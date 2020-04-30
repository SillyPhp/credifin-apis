<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>

<section class="mentor-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="m-banner-text">
                    A New Way Of <br>Funding Career Development
                </div>
                <div class="mentor-apply-btn">
                    <button type="button" class="mentorSignupModal">Find Mentor</button>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->render('/widgets/mentorships/types-of-mentorship')?>

<?= $this->render('/widgets/mentorships/how-it-works')?>
<?php
$this->registerCSS('
.mentor-header{
    background: url('. Url::to('@eyAssets/images/pages/mentorship/mentors-main-banner.png').');
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
');