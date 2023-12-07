<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\EmiCollectionForm;
use api\modules\v4\models\LoanApplication;
use api\modules\v4\utilities\UserUtilities;
use common\models\AssignedFinancerLoanType;
use common\models\AssignedFinancerLoanTypes;
use common\models\AssignedLoanProvider;
use common\models\CertificateTypes;
use common\models\extended\EmiCollectionExtended;
use common\models\extended\LoanAccountsExtended;
use common\models\extended\LoanApplicationImagesExtended;
use common\models\FinancerLoanDocuments;
use common\models\FinancerLoanProductDocuments;
use common\models\FinancerLoanProductImages;
use common\models\FinancerLoanProductLoginFeeStructure;
use common\models\FinancerLoanProductPendencies;
use common\models\FinancerLoanProductProcess;
use common\models\FinancerLoanProductPurpose;
use common\models\FinancerLoanProducts;
use common\models\FinancerLoanProductStatus;
use common\models\FinancerLoanPurpose;
use common\models\FinancerLoanStatus;
use common\models\FinancerNoticeBoard;
use common\models\LoanStatus;
use common\models\LoanTypes;
use common\models\OrganizationLocations;
use common\models\spaces\Spaces;
use common\models\UserRoles;
use common\models\UserTypes;
use common\models\Utilities;
use Yii;
use yii\db\Expression;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\UploadedFile;


class OrganizationsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors["verbs"] = [
            "class" => VerbFilter::className(),
            "actions" => [
                "add-branch" => ["POST", "OPTIONS"],
                "get-branches" => ["POST", "OPTIONS"],
                "update-branch" => ["POST", "OPTIONS"],
                "remove-branch" => ["POST", "OPTIONS"],
                "get-loan-types" => ["POST", "OPTIONS"],
                "update-loan-type" => ["POST", "OPTIONS"],
                "assigned-loan-types" => ["POST", "OPTIONS"],
                "assigned-financer-loan-types" => ["POST", "OPTIONS"],
                "get-documents-list" => ["POST", "OPTIONS"],
                "assign-document" => ["POST", "OPTIONS"],
                "get-assigned-documents" => ["POST", "OPTIONS"],
                "remove-assigned-documents-list" => ["POST", "OPTIONS"],
                "update-assigned-documents" => ["POST", "OPTIONS"],
                "add-purpose" => ["POST", "OPTIONS"],
                "get-purpose-list" => ["POST", "OPTIONS"],
                "remove-purpose-list" => ["POST", "OPTIONS"],
                "update-purpose-list" => ["POST", "OPTIONS"],
                "remove-purpose" => ["POST", "OPTIONS"],
                "loan-status" => ["POST", "OPTIONS"],
                "assign-loan-status" => ["POST", "OPTIONS"],
                "loan-status-list" => ["POST", "OPTIONS"],
                "remove-status-list" => ["POST", "OPTIONS"],
                "remove-status" => ["POST", "OPTIONS"],
                "update-status-list" => ["POST", "OPTIONS"],
                "delete-emi" => ["POST", "OPTIONS"],
                "emi-list" => ["POST", "OPTIONS"],
                "add-notice" => ["POST", "OPTIONS"],
                "get-notice" => ["POST", "OPTIONS"],
                "update-notice" => ["POST", "OPTIONS"],
                "update-loan-product-process" => ["POST", "OPTIONS"],
                "update-loan-product-fees" => ["POST", "OPTIONS"],
                "financer-loan-status-list" => ["POST", "OPTIONS"],
                "emi-stats" => ["POST", "OPTIONS"],
                "update-loan-product-images" => ["POST", "OPTIONS"],
                "remove-loan-product-image" => ["POST", "OPTIONS"],
                "upload-application-image" => ["POST", "OPTIONS"],
                "get-assigned-images" => ["POST", "OPTIONS"],
                "search-emi" => ["POST", "OPTIONS"],
                "update-pendency" => ["POST", "OPTIONS"]
            ]
        ];

        $behaviors["corsFilter"] = [
            "class" => Cors::className(),
            "cors" => [
                "Origin" => ["https://www.empowerloans.in/"],
                "Access-Control-Request-Method" => ["GET", "POST", "PUT", "PATCH", "DELETE", "HEAD", "OPTIONS"],
                "Access-Control-Max-Age" => 86400,
                "Access-Control-Expose-Headers" => [],
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

            // checking city_id
            if (empty($params["city_id"])) {
                return $this->response(422, ["status" => 422, "message" => "missing information 'city_id'"]);
            }

            // adding branch
            $orgLocations = new OrganizationLocations();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables["string"] = time() . rand(100, 100000);
            $orgLocations->location_enc_id = $utilitiesModel->encrypt();
            $orgLocations->organization_enc_id = $user->organization_enc_id;
            $orgLocations->location_name = $params["location_name"];
            $orgLocations->organization_code = $params["organization_code"];
            $orgLocations->location_for = json_encode(["1"]);
            $orgLocations->address = $params["address"];
            $orgLocations->city_enc_id = $params["city_id"];
            $orgLocations->created_by = $user->user_enc_id;
            $orgLocations->created_on = date("Y-m-d H:i:s");
            if (!$orgLocations->save()) {
                return $this->response(500, ["status" => 500, "message" => "an error occurred", "error" => $orgLocations->getErrors()]);
            }

            return $this->response(200, ["status" => 200, "message" => "successfully saved"]);
        } else {
            return $this->response(401, ["status" => 401, "message" => "unauthorized"]);
        }
    }

    // this action is used to update branch
    public function actionUpdateBranch()
    {
        // checking authorization
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            // checking location_id
            if (empty($params["location_id"])) {
                return $this->response(422, ["status" => 422, "message" => "missing information 'location_id'"]);
            }

            // getting locations object with location_id
            $location = OrganizationLocations::findOne(["location_enc_id" => $params["location_id"], "is_deleted" => 0]);

            // if not found
            if (!$location) {
                return $this->response(404, ["status" => 404, "message" => "branch not found"]);
            }

            // updating data
            (!empty($params["location_name"])) ? $location->location_name = $params["location_name"] : "";
            (!empty($params["city_id"])) ? $location->city_enc_id = $params["city_id"] : "";
            $location->organization_code = $params["organization_code"] ?? "";
            (!empty($params["address"])) ? $location->address = $params["address"] : "";
            (!empty($params["status"])) ? $location->status = $params["status"] : "";
            $location->last_updated_by = $user->user_enc_id;
            $location->last_updated_on = date("Y-m-d H:i:s");
            if (!$location->update()) {
                return $this->response(500, ["status" => 500, "message" => "an error occurred", "error" => $location->getErrors()]);
            }

            return $this->response(200, ["status" => 200, "message" => "successfully updated"]);
        } else {
            return $this->response(401, ["status" => 401, "message" => "unauthorized"]);
        }
    }

    // getting list of branches
    public function actionGetBranches()
    {
        if ($user = $this->isAuthorized()) {
            // default org of user
            $org = $user->organization_enc_id;
            if (!$org) {
                $org = UserRoles::findOne(["user_enc_id" => $user->user_enc_id])["organization_enc_id"];
            }
            $user_type = UserTypes::findOne(["user_type_enc_id" => $user->user_type_enc_id]);
            if ($user_type["user_type"] && $user_type["user_type"] == "Dealer") {
                $user_role = UserRoles::findOne(["user_enc_id" => $user->user_enc_id]);
                if (!empty($user_role["organization_enc_id"])) {
                    // if user_type = dealer, then org id is from UserRoles
                    $org = $user_role["organization_enc_id"];
                }
            }
            if (empty($org)) {
                return $this->response(404, ["status" => 404, "message" => "not found"]);
            }

            $locations = OrganizationLocations::find()
                ->alias("a")
                ->select(["a.location_enc_id", "a.location_enc_id as id", "b.city_code", "a.organization_code", "a.location_name", "a.location_for", "a.address", "b.name city", "b.city_enc_id", "a.status"])
                ->addSelect(["CONCAT(a.location_name , ', ', b.name) as value"])
                ->joinWith(["cityEnc b"], false)
                ->andWhere(["a.is_deleted" => 0, "a.organization_enc_id" => $org])
                ->asArray()
                ->all();

            if ($locations) {
                return $this->response(200, ["status" => 200, "branches" => $locations]);
            }

            return $this->response(404, ["status" => 404, "message" => "not found"]);
        } else {
            return $this->response(401, ["status" => 401, "message" => "unauthorized"]);
        }
    }

    public function actionRemoveBranch()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params["location_id"])) {
                return $this->response(422, ["status" => 422, "message" => "missing information 'location_id'"]);
            }

            $location = OrganizationLocations::findOne(["location_enc_id" => $params["location_id"]]);

            if ($location) {
                $location->is_deleted = 1;
                $location->last_updated_by = $user->user_enc_id;
                $location->last_updated_on = date("Y-m-d H:i:s");
                if (!$location->update()) {
                    return $this->response(500, ["status" => 500, "message" => "an error occurred", "error" => $location->getErrors()]);
                }

                return $this->response(200, ["status" => 200, "message" => "successfully updated"]);
            }

            return $this->response(404, ["status" => 404, "message" => "not found"]);
        } else {
            return $this->response(401, ["status" => 401, "message" => "unauthorized"]);
        }
    }

    public function actionGetLoanTypes()
    {
        if ($user = $this->isAuthorized()) {

            $assignedLoanTypes = AssignedFinancerLoanTypes::find()
                ->alias("a")
                ->select(["a.assigned_financer_enc_id", "a.organization_enc_id", "a.loan_type_enc_id", "a.status", "b.name"])
                ->joinWith(["loanTypeEnc b"], false)
                ->where(["a.organization_enc_id" => $user->organization_enc_id, "a.is_deleted" => 0])
                ->asArray()
                ->all();

            $allLoanTypes = LoanTypes::find()
                ->select(["name", "loan_type_enc_id", new Expression("0 as status"),])
                ->asArray()
                ->all();

            foreach ($allLoanTypes as $key => $val) {
                foreach ($assignedLoanTypes as $v) {
                    if ($v["name"] == $val["name"]) {
                        $allLoanTypes[$key] = $v;
                    }
                }
            }

            return $this->response(200, ["status" => 200, "allLoanTypes" => $allLoanTypes]);
        } else {
            return $this->response(401, ["status" => 401, "message" => "unauthorized"]);
        }
    }

    public function actionUpdateLoanType()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params["loan_type_enc_id"])) {
                return $this->response(422, ["status" => 422, "message" => "missing information 'loan_type_enc_id'"]);
            }

            if (empty($params["status"])) {
                return $this->response(422, ["status" => 422, "message" => "missing information 'status'"]);
            }


            $assignedType = AssignedFinancerLoanTypes::findOne(['organization_enc_id' => $user->organization_enc_id, 'loan_type_enc_id' => $params['loan_type_enc_id'], 'is_deleted' => 0]);

            if ($assignedType) {
                $assignedType->status = $params["status"] == "Active" ? 1 : 0;
                $assignedType->updated_by = $user->user_enc_id;
                $assignedType->updated_on = date("Y-m-d H:i:s");
                if (!$assignedType->update()) {
                    return $this->response(500, ["status" => 500, "message" => "an error occurred", "error" => $assignedType->getErrors()]);
                }
            } else {
                $assignedType = new AssignedFinancerLoanTypes();
                $assignedType->assigned_financer_enc_id = Yii::$app->security->generateRandomString(32);
                $assignedType->organization_enc_id = $user->organization_enc_id;
                $assignedType->loan_type_enc_id = $params["loan_type_enc_id"];
                $assignedType->status = $params["status"] == "Active" ? 1 : 0;
                $assignedType->created_by = $user->user_enc_id;
                $assignedType->created_on = date("Y-m-d H:i:s");
                if (!$assignedType->save()) {
                    return $this->response(500, ["status" => 500, "message" => "an error occurred", "error" => $assignedType->getErrors()]);
                }
            }

            return $this->response(200, ["status" => 200, "message" => "successfully updated"]);
        } else {
            return $this->response(401, ["status" => 401, "message" => "unauthorized"]);
        }
    }

    public function actionAssignedLoanTypes()
    {
        if ($user = $this->isAuthorized()) {
            $provider_id = $this->getFinancerId($user);

            $assignedLoanTypes = AssignedFinancerLoanType::find()
                ->alias("a")
                ->select(["a.assigned_financer_enc_id", "a.organization_enc_id", "a.loan_type_enc_id", "b.name"])
                ->joinWith(["loanTypeEnc b"], false)
                ->where(["a.organization_enc_id" => $provider_id, "a.is_deleted" => 0, "a.status" => 1])
                ->asArray()
                ->all();

            if ($assignedLoanTypes) {
                return $this->response(200, ["status" => 200, "assignedLoanTypes" => $assignedLoanTypes]);
            }

            return $this->response(404, ["status" => 404, "message" => "not found"]);
        } else {
            return $this->response(401, ["status" => 401, "message" => "unauthorized"]);
        }
    }

    public function actionAssignedFinancerLoanTypes()
    {
        if ($user = $this->isAuthorized()) {
            $provider_id = $this->getFinancerId($user);

            $assignedLoanTypes = AssignedFinancerLoanTypes::find()
                ->alias("a")
                ->select(["a.assigned_financer_enc_id", "a.organization_enc_id", "a.loan_type_enc_id", "b.name"])
                ->joinWith(["loanTypeEnc b"], false)
                ->where(["a.organization_enc_id" => $provider_id, "a.is_deleted" => 0, "a.status" => 1])
                ->asArray()
                ->all();

            if ($assignedLoanTypes) {
                return $this->response(200, ["status" => 200, "assignedLoanTypes" => $assignedLoanTypes]);
            }

            return $this->response(404, ["status" => 404, "message" => "not found"]);
        } else {
            return $this->response(401, ["status" => 401, "message" => "unauthorized"]);
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

            $subquery = (new \yii\db\Query())
                ->select(['c.financer_loan_product_document_enc_id', 'c.financer_loan_product_enc_id', 'c.certificate_type_enc_id', 'c.sequence', 'c1.name certificate_name'])
                ->from(['c' => FinancerLoanProductDocuments::tableName()])
                ->join('LEFT JOIN', ['c1' => CertificateTypes::tableName()], 'c1.certificate_type_enc_id = c.certificate_type_enc_id')
                ->andWhere(['c.is_deleted' => 0])
                ->orderBy(['c.sequence' => SORT_ASC]);

            $certificates = FinancerLoanProducts::find()
                ->alias('a')
                ->select(['b.assigned_financer_enc_id', 'b.organization_enc_id', 'a.financer_loan_product_enc_id', 'a.name loan'])
                ->joinWith(['assignedFinancerLoanTypeEnc b'], false)
                ->innerJoinWith([
                    'financerLoanProductDocuments c' => function ($k) use ($subquery) {
                        $k->from(['subquery' => $subquery]);
                    }
                ])
                ->where([
                    'b.organization_enc_id' => $lender, 'b.is_deleted' => 0, 'a.is_deleted' => 0
                ])
                ->groupBy(['a.financer_loan_product_enc_id'])
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
            ], [
                'and',
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

            $purpose = AssignedFinancerLoanTypes::find()
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
            $subquery = (new \yii\db\Query())
                ->select(['c.financer_loan_product_status_enc_id', 'c.financer_loan_product_enc_id', 'c1.loan_status_enc_id', 'c1.loan_status name', 'c1.value', 'c1.sequence', 'c1.status_color'])
                ->from(['c' => FinancerLoanProductStatus::tableName()])
                ->join('LEFT JOIN', ['c1' => LoanStatus::tableName()], 'c1.loan_status_enc_id = c.loan_status_enc_id')
                ->andWhere(['c.is_deleted' => 0])
                ->orderBy(['c1.sequence' => SORT_ASC]);

            $loan_status = FinancerLoanProducts::find()
                ->alias('a')
                ->select(['b.assigned_financer_enc_id', 'b.organization_enc_id', 'a.financer_loan_product_enc_id', 'a.name loan'])
                ->joinWith(['assignedFinancerLoanTypeEnc b'])
                ->innerJoinWith([
                    'financerLoanProductStatuses c' => function ($k) use ($subquery) {
                        $k->from(['subquery' => $subquery]);
                    }
                ])
                ->where(['b.organization_enc_id' => $lender])
                ->groupBy(['a.financer_loan_product_enc_id'])
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

    public function actionFinancerLoanStatusList()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $org_id = $this->getFinancerId($user);
        $data = AssignedLoanProvider::find()
            ->distinct(['b.value'])
            ->alias('a')
            ->select(['b.value', 'b.loan_status'])
            ->joinWith(['status0 b'], false)
            ->where(['a.provider_enc_id' => $org_id, 'b.is_deleted' => 0])
            ->asArray()
            ->all();
        if ($data) {
            return $this->response(200, ['status' => 200, 'data' => $data]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
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

    // add, update or delete product
    public function actionUpdateLoanProduct()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $params = Yii::$app->request->post();

        if (isset($params['financer_loan_product_enc_id'])) {
            $product = FinancerLoanProducts::findOne(['financer_loan_product_enc_id' => $params['financer_loan_product_enc_id']]);
            if (!$product) {
                return $this->response(404, ['status' => 404, 'message' => 'Product Not Found']);
            }

            if (!empty($params['deleted'])) {
                if ($product['is_deleted'] == 1) {
                    return $this->response(500, ['status' => 500, 'message' => 'Already Deleted']);
                }
                $product->is_deleted = 1;
            }
            $save = 'update';
        } else {
            $product = new FinancerLoanProducts();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(10, 100000);
            $product->financer_loan_product_enc_id = $utilitiesModel->encrypt();
            //            $product->product_code = $params['product_code'];
            $product->created_by = $user->user_enc_id;
            $product->created_on = date('Y-m-d H:i:s');
            $save = 'save';
        }

        if (!empty($params['name'])) {
            $product->name = $params['name'];
        }

        if (!empty($params['assigned_financer_loan_type_enc_id'])) {
            $product->assigned_financer_loan_type_enc_id = $params['assigned_financer_loan_type_enc_id'];
        }
        if (isset($params['product_code'])) {
            $product->product_code = $params['product_code'];
        }

        $product->updated_by = $user->user_enc_id;
        $product->updated_on = date('Y-m-d H:i:s');

        if (!$product->$save()) {
            return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $product->getErrors()]);
        }

        return $this->response(200, ['status' => 200, 'message' => $save . 'd successfully']);
    }

    // get loan products (updated)
    public function actionGetLoanProducts()
    {
        if ($user = $this->isAuthorized()) {
            $lender = $this->getFinancerId($user);
            if (empty($lender)) {
                return $this->response(422, ['status' => 422, 'message' => 'Organization not found']);
            }
            $subquery = (new \yii\db\Query())
                ->select(['c.financer_loan_product_purpose_enc_id', 'c.financer_loan_product_enc_id', 'c.sequence', 'c.purpose'])
                ->from(['c' => FinancerLoanProductPurpose::tableName()])
                ->andWhere(['c.is_deleted' => 0])
                ->orderBy(['c.sequence' => SORT_ASC]);

            $loan_products = FinancerLoanProducts::find()
                ->alias('a')
                ->select(['a.financer_loan_product_enc_id', 'b.assigned_financer_enc_id', 'b.organization_enc_id', 'a.product_code', 'b.loan_type_enc_id', 'b1.name loan', 'a.name'])
                ->joinWith(['assignedFinancerLoanTypeEnc b' => function ($b) use ($lender) {
                    $b->joinWith(['loanTypeEnc b1'], false);
                    $b->andWhere([
                        'b.organization_enc_id' => $lender,
                        'b.is_deleted' => 0
                    ]);
                }], false)
                ->joinWith([
                    'financerLoanProductPurposes c' => function ($k) use ($subquery) {
                        $k->from(['subquery' => $subquery]);
                    }
                ])
                ->joinWith(['financerLoanProductLoginFeeStructures d' => function ($d) {
                    $d->select(['d.financer_loan_product_login_fee_structure_enc_id', 'd.financer_loan_product_enc_id', 'd.name', 'd.amount']);
                    $d->onCondition(['d.is_deleted' => 0]);
                }])
                ->joinWith(["financerLoanProductDisbursementCharges e" => function ($e) {
                    $e->select(["e.financer_loan_product_enc_id", "e.disbursement_charges_enc_id", "e.name"]);
                }])
                ->groupBy(['a.financer_loan_product_enc_id'])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->where(['a.is_deleted' => 0])
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
                ->select(['a.financer_loan_product_enc_id', 'a.product_code', 'a.name product_name', 'e1.name loan_type_name', 'a.assigned_financer_loan_type_enc_id'])
                ->joinWith(['financerLoanProductPurposes b' => function ($b) {
                    $b->select(['b.financer_loan_product_purpose_enc_id', 'b.purpose_code', 'b.financer_loan_product_enc_id', 'b.purpose', 'b.sequence']);
                    $b->orderBy(['b.sequence' => SORT_ASC]);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->joinWith(['financerLoanProductDocuments c' => function ($c) {
                    $c->select([
                        'c.financer_loan_product_document_enc_id', 'c.financer_loan_product_enc_id', 'c.certificate_type_enc_id',
                        'c.sequence', 'ct.name name'
                    ]);
                    $c->joinWith(['certificateTypeEnc ct'], false);
                    $c->orderBy(['c.sequence' => SORT_ASC]);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->joinWith(['financerLoanProductStatuses d' => function ($d) {
                    $d->select([
                        'd.financer_loan_product_status_enc_id', 'd.financer_loan_product_enc_id', 'd1.loan_status_enc_id', 'd1.loan_status name',
                        'd1.value', 'd1.sequence'
                    ]);
                    $d->joinWith(['loanStatusEnc d1'], false);
                    $d->onCondition(['d.is_deleted' => 0]);
                    $d->orderBy(['d1.sequence' => SORT_ASC]);
                }])
                ->joinWith(['assignedFinancerLoanTypeEnc e' => function ($e) {
                    $e->select(['e.assigned_financer_loan_type_enc_id']);
                    $e->joinWith(['loanTypeEnc e1'], false);
                }], false)
                ->joinWith(['financerLoanProductProcesses f' => function ($f) {
                    $f->select(['f.financer_loan_product_process_enc_id', 'f.financer_loan_product_enc_id', 'f.process', 'f.sequence']);
                    $f->orderBy(['f.sequence' => SORT_ASC]);
                    $f->onCondition(['f.is_deleted' => 0]);
                }])
                ->joinWith(['financerLoanProductLoginFeeStructures g' => function ($g) {
                    $g->select(['g.financer_loan_product_login_fee_structure_enc_id', 'g.financer_loan_product_enc_id', 'g.name', 'g.amount']);
                    $g->onCondition(['g.is_deleted' => 0]);
                }])
                ->joinWith(['financerLoanProductImages h' => function ($h) {
                    $h->select(['h.product_image_enc_id', 'h.financer_loan_product_enc_id', 'h.name']);
                    $h->orderBy(['h.sequence' => SORT_ASC]);
                    $h->onCondition(['h.is_deleted' => 0]);
                }])
                ->joinWith(['financerLoanProductPendencies i' => function ($i) {
                    $i->select(['i.pendencies_enc_id', 'i.financer_loan_product_enc_id', 'i.name', 'i.type']);
                    $i->onCondition(['i.is_deleted' => 0]);
                }])
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
                    $data['purpose_code'] = $value['purpose_code'];
                    if (!empty($value['financer_loan_product_purpose_enc_id'])) {
                        $purpose = FinancerLoanProductPurpose::findOne([
                            'financer_loan_product_purpose_enc_id' => $value['financer_loan_product_purpose_enc_id'],
                            'is_deleted' => 0
                        ]);
                        if ($purpose) {
                            $purpose->sequence = $key;
                            $purpose->purpose = $value['purpose'];
                            $purpose->purpose_code = $value['purpose_code'];
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

    // create or update loan product process (updated)
    public function actionUpdateLoanProductProcess()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['loan_process'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_process"']);
            }
            if (empty($params['financer_loan_product_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "financer_loan_product_enc_id"']);
            }
            $transaction = Yii::$app->db->beginTransaction();
            $data['financer_loan_product_enc_id'] = $params['financer_loan_product_enc_id'];
            $data['user_enc_id'] = $user->user_enc_id;
            try {
                foreach ($params['loan_process'] as $key => $value) {
                    $data['key'] = $key;
                    $data['process'] = $value['process'];
                    if (!empty($value['financer_loan_product_process_enc_id'])) {
                        $process = FinancerLoanProductProcess::findOne([
                            'financer_loan_product_process_enc_id' => $value['financer_loan_product_process_enc_id'],
                            'is_deleted' => 0
                        ]);
                        if ($process) {
                            $process->sequence = $key;
                            $process->process = $value['process'];
                            $process->updated_by = $user->user_enc_id;
                            $process->updated_on = date('Y-m-d H:i:s');
                            if (!$process->update()) {
                                $transaction->rollBack();
                                return $this->response(500, ['status' => 500, 'message' => 'An error occurred', 'error' => $process->getErrors()]);
                            }
                        } else {
                            $query = $this->__createProcess($data);
                            if ($query['status'] == 500) {
                                $transaction->rollback();
                                return $this->response(500, $query);
                            }
                        }
                    } else {
                        $query = $this->__createProcess($data);
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

    // remove loan product process (updated)
    public function actionRemoveLoanProductProcess()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['financer_loan_product_process_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_product_process_enc_id"']);
            }

            $process = FinancerLoanProductProcess::findOne([
                'financer_loan_product_process_enc_id' => $params['financer_loan_product_process_enc_id'],
                'is_deleted' => 0
            ]);

            if ($process) {
                $process->is_deleted = 1;
                $process->updated_by = $user->user_enc_id;
                $process->updated_on = date('Y-m-d H:i:s');
                if (!$process->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $process->getErrors()]);
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
        $purpose->purpose_code = $data['purpose_code'];
        $purpose->sequence = $data['key'];
        $purpose->created_on = date('Y-m-d H:i:s');
        $purpose->created_by = $data['user_enc_id'];
        if (!$purpose->save()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $purpose->getErrors()];
        }
        return ['status' => 200];
    }

    // used to create product process
    private function __createProcess($data)
    {
        $process = new FinancerLoanProductProcess();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $process->financer_loan_product_process_enc_id = $utilitiesModel->encrypt();
        $process->financer_loan_product_enc_id = $data['financer_loan_product_enc_id'];
        $process->process = $data['process'];
        $process->sequence = $data['key'];
        $process->created_on = date('Y-m-d H:i:s');
        $process->updated_on = date('Y-m-d H:i:s');
        $process->created_by = $data['user_enc_id'];
        $process->updated_by = $data['user_enc_id'];
        if (!$process->save()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $process->getErrors()];
        }
        return ['status' => 200];
    }

    public function actionEmiCollection()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        if (!$org = $user->organization_enc_id) {
            $findOrg = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
            if (!$org = $findOrg['organization_enc_id']) {
                return $this->response(500, ['status' => 500, 'message' => 'Organization not found']);
            }
        }
        $params = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $update_overdue = false;
            if (!empty($params['emi_collection_enc_id']) && !empty($params['status'])) {
                $model = EmiCollectionExtended::findOne(['emi_collection_enc_id' => $params['emi_collection_enc_id']]);
                if ($model) {
                    if ($model->emi_payment_status !== $params['status']) {
                        $update_overdue = true;
                    }
                    $model->emi_payment_status = $params['status'];
                    $model->updated_by = $user->user_enc_id;
                    $model->updated_on = date('Y-m-d h:i:s');
                    if (!$model->save()) {
                        throw new \Exception('an error occurred while updating');
                    }
                    if ($update_overdue) {
                        EmiCollectionForm::updateOverdue($model['loan_account_enc_id'], $model['amount'], $user->user_enc_id);
                    }
                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
                }
            } else {
                $model = new EmiCollectionForm();
                $model->org_id = $org;
                if (!empty($params['loan_account_number'])) {
                    $query = LoanAccountsExtended::findOne(["loan_account_number" => $params['loan_account_number']]);
                    if ($query) {
                        $model->loan_account_enc_id = $query['loan_account_enc_id'];
                    }
                }
                if ($model->load(Yii::$app->request->post()) && !$model->validate()) {
                    return $this->response(422, ['status' => 422, 'message' => \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)]);
                }
                $model->other_doc_image = UploadedFile::getInstance($model, 'other_doc_image');
                $model->borrower_image = UploadedFile::getInstance($model, 'borrower_image');
                $model->pr_receipt_image = UploadedFile::getInstance($model, 'pr_receipt_image');
                $save = $model->save($user->user_enc_id);
                $save['status'] == 200 ? $transaction->commit() : $transaction->rollBack();
                return $this->response($save['status'], $save);
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->response(500, ['status' => 500, 'message' => $exception->getMessage()]);
        }
    }

    public function actionEmiStats()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        if (!$params = Yii::$app->request->post()) {
            return $this->response(500, ['status' => 500, 'message' => 'params not found']);
        }
        if (!empty($params['method'])) {
            $method = [$params['method']];
        }
        $data = EmiCollectionExtended::find()
            ->select([
                'emi_payment_method AS method',
                'emi_payment_status AS status',
                'amount'
            ])
            ->andWhere([
                'and',
                ['between', 'collection_date', $params['start_date'], $params['end_date']],
                ['is_deleted' => 0]
            ]);
        if (!empty($method)) {
            if (in_array('pending', $method)) {
                $data->andWhere(['emi_payment_status' => $method]);
            } else {
                if (in_array(1, $method)) {
                    $method[] = 9;
                }
                if (in_array(4, $method)) {
                    $method[] = 81;
                }
                if (in_array(5, $method)) {
                    $method[] = 82;
                }
                $data->andWhere(['emi_payment_method' => $method]);
            }
        }
        if (!empty($params['loan_type'])) {
            $data->andWhere(['loan_type' => $params['loan_type']]);
        }
        if (!empty($params['branch_enc_id'])) {
            $data->andWhere(['branch_enc_id' => $params['branch_enc_id']]);
        }
        if (empty($user->organization_enc_id) && !in_array($user->username, ['nisha123', 'rajniphf', 'KKB', 'phf604'])) {
            $juniors = UserUtilities::getting_reporting_ids($user->user_enc_id, 1);
            $data = $data->andWhere(['IN', 'created_by', $juniors]);
        }

        $data = $data->asArray()
            ->all();

        $def = EmiCollectionForm::$payment_methods;
        if (!empty($method)) {
            $method = array_merge(['total', 'pending'], $method);
            $def = array_intersect_key($def, array_fill_keys(array_values($method), 0));
        }
        $res = [];
        foreach ($def as $item) {
            $res[$item] = ['payment_method' => $item, 'sum' => 0, 'count' => 0];
            if (!in_array($item, ['Total', 'Pending']) && empty($method)) {
                $res[$item]['pending']['count'] = $res[$item]['pending']['sum'] = 0;
            }
        }
        foreach ($data as $item) {
            $payment_method = $def[$item['method']] ?? '';
            $amount = $item['amount'];
            if ($item['status'] == 'paid') {
                $res[$payment_method]['sum'] += $amount;
                $res[$payment_method]['count'] += 1;
            } else {
                if (empty($method)) {
                    $res[$payment_method]['pending']['count'] += 1;
                    $res[$payment_method]['pending']['sum'] += $amount;
                }
                $res['Pending']['sum'] += $amount;
                $res['Pending']['count'] += 1;
            }
            $res['Total']['sum'] += $amount;
            $res['Total']['count'] += 1;
        }
        return $this->response(200, ['status' => 200, 'data' => array_values($res)]);
    }

    public function actionGetCollectedEmiList()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        $search = '';
        if (empty($params['organization_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "organization_id"']);
        }
        if (isset($params['fields_search'])) {
            $search = $params['fields_search'];
        }

        $org_id = $params['organization_id'];
        $model = $this->_emiData($org_id, 0, $search, $user);
        $count = $model['count'];
        if (!$count > 0) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }
        return $this->response(200, ['status' => 200, 'data' => $model['data'], 'count' => $count]);
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
        $lac = EmiCollectionExtended::findOne(['emi_collection_enc_id' => $params['emi_collection_enc_id']])['loan_account_number'];
        $model = $this->_emiData($lac, 1, '', $user)['data'];
        if (!$model) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }

        $display_data = EmiCollectionExtended::find()
            ->alias('a')
            ->select([
                'ANY_VALUE(a.customer_name) customer_name', 'ANY_VALUE(a.loan_account_number) loan_account_number',
                'ANY_VALUE(a.loan_type) loan_type', 'ANY_VALUE(a.phone) phone', 'SUM(a.amount) total_amount',
                'COUNT(a.loan_account_number) as total_emis',
                "CONCAT(ANY_VALUE(b.location_name) , ', ', COALESCE(ANY_VALUE(b1.name), '')) as branch_name",
                "SUM(CASE WHEN a.emi_payment_status != 'paid' THEN a.amount END) as pending_amount",
                "SUM(CASE WHEN a.emi_payment_status = 'paid' THEN a.amount END) as paid_amount",
            ])
            ->joinWith(['branchEnc b' => function ($b) {
                $b->joinWith(['cityEnc b1'], false);
            }], false)
            ->where(['a.loan_account_number' => $lac, 'a.is_deleted' => 0])
            ->groupBy(['a.loan_account_number'])
            ->asArray()
            ->one();
        return $this->response(200, ['status' => 200, 'display_data' => $display_data, 'data' => $model]);
    }

    public static function _emiData($data, $id_type, $search = '', $user = null)
    {
        // if id_type = 1 then loan account number if id_type = 0 then organization id, this function is being used for GetCollectedEmiList and EmiDetail
        if ($id_type == 1) {
            $lac = $data;
        }
        if ($id_type == 0) {
            $org_id = $data;
        }
        $params = Yii::$app->request->post();
        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $payment_methods = EmiCollectionForm::$payment_methods;
        $payment_modes = EmiCollectionForm::$payment_modes;
        $model = EmiCollectionExtended::find()
            ->alias('a')
            ->select([
                'a.emi_collection_enc_id', "CONCAT(c.location_name , ', ', COALESCE(c1.name, '')) as branch_name", 'a.customer_name', 'a.collection_date',
                'a.loan_account_number', 'a.phone', 'a.amount', 'a.loan_type', 'a.loan_purpose', 'a.emi_payment_method', 'a.emi_payment_mode',
                'a.ptp_amount', 'a.ptp_date', 'b1a.designation', "CONCAT(b.first_name, ' ', COALESCE(b.last_name, '')) name",
                "CASE WHEN a.other_delay_reason IS NOT NULL THEN CONCAT(a.delay_reason, ',',a.other_delay_reason) ELSE a.delay_reason END AS delay_reason",
                "CASE WHEN a.borrower_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->borrower_image->image . "',a.borrower_image_location, '/', a.borrower_image) ELSE NULL END as borrower_image",
                "CASE WHEN a.pr_receipt_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image . "',a.pr_receipt_image_location, '/', a.pr_receipt_image) ELSE NULL END as pr_receipt_image",
                "CASE WHEN a.other_doc_image IS NOT NULL THEN  CONCAT('" . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->other_doc_image->image . "',a.other_doc_image_location, '/', a.other_doc_image) ELSE NULL END as other_doc_image",
                "CONCAT(a.address,', ', COALESCE(a.pincode, '')) address", "CONCAT(b.first_name , ' ', COALESCE(b.last_name, '')) as collected_by", 'a.created_on',
                "CONCAT('http://maps.google.com/maps?q=', a.latitude, ',', a.longitude) AS link",
                'a.comments', 'a.emi_payment_status', 'a.reference_number', 'a.dealer_name', 'd1.payment_short_url'
            ])
            ->joinWith(['createdBy b' => function ($b) {
                $b->joinWith(['userRoles0 b1' => function ($b1) {
                    $b1->joinWith(['designation b1a'], false);
                }], false);
            }], false)
            ->joinWith(['branchEnc c' => function ($c) {
                $c->joinWith(['cityEnc c1'], false);
            }], false)
            ->joinWith(['assignedLoanPayments d' => function ($d) {
                $d->joinWith(['loanPaymentsEnc d1'], false);
            }], false)
            ->orderBy(['a.created_on' => SORT_DESC])
            ->andWhere(['a.is_deleted' => 0]);

        if (isset($org_id)) {
            $model->andWhere(['or', ['b.organization_enc_id' => $org_id], ['b1.organization_enc_id' => $org_id]]);
        }
        if (empty($user->organization_enc_id) && !in_array($user->username, ['nisha123', 'rajniphf', 'KKB', 'phf604'])) {
            $juniors = UserUtilities::getting_reporting_ids($user->user_enc_id, 1);
            $model->andWhere(['IN', 'a.created_by', $juniors]);
        }
        if (isset($lac)) {
            $model->andWhere(['a.loan_account_number' => $lac]);
        }

        if (!empty($search)) {
            $a = ['loan_account_number', 'customer_name', 'collection_date', 'amount', 'loan_type', 'emi_payment_method', 'ptp_amount', 'ptp_date', 'delay_reason', 'address', 'emi_payment_status'];
            $others = ['collected_by', 'branch', 'designation', 'payment_status', 'ptp_status'];
            foreach ($search as $key => $value) {
                if (!empty($value) || $value == '0') {
                    if (in_array($key, $a)) {
                        if ($key == 'amount') {
                            $model->andWhere(['like', 'a.amount', $value . '%', false]);
                        } elseif ($key == 'address') {
                            $model->andWhere(['like', "CONCAT(a.address,', ', COALESCE(a.pincode, ''))", $value]);
                        } elseif ($key == 'ptp_amount') {
                            $model->andWhere(['like', 'a.ptp_amount', $value . '%', false]);
                        } elseif ($key == 'emi_payment_method') {
                            if (in_array($value, $val = [4, 81])) {
                                $model->andWhere(['in', 'a.' . $key, $val]);
                            } elseif (in_array($value, $val = [5, 82])) {
                                $model->andWhere(['in', 'a.' . $key, $val]);
                            } elseif (in_array($value, $val = [1, 9])) {
                                $model->andWhere(['in', 'a.' . $key, $val]);
                            } else {
                                $model->andWhere(['a.' . $key => $value]);
                            }
                        } else {
                            $model->andWhere(['like', 'a.' . $key, $value]);
                        }
                    }
                    if (in_array($key, $others)) {
                        if ($key == 'collected_by') {
                            $model->andWhere(['like', "CONCAT(b.first_name , ' ', COALESCE(b.last_name, ''))", $value]);
                        } elseif ($key == 'branch') {
                            $model->andWhere(['c.location_enc_id' => $value]);
                        } elseif ($key == 'designation') {
                            $model->andWhere(['like', 'b1a.' . $key, $value]);
                        } elseif ($key == 'ptp_status') {
                            $model->andWhere([$value == 'yes' ? 'not in' : 'in', 'a.ptp_amount', [null, '']]);
                        }
                    }
                }
            }
        }
        $count = $model->count();

        $model = $model
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        foreach ($model as $key => $value) {
            $model[$key]['emi_payment_method'] = $payment_methods[$value['emi_payment_method']];
            $model[$key]['emi_payment_mode'] = $payment_modes[$value['emi_payment_mode']];
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
        return ['data' => $model, 'count' => $count];
    }

    public function actionUpdateLoanProductFees()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['product_no_dues'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "product_no_dues"']);
            }
            if (empty($params['financer_loan_product_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "financer_loan_product_enc_id"']);
            }
            $transaction = Yii::$app->db->beginTransaction();
            $data['financer_loan_product_enc_id'] = $params['financer_loan_product_enc_id'];
            $data['user_enc_id'] = $user->user_enc_id;
            try {
                foreach ($params['product_no_dues'] as $key => $value) {
                    $data['name'] = $value['name'];
                    $data['amount'] = $value['amount'];
                    if (!empty($value['financer_loan_product_login_fee_structure_enc_id'])) {
                        $fees = FinancerLoanProductLoginFeeStructure::findOne([
                            'financer_loan_product_login_fee_structure_enc_id' => $value['financer_loan_product_login_fee_structure_enc_id'],
                            'is_deleted' => 0
                        ]);
                        if ($fees) {
                            $fees->name = $value['name'];
                            $fees->amount = $value['amount'];
                            $fees->updated_by = $user->user_enc_id;
                            $fees->updated_on = date('Y-m-d H:i:s');
                            if (!$fees->update()) {
                                $transaction->rollBack();
                                return $this->response(500, ['status' => 500, 'message' => 'An error occurred', 'error' => $fees->getErrors()]);
                            }
                        } else {
                            $query = $this->__createFees($data);
                            if ($query['status'] == 500) {
                                $transaction->rollback();
                                return $this->response(500, $query);
                            }
                        }
                    } else {
                        $query = $this->__createFees($data);
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

    public function actionRemoveLoanProductFees()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['financer_loan_product_login_fee_structure_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "financer_loan_product_login_fee_structure_enc_id"']);
            }

            $fees = FinancerLoanProductLoginFeeStructure::findOne([
                'financer_loan_product_login_fee_structure_enc_id' => $params['financer_loan_product_login_fee_structure_enc_id'],
                'is_deleted' => 0
            ]);

            if ($fees) {
                $fees->is_deleted = 1;
                $fees->updated_by = $user->user_enc_id;
                $fees->updated_on = date('Y-m-d H:i:s');
                if (!$fees->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred', 'error' => $fees->getErrors()]);
                }
                return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
            }
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function __createFees($data)
    {
        $fees = new FinancerLoanProductLoginFeeStructure();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $fees->financer_loan_product_login_fee_structure_enc_id = $utilitiesModel->encrypt();
        $fees->financer_loan_product_enc_id = $data['financer_loan_product_enc_id'];
        $fees->name = $data['name'];
        $fees->amount = $data['amount'];
        $fees->created_on = date('Y-m-d H:i:s');
        $fees->updated_on = date('Y-m-d H:i:s');
        $fees->created_by = $data['user_enc_id'];
        $fees->updated_by = $data['user_enc_id'];
        if (!$fees->save()) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $fees->getErrors()];
        }
        return ['status' => 200];
    }

    public function actionDeleteEmi()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (empty($params['emi_collection_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing parameter "emi_collection_enc_id"']);
            }
            $removeEmi = EmiCollectionExtended::findOne(['emi_collection_enc_id' => $params['emi_collection_enc_id']]);
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
            $emiList = EmiCollectionExtended::find()
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
        $params = Yii::$app->request->post();
        $notice = new FinancerNoticeBoard();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        if (isset($params['type'])) {
            if ($params['type'] == '0') {
                if (!$image = UploadedFile::getInstanceByName('image')) {
                    return $this->response(401, ['status' => 401, 'message' => 'image missing']);
                }
                $type = explode('/', $image->type)[1];
                $notice->image = $utilitiesModel->encrypt() . '.' . $type;
                $notice->image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->notice->image . $notice->image_location;
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . DIRECTORY_SEPARATOR . $notice->image, "public", ['params' => ['ContentType' => $type]]);
                if (!$result) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred while saving image']);
                }
            } else {
                $notice->notice = $params['notice'];
            }
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'missing parameter "type"']);
        }
        $notice->type = $params['type'];
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
            ->select([
                'a.notice_enc_id',
                'a.notice', 'a.type',
                'a.created_on'
            ])
            ->addSelect([
                "(CASE WHEN a.status = 'Active' THEN TRUE ELSE FALSE END) as status",
                "(CASE WHEN a.image IS NOT NULL THEN CONCAT('" . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->notice->image, "https") . "', a.image_location, '/', a.image) ELSE NULL END) as image"
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

    public function actionUpdateLoanProductImages()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['financer_loan_product_enc_id']) || empty($params['images'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing parameter "financer_loan_product_enc_id or images"']);
        }
        $product_id = $params['financer_loan_product_enc_id'];
        $transaction = Yii::$app->db->beginTransaction();
        foreach ($params['images'] as $key => $value) {
            if (empty($value['product_image_enc_id']) || !$image = self::_imageCheck($value['product_image_enc_id'], $product_id)) {
                $image = new FinancerLoanProductImages();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $image->product_image_enc_id = $utilitiesModel->encrypt();
                $image->financer_loan_product_enc_id = $product_id;
                $image->created_by = $user->user_enc_id;
                $image->created_on = date('Y-m-d H:i:s');
            }
            $image->name = $value['name'];
            $image->sequence = $key;
            $image->updated_by = $user->user_enc_id;
            $image->updated_on = date('Y-m-d H:i:s');
            if (!$image->save()) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $image->getErrors()]);
            }
        }
        $transaction->commit();
        return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
    }

    private function _imageCheck($image_id, $product_id)
    {
        $image = FinancerLoanProductImages::findOne([
            'product_image_enc_id' => $image_id,
            'financer_loan_product_enc_id' => $product_id,
            'is_deleted' => 0
        ]);
        return $image ?? false;
    }

    public function actionRemoveLoanProductImage()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['product_image_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "product_image_enc_id"']);
        }
        $image = FinancerLoanProductImages::findOne([
            'product_image_enc_id' => $params['product_image_enc_id'],
            'is_deleted' => 0
        ]);
        if (!$image) {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
        $image->is_deleted = 1;
        $image->updated_by = $user->user_enc_id;
        $image->updated_on = date('Y-m-d H:i:s');
        if (!$image->update()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $image->getErrors()]);
        }
        return $this->response(200, ['status' => 200, 'message' => 'Deleted Successfully']);
    }

    public function actionUploadApplicationImage()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['product_image_enc_id']) || empty($params['loan_app_enc_id']) || empty($params['image'])) {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information "product_image_enc_id or loan_app_enc_id or image"']);
        }
        $image_enc_check = FinancerLoanProductImages::findOne(['product_image_enc_id' => $params['product_image_enc_id']]);
        if (!$image_enc_check) {
            return $this->response(404, ['status' => 404, 'message' => 'Product image enc id not found']);
        }
        $image_parts = explode(";base64,", $params['image']);
        $image_base64 = base64_decode($image_parts[1]);
        $ext = explode('/', $image_parts[0])[1];
        $image = new LoanApplicationImagesExtended();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $image->loan_application_image_enc_id = $utilitiesModel->encrypt();
        $image->product_image_enc_id = $params['product_image_enc_id'];
        $image->loan_app_enc_id = $params['loan_app_enc_id'];
        $image->name = $image_enc_check['name'];
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $image->image = $utilitiesModel->encrypt() . '.' . $ext;
        $image->image_location = Yii::$app->getSecurity()->generateRandomString();
        $path = Yii::$app->params->upload_directories->loan_images->image;
        $base_path = $path . $image->image_location . DIRECTORY_SEPARATOR . $image->image;
        $type = 'image/' . $ext;
        $file = dirname(__DIR__, 4) . '/files/temp/' . $image->image;
        if (file_put_contents($file, $image_base64)) {
            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path, "private", ['params' => ['ContentType' => $type]]);
            if (!$result) {
                throw new \Exception('error occurred while uploading image');
            }
            if (file_exists($file)) {
                unlink($file);
            }
        }
        $image->created_on = date('Y-m-d H:i:s');
        $image->created_by = $user->user_enc_id;
        if (!$image->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $image->getErrors()]);
        }
        return $this->response(200, ['status' => 200, 'message' => 'Saved Successfully']);
    }

    public function actionGetAssignedImages()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $lender = $this->getFinancerId($user);
        if (!$lender) {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
        $subquery = (new \yii\db\Query())
            ->select([])
            ->from(['c' => FinancerLoanProductImages::tableName()])
            ->andWhere(['c.is_deleted' => 0])
            ->orderBy(['c.sequence' => SORT_ASC])
            ->andWhere(['c.is_deleted' => 0]);

        $images = FinancerLoanProducts::find()
            ->alias('a')
            ->select(['a.financer_loan_product_enc_id', 'a.name'])
            ->joinWith(['assignedFinancerLoanTypeEnc b'], false, 'INNER JOIN')
            ->innerJoinWith([
                'financerLoanProductImages c' => function ($k) use ($subquery) {
                    $k->from(['subquery' => $subquery]);
                }
            ])
            ->where([
                'b.organization_enc_id' => $lender,
                'a.is_deleted' => 0,
                'b.is_deleted' => 0,
            ])
            ->groupBy(['a.financer_loan_product_enc_id'])
            ->asArray()
            ->all();
        if ($images) {
            return $this->response(200, ['status' => 200, 'images' => $images]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
    }

    public function actionSearchEmi()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (!empty($params['loan_number'])) {
            $query = LoanAccountsExtended::find()
                ->select(['loan_account_enc_id', 'loan_account_number', 'name', 'phone', 'emi_amount', 'overdue_amount', 'ledger_amount', 'loan_type', 'emi_date'])
                ->where(['is_deleted' => 0])
                ->andWhere([
                    'or',
                    ['like', 'loan_account_number', '%' . $params['loan_number'] . '%', false],
                    ['like', 'phone', '%' . $params['loan_number'] . '%', false],

                ])
                ->limit(20)
                ->asArray()
                ->all();
            if ($query) {
                return $this->response(200, ['status' => 200, 'data' => $query]);
            }
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionGetEmiAccounts()
    {
        $this->isAuth();
        $params = $this->post;
        $user = $this->user;
        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $query = LoanAccountsExtended::find()
            ->alias("a")
            ->select([
                "a.loan_account_enc_id", "a.total_installments", "a.financed_amount", "a.stock",
                "a.advance_interest", "a.bucket", "a.branch_enc_id", "a.bucket_status_date", "a.pos",
                "a.loan_account_number", "a.last_emi_date", "a.name",
                "a.emi_amount", "a.overdue_amount", "a.ledger_amount", "a.loan_type", "a.emi_date",
                "a.created_on", "a.last_emi_received_amount", "CONCAT(cm.first_name, ' ', COALESCE(cm.last_name, '')) as collection_manager",
                "a.last_emi_received_date", "b.location_enc_id as branch", "b.location_name as branch_name", "CONCAT(ac.first_name, ' ', COALESCE(ac.last_name, '')) as assigned_caller"
            ])
            ->joinWith(["branchEnc b"], false)
            ->joinWith(["assignedCaller ac"], false)
            ->joinWith(["collectionManager cm"], false)
            ->andWhere(["a.is_deleted" => 0]);

        if (!empty($params["fields_search"])) {
            foreach ($params["fields_search"] as $key => $value) {
                if (!empty($value) || $value == "0") {
                    if ($key == 'assigned_caller') {
                        $query->andWhere(["like", "CONCAT(ac.first_name, ' ', COALESCE(ac.last_name, ''))", "$value%", false]);
                    } elseif ($key == 'bucket') {
                        $query->andWhere(['IN', 'a.bucket', $value]);
                    } elseif ($key == 'loan_type') {
                        $query->andWhere(['IN', 'a.loan_type', $value]);
                    } elseif ($key == 'branch') {
                        $query->andWhere(['IN', 'b.location_enc_id', $value]);
                    } elseif ($key == 'collection_manager') {
                        $query->andWhere(["like", "CONCAT(cm.first_name, ' ', COALESCE(cm.last_name, ''))", "$value%", false]);
                    } else {
                        $query->andWhere(["like", $key, "$value%", false]);
                    }
                }
            }
        }
        if (!$this->isSpecial(1)) {
            $juniors = UserUtilities::getting_reporting_ids($user->user_enc_id, 1);
            $query->andWhere([
                "OR",
                ["IN", "a.assigned_caller", $juniors],
                ["IN", "a.collection_manager", $juniors],
                ["IN", "a.created_by", $juniors],
            ]);
        }
        if (!empty($params["bucket"])) {
            $query->andWhere(["a.bucket" => $params["bucket"]]);
        }
        $count = $query->count();
        $query = $query->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($query) {
            return $this->response(200, ["status" => 200, "data" => $query, "count" => $count]);
        }

        return $this->response(404, ["status" => 404, "message" => "data not found"]);
    }


    public function actionUpdatePendency()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ["status" => 401, "message" => "unauthorised"]);
        }
        $params = Yii::$app->request->post();
        if (empty($params["financer_loan_product_enc_id"]) && !$params["delete"]) {
            return $this->response(422, ["status" => 422, "message" => "missing parameter 'financer_loan_product_enc_id'"]);
        }
        if (UserUtilities::getUserType($user->user_enc_id) != "Financer") {
            return $this->response(500, ["status" => 500, "message" => "permission denied"]);
        }
        $user = $user->user_enc_id;
        $time = date("Y-m-d H:i:s");
        if (!empty($params["pendencies_enc_id"])) {
            $pendency = FinancerLoanProductPendencies::findOne(["pendencies_enc_id" => $params["pendencies_enc_id"]]);
            if (!$pendency) {
                return $this->response(404, ["status" => 404, "message" => "Pendency not Found"]);
            }
            if (!empty($params["delete"])) {
                $pendency->is_deleted = 1;
            }
        } else {
            $pendency = new FinancerLoanProductPendencies();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables["string"] = time() . rand(100, 100000);
            $pendency->financer_loan_product_enc_id = $params["financer_loan_product_enc_id"];
            $pendency->pendencies_enc_id = $utilitiesModel->encrypt();
            $pendency->created_by = $user;
            $pendency->created_on = $time;
        }
        if (empty($params["delete"])) {
            $pendency->name = $params["name"];
            $pendency->type = $params["type"];
        }
        $pendency->updated_by = $user;
        $pendency->updated_on = $time;
        if (!$pendency->save()) {
            return $this->response(500, ["status" => 500, "message" => "an error occurred", "error" => $pendency->getErrors()]);
        }
        return $this->response(200, ["status" => 200, "message" => "success"]);
    }

    public function actionEmiRefCheck()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ["status" => 401, "message" => "unauthorised"]);
        }
        $params = Yii::$app->request->post();
        if (empty($params["ref"])) {
            return $this->response(422, ["status" => 422, "message" => "missing parameter 'ref'"]);
        }
        $emi = EmiCollectionExtended::findOne(["reference_number" => $params["ref"]]);
        if ($emi) {
            return $this->response(201, ["status" => 201, "message" => "Already exists"]);
        }
        return $this->response(200, ["status" => 200, "message" => "Doesn't exist"]);
    }
}
