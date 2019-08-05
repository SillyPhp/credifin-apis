<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;
use yii\helpers\Html;

?>
    <div class="background"></div>
    <div class="container">
        <div class="row col-md-12">
            <div class="heading-style col-md-6 col-sm-6">Top Topics</div>
        </div>
    </div>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="popular-cate">
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                            <a href="">
                                <div class="newset">
                                    <div class="imag">
                                        <img src="http://ajay.eygb.me/assets/common/quiz_categories/blog.png">
                                    </div>
                                    <div class="txt">study</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                            <a href="">
                                <div class="newset">
                                    <div class="imag">
                                        <img src="http://ajay.eygb.me/assets/common/quiz_categories/blog.png">
                                    </div>
                                    <div class="txt">study</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                            <a href="">
                                <div class="newset">
                                    <div class="imag">
                                        <img src="http://ajay.eygb.me/assets/common/quiz_categories/blog.png">
                                    </div>
                                    <div class="txt">study</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Top Collaborators</div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="collaborators-main">
                        <div class="c-detail">
                            <h4 class="title">Makayla Linger</h4>
                            <span class="post">operator</span>
                            <ul class="social-icon">
                                <li><a href="#">
                                        <i class="fab fa-facebook"></i></a>
                                </li>
                                <li><a href="#">
                                        <i class="fab fa-twitter"></i></a>
                                </li>
                                <li><a href="#">
                                        <i class="fab fa-instagram"></i></a>
                                </li>
                                <li><a href="#">
                                        <i class="fab fa-google-plus-g"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="thumb">
                            <img src="https://plugins.xgenious.com/tbuilder/wp-content/uploads/2018/12/08-280x280.jpg"
                                 alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="collaborators-main">
                        <div class="c-detail">
                            <h4 class="title">Makayla Linger</h4>
                            <span class="post">operator</span>
                            <ul class="social-icon">
                                <li><a href="#">
                                        <i class="fab fa-facebook"></i></a>
                                </li>
                                <li><a href="#">
                                        <i class="fab fa-twitter"></i></a>
                                </li>
                                <li><a href="#">
                                        <i class="fab fa-instagram"></i></a>
                                </li>
                                <li><a href="#">
                                        <i class="fab fa-google-plus-g"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="thumb">
                            <img src="https://plugins.xgenious.com/tbuilder/wp-content/uploads/2018/12/08-280x280.jpg"
                                 alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="collaborators-main">
                        <div class="c-detail">
                            <h4 class="title">Makayla Linger</h4>
                            <span class="post">operator</span>
                            <ul class="social-icon">
                                <li><a href="#">
                                        <i class="fab fa-facebook"></i></a>
                                </li>
                                <li><a href="#">
                                        <i class="fab fa-twitter"></i></a>
                                </li>
                                <li><a href="#">
                                        <i class="fab fa-instagram"></i></a>
                                </li>
                                <li><a href="#">
                                        <i class="fab fa-google-plus-g"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="thumb">
                            <img src="https://plugins.xgenious.com/tbuilder/wp-content/uploads/2018/12/08-280x280.jpg"
                                 alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row col-md-12">
                <div class="heading-style col-md-6 col-sm-6">Top Videos</div>
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

    <section>
        <div class="container">
            <div class="row col-md-12">
                <div class="heading-style col-md-6 col-sm-6">Related Courses</div>
            </div>
            <div class="inst-box">
                <div class="col-md-3 col-sm-6">
                    <div class="inst-container">
                        <a href="#">
                            <div class="inst-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            </div>
                            <div class="inst-member">
                                <div class="inst-name">Web Developing</div>
                                <div class="t-post">6weeks</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row col-md-12">
                <div class="heading-style col-md-6 col-sm-6">Related Jobs</div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 pt-5">
                <div class="application-card-main">
                        <span class="application-card-type location">
                            <i class="fas fa-map-marker-alt"></i>&nbsp;
                      </span>

                    <span class="application-card-type location">
                            <i class="fas fa-map-marker-alt"></i>&nbsp;All India
                        </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="" title="">
                                <img src="https://www.empoweryouth.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/W10EsCvmo-75qtYr9L77yP1BrP6Q2I5c/WYn1kN3q6R6KAGmB3mNVoglZbMv0OE.png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="" title=""><h4 class="application-title">web design</h4></a>
                            <h5><i class="fas fa-rupee-sign"></i>&nbsp;60000</h5>
                            <h5>Full Time</h5>
                            <h5><i class="far fa-clock"></i>&nbsp;2years</h5>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h4 class="org_name text-right">dsb law group</h4>
                    </div>
                    <div class="application-card-wrapper">
                        <a href="" class="application-card-open" title="View Detail">View Detail</a>
                        <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i
                                    class="fas fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row col-md-12">
                <div class="heading-style col-md-6 col-sm-6">Related Internships</div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 pt-5">
                <div class="application-card-main">
                        <span class="application-card-type location">
                            <i class="fas fa-map-marker-alt"></i>&nbsp;
                      </span>

                    <span class="application-card-type location">
                            <i class="fas fa-map-marker-alt"></i>&nbsp;All India
                        </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="" title="">
                                <img src="https://www.empoweryouth.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/W10EsCvmo-75qtYr9L77yP1BrP6Q2I5c/WYn1kN3q6R6KAGmB3mNVoglZbMv0OE.png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="" title=""><h4 class="application-title">web design</h4></a>
                            <!--                            <h5><i class="fas fa-rupee-sign"></i>&nbsp;60000</h5>-->
                            <h5>negotiable</h5>
                            <h5>Full Time</h5>
                            <!--                            <h5><i class="far fa-clock"></i>&nbsp;2years</h5>-->
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h4 class="org_name text-right">tech adaptive</h4>
                    </div>
                    <div class="application-card-wrapper">
                        <a href="" class="application-card-open" title="View Detail">View Detail</a>
                        <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i
                                    class="fas fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">new design</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="pos-rel">
                    <div class="parent">
                        <div class="logo _1">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="logo _2">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="logo _3">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="logo _4">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="logo _5">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="logo _6">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="logo _7">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="logo _8">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="logo _9">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="logo _10">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="logo _11">
                            <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            <div class="overlay">
                                <div class="text">
                                    <span class="setloc">Hello World</span>
                                    <span class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </span>
                                    <span class="revie">(4 Reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php

echo $this->render('/widgets/mustache/skills/video-gallery-video');

$this->registerCss('
.background{
    background:url("' . Url::to("@eyAssets/images/pages/learning-corner/learning.png") . '");
    min-height:550px;
    background-size: cover;
    background-repeat: no-repeat;
}
.setloc{display:block; font-weight:bold;}
.stars{display:block; color:orange; background-color:white;}
.revie{display:block;}
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

.logo:hover .overlay {
  opacity: 1;
}

.text {
  color: white;
  font-size: 15 px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
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
    left: 16%;
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
.logo img{
    border-radius: 50%;
    height: 140px;
    width: 140px;
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

JS;
$this->registerJs($script);
