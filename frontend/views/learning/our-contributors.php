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
                    <p>Read The Dynamic Content Provided By The<br> Best Contributors To Enhance Your Knowledge.</p>
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

<?php
$this->registercss('
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
    font-size: 20px;
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
');


