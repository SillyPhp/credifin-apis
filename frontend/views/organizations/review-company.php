<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$radios_array = [1=>1,2=>2,3=>3,4=>4,5=>5];
$this->title = $org_details['name'].' '.Yii::$app->params->seo_settings->title_separator.' Reviews';
Yii::$app->view->registerJs('var slug = "'. $slug.'"',  \yii\web\View::POS_HEAD);
$overall_avg = array_sum($stats)/count($stats);
$round_avg = round($overall_avg);
$logo_image = Yii::$app->params->upload_directories->organizations->logo . $org_details['logo_location'] . DIRECTORY_SEPARATOR . $org_details['logo'];
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
<section class="rh-header">
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
                                    color="<?= $org_details['initials_color']?>" font="70px"></canvas>
                            <?php
                        }
                        ?>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="com-name"><?= ucwords($org_details['name']); ?></div>
                <div class="com-rating-1">
                    <?php for ($i=1;$i<=5;$i++){ ?>
                        <i class="fa fa-star <?=(($round_avg<$i) ?  '': 'active') ?>"></i>
                    <?php } ?>
                </div>
                <div class="com-rate"><?= $round_avg ?>/5 - based on <?= count($reviews); ?> reviews</div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="header-bttns">
                    <div class="header-bttns-flex">
                        <?php if (!Yii::$app->user->isGuest){ ?>
                        <?php if (!empty($follow) && $follow['followed'] == 1) {
                            ?>
                            <div class="follow-bttn hvr-icon-pulse">
                                <button type="button" class="follow" value="<?= $org_details['organization_enc_id']; ?>"><i class="fa fa-heart-o hvr-icon"></i> Following</button>
                            </div>
                            <?php
                        } else  {
                            ?>
                            <div class="follow-bttn hvr-icon-pulse">
                                <button type="button" class="follow" value="<?= $org_details['organization_enc_id']; ?>"><i class="fa fa-heart-o hvr-icon"></i> Follow</button>
                            </div>
                        <?php }} else { ?>
                            <div class="follow-bttn hvr-icon-pulse">
                                <button type="button" data-toggle="modal" data-target="#loginModal"><i class="fa fa-heart-o hvr-icon"></i> Follow</button>
                            </div>
                        <?php } ?>
                            <?php if (!Yii::$app->user->isGuest){
                                if(!empty($edit)){ ?>
                        <div class="wr-bttn hvr-icon-pulse">
                              <a href="javascript:;" data-toggle="modal" data-target="#edit_review" class="btn_review"><i class="fa fa-comments-o hvr-icon"></i> Edit Your Review</a>
                        </div>
                               <?php } else {
                                     if (empty(Yii::$app->user->identity->organization_enc_id)){ ?>
                        <div class="wr-bttn hvr-icon-pulse">
                                    <button type="button" id="wr"><i class="fa fa-comments-o hvr-icon"></i> Write Review</button>
                        </div>
                            <?php } } } else{ ?>
                        <div class="wr-bttn hvr-icon-pulse">
                                <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="btn_review"><i class="fa fa-comments-o hvr-icon"></i> Write Review</a>
                        </div>
                            <?php } ?>
                    </div>
                    <div class="col-md-12 cp-center no-padd">
                        <div class="cp-bttn hvr-icon-pulse">
                            <?php if ($review_type=='unclaimed'):?>
<!--                                <a href="#" type="button"><i class="fa fa-eye hvr-icon"></i> Claim This Profile</a>-->
                            <?php else: ?>
                                <a href="/<?=$slug;?>" type="button"><i class="fa fa-eye hvr-icon"></i> View Company Profile</a>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="rh-body">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="heading-style">Reviews </h1>
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
                            <div class="rs-main <?= (($reviews) ? '': 'fade_background') ?>">
                                <div class="rating-large"><?= $round_avg ?>/5</div>
                                <div class="com-rating-1">
                                    <?php for ($i=1;$i<=5;$i++){ ?>
                                        <i class="fa fa-star <?=(($round_avg<$i) ?  '': 'active') ?>"></i>
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
                                    <div class="sr-rating <?= (($reviews) ? '': 'fade_background') ?>"> <?= $stats['job_avg']; ?> </div>
                                    <div class="fourstar-box com-rating-2 <?= (($reviews) ? '': 'fade_border') ?>">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                        <i class="fa fa-star <?=(($stats['job_avg']<$i) ?  '': 'active') ?>"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Career growth </div>
                                <div class="summary-box">
                                    <div class="sr-rating <?= (($reviews) ? '': 'fade_background') ?>"> <?= $stats['growth_avg']; ?> </div>
                                    <div class="fourstar-box com-rating-2 <?= (($reviews) ? '': 'fade_border') ?>">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star <?=(($stats['growth_avg']<$i) ?  '': 'active') ?>"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Company culture </div>
                                <div class="summary-box">
                                    <div class="sr-rating <?= (($reviews) ? '': 'fade_background') ?>"> <?= $stats['avg_cult']; ?> </div>
                                    <div class="fourstar-box com-rating-2 <?= (($reviews) ? '': 'fade_border') ?>">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star <?=(($stats['avg_cult']<$i) ?  '': 'active') ?>"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Salary & Benefits</div>
                                <div class="summary-box">
                                    <div class="sr-rating <?= (($reviews) ? '': 'fade_background') ?>"> <?= $stats['avg_compensation']; ?> </div>
                                    <div class="fourstar-box com-rating-2 <?= (($reviews) ? '': 'fade_border') ?>">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star <?=(($stats['avg_compensation']<$i) ?  '': 'active') ?>"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Work Satisfaction</div>
                                <div class="summary-box">
                                    <div class="sr-rating <?= (($reviews) ? '': 'fade_background') ?>"> <?= $stats['avg_work']; ?> </div>
                                    <div class="threestar-box com-rating-2 <?= (($reviews) ? '': 'fade_border') ?>">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star <?=(($stats['avg_work']<$i) ?  '': 'active') ?>"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Work-Life Balance</div>
                                <div class="summary-box">
                                    <div class="sr-rating <?= (($reviews) ? '': 'fade_background') ?>"> <?= $stats['avg_work_life']; ?> </div>
                                    <div class="fourstar-box com-rating-2 <?= (($reviews) ? '': 'fade_border') ?>">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star <?=(($stats['avg_work_life']<$i) ?  '': 'active') ?>"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Skill development </div>
                                <div class="summary-box">
                                    <div class="sr-rating <?= (($reviews) ? '': 'fade_background') ?>"> <?= $stats['avg_skill']; ?> </div>
                                    <div class="fourstar-box com-rating-2 <?= (($reviews) ? '': 'fade_border') ?>">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star <?=(($stats['avg_skill']<$i) ?  '': 'active') ?>"></i>
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
</section>
<div id="edit_review" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Your Review</h4>
            </div>
            <div class="modal-body">
            <?php
            if ($review_type=='claimed') {
                $url = Url::to(['/organizations/edit-review?request_type=1']);
                $request_type = 1;
            }
            else
            {
                $url = Url::to(['/organizations/edit-review?request_type=2']);
                $request_type = 2;
            }
            $form = ActiveForm::begin([
            'id' => 'edit-review-form',
            'action'=>$url,
            'fieldConfig' => [
                'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
            ]
            ]);
            ?>
             <div class="row">
                 <div class="col-md-6 col-md-offset-1">
                     <?= $form->field($editReviewForm, 'identity')->dropDownList([0=>Anonymous,1=>Yii::$app->user->identity->first_name.' '.Yii::$app->user->identity->last_name])->label('Post As'); ?>
                 </div>
             </div>
             <div class="row">
                 <div class="col-md-3 col-md-offset-1">
                     <label class="control-label padding_top">Career Growth</label>
                 </div>
                 <div class="col-md-8">
                     <div class="star-rating1">
                         <fieldset>
                             <?=
                             $form->field($editReviewForm, 'career_growth',['template'=>'{input}{error}'])->inline()->radioList([
                                 5 => '5 stars',
                                 4 => '4 stars',
                                 3 => '3 stars',
                                 2 => '2 stars',
                                 1 => '1 stars',
                             ], [
                                 'item' => function($index, $label, $name, $checked, $value) {
                                     $return = '<input type="radio" id="career'.$index.'" name="'.$name.'" value="'.$value.'" ' . (($checked) ? 'checked' : '') . '>';
                                     $return .= '<label for="career'.$index.'" title="'.$label.'">"'.$label.'"</label>';
                                     return $return;
                                 }
                             ])->label(false);
                             ?>
                         </fieldset>
                     </div>
                 </div>
             </div>
               <div class="row">
                 <div class="col-md-3 col-md-offset-1">
                     <label class="control-label padding_top">Company Culture</label>
                 </div>
                   <div class="col-md-8">
                     <div class="star-rating1">
                         <fieldset>
                             <?=
                             $form->field($editReviewForm, 'compnay_culture',['template'=>'{input}{error}'])->inline()->radioList([
                                 5 => '5 stars',
                                 4 => '4 stars',
                                 3 => '3 stars',
                                 2 => '2 stars',
                                 1 => '1 stars',
                             ], [
                                 'item' => function($index, $label, $name, $checked, $value) {
                                     $return = '<input type="radio" id="compnay_culture'.$index.'" name="'.$name.'" value="'.$value.'" ' . (($checked) ? 'checked' : '') . '>';
                                     $return .= '<label for="compnay_culture'.$index.'" title="'.$label.'">"'.$label.'"</label>';
                                     return $return;
                                 }
                             ])->label(false);
                             ?>
                         </fieldset>
                     </div>
                 </div>
               </div>
                <div class="row">
                    <div class="col-md-3 col-md-offset-1">
                        <label class="control-label padding_top">Salary Benefits</label>
                    </div>
                    <div class="col-md-8">
                     <div class="star-rating1">
                         <fieldset>
                             <?=
                             $form->field($editReviewForm, 'salary_benefits',['template'=>'{input}{error}'])->inline()->radioList([
                                 5 => '5 stars',
                                 4 => '4 stars',
                                 3 => '3 stars',
                                 2 => '2 stars',
                                 1 => '1 stars',
                             ], [
                                 'item' => function($index, $label, $name, $checked, $value) {
                                     $return = '<input type="radio" id="salary_benefits'.$index.'" name="'.$name.'" value="'.$value.'" ' . (($checked) ? 'checked' : '') . '>';
                                     $return .= '<label for="salary_benefits'.$index.'" title="'.$label.'">"'.$label.'"</label>';
                                     return $return;
                                 }
                             ])->label(false);
                             ?>
                         </fieldset>
                     </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-md-3 col-md-offset-1">
                     <label class="control-label padding_top">Work satisfaction</label>
                 </div>
                 <div class="col-md-8">
                     <div class="star-rating1">
                         <fieldset>
                             <?=
                             $form->field($editReviewForm, 'work_satisfaction',['template'=>'{input}{error}'])->inline()->radioList([
                                 5 => '5 stars',
                                 4 => '4 stars',
                                 3 => '3 stars',
                                 2 => '2 stars',
                                 1 => '1 stars',
                             ], [
                                 'item' => function($index, $label, $name, $checked, $value) {
                                     $return = '<input type="radio" id="work_satisfaction'.$index.'" name="'.$name.'" value="'.$value.'" ' . (($checked) ? 'checked' : '') . '>';
                                     $return .= '<label for="work_satisfaction'.$index.'" title="'.$label.'">"'.$label.'"</label>';
                                     return $return;
                                 }
                             ])->label(false);
                             ?>
                         </fieldset>
                     </div>
                 </div>
             </div>
              <div class="row">
                 <div class="col-md-3 col-md-offset-1">
                     <label class="control-label padding_top">Work-Life Balance</label>
                 </div>
                  <div class="col-md-8">
                     <div class="star-rating1">
                         <fieldset>
                             <?=
                             $form->field($editReviewForm, 'work_life',['template'=>'{input}{error}'])->inline()->radioList([
                                 5 => '5 stars',
                                 4 => '4 stars',
                                 3 => '3 stars',
                                 2 => '2 stars',
                                 1 => '1 stars',
                             ], [
                                 'item' => function($index, $label, $name, $checked, $value) {
                                     $return = '<input type="radio" id="work_life'.$index.'" name="'.$name.'" value="'.$value.'" ' . (($checked) ? 'checked' : '') . '>';
                                     $return .= '<label for="work_life'.$index.'" title="'.$label.'">"'.$label.'"</label>';
                                     return $return;
                                 }
                             ])->label(false);
                             ?>
                         </fieldset>
                     </div>
                  </div>
              </div>
               <div class="row">
                 <div class="col-md-3 col-md-offset-1">
                     <label class="control-label padding_top">Skill Development</label>
                 </div>
                   <div class="col-md-8">
                     <div class="star-rating1">
                         <fieldset>
                             <?=
                             $form->field($editReviewForm, 'skill_devel',['template'=>'{input}{error}'])->inline()->radioList([
                                 5 => '5 stars',
                                 4 => '4 stars',
                                 3 => '3 stars',
                                 2 => '2 stars',
                                 1 => '1 stars',
                             ], [
                                 'item' => function($index, $label, $name, $checked, $value) {
                                     $return = '<input type="radio" id="skill_devel'.$index.'" name="'.$name.'" value="'.$value.'" ' . (($checked) ? 'checked' : '') . '>';
                                     $return .= '<label for="skill_devel'.$index.'" title="'.$label.'">"'.$label.'"</label>';
                                     return $return;
                                 }
                             ])->label(false);
                             ?>
                         </fieldset>
                     </div>
                   </div>
             </div>
             <div class="row">
                     <div class="col-md-3 col-md-offset-1">
                         <label class="control-label padding_top">Job Security</label>
                     </div>
                     <div class="col-md-8">
                         <div class="star-rating1">
                             <fieldset>
                                 <?=
                                 $form->field($editReviewForm, 'job_security',['template'=>'{input}{error}'])->inline()->radioList([
                                     5 => '5 stars',
                                     4 => '4 stars',
                                     3 => '3 stars',
                                     2 => '2 stars',
                                     1 => '1 stars',
                                 ], [
                                     'item' => function($index, $label, $name, $checked, $value) {
                                         $return = '<input type="radio" id="job_security'.$index.'" name="'.$name.'" value="'.$value.'" ' . (($checked) ? 'checked' : '') . '>';
                                         $return .= '<label for="job_security'.$index.'" title="'.$label.'">"'.$label.'"</label>';
                                         return $return;
                                     }
                                 ])->label(false);
                                 ?>
                             </fieldset>
                         </div>
                     </div>
             </div>
             <div class="row">
                 <div class="col-md-12">
                     <?= $form->field($editReviewForm, 'likes')->textArea(['rows'=>4])->label('Likes'); ?>
                 </div>
                 <div class="col-md-12">
                     <?= $form->field($editReviewForm, 'dislikes')->textArea(['rows'=>4])->label('Dislikes'); ?>
                 </div>
             </div>
              <div class="row">
                 <div class="col-md-12">
                     <?= $form->field($editReviewForm, 'org_id',['template'=>'{input}'])->hiddenInput()->label(false); ?>
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
</div>
<?php
if ($review_type=='claimed')
{
    echo $this->render('/widgets/mustache/organization-reviews',[
        'org_slug'=>$slug
    ]);
}else
{
    echo $this->render('/widgets/mustache/organization-unclaimed-reviews',[
        'org_slug'=>$slug
    ]);
}

$this->registerCss('
.i-review-navigation
{
display:none;
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
    display:flex;
    padding: 20px 0 0 0;
    justify-content:center;
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
}
.cp-center{
    text-align:center;
}
.cp-bttn{
    margin-top:25px;
}
.rh-header{
    padding:80px 0;
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
//    padding:0 10px;
    background:#fff;
    display:block;
    line-height:150px; 
    text-align:center;
    border-radius:6px;
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
.user-rating{
    display:flex;
    justify-content:center; 
    text-align:center;
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
//    font-style:italic;
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
.ur-bg{
   background:#edecec;
    color: #000;
    border-radius: 5px;
    padding: 10px 5px;
    border-right: 1px solid #fff;
    height: 95px;
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
//    line-height:18px;
//    padding-top:20px;
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
    padding-right:1.2em;
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
');
$script = <<< JS
$(document).on("click", ".star-rating1 label", function(e){
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
						question 	: 'Post your review',
						answerType	: 'radio',
						formName	: 'user',
						choices     : [
								{ label : 'Anonymously', value : 'anonymous' },
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
					
					},
			]
			});
if($("#wr").length>0){
document.getElementById("wr").addEventListener("click", function(e){
            popup.open();
        });
}
JS;
$headScript = <<< JS
function review_post_ajax(data) {
	$.ajax({
       method: 'POST',
       url : '/organizations/post-reviews?slug='+slug+'&request_type='+$request_type,
	   data:{data:data},
       success: function(response) {
               if (response==true)
                   {
                       window.location = window.location.pathname;
                   }
               else 
                   {
                       window.location = window.location.pathname;
                   }
          }
	});
}
JS;
$this->registerJs($script);
$this->registerJs($headScript,yii\web\View::POS_HEAD);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/ideapopup/ideapopup-review.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script id="review-cards" type="text/template">

</script>