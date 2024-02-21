<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_streams}}".
 *
 * @property int $id Primary Key
 * @property string $stream_enc_id Route Encrypted Encrypted ID
 * @property string $name Name
 * @property string $created_on On which date Route information was added to database
 * @property string $created_by By which User Route information was added
 */
class CollegeStreams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%college_streams}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stream_enc_id', 'name', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['stream_enc_id', 'created_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
            [['stream_enc_id'], 'unique'],
        ];
    }
}
