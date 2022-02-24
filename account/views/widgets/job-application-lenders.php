<?php

use yii\helpers\Url;

?>
    <section class="header-bg">
        <div class="row">
            <div class="vect-data">
                <div class="job-app-lender-vector">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/undraw-envelope.png') ?>" alt="">
                </div>
                <div class="job-app-lender-heading text-center">
                    <h2>We have received your Loan Application.<br>Your Application has been sent to</h2>
                </div>
            </div>
        </div>
        <div class="row flex-line">
            <div class="lender-card">
                <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>" alt="Agile Finserv">
                <p>Agile Finserv</p>
            </div>
            <div class="lender-card">
                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>"
                     alt="Avanse Financial Services">
                <p>Avanse Financial Services</p>
            </div>
            <div class="lender-card">
                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>"
                     alt="Exclusive Leasing & Finance">
                <p>Exclusive Leasing & Finance</p>
            </div>
            <div class="lender-card">
                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png') ?>"
                     alt="InCred">
                <p>InCred</p>
            </div>
            <div class="lender-card">
                <img src="<?= Url::to('@eyAssets/images/pages/index2/ezcapital.png') ?>" alt="EZ Capital">
                <p>EZ Capital</p>
            </div>
            <div class="lender-card">
                <img src="<?= Url::to('@eyAssets/images/pages/index2/phf-leasing.png') ?>"
                     alt="PHF Leasing">
                <p>PHF Leasing</p>
            </div>
        </div>
    </section>
<?php
$this->registercss('
.header-bg {
    background: linear-gradient(154.01deg, #FF4B1A -3.84%, #E2C952 111.2%);
    border-radius: 8px;
    padding:20px;
    margin-bottom:30px;
}
.job-app-lender-vector {
    text-align: center;
}
.job-app-lender-vector img {
    width: 150px;
    height: 150px;
    object-fit: contain;
}
.job-app-lender-heading h2, .application-sent-heading h2 {
    font-family: lora;
    font-size: 28px;
    color: #fff;
    font-weight: 500;
    margin:10px 0 20px 0;
}
.lender-card {
    text-align: center;
    padding: 10px 0;
    margin:0 2px 20px 2px;
    box-shadow: inset 0 0 10px rgb(0 0 0 / 10%);
    background-color: #fff;
    border-radius: 4px;
    overflow: hidden;
    flex-basis: 15%;
    min-width:140px;
}
.lender-card img {
    width: 60px;
    height: 60px;
    margin: 0 auto;
    object-fit: contain;
}
.flex-line {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
}
.lender-card p {
    font-family: roboto;
    color: #000;
    font-weight: 500;
    margin: 5px 0 0;
    overflow: hidden;
    padding: 0 5px;
    height: 40px;
}
.vect-data {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    margin-bottom: 30px;
    flex-wrap: wrap;
}
');
