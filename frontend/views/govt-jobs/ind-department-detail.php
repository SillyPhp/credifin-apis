<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

$separator = Yii::$app->params->seo_settings->title_separator;
$this->title = $data['Value'];
$keywords = $data["Value"] . ' Recruiment 2020,' . $data["Value"] . ' Jobs, Apply online for latest ' . $data["Value"] . ' jobs, online Exam across India, relationship executive, manager, assistant & Deputy manager.Get latest ' . $data["Value"] . ' online notifications, clerk, special Latest ' . $data["Value"] . ' jobs vacancies updated on ' . date("d-M-Y") . ', ' . $data["Value"] . ' jobs, ' . $data["Value"] . ' recruitment, ' . $data["Value"] . ' vacancies,' . $data["Value"] . ' Jobs,' . $data["Value"] . ' vacancies,' . $data["Value"] . 'careersc';
$description = '' . $data["Value"] . ' Recruiment 2020,' . $data["Value"] . ' Jobs, Apply online for latest ' . $data["Value"] . ' jobs, online Exam across India, relationship executive, manager, assistant & Deputy manager.Get latest ' . $data["Value"] . ' online notifications, clerk, special Latest ' . $data["Value"] . ' jobs vacancies updated on ' . date("d-M-Y") . ',' . $data["Value"] . ' jobs, ' . $data["Value"] . ' recruitment, ' . $data["Value"] . ' vacancies,' . $data["Value"] . ' Jobs,' . $data["Value"] . ' vacancies,' . $data["Value"] . 'careersc';
$this->title = $data['Value'] . " Jobs";
$keywords = $data["Value"] . ' Recruitment 2020,' . $data["Value"] . ' Jobs, Apply online for latest ' . $data["Value"] . ' jobs, online Exam across India, relationship executive, manager, assistant & Deputy manager.Get latest ' . $data["Value"] . ' online notifications, clerk, special Latest ' . $data["Value"] . ' jobs vacancies updated on ' . date("d-M-Y") . ', ' . $data["Value"] . ' jobs, ' . $data["Value"] . ' recruitment, ' . $data["Value"] . ' vacancies,' . $data["Value"] . ' Jobs,' . $data["Value"] . ' vacancies,' . $data["Value"] . 'careers';
$description = '' . $data["Value"] . ' Recruitment 2020,' . $data["Value"] . ' Jobs, Apply online for latest ' . $data["Value"] . ' jobs, online Exam across India, relationship executive, manager, assistant & Deputy manager.Get latest ' . $data["Value"] . ' online notifications, clerk, special Latest ' . $data["Value"] . ' jobs vacancies updated on ' . date("d-M-Y") . ',' . $data["Value"] . ' jobs, ' . $data["Value"] . ' recruitment, ' . $data["Value"] . ' vacancies,' . $data["Value"] . ' Jobs,' . $data["Value"] . ' vacancies,' . $data["Value"] . 'careers';
$image = Yii::$app->urlManager->createAbsoluteUrl($data['logo']);
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
    <div class="head-img"></div>
    <section>
        <div class="container">
            <div class="row">
                <div class="department">
                    <div class="depart-logo">
                        <?php if ($data['logo']): ?>
                            <img src="<?= $data['logo'] ?>" class="img_logo">
                        <?php else: ?>
                            <canvas class="user-icon" name="<?= $data['Value'] ?>" width="100" height="100"
                                    color="" font="60px"></canvas>
                        <?php endif; ?>
                    </div>
                    <div class="depart-name"><?= $data['Value'] ?></div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Jobs</div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="loader_screen">
                    <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
                </div>
                <div id="cards">
                </div>
                <div class="align_btn">
                    <button id="loader" class="btn btn-success">Load More</button>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" name="dept_id" id="dept_id" value="<?= $data['dept_enc_id']; ?>">
<?php
echo $this->render('/widgets/mustache/application-card-bk');
$this->registerCss('
.application-card-main
{
height:210px;
}
.align_btn
{
text-align:center;
clear:both;
}
.head-img{
    background: url(\'/assets/themes/ey/images/pages/blog/govdept-hdr.png\');
    min-height: 435px;
    background-size: cover;
    background-repeat: no-repeat;
}
.department {
    margin-top: -75px;
    display:flex;
}
.depart-logo {
    display: inline-block;
    width: 104px;
    height: 104px;
    border:2px solid #eee;
    text-align: center;
    margin-left:10px;
    background:#fff;
}
.depart-logo img {
    height: 100px;
    width: 100px;
}
.depart-name {
    display: inline-block;
    font-size: 22px;
    font-family: roboto;
    font-weight: 700;
    padding: 60px 10px 0px 8px;
    text-transform: uppercase;
}
.loader_screen img
{
display:none;
margin:auto
}
@media (max-width:415px){
.depart-name{
    font-size:15px;
    padding: 53px 10px 0px 8px;  
    }
}
.application-card-img {
    margin-left: 0px;
    margin-top: 30px;
}
.application-card-description {
    margin: 20px 0 0 15px !important;
}
');
echo $this->render('/widgets/mustache/govt-jobs-card');
$script = <<< JS
var dept_id = $('#dept_id').val();
$(document).on('click','#loader',function(e) {
  e.preventDefault();
  fetchDeptData(template=$('#cards'),limit,offset+12,dept_id,loader=false,loader_btn=true);
})
var limit =12;
var offset = 0;
fetchDeptData(template=$('#cards'),limit,offset,dept_id,loader=true,loader_btn=false);
JS;

$this->registerJs($script);