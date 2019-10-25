<?php
$this->params['header_dark'] = false;
use yii\helpers\Url;
Yii::$app->view->registerJs('var keywords = "'. $keywords.'"',  \yii\web\View::POS_HEAD);
?>
<div id="loading_img">
</div>
<section class="head-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 z-index-9">
                <div class="search-box text-center">
                    <h2 class="text-white font-23">Looking for a <b>Career In US Govt</b>. Find Your <b>Dream Job</b> Today.</h2>
                    <form id="form-search" action="">
                        <div class="input-group search-bar">
                            <input type="text" id="search_company" class="col-md-7 header-search-tw" placeholder="Search Usa Jobs, Job title, Department." name="keywords" value="<?= $keywords ?>">
                            <div class="input-group-btn">
                                <button class="loader_btn_search"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<!--        <div class="overlay-image i-2"><img src="--><?//= Url::to('@eyAssets/images/pages/tw-jobs/top-header.png');?><!--"/></div>-->
<!--        <div class="overlay-image i-3"><img src="--><?//= Url::to('@eyAssets/images/pages/tw-jobs/bottom-header-1.png');?><!--"/></div>-->
<!--        <div class="overlay-image i-4"><img src="--><?//= Url::to('@eyAssets/images/pages/tw-jobs/tweet4.png');?><!--"/></div>-->
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
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
<?php
$this->registerCss("
.loader_screen img
{
display:none;
margin:auto
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
.posted-tweet iframe{width:100% !important;margin-bottom:0px !important;}
.head-bg{
    background:url('" . Url::to('@eyAssets/images/pages/jobs/usa-jobs-bg.png') . "');
    background-repeat: no-repeat;
    background-size: 100% 100%;
    padding: 105px 0px;
    height: 350px;
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
#search_company
{
width:100%; 
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
    max-width: 500px;
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
#loader
{
display:none;
}
@media only screen and (max-width: 550px){
    .overlay-image {
        max-width: 115px;
    }
}
");
echo $this->render('/widgets/mustache/usa-jobs-card');
$script = <<< JS
$(document).on('click','#loader',function(e) {
  e.preventDefault();
  fetchLocalData(template=$('#cards'),min+8,max+8,loader=false,loader_btn=true);
})
var host = 'data.usajobs.gov';  
var userAgent = 'snehkant93@gmail.com';  
var authKey = 'ePz5DRXvkE/1XaIu++wGwe5EzgmvM3jNTbHRe9dGMRM='; 
$(document).on('submit','#form-search',function(e) {
  e.preventDefault();
  var keyword = $('#search_company').val();
  fetch_usa_cards(host,userAgent,authKey,template=$('#cards'),keyword);
})
var min =0;
var max = 8;
fetchLocalData(template=$('#cards'),min,max,loader=true,loader_btn=false);
//fetch_usa_cards(host,userAgent,authKey,template=$('#cards'),keywords);
JS;
$this->registerJs($script);
?>
