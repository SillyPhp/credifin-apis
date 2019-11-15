<?php

use yii\helpers\Url;
use yii\helpers\Html;

$link = Url::to('detail/' . $familyid . '/' . $objectid, 'https');
$this->params['header_dark'] = false;
$separator = Yii::$app->params->seo_settings->title_separator;
$this->title = $get['DepartmentName'] . ' is hiring for ' . $get['PositionTitle'];
$keywords = 'Jobs,Jobs in Usa';
$description = 'Empower Youth is a career development platform where you can find your dream job and give wings to your career.';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/images/fb-image.png');
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
<section>
    <div class="header-bg" style='
        background-image:url("/assets/themes/ey/images/backgrounds/default_cover.png");'>
        <div class="cover-bg-color"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-header">
                        <div class="agency-name-top">
                            <h1><?= $get['DepartmentName'] ?></h1>
                        </div>
                        <div class="job-title"><?= $get['PositionTitle'] ?></div>
                        <div class="job-statistic">
                            <div class="job-time"><?= $get['PositionSchedule'][0]['Name'] ?></div>
                            <div class="job-location"><i
                                        class="fas fa-map-marker-alt marg"></i> <?= $get['PositionLocationDisplay'] ?>
                            </div>
                            <div class="job-valid"><i
                                        class="fas fa-suitcase marg"></i><?= $get['UserArea']['Details']['TotalOpenings'] ?>
                                vacancy
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--    <section>-->
<!--        <div class="container padd-top-0">-->
<!--            <div class="row">-->
<!--                <div class="col-md-4 col-sm-12 col-xs-12 col-md-offset-9">-->
<!--                    <div class="follow-btn">-->
<!--                        <button class="follow">Apply</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->

<section id="us-sub-header">
    <div class="row">
        <div class="col-md-12">
            <div id="s-header" class="nav-bar">
                <ul>
                    <li><a href="#overview">Overview</a></li>
                    <li><a href="#duties">Duties</a></li>
                    <li><a href="#requirements">Qualification And Other Details</a></li>
                    <li><a href="#locations">Locations</a></li>
                    <?php
                    if ($get['UserArea']['Details']['AgencyMarketingStatement']) {
                        ?>
                        <li><a href="#requireddocuments">Agency Overview</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="job-single-head2">
                    <div class="job-overview">
                        <div class="d-head " id="overview">Overview</div>
                        <ul class="set-sticky">
                            <li><i class="fas fa-calendar-alt"></i></i>
                                <h3>Opening & Closing Dates</h3>
                                <span><?= date("d-m-Y", strtotime($get['PositionStartDate'])) ?> to <?= date("d-m-Y", strtotime($get['PositionEndDate'])) ?></span>
                            </li>
                            <li><i class="fas fa-puzzle-piece"></i>
                                <h3>Pay scale & Grade</h3><span>
                                    <?php if ($get['UserArea']['Details']['LowGrade'] != $get['UserArea']['Details']['HighGrade']):
                                        echo $get['JobGrade'][0]['Code'] . " " . $get['UserArea']['Details']['LowGrade'] . "-" . $get['UserArea']['Details']['HighGrade'];
                                    else:
                                        echo $get['JobGrade'][0]['Code'] . " " . $get['UserArea']['Details']['HighGrade'];
                                    endif;
                                    ?>
                                </span></li>
                            <li><i class="fas fa-money-bill-alt"></i>
                                <h3>Salary</h3><span><i
                                            class="fas fa-dollar-sign custm"></i> <?= $get['PositionRemuneration'][0]['MinimumRange'] ?> to <i
                                            class="fas fa-dollar-sign custm"></i> <?= $get['PositionRemuneration'][0]['MaximumRange'] . " " . $get['PositionRemuneration'][0]['RateIntervalCode'] ?></span>
                            </li>
                            <li><i class="fas fa-suitcase"></i>
                                <h3>Service</h3><span>Excepted</span></li>
                            <li><i class="fas fa-mars-double"></i>
                                <h3>Appointment Type</h3><span><?= $get['PositionOfferingType'][0]['Name'] ?></span>
                            </li>
                            <li><i class="fas fa-network-wired"></i></i>
                                <h3>Work Schedule</h3><span><?= $get['PositionSchedule'][0]['Name'] ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="d-head" id="duties">Duties</div>
                <div class="duties-tab set-sticky">
                    <div class="summary">Summary</div>
                    <div class="d-content"><?= $get['UserArea']['Details']['JobSummary'] ?>
                    </div>
                </div>
                <div class="d-head" id="requirements">Qualification And Other Details</div>
                <div class="requirements-tab set-sticky">
                    <div class="d-content">
                        <?= $get['QualificationSummary'] ?>
                    </div>
                </div>
                <div class="d-head" id="locations">Locations</div>
                <div class="location-tab set-sticky">
                    <div class="location-set">
                        <div style="margin-bottom: 8px;">
                            <i class="fas fa-map-marker-alt" style="color:#3790ec;margin-right: 5px;"></i>
                            <span><?= $get['PositionLocation'][0]['LocationName'] ?></span>
                        </div>
                        <?php if (count($get['PositionLocation']) > 1): ?>
                            <div id="show-more">
                                <?php foreach ($get['PositionLocation'] as $location) { ?>
                                    <div style="margin-bottom: 8px;">
                                        <i class="fas fa-map-marker-alt" style="color:#3790ec;margin-right: 5px;"></i>
                                        <span><?= $location['LocationName'] ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="set-clr" id="toggle">Read More</div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                if ($get['UserArea']['Details']['AgencyMarketingStatement']) {
                    ?>
                    <div class="d-head" id="requireddocuments">Agency Overview</div>
                    <div class="required-doc-tab set-sticky">
                        <div class="d-content">
                            <?= $get['UserArea']['Details']['AgencyMarketingStatement']; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="col-md-4">
                <div class="agency-info">
                    <div class="agency">Agency Information</div>
                    <div class="agency-name"><i class="fas fa-user user-set"></i><?= $get['OrganizationName'] ?></div>
                    <!--                    <div class="phone">-->
                    <!--                        <div class="agency-num"><i class="fas fa-mobile-alt user-set"></i>Phone</div>-->
                    <!--                        <span class="d-content">+984616161</span>-->
                    <!--                    </div>-->
                    <!--                    <div class="email">-->
                    <!--                        <div class="agency-email"><i class="fas fa-envelope user-set"></i>E-mail</div>-->
                    <!--                        <span class="d-content">abc@gmail.com</span>-->
                    <!--                    </div>-->
                    <!--                    <div class="adress">-->
                    <!--                        <div class="agency-adress"><i class="fas fa-map-marker-alt user-set"></i>Address</div>-->
                    <!--                        <span class="d-content">Government Office, 441 street nw, room no.145, washington, united states</span>-->
                    <!--                    </div>-->
                    <div class="a-divider"></div>
                    <div class="announcement">
                        <span class="announcement-name">Announcement number</span>
                        <span class="annousncement-num"><?= $get['PositionID'] ?></span>
                    </div>
                    <div class="Control">
                        <span class="announcement-name">Control number</span>
                        <span class="annousncement-num"><?= $objectid; ?></span>
                    </div>
                    <div class="follow-btn">
                        <?php if (Yii::$app->user->isGuest): ?>
                        <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="follow app_btn"><i
                                    class="fas fa-paper-plane"></i>Login to apply</a>
                        <?php else : ?>
                        <a class="follow app_btn" href="<?= $get['ApplyURI'][0] ?>" target="_blank">Apply On Website</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sharing-box">
                    <div class="sharing-pic">
                        <img src="<?= Url::to('/assets/themes/ey/images/pages/jobs/socialsharing.png'); ?>">
                    </div>
                    <!--                        <div class="share-it">Share :-</div>-->
                    <div class="fb-share">
                        <button class="fb-btn"
                                onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fab fa-facebook-f marg"></i>Facebook
                        </button>
                    </div>
                    <div class="tw-share">
                        <button class="tw-btn"
                                onclick="window.open('<?= Url::to('https://twitter.com/home?status=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fab fa-twitter marg"></i>Twitter
                        </button>
                    </div>
                    <div class="li-share">
                        <button class="li-btn"
                                onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fab fa-linkedin-in marg"></i>LinkedIn
                        </button>
                    </div>
                    <div class="wa-share">
                        <button class="wa-btn"
                                onclick="window.open('<?= Url::to('https://wa.me/?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fab fa-whatsapp marg"></i>Whatsapp
                        </button>
                    </div>
                    <div class="mail-share">
                        <button class="mail-btn"
                                onclick="window.open('<?= Url::to('mailto:?&body=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fas fa-envelope marg"></i>Mail
                        </button>
                    </div>
                </div>
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({
                        google_ad_client: "ca-pub-2186770765824304",
                        enable_page_level_ads: true
                    });
                </script>
                <ins class="adsbygoogle" style="display:inline-block;width:100%;"
                     data-ad-client="ca-pub-2186770765824304" data-ad-slot="second"></ins>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.app_btn
{
display:block;
margin:auto;
}
.custm
{
    position: unset !important;
    left: unset !important;
    top: unset !important;
    font-size: unset !important;
}
.set-clr {
    font-size: 15px;
    padding-left: 22px;
    color: #005aff;
    cursor: pointer;
}
#show-more{
    display:none;
}
.location-set {
    font-size: 18px;
    text-transform: capitalize;
}
.fb-share, .tw-share, .li-share, .wa-share{
    display:inline-block;
}
.mail-share{
    text-align:center;
}
.nav-bar {
    background-color: #eee;
    text-align:center;
}
.nav-bar > ul *{
    transition: all ease-out .3s;
}
.nav-bar > ul > li {
    display: inline-block;
    margin-right: 20px;
    font-size: 16px;
    font-weight:500;
    font-family:roboto;
    padding:10px 0px;
}
.nav-bar > ul > li a{padding:10px;}
.nav-bar > ul > li.active {
    border-bottom: 5px solid orange;
}
.nav-bar > ul > li.active a{color:#000;}
@media only screen and (max-width: 550px) {
    .nav-bar{
        display:none;
    }
}
.marg{
    margin-right:5px;
}
.user-set{
    color: #00a0e3;
    margin-right: 10px;
}
.header-bg{
    background-repeat: no-repeat !important;
    background-size: 100% 100% !important;
    min-height:400px;
    }
.cover-bg-color{
    height: 100%;
    width: 100%;
    position: absolute;
    background-color: #00000057;
    }
.inner-header{
	text-align: center;
	padding-top: 125px;
	padding-bottom: 50px;
	color: #fff;
}
.agency-name-top > h1{
    color:white;
    font-family:roboto;
    font-size: 36px;
}
.job-title {
    font-size: 26px;
    font-weight: bold;
    padding-top:60px;
    font-family:roboto;
}
.job-statistic{
	padding-top: 30px;
}
.job-time, .job-location, .job-valid{
	display: inline-block;
	margin-right: 10px;
	font-size: 13px;
	font-family:roboto;
}
.job-time{
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
    font-family:roboto;
}
.follow-btn,.social-btns{
    text-align:center;
    margin-top:10px;
    }
.follow{
    padding:10px 0px;
    width:290px;
    background:#00a0e3;
    border:none;
    border-radius:5px;
    font-size: 16px;
    font-family:roboto;
    text-transform: capitalize;
    color: #fff;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    }
.follow:hover{
    background:#fff;
    color:#00a0e3;
    }
.follow, .follow:hover{
    transition:.3s all;
    }
.agency-info{
    border: 1px solid #eee;
    padding: 15px;
    margin-top: 67px;
    border-radius: 5px;
    box-shadow: 0 0 10px 0px #eee;
    float:left;
    width:100%;
}
.agency{
    font-size:22px;
    font-weight:500;  
    font-family:roboto; 
}
.agency-name, .agency-num, .agency-email, .agency-adress{
    font-size:20px;
    padding-top:15px;
    font-family:roboto;
}
.phone{
    font-size:19px;
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
        font-family:roboto;
    }
.job-single-head2 > span strong {
        font-weight: normal;
        color: #202020;
    }
.job-overview {
    float: left;
    width: 100%;
}
.job-overview > h3 {
    float: left;
    width: 100%;
    font-size: 15px;
    color: #202020;
    font-weight: 400;
}
.job-overview ul {
    float: left;
    width: 100%;
    border: 1px solid #e8ecec;
    border-radius: 5px;
    margin: 0;
    padding-left: 15px !important;
    box-shadow: 0 0 10px 0px #eee;
}
.job-overview ul > li {
    float: left;
    width: 49.9%;
    margin: 0;
    position: relative;
    padding-left: 67px;
    margin: 20px 0px;
//    min-height: 68px;
}
@media only screen and (max-width: 550px) {
.job-overview ul > li {
    width:96%;    
  }
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
    font-size: 15px;
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
.job-overview ul > li:hover i {
    color: #ef7706;
}
.duties-tab, .requirements-tab, .required-doc-tab, .location-tab {
    border: 1px solid #eee;
    padding: 15px;
    border-radius: 5px;
    text-align: justify;
    float:left;
    box-shadow: 0 0 10px 0px #eee;
    clear:both;
    width:100%;
}
.d-head {
    font-size: 22px;
    font-weight: 500;
    font-family:roboto;
    color: #00a0e3;
    padding: 25px 0 5px 5px;
    float:left;
}
.summary{
    font-size:18px;
    font-weight:500;
    padding: 10px 0 5px 0;
    font-family:roboto;
}   
.d-content {
    font-size: 15px;
    padding:0 0 15px 0;
    font-family:roboto;
}
.d-points > ul {
    list-style: decimal !important;
    padding-left: 25px !important;
    font-size: 15px;
    text-align: justify;
    font-family:roboto;
}
.condition > ul{
    list-style: inside !important;
    font-size:15px;
    font-family:roboto;
}
.required-package {
    font-size: 17px;
    font-family:roboto;
}
.required > ul{
    font-size:15px;
    list-style: disc;
    padding: 5px 0 5px 18px;
    font-family:roboto;
}
.a-divider {
    border-top: 2px solid #eee;
    margin: 10px 0 0 0;
}
.announcement-name {
    font-size: 16px;
    display: block;
    font-weight: 500;
    padding-top:10px;
    font-family:roboto;
}
#s-header.sticky {
    position: fixed;
    top: 65px;
    width: 100%;
    z-index:1;
}
.share-it {
    text-align: center;
    font-size: 19px;
    padding-bottom: 10px;
    color: #fff;
    font-weight: bold;
}
.sharing-box{
    border: 1px solid #eee;
    padding: 15px;
    margin-top: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px 0px #eee;
    float:left;
    width:100%;
    background-color:#1d759a;
}
.fb-btn, .li-btn, .tw-btn, .wa-btn, .mail-btn {
    padding: 10px 0;
    width:160px;
    background: #00a0e3;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-family: roboto;
    text-transform: capitalize;
    color: #fff;
    margin-bottom: 10px;
}
.fb-btn:hover {
    background-color: #fff;
    color: #1d759a;
}
.li-btn:hover {
    background-color: #fff;
    color: #0077b5;
}
.tw-btn:hover {
    background-color: #fff;
    color: #28aae1;
}
.wa-btn:hover {
    background-color: #fff;
    color: #00e676;
}
.mail-btn:hover {
    background-color: #fff;
     color:#d4483a;
}
.sharing-pic{
    padding-bottom:10px;
    text-align:center;
}
.sharing-pic img{
    width:330px;
    height:180px;
}
#us-sub-header{
    height:52px;
    overflow: hidden;
}
@media only screen and (max-width: 768px){
.fb-btn, .li-btn, .tw-btn, .wa-btn, .mail-btn {
    width:134px;
}
.mail-share{
    display:initial;
}
}
@media only screen and (max-width: 414px){
.fb-btn, .li-btn, .tw-btn, .wa-btn, .mail-btn {
    width:174px;
}
.mail-share{
    display:inherit;
}
}
@media only screen and (max-width: 380px){
.fb-btn, .li-btn, .tw-btn, .wa-btn, .mail-btn {
    width:154px;
}
}
@media only screen and (max-width: 360px){
.fb-btn, .li-btn, .tw-btn, .wa-btn, .mail-btn {
    width:296px;
}
}
');

$script = <<<JS
$(document).ready(function(){
  $(".nav-bar > ul > li > a").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top - 80
      }, 800, function(){
      });
    } 
  });
});
window.onscroll = function() {myFunction()};
var header = document.getElementById("s-header");
function myFunction() {
    var h_height = $('#main-header').height();
    var header_offset = document.getElementById("us-sub-header").offsetTop;
    if($('#s-header.sticky').length){
        $('#s-header.sticky').css('top',h_height);
    }
  if (window.pageYOffset > (header_offset - h_height)) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
$(document).on('click', "#toggle", function() {
    var elem = $("#toggle").text();
    if (elem == "Read More") {
      //Stuff to do when btn is in the read more state
      $("#toggle").text("Read Less");
      $("#show-more").slideDown();
    } else {
      //Stuff to do when btn is in the read less state
      $("#toggle").text("Read More");
      $("#show-more").slideUp();
    }
});
$(window).scroll(function() {
    var scrollDistance = $(window).scrollTop();
    $('.set-sticky').each(function(i) {
        if ($(this).position().top <= (scrollDistance - 350)) {
            $('.nav-bar > ul > li.active').removeClass('active');
            $('.nav-bar > ul > li').eq(i).addClass('active');
        }
    });
}).scroll();
JS;
$this->registerJs($script);
?>

