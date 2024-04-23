<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\Employee;
use api\modules\v4\utilities\ArrayProcessJson;
use api\modules\v4\utilities\UserUtilities;
use common\models\extended\LoanAccountsExtended;
use common\models\UserAccessTokens;
use common\models\UserRoles;
use common\models\Users;
use Yii;
use yii\db\Expression;
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
                'employee-collected-emi-stats' => ['POST', 'OPTIONS'],
                'get-employee=details' => ['POST', 'OPTIONS']
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

    public function actionUpdateProfile()
    {
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

    public function actionListUsers()
    {
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
                [
                    'and',
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
            ->where([
                'b.status' => 'Inactive', 'a.organization_enc_id' => $org_id,
                'c.user_type' => 'Employee', 'a.is_deleted' => 0
            ]);

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
    public function actionEmployeeCollectedEmiStats()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            $limit = !empty($params['limit']) ? $params['limit'] : 10;
            $page = !empty($params['page']) ? $params['page'] : 1;
            $startDate = $params['start_date'];
            $endDate = $params['end_date'];
            $org_id = $user->organization_enc_id;
            if (!$org_id) {
                $user_roles = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
                $org_id = $user_roles->organization_enc_id;
            }
            $valuesSma = LoanAccountsExtended::$buckets;
            $queryResult = "";
            foreach ($valuesSma as $key => $value) {
                $totalCasesNumber = "COUNT(DISTINCT CASE WHEN lac.bucket = '{$value['name']}' THEN lac.loan_account_enc_id END) total_cases_count_{$key},";
                $CollectedCasesNumber = "COUNT(CASE WHEN lac.bucket = '{$value['name']}' AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}' AND ec.emi_payment_status NOT IN ('rejected', 'failed','pending') THEN 1 END) collected_cases_count_{$key},";
                if ($key == 'OnTime') :
                    $targetAmount = "SUM(CASE WHEN lac.bucket = '{$value['name']}' THEN COALESCE(lac.emi_amount, 0) ELSE 0 END) target_amount_{$key},";
                else :
                    $targetAmount = "SUM(CASE WHEN lac.bucket = '{$value['name']}' THEN LEAST(COALESCE(lac.ledger_amount, 0) + COALESCE(lac.overdue_amount, 0), lac.emi_amount * '{$value['value']}') ELSE 0 END) target_amount_{$key},";
                endif;
                $collectedVerifiedAmount = "COALESCE(SUM(CASE WHEN lac.bucket = '{$value['name']}' AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}'  AND ec.emi_payment_status = 'paid' THEN COALESCE(ec.amount, 0) END),0) collected_verified_amount_{$key},";
                $collectedUnVerifiedAmount = "COALESCE(SUM(CASE WHEN lac.bucket = '{$value['name']}' AND ec.created_on BETWEEN '{$startDate}' AND '{$endDate}'  AND ec.emi_payment_status != 'paid' AND ec.emi_payment_status NOT IN ('rejected', 'failed','pending') THEN COALESCE(ec.amount, 0) END),0) collected_unverified_amount_{$key},";

                $queryResult .= "$totalCasesNumber $CollectedCasesNumber $targetAmount $collectedVerifiedAmount $collectedUnVerifiedAmount";
            }
            $queryResult = rtrim($queryResult, ',');
            $list = Users::find()
                ->alias('a')
                ->select([
                    'a.user_enc_id',
                    "(CASE WHEN a.last_name IS NOT NULL THEN CONCAT(a.first_name,' ',a.last_name) ELSE a.first_name END) as employee_name",
                    "CASE WHEN a.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . "', a.image_location, '/', a.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(a.first_name, ' ', COALESCE(a.last_name, '')), '&size=200&rounded=false&background=', REPLACE(a.initials_color, '#', ''), '&color=ffffff') END employee_image",
                    "(CASE WHEN b2.image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . "',b2.image_location, '/', b2.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(b2.first_name,' ',b2.last_name), '&size=200&rounded=true&background=', REPLACE(b2.initials_color, '#', ''), '&color=ffffff') END) reporting_image",
                    'a.phone', 'a.email', 'a.username', 'a.status', 'b.employee_code',
                    'gd.designation designation',
                    "CONCAT(b2.first_name,' ',b2.last_name) reporting_person",
                    'b3.location_name branch_name', 'b3.location_enc_id branch_id',
                    $queryResult, "ANY_VALUE(ce2.name) as state_name"
                ])
                ->joinWith(['userRoles0 b' => function ($b) {
                    $b->joinWith(['designationEnc b1'])
                        ->joinWith(['designation gd'])
                        ->joinWith(['reportingPerson b2'])
                        ->joinWith(['branchEnc b3' => function ($b3) {
                            $b3->joinWith(['cityEnc ce1' => function ($ce1) {
                                $ce1->joinWith(['stateEnc ce2'], false);
                            }], false);
                        }], false)
                        ->joinWith(['userTypeEnc b4']);
                }], false)
                ->joinWith(['assignedLoanAccounts0 ala' => function ($asla) {
                    $asla->joinWith(['loanAccountEnc lac' => function ($lac) {
                        $lac->joinWith(['emiCollections ec']);
                    }]);
                }], false)
                ->andWhere(['b4.user_type' => 'Employee', 'b.is_deleted' => 0])
                //date between condition need to be set after shalya beta test and scenerio
                ->andWhere(['between', new Expression('DAY(emi_date)'), new Expression("DAY('$startDate')"), new Expression("DAY('$endDate')")])
                ->andWhere(['<=', new Expression('YEAR(emi_date)'), new Expression("YEAR('$endDate')")])
                ->andWhere(['<=', new Expression('MONTH(emi_date)'), new Expression("MONTH('$endDate')")])
                ->andWhere(['a.status' => 'active', 'a.is_deleted' => 0, 'b.organization_enc_id' => $org_id])
                ->groupBy(['a.user_enc_id', 'b2.image', 'b2.image_location', 'b2.initials_color', 'b.employee_code', 'b2.first_name', 'b2.last_name', 'gd.designation', 'b3.location_name', 'b3.location_enc_id']);

            if (!empty($params['loan_type'])) {
                $list->andWhere(['IN', 'ec.loan_type', $params['loan_type']]);
            }
            if (!empty($params['fields_search'])) {
                foreach ($params['fields_search'] as $key => $value) {
                    if (!empty($value)) {
                        if ($key == 'employee_code') {
                            $list->andWhere(['like', 'b.' . $key, $value]);
                        } elseif ($key == 'state_enc_id') {
                            if (in_array("unassigned", $value)) {
                                $list->andWhere(['ce2.state_enc_id' => null]);
                            } else {
                                $list->andWhere(['IN', 'ce2.state_enc_id', $value]);
                            }
                        } elseif ($key == 'phone') {
                            $list->andWhere(['like', 'a.' . $key, $value]);
                        } elseif ($key == 'username') {
                            $list->andWhere(['like', 'a.' . $key, $value]);
                        } elseif ($key == 'employee_name') {
                            $list->andWhere(['like', "CONCAT(a.first_name,' ',COALESCE(a.last_name))", $value]);
                        } elseif ($key == 'reporting_person') {
                            $list->andWhere(['like', "CONCAT(b2.first_name,' ',COALESCE(b2.last_name))", $value]);
                        } elseif ($key == 'branch') {
                            if (in_array("unassigned", $value)) {
                                $list->andWhere(['b3.location_enc_id'=> null]);
                            } else {
                                $list->andWhere(['IN', 'b3.location_enc_id', $value]);
                            }
                        } elseif ($key == 'designation_id') {
                            $list->andWhere(['IN', 'gd.assigned_designation_enc_id', $value]);
                        } else {
                            $list->andWhere(['like', $key, $value]);
                        }
                    }
                }
            }
            if (!$res = UserUtilities::getUserType($user->user_enc_id) == 'Financer' || self::specialCheck($user->user_enc_id)) {
                $juniors = UserUtilities::getting_reporting_ids($user->user_enc_id, 1);
                $list->andWhere(['a.user_enc_id' => $juniors]);
            }
            if (isset($params['field']) && !empty($params['field']) && isset($params['order_by']) && !empty($params['order_by'])) {
                $list->orderBy(['a.' . $params['field'] => $params['order_by'] == 0 ? SORT_ASC : SORT_DESC]);
            }
            if (isset($params['report_type']) && $params['report_type'] != "") {
                $list->andWhere(['=', 'ala.user_type', $params['report_type']]);
            }
            $count = $list->count();
            $list = $list
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();
            if ($list) :
                $list = ArrayProcessJson::Parse($list);
            endif;
            return $this->response(200, ['status' => 200, 'data' => $list, 'count' => $count]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
    public function actionGetEmployeeDetails()
    {
        $params = Yii::$app->request->post();

        if (empty($params['username'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "username"']);
        }

        $employee = Users::find()
            ->alias('a')
            ->select([
                'a.username', 'b.employee_joining_date', 'b2.designation', 'b.employee_code', 'b3.location_name', 'a.email', 'a.phone',
                "CONCAT(a.first_name , ' ', COALESCE(a.last_name, '')) as name", 'a.status',
                "(CASE WHEN a.status = 'Active' OR a.status = 'Inactive' THEN a.status ELSE NULL END) as status",
                "CASE WHEN a.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . "', a.image_location, '/', a.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(a.first_name, ' ', COALESCE(a.last_name, '')), '&size=200&rounded=false&background=', REPLACE(a.initials_color, '#', ''), '&color=ffffff') END employee_image",
            ])
            ->joinWith(['userRoles0 b' => function ($d) {
                $d->joinWith(['designation b2'], false);
                $d->joinWith(['branchEnc b3' => function ($f) {
                }], false);
            }], false)
            ->andWhere(['a.username' => $params['username'], 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if (!$employee) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }
        return $this->response(200, ['status' => 200, 'data' => $employee]);
    }
}
