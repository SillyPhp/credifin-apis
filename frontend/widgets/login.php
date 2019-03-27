<?php
namespace frontend\widgets;

use frontend\models\accounts\ForgotPasswordForm;
use frontend\models\accounts\IndividualSignUpForm;
use frontend\models\accounts\LoginForm;
use yii\base\Widget;
use yii\helpers\Html;
use Yii;
class Login extends Widget
{
//    public $application_enc_id;
//    public $btn_class;

//    public function init()
//    {
//        parent::init();
//        if ($this->btn_class === null) {
//            $this->btn_class = 'apply-btn';
//        }
//    }

    public function run()
    {
        $loginFormModel = new LoginForm();
        $model = new IndividualSignUpForm();
        $fmodel = new ForgotPasswordForm();
        return $this->render('@frontend/views/widgets/login-modal',['loginFormModel' => $loginFormModel,'model' => $model,'fmodel' => $fmodel,]);
    }
}

