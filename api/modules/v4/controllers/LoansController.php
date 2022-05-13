<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\BusinessLoanApplication;
use common\models\LeadsApplications;
use common\models\Utilities;
use api\modules\v4\models\LoanApplication;
use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use yii\filters\VerbFilter;
use Razorpay\Api\Api;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;

class LoansController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'loan-application' => ['POST', 'OPTIONS'],
                'update-payment-status' => ['POST', 'OPTIONS'],
                'update-payment-link-status' => ['POST', 'OPTIONS'],
                'contact-us' => ['POST', 'OPTIONS'],
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

    public function actionLoanApplication()
    {
        $model = new LoanApplication();
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $resposne = $model->save();
                if ($resposne['status']) {
                    return $this->response(201, ['status' => 201, 'data' => $resposne['data']]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'Some Internal Server Error']);
                }
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information', 'error' => $model->getErrors()]);
            }
        } else {
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);
        }
    }

    public function actionUpdatePaymentStatus()
    {
        $params = Yii::$app->request->post();

        if (isset($params['loan_app_id']) && !empty($params['loan_app_id'])) {
            $loan_app_id = $params['loan_app_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_app_id"']);
        }

        if (isset($params['loan_payment_id']) && !empty($params['loan_payment_id'])) {
            $loan_payment_id = $params['loan_payment_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_payment_id"']);
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
            $loan_payments->payment_signature = $params['signature'];
            $loan_payments->updated_by = null;
            $loan_payments->updated_on = date('Y-m-d H:i:s');
            $loan_payments->update();
        }
        return $this->response(200, ['status' => 200, 'message' => 'success']);
    }

    public function actionContactUs()
    {
        $params = Yii::$app->request->post();

        $model = new LeadsApplications();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->application_enc_id = $enc_id = $utilitiesModel->encrypt();
        $model->application_number = date('ymd') . time();
        $model->first_name = $params['first_name'];
        $model->last_name = $params['last_name'];
        $model->student_email = $params['email'];
        $model->student_mobile_number = $params['phone'];
        $model->message = $params['message'];
        $model->source = 'Empower Loans';
        if (!$model->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'Some Internal Server Error']);
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

    }

    public function actionUpdatePaymentLinkStatus()
    {
        $params = Yii::$app->request->post();

        $razorpay_payment_id = $params['razorpay_payment_id'];
        $razorpay_payment_link_id = $params['razorpay_payment_link_id'];
        $razorpay_signature = $params['razorpay_signature'];

        $api_key = Yii::$app->params->razorPay->prod->apiKey;
        $api_secret = Yii::$app->params->razorPay->prod->apiSecret;

        $api = new Api($api_key, $api_secret);

        if ($razorpay_payment_id) {
            try {
                $payment = $api->payment->fetch($razorpay_payment_id);
            } catch (Exception $e) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred, Please Contact The Support Team..']);
            }

            if ($payment) {
                if ($payment->captured == 1) {
                    if ($this->savePaymentStatus($razorpay_payment_id, $payment->status, $razorpay_payment_link_id, $razorpay_signature)) {
                        return $this->response(200, ['status' => 200, 'message' => 'payment successfully captured']);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred, Please Contact The Support Team..']);
                    }
                } else {
                    return $this->response(404, ['status' => 404, 'message' => 'Payment Status Not Found, Please Contact The Support Team..']);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Payment Status Not Found, Please Contact The Support Team..']);
            }
        }

        return $this->response(400, ['status' => 400, 'message' => 'bad request']);

    }

    private function savePaymentStatus($payment_id, $status, $plink_id, $signature)
    {
        $loan_payment = EducationLoanPayments::findOne(['payment_token' => $plink_id]);
        $loan_payment->payment_status = $status;
        $loan_payment->payment_id = $payment_id;
        $loan_payment->payment_signature = $signature;
        if ($loan_payment->save()) {
            return true;
        } else {
            return false;
        }
    }

}