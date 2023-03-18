<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\LoanApplication;
use common\models\AssignedLoanProvider;
use common\models\Cities;
use common\models\Designations;
use common\models\LoanApplicationOptions;
use common\models\LoanApplications;
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
                'updating-loan-type'=> ['POST', 'OPTIONS'],
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


}


