<?php

use yii\helpers\Url;

$this->params['header_dark'] = false;
?>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<section class="slider bg-main-s">
    <div class="block no-padding">
        <div class="container fluid">
            <div class="">
                <div class="col-lg-12 no-padd">
                    <div class="main-featured-sec style2">
                        <ul class="main-slider-sec style2 text-arrows">
<!--                            <li class="slideHome">-->
<!--                                <img src="--><?//= Url::to('@eyAssets/images/pages/index2/nslider-image2.jpg') ?><!--"-->
<!--                                     alt="internship, software developer, internships near me,web developer jobs,software engineer jobs"/>-->
<!--                            </li>-->
<!--                            <li class="slideHome">-->
<!--                                <img src="--><?//= Url::to('@eyAssets/images/pages/index2/nslider-image.jpg') ?><!--"-->
<!--                                     alt="data science internship,web design jobs,online internships, digital marketing internship, free course site, software developer jobs"/>-->
<!--                            </li>-->
                            <li class="slideHome">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/nslider-image1.jpg') ?>"
                                     alt="marketing internships, machine learning internship, hr internships, software jobs, best online course sites, website design jobs"/>
                            </li>
                        </ul>
                        <div class="job-search-sec">
                            <div class="job-search style2">
                                <h3>Discover a New Career Specially Designed For You</h3>
                                <span>The Easiest Way to Build Your Career</span>
                                <div class="search-job2">
                                    <form id="search_jobs_internships" action="<?= Url::to('/search'); ?>">
                                        <div class="row no-gape">
                                            <div class="col-lg-10 col-md-9 col-sm-8 col-xs-7">
                                                <div class="job-field">
                                                    <input id="search-input" type="text" name="keyword"
                                                           placeholder="Keywords"/>
                                                </div>
                                            </div>
                                            <div class="col-lg-2  col-md-3 col-sm-4 col-xs-5">
                                                <button type="submit" id="search-submit">Search <i
                                                            class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- Job Search 2 -->
                                <span class="feature-links">Search For: <a href="/jobs">Jobs</a>,
                                    <a href="/internships">Internships</a>, <a href="/training-programs">Training Courses</a>,
                                    <a href="/reviews">Reviews</a>, <a href="/learning">Learning Content</a>, <a
                                            href="/blog">Blogs</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-row">
        <div class="container">
            <div class="header-boxs">
                <div class="col-md-2 col-sm-6 col-xs-6">
                    <div class="box-border fade-in one">
                        <a href="/employers">
                            <div class="icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/employer.png') ?>"
                                     alt="Employers" title="Employers"></div>
                            <div class="icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/employerw.png') ?>"
                                     alt="Employers" title="Employers"></div>
                            <div class="h-heading">Employers</div>
                            <div class="h-text">I want to recruit talent</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6">
                    <div class="box-border fade-in two">
                        <a href="/candidates/features">
                            <div class="icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/candidate.png') ?>"
                                     alt="Candidates" title="Candidates">
                            </div>
                            <div class="icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/candidatew.png') ?>"
                                     alt="Employers" title="Employers"></div>
                            <div class="h-heading">Candidates</div>
                            <div class="h-text">I'm the talent</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6">
                    <div class="box-border fade-in two">
                        <a href="/schools">
                            <div class="icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/school.png') ?>"
                                     alt="Candidates" title="Candidates">
                            </div>
                            <div class="icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/schoolw.png') ?>"
                                     alt="Employers" title="Employers"></div>
                            <div class="h-heading">Schools</div>
                            <div class="h-text">COVID-19 <br>( Online Classes )</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6">
                    <div class="box-border fade-in three">
<!--                        <div class="box-overlay">-->
                            <a href="/colleges">
                                <div class="icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/colg.png') ?>"
                                         alt="Universities & Colleges" title="Universities and Colleges">
                                </div>
                                <div class="icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/colgw.png') ?>"
                                         alt="Employers" title="Employers"></div>
                                <div class="h-heading">Colleges</div>
                                <div class="h-text">I'm the future</div>
                            </a>
<!--                        </div>-->
                        <!--                        <div class="overlay">-->
                        <!--                            <div class="text">Coming Soon</div>-->
                        <!--                        </div>-->
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6">
                    <div class="box-border fade-in three">
                        <div class="box-overlay">
                            <div class="icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/colleges.png') ?>"
                                     alt="Universities & Colleges" title="Universities and Colleges">
                            </div>
                            <div class="icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/collegesw.png') ?>"
                                     alt="Employers" title="Employers"></div>
                            <div class="h-heading">Universities</div>
                            <div class="h-text">I want to enroll talent</div>
                        </div>
                        <div class="overlay">
                            <div class="text">Coming Soon</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-6">
                    <div class="box-border fade-in four">
                        <div class="box-overlay">
                            <div class="icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/recruiter.png') ?>"
                                     title="Recruiters" alt="Recruiters">
                            </div>
                            <div class="icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/recruiterw.png') ?>"
                                     alt="Employers" title="Employers"></div>
                            <div class="h-heading">Recruiters</div>
                            <div class="h-text">I want to find the best match for talent</div>
                        </div>
                        <div class="overlay">
                            <div class="text">Coming Soon</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--------services section starts-------->

<section class="services-section">
    <div class="container">
        <h1 class="heading-style ">Our Services</h1>
        <div class="services row">
            <div class="col-md-4 col-sm-6">
                <a href="<?= Url::to('/jobs'); ?>">
                    <div class="service-box">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/job.png') ?>"
                                 alt="web developer jobs for freshers, job openings in chandigarh data science job opportunities, it software engineer"
                                 title="Jobs"/>
                        </div>
                        <div class="ser-heading">Jobs</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?= Url::to('/internships'); ?>">
                    <div class="service-box ser-box-orange">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/internships.png') ?>"
                                 alt="free learning sites, free internship, best online learning sites, free online courses sites,internship jobs near me"
                                 title="Internships"/>
                        </div>
                        <div class="ser-heading">Internships</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?= Url::to('/learning'); ?>">
                    <div class="service-box ser-box-yellow">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/learning-icon-set.png') ?>"
                                 alt="international internships, web developer career, software engineer career">
                        </div>
                        <div class="ser-heading">Learning Hub</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?= Url::to('/reviews'); ?>">
                    <div class="service-box ser-box-purple">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/review-icon.png') ?>"
                                 alt="research internship, software developer career internship websites, best learning websites"
                                 title="Reviews"/>
                        </div>
                        <div class="ser-heading">Reviews</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?= Url::to('/training-programs'); ?>">
                    <div class="service-box ser-box-maroon">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/training.png') ?>"
                                 alt="market research internship, jobs in ludhiana city, latest jobs in chandigarh for freshers, software engineer work">
                        </div>
                        <div class="ser-heading">Training Courses</div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?= Url::to('/career-advice'); ?>">
                    <div class="service-box ser-box-green">
                        <div class="ser-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/careerAdvice.png') ?>"
                                 alt="latest recruitment in chandigarh, it internships, online marketing jobs from home, latest jobs in ludhiana">
                        </div>
                        <div class="ser-heading">Career Advice</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<div id="app-data"></div>
<div id="sectionIsLoading" class="sectionIsLoading">
    <div></div>
    <div></div>
</div>
<?php
$this->registerCss('
.header-row {
    margin-top: -177px;
    background-color:#ffffff2b;
    padding:0;
}
.icon img {
    height: 60px;
    width: 60px;
}
.h-heading{
    color:#fff;
}
.h-text{
    color:#eef7ff; 
}
.sectionIsLoading {
    display: none;
    position: relative;
    width: 80px;
    height: 80px;
    margin: auto;
}
.sectionIsLoading div {
  position: absolute;
  border: 4px solid #00a0e3;
  opacity: 1;
  border-radius: 50%;
  animation: sectionIsLoading 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
}
.sectionIsLoading div:nth-child(2) {
  animation-delay: -0.5s;
}
@keyframes sectionIsLoading {
  0% {
    top: 36px;
    left: 36px;
    width: 0;
    height: 0;
    opacity: 1;
  }
  100% {
    top: 0px;
    left: 0px;
    width: 72px;
    height: 72px;
    opacity: 0;
  }
}

.j-tweets{
    background:url(' . Url::to('@eyAssets/images/backgrounds/p6.png') . ');  
    background-attachment: fixed;
    padding-bottom:20px;
}
.tweetLinks{
    text-align: right;
    margin-top:30px;
}
.cat-padding{
    padding-bottom:20px;
}
.tweetLinks a{
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    padding: 13px 32px;
    border-radius: 4px;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
    color: #222;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    margin-left:5px;
     background: #fff;
}
.tweetLinks a:hover{
       background-color: #00a0e3;
    color: #fff;
}
.tweet-btn{
    padding-bottom:20px;
    marginn-top:-10px;
}
.tweet-btn button{
    background:none;
    border:none;
    font-size: 18px;
    font-family: lora;  
}
.tweet-btn button:hover{
    color:#00a0e3;
}
.job-search > span{
    color:#fff !important;
}
.feature-links a{
    color: #d5d8f3;
    padding-right: 5px;    
}
.feature-links a:hover{
    color:#ff7803;
}
.app-btn{
    max-width:200px;
    margin:0 auto;
}
.intern-tag{
    position:absolute;
    top:0;
    right:0px;
    background:transparent;
    padding:5px 10px;
    font-size:12px;
    color:#8b91dd;
    border-left: 1px solid #eee;
    border-bottom: 1px solid #eee;
    border-radius: 0 7px 0 7px;
}
.hiw-heading{
    text-align: center;
    padding-bottom: 30px;
    font-size: 28px;
    color: #00a0e3;
    line-height: 33px;
    font-family: lobster;
    text-transform: capitalize;  
}
.hiw-heading p{
    color:#ff7803;
}
.signupbttns{
    text-align:center;
    padding-top:30px;
}
.signupbttns a{
    margin:0 8px;
}
.login-bttn{
    padding: 12px 40px;
    border:2px solid #00a0e3;
    border-radius:5px;
    color:#00a0e3;
    text-transform:uppercase;
}
.login-bttn, .sign-up, .sign-up:hover, .login-bttn:hover{
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.login-bttn:hover{
    border:2px solid #00a0e3;
    color:#fff; 
    background:#00a0e3; 
}
.sign-up{
    padding: 12px 40px;
    border:2px solid #ff7803;
    border-radius:5px;
    color:#ff7803;
    text-transform:uppercase;
}
.sign-up:hover{
   color:#fff; 
    background:#ff7803;  
}
.job-field input:focus{
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
}
.no-padd{
   padding-left:0px !important; 
   padding-right:0px !important; 
}
.header-boxs{
    margin:0 auto;
}
.box-border:hover{
    -ms-transform: scale(1.1,1.1); 
    -webkit-transform: scale(1.1,1.1); 
    transform: scale(1.1,1.1);
    -ms-transition:.3s all; 
    -webkit-transition:.3s all;
    transition:.3s all;
    background-color:#00a0e3;
    z-index:1;
    border:none;
    box-shadow:0px 0px 37px #00000091;
}
.box-border:hover .icon{
    display:none;
}
.icon2{
    display:none;
}
.icon2 img{
    height:60px;
    width:60px;
}
.box-border:hover .icon2{
    display:block;
}
.box-border{
    border-left:1px solid #ffffff4f;
    border-right:1px solid #ffffff4f;
    padding: 18px 20px 10px;
    text-align: center; 
    margin-bottom: 20px; 
    position:relative;
    -ms-transition:.3s all; 
    -webkit-transition:.3s all;
    transition:.3s all;
} 
.box-overlay {
    display: block;
  width: 100%;
  height: auto;
}
.overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #00a0e3;
    overflow: hidden;
    width: 100%;
    height: 0;
    transition: .5s ease;
}
.text { 
    color: white;
    font-size: 15px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
}
.box-border:hover .box-overlay {
    opacity: 0.1;
}
.box-border:hover .overlay {
    height: 20%;
}
/*services section starts*/
.services{
    padding: 0px 0 25px 0; 
    text-align:center !important;
}
.service-box{ 
    background:url(' . Url::to('@eyAssets/images/pages/index2/orange-bg.png') . ');
    padding:20px 20px;
    border-radius:10px;
    border-width:5px 0px 0px 0px; 
    border-color:transparent;
    border-style:solid;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    width: 95%;
    margin: auto;
    margin-bottom:20px;
    box-shadow: 0px 2px 13px 0px #ddddddb8;
    background-size: 100% !important;
    background-position: 0px -8px !important;
    background-repeat:no-repeat !important;
}
.service-box:hover{
    box-shadow: 0px 2px 13px 3px #ddddddb8;
    border-top:5px solid #ff7803;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -o-transition:.3s all;
    color:#ff7803;
}
.ser-box-orange{
    background:url(' . Url::to('@eyAssets/images/pages/index2/bgq.png') . ');
}
.ser-box-orange:hover{
    border-top:5px solid #00a0e3;
    color:#00a0e3;
}
.ser-box-purple{
    background:url(' . Url::to('@eyAssets/images/pages/index2/review-box-bg.png') . ');
}
.ser-box-purple:hover{
    border-top:5px solid #5E4795;
    color:#5E4795;
}
.ser-box-yellow{
    background: url(' . Url::to('@eyAssets/images/pages/index2/learningbg.png') . ');
}
.ser-box-yellow:hover{
    border-top: 5px solid #f8b321;
    color:#f8b321
}
.ser-box-maroon{
    background: url(' . Url::to('@eyAssets/images/pages/index2/trainingbg.png') . ');
}
.ser-box-maroon:hover{
    border-top: 5px solid #c76692;
    color:#c76692
}
.ser-box-green{
    background: url(' . Url::to('@eyAssets/images/pages/index2/careerAdviceBg.png') . ');
}
.ser-box-green:hover{
    border-top: 5px solid #047c7d;
    color:#047c7d
}
.ser-icons{
    text-align:center;
}
.ser-icons img{
    max-height: 75px; 
    max-width: 75px;
}
.serv-center{
    padding:0 30px;
}
.ser-heading{
    padding: 10px 0 0 0;
    text-transform: uppercase;
    font-size: 20px;
    text-align:center;
    font-family:lora;
}
/*services section ends*/
/*how it works section starts*/
.how-it-works{
    padding: 20px 0 45px 0;
    background:#ecf5fe;
    text-align:center;
}
.how-heading{
    font-size: 15px;
    font-weight:400;
    font-family:Roboto;
}
.steps-row{
    padding: 30px 0;
}
.how-text-box{
    padding:10px 0 0 0;
    text-align:center;
}
how-icon{
    text-align:center;
}
.how-icon img{
    width:220px;
    max-height:250px;    
}

/*how it works section ends*/
/*-------------------------------------*/

@media only screen and (min-width: 1120px){
    .seq .seq-model {
        margin-left: 0;
        width: 45.5%;
    }
    .seq .seq-title {
        width: 41.5%;
        margin-right: 0;
    }
}


/* make keyframes that tell the start state and the end state of our object */
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

.fade-in {
  opacity:0;  /* make things invisible upon start */
  -webkit-animation:fadeIn ease-in 1;  /* call our keyframe named fadeIn, use animattion ease-in and repeat it only 1 time */
  -moz-animation:fadeIn ease-in 1;
  animation:fadeIn ease-in 1;

  -webkit-animation-fill-mode:forwards;  /* this makes sure that after animation is done we remain at the last keyframe value (opacity: 1)*/
  -moz-animation-fill-mode:forwards;
  animation-fill-mode:forwards;

  -webkit-animation-duration:1s;
  -moz-animation-duration:1s;
  animation-duration:1s;
}

.fade-in.one {
  -webkit-animation-delay: 0.9s;
  -moz-animation-delay: 0.9s;
  animation-delay: 0.9s;
}

.fade-in.two {
  -webkit-animation-delay: 1.5s;
  -moz-animation-delay:1.5s;
  animation-delay: 1.5s;
}

.fade-in.three {
  -webkit-animation-delay: 2.0s;
  -moz-animation-delay: 2.0s;
  animation-delay: 2.0s;
}

.fade-in.four {
  -webkit-animation-delay: 2.4s;
  -moz-animation-delay: 2.4s;
  animation-delay: 2.4s;
}

/*---make a basic box ---*/
/*    <!-- view-all button css start -->*/
.btn-3 {
    background-color: #424242;
}
.btn-3 .round {
    background-color: #737478;
}
.type-1{
    float:right;
    margin-top: 15px;
    margin-bottom: 15px;
}

.type-1 div a {
    text-decoration: none;
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
    padding: 12px 53px 12px 23px;
    color: #fff;
    text-transform: uppercase;
    font-family: sans-serif;
    font-weight: bold;
    position: relative;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    display: inline-block;
}
.type-1 div a span {
    position: relative;
    z-index: 3;
}
.type-1 div a .round {
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    position: absolute;
    right: 3px;
    top: 3px;
    -moz-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
    z-index: 2;
}
.type-1 div a .round i {
    position: absolute;
    top: 50%;
    margin-top: -6px;
    left: 50%;
    margin-left: -4px;
    color: #333332;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}
.txt-cate {
    font-size: 14px;
    line-height: 1.45;
}
.type-1 a:hover {
    padding-left: 48px;
    padding-right: 28px;
}
.type-1 a:hover .round {
    width: calc(100% - 6px);
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
}
.type-1 a:hover .round i {
    left: 12%;
    color: #FFF;
}
/*<!---- view-all button css ends --->*/

@media screen and (min-width: 993px){
    .box-border{
         min-width: 191px !important;
         max-width: 191px !important;
         height: 170px;
    }
}
@media screen and (max-width: 992px) {
    .header-boxs{
        display:inline;
    }
    .header-row{
        margin-top:-100px;
    }
    .box-border{
        min-height: 175px;
        margin-left: 0px;
        background: #fff;
        border: 1px solid #eee;
        padding: 30px;
    }
    .h-heading{
        color:#000;
    }
    .box-border:hover .h-heading{
        color:#fff;
    }
}
.job-field .chosen-container-single .chosen-single{
    border-radius:0 23px 0 0;
    border:none;
  }
  .search-job2 .job-field2::before{
    background:transparent;
  }
  .search-job2{
    padding:9px 20px;
    background:none;
  }

@media screen and (max-width: 767px){
    .how-icon{
        text-align:center;
        padding:0 0 20px 0;
    }
    .how-text-box{
        padding:10px 0 20px 0;
    }
    .job-search-sec{
        min-width:100%;
    }
    .tweetLinks {
        text-align: right;
        margin-bottom: 30px;
    }
    .box-border{
        min-height: 215px;
        }
}
.job-field select{
    float: left;
    width: 100%;
    background: no-repeat;
    border: none;
    font-size: 13px;
    color: #888888;
    margin: 0;
    padding: 0 70px 0 30px;
    height: 61px;
    line-height: 61px;
    background-color: #FFF;
    border-radius: 23px;
}
.job-field input{
    border-radius: 23px !important;
}
.search-job2{
        border-radius: 8px;
        background:none;
    }
@media screen and (max-width: 575px){   
    .header-row{
        margin-top:20px;
    }
}

@media screen and (max-width: 375px){
     .box-border{
        min-height:280px;
        margin-left:0px;
        padding: 20px 10px;
     }
}

.tab-sec {
    float: left;
    width: 100%;
    text-align: center;
}
.nav.nav-tabs {
    float: none;
    width: auto;
    text-align: center;
    margin: 0;
    display: inline-block;
    border: 1px solid #e7e7e7;
    background: #00a0e3;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    -ms-border-radius: 5px;
    -o-border-radius: 5px;
    border-radius: 5px;
    padding: 0 8px;
}
.nav.nav-tabs > li {
    float: none;
    display: inline-block;
    margin: 0;
}
.nav.nav-tabs > li a {
    float: left;
    font-size:18px;
    font-weight:400;
    font-family:Roboto;
    letter-spacing: 0px;
    padding: 12px 21px;
    color:#fff;
    -webkit-border-radius: 8px;
    -moz-border-radius: 5px;
    -ms-border-radius: 5px;
    -o-border-radius: 5px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 9px;
    margin-bottom: 3px;
    border-left:none !important;
}
.nav.nav-tabs > li a:hover{
    border-color:transparent;
    background:#fff;
    color:#00a0e3;
}
.nav.nav-tabs > li a.current {
    color: #00a0e3 !important;
    background-color: #fff;
    font-family:Roboto;
    font-weight:400;
}
.job-listing.wtabs {
    border: 1px solid #ebefef;
    margin-top: 30px;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    display: inherit;
    text-align: left;
    position: relative;
}
.job-listing.wtabs .job-title-sec {
    float: left;
    width: 80%;
}
.wtabs-com-name{
    display: table;
    float: none;
}
.wtabs-com-name a{
    color: #1e83f0 !important;
      font-size:14px;
      font-weight:normal;
    width:100%;
}
.job-listing.wtabs .job-lctn {
    display: inline;
    width: 100%;
    font-size: 13px;
}
.job-listing.wtabs .job-lctn i {
    float: none;
    font-size: 15px;
}
.job-style-bx {
    float: left;
    width: 30%;
    position: absolute;
    right: 0px;
    bottom: 0;
    padding: 15px;
}
.job-style-bx .fav-job {
    font-size: 20px;
    float: right;
    margin-top: 5px;
    margin-right: 10px;
}
.job-style-bx .job-is {
    margin: 0;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -ms-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;
    color: #ffffff;
}
.tab-sec .tab-content {
    display: none;
}
.tab-sec .tab-content.current {
    display: block;
}
.tab-sec .browse-all-cat .style2 {
    border: 1px solid #ebefef;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    -ms-box-shadow: none;
    -o-box-shadow: none;
    box-shadow: none;
    padding: 15px 44px;
    font-size: 15px;
    color: #111111;   
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
}

.how-to-sec.style2.no-lines .how-to::before {
    display: none;
}
.how-to-sec.style2.no-lines .how-icon {
    border: 1px solid #e8ecec;
    background: none;
    color: #707070;
}
.browse-all-cat a.style2:hover{
    background-color:#00a0e3;
    color:#fff;
    border-color:transparent;
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.back-top:hover {
    color: #FFF;
}
.job-listings-sec {
    float: left;
    width: 100%;
}
.job-listing {
    float: left;
    width: 100%;
    display: table;
    border-bottom: 1px solid #e8ecec;
    padding: 20px 0;
    background: #ffffff;
    border-left: 2px solid #ffffff;
    padding-right: 30px;
}
.job-title-sec {
    display: table-cell;
    vertical-align: middle;
    width: 60%;
}
.c-logo {
    float: left;
    width: 130px;
    height:80px;
    text-align: center;
    position:relative;
}
.c-logo img {
    float: none;
    display: inline-block;
    max-width: 80px;
    position:absolute;
    top:50%;
    transform: translate(-50%, -50%);
}
.job-title-sec h3 {
    display: table;
    font-size: 15px;
    color: #202020;
    margin: 0;
        margin-bottom: 0px;
    margin-bottom: 7px;
    margin-top: 3px;
}
.job-title-sec span {
    float: left;
    font-size: 13px;
    margin-top: 1px;
}
.job-lctn {
    display: table-cell;
    vertical-align: middle;
    font-family: open Sans;
    font-size: 13px;
    color: #888888;
    line-height: 23px;
    width: 25%;
}
.job-lctn i {
    font-size: 24px;
    float: left;
    margin-right: 7px;
}

.job-is {
    display: table-cell;
    vertical-align: middle;
    font-family: Open Sans;
    font-size: 12px;
    border: 1px solid;
    float: right;
    padding: 7px 0;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    -ms-border-radius: 20px;
    -o-border-radius: 20px;
    border-radius: 20px;
    width: 108px;
    margin: 9px 0;
    text-align: center;
}
.ft.fill {
    background: #8b91dd;
}
.fill.pt {
    background: #7dc246;
}
.fill.fl {
    background: #fb236a;
}
.fill.tp {
    background: #26ae61;
}
.job-listing:hover {
    -webkit-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 30px rgba(0,0,0,0.1);
    z-index: 1;
    position: relative;
}

.job-grid .job-title-sec {
    float: left;
    width: 100%;
    text-align: center;
    position: relative;
    padding-bottom: 20px;
    border-bottom: 1px solid #e8ecec;
}
.job-grid .job-title-sec .c-logo {
    float: left;
    width: 100%;
    margin-top: 50px;
    margin-bottom: 30px;
}
.job-grid .job-title-sec h3 {
    float: left;
    width: 100%;
    margin: 0;
    margin-bottom: 0px;
    text-align: left;
    padding-left: 0px;
    margin-bottom: 6px;
}
.job-grid .job-title-sec span {
    margin-left: 0px;
}

.job-grid .job-lctn {
    float: left;
    width: auto;
    font-size: 13px;
    margin: 18px 0;
}
.job-grid > a {
    float: right;
    font-family: Open Sans;
    font-size: 13px;
    color: #fb236a;
    border: 1px solid #fb236a;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    -ms-border-radius: 20px;
    -o-border-radius: 20px;
    border-radius: 20px;
    padding: 6px 14px;
    letter-spacing: 0px;
    margin: 16px 0;
    display: inline-block;
}

.browse-all-cat {
    float: left;
    width: 100%;
    text-align: center;
    margin-top: 60px;
}

.search-job2 form{
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
}

.search-job2 form button{
    -webkit-border-radius: 0px 8px 8px 0px !important;
    -moz-border-radius: 0px 8px 8px 0px !important;
    -ms-border-radius: 0px 8px 8px 0px !important;
    -o-border-radius: 0px 8px 8px 0px !important;
    border-radius: 0px 8px 8px 0px !important;
}
.search-job2 form button{
    font-family:roboto;
}
.list-heading{
    font-size:16px;
    font-weight:500;
    font-family:Roboto;
}

.quick-links li a{
    line-height:23px;
    font-size:13px;
    font-weight:300;
    font-family:Roboto;
}
.quick-links li a:hover{
    color:#00a0e3;
}
.search-lists{
    padding:20px 0 50px;
    text-transform:capitalize;
}
.hide{
    display:none;
}
.showHideBtn{
    background:none;
    border:none;
    color:#00a0e3;
    padding:0;
    font-size:14px;
}

@media only screen and (max-width: 992px){  
     .how-icon{
        text-align:center;
        padding:0 0 20px 0;
    }
    .how-heading{
        font-family:lora;
        font-size:20px
    }
}
@media only screen and (max-width:500px){
    .c-logo{
        width:100% !important ;
        text-align:center;
        margin-botom:15px;
    }
    .job-title-sec h3, .job-title-sec span{
        width:100%;
    }
    
    .job-lctn{
        width:100%;
    }
    .job-listing{
        padding:20px 25px !important;
        padding-bottom: 35px !important;
    }
    .job-style-bx{
        padding: 0px;
    }
    .job-listing.wtabs .job-title-sec {
        float: left;
        width: 100%;
    }
}

');
$script = <<< JS
$("html, body").animate({ scrollTop: 0 }, "slow");
var load_content = true;
var loadNth = 0;
var errorNth = 0;
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
     var doc_height = $(document).height() - $(window).height();
  if (document.documentElement.scrollTop > doc_height - $('#footer').height()) {
      if(load_content && loadElems[loadNth]){
        load_content = false;
        $.ajax({
            url: "/site/load-data",
            method: "POST",
            data: {type:loadElems[loadNth]},
            beforeSend:function(){
                $('#sectionIsLoading').fadeIn(500);
            },
            success: function (response) {
                $('#sectionIsLoading').fadeOut(800);
                $(this).animate({scrollTop : -500}, 400);
                $('#app-data').append(response);
                loadNth++;
                errorNth = 0;
            },
            complete: function() {
                load_content = true;
            },
            error: function(xhr, textStatus, errorThrown){
               scrollFunction();
               errorNth++;
               if(errorNth == 3){
                   loadNth++;
               }
            }
        });
      }
  }
}
        
  jQuery(function($) {
  $('.main-slider-sec').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: false,
	  autoplay: true,
	  slide: 'li',
	  fade: false,
	  infinite: true,
	  dots: false
	});
});


document.getElementById('search-submit').addEventListener('click',(evt)=> {
  var searchInput = document.getElementById('search-input').value;
  if(searchInput == ''){
      evt.preventDefault();
      return false; 
  }
});
JS;
if (!Yii::$app->user->isGuest) {
    $this->registerJs("
    var loadElems = [
        'getGovernmentJobs',
        'getFeaturedJobs',
        'getOpportunities',
        'getWhatsappCommunity',
        'getLearningTopics',
        'getStats',
        'getTopCities',
        'getCompaniesWithUs',
        'getTweets',
        'getShortcuts'
    ];
    ");
} else {
    $this->registerJs("
    var loadElems = [
        'getGovernmentJobs',
        'getFeaturedJobs',
        'getOpportunities',
        'getWhatsappCommunity',
        'getLearningTopics',
        'getStats',
        'getTopCities',
        'getHowItWorks',
        'getCompaniesWithUs',
        'getTweets',
        'getNewsletter',
        'getShortcuts'
    ];
    ");
}
$this->registerJs($script);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
//$this->registerCssFile('https://fonts.googleapis.com/css?family=Roboto:300,400,500&display=swap" rel="stylesheet');
$this->registerCssFile('@eyAssets/css/home-page-slider.css');
$this->registerJsFile('@eyAssets/js/homepage_slider/select-chosen.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@eyAssets/js/homepage_slider/slick.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['position' => \yii\web\View::POS_HEAD]);
?>
<script src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>