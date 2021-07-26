<?php

namespace common\models;

/**
 * This is the model class for table "{{%open_job_related_skills}}".
 *
 * @property int $id Primary Key
 * @property string $relation_enc_id Encrypted ID
 * @property string $skill_enc_id skill_enc_id
 * @property string $title_enc_id
 * @property string $description
 * @property double $level level
 * @property double $importance importance
 * @property string $created_on On which date Category information was added to database
 * @property string $created_by By which User Category information was added
 * @property string $last_updated_on On which date Category information was updated
 * @property string $last_updated_by By which User Category information was updated
 *
 * @property OpenSkills $skillEnc
 * @property OpenTitles $titleEnc
 */
class OpenJobRelatedSkills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%open_job_related_skills}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['relation_enc_id', 'skill_enc_id', 'title_enc_id', 'level', 'importance'], 'required'],
            [['description'], 'string'],
            [['level', 'importance'], 'number'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['relation_enc_id', 'skill_enc_id', 'title_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['relation_enc_id'], 'unique'],
            [['skill_enc_id', 'title_enc_id'], 'unique', 'targetAttribute' => ['skill_enc_id', 'title_enc_id']],
            [['skill_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpenSkills::className(), 'targetAttribute' => ['skill_enc_id' => 'skill_enc_id']],
            [['title_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpenTitles::className(), 'targetAttribute' => ['title_enc_id' => 'title_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkillEnc()
    {
        return $this->hasOne(OpenSkills::className(), ['skill_enc_id' => 'skill_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitleEnc()
    {
        return $this->hasOne(OpenTitles::className(), ['title_enc_id' => 'title_enc_id']);
    }
}
