<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%class_notes}}".
 *
 * @property int $id
 * @property string $note_enc_id note encrypted id
 * @property string $class_enc_id class encrytpted id
 * @property string $note note name
 * @property string $note_location note location
 * @property string $title note title
 * @property string $alt note alternative title
 * @property string $created_on created on time
 * @property string $created_by created by id
 * @property int $is_deleted 0 false, 1 true
 *
 * @property OnlineClasses $classEnc
 * @property Users $createdBy
 */
class ClassNotes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%class_notes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note_enc_id', 'class_enc_id', 'note', 'note_location', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['note_enc_id', 'class_enc_id', 'note', 'note_location', 'title', 'alt', 'created_by'], 'string', 'max' => 100],
            [['note_enc_id'], 'unique'],
            [['class_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OnlineClasses::className(), 'targetAttribute' => ['class_enc_id' => 'class_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassEnc()
    {
        return $this->hasOne(OnlineClasses::className(), ['class_enc_id' => 'class_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
