
<?php
use yii\helpers\Html;
use account\assets\AppAssets;
use yii\helpers\Url;
AppAssets::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="<?= Yii::$app->language; ?>">
<!--<![endif]-->
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <?= Html::csrfMetaTags(); ?>
    <link rel="icon" href="<?= Url::to('/favicon.ico'); ?>">
    <title><?= Html::encode((!empty($this->title)) ? Yii::t('account', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name : Yii::$app->params->site_name); ?></title>
    <?php $this->head(); ?>
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-md page-container-bg-solid">
<?php $this->beginBody(); ?>
<div class="wrapper">
    <header class="page-header">
        <nav class="navbar mega-menu" role="navigation">
            <div class="container-fluid">
                <div class="clearfix navbar-fixed-top">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="toggle-icon">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </span>
                    </button>
                    <div class="topbar-actions" style="width: 100%;position: relative;float: left;top:0;left:0;">
                        <div id="menuzord" class="menuzord">
                            <a style="position:relative;float: left;margin-top: 10px;" href="<?= Url::to('/'); ?>">
                                <img id="header-logo" alt="<?= Yii::$app->params->site_name; ?>"
                                     src="<?= Url::to('@commonAssets/logos/empower_youth_plus.svg'); ?>">
                                <span class="logo_beta">Beta</span>
                            </a>
                            <?php
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
                            <div class="my-profiles-sec">
                                <?php if ($image): ?>
                                    <span><img src="<?= $image; ?>" title="<?= $name; ?>"
                                               alt="<?= $name; ?>"/></span>
                                <?php else: ?>
                                    <span><canvas class="user-icon" name="<?= $name; ?>" color="<?= $color; ?>"
                                                  width="40" height="40" font="20px"></canvas></span>
                                <?php endif; ?>
                            </div>

                            <?=
                            $this->render('/widgets/common/header/top-header', [
                                'menu_class' => 'menuzord-menu'
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse">
                    <?= $this->render('/widgets/header/top-header'); ?>
                </div>
            </div>
        </nav>
    </header>
    <div class="container-fluid">
        <div class="page-content" style="padding-top:20px;">
            <div id="page-loading" class="page-loading">
                <img src="<?= Url::to('@eyAssets/images/loader/loader-main.gif'); ?>" alt="Loading..">
            </div>
            <?= $content; ?>
        </div>
        <p class="copyright"> <?= Yii::t('account', 'Copyright') . ' &copy; ' . date('Y') . ' ' . Yii::$app->params->site_name . ' ' . Yii::t('account', 'All Rights Reserved') . '.'; ?>
        </p>
    </div>
    <?php
    //        if (!Yii::$app->user->identity->organization) {
    echo $this->render('/widgets/common/sidebar/user-profile-sidebar-right');
    //        }
    ?>
</div>
<?php
echo $this->render('/widgets/chat/main');
$this->registerCss('
            .logo_beta{font-size: 11px;position: absolute;bottom: -2px;right: -15px;color: #fff;}
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
            #menuzord{
                background:transparent;
            }
            .menuzord-menu > li > a {
                padding: 8px 12px !important;
                font-weight:400 !important;
            }
            .logo-default{
                top:6px;
                left: 12px;
                position: absolute;
            }
            .page-header.navbar .menu-toggler.sidebar-toggler {
                float: left;
                margin: 0 0 0;
                position: absolute;
                z-index: 20;
            }
            .page-header.navbar .menu-toggler{
                opacity: 1 !important;
            }
            .list-unstyled li:first-child a{
                display: block;
            }
            .list-unstyled li a{
                display: block;
            }
            .page-sidebar .page-sidebar-menu>li>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li>a{
                color: #49a1e3 !important;
            }
            .page-sidebar, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover {
                background: #000 !important;
            }
            .page-sidebar .page-sidebar-menu>li>a>i[class*=icon-], .page-sidebar .page-sidebar-menu>li>a>i[class^=icon-], .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li>a>i[class*=icon-], .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li>a>i[class^=icon-] {
                color: #49a1e3 !important;
            }
            .page-sidebar .page-sidebar-menu .sub-menu>li:hover>a,.page-sidebar .page-sidebar-menu>li.open>a, .page-sidebar .page-sidebar-menu>li:hover>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li.open>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li:hover>a {
                background: #f08227 !important;
                color: #ffffff !important;
            }
            .page-sidebar .page-sidebar-menu .sub-menu>li:hover>a>i,.page-sidebar .page-sidebar-menu>li.open>a>.arrow.open:before, .page-sidebar .page-sidebar-menu>li.open>a>.arrow:before, .page-sidebar .page-sidebar-menu>li.open>a>i, .page-sidebar .page-sidebar-menu>li:hover>a>.arrow.open:before, .page-sidebar .page-sidebar-menu>li:hover>a>.arrow:before, .page-sidebar .page-sidebar-menu>li:hover>a>i, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li.open>a>.arrow.open:before, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li.open>a>.arrow:before, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li.open>a>i, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li:hover>a>.arrow.open:before, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li:hover>a>.arrow:before, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu>li:hover>a>i {
                color: #ffffff !important;
            }
            @media (min-width: 992px){
                .page-sidebar-menu-hover-submenu li:hover a>.arrow {
                    border-right: 8px solid #1d2737 !important;
                }
                .page-header-fixed .page-container{
                    margin-top: 50px !important;
                }
                .page-sidebar-menu-hover-submenu li:hover>.sub-menu {
                    background-color: #000 !important;
                }
                .top-menu{
                    width: 100%;
                }
            }
            @media (max-width: 990px){
                .top-menu{
                    width: 100%;
                }
            }
            @media (min-width: 992px){
                .page-sidebar-menu-hover-submenu li:hover>.sub-menu {
                    background-color: #000 !important;
                }
            }
            .page-sidebar .page-sidebar-menu .sub-menu>li.active>a, .page-sidebar .page-sidebar-menu .sub-menu>li.open>a, .page-sidebar .page-sidebar-menu .sub-menu>li:hover>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li.active>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li.open>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li:hover>a {
                background: #49a1e3!important;
            }
            .page-sidebar .page-sidebar-menu .sub-menu>li>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li>a {
                color: #49a1e3 !important;
            }
            .page-sidebar .page-sidebar-menu .sub-menu>li>a>i, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li>a>i {
                color: #49a1e3;
            }
            .page-sidebar .page-sidebar-menu .sub-menu>li.active>a, .page-sidebar .page-sidebar-menu .sub-menu>li.open>a, .page-sidebar .page-sidebar-menu .sub-menu>li:hover>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li.active>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li.open>a, .page-sidebar-closed.page-sidebar-fixed .page-sidebar:hover .page-sidebar-menu .sub-menu>li:hover>a {
                background: #f08228!important;
            }
            .page-header.navbar .page-top{
                height: 52px !important;
            }
            .page-header.navbar{
                min-height: 52px !important;
                height: 52px !important;
            }
            .page-header.navbar .menu-toggler.responsive-toggler {
                margin: 16px 14px 12px 6px !important;
            }
            .page-container-bg-solid .page-content {
                background: #eef1f5;
            }
            #header-logo{
                max-height:42px;
            }
            .profiles-sidebar .tree_widget-sec > ul{
                list-style: none;
                padding-left: 0px;
            }
            .tree_widget-sec > ul > li > a i{
                line-height: 41px !important;
            }
            .tree_widget-sec > ul > li > a:hover{
                text-decoration:none;
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
            .can-detail-s > p{
                margin-top: 10px !important;
            }
            .my-profiles-sec span{
                line-height:normal;
                margin-top:5px;
            }
        ');
$script = <<<JS
        jQuery("#menuzord").menuzord({
            align: "right",
        });
                
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        $(".page-loading").fadeOut();
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/functions.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->endBody();
?>
</body>
</html>
<?php $this->endPage(); ?>