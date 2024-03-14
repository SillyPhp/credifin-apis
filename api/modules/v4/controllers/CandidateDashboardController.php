<?php

namespace api\modules\v4\controllers;

use common\models\AssignedDeals;
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
        Yii::$app->cache->flush();
        $user = $this->isAuth();
        $params = $this->post;
        if (!isset($params['pay_by'])) {
            return $this->response(500, ['message' => 'missing information "pay_by"']);
        }
        try {
            $type = $params['pay_by'];
            $loan_payments = LoanPayments::find()
                ->alias('a')
                ->select(['a.payment_short_url AS link'])
                ->innerJoinWith(['assignedLoanPayments AS b' => function ($b) use ($params) {
                    $b->andOnCondition(['b.loan_app_enc_id' => $params['loan_app_enc_id']]);
                }], false)
                ->andWhere([
                    'AND',
                    ['a.payment_link_type' => $type],
                    ['>=', 'a.close_by', date('Y-m-d H:i:s')],
                    ['a.payment_mode_status' => 'active'],
                    ['a.payment_status' => 'pending']
                ])
                ->asArray()
                ->one();
            if ($loan_payments) {
                $link = $loan_payments['link'];
            }
            if (empty($link)) {
                $options = [];
                $options['loan_app_enc_id'] = $params['loan_app_enc_id'];
                $options['user_id'] = $user->user_enc_id;
                $options['org_id'] = $params['org_id'];
                $options['amount'] = $params['emi_amount'];
                $options['description'] = 'Emi collection for ' . $params['loan_type'];
                $options['name'] = $params['name'];
                $options['contact'] = $params['phone'];
                $options['call_back_url'] = Yii::$app->params->EmpowerYouth->callBack . "/payment/transaction";
                // $options['brand'] = $paramsbrand;
                $options['purpose'] = $params['loan_type'];

                $keys = \common\models\credentials\Credentials::getrazorpayKey($options);
                if (!$keys) {
                    throw new \Exception('an error occurred while fetching razorpay credentials');
                }
                $api_key = $keys['api_key'];
                $api_secret = $keys['api_secret'];
                $api = new Api($api_key, $api_secret);
                $options['ref_id'] = 'EMPL-' . Yii::$app->security->generateRandomString(8);

                $options['close_by'] = time() + 24 * 60 * 60 * 30;
                if ($type == 0) {
                    $link = \common\models\payments\Payments::createLink($api, $options);
                }
                if ($type == 1) {
                    $link = \common\models\payments\Payments::createQr($api, $options);
                }
            }
            if (!$link) {
                throw new \Exception("Unable to generate.");
            }
            return $this->response(200, ['message' => 'success', 'type' => $type, 'link' => $link]);
        } catch (Exception $exception) {
            return $this->response(500, ['message' => 'an error occurred', 'error' => $exception->getMessage()]);
        }
    }

    // this action is called for loan details
    public function actionLoanDetails2()
    {
        // checking user authorization
        if ($user = $this->isAuthorized()) {

            // getting details of loan applications of this user
            $loan_application = LoanApplications::find()
                ->alias('a')
                ->select(['a.id', 'a.loan_app_enc_id', 'a.applicant_name', 'a.amount loan_amount', 'a.loan_type', 'b.payment_token', 'b.education_loan_payment_enc_id', 'a.email', 'a.phone', 'b.payment_amount amount', 'a.is_deleted'])
                ->joinWith(['educationLoanPayments b' => function ($b) {
                    $b->select(['b.loan_app_enc_id', 'b.payment_status']);
                    $b->onCondition(['b.payment_status' => ['captured', 'created', 'waived off']]);
                }])
                ->joinWith(['assignedLoanProviders c' => function ($c) {
                    $c->select(['c.assigned_loan_provider_enc_id', 'c.provider_enc_id', 'c.loan_application_enc_id', 'c.status', 'c1.name', '(CASE
                WHEN c1.logo IS NULL OR c1.logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", c1.name, "&size=50&rounded=false&background=", REPLACE(c1.initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . '", c1.logo_location, "/", c1.logo) END
                ) organization_logo']);
                    $c->joinWith(['providerEnc c1'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->joinWith(['loanApplicationNotifications e' => function ($e) {
                    $e->select(['e.message', 'e.loan_application_enc_id', 'e.created_on']);
                }])
                ->where(['a.created_by' => $user->user_enc_id])
                ->groupBy(['a.loan_app_enc_id'])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            // this query is showing applications list in sidebar to get detail
            $loan_apps = LoanApplications::find()
                ->select(['loan_app_enc_id', 'applicant_name', 'amount'])
                ->where(['created_by' => $user->user_enc_id])
                ->groupBy(['loan_app_enc_id'])
                ->orderBy(['created_on' => SORT_DESC])
                ->asArray()
                ->all();

            if ($loan_application) {

                // looping loan_application array to set educationLoanPayments data
                foreach ($loan_application as $key => $val) {

                    // if educationLoanPayments not empty then getting payment detail and add payment_token and payment_amount
                    if (!empty($loan_application['educationLoanPayments'])) {
                        $get_amount = EducationLoanPayments::find()->where(['loan_app_enc_id' => $val['loan_app_enc_id']])->one();
                        $loan_application[$key]['payment_token'] = $get_amount->payment_token;
                        $loan_application[$key]['amount'] = $get_amount->payment_amount;
                    }

                    // getting loanSanctionReports data
                    $loan_application[$key]['loanSanctionReports'] = [];
                    if (!empty($val['assignedLoanProviders']) && $val['assignedLoanProviders'][0]['status'] == 5) {
                        $loan_application[$key]['loanSanctionReports'] = $this->__loanSanctionReports($val['loan_app_enc_id'], $val['assignedLoanProviders'][0]['provider_enc_id']);
                    }
                }
            }

            // returning data
            return $this->response(200, ['status' => 200, 'loan_applications' => $loan_application, 'loan_apps' => $loan_apps]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
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
                "GROUP_CONCAT(DISTINCT d1.purpose) AS purposes"
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
                    "CASE WHEN e.image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->image . "',e.image_location, e.image) ELSE NULL END image",
                ]);
                $e->joinWith(['loanApplicantResidentialInfos e1' => function ($e1) {
                    $e1->joinWith(['cityEnc e2'], false);
                    $e1->joinWith(['stateEnc e3'], false);
                }], false);
            }]);

        if (!empty($params) && $params['loan_app_enc_id']) {
            $query->andWhere(['a.loan_app_enc_id' => $params['loan_app_enc_id']]);
        }

        $query = $query
            ->joinWith(['loanApplicationOptions f'], false)
            ->andWhere(['a.is_deleted' => 0, 'a.phone' => $user->phone])
            ->groupBy(['a.loan_app_enc_id', 'c.status', 'f.model_year', 'f.vehicle_color', 'f.emi_amount', 'c.provider_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();

        if (!$query) {
            return $this->response(200, ['status' => 200, 'data' => [], 'message' => 'Data not Found']);
        }

        return $this->response(200, ['status' => 200, 'loan_applications' => $query]);
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

        if (!$emi) {
            return $this->response(200, ['status' => 200, 'data' => [], 'message' => 'Data not Found']);
        }
        return $this->response(200, ['status' => 200, 'data' => $emi]);
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
            ->select(['a.assigned_loan_provider_enc_id', 'a.loan_application_enc_id', 'a.status', 'b.name',
                '(CASE WHEN b.logo IS NULL OR b.logo = "" THEN CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") ELSE CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . '", b.logo_location, "/", b.logo) END) organization_logo',
                'c.loan_type', 'c.amount'])
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