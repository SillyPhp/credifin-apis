<?php

namespace common\models;

/**
 * This is the model class for table "{{%qualifications}}".
 *
 * @property int $id Primary Key
 * @property string $qualification_enc_id Qualification Encrypted ID
 * @property string $name Qualification
 * @property string $slug Qualification Slug
 *
 * @property Applications[] $applications
 */
class Qualifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%qualifications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qualification_enc_id', 'name', 'slug'], 'required'],
            [['qualification_enc_id'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 30],
            [['slug'], 'string', 'max' => 40],
            [['qualification_enc_id'], 'unique'],
            [['name'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Applications::className(), ['qualification_enc_id' => 'qualification_enc_id']);
    }
}
