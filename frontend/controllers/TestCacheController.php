<?php

namespace frontend\controllers;

use common\models\AppliedApplications;
use common\models\Auth;
use common\models\Posts;
use common\models\SkillsUpPostAssignedBlogs;
use common\models\Users;
use common\models\RandomColors;
use common\models\Utilities;
use common\models\Webinar;
use common\models\WebinarRegistrations;
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

    public function actionEmail()
    {
        $params = AppliedApplications::find()
            ->alias('a')
            ->select(['CONCAT(b.first_name," ",b.last_name) name', 'b.email', 'a.applied_application_enc_id applied_id'])
            ->where(['application_enc_id' => '2DeBxPEjOGdjkjgnV3beQpqANyVYw9'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id = a.created_by')
            ->asArray()
            ->one();
        $params['subject'] = 'Your Application has been selected';
        Yii::$app->notificationEmails->candidateProcessNotification($params);
    }

    public function actionJava()
    {
        $this->layout = 'widget-layout';
        return $this->render('pdf');
    }

    public function actionRecentUserRegis($id)
    {
        $users = Users::find()
            ->where(['signed_up_through' => 'ECAMPUS', 'is_deleted' => 0])
            ->andWhere(['between', 'created_on', "2021-10-02", "2021-10-08"])
            ->asArray()
            ->all();

        if ($users) {
            foreach ($users as $u) {
                $registered = WebinarRegistrations::findOne(['created_by' => $u['user_enc_id']]);
                if (!$registered) {
                    $webinar_id = Webinar::findOne(['webinar_enc_id' => $id])->webinar_enc_id;
                    $model = new WebinarRegistrations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $model->register_enc_id = $utilitiesModel->encrypt();
                    $model->webinar_enc_id = $webinar_id;
                    $model->status = 1;
                    $model->created_by = $u['user_enc_id'];
                    $model->created_on = date('Y-m-d H:i:s');
                    if (!$model->save()) {
                        print_r($model->getErrors());
                    }
                }
            }
        }

        print_r('done');
        die();
    }

    public function actionModule(){
       return Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory .DIRECTORY_SEPARATOR. Yii::$app->params->upload_directories->webinars->banners->image;
    }
}
