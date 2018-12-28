<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\Cities;
use common\models\EmployerApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\AppliedApplications;
use common\models\Users;
use common\models\AppliedApplicationProcess;
use common\models\AppliedApplicationLocations;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;

class ProcessApplicationsController extends Controller {

    public function actionIndex($aidk) {

        $application_id = $aidk;
        $city_id = Yii::$app->request->post('city_id');

        $emp_application = EmployerApplications::find()
                ->alias('a')
                ->select(['CONCAT(a.designation_enc_id, " - " ,c.name) name', 'c.name cat_name', 'a.application_enc_id as application_id'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->where(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'a.is_deleted' => 0])
                ->orderBy(['a.id' => SORT_DESC]);
        
        $userrs = AppliedApplications::find()
                ->alias('a')
                ->select(['e.city_enc_id', 'c.application_enc_id', 'a.applied_application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active'])
                ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
                ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
                ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
                ->innerJoin(AppliedApplicationLocations::tableName() . 'as e', 'e.applied_application_enc_id = a.applied_application_enc_id')
                ->where(['a.application_enc_id' => $application_id])
                ->groupBy('a.applied_application_enc_id');

        $queue = ApplicationInterviewQuestionnaire::find()
                ->alias('a')
                ->where(['a.application_enc_id' => $application_id])
                ->select(['a.interview_questionnaire_enc_id as id', 'a.questionnaire_enc_id as qid', 'b.questionnaire_name as name', 'c.field_label'])
                ->joinWith(['questionnaireEnc b'], false)
                ->joinWith(['fieldEnc c'], false)
                ->orderBy(['a.id' => SORT_DESC]);

        $label_city = ApplicationPlacementLocations::find()
                ->alias('a')
                ->distinct()
                ->select(['c.name', 'c.city_enc_id'])
                ->where(['application_enc_id' => $application_id])
                ->joinWith(['locationEnc b'], false)
                ->leftJoin(Cities::tableName() . 'as c', 'c.city_enc_id = b.city_enc_id')
                ->asArray()
                ->all();

        if (Yii::$app->request->isAjax) {
            return($city_id);
            $employer_application = $emp_application->asArray()->all();
            $users = $userrs->andWhere(['e.city_enc_id' => $city_id])->asArray()->all();
            $que = $queue->asArray()->all();

            foreach ($users as $user) {
                $process_fields = InterviewProcessFields::find()
                        ->alias('a')
                        ->select(['a.field_name', 'a.field_enc_id', 'a.icon'])
                        ->where(['a.interview_process_enc_id' => $user['interview_process_enc_id']])
                        ->asArray()
                        ->all();

                $user['process'] = $process_fields;
                $arr['fields'][] = $user;
            }

            return $this->render('index', [
                        'application' => $employer_application,
                        'fields' => $arr,
                        'que' => $que,
                        'labels' => $label_city,
            ]);
        } else {
            $employer_application = $emp_application->asArray()->all();
            $users = $userrs->asArray()->all();
            $que = $queue->asArray()->all();

            foreach ($users as $user) {
                $process_fields = InterviewProcessFields::find()
                        ->alias('a')
                        ->select(['a.field_name', 'a.field_enc_id', 'a.icon'])
                        ->where(['a.interview_process_enc_id' => $user['interview_process_enc_id']])
                        ->asArray()
                        ->all();

                $user['process'] = $process_fields;
                $arr['fields'][] = $user;
            }

            return $this->render('index', [
                        'application' => $employer_application,
                        'fields' => $arr,
                        'que' => $que,
                        'labels' => $label_city,
            ]);
        }
    }

}
