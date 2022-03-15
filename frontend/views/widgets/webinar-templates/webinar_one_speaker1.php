<script id="temp_<?=$webinar_enc_id ?>" type="text/template">
    <section class="webinar-one-speaker" id="web-one-speak1">
        <div class="container">
        <div class="row">
        <div class="col-md-12">
            <div class="webinar-text">
                <h1>{{name}}</h1>
                <div class="date-time">
                    <span class="date">{{date}}</span>
                    <span class="time">{{time}}</span>
                </div>
                    <p>{{description}}</p>
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
    </div>
    <div class="webinar-speaker-img">
        <div class="rotate-div">
            <div class="speaker-img">
            <img src="{{speaker_image}}">

            </div>
            <div class="speaker-detail">
                <h2>{{speaker_name}}</h2>
                <h5>{{speaker_designation}}</h5>
            </div>
        </div>
    </div>
    </div>
    </section>
</script>
<?php
$this->registerCss('
img {
    width: 100%;
}
#web-one-speak1 {
    background: url(/assets/themes/ey/images/pages/webinar/webinar-one-speaker-bg.png);
    min-height: 550px;
    overflow: hidden;
    background-repeat: no-repeat;
    background-size: cover;
}
#web-one-speak1 .container {
    min-height: 550px;
    display: flex;
    align-items: center;
    position: relative;
}
#web-one-speak1 .row{
    position: relative;
    z-index: 2;
}
#web-one-speak1 .webinar-text{
    max-width: 400px;
}
#web-one-speak1 .webinar-text h1 {
    color: #fff;
    font-family: Roboto;
    text-transform: uppercase;
    font-size: 45px;
    line-height: 1.3;
    text-align: left;
}
#web-one-speak1 .date-time span {
    display: block;
    line-height: 23px;
    font-family: farro;
    text-transform: uppercase;
    color: #fff;
    font-size: 20px;
    font-weight: 600;
}
#web-one-speak1 .webinar-text p {
    line-height: 17px;
    color: #c0c0c0;
    margin: 22px 0 0 0;
}
#web-one-speak1 a.register-btn {
    background: linear-gradient(91.16deg, #FFBB54 -43.72%, #CB650C 125.14%, #DB7E2E 125.14%);
    border-radius: 27px;
    padding: 15px 30px;
    display: inline-block;
    margin-top: 20px;
    color: #fff;
    transition: all linear .3s;
}
#web-one-speak1 a.register-btn i{
    transition: all linear .3s;
}
#web-one-speak1 a.register-btn:hover{
    color: #fff;
    transition: all linear .3s;
}
#web-one-speak1 a.register-btn:hover i{
    margin-left: 15px;
    transition: all linear .3s;
}
#web-one-speak1 .share-bar {
    margin-top: 20px;
}

#web-one-speak1 .share-bar a {
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

#web-one-speak1 .share-bar .fab, #web-one-speak1 .share-bar .far {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

#web-one-speak1 .share-bar a:not(.share-fb) {
    margin-left: 7px;
}

#web-one-speak1 .share-bar a.share-fb {
    color: #3b5998;
}

#web-one-speak1 .share-bar a.share-twitter {
    color: #1DA1F2;
}

#web-one-speak1 .share-bar a.share-whatsapp {
    color: #25D366;
}
#web-one-speak1 .share-bar a.share-linkedin {
    color: #0e76a8;
}

#web-one-speak1 .share-bar a.tg-tele {
    color: #0088cc;
    border-color: #0088cc;
}

#web-one-speak1 .share-bar a:hover {
    color: #fff;
    transition: 0.2s all ease-in;
    font-size: 12px;
    border-radius: 20px;
}

#web-one-speak1 .share-bar a.share-fb:hover {
    background-color: #3b5998;
}

#web-one-speak1 .share-bar a.share-twitter:hover {
    background-color: #1DA1F2;
}

#web-one-speak1 .share-bar a.share-whatsapp:hover {
    background-color: #25D366;
}
#web-one-speak1 .share-bar a.share-linkedin:hover {
    background-color: #0e76a8;
}

#web-one-speak1 .share-bar a.tg-tele:hover {
    background-color: #0088cc;
    border-color: #0088cc;
}
#web-one-speak1 .webinar-speaker-img {
    width: 70%;
    position: absolute;
    height: 100%;
    right: -200px;
    top: -76px;
    display: flex;
    align-items: center;
}
#web-one-speak1 .rotate-div {
    width: 100%;
    height: 250px;
    background: #323e5a;
    display: flex;
    align-items: center;
    border-radius: 140px;
    transform: rotate(-45deg) translate(30px, -120px);
}
#web-one-speak1 .speaker-img {
    width: 230px;
    background: #fff;
    border-radius: 50%;
    height: 230px;
    margin-left: 10px;
    overflow: hidden;
}
#web-one-speak1 .speaker-detail {
    margin-left: 20px;
}
#web-one-speak1 .speaker-detail h2 {
    color: #fff;
    font-family: Roboto;
}
#web-one-speak1 .speaker-detail h5 {
    color: #afafaf;
    margin: 0;
    font-weight: 600;
}
#web-one-speak1 .rotate-div div {
    transform: rotate(45deg);
}

@media only screen and (max-width: 992px){
    #web-one-speak1 .rotate-div{
        transform: rotate(-90deg) translate(30px, -120px);
    }
    #web-one-speak1 .rotate-div div{
        transform: rotate(90deg);
    }
    #web-one-speak1 .webinar-speaker-img{
        right: -260px;
    }
    #web-one-speak1 .webinar-text h1{
        font-size: 35px;
    }
}
@media only screen and (max-width: 767px){
    #web-one-speak1{
        display: flex;
        align-items: center;
    }
    #web-one-speak1 .container{
        width: 100%;
    }
    #web-one-speak1 .webinar-speaker-img{
        right: -65px;
        top: -39px;
        align-items: flex-start;
    }
    #web-one-speak1 .rotate-div{
        transform: none;
        height: 160px;
    }
    #web-one-speak1 .speaker-img{
        width: 140px;
        height: 140px;
    }
    #web-one-speak1 .rotate-div div{
        transform: none;
        margin-left: 8px;
    }
    #web-one-speak1 .webinar-text h1{
        max-width: 280px;
    }
    #web-one-speak1 .speaker-detail h5{
        font-size: 10px;
    }
}
@media only screen and (max-width: 576px){
    #web-one-speak1 .webinar-speaker-img{
        align-items: flex-end;
        top: 0;
        width: 110%;
    }
    #web-one-speak1 .container{
        align-items: flex-start;
        margin-top: 30px;
    }
    #web-one-speak1 .rotate-div{
        margin-bottom: 10px;
    }
    #web-one-speak1 .webinar-text h1{
        max-width: 100%;
        font-size: 28px;
    }
    #web-one-speak1 .webinar-text{
        max-width: 100%;
    }
    #web-one-speak1 .rotate-div{
        height: 120px;
    }
    #web-one-speak1 .speaker-img{
        width: 100px;
        height: 100px;
    }
    #web-one-speak1{
        min-height: 650px;
    }
}
@media only screen and (max-width: 375px){
    .webinar-speaker-img{
        right: -60px;
        width: 108%;
    }
    #web-one-speak1 .rotate-div{
        height: 140px;
    }
    #web-one-speak1 .speaker-img{
        width: 120px;
        height: 120px;
    }
    #web-one-speak1{
        min-height: 620px;
    }
    #web-one-speak1 .container{
        min-height: 620px;
    }
}
');
$script = <<<JS
    getWebinarDetails('$webinar_enc_id');
JS;
$this->registerJs($script);
