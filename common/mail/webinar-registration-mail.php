<?php
$this->registerCss("
img + div{
    display: none;
}
.blue{
	color: #00a0e3;
}
.orange {
	color: #ff7803;
}
.white-bg {
    background-color: #fff;
    margin: 10px;
    border-radius: 4px;
}
.webinar-main {
	background-color: #e2f2f1;
	padding: 2px;
	max-width: 650px;
	margin: auto;
	border-radius: 6px;
	font-family: arial;
	overflow: hidden;
}
.logo {
    padding: 20px;
    text-align: left;
}
.logo img {
	width: 155px;
}
.web-img {
    text-align: center;
    padding: 15px;
}
.web-img img {
    width: 100%;
    max-width: 320px;
}
.content {
    padding: 10px 20px 0;
    text-align: center;
}
.cont {
	text-align: center;
}
.content p, .cont p {
	color: #000;
    line-height: 26px;
    letter-spacing: 0.3px;
    font-size: 16px;
    overflow: hidden;
}
.content li {
	font-size: 14px;
    text-align: justify;
    color: #000;
    font-family: 'Roboto', sans-serif;
    margin-top: 0px;
    margin-bottom: 4px;
}
.webinar {
	margin: 10px auto;
    padding: 2px 10px;
    background-color: #e2f2f1;
    border-radius: 8px;
    border: 3px solid #e2f2f1;
    display: flex;
    align-items: center;
    max-width: 350px;
    min-width: 350px;
}
.webinar-details {
    padding: 5px 0px;
}
.webinar-details p 
    {
    font-size: 14px;
    text-align: justify;
    color: #000;
    font-family: 'Roboto', sans-serif;
    margin-top: 0px;
    margin-bottom: 4px;
}
.wd {
	font-weight: bold;
}
.join-btn {
	padding: 10px 26px;
    font-size: 16px;
    background-color: #00a0e3;
    color: #fff;
    border: 1px solid #00a0e3;
    border-radius: 4px;
    cursor: pointer;
    width: 80px;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 15px;
}
.join-btn:hover {
	background-color: #fff;
	color: #00a0e3;
}
.footer {
	padding: 30px 20px;
	width: 95%;
}
.footer-content p {
    font-size: 16px;
    color: #000;
    text-align: center;
    line-height: 24px;
}
.web-social a {
	margin: 0 5px;
	display: inline-block;
	width: 30px;
	height: 30px;
}
.web-social {
	text-align: center;
	padding-bottom: 15px;
}
.web-social a img {
	width: 29px;
}
.appstore {
	font-weight: 600;
	font-size: 16px;
	font-family: lora;
	text-align: center;
	color: #000;
}
.appss img {
	height: 50px;
	width: 110px;
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
");
?>
<div class="webinar-main">
    <div class="logo">
        <img src="https://www.empoweryouth.com/assets/themes/email/images/qOLw3GDM1RZDDwMENZJxdgjYBra6Ak.png">
    </div>
    <div class="white-bg">
        <div class="web-img">
            <img src="https://www.empoweryouth.com/assets/themes/email/images/rNap3jW8EobD27J5vG5LQB0yYn7GXq.png">
        </div>
        <div class="content">
            <h3>Greetings from <span class="blue">Empower</span><span class="orange">Youth</span></h3>
            <p>You have successfully Registered for the following webinar:</p>
        </div>
        <div class="webinar">
            <div class="webdetails">
                <p> <span class="wd">Webinar Name:</span> <?= $data['title'] ?></p>
                <p> <span class="wd">Speakers:</span> <?= $data['speakers'] ?></p>
                <p> <span class="wd">Time:</span> <?= $data['time'] ?></p>
                <p> <span class="wd">Date:</span><?= $data['date'] ?></p>
            </div>
        </div>
        <div class="cont">
            <p>Please Join the webinar by clicking the button below:</p>
            <a href="<?= $data['link'] ?>" class="join-btn">Join</a>
        </div>
    </div>
    <div class="footer">
        <div class="web-social">
            <a href="https://www.facebook.com/empower/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/Nxj6lKYbJdDjEJYOMWeBRvg5VrAZ3y.png"></a>
            <a href="https://www.linkedin.com/company/empoweryouth/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/VA1npK2MJdJjMB18BWL5drlbjPkBXZ.png"></a>
            <a href="https://twitter.com/EmpowerYouthin" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/w6rmj0npDd2rwZeEjWjldJ8qgNV5KW.png"></a>
            <a href="https://www.instagram.com/empoweryouth.in/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/yVgawN7rxoLWq3vWnEywRYOM5kelbv.png"></a>
        </div>
        <div class="appstore">Download Our App
            <div class="appss">
                <a href="https://play.google.com/store/apps/details?id=com.empoweryouth.app" title="Get it on Google Play" target="_blank">
                    <img alt="Get it on Google Play" src="https://play.google.com/intl/en/badges/images/generic/en_badge_web_generic.png" title="Download Empower Youth App on Google Play">
                </a>
            </div>
        </div>
        <div class="ey-team">
            <a href="https://www.empoweryouth.com/">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/DeBxPEjOGdjymqkD7DqBopqANyVYw9.png">
            </a>
            <p>Copyright © 2021 Empower Youth</p>
        </div>
    </div>
</div>
