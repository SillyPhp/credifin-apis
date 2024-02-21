<?php

namespace common\models;

/**
 * This is the model class for table "{{%Usa_Profile_Codes}}".
 *
 * @property int $id Primary Key
 * @property string $Profile_Code Profile Code
 * @property string $name Profile Name
 * @property string $IsDisabled Yes or No
 * @property string $JobFamily Job Family
 * @property string $Total_Jobs Number of Jobs In This Profile
 */
class UsaProfileCodes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%Usa_Profile_Codes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Profile_Code', 'name', 'IsDisabled', 'JobFamily', 'Total_Jobs'], 'required'],
            [['Profile_Code', 'IsDisabled', 'JobFamily', 'Total_Jobs'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 150],
            [['Profile_Code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
}
