<?php

use yii\helpers\Url;

?>
    <section class="our-backg">
        <div class="container">
            <div class="col-md-12">
                <div class="row">
                    <h2 class="heading-style">To Whom We Serve</h2>
                </div>
                <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                        <a href="<?= Url::to('/employers'); ?>">
                            <div class="service-main">
                                <div class="service-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/employer.png') ?>"
                                         alt="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                         title="Employers">
                                </div>
                                <div class="service-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/employerO.png') ?>"
                                         alt="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                         title="Employers">
                                </div>
                                <h2 class="service-txt">Employers</h2>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                        <a href="<?= Url::to('/candidates/features'); ?>">
                            <div class="service-main">
                                <div class="service-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/candidate.png') ?>"
                                         alt="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                         title="Candidates">
                                </div>
                                <div class="service-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/candidatesO.png') ?>"
                                         alt="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                         title="Candidates">
                                </div>
                                <h2 class="service-txt">Candidates</h2>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                        <a href="<?= Url::to('/schools'); ?>">
                            <div class="service-main">
                                <div class="service-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/school.png') ?>"
                                         alt="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                         title="schools">
                                </div>
                                <div class="service-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/schoolsO.png') ?>"
                                         alt="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                         title="schools">
                                </div>
                                <h2 class="service-txt">Schools</h2>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                        <a href="<?= Url::to('/training-programs'); ?>">
                            <div class="service-main">
                                <div class="service-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/universitesB.png') ?>"
                                         alt="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                         title="Educational Institute">
                                </div>
                                <div class="service-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/universitesO.png') ?>"
                                         alt="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                         title="Educational Institute">
                                </div>
                                <h2 class="service-txt">Educational Institute</h2>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                        <a href="<?= Url::to('/colleges'); ?>">
                            <div class="service-main">
                                <div class="service-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/colg.png') ?>"
                                         alt="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                         title="Colleges">
                                </div>
                                <div class="service-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/index2/collegesO.png') ?>"
                                         alt="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                         title="Colleges">
                                </div>
                                <h2 class="service-txt">Universities & Colleges</h2>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 u-p">
                        <div class="service-main">
                            <div class="service-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/recruiter.png') ?>"
                                     title="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                     alt="Recruiters">
                            </div>
                            <div class="service-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/index2/RecruitersO.png') ?>"
                                     title="technical free courses, jobs, internships, technical courses, education loan, Apply for education loan, Apply for lower education loan "
                                     alt="Recruiters">
                            </div>
                            <h2 class="service-txt">Recruiters</h2>
                            <div class="overl">
                                <div class="overl-text">Coming Soon</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registercss('
.service-main:hover .overl{
	height: 100%;
}
.overl {
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
	background-color: #ff7803;
	overflow: hidden;
	width: 100%;
	height: 0;
	transition: .5s ease;
}
.overl-text {
	color: white;
	font-size: 15px;
	position: absolute;
	top: 50%;
	left: 50%;
	-webkit-transform: translate(-50%, -50%);
	-ms-transform: translate(-50%, -50%);
	transform: translate(-50%, -50%);
	text-align: center;
	font-family: roboto;
    font-weight: 500;
}
.our-backg {
    background-color: #ECF5FE;
	padding:55px 0;
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
	position:relative;
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
	font-size: 16px;
	font-family: roboto;
	text-align: center;
	color:#333;
	margin:0;
	line-height: inherit;
}
@media(max-width:1200px){
.service-txt {
	font-size: 13px;
	}
}
@media(max-width:990px){
.service-txt {
	font-size: 16px;
	}
}
@media(max-width:550px){
    .u-p{
        padding:0 8px !important;
    }
    .service-txt {
        font-size: 14px;
	}
    .service-main{
        min-height: 165px;
    }
}
');