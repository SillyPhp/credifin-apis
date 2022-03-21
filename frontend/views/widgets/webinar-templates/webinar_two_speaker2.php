<?php

use yii\helpers\Url;

?>
<script id="temp_<?=$webinar_enc_id ?>" type="text/template">
    <section class="webinar-speaker1" id="web-two-speak2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 web-txt">
                    <div class="web-text">
                        <h1>{{name}}</h1>
                        <div class="date-time">
                            <span class="date"><img src="<?= Url::to('/assets/themes/ey/images/pages/webinar/triangle1.png')?>">{{date}}</span>
                            <span class="time"><img src="<?= Url::to('/assets/themes/ey/images/pages/webinar/triangle.png')?>">{{time}}</span>
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
                {{#webinarEvents}}
                <div class="col-md-6 col-sm-6">
                    {{#webinarSpeakers}}
                    <div class="speaker-image">
                        <div class="two-speakers">
                            <div class="two-speakers-img">
                                {{#speaker_image}}
                                <img src="{{speaker_image}}">
                                {{/speaker_image}}
                            </div>
                            <div class="two-speakers-text">
                                <h3>{{speaker_name}}</h3>
                                <p>{{designation}}</p>
                            </div>
                        </div>
                    </div>
                    {{/webinarSpeakers}}
                </div>
                {{/webinarEvents}}
            </div>
        </div>
    </section>
</script>
<?php
$this->registerCss('
#web-two-speak2 .two-speakers-img img
{
width: 100%;
}
#web-two-speak2{
    background: url(/assets/themes/ey/images/pages/webinar/circle.png) -6% -19%, url(/assets/themes/ey/images/pages/webinar/circle.png) 100% -11%, url(/assets/themes/ey/images/pages/webinar/circle.png) 38% 170%, url(/assets/themes/ey/images/pages/webinar/webinar-bg.png);
    min-height: 550px;
    background-repeat: no-repeat;
    background-size: 16%, 11%, 19%, cover;
    display: flex;
    align-items: center;
    padding-bottom: 30px;
}
#web-two-speak2 .web-text{
    max-width: 400px;
}
#web-two-speak2 .web-text h1 {
    color: #fff;
    font-family: Roboto;
}
#web-two-speak2 .date-time img {
    margin-right: 10px;
    width: unset;
}
#web-two-speak2 .date-time span {
    display: block;
    line-height: 23px;
    font-family: farro;
    text-transform: uppercase;
    color: #fff;
    font-size: 20px;
    font-weight: 600;
}
#web-two-speak2 .web-text p {
    line-height: 22px;
    color: #fff;
    font-size: 16px;
    font-family: roboto;
    margin: 22px 0 0 0;
}
#web-two-speak2 a.register-btn {
    background: linear-gradient(91.16deg, #FFBB54 -43.72%, #CB650C 125.14%, #DB7E2E 125.14%);
    border-radius: 27px;
    font-size: 16px;
    padding: 15px 30px;
    display: inline-block;
    margin-top: 20px;
    color: #fff;
    transition: all linear .3s;
}
#web-two-speak2 a.register-btn i{
    transition: all linear .3s;
}
#web-two-speak2 a.register-btn:hover{
    color: #fff;
    transition: all linear .3s;
}
#web-two-speak2 a.register-btn:hover i{
    margin-left: 15px;
    transition: all linear .3s;
}
#web-two-speak2 .share-bar {
    margin-top: 20px;
}

#web-two-speak2 .share-bar a {
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

#web-two-speak2 .share-bar .fab, #web-two-speak2 .share-bar .far {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

#web-two-speak2 .share-bar a:not(.share-fb) {
    margin-left: 7px;
}

#web-two-speak2 .share-bar a.share-fb {
    color: #3b5998;
}

#web-two-speak2 .share-bar a.share-twitter {
    color: #1DA1F2;
}

#web-two-speak2 .share-bar a.share-linkedin {
    color: #0e76a8;
}

#web-two-speak2 .share-bar a.tg-tele {
    color: #0088cc;
    border-color: #0088cc;
}

#web-two-speak2 .share-bar a:hover {
    color: #fff;
    transition: 0.2s all ease-in;
    font-size: 12px;
    border-radius: 20px;
}
#web-two-speak2 .share-whatsapp{
color: #25D366 !important;
}
#web-two-speak2 .share-bar a.share-whatsapp:hover{
    background-color: #25D366 !important;
    color: #fff !important;
    
}
#web-two-speak2 .share-bar a.share-fb:hover {
    background-color: #3b5998;
}

#web-two-speak2 .share-bar a.share-twitter:hover {
    background-color: #1DA1F2;
}

#web-two-speak2 .share-bar a.share-linkedin:hover {
    background-color: #0e76a8;
}

#web-two-speak2 .share-bar a.tg-tele:hover {
    background-color: #0088cc;
    border-color: #0088cc;
}
#web-two-speak2 .speaker-image{
    margin-bottom: 5px;
}
#web-two-speak2 .speaker-image .two-speakers{
    margin-left: auto;
}
#web-two-speak2 .two-speakers {
    width: 400px;
    position: relative;
}
#web-two-speak2 .two-speakers-img {
    background: #000;
    border: 6px solid #fff;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    position: relative;
    z-index: 2;
    overflow: hidden;
}
#web-two-speak2 .two-speakers-text {
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
#web-two-speak2 .two-speakers-text h3 {
    font-size: 18px;
    margin: 0px;
    font-family: roboto;
    font-weight: 600;
    margin-bottom: 4px;
}
#web-two-speak2 .two-speakers-text p {
    line-height: 16px;
    font-size: 13px;
    margin: 0px;
    color: #00a0e3;
    font-family: roboto;
    font-weight: 500;
}
#web-two-speak2 .two-speakers:nth-child(2) .two-speakers-img {
    margin-left: auto;
}
#web-two-speak2 .two-speakers:nth-child(2) .two-speakers-text {
    left: 0;
}
@media screen and (max-width: 992px) and (min-width: 768px) {
    #web-two-speak2 .two-speakers-text {
        padding: 10px 45px;
    }
    #web-two-speak2 .two-speakers-img {
        width: 170px;
        height: 170px;
    }
    #web-two-speak2 .two-speakers {
        width: 360px;
    }
}
@media screen and (max-width: 767px) and (min-width: 470px) {
    #web-two-speak2 .web-txt {
        text-align: center;
    }
    #web-two-speak2 .two-speakers-img {
        width: 140px;
        height: 140px;
    }
    #web-two-speak2 .two-speakers-text{
        right: 10px;    
    }
    #web-two-speak2 .two-speakers {
        // margin-top: 30px;
        width: 360px;
    }
    #web-two-speak2 .date-time span {
        font-size: 16px;
        text-align: left;
    }
    #web-two-speak2 .date-time {
        display: inline-block;
    }
    #web-two-speak2 {
        background: url(/assets/themes/ey/images/pages/webinar/circle.png) -6% -19%, url(/assets/themes/ey/images/pages/webinar/circle.png) 100% -11%, url(/assets/themes/ey/images/pages/webinar/circle.png) 38% 170%, url(/assets/themes/ey/images/pages/webinar/webinar-bg.png)16% 15%;
        background-repeat: no-repeat;
        background-size: 16%, 11%, 19%, cover;
        min-height: 650px;
    }
}
@media screen and (max-width: 469px) and (min-width: 320px) {
    #web-two-speak2 .two-speakers-text {
        text-align: right;
    }
    #web-two-speak2 .two-speakers-text h3 {
        font-size: 15px;
    }
    #web-two-speak2 .web-txt {
        text-align: center;
    }
    #web-two-speak2 .two-speakers-img {
        width: 125px;
        height: 125px;
    }
    #web-two-speak2 .two-speakers {
        margin-top: 30px;
        width: 290px;
    }
    #web-two-speak2 .date-time span {
        font-size: 16px;
        text-align: left;
    }
    #web-two-speak2 .date-time {
        display: inline-block;
    }
    #web-two-speak2 {
        background: url(/assets/themes/ey/images/pages/webinar/circle.png) -6% -19%, url(/assets/themes/ey/images/pages/webinar/circle.png) 100% -11%, url(/assets/themes/ey/images/pages/webinar/circle.png) 38% 170%, url(/assets/themes/ey/images/pages/webinar/webinar-bg.png)16% 15%;
        background-repeat: no-repeat;
        background-size: 16%, 11%, 19%, cover;
        min-height: 650px;
    }
    #web-two-speak2 a.register-btn {
        font-size: 14px;
        padding: 12px 24px;
    }
    #web-two-speak2 .two-speakers:nth-child(2) .two-speakers-text {
        left: 0;
        text-align: left;
    }
}
');
$script = <<<JS

    getWebinarDetails('$webinar_enc_id');
JS;
$this->registerJs($script);