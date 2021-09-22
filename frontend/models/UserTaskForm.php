<?php

namespace frontend\models;

use common\models\UserEducation;
use common\models\UserSkills;
use common\models\UserSpokenLanguages;
use common\models\UserTypes;
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
            $userTasksModel->created_on = date('Y-m-d H:i:s');
            if ($userTasksModel->validate() && $userTasksModel->save()) {
                return $userTasksModel;
            } else {
                return false;
            }
        }
    }
    public function getProfileCompleted($key)
    {
        $d = (new \yii\db\Query())
            ->from(['a' => \common\models\Users::tableName()])
            ->select(['a.user_enc_id', 'a.email', 'CONCAT(a.first_name, " ", a.last_name) name', 'a.username', 'a.gender', 'a.description', 'a.image', 'a.city_enc_id', 'a.dob', 'a.experience', 'a.job_function', 'e.user_language_enc_id', 'd.user_skill_enc_id', 'c.education_enc_id'])
            ->leftJoin(UserTypes::tableName() . 'as b', 'b.user_type_enc_id = a.user_type_enc_id')
            ->leftJoin(UserEducation::tableName() . 'as c', 'c.user_enc_id = a.user_enc_id')
            ->leftJoin(UserSkills::tableName() . 'as d', 'd.created_by = a.user_enc_id')
            ->leftJoin(UserSpokenLanguages::tableName() . 'as e', 'e.created_by = a.user_enc_id')
            ->andWhere(['a.user_enc_id' => $key])
            ->one();
        $per = 0;
        $total = 10;
        $t = 100 / $total;
        if ($d['user_language_enc_id']) {
            $per += $t;
        }
        if ($d['user_skill_enc_id']) {
            $per += $t;
        }
        if ($d['education_enc_id']) {
            $per += $t;
        }
        if ($d['experience']) {
            $per += $t;
        }
        if ($d['image']) {
            $per += $t;
        }
        if ($d['job_function']) {
            $per += $t;
        }
        if ($d['description']) {
            $per += $t;
        }
        if ($d['gender']) {
            $per += $t;
        }
        if ($d['city_enc_id']) {
            $per += $t;
        }
        if ($d['dob']) {
            $per += $t;
        }
        return $per;
    }

}
