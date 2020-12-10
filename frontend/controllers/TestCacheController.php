<?php

namespace frontend\controllers;

use common\models\AppliedApplications;
use common\models\AssignedCategories;
use common\models\Auth;
use common\models\EmployerApplications;
use common\models\ErexxEmployerApplications;
use common\models\Organizations;
use common\models\spaces\Spaces;
use common\models\UnclaimedOrganizations;
use common\models\User;
use common\models\UserOtherDetails;
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
            //->andWhere(['organization_enc_id'=>'zpBn4vYx2RmK7WwnepbLdJg3Aq9Vyl'])
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();
        $i = 0;
        if ($data){
            foreach ($data as $d){
                $model = new \common\models\extended\EmployerApplications();
                $app = $model->_cloneApplication($d['application_enc_id'],2);
                if ($app){
                    $erexx = ErexxEmployerApplications::findAll(['employer_application_enc_id'=>$d['application_enc_id']]);
                    if ($erexx){
                        foreach ($erexx as $er){
                            $er->employer_application_enc_id = $app;
                            $er->save();
                        }
                    }
                    $applied = AppliedApplications::find()
                        ->alias('a')
                        ->select(['a.applied_application_enc_id'])
                        ->where(['application_enc_id'=>$d['application_enc_id']])
                        ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id = a.created_by')
                        ->innerJoin(UserOtherDetails::tableName() . 'as c', 'c.user_enc_id = b.user_enc_id')
                        ->asArray()->all();
                    if ($applied){
                        foreach ($applied as $a){
                            $apply = AppliedApplications::findOne(['applied_application_enc_id'=>$a['applied_application_enc_id']]);
                            if ($apply){
                                $apply->application_enc_id = $app;
                                $apply->save();
                            }
                        }
                    }
                    $i++;
                }
            }
            return $i;
        }else{
            return 'empty';
        }
    }
}
