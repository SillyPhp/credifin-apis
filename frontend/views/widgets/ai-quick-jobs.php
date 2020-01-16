<?php

use yii\helpers\Url;

?>

<div class="container">
    <div class="row">
        <div class="ocl-md-12">
            <div class="jobs-main-heading">jobs that can turn into a career</div>
        </div>
    </div>
    <div class="parent row">
        <div class="col-md-4 col-sm-4">
            <div class="ai-job">
                <div class="ai-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/jobs/ai-jobs.png') ?>">
                </div>
                <div class="ai-point">
                    <ul>
                        <li>Application Tracking System</li>
                        <li>Get Predefined Job descriptions</li>
                        <li>Create your own questionare</li>
                        <li>set predefined interview location</li>
                        <li>Conduct campus placement</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="ai-job ai-quick">
                <div class="ai-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/jobs/quick-jobs.png') ?>">
                </div>
                <div class="ai-point">
                    <ul>
                        <li>one minute process</li>
                        <li>hassle free job creating</li>
                        <li>fast recruitment process</li>
                        <li>make your job more dynamic</li>
                        <li>expedites the hiring process system</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="ai-job">
                <div class="ai-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/jobs/twitter-jobs.png') ?>">
                </div>
                <div class="ai-point">
                    <ul>
                        <li>one minute process</li>
                        <li>one click procedure</li>
                        <li>fast recruitment process</li>
                        <li>post jobs directly from twitter</li>
                        <li>post on Empower Youth, hire on your own platform</li>
                    </ul>
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
    text-transform: uppercase;
    font-family: lobster;
    font-weight: 800;
    word-spacing:10px;
    margin:10px 0px;
}
.parent{
    margin:80px 0px 40px 0;
}
.ai-quick{
    margin-top: 90px !important;
}
.ai-job {
    width: 68%;
    margin: 0 auto;
    border: 1px solid #eee;
    box-shadow: 0px 0px 18px 0px #eee;
    border-radius: 25px;
    background:#fff;
}
.ai-img {
    margin: -46px 0px 0 10px;
    width:93%;
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
@media (max-width:1200px){
.ai-job{width:84%;}
}
@media (max-width:992px){
.ai-job{width:100%;}
.ai-point > ul > li{font-size:13px;}
}
@media (max-width:786px){
.ai-job{width:100%;}
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
.ai-quick{
    margin-top: 0px;
}
}
@media (max-width:375px){
    .ai-job{width:85%}
}
');