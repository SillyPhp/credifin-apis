<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\EmiCollectionForm;
use common\models\AssignedDeals;
use common\models\AssignedLoanPayments;
use common\models\AssignedLoanProvider;
use common\models\ClaimedDeals;
use common\models\EducationLoanPayments;
use common\models\LoanAccounts;
use common\models\LoanApplications;
use common\models\LoanPayments;
use common\models\LoanSanctionReports;
use Exception;
use Razorpay\Api\Api;
use Yii;
use yii\db\Expression;
use yii\filters\Cors;
use yii\filters\VerbFilter;

class CandidateDashboardController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'loan-details' => ['POST', 'OPTIONS'],
                'loan-provider-detail' => ['POST', 'OPTIONS'],
                'pro-benefits-access' => ['POST', 'OPTIONS'],
                'scratch-cards' => ['POST', 'OPTIONS'],
                'scratch-cards-code' => ['POST', 'OPTIONS'],
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

    public function actionCreatePaymentLink()
    {
        $user = $this->isAuth();
        $params = $this->post;
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (empty($params['emi_amount']) || !isset($params['pay_by']) || empty($params['loan_app_enc_id'])) {
                throw new \Exception("missing information 'loan_app_enc_id' or 'pay_by' or 'emi_amount'");
            }
            $type = $params['pay_by'];
            if (!in_array($type, [0, 1])) {
                throw new \Exception("Invalid pay_by");
            }
            $query = AssignedLoanPayments::find()
                ->alias('a')
                ->select(['b.payment_short_url AS link'])
                ->innerJoinWith(['loanPaymentsEnc AS b' => function ($b) use ($params) {
                    $b->andOnCondition([
                        "AND",
                        ['b.payment_amount' => $params['emi_amount']],
                        ['b.payment_link_type' => $params['pay_by']],
                        ['>=', 'b.close_by', date('Y-m-d H:i:s')],
                        ['b.payment_mode_status' => 'active'],
                        ['b.payment_status' => 'pending']
                    ]);
                }], false)
                ->andWhere(['a.loan_app_enc_id' => $params['loan_app_enc_id']])
                ->asArray()
                ->one();
            $link = !empty($query) ? $query['link'] : '';
            if (!$link) {
                $loan = LoanApplications::find()
                    ->alias('a')
                    ->select(['a.loan_app_enc_id', 'a.applicant_name', 'a.application_number', 'a.phone', 'b.branch_enc_id', 'c.name loan_type', 'GROUP_CONCAT(DISTINCT d1.purpose) AS purposes', 'b.provider_enc_id AS org_id'])
                    ->joinWith(['assignedLoanProviders AS b'], false)
                    ->joinWith(['loanProductsEnc AS c'], false)
                    ->joinWith(['loanPurposes AS d' => function ($d) {
                        $d->joinWith(['financerLoanPurposeEnc AS d1'], false);
                    }], false)

                    ->where(['a.loan_app_enc_id' => $params['loan_app_enc_id']])
                    ->groupBy(['a.loan_app_enc_id', 'b.assigned_loan_provider_enc_id', 'd.loan_app_enc_id'])
                    ->asArray()
                    ->one();
                if (!$loan) {
                    throw new \Exception("Loan Application not found");
                }
                $model = new EmiCollectionForm();
                $model->branch_enc_id = $loan['branch_enc_id'];
                $model->customer_name = $loan['applicant_name'];
                $model->loan_account_number = $loan['application_number'];
                $model->loan_app_enc_id = $loan['loan_app_enc_id'];
                $model->phone = $loan['phone'];
                $model->amount = $params['emi_amount'];
                $model->loan_type = $loan['loan_type'];
                $model->loan_purpose = $loan['purposes'];
                $model->payment_mode = 1;
                $model->payment_method = $type == 0 ? 2 : $type;
                $model->address = $params['address'];
                $model->postal_code = $params['pincode'];
                $model->latitude = $params['latitude'];
                $model->longitude = $params['longitude'];
                $model->org_id = $loan['org_id'];
                $model->brand = 'testing';
                $save = $model->save($user->user_enc_id);
                if ($save['status'] != 200) {
                    throw new Exception('An error occurred.');
                }
                if (!empty($save['links']['link'])) {
                    $link = $save['links']['link'];
                } elseif (!empty($save['links']['qr'])) {
                    $link = $save['links']['qr'];
                }
            }
            if (!$link) {
                throw new \Exception("An error occurred while creating link");
            }
            $transaction->commit();
            return $this->response(200, ['message' => 'success', 'type' => $type, 'link' => $link]);
        } catch (Exception $exception) {
            $transaction->rollback();
            return $this->response(500, ['message' => 'an error occurred', 'error' => $exception->getMessage()]);
        }
    }

    public function actionLoanDetails()
    {
        $user = $this->isAuth();
        $params = $this->post;

        $query = LoanApplications::find()
            ->alias('a')
            ->select([
                'a.loan_app_enc_id', 'a.applicant_name', 'a.loan_products_enc_id', 'a.invoice_number', 'a.invoice_date', 'a.phone',
                'f.vehicle_color', 'a.battery_number', 'a.rc_number', 'a.chassis_number',
                'f.model_year', 'f.emi_amount',
                'c3.loan_status', 'c.status', 'c.provider_enc_id',
                'a.amount AS loan_amount',
                'a.application_number', 'b.name AS loan_type', 'ANY_VALUE(c1.location_name) AS branch_name',
                'ANY_VALUE(c2.name) AS loan_provider', 'a.created_on AS applied_date',
                "GROUP_CONCAT(DISTINCT d1.purpose) AS purposes",
                "CASE WHEN g.bucket = 'onTime' THEN g.emi_amount ELSE
                        (CASE WHEN COALESCE(SUM(g.ledger_amount), 0) + COALESCE(SUM(g.overdue_amount), 0) < g.emi_amount * (
                            CASE 
                                WHEN g.bucket = 'sma-0' THEN 1.25
                                WHEN g.bucket IN ('sma-1', 'sma-2') THEN 1.50
                                WHEN g.bucket = 'npa' THEN 2
                                ELSE 1
                            END)  
                        THEN COALESCE(SUM(g.ledger_amount), 0) + COALESCE(SUM(g.overdue_amount), 0)  
                        ELSE g.emi_amount * 
                                (CASE 
                                    WHEN g.bucket = 'sma-0' THEN 1.25
                                    WHEN g.bucket IN ('sma-1', 'sma-2') THEN 1.50
                                    WHEN g.bucket = 'npa' THEN 2
                                    ELSE 1
                                END) 
                        END) 
                    END target_collection_amount", "g.overdue_amount"
            ])
            ->joinWith(['loanProductsEnc AS b'], false)
            ->joinWith(['assignedLoanProviders AS c' => function ($c) {
                $c->joinWith(['status0 c3'], false);
                $c->joinWith(['branchEnc AS c1'], false);
                $c->joinWith(['providerEnc AS c2'], false);
            }], false)
            ->joinWith(['loanPurposes AS d' => function ($d) {
                $d->joinWith(['financerLoanPurposeEnc AS d1'], false);
            }], false)
            ->joinWith(['loanCoApplicants e' => function ($e) {
                $e->select([
                    'e.loan_co_app_enc_id', 'e.loan_app_enc_id', 'e.father_name', 'e.name', 'e.email', 'e.phone', 'e.borrower_type',
                    'e.relation', 'e.employment_type', 'e.annual_income', 'e.co_applicant_dob', 'e.occupation',
                    'ANY_VALUE(e1.address) address', 'ANY_VALUE(e2.name) city', 'ANY_VALUE(e3.name) state', 'ANY_VALUE(e3.abbreviation) state_abbreviation', 'ANY_VALUE(e1.postal_code) postal_code', 'ANY_VALUE(e3.state_code) state_code',
                    'e.voter_card_number', 'e.aadhaar_number', 'e.pan_number',
                    "(CASE WHEN e.gender = 1 THEN 'Male' WHEN e.gender = 2 THEN 'Female' WHEN e.gender = 3 THEN 'Others' ELSE null END) gender",
                    'e.marital_status', 'e.driving_license_number', 'e.cibil_score', 'e.passport_number',
                    "CASE WHEN e.image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->image . "',e.image_location, e.image) ELSE NULL END image"
                ]);
                $e->joinWith(['loanApplicantResidentialInfos e1' => function ($e1) {
                    $e1->joinWith(['cityEnc e2'], false);
                    $e1->joinWith(['stateEnc e3'], false);
                }], false);
            }])
            ->joinWith(['loanApplicationOptions AS f'], false)
            ->joinWith(['loanAccounts AS g'], false)
            ->joinWith(['assignedLoanPayments AS h' => function ($h) {
                $h->select(['h.loan_app_enc_id', 'h1.payment_amount']);
                $h->joinWith(['loanPaymentsEnc h1' => function ($h1) {
                    $h1->andOnCondition(['h1.payment_status' => 'captured', "DATE_FORMAT(h1.created_on, '%Y-%m')" =>  new Expression("DATE_FORMAT(NOW(), '%Y-%m')")]);
                }], false);
            }]);

        if (!empty($params) && $params['loan_app_enc_id']) {
            $query->andWhere(['a.loan_app_enc_id' => $params['loan_app_enc_id']]);
        }

        $query = $query
            ->andWhere(['a.is_deleted' => 0, 'a.phone' => $user->phone])
            ->groupBy(['a.loan_app_enc_id', 'c.status', 'f.model_year', 'f.vehicle_color', 'f.emi_amount', 'c.provider_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->limit(10)
        ->asArray()
        ->all();
        foreach ($query as &$item) {
            $item["paid"] = false;
            if (in_array($item['target_collection_amount'], array_column($item['assignedLoanPayments'], 'payment_amount'))) {
                $item["paid"] = true;
            }
            unset($item['assignedLoanPayments']);
        }

        return $this->response(200, ['status' => 200, 'loan_applications' => $query ?? []]);
    }

    public function actionGetEmiDetails()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = $this->post;
        if (empty($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "loan_app_enc_id"']);
        }

        $emi = LoanAccounts::find()
            ->alias('a')
            ->select([
                'a.id', 'a.emi_date', 'c1.number_of_emis',
                'c.customer_name', 'c.loan_account_number', 'c.loan_account_enc_id',
                "a.sales_priority",
                "a.collection_priority",
                "a.telecaller_priority",
                'a.sales_target_date', 'a.telecaller_target_date', 'a.collection_target_date',
                "a.bucket AS bucket_value", 'a.loan_app_enc_id',
                'c.loan_type', 'c.phone', 'c1.loan_app_enc_id',
                'SUM(c.amount) OVER(PARTITION BY loan_account_number) total_amount',
                'COUNT(*) OVER(PARTITION BY loan_account_number) AS total_emis',
                "CONCAT(b.location_name, ', ', COALESCE(b1.name, '')) AS branch_name",
                "SUM(CASE WHEN c.emi_payment_status NOT IN ('pending','failed','rejected') AND MONTH(collection_date) = MONTH(CURRENT_DATE()) THEN c.amount ELSE 0 END) OVER(PARTITION BY loan_account_number) AS collected_amount",
                "SUM(CASE WHEN c.emi_payment_status = 'pending' THEN c.amount END) OVER(PARTITION BY loan_account_number) AS pending_amount",
                "SUM(CASE WHEN c.emi_payment_status NOT IN ('pending','failed','rejected') THEN c.amount END) OVER(PARTITION BY loan_account_number) AS paid_amount",
            ])
            ->joinWith(['emiCollections c' => function ($c) {
                $c->joinWith(['branchEnc b' => function ($b) {
                    $b->joinWith(['cityEnc b1'], false);
                }], false);
            }], false)
            ->joinWith(['loanAppEnc c1'], false)
            ->where(['a.is_deleted' => 0, 'a.loan_app_enc_id' => $params['loan_app_enc_id']])
            ->orderBY(['a.id' => SORT_DESC])
            ->limit(1)
            ->asArray()
            ->one();

        return $this->response(200, ['status' => 200, 'data' => $emi ?? []]);
    }

    // getting loan sanction reports
    private function __loanSanctionReports($loan_app_id, $provider_id)
    {
        return LoanSanctionReports::find()
            ->alias('d')
            ->select(['d.report_enc_id', 'd.loan_app_enc_id', 'd.loan_amount', 'd.processing_fee', 'd.rate_of_interest'])
            ->joinWith(['loanEmiStructures d1' => function ($d1) {
                $d1->select(['d1.loan_structure_enc_id', 'd1.sanction_report_enc_id', 'd1.due_date', 'd1.amount', 'd1.is_advance']);
            }])
            ->where(['d.loan_app_enc_id' => $loan_app_id, 'd.loan_provider_id' => $provider_id])
            ->groupBy(['d.report_enc_id'])
            ->asArray()
            ->all();
    }

    // getting loan provider detail
    public function actionLoanProviderDetail()
    {
        $params = Yii::$app->request->post();

        // if loan_provider_id missing information not found
        if (empty($params['loan_provider_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_provider_id"']);
        }

        // getting provider detail
        $assigned_loan_provider = AssignedLoanProvider::find()
            ->alias('a')
            ->select([
                'a.assigned_loan_provider_enc_id', 'a.loan_application_enc_id', 'a.status', 'b.name',
                '(CASE WHEN b.logo IS NULL OR b.logo = "" THEN CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") ELSE CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . '", b.logo_location, "/", b.logo) END) organization_logo',
                'c.loan_type', 'c.amount'
            ])
            ->joinWith(['providerEnc b'], false)
            ->joinWith(['loanApplicationEnc c'], false)
            ->where(['a.assigned_loan_provider_enc_id' => $params['loan_provider_id']])
            ->asArray()
            ->one();

        return $this->response(200, ['status' => 200, 'assigned_loan_provider' => $assigned_loan_provider]);
    }

    // checking application exists for pro benefits
    public function actionProBenefitsAccess()
    {
        if ($user = $this->isAuthorized()) {

            $loan = LoanApplications::find()
                ->alias('a')
                ->select(['a.loan_app_enc_id'])
                ->joinWith(['assignedLoanProviders b'], false)
                ->where(['a.created_by' => $user->user_enc_id, 'a.is_deleted' => 0, 'b.status' => 4, 'b.is_deleted' => 0])
                ->asArray()
                ->exists();

            return $this->response(200, ['status' => 200, 'application_exists' => $loan]);
        }

        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    // getting scratch card applications
    public function actionScratchCards()
    {
        // checking is user authorized
        if ($user = $this->isAuthorized()) {

            // getting date before 3 months
            $date = new \DateTime('now');
            $date->modify('-3 month'); // or you can use '-90 day' for deduct
            $date = $date->format('Y-m-d');

            // getting eligible loan applications for reward of this user
            $loans = LoanApplications::find()
                ->alias('a')
                ->select(['a.loan_app_enc_id'])
                ->joinWith(['assignedLoanProviders b' => function ($b) {
                    $b->joinWith(['providerEnc b1']);
                }], false)
                ->joinWith(['loanApplicationOptions c'], false)
                ->joinWith(['loanDisbursementSchedules d'], false)
                ->where(['a.created_by' => $user->user_enc_id, 'a.is_deleted' => 0, 'a.loan_type' => ['Vehicle Loan', 'Two Wheeler', 'E-Rickshaw'], 'a.source' => 'EmpowerFintech'])
                ->andWhere(['b1.slug' => 'phfleasing', 'b.status' => 31])
                ->andWhere(['>=', "d.disbursed_date", $date])
                ->asArray()
                ->count();

            // returning count of applications
            if ($loans) {
                return $this->response(200, ['status' => 200, 'count' => $loans]);
            }

            // if no data found
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    // this action is used to return coupon code
    public function actionScratchCardsCode()
    {
        // checking user authorized
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // if deal_slug empty then returning 422 missing information deal_slug
            if (empty($params['deal_slug'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "deal_slug"']);
            }

            // getting coupon codes
            $claimed = ClaimedDeals::find()
                ->select(['claimed_coupon_code'])
                ->where(['user_enc_id' => $user->user_enc_id, 'deal_enc_id' => AssignedDeals::findOne(['slug' => $params['deal_slug']])->deal_enc_id])
                ->asArray()
                ->all();

            // returning codes
            if ($claimed) {
                return $this->response(200, ['status' => 200, 'coupon_codes' => $claimed]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}
