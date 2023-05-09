<?php

namespace api\modules\v4\controllers;

use api\modules\v4\utilities\UserUtilities;
use common\models\Cities;
use common\models\Designations;
use common\models\FinancerLoanDocuments;
use common\models\FinancerLoanProductDocuments;
use common\models\FinancerLoanProductPurpose;
use common\models\FinancerLoanProducts;
use common\models\FinancerLoanProductStatus;
use common\models\FinancerLoanPurpose;
use common\models\FinancerLoanStatus;
use common\models\LoanApplicationOptions;
use common\models\LoanApplications;
use common\models\LoanCertificates;
use common\models\LoanCertificatesImages;
use common\models\OrganizationTypes;
use common\models\SelectedServices;
use common\models\spaces\Spaces;
use common\models\SponsoredCourses;
use common\models\States;
use common\models\Users;
use common\models\UserTypes;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;
use common\models\Utilities;

class UtilitiesController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'organization-types' => ['GET', 'OPTIONS'],
                'designations' => ['GET', 'OPTIONS'],
                'states' => ['GET', 'OPTIONS'],
                'cities' => ['GET', 'OPTIONS'],
                'search-cities' => ['GET', 'OPTIONS'],
                'file-upload' => ['POST', 'OPTIONS'],
                'move-data' => ['GET', 'OPTIONS'],
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

    // this action is used to get organization types
    public function actionOrganizationTypes()
    {
        $org_types = OrganizationTypes::find()
            ->select(['organization_type_enc_id', 'organization_type'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'organization_types' => $org_types]);
    }

    // this action is used to search designations
    public function actionDesignations($keyword)
    {
        $designations = Designations::find()
            ->select(['designation_enc_id', 'designation', 'designation_enc_id id', 'designation name'])
            ->where(['is_deleted' => 0])
            ->andFilterWhere(['like', 'designation', $keyword])
            ->limit(10)
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'list' => $designations, 'designations' => $designations]);
    }

    // this action is used to states list default country_enc_id = INDIA
    public function actionStates()
    {
        $states = States::find()
            ->select(['state_enc_id', 'name'])
            ->andWhere(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'states' => $states]);
    }

    // this action is used to get cities list by default state_id = PUNJAB
    public function actionCities($state_id = 'OVlINEg0MGxyRzMydlFrblNTSWExQT09')
    {
        $cities = Cities::find()
            ->select(['city_enc_id', 'name'])
            ->andWhere(['state_enc_id' => $state_id])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'cities' => $cities]);
    }

    // this action is used to search cities default country_enc_id is INDIA
    public function actionSearchCities($keyword)
    {
        $cities = Cities::find()
            ->alias('a')
            ->select(['a.city_enc_id id', 'concat(a.name,", ",b.name) name'])
            ->joinWith(['stateEnc b' => function ($b) {
                $b->joinWith(['countryEnc c'], false);
            }], false)
            ->andWhere(['like', 'a.name', $keyword])
            ->andWhere(['c.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'list' => $cities]);
    }

    // this action is used to upload file for e-sign
    public function actionFileUpload()
    {
        if ($this->isAuthorized()) {
            $file = UploadedFile::getInstanceByName('file');

            $base_path = Yii::$app->params->upload_directories->loans->e_sign . Yii::$app->getSecurity()->generateRandomString() . '/';
            $type = $file->type;
            $file_name = Yii::$app->getSecurity()->generateRandomString() . '.' . 'pdf';

            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($file->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $file_name, "private", ['params' => ['ContentType' => $type]]);
            if ($result['ObjectURL']) {
                return $this->response(200, ['status' => 200, 'path' => Yii::$app->params->digitalOcean->rootDirectory . $base_path . $file_name]);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to shift images from loan certificates to LoanCertificatesImages
    public function actionImageShifter()
    {
        if ($this->isAuthorized()) {
            $query = LoanCertificates::find()
                ->where(['is_deleted' => 0])
                ->andWhere(['IS NOT', 'proof_image', null])
                ->asArray()
                ->all();

            $utilitiesModel = new \common\models\Utilities();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($query as $oldRow) {
                    $newRow = new LoanCertificatesImages();
                    $utilitiesModel->variables['string'] = time() . rand(10, 100000);
                    $newRow->certificate_image_enc_id = $utilitiesModel->encrypt();
                    $newRow->certificate_enc_id = $oldRow['certificate_enc_id'];
                    $newRow->image = $oldRow['proof_image'];
                    $newRow->image_location = $oldRow['proof_image_location'];
                    $newRow->created_by = $oldRow['created_by'];
                    $newRow->created_on = $oldRow['created_on'];
                    if (!$newRow->save()) {
                        $transaction->rollBack();
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $newRow->getErrors()]);
                    }
                }
                $transaction->commit();
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
            } catch (\Exception $exception) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionProductDataShifter()
    {
        if ($user = $this->isAuthorized()) {
            $product_save = $this->_productShift($user->user_enc_id);
            if (!$product_save) {
                return 'product error';
            }

            $transaction = Yii::$app->db->beginTransaction();

            // purpose
            $old_purpose = FinancerLoanPurpose::find()
                ->alias('a')
                ->select(['a.assigned_financer_loan_type_id', 'a.purpose', 'a.sequence', 'a.created_by', 'a.created_on', 'a.updated_by', 'a.updated_on'])
                ->joinWith(['assignedFinancerLoanType b' => function ($b) {
                    $b->joinWith(['organizationEnc b1'], false);
                }], false)
                ->where(['a.is_deleted' => 0, 'b1.slug' => 'phfleasing'])
                ->asArray()
                ->all();
            foreach ($old_purpose as $key => $value) {
                $purpose_product_id = FinancerLoanProducts::findOne(['assigned_financer_loan_type_enc_id' => $value['assigned_financer_loan_type_id'], 'is_deleted' => 0]);
                if (!empty($purpose_product_id)) {
                    $new_purpose = new FinancerLoanProductPurpose();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $new_purpose->financer_loan_product_purpose_enc_id = $utilitiesModel->encrypt();
                    $new_purpose->financer_loan_product_enc_id = $purpose_product_id['financer_loan_product_enc_id'];
                    $new_purpose->purpose = $value['purpose'];
                    $new_purpose->sequence = $value['sequence'];
                    $new_purpose->created_by = $value['created_by'];
                    $new_purpose->created_on = $value['created_on'];
                    $new_purpose->updated_by = $value['updated_by'];
                    $new_purpose->updated_on = $value['updated_on'];
                    if (!$new_purpose->save()) {
                        $transaction->rollBack();
                        return ['status' => 500, 'message' => 'an error occurred', 'error' => $new_purpose->getErrors()];
                    }
                } else {
                    $transaction->rollBack();
                    return 'error while shifting purpose';
                }
            }

            // status
            $old_status = FinancerLoanStatus::find()
                ->alias('a')
                ->select(['a.assigned_financer_loan_type_id', 'a.loan_status_enc_id', 'a.created_by', 'a.created_on', 'a.updated_by', 'a.updated_on'])
                ->joinWith(['assignedFinancerLoanType b' => function ($b) {
                    $b->joinWith(['organizationEnc b1'], false);
                }], false)
                ->where(['a.is_deleted' => 0, 'b1.slug' => 'phfleasing'])
                ->asArray()
                ->all();
            foreach ($old_status as $key => $value) {
                $status_product_id = FinancerLoanProducts::findOne(['assigned_financer_loan_type_enc_id' => $value['assigned_financer_loan_type_id'], 'is_deleted' => 0]);
                if (!empty($status_product_id)) {
                    $new_status = new FinancerLoanProductStatus();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $new_status->financer_loan_product_status_enc_id = $utilitiesModel->encrypt();
                    $new_status->financer_loan_product_enc_id = $status_product_id['financer_loan_product_enc_id'];
                    $new_status->loan_status_enc_id = $value['loan_status_enc_id'];
                    $new_status->created_by = $value['created_by'];
                    $new_status->created_on = $value['created_on'];
                    $new_status->updated_by = $value['updated_by'];
                    $new_status->updated_on = $value['updated_on'];
                    if (!$new_status->save()) {
                        $transaction->rollBack();
                        return ['status' => 500, 'message' => 'an error occurred', 'error' => $new_status->getErrors()];
                    }
                } else {
                    $transaction->rollBack();
                    return 'error while shifting status';
                }
            }

            // documents
            $old_documents = FinancerLoanDocuments::find()
                ->alias('a')
                ->select(['a.assigned_financer_loan_type_id', 'a.certificate_type_enc_id', 'a.sequence', 'a.created_by', 'a.created_on', 'a.updated_by', 'a.updated_on'])
                ->joinWith(['assignedFinancerLoanType b' => function ($b) {
                    $b->joinWith(['organizationEnc b1'], false);
                }], false)
                ->where(['a.is_deleted' => 0, 'b1.slug' => 'phfleasing'])
                ->asArray()
                ->all();
            foreach ($old_documents as $key => $value) {
                $document_product_id = FinancerLoanProducts::findOne(['assigned_financer_loan_type_enc_id' => $value['assigned_financer_loan_type_id'], 'is_deleted' => 0]);
                if (!empty($status_product_id)) {
                    $new_document = new FinancerLoanProductDocuments();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $new_document->financer_loan_product_document_enc_id = $utilitiesModel->encrypt();
                    $new_document->financer_loan_product_enc_id = $document_product_id['financer_loan_product_enc_id'];
                    $new_document->certificate_type_enc_id = $value['certificate_type_enc_id'];
                    $new_document->sequence = $value['sequence'];
                    $new_document->created_by = $value['created_by'];
                    $new_document->created_on = $value['created_on'];
                    $new_document->updated_by = $value['updated_by'];
                    $new_document->updated_on = $value['updated_on'];
                    if (!$new_document->save()) {
                        $transaction->rollBack();
                        return ['status' => 500, 'message' => 'an error occurred', 'error' => $new_document->getErrors()];
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

    private function _productShift($user_id)
    {
        $purpose_loan_ids = FinancerLoanPurpose::find()
            ->alias('a')
            ->distinct()
            ->select(['a.assigned_financer_loan_type_id', 'c.name'])
            ->joinWith(['assignedFinancerLoanType b' => function ($b) {
                $b->joinWith(['loanTypeEnc c'], false);
                $b->joinWith(['organizationEnc d'], false);
                $b->onCondition(['b.is_deleted' => 0]);
                $b->groupBy(['b.loan_type_enc_id']);
            }], false)
            ->where(['a.is_deleted' => 0, 'd.slug' => 'phfleasing'])
            ->asArray()
            ->all();
        $status_loan_ids = FinancerLoanStatus::find()
            ->alias('a')
            ->distinct()
            ->select(['a.assigned_financer_loan_type_id', 'c.name'])
            ->joinWith(['assignedFinancerLoanType b' => function ($b) {
                $b->joinWith(['loanTypeEnc c'], false);
                $b->joinWith(['organizationEnc d'], false);
                $b->onCondition(['b.is_deleted' => 0]);
                $b->groupBy(['b.loan_type_enc_id']);
            }], false)
            ->where(['a.is_deleted' => 0, 'd.slug' => 'phfleasing'])
            ->asArray()
            ->all();

        $document_loan_ids = FinancerLoanDocuments::find()
            ->alias('a')
            ->distinct()
            ->select(['a.assigned_financer_loan_type_id', 'c.name'])
            ->joinWith(['assignedFinancerLoanType b' => function ($b) {
                $b->joinWith(['loanTypeEnc c'], false);
                $b->joinWith(['organizationEnc d'], false);
                $b->onCondition(['b.is_deleted' => 0]);
                $b->groupBy(['b.loan_type_enc_id']);
            }], false)
            ->where(['a.is_deleted' => 0, 'd.slug' => 'phfleasing'])
            ->asArray()
            ->all();

        $transaction = Yii::$app->db->beginTransaction();
        $data = [$status_loan_ids, $purpose_loan_ids, $document_loan_ids];
        $product_save = $this->_checker($data, $user_id);

        if (!$product_save) {
            $transaction->rollBack();
            return false;
        }
        $transaction->commit();
        return true;

    }

    private function _checker($data, $user_id)
    {
        foreach ($data as $key) {
            foreach ($key as $val) {
                $product_check = FinancerLoanProducts::findOne(['assigned_financer_loan_type_enc_id' => $val['assigned_financer_loan_type_id'], 'is_deleted' => 0]);
                if (!$product_check) {
                    $new_product = new FinancerLoanProducts();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $new_product->financer_loan_product_enc_id = $utilitiesModel->encrypt();
                    $new_product->assigned_financer_loan_type_enc_id = $val['assigned_financer_loan_type_id'];
                    $new_product->name = $val['name'];
                    $new_product->created_on = date('Y-m-d H:i:s');
                    $new_product->created_by = $user_id;
                    if (!$new_product->save()) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

}
