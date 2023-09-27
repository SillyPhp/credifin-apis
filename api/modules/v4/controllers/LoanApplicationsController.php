<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\LoanApplication;
use common\models\AssignedLoanProvider;
use common\models\extended\AssignedLoanProviderExtended;
use common\models\extended\LoanApplicationsExtended;
use common\models\extended\LoanPurposeExtended;
use common\models\FinancerLoanProductPurpose;
use common\models\FinancerLoanProducts;
use common\models\LoanApplications;
use common\models\LoanPurpose;
use common\models\Utilities;
use common\models\WebhookTest;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;

class LoanApplicationsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'update-loan-application' => ['POST', 'OPTIONS'],
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

    public function actionUpdateLoanApplication()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing loan_id']);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $loan_id = $params['loan_id'];
            $product_id = $params['product_enc_id'];
            $purposes = $params['purpose'];
            $user_id = $user->user_enc_id;
            $application = LoanApplicationsExtended::findOne(['loan_app_enc_id' => $loan_id]);
            $loan_provider = AssignedLoanProvider::findOne(['loan_application_enc_id' => $loan_id]);
            if (!$loan_provider) {
                $transaction->rollBack();
                throw new \Exception ('an error occurred while fetching loan provider');
            }
            $branch_id = $loan_provider['branch_enc_id'];
            $application->loan_products_enc_id = $product_id;
            $new_application_number = LoanApplication::generateApplicationNumber($product_id, $branch_id, $purposes);
            if (!$new_application_number) {
                throw new \Exception ('error while fetching new application number');
            }
            $application->application_number = $new_application_number;
            $application->updated_on = date('Y-m-d H:i:s');
            $application->updated_by = $user_id;
            if (!$application->save()) {
                $transaction->rollBack();
                throw new \Exception ('an error occurred while updating application');
            }
            $purposeData = $this->purpose($purposes, $user_id, $loan_id);
            if (!$purposeData) {
                $transaction->rollBack();
                throw new \Exception ('an error occurred while updating purposes');
            }
            $status = $this->status($params, $user_id, $loan_id);
            if (!$status) {
                $transaction->rollBack();
                throw new \Exception ('an error occurred while updating status');
            }
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);
        }
    }

    private function purpose($purposes, $user_id, $loan_id)
    {
        LoanPurposeExtended::updateAll(['is_deleted' => 1], ['loan_app_enc_id' => $loan_id]);
        foreach ($purposes as $d) {
            $purpose = new LoanPurposeExtended();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $purpose->loan_purpose_enc_id = $utilitiesModel->encrypt();
            $purpose->financer_loan_purpose_enc_id = $d;
            $purpose->loan_app_enc_id = $loan_id;
            $purpose->created_on = $purpose->updated_on = date('Y-m-d H:i:s');
            $purpose->created_by = $purpose->updated_by = $user_id;
            if (!$purpose->save()) {
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($purpose->errors, 0, false)));
            }
        }
        return true;
    }


    private function status($params, $user_id, $loan_id)
    {
        $status = AssignedLoanProviderExtended::findOne(['loan_application_enc_id' => $loan_id]);

        if ($status) {
            $status->status = $params['status'];
            $status->updated_on = date('Y-m-d H:i:s');
            $status->updated_by = $user_id;

            if (!$status->save()) {
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($status->errors, 0, false)));
            }
        }
        return true;
    }
}

