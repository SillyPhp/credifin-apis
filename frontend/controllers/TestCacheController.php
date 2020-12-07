<?php

namespace frontend\controllers;

use common\models\Auth;
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
}
