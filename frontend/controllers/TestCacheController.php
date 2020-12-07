<?php

namespace frontend\controllers;

use common\models\Auth;
use common\models\EmployerApplications;
use common\models\Organizations;
use common\models\spaces\Spaces;
use common\models\UnclaimedOrganizations;
use common\models\UserResume;
use common\models\Users;
use yii\web\Controller;
use Yii;

class TestCacheController extends Controller
{
    public function actionTest()
    {
        try {
            $model = new Auth();
            $model->user_id = 12;
            if (!$model->save()) //model errors
            {
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)));
            }

            //some kind of err
        } catch (\Exception $exception) {
            return $exception->getMessage(); //final messege for user
        }
    }

    public function actionMove($limit=10,$page=1){
        $offset = ($page - 1) * $limit;
        $data = EmployerApplications::find()
            ->select(['application_enc_id','application_for'])
            ->where(['application_for'=>0])
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();
        $i = 0;
        if ($data){
            foreach ($data as $d){
                $model = new \common\models\extended\EmployerApplications();
                $app = $model->_cloneApplication($data['applications'],2);
                if ($app){
                    $i++;
                }
            }
            return $i;
        }else{
            return 'empty';
        }
    }
}
