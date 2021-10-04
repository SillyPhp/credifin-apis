<?php

use yii\helpers\Url;
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Farro:wght@400;500;700&display=swap" rel="stylesheet">

<section class="webinar-one-speaker">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <div class="webinar-text">
                <h1>How to get Your Dream Job</h1>
                <div class="date-time">
                    <span class="date">8 October</span>
                    <span class="time">1:20 PM - 2:20 PM</span>
                </div>
                <p>Are you ready for your dream career? Don’t miss the upcoming webinar on “how to get your dream job?” so that you are no longer confused and frustrated when it comes to making your career decision. The webinar with Vishal Verma will be live soon so register now!</p>
                <a href="/webinar/how-to-get-your-dream-job-4790" class="register-btn">Register Now <i class="fas fa-angle-double-right"></i></a>
                <div class="share-bar">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://www.empoweryouth.com/webinar/how-to-get-your-dream-job-4790" class="share-fb"><i class="fab fa-facebook-f"></i></a>
                    <a target="_blank" href="https://telegram.me/share/url?url=https://www.empoweryouth.com/webinar/how-to-get-your-dream-job-4790" class="tg-tele"><i class="fab fa-telegram-plane"></i></a>
                    <a target="_blank" href="https://api.whatsapp.com/send?text=https://www.empoweryouth.com/webinar/how-to-get-your-dream-job-4790" class="share-linkedin"><i class="fab fa-whatsapp"></i></a>
                    <a target="_blank" href="https://twitter.com/intent/tweet?text=https://www.empoweryouth.com/webinar/how-to-get-your-dream-job-4790" class="share-twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="webinar-speaker-img">
        <div class="rotate-div">
            <div class="speaker-img">
            <img src="<?= Url::to('@eyAssets/images/pages/webinar/vishal-verma-pic.png') ?>">

            </div>
            <div class="speaker-detail">
                <h2>Vishal Verma</h2>
                <h5>Personality Development Coach</h5>
                <h5>International IELTS Trainer</h5>
                <h5>Natitonal Debate Champion</h5>
            </div>
        </div>
    </div>
    </div>
</section>

<?php $this->registerCss('
    .webinar-one-speaker {
        background: url('.Url::to('@eyAssets/images/pages/webinar/webinar-one-speaker-bg.png').');
        min-height: 550px;
        overflow: hidden;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .webinar-one-speaker .container {
        min-height: 550px;
        display: flex;
        align-items: center;
        position: relative;
    }
    .webinar-one-speaker .row{
        position: relative;
        z-index: 2;
    }
    .webinar-text{
        max-width: 400px;
    }
    .webinar-text h1 {
        color: #fff;
        font-family: Roboto;
        text-transform: uppercase;
        font-size: 45px;
        line-height: 1;
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
    .webinar-text p {
        line-height: 17px;
        color: #c0c0c0;
        margin: 22px 0 0 0;
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
        color: #1DA1F2;
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
        background-color: #1DA1F2;
    }
    
    .share-bar a.share-linkedin:hover {
        background-color: #25D366;
    }
    
    .share-bar a.tg-tele:hover {
        background-color: #0088cc;
        border-color: #0088cc;
    }
    .webinar-speaker-img {
        width: 70%;
        position: absolute;
        height: 100%;
        right: -200px;
        top: -76px;
        display: flex;
        align-items: center;
    }
    .rotate-div {
        width: 100%;
        height: 250px;
        background: #323e5a;
        display: flex;
        align-items: center;
        border-radius: 140px;
        transform: rotate(-45deg) translate(30px, -120px);
    }
    .speaker-img {
        width: 230px;
        background: #fff;
        border-radius: 50%;
        height: 230px;
        margin-left: 10px;
    }
    .speaker-detail {
        margin-left: 20px;
    }
    .speaker-detail h2 {
        color: #fff;
        font-family: Roboto;
    }
    .speaker-detail h5 {
        color: #afafaf;
        margin: 0;
        font-weight: 600;
    }
    .rotate-div div {
        transform: rotate(45deg);
    }

    @media only screen and (max-width: 992px){
        .rotate-div{
            transform: rotate(-90deg) translate(30px, -120px);
        }
        .rotate-div div{
            transform: rotate(90deg);
        }
        .webinar-speaker-img{
            right: -260px;
        }
        .webinar-text h1{
            font-size: 35px;
        }
    }
    @media only screen and (max-width: 768px){
        .webinar-speaker-img{
            right: -94px;
            top: 30px;
            align-items: flex-start;
        }
        .rotate-div{
            transform: none;
            height: 160px;
        }
        .speaker-img{
            width: 140px;
            height: 140px;
        }
        .rotate-div div{
            transform: none;
        }
        .webinar-text h1{
            max-width: 280px;
        }
        .speaker-detail h5{
            font-size: 10px;
        }
    }
    @media only screen and (max-width: 576px){
        .webinar-speaker-img{
            align-items: flex-end;
            top: 0;
            width: 110%;
        }
        .webinar-one-speaker .container{
            align-items: flex-start;
            margin-top: 30px;
        }
        .rotate-div{
            margin-bottom: 10px;
        }
        .webinar-text h1{
            max-width: 100%;
            font-size: 30px;
        }
        .webinar-text{
            max-width: 100%;
        }
        .rotate-div{
            height: 120px;
        }
        .speaker-img{
            width: 100px;
            height: 100px;
        }
    }
    @media only screen and (max-width: 375px){
        .webinar-speaker-img{
            right: -60px;
            width: 108%;
        }
        .rotate-div{
            height: 140px;
        }
        .speaker-img{
            width: 120px;
            height: 120px;
        }
        .webinar-one-speaker{
            min-height: 620px;
        }
        .webinar-one-speaker .container{
            min-height: 620px;
        }
    }
') ?>