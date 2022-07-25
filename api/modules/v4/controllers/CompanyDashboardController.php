<?php

namespace api\modules\v4\controllers;

use common\models\AssignedLoanProvider;
use common\models\AssignedSupervisor;
use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use common\models\LoanSanctionReports;
use common\models\SelectedServices;
use common\models\Users;
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

            $stats = LoanApplications::find()
                ->alias('a')
                ->select([
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
                }], false);

            if ($user->organization_enc_id) {
                $stats->andWhere(['a.lead_by' => $dsa]);
            } else {
                $stats->andWhere(['a.lead_by' => $user->user_enc_id]);
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

            $params = Yii::$app->request->post();

            $filter = null;

            if (isset($params['filter']) && !empty($params['filter'])) {
                $filter = $params['filter'];
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
                }]);

            if ($user->organization_enc_id) {
                if (!$service) {
                    $loans->andWhere(['a.lead_by' => $dsa]);
                }
            } else {
                $loans->andWhere(['a.lead_by' => $user->user_enc_id]);
            }


            if ($filter) {
                $loans->andWhere(['in', 'i.status', $filter]);
            }

            $loans = $loans->asArray()->all();

            if ($loans) {
                foreach ($loans as $key => $val) {
                    if (!$loans['educationLoanPayments']) {
                        $get_amount = EducationLoanPayments::find()->where(['loan_app_enc_id' => $val['loan_app_enc_id']])->one();
                        $loans[$key]['payment_status'] = $get_amount->payment_status;
                    } else {
                        $loans[$key]['payment_status'] = $val[0]['payment_status'];
                    }
                    unset($loans[$key]['educationLoanPayments']);
                }
            }

            return $this->response(200, ['status' => 200, 'loans' => $loans]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
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


            $loan = LoanApplications::find()
                ->alias('a')
                ->select(['a.loan_app_enc_id', 'a.amount', 'a.created_on apply_date',
                    'a.applicant_name', 'a.phone', 'a.email', 'b.status as loan_status', 'a.loan_type'])
                ->joinWith(['assignedLoanProviders b' => function ($b) use ($organization_id) {
                    $b->where(['b.provider_enc_id' => $organization_id]);
                }], false)
                ->joinWith(['loanCertificates c' => function ($c) {
                    $c->select(['c.certificate_enc_id', 'c.loan_app_enc_id', 'c.certificate_type_enc_id', 'c.number', 'c1.name',
                        'CASE WHEN c.proof_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->proof, 'https') . '", c.proof_image_location, "/", c.proof_image) ELSE NULL END proof_image',]);
                    $c->joinWith(['certificateTypeEnc c1'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->joinWith(['loanCoApplicants d' => function ($d) {
                    $d->select(['d.loan_co_app_enc_id', 'd.loan_app_enc_id', 'd.name', 'd.email', 'd.phone',
                        'd.relation', 'd.employment_type', 'd.annual_income','d.co_applicant_dob','d.occupation']);
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
}