<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$radios_array = [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5];
$this->title = $org_details['name'] . ' ' . Yii::$app->params->seo_settings->title_separator . ' Reviews';
Yii::$app->view->registerJs('var slug = "' . $slug . '"; var business_type = "' . $org_details['business_activity'] . '" ', \yii\web\View::POS_HEAD);
$overall_avg = array_sum($stats) / count($stats);
$overall_college_avg = array_sum($stats_students) / count($stats_students);
$round_avg = round($overall_avg);
$round_students_avg = round($overall_college_avg);
$logo_image = Yii::$app->params->upload_directories->unclaimed_organizations->logo . $org_details['logo_location'] . DIRECTORY_SEPARATOR . $org_details['logo'];
$keywords = 'Jobs,Jobs in Ludhiana,Jobs in Jalandhar,Jobs in Chandigarh,Government Jobs,IT Jobs,Part Time Jobs,Top 10 Websites for jobs,Top lists of job sites,Jobs services in india,top 50 job portals in india,jobs in india for freshers';
$description = 'Empower Youth is a career development platform where you can find your dream job and give wings to your career.';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/images/review_share.png');
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
<section class="rh-header <?= $org_details['business_activity'] ?>">
    <div class="container">
        <div class="row">
            <div class=" col-md-2 col-md-offset-0 col-sm-4 col-sm-offset-2 col-xs-12">
                <div class="logo-box">
                    <?php
                    if (!empty($org_details['logo'])) {
                        ?>
                        <img src="<?= $logo_image; ?>">
                        <?php
                    } else {
                        ?>
                        <canvas class="user-icon" name="<?= $org_details['name']; ?>" width="150" height="150"
                                color="<?= $org_details['initials_color'] ?>" font="70px"></canvas>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="com-name"><?= ucwords($org_details['name']); ?></div>
                <div class="com-rating-1">
                    <?php for ($i = 1; $i <= 5; $i++) {
                        if (!empty($round_avg)) {
                            ?>
                            <i class="fa fa-star <?= (($round_avg < $i) ? '' : 'active') ?>"></i>
                        <?php } else { ?>
                            <i class="fa fa-star <?= (($round_students_avg < $i) ? '' : 'active') ?>"></i>
                        <?php }
                    } ?>
                </div>
                <div class="com-rate"><?= (($round_avg) ? $round_avg : $round_students_avg) ?>/5 - based
                    on <?= $reviews + $reviews_students; ?> reviews
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="header-bttns">
                    <div class="header-bttns-flex">
                        <?php if (!Yii::$app->user->isGuest) { ?>
                            <?php if (!empty($follow) && $follow['followed'] == 1) {
                                ?>
                                <div class="follow-bttn hvr-icon-pulse">
                                    <button type="button" class="follow"
                                            value="<?= $org_details['organization_enc_id']; ?>"><i
                                                class="fa fa-heart-o hvr-icon"></i> Following
                                    </button>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="follow-bttn hvr-icon-pulse">
                                    <button type="button" class="follow"
                                            value="<?= $org_details['organization_enc_id']; ?>"><i
                                                class="fa fa-heart-o hvr-icon"></i> Follow
                                    </button>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="follow-bttn hvr-icon-pulse">
                                <button type="button" data-toggle="modal" data-target="#loginModal"><i
                                            class="fa fa-heart-o hvr-icon"></i> Follow
                                </button>
                            </div>
                        <?php } ?>
                        <?php if (!Yii::$app->user->isGuest) {
                            if (!empty($edit)) { ?>
                                <div class="wr-bttn hvr-icon-pulse">
                                    <a href="javascript:;" data-toggle="modal" data-target="#edit_review"
                                       class="btn_review"><i class="fa fa-comments-o hvr-icon"></i> Edit Your Review</a>
                                </div>
                            <?php } else {
                                if (empty(Yii::$app->user->identity->organization_enc_id)) { ?>
                                    <div class="wr-bttn hvr-icon-pulse">
                                        <button type="button" id="wr"><i class="fa fa-comments-o hvr-icon"></i> Employee
                                            Review
                                        </button>
                                    </div>
                                    <div class="wr-bttn hvr-icon-pulse">
                                        <button type="button" id="wr1"><i class="fa fa-comments-o hvr-icon"></i> Student
                                            Review
                                        </button>
                                    </div>
                                <?php }
                            }
                        } else { ?>
                            <div class="wr-bttn hvr-icon-pulse">
                                <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="btn_review"><i
                                            class="fa fa-comments-o hvr-icon"></i> Write Review</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#menu1">Student Reviews</a></li>
            <li><a data-toggle="tab" href="#home">Employee Reviews</a></li>
        </ul>
    </div>
</section>
<section class="rh-body">
    <div class="container">
        <div class="tab-content">
            <div id="menu1" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="heading-style">Student Reviews </h1>
                        <div id="org-students-reviews"></div>
                        <div class="col-md-offset-2 load-more-bttn">
                            <button type="button" id="load_more_btn1">Load More</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <?php if ($org_details['business_activity'] == 'College') {
                            echo $this->render('/widgets/review/review-college-stats', [
                                'reviews_students' => $reviews_students,
                                'round_students_avg' => $round_students_avg,
                                'stats_students' => $stats_students,
                            ]);
                        } elseif ($org_details['business_activity'] == 'School') {
                            echo $this->render('/widgets/review/review-school-stats', [
                                'reviews_students' => $reviews_students,
                                'round_students_avg' => $round_students_avg,
                                'stats_students' => $stats_students,
                            ]);
                        } elseif ($org_details['business_activity'] == 'Educational Institute') {
                            echo $this->render('/widgets/review/review-institute-stats', [
                                'reviews_students' => $reviews_students,
                                'round_students_avg' => $round_students_avg,
                                'stats_students' => $stats_students,
                            ]);
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div id="home" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="heading-style">Employee Reviews </h1>
                        <div id="org-reviews"></div>
                        <div class="col-md-offset-2 load-more-bttn">
                            <button type="button" id="load_more_btn">Load More</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="review-summary">
                            <h1 class="heading-style">Overall Ratings</h1>
                            <div class="row">
                                <div class="col-md-12 col-sm-4">
                                    <div class="rs-main <?= (($reviews) ? '' : 'fade_background') ?>">
                                        <div class="rating-large"><?= $round_avg ?>/5</div>
                                        <div class="com-rating-1">
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <i class="fa fa-star <?= (($round_avg < $i) ? '' : 'active') ?>"></i>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-4">
                                    <div class="rs1">
                                        <div class="re-heading">Job Security</div>
                                        <div class="summary-box">
                                            <div class="sr-rating <?= (($reviews) ? '' : 'fade_background') ?>"> <?= $stats['job_avg']; ?> </div>
                                            <div class="fourstar-box com-rating-2 <?= (($reviews) ? '' : 'fade_border') ?>">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <i class="fa fa-star <?= (($stats['job_avg'] < $i) ? '' : 'active') ?>"></i>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="rs1">
                                        <div class="re-heading">Career growth</div>
                                        <div class="summary-box">
                                            <div class="sr-rating <?= (($reviews) ? '' : 'fade_background') ?>"> <?= $stats['growth_avg']; ?> </div>
                                            <div class="fourstar-box com-rating-2 <?= (($reviews) ? '' : 'fade_border') ?>">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <i class="fa fa-star <?= (($stats['growth_avg'] < $i) ? '' : 'active') ?>"></i>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="rs1">
                                        <div class="re-heading">Company culture</div>
                                        <div class="summary-box">
                                            <div class="sr-rating <?= (($reviews) ? '' : 'fade_background') ?>"> <?= $stats['avg_cult']; ?> </div>
                                            <div class="fourstar-box com-rating-2 <?= (($reviews) ? '' : 'fade_border') ?>">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <i class="fa fa-star <?= (($stats['avg_cult'] < $i) ? '' : 'active') ?>"></i>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="rs1">
                                        <div class="re-heading">Salary & Benefits</div>
                                        <div class="summary-box">
                                            <div class="sr-rating <?= (($reviews) ? '' : 'fade_background') ?>"> <?= $stats['avg_compensation']; ?> </div>
                                            <div class="fourstar-box com-rating-2 <?= (($reviews) ? '' : 'fade_border') ?>">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <i class="fa fa-star <?= (($stats['avg_compensation'] < $i) ? '' : 'active') ?>"></i>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="rs1">
                                        <div class="re-heading">Work Satisfaction</div>
                                        <div class="summary-box">
                                            <div class="sr-rating <?= (($reviews) ? '' : 'fade_background') ?>"> <?= $stats['avg_work']; ?> </div>
                                            <div class="threestar-box com-rating-2 <?= (($reviews) ? '' : 'fade_border') ?>">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <i class="fa fa-star <?= (($stats['avg_work'] < $i) ? '' : 'active') ?>"></i>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="rs1">
                                        <div class="re-heading">Work-Life Balance</div>
                                        <div class="summary-box">
                                            <div class="sr-rating <?= (($reviews) ? '' : 'fade_background') ?>"> <?= $stats['avg_work_life']; ?> </div>
                                            <div class="fourstar-box com-rating-2 <?= (($reviews) ? '' : 'fade_border') ?>">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <i class="fa fa-star <?= (($stats['avg_work_life'] < $i) ? '' : 'active') ?>"></i>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4">
                                    <div class="rs1">
                                        <div class="re-heading">Skill development</div>
                                        <div class="summary-box">
                                            <div class="sr-rating <?= (($reviews) ? '' : 'fade_background') ?>"> <?= $stats['avg_skill']; ?> </div>
                                            <div class="fourstar-box com-rating-2 <?= (($reviews) ? '' : 'fade_border') ?>">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <i class="fa fa-star <?= (($stats['avg_skill'] < $i) ? '' : 'active') ?>"></i>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="edit_review" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Your Review</h4>
            </div>
            <div class="modal-body">
                <?php if ($editReviewForm->type == 'org') {
                    $url = '/organizations/edit-review-unclaimed?request_type=2&type=org';
                } elseif ($editReviewForm->type == 'college') {
                    $url = '/organizations/edit-review-unclaimed?request_type=2&type=college';
                } elseif ($editReviewForm->type == 'school') {
                    $url = '/organizations/edit-review-unclaimed?request_type=2&type=school';
                } elseif ($editReviewForm->type == 'institute') {
                    $url = '/organizations/edit-review-unclaimed?request_type=2&type=institute';
                }
                ?>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'edit-review-form',
                    'action' => $url,
                    'fieldConfig' => [
                        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                    ]
                ]);
                ?>
                <div class="row">
                    <div class="col-md-6 col-md-offset-1">
                        <?= $form->field($editReviewForm, 'identity')->dropDownList([0 => Anonymous, 1 => Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name])->label('Post As'); ?>
                    </div>
                </div>
                <div id="widget_bar_stats">
                    <?php if ($editReviewForm->type == 'org') {
                        echo $this->render('/widgets/review/review-org-stats-edit', [
                            'form' => $form,
                            'editReviewForm' => $editReviewForm
                        ]);
                    } elseif ($editReviewForm->type == 'college') {
                        echo $this->render('/widgets/review/review-college-stats-edit', [
                            'form' => $form,
                            'editReviewForm' => $editReviewForm
                        ]);
                    } elseif ($editReviewForm->type == 'school') {
                        echo $this->render('/widgets/review/review-school-stats-edit', [
                            'form' => $form,
                            'editReviewForm' => $editReviewForm
                        ]);
                    } elseif ($editReviewForm->type == 'institute') {
                        echo $this->render('/widgets/review/review-institute-stats-edit', [
                            'form' => $form,
                            'editReviewForm' => $editReviewForm
                        ]);
                    }
                    ?>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($editReviewForm, 'likes')->textArea(['rows' => 4])->label('Likes'); ?>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($editReviewForm, 'dislikes')->textArea(['rows' => 4])->label('Dislikes'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($editReviewForm, 'org_id', ['template' => '{input}'])->hiddenInput()->label(false); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Update', ['class' => 'btn btn-primary']); ?>
                <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<input type="hidden" name="hidden_city_location" class="hidden_city_location">
<?php
echo $this->render('/widgets/mustache/organization-unclaimed-reviews', [
    'org_slug'=>$slug
]);
if ($org_details['business_activity'] == 'College') {
    echo $this->render('/widgets/mustache/organization-unclaimed-college-reviews',[
        'org_slug'=>$slug
    ]);
} elseif ($org_details['business_activity'] == 'School') {
    echo $this->render('/widgets/mustache/organization-unclaimed-school-reviews',[
        'org_slug'=>$slug
    ]);
} elseif ($org_details['business_activity'] == 'Educational Institute') {
    echo $this->render('/widgets/mustache/organization-unclaimed-institute-reviews',[
        'org_slug'=>$slug
    ]);
}

$this->registerCss('
.nav-padd-20 {
    padding-left: 50px;
}
.nav-tabs > li.active a, .nav-tabs > li.active a:hover, .nav-tabs > li.active a:focus {
    color: #fff;
    background-color: #00a0e3 !important;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    transition: .2s all;
}
.star-rating1 {
  font-family: "FontAwesome";
}
.star-rating1 > fieldset {
  border: none;
  display: inline-block;
}
.star-rating1 fieldset:not(:checked) input {
  position: absolute;
  top: -9999px;
  clip: rect(0, 0, 0, 0);
}
.star-rating1 fieldset:not(:checked) label {
  float: right;
  width: 1em;
  padding: 0 0.05em;
  overflow: hidden;
  white-space: nowrap;
  cursor: pointer;
  font-size: 200%;
  color: #36c6d3;
  font-family: "FontAwesome";
}
.star-rating1 fieldset:not(:checked) label:before {
  content: "\f006  ";
}
.star-rating1 fieldset:not(:checked) label:hover,
.star-rating1 fieldset:not(:checked) label:hover ~ label {
  color:#36c6d3;
  text-shadow: 0 0 3px #36c6d3;
}
.star-rating1 fieldset:not(:checked) label:hover:before,
.star-rating1 fieldset:not(:checked) label:hover ~ label:before {
  content: "\f005  ";
}
.star-rating1 fieldset input:checked ~ label:before {
  content: "\f005  ";
}
.star-rating1 fieldset label:active {
  position: relative;
  top: 2px;
}

.padd-lr-5{
    padding-left:10px !important;
    padding-right:10px !important;
}   
.light-bg{
    background:#f4f4f4 !important;
}
.rh-header{
    background-image: linear-gradient(141deg, #65c5e9 0%, #25b7f4 51%, #00a0e3 75%);
    background-size:100% 300px;
    background-repeat: no-repeat;
}
.no-padd{
    padding-left:0px !important;
    padding-right:0px !important
}
.padd-10{
    padding-top:20px;
}
.header-bttns-flex{
    text-align:center;
    padding: 20px 0 0 0;
}
.padding_top
{
padding:16px 0px;
}
.follow-bttn button ,.wr-bttn button, .cp-bttn a{
    background:#fff;
    border:1px solid #00a0e3;
    color:#00a0e3;
    padding:12px 15px;
    font-size:14px;
    border-radius:5px;
    text-transform:uppercase;
    margin-bottom: 4px;
}
.cp-center{
    text-align:center;
}
.cp-bttn{
    margin-top:25px;
}
.rh-header{
    padding:80px 0;
    padding-bottom: 30px;
}
.fade_background
{
background: #cadfe8 !important;
}  
.fade_border
{
border: 2px solid #cadfe8 !important;
}  
.logo-box{
    height:150px;
    width:150px;
    background:#fff;
    display:block;
    line-height:150px; 
    text-align:center;
    border-radius:6px;
    margin-bottom: 20px;
}  
.logo-box img, .logo-box canvas{
    border-radius:6px;
}
.com-name{
    font-size:38px;
    font-family: "Lora", serif;
    font-weight: 700;
    color:#fff;
    line-height:50px;
    margin-top: -16px;
}
.com-rating-1{
    padding-top:15px;
}
.com-rating i{
    font-size:16px;
    background:#ccc;
    color:#fff;
    padding:7px 5px;
    border-radius:5px;
}
.com-rating i.active{
    background:#ff7803;
    color:#fff;
}
.com-rate{
    color: #fff;
    font-size: 13px;
    font-style: italic;
    padding:10px 0;
}
.rh-main-heading{
    font-size:30px;
    font-family:lobster;
    padding-left:20px;
}
.refirst{
    padding-top:25px !important;
}
.re-box{
    padding-top:60px;
}
.uicon{
    text-align:center;
}
.uicon img{
    max-height:80px;
    max-width:80px;
}
.uname{
    text-align:center;
    text-transform:uppercase;
    font-weight:bold;
    padding-top:10px;
    line-height:15px;
    color:#00a0e3;
}
.user-saying{
    padding-top:20px;
}
.uheading{
    font-weight:bold;
    
}
.utext{
    text-align:justify;
}
.publish-date{
    text-align:right;
    font-size: 14px;
}
.view-detail-btn button{
    background:transparent;
    border:none;
    font-size:14px;
    padding:0px
}
.view-detail-btn button:hover, .re-btns button:hover{
    color:#00a0e3;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    transition:.3s all;
}
.num-rate{
    
}
.re-btns{
    text-align:right;
    padding-top: 5px;
}
.re-btns button{
    background:none;
    border:none;
    font-size:19px;
    color:#ccc;
}
.re-btns button:hover{
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.re-btns button:hover i.fa-flag{
    color:#d72a2a;
}
.re-btns button i.fa-thumbs-down{
    margin-left:-8px;
}
.utitle{
    font-size:20px;
    font-weight:bold;
    padding-top:8px;
    color:#00a0e3;
}
.user-review-main{
    border-left:2px solid #ccc;
}
.uratingtitle{
    font-size:12px;
    line-height:15px;
}
.urating{
    font-size:25px;
}
.emp-duration{
    text-align:right;
}
.ushare i{
   font-size:20px;
    color:#ccc; 
}
.ushare i.fa-facebook-square:hover{
    color:#4267B2; 
    cursor: pointer;
}
.wa_icon_hover:hover
{
    cursor: pointer;
    color: #56dc56 !important;
}
.ushare i.fa-twitter-square:hover{
    color:#38A1F3; 
    cursor: pointer;
}
.ushare i.fa-linkedin-square:hover{
    color:#0077B5;
    cursor: pointer; 
}
.ushare i.fa-google-plus-square:hover{
    color:#CC3333;
    cursor: pointer;
}
.ushare-heading{
    font-size:14px;
    padding-top:20px;
    line-height:23px;
    font-weight:bold;
}
.usefull-bttn{
    padding-top:33px;
    display:flex;
}
.re-bttn{
    text-align:right
}
.use-bttn button, .notuse-bttn button, .re-bttn button{
    background: transparent !important;
    border:1px solid #ccc;
    color:#ccc;
    padding:5px 15px;
    margin-left:10px;
    border-radius:10px;
    font-size:14px;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.re-bttn{
    padding-bottom:5px;
}
.use-bttn button:hover{
    color:#00a0e3;
    border-color:#00a0e3;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.re-bttn button:hover, .notuse-bttn button:hover{
    color:#d72a2a;
    border-color:#d72a2a;
     transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.review-summary{
    text-align:left;
    padding-left:50px
}
.oa-review{
    font-size:30px;
    font-family:lobster;
    padding-bottom:22px;
}
.rs1{
    padding-top:20px;
}
.re-heading{
    font-size: 17px;
    text-transform: capitalize;
    font-weight: bold;
}
.filter-review{
    padding-top:80px;
//    text-align:center;
}
.form-group.form-md-line-input {
    position: relative;
    margin: 0 0 10px;
    text-align:left;
}
.filter-bttn{
    padding-top:15px;
}
.rs-main{
    background: #00a0e3;
    max-width: 200px;
    padding: 10px 13px 15px 13px;
    text-align: center;
    color: #fff;
    border-radius: 6px;
}
.rating-large{
    font-size:56px;
}

.com-rating-1 i{ 
    font-size:16px;
    background:#fff;
    color:#ccc;
    padding:7px 5px;
    border-radius:5px;
}
.com-rating-1 i.active{
    background:#fff;
    color:#00a0e3;
}
.summary-box{ 
    display:flex
}
.com-rating-2 {
    padding: 13px 23px 15px 42px;
    height: 46px;
    margin-top: 5px;
    border: 2px solid #00a0e3;
    border-radius: 5px;
    margin-left: -30px;
}
.com-rating-2 i{
    font-size:22px;
    color: #ccc;
}
.com-rating-2 .active{
    color:#ff7803;
}
.sr-rating{
   background: #00a0e3;
    padding: 12px 15px;
    z-index: 9;
    color: #fff;
//    margin-left: 11px;
    font-size: 19px;
    border-radius:5px;    
}
.hvr-icon-pulse {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    padding-right:0px;
}
.hvr-icon-pulse .hvr-icon {
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-transition-timing-function: ease-out;
    transition-timing-function: ease-out;
}
.hvr-icon-pulse:hover .hvr-icon, .hvr-icon-pulse:focus .hvr-icon, .hvr-icon-pulse:active .hvr-icon {
    -webkit-animation-name: hvr-icon-pulse;
    animation-name: hvr-icon-pulse;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
}
.btn_review
{
    background: #fff;
    border: 1px solid #00a0e3;
    color: #00a0e3;
    padding: 9px 15px;
    font-size: 14px;
    border-radius: 5px;
    display:block;
    margin-bottom: 4px;
    text-transform: uppercase;
}
.hvr-icon-pulse:before{
    content:"" !important;
}
.filter-bttn button, .load-more-bttn button{
    background: #00a0e3;
    border: 1px solid #00a0e3;
    padding: 12px 25px;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
    border-radius: 40px;
    
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.filter-bttn button:hover, .load-more-bttn button:hover{
    border-radius:8px;
    -webkit-border-radius:8px;
    -moz-border-radius:8px;
    -o-border-radius:8px;
    
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
}
.load-more-bttn{
    padding-top:50px;
    text-align:center;
}
.form-group.form-md-line-input.form-md-floating-label .form-control~label{
    font-size: 14px;
}
.fivestar-box i.active {
    color:#fd7100;
}
.fourstar-box i.active {
    color:#fa8f01;
}
.threestar-box i.active {
    color:#fcac01;
}
.twostar-box i.active {
    color:#fabf37;
}
.onestar-box i.active {
    color:#ffd478;
}

.twitter-typeahead,.tt-menu{
    width:100%;
}
#autocomplete-list,.tt-menu{
    background-color: #fff;
    border-radius: 0px 0px 10px 10px;
    max-height: 350px;
    overflow-y: scroll;
}
#autocomplete-list div,.tt-dataset{
    padding: 3px;
    border-bottom: .5px solid #eee;
    font-size: 16px;
}
#autocomplete-list div:last-child,.tt-dataset:last-child {
    border-bottom:0px;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 50px;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #fff;
  margin: 35px 1px;
}

.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}

.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}

.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}

@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }

  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */
/*-----*/
@media only screen and (max-width: 992px){
    .cp-bttn button {
        margin-top: 20px; 
    }
    .cp-bttn {
        padding-left: 0px;
    }
    .header-bttns{
        display: inline;
        justify-content:center;
        margin: 20px 0 0 0;
    }
    .com-name{
        margin-top:0px;
    }
    .rh-header {
        padding: 65px 0;
          background-size:100% 400px;
    }
    .review-summary{
        padding-top:40px;
    }
    .oa-review{
        padding-bottom:20px;
    }
}

@media only screen and (max-width: 767px){
    .rh-header{
        background-size:100% 520px;
        text-align:center;
    }
    .logo-box{
        margin:0 auto;
    }
}
@media only screen and (max-width: 992px){
    .rh-header {
        padding: 45px 0;
    }
}
.i-review-navigation
{
display:none;
}
.ur-bg{
   background:#edecec;
    color: #000;
    border-radius: 5px;
    padding: 10px 5px;
    border-right: 1px solid #fff;
    min-height: 95px;
}
.user-rating{
    display:flex;
    justify-content:center; 
    text-align:center;
    padding-top:20px;
}
@media only screen and (max-width: 767px){
    .ur-bg {
        background: #edecec;
        color: #000;
        padding: 10px 5px;
        height: 95px;
        width: 200px;
        float: left;
    }
    .user-rating {
        display: inherit;
        justify-content: center;
        text-align: center;
        padding-top: 20px;
    }
    
}
.i-review-box *{
    font-family: "Roboto Slab";
    font-weight:400;
}
.i-review-start-end-title, .i-review-question-title{
    font-weight:700;
}
.i-review-star{
    width: 45px;
    height: 45px;
}
/*----- College css starts -----*/
.rh-header.College{
    background-image: linear-gradient(141deg, #7453c6bd 0%, #7453c6 51%, #7453c6 75%);
}
.rh-header.College div .com-rating-1 i.active, .rh-header.College ~ .rh-body .tab-content .review-summary .rs-main .com-rating-1 i.active{
    color: #7453c6;
}
.rh-header.College .header-bttns button, .rh-header.College .header-bttns a{
    border: 1px solid #7453c6;
    color: #7453c6;
}
.rh-header.College ~ section .nav-tabs > li.active a, .rh-header.College ~ section .nav-tabs > li.active a:hover, .rh-header.College ~ section .nav-tabs > li.active a:focus{
    background-color: #7453c6 !important;
}
.rh-header.College ~ .rh-body .tab-content .review-summary .rs-main, .rh-header.College ~ .rh-body .tab-content .review-summary .rs1 .summary-box .sr-rating{
    background: #7453c6;
}
.rh-header.College ~ .rh-body .tab-content .review-summary .rs1 .summary-box .com-rating-2{
    border-color: #7453c6;
}
.rh-header.College ~ .rh-body .tab-content .review-summary .rs-main.fade_background, .rh-header.College ~ .rh-body .tab-content .review-summary .rs1 .summary-box .sr-rating.fade_background{
    background: #bbaddc !important;
}
.rh-header.College ~ .rh-body .tab-content .review-summary .rs1 .summary-box .com-rating-2.fade_border{
    border-color: #bbaddc !important;
}
/*----- College css ends -----*/

/*----- Educational Institute css starts -----*/
.rh-header.Educational.Institute{
    background-image: linear-gradient(141deg, #da4453c7 0%, #da4453eb 51%, #da4453 75%);
}
.rh-header.Educational.Institute div .com-rating-1 i.active, .rh-header.Educational.Institute ~ .rh-body .tab-content .review-summary .rs-main .com-rating-1 i.active{
    color: #da4453;
}
.rh-header.Educational.Institute .header-bttns button, .rh-header.Educational.Institute .header-bttns a{
    border: 1px solid #da4453;
    color: #da4453;
}
.rh-header.Educational.Institute ~ section .nav-tabs > li.active a, .rh-header.Educational.Institute ~ section .nav-tabs > li.active a:hover, .rh-header.Educational.Institute ~ section .nav-tabs > li.active a:focus{
    background-color: #da4453 !important;
}
.rh-header.Educational.Institute ~ .rh-body .tab-content .review-summary .rs-main, .rh-header.Educational.Institute ~ .rh-body .tab-content .review-summary .rs1 .summary-box .sr-rating{
    background: #da4453;
}
.rh-header.Educational.Institute ~ .rh-body .tab-content .review-summary .rs1 .summary-box .com-rating-2{
    border-color: #da4453;
}
.rh-header.Educational.Institute ~ .rh-body .tab-content .review-summary .rs-main.fade_background, .rh-header.Educational.Institute ~ .rh-body .tab-content .review-summary .rs1 .summary-box .sr-rating.fade_background{
    background: #e8b8bd !important;
}
.rh-header.Educational.Institute ~ .rh-body .tab-content .review-summary .rs1 .summary-box .com-rating-2.fade_border{
    border-color: #e8b8bd !important;
}
/*----- Educational Institute css ends -----*/

/*----- School css starts -----*/
.rh-header.School{
    background-image: linear-gradient(141deg, #0caa41db 0%, #0caa41eb 51%, #0caa41 75%);
}
.rh-header.School div .com-rating-1 i.active, .rh-header.School ~ .rh-body .tab-content .review-summary .rs-main .com-rating-1 i.active{
    color: #0caa41;
}
.rh-header.School .header-bttns button, .rh-header.School .header-bttns a{
    border: 1px solid #0caa41;
    color: #0caa41;
}
.rh-header.School ~ section .nav-tabs > li.active a, .rh-header.School ~ section .nav-tabs > li.active a:hover, .rh-header.School ~ section .nav-tabs > li.active a:focus{
    background-color: #0caa41 !important;
}
.rh-header.School ~ .rh-body .tab-content .review-summary .rs-main, .rh-header.School ~ .rh-body .tab-content .review-summary .rs1 .summary-box .sr-rating{
    background: #0caa41;
}
.rh-header.School ~ .rh-body .tab-content .review-summary .rs1 .summary-box .com-rating-2{
    border-color: #0caa41;
}
.rh-header.School ~ .rh-body .tab-content .review-summary .rs-main.fade_background, .rh-header.School ~ .rh-body .tab-content .review-summary .rs1 .summary-box .sr-rating.fade_background{
    background: #a8e0ba !important;
}
.rh-header.School ~ .rh-body .tab-content .review-summary .rs1 .summary-box .com-rating-2.fade_border{
    border-color: #a8e0ba !important;
}
/*----- School css ends -----*/
');
$script = <<< JS
$(document).on("click", "#widget_bar_stats label", function(e){
    e.preventDefault();
    var id = "#" + $(this).attr("for");
    $(id).prop("checked", true);
});
$(document).on('click','.load_reviews',function(e){
    e.preventDefault();
    $.ajax({
        url:'/organizations/load-reviews',                         
        method: 'post',
        beforeSend:function(){
         $('.load_reviews').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
        },
        success:function(res){
            if(res==true){
                $('.load_reviews').html('<i class="fa fa-heart-o hvr-icon"></i> Load More');
                }
         }
    });        
});
var yearsObj = [];
selectObj = {
    label : '-Select-',
    value : ''
};
yearsObj.push(selectObj);
var currentD = new Date();
var currentY = currentD.getFullYear();
for(var i=currentY; i > 1950; i--){
    var singleObj = {};
    singleObj['label'] = i;
    singleObj['value'] = i;
    yearsObj.push(singleObj);
}
var popup = new ideaboxPopup({
			background : '#2995c2',
			popupView : 'full',
			startPage: {
					msgTitle        : 'Rate the company on the following criteria :',
					msgDescription 	: '',
					startBtnText	: "Let's Get Start",
					showCancelBtn	: false,
					cancelBtnText	: 'Cancel'

			},
			endPage: {
					msgTitle	: 'Thank you :) ',
					msgDescription 	: 'We thank you for giving your review about the company',
					showCloseBtn	: true,
					closeBtnText	: 'Close All',
					inAnimation     : 'zoomIn'
			},
			data: [
					{
						question 	: 'Post Your Review As',
						answerType	: 'radio',
						formName	: 'user',
						choices     : [
								{ label : 'Anonymous', value : 'anonymous' },
								{ label : 'With your Name', value : 'credentials' },
						],
						description	: 'Please select anyone choice.',
						nextLabel	: 'Go to Step 2',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select one</b>'
					},
					{
						question 	: 'Are you a current or former employee?',
						answerType	: 'radio',
						formName	: 'current_employee',
						choices     : [
								{ label : 'Current', value : 'current' },
								{ label : 'Former', value : 'former' },
						],
						description	: 'Please select anyone choice.',
						nextLabel	: 'Go to Step 3',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select one</b>'
					},
					{
						question 	: 'Period of work',
						answerType	: 'selectbox',
						formName	: 'tenure',
						choices : [
							[
								{ label : '-Select-', value : '' },
								{ label : 'January', value : '1' },
								{ label : 'February', value : '2' },
								{ label : 'March', value : '3' },
								{ label : 'April', value : '4' },
								{ label : 'May', value : '5' },
								{ label : 'June', value : '6' },
								{ label : 'July', value : '7' },
								{ label : 'August', value : '8' },
								{ label : 'September', value : '9' },
								{ label : 'October', value : '10' },
								{ label : 'Novemeber', value : '11' },
								{ label : 'December', value : '12' },
							],
							yearsObj
						],
						description	: 'Choose dates of work.',
						nextLabel	: 'Go to Step 4',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please selecty our tenure</b>'
					},
					{
						question 	: 'Skill Development & Learning',
						answerType	: 'starrate',
						starCount	: 5,
						formName	: 'skill_development',
						description	: '',
						nextLabel	: 'Go to Step 5',
						required	: true,
						errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
					},
					{
						question 	: 'Work-Life Balance',
						answerType	: 'starrate',
						starCount	: 5,
						formName	: 'work_life',
						description	: '',
						nextLabel	: 'Go to Step 5',
						required	: true,
						errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
					},
					{
						question 	: 'Compensation & Benefits',
						answerType	: 'starrate',
						starCount	: 5,
						formName	: 'compensation',
						description	: '',
						nextLabel	: 'Go to Step 7',
						required	: true,
						errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
					},
					{
						question 	: 'Company culture',
						answerType	: 'starrate',
						starCount	: 5,
						formName	: 'organization_culture',
						description	: '',
						nextLabel	: 'Go to Step 8',
						required	: true,
						errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
					},
					{
						question 	: 'Job Security',
						answerType	: 'starrate',
						starCount	: 5,
						formName	: 'job_security',
						description	: '',
						nextLabel	: 'Go to Step 9',
						required	: true,
						errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
					},
					{
						question 	: 'Growth & Opportunities',
						answerType	: 'starrate',
						starCount	: 5,
						formName	: 'growth',
						description	: '',
						nextLabel	: 'Go to Step 10',
						required	: true,
						errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
					},
					{
						question 	: 'Work Satisfaction',
						answerType	: 'starrate',
						starCount	: 5,
						formName	: 'work',
						description	: '',
						nextLabel	: 'Go to Step 11',
						required	: true,
						errorMsg	: '<b style="color:#900;">Rate to proceed</b>'
					},
				
					{
						question 	: 'Select City of Your Office',
						answerType	: 'location_autocomplete',
						formName	: 'location',
						description	: 'Please enter your office location',
						nextLabel	: 'Go to Step 12',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select a location.</b>'
					},
					{
						question 	: 'Select Your Job Profile',
						answerType	: 'department_autocomplete',
						formName	: 'department',
						description	: 'Please enter your department or division',
						nextLabel	: 'Go to Step 13',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select a department</b>'
					},
					{
						question 	: 'Select Your Designation',
						answerType	: 'designation_autocomplete',
						formName	: 'designation',
						description	: 'Please enter your designation',
						nextLabel	: 'Go to Step 14',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select a department</b>'
					},
					{
						question 	: 'Things you like about the company',
						answerType	: 'textarea',
						formName	: 'likes',
						description	: 'For eg :- Talk about teammates, training, job security, career growth, salary appraisal, travel, politics, learning, work environment, innovation, work-life balance, etc.',
						nextLabel	: 'Go to Step 15',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please write a review</b>'
					},
					{
						question 	: 'Things you dislike about the company',
						answerType	: 'textarea',
						formName	: 'dislikes',
						description	: 'For eg :- Talk about teammates, training, job security, career growth, salary appraisal, travel, politics, learning, work environment, innovation, work-life balance, etc.',
						nextLabel	: 'Finish',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please share your reviews.</b>'
					
					}
			]
			});
var popup2 = new ideaboxPopupCollege({
            background	: '#2995c2',
            popupView : 'full',
			onFinish: function(){
				ajax_college(this.values);
			},
			startPage: {
					msgTitle        : 'Rate the College/University on the following criteria :',
					msgDescription 	: '',
					startBtnText	: "Let's Get Start",
					showCancelBtn	: false,
					cancelBtnText	: 'Cancel'

			},
			endPage: {
					msgTitle	: 'Thank you :) ',
					msgDescription 	: 'We thank you for giving your review about the College/University',
					showCloseBtn	: true,
					closeBtnText	: 'Close All',
					inAnimation     : 'zoomIn'
			},
			data: [
			    {
					question 	: 'City Of College/University',
					answerType	: 'colleg_city_autocomplete',
					formName	: 'college_city',
					description	: 'Please input City Of The College/University..',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Please Choose A Valid City.'

				},
				{
						question 	: 'Post Your Review As',
						answerType	: 'radio',
						formName	: 'user',
						choices     : [
								{ label : 'Anonymous', value : 'anonymous' },
								{ label : 'With your Name', value : 'credentials' },
						],
						description	: 'Please select anyone choice.',
						nextLabel	: 'Next',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select one</b>'
				},
				{
						question 	: 'Are you a current or former student?',
						answerType	: 'radio',
						formName	: 'current_employee',
						choices     : [
								{ label : 'Current', value : 'current' },
								{ label : 'Former', value : 'former' },
						],
						description	: 'Please select anyone choice.',
						nextLabel	: 'Go to Step 3',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select one</b>'
					},
				{
					question 	: 'Academic Year:',
					answerType	: 'selectbox',
					formName	: 'tenure',
					choices : [
							[
								{ label : '-Select-', value : '' },
								{ label : 'January', value : '1' },
								{ label : 'February', value : '2' },
								{ label : 'March', value : '3' },
								{ label : 'April', value : '4' },
								{ label : 'May', value : '5' },
								{ label : 'June', value : '6' },
								{ label : 'July', value : '7' },
								{ label : 'August', value : '8' },
								{ label : 'September', value : '9' },
								{ label : 'October', value : '10' },
								{ label : 'Novemeber', value : '11' },
								{ label : 'December', value : '12' },
							],
							yearsObj
						],
					description	: '',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Please select Your Academic Year Correctly.'
				},
				{
					question 	: 'Educational Stream',
					answerType	: 'stream_autocomplete',
					formName	: 'stream',
					description	: 'Please input Your Education Stream..',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Please Choose A Valid Stream.'

				},
				{
					question 	: 'Academics',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'academics',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Faculity & Teaching Quality',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'faculity',
					description	: '',
					nextLabel	: 'Next',
					required	: true,
				},
				{
					question 	: 'Infrastructure',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'infrastructure',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Accomodation & Food',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'accomodation_food',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Placements/Internships',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'placement',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				
				},
				{
					question 	: 'Social Life/Extracurriculars',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'social_life',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Culture & Diversity',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'culture',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Likes',
					answerType	: 'textarea',
					formName	: 'likes',
					description	: 'Please input any words..',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Write Something.'
				},
				{
					question 	: 'Dislikes',
					answerType	: 'textarea',
					formName	: 'dislikes',
					description	: 'Please input any words..',
					required	: true,
					errorMsg	: '<b style="color:#900;">Please share your reviews.</b>',
					nextLabel	: 'Finish',
				}
				
			]
		});
var popup3 = new ideaboxPopupSchool({
            background	: 'url("/assets/themes/ey/ideapopup/bg-example-1.jpg") center center / cover no-repeat',
            popupView : 'full',
			onFinish: function(){
				ajax_school(this.values);
			},
			startPage: {
					msgTitle        : 'Rate the School on the following criteria :',
					msgDescription 	: '',
					startBtnText	: "Let's Get Start",
					showCancelBtn	: false,
					cancelBtnText	: 'Cancel'

			},
			endPage: {
					msgTitle	: 'Thank you :) ',
					msgDescription 	: 'We thank you for giving your review about the School',
					showCloseBtn	: true,
					closeBtnText	: 'Close All',
					inAnimation     : 'zoomIn'
			},
			data: [
			    {
					question 	: 'City Of School',
					answerType	: 'colleg_city_autocomplete',
					formName	: 'college_city',
					description	: 'Please input City Of The College/University..',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Please Choose A Valid City.'

				},
				{
						question 	: 'Post Your Review As',
						answerType	: 'radio',
						formName	: 'user',
						choices     : [
								{ label : 'Anonymous', value : 'anonymous' },
								{ label : 'With your Name', value : 'credentials' },
						],
						description	: 'Please select anyone choice.',
						nextLabel	: 'Next',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select one</b>'
				},
				{
						question 	: 'Are you a current or former student?',
						answerType	: 'radio',
						formName	: 'current_employee',
						choices     : [
								{ label : 'Current', value : 'current' },
								{ label : 'Former', value : 'former' },
						],
						description	: 'Please select anyone choice.',
						nextLabel	: 'Go to Step 3',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select one</b>'
					},
				{
					question 	: 'Academic Year:',
					answerType	: 'selectbox',
					formName	: 'tenure',
					choices : [
							[
								{ label : '-Select-', value : '' },
								{ label : 'January', value : '1' },
								{ label : 'February', value : '2' },
								{ label : 'March', value : '3' },
								{ label : 'April', value : '4' },
								{ label : 'May', value : '5' },
								{ label : 'June', value : '6' },
								{ label : 'July', value : '7' },
								{ label : 'August', value : '8' },
								{ label : 'September', value : '9' },
								{ label : 'October', value : '10' },
								{ label : 'Novemeber', value : '11' },
								{ label : 'December', value : '12' },
							],
							yearsObj
						],
					description	: '',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Please select Your Academic Year Correctly.'
				},
				{
					question 	: 'Educational Stream',
					answerType	: 'stream_autocomplete',
					formName	: 'stream',
					description	: 'Please input Your Education Stream..',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Please Choose A Valid Stream.'

				},
				{
					question 	: 'Student Engagement',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'student_engagement',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Infrastructure',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'infrastructure',
					description	: '',
					nextLabel	: 'Next',
					required	: true,
				},
				{
					question 	: 'Faculty',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'faculty',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Accessibility of Faculty',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'accessibility_of_faculty',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Co-curricular Activitie',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'co_curricular_activitie',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				
				},
				{
					question 	: 'Leadership Development',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'leadership_development',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Sports',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'sports',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Likes',
					answerType	: 'textarea',
					formName	: 'likes',
					description	: 'Please input any words..',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Write Something.'
				},
				{
					question 	: 'Dislikes',
					answerType	: 'textarea',
					formName	: 'dislikes',
					description	: 'Please input any words..',
					required	: true,
					errorMsg	: '<b style="color:#900;">Please share your reviews.</b>',
					nextLabel	: 'Finish',
				}
				
			]
		});
var popup4 = new ideaboxPopupInstitute({
            background	: '#2995c2',
            popupView : 'full',
			onFinish: function(){
				ajax_institute(this.values);
			},
			startPage: {
					msgTitle        : 'Rate the Institute on the following criteria :',
					msgDescription 	: '',
					startBtnText	: "Let's Get Start",
					showCancelBtn	: false,
					cancelBtnText	: 'Cancel'

			},
			endPage: {
					msgTitle	: 'Thank you :) ',
					msgDescription 	: 'We thank you for giving your review about the Institute',
					showCloseBtn	: true,
					closeBtnText	: 'Close All',
					inAnimation     : 'zoomIn'
			},
			data: [
			    {
					question 	: 'City Of Institute',
					answerType	: 'colleg_city_autocomplete',
					formName	: 'college_city',
					description	: 'Please input City Of The Institute..',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Please Choose A Valid City.'

				},
				{
						question 	: 'Post your review',
						answerType	: 'radio',
						formName	: 'user',
						choices     : [
								{ label : 'Anonymously', value : 'anonymous' },
								{ label : 'With your Name', value : 'credentials' },
						],
						description	: 'Please select anyone choice.',
						nextLabel	: 'Next',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select one</b>'
				},
				{
						question 	: 'Are you a current or former student?',
						answerType	: 'radio',
						formName	: 'current_employee',
						choices     : [
								{ label : 'Current', value : 'current' },
								{ label : 'Former', value : 'former' },
						],
						description	: 'Please select anyone choice.',
						nextLabel	: 'Go to Step 3',
						required	: true,
						errorMsg	: '<b style="color:#900;">Please select one</b>'
					},
				{
					question 	: 'Academic Year:',
					answerType	: 'selectbox',
					formName	: 'tenure',
					choices : [
							[
								{ label : '-Select-', value : '' },
								{ label : 'January', value : '1' },
								{ label : 'February', value : '2' },
								{ label : 'March', value : '3' },
								{ label : 'April', value : '4' },
								{ label : 'May', value : '5' },
								{ label : 'June', value : '6' },
								{ label : 'July', value : '7' },
								{ label : 'August', value : '8' },
								{ label : 'September', value : '9' },
								{ label : 'October', value : '10' },
								{ label : 'Novemeber', value : '11' },
								{ label : 'December', value : '12' },
							],
							yearsObj
						],
					description	: '',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Please select Your Academic Year Correctly.'
				},
				{
					question 	: 'Educational Stream',
					answerType	: 'stream_autocomplete',
					formName	: 'stream',
					description	: 'Please input Your Education Stream..',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Please Choose A Valid Stream.'

				},
				{
					question 	: 'Student Engagement',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'student_engagement',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Infrastructure',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'infrastructure',
					description	: '',
					nextLabel	: 'Next',
					required	: true,
				},
				{
					question 	: 'Faculty',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'faculty',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Value for Money',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'value_for_money',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Teaching Style',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'teaching_style',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				
				},
				{
					question 	: 'Coverage of Subject Matter',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'coverage_of_subject_matter',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Accessibility of Faculty',
					answerType	: 'starrate',
					starCount	: 5,
					formName	: 'accessibility_of_faculty',
					description	: '',
					nextLabel	: 'Next',
					required	: true
				},
				{
					question 	: 'Likes',
					answerType	: 'textarea',
					formName	: 'likes',
					description	: 'Please input any words..',
					nextLabel	: 'Next',
					required	: true,
					errorMsg	: 'Write Something.'
				},
				{
					question 	: 'Dislikes',
					answerType	: 'textarea',
					formName	: 'dislikes',
					description	: 'Please input any words..',
					required	: true,
					errorMsg	: 'Write Something.',
					nextLabel	: 'Finish',
				}
				
			]
		});
if($("#wr").length>0){
document.getElementById("wr").addEventListener("click", function(e){
            popup.open();
        });
}
if($("#wr1").length>0){
    if (business_type=='College'){ 
document.getElementById("wr1").addEventListener("click", function(e){
            popup2.open();
        });
}
    else if (business_type=='School')
        {
            document.getElementById("wr1").addEventListener("click", function(e){
            popup3.open();
        });
        }
     else if (business_type=='Educational Institute')
        {
            document.getElementById("wr1").addEventListener("click", function(e){
            popup4.open();
        });
        }
}
JS;
$headScript = <<< JS
function ajax_institute(data) {
  var type = 'institute';
	$.ajax({
       method: 'POST',
       url : '/organizations/post-college-company-reviews',
	   data:{data:data,type:type,slug:slug},
       success: function(response) {
               if (response==false)
                   {
                       alert('there is some server error');
                   }
               else
                   {
                       window.location = window.location.pathname;
                   }
          }});
}
function review_post_ajax(data) {
    var type = 'company';
	$.ajax({
       method: 'POST',
       url : '/organizations/post-college-company-reviews',
	   data:{data:data,type:type,slug:slug},
       success: function(response) {
               if (response==false)
                   {
                       alert('there is some server error');
                   }
               else
                   {
                       window.location = window.location.pathname;
                   }
          }});
}
function ajax_school(data) {
    var type = 'school';
	$.ajax({
       method: 'POST',
       url : '/organizations/post-college-company-reviews',
	   data:{data:data,type:type,slug:slug},
       success: function(response) {
               if (response==false)
                   {
                       alert('there is some server error');
                   }
               else
                   {
                       window.location = window.location.pathname;
                   }
          }});
}
function ajax_college(data) {
    var type =  'college';
	$.ajax({
       method: 'POST',
       url : '/organizations/post-college-company-reviews',
	   data:{data:data,type:type,slug:slug},
       success: function(response) {
               if (response==false)
                   {
                       alert('there is some server error');
                   }
               else
                   {
                       window.location = window.location.pathname;
                   }
          }});
}
JS;
$this->registerJs($script);
$this->registerJs($headScript, yii\web\View::POS_HEAD);
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup-school.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup-school.css');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
//$this->registerCssFile('https://fonts.googleapis.com/css?family=Quicksand:300,500');
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup-college.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup-college.css');
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup-institute.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/ideapopup/ideapopup-review.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup-institute.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script id="review-cards" type="text/template">

</script>