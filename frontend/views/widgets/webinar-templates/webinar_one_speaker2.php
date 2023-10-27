<?php

use yii\helpers\Url;

?>
    <script id="temp_<?= $webinar_enc_id ?>" type="template/javascript">
        <section class="webinar-one-speaker1" id="web-one-speak2">
            <div class="green-strip"></div>
            <div class="green-strip"></div>
            <div class="date-time">
                <div class="time">
                    {{time}}
                </div>
                <div class="date">
                    {{date}}
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="speaker-details">
                            <div class="speaker-image">
                                <div class="inside-div">
                                    <img src="{{speaker_image}}">
                                </div>
                            </div>
                            <div class="speaker-name">
                                <h5>Speaker:</h5>
                                <h3>{{speaker_name}}</h3>
                                <h4>{{speaker_designation}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="webinar-text">
                            <h1>{{name}}</h1>
                            <div class="date-time">
                                <div class="time">
                                    <img src="<?= Url::to('@eyAssets/images/pages/webinar/time-icon.png') ?>">{{time}}
                                </div>
                                <div class="date">
                                    <img
                                        src="<?= Url::to('@eyAssets/images/pages/webinar/calendar-icon.png') ?>">{{date}}
                                </div>
                            </div>
                            <p>{{description}}</p>
                            <a href="/webinar/{{slug}}" class="register-btn">Register Now <i
                                class="fas fa-angle-double-right"></i></a>
                            <div class="share-bar">
                                <a target="_blank"
                                   href="https://www.facebook.com/sharer/sharer.php?u=https://www.empoweryouth.com/webinar/{{slug}}"
                                   class="share-fb"><i class="fab fa-facebook-f"></i></a>
                                <a target="_blank"
                                   href="https://telegram.me/share/url?url=https://www.empoweryouth.com/webinar/{{slug}}"
                                   class="tg-tele"><i class="fab fa-telegram-plane"></i></a>
                                <a target="_blank"
                                   href="https://api.whatsapp.com/send?text=https://www.empoweryouth.com/webinar/{{slug}}"
                                   class="share-whatsapp"><i class="fab fa-whatsapp"></i></a>
                                <a target="_blank"
                                   href="https://twitter.com/intent/tweet?text=https://www.empoweryouth.com/webinar/{{slug}}"
                                   class="share-twitter"><i class="fab fa-twitter"></i></a>
                                <a target="_blank"
                                   href="https://www.linkedin.com/shareArticle?mini=true&url=https://www.empoweryouth.com/webinar/{{slug}}"
                                   class="share-linkedin"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </script>

<?php
$this->registerCss('
#web-one-speak2 img{
    width : 100%;
}
#web-one-speak2 {
    background: radial-gradient(77.06% 77.06% at 50% 50%, #999999 0%, #000000 100%);
    min-height: 550px;
    overflow: hidden;
    background-repeat: no-repeat;
    background-size: cover;
    display: flex;
    align-items: center;
}
#web-one-speak2 .webinar-text p{
    max-width: 400px;
}
#web-one-speak2 .webinar-text h1 {
    color: #fff;
    font-family: Roboto;
    font-size: 40px;
    line-height: 1.3;
    max-width: 450px;
    text-align: left;
}
#web-one-speak2 > .date-time span {
    display: block;
    line-height: 23px;
    font-family: farro;
    text-transform: uppercase;
    color: #fff;
    font-size: 20px;
    font-weight: 600;
}
#web-one-speak2 .webinar-text p {
    line-height: 17px;
    color: #c0c0c0;
    margin: 22px 0 0 0;
}
#web-one-speak2 a.register-btn {
    background: #78E890;
    border-radius: 27px;
    padding: 15px 30px;
    display: inline-block;
    margin-top: 20px;
    color: #fff;
    transition: all linear .3s;
}
#web-one-speak2 a.register-btn i{
    transition: all linear .3s;
}
#web-one-speak2 a.register-btn:hover{
    color: #fff;
    transition: all linear .3s;
}
#web-one-speak2 a.register-btn:hover i{
    margin-left: 15px;
    transition: all linear .3s;
}
#web-one-speak2 .share-bar {
    margin-top: 20px;
}

#web-one-speak2 .share-bar a {
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

#web-one-speak2 .share-bar .fab, #web-one-speak2 .share-bar .far {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

#web-one-speak2 .share-bar a:not(.share-fb) {
    margin-left: 7px;
}

#web-one-speak2 .share-bar a.share-fb {
    color: #3b5998;
}

#web-one-speak2 .share-bar a.share-twitter {
    color: 	#1DA1F2;
}

#web-one-speak2 .share-bar a.share-whatsapp {
    color: #25D366;
}
#web-one-speak2 .share-bar a.share-linkedin {
    color: #0e76a8;
}

#web-one-speak2 .share-bar a.tg-tele {
    color: #0088cc;
    border-color: #0088cc;
}

#web-one-speak2 .share-bar a:hover {
    color: #fff;
    transition: 0.2s all ease-in;
    font-size: 12px;
    border-radius: 20px;
}

#web-one-speak2 .share-bar a.share-fb:hover {
    background-color: #3b5998;
}

#web-one-speak2 .share-bar a.share-twitter:hover {
    background-color: #1DA1F2;
}

#web-one-speak2 .share-bar a.share-whatsapp:hover {
    background-color: #25D366;
}
#web-one-speak2 .share-bar a.share-linkedin:hover {
    background-color: #0e76a8;
}


#web-one-speak2 .share-bar a.tg-tele:hover {
    background-color: #0088cc;
    border-color: #0088cc;
}
#web-one-speak2 .green-strip:nth-child(2) {
    bottom: 35px;
    top: inherit;
    right: 0;
    transform: rotate(180deg);
}

#web-one-speak2 .green-strip {
    width: 300px;
    height: 45px;
    background: linear-gradient(90deg, #78E890 28.66%, rgba(124, 192, 100, 0) 100%);
    position: absolute;
    top: 35px;
}
#web-one-speak2 .speaker-image {
    width: 250px;
    height: 250px;
    border-radius: 50%;
    background: #1F1F1F;
    box-shadow: inset -5px 0px 15px rgb(0 0 0 / 42%), inset 5px 0px 7px rgb(141 141 141 / 35%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: auto;
    margin-right: 50px;
    overflow: hidden;
}
#web-one-speak2 .inside-div {
    background: #FFFFFF;
    border: 9px solid #78E790;
    width: 70%;
    height: 70%;
    border-radius: 50%;
    overflow: hidden;

}
#web-one-speak2 .speaker-name {
    font-family: Roboto;
}
#web-one-speak2 .speaker-name h5 {
    color: #78e890;
    margin: 0;
}
#web-one-speak2 .speaker-name h3 {
    color: #fff;
    margin: 0;
    font-weight: 700;
}
#web-one-speak2 .speaker-name h4 {
    margin: 0;
    color: #e3e3e3;
}
#web-one-speak2 > .date-time div:nth-child(2) {
    border-left: 4px solid #78e890;
}
#web-one-speak2 > .date-time {
    position: absolute;
    bottom: 20px;
    display: flex;
}
#web-one-speak2 > .date-time div {
    text-align: center;
    font-size: 25px;
    color: #fff;
    font-weight: 700;
    padding: 0 40px;
}
#web-one-speak2 .webinar-text .date-time{
    display: none;
}
#web-one-speak2 .webinar-text .speaker-name h3 {
    font-size: 17px;
}
#web-one-speak2 .webinar-text .speaker-name h4 {
    font-size: 14px;
}
#web-one-speak2 .webinar-text .date-time div {
    color: #fff;
    margin: 0 20px 0 0;
    color: #78e890;
    font-size: 20px;
    font-weight: 700;
}
#web-one-speak2 .webinar-text .date-time img {
    margin-right: 10px;
}

@media only screen and (max-width: 767px){
    #web-one-speak2 > .date-time{
        display: none;
    }
    #web-one-speak2{
        min-height: 750px;
    }
    #web-one-speak2 .webinar-text h1{
        font-size: 30px
    }
    #web-one-speak2 .container{
        width: 80%;
    }
    #web-one-speak2 .webinar-text .date-time{
        display: flex;
    }
    #web-one-speak2 .speaker-name{
        text-align: right;
    }
    #web-one-speak2 .webinar-text{
        max-width: 100%;
    }

    #web-one-speak2 .webinar-text .date-time img{
        width: 24px;
        height: 24px;
        display: inline;
    }
    
}
@media (min-width: 576px) and (max-width: 767px){
    #web-two-speak1 .speaker:nth-child(1){
        margin-left: unset;
    }
}
@media only screen and (max-width: 576px){
    #web-one-speak2{
        min-height: 650px;
        display: flex;
        align-items: center;
    }
    #web-one-speak2 .green-strip{
        display: none;
    }
    #web-one-speak2 .speaker-image{
        margin-right: 0;
    }
    #web-one-speak2 .row{
        display: flex;
        flex-direction: column-reverse;
    }
    #web-one-speak2 .webinar-text .date-time{
        display: block;
    }
    #web-one-speak2 .container{
        width: 100%;
    }
    #web-one-speak2 .speaker-image {
        width: 120px !important;
        height: 120px !important;
    }
    #web-one-speak2 .speaker-details{
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-top: 20px;
    }
    #web-one-speak2 .speaker-image{
        margin: 0 15px 0 0;
    }
    #web-one-speak2 .speaker-name{
        text-align: left;
    }
}

@media only screen and (max-width: 991px){
    #web-one-speak2 > .date-time div {
        font-size: 16px;
        padding: 0 20px;
    }
    #web-one-speak2 .webinar-text h1{
        font-size: 36px;
    }
}

@media only screen and (max-width: 480px){
    #web-one-speak2{
        min-height: 650px;
    }
    #web-one-speak2 .webinar-text h1{
        font-size: 28px;
    }
    #web-one-speak2 .speaker-name h4 {
        margin: 0;
        color: #e3e3e3;
        font-size: 13px;
    }
    #web-one-speak2 .speaker-name h3 {
        font-size: 16px;
    }
}
');
$script = <<<JS

    getWebinarDetails('$webinar_enc_id');
JS;
$this->registerJs($script);
