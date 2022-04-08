<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\BusinessLoanApplication;
use api\modules\v4\models\LoanApplication;
use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use yii\filters\VerbFilter;
use Yii;

class LoansController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'loan-application' => ['POST'],
                'update-payment-status' => ['POST'],
            ]
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

}