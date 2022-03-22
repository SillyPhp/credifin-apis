<?php

use yii\helpers\Url;

?>
<script id="temp_<?=$webinar_enc_id ?>" type="text/template">
    <section class="webinar-two-speaker" id="web-two-speak1">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="webinar-text">
                        <h1>{{name}}</h1>
                        <p>{{descrition}}</p>
                        <div class="date-time">
                            <span class="date"><img src="<?= Url::to('@eyAssets/images/pages/webinar/calendar-icon.png')?>">{{date}}</span>
                            <span class="time"><img src="<?= Url::to('@eyAssets/images/pages/webinar/time-icon.png')?>">{{time}}</span>
                        </div>
                        <a href="/webinar/{{slug}}" class="register-btn">Register Now <i class="fas fa-angle-double-right"></i></a>
                        <div class="share-bar">
                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.empoweryouth.com/webinar/{{slug}}" class="share-fb"><i class="fab fa-facebook-f"></i></a>
                            <a target="_blank" href="https://telegram.me/share/url?url=https://www.empoweryouth.com/webinar/{{slug}}" class="tg-tele"><i class="fab fa-telegram-plane"></i></a>
                            <a target="_blank" href="https://api.whatsapp.com/send?text=https://www.empoweryouth.com/webinar/{{slug}}" class="share-whatsapp"><i class="fab fa-whatsapp"></i></a>
                            <a target="_blank" href="https://twitter.com/intent/tweet?text=https://www.empoweryouth.com/webinar/{{slug}}" class="share-twitter"><i class="fab fa-twitter"></i></a>
                            <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=https://www.empoweryouth.com/webinar/{{slug}}" class="share-linkedin"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="speakers-images">
                        {{#webinarEvents}}
                        {{#webinarSpeakers}}
                        <div class="speaker">
                            <div class="speaker-img">
                                {{#speaker_image}}
                                <img src="{{speaker_image}}"/>
                                {{/speaker_image}}
                            </div>
                            <div class="speaker-detail">
                                <div class="speaker-name">
                                    {{speaker_name}}
                                </div>
                                <div class="speaker-designation">
                                    {{designation}}
                                </div>
                            </div>
                        </div>
                        {{/webinarSpeakers}}
                        {{/webinarEvents}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</script>

<?php $this->registerCss('
#web-two-speak1 .share-whatsapp{
    color: #25D366 !important;
}
#web-two-speak1 .share-bar a.share-whatsapp:hover{
    background-color: #25D366 !important;
    color: #fff !important;
    
}
#web-two-speak1{
    background: url(/assets/themes/ey/images/pages/webinar/webinar-two-speaker-bg.png);
    min-height: 550px;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: bottom;
    display: flex;
    align-items: center;
}
#web-two-speak1 .webinar-text{
    max-width: 400px;
}
#web-two-speak1 .webinar-text h1 {
    color: #fff;
    font-family: Roboto;
}
#web-two-speak1 .date-time{
    margin: 22px 0 0 0;
}
#web-two-speak1 .date-time span {
    display: block;
    line-height: 23px;
    font-family: farro;
    text-transform: uppercase;
    color: #fff;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 10px;
}
#web-two-speak1 .date-time span img {
    margin-right: 10px;
    width: unset;
}
#web-two-speak1 .webinar-text p {
    line-height: 17px;
    color: #c0c0c0;
}
#web-two-speak1 a.register-btn {
    background: linear-gradient(91.16deg, #FFBB54 -43.72%, #CB650C 125.14%, #DB7E2E 125.14%);
    border-radius: 27px;
    padding: 15px 30px;
    display: inline-block;
    margin-top: 20px;
    color: #fff;
    transition: all linear .3s;
}
#web-two-speak1 a.register-btn i{
    transition: all linear .3s;
}
#web-two-speak1 a.register-btn:hover{
    color: #fff
    transition: all linear .3s;
}
#web-two-speak1 a.register-btn:hover i{
    margin-left: 15px;
    transition: all linear .3s;
}
#web-two-speak1 .share-bar {
    margin-top: 20px;
}

#web-two-speak1 .share-bar a {
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
    
#web-two-speak1 .share-bar .fab, #web-two-speak1 .share-bar .far {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

#web-two-speak1 .share-bar a:not(.share-fb) {
    margin-left: 7px;
}

#web-two-speak1 .share-bar a.share-fb {
    color: #3b5998;
}
    
#web-two-speak1 .share-bar a.share-twitter {
    color: #1DA1F2;
}

#web-two-speak1 .share-bar a.share-linkedin {
    color: #0e76a8;
}

#web-two-speak1 .share-bar a.tg-tele {
    color: #0088cc;
    border-color: #0088cc;
}
    
#web-two-speak1 .share-bar a:hover {
    color: #fff;
    transition: 0.2s all ease-in;
    font-size: 12px;
    border-radius: 20px;
}

#web-two-speak1 .share-bar a.share-fb:hover {
    background-color: #3b5998;
}

#web-two-speak1 .share-bar a.share-twitter:hover {
    background-color: #1DA1F2;
}
    
#web-two-speak1 .share-bar a.share-linkedin:hover {
    background-color: #0e76a8;
}

#web-two-speak1 .share-bar a.tg-tele:hover {
    background-color: #0088cc;
    border-color: #0088cc;
}

#web-two-speak1 .speaker {
    width: 350px;
    overflow: auto;
}
#web-two-speak1 .speaker-img {
    float: right;
    background: #fff;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
}
#web-two-speak1 .speaker-img img{
    width: 100%;
}
#web-two-speak1 .speaker {
    width: 345px;
    overflow: auto;
    position: relative;
}
#web-two-speak1 .speaker-img {
    margin-left: auto;
    background: #fff;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    position: relative;
    z-index: 1;
    border: 2px solid #DF2E2E;
}
#web-two-speak1 .speaker-detail {
    width: 100%;
    position: absolute;
    bottom: 0;
}
#web-two-speak1 .speaker-detail div {
    color: #fff;
    display: block;
    border-radius: 20px;
    width: 65%;
    padding: 0 20px;
    font-weight: 600;
}
#web-two-speak1 .speaker-name {
    background: #DF2E2E;
}
#web-two-speak1 .speaker-designation {
    background: #D2B82E;
    margin-left: 20px;
}
#web-two-speak1 .speaker:nth-child(1){
    margin-left: auto;
    margin-bottom: 20px;
}
@media only screen and (max-width: 992px){
    #web-two-speak1 .speaker-img{
        width: 150px;
        height: 150px;
    }
    #web-two-speak1 .speaker{
        width: 290px;
    }
}
@media only screen and (max-width: 767px){
    #web-two-speak1{
        background: #213d85;
        height: 650px;
    }
    #web-two-speak1 .container{
        width: 100%;
    }
    #web-two-speak1 .row {
        display: flex;
        flex-direction: column;
    }
    #web-two-speak1 .speakers-images {
        display: flex;
    }
    #web-two-speak1 .speaker-img {
        width: 120px;
        height: 120px;
    }
    #web-two-speak1 .webinar-text {
        text-align: center;
        margin: auto;
        margin-bottom: 40px;
    }
    #web-two-speak1 .speaker:nth-child(1){
        margin-bottom: 0;
    }
    #web-two-speak1 .speaker{
        width: 240px;
    }
}
@media (min-width: 576px) and (max-width: 767px){
    #web-two-speak1 .speakers-images {
        display: flex;
        justify-content: center;
    }
}
@media only screen and (max-width: 576px){
    #web-two-speak1 .speakers-images{
        flex-direction: column;
    }
    #web-two-speak1 .speakers-images .speaker{
        margin-bottom: 20px;
    }
}
');
$script = <<<JS

    getWebinarDetails('$webinar_enc_id');
JS;
$this->registerJs($script);
?>