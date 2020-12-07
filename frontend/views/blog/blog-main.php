<?php

use yii\helpers\Url;

$this->registerCssFile('@eyAssets/css/blog-main.css');
?>

    <section class="blog-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 set-flex">
                    <div class="blog-txt">
                        <h1>Blogging</h1>
                        <h2>100+ Interesting Blogs & Articles to Read</h2>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 blog-icon col-xs-12">
                    <img src="<?= Url::to('@eyAssets/images/pages/blog/blog-icon.png') ?>"/>
                </div>
            </div>
        </div>
    </section>
    <section class="background-mirror blog-section-0">
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-md-9 col-xs-9">
                        <h2 class="heading-style"><?= Yii::t('frontend', 'Featured Blog'); ?></h2>
                    </div>
                    <div class="col-md-3 col-xs-3">
                        <!-- Controls -->
                        <div class="controls pull-right">
                            <a class="left fas fa-chevron-left bttn-left" href="#carousel-example"
                               data-slide="prev"></a>
                            <a class="right fas fa-chevron-right bttn-right" href="#carousel-example"
                               data-slide="next"></a>
                        </div>
                    </div>
                </div>
                <div id="carousel-example" class="carousel slide" data-ride="carousel">
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
            <div class="row">
                <div class="view-all-articles">
                    <a href="<?= Url::to('/blog/category/articles'); ?>" class="artic">view all</a>
                </div>
            </div>
        </div>
    </section>
    <!--    <section class="blog-section-1">-->
    <!--        <div class="container">-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-12">-->
    <!--                    <h2 class="heading-style">--?//= Yii::t('frontend', 'Travel Blogs'); ?><!--</h2>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="section-1-shadow">-->
    <!--                <div class="row padd">-->
    <!--                    <div class="col-md-6 col-sm-12 no-padd">-->
    <!--                        <div class="blog-box col-sm-12 no-padd">-->
    <!--                            <div class="col-md-6 col-sm-4 no-padd">-->
    <!--                                <div class="blog-img">-->
    <!--                                    <img src="--?//= Url::to('@eyAssets/images/pages/blog/p2.png') ?><!--">-->
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
    <!--                                <div class="blog-img"><img src="--?//= Url::to('@eyAssets/images/pages/blog/p3.png') ?><!--">-->
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
    <!--                                    <img src="--?//= Url::to('@eyAssets/images/pages/blog/p3.png') ?><!--">-->
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
    <!--                                    <img src="--?//= Url::to('@eyAssets/images/pages/blog/p2.png') ?><!--">-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <!--    <section class="bg-black">-->
    <!--        <div class="container">-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-6 col-xs-4">-->
    <!--                    <hr style="color: #ff704d;width: 50px;margin-left: 5px; border-top:3px solid #ff704d;margin-bottom: 0px;"/>-->
    <!--                    <h3 style="font-family:lobster;font-size:28pt;color:#FFF;margin-top:3px;">--><? //= Yii::t('frontend', 'Quiz'); ?><!--</h3>-->
    <!--                </div>-->
    <!--                <div class="col-md-6 col-sm-6">-->
    <!--                    <div class="type-1">-->
    <!--                        <div>-->
    <!--                            <a href="--><? //= Url::to('/site/all-quiz'); ?><!--" class="btn btn-3">-->
    <!--                                <span class="txt">--><? //= Yii::t('frontend', 'View all Quizzes'); ?><!--</span>-->
    <!--                                <span class="round"><i class="fas fa-chevron-right"></i></span>-->
    <!--                            </a>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="row">-->
    <!--                <div class="col-md-4">-->
    <!--                    <div class="q-box">-->
    <!--                        <a title="world-cup-quiz-volume-3" href="/quiz/world-cup-quiz-volume-3">-->
    <!--                            <img src="--><? //= Url::to('@eyAssets/images/pages/quiz/vlm3.png') ?><!--" alt="World Cup 2019 Quiz"-->
    <!--                                 class="q-box-img">-->
    <!--                            <div class="q-box-hover">-->
    <!--                                <div class="text2">Take Quiz</div>-->
    <!--                            </div>-->
    <!--                        </a>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="col-md-4">-->
    <!--                    <div class="q-box">-->
    <!--                        <a title="Independence Quiz" href="/quiz/how-well-do-you-know-about-independence-daylevel-three">-->
    <!--                            <img src="--><? //= Url::to('@eyAssets/images/pages/quiz/independence.jpg') ?><!--"-->
    <!--                                 alt="World Cup 2019 Quiz vol-2" class="q-box-img">-->
    <!--                            <div class="q-box-hover">-->
    <!--                                <div class="text2">Take Quiz</div>-->
    <!--                            </div>-->
    <!--                        </a>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div class="col-md-4">-->
    <!--                    <div class="q-box">-->
    <!--                        <a title="History Quiz" href="/quiz/history-quiz">-->
    <!--                            <img src="--><? //= Url::to('@eyAssets/images/pages/quiz/history.jpg') ?><!--"-->
    <!--                                 alt="Yuvraj Singh Quiz" class="q-box-img">-->
    <!--                            <div class="q-box-hover">-->
    <!--                                <div class="text2">Take Quiz</div>-->
    <!--                            </div>-->
    <!--                        </a>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </section>-->
    <section class="blog-section-2">
        <div class="container">
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
                            <?= $this->render('/widgets/follow-widget') ?>
                        </div>
                    </div>
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

<?= $this->render('/widgets/news-update') ?>

<?php
if (!empty($quotes)) {
    ?>
    <div class="myfade1"></div>
    <div class="imgmain-div"><img class="imgmain"/></div>
    <ul class="styled-icon icon-bordered icon-md mb-5 lightbox-ul">
        <li><a link='https://www.facebook.com/sharer/sharer.php?u=' target="_blank" class="overfb"><i
                        class="fab fa-facebook-f"></i></a></li>
        <li><a link='https://twitter.com/home?status=' target="_blank" class="overtw"><i class="fab fa-twitter"></i></a>
        </li>
        <li><a href link="https://www.pinterest.com/pin/create/button/?url={link}&media={image}&description={title}"
               target="_blank" class="overpt"><i class="fab fa-pinterest"></i></a></li>
        <li><a target="_blank" class="overdw" download><i class="fas fa-download"></i></a></li>
    </ul>
    <section class="blog-mirror">
        <div class="my-container">
            <div class="container pt-20 pb-5">
                <hr style="color: #ff704d;width: 50px;margin-left: 5px; border-top:3px solid #ff704d;margin-bottom: 0px;"/>
                <h3 style="font-family:lobster;font-size:28pt;color:#FFF;margin-top:3px;"><?= Yii::t('frontend', 'Food for Thoughts'); ?></h3>
                <div class="row">
                    <div class="col-md-12">
                        <article class="post clearfix">
                            <div class="entry-header">
                                <div class="post-thumb">
                                    <div id="slider1" class="owl-carousel-4col" data-nav="true">
                                        <?php
                                        foreach ($quotes as $post) {
                                            ?>
                                            <div class="zoom">
                                                <img class="imgsdds" src="<?= Url::to($post['image']); ?>" width="570"
                                                     height="133" alt="<?= $post['featured_image_alt']; ?>"
                                                     title="<?= $post['featured_image_title']; ?>"
                                                     url="<?= Yii::$app->urlManager->createAbsoluteUrl('/blog/' . $post['slug']); ?>">
                                                <div class="carousel-content">
                                                    <a href="<?= Url::to('/blog/' . $post['slug']); ?>"></a>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Subscribe Widget start-->
    <?php
    if (Yii::$app->user->isGuest) {
        echo $this->render('/widgets/subscribe-section');
    }
    ?>
    <!--Subscribe Widget ends-->

    <?php
}
echo $this->render('/widgets/blogs/whats-new');
echo $this->render('/widgets/blogs/popular-blogs');
echo $this->render('/widgets/blogs/trending-posts');
$this->registerCss('
.set-flex {
    display: flex;
	justify-content: flex-start;
	align-items: flex-end;
	padding-left: 40px;
	min-height: 380px;
}
.blog-header{
    background-image: url(' . Url::to('@eyAssets/images/pages/blog/blog-hdrbg.png') . ');
    background-repeat: no-repeat;
    background-position: left top;
    min-height: 450px;
    background-size: cover;
}
.blog-icon img{
    width: 580px;
}
.blog-icon{
    text-align: right;
	padding: 0;
	min-height: 430px;
	display: flex;
	align-items: flex-end;
	justify-content: flex-end;
}
.blog-txt h1{
    font-family: lobster;
    font-size: 60px;
    font-weight: 600;
}
.blog-txt h2{
    font-family: lora;
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 10px;
}
.col-item {
	box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
}
.col-item .photo img{
    object-fit:cover !important;
}
.col-item .info{
    text-align:center;
    font-family:roboto;
}
.col-item .price h5{
    font-size:16px;
    display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
.view-all-articles {
	text-align: center;
	margin: 25px 0 0;
}
.artic {
    border:2px solid transparent;
	background-color: #00a0e3;
	color: #fff;
	font-size: 18px;
	font-family: roboto;
	padding: 7px 30px;
	border-radius: 4px;
	text-transform: capitalize;
	transition: all .3s;
}
.artic:hover{
    background-color:#fff;
    color:#00a0e3;
    border:2px solid #00a0e3;
}
.price > h5{
    font-family:roboto;
}
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
 /*blog-section-0-ends*/
 
/*--------------------------------------------------*/
/*blog-section-2-css*/
.blog-section-2{
    padding:0px 0 30px 0;
    overflow:hidden;
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
 .myfade1{
    position:fixed;
    width:100%;
    height:100%;
    background-color:#000;
    top:0;
    left:0;
    opacity:0.8;
    display:none;
    z-index: 2000;
}
.imgmain{
    width:100%;
    height:100%;
    display:none;
    object-fit:contain;
}
.imgmain-div{
    width:60%;
    height:80%;
    top:10%;
    left:20%;
    display: none;
    position: fixed;
    z-index: 2000;
}
@media(min-width : 1500px) {
    .imgmain-div{
        width: 50%;
        height: 70%;
        top:15%;
        left:25%;
    }
}
.lightbox-ul{
    display: none;
    float:right;
    position: fixed;
    right:10%;
    width:50px !important;
    top:20%;
    z-index: 2000;
}
.lightbox-ul li a{
    border-radius: 25px !important;
}
.lightbox-ul li a{
    clear: both !important;
    color:white;
}
@media only screen and (min-width:2000px){
    .lightbox-ul{
        right:18%;
        width:64px !important;
    }
    .lightbox-ul li a{
        border-radius: 35px !important;
    }
    .styled-icon.icon-md a {
        font-size: 34px;
        height: 60px;
        line-height: 60px;
        width: 60px;
    }
}
.imgsdds{
    cursor:pointer !important;
}
.zoom {
    transition: transform .4s;
    width: 253px;
    height: 320px;
    margin: 0 auto;
    padding: 50px 0;
    top:-10px;
    left:-10px;
    transition-timing-function: linear;
    z-index:300;
}
.zoom img{
    height:200px;
    z-index:-500;
}
.zoom:hover{
    -ms-transform: scale(1.4); /* IE 9 */
    -webkit-transform: scale(1.4); /* Safari 3-8 */
    transform: scale(1.4);
    z-index: 999;
}
.c_content{
    left:44%;
}
.tag {
    background-color: #e0e0eb;
    border-left: 6px solid  #33334d;
}
hr {
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid  #ff704d;
    margin: 1em 0;
    padding: 0; 
}
.caption{
    background-color: #e0e0eb;
    border-left: 6px solid  #33334d;
}
#slider1 .owl-stage-outer{
    overflow: visible !important;
    z-index: 1000;
}
.owl-controls{
    display: none !important;
}
.overdw:hover{
    background-color:#1c99e9 !important;
    color:white;
    border:0px !important;
}
#slider1 {
    margin-bottom: 20px;
    margin-top: -40px;
}
#slider1 .owl-stage{
    margin-left: -56px !important;
}
.blog-mirror{
    background: linear-gradient(180deg, #2b2d32 60%, #fff 40%);
}
.styled-icon.icon-md a {
    font-size: 24px;
    height: 50px;
    line-height: 50px;
    width: 50px;
    color:#fff;
    border: 1px solid #777777;
    float: left;
    margin: 5px 7px 5px 0;
    text-align: center;
    -webkit-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}
.my-container{
    max-width: 100%;
    overflow:hidden;
    display: block;
    margin: auto;
}
.lightbox-ul-show{
    display:block;
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
@media screen and (max-width: 768px){
    .controls {
        margin-top: 35px;
    }
    .owl-stage-outer{
        overflow: hidden !important;
    }
    .zoom:hover{
        -ms-transform: scale(1.5,1.2);
        -webkit-transform: scale(1.5,1.2);
        transform: scale(1.5,1.2);
        left: 8%;
    }
    .imgmain-div{
        width: 70%;
        height: 275px;
        top: calc(47vh - 137px);
        left: 15%;
    }
    .lightbox-ul-show{
        display: inline;
    }
    .lightbox-ul{
        width: 90% !important;
        bottom: 5%;
        top: auto;
        left: 5%;
        text-align: center;
    }
    .lightbox-ul li{
        display: inline;
    }
    .styled-icon.icon-md a{
        font-size: 18px;
        height: 40px;
        display: inline-block;
        line-height: 40px;
        width: 40px;
        float: none;
    }
    .carousel-inner {
        padding: 0px 10px;
    }
    .col-item {
        margin-bottom: 10px;
    }
    #slider1 .owl-stage-outer .owl-stage .owl-item{
        margin: 0px 10px !important;
    }
    .whats-block-heading:before{
        border-width: 1px 280px 0px 0px;
    }
    .whats-popular-heading:before{
        border-width: 1px 250px 0px 0px;
    }
}
@media screen and (max-width: 450px){
    .zoom img{
        width:79vw !important;
    }
    .zoom{
        padding-left: 26px;
    }
}
@media screen and (max-width: 500px){
    .whats-block-heading:before{
        border-width: 1px 200px 0px 0px;
    }
    .whats-popular-heading:before{
        border-width: 1px 170px 0px 0px;
    }
}
@media screen and (max-width: 425px){
    .whats-block-heading:before{
        border-width: 1px 180px 0px 0px;
    }
    .whats-popular-heading:before{
        border-width: 1px 150px 0px 0px;
    }
}
@media screen and (max-width: 400px){
    .whats-block-heading:before{
        border-width: 1px 150px 0px 0px;
    }
    .whats-popular-heading:before{
        border-width: 1px 120px 0px 0px;
    }
}
@media screen and (max-width: 374px){
    .whats-block-heading:before{
        border-width: 1px 110px 0px 0px;
    }
    .whats-popular-heading:before{
        border-width: 1px 80px 0px 0px;
    }
}
@media screen and (max-width: 767px) {
    .blog-icon{
        min-height: 0px;
    } 
    .blog-icon img {
        width: 438px;
    }
    .set-flex {
        min-height: 228px;
    }
}
@media screen and (max-width: 750px) and (min-width: 601px) {
    .blog-txt h1 {
        font-size: 47px;
    }
    .blog-txt h2 {
        font-size: 20px;
    }
    .set-flex {
        min-height: 200px;
    }
    .blog-icon{
        min-height: 0px;
    }
    .blog-header {
        min-height: 355px;
    }
    .blog-icon img {
        width: 410px;
    }
}
@media screen and (max-width: 600px) and (min-width: 450px) {
    .blog-txt h1 {
        font-size: 47px;
    }
    .blog-txt h2 {
        font-size: 20px;
    }
    .set-flex {
        min-height: 200px;
    }
    .blog-icon{
        min-height: 0px;
    }
    .blog-header {
        min-height: 355px;
    }
    .blog-icon img {
        width: 250px;
    }
}
@media screen and (max-width: 450px) and (min-width: 320px) {
    .blog-txt h1 {
        font-size: 34px;
    }
    .blog-txt h2 {
        font-size: 16px;
    }
     .set-flex {
        min-height: 200px;
    }
    .blog-icon{
        min-height: 0px;
    }
    .blog-header {
        min-height: 355px;
    }
    .blog-icon img {
        width: 250px;
    }
)
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
$script = <<<JS
$.ajax({
    method: "POST",
    url : '/blog/trending-posts',
    success: function(response) {
    if(response.status === 200) {
        var wn_data = $('#whats-new-blog').html();
        $("#whats-new").html(Mustache.render(wn_data, response.whats_new_posts));
        var pb_data = $('#trending-blog').html();
        $("#trending-post").html(Mustache.render(pb_data, response.trending_posts));
        var tb_data = $('#popular-blog-post').html();
        $("#popular-blog").html(Mustache.render(tb_data, response.popular_posts));
    }
}
});
$(document).on('click', '.imgsdds', function () {
    var u = $(this).attr('url');
    var t = $(this).attr('alt');
    var image = $(location).attr('protocol') + '//' + $(location).attr('hostname') + $(this).attr('src');
    $('.lightbox-ul li a').each(function () {
        if ($(this).attr('class') != 'overpt' || $(this).attr('class') != 'overdw') {
            $(this).attr('href', $(this).attr('link') + u);
        }
    });

    $(function () {
        var link = $('.overpt').attr('link');
        $('.overdw').attr('href', image);
        $('.overpt').each(function () {
            this.href = this.href.replace('{link}', u);
            this.href = this.href.replace('{image}', image);
            this.href = this.href.replace('{title}', t);
        });
    });
});

$(function () {
    $('.imgsdds').click(function () {
        var c = $(this).attr('src');
        $('.imgmain').attr('src', c);
        $('.myfade1').fadeIn(500);
        $('.imgmain').fadeIn(1000);
        $('.imgmain-div').fadeIn(1000);
        $('.lightbox-ul').addClass('lightbox-ul-show');

    });
    $('.myfade1').click(function () {
        var d = $(this).attr('src');
        $('.main').attr('src', d);
        $('.imgmain').fadeOut(1000);
        $('.myfade1').fadeOut(1000);
        $('.imgmain-div').fadeOut(1000);
        $('.lightbox-ul').removeClass('lightbox-ul-show');
    });

    $(document).bind('keydown', function (e) {
        if (e.which == 27) {
            var d = $(this).attr('src');
            $('.main').attr('src', d);
            $('.imgmain').fadeOut(1000);
            $('.myfade1').fadeOut(1000);
            $('.imgmain-div').fadeOut(1000);
            $('.lightbox-ul').removeClass('lightbox-ul-show');
        }
    });
});

$('.owl-carousel-4col').owlCarousel({
    loop: true,
    nav: true,
    pauseControls: true,
    margin: 20,
    autoplay: true,
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    responsiveClass: true,
    navText: [
        '<i class="fas fa-chevron-left"></i>',
        '<i class="fas fa-chevron-right"></i>'
    ],
    responsive: {
        0: {
            items: 1
        },
        568: {
            items: 1
        },
        600: {
            items: 2
        },
        1000: {
            items: 4
        }
    }
});
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');