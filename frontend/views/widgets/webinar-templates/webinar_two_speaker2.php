<?php

use yii\helpers\Url;

?>

<section class="webinar-speaker1">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 web-txt">
                <div class="web-text">
                    <h1>{{name}}</h1>
                    <div class="date-time">
                        <span class="date"><img src="<?= Url::to('/assets/themes/ey/images/pages/webinar/triangle1.png')?>">{{start_date}}</span>
                        <span class="time"><img src="<?= Url::to('/assets/themes/ey/images/pages/webinar/triangle.png')?>">{{start_date_time}}</span>
                    </div>
                    <p>{{description}}</p>
                </div>
                <a href="/webinar/{{slug}}" class="register-btn">Register Now <i class="fas fa-caret-right"></i></a>
                <div class="share-bar">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.empoweryouth.com/webinar/{{slug}}" class="share-fb"><i class="fab fa-facebook-f"></i></a>
                    <a target="_blank" href="https://telegram.me/share/url?url=https://www.empoweryouth.com/webinar/{{slug}}" class="tg-tele"><i class="fab fa-telegram-plane"></i></a>
                    <a target="_blank" href="https://api.whatsapp.com/send?text=https://www.empoweryouth.com/webinar/{{slug}}" class="share-whatsapp"><i class="fab fa-whatsapp"></i></a>
                    <a target="_blank" href="https://twitter.com/intent/tweet?text=https://www.empoweryouth.com/webinar/{{slug}}" class="share-twitter"><i class="fab fa-twitter"></i></a>
                    <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=https://www.empoweryouth.com/webinar/{{slug}}" class="share-linkedin"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="speaker-image">
                    {{#speakers}}
                    <div class="two-speakers">
                        <div class="two-speakers-img"></div>
                        <div class="two-speakers-text">
                            <h3>{{speaker_name}}</h3>
                            <p>{{designation}}</p>
                            {{#company_name}}
                            <p>{{company_name}}</p>
                            {{/company_name}}
                            {{#location}}
                            <p>{{location}}</p>
                            {{/location}}
                        </div>
                    </div>
                    {{/speakers}}
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.webinar-speaker1{
    background: url(/assets/themes/ey/images/pages/webinar/circle.png) -6% -19%, url(/assets/themes/ey/images/pages/webinar/circle.png) 100% -11%, url(/assets/themes/ey/images/pages/webinar/circle.png) 38% 170%, url(/assets/themes/ey/images/pages/webinar/webinar-bg.png);
    min-height: 550px;
    background-repeat: no-repeat;
    background-size: 16%, 11%, 19%, cover;
    display: flex;
    align-items: center;
    padding-bottom: 30px;
}
.web-text{
    max-width: 400px;
}
.web-text h1 {
    color: #fff;
    font-family: Roboto;
}
.date-time img {
    margin-right: 10px;
}
.date-time span {
    display: block;
    line-height: 23px;
    font-family: farro;
    text-transform: uppercase;
    color: #fff;
    font-size: 20px;
    font-weight: 600;
}
.web-text p {
    line-height: 22px;
    color: #fff;
    font-size: 16px;
    font-family: roboto;
    margin: 22px 0 0 0;
}
a.register-btn {
    background: linear-gradient(91.16deg, #FFBB54 -43.72%, #CB650C 125.14%, #DB7E2E 125.14%);
    border-radius: 27px;
    font-size: 16px;
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
    color: #fff;
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
.two-speakers {
    width: 400px;
    position: relative;
}
.two-speakers-img {
    background: #000;
    border: 6px solid #fff;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    position: relative;
    z-index: 2;
}
.two-speakers-text {
    z-index: 1;
    transform: translateY(-50%);
    background-color: #fff;
    border-radius: 10px;
    width: 230px;
    position: absolute;
    right: 0;
    text-align: left;
    top: 50%;
    padding: 10px 40px;
}
.two-speakers-text h3 {
    font-size: 18px;
    margin: 0px;
    font-family: roboto;
    font-weight: 600;
    margin-bottom: 4px;
}
.two-speakers-text p {
    line-height: 16px;
    font-size: 13px;
    margin: 0px;
    color: #00a0e3;
    font-family: roboto;
    font-weight: 500;
}
.two-speakers:nth-child(2) .two-speakers-img {
    margin-left: auto;
}
.two-speakers:nth-child(2) .two-speakers-text {
    left: 0;
}
@media screen and (max-width: 992px) and (min-width: 768px) {
    .two-speakers-text {
        padding: 10px 45px;
    }
    .two-speakers-img {
        width: 170px;
        height: 170px;
    }
    .two-speakers {
        width: 360px;
    }
}
@media screen and (max-width: 767px) and (min-width: 470px) {
    .web-txt {
        text-align: center;
    }
    .two-speakers-img {
        width: 170px;
        height: 170px;
    }
    .two-speakers {
        margin-top: 30px;
        width: 360px;
    }
    .date-time span {
        font-size: 16px;
        text-align: left;
    }
    .date-time {
        display: inline-block;
    }
    .webinar-speaker1 {
        background: url(/assets/themes/ey/images/pages/webinar/circle.png) -6% -19%, url(/assets/themes/ey/images/pages/webinar/circle.png) 100% -11%, url(/assets/themes/ey/images/pages/webinar/circle.png) 38% 170%, url(/assets/themes/ey/images/pages/webinar/webinar-bg.png)16% 15%;
        background-repeat: no-repeat;
        background-size: 16%, 11%, 19%, cover;
    }
}
@media screen and (max-width: 469px) and (min-width: 320px) {
    .two-speakers-text {
        text-align: right;
    }
    .two-speakers-text h3 {
        font-size: 15px;
    }
    .web-txt {
        text-align: center;
    }
    .two-speakers-img {
        width: 125px;
        height: 125px;
    }
    .two-speakers {
        margin-top: 30px;
        width: 290px;
    }
    .date-time span {
        font-size: 16px;
        text-align: left;
    }
    .date-time {
        display: inline-block;
    }
    .webinar-speaker1 {
        background: url(/assets/themes/ey/images/pages/webinar/circle.png) -6% -19%, url(/assets/themes/ey/images/pages/webinar/circle.png) 100% -11%, url(/assets/themes/ey/images/pages/webinar/circle.png) 38% 170%, url(/assets/themes/ey/images/pages/webinar/webinar-bg.png)16% 15%;
        background-repeat: no-repeat;
        background-size: 16%, 11%, 19%, cover;
    }
    a.register-btn {
        font-size: 14px;
        padding: 12px 24px;
    }
    .two-speakers:nth-child(2) .two-speakers-text {
        left: 0;
        text-align: left;
    }
}
');