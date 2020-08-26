<?php

namespace api\modules\v2\controllers;

use api\modules\v2\models\LoanApplicationsForm;
use common\models\AssignedCategories;
use common\models\AssignedCollegeCourses;
use common\models\CollegeCourses;
use common\models\CollegeCoursesPool;
use common\models\EducationLoanPayments;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\LoanApplications;
use common\models\LoanTypes;
use common\models\OrganizationFeeAmount;
use common\models\OrganizationFeeComponents;
use common\models\OrganizationLoanSchemes;
use common\models\Organizations;
use common\models\UserOtherDetails;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

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
            $college_id = $this->getStudentCollegeId();
            $model = new LoanApplicationsForm();
            if ($model->load(Yii::$app->request->post(), '')) {
                if ($model->validate()) {
                    if ($data = $model->add($user->user_enc_id, $college_id)) {
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
                    'f.payment_status',
                    'c1.course_name',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image',
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
                ->joinWith(['loanPurposes e' => function ($e) {
                    $e->select(['e.loan_purpose_enc_id', 'e.loan_app_enc_id', 'e.fee_component_enc_id', 'e1.name']);
                    $e->joinWith(['feeComponentEnc e1'], false);
                }])
                ->where(['cc.organization_enc_id' => $college_id, 'a.status' => 0, 'f.payment_status' => ['captured', 'created']]);
            if ($limit) {
                $loan_requests->limit($limit)
                    ->offset(($page - 1) * $limit);
            }
            $loan_requests = $loan_requests
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
                        'c1.course_name',
                        'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'
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
                    ->joinWith(['loanPurposes e' => function ($e) {
                        $e->select(['e.loan_purpose_enc_id', 'e.loan_app_enc_id', 'e.fee_component_enc_id', 'e1.name']);
                        $e->joinWith(['feeComponentEnc e1'], false);
                    }])
                    ->where(['cc.organization_enc_id' => $college_id, 'a.status' => 0, 'a.loan_app_enc_id' => $id])
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
                    $i++;
                }
                if ($loan) {
                    if (!$loan['image'] && $loan['image'] == null) {
                        $image = "https://ui-avatars.com/api/?name=" . $l['applicant_name'] . '&size=200&rounded=false&background' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT) . '=&color=ffffff';
                        $loan['image'] = $image;
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
                ->where(['loan_app_enc_id' => $id, 'status' => 0])
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
                return $this->response(404, ['status' => 404, 'message' => 'nor found']);
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

            $loan_types = LoanTypes::find()
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

            $loan_types = LoanTypes::find()
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
                    'a.years',
                    'a.semesters',
                    'a.phone',
                    'a.email',
                    'a.gender',
                    'a.amount',
                    'a.status',
                    'f.payment_status',
                    'c1.course_name',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image',
                ])
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
                ->where(['cc.organization_enc_id' => $college_id]);
            if (isset($params['name']) && !empty($params['name'])) {
                $loan_requests->andWhere(['like', 'a.applicant_name', $params['name']]);
            }
            if (isset($params['college_loan_status']) && !empty($params['college_loan_status'])) {
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
                ->asArray()
                ->all();

            if ($loan_requests) {
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
        Yii::$app->cache->flush();
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

    public function actionUpdateUserCourses()
    {
        $data = UserOtherDetails::find()
            ->where(['not', ['course_enc_id' => NULL]])
            ->asArray()
            ->all();

        if ($data) {
            foreach ($data as $d) {
                $courses = CollegeCourses::find()
                    ->where(['college_course_enc_id' => $d['course_enc_id']])
                    ->asArray()
                    ->one();

                if ($courses) {
                    $pool = CollegeCoursesPool::find()
                        ->where(['course_name' => $courses['course_name']])
                        ->asArray()
                        ->one();

                    if ($pool) {
                        $assigned_courses = AssignedCollegeCourses::find()
                            ->where(['organization_enc_id' => $d['organization_enc_id'], 'course_enc_id' => $pool['course_enc_id']])
                            ->asArray()
                            ->one();

                        if ($assigned_courses) {
                            $user = UserOtherDetails::find()
                                ->where(['user_other_details_enc_id' => $d['user_other_details_enc_id']])
                                ->one();

                            if ($user) {
                                $user->assigned_college_enc_id = $assigned_courses['assigned_college_enc_id'];
                                $user->updated_on = date('Y-m-d H:i:s');
                                if (!$user->update()) {
                                    print_r($user->getErrors());
                                    die();
                                }
                            }
                        }
                    }
                }
            }
            print_r('done');
            die();
        }
    }

}