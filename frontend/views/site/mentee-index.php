<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <section class="mentor-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="m-banner-text">
                        A New Way Of <br>Funding Career Development
                    </div>
                    <div class="mentor-apply-btn">
                        <a href="/site/all-mentors">
                            <button type="button">Find Mentors</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mentee-heading">Top Mentors</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <?= $this->render('/widgets/mentorships/mentorship-card') ?>
                </div>
                <div class="col-md-4 col-sm-6">
                    <?= $this->render('/widgets/mentorships/mentorship-card') ?>
                </div>
                <div class="col-md-4 col-sm-6">
                    <?= $this->render('/widgets/mentorships/mentorship-card') ?>
                </div>
            </div>
        </div>
    </section>

<?= $this->render('/widgets/mentorships/types-of-mentorship') ?>

<?= $this->render('/widgets/mentorships/how-it-works') ?>
<?php
$this->registerCSS('
.mentor-header{
    background: url(' . Url::to('@eyAssets/images/pages/mentor/mentee.png') . ');
    background-size: cover;
    min-height: 400px;
    display: flex;
    align-items: center;
        background-position: top;
}
.m-banner-text{
    font-family: lora;
    font-size: 35px;
    color: #333;
    line-height: 40px;
    text-transform: capitalize;
}
.mentor-apply-btn {
    margin-top: 20px;
}
.mentor-apply-btn button{
    text-transform: uppercase;
    background:#00a0e3;
    color:#fff;
    padding:15px 20px;
    border: 1px solid #00a0e3
}
.mentee-heading{
    font-size:30px;
    font-family: lora;
    color:#333;
    margin-bottom:20px;
    text-transform: capitalize;
    text-align:center;
}
.footer{
    margin-top:0 !important;
}
');