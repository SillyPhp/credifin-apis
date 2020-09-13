<?php
namespace common\models;
/**
 * This is the model class for table "{{%webinar}}".
 *
 * @property int $id Primary Key
 * @property string $webinar_enc_id Webinar Encrypted Encrypted ID
 * @property string $name
 * @property string $image
 * @property string $image_location
 * @property string $title
 * @property double $price
 * @property double $gst
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property WebinarEvents[] $webinarEvents
 * @property WebinarPayments[] $webinarPayments
 */
class Webinar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['webinar_enc_id', 'name', 'title', 'created_by'], 'required'],
            [['price', 'gst'], 'number'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['webinar_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['name', 'image', 'image_location', 'title'], 'string', 'max' => 200],
            [['webinar_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEvents()
    {
        return $this->hasMany(WebinarEvents::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarPayments()
    {
        return $this->hasMany(WebinarPayments::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }
}
