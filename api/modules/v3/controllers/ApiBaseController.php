<?php

namespace api\modules\v3\controllers;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use api\modules\v1\models\Candidates;
use common\models\UserAccessTokens;

class ApiBaseController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function response($code, $data = '')
    {
        $message = $this->getStatusCodeMessage($code);

        if (!empty($data)) {
            $response = [
                'response' => $data
            ];
        }

        $this->setHeader($code);

        return $response;
//        echo json_encode($response);
//        die();
    }

    private function getStatusCodeMessage($status)
    {
        $codes = [

            //Success Codes
            200 => 'OK',
            201 => 'New Resource Created',

            //Client Error
            401 => 'Unauthorised',
            404 => 'Resource Not Found',
            405 => 'Method Not allowed',
            409 => 'Conflict', //Validation Error or Creating resource that already exists
            422 => 'Missing Information in Request',

            //Server Error
            500 => 'Information cant be processes', //data didnt saved
            503 => 'Service Unavailable',
        ];
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function setHeader($status)
    {
        $status_header = 'HTTP/2 ' . $status . ' ' . $this->getStatusCodeMessage($status);
//        $content_type = "application/json; charset=utf-8";
        header($status_header);
//        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Empower Youth Foundation");
    }

    public function isAuthorized(){
        $source = Yii::$app->request->headers->get('source');
        $bearer_token = Yii::$app->request->headers->get('Authorization');
        $token = explode(" ", $bearer_token)[1];
        $access_token = UserAccessTokens::findOne(['access_token' => $token]);
        if(!empty($access_token) && $source == $access_token->source){
            if(strtotime($access_token->access_token_expiration) > strtotime("now")) {
                $time_now = date('Y-m-d H:i:s', time('now'));
                $access_token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
                $access_token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
                return Candidates::findOne(['user_enc_id' => $access_token->user_enc_id]);
            }
            return false;
        }
        return false;
    }
}