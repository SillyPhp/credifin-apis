<?php

use yii\helpers\Url;

?>
    <section class="types-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mentors-heading">Types of Mentorship</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <a href="/site/mentorship-index">
                        <div class="ment-main">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentor/startup.png') ?>">
                            <p class="ment-heading">startup mentorship</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4">
                    <a href="/site/mentorship-index">
                        <div class="ment-main">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentor/coding.png') ?>">
                            <p class="ment-heading">coding mentorship</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4">
                    <a href="/site/mentorship-index">
                        <div class="ment-main">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentor/learning-education.png') ?>">
                            <p class="ment-heading">learning & education mentorship</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4">
                    <a href="/site/mentorship-index">
                        <div class="ment-main">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentor/design.png') ?>">
                            <p class="ment-heading">Design mentorship</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4">
                    <a href="/site/mentorship-index">
                        <div class="ment-main">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentor/blogging.png') ?>">
                            <p class="ment-heading">blogging mentorship</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4">
                    <a href="/site/mentorship-index">
                        <div class="ment-main">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentor/career-choice.png') ?>">
                            <p class="ment-heading">career choice mentorship</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4">
                    <a href="/site/mentorship-index">
                        <div class="ment-main">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentor/companies.png') ?>">
                            <p class="ment-heading">companies mentorship</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4">
                    <a href="/site/mentorship-index">
                        <div class="ment-main">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentor/digital-mentorship.png') ?>">
                            <p class="ment-heading">digital marketing mentorship</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-12">
                    <div class="become-m">
                        <a href="/site/mentorship-index">Become a mentor</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.become-m {
	background-color: #00a0e3;
	border-radius: 2px;
	transition: all .2s;
	width: 200px;
	height: 45px;
	line-height: 45px;
	margin: auto;
	margin-bottom: 20px !important;
}
.become-m a {
	color: #fff;
	font-size: 16px;
	text-transform: uppercase;
	font-family: roboto;
	display: block;
}
.become-m:hover {
	box-shadow: 0px 6px 7px 0px #aaa;
	transform: translateY(-2px);
}
.types-section{
    text-align:center;
    font-family: roboto;
}
.mentors-heading{
    font-size:30px;
    font-family: lora;
    color:#333;
    margin-bottom:20px;
    text-transform: capitalize;
}
.ment-main{
    margin-bottom:20px;
    color:#333;
    padding:0 10px;
}
.ment-heading{
    font-size: 20px;
    font-family: lora;
    padding: 5px;
    margin:0;
    height:65px;
}
.ment-main p{
    text-transform: capitalize;
}

');
?>