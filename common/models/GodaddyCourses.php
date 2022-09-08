<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%godaddy_courses}}".
 *
 * @property int $id
 * @property string $course_enc_id
 * @property string $name name of person
 * @property string $phone phone of person
 * @property string $email email of person
 * @property string $course_name course name
 * @property double $price course price
 * @property string $created_by
 * @property string $created_on
 *
 * @property Users $createdBy
 */
class GodaddyCourses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%godaddy_courses}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_enc_id', 'name', 'phone', 'email', 'course_name', 'created_on'], 'required'],
            [['price'], 'number'],
            [['created_on'], 'safe'],
            [['course_enc_id', 'name', 'email', 'course_name', 'created_by'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
            [['course_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
