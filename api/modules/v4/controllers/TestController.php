<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\LoanApplication;
use common\models\AssignedLoanProvider;
use common\models\Cities;
use common\models\Designations;
use common\models\extended\LoanApplicationsExtended;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanApplicationOptions;
use common\models\LoanApplications;
use common\models\LoanCoApplicants;
use common\models\OrganizationLocations;
use common\models\OrganizationTypes;
use common\models\spaces\Spaces;
use common\models\SponsoredCourses;
use common\models\States;
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
                'main' => ['GET', 'POST', 'OPTIONS'],
                'updating-loan-type' => ['POST', 'OPTIONS'],
                'new' => ['POST', 'OPTIONS'],
                'try' => ['POST', 'OPTIONS'],

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

    public function actionIndex()
    {
        if ($this->isAuthorized()) {
            $params = Yii::$app->request->post();
            print_r($params['name']);
            die();
            return $this->response(200, ['status' => 200, 'message' => 'success']);
        } else
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
    }

    public function actionMain()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            $todayDate = date('Y-m-d H:i:s');
            $previousDate = date_create($todayDate)->modify('-30 day')->format('Y-m-d H:i:s');
//            $loan = LoanApplications::find()
//                ->alias('a')
//                ->select(['COUNT(b.loan_application_enc_id) count','b1.location_name'])
//                ->joinWith(['assignedLoanProviders b' => function ($b) {
//                    $b ->joinWith(['branchEnc b1']);
//                }], false)
//                ->andWhere(['b.provider_enc_id'=>$user->organization_enc_id])
//                ->andWhere(['between','a.created_on',$previousDate,$todayDate]);
//
//            if(isset($params['branch_enc_id'])&& !empty($params['branch_enc_id'])) {
//                $loan->andWhere(['branch_enc_id' => $params['branch_enc_id']]);
//            }
//                //->andWhere(['branch_enc_id'=>'b1.id'])
//            $loan=$loan
//                //->groupBy(['b.loan_application_enc_id'])
//                ->groupBy(['b.branch_enc_id'])
//                ->all();
//            return $this->response(200,['status'=>200,'data'=>$loan]);
//        } else{
//            return $this->response(401,['status'=>401,'message'=>'unauthorised']);
//        };
//
//        $loan = $loan
//            ->orderBy(['b1.id' => SORT_DESC])
//            ->limit($limit)
//            ->offset(($page - 1) * $limit)
//            ->asArray()
//            ->all();

            $data = (new \yii\db\Query())
                ->distinct()
                ->select(['COUNT(b.loan_application_enc_id) count', 'c.location_name', 'b.branch_enc_id', 'b.created_on'])
                ->from(LoanApplications::tableName() . 'as a')
                ->leftJoin(AssignedLoanProvider::tableName() . 'as b', 'b.loan_application_enc_id = a.loan_app_enc_id')
                ->leftJoin(OrganizationLocations::tableName() . 'as c', 'c.location_enc_id = b.branch_enc_id')
                ->andWhere(['b.provider_enc_id' => $user->organization_enc_id])
                ->andWhere(['between', 'a.created_on', $previousDate, $todayDate])
                ->groupBy(['b.branch_enc_id']);

            if (isset($params['branch_enc_id']) && !empty($params['branch_enc_id'])) {
                $data->andWhere(['b.branch_enc_id' => $params['branch_enc_id']]);
            }
            return $this->response(200, ['status' => 200, 'data' => $data->all()]);
        }
    }


    public function actionNew()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();
            if (empty($params['address']) || empty($params['applicant_name'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "address, city_id"']);
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {


            $loanApp = new LoanApplications();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $loanApp->loan_app_enc_id = $utilitiesModel->encrypt();
            $loanApp->created_by = $user->user_enc_id;
            $loanApp->applicant_name = $params['applicant_name'];
            $loanApp->phone = $params['phone'];
            $loanApp->source = 'EmpowerFintech';


            if (!$loanApp->save()) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loanApp->getErrors()]);
            }
            $loanCoApp = new LoanCoApplicants();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $loanCoApp->loan_co_app_enc_id = $utilitiesModel->encrypt();
            $loanCoApp->name = $params['co_name'];
            $loanCoApp->loan_app_enc_id = $loanApp->loan_app_enc_id;
            $loanCoApp->relation = $params['relation'];
            $loanCoApp->email = $params['co_email'];

            if (!$loanCoApp->save()) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loanCoApp->getErrors()]);
            }
            $loanRes = new LoanApplicantResidentialInfo();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $loanRes->loan_app_res_info_enc_id = $utilitiesModel->encrypt();
            $loanRes->created_by = $user->user_enc_id;
            $loanRes->address = $params['address'];
            $loanRes->loan_co_app_enc_id = $loanCoApp->loan_co_app_enc_id;
            $loanRes->city_enc_id = $params['city_id'];

            if (!$loanRes->save()) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loanRes->getErrors()]);
            }
                $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
            } catch (\Exception $exception) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()]);
            }
            } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

//        $params = Yii::$app->request->post();
//        if ($user = $this->isAuthorized()) {
//            $new = LoanApplications::find()
//                ->alias('a')
//                ->select(['a.loan_app_enc_id', 'a.applicant_name', 'a.email',])
//                ->joinWith(['LoanCoApplicants b' => function ($b) {
//                    $b->joinWith(['LoanApplicantResidentialInfo b1']);
//                }], false)
//                ->where(['a.id' => $params['loan_id'], 'a.created_by' => $user->user_enc_id])
//                ->asArray()
//                ->one();
//
//            if ($new) {
//                return $this->response(200, ['status' => 200, 'detail' => $new]);
//            }
//        }

    public function actionTry()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            $loan = LoanApplications::find()
                ->distinct()
                ->alias('a')
                ->select(['a.loan_app_enc_id', 'a.application_number', 'a.applicant_name', 'a.is_deleted', 'a.created_by', 'a.created_on', 'b.created_on'])
                ->joinWith(['loanCoApplicants b' => function ($b) {
                    $b->joinWith(['loanApplicantResidentialInfos b1']);
                    $b->select(['b.loan_app_enc_id',
                        'b.name','b1.type','b1.address']);
                }])
                ->where(['a.loan_app_enc_id' => $params['loan_id'], 'a.is_deleted' => 0])
                ->asArray()
                ->one();
            return $this->response(200, ['status' => 200, 'detail' => $loan, 'message' => 'successfully']);
        }
    }
}
