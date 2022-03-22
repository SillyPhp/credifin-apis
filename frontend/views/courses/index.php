<?php
$this->params['header_dark'] = false;
$this->title = "Acquire And Find Best Courses From Top Institutes";
use yii\helpers\Url;

$keywords = "Best Courses from Top Institutes,  ";

$description = "Learn anything , anytime , Acquire and find best courses from top institutes";

$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/images/fb-image.png');

$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::to(Yii::$app->request->url,'https'),
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
        'og:url' => Url::to(Yii::$app->request->url,'https'),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>
    <section style="background: #061540;">
        <div class="container headsec">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="newlogoset">
                        <div class="main-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/courses/coursescvr.png'); ?>" align="right"
                                 class="responsive"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 topp-pad">
                    <div class="main-heading-set">
                        <div class="min-heading">Learn anything, anytime, anywhere</div>
                        <div class="jumbo-heading">Acquire and Find best courses from top institutes</div>
                        <div class="search-box1">
                            <form action="<?= Url::to('/courses/courses-list') ?>">
                                <input type="text" placeholder="Search" name="keyword" id="get-courses-list">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="heading-style">Courses By Category</div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="popular-cate" id="categories"></div>
                </div>
            </div>
        </div>
    </section>

<?php
if($data = Yii::$app->webinarSlides->check()) {
    echo $this->render('/webinars/webinar-carousel', [
        'webinars'=>$data,
    ]);
}
?>

    <section class="popular-skills">
        <h3>Popular Categories</h3>
        <div class="container" id="popular-category"></div>
    </section>

<!--    <section>-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="heading-style">Top Course Provider</div>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="col-md-2 col-sm-3 col-xs-6">-->
<!--                    <div class="p-parent">-->
<!--                        <div class="p-logo">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/courses/udemy.png'); ?><!--" align="right"-->
<!--                                 class="responsive"/>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-2 col-sm-3 col-xs-6">-->
<!--                    <div class="p-parent">-->
<!--                        <div class="p-logo">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/courses/coursera-vector-logo.png'); ?><!--"-->
<!--                                 align="right"-->
<!--                                 class="responsive"/>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-2 col-sm-3 col-xs-6">-->
<!--                    <div class="p-parent">-->
<!--                        <div class="p-logo">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/courses/Udacity_logo.png'); ?><!--" align="right"-->
<!--                                 class="responsive"/>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6 p-0">
                    <div class="heading-style">Courses</div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="type-1">
                        <div>
                            <a href="<?= Url::to('/courses/courses-list'); ?>" class="btn btn-3">
                                <span class="txt-v"><?= Yii::t('frontend', 'View all'); ?></span>
                                <span class="round"><i class="fas fa-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="card-main"></div>
        </div>
    </section>

<?php if (!empty($popular_videos)) { ?>
    <div class="container">
        <div class="row">
            <div class="heading-style">Free Learning Videos</div>
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

    <!--Subscribe Widget start-->
<?php
if (Yii::$app->user->isGuest) {
    echo $this->render('/widgets/subscribe-section');
}
?>
    <!--Subscribe Widget ends-->

    <script id="courses-categories" type="text/template">
        {{#.}}
        <div class="col-md-2 col-sm-4 col-xs-6 pc-main">
            <a href="/courses/courses-list?cat={{title}}">
                <div class="newset">
                    <div class="imag">
                        <img src="/assets/themes/ey/images/pages/learning-corner/{{icon_name}}.png" alt="{{title}}"/>
                    </div>
                    <div class="txt">{{title}}</div>
                </div>
            </a>
        </div>
        {{/.}}
    </script>
<?php
echo $this->render('/widgets/mustache/courses-card');
$this->registerCss('
.type-1 .txt-v {
    font-size: 14px;
    line-height: 1.45;
}
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
    width: 47%;
  }
}
@media (max-width: 768px) {
  #mixedSlider .MS-content .item {
    width: 49%;
    margin:0px;
  }
}
@media (max-width: 550px) {
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
  text-decoration: none;
}

/*video slider css starts*/
.lc-single-item-main {
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
    margin: 0 0 0.25rem 15px;
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

.p-parent {
    border: 2px solid transparent;
    padding: 28px 15px;
    box-shadow: 0 0 16px 0px #eee;
    border-radius: 5px;
    margin-bottom:15px;
}
.p-logo {
    width: 120px;
    margin: auto;
    height: 65px;
}
//.p-name {
//    text-align: center;
//    font-size: 16px;
//    font-family: roboto;
//    text-transform:uppercase;
//    font-weight:500;
//}
/*---Categories css start---*/
.cat-padding{
    padding-top:20px;
}
.newset{
    text-align:center;
    max-width: 160px;
    line-height: 210px;
    position: relative;
    width:100%;
    margin-bottom:20px !important;
    margin:0 auto;
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
/*---Categories css end---*/
.topp-pad{
    margin-top: 80px !important;
}
.newlogoset{
    max-width:500px;
    margin: 0 auto;
    position:relative;
}
.main-img {
    position: relative;
    display: inline-block;
    z-index: 9;
    margin-bottom: 10px;
    margin-top:20px;
}
.main-heading-set {
    display: block;
    z-index: 9;
    position: relative;
    padding-top: 55px;
}
.min-heading {
    color: #fff;
    text-transform: uppercase;
    border-left: 3px solid #ff7803;
    padding-left: 10px;
    font-weight: 500;
    font-size: 11px;
    font-family: roboto;
    letter-spacing: 1px;
}
.jumbo-heading {
    font-size: 40px;
    font-weight: bold;
    font-family: roboto;
    text-transform: capitalize;
    color: #fff;
}
.search-box1{
    max-width:500px;
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
    width: calc(100% - 38px);
}
.search-box1 .search_init input{
    width: 100%;
}
.search_init{
    width: calc(100% - 38px);
}
.search-box1 input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
.search-box1 button {
    float: right;
    width:38px;
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
.newlogoset img{
    width:100%;
    height:100%;
}
.pro-box{
    border:1px solid #eee;
    text-align:center;
    box-shadow: 0px 0px 8px 0px #eee;
    margin-bottom: 20px;
    background: #fff;
    transition: all 250ms ease-out, transform 250ms ease-out, -webkit-transform 250ms ease-out;
    border-radius: 4px;
    cursor: pointer;
}
.pro-box:hover{
    transform: translate3d(0, -3px, 0);
    box-shadow: 0px 7px 13px rgba(0, 0, 0, 0.14);
}
.pro-logo{
    width: 100px;
    margin: 0 auto;
    margin-top: 20px;
    height: 100px;
    line-height: 100px;
    text-align: center;
}
.pro-logo img{
    width: auto;
    height: auto;
    max-height: 100px;
    max-width: 100px;
}
.pro-name{
    text-transform:capitalize;
    text-align: center;
    padding: 5px 5px 5px 5px;
    font-size: 16px;
    font-weight: 500;
    font-family: roboto;
    position: relative;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 65px;
}
.set-padding-col{
    padding:0px 3px !important;
}
.popular-skills {
    padding: 20px 20px 40px 20px;
    background-image: linear-gradient(98deg, #ba0803, #c2582b);
    margin-top:30px;
}
.popular-skills h3 {
    color:#ef9f89;
    font-size: 29px;
    text-align: center;
}
.popular-skills .popular-cards {
    text-align: center;
    display: inline-block;
    width: 23.6%;
    margin: 5px;
}
.popular-skills .popular-cards a {
    color: white;
    display: block;
    padding: 15px;
    background: #ffffff36;
    text-align: left;
    transition: all 0.3s ease;
}
@media screen and (max-width: 768px){
    .popular-skills .popular-cards a {
        font-size: 11px;
        padding: 12px 9px;
    }
    .popular-skills .popular-cards {
        width: 48%;
        margin: 1px;
    }
    .topp-pad{
        margin-top: 10px !important;
    }
    .jumbo-heading {
        font-size: 28px;
    }
}
@media screen and (max-width: 456px){
    .popular-skills {
        padding: 18px 3px;
        text-align: center;
    }
    .set-padding-col {
        padding: 0px 10px !important;
    }
    .jumbo-heading {
        font-size: 25px;
    }
    .topp-pad{
        margin-top: 10px !important;
    }
    .main-heading-set{
        padding:0px 0px 20px 0px !important;
    }
}
');
$script = <<<JS
browse = {
    navigation_categories:[{"type":"category","icon_name":"development","title":"Development","id":288,"absolute_url":"/courses/development/","title_cleaned":"development","slug":"development"},{"type":"category","icon_name":"business","title":"Business","id":268,"absolute_url":"/courses/business/","title_cleaned":"business","slug":"business"},{"type":"category","icon_name":"finance","title":"Finance & Accounting","id":328,"absolute_url":"/courses/finance-and-accounting/","title_cleaned":"finance-and-accounting","slug":"finance"},{"type":"category","icon_name":"it-and-software","title":"IT & Software","id":294,"absolute_url":"/courses/it-and-software/","title_cleaned":"it-and-software","slug":"it-and-software"},{"type":"category","icon_name":"office-productivity","title":"Office Productivity","id":292,"absolute_url":"/courses/office-productivity/","title_cleaned":"office-productivity","slug":"office-productivity"},{"type":"category","icon_name":"personal-development","title":"Personal Development","id":296,"absolute_url":"/courses/personal-development/","title_cleaned":"personal-development","slug":"personal-development"},{"type":"category","icon_name":"design","title":"Design","id":269,"absolute_url":"/courses/design/","title_cleaned":"design","slug":"design"},{"type":"category","icon_name":"marketing","title":"Marketing","id":290,"absolute_url":"/courses/marketing/","title_cleaned":"marketing","slug":"marketing"},{"type":"category","icon_name":"lifestyle","title":"Lifestyle","id":274,"absolute_url":"/courses/lifestyle/","title_cleaned":"lifestyle","slug":"lifestyle"},{"type":"category","icon_name":"photography","title":"Photography","id":273,"absolute_url":"/courses/photography/","title_cleaned":"photography","slug":"photography"},{"type":"category","icon_name":"health-and-fitness","title":"Health & Fitness","id":276,"absolute_url":"/courses/health-and-fitness/","title_cleaned":"health-and-fitness","slug":"health-and-fitness"},{"type":"category","icon_name":"music","title":"Music","id":278,"absolute_url":"/courses/music/","title_cleaned":"music","slug":"music"},{"type":"category","icon_name":"academics","title":"Teaching & Academics","id":300,"absolute_url":"/courses/teaching-and-academics/","title_cleaned":"teaching-and-academics","slug":"academics"}]
};
var i_list = [];
var count_list = 8;
for(var a=0;a<count_list;a++){
    var index = Math.floor(Math.random() * browse.navigation_categories.length);
    var raw_html = '<div class="popular-cards"><a href="/courses/courses-list?cat=' + browse.navigation_categories[index].title + '">' + browse.navigation_categories[index].title + '</a></div>';
    if(!i_list.includes(index)){
        i_list.push(index);
        $('#popular-category').append(raw_html);
    } else{
        count_list++;
    }
}
var categories_template = $('#courses-categories').html();
$("#categories").html(Mustache.render(categories_template, browse.navigation_categories));
$.ajax({
    method: "POST",
    url : window.location.href,
    success: function(response) {
            response = JSON.parse(response);
        if(response.detail == "Not found.") {
            console.log('cards not found');
        } else{
            var template = $('#course-card').html();
            var rendered = Mustache.render(template,response.results);
            $('#card-main').append(rendered);
            $('.c-author').each(function() {
                var strVal = $.trim($(this).text());
                var lastChar = strVal.slice(-1);
                if (lastChar == ',') { // check last character is string
                    strVal = strVal.slice(0, -1); // trim last character
                    $(this).text(strVal);
                }
            });
        }
    }
});
initializeSearch('#get-courses-list', "/courses/search?q=");
JS;
$this->registerJs($script);
$this->registerCssFile('/assets/themes/search/css/main.css');
$this->registerJsFile('/assets/themes/search/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
