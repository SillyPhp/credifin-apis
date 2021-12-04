<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<section class="fee-bg">
    <div class="container-fluid">
        <div class="row dueflex">
            <div class="col-md-6 col-sm-6">
                <div class="fee-due-text">
                    <h3>Login Fee Due</h3>
                    <p class="mb3">Login Fee of <?= $loginFee['applicant_name'] ?>'s loan of Rs <?= $loginFee['amount'] ?> is pending.</p>
                    <p>Please pay your login fees to move your loan application one step ahead.</p>
                    <a href="" class="pay-btn">Pay Now</a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="img-bg"></div>
                <div class="fee-due-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/fees.png') ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.fee-bg {
    background: url(' . Url::to('@eyAssets/images/pages/education-loans/blue-bg-shape.png') . '), url(' . Url::to('@eyAssets/images/pages/education-loans/blue-background.png') . ');
	background-repeat: no-repeat;
	background-size: 260px, cover;
	min-height: 350px;
    display: flex;
    align-items: center;
    margin-bottom: 30px;
}
.mb3{
    margin-bottom: 20px !important;
}
.dueflex {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: nowrap;
}
.fee-due-text {
    margin-left: 40px;
}
.fee-due-text h3 {
    color: #39449d;;
    font-size: 32px;
    font-family: lobster;
    font-weight: 600;
}
.fee-due-text p {
    font-family: roboto;
    font-size: 18px;
    line-height: 24px;
    letter-spacing: 0.3px;
    font-weight: 500;
    color: #000;
}
.fee-due-img {
    text-align: center;
    margin-top: 20px;
    position: relative;
}
.fee-due-img img {
    width: 100%;
    max-width: 260px;
}
.img-bg {
    position: absolute;
    right: 0;
    bottom: -24px;
    display: block;
    width: 450px;
    height: 125px;
    background-color: #516489;
    border-radius: 87px 0 0 87px;
}
.pay-btn {
    padding: 8px 15px;
    background: #39449d;
    color: #fff;
    border: 1px solid #39449d;
    font-size: 16px;
    font-family: roboto;
    border-radius: 4px;
    display: inline-block;
    width: 130px;
    text-align: center;
    transition: 0.3s ease-in-out;
    margin-top: 20px; 
}
.pay-btn:hover {
    color: #39449d;
    background-color: #fff;
     border: 1px solid #fff;
}
@media screen and (max-width: 1024px) and (min-width: 992px) {
    .img-bg {
        width: 360px;
     }
}
@media screen and (max-width: 880px) and (min-width: 768px) {
    .img-bg {
        width: 360px;
     }
     .fee-due-text p {
        font-size: 15px;
    }
}
@media screen and (max-width: 766px) and (min-width: 598px) {
    .img-bg {
        display: none;
     }
     .fee-due-text p {
        font-size: 16px;
    }
}
@media screen and (max-width: 596px) and (min-width: 320px) {
    .img-bg {
        display: none;
     }
     .fee-bg {
    background-size: 200px, cover;
    }
     .fee-due-img {
        display: none;
     }
     .fee-due-text {
        margin-left: 20px;
        text-align: center;
     }
     .fee-due-text p {
        font-size: 16px;
    }
    .fee-due-text h3 {
        font-size: 32px;
    }
}
');
