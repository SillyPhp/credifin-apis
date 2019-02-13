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
                                <h3>Discover a New Career Specially Designed For You</h3>
                                <span>The Easiest Way to Get Your New Job</span>
                                <div class="search-job2">
                                    <form id="search_jobs_internships" action="<?= Url::to('/jobs/list'); ?>">
                                        <div class="row no-gape">
                                            <div class="col-lg-7 col-md-7 col-sm-4">
                                                <div class="job-field">
                                                    <input type="text" name="keyword" placeholder="Keywords"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-2 col-sm-4">
                                                <div class="job-field">
                                                    <select data-placeholder="Any category" id="search_type" class="chosen-city">
                                                        <option value="jobs">Jobs</option>
                                                        <option value="internships">Internships</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2  col-md-3 col-sm-4">
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
                        <div class="h-heading">Recruiters</div>
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
<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="tab-sec">
                        <ul class="nav nav-tabs">
                            <li><a class="current" data-tab="fjobs">Featured Jobs</a></li>
                            <li><a data-tab="rjobs">Recent Jobs</a></li>
                        </ul>
                        <div id="fjobs" class="tab-content current">
                            <div class="job-listings-tabs">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">

                                            <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/ey.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">Web Designer / Developer</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is ft fill">Full time</span>
                                            </div>
                                        </div><!-- Job -->

                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/ey.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">C Developer (Senior) C .Net</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is pt fill">Part time</span>
                                               </div>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">Regional Sales Manager South</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is ft fill">Full time</span>
                                            </div>
                                        </div><!-- Job -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/midland.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">Marketing Dairector</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is ft fill">Full time</span>
                                              </div>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">Application Developer</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is pt fill">Part time</span>
                                            </div>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/ey.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">Social Media and Public</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is fl fill">Freelance</span>
                                                <span class="fav-job"><i class="la la-heart-o"></i></span>
                                            </div>
                                        </div><!-- Job -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="rjobs" class="tab-content">
                            <div class="job-listings-tabs">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">Marketing Dairector</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is ft fill">Full time</span>
                                                <span class="fav-job"><i class="la la-heart-o"></i></span>
                                            </div>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">Application Developer</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is pt fill">Part time</span>
                                                <span class="fav-job"><i class="la la-heart-o"></i></span>
                                            </div>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">Social Media and Public</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is fl fill">Freelance</span>
                                            </div>
                                        </div><!-- Job -->
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">Web Designer / Developer</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is ft fill">Full time</span>
                                            </div>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">C Developer (Senior) C .Net</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is pt fill">Part time</span>
                                            </div>
                                        </div><!-- Job -->
                                        <div class="job-listing wtabs">
                                            <div class="job-title-sec">
                                                <div class="c-logo">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/ey.png')?>" alt="" />
                                                </div>
                                                <h3><a href="#" title="">Regional Sales Manager South</a></h3>
                                                <span>Massimo Artemisis</span>
                                                <div class="job-lctn"><i class="fa fa-map-marker"></i>Sacramento, California</div>
                                            </div>
                                            <div class="job-style-bx">
                                                <span class="job-is ft fill">Full time</span>
                                            </div>
                                        </div><!-- Job -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="browse-all-cat">
                            <a href="#" title="" class="style2">Load more listings</a>
                        </div>
                    </div>
                </div>
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

.tab-sec {
    float: left;
    width: 100%;
    text-align: center;
}
.nav.nav-tabs {
    float: none;
    width: auto;
    text-align: center;
    margin: 0;
    display: inline-block;
    border: 1px solid #e7e7e7;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

    padding: 0 4px;
}
.nav.nav-tabs > li {
    float: none;
    display: inline-block;
    margin: 0;
}
.nav.nav-tabs > li a {
    float: left;
    font-size: 18px;
    font-weight: bold;
    letter-spacing: 0px;
    padding: 15px 30px;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

    margin-top: 4px;
}
.nav.nav-tabs > li a.current {
    color: #ffffff;
    background-color: #00a0e3;
}
.job-listing.wtabs {
    border: 1px solid #ebefef;
    margin-top: 30px;
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

    display: inherit;
    text-align: left;
    position: relative;
}
.job-listing.wtabs .job-title-sec {
    float: left;
    width: 70%;
}
.job-listing.wtabs .job-title-sec > span {
    color: #1e83f0;
    display: table;
    float: none;
}
.job-listing.wtabs .job-lctn {
    display: inline;
    padding-top: 20px;
    width: 100%;
    font-size: 13px;
}
.job-listing.wtabs .job-lctn i {
    float: none;
    font-size: 15px;
}
.job-style-bx {
    float: left;
    width: 30%;
    position: absolute;
    right: 0px;
    bottom: 0;
    padding: 15px;
}
.job-style-bx .fav-job {
    font-size: 20px;
    float: right;
    margin-top: 5px;
    margin-right: 10px;
}
.job-style-bx .job-is {
    margin: 0;
    
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -ms-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;

    color: #ffffff;
}
.tab-sec .tab-content {
    display: none;
}
.tab-sec .tab-content.current {
    display: block;
}
.tab-sec .browse-all-cat .style2 {
    border: 1px solid #ebefef;
    
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    -ms-box-shadow: none;
    -o-box-shadow: none;
    box-shadow: none;

    padding: 15px 44px;
    font-size: 15px;
    color: #111111;   
    
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;

}

.how-to-sec.style2.no-lines .how-to::before {
    display: none;
}
.how-to-sec.style2.no-lines .how-icon {
    border: 1px solid #e8ecec;
    background: none;
    color: #707070;
}
.back-top:hover {
    color: #FFF;
}
.job-listings-sec {
    float: left;
    width: 100%;
}
.job-listing {
    float: left;
    width: 100%;
    display: table;
    border-bottom: 1px solid #e8ecec;
    padding: 20px 0;
    background: #ffffff;
    border-left: 2px solid #ffffff;
    padding-right: 30px;
}
.job-title-sec {
    display: table-cell;
    vertical-align: middle;
    width: 60%;
}
.c-logo {
    float: left;
    width: 130px;
    height:80px;
    text-align: center;
    position:relative;
}
.c-logo img {
    float: none;
    display: inline-block;
    max-width: 80px;
    position:absolute;
    top:50%;
    transform: translate(-50%, -50%);
}
.job-title-sec h3 {
    display: table;
    font-size: 15px;
    color: #202020;
    margin: 0;
        margin-bottom: 0px;
    margin-bottom: 7px;
    margin-top: 3px;
}
.job-title-sec span {
    float: left;
    font-size: 13px;
    margin-top: 1px;
}
.job-lctn {
    display: table-cell;
    vertical-align: middle;
    font-family: open Sans;
    font-size: 13px;
    color: #888888;
    line-height: 23px;
    width: 25%;
}
.job-lctn i {
    font-size: 24px;
    float: left;
    margin-right: 7px;
}

.job-is {
    display: table-cell;
    vertical-align: middle;
    font-family: Open Sans;
    font-size: 12px;
    border: 1px solid;
    float: right;
    padding: 7px 0;
    
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    -ms-border-radius: 20px;
    -o-border-radius: 20px;
    border-radius: 20px;

    width: 108px;
    margin: 9px 0;
    text-align: center;
}
.ft.fill {
    background: #8b91dd;
}
.fill.pt {
    background: #7dc246;
}
.fill.fl {
    background: #fb236a;
}
.fill.tp {
    background: #26ae61;
}
.job-listing:hover {
    -webkit-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 30px rgba(0,0,0,0.1);

    z-index: 1;
    position: relative;
}

.job-grid .job-title-sec {
    float: left;
    width: 100%;
    text-align: center;
    position: relative;
    padding-bottom: 20px;
    border-bottom: 1px solid #e8ecec;
}
.job-grid .job-title-sec .c-logo {
    float: left;
    width: 100%;
    margin-top: 50px;
    margin-bottom: 30px;
}
.job-grid .job-title-sec h3 {
    float: left;
    width: 100%;
    margin: 0;
        margin-bottom: 0px;
    text-align: left;
    padding-left: 0px;
    margin-bottom: 6px;
}
.job-grid .job-title-sec span {
    margin-left: 0px;
}

.job-grid .job-lctn {
    float: left;
    width: auto;
    font-size: 13px;
    margin: 18px 0;
}
.job-grid > a {
    float: right;
    font-family: Open Sans;
    font-size: 13px;
    color: #fb236a;
    border: 1px solid #fb236a;
    
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    -ms-border-radius: 20px;
    -o-border-radius: 20px;
    border-radius: 20px;

    padding: 6px 14px;
    letter-spacing: 0px;
    margin: 16px 0;
    display: inline-block;
}
.browse-all-cat {
    float: left;
    width: 100%;
    text-align: center;
    margin-top: 60px;
}
');
$script = <<< JS
 $('.tab-sec li a').on("click", function(){
        var tab_id = $(this).attr('data-tab');
        $('.tab-sec li a').removeClass('current');
        $('.tab-content').removeClass('current');
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });

window.onscroll = function() {scrollFunction()};
function scrollFunction() {
  if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
    document.getElementById("myBttn").style.display = "block";
  } else {
    document.getElementById("myBttn").style.display = "none";
  }
}
$(document).on('change', '#search_type', function(){
    var value = $(this).val();
    $('#search_jobs_internships').attr('action', '/'+value+'/list');
});

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
$this->registerCssFile('@eyAssets/css/home-page-slider.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/homepage_slider/select-chosen.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/homepage_slider/slick.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
?>
