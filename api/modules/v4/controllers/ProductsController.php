<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\Products;
use common\models\AssignedCategories;
use common\models\BrandModels;
use common\models\Brands;
use common\models\Categories;
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
                'get-brands' => ['GET', 'OPTIONS']
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
                    $brand->name = $b['name'];
                    $brand->created_by = $user->user_enc_id;
                    if (!$brand->save()) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $brand->getErrors()]);
                    }

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

    public function actionGetBrands()
    {
        if ($user = $this->isAuthorized()) {
            $brands = Brands::find()
                ->alias('a')
                ->select(['a.brand_enc_id value', 'a.name label', 'a.brand_enc_id'])
                ->innerJoinWith(['brandModels b' => function ($b) {
                    $b->select(['b.model_enc_id', 'b.model_enc_id value', 'b.name label', 'b.brand_enc_id'])->onCondition(['b.is_deleted' => 0]);
                }])
                ->andWhere(['a.is_deleted' => 0])
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
            $model = new Products();

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
                    if (!$model->save($user->user_enc_id)) {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                    return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
                } else {
                    return $this->response(422, ['status' => 422, 'error' => $model->getErrors()]);
                }
            }
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

}