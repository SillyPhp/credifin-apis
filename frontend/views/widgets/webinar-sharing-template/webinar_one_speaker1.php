<section class="webinar-one-speaker1">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="webinar-text">
                    <h1>Webinar Name - Title</h1>
                    <h3>September 21, 2021</h3>
                    <h3>4PM - 8PM</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laborum ratione, aspernatur harum tempora optio accusamus cumque, quo voluptate, maiores sit eligendi quasi omnis.</p>
                    <a href="">Register Now</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="webinar-img">
                    <div class="speaker-img">
                        <img src="">
                    </div>
                    <div class="speaker-name">
                        <p>Speaker Name</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

use yii\helpers\Url;

$this->registerCss('
    .webinar-one-speaker1{
        background: url('.Url::to('@eyAssets/images/pages/webinar-widgets/one-speaker-sharing-bg1.png').');
        background-repeat: no-repeat;
        background-size: cover;
        padding: 50px 0;
        width: 1200px;
        height: 630px;
        margin: auto;
        padding: 90px 0;
    }
    .webinar-one-speaker1 .container{
        padding: 50px !important;
    }
    .webinar-one-speaker1 .webinar-text h1 {
        color: #fff;
        font-size: 50px;
        font-family: Roboto;
        margin: 0;
    }
    .webinar-one-speaker1 .webinar-text h3 {
        margin: 0;
        color: #fff;
        text-transform: uppercase;
        font-weight: 700;
        font-family: Roboto;
        font-size: 23px;
    }
    .webinar-one-speaker1 .webinar-text p {
        font-size: 18px;
        margin: 15px 0;
        line-height: 1.3;
        color: #eee;
    }
    .webinar-one-speaker1 .webinar-text a {
        background: #e3a024;
        color: #fff;
        padding: 7px 17px;
        display: inline-block;
        font-weight: 600;
        font-size: 18px;
        margin-top: 13px;
    }
    .webinar-one-speaker1 .speaker-img {
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: #fff;
    }
    .webinar-one-speaker1 .speaker-name {
        font-size: 22px;
        margin-top: 10px;
        color: #fff;
        font-weight: 600;
        display: inline-block;
    }
    .webinar-one-speaker1 .webinar-img{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
')?>