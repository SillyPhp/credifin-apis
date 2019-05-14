<?php

use yii\helpers\Url;

$this->registerCssFile('@eyAssets/css/blog-main.css');
?>

    <section class="header">
        <img src="<?= Url::to('@eyAssets/images/pages/blog/blog-cover.png ') ?>" alt=""/>
    </section>
    <section class="background-mirror blog-section-0">
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="heading-style"><?= Yii::t('frontend', 'Featured Blog'); ?></h2>
                    </div>
                    <div class="col-md-3">
                        <!-- Controls -->
                        <div class="controls pull-right hidden-xs">
                            <a class="left fa fa-chevron-left bttn-left" href="#carousel-example"
                               data-slide="prev"></a>
                            <a class="right fa fa-chevron-right bttn-right" href="#carousel-example"
                               data-slide="next"></a>
                        </div>
                    </div>
                </div>
                <div id="carousel-example" class="carousel slide hidden-xs" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <?php
                        $rows = ceil(count($posts) / 4);
                        $next = 0;
                        for ($i = 0; $i < $rows; $i++) {
                            ?>
                            <div class="item <?php echo $next == 0 ? 'active' : '' ?>">
                                <div class="row">
                                    <?php
                                    for ($j = 0; $j < 4; $j++) {
                                        $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $posts[$next]['featured_image_location'] . DIRECTORY_SEPARATOR . $posts[$next]['featured_image'];
                                        $image = Yii::$app->params->upload_directories->posts->featured_image . $posts[$next]['featured_image_location'] . DIRECTORY_SEPARATOR . $posts[$next]['featured_image'];
                                        if (!file_exists($image_path)) {
                                            $image = '//placehold.it/570x390';
                                        }
                                        ?>
                                        <div class="col-sm-3">
                                            <a href="<?= Url::to('/blog/' . $posts[$next]['slug']); ?>">
                                                <div class="col-item">
                                                    <div class="photo">
                                                        <img src="<?= $image; ?>" class=""
                                                             alt="<?= $posts[$next]['featured_image_alt']; ?>"
                                                             title="<?= $posts[$next]['featured_image_title']; ?>"/>
                                                    </div>
                                                    <div class="info">
                                                        <div class="row">
                                                            <div class="price col-md-12">
                                                                <h5> <?= $posts[$next]['title']; ?></h5>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix">
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <?php
                                        $next++;
                                    }
                                    ?>
                                </div>

                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>


        </div>
    </section>
<!--    <section class="blog-section-1">-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-md-12">-->
<!--                    <h2 class="heading-style">--><?//= Yii::t('frontend', 'Travel Blogs'); ?><!--</h2>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="section-1-shadow">-->
<!--                <div class="row padd">-->
<!--                    <div class="col-md-6 col-sm-12 no-padd">-->
<!--                        <div class="blog-box col-sm-12 no-padd">-->
<!--                            <div class="col-md-6 col-sm-4 no-padd">-->
<!--                                <div class="blog-img">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/blog/p2.png') ?><!--">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-md-6 col-sm-8 no-padd">-->
<!--                                <div class="blog-discription">-->
<!--                                    <div class="blog-title"><a href="">Fashion Model Shoot</a></div>-->
<!--                                    <div class="blog-txt">Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum-->
<!--                                        dolor sit amet,-->
<!--                                        consectetur Nulla fringilla purus at leo dignissim congue.-->
<!--                                    </div>-->
<!--                                    <div class="read-more"><a href="">Read More</a></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6 col-sm-12 no-padd">-->
<!--                        <div class="blog-box col-sm-12 no-padd">-->
<!--                            <div class="col-md-6 col-sm-4 no-padd">-->
<!--                                <div class="blog-img"><img src="--><?//= Url::to('@eyAssets/images/pages/blog/p3.png') ?><!--">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-md-6 col-sm-8 no-padd">-->
<!--                                <div class="blog-discription">-->
<!--                                    <div class="blog-title"><a href="">Fashion Model Shoot Lorem ipsum dosectetur</a>-->
<!--                                    </div>-->
<!--                                    <div class="blog-txt">Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum-->
<!--                                        dolor sit amet,-->
<!--                                        consectetur Nulla fringilla purus at leo dignissim congue.-->
<!--                                    </div>-->
<!--                                    <div class="read-more"><a href="">Read More</a></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="row blog-row-2 padd">-->
<!--                    <div class="col-md-6 col-sm-12 no-padd">-->
<!--                        <div class="blog-box col-sm-12 no-padd">-->
<!--                            <div class="col-md-6 col-sm-8 no-padd">-->
<!--                                <div class="blog-discription2">-->
<!--                                    <div class="blog-title"><a href="">Fashion model shoot</a></div>-->
<!--                                    <div class="blog-txt">Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum-->
<!--                                        dolor sit amet,-->
<!--                                        consectetur Nulla fringilla purus at leo dignissim congue.-->
<!--                                    </div>-->
<!--                                    <div class="read-more"><a href="">Read More</a></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-md-6 col-sm-4 no-padd">-->
<!--                                <div class="blog-img-right ">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/blog/p3.png') ?><!--">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="col-md-6 col-sm-12 no-padd">-->
<!--                        <div class="blog-box col-sm-12 no-padd">-->
<!--                            <div class="col-md-6 col-sm-8 no-padd">-->
<!--                                <div class="blog-discription2">-->
<!--                                    <div class="blog-title"><a href="">Fashion model shoot Lorem ipsum dosectetur-->
<!--                                            adipisicing elit</a></div>-->
<!--                                    <div class="blog-txt">Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum-->
<!--                                        dolor sit amet,-->
<!--                                        consectetur Nulla fringilla purus at leo dignissim congue.-->
<!--                                    </div>-->
<!--                                    <div class="read-more"><a href="">Read More</a></div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-md-6 col-sm-4 no-padd">-->
<!--                                <div class="blog-img-right arrow-right">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/blog/p2.png') ?><!--">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
    <section class="blog-section-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="heading-style"><?= Yii::t('frontend', 'Other Blogs'); ?></h2>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="whats-block-heading">What's New</div>
                    </div>
                </div>
                <div id="whats-new" class="row">

                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="whats-popular-heading">What's Popular</div>
                    </div>
                </div>
                <div class="row">
                    <div id="popular-blog" class="col-md-12 col-sm-12">

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="trending-posts">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="trending-heading">Trending Posts</div>
                        </div>
                    </div>
                    <div id="trending-post">

                    </div>
                </div>
<!--                <div class="row">-->
<!--                    <div class="col-md-12">-->
<!--                        <div class="popular-heading">Popular Categories</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="tg-widget tg-widgetcategories">-->
<!--                    <div class="tg-widgetcontent">-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-12">-->
<!--                                <ul>-->
<!--                                    <li><a href="javascript:void(0);"><span>Funny</span>28245</a></li>-->
<!--                                    <li><a href="javascript:void(0);"><span>Sports</span>4856</a></li>-->
<!--                                    <li><a href="javascript:void(0);"><span>DIY</span>8654</a></li>-->
<!--                                    <li><a href="javascript:void(0);"><span>Fashion</span>6247</a></li>-->
<!--                                    <li><a href="javascript:void(0);"><span>Travel</span>888654</a></li>-->
<!--                                    <li><a href="javascript:void(0);"><span>Lifestyle</span>873144</a></li>-->
<!--                                    <li><a href="javascript:void(0);"><span>Gifs</span>873144</a></li>-->
<!--                                    <li><a href="javascript:void(0);"><span>Video</span>18465</a></li>-->
<!--                                    <li><a href="javascript:void(0);"><span>Gadgets</span>3148</a></li>-->
<!--                                    <li><a href="javascript:void(0);"><span>Audio</span>77531</a></li>-->
<!--                                    <li><a href="javascript:void(0);"><span>All</span>9247</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/blogs/whats-new');
echo $this->render('/widgets/blogs/popular-blogs');
echo $this->render('/widgets/blogs/trending-posts');
$this->registerCss('
.bttn-left, .bttn-right{
    background:transparent;
    color:#00a0e3;
}
 /*blog-section-0-css*/
.blog-section-0{
    padding:10px 0 30px 0;
}
 /*blog-section-0-ends*/
 
/*--------------------------------------------------*/
/*blog-section-2-css*/
.blog-section-2{
    padding:0px 0 30px 0;
}
.whats-block-heading, .popular-heading, .trending-heading{
    position:relative;
    text-align:right;
    text-transform: uppercase;
    padding: 0px 25px 2px 0px;
    font-weight: bold;
}
.whats-block-heading:before{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 136px 0px 0px;
    top: 11px;
    left: 5px;
}
.whats-block-heading:after, .popular-heading:after, .trending-heading:after{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 18px 0px 0px;
    top: 11px;
    right: 5px;
}
.whats-popular-heading{
   position:relative;
    text-align:right;
    text-transform: uppercase;
    padding: 0px 25px 2px 0px;
    font-weight: bold; 
}
.whats-popular-heading:before{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 390px 0px 0px;
    top: 11px;
    left: 5px;
}
.whats-popular-heading:after{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 18px 0px 0px;
    top: 12px;
    right: 5px;
}
.trending-heading:before{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 107px 0px 0px;
    top: 11px;
    left: 5px;
}
.popular-heading:before{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 73px 0px 0px;
    top: 11px;
    left: 5px;
}
.wp-box-des{
    padding-top:15px;
    font-size:13px;
}
.button {
  display: inline-block;
  background-color: #00a0e3;
  border-radius: 5px;
  border:none;
  color: #FFFFFF;
  text-align: center;
  font-size: 13px;
  padding: 8px 15px;
//  width: 200px;
  transition: all 0.3s;
  cursor: pointer;
  margin-top:15px;
}
.button span {
  color:#fff;
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.3s;
}
.button span:after {
  content: "\00bb";
  position: absolute;
  opacity: 0;
  top: 0;
  color:#fff;
  right: -20px;
  transition: 0.5s;
}
.button:hover span {
  padding-right: 20px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}

.tg-widgetcategories .tg-widgetcontent ul{
    text-align: right;
}
.tg-widgetcategories .tg-widgetcontent ul li{
    position:relative;
    padding:8px 0px; 
}
.tg-widgetcategories .tg-widgetcontent ul li a{
    width: 100%;
    position: relative;
    display:block;
    transition:.3s all;
}
.tg-widgetcategories .tg-widgetcontent ul li a:hover{
    padding: 0 0 0 15px;
      transition:.3s all;
}
.tg-widgetcategories .tg-widgetcontent ul li a:before{
    top: 0;
    left: 0;
    opacity: 0;
    color: #333;
    content: "\f105";
    position: absolute;
    font-size: inherit;
    visibility: hidden;
    line-height:inherit;
    font-family: "FontAwesome";   
}
.tg-widgetcategories .tg-widgetcontent ul li a:hover:before{
    opacity: 1;
    visibility: visible;
}
.tg-widgetcontent ul li + li {
    border-top: 1px solid #e6e6e6;
}
.tg-widgetcontent ul li a span {
    float: left;
}
/*blog-section-2-ends*/

@media only screen and (max-width: 1200px) and (min-width: 992px){
    .blog-img img{
        height:220px;
        object-fit:cover;
    }
    .whats-block-heading:before{
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 87px 0px 0px;
        top: 11px;
        left: 5px;
    }
    .whats-popular-heading:before {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 290px 0px 0px;
        top: 11px;
        left: 5px
    }
}
@media only screen and (max-width: 991px){
    .blog-box{
        margin-top:15px;
        box-shadow:0 0 10px rgba(0,0,0,.5);
    }
    .blog-discription{
        height:200px;
    }
    .blog-img img{
        height:210px;
        object-fit:cover;
    }
    .whats-block-heading:before {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 521px 0px 0px;
        top: 11px;
        left: 5px;
    }
    .whats-block-heading {
        position: relative;
        text-align: right;
        text-transform: uppercase;
        padding: 0px 70px 2px 0px;
        font-weight: bold;
    }
    .whats-block-heading:after {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 58px 0px 0px;
        top: 11px;
        right: 5px;
    }
    .whats-popular-heading {
        position: relative;
        text-align: right;
        text-transform: uppercase;
        padding: 0px 70px 2px 0px;
        font-weight: bold;  
    }
     .whats-popular-heading:before {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 290px 0px 0px;
        top: 11px;
        left: 5px
    }
    .whats-popular-heading:before {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 490px 0px 0px;
        top: 11px;
        left: 5px;
    }
    .whats-popular-heading:after {
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 58px 0px 0px;
        top: 12px;
        right: 5px;
    }
    .section-1-shadow {
        box-shadow: none;
    }
 }
  /*blog-section-1-css*/   
//.blog-section-1{
//    padding:0px 0 70px 0;
//    background: url(' . Url::to("@eyAssets/images/pages/blog/sec-1-bg.png") . ');
//    background-size:cover;
//    background-attachment: fixed;
//    margin:20px 0;
//} 
//.section-1-shadow{
//    box-shadow:0 0 20px rgba(0,0,0,.5);
//}
//.no-padd{
//    padding-left:0px !important;
//    padding-right:0px !important;
//}
//.blog-img{
//    border-left:5px solid #00a0e3;
//}
//.blog-img-right{
//    border-right:5px solid #00a0e3;
//}
//.blog-img img, .blog-img-right img{ 
//    height:210px;
//    width:290px;
//    object-fit:cover
//}
//.blog-discription{
//    padding:5px 15px;
//    position:relative;
//    min-height:210px; 
//    background:#fff;
//}
//.blog-discription2{
//    padding:5px 15px;
//    position:relative;
//    min-height:210px; 
//    background:#fff;
//}
//.blog-title a{
//    color:#00a0e3; 
//    font-weight:bold;
//    text-transform:capitalize;
//    position:relative;
//    padding-top:5px;
//}
//.blog-discription:before{
//    content: "";
//    left: -20px;
//    top: 25px;
//    position: absolute;
//    border-top: 15px solid transparent;
//    border-right: 20px solid #fff;
//    border-bottom: 15px solid transparent;
//}
//.blog-discription2:before{
//    content: "";
//    right: -20px;
//    top: 25px;
//    position: absolute;
//    border-top: 15px solid transparent;
//    border-left: 20px solid #fff;
//    border-bottom: 15px solid transparent;
//    z-index:9;
//}
//.blog-txt{
//    padding-top:15px;
//    font-size:13px;
//    line-height:17px;
//    position:relative;
//    text-align:justify;
//}
//.read-more{
//   position:absolute;
//   bottom:11px;
//}
//.read-more a{
//    bottom:0px;
//    color:#00a0e3;
//}
//.padd{
//    padding-left:10px;
//    padding-right:10px;
//}
/*blog-section-1-ends*/
');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
