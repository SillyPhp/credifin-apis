<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = false;
?>
<section class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header-content">
                    <div class="vertically-center">
                        <div class="main-tagline">Want to attract top talent ?</div>
                        <div class="main-text">Showcase Your Profile, Create your Brand, Find Empowered Candidates &
                            Save Time On Hiring Candidates.</div>
                        <div class="main-text"><span>Increase Your Efficiency & Effectiveness.</span></div>
<!--                        <div class="main-bttn">-->
<!--                            <a href="/signup/organization" class="button2">Create Account-->
<!--                                <span><i class="fa fa-arrow-right"></i></span> </a>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <h1 class="heading-style">Candidates</h1>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="grid-view brows-job-list">
                    <div class="brows-job-company-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?>" class="img-responsive" alt="" />
                    </div>
                    <div class="brows-job-position">
                        <h3><a href="job-detail.html">Web Developer</a></h3>
                        <p><span>Google</span></p>
                    </div>
                    <div class="job-position">
                        <span class="job-num">  5 Position</span>
                    </div>
                    <div class="brows-job-type">
                        <span class="part-time">Part Time</span>
                    </div>
                    <ul class="grid-view-caption">
                        <li>
                            <div class="brows-job-location">
                                <p><i class="fa fa-briefcase"></i>10 Jobs </p>
                            </div>
                        </li>
                        <li>
                            <p><span class="brows-job-sallery"><i class="fa fa-briefcase"></i>5 Internships</span></p>
                        </li>
                    </ul>
                    <span class="tg-themetag tg-featuretag">Premium</span>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="grid-view brows-job-list">
                    <div class="brows-job-company-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/hamco.png')?>" class="img-responsive" alt="" />
                    </div>
                    <div class="brows-job-position">
                        <h3><a href="job-detail.html">Web Developer</a></h3>
                        <p><span>Google</span></p>
                    </div>
                    <div class="job-position">
                        <span class="job-num">5 Position</span>
                    </div>
                    <div class="brows-job-type">
                        <span class="full-time">Full Time</span>
                    </div>
                    <ul class="grid-view-caption">
                        <li>
                            <div class="brows-job-location">
                                <p><i class="fa fa-briefcase"></i>10 Jobs </p>
                            </div>
                        </li>
                        <li>
                            <p><span class="brows-job-sallery"><i class="fa fa-briefcase"></i>5 Internships</span></p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="grid-view brows-job-list">
                    <div class="brows-job-company-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/ey.png')?>" class="img-responsive" alt="" />
                    </div>
                    <div class="brows-job-position">
                        <h3><a href="job-detail.html">Web Developer</a></h3>
                        <p><span>Google</span></p>
                    </div>
                    <div class="job-position">
                        <span class="job-num">5 Position</span>
                    </div>
                    <div class="brows-job-type">
                        <span class="freelanc">Freelancer</span>
                    </div>
                    <ul class="grid-view-caption">
                        <li>
                            <div class="brows-job-location">
                                <p><i class="fa fa-briefcase"></i>10 Jobs </p>
                            </div>
                        </li>
                        <li>
                            <p><span class="brows-job-sallery"><i class="fa fa-briefcase"></i>5 Internships</span></p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="grid-view brows-job-list">
                    <div class="brows-job-company-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>" class="img-responsive" alt="" />
                    </div>
                    <div class="brows-job-position">
                        <h3><a href="job-detail.html">Web Developer</a></h3>
                        <p><span>Google</span></p>
                    </div>
                    <div class="job-position">
                        <span class="job-num">5 Position</span>
                    </div>
                    <div class="brows-job-type">
                        <span class="enternship">Internship</span>
                    </div>
                    <ul class="grid-view-caption">
                        <li>
                            <div class="brows-job-location">
                                <p><i class="fa fa-briefcase"></i>10 Jobs </p>
                            </div>
                        </li>
                        <li>
                            <p><span class="brows-job-sallery"><i class="fa fa-briefcase"></i>5 Internships</span></p>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>


<?php
$this->registerCss('
.header{
    background:url(' . Url::to('@eyAssets/images/pages/company-and-candidate/candidate-list-bg.png') . ');
    background-repeat:no-repeat; 
    background-size:cover;
}
.header-content{
    height:350px;
}
.vertically-center{
    position: relative;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}
.main-tagline{
    color:#000;
    font-family:lobster;
    font-size:40px;
}
.main-text{
    color:#fff;
    font-size:17px;
    max-width:600px;
    line-height:27px;
}
.main-text span{
    background:#000;
    padding:2px 5px;
}
.main-bttn{
    padding-top:20px;
}
.grid-view.brows-job-list {
    position: relative;
    text-align: center;
	padding-bottom:0;
	margin-bottom:45px;
}
.grid-view .brows-job-type span {
    position: absolute;
    padding: 4px 15px;
    top: 10px;
    right: 0;
	color:#ffffff;
    line-height: 1.4;
    font-size: 12px;
    border-radius: 2px 0 0 2px;
}
.grid-view.brows-job-list:hover, .grid-view.brows-job-list:focus{
    border-color: transparent;
}
.grid-view .brows-job-company-img {
    width: 80px;
    margin: 10px auto;
    height: 80px;
    display: inline-block;
    border: 1px solid #e4e4e4;
    background: #fff;
    vertical-align: middle;
    border-radius: 50%;
    line-height: 80px;
}
.grid-view .brows-job-company-img img {
    margin: 0 auto;
    vertical-align: middle;
    display: inline-block;
    max-width: 50px;
    line-height: 50px;
}
.grid-view-caption {
margin:3em 0 0 0;
padding: 0;
border-top:1px solid #eaeff5;
display:flex;
width: 100%;
}
.brows-job-position {
    padding: 0 15px;
}
.grid-view-caption li{
display:inline-block;
float:left;
width:50%;
padding:10px 0;
line-height: 2.2;
}
.brows-job-description{
font-size:15.5px;
line-height:1.8;
color:#5b6d77;
padding:10px 12px;
}
.brows-job-description p{
line-height:1.9;
}
.grid-view-caption li:first-child{
border-right:1px solid #eaeff5;
}
.grid-view-caption li p{
margin-bottom:0;
}
.grid-view-caption li i{
padding-right:10px;
}
.grid-view-caption .brows-job-location {
    margin-top: 0px;
}
.grid-view-caption .brows-job-location p i{
margin-right:0;
}
.grid-view-caption .brows-job-location p, .grid-view-caption .brows-job-sallery {
font-size:14px;
margin-bottom:0;
}
/*----------------*/
.brows-job-category{
position:relative;
}
.brows-job-category .no-padding{
margin:0;
margin-bottom:30px;
}
.brows-job-category h2{
color:#5a6f7c;
font-size:25px;
}
.brows-job-list {
display: table;
width: 100%;
clear: both;
padding: 15px 0;
margin-bottom:15px;
transition:.4s;
border: 1px solid #eaeff5;
background:#ffffff;
border-radius:6px;
box-shadow:0px 0px 10px 0px rgba(88,96,109,0.14);
-webkit-box-shadow:0px 0px 10px 0px rgba(88,96,109,0.14);
-moz-box-shadow:0px 0px 10px 0px rgba(88,96,109,0.14);
}
.brows-job-list:hover, .brows-job-list:focus{
	transform: translateY(-5px);
	-webkit-transform: translateY(-5px);
}
.brows-job-company-img {
width: 75px;
margin: 0 auto;
margin:10px auto;
height: 75px;
display:inline-block;
background: #f4f5f7;
vertical-align: middle;
border-radius: 50%;
line-height: 75px;
}
.brows-job-company-img img{
margin: 0 auto;
vertical-align: middle;
display:inline-block;
}
.brows-job-position h3 {
    color: #5b6d77;
    font-size: 20px;
    padding: 0;
	margin-bottom: 0;
    line-height: 1.4;
}
span.job-num {
    padding: 5px 10px;
    border-radius: 4px;
    text-transform: capitalize;
    color: #8da2b3;
    background: #f3f6fb;
}
.brows-job-position p span{
font-size:12px;
color:#5a6f7c;
margin-top:12px;
margin-right:20px;
}
.brows-job-position p .brows-job-sallery{
margin-right:0;
}
.brows-job-position p .brows-job-sallery i{
margin-right:10px;
}
.brows-job-location {
margin-top: 23px;
}
.brows-job-location p{
font-size:18px;
color:#5a6f7c;
}
.brows-job-location p i{
font-size:16px;
margin-right:10px;
}
.brows-job-link{
margin-top: 22px;
}
.brows-job-position .job-type{
padding:4px 12px;
color:#ffffff;
margin-left:10px;
border-radius:2px;
text-transform:capitalize;
}
.full-time {
background: #03a504;
}
.part-time {
background: #f6931e;
}
.enternship {
background: #d20001;
}
.freelanc {
background: #26a9e1;
}
.jb-type {
    padding: 3px 10px;
    color: #ffffff;
    font-size: 12px;
    border-radius: 2px;
}
.tg-themetag{
    top:7px;
    left: -5px;
    z-index: 2;
    color: #fff;
    font-size: 10px;
    font-weight: 500;
    line-height: 10px;
    position: absolute;
    background:#ff526c;
    padding: 5px 3px 3px 10px;
    text-transform: uppercase;
}
.tg-featuretag:before, .tg-featuretag:after {
    width: 0;
    height: 0;
    content: "";
    position: absolute;
}
.tg-featuretag:before{
    top: 0;
    left: 100%;
    border-top: 9px solid transparent;
    border-bottom: 9px solid transparent;
    border-left: 10px solid #ff526c;
}
.tg-featuretag:after{
    top: 100%;
    left: 0;
    border-top: 5px solid #eb344f;
    border-left: 5px solid transparent;
}


');
$script = <<< JS
  
JS;
$this->registerJs($script);
