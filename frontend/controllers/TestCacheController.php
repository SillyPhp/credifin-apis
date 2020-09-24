<?php

namespace frontend\controllers;
use common\models\UserOtherDetails;
use frontend\models\applications\PreferencesCards;
use frontend\models\script\Box;
use frontend\models\script\Color;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TestCacheController extends Controller
{
    public function actionTest()
    {
        print_r($this->Script());
    }
   private function Script($filepath=null)
   {
       $filepath = Url::to('@rootDirectory/assets/common/images/review_share.png');
       ini_set('max_execution_time', 0);
       $start = microtime(true);
           $img = imagecreatefrompng(Url::to('@rootDirectory/assets/common/images/admin.png'));
           $box = new Box($img);
           $box->setFontFace(Url::to('@rootDirectory/assets/common/fonts/times.ttf'));
           $box->setFontSize(44);
           $box->setFontColor(new Color(0, 0, 0));
           // $box->setTextShadow(new Color(0, 0, 0, 50), 0, -2);
           $box->setBox(717, 3240, 1200, 0);
           $box->setTextAlign('center', 'center');
           $box->draw('Issued In Public Health And Safety By:');
           //$profile_image = imagecreatefrompng(Url::to('@rootDirectory/assets/common/dum_icons/icon.png'));
           $profile_image = imagecreatefrompng($filepath);
           $color = imagecolorallocatealpha($profile_image, 0, 0, 0, 127);
           imagefill($profile_image, 0, 0, $color);
           imagecopy($img, $profile_image, 100, 100, 0, 0, 300, 300);
           $filename = Yii::$app->getSecurity()->generateRandomString() . '.png';
           $save = Url::to('@rootDirectory/files/temp/'. $filename);
           $user_path = Url::to('@root/files/temp/'. $filename);
           header("Content-type: image/png");
           imagepng($img, $save);
           imagedestroy($img);
           $end = number_format((microtime(true) - $start), 2);
       return [
           'path' => $save,
           'user_path' => $user_path,
           'time' => $end,
       ];

   }
}