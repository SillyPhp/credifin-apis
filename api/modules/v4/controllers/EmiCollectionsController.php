<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\EmiCollectionForm;
use api\modules\v4\utilities\ArrayProcessJson;
use api\modules\v4\utilities\UserUtilities;
use common\models\EmiCollection;
use common\models\EmployeesCashReport;
use common\models\extended\EmiCollectionExtended;
use common\models\extended\EmployeesCashReportExtended;
use common\models\extended\UsersExtended;
use common\models\LoanAccounts;
use common\models\spaces\Spaces;
use common\models\UserRoles;
use common\models\Users;
use common\models\Utilities;
use Exception;
use Yii;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;

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
                "update-emi-number" => ["POST", "OPTIONS"],
                "ptp-emi" => ["POST", "OPTIONS"],
                "update-payment-method" => ["POST", "OPTIONS"],
                "employee-cash-stats" => ["POST", "OPTIONS"],
                "collection-daily-stats" => ["POST", "OPTIONS"],
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
        if (empty($params["start_date"]) || empty($params["end_date"])) {
            return $this->response(500, ["error" => "'start date' or 'end date' missing"]);
        }
        $start_date = strtotime($params["start_date"]);
        $end_date = strtotime($params["end_date"]);
        if ($start_date === $end_date) {
            $end_date += (24 * 60 * 60) - 1;
        } else if ($end_date <= $start_date) {
            return $this->response(500, ["error" => "end date must be greater than start date"]);
        }
        $query = EmiCollection::find()
            ->alias("a")
            ->select([
                "a.emi_collection_enc_id AS collection_id",
                "a.loan_account_number AS file_number",
                "(CASE WHEN b.case_no IS NOT NULL THEN b.case_no ELSE a.case_no END) AS loan_account_number",
                "TRIM(a.customer_name) AS customer_name",
                "a.phone as collected_emi_phone",
                "a.amount collected_amount",
                "a.emi_payment_method",
                "COALESCE(b.loan_type, a.loan_type) AS loan_type",
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
                "(CASE WHEN b.company_id IS NOT NULL THEN b.company_id ELSE a.company_id END) AS company_id",
                "b.phone",
                "CONCAT(cb.first_name, ' ', COALESCE(cb.last_name,'')) collected_by",
                "br.location_name as branch",
                "a.updated_on AS approved_on"
            ])
            ->innerJoinWith(["createdBy cb"], false)
            ->innerJoinWith(["branchEnc br"], false)
            ->joinWith(["loanAccountEnc b"], false)
            ->joinWith(["assignedLoanPayments c" => function ($c) {
                $c->andOnCondition(["IS NOT", "c.emi_collection_enc_id", null]);
                $c->joinWith(["loanPaymentsEnc c1" => function ($c1) {
                    $c1->andOnCondition(["c1.payment_status" => "captured"]);
                }], false);
            }], false)
            ->andWhere(["a.is_deleted" => 0, "a.emi_payment_status" => !empty($params['status']) ? $params['status'] : "paid"])
            ->andWhere(["BETWEEN", "UNIX_TIMESTAMP(a.updated_on)", $start_date, $end_date])
            ->asArray()
            ->all();
        $payment_methods = EmiCollectionForm::$payment_methods;
        $query = array_map(function ($e) use ($payment_methods) {
            $e["emi_payment_method"] = $payment_methods[$e["emi_payment_method"]];
            return $e;
        }, $query);
        return $this->response(200, ["data" => $query]);
    }

    public function actionGetTelecallersList()
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
        if (empty($params["start_date"]) || empty($params["end_date"])) {
            return $this->response(500, ["error" => "'start date' or 'end date' missing"]);
        }
        $start_date = strtotime($params["start_date"]);
        $end_date = strtotime($params["end_date"]);
        if ($start_date === $end_date) {
            $end_date += (24 * 60 * 60) - 1;
        } else if ($end_date <= $start_date) {
            return $this->response(500, ["error" => "end date must be greater than start date"]);
        }
        $query = EmiCollection::find()
            ->alias("a")
            ->select([
                "a.emi_collection_enc_id AS collection_id",
                "a.loan_account_number AS file_number",
                "b.lms_loan_account_number AS loan_account_number",
                "TRIM(a.customer_name) AS customer_name",
                "a.phone as collected_emi_phone",
                "a.amount collected_amount",
                "a.emi_payment_method",
                "COALESCE(b.loan_type, a.loan_type) AS loan_type",
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
                "b.phone",
                "CONCAT(cb.first_name, ' ', COALESCE(cb.last_name,'')) collected_by",
                "br.location_name as branch"
            ])
            ->innerJoinWith(["createdBy cb" => function ($cb) {
                $cb->innerJoinWith(["userRoles0 ur" => function ($ur) {
                    $ur->andOnCondition(['in', 'designation_id', ['39pOaLxn1RyA6ewg0m14RwrK85kq6m', 'jE3DW981MQMDwAbvpx1Vdl5zrZyBag']]);
                }], false);
            }], false)
            ->innerJoinWith(["branchEnc br"], false)
            ->joinWith(["loanAccountEnc b"], false)
            ->joinWith(["assignedLoanPayments c" => function ($c) {
                $c->andOnCondition(["IS NOT", "c.emi_collection_enc_id", null]);
                $c->joinWith(["loanPaymentsEnc c1" => function ($c1) {
                    $c1->andOnCondition(["c1.payment_status" => "captured"]);
                }], false);
            }], false)
            ->andWhere(["a.is_deleted" => 0]);
        if (!empty($params['status'])) {
            $query->andWhere(["a.emi_payment_status" => $params['status']]);
        }
        $query = $query->andWhere(["BETWEEN", "UNIX_TIMESTAMP(a.collection_date)", $start_date, $end_date])
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

        $subquery1 = (new Query())
            ->select([
                "a.given_to",
                "SUM(CASE WHEN a.status = 0 AND type = 0 THEN a.remaining_amount END) collected_cash",
                "SUM(CASE WHEN a.status = 1 AND type = 2 THEN a.remaining_amount END) received_cash",
                "SUM(CASE WHEN a.status = 2 AND type = 2 THEN a.remaining_amount END) received_pending_cash"
            ])
            ->from(["a" => EmployeesCashReport::tableName()])
            ->andWhere([
                "AND",
                ["!=", "a.remaining_amount", 0],
                ["a.parent_cash_report_enc_id" => null],
                ["a.is_deleted" => 0],
                ["IS NOT", "a.given_to", null],
                ["!=", "a.status", 3],
                ["IN", "a.type", [0, 2]]
            ])
            ->groupBy(["a.given_to"]);
        $subquery2 = (new Query())
            ->select([
                "a.received_from",
                "SUM(a.remaining_amount) AS bank_unapproved_cash"
            ])
            ->from(["a" => EmployeesCashReport::tableName()])
            ->andWhere([
                "AND",
                ["!=", "a.remaining_amount", 0],
                ["a.parent_cash_report_enc_id" => null],
                ["a.is_deleted" => 0],
                ["!=", "a.status", 3],
                ["a.status" => 2],
                ["a.type" => 1]
            ])
            ->groupBy(["a.received_from"]);
        $fields_search = [];
        if (!empty($params['fields_search'])) {
            foreach ($params['fields_search'] as $key => $value) {
                if (!empty($value) || $value == '0') {
                    switch ($key) {
                        case 'employee_code':
                            $fields_search[] = "ANY_VALUE(b1.employee_code) LIKE '%$value%'";
                            break;
                        case 'name':
                            $fields_search[] = "CONCAT(a.first_name, ' ', COALESCE(a.last_name, '')) LIKE '%$value%'";
                            break;
                        case 'reporting_person':
                            $fields_search[] = "CONCAT(ANY_VALUE(b3.first_name), ' ', COALESCE(ANY_VALUE(b3.last_name), '')) LIKE '%$value%'";
                            break;
                        case 'designation':
                            $fields_search[] = "ANY_VALUE(b2.designation) LIKE '%$value%'";
                            break;
                        case 'phone':
                            $fields_search[] = "ANY_VALUE(a.phone) LIKE '%$value%'";
                            break;
                        case 'branch':
                            $branch = "('" . implode("','", $value) . "')";
                            $fields_search[] = "ANY_VALUE(b4.location_enc_id) IN $branch";
                            break;
                    }
                }
            }
            $fields_search = implode(" AND ", $fields_search);
        }
        $users = UsersExtended::find()
            ->alias('a')
            ->select([
                'a.user_enc_id AS user_id',
                "CONCAT(a.first_name, ' ', COALESCE(a.last_name, '')) name",
                "ANY_VALUE(b1.employee_code) employee_code",
                "ANY_VALUE(b2.designation) designation",
                "CONCAT(ANY_VALUE(b3.first_name), ' ', COALESCE(ANY_VALUE(b3.last_name), '')) reporting_person",
                "ANY_VALUE(b4.location_name) location_name", "ANY_VALUE(a.phone) phone", "a.email", 'COALESCE(ANY_VALUE(subquery.collected_cash), 0) collected_cash',
                'COALESCE(ANY_VALUE(subquery.received_cash), 0) received_cash',
                'COALESCE(ANY_VALUE(subquery.received_pending_cash), 0) received_pending_cash',
                'COALESCE(ANY_VALUE(subquery2.bank_unapproved_cash), 0) bank_unapproved_cash',
                'ANY_VALUE(b4.location_enc_id) branch_enc_id'
            ])
            ->joinWith(["userRoles0 b1" => function ($b1) {
                $b1->joinWith(["designation b2"], false);
                $b1->joinWith(["reportingPerson b3"], false);
                $b1->joinWith(["branchEnc b4"], false);
            }], false)
            ->joinWith(["employeesCashReports3 c" => function ($c) use ($subquery1) {
                $c->from(["subquery" => $subquery1]);
            }])
            ->joinWith(["employeesCashReports2 d" => function ($d) use ($subquery2) {
                $d->from(["subquery2" => $subquery2]);
            }])
            ->andWhere([
                "OR",
                ["IS NOT", "subquery.given_to", NULL],
                ["IS NOT", "subquery2.received_from", NULL]
            ])
            ->andWhere($fields_search)
            ->groupBy(['a.user_enc_id']);
        $count = $users->count();
        $users = $users
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();
        if (!$users) {
            return $this->response(404, ["message" => "not found"]);
        }

        return $this->response(200, ["status" => 200, "data" => $users, "count" => $count]);
    }

    public function actionEmployeeCashStats()
    {
        $this->isAuth();
        $user = $this->user;
        $params = $this->post;
        $limit = !empty($params["limit"]) ? $params["limit"] : 10;
        $page = !empty($params["page"]) ? $params["page"] : 1;
        $juniors = UserUtilities::getting_reporting_ids($user->user_enc_id, 1);
        $currentUser = [$user->user_enc_id];
        $juniors = array_diff($juniors, $currentUser);
        $subquery1 = (new Query())
            ->select([
                "a.given_to",
                "SUM(CASE WHEN a.status = 0 AND type = 0 THEN a.remaining_amount END) collected_cash",
                "SUM(CASE WHEN a.status = 1 AND type = 2 THEN a.remaining_amount END) received_cash",
                //                "SUM(CASE WHEN a.status = 2 AND type = 2 THEN a.remaining_amount END) received_pending_cash"
            ])
            ->from(["a" => EmployeesCashReport::tableName()])
            ->andWhere([
                "AND",
                ["!=", "a.remaining_amount", 0],
                ["a.parent_cash_report_enc_id" => null],
                ["a.is_deleted" => 0],
                ["IS NOT", "a.given_to", null],
                ["!=", "a.status", 3],
                ["IN", "a.type", [0, 2]]
            ])
            ->groupBy(["a.given_to"]);
        $subquery2 = (new Query())
            ->select([
                "a.received_from",
                "SUM(a.remaining_amount) AS bank_unapproved_cash"
            ])
            ->from(["a" => EmployeesCashReport::tableName()])
            ->andWhere([
                "AND",
                ["!=", "a.remaining_amount", 0],
                ["a.parent_cash_report_enc_id" => null],
                ["a.is_deleted" => 0],
                ["!=", "a.status", 3],
                ["a.status" => 2],
                ["a.type" => 1]
            ])
            ->groupBy(["a.received_from"]);
        $fields_search = [];
        if (!empty($params['fields_search'])) {
            foreach ($params['fields_search'] as $key => $value) {
                if (!empty($value) || $value == '0') {
                    switch ($key) {
                        case 'employee_code':
                            $fields_search[] = "ANY_VALUE(b1.employee_code) LIKE '%$value%'";
                            break;
                        case 'name':
                            $fields_search[] = "CONCAT(a.first_name, ' ', COALESCE(a.last_name, '')) LIKE '%$value%'";
                            break;
                        //                        case 'reporting_person':
                        //                            $fields_search[] = "CONCAT(ANY_VALUE(b3.first_name), ' ', COALESCE(ANY_VALUE(b3.last_name), '')) LIKE '%$value%'";
                        //                            break;
                        case 'designation':
                            $fields_search[] = "ANY_VALUE(b2.designation) LIKE '%$value%'";
                            break;
                        case 'phone':
                            $fields_search[] = "ANY_VALUE(a.phone) LIKE '%$value%'";
                            break;
                        //                        case 'branch':
                        //                            $branch = "('" . implode("','", $value) . "')";
                        //                            $fields_search[] = "ANY_VALUE(b4.location_enc_id) IN $branch";
                        //                            break;
                    }
                }
            }
            $fields_search = implode(" AND ", $fields_search);
        }
        $users = UsersExtended::find()
            ->alias('a')
            ->select([
                'a.user_enc_id AS user_id',
                "CONCAT(a.first_name, ' ', COALESCE(a.last_name, '')) name",
                "ANY_VALUE(b1.employee_code) employee_code",
                "ANY_VALUE(b2.designation) designation",
                "ANY_VALUE(a.phone) phone", 'COALESCE(ANY_VALUE(subquery.collected_cash), 0) collected_cash',
                "CASE 
                    WHEN a.image IS NOT NULL 
                        THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . "', a.image_location, '/', a.image) 
                        ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(a.first_name, ' ', COALESCE(a.last_name, '')), '&size=200&rounded=false&background=', REPLACE(a.initials_color, '#', ''), '&color=ffffff') 
                    END image",
                'COALESCE(ANY_VALUE(subquery.received_cash), 0) received_cash',
                //                'COALESCE(ANY_VALUE(subquery.received_pending_cash), 0) received_pending_cash',
                //                'COALESCE(ANY_VALUE(subquery2.bank_unapproved_cash), 0) bank_unapproved_cash',
            ])
            ->joinWith(["userRoles0 b1" => function ($b1) {
                $b1->joinWith(["designation b2"], false);
                //                $b1->joinWith(["reportingPerson b3"], false);
                //                $b1->joinWith(["branchEnc b4"], false);
            }], false)
            ->joinWith(["employeesCashReports3 c" => function ($c) use ($subquery1) {
                $c->from(["subquery" => $subquery1]);
            }])
            //            ->joinWith(["employeesCashReports2 d" => function ($d) use ($subquery2) {
            //                $d->from(["subquery2" => $subquery2]);
            //            }])
            ->andWhere([
                "OR",
                ["IS NOT", "subquery.given_to", NULL],
                //                ["IS NOT", "subquery2.received_from", NULL]
            ])
            ->andWhere($fields_search)
            ->andWhere(['IN', 'a.user_enc_id', $juniors])
            ->orderBy(['COALESCE(ANY_VALUE(subquery.collected_cash), 0)' => SORT_DESC])
            ->groupBy(['a.user_enc_id']);
        $count = $users->count();
        $users = $users
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();
        if (!$users) {
            return $this->response(404, ["message" => "not found"]);
        }

        return $this->response(200, ["status" => 200, "data" => $users, "count" => $count]);
    }

    public function actionCashReportStats()
    {
        $this->isAuth();
        $stats = EmployeesCashReport::find()
            ->alias('a')
            ->select([
                "SUM(CASE WHEN a.status = 0 AND type = 0 THEN a.remaining_amount END) collected_cash",
                "SUM(CASE WHEN a.status = 2 AND type = 2 THEN a.remaining_amount END) received_pending_cash",
                "SUM(CASE WHEN a.status = 2 AND a.type =1 THEN a.remaining_amount END) AS bank_unapproved_cash"
            ])
            ->andWhere([
                "AND",
                ["!=", "a.remaining_amount", 0],
                ["a.parent_cash_report_enc_id" => null],
                ["a.is_deleted" => 0],
            ])
            ->asArray()
            ->one();
        return $this->response(200, ['status' => 200, 'data' => $stats]);
    }

    public function actionEmployeeEmiCollection()
    {
        $this->isAuth();
        $params = $this->post;
        $user_id = $params["user_id"];

        $query_data = $this->emiCashReport($user_id);
        $count = $query_data['count'];
        $query = $query_data['query'];

        $data = $this->displayData($user_id);
        $received_cash = $data['received_cash'];
        $display_data = $data['display_data'];

        return $this->response(200, ["status" => 200, 'count' => $count, "data" => $query, "display_data" => $display_data, "received_cash" => $received_cash]);
    }

    private function emiCashReport($user_id)
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
            ->innerJoinWith(["emiCollectionEnc b" => function ($b) {
                $b->andOnCondition(['b.is_deleted' => 0]);
            }], false)
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
                ["!=", "a.remaining_amount", 0],
                ["!=", "a.status", 3],
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
                    "b.loan_type", "b.emi_collection_enc_id", "b.amount",
                    "b.pr_receipt_image", "b.pr_receipt_image_location", "b.collection_date"
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
        $pr_receipt_base = Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image;
        foreach ($approval as &$item) {
            if (empty($item['emiCollectionEnc'])) {
                $item['emiCollectionEnc'] = $this->finder($item['cash_report_enc_id']);
            }
            foreach ($item['emiCollectionEnc'] as &$emi) {
                $image = $emi['pr_receipt_image'];
                if (!empty($image)) {
                    $image_location = $emi['pr_receipt_image_location'];
                    $emi['pr_receipt'] = $my_space->signedURL("$pr_receipt_base$image_location/$image");
                }
                unset($emi['pr_receipt_image'], $emi['pr_receipt_image_location']);
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
                    "c.loan_type", "c.emi_collection_enc_id", "c.amount", "c.pr_receipt_image", "c.pr_receipt_image_location", "c.collection_date"
                ]);
                $c->andOnCondition(['!=', 'c.emi_payment_status', 'rejected']);
                $c->andOnCondition(['c.is_deleted' => 0]);
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
            return $this->response(500, ["status" => 500, "message" => "An error occurred.", "error" => $exception->getMessage()]);
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
                    return $this->response(500, ["message" => "an error occurred", "error" => implode(" ", array_column($update->errors, "0"))]);
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
                $emi_id = array_column($emi_id, "emi_collection_enc_id");
            }
            if ($overdue_update) {
                $emi = EmiCollection::findOne(["emi_collection_enc_id" => $emi_id]);
                if ($emi) {
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
        $user = $this->user;
        $params = $this->post;
        $user_id = $params['user_id'] ?? $user->user_enc_id;
        $query = EmployeesCashReportExtended::find()
            ->alias("a")
            ->select([
                "a.remaining_amount", "a.emi_collection_enc_id", "a.cash_report_enc_id",
                "CONCAT(c.first_name, ' ', COALESCE(c.last_name, '')) AS received_from", "a.created_on"
            ])
            ->joinWith(["emiCollectionEnc b" => function ($b) {
                $b->select([
                    "b.emi_collection_enc_id", "b.loan_account_number", "b.customer_name",
                    "b.loan_type", "b.emi_collection_enc_id", "b.amount"
                ]);
            }])
            ->joinWith(['receivedFrom c'], false)
            ->andWhere([
                "AND",
                ["a.given_to" => $user_id],
                ["a.is_deleted" => 0],
                ["a.parent_cash_report_enc_id" => null],
                [
                    "NOT",
                    ["a.remaining_amount" => 0]
                ],
                ['a.status' => 2],
                ['a.type' => 2]
            ])
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
                    throw new \yii\db\Exception(implode(" ", array_column($update->errors, "0")));
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
                throw new \Exception(implode(" ", array_column($q->errors, "0")));
            }
        }
        $reject = EmployeesCashReportExtended::findOne(['cash_report_enc_id' => $cash_id]);
        $reject->status = 3;
        $reject->updated_by = $user_id;
        $reject->updated_on = date("Y-m-d H:i:s");
        if (!$reject->save()) {
            throw new \Exception(implode(" ", array_column($reject->errors, "0")));
        }
    }


    // this api was shifted from org controller to emi controller on 13 Dec
    public function actionGetCollectedEmiList()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = $this->post;
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
        $model = $this->_emiDataSideBar($lac, 1, '', $user)['data'];
        if (!$model) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }
        $display_data = EmiCollectionExtended::find()
            ->alias('a')
            ->select([
                'a.customer_name', 'a.loan_account_number', 'a.loan_account_enc_id',
                "c.sales_priority",
                "c.collection_priority",
                "c.telecaller_priority",
                'c.sales_target_date', 'c.telecaller_target_date', 'c.collection_target_date',
                "c.bucket AS bucket_value",
                'a.loan_type', 'a.phone', 'SUM(a.amount) OVER(PARTITION BY loan_account_number) total_amount',
                'COUNT(*) OVER(PARTITION BY loan_account_number) AS total_emis',
                "CONCAT(b.location_name, ', ', COALESCE(b2.name, '')) AS branch_name",
                "SUM(CASE WHEN a.emi_payment_status NOT IN ('pending','failed','rejected') AND MONTH(collection_date) = MONTH(CURRENT_DATE()) THEN amount ELSE 0 END) OVER(PARTITION BY loan_account_number) AS collected_amount",
                "SUM(CASE WHEN a.emi_payment_status = 'pending' THEN a.amount END) OVER(PARTITION BY loan_account_number) AS pending_amount",
                "SUM(CASE WHEN a.emi_payment_status NOT IN ('pending','failed','rejected') THEN a.amount END) OVER(PARTITION BY loan_account_number) AS paid_amount",
            ])
            ->joinWith(['branchEnc b' => function ($b) {
                $b->joinWith(['cityEnc b1' => function ($b1) {
                    $b1->joinWith(['stateEnc b2'], false);
                }], false);
            }], false)
            ->joinWith(['loanAccountEnc c'], false)
            ->where(['a.loan_account_number' => $lac, 'a.is_deleted' => 0])
            ->orderBY(['a.id' => SORT_DESC])
            ->limit(1)
            ->asArray()
            ->one();
        return $this->response(200, ['status' => 200, 'display_data' => $display_data, 'data' => $model]);
    }

    public static function _emiDataSideBar($data, $id_type, $search = '', $user = null)
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

        function payment_mode_add($data)
        {
            if (in_array(1, $data)) {
                $data[] = 21;
            }
            if (in_array(2, $data)) {
                $data[] = 22;
            }
            if (in_array(3, $data)) {
                $data[] = 23;
            }
            if (in_array(4, $data)) {
                $data[] = 24;
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
                'a.emi_collection_enc_id', 'a.collection_date', 'a.created_on', 'a.reference_number',
                'a.customer_visit', 'a.customer_interaction',
                'a.phone', 'a.amount', 'a.emi_payment_method', 'a.emi_payment_mode',
                'a.ptp_amount', 'a.ptp_date', "CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')) name",
                "CASE WHEN a.other_delay_reason IS NOT NULL THEN CONCAT(a.delay_reason, ',',a.other_delay_reason) ELSE a.delay_reason END AS delay_reason",
                "CASE WHEN a.borrower_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->borrower_image->image . "',a.borrower_image_location, '/', a.borrower_image) ELSE NULL END as borrower_image",
                "CASE WHEN a.pr_receipt_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image . "',a.pr_receipt_image_location, '/', a.pr_receipt_image) ELSE NULL END as pr_receipt_image",
                "CASE WHEN a.other_doc_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->other_doc_image->image . "',a.other_doc_image_location, '/', a.other_doc_image) ELSE NULL END as other_doc_image",
                "CONCAT(b.first_name , ' ', COALESCE(b.last_name, '')) as collected_by", 'a.created_on',
                "CONCAT('http://maps.google.com/maps?q=', a.latitude, ',', a.longitude) AS link",
                'a.emi_payment_status', 'd1.payment_short_url'
            ])
            ->joinWith(['updatedBy ub'], false)
            ->joinWith(['loanAccountEnc lc'], false)
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
            ->groupBy(['a.emi_collection_enc_id', 'b1a.designation', 'b.user_enc_id', 'd1.payment_short_url'])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->andWhere(['a.is_deleted' => 0]);

        if (isset($org_id)) {
            $model->andWhere(['or', ['b.organization_enc_id' => $org_id], ['b1.organization_enc_id' => $org_id]]);
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
        if (!empty($params['discrepancy_list'])) {
            $model->andWhere(['a.loan_account_enc_id' => null]);
            $model->andWhere("IF(a.emi_payment_mode = 1, a.emi_payment_status != 'pending', TRUE)");
        }
        if (!empty($search)) {
            $a = ['loan_account_number', 'company_id', 'case_no', 'customer_name', 'dealer_name', 'reference_number', 'emi_payment_mode', 'amount', 'ptp_amount', 'address', 'collection_date', 'loan_type', 'emi_payment_method', 'ptp_date', 'emi_payment_status', 'collection_start_date', 'collection_end_date', 'delay_reason', 'start_date', 'end_date'];
            $others = ['collected_by', 'branch', 'designation', 'payment_status', 'ptp_status', 'updated_by', 'updated_on_start_date', 'updated_on_end_date'];
            foreach ($search as $key => $value) {
                if (!empty($value) || $value == '0') {
                    if (in_array($key, $a)) {

                        switch ($key) {
                            case 'collection_start_date':
                                $model->andWhere(['>=', 'a.collection_date', $value]);
                                break;
                            case 'loan_account_number':
                                $model->andWhere(['like', 'a.loan_account_number', $value . '%', false]);
                                break;
                            case 'company_id':
                                $model->andWhere(['like', 'a.company_id', $value . '%', false]);
                                break;
                            case 'case_no':
                                $model->andWhere(['like', 'a.case_no', $value . '%', false]);
                                break;
                            case 'dealer_name':
                                $model->andWhere(['like', 'a.dealer_name', $value . '%', false]);
                                break;
                            case 'reference_number':
                                $model->andWhere(['like', 'a.reference_number', $value . '%', false]);
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
                            case 'emi_payment_mode':
                                $model->andWhere(['IN', 'a.' . $key, payment_mode_add($value)]);
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
                        } elseif ($key == 'updated_by') {
                            $model->andWhere(['like', "CONCAT(ub.first_name, ' ', COALESCE(ub.last_name, ''))", $value]);
                        } elseif ($key == 'updated_on_start_date') {
                            $model->andWhere(['>=', 'a.updated_on', $value]);
                        } elseif ($key == 'updated_on_end_date') {
                            $model->andWhere(['<=', 'a.updated_on', $value]);
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
        foreach ($model as &$value) {
            $value['emi_payment_method'] = $payment_methods[$value['emi_payment_method']];
            $value['emi_payment_mode'] = $payment_modes[$value['emi_payment_mode']];
            if ($value['other_doc_image']) {
                $value['other_doc_image'] = $my_space->signedURL($value['other_doc_image']);
            }
            if ($value['borrower_image']) {
                $value['borrower_image'] = $my_space->signedURL($value['borrower_image']);
            }
            if ($value['pr_receipt_image']) {
                $value['pr_receipt_image'] = $my_space->signedURL($value['pr_receipt_image']);
            }
        }
        return ['data' => $model, 'count' => $count];
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

        function payment_mode_add($data)
        {
            if (in_array(1, $data)) {
                $data[] = 21;
            }
            if (in_array(2, $data)) {
                $data[] = 22;
            }
            if (in_array(3, $data)) {
                $data[] = 23;
            }
            if (in_array(4, $data)) {
                $data[] = 24;
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
                'a.company_id', 'a.case_no', 'a.updated_on', "CONCAT(ub.first_name, ' ', COALESCE(ub.last_name, '')) updated_by",
                'a.emi_collection_enc_id', 'c.location_name as branch_name', 'a.customer_name', 'a.collection_date', 'a.created_on',
                'a.loan_account_number', 'a.loan_account_enc_id', 'a.amount', 'a.loan_type', 'a.emi_payment_method', 'a.emi_payment_mode',
                'a.ptp_amount', 'a.ptp_date', 'b1a.designation', "CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')) name",
                "CASE WHEN a.other_delay_reason IS NOT NULL THEN CONCAT(a.delay_reason, ',',a.other_delay_reason) ELSE a.delay_reason END AS delay_reason",
                "CASE WHEN a.borrower_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->borrower_image->image . "',a.borrower_image_location, '/', a.borrower_image) ELSE NULL END as borrower_image",
                "CASE WHEN a.pr_receipt_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image . "',a.pr_receipt_image_location, '/', a.pr_receipt_image) ELSE NULL END as pr_receipt_image",
                "CASE WHEN a.other_doc_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->other_doc_image->image . "',a.other_doc_image_location, '/', a.other_doc_image) ELSE NULL END as other_doc_image",
                "CONCAT(a.address,', ', COALESCE(a.pincode, '')) address", "CONCAT(b.first_name , ' ', COALESCE(b.last_name, '')) as collected_by", 'a.created_on',
                "b.user_enc_id as collected_by_id", 'c2.name as state_name', 'c2.state_enc_id',
                'a.comments', 'a.emi_payment_status', 'a.reference_number', 'a.dealer_name', 'd1.payment_short_url', 'lc.bucket'
            ])
            ->joinWith(['updatedBy ub'], false)
            ->joinWith(['loanAccountEnc lc' => function ($lc) {
                $lc->joinWith(['assignedLoanAccounts ala' => function ($ala) {
                    $ala->andOnCondition(['ala.is_deleted' => 0]);
                    $ala->joinWith(['sharedTo dd1']);
                }]);
            }])
            ->joinWith(['createdBy b' => function ($b) {
                $b->joinWith(['userRoles0 b1' => function ($b1) {
                    $b1->joinWith(['designation b1a'], false);
                }], false);
            }], false)
            ->joinWith(['branchEnc c' => function ($c) {
                $c->joinWith(['cityEnc c1' => function ($c1) {
                    $c1->joinWith(['stateEnc c2'], false);
                }], false);
            }], false)
            ->joinWith(['assignedLoanPayments d' => function ($d) {
                $d->joinWith(['loanPaymentsEnc d1'], false);
            }], false)
            ->groupBy(['a.emi_collection_enc_id', 'b1a.designation', 'b.user_enc_id', 'd1.payment_short_url'])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->andWhere(['a.is_deleted' => 0]);

        if (isset($org_id)) {
            $model->andWhere(['or', ['b.organization_enc_id' => $org_id], ['b1.organization_enc_id' => $org_id]]);
        }
        if (empty($user->organization_enc_id) && !in_array($user->username, ['nisha123', 'rajniphf', 'KKB', 'phf604', 'wishey', 'Rachyita', 'phf403', 'phf110', 'ghuman'])) {
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
        if (!empty($params['discrepancy_list'])) {
            $model->andWhere(['a.loan_account_enc_id' => null]);
            $model->andWhere("IF(a.emi_payment_mode = 1, a.emi_payment_status != 'pending', TRUE)");
        }
        if (!empty($search)) {
            $a = ['loan_account_number', 'company_id', 'case_no', 'customer_name', 'dealer_name', 'reference_number', 'emi_payment_mode', 'amount', 'ptp_amount', 'address', 'collection_date', 'loan_type', 'emi_payment_method', 'ptp_date', 'emi_payment_status', 'collection_start_date', 'collection_end_date', 'delay_reason', 'start_date', 'end_date'];
            $others = ['collected_by', 'branch', 'designation', 'payment_status', 'state_enc_id', 'ptp_status', 'updated_by', 'updated_on_start_date', 'updated_on_end_date', 'bucket'];
            foreach ($search as $key => $value) {
                if (!empty($value) || $value == '0') {
                    if (in_array($key, $a)) {

                        switch ($key) {
                            case 'collection_start_date':
                                $model->andWhere(['>=', 'a.collection_date', $value]);
                                break;
                            case 'loan_account_number':
                                $model->andWhere(['like', 'a.loan_account_number', $value . '%', false]);
                                break;
                            case 'company_id':
                                $model->andWhere(['like', 'a.company_id', $value . '%', false]);
                                break;
                            case 'case_no':
                                $model->andWhere(['like', 'a.case_no', $value . '%', false]);
                                break;
                            case 'dealer_name':
                                $model->andWhere(['like', 'a.dealer_name', $value . '%', false]);
                                break;
                            case 'reference_number':
                                $model->andWhere(['like', 'a.reference_number', $value . '%', false]);
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
                            case 'emi_payment_mode':
                                $model->andWhere(['IN', 'a.' . $key, payment_mode_add($value)]);
                                break;
                            case 'emi_payment_method':
                                $model->andWhere(['IN', 'a.' . $key, payment_method_add($value)]);
                                break;
                        }
                    }
                    if (in_array($key, $others)) {
                        switch ($key) {
                            case 'collected_by':
                                $model->andWhere(['like', "CONCAT(b.first_name , ' ', COALESCE(b.last_name, ''))", $value]);
                                break;
                            case 'branch':
                                $model->andWhere(['c.location_enc_id' => $value]);
                                break;
                            case 'state_enc_id':
                                $model->andWhere(['IN', "c2.state_enc_id", $value]);
                                break;
                            case 'designation':
                                $model->andWhere(['like', 'b1a.' . $key, $value]);
                                break;
                            case 'ptp_status':
                                $model->andWhere([$value == 'yes' ? 'not in' : 'in', 'a.ptp_amount', [null, '']]);
                                break;
                            case 'updated_by':
                                $model->andWhere(['like', "CONCAT(ub.first_name, ' ', COALESCE(ub.last_name, ''))", $value]);
                                break;
                            case 'updated_on_start_date':
                                $model->andWhere(['>=', 'a.updated_on', $value]);
                                break;
                            case 'updated_on_end_date':
                                $model->andWhere(['<=', 'a.updated_on', $value]);
                                break;
                            case 'bucket':
                                $model->andWhere(['lc.bucket' => $value]);
                                break;
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

        foreach ($model as &$item) {
            $item['assignedLoanAccounts'] = array_map(function ($assignedLoan) {
                $user_type = ($assignedLoan['user_type'] == 1) ? 'bdo' : (($assignedLoan['user_type'] == 2) ? 'collection_manager' : (($assignedLoan['user_type'] == 3) ? 'telecaller' : null));
                $shared_name = $assignedLoan['sharedTo']['first_name'] . ' ' . ($assignedLoan['sharedTo']['last_name'] ?? null);
                if (!empty($assignedLoan['sharedTo']['image'])) {
                    $shared_img = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $assignedLoan['sharedTo']['image_location'] . '/' . $assignedLoan['sharedTo']['image'];
                } else {
                    $shared_img = 'https://ui-avatars.com/api/?name=' . urlencode($assignedLoan['sharedTo']['first_name'] . ' ' . ($assignedLoan['sharedTo']['last_name'] ?? '')) . '&size=200&rounded=false&background=' . str_replace('#', '', $assignedLoan['sharedTo']['initials_color']) . '&color=ffffff';
                }
                return [
                    'id' => $assignedLoan['id'],
                    'assigned_enc_id' => $assignedLoan['assigned_enc_id'],
                    'loan_account_enc_id' => $assignedLoan['loan_account_enc_id'],
                    'access' => $assignedLoan['access'],
                    'name' => $shared_name,
                    'image' => $shared_img,
                    'user_type' => $user_type,
                ];
            }, $item['loanAccountEnc']['assignedLoanAccounts']);
            unset($item['loanAccountEnc']);
        }


        $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        foreach ($model as &$value) {
            $value['emi_payment_method'] = $payment_methods[$value['emi_payment_method']];
            $value['emi_payment_mode'] = $payment_modes[$value['emi_payment_mode']];
            if ($value['other_doc_image']) {
                $value['other_doc_image'] = $my_space->signedURL($value['other_doc_image']);
            }
            if ($value['borrower_image']) {
                $value['borrower_image'] = $my_space->signedURL($value['borrower_image']);
            }
            if ($value['pr_receipt_image']) {
                $value['pr_receipt_image'] = $my_space->signedURL($value['pr_receipt_image']);
            }
        }
        return ['data' => $model, 'count' => $count];
    }

    public function actionUpdate()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        if ((empty($params['collection_date']) && (!isset($params['amount']) || $params['amount'] < 0)) || empty($params['remarks']) || empty($params['emi_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "collection_date" or "amount" or "remarks" or "emi_id"']);
        }
        $transaction = Yii::$app->db->beginTransaction();
        function change_amount($cash_model, $amount, $user_id)
        {
            if ($cash_model->remaining_amount != 0) {
                $cash_model->remaining_amount += $amount;
            }
            $cash_model->amount += $amount;
            $cash_model->updated_on = date('Y-m-d H:i:s');
            $cash_model->updated_by = $user_id;
            if (!$cash_model->save()) {
                throw new Exception(implode(',', array_column($cash_model->errors, "0")));
            }
        }

        try {
            if (!empty($params['collection_date']) && !empty($params['amount'])) {
                throw new Exception("You can not update collection date and amount both at same time");
            }
            $emi_id = $params['emi_id'];
            $emi = EmiCollectionExtended::findOne(['emi_collection_enc_id' => $emi_id, 'is_deleted' => 0]);
            if (!$emi) {
                $this->response(404, ['message' => 'an error occurred', 'error' => 'emi not found']);
            }
            if ($emi->emi_payment_status === 'paid') {
                throw new Exception("Emi is only updatable when the status is not in paid status.");
            }
            if (!empty($params['collection_date'])) {
                $emi->collection_date = $params['collection_date'];
            }
            if (isset($params['amount'])) {
                $updated_amount = $params['amount'] - $emi->amount;
                $emi->amount = $params['amount'];
            }
            $emi->updated_on = date('Y-m-d H:i:s');
            $emi->updated_by = $user->user_enc_id;
            if (!$emi->save()) {
                throw new Exception(implode(',', array_column($emi->errors, "0")));
            }
            UserUtilities::CustomLoanAudit($emi->id, $emi_id, "SET", "EmiCollection", "remarks", $params['remarks'], $user->id);
            if (isset($params['amount'])) {
                $cash = EmployeesCashReportExtended::findOne(['emi_collection_enc_id' => $emi_id, "is_deleted" => 0]);
                if ($cash) {
                    change_amount($cash, $updated_amount, $user->user_enc_id);
                    if (!empty($cash->parent_cash_report_enc_id)) {
                        $cash2 = EmployeesCashReportExtended::findOne(['cash_report_enc_id' => $cash->parent_cash_report_enc_id, "is_deleted" => 0]);
                        if ($cash2) {
                            if (!($cash2->type == 1 && $cash2->status == 2) || !empty($cash2->parent_cash_report_enc_id)) {
                                throw new Exception("Amount can not be changed for this emi.");
                            }
                            change_amount($cash2, $updated_amount, $user->user_enc_id);
                        }
                    }
                }
            }
            $transaction->commit();
            return $this->response(200, ["message" => "updated successfully"]);
        } catch (Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['message' => 'an error occurred', 'error' => $exception->getMessage()]);
        }
    }

    public function actionUpdateEmiNumber()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ["status" => 401, "message" => "unauthorized"]);
        }
        // id = emi_id
        // value = loan_account_number
        $params = Yii::$app->request->post();
        if (empty($params['id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "emi_collection_enc_id']);
        }
        if (empty($params['value'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_account_number']);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $loan_account = LoanAccounts::findOne(["loan_account_number" => $params['value']]);
            if (empty($loan_account)) {
                throw new Exception("Loan Account not found.");
            }

            $fetch = EmiCollection::findOne(["emi_collection_enc_id" => $params['id']]);
            $updates = EmiCollectionExtended::findAll(["loan_account_number" => $fetch->loan_account_number, "loan_account_enc_id" => null, "is_deleted" => 0]);
            if (empty($updates)) {
                $updates[] = $fetch;
            }

            foreach ($updates as $update) {
                $update->loan_account_enc_id = $loan_account->loan_account_enc_id;
                $update->loan_account_number = $loan_account->loan_account_number;
                $update->customer_name = $loan_account->name;
                $update->updated_by = $user->user_enc_id;
                $update->updated_on = date('Y-m-d H:i:s');
                if (!$update->update()) {
                    throw new Exception(implode(' ', array_column($update->errors, "0")));
                }
            }
            $transaction->commit();
            return $this->response(200, ["status" => 200, "message" => "saved successfully"]);
        } catch (Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ["status" => 500, "message" => "An error occurred.", "error" => $exception->getMessage()]);
        }
    }

    public function actionUploadReceipt()
    {
        $params = Yii::$app->request->post();
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ["status" => 401, "message" => "unauthorized"]);
        }

        if (empty($params['emi_collection_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "emi_collection_enc_id']);
        }

        $receipt = UploadedFile::getInstanceByName('pr_receipt_image');
        $pr = EmiCollectionExtended::findOne(['emi_collection_enc_id' => $params['emi_collection_enc_id']]);
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $pr->pr_receipt_image = $utilitiesModel->encrypt() . '.' . $receipt->extension;
        $pr->pr_receipt_image_location = Yii::$app->getSecurity()->generateRandomString();
        $path = Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image;

        $base_path = $path . $pr->pr_receipt_image_location;
        $type = $receipt->type;
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $result = $my_space->uploadFileSources($receipt->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . DIRECTORY_SEPARATOR . $pr->pr_receipt_image, "private", ['params' => ['ContentType' => $type]]);

        if (!$result) {
            throw new \Exception('Error occurred while uploading receipt image');
        }
        if (!$pr->save()) {
            throw new \Exception('Error occurred while saving the model');
        }

        return $this->response(200, ['status' => 200, 'message' => 'Receipt image uploaded successfully']);
    }

    public function actionPtpEmi()
    {
        $this->isAuth();
        $user = $this->user;
        $params = $this->post;
        if (empty($params['emi_collection_enc_id'])) {
            return $this->response(422, ['message' => 'missing information "emi_collection_enc_id"']);
        }
        $id = $params['emi_collection_enc_id'];
        $emi = EmiCollection::find()
            ->where(["emi_collection_enc_id" => $id])
            ->andWhere(['IS NOT', 'ptp_amount', null])
            ->asArray()
            ->one();
        if (!$emi) {
            return $this->response(404, ['message' => 'emi not found']);
        }
        $exist_check = EmiCollection::find()
            ->alias('a')
            ->select([
                'a.emi_collection_enc_id',
                'ANY_VALUE(c.payment_short_url) link'
            ])
            ->innerJoinWith(['assignedLoanPayments AS b' => function ($b) {
                $b->innerJoinWith(['loanPaymentsEnc AS c' => function ($c) {
                    $c->andOnCondition([
                        "AND",
                        ['c.payment_link_type' => '1'],
                        ['c.payment_amount' => new Expression('a.amount')],
                        ['>=', 'c.close_by', date('Y-m-d H:i:s')],
                        ['payment_mode_status' => 'active'],
                        ['c.payment_status' => 'pending']
                    ]);
                }], false);
            }], false)
            ->andWhere([
                'a.emi_payment_status' => 'pending',
                'a.loan_account_number' => $emi['loan_account_number'],
                'a.emi_payment_method' => 1,
                'a.emi_payment_mode' => 1,
                'a.is_deleted' => 0,
                'a.amount' => $emi['ptp_amount'],
                'a.customer_name' => $emi['customer_name']
            ])
            ->asArray()
            ->one();
        if (!empty($exist_check['link'])) {
            return $this->response(200, ['message' => 'Saved Successfully', 'links' => ['qr' => $exist_check['link']]]);
        }
        if (!$org = $user->organization_enc_id) {
            $findOrg = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            if (!$org = $findOrg['organization_enc_id']) {
                return $this->response(500, ['status' => 500, 'message' => 'Organization not found']);
            }
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new EmiCollectionForm();
            $model->branch_enc_id = $emi['branch_enc_id'];
            $model->customer_name = $emi['customer_name'];
            $model->loan_account_number = $emi['loan_account_number'];
            $model->phone = $emi['phone'];
            $model->amount = $emi['ptp_amount'];
            $model->loan_type = $emi['loan_type'];
            $model->loan_purpose = $emi['loan_purpose'];
            $model->payment_mode = 1;
            $model->payment_method = 1;
            $model->address = $emi['address'];
            $model->postal_code = $emi['pincode'];
            $model->latitude = $params['latitude'] ?? $emi['latitude'];
            $model->longitude = $params['longitude'] ?? $emi['longitude'];
            $model->org_id = $org;
            $model->brand = $params['brand'];
            $save = $model->save($user->user_enc_id);
            if ($save['status'] != 200) {
                throw new Exception('An error occurred.');
            }
            $transaction->commit();
            return $this->response(200, $save);
        } catch (Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['status' => 500, 'message' => $exception->getMessage()]);
        }
    }

    public function actionUpdatePaymentMethod()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        if (empty($params['payment_mode']) || empty($params['payment_method']) || empty($params['emi_id'])) {
            return $this->response(422, ['message' => 'missing information "payment mode" or "payment method" or "emi_id"']);
        }
        $mode = $params['payment_mode'];
        $method = $params['payment_method'];
        $modes_methods = EmiCollectionForm::$modes_methods;
        try {
            if (!in_array($method, $modes_methods[$mode])) {
                throw new Exception('Incorrect payment method.');
            }
            $emi = EmiCollectionExtended::findOne(['emi_collection_enc_id' => $params['emi_id']]);
            if (!$emi) {
                return $this->response(404, ['message' => 'Emi not found.']);
            }
            $emi->emi_payment_mode = $mode;
            $emi->emi_payment_method = $method;
            $emi->emi_payment_status = in_array($method, [5, 9, 10, 81, 82, 83, 84]) ? 'pipeline' : ($method == 4 ? 'collected' : 'pending');
            if (!empty($params['collection_date'])) {
                $emi->collection_date = $params['collection_date'];
            }
            if (!empty($params['reference_number'])) {
                $emi->reference_number = $params['reference_number'];
            }
            if (($image = UploadedFile::getInstanceByName('pr_receipt_image'))) {
                $utilitiesModel = new Utilities;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $type = explode('/', $image->type)[1];
                $emi->pr_receipt_image = $utilitiesModel->encrypt() . '.' . $type;
                $emi->pr_receipt_image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image . $emi->pr_receipt_image_location;
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources(
                    $image->tempName,
                    Yii::$app->params->digitalOcean->rootDirectory . $base_path . DIRECTORY_SEPARATOR . $emi->pr_receipt_image,
                    "private",
                    ['params' => ['ContentType' => $image->type]]
                );
                if (!$result) {
                    throw new Exception("An error occurred while saving image.");
                }
            }
            $emi->updated_on = date('Y-m-d H:i:s');
            $emi->updated_by = $user->user_enc_id;
            if (!$emi->save()) {
                throw new Exception(implode(' ', array_column($emi->errors, "0")));
            }
            return $this->response(200, ['message' => 'Successfully saved.']);
        } catch (Exception $exception) {
            return $this->response(500, ['message' => 'An error occurred.', 'error' => $exception->getMessage()]);
        }
    }

    public function actionEmiCollection()
    {
        $this->isAuth();
        $user = $this->user;
        if (!$org = $user->organization_enc_id) {
            $findOrg = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            if (!$org = $findOrg['organization_enc_id']) {
                return $this->response(500, ['status' => 500, 'message' => 'Organization not found']);
            }
        }
        $params = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $update_overdue = false;
            if (!empty($params['emi_collection_enc_id']) && !empty($params['status'])) {
                $emi_id = $params['emi_collection_enc_id'];
                $model = EmiCollectionExtended::findOne(['emi_collection_enc_id' => $emi_id]);
                if ($model) {
                    $status = $params['status'];
                    if ($status === 'paid') {
                        $update_overdue = true;
                    }
                    $model->emi_payment_status = $status;
                    UserUtilities::CustomLoanAudit($model->id, $model->emi_collection_enc_id, "SET", "EmiCollection", "remarks", $params['remarks'], $user->id);
                    if ($status === 'rejected') {
                        $cash = EmployeesCashReportExtended::findOne(['emi_collection_enc_id' => $emi_id, "is_deleted" => 0]);
                        if ($cash) {
                            if (!empty($cash->parent_cash_report_enc_id)) {
                                $cash2 = EmployeesCashReportExtended::findOne([
                                    'cash_report_enc_id' => $cash->parent_cash_report_enc_id,
                                    "is_deleted" => 0,
                                    'type' => 1,
                                    'status' => 2
                                ]);
                                if (!$cash2) {
                                    throw new Exception('We can not update this emi.');
                                }
                                $cash2->amount -= $cash->amount;
                                $cash2->remaining_amount -= $cash->amount;
                                if (!$cash2->save()) {
                                    throw new \yii\db\Exception(implode(' ', array_column($cash2->errors, 0)));
                                }
                            }
                            $cash->status = 3;
                            if (!$cash->save()) {
                                throw new \yii\db\Exception(implode(' ', array_column($cash->errors, 0)));
                            }
                        }
                    }
                    $model->updated_by = $user->user_enc_id;
                    $model->updated_on = date('Y-m-d H:i:s');
                    if (!$model->save()) {
                        throw new \yii\db\Exception(implode(' ', array_column($model->errors, 0)));
                    }
                    if ($update_overdue) {
                        EmiCollectionForm::updateOverdue($model['loan_account_enc_id'], $model['amount'], $user->user_enc_id);
                    }
                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
                }
            } else {
                $model = new EmiCollectionForm();
                $model->org_id = $org;
                if ($model->load(Yii::$app->request->post()) && !$model->validate()) {
                    throw new Exception(implode(' ', array_column($model->errors, 0)));
                }
                $model->other_doc_image = UploadedFile::getInstance($model, 'other_doc_image');
                $model->borrower_image = UploadedFile::getInstance($model, 'borrower_image');
                $model->pr_receipt_image = UploadedFile::getInstance($model, 'pr_receipt_image');
                $save = $model->save($user->user_enc_id);
                $save['status'] == 200 ? $transaction->commit() : $transaction->rollBack();
                return $this->response($save['status'], $save);
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['status' => 500, 'message' => $exception->getMessage()]);
        }
    }

    public function actionUpdateCompanyCase()
    {
        $user = $this->isAuthorized();
        if (!$user) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        if ($user->username != 'KKB') {
            return $this->response(404, ['status' => 404, 'message' => 'Page Not Found']);
        }
        $params = Yii::$app->request->post();

        if (empty($params['emi_collection_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "emi_collection_enc_id"']);
        }

        if (!isset($params['company_id']) && !isset($params['case_no'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing information: "company_id" or "case_no"']);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $case = EmiCollection::findOne(['emi_collection_enc_id' => $params['emi_collection_enc_id']]);
            $cases = EmiCollection::findAll(["loan_account_number" => $case->loan_account_number, "loan_account_enc_id" => null, 'is_deleted' => 0]);
            if (empty($cases)) {
                $cases[] = $case;
            }

            foreach ($cases as $case) {
                $case->company_id = $params['company_id'];
                $case->case_no = $params['case_no'];
                if (!$case->save()) {
                    throw new \yii\db\Exception(implode(" ", array_column($case->getErrors(), '0')));
                }
            }

            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'Added Successfully']);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['message' => 'An error occurred', 'error' => $exception->getMessage()]);
        }
    }

    public function actionCollectionReportBranches()
    {
        $user = $this->isAuthorized();
        if (!$user) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();
        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $org_id = $user->organization_enc_id;
        if (!$org_id) {
            $user_roles = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            $org_id = $user_roles->organization_enc_id;
        }
        $valuesSma = [
            'SMA0' => [
                'name' => 'SMA-0',
                'value' => 1.25
            ],
            'SMA1' => [
                'name' => 'SMA-1',
                'value' => 1.5
            ],
            'SMA2' => [
                'name' => 'SMA-2',
                'value' => 1.5
            ],
            'NPA' => [
                'name' => 'NPA',
                'value' => 1
            ],
            'OnTime' => [
                'name' => 'OnTime',
                'value' => null
            ],
        ];
        $list = EmiCollection::find()
            ->alias('a')
            ->select(["CONCAT(b1.location_name, ', ', b2.name) as location_name", $this->data($valuesSma)])
            ->joinWith(['loanAccountEnc b' => function ($b) {
                $b->joinWith(['branchEnc b1' => function ($b1) {
                    $b1->joinWith(['cityEnc b2'], false);
                }], false);
            }], false)
            ->where(['a.is_deleted' => 0, 'b1.organization_enc_id' => $org_id])
            ->orWhere(['between', 'a.collection_date', $params['start_date'], $params['end_date']])
            ->andWhere(['NOT', ['b.branch_enc_id' => null]])
            ->andWhere(['NOT', ['b.bucket' => null]])
            ->groupBy(['b1.location_name', 'b2.name']);

        if (!empty($params['loan_type'])) {
            $list->andWhere(['IN', 'a.loan_type', $params['loan_type']]);
        }
        if (!empty($params['fields_search'])) {
            foreach ($params['fields_search'] as $key => $value) {
                if (!empty($value)) {
                    if ($key == 'branch') {
                        $list->andWhere(['IN', 'b1.location_enc_id', $value]);
                    } else {
                        $list->andWhere(['like', $key, $value]);
                    }
                }
            }
        }

        if (!$res = UserUtilities::getUserType($user->user_enc_id) == 'Financer' || self::specialCheck($user->user_enc_id)) {
            $juniors = UserUtilities::getting_reporting_ids($user->user_enc_id, 1);
            $list->andWhere(['b.created_by' => $juniors]);
        }
        $count = $list->count();
        $list = $list
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($list) {
            $list = ArrayProcessJson::Parse($list);
        }

        return $this->response(200, ['status' => 200, 'data' => $list, 'count' => $count]);
    }


    private function data($valuesSma)
    {
        $queryResult = '';
        foreach ($valuesSma as $key => $value) {
            $totalCasesNumber = "COUNT(DISTINCT CASE WHEN b.bucket = '{$value['name']}' THEN b.loan_account_enc_id END) total_cases_count_{$key},";
            $collectedCasesNumber = "COUNT(CASE WHEN b.bucket = '{$value['name']}' AND a.emi_payment_status NOT IN ('rejected', 'failed','pending') THEN 1 END) collected_cases_count_{$key},";
            if ($key == 'OnTime') {
                $targetAmount = "SUM(CASE WHEN b.bucket = '{$value['name']}' THEN COALESCE(b.emi_amount, 0) ELSE 0 END) target_amount_{$key},";
            } else {
                $targetAmount = "SUM(CASE WHEN b.bucket = '{$value['name']}' THEN LEAST(COALESCE(b.ledger_amount, 0) + COALESCE(b.overdue_amount, 0), b.emi_amount * '{$value['value']}') ELSE 0 END) target_amount_{$key},";
            }
            $collectedVerifiedAmount = "COALESCE(SUM(CASE WHEN b.bucket = '{$value['name']}' AND a.emi_payment_status = 'paid' THEN COALESCE(a.amount, 0) END),0) collected_verified_amount_{$key},";
            $collectedUnVerifiedAmount = "COALESCE(SUM(CASE WHEN b.bucket = '{$value['name']}' AND a.emi_payment_status != 'paid' AND a.emi_payment_status NOT IN ('rejected', 'failed','pending') THEN COALESCE(a.amount, 0) END),0) collected_unverified_amount_{$key},";

            $queryResult .= "$totalCasesNumber $collectedCasesNumber $targetAmount $collectedVerifiedAmount $collectedUnVerifiedAmount";
        }

        return rtrim($queryResult, ',');
    }

    public function actionCollectionDailyStats()
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
            $valuesSma = [
                'SMA0' => [
                    'name' => 'SMA-0',
                    'value' => 1.25
                ],
                'SMA1' => [
                    'name' => 'SMA-1',
                    'value' => 1.5
                ],
                'SMA2' => [
                    'name' => 'SMA-2',
                    'value' => 1.5
                ],
                'NPA' => [
                    'name' => 'NPA',
                    'value' => 1
                ],
                'OnTime' => [
                    'name' => 'OnTime',
                    'value' => null
                ],
            ];
            $queryResult = "";
            foreach ($valuesSma as $key => $value) {
                $totalCasesNumber = "COUNT(DISTINCT CASE WHEN lac.bucket = '{$value['name']}' THEN emi.emi_collection_enc_id END) total_cases_count_{$key},";
                $CollectedCasesNumber = "SUM(CASE WHEN lac.bucket = '{$value['name']}' THEN COALESCE(emi.amount, 0) ELSE 0 END) collected_cases_count_{$key},";
                $collectedVerifiedAmount = "COALESCE(SUM(CASE WHEN lac.bucket = '{$value['name']}' AND emi.created_on BETWEEN '{$startDate}' AND '{$endDate}'  AND emi.emi_payment_status = 'paid' THEN COALESCE(emi.amount, 0) END),0) collected_verified_amount_{$key},";
                $collectedUnVerifiedAmount = "COALESCE(SUM(CASE WHEN lac.bucket = '{$value['name']}' AND emi.created_on BETWEEN '{$startDate}' AND '{$endDate}'  AND emi.emi_payment_status != 'paid' AND emi.emi_payment_status NOT IN ('rejected', 'failed','pending') THEN COALESCE(emi.amount, 0) END),0) collected_unverified_amount_{$key},";

                $queryResult .= "$totalCasesNumber $CollectedCasesNumber $collectedVerifiedAmount $collectedUnVerifiedAmount";
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
                    'b3.location_name branch_name', 'b3.location_enc_id branch_id', 'b5.name as state_name',
                    $queryResult
                ])
                ->joinWith(['userRoles0 b' => function ($b) {
                    $b->joinWith(['designationEnc b1'])
                        ->joinWith(['designation gd'])
                        ->joinWith(['reportingPerson b2'])
                        ->joinWith(['branchEnc b3' => function ($b3) {
                            $b3->joinWith(['cityEnc b6' => function ($b6) {
                                $b6->joinWith(['stateEnc b5'], false);
                            }], false);
                        }], false)
                        ->joinWith(['userTypeEnc b4']);
                }], false)
                ->joinWith(['emiCollections emi' => function ($emi) {
                    $emi->joinWith(['loanAccountEnc lac' => function ($lac) {
                    }], false);
                }], false)
                ->andWhere(['b4.user_type' => 'Employee', 'b.is_deleted' => 0])
                ->andWhere(['between', 'collection_date', $startDate, $endDate])
                ->andWhere(['a.status' => 'active', 'a.is_deleted' => 0, 'b.organization_enc_id' => $org_id])
                ->groupBy(['a.user_enc_id', 'b2.image', 'b2.image_location', 'b2.initials_color', 'b.employee_code', 'b2.first_name', 'b2.last_name', 'gd.designation', 'b3.location_name', 'b3.location_enc_id']);

            if (!empty($params['loan_type'])) {
                $list->andWhere(['IN', 'emi.loan_type', $params['loan_type']]);
            }
            if (!empty($params['fields_search'])) {
                foreach ($params['fields_search'] as $key => $value) {
                    if (!empty($value)) {
                        if ($key == 'employee_code') {
                            $list->andWhere(['like', 'b.' . $key, $value]);
                        } elseif ($key == 'phone') {
                            $list->andWhere(['like', 'a.' . $key, $value]);
                        } elseif ($key == 'username') {
                            $list->andWhere(['like', 'a.' . $key, $value]);
                        } elseif ($key == 'employee_name') {
                            $list->andWhere(['like', "CONCAT(a.first_name,' ',COALESCE(a.last_name))", $value]);
                        } elseif ($key == 'state_enc_id') {
                            $list->andWhere(['IN', "b5.state_enc_id", $value]);
                        } elseif ($key == 'reporting_person') {
                            $list->andWhere(['like', "CONCAT(b2.first_name,' ',COALESCE(b2.last_name))", $value]);
                        } elseif ($key == 'branch') {
                            $list->andWhere(['IN', 'b3.location_enc_id', $value]);
                        } elseif ($key == 'state_enc_id') {
                            $list->andWhere(['IN', 'b5.state_enc_id', $value]);
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
            $count = $list->count();
            $list = $list
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();
            if ($list):
                $list = ArrayProcessJson::Parse($list);
            endif;
            return $this->response(200, ['status' => 200, 'data' => $list, 'count' => $count]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

}
