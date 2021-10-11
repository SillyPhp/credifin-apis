<?php

use yii\helpers\Html;
use yii\helpers\Url;
$link = Url::to( 'site/', true);
?>

    <section class="ansilery-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="ansilery-title">
                        <h1>What is Php Developer ?</h1>
                        <p>Use this Mortgage Loan Officer job description to advertise your vacancies and find qualified
                            candidates. Feel free to modify responsibilities and requirements based on your needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ansilery-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-7">
                    <div class="all-job-details">
                        <div class="job-auth">
                            <p>PHP is one of the most developer-friendly languages to work with and the most reliable
                                tool for a startup. Read on to learn more about PHP development.
                            </p>
                            <p>
                                The reason why programming languages exist is for us to communicate effectively with
                                computers. Over the years, these languages have evolved drastically in their
                                functionalities.
                            </p>
                            <p>
                                But how do “outdated” languages like PHP stay relevant today? Strangely enough, it makes
                                up the foundation of a lot of current popular websites. To further understand this,
                                let’s first learn the basics of what PHP is.
                            </p>
                        </div>
                        <div class="job-desc">
                            <h3>Job Description</h3>
                            <ul>
                                <li>Strong knowledge of PHP web frameworks {{such as Laravel, Yii, etc depending on your
                                    technology stack}}
                                </li>
                                <li>Understanding the fully synchronous behavior of PHP</li>
                                <li>Understanding of MVC design patterns</li>
                                <li>Basic understanding of front-end technologies, such as JavaScript, HTML5, and CSS3
                                </li>
                            </ul>
                        </div>
                        <div class="job-skills">
                            <h3>Skills & tools</h3>
                            <ul class="skill-points">
                                <li>Configuration management software <span class="tools-used"> (hello)</span></li>
                                <li>Understanding the fully synchronous behavior of PHP</li>
                                <li>Understanding of MVC design patterns</li>
                                <li>Basic understanding of front-end technologies, such as JavaScript, HTML5, and CSS3
                                </li>
                                <li>Understanding accessibility and security compliance {{Depending on the specific
                                    project}}
                                </li>
                                <li>Strong knowledge of the common PHP or web server exploits and their solutions</li>
                                <li>Understanding fundamental design principles behind a scalable application</li>
                            </ul>
                        </div>
                        <div class="job-response">
                            <h3>Responsibilities</h3>
                            <ul class="resp-points">
                                <li>Integration of user-facing elements developed by front-end developers</li>
                                <li>Build efficient, testable, and reusable PHP modules</li>
                                <li>Solve complex performance problems and architectural challenges</li>
                                <li>Integration of data storage solutions {{may include databases, key-value stores,
                                    blob stores, etc.}}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <?= $this->render('/widgets/sharing-widget-new',[
                            'link' => $link,
                        ]); ?>
                    </div>
                </div>
                <div class="col-md-4 col-sm-5">
                    <div class="related-side-bar">
                        <div class="Rel-Job-Desc side-b">
                            <h3>Related Job Descriptions</h3>
                            <ul>
                                <li><a href="">SQL developer</a></li>
                                <li><a href="">Designer</a></li>
                                <li><a href="">android developer</a></li>
                            </ul>
                        </div>
                        <div class="Rel-int-que side-b">
                            <h3>Related Interview Questions</h3>
                            <ul>
                                <li><a href="">SQL developer</a></li>
                                <li><a href="">Designer</a></li>
                                <li><a href="">android developer</a></li>
                            </ul>
                        </div>
                        <div class="Rel-top side-b">
                            <h3>Related Topics</h3>
                            <ul>
                                <li><a href="">SQL developer</a></li>
                                <li><a href="">Designer</a></li>
                                <li><a href="">android developer</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.ansilery-bg {
	background: url(' . Url::to('@eyAssets/images/pages/webinar/wb2.png') . ');
	min-height: 450px;
	background-repeat: no-repeat;
	background-size: cover;
	display: flex;
	align-items: center;
	position: relative;
	text-align: center;
	max-height: 700px;
}
.ansilery-title {
    text-align: left;
    margin-bottom: 40px;
}
.ansilery-title h1 {
	font-size: 45px;
	font-family: lora;
}
.ansilery-title p {
	font-size: 18px;
	font-family: roboto;
}
.ansilery-icon {
    text-align: center;
    margin-top: 40px;
}
.ansilery-icon img {
    width: 350px;
}
.all-job-details {
	margin: 40px 0 0;
//	box-shadow: 0 0px 5px -2px rgba(0,0,0,0.2);
//	padding: 20px 30px;
}
.job-auth, .job-desc, .job-response, .job-skills{
	margin-bottom: 30px;
	font-family: roboto;
}
.job-auth h3, .job-desc h3, .job-response h3, .job-skills h3{
	font-size: 30px;
	font-family: roboto;
	font-weight: 500;
	margin-top: 0;
	color:#666666;
}
.job-auth p{
	font-size: 16px;
	text-align: justify;
}
.job-desc li, .resp-points li, .skill-points li{
	font-size: 16px;
	margin-left: 20px;
	line-height: 32px;
	display: flex;
}
.job-desc li::before, .resp-points li::before, .skill-points li::before{
	content: "\2023";
	color: #666666;
	font-weight: bold;
	display: inline-block;
	width: 20px;
	margin-left: -20px;
	font-size: 30px;
}
.related-side-bar {
	margin-top: 40px;
}
.side-b {
	margin-bottom: 30px;
	box-shadow: 0px 2px 5px -2px rgba(0,0,0,0.2);
	padding: 15px;
}
.side-b h3 {
	font-size: 20px;
	font-family: roboto;
	color: #00a0e3;
	margin-top:0;
}
.side-b ul li{
	font-size: 16px;
	font-family: roboto;
	display:flex;
}
.side-b ul li a{
	color:#666666;
}
.side-b ul li::before {
	content: "\2022";
	color: #666666;
	font-weight: bold;
	/* width: 15px; */
	margin-left: 0px;
	font-size: 16px;
	display: inline-block;
	margin-right: 5px;
}
');
