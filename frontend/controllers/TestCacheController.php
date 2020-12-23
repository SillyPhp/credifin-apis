<?php

namespace frontend\controllers;

use common\models\AppliedApplicationProcess;
use common\models\AppliedApplications;
use common\models\Auth;
use common\models\EmployerApplications;
use common\models\InterviewProcessFields;
use common\models\UserResume;
use common\models\Utilities;
use yii\helpers\Url;
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

    public function actionResume($page, $limit = 20)
    {
        $offset = ($page - 1) * $limit;
        $resumes = UserResume::find()
            ->select(['resume_enc_id', 'resume', 'resume_location'])
            ->where([
                'or',
                ['!=', 'resume', null],
                ['!=', 'resume', '']
            ])
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();

        if ($resumes) {
            foreach ($resumes as $v) {
                $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $cv = $my_space->signedURL(Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->resume->file . $v['resume_location'] . DIRECTORY_SEPARATOR . $v['resume'], "15 minutes");
                $remoteFile = $cv;

                $handle = @fopen($remoteFile, 'r');

                if (!$handle) {
//                    $res = UserResume::find()
//                        ->where(['resume_enc_id' => $v['resume_enc_id']])
//                        ->one();
//                    $res->resume = null;
//                    $res->resume_location = null;
//                    if (!$res->update()) {
//                        print_r($res->getErrors());
//                        die();
//                    }
                    $applied_resume = AppliedApplications::find()
                        ->where(['resume_enc_id' => $v['resume_enc_id']])
                        ->one();
                    $applied_resume->resume_enc_id = null;
                    if(!$applied_resume->update()){
                        print_r($applied_resume->getErrors());
                        die();
                    }
                }
            }
        } else {
            print_r('done');
            die();
        }
        print_r('updated');
    }
}
