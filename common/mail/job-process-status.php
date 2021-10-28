<?php
$this->registerCss("
img + div{
    display: none;
}
.darktext {
    font-weight: bold;
}
.job-status-main {
			max-width: 650px;
		    margin: auto;
		    background-color: #fff;
		    border-radius: 6px;
		    font-family: arial;
		    overflow: hidden;
		}
		.logo {
		    text-align: left;
		    padding: 20px;
		    background-color: #e2ecfd;
		}
		.logo img {
		    width: 155px;
		}
		.job-status h3 {
		    text-align: center;
		    color: #000;
                    font-weight: bold;
		    padding: 0px 10px;
		}
		.job-status p,.status-bar {
		    font-size: 20px;
		    color: #46b527;
		    text-align: center;
		    font-weight: bold;
		    padding: 5px
		}
		.content {
		    padding: 5px 20px 0;
		}
		.content p {
	       line-height: 22px;
	       text-align: justify;
	       color: #000;
	    }
		.job-img {
		    text-align: center;
		    padding: 20px;
		}
		.job-img img {
		    width: 100%;
		    max-width: 200px;
		}
		.track, .fill {
    		text-align: center;
    		padding-bottom: 20px;
		}
		.track-btn {
	   		border: 1px solid #00a0e3;
	    	background-color: #00a0e3;
	        color: #fff !important;
	        text-decoration: none;
	        padding: 8px 20px;
	        display: inline-block;
	        border-radius: 4px;
	        text-decoration: none;
	        transition: 0.3s ease-in-out;
	    }
	    .track-btn:hover {
	        color: #00a0e3 !important;
	        background-color: #fff;
	    }
		.fill-btn {
	   		border: 1px solid #f9bd21;
	    	background-color: #f9bd21;
	        color: #fff !important;
	        text-decoration: none;
	        padding: 8px 32px;
	        display: inline-block;
	        border-radius: 4px;
	        text-decoration: none;
	        transition: 0.3s ease-in-out;
	    }
	    .fill-btn:hover {
	        color: #f9bd21 !important;
	        background-color: #fff;
	    }
		.footer {
	    background-color: #e2ecfd;;
	    padding: 20px;
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
		    margin: 0 34px;
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
		.appstore {
		    font-weight: 600;
		    font-size: 16px;
		    font-family: lora;
		    padding-top: 15px;
		    text-align: center;
		    color: #000;
	  	}
	  	.appss img
	  	{
			height: 50px;
			width: 110px;
	  	}
");
?>
<div class="job-status-main">
    <div class="logo">
        <img src="https://www.empoweryouth.com/assets/themes/email/images/zpBn4vYx2RmKpNExaDvPdJg3Aq9Vyl.png">
    </div>
    <div class="job-status">
        <h3>Job Application Status</h3>
        <p>Application Has Been Accepted!!</p>
    </div>
    <div class="job-img">
        <img src="https://www.empoweryouth.com/assets/themes/email/images/Nxj6lKYbJdDjmXZwmb1BRvg5VrAZ3y.png">
    </div>
    <div class="content">
        <p>Dear <?= $data['name'] ?>,</p>
        <p>We are happy to inform you that you have been selected for the<span class="darktext"> <?= $data['round_name'] ?></span> round for <span class="darktext"><?= $data['job_title'] ?></span> in <span class="darktext"><?= $data['company'] ?></span>. Please give your consent regarding the same as soon as possible as we are eagerly waiting for your response.</p>
        <p>Track your application by clicking the button below</p>
    </div>
    <div class="track">
        <a href="https://www.empoweryouth.com/account/process-applications/<?= $data['applied_id'] ?>" class="track-btn">Track Your Application</a>
    </div>
    <?php if ($data['questionniare_enc_id']): ?>
    <div class="content">
        <p>Also Note That You Have Some Pending Questionnaire Please Fill Up Before Apearing To Personal Interview</p>
    </div>
        <div class="fill">
        <a href="https://www.empoweryouth.com/account/questionnaire/fill-questionnaire/<?= $data['questionniare_enc_id'] ?>/<?= $data['applied_id'] ?>" class="fill-btn">Fill Questionnaire</a>
    </div>
    <?php endif; ?>
    <div class="footer">
        <div class="web-social">
            <a href="https://www.facebook.com/empower/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/Nxj6lKYbJdDjEJYOMWeBRvg5VrAZ3y.png"></a>
            <a href="https://www.linkedin.com/company/empoweryouth/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/MXOy576jYoKjLAZ4Gr3lRKlw1eWDnG.png"></a>
            <a href="https://twitter.com/EmpowerYouthin" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/v8rXbWDwJoBk4wAkOWObdKkl25YEpO.png"></a>
            <a href="https://www.instagram.com/empoweryouth.in/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/yVgawN7rxoLj40DqPn94QYOM5kelbv.png"></a>
        </div>
        <div class="appstore">Download Our App
            <div class="appss">
                <a href="https://play.google.com/store/apps/details?id=com.empoweryouth.app" title="Get it on Google Play" target="_blank">
                    <img alt="Get it on Google Play" src="https://play.google.com/intl/en/badges/images/generic/en_badge_web_generic.png" title="Download Empower Youth App on Google Play">
                </a>
            </div>
        </div>
        <div class="emal-contact">
            <a href="mailto:info@empoweryouth.com" class="mail">Email: info@empoweryouth.com</a>
            <a href="tel:7814871632">Contact Us: +91 7814871632</a>
        </div>
        <div class="ey-team">
            <a href="https://www.empoweryouth.com/">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/DeBxPEjOGdjymqkD7DqBopqANyVYw9.png">
            </a>
            <p>Copyright © 2019 Empower Youth</p>
        </div>
    </div>
</div>
