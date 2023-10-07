<?php

namespace api\modules\v4\controllers;

use common\models\EmiCollection;
use common\models\EmployeesCashReport;
use common\models\Utilities;
use common\models\WebhookTest;
use Exception;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;

class EmiCollectionsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-emi-phone' => ['POST', 'OPTIONS'],
                'emi-employee-stats' => ['POST', 'OPTIONS'],
                'employee-emi-collection' => ['POST', 'OPTIONS'],
                'collect-cash' => ['POST', 'OPTIONS'],
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

    public function actionGetEmiPhone()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        if (!$params = Yii::$app->request->post()) {
            return $this->response(500, ['status' => 500, 'message' => 'params not found']);
        }

        $data = EmiCollection::find()
            ->select([
                'phone'
            ])
            ->andWhere([
                'and',
                ['between', 'collection_date', $params['start_date'], $params['end_date']],
                ['is_deleted' => 0],
                ['emi_payment_status' => 'pending'],
                ['emi_payment_method' => [6, 7]]
            ])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'data' => $data]);
    }

    public function actionEmiEmployeeStats()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        if (!$params = Yii::$app->request->post()) {
            return $this->response(500, ['status' => 500, 'message' => 'params not found']);
        }

        $limit = !empty($params['limit']) ? $params['limit'] : 25;
        $page = !empty($params['page']) ? $params['page'] : 1;

        $query = EmiCollection::find()
            ->alias('a')
            ->select([
                'CONCAT(b.first_name, " ", COALESCE(b.last_name, "")) name', 'b1.employee_code',
                'b2.designation', 'CONCAT(b3.first_name, " ", COALESCE(b3.last_name, "")) reporting_person',
                'b4.location_name', 'b.phone', 'b.email', 'SUM(a.amount) total_sum', 'a.created_by', 'COUNT(a.amount) total_count'
            ])
            ->joinWith(['createdBy b' => function ($a) {
                $a->joinWith(['userRoles0 b1' => function ($b1) {
                    $b1->joinWith(['designation b2'], false);
                    $b1->joinWith(['reportingPerson b3'], false);
                    $b1->joinWith(['branchEnc b4'], false);
                }], false);
            }], false)
            ->andWhere([
                'and',
                ['in', 'a.emi_payment_method', [4, 81]],
                ['a.is_deleted' => 0],
                ['a.emi_payment_status' => 'pending']
            ])
            ->groupBy(['a.created_by']);
        if (!empty($params['branch_name'])) {
            $query->andWhere(['b4.location_enc_id' => $params['branch_name']]);
        }
        if (!empty($params['loan_type']) && $params['loan_type'] != 'All') {
            $query->andWhere(['a.loan_type' => $params['loan_type']]);
        }
        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $query->andWhere([
                'or',
                ['like', 'CONCAT(b.first_name, " ", COALESCE(b.last_name, ""))', $params['keyword']],
                ['like', 'b.phone', $params['keyword']],
                ['like', 'b1.employee_code', $params['keyword']],
                ['like', 'b2.designation', $params['keyword']],
            ]);
        }
        $count = $query->count();
        $query = $query
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();
        $collected_cash = $this->collectedCash();
        foreach ($query as &$item) {
            if (in_array($item['created_by'], $collected_cash)) {
                $item['collected_cash'] = $collected_cash[$item['created_by']];
            }
        }

        if ($query) {
            return $this->response(200, ['status' => 200, 'data' => $query, 'count' => $count]);
        }
        return $this->response(200, ['status' => 404, 'message' => 'no data found']);
    }

    private function collectedCash()
    {
        $query = EmployeesCashReport::find()
            ->alias('a')
            ->select(['a.user_enc_id', 'SUM(a.amount) as sum'])
            ->andWhere(['a.is_deleted' => 0])
            ->groupBy(['a.user_enc_id'])
            ->asArray()
            ->all();
        $res = array_column($query, 'sum', 'user_enc_id');
        return $res ?? false;
    }

    public function actionCollectCash()
    {
        if (!$user = $this->isSpecialUser()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        try {
            $query = new EmployeesCashReport();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $query->employees_cash_report_enc_id = $utilitiesModel->encrypt();
            $query->organization_enc_id = $params['org_id'];
            $query->user_enc_id = $params['user_id'];
            $query->amount = $params['amount'];
            $query->created_by = $query->updated_by = $user->user_enc_id;
            $query->created_on = $query->updated_on = date('Y-m-d H:i:s');
            if (!$query->save()) {
                throw new \Exception(implode(" ", \yii\helpers\ArrayHelper::getColumn($query->errors, 0, false)));
            }
            return $this->response(200, ['status' => 200, 'message' => 'Saved Successfully']);
        } catch (Exception $exception) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()]);
        }
    }

    public function actionEmployeeEmiCollection()
    {
        if (!$user = $this->isSpecialUser()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        $org_id = $params['org_id'];
        $user_id = $params['user_id'];
        $search = ['emi_payment_status' => 'pending', 'emi_payment_method' => [4, 81]];
        $json = (object)['user_enc_id' => $user_id];
        $query = OrganizationsController::_emiData($org_id, 0,  $search, $json)['data'];

        $display_data = EmiCollection::find()
            ->alias('a')
            ->select(['SUM(a.amount) total_sum', 'count(a.amount) count'])
            ->joinWith(['createdBy b'], false)
            ->andWhere(['a.created_by' => $user_id, 'a.is_deleted' => 0, 'a.emi_payment_method' => [4, 81], 'a.emi_payment_status' => 'pending'])
            ->asArray()
            ->one();
        if ($query) {
            return $this->response(200, ['status' => 200, 'data' => $query, 'display_data' => $display_data]);
        }
        return $this->response(200, ['status' => 404, 'message' => 'no data found']);
    }
}
