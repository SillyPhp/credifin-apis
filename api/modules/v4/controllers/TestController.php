<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\LoanApplication;
use common\models\AssignedLoanProvider;
use common\models\Cities;
use common\models\CreditLoanApplicationReports;
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

            $Credit = CreditLoanApplicationReports::find()
                ->distinct()
                ->alias('a')
                ->select('a.report_enc_id', 'b.loan_app_enc_id','b.applicant_name', 'c.cibil_score', '')
                ->joinWith(['loanAppEnc b'], false)
                ->joinWith(['LoanCoAppEnc c'], false)
                ->joinWith(['responseEnc d' => function ($d) {
                    $d->joinWith(['requestEnc d1']);
                }], false)
                ->andWhere(['']);


            if (isset($params['keyword']) && !empty($params['keyword'])) {
                $Credit->andWhere([
                    'or',
                    ['like', 'b.applicant_name', $params['keyword']],
                ]);
            }
        }

    }

    public function actionNew(){

    }


}
