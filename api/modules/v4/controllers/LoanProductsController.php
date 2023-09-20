<?php

namespace api\modules\v4\controllers;

use common\models\AssignedFinancerLoanType;
use common\models\FinancerLoanProductDocuments;
use common\models\FinancerLoanProductImages;
use common\models\FinancerLoanProductLoginFeeStructure;
use common\models\FinancerLoanProductPendencies;
use common\models\FinancerLoanProductProcess;
use common\models\FinancerLoanProductPurpose;
use common\models\FinancerLoanProducts;
use common\models\FinancerLoanProductStatus;
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
        $query = $this->getLoanProductPurposes($params['financer_loan_product_enc_id'], $type);
        if (!$query) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }
        return $this->response(200, ['status' => 200, 'data' => $query]);
    }

    private function getLoanProductPurposes($product_id, $type)
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
                        'a.sequence', 'ct.name'])
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
            default:
                return ['status' => 500, 'message' => 'an error occurred', 'error' => 'error "Type is not valid"'];
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

    private function pendency($data)
    {
        $names = ["1" => 'Individual', "2" => 'Company', "3" => 'Property', "4" => 'Miscellaneous'];
        $res = [];
        foreach ($data as $datum) {
            $res[$names[$datum['type']]][] = $datum;
        }
        return $res;
    }
}