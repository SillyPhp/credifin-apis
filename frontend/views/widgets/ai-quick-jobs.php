<?php

use yii\helpers\Url;

?>

<div class="container">

    <div class="row">
        <div class="ocl-md-12">
            <div class="jobs-main-heading">Hire Your Super Star Team</div>
        </div>
    </div>

    <div class="ji-tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#jobs" aria-controls="jobs" role="tab" data-toggle="tab"><img src="<?= Url::to('@eyAssets/images/pages/jobs/job-icon.png') ?>">Jobs</a></li>
            <li role="presentation"><a href="#internships" aria-controls="internships" role="tab" data-toggle="tab"><img src="<?= Url::to('@eyAssets/images/pages/jobs/internship-icon.png') ?>">Internships</a></li>
        </ul>
    </div>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="jobs">
            <div class="parent row">
                <div class="col-md-3 col-sm-6">
                    <div class="ai-job">
                        <a href="/account/jobs/create" class="ai-img" title="Create AI Job">
                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/ai-jobs.png') ?>">
                        </a>
                        <div class="ai-point">
                            <ul>
                                <li>Application Tracking System</li>
                                <li>Get Predefined Job descriptions</li>
                                <li>Create your own Questionnaire</li>
                                <li>set predefined interview location</li>
                                <li>Conduct campus placement</li>
                            </ul>
                        </div>
                        <a href="/account/jobs/create" class="create-btn ai">Create Now</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="ai-job ai-quick">
                        <a href="/account/jobs/quick-job" class="ai-img" title="Create Quick Job">
                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/quick-jobs.png') ?>">
                        </a>
                        <div class="ai-point">
                            <ul>
                                <li>one minute process</li>
                                <li>hassle free job creating</li>
                                <li>fast recruitment process</li>
                                <li>make your job more dynamic</li>
                                <li>expedites the hiring process system</li>
                            </ul>
                        </div>
                        <a href="/account/jobs/quick-job" class="create-btn quick">Create Now</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="ai-job ai-quick">
                        <a href="/tweets/job/create" class="ai-img" title="Create Twitter Job">
                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/twitter-jobs.png') ?>">
                        </a>
                        <div class="ai-point">
                            <ul>
                                <li>one click procedure</li>
                                <li>fast recruitment process</li>
                                <li>post jobs directly from twitter</li>
                                <li>post on Empower Youth, hire on your own platform</li>
                            </ul>
                        </div>
                        <a href="/tweets/job/create" class="create-btn twitter">Create Now</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="ai-job">
                        <a href="/account/jobs/campus-placement"  class="ai-img" title="Create Ecampus Job">
                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/e-campus.png') ?>">
                        </a>
                        <div class="ai-point">
                            <ul>
                                <li>visit hundred of colleges just in a click</li>
                                <li>most advanced recruiters process showcase your employer brand</li>
                                <li>post all kind of job and opportunities</li>
                            </ul>
                        </div>
                        <a href="/account/jobs/campus-placement" class="create-btn campus">Create Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="internships">
            <div class="parent row">
                <div class="col-md-3 col-sm-6">
                    <div class="ai-job">
                        <a href="/account/internships/create" class="ai-img" title="Create AI Internship">
                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/ai-internships.png') ?>">
                        </a>
                        <div class="ai-point">
                            <ul>
                                <li>Application Tracking System</li>
                                <li>Get Predefined Internship descriptions</li>
                                <li>Create your own Questionnaire</li>
                                <li>set predefined interview location</li>
                                <li>Conduct campus placement</li>
                            </ul>
                        </div>
                        <a href="/account/internships/create" class="create-btn ai">Create Now</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="ai-job ai-quick">
                        <a href="/account/internships/quick-internship" class="ai-img" title="Create Quick Internship">
                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/quick-internships.png') ?>">
                        </a>
                        <div class="ai-point">
                            <ul>
                                <li>one minute process</li>
                                <li>hassle free internship creating</li>
                                <li>fast recruitment process</li>
                                <li>make your job more dynamic</li>
                                <li>expedites the hiring process system</li>
                            </ul>
                        </div>
                        <a href="/account/internships/quick-internship" class="create-btn quick">Create Now</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="ai-job ai-quick">
                        <a href="/tweets/internship/create" class="ai-img" title="Create Twitter Internship">
                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/twitter-internships.png') ?>">
                        </a>
                        <div class="ai-point">
                            <ul>
                                <li>one click procedure</li>
                                <li>fast recruitment process</li>
                                <li>post internships directly from twitter</li>
                                <li>post on Empower Youth, hire on your own platform</li>
                            </ul>
                        </div>
                        <a href="/tweets/internship/create" class="create-btn twitter">Create Now</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="ai-job">
                        <a href="/account/internships/campus-placement"  class="ai-img" title="Create Ecampus Internship">
                            <img src="<?= Url::to('@eyAssets/images/pages/jobs/e-campus.png') ?>">
                        </a>
                        <div class="ai-point">
                            <ul>
                                <li>visit hundred of colleges just in a click</li>
                                <li>most advanced recruiters process showcase your employer brand</li>
                                <li>post all kind of internships and opportunities</li>
                            </ul>
                        </div>
                        <a href="/account/internships/campus-placement" class="create-btn campus">Create Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
$this->registerCss('
.jobs-main-heading{
    text-align: center;
    font-size: 28pt;
    text-transform: capitalize;
    font-family: roboto;
    font-weight: 700;
    word-spacing:3px;
    margin:10px 0px;
    color: #000;
}
.parent{
    margin:0 0 40px 0;
}
.ai-quick{
    margin-top: 90px !important;
}
.ai-job {
    width: 92%;
    margin: 0 auto;
    border: 1px solid #eee;
    box-shadow: 0px 0px 18px 0px #eee;
    border-radius: 25px;
    background:#fff;
}
.ai-img {
    margin: -46px 0px 0 10px;
    width:93%;
    display: block;
}
.ai-point {
    padding: 15px 8px 15px 27px;
}
.ai-point > ul > li{
    font-size:14px;
    font-family:Roboto;
    list-style: circle;
    text-transform: capitalize;
}
.create-btn{
    background: linear-gradient(90deg, #3969af, #00a5cc);
    color: #ffff;
    padding: 5px 15px;
    display: block;
    width: fit-content;
    margin-left: 25px;
    margin-bottom: 15px;
    border-radius: 4px;
    font-weight: 600;
    font-family: Roboto;
    letter-spacing: 0.2px;
}
.create-btn.ai{
    background: linear-gradient(90deg, #3969af, #00a5cc);
}
.create-btn.quick{
    background: linear-gradient(90deg, #674a97, #8661a6);
}
.create-btn.twitter{
    background: linear-gradient(90deg, #ea517a, #f3a189);
}
.create-btn.campus{
    background: linear-gradient(90deg, #f18b6f, #eea73e);
}
.create-btn:hover{
    opacity: 0.8;
    color: #fff;
}

.tab-pane{
    transition: .3s all ease-in;
}
.nav-tabs{
    display: flex;
    justify-content: center;
    margin: auto;
    width: fit-content;
    padding: 3px;
    border-radius: 41px;
    background: #FFFFFF;
    box-shadow: 0px 2px 7px rgb(0 0 0 / 25%);
}
.nav-tabs > li:nth-child(1) {
    margin-right: 10px;
}
.nav-tabs > li.active a, .nav-tabs > li.active a:hover, .nav-tabs > li.active a:focus{
    border: 1px solid #00a0e3 !important;
    color: #fff;
    border-radius: 20px;
    background: linear-gradient(270deg, #00A0E3 -4.76%, #0177A8 100%);
}
.nav-tabs > li > a:hover{
    color: #000;
}
.nav-tabs li a{
    border: none;
    padding: 5px 20px;
    font-family: roboto;
    font-size: 14px;
    display: flex;
    align-items: center;
}
.nav>li>a>img {
    max-width: none;
    margin-right: 9px;
    margin-bottom: 1px;
}
.nav-tabs > li.active a img, .nav-tabs > li.active a:hover img, .nav-tabs > li.active a:focus img {
    filter: brightness(0) invert(1);
}
@media only screen and (max-width: 768px){
    .ai-job{
        margin-bottom: 55px;
    }
}
@media (max-width:1200px){
.ai-job{width:84%;}
}
@media (max-width:992px){
.ai-job{width:100%;}
.ai-point > ul > li{font-size:13px;}
.ai-quick {margin-top: 0px !important;margin-bottom:55px !important;)
}
@media (max-width:834px){
.ai-job{width:75%;}
.ai-point > ul > li{font-size:13px;}
}
@media (max-width:414px){
.jobs-main-heading{
    font-size:23pt;
}

.parent{
    margin:80px 0px 0px 0;
}
.ai-job{
    width:78%;
    margin-bottom:70px;
}
}
@media (min-width: 414px) and (max-width: 768px){
    .ai-img{
        width: 53%;
    }
}
@media (max-width:375px){
    .ai-job{width:85%}
}
');