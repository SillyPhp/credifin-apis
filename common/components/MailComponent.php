<?php


namespace common\components;

use Yii;
use yii\base\Component;

class MailComponent extends Component
{

    public $receivers = [];
    public $template = '';
    public $subject = '';
    public $data;
    public $sender = [];
    private $_mails = [];
    private $_mail;

    public function init()
    {
        parent::init();
        $this->sender['email'] = Yii::$app->params->from_email;
        $this->sender['name'] = Yii::$app->params->site_name;
    }

    public function send()
    {
        Yii::$app->mailer->htmlLayout = 'layouts/html';

        foreach ($this->receivers as $receiver) {
            $this->_mail = Yii::$app
                ->mailer
                ->compose(
                    ['html' => $this->template], ['data' => $this->data]
                )
                ->setFrom([$this->sender['email'] => $this->sender['name']]);

            if (!empty($receiver['name'])) {
                $this->_mail->setTo([$receiver['email'] => $receiver['name']]);
            } else {
                $this->_mail->setTo($receiver['email']);
            }
            $this->_mail->setSubject($this->subject);
            $this->_mails[] = $this->_mail;
        }

        if (Yii::$app->mailer->sendMultiple($this->_mails)) {
            return true;
        }

        return false;
    }

}