<?php

use yii\helpers\Url;

$this->registerCssFile("https://fonts.googleapis.com/css?family=Roboto&display=swap");
$this->registerCss('
    body {
        margin: 10px;
        padding: 0;
        background-color: #eee;
        font-family: roboto;
    }

    .border {
        max-width: 600px;
        margin: 0 auto;
    }

    .border2 {
        background: white;
        text-align: center;
    }

    .border3 {
        background-color: white;
        margin-top: 5px;
    }

    .last {
        text-align: center;
        padding-top: 10px;
    }

    .logo {
        text-align: left;
        padding: 15px 0 15px 12px;
        background-color: #2a3e60;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .logo img {
        max-width: 160px;
    }

    .bg-img {
        background: url(images/banner.png);
        height: 252px;
        background-size: contain;
        width: 100%;
        background-repeat: no-repeat;
        background-position: center;
    }

    .bg-text {
        position: absolute;
        transform: translate(-50%, -50%);
        left: 50%;
        top: 148px;
        font-size: 30px;
        font-family: lora;
    }

    .text-head {
        text-align: left;
        padding: 0px 10px;
        padding-top: 25px;
        font-size: 17px;
        font-family: arial;
    }

    .text-main {
        text-align: left;
        padding: 0px 10px;
        padding-top: 8px;
        font-size: 16px;
        padding-bottom: 25px;
        font-family: arial;
    }

    .text {
        text-align: left;
        padding: 0px 10px;
        padding-top: 18px;
        font-size: 16px;
        padding-bottom: 20px;
        font-family: arial;
    }

    .btns {
        padding: 15px 0 40px;
    }

    .btn, .btn1 {
        font-family: arial;
        padding-bottom: 20px;
        padding-top: 20px;
        display: inline-block;
        margin: 0px 10px;
    }

    .btn a, .btn1 a {
        text-align: center;
        display: inline-block;
        padding: 8px 30px;
        background: #00a0e3;
        border-radius: 6px;
        font-size: 15px;
        color: #fff;
        text-decoration: none;
    }

    .cmp-logo {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border: 1px solid #fff;
        position: relative;
    }

    .cmp-logo img {
        width: 70px;
        height: 70px;
        position: absolute;
        top: 50%;
        left: 51%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
    }

    .good {
        font-family: arial;
        font-size: 18px;
        position: absolute;
        top: 25px;
        left: 17%;
    }

    .team {
        font-family: arial;
        font-size: 17px;
        position: absolute;
        top: 53px;
        left: 17%;
        color: #db9595;
    }

    .position-relative {
        position: relative;
    }

    .teaming {
        text-align: left;
        padding: 15px 0px 15px 15px;
        font-family: roboto;
        font-size: 15px;
    }

    .social img {
        width: 32px;
        margin: 1px 2px;
    }

    .copyright {
        padding: 10px 0 10px 0;
        font-size: 11px;
    }
', ['media' => 'screen']);

$this->registerCss('
@media screen and (max-width: 414px) {
    .bg-img {
        height: 180px;
    }

    .bg-text {
        font-size: 18px;
        top: 108px;
    }

    .good {
        padding-left: 48px;
    }

    .team {
        padding-left: 48px;
    }
}
', ['media' => 'only screen and (max-device-width: 414px)']);
?>
<div class="border">
    <div class="position-relative">
        <div class="logo">
            <a href="https://www.empoweryouth.com" target="blank"><img src="images/com.png" class="responsive"></a>
        </div>
    </div>
    <div class="border2 position-relative">
        <div class="bg-img">
            <div class="bg-text">Let's Get You Noticed!</div>
        </div>
        <div class="text-head">Hi,</div>
        <div class="text-main">You signed up for EmpowerYouth! That's awesome.</div>
        <div class="text">To get most of your account, however, we recommend building your complete profile & updating
            your preferences.
        </div>
        <div class="btns">
            <div class="btn"><a href="<?= Url::to("/" . $data[''] . "/edit", "https"); ?>">Edit Profile</a></div>
            <div class="btn1"><a href="<?= Url::to("/account/preferences", "https"); ?>">Edit Preferences</a></div>
        </div>

    </div>
    <div class="border3">
        <div class="teaming position-relative">
            <div class="cmp-logo"><img src="images/name.png"></div>
            <div class="good">Best Regards,</div>
            <div class="team">Shyna and EmpowerYouth Team</div>
        </div>
    </div>
    <div class="last">
        <div class="social">
            <a href="https://www.facebook.com/" target="blank">
                <span><img src="images/facebook.png"></span></a>
            <a href="https://twitter.com/EmpowerYouth__" target="blank">
                <span><img src="images/twitter.png"></span></a>
            <a href="https://www.instagram.com/empoweryouth.in" target="blank">
                <span><img src="images/instagram.png"></span></a>
            <a href="https://www.linkedin.com/company/empoweryouth" target="blank">
                <span><img src="images/linkedin.png"></span></a>
            <a href="https://www.empoweryouth.com" target="blank">
                <span><img src="images/eyrl.png"></span></a>
        </div>
        <div class="copyright">
            <div class="">Copyright © 2019 Empower Youth</div>
        </div>
    </div>
</div>