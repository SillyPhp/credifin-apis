<?php

namespace account\controllers;

use common\models\LoanApplicationLogs;
use common\models\LoanApplications;
use common\models\Organizations;
use common\models\UserOtherDetails;
use yii\web\Response;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Utilities;


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
            ->select(['a.loan_app_enc_id', 'a.college_course_enc_id', 'a.college_enc_id',
                'a.created_on as apply_date',
                '(CASE
                    WHEN a.status = "4" THEN "New Lead"
                    WHEN a.status = "5" THEN "Accepted"
                    WHEN a.status = "6" THEN "Pre Verification"
                    WHEN a.status = "7" THEN "Under Process"
                    WHEN a.status = "8" THEN "Sanctioned"
                    WHEN a.status = "9" THEN "Disbursed"
                    WHEN a.status = "10" THEN "Reject"
                    ELSE "N/A"
                END) as status',
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
                '(CASE
                    WHEN a.gender = "1" THEN "Male"
                    WHEN a.gender = "2" THEN "Female"
                    ELSE "N/A"
                END) as gender',
                'a.applicant_dob as dob',
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
            ->where(['in', 'a.created_by', $studentIds])
            ->andWhere(['>', 'a.status', 3])
            ->asArray()
            ->all();

        return $this->render('dashboard', [
            'loans' => $loans
        ]);
    }

    public function actionChangeStatus()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            $status = Yii::$app->request->post('status');
            $reconsider = Yii::$app->request->post('reconsider');
            switch ($status) {
                case 'New Lead' :
                    $status = 4;
                    break;
                case 'Accepted' :
                    $status = 5;
                    break;
                case 'Pre Verification' :
                    $status = 6;
                    break;
                case 'Under Process' :
                    $status = 7;
                    break;
                case 'Sanctioned' :
                    $status = 8;
                    break;
                case 'Disbursed' :
                    $status = 9;
                    break;
                case 'Reject' :
                    $status = 10;
                    break;
                default :
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = LoanApplications::findOne(['loan_app_enc_id' => $id]);
                $model->status = $status;
                $model->updated_by = Yii::$app->user->identity->user_enc_id;
                $model->updated_on = date('Y-m-d H:i:s');
                if (!$model->save()) {
                    $transaction->rollBack();
                    return [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'Something went wrong..',
                    ];
                }
                $logModel = new LoanApplicationLogs();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $logModel->app_log_enc_id = $utilitiesModel->encrypt();
                $logModel->loan_app_enc_id = $id;
                $logModel->created_by = Yii::$app->user->identity->user_enc_id;
                $logModel->created_on = date('Y-m-d H:i:s');
                $logModel->status = $status;
                $logModel->is_reconsidered = $reconsider;
                if (!$logModel->save()) {
                    $transaction->rollBack();
                    return [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'Something went wrong..',
                    ];
                }
                $transaction->commit();
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Updated Successfully..',
                ];
            } catch (yii\db\Exception $exception) {
                $transaction->rollBack();
                return [
                    'status' => 201,
                    'title' => 'DB Exception',
                    'message' => 'Something went wrong..',
                ];
            }
        }
    }
}