<?php


use yii\helpers\Url;
use yii\helpers\Html;

$this->title = Yii::t('frontend', 'Learning Section');
$this->params['header_dark'] = true;

$keywords = 'Learning';
$description = $video_detail['description'];
$image = $video_detail['cover_image'];
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth__',
        'twitter:creator' => '@EmpowerYouth__',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];

?>
<section class="bg-blue">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 color-bg">
                <div class="top-categories">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="chan-heading">Top Categories</h1>
                        </div>
                    </div>

                    <div id="top-category"></div>

                </div>
            </div>

            <input type="hidden" id="video-id" value="<?= $video_detail['youtube_video_id']; ?>">
            <div class="col-md-7 white-bg">
                <div class="row">
                    <div class="video-frame" id="ytplayer">
                        <!--                        <iframe id="yt-video-frame" onclick="iframeClick(this);" width="100%" height="480"-->
                        <!--                                src="https://www.youtube.com/embed/-->
                        <? //= $video_detail['youtube_video_id']; ?><!--"-->
                        <!--                                frameborder="0" allowfullscreen></iframe>-->
                    </div>
                    <div class="video-options">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="flex-view">
                                    <div class="likebtn">
                                        <button id="like">
                                            <span class="<?= $like_status['status'] == 1 ? 'imageBlue2' : ''; ?> imageGray"
                                                  id="imageOn"></span>
                                        </button>
                                    </div>
                                    <div class="dislikebtn">
                                        <button id="dislike">
                                            <span class="<?= $like_status['status'] == 2 ? 'dislikeBlue2' : ''; ?> dislikeGray"
                                                  id="imageOff"></span>
                                        </button>
                                    </div>

                                    <div class="share-list">
                                        <div class="share">
                                            <button type="button" class="sbtn" onclick="showShare()"><i
                                                        class="fa fa-share-alt"></i> Share
                                            </button>
                                        </div>
                                        <?php
                                        $fb_url = Url::to(Yii::$app->controller->id . '/video/' . $video_detail['slug'], true);
                                        ?>
                                        <ul class="s-list fadeout" id="Fader">
                                            <li><a href="javascript:;"
                                                   onclick="window.open('<?= Url::to('https://www.facebook.com/sharer.php?u=' . $fb_url); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                                    <i class="fa fa-facebook-f"></i> </a></li>
                                            <li><a href="javascript:;"
                                                   onclick="window.open('<?= Url::to('https://www.twitter.com/home?status=' . $fb_url); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                                    <i class="fa fa-twitter"></i></a></li>
                                            <li><a href="javascript:;"
                                                   onclick="window.open('<?= Url::to('https://wa.me?text=' . $fb_url); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                                    <i class="fa fa-whatsapp"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="video-details">
                        <div class="v-title"><?= $video_detail['title']; ?></div>
                        <input type="hidden" id="video-duration" value="<?= floor($video_detail['duration'] * 0.4); ?>">
                        <div class="v-category">
                            <ul>
                                <li id="cate" data-id="<?= $video_detail['parent_enc_id']; ?>">Category: <span>
                                        <?= $video_detail['parent_name']; ?></span></li>
                                <li id="subcate" data-id="<?= $video_detail['category_enc_id']; ?>">Sub Category: <span>
                                        <?= $video_detail['child_name']; ?></span></li>
                            </ul>
                        </div>
                        <div class="v-tags">
                            <ul id="tags-cont">
                                <?php
                                foreach ($video_detail['learningVideoTags'] as $v) {
                                    ?>
                                    <li id="<?= $v['tag_enc_id'] ?>"> <?= $v['name']; ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="views"><i class="fa fa-eye"></i> <span><?= $video_detail['view_count'] ? $video_detail['view_count'] : 'No' ?></span> Views</div>
                                <div class="likes"><i class="fa fa-thumbs-up"></i>
                                    <span><?= $like_count ? $like_count : 'No' ?></span> Likes
                                </div>
                                <div class="likes"><i class="fa fa-thumbs-down"></i>
                                    <span><?= $dislike_count ? $dislike_count : 'No' ?></span> Dislikes
                                </div>
                                <div class="comms"><a href="#comments"> <i class="fa fa-comments-o"></i>
                                        <span><?= $comment_count ? $comment_count : 'No' ?></span>
                                        Comments </a></div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="v-disc">

                                <?php
                                $des_len = round(strlen($video_detail['description']));
                                if ($des_len > 300) {
                                    ?>
                                    <div id="less-des">
                                        <?php
                                        echo substr($video_detail['description'], 0, 300);
                                        ?>
                                    </div>
                                    <div class="hidden" id="show-more-content">
                                        <?= $video_detail['description']; ?>
                                    </div>
                                    <div class="show-more-bttn">
                                        <button type="button" id="smoreBtn">Show More</button>
                                    </div>
                                    <?php
                                } else {
                                    echo $video_detail['description'];
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row" id="comments">
                        <div class="col-md-12">
                            <h1 class="chan-heading">Comments</h1>
                        </div>
                        <div class="comment-box">
                            <div class="add-comment">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1">
                                        <form id="postComm">
                                            <div class="">
                                                <textarea id="commentArea"></textarea>
                                            </div>
                                            <div class="comment-sub">
                                                <button type="button" id="sendComment">Comment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-md-offset-1">
                                <div id="activecomments"></div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row" id="interested-cont">
                        <div class="col-md-12">
                            <h1 class="chan-heading">You Might Be Interested In</h1>
                        </div>
                        <div id="i-videos"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 blue-bg">
                <div class="top-video">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="chan-heading">Top Videos</h1>
                        </div>
                        <div id="top-videos"></div>
                    </div>
                </div>
                <div class="rVideos" id="related-videos-cont">
                    <h1 class="chan-heading">Related Videos</h1>
                    <div class="row" id="r-videos">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<input type="hidden" value="<?= Yii::$app->user->identity->user_enc_id; ?>" id="user_id">

<?php

$this->registerCss('
.footer{
margin-top:0px !important;
}
section > .container, section > .container-fluid{
padding-top:0px !important;
}
.padd-top-40{
padding-top:40px;
padding-left: 5px;
padding-right: 5px;
}
.mar-20{
margin:20px;
}
.divider{
border-top:1px solid #eee;
margin-top:15px;
}
.align-right{
text-align:right;
}
.padd-10{
padding-left:10px;
padding-right:10px;
}
.no-padd{
padding-right:0px;
padding-left:0px;
}
.bg-blue{
background:#ecf5fe;
}
.color-bg{
padding-top:0px;
padding-bottom:30px
}
.blue-bg{
padding-top:0px;
padding-bottom:30px
}
.padd-left-0{
padding-left:0px !important;
}
.chan-heading{
font-size:18px;
font-weight:bold;
text-transform: capitalize;
padding:0px 0px 5px 0;
}
.trending-posts{
padding:0px 10px;
}
.tp-box{
margin-bottom:10px;
}
.tp-box:hover .tp-icon img{
-webkit-transform: scale(1.1);
transform: scale(1.1);
opacity: 0.3;
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
.tp-heading{
font-weight:bold;
color:#000;
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
/*----------*/
.video-frame{
max-height:480px;
width:100%;
}
.fluid-width-video-wrapper {
padding-top: 0px !important;
height: 400px;
}
.white-bg{
background:#fff;
border-left:1px solid #eee;
border-right:1px solid #eee;
padding:20px 30px 30px 30px;
}
.video-options{
padding:5px 10px;
border:1px solid #262626;
border-radius:0 0 5px 5px;
background:#262626;
}
.flex-view{
display:flex;
padding-top:8px;
}
.share{
padding-left: 10px;
}
.like i, .dislike i,{
color:#999;
font-size:20px;
}
.likebtn, .dislikebtn{
font-size:14px;
margin: 0px 0px;
}
.share i{
font-size:18px
}
.views i{
font-size:15px;
}
.dislikeGray{
background:url(' . Url::to('@eyAssets/images/pages/learning-corner/dislike1.png') . ');
width:20px;
height:20px;
display:block;
}
.dislikeBlue{
background:url(' . Url::to('@eyAssets/images/pages/learning-corner/dislikeb.png') . ');
width:20px;
height:20px;
display:block;
}
.dislikeBlue2{
background:url(' . Url::to('@eyAssets/images/pages/learning-corner/dislikeb.png') . ') !important;
}
.imageGray{
background:url(' . Url::to('@eyAssets/images/pages/learning-corner/like1.png') . ');
width:20px;
height:20px;
display:block;
}
.imageBlue{
background:url(' . Url::to('@eyAssets/images/pages/learning-corner/likeb.png') . ');
width:20px;
height:20px;
display:block;
}
.imageBlue2{
background:url(' . Url::to('@eyAssets/images/pages/learning-corner/likeb.png') . ') !important;
}
.align-right{
justify-content:flex-end;
}
.likebtn button, .dislikebtn button{
background:none;
border:none;
font-size:20px;
}
ul.s-list li{
display:inline !important;
padding:5px 5px;
color:#dfdedc;
}
ul.s-list li a{
color:#dfdedc;
}
ul.s-list{
margin-left:5px;
}
.sbtn{
background:none;
border:none;
color:#dfdedc;
}
.sbtn:hover{
color:#00a0e3;
}
.fadein, .fadeout {
opacity: 0;
-moz-transition: opacity 0.4s ease-in-out;
-o-transition: opacity 0.4s ease-in-out;
-webkit-transition: opacity 0.4s ease-in-out;
transition: opacity 0.4s ease-in-out;
}
.fadein {
opacity: 1;
}
.share-list{
display:flex;
}
.report-btn{
justify-content:flex-end;
}
.report-btn button{
background:none;
border:none;
color:#dfdedc;
}
.n-p-bttns{
text-align:center;
}
.n-p-bttns button{
background: #dfdedc;
color: #262626;
border: 1px solid #dfdedc;
padding: 7px 10px;
border-radius: 5px;
font-size: 11px;
}
.n-p-bttns button:hover{
background: #00a0e3;
color:#fff;
border: 1px solid #00a0e3;
transition:.3s all;
}
.n-p-bttns button:hover, .n-p-bttns button, .sbtn, .sbtn:hover {
-webkit-transition:.3s all;
-moz-transition:.3s all;
-ms-transition:.3s all;
transition:.3s all;
}
.video-details{
padding:10px 0 0 0 ;
}
.v-title{
font-size:18px;
font-weight:bold;
text-transform:capitalize;
color:#000;
line-height:24px;
}
.v-disc{
padding-top:30px
}
#smoreDiv{
display:none;
}
.show-more-bttn{
text-align:center;
}
.show-more-bttn button{
background:#00a0e3;
color:#fff;
border:1px solid #00a0e3;
padding:8px 10px;
border-radius:5px;
font-size:13px;
}
.v-category{
padding-top:10px;
font-weight:bold
}
.v-category ul li{
display:inline;
margin-right:20px;
color:#000;
}
.v-category span{
font-weight:500;
}
.v-tags{
padding:20px 0 20px;
}
.v-tags ul li{
display:inline-block;
padding:5px 10px;
border:1px solid #999;
border-radius:8px;
margin-right:5px;
}
.v-tags ul a li{
margin-bottom:10px;
}
.video-container, .video-container2{
box-shadow:0 0 10px rgba(0,0,0,0.1);
border-radius:10px;
height:250px;
position:relative;
margin-bottom:20px;
}
.video-container2{
height:auto;
background:#fff;
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
height:120px;
overflow:hidden;
object-fit:cover;
}
.video-icon2{
width:100%;
height:200px;
overflow:hidden;
object-fit:cover;
}
.video-icon img, .video-icon2 img{
border-radius:10px 10px 0 0;
width:100%;
height:100%;
}
.r-video, .r-video2{
padding:5px 10px 10px 10px;
}
.r-video2{
background:#fff;
}
.r-v-name{
font-size:14px;
font-weight:bold;
}
.r-ch-name{
position:absolute;
bottom:5px;
left:10px;
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
.comment-icon img{
width:100%;
line-height:0px;
}
.comment-icon{
width:70px;
height:70px;
background:#fff;
box-shadow:0 0 10px rgba(0, 0, 0, .5);
border-radius:50%;
border:3px solid #eee;
margin:0 auto;
overflow:hidden;
object-fit:cover;
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
.add-comment{
padding:10px 20px;
border-bottom: 1px dotted #eee;
border-radius:10px;
}
.reply-comment{
//    border-top:1px solid #eee;
padding:20px 20px 10px;
margin-top:20px;
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
padding:8px 10px;
font-size:13px;
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
.comms a{
transition:.3s all;
}
.related-video-box{
padding:5px 0;
}
.re-v-icon img{
border-radius:10px;
}
.re-v-name{
font-size:11px;
font-weight:bold;
line-height:20px;
}

/*------*/
.social-buttons {
display: flex;
flex-wrap: wrap;
justify-content: center;
}
.social-buttons__button {
margin: 10px 5px 0;
}

.social-button {
position: relative;
display: flex;
justify-content: center;
align-items: center;
outline: none;
width: 50px;
height: 50px;
text-decoration: none;
}
.social-button__inner {
position: relative;
display: flex;
align-items: center;
justify-content: center;
width: calc(100% - 2px);
height: calc(100% - 2px);
border-radius: 100%;
background: #fff;
text-align: center;
}
.social-button i,
.social-button svg {
position: relative;
z-index: 1;
transition: 0.3s;
}
.social-button i {
font-size: 20px;
}
.social-button svg {
height: 40%;
width: 40%;
}
.social-button::after {
content: "";
position: absolute;
top: 0;
left: 50%;
display: block;
width: 0;
height: 0;
border-radius: 100%;
transition: 0.3s;
}
.social-button:focus, .social-button:hover {
color: #fff;
}
.social-button:focus::after, .social-button:hover::after {
width: 100%;
height: 100%;
margin-left: -50%;
}
.social-button--mail {
color: #0072c6;
}
.social-button--mail::after {
background: #0072c6;
}
.social-button--facebook {
color: #3b5999;
}
.social-button--facebook::after {
background: #3b5999;
}
.social-button--linkedin {
color: #0077b5;
}
.social-button--linkedin::after {
background: #0077b5;
}
.social-button--github {
color: #6e5494;
}
.social-button--github::after {
background: #6e5494;
}
.social-button--codepen {
color: #212121;
}
.social-button--codepen::after {
background: #212121;
}
.social-button--steam {
color: #7da10e;
}
.social-button--steam::after {
background: #7da10e;
}
.social-button--snapchat {
color: #eec900;
}
.social-button--snapchat::after {
background: #eec900;
}
.social-button--twitter {
color: #55acee;
}
.social-button--twitter::after {
background: #55acee;
}
.social-button--instagram {
color: #e4405f;
}
.social-button--instagram::after {
background: #e4405f;
}
.social-button--npmjs {
color: #c12127;
}
.social-button--npmjs::after {
background: #c12127;
}

@media screen and (max-width: 992px){
.video-icon{
max-width:100%;
}
.padd-left-0{
padding-left: 15px !important;
}
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
text-transform:capitalize;
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

.video-container2{
box-shadow:0 0 10px rgba(0,0,0,0.1);
border-radius:10px;
height:300px;
background:#fff;
position:relative;
margin-bottom:20px;
}
.video-icon2{
width:100%;
height:200px;
overflow:hidden;
object-fit:cover;
}
.r-video2{
padding:5px 10px 10px 10px;
background:#fff;
}
.r-v-name{
font-size:14px;
font-weight:bold;
}
.r-ch-name{
position:absolute;
bottom:5px;
left:10px;
}

.video-container2{
box-shadow:0 0 10px rgba(0,0,0,0.1);
border-radius:10px;
height:300px;
background:#fff;
position:relative;
margin-bottom:20px;
}
.video-icon2{
width:100%;
height:200px;
overflow:hidden;
object-fit:cover;
}
.r-video2{
padding:5px 10px 10px 10px;
background:#fff;
}
.r-v-name{
font-size:14px;
font-weight:bold;
}
.r-ch-name{
position:absolute;
bottom:5px;
left:10px;
}
.video-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:250px;
    position:relative;
    margin-bottom:20px;
}
.video-icon{
    height:120px;
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
    font-size:14px;
    font-weight:bold;
}
.r-ch-name{
    position:absolute;
    bottom:5px;
    left:10px;
}
/*---show more reply btn---*/
.srBtn button{
    background:none;
    border:none;
    font-size:13px;
    color:#00a0e3;
}
.showReply{
    text-align:center;
}
');

$script = <<<JS
    function getQueryStringValue (key) {  
      return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
    }
    
    var like = document.getElementById('like');
    var imageOn = document.getElementById('imageOn');

    var dislike = document.getElementById('dislike');
    var imageOff = document.getElementById('imageOff');
    
    var already_liked = false;
    if(imageOn.classList.contains('imageBlue2')){
        already_liked = true;
    }
    
    var likeEvent = {
        type: 'liked',
        status : already_liked,
        param: window.location.pathname.split('/')[3]
    };

    var already_disliked = false;
    if(imageOff.classList.contains('dislikeBlue2')){
        already_disliked = true;
    }
    
    var dislikeEvent = {
        type: 'disliked',
        status : already_disliked,
        param: window.location.pathname.split('/')[3]
    };

    function ajaxRequest(url, data = null, async = true, callback){
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                callback(response);
            }
        })
    }
    
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    like.onmouseover = function() {
        imageOn.classList.add('imageBlue');
        imageOn.classList.remove('imageGray');
    };

    like.onmouseleave = function() {
        imageOn.classList.add('imageGray');
        imageOn.classList.remove('imageBlue');
    };
    
    function videoLiked(data){
        if(data.status == 200){
            imageOn.classList.toggle('imageBlue2');
            if(imageOff.classList.contains('dislikeBlue2')){
                imageOff.classList.remove('dislikeBlue2');
            }
        }
    }
    
    like.onclick = function() {
        likeEvent.status = !likeEvent.status;
        ajaxRequest('/learning/video-liked', likeEvent, null, videoLiked);
    };
    
    dislike.onmouseover = function() {
        imageOff.classList.add('dislikeBlue');
        imageOff.classList.remove('dislikeGray');
    };

    dislike.onmouseleave = function() {
        imageOff.classList.add('dislikeGray');
        imageOff.classList.remove('dislikeBlue');
    };
    
    function videoDisliked(data){
        if(data.status == 200){
            imageOff.classList.toggle('dislikeBlue2');
            if(imageOn.classList.contains('imageBlue2')){
                imageOn.classList.remove('imageBlue2');
            }
        }
    }

    dislike.onclick = function() {
        dislikeEvent.status = !dislikeEvent.status;
        ajaxRequest('/learning/video-liked', dislikeEvent, null, videoDisliked);
    };
    
    
    var tags = [];
    var tags_cont = document.getElementById('tags-cont');
    for(var k = 0; k < tags_cont.children.length; k++){
        tags.push(tags_cont.children[k].getAttribute('id'));
    }
    var data = {
        video_id: document.getElementById('cate').getAttribute('data-id'),
        tags_id: tags
    };
    $.ajax({
        method: "POST",
        url : window.location.href,
        data: data,
        async: false,
        success: function(response) {
            if(response.status === 200) {
                var temp1 = $('#top-category-card').html();
                $("#top-category").html(Mustache.render(temp1, response.top_category));
                var temp2 = $('#top-videos-card').html();
                $("#top-videos").html(Mustache.render(temp2, response.top_videos));
                if(response.related_videos.length > 0){
                    var temp3 = $('#related-videos').html();
                    $("#r-videos").html(Mustache.render(temp3, response.related_videos));
                }else{
                    document.getElementById('related-videos-cont').remove();
                }
                if(response.interested_videos.length > 0){
                    var temp4 = $('#interested-topics-card').html();
                    $("#i-videos").html(Mustache.render(temp4, response.interested_videos));
                }else{
                    document.getElementById('interested-cont').remove();
                }
                utilities.initials();
            }
        }
    });
    
    $.ajax({
        type: 'POST',
        url: '/learning/get-parent-comments',
        async: false,
        data: {
            param: window.location.pathname.split('/')[3]
        },
        success: function(response){

            if(response.status == 200){
                var temp1 = document.getElementById("replytemp").innerHTML;
                var output = Mustache.render(temp1, response.result);
                utilities.initials();
                var a = document.getElementById("activecomments");
                a.innerHTML += output;
            }
        }
    })    
    
    $(document).on('click', '#smoreBtn', function(){
        document.getElementById('less-des').style.display = 'none';
        document.getElementById('smoreBtn').style.display = 'none';
        document.getElementById('show-more-content').classList.remove('hidden');
    })

    $(document).on('click', '#sendComment', function(){
       var toLogin= $('#user_id').val();
        if(!toLogin){
            $('#loginModal').modal('show');
            return false;
        }
        var comment = document.getElementById('commentArea').value;

        if (comment == "") {
            document.getElementById("commentArea").classList.add("errorClass");
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/learning/parent-comment',
            async: false,
            data: {
                param: window.location.pathname.split('/')[3],
                comment: comment
            },
            success: function (response) {
                result = {};
                if (response.user_info.logo) {
                    result['img'] = response.user_info.path;
                } else {
                    result['img'] = false;
                }

                result['color'] = response.user_info.color;
                result['name'] = response.user_info.name;
                result['reply'] = comment;
                result['hasChild'] = false;
                result['comment_enc_id'] = response.user_info.comment_enc_id;
                result['username'] = response.user_info.username;

                if (response.status == 200) {
                    var temp1 = document.getElementById("replytemp").innerHTML;
                    var output = Mustache.render(temp1, result);
                    utilities.initials();
                    var a = document.getElementById("activecomments");
                    a.innerHTML += output;

                    document.getElementById("commentArea").classList.remove("errorClass");
                    document.getElementById("postComm").reset();
                }
            }
        }) 
    });
    utilities.initials();

JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script src="https://www.youtube.com/iframe_api" type="text/javascript"></script>
<script>
    var player;
    var video_id = document.getElementById('video-id').getAttribute('value');
    var incrementTime = document.getElementById('video-duration').getAttribute('value') * 60 * 1000;

    var dvar;
    function startTimer(){
        dvar = setTimeout(
            function(){
                $.ajax({
                    type: 'POST',
                    url: '/learning/increment-views',
                    data: {
                        param: window.location.pathname.split('/')[3],
                    }
                })
            },
            incrementTime
        )
    }

    function stopTimer(){
        clearTimeout(dvar);
    }

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('ytplayer', {
            height: '390',
            width: '640',
            videoId: video_id,
            events: {
                'onStateChange': function(event) {
                    if (event.data == YT.PlayerState.PLAYING) {
                        startTimer();
                    }
                    if (event.data == YT.PlayerState.PAUSED) {
                        stopTimer();
                    }
                }
            }
        });
    }

    onYouTubeIframeAPIReady();

    function getQueryStringValue(key) {
        return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
    }

    function showShare() {
        var a = document.getElementById('Fader');
        if (a.classList.contains('fadeout')) {
            a.classList.remove('fadeout');
            a.classList.add('fadein');
        } else {
            a.classList.remove('fadein');
            a.classList.add('fadeout');
        }
    }

    var hasPushed = false;

    function addReply(t) {
        var r = document.getElementsByClassName("cboxRemove");
        for (var i = 0; i < r.length; i++) {
            r[i].remove();
        }
        if (!hasPushed) {
            hasPushed = !hasPushed;

            var temp2 = document.getElementById("commentbox").innerHTML;
            var output = Mustache.render(temp2);
            utilities.initials();
            var art = t.closest(".blog-comm");

            if(art.querySelectorAll('.reply-comm')[0]) {
                var a = document.createElement('div');
                a.innerHTML = output;
                art.querySelectorAll('.reply-comm')[0].prepend(a);
            }else {
                var a = document.createElement('div');
                a.innerHTML = output;
                var el = t.parentElement;
                while (el.className != 'blog-comm') {
                    el = el.parentElement;
                }
                var parent_id = el.getAttribute('data-id');
                if(document.getElementById(parent_id)) {
                    if (!document.getElementById(parent_id).classList.contains('hidden')) {
                        document.getElementById(parent_id).parentNode.parentNode.prepend(a);
                    }
                }else{
                    art.innerHTML += output;
                }
            }

            hasPushed = !hasPushed;
        }
    }

    function closeComm(t) {
        var r = document.getElementsByClassName("cboxRemove");
        r[0].remove();
    }

    function addDynamicComment(t) {
        var toLogin= $('#user_id').val();
        if(!toLogin){
            $('#loginModal').modal('show');
            return false;
        }

        var reply = t.closest('div').parentNode.querySelector('textarea').value;

        if (reply == "") {
            document.getElementById("commentReply").classList.add("errorClass");
            return;
        }

        var el = t.parentElement;
        while (el.className != 'blog-comm') {
            el = el.parentElement;
        }
        var parent_id = el.getAttribute('data-id');

        $.ajax({
            type: 'POST',
            url: '/learning/child-comment',
            async: false,
            data: {
                param: window.location.pathname.split('/')[3],
                reply: reply,
                parent_id: parent_id
            },
            success: function (response) {
                if (response.status == 200) {
                    result = {};
                    if (response.user_info.logo) {
                        result['img'] = response.user_info.path;
                    } else {
                        result['img'] = false;
                    }

                    result['color'] = response.user_info.color;
                    result['name'] = response.user_info.name;
                    result['reply'] = reply;
                    result['comment_enc_id'] = response.user_info.comment_enc_id;
                    result['username'] = response.user_info.username;

                    var temp1 = document.getElementById("comtemp").innerHTML;
                    var output = Mustache.render(temp1, result);
                    utilities.initials();
                    var art = t.closest(".blog-comm");

                    if(art.querySelectorAll('.reply-comm')[0]) {
                        var a = document.createElement('div');
                        a.innerHTML = output;
                        art.querySelectorAll('.reply-comm')[0].prepend(a);
                    }else {
                        var a = document.createElement('div');
                        a.innerHTML = output;

                        if(document.getElementById(parent_id)) {
                            if (!document.getElementById(parent_id).classList.contains('hidden')) {

                                art.querySelector('#dyn-comm').append(a);
                            }
                        }else{
                            art.innerHTML += output;
                        }
                    }

                    document.getElementsByClassName('cboxRemove')[0].remove();
                }
            }
        });
    }

    function viewMoreReplies(t) {
        var el = t.parentElement;
        while (el.className != 'blog-comm') {
            el = el.parentElement;
        }
        var parent_id = el.getAttribute('data-id');

        $.ajax({
            type: 'POST',
            url: '/learning/get-child-comments',
            data: {
                parent: parent_id,
                param: window.location.pathname.split('/')[3],
            },
            success: function (response) {
                if (response.status == 200) {
                    var art = t.closest(".blog-comm");
                    art.querySelectorAll('.reply-comm').forEach(function (d) {
                        d.remove();
                    });

                    var temp1 = document.getElementById("comtemp").innerHTML;
                    var output = Mustache.render(temp1, response.result);
                    utilities.initials();

                    el.innerHTML += output;
                    document.getElementById(parent_id).classList.add('hidden');
                }
            }
        })
    }

</script>
<script id="replytemp" type="text/template">
    {{#.}}
    <article class="blog-comm" data-id="{{comment_enc_id}}">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="col-md-2 col-xs-3">
                    <div class="comment-icon">
                        {{#img}}
                        <img src="{{img}}">
                        {{/img}}
                        {{^img}}
                        <canvas class="user-icon" name="{{name}}" color="{{color}}" width="70" height="70"
                                font="40px"></canvas>
                        {{/img}}
                    </div>
                </div>
                <div class="col-md-10 col-xs-9">
                    <div class="comment">
                        <div class="comment-name" id="{{username}}">{{name}}</div>
                        <div class="comment-text">
                            {{reply}}
                        </div>
                    </div>

                    <div class="reply">
                        <button class="replyButton" onclick="addReply(this)"><i class="fa fa-reply"></i> Reply</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="dyn-comm"></div>
        {{#hasChild}}
        <div class="showReply">
            <div class="srBtn">
                <button type="button" id="{{comment_enc_id}}" onclick="viewMoreReplies(this)">View Replies</button>
            </div>
        </div>
        {{/hasChild}}
    </article>
    {{/.}}
</script>
<script id="comtemp" type="text/template">
    {{#.}}
    <article class="reply-comm">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="col-md-2 col-xs-3">
                    <div class="comment-icon">
                        {{#img}}
                        <img src="{{img}}">
                        {{/img}}
                        {{^img}}
                        <canvas class="user-icon" name="{{name}}" color="{{color}}" width="70" height="70"
                                font="40px"></canvas>
                        {{/img}}
                    </div>
                </div>
                <div class="col-md-10 col-xs-9">
                    <div class="comment">
                        <div class="comment-name" id="{{username}}">{{name}}</div>
                        <div class="comment-text">
                            {{reply}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
    {{/.}}
</script>
<script id="commentbox" type="text/template">
    <div class="row cboxRemove">
        <div class="col-md-10 col-md-offset-2">
            <div class="reply-comment">
                <div class="col-md-12">
                    <form>
                        <textarea id="commentReply" class="repComment"></textarea>
                        <div class="comment-sub1">
                            <button type="button" class="addComment" onclick="addDynamicComment(this)">Comment</button>
                            <button type="button" class="closeComment1" onclick="closeComm(this)">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</script>
<script id="top-category-card" type="text/template">
    <div class="tg-widget tg-widgetcategories">
        <div class="tg-widgetcontent">
            <div class="row">
                <div class="col-md-12">
                    <ul id="top-categories">
                        {{#.}}
                        <li>
                            <a href="/learning/videos/category/{{slug}}"><span>{{parent_name}}</span>
                                {{cnt}} </a></li>
                        {{/.}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</script>
<script id="top-videos-card" type="text/template">
    {{#.}}
    <div class="col-md-12 col-sm-4">
        <div class="video-container2">
            <a href="/learning/video/{{slug}}">
                <div class="video-icon2">
                    <img src="{{cover_image}}" alt="Cover Image">
                </div>
                <div class="r-video2">
                    <div class="r-v-name">{{title}}</div>
                </div>
            </a>
        </div>
    </div>
    {{/.}}
</script>
<script id="related-videos" type="text/template">
    {{#.}}
    <div class="col-md-12 col-sm-4">
        <div class="related-video-box">
            <a href="/learning/video/{{slug}}">
                <div class="row">
                    <div class="col-md-5">
                        <div class="re-v-icon">
                            <img src="{{cover_image}}">
                        </div>
                    </div>
                    <div class="col-md-7 padd-left-0">
                        <div class="re-v-name">{{title}}</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    {{/.}}
</script>
<script id="interested-topics-card" type="text/template">
    {{#.}}
    <div class="col-md-3 col-sm-4">
        <div class="video-container">
            <a href="/skills/video/{{slug}}">
                <div class="video-icon">
                    <img src="{{cover_image}}" alt="Cover Image">
                </div>
                <div class="r-video">
                    <div class="r-v-name">{{title}}</div>
                </div>
            </a>
        </div>
    </div>
    {{/.}}
</script>