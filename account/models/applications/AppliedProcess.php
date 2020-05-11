<?php

namespace account\models\applications;

use common\models\ApplicationInterviewQuestionnaire;
use common\models\AppliedApplications;
use common\models\AppliedApplicationProcess;

class AppliedProcess extends AppliedApplicationProcess
{
    public function getProcess() //to be dltd
    {
        return $this->hasOne(AppliedApplicationProcess::className(),['field_enc_id'=>'field_enc_id']);
    }
}