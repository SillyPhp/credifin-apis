<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\Apps;
use common\models\AssignedSupervisor;
use common\models\OrganizationAppFields;
use common\models\OrganizationApps;
use common\models\OrganizationAppUsers;
use common\models\SelectedServices;
use common\models\spaces\Spaces;
use common\models\UserRoles;
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

    // this is used to add organization apps
    public function actionAdd()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // creating apps new object
            $model = new Apps();

            // loading request data to model
            if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {

                // getting logo instance by name
                $model->logo = UploadedFile::getInstanceByName('logo');

                // validating model
                if ($model->validate()) {

                    // saving data
                    $data = $model->add($user);
                    if ($data['status'] == 201) {
                        return $this->response(201, ['status' => 201, 'message' => 'successfully saved']);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'Some Internal Server Error']);
                    }
                } else {
                    // returning validation errors
                    return $this->response(422, ['status' => 422, 'message' => 'missing information', 'error' => $model->getErrors()]);
                }

            } else {
                // in no data in request
                return $this->response(400, ['status' => 400, 'message' => 'bad request']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting organization apps list
    public function actionList()
    {
        if ($user = $this->isAuthorized()) {

            // if user is organization
            if ($user->organization_enc_id) {

                $params = Yii::$app->request->post();

                $limit = !empty($params['limit']) ? $params['limit'] : 10;
                $page = !empty($params['page']) ? $params['page'] : 1;

                // getting list
                $list = OrganizationApps::find()
                    ->select(['app_enc_id', 'app_name', 'app_description', 'assigned_to', 'created_on'])
                    ->where(['organization_enc_id' => $user->organization_enc_id, 'is_deleted' => 0])
                    ->limit($limit)
                    ->offset(($page - 1) * $limit)
                    ->asArray()
                    ->all();

                if ($list) {

                    // getting logo, decoding assigned_to and getting app fields count
                    foreach ($list as $key => $val) {
                        $list[$key]['logo'] = $this->getFile($val['app_enc_id']);
                        $list[$key]['assigned_to'] = json_decode($val['assigned_to']);
                        $list[$key]['elements_count'] = OrganizationAppFields::find()->where(['app_enc_id' => $val['app_enc_id'], 'is_deleted' => 0])->count();
                    }

                    return $this->response(200, ['status' => 200, 'list' => $list]);
                }


                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            } else {
                // if not organization login
                return $this->response(403, ['status' => 403, 'message' => 'must be organization login']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting file singed url
    private function getFile($app_id)
    {
        $file = OrganizationApps::findOne(['app_enc_id' => $app_id]);
        $path = Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->form_apps->logo . $file->app_icon_location . $file->app_icon;
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        return $my_space->signedURL($path, "15 minutes");
    }

    // getting app detail
    public function actionDetail()
    {
        $params = Yii::$app->request->post();

        // checking app_id
        if (empty($params['app_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing parameter "app_id"']);
        }

        // getting app
        $app = OrganizationApps::findOne(['app_enc_id' => $params['app_id']]);

        // if app not found
        if (!$app) {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

        // checking authorization for app detail
        if ($this->authorize($params['app_id'])) {

            // getting detail
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

                // getting organization app users and get their type
                if ($detail['organizationAppUsers']) {
                    foreach ($detail['organizationAppUsers'] as $key => $val) {
                        $detail['organizationAppUsers'][$key]['user_type'] = $this->getType($val['value']);
                    }
                }

                // get logo
                $detail['logo'] = $this->getFile($params['app_id']);
                $detail['assigned_to'] = json_decode($detail['assigned_to']);
                return $this->response(200, ['status' => 200, 'detail' => $detail]);
            }

            // not found
            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting user type
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

    // authorize user for organization app
    private function authorize($app_id)
    {
        if ($user = $this->isAuthorized()) {

            $app = OrganizationApps::findOne(['app_enc_id' => $app_id]);

            $assigned_to = json_decode($app->assigned_to);

            // adding e-partners if dsa is added in assigned to for service condition
            if ($assigned_to && array_search('DSA', $assigned_to)) {
                $assigned_to[] = 'E-Partners';
            }

            // checking by organization id
            if ($user->organization_enc_id && ($user->organization_enc_id == $app->organization_enc_id)) {
                return true;
            }

            // checking for employee authorization
            $org_id = UserRoles::findOne(['user_enc_id' => $user->user_enc_id])->organization_enc_id;

            if ($org_id && ($org_id == $app->organization_enc_id)) {
                return true;
            }

            // getting service of user
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

            $service = $service->asArray()->one();

            // checking for DSA/E-Partners
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

    // updating apps data
    public function actionUpdate()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // getting file instance
            $logo = UploadedFile::getInstanceByName('logo');

            // checking app_id
            if (empty($params['app_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing parameter "app_id"']);
            }

            // starting transaction
            $transaction = Yii::$app->db->beginTransaction();
            try {

                // getting app data object
                $app = OrganizationApps::findOne(['app_enc_id' => $params['app_id']]);

                // if not exists
                if (!$app) {
                    return $this->response(404, ['status' => 404, 'message' => 'not found']);
                }

                // app should be created by this user
                if ($app->organization_enc_id != $user->organization_enc_id) {
                    return $this->response(403, ['status' => 403, 'message' => 'forbidden']);
                }

                (!empty($params['app_name'])) ? $app->app_name = $params['app_name'] : "";
                (!empty($params['app_description'])) ? $app->app_description = $params['app_description'] : "";
                (!empty($params['assigned_to'])) ? $app->assigned_to = $params['assigned_to'] : "";

                // uploading file
                if ($logo) {
                    $app->app_icon = Yii::$app->getSecurity()->generateRandomString() . '.' . $logo->extension;
                    $app->app_icon_location = Yii::$app->getSecurity()->generateRandomString() . '/';
                    if (!$this->fileUpload($app->app_icon, $app->app_icon_location, $logo)) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                }

                // updating elements
                if (!empty($params['elements'])) {

                    $elements = json_decode($params['elements'], true);
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

                // updating users
                if (!empty($params['assigned_users'])) {

                    $assigned_users = json_decode($params['assigned_users'], true);
//                    $assigned_users = $params['assigned_users'];

                    $a_users = OrganizationAppUsers::find()
                        ->select(['assigned_user_enc_id', 'user_enc_id'])
                        ->where(['app_enc_id' => $params['app_id'], 'is_deleted' => 0])
                        ->asArray()
                        ->all();

                    $already_assigned_users = [];
                    foreach ($a_users as $val) {
                        $already_assigned_users[] = $val['user_enc_id'];
                    }

                    $to_be_added_users = array_diff($assigned_users, $already_assigned_users);
                    $to_be_deleted_users = array_diff($already_assigned_users, $assigned_users);

                    // to be added users
                    foreach ($to_be_added_users as $val) {
                        $assigned_user = new OrganizationAppUsers();
                        $assigned_user->assigned_user_enc_id = Yii::$app->getSecurity()->generateRandomString();
                        $assigned_user->app_enc_id = $params['app_id'];
                        $assigned_user->user_enc_id = $val;
                        $assigned_user->created_by = $user->user_enc_id;
                        $assigned_user->created_on = date('Y-m-d H:i:s');
                        if (!$assigned_user->save()) {
                            $transaction->rollBack();
                            return false;
                        }
                    }

                    // to be deleted users
                    foreach ($to_be_deleted_users as $val) {
                        $assigned_user_del = OrganizationAppUsers::findOne(['app_enc_id' => $params['app_id'], 'user_enc_id' => $val]);
                        $assigned_user_del->is_deleted = 1;
                        $assigned_user_del->updated_by = $user->user_enc_id;
                        $assigned_user_del->updated_on = date('Y-m-d H:i:s');
                        if (!$assigned_user_del->update()) {
                            $transaction->rollBack();
                            return false;
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

    // uploading file
    private function fileUpload($icon, $icon_location, $logo)
    {

        $base_path = Yii::$app->params->upload_directories->form_apps->logo . $icon_location;
        $type = $logo->type;

        // creating spaces object
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $result = $my_space->uploadFileSources($logo->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $icon, "private", ['params' => ['ContentType' => $type]]);
        if (!$result) {
            return false;
        }
        return true;
    }

    // this action is used to remove element
    public function actionRemoveElement()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking field_id
            if (empty($params['field_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing parameter "field_id"']);
            }

            $field = OrganizationAppFields::findOne(['field_enc_id' => $params['field_id']]);

            // if element/field not found
            if (!$field) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            $field->is_deleted = 1;
            $field->updated_by = $user->user_enc_id;
            $field->updated_on = date('Y-m-d H:i:s');
            if (!$field->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $field->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully removed']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to remove app
    public function actionRemoveApp()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking app_id
            if (empty($params['app_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing parameter "app_id"']);
            }

            // getting app object
            $app = OrganizationApps::findOne(['app_enc_id' => $params['app_id']]);

            if ($app->organization_enc_id != $user->organization_enc_id) {
                return $this->response(403, ['status' => 403, 'message' => 'forbidden']);
            }

            $app->is_deleted = 1;
            $app->updated_by = $user->user_enc_id;
            $app->updated_on = date('Y-m-d H:i:s');
            if (!$app->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $app->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully removed']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}