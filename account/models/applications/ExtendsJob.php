<?php
namespace account\models\applications;

use common\models\EmployerApplications;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\Utilities;

class ExtendsJob extends Model {

    public $date;
    public $application_enc_id;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['date','application_enc_id'],'required'],
        ];
    }

    public function save()
    {
        $employerApplicationsModel = EmployerApplications::findOne(['application_enc_id'=>$this->application_enc_id]);
        $employerApplicationsModel->last_date = date('Y-m-d', strtotime($this->date));
        if ($employerApplicationsModel->save())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}