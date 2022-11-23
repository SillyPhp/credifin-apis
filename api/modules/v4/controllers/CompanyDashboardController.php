<?php

namespace api\modules\v4\controllers;

use common\models\AssignedFinancerLoanType;
use common\models\AssignedLoanProvider;
use common\models\AssignedSupervisor;
use common\models\EducationLoanPayments;
use common\models\EsignOrganizationTracking;
use common\models\LoanApplications;
use common\models\LoanSanctionReports;
use common\models\Organizations;
use common\models\Referral;
use common\models\ReferralSignUpTracking;
use common\models\SelectedServices;
use common\models\Users;
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
                }], false)
                ->andWhere(['a.is_deleted' => 0]);

            if ($user->organization_enc_id) {
                $stats->andWhere(['a.lead_by' => $dsa]);
            } else {
//                $stats->andWhere(['a.lead_by' => $user->user_enc_id]);
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


            if ($filter) {
                $loans->andWhere(['in', 'i.status', $filter]);
            }

            if (!empty($params['search_keyword'])) {
                $loans->andWhere([
                    'or',
                    ['like', 'a.applicant_name', $params['search_keyword']],
                    ['like', 'a.loan_type', $params['search_keyword']],
                    ['like', 'a.amount', $params['search_keyword']],
                    ['like', 'a.created_on', $params['search_keyword']]
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
//                    $b->where(['b.provider_enc_id' => $organization_id]);
                }], false)
                ->joinWith(['loanCertificates c' => function ($c) {
                    $c->select(['c.certificate_enc_id', 'c.loan_app_enc_id', 'c.certificate_type_enc_id', 'c.number', 'c1.name',
                        'CASE WHEN c.proof_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->loans->proof, 'https') . '", c.proof_image_location, "/", c.proof_image) ELSE NULL END proof_image',]);
                    $c->joinWith(['certificateTypeEnc c1'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->joinWith(['loanCoApplicants d' => function ($d) {
                    $d->select(['d.loan_co_app_enc_id', 'd.loan_app_enc_id', 'd.name', 'd.email', 'd.phone',
                        'd.relation', 'd.employment_type', 'd.annual_income', 'd.co_applicant_dob', 'd.occupation']);
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
        $employee = ReferralSignUpTracking::find()
            ->alias('a')
            ->select(['a.sign_up_user_enc_id user_enc_id', 'c.username', 'c.email', 'c.phone', 'c.first_name', 'c.last_name', 'c.status', new Expression('"Employee" as user_type')])
            ->joinWith(['referralEnc b'], false)
            ->joinWith(['signUpUserEnc c'], false)
            ->where(['b.organization_enc_id' => $org_id, 'c.is_deleted' => 0, 'a.is_deleted' => 0]);

        if ($params != null && !empty($params['employee_search'])) {
            $employee->andWhere([
                'or',
                ['like', 'CONCAT(c.first_name," ", c.last_name)', $params['employee_search']],
                ['like', 'c.username', $params['employee_search']],
                ['like', 'c.email', $params['employee_search']],
                ['like', 'c.phone', $params['employee_search']],
            ]);
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
                ->select(['a.assigned_financer_enc_id', 'a.financer_enc_id', 'a.loan_type_enc_id', 'a.type', 'b.name loan_type'])
                ->joinWith(['loanTypeEnc b'], false)
                ->joinWith(['assignedFinancerLoanPartners c' => function ($c) {
                    $c->select(['c.assigned_loan_partner_enc_id', 'c.assigned_financer_enc_id', 'c.loan_partner_enc_id',
                        'c.ltv', 'concat(c1.first_name," ",c1.last_name) partner_name']);
                    $c->joinWith(['loanPartnerEnc c1'], false);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->where(['a.is_deleted' => 0, 'a.status' => 1, 'a.financer_enc_id' => Users::findOne(['organization_enc_id' => $detail['organization_enc_id']])->user_enc_id])
                ->andWhere(['<>', 'b.name', 'Vehicle Loan'])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'detail' => $detail]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }


}