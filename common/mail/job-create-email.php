<?php
$this->registerCss("
a, h1,h2,h3,h4,h5,h6, p{
			margin: 0;
		}
		img + div  {
    display: none;
}
table{
	width: 100%;
	border-collapse: collapse;
}
.job-created-main {
	max-width: 650px;
	margin: 0 auto;
	border-radius: 6px;
	font-family: arial;
	overflow: hidden;
	background-image: linear-gradient(to top, #accbee 0%, #e7f0fd 100%);
}
.job-mail{
	width: 90%;
	margin: auto;
}
.logo {
	width: 100%;
}
.logo td {
    padding: 20px 20px 0;
    text-align: right;
}
.logo td img {
    width: 155px;
}
.c-text p {
    text-align: center;
    font-size: 18px;
    letter-spacing: 0.3px;
    color: #2a3554;
}
.company-logo{
    width: 80px;
    border-radius: 50%;
}
.job-detail-img {
	margin-right: 5px;
	display: inline-block;
}
.job-detail-img img {
	max-width: 16px;
}
.job-detail td p {
    font-size: 13px;
    margin-top: -4px;
    line-height: 26px;
    display: inline-block;
}
.job-detail td h4{
    font-size: 16px;
    margin-bottom: 5px;
}
.job-post{
    margin: 25px;
	background-color: #fff;
	width: 90%;
}
.thanks {
    background-color: #2a3554;
    margin: 30px  0;
}
.thanks h3 {
    color: #fff;
    text-align: center;
    margin-bottom: 0px;
    letter-spacing: 0.3px;
    padding: 10px;
}
.thanks p {
    padding: 0 10px;
	color: #fff;
	font-size: 17px;
	line-height: 26px;
	text-align: center;
	margin-top: 5px;
	padding-bottom: 10px;
}
.vbtn a{
	display: block;
	padding: 5px 25px;
	border: 2px solid #2a3554;
	border-radius: 20px;
	width: fit-content;
	margin: auto;;
	margin-top: 20px;
	color: #fff;
	font-weight: bold;
	background-color: #2a3554;
	text-decoration: none;
}
.footer{
    background-color: #1B6285;
}
.footer td{
    padding: 10px;
    text-align: center;
}
.play-img{
    width: 120px;
}
.ey-team-img{
    width: 150px;
}
.logo-copyright p {
    font-family: 'Open Sans';
    font-size: 14px;
    color: #fff;
    font-weight: 500;
}
");
?>

<table class="job-created-main">
    <tr>
        <td>
            <table class="job-mail">
                <tr>
                    <td>
                        <table class="logo">
                            <tr>
                                <td style="padding: 15px;">
                                    <img src="https://www.empoweryouth.com/assets/themes/email/images/XGpD9mA68oPlZvBAknjzoBVl4kwJne.png">
                                </td>
                            </tr>
                        </table>
                        <table class="content">
                            <tr>
                                <td class="c-text">
                                    <p>Your Application has been created <b>Successfully</b>.</p>
                                </td>
                            </tr>
                        </table>
                        <table class="job-post">
                            <tr>
                                <td style="text-align:center;padding: 15px 0;">
                                    <img class="company-logo" src="<?= $data['org_logo'] ?>">
                                </td>
                                <td style="padding: 10px 0;">
                                    <table class="job-detail">
                                        <tr>
                                            <td><h4><?= $data['job_title'] ?></h4></td>
                                        </tr>
                                        <tr>
                                            <td><p><?= $data['job_profile'] ?></p></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                	<span class="job-detail-img">
                                                		<img src="https://www.empoweryouth.com/assets/themes/email/images/XGpD9mA68oPvb9Kn2MEkQBVl4kwJne.png">
                                                	</span>
                                                <p><?= $data['locations']?></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                	<span class="job-detail-img">
                                                		<img src="https://www.empoweryouth.com/assets/themes/email/images/n9lYWbywLRkVAJDw2pDLQE854A1z7M.png">
                                                	</span>
                                                <p><?= $data['salary'] ?></p>
                                            </td>
                                        </tr>
                                        <?php if ($data['position']): ?>
                                        <tr>
                                            <td>
                                                	<span class="job-detail-img">
                                                		<img src="https://www.empoweryouth.com/assets/themes/email/images/MXOy576jYoKjeBjOmAM4RKlw1eWDnG.png">
                                                	</span>
                                                <p>Openings: <?= $data['position'] ?></p>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <table class="view-btn">
                            <tr>
                                <td class="vbtn"><a href="<?= $data['link'] ?>">View Details</a></td>
                            </tr>
                        </table>
                        <table class="thanks">
                            <tr>
                                <td style="padding: 10px;">
                                    <h3>Thank You!</h3>
                                    <p>We are so glad that you have trusted our platform.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class="footer">
                <tr>
                    <td>
                        <table class="social">
                            <tr>
                                <td>
                                    <a href="https://www.facebook.com/empower/"><img src="https://www.empoweryouth.com/assets/themes/email/images/n9lYWbywLRkn75m8qvzbQE854A1z7M.png"></a>
                                    <a href="https://twitter.com/EmpowerYouthin"><img src="https://www.empoweryouth.com/assets/themes/email/images/ZBW1zjDgOQXwN59Y87NldAw80vrkMx.png"></a>
                                    <a href="https://www.instagram.com/empoweryouth.in/"><img src="https://www.empoweryouth.com/assets/themes/email/images/g2PlVzA0MQ18VnYJJAWxdbZ8yqE9ON.png"></a>
                                    <a href="https://www.linkedin.com/company/empoweryouth/"><img src="https://www.empoweryouth.com/assets/themes/email/images/jmXaKq76pdwG9nWzwnped9gMN83Bbv.png"></a>
                                </td>
                            </tr>
                        </table>
                        <table class="logo-copyright">
                            <tr>
                                <td style="text-align: center;">
                                    <a href="https://www.empoweryouth.com/">
                                        <img class="ey-team-img"
                                             src="https://www.empoweryouth.com/assets/themes/email/images/DeBxPEjOGdjymqkD7DqBopqANyVYw9.png">
                                    </a>
                                    <p>Copyright © 2021 Empower Youth</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
