<?php

namespace common\models;

/**
 * This is the model class for table "{{%shared_links_counter}}".
 *
 * @property int $id Primary Key
 * @property string $link_enc_id Foreign Key to Sharing Links Table
 * @property string $ip_address IP Address
 * @property string $date_time Date Time
 *
 * @property SharingLinks $linkEnc
 */
class SharedLinksCounter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shared_links_counter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_enc_id', 'ip_address'], 'required'],
            [['date_time'], 'safe'],
            [['link_enc_id'], 'string', 'max' => 100],
            [['ip_address'], 'string', 'max' => 20],
            [['link_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SharingLinks::className(), 'targetAttribute' => ['link_enc_id' => 'link_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('dsbedutech', 'ID'),
            'link_enc_id' => Yii::t('dsbedutech', 'Link Enc ID'),
            'ip_address' => Yii::t('dsbedutech', 'Ip Address'),
            'date_time' => Yii::t('dsbedutech', 'Date Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinkEnc()
    {
        return $this->hasOne(SharingLinks::className(), ['link_enc_id' => 'link_enc_id']);
    }
}