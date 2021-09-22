<?php

use yii\helpers\Url;

?>

<section class="ment-bg" style="padding: 10px 0 30px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="main-head">How It Works</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="w-main">
                    <div class="w-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentor/first.png'); ?>"/>
                    </div>
                    <div class="w-head">Register</div>
                    <div class="w-content">Mentors and Students will Sign up and join EmpowerYouth.</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="w-main">
                    <div class="w-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentor/meet.png'); ?>"/>
                    </div>
                    <div class="w-head">Meet</div>
                    <div class="w-content">Students have ample of Choice to choose and meet mentor.</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="w-main">
                    <div class="w-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentor/participate.png'); ?>"/>
                    </div>
                    <div class="w-head">Participate</div>
                    <div class="w-content">Students and Mentors following rules or instructions to reach a particular goal.</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="w-main">
                    <div class="w-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentor/develop.png'); ?>"/>
                    </div>
                    <div class="w-head">Develop</div>
                    <div class="w-content">Reaching the goals will Develop the trusted relationship between Students and mentor.</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="w-main">
                    <div class="w-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentor/plan.png'); ?>"/>
                    </div>
                    <div class="w-head">Plan</div>
                    <div class="w-content"> Trust mentor will help their students to plan their personal, academic and career goals.</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="w-main">
                    <div class="w-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentor/done.png'); ?>"/>
                    </div>
                    <div class="w-head">Succeed</div>
                    <div class="w-content">Mentor succeed to successfully builds career and life skills of their student.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registercss('
.ment-bg{
    background:url(' . Url::to('@eyAssets/images/backgrounds/p6.png') . ');
    background-attachment: fixed;
}
.main-head {
    text-align: center;
    margin: 0;
    margin-bottom: 25px !important;
    font-size: 30px;
    font-family: roboto;
    font-weight: 500;
    color: #333;
}
.w-main {
    background-color: #fff;
    padding: 20px;
    margin-bottom: 20px !important;
    border-radius: 4px;
    box-shadow: 0 0 14px 0px #d5d5d5;
    border: 2px solid transparent;
    width: 295px;
    margin: auto;
    min-height: 216px;
}
.w-logo {
    width: 55px;
    height: 55px;
}
.w-head {
    font-size: 18px;
    color: #ff7803;
    font-family: roboto;
    font-weight: 500;
    padding-top: 5px;
}
.w-content {
    font-size: 16px;
    font-family: roboto;
    color: #333;
}
');
