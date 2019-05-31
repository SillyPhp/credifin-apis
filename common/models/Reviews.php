<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%reviews}}".
 *
 * @property int $id
 * @property string $reviews_enc_id
 * @property string $review_type_enc_id
 * @property int $is_deleted
 * @property string $created_on
 * @property string $created_by
 *
 * @property ReviewsType $reviewTypeEnc
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reviews}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reviews_enc_id', 'review_type_enc_id', 'created_by'], 'required'],
            [['is_deleted'], 'integer'],
            [['created_on'], 'safe'],
            [['reviews_enc_id', 'review_type_enc_id', 'created_by'], 'string', 'max' => 100],
            [['review_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReviewsType::className(), 'targetAttribute' => ['review_type_enc_id' => 'review_type_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewTypeEnc()
    {
        return $this->hasOne(ReviewsType::className(), ['review_type_enc_id' => 'review_type_enc_id']);
    }
}
