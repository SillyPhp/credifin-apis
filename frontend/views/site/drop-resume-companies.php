<?php

use yii\helpers\Url;

?>
<section class="dr-companies-bg">
    <div class="container">
        <div class="row dr-companies">
            <div class="col-md-6 col-sm-12">
                <div class="dr-companies-text">
                    <h3>Hire The Best Talent</h3>
                    <p>It is often the best hire that sets the tone
                        for the company's culture. Pick the best candidate for your team, your vision and the
                        company as a whole.</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="dr-companies-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/companies-header-img.png') ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'Benefits'); ?></h3>
            </div>
        </div>
            <div class="row dr-flex">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="dr-benefits">
                    <div class="dr-benefits-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/candidates.png') ?>" alt="">
                    </div>
                    <p class="dr-benefits-text">
                        Identify The Most Qualified Applicants Faster
                    </p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="dr-benefits">
                    <div class="dr-benefits-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/documents.png') ?>" alt="">
                    </div>
                    <p class="dr-benefits-text">
                        Adapt Application Forms In Accordance With Vacancies
                    </p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="dr-benefits">
                    <div class="dr-benefits-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/click.png') ?>" alt="">
                    </div>
                    <p class="dr-benefits-text">
                        An Easy Application Process Will Attract More Applicants
                    </p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="dr-benefits">
                    <div class="dr-benefits-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/candidate.png') ?>" alt="">
                    </div>
                    <p class="dr-benefits-text">
                        You Won't Let Good Candidates Go Out Of The Door
                    </p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="dr-benefits">
                    <div class="dr-benefits-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/save-time.png') ?>" alt="">
                    </div>
                    <p class="dr-benefits-text">
                        Time Saving And Cost Effective
                    </p>
                </div>
            </div>
            </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="activate-text">
                    <h3>Activate</h3>
                    <p>Activate Your Drop Resume Services</p>
                    <div class="activate-btn">Activate</div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="activate-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/resume-activate.png') ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>



<?php
$this->registerCss('
.wfnt{
    color: #fff;
    text-transform: uppercase;
    font-family: lobster;
    font-size: 30px;
}
.dr-companies-bg {
    background: url(' . Url::to('@eyAssets/images/pages/custom/companies-bg-icon.png') . ') 55% 20%, linear-gradient(51.32deg, #50A7C2 58.67%, #B7F8DB 87.24%);
    background-size: 12%, cover;
    background-repeat: no-repeat;
    min-height: 550px;
    display: flex;
    align-items: flex-end;
}
.dr-companies-text h3 {
    text-align: left;
    margin: 0px 0px 10px 0px;
    color: #fff;
    text-transform: uppercase;
    font-family: lobster;
    font-size: 40px;
}
.dr-companies-text p {
    text-align: left;
    text-transform: capitalize;
    line-height: 34px;
    color: #fff;
    font-family: lora;
    font-size: 24px;
}
.dr-companies {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.dr-companies-img {
    text-align: center;
}
.dr-flex {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}
.dr-benefits {
    padding-bottom: 40px;
}
.dr-benefits-img {
    height: 100px;
    width: 100px;
    margin-bottom: 5px;
}
.dr-benefits-text {
    font-size: 20px;
    color: #000;
    font-family: lora;
    line-height: 28px;
    letter-spacing: 0.3px;
}
.activate-text {
    padding-top: 40px;
}
.activate-text h3 {
    font-size: 38pt;
    font-family: lora;
    color: #000;
    font-weight: 600;
    text-transform: uppercase;
}
.activate-text p {
    font-size: 26px;
    font-family: lora;
    color: #000;
    letter-spacing: 0.3px;
    margin-bottom: 20px;
}
.activate-btn {
    padding: 10px 15px;
    background: #00A0E3;
    color: #fff;
    border: 1px solid #00A0E3;
    box-shadow: 0 5px 10px rgb(0 0 0 / 20%);
    font-size: 16px;
    font-family: roboto;
    border-radius: 4px;
    display: inline-block;
    width: 150px;
    text-align: center;
    transition: 0.3s ease-in;
}
.activate-btn:hover {
    color: #00a0e3;
    background-color: #fff;
}
.activate-img {
    width: 100%;
    max-width: 450px;
}
@media screen and (max-width: 990px) {
    .dr-companies-img {
        display: none;
    }
    .dr-companies-bg {
        align-items: center;
    }
}
@media screen and (max-width: 760px) {
    .dr-flex {
        justify-content: flex-start;
    }
}
@media screen and (max-width: 992px) and (min-width: 770px){
    .activate-text p {
        font-size: 22px;
    }
    .activate-text h3 {
        font-size: 32pt;
    }
}
@media screen and (max-width: 768px) and (min-wudth: 500px) {
    .activate-text p {
        font-size: 20px;
    }
    .activate-text h3 {
        font-size: 30pt;
    }
    .activate-btn {
        width: 130px;
    }
}
@media screen and (max-width: 540px) and (min-wudth: 320px) {
    .activate-text p {
        font-size: 18px;
    }
    .activate-text h3 {
        font-size: 28pt;
    }
    .activate-btn {
        width: 110px;
    }
    .activate-text {
        padding-top: 0px;
    }
}
');
