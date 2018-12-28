<?php
$this->title = Yii::t('frontend', 'Jobs');
$this->params['header_dark'] = true;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\web\JsExpression;

//$this->registerCssFile('https://fonts.googleapis.com/css?family=Lobster');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Crimson+Text');
$this->registerCss('



.owl-item{
    min-height:150px !important;
}
.partners-flex-box .logo-box:hover {
    -webkit-box-shadow: 0 17px 27px -9px #757575;
    box-shadow: 0 17px 27px -9px #757575;
    -webkit-transition: -webkit-box-shadow .7s !important;
    transition: -webkit-box-shadow .7s !important;
    transition: box-shadow .7s !important;
    transition: box-shadow .7s, -webkit-box-shadow .7s !important;
}
.partners-flex .partners-flex-box {
    width: 20%;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 65px;
    width: 65px;
    background-color: #fff;
}
.partners-flex .partners-flex-box {
    width: 20%;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 90px;
    width: 90px;
    background-color: #fff;
}
.partners-flex .partners-flex-box {
    width: 130px;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 120px;
    width: 120px;
    background-color: #fff;
}
.partners-flex .partners-flex-box .image-partners {
    height: 114px;
    margin: 2px;
    cursor: pointer;
    padding: 6px;
    width: 116px;
}
.partners-flex {
    width: 90%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap;
    margin: 1.5% auto;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
.set_logo{
    display: table-cell;
    vertical-align: middle;
    height: 125px;
}
.custom_color:hover{
    color:#f08340 !important;
}
.custom_color2{
    color:#fff !important;
}
.custom_color2:hover{
    color: #202c45 !important;
}
.custom_set {
    margin-bottom: 0px !important;
    margin-top: 0px !important;
    font-weight: 700;
    padding-top: 20px;
    text-align: center;
    float: rigth;
}
.custom_set2 {
    margin-bottom: 0px !important;
    font-weight: 700;
    padding-left: 20px;
    text-align: center;
    float: left;
}
.btn-add-to-cart-wrapper{
    margin-bottom: 10px !important;
    z-index:999;
}
.btn-add-to-cart-wrapper a{
    padding:10px 15px !important;
}
.top-container {
    background-color: #f1f1f1;
    padding: 30px;
    text-align: center;
}
.content-search {
    position: relative;
    background-color: #666666;
    padding: 16px;
    top: 15% !important;
    z-index: 99;
}
.sticky {
    position: fixed;
    top: 0;
}
.sticky + .content {
    padding-top: 80px;
}
.set_icon{
    background:transparent !important;
}
.item{
    display: block;
    padding: 30px 0px;
    margin: 5px;
    color: #FFF;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    text-align: center;
}
.owl-controls .nav div {
    padding: 5px 9px;
}
.owl-nav i{
    margin-top: 2px;
}
.owl-controls .owl-nav div {
    position: absolute;
}
.owl-controls .owl-nav .owl-prev{
    left: -60px;
    top: 50px;
}
.owl-controls .owl-nav .owl-prev i,.owl-controls .owl-nav .owl-next i{
    font-size:64px !important;
}
.owl-controls .owl-nav .owl-prev,.owl-controls .owl-nav .owl-next{
    background: transparent !important;
}
.owl-controls .owl-nav .owl-next{
    right: -60px;
    top: 50px;
}
@media only screen and (max-width: 991px) {
    .side-body{
        margin-left: 168px;
    }
}
.input-group{
    width: 100%;
    margin-bottom:10px;
}
.input-group-btn:last-child>.btn, .input-group-btn:last-child>.btn-group{
    height: 45px;
}
.content-search{
    background-color: transparent !important;
    padding:0px 16px !important;
}
.search-button{
    width:94%;
    background-color: #ed4303 !important;
    color: #fff;
}
#header-search{
    margin-top: 10px;
    padding-top: 15px;
}
.btn_effect{
    transition: all .5s ease;
    border-radius: 3px;
}
.btn_effect:hover{
    color: #fff !important;
}
.is-active{
    box-shadow: 0px 16px 21px -10px #000;
    transform: translateY(6px);
}
.change-hr{
    margin-bottom: 30px;
    margin-top: 15px;
    border-top: 1px solid #ccc;
    width:100%;
}
#menuzord-right{
    padding:0px !important;
}
.blogbox{
    margin-bottom: 20px;
}

a:hover {
    text-decoration: none;
}
#loadMore {
    text-align: center;
    background-color: #202c45;
    color: #fff !important;
    border-width: 0 0px 0px 0;
    border-radius: 12px;
    border-style: solid;
    border-color: #fff;
    box-shadow: 0 6px 10px #868686;
    transition: all 600ms ease-in-out;
    -webkit-transition: all 600ms ease-in-out;
    -moz-transition: all 600ms ease-in-out;
    -o-transition: all 600ms ease-in-out;
}
#loadMore:hover {
    background-color: #f08340;
    color: #fff;
}
#loadMore h4{
    color:#fff !important;
}
.btn-div{
    border-top: 1px solid transparent;
    margin-top: 20px;
    padding-top: 20px;
    margin-bottom: 20px;
}
.blogbox *:not(i){
    font-family: Georgia !important;
}
.round{
    border-radius: 10px;
    color:white;
}
.icon-box
{
    padding: 0px 0px !important;
}

.round-info{
    border-radius: 10px;
    background: darkgrey;
    box-shadow: 0 1px 3px 0px #797979;
}
.round-info-upper{
    border-radius: 10px 10px 0px 0px;
    background: darkgrey;
}
.round-info-lower{
    border:1px;
    border-radius: 10px 10px 10px 10px;
    box-shadow: 0 1px 3px 0px #797979;
}
.info{
    background:#f9f9f9;
}
.shadow{
    box-shadow: 0 1px 3px 0px #797979;
}
.product{
    margin-bottom:15px !important;
    margin-top:0px !important;
}
.ui-draggable{
    padding: 0px 10px 10px 10px;
}
.hr{
    margin-bottom: 0px !important;
    margin-top: 0px !important;
}
.tag-sale color-o {
    background:#FF4500  !important; 
}
.color-o{
    background:#FF4500 !important;
}
.tag-sale{
    font-family:arial;
}
.product .tag-sale {
    margin: 0;
    top: 0;
    display: block;
    left: auto;
    right: 0;
    -webkit-transition: 400ms;
    -o-transition: 400ms;
    transition: 400ms;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    line-height: 18px;
    padding:4px 20px;
    position: absolute;
    text-align: right;
    text-transform: uppercase;
    z-index: 9;
}
.set_logo img{
    width: 96px;
    height: 73px;
    margin-left: 12px;
}
.icon-box-title{
    font-weight: 700;
}
.icon-box-description{
    font-weight: 700;
}
#thumbnail-slider {
    margin:0 auto; /*center-aligned*/
    width:100%;/*width:400px;*/
    max-width:600px;
    padding:20px;
    background-color:#f2f1ea;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    box-sizing:border-box;
    position:relative;
    -webkit-user-select: none;
    user-select:none;
}
#thumbnail-slider div.inner {
    /*the followings should not be changed */
    position:relative;
    overflow:hidden;
    padding:2px 0;
    margin:0;
}
#thumbnail-slider div.inner ul {
    /*the followings should not be changed */
    white-space:nowrap;
    position:relative;
    left:0; top:0;
    list-style:none;
    font-size:0;
    padding:0;
    margin:0;
    float:left!important;
    width:auto!important;
    height:auto!important;
}
#thumbnail-slider ul li {
    display:inline-block;
    *display:inline!important; /*IE7 hack*/
    border:3px solid black;
    margin:0;
    margin-right:10px; /* Spacing between thumbs*/
    transition:border-color 0.3s;
    box-sizing:content-box;
    text-align:center;
    vertical-align:middle;
    padding:0;
    position:relative;
    list-style:none;
    backface-visibility:hidden;
}
#thumbnail-slider ul li.active {
    border-color:white;
}
#thumbnail-slider .thumb {
    opacity:1;
    width:100%;
    height: 100%;
    background-size:contain;
    background-repeat:no-repeat;
    background-position:center center;
    display:block;
    position:absolute;
    font-size:0;
}
#thumbnail-slider-pause-play {display:none;} /*.pause*/
#thumbnail-slider-prev, #thumbnail-slider-next
{
    opacity:1;
    position: absolute;
    *background-color:#ccc;/*IE7 hack*/
    backface-visibility:hidden;
    width:32px;
    height:60px;
    line-height:60px;
    top: 50%;
    margin:0;
    margin-top:-30px;
    color:white;    
    z-index:10;
    cursor:pointer;
}
#thumbnail-slider-prev {
    left:-30px; right:auto;
}
#thumbnail-slider-next {
    left:auto; right:-30px;
}
#thumbnail-slider-next.disabled, #thumbnail-slider-prev.disabled {
    opacity:0.3;
    cursor:default;
}
/* arrows */
#thumbnail-slider-prev::before, #thumbnail-slider-next::before {
    position: absolute;
    top: 19px;
    content: "";
    display: block;
    width: 12px;
    height: 12px;
    border-left: 6px solid black;
    border-top: 6px solid black;
}
#thumbnail-slider-prev::before {
    left:7px;
    -ms-transform:rotate(-45deg);/*IE9*/
    -webkit-transform:rotate(-45deg);
    transform: rotate(-45deg);
}
#thumbnail-slider-next::before {
    right:7px;
    -ms-transform:rotate(135deg);/*IE9*/
    -webkit-transform:rotate(135deg);
    transform: rotate(135deg);
}
/*Responsive settings*/
@media only screen and (max-width:736px){
    #thumbnail-slider {padding:10px 26px;}
    #thumbnail-slider-prev {left:0px;}
    #thumbnail-slider-next {right:0px;}
}
#thumbs2 {
    height:300px; 
    display:inline-block;
    *display:inline; /* hack for old IE6-7 */
    background-color:#fff;
    box-shadow: 0px 1px 11px rgba(0,0,0,0.2);
    padding:16px;
    position:relative;
    -webkit-user-select: none;
    user-select:none;
}
#thumbs2 div.inner {
    width:auto;
    padding:2px;
    /*the followings should not be changed */
    height:100%;
    box-sizing:border-box;
    position:relative;
    overflow:hidden;
    margin:0 auto;
}
#thumbs2 div.inner ul {
    /*the followings should not be changed */
    position:relative;
    left:0; top:0;
    list-style:none;
    font-size:0;
    padding:0;
    margin:0;
    float:left!important;
    width:auto!important;
    height:auto!important;
}
#thumbs2 ul li {
    display:block;
    border: 4px solid transparent;
    outline:1px solid transparent;
    margin:0;
    margin-bottom:3px; /* Spacing between thumbs*/
    box-sizing:content-box;
    text-align:center;
    padding:0;
    position:relative;
    list-style:none;
    backface-visibility:hidden;
}
#thumbs2 ul li.active {
    outline-color:black;
}
#thumbs2 li:hover {
    border-color:rgba(255,255,255,0.5);
}
#thumbs2 .thumb {
    width:100%;
    height: 100%;
    background-size:contain;
    background-repeat:no-repeat;
    background-position:center center;
    display:block;
    position:absolute;
    font-size:0;
}
#thumbs2-pause-play {display:none;} /*.pause*/
#thumbs2-prev, #thumbs2-next
{
    position: absolute;
    width:100%;
    height:30px;
    line-height:30px;
    text-align:center;
    margin:0;
    z-index:10;
    cursor:pointer;
    transition:opacity 0.6s;
    *background-color:#ccc;/*IE7 hack*/
    backface-visibility:hidden;
}
#thumbs2-prev {
    top:-36px;
}
#thumbs2-next {
    bottom:-36px;
}
#thumbs2-next.disabled, #thumbs2-prev.disabled {
    opacity:0.1;
    cursor:default;
}
/* arrows */
#thumbs2-prev::before, #thumbs2-next::before {
    position:absolute;
    content: "";
    display: inline-block;
    width: 10px;
    height: 10px;
    margin-left:-20px;
    border-left: 4px solid black;
    border-top: 4px solid black;
}
#thumbs2-prev::before {
    top:12px;
    -ms-transform:rotate(-45deg);/*IE9*/
    -webkit-transform:rotate(45deg);
    transform: rotate(45deg);
}
#thumbs2-next::before {
    bottom:12px;
    -ms-transform:rotate(135deg);/*IE9*/
    -webkit-transform:rotate(-135deg);
    transform: rotate(-135deg);
}
.general-partners .partners .partners-flex .partners-flex-box {
    width: 130px;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.alerts{
    position:fixed;
    left:0%;
    bottom:2%;
    z-index:9999;
}
.bubbly-button {
  font-family: "Helvetica", "Arial", sans-serif;
  display: inline-block;
  font-size: 1em;
  padding: 1em 2em;
  margin-left:10px;
  -webkit-appearance: none;
  appearance: none;
  background-color: #ed4303;
  color: #fff;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  position: relative;
  transition: transform ease-in 0.1s, box-shadow ease-in 0.25s;
  box-shadow: 0 2px 25px rgba(237, 67, 3, 0.5);
}
.bubbly-button:hover {
    color:#FFF;
}
.bubbly-button:focus {
  outline: 0;
  color:#FFF;
}
.bubbly-button:before, .bubbly-button:after {
  position: absolute;
  content: "";
  display: block;
  width: 140%;
  height: 100%;
  left: -20%;
  z-index: 999999 !important;
  transition: all ease-in-out 0.5s;
  background-repeat: no-repeat;
}
.bubbly-button:before {
  display: none;
  top: -75%;
  background-image: radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, transparent 20%, #ed4303 20%, transparent 30%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, transparent 10%, #ed4303 15%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%);
  background-size: 10% 10%, 20% 20%, 15% 15%, 20% 20%, 18% 18%, 10% 10%, 15% 15%, 10% 10%, 18% 18%;
}
.bubbly-button:after {
  display: none;
  bottom: -75%;
  background-image: radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, transparent 10%, #ed4303 15%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%), radial-gradient(circle, #ed4303 20%, transparent 20%);
  background-size: 15% 15%, 20% 20%, 18% 18%, 20% 20%, 15% 15%, 10% 10%, 20% 20%;
}
.bubbly-button:active {
  transform: scale(0.9);
  background-color: #de4f19;
  box-shadow: 0 2px 25px rgba(237, 67, 3, 0.5);
}
.bubbly-button.animate:before {
  display: block;
  animation: topBubbles ease-in-out 0.75s forwards;
}
.bubbly-button.animate:after {
  display: block;
  animation: bottomBubbles ease-in-out 0.75s forwards;
}

@keyframes topBubbles {
  0% {
    background-position: 5% 90%, 10% 90%, 10% 90%, 15% 90%, 25% 90%, 25% 90%, 40% 90%, 55% 90%, 70% 90%;
  }
  50% {
    background-position: 0% 80%, 0% 20%, 10% 40%, 20% 0%, 30% 30%, 22% 50%, 50% 50%, 65% 20%, 90% 30%;
  }
  100% {
    background-position: 0% 70%, 0% 10%, 10% 30%, 20% -10%, 30% 20%, 22% 40%, 50% 40%, 65% 10%, 90% 20%;
    background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
  }
}
@keyframes bottomBubbles {
  0% {
    background-position: 10% -10%, 30% 10%, 55% -10%, 70% -10%, 85% -10%, 70% -10%, 70% 0%;
  }
  50% {
    background-position: 0% 80%, 20% 80%, 45% 60%, 60% 100%, 75% 70%, 95% 60%, 105% 0%;
  }
  100% {
    background-position: 0% 90%, 20% 90%, 45% 70%, 60% 110%, 75% 80%, 95% 70%, 110% 10%;
    background-size: 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%, 0% 0%;
  }
}
.select2-selection{
    height:45px !important;
    border-radius:0px !important;
}
.select2-selection__arrow{
    display:none !important;
}
.select2-container{
    width: 200px !important;
    margin-left: -1px !important;
}
.select2-selection__rendered{
    margin-top:6px !important;
    text-align:left !important;
}



.tag-load{
    margin: 0;
    top: 0;
    display: block;
    left: auto;
    right: 0;
    -webkit-transition: 400ms;
    -o-transition: 400ms;
    transition: 400ms;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    line-height: 18px;
    padding: 4px 10px 4px 16px;
    position: absolute;
    text-align: right;
    text-transform: uppercase;
    z-index: 9;
}
.product .tag-load .anim{
  max-width:30%;
  float:right;
}
.set_logo .anim{
  max-width:96px;
  height:73px;
  margin-left:10px;
}
.icon-box-title strong .anim{
  max-width:100%;
  height:15px;
}
.locations .anim{
  max-width:60%;
}
.periods .anim{
  max-width:40%;
}
.custom_set2 strong .anim{
  max-width:80%;
  margin:auto;
}
.last-date .anim{
  max-width:60%;
  margin:auto;
}
.custom_set strong .anim{
  max-width:80%;
  height:18px;
  float:right;
}
.loader {
	display: block;
  position:relative;
	width: 160px;
	height: 10px;
	background-color: #ECEFF1;
	border-radius: 4px;
}
.anim {
    animation-duration: 1s;
    animation-fill-mode: forwards;
    animation-iteration-count: infinite;
    animation-name: placeHolderAnim;
    animation-timing-function: linear;
    background: #f6f7f8;
    background: linear-gradient(to right, #ECEFF1 8%, #DBE2E5 18%, #ECEFF1 33%);
    background-size: 40rem 1rem;
    position: relative;
}
@keyframes placeHolderAnim {
    0% { background-position: -12rem 0; }
    100% { background-position: 12rem 0; }
}
.border-top-set{
    border-top: 1px solid #ccc;
    padding-top: 20px;
}
');
?>
<div class="alerts">
    <?=
    Html::button('<i class="fa fa-envelope"></i> Email Jobs', [
        'class' => 'btn btn-md bubbly-button',
        'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'jobalert'),
        'id' => 'open-modal',
        'data-toggle' => 'modal',
        'data-target' => '#myModal2',
    ]);
    ?>
<!--    <button type="button" class="bubbly-button" data-toggle="modal" data-target="#myModal2"><i class="fa fa-envelope"></i> Email Jobs</button>-->
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!--<div class="modal-header">-->
            <!--                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
            <!--<h4 class="">Modal Header</h4>-->
            <!--<h3 class="modal-title"><i class="fa fa-bell-o fa-lg"></i> Create Job alert</h3>-->
            <!--</div>-->
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>" alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
                <!--                <form>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Name:</label>
                                            <input type="text" class="form-control" placeholder="Enter email" name="email">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Email:</label>
                                            <input type="email" class="form-control" placeholder="Enter password" name="pwd">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Location:</label>
                                            <input type="text" class="form-control" placeholder="Enter email" name="email">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Email Frequency:</label>
                                            <select class="form-control">
                                                <option>Daily</option>
                                                <option>Weekly</option>
                                                <option>Fortnightly</option>
                                                <option>Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-default">Submit</button>
                                </form>-->
            </div>
        </div>
    </div>
</div>
<section>
    <div class="col-md-2">
        <?=
        $this->render('/widgets/sidebar-review', [
            'type' => 'jobs',
        ]);
        ?>
    </div>
    <div class="col-md-10">
        <div class="side-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="overlay-white-9">
                        <div id="header-search">
                            <form>
                                <div class="row content-search">
                                    <div class="col-md-10 col-xs-12">
                                        <div class="col-md-3 col-xs-6 ">
                                            <div class="input-group">
                                                <input type="text" placeholder="Enter Field" class="form-control search-input">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="input-group">
                                                <input type="text" placeholder="Search by Duration" class="form-control search-input">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="input-group">
                                                <select class="form-control">
                                                    <option class="form-control">Search Courses
                                                    </option>
                                                    <option class="form-control">Web Development
                                                    </option>
                                                    <option class="form-control">Web Design
                                                    </option>
                                                    <option class="form-control">Programming
                                                    </option>
                                                    <option class="form-control">Search All
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-6">
                                            <div class="input-group">
                                                <?=
                                                Select2::widget([
                                                    'name' => 'state_10',
                                                    'options' => [
                                                        'placeholder' => 'Enter State or City',
                                                        'class' => 'form-control',
                                                        'multiple' => false
                                                    ],
                                                    'pluginOptions' => [
                                                        'ajax' => [
                                                            'url' => Url::to(['cities/city-list']),
                                                            'dataType' => 'json',
                                                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                                        ],
                                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                                        'templateResult' => new JsExpression('function(city) { return city.text; }'),
                                                        'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                                                    ],
                                                ]);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-12 text-center">
                                        <button type="submit" class="btn search-button btn_effect">
                                            <i class="fa fa-search">
                                            </i> Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row border-top-set">
                <div class="col-md-12">
                    <div class="row cards_place">
                        
                    </div>
<!--                       <div class="row work-load blogbox cards_place">-->
<!--                            <div class="col-md-4 pt-5">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                    <span class="tag-sale color-o pl-20 pr-20 "><i class="fa fa-inr"></i> 1.75+ lpa
                                    </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5" >
                                            <a href="#" class="icon set_logo">
                                                <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/7d8b513d-6743-4059-9df7-aad9bd63a76c.png">
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title"> 
                                                <strong>PHP Developer 
                                                </strong>
                                            </h4>
                                            <h5> 
                                                <i class="fa fa-location-arrow"></i> 
                                                <strong>Ludhiana, Jalandhar, Amritsar, Chandigarh
                                                </strong>

                                            </h5>
                                            <h5>
                                                <i class="fa fa-map-pin"> 
                                                    Min 1 yr exp
                                                </i>
                                            </h5>
                                        </div>
                                        <div class="btn-add-to-cart-wrapper">
                                            <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/jobs/detail">VIEW DETAILS
                                            </a>
                                            <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                                <i class="fa fa-plus">
                                                </i>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-8">
                                            <h4 class="pull-right pr-10 pt-10 custom_set" align="right">
                                                <p><strong>Empower Youth</strong>
                                                </p>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
<!--                       </div> -->
<!--                            <div class="col-md-4 pt-5">
                                <div class="product iconbox-border iconbox-theme-colored shadow">
                                    <span class="tag-sale color-o pl-20 pr-20 "><i class="fa fa-inr"></i> 1.75+ lpa
                                    </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5" >
                                            <a href="#" class="icon set_logo">
                                                <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/8032b0b9-ae8a-43a1-a8fa-df1c258add83.png">
                                            </a> 
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title"> 
                                                <strong>Web Development</strong></h4>
                                            <h5> 
                                                <i class="fa fa-location-arrow"></i>
                                                <strong>Gurgaon,Pune
                                                </strong>

                                            </h5>
                                            <h5>
                                                <i class="fa fa-map-pin"> 
                                                    Min 2 yr exp
                                                </i>
                                            </h5>
                                        </div>
                                        <div class="btn-add-to-cart-wrapper">
                                            <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/jobs/detail">VIEW DETAILS
                                            </a>
                                            <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                                <i class="fa fa-plus">
                                                </i>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <div class="row">
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-8">
                                            <h4 class="pull-right pr-10 pt-10 custom_set" align="right">
                                                <p><strong>DSB Edutech</strong>
                                                </p>
                                            </h4>
                                        </div>
                                    </div>
                                </div> 
                            </div>-->
<!--                            <div class="col-md-4 pt-5">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                    <span class="tag-sale color-o pl-20 pr-20 "><i class="fa fa-inr"></i> 1.75+ lpa
                                    </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5" >
                                            <a href="#" class="icon set_logo">
                                                <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/7d8b513d-6743-4059-9df7-aad9bd63a76c.png">
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title"> 
                                                <strong>PHP Developer
                                                </strong>
                                            </h4>
                                            <h5> 
                                                <i class="fa fa-location-arrow"></i>
                                                <strong> Chandigarh,Ludhiana
                                                </strong>

                                            </h5>
                                            <h5>
                                                <i class="fa fa-map-pin"> 
                                                    Min 2 yr exp
                                                </i>
                                            </h5>
                                        </div>
                                        <div class="btn-add-to-cart-wrapper">
                                            <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/jobs/detail">VIEW DETAILS
                                            </a>
                                            <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                                <i class="fa fa-plus">
                                                </i>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <div class="row">
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-8">
                                            <h4 class="pull-right pr-10 pt-10 custom_set" align="right">
                                                <p><strong>DSB Edutech</strong>
                                                </p>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                       
                  
<!--                        <div class="row work-load blogbox" style="display: none;">
                            <div class="col-md-4 pt-5">
                                <div class="product shadow iconbox-border iconbox-theme-colored">
                                    <span class="tag-sale color-o pl-20 pr-20 "><i class="fa fa-inr"></i> 1.75+ lpa
                                    </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5" >
                                            <a href="#" class="icon set_logo">
                                                <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/7d8b513d-6743-4059-9df7-aad9bd63a76c.png">
                                            </a>
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title"> 
                                                <strong>PHP Developer 
                                                </strong>
                                            </h4>
                                            <h5> 
                                                <i class="fa fa-location-arrow"></i>
                                                <strong>Ludhiana,Jalandhar
                                                </strong>

                                            </h5>
                                            <h5>
                                                <i class="fa fa-map-pin"> 
                                                    Min 1 yr exp
                                                </i>
                                            </h5>
                                        </div>
                                        <div class="btn-add-to-cart-wrapper">
                                            <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/jobs/detail">VIEW DETAILS
                                            </a>
                                            <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                                <i class="fa fa-plus">
                                                </i>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="hr">
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-8">
                                            <h4 class="pull-right pr-10 pt-10 custom_set" align="right">
                                                <p><strong>Empower Youth</strong>
                                                </p>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 pt-5">
                                <div class="product iconbox-border iconbox-theme-colored shadow">
                                    <span class="tag-sale color-o pl-20 pr-20 "><i class="fa fa-inr"></i> 1.75+ lpa
                                    </span>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 pt-5" >
                                            <a href="#" class="icon set_logo">
                                                <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/8032b0b9-ae8a-43a1-a8fa-df1c258add83.png">
                                            </a> 
                                        </div>
                                        <div class="col-md-8 col-xs-8 pt-20">
                                            <h4 class="icon-box-title"> 
                                                <strong>Web Development</strong></h4>
                                            <h5> 
                                                <i class="fa fa-location-arrow"></i>
                                                <strong>Gurgaon,Pune
                                                </strong>

                                            </h5>
                                            <h5>
                                                <i class="fa fa-map-pin"> 
                                                    Min 2 yr exp
                                                </i>
                                            </h5>
                                        </div>
                                        <div class="btn-add-to-cart-wrapper">
                                            <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/jobs/detail">VIEW DETAILS
                                            </a>
                                            <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                                <i class="fa fa-plus">
                                                </i>
                                            </a>
                                        </div>
                                    </div>
                                <hr class="hr">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="pull-right pr-10 pt-10 custom_set" align="right">
                                            <p><strong>DSB Edutech</strong>
                                            </p>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 pt-5">
                            <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-sale color-o pl-20 pr-20 "><i class="fa fa-inr"></i> 1.75+ lpa
                                </span>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4 pt-5" >
                                        <a href="#" class="icon set_logo">
                                            <img src="https://gallery.mailchimp.com/c7206d4075e0ae713cf6ecde2/images/7d8b513d-6743-4059-9df7-aad9bd63a76c.png">
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-xs-8 pt-20">
                                        <h4 class="icon-box-title"> 
                                            <strong>PHP Developer
                                            </strong>
                                        </h4>
                                        <h5> 
                                            <i class="fa fa-location-arrow"></i>
                                            <strong> Chandigarh,Ludhiana
                                            </strong>

                                        </h5>
                                        <h5>
                                            <i class="fa fa-map-pin"> 
                                                Min 2 yr exp
                                            </i>
                                        </h5>
                                    </div>
                                    <div class="btn-add-to-cart-wrapper">
                                        <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/jobs/detail">VIEW DETAILS
                                        </a>
                                        <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                            <i class="fa fa-plus">
                                            </i>
                                        </a>
                                    </div>
                                </div>
                                <hr class="hr">
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="pull-right pr-10 pt-10 custom_set" align="right">
                                            <p><strong>DSB Edutech</strong>
                                            </p>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
             
                <div class="row blogbox loader-main" style="display: none;">
                    <div class="col-md-4">
                        <div class="product shadow iconbox-border iconbox-theme-colored">
                            <span class="tag-load pl-20 pr-20 ">
                                <div class="loader anim"></div>
                            </span>
                            <div class="row">
                                <div class="col-md-4 col-xs-4 pt-5" >
                                    <a href="#" class="icon set_logo">
                                        <div class="loader anim"></div>
                                    </a>
                                </div>
                                <div class="col-md-8 col-xs-8 pt-20">
                                    <h4 class="icon-box-title">
                                        <strong><div class="loader anim"></div></strong>
                                    </h4>
                                    <h5>
                                        <i class="locations"><div class="loader anim"></div></i>
                                    </h5>
                                    <h5>
                                        <i class="periods"><div class="loader anim"></div></i>
                                    </h5>
                                </div>
                            </div>
                            <hr class="hr">
                            <div class="col-md-6">
                                <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                    <br>
                                    <div class="last-date">
                                        <div class="loader anim"></div>
                                    </div>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h4 class="pull-right pt-20 custom_set" align="center">
                                    <strong>
                                        <div class="loader anim"></div>
                                    </strong>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product shadow iconbox-border iconbox-theme-colored">
                            <span class="tag-load pl-20 pr-20 ">
                                <div class="loader anim"></div>
                            </span>
                            <div class="row">
                                <div class="col-md-4 col-xs-4 pt-5" >
                                    <a href="#" class="icon set_logo">
                                        <div class="loader anim"></div>
                                    </a>
                                </div>
                                <div class="col-md-8 col-xs-8 pt-20">
                                    <h4 class="icon-box-title">
                                        <strong><div class="loader anim"></div></strong>
                                    </h4>
                                    <h5>
                                        <i class="locations"><div class="loader anim"></div></i>
                                    </h5>
                                    <h5>
                                        <i class="periods"><div class="loader anim"></div></i>
                                    </h5>
                                </div>
                            </div>
                            <hr class="hr">
                            <div class="col-md-6">
                                <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                    <br>
                                    <div class="last-date">
                                        <div class="loader anim"></div>
                                    </div>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h4 class="pull-right pt-20 custom_set" align="center">
                                    <strong>
                                        <div class="loader anim"></div>
                                    </strong>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="product shadow iconbox-border iconbox-theme-colored">
                            <span class="tag-load pl-20 pr-20 ">
                                <div class="loader anim"></div>
                            </span>
                            <div class="row">
                                <div class="col-md-4 col-xs-4 pt-5" >
                                    <a href="#" class="icon set_logo">
                                        <div class="loader anim"></div>
                                    </a>
                                </div>
                                <div class="col-md-8 col-xs-8 pt-20">
                                    <h4 class="icon-box-title">
                                        <strong><div class="loader anim"></div></strong>
                                    </h4>
                                    <h5>
                                        <i class="locations"><div class="loader anim"></div></i>
                                    </h5>
                                    <h5>
                                        <i class="periods"><div class="loader anim"></div></i>
                                    </h5>
                                </div>
                            </div>
                            <hr class="hr">
                            <div class="col-md-6">
                                <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                    <br>
                                    <div class="last-date">
                                        <div class="loader anim"></div>
                                    </div>
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <h4 class="pull-right pt-20 custom_set" align="center">
                                    <strong>
                                        <div class="loader anim"></div>
                                    </strong>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="btn-div" align="center">
                    <a href="#" id="loadMore" class="btn btn-primary" align="center"style="color:white">
                        <h4>Load More 
                            <i class="fa fa-angle-down">
                            </i>
                        </h4>
                    </a>
                </div>
                <hr class="change-hr">
                <div class="esc-heading ml-20">
                    <h3 style="font-family:lobster;font-size:28pt;margin-bottom:0px;text-indent: 50px;">Featured Companies</h3>
                </div>
                <div class="row ml-20 mr-20">
                    <div class="partners-flex">
                        <div class="owl-carousel-4col" data-dots="false" data-nav="true">
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/dsbedutech.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/agile.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/dsblaw.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/agile.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/ey.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/dsblaw.jpg'); ?>" align="left">
                                </a>
                            </div>
                            <div class="item partners-flex-box">
                                <a class="logo-box" href="">
                                    <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/agile.jpg'); ?>" align="left">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<?php
$script = <<<JS

function job_cards()
        {
         $.ajax({
                url:'/jobs/job-cards',
                method:'post',
              
                success:function(data)
                    {
                      var data = JSON.parse(data);
                      var html = [];
        
                       $.each(data,function()
                           {
                                html.push("<div class=\"col-md-4\"><div class=\"product shadow\"><span class=\"tag-sale color-o\"> paid </span><div class=\"row\"> <div class=\"col-md-4 col-sm-4 pt-5\" > <a href=\"#\" class=\"icon set_logo\"><img width=\"95px\" height=\"95px\" src=\"http://www.eygb.co/assets/img/favicon.png\"></a></div> <div class=\"col-md-8 col-sm-8 pt-20\"><h4 class=\"icon-box-title\">"+ this.title+"</h4> <h5 class=\"icon-box-description\"><i class=\"fa fa-map-marker\"></i>"+this.name+"</h5><h5><i class=\"fa fa-clock-o\"></i>"+this.type+"</h5></div><div class=\"btn-add-to-cart-wrapper\"><a class=\"btn btn-theme-colored btn-flat text-uppercase font-weight-700\" href=\"#\">View Detail</a> <a style=\"background-color:#FF4500\" class=\"btn btn-sm btn-flat text-uppercase font-weight-700\" href=\"#\"><i class=\"fa fa-plus\"> </i></a></div></div><hr class=\"hr\"><div class=\"row\"><div class=\"col-md-5\"><h6 class=\"custom_set2\"><br></h6></div><div class=\"col-md-7\"><h4 class=\"custom_set\">"+this.company_name+"</h4></div></div></div></div>");
                           });
                      $('.cards_place').html(html);
                     
                    }
               })
        }
  
  job_cards();
        
        
$(document).on("click", "#open-modal", function () {
    $(".modal-body").load($(this).attr("url"));
});

        
$('.owl-carousel-4col').owlCarousel({
    loop: true,
    nav: true,
    dots: false,
    pauseControls: true,
    margin: 20,
    responsiveClass: true,
    navText: [
        '<i class="fa fa-angle-left set_icon"></i>',
        '<i class="fa fa-angle-right set_icon"></i>'
    ],
    responsive: {
        0: {
            items: 1
        },
        568: {
            items: 2
        },
        600: {
            items: 3
        },
        1000: {
            items: 6
        },
        1400: {
            items: 7
        }
    }
});

//$(document).on('click', '.mb-10 .product', function (event) {
//    event.preventDefault();
//$('#modal').modal('toggle');
//         var html =
//       "<div>" +
//          "Firstname:<br>" +
//          "<input type='text' class='firstname'/>" +
//          "<br/><br/>" +
//          "Lastname:<br>" +
//          "<input type='text' class='lastname'/>" +
//          "<br/><br/>" +
//          "<button class='ok'>ok</button>" +    
//       "</div>";
//      $('.modal-content').html(html);
////    var div = $(html);	
////    
////    var default_firstname = $('#default_firstname').val();
////    div.find('.firstname').val(default_firstname);        
//});
        

$(document).ready(function () {
    $(".work-load").slice(0, 3).show();
    if ($(".blogbox:hidden").length != 0) {
        $("#loadMore").show();
    }
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $('.loader-main').slideDown();
        setTimeout(function() { $(".loader-main").hide(); 
            $(".work-load:hidden").slice(0, 1).fadeIn();
        if ($(".work-load:hidden").length == 0) {
            $(".btn-div").fadeOut('slow');
        }
        }, 2000);
        
        
    });
});
        

$(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
        $('.totop a').fadeIn(5000);
    } else {
        $('.totop a').fadeOut();
    }
});

$(".btn_effect").hover(function () {
    $(this).toggleClass("is-active");
});
        
var animateButton = function(e) {

  e.preventDefault;
  //reset animation
  e.target.classList.remove('animate');
  
  e.target.classList.add('animate');
  setTimeout(function(){
    e.target.classList.remove('animate');
  },700);
};

var bubblyButtons = document.getElementsByClassName("bubbly-button");

for (var i = 0; i < bubblyButtons.length; i++) {
  bubblyButtons[i].addEventListener('click', animateButton, false);
}
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);


