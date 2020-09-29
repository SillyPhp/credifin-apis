<?php

namespace frontend\controllers;

use api\modules\v3\models\OrganizationList;
use common\models\AssignedCollegeCourses;
use common\models\BusinessActivities;
use common\models\CollegeCoursesPool;
use common\models\Countries;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use frontend\models\applications\LeadsForm;
use frontend\models\EducationalLoans;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;


class EducationLoansController extends Controller
{

    public function beforeAction($action)
    {
        $route = ltrim(Yii::$app->request->url, '/');
        if ($route === "") {
            $route = "/";
        }
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute($route, $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $loan_org = Organizations::find()
            ->select(['organization_enc_id', 'name', 'logo', 'logo_location', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END org_logo', 'initials_color'])
            ->where(['is_deleted' => 0, 'has_loan_featured' => 1, 'status' => 'Active'])
            ->asArray()
            ->all();
        return $this->render("education-loan-index", [
            'loan_org' => $loan_org,
        ]);
    }

    public function actionApply()
    {
        $india = Countries::findOne(['name' => 'India'])->country_enc_id;
        return $this->render('apply-general-loan-form', [
            'india' => $india,
        ]);
    }

    public function actionApplyLoan($id)
    {
        $this->layout = 'widget-layout';
        $wid = Organizations::find()
            ->select(['organization_enc_id', 'REPLACE(name, "&amp;", "&") as name'])
            ->where(['organization_enc_id' => $id])
            ->asArray()->one();
        if ($wid) {
            return $this->render('/framed-widgets/education-loan', ['wid' => $wid['organization_enc_id'], 'title' => $wid['name']]);
        } else {
            return 'Unauthorized';
        }
    }

    public function actionEducationLoanView()
    {
        return $this->render('education-loan-view');
    }

    public function actionLoanViewCollege()
    {
        return $this->render('loan-view-college');
    }

    public function actionLoanCollegeIndex()
    {
        return $this->render('loan-college-index');
    }

    public function actionLeads()
    {
        $this->layout = 'main-secondary';
        $model = new LeadsForm();
        $options = ['source'=>3,'datatype'=>0,'type'=>['College']];
        $data = OrganizationList::get($options);
        if ($model->load(Yii::$app->request->post())){
            $session = Yii::$app->session;
            $session->set('app_number', '');
            if ($model->save())
            {
                Yii::$app->session->setFlash('success', 'Success');
                return $this->refresh();
            }else{
                Yii::$app->session->setFlash('error', 'An error has occurred. Please try again later.');
            }
        }else{
            return $this->render('leads-form',['model'=>$model,'data'=>$data]);
        }
    }
}
