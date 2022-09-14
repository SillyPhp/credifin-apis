<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\Apps;
use common\models\OrganizationApps;
use common\models\spaces\Spaces;
use common\models\Utilities;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use Razorpay\Api\Api;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;

class OrganizationAppsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'add' => ['POST', 'OPTIONS'],
                'get-file' => ['POST', 'OPTIONS'],
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

    public function actionAdd()
    {
        if ($user = $this->isAuthorized()) {

            $model = new Apps();
            if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {

                $model->logo = UploadedFile::getInstanceByName('logo');

                if ($model->validate()) {

                    if ($model->add($user)) {
                        return $this->response(201, ['status' => 201, 'message' => 'successfully saved']);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'Some Internal Server Error']);
                    }
                } else {
                    return $this->response(422, ['status' => 422, 'message' => 'missing information', 'error' => $model->getErrors()]);
                }

            } else {
                return $this->response(400, ['status' => 400, 'message' => 'bad request']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetFile()
    {

        $file = OrganizationApps::findOne(['app_enc_id' => 'PC9rS9YrHgo9pegU5WCnlJawyjFAnwad']);
        $path = Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->form_apps->logo . $file->app_icon_location . $file->app_icon;
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $url = $my_space->signedURL($path, "15 minutes");

        print_r($url);
        die();
    }
}