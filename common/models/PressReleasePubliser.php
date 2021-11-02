<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%press_release_publiser}}".
 *
 * @property int $id
 * @property string $publiser_enc_id
 * @property string $name
 * @property string $logo
 * @property string $logo_location
 * @property string $link
 * @property int $sequence
 * @property string $created_by
 * @property string $last_updated_by
 * @property string $created_on
 * @property string $last_updated_on
 * @property int $is_deleted 0 as false, 1 as True
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class
PressReleasePubliser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%press_release_publiser}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['publiser_enc_id', 'name', 'logo', 'logo_location', 'link', 'sequence', 'created_by'], 'required'],
            [['sequence', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['publiser_enc_id', 'name', 'logo', 'logo_location', 'link', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['publiser_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'publiser_enc_id' => 'Publiser Enc ID',
            'name' => 'Name',
            'logo' => 'Logo',
            'logo_location' => 'Logo Location',
            'link' => 'Link',
            'sequence' => 'Sequence',
            'created_by' => 'Created By',
            'last_updated_by' => 'Last Updated By',
            'created_on' => 'Created On',
            'last_updated_on' => 'Last Updated On',
            'is_deleted' => 'Is Deleted',
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
}
