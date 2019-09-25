<?php

namespace account\models\training_program;

use common\models\AppliedTrainingApplications;
use common\models\TrainingProgramApplication;
use Yii;
use yii\base\Model;

class UserAppliedTraining extends Model
{
    public function total_applied($type=null)
    {
        $total_applications = AppliedTrainingApplications::find()
            ->alias('a')
            ->innerJoin(TrainingProgramApplication::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
            ->andWhere(['b.is_deleted' => 0])
            ->count();
        return $total_applications;
    }
}
