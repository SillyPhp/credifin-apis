<?php

use yii\helpers\Url;

?>
<section class="quiz-template1">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="temp-text">
                    <h1>ANSWER THE QUESTIONS & <br> WIN ₹1000</h1>
                    <p><span class="topic-title">Topic: </span>Guess the Country with their Wierd Law</p>
                    <h1 class="date">8 DEC 2021</h1>
                    <p>Fee ₹100/-</p>
                    <a href="">Register Now</a>
                    <div class="sponser">
                        <h5>Sponsered By</h5>
                        <div class="spons-img">
                            <img src="/assets/themes/ey/images/pages/home/agile.jpg">
                            <img src="/assets/themes/ey/images/pages/home/agile.jpg">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="temp-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/quiz/q-a-img.png')?>">
                </div>
            </div>
        </div>
    </div>
</section>


<?php

$this->registerCss('
    .quiz-template1 {
        background: url(/assets/themes/ey/images/pages/quiz/quiz-temp-bg.png);
        background-repeat: no-repeat;
        background-size: cover;
        min-height: 465px;
    }
    .temp-text h1 {
        font-size: 38px;
        font-weight: 900;
        color: #fff;
        margin: 0;
    }
    .temp-text p {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0;
    }
    .temp-text a {
        border: 2px solid #fff;
        padding: 10px 25px;
        display: inline-block;
        margin-top: 5px;
        color: #fff;
        font-weight: 700;
        transition: all linear .3s;
    }
    .temp-text a:hover, .temp-text a:focus {
        box-shadow: inset 0 0 0 2em #fff;
        transition: all linear .3s;
        color: #7201a7;
    }
    .topic-title {
        color: #F3D656;
    }
    .temp-text .date {
        font-size: 26px;
        margin: 20px 0;
    }
    .quiz-template1 .col-sm-6 {
        display: flex;
        align-items: center;
    }
    .quiz-template1 .row, .quiz-template1 .container, .quiz-template1 .col-sm-6 {
        min-height: 465px;
    }
    .temp-img {
        width: 250px;
        margin: auto;
    }
    .quiz-template1 img{
        width: 100%;
    }
    .sponser h5 {
        font-size: 14px;
        color: #fff;
        font-weight: 800;
    }
    .spons-img img {
        width: 35px;
        border-radius: 50%;
        margin-right: 5px;
    }
    @media only screen and (max-width: 1199px){
        .temp-text h1 {
            font-size: 35px;
        }
        .temp-img {
            width: 200px;
        } 
    }
    @media only screen and (max-width: 991px){
        .temp-text h1 {
            font-size: 26px;
        }
    }
    @media only screen and (max-width: 767px){
        .quiz-template1 {
            min-height: 366px;
            padding: 30px 20px;
            position: relative;
        }
        .quiz-template1 {
            display: flex;
            flex-direction: column-reverse;
        }
        .temp-img {
            position: absolute;
            opacity: 0.05;
            bottom: 0;
            right: 0;
        }
        .quiz-template1 .row, .quiz-template1 .container, .quiz-template1 .col-sm-6 {
            min-height: unset;
        }
        .temp-text{
            text-align: center;
        }
    }
    @media only screen and (max-width: 425px){
        .temp-text h1 {
            font-size: 19px;
        }
        .temp-text .date {
            font-size: 20px;
            margin: 20px 0;
        }
    }
')?>