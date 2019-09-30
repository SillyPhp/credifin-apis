<?php
$this->params['header_dark'] = true;
$this->title = Yii::t('frontend', 'Learning Corner');

use yii\helpers\Url;

?>
    <section>
        <div class="container headsec">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="newlogoset">
                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/learningc.png'); ?>" align="right"
                             class="responsive"/>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 mt-80 topp-pad">
                    <div class="jumbo-heading">BOOST YOUR SKILLS</div>
                    <div class="jumbo-subheading"> Learn Something <span class="jumbo-heading">New Everyday</span></div>
                    <div class="search-box1">
                        <form action="<?= Url::to('/learning/search-video') ?>">
                            <input type="text" placeholder="Search" name="keyword">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="empty"></div>


<?php if (!empty($categories)) { ?>
    <div class="container ">
        <div class="cat-padding">
            <div class="row col-md-6 col-xs-4">
                <div class="heading-style col-md-6 col-sm-6">Category</div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="type-1">
                    <div>
                        <a href="learning/categories" class="btn btn-3">
                            <span class="txt-cate">View all</span>
                            <span class="round"><i class="fas fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="popular-cate">
                            <?php
                            foreach ($categories as $cat) {
                                ?>
                                <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                                    <a href="/learning/videos/category/<?= $cat['slug']; ?>">
                                        <div class="newset">
                                            <div class="imag">
                                                <img src="<?= $cat['icon']; ?>">
                                            </div>
                                            <div class="txt"><?= $cat['name']; ?></div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

    <!--dynamic categories start-->

    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="empty"></div>

    <!--dynamic categories end-->

<!--    <div class="working-box ">-->
<!--        <div class="container">-->
<!--            <div class="heading-style">How It Works</div>-->
<!--        </div>-->
<!--        <div class="box1 col-md-3 col-sm-6">-->
<!--            <div class="bar-icon"><img src="--><?//= Url::to('@eyAssets/images/pages/learning-corner/bar-icon-1.png'); ?><!--"-->
<!--                                       alt=""/></div>-->
<!--            <div class="w-heading">Want to Learn</div>-->
<!--            <div class="w-text">Do you have something in mind that you want to learn</div>-->
<!--        </div>-->
<!--        <div class="box2 col-md-3 col-sm-6">-->
<!--            <div class="bar-icon"><img src="--><?//= Url::to('@eyAssets/images/pages/learning-corner/bar-icon-2.png'); ?><!--"-->
<!--                                       alt=""/></div>-->
<!--            <div class="w-heading">Don't Know</div>-->
<!--            <div class="w-text">Missing resources from where you can learn</div>-->
<!--        </div>-->
<!--        <div class="box3 col-md-3 col-sm-6">-->
<!--            <div class="bar-icon"><img src="--><?//= Url::to('@eyAssets/images/pages/learning-corner/bar-icon-3.png'); ?><!--"-->
<!--                                       alt=""/></div>-->
<!--            <div class="w-heading">Search Here</div>-->
<!--            <div class="w-text">Search Empower Youth's learning corner.</div>-->
<!--        </div>-->
<!--        <div class="box4 col-md-3 col-sm-6">-->
<!--            <div class="bar-icon"><img src="--><?//= Url::to('@eyAssets/images/pages/learning-corner/bar-icon-4.png'); ?><!--"-->
<!--                                       alt=""/></div>-->
<!--            <div class="w-heading">Start Learning</div>-->
<!--            <div class="w-text">Find resources and start learning at empower youth</div>-->
<!--        </div>-->
<!--    </div>-->

    <div class="clearfix"></div>
    <div class="empty"></div>

<!--    <div class="container ">-->
<!--        <div class="cat-padding">-->
<!--            <div class="mv">-->
<!--                <div class="container">-->
<!--                    <div class="heading-style">Most Popular Topics</div>-->
<!--                    <div class="mt-actions " style="">-->
<!--                        --><?php
//                        foreach ($topics as $topic) {
//                            ?>
<!--                            <div class="col-md-3 col-sm-4">-->
<!--                                <div class="topic-con">-->
<!--                                    <a href="--><?//= Url::to('/learning/videos/videos?slug=' . $topic['slug']) ?><!--">-->
<!--                                        <div class="hr-company-box">-->
<!--                                            <div class="hr-company-box-center">-->
<!--                                                <div class="hr-com-icon">-->
<!--                                                    <img src="--><?//= Url::to('@eyAssets/images/pages/learning-corner/lc_tags.png'); ?><!--"-->
<!--                                                         class="img-responsive ">-->
<!--                                                </div>-->
<!--                                                <div class="hr-com-name">--><?//= $topic['name'] ?><!--</div>-->
<!--                                                <div class="hr-com-field">--><?//= $topic['cnt'] ?><!-- Videos</div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            --><?php
//                        }
//                        ?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

    <div class="clearfix"></div>
    <div class="empty"></div>

<?php if (!empty($popular_videos)) { ?>
    <div class="container">
        <!-- Example row of columns -->
        <div class="row col-md-12">
            <div class="heading-style col-md-6 col-sm-6">Most Popular Videos</div>
        </div>
    </div>
    <div>
        <div class="container">
            <div id="mixedSlider">
                <div class="MS-content lc-items-grids">
                    <?php foreach ($popular_videos as $p) { ?>
                        <div class="item lc-single-item-main">
                            <div class="lc-item-img">
                                <a href="<?= Url::to('learning/video/' . $p['slug']); ?>" class="lc-item-video-link">
                                </a>
                                <div class="lc-item-video-img"
                                     style="background-image: url(<?= Url::to($p['cover_image']); ?>);"></div>
                            </div>
                            <div class="lc-item-desciption">
                                <!--                                <a class="lc-item-user-icon" href="#">-->
                                <!--                                    <img src="https://s.cdpn.io/profiles/user/1531686/80.jpg?1511402852" alt=""-->
                                <!--                                         width="40" height="40">-->
                                <!--                                </a>-->
                                <div class="lc-item-user-detail">
                                    <h3 class="lc-item-video-title">
                                        <a href="<?= Url::to('learning/video/' . $p['slug']); ?>" class="ml-20">
                                            <?= Yii::t('frontend', $p['title']); ?>
                                        </a>
                                    </h3>
                                    <!--                                    <div class="lc-item-user-sub-main">-->
                                    <!--                                        <a class="lc-item-user-sub-detail" href="#">-->
                                    <!--                                            <span>casper392945</span>-->
                                    <!--                                        </a>-->
                                    <!--                                    </div>-->
                                </div>
                                <!--                                <div class="lc-item-video-actions">-->
                                <!--                                    <button class="lc-item-video-menu" aria-expanded="false">-->
                                <!--                                        <i class="fas fa-ellipsis-v"></i>-->
                                <!--                                    </button>-->
                                <!--                                </div>-->
                            </div>
                            <div class="lc-item-video-stats">
                                <!--                                <a class="lc-item-video-stat" href="#">-->
                                <!--                                    <span>-->
                                <!--                                        <i class="fas fa-heart"></i> 5-->
                                <!--                                    </span>-->
                                <!--                                </a>-->
                                <!--                                <a class="lc-item-video-stat" href="#">-->
                                <!--                                    <span>-->
                                <!--                                        <i class="far fa-comments"></i> 0-->
                                <!--                                    </span>-->
                                <!--                                </a>-->
                                <!--                                <a class="lc-item-video-stat" href="#">-->
                                <!--                                    <span>-->
                                <!--                                        <i class="fas fa-eye"></i> 0-->
                                <!--                                    </span>-->
                                <!--                                </a>-->
                                <span class="lc-item-video-stat marg">
                                    <?php
                                    $link = Url::to('learning/video/' . $p['slug'], 'https');
                                    ?>
                                        <a href="<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>"
                                           target="blank">
                                            <span>
                                                <i class="fab fa-facebook-f"></i>
                                            </span>
                                        </a>
                                        <a href="<?= Url::to('https://twitter.com/intent/tweet?text=' . $link); ?>"
                                           target="blank">
                                            <span>
                                                <i class="fab fa-twitter"></i>
                                            </span>
                                        </a>
                                        <a href="<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>"
                                           target="blank">
                                            <span>
                                                <i class="fab fa-linkedin"></i>
                                            </span>
                                        </a>
                                </span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
<!--                <div class="MS-controls">-->
<!--                    <button class="MS-left"><i class="fas fa-angle-left" aria-hidden="true"></i></button>-->
<!--                    <button class="MS-right"><i class="fas fa-angle-right" aria-hidden="true"></i></button>-->
<!--                </div>-->
            </div>
        </div>
    </div>
<?php } ?>
<?php
if (!empty($contributors)) {
    ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="heading-style">Our Collaborators</h2>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($contributors as $contributor) {
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="collaborators-main">
                            <div class="c-detail">
                                <h4 class="title"><?= $contributor['name']; ?></h4>
                                <span class="post">Contributor</span>
                                <ul class="social-icon">

                                    <?php if (!empty($contributor['facebook'])) { ?>
                                        <li><a href="https://www.facebook.com/<?= $contributor['facebook']; ?>"
                                               target="_blank">
                                                <i class="fab fa-facebook"></i></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (!empty($contributor['twitter'])) { ?>
                                        <li><a href="https://www.twitter.com/<?= $contributor['twitter']; ?>"
                                               target="_blank">
                                                <i class="fab fa-twitter"></i></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (!empty($contributor['linkedin'])) { ?>
                                        <li><a href="https://www.linkedin.com/in/<?= $contributor['linkedin']; ?>"
                                               target="_blank">
                                                <i class="fab fa-linkedin"></i></a>
                                        </li>
                                    <?php } ?>
                                    <?php if (!empty($contributor['instagram'])) { ?>
                                        <li><a href="https://www.instagram.com/<?= $contributor['instagram']; ?>"
                                               target="_blank">
                                                <i class="fab fa-instagram"></i></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="thumb">
                                <img src="<?= $contributor['image']; ?>"
                                     alt="">
                            </div>
                        </div>
                    </div>

                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <?php
}
?>

<?php
$this->registerCss('
.newlogoset{
    max-width:500px;
    margin: 0 auto;
}
.newlogoset img{
    width:100%;
    height:100%;
}
.search-box1{
    max-width:500px;
    float:left;
//  border: 1px solid #ccc;
    border-radius: 10px;
    padding: 3px;
    margin: 21px 0 0 0;
    box-shadow: 0px 0px 10px 1px #eee;
}
.search-box1 form{
    margin-bottom:0px;
}
.search-box1 input[type=text] {
    padding: 11px;
    font-size: 15px;
    border:none ;
    border-radius:10px 0 0 10px;
    width: 440px;
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
.head-pic{
    text-align: center;
}
.headsec{
    color:#333;
}
.jumbo-heading{
    font-size: 40px;
    font-weight:bold;
    font-family: lora;
    text-transform: uppercase;
    color:#3b394a; 
}
@media only screen and (max-width:1200px) {
 .search-box1 input[type=text]
    {
    width:300px;
    }
  .jumbo-heading{
    font-size: 35px !important;}
}
@media only screen and (max-width:992px) {
  .jumbo-heading{
    font-size: 25px !important; margin-top: -30px !important;}
}
@media only screen and (max-width:767px) {
    .topp-pad{text-align:center; margin-top:50px !important;}
    .search-box1{max-width: 360px; float: none; margin: auto;}
}
.jumbo-subheading{
    font-size: 25px;
    padding-top: 0px;
    font-family: lobster;
    color:#7ba9da;
}
@media only screen and (max-width:992px) {
  .jumbo-subheading{
    font-size: 20px !important;}
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
.imag{
    text-align: right;
}
.txt {
    position: absolute;
    line-height: 17px;
    bottom: 10px;
    left: -4px;
    font-weight: 400;
    color: #222;
    font-family: roboto;
    text-transform: capitalize;
    background-color: #fff;
    padding: 0px 5px;
}
.b-padding{
    padding-top: 125px;
}
.c-padding{
    padding-top: 125px;
}
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
//.working-box{ 
//    padding: 30px 0 !important;
//}
.box1{
    background: #2d4080; 
    padding: 40px 50px 0px 50px; 
    min-height: 280px;
}
.box2{
    background: #2d4080eb; 
    padding: 40px 50px 0px 50px; 
    min-height: 280px;
}
.box3{
    background:#2d4080d1; 
    padding: 40px 50px 0px 50px; 
    min-height: 280px;
}
.box4{
    background: #2d40808f; 
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
//#mixedSlider {
//    position: relative;
//}
//#mixedSlider .MS-content {
//    white-space: nowrap;
//    overflow: hidden;	
//    margin: 0 45px;
//    margin-left: 35px;
//}
#mixedSlider .MS-content .item {
    display: inline-block;
    width: 31.7%;
    position: relative;
    vertical-align: top;
    height: 100%;
    white-space: normal;
    padding: 5px 10px;
    margin: 15px 8px;
}
@media (max-width: 991px) {
  #mixedSlider .MS-content .item {
    width: 50%;
  }
}
@media (max-width: 767px) {
  #mixedSlider .MS-content .item {
    width: 100%;
    margin:0px;
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
  font-size: 16px;
}
.marg a {
    margin: 0px 2px;
}
#mixedSlider .MS-content .item a:hover {
//  text-shadow: 0 0 1px grey;
  text-decoration: none;
}
//#mixedSlider .MS-controls button {
//  position: absolute;
//  border: none;
//  background-color: transparent;
//  outline: 0;
//  font-size: 50px;
//  top: 95px;
//  color: rgba(0, 0, 0, 0.4);
//  transition: 0.15s linear;
//}
//#mixedSlider .MS-controls button:hover {
//  color: rgba(0, 0, 0, 0.8);
//}
//@media (max-width: 992px) {
//  #mixedSlider .MS-controls button {
//    font-size: 30px;
//  }
//}
//@media (max-width: 767px) {
//  #mixedSlider .MS-controls button {
//    font-size: 20px;
//  }
//}
//#mixedSlider .MS-controls .MS-left {
//  left: 0px;
//}
//@media (max-width: 767px) {
//  #mixedSlider .MS-controls .MS-left {
//    left: -10px;
//  }
//}
//#mixedSlider .MS-controls .MS-right {
//  right: 0px;
//}
//@media (max-width: 767px) {
//  #mixedSlider .MS-controls .MS-right {
//    right: -10px;
//  }
//}
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
    margin-bottom: 15px;
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

.txt-cate {
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
/*collaborators css starts*/
.collaborators-main {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start;
    overflow: hidden;
    margin-bottom:20px;
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
    height: 200px;
    width:calc(100% - 200px);
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


/*video slider css starts*/
//.lc-items-grids {
//    display: grid;
//    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
//    -webkit-box-align: start;
//    -webkit-align-items: start;
//    -ms-flex-align: start;
//    align-items: start;
//    justify-items: center;
//    grid-gap: 4rem 3rem;
//    margin-top: 20px;
//}
.lc-single-item-main {
//    display: -webkit-box;
//    display: -webkit-flex;
//    display: -ms-flexbox;
//    display: flex;
//    -webkit-box-orient: vertical;
//    -webkit-box-direction: normal;
//    -webkit-flex-direction: column;
//    -ms-flex-direction: column;
//    flex-direction: column;
//    color: #9ca0b1;
//    position: relative;
//    width: 100%;
//    height: 100%;
    z-index: 1;
}
.lc-item-img{
    position: relative;
    height: 0;
    border-radius: 6px;
    padding-top: 56.25%;
    overflow: hidden;
    background: #444857;
}
.lc-single-item-main .lc-item-video-link {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    border: 0 !important;
    z-index: 1;
}
.lc-item-img .lc-item-video-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-position: center center;
    background-size: cover;
}
.lc-single-item-main .lc-item-desciption {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    margin-top: 1rem;
    -webkit-box-ordinal-group: 4;
    -webkit-order: 3;
    -ms-flex-order: 3;
    order: 3;
}
.lc-single-item-main .lc-item-user-icon {
    display: block;
    margin-right: 0.75rem;
    position: relative;
    z-index: 1;
}
.lc-single-item-main .lc-item-user-icon>img {
    display: block;
    width: 40px;
    height: 40px;
    background: #444857;
    overflow: hidden;
    font: 10px/1 monospace;
    border-radius: 4px;
}
.lc-single-item-main .lc-item-user-detail {
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    margin: 0 1rem 0 0;
}
.lc-single-item-main .lc-item-user-detail, .lc-single-item-main .lc-item-user-detail .lc-item-video-title {
    width: 95%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.lc-single-item-main .lc-item-video-title {
    font-weight: 900;
    font-size: 17px;
    margin: 0 0 0.25rem;
    display: block;
}
.lc-single-item-main .lc-item-video-title a {
    color: white;
}
.lc-single-item-main .lc-item-user-sub-main {
    color: #c0c3d0;
    font: inherit;
    font-size: 14px;
    line-height: 1.2;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
}
.lc-single-item-main .lc-item-user-sub-detail {
    color: inherit;
    display: inline-block;
    position: relative;
    z-index: 1;
    -webkit-transition: 0.2s ease all;
    transition: 0.2s ease all;
}
.lc-single-item-main .lc-item-video-actions {
    position: relative;
}
.lc-item-video-stats {
    padding: 0 0 0 7px;
    height: 45px;
    z-index: 1;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    justify-content: flex-end;
    -webkit-box-align: center;  
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    font-size: 12px;
    overflow: hidden;
}
button.lc-item-video-menu {
    border: 0;
    background: none;
}
.lc-item-video-stats .lc-item-video-stat {
    font: inherit;
    margin-right: 5px;
    background: rgba(0,0,0,0.9);
    border-radius: 4px;
    padding: 2px 5px;
    color: white;
    cursor: pointer;
}
.lc-single-item-main:not(.hide-owner) .lc-item-video-stat {
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    opacity: 0;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
    -webkit-transition-property: opacity, -webkit-transform;
    transition-property: opacity, -webkit-transform;
    transition-property: transform, opacity;
    transition-property: transform, opacity, -webkit-transform;
    -webkit-transition-timing-function: cubic-bezier(1, 0, 0.65, 0.75),linear;
    transition-timing-function: cubic-bezier(1, 0, 0.65, 0.75),linear;
}
.lc-single-item-main:not(.hide-owner) .lc-item-video-stat:nth-child(2) {
    -webkit-transition-delay: 0.05s;
    transition-delay: 0.05s;
}
.lc-single-item-main:not(.hide-owner) .lc-item-video-stat:nth-child(3) {
    -webkit-transition-delay: 0.1s;
    transition-delay: 0.1s;
}
.lc-single-item-main::after {
    position: absolute;
    content: \'\';
    right: 0px;
    bottom: 35px;
    left: 1rem;
    top: 1rem;
    background: #202229;
    border-radius: 10px;
    z-index: -1;
    -webkit-transition: 0.3s ease;
    transition: 0.3s ease;
}
.lc-single-item-main:hover::after, .lc-single-item-main:focus::after, .lc-single-item-main:active::after {
    left: -5px;
    right: -5px;
    top: -5px;
    bottom: 0px;
}
.lc-single-item-main:not(.hide-owner):hover .lc-item-video-stat, .lc-single-item-main:not(.hide-owner):active .lc-item-video-stat, .lc-single-item-main:not(.hide-owner):focus .lc-item-video-stat {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
    -webkit-transition-timing-function: cubic-bezier(0.2, 0.15, 0.1, 1),ease;
    transition-timing-function: cubic-bezier(0.2, 0.15, 0.1, 1),ease;
    -webkit-transition-delay: 0.2s;
    transition-delay: 0.2s;
}
.lc-single-item-main:not(.hide-owner):hover .lc-item-video-stat:nth-child(2), .lc-single-item-main:not(.hide-owner):active .lc-item-video-stat:nth-child(2), .lc-single-item-main:not(.hide-owner):focus .lc-item-video-stat:nth-child(2) {
    -webkit-transition-delay: 0.15s;
    transition-delay: 0.15s;
}
.lc-single-item-main:not(.hide-owner):hover .lc-item-video-stat:nth-child(3), .lc-single-item-main:not(.hide-owner):active .lc-item-video-stat:nth-child(3), .lc-single-item-main:not(.hide-owner):focus .lc-item-video-stat:nth-child(3) {
    -webkit-transition-delay: 0.1s;
    transition-delay: 0.1s;
}
.marg{
	margin-left: 125px;
	margin-bottom: 2px;
	background: none !important;
}
.marg img{
	width: 22px;
}
/*Video slider css ends*/

@media only screen and (max-width: 992px){
    .b-padding{
        padding-top: 0px;
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
    // (function (b, o, i, l, e, r) {
    //     b.GoogleAnalyticsObject = l;
    //     b[l] || (b[l] =
    //             function () {
    //                 (b[l].q = b[l].q || []).push(arguments)
    //             });
    //     b[l].l = +new Date;
    //     e = o.createElement(i);
    //     r = o.getElementsByTagName(i)[0];
    //     e.src = '//www.google-analytics.com/analytics.js';
    //     r.parentNode.insertBefore(e, r)
    // }(window, document, 'script', 'ga'));
    // ga('create', 'UA-XXXXX-X', 'auto');
    // ga('send', 'pageview');
    //
    // $('#mixedSlider').multislider({
    //     duration: 750,
    //     interval: 3000
    // });
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/candidates-list/modernizr-2.8.3-respond-1.4.2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/multislider.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
