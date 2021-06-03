<?php

use yii\helpers\Url;

?>
<section class="contributor-bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 col-sm-7">
                <div class="bulb movi">
                    <img src="<?= Url::to('@eyAssets/images/pages/Colabraters-img/bulb.png'); ?>"/>
                </div>
                <div class="brain movi">
                    <img src="<?= Url::to('@eyAssets/images/pages/Colabraters-img/brain.png'); ?>"/>
                </div>
                <div class="con-text">
                    <div class="con-txt">
                    <h1>Our Contributors</h1>
                    <p>Read Dynamic and Latest Content To Enhance Your Knowledge.</p>
                    </div>
                </div>
                <div class="chat movi">
                    <img src="<?= Url::to('@eyAssets/images/pages/Colabraters-img/chat1.png'); ?>"/>
                </div>
                <div class="chat1 movi">
                    <img src="<?= Url::to('@eyAssets/images/pages/Colabraters-img/chat2.png'); ?>"/>
                </div>
                <div class="stat movi">
                    <img src="<?= Url::to('@eyAssets/images/pages/Colabraters-img/stats.png'); ?>"/>
                </div>
            </div>
            <div class="col-md-5 col-sm-5">
                <div class="contri-vector">
                    <img src="<?= Url::to('@eyAssets/images/pages/Colabraters-img/contribute-hdr-vector.png'); ?>"/>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mgtp10">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="collaborators-main">
                    <div class="c-detail">
                        <h4 class="title">Name</h4>
                        <span class="post">Contributor</span>
                        <ul class="social-icon">
                            <li><a href="https://www.facebook.com/{{facebook}}"
                                   target="_blank">
                                    <i class="fab fa-facebook"></i></a>
                            </li>

                            <li><a href="https://www.twitter.com/twitter"
                                   target="_blank">
                                    <i class="fab fa-twitter"></i></a>
                            </li>

                            <li><a href="https://www.linkedin.com/in/"
                                   target="_blank">
                                    <i class="fab fa-linkedin"></i></a>
                            </li>

                            <li><a href="https://www.instagram.com/"
                                   target="_blank">
                                    <i class="fab fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="thumb">
                        <img src="<?= Url::to('@eyAssets/images/pages/Colabraters-img/nw(1).png'); ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registercss('
.footer {
    margin-top: 0px !important;
}
.contributor-bg {
    background: url(' . Url::to('@eyAssets/images/pages/Colabraters-img/contribute-hdr-bg2.png') . ');
    background-repeat: no-repeat;
    background-size: cover;
	min-height: 500px;
	position: relative;
}
.contri-vector {
     display: flex;
    align-items: flex-end;
    min-height: 480px;
}
.contri-vector img {
    width: 100%;
    max-width: 500px;
}
.con-text {
    display: flex;
    justify-content: flex-start;
    align-items: flex-end;
    padding-left: 60px;
    min-height: 360px;
}
.con-txt h1 {
    font-family: roboto;
    font-weight: 600;
    color: #000;
    letter-spacing: 0.5px;
}
.con-txt p {
    font-size: 19px;
    font-family: roboto;
    color: #000;
    font-weight: 500;
    line-height: 28px;
    letter-spacing: 0.3px;
}
.bulb{
    position: absolute;
    top: 120px;
    left: 70px;
    width: 90px;
    height: 100px;
}
.brain{
    position: absolute;
    top: 120px;
    left: 300px;
    width: 90px;
    height: 100px;
}
.chat {
    position: absolute;
    bottom: -100px;
    left: 70px;
    width: 90px;
    height: 100px;
}
.chat img, .chat1 img {
    width: 100%;
    max-width: 60px;
}
.chat1 {
    position: absolute;
    bottom: -120px;
    right: 230px;
    width: 90px;
    height: 100px;
}
.stat {
    position: absolute;
    bottom: -140px;
    right: 65px;
    width: 90px;
    height: 100px;
}
.brain, .chat, .stat {
    animation: pulse 3s infinite;
}
@keyframes pulse {
  0% {
    opacity:0;
  }
  25% {
    opacity:0.5;
  }
  50% {
    opacity:1;
  }
  75% {
    opacity: 0.5;
  }
  100% {
    opacity:0;
  }
}
.bulb, .chat1 {
    animation: pulse 2s infinite;
}
@keyframes pulse2 {
  0% {
    opacity:1;
  }
  25% {
    opacity:0.5;
  }
  50% {
    opacity:0;
  }
  75% {
    opacity:0.5;
  }
  100% {
    opacity:1;
  }
}
.mgtp10 {
    margin-top: 20px;
}
.collaborators-main {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start;
    overflow: hidden;
    margin-bottom:20px;
}
.collaborators-main .c-detail {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    height: 200px;
    width:calc(100% - 200px);
}
.collaborators-main .c-detail .title {
    font-size: 20px;
    line-height: 30px;
    color: #07c3ff;
    font-weight: 700;
    margin-bottom: 10px;
}
.collaborators-main .c-detail .title {
    font-size: 18px;
    color: #2a384c;
}
.collaborators-main .c-detail .post {
    font-size: 16px;
    line-height: 26px;
    color: #616161;
}
.collaborators-main .c-detail .post {
    font-size: 14px;
    color: #197BEB;
}
.collaborators-main .c-detail .social-icon {
    margin: 0;
    padding: 0;
    margin-top: 20px;
    position: relative;
    padding-top: 20px;
}
.collaborators-main .c-detail .social-icon li {
    list-style: none;
    display: inline-block;
    margin: 0px;
    text-align: center;
}
.collaborators-main .c-detail .social-icon li a {
    display: block;
    width: 30px;
    height: 30px;
    line-height: 30px;
    border-radius: 50%;
    background-color: #dfdfdf;
    -webkit-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.53);
    box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.53);
    color: #4f78ee;
    font-size: 14px;
    -webkit-transition: .3s ease-in;
    -o-transition: .3s ease-in;
    transition: .3s ease-in;
}
.collaborators-main .c-detail .social-icon li a {
    background-color: #f2f2f2;
    color: #515151;
    font-size: 16px;
}
.collaborators-main .thumb {
    width: 200px;
    height: 200px;
    overflow: hidden;
    margin-left: 10px;
}

.collaborators-main .thumb img {
    -webkit-transition: 1s ease-in-out;
    -o-transition: 1s ease-in-out;
    transition: 1s ease-in-out;
  width:100%;
}
.collaborators-main .c-detail .social-icon:after {
    position: absolute;
    left: 0;
    top: 0;
    width: 120%;
    background-color: #07c3ff;
    content: "";
    height: 1px;
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
    -webkit-transition: 1s ease-in;
    -o-transition: 1s ease-in;
    transition: 1s ease-in;
    z-index: 1;
}
.collaborators-main .c-detail .social-icon:after {
    background-color: #197BEB;
}
.collaborators-main:hover .thumb img {
    -webkit-transform: scale(1.3);
    -ms-transform: scale(1.3);
    transform: scale(1.3);
}
.collaborators-main:hover .c-detail .social-icon:after {
    -webkit-transform: translateX(0%);
    -ms-transform: translateX(0%);
    transform: translateX(0%);
}
@media screen and (max-width: 600px) and (min-width:441px) {
    .con-text {
        padding-left: 0px;
        min-height: 308px;
    }
    .contri-vector {
        display: none;
    }
    .brain {
        top: 125px;
        left: 330px;
    }
    .chat1 {
        right: 165px;
    }
}
@media screen and (max-width: 440px) and (min-width:320px) {
    .con-text {
        padding-left: 0px;
        min-height: 308px;
    }
    .contri-vector {
        display: none;
    }
    .brain {
        top: 125px;
        left: 220px;
    }
    chat {
        left: 25px;
    }
    .chat1 {
        bottom: -86px;
        right: 48px;
    }
    .stat {
        bottom: -160px;
        right: 115px;
    }
    .con-txt p {
        font-size: 18px;
        line-height: 24px;
    }
');


