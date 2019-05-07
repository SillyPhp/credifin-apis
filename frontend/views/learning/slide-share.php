<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = true;
?>
<section class="bg-blue">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 color-bg">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="chan-heading">Top Channels</h1>
                    </div>
                </div>
                <div class="trending-posts">
                    <div class="row">
                        <div class="col-md-12 col-sm-4 col-xs-12">
                            <div class="tp-box">
                                <div class="row">
                                    <a href="">
                                        <div class="col-md-5 col-sm-5 col-xs-5 padd-10">
                                            <div class="tp-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-7 col-xs-7 no-padd">
                                            <div class="tp-heading">Sports Channel</div>
                                            <div class="tp-date">8 Videos</div>
                                            <!--<div class="tp-heading">Fashion Model Shoot....</div>-->
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4 col-xs-12">
                            <div class="tp-box">
                                <div class="row">
                                    <a href="">
                                        <div class="col-md-5 col-sm-5 col-xs-5 padd-10">
                                            <div class="tp-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-7 col-xs-7 no-padd">
                                            <div class="tp-heading">Sports Channel</div>
                                            <div class="tp-date">8 Videos</div>
                                            <!--<div class="tp-heading">Fashion Model Shoot....</div>-->
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4 col-xs-12">
                            <div class="tp-box">
                                <div class="row">
                                    <a href="">
                                        <div class="col-md-5 col-sm-5 col-xs-5 padd-10">
                                            <div class="tp-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-7 col-xs-7 no-padd">
                                            <div class="tp-heading">Sports Channel</div>
                                            <div class="tp-date">8 Videos</div>
                                            <!--<div class="tp-heading">Fashion Model Shoot....</div>-->
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4 col-xs-12">
                            <div class="tp-box">
                                <div class="row">
                                    <a href="">
                                        <div class="col-md-5 col-sm-5 col-xs-5 padd-10">
                                            <div class="tp-icon">
                                                <img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-7 col-xs-7 no-padd">
                                            <div class="tp-heading">Sports Channel</div>
                                            <div class="tp-date">8 Videos</div>
                                            <!--<div class="tp-heading">Fashion Model Shoot....</div>-->
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="top-categories">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="chan-heading">Top Categories</h1>
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

            <div class="col-md-7 white-bg">
                <div class="row">
                    <div class="video-frame">
                        <iframe src="//www.slideshare.net/slideshow/embed_code/key/aQw6qVK5Q9rJBE" width="595" height="485" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:1px solid #CCC; border-width:1px; margin-bottom:5px; max-width: 100%;" allowfullscreen> </iframe>
                    </div>
                    <div class="video-options">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="flex-view">
                                    <div class="likebtn">
                                        <button id="like" data-toggle="tooltip" title="Like this">
                                            <span class="imageGray" id="imageOn"></span>
                                        </button>
                                    </div>
                                    <div class="dislikebtn">
                                        <button id="dislike" data-toggle="tooltip" title="Don't like this">
                                            <span class="dislikeGray" id="imageOff"></span>
                                        </button>
                                    </div>

                                    <div class="share-list">
                                        <div class="share">
                                            <button type="button" class="sbtn" onclick="showShare()"><i class="fa fa-share-alt"></i> Share </button></div>
                                        <ul class="s-list fadeout" id="Fader">
                                            <li><a href=""> <i class="fa fa-facebook-f"></i> </a></li>
                                            <li><a href=""> <i class="fa fa-linkedin"></i></a> </li>
                                            <li><a href=""> <i class="fa fa-whatsapp"></i></a> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="flex-view report-btn">
                                    <button type="button"><i class="fa fa-flag"></i> Report</button>
                                </div>
                            </div>
                        </div>
                        <!--                        <div class="row">-->
                        <!--                            <div class="col-md-12">-->
                        <!--                                <div class="n-p-bttns">-->
                        <!--                                    <button type="button">Prev Video</button>-->
                        <!--                                    <button type="button">Next Video</button>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                    <div class="video-details">
                        <div class="v-title">Lorem Ipsum is simply dummy text of the printing and typesetting industry of the
                            printing and typesetting industry
                        </div>
                        <div class="v-category">
                            <ul>
                                <li>Category: <span><a href=""> Web Designing </a></span></li>
                                <li>Sub Category: <span><a href=""> Web Designing</a></span></li>
                            </ul>
                        </div>
                        <div class="v-tags">
                            <ul>
                                <a href=""><li> Web Design</li></a>
                                <a href=""><li> Html</li></a>
                                <a href=""><li> CSS</li></a>
                                <a href=""><li> Bootstrap</li></a>
                            </ul>
                        </div>
                        <div class="row padd-top-40">
                            <div class="col-md-6 col-sm-6">
                                <div class="tp-box">
                                    <div class="row">
                                        <a href="">
                                            <div class="col-md-3 col-sm-3 col-xs-5 padd-10">
                                                <div class="tp-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/blog/wn1.jpg') ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-9 col-sm-9 col-xs-7 no-padd">
                                                <div class="tp-heading">Web Channel</div>
                                                <div class="tp-date">12 Videos</div>
                                                <!--<div class="tp-heading">Fashion Model Shoot....</div>-->
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 align-right">
                                <div class="views"><i class="fa fa-eye"></i> <span>1,200</span> Views</div>
                                <div class="likes"> <span>1,200</span> Likes</div>
                                <div class="comms"><a href="#comments"> <i class="fa fa-comments-o"></i> <span>0</span> Comments </a></div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="v-disc">
                                <p>Scientific research shows this is a great way to immediately increase happiness. You can do it
                                    anywhere and it does not cost anything. Sed ut perspiciatis unde omnis iste natus error sit
                                    voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo
                                    inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam
                                    voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores
                                    eos qui ratione voluptatem sequi nesciunt.</p>
                                <div class="show-more" id="smoreDiv">
                                    <p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit,
                                        sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat
                                        voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit
                                        laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui
                                        in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo
                                        voluptas nulla pariatur. Here are three ways, why they work, and quick tips to use them to put a
                                        smile on your face.</p>
                                </div>
                                <div class="show-more-bttn">
                                    <button type="button" id="smoreBtn">Show More</button>
                                </div>
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
                            <div class="show-more-bttn mar-20">
                                <button type="button">Load More Comments</button>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="chan-heading">You Might Be Interested In</h1>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="video-container">
                                <a href="">
                                    <div class="video-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg')?>" alt="Cover Image">
                                    </div>
                                    <div class="r-video">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                        <div class="r-ch-name">DSB Edu Tech</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="video-container">
                                <a href="">
                                    <div class="video-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-02.jpg')?>" alt="Cover Image">
                                    </div>
                                    <div class="r-video">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                        <div class="r-ch-name">DSB Edu Tech</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="video-container">
                                <a href="">
                                    <div class="video-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/solution-tile-stream.png')?>" alt="Cover Image">
                                    </div>
                                    <div class="r-video">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                        <div class="r-ch-name">DSB Edu Tech</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="video-container">
                                <a href="">
                                    <div class="video-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-01.jpg')?>" alt="Cover Image">
                                    </div>
                                    <div class="r-video">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                        <div class="r-ch-name">DSB Edu Tech</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="video-container">
                                <a href="">
                                    <div class="video-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-02.jpg')?>" alt="Cover Image">
                                    </div>
                                    <div class="r-video">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                        <div class="r-ch-name">DSB Edu Tech</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="video-container">
                                <a href="">
                                    <div class="video-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/solution-tile-stream.png')?>" alt="Cover Image">
                                    </div>
                                    <div class="r-video">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                        <div class="r-ch-name">DSB Edu Tech</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <div class="video-container">
                                <a href="">
                                    <div class="video-icon">
                                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-01.jpg')?>" alt="Cover Image">
                                    </div>
                                    <div class="r-video">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                        <div class="r-ch-name">DSB Edu Tech</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 blue-bg">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="chan-heading">Social Links</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="social-buttons">
                        <a href="#" class="social-buttons__button social-button social-button--facebook" aria-label="Facebook">
<span class="social-button__inner">
 <i class="fa fa-facebook-f"></i>
</span>
                        </a>
                        <a href="#" class="social-buttons__button social-button social-button--linkedin" aria-label="LinkedIn">
<span class="social-button__inner">
 <i class="fa fa-linkedin"></i>
</span>
                        </a>
                        <a href="#" class="social-buttons__button social-button social-button--snapchat" aria-label="SnapChat">
<span class="social-button__inner">
 <i class="fa fa-snapchat-ghost"></i>
</span>
                        </a>
                        <a href="#" class="social-buttons__button social-button social-button--github" aria-label="GitHub">
<span class="social-button__inner">
 <i class="fa fa-github"></i>
</span>
                        </a>
                        <a href="#" class="social-buttons__button social-button social-button--codepen" aria-label="CodePen">
<span class="social-button__inner">
 <i class="fa fa-codepen"></i>
</span>
                        </a>
                    </div>
                </div>
                <div class="top-video">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="chan-heading">Top Videos</h1>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="video-container2">
                                <a href="">
                                    <div class="video-icon2">
                                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg')?>" alt="Cover Image">
                                    </div>
                                    <div class="r-video2">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                        <div class="r-ch-name">DSB Edu Tech</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="video-container2">
                                <a href="">
                                    <div class="video-icon2">
                                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg')?>" alt="Cover Image">
                                    </div>
                                    <div class="r-video2">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text of the printing</div>
                                        <div class="r-ch-name">DSB Edu Tech</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rVideos">
                    <h1 class="chan-heading">Related Videos</h1>
                    <div class="row">
                        <div class="col-md-12 col-sm-4">
                            <div class="related-video-box">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="re-v-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-7 padd-left-0">
                                        <div class="re-v-name">Lorem Ipsum is simply dummy text of the simply dummy text of the printin</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="related-video-box">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="re-v-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-7 padd-left-0">
                                        <div class="re-v-name">Lorem Ipsum is simply dummy text of the simply dummy text of the printin</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="related-video-box">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="re-v-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-7 padd-left-0">
                                        <div class="re-v-name">Lorem Ipsum is simply dummy text of the simply dummy text of the printin</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="related-video-box">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="re-v-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-7 padd-left-0">
                                        <div class="re-v-name">Lorem Ipsum is simply dummy text of the simply dummy text of the printin</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-4">
                            <div class="related-video-box">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="re-v-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png')?>">
                                        </div>
                                    </div>
                                    <div class="col-md-7 padd-left-0">
                                        <div class="re-v-name">Lorem Ipsum is simply dummy text of the simply dummy text of the printin</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
    background:url('. Url::to('@eyAssets/images/pages/learning-corner/dislikeb.png').') !important;
}
.imageGray{
     background:url(' . Url::to('@eyAssets/images/pages/learning-corner/like1.png') . ');
     width:20px;
     height:20px; 
     display:block;
}
.imageBlue{
    background:url('. Url::to('@eyAssets/images/pages/learning-corner/likeb.png').');
     width:20px;
     height:20px; 
     display:block;
}
.imageBlue2{
    background:url('. Url::to('@eyAssets/images/pages/learning-corner/likeb.png').') !important;
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
    height:300px;
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
');

$script = <<<JS
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

var like = document.getElementById('like');
var imageOn = document.getElementById('imageOn'); 
    like.onmouseover = function() {
        imageOn.classList.add('imageBlue');
        imageOn.classList.remove('imageGray');
    } 
    like.onmouseleave = function() {
      imageOn.classList.add('imageGray');
      imageOn.classList.remove('imageBlue');
    }
    like.onclick = function() {
      imageOn.classList.toggle('imageBlue2');
      if(imageOff.classList.contains('dislikeBlue2')){
          imageOff.classList.remove('dislikeBlue2');
      }
    }
    
 var dislike = document.getElementById('dislike');
 var imageOff = document.getElementById('imageOff');
    dislike.onmouseover = function() {
      imageOff.classList.add('dislikeBlue');
      imageOff.classList.remove('dislikeGray');
    }
    dislike.onmouseleave = function() {
      imageOff.classList.add('dislikeGray');
      imageOff.classList.remove('dislikeBlue');
    }
    dislike.onclick = function() {
      imageOff.classList.toggle('dislikeBlue2');
          if(imageOn.classList.contains('imageBlue2')){
              imageOn.classList.remove('imageBlue2');
          }
    }
    
    
    
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<script>
    function showShare(){
        var a = document.getElementById('Fader');
        if(a.classList.contains('fadeout')){
            a.classList.remove('fadeout');
            a.classList.add('fadein');
        }else{
            a.classList.remove('fadein');
            a.classList.add('fadeout');
        }
    }

    document.getElementById('smoreBtn').addEventListener('click', showContent);
    function showContent() {
        var smoreDiv = document.getElementById('smoreDiv');
        if(smoreDiv.style.display === 'none'){
            smoreDiv.style.display = 'block';
            document.getElementById('smoreBtn').innerHTML = 'Show Less';
        }else {
            smoreDiv.style.display = 'none';
            document.getElementById('smoreBtn').innerHTML = 'Show  More';
        }

    }

    function addComment(){
        repliedCommnet={};
        repliedCommnet['img']= '@eyAssets/images/pages/candidate-profile/Girls2.jpg';
        repliedCommnet['name']= 'Shshank';
        repliedCommnet['reply']= document.getElementById("commentArea").value;
        if(repliedCommnet['reply'] == ""){
            document.getElementById("commentArea").classList.add("errorClass");
            return;
        }
        var temp1 = document.getElementById("replytemp").innerHTML;
        var output = Mustache.render(temp1, repliedCommnet);
        var a = document.getElementById("activecomments");
        a.innerHTML += output;
        document.getElementById("commentArea").classList.remove("errorClass");
        document.getElementById("postComm").reset();
    }

    document.getElementById("sendComment").addEventListener('click', addComment);
    var hasPushed = false;
    function addReply(t){
        var r = document.getElementsByClassName("cboxRemove");
        for(var i = 0; i<r.length; i++){
            r[i].remove();
        }
        if(!hasPushed){
            hasPushed=!hasPushed;
            var temp2 = document.getElementById("commentbox").innerHTML;
            var output = Mustache.render(temp2);
            var art = t.closest("article");
            art.innerHTML += output;
            hasPushed = !hasPushed;
        }
    }
    function closeComm(t) {
        var r = document.getElementsByClassName("cboxRemove");
        r[0].remove();
    }


    function addDynamicComment(t){

        repliedCommnet={};
        repliedCommnet['img']= '@eyAssets/images/pages/candidate-profile/Girls2.jpg';
        repliedCommnet['name']= 'Shshank';
        repliedCommnet['reply']= t.closest('div').parentNode.querySelector('textarea').value;
        if (repliedCommnet['reply'] == ""){
            document.getElementById("commentReply").classList.add("errorClass");
            return;
        }
        var temp1 = document.getElementById("comtemp").innerHTML;
        var output = Mustache.render(temp1, repliedCommnet);
        var art = t.closest("article");
        art.innerHTML += output;
        document.getElementsByClassName('cboxRemove')[0].remove();

    }

</script>
<script id="replytemp" type="text/template">
    <article class="blog-comm">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="col-md-2 col-xs-3">
                    <div class="comment-icon">
                        <img src="<?= Url::to('{{img}}') ?>" alt="User Icon">
                    </div>
                </div>
                <div class="col-md-10 col-xs-9">
                    <div class="comment">
                        <div class="comment-name">{{name}}</div>
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
    </article>
</script>
<script id="comtemp" type="text/template">
    <article class="reply-comm">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <div class="col-md-2 col-xs-3">
                    <div class="comment-icon">
                        <img src="<?= Url::to('{{img}}') ?>" alt="User Icon">
                    </div>
                </div>
                <div class="col-md-10 col-xs-9">
                    <div class="comment">
                        <div class="comment-name">{{name}}</div>
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
    </article>
</script>
<script id="commentbox" type="text/template">
    <div class="row cboxRemove">
        <div class="col-md-10 col-md-offset-2">
            <div class="reply-comment">
                <div class="col-md-12">
                    <form>
                        <textarea placeholder="Reply to this comment" id="commentReply" class="repComment" ></textarea>
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