<?php

namespace frontend\controllers;

use api\modules\v3\models\OrganizationList;
use common\models\AssignedCollegeCourses;
use common\models\BusinessActivities;
use common\models\CollegeCoursesPool;
use common\models\Countries;
use common\models\Organizations;
use common\models\PressReleasePubliser;
use common\models\UnclaimedOrganizations;
use frontend\models\AdmissionForm;
use frontend\models\applications\LeadsForm;
use frontend\models\EducationalLoans;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;


class EducationLoansController extends Controller
{

    public function actionPressReleases()
    {
        $data = self::getPressReleasData();
        return $this->render('press-releases', [
            'data' => $data
        ]);
    }

    private function getPressReleasData($option = []){
        $data = PressReleasePubliser::find()
            ->andWhere(['is_deleted' => 0])
            ->orderBy(['sequence' => SORT_ASC]);
            if($option['limit']){
                $data->limit($option['limit']);
            }
        return $data->asArray()->all();
    }
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
        $data = self::getPressReleasData(['limit' => 6]);
        $loan_org = Organizations::find()
            ->select(['organization_enc_id', 'name', 'logo', 'logo_location', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END org_logo', 'initials_color'])
            ->where(['is_deleted' => 0, 'has_loan_featured' => 1, 'status' => 'Active'])
            ->asArray()
            ->all();
        return $this->render("education-loan-index", [
            'data' => $data,
            'loan_org' => $loan_org,
        ]);
    }

    public function actionApply($ref_id = null)
    {
        $india = Countries::findOne(['name' => 'India'])->country_enc_id;
        return $this->render('apply-general-loan-form', [
            'india' => $india,
            'ref_id' => $ref_id
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
        if ($model->load(Yii::$app->request->post())){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $res = $model->save();
            if ($res['status'])
            {
                return [
                  'status'=>200,
                  'app_num'=>$res['app_num'],
                  'title'=>'Success',
                  'message' => 'Submit Successfully'
                ];
            }else{
                return [
                    'status'=>201,
                    'title'=>'Error',
                    'message' => 'Some Input Error Please Varify Your Information'
                ];;
            }
        }else{
            return $this->render('leads-form',['model'=>$model]);
        }
    }

    public function actionStudyInUsa(){
        $model = new AdmissionForm();
        $data = self::getPressReleasData();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }

        return $this->render('study-in-usa',[
            'model' => $model,
            'data' => $data,
        ]);
    }
    public function actionStudyInAustralia(){
        $model = new AdmissionForm();
        $data = self::getPressReleasData();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }

        return $this->render('study-in-australia',[
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionStudyInCanada(){
        $model = new AdmissionForm();
        $data = self::getPressReleasData();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }

        return $this->render('study-in-canada',[
            'model' => $model,
            'data' => $data,
        ]);
    }
    public function actionStudyInIndia(){
        $model = new AdmissionForm();
        $data = self::getPressReleasData();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }

        return $this->render('study-in-india',[
            'model' => $model,
            'data' => $data,
        ]);
    }
    public function actionStudyInEurope(){
        $model = new AdmissionForm();
        $data = self::getPressReleasData();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }

        return $this->render('study-in-europe',[
            'model' => $model,
            'data' => $data,
        ]);
    }
    public function actionStudyAbroad(){
        $model = new AdmissionForm();
        $data = self::getPressReleasData();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }

        return $this->render('study-abroad',[
            'model' => $model,
            'data' => $data,
        ]);
    }
    public function actionRefinance(){
        $model = new AdmissionForm();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }
        return $this->render('refinancing-education-loan',[
            'model' => $model
        ]);
    }
    public function actionAnnualFeeFinancing(){
        $model = new AdmissionForm();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }
        return $this->render('annual-fee-financing',[
            'model' => $model,
        ]);
    }
    public function actionSchoolFeeFinance(){
        $model = new AdmissionForm();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }
        return $this->render('school-fee-financing',[
            'model' => $model
        ]);
    }
    public function actionInterestFree(){
        $model = new AdmissionForm();
        $data = self::getPressReleasData();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }
        return $this->render('interest-free-education-loan',[
            'model' => $model,
            'data' => $data,
        ]);
    }
    public function actionEducationInstitutionLoan()
    {
        $model = new AdmissionForm();
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $lead_id = Yii::$app->request->post('lead_id');
                return $model->updateData($lead_id);
            }
        }
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            return ActiveForm::validate($model);
        }
        return $this->render('education-institution-loan', [
            'model' => $model
        ]);
    }

    public function actionLoanCalculator(){
        $this->layout = 'widget-layout';
        return $this->render('calc');
    }
}
