<?php

namespace common\models;

/**
 * This is the model class for table "{{%open_skills}}".
 *
 * @property int $id Primary Key
 * @property string $skill_enc_id Encrypted ID
 * @property string $parent_enc_id
 * @property string $onet_element_id
 * @property string $name Name
 * @property string $type
 * @property string $skill_description
 * @property string $slug Slug
 * @property string $created_on On which date Category information was added to database
 * @property string $created_by By which User Category information was added
 * @property string $last_updated_on On which date Category information was updated
 * @property string $last_updated_by By which User Category information was updated
 *
 * @property OpenJobRelatedSkills[] $openJobRelatedSkills
 * @property OpenTitles[] $titleEncs
 */
class OpenSkills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%open_skills}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['skill_enc_id', 'name', 'type', 'slug'], 'required'],
            [['skill_description'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['skill_enc_id', 'parent_enc_id', 'onet_element_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['name', 'type', 'slug'], 'string', 'max' => 255],
            [['skill_enc_id'], 'unique'],
            [['slug'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpenJobRelatedSkills()
    {
        return $this->hasMany(OpenJobRelatedSkills::className(), ['skill_enc_id' => 'skill_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitleEncs()
    {
        return $this->hasMany(OpenTitles::className(), ['title_enc_id' => 'title_enc_id'])->viaTable('{{%open_job_related_skills}}', ['skill_enc_id' => 'skill_enc_id']);
    }
}
