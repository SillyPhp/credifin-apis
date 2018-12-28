<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\UserTasks;

class UserTaskForm extends Model {

    public $name;

    public function rules() {
        return[
            [['name'], 'required'],
        ];
    }

    public function attributeLabels() {
        return[
            'name' => Yii::t('frontend', 'Name'),
        ];
    }

    public function save() {
        if ($this->validate()) {
            $userTasksModel = new UserTasks();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $userTasksModel->name = $this->name;
            $userTasksModel->user_task_enc_id = $utilitiesModel->encrypt();
            $userTasksModel->assigned_to = Yii::$app->user->identity->user_enc_id;
            $userTasksModel->created_by = Yii::$app->user->identity->user_enc_id;
            $userTasksModel->created_on = date('Y-m-d h:i:s');
            if ($userTasksModel->validate() && $userTasksModel->save()) {
                return $userTasksModel;
            } else {
                return false;
            }
        }
    }

}
