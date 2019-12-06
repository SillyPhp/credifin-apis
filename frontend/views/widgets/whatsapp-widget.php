<?php
use Yii\helpers\url;
?>
    <section class="whatsapp-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="wm-pos-rel">
                        <div class="whats-abso">
                            <h1 class="whats-main-heading">Join Our WhatsApp Community</h1>
                            <div class="whats-sub-heading">Get Latest Job Updates</div>
                            <div class="whats-href">
                                <a href= "<?= Url::to('/whatsapp-community') ?>">
                                    View Links
                                    <span><img src="<?= Url::to('@eyAssets/images/pages/custom/whatsapp-logo-white.png') ?>"> </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="wm-pos-rel-img">
                        <div class="whats-main-img">
                            <a href="/whatsapp-community">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/whats.png') ?>" alt="">
                            </a>
                        </div>
                        <div class="whats-img-chat">
                            <a href="/site/whatsapp-links">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/whtsppmsg.png') ?>" alt="">
                            </a>
                        </div>
                        <div class="whats-img-chat-2">
                            <a href="">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/whtsppmsg2.png') ?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.whats-href {
    margin-top:30px;
}
.whats-href a{
    font-family: roboto;
    color:#fff;
    font-size: 15px;
    padding: 7px 15px;
    border:2px solid #fff;
    position: relative;
    transition:.3s ease;
    overflow: hidden;
    border-radius: 50px;
    width:107px;
    display:inline-block;
}
.whats-href a span{
    position: absolute;
    right: 8px !important;
    top:5px;
    display: none;
}
.whats-href a span img{
    max-height:15px;
    max-width:15px;
}
.whats-href a:hover{
    width:125px;
    transition:.3s ease;
}
.whats-href a:hover span{
    display: block;
}
.whatsapp-bg{
    background: linear-gradient(141deg, #53ccb1, #548c7f);
    min-height:380px;
}
.wm-pos-rel{
    position: relative;
    height:380px;
}
.wm-pos-rel-img{
    position: relative;
    height:380px;
}
.whats-abso{
    position:absolute;
    top:50%;
    transform:translateY(-50%);
}
.whats-main-heading{
    font-family:Roboto;
    color:#fff;
    font-weight:bold;
    font-size:38px;
    margin:0px; 
    text-transform: capitalize;
}
.whats-sub-heading{
    color:#fff;
    font-family: roboto;
    font-size: 30px;  
    text-transform: capitalize;
    margin-top: -10px;
}
.whats-main-img, .whats-img-chat{
    position:absolute;
    top:50%;
    left:50%;
    transform: translate(-50%,-50%);
}
.whats-img-chat{
    position:absolute;
    top:50%;
    margin-top:60px;
    right:0px;
    transform: translateY(-50%);
}
.whats-img-chat-2{
    position:absolute;
    top:50%;
    margin-top:-50px;
    left:80px;
    transform: translateY(-50%);
}
.whats-img-chat img{
    max-width: 200px;
}
.whats-img-chat-2 img{
    max-width:160px;
}
.whats-main-img img{
    animation: rotateWhats 15s infinite;
}
@keyframes rotateWhats{
    0%{transform: rotate(-20deg)}
    50%{transform: rotate(40deg)}
    100%{transform: rotate(-20deg)}
}
')
?>