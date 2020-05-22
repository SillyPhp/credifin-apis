<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
    <section class="mt30">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="mentor-details-bg">
                        <div class="turitor-instructor-profile">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                        </div>
                        <div class="mentor-details">
                            <p class="mentor-name">Mr. Tarry</p>
                            <p class="work-set"><span>CTO at</span> Empower Youth</p>
                            <p class="college-name"></p>
                        </div>
                        <div class="mentor-name">About Me</div>
                        <div class="mentor-description">
                            <p>
                                Tarry started photography to find happiness, and he lives to put that enthusiasm
                                into Mophie Photography. He creates intuitive, creative, and adventurous
                                experiences within the process of shooting that make the process itself
                                memorable.
                            </p>
                        </div>
                        <div class="btn-flex use-p">
                            <div class="apply-btn">
                                <button type="button">Follow <i class="fas fa-plus"></i></button>
                            </div>
                            <div class="apply-btn">
                                <button type="button">Share <i class="fas fa-share-alt"></i></button>
                            </div>
                        </div>
                        <div class="mentor-social-links">
                            <h4>Social Links</h4>
                            <ul class="">
                                <li>
                                    <a href="" target="_blank" class="ms-fb">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="" target="_blank" class="ms-tw">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="" target="_blank" class="ms-ig">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="" target="_blank" class="ms-pt">
                                        <i class="fab fa-pinterest"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="" target="_blank" class="ms-link">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="col-md-12">
                        <div class="mentor-heading">All Quizzes</div>
                    </div>
                    <div class="col-md-6">
                        <div class="what-popular-box">
                            <div class="wp-box-icon">
                                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/quiz/quiz-default.png') ?>"
                                                alt="Blog testing"></a>
                            </div>
                            <div class="wn-box-details">
                                <a href="">
                                    <div class="qz-box-title">Lorem Ipsum is simply dummy</div>
                                </a>
                                <div class="qz-box-des">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><span>Questions:</span> 5</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span>Group:</span> 9th</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span>Subject:</span> GK</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span>Duration :</span> 5min</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center"><a href="" class="button"><span>Take Quiz</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="what-popular-box">
                            <div class="wp-box-icon">
                                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/mentorship/thumbnail1.png') ?>"
                                                alt="Blog testing"></a>
                            </div>
                            <div class="wn-box-details">
                                <a href="">
                                    <div class="qz-box-title">Lorem Ipsum is simply dummy</div>
                                </a>
                                <div class="qz-box-des">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><span>Questions:</span> 5</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span>Group:</span> 9th</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span>Subject:</span> GK</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span>Duration :</span> 5min</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center"><a href="" class="button"><span>Take Quiz</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="what-popular-box">
                            <div class="wp-box-icon">
                                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/mentorship/thumbnail1.png') ?>"
                                                alt="Blog testing"></a>
                            </div>
                            <div class="wn-box-details">
                                <a href="">
                                    <div class="qz-box-title">Lorem Ipsum is simply dummy</div>
                                </a>
                                <div class="qz-box-des">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><span>Questions:</span> 5</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span>Group:</span> 9th</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span>Subject:</span> GK</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><span>Duration :</span> 5min</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center"><a href="" class="button"><span>Take Quiz</span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row mb4">
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.about-box {
    border: 1px solid transparent;
    border-radius: 20px;
    padding: 10px 20px;
    box-shadow: 0 0 5px 1px #eee;
    margin-bottom: 20px;
}
.bg-gray{
    background: #f4f8ff;
    text-align: center;
    border-radius: 20px;
}
.what-popular-box {
    margin-bottom: 20px;
    border-radius: 5px;
}
.wp-box-icon {
    width: 100%;
    height: 150px;
    overflow: hidden;
    border-radius: 5px 5px 0 0;
    position: relative;
}
.wp-box-icon img {
    border-radius: 5px 5px 0 0;
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;
    opacity: 1;
    display: block;
    width: 100%;
    height: 100%;
    transition: .5s ease;
    backface-visibility: hidden;
    object-fit: cover;
}
.what-popular-box:hover .wp-box-icon img {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1;
}
.wn-box-details {
    border-top: none;
    padding: 5px 10px 10px 8px;
    border: 1px solid rgba(230, 230, 230, .3);
    border-radius: 0 0 5px 5px;
}
.qz-box-title{
    font-weight: bold;
}
.work-set {
    font-size: 15px;
    padding: 0 20px;
}
.college-name {
    font-size: 18px;
    font-weight: 500;
    font-family: roboto;
}
.work-set span{
    font-family: roboto;
    font-weight: 500;
}
.qz-box-des {
    padding-top: 15px;
    font-size: 13px;
}
.qz-box-des p span{
    font-weight: bold;
}
.button {
    display: inline-block;
    background-color: #00a0e3;
    border-radius: 5px;
    border: none;
    color: #FFFFFF;
    text-align: center;
    font-size: 13px;
    padding: 8px 15px;
    // width: 200px;
    transition: all 0.3s;
    cursor: pointer;
    margin-top: 15px;
}
.button:hover{
    color: #fff;
}
.what-popular-box:hover {
    box-shadow: 0 0 15px rgba(73, 72, 72, 0.28);
}


.use-p{
    padding:0 20px;
    margin-top:15px;
}
.mentor-social-links{
    text-align: center;
    margin-top: 10px;
}
.mentor-social-links ul li{
    display: inline;
        margin: 0 5px
}
.mentor-social-links ul li a{
    color:#00a0e3;  
}
.ms-fb:hover{
    color:#3b5998
}
.ms-tw:hover{
    color:#00acee;
}
.ms-ig:hover{
    color:#bc2a8d;
}
.ms-pt:hover{
    color: #c8232c;
}
.ms-link:hover{
    color: #0e76a8;
}
.mentor-fields ul li, .mentor-expertise ul li{
    font-size: 16px;
    color: #333;
    font-weight: 400;
}
.mentor-expertise ul{
    padding-inline-start: 20px;
}
.mentor-expertise ul li{
    list-style-type: disc;
}
.support-list ul{
    margin-top: 20px;
}
.support-list ul li{
    max-width: 150px;
    text-align: center;    
}
.sl-icon img{
    max-width: 80px;
    max-height: 80px;
}
.sl-icon p{
    padding-top: 10px;
    font-size: 15px;
    color: #333;
}
.am-box ul li{
    margin-left: 30px;
}
.am-box ul li{
    font-size: 17px;
    font-family: roboto;
    color:#00a0e3;
    line-height: 27px;
    margin-bottom: 20px;
}
.am-box ul li span{
    font-size: 16px;
    color:#333;
    font-weight: 400;
}
.am-box ul li:before{
    content:"";
    position: absolute;
    font-family: "Font Awesome 5 Free" ;
    top:1px;
    left:0px;   
    font-weight: 900;
    color:#00a0e3;    
}
.am-box .prim-ind li:before{
    content:"\f54f";
     left:15px; 
}
.am-box .location-work li:before{
    content:"\f3c5";
     left:20px; 
}
.am-box .emp-work li{
    margin-bottom: 0px;
}
.am-box .emp-work li:before{
    content:"\f2bb";
     left:20px; 
}
.exp-field li{
    color: #000 !important;
}
.exp-field li span{
    color: #333 !important;
}
.am-box .expertize-list li:before{
    content:"\f005";
     left:15px; 
}

.mentor-heading{
    font-size: 25px;
    font-family: lora;
    color:#000;
    text-transform: capitalize;
    padding: 0 20px;
}
.mb4{
    margin-bottom: 40px;
}
.mb3{
    margin-bottom: 30px;
}
.mt30{
    margin-top: 10px;
}
.mentor-header{
    background: url(' . Url::to('@eyAssets/images/pages/mentorship/mentor-profile-header.png') . ');
    background-size: cover;
}
.mentor-padding-50{
    padding:0 30px;
}
.mentor-details-bg{
    background: #f4f8ff;
    padding: 20px 0 20px;
    border-radius: 20px;
    margin-bottom: 20px;
}
.mentor-relative{
    min-height: 200px;
    display: flex;
    justify-content: center;
    
}
.mentor-title{
   color: #333;
    font-family: lora;
    font-size: 35px;
    display: flex;
    align-items: center;
    font-weight: bold;
}
.turitor-instructor-profile {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -ms-border-radius: 50%;
    background: #fff;
    
    overflow: hidden;
    margin: 0 auto 20px;
}
.turitor-instructor-profile img {
    width: 100%;
}
.mentor-details{
    text-align: center;
    font-family: roboto;
    color:#333;   
    text-transform: capitalize;  
}
.mentor-name{
    color:#333;
    font-family: lora;
    font-size:23px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 0px;
}
.mentor-fields p{
    margin: 0px;
    font-size: 16px;
    line-height: 25px;
}
.mentor-fields{
    text-align: center;
    font-family: roboto;
    margin-top: 10px;
}
.mentor-fields h4, .mentor-social-links h4, .mentor-expertise h4{
    color: #333;
    font-family: lora;
    font-size: 23px;
    font-weight: bold;
    margin-bottom: 5px;
    margin-top: 0px;
}
.mentor-pay{
    margin-top: 20px;
    background:#00a0e3;
    color: #fff;
    text-align: center;
    font-family: roboto;
    font-size: 20px;
    padding: 15px 0;
    width: 100%;
    border: none;
}

.mentor-stats {
    padding: 30px 0;
    position: relative;
    border-right: 1px solid #eee
}
.border-none{
    border-right: none;
}

.mentor-stats h4{
    font-size: 25px;
    margin: 0;
    line-height: 20px;
    font-family: roboto;
    color: #333;
}
.mentor-stats span, .mentor-stats h4 span{
    font-size: 16px;
    font-family: roboto;
    color: #00a0e3;
}
.mentor-stats h4 span{
    color:#333;
}
.mentor-description, .mpb-text{
    font-size: 15px;
    line-height: 25px;
    color: #333;
    font-family: roboto;
    padding: 0px 20px 0 20px;
    text-align: center;   
}

.mentee-btn{
    margin-top: 30px;
    text-align:center
}
.mentee-btn button{
    color:#fff;
    border: none;
    padding: 15px 20px;
    background: #00a0e3;
    transition: .3s all;
    text-transform: uppercase;
    font-size: 16px;
}
.mentee-btn button:hover{
   box-shadow: 0 0 8px rgba(0,0,0,.3);
    background: #fff;
    color: #00a0e3;
    transition: .2s ease;
    transform: scale(1.03);
}


.user-meta-summery {
    padding: 10px 00px 10px 00px;
    /* background: #f4f8ff; */
    list-style: none;
    margin: 10px 0 40px;
    border-radius: 15px;
    width: 100%;
}
.total-course {
    padding: 0px 0 0 55px;
    position: relative;
    line-height: 16px;
}
.total-course:before {
    width: 135px;
    height: 135px;
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -ms-border-radius: 50%;
    content: \'\';
    left: 0;
    top: 0;
    background: #eef2fa;
    position: absolute;
    bottom: 0;
    margin: auto;
}
.total-course h4 {
     font-size: 38px;
    margin-bottom: 0px;
    position: relative;
    font-family: lora;
    font-weight: bold;
}
.total-course span {
   position: relative;
    font-size: 14px;
    color: #333;
    font-family: roboto;
}
.mentor-expertise{
    background: #f4f8ff;
    padding: 20px;
    border-radius: 20px;
    margin-bottom: 20px;
    font-family: roboto;
}
.skills-taught{
    margin-top: 10px;
}
.skills-taught li{
       display: inline;
    font-size: 15px !important;
    color: #333 !important;
    margin: 0 5px 0 0px !important;
    background: #f7f8fa;
    padding: 8px 15px;
}
.ex-box ul li {
    font-size: 17px;
    font-family: roboto;
    color: #00a0e3;
    line-height: 27px;
    margin-bottom: 20px;
}
.ex-box ul li span {
    font-size: 16px;
    color: #333;
    font-weight: 400;
}
.ment-exp-box p{
    font-size: 16px;
    font-family: roboto;
    color: #333;
}
.ment-exp-box p span{
    color: #000; 
    font-weight: bold;
}
.btn-flex{
    display: flex;
}
.apply-btn{
    flex-basis: 50%;
}
.apply-btn button, .share-btn button{
    width: 100%;
    padding: 10px 0;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    background: #00a0e3;
    color: #fff;
    border: 1px solid #fff;
}
.apply-btn button:hover, .share-btn button:hover{
    box-shadow: 0 0 8px rgba(0,0,0,.3);
    background: #fff;
    color:#00a0e3;
    transition: .2s ease;
    transform: scale(1.03);
}
');
$script = <<<JS

JS;
$this->registerJS($script);
?>