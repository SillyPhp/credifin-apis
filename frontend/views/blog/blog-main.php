<?php

use yii\helpers\Url;

$this->registerCssFile('@eyAssets/css/blog-main.css');
?>

    <section class="header">
        <img src="<?= Url::to('@eyAssets/images/pages/blog/blog-cover.png ') ?>" alt=""/>
    </section>
    <section class="background-mirror blog-section-0">
        <div class="container">

            <!--        <div class="row">
                    <div class="col-md-12 no-padd">
                        <div id="blog-slider" class="owl-carousel-4col" data-dots="false" data-nav="true">
        <?php
            foreach ($posts as $post) {
                $image_path = Yii::$app->params->upload_directories->posts->featured_image_path . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                $image = Yii::$app->params->upload_directories->posts->featured_image . $post['featured_image_location'] . DIRECTORY_SEPARATOR . $post['featured_image'];
                if (!file_exists($image_path)) {
                    $image = '//placehold.it/570x390';
                }
                ?>
                                    <div class="item owl-item">
                                        <div class="single-news-content single-item-hoverly first-column">
                                            <figure class="img-box">
                                                <img src="<?= $image; ?>" width="100%" height="212px" alt="<?= $post['featured_image_alt']; ?>" title="<?= $post['featured_image_title']; ?>"/>
                                                <div class="overlay">
                                                    <a href="<?= Url::to('/blog/' . $post['slug']); ?>" class="btn-one btn-bg"><?= Yii::t('frontend', 'Read More'); ?></a>
                                                </div>
                                            </figure>
                                            <ul class="meta in-block">
                                                <li><?= date('d M, Y', strtotime($post['created_on'])); ?></li>
                                            </ul>
                                            <div class="lower-content">
                                                <div class="title"><h4><a href="<?= Url::to('/blog/' . $post['slug']); ?>"><?= $post['title']; ?></a></h4></div>
                                                <div class="text">
                                                    <p>
            <?php
                $post['slug'] = strip_tags($post['excerpt']);
                if (strlen($post['excerpt']) > 55) {
                    echo substr($post['excerpt'], 0, 55) . ' .<a href="' . Url::to('/blog/' . $post['title']) . '"><br><div class="read-more">Read More</div></a>';
                } else {
                    echo $post['excerpt'] . ' ... ';
                    ?>
                                                                <a href="<?= Url::to('/blog/' . $post['slug']); ?>" style="color:red;padding-left:5px;font-size:16px;"><?= Yii::t('frontend', 'Read More'); ?></a>
                <?php
                }
                ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
            <?php
            }
            ?>
                        </div>
                    </div>
                </div>-->


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
    <section class="blog-section-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="heading-style"><?= Yii::t('frontend', 'Travel Blogs'); ?></h2>
                </div>
            </div>
            <div class="section-1-shadow">
                <div class="row padd">
                    <div class="col-md-6 col-sm-12 no-padd">
                        <div class="blog-box col-sm-12 no-padd">
                            <div class="col-md-6 col-sm-4 no-padd">
                                <div class="blog-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/p2.png') ?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-8 no-padd">
                                <div class="blog-discription">
                                    <div class="blog-title"><a href="">Fashion Model Shoot</a></div>
                                    <div class="blog-txt">Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum
                                        dolor sit amet,
                                        consectetur Nulla fringilla purus at leo dignissim congue.
                                    </div>
                                    <div class="read-more"><a href="">Read More</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 no-padd">
                        <div class="blog-box col-sm-12 no-padd">
                            <div class="col-md-6 col-sm-4 no-padd">
                                <div class="blog-img"><img src="<?= Url::to('@eyAssets/images/pages/blog/p3.png') ?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-8 no-padd">
                                <div class="blog-discription">
                                    <div class="blog-title"><a href="">Fashion Model Shoot Lorem ipsum dosectetur</a>
                                    </div>
                                    <div class="blog-txt">Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum
                                        dolor sit amet,
                                        consectetur Nulla fringilla purus at leo dignissim congue.
                                    </div>
                                    <div class="read-more"><a href="">Read More</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row blog-row-2 padd">
                    <div class="col-md-6 col-sm-12 no-padd">
                        <div class="blog-box col-sm-12 no-padd">
                            <div class="col-md-6 col-sm-8 no-padd">
                                <div class="blog-discription2">
                                    <div class="blog-title"><a href="">Fashion model shoot</a></div>
                                    <div class="blog-txt">Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum
                                        dolor sit amet,
                                        consectetur Nulla fringilla purus at leo dignissim congue.
                                    </div>
                                    <div class="read-more"><a href="">Read More</a></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-4 no-padd">
                                <div class="blog-img-right ">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/p3.png') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 no-padd">
                        <div class="blog-box col-sm-12 no-padd">
                            <div class="col-md-6 col-sm-8 no-padd">
                                <div class="blog-discription2">
                                    <div class="blog-title"><a href="">Fashion model shoot Lorem ipsum dosectetur
                                            adipisicing elit</a></div>
                                    <div class="blog-txt">Lorem ipsum dosectetur adipisicing elit, sed do.Lorem ipsum
                                        dolor sit amet,
                                        consectetur Nulla fringilla purus at leo dignissim congue.
                                    </div>
                                    <div class="read-more"><a href="">Read More</a></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-4 no-padd">
                                <div class="blog-img-right arrow-right">
                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/p2.png') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                <div class="row">
                    <div class="col-md-12 col-sm-4">
                        <div class="whats-new-box">
                            <div class="wn-box-icon">
                                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>"></a>
                                <div class="middle">
                                    <div class=""><a href="" class="wn-overlay-text">Read More</a></div>
                                </div>
                            </div>
                            <div class="wn-box-details">
                                <a href="">
                                    <div class="wn-box-cat">Health</div>
                                    <div class="wn-box-title">Top 10 Relaxing Position For Adult Womens</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-4">
                        <div class="whats-new-box">
                            <div class="wn-box-icon">
                                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/blog/img-21.jpg') ?>"></a>
                                <div class="middle">
                                    <div class=""><a href="" class="wn-overlay-text">Read More</a></div>
                                </div>
                            </div>
                            <div class="wn-box-details">
                                <a href="">
                                    <div class="wn-box-cat">Health</div>
                                    <div class="wn-box-title">Top 10 Relaxing Position For Adult Womens</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-4">
                        <div class="whats-new-box">
                            <div class="wn-box-icon">
                                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>"></a>
                                <div class="middle">
                                    <div class=""><a href="" class="wn-overlay-text">Read More</a></div>
                                </div>
                            </div>
                            <div class="wn-box-details">
                                <a href="">
                                    <div class="wn-box-cat">Health</div>
                                    <div class="wn-box-title">Top 10 Relaxing Position For Adult Womens</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="whats-popular-heading">What's Popular</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="what-popular-box">
                            <div class="wp-box-icon">
                                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>"></a>
                                <div class="middle">
                                    <a href="" class="">
                                        <img src="<?= Url::to('@eyAssets/images/pages/blog/play-button.png') ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="wn-box-details">
                                <a href="">
                                    <div class="wn-box-cat">Video</div>
                                    <div class="wn-box-title">Top 10 Relaxing Position For Adult Womens</div>
                                </a>
                                <div class="wp-box-des">Consectetur adipisicing elit sed do eiusmod tempor incididunt ut
                                    labore
                                    et dolore magna aliqua enim ad minim veniam qui.
                                </div>
                                <div class=""><a href="" class="button"><span>View Post</span></a></div>
                            </div>
                        </div>
                        <div class="what-popular-box">
                            <div class="wp-box-icon">
                                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/blog/img-27.jpg') ?>"></a>
                                <div class="middle">
                                    <a href="" class="">
                                        <img src="<?= Url::to('@eyAssets/images/pages/blog/audio.png') ?>">
                                    </a>
                                </div>
                            </div>
                            <div class="wn-box-details">
                                <a href="">
                                    <div class="wn-box-cat">Audio</div>
                                    <div class="wn-box-title">Top 10 Relaxing Position For Adult Womens</div>
                                </a>
                                <div class="wp-box-des">Consectetur adipisicing elit sed do eiusmod tempor incididunt ut
                                    labore
                                    et dolore magna aliqua enim ad minim veniam qui.
                                </div>
                                <div class=""><a href="" class="button"><span>View Post</span></a></div>
                            </div>
                        </div>
                        <div class="what-popular-box">
                            <div class="wp-box-icon">
                                <a href=""><img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>"></a>
                                <div class="middle">
                                    <div class=""><a href="" class="wn-overlay-text">Read More</a></div>
                                </div>
                            </div>
                            <div class="wn-box-details">
                                <a href="">
                                    <div class="wn-box-cat">Health</div>
                                    <div class="wn-box-title">Top 10 Relaxing Position For Adult Womens</div>
                                </a>
                                <div class="wp-box-des">Consectetur adipisicing elit sed do eiusmod tempor incididunt ut
                                    labore
                                    et dolore magna aliqua enim ad minim veniam qui.
                                </div>
                                <div class=""><a href="" class="button"><span>View Post</span></a></div>
                            </div>
                        </div>
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
                    <div class="tp-box">
                        <div class="row">
                            <a href="">
                                <div class="col-md-5">
                                    <div class="tp-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>">
                                    </div>
                                </div>
                                <div class="col-md-7 no-padd">
                                    <div class="tp-heading">Fashion Model Shoot....</div>
                                    <div class="tp-date">17 April 2012</div>
                                    <!--<div class="tp-heading">Fashion Model Shoot....</div>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="tp-box">
                        <div class="row">
                            <a href="">
                                <div class="col-md-5">
                                    <div class="tp-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>">
                                    </div>
                                </div>
                                <div class="col-md-7 no-padd">
                                    <div class="tp-heading">Fashion Model Shoot....</div>
                                    <div class="tp-date">17 April 2012</div>
                                    <!--<div class="tp-heading">Fashion Model Shoot....</div>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="tp-box">
                        <div class="row">
                            <a href="">
                                <div class="col-md-5">
                                    <div class="tp-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>">
                                    </div>
                                </div>
                                <div class="col-md-7 no-padd">
                                    <div class="tp-heading">Fashion Model Shoot....</div>
                                    <div class="tp-date">17 April 2012</div>
                                    <!--<div class="tp-heading">Fashion Model Shoot....</div>-->
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="tp-box">
                        <div class="row">
                            <a href="">
                                <div class="col-md-5">
                                    <div class="tp-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>">
                                    </div>
                                </div>
                                <div class="col-md-7 no-padd">
                                    <div class="tp-heading">Fashion Model Shoot....</div>
                                    <div class="tp-date">17 April 2012</div>
                                    <!--<div class="tp-heading">Fashion Model Shoot....</div>-->
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="popular-heading">Popular Categories</div>
                    </div>
                </div>
                <div class="tg-widget tg-widgetcategories">
                    <div class="tg-widgetcontent">
                        <div class="row">
                            <div class="col-md-12">
                                <ul>
                                    <li><a href="javascript:void(0);"><span>Funny</span>28245</a></li>
                                    <li><a href="javascript:void(0);"><span>Sports</span>4856</a></li>
                                    <li><a href="javascript:void(0);"><span>DIY</span>8654</a></li>
                                    <li><a href="javascript:void(0);"><span>Fashion</span>6247</a></li>
                                    <li><a href="javascript:void(0);"><span>Travel</span>888654</a></li>
                                    <li><a href="javascript:void(0);"><span>Lifestyle</span>873144</a></li>
                                    <li><a href="javascript:void(0);"><span>Gifs</span>873144</a></li>
                                    <li><a href="javascript:void(0);"><span>Video</span>18465</a></li>
                                    <li><a href="javascript:void(0);"><span>Gadgets</span>3148</a></li>
                                    <li><a href="javascript:void(0);"><span>Audio</span>77531</a></li>
                                    <li><a href="javascript:void(0);"><span>All</span>9247</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.bttn-left, .bttn-right{
    background:transparent;
    color:#00a0e3;
}
 /*blog-section-0-css*/
.blog-section-0{
    padding:10px 0 30px 0;
}
/*includes blog_1.css*/
 /*blog-section-0-ends*/
 
 /*blog-section-1-css*/   
.blog-section-1{
    padding:0px 0 70px 0;
    background: url(' . Url::to("@eyAssets/images/pages/blog/sec-1-bg.png") . ');
    background-size:cover;
    background-attachment: fixed;
    margin:20px 0;
} 
.section-1-shadow{
    box-shadow:0 0 20px rgba(0,0,0,.5);
}
.no-padd{
    padding-left:0px !important;
    padding-right:0px !important;
}
.blog-img{
//    border-left:5px solid #00a0e3;
}
.blog-img-right{
//    border-right:5px solid #00a0e3;
}
.blog-img img, .blog-img-right img{ 
    height:210px;
    width:290px;
    object-fit:cover
}
.blog-discription{
    padding:5px 15px;
    position:relative;
    min-height:210px; 
    background:#fff;
}
.blog-discription2{
    padding:5px 15px;
    position:relative;
    min-height:210px; 
    background:#fff;
}
.blog-title a{
    color:#00a0e3; 
    font-weight:bold;
    text-transform:capitalize;
    position:relative;
    padding-top:5px;
}

.blog-discription:before{
    content: "";
    left: -20px;
    top: 25px;
    position: absolute;
    border-top: 15px solid transparent;
    border-right: 20px solid #fff;
    border-bottom: 15px solid transparent;
}
.blog-discription2:before{
    content: "";
    right: -20px;
    top: 25px;
    position: absolute;
    border-top: 15px solid transparent;
    border-left: 20px solid #fff;
    border-bottom: 15px solid transparent;
    z-index:9;
}
.blog-txt{
    padding-top:15px;
    font-size:13px;
    line-height:17px;
    position:relative;
    text-align:justify;
}
.read-more{
   position:absolute;
   bottom:11px;
}
.read-more a{
    bottom:0px;
    color:#00a0e3;
}
.padd{
    padding-left:10px;
    padding-right:10px;
}
/*blog-section-1-ends*/
/*--------------------------------------------------*/
/*blog-section-2-css*/
.blog-section-2{
    padding:0px 0 30px 0;
}
.whats-new-box{
    border-radius:5px;
    margin-bottom:20px;
}
.wn-box-icon{
    max-width:255px;
    height:100%;
    overflow: hidden;
    border-radius:5px 5px 0 0; 
    position:relative;
}
.wp-box-icon{
    width:100%;
    heigth:100%;
    overflow:hidden;
     border-radius:5px 5px 0 0; 
    position:relative;   
}
.tp-icon{
    width:100%;
    heigth:100%;
    overflow:hidden;
    border-radius:5px; 
    position:relative; 
}
.tp-icon img{
    border-radius:5px; 
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;  
    opacity: 1;
    display: block;
    width: 100%;
    height: auto;
}
//.tp-box:hover{
//     box-shadow:0 0 10px rgba(0,0,0,.1);
//}
.tp-box:hover .tp-icon img{
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 0.3;
}
.tp-heading{
    font-weight:bold;
}
.tp-box{
    margin-bottom:20px;
    border-radius:5px;
}
.wn-box-icon img, .wp-box-icon img{
    border-radius:5px 5px 0 0; 
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

.what-popular-box:hover, .whats-new-box:hover{
    box-shadow:0 0 15px rgba(73, 72, 72, 0.28);
}
.what-popular-box:hover .wp-box-icon img, .whats-new-box:hover .wn-box-icon img{
     -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1; 
}
.what-popular-box{
    margin-bottom:20px;
    border-radius:5px;
}
.what-popular-box:hover > .wp-box-icon > .middle, .whats-new-box:hover > .wn-box-icon > .middle{
    opacity:1 !important;
}
.what-popular-box:hover > .wp-box-icon > .middle > a > img, .whats-new-box:hover >.wn-box-icon > .middle > a > img{
    opacity:1 !important;
}
.wn-box-title{
    font-weight: bold;
}
.wn-box-details{
    border-top:none;
    padding: 5px 10px 10px 8px;
    border: 1px solid rgba(230, 230, 230, .3);
    border-radius:0 0 5px 5px;
}
.wn-box-cat{
   font-size:14px;
   color: #9e9e9e;
}
a.wn-overlay-text {
  background-color: #00a0e3;
  color: white;
  font-size: 12px;
  padding: 6px 12px;
  border-radius:5px;
}
.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
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
');

$script = <<<JS

JS;

$this->registerJs($script);
