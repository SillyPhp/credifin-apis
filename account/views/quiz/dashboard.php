<?php

use yii\helpers\Url;

?>
<section>
    <div class="row">
        <div class="col-md-3">
            <div class="mentor-details-bg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="turitor-instructor-profile">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mentor-details">
                            <p class="mentor-name">Mr. Tarry</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mentor-fields">
                            <h4>Quiz Fields</h4>
                            <p>Science / Maths / Computer Science</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mentor-link">
                            <a href="create" class="mentor-pay">Create Quiz</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="share-box">
                <div class="blur">
                    <img src="<?= Url::to('@eyAssets/images/pages/quiz/comingsoon.png') ?>">
                    <p>This Feature Is Comming Soon</p>
                </div>
                <div class="sb-title">
                    Share This Quiz
                </div>
                <div class="qz-logo">
                    <img src="<?= Url::to('@eyAssets/images/pages/quiz/quiz-default.png') ?>" alt="">
                </div>
                <div class="sb-btn">
                    <button type="button" class="ql-share">Share <i class="fa fa-share-alt"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="stats">
                <div class="row">
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="stats-details">
                                <div class="qsb-heading">Total Quiz</div>
                                <div class="qsb-price">250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/total-quiz.png') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="stats-details">
                                <div class="qsb-heading">Quiz Created This Month</div>
                                <div class="qsb-price">250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/quiz-created-this-month.png') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="stats-details">
                                <div class="qsb-heading">Quiz Taken Lifetime</div>
                                <div class="qsb-price"><i class="fa fa-users"></i> 250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/total-quiz-taken.png') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="stats-details">
                                <div class="qsb-heading">Quiz Taken This Month</div>
                                <div class="qsb-price"><i class="fa fa-user"></i> 250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/quiz-taken-this-month.png') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="blur">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/comingsoon.png') ?>">
                                <p>This Feature Is Comming Soon</p>
                            </div>
                            <div class="stats-details">
                                <div class="qsb-heading">Earnings This Month</div>
                                <div class="qsb-price"><i class="fa fa-inr"></i> 250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/earnings-this-month.png') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quiz-stats-box">
                            <div class="blur">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/comingsoon.png') ?>">
                                <p>This Feature Is Comming Soon</p>
                            </div>
                            <div class="stats-details">
                                <div class="qsb-heading">Earnings Lifetime</div>
                                <div class="qsb-price"><i class="fa fa-inr"></i> 250</div>
                                <div class="qsb-rise"><i class="fa fa-arrow-up"></i> 30</div>
                            </div>
                            <div class="qsb-icons">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/earnings-lifetime.png') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="top-quiz">
                            <div class="tq-heading">
                                <p>Top Quiz</p>
                                <a href="my-quiz">View All</a>
                            </div>
                            <ul>
                                <li>
                                    <div class="tq-box">
                                        <div class="tq-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>">
                                        </div>
                                        <div class="tq-details">
                                            <div class="tq-name"><a href="quiz-view">Basics of Social Media</a></div>
                                            <div class="tq-flex">
                                                <div class="tq-played">Played: <span>100</span></div>
                                                <div class="tq-earn">
                                                    Earnings: <span><i class="fa fa-inr"></i>1000</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tq-details-edit">
                                            <a href="quiz-view"><i class="fa fa-pencil"></i></a>
                                            <button href="quiz-view" class="top-quiz-delete"><i class="fa fa-trash"></i></button>
                                            <button href="quiz-view" class="top-quiz-share"><i
                                                        class="fa fa-share-alt"></i></button>
                                            <button href="quiz-view" class="top-quiz-share"><i
                                                        class="fa fa-eye-slash"></i></button>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="tq-box">
                                        <div class="tq-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>">
                                        </div>
                                        <div class="tq-details">
                                            <div class="tq-name"><a href="quiz-view">Basics of Social Media</a></div>
                                            <div class="tq-flex">
                                                <div class="tq-played">Played: <span>100</span></div>
                                                <div class="tq-earn">
                                                    Earnings: <span><i class="fa fa-inr"></i>1000</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tq-details-edit">
                                            <a href="quiz-view"><i class="fa fa-pencil"></i></a>
                                            <button href="quiz-view" class="top-quiz-delete"><i class="fa fa-trash"></i></button>
                                            <button href="quiz-view" class="top-quiz-share"><i
                                                        class="fa fa-share-alt"></i></button>
                                            <button href="quiz-view" class="top-quiz-share"><i
                                                        class="fa fa-eye-slash"></i></button>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="tq-box">
                                        <div class="tq-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>">
                                        </div>
                                        <div class="tq-details">
                                            <div class="tq-name"><a href="quiz-view">Basics of Social Media</a></div>
                                            <div class="tq-flex">
                                                <div class="tq-played">Played: <span>100</span></div>
                                                <div class="tq-earn">
                                                    Earnings: <span><i class="fa fa-inr"></i>1000</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tq-details-edit">
                                            <a href="quiz-view"><i class="fa fa-pencil"></i></a>
                                            <button href="quiz-view" class="top-quiz-delete"><i class="fa fa-trash"></i></button>
                                            <button href="quiz-view" class="top-quiz-share"><i
                                                        class="fa fa-share-alt"></i></button>
                                            <button href="quiz-view" class="top-quiz-share"><i
                                                        class="fa fa-eye-slash"></i></button>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="tq-box">
                                        <div class="tq-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>">
                                        </div>
                                        <div class="tq-details">
                                            <div class="tq-name"><a href="quiz-view">Basics of Social Media</a></div>
                                            <div class="tq-flex">
                                                <div class="tq-played">Played: <span>100</span></div>
                                                <div class="tq-earn">
                                                    Earnings: <span><i class="fa fa-inr"></i>1000</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tq-details-edit">
                                            <a href="quiz-view"><i class="fa fa-pencil"></i></a>
                                            <button href="quiz-view" class="top-quiz-delete"><i class="fa fa-trash"></i></button>
                                            <button href="quiz-view" class="top-quiz-share"><i
                                                        class="fa fa-share-alt"></i></button>
                                            <button href="quiz-view" class="top-quiz-share"><i
                                                        class="fa fa-eye-slash"></i></button>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="tq-box">
                                        <div class="tq-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>">
                                        </div>
                                        <div class="tq-details">
                                            <div class="tq-name"><a href="quiz-view">Basics of Social Media</a></div>
                                            <div class="tq-flex">
                                                <div class="tq-played">Played: <span>100</span></div>
                                                <div class="tq-earn">
                                                    Earnings: <span><i class="fa fa-inr"></i>1000</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tq-details-edit">
                                            <a href="quiz-view"><i class="fa fa-pencil"></i></a>
                                            <button href="quiz-view" class="top-quiz-delete"><i class="fa fa-trash"></i></button>
                                            <button href="quiz-view" class="top-quiz-share"><i
                                                        class="fa fa-share-alt"></i></button>
                                            <button href="quiz-view" class="top-quiz-share"><i
                                                        class="fa fa-eye-slash"></i></button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="earning-quiz">
                            <div class="blur">
                                <img src="<?= Url::to('@eyAssets/images/pages/quiz/comingsoon.png') ?>">
                                <p>This Feature Is Comming Soon</p>
                            </div>
                            <div class="tq-heading">Earnings</div>
                            <div class="earning-table">
                                <ul>
                                    <li><i class="fa fa-inr"></i></li>
                                    <li>500</li>
                                    <li>1000</li>
                                    <li>1500</li>
                                    <li>2000</li>
                                    <li>2500</li>
                                    <li>3000</li>
                                    <li>3500</li>
                                </ul>
                            </div>
                            <div class="eq-list">
                                <ul>
                                    <li>
                                        <div class="earning-box">
                                            <div class="month">
                                                Jan
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                     aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                                    <span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                            <div class="m-income"><i class="fa fa-inr"></i> 2000</div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="earning-box">
                                            <div class="month">
                                                Feb
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                     aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                                    <span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                            <div class="m-income"><i class="fa fa-inr"></i> 2000</div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="earning-box">
                                            <div class="month">
                                                Mar
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                     aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                                    <span class="sr-only">100% Complete</span>
                                                </div>
                                            </div>
                                            <div class="m-income"><i class="fa fa-inr"></i> 3200</div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="earning-box">
                                            <div class="month">
                                                Apr
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                     aria-valuemin="0" aria-valuemax="100" style="width:80%">
                                                    <span class="sr-only">80% Complete</span>
                                                </div>
                                            </div>
                                            <div class="m-income"><i class="fa fa-inr"></i> 2800</div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="earning-box">
                                            <div class="month">
                                                May
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                                     aria-valuemin="0" aria-valuemax="100" style="width:50%">
                                                    <span class="sr-only">50% Complete</span>
                                                </div>
                                            </div>
                                            <div class="m-income"><i class="fa fa-inr"></i> 1700</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="shareQuizModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="qModal">
            <h2>Share Quiz</h2>
            <div class="qm-logo">
                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" class="imagePath"
                     alt="">
            </div>
            <p class="qm-name">Quiz on human ethics</p>
            <div class="share-input">
                <form>
                    <input type="text" placeholder="" class="shareLinkInput">
                    <button type="button" onclick="nextStep()"><i class="fa fa-copy"></i></button>
                </form>
            </div>
            <p>If someone plays this quiz through this link, It will earn you 20 extra credits</p>
            <h4>Share on</h4>
            <ul class="qshare">
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=" target="_blank"
                       onclick="appendLink(this)">
                        <i class="fa fa-facebook-f"></i>
                    </a>
                </li>
                <li>
                    <a href=" https://publish.twitter.com/" target="_blank" onclick="appendLink(this)">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/cws/share?url=" target="_blank" onclick="appendLink(this)">
                        <i class="fa fa-linkedin"></i>
                    </a>
                </li>
                <li>
                    <a href="whatsapp://send?text=" target="_blank" onclick="appendLink(this)">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                </li>
                <li>
                    <a href="https://t.me/share/url?url=" target="_blank" onclick="appendLink(this)">
                        <i class="fa fa-telegram"></i>
                    </a>
                </li>
                <li>
                    <a href="mailto:?subject=[SUBJECT]&body=" target="_blank" onclick="appendLink(this)">
                        <i class="fa fa-envelope"></i>
                    </a>
                </li>
                <li>
                    <a href="" onclick="downloadImage(this)" target="_blank">
                        <i class="fa fa-download"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php
$this->registerCss('
. pos-rel{
    position: relative;
}
.blur{
    position: absolute;
    top: 0;
    left: 0;
    background: rgba(255,255,255,.9);
    width: 100%;
    height: 100%;
    z-index: 2;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
.blur p{
    font-size: 17px;
    font-weight: bold;
}
.blur img{
    max-width: 150px;
}
.quiz-stats-box .blur p{
    font-size: 14px;
    margin: 0px !important;
}
.quiz-stats-box .blur img{
    max-width: 50px;
}
#chat-icon{
    z-index: 3;
}
.top-quiz-delete, .top-quiz-share{
    background: transparent;
    border: none;
    padding: 0 0px;
}
.qm-logo{
    max-width:100px;
    max-height: 100px;    
    margin: 0 auto;
}
.qm-name{
    margin-bottom: 10px;
    margin-top: 10px;
}
.qm-logo img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 10px;
}
.qModal h4{
    font-weight: bold;
    color: #333;
    font-family: roboto;
    font-size: 20px;
}
.qModal h2{
    font-weight: bold;
    color: #00a0e3;
    font-family: lora;
    font-size: 30px;
}
.qModal p{
    color: #333;
    font-family: roboto;
    font-size: 16px;
}
.qshare {
    padding-inline-start: 0;
}
.qshare li{
    list-style: none;
    display: inline;
    padding:10px 10px;
}
.qshare li a{
    font-size: 23px;
    color: #333; 
}
.qshare li a:hover{
    color: #00a0e3; 
}
.share-box{
    box-shadow: 0 0 10px rgba(0,0,0,.3);
    position: relative;
}
.sb-title{
    padding: 10px 10px;
    color: #333;
    font-family: lora;
    font-size:16px;
    font-weight: 600;
}
.sb-btn{
    background: #fff;
    height: 50px
}
.sb-btn button{
    width: 100%;
    height: 100%;
    
    background: #fff;
    border: none;
}
.sb-btn button:hover{
    color: #00a0e3;
}
.qz-logo {
   width: 100%;
   height: 200px;
}
.qz-logo img{
    height: 100%;
    width: 100%;
    object-position: center;
    object-fit: cover;
}
.earning-box{
    position: relative; 
    height: 30px;   
}
.m-income{
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    color:#333;
    font-weight: bold;
    font-size: 12px;
    font-family: roboto;
}
.btnview, .btnedit{
    background: #00a0e3;
    color: #fff;
    border: none;
    padding: 3px 8px;
    font-size: 12px;
}
.btndelete{
    background: #FF0000;
    color: #fff;
    border: none;
    padding: 3px 8px;
    font-size: 12px;
}
.quiz-stats-box{
    box-shadow: 0 0 10px rgba(0,0,0,.3);
    width: 100%;
    min-height: 100px;
    display: flex;
    padding: 10px 20px;
    align-items: center;
    margin-bottom: 20px;
    position: relative
    
}
.stats-details{
    flex: 2;
}
.qsb-heading{
    font-size: 16px;
    color: #000;
    font-family: lora;
    letter-spacing: .8px;
}
.qsb-price{
    font-size: 22px;
    color: #333;
    font-family: roboto;
}
.qsb-rise{
    font-size: 12px;
    color: #00a0e3;
    font-family: roboto;
}
.qsb-icons{
   background: #00a0e3;
    width: 50px;
    height: 50px;
    position: relative;
    border-radius: 50%;
    font-size: 22px;
    color: #fff;
}
.qsb-icons i{
    position: absolute;
    top: 50%;
    left:50%;
    transform: translate(-50%,-50%);
}
.qsb-icons img{
    max-width: 30px;
    max-height: 30px;
        position: absolute;
    top: 50%;
    left:50%;
    transform: translate(-50%,-50%);
}
.tq-heading{
    font-family: lora;
    font-size: 20px;
    background: #f8f8f8;
    padding: 10px 15px ;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.tq-heading p{
    margin: 0 0;
}
.tq-heading a{
    color: #333;
    font-family: roboto;
    font-size: 14px;
    font-weight: 500;
}
.tq-heading a:hover{
    color: #00a0e3;
}
.tq-flex{
    display: flex;
}
.top-quiz, .quiz-taken{
    box-shadow: 0 0 10px rgba(0,0,0,.3);
    margin-top: 20px;
}
.quiz-taken{
    margin-top: 40px;
}
.top-quiz ul, .quiz-taken ul{
    list-style: none;
    padding-inline-start: 0;
}
//.top-quiz ul li, .quiz-taken ul li{
//    padding: 10px 15px;
//}
.top-quiz ul li:nth-child(even), .quiz-taken ul li:nth-child(even){
    background: #f8f8f8
}
.tq-box{
    display: flex;
    position: relative;
    padding: 10px 15px
}
.tq-icon{
    max-width: 70px;
    height: 50px;
}
.tq-icon img{
    width: 100%;
    height:100%;
    object-fit: cover;
}
.tq-details{
    padding:0 0 0 10px;
    width: 100%;
    position: relative;
}
.tq-details-edit{
    position: absolute;
    top: 3px;
    right: 3px;
}
.tq-details-edit a, .tq-details-edit button{
    color: #333;
}
.tq-details-edit a:hover, .tq-details-edit button:hover{
    color: #00a0e3;
    transition: .3s ease;
}
.tq-name a, .tq-played, .tq-earn{
    font-weight: bold;
    color:#333;
}
.tq-played, .tq-earn{
    flex:1
    padding: 5px 0 0 0;
}
.tq-played span, .tq-earn span{
    font-weight: 400;
}
.tq-dots{
    position:absolute;
    top:0;
    right:0;
}
.tq-dots button{
    background: transparent;
    border: none;
}
.tq-dots button:hover{
    color: #00a0e3;
}
.tq-btns{
    position: absolute;
    top:-50px;
    right: 10px;
    background: #fff;
    padding: 10px 15px;
    box-shadow: 0 0 15px rgba(0,0,0,.3);
    display: none;
}
.tq-btns-show{
    display: block;
}
.tq-btns:after{
    right: 0;
    content: "\f0d7";
    font-family: FontAwesome;
    font-style: normal;
    font-weight: normal;
    color: #fff;
    bottom: -13px;
    position: absolute;
    font-size: 16px;
}
.month{
    float: left;
    margin: -5px 10px 0 0;
}
.progress{
    margin-bottom: 0px;
    background: transparent;
}
.earning-quiz{
     box-shadow: 0 0 10px rgba(0,0,0,.3);
     margin-top: 20px;
    position: relative;
}
.eq-list ul{
    list-style: none;
    padding-inline-start: 0px;
}
.eq-list ul li{
    padding: 20px 20px 10px;
}
.eq-list ul li:nth-child(even){
    background: #f8f8f8;   
}
.earning-table{
    overflow: hidden;
    background: #f8f8f8; 
}
.earning-table ul{
    padding-inline-start: 0px;
    padding: 0 0 0 10px;
}
.earning-table ul li{
    display: inline;
    padding: 5px 10px;
}
/*-----*/
.mentor-details-bg{
    box-shadow: 0 0 10px rgba(0,0,0,.3);
    padding: 20px 0 0;
//    border-radius: 20px;
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
    margin: 0 auto 30px;
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
.mentor-details .mentor-name{
    color:#333;
    font-family: lora;
    font-size:23px;
    font-weight: bold;
    margin-bottom: 5px;
}
.mentor-details p, mentor-fields p{
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
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
    margin-top: 10px;
}
.mentor-link a{
    margin-top: 20px;
    background:#00a0e3;
    color: #fff;
    text-align: center;
    font-family: roboto;
    font-size: 20px;
    padding: 15px 0;
    width: 100%;
    border: none;
    float: left;
}
.mentor-fields ul li, .mentor-expertise ul li{
    font-size: 16px;
    color: #333;
    font-weight: 400;
}
.mentor-fields p{
    margin-top: 0px;
}
/*-------modal ----------*/
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 10px; /* Location of the box */
  left: 0;
  top: 100px;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: scroll; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin:5% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 60%;
  text-align: center;

}

/* The Close Button */
.close, .closeInfo {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  position: absolute;
  top: 10px;
  right: 10px
}

.close:hover,
.closeInfo:hover,
.close:focus,
.closeInfo:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.share-input button{
    padding: 8px 14px;
    border: none;
    background: #00a0e3;
    color: #fff;
    float: right;
}
.share-input{
    max-width:500px;
    width: 100%;
    border:1px solid #eee;
    margin: 0 auto;
}
.shareLinkInput{
    width: 89%;
    padding:8px 10px;
//     border:1px solid #eee;
    border:transparent;
}
');
$script = <<<JS

JS;
$this->registerJS($script);
?>
<script>
    let tqActions = document.getElementsByClassName('tqActions');
    console.log(tqActions);
    for (let i = 0; i < tqActions.length; i++) {
        tqActions[i].addEventListener('click', showTqBtns)
    }

    function showTqBtns(e) {
        let tqDots = e.currentTarget.parentElement;
        let tqBox = tqDots.parentElement;
        let tqBtns = tqBox.querySelector('.tq-btns')
        if (tqBtns.classList.contains('tq-btns-show')) {
            tqBox.querySelector('.tq-btns').classList.remove('tq-btns-show')
        } else {
            tqBox.querySelector('.tq-btns').classList.add('tq-btns-show')
        }
    }

    let qlBtn = document.querySelector('.ql-share');
    let qlModal = document.getElementById("shareQuizModal");
    qlBtn.addEventListener('click', openInfoModal);

    function openInfoModal() {
        qlModal.style.display = 'block';
    }

    var closeInfo = document.querySelector(".close");
    closeInfo.onclick = function () {
        qlModal.style.display = 'none';
    }
    window.onclick = function (event) {
        if (event.target == qlModal) {
            qlModal.style.display = "none";
        }
    }

    function appendLink(e) {
        let shareLink = document.querySelector('.shareLinkInput').value;
        let attriBute = e.getAttribute('href');
        e.setAttribute('href', attriBute + shareLink)
    }

    function downloadImage(e) {
        let downImage = document.querySelector('.imagePath');
        let imagePath = downImage.getAttribute('src');
        e.setAttribute('href', imagePath);
        e.setAttribute('download', imagePath);
    }

    let topQuizDelete = document.getElementsByClassName('top-quiz-delete');
    for(let i = 0; i < topQuizDelete.length; i++){
        topQuizDelete[i].addEventListener('click', deleteTopQuiz);
    }
    function deleteTopQuiz(e) {
        let actionBtns = e.currentTarget.parentElement;
        actionBtns.parentElement.remove();
    }
</script>
