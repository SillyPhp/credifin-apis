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
                    <div class="register-btn">
                        <a href="/webinar/the-future-of-business-analyst-39800">Register Now<span><i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></span></a>
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
    min-height: 450px;
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
        width: 160px;
        height: 160px;
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
        font-size: 20px;
        font-weight: 700;
    }
    .webinar-one-speaker4 .webinar-text .date-and-time {
        margin: 18px 0;
    }
    .webinar-one-speaker4 .webinar-speaker-img .speaker-bg{
        height: unset;
    }
    
}
');
?>