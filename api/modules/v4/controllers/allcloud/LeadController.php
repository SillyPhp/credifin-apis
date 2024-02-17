<?php
namespace api\modules\v4\controllers\allcloud;
use api\modules\v4\controllers\ApiBaseController;
use common\models\allcloud\Auth;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
class LeadController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'add-new-lead',
                'add-new-loan',
                'add-customer',
                'add-documents',
                'generate-token',
                'add-new-collection',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'add-new-lead' => ['POST', 'OPTIONS'],
                'add-new-loan' => ['POST', 'OPTIONS'],
                'add-customer' => ['POST', 'OPTIONS'],
                'add-documents' => ['POST', 'OPTIONS'],
                'add-new-collection' => ['POST', 'OPTIONS'],
            ]
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                // restrict access to
                'Origin' => ['*'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Method' => ['POST', 'PUT', 'GET', 'OPTIONS'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Request-Headers' => ['X-Wsse'],
                // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                'Access-Control-Allow-Credentials' => False,
                // Allow OPTIONS caching
                'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ];
        return $behaviors;
    }

    public function actionGenerateToken(){
        $payload = Yii::$app->request->post();
        $options = [];
        $options['AppId'] = Yii::$app->params->allcloud->phf->dev->AppId;
        $options['USER_TOKEN'] = Yii::$app->params->allcloud->phf->dev->USER_TOKEN;
        $options['USER_SECRET'] =  Yii::$app->params->allcloud->phf->dev->USER_SECRET;
        $options['requestHttpMethod'] = 'POST';
        $options['Request_URL'] = Yii::$app->params->allcloud->phf->dev->UrlPrefix.'apiv2phfleasing/api/LeadDetail/AddLeadDetail';
        $payload = json_encode($payload);
       return $res = Auth::generateToken($options,$payload);
    }

    public function actionAddNewCollection(){
        try {
            if ($user = $this->isAuthorized()){
                $payload = Yii::$app->request->post();
                $options = [];
                $options['AppId'] = Yii::$app->params->allcloud->phf->dev->AppId;
                $options['USER_TOKEN'] = Yii::$app->params->allcloud->phf->dev->USER_TOKEN;
                $options['USER_SECRET'] =  Yii::$app->params->allcloud->phf->dev->USER_SECRET;
                $options['requestHttpMethod'] = 'POST';
                $options['Request_URL'] = Yii::$app->params->allcloud->phf->dev->UrlPrefix.'apiv2phfleasing/api/Payment/SaveRepayment';
                $payload = json_encode($payload);
                $res = Auth::generateToken($options,$payload);
                if ($res['status']){
                    $auth = $res['token']['data']['Authorization'];
                    $ch = curl_init($options['Request_URL']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
                    curl_setopt($ch, CURLOPT_POST, true); // Set the request type to POST
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Set the POST data
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        "Content-Type: application/json", // You can adjust the content type as needed
                        "Authorization: $auth",
                    ]);
                    return   $response = curl_exec($ch);
                    if (curl_errno($ch)) {
                        return  $this->response(422, ['message'=>'Error','Error'=>'cURL Error: ' . curl_error($ch)]);
                    }else{
                        $decodeResponse = json_decode($response,true);
                        if (isset($decodeResponse['LeadDetailId'])&&!empty($decodeResponse['LeadDetailId'])){
                            return $this->response(200, ['message'=>'Success','data'=>$decodeResponse]);
                        }else{
                            return  $this->response(422, ['message'=>'Error','Error'=>$decodeResponse]);
                        }
                    }
                }

            } else{
                return  $this->response(401, ['message'=>'Error','Error'=>'Your Are Not Allowed To Perform This Action']);
            }
        }catch (\Exception $exception){
            return  $this->response(422, ['message'=>'Error','Error'=>$exception->getMessage()]);
        }
    }
    public function actionAddNewLead(){
        try {
            if ($user = $this->isAuthorized()){
                $payload = Yii::$app->request->post();
                $options = [];
                $options['AppId'] = Yii::$app->params->allcloud->phf->dev->AppId;
                $options['USER_TOKEN'] = Yii::$app->params->allcloud->phf->dev->USER_TOKEN;
                $options['USER_SECRET'] =  Yii::$app->params->allcloud->phf->dev->USER_SECRET;
                $options['requestHttpMethod'] = 'POST';
                $options['Request_URL'] = Yii::$app->params->allcloud->phf->dev->UrlPrefix.'apiv2phfleasing/api/LeadDetail/AddLeadDetail';
                $payload = json_encode($payload);
                $res = Auth::generateToken($options,$payload);
                if ($res['status']){
                    $auth = $res['token']['data']['Authorization'];
                    $ch = curl_init($options['Request_URL']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
                    curl_setopt($ch, CURLOPT_POST, true); // Set the request type to POST
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Set the POST data
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        "Content-Type: application/json", // You can adjust the content type as needed
                        "Authorization: $auth",
                    ]);
                 return   $response = curl_exec($ch);
                    if (curl_errno($ch)) {
                        return  $this->response(422, ['message'=>'Error','Error'=>'cURL Error: ' . curl_error($ch)]);
                    }else{
                        $decodeResponse = json_decode($response,true);
                        if (isset($decodeResponse['LeadDetailId'])&&!empty($decodeResponse['LeadDetailId'])){
                            return $this->response(200, ['message'=>'Success','data'=>$decodeResponse]);
                        }else{
                            return  $this->response(422, ['message'=>'Error','Error'=>$decodeResponse]);
                        }
                    }
                }

            } else{
                return  $this->response(401, ['message'=>'Error','Error'=>'Your Are Not Allowed To Perform This Action']);
            }
        }catch (\Exception $exception){
            return  $this->response(422, ['message'=>'Error','Error'=>$exception->getMessage()]);
        }
    }

    public function actionAddNewLoan(){
        try {
            if ($user = $this->isAuthorized()){
                $payload = Yii::$app->request->post();
                $options = [];
                $options['AppId'] = Yii::$app->params->allcloud->phf->dev->AppId;
                $options['USER_TOKEN'] = Yii::$app->params->allcloud->phf->dev->USER_TOKEN;
                $options['USER_SECRET'] =  Yii::$app->params->allcloud->phf->dev->USER_SECRET;
                $options['requestHttpMethod'] = 'POST';
                $options['Request_URL'] = Yii::$app->params->allcloud->phf->dev->UrlPrefix.'apiv2phfleasing/api/Loan/SaveNewLoanByLeadDetail';
                $payload = json_encode($payload);
                $res = Auth::generateToken($options,$payload);
                if ($res['status']){
                    $auth = $res['token']['data']['Authorization'];
                    $ch = curl_init($options['Request_URL']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
                    curl_setopt($ch, CURLOPT_POST, true); // Set the request type to POST
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Set the POST data
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        "Content-Type: application/json", // You can adjust the content type as needed
                        "Authorization: $auth",
                    ]);
                return    $response = curl_exec($ch);
                    if (curl_errno($ch)) {
                        return  $this->response(422, ['message'=>'Error','Error'=>'cURL Error: ' . curl_error($ch)]);
                    }else{
                        $decodeResponse = json_decode($response,true);
                       // print_r($decodeResponse);exit();
                        if (isset($decodeResponse['LeadDetailId'])&&!empty($decodeResponse['LeadDetailId'])){
                            return $this->response(200, ['message'=>'Success','data'=>$decodeResponse]);
                        }else{
                            return  $this->response(422, ['message'=>'Error','Error'=>$decodeResponse]);
                        } 
                    }
                }

            } else{
                return  $this->response(401, ['message'=>'Error','Error'=>'Your Are Not Allowed To Perform This Action']);
            }
        }catch (\Exception $exception){
            return  $this->response(422, ['message'=>'Error','Error'=>$exception->getMessage()]);
        }
    }

    public function actionAddCustomer(){
        try {
            if ($user = $this->isAuthorized()){
                $payload = Yii::$app->request->post();
                $options = [];
                $options['AppId'] = Yii::$app->params->allcloud->phf->dev->AppId;
                $options['USER_TOKEN'] = Yii::$app->params->allcloud->phf->dev->USER_TOKEN;
                $options['USER_SECRET'] =  Yii::$app->params->allcloud->phf->dev->USER_SECRET;
                $options['requestHttpMethod'] = 'POST';
                $options['Request_URL'] = Yii::$app->params->allcloud->phf->dev->UrlPrefix.'apiv2phfleasing/api/Customer/SaveCustomerData';
                $payload = json_encode($payload);
                $res = Auth::generateToken($options,$payload);
                if ($res['status']){
                    $auth = $res['token']['data']['Authorization'];
                    $ch = curl_init($options['Request_URL']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
                    curl_setopt($ch, CURLOPT_POST, true); // Set the request type to POST
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Set the POST data
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        "Content-Type: application/json", // You can adjust the content type as needed
                        "Authorization: $auth",
                    ]);
                      $response = curl_exec($ch);
                    if (curl_errno($ch)) {
                        return  $this->response(422, ['message'=>'Error','Error'=>'cURL Error: ' . curl_error($ch)]);
                    }else{
                        $decodeResponse = json_decode($response,true);
                        if (isset($decodeResponse['CustomerId'])&&!empty($decodeResponse['CustomerId'])){
                           return $this->response(200, ['message'=>'Success','data'=>$decodeResponse]);
                        }else{
                            return  $this->response(422, ['message'=>'Error','Error'=>$response]);
                        }
                    }
                }

            } else{
                return  $this->response(401, ['message'=>'Error','Error'=>'Your Are Not Allowed To Perform This Action']);
            }
        }catch (\Exception $exception){
            return  $this->response(422, ['message'=>'Error','Error'=>$exception->getMessage()]);
        }
    }

    public function actionAddDocuments(){
        try {
            if ($user = $this->isAuthorized()){
                $payload = Yii::$app->request->post();
                $options = [];
                $options['AppId'] = Yii::$app->params->allcloud->phf->dev->AppId;
                $options['USER_TOKEN'] = Yii::$app->params->allcloud->phf->dev->USER_TOKEN;
                $options['USER_SECRET'] =  Yii::$app->params->allcloud->phf->dev->USER_SECRET;
                $options['requestHttpMethod'] = 'POST';
                $options['Request_URL'] = Yii::$app->params->allcloud->phf->dev->UrlPrefix.'apiv2phfleasing/api/UploadDocuments/UploadDocumentsBase64DTO';
                //$options['Request_URL'] = Yii::$app->params->allcloud->phf->dev->UrlPrefix.'apiv2phfleasing/api/Customer/CustomerBase64UploadDocumentDTO';
                $payload = json_encode($payload);
                $res = Auth::generateToken($options,$payload);
                if ($res['status']){
                    $auth = $res['token']['data']['Authorization'];
                    $ch = curl_init($options['Request_URL']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
                    curl_setopt($ch, CURLOPT_POST, true); // Set the request type to POST
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload); // Set the POST data
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        "Content-Type: application/json", // You can adjust the content type as needed
                        "Authorization: $auth",
                    ]);
                 return   $response = curl_exec($ch);
                    if (curl_errno($ch)) {
                        return  $this->response(422, ['message'=>'Error','Error'=>'cURL Error: ' . curl_error($ch)]);
                    }else{
                        $decodeResponse = json_decode($response,true);
                    }
                }

            } else{
                return  $this->response(401, ['message'=>'Error','Error'=>'Your Are Not Allowed To Perform This Action']);
            }
        }catch (\Exception $exception){
            return  $this->response(422, ['message'=>'Error','Error'=>$exception->getMessage()]);
        }
    }
}