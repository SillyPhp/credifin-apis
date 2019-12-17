<?php

namespace account\models\applications;
use common\models\ApplicationReminder;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class ApplicationReminderForm extends Model
{
    public $application_title;
    public $organization_name;
    public $salary;
    public $date;
    public $status;
    public $link;

    public function formName()
    {
        return '';
    }

    public function rules() {
        return [
            [['application_title', 'organization_name', 'salary', 'date', 'status', 'link'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'application_title' => Yii::t('account', 'Application Title'),
            'organization_name' => Yii::t('account', 'Organization Name'),
            'salary' => Yii::t('account', 'Salary'),
            'link' => Yii::t('account', 'Link'),
        ];
    }

    public function save(){
        if (!$this->validate()) {
            return false;
        }
        $utilitiesModel =   new Utilities();
        $applicationReminder = new ApplicationReminder();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $applicationReminder->reminder_enc_id = $utilitiesModel->encrypt();
        $applicationReminder->application_name = $this->application_title;
        $applicationReminder->organization_name = $this->organization_name;
        $applicationReminder->link = $this->link;
        $applicationReminder->date = $this->date;
        $applicationReminder->status = $this->status;
        $applicationReminder->salary = $this->salary;
        $applicationReminder->created_by = Yii::$app->user->identity->user_enc_id;
        $applicationReminder->created_on = date('Y-m-d H:i:s');
        if (!$applicationReminder->validate() || !$applicationReminder->save()) {
            return false;
        }
        return true;
    }
}