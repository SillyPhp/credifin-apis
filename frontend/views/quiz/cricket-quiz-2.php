<?php

use yii\helpers\Url;


$this->title = $quiz['title'];

$keywords = $quiz['keywords'];

$description = $quiz['description'];

if (!empty($score) && !empty($total)) {
    if (($score >= 0 && $score <= 10) && ($total >= 0 && $total <= 10)) {
        $description = 'I scored ' . $score . ' out of ' . $total . '. Try Yours!!!. ' . $description;
    }
}

$sharing_image = null;

if($quiz['sharing_image']){
    $sharing_image = Yii::$app->params->upload_directories->quiz->background->image . '/' . $quiz['sharing_image_location'] . '/' . $quiz['sharing_image'];
}else{
    $sharing_image = Yii::$app->urlManager->createAbsoluteUrl('/assets/themes/quiz2/quizvol2.png');
}

$image = $sharing_image;

$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::canonical(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth2',
        'twitter:creator' => '@EmpowerYouth2',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Url::canonical(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
    ],
];
?>
    <div class="fade-bg"></div>
    <div class="container">
        <span class="sub-container" id="sub-container">
            <a href="/" style="max-width: 275px;display: block;margin: auto;border-radius: 0px;">
                <img src="<?= Url::to('@commonAssets/logos/logo.svg'); ?>" style="width: 100%;border-radius: 0px;"/>
            </a>
            <!-- Question container -->
            <div class="elem-div-question-container">
              <h1 id="elem-h1-question">
                Loading...
              </h1>
            </div>

            <!-- Progress bar container -->
            <div class="elem-div-progress-container">
              <progress id="elem-progress-bar" class="hidden"></progress>
              <small class="elem-small-progress-val" id="elem-small-progress-val"></small>
            </div>

            <!-- Answers container -->
            <div class="elem-div-answers-container" id="elem-div-answers-container">
                <div class="elem-div-loading-spinner"></div>
            </div>
    </div>

    <input type="hidden" id="quest-path" value="<?= Yii::$app->params->upload_directories->quiz->question->image; ?>">
    <input type="hidden" id="quest-name" value="<?= $quiz['name'] ?>">

<?php

$background_image = null;

if($quiz['background_image']){
    $background_image = Yii::$app->params->upload_directories->quiz->background->image . '/' . $quiz['background_image_location'] . '/' . $quiz['background_image'];
}else{
    $background_image = Yii::$app->urlManager->createAbsoluteUrl('/assets/themes/quiz2/bg.png');
}

$this->registerCss('
body{
    background: url('. $background_image .');
    background-size: 100% 100%;
    background-attachment: fixed;
    background-repeat: no-repeat;
}
');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
$this->registerJs("function fbs_click() {
    u = location.href;
    t = document.title;
    window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), 'sharer', 'toolbar=0,status=0,width=626,height=436');
    return false;
}");
