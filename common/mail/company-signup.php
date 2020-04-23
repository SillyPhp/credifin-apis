<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCss('
body{
    margin: 0;
    padding: 0;
    background-color:#f8f8f8;
    font-family: open sans;
}
.wrapper{
    max-width:600px;
    margin: 0 auto;
    background:#fff;
    position:relative;
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
}
img + div{
    display: none;
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
.bg-blue{
    background: #eff2f7;
    display:flex;
}
.banner{
    text-align:center;
    
}
.banner img{
    max-width:300px;
    width:100%;
    margin-top:50px;
}
.editProfile{
    margin-top:40px;
    text-align:center;
    margin-bottom:20px;
}
.editProfile a{
    background: #00a0e3;
    color:#fff !important;
    padding:8px 20px;
    text-decoration: none;
    border-radius:8px;
    text-transform:uppercase;
}
.mail-text{
    text-align:center;
    margin: 0 auto;
    color:#000;
}
.mail-text a{
    color:#00a0e3;
    text-decoration:none;
}
.text-bold{
    margin-top:30px;
    font-size:25px;
    font-weight:bold;
    color:#000;
}
.text-bold img{
    max-width:200px;
    margin-bottom:-5px;
}
.tb{
    font-weight:bold;
}
p{
    margin-block-start: 0em;
    color:#000;
}
.mb1{
    margin-bottom:10px;
}
.mb3{
    margin-bottom:30px;
}
.padding40{
    padding-left:40px;
    padding-right:40px;
}
.text-blue{
    color:#00a0e3;
    font-size:20px;
    font-weight: bold;
    margin-top:30px;
    margin-bottom: 10px !important
}
.icon img{
    max-width:100px;
    padding: 0 20px;
}
.display-flex{
    display:flex;
    text-align:left;
    padding: 20px 40px;
}
.heading-bold{
    font-size:20px;
    font-weight:bold;
    color:#000;
}
.text{
    padding-top: 0px;
    padding: 0 20px;
    color:#000;
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
    width:100%;
    max-width: 160px;
}
.copyright div{
    color:#000;
}
');
?>
<div class="wrapper">
    <div class=" bg-blue">
        <div class="logo">
            <a href="https://www.empoweryouth.com">
                <img src="<?= Url::to('@commonAssets/email_service/email-logo.png', true); ?>" class="responsive"></a>
        </div>
        <div class="social-list">
            <ul>
                <li><a href="https://www.facebook.com/empower/">
                        <img src="<?= Url::to('@commonAssets/email_service/fb-icon.png', true); ?>"></a></li>
                <li><a href="https://www.instagram.com/empoweryouth.in/">
                        <img src="<?= Url::to('@commonAssets/email_service/insta-icon.png', true); ?>"></a></li>
                <li><a href="https://twitter.com/EmpowerYouthin">
                        <img src="<?= Url::to('@commonAssets/email_service/twitter-icon.png', true); ?>"></a></li>
                <li><a href="https://www.linkedin.com/company/empoweryouth/">
                        <img src="<?= Url::to('@commonAssets/email_service/linkedin-icon.png', true); ?>">
                    </a></li>
            </ul>
        </div>
    </div>
    <div class="banner">
        <img src="<?= Url::to('@commonAssets/email_service/company-signup/company-signup.png', true);?>">
    </div>

    <div class="mail-text">
        <div class="text-bold mb1">You're invited to <a href="https://www.empoweryouth.com/">
                <img src="<?= Url::to('@commonAssets/email_service/company-signup/ey-logo-text.png', true)?>"></a></div>
        <p class="padding40"><a href="https://www.empoweryouth.com/">Empoweryouth.com</a> is a social organization working on career and skills development of people to lead better and fulfilled life. It is a free job portal, for employers as well as employees.</p>
        <p class="tb">As an NGO, The platform is Free of cost for everyone.</p>
        <p class="text-blue">What You Will Get</p>

        <div class="display-flex bg-blue">
            <div class="icon">
                <img src="<?= Url::to('@commonAssets/email_service/company-signup/ats1.png', true)?>">
            </div>
            <div class="text">
                <div class="heading-bold">Application Tracking System</div>
                <p class="font14">With ATS, we provide you Interview Scheduler, Application Integration, Hiring Process, Questionnaires, Built-in-Templates & Chat Box.</p>
            </div>
        </div>
        <div class="display-flex">
            <div class="text">
                <div class="heading-bold">Online Campus Placement</div>
                <p class="font14">Hire Freshers & Save Time, Cost & Efforts with Secure and Rapid Online Process of E-Campus Drive.</p>
            </div>
            <div class="icon">
                <img src="<?= Url::to('@commonAssets/email_service/company-signup/campus-placement.png', true)?>">
            </div>
        </div>
        <div class="display-flex bg-blue">
            <div class="icon">
                <img src="<?= Url::to('@commonAssets/email_service/company-signup/reviews.png', true)?>">
            </div>
            <div class="text">
                <div class="heading-bold">Full-Fledge Reviews System</div>
                <p class="font14">Reviews Elevate Customer's Confidence, generate better-qualified leads & boost your Business Branding</p>
            </div>
        </div>
        <div class="display-flex">
            <div class="text">
                <div class="heading-bold">Training Programs</div>
                <p class="font14">Create Training Courses to attract better and large of candidates by generating Leads in the market.</p>
            </div>
            <div class="icon">
                <img src="<?= Url::to('@commonAssets/email_service/company-signup/training-programs.png', true)?>">
            </div>
        </div>
        <div class="display-flex bg-blue">
            <div class="icon">
                <img src="<?= Url::to('@commonAssets/email_service/company-signup/resume.png', true)?>">
            </div>
            <div class="text">
                <div class="heading-bold">Resume Bank</div>
                <p class="font14">Use Resume Bank to hire applicants whenever you want, even when you don't have vacancies.</p>
            </div>
        </div>
        <div class="editProfile">
            <a href="https://www.empoweryouth.com/signup/organization">Sign Up</a>
        </div>
        <p class="padding40 mb3">We ensure that this collaboration will be highly valuable for your Company and it's reputation.</p>
    </div>

    <div class="border3">
        <div class="end"><img src="<?= Url::to('@commonAssets/email_service/email-eyteam.png', true)?>"></div>
        <div class="copyright">
            <div class="">Copyright © 2020 Empower Youth</div>
        </div>
    </div>
</div>
<?php
?>
