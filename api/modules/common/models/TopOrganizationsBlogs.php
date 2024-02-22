<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%top_organizations_blogs}}".
 *
 * @property int $id
 * @property string $top_organizations_blogs_enc_id
 * @property string $title
 * @property string $slug
 * @property string $created_on
 * @property string $created_by
 * @property int $is_deleted
 *
 * @property Users $createdBy
 * @property TopOrganizationsBlogsList[] $topOrganizationsBlogsLists
 */
class TopOrganizationsBlogs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%top_organizations_blogs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['top_organizations_blogs_enc_id', 'title', 'slug'], 'required'],
            [['title', 'slug'], 'string'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['top_organizations_blogs_enc_id', 'created_by'], 'string', 'max' => 100],
            [['top_organizations_blogs_enc_id'], 'unique'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopOrganizationsBlogsLists()
    {
        return $this->hasMany(TopOrganizationsBlogsList::className(), ['top_organizations_blogs_enc_id' => 'top_organizations_blogs_enc_id']);
    }
}
