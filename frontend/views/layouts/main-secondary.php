<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppSecondaryAssets;

$userType = explode('/', Yii::$app->request->url)[2];
AppSecondaryAssets::register($this);
$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language; ?>">
    <head>
        <meta charset="<?= Yii::$app->charset; ?>">
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode((!empty($this->title)) ? Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name : Yii::$app->params->site_name); ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
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
                    'href' => Url::to($value,'https'),
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
        }
        ?>
        <?php $this->head(); ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>
    <div id="wrapper" class="clearfix">
        <div class="main-content">
            <section id="home" class="divider parallax fullscreen layer-overlay overlay-white-9"
            ">
            <div class="display-table">
                <div class="display-table-cell">
                    <div class="container">
                        <div class="row">
                            <div class="<?= (isset($this->params['grid_size']) ? $this->params['grid_size'] : 'col-md-6 col-md-push-3'); ?>">
                                <div class="text-center col-md-12 mb-60">
                                    <a href="/">
                                        <img width="275px" alt="<?= Yii::$app->params->site_name; ?>"
                                             src="<?= Url::to('@commonAssets/logos/logo.svg'); ?>">
                                    </a>
                                </div>
                                <?= $content; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ($userType == "organization") {
                ?>
                <div class="pos-abso-individual">
                    <div class="pai-rel">
                        <div class="pai-abso">
                            I Want To Get Hired
                            <div class="pai-button">
                                <a class="btn btn-dark btn-lg btn-block no-border hvr-float main-orange-btn"
                                   href="<?= Url::to('/signup/individual'); ?>"
                                   data-bg-color="#ff7803"><?= Yii::t('frontend', 'Signup as Individual'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } elseif ($userType == "individual") {
                ?>
                <div class="pos-abso-individual">
                    <div class="pai-rel">
                        <div class="pai-abso">
                            I Want To Hire
                            <div class="pai-button">
                                <a class="btn btn-dark btn-lg btn-block no-border hvr-float main-orange-btn"
                                   href="<?= Url::to('/signup/organization'); ?>"
                                   data-bg-color="#ff7803"><?= Yii::t('frontend', 'Signup as Organization'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            </section>
        </div>
    </div>
    <?php
    $bg_img = (isset($this->params['background_image']) && !empty($this->params['background_image'])) ? $this->params['background_image'] : '/assets/themes/ey/images/backgrounds/lco_bg.jpg';
    $this->registerCss('
        /*---new css---*/
        .pai-button{
            margin-top:10px;
        }
        .pai-rel{
            position:relative;
            height:150px;
        }
        .pai-abso{
            position:absolute;
            top:50%;
            left:50%;
            transform: translate(-50%, -50%);
        }
        .pos-abso-individual{
            position:fixed;
            bottom:0px;
            right:0px;
            height:150px;
            width:200px;
            background: rgba(0,0,0,.1);
            box-shadow:0 0 10px rgba(0,0,0,.3);
            z-index:9;
            text-align:center;
            border-radius:10px 0 0 0;
            color:#000;
            font-family:roboto;
            font-size:18px;
            
            animation: SlideUp 4s;
            animation-delay:2s
        }
        @keyframes SlideUp{
            from{bottom:-200px}
            to{bottom:0px}
        }
        
        /*---new css ends---*/
        body{
            background-image: url( ' . $bg_img . ' );
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
        .display-table {
            display: table;
            height: 100%;
            position: relative;
            width: 100%;
            z-index: 1;
        }
        .display-table-cell {
            display: table-cell;
            height: 100%;
            vertical-align: middle;
        }
        .layer-overlay::before {
            background: rgba(17, 17, 17, 0.5) none repeat scroll 0 0;
            content: " ";
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 0;
        }
        .layer-overlay.overlay-white-9::before {
            background-color: rgba(255, 255, 255, 0.9);
        }
        .form-control {
            border-radius: 0;
            height: 45px;
        }
        .divider .container {
            padding-top: 70px;
            padding-bottom: 70px;
        }
        .separator {
            line-height: 1.2em;
            margin: 30px auto;
            overflow: hidden;
            text-align: center;
            width: 100%;
        }
        .separator i, .separator span, .separator a {
            display: inline-block;
            margin: 0 20px 0 24px;
            font-size: 20px;
        }
        .no-border {
            border: none !important;
        }
        .main-orange-btn, .main-blue-btn {
            width: 100%;
            color: #ffffff;
            border: 0px;
            background: #ff7803 !important;
            margin-bottom: 20px;
            -webkit-border-radius: 6px !important;
            -moz-border-radius: 6px !important;
            -ms-border-radius: 6px !important;
            -o-border-radius: 6px !important;
            border-radius: 6px !important;
        }
        .main-blue-btn {
            background: #00a0e3 !important;
        }
        .main-orange-btn:hover, .main-orange-btn:focus , .main-blue-btn:hover, .main-blue-btn:focus {
            color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,.5) !important;
            border: 0px;
            transition: .3s all;
            -webkit-transition: .3s all;
            -moz-transition: .3s all;
            -ms-transition: .3s all;
            -o-transition: .3s all;
        }
        .btn {
            font-size: 13px;
            padding: 12px 22px;
        }
        .hvr-float {
            display: inline-block;
            vertical-align: middle;
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            box-shadow: 0 0 1px rgba(0,0,0,0);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -moz-osx-font-smoothing: grayscale;
            -webkit-transition-duration: .3s;
            transition-duration: .3s;
            -webkit-transition-property: transform;
            transition-property: transform;
            -webkit-transition-timing-function: ease-out;
            transition-timing-function: ease-out;
        }
        .hvr-float:active, .hvr-float:focus, .hvr-float:hover {
            -webkit-transform: translateY(-8px);
            transform: translateY(-8px);
        }
        .separator::before, .separator::after {
            border-bottom: 1px solid #eee;
            content: "";
            display: inline-block;
            height: .65em;
            margin: 0 -4px 0 -100%;
            vertical-align: top;
            width: 50%;
        }
        .separator::after {
            margin: 0 -100% 0 0;
        }
        .text-black {
            color: #000 !important;
        }
        #home {
            min-height:100vh !important;
            height: auto !important;
            position: relative;
        }');

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
    ?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>