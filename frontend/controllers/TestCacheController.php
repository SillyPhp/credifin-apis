<?php

namespace frontend\controllers;

use common\models\Auth;
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

    public function actionUnclaimedUpload($page, $limit = 20)
    {
        $offset = ($page - 1) * $limit;
        $getData = UnclaimedOrganizations::find()
            ->select(['logo', 'logo_location'])
            ->where([
                'or',
                ['!=', 'logo', null],
                ['!=', 'logo', '']
            ])
            ->andWhere(['>=', 'created_on', '2020-10-08'])
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();

        if (empty($getData)) {
            print_r('done');
            die();
        }

        foreach ($getData as $get) {
            if (!empty($get['logo'])) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $imageSourcePath = Yii::$app->params->upload_directories->unclaimed_organizations->logo_path . $get['logo_location'] . '/' . $get['logo'];
                $result = $my_space->uploadFile($imageSourcePath, "images/ey-logos/uncliamed-organizations/" . $get['logo_location'] . '/' . $get['logo'], "public");
            }
        }
    }

    public function actionClaimedUpload($page, $limit = 20)
    {
        $offset = ($page - 1) * $limit;
        $getData = Organizations::find()
            ->select(['logo', 'logo_location'])
            ->where([
                'or',
                ['!=', 'logo', null],
                ['!=', 'logo', '']
            ])
            ->andWhere(['>=', 'created_on', '2020-10-08'])
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();

        if (empty($getData)) {
            print_r('done');
            die();
        }

        foreach ($getData as $get) {
            if (!empty($get['logo'])) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $imageSourcePath = Yii::$app->params->upload_directories->organizations->logo_path . $get['logo_location'] . '/' . $get['logo'];
                $result = $my_space->uploadFile($imageSourcePath, "images/ey-logos/organizations/" . $get['logo_location'] . '/' . $get['logo'], "public");
            }
        }
        echo count($getData);
    }

    public function actionUserProfile($page, $limit = 20)
    {
        $offset = ($page - 1) * $limit;
        $getData = Users::find()
            ->select(['image', 'image_location'])
            ->where([
                'or',
                ['!=', 'image', null],
                ['!=', 'image', '']
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
            if (!empty($get['image'])) {
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $imageSourcePath = Yii::$app->params->upload_directories->users->image_path . $get['image_location'] . '/' . $get['image'];
                $result = $my_space->uploadFile($imageSourcePath, Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $get['image_location'] . '/' . $get['image'], "public");
            }
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
            ->andWhere(['created_by'=>'zroPWqDpjZxLp0KL0EvqZJnYE3wX6x'])
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
                $result = $my_space->uploadFile($resumeSourcePath, Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->resume->file . $get['resume_location'] . '/' . $get['resume'], "private");
            }
        }

    }
}
