<?php
use yii\helpers\Url;
?>
    <section class="college-fee-main-bg">
        <div class="container" style="padding-top: 0 !important; padding-bottom: 0 !important;">
            <div class="row college-fee-main">
                <div class="col-md-7 col-sm-7">
                    <div class="college-fee-headings">
                        <h1>Don't Pay in Advance</h1>
                        <p>Pay your College Fees Monthly<br> at zero cost*</p>
                        <a href="/education-loans/apply" class="col-apply-btn">APPLY NOW</a>
                    </div>
                </div>
                <div class="col-md-5 col-sm-5">
                    <div class="college-fee-images">
                        <div class="college-fee-image1">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/apply-now-img.png')?>">
                        </div>
                        <div class="college-fee-image2">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/dot-img.png')?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.college-fee-main-bg {
    background: linear-gradient(98.17deg, #B4DBF5 -35.49%, #48B3DB 118.59%);
    min-height: 350px;
    overflow: hidden;
}
.college-fee-main {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.college-fee-images {
    display: flex;
    align-items: flex-start;
}
.college-fee-image2 img {
    width: 100%;
}
.college-fee-headings h1{
    font-size: 40px;
    font-family: lora;
    font-weight: 600;
    color: #000;
}
.college-fee-headings p {
    font-size: 20px;
    font-family: roboto;
    color: #6a6a6a;
    line-height: 32px;
    letter-spacing: 0.5px;
    margin-bottom: 30px;
}
.college-fee-headings {
    margin-bottom: 30px;
}
.col-apply-btn {
    background: #fff;
    padding: 10px 22px;
    border-radius: 4px;
    font-size: 18px;
    color: #00a0e3;
    border: none;
    outline: none;
    display: inline-block;
    font-weight: 600;
    font-family: roboto;
    transition: 0.3s ease-in;
}
.col-apply-btn:hover {
    background: #00a0e3;
    color: #fff;
}
.college-fee-image1 {
    background: url(' . Url::to('@eyAssets/images/pages/education-loans/color-dots.png') . ');
    background-repeat: no-repeat;
    background-position: bottom;
    background-size: cover;
}
@media screen and (max-width: 576px) and (min-height: 320px) {
    .college-fee-image1 {
        background-size: contain;
        margin-top: 20px;
    }
    .col-apply-btn {
        padding: 12px 30px;
        font-size: 16px;
    }
    .college-fee-headings p {
        font-size: 20px;
        line-height: 26px;
    }
    .college-fee-headings h1 {
        font-size: 36px;
    }
    .college-fee-image2 {
        display: none;
    }
}
');
