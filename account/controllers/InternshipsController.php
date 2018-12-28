<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use common\models\States;
use common\models\Cities;
use common\models\OrganizationQuestionnaire;
use common\models\OrganizationLocations;
use frontend\models\CompanyLocationForm;
use frontend\models\InternshipApplicationForm;
use common\models\EmployerApplications;
use common\models\ApplicationPlacementLocations;
use common\models\Companies;

class InternshipsController extends Controller {

    public function actionDashboard() {
        return $this->render('dashboard');
    }

    public function actionApplication() {
        $model = new InternshipApplicationForm();
        $companyLocationFormModel = new CompanyLocationForm();
        $questions_list = OrganizationQuestionnaire::find()
                ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->andWhere(['like', 'questionnaire_for', '"1"'])
                ->orderBy(['id' => SORT_DESC])
                ->asArray()
                ->all();

        $location_list = OrganizationLocations::find()
                ->alias('a')
                ->select(['a.*', 'b.name AS city_name', 'c.name AS state_name'])
                ->leftJoin(Cities::tableName() . ' as b', 'b.city_enc_id = a.city_enc_id')
                ->innerJoin(States::tableName() . ' as c', 'c.state_enc_id = b.state_enc_id')
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->all();

        if ($model->load(Yii::$app->request->post())) {


            if ($model->saveValues()) {
                return 'success';
            } else {
                return 'failed';
            }
        } else {
            return $this->render('application', [
                        'model' => $model, 'location_list' => $location_list,
                        'companyLocationFormModel' => $companyLocationFormModel,
                        'questions_list' => $questions_list,
            ]);
        }
    }

    public function actionAddLocation() {
        $statesModel = new States();
        $companyLocationFormModel = new CompanyLocationForm();

        if ($companyLocationFormModel->load(Yii::$app->request->post())) {
            if ($companyLocationFormModel->save()) {
                return '1';
            } else {
                return '0';
            }
        } else {
            return $this->renderAjax('add-location', [
                        'statesModel' => $statesModel,
                        'companyLocationFormModel' => $companyLocationFormModel,
            ]);
        }
    }

    public function actionJobCards() {
        $jobcards = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_number', 'a.title', 'b.positions', 'd.name', 'e.name as company_name'])
                ->innerJoin(ApplicationPlacementLocations::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
                ->innerJoin(OrganizationLocations::tablename() . 'as c', 'c.location_enc_id = b.location_enc_id')
                ->innerJoin(Cities::tablename() . 'as d', 'd.city_enc_id = c.city_enc_id')
                ->innerJoin(Companies::tablename() . 'as e', 'e.company_enc_id = a.organization_enc_id')
                ->asArray()
                ->all();

        return json_encode($jobcards);
    }

}
