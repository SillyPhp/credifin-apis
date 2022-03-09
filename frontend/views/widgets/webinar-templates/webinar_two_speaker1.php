<?php

use yii\helpers\Url;

?>
<script id="temp_<?=$webinar_enc_id ?>" type="text/javascript">
    <section class="webinar-two-speaker">
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
.share-whatsapp{
    color: #25D366 !important;
}
.share-bar a.share-whatsapp:hover{
    background-color: #25D366 !important;
    color: #fff !important;
    
}
.webinar-two-speaker{
    background: url(/assets/themes/ey/images/pages/webinar/webinar-two-speaker-bg.png);
    min-height: 550px;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: bottom;
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
.date-time{
    margin: 22px 0 0 0;
}
.date-time span {
    display: block;
    line-height: 23px;
    font-family: farro;
    text-transform: uppercase;
    color: #fff;
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 10px;
}
.date-time span img {
    margin-right: 10px;
}
.webinar-text p {
    line-height: 17px;
    color: #c0c0c0;
}
a.register-btn {
    background: linear-gradient(91.16deg, #FFBB54 -43.72%, #CB650C 125.14%, #DB7E2E 125.14%);
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

.speaker {
    width: 350px;
    overflow: auto;
}
.speaker-img {
    float: right;
    background: #fff;
    width: 150px;
    height: 150px;
    border-radius: 50%;
}
.speaker-img img{
    width: 100%;
}
.speaker {
    width: 345px;
    overflow: auto;
    position: relative;
}
.speaker-img {
    margin-left: auto;
    background: #fff;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    position: relative;
    z-index: 1;
    border: 2px solid #DF2E2E;
}
.speaker-detail {
    width: 100%;
    position: absolute;
    bottom: 0;
}
.speaker-detail div {
    color: #fff;
    display: block;
    border-radius: 20px;
    width: 65%;
    padding: 0 20px;
    font-weight: 600;
}
.speaker-name {
    background: #DF2E2E;
}
.speaker-designation {
    background: #D2B82E;
    margin-left: 20px;
}
.speaker:nth-child(1){
    margin-left: auto;
    margin-bottom: 20px;
}
@media only screen and (max-width: 992px){
    .speaker-img{
        width: 150px;
        height: 150px;
    }
    .speaker{
        width: 290px;
    }
}
@media only screen and (max-width: 768px){
    .webinar-two-speaker{
        background: #213d85;
    }
    .webinar-two-speaker .row {
        display: flex;
        flex-direction: column;
    }
    .speakers-images {
        display: flex;
    }
    .speaker-img {
        width: 120px;
        height: 120px;
    }
    .webinar-text {
        text-align: center;
        margin: auto;
        margin-bottom: 40px;
    }
    .speaker:nth-child(1){
        margin-bottom: 0;
    }
    .speaker{
        width: 240px;
    }
}
@media only screen and (max-width: 576px){
    .speakers-images{
        flex-direction: column;
    }
    .speakers-images .speaker{
        margin-bottom: 20px;
    }
}
');
$script = <<<JS

    getWebinarDetails('$webinar_enc_id');
JS;
$this->registerJs($script);
?>