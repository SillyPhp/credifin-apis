<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\FinancerDesignationForm;
use api\modules\v4\models\LoanApplication;
use api\modules\v4\models\SignupForm;
use api\modules\v4\utilities\UserUtilities;
use common\models\AssignedDeals;
use common\models\AssignedFinancerLoanTypes;
use common\models\AssignedLoanProvider;
use common\models\AssignedSupervisor;
use common\models\Cities;
use common\models\ClaimedDeals;
use common\models\ColumnPreferences;
use common\models\CreditLoanApplicationReports;
use common\models\CreditRequestedData;
use common\models\CreditResponseData;
use common\models\EsignOrganizationTracking;
use common\models\extended\AssignedLoanProviderExtended;
use common\models\extended\LoanApplicationCommentsExtended;
use common\models\extended\LoanApplicationFiExtended;
use common\models\extended\LoanApplicationNotificationsExtended;
use common\models\extended\LoanApplicationPartnersExtended;
use common\models\extended\LoanApplicationPdExtended;
use common\models\extended\LoanApplicationReleasePaymentExtended;
use common\models\extended\LoanApplicationsReferencesExtended;
use common\models\extended\LoanApplicationTvrExtended;
use common\models\extended\SharedLoanApplicationsExtended;
use common\models\FinancerAssignedDesignations;
use common\models\FinancerLoanProducts;
use common\models\FinancerVehicleBrand;
use common\models\LoanApplications;
use common\models\LoanCertificates;
use common\models\LoanCoApplicants;
use common\models\LoanSanctionReports;
use common\models\LoanStatus;
use common\models\LoanTypes;
use common\models\OrganizationLocations;
use common\models\Organizations;
use common\models\Referral;
use common\models\ReferralSignUpTracking;
use common\models\SelectedServices;
use common\models\SharedLoanApplications;
use common\models\spaces\Spaces;
use common\models\UserRoles;
use common\models\Users;
use common\models\UserTypes;
use common\models\Utilities;
use Yii;
use yii\db\Expression;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;

class CompanyDashboardController extends ApiBaseController
{
    public $vehicleList = ["E-Rickshaw", "Used Commercial Vehicle Loan", "Used Car Loan", "EV Two Wheeler", "Two Wheeler"];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'lead-stats' => ['POST', 'OPTIONS'],
                'loan-applications' => ['POST', 'OPTIONS'],
                'loan-detail' => ['POST', 'OPTIONS'],
                'update-provider-status' => ['POST', 'OPTIONS'],
                'save-organization-tracking' => ['POST', 'OPTIONS'],
                'employees' => ['POST', 'OPTIONS'],
                'all-employees' => ['POST', 'OPTIONS'],
                'change-status' => ['POST', 'OPTIONS'],
                'update-employee-info' => ['POST', 'OPTIONS'],
                'dsa-connectors' => ['POST', 'OPTIONS'],
                'financer-detail' => ['POST', 'OPTIONS'],
                'save-notification' => ['POST', 'OPTIONS'],
                'save-comment' => ['POST', 'OPTIONS'],
                'share-application' => ['POST', 'OPTIONS'],
                'update-shared-application' => ['POST', 'OPTIONS'],
                'employee-search' => ['GET', 'OPTIONS'],
                'update-employee' => ['POST', 'OPTIONS'],
                'get-financer-list' => ['POST', 'OPTIONS'],
                'assign-loan-partner' => ['POST', 'OPTIONS'],
                'remove-partner' => ['POST', 'OPTIONS'],
                'status-stats' => ['POST', 'OPTIONS'],
                'status-applications' => ['POST', 'OPTIONS'],
                'add-column-preference' => ['POST', 'OPTIONS'],
                'employee-stats' => ['POST', 'OPTIONS'],
                'financer-designations' => ['POST', 'OPTIONS'],
                'financer-designation-list' => ['POST', 'OPTIONS'],
                'dashboard-stats' => ['POST', 'OPTIONS'],
                'branch-list' => ['POST', 'OPTIONS'],
                'update-tvr' => ['POST', 'OPTIONS'],
                'update-fi' => ['POST', 'OPTIONS'],
                'update-pd' => ['POST', 'OPTIONS'],
                'update-release-payment' => ['POST', 'OPTIONS'],
                'financer-vehicle-brand' => ['POST', 'OPTIONS'],
                'get-financer-vehicle-brand' => ['POST', 'OPTIONS'],
                'delete-financer-vehicle-brand' => ['POST', 'OPTIONS'],
                'update-references' => ['POST', 'OPTIONS'],
                'loan-payments' => ['POST', 'OPTIONS']
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

    // getting lead stats
    public function actionLeadStats()
    {
        // checking user authorization
        if ($user = $this->isAuthorized()) {

            // if user is organization/financer then getting its DSA's
            if ($user->organization_enc_id) {

                // getting DSA
                $leads = $this->getDsa($user->user_enc_id);

                // if leads not empty then adding assigned_user_enc_id in dsa array
                if ($leads) {
                    $dsa = [];
                    foreach ($leads as $val) {
                        $dsa[] = $val['assigned_user_enc_id'];
                    }
                }

                $dsa[] = $user->user_enc_id;
            }

            // checking if this user is financer by checking service "Loans"
            $service = SelectedServices::find()
                ->alias('a')
                ->joinWith(['serviceEnc b'], false)
                ->where(['a.organization_enc_id' => $user->organization_enc_id, 'a.is_selected' => 1, 'b.name' => 'Loans'])
                ->exists();

            // getting shared applications list to show stats of shared applications
            $shared_apps = $this->sharedApps($user->user_enc_id);

            // getting loan application stats
            $stats = LoanApplications::find()
                ->alias('a')
                ->select([
                    'COUNT(CASE WHEN a.form_type = "others" THEN 1 END) as all_applications',
                    'COUNT(CASE WHEN a.form_type = "others" and i.status = "0" THEN 1 END) as new_leads',
                    'COUNT(CASE WHEN a.form_type = "others" and i.status = "1" THEN 1 END) as accepted',
                    'COUNT(CASE WHEN a.form_type = "others" and i.status = "2" THEN 1 END) as pre_verification',
                    'COUNT(CASE WHEN a.form_type = "others" and i.status = "3" THEN 1 END) as under_process',
                    'COUNT(CASE WHEN a.form_type = "others" and i.status = "30" THEN 1 END) as sanctioned',
                    'COUNT(CASE WHEN a.form_type = "others" and i.status = "31" THEN 1 END) as disbursed',
                    'COUNT(CASE WHEN a.form_type = "others" and i.status = "32" THEN 1 END) as rejected',
                ])
                ->joinWith(['assignedLoanProviders i' => function ($i) use ($service, $user) {
                    $i->joinWith(['providerEnc j']);
                    // if loans service exists then using andWhere with provider_enc_id
                    if ($service) {
                        $i->andWhere(['i.provider_enc_id' => $user->organization_enc_id]);
                    }
                }], false)
                ->andWhere(['a.is_deleted' => 0]);

            // if its organization and service is not "Loans" then checking lead_by=$dsa
            if ($user->organization_enc_id) {
                if (!$service) {
                    $stats->andWhere(['a.lead_by' => $dsa]);
                }
            } else {
                // else checking lead_by and managed_by by logged-in user
                $stats->andWhere(['or', ['a.lead_by' => $user->user_enc_id], ['a.managed_by' => $user->user_enc_id]]);
            }

            // if shared app_ids exists then also getting data for those applications
            if ($shared_apps['app_ids']) {
                $stats->orWhere(['a.loan_app_enc_id' => $shared_apps['app_ids']]);
            }

            $stats = $stats->asArray()
                ->one();

            return $this->response(200, ['status' => 200, 'stats' => $stats]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting loan applications
    public function actionLoanApplications()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // getting applications data
            $loans = $this->__getApplications($user, $params);
            $data = $this->loanApplicationStats();

            return $this->response(200, ['status' => 200, 'loans' => $loans['loans'], 'data' => $data['data'], 'count' => $loans['count']]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting loan applications by loan status
    public function actionStatusApplications()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // if status is empty sending missing information status
            if (empty($params['status'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "status"']);
            }

            // if status is empty sending missing information loan_type
            if (empty($params['loan_product'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_product"']);
            }

            $limit = !empty($params['limit']) ? $params['limit'] : 10;
            $page = !empty($params['page']) ? $params['page'] : 1;

            // assigning status
            $status = $params['status'];
            if (!empty($params['fields_search']['status'])) {
                $status = [$params['fields_search']['status']];
            }

            // getting loan application by loan_status
            $loan_status = [];
            foreach ($status as $s) {

                // to filter loan status
                $params['filter'] = [$s];

                // getting applications
                $d = $this->__getApplications($user, $params);

                // if not empty then add it to main loan_status array
                if (!empty($d)) {
                    $loan_status[$s]['data'] = $d['loans'];
                    $loan_status[$s]['page'] = $page;
                    $loan_status[$s]['limit'] = $limit;
                }
            }

            // getting and returning loan_type_enc_id
            //            $loan_id = FinancerLoanProducts::findOne(['name' => $params['loan_product'], 'is_deleted' => 0]);

            return $this->response(200, ['status' => 200, 'loans' => $loan_status, 'loan_id' => $params['loan_product']]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function __getApplications($user, $params)
    {
        // checking if this user is financer by checking service "Loans"
        $service = SelectedServices::find()
            ->alias('a')
            ->joinWith(['serviceEnc b'], false)
            ->where(['a.organization_enc_id' => $user->organization_enc_id, 'a.is_selected' => 1, 'b.name' => 'Loans'])
            ->exists();


        //get user roles
        $specialroles = false;
        $leadsAccessOnly = false;
        $roleUnderId = null;
        if (in_array($user->username, ["Phf24", "PHF141", "phf607", "PHF491", "satparkash", "shgarima21", "Sumit1992"])) {
            $leadsAccessOnly = $user->username === "Sumit1992" ? "lap" : "vehicle";
        }

        // if user is organization/financer then getting its DSA's
        $dsa = [];
        if ($user->organization_enc_id) {

            // getting DSA
            $leads = $this->getDsa($user->user_enc_id);

            // if leads not empty then adding assigned_user_enc_id in dsa array
            if ($leads) {
                foreach ($leads as $val) {
                    $dsa[] = $val['assigned_user_enc_id'];
                }
            }

            $dsa[] = $user->user_enc_id;
        } else {
            $accessroles = UserUtilities::$rolesArray;
            $role = UserRoles::find()
                ->alias('a')
                ->where(['user_enc_id' => $user->user_enc_id])
                ->andWhere(['a.is_deleted' => 0])
                ->joinWith(['designation b' => function ($b) use ($accessroles) {
                    $b->andWhere(['in', 'b.designation', $accessroles]);
                }], true, 'INNER JOIN');
            $specialroles = $role->exists();

            if ($specialroles) {
                $roleUnder = $role->asArray()->one();
                $roleUnderId = $roleUnder['organization_enc_id'];
            }
        }

        // getting shared applications to logged-in user
        $shared_apps = $this->sharedApps($user->user_enc_id);

        $filter = !empty($params['filter']) ? $params['filter'] : null;
        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        $page = !empty($params['page']) ? $params['page'] : 1;

        // getting loan applications list
        $loans = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select([
                'a.id', 'a.loan_app_enc_id', 'a.college_course_enc_id', 'a.college_enc_id',
                'a.created_on as apply_date', 'a.application_number',
                'i.status status_number',
                'a.amount',
                'h.name applicant_name',
                'a.amount_received',
                'a.amount_due',
                'a.scholarship',
                'a.loan_type',
                'a.loan_products_enc_id',
                'a.semesters',
                'a.years',
                'a.phone',
                'a.email',
                'a.applicant_current_city as city',
                'a.applicant_dob as dob',
                'a.created_by',
                'a.lead_by',
                'a.managed_by',
                'lp.name as loan_product',
                'i.updated_on',
                'a.created_on'
            ])
            ->addSelect([
                "CONCAT(k.first_name, ' ', COALESCE(k.last_name,'')) employee_name",
                "(CASE
                    WHEN a.lead_by IS NOT NULL THEN CONCAT(lb.first_name,' ',COALESCE(lb.last_name, ''))
                    ELSE CONCAT('SELF (',cb.first_name, ' ', COALESCE(cb.last_name, ''), ')')
                END) as creator_name",
                "(CASE 
                    WHEN a.lead_by IS NOT NULL THEN '0' 
                    ELSE '1' 
                END) as is_self",
                "REPLACE(g.name, '&amp;', '&') as org_name",
                "(CASE
                    WHEN a.gender = '1' THEN 'Male'
                    WHEN a.gender = '2' THEN 'Female'
                    ELSE 'N/A'
                END) as gender"
            ])
            ->joinWith(['collegeCourseEnc f'], false)
            ->joinWith(['loanPurposes lpp' => function ($lpp) {
                $lpp->select(['lpp.loan_app_enc_id', 'lpp1.financer_loan_product_purpose_enc_id', 'lpp1.purpose']);
                $lpp->joinWith(['financerLoanPurposeEnc lpp1'], false);
            }])
            ->joinWith(['collegeEnc g'], false)
            ->joinWith(['leadBy lb'], false)
            ->joinWith(['createdBy cb' => function ($cr) {
                $cr->joinWith(['userTypeEnc ute'], false);
            }], false)
            ->joinWith(['loanCoApplicants h' => function ($h) {
                $h->andOnCondition(['h.borrower_type'=>'Borrower']);
            }])
            ->joinWith(['assignedLoanProviders i' => function ($i) use ($service, $user, $roleUnderId) {
                $i->joinWith(['providerEnc j']);
                // if loans service exists then using andWhere with provider_enc_id
                if ($service) {
                    $i->andWhere(['i.provider_enc_id' => $user->organization_enc_id]);
                }
                if (!empty($roleUnderId) || $roleUnderId != null) {
                    $i->andWhere(['i.provider_enc_id' => $roleUnderId]);
                }
                $i->joinWith(['branchEnc be']);
            }])
            ->joinWith(['managedBy k'], false)
            ->joinWith(['loanProductsEnc lp'], false)
            ->joinWith(['sharedLoanApplications n' => function ($n) {
                $n->select([
                    'n.shared_loan_app_enc_id', 'n.loan_app_enc_id', 'n.access', 'n.status', "CONCAT(n1.first_name, ' ',n1.last_name) name", 'n1.phone',
                    "CASE WHEN n1.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, "https") . "', n1.image_location, '/', n1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', concat(n1.first_name,' ',n1.last_name), '&size=200&rounded=false&background=', REPLACE(n1.initials_color, '#', ''), '&color=ffffff') END image"
                ])
                    ->joinWith(['sharedTo n1'], false)
                    ->onCondition(['n.is_deleted' => 0]);
            }])
            ->andWhere([
                'or',
                [
                    'and',
                    ['a.loan_type' => 'Loan Against Property'],
                    ['>=', 'a.loan_status_updated_on', '2023-06-01 00:00:00']
                ],
                [
                    'and',
                    ['not', ['a.loan_type' => 'Loan Against Property']],
                    ['>=', 'a.loan_status_updated_on', '2023-07-01 00:00:00']
                ],
                [
                    'or',
                    ['a.loan_type' => null],
                    ['a.loan_type' => '']
                ]
            ]);
        // if its organization and service is not "Loans" then checking lead_by=$dsa
        if ($user->organization_enc_id) {
            if (!$service) {
                $loans->andWhere(['a.lead_by' => $dsa]);
            }
        }

        if (!$user->organization_enc_id && !$specialroles && !$leadsAccessOnly) {
            // else checking lead_by and managed_by by logged-in user
            $loans->andWhere(['or', ['a.lead_by' => $user->user_enc_id], ['a.managed_by' => $user->user_enc_id]]);
        }

        // if shared app_ids exists then also getting data for those applications
        if ($shared_apps['app_ids']) {
            $loans->orWhere(['a.loan_app_enc_id' => $shared_apps['app_ids']]);
        }

        // if all, rejected or disbursed data needed
        if (isset($params['type'])) {
            switch ($params['type']) {
                case 'rejected':
                    $loans->andWhere(['or', ['i.status' => 28], ['i.status' => 32]]);
                    $loans->andWhere(['between', 'a.loan_status_updated_on', $params['start_date'], $params['end_date']]);
                    break;
                case 'disbursed':
                    $loans->andWhere(['i.status' => 31]);
                    $loans->andWhere(['between', 'a.loan_status_updated_on', $params['start_date'], $params['end_date']]);
                    break;
                case 'all':
                    $loans->andWhere(['not in', 'i.status', [28, 31, 32]]);
                    break;
                case 'tvr':
                    $loans->innerJoinWith(['loanApplicationTvrs m' => function ($m) {
                        $m->select(['m.loan_application_tvr_enc_id', 'm.loan_app_enc_id', 'm.status', 'm.assigned_to']);
                        $m->onCondition(['m.status' => 0]);
                    }]);
                    break;
                case 'fi':
                    $loans->innerJoinWith(['loanApplicationFis m' => function ($m) {
                        $m->select(['m.loan_application_fi_enc_id', 'm.loan_app_enc_id', 'm.status', 'm.assigned_to']);
                        $m->onCondition(['m.status' => 0]);
                    }]);
                    break;
                case 'pd':
                    $loans->innerJoinWith(['loanApplicationPds m' => function ($m) {
                        $m->select(['m.loan_application_pd_enc_id', 'm.loan_app_enc_id', 'm.status', 'm.assigned_to', 'm.preferred_date']);
                        $m->onCondition(['m.status' => 0]);
                    }]);
                    break;
                case 'release_payment':
                    $loans->innerJoinWith(['loanApplicationReleasePayments m' => function ($m) {
                        $m->select(['m.loan_application_release_payment_enc_id', 'm.loan_app_enc_id', 'm.status', 'm.assigned_to']);
                        $m->onCondition(['m.status' => 0]);
                    }]);
                    break;
            }
        }

        // filter to check status
        if ($filter) {
            $loans->andWhere(['in', 'i.status', $filter]);
        }

        // checking loan type filter
        if (!empty($params['loan_type'])) {
            $loans->andWhere(['a.loan_type' => $params['loan_type']]);
        }
        if (!empty($params['loan_product'])) {
            $loans->andWhere(['a.loan_products_enc_id' => $params['loan_product']]);
        }
        if (!empty($params['fields_search']['start_date'])) {
            $loans->andWhere(['>=', 'a.loan_status_updated_on', $params['fields_search']['start_date']]);
        }

        if (!empty($params['fields_search']['end_date'])) {
            $loans->andWhere(['<=', 'a.loan_status_updated_on', $params['fields_search']['end_date']]);
        }


        // fields search filter
        if (!empty($params['fields_search'])) {
            // fields array for "a" alias table
            $a = ['applicant_name', 'application_number', 'loan_status_updated_on', 'amount', 'apply_date', 'loan_type', 'loan_products_enc_id'];

            // fields array for "cb" alias table
            $name_search = ['created_by', 'sharedTo'];

            // fields array for "lpp" alias table
            $purpose_search = ['purpose'];

            // fields array for "i" alias table
            $i = ['bdo_approved_amount', 'tl_approved_amount', 'soft_approval', 'soft_sanction', 'valuation', 'disbursement_approved', 'insurance_charges', 'status', 'branch'];

            // loop fields
            foreach ($params['fields_search'] as $key => $val) {

                if (!empty($val) || $val == '0') {
                    // key match to "a" table array
                    if (in_array($key, $a)) {

                        // if key is apply_date then checking created_on time
                        if ($key == 'apply_date') {
                            $loans->andWhere(['like', 'a.created_on', $val]);
                        } else {
                            if ($key=='applicant_name'):
                                $loans->andWhere(['like', 'h.name', $val]);
                                else:
                            // else checking other fields with their names
                            $loans->andWhere(['like', 'a.' . $key, $val]);
                                endif;
                        }
                    }

                    // key match to "lpp" table array
                    if (in_array($key, $purpose_search)) {
                        if ($key == 'purpose') {
                            $loans->andWhere(['like', 'lpp1.purpose', $val]);
                        }
                    }

                    // key match to "i" table array
                    if (in_array($key, $i)) {
                        switch ($key) {
                            case 'branch':
                                $loans->andWhere(['like', 'i.branch_enc_id', $val]);
                                break;
                            case 'status':
                                $loans->andWhere(['i.status' => $val]);
                                break;
                            default:
                                $loans->andWhere(['like', 'i.' . $key, $val]);
                                break;
                        }
                    }

                    // key match to "$name_search" table array
                    if (in_array($key, $name_search)) {
                        switch ($key) {
                            case 'created_by':
                                $loans->andWhere([
                                    'or',
                                    [
                                        'and',
                                        [
                                            'not',
                                            ['a.lead_by' => null]
                                        ],
                                        ['like', 'CONCAT(lb.first_name, " ", COALESCE(lb.last_name,""))', $val]
                                    ],
                                    [
                                        'and',
                                        ['a.lead_by' => null],
                                        ['like', 'CONCAT(cb.first_name, " ", COALESCE(cb.last_name, ""))', $val]
                                    ]
                                ]);
                                break;
                            case 'sharedTo':
                                $loans->andWhere(['like', 'CONCAT(n1.first_name, " ", COALESCE(n1.last_name,""))', $val]);
                                break;
                        }
                    }
                }
            }
        }

        // keyword search matching with these fields
        if (!empty($params['search_keyword'])) {
            $loans->andWhere([
                'or',
                ['like', 'a.applicant_name', $params['search_keyword']],
                ['like', 'h.name', $params['search_keyword']],
                ['like', 'a.loan_type', $params['search_keyword']],
                ['like', 'a.amount', $params['search_keyword']],
                ['like', 'a.created_on', $params['search_keyword']],
                ['like', 'a.phone', $params['search_keyword']],
                ['like', 'a.application_number', $params['search_keyword']],
            ]);
        }

        // if form_type == diwali_dhamaka
        if (!empty($params['form_type']) && $params['form_type'] == 'diwali-dhamaka') {
            $loans->andWhere(['a.form_type' => 'diwali-dhamaka']);
        } else {
            $loans->andWhere(['!=', 'a.form_type', 'diwali-dhamaka']);
        }

        // sorting data
        if (!empty($params['field_sort'])) {

            // fields array of "a" alias table
            $a = ['applicant_name', 'application_number', 'amount', 'apply_date', 'loan_type'];

            // fields array of "i" alias table
            $i = ['bdo_approved_amount', 'tl_approved_amount', 'soft_approval', 'soft_sanction', 'valuation', 'disbursement_approved', 'insurance_charges', 'status'];

            // loop field_sort array
            foreach ($params['field_sort'] as $key => $val) {

                // if $val not null or empty
                if ($val != null || $val != '') {

                    // if val is ASC then sorting ascending
                    if ($val == 'ASC') {
                        $val = SORT_ASC;
                    } else if ($val == 'DESC') {
                        // else sort descending
                        $val = SORT_DESC;
                    }

                    if (in_array($key, $a)) {

                        // if key apply_date then order_by created_by
                        if ($key == 'apply_date') {
                            $loans->orderBy(['a.created_on' => $val]);
                        } else {
                            // else with field name
                            $loans->orderBy(['a.' . $key => $val]);
                        }

                        // if "i" alias table array matching then sorting from their
                        if (in_array($key, $i)) {
                            $loans->orderBy(['i.' . $key => $val]);
                        }
                    }
                } else {
                    // else order_by i.updated_on desc and created_on desc
                    $loans->orderBy(['i.updated_on' => SORT_DESC, 'a.created_on' => SORT_DESC]);
                }
            }
        } else {
            // else order_by i.updated_on desc and created_on desc
            $loans->orderBy(['i.updated_on' => SORT_DESC, 'a.created_on' => SORT_DESC]);
        }

        if (!empty($leadsAccessOnly)) {
            if ($leadsAccessOnly == 'vehicle') {
                $where = ['lp.name' => $this->vehicleList];
            } else {
                $where = ['lp.name' => ['Loan Against Property', 'Capital LAP BC 10', 'Affordable Housing Loan BC 15']];
            }
            $loans->andWhere($where);
        }
        $loans->andWhere(['a.is_deleted' => 0, 'a.is_removed' => 0]);
        $count = $loans->count();

        $loans = $loans
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($loans) {
            foreach ($loans as $key => $val) {
                $loans[$key]['sharedTo'] = $val['sharedLoanApplications'];
                unset($loans[$key]['sharedLoanApplications']);

                $loans[$key]['access'] = null;
                $loans[$key]['shared_by'] = null;
                $loans[$key]['is_shared'] = false;
                if ($shared_apps['app_ids']) {
                    foreach ($shared_apps['shared'] as $s) {
                        if ($val['loan_app_enc_id'] == $s['loan_app_enc_id']) {
                            $loans[$key]['access'] = $s['access'];
                            $loans[$key]['shared_by'] = $s['shared_by'];
                            $loans[$key]['is_shared'] = true;
                        }
                    }
                }

                $d = ClaimedDeals::find()
                    ->alias('a')
                    ->select(['a.claimed_deal_enc_id', 'a.deal_enc_id', 'a.user_enc_id', 'a.claimed_coupon_code'])
                    ->joinWith(['dealEnc b'], false)
                    ->andWhere(['a.user_enc_id' => $val['created_by'], 'a.is_deleted' => 0, 'b.slug' => 'diwali-dhamaka'])
                    ->asArray()
                    ->all();
                $loans[$key]['claimedDeals'] = $d;

                $provider_id = $this->getFinancerId($user);
                //                $provider = AssignedLoanProvider::findOne(['loan_application_enc_id' => $val['loan_app_enc_id'], 'provider_enc_id' => $provider_id]);

                $provider = AssignedLoanProvider::find()
                    ->alias('a')
                    ->select(['a.assigned_loan_provider_enc_id', 'a.branch_enc_id', 'b.location_name', 'b1.name city', 'a.bdo_approved_amount', 'a.tl_approved_amount', 'a.soft_approval', 'a.soft_sanction', 'a.valuation', 'a.disbursement_approved', 'a.insurance_charges'])
                    ->joinWith(['branchEnc b' => function ($b) {
                        $b->joinWith(['cityEnc b1']);
                    }], false)
                    ->andWhere(['a.loan_application_enc_id' => $val['loan_app_enc_id'], 'a.provider_enc_id' => $provider_id])
                    ->asArray()
                    ->one();

                if (!empty($provider)) {
                    $loans[$key]['bdo_approved_amount'] = $provider['bdo_approved_amount'];
                    $loans[$key]['tl_approved_amount'] = $provider['tl_approved_amount'];
                    $loans[$key]['soft_approval'] = $provider['soft_approval'];
                    $loans[$key]['soft_sanction'] = $provider['soft_sanction'];
                    $loans[$key]['valuation'] = $provider['valuation'];
                    $loans[$key]['disbursement_approved'] = $provider['disbursement_approved'];
                    $loans[$key]['insurance_charges'] = $provider['insurance_charges'];
                    $loans[$key]['branch_id'] = $provider['branch_enc_id'];
                    $loans[$key]['branch'] = $provider['location_name'] ? $provider['location_name'] . ', ' . $provider['city'] : $provider['city'];
                }
            }
        }

        return ['loans' => $loans, 'count' => $count];
    }


    private function loanApplicationStats()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        $query = AssignedLoanProvider::find()
            ->alias('a')
            ->select([
                "COUNT(CASE WHEN a.status = '33' THEN b.loan_app_enc_id END) as completed",
                "COUNT(CASE WHEN a.status != '33' AND a.status != '0' THEN b.loan_app_enc_id END) as pending",
            ])
            ->joinWith(['loanApplicationEnc b'], false)
            ->andWhere(['a.is_deleted' => 0, 'b.is_deleted' => 0])
            ->andWhere(['YEAR(b.loan_status_updated_on)' => $currentYear])
            ->andWhere(['MONTH(b.loan_status_updated_on)' => $currentMonth]);

        $count = $query->count();
        $queryResults = $query
            ->asArray()
            ->one();

        $queryResults['new_case'] = $count;

        if ($queryResults) {
            return ['status' => 200, 'data' => $queryResults];
        } else {
            return ['status' => 404, 'message' => 'Not found'];
        }
    }



    //    private function __partnerApplications($user)
    //    {
    //        return LoanApplicationPartnersExtended::find()
    //            ->alias('a')
    //            ->select(['a.loan_app_enc_id'])
    //            ->joinWith(['providerEnc b'], false)
    //            ->where(['a.is_deleted' => 0, 'a.partner_enc_id' => $user->organization_enc_id])
    //            ->asArray()
    //            ->all();
    //    }

    // getting shared loan applications
    private function sharedApps($user_id)
    {
        // getting loan applications shared to this user
        $shared = SharedLoanApplications::find()
            ->alias('a')
            ->select(["a.loan_app_enc_id" , "a.access"])
            ->addSelect(["CONCAT(b.first_name, ' ' ,b.last_name) shared_by"])
            ->joinWith(['sharedBy b'], false)
            ->joinWith(['loanAppEnc c'], false)
            ->where(['a.is_deleted' => 0, 'a.status' => 'Active', 'a.shared_to' => $user_id, 'c.is_deleted' => 0])
            ->asArray()
            ->all();
        $loan_app_ids = [];
        if ($shared) {
            foreach ($shared as $s) {
                $loan_app_ids[] = $s["loan_app_enc_id"];
            }
        }

        // returning application id's and shared detail
        return ['app_ids' => $loan_app_ids, 'shared' => $shared];
    }

    // getting financer dsa list
    private function getDsa($user_id)
    {
        // getting dsa of this user
        return AssignedSupervisor::find()
            ->select(['assigned_user_enc_id'])
            ->where(['supervisor_enc_id' => $user_id, 'supervisor_role' => 'Lead Source', 'is_supervising' => 1])
            ->groupBy(['assigned_user_enc_id'])
            ->asArray()
            ->all();
    }

    // getting detail of loan application
    public function actionLoanDetail()
    {
        // checking user authorization
        if ($user = $this->isAuthorized()) {

            // getting date before 1 month
            $date = new \DateTime('now');
            //            $date->modify('-30 day'); // or you can use '-90 day' for deduct
            $date = $date->format('Y-m-d H:i:s');

            $params = Yii::$app->request->post();

            // getting provider/financer id
            if (isset($params['provider_id'])&&!empty($params['provider_id'])):
                $provider_id = $params['provider_id'];
            else:
            $provider_id = $this->getFinancerId($user);
            endif;

            // if not found provider id
            if ($provider_id == null) {
                return $this->response(409, ['status' => 409, 'message' => 'provider id not found']);
            }

            // if loan_id empty
            if (empty($params["loan_id"])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

           $subquery = (new \yii\db\Query())
               ->select([
                        'ANY_VALUE(report_enc_id) report_enc_id','ANY_VALUE(d4.loan_app_enc_id) loan_app_enc_id','d4.loan_co_app_enc_id',
                        'ANY_VALUE(d5.file_url) file_url', 'ANY_VALUE(d5.filename) filename',
                        'ANY_VALUE(d4.created_on) created_on', "DATEDIFF('" . $date . "', ANY_VALUE(d4.created_on)) as days_till_now",
                        'ANY_VALUE(d6.request_source) request_source'
                    ])
            ->from(['d4' => CreditLoanApplicationReports::tableName()])
            ->join('INNER JOIN', ['d5' => CreditResponseData::tableName()], 'd5.response_enc_id = d4.response_enc_id')
            ->join('INNER JOIN', ['d6' => CreditRequestedData::tableName()], 'd6.request_enc_id = d5.request_enc_id')
            ->orderBy(['created_on' => SORT_DESC])
            ->andWhere(['d4.is_deleted' => 0])
            ->groupBy(['d4.loan_co_app_enc_id']);

            // getting loan detail
            $loan = LoanApplications::find()
                ->alias('a')
                ->select([
                    'a.loan_app_enc_id', 'a.amount', 'a.created_on apply_date', 'a.application_number', 'a.capital_roi', 'a.capital_roi_updated_on', "CONCAT(ub.first_name, ' ', ub.last_name) AS capital_roi_updated_by", 'a.registry_status', 'a.registry_status_updated_on', "CONCAT(rs.first_name, ' ', rs.last_name) AS registry_status_updated_by",
                    'lpe.name as loan_product', 'a.chassis_number', 'a.rc_number', 'a.invoice_date', 'a.invoice_number', 'a.pf', 'a.roi', 'a.number_of_emis', 'a.emi_collection_date', 'a.battery_number',
                    "CASE WHEN ub.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . "', ub.image_location, '/', ub.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(ub.first_name,' ',ub.last_name), '&size=200&rounded=false&background=', REPLACE(ub.initials_color, '#', ''), '&color=ffffff') END update_image",
                    "CASE WHEN rs.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . "', rs.image_location, '/', rs.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(rs.first_name,' ',rs.last_name), '&size=200&rounded=false&background=', REPLACE(rs.initials_color, '#', ''), '&color=ffffff') END rs_image",
                    'ANY_VALUE(b.status) as loan_status', 'a.loan_type', 'ANY_VALUE(i1.name) city','ANY_VALUE(i2.name) state',
                    'ANY_VALUE(i2.abbreviation) state_abbreviation','ANY_VALUE(i2.state_code) state_code','ANY_VALUE(i.postal_code) postal_code',
                    'ANY_VALUE(i.address) address','ANY_VALUE(k.access) access','lp.name as loan_product', "(CASE WHEN a.loan_app_enc_id IS NOT NULL THEN FALSE ELSE TRUE END) as login_fee", 'a.loan_products_enc_id',
                    'de.name as dealer_name', "(CASE WHEN de.logo IS NULL OR de.logo = '' THEN CONCAT('https://ui-avatars.com/api/?name=', de.name, '&size=200&rounded=false&background=', REPLACE(de.initials_color, '#', ''), '&color=ffffff') ELSE CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . "', de.logo_location, '/', de.logo) END) dealer_logo",
                ])
                ->joinWith(['assignedDealer de'], false)
                ->joinWith(['loanProductsEnc lpe'], false)
                ->joinWith(['capitalRoiUpdatedBy ub'], false)
                ->joinWith(['registryStatusUpdatedBy rs'], false)
                ->joinWith(['assignedLoanProviders b'], false)
                ->joinWith(['loanCoApplicants d' => function ($d) use ($date,$subquery) {
                    $d->select([
                        'd.loan_co_app_enc_id', 'd.loan_app_enc_id', 'd.name', 'd.email', 'd.phone', 'd.borrower_type',
                        'd.relation', 'd.employment_type', 'd.annual_income', 'd.co_applicant_dob', 'd.occupation',
                        'ANY_VALUE(d1.address) address','ANY_VALUE(d2.name) city','ANY_VALUE(d3.name) state','ANY_VALUE(d3.abbreviation) state_abbreviation','ANY_VALUE(d1.postal_code) postal_code','ANY_VALUE(d3.state_code) state_code',
                        'd.voter_card_number', 'd.aadhaar_number', 'd.pan_number', 'd.gender', 'd.marital_status', 'd.driving_license_number', 'd.cibil_score',
                        "CASE WHEN d.image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->image . "',d.image_location, d.image) ELSE NULL END image",
                    ]);
                    $d->groupBy(['d.loan_co_app_enc_id']);
                    $d->joinWith(['loanApplicantResidentialInfos d1' => function ($d1) {
                        $d1->joinWith(['cityEnc d2'], false);
                        $d1->joinWith(['stateEnc d3'], false);
                    }], false);
                    $d->joinWith([
                        'creditLoanApplicationReports d4' => function ($k) use ($subquery) {
                            $k->from(['subquery' => $subquery]);
                        }
                    ]);
                }])
                ->joinWith(['loanApplicationNotifications e' => function ($e) {
                    $e->select(['e.notification_enc_id', 'e.message', 'e.loan_application_enc_id', 'e.created_on', "CONCAT(e1.first_name,' ',e1.last_name) created_by"]);
                    $e->joinWith(['createdBy e1'], false);
                    $e->onCondition(['e.is_deleted' => 0, 'e.source' => 'EL']);
                }])
                ->joinWith(['loanApplicationComments f' => function ($f) {
                    $f->select([
                        'f.comment_enc_id', 'f.comment', 'f.loan_application_enc_id', 'f.created_on', "CONCAT(f1.first_name,' ',f1.last_name) created_by",
                        "CASE WHEN f1.image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . "',f1.image_location, '/', f1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(f1.first_name,' ',f1.last_name), '&size=200&rounded=true&background=', REPLACE(f1.initials_color, '#', ''), '&color=ffffff') END user_image",
                        "CASE WHEN f2.logo IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . "', f2.logo_location, '/', f2.logo) ELSE CONCAT('https://ui-avatars.com/api/?name=', f2.name, '&size=200&rounded=false&background=', REPLACE(f2.initials_color, '#', ''), '&color=ffffff') END logo",
                    ]);
                    $f->joinWith(['createdBy f1' => function ($f1) {
                        $f1->joinWith(['organizations f2']);
                    }], false);
                    $f->onCondition(['f.is_deleted' => 0, 'f.source' => 'EL']);
                }])
                ->joinWith(['loanPurposes g' => function ($g) {
                    $g->select(['g.financer_loan_purpose_enc_id', 'g.financer_loan_purpose_enc_id', 'g.loan_app_enc_id', 'g1.purpose']);
                    $g->joinWith(['financerLoanPurposeEnc g1'], false);
                    $g->onCondition(['g.is_deleted' => 0]);
                }])
                ->joinWith(['loanVerificationLocations h' => function ($h) {
                    $h->select([
                        'h.loan_verification_enc_id', 'h.loan_app_enc_id', 'h.location_name',
                        'h.local_address', 'h.latitude', 'h.longitude', "CONCAT(h1.first_name,' ',h1.last_name) created_by", 'h.created_on',
                        "CASE WHEN h1.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, "https") . "', h1.image_location, '/', h1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(h1.first_name,' ',h1.last_name), '&size=200&rounded=false&background=', REPLACE(h1.initials_color, '#', ''), '&color=ffffff') END image"
                    ]);
                    $h->joinWith(['createdBy h1'], false);
                    $h->onCondition(['h.is_deleted' => 0]);
                }])
                ->joinWith(['loanApplicantResidentialInfos i' => function ($i) {
                    $i->joinWith(['cityEnc i1'], false);
                    $i->joinWith(['stateEnc i2'], false);
                }], false)
                ->joinWith(['sharedLoanApplications k' => function ($k) {
                    $k->select([
                        'k.shared_loan_app_enc_id', 'k.loan_app_enc_id', 'k.access', 'k.status', "CONCAT(k1.first_name,' ',k1.last_name) name", 'k1.phone',
                        "CASE WHEN k1.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, "https") . "', k1.image_location, '/', k1.image) ELSE CONCAT('https://ui-avatars.com/api/?name=', CONCAT(k1.first_name,' ',k1.last_name), '&size=200&rounded=false&background=', REPLACE(k1.initials_color, '#', ''), '&color=ffffff') END image"
                ])->joinWith(['sharedTo k1'], false)
                ->onCondition(['k.is_deleted' => 0]);
                }])
                ->joinWith(['assignedLoanPayments p' => function ($p) {
                    $p->select(['p.loan_app_enc_id', 'p1.payment_mode', 'p1.payment_status', 'p1.payment_amount']);
                    $p->orderBy(['p1.created_on' => SORT_DESC]);
                    $p->joinWith(['loanPaymentsEnc p1'], false);
                }])
                ->joinWith(['loanProductsEnc lp'], false)
                ->joinWith(['loanApplicationTvrs l' => function ($m) {
                    $m->select(['l.loan_application_tvr_enc_id', 'l.loan_app_enc_id', 'l.status', 'l.assigned_to']);
                }])
                ->joinWith(['loanApplicationPds m' => function ($m) {
                    $m->select(['m.loan_application_pd_enc_id', 'm.preferred_date', 'm.loan_app_enc_id', 'm.status', 'm.assigned_to', 'm.preferred_date']);
                }])
                ->joinWith(['loanApplicationReleasePayments n' => function ($m) {
                    $m->select(['n.loan_application_release_payment_enc_id', 'n.loan_app_enc_id', 'n.status', 'n.assigned_to']);
                }])
                ->joinWith(['loanApplicationsReferences o' => function ($o) {
                    $o->select(['o.references_enc_id', 'o.loan_app_enc_id', 'o.type', 'o.value', 'o.name', 'o.reference']);
                    $o->onCondition(['o.is_deleted' => 0]);
                }])
                ->joinWith(['loanApplicationFis q' => function ($m) {
                    $m->select(['q.loan_application_fi_enc_id', 'q.loan_app_enc_id', 'q.status', 'q.assigned_to']);
                }])
                ->where(['a.loan_app_enc_id' => $params['loan_id'], 'a.is_deleted' => 0])
                ->limit(1)
                ->asArray()
                ->one();


            // if loan application exists
            if ($loan) {
                //renaming key in loan application
                $loan['sharedTo'] = $loan['sharedLoanApplications'];
                unset($loan['sharedLoanApplications']);

                // getting loan sanction reports
                $loan['loanSanctionReports'] = LoanSanctionReports::find()
                    ->alias('d')
                    ->select(['d.report_enc_id', 'd.loan_app_enc_id', 'd.loan_amount', 'd.processing_fee', 'd.rate_of_interest', 'd.fldg'])
                    ->joinWith(['loanEmiStructures d1' => function ($d1) {
                        $d1->select(['d1.loan_structure_enc_id', 'd1.sanction_report_enc_id', 'd1.due_date', 'd1.amount', 'd1.is_advance']);
                    }])
                    ->where(['d.loan_app_enc_id' => $loan['loan_app_enc_id'], 'd.loan_provider_id' => $provider_id])
                    ->groupBy(['d.report_enc_id'])
                    ->limit(1)
                    ->asArray()
                    ->one();

                // if loan certificates exists then getting their images private links
                $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                if (!empty($loan['creditLoanApplicationReports'])) {
                    foreach ($loan['creditLoanApplicationReports'] as $key => $value) {
                        if (!empty($value['file_url'])) {
                            $parsedUrl = parse_url($value['file_url']);
                            $path = $parsedUrl['path'];
                            $path = ltrim($path, '/');
                            $file_url = $my_space->signedURL($path, "15 minutes");
                            $loan['creditLoanApplicationReports'][$key]['file_url'] = $file_url;
                        }
                    }
                }


                if (!empty($loan['loanCoApplicants'])) {
                    foreach ($loan['loanCoApplicants'] as $keys => $values) {
                        if (!empty($values['creditLoanApplicationReports'])) {
                            foreach ($values['creditLoanApplicationReports'] as $key => $value) {
                                if (!empty($value['file_url'])) {
                                    $parsedUrl = parse_url($value['file_url']);
                                    $path = $parsedUrl['path'];
                                    $path = ltrim($path, '/');
                                    $file_url = $my_space->signedURL($path, "15 minutes");
                                    $loan['loanCoApplicants'][$keys]['creditLoanApplicationReports'][$key]['file_url'] = $file_url;
                                }
                            }
                        }
                    }
                }

                // getting other details of this loan application from provider
                $branch = AssignedLoanProvider::find()
                    ->alias('a')
                    ->select(['a.assigned_loan_provider_enc_id', 'a.branch_enc_id', 'b.location_name', 'b1.name city', 'a.bdo_approved_amount', 'a.tl_approved_amount', 'a.soft_approval', 'a.soft_sanction', 'a.valuation', 'a.disbursement_approved', 'a.insurance_charges'])
                    ->joinWith(['branchEnc b' => function ($b) {
                        $b->joinWith(['cityEnc b1']);
                    }], false)
                    ->andWhere(['a.loan_application_enc_id' => $loan['loan_app_enc_id'], 'a.provider_enc_id' => $provider_id])
                    ->limit(1)
                    ->asArray()
                    ->one();

                if (!empty($branch)) {
                    $loan['branch_id'] = $branch['branch_enc_id'];
                    $loan['branch'] = $branch['location_name'] ? $branch['location_name'] . ', ' . $branch['city'] : $branch['city'];
                    $loan['bdo_approved_amount'] = $branch['bdo_approved_amount'];
                    $loan['tl_approved_amount'] = $branch['tl_approved_amount'];
                    $loan['soft_approval'] = $branch['soft_approval'];
                    $loan['soft_sanction'] = $branch['soft_sanction'];
                    $loan['valuation'] = $branch['valuation'];
                    $loan['disbursement_approved'] = $branch['disbursement_approved'];
                    $loan['insurance_charges'] = $branch['insurance_charges'];
                }

                // getting loan application partners
                $loan['loan_partners'] = $this->__applicationPartners($user, $loan['loan_app_enc_id']);

                if (!empty($loan['loan_products_enc_id'])) {
                    $product = FinancerLoanProducts::find()
                        ->alias('a')
                        ->select(['b1.value'])
                        ->joinWith(['assignedFinancerLoanTypeEnc b' => function ($b) {
                            $b->joinWith(['loanTypeEnc b1']);
                        }], false)
                        ->where(['a.financer_loan_product_enc_id' => $loan['loan_products_enc_id']])
                        ->limit(1)
                        ->asArray()
                        ->one();
                    $loan['loan_type_code'] = $product['value'];
                } else {
                    $loan['loan_type_code'] = LoanTypes::findOne(['name' => $loan['loan_type']])->value;
                }

                // getting loan type code

                return $this->response(200, ['status' => 200, 'loan_detail' => $loan]);
            }

            // if application detail not found
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    //    public function actionUniqueLink()
    //    {
    //        $loan_app_enc_id = Yii::$app->request->post('loan_app_enc_id');
    //
    //        if ($loan_app_enc_id !== null) {
    //            $loan = LoanApplications::find()
    //                ->alias('a')
    //                ->select(['a.phone'])
    //                ->joinWith([''])
    //                ->where(['loan_app_enc_id' => $loan_app_enc_id])
    //                ->asArray()
    //                ->all();
    //
    //            } else {
    //                return "Loan application not found.";
    //            }
    //    }

    public function actionLoanCertificates()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            $query = LoanCertificates::find()
                ->alias('a')
                ->select(['a.certificate_enc_id', 'a.loan_app_enc_id', 'a.short_description', 'a.certificate_type_enc_id', 'a.number', 'c1.name', 'a.proof_image', 'a.proof_image_location', 'a.created_on', 'CONCAT(c2.first_name," ",c2.last_name) created_by'])
                ->joinWith(['certificateTypeEnc c1'], false)
                ->joinWith(['createdBy c2'], false)
                ->andWhere(['a.loan_app_enc_id' => $params['loan_id'], 'a.is_deleted' => 0])
                ->asArray()
                ->all();

            if ($query) {
                foreach ($query as $key => $val) {
                    if ($val['proof_image']) {
                        $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $proof = $my_space->signedURL(Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->image . $val['proof_image_location'] . DIRECTORY_SEPARATOR . $val['proof_image'], "15 minutes");
                        $query[$key]['proof_image'] = $proof;
                    }
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
            }
            return $this->response(200, ['status' => 200, 'loan_detail' => $query]);
        }
    }

    // getting partnered applications
    private function __applicationPartners($user, $loan_id)
    {
        return LoanApplicationPartnersExtended::find()
            ->alias('a')
            ->select(['a.loan_application_partner_enc_id', 'a.loan_app_enc_id', 'a.type', 'a.ltv', 'a.partner_enc_id', 'b.name'])
            ->joinWith(['partnerEnc b'], false)
            ->where(['a.is_deleted' => 0, 'a.provider_enc_id' => $user->organization_enc_id, 'a.loan_app_enc_id' => $loan_id])
            ->asArray()
            ->all();
    }

    // updating loan status
    public function actionUpdateProviderStatus()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // getting provider id
            $provider_id = $this->getFinancerId($user);

            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            if (empty($params['status'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "status"']);
            }

            // getting object to update
            $provider = AssignedLoanProviderExtended::findOne(['loan_application_enc_id' => $params['loan_id'], 'provider_enc_id' => $provider_id, 'is_deleted' => 0]);
            // if provider not found to update status
            if (!$provider) {
                return $this->response(404, ['status' => 404, 'message' => 'provider not found with this loan_id']);
            }

            $loanApp = LoanApplications::findOne(['loan_app_enc_id' => $params['loan_id'], 'is_deleted' => 0]);

            $prevStatus = $provider->status;
            // updating data
            $provider->status = $params['status'];
            $loanApp->updated_by = $provider->updated_by = $user->user_enc_id;
            $provider->loan_status_updated_on = date('Y-m-d H:i:s');
            $provider->updated_on = date('Y-m-d H:i:s');
            $loanApp->loan_status_updated_on = date('Y-m-d H:i:s');
            $loanApp->updated_on = date('Y-m-d H:i:s');
            if ($loanApp->update() && $provider->update()) {

                $notificationUsers = new UserUtilities();
                $userIds = $notificationUsers->getApplicationUserIds($params['loan_id']);
                $searchable = [$prevStatus, $params['status']];
                $loanStatus = LoanStatus::find()
                    ->andWhere(['in', 'value', $searchable])
                    ->asArray()
                    ->all();
                $updated_by = $user->first_name . " " . $user->last_name;
                $notificationBody = "Status: " . $loanStatus[0]['loan_status'] . " -> " . $loanStatus[1]['loan_status'];
                if (!empty($userIds)) {
                    $allNotifications = [];
                    foreach ($userIds as $uid) {
                        $utilitiesModel = new \common\models\Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $notification = [
                            'notification_enc_id' => $utilitiesModel->encrypt(),
                            'user_enc_id' => $uid,
                            'title' => "Application status of $loanApp->application_number changed by $updated_by",
                            'description' => $notificationBody,
                            'link' => '/account/loan-application/' . $params['loan_id'],
                            'created_by' => $user->user_enc_id
                        ];

                        array_push($allNotifications, $notification);
                    }
                }

                $notificationUsers->saveNotification($allNotifications);

                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred while updating status', 'error' => $provider->getErrors()]);
            }
        }

        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    // saving data for organization tracking
    public function actionSaveOrganizationTracking()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $org_id = $user->organization_enc_id;

            // if org_id empty then getting organization id from referral_enc_id of whom referred this user of this user
            if (!$org_id) {
                $ref_enc_id = ReferralSignUpTracking::findOne(['sign_up_user_enc_id' => $user->user_enc_id])->referral_enc_id;
                if ($ref_enc_id) {
                    $org_id = Referral::findOne(['referral_enc_id' => $ref_enc_id])->organization_enc_id;
                }
            }

            // adding data to this table
            $model = new EsignOrganizationTracking();
            $model->esign_tracking_enc_id = Yii::$app->getSecurity()->generateRandomString();
            $model->organization_enc_id = $org_id;
            $model->employee_id = $user->user_enc_id;
            $model->legality_document_id = $params['legality_document_id'];
            $model->empower_loans_tracking_id = $params['empower_loans_tracking_id'];
            $model->created_by = $user->user_enc_id;
            $model->created_on = date('Y-m-d H:i:s');
            if (!$model->save()) {
                // if data not saved
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting employee, dsa and connector list of this financer
    public function actionEmployees()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // checking if its organization
            $org_id = $user->organization_enc_id;
            if (!$user->organization_enc_id) {
                $findOrg = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
                $org_id = $findOrg->organization_enc_id;
            }
            if ($org_id) {

                $params = Yii::$app->request->post();

                // getting employees list
                $employee = $this->employeesList($org_id, $params);

                $deleted = $this->employeesList($org_id, $params, 'deleted');

                // getting dsa's list
                $dsa = $this->dsaList($user->user_enc_id, $params);


                // extracting dsa user_enc_Id
                $dsa_id = [];
                if ($dsa) {
                    foreach ($dsa as $d) {
                        $dsa_id[] = $d['user_enc_id'];
                    }
                }

                $dsa_id[] = $user->user_enc_id;

                // getting connectors list
                $connector = $this->connectorsList($dsa_id, $params);

                return $this->response(200, ['status' => 200, 'employees' => $employee, 'dsa' => $dsa, 'connector' => $connector, 'deleted' => $deleted]);
            } else {
                return $this->response(403, ['status' => 403, 'message' => 'only authorized by financer']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting employee list
    private function employeesList($org_id, $params = null, $deleted = null)
    {
        // getting employees data
        $employee = UserRoles::find()
            ->alias('a')
            ->select([
                'a.role_enc_id',
                'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", concat(b.first_name," ",b.last_name), "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image',
                'a.employee_joining_date', 'a.user_enc_id', 'b.username', 'b.email', 'b.phone', 'b.first_name', 'b.last_name', 'b.status', 'c.user_type', 'a.employee_code',
                'd.designation', 'a.designation_id', 'CONCAT(e.first_name," ",e.last_name) reporting_person', 'CONCAT(f.location_name, ", ", f1.name) AS branch_name', 'f.address branch_address', 'f1.name city_name', 'f.location_enc_id branch_id', 'a.grade', 'b.created_on platform_joining_date'
            ])
            ->joinWith(['userEnc b'], false)
            ->joinWith(['userTypeEnc c'], false)
            ->joinWith(['designation d'], false)
            ->joinWith(['reportingPerson e'], false)
            ->joinWith(['branchEnc f' => function ($f) {
                $f->joinWith(['cityEnc f1']);
            }], false)
            ->where(['a.organization_enc_id' => $org_id, 'c.user_type' => 'Employee', 'a.is_deleted' => 0]);

        // delete employees list
        if ($deleted) {
            $employee->andWhere(['b.is_deleted' => 1]);
        } else {
            $employee->andWhere(['b.is_deleted' => 0]);
        }

        if ($params != null && !empty($params['fields_search'])) {
            $a = ['designation_id', 'employee_code', 'grade', 'employee_joining_date'];
            $b = ['phone', 'email', 'username', 'status', 'name', 'platform_joining_date'];
            foreach ($params['fields_search'] as $key => $value) {
                if (!empty($value) || $value == '0') {

                    if (in_array($key, $a)) {
                        if ($key == 'designation_id') {
                            $employee->andWhere(['a.' . $key => $value]);
                        } else {
                            $employee->andWhere(['like', 'a.' . $key, $value]);
                        }
                    }
                    if (in_array($key, $b)) {
                        if ($key == 'status') {
                            $employee->andWhere(['like', 'b.status', $value . '%', false]);
                        } elseif ($key == 'name') {
                            $employee->andWhere(['like', 'CONCAT(b.first_name," ",b.last_name)', $value]);
                        } elseif ($key == 'platform_joining_date') {
                            $employee->andWhere(['like', 'b.created_on', $value]);
                        } else {
                            $employee->andWhere(['like', 'b.' . $key, $value]);
                        }
                    }
                    switch ($key) {
                        case 'reporting_person':
                            $employee->andWhere(['like', 'CONCAT(e.first_name," ",e.last_name)', $value]);
                            break;
                        case 'branch':
                            $employee->andWhere(['like', 'f.location_enc_id', $value]);
                            break;
                    }
                }
            }
        }

        if ($params != null && !empty($params['employee_search'])) {
            $employee->andWhere([
                'and',
                [
                    'or',
                    ['like', 'CONCAT(b.first_name, " ", b.last_name)', $params['employee_search']],
                    ['like', 'b.username', $params['employee_search']],
                    ['like', 'b.email', $params['employee_search']],
                    ['like', 'b.phone', $params['employee_search']],
                    ['like', 'a.employee_code', $params['employee_search']],
                ],
                ['b.status' => 'active'],
            ]);
        }

        // filter employee search on employee reporting person
        if ($params != null && !empty($params['reporting_person'])) {
            $employee->andWhere([
                'like', 'CONCAT(e.first_name," ", e.last_name)', $params['reporting_person'],
            ]);
        }


        // checking if this employee already exists in list from frontend
        if ($params != null && !empty($params['alreadyExists'])) {
            $employee->andWhere(['not', ['a.user_enc_id' => $params['alreadyExists']]]);
        }

        return $employee->asArray()
            ->all();
    }



    // getting dsa list
    private function dsaList($user_id, $params = null)
    {
        // getting dsa from assigned supervisor table
        $dsa = AssignedSupervisor::find()
            ->alias('a')
            ->select([
                'a.assigned_user_enc_id user_enc_id',
                'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", concat(b.first_name," ",b.last_name), "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image', 'b.username', 'b.email', 'b.phone', 'b.first_name', 'b.last_name', 'b.status', new Expression('"DSA" as user_type')
            ])
            ->joinWith(['assignedUserEnc b'], false)
            ->where(['a.supervisor_enc_id' => $user_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);

        // filter dsa search on dsa name, username, email and phone
        if ($params != null && !empty($params['dsa_search'])) {
            $dsa->andWhere([
                'or',
                ['like', 'CONCAT(b.first_name," ", b.last_name)', $params['dsa_search']],
                ['like', 'b.username', $params['dsa_search']],
                ['like', 'b.email', $params['dsa_search']],
                ['like', 'b.phone', $params['dsa_search']],
            ]);
        }

        // returning data
        return $dsa->asArray()
            ->all();
    }


    // getting connector list
    private function connectorsList($user_id, $params = null)
    {
        // getting connector list
        $connector = SelectedServices::find()
            ->alias('a')
            ->select([
                'a.created_by user_enc_id',
                'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", concat(b.first_name," ",b.last_name), "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image', 'b.username', 'b.email', 'b.phone', 'b.first_name', 'b.last_name', 'b.status', new Expression('"Connector" as user_type')
            ])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['serviceEnc c'], false)
            ->where(['a.assigned_user' => $user_id, 'c.name' => 'Connector', 'b.is_deleted' => 0, 'a.is_selected' => 1]);

        // filter connector search on employee name, username, email and phone
        if ($params != null && !empty($params['connector_search'])) {
            $connector->andWhere([
                'or',
                ['like', 'CONCAT(b.first_name," ", b.last_name)', $params['connector_search']],
                ['like', 'b.username', $params['connector_search']],
                ['like', 'b.email', $params['connector_search']],
                ['like', 'b.phone', $params['connector_search']],
            ]);
        }

        return $connector->asArray()
            ->all();
    }


    // employee search
    public function actionEmployeeSearch($employee_search, $type, $loan_id = null)
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $params = Yii::$app->request->post();

        // getting and adding in params
        $params['employee_search'] = $employee_search;
        $params['type'] = $type;
        $params['loan_id'] = $loan_id;
        // getting lender of this user
        $lender = $this->getFinancerId($user);

        // if lender not found
        if (!$lender) {
            return $this->response(404, ['status' => 404, 'message' => 'lender not found']);
        }

        // getting employee list already assigned to this loan_id
        $already_exists_ids = [];
        if ($loan_id) {
            $already_exists = SharedLoanApplications::find()
                ->select(['shared_to'])
                ->where(['is_deleted' => 0, 'loan_app_enc_id' => $loan_id])
                ->asArray()
                ->all();

            // extracting shared to ids
            if ($already_exists) {
                foreach ($already_exists as $e) {
                    $already_exists_ids[] = $e['shared_to'];
                }
            }
        }

        // assigning already exists in params
        $params['alreadyExists'] = $already_exists_ids;

        // getting employees list

        // if type employees
        if ($params['type'] == 'employees') {
            $employees = $this->employeesList($lender, $params);

            // if employees exists
            if ($employees) {

                // looping employees
                foreach ($employees as $key => $val) {

                    // adding lead_by and managed_by = false in employees
                    $employees[$key]['lead_by'] = $loan_id != null && $val['user_enc_id'] == LoanApplications::findOne(['loan_app_enc_id' => $params['loan_id']])->lead_by;
                    $employees[$key]['managed_by'] = $loan_id != null && $val['user_enc_id'] == LoanApplications::findOne(['loan_app_enc_id' => $params['loan_id']])->managed_by;
                    $employees[$key]['id'] = $val['user_enc_id'];
                    $employees[$key]['name'] = $val['first_name'] . ' ' . $val['last_name'];
                }
            }
        }
        return $this->response(200, ['status' => 200, 'list' => $employees]);
    }

    public function actionChangeStatus()
    {
        if ($this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['status'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "status"']);
            }

            if (empty($params['user_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "user_id"']);
            }

            $user = Users::findOne(['user_enc_id' => $params['user_id']]);

            if (!$user) {
                return $this->response(404, ['status' => 404, 'message' => 'user not found']);
            }
            if (!empty($params['status'])) {
                if ($params['status'] == 'delete') {
                    $user->is_deleted = 1;
                } else {
                    $user->status = $params['status'];
                }
            }

            //            $user->status = $params['status'];
            $user->last_updated_on = date('Y-m-d H:i:s');

            if (!$user->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

            return $this->response(200, ['status' => 200, 'message' => 'status updated']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to update employee info
    public function actionUpdateEmployeeInfo()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // checking if its organization
            if ($user->organization_enc_id) {

                $params = Yii::$app->request->post();

                // if empty user_id then return missing information user id
                if (empty($params['user_id'])) {
                    return $this->response(422, ['status' => 422, 'message' => 'missing information "user_id"']);
                }

                // getting employee object from user_id
                $user = Users::findOne(['user_enc_id' => $params['user_id']]);

                // if user not found
                if (!$user) {
                    return $this->response(404, ['status' => 404, 'message' => 'user not found']);
                }

                // checking if variables exists in params to update
                (!empty($params['first_name'])) ? ($user->first_name = $params['first_name']) : '';
                (!empty($params['last_name'])) ? ($user->last_name = $params['last_name']) : '';
                (!empty($params['email'])) ? ($user->email = $params['email']) : '';
                (!empty($params['phone'])) ? ($user->phone = $params['phone']) : '';
                $user->last_updated_on = date('Y-m-d H:i:s');


                if (!$user->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $user->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
            } else {
                return $this->response(403, ['status' => 403, 'message' => 'only authorized by financer']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting list of connectors referred by dsa
    public function actionDsaConnectors()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // getting connector list
            $connector = $this->connectorsList($user->user_enc_id, $params);

            // returnin data
            return $this->response(200, ['status' => 200, 'connector' => $connector]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting all employees
    public function actionAllEmployees()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            // checking if its organization
            if ($user->organization_enc_id) {

                $params = Yii::$app->request->post();

                // getting employees list
                $employee = $this->employeesList($user->organization_enc_id, $params);

                // getting dsa list
                $dsa = $this->dsaList($user->user_enc_id, $params);

                $dsa_id = [];
                if ($dsa) {
                    foreach ($dsa as $d) {
                        $dsa_id[] = $d['user_enc_id'];
                    }
                }

                $dsa_id[] = $user->user_enc_id;

                // getting connector list
                $connector = $this->connectorsList($dsa_id, $params);

                $all = [];

                // extracting data from all arrays
                foreach ([$employee, $dsa, $connector] as $users) {
                    foreach ($users as $val) {
                        $data = [];
                        $data['value'] = $val['user_enc_id'];
                        $data['label'] = $val['first_name'] . ' ' . $val['last_name'];
                        $data['user_type'] = $val['user_type'];
                        $all[] = $data;
                    }
                }

                return $this->response(200, ['status' => 200, 'all_employees' => $all]);
            } else {
                return $this->response(403, ['status' => 403, 'message' => 'only authorized by financer']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to get financer detail
    public function actionFinancerDetail()
    {
        $params = Yii::$app->request->post();

        // checking if slug is missing
        if (empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "slug"']);
        }

        // getting detail
        $detail = Organizations::find()
            ->alias('a')
            ->select([
                'a.organization_enc_id', 'a.name', 'a.slug', 'a.email', 'a.phone', 'a.description', 'a.facebook', 'a.google', 'a.twitter', 'a.instagram', 'a.linkedin',
                'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo', 'CASE WHEN a.cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, 'https') . '", a.cover_image_location, "/", a.cover_image) ELSE NULL END cover_image'
            ])
            ->joinWith(['organizationLocations b' => function ($b) {
                $b->select([
                    'b.location_enc_id', 'b.organization_enc_id', 'b.location_name', 'b.location_for', 'b.email', 'b.description',
                    'b.website', 'b.phone', 'b.address', 'b.postal_code', 'b.latitude', 'b.longitude', 'b.sequence', 'b1.name city_name', 'b2.name state_name'
                ]);
                $b->joinWith(['cityEnc b1' => function ($b1) {
                    $b1->joinWith(['stateEnc b2'], false);
                }], false);
                $b->onCondition(['b.is_deleted' => 0]);
            }])
            ->where(['a.slug' => $params['slug'], 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        // checking if service loans exists for this user
        $service = SelectedServices::find()->alias('a')->joinWith(['serviceEnc b'], false)->where(['a.organization_enc_id' => $detail['organization_enc_id'], 'a.is_selected' => 1, 'b.name' => 'Loans'])->exists();

        if (!$service) {
            return $this->response(403, ['status' => 403, 'message' => 'forbidden']);
        }


        if ($detail) {

            // getting financer loan types
            $detail['assignedFinancerLoanTypes'] = AssignedFinancerLoanTypes::find()
                ->alias('a')
                ->select(['a.assigned_financer_enc_id', 'a.organization_enc_id', 'a.loan_type_enc_id', 'b.name loan_type'])
                ->joinWith(['loanTypeEnc b'], false)
                ->joinWith(['assignedFinancerLoanPartners c' => function ($c) {
                    $c->select([
                        'c.assigned_loan_partner_enc_id', 'c.assigned_financer_enc_id', 'c.loan_partner_enc_id',
                        'c.ltv', 'concat(c1.first_name," ",c1.last_name) partner_name'
                    ]);
                    $c->joinWith(['loanPartnerEnc c1'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->where(['a.is_deleted' => 0, 'a.status' => 1, 'a.organization_enc_id' => $detail['organization_enc_id']])
                ->andWhere(['<>', 'b.name', 'Vehicle Loan'])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'detail' => $detail]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    // this action is used to save loan notifications
    public function actionSaveNotification()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            if (empty($params['message'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "message"']);
            }

            // saving loan notifications
            $notification = new LoanApplicationNotificationsExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $notification->notification_enc_id = $utilitiesModel->encrypt();
            $notification->loan_application_enc_id = $params['loan_id'];
            $notification->message = $params['message'];
            $notification->source = 'EL';
            $notification->created_by = $user->user_enc_id;
            $notification->created_on = date('Y-m-d H:i:s');
            if (!$notification->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $notification->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is saving comments for loans
    public function actionSaveComment()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            if (empty($params['comment'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "comment"']);
            }

            // saving comments
            $comment = new LoanApplicationCommentsExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $comment->comment_enc_id = $utilitiesModel->encrypt();
            $comment->loan_application_enc_id = $params['loan_id'];
            $comment->comment = $params['comment'];
            if (!empty($params['is_important']) && (int)$params['is_important'] == 1) {
                $comment->is_important = 1;
            }
            $comment->source = 'EL';
            $comment->created_by = $user->user_enc_id;
            $comment->created_on = date('Y-m-d H:i:s');
            if (!$comment->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $comment->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is sharing loan applications with users
    public function actionShareApplication()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            if (empty($params['shared_to'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "shared_to"']);
            }

            if (empty($params['access'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "access"']);
            }

            // checking if already exists or not
            $exists = SharedLoanApplications::findOne(['loan_app_enc_id' => $params['loan_id'], 'shared_to' => $params['shared_to'], 'is_deleted' => 0]);

            // if exists then returning 409 conflict
            if ($exists) {
                return $this->response(409, ['status' => 409, 'message' => 'Application already shared with this user']);
            }

            // saving data
            $shared = new SharedLoanApplicationsExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $shared->shared_loan_app_enc_id = $utilitiesModel->encrypt();
            $shared->loan_app_enc_id = $params['loan_id'];
            $shared->shared_by = $user->user_enc_id;
            $shared->shared_to = $params['shared_to'];
            $shared->access = $params['access'];
            $shared->created_by = $user->user_enc_id;
            $shared->created_on = date('Y-m-d H:i:s');
            if (!$shared->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $shared->getErrors()]);
            }

            $shared_by = $user->first_name . " " . $user->last_name;
            $shared = Users::findOne(['user_enc_id' => $params['shared_to']]);
            $shared_to = $shared->first_name . " " . $shared->last_name;

            $loan_details = LoanApplications::findOne(['loan_app_enc_id' => $params['loan_id']]);
            $notificationBody = $loan_details->application_number ? "Loan Account Number: $loan_details->application_number" : '';
            $allNotifications = [];
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $notification = [
                'notification_enc_id' => $utilitiesModel->encrypt(),
                'user_enc_id' => $params['shared_to'],
                'title' => "$shared_by shared an application with you",
                'description' => $notificationBody,
                'link' => '/account/loan-application/' . $params['loan_id'],
                'created_by' => $user->user_enc_id
            ];
            array_push($allNotifications, $notification);
            $notificationUsers = new UserUtilities();
            $userIds = $notificationUsers->getApplicationUserIds($params['loan_id'], $params['shared_to']);
            if (!empty($userIds)) {
                foreach ($userIds as $uid) {
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $notification = [
                        'notification_enc_id' => $utilitiesModel->encrypt(),
                        'user_enc_id' => $uid,
                        'title' => "$shared_by shared an application with $shared_to",
                        'description' => $notificationBody,
                        'link' => '/account/loan-application/' . $params['loan_id'],
                        'created_by' => $user->user_enc_id,
                    ];
                    array_push($allNotifications, $notification);
                }
            }

            $notificationUsers->saveNotification($allNotifications);


            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // updating shared application
    public function actionUpdateSharedApplication()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking shared_loan_app_id
            if (empty($params['shared_loan_app_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "shared_loan_app_id"']);
            }

            // getting data object from shared_loan_app_id
            $shared = SharedLoanApplicationsExtended::findOne(['shared_loan_app_enc_id' => $params['shared_loan_app_id'], 'is_deleted' => 0]);

            // if not exists
            if (!$shared) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            // updating variables if exists in params
            (!empty($params['access'])) ? $shared->access = $params['access'] : "";
            (!empty($params['status'])) ? $shared->status = $params['status'] : "";
            if (!empty($params['delete']) && $params['delete'] == true) {
                $shared->is_deleted = 1;
            }
            $shared->updated_by = $user->user_enc_id;
            $shared->updated_on = date('Y-m-d H:i:s');
            if (!$shared->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $shared->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // generating username
    private function generate_username($string_name = null, $rand_no = 200)
    {
        $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
        $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

        $part1 = (!empty($username_parts[0])) ? substr($username_parts[0], 0, 8) : ""; //cut first name to 8 letters
        $part2 = (!empty($username_parts[1])) ? substr($username_parts[1], 0, 5) : ""; //cut second name to 5 letters
        $part3 = ($rand_no) ? rand(0, $rand_no) : "";

        $username = $part1 . str_shuffle($part2) . $part3; //str_shuffle to randomly shuffle all characters
        return $username;
    }

    // saving diwali dhamaka data
    public function actionSaveDiwaliDhamakaData()
    {
        $ids = '';
        $params = Yii::$app->request->post();

        // getting csv file
        $data = UploadedFile::getInstanceByName('file');

        // reading file
        $file = fopen($data->tempName, "r");
        $array_data = [];

        // get data from csv
        while (($data = fgetcsv($file)) !== FALSE) {
            if (!empty($data)) {
                array_push($array_data, $data);
            }
        }

        // unsetting index
        unset($array_data[0]);

        // looping data
        for ($i = (int)$params['start']; $i <= count($array_data); $i++) {
            $d = $array_data[$i];

            // extracting and transforming name
            $name = $d[8];
            if (str_contains($name, 'S/O')) {
                $name = explode('S/O', $name)[0];
            } elseif (str_contains($name, 'W/O')) {
                $name = explode('W/O', $name)[0];
            } elseif (str_contains($name, 'D/O')) {
                $name = explode('D/O', $name)[0];
            }

            // starting transaction
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $bdo_name = $d[5];
                $bdo_number = $d[6];

                // getting refId of this organization default is phfleasing
                $refId = Referral::findOne(['organization_enc_id' => Organizations::findOne(['slug' => 'phfleasing'])->organization_enc_id])->code;

                // checking if employee exists with this number
                $employee_exists = Users::findOne(['phone' => [$bdo_number, '+91' . $bdo_number]]);

                // if not exists then saving it
                if (!$employee_exists) {

                    // adding data to form
                    $signup = new SignupForm();
                    $signup->phone = $bdo_number;
                    $signup->ref_id = $refId;
                    $signup->user_type = 'Employee';
                    $e_bdo_name = explode(' ', $bdo_name);
                    $signup->first_name = $e_bdo_name[0];
                    $signup->last_name = $e_bdo_name[1];
                    $signup->username = $this->generate_username($bdo_name);
                    $signup->password = $bdo_number;
                    $signup->source = Yii::$app->getRequest()->getUserIP();
                    if (!$signup->save()) {
                        $transaction->rollback();
                        $ids = $ids . $d[0] . ',';
                    }
                }

                // getting employee user id
                $employee_id = Users::findOne(['phone' => [$bdo_number, '+91' . $bdo_number]])->user_enc_id;

                // adding data to loan application form
                $loan_application = new LoanApplication();
                $loan_application->disbursement_date = date('Y-m-d', strtotime($d[2]));
                $loan_application->dealer_name = $d[3];
                $loan_application->applicant_name = ucwords(strtolower($name));
                $loan_application->pan_number = $d[10];
                $loan_application->aadhar_number = $d[11];
                $loan_application->phone_no = $d[12];
                $loan_application->loan_amount = $d[17];
                $loan_application->loan_type = 'Vehicle Loan';
                $loan_application->loan_lender = 'phfleasing';
                $loan_application->vehicle_type = ucwords(strtolower($d[13]));
                $loan_application->lead_type = 'Online';
                $loan_application->form_type = 'diwali-dhamaka';
                $loan_application->vehicle_making_year = '2022';
                if (!$loan_application->save($employee_id)) {
                    $transaction->rollback();
                    $ids = $ids . $d[0] . ',';
                }

                // commiting code
                $transaction->commit();
            } catch (Exception $e) {
                $ids = $ids . $d[0] . ',' . $e->getMessage();
                $transaction->rollback();
                $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);
            }
        }

        //closing file
        fclose($file);

        return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
    }

    // saving scratch card code to loan users
    public function actionSaveCode()
    {
        // deal slug
        $deal_slug = 'diwali-dhamaka';

        // coupon code for everyone
        $code_for_everyone = 'BAG';

        // coupon code for HEADPHONE
        $code_for_headphone = 'HEADPHONES';

        // coupon code for Power Bank
        $code_for_powerbank = 'POWERBANK';

        $headphone_cnt = 0;
        $powerbank_cnt = 0;
        $get_random = true;

        // if users exists for scratch card else not found 404 code
        if ($users = $this->scratchCardUsers()) {
            $loan_users = $users;
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

        // starting transaction
        $transaction = Yii::$app->db->beginTransaction();
        try {

            foreach ($loan_users as $user) {

                // getting and converting card count to INT
                $user_cnt = (int)$user['cnt'];

                // saving coupon code for user
                for ($i = 0; $i < $user_cnt; $i++) {

                    // check if unique for 2 times for overall and only 1 per user
                    if ($headphone_cnt < 100 & $get_random) {

                        // getting random code
                        $code = $this->_genCode([$code_for_headphone, $code_for_everyone, $code_for_powerbank]);
                        if ($code == $code_for_headphone) {
                            $headphone_cnt += 1;
                            $get_random = false;
                        }
                    } else if ($powerbank_cnt < 100 & $get_random) {

                        // getting random code
                        $code = $this->_genCode([$code_for_headphone, $code_for_everyone, $code_for_powerbank]);
                        if ($code == $code_for_powerbank) {
                            $powerbank_cnt += 1;
                            $get_random = false;
                        }
                    } else {
                        $code = $code_for_everyone;
                    }

                    // saving claimed deal for user
                    $claim = new ClaimedDeals();
                    $claim->claimed_deal_enc_id = \Yii::$app->security->generateRandomString();
                    $claim->deal_enc_id = AssignedDeals::findOne(['slug' => $deal_slug])->deal_enc_id;
                    $claim->user_enc_id = $user['user_id'];
                    $claim->claimed_coupon_code = $code;
                    $claim->created_by = $user['user_id'];
                    $claim->created_on = date('Y-m-d H:i:s');
                    if (!$claim->save()) {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $claim->getErrors()]);
                    }
                }

                // get random true for next user
                $get_random = true;
            }

            $transaction->commit();

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        } catch (Exception $e) {
            $transaction->rollback();
            $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);
        }
    }

    // getting scratch card users
    private function scratchCardUsers()
    {

        // getting date before 3 months
        $date = new \DateTime('now');
        $date->modify('-3 month'); // or you can use '-90 day' for deduct
        $date = $date->format('Y-m-d');

        // getting loan application count for with users

        //Scratch card conditions:-
        //  - Disbursed with phf
        //  - two-wheeler loan or e rickshaw loan
        //  - has disbursed date and under 3 month
        $loans = LoanApplications::find()
            ->alias('a')
            ->select(['COUNT(a.loan_app_enc_id) cnt', 'a.created_by user_id', 'a.loan_app_enc_id'])
            ->joinWith(['assignedLoanProviders b' => function ($b) {
                $b->joinWith(['providerEnc b1']);
            }], false)
            ->joinWith(['loanApplicationOptions c'], false)
            ->joinWith(['loanDisbursementSchedules d'], false)
            ->where(['a.is_deleted' => 0, 'a.loan_type' => 'Vehicle Loan', 'a.source' => 'EmpowerFintech'])
            ->andWhere(['b1.slug' => 'phfleasing', 'b.status' => 5])
            ->andWhere(['<>', 'a.created_by', 'null'])
            ->andWhere(['>=', "c.disbursement_date", $date])
            ->andWhere([
                'or',
                ['c.vehicle_type' => 'Two Wheeler'],
                ['c.vehicle_type' => 'Three Wheeler'],
                ['c.vehicle_option' => 'E-Rickshaw']
            ])
            ->groupBy(['a.created_by'])
            ->asArray()
            ->all();

        if ($loans) {
            return $loans;
        }

        return false;
    }

    private function _genCode($arr)
    {
        for ($i = 0; $i < 1; $i++) {
            $index = rand(0, count($arr) - 1);
            $randomString = $arr[$index];
        }
        return $randomString;
    }

    // this action is used to update employee
    public function actionUpdateEmployee()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // parent_id = user_enc_id/employee_id
            // id = field name
            // value = field value
            if (empty($params['parent_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "parent_id"']);
            }
            $org_id = $user->organization_enc_id;
            if (!$user->organization_enc_id) {
                $findOrg = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
                $org_id = $findOrg->organization_enc_id;
            }

            // getting employee with this id
            $employee = UserRoles::findOne(['user_enc_id' => $params['parent_id'], 'organization_enc_id' => $org_id]);
            $field = $params['id'];

            // if not empty employee
            if (!empty($employee)) {
                // field name and value
                $employee->$field = $params['value'];
                $employee->updated_by = $user->user_enc_id;
                $employee->updated_on = date('Y-m-d H:i:s');
                if (!$employee->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $employee->getErrors()]);
                }
            } else {
                // if not exists then adding it
                $employee = new UserRoles();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $employee->role_enc_id = $utilitiesModel->encrypt();
                $employee->user_type_enc_id = UserTypes::findOne(['user_type' => 'Employee'])->user_type_enc_id;
                $employee->user_enc_id = $params['parent_id'];
                $employee->organization_enc_id = $org_id;
                $employee->$field = $params['value'];
                $employee->created_by = $user->user_enc_id;
                $employee->created_on = date('Y-m-d H:i:s');
                if (!$employee->save()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $employee->getErrors()]);
                }
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // saving assign loan partner
    public function actionAssignLoanPartner()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            if (empty($params['partner_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "partner_id"']);
            }

            if (empty($params['type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "type"']);
            }

            // getting loan partner with this id
            $partner = LoanApplicationPartnersExtended::findOne(['loan_app_enc_id' => $params['loan_id'], 'partner_enc_id' => $params['partner_id'], 'is_deleted' => 0]);

            // if partner exists with this id then sending error 409 conflict
            if (!empty($partner)) {
                return $this->response(409, ['status' => 409, ['conflict already added']]);
            }

            // adding loan partner
            $partner = new LoanApplicationPartnersExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $partner->loan_application_partner_enc_id = $utilitiesModel->encrypt();
            $partner->loan_app_enc_id = $params['loan_id'];
            $partner->provider_enc_id = $user->organization_enc_id;
            $partner->partner_enc_id = $params['partner_id'];
            $partner->type = $params['type'];
            $partner->created_by = $user->user_enc_id;
            $partner->created_on = date('Y-m-d H:i:s');
            if (!$partner->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $partner->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to remove loan pertner
    public function actionRemovePartner()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking partner id exists or not
            if (empty($params['loan_partner_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_partner_id"']);
            }

            // getting loan partner object
            $partner = LoanApplicationPartnersExtended::findOne(['loan_application_partner_enc_id' => $params['loan_partner_id']]);

            // if not empty partner object then removing it
            if (!empty($partner)) {
                $partner->is_deleted = 1;
                $partner->updated_by = $user->user_enc_id;
                $partner->updated_on = date('Y-m-d H:i:s');
                if (!$partner->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $partner->getErrors()]);
                }
                return $this->response(200, ['status' => 200, 'message' => 'successfully removed']);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting financer list
    public function actionGetFinancerList()
    {
        if ($user = $this->isAuthorized()) {

            // getting financer
            $financer = SelectedServices::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'c.name', 'c.slug'])
                ->joinWith(['serviceEnc b'], false)
                ->joinWith(['organizationEnc c'], false)
                ->where(['b.name' => 'Loans', 'a.is_selected' => 1, 'c.status' => 'Active'])
                ->andWhere(['not', ['a.organization_enc_id' => $user->organization_enc_id]])
                ->asArray()
                ->all();

            if ($financer) {
                return $this->response(200, ['status' => 200, 'financer_list' => $financer]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting stats according to laon status
    public function actionStatusStats()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();
            //get user roles
            $specialroles = false;
            $roleUnderId = null;

            // checking if its organization
            if ($user->organization_enc_id) {

                // getting dsa
                $leads = $this->getDsa($user->user_enc_id);

                $dsa = [];
                if ($leads) {
                    foreach ($leads as $val) {
                        $dsa[] = $val['assigned_user_enc_id'];
                    }
                }

                $dsa[] = $user->user_enc_id;
            } else {
                $accessroles = UserUtilities::$rolesArray;
                $role = UserRoles::find()
                    ->alias('a')
                    ->where(['user_enc_id' => $user->user_enc_id])
                    ->andWhere(['a.is_deleted' => 0])
                    ->joinWith(['designation b' => function ($b) use ($accessroles) {
                        $b->andWhere(['in', 'b.designation', $accessroles]);
                    }], true, 'INNER JOIN');
                $specialroles = $role->exists();

                if ($specialroles) {
                    $roleUnder = $role->asArray()->one();
                    $roleUnderId = $roleUnder['organization_enc_id'];
                }
            }

            // checking if logged-in user financer
            $service = SelectedServices::find()
                ->alias('a')
                ->joinWith(['serviceEnc b'], false)
                ->where(['a.organization_enc_id' => $user->organization_enc_id, 'a.is_selected' => 1, 'b.name' => 'Loans'])
                ->exists();

            // getting shared applications
            $shared_apps = $this->sharedApps($user->user_enc_id);

            // getting stats
            $stats = LoanApplications::find()
                ->alias('a')
                ->select(['j1.loan_status', 'COUNT(a.status) count', 'j1.status_color', 'j1.value'])
                ->joinWith(['assignedLoanProviders i' => function ($i) use ($service, $user, $roleUnderId) {
                    $i->joinWith(['providerEnc j']);
                    $i->joinWith(['status0 j1']);
                    if ($service) {
                        $i->andWhere(['i.provider_enc_id' => $user->organization_enc_id]);
                    }
                    if (!empty($roleUnderId) || $roleUnderId != null) {
                        $i->andWhere(['i.provider_enc_id' => $roleUnderId]);
                    }
                }], false)
                ->andWhere(['a.is_deleted' => 0, 'a.form_type' => 'others']);

            if ($user->organization_enc_id) {
                if (!$service) {
                    $stats->andWhere(['a.lead_by' => $dsa]);
                }
            }
            if (!$user->organization_enc_id && $specialroles == false) {
                // else checking lead_by and managed_by by logged-in user
                $stats->andWhere(['or', ['a.lead_by' => $user->user_enc_id], ['a.managed_by' => $user->user_enc_id]]);
            }

            if ($shared_apps['app_ids']) {
                $stats->orWhere(['a.loan_app_enc_id' => $shared_apps['app_ids']]);
            }

            if (!empty($params['loan_product'])) {
                $stats->andWhere(['a.loan_products_enc_id' => $params['loan_product']]);
                $product_name = FinancerLoanProducts::findOne(['financer_loan_product_enc_id' => $params['loan_product']]);
            }

            $stats = $stats
                ->groupBy(['i.status'])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'stats' => $stats, 'product_name' => $product_name ? $product_name->name : '']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // adding column preferences
    public function actionAddColumnPreference()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $identity = $user->user_enc_id;

            // checking if already exists
            $exist = ColumnPreferences::find()->where(['user_enc_id' => $user->user_enc_id, 'loan_product_enc_id' => $params['loan_product_enc_id']])->asArray()->one();
            if (empty($params['disabled_fields'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "disabled_fields"']);
            }

            if ($exist) {
                // query to update disabled fields
                $query = Yii::$app->db->createCommand()
                    ->update(ColumnPreferences::tableName(), ['disabled_fields' => $params['disabled_fields'], 'updated_by' => $identity, 'updated_on' => date('Y-m-d H:i:s')], ['user_enc_id' => $identity, 'column_preference_enc_id' => $exist['column_preference_enc_id']])
                    ->execute();
                if ($query) {
                    return $this->response(200, ['status' => 200, 'title' => 'Success', 'message' => 'Preference has been changed.']);
                } else {
                    return $this->response(500, ['status' => 500, 'title' => 'Error', 'message' => 'An error has occurred. Please try again.']);
                }
            } else {
                // saving column preferences
                $preference = new ColumnPreferences();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $preference->column_preference_enc_id = $utilitiesModel->encrypt();
                $preference->user_enc_id = $identity;
                $preference->loan_product_enc_id = $params['loan_product_enc_id'];
                $preference->created_by = $identity;
                $preference->created_on = date('Y-m-d H:i:s');
                $preference->disabled_fields = $params['disabled_fields'];
                if (!$preference->save()) {
                    //                    print_r( $preference->loan_product_enc_id);
                    //                    die();
                    return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $preference->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'title' => 'Success', 'message' => 'Preference added successfully']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // getting column preferences
    public function actionGetColumnPreference()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            // checking loan_product_enc_id
            if (empty($params['loan_product_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_product_enc_id"']);
            }

            // fetching data
            $fetch = ColumnPreferences::find()->where(['user_enc_id' => $user->user_enc_id, 'loan_product_enc_id' => $params['loan_product_enc_id']])->asArray()->all();

            if ($fetch) {
                return $this->response(200, ['status' => 200, 'columns' => json_decode($fetch[0]['disabled_fields'])]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'Preference not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionEmployeeStats()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            $limit = !empty($params['limit']) ? $params['limit'] : 10;
            $page = !empty($params['page']) ? $params['page'] : 1;

            $lap = strtotime($params['start_date']) > strtotime('2023-06-01 00:00:00') ? $params['start_date'] : '2023-06-01 00:00:00';
            $nlap = strtotime($params['start_date']) > strtotime('2023-07-01 00:00:00') ? $params['start_date'] : '2023-07-01 00:00:00';

            $subquery = (new \yii\db\Query())
                ->select([
                    'k.created_by',
                    'cibil' => "SUM(CASE WHEN k2.request_source = 'CIBIL' THEN 1 ELSE 0 END)",
                    'equifax' => "SUM(CASE WHEN k2.request_source = 'EQUIFAX' THEN 1 ELSE 0 END)",
                    'crif' => "SUM(CASE WHEN k2.request_source = 'CRIF' THEN 1 ELSE 0 END)",
                ])
                ->from(['k' => CreditLoanApplicationReports::tableName()])
                ->join('INNER JOIN', ['k1' => CreditResponseData::tableName()], 'k1.response_enc_id = k.response_enc_id')
                ->join('INNER JOIN', ['k2' => CreditRequestedData::tableName()], 'k2.request_enc_id = k1.request_enc_id')
                ->groupBy(['k.created_by'])
                ->andWhere(['between', 'k.created_on', $params['start_date'], $params['end_date']]);

            $employeeStats = Users::find()
                ->alias('a')
                ->select([
                    'a.user_enc_id',
                    "(CASE WHEN a.last_name IS NOT NULL THEN CONCAT(a.first_name,' ',a.last_name) ELSE a.first_name END) as employee_name",
                    'a.phone', 'a.email', 'a.username', 'a.status', 'b.employee_code', 'ANY_VALUE(b1.designation)', "CONCAT(ANY_VALUE(b2.first_name),' ',ANY_VALUE(b2.last_name)) reporting_person", 'ANY_VALUE(b3.location_name) location_name',
                    "COUNT(DISTINCT CASE WHEN c.is_deleted = '0' and c.form_type = 'others' THEN c.loan_app_enc_id END) as total_cases",
                    "COUNT(DISTINCT CASE WHEN c.is_deleted = '0' and c.form_type = 'others' and c2.loan_status = 'New Lead' THEN c.loan_app_enc_id END) as new_lead",
                    "COUNT(DISTINCT CASE WHEN c.is_deleted = '0' and c.form_type = 'others' and c2.loan_status = 'Sanctioned' THEN c.loan_app_enc_id END) as sanctioned",
                    "COUNT(DISTINCT CASE WHEN c.is_deleted = '0' and c.form_type = 'others' and (c2.loan_status = 'Rejected' or c2.loan_status = 'CNI') THEN c.loan_app_enc_id END) as rejected",
                    "COUNT(DISTINCT CASE WHEN c.is_deleted = '0' and c.form_type = 'others' and c2.loan_status = 'Disbursed' THEN c.loan_app_enc_id END) as disbursed",
                ])
                ->joinWith(['userRoles b' => function ($b) {
                    $b->joinWith(['designationEnc b1'])
                        ->joinWith(['reportingPerson b2'])
                        ->joinWith(['branchEnc b3'])
                        ->joinWith(['userTypeEnc b4']);
                }], false)
                ->joinWith(['loanApplications3 c' => function ($c) use ($params, $lap, $nlap) {
                    $c->andWhere([
                        'or',
                        [
                            'and',
                            ['c.loan_type' => 'Loan Against Property'],
                            ['between', 'c.created_on', $lap, $params['end_date']]
                        ],
                        [
                            'and',
                            ['not', ['c.loan_type' => 'Loan Against Property']],
                            ['between', 'c.created_on', $nlap, $params['end_date']]
                        ],
                        [
                            'or',
                            ['c.loan_type' => null],
                            ['c.loan_type' => '']
                        ]
                    ]);
                    $c->joinWith(['assignedLoanProviders c1' => function ($c1) {
                        $c1->joinWith(['status0 c2']);
                    }], false);
                    if (isset($params['loan_id']) and !empty($params['loan_id'])) {
                        $c->andWhere(['c.loan_type' => $params['loan_id']]);
                    }
                }], false)
                ->joinWith([
                    'creditLoanApplicationReports k' => function ($k) use ($subquery) {
                        $k->from(['subquery' => $subquery]);
                    }
                ])
                ->andWhere(['b.organization_enc_id' => $user->organization_enc_id, 'b4.user_type' => 'Employee', 'b.is_deleted' => 0])
                ->groupBy(['a.user_enc_id','b.employee_code']);

            if (isset($params['field']) && !empty($params['field']) && isset($params['order_by']) && !empty($params['order_by'])) {
                $employeeStats->orderBy(['a.' . $params['field'] => $params['order_by'] == 0 ? SORT_ASC : SORT_DESC]);
            }

            if (isset($params['keyword']) && !empty($params['keyword'])) {
                $employeeStats->andWhere([
                    'or',
                    ['like', "CONCAT(a.first_name,' ',a.last_name)", $params['keyword']],
                    ['like', 'a.phone', $params['keyword']],
                    ['like', 'a.username', $params['keyword']],
                    ['like', 'a.email', $params['keyword']],
                    ['like', 'b1.designation', $params['keyword']],
                    ['like', "CONCAT(b2.first_name,' ',b2.last_name)", $params['keyword']],
                    ['like', 'b3.location_name', $params['keyword']],
                ]);
            }

            $count = $employeeStats->count();
            $employeeStats = $employeeStats
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'data' => $employeeStats, 'count' => $count]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
    }


    public function actionProductListStats()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ["status" => 401, "message" => "unauthorised"]);
        }
        $params = Yii::$app->request->post();

        if (!empty($params["provider_id"])) {
            $provider_id = $params["provider_id"];
        } else {
            $provider_id = $this->getFinancerId($user);
        }
        $limit = !empty($params["limit"]) ? $params["limit"] : 10;
        $page = !empty($params["page"]) ? $params["page"] : 1;
        $productStats = LoanApplications::find()
            ->alias("c")
            ->select([
                "c.loan_products_enc_id",
                "c3.name AS product_name",
                "COUNT(DISTINCT CASE WHEN c.is_deleted = '0' AND c.form_type = 'others' THEN c.loan_app_enc_id END) AS total_cases",
                "COUNT(DISTINCT CASE WHEN c.is_deleted = '0' AND c.form_type = 'others' AND c2.loan_status = 'New Lead' THEN c.loan_app_enc_id END) AS new_lead",
                "COUNT(DISTINCT CASE WHEN c.is_deleted = '0' AND c.form_type = 'others' AND c2.loan_status = 'Sanctioned' THEN c.loan_app_enc_id END) AS sanctioned",
                "COUNT(DISTINCT CASE WHEN c.is_deleted = '0' AND c.form_type = 'others' AND (c2.loan_status = 'Rejected' or c2.loan_status = 'CNI') THEN c.loan_app_enc_id END) AS rejected",
                "COUNT(DISTINCT CASE WHEN c.is_deleted = '0' AND c.form_type = 'others' AND c2.loan_status = 'Disbursed' THEN c.loan_app_enc_id END) AS disbursed",
                "SUM(CASE WHEN c1.status = '31' THEN c1.disbursement_approved ELSE 0 END) AS disbursed_amount",


                "SUM(CASE WHEN c1.insurance_charges = null THEN 0 ELSE ' ' END) AS insurance_charges_amount",
                "SUM(CASE WHEN c1.disbursement_approved = null THEN 0 ELSE ' ' END) AS disbursed_approval_amount",
                "SUM(CASE WHEN c1.soft_sanction = null THEN 0 ELSE ' ' END) AS soft_sanctioned_amount",
                "SUM(CASE WHEN c1.soft_approval = null THEN 0 ELSE ' ' END) AS soft_approval_amount",

                "SUM(CASE WHEN c1.status = '32' THEN IF(c1.soft_sanction, c1.soft_sanction, IF(c1.soft_approval, c1.soft_approval, c.amount)) ELSE 0 END) AS rejected_amount",
                "SUM(CASE WHEN c1.status = '28' THEN IF(c1.soft_sanction, c1.soft_sanction, IF(c1.soft_approval, c1.soft_approval, c.amount)) ELSE 0 END) AS cni_amount",
                "SUM(CASE WHEN c1.status = '30' THEN IF(c1.soft_sanction, c1.soft_sanction, IF(c1.soft_approval, c1.soft_approval, c.amount)) ELSE 0 END) AS sanctioned_amount",
                "SUM(CASE WHEN  c.amount = null THEN 0 ELSE '' END) AS total_amount",
            ])
            ->joinWith(["assignedLoanProviders c1" => function ($c1) {
                $c1->joinWith(["status0 c2"]);
            }], false)
            ->joinWith(["loanProductsEnc c3"], false)

            ->andWhere(["c1.provider_enc_id" => $provider_id])
            ->andWhere(["not", ["c.loan_products_enc_id" => null]])
            ->andWhere(["between", "c.created_on", $params["start_date"], $params["end_date"]])

            ->groupBy(["c.loan_products_enc_id"]);


        if (!empty($params["branch_name"])) {
            $productStats->andWhere(["c1.branch_enc_id" => $params["branch_name"]]);
        }
        if (isset($params["field"]) && !empty($params["field"]) && isset($params["order_by"]) && !empty($params["order_by"])) {
            $productStats->orderBy(["c." . $params["field"] => $params["order_by"] == 0 ? SORT_ASC : SORT_DESC]);
        }
        if (isset($params["keyword"]) && !empty($params["keyword"])) {
            $productStats->andWhere([
                "or",
                ["like", "concat(a.first_name,' ',a.last_name)", $params["keyword"]],
                ["like", "a.phone", $params["keyword"]],
                ["like", "a.username", $params["keyword"]],
                ["like", "a.email", $params["keyword"]],
                ["like", "b1.designation", $params["keyword"]],
                ["like", "concat(b2.first_name, ' ' ,b2.last_name)", $params["keyword"]],
                ["like", "b3.location_name", $params["keyword"]],
            ]);
        }
        $count = $productStats->count();
        $productStats = $productStats
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();
        return $this->response(200, ["status" => 200, "data" => $productStats, "count" => $count]);
    }

    public function actionUploadApplicantImage()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (empty($params['id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "id"']);
            }

            if (empty($params['type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "type"']);
            }

            if ($params['type'] == 'Borrower') {
                $model = LoanApplications::findOne(['loan_app_enc_id' => $params['id']]);
            } else {
                $model = LoanCoApplicants::findOne(['loan_co_app_enc_id' => $params['id']]);
            }

            if ($model) {
                $image = UploadedFile::getInstanceByName('image');

                $model->image = Yii::$app->getSecurity()->generateRandomString() . '.' . $image->extension;
                $model->image_location = Yii::$app->getSecurity()->generateRandomString() . '/';
                $base_path = Yii::$app->params->upload_directories->loans->image . $model->image_location . $model->image;

                if ($model->update()) {
                    $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                    $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                    $result = $my_space->uploadFileSources($image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path, "public", ['params' => ['contentType' => $image->type]]);
                    if ($result) {
                        return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred while uploading image']);
                    }
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()]);
                }
            }
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionFinancerDesignations()
    {
        if ($user = $this->isAuthorized()) {
            $model = new FinancerDesignationForm();
            $get = Yii::$app->request->post();
            if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $designation = $model->addDesignation($user);
                    if ($designation['status'] == 200) {
                        return $this->response(200, $designation);
                    } else {
                        return $this->response(500, $designation);
                    }
                } else {
                    return $this->response(422, ['status' => 422, 'message' => 'missing information', 'error' => $model->getErrors()]);
                }
            } else {
                return $this->response(400, ['status' => 400, 'message' => 'bad request']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionFinancerDesignationList()
    {
        if ($user = $this->isAuthorized()) {
            $org_id = $user->organization_enc_id;
            if (!$user->organization_enc_id) {
                $findOrg = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
                $org_id = $findOrg->organization_enc_id;
            }
            if ($org_id) {
                $financerDesignations = FinancerAssignedDesignations::find()
                    ->select(['assigned_designation_enc_id as id', 'designation as value'])
                    ->andWhere(['organization_enc_id' => $org_id, 'is_deleted' => 0])
                    ->asArray()
                    ->all();
                return $this->response(200, ['status' => 200, 'data' => $financerDesignations]);
            } else {
                return $this->response(401, ['status' => 201, 'message' => 'Financer not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
    }

    public function actionDesignationRemove()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (empty($params['assigned_designation_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing parameter "assigned_designation_enc_id"']);
            }
            $removeDesignation = FinancerAssignedDesignations::findOne(['organization_enc_id' => $user['organization_enc_id'], 'assigned_designation_enc_id' => $params['assigned_designation_enc_id']]);
            if (!$removeDesignation) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            $removeDesignation->is_deleted = 1;
            $removeDesignation->last_updated_by = $user->user_enc_id;
            $removeDesignation->last_updated_on = date('Y-m-d H:i:s');
            if (!$removeDesignation->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred while deleting.', 'error' => $removeDesignation->getErrors()]);
            }
            return $this->response(200, ['status' => 200, 'message' => 'successfully removed']);
        }
    }

    public function actionEmployeeLoanList()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            $limit = !empty($params['limit']) ? $params['limit'] : 10;
            $page = !empty($params['page']) ? $params['page'] : 1;


            if (empty($params['user_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "user_enc_id"']);
            }

            $employeeLoanList = LoanApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.loan_app_enc_id', 'a.amount', 'a.loan_type', 'a.application_number', 'a.applicant_name',
                    'c1.location_name', 'c3.loan_status', 'd.name product_name'
                ])
                ->joinWith(['assignedLoanProviders c' => function ($c) {
                    $c->joinWith(['branchEnc c1']);
                }], false)
                ->joinWith(['assignedLoanProviders c2' => function ($c2) use ($params) {
                    $c2->joinWith(['status0 c3']);
                    if ($params['status']) {
                        $c2->andWhere(['in', 'c3.loan_status', $params['status']]);
                    }
                }], false)
                ->joinWith(['creditLoanApplicationReports k' => function ($k) use ($params) {
                    $k->groupBy(['k.loan_app_enc_id']);
                    $k->select([
                        'k.report_enc_id', 'k.loan_app_enc_id', 'k.created_by',
                        'COUNT(CASE WHEN k2.request_source = "CIBIL" THEN k.loan_app_enc_id END) as cibil',
                        'COUNT(CASE WHEN k2.request_source = "EQUIFAX" THEN k.loan_app_enc_id END) as equifax',
                        'COUNT(CASE WHEN k2.request_source = "CRIF" THEN k.loan_app_enc_id END) as crif'
                    ]);
                    $k->joinWith(['responseEnc k1' => function ($k1) {
                        $k1->joinWith(['requestEnc k2']);
                    }]);
                    $k->onCondition(['k.created_by' => $params['user_enc_id']]);
                }])
                ->joinWith(['loanProductsEnc d'])
                ->where(['between', 'a.created_on', $params['start_date'], $params['end_date']])
                ->andWhere(['a.lead_by' => $params['user_enc_id'], 'a.is_deleted' => 0])
                ->groupBy(['a.loan_app_enc_id']);
            $count = $employeeLoanList->count();
            $employeeLoanList = $employeeLoanList
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            if ($employeeLoanList) {
                return $this->response(200, ['status' => 200, 'loanDetails' => $employeeLoanList, 'count' => $count, 'limit' => $limit, 'page' => $page]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'Loan Details not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
    }

    public function actionDashboardStats()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            //get user roles
            $specialroles = false;
            $roleUnderId = null;

            // checking if its organization
            if ($user->organization_enc_id) {

                // getting dsa
                $leads = $this->getDsa($user->user_enc_id);

                $dsa = [];
                if ($leads) {
                    foreach ($leads as $val) {
                        $dsa[] = $val['assigned_user_enc_id'];
                    }
                }

                $dsa[] = $user->user_enc_id;
            } else {
                $accessroles = UserUtilities::$rolesArray;
                $role = UserRoles::find()
                    ->alias('a')
                    ->where(['user_enc_id' => $user->user_enc_id])
                    ->andWhere(['a.is_deleted' => 0])
                    ->joinWith(['designation b' => function ($b) use ($accessroles) {
                        $b->andWhere(['in', 'b.designation', $accessroles]);
                    }], true, 'INNER JOIN');
                $specialroles = $role->exists();

                if ($specialroles) {
                    $roleUnder = $role->asArray()->one();
                    $roleUnderId = $roleUnder['organization_enc_id'];
                }
            }
            $service = SelectedServices::find()
                ->alias('a')
                ->joinWith(['serviceEnc b'], false)
                ->where(['a.organization_enc_id' => $user->organization_enc_id, 'a.is_selected' => 1, 'b.name' => 'Loans'])
                ->exists();

            $shared_apps = $this->sharedApps($user->user_enc_id);

            $employeeAmount = LoanApplications::find()
                ->alias('b')
                ->select([
                    "SUM(b.amount) total_amount",
                    "SUM(CASE WHEN i.status = '0' THEN b.amount ELSE 0 END) as new_lead_amount",
                    "SUM(CASE WHEN i.status = '4' THEN IF(i.tl_approved_amount, i.tl_approved_amount, IF(i.bdo_approved_amount, i.bdo_approved_amount, b.amount)) ELSE 0 END) as login_amount",
                    "SUM(CASE WHEN i.status = '31' THEN i.disbursement_approved ELSE 0 END) as disbursed_amount",
                    "SUM(CASE WHEN i.status = '26' THEN i.disbursement_approved ELSE 0 END) as disbursed_approval_amount",
                    "SUM(CASE WHEN i.status = '31' THEN i.insurance_charges ELSE 0 END) as insurance_charges_amount",
                    "SUM(CASE WHEN i.status = '24' THEN i.soft_sanction ELSE 0 END) as soft_sanctioned_amount",
                    "SUM(CASE WHEN i.status = '15' THEN i.soft_approval ELSE 0 END) as soft_approval_amount",
                    "SUM(CASE WHEN i.status > '4' AND i.status < '26' THEN b.amount ELSE 0 END) as under_process_amount",
                    "SUM(CASE WHEN i.status = '32' THEN IF(i.soft_sanction, i.soft_sanction, IF(i.soft_approval, i.soft_approval, b.amount)) ELSE 0 END) as rejected_amount",
                    "SUM(CASE WHEN i.status = '28' THEN IF(i.soft_sanction, i.soft_sanction, IF(i.soft_approval, i.soft_approval, b.amount)) ELSE 0 END) as cni_amount",
                    "SUM(CASE WHEN i.status = '30' THEN IF(i.soft_sanction, i.soft_sanction, IF(i.soft_approval, i.soft_approval, b.amount)) ELSE 0 END) as sanctioned_amount",
                    "COUNT(*) as all_applications_count",
                    "COUNT(CASE WHEN i.status = '0' THEN b.loan_app_enc_id END) as new_lead_count",
                    "COUNT(CASE WHEN i.status = '31' THEN i.insurance_charges END) as insurance_charges_count",
                    "COUNT(CASE WHEN i.status = '4' THEN b.loan_app_enc_id END) as login_count",
                    "COUNT(CASE WHEN i.status = '15' THEN b.loan_app_enc_id END) as soft_approval_count",
                    "COUNT(CASE WHEN i.status = '31' THEN b.loan_app_enc_id END) as disbursed_count",
                    "COUNT(CASE WHEN i.status = '30' THEN b.loan_app_enc_id END) as sanctioned_count",
                    "COUNT(CASE WHEN i.status > '4' AND i.status < '26' THEN b.loan_app_enc_id END) as under_process_count",
                    "COUNT(CASE WHEN i.status = '28' THEN b.loan_app_enc_id END) as cni_count",
                    "COUNT(CASE WHEN i.status = '32' THEN b.loan_app_enc_id END) as rejected_count",
                    "COUNT(CASE WHEN i.status = '26' THEN b.loan_app_enc_id END) as disbursement_approval_count",
                    "COUNT(CASE WHEN i.status = '24' THEN b.loan_app_enc_id END) as soft_sanction_count"
                ])
                ->joinWith(['assignedLoanProviders i' => function ($i) use ($service, $user, $roleUnderId) {
                    $i->joinWith(['providerEnc j']);
                    if ($service) {
                        $i->andWhere(['i.provider_enc_id' => $user->organization_enc_id]);
                    }
                    if (!empty($roleUnderId) || $roleUnderId != null) {
                        $i->andWhere(['i.provider_enc_id' => $roleUnderId]);
                    }
                }], false)
                ->where(['b.is_deleted' => 0, 'b.is_removed' => 0, 'b.form_type' => 'others']);
            if ($user->organization_enc_id) {
                if (!$service) {
                    $employeeAmount->andWhere(['b.lead_by' => $dsa]);
                }
            }
            if (!$user->organization_enc_id && $specialroles == false) {
                // else checking lead_by and managed_by by logged-in user
                $employeeAmount->andWhere(['or', ['b.lead_by' => $user->user_enc_id], ['b.managed_by' => $user->user_enc_id]]);
            }

            if ($shared_apps['app_ids']) {
                $employeeAmount->orWhere(['b.loan_app_enc_id' => $shared_apps['app_ids']]);
            }
            if (!empty($params['loan_product'])) {
                $employeeAmount->andWhere(['b.loan_products_enc_id' => $params['loan_product']]);
            }
            if (!empty($params['branch_name'])) {
                $employeeAmount->andWhere(['i.branch_enc_id' => $params['branch_name']]);
            }
            $lap = strtotime($params['start_date']) > strtotime('2023-06-01 00:00:00') ? $params['start_date'] : '2023-06-01 00:00:00';
            $nlap = strtotime($params['start_date']) > strtotime('2023-07-01 00:00:00') ? $params['start_date'] : '2023-07-01 00:00:00';
            $employeeAmount = $employeeAmount
                ->andWhere(['between', 'b.loan_status_updated_on', $params['start_date'], $params['end_date']])
                ->asArray()
                ->one();

            return $this->response(200, ['status' => 200, 'data' => $employeeAmount]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionBranchList()
    {
        // checking authorization
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $org_id = $user->organization_enc_id;
        if ($org_id) {
            $params = Yii::$app->request->post();
            if (isset($params['type']) && $params['type'] === 'by_cases') {
                $data = $this->branchCount($org_id, $params);
            } else {
                $data = $this->branchSum($org_id, $params);
            }
            return $this->response($data['status'], $data);
        } else {
            return $this->response(403, ['status' => 403, 'message' => 'error']);
        }
    }


    private function branchSum($org_id, $params)
    {
        $branchSum = OrganizationLocations::find()
            ->alias('a')
            ->select([
                'a.location_name', 'a.organization_enc_id', 'a.location_enc_id',
                'SUM(c.amount) as new_lead_amount',
                'SUM(IF(b.tl_approved_amount, b.tl_approved_amount, IF(b.bdo_approved_amount, b.bdo_approved_amount, c.amount))) as login_amount',
                'SUM(CASE WHEN b.status = "31" THEN b.disbursement_approved ELSE 0 END) as disbursed_amount',
                'SUM(b.disbursement_approved) as disbursed_approval_amount',
                'SUM(b.insurance_charges) as insurance_charges_amount',
                'SUM(b.soft_sanction) as soft_sanctioned_amount',
                'SUM(b.soft_approval) as soft_approval_amount',
                'SUM(CASE WHEN b.status = "32" THEN IF(b.soft_sanction, b.soft_sanction, IF(b.soft_approval, b.soft_approval, c.amount)) ELSE 0 END) as rejected_amount',
                'SUM(CASE WHEN b.status = "28" THEN IF(b.soft_sanction, b.soft_sanction, IF(b.soft_approval, b.soft_approval, c.amount)) ELSE 0 END) as cni_amount',
                'SUM(CASE WHEN b.status = "30" THEN IF(b.soft_sanction, b.soft_sanction, IF(b.soft_approval, b.soft_approval, c.amount)) ELSE 0 END) as sanctioned_amount',
            ])
            ->leftJoin(AssignedLoanProvider::tableName() . 'as b', 'b.branch_enc_id = a.location_enc_id')
            ->leftJoin(LoanApplications::tableName() . 'as c', 'c.loan_app_enc_id = b.loan_application_enc_id')
            ->where(['between', 'c.updated_on', $params['start_date'], $params['end_date']])
            ->andWhere(['a.is_deleted' => 0, 'a.organization_enc_id' => $org_id])
            ->groupBy(['a.location_enc_id']);

        if (!empty($params['keyword'])) {
            $branchSum->andWhere([
                'or',
                ['like', 'a.location_enc_id', $params['keyword']],
            ]);
        }

        $branchSum = $branchSum
            ->asArray()
            ->all();

        if ($branchSum) {
            return ['status' => 200, 'data' => $branchSum, 'count' => count($branchSum)];
        }
        return ['status' => 404, 'message' => 'not found'];
    }

    private function branchCount($org_id, $params)
    {
        $branchCount = OrganizationLocations::find()
            ->alias('a')
            ->select([
                'a.location_name', 'a.organization_enc_id', 'a.location_enc_id',
                'COUNT(CASE WHEN b.status = "0" THEN c.amount END) as new_lead_amount',
                'COUNT(CASE WHEN b.status = "4" THEN IF(b.tl_approved_amount, b.tl_approved_amount, IF(b.bdo_approved_amount, b.bdo_approved_amount, c.amount)) END) as login_amount',
                'COUNT(CASE WHEN b.status = "31" THEN b.disbursement_approved END) as disbursed_amount',
                'COUNT(CASE WHEN b.status = "26" THEN b.disbursement_approved END) as disbursed_approval_amount',
                'COUNT(CASE WHEN b.status = "24" THEN b.soft_sanction END) as soft_sanctioned_amount',
                'COUNT(CASE WHEN b.status = "15" THEN b.soft_approval END) as soft_approval_amount',
                'COUNT(CASE WHEN b.status != "0" AND b.status != "4" AND b.status != "15" AND b.status != "31" AND b.status != "26" AND b.status != "32" AND b.status != "30" AND b.status != "28" AND b.status != "24" THEN c.amount END) as under_process_amount',
                'COUNT(CASE WHEN b.status = "32" THEN IF(b.soft_sanction, b.soft_sanction, IF(b.soft_approval, b.soft_approval, c.amount)) END) as rejected_amount',
                'COUNT(CASE WHEN b.status = "28" THEN IF(b.soft_sanction, b.soft_sanction, IF(b.soft_approval, b.soft_approval, c.amount)) END) as cni_amount',
                'COUNT(CASE WHEN b.status = "30" THEN IF(b.soft_sanction, b.soft_sanction, IF(b.soft_approval, b.soft_approval, c.amount)) END) as sanctioned_amount'
            ])
            ->leftJoin(AssignedLoanProvider::tableName() . 'as b', 'b.branch_enc_id = a.location_enc_id')
            ->leftJoin(LoanApplications::tableName() . 'as c', 'c.loan_app_enc_id = b.loan_application_enc_id')
            ->where(['between', 'c.updated_on', $params['start_date'], $params['end_date']])
            ->andWhere(['a.is_deleted' => 0, 'a.organization_enc_id' => $org_id])
            ->groupBy(['a.location_enc_id']);

        if (!empty($params['keyword'])) {
            $branchCount->andWhere([
                'or',
                ['like', 'a.location_enc_id', $params['keyword']],
            ]);
        }

        $branchCount = $branchCount
            ->asArray()
            ->all();

        if ($branchCount) {
            return ['status' => 200, 'data' => $branchCount, 'count' => count($branchCount)];
        }
        return ['status' => 404, 'message' => 'not found'];
    }

    public function actionUpdatePd()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_enc_id"']);
        }
        $save = 'save';
        if (!empty($params['loan_application_pd_enc_id'])) {
            $loan_pd = LoanApplicationPdExtended::findOne(['loan_application_pd_enc_id' => $params['loan_application_pd_enc_id'], 'loan_app_enc_id' => $params['loan_app_enc_id']]);
            if (!$loan_pd) {
                return $this->response(404, ['status' => 404, 'message' => 'Pd not found']);
            }
            $save = 'update';
        } else {
            $exist_check = LoanApplicationPdExtended::findOne(['loan_app_enc_id' => $params['loan_app_enc_id']]);
            if ($exist_check) {
                return $this->response(404, ['status' => 404, 'message' => 'Pd with loan id already exists']);
            }
            $loan_pd = new LoanApplicationPdExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $loan_pd->loan_application_pd_enc_id = $utilitiesModel->encrypt();
            $loan_pd->loan_app_enc_id = $params['loan_app_enc_id'];
            $loan_pd->created_on = date('Y-m-d H:i:s');
            $loan_pd->created_by = $user->user_enc_id;
            if (!empty($params['dates'])) {
                $loan_pd->preferred_date = $params['dates'];
            }
        }
        $loan_pd->status = $params['status'];
        if (isset($params['assigned_to'])) {
            $loan_pd->assigned_to = $params['assigned_to'];
        }
        $loan_pd->updated_on = date('Y-m-d H:i:s');
        $loan_pd->updated_by = $user->user_enc_id;
        if (!$loan_pd->$save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_pd->getErrors()]);
        }

        $notificationUsers = new UserUtilities();
        $userIds = $notificationUsers->getApplicationUserIds($params['loan_app_enc_id']);
        $updated_by = $user->first_name . " " . $user->last_name;
        $pd_status = $params['status'] === 1 ? "Completed" : "Initiated";
        if (!empty($userIds)) {
            $allNotifications = [];
            foreach ($userIds as $uid) {
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $notification = [
                    'notification_enc_id' => $utilitiesModel->encrypt(),
                    'user_enc_id' => $uid,
                    'title' => "PD $pd_status by $updated_by",
                    'description' => "",
                    'link' => '/account/loan-application/' . $params['loan_app_enc_id'],
                    'created_by' => $user->user_enc_id
                ];

                array_push($allNotifications, $notification);
            }
        }
        $notificationUsers->saveNotification($allNotifications);

        return $this->response(200, ['status' => 200, 'message' => $save . 'd successfully']);
    }

    public function actionUpdateTvr()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_enc_id"']);
        }
        $save = 'save';
        if (!empty($params['loan_application_tvr_enc_id'])) {
            $loan_tvr = LoanApplicationTvrExtended::findOne(['loan_application_tvr_enc_id' => $params['loan_application_tvr_enc_id'], 'loan_app_enc_id' => $params['loan_app_enc_id']]);
            if (!$loan_tvr) {
                return $this->response(404, ['status' => 404, 'message' => 'tvr not found']);
            }
            $save = 'update';
        } else {
            $exist_check = LoanApplicationTvrExtended::findOne(['loan_app_enc_id' => $params['loan_app_enc_id']]);
            if ($exist_check) {
                return $this->response(404, ['status' => 404, 'message' => 'tvr with loan id already exists']);
            }
            $loan_tvr = new LoanApplicationTvrExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $loan_tvr->loan_application_tvr_enc_id = $utilitiesModel->encrypt();
            $loan_tvr->loan_app_enc_id = $params['loan_app_enc_id'];
            $loan_tvr->created_on = date('Y-m-d H:i:s');
            $loan_tvr->created_by = $user->user_enc_id;
        }
        $loan_tvr->status = $params['status'];
        if (isset($params['assigned_to'])) {
            $loan_tvr->assigned_to = $params['assigned_to'];
        }
        $loan_tvr->updated_on = date('Y-m-d H:i:s');
        $loan_tvr->updated_by = $user->user_enc_id;

        if (!$loan_tvr->$save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_tvr->getErrors()]);
        }

        $notificationUsers = new UserUtilities();
        $userIds = $notificationUsers->getApplicationUserIds($params['loan_app_enc_id']);
        $updated_by = $user->first_name . " " . $user->last_name;
        $tvr_status = $params['status'] === 1 ? "Completed" : "Initiated";
        if (!empty($userIds)) {
            $allNotifications = [];
            foreach ($userIds as $uid) {
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $notification = [
                    'notification_enc_id' => $utilitiesModel->encrypt(),
                    'user_enc_id' => $uid,
                    'title' => "TVR $tvr_status by $updated_by",
                    'description' => "",
                    'link' => '/account/loan-application/' . $params['loan_app_enc_id'],
                    'created_by' => $user->user_enc_id
                ];

                array_push($allNotifications, $notification);
            }
        }
        $notificationUsers->saveNotification($allNotifications);

        return $this->response(200, ['status' => 200, 'message' => $save . 'd successfully']);
    }

    public function actionUpdateFi()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_enc_id"']);
        }
        $save = 'save';
        if (!empty($params['loan_application_fi_enc_id'])) {
            $loan_fi = LoanApplicationFiExtended::findOne(['loan_application_fi_enc_id' => $params['loan_application_fi_enc_id'], 'loan_app_enc_id' => $params['loan_app_enc_id']]);
            if (!$loan_fi) {
                return $this->response(404, ['status' => 404, 'message' => 'Fi not found']);
            }
            $save = 'update';
        } else {
            $exist_check = LoanApplicationFiExtended::findOne(['loan_app_enc_id' => $params['loan_app_enc_id']]);
            if ($exist_check) {
                return $this->response(404, ['status' => 404, 'message' => 'Fi with loan id already exists']);
            }
            $loan_fi = new LoanApplicationFiExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $loan_fi->loan_application_fi_enc_id = $utilitiesModel->encrypt();
            $loan_fi->loan_app_enc_id = $params['loan_app_enc_id'];
            $loan_fi->created_on = date('Y-m-d H:i:s');
            $loan_fi->created_by = $user->user_enc_id;
        }
        $document = UploadedFile::getInstanceByName('document');
        if ($document) {
            $documents = Yii::$app->getSecurity()->generateRandomString() . '.' . $document->extension;
            $documents_location = Yii::$app->getSecurity()->generateRandomString();
            $base_path = Yii::$app->params->upload_directories->document_images->documents . $documents_location;

            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($document->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . '/' . $documents, "public", ['params' => ['contentType' => $document->type]]);

            $loan_fi->documents = $documents;
            $loan_fi->documents_location = $documents_location;
        }
        $loan_fi->status = $params['status'];
        if (isset($params['assigned_to'])) {
            $loan_fi->assigned_to = $params['assigned_to'];
        }
        $loan_fi->updated_on = date('Y-m-d H:i:s');
        $loan_fi->updated_by = $user->user_enc_id;
        if (!$loan_fi->$save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_fi->getErrors()]);
        }
        return $this->response(200, ['status' => 200, 'message' => $save . 'd successfully']);
    }

    public function actionUpdateReleasePayment()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_enc_id"']);
        }
        $save = 'save';
        if (!empty($params['loan_application_release_payment_enc_id'])) {
            $loan_release_payment = LoanApplicationReleasePaymentExtended::findOne(['loan_application_release_payment_enc_id' => $params['loan_application_release_payment_enc_id'], 'loan_app_enc_id' => $params['loan_app_enc_id']]);
            if (!$loan_release_payment) {
                return $this->response(404, ['status' => 404, 'message' => 'Release Payment not found']);
            }
            $save = 'update';
        } else {
            $exist_check = LoanApplicationReleasePaymentExtended::findOne(['loan_app_enc_id' => $params['loan_app_enc_id']]);
            if ($exist_check) {
                return $this->response(404, ['status' => 404, 'message' => 'Release payment with loan id already exists']);
            }
            $loan_release_payment = new LoanApplicationReleasePaymentExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $loan_release_payment->loan_application_release_payment_enc_id = $utilitiesModel->encrypt();
            $loan_release_payment->loan_app_enc_id = $params['loan_app_enc_id'];
            $loan_release_payment->created_on = date('Y-m-d H:i:s');
            $loan_release_payment->created_by = $user->user_enc_id;
        }
        $loan_release_payment->status = $params['status'];
        if (isset($params['assigned_to'])) {
            $loan_release_payment->assigned_to = $params['assigned_to'];
        }
        $loan_release_payment->updated_on = date('Y-m-d H:i:s');
        $loan_release_payment->updated_by = $user->user_enc_id;
        if (!$loan_release_payment->$save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_release_payment->getErrors()]);
        }
        return $this->response(200, ['status' => 200, 'message' => $save . 'd successfully']);
    }

    public function actionFinancerVehicleBrand()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $brand_name = Yii::$app->request->post('brand_name');
            $org_id = Yii::$app->request->post('organization_enc_id');

            $logoModel = new FinancerVehicleBrand();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $logoModel->financer_vehicle_brand_enc_id = $utilitiesModel->encrypt();
            $logoModel->brand_name = $brand_name;
            $logoModel->organization_enc_id = $org_id;
            $logoModel->created_by = $user->user_enc_id;
            $logoModel->created_on = date('Y-m-d H:i:s');

            if ($logo_image = UploadedFile::getInstanceByName('logo_image')) {
                $logo = Yii::$app->getSecurity()->generateRandomString() . '.' . $logo_image->extension;
                $logo_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->vehicle_brands->logo . $logo_location;

                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($logo_image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . '/' . $logo, "public", ['params' => ['contentType' => $logo_image->type]]);

                $logoModel->logo = $logo;
                $logoModel->logo_location = $logo_location;
            }

            if (!$logoModel->save()) {
                $transaction->rollback();
                return $this->response(500, ['status' => 500, 'message' => 'An error occurred while saving the vehicle data.', 'error' => $logoModel->getErrors()]);
            }

            $transaction->commit();
            return $this->response(200, ['status' => 200, 'brand_name' => $brand_name]);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'An error occurred', 'error' => json_decode($exception->getMessage(), true)];
        }
    }

    public function actionGetFinancerVehicleBrand()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $org_id = $user->organization_enc_id;
        if (!$org_id) {
            $user_roles = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            $org_id = $user_roles->organization_enc_id;
        }

        $financerList = FinancerVehicleBrand::find()
            ->alias('a')
            ->select([
                'a.financer_vehicle_brand_enc_id',
                'a.brand_name',
                'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->vehicle_brands->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE NULL END logo'
            ])
            ->andWhere(['a.is_deleted' => 0, 'a.organization_enc_id' => $org_id])
            ->asArray()
            ->all();

        if ($financerList) {
            return $this->response(200, ['status' => 200, 'financer_list' => $financerList]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'Not found']);
    }

    public function actionDeleteFinancerVehicleBrand()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();

        // checking id exists or not
        if (empty($params['financer_vehicle_brand_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "financer_vehicle_brand_enc_id"']);
        }

        $vehicle_enc_id = FinancerVehicleBrand::findOne(['financer_vehicle_brand_enc_id' => $params['financer_vehicle_brand_enc_id']]);

        if (!empty($vehicle_enc_id)) {
            $vehicle_enc_id->is_deleted = 1;
            $vehicle_enc_id->updated_by = $user->user_enc_id;
            $vehicle_enc_id->updated_on = date('Y-m-d H:i:s');
            if (!$vehicle_enc_id->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $vehicle_enc_id->getErrors()]);
            }
            return $this->response(200, ['status' => 200, 'message' => 'successfully removed']);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionUpdateReferences()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        if (!isset($params['loan_app_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_enc_id"']);
        }
        if (!isset($params['data'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "data"']);
        }
        $transaction = Yii::$app->db->beginTransaction();
        foreach ($params['data'] as $value) {
            if (!empty($value['references_enc_id'])) {
                $references = LoanApplicationsReferencesExtended::findOne(['references_enc_id' => $value['references_enc_id'], 'loan_app_enc_id' => $value['loan_app_enc_id']]);
                if (!$references) {
                    $transaction->rollBack();
                    return $this->response(404, ['status' => 404, 'message' => 'Reference not found']);
                }
                $save = 'update';
            } else {
                $references = new LoanApplicationsReferencesExtended();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $references->references_enc_id = $utilitiesModel->encrypt();
                $references->loan_app_enc_id = $params['loan_app_enc_id'];
                if (!empty($value['type'])) {
                    $references->type = $value['type'];
                }
                $references->value = $value['value'];
                $references->name = $value['name'];
                $references->reference = $value['reference'];
                $references->created_on = date('Y-m-d H:i:s');
                $references->created_by = $user->user_enc_id;
                $save = 'save';
            }
            $references->updated_on = date('Y-m-d H:i:s');
            $references->updated_by = $user->user_enc_id;
            if (!$references->$save()) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $references->getErrors()]);
            }
        }
        $transaction->commit();
        return $this->response(200, ['status' => 200, 'message' => $save . 'd successfully']);
    }

    public function actionLoanPayments()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();

        if (empty($params['loan_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
        }
        if (isset($params['type']) && $params['type'] === 'emi_id') {
            $data = $this->loanEmiList($params);
        } else {
            $data = $this->assignedPayment($params);
        }
        return $this->response($data['status'], $data);
    }

    private function loanEmiList($params)
    {
        $emiList = LoanApplications::find()
            ->alias('a')
            ->select([
                'a.loan_app_enc_id', 'b1.emi_collection_enc_id', 'b1.amount', 'b.assigned_loan_payments_enc_id', 'b.loan_app_enc_id', 'b1.loan_account_number',
                'b1.payment_method'
            ])
            ->joinWith(['assignedLoanPayments b' => function ($b) {
                $b->joinWith(['emiCollectionEnc b1'], false);
            }])
            ->where(['a.loan_app_enc_id' => $params['loan_id'], 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        if ($emiList) {
            return ['status' => 200, 'data' => $emiList];
        }
        return ['status' => 404, 'message' => 'not found'];
    }

    private function assignedPayment($params)
    {
        $assignedList = LoanApplications::find()
            ->alias('a')
            ->joinWith(['assignedLoanPayments b' => function ($b) {
                $b->select(['b.assigned_loan_payments_enc_id', 'b1.loan_payments_enc_id', 'b.loan_app_enc_id']);
                $b->joinWith(['loanPaymentsEnc b1' => function ($b1) {
                    $b1->select([
                        'b1.loan_payments_enc_id', 'b1.payment_amount', 'b1.payment_mode', 'b1.payment_short_url', 'b1.payment_status',
                        "(CASE WHEN b1.payment_link_type = '0' Then 'Link' WHEN b1.payment_link_type = '1' Then 'QR' ELSE 'Manual' END) as mode", 'b1.reference_number',
                        "(CASE WHEN b1.image IS NOT NULL THEN CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->payments->image . "', b1.image_location, '/',b1.image) ELSE NULL END) as receipt",
                        'b1.remarks', 'b1.created_on', "CONCAT(b3.first_name, ' ', b3.last_name) as created_by", "CONCAT(b4.first_name, ' ', b4.last_name) as updated_by", 'b1.updated_on'
                    ]);
                    $b1->joinWith(['loanPaymentsDetails b2' => function ($b2) {
                        $b2->select(['b2.loan_payments_enc_id', 'b2.no_dues_name', 'b2.no_dues_amount']);
                    }]);
                    $b1->joinWith(['createdBy b3'], false);
                    $b1->joinWith(['updatedBy b4'], false);
                }]);
                $b->groupBy(['b.assigned_loan_payments_enc_id']);
                $b->orderBy(['b1.created_on' => SORT_DESC]);
            }])
            ->groupBy(['a.loan_app_enc_id'])
            ->where(['a.loan_app_enc_id' => $params['loan_id'], 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        $res = [];
        $paymentModes = [
            '0' => 'Online Payment', '1' => 'NEFT', '2' => 'RTGS', '3' => 'IMPS', '4' => 'Cheque', '5' => 'UPI',
            '6' => 'DD', '7' => 'Cash', '8' => 'Credit Card', '9' => 'Debit Card'
        ];
        $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        foreach ($assignedList as $assigned) {
            foreach ($assigned['assignedLoanPayments'] as $asp) {
                $payment = $asp['loanPaymentsEnc']['payment_mode'];
                if ($payment != null) {
                    $asp['loanPaymentsEnc']['payment_mode'] = $paymentModes[$payment];
                    if ($asp['loanPaymentsEnc']['receipt'] != null) {
                        $asp['loanPaymentsEnc']['receipt'] = $my_space->signedURL($asp['loanPaymentsEnc']['receipt'], "15 minutes");;
                    }
                }
                $res[] = $asp['loanPaymentsEnc'];
            }
        }
        //       'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loan_payments->image, 'https') . '", p1.image_location, "/", p1.image) ELSE NULL END imgg',
        if ($res) {
            return ['status' => 200, 'data' => $res];
        }
        return ['status' => 404, 'message' => 'not found'];
    }

    // adding city codes in cities table
    public function actionAddCity()
    {
        $jsonData = file_get_contents('https://empoweryouth.com/assets/lJCWPnNNVy3d95ppLp7M_cities.json');
        $citiesData = Json::decode($jsonData, true);

        $entryCount = count($citiesData['data']);

        $limit = 10;
        $totalPages = ceil($entryCount / $limit);

        for ($page = 1; $page <= $totalPages; $page++) {
            $citiesFromUrl = array_slice($citiesData['data'], ($page - 1) * $limit, $limit);

            foreach ($citiesFromUrl as $cityData) {
                $cityName = $cityData['name'];
                $cityCode = $cityData['city_code'];

                //                $existingCity = Cities::findOne(['name' => $cityName]);
                $existingCity = Cities::find()
                    ->alias('a')
                    ->select(['a.city_enc_id', 'a.city_code', 'a.state_enc_id', 'b.state_enc_id', 'b.country_enc_id'])
                    ->joinWith(['stateEnc b' => function ($b) {
                        $b->joinWith(['countryEnc c']);
                    }], false)
                    ->where(['a.name' => $cityName, 'c.name' => 'India'])
                    ->asArray()
                    ->one();

                if ($existingCity) {
                    Yii::$app->db->createCommand()
                        ->update(Cities::tableName(), ['city_code' => $cityCode], ['city_enc_id' => $existingCity['city_enc_id']])
                        ->execute();
                    //                    $existingCity[0]->city_code = $cityCode;
                    //                    $existingCity[0]->update();
                }
            }
        }
        return 'Data updated successfully.';
    }
}
