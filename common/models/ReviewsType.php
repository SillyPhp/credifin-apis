<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%reviews_type}}".
 *
 * @property int $id
 * @property string $review_type_enc_id
 * @property string $name
 * @property int $is_deleted
 * @property string $created_on
 * @property string $created_by
 *
 * @property Reviews[] $reviews
 */
class ReviewsType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reviews_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['review_type_enc_id', 'name', 'created_by'], 'required'],
            [['is_deleted'], 'integer'],
            [['created_on'], 'safe'],
            [['review_type_enc_id', 'name', 'created_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['review_type_enc_id' => 'review_type_enc_id']);
    }
}
