<?php
    
use yii\helpers\Url;

?>
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Sansita+One" />

<script id="temp_<?=$webinar_enc_id ?>" type="text/template">
<section class="webinar-one-speaker4" id="web-one-speak4">
    <img src="<?= Url::to('@eyAssets/images/pages/webinar-widgets/one-speaker4-bg-top.png') ?>" class="bg-top" alt="">
    <img src="<?= Url::to('@eyAssets/images/pages/webinar-widgets/one-speaker4-bg-bottom.png') ?>" class="bg-bottom" alt="">
    <img src="<?= Url::to('@eyAssets/images/pages/webinar-widgets/dotted-square.png') ?>" class="dotted-square" alt="">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="webinar-text">
                    <h1>{{name}}</h1>
                    <p>{{description}}</p>
                    <div class="date-and-time">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="date">
                            <span class="small-text">
                                DATE
                            </span>
                            <span class="large-text">
                            {{date}}
                            </span>
                        </div>
                        <div class="date">
                            <span class="small-text">
                                TIME
                            </span>
                            <span class="large-text">
                            {{time}}
                            </span>
                        </div>
                    </div>
                    <div class="register-btn">
                        <a href="/webinar/{{slug}}" target="_blank"
                        >Register Now<span><i class="fas fa-chevron-right" style="margin-right: -3px;"></i><i class="fas fa-chevron-right"></i></span></a>
                    </div>
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
                <div class="webinar-speaker-img">
                    <div class="speaker-bg">
                        <img src="{{speaker_image}}" alt="">
                    </div>
                    <div class="speaker-detail">
                        <div class="name">{{speaker_name}}</div>
                        <div class="desg">{{speaker_designation}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</script>

<?php
$this->registerCss('
#web-one-speak4.white{
    background: #fff;
}
#web-one-speak4{
    min-height: 550px;
    background: #e0ebff;
    position: relative;
    display: flex;
    align-items: center;
    // padding: 50px 0;
}
#web-one-speak4 .bg-top{
    position: absolute;
    top: 0;
    right: 0;   
    width: 300px; 
}
#web-one-speak4 .bg-bottom{
    position: absolute;
    bottom: 0;
    left: 0;  
    width: 65px;
    opacity: .2; 
}
#web-one-speak4 .dotted-square{
    position: absolute;
    top: 50px;
    left: 50%;
    width: unset;
}
#web-one-speak4 .webinar-text h1 {
    font-size: 45px;
    font-weight: 900;
    line-height: 1.1;
}
#web-one-speak4 .webinar-text p {
    font-size: 22px;
    line-height: 1.3;
}
#web-one-speak4 .webinar-text .date-and-time {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    margin: 35px 0;
}
#web-one-speak4 .webinar-text .date-and-time > * {
    margin-right: 38px;
}
#web-one-speak4 .webinar-text .date-and-time i {
    font-size: 35px;
    color: #264b8c;
}
#web-one-speak4 .webinar-text .date-and-time .date span {
    display: block;
    line-height: 1.3;
}
#web-one-speak4 .webinar-text .date-and-time .date .small-text {
    font-size: 15px;
    font-weight: 900;
    color: #264b8c;
}
#web-one-speak4 .webinar-text .date-and-time .date .large-text {
    font-size: 22px;
    font-weight: 900;
    color: #333;
}
#web-one-speak4 .webinar-text .register-btn a {
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
#web-one-speak4 .webinar-text .register-btn a span{
    position: absolute;
    right: 20px;
    opacity: 0;
    transition: all ease .2s;
}
#web-one-speak4 .webinar-text .register-btn a:hover{
    padding-left: 20px;
    padding-right: 50px;
    transition: all ease .2s;
}
#web-one-speak4 .webinar-text .register-btn a:hover span{
    right: 10px;
    opacity: 1;
    transition: all ease .2s;
}
#web-one-speak4 .webinar-speaker-img .speaker-bg {
    display: block;
    border: 12px solid #254887;
    border-radius: 50%;
    margin: auto;
    width: 250px;
    height: 250px;
    overflow: hidden;
}
#web-one-speak4 .webinar-speaker-img .speaker-bg img {
    display: inline-block;
}
#web-one-speak4 .webinar-speaker-img .speaker-detail > div {
    font-family: "Sansita One";
    font-size: 28px;
    line-height: 1.2;
    color: #334756;
}
#web-one-speak4 .webinar-speaker-img .speaker-detail .desg,
#web-one-speak4 .webinar-speaker-img .speaker-detail .com{
    color: #737373;
    font-size: 20px;
}
#web-one-speak4 .share-bar {
    margin-top: 20px;
}

#web-one-speak4 .share-bar a {
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

#web-one-speak4 .share-bar .fab, #web-one-speak4 .share-bar .far {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

#web-one-speak4 .share-bar a:not(.share-fb) {
    margin-left: 7px;
}

#web-one-speak4 .share-bar a.share-fb {
    color: #3b5998;
}

#web-one-speak4 .share-bar a.share-twitter {
    color: #1DA1F2;
}

#web-one-speak4 .share-bar a.share-whatsapp {
    color: #25D366;
}
#web-one-speak4 .share-bar a.share-linkedin {
    color: #0e76a8;
}

#web-one-speak4 .share-bar a.tg-tele {
    color: #0088cc;
    border-color: #0088cc;
}

#web-one-speak4 .share-bar a:hover {
    color: #fff;
    transition: 0.2s all ease-in;
    font-size: 12px;
    border-radius: 20px;
}

#web-one-speak4 .share-bar a.share-fb:hover {
    background-color: #3b5998;
}

#web-one-speak4 .share-bar a.share-twitter:hover {
    background-color: #1DA1F2;
}

#web-one-speak4 .share-bar a.share-whatsapp:hover {
    background-color: #25D366;
}
#web-one-speak4 .share-bar a.share-linkedin:hover {
    background-color: #0e76a8;
}

#web-one-speak4 .share-bar a.tg-tele:hover {
    background-color: #0088cc;
    border-color: #0088cc;
}

@media only screen and (min-width: 768px) {
    #web-one-speak4 .row{
        display: flex;
        align-items: center;
    }
}

@media (min-width: 768px) and (max-width:991px){
    #web-one-speak4 .row{
        display: flex;
        align-items: center;
    }
    #web-one-speak4 .webinar-text h1 {
        font-size: 36px;
    }
    #web-one-speak4 .webinar-text p {
        font-size: 18px;
    }
    #web-one-speak4 .webinar-text .date-and-time .date .large-text {
        font-size: 16px;
    }
    #web-one-speak4 .webinar-speaker-img .speaker-bg {
        width: 200px;
        height: 200px;
    }
    #web-one-speak4 .bg-top {
        width: 245px;
    }
    #web-one-speak4 .webinar-speaker-img .speaker-detail > div {
        font-size: 24px;
    }    
    #web-one-speak4 .webinar-speaker-img .speaker-detail .desg, #web-one-speak4 .webinar-speaker-img .speaker-detail .com {
        color: #737373;
        font-size: 17px;
    }
}

@media only screen and (max-width: 767px){
    #web-one-speak4 .bg-top {
        display: none;
    }
    #web-one-speak4 .dotted-square {
        display: none;
    }
    #web-one-speak4 .webinar-text h1 {
        font-size: 45px;
        line-height: 1.2;
    }
    #web-one-speak4 .webinar-text p {
        font-size: 22px;
    }
    #web-one-speak4 .webinar-speaker-img {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-top: 55px;
    }
    #web-one-speak4 .webinar-speaker-img .speaker-bg {
        border: 6px solid #254887;
        margin-right: 40px;
        min-width: 160px;
        max-width: 160px;
        min-height: 160px;
        max-height: 160px;
        margin-left: 0;
    }
}

@media only screen and (max-width: 475px){
    #web-one-speak4 .webinar-speaker-img .speaker-detail .desg, #web-one-speak4 .webinar-speaker-img .speaker-detail .com {
        font-size: 14px;
    }
    #web-one-speak4 .webinar-speaker-img .speaker-detail > div {
        font-size: 23px;
    }
    #web-one-speak4 .webinar-text .date-and-time i, #web-one-speak4 .webinar-text .date-and-time{
        display: block;
    }
    #web-one-speak4 .webinar-text .date-and-time > div {
        display: inline-block;
    }
    #web-one-speak4 .webinar-text .date-and-time > * {
        margin-bottom: 18px;
    }
    #web-one-speak4 .webinar-text .register-btn a {
        font-weight: 700;
    }
    #web-one-speak4 .webinar-text .date-and-time {
        margin: 18px 0;
    }
    #web-one-speak4 .webinar-speaker-img .speaker-bg{
        min-width: 120px;
        max-width: 120px;
        min-height: 120px;
        max-height: 120px;
    }
    #web-one-speak4 .webinar-speaker-img {
        margin-top: 44px;
    }
    #web-one-speak4 .webinar-text .date-and-time .date .large-text {
        font-size: 16px;
    }   
}

@media only screen and (max-width: 575px){
    #web-one-speak4 .webinar-text h1 {
        font-size: 30px;
    }
    #web-one-speak4 .webinar-text p {
        font-size: 18px;
    }
    #web-one-speak4{
        display: block;
    }
    #web-one-speak4 .webinar-text .register-btn a{
        margin-top: 0;
    }
}

');
?>