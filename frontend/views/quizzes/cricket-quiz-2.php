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

if ($quiz['sharing_image']) {
    $sharing_image = Url::to(Yii::$app->params->upload_directories->quiz->sharing->image . $quiz['sharing_image_location'] . DIRECTORY_SEPARATOR . $quiz['sharing_image'], 'https');
} else {
    $sharing_image = Url::to('/assets/themes/quiz2/quizvol2.png', 'https');
}

$image = $sharing_image;

$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
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
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
    ],
];
?>
    <div class="fade-bg"></div>
    <div id="app-main-quiz" class="container">
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

if ($quiz['background_image']) {
    $background_image = Url::to(Yii::$app->params->upload_directories->quiz->background->image . $quiz['background_image_location'] . DIRECTORY_SEPARATOR . $quiz['background_image']);
} else {
    $background_image = Url::to('/assets/themes/quiz2/bg.png');
}


$this->registerCss('
body{
    background: url(' . $background_image . ');
    background-size: cover;
    background-attachment: fixed;
    background-repeat: no-repeat;
}
@media screen and (max-width: 991px) {
    body{
        background-size:100% 100%;
    }
}
');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
$this->registerJs("function fbs_click() {
    u = location.href;
    t = document.title;
    window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), 'sharer', 'toolbar=0,status=0,width=626,height=436');
    return false;
}");
if($quiz['is_login'] == 1 && Yii::$app->user->isGuest) {
    echo $this->render('/widgets/login-required-modal');
}