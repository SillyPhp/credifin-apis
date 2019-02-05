<?php

namespace account\models\applications;
use Yii;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\AppliedApplications;
use common\models\AppliedApplicationProcess;

class Applied extends AppliedApplications
{
    public function getQuestion()
    {
        return $this->hasMany(ApplicationInterviewQuestionnaire::className(), ['application_enc_id' => 'application_enc_id']);
    }

    public function getProcess()
    {
        return $this->hasMany(AppliedApplicationProcess::className(),['applied_application_enc_id' => 'applied_application_enc_id']);
    }

    public function getCurrentQuestions($id,$current)
    {
        $questionnaires = self::find()
            ->alias('a')
            ->distinct()
            ->select(['a.application_enc_id','f.name as title','a.applied_application_enc_id','a.is_deleted','a.current_round'])
            ->where(['a.created_by'=>Yii::$app->user->identity->user_enc_id])
            ->andWhere(['a.applied_application_enc_id'=>$id])
            ->joinWith(['question b'=>function($b) use ($current)
            {
                $b->select(['b.application_enc_id','c.field_name','c.field_enc_id','c.sequence','g.questionnaire_name','b.questionnaire_enc_id']);
                $b->andWhere(['not',['b.questionnaire_enc_id'=>null]]);
                $b->joinWith(['fieldEnc c'],false,'INNER JOIN');
                $b->joinWith(['questionnaireEnc g'],false,'INNER JOIN');
                $b->orderBy(['c.sequence'=>SORT_ASC]);
                $b->andWhere(['c.sequence' => $current]);
            }])
            ->joinWith(['applicationEnc d'=>function($b)
            {$b->joinWith(['title e'=>function($b)
            {
                $b->joinWith(['categoryEnc f'],false,'INNER JOIN');
            }],false,'INNER JOIN');
            }],false,'INNER JOIN')
            ->asArray()
            ->one();

        return $questionnaires;
    }

}