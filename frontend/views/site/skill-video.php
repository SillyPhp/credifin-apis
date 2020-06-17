<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
<section>
    <div class="videoFlex">
        <div class="video-section">
            <div class="video-title">Filmmaking from home | The power of found footage |  The science behind found footage
                | Filmmaking from home
            </div>
            <iframe src="https://www.youtube.com/embed/"></iframe>
        </div>
        <div class="slide-section">
            <div class="contentHeading">Lessons</div>
            <ol>
                <li class="liActive">
                    <button class="vTitleBtn">
                        <i class="fas fa-play"></i>
                        <span class="w70">1. Introduction</span>
                        <span class="w30">01:45</span>
                    </button>
                </li>
                <li>
                    <button class="vTitleBtn">
                        <i class="fas fa-play"></i>
                        <span class="w70">2. The power of found footage</span>
                        <span class="w30">03:00</span>
                    </button>
                </li>
                <li>
                    <button class="vTitleBtn">
                        <i class="fas fa-play"></i>
                        <span class="w70">3. The science behind found footage</span>
                        <span class="w30">02:15</span>
                    </button>
                </li>
                <li>
                    <button class="vTitleBtn">
                        <i class="fas fa-play"></i>
                        <span class="w70">4. The power of found footage</span>
                        <span class="w30">03:00</span>
                    </button>
                </li>
            </ol>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="position-relative">
                <div class="col-md-3" id="hSticky">
                <div class="course-menu">
                    <h3>Course Information</h3>
                    <ul class="nav nav-tabs tabs-left">
                        <li class="active"><a href="#tabOne" data-toggle="tab">About</a></li>
                        <li><a href="#tabTwo" data-toggle="tab">Reviews</a></li>
                        <li><a href="#tabThree" data-toggle="tab">Project & Resources</a></li>
                    </ul>
                </div>
            </div>
                <div class="col-md-9" id="hData">
                <div class="tab-content">
                    <div class="tab-pane active" id="tabOne">
                        <div class="row">
                            <div class="col-md-9">
                                <h3>About This Class</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                <h4>Why do we use it?</h4>
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="tabTwo">
                        <h3>Choosing Your Class Project</h3>
                        <p>Since EmpowerYouth focuses on project-based learning so all classes must have project component. This is because we believe that project helps the students to give a practical touch to their new skill.</p>
                        <p>Tips for creating a class project more exciting for students:</p>
                        <h4>1. Project should be easy to start</h4>
                        <p>Students always prefer those projects which are quick and easy to do over time consuming and complicated projects. So, we recommend you to devise projects which are lightweight so that students can feel immediate sense of accomplishment without feeling any sort of burden.
                        </p>
                        <h4>2. Give clear-cut instructions</h4>
                        <p>When students are given clear instructions they are more willing to complete the task. So give the description of your project in such a manner that it encourages students to complete the project. If you want to provide any additional resource to help the students to complete the task feel free to attach such file.
                        </p>
                        <h4>3. Encourage students to share their work</h4>
                        <p>When students are encouraged to share their work it helps them in many ways. It helps to create better learning experience for other students. Also when the creator of the project gets feedback from others it helps in the overall growth and development of creator. So, we recommend to encourage your students to share their work-in-progress.
                        </p>
                    </div>
                    <div class="tab-pane" id="tabThree">
                        <h3>Choosing Your Class Project</h3>
                        <p>Since EmpowerYouth focuses on project-based learning so all classes must have project component. This is because we believe that project helps the students to give a practical touch to their new skill.</p>
                        <p>Tips for creating a class project more exciting for students:</p>
                        <h4>1. Project should be easy to start</h4>
                        <p>Students always prefer those projects which are quick and easy to do over time consuming and complicated projects. So, we recommend you to devise projects which are lightweight so that students can feel immediate sense of accomplishment without feeling any sort of burden.
                        </p>
                        <h4>2. Give clear-cut instructions</h4>
                        <p>When students are given clear instructions they are more willing to complete the task. So give the description of your project in such a manner that it encourages students to complete the project. If you want to provide any additional resource to help the students to complete the task feel free to attach such file.
                        </p>
                        <h4>3. Encourage students to share their work</h4>
                        <p>When students are encouraged to share their work it helps them in many ways. It helps to create better learning experience for other students. Also when the creator of the project gets feedback from others it helps in the overall growth and development of creator. So, we recommend to encourage your students to share their work-in-progress.
                        </p>
                    </div>
                </div>
           </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.tab-pane h3{
    margin-top: 5px;
}
.tab-pane p{
    text-align: justify;
}
.nav-tabs > li{
    width: 100%;
}
.nav-tabs > li.active a, 
.nav-tabs > li.active a:hover, 
.nav-tabs > li.active a:focus{
    background: #00a0e3;
    color:#fff;
    border-bottom: 1px solid #fff !important;
}
.nav-tabs > li > a{
    font-size: 16px;
    color:#000;
    padding: 10px 15px;  
    text-align: left;  
}
.nav-tabs>li>a:hover {
    border-color: #00a0e3 #00a0e3 #00a0e3;
    background: #00a0e3;
    color:#fff
}
.position-relative{
    position: relative;
}
.contentHeading{
    font-size: 20px;
    color: #000;
    font-family: lora;
    padding: 0 20px;
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
.video-section{
    position: relative;
    overflow: hidden;
}
.video-section iframe{
    width: 100%;
    height:100%;
    object-fit: contain;
}
.video-title{
    position: absolute;
    top: -100px;
    width: 100%;
    background: rgba(0,0,0,.6);
    padding: 20px;
    color:#fff;
    font-weight: 500;
    font-size: 18px;
    transition: .2s ease;
    line-height: 25px;
    font-family: roboto;
}
.video-section:hover .video-title{
    top:0;
    transition: .2s ease;
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
    padding: 20px 0px;
}
.slide-section ol{
    width: 100%;
}
.slide-section ol li{
    font-size: 16px;
    color:#000;
    padding: 0px 30px;
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
    color:#fff;
    transition: .2s ease;
}
.slide-section ol li:hover,
.slide-section ol li.liActive{
    background: #00a0e3; 
    transition: .2s ease;
}
.slide-section ol li button i{
    display: none;
    position: absolute;
    left: -15px;
    top: 50%;
    transform: translateY(-50%);
}
.slide-section ol li.liActive button i{
    display: block;
    color: #fff;
}
.slide-section ol li button span.w70{
    width: 85%;
}
.w30{
    width: 15%;
    text-align:center;
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

.course-menu{
    position: sticky;
    top: 60px;
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

    window.onload = function () {
        let hSticky = document.getElementById("hSticky");
        let hData = document.getElementById("hData");

        let dataHeight = hData.offsetHeight;
        console.log(dataHeight)
        hSticky.style.height = dataHeight + 'px';
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
