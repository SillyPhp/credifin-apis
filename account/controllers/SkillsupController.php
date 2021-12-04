<?php

namespace account\controllers;

use account\models\loanApplications\LoanSanctionedForm;
use common\models\AssignedLoanProvider;
use common\models\LoanApplicationLogs;
use common\models\LoanApplications;
use common\models\LoanDocuments;
use common\models\Organizations;
use common\models\SelectedServices;
use common\models\Services;
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


class SkillsupController extends Controller
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

    public function actionDashboard($filter = null)
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
        return $this->render('candidate-dashboard', ['loan_app_id' => $id]);
    }

    public function actionLoanProfileView()
    {
        return $this->render('loan-profile-view');
    }
}