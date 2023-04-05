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
            $loan = CreditLoanApplicationReports::find()
                ->distinct()
                ->alias('a')
                ->select(['a.loan_app_enc_id', 'b.applicant_name', 'b.loan_type', 'c.file_url', 'c.created_by', 'c1.request_source', 'concat(d.first_name," ",d.last_name) name','e.name as co_applicant_name','e.relation','e.borrower_type'])
                ->joinWith(['loanAppEnc b' => function ($b) {
                    $b->joinWith(['assignedLoanProviders b1']);
                }], false)
                ->joinWith(['responseEnc c' => function ($c) {
                    $c->joinWith(['requestEnc c1' => function ($c1) {
                    }]);
                }], false)
                ->joinWith(['createdBy d'], false)
                ->joinWith(['loanCoAppEnc e'], false)
                ->andWhere(['b1.provider_enc_id' => $user->organization_enc_id,'b1.is_deleted' => 0])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'data' => $loan]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
    }

}