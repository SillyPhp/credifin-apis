<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%teachers}}".
 *
 * @property int $id
 * @property string $teacher_enc_id teacher encrypted id
 * @property string $user_enc_id user encrypted id
 * @property string $college_enc_id college encrypted id
 * @property string $role role of user
 * @property string $created_on
 *
 * @property Users $userEnc
 * @property Organizations $collegeEnc
 * @property UserTypes $role0
 */
class Teachers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%teachers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_enc_id', 'user_enc_id', 'college_enc_id', 'role'], 'required'],
            [['created_on'], 'safe'],
            [['teacher_enc_id', 'user_enc_id', 'college_enc_id', 'role'], 'string', 'max' => 100],
            [['teacher_enc_id'], 'unique'],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => UserTypes::className(), 'targetAttribute' => ['role' => 'user_type_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
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
    public function getRole0()
    {
        return $this->hasOne(UserTypes::className(), ['user_type_enc_id' => 'role']);
    }
}
