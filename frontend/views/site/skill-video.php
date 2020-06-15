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
            <div class="contentHeading">Course Details</div>
            <ol>
                <li class="liActive">
                    <button class="vTitleBtn">
                        <i class="fas fa-play"></i>
                        <span class="w70">1. Introduction</span>
                        <span class="w30">1:45</span>
                    </button>
                </li>
                <li>
                    <button class="vTitleBtn">
                        <i class="fas fa-play"></i>
                        <span class="w70">2. The power of found footage</span>
                        <span class="w30">3:00</span>
                    </button>
                </li>
                <li>
                    <button class="vTitleBtn">
                        <i class="fas fa-play"></i>
                        <span class="w70">3. The science behind found footage</span>
                        <span class="w30">2:15</span>
                    </button>
                </li>
                <li>
                    <button class="vTitleBtn">
                        <i class="fas fa-play"></i>
                        <span class="w70">4. The power of found footage</span>
                        <span class="w30">3:00</span>
                    </button>
                </li>
            </ol>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.contentHeading{
    font-size: 20px;
    color: #000;
    font-family: lora;
}
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
    padding: 20px 30px;
}
.slide-section ol{
    width: 100%;
}
.slide-section ol li{
    font-size: 16px;
    color:#000;
}
.slide-section ol li button{
    color:#000;
    width: 100%;
    display: flex;
    text-align: left;
    border: none;
    background: transparent;
    padding: 10px 10px;
    width: 100%;
    position: relative;
}
.slide-section ol li:hover button, 
.slide-section ol li.liActive button{
    background: #00a0e3;
    color:#fff;
    transition: .2s ease;
}
.slide-section ol li button i{
    display: none;
    position: absolute;
    left: -20px;
    top: 0;
}
.slide-section ol li.liActive button i{
    display: block;
    color: #00a0e3;
}
.slide-section ol li.liActive button span.w70{
    width: 85%;
}
.slide-section ol li button span.w70{
    width: 85%;
}
.w30{
    width: 15%;
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
// const ps = new PerfectScrollbar('#scroll-chat');

JS;
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>

    let vTitleBtn = document.getElementsByClassName('vTitleBtn');
    for (let i = 0; i < vTitleBtn.length; i++){
        vTitleBtn[i].addEventListener('click', function () {
            let liActive = document.getElementsByClassName('liActive');
            if(liActive.length > 0){
                liActive[0].classList.remove('liActive');
            }
            let li = event.currentTarget.parentElement;
            li.classList.add('liActive');
        })
    }
    // document.querySelector('.slide-close-btn').addEventListener('click', hideSlide);

    // function hideSlide() {
    //     let slideSec = document.querySelector('.slide-section');
    //     let videoSec = document.querySelector('.video-section');
    //     let chatBoxes = document.querySelector('.chat');
    //     if (slideSec.classList.contains('slide-hide')) {
    //         slideSec.classList.remove('slide-hide');
    //         videoSec.style.width = '80vw';
    //         chatBoxes.style.display = "block"
    //
    //     } else {
    //         slideSec.classList.add('slide-hide');
    //         videoSec.style.width = '100vw';
    //         chatBoxes.style.display = "none";
    //
    //     }
    // }

</script>
