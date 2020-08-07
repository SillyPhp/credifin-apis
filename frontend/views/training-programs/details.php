<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\applications\UserOpinion;

$separator = Yii::$app->params->seo_settings->title_separator;
$this->title = $org['org_name'] . ' is Providing Training Program for ' . $data['cat_name'];
$keywords = 'Trainings,Trainings in Ludhiana,Trainings in Jalandhar,Trainings in Chandigarh,Government Trainings,IT Trainings,Top 10 Websites for Training Programs,Top lists of Trainings Program sites,Trainings Program services in india,top 50 Trainings Program portals in india,Trainings Program in india for freshers';
$description = 'Empower Youth is a career development platform where you can find your dream job and give wings to your career.';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/images/training-sharing.png');
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

$this->params['header_dark'] = false;

if (!Yii::$app->user->isGuest) {
    $user_id = Yii::$app->user->identity->user_enc_id;
}
?>
<?=
$this->render('/widgets/employer_applications/top-banner', [
    'org_image_location' => $org['cover_image_location'],
    'org_image' => $org['cover_image'],
    'job_title' => $data['cat_name'],
    'icon_png' => $data['icon_png'],
    'shortlist' => $shortlist,
    'shortlist_btn_display'=>false
]);
?>
<section>
    <div class="container">
        <div class="row m-0">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="job-single-sec">
                    <div class="job-single-head2">
                        <div class="job-overview">
                            <?php
                            switch ($data['training_duration_type']) {
                                case 1:
                                    $duration = 'Months';
                                    break;
                                case 2:
                                    $duration = 'Weeks';
                                    break;
                                case 3:
                                    $duration = 'Year';
                                    break;
                                default:
                                    $duration = 'Months';
                            }
                            ?>
                            <h3>Training Overview</h3>
                            <ul>
                                <li><i class="fas fa-puzzle-piece"></i>
                                    <h3>Profile</h3><span><?= $data['name'] ?></span></li>
                                <li><i class="fas fa-suitcase"></i>
                                    <h3>Training Duration</h3>
                                    <span><?= $data['training_duration'] . ' ' . $duration ?></span></li>
                                <li><i class="fas fa-chart-line"></i>
                                    <h3>Total Seats</h3>
                                    <span><?= $total_seats ?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="job-details">
                        <?=
                        $this->render('/widgets/employer_applications/skills', [
                            'skills' => $data['trainingProgramSkills'],
                            'text' => 'Course Skills That Will Be Learned',
                        ]);
                        ?>
                        <?=
                        $this->render('/widgets/employer_applications/other-details', [
                            'other_details' => $data['description'],
                            'text' => 'About This Course',
                        ]);
                        ?>
                    </div>
                    <div class="job-details">
                        <div class="job-single-head2">
                            <h4 class="p-location-heading">Navigate to institute Location</h4>
                            <ul class="p-locations">
                                <?php $j = 0; ?>
                                <?php $i = 0; ?>
                                <?php foreach ($grouped_cities as $key => $bt) { ?>
                                <li>
                                    <a class="loc" data-key="demo<?=$j?>" href="javascript:;">
                                        <img src="/assets/themes/ey/images/pages/jobs/city-map.png"/>
                                        <span><?= $key ?></span>
                                    </a>
                                </li>
                              <?php $j++; } ?>
                            </ul>
                        </div>
                        <div class="batches-main">
                            <?php foreach ($grouped_cities as $key=>$batch){ ?>
                            <div class="loc-batches" id="demo<?=$i ?>">
                                <h2 class="heading-style"><?= $key ?> Batches</h2>
                                <?php foreach ($batch as $key=>$batches){
                                    $working_days_data = json_decode($batches['days']);
                                    ?>
                                    <div class="row marg">
                                    <div class="col-md-12">
                                        <div class="batch">Batch <?= ($key+1) ?></div>
                                        <div class="sett">
                                            <div class="week-days">
                                                <ul>
                                                    <li class="<?= in_array(1, $working_days_data) ? 'active' : '' ?>">
                                                        <span>Monday</span>
                                                        <h2>M</h2>
                                                    </li>
                                                    <li class="<?= in_array(2, $working_days_data) ? 'active' : '' ?>">
                                                        <span>Tuesday</span>
                                                        <h2>T</h2>
                                                    </li>
                                                    <li class="<?= in_array(3, $working_days_data) ? 'active' : '' ?>">
                                                        <span>Wednesday</span>
                                                        <h2>W</h2>
                                                    </li>
                                                    <li class="<?= in_array(4, $working_days_data) ? 'active' : '' ?>">
                                                        <span>Thursday</span>
                                                        <h2>T</h2>
                                                    </li>
                                                    <li class="<?= in_array(5, $working_days_data) ? 'active' : '' ?>">
                                                        <span>Friday</span>
                                                        <h2>F</h2>
                                                    </li>
                                                    <li class="<?= in_array(6, $working_days_data) ? 'active' : '' ?>">
                                                        <span>Saturday</span>
                                                        <h2>S</h2>
                                                    </li>
                                                    <li class="<?= in_array(7, $working_days_data) ? 'active' : '' ?>">
                                                        <span>Sunday</span>
                                                        <h2>S</h2>
                                                    </li>
                                                </ul>
                                            </div>
                                                <div class="time-bar-inner col-md-12 col-sm-12 col-xs-12">
                                                    <div class="working-time-from">
                                                        <?= date("h:i A", strtotime($batches['start_time'])); ?> To <?= date("h:i A", strtotime($batches['end_time'])); ?>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="no-of-seats">Total No. Seats Available - <?= $batches['seats'] ?></div>
                                                <div class="no-of-seats">Fees ₹ - <?= $batches['fees'].' '.$batches['fees_method'] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              <?php  } ?>
                            </div>
                            <?php $i++; } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 z-index-9">
                <?= $this->render('/widgets/employer_applications/organization-details', [
                    'org_logo' => $org['logo'],
                    'org_logo_location' => $org['logo_location'],
                    'org_name' => $org['org_name'],
                    'initial_color' => $org['color'],
                    'slug' => $org['slug'],
                    'website' => $org['website'],
                    'email' => $org['email'],
                    'type' => 'Training',
                    'applied' => $applied,
                    'application_slug' => $application_details["slug"],
                    'shortlist' => $shortlist,
                    'shortlist_btn_display'=>false
                ]); ?>
            </div>
        </div>
    </div>
</section>
<div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php $form = ActiveForm::begin(['id' => 'training_form']); ?>
            <div class="modal-header">
                <h4 class="modal-title">Fill Out The Details</h4>
            </div>
            <div class="modal-body pt-0">
                <?= $form->field($model, 'application_id', ['template' => '{input}'])->hiddenInput(['id'=>'application_id','value'=>$application_details['application_enc_id']]) ?>
                <?php foreach ($grouped_cities as $key => $g){
                    echo "<label class='location_batches'>".$key."</label>";
                    ?>
                    <ul class="batch-items">
                    <?php foreach ($g as $key => $b){
                        ?>
                    <li><input type="checkbox" name="batch_id[]" value="<?=$b['batch_enc_id'] ?>"> Batch <?= ($key+1); ?></li>
                     <?php } ?>
                    </ul>
               <?php } ?>
            </div>
            <div class="modal-footer">
                <?= Html::submitbutton('Apply', ['class' => 'btn btn-primary sav_job']); ?>
                <?= Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
    function copyToClipboard() {
        var copyText = document.getElementById("share_manually");
        copyText.select();
        document.execCommand("copy");
        toastr.success("", "Copied");
        // alert("Copied the text: " + copyText.value);
    }
</script>
<?php
echo $this->render('/widgets/mustache/application-card');
$this->registerCss("
    label.location_batches {
        margin-bottom: 0px;
    }
    ul.batch-items {
        margin-bottom: 10px;
    }
    .batch-items > li {
        padding-left: 15px;
    }
    .no-of-seats{
        text-align:center;
        font-size: 20px;
        margin: 10px auto;
        font-family:roboto;
        font-weight:500;
        }
    .time-bar-inner{
        line-height: 35px;
        border-radius: 10px;
        padding: 4px;
        background-color: #EE7436; 
        background-image: linear-gradient(-40deg, #EA5768, #EE7436 90%);
        border:2px solid #D9DADA;
        color: #fff;
        font-size: 19px;
        font-family:roboto;
        text-align:center;
        width: 98%;
        font-weight: 400;
        }
    .working-time-from{
        width: 100%;
        float: left;
        background-color: #fff;
        color: #ff7803;
        border-radius: 5px;
        margin: 2px 0px;
        }
    @media only screen and (max-width: 768px) and (min-width: 360px) {
        .week-days ul{margin-left:15px;}
        }
    .week-days{padding-top:15px;}
    .week-days ul li{
        position:relative;
        list-style:none;
        display:none;
        width:94px;
        height:100px;
        line-height:100px;
        text-align:center;
        margin-right:5px;
        background-color:#fff !important;
        background-image:none;
        border:1px solid #ddd;
        color:#000;
        }
    .week-days ul li.active{
        color:#fff;
        display:inline-block;
        background-color: #35394F; 
        background-image: linear-gradient(-40deg, #35394F 25%, #787D90);
        border:1px solid #ddd;
        }
    .week-days ul li.active h2{
        color:#fff;
        }
    .week-days ul li span{
        position:absolute;
        top:0px;
        line-height:25px;
        left:0;
        width:100%;
        background-color:#fff;
        box-shadow: 0 1px 5px -2px #393d52;
        }
    .week-days ul li.active span{
        background-color:#787E91;
        box-shadow: 0 5px 5px -5px #393d52;
        }
    .week-days ul li h2{
        line-height:115px;
        margin:0px;
    }
    .marg{
        margin:15px 10px;
        border:1px solid  #d0d3d4 ;
    }
    .table-view{
        display:none;
        }
    .table-view.in{
        display:block;  
        float: left;
        width: 100%;
    }
    .batch{
        padding: 5px;
        background-color: #ff7803;
        color: white;
        font-weight: 400;
        position: relative; 
        right: 15px;
        width: 80px;
        text-align:center;
        font-family:roboto;
    }
    .p-location-heading{
        width: 100%;
        font-family: roboto;
        font-size: 15px;
        color: #202020;
    }
    .p-locations li{
        max-width: 125px;
        box-shadow: 0px 1px 10px -2px #ddd;
        background-color: #35394F;
        background-image: linear-gradient(-40deg, #35394F 25%, #787D90);
        display: inline-block;
        margin: 8px !Important;
        box-shadow: 0px 1px 10px -2px #ddd;
    }
    .p-locations li a{
        color: #222;
        position: relative;
        display:block;
    }
    .p-locations li a:before, .p-locations li a:after{
        content:'';
        position:absolute;
        width:100%;
        height:77%;
        left:0;
        top:0;
        background-repeat: no-repeat;
        background-position: center;
        display:block;
        opacity:0;
         -webkit-transition: opacity 0.7s ease;
      -moz-transition: opacity 0.7s ease;
      -ms-transition: opacity 0.7s ease;
      -o-transition: opacity 0.7s ease;
      transition: opacity 0.7s ease-out;
    }
    .p-locations li a:before{
        content:'Click here to show Batches';
//        background:url(\"/assets/themes/ey/images/pages/jobs/direction_icon.png\");
        z-index: 2;
        background-repeat: no-repeat;
        background-position: center;
        background-size: 40%;
        color: #fff;
        text-align: center;
        font-size: 16px;
        padding-top: 35px;
    }
    .p-locations li a:after{
        background-color: #000;
    }
    .p-locations li:hover a:before{
        opacity:1;
    }.p-locations li:hover a:after{
        opacity:0.55;
    }
    .p-locations li a img{
        width: 90%;
        margin-left: 5%;
        padding: 10px;
    }
    .p-locations li span {
        font-size: 14px;
        color: #fff;
        padding: 0px 4px;
        height: 35px;
        line-height: 35px;
        width: 100%;
        text-align: center;
        display: block;
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -ms-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
        background-color: #787E91;
        box-shadow: 0 -10px 5px -5px #393d52;
    }
    .loc-batches{display:none;}
    .loc-batches:first-child{display:block;}
    .overlay-top {
        width: 80%;
        margin: auto;
        margin-top: -150px;
        float: none;
        background-color: #333a44;
        z-index: 9;
        padding-top: 20px;
        padding-bottom: 50px;
    }
    .organization-details {
        display: block;
        text-align: left;
        padding: 25px;
    }
    .organization-details h4 {
        font-size: 14px !Important;
        margin-top: 15px !important;
    }
    .job-thumb a {
        width: 100px;
        height: 100px;
        background-color: #fff;
        display: block;
        margin: auto;
        border-radius: 50%;
    }
    
    .job-thumb a img {
        margin: 5px;
    }
    .z-index-9{
        z-index:9;
    }
     .sub_description_1,sub_description_2{
        display:none;
     }   
     .heading_submit{
        color:#fff;
     } 
     .sub_description{
        font-size:15px;
     }  
     #msg{
        color:#fff;
        padding: 5px 5px;
        text-align:center;
     }   
     #close_btn {
        float: right;
        display: inline-block;
        padding: 0px 6px;
        color: #fff;
        font-size: 28px;
        cursor: pointer;
    }
   
    .fader{
      width:100%;
      height:100%;
      position:fixed;
      top:0;
      left:0;
      display:none;
      z-index:99;
      background-color:#fff;
      opacity:0.7;
    }
    #warn{
        color:#e9465d;
        display:none;
    }
    .inputGroup {
      background-color: #fff;
      display: block;
      margin: 10px 0;
      position: relative;
    }
    .inputGroup label {
       padding: 6px 75px 10px 25px;
        width: 96%;
        display: block;
        margin:auto;
        text-align: left;
        color: #3C454C;
        cursor: pointer;
        position: relative;
        z-index: 2;
        transition: color 1ms ease-out;
        overflow: hidden;
        border-radius: 8px;
        border:1px solid #eee;
    }
    .inputGroup label:before {
      width: 100%;
      height: 10px;
      border-radius: 50%;
      content: '';
      background-color: #00a0e3;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%) scale3d(1, 1, 1);
      transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
      opacity: 0;
      z-index: -1;
    }
    .inputGroup label:after {
      width: 32px;
      height: 32px;
      content: '';
      border: 2px solid #D1D7DC;
      background-color: #fff;
      background-repeat: no-repeat;
      background-position: 2px 3px;
      background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
      border-radius: 50%;
      z-index: 2;
      position: absolute;
      right: 30px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      transition: all 200ms ease-in;
    }
    .inputGroup input:checked ~ label {
      color: #fff;
    }
    .inputGroup input:checked ~ label:before {
      transform: translate(-50%, -50%) scale3d(56, 56, 1);
      opacity: 1;
    }
    .inputGroup input:checked ~ label:after {
      background-color: #54E0C7;
      border-color: #54E0C7;
    }
    .inputGroup input {
      width: 32px;
      height: 32px;
      order: 1;
      z-index: 2;
      position: absolute;
      right: 30px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      visibility: hidden;
    }

    .block {
        float: left;
        padding: 60px 0;
        position: relative;
        width: 100%;
        z-index: 1;
    }
    #new_resume,#use_existing{
        display:none;
    }
    #logo_img{
        width: 115px;
        height: 115px; 
    }
    .block .container{padding:0}
    .block.remove-top{padding-top:0}
    .block.no-padding{padding-top:0; padding-bottom:0; }
    .block.dark{background:#111111}
    .block.remove-bottom{padding-bottom:0}
    .block.overlape {
        z-index: 2;
    }
    section.overlape {
        z-index: 2;
    }
    .dark-color::before {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        content: '';
//        z-index: -1;
        background: #00000078;
        opacity: 0.8;
    }
    .dark-color::after {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        content: '';
        z-index: -1;
        opacity: 0.14;
    }
    .inner-header {
        float: left;
        width: 100%;
        position: relative;
        padding-top: 215px;
        padding-bottom: 15px;
        z-index: 0;
    }
    .inner-header.wform .job-search-sec {
        position: relative;
        float: left;
        z-index: 4;
        top: 0;
        -webkit-transform: translateX(-50%);
        -moz-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        -o-transform: translateX(-50%);
        transform: translateX(-50%);
    }
    .inner-header > h3 {
        max-width: 500px;
        position: relative;
        z-index: 1;
        color: #ffffff;
        font-weight: bold;
        font-size: 30px;
        text-align: center;
        margin: auto;
        margin-bottom: 50px;
        text-transform: capitalize;
    }
    .inner-header .container {
        position: relative;
        z-index: 1;
    }
    .job-statistic {
        float: left;
        width: 100%;
        text-align: center;
        position: relative;
        margin-top: 20px;
        margin-bottom: 50px;
        z-index: 1;
        color: #fff;
        font-size: 18px;
    }
    .job-statistic span {
        float: none;
        display: inline-block;
        font-size: 12px;
        border: 1px solid #ffffff;
        color: #ffffff;
        padding: 7px 20px;
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        -ms-border-radius: 20px;
        -o-border-radius: 20px;
        border-radius: 20px;
        background: #00a0e3;
        border-color: #00a0e3;
    }
    .job-statistic p {
        float: none;
        display: inline-block;
        color: #ffffff;
        font-size: 13px;
        margin: 0 20px;
    }
    .job-statistic p i {
        font-size: 23px;
        float: left;
        line-height: 29px;
        margin-right: 9px;
    }
    .container.fluid{ max-width: 100%; width: 100%; }
    .block .container{padding:0}
    .container{padding:0}
    .inner-header .container {
        position: relative;
        z-index: 1;
    }
    .job-single-sec {
        float: left;
        width: 100%;
    }
    .job-single-head2 {
        float: left;
        width: 100%;
//        padding-bottom: 30px;
//        border-bottom: 1px solid #e8ecec;
    }
    .job-single-head2 > span {
        float: left;
        width: 100%;
        font-size: 13px;
        color: #888888;
        margin-top: 20px;
    }
    .job-single-head2 > span strong {
        font-weight: normal;
        color: #202020;
    }
    .job-is {
        display: table-cell;
        vertical-align: middle;
        font-family: Open Sans;
        font-size: 12px;
        border: 1px solid;
        float: right;
        padding: 7px 0;
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        -ms-border-radius: 20px;
        -o-border-radius: 20px;
        border-radius: 20px;
        width: 108px;
        margin: 9px 0;
        text-align: center;
    }
    .job-is.ft,
    .job-list-modern .job-is.ft{
        color: #4aa1e3;
        border-color: #4aa1e3;
    }
    .job-is.ft {
        margin-top: 12px;
    }
    .job-title2 span.job-is {
        float: left;
        margin: 0;
    }
    .tags-jobs {
        float: left;
        width: auto;
        margin: 0;
        margin-top: 0px;
        margin-top: 20px;
    }
    .tags-jobs > li {
        float: left;
        margin: 0;
        margin-right: 0px;
        font-family: Open Sans;
        font-size: 13px;
        color: #888888;
        margin-right: 30px;
    }
    .tags-jobs > li i {
        float: left;
        font-size: 23px;
        float: left;
        line-height: 15px;
        margin-right: 8px;
        color: #4aa1e3;
    }
    .tags-jobs > li span {
        color: #4aa1e3;
    }
    .job-details {
        float: left;
        width: 100%;
//        padding-top: 20px;
    }
    .job-details h3 {
        float: left;
        width: 100%;
        font-family: Open Sans;
        font-size: 15px;
        color: #202020;
        margin-bottom: 15px;
        margin-top: 10px;
        font-weight: 600;
    }
    .job-details p,
    .job-details li {
        float: left;
        width: 100%;
        font-size: 13px;
        color: #888888;
        line-height: 24px;
        margin: 0;
        margin-bottom: 19px;
    }
    .job-details > ul {
        float: left;
        width: 100%;
        margin-bottom: 20px;
    }
    .job-details > ul li {
        float: left;
        width: 100%;
        margin: 0;
        margin-bottom: 0px;
        position: relative;
        padding-left: 23px;
        line-height: 21px;
        margin-bottom: 10px;
        font-size: 13px;
        color: #888888;
    }
    .job-details > ul li::before {
        position: absolute;
        left: 0;
        top: 10px;
        width: 10px;
        height: 1px;
        background: #888888;
        content: '';
    }
    .job-overview {
        float: left;
        width: 100%;
    }
    .job-overview > h3 {
        float: left;
        width: 100%;
        font-family: Open Sans;
        font-size: 15px;
        color: #202020;
        font-weight: 600;
    }
    .job-overview ul {
        float: left;
        width: 100%;
        border: 2px solid #e8ecec;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        margin: 0;
        padding-left: 15px !important;
    }
    .job-overview ul > li {
        float: left;
        width: 100%;
        margin: 0;
        position: relative;
        padding-left: 67px;
        margin: 8px 0px;
        min-height: 68px;
    }
    .job-overview ul > li i {
        position: absolute;
        left: 23px;
        top: 5px;
        font-size: 30px;
        color: #4aa1e3;
    }
    .job-overview ul > li h3 {
        float: left;
        width: 100%;
        font-size: 13px;
        font-family: Open Sans;
        margin: 0;
        color: #1e1e1e;
        font-weight: 600;
    }
    .job-overview ul > li span {
        float: left;
        width: 100%;
        font-size: 13px;
        color: #545454;
        margin-top: 4px;
    }
    .job-single-sec .job-overview ul {
        padding: 0;

        margin-bottom: 20px;
    }
    .job-single-sec .job-overview ul li {
        float: left;
        width: 33.334%;
        padding-left: 50px;
    }
    .job-single-sec .job-overview ul li i {
        left: 0;
    }
    .job-overview > a {
        float: left;
        width: 100%;
        height: 50px;
        font-size: 13px;
        background: #ef7706;
        text-align: center;
        line-height: 50px;
        color: #ffffff;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .job-overview > a.contct-user {
        background: #4aa1e3;
    }
    .job-overview ul > li:hover i {
        color: #ef7706;
    }
    .job-overview ul > li *, .job-single-head.style2 > a, .apply-job-btn, .hover-change{
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -ms-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }
    .share-bar {
        float: left;
        width: 100%;
        padding-top: 20px;
        border-top: 1px solid #e8ecec;
        border-bottom: 1px solid #e8ecec;
    }
    .share-bar span {
        float: left;
        font-size: 15px;
        color: #202020;
        line-height: 40px;
        margin-right: 14px;
    }
    .share-bar  a {
        float: none;
        display: inline-block;
        width: 47px;
        height: 35px;
        border: 2px solid;
        border-top-color: currentcolor;
        border-right-color: currentcolor;
        border-bottom-color: currentcolor;
        border-left-color: currentcolor;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        line-height: 30px;
        font-size: 18px;
        margin: 0 5px;
        margin-top: 0px;
        text-align: center;
        margin-top: 0px;
        margin-top: 6px;
    }
    .share-bar a.share-fb {
        color: #3b5998;
        border-color: #3b5998;
    }
    .share-bar  a.share-twitter {
        color: #1da1f2;
        border-color: #1da1f2;
    }
    .share-bar  a.share-google {
        color: #EA4335;
        border-color: #EA4335;
    }
    .share-bar  a.share-linkedin {
        color: #0077B5;
        border-color: #0077B5;
    }
    .share-bar  a.share-whatsapp {
        color: #4FCE5D;
        border-color: #4FCE5D;
    }
    .share-bar a.share-fb:hover {
        background: #3b5998;
        border-color: #3b5998;
        color: #ffffff;
    }
    .share-bar  a.share-twitter:hover {
        background: #1da1f2;
        border-color: #1da1f2;
        color: #ffffff;
    }
    .share-bar  a.share-google:hover {
        background: #EA4335;
        border-color: #EA4335;
        color: #ffffff;
    }
    .share-bar a:hover {
        color: #ffffff;
    }
    .share-bar a.share-linkedin:hover {
        background: #0077B5;
        border-color: #0077B5;
    }
    .share-bar a.share-whatsapp:hover {
        background: #4FCE5D;
        border-color: #4FCE5D;
    }
    .job-single-head.style2 {
//        float: left;
//        width: 100%;
        display: inherit;
        text-align: center;
        border: none;
    }
    .job-single-head.style2 .job-thumb {
        float: left;
        width: 100%;
        text-align: center;
        margin-top:20px;
    }
    .job-single-head.style2 .job-thumb img, .job-single-head.style2 .job-thumb canvas {
        float: none;
        display: inline-block;
        width: auto;
        border: none;
//        -webkit-box-shadow: 0px 0px 20px 7px #ddd;
//        -moz-box-shadow: 0px 0px 20px 7px #ddd;
//        -ms-box-shadow: 0px 0px 20px 7px #ddd;
//        -o-box-shadow: 0px 0px 20px 7px #ddd;
//        box-shadow: 0px 0px 20px 7px #ddd;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }
    .job-single-head.style2 .job-head-info {
        float: left;
        width: 100%;
        display: inherit;
        padding: 0;
        margin-top: 10px;
        margin-bottom: 18px;
    }
    .job-single-head.style2 .job-head-info p {
        float: left;
        width: 100%;
//        text-align: center;
        margin: 0;
        margin-top: 0px;
    }
    .job-single-head.style2 .job-head-info p i {
        float: none;
        color: #fff;
        display:inline-block;
    }
    .job-single-head.style2 .job-head-info > span {
        margin-top: 5px;
        margin-bottom: 20px;
    }
    .job-single-head.style2 > a {
        clear: both;
        display: block;
    }
    .job-single-head.style2 > a:hover {

        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        color: #ffffff;
    }
    .job-thumb {
        display: table-cell;
        vertical-align: top;
        width: 107px;
    }
    .job-thumb img {
        float: left;
        width: 100%;
        border: 2px solid #e8ecec;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
    }
    .job-head-info {
        display: table-cell;
        vertical-align: middle;
        padding-left: 25px;
    }
    .job-head-info h4 {
        float: left;
        width: 100%;
        font-family: Open Sans;
        font-size: 17px;
        font-weight: 600;
        color: #fff;
        margin: 0;
        margin-bottom: 0px;
        margin-bottom: 10px;
    }
    .job-head-info span {
        float: none;
        width: auto;
        font-size: 13px;
        color: #fff;
        line-height: 10px;
    }
    .job-head-info p {
        float: left;
        margin: 0;
        margin-top: 0px;
        margin-right: 0px;
        font-size: 13px;
        margin-right: 40px;
        color: #888;
        margin-top: 11px;
    }
    .job-head-info p i {
        float: left;
        font-size: 14px;
        line-height: 27px;
        margin-right: 9px;
        margin-top: 1px;
    }
    .apply-job-btn {
        background: #00a0e3;
        -webkit-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
        -moz-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
        -ms-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
        -o-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
        box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        -ms-border-radius: 2px;
        -o-border-radius: 2px;
        border-radius: 2px;
        font-family: Open Sans;
        font-size: 13px;
        color: #fff;
        width: 175px;
        height: auto;
        padding: 15px 6px;
        text-align: center;
        margin:auto;
    }
    .apply-job-btn:hover {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        color: #fff !important;
    }
    .apply-job-btn i {
        float: none;
        font-size: 18px;
        margin-right: 6px;
        line-height: 8px;
        position: relative;
        top: 4px;
    }
    .viewall-jobs {
        background: #4aa1e3;
        width: 200px;
        height: auto;
        color: #ffffff;
        font-family: Open Sans;
        font-size: 13px;
        -webkit-border-radius: 40px;
        -moz-border-radius: 40px;
        -ms-border-radius: 40px;
        -o-border-radius: 40px;
        border-radius: 40px;
        margin:auto;
        margin-top: 15px;
        padding: 15px 30px;
    }
    .job-title2 > h3 {
        float: left;
        font-size: 20px;
        font-weight: bold;
        margin: 0;
        margin-right: 0px;
        margin-right: 20px;
    }
    .radio_questions {
      padding: 0 16px;
      max-width: 100%;
      font-size: 18px;
      font-weight: 600;
      line-height: 36px;
    }
    .parallax{
        height:100%;
        width:100%;
        margin:0;
        position:absolute;
        left:0;
        top:0;
        z-index:-1;
        background-size: cover !important;
    }
    .parallax.no-parallax {
        background-attachment: scroll !important;
        background-position: inherit !important;
    }
    .tags-bar {
        float: left;
        width: 100%;
        margin-bottom: 20px;
        border: 2px solid #e8ecec;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        padding: 10px;
        position: relative;
    }
    .tags-bar > span {
        float: left;
        background: #f4f5fa;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        font-family: Open Sans;
        font-size: 13px;
        padding: 7px 17px;
        margin-right: 15px;
        margin-bottom:5px;
        position: relative;
    }
    .shortlist_job,.shortlist_job:hover{
        color:#fff;
    }
    .shortlist_job:focus{
        color:#fff;
    }
    .col_pink{
        background: #ef7706 !important;
        border-color: #ef7706 !important;
        color: #ffffff;
    }
    .hover-change:hover {
        background: #ef7706;
        border-color: #ef7706;
        color: #ffffff;
    }
    .pf-field {
        float: left;
        width: 100%;
        position: relative;
    }
    .pf-field > input {
        height: 56px;
        float: left;
        width: 100%;
        border: 2px solid #e8ecec;
        margin-bottom: 20px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        padding: 14px 45px 14px 15px;
        background: #ffffff !important;
        font-family: Open Sans;
        font-size: 13px;
        font-weight: 400;
        color: #101010;
        line-height: 24px;
        cursor: pointer;
    }
    .pf-field > i {
        position: absolute;
        right: 20px;
        top: 0;
        font-size: 20px;
        color: #848484;
        line-height: 56px;
        cursor: pointer;
    }
    @media only screen and (max-width: 575px) {
        .job-overview ul li{
             width: 50% !important;
        }
    }
    .has-success .control-label, .has-success.radio-inline label, .has-success .checkbox-inline, .has-success .radio-inline, .has-error .control-label, .has-error.radio-inline label, .has-error .checkbox-inline{
        color:inherit;
    }
    /* Feature, categories css starts */
    .cat-sec {
        float: left;
        width: 100%;
    }
    .p-category {
        float: left;
        width: 100%;
        z-index: 1;
        position: relative;
    }
    .p-category, .p-category *{
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -ms-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }
    .p-category > .p-category-view {
        float: left;
        width: 100%;
        text-align: center;
        padding-bottom: 30px;
        border-bottom: 1px solid #e8ecec;
        border-right: 1px solid #e8ecec;
    }
    .p-category > .p-category-view img {
        font-size: 70px;
        margin-top: 30px;
        line-height: initial !important;
    }
    .p-category > .p-category-view span {
        float: left;
        width: 100%;
        font-family: Open Sans;
        font-size: 15px;
        color: #202020;
        margin-top: 18px;
    }
    .p-category:hover {
        background: #ffffff;
        -webkit-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
        -moz-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
        -ms-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
        -o-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
        box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        width: 104%;
        margin-left: -2%;
        height: 102%;
        z-index: 10;
    }
    .p-category:hover .p-category-view {
        border-color: #ffffff;
    }
    .p-category:hover i{
        color: #f07d1d;
    }
    .row.no-gape > div {
        padding: 0;
    }
    .cat-sec .row > div:last-child .p-category-view {
        border-right-color: #ffffff;
    }
    .p-category img{
        width: 80px;
        height: 50px;
    }
    .p-category .p-category-view img, .p-category .checkbox-text span i {
        color: #4aa1e3;
        font-size: 70px;
        margin-top: 30px;
        line-height: initial !important;
    }
    /* Feature, categories css ends */
    /* Profile icons css start */
    .profile_icons{
        position: absolute;
        width: 320px;
        left: 0px;
        bottom: -3px;
    }
    .background-container{
        max-width:1200px;
        padding-left: 15px;
        padding-right: 15px;
        margin:auto;
    }
    @media screen and (max-width: 1150px) and (min-width: 1025px) {
          .profile_icons{
               width: 290px;
          }
          .inner-header > h3{
               width: 400px;
          }
          .inner-header {
               padding-top: 190px;
          }
    }
    @media screen and (max-width: 1024px) and (min-width: 890px) {
          .profile_icons{
               width: 260px;
          }
          .inner-header {
               padding-top: 160px;
          }
          .inner-header > h3{
               width: 370px;
          }
    }
    @media screen and (max-width: 889px) and (min-width: 650px) {
          .profile_icons{
               width: 210px;
          }
          .inner-header > h3 {
               width: 290px;
               font-size: 22px;
               margin-bottom: 20px;
          }
          .inner-header {
               padding-top: 160px;
          }
    }
    @media screen and (max-width: 649px) and (min-width: 0px) {
          .profile_icons{
               width: 150px;
               position: relative;
               margin: auto;
               left: 0;
               bottom: 0px;
               margin-bottom: 30px;
          }
          .inner-header {
               padding-top: 90px;
          }
          .inner-header > h3 {
               font-size: 20px;
               margin-bottom: 20px;
          }
          .job-statistic{
               display:none;
          }
    }
    /* Profile icons css ends */
    ");
$script = <<< JS
$(document).on('click', '.loc', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-key');
    $('.loc-batches').fadeOut(500);
    $('#'+ id).fadeIn(1000);
});
$(document).on('click','.apply-btn',function(e) {
  e.preventDefault();
  if($(this).attr("disabled") == "disabled")
            {
               return false;
            }
  $('#modal').modal('show');
})

$(document).on('click','.sav_job',function(e) {
  e.preventDefault();
  if ($('input[name="batch_id[]"]:checked').length==0){
      alert("choose atlease one batch");
      return false;
  }
  $.ajax({
  url:'/training-programs/apply',
  type: 'post',
  data: $('#training_form').serialize(),                         
  beforeSend:function()
  {
  $('.sav_job').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
  },     
  success:function(res)
  {
    if (res==true)
        {
        applied();
        swal("Submitted!", "Your Application Has been successfully registered with the Institute. keep checking your Dashboard Regularly for further confirmation..", "success");
        }
    else {
         alert('Something went wrong..');
        }
  }
});
});
 function applied()
        {
             $('#modal').modal('toggle');
                     $('.apply-btn').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
                     $('.apply-btn').html('<i class = "fas fa-check"></i>Applied');
                     $('.apply-btn').attr("disabled","true");
            }
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
