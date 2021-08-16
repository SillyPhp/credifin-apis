<?php
namespace common\models\extended;
use common\models\Utilities;
use common\models\Webinar;
use common\models\WebinarRegistrations;
use Yii;
class WebinarPayments extends \common\models\WebinarPayments
{
  public $_flag;
  public $payment_id; //payment success id
  public $payment_status;
  public $payment_token;
  public $payment_gst;
  public $payment_amount;
  public $payment_enc_id;
  public $registration_enc_id;

  public function checkout()
  {
      $webinar_amount = Webinar::find()
          ->where(['webinar_enc_id'=>$this->webinar_enc_id])
          ->asArray()
          ->one();

      if (!empty($webinar_amount)) {
          $total_amount = $webinar_amount['price'];
          $gst = $webinar_amount['gst'];
          $percentage = ($total_amount * $gst) / 100;
          $total_amount = $total_amount + $percentage;
          $args = [];
          $args['amount'] = $this->floatPaisa($total_amount); //for inr float to paisa format for razor pay payments
          $args['currency'] = "INR";
          $args['accessKey'] = Yii::$app->params->EmpowerYouth->permissionKey;
          $response = PaymentsModule::_authPayToken($args);

          $this->payment_amount = $webinar_amount['price'];
          $this->payment_gst = $webinar_amount['gst'];
//          $percentage = ($this->payment_amount * $this->payment_gst) / 100;
//          $total_amount = $this->payment_amount + $percentage;
      }
      else{
          return false;
      }
//      $args = [];
//      $args['amount'] = $total_amount;
//      $args['currency'] = "INR";
//      $response = PaymentsModule::GetToken($args);
      $transaction = Yii::$app->db->beginTransaction();
      try {
          $Registration = new WebinarRegistrations();
          $utilitiesModel = new \common\models\Utilities();
          $utilitiesModel->variables['string'] = time() . rand(100, 100000);
          $Registration->register_enc_id = $utilitiesModel->encrypt();
          $Registration->webinar_enc_id = $this->webinar_enc_id;
          $Registration->created_by = $this->created_by;
          $Registration->created_on = date('Y-m-d H:i:s');
          if (!$Registration->save())
          {
              $transaction->rollBack();
              $this->_flag = false;
              return false;
          }else{
              $this->_flag = true;
          }

          if (isset($response['status']) && $response['status'] == 'created') {
              $token = $response['id'];
              $payment = new \common\models\WebinarPayments();
              $utilitiesModel = new \common\models\Utilities();
              $utilitiesModel->variables['string'] = time() . rand(100, 100000);
              $payment->payment_enc_id = $utilitiesModel->encrypt();
              $payment->webinar_enc_id = $this->webinar_enc_id;
              $payment->registration_enc_id = $Registration->register_enc_id;
              $payment->created_by = $this->created_by;
              $payment->payment_token = $token;
              $payment->payment_amount = $this->payment_amount;
              $payment->payment_gst = $this->payment_gst;
              $payment->created_on = date('Y-m-d H:i:s');
              if (!$payment->save()) {
                  $transaction->rollBack();
                  $this->_flag = false;
                  return false;
              } else {
                 $this->_flag = true;
              }
          }else{
              $this->_flag = false;
              return false;
          }

          if ($this->_flag)
          {
              $transaction->commit();
              $data = [];
              $data['webinar_enc_id'] = $this->webinar_enc_id;
              $data['payment_enc_id'] = $payment->payment_enc_id;
              $data['payment_token'] = $payment->payment_token;
              $data['registration_enc_id'] = $Registration->register_enc_id;
              return $data;
          }
      }
      catch (\Exception $exception) {
          $transaction->rollBack();
          return false;
      }
  }
  public function updateStatus()
  {
      $payment_model = \common\models\WebinarPayments::findOne(['payment_enc_id'=>$this->payment_enc_id]);
      $payment_model->payment_status = $this->payment_status;
      $payment_model->payment_id = $this->payment_id;
      if (!$payment_model->save())
      {
          return false;
      }else{
         if ($this->payment_status=='captured'||$this->payment_status=='created')
         {
             $Registration = WebinarRegistrations::findOne(['register_enc_id'=>$this->registration_enc_id]);
             $Registration->status = 1;
             if (!$Registration->save())
             {
                 return false;
             }else{
                 return true;
             }
         }
         return true;
      }

  }

    private function floatPaisa($amount)
    {
        $c = $amount * 100;
        return (int)$c;
    }
}