<?php

namespace account\controllers;

use account\models\loanApplications\LoanSanctionedForm;
use common\models\AssignedLoanProvider;
use common\models\LoanApplicationLogs;
use common\models\LoanApplications;
use common\models\LoanDocuments;
use common\models\LoanSanctionReports;
use common\models\Organizations;
use common\models\SelectedServices;
use common\models\Services;
use common\models\User;
use common\models\Usernames;
use common\models\UserOtherDetails;
use common\models\Users;
use frontend\models\whatsAppShareForm;
use yii\web\Response;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Utilities;


class EducationLoansController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionTest()
    {
        $params['id'] = 'mKXM03kGoZak4E81xxmW79z4NJv6eW';
        $loansApplications = AssignedLoanProvider::find()
            ->alias('z')
            ->distinct()
            ->where(['provider_enc_id' => $params['id']])
            ->select(['a.loan_app_enc_id',
                'a.created_on as apply_date',
                '(CASE
                    WHEN a.loan_status = "0" THEN "New Lead"
                    WHEN a.loan_status = "1" THEN "Accepted"
                    WHEN a.loan_status = "2" THEN "Pre Verification"
                    WHEN a.loan_status = "3" THEN "Under Process"
                    WHEN a.loan_status = "4" THEN "Sanctioned"
                    WHEN a.loan_status = "5" THEN "Disbursed"
                    WHEN a.loan_status = "10" THEN "Reject"
                    ELSE "N/A"
                END) as loan_status',
                'a.applicant_name',
                'a.amount',
                'a.degree',
                'f.course_name',
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
            ])
            ->joinWith(['loanApplicationEnc a' => function ($b) {
                $b->joinWith(['loanCoApplicants h']);
                $b->joinWith(['pathToClaimOrgLoanApplications c' => function ($b) {
                    $b->joinWith(['assignedCourseEnc d' => function ($v) {
                        $v->joinWith(['courseEnc f'], false, 'INNER JOIN');
                        $v->joinWith(['organizationEnc g'], false, 'INNER JOIN');
                    }]);
                }], false, 'INNER JOIN');
            }], true, 'LEFT JOIN')
            ->asArray()
            ->all();
    }

    public function actionDashboard($filter = null, $search = null)
    {
        $model = new LoanSanctionedForm();
        $permissions = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "Loans");
        if (!$permissions) {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $model->documents = Yii::$app->request->post('documents');
            if ($model->updateReport()) {
                return $this->refresh();
            } else {
                return false;
            }
        }

        $loans = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.loan_app_enc_id', 'a.college_course_enc_id', 'a.college_enc_id',
                'a.created_on as apply_date',
                '(CASE
                    WHEN i.status = "0" THEN "New Lead"
                    WHEN i.status = "1" THEN "Accepted"
                    WHEN i.status = "2" THEN "Pre Verification"
                    WHEN i.status = "3" THEN "Under Process"
                    WHEN i.status = "4" THEN "Sanctioned"
                    WHEN i.status = "5" THEN "Disbursed"
                    WHEN i.status = "10" THEN "Reject"
                    ELSE "N/A"
                END) as loan_status',
                'a.applicant_name',
                'a.amount',
                'a.amount_received',
                'a.amount_due',
                'a.scholarship',
                'a.degree',
                'f.course_name',
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
            ->joinWith(['assignedLoanProviders i' => function ($i) {
                $i->andWhere(['i.provider_enc_id' => Yii::$app->user->identity->organization_enc_id]);
            }])
            ->andWhere(['a.status' => 1]);
        if ($filter != null) {
            if ($filter != 'all') {
                $filter = explode(',', $filter);
                $loans->andWhere(['in', 'i.status', $filter]);
            }
        }
        if ($search != null) {
            $loans->andFilterHaving([
                'or',
                ['like', 'apply_date', $search],
                ['like', 'loan_status', $search],
                ['like', 'applicant_name', $search],
                ['like', 'amount', $search],
                ['like', 'amount_received', $search],
                ['like', 'amount_due', $search],
                ['like', 'scholarship', $search],
                ['like', 'degree', $search],
                ['like', 'course_name', $search],
                ['like', 'org_name', $search],
                ['like', 'semesters', $search],
                ['like', 'years', $search],
                ['like', 'phone', $search],
                ['like', 'email', $search],
                ['like', 'city', $search],
                ['like', 'gender', $search],
                ['like', 'dob', $search],
            ]);
        }
        $loans = $loans->asArray()->all();
        $stats = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.loan_app_enc_id',
                'COUNT(a.loan_app_enc_id) as all_applications',
                'COUNT(CASE WHEN i.status = "0" THEN 1 END) as new_leads',
                'COUNT(CASE WHEN i.status = "1" THEN 1 END) as accepted',
                'COUNT(CASE WHEN i.status = "2" THEN 1 END) as pre_verification',
                'COUNT(CASE WHEN i.status = "3" THEN 1 END) as under_process',
                'COUNT(CASE WHEN i.status = "4" THEN 1 END) as sanctioned',
                'COUNT(CASE WHEN i.status = "5" THEN 1 END) as disbursed',
                'COUNT(CASE WHEN i.status = "10" THEN 1 END) as rejected',
            ])
            ->joinWith(['assignedLoanProviders i' => function ($i) {
                $i->andWhere(['i.provider_enc_id' => Yii::$app->user->identity->organization_enc_id]);
            }], false)
            ->andWhere(['a.status' => 1])
            ->asArray()
            ->one();

        $documents = LoanDocuments::findAll(['is_deleted' => 0, 'visible_for' => 'Loan']);

        return $this->render('dashboard', [
            'loans' => $loans,
            'model' => $model,
            'documents' => $documents,
            'stats' => $stats
        ]);
    }

    public function actionLeads($filter = null)
    {
        $user = Users::findOne(['user_enc_id' => Yii::$app->user->identity->user_enc_id]);
        $referrer_code = $user->getReferrals0()->one()->code;
        $model = new LoanSanctionedForm();
        $permissions = Yii::$app->userData->checkSelectedService(Yii::$app->user->identity->user_enc_id, "E-Partners");
        if (!$permissions) {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $model->documents = Yii::$app->request->post('documents');
            if ($model->updateReport()) {
                return $this->refresh();
            } else {
                return false;
            }
        }

        $loans = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.id', 'a.loan_app_enc_id', 'a.college_course_enc_id', 'a.college_enc_id',
                'a.created_on as apply_date',
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
                'a.applicant_name',
                'a.amount',
                'a.amount_received',
                'a.amount_due',
                'a.scholarship',
                'a.degree',
                'f.course_name',
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
            ->joinWith(['assignedLoanProviders i' => function ($i) {
                $i->joinWith(['providerEnc j']);
            }])
            ->andWhere(['a.lead_by' => Yii::$app->user->identity->user_enc_id]);
        if ($filter != null) {
            if ($filter != 'all') {
                $filter = explode(',', $filter);
                $loans->andWhere(['in', 'i.status', $filter]);
            }
        }
        $loans = $loans->asArray()->all();
        $stats = LoanApplications::find()
            ->alias('a')
            ->select(['a.id', 'a.loan_app_enc_id',
                'COUNT(DISTINCT a.loan_app_enc_id) as all_applications',
                'COUNT(CASE WHEN i.status = "0" THEN 1 END) as new_leads',
                'COUNT(CASE WHEN i.status = "1" THEN 1 END) as accepted',
                'COUNT(CASE WHEN i.status = "2" THEN 1 END) as pre_verification',
                'COUNT(CASE WHEN i.status = "3" THEN 1 END) as under_process',
                'COUNT(CASE WHEN i.status = "4" THEN 1 END) as sanctioned',
                'COUNT(CASE WHEN i.status = "5" THEN 1 END) as disbursed',
                'COUNT(CASE WHEN i.status = "10" THEN 1 END) as rejected',
            ])
            ->joinWith(['assignedLoanProviders i' => function ($i) {
                $i->onCondition(['or',
                    ['not', ['i.provider_enc_id' => null]],
                    ['not', ['i.provider_enc_id' => '']]
                ]);
                $i->andWhere(['in', 'i.status', [0, 3, 4, 10]]);
            }], false)
            ->andWhere(['a.status' => 1, 'a.lead_by' => Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->one();

        $documents = LoanDocuments::findAll(['is_deleted' => 0, 'visible_for' => 'Loan']);
        $whatsAppForm = new whatsAppShareForm();

        return $this->render('dsa-dashboard', [
            'loans' => $loans,
            'model' => $model,
            'documents' => $documents,
            'stats' => $stats,
            'whatsAppmodel' => $whatsAppForm,
            'referrer_code' => $referrer_code,
        ]);
    }

    public function actionCandidateLoanDashboard($filter = null)
    {
        $user = Users::findOne(['user_enc_id' => Yii::$app->user->identity->user_enc_id]);
        $referrer_code = $user->getReferrals0()->one()->code;
        $model = new LoanSanctionedForm();
        if (Yii::$app->user->identity->organization_enc_id) {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }

        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $model->documents = Yii::$app->request->post('documents');
            if ($model->updateReport()) {
                return $this->refresh();
            } else {
                return false;
            }
        }

        $loans = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.id', 'a.loan_app_enc_id', 'a.college_course_enc_id', 'a.college_enc_id',
                'a.created_on as apply_date',
                '(CASE
                    WHEN i.status = "0" THEN "New Lead"
                    WHEN i.status = "3" THEN "Under Process"
                    WHEN i.status = "4" THEN "Sanctioned"
                    WHEN i.status = "10" THEN "Reject"
                    ELSE "N/A"
                END) as loan_status',
                'a.applicant_name',
                'a.amount',
                'a.amount_received',
                'a.amount_due',
                'a.scholarship',
                'a.degree',
                'f.course_name',
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
            ->joinWith(['assignedLoanProviders i' => function ($i) {
                $i->joinWith(['providerEnc j']);
                $i->onCondition(['in', 'i.status', [0, 3, 4, 10]]);
            }])
            ->andWhere(['a.created_by' => Yii::$app->user->identity->user_enc_id]);
        if ($filter != null) {
            if ($filter != 'all') {
                $filter = explode(',', $filter);
                $loans->andWhere(['in', 'i.status', $filter]);
            }
        }
        $loans = $loans->asArray()->all();
        $stats = LoanApplications::find()
            ->alias('a')
            ->select(['a.id', 'a.loan_app_enc_id',
                'COUNT(DISTINCT a.loan_app_enc_id) as all_applications',
                'COUNT(CASE WHEN i.status = "0" THEN 1 END) as new_leads',
                'COUNT(CASE WHEN i.status = "1" THEN 1 END) as accepted',
                'COUNT(CASE WHEN i.status = "2" THEN 1 END) as pre_verification',
                'COUNT(CASE WHEN i.status = "3" THEN 1 END) as under_process',
                'COUNT(CASE WHEN i.status = "4" THEN 1 END) as sanctioned',
                'COUNT(CASE WHEN i.status = "5" THEN 1 END) as disbursed',
                'COUNT(CASE WHEN i.status = "10" THEN 1 END) as rejected',
            ])
            ->joinWith(['assignedLoanProviders i' => function ($i) {
//                $i->onCondition(['or',
//                    ['not', ['i.provider_enc_id' => null]],
//                    ['not', ['i.provider_enc_id' => '']]
//                ]);
//                $i->andWhere(['in', 'i.status', [0, 3, 4, 10]]);
            }], false)
            ->andWhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->one();

        $documents = LoanDocuments::findAll(['is_deleted' => 0, 'visible_for' => 'Loan']);
        $whatsAppForm = new whatsAppShareForm();

        return $this->render('candidate-loan-dashboard', [
            'loans' => $loans,
            'model' => $model,
            'documents' => $documents,
            'stats' => $stats,
            'whatsAppmodel' => $whatsAppForm,
            'referrer_code' => $referrer_code,
        ]);
    }

    public function actionChangeStatus()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new LoanSanctionedForm();
            $id = Yii::$app->request->post('id');
            $status = Yii::$app->request->post('status');
            $reconsider = Yii::$app->request->post('reconsider');
            if ($status == 4) {
                return [
                    'status' => 203,
                    'title' => 'Important',
                    'message' => 'Form Submission Required',
                ];
            }
            return $model->updateStatus($id, $status, $reconsider, NULL);
        }
    }

    public function actionAddDocuments()
    {
        $documents = ['Birth Certificate', 'Residence Proof', 'Proof of Identity'];
        foreach ($documents as $doc) {
            $chk = LoanDocuments::findOne(['name' => $doc]);
            if (!$chk) {
                $model = new LoanDocuments();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->document_enc_id = $utilitiesModel->encrypt();
                $model->name = $doc;
                $model->visible_for = 'Loan';
                $model->created_by = Yii::$app->user->identity->user_enc_id;
                $model->created_on = date('Y-m-d H:i:s');
                if (!$model->save()) {
                    return 'not updated';
                }
            }
        }
        return 'updated';
    }

    public function actionCandidateDashboard($id)
    {
        $data = Yii::$app->userData->loanApplication($id, Yii::$app->user->identity->user_enc_id);;
        if (!$data) {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
        return $this->render('candidate-dashboard', [
            'loan_app_id' => $id,
            'data' => $data,
        ]);
    }

    public function actionLoanProfileView()
    {
        return $this->render('loan-profile-view');
    }

    public function actionIndividual()
    {
        return $this->render('individual');
    }

    public function actionEmiDetails($id)
    {
        if (!Yii::$app->user->isGuest) {
            setlocale(LC_MONETARY, 'en_IN');
            $data = LoanSanctionReports::find()
                ->alias('z')
                ->select(['z.report_enc_id', 'z.loan_app_enc_id', 'z.loan_amount', 'z.processing_fee', 'z.rate_of_interest'])
                ->joinWith(['loanEmiStructures a' => function ($a) {
                    $a->addSelect(['a.sanction_report_enc_id', 'a.due_date', 'a.amount', 'a.is_advance']);
                    $a->orderBy(['a.is_advance' => SORT_DESC]);
                }])
                ->joinWith(['createdBy b'])
                ->joinWith(['loanAppEnc c' => function ($c) {
                    $c->addSelect(['c.loan_app_enc_id', 'c.applicant_name', 'c.phone', 'c.email', 'c.amount',
                        'c.loan_type',
                        '(CASE WHEN c.loan_type = "Education Loan" THEN "College Education Loan"
                            WHEN c.loan_type = "School Fee Loan" THEN "School Fee Loan"
                            WHEN c.loan_type = "Personal Loan" THEN "Personal Loan"
                            WHEN c.loan_type = "Teacher Loan" THEN "Teacher Loan"
                            END) as loan_type',
                        'c.created_by']);
                    $c->andWhere(['c.is_deleted' => 0]);
                }])
                ->andWhere(['z.report_enc_id' => $id])
                ->asArray()->one();
            if ($data['loanAppEnc']['created_by'] && $data['loanAppEnc']['created_by'] == Yii::$app->user->identity->user_enc_id) {
                    return $this->render('emi-details', [
                        'data' => $data
                    ]);
            } else {
                throw new HttpException(404, Yii::t('account', 'Page not found.'));
            }
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionLoanDetails()
    {
        $loan_application = LoanApplications::find()
            ->alias('a')
            ->select(['a.loan_app_enc_id', 'a.applicant_name', 'a.amount loan_amount', 'a.loan_type', 'b.payment_token', 'b.education_loan_payment_enc_id', 'a.email', 'a.phone', 'b.payment_amount amount'])
            ->joinWith(['educationLoanPayments b' => function ($b) {
                $b->select(['b.loan_app_enc_id', 'b.payment_status']);
                $b->onCondition(['b.payment_status' => ['captured', 'created', 'waived off']]);
            }])
            ->joinWith(['assignedLoanProviders c' => function ($c) {
                $c->select(['c.assigned_loan_provider_enc_id', 'c.loan_application_enc_id', 'c.status', 'c1.name', '(CASE
                WHEN c1.logo IS NULL OR c1.logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", c1.name, "&size=50&rounded=false&background=", REPLACE(c1.initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory .  Yii::$app->params->upload_directories->organizations->logo . '", c1.logo_location, "/", c1.logo) END
                ) organization_logo']);
                $c->joinWith(['providerEnc c1'],false);
                $c->onCondition(['c.is_deleted'=>0]);
            }])
            ->joinWith(['loanApplicationNotifications e' => function($e){
                $e->select(['e.message','e.loan_application_enc_id','e.created_on']);
            }])
            ->joinWith(['loanSanctionReports d'=>function($d){
                $d->select(['d.report_enc_id','d.loan_app_enc_id','d.loan_amount','d.processing_fee','d.rate_of_interest']);
                $d->joinWith(['loanEmiStructures d1'=>function($d1){
                    $d1->select(['d1.loan_structure_enc_id','d1.sanction_report_enc_id','d1.due_date','d1.amount','d1.is_advance']);
                }]);
            }])
            ->where(['a.is_deleted'=>0,'a.created_by'=>Yii::$app->user->identity->user_enc_id])
            ->groupBy(['a.loan_app_enc_id'])
            ->orderBy(['a.created_on'=>SORT_DESC])
            ->asArray()
            ->all();
        $loan_apps = LoanApplications::find()
            ->select(['loan_app_enc_id','applicant_name','amount'])
            ->where(['is_deleted'=>0,'created_by'=>Yii::$app->user->identity->user_enc_id])
            ->groupBy(['loan_app_enc_id'])
            ->orderBy(['created_on'=>SORT_DESC])
            ->asArray()
            ->all();

//        print_r($loan_application);
//        die();
        return $this->render('loan-details',[
            'applications' => $loan_application,
            'loan_apps' => $loan_apps
        ]);
    }
    public function actionLoanProviderDetail($loan_provider_id){
        $assigned_loan_provider = AssignedLoanProvider::find()
            ->alias('a')
            ->select(['a.assigned_loan_provider_enc_id','a.loan_application_enc_id','a.status','b.name',
                '(CASE
                        WHEN b.logo IS NULL OR b.logo = "" THEN
                        CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") ELSE
                        CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory .  Yii::$app->params->upload_directories->organizations->logo . '", b.logo_location, "/", b.logo) END
                    ) organization_logo',
                'c.loan_type','c.amount'])
            ->joinWith(['providerEnc b'],false)
            ->joinWith(['loanApplicationEnc c'],false)
            ->where(['a.assigned_loan_provider_enc_id'=>$loan_provider_id])
            ->asArray()
            ->one();
        return $this->renderAjax('/widgets/education-loan/loan-detail-individual-dashboard',[
            'loanApplication'=>$assigned_loan_provider,
        ]);
    }
}