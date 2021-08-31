<?php

use yii\helpers\Url;

?>

    <section class="head-bg">
<!--        <div class="img-top-left">-->
<!--            <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/blue-bg.png') ?><!--" alt="">-->
<!--        </div>-->
<!--        <div class="img-bottom-right">-->
<!--            <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/blue-bg1.png') ?><!--" alt="">-->
<!--        </div>-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="partner-text">
                        <h2>Build a PARTNERSHIP With US</h2>
                        <p>so that together we can help students across the
                            globe fulfill their dreams and lay their career path.</p>
                        <a href="/educational-institution-loan" class="fin-btn" target="_blank">Financial Institutes</a>
                        <a href="/e-partners" class="agent-btn" target="_blank">Agents</a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="partner-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/partner-with-us-icn.png') ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.fin-btn {
    text-decoration: none;
    color: #fff;
    background-color: #3F9CC3;
    font-size: 16px;
    font-family: roboto;
    border: 2px solid #3F9CC3;
    padding: 4px 16px;
    border-radius: 4px;
    display: inline-block;
    cursor: pointer;
    transition: ease-in-out .2s;
}
.fin-btn:hover{
    color:#3F9CC3;
    background-color:#fff;
}
.agent-btn {
    text-decoration: none;
    color: #fff;
    background-color: #ed6d1e;
    font-size: 16px;
    font-family: roboto;
    border: 2px solid #ed6d1e;
    padding: 4px 40px;
    border-radius: 4px;
    display: inline-block;
    cursor: pointer;
    transition: ease-in-out .2s;
}
.agent-btn:hover{
    color: #ED6D1E;
    background-color: #fff;
}
.row{
    margin-left: 0px;
    margin-right: 0px;
}
.head-bg{
    background-image: url(/assets/themes/ey/images/pages/education-loans/blue-bg.png),url(/assets/themes/ey/images/pages/education-loans/blue-bg1.png);
    background-color: #fff;
    background-repeat: no-repeat;
    background-position: top left, bottom right;
    background-size: 12%, 50% 100%; 
    height: 450px;
}
.partner-icon{
    text-align: right;
    margin-top: 30px;
}
.partner-icon img {
    width: 100%;
    max-width: 500px;
}
.partner-text {
    padding: 110px 0px 0px 100px;
}
.partner-text h2 {
    font-family: lora;
   color: #3F9CC3;
    text-align: justify;
    font-size: 32px;
    font-weight: 600;
    text-transform: uppercase;
}
.partner-text p {
    font-size: 18px;
    color: #959595;
    font-family: roboto;
    font-weight: 500;
    line-height: 24px;
}
@media screen and (max-width: 1100px) and (min-width: 981px){
    .partner-text h2 {
        font-size: 23px;
    }
    .partner-text p {
        font-size: 18px;
        margin-bottom: 25px;
    }
    .fin-btn{
        margin-bottom: 10px;
        font-size: 15px;
    }
    .agent-btn {
        margin-bottom: 10px;
        font-size: 14px;
    }
    .partner-icon {
        margin-top: 100px;
    }
    .partner=icon img{
        width: 100%;
        max-width: 430px;
    }
    .head-bg {
        background-size: 15% 70%, 50% 100%;
        height: 400px;
    }
}
@media only screen and (max-width: 980px) and (min-width: 768px){
    .partner-text h2 {
        font-size: 30px;
    }
    .partner-text p {
        font-size: 18px;
    }
    .fin-btn {
        margin-bottom: 10px;
        font-size: 15px;
    }
    .agent-btn {
        margin-bottom: 10px;
        font-size: 14px;
    }
    .partner=icon img{
        width: 100%;
        max-width: 430px;
    }
}
@media only screen and (max-width: 760px) and (min-width: 360px){
     .partner-text {
        padding: 20px 12px 0px 12px;
        text-align: center;
    }
    .head-bg {
        background-image: url(/assets/themes/ey/images/pages/education-loans/
        background-repeat: no-repeat;
    }
    .partner-text h2 {
        font-size: 20px;
        text-align: center;
    }
    .partner-text p{
        font-size: 16px;
        margin-bottom: 20px;
    }
    .partner-icon img{
        width: 100%;
        max-width: 418px;
    }
    .partner-icon {
        text-align: center;
    }
    .fin-btn {
        margin-bottom: 8px;
    }
}
');
