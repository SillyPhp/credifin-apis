<?php
$this->title = Yii::t('frontend', 'Quizzes');
$this->params['header_dark'] = false;

use yii\helpers\Url;

$keywords = 'Cricket Quiz, World Cup Quiz, Football Quiz, World Cup, WomenFootball Quiz, Cricket, Football';
$description = 'It Will Helps You To Know More About The Sports. All The Facts Are Available In Enjoyable Way To Make You Vigilant About Sports In The Form Of Quiz.';
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/common/logos/empower_fb.png');
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
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
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>
    <section class="quiz-header">
        <div class="container">
            <div class="header-main-icon ani-img">
                <img src="<?= Url::to('@eyAssets/images/pages/quiz/quizh.png');?>"/>
            </div>
            <div class="ani-img left-top"><img src="<?= Url::to('@eyAssets/images/pages/quiz/q1.png');?>"/></div>
            <div class="ani-img left-middle"><img src="<?= Url::to('@eyAssets/images/pages/quiz/q2.png');?>"/></div>
            <div class="ani-img left-bottom"><img src="<?= Url::to('@eyAssets/images/pages/quiz/q3.png');?>"/></div>
            <div class="ani-img right-top"><img src="<?= Url::to('@eyAssets/images/pages/quiz/q4.png');?>"/></div>
            <div class="ani-img right-middle"><img src="<?= Url::to('@eyAssets/images/pages/quiz/q5.png');?>"/></div>
            <div class="ani-img right-bottom"><img src="<?= Url::to('@eyAssets/images/pages/quiz/q6.png');?>"/></div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">All Quizzes</div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($data as $d) { ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="quiz-box">
                            <div class="quiz-icon">
                                <img src="<?= Yii::$app->params->upload_directories->quiz->sharing->image . "/" . $d['sharing_image_location'] . "/" . $d['sharing_image'] ?>">
                            </div>
                            <div class="quiz-title">
                                <?= $d['name']; ?>
                            </div>
                            <div class="quiz-ques">
                                Total Questions : <?= $d['cnt']; ?>
                            </div>

                            <div class="take-quiz">
                                <a href="<?= $d['slug']; ?>">Take Quiz</a>
                            </div>
                            <div class="quiz-social-links">
                                <ul class="menu-sl bottomRight">
                                    <li class="share-sl top">
                                        <i class="fa fa-share-alt"></i>
                                        <ul class="submenu">
                                            <li><a href="<?= Url::to('http://www.facebook.com/sharer.php?u=' . $d['slug']);?>" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i></a></li>
                                            <li><a href="<?= Url::to('https://twitter.com/intent/tweet?text=' . $d['slug']);?>" target="_blank" class="twitter"><i class="fab fa-twitter"></i></a></li>
                                            <li><a href="<?= Url::to('mailto:?&body=' . $d['slug']);?>" target="_blank" class="googlePlus"><i class="far fa-envelope"></i></a></li>
                                            <li id="elem-button-share-quiz-wa"><a href="<?= Url::to('https://wa.me/?text=' . $d['slug']);?>" target="_blank" class="whatsapp"><i class="fab fa-whatsapp"></i></a></li>
                                            <li id="elem-button-share-quiz-wa-mob"><a href="<?= Url::to('whatsapp://send?text=' . $d['slug']);?>" target="_blank" data-action="share/whatsapp/share" class="whatsapp"><i class="fab fa-whatsapp"></i></a></li>
                                        </ul>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.header-main-icon{
    left:50%;
    transform:translate(-50%, -50%);
    width: 75%;
    max-width: 600px;
}
.header-main-icon.active{
    top:50%;
    animation:main_icon 2s forwards;
    -webkit-animation:main_icon 2s forwards;
}
.ani-img {
    position:absolute;
    opacity:0;
}
.left-top.active{
    top: 12%;
    right: 87vw;
    animation:left_top 2s forwards;
    -webkit-animation:left_top 2s forwards;
}
.left-middle.active{
    top: 40%;
    right: 87vw;
    animation:left_middle 3s forwards;
    -webkit-animation:left_middle 3s forwards;
}
.left-bottom.active{
    top: 70%;
    right: 87vw;
    animation:left_bottom 4s forwards;
    -webkit-animation:left_bottom 4s forwards;
}
.right-top.active{
    left: 85vw;
    top: 12%;
    animation:right_top 2s forwards;
    -webkit-animation:right_top 2s forwards;
}
.right-middle.active{
    left: 85vw;
    top: 41%;
    animation:right_middle 3s forwards;
    -webkit-animation:right_middle 3s forwards;
}
.right-bottom.active{
    left: 85vw;
    top: 73%;
    animation:right_bottom 4s forwards;
    -webkit-animation:right_bottom 4s forwards;
}
@keyframes main_icon{
    from{opacity:0;top:100%}
    to{opacity:1;top:50%;}
}@-webkit-keyframes main_icon{
    from{opacity:0;top:100%}
    to{opacity:1;top:50%;}   
}
@keyframes left_top{
    from{opacity:0;right:100%}
    to{opacity:1;right:87vw;}
}@-webkit-keyframes left_top{
    from{opacity:0;right:100%}
    to{opacity:1;right:87vw;}   
}

@keyframes left_middle{
    from{opacity:0;right:100%}
    to{opacity:1;right:87vw;}
}@-webkit-keyframes middle{
    from{opacity:0;right:100%}
    to{opacity:1;right:87vw;}   
}

@keyframes left_bottom{
    from{opacity:0;right:100%}
    to{opacity:1;right:87vw;}
}@-webkit-keyframes left_bottom{
    from{opacity:0;right:100%}
    to{opacity:1;right:87vw;}   
}

@keyframes right_top{
    from{opacity:0;left:100%}
    to{opacity:1;left:85vw;}
}@-webkit-keyframes right_top{
    from{opacity:0;left:100%}
    to{opacity:1;left:85vw;}   
}

@keyframes right_middle{
    from{opacity:0;left:100%}
    to{opacity:1;left:85vw;}
}@-webkit-keyframes right_middle{
    from{opacity:0;left:100%}
    to{opacity:1;left:85vw;}   
}

@keyframes right_bottom{
    from{opacity:0;left:100%}
    to{opacity:1;left:85vw;}
}@-webkit-keyframes bottom{
    from{opacity:0;left:100%}
    to{opacity:1;left:85vw;}   
}
@media screen and (max-width: 991px) {
    #elem-button-share-quiz-wa{display:none !important;}
}
@media screen and (min-width: 991px) {
    #elem-button-share-quiz-wa-mob{display:none !important;}
}

.menu-sl {
  z-index: 999;
  position: absolute;
  padding: 0;
  margin: 0;
  list-style-type: none;
}
.menu-sl .share-sl i.fa {
  height: 0px;
  width: 0px;
  text-align: center;
  line-height: 50px;
  background-color: #fff;
  border-radius: 2px;
}
.quiz-box:hover .quiz-social-links .menu-sl .share-sl.top .submenu li:nth-child(1) {
  opacity: 1;
  top: -20px;
  left: 0px;
  background:#fff;
  border-radius:50%;
  padding:5px 10px;
  box-shadow:0 0 5px rgba(0,0,0,.1);
  transition-delay: 0.08s;
  transform: rotateY(0deg);
  background-color: #236dce;
//  border-bottom: 1px dashed #d9d9d9;
}
.quiz-box:hover .quiz-social-links .menu-sl .share-sl.top .submenu li:nth-child(2) {
  opacity: 1;
  top: -56px;
  left:0px;
   background:#fff;
  border-radius:50%;
  padding:5px 10px;
   box-shadow:0 0 5px rgba(0,0,0,.1);
  transition-delay: 0.16s;
  transform: rotateY(0deg);
  background-color: #1c99e9;
//  border-bottom: 1px dashed #d9d9d9;
}
.quiz-box:hover .quiz-social-links .menu-sl .share-sl.top .submenu li:nth-child(3) {
  opacity: 1;
  top: -92px;
  left:0px;
   background:#fff;
  border-radius:50%;
  padding:5px 10px;
   box-shadow:0 0 5px rgba(0,0,0,.1);
  transition-delay: 0.24s;
  transform: rotateY(0deg);
  background-color: #D3252B;
//  border-bottom: 1px dashed #d9d9d9;
}
.quiz-box:hover .quiz-social-links .menu-sl .share-sl.top .submenu li:nth-child(4) {
  opacity: 1;
  top: -128px;
  left:0px;
   background:#fff;
  border-radius:50%;
   box-shadow:0 0 5px rgba(0,0,0,.1);
  padding:5px 10px;
  transition-delay: 0.32s;
  transform: rotateY(0deg);
  background-color: #25D366;
//  border-bottom: 1px dashed #d9d9d9;
}
.quiz-box:hover .quiz-social-links .menu-sl .share-sl.top .submenu li:nth-child(5) {
  opacity: 1;
  top: -128px;
  left:0px;
  background:#fff;
  border-radius:50%;
  box-shadow:0 0 5px rgba(0,0,0,.1);
  padding:5px 10px;
  transition-delay: 0.32s;
  transform: rotateY(0deg);
  background-color: #25D366;
}
.menu-sl.bottomRight {
  bottom: 5px;
  right: 35px;
}
.menu-sl .submenu {
  list-style-type: none;
  padding: 0;
  margin: 0;
}
.menu-sl .submenu li {
  transition: all ease-in-out 0.5s;
  position: absolute;
  top: 0;
  left: 0;
  z-index: -1;
  width: 34px;
  height: 34px;
  opacity: 0;
}
.share-sl.top{
    height: 40px;
    margin-left: 10px;
}
.menu-sl .submenu li a {
  color: #fff;
}
.menu-sl .submenu li:nth-child(1) {
  transform: rotateX(45deg);
}
.menu-sl .submenu li:nth-child(2) {
  transform: rotateX(90deg);
}
.menu-sl .submenu li:nth-child(3) {
  transform: rotateX(135deg);
}
.menu-sl .submenu li:nth-child(4) {
  transform: rotateX(180deg);
}
.menu-sl .submenu li:nth-child(5) {
  transform: rotateX(180deg);
}

.quiz-header{
     background-color: red; /* For browsers that do not support gradients */
    background-image: linear-gradient(to bottom right, #0DCBC8, #6774FF);
     min-height:550px;
}
.quiz-box{
    text-align: center;
    box-shadow:0 0 10px rgba(0,0,0,.1);
    border-radius: 10px;
    margin-bottom: 20px;
    display:block;
    color:#000;
    position:relative;
}
.quiz-box:hover{
    box-shadow:0 0 10px rgba(0,0,0,.2);
    transform: translate3d(-3px, -3px, -3px);
    transition: .3s ease;
}
.quiz-box:hover .take-quiz a{
    color:#fff;
    background:#00a0e3;
    border-color:#00a0e3;
    transition:.3s ease;
}
.quiz-box:hover .quiz-icon img{
     -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1; 
}
.quiz-icon{
    width:100%;
    height:150px;
    overflow:hidden;
     border-radius:5px 5px 0 0; 
    position:relative;  
}
.quiz-icon img{
    border-radius:10px 10px 0 0;
    -webkit-transform: scale(1);
    transform: scale(1);
    -webkit-transition: .3s ease-in-out;
    transition: .3s ease-in-out;  
    opacity: 1;
    display: block;
    width: 100%;
    height: 100%;
    transition: .5s ease;
    backface-visibility: hidden;
}
.quiz-title{
    font-size:15px;
    font-weight:bold;
    padding-top: 10px;
    font-family:lora;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 60px;
}
.quiz-ques{
    line-height: 13px;
    padding-top: 5px;   
}
.take-quiz{
    overflow: hidden;
    padding: 20px 0 20px 0;
}
.take-quiz a{
    border:1px solid #eee;
    padding: 8px 13px;
    border-radius:5px;
    font-size:13px;    
}
.take-quiz a:hover{
    color:#fff;
    background:#00a0e3;
    border-color:#00a0e3;
    transition:.3s ease;
}
');
$script = <<<JS
setTimeout(function(){
    $('.ani-img').each(function(){
        $(this).addClass('active');
    });
  },1000);
JS;
$this->registerJs($script);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
?>