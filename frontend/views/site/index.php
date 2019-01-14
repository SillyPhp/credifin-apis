<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['header_dark'] = false;
?>

<section class="slider">
    <div class="block no-padding">
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-featured-sec style2">
                        <ul class="main-slider-sec style2 text-arrows">
                            <li class="slideHome"><img src="<?= Url::to('@eyAssets/images/pages/index2/mslider1.jpg') ?>" alt=""/></li>
                            <li class="slideHome"><img src="<?= Url::to('@eyAssets/images/pages/index2/mslider2.jpg') ?>" alt=""/></li>
                            <li class="slideHome"><img src="<?= Url::to('@eyAssets/images/pages/index2/mslider3.jpg') ?>" alt=""/></li>
                        </ul>
                        <div class="job-search-sec">
                            <div class="job-search style2">
                                <h3>The Easiest Way to Get Your New Job</h3>
                                <span>Find Jobs, Employment & Career Opportunities</span>
                                <div class="search-job2">
                                    <form>
                                        <div class="row no-gape">
                                            <div class="col-lg-6 col-md-6 col-sm-4">
                                                <div class="job-field">
                                                    <input type="text" placeholder="Keywords"/>
                                                </div>
                                            </div>
<!--                                            <div class="col-lg-3 col-md-3 col-sm-4">-->
<!--                                                <div class="job-field">-->
<!--                                                    <select data-placeholder="All Regions" class="chosen-city">-->
<!--                                                        <option>Istanbul</option>-->
<!--                                                        <option>New York</option>-->
<!--                                                        <option>London</option>-->
<!--                                                        <option>Russia</option>-->
<!--                                                    </select>-->
<!--                                                </div>-->
<!--                                            </div>-->
                                            <div class="col-lg-4 col-md-3 col-sm-4">
                                                <div class="job-field">
                                                    <select data-placeholder="Any category" class="chosen-city">
                                                        <option>Jobs</option>
                                                        <option>Internship</option>
                                                        <option>Training</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2  col-md-3 col-sm-12">
                                                <button type="submit">Search <i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- Job Search 2 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="header-row">
        <div class="container">
            <div class="header-boxs">
                <div class="box-border fade-in one">
                    <!--<div class="box-overlay"></div>-->
                    <div class="icon"><img src="<?= Url::to('@eyAssets/images/pages/index2/corporates.svg') ?>"></div>
                    <div class="h-heading">Corporates</div>
                    <div class="h-text">Ask and answer questions, share results</div>

                    <!--                    <div class="middle">
                                            <div class="text">John Doe</div>
                                        </div>-->
                </div>
                <div class="box-border fade-in two">
                    <div class="icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/candidates.svg') ?>">
                    </div>
                    <div class="h-heading">Candidates</div>
                    <div class="h-text">Consultants, test preparation, travel services</div>
                </div>
                <div class="box-border fade-in three">
                    <div class="box-overlay">
                        <div class="icon"><img src="<?= Url::to('@eyAssets/images/pages/index2/universities.svg') ?>">
                        </div>
                        <div class="h-heading">Universities & Colleges</div>
                        <div class="h-text">Search or let universities find you</div>
                    </div>
                    <div class="overlay">
                        <div class="text">Coming Soon</div>
                    </div>
                </div>
                <div class="box-border fade-in four">
                    <div class="box-overlay">
                        <div class="icon"><img src="<?= Url::to('@eyAssets/images/pages/index2/consultants.svg') ?>">
                        </div>
                        <div class="h-heading">Consultants</div>
                        <div class="h-text">Latest news & everything you need to know</div>
                    </div>
                    <div class="overlay">
                        <div class="text">Coming Soon</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--------services section starts-------->

<section class="services-section">
    <div class="container">
        <div class="heading-style ">Our Services</div>
        <div class="services row">
            <div class="col-md-6 serv-center">
                <a href="<?= Url::to('/jobs'); ?>">
                    <div class="service-box">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/job.png') ?>">
                        </div>
                        <div class="ser-heading">Jobs</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="<?= Url::to('/internships'); ?>">
                    <div class="service-box ser-box-orange">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/internships.png') ?>">
                        </div>
                        <div class="ser-heading">Internships</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<!---->
<section class="fixed-bttn">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="fx-heading">
                    Its Free To Get Hired On Empower Youth
                </div>
                <div class="post-job-bttn">
                    <a href="#" id="myBttn" class="hvr-float-shadow">
                        Get Hired
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!---->
<!---------------how it works-------------->
<section class="how-it-works">
    <div class="container">
        <div class="heading-style ">Solutions</div>
        <div class="row steps-row">
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-5 col-sm-5">
                    <div class="how-icon animatable fadeIn">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/em2.svg') ?>">
                    </div>
                </div>
                <div class="col-md-7 col-sm-7">
                    <div class="how-text-box">
                        <div class="how-heading">Employment</div>
                        <div class="how-text">Create a profile with your past education and experience details, add
                            goals and preferences to let people know you better.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row steps-row">
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-7 col-sm-7">
                    <div class="how-text-box">
                        <div class="how-heading">Skill Enhancement</div>
                        <div class="how-text">Browse our portal, check out the services that we offer and find the
                            service that you are looking for.
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-5">
                    <div class="how-icon how-icon-right animatable fadeIn">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/se1.svg') ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row steps-row">
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-5 col-sm-5">
                    <div class="how-icon animatable fadeIn">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/create-resume.png') ?>">
                    </div>
                </div>
                <div class="col-md-7 col-sm-7">
                    <div class="how-text-box">
                        <div class="how-heading">Create Resume</div>
                        <div class="how-text">Once you have found the service that you desire than why wait avail it
                            right away
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--how it works ends-->
<!--new section starts-->
<section class="companies">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="com-grid">
                    <div class="heading-style">Companies With Us</div>
                    <div class="">Companies recruiting top talent from our portal.</div>
                    <div class="com1 animatable fadeIn">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/capital-small-finance.png') ?>">
                        </div>
                        <div class="com-name">
                            Capital Small Finance Bank
                        </div>
                    </div>
                    <div class="com2 animatable fadeIn">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/midland.png') ?>">
                        </div>
                        <div class="com-name">
                            Midland MicroFin
                        </div>
                    </div>
                    <div class="com3 animatable fadeIn">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/dsb.png') ?>">
                        </div>
                        <div class="com-name">
                            DSB Law Group
                        </div>
                    </div>
                    <div class="com4 animatable fadeIn">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/hag.png') ?>">
                        </div>
                        <div class="com-name">
                            HAG India
                        </div>
                    </div>
                    <div class="com5 animatable fadeIn">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/agile.png') ?>">
                        </div>
                        <div class="com-name">
                            Agile Finserv
                        </div>
                    </div>
                    <div class="com6 animatable fadeIn">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/olready.png') ?>">
                        </div>
                        <div class="com-name">
                            Olready
                        </div>
                    </div>
                    <div class="com8 animatable fadeIn">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/ey.svg') ?>">
                        </div>
                        <div class="com-name">
                            Empower youth
                        </div>
                    </div>
                    <div class="com9 animatable fadeIn">
                        <div class="com-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/hamco.png') ?>">
                        </div>
                        <div class="com-name">
                            Hamco Ispat
                        </div>
                    </div>
                    <div class="com10 animatable fadeIn">
                        <div class="com-logo">
                            <img src="<?= Url::to('@commonAssets/logos/text-logo.png') ?>">
                        </div>
                        <div class="com-name">
                            Empower youth
                        </div>
                    </div>
                    <div class="com11 animatable fadeIn">
                        <div class="com-logo">
                            <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                        </div>
                        <div class="com-name">
                            Empower youth
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
<!--new section ends-->

<section class="partner">
    <div class="container">
        <div class="heading-style ">Join our Community</div>
        <div class="row partner-row">
            <div class="col-md-12">
                <div class="col-md-6 col-sm-6">
                    <div class="partner-btn">
                        <button type='button' class="feed-open2">Partner with Us</button>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="partner-btn">
                        <button type="button" class="feed-open">Give us Feedback</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="window-popup message-popup">
    <a href="#" class="popup-close">
        <i class="fa fa-times"></i>
    </a>
    <article class="content-wrapper">
        <header class="modal-header">
            <h3>Reach us instantly via form below.</h3>
        </header>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $form = ActiveForm::begin([
                        'id' => 'feedback-form',
                        'action' => '/site/send-feedback',
                    ]);
                    ?>
                    <?= $form->field($feedbackFormModel, 'name', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-user"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Your Name', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'email', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-envelope"></i>{error}{hint}</div>'])->textInput(['class' => 'lowercase', 'placeholder' => 'Email Address', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'phone', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-phone"></i>{error}{hint}</div>'])->textInput(['placeholder' => 'Phone Number', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'subject', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-file-text-o"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Subject', 'autocomplete' => 'off'])->label(false); ?>
                    <?= $form->field($feedbackFormModel, 'message', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-pencil"></i>{error}{hint}</div>'])->textarea(['placeholder' => 'Your Message', 'autocomplete' => 'off'])->label(false); ?>
                    <?= Html::submitButton('Submit', ['class' => 'action']); ?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </article>

</div>
<div class="window-popup2 message-popup">
    <a href="#" class="popup-close2">
        <i class="fa fa-times"></i>
    </a>
    <article class="content-wrapper">
        <header class="modal-header">
            <h2>Partner With Us.</h2>
            <h5>Want to collaborate with us, fill the form and we will get back to you</h5>
        </header>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <?php
                        $formm = ActiveForm::begin([
                            'id' => 'partner-with-us-form',
                            'action' => '/site/partner-with-us',
                        ]);
                        ?>
                        <?= $formm->field($partnerWithUsModel, 'name', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-user"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Your Name', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'email', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-envelope"></i>{error}{hint}</div>'])->textInput(['class' => 'lowercase', 'placeholder' => 'Email Address', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'phone', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-phone"></i>{error}{hint}</div>'])->textInput(['placeholder' => 'Phone Number', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'subject', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-file-text-o"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Subject', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'company_name', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-file-text-o"></i>{error}{hint}</div>'])->textInput(['class' => 'capitalize', 'placeholder' => 'Company Name', 'autocomplete' => 'off'])->label(false); ?>
                        <?= $formm->field($partnerWithUsModel, 'message', ['template' => '<div class="with-icon">{input}<i class="utouch-icon utouch-icon-user fa fa-pencil"></i>{error}{hint}</div>'])->textarea(['placeholder' => 'Your Message', 'autocomplete' => 'off'])->label(false); ?>
                        <?= Html::submitButton('Submit', ['class' => 'action']); ?>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
<div class="fixed-btn background-logo-blue">
    <a href="/site/company-index"> <img
                src="<?= Url::to('@eyAssets/images/flaticon-png/small/team-white.png'); ?>"/><br/>
        <?= Yii::t('frontend', 'Are you an Employer?'); ?><br/>
        <span><?= Yii::t('frontend', 'Want to post a Job or an Intenship?'); ?></span></a>
</div>

<?php
$this->registerCss('
.fixed-btn a{
    position: fixed;
    text-align: center;
    width: 150px;
    color: #fff !important;
    bottom: 0px;
    left:0px;
    border-right: 4px solid orange;
    z-index: 999999;
    height: 112px;
    opacity: 0.9;
    padding: 10px 0px;
    transition: ease-in-out .3s;
    cursor: pointer;
    bottom: -42px;
    border-top-right-radius: 28px;
}
.fixed-btn a span{
    font-weight: 700;
    color: #fff;
}
.fixed-btn a:hover{
    opacity: 1;
    bottom: 0px;
}
.background-logo-blue a{
    background-color: #49a1e3;
}
/*try now sec*/
.fixed-bttn{
    padding:60px 0 100px;
    background:url(' . Url::to('@eyAssets/images/pages/index2/footer-bg-1.png') . '); 
    background-size: cover;
    background-attachment:fixed;
    background-repeat:no-repeat;
}
.fx-heading{
  text-transform:capitalize;
    font-size:35px;
    text-align:center;
    padding:0 0 20px 0;
    color:#666666;
    font-family:lobster;
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
/*try now ends*/

.animated.fadeIn {
	-webkit-animation-name: fadeIn;
	-moz-animation-name: fadeIn;
	-o-animation-name: fadeIn;
	animation-name: fadeIn;
}
.animatable {
  
  /* initially hide animatable objects */
  visibility: hidden;
  
  /* initially pause animatable objects their animations */
  -webkit-animation-play-state: paused;   
  -moz-animation-play-state: paused;     
  -ms-animation-play-state: paused;
  -o-animation-play-state: paused;   
  animation-play-state: paused; 
}

/* show objects being animated */
.animated {
  visibility: visible;
  
  -webkit-animation-fill-mode: both;
  -moz-animation-fill-mode: both;
  -ms-animation-fill-mode: both;
  -o-animation-fill-mode: both;
  animation-fill-mode: both;
  
  -webkit-animation-duration: .3s;
  -moz-animation-duration: .3s;
  -ms-animation-duration: .3s;
  -o-animation-duration: .3s;
  animation-duration: .3s;

  -webkit-animation-play-state: running;
  -moz-animation-play-state: running;
  -ms-animation-play-state: running;
  -o-animation-play-state: running;
  animation-play-state: running;
}
@-webkit-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

@-moz-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

@-o-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}

@keyframes fadeIn {
	0% {
		opacity: 0;
	}
	60% {
		opacity: 0;
	}
	20% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}


.box-border:hover{
    -ms-transform: scale(1.1,1.1); 
    -webkit-transform: scale(1.1,1.1); 
    transform: scale(1.1,1.1);

    -ms-transition:.3s all; 
    -webkit-transition:.3s all;
    transition:.3s all;
}
.box-border{
    background: #fff;
    border:1px solid rgba(234,238,238,.8);
    padding: 20px 30px;
    text-align: center;
    box-shadow: 0 0 5px rgba(0,0,0,.1); 
    margin-bottom: 20px; 
    max-width: 200px;
    margin-left: 20px;
    position:relative;
    -ms-transition:.3s all; 
    -webkit-transition:.3s all;
    transition:.3s all;
} 
.box-overlay {
    display: block;
  width: 100%;
  height: auto;
}
.overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #008CBA;
    overflow: hidden;
    width: 100%;
    height: 0;
    transition: .5s ease;
}
.text { 
    color: white;
    font-size: 20px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
}
.box-border:hover .box-overlay {
    opacity: 0.1;
}
.box-border:hover .overlay {
    height: 50%;
}


/*how we are different*/
.different{
    overflow-x:hidden
}
/*how we are different ends*/

/*services section starts*/
.services{
    padding: 50px 0 50px 0; 
    text-align:center !important;
}
.service-box{ 
    background:url(' . Url::to('@eyAssets/images/pages/index2/orange-bg.png') . ');
    padding:20px 20px;
    border-radius:10px;
    border-width:5px 0px 0px 0px; 
    border-color:transparent;
    border-style:solid;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    width: 80%;
    margin: auto;
    margin-bottom:20px;
    box-shadow: 0px 2px 13px 0px #ddddddb8;
    background-size: 100%;
    background-position: 0px -8px;
    background-repeat:no-repeat;
}
.service-box:hover{
    box-shadow: 0px 2px 13px 3px #ddddddb8;
    border-top:5px solid #ff7803;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.ser-box-orange{
    background:url(' . Url::to('@eyAssets/images/pages/index2/bgq.png') . ');
    padding:20px 20px;
    border-radius:10px;
    border-width:5px 0px 0px 0px; 
    border-color:transparent;
    border-style:solid;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    width: 80%;
    margin: auto;
    margin-bottom:20px;
    box-shadow: 0px 2px 13px 0px #ddddddb8;
    background-size: 100%;
    background-position: 0px -8px;
    background-repeat:no-repeat;
}
.ser-box-orange:hover{
    box-shadow: 0px 2px 13px 3px #ddddddb8;
    border-top:5px solid #00a0e3;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.ser-icons{
    text-align:center;
}
.ser-icons img{
    max-height: 150px; 
    max-width: 150px;
}
.serv-center{
    padding:0 30px;
}
.ser-heading{
    padding: 10px 0 0 0;
    text-transform: uppercase;
    font-size: 20px;
    text-align:center;
}
/*services section ends*/
/*how it works section starts*/
.how-it-works{
    padding: 0px 0 30px 0;
    background:#ecf5fe;
}
.how-heading{
    color:#f07706;
    font-size: 20px;
    font-family: lobster;
//    font-weight: bold;
//    text-transform: uppercase;
}
.steps-row{
    padding: 30px 0;
}
.how-text-box{
    padding:60px 0 0 0;
    text-align:center;
}
.how-icon img{
    width:300px;
    max-height:300px;    
}
.how-icon-right{
    text-align:right;
}
/*how it works section ends*/
/*-------------------------------------*/
/*partner with us*/
.partner{
    padding:0px 0 80px 0;
    text-align:center;
    background:#ecf5fe;
}
.partner-btn button{
    border: 2px solid #00a0e3;
    border-width: 2px 12px;
    padding: 14px 59px;
    background: #00a0e3 !important;
    color: #fff;
    text-transform: uppercase;
    border-radius: 9px 50px;
    transition:.6s all;
    -webkit-transition:.6s all;
    -o-transition:.6s all;
    -moz-transition:.6s all;
    -ms-transition:.6s all;
}
.partner-btn button:hover{
    border:2px solid #00a0e3;
    border-width: 2px 12px;
    background: #00a0e3 !important;
    color: #fff;
    border-radius: 9px 0px;
    transition:.6s all;
    -webkit-transition:.6s all;
    -moz-transition:.6s all;
    -o-transition:.6s all;
    -ms-transition:.6s all;
}
.partner-row{
    padding:30px 0 0 0; 
}
.footer{
    margin-top:0px !important;
}
/*partner with us ends*/

@media only screen and (min-width: 1120px){
    .seq .seq-model {
        margin-left: 0;
        width: 45.5%;
    }
    .seq .seq-title {
        width: 41.5%;
        margin-right: 0;
    }
}
@media only screen and (min-width: 992px) {
    .box-border{
        height: 260px;
    }
}
/*Modal css starts */
.content-wrapper {
    position: relative;
    display: block;
    max-width: 560px;
    margin: 100px auto;
    padding: 1.5rem 3.5rem;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0px -15px 0px 0px rgba(69, 74, 79, 0.5), 15px -30px 0px 0px rgba(69, 74, 79, 0.5), 30px -45px 0px 0px rgba(69, 74, 79, 0.5), 45px -60px 0px 0px rgba(69, 74, 79, 0.5);
    transition: transform 0.25s;
    transition-delay: 0.15s;
}
.content-wrapper .modal-header {
    position: relative;
    width: 100%;
    margin: 0;
    padding: 0 0 0.25rem;
    margin-bottom: 10px;
    text-align:center;
}
.content-wrapper .modal-header h2 {
    font-size: 1.5rem;
    font-weight: bold;
}
.content-wrapper .content {
    position: relative;
    display: block;
    text-align:center;
}
.action {
    position: relative;
    width: 100%;
    height: 53px;
    padding: 0.625rem 1.25rem;
    border: none;
    background-color: slategray;
    border-radius: 0.25rem;
    color: white;
    font-size: 0.87rem;
    font-weight: 300;
    overflow: hidden;
    z-index: 1;
    background-color: #e74c3c;
}
.action:before {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    width: 0%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.2);
    transition: width 0.25s;
    z-index: 0;
}
.action:hover:before {
    width: 100%;
}
.with-icon {
    position: relative;
}
.has-error .with-icon input, .has-error .with-icon textarea {
    border: 1px solid #ff00004d !important;
}
.has-success .form-control {
    border-color: transparent !important;
}
#feedback-form input, #feedback-form textarea, #partner-with-us-form input, #partner-with-us-form textarea{
    padding: 13px 40px !important;
    border: 1px solid transparent !important;
    transition: all .3s ease !important;
    font-size: 16px !important;
    color: #273f5b !important;
    margin-bottom: 20px !important;
    border-radius: 50px !important;
    height:53px !important;
    background-color: #fff !important;
    box-shadow: 0 0 30px 0 rgba(18, 25, 33, 0.15) !important;
    width: 100% !important;
    outline: none !important;
    padding-left: 50px !important;
}
#feedback-form input:focus, #feedback-form textarea:focus, #partner-with-us-form input:focus, #partner-with-us-form textarea:focus{
    -webkit-box-shadow: 5px 0 40px 0 rgba(0, 88, 171, 0.25) !important;
    box-shadow: 5px 0 40px 0 rgba(0, 88, 171, 0.25) !important;
    color: #0083ff !important;
    outline: 0 !important;
}
.with-icon .utouch-icon {
    position: absolute !important;
    left: 12px !important;
    top: 18px !important;
    height: 16px !important;
    border-right: 1px solid #dbe3ec !important;
    z-index: 1 !important;
    transition: all .3s ease !important;
    padding-left: 6px !important;
    padding-right: 8px !important;
}
.utouch-icon {
    transition: all .3s ease !important;
    width: 32px !important;
}
.with-icon input:focus + .utouch-icon, .with-icon textarea:focus + .utouch-icon, .with-icon select:focus + .utouch-icon {
    color: #0083ff !important;
}
textarea {
    height: 120px !important;
    border-radius: 30px !important;
}
.window-popup, .window-popup2 {
    opacity: 0;
    visibility: hidden;
    background-color: #66b5ff;
    position: fixed;
    top: 0;
    width: calc(100% + 20px);
    height: 100%;
    -webkit-transition: opacity .5s ease, -webkit-transform .5s ease, scale .6s ease;
    transition: opacity .5s ease, -webkit-transform .5s ease, scale .6s ease;
    -o-transition: opacity .5s ease, transform .5s ease, scale .6s ease;
    transition: opacity .0s ease, transform .5s ease, -webkit-transform .5s ease, scale .6s ease;
    -webkit-transform: scale(0);
    -ms-transform: scale(0);
    transform: scale(0);
    z-index: 50;
    right: -17px;
}
.window-popup.open, .window-popup2.open2 {
    opacity: 1;
    z-index: 999999;
    visibility: visible;
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
    overflow: auto;
    background-color: #1e242c;
}
.popup-close, .popup-close2 {
    border-radius: 0 0 0 30px;
    background-color: #131a22;
    width: 80px;
    height: 80px;
    font-size: 40px;
    text-align: center;
    line-height: 80px;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 99999;
    transition: all .0s ease;
}
.sc_remove::-webkit-scrollbar { width: 0 !important }
.sc_remove { -ms-overflow-style: none; overflow: hidden; overflow: -moz-scrollbars-none; }
/*Modal css ends */



/* make keyframes that tell the start state and the end state of our object */
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

.fade-in {
  opacity:0;  /* make things invisible upon start */
  -webkit-animation:fadeIn ease-in 1;  /* call our keyframe named fadeIn, use animattion ease-in and repeat it only 1 time */
  -moz-animation:fadeIn ease-in 1;
  animation:fadeIn ease-in 1;

  -webkit-animation-fill-mode:forwards;  /* this makes sure that after animation is done we remain at the last keyframe value (opacity: 1)*/
  -moz-animation-fill-mode:forwards;
  animation-fill-mode:forwards;

  -webkit-animation-duration:1s;
  -moz-animation-duration:1s;
  animation-duration:1s;
}

.fade-in.one {
  -webkit-animation-delay: 0.9s;
  -moz-animation-delay: 0.9s;
  animation-delay: 0.9s;
}

.fade-in.two {
  -webkit-animation-delay: 1.5s;
  -moz-animation-delay:1.5s;
  animation-delay: 1.5s;
}

.fade-in.three {
  -webkit-animation-delay: 2.0s;
  -moz-animation-delay: 2.0s;
  animation-delay: 2.0s;
}

.fade-in.four {
  -webkit-animation-delay: 2.4s;
  -moz-animation-delay: 2.4s;
  animation-delay: 2.4s;
}

/*---make a basic box ---*/

/*companies section css*/
.companies{
    margin-top:20px;
    position:relative;
    padding:0 0 105px 0;
}
.com-grid{
    text-transform:capitalize;
    min-height:400px;
    position:relative;
}
.com-logo{
    width:100px;
    height:100px;
    background:#fff;
    border-radius:50%;
    box-shadow: 8px 13px 30px 5px rgba(162, 153, 153, 0.3);
    padding: 18px !important; 
    line-height: 0px;
}
.com-name{ 
    padding-top:8px;
    font-size:15px;
    display:none;
    line-height:20px;
    max-width:109px;
    font-weight:bold;
    text-align:center;
    color:#00a0e3;
}
.com-logo:hover ~ .com-name{
    display:block;
}
.com-logo img{
    max-width:100%;
    max-height:100%;
    position: relative;
    top:50%;
    left:50%;
    -webkit-transform: translate(-50%, -50%); 
    transform: translate(-50%, -50%); 
}
.com1, .com2, .com3, .com4, .com5, .com6, .com7, .com8, .com9, .com10, .com11{
      position:absolute;
}
.com1{
   top: -23px;
    left: 51%;
}
.com5{
    top: 1%;
    left: 84%;;
}
.com2{
   top: 31%;
    left: 40%;
}
.com3{
    top:21%;
    left:65%;
}
.com4{
   top: 42%;
    left: 81%;
}
.com6{
    top: 55%;
    left: 18%;
} 
.com7{
    top: 55%;
    left: 24%;
}
.com8{
   top: 63%;
   left: 51%;
}
.com9{
    top: 83%;
    left: 69%;
}
.com10{
    top: 78%;
    left: 90%;
}
.com11{
    top: 84%;
    left: 32%;
}
/*companies css ends*/
/*slider main css starts*/
.block.no-padding {
    padding-top: 0;
    padding-bottom: 0;
}

.block {
//    float: left;
    padding: 60px 0;
    position: relative;
    width: 100%;
    z-index: 1;
}
.block .container {
    padding: 0;
}
.chosen-container-single .chosen-single div::before, .chosen-container .chosen-results li.highlighted {
    color: #fb236a;
}
.container.fluid {
    max-width: 100%;
    width: 100%;
}
.main-featured-sec {
    float: left;
    width: 100%;
    z-index: 1;
}
.main-slider-sec {
    float: left;
    width: 100%;
    position: relative;
    z-index: 0;
    margin: 0;
    background: #141f72;
}
.slick-slider {
    position: relative;
    display: block;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-touch-callout: none;
    -khtml-user-select: none;
    -ms-touch-action: pan-y;
    touch-action: pan-y;
    -webkit-tap-highlight-color: transparent;
}
.main-slider-sec::before {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    content: "";
    z-index: 1;
    background: rgb(139,145,221);
    background: -moz-linear-gradient(45deg, rgba(139,145,221,1) 0%, rgba(16,25,93,1) 71%, rgba(16,25,93,1) 100%);
    background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,rgba(139,145,221,1)), color-stop(71%,rgba(16,25,93,1)), color-stop(100%,rgba(16,25,93,1)));
    background: -webkit-linear-gradient(45deg, rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
    background: -o-linear-gradient(45deg, rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
    background: -ms-linear-gradient(45deg, rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
    background: linear-gradient(45deg, rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#8b91dd\', endColorstr=\'#10195d\',GradientType=1 );
    opacity: 0.8;
}
.main-slider-sec.style2::before {
    background: #16192c;
}
.slick-prev, .slick-next {
    background: none;
    border: none;
    color: transparent;
    cursor: pointer;
    display: block;
    font-size: 0;
    height: 40px;
    line-height: 0;
    margin-top: 0;
    outline: medium none;
    padding: 0;
    position: absolute;
    top: 50%;
    width: 100px;
    margin: 0 40px;
    z-index: 11;
    text-align: center;
}
.slick-prev {
    left: -25px;
}
.slick-prev::before, .slick-next::before {
    color: #ffffff;
    font-family: "lineawesome";
    font-size: 30px;
    left: 0;
    line-height: 1;
    opacity: 0.75;
    position: absolute;
    top: 9px;
    width: 100%;
}
.slick-prev::before {
    content: "\f120";
}
.slick-list {
    position: relative;
    display: block;
    overflow: hidden;
    margin: 0;
    padding: 0;
}
.slick-slider .slick-track, .slick-slider .slick-list {
    -webkit-transform: translate3d(0, 0, 0);
    -moz-transform: translate3d(0, 0, 0);
    -ms-transform: translate3d(0, 0, 0);
    -o-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
.slick-track {
    position: relative;
    top: 0;
    left: 0;
    display: block;
}
.slick-slider .slick-track, .slick-slider .slick-list {
    -webkit-transform: translate3d(0, 0, 0);
    -moz-transform: translate3d(0, 0, 0);
    -ms-transform: translate3d(0, 0, 0);
    -o-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
}
.slick-initialized .slick-slide {
    display: block;
}
.main-slider-sec li {
    margin: 0;
}
.search-job2 form .row > div {
    padding: 0;
}
.slideHome {
    height: 700px !important;
}
.slick-slide {
    display: none;
    float: left;
    height: 100%;
    min-height: 1px;
}
.slideHome {
    color: #1e1e1e;
    margin-bottom: 15px;
    position: relative;
}
.main-slider-sec img {
    float: left;
    width: 100%;
    opacity: 0.8;
    height:100%;
}

.slick-slide img {
    display: block;
}
.slick-track:after {
    clear: both;
}

.slick-track:before, .slick-track:after {
    display: table;
    content: "";
}
.slick-next {
    right: -25px;
}
.slick-next:before {
    content: "\f121";
}
.job-search-sec {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 1000px;
    content: "";
    -webkit-transform: translateY(-50%) translateX(-50%);
    -moz-transform: translateY(-50%) translateX(-50%);
    -ms-transform: translateY(-50%) translateX(-50%);
    -o-transform: translateY(-50%) translateX(-50%);
    transform: translateY(-50%) translateX(-50%);
    margin-top: 0px;
}
.job-search {
    float: left;
    width: 100%;
    padding: 0;
    margin-bottom: 50px;
}
.job-search-sec .job-search > h3 {
    font-weight: normal;
}
.job-search > h3 {
    float: left;
    width: 100%;
    font-family: Quicksand;
    font-size: 50px;
    font-weight: normal;
    color: #ffffff;
    letter-spacing: 0px;
    text-align: center;
    line-height: 39px;
    margin-bottom: 13px;
}
.job-search-sec .job-search.style2 > span {
    opacity: 1;
}
.job-search > span {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    font-weight: 400;
    color: #d5d8f3;
    text-align: center;
    margin-top: 10px;
}
.search-job2 {
    float: left;
    width: 100%;
    background: rgba(255,255,255,0.3);
    -webkit-border-radius: 60px;
    -moz-border-radius: 60px;
    -ms-border-radius: 60px;
    -o-border-radius: 60px;
    border-radius: 60px;
    margin-top: 50px;
    padding: 9px;
}
.search-job2 form {
    margin: 0 !important;
    background: #ffffff;
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    -ms-border-radius: 50px;
    -o-border-radius: 50px;
    border-radius: 50px;
}
.job-search form {
    float: left;
    width: 100%;
    margin-top: 40px;
}
.job-search form .row {
    margin: 0 -12px;
}
.search-job2 form .row {
    margin: 0;
}
.job-field {
    float: left;
    width: 100%;
    position: relative;
}
.search-job2 .job-field::before {
    position: absolute;
    right: 0;
    top: 17px;
    width: 1px;
    height: 30px;
    background: #e8ecec;
    content: "";
    z-index: 1;
}
.search-job2 form .row > div:first-child .job-field input {
    -webkit-border-radius: 40px 0px 0px 40px;
    -moz-border-radius: 40px 0px 0px 40px;
    -ms-border-radius: 40px 0px 0px 40px;
    -o-border-radius: 40px 0px 0px 40px;
    border-radius: 40px 0px 0px 40px;
}
.job-field input {
    float: left;
    width: 100%;
    background: no-repeat;
    border: none;
    font-size: 13px;
    color: #888888;
    margin: 0;
    padding: 0 70px 0 30px;
    height: 61px;
    line-height: 61px;
    background-color: #FFF;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
}
.job-field .chosen-container {
    border: none !important;
}
.chosen-container *{
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.search-job2 form button {
    font-size: 15px;
    font-weight: bold;
    background: #d42525;
    padding: 20px 0px;
    width: 100%;
    border:0px;
    color:#fff;
    height:61px;
    font-family: Open Sans;
}
.job-field .chosen-container-single .chosen-single {
    padding: 19px 30px 18px 30px;
}
.search-job2 form .row > div:last-child button {
    -webkit-border-radius: 0px 40px 40px 0px;
    -moz-border-radius: 0px 40px 40px 0px;
    -ms-border-radius: 0px 40px 40px 0px;
    -o-border-radius: 0px 40px 40px 0px;
    border-radius: 0px 40px 40px 0px;
}
.job-search form button:hover {
    background: #fb236a;
}
.chosen-container {
  position: relative;
  display: inline-block;
  vertical-align: middle;
  font-size: 13px;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  float: left;
  width: 100% !important;
  text-align: left;
  border-radius: 8px;
  box-shadow: none !important;
  border: 2px solid #e8ecec;
}

.chosen-container * {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

.chosen-container .chosen-drop {
  position: absolute;
  top: 100%;
  z-index: 1010;
  width: 100%;
  border-top: 0;
  background: #f4f5fa;
  box-shadow: none;
  clip: rect(0, 0, 0, 0);
  float: left;
  width: 100%;
}

.chosen-container.chosen-with-drop .chosen-drop {
  clip: auto;
}
.chosen-container.chosen-container-single.chosen-container-single-nosearch.chosen-with-drop.chosen-container-active {
    /*! background: none; */
}
.chosen-container.chosen-container-single.chosen-container-single-nosearch.chosen-with-drop.chosen-container-active > a {
    background: #ffffff;
    border: none !important;
    box-shadow: none !important;
    border-radius: inherit !important;
}
.chosen-container a {
  cursor: pointer;
}

.chosen-container .search-choice .group-name, .chosen-container .chosen-single .group-name {
  margin-right: 4px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  font-weight: normal;
  color: #999999;
}

.chosen-container .search-choice .group-name:after, .chosen-container .chosen-single .group-name:after {
  content: ":";
  padding-left: 2px;
  vertical-align: top;
}

/* @end */
/* @group Single Chosen */
.chosen-container-single .chosen-single {
  position: relative;
  display: block;
  overflow: hidden;
  padding: 0 0 0 8px;
  height: 25px;
  border-radius: 8px;
  background-color: #fff;
  color: #888888;
  text-decoration: none;
  white-space: nowrap;
  line-height: 24px;
  float: left;
  width: 100%;
  text-align: left;
  padding: 0;
  padding: 14px 45px 14px 15px;
  height: auto;
}

.chosen-container-single .chosen-default {
  color: #999;
}

.chosen-container-single .chosen-single span {
  display: block;
  overflow: hidden;
  margin-right: 26px;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.chosen-container-single .chosen-single-with-deselect span {
  margin-right: 38px;
}

.chosen-container-single .chosen-single abbr {
  position: absolute;
  top: 6px;
  right: 26px;
  display: block;
  width: 12px;
  height: 12px;
  font-size: 1px;
}
.chosen-container-single .chosen-single div::before {
    position: absolute;
    font-family: fontawesome;
    font-size: 13px;
    content: "\f107";
    font-size: 13px;
    right: 22px;
    top: 50%;
    margin-top: -13px;
}
.chosen-container-single .chosen-single abbr:hover {
  background-position: -42px -10px;
}

.chosen-container-single.chosen-disabled .chosen-single abbr:hover {
  background-position: -42px -10px;
}

.chosen-container-single .chosen-single div {
  position: absolute;
  top: 0;
  right: 0;
  display: block;
  width: 18px;
  height: 100%;
}

.chosen-container-single .chosen-single div b {
  display: block;
  width: 100%;
  height: 100%;
//  background: url("chosen-sprite.png") no-repeat 0px 2px;
}

.chosen-container-single .chosen-search {
  position: relative;
  z-index: 1010;
  margin: 0;
  padding: 3px 4px;
  white-space: nowrap;
  float: left;
  width: 100%;
}

.chosen-container-single .chosen-search input[type="text"] {
  margin: 1px 0;
  padding: 4px 20px 4px 5px;
  width: 100%;
  height: auto;
  outline: 0;
  border: 1px solid #aaa;
//  background: url("chosen-sprite.png") no-repeat 100% -20px;
  font-size: 1em;
  font-family: sans-serif;
  line-height: normal;
  border-radius: 0;
}

.chosen-container-single .chosen-drop {
  margin-top: 5px;
  border-radius: 8px;
  background-clip: padding-box;
}

.chosen-container-single.chosen-container-single-nosearch .chosen-search {
  position: absolute;
  clip: rect(0, 0, 0, 0);
}

/* @end */
/* @group Results */
.chosen-container .chosen-results {
  color: #444;
  position: relative;
  overflow-x: hidden;
  overflow-y: auto;
  margin: 0 4px 4px 0;
  padding: 0 0 0 4px;
  max-height: 240px;
  -webkit-overflow-scrolling: touch;
  float: left;
  width: 100%;
  padding: 0 6px;
  margin: 10px 0;
}

.chosen-container .chosen-results li {
  display: none;
  margin: 0;
  padding: 10px;
  list-style: none;
  line-height: 15px;
  word-wrap: break-word;
  -webkit-touch-callout: none;
  float: left;
  width: 100%;
  font-family: Open Sans;
  font-size: 13px;
  color: #a7a7a7;
}

.chosen-container .chosen-results li.active-result {
  display: list-item;
  cursor: pointer;
}

.chosen-container .chosen-results li.disabled-result {
  display: list-item;
  color: #ccc;
  cursor: default;
}

.chosen-container .chosen-results li.highlighted {
  padding-left: 15px;
}

.chosen-container .chosen-results li.no-results {
  color: #777;
  display: list-item;
  background: #f4f4f4;
}

.chosen-container .chosen-results li.group-result {
  display: list-item;
  font-weight: bold;
  cursor: default;
}

.chosen-container .chosen-results li.group-option {
  padding-left: 15px;
}

.chosen-container .chosen-results li em {
  font-style: normal;
  text-decoration: underline;
}

/* @end */
/* @group Multi Chosen */
.chosen-container-multi .chosen-choices {
  position: relative;
  overflow: hidden;
  margin: 0;
  padding: 0 5px;
  width: 100%;
  height: auto;
  border: 1px solid #aaa;
  background-color: #fff;
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(1%, #eee), color-stop(15%, #fff));
  background-image: linear-gradient(#eee 1%, #fff 15%);
  cursor: text;
}

.chosen-container-multi .chosen-choices li {
  float: left;
  list-style: none;
}

.chosen-container-multi .chosen-choices li.search-field {
  margin: 0;
  padding: 0;
  white-space: nowrap;
}

.chosen-container-multi .chosen-choices li.search-field input[type="text"] {
  margin: 1px 0;
  padding: 0;
  height: 25px;
  outline: 0;
  border: 0 !important;
  background: transparent !important;
  -webkit-box-shadow: none;
          box-shadow: none;
  color: #999;
  font-size: 100%;
  font-family: sans-serif;
  line-height: normal;
  border-radius: 0;
  width: 25px;
}

.chosen-container-multi .chosen-choices li.search-choice {
  position: relative;
  margin: 3px 5px 3px 0;
  padding: 3px 20px 3px 5px;
  border: 1px solid #aaa;
  max-width: 100%;
  border-radius: 3px;
  background-color: #eeeeee;
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), to(#eee));
  background-image: linear-gradient(#f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%);
  background-size: 100% 19px;
  background-repeat: repeat-x;
  background-clip: padding-box;
  -webkit-box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05);
          box-shadow: 0 0 2px #fff inset, 0 1px 0 rgba(0, 0, 0, 0.05);
  color: #333;
  line-height: 13px;
  cursor: default;
}

.chosen-container-multi .chosen-choices li.search-choice span {
  word-wrap: break-word;
}

.chosen-container-multi .chosen-choices li.search-choice .search-choice-close {
  position: absolute;
  top: 4px;
  right: 3px;
  display: block;
  width: 12px;
  height: 12px;
//  background: url("chosen-sprite.png") -42px 1px no-repeat;
  font-size: 1px;
}

.chosen-container-multi .chosen-choices li.search-choice .search-choice-close:hover {
  background-position: -42px -10px;
}

.chosen-container-multi .chosen-choices li.search-choice-disabled {
  padding-right: 5px;
  border: 1px solid #ccc;
  background-color: #e4e4e4;
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(20%, #f4f4f4), color-stop(50%, #f0f0f0), color-stop(52%, #e8e8e8), to(#eee));
  background-image: linear-gradient(#f4f4f4 20%, #f0f0f0 50%, #e8e8e8 52%, #eee 100%);
  color: #666;
}

.chosen-container-multi .chosen-choices li.search-choice-focus {
  background: #d4d4d4;
}

.chosen-container-multi .chosen-choices li.search-choice-focus .search-choice-close {
  background-position: -42px -10px;
}

.chosen-container-multi .chosen-results {
  margin: 0;
  padding: 0;
}

.chosen-container-multi .chosen-drop .result-selected {
  display: list-item;
  color: #ccc;
  cursor: default;
}

/* @end */
/* @group Active  */
.chosen-container-active .chosen-single {
}

.chosen-container-active.chosen-with-drop .chosen-single {
  border: 1px solid #aaa;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(20%, #eee), color-stop(80%, #fff));
  background-image: linear-gradient(#eee 20%, #fff 80%);
  -webkit-box-shadow: 0 1px 0 #fff inset;
          box-shadow: 0 1px 0 #fff inset;
}

.chosen-container-active.chosen-with-drop .chosen-single div {
  border-left: none;
  background: transparent;
}

.chosen-container-active.chosen-with-drop .chosen-single div b {
  background-position: -18px 2px;
}

.chosen-container-active .chosen-choices {
  border: 1px solid #5897fb;
  -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
          box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
}

.chosen-container-active .chosen-choices li.search-field input[type="text"] {
  color: #222 !important;
}

/* @end */
/* @group Disabled Support */
.chosen-disabled {
  opacity: 0.5 !important;
  cursor: default;
}

.chosen-disabled .chosen-single {
  cursor: default;
}

.chosen-disabled .chosen-choices .search-choice .search-choice-close {
  cursor: default;
}

/* @end */
/* @group Right to Left */
.chosen-rtl {
  text-align: right;
}

.chosen-rtl .chosen-single {
  overflow: visible;
  padding: 0 8px 0 0;
}

.chosen-rtl .chosen-single span {
  margin-right: 0;
  margin-left: 26px;
  direction: rtl;
}

.chosen-rtl .chosen-single-with-deselect span {
  margin-left: 38px;
}

.chosen-rtl .chosen-single div {
  right: auto;
  left: 3px;
}

.chosen-rtl .chosen-single abbr {
  right: auto;
  left: 26px;
}

.chosen-rtl .chosen-choices li {
  float: right;
}

.chosen-rtl .chosen-choices li.search-field input[type="text"] {
  direction: rtl;
}

.chosen-rtl .chosen-choices li.search-choice {
  margin: 3px 5px 3px 0;
  padding: 3px 5px 3px 19px;
}

.chosen-rtl .chosen-choices li.search-choice .search-choice-close {
  right: auto;
  left: 4px;
}

.chosen-rtl.chosen-container-single .chosen-results {
  margin: 0 0 4px 4px;
  padding: 0 4px 0 0;
}

.chosen-rtl .chosen-results li.group-option {
  padding-right: 15px;
  padding-left: 0;
}

.chosen-rtl.chosen-container-active.chosen-with-drop .chosen-single div {
  border-right: none;
}

.chosen-rtl .chosen-search input[type="text"] {
  padding: 4px 5px 4px 20px;
//  background: url("chosen-sprite.png") no-repeat -30px -20px;
  direction: rtl;
}

.chosen-rtl.chosen-container-single .chosen-single div b {
  background-position: 6px 2px;
}

.chosen-rtl.chosen-container-single.chosen-with-drop .chosen-single div b {
  background-position: -12px 2px;
}

/* @end */
/* @group Retina compatibility */
@media only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min-resolution: 144dpi), only screen and (min-resolution: 1.5dppx) {
  .chosen-rtl .chosen-search input[type="text"],
  .chosen-container-single .chosen-single abbr,
  .chosen-container-single .chosen-single div b,
  .chosen-container-single .chosen-search input[type="text"],
  .chosen-container-multi .chosen-choices .search-choice .search-choice-close,
  .chosen-container .chosen-results-scroll-down span,
  .chosen-container .chosen-results-scroll-up span {
//    background-image: url("chosen-sprite@2x.png") !important;
    background-size: 52px 37px !important;
    background-repeat: no-repeat !important;
  }
}
/*slider main css ends*/

');
$script = <<< JS
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
  if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
    document.getElementById("myBttn").style.display = "block";
  } else {
    document.getElementById("myBttn").style.display = "none";
  }
}

$(document).on('click', '.feed-open', function(){
   $('.window-popup').addClass('open') ;
   $('body').toggleClass('sc_remove') ;
});
$(document).on('click', '.popup-close', function(e){
    e.preventDefault();
   $('.window-popup').removeClass('open') ;
   $('body').toggleClass('sc_remove') ;
});
$(document).on('click', '.feed-open2', function(){
   $('.window-popup2').addClass('open2') ;
   $('body').toggleClass('sc_remove') ;
});
$(document).on('click', '.popup-close2', function(e){
    e.preventDefault();
   $('.window-popup2').removeClass('open2') ;
   $('body').toggleClass('sc_remove') ;
});
        
$(document).on('submit', '#feedback-form', function(event) {
    event.preventDefault();
    var form_method = $(this).attr('method');
    var form_url = $(this).attr('action');
    var form_data = $(this).serialize();
    var before = function(){     
        $('.loader-aj-main').fadeIn(1000);  
    };
    var req = function(){
        var result = ajax(form_method, form_url, form_data);
        var resp = result["responseJSON"];
        $('.loader-aj-main').fadeOut(1000);
        if(resp.status == 200){
            toastr.success(resp.message, resp.title);
            $("#feedback-form")[0].reset();
            $(".popup-close").trigger("click");
        }else{
            toastr.error(resp.message, resp.title);
        }
    }
    order(before, req);
});
        
function order(before, req){
    before();
    req();
}
        
$(document).on('submit', '#partner-with-us-form', function(event) {
    event.preventDefault();
    var form_method = $(this).attr('method');
    var form_url = $(this).attr('action');
    var form_data = $(this).serialize();
    var before = function(){     
        $('.loader-aj-main').fadeIn(1000);  
    };
    var req = function(){
        var result = ajax(form_method, form_url, form_data);
        var resp = result["responseJSON"];
        $('.loader-aj-main').fadeOut(1000);
        if(resp.status == 200){
            toastr.success(resp.message, resp.title);
            $("#partner-with-us-form")[0].reset();
            $(".popup-close2").trigger("click");
        }else{
            toastr.error(resp.message, resp.title);
        }
    }
    order(before, req);
});
        
  jQuery(function($) {
  var doAnimations = function() {
    var offset = $(window).scrollTop() + $(window).height(), animatables = $('.animatable');
    if (animatables.length == 0) {
      $(window).off('scroll', doAnimations);
    }
		animatables.each(function(i) {
       var animatable = $(this);
			if ((animatable.offset().top + animatable.height() - 20) < offset) {
        animatable.removeClass('animatable').addClass('animated');
	}
      });
    };
    $(window).on('scroll', doAnimations);
  $(window).trigger('scroll'); 
  
  // var sequenceElement = document.getElementById("sequence");
  //
  //   var options = {
  //       autoPlay: true,
  //       autoPlayInterval: 3000,
  //       phaseThreshold: false,
  //       preloader: true,
  //       reverseWhenNavigatingBackwards: true
  //   }
  //  
  //   var mySequence = sequence(sequenceElement, options);
  $('.main-slider-sec').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  autoplay: true,
	  slide: 'li',
	  fade: false,
	  infinite: true,
	  dots: false
	});
});

JS;
$this->registerJs($script);
//$this->registerCssFile('http://demo.sequencejs.com/modern-slide-in/css/sequence-theme.modern-slide-in.css');
$this->registerCssFile('@eyAssets/css/sequence-theme.modern-slide-in.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
//$this->registerCssFile('//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
//$this->registerJsFile('http://demo.sequencejs.com/modern-slide-in/scripts/hammer.min.js');
//$this->registerJsFile('@eyAssets/js/sequence.min.js');
//$this->registerJsFile('http://demo.sequencejs.com/modern-slide-in/scripts/scripts.min.js');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/select-chosen.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/slick.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
?>
