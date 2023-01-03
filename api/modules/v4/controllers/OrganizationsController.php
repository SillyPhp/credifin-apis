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
                ->select(['a.location_enc_id', 'a.location_name', 'a.location_for', 'a.address', 'b.name city', 'b.city_enc_id', 'a.status'])
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
            $documentsList = CertificateTypes::find()->asArray()->all();
            return $this->response(200, ['status' => 200, 'documents_list' => $documentsList]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAssignDocument()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['certificate_type']) || empty($params['assigned_financer_loan_type_id']) || empty($params['sequence'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "certificate_type, assigned_financer_loan_type_id, sequence"']);
            }

            $certificate_id = $this->__getCertificateTypeId($params['certificate_type']);

            if (!$certificate_id) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred while getting certificate type']);
            }

            $loan_documents = new FinancerLoanDocuments();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(10, 100000);
            $loan_documents->financer_loan_document_enc_id = $utilitiesModel->encrypt();
            $loan_documents->assigned_financer_loan_type_id = $params['assigned_financer_loan_type_id'];
            $loan_documents->certificate_type_enc_id = $certificate_id;
            $loan_documents->sequence = $params['sequence'];
            $loan_documents->created_by = $user->user_enc_id;
            $loan_documents->created_on = date('Y-m-d H:i:s');
            if (!$loan_documents->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_documents->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function __getCertificateTypeId($certificate)
    {
        $certificate = CertificateTypes::findOne(['name' => $certificate]);

        if ($certificate) {
            return $certificate->certificate_type_enc_id;
        }

        $certificate = new CertificateTypes();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $certificate->certificate_type_enc_id = $utilitiesModel->encrypt();
        $certificate->name = $certificate;
        if ($certificate->save()) {
            return $certificate->certificate_type_enc_id;
        }

        return false;
    }
}