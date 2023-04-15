<?php

namespace api\modules\v4\controllers;

use common\models\AssignedDeals;
use common\models\AssignedLoanProvider;
use common\models\ClaimedDeals;
use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use common\models\LoanSanctionReports;
use common\models\Utilities;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;

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

    // this action is called for loan details
    public function actionLoanDetails()
    {
        // checking user authorization
        if ($user = $this->isAuthorized()) {

            // getting details of loan applications of this user
            $loan_application = LoanApplications::find()
                ->alias('a')
                ->select(['a.id', 'a.loan_app_enc_id', 'a.applicant_name', 'a.amount loan_amount', 'a.loan_type', 'b.payment_token', 'b.education_loan_payment_enc_id', 'a.email', 'a.phone', 'b.payment_amount amount'])
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
                ->where(['a.is_deleted' => 0, 'a.created_by' => $user->user_enc_id])
                ->groupBy(['a.loan_app_enc_id'])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            // this query is showing applications list in sidebar to get detail
            $loan_apps = LoanApplications::find()
                ->select(['loan_app_enc_id', 'applicant_name', 'amount'])
                ->where(['is_deleted' => 0, 'created_by' => $user->user_enc_id])
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
                ->andWhere(['b1.slug' => 'phfleasing', 'b.status' => 5])
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