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
use Razorpay\Api\Api;
use common\models\Utilities;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;
use yii\web\Response;

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

    private function generate_username($string_name=null, $rand_no = 200){
        $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
        $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

        $part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
        $part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
        $part3 = ($rand_no)?rand(0, $rand_no):"";

        $username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters
        return $username;
    }

    public function actionApplicationStatusEmail(){
        $params = AppliedApplications::find()
            ->alias('a')
            ->select(['CONCAT(b.first_name," ",b.last_name) name','b.email','a.applied_application_enc_id applied_id'])
            ->where(['application_enc_id'=>'2DeBxPEjOGdjkjgnV3beQpqANyVYw9','current_round'=>2])
            ->innerJoin(Users::tableName().'as b','b.user_enc_id = a.created_by')
            ->asArray()
            ->all();
        $k = 0;
        foreach ($params as $param){
            Yii::$app->mailer->htmlLayout = 'layouts/email';
            $mail = Yii::$app->mailer->compose(
                ['html' => 'job-process-status'],['data'=>$param]
            )
                ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
                ->setTo([$param['email'] => $param['name']])
                ->setSubject('Your Job Application Has Been Accepted');
            if ($mail->send()) {
                $k++;
            }
        }
        echo $k;
    }
    public function actionMoveTitles($limit=50, $offset=0){
        $_flag = false;
        $model = OpenTitles::find()
            ->select(['title_enc_id','name'])
            ->where(['is_deleted' => 0])
            ->limit($limit)
            ->offset($offset)
            ->orderBy(['created_on' => SORT_DESC])
            ->all();
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($model) {
            foreach ($model as $m) {
                $category = Categories::find()
                    ->where(['name' => $m->name])
                    ->asArray()
                    ->one();
                if (empty($category)) {
                    $category = new Categories();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $category->category_enc_id = $m->title_enc_id;
                    $category->name = $m->name;
                    $utilitiesModel->variables['name'] = $category->name;
                    $utilitiesModel->variables['table_name'] = Categories::tableName();
                    $utilitiesModel->variables['field_name'] = 'slug';
                    $category->slug = $utilitiesModel->create_slug();
                    $category->source = 1;
                    $category->created_on = date('Y-m-d H:i:s');
                    $category->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($category->save()) {
                        $_flag = true;
                    } else {
                        $_flag = false;
                    }
                }
                $titleModel = OpenTitles::findOne(['title_enc_id' => $m->title_enc_id]);
                $titleModel->is_deleted = 1;
                $titleModel->last_updated_by = Yii::$app->user->identity->user_enc_id;
                $titleModel->last_updated_on = date('Y-m-d H:i:s');
                if($titleModel->save()){
                    $_flag = true;
                } else {
                    $_flag = false;
                }
            }
            if($_flag){
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Data Move Successfully'
                ];
            } else {
                return [
                    'status' => 201,
                    'title' => 'Oops!!',
                    'message' => 'Something went wrong...'
                ];
            }
        } else {
            return [
                'status' => 201,
                'title' => 'Oops!!',
                'message' => 'Data Not Found'
            ];
        }
    }

    public function actionMoveToBorrower($page=1,$limit=100,$start='2023-08-01',$end='2023-09-01', $app_number = null){
        try {
            $offset = ($page - 1) * $limit;
            $model = LoanApplications::find();
            if ($app_number) {
                $model = $model->where(['application_number'=> $app_number]);
            } else {
                $model = $model->where(['between','created_on',$start,$end]);
            }
            $model = $model->limit($limit)
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
    public function actionMoveResidence($page=1,$limit=100,$start='2023-08-01',$end='2023-09-01', $app_number = null){
        try {
            $offset = ($page - 1) * $limit;
            $model = LoanApplications::find();
            if ($app_number) {
                $model = $model->where(['application_number'=> $app_number]);
            } else {
                $model = $model->where(['between','created_on',$start,$end]);
            }
            $model = $model->limit($limit)
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

    public function actionMoveCredits($page=1,$limit=100,$start='2023-08-01',$end='2023-09-01', $app_number = null){
        try {
            $offset = ($page - 1) * $limit;
            $model = LoanApplications::find();
            if ($app_number) {
                $model = $model->where(['application_number'=> $app_number]);
            } else {
                $model = $model->where(['between','created_on',$start,$end]);
            }
            $model = $model->limit($limit)
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
