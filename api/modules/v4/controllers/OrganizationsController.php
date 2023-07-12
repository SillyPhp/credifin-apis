<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\EmiCollectionForm;
use common\models\EmiCollection;
use common\models\FinancerLoanProductDocuments;
use common\models\FinancerLoanProductPurpose;
use common\models\FinancerLoanProducts;
use common\models\AssignedFinancerLoanType;
use common\models\CertificateTypes;
use common\models\FinancerLoanDocuments;
use common\models\FinancerLoanProductStatus;
use common\models\FinancerLoanPurpose;
use common\models\FinancerLoanStatus;
use common\models\FinancerNoticeBoard;
use common\models\LoanStatus;
use common\models\LoanType;
use common\models\OrganizationLocations;
use common\models\spaces\Spaces;
use common\models\UserAccessTokens;
use common\models\UserRoles;
use common\models\UserTypes;
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
                'add-purpose' => ['POST', 'OPTIONS'],
                'get-purpose-list' => ['POST', 'OPTIONS'],
                'remove-purpose-list' => ['POST', 'OPTIONS'],
                'update-purpose-list' => ['POST', 'OPTIONS'],
                'remove-purpose' => ['POST', 'OPTIONS'],
                'loan-status' => ['POST', 'OPTIONS'],
                'assign-loan-status' => ['POST', 'OPTIONS'],
                'loan-status-list' => ['POST', 'OPTIONS'],
                'remove-status-list' => ['POST', 'OPTIONS'],
                'remove-status' => ['POST', 'OPTIONS'],
                'update-status-list' => ['POST', 'OPTIONS'],
                'delete-emi' => ['POST', 'OPTIONS'],
                'emi-list' => ['POST', 'OPTIONS'],
                'add-notice' => ['POST', 'OPTIONS'],
                'get-notice' => ['POST', 'OPTIONS'],
                'update-notice' => ['POST', 'OPTIONS']
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

    // this action is used to add branch to financer
    public function actionAddBranch()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking location_name, address, city_id
            if (empty($params['location_name']) || empty($params['address']) || empty($params['city_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "location_name, address, city_id"']);
            }

            // adding branch
            $orgLocations = new OrganizationLocations();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $orgLocations->location_enc_id = $utilitiesModel->encrypt();
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

    // this action is used to update branch
    public function actionUpdateBranch()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking location_id
            if (empty($params['location_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "location_id"']);
            }

            // getting locations object with location_id
            $location = OrganizationLocations::findOne(['location_enc_id' => $params['location_id'], 'is_deleted' => 0]);

            // if not found
            if (!$location) {
                return $this->response(404, ['status' => 404, 'message' => 'branch not found']);
            }

            // updating data
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

    // getting list of branches
    public function actionGetBranches()
    {
        if ($user = $this->isAuthorized()) {
            // default org of user
            $org = $user->organization_enc_id;
            $user_type = UserTypes::findOne(['user_type_enc_id' => $user->user_type_enc_id])['user_type'];
            if ($user_type == 'Dealer') {
                $user_role = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
                if (!empty($user_role['organization_enc_id'])) {
                    // if user_type = dealer, then org id is from UserRoles
                    $org = $user_role['organization_enc_id'];
                }
            }
            if (!$org) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            $locations = OrganizationLocations::find()
                ->alias('a')
                ->select(['a.location_enc_id', 'a.location_enc_id as id', 'a.location_name', 'a.location_for', 'a.address', 'b.name city', 'CONCAT(a.location_name , ", ", b.name) as value', 'b.city_enc_id', 'a.status'])
                ->joinWith(['cityEnc b'], false)
                ->andWhere(['a.is_deleted' => 0, 'a.organization_enc_id' => $org])
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
                ->select(['a.assigned_financer_enc_id', 'a.organization_enc_id', 'a.loan_type_enc_id', 'a.status', 'b.name'])
                ->joinWith(['loanTypeEnc b'], false)
                ->where(['a.organization_enc_id' => $user->organization_enc_id, 'a.is_deleted' => 0])
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


            $assignedType = AssignedFinancerLoanType::findOne(['organization_enc_id' => $user->organization_enc_id, 'loan_type_enc_id' => $params['loan_type_enc_id'], 'is_deleted' => 0]);

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
                $assignedType->organization_enc_id = $user->organization_enc_id;
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
            $provider_id = $this->getFinancerId($user);

            $assignedLoanTypes = AssignedFinancerLoanType::find()
                ->alias('a')
                ->select(['a.assigned_financer_enc_id', 'a.organization_enc_id', 'a.loan_type_enc_id', 'b.name'])
                ->joinWith(['loanTypeEnc b'], false)
                ->where(['a.organization_enc_id' => $provider_id, 'a.is_deleted' => 0, 'a.status' => 1])
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
            $lender = $this->getFinancerId($user);
            if (!$lender) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
            $certificates = AssignedFinancerLoanType::find()
                ->alias('a')
                ->select(['a.assigned_financer_enc_id', 'a.organization_enc_id', 'a.loan_type_enc_id', 'lt.name loan'])
                ->joinWith(['loanTypeEnc lt'], false)
                ->innerJoinWith(['financerLoanDocuments b' => function ($b) {
                    $b->select(['b.financer_loan_document_enc_id', 'b.assigned_financer_loan_type_id', 'b.certificate_type_enc_id',
                        'b.sequence', 'ct.name certificate_name']);
                    $b->joinWith(['certificateTypeEnc ct'], false);
                    $b->orderBy(['b.sequence' => SORT_ASC]);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $lender, 'a.is_deleted' => 0])
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

    public function actionRemoveAssignedDocumentsList()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['assigned_financer_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "assigned_financer_enc_id"']);
            }

            $removeCertificates = FinancerLoanDocuments::updateAll([
                'is_deleted' => 1,
                'updated_by' => $user->user_enc_id,
                'updated_on' => date('Y-m-d H:i:s'),
            ], ['and',
                ['assigned_financer_loan_type_id' => $params['assigned_financer_enc_id']],
            ]);

            if ($removeCertificates) {
                return $this->response(200, ['status' => 200, 'message' => 'Delete Successfully']);
            }

            return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionUpdateAssignedDocuments()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!empty($params['certificate_types'])) {
                    foreach ($params['certificate_types'] as $key => $val) {
                        $document = FinancerLoanDocuments::findOne([
                            'certificate_type_enc_id' => $val['certificate_type_enc_id'],
                            'assigned_financer_loan_type_id' => $val['assigned_financer_loan_type_id'],
                            'is_deleted' => 0
                        ]);
                        if ($document) {
                            $document->sequence = $key;
                            $document->updated_by = $user->user_enc_id;
                            $document->updated_on = date('Y-m-d H:i:s');
                            if (!$document->update()) {
                                $transaction->rollBack();
                            }
                        } else {
                            if (!empty($val['name'])) {
                                $certificate_id = $this->__getCertificateTypeId($val['name']);

                                if (!$certificate_id) {
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
                                if (!$loan_document->save()) {
                                    $transaction->rollback();
                                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_document->getErrors()]);
                                }
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getErrors()]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveAssignedDocument()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['financer_loan_document_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_document_enc_id"']);
            }

            $document = FinancerLoanDocuments::findOne([
                'financer_loan_document_enc_id' => $params['financer_loan_document_enc_id'],
            ]);

            if ($document) {
                $document->is_deleted = 1;
                $document->updated_by = $user->user_enc_id;
                $document->updated_on = date('Y-m-d H:i:s');
                if (!$document->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $document->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'Deleted Successfully']);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddPurpose()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['assigned_financer_loan_type_id']) || empty($params['loan_purpose'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "assigned_financer_loan_type_id" or "loan_purpose"']);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($params['loan_purpose'] as $key => $val) {
                    $purpose = new FinancerLoanPurpose();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(10, 100000);
                    $purpose->financer_loan_purpose_enc_id = $utilitiesModel->encrypt();
                    $purpose->assigned_financer_loan_type_id = $params['assigned_financer_loan_type_id'];
                    $purpose->purpose = $val['purpose'];
                    $purpose->sequence = $key;
                    $purpose->created_by = $user->user_enc_id;
                    $purpose->created_on = date('Y-m-d H:i:s');
                    if (!$purpose->save()) {
                        return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $purpose->getErrors()]);
                    }
                }

                $transaction->commit();
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
            } catch (\Exception $e) {
                $transaction->rollback();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);

            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionGetPurposeList()
    {
        if ($user = $this->isAuthorized()) {

            $lender = $this->getFinancerId($user);
            if (!$lender) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            $purpose = AssignedFinancerLoanType::find()
                ->alias('a')
                ->select(['a.assigned_financer_enc_id', 'a.organization_enc_id', 'a.loan_type_enc_id', 'lt.name loan'])
                ->joinWith(['loanTypeEnc lt'], false)
                ->innerJoinWith(['financerLoanPurposes b' => function ($b) {
                    $b->select(['b.financer_loan_purpose_enc_id', 'b.assigned_financer_loan_type_id', 'b.purpose', 'b.sequence']);
                    $b->orderBy(['b.sequence' => SORT_ASC]);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $lender])
                ->groupBy(['a.loan_type_enc_id'])
                ->orderBy(['a.created_by' => SORT_DESC])
                ->asArray()
                ->all();

            if ($purpose) {
                return $this->response(200, ['status' => 200, 'purpose' => $purpose]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'Unauthorized']);
        }
    }

    public function actionRemovePurposeList()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['assigned_financer_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "assigned_financer_enc_id"']);
            }

            $purpose = FinancerLoanPurpose::updateAll([
                'is_deleted' => 1,
                'updated_by' => $user->user_enc_id,
                'updated_on' => date('Y-m-d H:i:s')
            ], [
                'assigned_financer_loan_type_id' => $params['assigned_financer_enc_id']
            ]);

            if ($purpose) {
                return $this->response(200, ['status' => 200, 'message' => 'Delete Successfully']);
            }

            return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionUpdatePurposeList()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!empty($params['loan_purpose'])) {
                    foreach ($params['loan_purpose'] as $key => $val) {
                        $purpose = FinancerLoanPurpose::findOne([
                            'financer_loan_purpose_enc_id' => $val['financer_loan_purpose_enc_id'],
                            'is_deleted' => 0
                        ]);

                        if ($purpose) {
                            $purpose->sequence = $key;
                            $purpose->purpose = $val['purpose'];
                            $purpose->updated_by = $user->user_enc_id;
                            $purpose->updated_on = date('Y-m-d H:i:s');
                            if (!$purpose->update()) {
                                $transaction->rollBack();
                            }
                        } else {
                            if (!empty($val['purpose'])) {
                                $purpose = new FinancerLoanPurpose();
                                $utilitiesModel = new \common\models\Utilities();
                                $utilitiesModel->variables['string'] = time() . rand(10, 100000);
                                $purpose->financer_loan_purpose_enc_id = $utilitiesModel->encrypt();
                                $purpose->assigned_financer_loan_type_id = $params['assigned_financer_loan_type_id'];
                                $purpose->purpose = $val['purpose'];
                                $purpose->sequence = $key;
                                $purpose->created_by = $user->user_enc_id;
                                $purpose->created_on = date('Y-m-d H:i:s');
                                if (!$purpose->save()) {
                                    $transaction->rollback();
                                    return $this->response(500, ['status' => 500, 'message' => 'An error occurred', 'error' => $purpose->getErrors()]);
                                }
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getErrors()]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemovePurpose()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['financer_loan_purpose_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_purpose_enc_id"']);
            }

            $purpose = FinancerLoanPurpose::findOne([
                'financer_loan_purpose_enc_id' => $params['financer_loan_purpose_enc_id']
            ]);

            if ($purpose) {
                $purpose->is_deleted = 1;
                $purpose->updated_by = $user->user_enc_id;
                $purpose->updated_on = date('Y-m-d H:i:s');
                if (!$purpose->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $purpose->getErrors()]);
                }
                return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
            }
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionLoanStatus()
    {
        if ($user = $this->isAuthorized()) {
            $loan_status = LoanStatus::find()
                ->select(['loan_status_enc_id', 'loan_status name', 'value', 'sequence'])
                ->where(['is_deleted' => 0])
                ->orderBy(['sequence' => SORT_ASC])
                ->asArray()
                ->all();

            if ($loan_status) {
                return $this->response(200, ['status' => 200, 'loan_status' => $loan_status]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAssignLoanStatus()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['assigned_financer_loan_type_id']) || empty($params['loan_status'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "assigned_financer_loan_type_id" or "loan_status"']);
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($params['loan_status'] as $key => $val) {
                    $loan_status = new FinancerLoanStatus();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(10, 100000);
                    $loan_status->financer_loan_status_enc_id = $utilitiesModel->encrypt();
                    $loan_status->assigned_financer_loan_type_id = $params['assigned_financer_loan_type_id'];
                    $loan_status->loan_status_enc_id = $val['loan_status_enc_id'];
                    $loan_status->created_by = $user->user_enc_id;
                    $loan_status->created_on = date('Y-m-d H:i:s');
                    if (!$loan_status->save()) {
                        $transaction->rollback();
                        return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $loan_status->getErrors()]);
                    }
                }

                $transaction->commit();

                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

            } catch (\Exception $e) {
                $transaction->rollback();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);

            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionLoanStatusList()
    {
        if ($user = $this->isAuthorized()) {

            $lender = $this->getFinancerId($user);
            if (!$lender) {
                return $this->response(404, ['status' => 404, 'message' => 'lender not found']);
            }

            $loan_status = AssignedFinancerLoanType::find()
                ->alias('a')
                ->select(['a.assigned_financer_enc_id', 'a.organization_enc_id', 'a.loan_type_enc_id', 'lt.name loan'])
                ->joinWith(['loanTypeEnc lt'], false)
                ->innerJoinWith(['financerLoanStatuses b' => function ($b) {
                    $b->select(['b.financer_loan_status_enc_id', 'b.assigned_financer_loan_type_id', 'b1.loan_status_enc_id', 'b1.loan_status name', 'b1.value', 'b1.sequence']);
                    $b->joinWith(['loanStatusEnc b1'], false);
                    $b->onCondition(['b.is_deleted' => 0]);
                    $b->orderBy(['b1.sequence' => SORT_ASC]);
                }])
                ->where(['a.organization_enc_id' => $lender])
                ->groupBy(['a.loan_type_enc_id'])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            if ($loan_status) {
                return $this->response(200, ['status' => 200, 'loan_status' => $loan_status]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionRemoveStatusList()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (empty($params['assigned_financer_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "assigned_financer_enc_id"']);
            }

            $status = FinancerLoanStatus::updateAll([
                'is_deleted' => 1,
                'updated_by' => $user->user_enc_id,
                'updated_on' => date('Y-m-d H:i:s')
            ], [
                'assigned_financer_loan_type_id' => $params['assigned_financer_enc_id']
            ]);

            if ($status) {
                return $this->response(200, ['status' => 200, 'message' => 'Delete Successfully']);
            }

            return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function actionRemoveStatus()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['financer_loan_status_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_status_enc_id"']);
            }

            $status = FinancerLoanStatus::findOne([
                'financer_loan_status_enc_id' => $params['financer_loan_status_enc_id']
            ]);

            if ($status) {
                $status->is_deleted = 1;
                $status->updated_by = $user->user_enc_id;
                $status->updated_on = date('Y-m-d H:i:s');
                if (!$status->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $status->getErrors()]);
                }
                return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
            }
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateStatusList()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!empty($params['loan_status'])) {
                    foreach ($params['loan_status'] as $key => $val) {
                        $loan_status = FinancerLoanStatus::findOne([
                            'financer_loan_status_enc_id' => $val['financer_loan_status_enc_id'],
                            'is_deleted' => 0
                        ]);

                        if ($loan_status) {
                            $loan_status->loan_status_enc_id = $val['loan_status_enc_id'];
                            $loan_status->updated_by = $user->user_enc_id;
                            $loan_status->updated_on = date('Y-m-d H:i:s');
                            if (!$loan_status->update()) {
                                $transaction->rollBack();
                                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_status->getErrors()]);
                            }
                        } else {
                            if (!empty($val['loan_status_enc_id'])) {
                                $loan_status = new FinancerLoanStatus();
                                $utilitiesModel = new \common\models\Utilities();
                                $utilitiesModel->variables['string'] = time() . rand(10, 100000);
                                $loan_status->financer_loan_status_enc_id = $utilitiesModel->encrypt();
                                $loan_status->assigned_financer_loan_type_id = $params['assigned_financer_loan_type_id'];
                                $loan_status->loan_status_enc_id = $val['loan_status_enc_id'];
                                $loan_status->created_by = $user->user_enc_id;
                                $loan_status->created_on = date('Y-m-d H:i:s');
                                if (!$loan_status->save()) {
                                    $transaction->rollback();
                                    return $this->response(500, ['status' => 500, 'message' => 'An error occurred', 'error' => $loan_status->getErrors()]);
                                }
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
                }

                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_status"']);
            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // add loan product (updated)
    public function actionAddLoanProduct()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (empty($params['assigned_financer_loan_type_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "assigned_financer_loan_type_enc_id"']);
            }
            if (empty($params['name'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "name"']);
            }

            if (isset($params['financer_loan_product_enc_id'])) {
                $existingProduct = FinancerLoanProducts::findOne(['financer_loan_product_enc_id' => $params['financer_loan_product_enc_id']]);
                if (!$existingProduct) {
                    return $this->response(404, ['status' => 404, 'message' => 'Product Not Found']);
                }
                $existingProduct->name = $params['name'];
                $existingProduct->updated_on = date('Y-m-d H:i:s');
                $existingProduct->updated_by = $user->user_enc_id;

                if (!$existingProduct->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred, product not updated', 'error' => $existingProduct->getErrors()]);
                }

            } else {
                $product = new FinancerLoanProducts();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(10, 100000);
                $product->financer_loan_product_enc_id = $utilitiesModel->encrypt();
                $product->assigned_financer_loan_type_enc_id = $params['assigned_financer_loan_type_enc_id'];
                $product->name = $params['name'];
                $product->created_by = $user->user_enc_id;
                $product->created_on = date('Y-m-d H:i:s');
                if (!$product->save()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $product->getErrors()]);
                }
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully added']);
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    // get loan products (updated)
    public function actionGetLoanProducts()
    {
        if ($user = $this->isAuthorized()) {
            $lender = $this->getFinancerId($user);
            if (empty($lender)) {
                return $this->response(422, ['status' => 422, 'message' => 'Organization not found']);
            }
            $loan_products = AssignedFinancerLoanType::find()
                ->alias('a')
                ->select(['a.assigned_financer_enc_id', 'a.organization_enc_id', 'a.loan_type_enc_id', 'lt.name loan', 'a.is_deleted', 'flp.name', 'flp.financer_loan_product_enc_id', 'flp.assigned_financer_loan_type_enc_id'])
                ->innerJoinWith(['financerLoanProducts flp'], false)
                ->joinWith(['loanTypeEnc lt'], false)
                ->where(['a.organization_enc_id' => $lender, 'a.is_deleted' => 0, 'flp.is_deleted' => 0])
                ->asArray()
                ->all();
            if ($loan_products) {
                return $this->response(200, ['status' => 200, 'loan_products' => $loan_products]);
            }
            return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'Unauthorized']);
        }
    }

    // delete loan product (updated)
    public function actionRemoveLoanProduct()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['financer_loan_product_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_product_enc_id"']);
            }

            $product = FinancerLoanProducts::findOne([
                'financer_loan_product_enc_id' => $params['financer_loan_product_enc_id'],
                'is_deleted' => 0
            ]);

            if ($product) {
                $product->is_deleted = 1;
                $product->updated_by = $user->user_enc_id;
                $product->updated_on = date('Y-m-d H:i:s');
                if (!$product->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $product->getErrors()]);
                }
                return $this->response(200, ['status' => 200, 'message' => 'Deleted Successfully']);
            }
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // get loan product details (updated)
    public function actionGetLoanProductDetails()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            $lender = $this->getFinancerId($user);
            if (empty($params['financer_loan_product_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_product_enc_id"']);
            }
            $details = FinancerLoanProducts::find()
                ->alias('a')
                ->select(['a.financer_loan_product_enc_id', 'a.name product_name', 'e1.name loan_type_name'])
                ->joinWith(['financerLoanProductPurposes b' => function ($b) {
                    $b->select(['b.financer_loan_product_purpose_enc_id', 'b.financer_loan_product_enc_id', 'b.purpose', 'b.sequence']);
                    $b->orderBy(['b.sequence' => SORT_ASC]);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->joinWith(['financerLoanProductDocuments c' => function ($c) {
                    $c->select(['c.financer_loan_product_document_enc_id', 'c.financer_loan_product_enc_id', 'c.certificate_type_enc_id',
                        'c.sequence', 'ct.name name']);
                    $c->joinWith(['certificateTypeEnc ct'], false);
                    $c->orderBy(['c.sequence' => SORT_ASC]);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->joinWith(['financerLoanProductStatuses d' => function ($d) {
                    $d->select(['d.financer_loan_product_status_enc_id', 'd.financer_loan_product_enc_id', 'd1.loan_status_enc_id', 'd1.loan_status name',
                        'd1.value', 'd1.sequence']);
                    $d->joinWith(['loanStatusEnc d1'], false);
                    $d->onCondition(['d.is_deleted' => 0]);
                    $d->orderBy(['d1.sequence' => SORT_ASC]);
                }])
                ->joinWith(['assignedFinancerLoanTypeEnc e' => function ($e) {
                    $e->joinWith(['loanTypeEnc e1'], false);
                }], false)
                ->onCondition(['a.financer_loan_product_enc_id' => $params['financer_loan_product_enc_id'], 'a.is_deleted' => 0])
                ->where(['a.is_deleted' => 0])
                ->asArray()
                ->one();
            if ($details) {
                return $this->response(200, ['status' => 200, 'detail' => $details]);
            }
            return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    // create or update loan product purpose (updated)
    public function actionUpdateLoanProductPurpose()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['loan_purpose'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_purpose"']);
            }
            if (empty($params['financer_loan_product_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "financer_loan_product_enc_id"']);
            }
            $transaction = Yii::$app->db->beginTransaction();
            $data['financer_loan_product_enc_id'] = $params['financer_loan_product_enc_id'];
            $data['user_enc_id'] = $user->user_enc_id;
            try {
                foreach ($params['loan_purpose'] as $key => $value) {
                    $data['key'] = $key;
                    $data['purpose'] = $value['purpose'];
                    if (!empty($value['financer_loan_product_purpose_enc_id'])) {
                        $purpose = FinancerLoanProductPurpose::findOne([
                            'financer_loan_product_purpose_enc_id' => $value['financer_loan_product_purpose_enc_id'],
                            'is_deleted' => 0
                        ]);
                        if ($purpose) {
                            $purpose->sequence = $key;
                            $purpose->purpose = $value['purpose'];
                            $purpose->updated_by = $user->user_enc_id;
                            $purpose->updated_on = date('Y-m-d H:i:s');
                            if (!$purpose->update()) {
                                $transaction->rollBack();
                                return $this->response(500, ['status' => 500, 'message' => 'An error occurred', 'error' => $purpose->getErrors()]);
                            }
                        } else {
                            $query = $this->__createPurpose($data);
                            if ($query['status'] == 500) {
                                $transaction->rollback();
                                return $this->response(500, $query);
                            }
                        }
                    } else {
                        $query = $this->__createPurpose($data);
                        if ($query['status'] == 500) {
                            $transaction->rollback();
                            return $this->response(500, $query);
                        }
                    }
                }
                $transaction->commit();
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getErrors()]);
            }
        }
        return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
    }

    // remove loan product purpose (updated)
    public function actionRemoveLoanProductPurpose()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['financer_loan_product_purpose_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_product_purpose_enc_id"']);
            }

            $purpose = FinancerLoanProductPurpose::findOne([
                'financer_loan_product_purpose_enc_id' => $params['financer_loan_product_purpose_enc_id'],
                'is_deleted' => 0
            ]);

            if ($purpose) {
                $purpose->is_deleted = 1;
                $purpose->updated_by = $user->user_enc_id;
                $purpose->updated_on = date('Y-m-d H:i:s');
                if (!$purpose->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $purpose->getErrors()]);
                }
                return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
            }
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // create or update loan product documents (updated)
    public function actionUpdateLoanProductDocuments()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (empty($params['certificate_types'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "certificate_types"']);
            }
            if (empty($params['financer_loan_product_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "financer_loan_product_enc_id"']);
            }
            $transaction = Yii::$app->db->beginTransaction();
            $data['financer_loan_product_enc_id'] = $params['financer_loan_product_enc_id'];
            $data['user_enc_id'] = $user->user_enc_id;
            try {
                foreach ($params['certificate_types'] as $key => $val) {
                    $data['key'] = $key;
                    if (isset($val['certificate_type_enc_id'])) {
                        $document = FinancerLoanProductDocuments::findOne([
                            'certificate_type_enc_id' => $val['certificate_type_enc_id'],
                            'financer_loan_product_enc_id' => $data['financer_loan_product_enc_id'],
                            'is_deleted' => 0
                        ]);
                        if ($document) {
                            $document->sequence = $key;
                            $document->updated_by = $user->user_enc_id;
                            $document->updated_on = date('Y-m-d H:i:s');
                            if (!$document->update()) {
                                $transaction->rollBack();
                                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $document->getErrors()]);
                            }
                        } else {
                            if (empty($val['name'])) {
                                $transaction->rollBack();
                                return $this->response(422, ['status' => 422, 'message' => 'missing information "name"']);
                            }
                            $certificate_id = $this->__getCertificateTypeId($val['name']);
                            if (!$certificate_id) {
                                $transaction->rollback();
                                return $this->response(500, ['status' => 500, 'message' => 'an error occurred while getting certificate type id for "' . $val['name'] . '"']);
                            }
                            $data['certificate_id'] = $certificate_id;
                            $query = $this->__createDocument($data);
                            if ($query['status'] == 500) {
                                $transaction->rollback();
                                return $this->response(500, $query);
                            }

                        }
                    } else {
                        if (empty($val['name'])) {
                            $transaction->rollBack();
                            return $this->response(422, ['status' => 422, 'message' => 'missing information "name"']);
                        }
                        $certificate_id = $this->__getCertificateTypeId($val['name']);

                        if (!$certificate_id) {
                            $transaction->rollback();
                            return $this->response(500, ['status' => 500, 'message' => 'an error occurred while getting certificate type id for "' . $val['name'] . '"']);
                        }
                        $data['certificate_id'] = $certificate_id;
                        $query = $this->__createDocument($data);
                        if ($query['status'] == 500) {
                            $transaction->rollback();
                            return $this->response(500, $query);
                        }
                    }
                }
                $transaction->commit();
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

            } catch (Exception $e) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getErrors()]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // remove loan product document (updated)
    public function actionRemoveLoanProductDocument()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (empty($params['financer_loan_product_document_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_product_document_enc_id"']);
            }
            $document = FinancerLoanProductDocuments::findOne([
                'financer_loan_product_document_enc_id' => $params['financer_loan_product_document_enc_id'],
                'is_deleted' => 0
            ]);
            if ($document) {
                $document->is_deleted = 1;
                $document->updated_by = $user->user_enc_id;
                $document->updated_on = date('Y-m-d H:i:s');
                if (!$document->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $document->getErrors()]);
                }
                return $this->response(200, ['status' => 200, 'message' => 'Deleted Successfully']);
            }
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // assign loan status (updated)
    public function actionUpdateLoanProductStatus()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['financer_loan_product_enc_id']) || empty($params['loan_status'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_product_enc_id" or "loan_status"']);
            }

            $transaction = Yii::$app->db->beginTransaction();
            $data['financer_loan_product_enc_id'] = $params['financer_loan_product_enc_id'];
            $data['user_enc_id'] = $user->user_enc_id;
            try {
                foreach ($params['loan_status'] as $key => $val) {
                    $data['loan_status_enc_id'] = $val['loan_status_enc_id'];
                    if (isset($val['financer_loan_product_status_enc_id'])) {
                        $loan_status = FinancerLoanProductStatus::findOne([
                            'financer_loan_product_status_enc_id' => $val['financer_loan_product_status_enc_id'],
                            'is_deleted' => 0
                        ]);
                        if ($loan_status) {
                            $loan_status->loan_status_enc_id = $val['loan_status_enc_id'];
                            $loan_status->updated_by = $user->user_enc_id;
                            $loan_status->updated_on = date('Y-m-d H:i:s');
                            if (!$loan_status->update()) {
                                $transaction->rollBack();
                                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_status->getErrors()]);
                            }
                        } else {
                            $query = $this->__createStatus($data);
                            if ($query['status'] == 500) {
                                $transaction->rollBack();
                                return $this->response(500, $query);
                            }
                        }
                    } else {
                        $query = $this->__createStatus($data);
                        if ($query['status'] == 500) {
                            $transaction->rollback();
                            return $this->response(500, $query);
                        }
                    }
                }
                $transaction->commit();
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
            } catch (\Exception $e) {
                $transaction->rollback();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    // remove loan product status (updated)
    public function actionRemoveLoanProductStatus()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['financer_loan_product_status_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_product_status_enc_id"']);
            }

            $status = FinancerLoanProductStatus::findOne([
                'financer_loan_product_status_enc_id' => $params['financer_loan_product_status_enc_id'],
                'is_deleted' => 0
            ]);

            if ($status) {
                $status->is_deleted = 1;
                $status->updated_by = $user->user_enc_id;
                $status->updated_on = date('Y-m-d H:i:s');
                if (!$status->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $status->getErrors()]);
                }
                return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
            }
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }


    // used to create product status
    private function __createStatus($data)
    {
        $loan_status = new FinancerLoanProductStatus();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $loan_status->financer_loan_product_status_enc_id = $utilitiesModel->encrypt();
        $loan_status->financer_loan_product_enc_id = $data['financer_loan_product_enc_id'];
        $loan_status->loan_status_enc_id = $data['loan_status_enc_id'];
        $loan_status->created_by = $data['user_enc_id'];
        $loan_status->created_on = date('Y-m-d H:i:s');
        if (!$loan_status->save()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_status->getErrors()];
        }
        return ['status' => 200];
    }

    // used to create product document
    private function __createDocument($data)
    {
        $loan_document = new FinancerLoanProductDocuments();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $loan_document->financer_loan_product_document_enc_id = $utilitiesModel->encrypt();
        $loan_document->financer_loan_product_enc_id = $data['financer_loan_product_enc_id'];
        $loan_document->certificate_type_enc_id = $data['certificate_id'];
        $loan_document->sequence = $data['key'];
        $loan_document->created_by = $data['user_enc_id'];
        $loan_document->created_on = date('Y-m-d H:i:s');
        if (!$loan_document->save()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_document->getErrors()];
        }
        return ['status' => 200];
    }

    // used to create product purpose
    private function __createPurpose($data)
    {
        $purpose = new FinancerLoanProductPurpose();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $purpose->financer_loan_product_purpose_enc_id = $utilitiesModel->encrypt();
        $purpose->financer_loan_product_enc_id = $data['financer_loan_product_enc_id'];
        $purpose->purpose = $data['purpose'];
        $purpose->sequence = $data['key'];
        $purpose->created_on = date('Y-m-d H:i:s');
        $purpose->created_by = $data['user_enc_id'];
        if (!$purpose->save()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $purpose->getErrors()];
        }
        return ['status' => 200];
    }

    public function actionEmiCollection()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        if (!$user->organization_enc_id) {
            $findOrg = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            if (!$findOrg['organization_enc_id']) {
                return $this->response(500, ['status' => 500, 'message' => 'Organization not found']);
            }
        }
        try {
            $model = new EmiCollectionForm();
            if ($model->load(Yii::$app->request->post()) && !$model->validate()) {
                return $this->response(422, ['status' => 422, 'message' => \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)]);
            }
            $model->other_doc_image = UploadedFile::getInstance($model, 'other_doc_image');
            $model->borrower_image = UploadedFile::getInstance($model, 'borrower_image');
            $model->pr_receipt_image = UploadedFile::getInstance($model, 'pr_receipt_image');
            $save = $model->save($user->user_enc_id);
            if ($save['status'] == 500) {
                return $this->response(500, $save);
            } else {
                return $this->response(200, $save);
            }
        } catch (\Exception $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }

    public function actionGetCollectedEmiList()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        $search = '';
        if (empty($params['organization_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "organization_id"']);
        }
        if (isset($params['search_keyword'])) {
            $search = $params['search_keyword'];
        }

        $org_id = $params['organization_id'];
        $model = $this->_emiData($org_id, 0, $search);
        $count = count($model);
        if (!$count > 0) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }
        return $this->response(200, ['status' => 200, 'data' => $model, 'count' => $count]);
    }

    public function actionEmiDetail()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['emi_collection_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "emi_collection_enc_id"']);
        }
        $lac = EmiCollection::findOne(['emi_collection_enc_id' => $params['emi_collection_enc_id']])['loan_account_number'];
        $model = $this->_emiData($lac, 1);
        if (!$model) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }
        $display_data = EmiCollection::find()
            ->alias('a')
            ->select(['a.customer_name', 'a.loan_account_number', 'a.loan_type', 'a.phone', 'SUM(a.amount) total_amount', 'COUNT(a.loan_account_number) as total_emis', 'CONCAT(b.location_name , ", ", b1.name) as branch_name'])
            ->where(['a.loan_account_number' => $lac])
            ->joinWith(['branchEnc b' => function ($b) {
                $b->joinWith(['cityEnc b1']);
            }], false)
            ->asArray()
            ->all();
        return $this->response(200, ['status' => 200, 'display_data' => $display_data[0], 'data' => $model]);

    }

    private function _emiData($data, $id_type, $search = '')
    {
        // if id_type = 1 then loan account number if id_type = 0 then organization id, this function is being used for GetCollectedEmiList and EmiDetail
        if ($id_type == 1) {
            $lac = $data;
        }
        if ($id_type == 0) {
            $org_id = $data;
        }

        $model = EmiCollection::find()
            ->alias('a')
            ->select(['a.emi_collection_enc_id', 'CONCAT(c.location_name , ", ", c1.name) as branch_name', 'a.customer_name', 'a.collection_date',
                'a.loan_account_number', 'a.phone', 'a.amount', 'a.loan_type', 'a.loan_purpose', 'a.payment_method',
                'a.other_payment_method', 'a.ptp_amount', 'a.ptp_date', 'd.designation', 'CONCAT(b.first_name, " ", b.last_name) name',
                'CASE WHEN a.other_delay_reason IS NOT NULL THEN CONCAT(a.delay_reason, ",",a.other_delay_reason) ELSE a.delay_reason END AS delay_reason',
                'CASE WHEN a.borrower_image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->image . '",a.borrower_image_location, "/", a.borrower_image) ELSE NULL END as borrower_image',
                'CASE WHEN a.pr_receipt_image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->image . '",a.pr_receipt_image_location, "/", a.pr_receipt_image) ELSE NULL END as pr_receipt_image',
                'CASE WHEN a.other_doc_image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->image . '",a.other_doc_image_location, "/", a.other_doc_image) ELSE NULL END as other_doc_image',
                'CONCAT(a.address,", ", a.pincode) address',
                'a.comments']);
        if (isset($org_id)) {
            $model->joinWith(['createdBy b' => function ($b) {
                $b->joinWith(['userRoles b1'], false);
                $b->joinWith(['designations d']);
            }], false)
                ->andWhere(['or', ['b.organization_enc_id' => $org_id], ['b1.organization_enc_id' => $org_id]]);
        }

        if (isset($lac)) {
            $model->andWhere(['a.loan_account_number' => $lac]);
        }

        if (!empty($search)) {
            $model->andWhere([
                'or',
                ['like', 'CONCAT(c.location_name , ", ", c1.name)', $search],
                ['like', 'c.location_name', $search],
                ['like', 'a.customer_name', $search],
                ['like', 'a.loan_account_number', $search],
                ['like', 'a.loan_type', $search],
            ]);
        }

        $model = $model->joinWith(['branchEnc c' => function ($c) {
            $c->joinWith(['cityEnc c1'], false);
        }], false)
            ->orderBy(['a.created_on' => SORT_DESC])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->all();

        $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        foreach ($model as $key => $value) {
            if ($value['other_doc_image']) {
                $proof = $my_space->signedURL($value['other_doc_image'], "15 minutes");
                $model[$key]['other_doc_image'] = $proof;
            }
            if ($value['borrower_image']) {
                $proof = $my_space->signedURL($value['borrower_image'], "15 minutes");
                $model[$key]['borrower_image'] = $proof;
            }
            if ($value['pr_receipt_image']) {
                $proof = $my_space->signedURL($value['pr_receipt_image'], "15 minutes");
                $model[$key]['pr_receipt_image'] = $proof;
            }
        }
        return $model;

    }

    public function actionDeleteEmi()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (empty($params['emi_collection_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing parameter "emi_collection_enc_id"']);
            }
            $removeEmi = EmiCollection::findOne(['emi_collection_enc_id' => $params['emi_collection_enc_id']]);
            if (!$removeEmi) {
                return $this->response(404, ['status' => 404, 'message' => 'emi_collection_enc_id found']);
            }
            $removeEmi->is_deleted = 1;
            $removeEmi->updated_by = $user->user_enc_id;
            $removeEmi->updated_on = date('Y-m-d H:i:s');
            if (!$removeEmi->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred while deleting.', 'error' => $removeEmi->getErrors()]);
            }
            return $this->response(200, ['status' => 200, 'message' => 'successfully removed']);
        }
    }

    public function actionEmiList()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $org_id = $user->organization_enc_id;

        if (!$user->organization_enc_id) {
            $findOrg = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            $org_id = $findOrg->organization_enc_id;
        }
        if ($org_id) {
            $emiList = EmiCollection::find()
                ->alias('a')
                ->select(['a.customer_name', 'a.phone', 'a.loan_account_number', 'a.loan_type', 'b.location_name as branch_name', 'a.branch_enc_id'])
                ->joinWith(['branchEnc b'], false)
                ->andWhere(['organization_enc_id' => $org_id, 'a.is_deleted' => 0])
                ->groupBy(['a.loan_account_number'])
                ->asArray()
                ->all();
            return $this->response(200, ['status' => 200, 'data' => $emiList]);
        } else {
            return $this->response(401, ['status' => 201, 'message' => 'Not found']);
        }
    }

    public function actionAddNotice()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        if (!$org_id = $this->getFinancerId($user)) {
            return $this->response(401, ['status' => 401, 'message' => 'financer id not found']);
        }
        if (!$image = $_FILES['image']) {
            return $this->response(401, ['status' => 401, 'message' => 'image missing']);
        }
        $notice = new FinancerNoticeBoard();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $notice->image = $utilitiesModel->encrypt() . '.' . explode('.', $image['name'])[1];
        $notice->image_location = Yii::$app->getSecurity()->generateRandomString();
        $base_path = Yii::$app->params->upload_directories->notice->image . $notice->image_location;
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $result = $my_space->uploadFileSources($image['tmp_name'], Yii::$app->params->digitalOcean->rootDirectory . $base_path . DIRECTORY_SEPARATOR . $notice->image, "public", ['params' => ['ContentType' => $image['type']]]);
        if (!$result) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred while saving image']);
        }
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $notice->notice_enc_id = $utilitiesModel->encrypt();
        $notice->financer_enc_id = $org_id;
        $notice->created_on = $notice->updated_on = date('Y-m-d H:i:s');
        $notice->created_by = $notice->updated_by = $user->user_enc_id;
        if (!$notice->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $notice->getErrors()]);
        }
        return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
    }

    public function actionGetNotice()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        $notice = FinancerNoticeBoard::find()
            ->alias('a')
            ->select(['a.notice_enc_id',
                'CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->notice->image, 'https') . '", a.image_location, "/", a.image) image',
                '(CASE WHEN a.status = "Active" THEN TRUE ELSE FALSE END) as status',
                'a.created_on'
            ]);
        if (isset($params['status']) && $params['status']) {
            $notice->andWhere(['a.status' => $params['status']]);
        }
        $notice = $notice->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->all();
        if ($notice) {
            return $this->response(200, ['status' => 200, 'notices' => $notice]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
    }

    public function actionUpdateNotice()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['notice_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing parameter "notice_enc_id"']);
        }
        $notice = FinancerNoticeBoard::findOne(['notice_enc_id' => $params['notice_enc_id'], 'created_by' => $user->user_enc_id]);
        if (!$notice) {
            return $this->response(404, ['status' => 404, 'message' => 'Notice not Found']);
        }
        if (isset($params['status'])) {
            $status = 'Inactive';
            if ($params['status']) {
                $status = 'Active';
            }
            $notice->status = $status;
        }
        if (isset($params['delete']) && $params['delete']) {
            $notice->is_deleted = 1;
        }
        $notice->updated_by = $user->user_enc_id;
        $notice->updated_on = date('Y-m-d H:i:s');
        if (!$notice->update()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred while updating', 'error' => $notice->getErrors()]);
        }
        return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);

    }
}