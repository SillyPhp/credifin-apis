<?php

use yii\helpers\Url;

?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h1 class="heading-style"><?= Yii::t('frontend', 'Trending Companies'); ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="top-cities">
                <a href="">
                <div class="top-cities-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/asia-software.png') ?>" alt="">
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
                <a href="">
                <div class="top-cities-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/company-and-candidate/citizenBank.png') ?>" alt="">
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
                <a href="">
                <div class="top-cities-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/logo1.png') ?>" alt="">
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
                <a href="">
                <div class="top-cities-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/axis-bank.png') ?>" alt="">
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
                <a href="">
                <div class="top-cities-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/logo2.png') ?>" alt="">
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
                <a href="">
                <div class="top-cities-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/logo1.png') ?>" alt="">
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
                <a href="">
                <div class="top-cities-img">
                    <canvas class="user-icon" name="Cordlesspowertoolsca" width="110" height="110" color="#ef0b81" font="45px"></canvas>
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
                <a href="">
                <div class="top-cities-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/logo3.png') ?>" alt="">
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
                <a href="">
                <div class="top-cities-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/asia-software.png') ?>" alt="">
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
                <a href="">
                <div class="top-cities-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/axis-bank.png') ?>" alt="">
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
                <a href="">
                <div class="top-cities-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/logo2.png') ?>" alt="">
                </div>
                    <div class="company-name">Asia Software</div>
                </a>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.top-cities {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
.top-cities a {
    position: relative;
}
.top-cities-img {
    width: 110px;
    height: 110px;
    margin: 40px;
    border-radius: 60px;
    overflow: hidden;
    border: 1px solid #eee;
    box-shadow: 0 0 13px 4px #eee;
    line-height: 85px;
    margin-top: 12px;
    padding: 10px;
}
.company-name {
    display: none;
    position: absolute;
    bottom: -2px;
    left: 50px;
}
.top-cities-img:hover + .company-name{
    display: block;
}
.top-cities-img img, .top-cities-img canvas {
    width: 100%;
    height: auto;
    border-radius: 50%;
}
');
