<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%Usa_Departments}}".
 *
 * @property int $id Primary Key
 * @property string $Code
 * @property string $Value
 * @property string $Acronym
 * @property string $LastModified
 * @property string $IsDisabled
 * @property string $image
 * @property string $image_location
 * @property int $total_applications
 * @property string $last_retrieved_by By which User Department information was Last Retrieved
 * @property string $last_retrieved_on On which date Department information was Last Retrieved to database
 *
 * @property Users $lastRetrievedBy
 */
class UsaDepartments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%Usa_Departments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Code', 'Value'], 'required'],
            [['total_applications'], 'integer'],
            [['last_retrieved_on'], 'safe'],
            [['Code', 'Acronym', 'IsDisabled'], 'string', 'max' => 10],
            [['Value'], 'string', 'max' => 255],
            [['LastModified', 'last_retrieved_by'], 'string', 'max' => 100],
            [['image', 'image_location'], 'string', 'max' => 50],
            [['Code'], 'unique'],
            [['last_retrieved_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_retrieved_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastRetrievedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_retrieved_by']);
    }
}
