<?php

namespace common\models;

/**
 * This is the model class for table "{{%erexx_collaborators}}".
 *
 * @property int $id Primary Key
 * @property string $collaboration_enc_id Collaboration Encrypted ID
 * @property string $organization_enc_id Quiz Encrypted ID
 * @property string $college_enc_id
 * @property int $organization_approvel 1 for Approved and 0 for Pending
 * @property int $college_approvel 1 for Approved and 0 for Pending
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property string $status
 * @property int $is_deleted
 *
 * @property Organizations $collegeEnc
 * @property Organizations $organizationEnc
 */
class ErexxCollaborators extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%erexx_collaborators}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collaboration_enc_id', 'organization_enc_id', 'college_enc_id', 'created_by'], 'required'],
            [['organization_approvel', 'college_approvel', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['collaboration_enc_id', 'organization_enc_id', 'college_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['collaboration_enc_id'], 'unique'],
            [['organization_enc_id', 'college_enc_id', 'is_deleted'], 'unique', 'targetAttribute' => ['organization_enc_id', 'college_enc_id', 'is_deleted']],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'college_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}
