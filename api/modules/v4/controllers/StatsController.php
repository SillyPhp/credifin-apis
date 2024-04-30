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

        $keyword = isset($params['keyword']) ? str_replace('%', ' ', urldecode($params['keyword'])) : null;
        $keyword = preg_replace('/[^a-zA-Z\s]/', '', $keyword);

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
        if (isset($params['hr'])) {
            $case = [5, 6, 7, 8];
        } elseif (isset($params['lr'])) {
            $case = [0, 1, 2, 3, 4];
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
                "a.sub_bucket", "COUNT(*) AS count"
            ]);

        if (!empty($loan_types)) {
            $query->andWhere(["IN", "a.loan_type", $loan_types]);
        }

        $query = $query
            ->andWhere(["a.is_deleted" => 0])
            ->andWhere(['in', 'a.sub_bucket', $case])
            ->groupBy(['a.sub_bucket'])
            ->orderBy(['a.sub_bucket' => SORT_ASC])
            ->asArray()
            ->all();

        $data = [];
        foreach ($query as $row) {
            $sub_bucket = $row['sub_bucket'];
            $data[] = [
                'name' => $sub_bucket,
                'value' => $row['count'],
                'fill' => isset($color[$sub_bucket]) ? $color[$sub_bucket] : 'gray',
            ];
        }

        $response = [
            "postfix" => "USD",
            "data" => $data
        ];

        return $response;
    }
}
