<?php

use yii\helpers\Url;

?>

<div class="container">
    <div class="parent row" style="margin:80px 0px 40px 0;">
        <div class="col-md-4">
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
        <div class="col-md-4">
            <div class="ai-job" style="margin-top: 90px;">
                <div class="ai-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/jobs/quick-jobs.png') ?>">
                </div>
                <div class="ai-point">
                    <ul>
                        <li>one minute process</li>
                        <li>hassle free job creating</li>
                        <li>fast recruitment process</li>
                        <li>make your job more dynamic</li>
                        <li>expedites the hiring process</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
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
.ai-job {
    width: 68%;
    margin: 0 auto;
    border: 1px solid #eee;
    box-shadow: 0px 0px 15px 8px #eee;
    border-radius: 25px;
}
.ai-img {
    margin: -46px 0px 0 10px;
}
.ai-img img {
    max-width: 220px;
}
.ai-point {
    padding: 15px 8px 15px 27px;
}
.ai-point > ul > li{
    font-size:14px;
    font-family:Roboto;
    list-style: circle;
}
');