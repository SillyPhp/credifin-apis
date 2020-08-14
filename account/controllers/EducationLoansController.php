<?php

namespace account\controllers;

use common\models\LoanApplications;
use common\models\Organizations;
use common\models\UserOtherDetails;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


class EducationLoansController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionDashboard()
    {
//        $user_id = Yii::$app->user->identity->user_enc_id;
//        $user_id = '156761737999';


        $college_id = Yii::$app->user->identity->organization_enc_id;
        $students = UserOtherDetails::find()
            ->alias('a')
            ->select(['a.user_other_details_enc_id', 'a.user_enc_id', 'a.cgpa', 'b.first_name', 'b.last_name', 'a.starting_year', 'a.ending_year', 'a.semester', 'c.name', 'cc.course_name', 'b1.name city_name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'])
            ->joinWith(['userEnc b' => function ($b) {
                $b->joinWith(['cityEnc b1']);
            }], false)
            ->joinWith(['courseEnc cc'], false)
            ->joinWith(['departmentEnc c'], false)
            ->where(['a.organization_enc_id' => $college_id, 'a.college_actions' => 0])
            ->asArray()
            ->all();
        $studentIds = ArrayHelper::getColumn($students, 'user_enc_id');

        $loans = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.loan_app_enc_id', 'a.college_course_enc_id','a.college_enc_id',
                'a.created_on as apply_date',
                'a.status',
                'a.applicant_name',
                'a.amount',
                'a.degree',
                'f.course_name',
                'REPLACE(g.name, "&amp;", "&") as org_name',
                'a.semesters',
                'a.years',
                'a.phone',
                'a.email',
                'a.applicant_current_city as city',
                'a.gender',
                'a.applicant_dob as dob',
            ])
            ->joinWith(['collegeCourseEnc f'], false)
            ->joinWith(['collegeEnc g'], false)
            ->innerJoinWith(['loanCoApplicants h' => function($h){
                $h->select(['h.loan_app_enc_id',
                    'h.relation',
                    'h.name',
                    'h.employment_type',
                    'h.annual_income',
                ]);
            }])
            ->where(['in', 'a.created_by', $studentIds])
            ->asArray()
            ->all();

        return $this->render('dashboard', [
            'loans' => $loans
        ]);
    }

    public function actionCandidateDashboard(){
        return $this->render('candidate-dashboard');
    }
}