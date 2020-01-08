<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use frontend\models\OrganizationSignUpForm;
use frontend\models\OrganizationDetailForm;
use common\models\EmployerApplications;
use common\models\Categories;
use common\models\AppliedApplications;
use common\models\AppliedApplicationProcess;
use common\models\Organizations;
use common\models\AssignedCategories;

class HrController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

//    public $layout = 'backend-main';

    public function actionDashboard() {
//        $organizationSignUpForm = new OrganizationSignUpForm();
//        $organizationDetailForm = new OrganizationDetailForm();
        return $this->render('dashboard', [
//                    'organizationSignUpForm' => $organizationSignUpForm, 'organizationDetailForm' => $organizationDetailForm,
        ]);
    }

    public function actionCandidates(){
        return $this->render('candidates-hr');
    }
    public function actionCompany(){
        return $this->render('company-hr');
    }
    public function actionManageJobs() {
        return $this->render('manage-jobs');
    }
    public function actionManageAllJobs() {
        return $this->render('manage-all-jobs');
    }
    public function actionCompanyDashboard() {
        return $this->render('company-dashboard');
    }
    public function actionManageInternships() {
        return $this->render('manage-internships');
    }

    public function actionManageCompanies() {
        return $this->render('manage-companies');
    }

    public function actionManageCandidates() {
        return $this->render('manage-candidate-new'); 
    }

    public function actionRecruiterProfile() {
        return $this->render('recruiter-profile');
    }
    public function actionCompanyList() {
        return $this->render('company-list');
    }

    public function actionHrCandidates() {
        $applied_app = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id application_id', 'c.name as title', 'b.assigned_category_enc_id', 'f.applied_application_enc_id applied_id', 'f.status', 'd.icon', 'g.name as org_name', 'COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) as active', 'COUNT(h.is_completed) as total', 'ROUND((COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) / COUNT(h.is_completed)) * 100, 0) AS per'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = b.parent_enc_id')
                ->innerJoin(Organizations::tablename() . 'as g', 'g.organization_enc_id = a.organization_enc_id')
                ->leftJoin(AppliedApplications::tableName() . 'as f', 'f.application_enc_id = a.application_enc_id')
                ->where(['f.created_by' => Yii::$app->user->identity->user_enc_id])
                ->leftJoin(AppliedApplicationProcess::tableName() . 'as h', 'h.applied_application_enc_id = f.applied_application_enc_id')
                ->groupBy(['h.applied_application_enc_id'])
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->all();
        if (Yii::$app->request->isAjax) {
            
        } else {
            return $this->render('hr-candidate-details', ['applied' => $applied_app]);
        }
    }

}
