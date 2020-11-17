<?php

namespace api\modules\v3\controllers;

use common\models\extended\PaymentsModule;
use Yii;
use api\modules\v3\models\TokensModel;
use yii\filters\VerbFilter;

class PaymentRequestController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'request-pay' => ['POST'],
            ]
        ];
        return $behaviors;
    }
    public function actionRequestPay()
    {
        if(Yii::$app->request->post()){
            $get = PaymentsModule::_authPayToken(Yii::$app->request->post());
            if ($get['status']==='created'):
                return $this->response(200, ['status' => 200, 'data'=>$get]);
            else:
                return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
            endif;
        }
    }
}