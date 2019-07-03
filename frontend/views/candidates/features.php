<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = true;
$this->title = Yii::t('frontend', 'Candidate Features');

$keywords = 'Candidates,Jobs,Internships,Resume,Jobs Apply,Latest Jobs,Jobs in India';
$description = 'Empoweryouth candidate feature page will help you to know the gist of the platform. see how the feature like ATS and immediate resume making makes the platform unique from others.';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/logos/empower_fb.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth__',
        'twitter:creator' => '@EmpowerYouth__',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>
    <section class="candidate-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="animation-relative">
                        <div class="element1" id="el1">
                            <div class="chat-box2">
                                <img src="<?= Url::to('@eyAssets/images/pages/animation-company-feature/2girls.png') ?>"
                                     id="text-img">
                            </div>
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/c1.png') ?>">
                        </div>
                        <div class="element2">
                            <div class="chat-box2">
                                <img src="<?= Url::to('@eyAssets/images/pages/animation-company-feature/asst-boss.png') ?>"
                                     id="text-img3">
                            </div>
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/c2.png') ?>">
                        </div>
                        <div class="element3">
                            <div class="chat-box2">
                                <img src="<?= Url::to('@eyAssets/images/pages/animation-company-feature/boy.png') ?>"
                                     id="text-img2">
                            </div>
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/c3.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ohidden">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Features</div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div class="col-md-12">
                        <div data-aos="fade-right" class="heading">Most informative jobs site ever!</div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-right" class="sub-heading"> Know every minor detail about the company before you apply</div>

                        <div data-aos="fade-right" class="feature-list">
                            <ul>
                                <li>Jobs and internships with full description</li>
                                <li>Information of the companies in detail</li>
                                <li>Learn about the companies beforehand</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-left" class="cf-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/job-info.png')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div class="col-md-6 col-md-offset-6">
                        <div data-aos="fade-left" class="heading">Build your career with verified jobs and internships</div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-right" class="cf-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/build-career.png') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-left" class="sub-heading">Tired of counterfeit jobs? Get only verified jobs without any doubt.</div>

                        <div data-aos="fade-left" class="feature-list">
                            <ul>
                                <li>Only verified jobs and internships available</li>
                                <li>No more fuss of counterfeit jobs</li>
                                <li>Apply only in genuine companies</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div class="col-md-12">
                        <div data-aos="fade-right" class="heading">Give your review, might help someone!</div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-right" class="sub-heading">You can freely give your reviews and let others know your opinions.</div>

                        <div data-aos="fade-right" class="feature-list">
                            <ul>
                                <li>Post reviews about any firm or company</li>
                                <li>Also give reviews on educational institutes.</li>
                                <li>Also see other people’s reviews.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-left" class="cf-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/reviews-icon.png')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div class="col-md-6 col-md-offset-6">
                        <div data-aos="fade-left" class="heading">Don’t have a resume? Build your resume with us.</div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-right" class="cf-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/cv.png')?>">
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div data-aos="fade-left" class="sub-heading">Don’t worry if you don’t have a resume. You can make your resume and apply for any job of your choice.</div>

                        <div data-aos="fade-left" class="feature-list">
                            <ul>
                                <li>Fill necessary information</li>
                                <li>Build resume with relevant data</li>
                                <li>Adequate space for adding essential data</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div class="col-md-12">
                        <div data-aos="fade-right" class="heading">Connect with us on social media</div>
                    </div>
                    <div class="col-md-6">

                        <div data-aos="fade-right" class="sub-heading">You can easily find us on various social media platforms. </div>

                        <div data-aos="fade-right" class="feature-list">
                            <ul>
                                <li>See posts related to new upgrades</li>
                                <li>You can also drop comments and messages </li>
                                <li>Also see posts related jobs and internships</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-left" class="cf-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/socialmedia.png')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div data-aos="fade-left" class="col-md-6 col-md-offset-6">
                        <div class="heading">Drop Resume</div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-right" class="cf-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/cv1.png')?>">
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div data-aos="fade-left" class="sub-heading">Your dream company does not have any vacancies? Still apply.</div>

                        <div data-aos="fade-left" class="feature-list">
                            <ul>
                                <li>Drop your resume</li>
                                <li>Apply for the position beforehand</li>
                                <li>Be the first one to apply</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div class="col-md-12">
                        <div data-aos="fade-right" class="heading">Compare jobs and internships</div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-right" class="sub-heading">Know what is best for you! compare jobs and internships</div>

                        <div data-aos="fade-right" class="feature-list">
                            <ul>
                                <li>Compare from multiple options</li>
                                <li>Choose the best one</li>
                                <li>Apply for more than one</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-left" class="cf-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/comparejob.png')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div class="col-md-6 col-md-offset-6">
                        <div data-aos="fade-left" class="heading">Confidentiality of personal information</div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-right" class="cf-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/confidential-info.png')?>">
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div data-aos="fade-left" class="sub-heading">No worries of privacy any more, all your personal information will be safe.</div>

                        <div data-aos="fade-left" class="feature-list">
                            <ul>
                                <li>Fill your details without worrying</li>
                                <li>Your personal information will remain confidential</li>
                                <li>All personal data is stored in safe space</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div class="col-md-12">
                        <div data-aos="fade-right" class="heading">Operate through your phone</div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-right" class="sub-heading">Use our application on your phone.</div>

                        <div data-aos="fade-right" class="feature-list">
                            <ul>
                                <li>Easily accessible</li>
                                <li>Have access to your account anywhere</li>
                                <li>Get notified on your phone </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-left" class="cf-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/phone.png')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div class="col-md-6 col-md-offset-6">
                        <div data-aos="fade-left" class="heading">Track your application's status</div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-right" class="cf-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/status.png')?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-aos="fade-left" class="sub-heading">Easily know your applications’ status</div>

                        <div data-aos="fade-left" class="feature-list">
                            <ul>
                                <li>Easily know your interview schedule</li>
                                <li>Stay updated with each step of recruitment process</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="cf-box">
                    <div class="col-md-12">
                        <divdata-aos="fade-right" class="heading">Easy steps to apply</div>
                </div>
                <div class="col-md-6">
                    <div data-aos="fade-right" class="sub-heading">Make your career development journey fun!</div>
                    <div data-aos="fade-right" class="feature-list">
                        <ul>
                            <li>Add daily tasks</li>
                            <li>Create and manage your profile</li>
                            <li>Edit your job preferences</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div data-aos="fade-left" class="cf-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/stepstoapply1.png')?>">
                    </div>
                </div>
            </div>
        </div>
        </div>


    </section>
<?php
$this->registerCss('
.ohidden{
    overflow:hidden;
}
.candidate-header{
     background:url(' . Url::to('@eyAssets/images/pages/company-and-candidate/cfeaturebg.png') . ');
     min-height:400px;
     background-repeat:no-repeat;
     background-size: cover;
    background-position:bottom;
}
#text-img{
    max-width:140px;
}
.chat-box2{
     -webkit-animation: updownbox 2s ; /* Safari, Chrome and Opera > 12.1 */
       -moz-animation: updownbox 2s; /* Firefox < 16 */
        -ms-animation: updownbox 2s; /* Internet Explorer */
         -o-animation: updownbox 2s; /* Opera < 12.1 */
            animation: updownbox 2s;
    -moz-animation-iteration-count:infinite;  
    animation-iteration-count:infinite;  
    -moz-animation-timing-function: linear;
    animation-timing-function: linear;
}
@-webkit-keyframes updownbox {
    from { 	transform: rotate(0deg) translateX(2px) rotate(0deg); }
	to   {  transform: rotate(360deg) translateX(2px) rotate(-360deg); }
}
@-moz-keyframes updownbox {
    from { 	transform: rotate(0deg) translateX(2px) rotate(0deg); }
	to   {  transform: rotate(360deg) translateX(2px) rotate(-360deg); }
}
@keyframes updownbox{
    from { 	transform: rotate(0deg) translateX(2px) rotate(0deg); }
	to   {  transform: rotate(360deg) translateX(2px) rotate(-360deg); }
}
.animation-relative{
    position:relative;
    min-height: 400px;
}
.element1{
    position:absolute;
    bottom:50px;
    left:200px;
}
.element1 img{
    max-width:110px;
}
.element3{
    position:absolute;
    bottom:20px;
    left:500px;
}
.element3 img{
    max-height:180px;
}
.element2 {
    position:absolute;
    bottom:40px;
    left:850px;
}
.element2 img{
    max-height:210px;
}
.feature-list ul li{
    list-style-type:circle;
    margin-left:30px;
    font-size:16px;
}

.heading{
    font-family:lora;
    color:#000;
    font-size:25px;
    font-weight:bold;
 }  
.sub-heading{
    font-family:lora;
    font-size:20px;
    font-weight:bold;
    color:#000;
}
.cf-box{
    padding:40px 0;
}
.cf-icon{
    text-align:center;
}
.cf-icon img{
    max-height:300px;
    max-width:300px;
    margin:0 auto;
    padding: 0 0 20px 0;
}

  .pos-abso{       
    position:absolute;
//    top:50%;
//    transform:translateY(-50%);
}
.pos-rel{
    position:relative;
    min-height:400px;
}
  
@media only screen and (max-width: 992px){
    .cf-icon img{
       padding: 20px 0 20px 0; 
    }
} 
 ');
$script = <<<JS
if ($(window).width() > 992){
     $('.element1').css({'left':'0px', 'opacity':'0'}).animate({'left':'150px','opacity':'1' },"slow");
     $('.element2').css({'left':'0px', 'opacity':'0'}).animate({'left':'850px', 'opacity':'1'},"slow");
     $('.element3').css({'left':'0px', 'opacity':'0'}).animate({'left':'500px', 'opacity':'1'},"slow");
     $('#text-img').delay(1500).fadeIn();
     $('#text-img2').delay(2000).fadeIn();
 } else if ($(window).width()<992)  {
     $('.element3').css({'left':'0px', 'opacity':'0'}).animate({'left':'100px', 'opacity':'1'},"slow");
     $('.element1').css({'left':'0px', 'opacity':'0'}).animate({'left':'400px','opacity':'1' },"slow");
     $('#text-img').delay(1000).fadeIn();
     $('#text-img2').delay(1500).fadeIn();   
 } 
 

 AOS.init();
JS;
$this->registerJs($script);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
$this->registerCssFile('https://unpkg.com/aos@2.3.1/dist/aos.css');
$this->registerJsFile('https://unpkg.com/aos@2.3.1/dist/aos.js');