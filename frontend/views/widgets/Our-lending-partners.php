<?php

use yii\helpers\Url;

?>
    <section class="lending-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="heading-style"><?= Yii::t('frontend', 'Our Lending Partners'); ?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>" alt="Agile Finserv">
                        </div>
                        <div class="lp-name">Agile Finserv</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>"
                                 alt="Avanse Financial Services">
                        </div>
                        <div class="lp-name">Avanse Financial Services</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png') ?>"
                                 alt="InCred">
                        </div>
                        <div class="lp-name">InCred</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>"
                                 alt="Exclusive Leasing & Finance">
                        </div>
                        <div class="lp-name">Exclusive Leasing & Finance</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/ezcapital.png') ?>" alt="EZ Capital">
                        </div>
                        <div class="lp-name">EZ Capital</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/phf-leasing.png') ?>" alt="PHF Leasing">
                        </div>
                        <div class="lp-name">PHF Leasing</div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3">
                    <div class="lp-box">
                        <div class="loan-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/wepay.png') ?>" alt="Amrit Malwa Private Limtied">
                        </div>
                        <div class="lp-name">We Pay India</div>
                    </div>
                </div>
            </div>
        </div>
    </section>



<?php
$this->registerCss('
.lending-bg {
    background-color: #fff;
    padding-bottom: 20px;
}
.lp-name {
    text-transform: capitalize;
    font-weight: 500;
    font-family: roboto;
    padding: 5px 0 0 0;
    color: #333;
    line-height: 20px;
    min-height: 45px;
    max-height: 45px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.lp-box {
    box-shadow: 0 0 5px rgba(0,0,0,.3);
    text-align: center;
    margin-bottom: 15px;
    border-radius: 5px;
    padding: 10px;
}
.loan-logo img {
    max-width: 80px;
    max-height: 80px;
    height: 65px;
    object-fit: contain;
}
');

