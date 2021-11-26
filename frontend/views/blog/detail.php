<?php
$this->params['header_dark'] = true;
$this->title = $post->title;

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

//$link = Url::to( 'blog/'.$post->slug, true);

$keywords = $post->meta_keywords;
$description = $post->excerpt;
$image = Yii::$app->urlManager->createAbsoluteUrl(Yii::$app->params->upload_directories->posts->featured_image . $post->featured_image_location . DIRECTORY_SEPARATOR . $post->featured_image);
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl("https"),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl("https"),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>
    <section class="blog-header">
        <div class="container padd-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="pos-rel">
                        <div class="blog-title"><?= $post->title; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="blog-division">
                        <?php
                        $postCat = $post->postCategories;
                        foreach ($postCat as $cat) {
                            $cat_name = $cat->categoryEnc->name;
                        }
                        if (!$cat_name) {
                            ?>
                            <div class="blog-cover-image">
                                <?php $feature_image = Yii::$app->params->upload_directories->posts->featured_image . $post->featured_image_location . DIRECTORY_SEPARATOR . $post->featured_image; ?>
                                <img src="<?= $feature_image; ?>">
                            </div>
                            <?php
                        }
                        ?>
                        <div id="blog-description" class="blog-text">
                            <?= $post->description; ?>
                        </div>
                    </div>
                    <div class="share-social-links">
                        <a href="javascript:;" class="fb"
                           onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fab fa-facebook-f"></i></a>
                        <a href="javascript:;" class="wts-app"
                           onclick="window.open('https://api.whatsapp.com/send?text=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fab fa-whatsapp"></i></a>
                        <a href="javascript:;" class="tw"
                           onclick="window.open('https://twitter.com/intent/tweet?text=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fab fa-twitter"></i></a>
                        <a :href="'mailto:https://myecampus.in'+this.$route.fullPath" class="male">
                            <i class="far fa-envelope"></i></a>
                        <a href="javascript:;" class="fb"
                           onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&amp;url=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fab fa-linkedin"></i></a>
                        <a href="javascript:;" class="male"
                           onclick="window.open('http://pinterest.com/pin/create/link/?url=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fab fa-pinterest"></i></a>
                        <a href="javascript:;" class="tw"
                           onclick="window.open('https://telegram.me/share/url?url=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                            <i class="fab fa-telegram"></i></a>
                    </div>
                    <?=
                    $this->render('/widgets/mustache/discussion/discussion-box', [
                        "controllerId" => Yii::$app->controller->id . "/comments"
                    ]);
                    ?>
                </div>
                <div class="col-md-3">
                    <div class="about-blogger">
                        <div class="channel">
                            <a href="javascript:;">
                                <div class="channel-icon">
                                    <?php
                                    $author = $post->authorEnc;
                                    $name = $author->first_name . ' ' . $author->last_name;
                                    if ($author->image) {
                                        $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $author->image_location . DIRECTORY_SEPARATOR . $author->image;
                                        ?>
                                        <img src="<?= $image; ?>" alt="<?= $name; ?>"/>
                                        <?php
                                    } else {
                                        ?>
                                        <canvas class="user-icon img-circle img-responsive" name="<?= $name; ?>"
                                                color="<?= $author->initials_color; ?>" width="125" height="125"
                                                font="60px"></canvas>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </a>
                            <div class="channel-details">
                                <div class="channel-name"><a href=""><?= $name ?></a></div>
                                <div class="channel-des"><?= $author->description ?></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="blog-tags">
                                <span>Tags:</span>
                                <ul>
                                    <?php
                                    $postTags = $post->postTags;
                                    foreach ($postTags as $tags) {
                                        $tag = $tags->tagEnc;
                                        echo '<li><a href="/blog/tag/' . $tag->slug . '">' . $tag->name . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="padd-top"></div>
                        <?php
                        if (!empty($similar_posts)) {
                            ?>
                            <div class="col-md-12">
                                <div class="popular-heading">Related Blogs</div>
                            </div>
                            <?php
                            foreach ($similar_posts as $related) {
                                $path = Yii::$app->params->upload_directories->posts->featured_image . $related['featured_image_location'];
                                $image = $path . DIRECTORY_SEPARATOR . $related['featured_image'];
                                if (empty($related['featured_image'])) {
                                    $image = '//placehold.it/250x200';
                                }
                                ?>
                                <div class="col-md-12 col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1">
                                    <div class="video-container">
                                        <a href="/blog/<?= $related['slug'] ?>">
                                            <div class="video-icon">
                                                <img src="<?= $image ?>">
                                            </div>
                                            <div class="r-video">
                                                <div class="r-v-name"><?= $related['title'] ?></div>
                                                <div class="r-ch-name"><?= $related['excerpt'] ?></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <!--hotjobs Widget start-->
                    <?php
                    echo $this->render('/widgets/hot-jobs');
                    ?>
                    <!--hotjobs Widget ends-->
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" value="<?= Yii::$app->user->identity->user_enc_id; ?>" id="user_id">

<?php
$this->registerCss('
.share-social-links {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    flex-wrap: wrap;
}

.share-social-links > a {
    min-width: 90px;
    margin: 15px 1% 0 0;
}

.share-social-links > a:last-child {
    margin-right: 0;
}

.wts-app {
    background-color: #25D366;
}

.male {
    background-color: #d3252b;
}

.tw {
    background-color: #1c99e9;
}

.fb {
    background-color: #236dce;
}

.wts-app i, .male i, .tw i, .fb i {
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    width: 100%;
    text-align: center;
    padding: 10px 0;
}

.share-social-links:hover a {
    opacity: 0.6;
}

.share-social-links > a:hover {
    opacity: 1;
}
.divider{
border-top:1px solid #eee;
margin-top:15px;
}

/*----blog section----*/
.blog-header{
    min-height:150px;
    background:#007bff;
}
.blog-header > .container{
    padding-top:0px !important;
}
.pos-rel{
    position:relative;
    height:150px;
}

.blog-title{
    font-size: 35px;
    color:#fff;
    font-weight: bold;
    position:absolute;
    top:50%;
    transform:translateY(-50%);
    font-family: lora;
}
.publish-date{
    position: absolute;
    left: 50%;
    bottom:10px;
    transform:translateX(-50%);
    font-weight: bold;
    font-size: 14px;
    margin: 0 auto;
}
.load-more-btn{
    text-align:center;
    padding-top:20px;
}
.load-more-btn button{
   border: 1px solid #ebefef;
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    -ms-box-shadow: none;
    -o-box-shadow: none;
    box-shadow: none;
    padding: 15px 44px;
    font-size: 15px;
    color: #111111;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    background:none;
}
.load-more-btn button:hover{
    background-color: #00a0e3;
    color: #fff;
    border-color: transparent;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
}
.blog-tags span,.blog-cat span, .blog-pub span{
    font-weight:bold;
}
.blog-tags ul li{
    margin: 0px 0 10px 0;
    display: inline-block;
    border:1px solid #eee;
    padding:5px 10px;
    border-radius: 8px;
    margin-right: 5px;
}
.blog-tags ul{
    margin:10px 0 10px 0
}
.comment-sub{
    text-align:right;
}
.comment-sub1{
    text-align:right;
}
.comment-sub button, .comment-sub1 button {
    background:#00a0e3;
    border:1px solid #00a0e3;
    color:#fff;
    border-radius:5px;
    padding:6px 10px;
    font-size:13px;
    text-transform:uppercase;
}
.closeComment1{
   background:#fff;
   border:1px solid #00a0e3;
   color:#00a0e3; 
}
textarea{
    border:1px solid #eee; 
    border-radius:10px;
    width:100%;
    padding:10px 15px;
}
textarea::placeholder{
    color:#999;
    font-size:13px;
}
.errorClass{
     border: 1px solid rgba(227, 0, 49, .3);
    box-shadow: 0 0 15px rgba(227, 0, 49, .3);
    transition: .3s all;    
}
.add-comment{
    padding:10px 20px;
    border-bottom: 1px dotted #eee;
    border-radius:10px;
}
.reply-comment{
    padding:20px 20px 10px;
    margin-top:20px;
}

.blog-comm, .reply-comm{
    border-bottom: 1px dotted #eee;
    padding:25px 5px 20px; 
    border-radius:10px;
    position:relative;
}
.reply-comm{
    border-bottom: none;
}
.blog-cover-image img{
    height:auto;
    width:100%;
    object-fit:fill;
    border-radius:10px;
}
.blog-division{
    border:1px solid #fff;
    border-radius:10px;
}
//.blog-text{
//    padding:0 10px 10px 10px;
//}
.channel{
    text-align:center;
}
.channel-details{
    padding:5px 0px 0 10px;
}
.channel-name{
    font-size:17px;
    font-weight:bold;
    padding-top: 10px;
}
.channel-des{
    text-align:justify;
    padding:15px 0px;
}
.channel-icon, .comment-icon{
    background:#fff;
    box-shadow:0 0 10px rgba(0, 0, 0, .5);
    border-radius:50%;
    width:125px;
    height:125px;
    border:3px solid #eee;
    margin:0 auto;
    overflow:hidden;
    object-fit:cover;
}
.comment-icon{
    width:90px;
    height:90px;
}
.channel-icon img, .channel-icon canvas, .comment-icon img{
    width:100%;
    height:100%;
    line-height:0px;
}
.popular-heading, .about-heading{
    position:relative;
//    text-align:right;
    text-transform: uppercase;
//    padding: 0px 25px 2px 0px;
    font-weight: bold;
    margin-top:30px;
    text-align:center;
}
.about-heading:before{
    border-width: 1px 110px 0px 0px !important;
}
.popular-heading:before{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 58px 0px 0px;
    top: 11px;
    left: 0px;
}
.popular-heading:after{
    content: "";
    position: absolute;
    border-color: #000;
    border-style: solid;
    border-width: 1px 58px 0px 0px;
    top: 11px;
    right: 0px;
}
.video-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:300px;
    position:relative;
    margin-top:20px;
    overflow:hidden;
    
}
.video-container:hover{
    box-shadow:0 0 15px rgba(0,0,0,0.3);
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.video-icon{
    max-width:270px;
    height:186px;
    overflow:hidden;
    object-fit:cover;
}
.video-icon img{
    border-radius:10px 10px 0 0; 
    width:100%;
    height:100%;
}
.r-video{
    padding:5px 10px 10px 10px;
}
.r-v-name{
    font-size:16px;
    font-weight:bold;
}
.r-ch-name{
    position:relative;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-left: 5px;
}
.padd-top{
    margin-top:30px;
}
.comments-block{
    padding:30px 0;
}
.comment-box{
  
}
.comment-name{
    font-weight:bold;
    text-transform:uppercase;
    font-size:15px;
}
.comment{
    margin-top:5px;
    border-left:1px solid #eee;
    padding:0 0px 0 20px;
}
.reply{
    position:absolute;
    top:10px;
    right:20px;
}
.reply button{
    background: transparent;
    border:none;
    font-size:14px;
    color:#999;
}
.reply button:hover{
    color:#00a0e3;
}
.reply-comm .comment{
    margin-left:15px;
}

/*----blog section ends----*/
@media only screen and (min-width: 992px) and (max-width: 1200px) {
    .popular-heading:before{
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 30px 0px 0px;
        top: 11px;
        left: 5px;
    }
     .about-heading:before{
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 50px 0px 0px !important;
        top: 11px;
        left: 5px;
    }
}
@media only screen and (max-width: 991px){
    .popular-heading:before{
        content: "";
        position: absolute;
        border-color: #000;
        border-style: solid;
        border-width: 1px 533px 0px 0px;
        top: 11px;
        left: 5px;
    }
    .about-heading:before{
        border-width: 1px 560px 0px 0px !important;
    }
}
@media only screen and (max-width: 768px){
    .popular-heading{
        position:relative;
        text-align:center;
        text-transform: uppercase;
        padding: 10px 0px 2px 0px;
        font-weight: bold;
        margin-top:20px;
        border-top:2px solid #000;
    }
    .popular-heading:before,.popular-heading:after{
        border-width:0;
    }
    .about-heading:before{
        border-width:0 !important;
    }
    .channel{
        padding:30px;
    }
    .video-icon{
        max-width:100%;
    }
}



/*----blog description preview css start----*/
#blog-description ul{
    list-style: disc;
    margin-bottom: 10px;
    padding-left: 40px;
}
#blog-description ol{
    list-style: decimal;
    margin-bottom: 10px;
    padding-left: 40px;
}
//div#blog-description * {
//    font-size: 20px !important;
//    line-height: 29px !important;
//}
/*----blog description preview css ends----*/
');
$this->registerJsFile('https://platform-api.sharethis.com/js/sharethis.js#property=5aab8e2735130a00131fe8db&product=sticky-share-buttons', ['depends' => [\yii\web\JqueryAsset::className()]]);

