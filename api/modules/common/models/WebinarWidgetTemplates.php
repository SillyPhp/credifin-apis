<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinar_widget_templates}}".
 *
 * @property int $id Primary Key
 * @property string $widget_enc_id widget template encipted id
 * @property string $webinar_enc_id Webinar Encrypted ID
 * @property string $template_name widget template name
 * @property string $template_path widget template path
 * @property string $template_icon for template icons
 * @property string $template_icon_path template icons path
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_by
 * @property string $last_updated_on
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property AssignWebinarWidgetModules[] $assignWebinarWidgetModules
 * @property WebinarWidgetModules[] $webinarWidgetModules
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Webinar $webinarEnc
 */
class WebinarWidgetTemplates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%webinar_widget_templates}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['widget_enc_id', 'webinar_enc_id', 'template_name', 'template_path', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['widget_enc_id', 'webinar_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['template_name', 'template_path', 'template_icon', 'template_icon_path'], 'string', 'max' => 200],
            [['widget_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['webinar_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinar::className(), 'targetAttribute' => ['webinar_enc_id' => 'webinar_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignWebinarWidgetModules()
    {
        return $this->hasMany(AssignWebinarWidgetModules::className(), ['widget_enc_id' => 'widget_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarWidgetModules()
    {
        return $this->hasMany(WebinarWidgetModules::className(), ['widget_enc_id' => 'widget_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEnc()
    {
        return $this->hasOne(Webinar::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }
}
