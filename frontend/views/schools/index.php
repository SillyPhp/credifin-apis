<?php

use yii\helpers\Url;

?>

    <section style="background:#82CFF0;min-height: 430px;">
        <div class="container headsec">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="newlogoset">
                        <div class="main-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/header.png'); ?>" align="right"
                                 class="responsive"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 topp-pad">
                    <div class="main-heading-set">
                        <div class="min-heading">COVID-19 ( Online Classes )</div>
                        <div class="jumbo-heading">confronting Online School Classes for Students of Nursery to Class
                            12
                        </div>
                        <!--                    <div class="search-box1">-->
                        <!--                        <form action="--><? //= Url::to('/courses/courses-list') ?><!--">-->
                        <!--                            <input type="text" placeholder="Search" name="keyword" id="get-courses-list">-->
                        <!--                            <button type="submit"><i class="fas fa-search"></i></button>-->
                        <!--                        </form>-->
                        <!--                    </div>-->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?= $this->render('/widgets/online-classes', [
        'model' => $model
    ]) ?>

    <Section>
        <div class="container">
            <div class="row">
                <h3 class="ser-heading">Our Services</h3>
                <div class="main-get">
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="sc-main">
                            <div class="sc-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/schools/hiring.png') ?>">
                            </div>
                            <h3>Hire Staff</h3>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="sc-main">
                            <div class="sc-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/schools/school-review.png') ?>">
                            </div>
                            <h3>School Reviews</h3>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="sc-main">
                            <div class="sc-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/schools/online-classes2.png') ?>">
                            </div>
                            <h3>Online Classes</h3>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="sc-main">
                            <div class="sc-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/schools/quiz2.png') ?>">
                            </div>
                            <h3>Quiz</h3>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="sc-main">
                            <div class="sc-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/schools/scholarshipq.png') ?>">
                            </div>
                            <h3>Scholarships</h3>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="sc-main">
                            <div class="sc-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/schools/brand.png') ?>">
                            </div>
                            <h3>Showcase Your Brand</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Section>

    <Section>
        <div class="container">
            <div class="row">
                <h3 class="ser-heading">Benefits</h3>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="b-main">
                        <div class="b-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/video.png') ?>">
                        </div>
                        <div class="b-text">
                            <div class="b1">Video Calling</div>
                            <div class="b2">Add real-time high quality video chat</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="b-main">
                        <div class="b-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/phone.png') ?>">
                        </div>
                        <div class="b-text">
                            <div class="b1">Voice Calling</div>
                            <div class="b2">Add real-time crystal clear voice</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="b-main">
                        <div class="b-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/chatting.png') ?>">
                        </div>
                        <div class="b-text">
                            <div class="b1">Real Time Messaging</div>
                            <div class="b2">chat room, notifications, call signaling and more.</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="b-main">
                        <div class="b-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/recording.png') ?>">
                        </div>
                        <div class="b-text">
                            <div class="b1">Recording</div>
                            <div class="b2">Do more with your live audio and video streams</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="b-main">
                        <div class="b-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/live-audio.png') ?>">
                        </div>
                        <div class="b-text">
                            <div class="b1">Live Audio Streaming</div>
                            <div class="b2">Add real-time audio streaming</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="b-main">
                        <div class="b-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/live-video.png') ?>">
                        </div>
                        <div class="b-text">
                            <div class="b1">Live Video Streaming</div>
                            <div class="b2">Create meaningful real-time engagement experiences</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Section>

    <section class="feat-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="heading-style">Our Features</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="cl-feature-box">
                        <div class="cl-feat-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/qI.png') ?>">
                        </div>
                        <div class="cl-feat-name">
                            Quick User Integration
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cl-feature-box">
                        <div class="cl-feat-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/gr.png') ?>">
                        </div>
                        <div class="cl-feat-name">
                            Global Reach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cl-feature-box">
                        <div class="cl-feat-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/qt.png') ?>">
                        </div>
                        <div class="cl-feat-name">
                            Quality Teaching
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="cl-feature-box">
                        <div class="cl-feat-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/el.png') ?>">
                        </div>
                        <div class="cl-feat-name">
                            Effective learning and teaching
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cl-feature-box">
                        <div class="cl-feat-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/ts.png') ?>">
                        </div>
                        <div class="cl-feat-name">
                            Time-saving
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cl-feature-box">
                        <div class="cl-feat-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/schools/ac.png') ?>">
                        </div>
                        <div class="cl-feat-name">
                            Avoid commuting
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registercss('
.footer{
    margin-top:0px !important;
}
.topp-pad{
    margin-top: 80px !important;
}
.newlogoset{
    max-width:500px;
    margin: 0 auto;
    position:relative;
}
.main-img {
    position: relative;
    display: inline-block;
    z-index: 9;
    margin-bottom: 10px;
    margin-top:70px;
}
.main-heading-set {
    display: block;
    z-index: 9;
    position: relative;
    padding-top: 55px;
}
.min-heading {
    color: #fff;
    text-transform: uppercase;
    border-left: 3px solid #ff7803;
    padding-left: 10px;
    font-weight: 500;
    font-size: 15px;
    font-family: roboto;
    letter-spacing: 1px;
}
.jumbo-heading {
    font-size: 38px;
    font-weight: bold;
    font-family: roboto;
    text-transform: capitalize;
    color: #fff;
}
.sc-main {
    border-radius: 4px;
    box-shadow: 0px 0px 7px 5px #eee;
    padding: 15px 10px;
    text-align: center;
    min-height: 142px;
    margin-bottom: 25px;
    transition: ease-out .3s;
}
.sc-logo img{
    width:50px;
    height:50px;
}
.sc-main h3{
    margin: 0;
    padding: 22px 0px 0px;
    font-size: 18px;
    font-family: roboto;
    line-height:20px;
}
.sc-main:hover{
    background-color:#00a0e3;
    box-shadow:0 0 15px 8px #eee;
    transform: scale(1.1);
}
.sc-main:hover h3{
    color:#fff;
}
.ser-heading {
    font-size: 32px;
    font-family: lora;
    text-align: center;
    margin:25px 0 25px;
}
.b-main {
	margin-bottom: 25px;
	padding: 10px 20px;
	min-height: 172px;
	box-shadow: 0 0 15px -5px #aaa;
}
.b-logo {
	padding: 10px;
	display: inline-block;
}
.b-logo img{
	width: 35px;
	height: 35px;
}
.b-text {
	padding: 10px 0 0 0;
}
.b1 {
	font-size: 18px;
	font-family: roboto;
	font-weight: 500;
}
.b2 {
	font-size: 16px;
	font-family: roboto;
}
.virus-bg{
    position: ralative;
    overflow: hidden;
    background:#eee ;
    background-size: contain;
    padding:30px 0 50px 0;
}
.virus-icons, .virus-icon-left{
    position: absolute;
    -webkit-animation-name: spin;
    -webkit-animation-duration: 70ms;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-timing-function: linear;
    -moz-animation-name: spin;
    -moz-animation-duration: 70ms;
    -moz-animation-iteration-count: infinite;
    -moz-animation-timing-function: linear;
    -ms-animation-name: spin;
    -ms-animation-duration: 70ms;
    -ms-animation-iteration-count: infinite;
    -ms-animation-timing-function: linear;
    animation-name: spin;
    animation-duration: 70s;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
}
.virus-icons{
    top:-150px; 
    right:-150px;
    max-width: 350px;
    opacity:.5;
}
.virus-icon-left{
    bottom: -100px;
    left: -100px;
    max-width:250px;
    opacity:.4;
}
 @-ms-keyframes spin { 
    from { 
        -ms-transform: rotate(0deg); 
    } to { 
        -ms-transform: rotate(360deg); 
    }
}
@-moz-keyframes spin { 
    from { 
        -moz-transform: rotate(0deg); 
    } to { 
        -moz-transform: rotate(360deg); 
    }
}
@-webkit-keyframes spin { 
    from { 
        -webkit-transform: rotate(0deg); 
    } to { 
        -webkit-transform: rotate(360deg); 
    }
}
@keyframes spin { 
    from { 
        transform: rotate(0deg); 
    } to { 
        transform: rotate(360deg); 
    }
}
.onlineClasses{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.oc-text{
    font-size: 18px;
    font-family: roboto;
    color: #333;
}
.online-content{
    flex-basis:60%;
    margin-left: 40px;
}
.online-icon{
    text-align:center;
    flex-basis:30%
}
.oc-sub-heading{
   font-size: 30px;
    font-weight: 600;
    color: #000;
    font-family: lora;
    margin: 0px;
    text-transform: capitalize;
}
@media screen and (max-width:1200px){
    .onlineClasses{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        text-align:center;
    }
    .online-content{
        flex-basis:100%;
        margin-left: 40px;
    }
    .online-icon{
        text-align:center;
        flex-basis:100%
    }
    .online-icon img{
        max-width:250px;
    }
    .oc-text-icons{
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
        justify-content: center;
    }
}
.oc button{
    background: transparent;
    border: 1px solid #00a0e3;
    color:#00a0e3;
    padding:15px 20px;
    margin-top: 30px;
    text-transform: uppercase;
    font-family: roboto;
}
.oc button:hover{
    background: #00a0e3;
    color:#fff;
    transition: .3s ease;
}
.oc-text-icons div span{
    position: relative;   
    display:inline-block;
}
.oc-text-icons div span .hoverShow{
    display: none;
    position: absolute;
    top:0;
    left:0;
    z-index:99;
}
.oc-text-icons div:hover  span .hoverShow{
    display: inline;
    transition: 0.2s ease;
}
.oc-text-icons div:hover  span .hoverHide{
    display: hidden;
}
.oc-text-icons div{
    flex-basis: 200px;
    text-align: center;
    box-shadow:0 0 10px rgba(0,0,0,.1);
    margin:10px 10px 0 0;
    padding:10px 10px 5px 10px;
    border-radius: 10px;
} 
.oc-text-icons div:hover{
    background:#00a0e3;
    color:#fff;
    transition:.3s ease;
    cursor: pointer;
}
.oc-text-icons p{
    font-size:18px; 
    padding-top: 5px;
    font-family: roboto;
    line-height:20px;
}
.oc-text-icons{
    display: flex;
    flex-wrap: wrap;
    margin-top: 20px;
}
.feat-bg{
    padding-top:20px;
    margin-top:00px;
    background: linear-gradient(#fff 0%, #EEF2F6 30%, #f4f7fa 70%, #fff);
}
.cl-feature-box{
    text-align: center;
    padding:10px 0 60px;
}
.cl-feat-name{
    padding: 10px 0 0 0 ;
    font-size:18px;
    font-family: Roboto;
    text-transform: capitalize;
    line-height: 25px;
}
.cl-feat-icon img{
    max-width: 50px;
    height: 50px;
}
@media(max-width:835px){
.main-img{
    margin-top:150px;
}
}
@media(max-width:415px){
.main-img {
    margin-top: 100px;
}
.topp-pad{
    margin-top: 20px !important;
}
.jumbo-heading{
    font-size:30px;        
    }
.main-heading-set{
    padding-top:0px;
}
}

');