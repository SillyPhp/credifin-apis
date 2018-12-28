<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class WorkExpierenceForm extends Model {

    public $companyname;
    public $city;
    public $from;
    public $to;
    public $title;
    public $description;
    public $portfolio;

    public function rules() {
        return [
            [['companyname', 'city', 'from', 'to', 'title', 'description'], 'required'],
        ];
    }

    public function attributeLabels() {
        return[
            'companyname' => Yii::t('frontend', 'Company Name'),
            'city' => Yii::t('frontend', 'City'),
            'from' => Yii::t('frontend', 'from'),
            'to' => Yii::t('frontend', 'to'),
            'title' => Yii::t('frontend', 'Title'),
            'description' => Yii::t('frontend', 'Description'),
            'portfolio' => Yii::t('frontend', 'Portfolio'),
        ];
    }

}
