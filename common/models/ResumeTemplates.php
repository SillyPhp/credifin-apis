<?php

namespace common\models;


/**
 * This is the model class for table "{{%resume_templates}}".
 *
 * @property int $id Primary Key
 * @property string $template_enc_id
 * @property string $name
 * @property string $template_path
 * @property string $thumb_image
 * @property string $thumb_image_location
 * @property int $is_deleted
 * @property string $created_by By which User Department information was Last Retrieved
 * @property string $created_on On which date Department information was Last Retrieved to database
 *
 * @property Users $createdBy
 */
class ResumeTemplates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%resume_templates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_enc_id', 'name', 'template_path', 'created_by'], 'required'],
            [['is_deleted'], 'integer'],
            [['created_on'], 'safe'],
            [['template_enc_id', 'name', 'template_path'], 'string', 'max' => 200],
            [['thumb_image', 'thumb_image_location'], 'string', 'max' => 50],
            [['created_by'], 'string', 'max' => 100],
            [['name'], 'unique'],
            [['template_enc_id'], 'unique'],
            [['template_path'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
