<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%erexx_college_rejections}}".
 *
 * @property int $id
 * @property string $erexx_college_rejection_enc_id
 * @property string $erexx_collab_enc_id
 * @property string $erexx_employer_app_enc_id
 * @property string $created_by
 * @property string $created_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property Users $createdBy
 * @property ErexxEmployerApplications $erexxEmployerAppEnc
 * @property ErexxCollaborators $erexxCollabEnc
 */
class ErexxCollegeRejections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%erexx_college_rejections}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['erexx_college_rejection_enc_id', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['erexx_college_rejection_enc_id', 'erexx_collab_enc_id', 'erexx_employer_app_enc_id', 'created_by'], 'string', 'max' => 100],
            [['erexx_college_rejection_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['erexx_employer_app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ErexxEmployerApplications::className(), 'targetAttribute' => ['erexx_employer_app_enc_id' => 'application_enc_id']],
            [['erexx_collab_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ErexxCollaborators::className(), 'targetAttribute' => ['erexx_collab_enc_id' => 'collaboration_enc_id']],
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
    public function getErexxEmployerAppEnc()
    {
        return $this->hasOne(ErexxEmployerApplications::className(), ['application_enc_id' => 'erexx_employer_app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErexxCollabEnc()
    {
        return $this->hasOne(ErexxCollaborators::className(), ['collaboration_enc_id' => 'erexx_collab_enc_id']);
    }
}
