<?php

use yii\helpers\Url;

?>

    <section class="head-bg">
        <div class="img-top-left">
            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/partner.png') ?>" alt="">
        </div>
        <div class="img-top-right">
            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/partners.png') ?>" alt="">
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="partner-text">
                        <h2>Build a <span class="neela">PARTNERSHIP</span> With US</h2>
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
    background-color: #ed6d1e;
    font-size: 16px;
    font-family: roboto;
    border: 2px solid #ED6D1E;
    padding: 4px 16px;
    border-radius: 4px;
    display: inline-block;
    cursor: pointer;
    transition: ease-in-out .2s;
}
.fin-btn:hover{
    color:#ED6D1E;
    background-color:#fff;
}
.agent-btn {
    text-decoration: none;
    color: #fff;
    background-color: #2a478a;
    font-size: 16px;
    font-family: roboto;
    border: 2px solid #2a478a;
    padding: 4px 58px;
    border-radius: 4px;
    display: inline-block;
    cursor: pointer;
    transition: ease-in-out .2s;
}
.agent-btn:hover{
    color: #2a478a;
    background-color: #fff;
}
.neela{
    color: #2a478a;
}
.row{
    margin-left: 0px;
    margin-right: 0px;
}
.head-bg{
    background-color: #fff;
    position: relative;
    min-height: 350px;
}
.img-top-left{
    position: absolute;
    top: 0;
    left: 0;
}
.img-top-left img{
    width: 100%;
    max-width: 300px;
}
.img-top-right{
    position: absolute;
    top: 0;
    right: 0;
}
.img-top-right img{
    width: 100%;
    max-width: 250px;
}
.partner-icon{
    margin-top: 50px;
}
.partner-text {
    padding: 55px 0px 0px 130px;
}
.partner-text h2 {
    font-family: Lobster;
    color: #ed6d1e;
    text-align: justify;
}
.partner-text p {
    font-size: 20px;
    color: #2a478a;
    font-family: lora;
    font-weight: 600;
    line-height: 26px;
}
@media only screen and (max-width: 1024px) and (min-width: 985px){
    .img-top-left img {
         max-width: 178px;
         }
    .img-top-right img {
        max-width: 245px;
    }
    .partner-text h2 {
        font-size: 32px;
    }
    .partner-text p {
        font-size: 20px;
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
        margin-top: 150px;
    }
    .partner=icon img{
        width: 100%;
        max-width: 430px;
    }
}
@media only screen and (max-width: 980px) and (min-width: 770px){
    .img-top-left img {
         max-width: 178px;
         }
    .img-top-right img {
        max-width: 245px;
    }
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
    .partner-icon {
        margin-top: 150px;
    }
    .partner=icon img{
        width: 100%;
        max-width: 430px;
    }
}
@media only screen and (max-width: 758px) and (min-width: 360px){
    .img-top-left img {
        max-width: 85px;
        }
    .img-top-right img {
        max-width: 100px;
     }
     .partner-text {
        padding: 20px 12px 0px 12px;
    }
    .partner-text h2 {
        font-size: 29px;
    }
    .partner-text p{
        font-size: 19px;
    }
    .partner-icon img{
        width: 100%;
        max-width: 418px;
    }
    .partner-icon {
        margin-top: 50px;
        text-align: center;
    }
    .fin-btn {
        margin-bottom: 8px;
    }
}
');
