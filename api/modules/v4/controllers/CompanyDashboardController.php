<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\IndividualSignup;
use api\modules\v4\models\LoanApplication;
use common\models\AssignedDeals;
use common\models\AssignedFinancerLoanType;
use common\models\AssignedLoanProvider;
use common\models\AssignedSupervisor;
use common\models\ClaimedDeals;
use common\models\EducationLoanPayments;
use common\models\EsignOrganizationTracking;
use common\models\LoanApplicationComments;
use common\models\LoanApplicationNotifications;
use common\models\LoanApplications;
use common\models\LoanSanctionReports;
use common\models\Organizations;
use common\models\Referral;
use common\models\ReferralSignUpTracking;
use common\models\SelectedServices;
use common\models\SharedLoanApplications;
use common\models\UserRoles;
use common\models\Users;
use common\models\UserTypes;
use yii\web\UploadedFile;
use yii\db\Expression;
use common\models\Utilities;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\helpers\Url;
use yii\filters\ContentNegotiator;

class CompanyDashboardController extends ApiBaseController
{
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

    public function actionLeadStats()
    {
        if ($user = $this->isAuthorized()) {

            $user = Users::findOne(['user_enc_id' => $user->user_enc_id]);

            if ($user->organization_enc_id) {

                $leads = $this->getDsa($user->user_enc_id);

                $dsa = [];
                if ($leads) {
                    foreach ($leads as $val) {
                        array_push($dsa, $val['assigned_user_enc_id']);
                    }
                }

                $dsa[] = $user->user_enc_id;
            }

            $service = SelectedServices::find()
                ->alias('a')
                ->joinWith(['serviceEnc b'], false)
                ->where(['a.organization_enc_id' => $user->organization_enc_id, 'a.is_selected' => 1, 'b.name' => 'Loans'])
                ->exists();

            $stats = LoanApplications::find()
                ->alias('a')
                ->select([
//                    'COUNT(DISTINCT a.loan_app_enc_id) as all_applications',
                    'COUNT(CASE WHEN a.form_type = "others" THEN 1 END) as all_applications',
                    'COUNT(CASE WHEN i.status = "0" THEN 1 END) as new_leads',
                    'COUNT(CASE WHEN i.status = "1" THEN 1 END) as accepted',
                    'COUNT(CASE WHEN i.status = "2" THEN 1 END) as pre_verification',
                    'COUNT(CASE WHEN i.status = "3" THEN 1 END) as under_process',
                    'COUNT(CASE WHEN i.status = "4" THEN 1 END) as sanctioned',
                    'COUNT(CASE WHEN i.status = "5" THEN 1 END) as disbursed',
                    'COUNT(CASE WHEN i.status = "10" THEN 1 END) as rejected',
                ])
//                ->joinWith(['assignedLoanProviders i' => function ($i) {
//                    $i->onCondition(['or',
//                        ['not', ['i.provider_enc_id' => null]],
//                        ['not', ['i.provider_enc_id' => '']]
//                    ]);
////                    $i->andWhere(['in', 'i.status', [0, 3, 4, 10]]);
//                }], false)
                ->joinWith(['assignedLoanProviders i' => function ($i) use ($service, $user) {
                    $i->joinWith(['providerEnc j']);
                    if ($service) {
                        $i->andWhere(['i.provider_enc_id' => $user->organization_enc_id]);
                    }
                }])
                ->andWhere(['a.is_deleted' => 0]);

//            if ($user->organization_enc_id) {
//                $stats->andWhere(['a.lead_by' => $dsa]);
//            } else {
////                $stats->andWhere(['a.lead_by' => $user->user_enc_id]);
//                $stats->andWhere(['or', ['a.lead_by' => $user->user_enc_id], ['a.managed_by' => $user->user_enc_id]]);
//            }

            if ($user->organization_enc_id) {
                if (!$service) {
                    $stats->andWhere(['a.lead_by' => $dsa]);
                }
            } else {
//                $loans->andWhere(['a.lead_by' => $user->user_enc_id]);
                $stats->andWhere(['or', ['a.lead_by' => $user->user_enc_id], ['a.managed_by' => $user->user_enc_id]]);
            }

            $stats = $stats->asArray()
                ->one();

            return $this->response(200, ['status' => 200, 'stats' => $stats]);


        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionLoanApplications()
    {
        if ($user = $this->isAuthorized()) {

            $user = Users::findOne(['user_enc_id' => $user->user_enc_id]);

            $service = SelectedServices::find()
                ->alias('a')
                ->joinWith(['serviceEnc b'], false)
                ->where(['a.organization_enc_id' => $user->organization_enc_id, 'a.is_selected' => 1, 'b.name' => 'Loans'])
                ->exists();

            if ($user->organization_enc_id) {

                $leads = $this->getDsa($user->user_enc_id);

                $dsa = [];
                if ($leads) {
                    foreach ($leads as $val) {
                        array_push($dsa, $val['assigned_user_enc_id']);
                    }
                }

                $dsa[] = $user->user_enc_id;
            }

            $shared_apps = $this->sharedApps($user->user_enc_id);

            $params = Yii::$app->request->post();

            $filter = null;
            $limit = 10;
            $page = 1;

            if (isset($params['filter']) && !empty($params['filter'])) {
                $filter = $params['filter'];
            }

            if (isset($params['limit']) && !empty($params['limit'])) {
                $limit = $params['limit'];
            }

            if (isset($params['page']) && !empty($params['page'])) {
                $page = $params['page'];
            }

            $loans = LoanApplications::find()
                ->distinct()
                ->alias('a')
                ->select(['a.id', 'a.loan_app_enc_id', 'a.college_course_enc_id', 'a.college_enc_id',
                    'a.created_on as apply_date', 'a.application_number',
                    '(CASE
                    WHEN i.status = "0" THEN "New Lead"
                    WHEN i.status = "1" THEN "Accepted"
                    WHEN i.status = "2" THEN "Pre Verification"
                    WHEN i.status = "3" THEN "Under Process"
                    WHEN i.status = "4" THEN "Sanctioned"
                    WHEN i.status = "5" THEN "Disbursed"
                    WHEN i.status = "10" THEN "Reject"
                    WHEN i.status = "11" THEN "Disbursed"
                    ELSE "N/A"
                END) as loan_status',
                    'i.status status_number',
                    'CONCAT(k.first_name, " ", k.last_name) employee_name',
                    'a.applicant_name',
                    'a.amount',
                    'a.amount_received',
                    'a.amount_due',
                    'a.scholarship',
                    'a.loan_type',
                    'REPLACE(g.name, "&amp;", "&") as org_name',
                    'a.semesters',
                    'a.years',
                    'a.phone',
                    'a.email',
                    'a.applicant_current_city as city',
                    '(CASE
                    WHEN a.gender = "1" THEN "Male"
                    WHEN a.gender = "2" THEN "Female"
                    ELSE "N/A"
                END) as gender',
                    'a.applicant_dob as dob',
                    'a.created_by',
                    'a.lead_by',
                    'a.managed_by'
                ])
                ->joinWith(['collegeCourseEnc f'], false)
                ->joinWith(['collegeEnc g'], false)
                ->joinWith(['loanCoApplicants h' => function ($h) {
                    $h->select(['h.loan_app_enc_id',
                        'h.relation',
                        'h.name',
                        'h.annual_income',
                        '(CASE
                        WHEN h.employment_type = "0" THEN "Non Working"
                        WHEN h.employment_type = "1" THEN "Salaried"
                        WHEN h.employment_type = "2" THEN "Self Employed"
                        ELSE "N/A"
                    END) as employment_type',
                    ]);
                }])
                ->joinWith(['assignedLoanProviders i' => function ($i) use ($service, $user) {
                    $i->joinWith(['providerEnc j']);
                    if ($service) {
                        $i->andWhere(['i.provider_enc_id' => $user->organization_enc_id]);
                    }
                }])
                ->joinWith(['managedBy k'], false)
                ->joinWith(['educationLoanPayments l' => function ($l) {
                    $l->select(['l.loan_app_enc_id', 'l.payment_status']);
                    $l->onCondition(['l.payment_status' => ['captured', 'created', 'waived off']]);
                }])
                ->andWhere(['a.is_deleted' => 0]);

            if ($user->organization_enc_id) {
                if (!$service) {
                    $loans->andWhere(['a.lead_by' => $dsa]);
                }
            } else {
//                $loans->andWhere(['a.lead_by' => $user->user_enc_id]);
                $loans->andWhere(['or', ['a.lead_by' => $user->user_enc_id], ['a.managed_by' => $user->user_enc_id]]);
            }

            if ($shared_apps['app_ids']) {
                $loans->orWhere(['a.loan_app_enc_id' => $shared_apps['app_ids']]);
            }

            if ($filter) {
                $loans->andWhere(['in', 'i.status', $filter]);
            }

            if (!empty($params['search_keyword'])) {
                $loans->andWhere([
                    'or',
                    ['like', 'a.applicant_name', $params['search_keyword']],
                    ['like', 'a.loan_type', $params['search_keyword']],
                    ['like', 'a.amount', $params['search_keyword']],
                    ['like', 'a.created_on', $params['search_keyword']],
                    ['like', 'a.phone', $params['search_keyword']],
                    ['like', 'a.application_number', $params['search_keyword']],
                ]);
            }

            if (!empty($params['form_type']) && $params['form_type'] == 'diwali-dhamaka') {
                $loans->andWhere(['a.form_type' => 'diwali-dhamaka']);
            } else {
                $loans->andWhere(['!=', 'a.form_type', 'diwali-dhamaka']);
            }

            $loans = $loans
                ->orderBy(['a.created_on' => SORT_DESC])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            if ($loans) {
                foreach ($loans as $key => $val) {
                    if (!$val['educationLoanPayments']) {
                        $get_amount = EducationLoanPayments::find()->where(['loan_app_enc_id' => $val['loan_app_enc_id']])->one();
                        $loans[$key]['payment_status'] = $get_amount->payment_status;
                    } else {
                        $loans[$key]['payment_status'] = $val['educationLoanPayments'][0]['payment_status'];
                    }
                    unset($loans[$key]['educationLoanPayments']);

                    $loans[$key]['sharedTo'] = SharedLoanApplications::find()
                        ->alias('a')
                        ->select(['a.shared_loan_app_enc_id', 'a.loan_app_enc_id', 'a.access', 'a.status', 'concat(b.first_name," ",b.last_name) name', 'b.phone',
                            'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", concat(b.first_name," ",b.last_name), "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'
                        ])
                        ->joinWith(['sharedTo b'], false)
                        ->where(['a.is_deleted' => 0, 'a.shared_by' => $user->user_enc_id, 'a.loan_app_enc_id' => $val['loan_app_enc_id']])
                        ->asArray()
                        ->all();

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

                    $provider = AssignedLoanProvider::findOne(['loan_application_enc_id' => $val['loan_app_enc_id'], 'provider_enc_id' => $params['provider_id']]);

                    $loans[$key]['bdo_approved_amount'] = $provider->bdo_approved_amount;
                    $loans[$key]['tl_approved_amount'] = $provider->tl_approved_amount;
                    $loans[$key]['soft_approval'] = $provider->soft_approval;
                    $loans[$key]['soft_sanction'] = $provider->soft_sanction;
                    $loans[$key]['valuation'] = $provider->valuation;
                    $loans[$key]['disbursement_approved'] = $provider->disbursement_approved;
                    $loans[$key]['insurance_charges'] = $provider->insurance_charges;

                }
            }

            return $this->response(200, ['status' => 200, 'loans' => $loans]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function sharedApps($user_id)
    {
        $shared = SharedLoanApplications::find()
            ->alias('a')
            ->select(['a.loan_app_enc_id', 'a.access', 'concat(b.first_name," ",b.last_name) shared_by'])
            ->joinWith(['sharedBy b'], false)
            ->where(['a.is_deleted' => 0, 'a.status' => 'Active', 'a.shared_to' => $user_id])
            ->asArray()
            ->all();

        $loan_app_ids = [];
        if ($shared) {
            foreach ($shared as $s) {
                array_push($loan_app_ids, $s['loan_app_enc_id']);
            }
        }

        return ['app_ids' => $loan_app_ids, 'shared' => $shared];
    }

    private function getDsa($user_id)
    {
        return AssignedSupervisor::find()
            ->select(['assigned_user_enc_id'])
            ->where(['supervisor_enc_id' => $user_id, 'supervisor_role' => 'Lead Source', 'is_supervising' => 1])
            ->groupBy(['assigned_user_enc_id'])
            ->asArray()
            ->all();
    }

    public function actionLoanDetail()
    {
        if ($user = $this->isAuthorized()) {

            $organization_id = Users::findOne(['user_enc_id' => $user->user_enc_id])->organization_enc_id;
            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            if (empty($params['provider_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "provider_id"']);
            }


            $loan = LoanApplications::find()
                ->alias('a')
                ->select(['a.loan_app_enc_id', 'a.amount', 'a.created_on apply_date', 'a.application_number',
                    'a.applicant_name', 'a.phone', 'a.email', 'b.status as loan_status', 'a.loan_type'])
                ->joinWith(['assignedLoanProviders b' => function ($b) use ($organization_id) {
//                    $b->where(['b.provider_enc_id' => $organization_id]);
                }], false)
                ->joinWith(['loanCertificates c' => function ($c) {
                    $c->select(['c.certificate_enc_id', 'c.loan_app_enc_id', 'c.short_description', 'c.certificate_type_enc_id', 'c.number', 'c1.name', 'c.proof_image', 'c.proof_image_location', 'c.created_on', 'CONCAT(c2.first_name," ",c2.last_name) created_by']);
                    $c->joinWith(['certificateTypeEnc c1'], false);
                    $c->joinWith(['createdBy c2'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->joinWith(['loanCoApplicants d' => function ($d) {
                    $d->select(['d.loan_co_app_enc_id', 'd.loan_app_enc_id', 'd.name', 'd.email', 'd.phone',
                        'd.relation', 'd.employment_type', 'd.annual_income', 'd.co_applicant_dob', 'd.occupation']);
                }])
                ->joinWith(['loanApplicationNotifications e' => function ($e) {
                    $e->select(['e.notification_enc_id', 'e.message', 'e.loan_application_enc_id', 'e.created_on', 'concat(e1.first_name," ",e1.last_name) created_by']);
                    $e->joinWith(['createdBy e1'], false);
                    $e->onCondition(['e.is_deleted' => 0, 'e.source' => 'EL']);
                }])
                ->joinWith(['loanApplicationComments f' => function ($f) {
                    $f->select(['f.comment_enc_id', 'f.comment', 'f.loan_application_enc_id', 'f.created_on', 'concat(f1.first_name," ",f1.last_name) created_by']);
                    $f->joinWith(['createdBy f1'], false);
                    $f->onCondition(['f.is_deleted' => 0, 'f.source' => 'EL']);
                }])
                ->joinWith(['loanPurposes g' => function ($g) {
                    $g->select(['g.financer_loan_purpose_enc_id', 'g.financer_loan_purpose_enc_id', 'g.loan_app_enc_id', 'g1.purpose']);
                    $g->joinWith(['financerLoanPurposeEnc g1'], false);
                }])
                ->where(['a.loan_app_enc_id' => $params['loan_id'], 'a.is_deleted' => 0])
                ->asArray()
                ->one();

            if ($loan) {

                $loan_sanction_report = LoanSanctionReports::find()
                    ->alias('d')
                    ->select(['d.report_enc_id', 'd.loan_app_enc_id', 'd.loan_amount', 'd.processing_fee', 'd.rate_of_interest', 'd.fldg'])
                    ->joinWith(['loanEmiStructures d1' => function ($d1) {
                        $d1->select(['d1.loan_structure_enc_id', 'd1.sanction_report_enc_id', 'd1.due_date', 'd1.amount', 'd1.is_advance']);
                    }])
                    ->where(['d.loan_app_enc_id' => $loan['loan_app_enc_id'], 'd.loan_provider_id' => $organization_id])
                    ->groupBy(['d.report_enc_id'])
                    ->asArray()
                    ->one();

                $loan['loanSanctionReports'] = $loan_sanction_report;

                if ($loan['loanCertificates']) {
                    foreach ($loan['loanCertificates'] as $key => $val) {
                        if ($val['proof_image']) {
                            $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                            $proof = $my_space->signedURL(Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->image . $val['proof_image_location'] . DIRECTORY_SEPARATOR . $val['proof_image'], "15 minutes");
                            $loan['loanCertificates'][$key]['proof_image'] = $proof;
                        }
                    }
                }

                $branch = AssignedLoanProvider::find()
                    ->alias('a')
                    ->select(['a.assigned_loan_provider_enc_id', 'a.branch_enc_id', 'b.location_name', 'b1.name city'])
                    ->joinWith(['branchEnc b' => function ($b) {
                        $b->joinWith(['cityEnc b1']);
                    }], false)
                    ->andWhere(['a.loan_application_enc_id' => $loan['loan_app_enc_id'], 'a.provider_enc_id' => $params['provider_id']])
                    ->asArray()
                    ->one();

                if (!empty($branch)) {
                    $loan['branch_id'] = $branch['branch_enc_id'];
                    $loan['branch'] = $branch['location_name'] ? $branch['location_name'] . ', ' . $branch['city'] : $branch['city'];
                }

                return $this->response(200, ['status' => 200, 'loan_detail' => $loan]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        }

        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    public function actionUpdateProviderStatus()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['loan_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
            }

            if (empty($params['status'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "status"']);
            }

            $provider = AssignedLoanProvider::findOne(['loan_application_enc_id' => $params['loan_id'], 'provider_enc_id' => $user->organization_enc_id, 'is_deleted' => 0]);

            if (!$provider) {
                return $this->response(404, ['status' => 404, 'message' => 'provider not found with this loan_id']);
            }

            $provider->status = $params['status'];
            $provider->updated_by = $user->user_enc_id;
            $provider->updated_on = date('Y-m-d H:i:s');
            if (!$provider->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred while updating status']);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
        }

        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    public function actionSaveOrganizationTracking()
    {
        Yii::$app->cache->flush();
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $org_id = $user->organization_enc_id;

            if (!$org_id) {
                $ref_enc_id = ReferralSignUpTracking::findOne(['sign_up_user_enc_id' => $user->user_enc_id])->referral_enc_id;
                if ($ref_enc_id) {
                    $org_id = Referral::findOne(['referral_enc_id' => $ref_enc_id])->organization_enc_id;
                }
            }

            $model = new EsignOrganizationTracking();
            $model->esign_tracking_enc_id = Yii::$app->getSecurity()->generateRandomString();
            $model->organization_enc_id = $org_id;
            $model->employee_id = $user->user_enc_id;
            $model->legality_document_id = $params['legality_document_id'];
            $model->empower_loans_tracking_id = $params['empower_loans_tracking_id'];
            $model->created_by = $user->user_enc_id;
            $model->created_on = date('Y-m-d H:i:s');
            if (!$model->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionEmployees()
    {
        if ($user = $this->isAuthorized()) {

            if ($user->organization_enc_id) {

                $params = Yii::$app->request->post();

                $employee = $this->employeesList($user->organization_enc_id, $params);
                $dsa = $this->dsaList($user->user_enc_id, $params);

                $dsa_id = [];
                if ($dsa) {
                    foreach ($dsa as $d) {
                        array_push($dsa_id, $d['user_enc_id']);
                    }
                }

                $dsa_id[] = $user->user_enc_id;

                $connector = $this->connectorsList($dsa_id, $params);

                return $this->response(200, ['status' => 200, 'employees' => $employee, 'dsa' => $dsa, 'connector' => $connector]);
            } else {
                return $this->response(403, ['status' => 403, 'message' => 'only authorized by financer']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function employeesList($org_id, $params = null)
    {
        $employee = Users::find()
            ->alias('a')
            ->select(['a.user_enc_id','ur.employee_code','rs.sign_up_user_enc_id', 'a.username', 'a.email', 'a.phone',
                'a.first_name', 'a.last_name', 'a.status', new Expression('"Employee" as user_type')])
            ->joinWith(['userRoles0 ur'], false)
            ->joinWith(['referralSignUpTrackings rs' => function($rs){
                $rs->joinWith(['referralEnc b'], false);
            }], false)
            ->where(['b.organization_enc_id' => $org_id, 'a.is_deleted' => 0, 'rs.is_deleted' => 0]);

//        $employee = ReferralSignUpTracking::find()
//            ->alias('a')
//            ->select(['a.sign_up_user_enc_id user_enc_id', 'c.username', 'c.email', 'c.phone', 'c.first_name', 'c.last_name', 'c.status', new Expression('"Employee" as user_type')])
//            ->joinWith(['referralEnc b'], false)
//            ->joinWith(['signUpUserEnc c'], false)
//            ->where(['b.organization_enc_id' => $org_id, 'c.is_deleted' => 0, 'a.is_deleted' => 0]);

        if ($params != null && !empty($params['employee_search'])) {
            $employee->andWhere([
                'or',
                ['like', 'CONCAT(c.first_name," ", c.last_name)', $params['employee_search']],
                ['like', 'c.username', $params['employee_search']],
                ['like', 'c.email', $params['employee_search']],
                ['like', 'c.phone', $params['employee_search']],
            ]);
        }

        if ($params != null && !empty($params['alreadyExists'])) {
            $employee->andWhere(['not', ['a.sign_up_user_enc_id' => $params['alreadyExists']]]);
        }

        return $employee->asArray()
            ->all();
    }

    private function dsaList($user_id, $params = null)
    {
        $dsa = AssignedSupervisor::find()
            ->alias('a')
            ->select(['a.assigned_user_enc_id user_enc_id', 'b.username', 'b.email', 'b.phone', 'b.first_name', 'b.last_name', 'b.status', new Expression('"DSA" as user_type')])
            ->joinWith(['assignedUserEnc b'], false)
            ->where(['a.supervisor_enc_id' => $user_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);

        if ($params != null && !empty($params['dsa_search'])) {
            $dsa->andWhere([
                'or',
                ['like', 'CONCAT(b.first_name," ", b.last_name)', $params['dsa_search']],
                ['like', 'b.username', $params['dsa_search']],
                ['like', 'b.email', $params['dsa_search']],
                ['like', 'b.phone', $params['dsa_search']],
            ]);
        }

        return $dsa->asArray()
            ->all();
    }

    private function connectorsList($user_id, $params = null)
    {
        $connector = SelectedServices::find()
            ->alias('a')
            ->select(['a.created_by user_enc_id', 'b.username', 'b.email', 'b.phone', 'b.first_name', 'b.last_name', 'b.status', new Expression('"Connector" as user_type')])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['serviceEnc c'], false)
            ->where(['a.assigned_user' => $user_id, 'c.name' => 'Connector', 'b.is_deleted' => 0, 'a.is_selected' => 1]);

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

    public function actionEmployeeSearch($employee_search, $type, $loan_id)
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

//            if (empty($params['employee_search'])) {
//                return $this->response(422, ['status' => 422, 'message' => 'missing information "employee_search"']);
//            }
//
//            if (empty($params['type'])) {
//                return $this->response(422, ['status' => 422, 'message' => 'missing information "type"']);
//            }
//
//            if (empty($params['loan_id'])) {
//                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
//            }

            $params['employee_search'] = $employee_search;
            $params['type'] = $type;
            $params['loan_id'] = $loan_id;

//            if (!$user->organization_enc_id) {
//                return $this->response(403, ['status' => 403, 'message' => 'forbidden']);
//            }

            $lender = $this->getFinancerId($user);
            if (!$lender) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            $already_exists = SharedLoanApplications::find()
                ->select(['shared_to'])
                ->where(['is_deleted' => 0, 'loan_app_enc_id' => $loan_id])
                ->asArray()
                ->all();

            $already_exists_ids = [];
            if ($already_exists) {
                foreach ($already_exists as $e) {
                    array_push($already_exists_ids, $e['shared_to']);
                }
            }

            $params['alreadyExists'] = $already_exists_ids;

            if ($params['type'] == 'employees') {
                $employees = $this->employeesList($lender, $params);
                if ($employees) {
                    foreach ($employees as $key => $val) {
                        $employees[$key]['lead_by'] = false;
                        $employees[$key]['managed_by'] = false;
                        if ($val['user_enc_id'] == LoanApplications::findOne(['loan_app_enc_id' => $params['loan_id']])->lead_by) {
                            $employees[$key]['lead_by'] = true;
                        }

                        if ($val['user_enc_id'] == LoanApplications::findOne(['loan_app_enc_id' => $params['loan_id']])->managed_by) {
                            $employees[$key]['managed_by'] = true;
                        }

                        $employees[$key]['id'] = $val['user_enc_id'];
                        $employees[$key]['name'] = $val['first_name'] . ' ' . $val['last_name'];

                    }
                }
            }

            return $this->response(200, ['status' => 200, 'list' => $employees]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionChangeStatus()
    {
        if ($user = $this->isAuthorized()) {

//            if ($user->organization_enc_id) {

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

            $user->status = $params['status'];
            $user->last_updated_on = date('Y-m-d H:i:s');
            if (!$user->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

            return $this->response(200, ['status' => 200, 'message' => 'status updated']);


//            } else {
//                return $this->response(403, ['status' => 403, 'message' => 'only authorized by financer']);
//            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateEmployeeInfo()
    {
        if ($user = $this->isAuthorized()) {
            if ($user->organization_enc_id) {

                $params = Yii::$app->request->post();

                if (empty($params['user_id'])) {
                    return $this->response(422, ['status' => 422, 'message' => 'missing information "user_id"']);
                }

                $user = Users::findOne(['user_enc_id' => $params['user_id']]);

                if (!$user) {
                    return $this->response(404, ['status' => 404, 'message' => 'user not found']);
                }

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

    public function actionDsaConnectors()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $connector = $this->connectorsList($user->user_enc_id, $params);

            return $this->response(200, ['status' => 200, 'connector' => $connector]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAllEmployees()
    {
        if ($user = $this->isAuthorized()) {

            if ($user->organization_enc_id) {

                $params = Yii::$app->request->post();


                $employee = $this->employeesList($user->organization_enc_id, $params);
                $dsa = $this->dsaList($user->user_enc_id, $params);

                $dsa_id = [];
                if ($dsa) {
                    foreach ($dsa as $d) {
                        array_push($dsa_id, $d['user_enc_id']);
                    }
                }

                $dsa_id[] = $user->user_enc_id;

                $connector = $this->connectorsList($dsa_id, $params);

                $all = [];

                // extracting employee
                foreach ($employee as $val) {
                    $data = [];
                    $data['value'] = $val['user_enc_id'];
                    $data['label'] = $val['first_name'] . ' ' . $val['last_name'];
                    $data['user_type'] = $val['user_type'];
                    $all[] = $data;
                }

                // extracting dsa
                foreach ($dsa as $val) {
                    $data = [];
                    $data['value'] = $val['user_enc_id'];
                    $data['label'] = $val['first_name'] . ' ' . $val['last_name'];
                    $data['user_type'] = $val['user_type'];
                    $all[] = $data;
                }

                // extracting dsa
                foreach ($connector as $val) {
                    $data = [];
                    $data['value'] = $val['user_enc_id'];
                    $data['label'] = $val['first_name'] . ' ' . $val['last_name'];
                    $data['user_type'] = $val['user_type'];
                    $all[] = $data;
                }

                return $this->response(200, ['status' => 200, 'all_employees' => $all]);
            } else {
                return $this->response(403, ['status' => 403, 'message' => 'only authorized by financer']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionFinancerDetail()
    {

        $params = Yii::$app->request->post();

        if (empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "slug"']);
        }

        $detail = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name', 'a.slug', 'a.email', 'a.phone', 'a.description', 'a.facebook', 'a.google', 'a.twitter', 'a.instagram', 'a.linkedin',
                'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo', 'CASE WHEN a.cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, 'https') . '", a.cover_image_location, "/", a.cover_image) ELSE NULL END cover_image'
            ])
            ->joinWith(['organizationLocations b' => function ($b) {
                $b->select(['b.location_enc_id', 'b.organization_enc_id', 'b.location_name', 'b.location_for', 'b.email', 'b.description',
                    'b.website', 'b.phone', 'b.address', 'b.postal_code', 'b.latitude', 'b.longitude', 'b.sequence', 'b1.name city_name', 'b2.name state_name']);
                $b->joinWith(['cityEnc b1' => function ($b1) {
                    $b1->joinWith(['stateEnc b2'], false);
                }], false);
                $b->onCondition(['b.is_deleted' => 0]);
            }])
            ->where(['a.slug' => $params['slug'], 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        $service = SelectedServices::find()->alias('a')->joinWith(['serviceEnc b'], false)->where(['a.organization_enc_id' => $detail['organization_enc_id'], 'a.is_selected' => 1, 'b.name' => 'Loans'])->exists();

        if (!$service) {
            return $this->response(403, ['status' => 403, 'message' => 'forbidden']);
        }

        if ($detail) {

            $detail['assignedFinancerLoanTypes'] = AssignedFinancerLoanType::find()
                ->alias('a')
                ->select(['a.assigned_financer_enc_id', 'a.organization_enc_id', 'a.loan_type_enc_id', 'a.type', 'b.name loan_type'])
                ->joinWith(['loanTypeEnc b'], false)
                ->joinWith(['assignedFinancerLoanPartners c' => function ($c) {
                    $c->select(['c.assigned_loan_partner_enc_id', 'c.assigned_financer_enc_id', 'c.loan_partner_enc_id',
                        'c.ltv', 'concat(c1.first_name," ",c1.last_name) partner_name']);
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

            $notification = new LoanApplicationNotifications();
            $notification->notification_enc_id = Yii::$app->getSecurity()->generateRandomString();
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

            $comment = new LoanApplicationComments();
            $comment->comment_enc_id = Yii::$app->getSecurity()->generateRandomString();
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

            $exists = SharedLoanApplications::findOne(['loan_app_enc_id' => $params['loan_id'], 'shared_to' => $params['shared_to'], 'is_deleted' => 0]);

            if ($exists) {
                return $this->response(409, ['status' => 409, 'message' => 'Application already shared with this user']);
            }

            $shared = new SharedLoanApplications();
            $shared->shared_loan_app_enc_id = Yii::$app->getSecurity()->generateRandomString();
            $shared->loan_app_enc_id = $params['loan_id'];
            $shared->shared_by = $user->user_enc_id;
            $shared->shared_to = $params['shared_to'];
            $shared->access = $params['access'];
            $shared->created_by = $user->user_enc_id;
            $shared->created_on = date('Y-m-d H:i:s');
            if (!$shared->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $shared->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateSharedApplication()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['shared_loan_app_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "shared_loan_app_id"']);
            }

            $shared = SharedLoanApplications::findOne(['shared_loan_app_enc_id' => $params['shared_loan_app_id'], 'is_deleted' => 0]);

            if (!$shared) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

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

    public function actionSaveDiwaliDhamakaData()
    {

        $ids = '';
        $params = Yii::$app->request->post();

        //getting csv file
        $data = UploadedFile::getInstanceByName('file');

        //reading file
        $file = fopen($data->tempName, "r");
        $array_data = [];

        //get data from csv
        while (($data = fgetcsv($file)) !== FALSE) {
            if (!empty($data)) {
                array_push($array_data, $data);
            }
        }


        unset($array_data[0]);

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

            //saving data
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $bdo_name = $d[5];
                $bdo_number = $d[6];
                $refId = Referral::findOne(['organization_enc_id' => Organizations::findOne(['slug' => 'phfleasing'])->organization_enc_id])->code;
                $employee_exists = Users::findOne(['phone' => [$bdo_number, '+91' . $bdo_number]]);
                if (!$employee_exists) {
                    $signup = new IndividualSignup();
                    $signup->phone = $bdo_number;
                    $signup->dsaRefId = $refId;
                    $signup->user_type = 'Employee';
                    $e_bdo_name = explode(' ', $bdo_name);
                    $signup->first_name = $e_bdo_name[0];
                    $signup->last_name = $e_bdo_name[1];
                    $signup->username = $this->generate_username($bdo_name);
                    $signup->password = $bdo_number;
                    $signup->source = Yii::$app->getRequest()->getUserIP();
                    if (!$signup->saveUser()) {
                        $transaction->rollback();
                        $ids = $ids . $d[0] . ',';
                    }

                }

                $employee_id = Users::findOne(['phone' => [$bdo_number, '+91' . $bdo_number]])->user_enc_id;
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

                $transaction->commit();

            } catch (Exception $e) {
                $ids = $ids . $d[0] . ',' . $e->getMessage();
                $transaction->rollback();
//                    $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);
            }

        }


        //closing file
        fclose($file);

        if (!empty($ids)) {
            Yii::$app->mailer->htmlLayout = 'layouts/email';
            $mail = Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params->from_email => 'Empower Loans'])
                ->setTo(['ravindersaini15697@gmail.com' => 'Ravinder Singh'])
                ->setTextBody($ids)
                ->setSubject('not saved ids');

            if ($mail->send()) {
                return $this->response(200, ['status' => 200, 'message' => 'mail sent']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred email']);
            }
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

    }

    public function actionSaveCode()
    {

        $loan_users = null;
        // deal slug
        $deal_slug = 'diwali-dhamaka';
        // coupon for everyone
        $code_for_everyone = 'BAG';
        // coupon for HEADPHONE
        $code_for_headphone = 'HEADPHONES';
        // coupon for Power Bank
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

                    //saving claimed deal for user
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

        } catch (Exception $e) {
            $transaction->rollback();
            $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

    }

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
//            ->andWhere(['b1.slug' => 'rav1', 'b.status' => 5])
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

            $employee = UserRoles::findOne(['user_enc_id' => $params['parent_id'], 'organization_enc_id' => $user->organization_enc_id]);
            $field = $params['id'];

            if (!empty($employee)) {
                $employee->$field = $params['value'];
                $employee->updated_by = $user->user_enc_id;
                $employee->updated_on = date('Y-m-d H:i:s');
                if (!$employee->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $employee->getErrors()]);
                }
            } else {
                $employee = new UserRoles();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $employee->role_enc_id = $utilitiesModel->encrypt();
                $employee->user_type_enc_id = UserTypes::findOne(['user_type' => 'Employee'])->user_type_enc_id;
                $employee->user_enc_id = $params['parent_id'];
                $employee->organization_enc_id = $user->organization_enc_id;
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

}