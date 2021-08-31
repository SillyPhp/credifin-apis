<?php

namespace common\models;

/**
 * This is the model class for table "{{%open_titles}}".
 *
 * @property int $id Primary Key
 * @property string $title_enc_id Encrypted ID
 * @property string $parent_enc_id Parent Enc ID
 * @property string $name Name
 * @property string $slug Slug
 * @property string $icon Icon
 * @property string $icon_png PNG Icon
 * @property int $source 0 as EY, 1 as Api
 * @property string $created_on On which date Category information was added to database
 * @property string $created_by By which User Category information was added
 * @property string $last_updated_on On which date Category information was updated
 * @property string $last_updated_by By which User Category information was updated
 * @property int $is_deleted 0 false, 1 true
 *
 * @property OpenJobRelatedJobDescription[] $openJobRelatedJobDescriptions
 * @property OpenJobRelatedSkills[] $openJobRelatedSkills
 * @property OpenSkills[] $skillEncs
 */
class OpenTitles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%open_titles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_enc_id', 'parent_enc_id', 'name', 'slug'], 'required'],
            [['source', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['title_enc_id', 'parent_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['name', 'slug'], 'string', 'max' => 255],
            [['icon', 'icon_png'], 'string', 'max' => 50],
            [['title_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpenJobRelatedJobDescriptions()
    {
        return $this->hasMany(OpenJobRelatedJobDescription::className(), ['title_enc_id' => 'title_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpenJobRelatedSkills()
    {
        return $this->hasMany(OpenJobRelatedSkills::className(), ['title_enc_id' => 'title_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillEncs()
    {
        return $this->hasMany(OpenSkills::className(), ['skill_enc_id' => 'skill_enc_id'])->viaTable('{{%open_job_related_skills}}', ['title_enc_id' => 'title_enc_id']);
    }
}
