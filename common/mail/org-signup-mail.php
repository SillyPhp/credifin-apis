<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCss('
    body{
            background-color:#f5f5f5;
        }
        .border {
            max-width: 600px;
            margin: 0 auto;
            background-color:white;
        }

        .logo {
            text-align: center;
            padding-bottom: 20px;
            background-color: #eff2f7;
        }

        .responsive{
            max-width: 200px;
            padding: 30px 0 0 0;
        }

        .paragraph{
            font-size: 20px;
            font-family: roboto;
            padding: 20px;
            margin:0;
        }


        .steps {
            display: flex;
            margin-top: 20px;
        }
        .steps img{
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            max-width: 100%;
        }

        .box2 {
            padding-top: 80px;
        }

        .text{
            text-align: center;
            font-size: 35px;
            margin-top: 10px;
            text-transform: capitalize;
        }
        .border3 {
            text-align: center;
            padding-bottom: 20px;
            background-color: #eff2f7;
            margin-top: 15px;
        }

        .end img{
            max-width: 200px;
            padding: 30px 0 0 0;
        }

        .image{
            max-width: 35px;
            padding: 10px 0 0 0;
        }

        @media (max-width: 500px){
            .text{font-size: 23px;}
        }
')

?>

<div class="border">
    <div class="logo">
        <a href="https://www.empoweryouth.com/" target="_blank" >
            <img src="<?= Url::toRoute('/assets/themes/email/org-signup-img/com.png','https')?>" class="responsive">
        </a>
    </div>

    <p class="paragraph">Hey You!</p>
    <p class="paragraph">Signed up thats great, now it's time to create you first job & internship on our platform.</p>
    <hr style=" border:1px solid #f7f7f7;">
    <div class="text">
        <div class="main">You asked for a simple process!!</div>
        <div class="main2">We create three now</div>
    </div>

    <div class="steps">
        <div class="box1"><img src="<?= Url::toRoute('/assets/themes/email/org-signup-img/boxx1.png','https')?>"></div>
        <div class="box2"><img src="<?= Url::toRoute('/assets/themes/email/org-signup-img/boxx2.png','https')?>"></div>
        <div class="box3"><img src="<?= Url::toRoute('/assets/themes/email/org-signup-img/boxx3.png','https')?>"></div>
    </div>
    <div class="border3">
        <div class="social-icon">
            <a href="https://www.facebook.com/empower" target="_blank"><img class="image" src="<?= Url::toRoute('/assets/themes/email/org-signup-img/facebook.png','https')?>" alt="Error"></a>
            <a href="https://twitter.com/EmpowerYouthin"target="_blank"><img class="image" src="<?= Url::toRoute('/assets/themes/email/org-signup-img/twitter.png','https')?>" alt="Error"></a>
            <a href="https://www.instagram.com/empoweryouth.in/" target="_blank"><img class="image" src="<?= Url::toRoute('/assets/themes/email/org-signup-img/instagram.png','https')?>" alt="Error"></a>
        </div>
        <div class="end"><img src="<?= Url::toRoute('/assets/themes/email/org-signup-img/email-eyteam.png','https')?>"></div>
        <div class="copyright">
            <div class="">Copyright © 2019 Empower Youth</div>
        </div>
    </div>

</div>

