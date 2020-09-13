<?php
namespace common\models\extended;
use common\models\Utilities;
use common\models\Webinar;
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

  public function checkout()
  {
      $webinar_amount = Webinar::find()
          ->where(['webinar_enc_id'=>$this->webinar_enc_id])
          ->asArray()
          ->one();

      if (!empty($webinar_amount)) {
          $this->payment_amount = $webinar_amount['price'];
          $this->payment_gst = $webinar_amount['gst'];
          $percentage = ($this->payment_amount * $this->payment_gst) / 100;
          $total_amount = $this->payment_amount + $percentage;
      }
      else{
          return false;
      }
      $args = [];
      $args['amount'] = $total_amount;
      $args['currency'] = "INR";
      $response = PaymentsModule::GetToken($args);
      $transaction = Yii::$app->db->beginTransaction();
      try {
          if (isset($response['status']) && $response['status'] == 'created') {
              $token = $response['id'];
              $payment = new \common\models\WebinarPayments();
              $utilitiesModel = new \common\models\Utilities();
              $utilitiesModel->variables['string'] = time() . rand(100, 100000);
              $payment->payment_enc_id = $utilitiesModel->encrypt();
              $payment->webinar_enc_id = $this->webinar_enc_id;
              $payment->created_by = $this->created_by;
              $payment->payment_token = $token;
              $payment->payment_amount = $this->payment_amount;
              $payment->payment_gst = $this->payment_gst;
              $payment->created_on = date('Y-m-d H:i:s');
              if (!$payment->save()) {
                  $transaction->rollBack();
                  return false;
              } else {
                  $transaction->commit();
                  $data = [];
                  $data['webinar_enc_id'] = $this->webinar_enc_id;
                  $data['payment_enc_id'] = $payment->payment_enc_id;
                  $data['payment_token'] = $payment->payment_token;
                  return $data;
              }
          }else{
              return false;
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
          return true;
      }

  }
}