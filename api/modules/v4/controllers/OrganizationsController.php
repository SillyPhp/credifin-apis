<?php

namespace api\modules\v4\controllers;

use common\models\AssignedFinancerLoanType;
use common\models\CertificateTypes;
use common\models\FinancerLoanDocuments;
use common\models\LoanType;
use common\models\OrganizationLocations;
use yii\web\UploadedFile;
use yii\db\Expression;
use common\models\Utilities;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\helpers\Url;
use yii\filters\ContentNegotiator;


class OrganizationsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'add-branch' => ['POST', 'OPTIONS'],
                'get-branches' => ['POST', 'OPTIONS'],
                'update-branch' => ['POST', 'OPTIONS'],
                'remove-branch' => ['POST', 'OPTIONS'],
                'get-loan-types' => ['POST', 'OPTIONS'],
                'update-loan-type' => ['POST', 'OPTIONS'],
                'assigned-loan-types' => ['POST', 'OPTIONS'],
                'get-documents-list' => ['POST', 'OPTIONS'],
                'assign-document' => ['POST', 'OPTIONS'],
                'get-assigned-documents' => ['POST', 'OPTIONS'],
                'remove-assigned-documents-list' => ['POST', 'OPTIONS'],
                'update-assigned-documents' => ['POST', 'OPTIONS'],
                'remove-assigned-document' => ['POST', 'OPTIONS'],
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

    public function actionAddBranch()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['location_name']) || empty($params['address']) || empty($params['city_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "location_name, address, city_id"']);
            }

            $orgLocations = new OrganizationLocations();
            $orgLocations->location_enc_id = Yii::$app->security->generateRandomString(32);
            $orgLocations->organization_enc_id = $user->organization_enc_id;
            $orgLocations->location_name = $params['location_name'];
            $orgLocations->location_for = json_encode(['1']);
            $orgLocations->address = $params['address'];
            $orgLocations->city_enc_id = $params['city_id'];
            $orgLocations->created_by = $user->user_enc_id;
            $orgLocations->created_on = date('Y-m-d H:i:s');
            if (!$orgLocations->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $orgLocations->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateBranch()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();


            if (empty($params['location_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "location_id"']);
            }

            $location = OrganizationLocations::findOne(['location_enc_id' => $params['location_id'], 'is_deleted' => 0]);

            if (!$location) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            (!empty($params['location_name'])) ? $location->location_name = $params['location_name'] : "";
            (!empty($params['city_id'])) ? $location->city_enc_id = $params['city_id'] : "";
            (!empty($params['address'])) ? $location->address = $params['address'] : "";
            (!empty($params['status'])) ? $location->status = $params['status'] : "";
            $location->last_updated_by = $user->user_enc_id;
            $location->last_updated_on = date('Y-m-d H:i:s');
            if (!$location->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $location->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetBranches()
    {
        if ($user = $this->isAuthorized()) {
            $locations = OrganizationLocations::find()
                ->alias('a')
                ->select(['a.location_enc_id', 'a.location_enc_id as id', 'a.location_name', 'a.location_for', 'a.address', 'b.name city', 'CONCAT(a.location_name , " ", b.name) as value', 'b.city_enc_id', 'a.status'])
                ->joinWith(['cityEnc b'], false)
                ->andWhere(['a.is_deleted' => 0, 'a.organization_enc_id' => $user->organization_enc_id])
                ->asArray()
                ->all();

            if ($locations) {
                return $this->response(200, ['status' => 200, 'branches' => $locations]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveBranch()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['location_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "location_id"']);
            }

            $location = OrganizationLocations::findOne(['location_enc_id' => $params['location_id']]);

            if ($location) {
                $location->is_deleted = 1;
                $location->last_updated_by = $user->user_enc_id;
                $location->last_updated_on = date('Y-m-d H:i:s');
                if (!$location->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $location->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetLoanTypes()
    {
        if ($user = $this->isAuthorized()) {
            $assignedLoanTypes = AssignedFinancerLoanType::find()
                ->alias('a')
                ->select(['a.assigned_financer_enc_id', 'a.financer_enc_id', 'a.loan_type_enc_id', 'a.status', 'b.name'])
                ->joinWith(['loanTypeEnc b'], false)
                ->where(['a.financer_enc_id' => $user->user_enc_id, 'a.is_deleted' => 0])
                ->asArray()
                ->all();

            $allLoanTypes = LoanType::find()
                ->select(['name', 'loan_type_enc_id', new Expression('0 as status'),])
                ->asArray()
                ->all();

            foreach ($allLoanTypes as $key => $val) {
                foreach ($assignedLoanTypes as $v) {
                    if ($v['name'] == $val['name']) {
                        $allLoanTypes[$key] = $v;
                    }
                }
            }

            return $this->response(200, ['status' => 200, 'allLoanTypes' => $allLoanTypes]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateLoanType()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['loan_type_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_type_enc_id"']);
            }

            if (empty($params['status'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "status"']);
            }


            $assignedType = AssignedFinancerLoanType::findOne(['financer_enc_id' => $user->user_enc_id, 'loan_type_enc_id' => $params['loan_type_enc_id'], 'is_deleted' => 0]);

            if ($assignedType) {
                $assignedType->status = $params['status'] == 'Active' ? 1 : 0;
                $assignedType->updated_by = $user->user_enc_id;
                $assignedType->updated_on = date('Y-m-d H:i:s');
                if (!$assignedType->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $assignedType->getErrors()]);
                }
            } else {
                $assignedType = new AssignedFinancerLoanType();
                $assignedType->assigned_financer_enc_id = Yii::$app->security->generateRandomString(32);
                $assignedType->financer_enc_id = $user->user_enc_id;
                $assignedType->loan_type_enc_id = $params['loan_type_enc_id'];
                $assignedType->status = $params['status'] == 'Active' ? 1 : 0;
                $assignedType->created_by = $user->user_enc_id;
                $assignedType->created_on = date('Y-m-d H:i:s');
                if (!$assignedType->save()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $assignedType->getErrors()]);
                }
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAssignedLoanTypes()
    {
        if ($user = $this->isAuthorized()) {
            $assignedLoanTypes = AssignedFinancerLoanType::find()
                ->alias('a')
                ->select(['a.assigned_financer_enc_id', 'a.financer_enc_id', 'a.loan_type_enc_id', 'b.name'])
                ->joinWith(['loanTypeEnc b'], false)
                ->where(['a.financer_enc_id' => $user->user_enc_id, 'a.is_deleted' => 0, 'a.status' => 1])
                ->asArray()
                ->all();

            if ($assignedLoanTypes) {
                return $this->response(200, ['status' => 200, 'assignedLoanTypes' => $assignedLoanTypes]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetDocumentsList()
    {
        if ($user = $this->isAuthorized()) {
            $documentsList = CertificateTypes::find()->select(['certificate_type_enc_id value', 'name label'])->asArray()->all();
            return $this->response(200, ['status' => 200, 'documents_list' => $documentsList]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAssignDocument()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['certificate_types']) || empty($params['assigned_financer_loan_type_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "certificate_types, assigned_financer_loan_type_id"']);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($params['certificate_types'] as $key => $c) {

                    if (!empty($c['name'])) {
                        $certificate_id = $this->__getCertificateTypeId($c['name']);

                        if (!$certificate_id) {
                            $transaction->rollback();
                            return $this->response(500, ['status' => 500, 'message' => 'an error occurred while getting certificate type id for "' . $c['name'] . '"']);
                        }

                        $loan_documents = new FinancerLoanDocuments();
                        $utilitiesModel = new \common\models\Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
                        $loan_documents->financer_loan_document_enc_id = $utilitiesModel->encrypt();
                        $loan_documents->assigned_financer_loan_type_id = $params['assigned_financer_loan_type_id'];
                        $loan_documents->certificate_type_enc_id = $certificate_id;
                        $loan_documents->sequence = $key;
                        $loan_documents->created_by = $user->user_enc_id;
                        $loan_documents->created_on = date('Y-m-d H:i:s');
                        if (!$loan_documents->save()) {
                            $transaction->rollback();
                            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_documents->getErrors()]);
                        }
                    }
                }

                $transaction->commit();
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
            } catch (Exception $e) {
                $transaction->rollback();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function __getCertificateTypeId($certificateName)
    {
        $certificate = CertificateTypes::findOne(['name' => $certificateName]);

        if ($certificate) {
            return $certificate->certificate_type_enc_id;
        }

        $certificate = new CertificateTypes();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $certificate->certificate_type_enc_id = $utilitiesModel->encrypt();
        $certificate->name = $certificateName;

        if ($certificate->save()) {
            return $certificate->certificate_type_enc_id;
        }

        return false;
    }

    public function actionGetAssignedDocuments()
    {
        if ($user = $this->isAuthorized()) {

            $certificates = AssignedFinancerLoanType::find()
                ->alias('a')
                ->select(['a.assigned_financer_enc_id', 'a.financer_enc_id', 'a.loan_type_enc_id', 'lt.name loan'])
                ->joinWith(['loanTypeEnc lt'], false)
                ->innerJoinWith(['financerLoanDocuments b' => function ($b) {
                    $b->select(['b.financer_loan_document_enc_id', 'b.assigned_financer_loan_type_id', 'b.certificate_type_enc_id',
                        'b.sequence', 'ct.name certificate_name']);
                    $b->joinWith(['certificateTypeEnc ct'], false);
                    $b->orderBy(['b.sequence' => SORT_ASC]);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.financer_enc_id' => $user->user_enc_id, 'a.is_deleted' => 0])
                ->groupBy(['a.loan_type_enc_id'])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            if ($certificates) {
                return $this->response(200, ['status' => 200, 'certificates' => $certificates]);
            }
            return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionRemoveAssignedDocumentsList() {
        if($user = $this->isAuthorized()){

            $params = Yii::$app->request->post();

            if(empty($params['assigned_financer_enc_id'])){
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "assigned_financer_enc_id"']);
            }

            $removeCertificates = FinancerLoanDocuments::updateAll([
                'is_deleted' => 1,
                'updated_by' => $user->user_enc_id,
                'updated_on' => date('Y-m-d H:i:s'),
            ],[ 'and',
                ['assigned_financer_loan_type_id' => $params['assigned_financer_enc_id']],
                ['created_by' => $user->user_enc_id]
            ]);

            if($removeCertificates){
                return $this->response(200, ['status' => 200, 'message' => 'Delete Successfully']);
            }

            return $this->response(404, ['status'=>404, 'message'=>'Not Found']);
        }else{
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionUpdateAssignedDocuments(){
        if($user = $this->isAuthorized()){
            $params = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if(!empty($params['certificate_types'])){
                    foreach ($params['certificate_types'] as $key => $val){
                        $document = FinancerLoanDocuments::findOne([
                            'certificate_type_enc_id' => $val['certificate_type_enc_id'],
                            'assigned_financer_loan_type_id' => $val['assigned_financer_loan_type_id'],
                            'is_deleted' => 0
                        ]);
                        if($document){
                            $document->sequence = $key;
                            $document->updated_by = $user->user_enc_id;
                            $document->updated_on = date('Y-m-d H:i:s');
                            if(!$document->update()){
                                $transaction->rollBack();
                            }
                        }else{
                            if(!empty($val['name'])){
                                $certificate_id = $this->__getCertificateTypeId($val['name']);

                                if(!$certificate_id){
                                    $transaction->rollback();
                                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred while getting certificate type id for "' . $val['name'] . '"']);
                                }

                                $loan_document = new FinancerLoanDocuments();
                                $utilitiesModel = new \common\models\Utilities();
                                $utilitiesModel->variables['string'] = time() . rand(10, 100000);
                                $loan_document->financer_loan_document_enc_id = $utilitiesModel->encrypt();
                                $loan_document->assigned_financer_loan_type_id = $params['assigned_financer_loan_type_id'];
                                $loan_document->certificate_type_enc_id = $certificate_id;
                                $loan_document->sequence = $key;
                                $loan_document->created_by = $user->user_enc_id;
                                $loan_document->created_on = date('Y-m-d H:i:s');
                                if(!$loan_document->save()){
                                    $transaction->rollback();
                                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_document->getErrors()]);
                                }
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
                }
            }catch (Exception $e){
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getErrors()]);
            }
        }else{
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveAssignedDocument(){
        if($user = $this->isAuthorized()){
            $params = Yii::$app->request->post();

            if(empty($params['financer_loan_document_enc_id'])){
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_document_enc_id"']);
            }

            $document = FinancerLoanDocuments::findOne([
                'financer_loan_document_enc_id' => $params['financer_loan_document_enc_id'],
                'created_by' => $user->user_enc_id
            ]);

            if($document){
                $document->is_deleted = 1;
                $document->updated_by = $user->user_enc_id;
                $document->updated_on = date('Y-m-d H:i:s');
                if(!$document->update()){
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $document->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'Deleted Successfully']);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        }else{
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}