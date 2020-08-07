<?php

use yii\helpers\Url;

?>
    <section class="our-backg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="heading-style ">What Else You Can Do</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                    <a href="<?= Url::to('/jobs'); ?>">
                        <div class="service-main">
                            <div class="service-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/jobs-blue.png') ?>"
                                     alt="web developer jobs for freshers, job openings in chandigarh data science job opportunities, it software engineer"
                                     title="Jobs"/>
                            </div>
                            <div class="service-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/jobs-orange.png') ?>"
                                     alt="web developer jobs for freshers, job openings in chandigarh data science job opportunities, it software engineer"
                                     title="Jobs"/>
                            </div>
                            <div class="service-txt">Jobs</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                    <a href="<?= Url::to('/internships'); ?>">
                        <div class="service-main">
                            <div class="service-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/internship-blue.png') ?>"
                                     alt="free learning sites, free internship, best online learning sites, free online courses sites,internship jobs near me"
                                     title="Internships"/>
                            </div>
                            <div class="service-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/internship-orange.png') ?>"
                                     alt="free learning sites, free internship, best online learning sites, free online courses sites,internship jobs near me"
                                     title="Internships"/>
                            </div>
                            <div class="service-txt">Internships</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                    <a href="<?= Url::to('/learning'); ?>">
                        <div class="service-main">
                            <div class="service-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/learning-hub-blue.png') ?>"
                                     alt="international internships, web developer career, software engineer career">
                            </div>
                            <div class="service-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/learning-hub-orange.png') ?>"
                                     alt="international internships, web developer career, software engineer career">
                            </div>
                            <div class="service-txt">Learning Hub</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                    <a href="<?= Url::to('/reviews'); ?>">
                        <div class="service-main">
                            <div class="service-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/review-blue.png') ?>"
                                     alt="research internship, software developer career internship websites, best learning websites"
                                     title="Reviews"/>
                            </div>
                            <div class="service-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/review-orange.png') ?>"
                                     alt="research internship, software developer career internship websites, best learning websites"
                                     title="Reviews"/>
                            </div>
                            <div class="service-txt">Reviews</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                    <a href="<?= Url::to('/training-programs'); ?>">
                        <div class="service-main">
                            <div class="service-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/training-courses-blue.png') ?>"
                                     alt="market research internship, jobs in ludhiana city, latest jobs in chandigarh for freshers, software engineer work">
                            </div>
                            <div class="service-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/training-courses-orange.png') ?>"
                                     alt="market research internship, jobs in ludhiana city, latest jobs in chandigarh for freshers, software engineer work">
                            </div>
                            <div class="service-txt">Training Courses</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                    <a href="<?= Url::to('/career-advice'); ?>">
                        <div class="service-main">
                            <div class="service-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/career-advice-blue.png') ?>"
                                     alt="latest recruitment in chandigarh, it internships, online marketing jobs from home, latest jobs in ludhiana">
                            </div>
                            <div class="service-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/our-services/career-advice-orange.png') ?>"
                                     alt="latest recruitment in chandigarh, it internships, online marketing jobs from home, latest jobs in ludhiana">
                            </div>
                            <div class="service-txt">Career Advice</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registercss('
.our-backg {
	background: url(/assets/themes/ey/images/pages/our-services/service-back.png);
	padding: 0px 0 55px;
	background-size: cover;
	background-position: left;
}
.u-p{
    padding:0 5px !important;
}
.service-main {
	box-shadow: 0 0 11px -4px #000;
	padding: 15px 6px;
	margin-bottom: 20px;
	background-color: #fff;
	transition: all .2s;
	border-bottom:3px solid #00a0e3;
}
.service-main:hover {
	transform: translateY(-6px);
	z-index: 1;
	border-bottom:3px solid #ff7803;
	box-shadow: 0px 8px 18px -8px #000;
}
.service-icon {
	width: 85px;
	margin: auto;
	height: 85px;
	line-height: 79px;
	text-align:center;
}
.service-main:hover .service-icon{
    display:none;
}
.service-main:hover .service-icon2{
    display:block;
}
.service-icon2 {
    display:none;
	width: 85px;
	margin: auto;
	height: 85px;
	line-height: 79px;
	text-align:center;
}
.service-txt {
	font-size: 17px;
	font-family: roboto;
	text-transform: uppercase;
	text-align: center;
	color:#333;
}
@media(max-width:1200px){
.service-txt {
	font-size: 15px;
	}
}
@media(max-width:990px){
.service-txt {
	font-size: 17px;
	}
}
@media(max-width:550px){
    .u-p{
        padding:0 8px !important;
    }
    .service-txt {
        font-size: 14px;
	}
}
');