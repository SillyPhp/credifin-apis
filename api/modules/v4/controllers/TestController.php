<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\LoanApplication;
use common\models\AssignedFinancerLoanType;
use common\models\AssignedLoanProvider;
use common\models\Cities;
use common\models\LoanPayments;
use mPDF;
use common\models\CreditLoanApplicationReports;
use common\models\Designations;
use common\models\extended\LoanApplicationsExtended;
use common\models\FinancerLoanDocuments;
use common\models\FinancerLoanProductDocuments;
use common\models\FinancerLoanProductPurpose;
use common\models\FinancerLoanProducts;
use common\models\FinancerLoanProductStatus;
use common\models\FinancerLoanPurpose;
use common\models\FinancerLoanStatus;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanApplicationOptions;
use common\models\LoanApplications;
use common\models\LoanCoApplicants;
use common\models\OrganizationLocations;
use common\models\OrganizationTypes;
use common\models\spaces\Spaces;
use common\models\SponsoredCourses;
use common\models\States;
use common\models\User;
use common\models\Users;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;
use common\models\Utilities;

class TestController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
//                'employee-stats' => ['GET', 'POST', 'OPTIONS'],
                'generate-pdf' => ['GET', 'POST', 'OPTIONS'],

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

    public function actionLoanApplicationDate()
    {
        if (!$user = $this->isAuthorized()) {
            return 'unauthorised';
        }
        $query = LoanApplications::find()
            ->alias('a')
            ->select(['a.loan_app_enc_id', 'a.created_on'])
            ->where(['a.is_deleted' => 0, 'a.updated_on' => null])
            ->asArray()
            ->all();

        $transaction = Yii::$app->db->beginTransaction();
        foreach ($query as $key => $value) {
            $shift = LoanApplications::findOne(['loan_app_enc_id' => $value['loan_app_enc_id']]);
            $shift->updated_on = $value['created_on'];
            if (!$shift->update()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $shift->getErrors()];
            }
        }
        $transaction->commit();
        return 'success';

    }

    public function actionProductsShift()
    {
        if ($user = $this->isAuthorized()) {
//            $product_save = $this->_productShift($user->user_enc_id);
//            if (!$product_save) {
//                return 'product error';
//            }
            $transaction = Yii::$app->db->beginTransaction();

            // purpose
            $old_purpose = FinancerLoanPurpose::find()
                ->alias('a')
                ->select(['a.financer_loan_purpose_enc_id', 'a.assigned_financer_loan_type_id', 'a.purpose', 'a.sequence', 'a.created_by', 'a.created_on', 'a.updated_by', 'a.updated_on', 'a.is_deleted'])
//                ->joinWith(['assignedFinancerLoanType b' => function ($b) {
//                    $b->joinWith(['organizationEnc b1'], false);
//                }], false)
                ->asArray()
                ->all();
            foreach ($old_purpose as $key => $value) {
                $purpose_product_id = FinancerLoanProducts::findOne(['assigned_financer_loan_type_enc_id' => $value['assigned_financer_loan_type_id']]);
                $check = FinancerLoanProductPurpose::findOne(['financer_loan_product_purpose_enc_id' => $value['financer_loan_purpose_enc_id']]);

                if (!empty($purpose_product_id)) {
                    if (empty($check)) {
                        $new_purpose = new FinancerLoanProductPurpose();
                        $new_purpose->financer_loan_product_purpose_enc_id = $value['financer_loan_purpose_enc_id'];
                        $new_purpose->financer_loan_product_enc_id = $purpose_product_id['financer_loan_product_enc_id'];
                        $new_purpose->purpose = $value['purpose'];
                        $new_purpose->sequence = $value['sequence'];
                        $new_purpose->created_by = $value['created_by'];
                        $new_purpose->created_on = $value['created_on'];
                        $new_purpose->updated_by = $value['updated_by'];
                        $new_purpose->updated_on = $value['updated_on'];
                        $new_purpose->is_deleted = $value['is_deleted'];
                        if (!$new_purpose->save()) {
                            $transaction->rollBack();
                            return ['status' => 500, 'message' => 'an error occurred', 'error' => $new_purpose->getErrors()];
                        }
                    }
                } else {
                    $transaction->rollBack();
                    return 'error while shifting purpose';
                }
            }

            // status
            $old_status = FinancerLoanStatus::find()
                ->alias('a')
                ->select(['a.financer_loan_status_enc_id', 'a.assigned_financer_loan_type_id', 'a.loan_status_enc_id', 'a.created_by', 'a.created_on', 'a.updated_by', 'a.updated_on', 'a.is_deleted'])
//                ->joinWith(['assignedFinancerLoanType b' => function ($b) {
//                    $b->joinWith(['organizationEnc b1'], false);
//                }], false)
                ->asArray()
                ->all();
            foreach ($old_status as $key => $value) {
                $status_product_id = FinancerLoanProducts::findOne(['assigned_financer_loan_type_enc_id' => $value['assigned_financer_loan_type_id']]);
                $check = FinancerLoanProductStatus::findOne(['financer_loan_product_status_enc_id' => $value['financer_loan_status_enc_id']]);

                if (!empty($status_product_id)) {
                    if (empty($check)) {
                        $new_status = new FinancerLoanProductStatus();
                        $new_status->financer_loan_product_status_enc_id = $value['financer_loan_status_enc_id'];
                        $new_status->financer_loan_product_enc_id = $status_product_id['financer_loan_product_enc_id'];
                        $new_status->loan_status_enc_id = $value['loan_status_enc_id'];
                        $new_status->created_by = $value['created_by'];
                        $new_status->created_on = $value['created_on'];
                        $new_status->updated_by = $value['updated_by'];
                        $new_status->updated_on = $value['updated_on'];
                        $new_status->is_deleted = $value['is_deleted'];
                        if (!$new_status->save()) {
                            $transaction->rollBack();
                            return ['status' => 500, 'message' => 'an error occurred', 'error' => $new_status->getErrors()];
                        }
                    }
                } else {
                    $transaction->rollBack();
                    return 'error while shifting status';
                }
            }

            // documents
            $old_documents = FinancerLoanDocuments::find()
                ->alias('a')
                ->select(['a.financer_loan_document_enc_id', 'a.assigned_financer_loan_type_id', 'a.certificate_type_enc_id', 'a.sequence', 'a.created_by', 'a.created_on', 'a.updated_by', 'a.updated_on', 'a.is_deleted'])
//                ->joinWith(['assignedFinancerLoanType b' => function ($b) {
//                    $b->joinWith(['organizationEnc b1'], false);
//                }], false)
                ->asArray()
                ->all();
            foreach ($old_documents as $key => $value) {
                $document_product_id = FinancerLoanProducts::findOne(['assigned_financer_loan_type_enc_id' => $value['assigned_financer_loan_type_id']
                ]);
                $check = FinancerLoanProductDocuments::findOne(['financer_loan_product_document_enc_id' => $value['financer_loan_document_enc_id']]);
                if (!empty($document_product_id)) {
                    if (empty($check)) {
                        $new_document = new FinancerLoanProductDocuments();
                        $new_document->financer_loan_product_document_enc_id = $value['financer_loan_document_enc_id'];
                        $new_document->financer_loan_product_enc_id = $document_product_id['financer_loan_product_enc_id'];
                        $new_document->certificate_type_enc_id = $value['certificate_type_enc_id'];
                        $new_document->sequence = $value['sequence'];
                        $new_document->created_by = $value['created_by'];
                        $new_document->created_on = $value['created_on'];
                        $new_document->updated_by = $value['updated_by'];
                        $new_document->updated_on = $value['updated_on'];
                        $new_document->is_deleted = $value['is_deleted'];
                        if (!$new_document->save()) {
                            $transaction->rollBack();
                            return ['status' => 500, 'message' => 'an error occurred', 'error' => $new_document->getErrors()];
                        }
                    }
                } else {
                    $transaction->rollBack();
                    return 'error while shifting document';
                }
            }

            $transaction->commit();
            return 'Shifted Data Successfully';
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

//    private function _productShift($user_id)
//    {
//        $purpose_loan_ids = FinancerLoanPurpose::find()
//            ->alias('a')
//            ->distinct()
//            ->select(['a.assigned_financer_loan_type_id', 'c.name'])
//            ->joinWith(['assignedFinancerLoanType b' => function ($b) {
//                $b->joinWith(['loanTypeEnc c'], false);
//                $b->joinWith(['organizationEnc d'], false);
//                $b->onCondition(['b.is_deleted' => 0]);
//                $b->groupBy(['b.loan_type_enc_id']);
//            }], false)
//            ->asArray()
//            ->all();
//        $status_loan_ids = FinancerLoanStatus::find()
//            ->alias('a')
//            ->distinct()
//            ->select(['a.assigned_financer_loan_type_id', 'c.name'])
//            ->joinWith(['assignedFinancerLoanType b' => function ($b) {
//                $b->joinWith(['loanTypeEnc c'], false);
//                $b->joinWith(['organizationEnc d'], false);
//                $b->onCondition(['b.is_deleted' => 0]);
//                $b->groupBy(['b.loan_type_enc_id']);
//            }], false)
//            ->asArray()
//            ->all();
//
//        $document_loan_ids = FinancerLoanDocuments::find()
//            ->alias('a')
//            ->distinct()
//            ->select(['a.assigned_financer_loan_type_id', 'c.name'])
//            ->joinWith(['assignedFinancerLoanType b' => function ($b) {
//                $b->joinWith(['loanTypeEnc c'], false);
//                $b->joinWith(['organizationEnc d'], false);
//                $b->onCondition(['b.is_deleted' => 0]);
//                $b->groupBy(['b.loan_type_enc_id']);
//            }], false)
//            ->asArray()
//            ->all();
//
//        $transaction = Yii::$app->db->beginTransaction();
//        $data = [$status_loan_ids, $document_loan_ids, $purpose_loan_ids];
//        $product_save = $this->_checker($data, $user_id);
//
//        if (!$product_save) {
//            $transaction->rollBack();
//            return false;
//        }
//        $transaction->commit();
//        return true;
//
//    }

//    private function _checker($data, $user_id)
//    {
//        foreach ($data as $key) {
//            foreach ($key as $val) {
//                $product_check = FinancerLoanProducts::findOne(['assigned_financer_loan_type_enc_id' => $val['assigned_financer_loan_type_id'], 'is_deleted' => 0]);
//                if (!$product_check) {
//                    $new_product = new FinancerLoanProducts();
//                    $utilitiesModel = new Utilities();
//                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
//                    $new_product->financer_loan_product_enc_id = $utilitiesModel->encrypt();
//                    $new_product->assigned_financer_loan_type_enc_id = $val['assigned_financer_loan_type_id'];
//                    $new_product->name = $val['name'];
//                    $new_product->created_on = date('Y-m-d H:i:s');
//                    $new_product->created_by = $user_id;
//                    $new_product->is_deleted = $val['is_deleted'];
//                    if (!$new_product->save()) {
//                        return false;
//                    }
//                }
//            }
//        }
//        return true;
//    }

    public function actionLoanShift()
    {

        if (!$user = $this->isAuthorized()) {
            return 'unauthorised';
        }

        $query = AssignedFinancerLoanType::find()
            ->alias('a')
            ->select(['a.assigned_financer_enc_id', 'b.name', 'a.is_deleted', 'a.created_by'])
            ->joinWith(['loanTypeEnc b'], false)
            ->asArray()
            ->all();
        $transaction = Yii::$app->db->beginTransaction();

        foreach ($query as $value) {
            $product = FinancerLoanProducts::findOne(['name' => $value['name']]);
            if (!$product) {
                $new_product = new FinancerLoanProducts();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $new_product->financer_loan_product_enc_id = $utilitiesModel->encrypt();
                $new_product->assigned_financer_loan_type_enc_id = $value['assigned_financer_enc_id'];
                $new_product->name = $value['name'];
                $new_product->created_on = date('Y-m-d H:i:s');
                $new_product->updated_on = date('Y-m-d H:i:s');
                $new_product->created_by = $value['created_by'];
                $new_product->updated_by = $value['created_by'];
                $new_product->is_deleted = $value['is_deleted'];
                if (!$new_product->save()) {
                    $transaction->rollback();
                    return 'Error while shifting products';
                }
            }
        }
        $transaction->commit();
        return 'Done';


    }

    public function actionApplicationsShift()
    {
        if ($user = $this->isAuthorized()) {
            $query = LoanApplications::find()
                ->alias('a')
                ->select(['a.loan_app_enc_id', 'a.loan_type'])
                ->where(['a.source' => 'EmpowerFintech', 'a.loan_products_enc_id' => null])
                ->asArray()
                ->all();
            $transaction = Yii::$app->db->beginTransaction();
            foreach ($query as $value) {
                $product = FinancerLoanProducts::findOne(['name' => $value['loan_type']]);
                if (!empty($product)) {
                    $update = Yii::$app->db->createCommand()
                        ->update(LoanApplications::tableName(), ['loan_products_enc_id' => $product['financer_loan_product_enc_id']], ['loan_app_enc_id' => $value['loan_app_enc_id']])
                        ->execute();
                    if (!$update) {
                        $transaction->rollBack();
                        return ['status' => 500, 'message' => 'an error occurred'];
                    }
                }
            }
            $transaction->commit();
            return 'Done';
        }
        return 'unauthorized';
    }

    public function actionGeneratePdf()
    {
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
            $dealer_name = strtoupper($params['dealer_name']);
            $vehicle_name = strtoupper($params['vehicle_name']);
            $brand = strtoupper($params['brand']);
            $model = $params['model'];
            $vehicle_make = strtoupper($params['vehicle_make']);
            $date = $params['date'];
            $loan_type = $params['loan_type'];
            $borrower_name = strtoupper($params['borrower_name']);
            $father_name = $params['father_name'];
            $address = strtoupper($params['address']);
            $bill_name = $params['bill_name'];
            $company_name = $params['company_name'];
            $replace = ['{dealer_name}', '{vehicle_name}', '{address}', '{brand}', '{model}', '{date}', '{borrower_name}', '{father_name}', '{bill_name}', '{company_name}'];
            $data = [$dealer_name, $vehicle_name, $brand, $model, $vehicle_make, $date, $loan_type, $borrower_name, $father_name, $address, $bill_name, $company_name];
//            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [215.9, 355.6]]);
//           // $existingPdfContents = file_get_contents(dirname(dirname(dirname(dirname(__DIR__)))) . '/frontend/views/test/pdfView.php');
//           // $pdf = str_replace($replace, $data, $existingPdfContents);
//            $mpdf->WriteHTML($pdf);
            $base = dirname(dirname(dirname(dirname(__DIR__)))) . "/bin";
            $base2 = dirname(dirname(dirname(dirname(__DIR__)))) . "/assets";
//            $filePath =  $base.'/'. $dealer_name . '.pdf';
//            $mpdf->Output($filePath, 'F');

//            $mpdf->AddPage();
//            $mpdf->Output($dealer_name . '.pdf', 'I');
//            exit;

            $mpdf = new \Mpdf\Mpdf(['tempDir' => $base, 'debug' => true]);
            $mpdf->showImageErrors = true;
            $mpdf->text_input_as_HTML = true;
            $mpdf->allow_charset_conversion = true;
            $mpdf->charset_in = 'UTF-8';

            $page = $mpdf->setSourceFile($base . '/templates/dl_template.pdf');

            for ($i = 1; $i <= ($page); $i++) {
                $mpdf->AddPage();
                $mpdf->SetFont('Arial', 'B', 8);
                if ($i == 1) {
                    $mpdf->WriteFixedPosHTML($dealer_name, 36, 68.7, 40, 80, 'auto');
//                    $mpdf->WriteFixedPosHTML($dealer_name, 36,77,40,80, 'auto');
                    $mpdf->WriteFixedPosHTML($vehicle_name, 78, 86.9, 40, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($borrower_name, 78, 96, 60, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($address, 78, 106, 40, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($date, 126, 124.5, 40, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($loan_type, 126, 134.5, 40, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($brand, 60, 143.5, 40, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($father_name, 126, 143.5, 40, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($address, 96, 152.5, 40, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($vehicle_make, 116, 162.5, 40, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($borrower_name, 80, 172, 60, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($father_name, 156, 172, 60, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($bill_name, 106, 200, 60, 80, 'auto');
                    $mpdf->WriteFixedPosHTML($company_name, 164, 209.5, 60, 80, 'auto');
                }
                $importPage = $mpdf->ImportPage($i);
                $mpdf->UseTemplate($importPage);
            }
            $filename = rand(1000, 100000);
            $filePath = $base2 . '/' . $filename . '.pdf';
//            $mpdf->Output($filePath,'F');
            $mpdf->Output();
//            return 'https://ravinder.eygb.me/assets/'.$filename.'.pdf';
        }
        //  return $this->render('pdfView');
    }


    public function actionGetPaymentList()
    {
        if (Yii::$app->request->isPost) {
            $params = Yii::$app->request->post();
            if (!empty($params['loan_app_enc_id']) && isset($params['loan_app_enc_id'])) {
                $id = $params['loan_app_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $add = LoanPayments::find()
                ->distinct()
                ->select(['loan_app_enc_id', 'payment_status', 'payment_token', 'remarks', 'payment_source'])
                ->andWhere(['loan_app_enc_id' => $params['loan_app_enc_id']])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'data' => $add]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }

//            if ($add === null) {
//                return $this->response(500, ['status' => 500, 'message' => 'An error occurred']);
//            }
//            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);

//        return $this->response(200, ['status' => 200, 'message' => 'success']);
    }

    public function actionUpdatePaymentStatus()
    {
        if ($user = $this->isAuthorized()) {
            try {
                $params = Yii::$app->request->post();
                if (empty($params['loan_id'])) {
                    return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_id"']);
                }

                if (empty($params['status'])) {
                    return $this->response(422, ['status' => 422, 'message' => 'missing information "status"']);
                }

                $update = LoanPayments::findOne(['loan_app_enc_id' => $params['loan_id']]);
                if (!$update) {
                    return $this->response(404, ['status' => 404, 'message' => 'not found with this loan_id']);
                }
                $update->payment_status = $params['status'];
                $update->remarks = $params['remarks'];
                $update->updated_by = $user->user_enc_id;
                $update->updated_on = date('Y-m-d H:i:s');

                if (!$update->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred while updating status', 'error' => $update->getErrors()]);
                }
                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
            } catch (\Exception $e) {
                return $this->response(500, ['status' => 500, 'message' => $e->getMessage()]);
            }
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }
}


//if ($user = $this->isAuthorized())
//{
//try
//{
//$params = Yii::$app->request->post();
//
//
//$update = LoanPayments::findOne(['loan_app_enc_id' => $params['loan_id']]);
//if (!$update)
//{
//return $this->response(404, ['status' => 404, 'message' => 'not found with this loan_id']);
//}
//
//$update->payment_status = $params['status'];
//$update->remarks = $params['remarks'];
//$update->updated_by = $user->user_enc_id;
//$update->updated_on = date('Y-m-d H:i:s');
//
//if (!$update->update()) {
//    return $this->response(500, ['status' => 500, 'message' => 'an error occurred while updating status', 'error' => $update->getErrors()]);
//}
//return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
//} catch
//(\Exception $e) {
//    return ['status' => 500, 'message' => $e->getMessage()];
//}
//        }
//        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
//    }
