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
                            <div class="main-tagline">Company's most valuable assets is its employees</div>
                            <div class="main-text">Showcase Your Profile, Create your Brand, Find Empowered Candidates &
                                Save Time On Hiring Candidates.</div>
                            <div class="main-text2">Increase Your Efficiency & Effectiveness.</div>
                            <div class="main-bttn">
                                <a href="/signup/organization" class="button2">Create internship
                                    <span><i class="fa fa-arrow-right" aria-hidden="true"></i></span> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="padd-bottom-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="how-heading animatable fadeIn">
                        <div class="heading-style">How It Works</div>
                        <div class="how-sub-text">
                            <span class="how-icon"><img src="<?= Url::to('@eyAssets/images/pages/index2/ey.png')?>"></span>
                            <h3>Create an Empower Youth account </h3>
                            <p>Create your company profile, tell people about your business. In which industry you deal in.</p>
                        </div>
                    </div>
                    <!-- Heading -->
                    <div class="how-to-sec">
                        <div class="how-to animatable fadeIn">
                            <span class="how-icon"><i class="fa fa-briefcase"></i></span>
                            <h3>Create and Post Internships</h3>
                            <p>Create a Internship, get applications, let candidates fill Questionnaire.
                                Ask them what's relevant to your organization.</p>
                        </div>
                        <div class="how-to animatable fadeIn">
                            <span class="how-icon"><i class="fa fa-users"></i></span>
                            <h3>Compare Applicants</h3>
                            <p>Compare different applicants on the basis of their skills, suitability, location,
                                experience, expected salary, etc. </p>
                        </div>
                        <div class="how-to animatable fadeIn">
                            <span class="how-icon"><i class="fa fa-user"></i></span>
                            <h3>Hire relevant candidate</h3>
                            <p>Use the Empower Youth platform for selecting, interviewing and hiring top applicants
                                from your desktop or on the go.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="row sol-bg-heading ">
            <div class="container">
                <div class="col-md-12">
                    <div class="heading-style">Solutions</div>
                </div>
            </div>
        </div>
        <div class="how-section1">
            <div class="row sol-bg">
                <div class="container">
                    <div class="col-md-4 col-md-offset-1 how-img" data-aos="flip-left">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/easy-working-process.png')?>" class="rounded-circle img-fluid" alt=""/>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <h4>Easy Working Process</h4>
                        <p class="text-justify">Empower Youth gives you best of its alternatives and smooth working
                            procedure so as to make it best of your encounters at procuring. Directions
                            given are easy to follow and understand.</p>
                    </div>
                </div>
            </div>
            <div class="row sol">
                <div class="col-md-6 col-md-offset-1" data-aos="fade-right">
                    <h4>Easy Job Posting</h4>
                    <p class="text-justify">A stage that gives simple employment posting steps and assortment of choices for simple contracting. No restrictions to a specific occupation stream, open about any employment progressive system and gauges of working.</p>
                </div>
                <div class="col-md-4 how-img"data-aos="flip-left">
                    <img src="<?= Url::to('@eyAssets/images/pages/index2/easy-job-posting.png')?>" class="rounded-circle img-fluid" alt=""/>
                </div>
            </div>
            <div class="row sol-bg">
                <div class="col-md-4 col-md-offset-1 how-img" data-aos="flip-left">
                    <img src="<?= Url::to('@eyAssets/images/pages/index2/keep-tracking.png')?>" class="rounded-circle img-fluid" alt=""/>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <h4>Keep track of every Application</h4>
                    <p class="text-justify">Monitoring each activity effectively is currently conceivable with Empower
                        Youth . It essentially keeps you refreshed of each activity the candidate is upto likewise
                        uncovering his/her interest level and interview stage .</p>
                </div>
            </div>
            <div class="row sol">
                <div class="col-md-6 col-md-offset-1" data-aos="fade-right">
                    <h4>Quick Hiring</h4>
                    <p class="text-justify">This stage empowers you procure the intrigued candidates and give you finish information about their capabilities
                        making it less demanding for you to contract.</p>
                </div>
                <div class="col-md-4 how-img" data-aos="flip-left">
                    <img src="<?= Url::to('@eyAssets/images/pages/index2/quick-hiring.png')?>" class="rounded-circle img-fluid" alt=""/>
                </div>
            </div>
        </div>
    </section>
<?php

$this->registerCss('
.header{
    background:url(' . Url::to('@eyAssets/images/pages/index2/com-intern-bg.png') . ');
    background-size:cover;
    background-repeat:no-repeat;
    background-attachment: fixed;
    color:#000;
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
    font-weight:bold;
    font-size:30px;
}
.main-bttn{
    margin-top:20px;
}
.button2{
    border:2px solid #000;
    padding:8px 10px;
    color:#000;
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
    color:#000;
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
/* How to Sec */
.how-to-sec {
    float: left;
    width: 100%;
    margin-top: 0px;
    display: table;
    padding
}
.how-sub-text{
    text-align:center;
}
.how-sub-text h3{
     width: 100%;
    font-family: Open Sans;
    font-size: 18px;
    color: #121212;
    text-transform:capitalize;
    margin: 0;
    margin-top: 10px;
}
.how-sub-text p{
    width: 100%;
    margin: 0;
    font-family: Open Sans;
    font-size: 13px;
    color: #888888;
    line-height: 0px;
    margin-top: 14px;
    padding-bottom:50px;
}
.
.how-heading{
    padding-bottom:20px;
}
.how-icon {
    float: none;
    display: inline-block;
    width: 100px;
    height: 100px;
    border: 2px dashed;
    
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    
    position:relative;
    font-size: 53px;
    text-align: center;
    color: #ff7803;
    border-color: #ff7803;
}
.how-icon img, .how-icon i{
    max-width:70px;
    position:absolute;
    top:50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    -ms-transform: translate(-50%);
    transform: translate(-50%, -50%);
}
.how-to h3 {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 18px;
    color: #121212;
    text-transform:capitalize;
    margin: 0;
    margin-top: 10px;
}
.how-to p {
    float: left;
    width: 100%;
    margin: 0;
    font-family: Open Sans;
    font-size: 13px;
    color: #888888;
    line-height: 24px;
    margin-top: 14px;
}
.how-to {
    float: left;
    width: 33.334%;
    text-align: center;
    position: relative;
}
.how-to::before {
    position: absolute;
    left: 50%;
    top: 60px;
    width: 270px;
    height: 36px;
    background:(' . Url::to('@eyAssets/images/pages/company-index/line1.png') . ');
    content: "";
    z-index: 1;
    margin-left: 61px;
}
.how-to:nth-child(n+2)::before {
    (' . Url::to('@eyAssets/images/pages/company-index/line2.png') . ');
    top: 13px;
}
.how-to:last-child::before {
    display: none;
}
.how-to:nth-child(2n+2) {
    padding: 0 50px;
}
/*how it works ends*/
/*-------------------------*/
/*Solutions*/
.sol-bg{
    background:#ecf5fe;
    padding: 20px 0;
}
.sol-bg-heading{
    background:#ecf5fe;
    padding: 20px 0 0;
}
.sol{
    padding:20px 0;
}
//.how-section1{
//    margin-top:-8%;
//    padding: 2%;
//}
.how-section1 h4{
    color: #ff7803;
//    font-weight: bold;
    font-size: 30px;
    padding-top:50px;
    font-family:lobster;
}
.how-section1 .subheading{
    color: #5774b8;
    font-size: 20px;
}
.how-section1 .row{
    margin-top: 5% 0%;
}
.how-img {
    text-align: center;
    line-height:15;
}
.how-img img{
    max-width: 250px;
}
.padd-bottom-20{
    padding-bottom:30px;
}
/*--------------*/
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
		opacity: 0.5;
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
        20%{
                opacity: .5;
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
        
AOS.init({
    easing: 'ease-out-back',
    duration: 1000
});
        
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/aoa.css');
$this->registerJsFile('@eyAssets/js/aoa.js');