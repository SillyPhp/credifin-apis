<?php

use yii\helpers\Url;

$this->params['header_dark'] = false;
?>
    <section class="header-res">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="head-txt">
                        <h1>Create Your Resume Like A Professional!!</h1>
                        <h2>With Our <span class="org-txt1">Best Customized CV Templates</span> You Can Build Your Resume In A Professionalized Way.</h2>
                    </div>
                    <div class="head-btn">
                        Build Now
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="head-img move">
                        <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/cv.png') ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bene">
        <div class="container">
            <div class="row mt-20">
                <div class="col-md-12">
                    <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'Benefits Of Using CV Templates'); ?></h2>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="benefit">
                    <div class="benefit-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/organize.png'); ?>"/>
                    </div>
                    <div class="benefit-txt">
                        <span class="org-txt">Organize</span> Your Resume
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="benefit">
                    <div class="benefit-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/No-Experience.png'); ?>"/>
                    </div>
                    <div class="benefit-txt">
                        <span class="org-txt">No Experience</span> Needed
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="benefit">
                    <div class="benefit-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/save-time.png'); ?>"/>
                    </div>
                    <div class="benefit-txt">
                        <span class="org-txt">Save</span> Time
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="benefit">
                    <div class="benefit-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/impression.png'); ?>"/>
                    </div>
                    <div class="benefit-txt">
                        Make A Great<span class="org-txt"> First Impression </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="easy-steps">
            <h3>3-STEPS TO BUILD YOUR DREAM RESUME</h3>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="easy">
                    <div class="easy-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/resume-templates.png'); ?>"/>
                    </div>
                    <div class="easy-txt">
                        <h4>Select Your CV Template</h4>
                        <h5>We are providing a variety of professionalized CV templates from which you can select one as
                            per your needs. </h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="easy">
                    <div class="easy-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/pre-written-resume.png'); ?>"/>
                    </div>
                    <div class="easy-txt">
                        <h4>Showcase Yorself</h4>
                        <h5>Are you lacking in words to write about yourself? Showcase yourself in an efficient manner
                            with the help of thousand preiwritten resume templates.</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="easy">
                    <div class="easy-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/downlod-cv.png'); ?>"/>
                    </div>
                    <div class="easy-txt">
                        <h4>Finally! Download Your Resume</h4>
                        <h5>Now just click on the download button and your are ready with your professionalized
                            resume.</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="temp-v">
            <div class="col-md-6 col-sm-6">
                <div class="res-temp-icn">
                    <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/resume-builder-icon.png'); ?>"/>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="res-temp">
                    <h1>We all know the importance of a good and professionalized CV in getting a good job.
                        So, why to keep yourself away from yur dream job just because of a poor formatted
                        CV.</h1>
                    <h2>Now, build your CV with the help of the most professionalized and unique CV
                        templates.</h2>
                </div>
                <div class="temp-btn">Create Now</div>
            </div>
        </div>
    </section>

<?php
$this->registerCss(' 
.temp-v {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    margin: 50px 0;
}
.temp-v div {
    flex-basis: 50%;
}
.res-temp-icn {
    text-align: center;
}
.temp-btn {
    font-family: lora;
    background-color: #fe960f;
    border: 2px solid #fe960f;
    border-radius: 10px;
    color: #fff;
    padding: 6px 30px;
    text-align: center;
    display: inline-flex;
    font-size: 20px;
    margin-top: 20px;
    opacity: 1;
    transition: 0.3s;
    cursor: pointer;
}
.temp-btn:hover {
    opacity: 0.6;
    color: #fe960f;
    background-color: #fff;
}
.res-temp h1{
    font-size: 18px;
    font-family: lora;
    font-weight: 600;
    color: #000;
    line-height: 27px;
}
.res-temp h2{
    font-style: italic;
    font-size: 28px;
    font-family: lora;
    font-weight: 600;
    color: #fe960f;
}
.row {
    margin: 0px;
}
.easy-txt h4{
    font-family: Roboto;
    font-weight: 600;
    font-size: 18px;
    color: #fff;
    text-align: center;
}
.easy-txt h5{
    margin-right: 40px;
    margin-left: 40px;
    font-size: 13px;
    font-family: Roboto;
    text-align: center;
    color: #fff;
}
.easy-icon{
    width: 74px;
    margin: 20px auto 10px;
}
.easy-steps{
    background-image: url(' . Url::to('@eyAssets/images/pages/resume-builder/easy-bg.png') . ');
    min-height: 330px;
    background-repeat: no-repeat;
    background-size: cover;
    padding-top: 20px;
    padding-bottom: 20px;
}
.easy-steps h3{
    color: #fff;
    font-size: 28px;
    font-family: roboto;
    text-align: center;
    margin: 0;
    padding-top: 20px;
}
.move img {
  position: relative;
  animation: mymove 5s infinite;
}
@keyframes mymove {
   0%  {left:0px; top:0px;}
  25%  {left:0px; top:10px;}
  50%  {left:0px; top:10px;}
  75%  {left:0px; top:0px;}
  100% {left:0px; top:0px;}
}
.head-btn{
    border: 1px solid #e26d07;
    padding: 6px 30px;
    color: #fff;
    background: #e26d07;
    border-radius: 15px;
    display: inline-flex;
    margin-top: 6px;
    font-size: 20px;
    font-family: lora;
    transition-duration: 0.3s ease-in-out;
    cursor: pointer;
}
.head-btn:hover{
    background-color: #fff;
    color: #e26d07;
}
body{
    margin: 0px;
}
.container-fluid{
    padding: 0 !important;
}
.header-res{
    background-image: url(' . Url::to('@eyAssets/images/pages/resume-builder/resume-builder-bg1.png') . ');
    min-height: 500px;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 90px 0px 15px 30px;
}
.head-txt{
    padding-top: 60px;
}
.head-txt h1{
    font-size: 31px;
	font-family: roboto;
	font-weight: 600;
	color: #fff;
}
.head-txt h2{
    font-weight: 600;
    font-size: 18px;
    font-family: lora;
    margin-bottom: 18px;
}
.head-img{
    float: right;
    width: 58%;
}
.head-img img{
    height: 364px;
    width: 306px;
}
.org-txt1{
    color: #fff;
}
.bene{
    padding-top: 20px!important;
    padding-bottom: 20px!important;
}
.benefit{
    text-align: center;
    margin-bottom: 25px;
    display: block;
}
.benefit-icon{
    text-align: center;
    width: 100%;
    max-width: 120px;
    height: 100%;
    max-height: 120px;
    min-height: 120px;
    margin: 0 auto 20px;
    border-radius: 80px;
    box-shadow: 0 0 25px 0 rgba(0,0,0,.18);
}
.benefit icon img{
    max-width: 68px;
    margin-top: 26px;
}
.benefit-txt{
    font-size: 20px;
	font-family: lora;
	font-weight: 600;
}
@media screen and (max-width: 1040px) and (min-width: 768px){
.easy-steps{
    min-height: 350px;
}
}
@media screen and (max-width: 767px) and (min-width: 670px){
.easy-steps{
    min-height: 660px;
}
}
@media screen and (max-width: 668px) and (min-width: 541px){
.easy-steps{
    min-height: 690px;
}
}
@media screen and (max-width: 540px) and (min-width: 411px){
.easy-steps{
    min-height: 690px;
}
.easy-steps h3 {
    font-size: 25px;
}
}
@media screen and (max-width: 410px) and (min-width: 360px){
.easy-steps{
    min-height: 730px;
}
.easy-steps h3 {
    font-size: 22px;
}
.easy-txt h4{
    font-size: 16px;
}
}
@media screen and (max-width: 750px){
.temp-v div {
    flex-basis: 100%;
}
.res-temp h1 {
    font-size: 15px;
    line-height: 25px;
}
.res-temp h2 {
    font-size: 25px;
}
}
@media screen and (max-width: 359px) and (min-width: 320px){
.easy-steps{
    min-height: 765px;
}
.easy-steps h3 {
    font-size: 20px;
}
.easy-txt h4{
    font-size: 16px;
}
}
@media screen and (max-width: 767px) {
.head-img
{
    display: none;
}
}
');














