<?php

namespace account\controllers;

use common\models\LoanApplicationLogs;
use common\models\LoanApplications;
use common\models\Organizations;
use common\models\SelectedServices;
use common\models\Services;
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
        $service_id = Services::findOne(['name' => 'Loans'])['service_enc_id'];
        $chkPermission = SelectedServices::findOne(['service_enc_id' => $service_id, 'organization_enc_id' => Yii::$app->user->identity->organization_enc_id])['is_selected'];
        if(!$chkPermission){
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }

        $loans = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.loan_app_enc_id', 'a.college_course_enc_id', 'a.college_enc_id',
                'a.created_on as apply_date',
                '(CASE
                    WHEN a.loan_status = "0" THEN "New Lead"
                    WHEN a.loan_status = "1" THEN "Accepted"
                    WHEN a.loan_status = "2" THEN "Pre Verification"
                    WHEN a.loan_status = "3" THEN "Under Process"
                    WHEN a.loan_status = "4" THEN "Sanctioned"
                    WHEN a.loan_status = "5" THEN "Disbursed"
                    WHEN a.loan_status = "10" THEN "Reject"
                    ELSE "N/A"
                END) as loan_status',
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
            ->joinWith(['currentScheme i' => function($i){
                $i->andWhere(['i.loan_provider_id' => Yii::$app->user->identity->organization_enc_id]);
            }], false)
            ->andWhere(['a.status' => 1])
            ->andWhere(['not',['a.current_scheme_id' => null]])
            ->asArray()
            ->all();

        $stats = LoanApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.loan_app_enc_id',
                'COUNT(a.loan_app_enc_id) as all_applications',
                'COUNT(CASE WHEN a.loan_status = "0" THEN 1 END) as new_leads',
                'COUNT(CASE WHEN a.loan_status = "1" THEN 1 END) as accepted',
                'COUNT(CASE WHEN a.loan_status = "2" THEN 1 END) as pre_verification',
                'COUNT(CASE WHEN a.loan_status = "3" THEN 1 END) as under_process',
                'COUNT(CASE WHEN a.loan_status = "4" THEN 1 END) as sanctioned',
                'COUNT(CASE WHEN a.loan_status = "5" THEN 1 END) as disbursed',
                'COUNT(CASE WHEN a.loan_status = "10" THEN 1 END) as rejected',
            ])
            ->joinWith(['currentScheme i' => function($i){
                $i->andWhere(['i.loan_provider_id' => Yii::$app->user->identity->organization_enc_id]);
            }], false)
            ->andWhere(['a.status' => 1])
            ->asArray()
            ->one();

        return $this->render('dashboard', [
            'loans' => $loans,
            'stats' => $stats
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
                    $status = 0;
                    break;
                case 'Accepted' :
                    $status = 1;
                    break;
                case 'Pre Verification' :
                    $status = 2;
                    break;
                case 'Under Process' :
                    $status = 3;
                    break;
                case 'Sanctioned' :
                    $status = 4;
                    break;
                case 'Disbursed' :
                    $status = 5;
                    break;
                case 'Reject' :
                    $status = 10;
                    break;
                default :
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = LoanApplications::findOne(['loan_app_enc_id' => $id]);
                $model->loan_status = $status;
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
                $logModel->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
                $logModel->scheme_enc_id = $model->current_scheme_id;
                $logModel->created_by = Yii::$app->user->identity->user_enc_id;
                $logModel->created_on = date('Y-m-d H:i:s');
                $logModel->loan_status = $status;
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