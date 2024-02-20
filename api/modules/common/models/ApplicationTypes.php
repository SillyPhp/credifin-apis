<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%application_types}}".
 *
 * @property int $id Primary Key
 * @property string $application_type_enc_id Application Type Encrypted ID
 * @property string $name Application Type Name
 *
 * @property ApplicationQuestions[] $applicationQuestions
 * @property EmployerApplications[] $employerApplications
 */
class ApplicationTypes extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['application_type_enc_id', 'name'], 'required'],
            [['application_type_enc_id'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['application_type_enc_id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationQuestions() {
        return $this->hasMany(ApplicationQuestions::className(), ['application_type_enc_id' => 'application_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications() {
        return $this->hasMany(EmployerApplications::className(), ['application_type_enc_id' => 'application_type_enc_id']);
    }

}
