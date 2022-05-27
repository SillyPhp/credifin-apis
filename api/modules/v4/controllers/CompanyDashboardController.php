<?php

namespace api\modules\v4\controllers;

use common\models\LoanApplications;
use common\models\Users;
use common\models\Utilities;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;

class CompanyDashboardController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'lead-stats' => ['POST', 'OPTIONS'],
                'loan-applications' => ['POST', 'OPTIONS'],
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

    public function actionLeadStats()
    {
        if ($user = $this->isAuthorized()) {
            $user = Users::findOne(['user_enc_id' => $user->user_enc_id]);
            $referral_code = $user->getReferrals0()->one()->code;

            $stats = LoanApplications::find()
                ->alias('a')
                ->select([
                    'COUNT(DISTINCT a.loan_app_enc_id) as all_applications',
                    'COUNT(CASE WHEN i.status = "0" THEN 1 END) as new_leads',
                    'COUNT(CASE WHEN i.status = "1" THEN 1 END) as accepted',
                    'COUNT(CASE WHEN i.status = "2" THEN 1 END) as pre_verification',
                    'COUNT(CASE WHEN i.status = "3" THEN 1 END) as under_process',
                    'COUNT(CASE WHEN i.status = "4" THEN 1 END) as sanctioned',
                    'COUNT(CASE WHEN i.status = "5" THEN 1 END) as disbursed',
                    'COUNT(CASE WHEN i.status = "10" THEN 1 END) as rejected',
                ])
                ->joinWith(['assignedLoanProviders i' => function ($i) {
                    $i->onCondition(['or',
                        ['not', ['i.provider_enc_id' => null]],
                        ['not', ['i.provider_enc_id' => '']]
                    ]);
                    $i->andWhere(['in', 'i.status', [0, 3, 4, 10]]);
                }], false)
                ->andWhere(['a.lead_by' => $user->user_enc_id])
                ->asArray()
                ->one();

            return $this->response(200, ['status' => 200, 'stats' => $stats, 'referral_code' => $referral_code]);


        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionLoanApplications()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $filter = null;

            if (isset($params['filter']) && !empty($params['filter'])) {
                $filter = $params['filter'];
            }

            $loans = LoanApplications::find()
                ->distinct()
                ->alias('a')
                ->select(['a.id', 'a.loan_app_enc_id', 'a.college_course_enc_id', 'a.college_enc_id',
                    'a.created_on as apply_date',
                    '(CASE
                    WHEN i.status = "0" THEN "New Lead"
                    WHEN i.status = "1" THEN "Accepted"
                    WHEN i.status = "2" THEN "Pre Verification"
                    WHEN i.status = "3" THEN "Under Process"
                    WHEN i.status = "4" THEN "Sanctioned"
                    WHEN i.status = "5" THEN "Disbursed"
                    WHEN i.status = "10" THEN "Reject"
                    WHEN i.status = "11" THEN "Disbursed"
                    ELSE "N/A"
                END) as loan_status',
                    'CONCAT(k.first_name, " ", k.last_name) employee_name',
                    'a.applicant_name',
                    'a.amount',
                    'a.amount_received',
                    'a.amount_due',
                    'a.scholarship',
                    'a.degree',
                    'f.course_name',
                    'REPLACE(g.name, "&amp;", "&") as org_name',
                    'a.semesters',
                    'a.years',
                    'a.phone',
                    'a.email',
                    'a.applicant_current_city as city',
                    '(CASE
                    WHEN a.gender = "1" THEN "Male"
                    WHEN a.gender = "2" THEN "Female"
                    ELSE "N/A"
                END) as gender',
                    'a.applicant_dob as dob',
                    'a.created_by',
                ])
                ->joinWith(['collegeCourseEnc f'], false)
                ->joinWith(['collegeEnc g'], false)
                ->joinWith(['loanCoApplicants h' => function ($h) {
                    $h->select(['h.loan_app_enc_id',
                        'h.relation',
                        'h.name',
                        'h.annual_income',
                        '(CASE
                        WHEN h.employment_type = "0" THEN "Non Working"
                        WHEN h.employment_type = "1" THEN "Salaried"
                        WHEN h.employment_type = "2" THEN "Self Employed"
                        ELSE "N/A"
                    END) as employment_type',
                    ]);
                }])
                ->joinWith(['assignedLoanProviders i' => function ($i) {
                    $i->joinWith(['providerEnc j']);
                }])
                ->joinWith(['managedBy k'], false)
                ->andWhere(['a.lead_by' => $user->user_enc_id]);

            if ($filter) {
                $loans->andWhere(['in', 'i.status', $filter]);
            }

            $loans = $loans->asArray()->all();

            return $this->response(200, ['status' => 200, 'loans' => $loans]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}