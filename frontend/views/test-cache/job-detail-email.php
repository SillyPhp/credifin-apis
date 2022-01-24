<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCss('
    body{
	margin:0 auto; 
	padding:0;
	font-family: \'Open Sans\', sans-serif;
}
.responsive{
	width:100%;	
}
img + div {
	display:none;
}
.wrapper{
	max-width:600px;
	margin:0 auto;
}
.wrapper-header{
	background:url(images/wrapper-header-bg.png);
	background-size:cover;
	padding:30px 0;
	text-align:center;
}
.job-title{
	color:#fff;
	padding:10px 0 0 0;
	font-size:25px;
	font-weight:bold;
	text-transform:capitalize;
}
.job-icon img{
	max-width:250px;
}

.logo-box {
    height: 125px;
    width: 125px;
    border-radius: 50%;
    background: #fff;
    overflow: hidden;
    margin: 10px 20px 0;
    text-align: center;
    border: 2px solid #eee;
    position: relative;
}
.logo-box img {
    width: 100px;
    height: 125px;
    object-fit: contain;
}
.width-60{
	float:left;
	width:70%;	
}
.width-40{
	width:30%;
	float:left;	
}
.com-name {
    font-size: 18px;
    padding: 10px 0 0 20px;
    text-align: left;
}

.com-establish span{
	font-weight:bold;	
}
.job-overview {
	float: left;
	width: 100%;
}
.job-overview ul li{
	list-style-type:none;
	text-align:center;
    border: 1px solid #eee;
	margin:5px 10px;
}
.job-overview ul > li, .interview ul > li{
	float: left;
	width:31%;
	margin: 0;
	position: relative;
	margin: 8px 5px;
	min-height: 68px;
	padding: 10px 0;
}
.job-overview ul > li img, .interview ul > li img {
	/*position: absolute;*/
	left: -40px;
	top: 5px;
	font-size: 30px;
	color: #4aa1e3;
}
.job-overview ul li h3, .interview ul li h3 {
	float: left;
	width: 100%;
	font-size: 13px;
	font-family: Open Sans;
	margin: 0;
	color: #1e1e1e;
	font-weight: 600;
}
.job-overview ul > li span, .interview ul > li span {
    float: left;
    word-break: break-all;
    width: 100%;
    font-size: 13px;
    color: #545454;
    margin-top: 4px;
    min-height: 38px;
}
.job-overview ul {
	float: left;
	/*border: 2px solid #e8ecec;*/
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	-ms-border-radius: 8px;
	-o-border-radius: 8px;
	border-radius: 8px;
	margin: 0;
	padding-inline-start: 10px;
}
.jo-heading {
    padding: 20px 10px 0px 20px;
    font-size: 20px;
    font-weight: 500;
    margin-bottom:15px;
}
/*-----job-description-----*/
.job-description{
	float:left;
	padding-top:10px;
}
.job-description li {
	float: left;
	width: 100%;
	font-size: 13px;
	color: #000;
	line-height: 24px;
	margin: 0;
	margin-bottom: 19px;
}
.job-description > ul, .education > ul {
	float: left;
	margin-bottom: 20px;
	padding-inline-start: 40px;
	max-width:600px;
}
.job-description > ul li, .education > ul li {
	float: left;
	width: 100%;
	margin: 0;
	list-style-type:square;
	margin-bottom: 0px;
	line-height: 21px;
	margin-bottom: 10px;
	font-size: 14px;
	color: #000;
}

.interview ul li{
	list-style-type:none;
	text-align:center;
	margin:5px 0px;
}
.education{
	width:100%;
	float:left;	
}	
.interview{
	width:100%;
	float:left;
}
.interview ul{
	padding-inline-start: 10px;	
}
.interview ul > li{
	width:100%;
	padding:0;
	text-align:left;
	display:flex;
}
.skills{
	float:left;
	width:100%;	
}
.skills ul {
    padding-inline-start: 10px;
    border: 2px solid #eee;
    margin: 0 20px;
    padding: 5px;
    border-radius: 8px;
}
.skills ul li{
	list-style-type:none;
	background:#EEEEEE;
	display:inline-block;
	padding:5px 10px;
	border-radius:4px;
	margin:5px; 
}
.week-days{
	float:left;	
}
.week-days ul{
	padding-inline-start: 10px;	
}
.week-days ul li{
  position:relative;
  list-style:none;
  display:inline-block;
  width:100px;
  height:100px;
  line-height:100px;
  text-align:center;
  margin-right:8px;
  margin-bottom:10px;
  background-color:#fff !important;
  background-image:none;
  border:1px solid #ddd;
  color:#000;
}
.week-days ul li.active{
  color:#fff;
  background-color: #35394F; 
  background-image: linear-gradient(-40deg, #35394F 25%, #787D90);
  border:1px solid #ddd;
}
.week-days ul li h2{
  line-height:100px;
  margin:0px;
}
.working-hours{
	float:left;
	width:100%;
	margin: 0 auto;
	margin-top: 0px;
	margin-bottom:30px;
	text-align: center;
}
.time-bar-inner{
	height: 35px;
	line-height: 35px;
	border-radius: 35px;
	padding: 4px;
	background-color: #EE7436; 
	background-image: linear-gradient(-40deg, #EA5768, #EE7436 90%);
	border:5px solid #D9DADA;
	color: #fff;
	font-weight: 600;
	font-size: 20px;
	margin:0 10px;
}
.working-time-from{
	width: 15%;
	float: left;
	background-color: #fff;
	color: #EE7436;
	border-radius: 35px;
}
.working-time-to{
	width: 15%;
	float: right;
	background-color: #fff;
	color: #EE7436;
	border-radius: 35px;
}
.working-time-title{
	width: 70%;
	float: left;
}
.emp-benefits{
	float:left;	
	width:100%;
}
.benefit-box{
	width: 26%;
	min-height:105px;
    text-align: center;
    border: 1px solid rgba(221, 216, 216, 0.1);
    padding: 25px 12px;
    margin: 10px 8px 15px 8px;
    float: left;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.5);
}
.bb-icon img{
    width:50px;
    height:50px;
}
.bb-text{
    padding-top:10px;
    text-transform:uppercase;
    font-size:13px;
}
.b-boxs{
	padding:0 10px;
}
/*----apply btn-----*/
.applyBtn{
	float:left;
	text-align:center;
	margin:0 auto;
	width:100%;
	margin-bottom:40px;
}	
.btn-center{
	text-align:center;
	margin:0 auto;		
}
.applyBtn a {
    text-align: center;
    color: #fff;
    font-size: 14px;
    display: inline-block;
    background: #00a0e3;
    padding: 10px 25px;
    text-decoration: none;
    text-transform: uppercase;
    border-radius: 5px;
    width: 80px;
}
@media screen and (max-width:500px ){
	.job-overview ul > li {
		float: left;
		width:46%;
		margin: 0;
		position: relative;
		margin: 8px 5px;
		min-height: 68px;
		padding: 10px 0;
	}
	.benefit-box{
		width: 40%;
		min-height:105px;
		text-align: center;
		border: 1px solid rgba(221, 216, 216, 0.1);
		padding: 25px 10px;
		margin: 10px 8px 15px 8px;
		float: left;
		box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.5);
	}	
}
@media screen and (max-width:400px){
	.benefit-box{
		width: 90%;
		min-height:105px;
		text-align: center;
		border: 1px solid rgba(221, 216, 216, 0.1);
		padding: 25px 10px;
		margin: 10px 8px 15px 8px;
		float: left;
		box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.5);
	}	
}
@media screen and (max-width:380px ){
	.job-overview ul > li {
		float: left;
		width:95%;
		margin: 0;
		position: relative;
		margin: 8px 5px;
		min-height: 68px;
		padding: 10px 0;
	}	
	.education{
		width:100%;
		float:left;	
	}	
	.interview{
		width:100%;
		float:left;
	}
	.working-time-title {
		width: 50%;
		float: left;
		font-size: 15px;
	}
	.working-time-from {
		width: 25%;
		float: left;
		background-color: #fff;
		color: #EE7436;
		border-radius: 35px;
	}
	.working-time-to {
		width: 25%;
		float: right;
		background-color: #fff;
		color: #EE7436;
		border-radius: 35px;
	}
	.job-description > ul li, .education > ul li{
		width: 95%;		
	}
	
}
.logo-cmp {
    text-align: left;
    padding: 20px;
    background-color: #E2ECFD;
    width: 100%;
}
.logo-cmp img {
    width: 155px;
}
.footer {
    background-color: #E2ECFD;
    padding: 20px;
    width: 100%;
    float: left;
}
	.web-social a {
		margin: 0 5px;
		display: inline-block;
		width: 30px;
		height: 30px;
	}
	.web-social {
	    text-align: center;
	}
	.web-social a img {
		width: 29px;
	}
	.emal-contact {
		text-align: center;
		padding: 20px 0;
	}
	.emal-contact a {
	    color: #000;
	    text-decoration: none;
	    font-weight: bold;
	    display: inline-block;
	    margin: 0 20px;
	    font-size: 16px;
	}
	.ey-team img {
	    width: 160px;
	}
	.ey-team {
	    margin: 0 20px;
	    text-align: center;
	    padding: 0px 0px 5px;
	}
	.ey-team p {
	    color: #000;
	    font-weight: bold;
	    margin: 6px 0;
	}
');
?>

<?php

if (!empty($data['applicationPlacementLocations'])) {
    $location = ArrayHelper::map($data['applicationPlacementLocations'], 'city_enc_id', 'name');

    $total_vac = 0;
    $str = "";
    $locations = [];

    foreach ($data['applicationPlacementLocations'] as $placements) {
        $total_vac += $placements['positions'];
        array_push($locations, $placements['name']);
    }

    $str = implode(", ", array_unique($locations));
}

?>

<div class="wrapper">
    <div class="logo-cmp">
        <img src="https://www.empoweryouth.com/assets/themes/email/images/zpBn4vYx2RmKpNExaDvPdJg3Aq9Vyl.png">
    </div>
    <div class="wrapper-header">
        <div class="job-icon">
            <img src="<?= Url::to('@commonAssets/categories/' . $data['profile_icon']); ?>"
                 class="responsive">
        </div>
        <div class="job-title"><?= $data['name']; ?></div>
    </div>
    <div class="com-heading">
        <div class="jo-heading">Employer Details</div>
        <div class="logo-box">
            <?php
            $data['organization_logo'] = "@commonAssets/categories/" . $data['profile_icon'];
            $data['organization_name'] = "RV Digital HUB";
            ?>
            <img src="<?= Url::to($data['organization_logo']); ?>">
        </div>
        <div class="com-details">
            <div class="com-name"><?= $data['organization_name']; ?></div>
        </div>
    </div>

    <div class="job-overview">
        <div class="jo-heading"><?= $data['application_type']; ?> Overview</div>
        <ul>
            <?php if ($data['name']): ?>
                <li>
                    <img src="<?= Url::to('@commonAssets/email_service/puzzle_piece.png'); ?>">
                    <h3>Profile</h3>
                    <span><?= $data['name']; ?></span>
                </li>
            <?php endif; ?>
            <?php if ($data['industry']): ?>
                <li>
                    <img src="<?= Url::to('@commonAssets/email_service/puzzle_piece.png'); ?>">
                    <h3>Preferred Industry</h3>
                    <span><?= $data['industry']; ?></span>
                </li>
            <?php endif; ?>
            <?php if ($data['designation']): ?>
                <li>
                    <img src="<?= Url::to('@commonAssets/email_service/pin.png'); ?>">
                    <h3>Designation</h3>
                    <span><?= $data['designation']; ?></span>
                </li>
            <?php endif; ?>
            <?php if ($data['type']): ?>
                <li>
                    <img src="<?= Url::to('@commonAssets/email_service/suitcase.png'); ?>">
                    <h3>Job Type</h3>
                    <span><?= $data['type']; ?></span>
                </li>
            <?php endif; ?>
            <?php if ($data['amount']): ?>
                <li>
                    <img src="<?= Url::to('@commonAssets/email_service/money.png'); ?>">
                    <h3><?= ($data['application_type'] == 'Job') ? 'Offered Salary' : 'Offered Stipend'; ?></h3>
                    <span><?= $data['amount']; ?></span>
                </li>
            <?php endif; ?>
            <li>
                <img src="<?= Url::to('@commonAssets/email_service/gender.png'); ?>">
                <h3>Gender</h3>
                <span>
                        <?php
                        switch ($data['preferred_gender']) {
                            case 0:
                                echo 'No Preference';
                                break;
                            case 1:
                                echo 'Male';
                                break;
                            case 2:
                                echo 'Female';
                                break;
                            case 3:
                                echo 'Transgender';
                                break;
                            default:
                                echo 'No Preference';
                        }
                        ?>
                    </span>
            </li>
            <?php if ($data['experience']): ?>
                <li>
                    <img src="<?= Url::to('@commonAssets/email_service/watch.png'); ?>">
                    <h3>Experience</h3>
                    <span><?= $data['experience']; ?></span>
                </li>
            <?php endif; ?>
            <?php if ($total_vac): ?>
                <li>
                    <img src="<?= Url::to('@commonAssets/email_service/line-chart.png'); ?>">
                    <h3>Total Vacancies</h3>
                    <span><?= (($total_vac) ? $total_vac : 'Not Applicable'); ?></span>
                </li>
            <?php endif; ?>
            <li>
                <img src="<?= Url::to('@commonAssets/email_service/location.png'); ?>">
                <h3>Locations</h3>
                <span>
                        <?php
                        echo(($str) ? rtrim($str, ',') : 'Work From Home');
                        ?>
                    </span>
            </li>
        </ul>
    </div>
    <?php
    $benefits = $data['applicationEmployeeBenefits'];
    if (!empty($benefits)): ?>
        <div class="emp-benefits">
            <div class="jo-heading">Employee Benefits</div>
            <?php
            $rows = ceil(count($benefits) / 3);
            $next = 0;
            for ($i = 0; $i < $rows; $i++) {
                ?>
                <div class="b-boxs">
                    <?php
                    for ($j = 0; $j < 3; $j++) {
                        if (!empty($benefits[$next]['benefit'])):
                            ?>
                            <div class="benefit-box">
                                <div class="bb-icon">
                                    <img src="<?= Url::to('@commonAssets/email_service/location.png/flexible_hour.svg'); ?>">
                                </div>
                                <div class="bb-text">
                                    <?= $benefits[$next]['benefit']; ?>
                                </div>
                            </div>
                        <?php
                        endif;
                        $next++;
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
    <?php endif; ?>
    <div class="job-description">
        <div class="jo-heading"><?= $data['application_type']; ?> Description</div>
        <ul>
            <?php
            foreach ($data['applicationJobDescriptions'] as $description) {
                ?>
                <li><?= ucwords($description['job_description']); ?></li>
            <?php } ?>
        </ul>
    </div>
    <div class="skills">
        <div class="jo-heading">Required Knowledge, Skills, and Abilities</div>
        <ul>
            <?php
            foreach ($data['applicationSkills'] as $skill) {
                ?>
                <li><?= ucwords($skill['skill']); ?></li>
            <?php } ?>
        </ul>
    </div>
    <div class="edu-interview">
        <div class="education">
            <div class="jo-heading">Education</div>
            <ul>
                <?php
                foreach ($data['applicationEducationalRequirements'] as $qualification) {
                    ?>
                    <li><?= ucwords($qualification['educational_requirement']); ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="week-days">
        <div class="jo-heading">Working Days</div>
        <ul>
            <?php
            $working_days = $data['working_days'];
            if (empty($working_days)) {
                $working_days = [1, 2, 3, 4, 5];
                $working_days = json_encode($working_days);
            }
            $working_days_data = json_decode($working_days);
            if (in_array(1, $working_days_data)):
                ?>
                <li class="active">
                    <span>Monday</span>
                </li>
            <?php endif; ?>
            <?php if (in_array(2, $working_days_data)): ?>
                <li class="active">
                    <span>Tuesday</span>
                </li>
            <?php endif; ?>
            <?php if (in_array(3, $working_days_data)): ?>
                <li class="active">
                    <span>Wednesday</span>
                </li>
            <?php endif; ?>
            <?php if (in_array(4, $working_days_data)): ?>
                <li class="active">
                    <span>Thursday</span>
                </li>
            <?php endif; ?>
            <?php if (in_array(5, $working_days_data)): ?>
                <li class="active">
                    <span>Friday</span>
                </li>
            <?php endif; ?>
            <?php if (in_array(6, $working_days_data)): ?>
                <li class="active">
                    <span>Saturday</span>
                </li>
            <?php endif; ?>
            <?php if (in_array(7, $working_days_data)): ?>
                <li class="active">
                    <span>Sunday</span>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="working-hours">
        <div class="time-bar-inner">
            <div class="working-time-from">
                <?= date('H:i', strtotime($data['timings_from'])); ?>
            </div>
            <div class="working-time-title">
                Working Hours
            </div>
            <div class="working-time-to">
                <?= date('H:i', strtotime($data['timings_from'])); ?>
            </div>
        </div>
    </div>
    <div class="interview">
        <div class="jo-heading">Interview Details</div>
        <ul>
            <li>
                <div>
                    <img src="<?= Url::to('@commonAssets/email_service/location.png/location.png'); ?>">
                </div>
                <div><h3>Interview Locations</h3>
                    <span>
                            <?php
                            $interview_locations = $data['applicationInterviewLocations'];
                            if (!empty($interview_locations)) {
                                $str2 = "";
                                $locations = [];
                                foreach ($interview_locations as $loc) {
                                    array_push($locations, $loc['name']);
                                }
                                $str2 = implode(", ", $locations);
                                echo rtrim($str2, ',');
                            } else {
                                echo 'Online/Skype/Telephonic';
                            }
                            ?>
                        </span>
                </div>
            </li>
        </ul>
    </div>
    <div class="applyBtn">
        <div class="btn-center">
            <?= Html::a(Yii::t('app', 'Apply'), Url::to(Yii::$app->textTransformation->toLower($data['application_type']) . '/' . $data['slug'],'https')); ?>
            <?= Html::a(Yii::t('app', 'View '), Url::to(Yii::$app->textTransformation->toLower($data['application_type']) . '/' . $data['slug'],'https')); ?>
        </div>
    </div>
    <div class="footer">
        <div class="web-social">
            <a href="https://www.facebook.com/empower/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/Nxj6lKYbJdDjEJYOMWeBRvg5VrAZ3y.png"></a>
            <a href="https://www.linkedin.com/company/empoweryouth/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/MXOy576jYoKjLAZ4Gr3lRKlw1eWDnG.png"></a>
            <a href="https://twitter.com/EmpowerYouthin" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/v8rXbWDwJoBk4wAkOWObdKkl25YEpO.png"></a>
            <a href="https://www.instagram.com/empoweryouth.in/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/yVgawN7rxoLj40DqPn94QYOM5kelbv.png"></a>
        </div>
        <div class="emal-contact">
            <a href="mailto:info@empoweryouth.com" class="mail">Email: info@empoweryouth.com</a>
            <a href="tel:7814871632">Contact Us: +91 7814871632</a>
        </div>
        <div class="ey-team">
            <a href="https://www.empoweryouth.com/">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/DeBxPEjOGdjymqkD7DqBopqANyVYw9.png">
            </a>
            <p>Copyright © <?= date('Y') ?> Empower Youth</p>
        </div>
    </div>
</div>