<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['header_dark'] = true;
?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Choose Subject</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <a href="/quizzes/topics">
                        <div class="sub-main">
                            <span class="sub-round"></span>
                            <div class="sub-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="sub-name">
                                <h3>computer science</h3>
                                <p>1 course</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/quizzes/topics">
                        <div class="sub-main">
                            <span class="sub-round"></span>
                            <div class="sub-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="sub-name">
                                <h3>computer science</h3>
                                <p>1 course</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/quizzes/topics">
                        <div class="sub-main">
                            <span class="sub-round"></span>
                            <div class="sub-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="sub-name">
                                <h3>computer science</h3>
                                <p>1 course</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/quizzes/topics">
                        <div class="sub-main">
                            <span class="sub-round"></span>
                            <div class="sub-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                            </div>
                            <div class="sub-name">
                                <h3>computer science</h3>
                                <p>1 course</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registercss('
.sub-main {
	text-align: center;
	padding: 35px 35px 25px 35px;
	border-radius: 15px 15px 15px 15px;
	overflow: hidden;
	border: 1px dashed #e8e8e8;
	transition: all 0.4s ease;
	margin-bottom: 15px;
	background: #fff;
	margin-top: 20px;
}
.sub-main:hover {
	-webkit-box-shadow: 0 30px 50px 0 rgba(51,51,51,.08);
	box-shadow: 0 30px 50px 0 rgba(51,51,51,.08);
	border-color: transparent !important;
}
.sub-round {
	position: absolute;
	left: 0;
	top: 0;
	width: 60px;
	height: 60px;
	border-radius: 6px;
	background: #00a0e3;
	display: block;
	z-index: -1;
	transform: scale(0);
	transition: all 0.4s ease;
}
.sub-main:hover .sub-round {
	transform: scale(1);
}
.sub-logo {
	margin-bottom: 25px;
}
.sub-logo img{
	-o-transition: all 0.4s ease;
	transition: all 0.4s ease;
	transform: scale(1);
	width: 120px;
	height: 120px;
	border-radius: 50%;
}
.sub-main:hover .sub-logo img {
	transform: scale(.9);
}
.sub-name h3 {
	font-size: 22px;
	font-family: roboto;
	text-transform: capitalize;
	margin: 0 0 10px 0;
	font-weight: 600;
}
.sub-name p {
	font-size: 17px;
	font-family: roboto;
}
');
