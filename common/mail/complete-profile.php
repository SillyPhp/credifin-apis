<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCss('
body{
    margin: 0;
    padding: 0;
    background-color:#f8f8f8;
    font-family: open sans;
    color:#000 !important;
}
.wrapper{
    max-width:600px;
    margin: 0 auto;
    background:#fff;
    position:relative;
    color:#000;
}	
.social-list{
    width:100%;
    padding-right:30px;
    padding-top:20px;
}
.social-list ul{	
    text-align: right
}
.social-list ul li{
    list-style-type:none;
    display:inline;
    padding:0 3px;
    margin-left:0px !important;
}
.social-list ul li a{
    color: transparent;
}
.logo{
    text-align: left;
    padding-left: 30px;
    padding-bottom:20px;
    width:100%;
}
.logo img{
    max-width:150px; 
    padding:30px 0 0 0 ;
}
img + div{
    display:none;
}
.bg-blue{
    background: #eff2f7;
    display:flex;
}
.banner img{
    max-width:100%;
    
}
.editProfile{
    margin-top:20px;
    text-align:center;
}
.editProfile a{
    background: #ff575a;
    color:#fff;
    padding:8px 20px;
    text-decoration: none;
    border-radius:8px;
}
.mail-text{
    text-align:center;
    max-width:450px;
    margin: 0 auto;
}
.text-bold{
    margin-top:30px;
    font-size:25px;
    font-weight:bold;
}
p{
    margin-block-start: 0em;
}
.mb1{
    margin-bottom:10px;
}
.icon img{
    max-width:100px;
}
.display-flex{
    display:flex;
    text-align:left;
    margin-bottom:40px;
}
.heading-bold{
    font-size:20px;
    font-weight:bold;
    text-transform: capitalize;
}
.text{
    padding-left:20px;
    padding-top: 10px;
}
.font14{
    font-size:14px;
}
.border3{	 
    background:#eff2f7;
    text-align: center;
    border-radius: 0 0 10px 10px;
    padding:20px 0;
}
.end{
    text-align: center;
}
.end img{
    width: 160px;
}
');
?>
<div class="wrapper">
    <div class="bg-blue">
        <div class="logo">
            <a href="<?= Url::to('/', true);?>">
                <img src="<?= Url::to('@commonAssets/email_service/email-logo.png', true); ?>" class="responsive">
            </a>
        </div>
        <div class="social-list">
            <ul>
                <li><a href="https://www.facebook.com/empower/">
                        <img src="<?= Url::to('@commonAssets/email_service/fb-icon.png', true); ?>">
                    </a></li>
                <li><a href="https://www.instagram.com/empoweryouth.in/">
                        <img src="<?= Url::to('@commonAssets/email_service/insta-icon.png', true); ?>">
                    </a></li>
                <li><a href="https://twitter.com/EmpowerYouthin">
                        <img src="<?= Url::to('@commonAssets/email_service/twitter-icon.png', true); ?>">
                    </a></li>
                <li><a href="https://www.linkedin.com/company/empoweryouth/">
                        <img src="<?= Url::to('@commonAssets/email_service/linkedin-icon.png', true); ?>">
                    </a></li>
            </ul>
        </div>
    </div>
    <div>
        <div class="banner">
            <img src="<?= Url::to('@commonAssets/email_service/complete-profile/editprofile-hdr1.png', 'https'); ?>">
        </div>
    </div>
    <div class="editProfile">
        <a href="<?= Url::to('/' . $data['username'] . '/edit', true);?>">Edit Profile</a>
    </div>
    <div class="mail-text">
        <div class="text-bold mb1">SET IT, FORGET IT</div>
        <p>We recommend that Its Important to build complete profile & update your preferences.</p>

        <div class="display-flex">
            <div class="icon">
                <img src="<?= Url::to('@commonAssets/email_service/complete-profile/buildresume.png', true); ?>">
            </div>
            <div class="text">
                <div class="heading-bold">Write about yourself</div>
                <p class="font14">If you haven’t yet uploaded your details to help hosts get to know you before inviting you into their company.</p>
            </div>
        </div>
        <div class="display-flex">
            <div class="icon">
                <img src="<?= Url::to('@commonAssets/email_service/complete-profile/verifyinfo.png', true); ?>">
            </div>
            <div class="text">
                <div class="heading-bold">Verify your information</div>
                <p class="font14">Consider connecting your social networks and quickly verify your email or phone number to
                    help build trust in Empower Youth.</p>
            </div>
        </div>
        <div class="display-flex">
            <div class="icon">
                <img src="<?= Url::to('@commonAssets/email_service/complete-profile/writeabt.png', true); ?>">
            </div>
            <div class="text">
                <div class="heading-bold">Build your resume</div>
                <p class="font14">Build your prominent resume with us. Add work Experience and the required information.</p>
            </div>
        </div>
    </div>
    <div class="border3">
        <div class="end"><img src="<?= Url::to('@commonAssets/email_service/email-eyteam.png', true); ?>"></div>
        <div class="copyright">
            <div class="">Copyright © 2020 Empower Youth</div>
        </div>
    </div>
</div>

