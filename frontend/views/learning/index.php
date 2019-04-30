<?php
$this->title = Yii::t('frontend', 'Learning Corner');

use yii\helpers\Url;

?>
    <section class="backgrounds">
        <div class="container headsec">
            <div class="row">
                <div class="col-md-6 col-sm-12 mt-50">
                    <div class="jumbo-heading">BOOST YOUR SKILLS</div>
                    <div class="jumbo-subheading"> Learn Something <span class="jumbo-heading">New Everyday</span></div>
                    <div class="search-box1">
                        <form action="<?= Url::to('/learning/search-video') ?>">
                            <input type="text" placeholder="Search" name="keyword">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 sm-hidden">
                    <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/bgtop.svg'); ?>" align="right"
                         class="responsive"/>
                </div>
            </div>
        </div>
    </section>

    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="empty"></div>


    <div class="container ">
        <div class="cat-padding">
            <div class="row col-md-12">
                <div class="heading-style col-md-6 col-sm-6">All Category</div>
<!--                <div class="search-box">-->
<!--                    <form action="">-->
<!--                        <input type="text" placeholder="Search Category" name="search">-->
<!--                        <button type="submit"><i class="fa fa-search"></i></button>-->
<!--                    </form>-->
<!--                </div>-->
            </div>
            <div class="categories">
                <div class="row category b-padding">

                    <?php foreach($categories as $c) { ?>
                        <div class="f-box col-md-3 col-sm-6">
                            <div class="flipbox ">
                                <a href="/learning/videos/category/<?= $c['slug'] ?>" class="lc-link">
                                    <div class="back">
                                        <div class="b-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/lc_categories_flip.png'); ?>"  alt=""/>
                                        </div>
                                    </div>
                                    <div class="front">
                                        <div class="b-icon">
                                            <?php if($c['child_icon']){ ?>
                                                <img src="" alt=""/>
                                            <?php } else{ ?>
                                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/lc_categories.png'); ?>" alt=""/>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="b-text"><?= $c['parent_name']; ?></div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <!--dynamic categories start-->

    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="empty"></div>

    <!--dynamic categories end-->

    <div class="working-box ">
        <div class="container">
            <div class="heading-style">How It Works</div>
        </div>
        <div class="box1 col-md-3 col-sm-6">
            <div class="bar-icon"><img src="<?= Url::to('@eyAssets/images/pages/learning-corner/bar-icon-1.png'); ?>"
                                       alt=""/></div>
            <div class="w-heading">Want to Learn</div>
            <div class="w-text">Do you have something in mind that you want to learn</div>
        </div>
        <div class="box2 col-md-3 col-sm-6">
            <div class="bar-icon"><img src="<?= Url::to('@eyAssets/images/pages/learning-corner/bar-icon-2.png'); ?>"
                                       alt=""/></div>
            <div class="w-heading">Don't Know</div>
            <div class="w-text">Missing resources from where you can learn</div>
        </div>
        <div class="box3 col-md-3 col-sm-6">
            <div class="bar-icon"><img src="<?= Url::to('@eyAssets/images/pages/learning-corner/bar-icon-3.png'); ?>"
                                       alt=""/></div>
            <div class="w-heading">Search Here</div>
            <div class="w-text">Search Empower Youth's learning corner.</div>
        </div>
        <div class="box4 col-md-3 col-sm-6">
            <div class="bar-icon"><img src="<?= Url::to('@eyAssets/images/pages/learning-corner/bar-icon-4.png'); ?>"
                                       alt=""/></div>
            <div class="w-heading">Start Learning</div>
            <div class="w-text">Find resources and start learning at empower youth</div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="empty"></div>

    <div class="container ">
        <div class="cat-padding">
            <div class="mv">
                <div class="container">
                    <div class="heading-style">Most Popular Topics</div>
                    <div class="mt-actions " style="">
                        <?php foreach($topics as $t) { ?>
                            <div class="col-md-3 col-sm-4">
                                <div class="topic-con">
                                    <a href="/learning/videos/topic/<?= $t['slug']?>">
                                        <div class="hr-company-box">
                                            <div class="hr-company-box-center">
                                                <div class="hr-com-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/lc_tags.png'); ?>"
                                                         class="img-responsive ">
                                                </div>
                                                <div class="hr-com-name">
                                                    <?= $t['name']; ?>
                                                </div>
                                                <div class="hr-com-field">
                                                    <?= $t['cnt']; ?> Videos
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="empty"></div>

    <div class="container">
        <!-- Example row of columns -->
        <div class="row col-md-12">
            <div class="heading-style col-md-6 col-sm-6">Most Popular Videos</div>
        </div>
    </div>
    <div class="v-slider">
        <div class="container">
            <div id="mixedSlider">
                <div class="MS-content">
                    <?php foreach ($popular_videos as $p) { ?>
                        <div class="item">
                            <div class="imgTitle">
                                <a href="<?= Url::to('learning/video/' . $p['slug']); ?>">
                                    <img src="<?= Url::to($p['cover_image']); ?>" alt=""/>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="blogTitle">
                                <a href="<?= Url::to('learning/video/' . $p['slug']); ?>">
                                    <?= Yii::t('frontend', $p['title']); ?>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                </div>
                <div class="MS-controls">
                    <button class="MS-left"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                    <button class="MS-right"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
.search-box1{
    max-width:350px;
    float:left;
//  border: 1px solid #ccc;
    border-radius: 10px;
    padding: 3px;
    margin: 21px 0 0 0;
}
.search-box1 form{
    margin-bottom:0px;
}
.search-box1 input[type=text] {
    padding: 11px;
    font-size: 15px;
    border:none ;
    border-radius:10px 0 0 10px;
}
.search-box1 input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
.search-box1 button {
    float: right;
    padding: 9px 10px;
    background: #fff;
    font-size: 18px;
    border-radius:0 10px 10px 0;
    border: none;
    cursor: pointer;
}
.search-box1 button:hover {
    color: #ff7803; 
}
.sm-hidden img{
    width:80%;
}
.flipbox a.lc-link{ 
    color:#333;
}
.backgrounds{
    background-size: 100% 595px;
    background-image: url(' . Url::to('@eyAssets/images/backgrounds/learning-corner.png') . ');
    background-position: left top;
    background-repeat: no-repeat;
    min-height: 600px;
    padding-top: 70px;
}
.head-pic{
    text-align: center;
}
.headsec{
    color:#333;
}
.jumbo-heading{
    font-size: 45px;
    font-weight:bold;
    font-family: lobster;
    text-transform: uppercase; 
}
.jumbo-subheading{
    font-size: 25px;
    padding-top: 0px;
    font-family: lobster
}
.jumbo-subheading span{
    text-transform: uppercase;
}
.search-box{
    float: right;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 3px;
    margin: 21px 0 0 0;
}
.search-box form{
    margin-bottom:0px;
}
.search-box input[type=text] {
    padding: 9px;
    font-size: 15px;
    border:none ;
}
.search-box input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
.search-box button {
    float: right;
    padding: 8px 10px;
    background: transparent;
    font-size: 17px;
    border: none;
    cursor: pointer;
}
.search-box button:hover {
    color: #ff7803; 
}
.f-box{
    text-align: center;
    align-content: center;
    margin: 0 auto;
}
.b-padding{
    padding-top: 125px;
}
.c-padding{
    padding-top: 125px;
}
.flipbox{
    position:relative;
    width:160px;
    height:160px;
    padding-top:10px;
    margin-left:50px;
}
.flipbox a > .front{
    position:relative;
    text-align: center; 
    transform: perspective(600px) rotateY(0deg );
    height: 160px; width: 160px;
    background:transparent; 
    backface-visibility:hidden;
    transition: transform .5s linear 0s;
}
.flipbox a > .back{         
    text-align: center;
    position: absolute;
    justify-content: center;
    transform: perspective(600px) rotateY(180deg );
    height: 160px; width: 160px; background: #ff7803; border-radius:50%; 
    backface-visibility:hidden;
    transition: transform .5s linear 0s;	
}
.flipbox > a .back > .b-icon{
    height: 160px;
    line-height: 160px;  
}
.flipbox a:hover > .front{
    transform: perspective(600px) rotateY(-180deg );
}
.flipbox a:hover > .back{
    transform: perspective(600px) rotateY(0deg );
}
/*.flipbox a{
    color: #333;
}*/
.flipbox a:hover{
    color: #ff7803 !important; 
    transition: .3s ease-in-out; 
    text-decoration: none;
}
a .b-text{
    text-align: center; 
    padding: 20px 0 0 0; 
    font-weight: bold; 
    font-size: 20px; 
    text-decoration: none; 
    text-transform: capitalize; 
}
/*a .b-text:hover{
    color:#ff7803 !important; 
    text-decoration: none; 
}*/
.seemore{
    padding: 125px 0 0 0; 
    text-align: center;
}
.seemore a{
    border: 1px solid #ff7803; 
    padding: 10px 25px; 
    color:#fff; 
    background: #ff7803; 
    font-size: 17px; 
    border-radius: 5px
}
.seemore a:hover{
    background: #fff; 
    color: #ff7803; 
    transition: all .5s; 
    text-decoration: none; 
    box-shadow: 0px 0px 10px rgb(255, 120, 3, .5 )  
}
.cat-padding{
    padding-top:20px;
}
.mv{
    padding: 0px 0 0 0;
}
.mv1{
    background: #fff; 
    color: #080808; 
    border: 1px solid #ccc; 
    padding: 20px 10px; 
    text-align: center; 
    font-size:18px; 
    border-radius:5px; 
    min-height:100px; 
}
.mv1:hover{
    box-shadow: 0px 0px 15px rgb(0, 0, 0, .5); 
    transition: .3s ease-in-out;
}
.working-box{ 
    padding: 30px 0 !important;
     margin: 60px 0 0px 0; 
}
.box1{
    background: #fa811a; 
    padding: 40px 50px 0px 50px; 
    min-height: 280px;
}
.box2{
    background: #ff902f; 
    padding: 40px 50px 0px 50px; 
    min-height: 280px;
}
.box3{
    background: #ff9e4a; 
    padding: 40px 50px 0px 50px; 
    min-height: 280px;
}
.box4{
    background: #ffac64; 
    padding: 40px 50px 0px 50px; 
    min-height: 280px;
}
.w-heading{
    color: #fff; 
    padding: 20px 0 20px 0; 
    font-size: 20px; 
    text-transform: uppercase; 
    font-weight: 600; 
}
.w-heading:before{
   content: "";
   position: absolute;
   width: 0;
   height: 0;
   border-style: solid;
   border-width: 0 0 3px 40px;
   border-color: #fff;
   margin-top:-3px 
}
.w-text{
    color:#fff; 
    font-size: 16px
}
.empty{
    padding-bottom: 20px; 
}
.v-slider{
    padding-top: 20px; 
    padding-bottom: 40px;
}
#mixedSlider {
    position: relative;
}
#mixedSlider .MS-content {
    white-space: nowrap;
    overflow: hidden;	
    margin: 0 5%;
}
#mixedSlider .MS-content .item {
  display: inline-block;
  width: 33.3333%;
  position: relative;
  vertical-align: top;
  overflow: hidden;
  height: 100%;
  white-space: normal;
  padding: 0 10px;
}
@media (max-width: 991px) {
  #mixedSlider .MS-content .item {
    width: 50%;
  }
}
@media (max-width: 767px) {
  #mixedSlider .MS-content .item {
    width: 100%;
  }
}
#mixedSlider .MS-content .item .imgTitle a {
  position: relative;
}
#mixedSlider .MS-content .item .blogTitle  a{
  color: #252525;
  font-style:normal !important;
  background-color: rgba(255, 255, 255, 0.5);
  width: 100%;
  bottom: 0;
  font-weight: bold;
  padding: 10px 0 0 0;
  font-size: 16px;
  
}
#mixedSlider .MS-content .item .imgTitle img {
  height: auto;
  width: 100%;
}
#mixedSlider .MS-content .item p {
  font-size: 16px;
  margin: 0px 0px 0 5px;
text-align: left;
  padding-top: 0px !important;
}
#mixedSlider .MS-content .item a {
  margin: 0 0 0 0;
  font-size: 16px;
  font-style: italic;
  color: rgba(173, 0, 0, 0.82);
  font-weight: bold;
  transition: linear 0.1s;
}
#mixedSlider .MS-content .item a:hover {
  text-shadow: 0 0 1px grey; text-decoration: none;
}
#mixedSlider .MS-controls button {
  position: absolute;
  border: none;
  background-color: transparent;
  outline: 0;
  font-size: 50px;
  top: 95px;
  color: rgba(0, 0, 0, 0.4);
  transition: 0.15s linear;
}
#mixedSlider .MS-controls button:hover {
  color: rgba(0, 0, 0, 0.8);
}
@media (max-width: 992px) {
  #mixedSlider .MS-controls button {
    font-size: 30px;
  }
}
@media (max-width: 767px) {
  #mixedSlider .MS-controls button {
    font-size: 20px;
  }
}
#mixedSlider .MS-controls .MS-left {
  left: 0px;
}
@media (max-width: 767px) {
  #mixedSlider .MS-controls .MS-left {
    left: -10px;
  }
}
#mixedSlider .MS-controls .MS-right {
  right: 0px;
}
@media (max-width: 767px) {
  #mixedSlider .MS-controls .MS-right {
    right: -10px;
  }
}
/*topics css*/
.topic-con{
    position: relative;
    width:100%;
    /*border:1px solid #eee;*/
    border-radius:2px;
    text-align: center;
    font-size:18px; 
    color:#fff;
    text-transform: uppercase;
}
.mv12{ display: block;
    width: 100%;
    height: auto;
}

.overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color:rgba(0,140,186,.9);
    overflow: hidden;
    width: 100%;
    height: 0;
    transition: .5s ease;
}
.topic-con:hover .overlay {
    height: 100%;
    border-radius:15px 15px 15px 15px;
}
.text-o {
    color: white;
    font-size: 15px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    white-space: nowrap;
}
.back .b-icon img{
    width:55%;
}
.hr-company-box{
    text-align:center;
    border:2px solid #eef1f5;
    background:#fff; 
    padding:20px 10px;
    border-radius:14px !important; 
    margin-bottom:20px; 
    text-decoration:none; 
    min-height:250px;
    position:relative;
}
    
.hr-company-box:hover{
    border-color:#fff; 
    box-shadow:0 0 20px rgb(0,0,0,.3); 
    transition:.3s all;
    text-decoration:none;
} 
.hr-company-box > div:hover {
    text-decoration:none;
}  
.hr-company-box-center{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
}                     
.hr-com-icon{ 
    text-align:center; 
    text-decoration:none;  
    vertical-align:middle; 
    padding:10px 0;
}
.hr-com-icon img{
    text-align:center; 
    margin:0 auto; 
    max-width:80px;  
    max-height:80px; 
}
.hr-com-name{
    color:#00a0e3; 
    padding-top:10px;
    text-decoration:none;
    font-size:16px;
} 
.hr-com-name:hover{
    text-decoration:none;
}                                   
.hr-com-field{
    padding-top:2px; 
    font-weight:bold;
    font-size:14px; 
    color:#080808;
}
.hr-com-jobs{
    font-size:13px; 
    color:#080808; 
    padding:10px 0 10px; 
    margin-top:10px; 
    border-top:1px solid #eef1f5;
}            
.pad-top-10{
    padding-top:10px;
}
.minus-15-pad{
    padding-left:0px !important; 
    padding-right:0px !important;
}
@media only screen and (max-width: 992px){
    .b-padding{
        padding-top: 0px;
    }
    .f-box{
        padding-bottom: 100px;
    }
    .c-padding{
        padding: 0px;
    }
    .mv1{
        margin-bottom: 15px;  
    }
    .seemore{
        padding: 50px;
    }
    .mv{
        padding: 50px 0 0 0 ;
    }
    .sm-hidden{
       display:none;
    }
    .working-box{
        padding: 00px 0 !important;
        margin: 00px 0 0 0;
    }
}

');

$script = <<< JS
    (function (b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
                function () {
                    (b[l].q = b[l].q || []).push(arguments)
                });
        b[l].l = +new Date;
        e = o.createElement(i);
        r = o.getElementsByTagName(i)[0];
        e.src = '//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', 'UA-XXXXX-X', 'auto');
    ga('send', 'pageview');

    $('#mixedSlider').multislider({
        duration: 750,
        interval: 3000
    });
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/candidates-list/modernizr-2.8.3-respond-1.4.2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/multislider.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
