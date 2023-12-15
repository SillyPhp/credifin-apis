<?php

namespace frontend\controllers;
use common\models\FinancerLoanProductPurpose;
use common\models\FinancerLoanProducts;
use common\models\LoanApplications;
use common\models\OrganizationLocations;
use common\models\spaces\Spaces;
use common\models\TestData;
use Razorpay\Api\Api;
use yii\db\Expression;
use yii\web\Controller;
use Yii;
class TestCacheController extends Controller
{
    public function actionTokenTest(){
        $x = $this->generateAllCloudAuthHeader('GET','https://staging.allcloud.in/apiv2phfleasing/api/Customer/GetCustomerByCIFIdAsync/92','');
        print_r($x);
    }

    private  function generateAllCloudAuthHeader($requestHttpMethod, $Request_URL, $payload){
        try {
            $returnArr = [];

            $AppId = '4d53bce03ec34c0a911182d4c228ee6c';
            $USER_TOKEN = '786df557-a7ed-4368-a491-e931ba349aba';
            $USER_SECRET = 'b621f322-e85e-47ff-b965-e731a26e5872';

            if(isset($requestHttpMethod) && isset($Request_URL)){

                // Get Request URI
                $Request_URI = strtolower(urlencode($Request_URL));

                // Get Request Time Stamp
                $epochStart = date("Y")."-01-01 00:00:00";
                $currentDateTime = date('Y-m-d H:i:s');
                $epochStartDate = new \DateTime($epochStart);
                $currentDate = new \DateTime($currentDateTime);
                $requestTimeStamp = $currentDate->getTimestamp() - $epochStartDate->getTimestamp();

                // Get Nonce - It should be a new Global unique identifier which is converted to Numeric format
                $nonce = self::GenerateUniqueId(32);

                if($requestHttpMethod!='GET'){
                    $requestContentHash = md5($payload,true);
                    $requestContentBase64String = base64_encode($requestContentHash);
                }else{
                    $requestContentBase64String='';
                }

                // Generate below data for encryption and Generating the Authorization
                $signatureRawData = $AppId.$requestHttpMethod.$Request_URI.$requestTimeStamp.$nonce.$requestContentBase64String;

                $secretKeyByteArray = $USER_SECRET;

                $signatureBytes = hash_hmac("sha256", $signatureRawData, $secretKeyByteArray, true);

                $requestSignatureBase64String = base64_encode($signatureBytes);

                // Setting the values in the Authorization header using custom scheme (amx)
                $AllCloudAuthorizationHeader = "amx ".$AppId.":".$requestSignatureBase64String.":".$nonce.":".$requestTimeStamp.":".$USER_TOKEN;

                // Response Array
                $returnArr = [
                    'status' => true,'message' => 'Sucess','data' => ['Authorization' => $AllCloudAuthorizationHeader]
                ];


            } else {
                $returnArr = ['status'=>false, "message" => "Invalid Parameters. Please provide all required parameters to this API."];
            }

            return $returnArr;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
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

    public function actionCurlSaveCustomer(){
        // Data to send in the POST request (key-value pairs)
        $data = '{
        "FirstName": "Sneh",
        "LastName": "Kant",
        "DOB": "1993-06-08",
        "ContactNumber":9597868802,
        "PrimaryAddressLine1":"xyz",
        "PrimaryArea": "HSR Layout",
        "PrimaryTown": "Bangalore",
        "PrimaryPostcode": "560006",
        "PrimaryStateId": 12,
        "PrimaryStateName": "Karnataka",
        }';
        // API endpoint URL
        $url = 'https://staging.allcloud.in/apiv2phfleasing/api/Customer/SaveCustomerData';

        $token =  $this->generateAllCloudAuthHeader('POST',$url,$data);
        $auth = $token['data']['Authorization'];
        // Custom headers
        $headers = [
            "Content-Type: application/json", // You can adjust the content type as needed
            "Authorization: $auth", // Add any authorization headers here
        ];

// Initialize cURL session
        $ch = curl_init($url);

// Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
        curl_setopt($ch, CURLOPT_POST, true); // Set the request type to POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Set the POST data
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Set custom headers

// Execute cURL session and store the response in $response
        return  $response = curl_exec($ch);

// Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }

// Close cURL session
        curl_close($ch);

// Display the response from the server
        echo $response;

        echo '<br>';
        echo 'url hit on: '.$url;
    }

    public function actionCurlSaveLead(){
        // Data to send in the POST request (key-value pairs)
        $data = '{
  "LeadDetailId": 0,
  "ProductTypeId": 1,
  "CentreName": "Default Centre",
  "CompanyRoleId": "198",
  "LoanCategoryId": 0,
  "LoanAmount": 200000,
  "LoanTenure": 24,
  "SubmitLead": true,
  "IsLms": true,
  "LeadSourceId": 2,
  "DealerId": 3,
  "LeadSourceDetailId": 3,
  "PurposeofLoan": "1",
  "SchemeId": 6,
  "DownPayment": 0,
  "LoanSegmentId": 1,
  "LoanTypeId": 9,
  "LstLeadCustomers": [
    {
      "BorrowerId": 93,
      "BorrowerTypeId": 0,
      "OrderTypeId": 0,
      "RelationToBorrower": 1,
      "GuarantorTypeId": null
    }
  ],
  "LstTaggingDto": null,
  "ObjVlVehicleDto": {
    "MfgYear": 2021,
    "VehicleTypeId": 1,
    "VehicleClassId": 1,
    "VehicleMakeId": 2,
    "VehicleClassVariantId": 1,
    "RegistrationNo": "CFDGKd",
    "InvoiceAmount": 20000,
    "ResidualValue": 20000,
    "UploadDocumentDTOCollection": null
  },
  "ObjPlSalaryBorrowerDto": null,
  "ObjPlOrganizationBorrowerDto": null,
  "IsProgramType": false
}';
        // API endpoint URL
        //$url = 'https://staging.allcloud.in/apiv2phfleasing/api/Loan/SaveNewLoanByLeadDetail';
        $url = 'https://staging.allcloud.in/apiv2phfleasing/api/LeadDetail/AddLeadDetail';

        $token =  $this->generateAllCloudAuthHeader('POST',$url,$data);
        $auth = $token['data']['Authorization'];
        // Custom headers
        $headers = [
            "Content-Type: application/json", // You can adjust the content type as needed
            "Authorization: $auth", // Add any authorization headers here
        ];

// Initialize cURL session
        $ch = curl_init($url);

// Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
        curl_setopt($ch, CURLOPT_POST, true); // Set the request type to POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Set the POST data
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Set custom headers

// Execute cURL session and store the response in $response
          $response = curl_exec($ch);
        print_r(json_decode($response,true));
        die();

// Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }

// Close cURL session
        curl_close($ch);

// Display the response from the server
       print_r(json_decode($response,true));

        echo '<br>';
        echo 'url hit on: '.$url;
    }

    public function actionEycdn(){
       // $get = $_POST;
        $get = Yii::$app->request->post();
        print_r($get);exit();
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
    }

}
