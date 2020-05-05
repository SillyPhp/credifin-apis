<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
<section>
    <div class="videoFlex">
        <div class="video-section">
            <iframe src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
        </div>
        <div class="slide-section">
            <div class="slide-close-btn">X</div>
            <div class="chat">
                <div class="chat-box">
                    <div class="user-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                    </div>
                    <div class="username-msg">
                        <div class="us-name">Tarandeep Singh Rakhra</div>
                        <div class="us-msg">Registration is powered by Sign In Once</div>
                    </div>
                </div>
                <div class="chat-box">
                    <div class="user-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                    </div>
                    <div class="username-msg">
                        <div class="us-name">Tarandeep Singh Rakhra</div>
                        <div class="us-msg">Registration is powered by Sign In Once</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="video-details">
        <div class="row">
            <div class="col-md-3">
                <div class="live-count">
                    <i class="fas fa-circle"></i> Current Viewers<br> <span>700</span>
                </div>
            </div>
            <div class="col-md-9">
                <div class="video-action">
                    video action buttons
                </div>
            </div>
        </div>
    </div>
</section>
<section class="">
    <div class="webinar-widget">
        <div class="row">
            <div class="col-md-12">
                <h4>You have been invited to join webinar on Web Designing</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p><span>Speaker:</span> Mr. Kumar Shalya Gupta</p>
                <p><span>Participants:</span> 700+</p>
                <p><span>Interested:</span> 700+</p>
            </div>
            <div class="col-md-6">
                <div class="webinar-join-btn">
                    <a href="">Join Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
#footer{
    margin-top: 0px;
}
.video-section iframe{
    width: 100%;
    height:100%;
    object-fit: contain;
}
.chat-box{
    display: flex;
    padding: 10px 15px;
    width: 100%;
}
.user-icon{
    width: 50px;
    height: 50px;
    z-index: 1
}
.user-icon img{
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    object-position: top center;
}
.username-msg{
    background: #fff;
    padding:10px 10px 10px 15px;
    margin-left: -25px;
    z-index:0;
    margin-top: 15px;
    width: 100%;
    border-radius: 10px;
}
.us-name{
    font-size: 14px;
    font-weight: bold;
    font-family: roboto; 
    padding-left:20px;
}
.us-msg{
    font-size: 14px;
    font-family: roboto;
}
.fullwidth-page > #wrapper.clearfix > .main-content{
   padding-top: 0px !important;
}
.videoFlex{
    display: flex;
}
.video-section{
    width: 80vw;
    height: calc(100vh - 65px);
    background: #000; 
}
.slide-section{
    width:20vw;
    height: calc(100vh - 65px);
    background: #eee;
    position: relative;
 }
.slide-hide{
    width: 0vw;
    transition: .3s ease;
}
.slide-close-btn{
    position: absolute;
    top: 00px;
    left:-50px;
    width: 50px;
    height: 50px;
    color: #000;
    background:#eeeeee;
    display: flex;
    justify-content: center;
    align-items: center; 
    cursor:pointer;
}
.video-details{
    background: #eee;
    padding: 20px 0;
}
.live-count{
    text-align:center;
    flex:1;
}
.live-count span{
    font-weight: bold;
}
.live-count i{
    color: green;
}
.video-action{
}

.webinar-widget{
    text-align: center;
}
.webinar-widget h4{
    text-transform: capitalize;
    color: #333; 
}
.webinar-join-btn a{
    padding:10px 20px;
    background: #00a0e3;
    color: #fff;
}
.webinar-widget p span{
    font-weight: bold;
}
');
$script = <<<JS

JS;
$this->registerJS($script);
?>
<script>
    document.querySelector('.slide-close-btn').addEventListener('click', hideSlide);

    function hideSlide() {
        let slideSec = document.querySelector('.slide-section');
        let videoSec = document.querySelector('.video-section');
        let chatBoxes = document.querySelector('.chat');
        if (slideSec.classList.contains('slide-hide')) {
            slideSec.classList.remove('slide-hide');
            videoSec.style.width = '80vw';
            chatBoxes.style.display = "block"

        } else {
            slideSec.classList.add('slide-hide');
            videoSec.style.width = '100vw';
            chatBoxes.style.display = "none";

        }
    }
</script>