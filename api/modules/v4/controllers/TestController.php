<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\LoanApplication;
use common\models\AssignedFinancerLoanType;
use common\models\AssignedLoanProvider;
use common\models\Cities;
use common\models\CreditLoanApplicationReports;
use common\models\Designations;
use common\models\extended\LoanApplicationsExtended;
use common\models\FinancerLoanProductPurpose;
use common\models\FinancerLoanProducts;
use common\models\FinancerLoanPurpose;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanApplicationOptions;
use common\models\LoanApplications;
use common\models\LoanCoApplicants;
use common\models\OrganizationLocations;
use common\models\OrganizationTypes;
use common\models\SharedLoanApplications;
use common\models\spaces\Spaces;
use common\models\SponsoredCourses;
use common\models\States;
use common\models\UserRoles;
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
                'index' => ['GET', 'POST', 'OPTIONS'],

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

    public function actionTest()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (empty($params['user_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "user_enc_id"']);
            }
            if (empty($params['loan_app_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information "loan_app_enc_id"']);
            }
            $data1 = [];
            $data2 = ['loan_id' => $params['loan_app_enc_id'], 'user_id' => $params['user_enc_id']];
            $user_id = $params['user_enc_id'];
            while (true) {
                $query = UserRoles::find()
                    ->alias('a')
                    ->select(['a.reporting_person'])
                    ->where(['a.user_enc_id' => $user_id, 'a.is_deleted' => 0])
                    ->asArray()
                    ->one();
                if (!empty($query['reporting_person'])) {
                    $data1[] = $user_id = $query['reporting_person'];
                } else {
                    $transaction = Yii::$app->db->beginTransaction();
                    $query = $this->__test($data1, $data2);
                    if ($query['status'] == 500) {
                        $transaction->rollback();
                        return $this->response(500, $query);
                    }
                    $transaction->commit();
                    return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
                }
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function __test($data1, $data2)
    {
        foreach ($data1 as $key => $value) {
            $query = new SharedLoanApplications();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $query->shared_loan_app_enc_id = $utilitiesModel->encrypt();
            $query->loan_app_enc_id = $data2['loan_id'];
            $query->shared_by = $data2['user_id'];
            $query->shared_to = $value;
            $query->access = 'Full Access';
            $query->status = 'Active';
            $query->created_by = $data2['user_id'];
            $query->created_on = date('Y-m-d H:i:s');
            if (!$query->save()) {
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $query->getErrors()];
            }
        }
        return ['status' => 200];
    }

    public function actionShifter()
    {
        if ($user = $this->isAuthorized()) {
            $query1 = FinancerLoanPurpose::find()
                ->alias('a')
                ->select(['a.assigned_financer_loan_type_id', 'a.purpose', 'a.sequence', 'a.created_by', 'a.created_on', 'a.updated_by', 'a.updated_on'])
                ->where(['is_deleted' => 0])
                ->asArray()
                ->all();
            $transaction = Yii::$app->db->beginTransaction();
            foreach ($query1 as $key => $value) {
                $query2 = FinancerLoanProducts::findOne(['assigned_financer_loan_type_enc_id' => $value['assigned_financer_loan_type_id'], 'is_deleted' => 0]);
                if (!empty($query2)) {
                    $query3 = new FinancerLoanProductPurpose();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $query3->financer_loan_product_purpose_enc_id = $utilitiesModel->encrypt();
                    $query3->financer_loan_product_enc_id = $query2['financer_loan_product_enc_id'];
                    $query3->purpose = $value['purpose'];
                    $query3->sequence = $value['sequence'];
                    $query3->created_by = $value['created_by'];
                    $query3->created_on = $value['created_on'];
                    $query3->updated_by = $value['updated_by'];
                    $query3->updated_on = $value['updated_on'];
                    if (!$query3->save()) {
                        $transaction->rollBack();
                        return ['status' => 500, 'message' => 'an error occurred', 'error' => $query3->getErrors()];
                    }
                } else {
                    $transaction->rollBack();

                    return 'no';
                }
            }
            $transaction->commit();
            return 'Done';
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}