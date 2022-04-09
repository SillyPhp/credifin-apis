<?php
use yii\helpers\Url;
$this->title = 'Job Tweets';
$this->params['header_dark'] = true;
$seo_keywords = 'twitter jobs,Freshers jobs,Software Jobs,IT Jobs, Technical Jobs,Job Tweets,  MBA Jobs, Career, Part Time Jobs,Top 10 Websites for jobs,Top lists of job sites,Jobs services in india,top 50 job portals in india, jobs in india for freshers';
$description = 'Empower Youth is a career development platform where you can find your dream job and give wings to your career.';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/images/fb-image.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::to(Yii::$app->request->url,'https'),
    ],
    'name' => [
        'keywords' => $seo_keywords,
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
?>
<script src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<div id="loading_img">
</div>
<section class="head-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 z-index-9">
                <div class="search-box">
                    <form id="form-search" action="">
                        <div class="input-group search-bar">
                            <input type="text" id="search_company" class="col-md-7 header-search-tw" placeholder="Search Skills,Job title,Companies" name="keywords" value="<?= $keywords ?>">
                            <input type="text" id="cities" class="col-md-12 header-search-tw" placeholder="Enter Location" name="location" value="<?= $location ?>">
                            <div class="load-suggestions Typeahead-spinner">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                            <div class="input-group-btn">
                                <button class="loader_btn_search"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="overlay-image i-2"><img src="<?= Url::to('@eyAssets/images/pages/tw-jobs/tweet2.png');?>"/></div>
        <div class="overlay-image i-3"><img src="<?= Url::to('@eyAssets/images/pages/tw-jobs/tweet3.png');?>"/></div>
        <div class="overlay-image i-4"><img src="<?= Url::to('@eyAssets/images/pages/tw-jobs/tweet4.png');?>"/></div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <?php
            if (!empty($tweets)):
            ?>
            <div class="masonry">
                <div id="twitter_jobs_cards">
                </div>
                <?php
                foreach ($tweets as $tweet) {
                    ?>
                    <div class="tweet-main">
                        <div class="tweet-inner-main">
                            <div class="tweet-org-deatail">
                                <div class="tweet-org-logo">
                                    <?php if (!empty($tweet['logo'])): ?>
                                        <img src="<?= $tweet['logo'] ?>"/>
                                    <?php else: ?>
                                        <canvas class="user-icon" name="<?= $tweet['org_name'] ?>" width="150"
                                                height="150"
                                                color="<?= $tweet['color'] ?>" font="70px"></canvas>
                                    <?php endif; ?>
                                </div>
                                <div class="tweet-org-description">
                                    <h2><?= ucwords($tweet['job_title']) ?></h2>
                                    <h4><?= ucwords($tweet['org_name']) ?></h4>
                                    <p><?= $tweet['job_type'] ?></p>
                                </div>
                            </div>
                            <div class="posted-tweet">
                                <?= $tweet['html_code']; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php else: ?>
                <div class="no_tweets_found">
                    <img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php
if($type == 'internships') {
    ?>
    <div class="re-twitte">
        <a href="/tweets/internship/create" class="t-btn">
            <i class="fab fa-twitter"></i>
            Post Internship Tweet
        </a>
    </div>
    <?php
} else {
    ?>
    <div class="re-twitte">
        <a href="/tweets/job/create" class="t-btn">
            <i class="fab fa-twitter"></i>
            Post Job Tweet
        </a>
    </div>
    <?php
}
$this->registerCss("
.fullwidth-page > #wrapper.clearfix > .main-content{
    padding-top:0px !important;
}
.re-twitte{
	position:fixed;
	width:225px;
	height:80px;
	bottom:0px;
	right:10px;
	z-index: 9999;
}
.t-btn{
    position:absolute;
    right:10px;
    padding:15px;
    border:none;
    background-color:#00a0e3;
    border-radius:5px;
    box-shadow:0px 5px 9px 3px skyblue;
    color: #fff;
    font-size: 15px;
    font-weight: 700;
}
.t-btn:hover, .t-btn:focus{
    color:#fff;
}
.z-index-9{z-index:9;}
.not-found{
    max-width: 400px;
    width:100%;
    margin: auto;
    display: block;
}
.tweet-org-logo{
   display: inline-block;
    height: 50px;
    width: 50px;
    float: left;
    position: relative;
    border: 1px solid #ddd;
    border-radius: 50%;
    overflow: hidden;
}
.tweet-org-description{
    display:inline-block;
    width: calc(100% - 52px);
    padding-left:10px;
}
.tweet-org-logo img, .tweet-org-logo canvas{
    max-width: 40px;
    max-height: 40px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.tweet-org-logo canvas{
    max-width: 50px !important;
    max-height: 50px !important;
}
twitter-widget[style]{
    position: static;
    visibility: visible;
    display: block;
    transform: rotate(0deg);
    max-width: 100%;
    width: 100% !important;
    min-width: 100% !important;
    margin-top: 69px;
    margin-bottom: 10px;
}
@media only screen and (min-width:992px and max-width:1200px){
    .tweet-main{
        width: 100% !important;
    }
    twitter-widget[style]{
        position: static;
        visibility: visible;
        display: block;
        transform: rotate(0deg);
        max-width: 100%;
        width: 100% !important;
        min-width: 100% !important;
        margin-top: 69px;
        margin-bottom: 10px;
    }
}

.posted-tweet {
    margin-top: 69px !important;
}

body{
    background:url('" . Url::to('@eyAssets/images/backgrounds/p6.png') . "');
}
.header-search-tw{
    height:45px;
}
.header-search-tw:nth-child(2){
    border-left: 1px solid #f3f3f3 !important;
}
.header-search-tw::placeholder {
  color: #6c757d;
  font-size:14px;
  opacity: 1; /* Firefox */
}

.header-search-tw:-ms-input-placeholder { /* Internet Explorer 10-11 */
 color: #6c757d;
 font-size:14px;
}

.header-search-tw::-ms-input-placeholder { /* Microsoft Edge */
 color: #6c757d;
 font-size:14px;
}
.posted-tweet iframe{width:280px !important;margin-bottom:0px !important;}
.head-bg{
    background-color:#C1E8F1;
    padding: 85px 0px;
    height: 300px;
}
.search-box{
    width: 100%;
    max-width: 650px;
    margin: auto;
    margin-top: -30px;
}
#form-search .search-bar{
    border-radius: 18px;
}
#form-search .search-bar input{
    border: 0px;
    border-radius: 18px;
    width: 245px;
}
.input-group-btn{
    border-radius: 18px;
    overflow: hidden;
}

.masonry { 
    -webkit-column-count: 4;
  -moz-column-count:4;
  column-count: 4;
  -webkit-column-gap: 1em;
  -moz-column-gap: 1em;
  column-gap: 1em;
   margin: 1.5em;
    padding: 0;
    -moz-column-gap: 1.5em;
    -webkit-column-gap: 1.5em;
    column-gap: 1.5em;
    font-size: .85em;
}
.tweet-main{
     display: inline-block;
    background: #fff;
    width: 100%;
	-webkit-transition:1s ease all;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    margin-bottom: 20px;
}
#form-search{
    margin-bottom:55px;
}
.search-bar button {
    padding: 13px 19px 12px 16px;
    border: none;
    background: #fff;
    color: #999;
    }
.search-bar{
    box-shadow:4px 6px 20px rgba(73, 72, 72, 0.5);
    border: 1px solid #ddd;
    background: #fff;
}
#main_cnt{
    margin-top:20px
}
.tweet-org-deatail{
    width:100%;
    position:relative;
    float:left;
    background-color: #fff;
    padding: 10px 10px 0px;
    border-bottom: 1px solid #e8e8e8;
}
.tweet-org-logo{
    display:inline-block;
    max-width:50px;
    float:left;
}
.tweet-org-description{
    display:inline-block;
    width: calc(100% - 52px);
    padding-left:10px;
}
.tweet-org-description *{
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    font-family: Roboto;
}
.tweet-org-description h4{
    font-size: 12.5px;
    font-weight: 400;
    color: #222;
    margin: 0px;
    line-height: 14px;
}
.tweet-org-description h2{
    font-size: 16px;
    font-weight: 500;
    color: #222;
    margin: 0px 0px;
}
.tweet-org-description p{
    color: #777;
    font-size: 13px;
    margin: 0px;
    line-height: 16px;
    font-weight: 400;
}
.tweet-inner-main{
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0px 2px 10px 2px #eaeaea;
}

#loading_img
{
  display:none;
}

#loading_img.show
{
display : block;
position : fixed;
z-index: 100;
background-image : url('/assets/themes/ey/images/loader/5.gif');
opacity : 1;
background-repeat : no-repeat;
background-position : center;
width:60%;
height:60%;
left : 20%;
bottom : 0;
right : 0;
top : 20%;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
  margin: 0px 0;
  text-align:left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 0px 0px 6px 6px;
     -moz-border-radius: 0px 0px 6px 6px;
          border-radius: 0px 0px 6px 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 0;
    top: 10px;
    font-size: 25px;
    display: none;
}
.twitter-typeahead{
    float:left;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 34px;
    z-index: 999;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 15px 1px;
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
.no_result_found
{
display:inline-block;
}
.add_org
{
float:right;
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
.overlay-image {
    position: absolute;
    width: 100%;
    max-width: 220px;
    z-index: 0;
}
.overlay-image.i-2 {
    left: 0;
    top: 0px;
}
.overlay-image.i-3 {
    right: 0%;
    bottom: 0%;
}
.overlay-image.i-4 {
    bottom: 0px;
    left: 20%;
}
.twitter-tweet {
    max-width: 272px !important;
    justify-content:center;
    margin-left: auto !important;
    margin-right: auto !important;
}
//.container blockquote  {
//    display: none;
//}
@media only screen and (max-width: 1199px){
    .masonry{
        column-count: 3;
    }
}
@media only screen and (max-width: 991px){
    .masonry{
        column-count: 2;
    }
}
@media only screen and (max-width: 550px){
    .overlay-image {
        max-width: 115px;
    }
    .masonry { 
        -webkit-column-count: 1;
      -moz-column-count:1;
      column-count: 1;
      column-gap: 0em;
       margin: 0em;
        -moz-column-gap: 0em;
        -webkit-column-gap: 0em;
        column-gap: 0em;
    }
}
");
$script = <<< JS
var city = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/cities/city-list?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(list) {
             return list;
        }
  }
});
twttr.ready(function (twttr) {
    // At this point the widget.js file had been loaded.
    // We can now make use of the twttr events
    twttr.events.bind('loaded', function (event) {
         // At this point all tweets have been fully loaded
         // and rendered and you we can proceed with our Javascript
        $.each($(".container blockquote"),function() {
          // console.log($(this).closest(".tweet-main").css("display","none"));
        })
    });
});

    
$('#cities').typeahead(null, {
  name: 'cities',
  highlight: true,       
  display: 'text',
  source: city,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.Typeahead-spinner').hide();
  });

$(window).on('load', function() {
    var head = $(".posted-tweet iframe").contents().find("head");
    var css = '<style type="text/css">' +
              '.EmbeddedTweet{border: none !important;border-radius: 0 !important;}; ' +
              '</style>';
    jQuery(head).append(css);
});
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
