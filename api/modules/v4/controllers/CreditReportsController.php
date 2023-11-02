<?php

namespace api\modules\v4\controllers;

use common\models\CreditLoanApplicationReports;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use Yii;
use common\models\CreditReportsControllers;
use yii\web\UploadedFile;
use common\models\Utilities;


class CreditReportsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'list' => ['POST', 'OPTIONS'],
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

    public function actionList()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            $limit = 10;
            $page = 1;

            if (isset($params['limit']) && !empty($params['limit'])) {
                $limit = $params['limit'];
            }
            if (isset($params['page']) && !empty($params['page'])) {
                $page = $params['page'];
            }

            $creditReport = CreditLoanApplicationReports::find()
                ->distinct()
                ->alias('a')
                ->select(['a.loan_app_enc_id', 'b.applicant_name', 'b.loan_type', 'c.file_url', 'c.created_by', 'c1.request_source', "CONCAT(d.first_name,' ',d.last_name) created_by_name",'e.name as co_applicant_name','e.relation','e.borrower_type'])
                ->joinWith(['loanAppEnc b' => function ($b) {
                    $b->joinWith(['assignedLoanProviders b1']);
                }], false)
                ->joinWith(['responseEnc c' => function ($c) {
                    $c->joinWith(['requestEnc c1' => function ($c1) {
                    }]);
                }], false)
                ->joinWith(['createdBy d'], false)
                ->joinWith(['loanCoAppEnc e'], false)
                ->andWhere(['b1.provider_enc_id' => $user->organization_enc_id,'b1.is_deleted' => 0]);

            if (isset($params['keyword']) && !empty($params['keyword'])) {
                $creditReport->andWhere([
                    'or',
                    ['like', 'b.applicant_name', $params['keyword']],
                    ['like', 'e.name', $params['keyword']],
                    ['like', 'concat(d.first_name," ",d.last_name)', $params['keyword']],
                    ['like', 'b.loan_type', $params['keyword']],
                ]);
            }

            $count = $creditReport->count();
                $creditReport = $creditReport
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'data' => $creditReport,'count'=> $count]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
    }

}