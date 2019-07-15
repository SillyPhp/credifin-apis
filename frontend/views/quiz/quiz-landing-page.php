<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->params['header_dark'] = false;
?>
    <section class="bg-imgg">

    </section>

    <section>
        <div class="container mt-20">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="box1">
                        <div class="heading-text-1">You're Welcome To Challenge Yourself</div>
                        <div class="inner-text">Take a quiz from different categories to test your knowledge</div>
<!--                        <div class="btnn"><A href="#">View All</A></div>-->
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row mar-top">
                        <div class="col-md-6 col-sm-6 col-xs-6 sett pl-1">
                            <div class="edu mb-15">
                                <a href="#"><img src="<?= Url::to('/assets/themes/ey/images/quiz/eduicon.png');?>"></a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6 mt-5 pr-1">
                            <div class="edu1 mt-15">
                                <a href="#"><img src="<?= Url::to('/assets/themes/ey/images/quiz/qicon3.png');?>"></a>
                            </div>
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
                    <div class="heading-style">Popular Categories</div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="popular-cate">
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0">
                            <a href="#"><div class="cate1"><img src="<?= Url::to('/assets/themes/ey/images/quiz/qicon2.png');?>"></div></a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0">
                            <a href="#"><div class="cate2"><img src="<?= Url::to('/assets/themes/ey/images/quiz/qicon3.png');?>"></div></a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0">
                            <a href="#"><div class="cate3"><img src="<?= Url::to('/assets/themes/ey/images/quiz/qicon4.png');?>"></div></a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0">
                            <a href="#"><div class="cate4"><img src="<?= Url::to('/assets/themes/ey/images/quiz/qicon5.png');?>"></div></a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0">
                            <a href="#"><div class="cate5"><img src="<?= Url::to('/assets/themes/ey/images/quiz/qicon6.png');?>"></div></a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0">
                            <a href="#"><div class="cate6"><img src="<?= Url::to('/assets/themes/ey/images/quiz/qicon7.png');?>"></div></a>
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
                    <div class="heading-style">Popular Quiz</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 pb-15">
                    <div class="q-box">
                        <a title="World Cup 2019 Quiz" href="/quiz/world-cup-2019">
                            <img src="<?= Url::to('/assets/themes/ey/images/quiz/vol_1.png') ?>" alt="World Cup 2019 Quiz"
                                 class="q-box-img">
                            <div class="q-box-hover">
                                <div class="text2">Take Quiz</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 pb-15">
                    <div class="q-box">
                        <a title="World Cup 2019 Quiz vol-2" href="/quiz/world-cup-2019-vol-2">
                            <img src="<?= Url::to('/assets/themes/ey/images/quiz/quiz-vol2.jpg') ?>"
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
                            <img src="<?= Url::to('/assets/themes/ey/images/quiz/yuvi-quiz.png') ?>"
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
                <div class="col-md-12">
                    <div class="heading-style">All quiz</div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="quiz-box">
                        <div class="quiz-icon">
                            <img src="<?= Url::to('/assets/themes/ey/images/quiz/yuvi-quiz.png') ?>">
                        </div>
                        <div class="quiz-title">Yuvraj singh
                        </div>
                        <div class="quiz-ques">
                            Total Questions :12
                        </div>
                        <div class="take-quiz">
                            <a href="">Take Quiz</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php
$this->registerCss('
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
    heigth:100%;
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
    height: auto;
    transition: .5s ease;
    backface-visibility: hidden;
}
.quiz-title{
    font-size:15px;
    font-weight:bold;
    padding-top: 10px;
    font-family:lora;
}
.quiz-ques{
    line-height: 13px;
    padding-top: 5px;   
}
.take-quiz{
    margin-bottom: 0px;
    overflow: hidden;
    padding: 20px 0 6px 0;
}
.take-quiz a{
    border:1px solid #eee;
    padding: 8px 13px;
    border-radius:5px 5px 0 0;
    font-size:13px;    
}
.take-quiz a:hover{
    color:#fff;
    background:#00a0e3;
    border-color:#00a0e3;
    transition:.3s ease;
}
.q-box{
    text-align:center;
    position:relative;   
    border-radius:10px;
    padding-bottom:35px;
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
.sett{padding-right:0px !important;}
.bg-imgg{
    background: url(\'/assets/themes/ey/images/quiz/quizhdr.png\');
    min-height: 500px;
    background-position: bottom;
    background-repeat: no-repeat;
    background-size:cover;
    background-size: 100% 100%;
    }
.box1{
    width:100%;
    text-align:center;
    }
.heading-text-1{
    font-size:43px;
    font-family:lora;
    font-weight:bold;
    text-transform:capitalize;
    }
.inner-text{
    font-size:18px;
    font-family:roboto;
    font-weight:300;
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
    text-align:right;
    }
.edu img{
     box-shadow: 0 0 10px rgba(0,0,0,.3);
     }
.edu1{
    text-align:left;
    }
.edu1 img{
     box-shadow: 0 0 10px rgba(0,0,0,.3);
     }
.popular-cate{
    text-align:center;
    }
.cate1 {
    padding-bottom:20px;
    }
.cate1 img{
     box-shadow:0 0 10px rgba(255, 157, 10, 0.90);
     }
.cate2 {
    padding-bottom:20px;
    }
.cate2 img{
     box-shadow: 0 0 10px rgba(15, 6, 156, 0.90);
     }
.cate3 {
    padding-bottom:20px;
    }
.cate3 img{
     box-shadow:0 0 10px rgb(108, 110, 103);
     }
.cate4 {
    padding-bottom:20px;
    }
.cate4 img{
     box-shadow: 0 0 10px rgba(216, 42, 146, 0.90);
     }
.cate5 {
    padding-bottom:20px;
    }
.cate5 img{
     box-shadow:0 0 10px rgba(108, 97, 17, 0.90);
     }
.cate6 {
    padding-bottom:20px;
    }
.cate6 img{
     box-shadow: 0 0 10px rgba(14, 96, 134, 0.90);
     }
 @media only screen and (max-width:992px){
    .mar-top{
        margin-top:20px;
    }
 }   
 ');
$script = <<<JS
JS;
$this->registerJs($script);