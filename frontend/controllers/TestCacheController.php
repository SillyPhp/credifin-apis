<?php
namespace frontend\controllers;
use common\models\Organizations;
use common\models\User;
use common\models\Users;
use yii\web\Controller;
use common\models\Utilities;

class TestCacheController extends Controller
{
    public function actionTestQuery()
    {
        $model = new \common\models\Referral();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->referral_enc_id = $utilitiesModel->encrypt();
        $model->organization_enc_id = Organizations::findOne(['slug'=>'dsbedutech'])->organization_enc_id;
        $model->code = 'Redbull50';
        $model->referral_link = 'Redbull50';
        $model->created_by = Users::findOne(['username'=>'admin'])->user_enc_id;
        $model->created_on = date('Y-m-d H:i:s');
        if ($model->save())
        {
            return true;
        }else{
            print_r($model->getErrors());
        }
    }
}