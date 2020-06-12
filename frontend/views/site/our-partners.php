<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;
?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="our-part">Our Partners</h3>
                </div>
                <div id="side-bar-main" class="col-md-3">
                    <div class="search-main">
                        <h3>Find an Integration</h3>
                        <div class="search-b">
                            <input type="search" placeholder="Search by Name" class="form-control">
                        </div>
                        <div class="p-listing">
                            <ul>
                                <li>
                                    <a href="#jobs" class="scroll-to-sec">Jobs Integration</a>
                                </li>
                                <li>
                                    <a href="#training" class="scroll-to-sec">courses integration</a>
                                </li>
                                <li>
                                    <a href="#blogs" class="scroll-to-sec">Blogs integration</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="integration-main" class="col-md-8 col-md-offset-1">
                    <div class="cont-main row">
                        <div class="col-md-12">
                            <h3 id="jobs">Jobs Integration</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-partners/github.png') ?>"/>
                                <h2>github</h2>
                                <p>GitHub is built for collaboration. Set up an organization to improve the way your
                                    team works together, and get access to more features.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-partners/themuse.jpg') ?>"/>
                                <h2>muse</h2>
                                <p>Find everything you need to succeed from dream jobs to career advice.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-partners/themuse.jpg') ?>"/>
                                <h2>Careerjet</h2>
                                <p>Careerjet is an employment search engine. In just one search access 19,277,026 jobs published on 49,057 websites in the world.</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h3 id="training">courses integration</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-partners/udemy.jpg') ?>"/>
                                <h2>Udemy</h2>
                                <p>Udemy is the world’s largest selection of courses Choose from over 100,000 online video courses with new additions published every month.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-partners/udacity.jpg') ?>"/>
                                <h2>udacity</h2>
                                <p>Udacity is the world’s fastest, most efficient way to master the skills tech companies want. 100% online, part-time & self-paced.</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h3 id="blogs">Blogs integration</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/nslider-image1.jpg') ?>"/>
                                <h2>github</h2>
                                <p>GitHub is built for collaboration. Set up an organization to improve the way your
                                    team works together, and get access to more features. </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/nslider-image1.jpg') ?>"/>
                                <h2>github</h2>
                                <p>GitHub is built for collaboration. Set up an organization to improve the way your
                                    team works together, and get access to more features. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registercss('
.our-part {
	font-family: lora;
	font-size: 55px;
}
.form-control {
    border-radius: 8px;
}
.search-main{
    position:sticky;
    top:100px;
}
.p-listing {
	padding: 15px 5px;
}
.p-listing ul li {
	font-size: 18px;
	text-transform: capitalize;
	margin-bottom: 8px;
	font-family: roboto;
	font-weight: ;
}
.cont-main h3 {
	font-size: 35px;
	font-family: lora;
	text-transform: capitalize;
	margin-bottom:20px;
}
.box {
	box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
	border-radius: 6px;
	padding-bottom: 10px;
	overflow:hidden;
	margin-bottom:20px;
	height:380px;
}

.box img {
    min-height: 200px;
    object-fit: cover;
    height:200px;
    width:100%;
}
.box h2{
	font-size: 25px;
	margin: 10px 0 0 15px;
	text-transform: capitalize;
	font-family: lora;
}
.box p {
	margin: 10px 15px 5px;
	font-size: 16px;
	font-family: roboto;
	text-transform: capitalize;
	text-align: justify;
	display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
');
$script = <<<JS
function initializePosSticky() {
  var mainHeight = $('#integration-main').height();
  $('#side-bar-main').css('height',mainHeight);
}
initializePosSticky();
$(document).on('click', '.scroll-to-sec', function(e) {
    e.preventDefault();
    var sectionId = $(this).attr('href');
    var offsetHeight = $(sectionId).offset().top - 90 ;
    $('html, body').animate({scrollTop: offsetHeight}, 600);
});
JS;
$this->registerJs($script);
