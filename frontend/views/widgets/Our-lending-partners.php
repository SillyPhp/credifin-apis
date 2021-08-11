<?php

use yii\helpers\Url;

?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="heading-style"><?= Yii::t('frontend', 'Our Lending Partners'); ?></h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/AG-logo.png') ?>" alt="Agile Finserv">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>Agile Finserv</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png') ?>"
                                 alt="Avanse Financial Services">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>Avanse Financial Services</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/global-logo.png') ?>"
                                 alt="InCred">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>Global Financial Services</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png') ?>"
                                 alt="Exclusive Leasing & Finance">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>Exclusive Leasing & Finance</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/index2/ezcapital.png') ?>" alt="EZ Capital">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>EZ Capital</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/phf-leasing-ltd.png') ?>" alt="PHF Leasing">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>PHF Leasing</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/wepay.png') ?>" alt="Amrit Malwa Private Limtied">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>We Pay India</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/paisa-online.png') ?>" alt="Amrit Malwa Private Limtied">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>Paisa Online</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="college-card">
                        <div class="college-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/mpower-logo.jpg') ?>" alt="Amrit Malwa Private Limtied">
                        </div>
                        <div class="partner-name">
                            <div class="text-effect"></div>
                            <p>MPower Financing</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.college-card {
    text-align: center;
    padding: 15px 0;
    margin-bottom: 30px;
    box-shadow: 0 0 10px rgb(0 0 0 / 10%);
    transition: 300ms all linear;
    background-color: #fff;
    border-radius:4px;
    overflow:hidden;
    min-height:150px;
}
.college-img{
    width: 70px;
    height: 70px;
    margin: auto;
    line-height: 65px;
    transition: 300ms all linear;
    overflow:hidden;
}
.partner-name{
  width: fit-content;
  position: relative;
}

.partner-name .text-effect, .text-effect-content{
  position: absolute;
  top: 0;
  left: 0;
  width: 5px;
  height: 100%;
  background-color: #FB7D0D;
  transition: 200ms all linear;
  z-index: 1;
}

.college-card p {
    text-align: left;
    margin: 10px 0 0 0;
    padding: 2px 15px 2px 8px;
    position: relative;
    z-index: 2;
    transition: 300ms all linear;
    font-size: 15px;
    font-family: roboto;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 18px;
}
.college-card:hover{
  transform: scale(0.95);
}

.college-card:hover > .partner-name > .text-effect{
  width: 100%;
  transform: skewX(-17deg);
  margin-left: -8px;
}

.college-card:hover > .partner-name > p{
  color: #fff;
}
');

