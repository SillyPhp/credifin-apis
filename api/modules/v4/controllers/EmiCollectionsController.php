<?php

namespace api\modules\v4\controllers;

use common\models\EmiCollection;
use common\models\WebhookTest;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;

class EmiCollectionsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-emi-phone' => ['POST', 'OPTIONS'],
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

    public function actionGetEmiPhone()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        if (!$params = Yii::$app->request->post()) {
            return $this->response(500, ['status' => 500, 'message' => 'params not found']);
        }

        $data = EmiCollection::find()
            ->select([
                'phone'
            ])
            ->andWhere([
                'and',
                ['between', 'collection_date', $params['start_date'], $params['end_date']],
                ['is_deleted' => 0],
                ['emi_payment_status' => 'pending'],
                ['emi_payment_method' => [6, 7]]
            ])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'data' => $data]);
    }

}