<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset; ?>" />
        <title><?= Html::encode($this->title); ?></title>
        <?php $this->head(); ?>
        <style>
            body{
                margin: 0px;
                padding: 0px;
            }
            .container-fluid{
                width:100%;
            }
            .container{
                max-width: 1000px;
                margin: auto;
                padding-left: 15px;
                padding-right: 15px;
            }
            .logo{
                max-width: 350px;
                padding: 15px 0px;
            }
            .full-title{
                background-color: #38628c;
                padding: 10px 0px;
                color: #fff;
            }
            .title p{
                color: #fff;
                font-size: 20px;
                line-height: 40px;
                word-break: break-word;
                margin: 0;
            }
            .description{
                padding: 25px 0px;
                line-height: 1.4;
            }
            .description h2{	
                color: #3D474D;
                font-size: 20px;
                font-weight: 400;
                margin: 0;
            }
            .description p{
                font-size: 18px;
                color: #8A9499;
                word-break: break-word;
                margin: 0 0 0px;
            }
            .link{
                color: #00A0E3;
                text-decoration: underline;
                word-break: normal;
            }
            a.button{
                line-height: 30px;
                text-decoration: none;
                word-break: break-all;
                font-weight: 500;
                font-size: 20px !important;
                cursor: pointer;
                display: inline-block;
                overflow: visible;
                text-align: center;
                background-color: #00A0E3;
                border-radius: 5px;
                min-height: 30px;
                white-space: nowrap;
                padding: 6px 25px;
                border: 1px solid #00A0E3;
                margin: 30px auto;
                color: #fff;
            }
            .footer{
                font-size: 14px !important;
                font-weight: 500;
            }
        </style>
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <div class="container-fluid">
            <div class="container">
                <div class="logo">
                    <img src="<?= Url::to('@commonAssets/logos/logo-horizontal.png', true); ?>"/>
                </div>
            </div>
        </div>
        <?= $content; ?>
    </body>
</html>
<?php $this->endPage(); ?>