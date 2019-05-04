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
    font-size:13px; color:#4d4d4d;
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
  }
  .welcome-text{
    padding:20px 80px 0 80px; 
    font-size:24px; 
    line-height:30px;
  }
  .activate-button{
    padding:45px 0 0px 0;
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
  @media  (max-width: 500px){
    .welcome-text{padding:20px 30px 0 30px;
  }
}  
');
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
        <div class="ey-team">
            <img src="<?= Url::to('@commonAssets/email_service/email-eyteam.png', true); ?>">
        </div>
        <div class="copyright">
            <?= Yii::t('app', 'Copyright') . ' &copy; ' . date('Y') . ' ' . Yii::$app->params->site_name; ?>
        </div>
        <div class="last-list">
            <ul>
                <li><a href="#">Contact Us</a></li>
                |
                <li><a href="#">Terms and Conditions</a></li>
                |
                <li><a href="#">Privacy Policies</a></li>
            </ul>
        </div>
    </div>
</div>