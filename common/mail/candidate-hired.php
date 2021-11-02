<?php
$this->registerCss("
img + div{
    display: none;
}
.darktext {
    font-weight: bold;
}
.candidate-hired-main {
	background-color: #00a0e3;
    padding: 10px;
    max-width: 650px;
    margin: auto;
    border-radius: 6px;
    font-family: arial;
    overflow: hidden;
}
.content-bg{
	background-color: #fff;
    border-radius: 8px;
}
.logo {
    padding: 20px;
    text-align: center;
    border-bottom: 4px solid #f7f3f3;
    margin: 0 30px;
}
.logo img {
	width: 155px;
}
.content, .hired-you {
	padding: 5px 20px 5px;
    background-color: #fff;
    border-radius: 8px;
}
.hired-you h2, .footer-content h3 {
	text-align: center;
}
.content p, .hired-you p {
	font-size: 16px;
	line-height: 24px;
	text-align: center;
	color: #000;
}
.job-img {
	text-align: center;
    padding: 20px;
}
.job-img img {
	width: 100%;
	max-width: 220px;
}
.footer {
	padding: 0px 20px 20px;
	border-top: 4px solid #f7f3f3;
    margin: 0 30px;
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
}
.web-social a img {
	width: 29px;
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
.appss img {
	height: 50px;
	width: 110px;
}
.blue{
	color: #00a0e3;
}
.orange {
	color: #ff7803;
}
");
?>
<div class="candidate-hired-main">
    <div class="content-bg">
        <div class="logo">
            <img src="https://www.empoweryouth.com/assets/themes/email/images/zpBn4vYx2RmKpNExaDvPdJg3Aq9Vyl.png">
        </div>
        <div class="hired-you">
            <h2>Comapny's Name, Hired You!</h2>
            <p>We are pleased to inform you that you have been <span class="darktext">hired</span> for <span class="darktext">{job position}</span>.</p>
        </div>
        <div class="job-img">
            <img src="https://www.empoweryouth.com/assets/themes/email/images/v8rXbWDwJoBkKb8Y4K2YdKkl25YEpO.png">
        </div>
        <div class="content">
            <p><span class="darktext">Name</span>, After getting to know you during your interview, we have determined that you would be the best candidate to fill this job! We love how organized you are and your educational background is impeccable.</p>
            <p><span class="darktext">Looking forward to work with you!!</span></p>
        </div>
        <div class="footer">
            <div class="footer-content">
                <p>Thank You for showering us with immense love & support in such a critical situation.</p>
                <h3>At <span class="blue">Empower</span><span class="orange">Youth</span>, We Wish For Your Safety and Good Health!</h3>
            </div>
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
                <p>Copyright © 2019 Empower Youth</p>
            </div>
        </div>
    </div>
</div>
