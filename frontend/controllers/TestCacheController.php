<?php

namespace frontend\controllers;
use common\models\CreditLoanApplicationReports;
use common\models\EmiCollection;
use common\models\LoanApplicantResidentialInfo;
use common\models\LoanApplications;
use common\models\LoanCoApplicants;
use common\models\RandomColors;
use common\models\spaces\Spaces;
use phpDocumentor\Reflection\Types\Null_;
use yii\web\Controller;
use Yii;

class TestCacheController extends Controller
{
//    public function actionTokenTest(){
//        $options['org_id'] = 'R09YXEkaql0a9WWvJ8Y27531Wdo82J';
//        $keys = \common\models\credentials\Credentials::getrazorpayKey($options);
//        print_r($keys);
//    }

    public function actionTokenTest(){
       $x = $this->generateAllCloudAuthHeader('GET','https://staging.allcloud.in/apiv2phfleasing/api/Customer/GetCustomerByCIFIdAsync/1','');
      print_r($x);
    }

    private  function generateAllCloudAuthHeader($requestHttpMethod, $Request_URL, $payload){
        try {
            $returnArr = [];

            $AppId = '4d53bce03ec34c0a911182d4c228ee6c:';
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

    public function actionMoveToBorrower($page=1,$limit=100,$start='2023-08-01',$end='2023-09-01'){
        try {
            $offset = ($page - 1) * $limit;
            $model = LoanApplications::find()
                ->where(['between','created_on',$start,$end])
                ->limit($limit)
                ->offset($offset)
                ->asArray()->all();

            $transaction = Yii::$app->db->beginTransaction();
            $count = 0;
            foreach ($model as $mod) {
                $dataModel = new LoanCoApplicants();
                $dataModel->loan_co_app_enc_id = $mod['loan_app_enc_id'];
                $dataModel->loan_app_enc_id = $mod['loan_app_enc_id'];
                $dataModel->name = $mod['applicant_name'];
                $dataModel->email = $mod['email'];
                $dataModel->cibil_score = $mod['cibil_score'];
                $dataModel->equifax_score = $mod['equifax_score'];
                $dataModel->crif_score = $mod['crif_score'];
                $dataModel->phone = $mod['phone'];
                $dataModel->relation = Null;
                $dataModel->borrower_type = 'Borrower';
                $dataModel->employment_type = Null;
                $dataModel->gender = $mod['gender'];
                $dataModel->annual_income = $mod['yearly_income'];
                $dataModel->co_applicant_dob = $mod['applicant_dob'];
                $dataModel->image = $mod['image'];
                $dataModel->image_location = $mod['image_location'];
                $dataModel->pan_number = $mod['pan_number'];
                $dataModel->aadhaar_number = $mod['aadhaar_number'];
                $dataModel->voter_card_number = $mod['voter_card_number'];
                $dataModel->driving_license_number = Null;
                $dataModel->aadhaar_link_phone_number = $mod['aadhaar_link_phone_number'];
                $dataModel->created_by = $mod['created_by'];
                $dataModel->created_on = $mod['created_on'];
                $dataModel->updated_on = $mod['updated_on'];
                $dataModel->updated_by = $mod['updated_by'];
                $dataModel->is_deleted = $mod['is_deleted'];
                if (!$dataModel->save()) {
                    $transaction->rollBack();
                    throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($dataModel->errors, 0, false)));
                }
                $count++;
            }
            echo $count.' entry moved to database';
            $transaction->commit();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function actionMoveResidence($page=1,$limit=100,$start='2023-08-01',$end='2023-09-01'){
        try {
            $offset = ($page - 1) * $limit;
            $model = LoanApplications::find()
                ->where(['between','created_on',$start,$end])
                ->limit($limit)
                ->offset($offset)
                ->asArray()->all();
            $transaction = Yii::$app->db->beginTransaction();
            $count = 0;
            foreach ($model as $mod) {
                $datamodel = LoanApplicantResidentialInfo::find()
                ->where(['loan_app_enc_id'=>$mod['loan_app_enc_id']])
                ->andWhere([
                    'or',
                    ['loan_co_app_enc_id'=>null],
                    ['loan_co_app_enc_id'=>''],
                    ['loan_co_app_enc_id'=>Null],
                ])->one();
                if ($datamodel){
                    $datamodel->loan_co_app_enc_id = $datamodel->loan_app_enc_id;
                    if (!$datamodel->save()) {
                        $transaction->rollBack();
                        throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($datamodel->errors, 0, false)));
                    }
                    $count++;
                }
            }
            echo $count.' entry moved to database';
            $transaction->commit();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function actionMoveCredits($page=1,$limit=100,$start='2023-08-01',$end='2023-09-01'){
        try {
            $offset = ($page - 1) * $limit;
            $model = LoanApplications::find()
                ->where(['between','created_on',$start,$end])
                ->limit($limit)
                ->offset($offset)
                ->asArray()->all();
            $transaction = Yii::$app->db->beginTransaction();
            $count = 0;
            foreach ($model as $mod) {
                $datamodel = CreditLoanApplicationReports::find()
                    ->where(['loan_app_enc_id'=>$mod['loan_app_enc_id']])
                    ->andWhere([
                        'or',
                        ['loan_co_app_enc_id'=>null],
                        ['loan_co_app_enc_id'=>''],
                        ['loan_co_app_enc_id'=>Null],
                    ])->one();
                if ($datamodel){
                    $datamodel->loan_co_app_enc_id = $datamodel->loan_app_enc_id;
                    if (!$datamodel->save()) {
                        $transaction->rollBack();
                        throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($datamodel->errors, 0, false)));
                    }
                    $count++;
                }
            }
            echo $count.' entry moved to database';
            $transaction->commit();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}
