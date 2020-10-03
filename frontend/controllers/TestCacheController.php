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
        $client = Client::getInstance();
        $p = Url::to('@rootDirectory/bin/phantomjs');
        $client->getEngine()->setPath($p);
        $request = $client->getMessageFactory()->createRequest('https://www.empoweryouth.com/education-loans/apply-loan/7y028kbWNRWwj8VGg3zORK4v9marEp', 'GET');
        $response = $client->getMessageFactory()->createResponse();
        $client->send($request, $response);
        print_r($response);
        if($response->getStatus() === 200) {
            echo $response->getContent();
        }
    }

    public function actionSharing()
    {
        $client = Client::getInstance();
        $p = Url::to('@webroot/website/bin/phantomjs');
        $client->getEngine()->setPath($p);
        $width  = 1250;
        $height = 650;
        $top    = 0;
        $left   = 0;
        $request = $client->getMessageFactory()->createCaptureRequest('http://sneh.eygb.me/framed-widgets/application-sharing-image', 'GET');
        $request->setOutputFile('sav-image.png');
        $request->setViewportSize($width, $height);
        $request->setCaptureDimensions($width, $height, $top, $left);
        $request->setQuality(100);
        $response = $client->getMessageFactory()->createResponse();
        $client->send($request, $response);
    }
}
