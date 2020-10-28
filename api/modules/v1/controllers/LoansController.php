<?php


namespace api\modules\v1\controllers;


use api\modules\v1\models\Candidates;
use api\modules\v2\models\LoanApplicationsForm;
use api\modules\v3\models\OrganizationList;
use common\models\AssignedCollegeCourses;
use common\models\CollegeCoursesPool;
use common\models\Countries;
use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use common\models\LoanTypes;
use common\models\OrganizationFeeComponents;
use common\models\Organizations;
use common\models\UserAccessTokens;
use yii\helpers\Url;
use Yii;
use yii\filters\auth\HttpBearerAuth;

class LoansController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'college-list',
                'college-courses',
                'loan-purpose',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'college-list' => ['POST'],
                'college-courses' => ['POST'],
                'loan-purpose' => ['POST'],
                'save-application' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    private function userId()
    {

        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        return $user->user_enc_id;
    }

    public function actionCollegeList()
    {
        $organizations = Organizations::find()
            ->select([
                'organization_enc_id',
                'b.business_activity',
                'REPLACE(name, "&amp;", "&") as name',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->digitalOcean->organizations->logo, 'https') . '", logo_location, "/", logo) END
                ) organization_logo'
            ])
            ->joinWith(['businessActivityEnc b'], false)
            ->where([
                'is_erexx_registered' => 1,
                'status' => 'Active',
                'is_deleted' => 0,
                'b.business_activity' => ['College', 'School'],
                'has_loan_featured' => 1
            ])
            ->asArray()
            ->all();

        if ($organizations) {
            return $this->response(200, $organizations);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionCollegeCourses()
    {
        $courses = CollegeCoursesPool::find()
            ->select(['course_name'])
            ->where(['status' => 'Approved', 'is_deleted' => 0])
            ->asArray()
            ->all();

        if ($courses) {
            return $this->response(200, $courses);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionLoanPurpose()
    {

        $params = Yii::$app->request->post();

        if (isset($params['college_id']) && !empty($params['college_id'])) {
            $college_id = $params['college_id'];
        } else {
            return $this->response(422, 'missing information');
        }

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
            return $this->response(200, ['fee_components' => $fee_components, 'loan_types' => $loan_types]);
        } else {
            return $this->response(404, 'not found');
        }

    }

    public function actionSaveApplication()
    {
        $params = Yii::$app->request->post();
        $c = $params['college_course_info'];
        unset($params['college_course_info']);
        $params['college_course_info'][0] = $c;
        $params['userID'] = $this->userId();

        if ($params) {
            $organizationObject = new OrganizationList();
            $model = new LoanApplicationsForm();
            if ($params['is_addmission_taken'] == 1) {
                $parser = $organizationObject->conditionParser($params);
                if (!$parser['college_id']) {
                    return $this->response(500, ['status' => 500, 'message' => 'Unable to Get College Information']);
                }
                $parser2 = $organizationObject->conditionCourseParser($parser, $params);
                if (!$parser2['assigned_course_id']) {
                    return $this->response(500, ['status' => 500, 'message' => 'Unable to Get Course Information']);
                }
                $model->college_course_enc_id = $parser2['assigned_course_id'];
            } else {
                $course_name = $course_name = trim($params['college_course_info'][0]['course_text']);
                $model->college_course_enc_id = null;
                $parser['college_id'] = null;
                $parser['is_claim'] = 3;
                $pref = $params['clg_pref'];
            }
//            if (!$parser['college_id']) {
//                return $this->response(500, ['status' => 500, 'message' => 'Unable to Get College Information']);
//            }
//            $parser2 = $organizationObject->conditionCourseParser($parser, $params);
//            if (!$parser2['assigned_course_id']) {
//                return $this->response(500, ['status' => 500, 'message' => 'Unable to Get Course Information']);
//            }
            $orgDate = $params['applicant_dob'];
            $userId = $this->userId();
            if (!$params['is_india']) {
                $model->country_enc_id = $params['country_enc_id'];
            }

            if ($model->load(Yii::$app->request->post(), '')) {
                $model->applicant_dob = date("Y-m-d", strtotime($orgDate));
                $model->college_course_enc_id = $parser2['assigned_course_id'];
                if ($params['loan_purpose']) {
                    $model->purpose = explode(',', $params['loan_purpose']);
                }
                if ($model->validate()) {
                    if ($data = $model->add($params['is_addmission_taken'], $userId, $parser['college_id'], 'Android', $parser['is_claim'], $course_name, $pref)) {
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    }
                    return $this->response(500, ['status' => 500, 'message' => 'Something went wrong...']);
                }
                return $this->response(409, ['status' => 409, $model->getErrors()]);
            }
            return $this->response(422, ['status' => 422, 'message' => 'Modal values not loaded..']);
        }
    }

    public function actionApplicationStatus()
    {

        $userId = $this->userId();
        $status = LoanApplications::find()
            ->where(['created_by' => $userId, 'status' => 0])
            ->one();

        if ($status) {
            return $this->response(409, ['status' => 409, 'data' => $status->status]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }

    }

    public function actionStudentLoans()
    {
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
//            ->innerJoinWith(['pathToClaimOrgLoanApplications cc'], false)
            ->joinWith(['loanPurposes b' => function ($b) {
                $b->select(['b.loan_purpose_enc_id', 'b.fee_component_enc_id', 'b.loan_app_enc_id', 'c.name']);
                $b->joinWith(['feeComponentEnc c'], false);
            }])
            ->joinWith(['educationLoanPayments d'], false)
            ->where(['a.created_by' => $this->userId()])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if ($loans) {
            return $this->response(200, ['status' => 200, 'data' => $loans]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionUpdateLoanApplication()
    {
        $params = Yii::$app->request->post();
        if (isset($params['loan_app_id']) && !empty($params['loan_app_id'])) {
            $loan_app_id = $params['loan_app_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if (isset($params['education_loan_payment_enc_id']) && !empty($params['education_loan_payment_enc_id'])) {
            $loan_payment_id = $params['education_loan_payment_enc_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        if ($params['status'] == 'captured') {
            $loan_application = LoanApplications::find()
                ->where(['loan_app_enc_id' => $loan_app_id])
                ->one();
            if ($loan_application) {
                $loan_application->status = 0;
                $loan_application->updated_by = $this->userId();
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
            $loan_payments->updated_by = $this->userId();
            $loan_payments->updated_on = date('Y-m-d H:i:s');
            $loan_payments->update();
        }

        return $this->response(200, ['status' => 200, 'message' => 'success']);
    }

}