<?php

namespace frontend\controllers;
use api\modules\v2\models\LoanApplicationsForm;
use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use common\models\LoanTypes;
use common\models\OrganizationFeeAmount;
use common\models\PathToClaimOrgLoanApplication;
use common\models\PathToUnclaimOrgLoanApplication;
use Razorpay\Api\Api;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Response;

class PaymentController extends Controller
{
 public function actionGateway($id){
     $chk = LoanApplications::findOne(['loan_app_enc_id'=>$id]);
     if (!$chk)
     {
         throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
     }
     $loan_type = LoanTypes::findOne(['loan_name' => 'Annual'])->loan_type_enc_id;
     $loanApplication = LoanApplications::find()
         ->select(['loan_app_enc_id','email','phone'])
         ->where(['loan_app_enc_id' => $id,'is_deleted' => 0])
         ->asArray()
         ->one();
     $claimOrg = PathToClaimOrgLoanApplication::find()
         ->alias('z')
         ->select(['z.loan_app_enc_id','z.assigned_course_enc_id','ace.organization_enc_id'])
         ->where(['z.loan_app_enc_id' => $id])
         ->joinWith(['assignedCourseEnc ace' => function($x){
             $x->joinWith(['organizationEnc oe']);
         }],false);

     $unClaimOrg = PathToUnclaimOrgLoanApplication::find()
         ->alias('z')
         ->select(['z.loan_app_enc_id','z.assigned_course_enc_id','ace1.organization_enc_id'])
         ->where(['z.loan_app_enc_id' => $id])
         ->joinWith(['assignedCourseEnc ace1' => function($x){
             $x->joinWith(['organizationEnc oe1']);
         }],false);
     $college_id = $claimOrg->union($unClaimOrg)->asArray()->one();
         $application_fee = OrganizationFeeAmount::find()
             ->select(['application_fee_amount_enc_id', 'amount', 'gst'])
             ->where(['organization_enc_id' => $college_id['organization_enc_id'], 'loan_type_enc_id' => $loan_type, 'status' => 1])
             ->asArray()
             ->one();
     if (!empty($application_fee)) {
         $amount = $application_fee['amount'];
         $gst = $application_fee['gst'];
         $percentage = ($amount * $gst) / 100;
         $total_amount = $amount + $percentage;
     } else {
         $total_amount = 500;
         $gst = 0;
         $amount = 500;
     }
     $args = [];
     $args['amount'] = $total_amount;
     $args['currency'] = "INR";
     $args['email'] = $loanApplication['email'];
     $args['contact'] = $loanApplication['phone'];
     $token = new LoanApplicationsForm();
     $response = $token->GetToken($args);
     $this->layout = 'widget-layout';
     return $this->render('gateway',[
        'token' => $response['id'],
         'amount' => $amount,
         'gst' => $gst,
         'loan_id' => $id,
     ]);
 }

 public function actionTransections(){
     if (Yii::$app->request->get()){
         $api_key = Yii::$app->params->razorPay->prod->apiKey;
         $api_secret = Yii::$app->params->razorPay->prod->apiSecret;
         $api = new Api($api_key,$api_secret);
         if (Yii::$app->request->get('razorpay_payment_id')){
             $payment = $api->payment->fetch(Yii::$app->request->get('razorpay_payment_id'));
             if ($payment){
                 if ($payment->captured==1){
                     return $this->renderAjax('handleRequest',['get'=>Yii::$app->request->get()]);
                 }else{
                     throw new HttpException(404, Yii::t('frontend', 'Payment Status Not Found, Please Contact The Support Team..'));
                 }
             }
             else{
                 throw new HttpException(404, Yii::t('frontend', 'Page Not Found'));
             }
         }
     }
 }
    public function actionInstituteTransections(){
        if (Yii::$app->request->get()){
            $api_key = Yii::$app->params->razorPay->prod->apiKey;
            $api_secret = Yii::$app->params->razorPay->prod->apiSecret;
            $api = new Api($api_key,$api_secret);
            if (Yii::$app->request->get('razorpay_payment_id')){
                $payment = $api->payment->fetch(Yii::$app->request->get('razorpay_payment_id'));
                if ($payment){
                    if ($payment->captured==1){
                        return $this->renderAjax('instituteHandleRequest',['get'=>Yii::$app->request->get()]);
                    }else{
                        throw new HttpException(404, Yii::t('frontend', 'Payment Status Not Found, Please Contact The Support Team..'));
                    }
                }
                else{
                    throw new HttpException(404, Yii::t('frontend', 'Page Not Found'));
                }
            }
        }
    }
}