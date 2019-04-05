<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<section class="rh-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="search-bar">
                        <input type="text" class="s-input" placeholder="Search Companies, Jobs, Internships, Blogs">
                        <button type="submit" class="s-btn"><i class="fa fa-search"></i> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Companies</div>
            </div>
            <div class="col-md-6">
                <div class="type-1">
                    <div>
                        <a href="<?= Url::to('/jobs/list'); ?>" class="btn btn-3">
                            <span class="txt"><?= Yii::t('frontend', 'View all'); ?></span>
                            <span class="round"><i class="fa fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="com-review-box onestar-box">
                    <div class="com-logo">
                        <img src="<?= Url::to('@commonAssets/logos/logo-vertical.svg') ?>">
                    </div>
                    <div class="com-name">Empower Youth</div>
                    <div class="com-loc"><span>5</span> Jobs</div>
                    <div class="com-dep"><span>5</span> Internships</div>
                    <div class="starr" data-score="3"></div>
                    <div class="rating">
                        <div class="stars">1 </div>
                        <div class="reviews-rate"> of 1.5k review</div>
                    </div>
                    <div class="row">
                        <div class="cm-btns padd-0">
                            <div class="col-md-6">
                                <div class="color-blue">
                                    <a href="">View Profile</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="color-orange">
                                    <a href="">Read Review</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Jobs</div>
            </div>
            <div class="col-md-6">
                <div class="type-1">
                    <div>
                        <a href="<?= Url::to('/jobs/list'); ?>" class="btn btn-3">
                            <span class="txt"><?= Yii::t('frontend', 'View all'); ?></span>
                            <span class="round"><i class="fa fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4 col-sm-12 pt-5">
                <div class="application-card-main">
                    <span class="application-card-type"><i class="fa fa-inr"></i></span>
                    <span class="application-card-type"></span>
                    <div class="col-md-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="">
                                <img src="">
                                <canvas class="user-icon" name="" width="80" height="80"
                                        color="" font="35px"></canvas>
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href=""><h4 class="application-title"></h4></a>
                            <h5 class="location" data-lat="" data-long="" data-locations=""><i
                                    class="fa fa-map-marker"></i>&nbsp;</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                    </h4>
                    <div class="col-md-12">
                        <h4 class="org_name text-right"></h4>
                    </div>
                    <div class="application-card-wrapper">
                        <a href="" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Internships</div>
            </div>
            <div class="col-md-6">
                <div class="type-1">
                    <div>
                        <a href="<?= Url::to('/jobs/list'); ?>" class="btn btn-3">
                            <span class="txt"><?= Yii::t('frontend', 'View all'); ?></span>
                            <span class="round"><i class="fa fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-12 pt-5">
                <div class="application-card-main">
                    <span class="application-card-type"><i class="fa fa-inr"></i></span>
                    <span class="application-card-type"></span>
                    <div class="col-md-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="">
                                <img src="">
                                <canvas class="user-icon" name="" width="80" height="80"
                                        color="" font="35px"></canvas>
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href=""><h4 class="application-title"></h4></a>
                            <h5 class="location" data-lat="" data-long="" data-locations=""><i
                                    class="fa fa-map-marker"></i>&nbsp;</h5>
                            <h5><i class="fa fa-clock-o"></i>&nbsp;</h5>
                        </div>
                    </div>
                    <h6 class="col-md-5 pl-20 custom_set2 text-center">
                        Last Date to Apply
                        <br>
                    </h6>
                    <h4 class="col-md-7 org_name text-right pr-10">
                    </h4>
                    <div class="col-md-12">
                        <h4 class="org_name text-right"></h4>
                    </div>
                    <div class="application-card-wrapper">
                        <a href="" class="application-card-open">View Detail</a>
                        <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="heading-style">Blogs</div>
            </div>
            <div class="col-md-6">
                <div class="type-1">
                    <div>
                        <a href="<?= Url::to('/jobs/list'); ?>" class="btn btn-3">
                            <span class="txt"><?= Yii::t('frontend', 'View all'); ?></span>
                            <span class="round"><i class="fa fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
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
                            <div class="wn-box-title">Top 10 Relaxing Position For Adult Womens </div>
                        </a>
                        <div class="wp-box-des">Consectetur adipisicing elit sed do eiusmod tempor incididunt ut labore
                            et dolore magna aliqua enim ad minim veniam qui.</div>
                        <div class=""><a href="" class="button"><span>View Post</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.search-bar{
    width:100%;
    background:#fff;
    border-radius:10px;
    display:flex;
    padding:5px 5px;
    border:2px solid #eee;
    color:#bcbaba
}
.s-input{
    width:94%;
    padding:10px 15px;
    border:none;
    border-radius:10px;
    color:#bcbaba;
}
input::placeholder{
    color:#bcbaba;
}
form input[type="text"]:focus{
    outline:none;
    border:none !important;
    box-shadow:none;
}
.s-btn{
    width:5%;
     padding:10px 15px;
    border:none;
    background:none;
    color:#bcbaba;
}
.rh-header{
    background-image: linear-gradient(141deg, #65c5e9 0%, #25b7f4 51%, #00a0e3 75%);
    background-size:100% 300px;
    background-repeat: no-repeat;
    padding:60px 0 35px 0;
    color:#fff;
    margin-bottom:20px;
} 
.com-review-box{
    text-align:center;
    border:1px solid #eee;
    padding:20px 0 3px 0;
    margin-bottom:20px;
    border-radius:10px;
    color:#999;
}
.com-review-box:hover{
     box-shadow: 0 0 13px rgba(120, 120, 120, 0.2);
}
.com-logo{
    width:100px;
    height:100px;
    margin:0 auto;
    padding:0 10px;
    border-radius:10px;
    border:2px solid rgba(238,238,238,.5);
    position:relative;
}
.com-logo img{
    max-width:85px;
    position:absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
}
.com-name{
    padding-top: 10px;
    color: #bcbaba;
    font-size: 18px;
    text-transform: capitalize;
}
.rating-stars{
    font-size:20px;
}
.rating{
    display:flex;
    justify-content:center;
    font-size:14px;
}
.stars{
    margin-right:5px;
    color:#00a0e3;
    font-weight:bold;
    font-size:16px;
    margin-top:-2px;
}
.rating-stars i{
    color:#eee;
}
.read-bttn{
    padding-top:15px;
}
.read-bttn a{
    padding:5px 10px;
    background:#999;
    width:100%;
    color:#fff;
    border-radius: 10px 10px 0 0;
}
.read-bttn .vp-bttn a{
     background:#00a0e3;
     border-radius: 0px 0px 0px 10px;
     padding: 5px 20px;
}
.read-bttn .rr-bttn a{
    background:#00a0e3;
     border-radius: 0px 0px 10px 0px;
     padding: 5px 20px;
}
.cm-btns{
    margin-top:10px;
    padding-top:5px;
    border-top:1px solid #eee;
    text-transform: capitalize;
}
.color-blue a{
    color:#bcbaba;
}
.color-blue a:hover{
    color:#00a0e3;
}
.color-orange a{
    color:#bcbaba;
}
.color-orange a:hover{
    color:#ff7803;
}
.padd-0{
    margin-left:15px !important;
    margin-right:15px !important;
}
.whats-new-box{
    border-radius:5px;
    margin-bottom:20px;
}
.what-popular-box:hover, .whats-new-box:hover{
    box-shadow:0 0 15px rgba(73, 72, 72, 0.28);
    transition:.3s all;
}
.what-popular-box:hover .wp-box-icon img, .whats-new-box:hover .wn-box-icon img{
     -webkit-transform: scale(1.1);
    transform: scale(1.1);
    opacity: 1; 
    transition:.3s all;
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
.wp-box-icon{
    width:100%;
    heigth:100%;
    overflow:hidden;
     border-radius:5px 5px 0 0; 
    position:relative;   
}
.wp-box-des{
    padding-top:15px;
    font-size:13px;
}
.btn-3 {
    background-color: #00a0e3;
}
.btn-3 .round {
    background-color: #38b7ec;
}
.type-1{
    float:right;
    margin-top: 15px;
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
    color: #fff;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}
.txt {
    font-size: 14px;
    line-height: 1.45;
    color: #fff;
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
.fivestars i{
    color:#fd7100 !important; 
}
.fourstars i.active{
    color:#fa8f01 !important; 
}
.threestars i.active{
    color:#fcac01 !important; 
}
.twostars i.active{
    color:#fabf37 !important; 
}
.onestars i.active{
    color:#ffd478 !important; 
}
.fivestar-box{
    border-bottom:2px solid #fd7100;
}
.fivestar-box:hover{
    box-shadow: 0 0 13px rgba(120, 120, 120, 0.2);
}
.fivestar-box:hover .com-name {
    color:#fd7100;
}
.fivestar-box .read-bttn a{
    background:#fd7100;
}
.fivestar-box .rating-stars i, .fivestar-box .com-loc i, .fivestar-box .com-dep i,
.fivestar-box .stars{
   color:#fd7100;
}
.fourstar-box{
    border-bottom:2px solid #fa8f01;
}
.fourstar-box .read-bttn a{
    background:#fa8f01;
}
.fourstar-box .rating-stars i.active, .fourstar-box .com-loc i, .fourstar-box .com-dep i,
 .fourstar-box .stars{
   color:#fa8f01;
}
.threestar-box{
    border-bottom:2px solid #fcac01;
}
.threestar-box .read-bttn a{
    background:#fcac01;
}
.threestar-box .rating-stars i.active, .threestar-box .com-loc i, .threestar-box .com-dep i,
 .threestar-box .stars{
   color:#fcac01;
}
.twostar-box{
    border-bottom:2px solid #fabf37;
}
.twostar-box .read-bttn a{
    background:#fabf37;
}
.twostar-box .rating-stars i.active, .twostar-box .com-loc i, .twostar-box .com-dep i,
 .twostar-box .stars{
   color:#fabf37;
}
.onestar-box{
    border-bottom:2px solid #ffd478;
}
.onestar-box .read-bttn a{
    background:#ffd478;
}
.onestar-box .rating-stars i.active, .onestar-box .com-loc i, .onestar-box .com-dep i,
 .onestar-box .stars{
   color:#ffd478;
}
');

$script = <<< JS

JS;
$this->registerJs($script);