<?php

use yii\helpers\Url;

?>
    <div class="container">
        <div class="col-md-12">
            <div class="set-sticky">
                <h3 class="ou-head">Highlights</h3>
                <div class="placement-points">
                    <div class="place-point">
                        <div class="fa-icon"><i class="fas fa-university"></i></div>
                        <div class="fa-text">
                            <h3>No. of Companies visited</h3>
                            <p>AAA</p>
                        </div>
                    </div>
                    <div class="place-point">
                        <div class="fa-icon"><i class="fab fa-affiliatetheme"></i></div>
                        <div class="fa-text">
                            <h3>Top Recruiters</h3>
                            <p>AAA</p>
                        </div>
                    </div>
                    <div class="place-point">
                        <div class="fa-icon"><i class="fas fa-scroll"></i></div>
                        <div class="fa-text">
                            <h3>Highest Stipend Offered</h3>
                            <p>AAA</p>
                        </div>
                    </div>
                    <div class="place-point">
                        <div class="fa-icon"><i class="fas fa-microchip"></i></div>
                        <div class="fa-text">
                            <h3>Highest placement package</h3>
                            <p>AAA</p>
                        </div>
                    </div>
                    <div class="place-point">
                        <div class="fa-icon"><i class="fas fa-clipboard-check"></i></div>
                        <div class="fa-text">
                            <h3>No. of Companies Offering Dream Packages</h3>
                            <p>AAA</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="set-sticky">
                <h3 class="ou-head">Top Recruiters</h3>
                <div class="recruit-box-main">
                    <div class="recruiter-box">
                        <div class="recruit-logo"><img src="<?= Url::to('/assets/common/logos/logo.svg') ?>"></div>
                        <div class="recrt-content">
                            <div class="recruit-name">EmpowerYouth</div>
                            <div class="recruit-count">50+ Recruitments</div>
                            <div class="recruit-package">50k - 100k Package offered</div>
                        </div>
                    </div>
                    <div class="recruiter-box">
                        <div class="recruit-logo"><img src="<?= Url::to('/assets/common/logos/logo.svg') ?>"></div>
                        <div class="recrt-content">
                            <div class="recruit-name">EmpowerYouth</div>
                            <div class="recruit-count">50+ Recruitments</div>
                            <div class="recruit-package">50k - 100k Package offered</div>
                        </div>
                    </div>
                    <div class="recruiter-box">
                        <div class="recruit-logo"><img src="<?= Url::to('/assets/common/logos/logo.svg') ?>"></div>
                        <div class="recrt-content">
                            <div class="recruit-name">EmpowerYouth</div>
                            <div class="recruit-count">50+ Recruitments</div>
                            <div class="recruit-package">50k - 100k Package offered</div>
                        </div>
                    </div>
                    <div class="recruiter-box">
                        <div class="recruit-logo"><img src="<?= Url::to('/assets/common/logos/logo.svg') ?>"></div>
                        <div class="recrt-content">
                            <div class="recruit-name">EmpowerYouth</div>
                            <div class="recruit-count">50+ Recruitments</div>
                            <div class="recruit-package">50k - 100k Package offered</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="set-sticky row">
                <h3 class="ou-head">Recruitment By Course</h3>
                <div class="course-outer">
                    <div class="by-course-main">
                        <div class="by-course-name">B-tech</div>
                        <div class="by-data">
                            <div class="avg-pack">50k Average Package</div>
                            <div class="high-pack">50k Highest Package</div>
                            <div class="comp-visit">50+ Companies Visit</div>
                            <div class="total-offers">50+ Total offers</div>
                            <div class="student-offer">50+ Student Offers</div>
                        </div>
                    </div>
                    <div class="by-course-main">
                        <div class="by-course-name">B-tech</div>
                        <div class="by-data">
                            <div class="avg-pack">50k Average Package</div>
                            <div class="high-pack">50k Highest Package</div>
                            <div class="comp-visit">50+ Companies Visit</div>
                            <div class="total-offers">50+ Total offers</div>
                            <div class="student-offer">50+ Student Offers</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
<?php
$this->registerCss('
.placement-points {
	display: flex;
	justify-content: flex-start;
	align-items: center;
	flex-wrap: wrap;
	width: 100%;
}
.place-point {
	width: 25%;
	display: flex;
	align-items: center;
	margin-bottom: 10px;
	padding: 5px;
}
.fa-icon {
	font-size: 28px;
	margin-right: 8px;
	color: #00a0e3;
	width: 34px;
	text-align: center;
}
.fa-text h3 {
	font-size: 12px;
	margin: 0;
	font-family:roboto;
}
.fa-text p {
	font-size: 14px;
	margin: 0;
	font-weight:500;
}
.recruit-box-main {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
}
.recruiter-box {
	width: 32.6%;
	margin:0 1% 12px 0;
	box-shadow: 0 0 4px 0px rgba(0,0,0,0.1);
	padding: 10px;
	display: flex;
	align-items: center;
}
.recruiter-box:nth-child(3) {
    margin-right: 0px;
}
.recruit-logo {
	width: 90px;
	height: 90px;
}
.recruit-logo img {
	width: 100%;
	height: 100%;
	object-fit: contain;
}
.recrt-content {
	margin-left: 10px;
}
.recruit-name {
    font-size:16px;
	font-weight: 500;
}
.by-course-name {
	font-size: 20px;
	color:#00a0e3;
}
.by-data {
	display: flex;
	flex-wrap: wrap;
}
.by-data div {
	flex-basis: 50%;
}
.course-outer {
	display: flex;
	justify-content: center;
	flex-wrap: wrap;
}
.by-course-main {
	flex-basis: 49.5%;
	box-shadow: 0 0 3px 0 rgba(0,0,0,0.2);
	margin: 0 1% 15px 0;
	padding: 15px;
}
.by-course-main:nth-child(2) {
	margin-right: 0;
}
@media only screen and (max-width: 992px) {
.recruiter-box {
    width: 49%;
    margin: 0 0px 12px 0;
    }
}
@media only screen and (max-width: 767px) {
.place-point{width:50%;}
.recruiter-box {
    width: 100%;
    margin: 0 0px 12px 0;
    }
.by-course-main {
    flex-basis: 100%;
    margin: 0 0 15px 0;
    }
}
@media only screen and (max-width: 550px) {
.place-point{width:100%;}
.by-data div{flex-basis:100%;}
}
');
