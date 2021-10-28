<?php


namespace api\modules\v2\models;

use common\models\OnlineClasses;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class ClassForm extends Model
{
    public $teacher_id;
    public $course_id;
    public $section_id;
    public $start_time;
    public $end_time;
    public $subject_name;
    public $date;
    public $semester;

    public function rules()
    {
        return [
            [['course_id', 'start_time', 'end_time', 'subject_name', 'date','semester'], 'required'],
            [['section_id'],'safe']
        ];
    }

    public function SaveClass(){

        $time = new \DateTime($this->end_time);
        $time->modify("-1 second");

        $end_time = $time->format('H:i:s');

        $model = new OnlineClasses();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->class_enc_id = $utilitiesModel->encrypt();
        $model->teacher_enc_id = $this->teacher_id;
        $model->assigned_college_enc_id = $this->course_id;
        $model->section_enc_id = $this->section_id;
        $model->subject_name = $this->subject_name;
        $model->semester = $this->semester;
        $model->start_time = $this->start_time;
        $model->end_time = $end_time;
        $model->class_date = date('Y-m-d', strtotime($this->date));
        $model->created_on = date('Y-m-d H:i:s');
        if($model->save()){
            return true;
        }else{
            print_r($model->getErrors());
        }

    }
}