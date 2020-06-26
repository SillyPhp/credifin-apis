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
            <div id="scroll-chat">
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
            <div class="msg-input">
                <form class="form-flex">
                    <textarea class="send-msg" placeholder="Message"></textarea>
                    <button type="button" class="sendMessage"><i class="fas fa-comment"></i></button>
                </form>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="video-details">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="video-action">
                        <div class="webinar-video-title">Business Conferences 2020</div>
                        <div class="webinar-speakers">
                            <p><span>Speakers:</span>
                                <a target="_blank" href="mentor-profile">Tarandeep Singh Rakhra </a>,
                                <a target="_blank" href="">Sneh Kaushal</a> ,
                                <a target="_blank" href="">Ajay Juneja</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="live-count">
                        <i class="fas fa-circle"></i> Viewers: <span>700</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="similar-webinars">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mentor-heading">Similar Webinars</div>
            </div>
        </div>
        <div class="row">
            <?= $this->render('/widgets/mentorships/webinar-card') ?>
            <?= $this->render('/widgets/mentorships/webinar-card') ?>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.msg-input{
    border:1px solid #eee;
    width: 100%;
    height: 80px;
    background: #fff;
    position: fixed; 
    z-index:9;
}
#scroll-chat{
    position:relative;
    height: calc(100% - 90px);
}
.form-flex{
    display: flex;
    align-items: center;
    justify-content: space-between;
     width: 100%;
    height: 80px;

}
.msg-input .form-flex textarea{
    padding: 15px 20px;
    border: none;
    width: 86%;
    height: 100%;

}
.msg-input button{
    font-size: 25px;
    background: transparent;
    border: none;
    height: 100%;
    padding: 5px 10px;
}
.msg-input button:hover{
    color:#00a0e3;
}
.video-action .webinar-video-title{
    text-align: left;
    font-size: 20px;
    color: #333;
    font-family: roboto;
}
.webinar-speakers p span{
    font-weight: bold;
    color:#333;
}
.webinar-speakers p a{
        color:#000;
}
.webinar-speakers p a:hover{
        color:#00a0e3;
}
.mentor-heading {
    font-size: 25px;
    font-family: lora;
    color: #000;
    text-transform: capitalize;
}
.msg-input{
    position: absolute;
    bottom: 0;
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
    width: 70vw;
    height: calc(100vh - 65px);
    background: #000; 
}
.slide-section{
    width:30vw;
    height: calc(100vh - 65px);
    background: #eee;
    position: relative;
        overflow: hidden;
 }
.slide-hide{
    width: 0vw;
    transition: .2s ease;
}
.slide-close-btn{
    position: absolute;
    top: 50%;
    left:0px;
    width: 30px;
    height: 30px;
    color: #000;
    background:#00a0e3;
    display: flex;
    justify-content: center;
    align-items: center; 
    cursor:pointer;
    color:#fff;
}
.video-details{
    background: #f8f8f8;
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


');
$script = <<<JS
const ps = new PerfectScrollbar('#scroll-chat');

JS;
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
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

    document.querySelector('.sendMessage').addEventListener('click', sendMessage);
    let messageText = document.querySelector('.send-msg')
    messageText.addEventListener('keyup', function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            sendMessage();
        }
    });

    function sendMessage() {
        let message = document.querySelector('.send-msg').value;
        let chat = document.querySelector('.chat');
        let chatBox = document.createElement('div');
        chatBox.setAttribute('class', 'chat-box');
        chatBox.innerHTML = `<div class="user-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                            </div>
                            <div class="username-msg">
                                <div class="us-name">Tarandeep Singh Rakhra</div>
                                <div class="us-msg">` + message + `</div>
                            </div>`;
        chat.appendChild(chatBox);
        document.querySelector('.send-msg').value = "";

    }
</script>
