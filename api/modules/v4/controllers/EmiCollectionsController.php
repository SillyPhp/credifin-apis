<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\EmiCollectionForm;
use api\modules\v4\utilities\UserUtilities;
use common\models\EmiCollection;
use common\models\extended\EmiCollectionExtended;
use common\models\extended\EmployeesCashReportExtended;
use common\models\extended\LoanAuditTrail;
use Exception;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class EmiCollectionsController extends ApiBaseController
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors["verbs"] = [
            "class" => VerbFilter::className(),
            "actions" => [
                "get-emi-phone" => ["POST", "OPTIONS"],
                "emi-employee-stats" => ["POST", "OPTIONS"],
                "collect-cash" => ["POST", "OPTIONS"],
                "pending-approvals" => ["POST", "OPTIONS"],
                "authorised-approve" => ["POST", "OPTIONS"],
                "approve-by-employee-list" => ["POST", "OPTIONS"],
                "approve-by-employee" => ["POST", "OPTIONS"],
                "employee-emi-collection" => ["POST", "OPTIONS"],
                "list" => ["GET", "OPTIONS"],
                "get-collected-emi-list" => ["POST", "OPTIONS"],
                "emi-detail" => ["POST", "OPTIONS"],
                "update" => ["POST", "OPTIONS"],
            ]
        ];
        $behaviors["corsFilter"] = [
            "class" => Cors::className(),
            "cors" => [
                "Origin" => ["https://www.empowerloans.in/"],
                "Access-Control-Request-Method" => ["GET", "POST", "PUT", "PATCH", "DELETE", "HEAD", "OPTIONS"],
                "Access-Control-Max-Age" => 86400,
                "Access-Control-Expose-Headers" => [],
            ],
        ];
        return $behaviors;
    }

    public function actionList()
    {
        $bearer_token = Yii::$app->request->headers->get('Authorization');
        $token = explode(" ", $bearer_token);
        if (isset($token[0]) && $token[0] != 'Bearer') {
            $unAuthorised = 1;
        }
        if (!isset($token[1])) {
            $unAuthorised = 1;
        }
        if (!empty($unAuthorised) || $token[1] !== Yii::$app->params->emiCollection->authKey) {
            $this->response(401, ["message" => "unauthorized"]);
        }
        $params = Yii::$app->request->get();
        $c = !empty($params['company']);
        if (empty($params["start_date"]) || empty($params["end_date"])) {
            return $this->response(500, ["error" => "'start date' or 'end date' missing"]);
        }
        if (strtotime($params["end_date"]) <= strtotime($params["start_date"])) {
            return $this->response(500, ["error" => "end date must be greater than start date"]);
        }
        $query = EmiCollection::find()
            ->alias("a")
            ->select([
                "a.loan_account_number",
                "TRIM(a.customer_name) AS customer_name",
                "a.phone",
                "a.amount collected_amount",
                "a.emi_payment_method",
                "(CASE 
                    WHEN a.emi_payment_method NOT IN (1, 2, 3) 
                        THEN DATE_FORMAT(a.collection_date, '%d-%m-%Y') 
                        ELSE DATE_FORMAT(c1.updated_on, '%d-%m-%Y')
                END) as collection_date",
                "(CASE 
                    WHEN a.emi_payment_method IN (1, 2, 3)
                        THEN c1.payment_id
                        ELSE a.reference_number
                END) AS reference_id",
                "a.emi_payment_status",
                "b.company_id",
                "b.company_name",
            ])
            ->innerJoinWith(["loanAccountEnc b" => function ($b) use ($c) {
                if (!$c) {
                    $b->andOnCondition(["NOT", [
                        "b.company_id" => [null, ''],
                        "b.company_name" => [null, '']
                    ]]);
                }
            }], false)
            ->joinWith(["assignedLoanPayments c" => function ($c) {
                $c->andOnCondition(["IS NOT", "c.emi_collection_enc_id", null]);
                $c->joinWith(["loanPaymentsEnc c1" => function ($c1) {
                    $c1->andOnCondition(["c1.payment_status" => "captured"]);
                }], false);
            }], false)
            ->andWhere(["a.is_deleted" => 0, "a.emi_payment_status" => "paid"])
            ->andWhere(["BETWEEN", "UNIX_TIMESTAMP(a.collection_date)", strtotime($params["start_date"]), strtotime($params["end_date"])])
            ->asArray()
            ->all();
        $payment_methods = EmiCollectionForm::$payment_methods;
        $query = array_map(function ($e) use ($payment_methods) {
            $e["emi_payment_method"] = $payment_methods[$e["emi_payment_method"]];
            return $e;
        }, $query);
        return $this->response(200, ["data" => $query]);
    }

    public function actionGetEmiPhone()
    {
        $this->isAuth();
        if (!$params = $this->post) {
            return $this->response(500, ["status" => 500, "message" => "params not found"]);
        }

        $data = EmiCollectionExtended::find()
            ->select(["phone"])
            ->andWhere([
                "and",
                ["between", "collection_date", $params["start_date"], $params["end_date"]],
                ["is_deleted" => 0],
                ["emi_payment_status" => "pending"],
                ["emi_payment_method" => [6, 7]]
            ])
            ->asArray()
            ->all();

        return $this->response(200, ["data" => $data]);
    }

    public function actionEmiEmployeeStats()
    {
        $this->isAuth();
        $params = $this->post;
        $limit = !empty($params["limit"]) ? $params["limit"] : 10;
        $page = !empty($params["page"]) ? $params["page"] : 1;
        $select = [
            "CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')) name",
            "ANY_VALUE(b1.employee_code) employee_code", "ANY_VALUE(b2.designation) designation",
            "CONCAT(ANY_VALUE(b3.first_name), ' ', COALESCE(ANY_VALUE(b3.last_name), '')) reporting_person",
            "ANY_VALUE(b4.location_name) location_name", "ANY_VALUE(b.phone) phone", "b.email",
            "SUM(a.remaining_amount) total_sum",
            "a.given_to", "ANY_VALUE(a.received_from) received_from"
        ];
        $fields_search = [];
        if (!empty($params['field'])) {
            foreach ($params['field'] as $key => $value) {
                if (!empty($value) || $value == '0') {
                    switch ($key) {
                        case 'employee_code':
                            $fields_search[] = "ANY_VALUE(b1.employee_code) LIKE '%$value%'";
                            break;
                        case 'name':
                            $fields_search[] = "CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')) LIKE '%$value%'";
                            break;
                        case 'reporting_person':
                            $fields_search[] = "CONCAT(ANY_VALUE(b3.first_name), ' ', COALESCE(ANY_VALUE(b3.last_name), '')) LIKE '%$value%'";
                            break;
                        case 'designation':
                            $fields_search[] = "ANY_VALUE(b2.designation) LIKE '%$value%'";
                            break;
                        case 'phone':
                            $fields_search[] = "ANY_VALUE(b.phone) LIKE '%$value%'";
                            break;
                    }
                }
            }
            $fields_search = implode(" AND ", $fields_search);
        }
        $query = EmployeesCashReportExtended::find()
            ->alias("a")
            ->select($select)
            ->joinWith(["givenTo b" => function ($a) {
                $a->joinWith(["userRoles0 b1" => function ($b1) {
                    $b1->joinWith(["designation b2"], false);
                    $b1->joinWith(["reportingPerson b3"], false);
                    $b1->joinWith(["branchEnc b4"], false);
                }], false);
            }], false)
            ->andWhere(["a.type" => [0, 2]])
            ->andWhere(["AND",
                ["NOT",
                    ["a.remaining_amount" => 0]],
                ["a.parent_cash_report_enc_id" => null]])
            ->groupBy(["a.given_to"]);
        if (!empty($params["branch_id"])) {
            $query->andWhere(["b4.location_enc_id" => $params["branch_id"]]);
        }

        if (!empty($fields_search)) {
            $query->andWhere($fields_search);
        }
        $count = $query->count();
        $query = $query
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        $query = ArrayHelper::index($query, "given_to");
        $query2 = EmployeesCashReportExtended::find()
            ->alias("a")
            ->select($select)
            ->joinWith(["receivedFrom b" => function ($a) {
                $a->joinWith(["userRoles0 b1" => function ($b1) {
                    $b1->joinWith(["designation b2"], false);
                    $b1->joinWith(["reportingPerson b3"], false);
                    $b1->joinWith(["branchEnc b4"], false);
                }], false);
            }], false)
            ->andWhere(["a.type" => 1])
            ->andWhere(["AND",
                ["NOT",
                    ["a.remaining_amount" => 0]
                ],
                ["a.parent_cash_report_enc_id" => null],
                ["a.status" => 2]
            ])
            ->groupBy(["a.cash_report_enc_id"]);
        if (!empty($params["branch_id"])) {
            $query2->andWhere(["b4.location_enc_id" => $params["branch_id"]]);
        }
        if (!empty($fields_search)) {
            $query2->andWhere($fields_search);
        }
        $query2 = $query2
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();
        foreach ($query2 as $item) {
            if (in_array($item["received_from"], $query)) {
                $query[$item["received_from"]]["total_sum"] += $item["total_sum"];
            } else {
                $item["given_to"] = $item["received_from"];
                $query[$item["received_from"]] = $item;
            }
        }
        if ($query) {
            return $this->response(200, ["status" => 200, "data" => array_values($query), "count" => $count]);
        }
        return $this->response(404, ["status" => 404, "message" => "no data found"]);
    }

    public function actionEmployeeEmiCollection()
    {
        $this->isAuth();
        $params = $this->post;
        $user_id = $params["user_id"];

        $query_data = $this->emiCashReport($user_id, $params);
        $count = $query_data['count'];
        $query = $query_data['query'];

        $data = $this->displayData($user_id);
        $received_cash = $data['received_cash'];
        $display_data = $data['display_data'];

        return $this->response(200, ["status" => 200, 'count' => $count, "data" => $query, "display_data" => $display_data, "received_cash" => $received_cash]);
    }

    private function emiCashReport($user_id, $params)
    {
        $query = EmployeesCashReportExtended::find()
            ->alias("a")
            ->select([
                "b.loan_account_number", "b.collection_date", "b.customer_name", "a.amount",
                "b.loan_type", "b.phone", "b.delay_reason", "b.ptp_amount", "b.ptp_date", "a.cash_report_enc_id",
                "CASE WHEN b.borrower_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->borrower_image->image . "',b.borrower_image_location, '/', b.borrower_image) ELSE NULL END as borrower_image",
                "CASE WHEN b.pr_receipt_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image . "',b.pr_receipt_image_location, '/', b.pr_receipt_image) ELSE NULL END as pr_receipt_image",
                "CASE WHEN b.other_doc_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->other_doc_image->image . "',b.other_doc_image_location, '/', b.other_doc_image) ELSE NULL END as other_doc_image",
            ])
            ->joinWith(["emiCollectionEnc b"], false)
            ->andWhere([
                "AND",
                ["a.status" => 0],
                ["a.type" => [0, 2]],
                ["a.is_deleted" => 0],
                ["a.parent_cash_report_enc_id" => null],
                [
                    "NOT",
                    ["a.remaining_amount" => 0]
                ],
                ["a.given_to" => $user_id]
            ]);

        $count = $query->count();
        $query = $query
            ->asArray()
            ->all();

        $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        foreach ($query as &$value) {
            if ($value['other_doc_image']) {
                $value['other_doc_image'] = $my_space->signedURL($value['other_doc_image'], "15 minutes");
            }
            if ($value['borrower_image']) {
                $value['borrower_image'] = $my_space->signedURL($value['borrower_image'], "15 minutes");
            }
            if ($value['pr_receipt_image']) {
                $value['pr_receipt_image'] = $my_space->signedURL($value['pr_receipt_image'], "15 minutes");
            }
        }

        return ['count' => $count, 'query' => $query];

    }

    private function displayData($user_id)
    {
        $received_cash = $this->received_cash($user_id);
        $display_data = EmployeesCashReportExtended::find()
            ->alias("a")
            ->select([
                "SUM(CASE WHEN a.type = 2 AND a.status = 1 THEN a.remaining_amount END) AS cash",
                "COUNT(CASE WHEN a.type = 0 THEN a.amount END) AS emi_count",
                "SUM(CASE WHEN a.type = 0 THEN a.remaining_amount END) AS emi",
                "SUM(CASE WHEN a.status = 2 AND given_to IS NULL THEN a.remaining_amount END) AS pending_bank_approval",
                "SUM(CASE WHEN a.type = 2 AND a.status = 2 AND a.given_to = '$user_id' THEN a.remaining_amount END) AS pending_amount_approval"
            ])
            ->andWhere([
                "AND",
                [
                    "OR",
                    ["a.given_to" => $user_id],
                    [
                        "AND",
                        ["a.received_from" => $user_id],
                        ["a.status" => 2]

                    ]
                ],
                ["a.is_deleted" => 0],
                ["a.parent_cash_report_enc_id" => null],
                [
                    "not",
                    ["a.remaining_amount" => 0]
                ]
            ])
            ->asArray()
            ->one();

        foreach ($received_cash as &$cash) {
            if (empty($cash["emiCollectionEnc"])) {
                $cash["emiCollectionEnc"] = $this->finder($cash["cash_report_enc_id"]);
            }
        }

        $display_data["total_sum"] = $display_data["emi"] + $display_data["cash"];

        return ['received_cash' => $received_cash, 'display_data' => $display_data];
    }

    private
    function finder($parent): array
    {
        $res = [];
        $reports = $this->received_cash("", $parent);
        foreach ($reports as $report) {
            if (empty($report["emiCollectionEnc"])) {
                $res = array_merge($res, $this->finder($report["cash_report_enc_id"]));
            } else {
                $res[] = $report["emiCollectionEnc"];
            }
        }
        return $res;
    }

    public
    function actionPendingApprovals()
    {
        $this->isAuth();
        $params = $this->post;
        if (empty($params["user_id"])) {
            return $this->response(422, ["status" => 422, "message" => "missing parameter 'user_id'"]);
        }
        $user_id = $params["user_id"];
        $approval = EmployeesCashReportExtended::find()
            ->alias("a")
            ->select([
                "a.remaining_amount", "a.reference_number", "a.emi_collection_enc_id", "a.cash_report_enc_id",
                "CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->cash_report->image . "', a.image_location, '/', a.image) AS receipt",
                "a.created_on"
            ])
            ->joinWith(["emiCollectionEnc b" => function ($b) {
                $b->select([
                    "b.emi_collection_enc_id", "b.loan_account_number", "b.customer_name",
                    "b.loan_type", "b.emi_collection_enc_id", "b.amount"
                ]);
            }])
            ->andWhere([
                "AND",
                ["a.received_from" => $user_id],
                ["a.is_deleted" => 0],
                ["a.parent_cash_report_enc_id" => null],
                [
                    "NOT",
                    ["a.remaining_amount" => 0]
                ],
                ['a.status' => 2],
                ['a.type' => 1]
            ])
            ->asArray()
            ->all();
        if (!$approval) {
            return $this->response(404, ["status" => 404, "message" => "no data found"]);
        }
        $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        foreach ($approval as &$item) {
            if (empty($item['emiCollectionEnc'])) {
                $item['emiCollectionEnc'] = $this->finder($item['cash_report_enc_id']);
            }
            $item['receipt'] = $my_space->signedURL($item['receipt']);
        }
        return $this->response(200, ["status" => 200, "data" => $approval]);
    }

    private
    function received_cash($user_id, $parent = ""): array
    {
        $where = ["AND"];
        if ($parent) {
            $where[] = ["!=", "a.type", 1];
            $where[] = ["a.parent_cash_report_enc_id" => $parent];
        } else {
            $where[] = ["a.type" => 2];
            $where[] = ["a.status" => 1];
            $where[] = ["a.given_to" => $user_id];
            $where[] = ["!=", "a.remaining_amount", 0];
        }
        return EmployeesCashReportExtended::find()
            ->alias("a")
            ->select([
                "a.cash_report_enc_id", "CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')) received_from",
                "a.remaining_amount", "a.created_on", "a.parent_cash_report_enc_id", "a.emi_collection_enc_id", "a.status"
            ])
            ->joinWith(["receivedFrom b"], false)
            ->joinWith(["emiCollectionEnc c" => function ($c) {
                $c->select([
                    "c.emi_collection_enc_id", "c.loan_account_number", "c.customer_name",
                    "c.loan_type", "c.emi_collection_enc_id", "c.amount"
                ]);
            }])
            ->andWhere($where)
            ->asArray()
            ->all();
    }

    public
    function actionCollectCash()
    {
        $this->isAuth();
        $params = $this->post;
        $params["user_id"] = $this->user->user_enc_id;
        return $this->collectcash($params, true);
    }

    public function actionAdminCollectCash()
    {
        $this->isAuth(1);
        $params = $this->post;
        $params["user_id"] = $this->user->user_enc_id;
        $params["specialroles"] = true;
        return $this->collectcash($params);
    }

    public function collectcash($params, $not_special = false): ?array
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $save = EmiCollectionForm::collect_cash($params);
            if (!$save) {
                throw new \Exception("error occurred while saving emi");
            }
            if (!empty($params['cash_ids']) && $not_special) {
                self::updateEmiStatus($params['cash_ids'], $params['user_id'], 'pipeline');
            }
            $transaction->commit();
            return $this->response(200, ["status" => 200, "message" => "saved successfully"]);
        } catch (Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ["status" => 500, "message" => $exception->getMessage()]);
        }
    }

    public function actionAuthorisedApprove()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        if (!isset($params["type"]) || empty($params["cash_id"])) {
            return $this->response(422, ["status" => 422, "message" => "missing parameter 'type or cash_id'"]);
        }
        $cash_id = $params['cash_id'];
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($params["type"]) {
                $update = EmployeesCashReportExtended::findOne(["cash_report_enc_id" => $cash_id]);
                $update->status = 1;
                $update->approved_on = date('Y-m-d H:i:s');
                $update->approved_by = $this->user->user_enc_id;
                $update->remaining_amount = 0;
                if (!$update->save()) {
                    return $this->response(500, ["message" => "an error occurred", "error" => implode(", ", array_column($update->errors, "0", false))]);
                }
                self::updateEmiStatus($params["cash_id"], $user->user_enc_id, "paid");
            } else {
                $this->reject($this->user->user_enc_id, $cash_id);
            }
            $transaction->commit();
            return $this->response(200, ["message" => "updated successfully"]);
        } catch (Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ["message" => "an error occurred", "error" => $exception->getMessage()]);
        }
    }

    private function updateEmiStatus($cash_ids, $user_id, $status): void
    {
        $emi_ids = [];
        $overdue_update = $status == 'paid';
        foreach (explode(',', $cash_ids) as $cash_id) {
            $find = EmployeesCashReportExtended::findOne(["cash_report_enc_id" => $cash_id]);
            if (!empty($find['emi_collection_enc_id'])) {
                $emi_id = [$find['emi_collection_enc_id']];
            } else {
                // emi ids can be more than 1 so using updating function to track everything
                $emi_id = $this->finder($cash_id);
                $emi_id = array_column($emi_id,"emi_collection_enc_id");
            }
            if ($overdue_update) {
                $emi = EmiCollection::findOne(["emi_collection_enc_id" => $emi_id]);
                if ($emi){
                    EmiCollectionForm::updateOverdue($emi['loan_account_enc_id'], $emi['amount'], $user_id);
                }
            }
            $emi_ids = array_merge($emi_ids, $emi_id);
        }
        $updates = [
            "emi_payment_status" => $status,
            "updated_on" => date("Y-m-d H:i:s"),
            "updated_by" => $user_id
        ];
        $where = ["emi_collection_enc_id" => array_unique($emi_ids)];
        UserUtilities::updating("emi", "emi_collection_enc_id", $where, $updates);
    }

    public function actionApproveByEmployeeList()
    {
        $this->isAuth();
        $query = EmployeesCashReportExtended::find()
            ->alias("a")
            ->select(["a.remaining_amount", "a.emi_collection_enc_id", "a.cash_report_enc_id",
                "CONCAT(c.first_name, ' ', COALESCE(c.last_name, '')) AS received_from"])
            ->joinWith(["emiCollectionEnc b" => function ($b) {
                $b->select([
                    "b.emi_collection_enc_id", "b.loan_account_number", "b.customer_name",
                    "b.loan_type", "b.emi_collection_enc_id", "b.amount"
                ]);
            }])
            ->joinWith(['receivedFrom c'], false)
            ->andWhere(["AND",
                ["a.given_to" => $this->user->user_enc_id],
                ["a.is_deleted" => 0],
                ["a.parent_cash_report_enc_id" => null],
                ["NOT",
                    ["a.remaining_amount" => 0]],
                ['a.status' => 2],
                ['a.type' => 2]])
            ->asArray()
            ->all();
        if (!$query) {
            return $this->response(404, ["status" => 404, "message" => "no data found"]);
        }

        foreach ($query as &$item) {
            if (empty($item['emiCollectionEnc'])) {
                $item['emiCollectionEnc'] = $this->finder($item['cash_report_enc_id']);
            }
        }
        return $this->response(200, ["status" => 200, "data" => $query]);
    }

    public function actionApproveByEmployee()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        if (!isset($params["type"]) || empty($params["cash_id"])) {
            return $this->response(422, ["status" => 422, "message" => "missing parameter 'type' or 'cash_id'"]);
        }
        $cash_id = $params["cash_id"];
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($params["type"]) {
                $update = EmployeesCashReportExtended::findOne(["cash_report_enc_id" => $cash_id, "given_to" => $user->user_enc_id]);
                $update->status = 1;
                $update->approved_on = date('Y-m-d H:i:s');
                $update->approved_by = $user->user_enc_id;
                if (!$update->save()) {
                    throw new \yii\db\Exception(implode(", ", array_column($update->errors, "0", false)));
                }
            } else {
                $this->reject($user->user_enc_id, $cash_id);
            }
            $transaction->commit();
            return $this->response(200, ["message" => "approved successfully"]);
        } catch (Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ["message" => "an error occurred", "error" => $exception->getMessage()]);
        }
    }

    private function reject($user_id, $cash_id): void
    {
        $query = EmployeesCashReportExtended::find()
            ->alias('a')
            ->select(['cash_report_enc_id', 'amount'])
            ->andWhere(['parent_cash_report_enc_id' => $cash_id])
            ->asArray()
            ->all();
        foreach ($query as $item) {
            $q = EmployeesCashReportExtended::findOne(['cash_report_enc_id' => $item['cash_report_enc_id']]);
            $q->updated_by = $user_id;
            $q->updated_on = date("Y-m-d H:i:s");
            $q->remaining_amount = $item['amount'];
            $q->parent_cash_report_enc_id = null;
            if (!$q->save()) {
                throw new \Exception(implode(", ", array_column($q->errors, "0", false)));
            }
        }
        $reject = EmployeesCashReportExtended::findOne(['cash_report_enc_id' => $cash_id]);
        $reject->status = 3;
        $reject->updated_by = $user_id;
        $reject->updated_on = date("Y-m-d H:i:s");
        if (!$reject->save()) {
            throw new \Exception(implode(", ", array_column($reject->errors, "0", false)));
        }
    }


    // this api was shifted from org controller to emi controller on 13 Dec
    public function actionGetCollectedEmiList()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        $search = '';
        if (empty($params['organization_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "organization_id"']);
        }
        if (isset($params['fields_search'])) {
            $search = $params['fields_search'];
        }

        $org_id = $params['organization_id'];
        $model = $this->_emiData($org_id, 0, $search, $user);
        $count = $model['count'];
        if (!$count > 0) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }
        return $this->response(200, ['status' => 200, 'data' => $model['data'], 'count' => $count]);
    }

    public function actionEmiDetail()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        if (empty($params['emi_collection_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "emi_collection_enc_id"']);
        }
        $lac = EmiCollectionExtended::findOne(['emi_collection_enc_id' => $params['emi_collection_enc_id']])['loan_account_number'];
        $model = $this->_emiData($lac, 1, '', $user)['data'];
        if (!$model) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }

        $display_data = EmiCollectionExtended::find()
            ->alias('a')
            ->select([
                'ANY_VALUE(a.customer_name) customer_name', 'ANY_VALUE(a.loan_account_number) loan_account_number',
                'ANY_VALUE(a.loan_type) loan_type', 'ANY_VALUE(a.phone) phone', 'SUM(a.amount) total_amount',
                'COUNT(a.loan_account_number) as total_emis',
                "CONCAT(ANY_VALUE(b.location_name) , ', ', COALESCE(ANY_VALUE(b1.name), '')) as branch_name",
                "SUM(CASE WHEN a.emi_payment_status != 'paid' THEN a.amount END) as pending_amount",
                "SUM(CASE WHEN a.emi_payment_status = 'paid' THEN a.amount END) as paid_amount",
            ])
            ->joinWith(['branchEnc b' => function ($b) {
                $b->joinWith(['cityEnc b1'], false);
            }], false)
            ->where(['a.loan_account_number' => $lac, 'a.is_deleted' => 0])
            ->groupBy(['a.loan_account_number'])
            ->asArray()
            ->one();
        return $this->response(200, ['status' => 200, 'display_data' => $display_data, 'data' => $model]);
    }

    public static function _emiData($data, $id_type, $search = '', $user = null)
    {
        function payment_method_add($data)
        {
            if (in_array(4, $data)) {
                $data[] = 81;
            }
            if (in_array(5, $data)) {
                $data[] = 82;
            }
            if (in_array(1, $data)) {
                $data[] = 9;
            }
            return $data;
        }

        // if id_type = 1 then loan account number if id_type = 0 then organization id, this function is being used for GetCollectedEmiList and EmiDetail
        if ($id_type == 1) {
            $lac = $data;
        }
        if ($id_type == 0) {
            $org_id = $data;
        }
        $params = Yii::$app->request->post();
        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $payment_methods = EmiCollectionForm::$payment_methods;
        $payment_modes = EmiCollectionForm::$payment_modes;
        $model = EmiCollectionExtended::find()
            ->alias('a')
            ->select([
                'a.emi_collection_enc_id', "CONCAT(c.location_name , ', ', COALESCE(c1.name, '')) as branch_name", 'a.customer_name', 'a.collection_date',
                'a.loan_account_number', 'a.phone', 'a.amount', 'a.loan_type', 'a.loan_purpose', 'a.emi_payment_method', 'a.emi_payment_mode',
                'a.ptp_amount', 'a.ptp_date', 'b1a.designation', "CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')) name",
                "CASE WHEN a.other_delay_reason IS NOT NULL THEN CONCAT(a.delay_reason, ',',a.other_delay_reason) ELSE a.delay_reason END AS delay_reason",
                "CASE WHEN a.borrower_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->borrower_image->image . "',a.borrower_image_location, '/', a.borrower_image) ELSE NULL END as borrower_image",
                "CASE WHEN a.pr_receipt_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image . "',a.pr_receipt_image_location, '/', a.pr_receipt_image) ELSE NULL END as pr_receipt_image",
                "CASE WHEN a.other_doc_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->other_doc_image->image . "',a.other_doc_image_location, '/', a.other_doc_image) ELSE NULL END as other_doc_image",
                "CONCAT(a.address,', ', COALESCE(a.pincode, '')) address", "CONCAT(b.first_name , ' ', COALESCE(b.last_name, '')) as collected_by", 'a.created_on',
                "CONCAT('http://maps.google.com/maps?q=', a.latitude, ',', a.longitude) AS link",
                'a.comments', 'a.emi_payment_status', 'a.reference_number', 'a.dealer_name', 'd1.payment_short_url'
            ])
            ->joinWith(['createdBy b' => function ($b) {
                $b->joinWith(['userRoles0 b1' => function ($b1) {
                    $b1->joinWith(['designation b1a'], false);
                }], false);
            }], false)
            ->joinWith(['branchEnc c' => function ($c) {
                $c->joinWith(['cityEnc c1'], false);
            }], false)
            ->joinWith(['assignedLoanPayments d' => function ($d) {
                $d->joinWith(['loanPaymentsEnc d1'], false);
            }], false)
            ->orderBy(['a.created_on' => SORT_DESC])
            ->andWhere(['a.is_deleted' => 0]);

        if (isset($org_id)) {
            $model->andWhere(['or', ['b.organization_enc_id' => $org_id], ['b1.organization_enc_id' => $org_id]]);
        }
        if (empty($user->organization_enc_id) && !in_array($user->username, ['nisha123', 'rajniphf', 'KKB', 'phf604'])) {
            $juniors = UserUtilities::getting_reporting_ids($user->user_enc_id, 1);
            $model->andWhere(['IN', 'a.created_by', $juniors]);
        }
        if (isset($lac)) {
            $model->andWhere(['a.loan_account_number' => $lac]);
        }

        if (!empty($params['ptpstatus'])) {
            $model->andWhere(["NOT", "a.ptp_date", NULL]);
        }
        if (!empty($params['custom_method'])) {
            $model->andWhere(['a.emi_payment_method' => payment_method_add($params['custom_method'])]);
        }
        if (!empty($params['custom_status'])) {
            $model->andWhere(['IN', 'a.emi_payment_status', $params['custom_status']]);
        }
        if (!empty($search)) {
            $a = ['loan_account_number', 'customer_name', 'amount', 'ptp_amount', 'address', 'collection_date', 'loan_type', 'emi_payment_method', 'ptp_date', 'emi_payment_status', 'collection_start_date', 'collection_end_date', 'delay_reason', 'start_date', 'end_date'];
            $others = ['collected_by', 'branch', 'designation', 'payment_status', 'ptp_status'];
            foreach ($search as $key => $value) {
                if (!empty($value) || $value == '0') {
                    if (in_array($key, $a)) {

                        switch ($key) {
                            case 'collection_start_date':
                                $model->andWhere(['>=', 'a.collection_date', $value]);
                                break;
                            case 'collection_end_date':
                                $model->andWhere(['<=', 'a.collection_date', $value]);
                                break;
                            case 'loan_type':
                                $model->andWhere(['a.loan_type' => $value]);
                                break;
                            case 'customer_name':
                                $model->andWhere(['like', 'a.customer_name', $value . '%', false]);
                                break;
                            case 'emi_payment_status':
                                $model->andWhere(['IN', 'a.emi_payment_status', $value]);
                                break;
                            case 'delay_reason':
                                $where = ["OR"];
                                foreach ($value as $item) {
                                    $where[] = ["LIKE", "a.delay_reason", $item];
                                    $where[] = ["LIKE", "a.other_delay_reason", $item];
                                }
                                $model->andWhere($where);
                                break;
                            case 'amount':
                                $model->andWhere(['like', 'a.amount', $value . '%', false]);
                                break;
                            case 'address':
                                $model->andWhere(['like', "CONCAT(a.address,', ', COALESCE(a.pincode, ''))", $value]);
                                break;
                            case 'ptp_amount':
                                $model->andWhere(['like', 'a.ptp_amount', $value . '%', false]);
                                break;
                            case 'start_date':
                                $model->andWhere(['>=', 'a.ptp_date', $value]);
                                break;
                            case 'end_date':
                                $model->andWhere(['<=', 'a.ptp_date', $value]);
                                break;
                            case 'emi_payment_method':
                                $model->andWhere(['IN', 'a.' . $key, payment_method_add($value)]);
                        }
                    }
                    if (in_array($key, $others)) {
                        if ($key == 'collected_by') {
                            $model->andWhere(['like', "CONCAT(b.first_name , ' ', COALESCE(b.last_name, ''))", $value]);
                        } elseif ($key == 'branch') {
                            $model->andWhere(['c.location_enc_id' => $value]);
                        } elseif ($key == 'designation') {
                            $model->andWhere(['like', 'b1a.' . $key, $value]);
                        } elseif ($key == 'ptp_status') {
                            $model->andWhere([$value == 'yes' ? 'not in' : 'in', 'a.ptp_amount', [null, '']]);
                        }
                    }
                }
            }
        }
        $count = $model->count();

        $model = $model
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        foreach ($model as $key => $value) {
            $model[$key]['emi_payment_method'] = $payment_methods[$value['emi_payment_method']];
            $model[$key]['emi_payment_mode'] = $payment_modes[$value['emi_payment_mode']];
            if ($value['other_doc_image']) {
                $proof = $my_space->signedURL($value['other_doc_image'], "15 minutes");
                $model[$key]['other_doc_image'] = $proof;
            }
            if ($value['borrower_image']) {
                $proof = $my_space->signedURL($value['borrower_image'], "15 minutes");
                $model[$key]['borrower_image'] = $proof;
            }
            if ($value['pr_receipt_image']) {
                $proof = $my_space->signedURL($value['pr_receipt_image'], "15 minutes");
                $model[$key]['pr_receipt_image'] = $proof;
            }
        }
        return ['data' => $model, 'count' => $count];
    }

    public function actionUpdate()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        if ((empty($params['collection_date']) && empty($params['amount'])) || empty($params['remarks']) || empty($params['emi_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "collection_date" or "amount" or "remarks" or "emi_id"']);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!empty($params['collection_date']) && !empty($params['amount'])) {
                throw new Exception("You can not update collection date and amount both at same time");
            }
            $emi_id = $params['emi_id'];
            $emi = EmiCollectionExtended::findOne(['emi_collection_enc_id' => $emi_id, 'is_deleted' => 0]);
            if (!$emi) {
                $this->response(404, ['message' => 'an error occurred', 'error' => 'emi not found']);
            }
            if ($emi->emi_payment_status !== 'collected') {
                throw new Exception("Emi is only updatable when the status is in collected form.");
            }
            if (!empty($params['collection_date'])) {
                $emi->collection_date = $params['collection_date'];
            }
            if (!empty($params['amount'])) {
                $emi->amount = $params['amount'];
            }
            $emi->updated_on = date('Y-m-d H:i:s');
            $emi->updated_by = $user->user_enc_id;
            if (!$emi->save()) {
                throw new Exception(implode(',', array_column($emi->errors, "0")));
            }
            $audit = new LoanAuditTrail();

            $audit->old_value = "";
            $audit->new_value = $params['remarks'];
            $audit->action = "SET";
            $audit->model = "EmiCollection";
            $audit->field = "remarks";
            $audit->stamp = date('Y-m-d H:i:s');
            $audit->user_id = (string)Yii::$app->user->identity->id;
            $audit->model_id = (string)$emi->id;
            $audit->foreign_id = $emi_id;
            if (!$audit->save()) {
                throw new Exception(implode(',', array_column($audit->errors, "0")));
            }
            if (!empty($params['amount'])) {
                $cash = EmployeesCashReportExtended::findOne(['emi_collection_enc_id' => $emi_id, "parent_cash_report_enc_id" => null, "is_deleted" => 0]);
                if (!$cash) {
                    throw new Exception("an error occurred");
                }
                $cash->remaining_amount = $cash->amount = $params['amount'];
                $cash->updated_on = date('Y-m-d H:i:s');
                $cash->updated_by = $user->user_enc_id;
                if (!$cash->save()) {
                    throw new Exception(implode(',', array_column($cash->errors, "0")));
                }
            }
            $transaction->commit();
            return $this->response(200, ["message" => "updated successfully"]);
        } catch (Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['message' => 'an error occurred', 'error' => $exception->getMessage()]);
        }


    }
}
