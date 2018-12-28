<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class InternshipsPreferencesForm extends Model {

    public $coursename;
    public $option;
    public $options;
    public $image;
    public $course_list;
    public $state_enc_id;

    public function rules() {
        return [
            [['coursename', 'option', 'options', 'image', 'course_list',], 'required'],
            [['image'], 'file', 'extensions' => 'jpg, gif, png']];
    }

    public function attributeLabels() {
        return[
            'coursename' => Yii::t('frontend', 'Course Name'),
            'course_list' => Yii::t('frontend', 'Course List'),
            'image' => Yii::t('frontend', 'Image'),
        ];
    }

}
