<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCss('
body{
	margin: 0;
	padding: 0;
	background-color:#f8f8f8;
	font-family: open sans;
	color:#000;
}
.border{
	max-width: 600px;
	margin:0 auto;
 } 
.border2{	 
	background:white;
	text-align: center;
}
.border3{	 
	background:#eff2f7;
	text-align: center;
	border-radius: 0 0 10px 10px;
	padding:20px 0;
}
.responsive{
	width: 100%;
}
.header-text{
	max-width:300px;
	font-family:roboto;
	font-size:1.8625em;
	text-align:canter;
	font-weight:bold;
	padding:45px 30px;
	margin:0 auto;
	color:#000;
}
.bg-blue{
	background: #eff2f7;
	display:flex;
	align-items:center;
}
.blue{
	color:#00a0e3;
}
.orange{
	color:#ff7803;
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
.poster{
	margin: 0 30px;
}

.poster1 img{
	max-width:540px;
	width:100%;
}
img + div{
    display:none;
}
.text{
	padding:20px 30px; 
	font-size:16px; 
	line-height:25px; 
	text-align:justify; 
	color:#000;
	font-family: \'Roboto\', sans-serif;
 }
.btn {
	font-family: \'Roboto\', sans-serif;
	padding-bottom: 20px;
	padding-top: 20px;
}
.btn a{  
	text-align:center;
	display:inline-block; 
	 padding:10px 25px; 
	 background:#00a0e3; 
	 border-radius:5px; 
	 font-size:17px; 
	 font-weight:bold; 
	 color:#fff;
	 text-decoration: none;
	}


.position-relative{
	position:relative;
}

.end {
	text-align: center;
	}
.end img{
	width: 160px;
}

.copyright
{
	padding:5px 0 15px 0; 
	font-size:11px;
	text-align: center;
	font-family: roboto;
	color:#000;
}
.social-list{
    
	width:100%;
	padding-right:30px;
}
.social-list ul{	
	text-align: right;
    margin-top:10px;
}
.social-list ul li{
	list-style-type:none;
	display:inline;
	margin-left:3px;
}
', ['media' => 'screen']);
$this->registerCss('
@media only screen and (max-width: 450px){
.logo img{
    max-width:120px;
}
.poster img{
    height: 150px; 
    width: 150px;
}
.text{
    font-size: 14px;
}
}
')
?>

<div class="border">
    <div class="position-relative bg-blue">
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

    <div class="border2">
        <div class="header-text">
            How can we make <span class="blue">Empower</span> <span class="orange">Youth</span> work for you?
        </div>
        <div class="poster">
            <div class="poster1">
                <img src="<?= Url::to('@commonAssets/email_service/feedback/feedback.png', true)?>">
            </div>
        </div>
        <div class="btn">
            <a href="https://www.empoweryouth.com">FEEDBACK</a>
        </div>
        <div class="text">
            To help us make it the best it can be, we want your valuable feedback today. Take a few minutes to fill out our feedback form and let us know.
        </div>

    </div>
    <div class="border3">
        <div class="end">
            <img src="<?= Url::to('@commonAssets/email_service/email-eyteam.png', true); ?>">
        </div>
        <div class="copyright">
            <div class="">Copyright © 2020 Empower Youth</div>
        </div>
    </div>
</div>
