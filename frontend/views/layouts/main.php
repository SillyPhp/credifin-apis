<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use frontend\assets\AppAssets;

AppAssets::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
    <head>
        <meta charset="<?= Yii::$app->charset; ?>">
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode((!empty($this->title)) ? Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name : Yii::$app->params->site_name); ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="icon" href="<?= Url::to('/favicon.ico'); ?>">
        <?php
        if (isset($this->params['seo_tags']) && !empty($this->params['seo_tags'])) {
            foreach ($this->params['seo_tags']['rel'] as $key => $value) {
                $this->registerLinkTag([
                    'rel' => $key,
                    'href' => $value,
                ]);
            }
            foreach ($this->params['seo_tags']['name'] as $key => $value) {
                $this->registerMetaTag([
                    'name' => $key,
                    'content' => $value,
                ]);
            }
            foreach ($this->params['seo_tags']['property'] as $key => $value) {
                $this->registerMetaTag([
                    'property' => $key,
                    'content' => $value,
                ]);
            }
            if(!isset($this->params['header_dark'])) {
                $this->params['header_dark'] = false;
            }
        }
        ?>
        <?php $this->head(); ?>
    </head>
    <body class="fullwidth-page">
        <?php $this->beginBody(); ?>
        <div class="body-overlay"></div>
        <div id="wrapper" class="clearfix">
            <header id="header" class="header">
                <?= (!$this->params['header_dark']) ? '<div id="main-header" class="header-nav navbar-fixed-top header-dark navbar-white navbar-transparent navbar-sticky-animated animated-active">' : ''; ?>
                <div class="header-nav-wrapper <?= ($this->params['header_dark']) ? 'navbar-scrolltofixed bg-theme-colored border-bottom-theme-color-2-1px' : ''; ?>">
                    <div class="container-fluid">
                        <nav id="menuzord-right" class="menuzord orange <?= ($this->params['header_dark']) ? 'bg-theme-colored pull-left flip menuzord-responsive' : ''; ?>">
                            <a class="menuzord-brand pull-left flip mt-15" href="<?= Url::to('/'); ?>">
                                <?php
                                if (!Yii::$app->user->isGuest) {
                                    ?>
                                    <img id="logo-black" alt="<?= Yii::$app->params->site_name; ?>" src="<?= Url::to('@commonAssets/logos/empower_youth_plus.svg'); ?>">
                                    <?php
                                    if (!$this->params['header_dark']) {
                                        ?>
                                    <img id="logo-white"  alt="<?= Yii::$app->params->site_name; ?>" src="<?= Url::to('@commonAssets/logos/empower_youth_plus_white.svg'); ?>">
                                    <?php
                                    }
                                    ?>
                                    <span class="logo_beta">Beta</span>
                                    <?php
                                } else{
                                ?>
                                    <img id="logo-black" alt="<?= Yii::$app->params->site_name; ?>" src="<?= Url::to('@commonAssets/logos/logo.svg'); ?>">
                                    <?php
                                    if (!$this->params['header_dark']) {
                                        ?>
                                    <img id="logo-white"  alt="<?= Yii::$app->params->site_name; ?>" src="<?= Url::to('@commonAssets/logos/logo_white.svg'); ?>">
                                    <?php
                                    }
                                    ?>
                                    <span class="logo-beta">Beta</span>
                                    <?php
                                }
                                ?>

                            </a>
                            <?php
                            if (!Yii::$app->user->isGuest) {
                                $name = $image = $color = NULL;
                                if (Yii::$app->user->identity->organization->organization_enc_id) {
                                    if (Yii::$app->user->identity->organization->logo) {
                                        $image = Yii::$app->params->upload_directories->organizations->logo . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;
                                    }
                                    $name = Yii::$app->user->identity->organization->name;
                                    $color = Yii::$app->user->identity->organization->initials_color;
                                } else {
                                    if (Yii::$app->user->identity->image) {
                                        $image = Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image;
                                    }
                                    $name = Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name;
                                    $color = Yii::$app->user->identity->initials_color;
                                }
                                ?>
                               <?php Pjax::begin(['id' => 'pjax_profile_icon']); ?>
                                <div class="my-profiles-sec">
                                    <?php if ($image): ?>
                                        <span><img src="<?= $image; ?>" title="<?= $name; ?>" alt="<?= $name; ?>" /></span>
                                    <?php else: ?>
                                        <span><canvas class="user-icon" name="<?= $name; ?>" color="<?= $color; ?>" width="40" height="40" font="20px"></canvas></span>
                                    <?php endif; ?>
                                </div>
                                <?php Pjax::end(); ?>
                                <?php
                            }

                            echo $this->render('/widgets/top-header', [
                                'menu_class' => 'menuzord-menu' . (!$this->params['header_dark']) ? ' dark' : '',
                            ]);
                            ?>
                        </nav>
                    </div>
                </div>
                <?= (!$this->params['header_dark']) ? '</div>' : ''; ?>
            </header>
            <div class="main-content">
                <div id="page-loading" class="page-loading">
                    <img src="<?= Url::to('@eyAssets/images/loader/loader-main.gif'); ?>" alt="Loading..">
                </div>
                <?= $content; ?>
            </div>
            <footer id="footer" class="footer">
                <div class="footer-border">
                    <a href="/"><img src="<?= Url::to('/assets/common/logos/footer-logo.png'); ?>"> </a>
                </div>
                <div class="set_container container">
                    <div class="row">
                        <div class="mt-6 useful-links col-sm-6 col-xs-12 col-md-3">
                            <div class="footer-widget ">
                                <div class="widget-title1 mb-10"><?= Yii::t('frontend', 'Connect With Us'); ?></div>
                                <ul class="styled-icons icon-bordered icon-sm mb-5">
                                    <li><a href="https://www.facebook.com/empower" target="_blank" class="overfb"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/EmpowerYouth__" target="_blank" class="overtw"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="https://www.instagram.com/empoweryouth.in" target="_blank" class="overig"><i class="fa fa-instagram"></i></a></li>
                                    <li><a href="https://www.pinterest.com/dedutech" target="_blank" class="overpt"><i class="fa fa-pinterest"></i></a></li>
                                    <li><a href="https://www.linkedin.com/company/empoweryouth" target="_blank" class="overlink"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                                <br/><br/>
                                <a class="text-gray mt-10 send_mail" href="mailto:info@empoweryouth.com"><i class="fa fa-envelope-o mt-5 mr-5"></i> <span>info@empoweryouth.com</span></a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="col-sm-6 col-xs-12 col-md-3">
                                <div class="footer-widget mb-10"><?= Yii::t('frontend', 'Jobs By Location'); ?></div>
                                <ul class="footer-list">
                                    <li><a href="/jobs/list?location=Ludhiana">Jobs in Ludhiana</a></li>
                                    <li><a href="/jobs/list?location=Jalandhar">Jobs in Jalandhar</a></li>
                                    <li><a href="/jobs/list?location=Chandigarh">Jobs in Chandigarh</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-md-3">
                                <div class="footer-widget mb-10"><?= Yii::t('frontend', 'Jobs By Profile'); ?></div>
                                <ul class="footer-list">
                                    <li><a href="/jobs/list?keyword=Information%20Technology">IT Jobs</a></li>
                                    <li><a href="/jobs/list?keyword=Social%20Services">Social Services Jobs</a></li>
                                    <li><a href="/jobs/list?keyword=Business%20Development">Business Development Jobs</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-md-3">
                                <div class="footer-widget mb-10"><?= Yii::t('frontend', 'Internships By Location'); ?></div>
                                <ul class="footer-list">
                                    <li><a href="/internships/list?location=Ludhiana">Internships in Ludhiana</a></li>
                                    <li><a href="/internships/list?location=Jalandhar">Internships in Jalandhar</a></li>
                                    <li><a href="/internships/list?location=Chandigarh">Internships in Chandigarh</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-md-3">
                                <div class="footer-widget mb-10"><?= Yii::t('frontend', 'Internships By Profile'); ?></div>
                                <ul class="footer-list">
                                    <li><a href="/internships/list?keyword=Marketing">Marketing Internships</a></li>
                                    <li><a href="/internships/list?keyword=Arts%20and%20Design">Arts and Design Internships</a></li>
                                    <li><a href="/internships/list?keyword=Administrative">Administrative Internships</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="container pt-20 pb-20">
                            <div class="col-md-12 col-sm-12 text-center">
                                <p class="font-11 copyright-text"><?= Yii::t('frontend', 'Copyright') . ' &copy; ' . date('Y') . ' ' . Yii::$app->params->site_name . ' ' . Yii::t('frontend', 'All Rights Reserved') . '.'; ?></p>
                            </div>
                    </div>
                </div>
            </footer>
            <?php
            if (!Yii::$app->user->isGuest) {
                echo $this->render('/widgets/user-profile-sidebar-right');
            }
            ?>
        </div>
        <?php
        $this->registerCss('
            .send_mail{word-wrap: break-word;display:block;}
            .send_mail i{color:#00a0e3;float:left;}
            .send_mail span{float:left;}
             .feed-btn a{
                border:2px solid #00a0e3;
                color:#00a0e3;
                padding:5px 10px;
                border-radius:20px;
                margin-top:20px !important;
                -webkit-transition: .3s all;
                -moz-transition: .3s all;
                -ms-transition: .3s all;
                -o-transition: .3s all;
                transition: .3s all;
                
             }
             .feed-btn a:hover{
                color:#fff;
                background:#00a0e3;
                -webkit-transition: .3s all;
                -moz-transition: .3s all;
                -ms-transition: .3s all;
                -o-transition: .3s all;
                transition: .3s all;
                
             }
            .menuzord-brand{
                position:relative;
             }
            .logo-beta{
                font-size: 11px;
                position: absolute;
                bottom: -2px;
                right: -25px;
                color: #444;
             }
            .logo_beta{
                font-size: 11px;
                 position: absolute;
                 bottom: -2px; 
                 right: -15px;
                 color: #444;
             }
            .add-padding nav .menuzord-brand .logo_beta{
                color:#fff;
             }
            .add-padding nav .menuzord-brand .logo-beta{
                color:#fff;
             }
            .page-loading {
                background-color: #ffffff;
                content: "";
                height: 100%;
                left: 0;
                position: fixed;
                text-align: center;
                margin:0px;
                top: 0;
                width: 100%;
                z-index: 2147483647;
            }
            .page-loading > img {
                left: 50%;
                position: absolute;
                top: 50%;
                -webkit-transform: translateX(-50%) translateY(-50%);
                -moz-transform: translateX(-50%) translateY(-50%);
                -ms-transform: translateX(-50%) translateY(-50%);
                -o-transform: translateX(-50%) translateY(-50%);
                transform: translateX(-50%) translateY(-50%);
            }
            #main-header #logo-black{
                display:none;
            }
            .my-profiles-sec {
                float: right;
            }
            .my-profiles-sec > span {
                float: left;
                width:40px;
                height:40px;
                color: #49a1e3;
                font-family: Open Sans;
                cursor: pointer;
                -webkit-border-radius: 50%;
                -moz-border-radius: 50%;
                -ms-border-radius: 50%;
                -o-border-radius: 50%;
                border-radius: 50% !important;
            }
            /*footer css*/
            .useful-links ul li{
                display:inline;
            }
            .footer a {
                text-align: center;
                width: 100%;
             }
            .footer-border{
                text-align:center; 
                border-top:5px solid #00a0e3;
                position:relative;
            }
            .footer-border img{
                margin-top:-50px
            }
            .footer{
                background-repeat: no-repeat;
                background-size: contain;
                background-position: left bottom;
                margin-top: 60px;
            } 
            .footer-widget{
                color:#00a0e3;
                margin: 0 auto;
            }
            .icons-ss{
                padding-top:15px;
            }
            .widget .styled-icons li a {
                margin-bottom: 0;
                text-align:center;
            }
            .styled-icons.icon-sm a {
                font-size: 14px;
                width: 34px;
                height: 34px;
                color: #00a0e3;
            }
            .styled-icons.icon-bordered a:hover{
                border: 2px solid transparent;
            }
            .styled-icons.icon-bordered a { 
               border: 2px solid #00a0e3;
               border-radius:20px;
            }
            .styled-icons.icon-ss a { 
                font-size: 12px;
                width: 140px;
                color: #fff;
                height:35px;
             }  
            .subscribe-form{
                padding-top:60px ;
            }
            .copyright-text{
                margin-top:7px;
              }
            /*footer-css-ends*/
            .fullheight {
                background-size: contain !important;
            }
            .main-content{
                min-height: 70%;
                min-height: -webkit-calc(100vh - 355px);
                min-height: -moz-calc(100vh - 355px);
                min-height: calc(100vh - 355px);
            }
            .overfb:hover{
                background-color: #236dce !important;
                color:white;
            }
            .overtw:hover{
                background-color:#1c99e9 !important;
                color:white;
            }
            .overig:hover{
                background: #d6249f;
                background: radial-gradient(circle at 33% 100%, #FED373 4%, #F15245 30%, #D92E7F 62%, #9B36B7 85%, #515ECF);
                color:white;
                border-color:#b8319c !important;
            }
            .overpt:hover{
                background-color:#C92228 !important;
                color:white;
            }
            .overlink:hover{
                background-color: #0077B5 !important;
                color:white;
            }
            @media only screen and (min-width: 991px){
                .my .widget .mb-6{
                    text-align: left !important;
                }
            }
            .menuzord-brand img{
                max-height:42px;
                margin-left:20px;
            }
            .my-profiles-sec span{
                line-height:normal;
                margin-top:5px;
            }
            .my-profiles-sec > span > img, .cst img, .my-profiles-sec span canvas{
                -webkit-border-radius: 50% !important;
                -moz-border-radius: 50% !important;
                -ms-border-radius: 50% !important;
                -o-border-radius: 50% !important;
                border-radius: 50% !important;
                width: 100%;
                height: 100%;
                background-color: #fff;
            }
            .profiles-sidebar .close-profile{
                -webkit-border-radius: 50% !important;
                -moz-border-radius: 50% !important;
                -ms-border-radius: 50% !important;
                -o-border-radius: 50% !important;
                border-radius: 50% !important;
            }
            .footer-list li{
                float: left;
                width: 100%;
                margin: 0;
                margin-bottom: 0px;
                position: relative;
                padding-left: 10px;
                line-height: 21px;
                margin-bottom: 10px;
                font-size: 13px;
                color: #888888;
            }
            ');

        if ($this->params['header_dark']) {
            $this->registerCss('@media only screen and (max-width:900px){
                .header {
                    max-height:80px !important;
                }
            }
            #menuzord-right{
                padding:0px !important;
            }
            ');
        }

        $this->registerJsFile('https://www.googletagmanager.com/gtag/js?id=UA-121432126-1', [
            'depends' => [\yii\web\JqueryAsset::className()],
            'sync' => 'async',
        ]);

        $this->registerJs('
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag("js", new Date());
            gtag("config", "UA-121432126-1");
             
            window.fbAsyncInit = function() {
               FB.init({
                 xfbml            : true,
                 version          : "v3.2"
               });
             };
            
             (function(d, s, id) {
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) return;
             js = d.createElement(s); js.id = id;
             js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
             fjs.parentNode.insertBefore(js, fjs);
            }(document, "script", "facebook-jssdk"));
            
            $(".page-loading").fadeOut();
                    
        ');
        
        if (!$this->params['header_dark']) {
            $this->registerJs(" $(document).on('scroll', function () {
                var header = $('#main-header');
                if (!header.hasClass('animated-active')) {
                    $('#logo-white').hide();
                    $('#logo-black').show();
                } else {
                    $('#logo-black').hide();
                    $('#logo-white').show();
                }
            }); ");
        }
        $this->registerJsFile('https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js', ['depends' => [\yii\web\JqueryAsset::className()], 'position' => \yii\web\View::POS_HEAD]);
        $this->registerJs('
            WebFont.load({
                    google: {
                            "families": ["Lobster", "Roboto", "Poppins", "Open+Sans","Didact Gothic", "Raleway", "Playfair+Display"]
                    },
                    active: function() {
                            sessionStorage.fonts = true;
                    }
            });
       ', View::POS_HEAD);
        ?>
        <div id="fb-root"></div>
        <div class="fb-customerchat" attribution=setup_tool page_id="383925102019276" theme_color="#00a0e3"></div>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
