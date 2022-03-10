<?php

use yii\helpers\Url;

?>
<script id="temp_<?=$webinar_enc_id ?>" type="text/template">
<section class="webinar-one-speaker2" id="web-one-speak3">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="webinar-text">
                    <h5>WEBINAR</h5>
                    <h1>{{name}}</h1>
                    <p>{{description}}</p>
                    <a href="/webinar/{{slug}}" class="register-btn">Register Now <i class="fas fa-angle-double-right"></i></a>
                    <div class="share-bar">
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.empoweryouth.com/webinar/{{slug}}" class="share-fb"><i class="fab fa-facebook-f"></i></a>
                        <a target="_blank" href="https://telegram.me/share/url?url=https://www.empoweryouth.com/webinar/{{slug}}" class="tg-tele"><i class="fab fa-telegram-plane"></i></a>
                        <a target="_blank" href="https://api.whatsapp.com/send?text=https://www.empoweryouth.com/webinar/{{slug}}" class="share-whatsapp"><i class="fab fa-whatsapp"></i></a>
                        <a target="_blank" href="https://twitter.com/intent/tweet?text=https://www.empoweryouth.com/webinar/{{slug}}" class="share-twitter"><i class="fab fa-twitter"></i></a>
                        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=https://www.empoweryouth.com/webinar/{{slug}}" class="share-linkedin"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <div class="date-time">
                        <div class="arrows-icons">
                            <i class="fa fa-chevron-right"></i>
                            <i class="fa fa-chevron-right"></i>
                            <i class="fa fa-chevron-right"></i>
                        </div>
                        <div class="date">
                            <p>Date</p>
                            <p>{{date}}</p>
                        </div>
                        <div class="time">
                            <p>Time</p>
                            <p>{{time}}</p>
                        </div>
                    </div>
                </div>
            </div>
            {{#webinarEvents}}
            {{#webinarSpeakers}}
            <div class="col-sm-6">
                <div class="webinar-img">
                    <div class="speaker-img-frame">
                        <div class="upper-sqr"></div>
                        <div class="middle-sqr">
                            <img src="{{speaker_image}}">
                        </div>
                        <div class="lower-sqr"></div>
                        <div class="name-speaker">
                            <p>{{speaker_name}}</p>
                            <p>{{designation}}</p>
                        </div>
                    </div>
                </div>
            </div>
            {{/webinarSpeakers}}
            {{/webinarEvents}}
        </div>
    </div>
</section>
</script>

<!--<section class="webinar-one-speaker2">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-sm-6">-->
<!--                <div class="webinar-text">-->
<!--                    <h5>WEBINAR</h5>-->
<!--                    <h1>How to Start Your Career in Digital Marketing in 2022</h1>-->
<!--                    <p>E-certificates will be provided to all the registered participants.</p>-->
<!--                    <a href="/webinar/how-to-start-your-career-in-digital-marketing-in-2022-82584" target="_blank" class="register-btn">Register Now <i class="fas fa-angle-double-right"></i></a>-->
<!--                    <div class="share-bar">-->
<!--                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.empoweryouth.com/webinar/how-to-start-your-career-in-digital-marketing-in-2022-82584" class="share-fb"><i class="fab fa-facebook-f"></i></a>-->
<!--                        <a target="_blank" href="https://telegram.me/share/url?url=https://www.empoweryouth.com/webinar/how-to-start-your-career-in-digital-marketing-in-2022-82584" class="tg-tele"><i class="fab fa-telegram-plane"></i></a>-->
<!--                        <a target="_blank" href="https://api.whatsapp.com/send?text=https://www.empoweryouth.com/webinar/how-to-start-your-career-in-digital-marketing-in-2022-82584" class="share-whatsapp"><i class="fab fa-whatsapp"></i></a>-->
<!--                        <a target="_blank" href="https://twitter.com/intent/tweet?text=https://www.empoweryouth.com/webinar/how-to-start-your-career-in-digital-marketing-in-2022-82584" class="share-twitter"><i class="fab fa-twitter"></i></a>-->
<!--                        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=https://www.empoweryouth.com/webinar/how-to-start-your-career-in-digital-marketing-in-2022-82584" class="share-linkedin"><i class="fab fa-linkedin-in"></i></a>-->
<!--                    </div>-->
<!--                    <div class="date-time">-->
<!--                        <div class="arrows-icons">-->
<!--                            <i class="fa fa-chevron-right"></i>-->
<!--                            <i class="fa fa-chevron-right"></i>-->
<!--                            <i class="fa fa-chevron-right"></i>-->
<!--                        </div>-->
<!--                        <div class="date">-->
<!--                            <p>Date</p>-->
<!--                            <p>28 February</p>-->
<!--                        </div>-->
<!--                        <div class="time">-->
<!--                            <p>Time</p>-->
<!--                            <p>4PM - 5PM</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-sm-6">-->
<!--                <div class="webinar-img">-->
<!--                    <div class="speaker-img-frame">-->
<!--                        <div class="upper-sqr"></div>-->
<!--                        <div class="middle-sqr">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/webinar-widgets/surojit.png') ?><!--">-->
<!--                        </div>-->
<!--                        <div class="lower-sqr"></div>-->
<!--                        <div class="name-speaker">-->
<!--                            <p>Surojit Mahato</p>-->
<!--                            <p>Marketing Professional</p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->


<?php $this->registerCss('
    #web-one-speak3 {
        background: url(/assets/themes/ey/images/pages/webinar/webinar-one-speaker2-bg.png);
        background-repeat: no-repeat;
        background-size: cover;
        font-family: Roboto;
        // padding: 20px 0;
        min-height: 550px;
        display: flex;
        align-items: center;
    }
    #web-one-speak3 .row{
        display: flex;
        align-items: center;
    }
    #web-one-speak3 h5 {
        background: #ffffff53;
        padding: 5px 15px;
        text-transform: uppercase;
        color: #fff;
        display: inline-block;
        border-radius: 3px;
    }
    #web-one-speak3 h1 {
        color: #fff;
        font-size: 45px;
        margin: 0;
        font-weight: 600;
        font-family: Roboto;
        letter-spacing: 1px;
        line-height: 1.2;
        margin-bottom: 10px;
    }
    #web-one-speak3 .webinar-text p {
        color: #eee;
        font-size: 14px;
        line-height: 1.3;
        max-width: 480px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    #web-one-speak3 .date-time {
        display: flex;
        align-items: center;
    }
    #web-one-speak3 .arrows-icons {
        font-size: 45px;
        color: #fff;
    }
    #web-one-speak3 .arrows-icons i:not(:nth-child(1)) {
        margin-left: -20px;
    }
    #web-one-speak3 .date, #web-one-speak3 .time {
        width: 170px;
        text-align: center;
    }
    #web-one-speak3 .date p, #web-one-speak3 .time p {
        font-size: 14px;
        color: #fff;
        margin: 0;
    }
    #web-one-speak3 .webinar-text p {
        color: #eee;
        font-size: 14px;
        line-height: 1.3;
        max-width: 480px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    #web-one-speak3 .time{
        border-left: 2px solid #fff;
    }
    #web-one-speak3 a.register-btn {
        background: linear-gradient(91.16deg, #FFBB54 -43.72%, #CB650C 125.14%, #DB7E2E 125.14%);
        border-radius: 27px;
        padding: 8px 23px;
        display: inline-block;
        margin-top: 20px;
        color: #fff;
        transition: all linear .3s;
    }
    #web-one-speak3 a.register-btn i{
        transition: all linear .3s;
    }
    #web-one-speak3 a.register-btn:hover{
        color: #fff
        transition: all linear .3s;
    }
    #web-one-speak3 a.register-btn:hover i{
        margin-left: 15px;
        transition: all linear .3s;
    }
    #web-one-speak3 .share-bar {
        margin-top: 20px;
    }
    
    #web-one-speak3 .share-bar a {
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
    
    #web-one-speak3 .share-bar .fab, #web-one-speak3 .share-bar .far {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    #web-one-speak3 .share-bar a:not(.share-fb) {
        margin-left: 7px;
    }
    
    #web-one-speak3 .share-bar a.share-fb {
        color: #3b5998;
    }
    
    #web-one-speak3 .share-bar a.share-twitter {
        color: #1DA1F2;
    }
    
    #web-one-speak3 .share-bar a.share-whatsapp {
        color: #25D366;
    }
    #web-one-speak3 .share-bar a.share-linkedin {
        color: #0e76a8;
    }
    
    #web-one-speak3 .share-bar a.tg-tele {
        color: #0088cc;
        border-color: #0088cc;
    }
    
    #web-one-speak3 .share-bar a:hover {
        color: #fff;
        transition: 0.2s all ease-in;
        font-size: 12px;
        border-radius: 20px;
    }
    
    #web-one-speak3 .share-bar a.share-fb:hover {
        background-color: #3b5998;
    }
    
    #web-one-speak3 .share-bar a.share-twitter:hover {
        background-color: #1DA1F2;
    }
    
    #web-one-speak3 .share-bar a.share-whatsapp:hover {
        background-color: #25D366;
    }
    #web-one-speak3 .share-bar a.share-linkedin:hover {
        background-color: #0e76a8;
    }
    
    #web-one-speak3 .share-bar a.tg-tele:hover {
        background-color: #0088cc;
        border-color: #0088cc;
    }
    #web-one-speak3 .speaker-img-frame {
        height: 400px;
        width: 320px;
        margin: auto;
        position: relative;
    }
    #web-one-speak3 .upper-sqr, #web-one-speak3 .lower-sqr, #web-one-speak3 .middle-sqr {
        width: 200px;
        height: 200px;
        background: linear-gradient(180deg, #2575FC 0%, #6A11CB 100%);
        transform: translateX(-50%) rotate(45deg);
        top: 10%;
        position: absolute;
        left: 50%;
        border-radius: 10px;
    }
    #web-one-speak3 .middle-sqr {
        background: linear-gradient(157.38deg, #50C9C3 -19.19%, #96DEDA 91.27%);
        z-index: 2;
        top: 50%;
        transform: translate(-50%, -50%) rotate(45deg);
        overflow: hidden;
    }
    #web-one-speak3 .lower-sqr {
        background: linear-gradient(180deg, #6A11CB 0%, #2575FC 100%);
        bottom: 10%;
        top: unset;
    }
    #web-one-speak3 .middle-sqr img{
    width:100%;
        max-width: 280px;
        transform: rotate(-45deg) translateX(33px);
    }
    #web-one-speak3 .name-speaker {
        background: linear-gradient(90.78deg, #6A11CB -3.87%, #2575FC 100%);
        display: inline-block;
        color: #fff;
        text-transform: uppercase;
        padding: 5px 20px;
        border-radius: 5px;
        position: absolute;
        top: 65%;
        z-index: 5;
        left: -28%;
        font-size: 17px;
        font-weight: 600;
        letter-spacing: 1px;
    }  
    #web-one-speak3 .name-speaker p {
        margin: 0;
    }
    #web-one-speak3 .name-speaker p:nth-child(2) {
        font-size: 14px;
        text-transform: initial;
        color: #d7d7d7;
    }
    
    
    @media only screen and (max-width: 1199px){
        #web-one-speak3 .speaker-img-frame{
            margin-left: auto;
            margin-right: 0;
        }
    }

    @media only screen and (max-width: 991px){
        #web-one-speak3 .webinar-text h1{
            font-size: 30px;
            line-height: 1.3;
        }
        #web-one-speak3 .upper-sqr, #web-one-speak3 .lower-sqr, #web-one-speak3 .middle-sqr {
            width: 170px;
            height: 170px;
        }
        #web-one-speak3 .middle-sqr img{
            width: 209px;
            transform: rotate(-45deg) translateX(33px);
        }
        #web-one-speak3 .arrows-icons{
            display: none;
        }
        #web-one-speak3 .lower-sqr{
            bottom: 20%;
        }
        #web-one-speak3 .upper-sqr{
            top: 20%;
        }
        #web-one-speak3 .date, #web-one-speak3 .time {
            width: 138px;
            text-align: left;
            padding: 0 0 0 10px;
            margin-top: 16px;
        }
    }

    @media only screen and (max-width: 767px){
        #web-one-speak3 .container{
            width: 100%;
        }
        #web-one-speak3 .row{
            display: block;
        }
        #web-one-speak3 {
            min-height: 750px;
        }
        #web-one-speak3 .speaker-img-frame{
            width: 290px;
        }
        #web-one-speak3 .name-speaker{
           left: unset;
           top: unset;
           bottom: 65px;
           margin-left: 30px;
        }
        #web-one-speak3 .webinar-img{
            margin-top: -30px;
        }
    }
    
    @media only screen and (max-width: 576px){
        #web-one-speak3{
            max-height: 650px;
        }
        #web-one-speak3 .upper-sqr, #web-one-speak3 .lower-sqr, #web-one-speak3 .middle-sqr {
            width: 110px;
            height: 110px;
        }
        #web-one-speak3 .middle-sqr img{
            width: 140px;
            transform: rotate(-45deg) translateX(24px);
        }
        #web-one-speak3 .lower-sqr{
            bottom: 32%;
        }
        #web-one-speak3 .upper-sqr{
            top: 32%;
        }
        #web-one-speak3 .name-speaker {
            left: unset;
            top: unset;
            bottom: 100px;
            margin-left: 45px;
        }
        #web-one-speak3 .speaker-img-frame {
            width: 290px;
        }
        #web-one-speak3 .name-speaker {
            font-size: 14px;
        }
        #web-one-speak3 .webinar-img {
            margin-top: -80px;
        }
    }

    @media (min-width: 768px) and (max-width: 991px){
        #web-one-speak3 .speaker-image{
            width: 200px !important;
            height: 200px !important;
        }
    }

');
$script = <<<JS

    getWebinarDetails('$webinar_enc_id');
JS;
$this->registerJs($script);
?>