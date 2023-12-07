<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\EmiCollectionForm;
use api\modules\v4\utilities\UserUtilities;
use common\models\EmiCollection;
use common\models\EmployeesCashReport;
use common\models\extended\EmiCollectionExtended;
use common\models\extended\EmployeesCashReportExtended;
use common\models\extended\LoanAccountsExtended;
use common\models\LoanAccounts;
use Exception;
use Yii;
use yii\db\Expression;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;

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

    public
    function actionEmployeeEmiCollection()
    {
        $this->isAuth();
        $params = $this->post;
        $user_id = $params["user_id"];
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
            ])
            ->asArray()
            ->all();
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
        foreach ($received_cash as &$cash) {
            if (empty($cash["emiCollectionEnc"])) {
                $cash["emiCollectionEnc"] = $this->finder($cash["cash_report_enc_id"]);
            }
        }
        $display_data["total_sum"] = $display_data["emi"] + $display_data["cash"];
        return $this->response(200, ["status" => 200, "data" => $query, "display_data" => $display_data, "received_cash" => $received_cash]);
    }

    private function finder($parent): array
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

    public function actionPendingApprovals()
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
            $item['receipt'] = $my_space->signedURL($item['receipt'], "15 minutes");
        }
        return $this->response(200, ["status" => 200, "data" => $approval]);
    }

    private function received_cash($user_id, $parent = ""): array
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

    public function actionCollectCash()
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

    public
    function actionAuthorisedApprove()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        if (!isset($params["type"]) || empty($params["cash_id"])) {
            return $this->response(422, ["status" => 422, "message" => "missing parameter 'type or cash_id'"]);
        }
        $cash_id = $params['cash_id'];
        if ($params["type"]) {
            Yii::$app->db->createCommand()->update(
                EmployeesCashReportExtended::tableName(),
                [
                    "status" => 1,
                    "approved_on" => date('Y-m-d H:i:s'),
                    "approved_by" => $this->user->user_enc_id,
                    "remaining_amount" => 0
                ],
                [
                    "cash_report_enc_id" => $cash_id
                ]
            )->execute();
            self::updateEmiStatus($params['cash_id'], $user->user_enc_id, 'paid');
        } else {

            $this->reject($this->user->user_enc_id, $cash_id);
        }
        return $this->response(200);
    }

    private function updateEmiStatus($cash_ids, $user_id, $status): void
    {
        foreach (explode(',', $cash_ids) as $cash_id) {
            $find = EmployeesCashReport::findOne(["cash_report_enc_id" => $cash_id]);
            if (!empty($find['emi_collection_enc_id'])) {
                $emi_id = $find['emi_collection_enc_id'];
            } else {
                $emi_id = $this->finder($cash_id);
            }
            Yii::$app->db->createCommand()->update(EmiCollection::tableName(), [
                "emi_payment_status" => $status,
                "updated_on" => date("Y-m-d H:i:s"),
                "updated_by" => $user_id
            ], [
                "emi_collection_enc_id" => $emi_id
            ])->execute();
        }
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

    public
    function actionApproveByEmployee()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        if (!isset($params["type"]) || empty($params["cash_id"])) {
            return $this->response(422, ["status" => 422, "message" => "missing parameter 'type or cash_id'"]);
        }
        $cash_id = $params["cash_id"];
        if ($params["type"]) {
            Yii::$app->db->createCommand()->update(
                EmployeesCashReportExtended::tableName(),
                [
                    "status" => 1,
                    "approved_on" => date('Y-m-d H:i:s'),
                    "approved_by" => $user->user_enc_id,
                ],
                [
                    "cash_report_enc_id" => $cash_id,
                    "given_to" => $user->user_enc_id
                ]
            )->execute();
        } else {
            $this->reject($user->user_enc_id, $cash_id);
        }

        return $this->response(200);
    }

    private
    function reject($user_id, $cash_id): void
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
                throw new \Exception("error occurred while rejecting");
            }
        }
        $reject = EmployeesCashReportExtended::findOne(['cash_report_enc_id' => $cash_id]);
        $reject->status = 3;
        $reject->updated_by = $user_id;
        $reject->updated_on = date("Y-m-d H:i:s");
        if (!$reject->save()) {
            throw new \Exception("error occurred while rejecting");
        }
    }
}
