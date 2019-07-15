<?php
$this->params['header_dark'] = false;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<section class="header-image">
    <img src="<?= Url::to('@eyAssets/images/pages/blog/topcompny.png')?>">
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="topblog-heading"><?= $data['title'] ?></div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($data['topOrganizationsBlogsLists'] as $d){ ?>
                    <div class="col-md-12">
                        <div class="top-box">
                            <div class="blog-com-name"><a href=""><?= $d['company_name'] ?></a></div>
                            <div class="com-des">
                                <?= $d['description'] ?>
                            </div>
                            <div class="com-heading">Inside Company</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php foreach ($d['blogInformationEnc']['organizationBlogInformationImages'] as $s) { ?>
                                    <div class="col-md-3 col-sm-6 no-padd">
                                        <div class="inside-image">
                                            <a href="<?= Url::to(Yii::$app->params->upload_directories->organization_blog->image.DIRECTORY_SEPARATOR.$s['image_location'].DIRECTORY_SEPARATOR.$s['image'])?>" data-fancybox="image">
                                                <img src="<?= Url::to(Yii::$app->params->upload_directories->organization_blog->image.DIRECTORY_SEPARATOR.$s['image_location'].DIRECTORY_SEPARATOR.$s['image'])?>">
                                            </a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="com-heading">Job Cards</div>
                            <div class="row">
                                <div class="abc">
                                    <blockquote class="twitter-tweet" data-lang="en"><p lang="hi" dir="ltr">हर कोई चाहता है कि उसका ड्रीम ब्वॉय या ड्रीम गर्ल लविंग, केयरिंग होने के साथ अपने रिश्ते के लिए भी बेहद ईमानदार हो.<a href="https://t.co/g5JpurHms8">https://t.co/g5JpurHms8</a></p>&mdash; आज तक (@aajtak) <a href="https://twitter.com/aajtak/status/1144940423040778240?ref_src=twsrc%5Etfw">June 29, 2019</a></blockquote>
                                    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                </div>
<!--                                <div class="col-md-4 col-sm-4">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/jobs/job-card.png')?><!--">-->
<!--                                </div>-->
<!--                                <div class="col-md-4 col-sm-4">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/jobs/job-card.png')?><!--">-->
<!--                                </div>-->
<!--                                <div class="col-md-4 col-sm-4">-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/jobs/job-card.png')?><!--">-->
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12 col-sm-6">
                        <div class="box">
                            <div class="position-abso-box">
                                <div class="Search">
                                    Searching for a New Job/Internship?
                                </div>
                                <div class="explore">
                                    <a href="/jobs" ><i class="fa fa-paper-plane go"></i>  Explore positions</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading-style">Related Blogs</div>
                        <div class="related-blogs">
                            <div class="">
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
                                            <div class="wn-box-title">Top 10 Relaxing Position For Adult Womens </div>
                                        </a>
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
.header-image img{
    max-height:400px;
    width:100%;
    object-fit:cover;
}

.topblog-heading{
    font-size:30px;
    font-weight:bold;
    font-family:lora;
    color:#000;
}
.inside-image{
    max-width:100%;
    height:150px;
}
.inside-image img{
    width:100%;
    height:100%;
    object-fit:fill;
}
.no-padd{
    padding-left:0px !important;
    padding-right:0px !important;
}
.blog-com-name{
    padding-top:20px;
}
.blog-com-name a{
    font-size:20px;
    font-weight:bold;
    font-family:lora;
    color:#000;
    
}
.blog-com-name a:hover{
    color:#00a0e3;   
}
.com-des{
    padding-top:15px;
    text-align:justify;
    font-size:16px;
}
.com-heading{
    font-size:18px;
    font-family:lora;
    color:#000;
    font-weight:bold;
    padding:15px 0 10px 0;
}

/*---side box jobs----*/
.box {
    width: 100%;
    min-height: 275px;
    border: 1px solid #ccc;
    background-color: #fff;
    position: relative;
//    padding: 0px 20px 0px 20px;
    text-align: center;
    vertical-align: middle;
    box-shadow: 2px 2px 6px rgba(0,0,0,.5);
    font-size: 18px;
    margin-bottom: 15px;
    border-radius: 30px 10px 30px 10px;
    font-family: lora;
    font-weight: 700;
    color: #00a0e3;

}

.box::before,
.box::after {
    content: \'\';
    position: absolute;
    border-color: transparent;
    border-style: solid;
}

.box::before {
    border-radius:0 0 0 10px;
    border-width: 6px;
    border-left-color: #00a0e3;
    border-bottom-color: #00a0e3;
    height: 100px;
    width: 100px;
    left: -1px;
    bottom: -2px;
}

.box::after {
    border-radius:0 10px 0 0px;
    border-width: 6px;
    border-right-color: #ff7803;
    border-top-color: #ff7803;
    top: -1px;
    right: -2px;
    height: 100px;
    width: 100px;
}

.search {
    /*font-size: 1.9vw;*/
    margin: auto;
    padding: auto;
    transform: translate(-50%, -50%);
}

.box a {
    color: white;
    background-color: #4aa1e6;
    border: 1px solid #4aa1e6;
    border-radius: 20px;
    font-size: 17px;
    /*font-size: 1.1vw;*/
    padding: 10px;
    max-width: 206px;
}

.box a:hover {
    background-color: white;
    color: #4aa1e6;
    text-decoration: none;
    transition: .3s all;
}

.explore {
    width: auto;
    font-size: 1.42vw;
    color: white;
    margin: auto;
    padding: 25px;
    border-radius: 20px;
}
.position-abso-box{
    position:absolute;
    width:100%;
    top:50%;
    transform:translateY(-50%);
}

.whats-new-box{
    border-radius:5px;
    margin-bottom:20px;
}
.wn-box-icon{
//    max-width:255px;
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


@media only screen and (max-width:992px){
    .box{
        margin-top: 20px;
    }
}
');
$script = <<<JS

JS;
$this->registerJs($script);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
$this->registerCssFile('@eyAssets/css/jquery.fancybox.min.css');
$this->registerJsFile('@eyAssets/js/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
