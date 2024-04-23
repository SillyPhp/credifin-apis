<?php

namespace api\modules\v4\controllers;

use common\models\extended\LoanAccountsExtended;
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

        $loan_type = null;
        $case = '';

        if (isset($params['keyword'])) {
            switch ($params['keyword']) {
                case 'Loan Against Property':
                    $loan_type = "LAP";
                    break;
                case 'honda':
                    $loan_type = "Honda";
                    break;
                case 'HCV':
                    $loan_type = "HCV";
                    break;
                case 'LCV':
                    $loan_type = "LCV";
                    break;
                case 'TWO WHEELER':
                    $loan_type = "TWO WHEELER";
                    break;
                case 'THREE WHEELER':
                    $loan_type = "THREE WHEELER";
                    break;
                case 'E-Rickshaw':
                    $loan_type = "E-Rickshaw";
                    break;
                case 'EV Two Wheeler':
                    $loan_type = "EV Two Wheeler";
                    break;
                case 'Four Wheeler':
                    $loan_type = "Four Wheeler";
                    break;
                default:
                    break;
            }
        }

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

        $query = LoanAccountsExtended::find()
            ->alias("a")
            ->select([
                "CASE $case END AS sub_bucket", "COUNT(*) AS count"
            ])
            ->andWhere(["a.is_deleted" => 0]);

        if ($loan_type != null) {
            $query->andWhere(["a.loan_type" => $loan_type]);
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


}