<?php
namespace frontend\models\script;
use common\models\EmployerApplications;
use Yii;
use JonnyW\PhantomJs\Client;
use yii\base\Widget;
use yii\helpers\Url;

class ImageScript extends Widget
{
    public $content = [];

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $client = Client::getInstance();
        $p = Url::to('@rootDirectory/bin/phantomjs');
        $client->getEngine()->setPath($p);
        $width  = 1250;
        $height = 650;
        $top    = 0;
        $left   = 0;
        $request  = $client->getMessageFactory()->createCaptureRequest();
        $response = $client->getMessageFactory()->createResponse();
        $request->setMethod('GET');
        $request->setUrl(Url::to('/framed-widgets/application-sharing-image','https'));
        $request->setRequestData($this->content); // Set post data
        $imageName = $rand_dir = Yii::$app->getSecurity()->generateRandomString().'.png';
        $savePath = Url::to('@rootDirectory/files/sharing-images/'.$imageName);
        $userPath = Url::to('@root/files/sharing-images/'.$imageName);
        $request->setOutputFile($savePath);
        $request->setViewportSize($width, $height);
        $request->setCaptureDimensions($width, $height, $top, $left);
        $request->setQuality(100);
        $client->send($request, $response);
        $update = Yii::$app->db->createCommand()
            ->update(EmployerApplications::tableName(), ['image' => $imageName, 'last_updated_on' => date('Y-m-d H:i:s')], ['application_enc_id' => $this->content['app_id']])
            ->execute();
        return Url::to($userPath,'https');
    }
}