<?php


namespace common\components;

use common\models\Utilities;
use Yii;
use yii\base\Component;


class EmailLogs extends Component
{

    public $user_enc_id = '';
    public $organization_enc_id = '';
    public $email_type = '';
    public $email_template = '';
    public $email_subject = '';
    public $email_receivers = [];
    public $data = [];
    private $_flag = false;

    public function setEmailLog()
    {
        foreach ($this->email_receivers as $r) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $mail_log = new \common\models\EmailLogs();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $mail_log->email_log_enc_id = $utilitiesModel->encrypt();
                $mail_log->email_type = $this->email_type;
                $mail_log->user_enc_id = $this->user_enc_id;
                $mail_log->organization_enc_id = $this->organization_enc_id;
                $mail_log->subject = $this->email_subject;
                $mail_log->template = $this->email_template;
                $mail_log->receiver_email = $r['email'];
                $mail_log->receiver_name = $r['name'];
                $mail_log->receiver_phone = $r['phone'];
                $mail_log->template = $this->email_template;
                $mail_log->is_sent = 1;
                $mail_log->created_on = date('Y-m-d H:i:s');
                if ($mail_log->save()) {
                    $mail = Yii::$app->mail;
                    $mail->receivers = [];
                    $mail->receivers[] = [
                        'name' => $r['name'],
                        'email' => $r['email']
                    ];
                    $mail->subject = $this->email_subject;
                    $mail->data = $this->data;
                    $mail->template = $this->email_template;
                    if ($mail->send()) {
                        $mail_log_update = \common\models\EmailLogs::find()
                            ->where(['email_log_enc_id' => $mail_log->email_log_enc_id])
                            ->one();
                        $mail_log_update->is_sent = 0;
                        $mail_log_update->last_updated_on = date('Y-m-d H:i:s');
                        if($mail_log_update->update()){
                           $transaction->commit();
                        }
                        $this->_flag = true;
                    }
                }else{
                    $transaction->rollback();
                    $this->_flag = false;
                }
            }catch (Exception $e){
                $transaction->rollBack();
                $this->_flag = false;
            }
        }
        return $this->_flag;
    }
}