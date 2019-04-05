<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = false;
?>
    <section class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="header-content">
                        <div class="vertically-center">
                            <div class="main-tagline">Want to attract top talent ?</div>
                            <div class="main-text">Showcase Your Profile, Create your Brand, Find Empowered Candidates &
                                Save Time On Hiring Candidates.</div>
                            <div class="main-text2"> <span>Increase Your Efficiency & Effectiveness.</span></div>
                            <div class="main-bttn">
                                <a href="/signup/organization" class="button2">Create Account
                                <span><i class="fa fa-arrow-right"></i></span> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="how-it-works">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">How it works</div>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class="step-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/identity.png') ?>">
                        </div>
                        <div class="step-heading">Show your true identity</div>
                        <div class="step-dis">Attract top talent by showing who you really are with a powerful
                            employer branding campaign.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/save-time.png') ?>">
                    </div>
                    <div class="step-heading">save time on recruitment</div>
                    <div class="step-dis">Make the most of our collaboration platform and
                        interview only qualified, culture-fit candidates.</div>
                </div>
                <div class="col-md-4">
                    <div class="step-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/hired.png') ?>">
                    </div>
                    <div class="step-heading">Recruit top talent</div>
                    <div class="step-dis">Get on board fully engaged employees and boost
                        your retention rates </div>
                </div>
            </div>
        </div>
    </section>
    <section class="companies">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="com-grid">
                        <div class="heading-style">Companies With Us</div>
                        <div class="">Companies recruiting top talent from our portal.</div>
                        <div class="com1 animatable fadeIn">
                            <div class="com-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/capital-small-bank.jpg') ?>">
                            </div>
                            <div class="com-name">
                                Capital Small Finance Bank
                            </div>
                        </div>
                        <div class="com2 animatable fadeIn">
                            <div class="com-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/midland.png') ?>">
                            </div>
                            <div class="com-name">
                                Midland MicroFin
                            </div>
                        </div>
                        <div class="com3 animatable fadeIn">
                            <div class="com-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/dsb.png') ?>">
                            </div>
                            <div class="com-name">
                                DSB Law Group
                            </div>
                        </div>
                        <div class="com4 animatable fadeIn">
                            <div class="com-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/hag.png') ?>">
                            </div>
                            <div class="com-name">
                                HAG India
                            </div>
                        </div>
                        <div class="com5 animatable fadeIn">
                            <div class="com-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>">
                            </div>
                            <div class="com-name">
                                Agile Finserv
                            </div>
                        </div>
                        <div class="com6 animatable fadeIn">
                            <div class="com-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/olready.png') ?>">
                            </div>
                            <div class="com-name">
                                Olready
                            </div>
                        </div>
                        <!--                    <div class="com7 animatable fadeIn">
                                                <div class="com-logo">
                                                    <img src="">
                                                </div>
                                                <div class="com-name">
                                                    Empower youth
                                                </div>
                                            </div>-->
                        <div class="com8 animatable fadeIn">
                            <div class="com-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/ey.svg') ?>">
                            </div>
                            <div class="com-name">
                                Empower youth
                            </div>
                        </div>
                        <div class="com9 animatable fadeIn">
                            <div class="com-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/hamco.png') ?>">
                            </div>
                            <div class="com-name">
                                Hamco Ispat
                            </div>
                        </div>
                        <div class="com10 animatable fadeIn">
                            <div class="com-logo">
                                <img src="<?= Url::to('@commonAssets/logos/text-logo.png') ?>">
                            </div>
                            <div class="com-name">
                                Empower youth
                            </div>
                        </div>
                        <div class="com11 animatable fadeIn">
                            <div class="com-logo">
                                <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                            </div>
                            <div class="com-name">
                                Empower youth
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="bluebg"></div>
<?php
$this->registerCss('
.step-heading{
    text-transform:Uppercase;
    text-align:center;
    font-size:18px;
    padding-top:10px;
    color:#00a0e3;
} 
.step-icon{
    text-align:center;
}
.step-icon img{
    max-width:150px;
    max-height:150px;
}
.step-dis{
    padding:5px 20px;
    text-align:center;
}
.bluebg{
    background:#ecf5fe;
    height:50px;
}    
.header{
    background:url(' . Url::to('@eyAssets/images/pages/index2/company-index-bg.png') . ');
    background-repeat:no-repeat; 
    background-size:cover;
}
.header-content{
    height:400px;
}
.vertically-center{
    position: relative;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}
.main-tagline{
    color:#fff;
    font-family:lobster;
    font-size:40px;
}
.main-text{
    color:#fff;
    font-size:17px;
    max-width:600px;
    line-height:27px;
}
.main-text2{ 
    color:#fff;
    font-size:17px;
    line-height:27px;
}
.main-text2 span{
    padding:0 5px;
   background:#000; 
}
.main-bttn{
    padding-top:20px;
}
.button2{
    border:2px solid #fff;
    padding:8px 10px;
    color:#fff;
    text-transform:uppercase;
    font-weight:bold;
    display: inline-block;
    text-align: center;
    cursor: pointer;
    position:relative;
}
.button2 span{
    position:absolute;
    opacity:0;
    right: 5px;
    top:7px;
}
.button2:hover{
    color:#fff;
    padding-right:30px;   
}
.button2:hover span{
    opacity:1;
   right:10px;
   
}
.button2, .button2 span, .button2:hover {
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -ms-transition:.3s all;
    -o-transition:.3s all;
    transition:.3s all;
} 
.how-it-works{
    padding:10px 0 30px;
}
.companies{
    margin-top:20px;
    position:relative;
    background:#ecf5fe;
    padding:0 0 50px 0;
}
.com-grid{
    text-transform:capitalize;
    min-height:400px;
    position:relative;
}
.com-logo{
    width:100px;
    height:100px;
    background:#fff;
    border-radius:50%;
    box-shadow: 8px 13px 30px 5px rgba(162, 153, 153, 0.1);
    padding: 18px !important; 
    line-height:0px;
}
.com-name{ 
    padding-top:8px;
    font-size:15px;
    display:none;
    line-height:20px;
    max-width:109px;
    font-weight:bold;
    text-align:center;
//    font-style: oblique;
}
.com-logo:hover ~ .com-name{
    display:block;
}
.com-logo img{
    max-width:100%;
    max-height:100%;
    position: relative;
    top:50%;
    left:50%;
    -webkit-transform: translate(-50%, -50%); 
    transform: translate(-50%, -50%);    
}
.com1, .com2, .com3, .com4, .com5, .com6, .com7, .com8, .com9, .com10, .com11{
      position:absolute;
}
.com1{
   top: -23px;
    left: 51%;
}
.com5{
    top: 1%;
    left: 84%;;
}
.com2{
   top: 31%;
    left: 40%;
}
.com3{
    top:21%;
    left:65%;
}
.com4{
   top: 42%;
    left: 81%;
}
.com6{
    top: 55%;
    left: 18%;
} 
.com7{
    top: 55%;
    left: 24%;
}
.com8{
   top: 63%;
   left: 51%;
}
.com9{
    top: 83%;
    left: 69%;
}
.com10{
    top: 78%;
    left: 90%;
}
.com11{
    top: 84%;
    left: 32%;
}
.footer{
    margin-top:0px !important;
}
/*animate css */
.animated.fadeIn {
	-webkit-animation-name: fadeIn;
	-moz-animation-name: fadeIn;
	-o-animation-name: fadeIn;
	animation-name: fadeIn;
}
.animatable {
  
  /* initially hide animatable objects */
  visibility: hidden;
  
  /* initially pause animatable objects their animations */
  -webkit-animation-play-state: paused;   
  -moz-animation-play-state: paused;     
  -ms-animation-play-state: paused;
  -o-animation-play-state: paused;   
  animation-play-state: paused; 
}

/* show objects being animated */
.animated {
  visibility: visible;
  
  -webkit-animation-fill-mode: both;
  -moz-animation-fill-mode: both;
  -ms-animation-fill-mode: both;
  -o-animation-fill-mode: both;
  animation-fill-mode: both;
  
  -webkit-animation-duration: 4s;
  -moz-animation-duration: 4s;
  -ms-animation-duration: 4s;
  -o-animation-duration: 4s;
  animation-duration: 4s;

  -webkit-animation-play-state: running;
  -moz-animation-play-state: running;
  -ms-animation-play-state: running;
  -o-animation-play-state: running;
  animation-play-state: running;
}
@-webkit-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0.3;
	}
        60%{
                opacity: 0.6;
        }
	100% {
		opacity: 1;
	}
}

@-moz-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0.5;
	}
	100% {
		opacity: 1;
	}
}

@-o-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: 0.5;
	}
	100% {
		opacity: 1;
	}
}

@keyframes fadeIn {
	0% {
		opacity: 0;
	}
	20% {
		opacity: .3;
	}
	60% {
		opacity: .6;
	}
	100% {
		opacity: 1;
	}
}
');
$script = <<< JS
 jQuery(function($) {
  var doAnimations = function() {
    var offset = $(window).scrollTop() + $(window).height(), animatables = $('.animatable');
    if (animatables.length == 0) {
      $(window).off('scroll', doAnimations);
    }
		animatables.each(function(i) {
       var animatable = $(this);
			if ((animatable.offset().top + animatable.height() - 20) < offset) {
        animatable.removeClass('animatable').addClass('animated');
	}
      });
    };
    $(window).on('scroll', doAnimations);
  $(window).trigger('scroll'); 
});   
JS;
$this->registerJs($script);
