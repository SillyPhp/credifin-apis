<?php

namespace common\models;


/**
 * This is the model class for table "{{%courses}}".
 *
 * @property int $id
 * @property string $assigned_category_enc_id Course Category
 * @property string $course_id Course Id
 * @property string $title Course Name
 * @property string $url Course Url
 * @property string $image Course Thumbnail
 * @property int $is_paid 1 is paid and 0 is free
 * @property string $currency Currency Code
 * @property double $price Course Price
 * @property string $author Author Name
 * @property string $author_url Author Url
 * @property int $course_duration Course duration
 * @property string $updated_on
 * @property string $updated_by
 *
 * @property Users $updatedBy
 * @property AssignedCategories $assignedCategoryEnc
 */
class Courses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%courses}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'title', 'is_paid', 'price'], 'required'],
            [['is_paid', 'course_duration'], 'integer'],
            [['price'], 'number'],
            [['updated_on'], 'safe'],
            [['assigned_category_enc_id', 'course_id', 'currency', 'author', 'author_url', 'updated_by'], 'string', 'max' => 100],
            [['title', 'url', 'image'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['assigned_category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_category_enc_id' => 'assigned_category_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedCategoryEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }
}
