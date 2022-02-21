<?php

use yii\helpers\Url;

?>
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Sansita+One" />

<section class="webinar-one-speaker4 <?= $bg ?>">
    <img src="<?= Url::to('@eyAssets/images/pages/webinar-widgets/one-speaker4-bg-top.png') ?>" class="bg-top" alt="">
    <img src="<?= Url::to('@eyAssets/images/pages/webinar-widgets/one-speaker4-bg-bottom.png') ?>" class="bg-bottom" alt="">
    <img src="<?= Url::to('@eyAssets/images/pages/webinar-widgets/dotted-square.png') ?>" class="dotted-square" alt="">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="webinar-text">
                    <h1>The Future of Business Analyst</h1>
                    <p>E-certificates will be provided to all the registered participants.</p>
                    <div class="date-and-time">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="date">
                            <span class="small-text">
                                DATE
                            </span>
                            <span class="large-text">
                                March 4, 2022
                            </span>
                        </div>
                        <div class="date">
                            <span class="small-text">
                                TIME
                            </span>
                            <span class="large-text">
                                6PM - 7PM
                            </span>
                        </div>
                    </div>
                    <div class="share-bar">
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.empoweryouth.com/webinar/the-future-of-business-analyst-39800" class="share-fb"><i class="fab fa-facebook-f"></i></a>
                        <a target="_blank" href="https://telegram.me/share/url?url=https://www.empoweryouth.com/webinar/the-future-of-business-analyst-39800" class="tg-tele"><i class="fab fa-telegram-plane"></i></a>
                        <a target="_blank" href="https://api.whatsapp.com/send?text=https://www.empoweryouth.com/webinar/the-future-of-business-analyst-39800" class="share-whatsapp"><i class="fab fa-whatsapp"></i></a>
                        <a target="_blank" href="https://twitter.com/intent/tweet?text=https://www.empoweryouth.com/webinar/the-future-of-business-analyst-39800" class="share-twitter"><i class="fab fa-twitter"></i></a>
                        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=https://www.empoweryouth.com/webinar/the-future-of-business-analyst-39800" class="share-linkedin"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="register-btn">
                        <a href="/webinar/the-future-of-business-analyst-39800">Register Now<span><i class="fas fa-chevron-right" style="margin-right: -3px;"></i><i class="fas fa-chevron-right"></i></span></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="webinar-speaker-img">
                    <div class="speaker-bg">
                        <img src="<?= Url::to('@eyAssets/images/pages/webinar-widgets/juhi.png') ?>" alt="">
                    </div>
                    <div class="speaker-detail">
                        <div class="name">Juhi Anand</div>
                        <div class="desg">Business Analyst</div>
                        <div class="com">TCS(Tata Conusltancy Services)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.webinar-one-speaker4.white{
    background: #fff;
}
.webinar-one-speaker4{
    min-height: 550px;
    background: #e0ebff;
    position: relative;
    padding: 50px 0;
}
.webinar-one-speaker4 .bg-top{
    position: absolute;
    top: 0;
    right: 0;   
    width: 300px; 
}
.webinar-one-speaker4 .bg-bottom{
    position: absolute;
    bottom: 0;
    left: 0;  
    width: 65px;
    opacity: .2; 
}
.webinar-one-speaker4 .dotted-square{
    position: absolute;
    top: 50px;
    left: 50%;
}
.webinar-one-speaker4 .webinar-text h1 {
    font-size: 55px;
    font-weight: 900;
    line-height: 1.1;
}
.webinar-one-speaker4 .webinar-text p {
    font-size: 22px;
    line-height: 1.3;
}
.webinar-one-speaker4 .webinar-text .date-and-time {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    margin: 35px 0;
}
.webinar-one-speaker4 .webinar-text .date-and-time > * {
    margin-right: 38px;
}
.webinar-one-speaker4 .webinar-text .date-and-time i {
    font-size: 35px;
    color: #264b8c;
}
.webinar-one-speaker4 .webinar-text .date-and-time .date span {
    display: block;
    line-height: 1.3;
}
.webinar-one-speaker4 .webinar-text .date-and-time .date .small-text {
    font-size: 15px;
    font-weight: 900;
    color: #264b8c;
}
.webinar-one-speaker4 .webinar-text .date-and-time .date .large-text {
    font-size: 22px;
    font-weight: 900;
    color: #333;
}
.webinar-one-speaker4 .webinar-text .register-btn a {
    background: #264b8c;
    padding: 10px 35px;
    display: inline-block;
    margin-top: 20px;
    border-radius: 50px;
    color: #fff;
    font-size: 15px;
    font-weight: 700;
    position: relative;
    transition: all ease .2s;
}
.webinar-one-speaker4 .webinar-text .register-btn a span{
    position: absolute;
    right: 20px;
    opacity: 0;
    transition: all ease .2s;
}
.webinar-one-speaker4 .webinar-text .register-btn a:hover{
    padding-left: 20px;
    padding-right: 50px;
    transition: all ease .2s;
}
.webinar-one-speaker4 .webinar-text .register-btn a:hover span{
    right: 10px;
    opacity: 1;
    transition: all ease .2s;
}
.webinar-one-speaker4 .webinar-speaker-img .speaker-bg {
    display: block;
    border: 12px solid #254887;
    border-radius: 50%;
    margin: auto;
    width: 250px;
    height: 250px;
}
.webinar-one-speaker4 .webinar-speaker-img .speaker-bg img {
    display: inline-block;
}
.webinar-one-speaker4 .webinar-speaker-img .speaker-detail > div {
    font-family: "Sansita One";
    font-size: 28px;
    line-height: 1.2;
    color: #334756;
}
.webinar-one-speaker4 .webinar-speaker-img .speaker-detail .desg,
.webinar-one-speaker4 .webinar-speaker-img .speaker-detail .com{
    color: #737373;
    font-size: 20px;
}
.share-bar {
    margin-top: 20px;
}

.share-bar a {
    display: inline-block;
    font-size: 18px;
    color: #fff;
    width: 30px;
    border-radius: 4px;
    height: 30px;
    position: relative;
    border-radius: 10px;
    background: #FFFFFF;
    box-shadow: 0px 0px 4px rgb(0 0 0 / 25%);
    border-radius: 11px;
    transition: .2s all ease-in;
    margin-left: 10px;
}

.share-bar .fab, .share-bar .far {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.share-bar a:not(.share-fb) {
    margin-left: 7px;
}

.share-bar a.share-fb {
    color: #3b5998;
}

.share-bar a.share-twitter {
    color: #1DA1F2;
}

.share-bar a.share-whatsapp {
    color: #25D366;
}
.share-bar a.share-linkedin {
    color: #0e76a8;
}

.share-bar a.tg-tele {
    color: #0088cc;
    border-color: #0088cc;
}

.share-bar a:hover {
    color: #fff;
    transition: 0.2s all ease-in;
    font-size: 12px;
    border-radius: 20px;
}

.share-bar a.share-fb:hover {
    background-color: #3b5998;
}

.share-bar a.share-twitter:hover {
    background-color: #1DA1F2;
}

.share-bar a.share-whatsapp:hover {
    background-color: #25D366;
}
.share-bar a.share-linkedin:hover {
    background-color: #0e76a8;
}

.share-bar a.tg-tele:hover {
    background-color: #0088cc;
    border-color: #0088cc;
}

@media (min-width: 768px) and (max-width:991px){
    .webinar-one-speaker4 .row{
        display: flex;
        align-items: center;
    }
    .webinar-one-speaker4 .webinar-text h1 {
        font-size: 36px;
    }
    .webinar-one-speaker4 .webinar-text p {
        font-size: 18px;
    }
    .webinar-one-speaker4 .webinar-text .date-and-time .date .large-text {
        font-size: 16px;
    }
    .webinar-one-speaker4 .webinar-speaker-img .speaker-bg {
        width: 200px;
        height: 200px;
    }
    .webinar-one-speaker4 .bg-top {
        width: 245px;
    }
    .webinar-one-speaker4 .webinar-speaker-img .speaker-detail > div {
        font-size: 24px;
    }    
    .webinar-one-speaker4 .webinar-speaker-img .speaker-detail .desg, .webinar-one-speaker4 .webinar-speaker-img .speaker-detail .com {
        color: #737373;
        font-size: 17px;
    }
}

@media only screen and (max-width: 767px){
    .webinar-one-speaker4 .bg-top {
        display: none;
    }
    .webinar-one-speaker4 .dotted-square {
        display: none;
    }
    .webinar-one-speaker4 .webinar-text h1 {
        font-size: 45px;
        line-height: 1.2;
    }
    .webinar-one-speaker4 .webinar-text p {
        font-size: 22px;
    }
    .webinar-speaker-img {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-top: 55px;
    }
    .webinar-one-speaker4 .webinar-speaker-img .speaker-bg {
        border: 6px solid #254887;
        margin-right: 40px;
        min-width: 160px;
        max-width: 160px;
        min-height: 160px;
        max-height: 160px;
        margin-left: 0;
    }
}

@media only screen and (max-width: 475px){
    .webinar-one-speaker4 .webinar-speaker-img .speaker-detail .desg, .webinar-one-speaker4 .webinar-speaker-img .speaker-detail .com {
        font-size: 14px;
    }
    .webinar-one-speaker4 .webinar-speaker-img .speaker-detail > div {
        font-size: 23px;
    }
    .webinar-one-speaker4 .webinar-text .date-and-time i, .webinar-one-speaker4 .webinar-text .date-and-time{
        display: block;
    }
    .webinar-one-speaker4 .webinar-text .date-and-time > div {
        display: inline-block;
    }
    .webinar-one-speaker4 .webinar-text .date-and-time > * {
        margin-bottom: 18px;
    }
    .webinar-one-speaker4 .webinar-text .register-btn a {
        font-weight: 700;
    }
    .webinar-one-speaker4 .webinar-text .date-and-time {
        margin: 18px 0;
    }
    .webinar-one-speaker4 .webinar-speaker-img .speaker-bg{
        min-width: 120px;
        max-width: 120px;
        min-height: 120px;
        max-height: 120px;
    }
    .webinar-speaker-img {
        margin-top: 44px;
    }
    .webinar-one-speaker4 .webinar-text .date-and-time .date .large-text {
        font-size: 16px;
    }   
}

@media only screen and (max-width: 575px){
    .webinar-one-speaker4 .webinar-text h1 {
        font-size: 35px;
    }
    .webinar-one-speaker4 .webinar-text p {
        font-size: 18px;
    }
}
');
?>