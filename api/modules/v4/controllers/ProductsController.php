<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\ProductsForm;
use api\modules\v4\models\EnquiryForm;
use common\models\AssignedCategories;
use common\models\BrandModels;
use common\models\Brands;
use common\models\Categories;
use common\models\ProductEnquiry;
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

    // this action is used to add brands
    public function actionAddBrands()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // getting assigned_category_id
            $assigned_category_id = $this->getAssignedCategory($user->user_enc_id, $params['assigned_category'], $params['category']);

            // if assigned_category_id not found
            if (!$assigned_category_id) {
                return $this->response(500, ['status' => 500, 'message' => 'category not found']);
            }

            // starting transaction
            $transaction = Yii::$app->db->beginTransaction();
            try {

                // looping brands array
                foreach ($params['brands'] as $b) {

                    $brand = new Brands();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $brand->brand_enc_id = $utilitiesModel->encrypt();
                    $brand->assigned_category_enc_id = $assigned_category_id;

                    // if assigned category is Mobiles
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

                    // adding brand models if not empty
                    if (!empty($b['models'])) {

                        // looping models array
                        foreach ($b['models'] as $m) {

                            // adding models
                            $model = new BrandModels();
                            $utilitiesModel = new Utilities();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $model->model_enc_id = $utilitiesModel->encrypt();
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

                // commiting code
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

    // this action is used to add custom brand models
    public function actionAddModel()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // getting request data
            $params = Yii::$app->request->post();

            // checking brand_id
            if (empty($params['brand_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "brand_id"']);
            }

            // checking model
            if (empty($params['model'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "model"']);
            }

            // checking if model already exists
            $exists = BrandModels::findOne(['brand_enc_id' => $params['brand_id'], 'name' => $params['model'], 'is_deleted' => 0]);

            // if exists
            if ($exists) {
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved', 'model_id' => $exists->model_enc_id, 'model_name' => $exists->name]);
            }

            // adding model
            $model = new BrandModels();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->model_enc_id = $utilitiesModel->encrypt();
            $model->brand_enc_id = $params['brand_id'];
            $model->name = $params['model'];
            $model->created_by = $user->user_enc_id;
            if (!$model->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()]);
            }

            // if saved returning model_id and model_name
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved', 'model_id' => $model->model_enc_id, 'model_name' => $model->name]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting assigned category id
    private function getAssignedCategory($user_id, $assigned_category = 'Two Wheeler', $category = 'Vehicle')
    {
        // checking assigned_category_id
        $assigned_category_id = AssignedCategories::find()
            ->alias('a')
            ->select(['a.assigned_category_enc_id'])
            ->joinWith(['categoryEnc b'], false)
            ->andWhere(['b.name' => $assigned_category, 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        // if assigned category found returning its assigned_category_enc_id
        if ($assigned_category_id) {
            return $assigned_category_id['assigned_category_enc_id'];
        }

        // get parent_category_id
        $parent_category_id = $this->getCategory($category, $user_id);

        // if not found
        if (!$parent_category_id) {
            return false;
        }

        // getting category_id
        $category_id = $this->getCategory($assigned_category, $user_id);

        // adding data to assigned categories
        $assigned_category = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assigned_category->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assigned_category->category_enc_id = $category_id;
        $assigned_category->parent_enc_id = $parent_category_id;
        $assigned_category->assigned_to = 'Refurbish';
        $assigned_category->created_by = $user_id;
        if ($assigned_category->save()) {
            return $assigned_category->assigned_category_enc_id;
        }

        return false;
    }

    // getting category
    private function getCategory($category, $user_id)
    {
        // getting category_id
        $category_id = AssignedCategories::find()
            ->alias('a')
            ->select(['a.assigned_category_enc_id', 'b.category_enc_id'])
            ->joinWith(['categoryEnc b'], false)
            ->andWhere(['b.name' => $category, 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        // if exists then returning category_enc_id else adding new entry
        if ($category_id) {
            return $category_id['category_enc_id'];
        }

        // adding data
        $cat = new Categories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $cat->category_enc_id = $utilitiesModel->encrytp();
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

    // this action is used to get brands list
    public function actionGetBrands($type = 'Two Wheeler', $existing = '0')
    {
        // getting brands list
        $brands = Brands::find()
            ->alias('a')
            ->select(['a.brand_enc_id value', 'a.name label', 'a.brand_enc_id'])
            ->joinWith(['brandModels b' => function ($b) use ($existing) {
                $b->select(['b.model_enc_id', 'b.model_enc_id value', 'b.name label', 'b.brand_enc_id'])->onCondition(['b.is_deleted' => 0]);
                if ($existing == '1') {
                    $b->innerJoinWith(['products b1' => function ($b1) {
                        $b1->andWhere(['b1.is_deleted' => 0]);
                    }], false);
                }
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

        // if not found
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    // this action is used to add product
    public function actionAdd()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // creating products form object
            $model = new ProductsForm();

            // loading data to model
            if ($model->load(Yii::$app->request->post(), '')) {

                // getting images and dent_images instance
                $model->images = UploadedFile::getInstances($model, 'images');
                $model->dent_images = UploadedFile::getInstances($model, 'dent_images');

                // getting assigned_category
                $assigned_category = AssignedCategories::find()
                    ->alias('a')
                    ->select(['a.assigned_category_enc_id'])
                    ->joinWith(['categoryEnc b'], false)
                    ->andWhere(['b.name' => $model->assigned_category, 'a.is_deleted' => 0])
                    ->asArray()
                    ->one();

                // assigning assigned_category
                $model->assigned_category = $assigned_category['assigned_category_enc_id'];

                // validating model
                if ($model->validate()) {

                    // saving data
                    $product = $model->save($user->user_enc_id);

                    if ($product['status'] == 200) {
                        return $this->response(200, $product);
                    }

                    return $this->response(500, $product);
                } else {
                    // if error in model validation
                    return $this->response(422, ['status' => 422, 'error' => $model->getErrors()]);
                }
            }
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to update products
    public function actionUpdate()
    {
        // checking user authorization
        if ($user = $this->isAuthorized()) {

            // creating new object of products form
            $model = new ProductsForm();

            $params = Yii::$app->request->post();

            // checking product_enc_id
            if (empty($params['product_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "product_enc_id"']);
            }

            // loading data to model
            if ($model->load(Yii::$app->request->post(), '')) {

                // getting images and dent_images instance
                $model->images = UploadedFile::getInstances($model, 'images');
                $model->dent_images = UploadedFile::getInstances($model, 'dent_images');

                // validating model
                if ($model->validate()) {

                    // updating product
                    $product = $model->update($user->user_enc_id, $params['product_enc_id']);

                    if ($product['status'] == 200) {
                        return $this->response(200, $product);
                    }
                    return $this->response(500, $product);

                } else {
                    // if errors in data validation
                    return $this->response(422, ['status' => 422, 'error' => $model->getErrors()]);
                }
            }
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting products list for dealer
    public function actionGetProducts()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // getting request params
            $params = Yii::$app->request->post();

            $limit = !empty($params['limit']) ? $params['limit'] : 10;
            $page = !empty($params['page']) ? $params['page'] : 1;
            $category = !empty($params['category']) ? $params['category'] : 'Two Wheeler';

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

    // this action used to update product status
    public function actionUpdateProductStatus()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking product_enc_id
            if (empty($params['product_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "product_enc_id"']);
            }

            // checking status
            if (empty($params['status'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "status"']);
            }

            // getting product object with product_enc_id
            $product = Products::findOne(['product_enc_id' => $params['product_enc_id']]);

            // if not exists
            if (!$product) {
                return $this->response(404, ['status' => 404, 'message' => 'Product not Found']);
            }

            // updating data
            $product->status = $params['status'];
            $product->updated_on = date('Y-m-d H:i:s');
            $product->updated_by = $user->user_enc_id;
            if (!$product->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $product->getErrors()]);
            }
            return $this->response(200, ['status' => 200, 'message' => 'Status Updated']);
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    // getting product detail
    public function actionGetProductDetails()
    {
        // getting request data
        $params = Yii::$app->request->post();

        // checking slug
        if (empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "Slug"']);
        }

        // getting detail
        $details = Products::find()
            ->alias('a')
            ->select(['a.name', 'a.slug', 'a.price', 'a.description', 'a.product_enc_id', 'a.status', 'a.created_on',
                'c1.name city', 'c1.city_enc_id', 'c2.name state', 'm.name model', 'm.model_enc_id model_id', 'be.name brand', 'd1.name category'])
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
            ->where(['a.slug' => $params['slug'], 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        // if detail found
        if ($details) {

            $options = ['limit' => 3, 'page' => 1, 'category' => $details['category'], 'product_id' => $details['product_enc_id']];

            // getting similar products
            $similar_products = $this->__getProducts($options);

            // returning product detail and similar products
            return $this->response(200, ['status' => 200, 'products' => $details, 'similar_products' => $similar_products]);
        }

        // if not found
        return $this->response(404, ['status' => 404, 'message' => 'Not Found']);

    }

    // remove product image
    public function actionRemoveProductImage()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // getting request data
            $params = Yii::$app->request->post();

            // checking image_id
            if (empty($params['image_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "image_id"']);
            }

            // getting image object
            $productImage = ProductImages::findOne(['image_enc_id' => $params['image_id']]);

            // if image data not found
            if (!$productImage) {
                return $this->response(404, ['status' => 404, 'message' => 'Image Not Found']);
            }

            // removing image
            $productImage->is_deleted = 1;
            $productImage->updated_by = $user->user_enc_id;
            $productImage->updated_on = date('Y-m-d H:i:s');
            if (!$productImage->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $productImage->getErrors()]);
            }
            return $this->response(200, ['status' => 200, 'message' => 'Image Deleted Successfully']);
        }
    }

    // this action is used remove product
    public function actionRemoveProduct()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // getting request params
            $params = Yii::$app->request->post();

            // checking product_id exists
            if (empty($params['product_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "product_id"']);
            }

            // getting product object
            $product = Products::findOne(['product_enc_id' => $params['product_id'], 'dealer_enc_id' => $user->user_enc_id]);

            // product not found
            if (!$product) {
                return $this->response(404, ['status' => 404, 'message' => 'Product Not Found']);
            }

            // deleting product
            $product->is_deleted = 1;
            $product->updated_by = $user->user_enc_id;
            $product->updated_on = date('Y-m-d H:i:s');
            if (!$product->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $product->getErrors()]);
            }
            return $this->response(200, ['status' => 200, 'message' => 'Product Deleted Successfully']);
        }
    }

    // getting products list for customer
    public function actionAllProducts()
    {
        // getting request params
        $params = Yii::$app->request->post();

        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $category = !empty($params['category']) ? $params['category'] : 'Two Wheeler';

        $options = ['limit' => $limit, 'page' => $page, 'category' => $category];

        // setting filter if requested
        if (!empty($params['filter'])) {
            $options['filter'] = $params['filter'];
        }

        // setting search_keyword if requested
        if (!empty($params['search_keyword'])) {
            $options['search_keyword'] = $params['search_keyword'];
        }

        // getting products list
        $products = $this->__getProducts($options);

        if ($products) {
            return $this->response(200, ['status' => 200, 'products' => $products]);
        }

        // if products not found
        return $this->response(404, ['status' => 404, 'message' => 'Products Not Found']);
    }

    // getting products list
    private function __getProducts($options)
    {
        // getting products list
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

        // if product_id not empty then exclude this product from list
        if (!empty($options['product_id'])) {

            // excluding product
            $products->andWhere(['not', ['a.product_enc_id' => $options['product_id']]]);
            $products->orderBy(new Expression('rand()'));
        } else {
            // else order by sort_desc
            $products->orderBy(['a.created_on' => SORT_DESC]);
        }

        // filter keywords product name,model name, brand name
        if (!empty($options['search_keyword'])) {
            $products->andWhere([
                'or',
                ['like', 'a.name', $options['search_keyword']],
                ['like', 'm.name', $options['search_keyword']],
                ['like', 'be.name', $options['search_keyword']],
            ]);
        }

        // filtering products
        if (!empty($options['filter'])) {

            $params = $options['filter'];

            // filter for brand
            if (!empty($params['brand'])) {
                $products->andWhere(['be.name' => $params['brand']]);
            }

            // filter min_km_driven
            if (!empty($params['min_km_driven'])) {
                $products->andWhere(['>=', 'b.km_driven', $params['min_km_driven']]);
            }

            // filter max_km_driven
            if (!empty($params['max_km_driven'])) {
                $products->andWhere(['<=', 'b.km_driven', $params['max_km_driven']]);
            }

            // filter brand_name
            if (!empty($params['brand_name'])) {
                $products->andWhere(['in', 'be.name', $params['brand_name']]);
            }

            // filter making_year
            if (!empty($params['making_year'])) {
                $products->andWhere(['in', 'b.making_year', $params['making_year']]);
            }

            // filter budget_start_range
            if (!empty($params['budget_start_range'])) {
                $products->andWhere(['>=', 'a.price', $params['budget_start_range']]);
            }

            // filter budget_end_range
            if (!empty($params['budget_end_range'])) {
                $products->andWhere(['<=', 'a.price', $params['budget_end_range']]);
            }

            // filter status
            if (!empty($params['status'])) {
                $products->andWhere(['a.status' => $params['status']]);
            }
        }

        // returning products list
        return $products->groupBy('a.product_enc_id')
            ->orderBy(['a.status' => SORT_ASC, 'a.created_on' => SORT_DESC])
            ->limit($options['limit'])
            ->offset(($options['page'] - 1) * $options['limit'])
            ->asArray()
            ->all();
    }

    // this action provide data to filter products list
    public function actionProductFilterData()
    {
        // getting request params
        $params = Yii::$app->request->post();

        $category = !empty($params['category']) ? $params['category'] : 'Two Wheeler';

        // getting price and km driven filter data
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

        // getting years data
        $years = ProductOtherDetails::find()
            ->alias('a')
            ->select(['a.making_year'])
            ->joinWith(['productEnc b' => function ($b) {
                $b->joinWith(['assignedCategoryEnc dd' => function ($d) {
                    $d->joinWith(['categoryEnc dd1']);
                }], false);
            }])
            ->where(['b.is_deleted' => 0, 'dd1.name' => $category])
            ->andWhere(['not', ['a.making_year' => null]])
            ->groupBy(['a.making_year'])
            ->orderBy(['a.making_year' => SORT_ASC])
            ->asArray()
            ->all();

        // getting brands data
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

        $status = Products::find()
            ->distinct()
            ->select(['status'])
            ->where(['is_deleted' => 0])
            ->asArray()
            ->all();

        $filter['brands'] = $filter_brands;
        $filter['years'] = $years;
        $filter['status'] = $status;

        if ($category == 'Mobiles') {
            unset($filter['min_km_driven']);
            unset($filter['max_km_driven']);
        }

        return $this->response(200, ['status' => 200, 'filter' => $filter]);

    }

    // this action is used for product enquiry
    public function actionAddProductEnquiry()
    {
        // creating form object
        $model = new EnquiryForm();

        // loading data to model
        if ($model->load(Yii::$app->request->post(), '')) {

            // if user authorized then assign to created_by
            if ($user = $this->isAuthorized()) {
                $model->created_by = $user->user_enc_id;
            }

            // validating model
            if ($model->validate()) {

                // saving data
                $query = $model->create();

                if ($query['status'] == 500) {
                    return $this->response(500, $query);
                }
                return $this->response(200, $query);

            } else {
                // if validation error occurred
                return $this->response(422, ['status' => 422, 'error' => $model->getErrors()]);
            }
        }

        // if no data found in request params
        return $this->response(400, ['status' => 400, 'message' => 'bad request']);
    }

    // this action is used to update product enquiry
    public function actionUpdateProductEnquiry()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // creating form object
            $model = new EnquiryForm();

            // getting request params
            $params = Yii::$app->request->post();

            // checking enquiry_enc_id
            if (empty($params['enquiry_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "enquiry_enc_id"']);
            }

            // loading data to form
            if ($model->load(Yii::$app->request->post(), '')) {

                // validating model
                if ($model->validate()) {

                    // updating data
                    $query = $model->update($user->user_enc_id);

                    if ($query['status'] == 500) {
                        return $this->response(500, $query);
                    }
                    return $this->response(200, $query);

                } else {

                    // if validation error occurred
                    return $this->response(422, ['status' => 422, 'error' => $model->getErrors()]);
                }
            }

            // if request data is empty
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to show enquiries to dealer
    public function actionDealerViewProductEnquiry()
    {
        // check authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $limit = !empty($params['limit']) ? $params['limit'] : 10;
            $page = !empty($params['page']) ? $params['page'] : 1;

            // getting enquiries
            $enquiry = Products::find()
                ->alias('a')
                ->select(['a.name', 'a.price', 'a.product_enc_id'])
                ->joinWith(['productEnquiries b' => function ($b) {
                    $b->select(['b.product_id', 'b.first_name', 'b.last_name', 'b.email', 'b.mobile_number']);
                }])
                ->where(['not', ['b.status' => 'Closed']])
                ->andWhere(['a.dealer_enc_id' => $user->user_enc_id])
                ->groupBy(['a.product_enc_id'])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            if ($enquiry) {
                return $this->response(200, ['status' => 200, 'enquiry' => $enquiry]);
            }

            // if not found
            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to show enquiries to customer who make enquiry
    public function actionUserViewProductEnquiry()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $limit = !empty($params['limit']) ? $params['limit'] : 10;
            $page = !empty($params['page']) ? $params['page'] : 1;

            // getting enquiries
            $enquiry = Products::find()
                ->alias('a')
                ->select(['a.name', 'a.price', 'b.first_name', 'b.last_name', 'b.email', 'b.mobile_number'])
                ->joinWith(['productEnquiries b'], false)
                ->where(['not', ['b.status' => 'Closed']])
                ->andWhere(['b.created_by' => $user->user_enc_id])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            if ($enquiry) {
                return $this->response(200, ['status' => 200, 'enquiry' => $enquiry]);
            }

            // if data not found
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

}