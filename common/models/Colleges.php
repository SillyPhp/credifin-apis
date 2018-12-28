<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%colleges}}".
 *
 * @property int $id Primary Key
 * @property string $university University
 * @property string $college College
 * @property string $type College Type
 * @property string $state State
 * @property string $city City
 */
class Colleges extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%colleges}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'university', 'college', 'type', 'state', 'city'], 'required'],
            [['id'], 'integer'],
            [['university'], 'string', 'max' => 100],
            [['college'], 'string', 'max' => 200],
            [['type', 'state', 'city'], 'string', 'max' => 30],
            [['id'], 'unique'],
        ];
    }

}
