<?php

namespace frontend\models\applications;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use common\models\ApplicationPlacementCities;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;
use common\models\UserResume;

class CandidateApply extends Widget
{
    public $application_enc_id;
    public $organization_enc_id;
    public $btn_class;

    public function init()
    {
        parent::init();
        if ($this->btn_class === null) {
            $this->btn_class = 'apply-btn';
        }
    }

    public function run()
    {
        $model = new JobApplied();
        $locations = ApplicationPlacementLocations::find()
            ->alias('a')
            ->distinct()
            ->select(['b.city_enc_id', 'name'])
            ->where(['a.application_enc_id' => $this->application_enc_id])
            ->joinWith(['locationEnc b' => function ($b) {
                $b->joinWith(['cityEnc c']);
            }], false)
            ->asArray()
            ->all();
        if (empty($locations)) {
            $locations = ApplicationPlacementCities::find()
                ->alias('a')
                ->distinct()
                ->select(['b.city_enc_id', 'name'])
                ->where(['a.application_enc_id' => $this->application_enc_id])
                ->joinWith(['cityEnc b'], false)
                ->asArray()
                ->all();
        }
        if (!Yii::$app->user->isGuest) {
            $app_que = ApplicationInterviewQuestionnaire::find()
                ->alias('a')
                ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                ->where(['a.application_enc_id' => $this->application_enc_id])
                ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                ->andWhere(['b.field_name' => 'Get Applications'])
                ->exists();

            $resumes = UserResume::find()
                ->select(['user_enc_id', 'resume_enc_id', 'title'])
                ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->orderBy(['id' => SORT_DESC])
                ->asArray()
                ->limit(3)
                ->all();
        }
        return $this->render('@frontend/views/widgets/employer_applications/job-applied', ['model' => $model,
            'btn_class' => $this->btn_class,
            'application_enc_id' => $this->application_enc_id,
            'organization_enc_id' => $this->organization_enc_id,
            'locations' => $locations,
            'que' => $app_que,
            'resumes' => $resumes]);
    }
}

