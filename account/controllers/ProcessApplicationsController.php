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

class ProcessApplicationsController extends Controller
{

    public function actionIndex($aidk)
    {

        $application_id = $aidk;
        $employer_application = EmployerApplications::find()
            ->alias('a')
            ->select(['CONCAT(a.designation_enc_id, " - " ,c.name) name', 'a.application_enc_id as application_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->where(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'a.is_deleted' => 0])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $applied_users = AppliedApplications::find()
            ->distinct()
            ->alias('a')
            ->where(['a.application_enc_id'=>$application_id])
            ->select(['a.applied_application_enc_id,a.status, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image','COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active','COUNT(c.is_completed) total'])
            ->joinWith(['createdBy b'],false)
            ->joinWith(['appliedApplicationProcesses c'=>function($b)
            {
                $b->joinWith(['fieldEnc d'],false);
                $b->select(['c.applied_application_enc_id','c.process_enc_id','c.field_enc_id','d.field_name','d.icon']);
            }])
            ->groupBy(['a.applied_application_enc_id'])
            ->asArray()
            ->all();
        $question = ApplicationInterviewQuestionnaire::find()
            ->alias('a')
            ->distinct()
            ->where(['a.application_enc_id' => $application_id])
            ->select(['a.interview_questionnaire_enc_id as id','a.questionnaire_enc_id as qid', 'b.questionnaire_name as name','c.field_label'])
            ->joinWith(['questionnaireEnc b'],false)
            ->joinWith(['fieldEnc c'],false)
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $label_city = ApplicationPlacementLocations::find()
            ->alias('a')
            ->distinct()
            ->select(['c.name', 'c.city_enc_id'])
            ->where(['application_enc_id' => $application_id])
            ->joinWith(['locationEnc b'], false)
            ->leftJoin(Cities::tableName() . 'as c', 'c.city_enc_id = b.city_enc_id')
            ->asArray()
            ->all();

        return $this->render('index', [
            'application' => $employer_application,
            'fields' => $applied_users,
            'que' => $question,
            'labels' => $label_city
        ]);

    }

}
