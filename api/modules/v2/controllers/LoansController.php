<?php

namespace api\modules\v2\controllers;

use api\modules\v2\models\LoanApplicationsForm;
use Aws\S3\S3Client;
use common\models\AssignedCollegeCourses;
use common\models\CertificateTypes;
use common\models\CollegeCoursesPool;
use common\models\EducationLoanPayments;
use common\models\EducationLoanTypes;
use common\models\LeadsApplications;
use common\models\LeadsCollegePreference;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanApplications;
use common\models\LoanCandidateEducation;
use common\models\LoanCertificates;
use common\models\LoanCoApplicants;
use common\models\LoanQualificationType;
use common\models\OrganizationFeeComponents;
use common\models\OrganizationLoanSchemes;
use common\models\UserOtherDetails;
use common\models\Users;
use common\models\Utilities;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;

class LoansController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-fee-components' => ['POST', 'OPTIONS'],
                'save-widget-application' => ['POST', 'OPTIONS'],
                'update-widget-loan-application' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    private function getOrgId()
    {
        if ($user = $this->isAuthorized()) {
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id college_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();
            return $organizations['college_id'];
        } else {
            return $this->response(401);
        }
    }

    private function getStudentCollegeId()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = UserOtherDetails::find()
                ->where(['user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();
            return $college_id['organization_enc_id'];
        }
    }

    public function actionSaveApplicants()
    {
        if ($user = $this->isAuthorized()) {
            $param = Yii::$app->request->post();
            $college_id = $this->getStudentCollegeId();
            $model = new LoanApplicationsForm();
            if ($model->load(Yii::$app->request->post(), '')) {
                if (isset($param['course_name']) && !empty($param['course_name'])) {
                    $id = $this->addCourse($param['course_name'], $user->user_enc_id);
                    if ($id) {
                        $model->college_course_enc_id = $id;
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                } else {
                    return $this->response(422, ['status' => 422, 'message' => 'missing information']);
                }

                if ($model->validate()) {
                    if ($data = $model->add(1, $user->user_enc_id, $college_id)) {
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    }
                    return $this->response(500, ['status' => 500, 'message' => 'Something went wrong...']);
                }
                return $this->response(409, ['status' => 409, $model->getErrors()]);
            }
            return $this->response(422, ['status' => 422, 'message' => 'Modal values not loaded..']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    private function addCourse($course_name, $user_id)
    {
        $college_id = $this->getStudentCollegeId();
        $pool = CollegeCoursesPool::find()
            ->select(['course_enc_id'])
            ->where(['course_name' => $course_name])
            ->asArray()->one();

        if (!empty($pool)) {
            $assignClaim = AssignedCollegeCourses::find()
                ->select(['assigned_college_enc_id'])
                ->where(['organization_enc_id' => $college_id, 'course_enc_id' => $pool['course_enc_id']])
                ->asArray()
                ->one();
            if (!empty($assignClaim)) {
                return $assignClaim['assigned_college_enc_id'];
            } else {
                return $this->saveClaimCourse($college_id, $pool['course_enc_id'], $user_id);
            }
        } else {
            $cousrse_enc_id = $this->saveCourseInPool($course_name, $user_id);
            return $this->saveClaimCourse($college_id, $cousrse_enc_id, $user_id);
        }
    }

    private function saveClaimCourse($colleg_id, $course_id, $user_id)
    {
        $model = new AssignedCollegeCourses();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->assigned_college_enc_id = $utilitiesModel->encrypt();
        $model->course_enc_id = $course_id;
        $model->organization_enc_id = $colleg_id;
        $model->created_on = date('Y-m-d H:i:s');
        $model->created_by = $user_id;
        if ($model->save()) {
            return $model->assigned_college_enc_id;
        } else {
            return false;
        }
    }

    private function saveCourseInPool($course_name, $user_id)
    {
        $model = new CollegeCoursesPool();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->course_enc_id = $utilitiesModel->encrypt();
        $model->course_name = $course_name;
        $model->status = 'Pending';
        $model->created_on = date('Y-m-d H:i:s');
        $model->created_by = $user_id;
        if ($model->save()) {
            return $model->course_enc_id;
        } else {
            return false;
        }
    }

    public function actionSaveWidgetApplication()
    {
        $params = Yii::$app->request->post();
        if ($params['id']) {
            $college_id = $params['id'];
            $orgDate = $params['applicant_dob'];
            $model = new LoanApplicationsForm();
            if ($model->load(Yii::$app->request->post(), '')) {
                $model->applicant_dob = date("Y-m-d", strtotime($orgDate));
                if ($model->validate()) {
                    if ($data = $model->add(null, $college_id, 'CollegeWebsite')) {
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    }
                    return $this->response(500, ['status' => 500, 'message' => 'Something went wrong...']);
                }
                return $this->response(409, ['status' => 409, $model->getErrors()]);
            }
            return $this->response(422, ['status' => 422, 'message' => 'Modal values not loaded..']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionCollegeStudentLoans()
    {
        if ($this->isAuthorized()) {
            $college_id = $this->getOrgId();

            $loan = '';
            $params = Yii::$app->request->post();
            $id = $params['id'];
            $limit = $params['limit'];
            $page = $params['page'];
            if (!$page) {
                $page = 1;
            }


            $loan_requests = LoanApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.loan_app_enc_id',
                    'a.applicant_name',
                    'a.applicant_dob',
                    'a.applicant_current_city',
                    'a.degree',
                    'a.years',
                    'a.semesters',
                    'a.phone',
                    'a.email',
                    'a.gender',
                    'a.amount',
                    'a.amount_received',
                    'a.amount_due',
                    'a.scholarship',
                    'a.status',
                    'a.created_on submitted_date',
                    'a.updated_on verified_date',
                    'f.payment_status',
                    'c1.course_name',
                    'a.created_on',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=",a.applicant_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image',
                ])
                ->innerJoinWith(['pathToClaimOrgLoanApplications c' => function ($c) {
                    $c->joinWith(['createdBy b' => function ($b) {
                        $b->joinWith(['userOtherInfo b1']);
                    }], false);
                    $c->joinWith(['assignedCourseEnc cc' => function ($cc) {
                        $cc->joinWith(['courseEnc c1']);
                    }]);
                }], false)
                ->joinWith(['loanCoApplicants d' => function ($d) {
                    $d->select([
                        'd.loan_co_app_enc_id',
                        'd.loan_app_enc_id',
                        'd.name',
                        'd.relation',
                        'd.employment_type',
                        'd.annual_income'
                    ]);
                }])
                ->joinWith(['educationLoanPayments f'], false)
                ->where(['cc.organization_enc_id' => $college_id, 'f.payment_status' => ['captured', 'created']])
                ->andWhere(['not', ['a.status' => 2]]);
            if ($limit) {
                $loan_requests->limit($limit)
                    ->offset(($page - 1) * $limit);
            }
            $loan_requests = $loan_requests
                ->orderBy(['a.status' => SORT_ASC, 'a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            if ($id) {
                $loan = LoanApplications::find()
                    ->alias('a')
                    ->select([
                        'a.loan_app_enc_id',
                        'a.applicant_name',
                        'a.applicant_dob',
                        'a.applicant_current_city',
                        'a.degree',
                        'a.years',
                        'a.semesters',
                        'a.phone',
                        'a.email',
                        'a.gender',
                        'a.amount',
                        'a.amount_received',
                        'a.amount_due',
                        'a.scholarship',
                        'a.status',
                        'a.created_on submitted_date',
                        'a.updated_on verified_date',
                        'c1.course_name',
                        'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'
                    ])
                    ->innerJoinWith(['pathToClaimOrgLoanApplications c' => function ($c) {
                        $c->joinWith(['createdBy b' => function ($b) {
                            $b->joinWith(['userOtherInfo b1']);
                        }], false);
                        $c->joinWith(['assignedCourseEnc cc' => function ($cc) {
                            $cc->joinWith(['courseEnc c1']);
                        }]);
                    }], false)
                    ->joinWith(['loanCoApplicants d' => function ($d) {
                        $d->select([
                            'd.loan_co_app_enc_id',
                            'd.loan_app_enc_id',
                            'd.name',
                            'd.relation',
                            'd.employment_type',
                            'd.annual_income'
                        ]);
                    }])
                    ->where(['cc.organization_enc_id' => $college_id, 'a.loan_app_enc_id' => $id])
                    ->andWhere(['not', ['a.status' => 2]])
                    ->asArray()
                    ->one();
            }

            if ($loan_requests) {
                $i = 0;
                foreach ($loan_requests as $l) {
                    if (!$l['image'] && $l['image'] == null) {
                        $image = "https://ui-avatars.com/api/?name=" . $l['applicant_name'] . '&size=200&rounded=false&background' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT) . '=&color=ffffff';
                        $loan_requests[$i]['image'] = $image;
                    }
                    if ($l['submitted_date']) {
                        $loan_requests[$i]['submitted_date'] = date('Y-m-d', strtotime($l['submitted_date']));
                    }
                    if ($l['verified_date']) {
                        $loan_requests[$i]['verified_date'] = date('Y-m-d', strtotime($l['verified_date']));
                    }
                    $i++;
                }
                if ($loan) {
                    if (!$loan['image'] && $loan['image'] == null) {
                        $image = "https://ui-avatars.com/api/?name=" . $l['applicant_name'] . '&size=200&rounded=false&background' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT) . '=&color=ffffff';
                        $loan['image'] = $image;
                    }
                    if ($loan['submitted_date']) {
                        $loan['submitted_date'] = date('Y-m-d', strtotime($loan['submitted_date']));
                    }
                    if ($loan['verified_date']) {
                        $loan['verified_date'] = date('Y-m-d', strtotime($loan['verified_date']));
                    }
                    return $this->response(200, ['status' => 200, 'data' => $loan_requests, 'loan_detail' => $loan]);
                } else {
                    return $this->response(200, ['status' => 200, 'data' => $loan_requests]);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionLoanChangeStatus()
    {
        if ($user = $this->isAuthorized()) {
            $param = Yii::$app->request->post();
            if (isset($param['id']) && !empty($param['id'])) {
                $id = $param['id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
            }

            if (isset($param['action']) && !empty($param['action'])) {
                $action = $param['action'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
            }


            $application = LoanApplications::find()
                ->where(['loan_app_enc_id' => $id])
                ->one();

            if ($application) {
                if ($action == 'approve') {
                    $application->amount_received = $param['amount_received'];
                    $application->amount_due = $param['amount_due'];
                    $application->scholarship = $param['scholarship'];
                    $application->status = 1;
                } elseif ($action == "reject") {
                    $application->status = 2;
                }
                $application->updated_by = $user->user_enc_id;
                $application->updated_on = date('Y-m-d H:i:s');
                if ($application->update()) {
                    return $this->response(200, ['status' => 200, 'message' => 'updated']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'en error occurred']);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionFeeComponents()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getStudentCollegeId();

            $fee_components = OrganizationFeeComponents::find()
                ->distinct()
                ->alias('a')
                ->select(['a.fee_component_enc_id', 'a.name'])
                ->joinWith(['assignedOrganizationFeeComponents b'], false)
                ->where(['b.organization_enc_id' => $college_id, 'b.status' => 1, 'b.is_deleted' => 0])
                ->asArray()
                ->all();

            $loan_types = EducationLoanTypes::find()
                ->select(['loan_type_enc_id', 'loan_name'])
                ->asArray()
                ->all();

            if ($fee_components) {
                return $this->response(200, ['status' => 200, 'fee_components' => $fee_components, 'loan_types' => $loan_types]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetFeeComponents()
    {
        $params = Yii::$app->request->post();
        $college_id = $params['id'];
        if ($college_id) {
            $fee_components = OrganizationFeeComponents::find()
                ->distinct()
                ->alias('a')
                ->select(['a.fee_component_enc_id', 'a.name'])
                ->joinWith(['assignedOrganizationFeeComponents b'], false)
                ->where(['b.organization_enc_id' => $college_id, 'b.status' => 1, 'b.is_deleted' => 0])
                ->asArray()
                ->all();

            $loan_types = EducationLoanTypes::find()
                ->select(['loan_type_enc_id', 'loan_name'])
                ->asArray()
                ->all();

            if ($fee_components) {
                return $this->response(200, ['status' => 200, 'fee_components' => $fee_components, 'loan_types' => $loan_types]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionGetMinMax()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getStudentCollegeId();
            $params = Yii::$app->request->post();
            if (isset($params['loan_type_enc_id']) && !empty($params['loan_type_enc_id'])) {
                $loan_type = $params['loan_type_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $org_min_max = OrganizationLoanSchemes::find()
                ->select(['scheme_enc_id', 'min(borrower) min', 'max(borrower) max'])
                ->where(['organization_enc_id' => $college_id, 'loan_type_enc_id' => $loan_type])
                ->asArray()
                ->all();

            if ($org_min_max) {
                return $this->response(200, ['status' => 200, 'data' => $org_min_max]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateLoanApplication()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (isset($params['loan_app_id']) && !empty($params['loan_app_id'])) {
                $loan_app_id = $params['loan_app_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if (isset($params['loan_payment_id']) && !empty($params['loan_payment_id'])) {
                $loan_payment_id = $params['loan_payment_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            if ($params['status'] == 'captured') {
                $loan_application = LoanApplications::find()
                    ->where(['loan_app_enc_id' => $loan_app_id])
                    ->one();
                if ($loan_application) {
                    $loan_application->status = 0;
                    $loan_application->updated_by = $user->user_enc_id;
                    $loan_application->updated_on = date('Y-m-d H:i:s');
                    $loan_application->update();
                }
            }

            $loan_payments = EducationLoanPayments::find()
                ->where(['education_loan_payment_enc_id' => $loan_payment_id])
                ->one();
            if ($loan_payments) {
                $loan_payments->payment_id = $params['payment_id'];
                $loan_payments->payment_status = $params['status'];
                $loan_payments->payment_signature = $params['signature'];
                $loan_payments->updated_by = $user->user_enc_id;
                $loan_payments->updated_on = date('Y-m-d H:i:s');
                $loan_payments->update();
            }

            return $this->response(200, ['status' => 200, 'message' => 'success']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateWidgetLoanApplication()
    {
        $params = Yii::$app->request->post();
        if (isset($params['loan_app_id']) && !empty($params['loan_app_id'])) {
            $loan_app_id = $params['loan_app_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if (isset($params['loan_payment_id']) && !empty($params['loan_payment_id'])) {
            $loan_payment_id = $params['loan_payment_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if ($params['status'] == 'captured') {
            $loan_application = LoanApplications::find()
                ->where(['loan_app_enc_id' => $loan_app_id])
                ->one();
            if ($loan_application) {
                $loan_application->status = 0;
                $loan_application->updated_by = null;
                $loan_application->updated_on = date('Y-m-d H:i:s');
                $loan_application->update();
            }
        }

        $loan_payments = EducationLoanPayments::find()
            ->where(['education_loan_payment_enc_id' => $loan_payment_id])
            ->one();
        if ($loan_payments) {
            $loan_payments->payment_id = (($params['payment_id']) ? $params['payment_id'] : null);
            $loan_payments->payment_status = $params['status'];
            $loan_payments->updated_by = null;
            $loan_payments->updated_on = date('Y-m-d H:i:s');
            $loan_payments->update();
        }
        return $this->response(200, ['status' => 200, 'message' => 'success']);
    }

    public function actionStudentLoans()
    {
        if ($user = $this->isAuthorized()) {
            $loans = LoanApplications::find()
                ->distinct()
                ->alias('a')
                ->select(['a.loan_app_enc_id',
                    'a.applicant_name', 'a.amount loan_amount',
                    'a.status', 'd.payment_token',
                    'd.payment_id', 'd.payment_status',
                    'd.payment_amount application_fees', 'd.payment_gst application_fees_gst',
                    'd.education_loan_payment_enc_id'
                ])
                ->innerJoinWith(['pathToClaimOrgLoanApplications cc'], false)
                ->joinWith(['loanPurposes b' => function ($b) {
                    $b->select(['b.loan_purpose_enc_id', 'b.fee_component_enc_id', 'b.loan_app_enc_id', 'c.name']);
                    $b->joinWith(['feeComponentEnc c'], false);
                }])
                ->joinWith(['educationLoanPayments d'], false)
                ->where(['cc.created_by' => $user->user_enc_id])
                ->asArray()
                ->all();

            if ($loans) {
                return $this->response(200, ['status' => 200, 'data' => $loans]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionApplicationStatus()
    {
        if ($user = $this->isAuthorized()) {
            $status = LoanApplications::find()
                ->where(['created_by' => $user->user_enc_id, 'status' => 0])
                ->one();

            if ($status) {
                return $this->response(200, ['status' => 200, 'data' => $status->status]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionManageLoanApplications()
    {
        if ($this->isAuthorized()) {
            $college_id = $this->getOrgId();

            $params = Yii::$app->request->post();
            $limit = $params['limit'];

            $page = $params['page'];
            if (!$page) {
                $page = 1;
            }

            $loan_requests = LoanApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.loan_app_enc_id',
                    'a.applicant_name',
                    'a.applicant_dob',
                    'a.applicant_current_city',
                    'a.degree',
                    'a.amount_received',
                    'a.amount_due',
                    'a.scholarship',
                    'a.years',
                    'a.semesters',
                    'a.phone',
                    'a.email',
                    'a.gender',
                    'a.amount',
                    'a.status',
                    'f.payment_status',
                    'c1.course_name',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.applicant_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image',
                ])
                ->joinWith(['loanSanctionReports h' => function ($h) {
                    $h->select(['h.report_enc_id', 'h.loan_app_enc_id', 'h.loan_amount']);
                }])
                ->joinWith(['createdBy b' => function ($b) {
                    $b->joinWith(['userOtherInfo b1']);
                }], false)
                ->innerJoinWith(['pathToClaimOrgLoanApplications c' => function ($c) {
                    $c->joinWith(['assignedCourseEnc cc' => function ($cc) {
                        $cc->joinWith(['courseEnc c1']);
                    }]);
                }], false)
                ->joinWith(['loanCoApplicants d' => function ($d) {
                    $d->select([
                        'd.loan_co_app_enc_id',
                        'd.loan_app_enc_id',
                        'd.name',
                        'd.relation',
                        'd.employment_type',
                        'd.annual_income'
                    ]);
                }])
                ->joinWith(['educationLoanPayments f'], false)
                ->joinWith(['loanPurposes e' => function ($e) {
                    $e->select(['e.loan_purpose_enc_id', 'e.loan_app_enc_id', 'e.fee_component_enc_id', 'e1.name']);
                    $e->joinWith(['feeComponentEnc e1'], false);
                }])
                ->joinWith(['assignedLoanProviders g' => function ($g) {
                    $g->select(['g.assigned_loan_provider_enc_id', 'g.loan_application_enc_id', 'g.status', 'g1.name provider_name']);
                    $g->joinWith(['providerEnc g1'], false);
                    $g->onCondition(['g.is_deleted' => 0]);
                }])
                ->where(['cc.organization_enc_id' => $college_id])
                ->andWhere(['in', 'f.payment_status', ['captured', 'created']]);
            if (isset($params['name']) && !empty($params['name'])) {
                $loan_requests->andWhere(['like', 'a.applicant_name', $params['name']]);
            }
            if (isset($params['college_loan_status']) && $params['college_loan_status'] != '') {
                $loan_requests->andWhere(['a.status' => $params['college_loan_status']]);
            }
            if (isset($params['payment_status']) && !empty($params['payment_status'])) {
                $loan_requests->andWhere(['f.payment_status' => $params['payment_status']]);
            }
            if ($limit) {
                $loan_requests->limit($limit)
                    ->offset(($page - 1) * $limit);
            }
            $loan_requests = $loan_requests
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            if ($loan_requests) {
                foreach ($loan_requests as $key => $val) {
                    if ($val['image'] == null) {
                        $image = "https://ui-avatars.com/api/?name=" . $val['applicant_name'] . '&size=200&rounded=false&background' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT) . '=&color=ffffff';
                        $loan_requests[$key]['image'] = $image;
                    }
                }
                return $this->response(200, ['status' => 200, 'data' => $loan_requests]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateAmount()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (!isset($params['loan_app_id']) && empty($params['loan_app_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $loan_app = LoanApplications::find()
                ->where(['loan_app_enc_id' => $params['loan_app_id']])
                ->one();

            $loan_app->amount_received = $params['amount_received'];
            $loan_app->amount_due = $params['amount_due'];
            $loan_app->scholarship = $params['scholarship'];
            $loan_app->updated_by = $user->user_enc_id;
            $loan_app->updated_on = date('Y-m-d H:i:s');

            if ($loan_app->update()) {
                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionLoanSecondForm()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (!isset($params['loan_app_id']) && empty($params['loan_app_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }
            if (!isset($params['type']) && empty($params['type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $type = $params['type'];
            $id = $params['id'];

            if ($type == 'id_proof') {
                $id = $this->saveIdProof($params, $id);
                if ($id) {
                    return $this->response(200, ['status' => 200, 'id' => $id]);
                }
            } elseif ($type == 'address') {
                $id = $this->saveAddress($params, $id);
                if ($id) {
                    return $this->response(200, ['status' => 200, 'id' => $id]);
                }
            } elseif ($type == 'qualification') {
                $id = $this->saveQualification($params, $id);
                if ($id) {
                    return $this->response(200, ['status' => 200, 'id' => $id]);
                }
            } elseif ($type == 'co_applicant') {
                $id = $this->saveCoApplicant($params, $id);
                if ($id) {
                    return $this->response(200, ['status' => 200, 'id' => $id]);
                }
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function saveIdProof($params, $id = null)
    {
        if ($user = $this->isAuthorized()) {

            if ($id != null) {

                $certificate = CertificateTypes::find()
                    ->where(['name' => $params['proof_name']])
                    ->one();

                if (!$certificate) {
                    $certificate = new CertificateTypes();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $certificate->certificate_type_enc_id = $utilitiesModel->encrypt();
                    $certificate->name = $params['proof_name'];
                    if (!$certificate->save()) {
                        print_r($certificate->getErrors());
                        return false;
                    }
                }

                $loan_certificates = LoanCertificates::find()
                    ->where(['certificate_enc_id' => $id])
                    ->one();

                if ($loan_certificates) {
                    $loan_certificates->certificate_type_enc_id = $certificate->certificate_type_enc_id;
                    $loan_certificates->number = $params['number'];
                    $loan_certificates->updated_by = $user->user_enc_id;
                    $loan_certificates->updated_on = date('Y-m-d H:i:s');
                    if ($loan_certificates->update()) {
                        return $loan_certificates->certificate_enc_id;
                    } else {
                        $loan_certificates->getErrors();
                        return false;
                    }
                }

            } else {

                $certificate = CertificateTypes::find()
                    ->where(['name' => $params['proof_name']])
                    ->one();

                if (!$certificate) {
                    $certificate = new CertificateTypes();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $certificate->certificate_type_enc_id = $utilitiesModel->encrypt();
                    $certificate->name = $params['proof_name'];
                    if (!$certificate->save()) {
                        print_r($certificate->getErrors());
                        return false;
                    }
                }

                $loan_certificates = new LoanCertificates();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $loan_certificates->certificate_enc_id = $utilitiesModel->encrypt();
                if (isset($params['loan_co_app_id']) && $params['loan_co_app_id'] != '') {
                    $loan_certificates->loan_co_app_enc_id = $params['loan_co_app_id'];
                } else {
                    $loan_certificates->loan_app_enc_id = $params['loan_app_id'];
                }
                $loan_certificates->certificate_type_enc_id = $certificate->certificate_type_enc_id;
                $loan_certificates->number = $params['number'];
                $loan_certificates->created_by = $user->user_enc_id;
                $loan_certificates->created_on = date('Y-m-d H:i:s');
                if ($loan_certificates->save()) {
                    return $loan_certificates->certificate_enc_id;
                } else {
                    print_r($loan_certificates->getErrors());
                    return false;
                }

            }
        }
    }

    private function saveAddress($params, $id = null)
    {
        if ($user = $this->isAuthorized()) {

            if ($id == null) {
                $res_info = new LoanApplicantResidentialInfo();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $res_info->loan_app_res_info_enc_id = $utilitiesModel->encrypt();
                if (isset($params['loan_co_app_id']) && $params['loan_co_app_id'] != '') {
                    $res_info->loan_co_app_enc_id = $params['loan_co_app_id'];
                } else {
                    $res_info->loan_app_enc_id = $params['loan_app_id'];
                }
                $res_info->residential_type = $params['address_type'];
                $res_info->type = $params['res_type'];
                $res_info->address = $params['address'];
                $res_info->city_enc_id = $params['city_id'];
                $res_info->state_enc_id = $params['state_id'];
                $res_info->created_by = $user->user_enc_id;
                $res_info->created_on = date('Y-m-d H:i:s');
                if ($res_info->save()) {
                    return $res_info->loan_app_res_info_enc_id;
                } else {
                    print_r($res_info->getErrors());
                    return false;
                }
            } else {
                $update_res_info = LoanApplicantResidentialInfo::find()
                    ->where(['loan_app_res_info_enc_id' => $id])
                    ->one();

                if ($update_res_info) {
                    $update_res_info->residential_type = $params['address_type'] ? $params['address_type'] : $update_res_info->residential_type;
                    $update_res_info->type = $params['res_type'] ? $params['res_type'] : $update_res_info->type;
                    $update_res_info->address = $params['address'] ? $params['address'] : $update_res_info->address;
                    $update_res_info->city_enc_id = $params['city_id'] ? $params['city_id'] : $update_res_info->city_enc_id;
                    $update_res_info->state_enc_id = $params['state_id'] ? $params['state_id'] : $update_res_info->state_enc_id;
                    $update_res_info->created_by = $user->user_enc_id;
                    $update_res_info->created_on = date('Y-m-d H:i:s');
                    if ($update_res_info->update()) {
                        return $update_res_info->loan_app_res_info_enc_id;
                    } else {
                        print_r($update_res_info->getErrors());
                        return false;
                    }
                }
            }
        }
    }

    private function saveQualification($params, $id = null)
    {
        if ($user = $this->isAuthorized()) {

            if ($id == null) {

                if (isset($params['name']) && !empty($params['name'])) {
                    $qualification_type = LoanQualificationType::find()
                        ->where(['name' => $params['name']])
                        ->one();

                    if (!$qualification_type) {
                        $qualification_type = new LoanQualificationType();
                        $utilitiesModel = new \common\models\Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $qualification_type->qualification_enc_id = $utilitiesModel->encrypt();
                        $qualification_type->name = $params['name'];
                        if (!$qualification_type->save()) {
                            print_r($qualification_type->getErrors());
                            return false;
                        }
                    }
                }

                $education = new LoanCandidateEducation();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $education->loan_candidate_edu_enc_id = $utilitiesModel->encrypt();
                $education->loan_app_enc_id = $params['loan_app_id'];
                if (isset($params['name']) && !empty($params['name'])) {
                    $education->qualification_enc_id = $qualification_type->qualification_enc_id;
                }
                $education->institution = $params['institution'];
                $education->obtained_marks = $params['obtained_marks'];
                $education->created_by = $user->user_enc_id;
                $education->created_on = date('Y-m-d H:i:s');
                if ($education->save()) {
                    return $education->loan_candidate_edu_enc_id;
                } else {
                    print_r($education->getErrors());
                    return false;
                }

            } else {
                if (isset($params['name']) && !empty($params['name'])) {
                    $qualification_type = LoanQualificationType::find()
                        ->where(['name' => $params['name']])
                        ->one();

                    if (!$qualification_type) {
                        $qualification_type = new LoanQualificationType();
                        $utilitiesModel = new \common\models\Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $qualification_type->qualification_enc_id = $utilitiesModel->encrypt();
                        $qualification_type->name = $params['name'];
                        if (!$qualification_type->save()) {
                            print_r($qualification_type->getErrors());
                            return false;
                        }
                    }
                }

                $education = LoanCandidateEducation::find()
                    ->where(['loan_candidate_edu_enc_id' => $id])
                    ->one();

                if (isset($params['name']) && !empty($params['name'])) {
                    $education->qualification_enc_id = $qualification_type->qualification_enc_id;
                }
                if (isset($params['institution']) && !empty($params['institution'])) {
                    $education->institution = $params['institution'];
                }
                if (isset($params['obtained_marks']) && !empty($params['obtained_marks'])) {
                    $education->obtained_marks = $params['obtained_marks'];
                }
                $education->created_by = $user->user_enc_id;
                $education->created_on = date('Y-m-d H:i:s');
                if ($education->update()) {
                    return $education->loan_candidate_edu_enc_id;
                } else {
                    print_r($education->getErrors());
                    return false;
                }

            }
        }
    }

    private function saveCoApplicant($params, $id = null)
    {
        if ($user = $this->isAuthorized()) {
            if ($id == null) {
                $loan_co_applicants = new LoanCoApplicants();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $loan_co_applicants->loan_co_app_enc_id = $utilitiesModel->encrypt();
                $loan_co_applicants->loan_app_enc_id = $params['loan_app_id'];
                $loan_co_applicants->name = $params['name'];
                $loan_co_applicants->email = $params['email'];
                $loan_co_applicants->phone = $params['phone'];
                $loan_co_applicants->relation = $params['relation'];
                $loan_co_applicants->annual_income = $params['annual_income'];
                $loan_co_applicants->co_applicant_dob = date('Y-m-d', strtotime($params['applicant_dob']));
                $loan_co_applicants->years_in_current_house = $params['years_in_current_house'];
                $loan_co_applicants->occupation = $params['occupation'];
                $loan_co_applicants->address = $params['address'];
                $loan_co_applicants->created_by = $user->user_enc_id;
                $loan_co_applicants->created_on = date('Y-m-d H:i:s');
                if ($loan_co_applicants->save()) {
                    return $loan_co_applicants->loan_co_app_enc_id;
                } else {
                    print_r($loan_co_applicants->getErrors());
                    die();
                }
            } else {
                $loan_co_applicants = LoanCoApplicants::find()
                    ->Where(['loan_co_app_enc_id' => $id])
                    ->one();

                $loan_co_applicants->name = $params['name'] ? $params['name'] : $loan_co_applicants->name;
                $loan_co_applicants->email = $params['email'] ? $params['email'] : $loan_co_applicants->email;
                $loan_co_applicants->phone = $params['phone'] ? $params['phone'] : $loan_co_applicants->phone;
                $loan_co_applicants->employment_type = $params['employment_type'] ? $params['employment_type'] : $loan_co_applicants->employment_type;
                $loan_co_applicants->annual_income = $params['annual_income'] ? $params['annual_income'] : $loan_co_applicants->annual_income;
                $loan_co_applicants->co_applicant_dob = date('Y-m-d', strtotime($params['applicant_dob'])) ? date('Y-m-d', strtotime($params['applicant_dob'])) : $loan_co_applicants->co_applicant_dob;
                $loan_co_applicants->years_in_current_house = $params['years_in_current_house'] ? $params['years_in_current_house'] : $loan_co_applicants->years_in_current_house;
                $loan_co_applicants->occupation = $params['occupation'] ? $params['occupation'] : $loan_co_applicants->occupation;
                $loan_co_applicants->address = $params['address'] ? $params['address'] : $loan_co_applicants->address;
                $loan_co_applicants->updated_by = $user->user_enc_id;
                $loan_co_applicants->updated_on = date('Y-m-d H:i:s');
                if ($loan_co_applicants->update()) {
                    return $loan_co_applicants->loan_co_app_enc_id;
                } else {
                    print_r($loan_co_applicants->getErrors());
                    die();
                }
            }
        }
    }

    public function actionUploadImage()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (!isset($params['loan_app_id']) && empty($params['loan_app_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }
            if (!isset($params['type']) && empty($params['type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $image = UploadedFile::getInstanceByName('image');

            if ($id = $this->upload($params, $image)) {
                return $this->response(200, ['status' => 200, 'id' => $id]);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function upload($user_id, $params, $image)
    {

        if ($params['type'] == 'co_applicant') {

            if (isset($params['loan_co_app_id']) && !empty($params['loan_co_app_id']) && $params['loan_co_app_id'] != '') {
                $co_applicant = LoanCoApplicants::find()
                    ->where(['loan_co_app_enc_id' => $params['loan_co_app_id']])
                    ->one();

                if ($co_applicant) {
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $encrypted_string = $utilitiesModel->encrypt();
                    if (substr($encrypted_string, -1) == '.') {
                        $encrypted_string = substr($encrypted_string, 0, -1);
                    }
                    $co_applicant->image = $encrypted_string . '.' . $image->extension;
                    $co_applicant->image_location = 'loan-proofs-and-profile-images';
                    $co_applicant->updated_by = $user_id;
                    $co_applicant->updated_on = date('Y-m-d H:i:s');
                    if ($co_applicant->update()) {
                        if ($this->uploadFile($co_applicant->image, $image->tempName)) {
                            return $co_applicant->loan_co_app_enc_id;
                        }
                    } else {
                        print_r($co_applicant->getErrors());
                        die();
                    }
                } else {
                    $co_applicant = new LoanCoApplicants();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $co_applicant->loan_co_app_enc_id = $utilitiesModel->encrypt();
                    $co_applicant->loan_app_enc_id = $params['loan_app_id'];
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $encrypted_string = $utilitiesModel->encrypt();
                    if (substr($encrypted_string, -1) == '.') {
                        $encrypted_string = substr($encrypted_string, 0, -1);
                    }
                    $co_applicant->image = $encrypted_string . '.' . $image->extension;
                    $co_applicant->image_location = 'loan-proofs-and-profile-images';
                    $co_applicant->created_by = $user_id;
                    $co_applicant->created_on = date('Y-m-d H:i:s');
                    if ($co_applicant->save()) {
                        if ($this->uploadFile($co_applicant->image, $image->tempName)) {
                            return $co_applicant->loan_co_app_enc_id;
                        }
                    } else {
                        print_r($co_applicant->getErrors());
                    }
                }

            }
        } else if ($params['type'] == 'id_proof') {
            if (isset($params['id']) && !empty($params['id'])) {
                $proof = LoanCertificates::find()
                    ->where(['certificate_enc_id' => $params['id']])
                    ->one();

                if ($proof) {
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $encrypted_string = $utilitiesModel->encrypt();
                    if (substr($encrypted_string, -1) == '.') {
                        $encrypted_string = substr($encrypted_string, 0, -1);
                    }

                    $proof->proof_image = $encrypted_string . '.' . $image->extension;
                    $proof->proof_image_location = 'loan-proofs-and-profile-images';
                    $proof->updated_by = $user_id;
                    $proof->updated_on = date('Y-m-d H:i:s');
                    if ($proof->update()) {
                        if ($this->uploadFile($proof->proof_image, $image->tempName)) {
                            return $proof->certificate_enc_idl;
                        }
                    } else {
                        print_r($proof->getErrors());
                        die();
                    }
                }
            }
        } else if ($params['type'] == 'applicant') {
            $loan_applicant = LoanApplications::find()
                ->where(['loan_app_enc_id' => $params['loan_app_id']])
                ->one();

            if ($loan_applicant) {
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $encrypted_string = $utilitiesModel->encrypt();
                if (substr($encrypted_string, -1) == '.') {
                    $encrypted_string = substr($encrypted_string, 0, -1);
                }
                $loan_applicant->image = $encrypted_string . '.' . $image->extension;
                $loan_applicant->image_location = 'loan-proofs-and-profile-images';
                $loan_applicant->updated_by = $user_id;
                $loan_applicant->updated_on = date('Y-m-d H:i:s');
                if ($loan_applicant->update()) {
                    if ($this->uploadFile($loan_applicant->image, $image->tempName)) {
                        return $loan_applicant->loan_app_enc_id;
                    }
                } else {
                    print_r($loan_applicant->getErrors());
                    die();
                }
            }
        }

    }

    private function uploadFile($file_name, $file)
    {
        $bucketName = 'loan-uploads';
        $access_key = 'AKIATDLKTDI76APKFGXO';
        $secret_key = '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';
        $s3 = new S3Client([
            'region' => 'us-east-1',
            'version' => 'latest',
            'credentials' => [
                'key' => $access_key,
                'secret' => $secret_key,
            ]
        ]);

        $result = $s3->putObject([
            'Bucket' => $bucketName,
            'Key' => 'loan-proofs-and-profile-images/' . $file_name,
            'SourceFile' => $file
        ]);

        if ($result) {
            $s3->putObjectAcl([
                'Bucket' => $bucketName,
                'Key' => 'loan-proofs-and-profile-images/' . $file_name,
                'ACL' => 'public-read'
            ]);
            return true;
        } else {
            return false;
        }
    }

    public function actionCollegeCourses($keyword = null)
    {
        $courses = CollegeCoursesPool::find()
            ->select(['course_name'])
            ->where(['status' => 'Approved', 'is_deleted' => 0])
            ->andWhere(['like', 'course_name', $keyword])
            ->asArray()
            ->all();

        return $courses;

    }

    public function actionAdmissionForm()
    {
        $user_id = null;
        if ($user = $this->isAuthorized()) {
            $user_id = $user->user_enc_id;
        }
        $data = Yii::$app->request->post();
        if (!$data) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }
        if ($data['type'] == 'leadApplication') {
            $model = LeadsApplications::findone(['application_enc_id' => $data['app_enc_id']]);
            if (!$model) {
                $model = new LeadsApplications();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->application_enc_id = $enc_id = $utilitiesModel->encrypt();
                $model->application_number = date('ymd') . time();
                if ($user_id != null) {
                    $model->created_by = $user_id;
                }
            }

            $model->first_name = $data['first_name'] ? $data['first_name'] : $model->first_name;
            $model->last_name = $data['last_name'] ? $data['last_name'] : $model->last_name;
            $model->student_mobile_number = $data['phone'] ? $data['phone'] : $model->student_mobile_number;
            $model->student_email = $data['student_email'] ? $data['student_email'] : $model->student_email;
            $model->loan_for = $data['loan_for'] ? $data['loan_for'] : $model->loan_for;
            $model->admission_taken = $data['admission_taken'] ? $data['admission_taken'] : $model->admission_taken;
            $model->loan_amount = $data['loan_amount'] ? $data['loan_amount'] : $model->loan_amount;
            $model->college_name = $data['college_name'] ? $data['college_name'] : $model->college_name;
            $model->course_name = $data['course_name'] ? $data['course_name'] : $model->course_name;
            if ($user_id != null) {
                $model->last_updated_by = $user_id;
            }
            if ($model->save()) {
                return $this->response(200, ['status' => 200, 'app_enc_id' => $model->application_enc_id]);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
        } elseif ($data['type'] == 'leadCollegePref') {
            $model = LeadsCollegePreference::findone(['application_enc_id' => $data['app_enc_id'], 'sequence' => $data['seq']]);
            if (!$model) {
                $model = new LeadsCollegePreference();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->preference_enc_id = $utilitiesModel->encrypt();
                $model->application_enc_id = $data['app_enc_id'];
                $model->sequence = $data['seq'];
                if ($user_id != null) {
                    $model->created_by = $user_id;
                }
            }
            $model->college_name = $data['college_name'];
            if ($user_id != null) {
                $model->last_updated_by = $user_id;
            }
            if ($model->save()) {
                return $this->response(200, ['status' => 200, 'message' => 'saved']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }
    }

}