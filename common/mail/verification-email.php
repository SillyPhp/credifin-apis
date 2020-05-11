<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCss('
  * {
    margin:0; 
    padding:0;
  }
  body {
    font-family:open sans, arial; 
    font-size:13px;
    color:#4d4d4d;
    font-family:Times New Roman, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
  }
  img + div{
    display:none;
  }
  .responsive {
    width:100%;
  }
  .wrapper {
    max-width:600px; 
    margin:0 auto; 
    background:#89cde9; 
    padding:30px 50px; 
  }
  .inner-wrapper{ 
    background:#fff; 
    border-radius:10px; 
    text-align:center;
    box-shadow: 0px 0px 10px rgba(68, 67, 67, 0.4);
  }
  .logo img{
    max-width:175px; 
    padding:30px 0 0 0 ;
  }
  .icon img{
    max-width:220px; 
    padding:40px 0 0 0;
  }
  .com-name{
    padding:10px 0 0 0; 
    font-weight:bold; 
    font-size:28px;
    color:#4d4d4d;
  }
  .welcome-text{
    padding:20px 80px 0 80px; 
    font-size:24px; 
    line-height:30px;
    color:#4d4d4d;
  }
  .activate-button{
    padding:45px 0 20px 0;
  }
  .activate-button a{ 
    padding:15px 30px; 
    color:#fff; 
    background:#00a0e3; 
    border-radius:8px; 
    font-size:20px; 
    text-decoration:none
  }
  .ey-team{
    padding:40px 0 0 0;
  }
  .ey-team img{
    max-width:220px;
  }
  .copyright{
    padding:10px 0 0 0; 
    font-size:15px;
    color:#4d4d4d;
  }
  .last-list{
    padding:5px 0 10px 0; 
  }
  .last-list ul li{
    list-style-type:none; 
    display:inline; 
    padding:15px 5px;
  }
  .last-list ul li a{
    color:#00a0e3; 
    text-decoration:none;
  }
', ['media' => 'screen']);
$this->registerCss('
@media only screen and (max-width: 500px){
    .welcome-text{
        padding:20px 30px 0 30px;
    }
} 
@media only screen and (max-width: 380px){
    .wrapper { 
        padding:30px 10px; 
        font-size:20px;
    } 
    .activate-button a{ 
        padding:15px 20px; 
        font-size:15px; 
        text-decoration:none
    }
    .activate-button {
        margin-bottom:20px;
    }
}
', ['media' => 'only screen and (max-device-width: 500px), only screen and (max-width: 380px)']);
?>
<div class="wrapper">
    <div class="inner-wrapper">
        <div class="logo">
            <img src="<?= Url::to('@commonAssets/email_service/email-logo.png', true); ?>" class="responsive">
        </div>
        <div class="icon">
            <img src="<?= Url::to('@commonAssets/email_service/email-icon.png', true); ?>" class="responsive">
        </div>
        <div class="com-name">
            <?= Yii::t('app', 'Hello ') ?> <span><?= $data['name']; ?></span>!
        </div>
        <div class="welcome-text">
            <?= Yii::t('app', 'Your ' . Yii::$app->params->site_name . ' account has been successfully
            created, all you need to do is click the button below to activate it now.');?>
        </div>
        <div class="activate-button">
            <?= Html::a(Yii::t('app', 'Activate Account'), $data['link']); ?>
        </div>
        <div class="link-text">
            <p style="padding: 8px 60px;font-size: 16px;color:#4d4d4d;">If you’re having trouble clicking the button, copy and paste the URL below into your web browser.</p>
            <?= Html::a(Yii::t('app', $data['link']), $data['link'],['style' => 'padding: 2px 10px;font-size: 17px;text-decoration: none;word-break: break-word;']); ?>
        </div>
        <div class="ey-team">
            <img src="<?= Url::to('@commonAssets/email_service/email-eyteam.png', true); ?>">
        </div>
        <div class="copyright">
            <?= Yii::t('app', 'Copyright') . ' &copy; ' . date('Y') . ' ' . Yii::$app->params->site_name; ?>
        </div>
    </div>
</div>