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
        $client->getEngine()->debug(true);
        /**
         * @see JonnyW\PhantomJs\Http\Request
         **/
        $request = $client->getMessageFactory()->createRequest('https://www.empoweryouth.com/education-loans/apply-loan/7y028kbWNRWwj8VGg3zORK4v9marEp', 'GET');

        /**
         * @see JonnyW\PhantomJs\Http\Response
         **/
        $response = $client->getMessageFactory()->createResponse();
        // Send the request
       $client->send($request, $response);
        echo  $client->getLog(); // Output log
        //die();
        print_r($response);
        if($response->getStatus() === 200) {
            // Dump the requested page content
            echo $response->getContent();
        }
    }
}
