<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use frontend\assets\AppAssets;
use frontend\widgets\login;
use frontend\widgets\upcomingWebinar;

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
        <?php if (Yii::$app->user->isGuest): ?>
            <script src="https://accounts.google.com/gsi/client" async defer></script>
        <?php endif; ?>
        <link rel="icon" href="<?= Url::to('/favicon.ico'); ?>">
        <?php if (Yii::$app->params->options->crawl) { ?>
            <meta name="robots" content="index"/>
        <?php } else { ?>
            <meta name="robots" content="noindex,nofollow"/>
            <meta name="googlebot" content="noindex,nofollow">
        <?php }
        if (isset($this->params['seo_tags']) && !empty($this->params['seo_tags'])) {
            foreach ($this->params['seo_tags']['rel'] as $key => $value) {
                $this->registerLinkTag([
                    'rel' => $key,
                    'href' => Url::to($value, 'https'),
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
            if (!isset($this->params['header_dark'])) {
                $this->params['header_dark'] = false;
            }
        }
        ?>
        <?php $this->head(); ?>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "<?= Yii::$app->params->site_name; ?>",
            "url": "<?= Url::base("https"); ?>",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "<?= Url::to("/search?keyword={search_term_string}", "https"); ?>",
                "query-input": "required name=search_term_string"
            }
        }




        </script>
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
            window.OneSignal = window.OneSignal || [];
            OneSignal.push(function () {
                OneSignal.init({
                    appId: "a76531b8-a3c8-442b-a571-907e3e112de4",
                });
            });
            OneSignal.push(function () {
                <?php
                if(!Yii::$app->user->isGuest && !Yii::$app->user->identity->organization){
                $user_ens_id = Yii::$app->user->identity->user_enc_id;
                ?>
                    OneSignal.setExternalUserId('<?= $user_ens_id ?>');
                <?php
                }
                ?>
            });
        </script>
<!--        <script>-->
<!--        </script>-->
    </head>

    <body class="fullwidth-page">
    <?php $this->beginBody(); ?>
    <div class="body-overlay"></div>
    <div id="wrapper" class="clearfix">

        <header id="header" class="header">
            <?= (!$this->params['header_dark']) ? '<div id="main-header" class="header-nav navbar-fixed-top header-dark navbar-white navbar-transparent navbar-sticky-animated animated-active">' : ''; ?>
            <div id="header-main"
                 class="header-nav-wrapper <?= ($this->params['header_dark']) ? 'navbar-scrolltofixed bg-theme-colored border-bottom-theme-color-2-1px' : ''; ?>">


                <?php
                echo upcomingWebinar::widget();
                ?>


                <?php
                //            if (Yii::$app->user->isGuest && empty($this->params['sub_header'])) {
                if (Yii::$app->user->isGuest) {
                    ?>
                    <div class="secondary-top-header container-fluid">
                        <div class="secondary-top-header-left">
                            <span>
                                <i class="far fa-check-circle"></i> Post quick <a data-link="/jobs/quick-job"
                                                                                  data-target="#sign-up-benefit"><strong>Job</strong></a>or<a
                                        data-link="/internships/quick-internship"
                                        data-target="#sign-up-benefit"><strong>Internship</strong></a>
                            </span>
                            <span>
                                <i class="fab fa-twitter"></i> Post <a data-link="/tweets/job/create"
                                                                       data-target="#sign-up-benefit"><strong>Job</strong></a>or<a
                                        data-link="/tweets/internship/create" data-target="#sign-up-benefit"><strong>Internship Tweet</strong></a>
                            </span>
                        </div>

                        <div class="sign-up-modal" id="myModal">
                            <?= $this->render('/site/sign-up-modal') ?>
                        </div>

                        <div class="secondary-top-header-right">
                            <a href="/employers">Employer Zone</a>
                            <a href="/signup/organization" class="org-signup">Signup as Company</a>
                            <a href="/signup/individual">Signup as Candidate</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="ey-head-main">
                    <div class="container-fluid">
                        <div class="large-container container" style="padding: 0;">
                            <div class="ey-header-main">
                                <div class="ey-header-logo">
                                    <a class="ey-logo" href="/">
                                        <img id="logo-black" alt="<?= Yii::$app->params->site_name; ?>"
                                             src="<?= Url::to('@commonAssets/logos/logo.svg'); ?>">
                                        <?php
                                        if (!$this->params['header_dark']) {
                                            ?>
                                            <img id="logo-white" alt="<?= Yii::$app->params->site_name; ?>"
                                                 src="<?= Url::to('@commonAssets/logos/logo_white.svg'); ?>">
                                            <?php
                                        }
                                        ?>
                                        <!--                                    <span class="logo-beta">Beta</span>-->
                                    </a>
                                </div>
                                <div class="ey-menu-main">
                                    <?= $this->render('@common/widgets/top-header-beta', [
                                        'for' => 'Frontend',
                                        'data' => $this->params['sub_header']
                                    ]); ?>
                                </div>
                                <div class="ey-nav-actions">
                                    <div class="ey-menu-login">
                                        <?php
                                        if (!Yii::$app->user->isGuest) {
                                            $name = $image = $color = NULL;
                                            if (Yii::$app->user->identity->organization->organization_enc_id) {
                                                if (Yii::$app->user->identity->organization->logo) {
                                                    $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;
                                                }
                                                $name = Yii::$app->user->identity->organization->name;
                                                $color = Yii::$app->user->identity->organization->initials_color;
                                            } else {
                                                if (Yii::$app->user->identity->image) {
                                                    $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image;
                                                }
                                                $name = Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name;
                                                $color = Yii::$app->user->identity->initials_color;
                                            }
                                            ?>
                                            <?php Pjax::begin(['id' => 'pjax_profile_icon']); ?>
                                            <div class="my-profiles-sec">
                                                <?php if ($image) : ?>
                                                    <span><img src="<?= $image; ?>" title="<?= $name; ?>"
                                                               alt="<?= $name; ?>"/></span>
                                                <?php else : ?>
                                                    <span><canvas class="user-icon" name="<?= $name; ?>"
                                                                  color="<?= $color; ?>" width="40" height="40"
                                                                  font="20px"></canvas></span>
                                                <?php endif; ?>
                                            </div>
                                            <?php Pjax::end(); ?>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="javascript:;" data-toggle="modal" data-target="#loginModal">
                                                Log In
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ey-mobile-menu">
                    <div class="ey-mob-nav-main">
                        <div class="container-fluid">
                            <div class="container">
                                <div class="ey-mob-nav-items">
                                    <div class="ey-humburger-menu-main">
                                        <button id="open-mobile-menu" class="ey-humburger-menu" type="button"
                                                aria-expanded="false">
                                            <span aria-hidden="true"></span>
                                            <span aria-hidden="true"></span>
                                            <span aria-hidden="true"></span>
                                            <span aria-hidden="true"></span>
                                        </button>
                                    </div>
                                    <div class="ey-mobile-logo-main">
                                        <a class="ey-logo" href="/">
                                            <img src="<?= Url::to('@commonAssets/logos/logo.svg'); ?>"/>
                                        </a>
                                    </div>
                                    <div class="ey-mob-actions">
                                        <?php
                                        if (!Yii::$app->user->isGuest) {
                                            $name = $image = $color = NULL;
                                            if (Yii::$app->user->identity->organization->organization_enc_id) {
                                                if (Yii::$app->user->identity->organization->logo) {
                                                    $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;
                                                }
                                                $name = Yii::$app->user->identity->organization->name;
                                                $color = Yii::$app->user->identity->organization->initials_color;
                                            } else {
                                                if (Yii::$app->user->identity->image) {
                                                    $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image;
                                                }
                                                $name = Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name;
                                                $color = Yii::$app->user->identity->initials_color;
                                            }
                                            ?>
                                            <?php Pjax::begin(['id' => 'pjax_profile_icon']); ?>
                                            <div class="my-profiles-sec">
                                                <?php if ($image) : ?>
                                                    <span><img src="<?= $image; ?>" title="<?= $name; ?>"
                                                               alt="<?= $name; ?>"/></span>
                                                <?php else : ?>
                                                    <span><canvas class="user-icon" name="<?= $name; ?>"
                                                                  color="<?= $color; ?>" width="40" height="40"
                                                                  font="20px"></canvas></span>
                                                <?php endif; ?>
                                            </div>
                                            <?php Pjax::end(); ?>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="javascript:;" data-toggle="modal" data-target="#loginModal">
                                                Log In
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ey-mobile-content">
                        <div class="ey-mobile-menu-main-content">
                            <div class="ey-mobile-menu-inner-content">
                                <?= $this->render('@common/widgets/top-header-mobile', [
                                    'data' => $this->params['sub_header']
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= (!$this->params['header_dark']) ? '</div>' : ''; ?>
        </header>
        <div class="main-content">
            <div id="auth_loading_img">
            </div>
            <div class="auth_fader"></div>
            <?= $content; ?>
        </div>
        <footer id="footer" class="footer">
            <div class="footer-border"></div>
            <div class="set_container container">
                <div class="foot-bottom-border">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="foot-heading">Employers</div>
                            <div class="can-foot-list">
                                <ul>
                                    <li><a href="<?= "/account/jobs/create"; ?>">Post Job</a></li>
                                    <li><a href="<?= "/account/internships/create"; ?>">Post Internship</a></li>
                                    <li><a href="<?= "/tweets/job/create"; ?>">Post Job Tweet</a></li>
                                    <li><a href="<?= "/tweets/internship/create"; ?>">Post Internship Tweet</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="foot-heading">Candidates</div>
                            <div class="row footer-border-right">
                                <div class="col-md-4 ">
                                    <div class="can-foot-list">
                                        <ul>
                                            <li><a href="<?= "/jobs/near-me"; ?>">Jobs Near Me</a></li>
                                            <li><a href="<?= "/jobs/compare"; ?>">Compare Jobs</a></li>
                                            <li><a href="<?= "/tweets/jobs"; ?>">Tweet Jobs</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="can-foot-list">
                                        <ul>
                                            <li><a href="<?= "/internships/near-me"; ?>">Internships Near Me</a></li>
                                            <li><a href="<?= "/internships/compare"; ?>">Compare Internships</a></li>
                                            <li><a href="<?= "/tweets/internships"; ?>">Tweet Internships</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="can-foot-list">
                                        <ul>
                                            <li><a href="<?= "/reviews/companies"; ?>">Company Reviews</a></li>
                                            <li><a href="<?= "/reviews/colleges"; ?>">College Reviews</a></li>
                                            <li><a href="<?= "/reviews/schools"; ?>">School Reviews</a></li>
                                            <li><a href="<?= "/reviews/institutes"; ?>">Educational Institute
                                                    Reviews</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="foot-heading">Empower Youth</div>
                            <div class="can-foot-list">
                                <ul>
                                    <li><a href="<?= "/careers"; ?>">Careers</a></li>
                                    <li><a href="javascript:;" class="partnerWith">Partner With Us</a></li>
                                    <li><a href="javascript:;" class="giveFeedback">Feedback</a></li>
                                    <li><a href="<?= "/our-partners"; ?>">Our Partners</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="mt-6 col-sm-6 col-xs-12 col-md-3">

                        <div class="footer-widget ">
                            <div class="widget-title1 mb-10"><?= Yii::t('frontend', 'Connect With Us'); ?></div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="si-icons">
                                        <ul class="styled-icons icon-bordered icon-sm mb-5">
                                            <li><a href="https://www.facebook.com/empower" target="_blank"
                                                   class="overfb"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="https://twitter.com/EmpowerYouthin" target="_blank"
                                                   class="overtw"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="https://www.instagram.com/empoweryouth.in/" target="_blank"
                                                   class="overig"><i class="fab fa-instagram"></i></a></li>
                                            <li><a href="https://www.pinterest.com/empoweryouthin" target="_blank"
                                                   class="overpt"><i class="fab fa-pinterest"></i></a></li>
                                            <li><a href="https://www.linkedin.com/company/empoweryouth" target="_blank"
                                                   class="overlink"><i class="fab fa-linkedin-in"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="send_mail">
                                        <a class="" href="mailto:info@empoweryouth.com"><i
                                                    class="far fa-envelope mt-5 mr-5"></i>
                                            <span>info@empoweryouth.com</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="f-logo">
                            <a href="<?= "/"; ?>" title='Empower Youth'>
                                <img src="<?= Url::to('/assets/common/logos/fg2.png') ?>" title='Empower Youth'
                                     alt="Empower Youth"/>
                            </a>
                        </div>
                        <div class="ftxt">Empowering youth and going beyond</div>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="app-btn">
                            <a href='https://play.google.com/store/apps/details?id=com.empoweryouth.app&hl=en'
                               title='Download Empower Youth App on Google Play' target="_blank">
                                <img alt='Get it on Google Play'
                                     src='https://play.google.com/intl/en/badges/images/generic/en_badge_web_generic.png'
                                     title='Download Empower Youth App on Google Play'/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container pt-20 pb-20">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 footer-bottom-links">
                            <a href="<?= Url::to('/terms-conditions'); ?>">
                                Terms &amp; Conditions
                            </a>
                            <a href="<?= Url::to('/privacy-policy'); ?>">
                                Privacy Policy
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-12 text-right">
                            <p class="font-11 copyright-text"><?= Yii::t('frontend', 'Copyright') . ' &copy; ' . date('Y') . ' ' . Yii::$app->params->site_name . ' ' . Yii::t('frontend', 'All Rights Reserved') . '.'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <?php
        if (!Yii::$app->user->isGuest) {
            echo $this->render('/widgets/user-profile-sidebar-right');
        } elseif (Yii::$app->user->isGuest) {
            echo login::widget();
        }
        ?>
    </div>
    <script type="text/javascript">
        function handleCredentialResponse(response) {
            if (response.credential) {
                var token = parseJwt(response.credential);
                authLogin(token);
            } else {
                alert('Server Error');
            }

        }

        function parseJwt(token) {
            var base64Url = token.split('.')[1];
            var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            var jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));

            return JSON.parse(jsonPayload);
        };

        function authLogin(token) {
            $.ajax({
                url: '/site/one-tap-auth',
                method: 'POST',
                data: {
                    token: token,
                    returnUrl: returnUrl
                },
                beforeSend: function (e) {
                    $('#auth_loading_img').addClass('show');
                    $('.auth_fader').css('display', 'block');
                },
                success: function (e) {
                    $('#auth_loading_img').removeClass('show');
                    $('.auth_fader').css('display', 'none');
                    if (response.status == 201) {
                        toastr.error(response.message, response.title);
                    }
                },
                complete: function () {
                    $('#auth_loading_img').removeClass('show');
                    $('.auth_fader').css('display', 'none');
                }
            })
        }
    </script>
    <?php
    $this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerCss('
    .upcoming-webinar{
        width: 100%;
        background: #1F1F1F;
        display: flex;
        position: relative;
        margin-top:-39px;
        // top: 0;
        z-index: 20;
      }
      .upcoming-webinar .container-fluid{
          padding-top: 0 !important;
          width: 100%;
      }
      .upcoming-webinar .row{
        display: flex;
      }
      .webinar-heading{
        text-transform: capitalize;
        font-family: lora;
        font-weight: 700;
        font-size: 22px;
        line-height: 28px;
        color: #FFDF39;
        display: flex;
        align-items: center;
        height: 100%;
      }
      .webinar-name{
        font-family: Lobster;
        font-style: normal;
        font-weight: normal;
        font-size: 22px;
        text-align: center;
        color: #FFFFFF;
        background-repeat: no-repeat;
        background-size: 100% 100%;
        height: 100%;
        letter-spacing: 1.3px;
      }
      .view-btn{
        background: linear-gradient(91.16deg, #FFBB54 -43.72%, #CB650C 125.14%, #DB7E2E 125.14%);
        border-radius: 27px;
        color: #fff;
        padding: 2px 13px;
        display: block;
        margin-left: auto;
        width: fit-content;
        letter-spacing: 0.5px;
      }
      .view-detail{
        display: flex;
        align-items: center;
        height: 100%;
      }
      .view-btn:hover{
        text-decoration: none;
        color: #fff;
        opacity: 0.9;
      }
      
      @media only screen and (max-width: 767px){
          .webinar-heading{
              font-size: 19px;
          }
        .upcoming-webinar .row{
          display: block;
        }
        .webinar-name{
          background: none;
        }
        .upcoming-webinar{
          //background: url(' . Url::to('https://user-images.githubusercontent.com/72601463/133765334-22ac93c4-167b-4f7a-b145-11caa4175341.png') . '), #0e1c3d;
          background-repeat: no-repeat;
          background-size: 100% 100%;
          display: block;
          text-align: center;
        }
        .view-btn{
          margin: 10px auto;
        }
        .webinar-heading{
          justify-content: center;
        }
      }


#auth_loading_img
{
  display:none;
}
 
#auth_loading_img.show
{
   z-index:100;
   position: fixed;
    opacity: 1;
    top: 50%;
    left: 50%;
    right: 0;
    border: 6px solid #fff;
    border-radius: 50%;
    border-top: 6px solid #00a0e3;
    width: 60px;
    height: 60px;
   -webkit-animation: spin 2s linear infinite;
  animation: spin 1.2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.auth_fader{
  width:100%;
  height:100%;
  position:fixed;
  top:0;
  left:0;
  display:none;
  z-index:99;
  background-color:#fff;
  opacity:0.7;
}
.footer-bottom-links a{
    color:#fff;
    margin-right: 20px;
    font-size: 12px;
    display: inline-block;
    width: auto !important;
    margin-top: 7px;
}
.footer-bottom-links a:hover{
    color:#c7c7c7;
}
.foot-heading{
    font-family: lora;
    font-size:20px;
    color:#fff;
    text-align:center;
}
.can-foot-list ul li a:hover{
    color:#00a0e3;
}
.no-padd{
    padding-left:0px;
    padding-right:0px;  
}
.footer-border-right{
    border-right:1px solid rgba(92, 94, 95, .3);
    border-left:1px solid rgba(92, 94, 95, .3);
}
.can-foot-list ul{
    padding-inline-start: 00px;
    text-align:center;
    padding-top:10px;
}
.can-foot-list ul li a{
    color: #cecece;
    text-align:center;
}
.foot-bottom-border{
    border-bottom: 1px solid rgba(92, 94, 95, .3);
    padding:20px 0 60px 0;
    margin-bottom:50px;
}

.si-icons{
    width:100%;
}
.f-logo{
    text-align:center;
    margin-top:15px;
}
.f-logo img{
    max-width:330px;
}
.ftxt{
     margin-top: 0px;
    text-transform: capitalize;
    text-align: center;
    font-family: lora;
    font-size: 21px;
}
.app-btn{
    max-width:250px;
}
.ql{
    padding-top:20px;
    padding-bottom:10px;
    padding-inline-start: 00px;
}
.ql li{
    display:inline;
    color:#fff !important;
}
.ql li a:hover{
    color:#00a0e3;
}
.qb{
    margin-top:5px;
}
.qb li{
    display:inline;
}
.quick-links{
    padding-top:0px;
}
.quick-btns{
    padding-top:10px;
}
.subscribe-btn, .dr-btn, .career-btn{
    padding: 6px 10px;
    border: 2px solid #00a0e3;
    border-radius: 5px;
    color: #00a0e3 !important;
    text-transform: uppercase;
}
.subscribe-btn:hover, .dr-btn:hover, .career-btn:hover{
     border: 2px solid #00a0e3;
    color: #fff !important;
    background: #00a0e3;
    transition:.2s all;
}

.secondary-top-header{
    height:32px;
//    margin-top:-34px;
    margin-top:-2px;
    line-height: 30px;
    display: block;
    transition: margin 500ms;
    background-color: rgba(0, 0, 0, 0.4);
}
.header-show .secondary-top-header{
//    margin-top: -2px;
}
.header-show .upcoming-webinar{
    margin-top: -2px !important;
}
.animated-active .header-show .secondary-top-header{
    background-color: rgba(0, 0, 0, 0.2);
}
.secondary-top-header-left, .secondary-top-header-right{
    width:auto;
}
.secondary-top-header-left{padding-left:0;float:left;}
.secondary-top-header-left a i, .secondary-top-header-left span i{font-size:16px;}
.secondary-top-header-left a, .secondary-top-header-left span{margin:5px;}
.secondary-top-header-left span:first-child{margin-left:0px;}
.secondary-top-header-left span a{font-weight:500;}
.secondary-top-header-right{padding-right:0px;float:right;}
.upcoming-webinar, .secondary-top-header a, .secondary-top-header span, .secondary-top-header-left *{
    color:#fff;
    transition: all 500ms;
}
.secondary-top-header-right a{
    float: right;
    height: 32px;
    line-height: 32px;
    padding: 0px 10px;
    margin-left: 5px;
}
.secondary-top-header a:hover, .secondary-top-header a:hover *{color:#ff7803 !important;}
@media screen and (max-width: 610px) and (min-width: 0px) {
    .secondary-top-header-left{padding-left: 20px;}
}
@media screen and (max-width: 571px) and (min-width: 0px) {
    .secondary-top-header-right{padding-right:15px;}
    .secondary-top-header-left{padding-left: 10px;}
    .secondary-top-header-right a{padding:0px 5px;}
    .org-signup{display:none;}
    .upcoming-webinar{
        display: none;
    }
}
@media screen and (max-width: 1090px) and (min-width: 0px) {
    .secondary-top-header-left{padding-left: 0px;}
}
@media screen and (max-width: 1015px) and (min-width: 0px) {
    .secondary-top-header-left{display:none;}
}
.secondary-top-header-right a:first-child{
    background-color: #f07704;
}
.secondary-top-header-right a:first-child:hover{
    color:#fff !important;
    background-color: #dc6b00;
}
.send_mail{
    word-wrap: break-word;
    display:block;
    padding-top:15px;
    color:#fff;
}
.send_mail span{
    color:#fff;
}
.send_mail i{
    color:#00a0e3;
}
.send_mail span:hover{
    color:#00a0e3 !important;
    transition:.3s all;
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
@media screen and (max-width: 900px) and (min-width: 0px) {
    .my-profiles-sec span{
        margin-top:1px !important;
    }
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
    background:#333 !important;
    color:#fff !important;
} 
.footer-widget{
    margin: 0 auto;
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
    transform:rotate(360deg);
    transition:1s all;  
    border-radius:20px;
}
.styled-icons.icon-bordered a { 
   border: 2px solid #00a0e3;
   border-radius:5px;
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
@media only screen and (max-width: 768px){
    .footer-widget {
        text-align:center;
    }
    .app-btn{
        margin:0 auto;
    }
    .f-logo img{
        margin:40px 0 0 0;
        width:100%;
    }
}
@media (max-width: 992px) and (min-width: 768px){
    .view-btn{
        font-size: 13px;
    }
    .webinar-heading{
        font-size: 19px;
    }

}
');

    if ($this->params['header_dark']) {
        $this->registerCss('@media only screen and (max-width:900px){
                .header {
                    max-height:80px !important;
                }
            }
            .fullwidth-page > #wrapper.clearfix > .main-content{
                padding-top:20px;
            }
            ');
    }

    $this->registerJs("
        let winWidth = screen.width;
        
        if(winWidth <= 500){
            showWebinarBox();
        }
        function showWebinarBox(){
            $.ajax({
                url: '/webinars/upcoming-webinar-box',
                method: 'POST',
                data: {'" . Yii::$app->request->csrfParam . "':'" . Yii::$app->request->csrfToken . "'},
                success: function(response) {
                    $('body').append(response);
                }
            })
        }
    ");
    if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->organization) {
        $this->registerJs("
        function getCookie(name){
            var re = new RegExp(name + '=([^;]+)');
            var value = re.exec(document.cookie);
            return (value != null) ? unescape(value[1]) : null;
        }  
        function openUserDetailsModal(){
            let cookieVal = getCookie('ModalisViewed'); 
            if(cookieVal == 'modalViewed'){
                let date = new Date();
                date.setTime(date.getTime() + (1 * 24 * 60 * 60 * 1000));
                let jdate = date.toUTCString()
                const expires = 'expires=' + date.toUTCString();
                document.cookie='ModalisViewed='+jdate+'; expires='+expires+'; path=/'
            }
            if (document.cookie.indexOf('ModalisViewed') != -1) {
                return false; 
            }
            let userModal = document.getElementById('completeProfileModal')
                if(userModal != null){
                    $('#completeProfileModal').modal('show');
                    return false;
                }                 
            $.ajax({
                url: '/account/resume-builder/user-detail-modal',
                method: 'Post',
                data:  {'" . Yii::$app->request->csrfParam . "':'" . Yii::$app->request->csrfToken . "'},
                success: function(response){
                    $('body').append(response);
                    $('#completeProfileModal').modal('show');
                }
            });
         }
          
//        window.setTimeout(function(){
//            openUserDetailsModal();
//        },1000); 
               
         function openPreferenceModal(){
            let hasCookie = document.cookie;
            if (document.cookie.indexOf('PreferenceisViewed') != -1) {
                return false; 
            }
            
            let preferenceModal = document.getElementById('preferenceLocation');
            if(preferenceModal != null){
                $('#preferenceLocation').modal('show');
                return false;
            }   
            
            $.ajax({
                url: '/account/resume-builder/user-preference-modal',
                method: 'Post',
                data: {'" . Yii::$app->request->csrfParam . "':'" . Yii::$app->request->csrfToken . "'},
                success: function(response) {
                    $('body').append(response);
                    $('#preferenceLocation').modal('show');
                }
            })
         }
         
      
        ");
    }


    if (!empty(Yii::$app->params->google->analytics->id)) {
        $this->registerJsFile('https://www.googletagmanager.com/gtag/js?id=' . Yii::$app->params->google->analytics->id, [
            'depends' => [\yii\web\JqueryAsset::className()],
            'sync' => 'async',
        ]);

        $this->registerJs('
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag("js", new Date());
            gtag("config", "' . Yii::$app->params->google->analytics->id . '");        
        ');
    }

    if (!empty(Yii::$app->params->facebook->pixel->id)) {
        $this->registerJs('
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version="2.0";
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,"script",
            "https://connect.facebook.net/en_US/fbevents.js");
            fbq("init", "' . Yii::$app->params->facebook->pixel->id . '");
            fbq("track", "PageView");
        ');
    }

    if (Yii::$app->user->isGuest) {
        Yii::$app->view->registerJs('var returnUrl = "' . Yii::$app->request->url . '"', \yii\web\View::POS_HEAD);
    }
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
    $this->registerJs('
    let s_height = $(".upcoming-webinar").height() + 2;
    $(".upcoming-webinar").css("margin-top","-" + s_height + "px")
    window.addEventListener("scroll", header_main);
        var lastScrollTop = 50;
        function header_main() {
            var h_element = $(".ey-mobile-content");
            var st = $(this).scrollTop();
            var check_h_type = document.getElementById("header-main");
            if(st > lastScrollTop || h_element.hasClass("ey-mobile-show")) {
                check_h_type.classList.remove("header-show");
            } else {
                check_h_type.classList.add("header-show");
            }
            lastScrollTop = st;
        }
        header_main();
//$(".page-loading").fadeOut();
var thispageurl = window.location.pathname;
var hasAccessForSubHeader = true;
var preventHeaderFor = ["/mentors/webinar-view","/mentors/webinar-live","/jobs/list","/internships/list","/jobs/compare","/internships/compare","/jobs/near-me","/internships/near-me"];
for(var jj = 0;jj<preventHeaderFor.length;jj++){
    if(thispageurl == preventHeaderFor[jj]){
        hasAccessForSubHeader = false;
    }
}
$(".ey-menu-inner-main .ey-header-item-is-menu a").each(function(){
    var attr = $(this).attr("href");
      if (attr === thispageurl && hasAccessForSubHeader) {
        $(this).next(".ey-sub-menu").addClass("ey-active-menu");
        $(this).children("i").css("display", "none");
      }
}); 
$(".ey-sub-nav-items > li > a").each(function(){
    var attr = $(this).attr("href");
      if (attr === thispageurl && hasAccessForSubHeader) {
        $(this).parentsUntil(".ey-sub-menu").parent().addClass("ey-active-menu");
        return false;
      }
});
if(!hasAccessForSubHeader){
    $(".upcoming-webinar").css("display","none");
}


$(document).on("click", ".partnerWith", function(e){
    e.preventDefault();
    var elem = "<div class=\'partner-main\'></div>";
    $("body").append(elem);
    $(".partner-main").load("/site/partner-with-us");
});
$(document).on("click", ".giveFeedback", function(e){
    e.preventDefault();
    var elem = "<div class=\'feedback-main\'></div>";
    $("body").append(elem);
    $(".feedback-main").load("/site/send-feedback");
});
');
    ?>
    <?php $this->endBody(); ?>
    </body>

    </html>
<?php $this->endPage(); ?>