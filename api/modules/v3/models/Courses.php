<?php
namespace api\modules\v3\models;
use Yii;
use yii\helpers\Url;
class Courses {
    public static function get()
    {
        return self::getCourse();
    }

    private static function getCourse()
    {
      $get = \common\models\CollegeCoursesPool::find()
          ->select(['course_name value','course_enc_id id'])
          ->where([
              'or',
              ['status'=>'Approved'],
              ['status'=>'Pending']
          ])
          ->asArray()
          ->all();
      return $get;
    }
}