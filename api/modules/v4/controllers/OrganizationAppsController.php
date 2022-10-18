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
use common\models\UserTypes;
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
                'update' => ['POST', 'OPTIONS'],
                'remove-element' => ['POST', 'OPTIONS'],
                'remove-app' => ['POST', 'OPTIONS'],
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
                    $b->select(['b.field_enc_id', 'b.app_enc_id', 'b.field_title name', 'b.field_description', 'b.field_value', 'b.field_type',
                        'b.link', 'b.sequence']);
                    $b->orderBy(['b.sequence' => SORT_ASC]);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->joinWith(['organizationAppUsers c' => function ($c) {
                    $c->select(['c.assigned_user_enc_id', 'c.app_enc_id', 'c.user_enc_id value', 'CONCAT(c1.first_name," ",c1.last_name) label']);
                    $c->joinWith(['userEnc c1'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->where(['a.app_enc_id' => $params['app_id'], 'a.is_deleted' => 0])
                ->asArray()
                ->one();

            if ($detail) {

                if ($detail['organizationAppUsers']) {
                    foreach ($detail['organizationAppUsers'] as $key => $val) {
                        $detail['organizationAppUsers'][$key]['user_type'] = $this->getType($val['value']);
                    }
                }

                $detail['logo'] = $this->getFile($params['app_id']);
                $detail['assigned_to'] = json_decode($detail['assigned_to']);
                return $this->response(200, ['status' => 200, 'detail' => $detail]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function getType($user_id)
    {
        $user = Users::findOne(['user_enc_id' => $user_id]);

        $service = SelectedServices::find()
            ->alias('a')
            ->select(['b.name'])
            ->joinWith(['serviceEnc b'], false)
            ->where(['a.is_selected' => 1]);
        if ($user->organization_enc_id) {
            $service->andWhere(['or', ['a.organization_enc_id' => $user->organization_enc_id]]);
        } else {
            $service->andWhere(['or', ['a.created_by' => $user->user_enc_id]]);
        }

        $service = $service->asArray()
            ->all();

        $serviceArr = array_column($service, 'name');

        if (in_array('E-Partners', $serviceArr)) {
            return "DSA";
        } else if (in_array('Connector', $serviceArr)) {
            return "Connector";
        } else {
            return UserTypes::findOne(['user_type_enc_id' => $user->user_type_enc_id])->user_type;
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

    public function actionUpdate()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            $logo = UploadedFile::getInstanceByName('logo');

            if (empty($params['app_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing parameter "app_id"']);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $app = OrganizationApps::findOne(['app_enc_id' => $params['app_id']]);

                if (!$app) {
                    return $this->response(404, ['status' => 404, 'message' => 'not found']);
                }

                if ($app->organization_enc_id != $user->organization_enc_id) {
                    return $this->response(403, ['status' => 403, 'message' => 'forbidden']);
                }

                (!empty($params['app_name'])) ? $app->app_name = $params['app_name'] : "";
                (!empty($params['app_description'])) ? $app->app_description = $params['app_description'] : "";
                (!empty($params['assigned_to'])) ? $app->assigned_to = $params['assigned_to'] : "";

                if ($logo) {
                    $app->app_icon = Yii::$app->getSecurity()->generateRandomString() . '.' . $logo->extension;
                    $app->app_icon_location = Yii::$app->getSecurity()->generateRandomString() . '/';
                    if (!$this->fileUpload($app->app_icon, $app->app_icon_location, $logo)) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                }

                if (!empty($params['elements'])) {
                    $elements = json_decode($params['elements'], true);
//                    $elements = $params['elements'];
                    foreach ($elements as $key => $val) {
                        $field = OrganizationAppFields::findOne(['field_enc_id' => $val['field_enc_id'], 'is_deleted' => 0]);
                        if ($field) {
                            $field->sequence = $key;
                            $field->field_title = $val['name'];
                            $field->link = $val['link'];
                            $field->field_type = $val['field_type'];
                            $field->updated_by = $user->user_enc_id;
                            $field->updated_on = date('Y-m-d H:i:s');
                            if (!$field->update()) {
                                $transaction->rollBack();
                                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                            }
                        } else {
                            $app_fields = new OrganizationAppFields();
                            $app_fields->field_enc_id = Yii::$app->getSecurity()->generateRandomString();
                            $app_fields->app_enc_id = $params['app_id'];
                            $app_fields->field_title = $val['name'];
                            $app_fields->sequence = $key;
                            $app_fields->link = $val['link'];
                            $app_fields->field_type = $val['field_type'];
                            $app_fields->created_by = $user->user_enc_id;
                            $app_fields->created_on = date('Y-m-d H:i:s');
                            if (!$app_fields->save()) {
                                $transaction->rollBack();
                                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                            }
                        }
                    }
                }

                $app->updated_by = $user->user_enc_id;
                $app->updated_on = date('Y-m-d H:i:s');
                if (!$app->update()) {
                    $transaction->rollBack();
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }

                $transaction->commit();
                return $this->response(201, ['status' => 201, 'message' => 'successfully updated']);

            } catch (\Exception $exception) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function fileUpload($icon, $icon_location, $logo)
    {

        $base_path = Yii::$app->params->upload_directories->form_apps->logo . $icon_location;
        $type = $logo->type;

        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $result = $my_space->uploadFileSources($logo->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $icon, "private", ['params' => ['ContentType' => $type]]);
        if (!$result) {
            return false;
        }
        return true;
    }

    public function actionRemoveElement()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['field_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing parameter "field_id"']);
            }

            $field = OrganizationAppFields::findOne(['field_enc_id' => $params['field_id']]);

            if (!$field) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            $field->is_deleted = 1;
            $field->updated_by = $user->user_enc_id;
            $field->updated_on = date('Y-m-d H:i:s');
            if (!$field->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully removed']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveApp()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['app_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing parameter "app_id"']);
            }

            $app = OrganizationApps::findOne(['app_enc_id' => $params['app_id']]);

            if ($app->organization_enc_id != $user->organization_enc_id) {
                return $this->response(403, ['status' => 403, 'message' => 'forbidden']);
            }

            $app->is_deleted = 1;
            $app->updated_by = $user->user_enc_id;
            $app->updated_on = date('Y-m-d H:i:s');
            if (!$app->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully removed']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}