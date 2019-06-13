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

$image = Yii::$app->params->upload_directories->quiz->background->image . '/' . $quiz['sharing_image_location'] . '/' . $quiz['sharing_image'];

$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth__',
        'twitter:creator' => '@EmpowerYouth__',
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

    <div class="quiz-main">
        <div class="fade-bg-inner"></div>
        <div id="quiz"></div>
    </div>
    <input type="hidden" id="quest-path" value="<?= Yii::$app->params->upload_directories->quiz->question->image; ?>">
<?php
$this->registerCss('
body{
    background: url('. Yii::$app->params->upload_directories->quiz->background->image . '/' . $quiz['background_image_location'] . '/' . $quiz['background_image'] .');
    background-size: 100% 100%;
    background-attachment: fixed;
    background-repeat: no-repeat;
}
');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
$script = <<<JS
    $(function() {
      $('#quiz').quiz(window.location.href);
    });
JS;
$this->registerJs($script);
$this->registerCssFile('');
$this->registerJs("");