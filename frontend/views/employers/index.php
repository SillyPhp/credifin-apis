<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['header_dark'] = false;
?>
    <section class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="header-content">
                        <!--                        <div class="vertically-center">-->
                        <!--                            <div class="main-tagline">Want to attract top talent ?</div>-->
                        <!--                            <div class="main-text">Showcase Your Profile, Create your Brand, Find Empowered Candidates &-->
                        <!--                                Save Time On Hiring Candidates.-->
                        <!--                            </div>-->
                        <!--                            <div class="main-text"><span>Increase Your Efficiency & Effectiveness.</span></div>-->
                        <!--                            <div class="main-bttn">-->
                        <!--                                <a href="/signup/organization" class="button2">Create Account-->
                        <!--                                    <span><i class="fas fa-arrow-right"></i></span> </a>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
if (Yii::$app->user->isGuest) {
    echo $this->render('/widgets/sign-in-form', [
        'loginFormModel' => $loginFormModel,
    ]);
} ?>

    <!--    <section class="showcase">-->
    <!--        <div class="container">-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-12">-->
    <!--                    <div class="showcase-heading">-->
    <!--                        <span>Showcase Your employer brand</span>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                </div>-->
    <!--                <div class="row">-->
    <!--                <div class="showcase-subparts">-->
    <!--                    <div class="col-md-4">-->
    <!--                        <div class="showcase-icon">-->
    <!--                            <img src="--><? //= Url::to('@eyAssets/images/pages/index2/create-profile.png')?><!--">-->
    <!--                        </div>-->
    <!--                        <div class="showcase-title"><span>Create Company Profile</span></div>-->
    <!--                    </div>-->
    <!--                    <div class="col-md-4">-->
    <!--                        <div class="showcase-icon">-->
    <!--                            <img src="--><? //= Url::to('@eyAssets/images/pages/index2/hiring.png')?><!--">-->
    <!--                        </div>-->
    <!--                        <div class="showcase-title"><span>Hiring Posters</span></div>-->
    <!--                    </div>-->
    <!--                    <div class="col-md-4">-->
    <!--                        <div class="showcase-icon">-->
    <!--                            <img src="--><? //= Url::to('@eyAssets/images/pages/index2/responsive.png')?><!--">-->
    <!--                        </div>-->
    <!--                        <div class="showcase-title"><span>Responsiveness to Candidates</span></div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <section class="hwn">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Find Your Star Employee</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <div class="hwn-box">
                        <div class="hwn-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/how-it-works11.png') ?>">
                        </div>
                        <div class="hwn-title">Create a free account</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="hwn-box">
                        <div class="hwn-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/how-it-works22.png') ?>">
                        </div>
                        <div class="hwn-title">Add a position</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="hwn-box">
                        <div class="hwn-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/how-it-works33.png') ?>">
                        </div>
                        <div class="hwn-title">Get applications</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="hwn-box">
                        <div class="hwn-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/how-it-works44.png') ?>">
                        </div>
                        <div class="hwn-title">Hire your star employee</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
        echo $this->render('/widgets/e-campus')
    ?>

    <section class="great-bg">
        <div class="container">
            <div class="row">
                <div class="head-about">
                    <h3>What's Great About Us?</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <a href="/candidates/features">
                        <div class="about-box">
                            <div class="bx-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/Efficiency.png') ?>">
                            </div>
                            <h4>Enhance your Efficiency and Effectiveness</h4>
                            <div class="about-text">Receive multiple offers from top-level organizations and properly
                                recruited for joining an organization.
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="/candidates/features">
                        <div class="about-box">
                            <div class="bx-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/showcase-progress.png') ?>">
                            </div>
                            <h4>Showcase Your Employer Brand</h4>
                            <div class="about-text">Showcasing our unique cultural differentiators, and then working to
                                amplify it so you can position yourself as a top place to work.
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="/candidates/features">
                        <div class="about-box">
                            <div class="bx-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/track-progress.png') ?>">
                            </div>
                            <h4>Track Progress</h4>
                            <div class="about-text">Track your application process in simple steps & stay up-to-date.
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="/candidates/features">
                        <div class="about-box">
                            <div class="bx-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/free4all.png') ?>">
                            </div>
                            <h4>Free For All</h4>
                            <div class="about-text">You can apply for jobs and have your learning courses without giving
                                any
                                penny.
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="/candidates/features">
                        <div class="about-box">
                            <div class="bx-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/live-interview.png') ?>">
                            </div>
                            <h4>Live Interview Schedule</h4>
                            <div class="about-text">Automates scheduling of live interactions between interviewer and
                                interview.
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6">
                    <a href="/candidates/features">
                        <div class="about-box">
                            <div class="bx-img">
                                <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/livechat.png') ?>">
                            </div>
                            <h4>Live Chat</h4>
                            <div class="about-text">You can easily live chat with our Employers to get help & for more
                                other
                                queries.
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="great-red">
                <a href="/candidates/features">View All Features</a>
            </div>
        </div>
    </section>
    <section class="fixed-bttn">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="fx-heading">
                        its free to hire from empower youth
                    </div>
                    <div class="post-job-bttn">
                        <a href="/account/dashboard" id="myBttn" class="hvr-float-shadow">
                            Post Now
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fx-heading">
                        Find right candidate for your job
                    </div>
                    <div class="post-job-bttn">
                        <a href="/candidates" id="myBttn" class="hvr-float-shadow">
                            View Candidates
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <?= $this->render('/widgets/ai-quick-jobs'); ?>
    </section>

    <Section class="information">
        <div class="box-parent row">
            <div class="bolls">
                <div class="boll1 bol2"></div>
                <div class="boll2 bol2"></div>
                <div class="boll3 bol"></div>
                <div class="boll4 bol"></div>
                <div class="boll5 bol2"></div>
                <div class="boll6 bol2"></div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="jobs-content">
                    <div class="j-count">50 +</div>
                    <div class="j-name">Colleges</div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="jobs-content">
                    <div class="j-count">10k +</div>
                    <div class="j-name">Freshers</div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="jobs-content">
                    <div class="j-count">5k +</div>
                    <div class="j-name">Job candidates</div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="jobs-content">
                    <div class="j-count">20k +</div>
                    <div class="j-name">Internship Candidates</div>
                </div>
            </div>
        </div>
    </Section>

    <section class="emp-back">
        <div class="container">
            <div class="row">
                <div class="emp-main">
                    <h3>Job candidates have reported that they trust employees 3x More<Span> than employers to provide information on working at a company</Span>
                    </h3>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <div class="set-size charts-container">
                                <div class="pie-wrapper progress-75 style-2">
                                    <span class="label">75<span class="smaller">%</span></span>
                                    <div class="pie">
                                        <div class="left-side half-circle"></div>
                                        <div class="right-side half-circle"></div>
                                    </div>
                                    <div class="shadow"></div>
                                </div>
                                <div class="emp-text">of job seekers consider a
                                    company's<span> employer brand before</span> even applying for a job
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="set-size charts-container">
                                <div class="pie-wrapper progress-75 style-2">
                                    <span class="label">69<span class="smaller">%</span></span>
                                    <div class="pie pie2">
                                        <div class="left-side half-circle"></div>
                                        <div class="right-side half-circle"></div>
                                    </div>
                                    <div class="shadow"></div>
                                </div>
                                <div class="emp-text">of job seekers will <span>not accept</span> a job with a company
                                    if that company has a <span>bad reputation</span></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="set-size charts-container">
                                <div class="pie-wrapper progress-75 style-2">
                                    <span class="label">80<span class="smaller">%</span></span>
                                    <div class="pie pie3">
                                        <div class="left-side half-circle"></div>
                                        <div class="right-side half-circle"></div>
                                    </div>
                                    <div class="shadow"></div>
                                </div>
                                <div class="emp-text">of job seekers rely on <span>social media</span> and company
                                    review sites as important <span>research resources</span> when looking for work
                                </div>
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
                    <h1 class="heading-style">How It Works</h1>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="">
                        <div class="step-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/identity.png') ?>">
                        </div>
                        <div class="step-heading">Show your true identity</div>
                        <div class="step-dis">Attract top talent by showing who you really are with a powerful
                            employer branding campaign.
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="step-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/save-time.png') ?>">
                    </div>
                    <div class="step-heading">save time on recruitment</div>
                    <div class="step-dis">Make the most of our collaboration platform and
                        interview only qualified, culture-fit candidates.
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="step-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/hired.png') ?>">
                    </div>
                    <div class="step-heading">Recruit top talent</div>
                    <div class="step-dis">Get on board fully engaged employees and boost
                        your retention rates
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->render('/widgets/companies-with-us'); ?>

<?= $this->render('/widgets/partner-with-us-and-feedback-form', [
    'feedbackFormModel' => $feedbackFormModel,
    'partnerWithUsModel' => $partnerWithUsModel,
]); ?>
    <!--    <div class="bluebg"></div>-->
<?php
$this->registerCss('
.box-parent {
    background:#ff7803;
    border-radius: 8px;
    padding: 90px 50px;
    overflow:hidden;
    margin: 20px;
}
.jobs-content {
    text-align: left;
    border-left: 4px solid #fff;
    padding-left: 20px;
}
.j-count{
    font-size:40px;
    color:#fff;
    font-weight: 700;
    font-family: roboto;
}
.j-name{
    font-size:25px;
    color:#fff;
    font-weight: 300;
    font-family: roboto;
}
@media (max-width:768px){
    .box-parent{padding:20px 50px !important;}
    .jobs-content{margin-bottom:10px;}
}
.bolls{position:relative;}
.bol{
    position: absolute;
    width: 85px;
    height: 85px;
    background: #ff8821;
    border-radius: 50%;
}
.bol2{
    position: absolute;
    width: 125px;
    height: 125px;
    background: #ff8821;
    border-radius: 50%;
}
.boll1 {
    top: -100px;
    left: -56px;
}
.boll2 {
    left: 171px;
    top: 164px;
}
.boll3 {
    left: 371px;
    top: -25px;
}
.boll4 {
    right: 1px;
    top: 76px;
}
.boll5 {
    right: 195px;
    top: 18px;
}
.boll6 {
    right: -69px;
    bottom: 12px;
}
@media (max-width:415px){
.boll5 {
    right: 159px;
    top: 305px;
}
.boll6 {
    left: 205px;
    top: 415px;
}
}

.emp-main {
    text-align:center;
    margin: 0px 0px 30px 0px;
}
.emp-main h3 {
    font-size: 30px;
    font-family: roboto;
    font-weight: 700;
    margin: 0;
    margin-bottom: 30px;
    padding:0px 105px;
}
.emp-main h3 span{
    font-weight: 400;
}
.emp-text {
    font-size: 16px;
    font-family: roboto;
    margin: 15px 0px;
    text-align: center;
}
.emp-text span {
    font-weight:700;
}
@media (max-width:768px){
.emp-main h3 {
    font-size: 23px;
    padding:0px 20px;
}
}
@media (max-width:415px){
.emp-main h3 {
    font-size: 20px;
    padding:0px 10px;
}
.set-size {
     margin-bottom: 20px;
}
}
.set-size {
  font-size: 10em;
}
.pie-wrapper {
  height: 1em;
  width: 1em;
  margin: 15px;
  position: relative;
}
.pie-wrapper:nth-child(3n + 1) {
  clear: both;
  margin:0 auto;
}
.pie-wrapper .pie {
  height: 100%;
  width: 100%;
  clip: rect(0, 1em, 1em, 0.5em);
  left: 0;
  position: absolute;
  top: 0;
}
.pie-wrapper .pie .half-circle {
  height: 100%;
  width: 100%;
  border: 0.1em solid #00a0e3;
  border-radius: 50%;
  clip: rect(0, 0.5em, 1em, 0);
  left: 0;
  position: absolute;
  top: 0;
}
.pie-wrapper .label {
  background: #34495e;
  border-radius: 50%;
  bottom: 0.4em;
  color: #ecf0f1;
  cursor: default;
  display: block;
  font-size: 0.25em;
  left: 0.4em;
  line-height: 2.8em;
  position: absolute;
  right: 0.4em;
  text-align: center;
  top: 0.4em;
}
.pie-wrapper .label .smaller {
  color: #00a0e3;
  font-size: .45em;
  vertical-align: bottom;
}
.pie-wrapper .shadow {
  height: 100%;
  width: 100%;
  border: 0.1em solid #eee;
  border-radius: 50%;
}
.pie-wrapper.style-2 .label {
  background: transparent;
  color: #00a0e3;
}
.pie-wrapper.style-2 .label .smaller {
  color: #00a0e3;
}
.pie-wrapper.progress-75 .pie {
  clip: rect(auto, auto, auto, auto);
}
.pie-wrapper.progress-75 .pie .half-circle {
  border-color: #00a0e3;
}
.pie-wrapper.progress-75 .pie .left-side {
  -webkit-transform: rotate(270deg);
          transform: rotate(270deg);
}
.pie-wrapper.progress-75 .pie .right-side {
  -webkit-transform: rotate(180deg);
          transform: rotate(180deg);
}
.pie-wrapper.progress-75 .pie2 .left-side {
  -webkit-transform: rotate(250deg);
          transform: rotate(250deg);
}
.pie-wrapper.progress-75 .pie2 .right-side {
  -webkit-transform: rotate(180deg);
          transform: rotate(180deg);
}
.pie-wrapper.progress-75 .pie3 .left-side {
  -webkit-transform: rotate(290deg);
          transform: rotate(290deg);
}
.pie-wrapper.progress-75 .pie3 .right-side {
  -webkit-transform: rotate(180deg);
          transform: rotate(180deg);
}
.hwn{
    text-align:center;
    padding:30px 0 50px;
}
.hwn-icon{
    max-width:150px;
    max-height:150px;
    margin:0 auto;
}
.hwn-icon img{
    width:100%;
    height:100%;
}
.hwn-title{
    margin-top:20px;
    font-size:20px;
    color:#00a0e3;
}
@media (max-width:768px){
.hwn-icon{
    max-width:120px;
}
.hwn-title{
    font-size:18px;
}
.step-dis{
    font-size:13px;
}
}
@media (max-width:767px){
.hwn-box{
    margin-bottom:30px;
}
}
/*showcase starts*/
.showcase{
    padding:80px 0 110px;
    background:url(' . Url::to('@eyAssets/images/pages/index2/showcase-bg.png') . '); 
    background-size: cover;
    background-repeat:no-repeat;
    background-attachment: fixed;
}
.showcase-heading{
    text-align:center;
}
.showcase-title{
    padding-top:20px;
    font-size:20px;
}
.showcase-title span{
    background:#000;
    color:#fff;
    padding:5px;
    
}
.showcase-icon img{ 
    max-width:250px;
}
.showcase-heading span{
    text-transform:capitalize;
    font-size:35px;
    text-align:center;
    padding:5px 15px;
    color:#fff;
    background:#000;
    font-family:lobster;

}
.showcase-subparts{
    text-align:center;
    padding-top:50px;
    color:#000;
    text-transform:capitalize;
}
/*showcase ends*/
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
    background:url(' . Url::to('@eyAssets/images/pages/index2/cover-img.png') . ');
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
.main-text span{
    background:#000;
    padding:2px 5px;
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
/**/
.how-it-works{
    padding:10px 0 30px;
     background:#ecf5fe;
}

.footer{
    margin-top:0px !important;
}

.fixed-bttn{
    padding:80px 0 110px;
    background:url(' . Url::to('@eyAssets/images/pages/index2/get-hired-bg.jpg') . '); 
    background-size: cover;
    background-repeat:no-repeat;
    background-attachment: fixed;
}
.fx-heading{
  text-transform:capitalize;
    font-size:35px;
    text-align:center;
    padding:0 0 20px 0;
    color:#666666;
    font-family:lobster;
}
.post-job-bttn{
    text-align:center;
}
.post-job-bttn a{
    background:#00a0e3;
    color:#fff;
    border-radius:5px;
    text-transform: uppercase;
    padding:10px 20px;
    font-size:18px;
    box-shadow:0 0 10px rgba(66, 63, 63, .5);
    -webkit-transition:.3s all;
   transition:.3s all;
   text-align:center;
   margin:0 auto;
   max-width:300px;
   display:block;
   font-weight:600;
}
.post-job-bttn a:hover{
   box-shadow:none;
   -webkit-transition:.3s all;
   transition:.3s all;
}
.hvr-float-shadow {
  vertical-align: middle;
  -webkit-transform: perspective(1px) translateZ(0);
  transform: perspective(1px) translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  position: relative;
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-property: transform;
  transition-property: transform;
}
.hvr-float-shadow:before {
  pointer-events: none;
  position: absolute;
  z-index: -1;
  content: \'\';
  top: 100%;
  left: 5%;
  height: 10px;
  width: 90%;
  opacity: 0;
  background: -webkit-radial-gradient(center, ellipse, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0) 80%);
  background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.35) 0%, rgba(0, 0, 0, 0) 80%);
  -webkit-transition-duration: 0.3s;
  transition-duration: 0.3s;
  -webkit-transition-property: transform, opacity;
  transition-property: transform, opacity;
}
.hvr-float-shadow:hover, .hvr-float-shadow:focus, .hvr-float-shadow:active {
  -webkit-transform: translateY(-5px);
  transform: translateY(-5px);
}
.hvr-float-shadow:hover:before, .hvr-float-shadow:focus:before, .hvr-float-shadow:active:before {
  opacity: 1;
  -webkit-transform: translateY(5px);
  transform: translateY(5px);
}
/*Whats Great About Us css starts */
.great-red{
    text-align: center;
    position: relative;
    max-width: 175px;
    margin: 0 auto;
    margin-top: 15px;
    margin-bottom: 10px;
}
.great-red a{
    background:#00a0e3;
    color:#fff;
    font-size: 16px;
    border-radius: 4px;
    transition: 0.6s;
    overflow: hidden;
    padding: 10px 22px;
}
.great-red a:before {
  content: "";
  display: block;
  position: absolute;
  background: rgba(255, 255, 255, 0.5);
  width: 60px;
  height: 100%;
  left: 0;
  top: 0;
  opacity: 0.5;
  filter: blur(30px);
  transform: translateX(-100px) skewX(-15deg);
}
.great-red a:after {
  content: "";
  display: block;
  position: absolute;
  background: rgba(255, 255, 255, 0.2);
  width: 30px;
  height: 100%;
  left: 30px;
  top: 0;
  opacity: 0;
  filter: blur(5px);
  transform: translateX(-100px) skewX(-15deg);
}
.great-red a:hover {
  background: #00a0e3;
  cursor: pointer;
}
.great-red a:hover:before {
  transform: translateX(150px) skewX(-15deg);
  opacity: 0.6;
  transition: 0.5s;
}
.great-red a:hover:after {
  transform: translateX(150px) skewX(-15deg);
  opacity: 1;
  transition: 0.5s;
}
.great-red a:focus {
  outline: 0;
}
.great-bg{
    padding-bottom: 20px;
}
.head-about{
    text-align:center;
}
.head-about h3 {
    font-weight: 700;
    font-family: roboto;
    font-size: 30px;
}
.about-box {
    padding: 20px 10px;
    margin: 15px 0px;
    height: 200px;
    text-align:center;
    background:#fff;
    transition: ease-out .5s;
    cursor: pointer;
}
.about-box:hover{
    box-shadow: 0px 0px 15px 2px #eee;
}
@media(max-width:768px){
    .about-box {
        height:230px;
    }
}
.bx-img {
    width: 50px;
    height: 55px;
    margin: 0 auto;
}
.about-box h4{
    margin: 0px 0px 5px;
    font-size: 18px;
    font-weight: 500;
    font-family: roboto;
}
.about-text {
    font-size: 15px;
    font-family: roboto;
}
/*/*Whats Great About Us css starts */
@media only screen and (max-width: 450px){
    .header{
        background-position:-55px !important;
    }
}
');