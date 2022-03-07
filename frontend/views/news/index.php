<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'News';
$keywords = 'Get Latest and Breaking News Updates of India and world, live world and India news headlines, and Read all latest India and world news & top news on Empower Youth.
breaking news updates in hindi,breaking news updates india, 24/7 latest breaking news update,www breaking news,News Updates.';
$description = 'Empower Youth News: Get Latest and Breaking News Updates of world';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/themes/ey/images/pages/landing/news_update.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::to(Yii::$app->request->url,'https'),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Url::to(Yii::$app->request->url,'https'),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>

    <Section class="news-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <h1 class="get-latest">Get Latest News Updates</h1>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="get-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/news-update/news2.png'); ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </Section>
    <section>
        <div class="container">
            <div class="row">
                <div class="loader_screen">
                    <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
                </div>
                <div id="news_cards">

                </div>
                <div class="align_btn">
                    <button id="loader" class="btn btn-success">Load More</button>
                </div>
            </div>
        </div>
    </section>


    <!--Subscribe Widget start-->
<?php
if (Yii::$app->user->isGuest) {
    echo $this->render('/widgets/subscribe-section');
}
?>
    <!--Subscribe Widget ends-->

<?php
echo $this->render('/widgets/mustache/news-card');
$this->registerCss('
.loader_screen img
{
display:none;
margin:auto
}
.align_btn {
    text-align: center;
    clear: both;
}
');
$script = <<< JS
var offset = 0;
$(document).on('click','#loader',function(e) {
  e.preventDefault();
  fetchNews(template=$('#news_cards'),limit_dept=9,offset = offset+9,loader=false,loader_btn=true);
})
fetchNews(template=$('#news_cards'),limit_dept=9,offset=0,loader=true,loader_btn=false);


JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);