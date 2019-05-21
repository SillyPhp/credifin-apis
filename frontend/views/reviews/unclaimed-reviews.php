<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = $name.' '.Yii::$app->params->seo_settings->title_separator.' Reviews';
Yii::$app->view->registerJs('var slug = "'. $slug.'"',  \yii\web\View::POS_HEAD);
?>
<!--registration model-->
<div id="org_sign_up_Modal" class="modal fade-scale loginModal" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content half-bg-color">
            <div class="row margin-0">
                <div class="col-md-6 col-sm-6">
                    <div class=" half-bg half-bg-color">
                        <div class="top-circle">
                            <img src="<?= Url::to('@eyAssets/images/pages/login-signup-modal/top-half-circle.png') ?>">
                        </div>
                        <div class="log-icon">
                            <span></span>
                            <img src="<?= Url::to('@eyAssets/images/pages/login-signup-modal/login-image.png') ?>"
                                 class="centerthis">
                        </div>
                        <div class="bottom-circle">
                            <img src="<?= Url::to('@eyAssets/images/pages/login-signup-modal/bottom-circle.png') ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 padding-0 bg-log">
                    <div class="log-fom">
                        <div class="inner-log-fom"></div>
                        <div class="inner-main-log-fom">
                            <div class="ey-logo">
                                <img src="<?= Url::to('@commonAssets/logos/logo.svg') ?>">
                            </div>
                            <div class="main_head_title">
                                <h3>Be The First To Review..</h3>
                            </div>
                            <div class="login-form" id="loginForm">
                                <?php
                                $form = ActiveForm::begin([
                                    'id' => 'signup-form',
                                    'options' => [
                                        'class' => 'clearfix',
                                    ],
                                    'fieldConfig' => [
                                        'template' => '{input}{error}',
                                    ],
                                ]);
                                ?>
                                <div class="uname">
                                    <?=
                                    $form->field($model, 'organization_name')->textInput([
                                        'autofocus' => true,
                                        'autocomplete' => 'off',
                                        'class' => 'uname-in',
                                        'placeholder' => 'Organization Name',
                                        'value'=>$name
                                    ]);
                                    ?>
                                </div>
                                <div class="pass">
                                    <?=
                                    $form->field($model, 'website')->textInput([
                                        'autocomplete' => 'off',
                                        'class' => 'uname-in',
                                        'placeholder' => 'Organization Website (Optional)',
                                    ]);
                                    ?>
                                </div>
                                <div class="uname">
                                    <?= $form->field($model, 'bussiness_activity')->dropDownList(
                                        $type, [
                                        'prompt' => Yii::t('frontend', 'Select Business Activity'),
                                    ])->label(false); ?>
                                </div>
                                <div class="login-btn">
                                    <?= Html::submitButton('Employee Review', ['class' => 'lg-form', 'id'=>'company_review_btn1','formaction'=>'p1','name' => 'login-button']); ?>
                                    <?= Html::submitButton('Student Review', ['class' => 'lg-form','id'=>'company_review_btn2','formaction'=>'p2','name' => 'login-button']); ?>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="back_links">
                        <a href="/reviews" id="color_blue">Back To Reviews</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--registration model end-->
<section class="rh-header">
    <div class="container">
        <div class="row">
            <div class=" col-md-2 col-md-offset-0 col-sm-4 col-sm-offset-2">
                <div class="logo-box">
                    <canvas class="user-icon" name="<?= $name; ?>" width="150" height="150"
                            color="" font="70px"></canvas>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="com-name"><?= ucwords($name); ?></div>
                <div class="com-rating-1">
                    <?php for ($i=1;$i<=5;$i++){ ?>
                        <i class="fa fa-star"></i>
                    <?php } ?>
                </div>
                <div class="com-rate">0/5 - based on 0 reviews</div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="header-bttns">
                    <div class="header-bttns-flex">
                        <?php if (!Yii::$app->user->isGuest){
                            if (empty(Yii::$app->user->identity->organization_enc_id)){ ?>
                                <div class="wr-bttn hvr-icon-pulse">
                                    <button type="button" id="wr"><i class="fa fa-comments-o hvr-icon"></i> Back To Review</button>
                                </div>
                            <?php } } else { ?>
                            <div class="wr-bttn hvr-icon-pulse">
                                <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="btn_review"><i class="fa fa-comments-o hvr-icon"></i> Write Review</a>
                            </div>
                        <?php } ?>
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
                <div id="org-reviews"><p class="font_no_review">Currently No Reviews For This Company Be The First To Review This Company</p></div>
            </div>
            <div class="col-md-4">
                <div class="review-summary">
                    <h1 class="heading-style">Overall Ratings</h1>
                    <div class="row">
                        <div class="col-md-12 col-sm-4">
                            <div class="rs-main fade_background">
                                <div class="rating-large">0/5</div>
                                <div class="com-rating-1">
                                    <?php for ($i=1;$i<=5;$i++){ ?>
                                        <i class="fa fa-star"></i>
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
                                    <div class="sr-rating fade_background">0</div>
                                    <div class="fourstar-box com-rating-2 fade_border">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Career growth </div>
                                <div class="summary-box">
                                    <div class="sr-rating fade_background">0</div>
                                    <div class="fourstar-box com-rating-2 fade_border">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Company culture </div>
                                <div class="summary-box">
                                    <div class="sr-rating fade_background">0</div>
                                    <div class="fourstar-box com-rating-2 fade_border">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Salary & Benefits</div>
                                <div class="summary-box">
                                    <div class="sr-rating fade_background">0</div>
                                    <div class="fourstar-box com-rating-2 fade_border">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Work Satisfaction</div>
                                <div class="summary-box">
                                    <div class="sr-rating fade_background">0</div>
                                    <div class="threestar-box com-rating-2 fade_border">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Work-Life Balance</div>
                                <div class="summary-box">
                                    <div class="sr-rating fade_background">0</div>
                                    <div class="fourstar-box com-rating-2 fade_border">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="rs1">
                                <div class="re-heading">Skill development </div>
                                <div class="summary-box">
                                    <div class="sr-rating fade_background">0</div>
                                    <div class="fourstar-box com-rating-2 fade_border">
                                        <?php for ($i=1;$i<=5;$i++){ ?>
                                            <i class="fa fa-star"></i>
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
<input type="hidden" name="hidden_designation" id="hidden_designation">
<input type="hidden" name="hidden_city_location" class="hidden_city_location">
</div>
<?php
$this->registerCss('
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
.back_links
{
text-align:center;
margin-bottom:12px;
}
#color_blue
{
color: #3062d4 !important;
text-decoration: underline !important;
}
.view-detail-btn button:hover, .re-btns button:hover{
    color:#00a0e3;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    transition:.3s all;
}
.font_no_review
{
font-size: 21px;
font-family: lobster;
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
.uname select
{
padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 80%;
    font-size: 13px;
    margin:auto;
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
@media only screen and (max-width: 992px){
    .cp-bttn button {
        margin-top: 20px; 
    }
    .cp-bttn {
        padding-left: 0px;
    }
    .header-bttns{
        display: flex;
        justify-content:center;
        margin: 20px 0 0 0;
    }
    .com-name{
        margin-top:0px;
    }
    .rh-header {
        padding: 65px 0;
    }
    .review-summary{
        padding-top:40px;
    }
    .oa-review{
        padding-bottom:20px;
    }
}
#autocomplete-list{
    background-color: #fff;
    border-radius: 0px 0px 10px 10px;
    max-height: 350px;
    overflow-y: scroll;
}
#autocomplete-list div {
    padding: 3px;
    border-bottom: .5px solid #eee;
    font-size: 16px;
}
#autocomplete-list div:last-child {
    border-bottom:0px;
}
::placeholder{
    color:#999;
}
.login-heading{
    text-align:left;
    padding-left:40px;
}
.top-circle{
    position:absolute;
    top: 0;
    left: 40px;
    max-width: 100px;
}
.bottom-circle{
    position:absolute;
    bottom: 0;
    right: 40px;
    max-width: 80px;
}
#signForm, #individualForm{
    display:none;
}
.sign-heading{
    padding: 30px 0px 10px 0;
}
.indi-btn a{
    background: #00a0e3;
    color: #fff;
    padding: 7px 42px;
    border: 1px solid #00a0e3;
    border-radius: 5px;
    text-transform: capitalize;
    font-size: 15px;
    width: 160px;
    margin: auto;
    margin-top: 5px;
    display: block;
}
.organ-btn{
    margin-top:20px;
}
.organ-btn a{
    padding: 10px 37px;
    background: #ff7803;
    border:1px solid #ff7803;
    margin-top:10px;
    color:#fff;
    border-radius: 5px;
    text-transform: capitalize;
    font-size: 14px;
}
.uname-padd-10{
    padding-top:5px !important;
}
/*---forget box---*/
#forgotForm{
    display:none;
}
.f-text{
    padding:45px 0 5px 35px;
    text-align:left; 
    font-size:13px;
}
.f-button{
    padding:20px 0 0 0;
}
.f-mail{
    font-size:13px;
    padding:10px 50px 0 50px;
    white-space: normal !important;
}
.f-button button{
    background:#00a0e3;
    color:#fff;
    border:#00a0e3;
    padding:10px 20px;
    border-radius:5px;
    font-size:13px !important;
}
/*---forget box ends---*/
.loginModal.modal.in{
    display:flex !important;
}
.modal.in .modal-dialog{
    margin:auto;
}
.fade-scale {
  transform: scale(0);
  opacity: 0;
  -webkit-transition: all .25s linear;
  -o-transition: all .25s linear;
  transition: all .25s linear;
}
.fade-scale.in {
  opacity: 1;
  transform: scale(1);
}
.new-user{
    font-size:13px;
    position:absolute;
    bottom:5px;
    left:50%;
    transform: translateX(-50%);
}
.new-user button{
    font-size:14px;
    background:none;
    border:none;
    color:#00a0e3;
}
.bg-log{
    background:#fff;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 0 5px 5px 0;
    min-height:365px;
}
.margin-0{
    margin-left:0px !important;
    margin-right:0px !important;
}
.half-bg-color{
    background: #00a0e3;
}
.half-bg{
    background-size:cover;
    height:100%;
    border-radius: 5px 0 0 5px;
}
.log-fom, .log-icon{
    padding:50px 0;
    text-align:center;
    white-space: nowrap;
    height: 540px;
}
.ey-logo{
    position:absolute;
    top:20px;
    left:50%;
    transform:translateX(-50%);
}
.ey-logo img{
    max-width:200px;
}
.log-btn{
    padding:100px
}
.log-icon span{
    display: inline-block;
    height: 100%;
    vertical-align: middle;
}
.log-icon img{
    max-width:315px;
    vertical-align: middle;
}
.inner-log-fom{
    display: inline-block;
    height: 100%;
    vertical-align: middle;
}
.inner-main-log-fom{
    vertical-align: middle;
    display: inline-block;
    width:100%;
}
.uname{
    padding:10px 0 10px 0;
    
}
.uname-in, .pass-in{
    padding:10px 15px;
    border:1px solid #ddd;
    border-radius:5px;
    width:80%;
    font-size: 13px;
}
.forgot-pass{
    font-size:12px;
}
.rem-input{
    padding-top: 3px;
    padding-left: 30px;
}
.rem-input span{
    padding-left:3px;
}
.for-a{
    padding-top:3px;
    text-align:right; 
}
.for-a a{
    background:transparent;
    border:none;
    font-size:13px;
    margin-right:30px
}
input{
    font: normal;
}
.login-btn{
    padding-top:10px;
}
.login-btn button{
    background:#00a0e3;
    color:#fff;
    border:#00a0e3;
    padding:10px 20px;
    border-radius:5px;
    font-size:13px;
}
@media screen and (max-width: 992px){
    .half-bg{
        border-radius:5px 5px 0 0;
    }
    .bg-log{
        border-radius:0px 0px 5px 5px;
    }
    .rem-input input{
        margin-left:0px;
    }
}
@media screen and (max-width: 767px){
    .rem-input{
        padding-right:15px !important;
    }
    .half-bg{
        display:none;
    }
    .bg-log{
        min-width:300px;
    }
    .f-mail{
        white-space: normal !important;
    }
}
@media screen and(max-width: 550px){
    .bg-log{
        max-width:280px;
    }
}
@media screen and (min-width: 768px){
    .modal-dialog {
        width: 750px !important;
        margin: 30px auto;
    }
}
body.modal-open{
    padding-right:0px !important;
    overflow:visible;
}
.error-occcur{color:red;}
.close-lg-modal{
    position: absolute;
    right: -40px;
    font-size: 40px;
    color: #fff;
    opacity: 1;
    top: -8px;
    font-weight: 100;
    background: transparent;
    border: 0;
    outline: 0;
    z-index: 99;
}
.rem-input .checkbox{
    padding-left: 20px;
    margin: 0px;
    color: inherit;
}
.rem-input .checkbox label{
    font-size: 14px;
}
@media only screen and (max-width: 450px) {
    .close-lg-modal{
        right: -5px;
        color: #777;
    }
}
.uname .md-radio label{
    white-space: normal;
    font-size: 12px;
}
.has-success .md-radio label
{
color: initial;
}
.main_head_title h3
{
font-family: "lobster";
}
.twitter-typeahead,.tt-menu
{
width:100%;
}
#autocomplete-list,.tt-menu{
    background-color: #fff;
    border-radius: 0px 0px 10px 10px;
    max-height: 350px;
    overflow-y: scroll;
}
.tt-suggestion
{
    cursor: pointer;
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
.i-review-navigation
{
display:none;
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
$('#org_sign_up_Modal').modal({
    		backdrop: 'static',
    		keyboard: false
		});
$('#org_sign_up_Modal').modal('show');
$(document).on('submit','#signup-form',function(e)
{
   e.preventDefault();
   $('#org_sign_up_Modal').modal('toggle');
   if($(this).attr('action')=='p1')
       {
       popup.open();
       }
   else if($(this).attr('action')=='p2')
   {
      popup2.open(); 
   }
   else if($(this).attr('action')=='p3')
   {
      popup3.open(); 
   }
   else if($(this).attr('action')=='p4')
   {
      popup4.open(); 
   }
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
					errorMsg	: 'Write Something.',
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
					errorMsg	: 'Write Something.',
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
$('#company_review_btn1').hide();
$('#company_review_btn2').hide();
$(document).on('change','#bussiness_activity',function(e)
{
    if($('#bussiness_activity :selected').text()=='College/Universities')
        {
            $('#company_review_btn1').show();
            $('#company_review_btn2').show();
            $('#company_review_btn2').attr('formaction','p2');
        }
    else if($('#bussiness_activity :selected').text() =='School')
        {
            $('#company_review_btn1').show();
            $('#company_review_btn2').show();
            $('#company_review_btn2').attr('formaction','p3');
        }
    else if($('#bussiness_activity :selected').text()=='Educational Institute/Tution Centers')
        {
            $('#company_review_btn1').show();
            $('#company_review_btn2').show();
            $('#company_review_btn2').attr('formaction','p4');
        }
    else if ($('#bussiness_activity :selected').text() =='Others') 
        {
            $('#company_review_btn1').show();
            $('#company_review_btn2').hide();
        }
    else {
        $('#company_review_btn1').hide();
$('#company_review_btn2').hide();
    }
    
});
if($("#wr").length>0){
document.getElementById("wr").addEventListener("click", function(e){
            window.location.replace('/reviews');
        });
}
JS;
$headScript = <<< JS
function review_post_ajax(data) {
    var org_name = $('#organization_name').val();
    var website = $('#website').val();
    var org_category =  $('#bussiness_activity').val();
    var type = 'company';
	$.ajax({
       method: 'POST',
       url : '/reviews/post-unclaimed-reviews',
	   data:{data:data,org_name:org_name,website:website,org_category:org_category,type:type},
       success: function(response) {
               if (response==false)
                   {
                       alert('there is some server error');
                   }
          }});
}
function ajax_college(data) {
  var org_name = $('#organization_name').val();
    var website = $('#website').val();
    var org_category =  $('#bussiness_activity').val();
    var type =  'college';
	$.ajax({
       method: 'POST',
       url : '/reviews/post-unclaimed-reviews',
	   data:{data:data,org_name:org_name,website:website,org_category:org_category,type:type},
       success: function(response) {
               if (response==false)
                   {
                       alert('there is some server error');
                   }
          }});
}

function ajax_school(data) {
  var org_name = $('#organization_name').val();
    var website = $('#website').val();
    var org_category =  $('#bussiness_activity').val();
    var type =  'school';
	$.ajax({
       method: 'POST',
       url : '/reviews/post-unclaimed-reviews',
	   data:{data:data,org_name:org_name,website:website,org_category:org_category,type:type},
       success: function(response) {
               if (response==false)
                   {
                       alert('there is some server error');
                   }
          }});
}
function ajax_institute(data) {
  var org_name = $('#organization_name').val();
    var website = $('#website').val();
    var org_category =  $('#bussiness_activity').val();
    var type =  'institute';
	$.ajax({
       method: 'POST',
       url : '/reviews/post-unclaimed-reviews',
	   data:{data:data,org_name:org_name,website:website,org_category:org_category,type:type},
       success: function(response) {
               if (response==false)
                   {
                       alert('there is some server error');
                   }
          }});
}
JS;
$this->registerJs($script);
$this->registerJs($headScript,yii\web\View::POS_HEAD);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Roboto+Slab:400,700&subset=latin-ext');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup-college.css');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup-school.css');
$this->registerCssFile('@eyAssets/ideapopup/ideabox-popup-institute.css');
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/ideapopup/ideapopup-review.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup-college.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup-school.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/ideapopup/ideabox-popup-institute.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script id="review-cards" type="text/template">

</script>