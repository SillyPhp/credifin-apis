<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCss('
body{
    margin:0;
    padding:0;
    font-family: roboto;
    color:#000;
}
.wrapper{
    max-width:600px;
    margin: 0 auto;
    background:#e9cdc9;
    position:relative;
}	
.wrapper-inner{
   
    background-size:contain;
    position:relative;
    height:500px;
    text-align: center;
    padding-top: 130px;
    
}
img + div{
    display:none;
}
.wrapper-inner img{
    max-width:150px;
    margin-top:40px;
}
.thankyou-box{
    max-width:350px;
    width:100%;
    background: #fff;
  
    min-height:300px;
    text-align:center;
    padding: 80px 20px 0 20px;
    box-shadow:0 0 15px rgba(0,0,0,.3);
    border-radius: 10px;
    margin:0px auto;
    color:#000;
}
.thanks{
    font-size:40px;
    text-transform: uppercase;
    font-family:lora;
    font-weight:bold;
    color: #000;
    padding:0px 0;
}
.thankyou-box p{
    font-size:18px;
    padding:20px;
    line-height:24px;
    font-weight: bold;
}
.thankyou-box img{
    margin: 0 auto;
    max-width:150px;
    padding-bottom:20px;
}
.dis-flex{
    display:flex;
    text-align:center;
    padding:20px 0;
    color:#000;
}
.jobs, .reviews{
    padding: 0 10px;
    width:49%
}
.jobs{
    border-right: 2px solid #000;
}
.dis-flex p{
    margin-bottom:15px;
}
.dis-flex ul{
    text-align:left;
    padding-inline-start: 25px;
}
.dis-flex ul li{
    padding-bottom:10px;
    
}
.dis-flex img{
    max-width:80px;
    max-height:69px;
}
.mb1{
    margin-bottom:10px;
}
.mb3{
    margin-bottom:30px;
}
.text-bold{
    font-weight: bold;
    text-transform: uppercase;
    color:#000;
}
.social-links{
    text-align:center;
    padding-bottom:10px;
}
.social-links ul{
    padding-inline-start: 0px!important; 
}
.social-links ul li{
    list-style-type: none;
    display:inline;
    margin: 0 5px;
}
.social-links ul li a{
    color: transparent !important;
}
.social-links ul li a img{
    width:30px;
    height:30px;
}
.border3{	 
    background:#fff;
    text-align: center;
    border-bottom:10px solid #e9cdc9; 
    padding:20px 0;
}
.end {
    text-align: center;
    }
.end img{
    width:100%;
    max-width: 160px;
}
.copyright{
    color:#000;
}

');
?>
<div class="wrapper">
    <div class="wrapper-inner" style=" background-image:url('<?= Url::to('@commonAssets/email_service/thank-you/bg-pattren.png', 'https') ?>');">
        <div class="thankyou-box">
            <div class="">
                <img src="<?= Url::to('@commonAssets/email_service/email-logo.png', true) ?>">
            </div>
            <div class="thanks">Thank You</div>
            <p> For signing up on our platform, We are honored to serve you according to your requirements.</p>
        </div>
    </div>
    <div class="dis-flex">
        <div class="jobs">
            <div class="mb3">
                <img src="<?= Url::to('@commonAssets/email_service/thank-you/job-icon.png', true)?>">
            </div>
            <div>Build your career with verified</div>
            <div class="text-bold">Jobs & Internships</div>
            <ul>
                <li>Only verified jobs and internships available.</li>
                <li>No more fuss of counterfeit jobs.</li>
                <li>Apply only in genuine companies.</li>
            </ul>
        </div>
        <div class="reviews">
            <div class="mb3">
                <img src="<?= Url::to('@commonAssets/email_service/thank-you/review-icon.png', true)?>">
            </div>
            <div>Give your <span class="text-bold">review</span>, it might help someone!</div>
            <ul>
                <li>Post reviews about any firm or company.</li>
                <li>Also, give reviews on educational institutes.</li>
                <li>Also, see other people’s reviews.</li>
            </ul>
        </div>
    </div>
    <div class="social-links">
        <ul>
            <li><a href="https://www.facebook.com/empower/">
                    <img src="<?= Url::to('@commonAssets/email_service/thank-you/icon-fb.png', true);?>">
                </a></li>
            <li><a href="https://www.instagram.com/empoweryouth.in/">
                    <img src="<?= Url::to('@commonAssets/email_service/thank-you/icon-insta.png', true);?>">
                </a></li>
            <li><a href="https://twitter.com/EmpowerYouthin">
                    <img src="<?= Url::to('@commonAssets/email_service/thank-you/icon-twitter.png', true);?>">
                </a></li>
            <li><a href="https://www.linkedin.com/company/empoweryouth/">
                    <img src="<?= Url::to('@commonAssets/email_service/thank-you/icon-linkedin.png', true);?>">
                </a></li>
        </ul>
    </div>
    <div class="border3">
        <div class="end"><img src="<?= Url::to('@commonAssets/email_service/email-eyteam.png', true);?>"></div>
        <div class="copyright">
            <div class="">Copyright © 2020 Empower Youth</div>
        </div>
    </div>
</div>
</div>

