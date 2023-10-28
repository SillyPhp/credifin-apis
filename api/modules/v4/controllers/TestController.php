<?php

namespace api\modules\v4\controllers;

use api\modules\v4\utilities\UserUtilities;
use common\models\CreditLoanApplicationReports;
use common\models\extended\Industries;
use common\models\LoanApplications;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;

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
                "a.applicant_name",
                "c.address",
                "(CASE WHEN a.gender = 1 THEN 'Male' WHEN a.gender = 2 THEN 'Female' ELSE 'Other' END) gender",
                "c1.name state",
                "c.postal_code",
                "a.phone",
                "a.cibil_score",
                "a.aadhaar_number",
                "a.voter_card_number",
                "a.pan_number",
                "a.loan_purpose",
                "a.chassis_number",
                "a.invoice_number",
                "a.amount",
                "a.number_of_emis",
                "a.roi",
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
                "CONCAT('https://www.empowerloans.in/account/loan-application/', a.loan_app_enc_id) AS link"
            ])
            ->joinWith(["assignedLoanProviders b"], false)
            ->joinWith(["loanApplicantResidentialInfos c" => function ($c) {
                $c->joinWith(["stateEnc c1"], false);
            }], false)
            ->joinWith(["loanCoApplicants d" => function ($d) {
                $d->select(["d.loan_app_enc_id", "d.name", "d1.address", "d.co_applicant_dob", "d1.postal_code", "d.phone",
                    "(CASE WHEN d.gender = 1 THEN 'Male' WHEN d.gender = 2 THEN 'Female' ELSE 'Other' END) gender",
                    "d.borrower_type", "d.loan_co_app_enc_id", "d.aadhaar_number", "d.voter_card_number", "d.pan_number",
                    "d.cibil_score", "d.driving_license_number", "d.marital_status"]);
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

        foreach ($query as &$item) {
            $cibils = $this->CreditReports($item["loan_app_enc_id"]);
            if (!empty($cibils)) {

                if (in_array($item["loan_app_enc_id"], $cibils)) {
                    $item["cibil_score"] = $cibils[$item["loan_app_enc_id"]];
                }
                if (!empty($item["loanCoApplicants"])) {
                    foreach ($item["loanCoApplicants"] as &$loanCoApplicant) {
                        if (in_array($loanCoApplicant["loan_co_app_enc_id"], $cibils)) {
                            $loanCoApplicant["cibil_score"] = $cibils[$loanCoApplicant["loan_co_app_enc_id"]];
                        }
                    }
                }
            }
        }
        return $this->response(200, ["status" => 200, "data" => $query]);
    }

    private function CreditReports($loan_id)
    {
        $credit_report = CreditLoanApplicationReports::find()
            ->alias("a")
            ->select([
                "a.response_enc_id", "b1.request_source", "c.borrower_type", "c.name",
                "a.created_on", "a.loan_co_app_enc_id", "a.loan_app_enc_id"
            ])
            ->joinWith(["responseEnc b" => function ($b) {
                $b->select(["b.response_enc_id", "b1.request_source", "b.response_body"]);
                $b->joinWith(["requestEnc b1"], false);
                $b->andWhere(["b1.request_source" => "CIBIL"]);
            }])
            ->joinWith(["loanCoAppEnc c"], false)
            ->andWhere([
                "a.loan_app_enc_id" => $loan_id,
                "b1.request_source" => "CIBIL"
            ])
            ->offset(0)
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

}