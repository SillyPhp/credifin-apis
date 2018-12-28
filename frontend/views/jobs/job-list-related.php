<?php
$this->title = Yii::t('frontend', 'Jobs');
$this->params['header_dark'] = true;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

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
.top-container {
    background-color: #f1f1f1;
    padding: 30px;
    text-align: center;
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
    margin:0px;
    margin-bottom: 20px;
}

a:hover {
    text-decoration: none;
}
.btn-div2{
    border-top: 1px solid transparent;
    margin-top: 20px;
    padding-top: 20px;
    margin-bottom: 20px;
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
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>" alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>
<section>
    <div class="row">
        <div class="col-md-2">
            <?=
            $this->render('/widgets/sidebar-review', [
                'type' => 'jobs',
            ]);
            ?>
        </div>
        <div class="col-md-10">
            <div class="row side-body">
                <?=
                $this->render('/widgets/search-bar');
                ?>
                <div class="border-top-set col-md-12">
                    <div id="cardBlock" class="row work-load blogbox"></div>
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

                    <div class="btn-div2" align="center">
                        <a href="#" id="loadMore" class="ajax-paginate-link btn btn-border btn-more btn--primary load-more">
                        <span class="load-more-text">Load More</span>
                        <svg class="load-more-spinner" viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                        <g fill="none" fill-rule="evenodd">
                        <g transform="translate(1 1)" stroke-width="2">
                        <circle cx="8.90684" cy="50" r="5">
                        <animate attributeName="cy" begin="0s" dur="2.2s" values="50;5;50;50" calcMode="linear" repeatCount="indefinite"></animate>
                        <animate attributeName="cx" begin="0s" dur="2.2s" values="5;27;49;5" calcMode="linear" repeatCount="indefinite"></animate>
                        </circle>
                        <circle cx="25.0466" cy="8.99563" r="5">
                        <animate attributeName="cy" begin="0s" dur="2.2s" from="5" to="5" values="5;50;50;5" calcMode="linear" repeatCount="indefinite"></animate>
                        <animate attributeName="cx" begin="0s" dur="2.2s" from="27" to="27" values="27;49;5;27" calcMode="linear" repeatCount="indefinite"></animate>
                        </circle>
                        <circle cx="47.0466" cy="46.0044" r="5">
                        <animate attributeName="cy" begin="0s" dur="2.2s" values="50;50;5;50" calcMode="linear" repeatCount="indefinite"></animate>
                        <animate attributeName="cx" from="49" to="49" begin="0s" dur="2.2s" values="49;5;27;49" calcMode="linear" repeatCount="indefinite"></animate>
                        </circle>
                        </g>
                        </g>
                        </svg>
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
        
function GetURLParameter(sParam){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++){
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam){
            return sParameterName[1];
        }
    }
}
var para = GetURLParameter('r');

var pagenum = 0;
$(document).ready(function () {
    $.ajax({
        method: "GET",
        url : "/jobs/job-list-related?r="+ para +"&&pagenum="+pagenum,
        beforeSend: function(){
            $('.loader-main').show();
            $('.load-more-text').css('visibility', 'hidden');
            $('.load-more-spinner').css('visibility', 'visible');
        },
        success: function(response) {
//        console.log("response",response);
            $('.loader-main').hide();
            $('.load-more-text').css('visibility', 'visible');
            $('.load-more-spinner').css('visibility', 'hidden');
            if(response.status == 200) {
                jobcards(response);
                
            } else {
                $('#loadMore').hide();
            }
        }
    }).done(function(){
        $.each($('.application-card-main'), function(){
            $(this).draggable({
                helper: "clone",
            });
        });
    });
        
    
});
   
function jobcards(response){
    if(response.status == 200){    
                var card = $('#application-card').html();
                $(".blogbox").append(Mustache.render(card, response.jobcards));
    }else{
        console.log("not work");
    }
}        
        
$('#loadMore').on('click', function(e){
    e.preventDefault();
    pagenum+=1;
    $.ajax({
        method: "GET",
        url : "/jobs/job-list-related?r="+ para +"pagenum="+pagenum,
        beforeSend: function(){
           $('.loader-main').show();
            $('.load-more-text').css('visibility', 'hidden');
            $('.load-more-spinner').css('visibility', 'visible');
        },
        success: function(response) {
            $('.loader-main').hide();
            $('.load-more-text').css('visibility', 'visible');
            $('.load-more-spinner').css('visibility', 'hidden');
            if(response.status == 200) {
                jobcards(response);
            } else {
                $('#loadMore').hide();
            }
        }
    }).done(function(){
        $.each($('.application-card-main'), function(){
            $(this).draggable({
                helper: "clone",
            });
        });
    });
});

$('#review-internships').scroll(function(){
    if($(this).scrollTop() + $(this).height() >= $(window).height()){
        sidebarpage+=2;
        $.ajax({
            method: "GET",
            url : "/jobs/review-list?sidebarpage="+sidebarpage,
            beforeSend: function(){
                $('.side-loader').show();
            },
            success: function(response) {
                $('.side-loader').hide();
                reviewlists(response);
            }
        });
    }
});
        

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
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<script id="application-card" type="text/template">
    {{#.}}
    <div class="col-md-4 pt-5">
    <div data-key="{{id}}" class="application-card-main">
    <span class="application-card-type">{{type}}</span>
    <div class="col-md-12 application-card-border-bottom">
    <div class="application-card-img">
    <a href="/company/{{organization_link}}"><img src="{{logo}}"></a>
    </div>
    <div class="application-card-description">
    <h4 class="application-title">{{title}}</h4>
    <h5 class="location"><i class="fa fa-map-marker"></i>&nbsp;{{city}}</h5>
    <h5> <i class="fa fa-clock-o"></i>&nbsp;{{experience}}</h5>
    </div>
    </div>
    <div class="col-md-offset-3 col-md-9 text-center">
    <h4 class="org_name">{{org_name}}</h4>
    </div>
    <div class="application-card-wrapper">
    <a href="/job/{{slug}}" class="application-card-open">View Detail</a>
    <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
    </div>
    </div>
    </div>
    {{/.}}
</script>

<script id="application-card1" type="text/template">
    {{#.}}
    <div class="col-md-4 pt-5">
    <div data-key="{{id}}" class="product shadow iconbox-border iconbox-theme-colored">
    <span class="tag-sale color-o pl-20 pr-20 ">{{type}}</span>
    <div class="row">
    <div class="col-md-4 col-xs-4 pt-5">
    <a href="{{organization_link}}" class="icon set_logo">
    <img src="{{logo}}">
    </a>
    </div>
    <div class="col-md-8 col-xs-8 pt-20">
    <h4 class="icon-box-title">
    <strong>{{title}}</strong>
    </h4>
    <h5>
    <i class="fa fa-location-arrow"></i>
    <strong>{{city}}</strong>
    </h5>
    <h5>
    <i class="fa fa-map-pin">{{experience}}</i>
    </h5>
    </div>
    <div class="btn-add-to-cart-wrapper">
    <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/job/{{slug}}">VIEW DETAILS</a>
    <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
    <i class="fa fa-plus"></i>
    </a>
    </div>
    </div>
    <hr class="hr">
    <div class="row">
    <div class="col-md-12">
    <h4 class="pull-right pr-10 pt-10 custom_set" align="right">
    <p>
    <strong>{{org_name}}</strong>
    </p>
    </h4>
    </div>
    </div>
    </div>
    </div>
    {{/.}}
</script>
