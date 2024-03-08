<?php
namespace common\models\allcloud;
use Yii;
class Auth {

    public static function generateToken($options, $payload){
        try {
            $returnArr = [];

            $AppId = $options['AppId'];
            $USER_TOKEN = $options['USER_TOKEN'];
            $USER_SECRET = $options['USER_SECRET'];

            if(isset($options['requestHttpMethod']) && isset($options['Request_URL'])){

                // Get Request URI
                $Request_URI = strtolower(urlencode($options['Request_URL']));

                // Get Request Time Stamp
                $epochStart = date("Y")."-01-01 00:00:00";
                $currentDateTime = date('Y-m-d H:i:s');
                $epochStartDate = new \DateTime($epochStart);
                $currentDate = new \DateTime($currentDateTime);
                $requestTimeStamp = $currentDate->getTimestamp() - $epochStartDate->getTimestamp();

                // Get Nonce - It should be a new Global unique identifier which is converted to Numeric format
                $nonce = self::GenerateUniqueId(32);

                if($options['requestHttpMethod']!='GET'){
                    $requestContentHash = md5($payload,true);
                    $requestContentBase64String = base64_encode($requestContentHash);
                }else{
                    $requestContentBase64String='';
                }

                // Generate below data for encryption and Generating the Authorization
                $signatureRawData = $AppId.$options['requestHttpMethod'].$Request_URI.$requestTimeStamp.$nonce.$requestContentBase64String;

                $secretKeyByteArray = $USER_SECRET;

                $signatureBytes = hash_hmac("sha256", $signatureRawData, $secretKeyByteArray, true);

                $requestSignatureBase64String = base64_encode($signatureBytes);

                // Setting the values in the Authorization header using custom scheme (amx)
                //$AllCloudAuthorizationHeader = "amx ".$AppId.":"."MY".":"."NAME".":"."IS SNEH KAUSHAL".":".$USER_TOKEN;
                $AllCloudAuthorizationHeader = "amx ".$AppId.":".$requestSignatureBase64String.":".$nonce.":".$requestTimeStamp.":".$USER_TOKEN;

                // Response Array
                $returnArr = [
                    'status' => true,'message' => 'Sucess','data' => ['Authorization' => $AllCloudAuthorizationHeader]
                ];


            } else {
                $returnArr = ['status'=>false, "message" => "Invalid Parameters. Please provide all required parameters to this API."];
            }

            return [
                'status'=>true,
                'token'=>$returnArr
            ];
        } catch (\Exception $ex) {
            return [
                'status'=>false,
                'error'=>$ex->getMessage()
            ];
        }
    }

    private static function GenerateUniqueId($n){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}