
<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
?>
<!--<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">-->
<div class="fixed-btn background-logo-blue">
    <img src="<?= Url::to('@eyAssets/images/flaticon-png/small/team-white.png'); ?>"/><br/>
    Are you an Employer?<br/>
    <span>Want to post an Internship?</span>
</div>
<section class="backgrounds">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-6 text-center">
                <h2 class="text-white"><i><?= Yii::t('frontend', 'Intern with the best...'); ?></i></h2>
                <div class="search-by-type">
                    <form class="form-inline" action="<?= Url::to('/service/searched-results-internship?'); ?>" >
                        <div class="input-group mb-10 set-col-2">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="keyword" class="form-control" placeholder="Job Title or Skill"/>
                        </div>
                        <div class="input-group mb-10 set-col-2">
                            <span class="input-group-addon"><i class="fa fa-building fa-lg"></i></span>
                            <input type="text" name="company" class="form-control" placeholder="Company"/>
                        </div>
                        <div class="input-group mb-10 set-col-2">
                            <span class="input-group-addon"><i class="fa fa-map-marker fa-lg"></i></span>
                            <input type="text" id="cities" name="location" class="form-control" autocomplete="off" placeholder="City or State"/>
                            <i class="Typeahead-spinner fa fa-circle-o-notch fa-spin fa-fw"></i>
                            <!--<input type="text" class="form-control" placeholder="City or State"/>-->
                        </div>
                        <div class="form-group mb-10 set-col-2">
                            <input type="submit" class="form-control submit-next hvr-float" id="form_control_1" value="Search">
                        </div>
                    </form>
                </div>
<!--                <form class="form-wrapper cf">
                    <input type="text" placeholder="Search here..." required>
                    <button type="submit"><?= Yii::t('frontend', 'Search'); ?></button>
                </form>-->
            </div>
            <div class="col-md-offset-2 col-md-5 col-sm-6">
                <img src="<?= Url::to('@eyAssets/images/pages/internships/c5.png'); ?>" width="75%" align="right"/>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <nav class="nav1 cl-effect-18 nav-second-bg" id="cl-effect-18">
            <div class="container">
                <a href="/site/explore-company" data-hover="Explore Company">Explore Company</a>
                <a href="/site/jobs-near-me" data-hover="Scintilla">Internships Near Me</a>
                <a href="/site/start-up-internships" data-hover="Propinquity">Start Up Internships</a>
                <a href="/site/corporate-internships" data-hover="Desultory">Corporate Internships</a>
            </div>
        </nav>
        <div class="row mt-20">
            <div class="col-md-12">
                <h2 class="heading-style"><?= Yii::t('frontend', 'internships'); ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 categories">
                <a href="/internships/list">
                    <figure class="grids">
                        <img class="grids-image" src="<?= Url::to('@eyAssets/images/pages/freelancers/digital.png'); ?>">
                    </figure>
                    <h4><?= Yii::t('frontend', 'Digital Marketing'); ?></h4>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 categories">
                <a href="/internships/list">
                    <figure class="grids">
                        <img class="grids-image" src="<?= Url::to('@eyAssets/images/pages/freelancers/music.png'); ?>">
                    </figure>
                    <h4><?= Yii::t('frontend', 'Music & Audio'); ?></h4>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 categories">
                <a href="/internships/list">
                    <figure class="grids">
                        <img class="grids-image" src="<?= Url::to('@eyAssets/images/pages/freelancers/graphic.png'); ?>">
                    </figure>
                    <h4><?= Yii::t('frontend', 'Graphic & Design'); ?></h4>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 categories">
                <a href="/internships/list">
                    <figure class="grids">
                        <img class="grids-image" src="<?= Url::to('@eyAssets/images/pages/freelancers/programming.png'); ?>">
                    </figure>
                    <h4><?= Yii::t('frontend', 'Programming & Tech'); ?></h4>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 categories">
                <a href="/internships/list">
                    <figure class="grids">
                        <img class="grids-image" src="<?= Url::to('@eyAssets/images/pages/freelancers/fun.png'); ?>">
                    </figure>
                    <h4><?= Yii::t('frontend', 'Fun & Lifestyle'); ?></h4>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 categories">
                <a href="/internships/list">
                    <figure class="grids">
                        <img class="grids-image" src="<?= Url::to('@eyAssets/images/pages/freelancers/business.png'); ?>">
                    </figure>
                    <h4><?= Yii::t('frontend', 'Business'); ?></h4>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 categories">
                <a href="/internships/list">
                    <figure class="grids">
                        <img class="grids-image" src="<?= Url::to('@eyAssets/images/pages/freelancers/video.png'); ?>">
                    </figure>
                    <h4><?= Yii::t('frontend', 'Video & Animation'); ?></h4>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 categories">
                <a href="/internships/list">
                    <figure class="grids">
                        <img class="grids-image" src="<?= Url::to('@eyAssets/images/pages/freelancers/writing.png'); ?>">
                    </figure>
                    <h4><?= Yii::t('frontend', 'Writing & Translation'); ?></h4>
                </a>
            </div>
        </div>
    </div>
</section>
<section style="background-color:#edeeef">
    <div class="container">
        <center>
            <h2>
                <b>
                    <?= Yii::t('frontend', 'Ever wondered why are internships so important?'); ?>
                </b>
            </h2>
            <!--<h3>Internships provide you with the building blocks you need for your future. Many internship opportunities help set the foundation for your career.</h3>-->
        </center>
        <hr class="hr2"/>
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="stats">
                    <img src="<?= Url::to('@eyAssets/images/pages/internships/internshipstats.png'); ?>"/>
                </div>
            </div>
            <div class="col-md-6">
                <iframe class="video-style" src="<?= Url::to('https://www.youtube.com/embed/TEDR6Jg2Pls'); ?>" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>    
</section>
<section class="bg-lighter">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h3 class="heading-style"><?= Yii::t('frontend', 'Recent internships'); ?></h3>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="type-1">
                    <div>
                        <a href="<?= Url::to('/internships/list'); ?>" class="btn btn-3">
                            <span class="txt"><?= Yii::t('frontend', 'View all'); ?></span>
                            <span class="round"><i class="fa fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row blogbox">
                <div class="col-md-4 pt-5 mb-10">
                    <div class="product shadow iconbox-border iconbox-theme-colored">
                        <span class="tag-sale color-o pl-20 pr-20 "><?= Yii::t('frontend', 'Paid'); ?>
                        </span>
                        <div class="row">
                            <div class="col-md-4 col-xs-4 pt-5" >
                                <a href="#" class="icon set_logo">
                                    <img src="http://www.eygb.co/assets/img/favicon.png">
                                </a>
                            </div>
                            <div class="col-md-8 col-xs-8 pt-20">
                                <h4 class="icon-box-title"> 
                                    <strong><?= Yii::t('frontend', 'Finance Manager'); ?>
                                    </strong>
                                </h4>
                                <h5>
                                    <i class="fa fa-map-marker">
                                    </i>  <?= Yii::t('frontend', 'Ludhiana'); ?>
                                </h5>
                                <h5>
                                    <i class="fa fa-clock-o">
                                    </i> <?= Yii::t('frontend', '6 Months'); ?>
                                </h5>
                            </div>
                            <div class="btn-add-to-cart-wrapper">
                                <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="<?= Url::to('/internships/detail'); ?>">
                                    <?= Yii::t('frontend', 'VIEW DETAILS'); ?>
                                </a>
                                <a class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 color-o" href="#">
                                    <i class="fa fa-plus">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <hr class="hr">
                        <h6 class="pull-left pl-20 custom_set2" align="center">
                            <strong><?= Yii::t('frontend', 'Last Date to Apply'); ?>
                            </strong>
                            <br>
                            <?= Yii::t('frontend', '20 Feb, 2018'); ?>
                        </h6>
                        <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                            <strong><?= Yii::t('frontend', 'DSB EduTech'); ?>
                            </strong>
                        </h4>
                    </div>
                </div>
                <div class="col-md-4 pt-5 mb-10">
                    <div class="product iconbox-border iconbox-theme-colored shadow">
                        <span class="tag-sale color-o " style="background:#202C45 !important;"><?= Yii::t('frontend', 'Unpaid'); ?>
                        </span>
                        <div class="row">
                            <div class="col-md-4 col-xs-4 pt-5" >
                                <a href="#" class="icon set_logo">
                                    <img src="http://www.eygb.co/assets/img/favicon.png">
                                </a> 
                            </div>
                            <div class="col-md-8 col-xs-8 pt-20">
                                <h4 class="icon-box-title"> 
                                    <strong><?= Yii::t('frontend', 'Finance Manager'); ?>
                                    </strong>
                                </h4>
                                <h5>
                                    <i class="fa fa-map-marker">
                                    </i> <?= Yii::t('frontend', 'Jalandhar'); ?>
                                </h5>
                                <h5>
                                    <i class="fa fa-clock-o">
                                    </i> <?= Yii::t('frontend', '4 Months'); ?>
                                </h5>
                            </div>
                            <div class="btn-add-to-cart-wrapper">
                                <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="<?= Url::to('/internships/detail'); ?>">
                                    <?= Yii::t('frontend', 'VIEW DETAILS'); ?>
                                </a>
                                <a class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 color-o" href="#">
                                    <i class="fa fa-plus">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <hr class="hr">   
                        <h6 class="pull-left pl-20 custom_set2" align="center">
                            <strong><?= Yii::t('frontend', 'Last Date to Apply'); ?>
                            </strong>
                            <br>
                            <?= Yii::t('frontend', '20 Feb, 2018'); ?>
                        </h6>
                        <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                            <strong><?= Yii::t('frontend', 'DSB EduTech'); ?>
                            </strong>
                        </h4>
                    </div>
                </div>
                <div class="col-md-4 pt-5 mb-10">
                    <div class="product shadow iconbox-border iconbox-theme-colored">
                        <span class="tag-sale color-o pl-20 pr-20 "><?= Yii::t('frontend', 'Paid'); ?>
                        </span>
                        <div class="row">
                            <div class="col-md-4 col-xs-4 pt-5" >
                                <a href="#" class="icon set_logo">
                                    <img src="http://www.eygb.co/assets/img/favicon.png">
                                </a> 
                            </div>
                            <div class="col-md-8  col-xs-8 pt-20">
                                <h4 class="icon-box-title"> 
                                    <strong><?= Yii::t('frontend', 'Finance Manager'); ?>
                                    </strong>
                                </h4>
                                <h5>
                                    <i class="fa fa-map-marker">
                                    </i> <?= Yii::t('frontend', 'Amritsar'); ?>
                                </h5>
                                <h5>
                                    <i class="fa fa-clock-o">
                                    </i> <?= Yii::t('frontend', '2 Months'); ?>
                                </h5>
                            </div>
                            <div class="btn-add-to-cart-wrapper">
                                <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="<?= Url::to('/internships/detail'); ?>">
                                    <?= Yii::t('frontend', 'VIEW DETAILS'); ?>
                                </a>
                                <a class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 color-o" href="#">
                                    <i class="fa fa-plus">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <hr class="hr">
                        <h6 class="pull-left pl-20 custom_set2" align="center">
                            <strong><?= Yii::t('frontend', 'Last Date to Apply'); ?>
                            </strong>
                            <br>
                            <?= Yii::t('frontend', '20 Feb, 2018'); ?>
                        </h6>
                        <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                            <strong><?= Yii::t('frontend', 'DSB EduTech'); ?>
                            </strong>
                        </h4>
                    </div>
                </div>
                <div class="col-md-4 pt-5 mb-10">
                    <div class="product iconbox-border iconbox-theme-colored shadow">
                        <span class="tag-sale color-o " style="background:#202C45 !important;"><?= Yii::t('frontend', 'Unpaid'); ?>
                        </span>
                        <div class="row">
                            <div class="col-md-4 col-xs-4 pt-5" >
                                <a href="#" class="icon set_logo">
                                    <img src="http://www.eygb.co/assets/img/favicon.png">
                                </a> 
                            </div>
                            <div class="col-md-8 col-xs-8 pt-20">
                                <h4 class="icon-box-title"> 
                                    <strong><?= Yii::t('frontend', 'Finance Manager'); ?>
                                    </strong>
                                </h4>
                                <h5>
                                    <i class="fa fa-map-marker">
                                    </i> <?= Yii::t('frontend', 'Jalandhar'); ?>
                                </h5>
                                <h5>
                                    <i class="fa fa-clock-o">
                                    </i> <?= Yii::t('frontend', '4 Months'); ?>
                                </h5>
                            </div>
                            <div class="btn-add-to-cart-wrapper">
                                <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="<?= Url::to('/internships/detail'); ?>">
                                    <?= Yii::t('frontend', 'VIEW DETAILS'); ?>
                                </a>
                                <a class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 color-o" href="#">
                                    <i class="fa fa-plus">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <hr class="hr">   
                        <h6 class="pull-left pl-20 custom_set2" align="center">
                            <strong><?= Yii::t('frontend', 'Last Date to Apply'); ?>
                            </strong>
                            <br>
                            <?= Yii::t('frontend', '20 Feb, 2018'); ?>
                        </h6>
                        <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                            <strong><?= Yii::t('frontend', 'DSB EduTech'); ?>
                            </strong>
                        </h4>
                    </div>
                </div>
                <div class="col-md-4 pt-5 mb-10">
                    <div class="product shadow iconbox-border iconbox-theme-colored">
                        <span class="tag-sale color-o pl-20 pr-20 "><?= Yii::t('frontend', 'Paid'); ?>
                        </span>
                        <div class="row">
                            <div class="col-md-4 col-xs-4 pt-5" >
                                <a href="#" class="icon set_logo">
                                    <img src="http://www.eygb.co/assets/img/favicon.png">
                                </a> 
                            </div>
                            <div class="col-md-8  col-xs-8 pt-20">
                                <h4 class="icon-box-title"> 
                                    <strong><?= Yii::t('frontend', 'Finance Manager'); ?>
                                    </strong>
                                </h4>
                                <h5>
                                    <i class="fa fa-map-marker">
                                    </i> <?= Yii::t('frontend', 'Amritsar'); ?>
                                </h5>
                                <h5>
                                    <i class="fa fa-clock-o">
                                    </i> <?= Yii::t('frontend', '2 Months'); ?>
                                </h5>
                            </div>
                            <div class="btn-add-to-cart-wrapper">
                                <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="<?= Url::to('/internships/detail'); ?>">
                                    <?= Yii::t('frontend', 'VIEW DETAILS'); ?>
                                </a>
                                <a class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 color-o" href="#">
                                    <i class="fa fa-plus">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <hr class="hr">
                        <h6 class="pull-left pl-20 custom_set2" align="center">
                            <strong><?= Yii::t('frontend', 'Last Date to Apply'); ?>
                            </strong>
                            <br>
                            <?= Yii::t('frontend', '20 Feb, 2018'); ?>
                        </h6>
                        <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                            <strong><?= Yii::t('frontend', 'DSB EduTech'); ?>
                            </strong>
                        </h4>
                    </div>
                </div>
                <div class="col-md-4 pt-5 mb-10">
                    <div class="product iconbox-border iconbox-theme-colored shadow">
                        <span class="tag-sale color-o " style="background:#202C45 !important;"><?= Yii::t('frontend', 'Unpaid'); ?>
                        </span>
                        <div class="row">
                            <div class="col-md-4 col-xs-4 pt-5" >
                                <a href="#" class="icon set_logo">
                                    <img src="http://www.eygb.co/assets/img/favicon.png">
                                </a> 
                            </div>
                            <div class="col-md-8 col-xs-8 pt-20">
                                <h4 class="icon-box-title"> 
                                    <strong><?= Yii::t('frontend', 'Finance Manager'); ?>
                                    </strong>
                                </h4>
                                <h5>
                                    <i class="fa fa-map-marker">
                                    </i> <?= Yii::t('frontend', 'Jalandhar'); ?>
                                </h5>
                                <h5>
                                    <i class="fa fa-clock-o">
                                    </i> <?= Yii::t('frontend', '4 Months'); ?>
                                </h5>
                            </div>
                            <div class="btn-add-to-cart-wrapper">
                                <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="<?= Url::to('/internships/detail'); ?>">
                                    <?= Yii::t('frontend', 'VIEW DETAILS'); ?>
                                </a>
                                <a class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 color-o" href="#">
                                    <i class="fa fa-plus">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <hr class="hr">   
                        <h6 class="pull-left pl-20 custom_set2" align="center">
                            <strong><?= Yii::t('frontend', 'Last Date to Apply'); ?>
                            </strong>
                            <br>
                            <?= Yii::t('frontend', '20 Feb, 2018'); ?>
                        </h6>
                        <h4 class="pull-right pr-10 pt-20 custom_set" align="center">
                            <strong><?= Yii::t('frontend', 'DSB EduTech'); ?>
                            </strong>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="thanks"></div>
                <div id="nextques">
                    <div class="poll-card">
                        <div class="question">

                        </div>
                        <div class="options">
                            <div class="option option-1">
                                <div class="analytic">
                                    <div class="bar"></div>
                                    <div class="percent"><?= Yii::t('frontend', '50%'); ?></div>
                                </div>
                                <div class="input">
                                    <input type="radio" id="option-1" name="option" hidden>
                                    <label for="option-1" class="choice1">
                                    </label>
                                </div>
                            </div>
                            <div class="option option-2">
                                <div class="analytic">
                                    <div class="bar"></div>
                                    <div class="percent"><?= Yii::t('frontend', '50%'); ?></div>
                                </div>
                                <div class="input">
                                    <input type="radio" id="option-2" name="option" hidden>
                                    <label for="option-2" class="choice2"></label>
                                </div>
                            </div>
                            <div class="option option-3">
                                <div class="analytic">
                                    <div class="bar"></div>
                                    <div class="percent"><?= Yii::t('frontend', '50%'); ?></div>
                                </div>
                                <div class="input">
                                    <input type="radio" id="option-3" name="option" hidden>
                                    <label for="option-3" class="choice3"></label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info submit pull-right"><?= Yii::t('frontend', 'Next'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->

<section class="background-mirror mt-20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="heading-style text-white"><?= Yii::t('frontend', 'Recent Blog'); ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="blog-slider" class="owl-carousel-4col" data-dots="false" data-nav="true">
                    <?php
                    foreach ($posts as $post) {
                        $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                        $image = Yii::$app->params->upload_directories->posts->featured_image . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                        if (!file_exists($image_path)) {
                            $image = '//placehold.it/570x390';
                        }
                        ?>
                        <div class="item owl-item">
                            <div class="single-news-content single-item-hoverly first-column">
                                <figure class="img-box">
                                    <img src="<?= $image; ?>" width="100%" height="212px" alt="<?= $post['featured_image_alt']; ?>" title="<?= $post['featured_image_title']; ?>"/>
                                    <div class="overlay">
                                        <a href="<?= Url::to('/blog/' . $post['slug']); ?>" class="btn-one btn-bg"><?= Yii::t('frontend', 'Read More'); ?></a>
                                    </div>
                                </figure>
                                <ul class="meta in-block">
                                    <li><?= date('d M, Y', strtotime($post['created_on'])); ?></li>
                                </ul>
                                <div class="lower-content">
                                    <div class="title"><h4><a href="<?= Url::to('/blog/' . $post['slug']); ?>"><?= $post['title']; ?></a></h4></div>
                                    <div class="text">
                                        <p>
                                            <?php
                                            $post['slug'] = strip_tags($post['excerpt']);
                                            if (strlen($post['excerpt']) > 55) {
                                                echo substr($post['excerpt'], 0, 55) . ' ....<a href="' . Url::to('/blog/' . $post['title']) . '">Read More</a>';
                                            } else {
                                                echo $post['excerpt'] . ' ... ';
                                                ?>
                                                <a href="<?= Url::to('/blog/' . $post['slug']); ?>" style="color:red;padding-left:5px;font-size:16px;"><?= Yii::t('frontend', 'Read More'); ?></a>
                                                <?php
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="heading-style"><?= Yii::t('frontend', 'Featured Companies'); ?></h3>
                <div class="row ml-20 mr-20">
                    <div class="partners-flex">
                        <div id="company-slider" class="owl-carousel-4col" data-dots="false" data-nav="true">
                            <!---->
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/pages/home/dsbedutech.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <!---->
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/pages/home/agile.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <!---->
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/pages/home/dsblaw.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/pages/home/agile.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <!---->
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/pages/home/ey.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <!---->
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/pages/home/dsblaw.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/pages/home/agile.jpg'); ?>" align="left">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$script = <<<JS
$('#company-slider').owlCarousel({
loop: true,
nav: true,
dots: false,
pauseControls: true,
margin: 20,
responsiveClass: true,
navText: [
'<i class="fa fa-angle-left set_icon"></i>',
'<i class="fa fa-angle-right set_icon"></i>'
],
responsive: {
0: {
items: 1
},
568: {
items: 2
},
600: {
items: 3
},
1000: {
items: 6
},
1400: {
items: 7
}
}
});
JS;


$this->registerCss('
.backgrounds{
    background-size: 100% 640px;
    background-image: url(' . Url::to('@eyAssets/images/backgrounds/intern-bg.png') . ');
    background-position: left top;
    background-repeat: no-repeat;
    min-height: 600px;
    padding-top: 100px;
}
/* Top Search bar css start */
.twitter-typeahead{
    width: 100%;
    float: left;
}
.twitter-typeahead input{
    width:100% !important;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}



.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
  margin: 0px 0;
//  padding: 8px 0;
  text-align:left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 0px 0px 6px 6px;
     -moz-border-radius: 0px 0px 6px 6px;
          border-radius: 0px 0px 6px 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 0;
    top: 10px;
    font-size: 25px;
    display: none;
}
/* Top Search bar css ends */
/* Search button css start */
.form-wrapper {
    width: 450px;
    margin: auto;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    -moz-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);
    box-shadow: 0 1px 1px rgba(0,0,0,.4) inset, 0 1px 0 rgba(255,255,255,.2);
}
.form-wrapper input {
    width: 340px;
    height: 50px;
    padding: 10px 5px;
    float: left;    
    font: bold 15px "lucida sans", "trebuchet MS", "Tahoma";
    border: 0;
    background: #eee;
    -moz-border-radius: 3px 0 0 3px;
    -webkit-border-radius: 3px 0 0 3px;
    border-radius: 8px 0 0 8px;      
}
.form-wrapper input:focus {
    outline: 0;
    background: #fff;
    -moz-box-shadow: 0 0 2px rgba(0,0,0,.8) inset;
    -webkit-box-shadow: 0 0 2px rgba(0,0,0,.8) inset;
    box-shadow: 0 0 2px rgba(0,0,0,.8) inset;
}
.form-wrapper input::-webkit-input-placeholder {
    color: #999;
    font-weight: normal;
    font-style: italic;
}
.form-wrapper input:-moz-placeholder {
    color: #999;
    font-weight: normal;
    font-style: italic;
}
.form-wrapper input:-ms-input-placeholder {
    color: #999;
    font-weight: normal;
    font-style: italic;
}
.form-wrapper button {
    overflow: visible;
    position: relative;
    float: right;
    border: 0;
    padding: 0;
    cursor: pointer;
    height: 50px;
    width: 110px;
    font: bold 15px/40px "lucida sans", "trebuchet MS", "Tahoma";
    color: #fff;
    text-transform: uppercase;
    background: #d83c3c;
    -moz-border-radius: 0 3px 3px 0;
    -webkit-border-radius: 0 3px 3px 0;
    border-radius: 0 8px 8px 0;      
    text-shadow: 0 -1px 0 rgba(0, 0 ,0, .3);
}
.form-wrapper button:hover{		
    background: #e54040;
}
.form-wrapper button:active,
.form-wrapper button:focus{   
    background: #c42f2f;    
}
.form-wrapper button:before {
    content: "";
    position: absolute;
    border-width: 8px 8px 8px 0;
    border-style: solid solid solid none;
    border-color: transparent #d83c3c transparent;
    top: 18px;
    left: -6px;
}
.form-wrapper button:hover:before{
    border-right-color: #e54040;
}
.form-wrapper button:focus:before{
    border-right-color: #c42f2f;
}
.form-wrapper button::-moz-focus-inner {
    border: 0;
    padding: 0;
}
/*Search button css ends*/
.categories{
    text-align: center;
    min-height: 150px;
    margin-bottom: 20px;
}
.image-style img{
    width: 50px;
    height: 50px;
}
.grids {
    display: block;
    position: relative;
    width: 150px;
    height: 150px;
    margin: 0 auto 24px;
    border-radius: 50%;
    -webkit-transition: all .2s ease-out;
    transition: all .2s ease-out;
}
.grids-image {
    display: inline-block;
    width: 64px;
    height: 64px;
    margin-top: 44px;
}
.grids::after {
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 148px;
    height: 148px;
    border: 2px solid #afafaf;
    border-radius: 50%;
    content: "";
    -webkit-transition: all .1s ease-out;
    transition: all .1s ease-out;
}
.categories:hover .grids::after {
    top: -1px;
    left: -1px;
    border: 2px solid #f08440;
    -webkit-transform: scale(.9);
    transform: scale(.9);
}
.blogbox{
    margin-bottom: 20px;
}
.hr2{
    color: #f00;
    background-color: #000000;
    height: 1px;
}
/* owl Slider css starts */
#company-slider .owl-stage-outer .owl-stage .owl-item .item{
    display: block;
    padding: 30px 0px;
    margin: 5px;
    color: #FFF;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    text-align: center;
}
#company-slider .owl-controls .nav div {
    padding: 5px 9px;
}
.owl-nav i{
    margin-top: 2px;
}
#company-slider .owl-controls .owl-nav div {
    position: absolute;
}
#company-slider .owl-controls .owl-nav .owl-prev{
    left: -60px;
    top: 50px;
}
#company-slider .owl-controls .owl-nav .owl-prev i, #company-slider .owl-controls .owl-nav .owl-next i{
    font-size:64px !important;
}
#company-slider .owl-controls .owl-nav .owl-prev, #company-slider .owl-controls .owl-nav .owl-next{
    background: transparent !important;
}
#company-slider .owl-controls .owl-nav .owl-next{
    right: -60px;
    top: 50px;
}
.owl-item{
    min-height:150px !important;
}
.partners-flex-box .logo-box:hover {
    -webkit-box-shadow: 0 17px 27px -9px #757575;
    box-shadow: 0 17px 27px -9px #757575;
    -webkit-transition: -webkit-box-shadow .7s !important;
    transition: -webkit-box-shadow .7s !important;
    transition: box-shadow .7s !important;
    transition: box-shadow .7s, -webkit-box-shadow .7s !important;
}
.partners-flex .partners-flex-box {
    width: 20%;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 65px;
    width: 65px;
    background-color: #fff;
}
.partners-flex .partners-flex-box {
    width: 20%;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 90px;
    width: 90px;
    background-color: #fff;
}
.partners-flex .partners-flex-box {
    width: 130px;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 120px;
    width: 120px;
    background-color: #fff;
    display:block;
}
.partners-flex .partners-flex-box .image-partners {
    height: 114px;
    margin: 2px;
    cursor: pointer;
    padding: 6px;
    width: 116px;
}
.partners-flex {
    width: 90%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap;
    margin: 1.5% auto;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
/* owl Slider css ends */
.set-height li{
    height: 88px;
}
.c100{
    float: right !important;
    top:-26px;
}

/*    <!-- view-all button css start -->*/
.btn-3 {
    background-color: #424242;
}
.btn-3 .round {
    background-color: #737478;
}
.type-1{
    float:right;
    margin-top: 15px;
}
.type-1 div a {
    text-decoration: none;
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
    padding: 12px 53px 12px 23px;
    color: #fff;
    text-transform: uppercase;
    font-family: sans-serif;
    font-weight: bold;
    position: relative;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    display: inline-block;
}
.type-1 div a span {
    position: relative;
    z-index: 3;
}
.type-1 div a .round {
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    position: absolute;
    right: 3px;
    top: 3px;
    -moz-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
    z-index: 2;
}
.type-1 div a .round i {
    position: absolute;
    top: 50%;
    margin-top: -6px;
    left: 50%;
    margin-left: -4px;
    color: #333332;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}

.txt {
    font-size: 14px;
    line-height: 1.45;
}

.type-1 a:hover {
    padding-left: 48px;
    padding-right: 28px;
}
.type-1 a:hover .round {
    width: calc(100% - 6px);
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
}
.type-1 a:hover .round i {
    left: 12%;
    color: #FFF;
}

/*<!---- view-all button css ends --->*/
.fixed-btn{
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
.fixed-btn span{
    font-weight: 700;
}
.fixed-btn:hover{
    opacity: 1;
    bottom: 0px;
}
.background-logo-blue{
    background-color: #49a1e3;
}
.background-mirror {
    background: linear-gradient(180deg, #2b2d32 55%, #fff 55%);
}
.video-style{
    width: 100%;
    height: 300px !important;
}
.stats{
    padding: 75px 0px;
}
.search-by-type {
    width: 88%;
    background-color: #14141459;
    padding: 2px 20px;
    color: #fff;
    margin: auto;
    border-radius: 10px;
    margin-top: 20px;
    padding-top: 20px;
}
.submit-next {
    border-radius: 4px;
    width: 100% !important;
    background-color: #f07d1b;
    color: #FFF;
    border-color: transparent;
}
.select2-selection{
    height:45px !important;
    border-radius:0px !important;
}
.select2-selection__arrow{
    display:none !important;
}
.select2-container{
    margin-left: -1px !important;
}
.select2-selection__rendered{
    margin-top:6px !important;
    text-align:left !important;
}
.set-col-2{
    width:49%;
}
/* animated menu css starts */
.nav1{
    padding:60px 0;
    text-align:center;
}
.nav1 a {
    position: relative;
    display: inline-block;
    margin: 15px 25px;
    outline: none;
    color: #ff4500;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
    text-shadow: 0 0 1px rgba(255,255,255,0.3);
    font-size: 16px;	
}
.nav1 a:hover,
.nav1 a:focus {
	outline: none;
	text-decoration:none;
}
.cl-effect-18 {
    position: relative;
    z-index: 1;
}
.cl-effect-18 a {
    padding: 0 5px;
    color: #afafaf;
    font-weight: 700;
    -webkit-transition: color 0.3s;
    -moz-transition: color 0.3s;
    transition: color 0.3s;
}
.cl-effect-18 a::before,
.cl-effect-18 a::after {
    position: absolute;
    width: 100%;
    left: 0;
    top: 50%;
    height: 2px;
    margin-top: -1px;
    background: #333333;
    content: "";
    z-index: -1;
    -webkit-transition: -webkit-transform 0.3s, opacity 0.3s;
    -moz-transition: -moz-transform 0.3s, opacity 0.3s;
    transition: transform 0.3s, opacity 0.3s;
    pointer-events: none;
}
.cl-effect-18 a::before {
    -webkit-transform: translateY(-20px);
    -moz-transform: translateY(-20px);
    transform: translateY(-20px);	
}
.cl-effect-18 a::after {
    -webkit-transform: translateY(20px);
    -moz-transform: translateY(20px);
    transform: translateY(20px);	
}
.cl-effect-18 a:hover,
.cl-effect-18 a:focus {
    color: #ff9900;	
}
.cl-effect-18 a:hover::before,
.cl-effect-18 a:hover::after,
.cl-effect-18 a:focus::before,
.cl-effect-18 a:focus::after {
    opacity:0.1;
}
.cl-effect-18 a:hover::before,
.cl-effect-18 a:focus::before {
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    transform: rotate(45deg);
}
.cl-effect-18 a:hover::after,
.cl-effect-18 a:focus::after {
    -webkit-transform: rotate(-45deg);
    -moz-transform: rotate(-45deg);
    transform: rotate(-45deg);
}
@media only screen and (max-width: 1200px){
    .nav1 a{font-size: 15px;
    margin: 15px 10px;}
}
@media only screen and (max-width: 992px){
    .nav1 a{font-size: 10px;
    margin: 15px 10px;}
}
/* animated menu css ends */
');

$script = <<<JS
        
        
var city = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/cities/city-list?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#cities').typeahead(null, {
  name: 'cities',
  highlight: true,       
  display: 'text',
  source: city,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.Typeahead-spinner').hide();
  });

JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/blog.css');
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerCssFile('@eyAssets/css/quiz-style.css');
//$this->registerCssFile('/assets/dashboard/global/css/components-rounded.min.css');
//$this->registerCssFile('/assets/dashboard/global/plugins/simple-line-icons/simple-line-icons.min.css');
//$this->registerJsFile('@eyAssets/js/quiz/quiz.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
