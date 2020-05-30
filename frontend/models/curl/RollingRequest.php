<?php
namespace frontend\models\curl;

class RollingRequest
{
    private $rc;

    function __construct(){
        $this->rc = new RollingCurl(array($this, 'processPage'));
    }

    function processPage($response, $info){
        print_r($response);
    }

    function run($urls){
        foreach ($urls as $url){
            $request = new RollingCurlRequest($url);
            $this->rc->add($request);
        }
        $this->rc->execute();
    }
}