<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;
use yii\helpers\Html;

?>
    <div class="container sec2">
        <div class="row col-md-12">
            <div class="heading-style col-md-6 col-sm-6">Topics</div>
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

    <div class="container sec2">
        <div class="row col-md-12">
            <div class="heading-style col-md-6 col-sm-6">Videos</div>
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

<?php

echo $this->render('/widgets/mustache/skills/video-gallery-video');

$this->registerCss('
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
.sec2{
    padding-top: 15px;
}
@media screen and (max-width: 992px) {
    .v-text{
        padding-bottom:20px 
    }
}
');

$script = <<< JS

JS;
$this->registerJs($script);
