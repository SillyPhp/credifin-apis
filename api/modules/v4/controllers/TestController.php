<?php

namespace api\modules\v4\controllers;

use api\modules\v4\utilities\UserUtilities;
use common\models\AssignedLoanPayments;
use common\models\CreditLoanApplicationReports;
use common\models\EmiCollection;
use common\models\EmployeesCashReport;
use common\models\extended\Industries;
use common\models\extended\LoanApplicationsExtended;
use common\models\LoanAccounts;
use common\models\LoanApplications;
use common\models\LoanPayments;
use common\models\UserRoles;
use common\models\Utilities;
use phpDocumentor\Reflection\Types\Null_;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\web\Response;

class TestController extends ApiBaseController
{
    public function behaviors()
    {
        $model = explode("\\", Industries::className());
        $behaviors = parent::behaviors();

        $behaviors["verbs"] = [
            "class" => VerbFilter::className(),
            "actions" => [
                "testxl" => ["POST", "OPTIONS"],
                "pool" => ["POST", "OPTIONS"],
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

    public function actionPool()
    {
        $user = $this->isAuthorized();
        if (!$user && !UserUtilities::getUserType($user->user_enc_id) != "Financer") {
            return $this->response(500, "Not Authorized");
        }
        $params = Yii::$app->request->post();
        if (empty($params)) {
            return $this->response(500, "params missing");
        }
        $query = LoanApplications::find()
            ->alias("a")
            ->select([
                "a.application_number",
                "abc.name applicant_name",
                "a.invoice_date",
                "a.loan_status_updated_on as disbursement_date",
                "DATE_FORMAT(a.loan_status_updated_on, '%Y-%m-%d') disbursement_date",
                "c.address",
                "(CASE WHEN abc.gender = 1 THEN 'Male' WHEN abc.gender = 2 THEN 'Female' ELSE 'Other' END) gender",
                "c1.name state",
                "c.postal_code",
                "abc.phone",
                "abc.cibil_score",
                "abc.aadhaar_number",
                "abc.voter_card_number",
                "abc.pan_number",
                "a.loan_purpose",
                "a.chassis_number",
                "a.invoice_number",
                "a.amount",
                "a.number_of_emis",
                "a.roi",
                "abc.co_applicant_dob applicant_dob",
                "DATE_FORMAT(STR_TO_DATE(a.emi_collection_date, '%Y-%m-%d'), '%d-%m-%Y') as emi_collection_date",
                "b.disbursement_approved",
                "b.insurance_charges",
                "a.emi_collection_date",
                "e.vehicle_model",
                "e.vehicle_making_year",
                "a.loan_app_enc_id",
                "a.loan_products_enc_id",
                "e.dealer_name",
                "e.vehicle_type",
                "e.vehicle_brand",
                "f.name loan_type",
                "CONCAT(g.first_name, ' ', COALESCE(g.last_name)) as leadby",
                "a.applicant_dob",
                "CONCAT('https://www.empowerloans.in/account/loan-application/', a.loan_app_enc_id) AS link",
                "e.name_of_company", "e.type_of_company", "e.vehicle_making_year", "e.model_year", "e.engine_number",
                "e.ex_showroom_price", "e.on_road_price", "e.margin_money", "e.ltv", "e.valid_till",
                "e.policy_number", "e.payable_value", "e.field_officer"
            ])
            ->joinWith(["assignedLoanProviders b"], false)
            ->joinWith(["loanApplicantResidentialInfos c" => function ($c) {
                $c->joinWith(["stateEnc c1"], false);
            }], false)
            ->joinWith(["loanCoApplicants abc" => function ($abc) {
                $abc->andOnCondition(["abc.is_deleted" => 0, "abc.borrower_type" => "Borrower"]);
            }], false)
            ->joinWith(["loanCoApplicants d" => function ($d) {
                $d->select(["d.loan_app_enc_id", "d.name", "d1.address", "d.co_applicant_dob", "d1.postal_code", "d.phone",
                    "(CASE WHEN d.gender = 1 THEN 'Male' WHEN d.gender = 2 THEN 'Female' ELSE 'Other' END) gender",
                    "d.borrower_type", "d.loan_co_app_enc_id", "d.aadhaar_number", "d.voter_card_number", "d.pan_number",
                    "d.cibil_score", "d.driving_license_number", "d.marital_status"]);
                $d->onCondition(["d.is_deleted" => 0]);
                $d->andOnCondition(['!=', 'd.borrower_type', 'Borrower']);
                $d->joinWith(["loanApplicantResidentialInfos d1"], false);
            }], true)
            ->joinWith(["loanApplicationOptions e"], false)
            ->andWhere([
                "AND",
                ["between", "a.loan_status_updated_on", $params["start_date"], $params["end_date"]],
                ["b.provider_enc_id" => $params["org_id"]],
                ["a.is_deleted" => 0],
            ])
            ->joinWith(["loanProductsEnc f"], false)
            ->joinWith(["leadBy g"], false);
        if (!empty($params["loan_products_enc_id"])) {
            $query->andWhere(["a.loan_products_enc_id" => $params["loan_products_enc_id"]]);
        }
        if (!empty($params["status"])) {
            $query->andWhere(["b.status" => $params["status"]]);
        }
        $query = $query->limit($params["limit"])
            ->groupBy(["a.loan_app_enc_id"])
            ->offset(($params["page"] - 1) * $params["limit"])
            ->asArray()
            ->all();

        foreach ($query as &$item) {
            $cibils = $this->CreditReports($item["loan_app_enc_id"]);
            if (!empty($cibils)) {

                if (in_array($item["loan_app_enc_id"], array_keys($cibils))) {
                    $item["cibil_score"] = $cibils[$item["loan_app_enc_id"]];
                }
                if (!empty($item["loanCoApplicants"])) {
                    foreach ($item["loanCoApplicants"] as &$loanCoApplicant) {
                        if (in_array($loanCoApplicant["loan_co_app_enc_id"], array_keys($cibils))) {
                            $loanCoApplicant["cibil_score"] = $cibils[$loanCoApplicant["loan_co_app_enc_id"]];
                        }
                    }
                }
            }
        }
        return $this->response(200, ["status" => 200, "data" => $query]);
    }

    private function getCashReportDetail($id)
    {
        $findCashDe = EmployeesCashReport::find()
            ->select(['status', 'parent_cash_report_enc_id'])
            ->where(['cash_report_enc_id' => $id])
            ->one();
        if ($findCashDe['status'] != 1 && !empty($findCashDe['parent_cash_report_enc_id'])) {
            return $this->getCashReportDetail($findCashDe['parent_cash_report_enc_id']);
        }

        return $findCashDe['status'] == 1;
    }

    public function actionCashMove($limit = 50, $page = 1, $auth = '')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($auth !== 'EXhS3PIQq9iYHoCvpT2f1a62GUCfzRvn') {
            return ['status' => 401, 'msg' => 'authentication failed'];
        }
        $emis = EmiCollection::find()
            ->alias('a')
            ->select(['a.emi_collection_enc_id', 'a.loan_account_number'])
            ->innerJoinWith(['employeesCashReports b' => function ($b) {
                $b->select(["b.parent_cash_report_enc_id", "b.emi_collection_enc_id", "b.status"]);
                $b->andOnCondition(["!=", "b.status", 1]);
            }])
            ->orderBy(['a.id' => SORT_DESC])
            ->where(['not', ['a.emi_payment_status' => 'pipeline']])
//            ->andWhere(['b.is_deleted' => 0])
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->asArray()
            ->all();
        $updated = 0;
        foreach ($emis as $key => $emi) {
            $cash_id = reset($emi['employeesCashReports']);
            if (empty($cash_id['parent_cash_report_enc_id'])) {
                $update = Yii::$app->db->createCommand()
                    ->update(EmiCollection::tableName(), ['emi_payment_status' => 'collected'], ['emi_collection_enc_id' => $emi['emi_collection_enc_id']])
                    ->execute();
                if ($update) {
                    $updated += 1;
                }
            } else if (!$this->getCashReportDetail($cash_id['parent_cash_report_enc_id'])) {
//                $emis[$key]['cs'] = 'pipeline';
                $update = Yii::$app->db->createCommand()
                    ->update(EmiCollection::tableName(), ['emi_payment_status' => 'pipeline'], ['emi_collection_enc_id' => $emi['emi_collection_enc_id']])
                    ->execute();
                if ($update) {
                    $updated += 1;
                }
            }
        }
//        print_r($emis);
//        exit();
        return ['status' => 200, 'found' => count($emis), 'updated' => $updated];
    }

    public function actionFixPipelined($limit = 50, $page = 1, $auth = '')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($auth !== 'EXhS3PIQq9iYHoCvpT2f1a62GUCfzRvn') {
            return ['status' => 401, 'msg' => 'authentication failed'];
        }
        $emis = EmiCollection::find()
            ->alias('a')
            ->select(['a.emi_collection_enc_id', 'a.loan_account_number'])
            ->innerJoinWith(['employeesCashReports b' => function ($b) {
                $b->select(["b.parent_cash_report_enc_id", "b.emi_collection_enc_id", "b.status"]);
                $b->andOnCondition(["b.status" => 0]);
            }])
            ->orderBy(['a.id' => SORT_DESC])
            ->where(['not', ['a.emi_payment_status' => 'collected']])
//            ->andWhere(['b.is_deleted' => 0])
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->asArray()
            ->all();
        $updated = 0;
        foreach ($emis as $key => $emi) {
            $cash_id = reset($emi['employeesCashReports']);
            if (empty($cash_id['parent_cash_report_enc_id'])) {
//                $emis[$key]['cs'] = 'pipeline';
                $update = Yii::$app->db->createCommand()
                    ->update(EmiCollection::tableName(), ['emi_payment_status' => 'collected'], ['emi_collection_enc_id' => $emi['emi_collection_enc_id']])
                    ->execute();
                if ($update) {
                    $updated += 1;
                }
            }
        }
//        print_r($emis);
//        exit();
        return ['status' => 200, 'found' => count($emis), 'updated' => $updated];
    }

    private function CreditReports($loan_id)
    {
        $credit_report = CreditLoanApplicationReports::find()
            ->alias("a")
            ->select(["a.response_enc_id", "a.loan_co_app_enc_id", "a.loan_app_enc_id"])
            ->joinWith(["responseEnc b" => function ($b) {
                $b->select(["b.response_enc_id", "b.response_body"]);
                $b->joinWith(["requestEnc b1" => function ($b1) {
                    $b1->andOnCondition(["b1.request_source" => "CIBIL"]);
                }], false, "INNER JOIN");
            }])
            ->andWhere(["a.loan_app_enc_id" => $loan_id])
            ->asArray()
            ->all();
        $res = [];
        foreach ($credit_report as $value) {
            $value["responseEnc"]["response_body"] = json_decode($value["responseEnc"]["response_body"], true);
            $response_body = UserUtilities::array_search_key("BureauResponseXml", $value);
            $array = json_decode(json_encode((array)simplexml_load_string($response_body)), true);
            if (!empty($array["ScoreSegment"])) {
                $res[] = $array["ScoreSegment"];
                if (array_key_exists(0, $array["ScoreSegment"])) {
                    foreach ($array["ScoreSegment"] as $val) {
                        if (is_array($val)) {
                            if ($val["ScoreName"] == "CIBILTUSC3") {
                                $score = ltrim($val["Score"], 0);
                                break;
                            }
                        }
                    }
                } else {
                    $score = ltrim($array["ScoreSegment"]["Score"], 0);
                }
            }
            if (!empty($score)) {
                if (empty($value["loan_co_app_enc_id"])) {
                    $res[$value["loan_app_enc_id"]] = $score;
                } else {
                    $res[$value["loan_co_app_enc_id"]] = $score;
                }
            }
        }
        return $res;
    }

    public function actionTestxl()
    {
        $user = $this->isAuthorized();
        if (!$user && !UserUtilities::getUserType($user->user_enc_id) != "Financer") {
            return $this->response(500, "Not Authorized");
        }
        $params = Yii::$app->request->post();
        if (empty($params)) {
            return $this->response(500, "params missing");
        }
        $query = LoanApplications::find()
            ->alias("a")
            ->select([
                "a.loan_app_enc_id", "a.application_number", "a.loan_products_enc_id",
                "a.applicant_name", "a.pan_number", "a.aadhaar_number",
                "a.phone", "c.address", "a.roi", "a.number_of_emis", "a.emi_collection_date", "a.pf", "a.cibil_score",
                "DATE_FORMAT(STR_TO_DATE(a.emi_collection_date, '%Y-%m-%d'), '%d-%m-%Y') as emi_collection_date", "a.chassis_number",
                "DATE_FORMAT(DATE_ADD(STR_TO_DATE(a.emi_collection_date, '%Y-%m-%d'), INTERVAL a.number_of_emis MONTH), '%d-%m-%Y') AS last_date",
                "c1.name state", "e.dealer_name", "e.vehicle_type", "e.vehicle_making_year", "e.vehicle_brand", "e.vehicle_model", "f.name loan_type", "a.amount", "b.disbursement_approved", "b.insurance_charges",
                "c.postal_code",
                "CONCAT(g.first_name, ' ', COALESCE(g.last_name)) as leadby",
                "a.applicant_dob", "a.voter_card_number"
            ])
            ->joinWith(["assignedLoanProviders b"], false)
            ->joinWith(["loanApplicantResidentialInfos c" => function ($c) {
                $c->joinWith(["stateEnc c1"], false);
            }], false)
            ->joinWith(["loanCoApplicants d" => function ($d) {
                $d->select(["d.loan_app_enc_id", "d.name", "d1.address", "d.co_applicant_dob", "d1.postal_code", "d.phone", "d.borrower_type", "d.loan_co_app_enc_id", "d.aadhaar_number", "d.voter_card_number", "d.pan_number"]);
                $d->onCondition(["d.is_deleted" => 0]);
                $d->joinWith(["loanApplicantResidentialInfos d1"], false);
            }], true)
            ->joinWith(["loanApplicationOptions e"], false)
            ->andWhere([
                "AND",
                ["between", "a.loan_status_updated_on", $params["start_date"], $params["end_date"]],
                ["b.provider_enc_id" => $params["org_id"]],
                ["a.is_deleted" => 0],
            ])
            ->joinWith(["loanProductsEnc f"], false)
            ->joinWith(["leadBy g"], false);
        if (!empty($params["loan_products_enc_id"])) {
            $query->andWhere(["a.loan_products_enc_id" => $params["loan_products_enc_id"]]);
        }
        if (!empty($params["status"])) {
            $query->andWhere(["b.status" => $params["status"]]);
        }
        $query = $query->limit($params["limit"])
            ->groupBy(["a.loan_app_enc_id"])
            ->offset(($params["page"] - 1) * $params["limit"])
            ->asArray()
            ->all();
        return $this->response(200, ["status" => 200, "data" => $query]);
    }

    public function actionAssignPaymentLoginDate()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();

        $page = !empty($params['page']) ? $params['page'] : 1;
        $limit = !empty($params['limit']) ? $params['limit'] : 10;

        $login_date = (new \yii\db\Query())
            ->select(['b1.loan_app_enc_id', 'b2.updated_on', 'b2.payment_status'])
            ->from(['a' => LoanApplicationsExtended::tableName()])
            ->innerJoin(['b1' => AssignedLoanPayments::tableName()], 'b1.loan_app_enc_id = a.loan_app_enc_id')
            ->innerJoin(['b2' => LoanPayments::tableName()], 'b2.loan_payments_enc_id = b1.loan_payments_enc_id')
            ->where(['a.is_deleted' => 0, 'b2.payment_status' => 'captured'])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->all();


        foreach ($login_date as $loan_payment) {
            $loan_app_enc_id = $loan_payment['loan_app_enc_id'];
            $loan_application = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $loan_app_enc_id]);
            if ($loan_application) {
                $loan_application->login_date = $loan_payment['updated_on'];
                if (!$loan_application->save()) {
                    return $this->response(500, ['status' => 500, 'message' => 'Failed']);
                }
                return $this->response(200, ['status' => 200, 'message' => 'Saved Successfully']);
            }
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

    }

    public function actionAssignAuditLoginDate()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();

        $page = !empty($params['page']) ? $params['page'] : 1;
        $limit = !empty($params['limit']) ? $params['limit'] : 10;

        $results = (new \yii\db\Query())
            ->select(['b.loan_app_enc_id', 'c.foreign_id', 'c.stamp'])
            ->from(['a' => LoanApplicationsExtended::tableName()])
            ->innerJoin(['b' => AssignedLoanPayments::tableName()])
            ->innerJoin(['c' => \common\models\extended\LoanAuditTrail::tableName()])
            ->where(['b.loan_app_enc_id' => null, 'c.new_value' => 'Login', 'c.model' => 'AssignedLoanProvider', 'a.is_deleted' => 0])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->all();

        foreach ($results as $audit) {
            $loan_app_enc_id = $audit['foreign_id'];
            $loan_application = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $loan_app_enc_id]);
            if ($loan_application->login_date == null) {
                $loan_application->login_date = $audit['stamp'];
                $loan_application->save();
                if (!$loan_application) {
                    return $this->response(500, ['status' => 500, 'message' => 'Failed']);
                }
                return $this->response(200, ['status' => 200, 'message' => 'Saved successfully']);
            }
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionVehicleChanges($auth = '', $type = '')
    {
        $this->isAuth();
        if ($auth != Yii::$app->params->emiCollection->cashInHand->authKey) {
            return 'unauthorised';
        }
        $file = $_FILES['file'];
        if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
            $count = true;
            $transaction = Yii::$app->db->beginTransaction();
            while (($data = fgetcsv($handle, 1000)) !== FALSE) {
                if ($count) {
                    $header = $data;
                    $count = false;
                    continue;
                }
                if (empty($header)) {
                    return 'error';
                }
                $data = array_map(function ($key, $item) use ($header) {
                    $item = trim($item);
                    return $key == array_search('LoanNo', $header) ? str_replace(' ', '', $item) : $item;
                }, array_keys($data), $data);

                $loan = LoanAccounts::findOne(['loan_account_number' => trim($data[array_search('LoanNo', $header)])]);
                if ($loan) {
                    $loan->company_id = $data[array_search('CompanyId', $header)] ?? "";
                    $loan->company_name = $data[array_search('CompanyName', $header)] ?? "";
                    if (!empty($type)) {
                        if (!empty($data[array_search('Nach', $header)])) {
                            $loan->nach_approved = $data[array_search('Nach', $header)] == 'Yes' ? 1 : 0;
                        }
                        $loan->dealer_name = $data[array_search('DealerName', $header)] ?? "";
                    }
                    $loan->coborrower_name = $data[array_search('CoBorrowerName', $header)] ?? "";
                    $loan->coborrower_phone = $data[array_search('CoBorrowerPhone', $header)] ?? "";
                    if (!$loan->save()) {
                        $transaction->rollBack();
                        return json_encode($loan->getErrors());
                    }
                }
            }
            fclose($handle);
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        }
    }
}