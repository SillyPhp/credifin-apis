<?php

use yii\helpers\Url;

$this->title = 'Education Loan';
$keywords = 'Education Loan | Empower Youth';
$description = 'Everyone deserves access To Education, EmpowerYouth believes in funding dreams by helping youth fulfill their career potentials.';
$image = Url::to('@eyAssets/images/pages/education-loans/education-loan-share.png', 'https');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl("https"),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl("https"),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>

    <section class="bg-loans-set">
        <div class="row m0">
            <div class="col-md-12 col-sm-12 col-xs-12 p0">
                <div class="loanSchemesFlex">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="row">
                            <div class="col-md-11 col-md-offset-1 col-sm-12">
                                <div class="heading-data-set">
                                    <h3>Everyone deserves access to education<br> and with our help, it's just a couple of clicks away.</h3>
                                    <h4>EmpowerYouth believes in funding dreams by helping youth fulfill their career potentials.</h4>
                                    <p>Interested? Get started today!</p>
                                    <div class="loan-btn">
                                        <a href="/education-loans/apply">Apply Now!</a>
                                        <a href="/site/admission-form">Enquire Now!</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 p0">
                                <div class="image-topics">
                                    <div class="icon-loan">
                                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/low-interest-rate.png') ?>" alt="online-education=loan-in-India">
                                        <p>Low Rate Of Interest</p>
                                    </div>
                                    <div class="icon-loan">
                                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/quick-disbursment.png') ?>" alt="">
                                        <p>Quick Disbursement</p>
                                    </div>
                                    <div class="icon-loan">
                                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/online-application.png') ?>" alt="">
                                        <p>Online Application</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="student-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-cibil.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.image-topics{
    background:url(' . Url::to('@eyAssets/images/pages/education-loans/orangeshape.png') . ');
    background-size: cover;
    max-width: 600px;
    padding: 20px;
}
.icon-loan {
    display: inline-block;
    margin: 0 15px;
    text-align: center;
}
.loanSchemesFlex{
    display: flex;
    align-items: flex-end;
    flex-wrap: wrap;
    margin: 0 -15px;
}
.icon-loan img {
    width: 90px;
    height: 90px;
    object-fit: contain;
}
.icon-loan p {
    margin: 10px 0 0;
    color: #fff;
    font-family: Roboto;
}
.bg-loans-set{
    background-color: #fff;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    padding: 65px 0px 0px 0px;
    overflow: hidden;
}
.heading-data-set {
	padding: 60px 0 35px;
}
.m0{
    margin-left: 0px;
    margin-right: 0px; 
}
.p0{
    padding-left: 0px;
    padding-right: 0px;
}
.heading-data-set h3 {
	font-size: 26px;
    color: #ED6D1E;
    font-family: roboto;
    font-weight: 600;
    line-height: 40px;
    text-transform: uppercase;
}
.heading-data-set h4 {
	font-size: 20px;
    font-family: roboto;
    color: #000;
    font-weight: 500;
    margin: 10px 0;
}
.heading-data-set p {
    font-size: 18px;
    font-family: roboto;
}
.loan-btn a {
	color: #fff;
	background-color:#ED6D1E;
	font-size: 16px;
	font-family: roboto;
	border: 2px solid #ED6D1E;
	padding: 4px 15px;
	border-radius: 4px;
	display: inline-block;
	transition:ease-in-out .2s;
}
.loan-btn a:hover{
    color:#ED6D1E;
    background-color:#fff;
}
.student-icon{
    display: flex;
    align-items: baseline;
    justify-content: center;
    max-height: 450px;
}
.student-icon img{
    padding: 14px 50px 0 0;   
}
@media screen and (max-width: 992px) and (min-width: 768px) {
    .heading-data-set h3 {
        font-size: 22px;
        margin-left: 30px;
        line-height: 38px;
    }
    .heading-data-set p, .heading-data-set h4 {
        font-size: 16px;
        margin-left: 30px;
    }
    .loan-btn {
         margin-left: 30px;
    }
    .student-icon img{
        padding-left: 0px; 
    }
    .student-icon img{
       max-width: 360px;
    }
    .icon-loan img {
        width: 60px;
        height: 60px;
    }
    .image-topics {
        padding: 20px 5px;
    }
}
@media only screen and (max-width: 767px) {
    .bg-loans-set{
        background-position: left;
    }
    .heading-data-set {
        text-align: center;
    }
    .heading-data-set h3 {
        font-size: 25px;
        line-height: 35px;
    }
    .image-topics {
        background: #ed6d1e;
        width: 100%;
        max-width: unset;
        padding: 20px 15px;
        text-align: center;
    }
    .student-icon img{
        padding-left: 0px; 
    }
    .student-icon img{
       display: none;
    }
    .image-topics img {
        width: 90%;
    }
    .icon-loan img {
        width: 60px;
        height: 60px;
    }
    .loan-btn a {
        margin-left: 10px;
    }    
}
@media only screen and (max-width: 550px) {
.image-topics{
    text-align:center;
    width:100%;
    display: flex;
}
.icon-loan{
    margin-bottom:15px;
}
.student-icon img{
    display:none;
}
.icon-loan img {
    width: 60px;
    height: 60px;
}
.heading-data-set h3 {
    font-size: 20px;
    line-height: 30px;
}
.heading-data-set h4 {
    padding: 8px;
    font-size: 18px;
    line-height: 24px;
}
.heading-data-set p {
    font-size: 16px;
    line-height: 22px;
}
}
');
