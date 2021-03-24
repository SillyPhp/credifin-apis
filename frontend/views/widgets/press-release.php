<?php

use yii\helpers\Url;

?>
<section class="mgbm">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'As Seen In'); ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="press-release-hd">
                    <div class="press-release">
                    <div class="press-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/nyoooz.jpg'); ?>" alt=""/>
                    </div>
                    </div>
                    <div class="press-txt-hd">
                        <a href="https://www.nyoooz.com/news/chandigarh/1558601/empoweryouth-offers-education-loans-for-undergraduate-education-across-the-states-of-punjab-and-himachal-pradesh/" target="_blank">
                        <h3>
                                Empoweryouth offers education loans for undergraduate education across the states of
                                Punjab and Himachal Pradesh</h3>
                        </a>
                        <p>Empoweryouth.com, the career-tech platform,now offers Education loans for studies across the
                            states of Punjab and Himachal Pradesh............</p>
                        <div class="press-btn">
                            <a href="https://www.nyoooz.com/news/chandigarh/1558601/empoweryouth-offers-education-loans-for-undergraduate-education-across-the-states-of-punjab-and-himachal-pradesh/" target="_blank">
                                Continue Reading >></a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="press-release-hd">
                    <div class="press-release">
                        <div class="press-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/HED_Trade-marked.png'); ?>" alt=""/>
                        </div>
                    </div>
                    <div class="press-txt-hd">
                        <a href="https://www.highereducationdigest.com/empoweryouth-com-offers-education-loans-for-undergraduate-education-across-the-states-of-punjab-and-himachal-pradesh/" target="_blank">
                        <h3>Empoweryouth offers education loans for undergraduate education across the states of
                            Punjab and Himachal Pradesh</h3> </a>
                        <p>Empoweryouth.com, the career-tech platform,now offers Education loans for studies across the
                            states of Punjab and Himachal Pradesh............</p>
                        <div class="press-btn">
                            <a href="https://www.highereducationdigest.com/empoweryouth-com-offers-education-loans-for-undergraduate-education-across-the-states-of-punjab-and-himachal-pradesh/" target="_blank">
                                Continue Reading >></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.mgbm {
    margin-bottom: 20px;
}
.press-release-hd {
    border: 1px solid #272424;
    background-color: #272424;
    border-radius: 8px;
}
.press-release {
    background-color: #fff;
    border-radius: 8px;
    margin: 18px;
}
.press-img {
    text-align: center;
    padding: 10px 0px 0px;
}
.press-img img {
    width: 160px;
    height: 160px;
    object-fit: contain;
}
.press-txt-hd {
    padding: 0px 20px 15px;
}
.press-txt-hd h3 {
    font-size: 16px;
    font-family: roboto;
    text-align: left;
    color: #fff;
    line-height: 20px;
    margin-top: 2px;
    font-weight: 500;
}
.press-txt-hd p {
    font-size: 14px;
    font-family: roboto;
    line-height: 18px;
    color: #fff;
}
.press-btn a {
	color: #fff;
	background-color:#00a0e3;
	font-size: 14px;
	font-family: roboto;
	border: 2px solid #00a0e3;
	padding: 4px 15px;
	border-radius: 4px;
	display: inline-block;
	transition:ease-in-out .2s;
}
.press-btn a:hover{
    color:#00a0e3;
    background-color:#fff;
}

');
