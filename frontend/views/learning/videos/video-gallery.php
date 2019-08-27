<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;
use yii\helpers\Html;
//print_r($parentId);
//exit();
?>
    <section class="background" style="background: url('<?= $parentId['banner']?>');">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="heading-style h-spacing"><?= $parentId['name'];?></h2>
                </div>
            </div>
        </div>
    </section>

    <section class="topics-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Topics</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="popular-cate">

                    </div>
                </div>
            </div>
        </div>
    </section>

<!--    <section>-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-md-12">-->
<!--                    <div class="heading-style">Top Collaborators</div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row">-->
<!--            <div class="col-md-12">-->
<!--                <div class="pos-rel">-->
<!--                    <div class="parent">-->
<!--                        <div class="logo _1">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="logo _2">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="logo _3">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="logo _4">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="logo _5">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="logo _6">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="logo _7">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="logo _8">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="logo _9">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="logo _10">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="logo _11">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            <div class="overlay">-->
<!--                                <div class="text">-->
<!--                                    <span class="setloc">Hello World</span>-->
<!--                                    <span class="stars">-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star"></i>-->
<!--                                        <i class="fas fa-star-half-alt"></i>-->
<!--                                    </span>-->
<!--                                    <span class="revie">(4 Reviews)</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->

    <section class="videos-main">
        <div class="container">
            <div class="row">
                <div class=" col-md-12">
                    <div class="heading-style">Top Videos</div>
                </div>
            </div>
        </div>

        <!--Other Videos-->
        <div class="videorows">
            <div class="videorow container">
                <div class="col-md-12 row1 v-padding">

                    <div id="gallery-video"></div>

                </div>
            </div>
        </div>
    </section>

<!--    <section>-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class=" col-md-12">-->
<!--                    <div class="heading-style">Related Courses</div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="inst-box">-->
<!--                <div class="col-md-3 col-sm-6">-->
<!--                    <div class="inst-container">-->
<!--                        <a href="#">-->
<!--                            <div class="inst-icon">-->
<!--                                <img src="--><?//= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?><!--">-->
<!--                            </div>-->
<!--                            <div class="inst-member">-->
<!--                                <div class="inst-name">Web Developing</div>-->
<!--                                <div class="t-post">6weeks</div>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Related Jobs</div>
                </div>
            </div>
            <div class="jobs-list"></div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Related Internships</div>
                </div>
            </div>
            <div class="internships-list"></div>
        </div>
    </section>

    <section class="bg-black">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <hr style="color: #ff704d;width: 50px;margin-left: 5px; border-top:3px solid #ff704d;margin-bottom: 0px;"/>
                    <h3 style="font-family:lobster;font-size:28pt;color:#FFF;margin-top:3px;"><?= Yii::t('frontend', 'Quiz'); ?></h3>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="type-1">
                        <div>
                            <a href="<?= Url::to('/site/all-quiz'); ?>" class="btn btn-3">
                                <span class="txt"><?= Yii::t('frontend', 'View all Quizzes'); ?></span>
                                <span class="round"><i class="fas fa-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="q-box">
                        <a title="World Cup 2019 Quiz" href="/quiz/world-cup-2019">
                            <img src="<?= Url::to('@eyAssets/images/pages/quiz/vol_1.png') ?>" alt="World Cup 2019 Quiz"
                                 class="q-box-img">
                            <div class="q-box-hover">
                                <div class="text2">Take Quiz</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="q-box">
                        <a title="World Cup 2019 Quiz vol-2" href="/quiz/world-cup-2019-vol-2">
                            <img src="<?= Url::to('@eyAssets/images/pages/quiz/quiz-vol2.jpg') ?>"
                                 alt="World Cup 2019 Quiz vol-2" class="q-box-img">
                            <div class="q-box-hover">
                                <div class="text2">Take Quiz</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="q-box">
                        <a title="Yuvraj Singh Quiz" href="/quiz/yuvraj-singh-quiz">
                            <img src="<?= Url::to('@eyAssets/images/pages/quiz/yuvi-quiz.png') ?>"
                                 alt="Yuvraj Singh Quiz" class="q-box-img">
                            <div class="q-box-hover">
                                <div class="text2">Take Quiz</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="heading-style">Blogs</div>
                        </div>
                    </div>
                    <div id="whats-new" class="row">
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
echo $this->render('/widgets/blogs/whats-new', [
    'size' => 'col-md-3 col-sm-6',
    'is_ajax' => true,
]);
echo $this->render('/widgets/mustache/skills/video-gallery-video');

$this->registerCss('
.h-spacing{
    letter-spacing: 4px;
    word-spacing: 10px;
    text-transform: uppercase;
}
/*    <!-- view-all button css start -->*/
.btn-3 {
    background-color: #424242;
}
.btn-3 .round {
    background-color: #737478;
}
.type-1{
    float:right;
    margin-top: 15px;
}
.type-1 div a {
    text-decoration: none;
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
    padding: 12px 53px 12px 23px;
    color: #fff;
    text-transform: uppercase;
    font-family: sans-serif;
    font-weight: bold;
    position: relative;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    display: inline-block;
}
.type-1 div a span {
    position: relative;
    z-index: 3;
}
.type-1 div a .round {
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    position: absolute;
    right: 3px;
    top: 3px;
    -moz-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
    z-index: 2;
}
.type-1 div a .round i {
    position: absolute;
    top: 50%;
    margin-top: -6px;
    left: 50%;
    margin-left: -4px;
    color: #333332;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}
.txt {
    font-size: 14px;
    line-height: 1.45;
}
.type-1 a:hover {
    padding-left: 48px;
    padding-right: 28px;
}
.type-1 a:hover .round {
    width: calc(100% - 6px);
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
}
.type-1 a:hover .round i {
    left: 12%;
    color: #FFF;
}
/*<!---- view-all button css ends --->*/
.q-box{
    text-align:center;
    position:relative;   
    border-radius:10px;
    padding-bottom:35px;
    margin-bottom: 20px;
    overflow:hidden;
}
.bg-black{
    background:#2b2d32;
    padding-bottom:40px;
}
.q-box-img{
    opacity: 1;
    display: block;
    width: 100%;
    height: 200px;
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;
    backface-visibility: hidden;
    border-radius:10px;
}
.q-box:hover a .q-box-img{
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}
.q-box-hover{
   transition: .5s ease;
   opacity: 0;
   position: absolute;
   bottom: 0px;
   left: 50%;
   transform: translateX(-50%);
   -ms-transform: translateX(-50%);
   text-align: center;
}
.q-box a .q-box-img.coming-soon {
  opacity: 0.3;
}
.q-box a .q-box-hover {
  opacity: 1;
  width:100%
}
.text2{
  background-color: #00a0e3;
  color: white;
  font-size: 16px;
  font-family:lora;
  padding: 8px 0px;
  border-radius: 0 0 10px 10px;
}
.bttn-left, .bttn-right{
    background:transparent;
    color:#00a0e3;
}
 /*blog-section-0-css*/
.blog-section-0{
    padding:10px 0 30px 0;
    overflow:hidden;
}
.background{
    min-height:475px;
    padding-top: 120px;
    padding-left: 50px;
    background-size: 100% 100% !Important;
    background-repeat: no-repeat !Important;
    background-position: right bottom !Important;
}
.logo{
    width: 140px;
    height: 140px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 8px 13px 30px 5px rgba(162, 153, 153, 0.3);
}
.logo img{
    border-radius: 50%;
    height: 140px;
    width: 140px;
    }
.logo:hover .overlay {
  opacity: 1;
}
.overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  transition: .9s ease;
  background-color: #6F7375A1;
  border-radius:50%;
}
.setloc{display:block; font-weight:bold;}
.stars{display:block; color:orange; background-color:white;}
.revie{display:block;}
.text {
  color: white;
  font-size: 15 px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  width:100%;
}
.pos-rel{position:relative;}
.parent{height:400px;}
._1, ._2, ._3, ._4, ._5, ._6, ._7, ._8, ._9, ._10, ._11{
    position: absolute;
}
._1{
    position: absolute;
    left: 45%;
    top: 25%;
    }
._2{
    position: absolute;
    top: 2%;
    left: 31%;
    }
._3{
    position: absolute;
    left: 31%;
    top: 57%;
    }
._4{
    position: absolute;
    left: 59%;
    top: 2%;
    }
._5{
    position:absolute;
    left: 59%;
    top: 57%;
    }
._6{
    position:absolute;
    left: 17%;
    top: 25%;
    }
._7{
    position:absolute;
    left: 73%;
    top: 25%;
    }
._8{
    position: absolute;
    left: 3%;
    top: 2%;
    }
._9{
    position:absolute;
    left: 88%;
    top: 2%;
    }
._10{
    position:absolute;
    left: 3%;
    top: 57%;
    }
._11{
    position:absolute;
    left: 88%;
    top: 57%;
}
@media only screen and (max-width: 992px){
    ._1{
        left: 41%;
        top: 36%;
    }
    ._2{
        top: 4%;
        left: 27%;
    }
    ._3{
        left: 27%;
        top: 68%;
    }
    ._4{
        left: 55%;
        top: 4%;
    }
    ._5{
        left: 55%;
        top: 68%;
    }
    ._6{
        left: 14%;
        top: 36%;
    }
    ._7{
        left: 68%;
        top: 36%;
    }
    ._8{
        left: 1%;
        top: 4%;
    }
    ._9{
        left: 81%;
        top: 4%;
    }
    ._10{
        left: 1%;
        top: 68%;
    }
    ._11{
        left: 81%;
        top: 68%;
    }
}
@media only screen and (max-width: 768px){
    ._8, ._6, ._10, ._9, ._7, ._11{
        display: none;
    }
    ._2 {
        top: 2%;
        left:5%
    }
    ._3 {
        left: 5%;
        top: 69%;
    }
    ._5{
        left: 56%;
        top: 69%;
    }
    ._4{
        left: 56%;
        top: 2%;
    }
    ._1{
       left: 30%;
       top: 35%;
    }
}

.popular-cate{
    text-align:center;
    }
.newset{
    text-align:center;
    max-width: 160px;
    min-height: 245px;  
    line-height: 210px;
    position: relative;
    width:100%;
    margin-bottom:20px;
    }
.pc-main:nth-child(1) a .newset {
  background-color:#ffc0cb36;
}
.pc-main:nth-child(2) a .newset {
  background-color:#4e3cd52b;
}
.pc-main:nth-child(3) a .newset {
  background-color:#3cc2d52b;
}
.pc-main:nth-child(4) a .newset {
  background-color:#13060836;
}
.pc-main:nth-child(5) a .newset {
  background-color:#ff009b2b;
}
.pc-main:nth-child(6) a .newset {
  background-color:#1bc11a2b;
}
.pc-main:nth-child(7) a .newset {
  background-color:#7102022b;
}
.pc-main:nth-child(8) a .newset {
  background-color:#0ccc772b;
}
.imag{
    text-align: right;
    }
.txt{
    position: absolute;
    line-height: 30px;
    bottom: 10px;
    left: 10px;
    font-weight: 400;
    font-family:roboto;
    text-transform:uppercase;
     }
.heading-style{
    font-family: lobster;
    font-size: 28pt;
    text-align: left;
    margin: 15px 5px;
}
.heading-style:before{
    content: "";
    position: absolute;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 0 0 5px 52px;
    border-color: #f07706;
}
.v-padding{
    padding: 10px 0;
}
.v-videobox a img:hover{
    transform: scale(1.1); 
    box-shadow: 0px 0px 15px rgb(0, 0, 0,.5);
    transition: .3s ease-in-out; 
    margin-bottom: 0px;
}
.view-box{
    text-align: center;
    padding: 20px 0 30px 0; 
}
.view-box a{
    border: 1px solid #ff7803;
    padding: 10px 20px; 
    background: #ff7803; 
    color: #fff;
}
.view-box a:hover{
    background: #fff; 
    color: #ff7803; 
    text-decoration: none; 
    transition: .3s ease-in-out;
}
.v-text{
    text-align: left; 
    color: #337ab7; 
    font-size: 16px; 
    margin-top: 10px; 
    font-weight: bold;
}
.v-text a:hover{
    text-decoration: none; 
    color: #337ab7;
}
@media screen and (max-width: 992px) {
    .v-text{
        padding-bottom:20px 
    }
}
/*collaborators css starts*/
.collaborators-main {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start;
    overflow: hidden;
}
.collaborators-main .c-detail {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    height: 220px;
}
.collaborators-main .c-detail .title {
    font-size: 20px;
    line-height: 30px;
    color: #07c3ff;
    font-weight: 700;
    margin-bottom: 10px;
}
.collaborators-main .c-detail .title {
    font-size: 18px;
    color: #2a384c;
}
.collaborators-main .c-detail .post {
    font-size: 16px;
    line-height: 26px;
    color: #616161;
}
.collaborators-main .c-detail .post {
    font-size: 14px;
    color: #197BEB;
}
.collaborators-main .c-detail .social-icon {
    margin: 0;
    padding: 0;
    margin-top: 20px;
    position: relative;
    padding-top: 20px;
}
.collaborators-main .c-detail .social-icon li {
    list-style: none;
    display: inline-block;
    margin: 0px;
    text-align: center;
}
.collaborators-main .c-detail .social-icon li a {
    display: block;
    width: 30px;
    height: 30px;
    line-height: 30px;
    border-radius: 50%;
    background-color: #dfdfdf;
    -webkit-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.53);
    box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.53);
    color: #4f78ee;
    font-size: 14px;
    -webkit-transition: .3s ease-in;
    -o-transition: .3s ease-in;
    transition: .3s ease-in;
}
.collaborators-main .c-detail .social-icon li a {
    background-color: #f2f2f2;
    color: #515151;
    font-size: 16px;
}
.collaborators-main .thumb {
    width: 200px;
    height: 200px;
    overflow: hidden;
    margin-left: 10px;
}
.collaborators-main .thumb img {
    -webkit-transition: 1s ease-in-out;
    -o-transition: 1s ease-in-out;
    transition: 1s ease-in-out;
  width:100%;
}
.collaborators-main .c-detail .social-icon:after {
    position: absolute;
    left: 0;
    top: 0;
    width: 120%;
    background-color: #07c3ff;
    content: "";
    height: 1px;
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
    -webkit-transition: 1s ease-in;
    -o-transition: 1s ease-in;
    transition: 1s ease-in;
    z-index: 1;
}
.collaborators-main .c-detail .social-icon:after {
    background-color: #197BEB;
}
.collaborators-main:hover .thumb img {
    -webkit-transform: scale(1.3);
    -ms-transform: scale(1.3);
    transform: scale(1.3);
}
.collaborators-main:hover .c-detail .social-icon:after {
    -webkit-transform: translateX(0%);
    -ms-transform: translateX(0%);
    transform: translateX(0%);
}
/*collaborators css ends*/
.inst-name{
    font-size:16px;
    font-weight:bold;
}
.inst-member{
    padding:5px 10px 10px 10px;
    text-align:center;
}
.inst-icon{
    width:100%;
    overflow:hidden;
    object-fit:cover;
    position:relative;
}
.inst-icon img{
    border-radius:10px 10px 0 0; 
    width:100%;
    height:100%;
}
.inst-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:100%;
    position:relative;
    margin: 0 0 20px 0;
}
');

$script = <<< JS
function fillData(){
    $.ajax({
        type: 'POST',
        async: false,
        url: '/learning/videos/get-category-job',
        data: {
            'keyword' : 'it'
        },
        success: function(result){
                var application_card = $('#application-card').html();
                var jobs_render = Mustache.render(application_card, result.jobs);
                $('.jobs-list').html(jobs_render);
            
                var application_card = $('#application-card').html();
                var internships_render = Mustache.render(application_card, result.internships);
                $('.internships-list').html(internships_render);
            
            utilities.initials();
        }
    })
}
fillData();
JS;
$this->registerJs($script);
?>
<script id="application-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-12 col-xs-12 pt-5">
        <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
             class="application-card-main">
            {{#city}}
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fas fa-map-marker-alt"></i>&nbsp;{{city}}
                </span>
            {{/city}}
            {{^city}}
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fas fa-map-marker-alt"></i>&nbsp;All India
                </span>
            {{/city}}
            <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                <div class="application-card-img">
                    <a href="{{organization_link}}">
                        {{#logo}}
                        <img src="{{logo}}">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon" name="{{organization_name}}" width="80" height="80"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </a>
                </div>
                <div class="application-card-description">
                    <a href="{{link}}"><h4 class="application-title">{{title}}</h4></a>
                    {{#salary}}
                    <h5><i class="fas fa-rupee-sign"></i>&nbsp;{{salary}}</h5>
                    {{/salary}}
                    {{^salary}}
                    <h5>Negotiable</h5>
                    {{/salary}}
                    {{#type}}
                    <h5>{{type}}</h5>
                    {{/type}}
                    {{#experience}}
                    <h5><i class="far fa-clock"></i>&nbsp;{{experience}}</h5>
                    {{/experience}}
                </div>
            </div>
            {{#last_date}}
            <h6 class="col-md-5 pl-20 custom_set2 text-center">
                Last Date to Apply
                <br>
                {{last_date}}
            </h6>
            <h4 class="col-md-7 org_name text-right pr-10">
                {{organization_name}}
            </h4>
            {{/last_date}}
            {{^last_date}}
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h4 class="org_name text-right">{{organization_name}}</h4>
            </div>
            {{/last_date}}
            <div class="application-card-wrapper">
                <a href="{{link}}" class="application-card-open">View Detail</a>
                <a href="#" class="application-card-add">&nbsp;<i class="fas fa-plus"></i>&nbsp;</a>
            </div>
        </div>
    </div>
    {{/.}}
</script>
