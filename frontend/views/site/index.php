<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['header_dark'] = false;
?>
<section class="slider">
    <div id="sequence" class="seq">

        <div class="seq-screen">
            <ul class="seq-canvas">
                <li class="seq-in step1">
                    <div class="seq-model">
<!--                        <img data-seq src="--><?//= Url::to('@eyAssets/images/pages/index2/jobs_banner.png') ?><!--" class="img-responsive" alt="A" />-->
                    </div>

                    <div class="seq-title">
                        <h2 data-seq>Internships</h2>
                        <h3 data-seq>EmpowerYouth makes it easy for you to find internships</h3>
                    </div>
                </li>

                <li class="step2">
                    <div class="seq-model">
<!--                        <img data-seq src="--><?//= Url::to('@eyAssets/images/pages/index2/youth-development.png') ?><!--" class="img-responsive" alt="A" />-->
                    </div>

                    <div class="seq-title">
                        <h2 data-seq>Career Development</h2>
                        <h3 data-seq>EmpowerYouth main motive is the development of youth<br> in every aspect possible </h3>
                    </div>
                </li>

                <li class="step3">
                    <div class="seq-model">
<!--                        <img data-seq src="--><?//= Url::to('@eyAssets/images/pages/index2/job-search.png') ?><!--" alt="" />-->
                    </div>

                    <div class="seq-title">
                        <h2 data-seq>Job Search</h2>
                        <h3 data-seq>EmpowerYouth makes it easy for you to search your dream job </h3>
                    </div>
                </li>
            </ul>
        </div>

        <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
            <button type="button" class="seq-prev" aria-label="Previous">Previous</button>
            <button type="button" class="seq-next" aria-label="Next">Next</button>
        </fieldset>
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
                        <div class="icon"><img src="<?= Url::to('@eyAssets/images/pages/index2/universities.svg') ?>"></div>
                        <div class="h-heading">Universities & Colleges</div>
                        <div class="h-text">Search or let universities find you</div>
                    </div>
                    <div class="overlay">
                        <div class="text">Coming Soon</div>
                    </div>
                </div>              
                <div class="box-border fade-in four">
                    <div class="box-overlay">
                    <div class="icon"><img src="<?= Url::to('@eyAssets/images/pages/index2/consultants.svg') ?>"></div>
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
                        <div class="how-text">Create a profile with your past education and experience details, add goals and preferences to let people know you better.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row steps-row"> 
            <div class="col-md-10 col-md-offset-1">
                <div class="col-md-7 col-sm-7">
                    <div class="how-text-box">
                        <div class="how-heading">Skill Enhancement</div>
                        <div class="how-text">Browse our portal, check out the services that we offer and find the service that you are looking for.</div>
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
                        <div class="how-text">Once you have found the service that you desire than why wait avail it right away</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--how it works ends-->
<!--new section starts-->
<section class="background-image">
    <div class="container">
    <div class="row">
        <div class="col-xs-3">
            <ul class="nav nav-tabs tabs-left sideways pt-15">
                <li class="active"><a href="#home-v" data-toggle="tab"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="#profile-v" data-toggle="tab"><i class="fa fa-user"></i> Profile</a></li>
                <li><a href="#messages-v" data-toggle="tab"><i class="fa fa-envelope"></i> Messages</a></li>
                <li><a href="#settings-v" data-toggle="tab"><i class="fa fa-cog"></i> Settings</a></li>
            </ul>
        </div>

        <div class="col-xs-8">
            <!-- Tab panes -->
            <div class="tab-content tab-content-main">
                <div class="tab-pane active" id="home-v">
                    <div class="row">
                        <div class="col-xs-5 padding-0">
                            <img class="img-responsive" alt="200x200" src="https://resizing.flixster.com/2nm9DeqzcjkvO5AAu3RdVZdxqOg=/581x518/v1.cjs0MzIzNTtqOzE3OTEwOzEyMDA7NTgxOzUxOA" />
                            <div class="image-description">
                                <h4>Want to be part of team.</h4> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <ul class="nav nav-tabs inner-nav-ul">
                                <div class="tab-slider"></div>
                                <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                                <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
                                <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
                            </ul>
                            <div class="tab-content inner-nav">
                                <div id="home" class="tab-pane fade in active">
                                    <h3>Lorem ipsum dolor</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <br/>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                                <div id="menu1" class="tab-pane fade">
                                    <h3>Menu 1</h3>
                                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>
                                <div id="menu2" class="tab-pane fade">
                                    <h3>Menu 2</h3>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="profile-v">
                    <div class="row">
                        <div class="col-xs-5 padding-0">
                            <img class="img-responsive" alt="200x200" src="http://keenthemes.com/preview/metronic/theme/assets/pages/media/profile/profile_user.jpg">
                            <div class="image-description">
                                <h4>Want to be part of team.</h4> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <ul class="nav nav-tabs inner-nav-ul">
                                <div class="tab-slider"></div>
                                <li class="active"><a data-toggle="tab" href="#home2">Home</a></li>
                                <li><a data-toggle="tab" href="#menu21">Menu 1</a></li>
                                <li><a data-toggle="tab" href="#menu22">Menu 2</a></li>
                            </ul>
                            <div class="tab-content inner-nav">
                                <div id="home2" class="tab-pane fade in active">
                                    <h3>Lorem ipsum dolor</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <br/>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                                <div id="menu21" class="tab-pane fade">
                                    <h3>Menu 1</h3>
                                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>
                                <div id="menu22" class="tab-pane fade">
                                    <h3>Menu 2</h3>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="messages-v">
                    <div class="row">
                        <div class="col-xs-5 padding-0">
                            <img class="img-responsive" alt="200x200" src="https://resizing.flixster.com/2nm9DeqzcjkvO5AAu3RdVZdxqOg=/581x518/v1.cjs0MzIzNTtqOzE3OTEwOzEyMDA7NTgxOzUxOA" />
                            <div class="image-description">
                                <h4>Want to be part of team.</h4> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <ul class="nav nav-tabs inner-nav-ul">
                                <div class="tab-slider"></div>
                                <li class="active"><a data-toggle="tab" href="#home3">Home</a></li>
                                <li><a data-toggle="tab" href="#menu31">Menu 1</a></li>
                                <li><a data-toggle="tab" href="#menu32">Menu 2</a></li>
                            </ul>
                            <div class="tab-content inner-nav">
                                <div id="home3" class="tab-pane fade in active">
                                    <h3>Lorem ipsum dolor</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <br/>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                                <div id="menu31" class="tab-pane fade">
                                    <h3>Menu 1</h3>
                                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>
                                <div id="menu32" class="tab-pane fade">
                                    <h3>Menu 2</h3>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="settings-v">
                    <div class="row">
                        <div class="col-xs-5 padding-0">
                            <img class="img-responsive" alt="200x200" src="https://via.placeholder.com/350x280?text=Visit+Blogging.com+Now">
                            <div class="image-description">
                                <h4>Want to be part of team.</h4> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </div>
                        </div>
                        <div class="col-xs-7">
                            <ul class="nav nav-tabs inner-nav-ul">
                                <div class="tab-slider"></div>
                                <li class="active"><a data-toggle="tab" href="#home4">Home</a></li>
                                <li><a data-toggle="tab" href="#menu41">Menu 1</a></li>
                                <li><a data-toggle="tab" href="#menu42">Menu 2</a></li>
                            </ul>
                            <div class="tab-content inner-nav">
                                <div id="home4" class="tab-pane fade in active">
                                    <h3>Lorem ipsum dolor</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    <br/>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                </div>
                                <div id="menu41" class="tab-pane fade">
                                    <h3>Menu 1</h3>
                                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                </div>
                                <div id="menu42" class="tab-pane fade">
                                    <h3>Menu 2</h3>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
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
                    <div class="partner-btn"><button type='button' class="feed-open2">Partner with Us</button></div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="partner-btn"><button type="button" class="feed-open">Give us Feedback</button></div>
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


<?php
$this->registerCss('
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
/*header section*/
.seq{
    max-width: 100% !important;
}
#sequence .step1, #sequence .step2, #sequence .step3  {
    background-size:100% 100% !important;
    background-repeat:no-repeat !important;
}
#sequence .step1 {
    background: url(' . Url::to('@eyAssets/images/bg/slider1.webp') . ');  
}
#sequence .step2 {
    background: url(' . Url::to('@eyAssets/images/bg/slider2.webp') . ');
}
#sequence .step3 {
    background: url(' . Url::to('@eyAssets/images/bg/slider4.webp') . ');  
}
.seq .seq-canvas, .seq .seq-nav{
    max-width: 100%;
}
.header-boxs{
    display: flex;
    justify-content: center;
}
.seq .seq-next {
    right: 20px;
    background: url(' . Url::to('@eyAssets/images/pages/index2/right-arrow.png') . ');
    background-repeat:no-repeat;
    background-size:contain;
}
.seq .seq-prev {
    left: 20px;
    background: url(' . Url::to('@eyAssets/images/pages/index2/left-arrow.png') . ');
    background-repeat:no-repeat;
    background-size:contain;
}

.header-row{
    margin-top: -90px;
    padding: 0 0 20px 0;
    position: relative;
    z-index: 9;
}
.h-heading{
    font-weight: bold;
    color: #000;
    padding-top: 15px;
    font-size: 16px;
}
.seq .seq-model{
    height:50% !important;
}
.icon img{
    height:100px;
    width:100px;
}
/*header section ends*/

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
/*partner with us*/
.partner{
    padding:0px 0 80px 0;
    text-align:center;
}
.partner-btn button{
    border: 2px solid #dbd7d7;
    border-width: 2px 12px;
    padding: 14px 59px;
    background: #ffffff !important;
    color: #dbd7d7;
    text-transform: uppercase;
    border-radius: 9px 50px;
    transition:.6s all;
    -webkit-transition:.6s all;
    -moz-transition:.6s all;
    -o-transition:.6s all;
}
.partner-btn button:hover{
    border:2px solid #00a0e3;
    border-width: 2px 12px;
    background: #00a0e3 !important;
    color: #fff;
    transition:.6s all;
    -webkit-transition:.6s all;
    -moz-transition:.6s all;
    -o-transition:.6s all;
}
.partner-row{
    padding:30px 0 0 0; 
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
input, textarea{
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
input:focus, textarea:focus{
    -webkit-box-shadow: 5px 0 40px 0 rgba(0, 88, 171, 0.25) !important;
    box-shadow: 5px 0 40px 0 rgba(0, 88, 171, 0.25) !important;
    color: #0083ff !important;
}
:focus {
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
.seq .seq-nav{
    z-index:999;
}


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

/*---new Section css ends ---*/
.background-image{
  background:url("https://c1.staticflickr.com/9/8711/17095171331_4ec22e0407_b.jpg");
  background-size:100% 100%;
  overflow: hidden;
}
.tabs-left li a i{
    font-size: 15px;
    display: inline-block;
    margin: 4px;
    margin-top: 0px;
}
.tabs-left {
  border-bottom: none;
/*   border-right: 1px solid #ddd; */
}
.inner-nav-ul{
  background-color:#fff;
  position:relative;
}
//.inner-nav-ul li {
//    border-bottom: 3px solid transparent !important;
//}
//.inner-nav-ul li.active {
//    border-bottom: 3px solid #00a0e3 !important;
//}
.inner-nav-ul li a{
  border-radius:0px;
  color:#696969;
}
.inner-nav-ul li.active a{
  color:#00a0e3;
}
.inner-nav{
    padding:20px;
      background-color: #fff;
  min-height:390px;
}
.image-description{
  background-color:#fff;
  padding:25px;
  padding-top: 15px;
}
.inner-nav h3{
  margin-top:0px;
}
.tabs-left>li {
  float: none;
 margin:0px;
  
}
.padding-0{
  padding:0px !important;
}
.tabs-left>li>a{
  background:#222;
  color:#bdbdbd;
  border-radius:0px;
  margin-right: 0px;
  
    text-align: left;
}
.tabs-left>li.active>a,
.tabs-left>li>a:hover,
.tabs-left>li.active>a:hover,
.tabs-left>li.active:focus>a,
.tabs-left>li.active>a:focus {
  border-bottom-color: #ddd;
  border-right-color: transparent;
  background:#000 !important;
  color:#fff;
  font-weight:700;
  border:none;
  border-radius:0px;
  margin:0px;
}
.nav-tabs>li>a:hover {
    line-height: 1.42857143;
    border: 1px solid transparent;
}
.tab-pane.active {
    animation: slide-down 1s ease-out;
}

@keyframes slide-down {
    0% { opacity: 0; transform: translateY(100%); }
    100% { opacity: 1; transform: translateY(0); }
}
.tab-content-main .tab-pane{
//position:absolute;
//    margin-left: 225px;
//  -webkit-trasition: all 0.3s linear;
//  transition: all 0.3s linear;
}
//.tab-content-main .tab-pane.active{
//    margin-left: 0px;
//  transition: all 2.3s ease-in-out;
//  -webkit-transition: all 2.3s ease-in-out;
//  -ms-transition: all 2.3s ease-in-out;
//  -moz-transition: all 2.3s ease-in-out;
//  -o-transition: all 2.3s ease-in-out;
//}
.tab-slider
{
  display:inline-block;
  width:75px;
  height:4px;
  border-radius:3px;
  background-color:#00a0e3;
  position:absolute;
  z-index:1200;
  bottom:0;
  transition:all .4s linear;
  
}
/* .tabs-left>li.active>a::after{content: "";
    position: absolute;
    top: 0px;
    right: -20px;
    border-top: 20px solid transparent;
  border-bottom: 20px solid transparent;
  
  border-left: 20px solid #f90;
    display: block;
    width: 0;} */
/*---new Section css ends ---*/
');
$script = <<< JS
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
});       
  
$(".inner-nav-ul a").click(function() {
  var position = $(this).parent().position();
  var width = $(this).parent().width();
  var slider = $(this).parent().parent().find('.tab-slider');
    slider.css({"left":+ position.left,"width":width});
});
var actWidth = $(".inner-nav-ul").find(".active").parent("li").width();
var actPosition = $(".inner-nav-ul .active").position();
$(".tab-slider").css({"left":+ actPosition.left,"width": actWidth});

JS;
$this->registerJs($script);
$this->registerCssFile('http://demo.sequencejs.com/modern-slide-in/css/sequence-theme.modern-slide-in.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('http://demo.sequencejs.com/modern-slide-in/scripts/hammer.min.js');
$this->registerJsFile('@eyAssets/js/sequence.min.js');
//$this->registerJsFile('http://demo.sequencejs.com/modern-slide-in/scripts/scripts.min.js');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
?>
<script>
    $( document ).ready(function() {
    // Get the Sequence element
    var sequenceElement = document.getElementById("sequence");

    // Place your Sequence options here to override defaults
    var options = {
        autoPlay: true,
        autoPlayInterval: 3000,
        phaseThreshold: false,
        preloader: true,
        reverseWhenNavigatingBackwards: true
    }

    // Launch Sequence on the element, and with the options we specified above
    var mySequence = sequence(sequenceElement, options);

    });
</script>
