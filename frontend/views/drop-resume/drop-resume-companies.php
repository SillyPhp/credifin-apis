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

<section class="drop-resume-process">
    <div class="container">
        <h3 class="container heading-style">Process</h3>
        <div class="process-list">
            <div class="step step1">
                <div class="step-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/step1-img.png') ?>" alt="">
                </div>
                <div class="step-detail">
                    <div class="step-num">1</div>
                    <div class="step-text">
                        <h4>JOBS/INTERNSHIP</h4>
                        <p>On the dashboard, click on Manage Jobs/Internships.</p>
                    </div>
                </div>
            </div>
            <div class="step step2">
                <div class="step-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/step2-img.png') ?>" alt="">
                </div>
                <div class="step-detail">
                    <div class="step-num">2</div>
                    <div class="step-text">
                        <h4>RESUME BANK</h4>
                        <p>Go to the resume bank section.</p>
                    </div>
                </div>
            </div>
            <div class="step step3">
                <div class="step-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/step3-img.png') ?>" alt="">
                </div>
                <div class="step-detail">
                    <div class="step-num">3</div>
                    <div class="step-text">
                        <h4>PROFILE</h4>
                        <p>Look at how many resumes each profile has</p>
                    </div>
                </div>
            </div>
            <div class="step step4">
                <div class="step-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/step4-img.png') ?>" alt="">
                </div>
                <div class="step-detail">
                    <div class="step-num">4</div>
                    <div class="step-text">
                        <h4>REVIEW</h4>
                        <p>Review the applications under the job profile</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--<section>-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-md-6 col-sm-6 col-xs-12">-->
<!--                <div class="activate-text">-->
<!--                    <h3 class="heading-style">Activate</h3>-->
<!--                    <p>Activate Your Drop Resume Services</p>-->
<!--                    <div class="activate-btn">Activate</div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-md-6 col-sm-6 col-xs-12">-->
<!--                <div class="activate-img">-->
<!--                    <img src="--><?//= Url::to('@eyAssets/images/pages/custom/resume-activate.png') ?><!--" alt="">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->



<?php
$this->registerCss('
.wfnt{
    color: #fff;
    text-transform: uppercase;
    font-family: lobster;
    font-size: 30px;
}
.dr-companies-bg {
    background: url(' . Url::to('@eyAssets/images/pages/custom/companies-bg-icon.png') . ') 55% 15%, linear-gradient(51.32deg, #50A7C2 58.67%, #B7F8DB 87.24%);
    background-size: 100px, cover;
    background-repeat: no-repeat;
    min-height: 550px;
    max-height: 500px;
    display: flex;
    align-items: flex-end;
}
.dr-companies-text h3 {
    text-align: left;
    color: #fff;
    text-transform: uppercase;
    font-family: lora;
    font-size: 40px;
    font-weight: 700;
}
.dr-companies-text p {
    font-weight: 500;
    text-align: left;
    text-transform: capitalize;
    line-height: 29px;
    color: #e0e0e0;
    font-family: Roboto;
    font-size: 20px;
    letter-spacing: 1px;    
}
.dr-companies {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.dr-companies-img {
    text-align: center;
}
.dr-companies-img img{
    width: 75%;
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
    color: #7B7B7B;
    font-family: Roboto;
    line-height: 28px;
    letter-spacing: 0.3px;
    margin-top: 5px;
}
.activate-text {
    padding-top: 40px;
}
.activate-text h3 {
    font-size: 28pt;
    font-family: lobster;
    color: #000;
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
.drop-resume-process{
  background: #DCF1FF;
}
.drop-resume-process h3{
    color: #00A0E3;
}
.process{
  background: #DCF1FF;
  width: 1170px;
  margin: auto;
}
.process-list{
  font-family: roboto;
  margin: auto;
  max-width: 992px;
}
.step-detail{
  display: flex;
  align-items: center;
  max-width: 300px;
  transform: translateY(40px);
}
.step-detail .step-num{
  font-size: 70px;
  margin: 0 6px;
  opacity: 0.4;
  font-weight: 700;
}
.step-text h4{
  color: #74B9E7;
  margin-bottom: 1px;
  font-size: 20px;
  font-weight: 700;
}
.step2 h4{
  color: #74E0E7;
}
.step3 h4{
  color: #74E7C4;
}
.step-text p{
  font-size: 14px;
}
.step{
  display: flex;
  align-items: flex-end;
  height: 150px;
  width: 52%;
}
.step-img{
  max-width: 150px;
  min-width: 100px;
  transform: rotate(45deg);
}
.step-img img{
  height: 100%;
}
.step2, .step4{
  flex-direction: row-reverse;
}
.step1, .step3{
  margin-left: auto;
}
.step2 .step-detail, .step4 .step-detail{
  flex-direction: row-reverse;
  text-align: right;
}
.step1{
  transform: translateY(38px);
}
.step3{
  transform: translateY(-37px);
}
.step4{
  transform: translateY(-74px);
}
.footer{
  margin-top: 0 !important;
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
}
@media only screen and (max-width: 768px) {
    .activate-text p {
        font-size: 20px;
    }
    .activate-btn {
        width: 130px;
    }
    .process-list{
        max-width: 768px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
    .step{
        transform: translate(0,0);
        width: 45%;
        margin: 35px 10px;
        min-width: 300px;
        flex-direction: row;
        height: auto;
        display: block;
    }
    .step-img{
        margin-bottom: 15px !important;
        width: 100px;
    }
    .step .step-detail{
        transform: translate(0, 0);
        flex-direction: row;
        text-align: left;
    }
}
@media screen and (max-width: 540px) and (min-width: 320px) {
    .activate-text {
        text-align: center;
    }
    .activate-text p {
        font-size: 18px;
    }
    .activate-btn {
        width: 110px;
        text-align: center;
    }
    .activate-text {
        padding-top: 0px;
    }
}
');
