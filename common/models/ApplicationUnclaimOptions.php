<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%application_unclaim_options}}".
 *
 * @property int $id Primary Key
 * @property string $unclaim_options_enc_id Placement Cities Encrypted ID
 * @property string $application_enc_id Foreign Key To Employer Applications Table
 * @property string $email hr email
 * @property string $job_url job_url
 * @property int $positions no of positions
 * @property string $wage_type wage type
 * @property double $fixed_wage fixed wage
 * @property double $min_wage min wage
 * @property double $max_wage max wage
 * @property string $created_on On which date Wage information was added to database
 * @property string $created_by By which User Wage information was added
 * @property string $last_updated_on On which date Wage information was updated
 * @property string $last_updated_by By which User Wage information was updated
 *
 * @property EmployerApplications $applicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ApplicationUnclaimOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application_unclaim_options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unclaim_options_enc_id', 'application_enc_id', 'job_url', 'wage_type'], 'required'],
            [['positions'], 'integer'],
            [['wage_type'], 'string'],
            [['fixed_wage', 'min_wage', 'max_wage'], 'number'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['unclaim_options_enc_id', 'application_enc_id', 'email', 'job_url', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['unclaim_options_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
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
