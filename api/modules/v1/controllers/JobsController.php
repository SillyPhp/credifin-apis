<?php

namespace api\modules\v1\controllers;

use yii\helpers\Url;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Cities;
use common\models\Designations;
use common\models\Industries;
use common\models\OrganizationLocations;
use common\models\Organizations;
use common\models\EmployerApplications;
use common\models\AppliedApplications;
use common\models\UserResume;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;
use frontend\models\JobApplied;

class JobsController extends ApiBaseController {

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => ['detail', 'list'],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'list' => ['POST']
            ]
        ];
        return $behaviors;
    }

    //create, update, delete, view, index
//    public $modelClass = 'common\models\EmployerApplications';

    public function actionList(){
        $parameters = \Yii::$app->request->post();
        $result = [];
        $options = [];
        $limit = 20;

        if ($parameters['page'] && (int)$parameters['page'] >= 1) {
            $page = $parameters['page'];
        } else {
            $page = 1;
        }

        $options['limit'] = $limit;
        $options['offset'] = ($page - 1) * $limit;

        if ($parameters['location'] && !empty($parameters['location'])) {
            $options['location'] = $parameters['location'];
        }

        if ($parameters['keyword'] && !empty($parameters['keyword'])) {
            $options['keyword'] = $parameters['keyword'];
        }

        if ($parameters['company'] && !empty($parameters['company'])) {
            $options['company'] = $parameters['company'];
        }

        $options['type'] = 'Jobs';

        $jobcards = EmployerApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id application_id', 'e.location_enc_id location_id', 'a.created_on', 'i.name category', 'l.designation', 'a.slug link', 'd.initials_color color', 'd.slug organization_link', 'a.experience', "g.name as city", 'a.type', 'c.name as title', 'd.name as organization_name', 'CASE WHEN d.logo IS NULL THEN NULL ELSE CONCAT("'.Yii::$app->params->upload_directories->organizations->logo.'",d.logo_location, "/", d.logo) END logo'])
                    ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                    ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                    ->innerJoin(Categories::tableName() . 'as i', 'i.category_enc_id = b.parent_enc_id')
                    ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                    ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
                    ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
                    ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                    ->innerJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
                    ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
                    ->innerJoin(Designations::tableName() . 'as l', 'l.designation_enc_id = a.designation_enc_id')
                    ->where(['j.name' => $options['type'], 'a.is_deleted' => 0]);


        if (isset($options['company'])) {
            $jobcards->andWhere([
                'or',
                ($options['company']) ? ['like', 'd.name', $options['company']] : ''
            ]);
        }

        if (isset($options['location'])) {
            $jobcards->andWhere([
                'or',
                ['g.name' => $options['location']]
            ]);
        }

        if (isset($options['keyword'])) {
            $jobcards->andWhere([
                'or',
                ['like', 'l.designation', $options['keyword']],
                ['like', 'a.type', $options['keyword']],
                ['like', 'c.name', $options['keyword']],
                ['like', 'h.industry', $options['keyword']],
                ['like', 'i.name', $options['keyword']],
            ]);
        }

        if (isset($options['limit'])) {
            $jobcards->limit = $options['limit'];
        }

        if (isset($options['offset'])) {
            $jobcards->offset = $options['offset'];
        }

        $cards = $jobcards->orderBy(['a.id' => SORT_DESC])->asArray()->all();

        foreach ($cards as $jobcard) {
            $result[] = $jobcard;
        }

        if (count($cards) > 0) {
            return $this->response(200, $result);
        } else {
            return $this->response(201, 'No data found');
        }
    }

    public function actionDetail($id){
        $result = [];
        $application_details = EmployerApplications::find()
                                ->where([
                                    'application_enc_id' => $id,
                                    'is_deleted' => 0
                                ])
                                ->one();
        if (!$application_details) {
            return $this->response(201, 'No data found');
        }

        $organization_details = $application_details
                        ->getOrganizationEnc()
                        ->select(['name org_name', 'initials_color color', 'email', 'website', 'CASE WHEN logo IS NULL THEN NULL ELSE CONCAT("'.Yii::$app->params->upload_directories->organizations->logo.'",logo_location, "/", logo) END logo', 'CASE WHEN cover_image IS NULL THEN NULL ELSE CONCAT("'.Yii::$app->params->upload_directories->organizations->cover_image.'",cover_image_location, "/", cover_image) END cover_image'])
                        ->asArray()
                        ->one();

        if($organization_details['logo']) {
            $result['logo'] = Url::to($organization_details['logo'], true);
        } else {
            $result['logo'] = $organization_details['logo'];
        }

        if($organization_details['cover_image']) {
            $result['cover_image'] = Url::to($organization_details['cover_image'], true);
        } else {
            $result['cover_image'] = $organization_details['cover_image'];
        }

        $applied_jobs = AppliedApplications::find()
                        ->where(['application_enc_id' => $application_details->application_enc_id])
                        ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
                        ->exists();

        $resume = UserResume::find()
                    ->select(['user_enc_id', 'resume_enc_id', 'title'])
                    ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                    ->asArray()
                    ->all();

        $application_questionnaire = ApplicationInterviewQuestionnaire::find()
                    ->alias('a')
                    ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                    ->where(['a.application_enc_id' => $application_details->application_enc_id])
                    ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                    ->andWhere(['b.field_name' => 'Get Applications'])
                    ->exists();

        $object = new \account\models\jobs\JobApplicationForm();
        $data = $object
                ->getCloneData($application_details->application_enc_id);

        $model = new JobApplied();
//        return $organization_details;
        return $result['cover_image'];
        return [
            'Organizational Details' => $organization_details,
            'applied_jobs' => $applied_jobs,
            'resume' => $resume,
            'Application Questionnaire' => $application_questionnaire,
            'data' => $data,
            'model' => $model
        ];
    }

}