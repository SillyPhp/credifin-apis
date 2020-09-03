<?php
namespace api\modules\v3\controllers;
use api\modules\v2\models\LoanApplicationsForm;
use api\modules\v3\models\Courses;
use api\modules\v3\models\OrganizationList;
use common\models\AssignedCollegeCourses;
use common\models\AssignedLoanProvider;
use common\models\CollegeCourses;
use common\models\CollegeCoursesPool;
use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use common\models\LoanTypes;
use common\models\OrganizationFeeComponents;
use common\models\Organizations;
use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class EducationLoanController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-course-list' => ['POST', 'OPTIONS'],
                'get-fee-components' => ['POST', 'OPTIONS'],
                'save-widget-application' => ['POST', 'OPTIONS'],
                'update-widget-loan-application' => ['POST', 'OPTIONS'],
                'loan-applications' => ['POST', 'OPTIONS'],
                'course-pool-list' => ['GET'],
                'save-application' => ['POST', 'OPTIONS'],
                'retry-payment' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetCourseList()
    {
        $params = Yii::$app->request->post();
        if ($params['id']) {
            $courses = AssignedCollegeCourses::find()
                ->alias('a')
                ->select(['a.assigned_college_enc_id college_course_enc_id', 'b.course_name'])
                ->joinWith(['courseEnc b'], false, 'INNER JOIN')
                ->where(['a.organization_enc_id' => $params['id'], 'a.is_deleted' => 0])
                ->asArray()
                ->all();
            if ($courses) {
                return $this->response(200, ['status' => 200, 'courses' => $courses]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
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
        }else{
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
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
    public function actionCoursePoolList()
    {
        $get = Courses::get();
        if ($get) {
            return $get;
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionSaveApplication()
    {

    }

    public function actionRetryPayment()
    {
        date_default_timezone_set('Asia/Kolkata');
        $params = Yii::$app->request->post();
        $token = $params['token'];
        $gst = $params['gst'];
        $pay_amount = $params['pay_amount'];
        $loan_app_id = $params['loan_app_id'];
        $payment_id = $params['payment_id'];
        $status = $params['status'];
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $loan_payment = new EducationLoanPayments();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $loan_payment->education_loan_payment_enc_id = $utilitiesModel->encrypt();
            $loan_payment->loan_app_enc_id = $loan_app_id;
            $loan_payment->payment_token = $token;
            $loan_payment->payment_amount = $pay_amount;
            $loan_payment->payment_status = $status;
            $loan_payment->payment_id = $payment_id;
            $loan_payment->payment_gst = $gst;
            $loan_payment->created_on = date('Y-m-d H:i:s');
            if ($loan_payment->save()) {
                $transaction->commit();
                return $this->response(200, ['status' => 200, 'message' => 'success']);
            } else {
                print_r($loan_payment->getErrors());
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }

}