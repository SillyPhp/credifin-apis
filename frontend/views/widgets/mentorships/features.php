<?php

use yii\helpers\Url;

?>
    <section class="features-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mentors-feat-heading">Features</p>
                   </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="mentors-whats-in">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentorship/features-calender.png') ?>">
                        <p class="m-feat-heading">calender integration</p>
                        <p>Synchronization with google calender. compatibility with outlook and other calenders. </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mentors-whats-in">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentorship/features-online-meetings.png') ?>">
                        <p class="m-feat-heading">online meeting</p>
                        <p>screen sharing and live chat without registration and software installation. </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mentors-whats-in">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentorship/features-remider-profiles.png') ?>">
                        <p class="m-feat-heading">reminders</p>
                        <p>the platform sends summaries of startup and mentor profiles for upcoming meetings. there is a
                        reminder system for feedbacks and meetings.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.features-section{
    padding:50px 0;
    text-align:center;
    font-family: roboto;
}
.mentors-feat-heading{
    font-size:30px;
    font-family: lora;
    color:#333;
    margin-bottom:20px;
    text-transform: capitalize;
}
.mentors-whats-in{
    margin-bottom:20px;
    color:#333;
    padding:0 10px;
}
.m-feat-heading{
    font-size: 23px;
    font-family: lora;
    padding-top: 15px;
}
.mentors-whats-in p{
    text-transform: capitalize;
}

');
?>