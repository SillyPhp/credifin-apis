<?php

namespace account\models\training_program;

use common\models\ApplicationTypes;
use common\models\TrainingProgramApplication;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\Utilities;

class TrainingProgram extends Model
{
    public $title;
    public $fees;
    public $profile;
    public $skills;
    public $cities;
    public $description;
    public $training_duration;
    public $training_duration_type;
    public $fees_type;
    public $business_hours;

    public function rules()
    {
        return [
            [['title','skills', 'cities','business_hours','fees','training_duration','training_duration_type','profile','fees_type','description'],'required'],
            [['title'],'string','max'=>50],
            [['fees'],'integer','max'=>10],
            [['training_duration'],'integer','max'=>12],
            [['title','fees'],'trim'],
        ];
    }

    public function save(){
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $utilitiesModel = new Utilities();
        $trainingProgramApplication = new TrainingProgramApplication();
        $application_type_enc_id = ApplicationTypes::findOne(['name' => 'Trainings']);
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $trainingProgramApplication->application_enc_id = $utilitiesModel->encrypt();
        $trainingProgramApplication->profie_enc_id = $this->profile;
        $trainingProgramApplication->assigned_category_id = $this->profile;
        $trainingProgramApplication->application_type_enc_id = $application_type_enc_id->application_type_enc_id;
        $trainingProgramApplication->description = $this->description;
        $trainingProgramApplication->fees = $this->fees;
        $trainingProgramApplication->fees_type = $this->fees_type;
        $trainingProgramApplication->training_duration = $this->training_duration;
        $trainingProgramApplication->training_duration_type = $this->training_duration_type;
    }
}