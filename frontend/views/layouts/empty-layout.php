<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use frontend\assets\AppAssets;
use frontend\widgets\login;

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
</head>
<body class="fullwidth-page">
<?php $this->beginBody(); ?>
<div class="body-overlay"></div>
<div id="wrapper" class="clearfix">
    <div class="main-content">

        <?= $content; ?>
    </div>

</div>
<?php
$this->registerCss('

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
if (Yii::$app->user->isGuest) {
    $this->registerJs('
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
    ');
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
//$(".page-loading").fadeOut();
var thispageurl = window.location.pathname;
$(".ey-menu-inner-main .ey-header-item-is-menu a").each(function(){
    var attr = $(this).attr("href");
      if (attr === thispageurl) {
        $(this).next(".ey-sub-menu").addClass("ey-active-menu");
        $(this).children("i").css("display", "none");
      }
});
$(".ey-sub-nav-items > li > a").each(function(){
    var attr = $(this).attr("href");
      if (attr === thispageurl) {
        $(this).parentsUntil(".ey-sub-menu").parent().addClass("ey-active-menu");
        return false;
      }
});

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

