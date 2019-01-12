<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Skills;

class AddSkillForm extends Model {

    public $name;
    public $skills_id;

    public function rules() {
        return [
            [['name'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => Yii::t('frontend', 'Enter Name of Skill'),
        ];
    }

    public function save() {
        if (!$this->validate()) {
            return false;
        }
        $utilitiesModel = new Utilities();
        $userSkill = new \common\models\UserSkills();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userSkill->user_skill_enc_id = $utilitiesModel->encrypt();

            if (empty($skills_id)) {
                $skillsModel = new Skills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $skillsModel->skill_enc_id = $utilitiesModel->encrypt();
                $skillsModel->skill = $this->name;
                $skillsModel->created_on = date('Y-m-d H:i:s');
                $skillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if ($skillsModel->save()) {
                    $userSkill->skill_enc_id = $skillsModel->skill_enc_id;
                } else {
                    return false;
                }
            } else {
                $userSkill->skill_enc_id = $this->skills_id;
            }

        $userSkill->created_on = date('Y-m-d h:i:s');
        $userSkill->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$userSkill->validate() || !$userSkill->save()) {
            return false;
        }
        return true;
    }


}
