<?php

namespace api\modules\v4\controllers;

use common\models\extended\LoanAccountsExtended;
use common\models\LoanApplications;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;


class StatsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
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

    public function actionGetData()
    {
        $params = Yii::$app->request->get();

        $keyword = isset($params['keyword']) ? urldecode($params['keyword']) : null;
        $keyword = str_replace('%', ' ', $keyword);
        $keyword = preg_replace('/[^a-zA-Z0-9\s\-]/', '', $keyword);
        $keyword = str_replace('%20', ' ', $keyword);

        $color = [
            'X' => 'green',
            '1' => 'green',
            '2' => 'blue',
            '3' => 'red',
            '4' => 'yellow',
            '5' => 'orange',
            '6' => 'purple',
            '7' => 'cyan',
            '8' => 'magenta',
        ];

        $loan_types = [];
        $case = '';

        if (isset($params['hr'])) {
            $case .= " WHEN ((a.overdue_amount / a.emi_amount) * 30) > 60 AND ((a.overdue_amount / a.emi_amount) * 30) <= 75 THEN 5
                    WHEN ((a.overdue_amount / a.emi_amount) * 30) > 75 AND ((a.overdue_amount / a.emi_amount) * 30) <= 90 THEN 6
                    WHEN ((a.overdue_amount / a.emi_amount) * 30) > 90 AND ((a.overdue_amount / a.emi_amount) * 30) <= 120 THEN 7
        WHEN (a.overdue_amount / a.emi_amount) * 30 >= 120 THEN 8";
        } elseif (isset($params['lr'])) {
            $case .= " WHEN ((a.overdue_amount / a.emi_amount) * 30) <= 0 THEN 'X'
                    WHEN ((a.overdue_amount / a.emi_amount) * 30) >= 0 AND ((a.overdue_amount / a.emi_amount) * 30) <= 15 THEN 1
                    WHEN ((a.overdue_amount / a.emi_amount) * 30) > 15 AND ((a.overdue_amount / a.emi_amount) * 30) <= 30 THEN 2
                    WHEN ((a.overdue_amount / a.emi_amount) * 30) > 30 AND ((a.overdue_amount / a.emi_amount) * 30) <= 45 THEN 3
         WHEN ((a.overdue_amount / a.emi_amount) * 30) > 45 AND ((a.overdue_amount / a.emi_amount) * 30) <= 60 THEN 4";
        }

        if ($keyword == 'MSME' || $keyword == 'Loan Against Property') {
            $loan_types = ['MSME', 'Loan Against Property'];
        } elseif ($keyword == 'HCV' || $keyword == 'LCV') {
            $loan_types = ['HCV', 'LCV'];
        } else {
            $loan_types = [$keyword];
        }

        $query = LoanAccountsExtended::find()
            ->alias("a")
            ->select([
                "CASE $case END AS sub_bucket", "COUNT(*) AS count"
            ])
            ->andWhere(["a.is_deleted" => 0]);

        if (!empty($loan_types)) {
            $query->andWhere(["IN", "a.loan_type", $loan_types]);
        }

        $query->groupBy(['sub_bucket'])
            ->orderBy(['sub_bucket' => SORT_ASC]);

        $data = [];
        foreach ($query->asArray()->all() as $row) {
            $sub_bucket = $row['sub_bucket'];
            if ($sub_bucket == null) {
                continue;
            }
            $fillColor = isset($color[$sub_bucket]) ? $color[$sub_bucket] : 'gray';
            $data[] = [
                'name' => $sub_bucket,
                'value' => $row['count'],
                'fill' => $fillColor,
            ];
        }

        $response = [
            "postfix" => "USD",
            "data" => $data
        ];

        return $response;
    }


    public function actionGetDataStateWise()
    {
        $params = Yii::$app->request->get();

        $keyword = isset($params['keyword']) ? urldecode($params['keyword']) : null;
        $keyword = str_replace('%', ' ', $keyword);
        $keyword = preg_replace('/[^a-zA-Z0-9\s\-]/', '', $keyword);
        $keyword = str_replace('%20', ' ', $keyword);

        $query = LoanApplications::find()
            ->alias('a')
            ->select([
                'COUNT(*) AS count',
                'ce2.name AS state',
                "COUNT(b.disbursement_approved) AS disbursed_approval_count",
                'c.name AS loan_product_name'
            ])
            ->joinWith(['assignedLoanProviders b' => function ($b) {
                $b->joinWith(['branchEnc be' => function ($be) {
                    $be->joinWith(['cityEnc ce1' => function ($ce1) {
                        $ce1->joinWith(['stateEnc ce2'], false);
                    }], false);
                }], false);
            }], false)
            ->joinWith(['loanProductsEnc c' => function ($c) use ($keyword) {
                $c->andWhere(['c.name' => $keyword]);
//                $c->joinWith(['assignedFinancerLoanTypeEnc d' => function ($d) {
//                    $d->joinWith(['loanTypeEnc e'], false);
//                }], false);
            }], false)
            ->andWhere(['a.is_deleted' => 0])
            ->groupBy(['ce2.name'])
            ->orderBy(['ce2.name' => SORT_ASC]);

        $results = $query->asArray()->all();
        $data = [];
        foreach ($results as $row) {
            $state = $row['state'];
            if ($state == null) {
                continue;
            }
            $data[] = [
                'name' => $state,
                'value' => $row['disbursed_approval_count'],
            ];
        }

        $response = [
            'postfix' => 'USD',
            'data' => $data
        ];

        return $response;
    }


}