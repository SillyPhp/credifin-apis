<?php

namespace api\modules\v4\controllers;

use common\models\AssignedDisbursementCharges;
use common\models\AssignedFinancerLoanType;
use common\models\FinancerLoanProductDisbursementCharges;
use common\models\FinancerLoanProductDocuments;
use common\models\FinancerLoanProductImages;
use common\models\FinancerLoanProductLoginFeeStructure;
use common\models\FinancerLoanProductPendencies;
use common\models\FinancerLoanProductProcess;
use common\models\FinancerLoanProductPurpose;
use common\models\FinancerLoanProducts;
use common\models\FinancerLoanProductStatus;
use common\models\Utilities;
use common\models\WebhookTest;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;

class LoanProductsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-loan-product-details' => ['POST', 'OPTIONS'],
                'update-d-charges' => ['POST', 'OPTIONS'],
                'remove-d-charges' => ['POST', 'OPTIONS'],
                'save-assigned-charges' => ['POST', 'OPTIONS'],
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

    public function actionGetLoanProductDetails()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['financer_loan_product_enc_id']) && empty($params['type'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_product_enc_id or type"']);
        }
        $type = $params['type'];
        $query = $this->getLoanProductDetails($params['financer_loan_product_enc_id'], $type);
        if (!$query) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }
        return $this->response(200, ['status' => 200, 'data' => $query]);
    }

    private function getLoanProductDetails($product_id, $type)
    {

        switch ($type) {
            case "purpose":
                $query = FinancerLoanProductPurpose::find()
                    ->alias('a')
                    ->select(['a.financer_loan_product_purpose_enc_id', 'a.purpose_code', 'a.financer_loan_product_enc_id', 'a.purpose', 'a.sequence'])
                    ->orderBy(['a.sequence' => SORT_ASC])
                    ->onCondition(['a.is_deleted' => 0]);
                break;
            case "document":
                $query = FinancerLoanProductDocuments::find()
                    ->alias('a')
                    ->select([
                        'a.financer_loan_product_document_enc_id', 'a.financer_loan_product_enc_id', 'a.certificate_type_enc_id',
                        'a.sequence', 'ct.name'
                    ])
                    ->joinWith(['certificateTypeEnc ct'], false)
                    ->orderBy(['a.sequence' => SORT_ASC])
                    ->onCondition(['a.is_deleted' => 0]);
                break;
            case "status":
                $query = FinancerLoanProductStatus::find()
                    ->alias('a')
                    ->select([
                        'a.financer_loan_product_status_enc_id', 'a.financer_loan_product_enc_id', 'd1.loan_status_enc_id', 'd1.loan_status name',
                        'd1.value', 'd1.sequence'
                    ])
                    ->joinWith(['loanStatusEnc d1'], false)
                    ->onCondition(['a.is_deleted' => 0])
                    ->orderBy(['d1.sequence' => SORT_ASC]);
                break;

            case 4:
                $query = AssignedFinancerLoanType::find()
                    ->alias('a')
                    ->select(['a.assigned_financer_loan_type_enc_id', 'a.name loan_type_name'])
                    ->joinWith(['loanTypeEnc e1'], false);
                break;

            case "process":
                $query = FinancerLoanProductProcess::find()
                    ->alias('a')
                    ->select(['a.financer_loan_product_process_enc_id', 'a.financer_loan_product_enc_id', 'a.process', 'a.sequence'])
                    ->orderBy(['a.sequence' => SORT_ASC])
                    ->onCondition(['a.is_deleted' => 0]);
                break;

            case "fee":
                $query = FinancerLoanProductLoginFeeStructure::find()
                    ->alias('a')
                    ->select(['a.financer_loan_product_login_fee_structure_enc_id', 'a.financer_loan_product_enc_id', 'a.name', 'a.amount'])
                    ->onCondition(['a.is_deleted' => 0]);
                break;

            case "images":
                $query = FinancerLoanProductImages::find()
                    ->alias('a')
                    ->select(['a.product_image_enc_id', 'a.financer_loan_product_enc_id', 'a.name'])
                    ->orderBy(['a.sequence' => SORT_ASC])
                    ->onCondition(['a.is_deleted' => 0]);
                break;

            case "pendencies":
                $query = FinancerLoanProductPendencies::find()
                    ->alias('a')
                    ->select(['a.pendencies_enc_id', 'a.financer_loan_product_enc_id', 'a.name', 'a.type'])
                    ->onCondition(['a.is_deleted' => 0]);
                break;
            case "charges":
                $query = FinancerLoanProductDisbursementCharges::find()
                    ->alias('a')
                    ->select(['a.disbursement_charges_enc_id', 'a.financer_loan_product_enc_id', 'a.name'])
                    ->onCondition(['a.is_deleted' => 0]);
                break;
            default:
                return false;
        }
        $result = $query
            ->andWhere(['a.financer_loan_product_enc_id' => $product_id])
            ->asArray()
            ->all();

        if ($type == 'pendencies' && $result) {
            $result = self::pendency($result);
        }
        if (!empty($result)) {
            return $result;
        } else {
            return null;
        }
    }

    public static function pendency($data)
    {
        $names = ["1" => 'Individual', "2" => 'Company', "3" => 'Property', "4" => 'Miscellaneous'];
        $res = [];
        foreach ($data as $datum) {
            $res[$names[$datum['type']]][] = $datum;
        }
        return $res;
    }

    public function actionUpdateDCharges()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        if (!empty($params['disbursement_charges_enc_id'])) {
            return $query = self::removeDCharges($params['disbursement_charges_enc_id'], $user->user_enc_id);
        }
        if (empty($params['financer_loan_product_enc_id']) || empty($params['charges'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing parameter "financer_loan_product_enc_id or charges"']);
        }
        $product_id = $params['financer_loan_product_enc_id'];
        $transaction = Yii::$app->db->beginTransaction();
        foreach ($params['charges'] as $value) {
            if (empty($value['disbursement_charges_enc_id']) || !$query = self::_chargesCheck($value['disbursement_charges_enc_id'], $product_id)) {
                $query = new FinancerLoanProductDisbursementCharges();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $query->disbursement_charges_enc_id = $utilitiesModel->encrypt();
                $query->financer_loan_product_enc_id = $product_id;
                $query->created_by = $user->user_enc_id;
                $query->created_on = date('Y-m-d H:i:s');
            }
            $query->name = $value['name'];
            $query->updated_by = $user->user_enc_id;
            $query->updated_on = date('Y-m-d H:i:s');
            if (!$query->save()) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $query->getErrors()]);
            }
        }
        $transaction->commit();
        return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
    }

    private function _chargesCheck($charges_id, $product_id)
    {
        $image = FinancerLoanProductDisbursementCharges::findOne([
            'disbursement_charges_enc_id' => $charges_id,
            'financer_loan_product_enc_id' => $product_id,
            'is_deleted' => 0
        ]);
        return $image ?? false;
    }

    public function removeDCharges($id, $user_id)
    {
        $query = FinancerLoanProductDisbursementCharges::findOne([
            'disbursement_charges_enc_id' => $id,
            'is_deleted' => 0
        ]);
        if (!$query) {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
        $query->is_deleted = 1;
        $query->updated_by = $user_id;
        $query->updated_on = date('Y-m-d H:i:s');
        if (!$query->update()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $query->getErrors()]);
        }
        return $this->response(200, ['status' => 200, 'message' => 'Deleted Successfully']);
    }

    public function actionSaveAssignedCharges()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (empty($params['loan_id']) || empty($params['charges']) || !is_array($params['charges'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Invalid input data']);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($params['charges'] as $charge) {
                // Check if the amount is greater than 0
                if ($charge['amount'] < 0) {
                    return $this->response(422, ['status' => 422, 'message' => 'Amount should be greater than 0']);
                }
                // Check if a record with the same charge_id exists
                $existing_record = AssignedDisbursementCharges::findOne([
                    'disbursement_charges_enc_id' => $charge['charge_id'],
                    'loan_app_enc_id' => $params['loan_id'],
                    'is_deleted' => 0,
                ]);

                if ($existing_record) {
                    // Update the existing record's amount
                    $existing_record->amount = $charge['amount'];
                    $existing_record->save();
                } else {
                    // Create a new record
                    $model = new AssignedDisbursementCharges();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $model->assigned_disbursement_charges_enc_id = $utilitiesModel->encrypt();
                    $model->disbursement_charges_enc_id = $charge['charge_id'];
                    $financerCharge = FinancerLoanProductDisbursementCharges::findOne(['disbursement_charges_enc_id' => $charge['charge_id']]);
                    if ($financerCharge !== null) {
                        $model->name = $financerCharge->name;
                    }
                    $model->loan_app_enc_id = $params['loan_id'];
                    $model->amount = $charge['amount'];
                    $model->created_by = $model->updated_by = $user->user_enc_id;
                    $model->created_on = $model->updated_on = date('Y-m-d h:i:s');
                    if (!$model->save()) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()]);
                    }
                }
            }

            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()]);
        }
    }

}