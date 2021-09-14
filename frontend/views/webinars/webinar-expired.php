<?php

use yii\helpers\Url;

?>

<section class="pdtp">
    <div class="container">
        <div class="row eflex">
            <div class="col-md-6 col-sm-6">
                <div class="expired-vector">
                    <img src="<?= Url::to('@eyAssets/images/pages/webinar/expired-webinar.png'); ?>" alt="">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="expired-text">
                    <h3>Sorry!</h3>
                    <p>The webinar you have been looking for is expired. Click on the below button to explore some other exciting webinars.</p>
                    <a href="/webinars" class="web-btn" target="_blank">Back</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.footer {
    margin-top: 0 !important;
}
.eflex {
    display: flex;
    align-items: center;
    justify-content: center;
}
.pdtp {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: url(' . Url::to('@eyAssets/images/pages/webinar/wbg.png') . ');
    background-size: cover;
    background-repeat: no-repeat;
}
.expired-vector img {
    width: 100%;
    max-width: 500px;
}
.expired-text h3 {
    font-size: 32px;
    font-family: lora;
    text-transform: uppercase;
    color: #ff7803;
    font-weight: 600;
}
.expired-text p {
    font-size: 20px;
    line-height: 30px;
    color: #000;
    font-family: roboto;
    letter-spacing: 0.3px;
    font-weight: 500;
    margin-bottom: 30px;
}
.web-btn {
    background: #ff7803;
    color: #fff;
    padding: 10px 26px;
    border: 1px solid #ff7803;
    font-size: 14px;
    text-transform: uppercase;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.3s ease-in;
}
.web-btn:hover {
    color: #ff7803;
    background-color: #fff4eb;
}
@media screen and (max-width: 768px) and (min-width: 320px) {
    .eflex {
        display: inline-block;
    }
    .expired-text {
        text-align: center;
    }
    .expired-vector {
        text-align: center;
    }
    .expired-text p {
        font-size: 18px;
        line-height: 26px;
    }
}
');
