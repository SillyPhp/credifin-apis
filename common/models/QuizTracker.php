<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%quiz_tracker}}".
 *
 * @property int $id Primary Key
 * @property string $ip_address IP Address
 * @property string $location Location
 * @property string $date_time Date Time
 * @property int $question Question Number
 */
class QuizTracker extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%quiz_tracker}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ip_address', 'location', 'date_time', 'question'], 'required'],
            [['date_time'], 'safe'],
            [['question'], 'integer'],
            [['ip_address'], 'string', 'max' => 20],
            [['location'], 'string', 'max' => 30],
        ];
    }

}
