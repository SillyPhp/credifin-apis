<?php

namespace api\modules\v4\controllers;

use common\models\CreditLoanApplicationReports;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;


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
                ->select(['a.loan_app_enc_id',
                    'b.applicant_name', 'b.loan_type',
                    'c.file_url', 'c.created_by',
                    'c1.request_source',
                    "CONCAT(d.first_name,' ', COALESCE(d.last_name, '')) as created_by_name",
                    'e.name as co_applicant_name', 'e.relation', 'e.borrower_type', 'b2.financer_loan_product_enc_id',
                    'b2.name as loan_product'
                ])
                ->joinWith(['loanAppEnc b' => function ($b) {
                    $b->joinWith(['assignedLoanProviders b1']);
                    $b->joinWith(['loanProductsEnc b2']);
                }], false)
                ->joinWith(['responseEnc c' => function ($c) {
                    $c->joinWith(['requestEnc c1' => function ($c1) {
                    }]);
                }], false)
                ->joinWith(['createdBy d'], false)
                ->joinWith(['loanCoAppEnc e'], false)
                ->andWhere(['b1.provider_enc_id' => $user->organization_enc_id, 'b1.is_deleted' => 0]);

            if (!empty($params['fields_search'])) {
                foreach ($params['fields_search'] as $key => $value) {
                    if (!empty($value)) {
                        if ($key == 'applicant_name') {
                            $creditReport->andWhere(['like', 'e.name', $value]);
                        } elseif ($key == 'loan_product_enc_id') {
                            $creditReport->andWhere(['IN', 'b2.financer_loan_product_enc_id', $value]);
                        } elseif ($key == 'request_source') {
                            $creditReport->andWhere(['like', 'c1.' . $key, $value]);
                        } elseif ($key == 'created_by_name') {
                            $creditReport->andWhere(['like', "CONCAT(d.first_name,' ',COALESCE(d.last_name))", $value]);
                        } else {
                            $creditReport->andWhere(['like', $key, $value]);
                        }
                    }
                }
            }

            if (isset($params['keyword']) && !empty($params['keyword'])) {
                $creditReport->andWhere([
                    'or',
                    ['like', 'b.applicant_name', $params['keyword']],
                    ['like', 'e.name', $params['keyword']],
                    ['like', "CONCAT(d.first_name,' ', COALESCE(d.last_name, ''))", $params['keyword']],
                    ['like', 'b.loan_type', $params['keyword']],
                ]);
            }

            $count = $creditReport->count();
            $creditReport = $creditReport
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'data' => $creditReport, 'count' => $count]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
    }

}