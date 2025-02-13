<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%application_unclaim_options}}".
 *
 * @property int $id Primary Key
 * @property string $unclaim_options_enc_id Placement Cities Encrypted ID
 * @property string $application_enc_id Foreign Key To Employer Applications Table
 * @property string $currency_enc_id currency
 * @property string $email hr email
 * @property string $consultant_email consultant email
 * @property string $job_url job_url
 * @property string $job_level job level
 * @property int $positions no of positions
 * @property string $wage_type wage type
 * @property string $wage_duration wage_duration
 * @property double $fixed_wage fixed wage
 * @property double $min_wage min wage
 * @property double $max_wage max wage
 * @property string $created_on On which date Wage information was added to database
 * @property string $created_by By which User Wage information was added
 * @property string $last_updated_on On which date Wage information was updated
 * @property string $last_updated_by By which User Wage information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Currencies $currencyEnc
 * @property EmployerApplications $applicationEnc
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
            [['unclaim_options_enc_id', 'application_enc_id', 'job_url'], 'required'],
            [['positions'], 'integer'],
            [['wage_type', 'wage_duration'], 'string'],
            [['fixed_wage', 'min_wage', 'max_wage'], 'number'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['unclaim_options_enc_id', 'application_enc_id', 'currency_enc_id', 'email', 'consultant_email', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['job_url', 'job_level'], 'string', 'max' => 255],
            [['unclaim_options_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['currency_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::className(), 'targetAttribute' => ['currency_enc_id' => 'currency_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyEnc()
    {
        return $this->hasOne(Currencies::className(), ['currency_enc_id' => 'currency_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }
}
