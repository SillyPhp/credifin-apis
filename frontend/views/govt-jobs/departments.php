<?php
$this->params['header_dark'] = True;
$current_date = date('d M Y');
$current_year = date('Y');
$total_govt_jobs = count($all_govt_jobs);

use yii\helpers\Url;
$this->title = 'Find '.$total_govt_jobs. ' Government Jobs Vacancies. Updated on '. $current_date;
$keywords = ' latest notifications, latest notifications for government jobs, Gov. jobs '.$current_year.', government jobs '.$current_year.', latest government jobs, Latest Gov. Jobs '.$current_year.', Government Jobs Notifications';
$description = 'Apply Online For latest '.$total_govt_jobs.' Government Jobs '.$current_year.'. Also Get all the latest updates, job alerts of Private jobs and USA Government jobs.';
$image = Yii::$app->urlManager->createAbsoluteUrl('assets/themes/ey/images/pages/jobs/indian-govt-job.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl("https"),
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
        'og:url' => Yii::$app->request->getAbsoluteUrl("https"),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>

    <section>
        <div class="container">
            <div class="row">
                <div class="heading-style">All Departments</div>
            </div>
            <div class="row">
                <div class="loader_screen">
                    <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
                </div>
                <div id="departments_cards">

                </div>
                <div class="align_btn">
                    <button id="loader" class="btn btn-success">Load More</button>
                </div>
            </div>
        </div>
    </section>

<?php
echo $this->render('/widgets/mustache/departments_govt');
$script = <<< JS
var offset = 0;
$(document).on('click','#loader',function(e) {
  e.preventDefault();
  fetchDepartments(template=$('#departments_cards'),limit_dept=40,offset = offset+40,loader=false,loader_btn=true);
})
fetchDepartments(template=$('#departments_cards'),limit_dept=40,offset=0,loader=true,loader_btn=false);
JS;
$this->registerJs($script);
$this->registerCss("
.loader_screen img
{
display:none;
margin:auto
}");
