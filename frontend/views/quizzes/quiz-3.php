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

$image = Url::to(Yii::$app->params->upload_directories->quiz->sharing->image . $quiz['sharing_image_location'] . DIRECTORY_SEPARATOR . $quiz['sharing_image'], 'https');

$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
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
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>

    <div id="app-main-quiz" class="quiz-main">
        <div class="fade-bg-inner"></div>
        <div id="quiz"></div>
    </div>
    <input type="hidden" id="quest-path" value="<?= Yii::$app->params->upload_directories->quiz->question->image; ?>">
    <input type="hidden" id="quest-name" value="<?= $quiz['name'] ?>">
<?php
$this->registerCss('
body{
    background: url(' . Url::to(Yii::$app->params->upload_directories->quiz->background->image . $quiz['background_image_location'] . DIRECTORY_SEPARATOR . $quiz['background_image']) . ');
    background-size: 100% 100%;
    background-attachment: fixed;
    background-repeat: no-repeat;
}
@media screen and (max-width: 991px) {
    #elem-button-share-quiz-wa{display:none !important;}
}
@media screen and (min-width: 991px) {
    #elem-button-share-quiz-wa-mob{display:none !important;}
}
');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
$script = <<<JS
    $(function() {
      $('#quiz').quiz(window.location.href);
    });
JS;
$this->registerJs($script);
if($quiz['is_login'] == 1 && Yii::$app->user->isGuest) {
    echo $this->render('/widgets/login-required-modal');
}