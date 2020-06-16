<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;
?>
<section class="our-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="our-heading">
                    <h3>Our Partners</h3>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
    </div>
</section>
    <section>
        <div class="container">
            <div class="row">
                <div id="side-bar-main" class="col-md-3">
                    <div class="search-main">
                        <h3>Find an Integration</h3>
                        <div class="search-b">
                            <input type="text" id="searchForm" placeholder="Search by Name" class="form-control" onkeyup="search()">
                        </div>
                        <div class="p-listing">
                            <ul>
                                <li>
                                    <a href="#jobs" class="scroll-to-sec">Jobs Integration</a>
                                </li>
                                <li>
                                    <a href="#training" class="scroll-to-sec">courses integration</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="integration-main" class="col-md-8 col-md-offset-1">
                    <div class="cont-main row">
                        <div class="col-md-12">
                            <h3 id="jobs" class="heading-style">Jobs Integration</h3>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-partners/github.png') ?>"/>
                                <h2><a href="https://github.com/">github</a></h2>
                                <p>GitHub is built for collaboration. Set up an organization to improve the way your
                                    team works together, and get access to more features.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-partners/the-muse.png') ?>"/>
                                <h2><a href="https://www.themuse.com/">themuse</a></h2>
                                <p>Find everything you need to succeed from dream jobs to career advice.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-partners/careerjet2.png') ?>"/>
                                <h2><a href="https://www.careerjet.co.in/">Careerjet</a></h2>
                                <p>Careerjet is an employment search engine. In just one search access 19,277,026 jobs published on 49,057 websites in the world.</p>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <h3 id="training" class="heading-style">courses integration</h3>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="jobs-main box" id="udemy">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-partners/udemy.png') ?>"/>
                                <h2 class="provider"><a href="https://www.udemy.com/">Udemy</a></h2>
                                <p>Udemy is the world’s largest selection of courses Choose from over 100,000 online video courses with new additions published every month.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="jobs-main box">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-partners/udacity1.png') ?>"/>
                                <h2 class="provider"><a href="https://www.udacity.com/">udacity</a></h2>
                                <p>Udacity is the world’s fastest, most efficient way to master the skills tech companies want. 100% online, part-time & self-paced.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registercss('
.our-bg{
    background:url(' . Url::to('@eyAssets/images/pages/our-partners/our-partner.png') . ');
    min-height: 380px;
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center; 
}
.our-heading h3 {
	font-size: 55px;
	font-family: lora;
	margin-top: 110px;
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
}
.p-listing ul li a:hover {color:#00a0e3;}
.cont-main h3 {
	text-transform: capitalize;
	margin-bottom:20px;
}
.box {
	box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
	border-radius: 6px;
	padding-bottom: 10px;
	overflow:hidden;
	margin-bottom:20px;
	height:390px;
}

.box img {
    min-height: 200px;
    object-fit: cover;
    height:200px;
    width:100%;
    border-bottom:1px solid #eee; 
}
.box h2 a{
	font-size: 25px;
	margin: 10px 0 0 15px;
	text-transform: capitalize;
	font-family: lora;
	color:#00a0e3;
}
.box p {
	margin: 5px 15px 5px;
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
?>
<script>
    function search() {

        var name = document.getElementById("searchForm").value;
        var pattern = name.toLowerCase();
        var targetId = "";

        var divs = document.getElementsByClassName("jobs-main");
        for (var i = 0; i < divs.length; i++) {
            var para = divs[i].getElementsByTagName("h2");
            var index = para[0].innerText.toLowerCase().indexOf(pattern);
            if (index != -1) {
                targetId = divs[i].parentNode;
                    targetId.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // document.getElementById(targetId).scrollIntoView();
                break;
            }
        }
    }
</script>
