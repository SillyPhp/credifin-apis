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

    public function actionUserResume($page, $limit = 20)
    {
        $offset = ($page - 1) * $limit;
        $getData = UserResume::find()
            ->select(['resume', 'resume_location'])
            ->where([
                'or',
                ['!=', 'resume', null],
                ['!=', 'resume', '']
            ])
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();

        if (empty($getData)) {
            print_r('done');
            die();
        }

        foreach ($getData as $get) {
            if (!empty($get['resume'])) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $resumeSourcePath = Yii::$app->params->upload_directories->resume->file_path . $get['resume_location'] . '/' . $get['resume'];
                if (file_exists($resumeSourcePath)) {
                    $result = $my_space->uploadFile($resumeSourcePath, Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->resume->file . $get['resume_location'] . '/' . $get['resume'], "private");
                }
            }
        }

        echo 'done';
    }

}
