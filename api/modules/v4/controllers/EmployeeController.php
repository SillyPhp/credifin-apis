<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\Employee;
use common\models\UserAccessTokens;
use common\models\UserRoles;
use common\models\Users;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class EmployeeController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'update-profile' => ['POST', 'OPTIONS'],
                'list-users' => ['POST', 'OPTIONS'],
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

    public function actionUpdateProfile(){
        if ($user = $this->isAuthorized()) {
            $model = new Employee();
            $model->load(Yii::$app->getRequest()->getBodyParams());
            $res = $model->update($user['user_enc_id']);
            if ($res['status']) {
                return $this->response(200, ['status' => 200, 'message' => 'Successfully Updated']);
            } else {
                return $this->response(201, ['status' => 201, 'message' => $res['error']]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionListUsers(){
        if ($user = $this->isAuthorized()) {
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionResetPassword()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();

        if (empty($params['user_enc_id']) || empty($params['new_password'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing user_enc_id or new_password']);
        }

        $user_enc_id = $params['user_enc_id'];
        $new_password = $params['new_password'];

        $user = Users::findOne(['user_enc_id' => $user_enc_id, 'is_deleted' => 0]);

        if ($user != null) {
            $user->password = Yii::$app->getSecurity()->generatePasswordHash($new_password);
            $user->update();

            UserAccessTokens::updateAll(
                [
                    'is_deleted' => 1,
                    'last_updated_on' => date('Y-m-d H:i:s')
                ],
                ['and',
                    ['user_enc_id' => $user_enc_id],
                    ['is_deleted' => 0]
                ]
            );

            return $this->response(200, ['status' => 200, 'message' => 'Password changed successfully']);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'User not found']);
        }
    }

    public function actionInactiveEmployeeList()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }

        $org_id = $user->organization_enc_id;
        if (!$user->organization_enc_id) {
            $findOrg = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            $org_id = $findOrg->organization_enc_id;
        }
        if ($org_id) {
            $params = Yii::$app->request->post();
            $inactive_employees = $this->employee($org_id, $params);

            return $this->response(200, ['status' => 200, 'data' => $inactive_employees]);
        } else {
            return $this->response(403, ['status' => 403, 'message' => 'only authorized by financer']);
        }

    }

    private function employee($org_id, $params = null)
    {
        $inactive_employees = UserRoles::find()
            ->alias('a')
            ->select([
                'a.role_enc_id',
                "CASE 
                    WHEN b.image IS NOT NULL 
                        THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . "', b.image_location, '/', b.image) 
                        ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')), '&size=200&rounded=false&background=', REPLACE(b.initials_color, '#', ''), '&color=ffffff') 
                    END image",
                "CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')) name",
                'a.employee_joining_date', 'a.user_enc_id', 'b.username', 'b.email', 'b.phone',
                'b.status', 'c.user_type', 'a.employee_code', 'd.designation', 'a.designation_id',
                "CONCAT(e.first_name, ' ', COALESCE(e.last_name, '')) reporting_person", "CONCAT(f.location_name, ', ', f1.name) AS branch_name",
                'f.address branch_address', 'f1.name city_name', 'f.location_enc_id branch_id', 'a.grade', 'b.created_on platform_joining_date'
            ])
            ->joinWith(['userEnc b'], false)
            ->joinWith(['userTypeEnc c'], false)
            ->joinWith(['designation d'], false)
            ->joinWith(['reportingPerson e'], false)
            ->joinWith(['branchEnc f' => function ($f) {
                $f->joinWith(['cityEnc f1']);
            }], false)
            ->where(['b.status' => 'Inactive', 'a.organization_enc_id' => $org_id,
                'c.user_type' => 'Employee', 'a.is_deleted' => 0]);

        if ($params != null && !empty($params['fields_search'])) {
            $a = ['designation_id', 'employee_code', 'grade', 'employee_joining_date'];
            $b = ['phone', 'email', 'username', 'status', 'name', 'platform_joining_date'];
            foreach ($params['fields_search'] as $key => $value) {
                if (!empty($value) || $value == '0') {

                    if (in_array($key, $a)) {
                        if ($key == 'designation_id') {
                            $inactive_employees->andWhere(['a.' . $key => $value]);
                        } else {
                            $inactive_employees->andWhere(['like', 'a.' . $key, $value]);
                        }
                    }
                    if (in_array($key, $b)) {
                        if ($key == 'status') {
                            $inactive_employees->andWhere(['like', 'b.status', $value . '%', false]);
                        } elseif ($key == 'name') {
                            $inactive_employees->andWhere(['like', "CONCAT(b.first_name, ' ', COALESCE(b.last_name, ''))", $value]);
                        } elseif ($key == 'platform_joining_date') {
                            $inactive_employees->andWhere(['like', 'b.created_on', $value]);
                        } else {
                            $inactive_employees->andWhere(['like', 'b.' . $key, $value]);
                        }
                    }
                    switch ($key) {
                        case 'reporting_person':
                            $inactive_employees->andWhere(['like', "CONCAT(e.first_name, ' ', COALESCE(e.last_name, ''))", $value]);
                            break;
                        case 'branch':
                            $inactive_employees->andWhere(['like', 'f.location_enc_id', $value]);
                            break;
                    }
                }
            }
        }

        if ($params != null && !empty($params['employee_search'])) {
            $inactive_employees->andWhere([
                'or',
                ['like', "CONCAT(b.first_name, ' ', COALESCE(b.last_name, ''))", $params['employee_search']],
                ['like', 'b.username', $params['employee_search']],
                ['like', 'b.email', $params['employee_search']],
                ['like', 'b.phone', $params['employee_search']],
                ['like', 'a.employee_code', $params['employee_search']],
            ]);
        }

        if ($params != null && !empty($params['reporting_person'])) {
            $inactive_employees->andWhere([
                'like', "CONCAT(e.first_name, ' ', COALESCE(e.last_name, ''))", $params['reporting_person'],
            ]);
        }

        // checking if this employee already exists in list from frontend
        if ($params != null && !empty($params['alreadyExists'])) {
            $inactive_employees->andWhere(['not', ['a.user_enc_id' => $params['alreadyExists']]]);
        }

        return $inactive_employees->asArray()
            ->all();

    }

}