<?php
use yii\helpers\Url;

$this->registerCss("
		.wrapper {
			max-width: 600px;
			margin: 0 auto;
		}
		.new-img-set img {
			width: 100%;
			margin-top: -30px;
		}
		.border2 {
			background: white;
		}
		.part, .part2 {
			display: block;
			padding-left: 20px;
			text-align:center;
		}
		.part2 {
			padding-left: 40px;
		}
		.border3, .border4 {
			background: white;
			text-align: center;
		}
		.responsive {
			width: 100%;
		}
		.logo {
			padding: 20px 0 0 15px;
            text-align: center;
		}
		.logo img {
			max-width: 140px;
		}
		.cand-profile {
			float: right;
			width: 80px;
			height: 80px;
			border-radius: 50%;
		}
		.cand-profile img {
			margin-top: 4px;
			width: 70px;
			border-radius: 50%;
		}
		.icon img {
			max-width: 250px;
			padding: 40px 0 0 0;
		}
		.text {
			padding: 20px 30px 0 30px;
			font-size: 16px;
			line-height: 25px;
			text-align: justify;
			color: #000;
		}
		.text-heading {
			font-weight: bold;
			padding-bottom: 10px;
			text-align: left;
			font-size: 17px;
		}
		.e {
			font-weight: bold;
		}
		.f {
			padding-left: 10px;
		}

		.btn a {
			text-align: center;
			display: inline-block;
			padding: 5px 25px;
			background: #00a0e3;
			border-radius: 5px;
			font-size: 15px;
			color: #fff;
			text-decoration: none;
		}
		.info {
			margin: 30px 0;
		}
		.newlogo {
			text-align: center;
			margin: auto;
			width: 80px;
			height: 80px;
			border-radius: 50%;
			border: 1px solid #eff2f7;
		}
		.newlogo img {
			max-width: 70px;
			max-height: 70px;

		}

		.job-ds {
			font-weight: bold;
			font-size: 16px;
			text-transform: capitalize;
			padding-top: 10px;

		}
		.com-location {
			font-size: 16px;
			text-transform: capitalize;
			padding-top: 10px;
		}
		.interview {
			font-size: 16px;
			text-transform: capitalize;
		}

		.com-skills {
			font-size: 16px;
			text-transform: capitalize;
			padding-top: 10px;
		}

		.salary {
			font-size: 16px;
			text-transform: capitalize;
			padding-top: 10px;
		}

		.btn {
			padding-bottom: 20px;
			padding-top: 20px;
		}

		.text-candd {
			text-align: left;
			font-size: 18px;
			padding-left: 30px;
			padding-top: 20px;
			font-weight: bold;
			color: #00a0e3;
		}

		.text-cand {
			text-align: left;
			font-size: 16px;
			padding-left: 30px;
			padding-top: 10px;
			padding-bottom: 5px;

		}
		.text-cand1 {
			text-align: left;
			font-size: 16px;
			padding-left: 30px;
			padding-bottom: 5px;
		}
		.text-desi {
			text-align: left;
			font-size: 16px;
			padding-left: 30px;
			padding-top: 10px;
		}

		.text-loc {
			text-align: left;
			font-size: 16px;
			padding-left: 30px;
			padding-bottom: 20px;
		}
		.candidate-profile {
			border-top: 2px solid #f8f8f8;
		}

		.job-info {
			margin-top: 20px;
			text-align: left;
			padding: 20px 0 0 30px;
			font-weight: bold;
			font-size: 18px;
			color: #00a0e3;
		}

		.update-text {
			max-width: 250px;
			margin: 0 auto;
			font-size: 13px;
			padding-bottom: 5px;
		}

		.btn1 a {
			text-align: center;
			display: inline-block;
			padding: 5px 25px;
			background: #00a0e3;
			border-radius: 5px;
			font-size: 15px;
			color: #fff;
			text-decoration: none;
		}

		.btn1 {
			padding-bottom: 15px;
			padding-top: 5px;
		}

		.int-rounds {
			border-top: 2px solid #f8f8f8;
		}

		.interv {
			font-weight: bold;
			font-size: 18px;
			color: #00a0e3;
			padding-top: 10px;
		}

		.round1 {
			margin: -10px 0 -4px 29px;
			width: 50px;
			height: 50px;
			border-radius: 50%;
			border: 2px solid #00a0e3;
			background-color: #00a0e3;
			display: inline-block;
			text-align: center;
			overflow: hidden;
		}

		.round1 img {
			max-width: 30px;
			max-height: 30px;
			margin-top: 10px;
		}

		.rnd-list ul li {
			list-style: none;
			padding: 3px 0px;
			border: #b9c5ce;
			position: relative;
		}

		.rnd-list ul {
			text-align: left;
			padding: 3px 10px;
		}

		.round1text {
			font-weight: bold;
			font-size: 16px;
			display: inline-block;
			margin-bottom: 18px;
			margin-left: 5px;
			vertical-align: text-bottom;

		}
		.line {
			display: inline-block;
			padding-left: 27px;
		}
		.line img {
			height: 54px;
			width: 3px;
		}
		.line img {
			height: 47px;
			width: 3px;
		}
		.bg-color {
			background-color: white;
		}
		.clear {
			clear: both;
		}
		.text-center {
            text-align: center;
            padding: 20px 0;
            width: 100%;
        }
        

        .ey-team {
            padding: 20px 0 0 0;
        }

        .ey-team img {
            max-width: 220px;
        }

        .copyright {
            padding: 0px 0 0 0;
            font-size: 13px;
        }

        .last-list {
            padding: 0px 0 10px 0;
            font-size: 13px;
        }

        .last-list ul {
            padding-inline-start: 10px;
        }

        .last-list ul li {
            list-style-type: none;
            display: inline;
            padding: 15px 5px;
        }

        .last-list ul li a {
            color: #00a0e3;
            text-decoration: none;
        }
", ['media' => 'screen']);
$this->registerCss('
@media only screen and (max-width:500px ){
    .text {
        padding: 20px 30px 0 30px;
    } 
    .comp {
        padding: 20px 30px 0 30px;
    }
}
', ['media' => 'only screen and (max-device-width: 500px)']);
$this->registerCss('
    @media (max-width: 450px) {
        .cand-profile {
            width: 45px;
            height: 45px;
            top: 22%;
        }

        .cand-profile img {
            width: 45px;
            height: 45px;
        }

        .logo img {
            max-width: 120px;
        }

        .job-ds {
            position: relative;
            left: 0px;
            font-size: 15px;
        }

        .text {
            font-size: 15px;
        }
        .job-info {
            text-align: center;
            padding-right: 30px;
            font-size: 16px;
        }

        .com-location {
            position: relative;
            left: 0px;
            padding: 10px 0 0 0;
            font-size: 15px;
        }

        .newlogo {
            margin: 20px auto;
        }

        .com-skills {
            position: relative;
            left: 0px;
            font-size: 15px;
        }

        .interview {
            position: relative;
            left: 0px;
            font-size: 15px;
        }

        .salary {
            position: relative;
            left: 0px;
            font-size: 15px;
        }

        .text-candd {
            text-align: center;
            padding-right: 30px;
            font-size: 16px;
        }

        .text-desi, .text-cand, .text-cand1, .text-loc {
            text-align: center;
            padding-right: 30px;
            font-size: 15px;
        }
        .newlogo {
            width: 65px;
            height: 65px;
        }
        .newlogo img {
            max-width: 60px;
            max-height: 60px;
        }
    }
', ['media' => 'only screen and (max-device-width: 450px)']);
?>
<div class="wrapper">
    <div class="position-relative">
        <div class="logo">
            <a href="/"><img src="<?= Url::to('/assets/themes/email/campus-ambassador/images/email-logo.png', 'https');?>" class="responsive"></a>
        </div>
        <div class="clear"></div>
    </div>
    <div class="new-img-set"><img src="<?= Url::to('/assets/themes/email/candidate-applied/shortlisticon.png', 'https');?>"></div>
    <div class="border2">
        <div class="text">
            <div class="text-heading">Hi kulwinder</div>
            <span>Congratulations! You have been shortlisted for<span class="e"> (position)</span> role at the<span
                        class="e"> (company)</span>.
			We would like to inform you for an interview at their office.You will meet with
			<span class="e">(Interviewer name and position)</span> and discuss the position’s responsibility and
			learn about their company. Company’s address is mentioned below with the
			name of the interviewer.</span>
        </div>

        <div class="job-info">Job Information</div>
        <div class="info">
            <div class="part">
                <div class="newlogo"><img src="<?= Url::to('/assets/themes/email/user-applied/vsc.png', 'https');?>"></div>
                <div class="job-ds">Junior web Developer</div>
            </div>
            <div class="part2">
                <div class="com-location">
                    <img src="<?= Url::to('/assets/themes/email/candidate-applied/location1.png', 'https');?>" height="15px" width="15px">
                    <span class="f">Ludhiana</span>
                </div>
                <div class="com-skills">
                    <img src="<?= Url::to('/assets/themes/email/candidate-applied/skills.png', 'https');?>" height="15px" width="15px">
                    <span class="f">Php, Css, Html, Bootstrap.</span>
                </div>
                <div class="salary">
                    <img src="<?= Url::to('/assets/themes/email/candidate-applied/salary.png', 'https');?>" height="16px" width="14px">
                    <span class="f">₹ 96000 - ₹ 120000 p.a.</span>
                </div>
            </div>
        </div>

        <div class="border3">
            <div class="int-rounds">
                <div class="interv">Interview Rounds</div>
                <div class="rnd-list">
                    <ul>
                        <li>
                            <div class="round1"><img src="<?= Url::to('/assets/themes/email/candidate-applied/icon5.png', 'https');?>"></div>
                            <div class="round1text">Get Applications</div>
                            <div class="liner">
                                <div class="line">
                                    <img src="<?= Url::to('/assets/themes/email/candidate-applied/line.png', 'https');?>">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="round1">
                                <img src="<?= Url::to('/assets/themes/email/candidate-applied/icon1.png', 'https');?>">
                            </div>
                            <div class="round1text">Personal Interview</div>
                            <div class="liner">
                                <div class="line">
                                    <img src="<?= Url::to('/assets/themes/email/candidate-applied/line.png', 'https');?>">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="round1 bg-color">
                                <img src="<?= Url::to('/assets/themes/email/candidate-applied/icon33.png', 'https');?>">
                            </div>
                            <div class="round1text">Technical Interview</div>
                            <div class="liner">
                                <div class="line">
                                    <img src="<?= Url::to('/assets/themes/email/candidate-applied/gray-line.png', 'https');?>">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="round1 bg-color">
                                <img src="<?= Url::to('/assets/themes/email/candidate-applied/icon44.png', 'https');?>">
                            </div>
                            <div class="round1text">Group Discussion</div>
                            <div class="liner">
                                <div class="line">
                                    <img src="<?= Url::to('/assets/themes/email/candidate-applied/gray-line.png', 'https');?>">
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="round1 bg-color">
                                <img src="<?= Url::to('/assets/themes/email/candidate-applied/icon22.png', 'https');?>">
                            </div>
                            <div class="round1text">Hire Applicants</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border4">
            <div class="candidate-profile">
                <div class="text-candd">Your Current Information</div>

                <div class="text-desi">
                    <span class="e"> Web Developer</span>
                </div>

                <div class="text-cand">
                    <img src="<?= Url::to('/assets/themes/email/candidate-applied/jobexxx.png', 'https');?>" height="16px" width="14px">
                    <span class="f">2year</span>
                </div>

                <div class="text-cand1">
                    <img src="<?= Url::to('/assets/themes/email/candidate-applied/skills.png', 'https');?>" height="16px" width="14px">
                    <span class="f">Html, Css, Php</span>
                </div>
                <div class="text-loc">
                    <img src="<?= Url::to('/assets/themes/email/candidate-applied/interviewlocation.png', 'https');?>" height="15px" width="15px">
                    <span class="f">Ludhiana</span>
                </div>
                <div class="update-text">Note: If your profile is not up to date, update it by clicking the button
                    below
                </div>
                <div class="btn1"><a href="#">Update Profile</a></div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <div class="ey-team">
            <img src="<?= Url::to('@commonAssets/email_service/email-eyteam.png', 'https'); ?>"/>
        </div>
        <div class="copyright">
            <div class="">Copyright © 2019 Empower Youth</div>
        </div>
        <div class="last-list">
            <ul>
                <li><a href="<?= Url::to('/contact-us', true) ?>">Contact Us</a></li>
                |
                <li><a href="<?= Url::to('/terms-conditions', true) ?>">Terms and Conditions</a></li>
                |
                <li><a href="<?= Url::to('/privacy-policy', true) ?>">Privacy Policies</a></li>
            </ul>
        </div>
    </div>

</div>