<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%quiz_counter}}".
 *
 * @property int $id Primary Key
 * @property string $ip_address IP Address
 * @property string $location Location
 * @property string $date_time Date Time
 */
class QuizCounter extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%quiz_counter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ip_address', 'location', 'date_time'], 'required'],
            [['date_time'], 'safe'],
            [['ip_address'], 'string', 'max' => 20],
            [['location'], 'string', 'max' => 30],
        ];
    }

}
