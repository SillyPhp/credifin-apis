<?php
/**
 * Created by PhpStorm.
 * User: Shshank
 * Date: 30-Sep-19
 * Time: 01:31 PM
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;


class EducationalLoans extends Model
{
public $country;
public $city;
public $degree;
public $course;
public $number;
public $first_name;
public $last_name;
public $dob;
public $email;
public $monthly_income;
public $gender;
public $co_borrower;
public $co_borrower_emp;

    public function rules(){
        return[
          [['country','city','degree','course','number','first_name','last_name','dob','email','monthly_income','gender',
             'co_borrower','co_borrower_emp'],'required']
        ];
    }
    public function attributeLabels(){
        return[
            'country' => Yii::t('frontend','Choose Country where you want to study'),
            'city' => Yii::t('frontend','Current city where you live'),
            'degree' => Yii::t('frontend','Which degree do you want to pursue'),
            'course' => Yii::t('frontend','Select a course'),
            'number' => Yii::t('frontend','Enter your phone number'),
            'first_name' => Yii::t('frontend','First Name'),
            'last_name' => Yii::t('frontend','Last Name'),
            'dob' => Yii::t('frontend','Date Of Birth'),
            'email' => Yii::t('frontend','Email Address'),
            'monthly_income' => Yii::t('frontend','Monthly Income'),
            'gender' => Yii::t('frontend','Gender'),
            'co_borrower' => Yii::t('frontend','Who would be your co-borrower?'),
            'co_borrower_emp' => Yii::t('frontend',"Your Co-borrower's employment type ?"),
        ];
    }
}