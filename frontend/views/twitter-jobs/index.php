<?php
//$this->params['grid_size'] = 'col-md-12';
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['header_dark'] = true;
//$this->params['background_image'] = '/assets/themes/ey/images/backgrounds/vector-form-job.png';
?>
<div id="loading_img">
</div>
<section class="head-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="twitter_jobs_cards">

                </div>
                <?php
                if (!empty($tweets)):
                foreach ($tweets as $tweet) {
                    ?>
                    <div class="col-md-3 tweet-main">
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
                else:
                    ?>
                <div class="no_tweets_found">
                    <img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>
                </div>

                <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</section>
<?php
//echo $this->render('/widgets/twitter-jobs');
$this->registerCss("
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
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
.posted-tweet iframe{width:100% !important;margin-bottom:0px !important;}
.head-bg{
    background-color:#00a0e3;
    padding:50px 0px;
}
.search-box{
    width: 100%;
    max-width: 650px;
    margin: auto;
}
#form-search .search-bar{
    border-radius: 18px;
}
#form-search .search-bar input{
    border: 0px;
    border-radius: 18px;
}
.input-group-btn{
    border-radius: 18px;
    overflow: hidden;
}
.tweet-main{
    padding: 0px 8px;
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
.search-bar
{
box-shadow:4px 6px 20px rgba(73, 72, 72, 0.5);
border: 1px solid #ddd;
    background: #fff;
}
#main_cnt
{
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
.tweet-org-logo img, .tweet-org-logo canvas{
    width:100%;
    height:100%;
    border-radius:50%;
    border:1px solid #ddd;
    margin-top: 3px;
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
#load_me
{
//display:none;
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
");
$script = <<< JS
//$('#loading_img').addClass('show');
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
$this->registerJsFile("https://platform.twitter.com/widgets.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
