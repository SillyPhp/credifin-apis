<?php
    use yii\helpers\Url;
?>
<section class="webinar-banner">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="banner-text">
                    <h1>Whither Education</h1>
                    <p>
                        Join our webinar to learn how the Covid scenario has impacted parents, students, and the education system. Our guests will discuss how education has changed over time and what the future of education looks like.
                    </p>
                    <div class="date-time">
                        <div class="date">
                            SEPTEMBER 18
                        </div>
                        <div class="time">
                            3:45PM - 5:14PM
                        </div>
                    </div>
                    <a href="<?= url::to('/webinar/whither-education-the-challenge-of-change-90286')?>" class="register-btn">Register Now <i class="fas fa-angle-double-right"></i></a>
                    <div class="share-bar">
                        <a target="_blank" href="https://www.facebook.com/sharer.php?u=https://empoweryouth.com/webinar/whither-education-the-challenge-of-change-90286" class="share-fb"><i class="fab fa-facebook-f"></i></a>
                        <a target="_blank" href="https://telegram.me/share/url?url=https://empoweryouth.com/webinar/whither-education-the-challenge-of-change-90286" class="tg-tele"><i class="fab fa-telegram-plane"></i></a>
                        <a target="_blank" href="https://api.whatsapp.com/send?text=https://empoweryouth.com/webinar/whither-education-the-challenge-of-change-90286" class="share-linkedin"><i class="fab fa-whatsapp"></i></a>
                        <a target="_blank" href="mailto:?&body=https://empoweryouth.com/webinar/whither-education-the-challenge-of-change-90286" class="share-twitter"><i class="far fa-envelope-open"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="banner-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/webinar-widgets/webinar-speaker1.png')?>"/>
                    <img src="<?= Url::to('@eyAssets/images/pages/webinar-widgets/webinar-speaker2.png')?>"/>
                    <div class="special-guest">
                        <div class="heading">Special Guest</div>
                        <div class="guest-name">Saurabh Sameer</div>
                        <div class="guest-desg">
                            AM (RBI)
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
<?php
$this->registerCss('
.webinar-banner {
    background-image: url("https://user-images.githubusercontent.com/72601463/133228470-e9a7ce52-d6cb-4c7d-a012-0497919252cc.png");
    min-height: 500px;
    padding: 50px 0px;
    color: #fff;
    position: relative;
    background-repeat: no-repeat;
    background-size: cover;
}

.banner-text p {
    max-width: 470px;
    color: #eeeeee;
    text-align: justify;
}

.banner-text h1 {
    font-size: 45pt;
    font-family: Roboto;
    margin-bottom:15px;
    color: #fff;
}

.banner-text .date-time {
    font-family: "Roboto";
    font-size: 16pt;
}

.banner-text .date {
    margin-bottom: 5px;
    font-size: 20pt;
    font-weight: 700;
    letter-spacing: 2px;
    font-family: monospace;
}
.banner-text .time {
    /*font-size: 12pt;*/
    font-size: 17pt;
    font-weight: 700;
    letter-spacing: 2px;
    font-family: monospace;
}

.banner-text .register-btn {
    background: linear-gradient(91.16deg, #FFBB54 -43.72%, #CB650C 125.14%, #DB7E2E 125.14%);
    border-radius: 27px;
    padding: 15px 30px;
    display: inline-block;
    margin-top: 20px;
    color: #fff;
    /*font-family: "farro";*/
}

.banner-img img {
    width: 350px;
}

.banner-img img:nth-child(1) {
display: block;
    margin-left: auto;
}

.banner-img img:nth-child(2) {
margin-top: -50px;
}

.special-guest {
    background: #7730C9;
    border-radius: 5px 0px 0px 5px;
    width: 100%;
    position: absolute;
    right: 0;
    max-width: 500px;
    padding-bottom: 15px;
    clip-path: polygon(100% 0, 95% 50%, 100% 100%, 0% 100%, 0% 50%, 0% 0%);
}

.special-guest .heading {
    background: #FFFFFF;
    border-radius: 5px 0px;
    color: #7730C9;
    width: 150px;
    padding: 5px 0 5px 20px;
    font-weight: 700;
    font-family: "farro";;
}

.guest-name {
    color: #E8B41D;
    font-weight: 700;
    font-size: 14pt;
    padding-left: 20px;
    margin-top: 10px;
}

.guest-desg {
    padding-left: 20px;
    font-weight: 700;
    padding-bottom: 5px;
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
@media screen and (max-width: 768px){
    .special-guest{
        position: relative;
        float: right;
    }
}
@media screen and (max-width: 550px){
    .banner-img img{
        width: 100%;
        margin-top: 0px; 
    }
    .banner-img img:nth-child(2) {
        margin-top: 0px;
    }
}
');
