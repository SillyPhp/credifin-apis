<?php

namespace api\modules\v4\controllers;

use common\models\OrganizationLocations;
use yii\web\UploadedFile;
use yii\db\Expression;
use common\models\Utilities;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\helpers\Url;
use yii\filters\ContentNegotiator;

class OrganizationsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'add-branch' => ['POST', 'OPTIONS'],
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

    public function actionAddBranch()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['location_name']) || empty($params['address']) || empty($params['city_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "location_name, address, city_id"']);
            }

            $orgLocations = new OrganizationLocations();
            $orgLocations->location_enc_id = Yii::$app->security->generateRandomString(32);
            $orgLocations->organization_enc_id = $user->organization_enc_id;
            $orgLocations->location_name = $params['location_name'];
            $orgLocations->location_for = json_encode(['1']);
            $orgLocations->address = $params['address'];
            $orgLocations->city_enc_id = $params['city_id'];
            $orgLocations->created_by = $user->user_enc_id;
            $orgLocations->created_on = date('Y-m-d H:i:s');
            if (!$orgLocations->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $orgLocations->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}