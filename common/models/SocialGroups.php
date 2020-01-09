<?php

namespace common\models;

/**
 * This is the model class for table "{{%social_groups}}".
 *
 * @property int $id Primary Key
 * @property string $group_enc_id Group enc id
 * @property string $name Group Name
 * @property string $created_on On which date Social Page information was added to database
 * @property string $created_by By which User Social Page information was added
 * @property string $last_updated_on On which date Social Page information was updated
 * @property string $last_updated_by By which User Social Page information was updated
 * @property int $is_deleted Is Social Page Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property SocialLinks[] $socialLinks
 */
class SocialGroups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%social_groups}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_enc_id', 'name', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['group_enc_id', 'name', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['group_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
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
    public function getSocialLinks()
    {
        return $this->hasMany(SocialLinks::className(), ['group_enc_id' => 'group_enc_id']);
    }
}
