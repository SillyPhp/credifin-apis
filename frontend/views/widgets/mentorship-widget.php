<?php

use yii\helpers\Url;

?>

<section class="set-ment">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="ment-main">
                    <div class="ment-heading">A New Way Of <br> Funding Career Development</div>
                    <div class="ment-content">We appreciate that you're taking the time to help other people grow! We're sure you'll appreciate the benefits being a Empower Youth mentor too!</div>
                    <div class="ment-sign">Sign up now and create your profile</div>
                    <div class="ment-buttons">
                        <a href="#">Apply Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ment-image">
                    <img src="<?= Url::to('@eyAssets/images/pages/mentor/mentor.png') ?>">
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registercss('
.set-ment {
    padding: 30px 0;
    background-color: aliceblue;
}
.ment-main {
    padding: 20px;
}
.ment-heading {
    font-size: 30px;
    line-height: 32px;
    font-weight: 600;
    font-family: roboto;
    padding-bottom: 10px;
    color:#333;
}
.ment-content {
    font-size: 18px;
    font-family: roboto;
    text-align: justify;
    padding-bottom: 10px;
    color:#333;
}
.ment-sign {
    font-size: 18px;
    font-family: roboto;
    font-weight: 500;
    
}
.ment-buttons {
    margin: 15px 0 10px;
}
.ment-buttons a{
    padding: 10px 20px;
    background-color: #00a0e3;
    color: #fff;
    font-size: 16px;
    font-family: roboto;
    border-radius: 4px;
    font-weight: 500;
}
.ment-image {
    width: 296px;
    margin: auto;
}
');
