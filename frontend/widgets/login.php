<?php
namespace frontend\widgets;

use frontend\models\accounts\LoginForm;
use yii\base\Widget;
use yii\helpers\Html;
use Yii;
class Login extends Widget
{

    public function run()
    {
        $loginFormModel = new LoginForm();
        return $this->render('@frontend/views/widgets/login-modal',['loginFormModel' => $loginFormModel,]);
    }
}

