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
use JonnyW\PhantomJs\Client;

class TestCacheController extends Controller
{
    public function actionTest()
    {
        //return Url::to('@root');
        $client = Client::getInstance();
        $client->getEngine()->setPath('@rootDirectory/');

        /**
         * @see JonnyW\PhantomJs\Http\Request
         **/
        $request = $client->getMessageFactory()->createRequest('http://sneh.eygb.me', 'GET');

        /**
         * @see JonnyW\PhantomJs\Http\Response
         **/
        $response = $client->getMessageFactory()->createResponse();

        // Send the request
        $client->send($request, $response);

        if($response->getStatus() === 200) {

            // Dump the requested page content
            echo $response->getContent();
        }
    }
   public function actionScript($filepath=null)
   {
       $filepath = Url::to('@rootDirectory/assets/common/images/user1.png');
      // ini_set('max_execution_time', 0);
       $start = microtime(true);
           $img = imagecreatefrompng(Url::to('@rootDirectory/assets/common/images/admin.png'));
           $box = new Box($img);
           $box->setFontFace(Url::to('@rootDirectory/assets/common/fonts/GeoSlb712MdBTBold.ttf'));
           $box->setFontSize(55);
           $box->setFontColor(new Color(255, 255, 255));
           //$box->setTextShadow(new Color(0, 0, 0, 50), 0, -2);
           $box->setBox(40, 250, 600, 200);
           $box->setTextAlign('center', 'center');
           $box->draw('Dsb Edutech'); //big and bold but less then title

           $title = new Box($img);
           $title->setFontFace(Url::to('@rootDirectory/assets/common/fonts/GeoSlb712MdBTBold.ttf'));
           $title->setFontSize(40);
           $title->setFontColor(new Color(255, 255, 255));
           //$title->setTextShadow(new Color(0, 0, 0, 50), 0, -2);
           $title->setBox(340, 278, 600, 150);
           $title->setTextAlign('center', 'center');
           $title->draw('is hiring for'); //small not bold

          $maintitle = new Box($img);
          $maintitle->setFontFace(Url::to('@rootDirectory/assets/common/fonts/GeoSlb712MdBTBold.ttf'));
          $maintitle->setFontSize(80);
          $maintitle->setFontColor(new Color(255, 255, 255));
        //$title->setTextShadow(new Color(0, 0, 0, 50), 0, -2);
          $maintitle->setBox(120, 370, 800, 150);
          $maintitle->setTextAlign('center', 'center');
          $maintitle->draw('Full Stack Developer'); // big and bold
           $profile_image = imagecreatefrompng($filepath);
           $color = imagecolorallocatealpha($profile_image, 0, 0, 0, 127);
           imagefill($profile_image, 0, 0, $color);
           imagecopy($img, $profile_image, 20, 20, 0, 0, 128, 128);
           $filename = Yii::$app->getSecurity()->generateRandomString() . '.png';
           $save = Url::to('@rootDirectory/files/temp/'. $filename);
           $user_path = Url::to('@root/files/temp/'. $filename);
           header("Content-type: image/png");
           imagepng($img);
           imagedestroy($img);
//           $end = number_format((microtime(true) - $start), 2);
//       return [
//           'path' => $save,
//           'user_path' => $user_path,
//           'time' => $end,
//       ];

   }
}
