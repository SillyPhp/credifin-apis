<?php

use yii\helpers\Url;

?>
    <section class="mentors-whats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mentors-heading">Whats In For You</p>
                    <p class="mentors-sub-heading">We appreciate that you're taking the time to help other people grow!<br> We're sure you'll appreciate
                        the benefits being a Empower Youth mentor too!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="mentors-whats-in">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentorship/teaching.png') ?>">
                        <p class="mwi-heading">Teaching = Learning</p>
                        <p>Mentoring is a way which can enhance your skills in teaching, empathy and leadership. Employers love
                            that!</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mentors-whats-in">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentorship/networking.png') ?>">
                        <p class="mwi-heading">Networking</p>
                        <p>You'll meet tons of new people. Maybe your next coworker or business partner is one of
                            them?</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mentors-whats-in">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentorship/compensation.png') ?>">
                        <p class="mwi-heading">Compensation</p>
                        <p>We love to see people mentoring others for free, but you can set a payment as well! It's a
                            great way
                            to keep everyone on track.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.mentors-whats-section{
    background: #ecf5fe;
    padding:50px 0;
    text-align:center;
    font-family: roboto;
}
.mentors-sub-heading{
    font-size: 16px;
    color: #333;
    line-height: 25px;
    margin-bottom:40px;
}
.mentors-heading{
    font-size:30px;
    font-family: lora;
    color:#333;
    margin-bottom:5px;
}
.mentors-whats-in{
    margin-bottom:20px;
    color:#333;
    padding:0 10px;
}
.mwi-heading{
    font-size: 23px;
    font-family: lora
}

');
?>