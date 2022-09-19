<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\Apps;
use common\models\AssignedSupervisor;
use common\models\OrganizationAppFields;
use common\models\OrganizationApps;
use common\models\Referral;
use common\models\ReferralSignUpTracking;
use common\models\SelectedServices;
use common\models\spaces\Spaces;
use common\models\User;
use common\models\Users;
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
                'list' => ['POST', 'OPTIONS'],
                'detail' => ['POST', 'OPTIONS'],
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

    public function actionList()
    {
        if ($user = $this->isAuthorized()) {

            if ($user->organization_enc_id) {

                $params = Yii::$app->request->post();

                $limit = 10;
                $page = 1;

                if (!empty($params['limit'])) {
                    $limit = $params['limit'];
                }

                if (!empty($params['page'])) {
                    $page = $params['page'];
                }

                $list = OrganizationApps::find()
                    ->select(['app_enc_id', 'app_name', 'app_description', 'assigned_to', 'created_on'])
                    ->where(['organization_enc_id' => $user->organization_enc_id, 'is_deleted' => 0])
                    ->limit($limit)
                    ->offset(($page - 1) * $limit)
                    ->asArray()
                    ->all();

                if ($list) {

                    foreach ($list as $key => $val) {
                        $list[$key]['logo'] = $this->getFile($val['app_enc_id']);
                        $list[$key]['assigned_to'] = json_decode($val['assigned_to']);
                        $list[$key]['elements_count'] = OrganizationAppFields::find()->where(['app_enc_id' => $val['app_enc_id'], 'is_deleted' => 0])->count();
                    }

                    return $this->response(200, ['status' => 200, 'list' => $list]);
                }
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            } else {
                return $this->response(403, ['status' => 403, 'message' => 'must be organization login']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function getFile($app_id)
    {
        $file = OrganizationApps::findOne(['app_enc_id' => $app_id]);
        $path = Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->form_apps->logo . $file->app_icon_location . $file->app_icon;
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        return $my_space->signedURL($path, "15 minutes");
    }

    public function actionDetail()
    {
        $params = Yii::$app->request->post();

        if (empty($params['app_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing parameter "app_id"']);
        }

        $app = OrganizationApps::findOne(['app_enc_id' => $params['app_id']]);

        if (!$app) {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

        if ($this->authorize($params['app_id'])) {

            $detail = OrganizationApps::find()
                ->alias('a')
                ->select(['a.app_enc_id', 'a.app_name', 'a.app_description', 'a.assigned_to'])
                ->joinWith(['organizationAppFields b' => function ($b) {
                    $b->select(['b.field_enc_id', 'b.app_enc_id', 'b.field_title', 'b.field_description', 'b.field_value', 'b.field_type',
                        'b.link', 'b.sequence']);
                }])
                ->where(['a.app_enc_id' => $params['app_id'], 'a.is_deleted' => 0, 'b.is_deleted' => 0])
                ->asArray()
                ->one();

            if ($detail) {
                $detail['logo'] = $this->getFile($params['app_id']);
                $detail['assigned_to'] = json_decode($detail['assigned_to']);
                return $this->response(200, ['status' => 200, 'detail' => $detail]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function authorize($app_id)
    {
        if ($user = $this->isAuthorized()) {

            $app = OrganizationApps::findOne(['app_enc_id' => $app_id]);

            $assigned_to = json_decode($app->assigned_to);

            if ($assigned_to && array_search('DSA', $assigned_to)) {
                $assigned_to[] = 'E-Partners';
            }

            // checking by organization id
            if ($user->organization_enc_id && ($user->organization_enc_id == $app->organization_enc_id)) {
                return true;
            }

            // checking for employee authorization
            $ref_enc_id = ReferralSignUpTracking::findOne(['sign_up_user_enc_id' => $user->user_enc_id])->referral_enc_id;

            if ($ref_enc_id) {

                $org_id = Referral::findOne(['referral_enc_id' => $ref_enc_id])->organization_enc_id;

                if ($org_id && ($org_id == $app->organization_enc_id)) {
                    return true;
                }
            }


            $service = SelectedServices::find()
                ->alias('a')
                ->select(['a.selected_service_enc_id', 'b.name', 'a.assigned_user', 'a.created_by'])
                ->joinWith(['serviceEnc b'], false)
                ->where(['a.is_selected' => 1, 'b.name' => $assigned_to]);
            if ($user->organization_enc_id) {
                $service->andWhere(['or', ['a.organization_enc_id' => $user->organization_enc_id]]);
            } else {
                $service->andWhere(['or', ['a.created_by' => $user->user_enc_id]]);
            }

            $service = $service->asArray()
                ->one();

            // checking for DSA
            if ($service['name'] == 'E-Partners') {
                $supervisor_id = AssignedSupervisor::findOne(['assigned_user_enc_id' => $service['created_by']])->supervisor_enc_id;
                if ($supervisor_id && (Users::findOne(['user_enc_id' => $supervisor_id])->organization_enc_id == $app->organization_enc_id)) {
                    return true;
                }
            }

            // checking for Connector
            if ($service['name'] == 'Connector') {
                $org_id = Users::findOne(['user_enc_id' => $service['assigned_user']])->organization_enc_id;
                if ($org_id == $app->organization_enc_id) {
                    return true;
                } else {
                    $supervisor_id = AssignedSupervisor::findOne(['assigned_user_enc_id' => $service['assigned_user']])->supervisor_enc_id;
                    if ($supervisor_id && (Users::findOne(['user_enc_id' => $supervisor_id])->organization_enc_id == $app->organization_enc_id)) {
                        return true;
                    }
                }
            }

            return false;
        }

        return false;
    }
}