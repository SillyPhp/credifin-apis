<?php
namespace frontend\controllers;
use common\models\Auth;
use common\models\spaces\Spaces;
use yii\web\Controller;
use yii\helpers\Url;
use Yii;
class TestCacheController extends Controller
{
  public function actionTest()
  {
      try {
          $model = new Auth();
          $model->user_id = 12;
          if (!$model->save()) //model errors
          {
              throw new \Exception ( implode ( "<br />" , \yii\helpers\ArrayHelper::getColumn ( $model->errors , 0 , false ) ) );
          }

       //some kind of err
      }catch (\Exception $exception) {
          return $exception->getMessage(); //final messege for user
      }
  }

  public function actionSpacesApi()
  {
      $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey,Yii::$app->params->digitalOcean->secret);
      $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
      $result = $my_space->uploadFileMeta(
          Url::to('@rootDirectory/files/temp/1nmUsMFvd4yV_hgaChik60teROlmNQcI.png'),
          "images/sharing/sneh.png", "public",
          ['Content-Disposition'=>'attachment']
      );
      print_r($result);
  }
}
