<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\FinancerRewardsForm;
use common\models\FinancerRewards;
use common\models\spaces\Spaces;
use common\models\FinancerRewardsOption;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use common\models\Utilities;
use yii\web\UploadedFile;
use Yii;

class FinancerRewardsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'add' => ['POST', 'OPTIONS'],
                'upload-icon' => ['POST', 'OPTIONS'],
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

    public function actionAddReward()
    {
        if ($user = $this->isAuthorized()) {

            $model = new FinancerRewardsForm();
            if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
                $model->image = UploadedFile::getInstanceByName('image');
                if ($model->validate()) {
                    $reward = $model->addReward($user);

                    if ($reward['status'] == 201) {
                        return $this->response(201, $reward);
                    } else {
                        return $this->response(500, $reward);
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

    public function actionUploadIcon()
    {
        if ($user = $this->isAuthorized()) {
            $icon_image = UploadedFile::getInstanceByName('icon_image');
            $icon = Yii::$app->getSecurity()->generateRandomString() . '.' .$icon_image->extension;
            $icon_location = Yii::$app->getSecurity()->generateRandomString() . '/';
            $base_path = Yii::$app->params->upload_directories->financer_rewards->icon . $icon_location . $icon;

            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($icon_image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path, "public", ['params' => ['contentType' => $icon_image]]);

            return $this->response(200, ['status' => 200, 'icon'    => $icon, 'icon_location' => $icon_location]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }

    }
}

?>