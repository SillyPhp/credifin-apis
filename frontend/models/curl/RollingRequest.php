<?php
namespace frontend\models\curl;

class RollingRequest
{
    private $rc;
    public $collect = [];

    function __construct(){
        $this->rc = new RollingCurl(array($this, 'processPage'));
    }

    function processPage($response, $info){
        $collect[] = $response;
    }

    function run($urls){
        foreach ($urls as $url){
            $request = new RollingCurlRequest($url);
            $this->rc->add($request);
        }
        $this->rc->execute();
    }
}