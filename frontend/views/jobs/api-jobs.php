<?php

use borales\extensions\phoneInput\PhoneInput;
use common\models\RandomColors;
use frontend\models\script\ImageScript;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$date = new DateTime($get['created_at']);
$now = new DateTime();
$diff = date_diff($now, $date);
$diff = $date->diff($now)->format("%d");

if($diff > 30){
    $get['last_date'] = Date('d:m:y', strtotime('+30 days'));
}


$type = 'Job';
$separator = Yii::$app->params->seo_settings->title_separator;
if (!isset($get['company_logo']) || empty($get['company_logo'])) {
    $org = \common\models\UnclaimedOrganizations::find()
        ->select(['logo', 'logo_location'])
        ->where(['organization_enc_id' => $app['unclaimed_organization_enc_id']])
        ->asArray()->one();
    $get['company_logo'] = (($org['logo']) ? Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo . $org['logo_location'] . DIRECTORY_SEPARATOR . $org['logo'], 'https') : null);
}
if (is_array($get['location'])) {
    $p = '';
    foreach ($get['location'] as $loc) {
        $p .= $loc['name'];
    }
    $location = $p;
} else {
    $location = $get['location'];
}
$content = [
    'job_title' => $get['title'],
    'company_name' => $get['company'],
    'canvas' => (($get['company_logo']) ? false : true),
    'bg_icon' => (($app['profile_name'] == "Others") ? false : $app['profile_id']),
    'logo' => (($get['company_logo']) ? $get['company_logo'] : null),
    'initial_color' => RandomColors::one(),
    'location' => $location,
    'app_id' => $app['application_enc_id'],
    'permissionKey' => Yii::$app->params->EmpowerYouth->permissionKey
];
$this->title = $get['company'] . ' is hiring for ' . $get['title'];
$keywords = $get['company'] . ' jobs,Freshers jobs,Software Jobs,IT Jobs, Technical Jobs,' . $get['title'] . ' Jobs,  MBA Jobs, Career, Walk-ins ' . $get['title'] . ',Part Time Jobs,Top 10 Websites for jobs,Top lists of job sites,Jobs services in india,top 50 job portals in india,' . $get['title'] . ' jobs in india for freshers';
$description = 'Empower Youth is a career development platform where you can find your dream job and give wings to your career.';
$content['bg_icon'] = ImageScript::getProfile($content['bg_icon']);
if (empty($app['image']) || $app['image'] == 1) {
    $image = ImageScript::widget(['content' => $content]);
} else {
    $image = Yii::$app->params->digitalOcean->sharingImageUrl . $app['image'];
}

if (empty($app['square_image']) || $app['square_image'] == 1) {
    $Instaimage = \frontend\models\script\InstaImageScript::widget(['content' => $content]);
} else {
    $Instaimage = Yii::$app->params->digitalOcean->sharingImageUrl . $app['square_image'];
}

if (empty($app['story_image']) || $app['story_image'] == 1) {
    $Storyimage = \frontend\models\script\StoriesImageScript::widget(['content' => $content]);
} else {
    $Storyimage = Yii::$app->params->digitalOcean->sharingImageUrl . $app['story_image'];
}
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

$this->params['header_dark'] = false;

if (!Yii::$app->user->isGuest) {
    $user_id = Yii::$app->user->identity->user_enc_id;
}
?>
<!--top header-->
<section class="overlape dark-color">
    <div data-velocity="-.1"
         style="background: url('<?= Url::to("@eyAssets/images/backgrounds/default_cover.png"); ?>') repeat scroll 50% 422.28px transparent;background-size: 100% 100% !important;background-repeat: no-repeat;"
         class="parallax scrolly-invisible no-parallax"></div>
    <div class="background-container">
        <div class="row m-0">
            <div class="col-lg-12 p-0">
                <div class="inner-header">
                    <div class="agency-name-top">
                        <h1><?= $get['company'] ?></h1>
                    </div>
                    <div class="job-title"><?= $get['title']; ?></div>
                    <div class="job-statistic">
                        <?php if ($get['type']): ?>
                            <div class="job-time"><?= ucwords($get['type']) ?></div>
                        <?php endif; ?>
                    </div>
                    <?php if ($get['location']) { ?>
                        <div class="job-location"><i class="fas fa-map-marker-alt marg"></i>
                             <?= $location ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!--</div>-->
    <!--</div>-->
</section>
<!--top header-->
<section>
    <div class="container">
        <div class="row m-0">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="job-single-sec">
                    <div class="job-single-head2">
                    </div>
                    <div class="job-details">
                        <div class="d-head">Job Description</div>
                        <div class="duties-tab set-sticky">
                            <div class="d-content desc"><?= $get['description'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 z-index-9">
                <!--  org details-->
                <div class="job-single-head style2 overlay-top">
                    <div class="job-thumb">
                        <?php if ($get['company_logo']) { ?>
                            <img src="<?= $get['company_logo']; ?>" id="logo_img" alt=""/>
                        <?php } else { ?>
                            <canvas class="user-icon" name="<?= $get['company'] ?>" width="125" height="125"
                                    color="#73ef9c" font="48px"></canvas>
                        <?php } ?>
                    </div>
                    <div class="job-head-info">
                        <h4><?= $get['company'] ?></h4>
                        <!--                        <div class="organization-details">-->
                        <!--                            --><?php //if ($get['company_url']): ?>
                        <!--                                <p><i class="fas fa-unlink"></i><a href="-->
                        <? //= $get['company_url'] ?><!--"-->
                        <!--                                                                   target="_blank">-->
                        <? //= $get['company_url'] ?><!--</a></p>-->
                        <!--                            --><?php //endif; ?>
                        <!--                        </div>-->
                    </div>
                    <div class="actions-main">
                        <?php if (Yii::$app->user->isGuest): ?>
                            <div class="btn-parent">
                                <a href="javascript:;" data-toggle="modal" data-target="#loginModal"
                                   class="apply-job-btn single-btn"><i
                                            class="fas fa-paper-plane"></i>Login to apply</a>
                            </div>
                        <?php else: ?>
                            <div class="btn-parent">
                                <a href="<?= $get['url'] ?>" target="_blank" class="apply-job-btn hvr-icon-pulse"><i
                                            class="fas fa-paper-plane hvr-icon"></i>Apply On Website</a>
                            </div>
                        <?php endif; ?>
                        <a href="/jobs/list" title="" class="view-all-a">View all
                            Jobs</a>
                    </div>
                    <?php $link = Url::to('job/' . $source . '/' . $slugparams . '/' . $id, 'https'); ?>
                    <div class="effect thurio">
                        <h3 class="text-white">Share</h3>
                        <div class="buttons">
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://twitter.com/intent/tweet?text=' . $this->title . '&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link . '&title=' . $this->title . '&summary=' . $this->title . '&source=' . Url::base(true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('https://api.whatsapp.com/send?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="javascript:;"
                               onclick="window.open('<?= Url::to('mailto:?&body=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fas fa-envelope"></i>
                            </a>
                            <a href="javascript:;" class="tg-tele"
                               onclick="window.open('<?= Url::to('https://t.me/share/url?url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-telegram-plane"></i>
                            </a>
                        </div>
                        <div class="wts-ap">
                            <h3>Share on Whatsapp via Number</h3>
                            <div class="col-md-12 form-whats">
                                <?php
                                $form = ActiveForm::begin([
                                    'id' => 'whatsapp-form',
                                    'fieldConfig' => [
                                        'template' => '<div class="form-group">{input}{error}</div>',
                                        'labelOptions' => ['class' => ''],
                                    ],
                                ]);
                                ?>
                                <?=
                                $form->field($whatsAppmodel, 'phone')->widget(PhoneInput::className(), [
                                    'options' => ['class' => 'wts-txt', 'placeholder' => '+91 98 XXXX XXXX'],
                                    'jsOptions' => [
                                        'allowExtensions' => false,
                                        'preferredCountries' => ['in'],
                                        'nationalMode' => false,
                                    ]
                                ]);
                                ?>
                                <?php ActiveForm::end(); ?>
                                <div class="send"><i class="fa fa-arrow-right"></i></div>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-lg-12">
                                <h4 class="text-white">or</h4>
                                <div class="pf-field">
                                    <input type="text" title="Click to Copy" id="share_manually"
                                           onclick="copyToClipboard()" class="form-control" value="<?= $link ?>"
                                           readonly="">
                                    <i class="far fa-copy"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="down-img">
                    <div class="show-img">
                        <img src="<?= Url::to($Instaimage); ?>" alt=""/>
                    </div>
                    <h3>Download Sharing Image</h3>
                    <a href="<?= $image; ?>" download target="_blank" title="Banner Image" class="img-down">
                        <img src="<?= Url::to('@eyAssets/images/pages/employers/poster.png'); ?>" alt=""/>
                    </a>
                    <a href="<?= $Storyimage; ?>" download target="_blank" title="Story Image" class="img-down">
                        <img src="<?= Url::to('@eyAssets/images/pages/employers/story.png'); ?>" alt=""/>
                    </a>
                    <a href="<?= $Instaimage; ?>" download target="_blank" title="Post Image" class="img-down">
                        <img src="<?= Url::to('@eyAssets/images/pages/employers/square.png'); ?>" alt=""/>
                    </a>
                </div>
                <!--  org details-->
                <?php
                if (Yii::$app->user->isGuest) {
                    echo $this->render('/widgets/best-platform');
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="heading-style">Jobs You May Like</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="blogbox"></div>
            </div>
        </div>
        <?php if ($settings["showRelatedOpportunities"]): ?>
            <div class="row m-0">
                <div class="col-md-12">
                    <h2 class="heading-style">Related <?= $type . 's'; ?></h2>
                    <div class="similar-application"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
echo $this->render('/widgets/drop_resume', [
    'username' => Yii::$app->user->identity->username,
    'type' => 'application',
    'slug' => ''
]);
?>
<?php
if ($settings["showNewPositionsWidget"]):
    ?>
    <section>
        <div class="container">
            <?=
            $this->render('/widgets/new-position');
            ?>
        </div>
    </section>
<?php endif;
if (Yii::$app->params->options->showSchema) {
    ?>
    <script type="application/ld+json">
        {
            "@context" : "https://schema.org/",
            "@type" : "JobPosting",
            "title" : "<?= $get['title']; ?>",
            "description" : "<?= str_replace('"', "" ,str_replace("'","",$get['description'])) ?>",
            "datePosted" : "<?= $get['created_at'] ?>",
            "validThrough" : "<?= $get['last_date'] ?>",
            "employmentType" : "<?= $get['type'] ?>",
            "hiringOrganization" : {
                "@type" : "Organization",
                "name" : "<?= $get['company'] ?>",
                "sameAs" : "<?= $get['company_url'] ?>",
                "logo" : "<?= $get['company_logo']; ?>"
            },
            "jobLocation": {
                "@type": "Place",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "<?= $location ?>"
                }
            }
        }

    </script>
    <?php
}

?>
<script>
    function copyToClipboard() {
        var copyText = document.getElementById("share_manually");
        copyText.select();
        document.execCommand("copy");
        toastr.success("", "Copied");
    }
</script>
<?php
echo $this->render('/widgets/mustache/application-card');
$this->registerCss('
.down-img {
    background: #4ECDC4;
    background: -webkit-linear-gradient(to right, #556270, #4ECDC4);
    background: linear-gradient(to right, #556270, #333a44);
    width: 80%;
    margin: 15px auto;
    text-align:center;
    padding:20px 0;
}
.down-img h3 {  
	color: #fff;
	font-size: 16px;
	font-family: roboto;
	margin: 0px 0 15px;
}
.down-img a {
    background-color: #fff;
    padding: 5px;
    border-radius: 4px;
    display: inline-block;
    margin: 0px 2px;
    width: 38px;
    height: 36px;
}
.show-img img {
    width: 100%;
    height: 250px;
    object-fit: contain;
    margin-bottom: 15px;
}
.footer{margin-top:0 !important;}
.job-location {
    width: 40%;
    display: block;
    margin-top: 20px !important;
    margin: 0 auto;
}
.job-thumb canvas {
    width: 125px;
    height: 125px;
}
.iti{width:100%;}
.intl-tel-input{width:100%;}
.form-whats {
	position: relative;
}
.send {
	position: absolute;
	top: 2px;
	right: 28px;
	font-size: 22px;
	cursor:pointer;
}
.form-group.field-whatsappshareform-phone, .field-whatsappshareform-phone > .form-group{
    margin-bottom:0;
}
.wts-ap{position:relative;}
.wts-ap h3 {
    margin: 0;
    font-size: 14px;
    color: #fff;
    margin-bottom: 8px !important;
    font-family: roboto;
}
.wts-ap input {
    font-family: roboto;
    width: 100%;
    margin: auto;
    height: 40px;
    border-radius: 6px;
    padding: 5px 10px;
}
.desc strong, .desc h1,.desc h2 
{
    font-size: 15px !important;
    font-weight: 500 !important;
    font-family: roboto !important;
    color: #00a0e3 !important;
}
.duties-tab a
 {
 color :#337ab7 !important;
 }
.duties-tab{
border: 1px solid #eee;
    padding: 15px;
    border-radius: 5px;
    text-align: justify;
    float: left;
    box-shadow: 0 0 10px 0px #eee;
    clear: both;
    width: 100%;
}
.d-head {
    font-size: 18px;
    font-weight: 500;
    font-family: roboto;
    color: #00a0e3;
    padding: 25px 0 5px 5px;
    float: left;
}
.job-title
{
    font-size: 26px;
    font-weight: bold;
    padding-top: 60px;
    font-family: roboto;
}
.agency-name-top > h1 {
    color: white;
    font-family: roboto;
    font-size: 36px;
}
.job-statistic {
    padding-top: 30px;
}
.job-time {
    float: none;
    display: inline-block;
    font-size: 12px;
    border: 1px solid #fff;
    padding: 7px 20px;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    -ms-border-radius: 20px;
    -o-border-radius: 20px;
    border-radius: 20px;
    font-family: roboto;
}
.job-time, .job-location, .job-valid {
    display: inline-block;
    margin-right: 10px;
    font-size: 13px;
    font-family: roboto;
}
.job-thumb{
    width: 125px !Important;
    height: 125px !Important;
    background-color: #fff;
    display: block;
    overflow: hidden;
    line-height: 125px;
    margin: auto;
}
.job-thumb img{
    max-width: 100px !Important;
    max-height: 100px !Important;
    background-color: #fff;
    object-fit: contain;
}
.overlay-top{
    width: 80%;
    margin: auto;
    margin-top: -150px;
    float: none;
    background-color: #333a44;
    z-index: 9;
    padding-top: 20px;
    padding-bottom: 50px;
}
.organization-details{
    display: block;
    text-align: left;
    padding: 25px;
}
.organization-details h4{
    font-size:14px !Important;
    margin-top:15px !important;
}
a.add-or-compare {
    display: inline-block !important;
    background-color: #fff;
    padding: 10px 16px;
    width: 42%;
    font-size: 12px;
    border-radius: 2px;
    color: #333;
    margin-top: 15px;
    box-shadow: 0px 0px 10px -2px #ddd;
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.single-btn{
    display:inline-block;
}
a.add-or-compare.full-width {
    width:175px;
}
a.add-or-compare:hover, a.add-or-compare:focus {
    background-color:#00a0e3;
    color:#fff;
    border-radius:6px;
}
.add-or-compare i {
    display: block;
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
.hvr-icon-pulse:before{
    content:"" !important;
}
.effect {
  width: 100%;
}
.effect .buttons {
  display: block;
  padding: 10px 0px;
}
.effect a {
    text-decoration: none !important;
    width: 32px;
    height: 32px;
    display: inline-block;
    border-radius: 50%;
    margin: 0 5px;
    font-size: 17px;
    overflow: hidden;
    position: relative;
    color: #fff;
    border: 2px solid #fff;
    line-height: 26px;
}
.effect a i {
  font-size: 14px;
  text-align: center;
}
/* thurio effect */
.effect.thurio a {
  transition: border-radius 0.2s linear 0s;
  -webkit-transform: rotate(45deg);
          transform: rotate(45deg);`
}
.effect.thurio a i {
  transition: -webkit-transform 0.01s linear 0s;
  transition: transform 0.01s linear 0s;
  transition: transform 0.01s linear 0s, -webkit-transform 0.01s linear 0s;
  -webkit-transform: rotate(-45deg);
          transform: rotate(-45deg);
}
.effect.thurio a:hover {
  border-radius: 0px;
}
.view-all-a{
    margin-top: 15px;
    display: block;
    color: #ddd;
}
@media only screen and (max-width: 991px) {
    .job-single-head.style2.overlay-top{
        margin-top: 0;
        width: 100%;
    }
    .job-head-info{
        max-width: 275px;
        text-align: left;
    }
    
    .job-head-info .organization-details h4{
        margin-left:0px !Important;
    }
    .actions-main{
//        float: left;
        display: inline-block;
        width: 42%;
    }
    a.add-or-compare{padding: 10px 5px;}
    .effect.thurio{clear:both;}
}
@media only screen and (max-width: 768px) {
.job-location {
    width: 100%;
}
}
@media only screen and (max-width: 720px) {
    .actions-main{
        width: 30%;
        font-size:11px;
    }
}
@media only screen and (max-width: 640px) {
    a.add-or-compare{
        width:97%;
        padding: 13px 5px;
    }
    .add-or-compare i{display:inline-block;}
}
@media only screen and (max-width: 640px) {
    a.add-or-compare{
        width: 44%;
    }
    .actions-main {
        width: 100%;
    }
}
@media only screen and (max-width: 430px) {
    .job-head-info {
        max-width: inherit;
        text-align: center;
    }
    .organization-details {
        text-align: center;
    }
    .job-head-info h4{
        margin-left:0px !Important;
    }
}
');
$this->registerCss("
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
      text-align: center;
    padding-top: 125px;
    padding-bottom: 50px;
    color: #fff;
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
//        margin-bottom: 50px;
        z-index: 1;
        color: #fff;
        font-size: 18px;
    }
    .job-statistic span {
        float: none;
        display: inline-block;
        font-size: 16px;
        font-family:roboto;
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
        width: 33.33%;
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
        display: inherit;
        text-align: center;
        border: none;
    }
    .job-single-head.style2 .job-head-info {
        width: 100%;
        display: inherit;
        padding: 0;
        margin-top: 15px !important;
        margin: 0 auto;
        text-align: center;
        margin-bottom: 15px;
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
    .job-head-info {
        display: table-cell;
        vertical-align: middle;
        padding-left: 25px;
    }
    .job-head-info h4 {
        width: 100%;
        font-family: 'Roboto';
        font-size: 17px;
        font-weight: 600;
        color: #fff;
        margin: 0;
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
    display:flex;
    justify-content:center;
    align-items:center; 
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
    font-family: roboto;
    font-size: 18px;
    color: #fff;
    width: 200px;
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
        position: relative;
        margin-bottom:5px;
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
    
    @media screen and (max-width: 991px) {
      .btn-parent{
        position: fixed;
        bottom:28px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9;
        background: rgba(0,0,0,.1);
        padding: 7px;
    }
    }
    @media only screen and (max-width: 430px) {
    .btn-parent{
        left:30%;
        padding:0;
        }
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
$this->registerJs("
$(document).on('keypress','.wts-txt',function(e) {
        if(e.which == 13) {
            var val = $(this).val();
            var location = window.location.href;
            if(val.length < 8){
                alert('Enter Valid Number')
            }
            else {
                window.open('https://api.whatsapp.com/send?phone='+val+'&text=' + location);
            }
            $(this).val('');
        } else {
            var iKeyCode = (e.which) ? e.which : e.keyCode;
            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57) && iKeyCode != 43){
                return false;
            }
            // return true;
        }
    });
    $(document).on('submit','#whatsapp-form',function(e) {
        e.preventDefault();
        return false;
    });     
    $('.send').click(function () {        
    var val = $('.wts-txt').val();
    var location = window.location.href;
       if(val.length < 10){
            alert('Enter Valid Number')
        }
        else {
             window.open('https://api.whatsapp.com/send?phone='+val+'&text=' + location);
        }
        $('.wts-txt').val('');
});
loader = false;
addToReviewList();
getCards('" . $type . 's' . "','.blogbox','/organizations/organization-related-titles?title=" . $get['title'] . "');    
");
?>
