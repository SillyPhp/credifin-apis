<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['header_dark'] = false;
?>
    <section class="bg-imgg">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="box1">
                        <div class="heading-text-1">You're Welcome To Challenge Yourself</div>
                        <div class="inner-text">Take a quiz from different categories to test your knowledge</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--    <section>-->
    <!--        <div class="container mt-20">-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-6 col-sm-12">-->
    <!--                    <div class="box1">-->
    <!--                        <div class="heading-text-1">You're Welcome To Challenge Yourself</div>-->
    <!--                        <div class="inner-text">Take a quiz from different categories to test your knowledge</div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="col-md-6 col-sm-12">-->
    <!--                    <div class="row mar-top">-->
    <!--                        --><?php
//                        $next = 0;
//                        for ($i = 0; $i < 2; $i++) {
//                            ?>
    <!--                            <div class="col-md-6 col-sm-6 col-xs-6 top-categories pr-0">-->
    <!--                                --><?php
//                                for ($j = 0; $j < 2; $j++) {
//                                    ?>
    <!--                                    <div class="edu mb-15 top-categories-list">-->
    <!--                                        <a href="--><?//= Url::to('/quizzes?type=' . $data[$next]['slug']); ?><!--">-->
    <!--                                            <div class="newset">-->
    <!--                                                <div class="imag">-->
    <!--                                                    <img src="--><?//= $data[$next]['icon']; ?><!--"/>-->
    <!--                                                </div>-->
    <!--                                                <div class="txt-name">--><?//= $data[$next]['name']; ?><!--</div>-->
    <!--                                            </div>-->
    <!--                                        </a>-->
    <!--                                    </div>-->
    <!--                                    --><?php
//                                    $next++;
//                                }
//                                ?>
    <!--                            </div>-->
    <!--                            --><?php
//                        }
//                        ?>
    <!---->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--    </section>-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Choose Your Class</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <a href="/quizzes/subject-page">
                        <div class="class-box">
                            <div class="class-name">1st</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3">
                    <a href="/quizzes/subject-page">
                        <div class="class-box">
                            <div class="class-name">2nd</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3">
                    <a href="/quizzes/subject-page">
                        <div class="class-box">
                            <div class="class-name">3rd</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3">
                    <a href="/quizzes/subject-page">
                        <div class="class-box">
                            <div class="class-name">4th</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 col-sm-3">
                    <a href="/quizzes/subject-page">
                        <div class="class-box">
                            <div class="class-name">5th</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!--    <section>-->
    <!--        <div class="container">-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-12">-->
    <!--                    <div class="heading-style">Popular Categories</div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <!---->
    <!--    <section>-->
    <!--        <div class="container">-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-12">-->
    <!--                    <div class="popular-cate">-->
    <!--                        --><?php
//                        foreach ($data as $d) {
//                            ?>
    <!--                            <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">-->
    <!--                                <a href="--><?//= Url::to('/quizzes?type=' . $d['slug']); ?><!--">-->
    <!--                                    <div class="newset">-->
    <!--                                        <div class="imag">-->
    <!--                                            <img src="--><?//= $d['icon']; ?><!--"/>-->
    <!--                                        </div>-->
    <!--                                        <div class="txt-name">--><?//= $d['name']; ?><!--</div>-->
    <!--                                    </div>-->
    <!--                                </a>-->
    <!--                            </div>-->
    <!--                            --><?php
//                        }
//                        ?>
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="heading-style">Popular quiz</div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="type-1">
                        <div>
                            <a href="<?= Url::to('/quizzes/all'); ?>" class="btn btn-3">
                                <span class="txt"><?= Yii::t('frontend', 'View all'); ?></span>
                                <span class="round"><i class="fas fa-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($quiz as $q) {
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <a href="<?= Url::to($q['slug']); ?>" title="<?= $q['name']; ?>" class="quiz-box">
                            <div class="quiz-icon">
                                <img src="<?= Yii::$app->params->upload_directories->quiz->sharing->image . "/" . $q['sharing_image_location'] . "/" . $q['sharing_image'] ?>">
                            </div>
                            <div class="quiz-overlay">
                                <div class="quiz-text">
                                    <div class="quiz-creater">
                                        <div class="quiz-c-image"><img
                                                    src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>"
                                                    alt=""></div>
                                        <div class="quiz-c-name">alice</div>
                                    </div>
                                </div>
                            </div>
                            <div class="quiz-inner">
                                <div class="quiz-title">
                                    <?= $q['name']; ?>
                                </div>
                                <div class="quiz-ques">
                                    Total Questions : <?= $q['cnt']; ?>
                                </div>
                            </div>
                            <div class="take-quiz">
                                <span>Take Quiz</span>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="qz-main">
                        <div class="qz-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                        </div>
                        <div class="qz-count">
                            <span class="qz-q">16 question</span>
                            <span class="qz-plays">200 plays</span>
                        </div>
                        <div class="qz-inner">
                            <div class="qz-name">type of insurance</div>
                            <div class="qz-creater">
                                <div class="creator-name">
                                    <span class="creator-img">
                                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="">
                                    </span>
                                    <span>Pooja</span>
                                </div>
                                <div class="creator-grade">
                                    <span class="gd">grade :</span>
                                    <span class="cnt">8th</span>
                                </div>
                            </div>
                            <div class="qz-border"></div>
                            <div class="qz-level">Diificulty level : Easy</div>
                            <div class="take-quiz">
                                <span>Take Quiz</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.qz-border{
    border-bottom:2px solid #eee;
    margin:10px 0;
}
.qz-main {
	box-shadow: 0 0 15px 6px #eee;
	border-radius: 8px;
	overflow: hidden;
}
.qz-logo {
	width: 100%;
	height: 135px;
}
.qz-logo img{
	height: 135px;
	width: 100%;
}
.qz-count {
	margin-top: -15px;
	display: flex;
	justify-content: center;
}
.qz-q, .qz-plays {
	background-color: #000;
	padding: 2px 5px;
	color: #fff;
	font-family: roboto;
	font-size: 16px;
	border-radius: 4px;
	font-weight: 500;
	width: 100px;
	text-align: center;
	margin: 0 auto;
}
.qz-inner {
	padding: 15px 15px 0 15px;
	font-family: roboto;
}
.qz-name {
	font-size: 20px;
	text-transform: capitalize;
}
.qz-creater {
	display: flex;
	justify-content: space-between;
}
.creator-img img{
    width: 25px;
    border-radius: 50px;
    margin-right: 2px;
}
.creator-name, .creator-grade {
	font-size: 16px;
	text-transform: capitalize;
}
.qz-level {
	font-size: 15px;
}
.quiz-overlay {
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
	height: 150px;
	width: 100%;
	opacity: 0;
	transition: .4s all;
	background-color: #00a0e3;
	border-radius: 6px 6px 0 0;
}

.quiz-box:hover .quiz-overlay {
  opacity: .9;
  transform:scale(1.007);
}
.quiz-c-image {
    width: 70px;
    margin: auto;
    padding: 15px 0 5px;
}
.quiz-c-image img {
    border-radius: 60px;
}
.quiz-c-name {
	font-size: 20px;
	color: #fff;
	font-family: roboto;
	text-transform: capitalize;
	font-weight: 500;
}
//.quiz-text {
//  color: white;
//  font-size: 20px;
//  position: absolute;
//  top: 50%;
//  left: 50%;
//  -webkit-transform: translate(-50%, -50%);
//  -ms-transform: translate(-50%, -50%);
//  transform: translate(-50%, -50%);
//  text-align: center;
//}
.class-box {
    box-shadow: 0 0 7px 1px #eee;
    text-align: center;
    padding: 32px 0;
    min-height: 132px;
    border-radius: 4px;
    max-height: 132px;
    transition: all .3s;
    margin-bottom:20px;
}
.class-box:hover {
    background-color:#00a0e3;
    transform:scale(1.1)
}
.class-box:hover .class-name{color:#fff;}
.class-name {
    font-size: 40px;
    font-family: lora;
}
.top-categories:nth-child(2){
    margin-top:10px;
}
.top-categories:nth-child(1) .top-categories-list{
    float:right;
}
.quiz-header{
     background:url(' . Url::to('@eyAssets/images/pages/quiz/quiz-header1.png') . ');
     min-height:450px;
     background-repeat:no-repeat;
     background-size:cover;
     background-position:bottom;
}
.quiz-box{
    border:1px solid #eee;  
    text-align: center;
    border-radius: 10px;
    margin-bottom: 20px;
    display: block;
    position:relative;
}
.quiz-box:hover{
    box-shadow:0 0 8px rgba(0,0,0,.3);
}
.quiz-box:hover .quiz-icon img{
     -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1; 
}
.quiz-icon{
    width:100%;
    height:150px;
    overflow:hidden;
     border-radius:5px 5px 0 0; 
    position:relative;  
}
.quiz-icon img{
    border-radius:10px 10px 0 0;
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
}
.quiz-title{
    font-size: 15px;
    font-weight: bold;
    padding-top: 10px;
    font-family: lora;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 60px;
}
.quiz-ques{
    line-height: 13px;
    padding-top: 5px;   
}
.take-quiz{
    margin-bottom: 0px;
    overflow: hidden;
    padding: 20px 0 6px 0;
    text-align:center;
}
.take-quiz span{
    border:1px solid #eee;
    padding: 8px 13px;
    border-radius:5px 5px 0 0;
    font-size:13px;    
}
.take-quiz span:hover, .quiz-box:hover .take-quiz span{
    color:#fff;
    background:#00a0e3;
    border-color:#00a0e3;
    transition:.3s ease;
}
.text2{
  background-color: #00a0e3;
  color: white;
  font-size: 16px;
  font-family:lora;
  padding: 8px 0px;
  border-radius: 0 0 10px 10px;
}
.sett{padding-right:0px !important;}
.bg-imgg{
    background: url(\'/assets/themes/ey/images/quiz/quizhdr.png\');
    min-height: 500px;
    background-position: right;
    background-repeat: no-repeat;
    background-size:cover;
    background-size: cover;
    }
.box1{
    width:100%;
    text-align:center;
    padding-top:175px;
    }
.heading-text-1{
    font-size:43px;
    font-family:lora;
    font-weight:bold;
    text-transform:capitalize;
    line-height:55px;
    
    }
.inner-text {
	font-size: 18px;
	font-family: roboto;
	font-weight: 500;
	text-transform: capitalize;
	color: #8faaff;
}
.btnn{
    margin-bottom: 0px;
    padding-top:100px;
}
.btnn a{
    border:2px solid #eee;
    padding: 5px 18px;
    border-radius: 6px;
    font-size:13px;    
}
.btnn a:hover{
    color:#fff;
    background:#00a0e3;
    border-color:#00a0e3;
    transition:.3s ease;
}
.edu{
//    text-align:center;
//    box-shadow: 0 0 10px rgba(0,0,0,.3);
//    width: 160px;
    min-height: 245px;  
//    line-height: 210px;
    position: relative;
    clear:both;
}
.imag{
    text-align: right;
}
.txt-name {
    position: absolute;
    line-height: 17px;
    bottom: 10px;
    left: 0px;
    font-weight: 400;
    color: #222;
    font-family: roboto;
    text-transform: capitalize;
    background-color: #fff;
    padding: 0px 5px;
}
.top-categories-list{
    line-height: 30px;
    bottom: 10px;
    left: 10px;
    font-weight: 400;
    font-family:roboto;
    text-transform:uppercase;
 }
.popular-cate{
    text-align:center;
}
.newset{
    text-align:center;
    max-width: 160px;
    line-height: 210px;
    position: relative;
    width:100%;
    margin-bottom:20px;
}
@media only screen and (max-width:992px){
    .mar-top{
        margin-top:20px;
    }
}   
');
