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
.ld-color {
    color: #00a0e3;
    font-weight: bold;
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
.content, .rejects-you, .bestwish {
	padding: 5px 20px 5px;
    background-color: #fff;
    border-radius: 8px;
}
.rejects-you h2, .footer-content h3 {
	text-align: center;
}
.content p, .rejects-you p, .bestwish p {
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
.similar-job {
    margin: 10px auto;
    padding: 2px 10px;
    background-color: #f5f5f5;
    border-radius: 8px;
    border: 2px solid #00a0e3;
    display: flex;
    align-items: center;
    max-width: 350px;
    min-width: 350px;
}
.sim-job-img {
    min-width: 70px;
    width: 70px;
    display: inline-block;
    height: auto;
    margin-right: 25px;
}
.sim-job-img img {
    width: 100%;
    padding-top: 4px;
}
.sim-job-details {
    padding: 5px 0px;
}
.sim-job-details p 
    {
    font-size: 14px;
    text-align: justify;
    color: #000;
    font-family: 'Roboto', sans-serif;
    margin-top: 0px;
    margin-bottom: 4px;
}
.ld-headings{
    font-weight: bold;
}
.apply {
    margin-top: 10px;
}
.apply-btn {
    border: 1px solid #00a0e3;
    background-color: #00a0e3;
    color: #fff !important;
    text-decoration: none;
    padding: 4px 30px;
    display: inline-block;
    border-radius: 4px;
    text-decoration: none;
    transition: 0.3s ease-in-out;
    cursor: pointer;
}
.apply-btn:hover {
    color: #00a0e3 !important;
    background-color: #fff;
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
        <div class="rejects-you">
            <h2>We really appreciate that you have considered [Company_name]</h2>
            <p>We'd like to inorm you that <span class="darktext">we are not able to advance you to the next round </span> for the [Job_title] position at this time.</p>
        </div>
        <div class="job-img">
            <img src="https://www.empoweryouth.com/assets/themes/email/images/6mMpL8zN9QqG9KeNwlbkoAxKOrBbnw.png">
        </div>
        <div class="content">
            <p>We appreciate all your efforts but the skill set that you have does not fit well with this job role. Below, <span class="darktext">keeping your skill set in mind</span>, we are listing some <span class="darktext">similar jobs where you can apply</span>.</p>
        </div>
        <div class="similar-job">
            <div class="sim-job-img">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/G8nxNmgE3o4nrGgGzwpyQWVybejKkz.png">
            </div>
            <div class="sim-job-details">
                <p><span class="ld-headings"> Web Designer</span></p>
                <p><span class="ld-color">ABC company</span></p>
                <p>Rs.1,00,000 - Rs.3,00,000</p>
                <p>Full Time</p>
                <div class="apply">
                    <a href="#"><p class="apply-btn">Apply</p></a>
                </div>

            </div>
        </div>
        <div class="similar-job">
            <div class="sim-job-img">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/G8nxNmgE3o4nrGgGzwpyQWVybejKkz.png">
            </div>
            <div class="sim-job-details">
                <p><span class="ld-headings"> Web Designer</span></p>
                <p><span class="ld-color">ABC company</span></p>
                <p>Rs.1,00,000 - Rs.3,00,000</p>
                <p>Full Time</p>
                <div class="apply">
                    <a href="#"><p class="apply-btn">Apply</p></a>
                </div>
            </div>
        </div>
        <div class="similar-job">
            <div class="sim-job-img">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/G8nxNmgE3o4nrGgGzwpyQWVybejKkz.png">
            </div>
            <div class="sim-job-details">
                <p><span class="ld-headings"> Web Designer</span></p>
                <p><span class="ld-color">ABC company</span></p>
                <p>Rs.1,00,000 - Rs.3,00,000</p>
                <p>Full Time</p>
                <div class="apply">
                    <a href="#"><p class="apply-btn">Apply</p></a>
                </div>
            </div>
        </div>
        <div class="bestwish">
            <p><span class="darktext">Good Luck for your future endeavors!!</span></p>
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