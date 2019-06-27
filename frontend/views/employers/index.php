<?php

use yii\helpers\Url;
use yii\helpers\Html;
$this->title = Yii::t('frontend', 'Employers');
$this->params['header_dark'] = false;
$keywords = 'Jobs,Jobs in Ludhiana,Online Jobs,Internships,Summer Internships,Paid Internships,Jobs in Jalandhar,Top 10 Websites for Jobs,Data Entry Jobs,Latest IT Jobs for Freshers,Apply for Internship in India,Jobs near me,Internships near me,Top career sites,Best Career sites in India';
$description = 'Empower Youth is a career development platform where the candidate can apply for their desired job and internship.';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/logos/empower_fb.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth__',
        'twitter:creator' => '@EmpowerYouth__',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
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
                            <div class="main-bttn">
                                <a href="/signup/organization" class="button2">Create Account
                                    <span><i class="fas fa-arrow-right"></i></span> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!--    <section class="showcase">-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-md-12">-->
<!--                    <div class="showcase-heading">-->
<!--                        <span>Showcase Your employer brand</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                </div>-->
<!--                <div class="row">-->
<!--                <div class="showcase-subparts">-->
<!--                    <div class="col-md-4">-->
<!--                        <div class="showcase-icon">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/index2/create-profile.png')?><!--">-->
<!--                        </div>-->
<!--                        <div class="showcase-title"><span>Create Company Profile</span></div>-->
<!--                    </div>-->
<!--                    <div class="col-md-4">-->
<!--                        <div class="showcase-icon">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/index2/hiring.png')?><!--">-->
<!--                        </div>-->
<!--                        <div class="showcase-title"><span>Hiring Posters</span></div>-->
<!--                    </div>-->
<!--                    <div class="col-md-4">-->
<!--                        <div class="showcase-icon">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/index2/responsive.png')?><!--">-->
<!--                        </div>-->
<!--                        <div class="showcase-title"><span>Responsiveness to Candidates</span></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
    <section class="hwn">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Find Your Star Employee</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="hwn-box">
                        <div class="hwn-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/how-it-works11.png')?>">
                        </div>
                        <div class="hwn-title">Create a free account</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="hwn-box">
                        <div class="hwn-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/how-it-works22.png')?>">
                        </div>
                        <div class="hwn-title">Add a position</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="hwn-box">
                        <div class="hwn-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/how-it-works33.png')?>">
                        </div>
                        <div class="hwn-title">Get applications</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="hwn-box">
                        <div class="hwn-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/how-it-works44.png')?>">
                        </div>
                        <div class="hwn-title">Hire your star employee</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="fixed-bttn">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="fx-heading">
                        its free to hire from empower youth
                    </div>
                    <div class="post-job-bttn">
                        <a href="/account/dashboard" id="myBttn" class="hvr-float-shadow">
                            Post Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="how-it-works">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="heading-style">How It Works</h1>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class="step-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/identity.png') ?>">
                        </div>
                        <div class="step-heading">Show your true identity</div>
                        <div class="step-dis">Attract top talent by showing who you really are with a powerful
                            employer branding campaign.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/save-time.png') ?>">
                    </div>
                    <div class="step-heading">save time on recruitment</div>
                    <div class="step-dis">Make the most of our collaboration platform and
                        interview only qualified, culture-fit candidates.</div>
                </div>
                <div class="col-md-4">
                    <div class="step-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/hired.png') ?>">
                    </div>
                    <div class="step-heading">Recruit top talent</div>
                    <div class="step-dis">Get on board fully engaged employees and boost
                        your retention rates </div>
                </div>
            </div>
        </div>
    </section>


    <?= $this->render('/widgets/companies-with-us'); ?>

    <?= $this->render('/widgets/partner-with-us-and-feedback-form',[
        'feedbackFormModel' => $feedbackFormModel,
        'partnerWithUsModel' => $partnerWithUsModel,
    ]);?>
<!--    <div class="bluebg"></div>-->
<?php
$this->registerCss('
.hwn{
   
    text-align:center;
    padding:30px 0 50px;
}
.hwn-icon{
    max-width:150px;
    max-height:150px;
    margin:0 auto;
}
.hwn-icon img{
    width:100%;
    height:100%;
}
.hwn-title{
    margin-top:20px;
    font-size:20px;
    color:#00a0e3;
}

/*showcase starts*/
.showcase{
    padding:80px 0 110px;
    background:url(' . Url::to('@eyAssets/images/pages/index2/showcase-bg.png') . '); 
    background-size: cover;
    background-repeat:no-repeat;
    background-attachment: fixed;
}
.showcase-heading{
    text-align:center;
}
.showcase-title{
    padding-top:20px;
    font-size:20px;
}
.showcase-title span{
    background:#000;
    color:#fff;
    padding:5px;
    
}
.showcase-icon img{ 
    max-width:250px;
}
.showcase-heading span{
    text-transform:capitalize;
    font-size:35px;
    text-align:center;
    padding:5px 15px;
    color:#fff;
    background:#000;
    font-family:lobster;

}
.showcase-subparts{
    text-align:center;
    padding-top:50px;
    color:#000;
    text-transform:capitalize;
}
/*showcase ends*/
.step-heading{
    text-transform:Uppercase;
    text-align:center;
    font-size:18px;
    padding-top:10px;
    color:#00a0e3;
} 
.step-icon{
    text-align:center;
}
.step-icon img{
    max-width:150px;
    max-height:150px;
}
.step-dis{
    padding:5px 20px;
    text-align:center;
}
.bluebg{
    background:#ecf5fe;
    height:50px;
}    
.header{
    background:url(' . Url::to('@eyAssets/images/pages/index2/cover-image.png') . ');
    background-repeat:no-repeat; 
    background-size:cover;
}
.header-content{
    height:400px;
}
.vertically-center{
    position: relative;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}
.main-tagline{
    color:#fff;
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
.button2{
    border:2px solid #fff;
    padding:8px 10px;
    color:#fff;
    text-transform:uppercase;
    font-weight:bold;
  display: inline-block;
  text-align: center;
  cursor: pointer;
  position:relative;
}
.button2 span{
    position:absolute;
    opacity:0;
    right: 5px;
    top:7px;
}
.button2:hover{
    color:#fff;
    padding-right:30px;   
} 
.button2:hover span{
    opacity:1;
   right:10px; 
}
.button2, .button2 span, .button2:hover {
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -ms-transition:.3s all;
    -o-transition:.3s all;
    transition:.3s all;
}
/**/
.how-it-works{
    padding:10px 0 30px;
     background:#ecf5fe;
}

.footer{
    margin-top:0px !important;
}

.fixed-bttn{
    padding:80px 0 110px;
    background:url(' . Url::to('@eyAssets/images/pages/index2/get-hired-bg.jpg') . '); 
    background-size: cover;
    background-repeat:no-repeat;
    background-attachment: fixed;
}
.fx-heading{
  text-transform:capitalize;
    font-size:35px;
    text-align:center;
    padding:0 0 20px 0;
    color:#666666;
    font-family:lobster;
}
.post-job-bttn{
    text-align:center;
}
.post-job-bttn a{
    background:#00a0e3;
    color:#fff;
    border-radius:5px;
    text-transform: uppercase;
    padding:10px 20px;
    font-size:18px;
    box-shadow:0 0 10px rgba(66, 63, 63, .5);
    -webkit-transition:.3s all;
   transition:.3s all;
   text-align:center;
   margin:0 auto;
   max-width:300px;
   display:block;
   font-weight:600;
}
.post-job-bttn a:hover{
   box-shadow:none;
   -webkit-transition:.3s all;
   transition:.3s all;
}
.hvr-float-shadow {
  vertical-align: middle;
  -webkit-transform: perspective(1px) translateZ(0);
  transform: perspective(1px) translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  position: relative;
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-property: transform;
  transition-property: transform;
}
.hvr-float-shadow:before {
  pointer-events: none;
  position: absolute;
  z-index: -1;
  content: \'\';
  top: 100%;
  left: 5%;
  height: 10px;
  width: 90%;
  opacity: 0;
  background: -webkit-radial-gradient(center, ellipse, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0) 80%);
  background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0) 80%);
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-property: transform, opacity;
  transition-property: transform, opacity;
}
.hvr-float-shadow:hover, .hvr-float-shadow:focus, .hvr-float-shadow:active {
  -webkit-transform: translateY(-5px);
  transform: translateY(-5px);
}
.hvr-float-shadow:hover:before, .hvr-float-shadow:focus:before, .hvr-float-shadow:active:before {
  opacity: 1;
  -webkit-transform: translateY(5px);
  transform: translateY(5px);
}

');
