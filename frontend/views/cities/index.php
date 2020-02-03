<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = false;
?>
    <section class="backgrounds">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-heading">
                        <div class="pos-center">
                            <div class="main-text"><i class="fas fa-map-marker-alt"></i>  Ludhiana, Punjab, India</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-set">
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box1">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/job.png') ?>">
                            <span class="count"><?= $job_count?>+</span>
                            <span class="box-text">Jobs</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box2">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/company.png') ?>">
                            <span class="count"><?= $org_count?>+</span>
                            <span class="box-text">Companies</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box3">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/internship.png') ?>">
                            <span class="count"><?= $internship_count?>+</span>
                            <span class="box-text">Internships</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box4">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/institute.png') ?>">
                            <span class="count"><?= $institute_count?>+</span>
                            <span class="box-text">Institutes</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box5">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/school.png') ?>">
                            <span class="count"><?= $school_count?>+</span>
                            <span class="box-text">Schools</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="box-des box6">
                            <img src="<?= Url::to('@eyAssets/images/pages/cities/college1.png') ?>">
                            <span class="count"><?= $college_count ?>+</span>
                            <span class="box-text">Colleges</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container">
            <div class="row">
                <div class=" col-md-12">
                    <div class="heading-style">Related Jobs</div>
                </div>
            </div>
            <?php echo $this->render('/widgets/mustache/application-card', [
                'type' => 'Jobs',
            ]);?>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class=" col-md-12">
                    <div class="heading-style">Related Internships</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 pt-5">
                <div class="application-card-main">
                        <span class="application-card-type location">
                            <i class="fas fa-map-marker-alt"></i>&nbsp;
                      </span>

                    <span class="application-card-type location">
                            <i class="fas fa-map-marker-alt"></i>&nbsp;All India
                        </span>
                    <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                        <div class="application-card-img">
                            <a href="" title="">
                                <img src="https://www.empoweryouth.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/W10EsCvmo-75qtYr9L77yP1BrP6Q2I5c/WYn1kN3q6R6KAGmB3mNVoglZbMv0OE.png">
                            </a>
                        </div>
                        <div class="application-card-description">
                            <a href="" title=""><h4 class="application-title">web design</h4></a>
                            <!--                            <h5><i class="fas fa-rupee-sign"></i>&nbsp;60000</h5>-->
                            <h5>negotiable</h5>
                            <h5>Full Time</h5>
                            <!--                            <h5><i class="far fa-clock"></i>&nbsp;2years</h5>-->
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h4 class="org_name text-right">tech adaptive</h4>
                    </div>
                    <div class="application-card-wrapper">
                        <a href="" class="application-card-open" title="View Detail">View Detail</a>
                        <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i
                                class="fas fa-plus"></i>&nbsp;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Institutes</div>
                </div>
                <div class="padd-top-20">
                    <div id="companies-card"></div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="com-box">
                        <a href="">
                            <div class="com-icon">
                                <div class="icon"><img
                                        src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                                </div>
                                <div class="follow">
                                    <button><i class="fa fa-heart-o"></i></button>
                                </div>
                                <!--                                <div class="featured">Featured</div>-->
                            </div>
                            <div class="com-det">
                                <div class="com-name">Emity Institute</div>
                                <div class="com-cate"><img
                                        src="<?= Url::to('@eyAssets/images/pages/training-detail-page/l.png') ?>">
                                    <span class="a">Ludhiana</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="com-box">
                        <a href="">
                            <div class="com-icon">
                                <div class="icon"><img
                                        src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                                </div>
                                <div class="follow">
                                    <button><i class="fa fa-heart-o"></i></button>
                                </div>
                                <!--                                <div class="featured">Featured</div>-->
                            </div>
                            <div class="com-det">
                                <div class="com-name">Emity Institute</div>
                                <div class="com-cate"><img
                                        src="<?= Url::to('@eyAssets/images/pages/training-detail-page/l.png') ?>">
                                    <span class="a">Ludhiana</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="com-box">
                        <a href="">
                            <div class="com-icon">
                                <div class="icon"><img
                                        src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                                </div>
                                <div class="follow">
                                    <button><i class="fa fa-heart-o"></i></button>
                                </div>
                                <!--                                <div class="featured">Featured</div>-->
                            </div>
                            <div class="com-det">
                                <div class="com-name">Emity Institute</div>
                                <div class="com-cate"><img
                                        src="<?= Url::to('@eyAssets/images/pages/training-detail-page/l.png') ?>">
                                    <span class="a">Ludhiana</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="top-com">
        <div class="container">
            <h1 class="heading-style">Colleges</h1>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="com-review-box uncliamed_height fivestar-box">
                        <div class="com-logo">
                            <a href="#">
                                <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            </a>
                            <a href="#">
                                <canvas class="user-icon" name="name" width="100" height="100"
                                        color="color" font="35px">
                                </canvas>
                            </a>
                        </div>
                        <div class="pos-rel">
                            <div class="com-name"><a href="#">name</a></div>
                        </div>
                        <div class="com-loc"></div>
                        <div class="com-dep"></div>
                        <div class="com-rating">
                            <div class="average-star" data-score="rating"></div>
                        </div>
                        <div class="rating">
                            <div class="stars">rating</div>
                            <div class="reviews-rate">total_reviews </div>
                        </div>
                        <div class="com-rating">
                            <div class="average-star" data-score="2"></div>
                        </div>
                        <div class="rating">
                            <div class="reviews-rate"> Currently No Review</div>
                        </div>
                        <div class="row">
                            <div class="cm-btns padd-0">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="color-blue">
                                        <a href="#">View Profile</a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="color-orange">
                                        <a href="#">Read Reviews</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="top-com">
        <div class="container">
            <h1 class="heading-style">Schools</h1>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="com-review-box uncliamed_height fivestar-box">
                        <div class="com-logo">
                            <a href="#">
                                <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            </a>
                            <a href="#">
                                <canvas class="user-icon" name="name" width="100" height="100"
                                        color="color" font="35px">
                                </canvas>
                            </a>
                        </div>
                        <div class="pos-rel">
                            <div class="com-name"><a href="#">name</a></div>
                        </div>
                        <div class="com-loc"></div>
                        <div class="com-dep"></div>
                        <div class="com-rating">
                            <div class="average-star" data-score="rating"></div>
                        </div>
                        <div class="rating">
                            <div class="stars">rating</div>
                            <div class="reviews-rate">total_reviews </div>
                        </div>
                        <div class="com-rating">
                            <div class="average-star" data-score="2"></div>
                        </div>
                        <div class="rating">
                            <div class="reviews-rate"> Currently No Review</div>
                        </div>
                        <div class="row">
                            <div class="cm-btns padd-0">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="color-blue">
                                        <a href="#">View Profile</a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="color-orange">
                                        <a href="#">Read Reviews</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="top-com">
        <div class="container">
            <h1 class="heading-style">Educational Institutes</h1>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="com-review-box uncliamed_height fivestar-box">
                        <div class="com-logo">
                            <a href="#">
                                <img src="<?= Url::to('@eyAssets/images/pages/training-detail-page/small.jpg') ?>">
                            </a>
                            <a href="#">
                                <canvas class="user-icon" name="name" width="100" height="100"
                                        color="color" font="35px">
                                </canvas>
                            </a>
                        </div>
                        <div class="pos-rel">
                            <div class="com-name"><a href="#">name</a></div>
                        </div>
                        <div class="com-loc"></div>
                        <div class="com-dep"></div>
                        <div class="com-rating">
                            <div class="average-star" data-score="5"></div>
                        </div>
                        <div class="rating">
                            <div class="stars">5</div>
                            <div class="reviews-rate"> to 2 </div>
                        </div>
                        <div class="com-rating">
                            <div class="average-star" data-score="2"></div>
                        </div>
                        <div class="rating">
                            <div class="reviews-rate"> Currently No Review</div>
                        </div>
                        <div class="row">
                            <div class="cm-btns padd-0">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="color-blue">
                                        <a href="#">View Profile</a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <div class="color-orange">
                                        <a href="#">Read Reviews</a>
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
.backgrounds{
//    background-size: 100% 520px;
    background-image: url("' . Url::to("@eyAssets/images/pages/cities/instituteheader1.png") . '");
//    background-position: right top;
    background-repeat: no-repeat;
    min-height: 410px;
    padding-top: 150px;
    background-size: cover;
    background-position: 48%;
}
.main-heading{
    position:relative;
    height:218px;
    text-align:left;
}
.pos-center{
    position:absolute;
    top:213px;
    transform:translateY(-50%);
    max-width: 650px;
    width: 100%;
    z-index: 9;
}
.main-text{
     font-size:30px;
     color:#fff;
     font-family:lora;  
}
.box1{ background-image: url("/assets/themes/ey/images/pages/cities/1job.png");}
.box2{ background-image: url("/assets/themes/ey/images/pages/cities/1company.png");}
.box3{ background-image: url("/assets/themes/ey/images/pages/cities/1internship.png");}
.box4{ background-image: url("/assets/themes/ey/images/pages/cities/1institute.png");}
.box5{ background-image: url("/assets/themes/ey/images/pages/cities/1school.png");}
.box6{ background-image: url("/assets/themes/ey/images/pages/cities/college.png");}
.col-set {
    width: 85%;
    float: none;
    margin: auto;
}
.box-des {
    background-size: 100% 100%;
    background-repeat: no-repeat;
    position: relative;
    height: 172px;
    margin-top:30px;
}
.box-des img{
    position: absolute;
    max-width: 75px;
    right: 25px;
    top: 15px;
}
.box-text {
    position: absolute;
    bottom: 3px;
    left: 16px;
    color: white;
    font-size: 21px;
    font-family: roboto;
}
.count {
    position: absolute;
    bottom: 28px;
    left: 16px;
    color: white;
    font-size: 19px;
    font-family: roboto;
}
.parent{margin:10px 0;}
.logo{
	text-align: center;
	margin: 0 auto;
	margin-top: 25px;
}
.logo img{
	max-height: 75px;
}
.stat{
	text-align: center;
	margin-top: 15px;
	color: white;
	font-weight: bold;
	font-size: 17px;
}
.text{
	text-align: center;
	color: white;
	font-weight: bold;
	font-size: 17px;
}
.com-box{
    border:1px solid #eee;
    border-radius:5px;
    margin-bottom:20px;
}
.com-icon{
   position:relative;
   height:200px
}
.icon{
    position:absolute;
    max-height:150px;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
}
.icon img{
    width:150px;
    max-height:125px;
    object-fit:contain;
}
.follow{
    position:absolute;
    bottom:5px;
    right:10px;    
}
.follow button{
    margin-top:5px;  
    background:transparent;
    border:none;
    color:#ddd;
}
.follow button i{
    font-size:20px;
}
.follow button:hover{
    color:#00a0e3;    
}
.com-det{
    border-top:1px solid #eee;
    padding:10px 15px 10px;
    position:relative;
}
.com-name{
    font-size:20px;
    color:#525252;
    white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
   text-transform: capitalize;
}
.featured{
    background:#00a0e3;
    padding:5px 15px;
    position:absolute;
    top:15px;
    left:0;
    border-radius:0 5px 5px 0;
    color:#fff;
}
.com-box:hover{
    box-shadow:0 0 10px rgba(0,0,0,.1);
    transition:.2s ease-in;
}
.com-box:hover .com-name{
    color:#00a0e3;
    transition:.2s ease-in;
}
.inst-name{
    font-size:16px;
    font-weight:bold;
}
.inst-member{
    padding:5px 10px 10px 10px;
    text-align:center;
}
.inst-icon{
    width:100%;
    overflow:hidden;
    object-fit:cover;
    position:relative;
}
.inst-icon img{
    border-radius:10px 10px 0 0; 
    width:100%;
    height:100%;
}
.inst-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:100%;
    position:relative;
    margin: 0 0 20px 0;
}
.review-benifit{
    position: relative;
    padding-bottom: 50px;
    z-index: -1;
}
.cm-btns {
    margin-top:10px;
}  
.color-blue a:hover{
    color:#00a0e3;
}  
.color-orange a:hover{
    color:#ff7803;
}
.com-review-box{
    text-align:center;
     border:1px solid #e5e5e5;
    padding:20px 0 3px 0;
    margin-bottom:20px;
    border-radius:10px; 
    color:#999;
}
.com-logo{
    width:100px;
    height:100px;
    margin:0 auto;
    border-radius:10px;
     border:1px solid #e5e5e5;
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
.uname .md-radio label{
    white-space: normal;
    font-size: 12px;
}
.has-success .md-radio label
{
color: initial;
}
.rating-stars{
    font-size:20px;
}
.rating{
    display:flex;
    justify-content:center;
    font-size:14px;
    min-height:25px;
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
    color:#fff;
    border-radius: 10px 10px 0 0;
}
.fivestar-box{
    border-bottom:2px solid #fd7100;
}
.fivestar-box:hover, .fourstar-box:hover, .threestar-box:hover, twostar-box:hover, onestar-box:hover{
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
$script = <<<JS
    getCards();
JS;
$this->registerJs($script);