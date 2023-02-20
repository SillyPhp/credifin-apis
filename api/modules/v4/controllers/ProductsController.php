<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\ProductsForm;
use common\models\AssignedCategories;
use common\models\BrandModels;
use common\models\Brands;
use common\models\Categories;
use common\models\ProductImages;
use common\models\ProductOtherDetails;
use common\models\Products;
use yii\web\UploadedFile;
use yii\db\Expression;
use common\models\Utilities;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\helpers\Url;
use yii\filters\ContentNegotiator;

class ProductsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'add-brands' => ['POST', 'OPTIONS'],
                'get-brands' => ['GET', 'OPTIONS'],
                'get-products' => ['POST', 'OPTIONS'],
                'get-product-details' => ['POST', 'OPTIONS'],
                'remove-product-image' => ['POST', 'OPTIONS'],
                'remove-product' => ['POST', 'OPTIONS'],
                'all-products' => ['POST', 'OPTIONS'],
                'add-model' => ['POST', 'OPTIONS']
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        return $behaviors;
    }

    public function actionAddBrands()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            $assigned_category_id = $this->getAssignedCategory($user->user_enc_id, $params['assigned_category'], $params['category']);

            if (!$assigned_category_id) {
                return $this->response(500, ['status' => 500, 'message' => 'category not found']);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {

                foreach ($params['brands'] as $b) {
                    $brand = new Brands();
                    $brand->brand_enc_id = Yii::$app->security->generateRandomString(32);
                    $brand->assigned_category_enc_id = $assigned_category_id;
                    if ($params['assigned_category'] == 'Mobiles') {
                        $brand->name = $b;
                    } else {
                        $brand->name = $b['name'];
                    }
                    $brand->created_by = $user->user_enc_id;
                    if (!$brand->save()) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $brand->getErrors()]);
                    }

                    if (!empty($b['models'])) {
                        foreach ($b['models'] as $m) {
                            $model = new BrandModels();
                            $model->model_enc_id = Yii::$app->security->generateRandomString(32);
                            $model->brand_enc_id = $brand->brand_enc_id;
                            $model->name = $m['name'];
                            $model->created_by = $user->user_enc_id;
                            if (!$model->save()) {
                                $transaction->rollBack();
                                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()]);
                            }
                        }
                    }
                }

                $transaction->commit();

                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

            } catch (\Exception $exception) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddModel()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['brand_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "brand_id"']);
            }

            if (empty($params['model'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "model"']);
            }

            $exists = BrandModels::findOne(['brand_enc_id' => $params['brand_id'], 'name' => $params['name'], 'is_deleted' => 0]);

            if ($exists) {
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved', 'model_id' => $exists->model_enc_id, 'model_name' => $exists->name]);
            }

            $model = new BrandModels();
            $model->model_enc_id = Yii::$app->security->generateRandomString(32);
            $model->brand_enc_id = $params['brand_id'];
            $model->name = $params['model'];
            $model->created_by = $user->user_enc_id;
            if (!$model->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved', 'model_id' => $model->model_enc_id, 'model_name' => $model->name]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function getAssignedCategory($user_id, $assigned_category = 'Two Wheeler', $category = 'Vehicle')
    {
        $assigned_category_id = AssignedCategories::find()
            ->alias('a')
            ->select(['a.assigned_category_enc_id'])
            ->joinWith(['categoryEnc b'], false)
            ->andWhere(['b.name' => $assigned_category, 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if ($assigned_category_id) {
            return $assigned_category_id['assigned_category_enc_id'];
        }

        $parent_category_id = $this->getCategory($category, $user_id);

        if (!$parent_category_id) {
            return false;
        }

        $category_id = $this->getCategory($assigned_category, $user_id);

        $assigned_category = new AssignedCategories();
        $assigned_category->assigned_category_enc_id = Yii::$app->security->generateRandomString(32);
        $assigned_category->category_enc_id = $category_id;
        $assigned_category->parent_enc_id = $parent_category_id;
        $assigned_category->assigned_to = 'Refurbish';
        $assigned_category->created_by = $user_id;
        if ($assigned_category->save()) {
            return $assigned_category->assigned_category_enc_id;
        }

        return false;
    }

    private function getCategory($category, $user_id)
    {
        $category_id = AssignedCategories::find()
            ->alias('a')
            ->select(['a.assigned_category_enc_id', 'b.category_enc_id'])
            ->joinWith(['categoryEnc b'], false)
            ->andWhere(['b.name' => $category, 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if ($category_id) {
            return $category_id['category_enc_id'];
        }

        $cat = new Categories();
        $cat->category_enc_id = Yii::$app->security->generateRandomString(32);
        $cat->name = $category;
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['name'] = $category;
        $utilitiesModel->variables['table_name'] = Categories::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $cat->slug = $utilitiesModel->create_slug();
        $cat->source = 0;
        $cat->created_by = $user_id;
        if ($cat->save()) {
            return $cat->category_enc_id;
        }

        return false;
    }

    public function actionGetBrands($type = 'Two Wheeler')
    {
        if ($user = $this->isAuthorized()) {

            $brands = Brands::find()
                ->alias('a')
                ->select(['a.brand_enc_id value', 'a.name label', 'a.brand_enc_id'])
                ->joinWith(['brandModels b' => function ($b) {
                    $b->select(['b.model_enc_id', 'b.model_enc_id value', 'b.name label', 'b.brand_enc_id'])->onCondition(['b.is_deleted' => 0]);
                }])
                ->joinWith(['assignedCategoryEnc c' => function ($c) {
                    $c->joinWith(['categoryEnc c1']);
                }], false)
                ->andWhere(['a.is_deleted' => 0, 'c1.name' => $type])
                ->groupBy(['a.name'])
                ->asArray()
                ->all();

            if ($brands) {
                return $this->response(200, ['status' => 200, 'brands' => $brands]);
            }
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    public function actionAdd()
    {
        if ($user = $this->isAuthorized()) {
            $model = new ProductsForm();

            if ($model->load(Yii::$app->request->post(), '')) {

                $model->images = UploadedFile::getInstances($model, 'images');
                $model->dent_images = UploadedFile::getInstances($model, 'dent_images');

                $assigned_category = AssignedCategories::find()
                    ->alias('a')
                    ->select(['a.assigned_category_enc_id'])
                    ->joinWith(['categoryEnc b'], false)
                    ->andWhere(['b.name' => $model->assigned_category, 'a.is_deleted' => 0])
                    ->asArray()
                    ->one();

                $model->assigned_category = $assigned_category['assigned_category_enc_id'];

                if ($model->validate()) {
                    $product = $model->save($user->user_enc_id);
                    if ($product['status'] == 500) {
                        return $this->response(500, $product);
                    }
                    return $this->response(200, $product);
                } else {
                    return $this->response(422, ['status' => 422, 'error' => $model->getErrors()]);
                }
            }
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdate()
    {
        if ($user = $this->isAuthorized()) {
            $model = new ProductsForm();
            $identity = $user->user_enc_id;
            $params = Yii::$app->request->post();
            $model->images = UploadedFile::getInstances($model, 'images');
            if (empty($params['product_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "product_enc_id"']);
            }
            if ($model->load(Yii::$app->request->post(), '')) {
                if ($model->validate()) {
                    $product = $model->update($identity);
                    if ($product['status'] == 500) {
                        return $this->response(500, $product);
                    }
                    return $this->response(200, $product);
                } else {
                    return $this->response(422, ['status' => 422, 'error' => $model->getErrors()]);
                }
            }
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetProducts()
    {

        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();
            $limit = 10;
            $page = 1;
            $category = 'Two Wheeler';

            if (isset($params['limit']) && !empty($params['limit'])) {
                $limit = $params['limit'];
            }

            if (isset($params['page']) && !empty($params['page'])) {
                $page = $params['page'];
            }

            if (isset($params['category']) && !empty($params['category'])) {
                $category = $params['category'];
            }

            $products = Products::find()
                ->alias('a')
                ->select(['a.name', 'a.slug', 'a.price', 'a.description', 'a.product_enc_id', 'a.status', 'a.created_on'])
                ->joinWith(['productOtherDetails b' => function ($b) {
                    $b->select(['b.product_other_detail_enc_id', 'b.product_enc_id', 'b.other_detail']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->joinWith(['productImages c' => function ($c) {
                    $c->select(['c.product_enc_id', 'c.alt', 'c.type',
                        'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->refurbished->image, 'https') . '", c.image_location, "/", c.image) END image_link']);
                }])
                ->joinWith(['assignedCategoryEnc d' => function ($d) {
                    $d->joinWith(['categoryEnc d1']);
                }], false)
                ->where(['a.dealer_enc_id' => $user->user_enc_id, 'a.is_deleted' => 0])
                ->andWhere(['d1.name' => $category])
                ->groupBy('a.product_enc_id')
                ->orderBy(['a.created_on' => SORT_DESC])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            if ($products) {
                return $this->response(200, ['status' => 200, 'products' => $products]);
            }
            return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    public function actionGetProductDetails()
    {
        $params = Yii::$app->request->post();
        if (empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "Slug"']);
        }
        $slug = $params['slug'];

        $details = Products::find()
            ->alias('a')
            ->select(['a.name', 'a.slug', 'a.price', 'a.description', 'a.product_enc_id', 'a.status', 'a.created_on',
                'c1.name city', 'c2.name state', 'm.name model', 'be.name brand', 'd1.name category'])
            ->joinWith(['productOtherDetails b' => function ($b) {
                $b->select(['b.product_other_detail_enc_id', 'b.product_enc_id', 'b.km_driven', 'b.making_year', 'b.other_detail', 'b.ownership_type', 'b.variant', 'b.rom', 'b.ram', 'b.screen_size',
                    'b.back_camera', 'b.front_camera', 'b.sim_type']);
                $b->onCondition(['b.is_deleted' => 0]);
            }])
            ->joinWith(['productImages c' => function ($c) {
                $c->select(['c.product_enc_id', 'c.alt', 'c.type', 'c.image_enc_id',
                    'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->refurbished->image, 'https') . '", c.image_location, "/", c.image) END image_link']);
            }])
            ->joinWith(['cityEnc c1' => function ($c1) {
                $c1->joinWith(['stateEnc c2']);
            }], false)
            ->joinWith(['modelEnc m' => function ($m) {
                $m->joinWith(['brandEnc be']);
            }], false)
            ->joinWith(['assignedCategoryEnc d' => function ($d) {
                $d->joinWith(['categoryEnc d1']);
            }], false)
            ->where(['a.slug' => $slug, 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if ($details) {

            $options = [];
            $options['limit'] = 3;
            $options['page'] = 1;
            $options['category'] = $details['category'];
            $options['product_id'] = $details['product_enc_id'];

            $similar_products = $this->__getProducts($options);

            return $this->response(200, ['status' => 200, 'products' => $details, 'similar_products' => $similar_products]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'Not Found']);

    }

    public function actionRemoveProductImage()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (empty($params['image_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "image_id"']);
            }

            $productImage = ProductImages::findOne(['image_enc_id' => $params['image_id']]);
            if (!$productImage) {
                return $this->response(404, ['status' => 404, 'message' => 'Image Not Found']);
            }

            $productImage->is_deleted = 1;
            $productImage->updated_by = $user->user_enc_id;
            $productImage->updated_on = date('Y-m-d H:i:s');
            if (!$productImage->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred']);
            }
            return $this->response(200, ['status' => 200, 'message' => 'Image Deleted Successfully']);
        }
    }

    public function actionRemoveProduct()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['product_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "product_id"']);
            }

            $product = Products::findOne(['product_enc_id' => $params['product_id'], 'dealer_enc_id' => $user->user_enc_id]);
            if (!$product) {
                return $this->response(404, ['status' => 404, 'message' => 'Product Not Found']);
            }
            $product->is_deleted = 1;
            $product->updated_by = $user->user_enc_id;
            $product->updated_on = date('Y-m-d H:i:s');
            if (!$product->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred']);
            }
            return $this->response(200, ['status' => 200, 'message' => 'Product Deleted Successfully']);
        }
    }

    public function actionAllProducts()
    {

        $params = Yii::$app->request->post();
        $limit = 10;
        $page = 1;
        $category = 'Two Wheeler';
        $filter = '';

        if (isset($params['limit']) && !empty($params['limit'])) {
            $limit = $params['limit'];
        }

        if (isset($params['page']) && !empty($params['page'])) {
            $page = $params['page'];
        }

        if (isset($params['category']) && !empty($params['category'])) {
            $category = $params['category'];
        }

        if (isset($params['filter']) && !empty($params['filter'])) {
            $filter = $params['filter'];
        }

        $options = [];
        $options['limit'] = $limit;
        $options['page'] = $page;
        $options['category'] = $category;
        $options['filter'] = $filter;

        if (!empty($params['search_keyword'])) {
            $options['search_keyword'] = $params['search_keyword'];
        }

        $products = $this->__getProducts($options);


        if ($products) {
            return $this->response(200, ['status' => 200, 'products' => $products]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'Product Not Found']);
    }

    private function __getProducts($options)
    {
        $products = Products::find()
            ->alias('a')
            ->select(['a.name', 'a.slug', 'a.price', 'a.description', 'a.product_enc_id', 'a.status', 'a.created_on',
                'c1.name city', 'c2.name state', 'm.name model', 'be.name brand', 'CONCAT(d.first_name, " ", d.last_name) dealer_name'])
            ->joinWith(['productOtherDetails b' => function ($b) {
                $b->select(['b.product_other_detail_enc_id', 'b.product_enc_id', 'b.other_detail', 'b.rom', 'b.ram', 'b.making_year', 'b.km_driven']);
                $b->onCondition(['b.is_deleted' => 0]);
            }])
            ->joinWith(['productImages c' => function ($c) {
                $c->select(['c.product_enc_id', 'c.alt', 'c.type',
                    'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->refurbished->image, 'https') . '", c.image_location, "/", c.image) END image_link']);
            }])
            ->joinWith(['cityEnc c1' => function ($c1) {
                $c1->joinWith(['stateEnc c2']);
            }], false)
            ->joinWith(['modelEnc m' => function ($m) {
                $m->joinWith(['brandEnc be']);
            }], false)
            ->joinWith(['dealerEnc d'], false)
            ->joinWith(['assignedCategoryEnc dd' => function ($d) {
                $d->joinWith(['categoryEnc dd1']);
            }], false)
            ->where(['a.is_deleted' => 0, 'dd1.name' => $options['category']]);
        if (isset($options['product_id']) && !empty($options['product_id'])) {
            $products->andWhere(['not', ['a.product_enc_id' => $options['product_id']]]);
            $products->orderBy(new Expression('rand()'));
        } else {
            $products->orderBy(['a.created_on' => SORT_DESC]);
        }

        if (isset($options['search_keyword']) && !empty($options['search_keyword'])) {
            $products->andWhere([
                'or',
                ['like', 'a.name', $options['search_keyword']],
                ['like', 'm.name', $options['search_keyword']],
                ['like', 'be.name', $options['search_keyword']],
            ]);
        }

        if (!empty($options['filter'])) {
            $params = $options['filter'];
            if (isset($params['brand']) && !empty($params['brand'])) {
                $products->andWhere(['be.name' => $params['brand']]);
            }
            if (isset($params['min_km_driven']) && !empty($params['min_km_driven'])) {
                $products->andWhere(['>=', 'b.km_driven', $params['min_km_driven']]);
            }
            if (isset($params['max_km_driven']) && !empty($params['max_km_driven'])) {
                $products->andWhere(['<=', 'b.km_driven', $params['max_km_driven']]);
            }
            if (isset($params['brand_name']) && !empty($params['brand_name'])) {
                $products->andWhere(['in', 'be.name', $params['brand_name']]);
            }
            if (isset($params['making_year']) && !empty($params['making_year'])) {
                $products->andWhere(['in', 'b.making_year', $params['making_year']]);
            }
            if (isset($params['budget_start_range']) && !empty($params['budget_start_range'])) {
                $products->andWhere(['>=', 'a.price', $params['budget_start_range']]);
            }
            if (isset($params['budget_end_range']) && !empty($params['budget_end_range'])) {
                $products->andWhere(['<=', 'a.price', $params['budget_end_range']]);
            }
        }
        $products = $products->groupBy('a.product_enc_id')
            ->limit($options['limit'])
            ->offset(($options['page'] - 1) * $options['limit'])
            ->asArray()
            ->all();
        return $products;
    }

    public function actionProductFilterData()
    {
        $params = Yii::$app->request->post();
        $category = 'Two Wheeler';
        if (isset($params['category']) && !empty($params['category'])) {
            $category = $params['category'];
        }
        $filter = Products::find()
            ->alias('a')
            ->select([
                'min(a.price) min_price',
                'max(a.price) max_price',
                'min(b.km_driven) min_km_driven',
                'max(b.km_driven) max_km_driven'])
            ->joinWith(['productOtherDetails b'], false)
            ->joinWith(['assignedCategoryEnc dd' => function ($d) {
                $d->joinWith(['categoryEnc dd1']);
            }], false)
            ->where(['a.is_deleted' => 0, 'dd1.name' => $category])
            ->asArray()
            ->one();

        $years = ProductOtherDetails::find()
            ->alias('a')
            ->select(['a.making_year'])
            ->joinWith(['productEnc b' => function ($b) {
                $b->joinWith(['assignedCategoryEnc dd' => function ($d) {
                    $d->joinWith(['categoryEnc dd1']);
                }], false);
            }])
            ->where(['b.is_deleted' => 0, 'dd1.name' => $category])
            ->groupBy(['a.making_year'])
            ->orderBy(['a.making_year' => SORT_ASC])
            ->asArray()
            ->all();

        $filter_brands = Brands::find()
            ->alias('a')
            ->select(['a.name'])
            ->joinWith(['brandModels b' => function ($b) {
                $b->innerJoinWith(['products p' => function ($p) {
                    $p->joinWith(['assignedCategoryEnc dd' => function ($d) {
                        $d->joinWith(['categoryEnc dd1']);
                    }], false);
                }]);
            }], false)
            ->where(['dd1.name' => $category, 'p.is_deleted' => 0])
            ->distinct()
            ->asArray()
            ->all();

        $filter['brands'] = $filter_brands;
        $filter['years'] = $years;

        if ($category == 'Mobiles') {
            unset($filter['min_km_driven']);
            unset($filter['max_km_driven']);
        }

        return $this->response(200, ['status' => 200, 'filter' => $filter]);

    }

    public function actionUpdateProduct()
    {
        if ($user = $this->isAuthorized()) {

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}