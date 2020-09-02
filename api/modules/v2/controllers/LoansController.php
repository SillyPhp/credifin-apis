<?php

namespace api\modules\v2\controllers;

use api\modules\v2\models\LoanApplicationsForm;
use common\models\AssignedCategories;
use common\models\AssignedCollegeCourses;
use common\models\CertificateTypes;
use common\models\CollegeCourses;
use common\models\CollegeCoursesPool;
use common\models\EducationLoanPayments;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\LoanApplicantResidentialInformation;
use common\models\LoanApplications;
use common\models\LoanCandidateEducation;
use common\models\LoanCertificates;
use common\models\LoanCoApplicants;
use common\models\LoanQualificationType;
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
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

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
                    'a.status',
                    'f.payment_status',
                    'c1.course_name',
                    'a.created_on',
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
                ->where(['cc.organization_enc_id' => $college_id, 'f.payment_status' => ['captured', 'created']])
                ->andWhere(['not', ['a.status' => 2]]);
            if ($limit) {
                $loan_requests->limit($limit)
                    ->offset(($page - 1) * $limit);
            }
            $loan_requests = $loan_requests
                ->orderBy(['a.created_on' => SORT_DESC])
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
                        'a.status',
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
                ->joinWith(['assignedLoanProviders g' => function ($g) {
                    $g->select(['g.assigned_loan_provider_enc_id', 'g.loan_application_enc_id', 'g.status', 'g1.name provider_name']);
                    $g->joinWith(['providerEnc g1'], false);
                    $g->onCondition(['g.is_deleted' => 0]);
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
                ->orderBy(['a.created_on' => SORT_DESC])
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
                $res_info = new LoanApplicantResidentialInformation();
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
                $res_info->city = $params['city_id'];
                $res_info->state = $params['state_id'];
                $res_info->created_by = $user->user_enc_id;
                $res_info->created_on = date('Y-m-d H:i:s');
                if ($res_info->save()) {
                    return $res_info->loan_app_res_info_enc_id;
                } else {
                    print_r($res_info->getErrors());
                    return false;
                }
            } else {
                $update_res_info = LoanApplicantResidentialInformation::find()
                    ->where(['loan_app_res_info_enc_id' => $id])
                    ->one();

                if ($update_res_info) {
                    $update_res_info->residential_type = $params['address_type'];
                    $update_res_info->type = $params['res_type'];
                    $update_res_info->address = $params['address'];
                    $update_res_info->city = $params['city_id'];
                    $update_res_info->state = $params['state_id'];
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

                $education = new LoanCandidateEducation();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $education->loan_candidate_edu_enc_id = $utilitiesModel->encrypt();
                $education->loan_app_enc_id = $params['loan_app_id'];
                $education->qualification_enc_id = $qualification_type->qualification_enc_id;
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

                $education = LoanCandidateEducation::find()
                    ->where(['loan_candidate_edu_enc_id' => $id])
                    ->one();

                $education->qualification_enc_id = $qualification_type->qualification_enc_id;
                $education->institution = $params['institution'];
                $education->obtained_marks = $params['obtained_marks'];
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
                $loan_co_applicants->co_applicant_dob = $params['co_applicant_dob'];
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

                $loan_co_applicants->name = $params['name'];
                $loan_co_applicants->email = $params['email'];
                $loan_co_applicants->phone = $params['phone'];
                $loan_co_applicants->employment_type = $params['employment_type'];
                $loan_co_applicants->annual_income = $params['annual_income'];
                $loan_co_applicants->co_applicant_dob = $params['co_applicant_dob'];
                $loan_co_applicants->years_in_current_house = $params['years_in_current_house'];
                $loan_co_applicants->occupation = $params['occupation'];
                $loan_co_applicants->address = $params['address'];
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


        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function upload($params, $image)
    {
        if (isset($params['loan_co_app_id']) && !empty($params['loan_co_app_id']) && $params['loan_co_app_id'] != '') {
            $co_applicant = LoanCoApplicants::find()
                ->where(['loan_co_app_enc_id' => $params['loan_co_app_id']])
                ->one();

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

}