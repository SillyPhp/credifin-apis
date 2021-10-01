<?php

use yii\helpers\Url;
?>

<section class="webinar-one-speaker1">
    <div class="green-strip"></div>
    <div class="green-strip"></div>
    <div class="date-time">
        <div class="time">
            15:00 - 16:45
        </div>
        <div class="date">
            30 September, 2021
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="speaker-image">
                    <div class="inside-div">
                    <img src="<?= Url::to('@eyAssets/images/pages/webinar/vishal-verma-pic.png') ?>">
                    </div>
                </div>
                <div class="speaker-name">
                    <h5>Speaker:</h5>
                    <h3>Vishal Verma</h3>
                    <h4>Personality Development Coach</h4>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="webinar-text">
                    <h1>How to get Your Dream Job</h1>
                    <div class="date-time">
                        <div class="time">
                            <img src="<?= Url::to('@eyAssets/images/pages/webinar/time-icon.png')?>">1:20 PM - 2:20 PM
                        </div>
                        <div class="date">
                        <img src="<?= Url::to('@eyAssets/images/pages/webinar/calendar-icon.png')?>">8 October, 2021
                        </div>
                    </div>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae id sunt incidunt aperiam quisquam, quos sed fugit dolorum asperiores quod!</p>
                    <a href="#" class="register-btn">Register Now <i class="fas fa-angle-double-right"></i></a>
                    <div class="share-bar">
                        <a target="_blank" href="#" class="share-fb"><i class="fab fa-facebook-f"></i></a>
                        <a target="_blank" href="#" class="tg-tele"><i class="fab fa-telegram-plane"></i></a>
                        <a target="_blank" href="#" class="share-linkedin"><i class="fab fa-whatsapp"></i></a>
                        <a target="_blank" href="#" class="share-twitter"><i class="far fa-envelope-open"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->registerCss('
.webinar-one-speaker1 {
    background: radial-gradient(77.06% 77.06% at 50% 50%, #999999 0%, #000000 100%);
    min-height: 550px;
    overflow: hidden;
    background-repeat: no-repeat;
    background-size: cover;
    display: flex;
    align-items: center;
}
.webinar-text{
    max-width: 400px;
}
.webinar-text h1 {
    color: #fff;
    font-family: Roboto;
}
.webinar-one-speaker1 > .date-time span {
    display: block;
    line-height: 23px;
    font-family: farro;
    text-transform: uppercase;
    color: #fff;
    font-size: 20px;
    font-weight: 600;
}
.webinar-text p {
    line-height: 17px;
    color: #c0c0c0;
    margin: 22px 0 0 0;
}
a.register-btn {
    background: #78E890;
    border-radius: 27px;
    padding: 15px 30px;
    display: inline-block;
    margin-top: 20px;
    color: #fff;
    transition: all linear .3s;
}
a.register-btn i{
    transition: all linear .3s;
}
a.register-btn:hover{
    color: #fff
    transition: all linear .3s;
}
a.register-btn:hover i{
    margin-left: 15px;
    transition: all linear .3s;
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
    color: #E60023;
}

.share-bar a.share-linkedin {
    color: #25D366;
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
    background-color: #E60023;
}

.share-bar a.share-linkedin:hover {
    background-color: #25D366;
}

.share-bar a.tg-tele:hover {
    background-color: #0088cc;
    border-color: #0088cc;
}
.green-strip:nth-child(2) {
    bottom: 35px;
    top: inherit;
    right: 0;
    transform: rotate(180deg);
}

.green-strip {
    width: 300px;
    height: 45px;
    background: linear-gradient(90deg, #78E890 28.66%, rgba(124, 192, 100, 0) 100%);
    position: absolute;
    top: 35px;
}
.speaker-image {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: #1F1F1F;
    box-shadow: inset -5px 0px 15px rgb(0 0 0 / 42%), inset 5px 0px 7px rgb(141 141 141 / 35%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: auto;
    margin-right: 50px;
}
.inside-div {
    background: #FFFFFF;
    border: 9px solid #78E790;
    width: 70%;
    height: 70%;
    border-radius: 50%;
}
.speaker-name {
    font-family: Roboto;
}
.speaker-name h5 {
    color: #78e890;
    margin: 0;
}
.speaker-name h3 {
    color: #fff;
    margin: 0;
    font-weight: 700;
}
.speaker-name h4 {
    margin: 0;
    color: #e3e3e3;
}
.webinar-one-speaker1 > .date-time div:nth-child(2) {
    border-left: 4px solid #78e890;
}
.webinar-one-speaker1 > .date-time {
    position: absolute;
    bottom: 35px;
    display: flex;
}
.webinar-one-speaker1 > .date-time div {
    text-align: center;
    font-size: 25px;
    color: #fff;
    font-weight: 700;
    padding: 0 40px;
}
.webinar-text .date-time{
    display: none;
}
.webinar-text .speaker-name h3 {
    font-size: 17px;
}   
.webinar-text .speaker-name h4 {
    font-size: 14px;
}
.webinar-text .date-time div {
    color: #fff;
    margin: 0 20px 0 0;
    color: #78e890;
    font-size: 20px;
    font-weight: 700;
}
.webinar-text .date-time img {
    margin-right: 10px;
}

@media only screen and (max-width: 768px){
    .webinar-one-speaker1 > .date-time{
        display: none;
    }
    .webinar-one-speaker1{
        padding-bottom: 20px;
    }
    .webinar-one-speaker1 .container{
        width: 80%;
    }
    .webinar-text .date-time{
        display: flex;
    }
    .speaker-name{
        text-align: right;
    }
    .webinar-text{
        max-width: 100%;
    }
}

@media only screen and (max-width: 576px){
    .green-strip{
        display: none;
    }
    .speaker-image{
        margin-right: 0;
    }
    .webinar-one-speaker1 .row{
        display: flex;
        flex-direction: column-reverse;
    }
    .webinar-text .date-time{
        display: block;
    }
    .webinar-one-speaker1 .container{
        width: 100%;
    }
}
') ?>