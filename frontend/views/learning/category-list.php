<?php
$this->title = Yii::t('frontend', 'Categories');
$this->params['header_dark'] = true;

use yii\helpers\Url;
?>
    <!--<script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>-->
    <!--<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet"/>-->

    <div class="container">
        <!-- Example row of columns -->
        <div class="row col-md-12">
            <div class="heading-style col-md-6 col-sm-6">Featured Videos</div>
        </div>
    </div>
    <div class="v-slider">
        <div class="container">
            <div id="mixedSlider">
                <div class="MS-content">
                    <div class="item">
                        <div class="imgTitle">
                            <a href="/learning-corner/video-detail">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png') ?>" alt=""/>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="blogTitle">
                            <a href="/learning-corner/video-detail">Lorem ipsum dolor sit amet</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="imgTitle">
                            <a href="/learning-corner/video-detail">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png') ?>" alt=""/>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="blogTitle">
                            <a href="/learning-corner/video-detail">Lorem ipsum dolor sit amet</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="imgTitle">
                            <a href="/learning-corner/video-detail">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png') ?>" alt=""/>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="blogTitle">
                            <a href="/learning-corner/video-detail">Lorem ipsum dolor sit amet</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="imgTitle">
                            <a href="/learning-corner/video-detail">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png') ?>" alt=""/>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="blogTitle">
                            <a href="/learning-corner/video-detail">Lorem ipsum dolor sit amet</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="imgTitle">
                            <a href="/learning-corner/video-detail">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/video.png') ?>" alt=""/>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="blogTitle">
                            <a href="/learning-corner/video-detail">Lorem ipsum dolor sit amet</a>
                        </div>
                    </div>
                </div>
                <div class="MS-controls">
                    <button class="MS-left"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
                    <button class="MS-right"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>



    <div class="container sub-categories">
        <!-- Example row of columns -->
        <div class="row col-md-12">
            <div class="heading-style col-md-6 col-sm-6">Sub Categories</div>
            <div class="search-box">
                <form action="">
                    <input type="text" placeholder="Search Category" name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
    <!--sub categories-->
    <section>
        <div class="container ">
            <!--        <div class="sub-cat">
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                            </a>
                        <a href="/learning/video-gallery">
                        <div class="bottom-center wrap col-md-2 col-sm-3">
                            <div class="back2 minus-padding">
                                <div class="">100 Videos</div>
                                <div class="">10 Courses</div>
                            </div>
                            <div class="sfront">
                                <div class="">Web Development</div>
                            </div>
                        </div>
                        </a>

                    </div>-->
        </div>


        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-01.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Technology </h3>
                                <h4>Developing Mobiles Apps</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-02.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Adobe photoshop <span class="price"></span></h3>
                                <h4>Photoshop Effects </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Business<span class="price"></span></h3>
                                <h4>Market Management</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-01.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Technology <span class="price"></span></h3>
                                <h4>Developing Mobiles Apps</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-02.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Adobe photoshop <span class="price"></span></h3>
                                <h4>Photoshop Effects </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Business<span class="price"></span></h3>
                                <h4>Market Management</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-01.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Technology <span class="price"></span></h3>
                                <h4>Developing Mobiles Apps</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-02.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Adobe photoshop <span class="price"></span></h3>
                                <h4>Photoshop Effects </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Business<span class="price"></span></h3>
                                <h4>Market Management</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-01.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Technology <span class="price"></span></h3>
                                <h4>Developing Mobiles Apps</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-02.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Adobe photoshop <span class="price"></span></h3>
                                <h4>Photoshop Effects </h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="/learning/video-gallery">
                        <div class="product-thumb">
                            <div class="image">
                                <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/sub-cat-03.jpg') ?>" class="img-responsive" alt="img" />
                            </div>
                            <div class="caption">
                                <h3>Business<span class="price"></span></h3>
                                <h4>Market Management</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla interdum ipsum malesuada arcu tristique, sit amet fringilla metus volutpat.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>



        </div>
    </section>
<?php
$this->registerCss('
/*sub category box css*/
a.product-thumb:hover{
 box-shadow:0 0 10px rgba(0,0,0,.5);
}
.product-thumb {
	margin-bottom:30px;
}
.product-thumb img{
	border-radius:4px 4px 0 0;
}
.product-thumb .caption{
	border:1px solid #E5E5E5;
	border-top:0;
	border-radius: 0 0px 4px 4px;
	background:#fff;
}
.product-thumb .caption h3{
	font-size:14px;
	font-weight:600;
	color:#686868;
	padding:15px 15px 28px;
	margin:0;
	line-height:16px;
}
.product-thumb .caption h3 .price, .product-thumb .caption h3 .text{
	color:#F4BD01;
	float:right;
	font-size:24px;
	font-weight:700;
}
.product-thumb .caption h3 .text{
	color:#2AB5F0;
}
.product-thumb .caption h4{
	font-size:18px;
	font-weight:600;
	color:#000;
	margin:0;
	padding:0 15px 30px;
}
.product-thumb .caption p{
	font-size:14px;
	font-weight:400;
	margin:0 13px 17px;
	color:#686868;
	display:none;
}
.product-thumb .caption ul{
	margin:0;
	border-top:1px solid #e5e5e5;
}
.product-thumb .caption ul li{
	border-right:1px solid #e5e5e5;
	padding:13px 13px;
}
.product-thumb .caption ul li:last-child{
	border-right:none;
}
.product-thumb .caption ul li a{
	font-size:14px;
	font-weight:600;
	margin:0;
	color:#b2b2b2;
}
.product-thumb .caption ul li i{
	margin-right:3px;
}
.product-thumb .caption ul li:last-child i{
	font-size:14px;
	color:#F4BD01;
}
    

    

/*sub category box css ends*/

.jumbo-heading{ font-size: 45px; font-weight:bold; font-family: lobster; text-transform: uppercase; }
.jumbo-subheading{ font-size: 25px; padding-top: 0px; font-family: lobster}
.jumbo-subheading span{text-transform: uppercase;}
.heading-style{
   font-family: lobster;
   font-size: 28pt;
   text-align: left;
   margin: 15px 5px;
}
.heading-style:before{
   content: "";
   position: absolute;
   width: 0;
   height: 0;
   border-style: solid;
   border-width: 0 0 5px 52px;
   border-color: #f07706;
}
.search-box{float: right; border: 1px solid #ccc;  border-radius: 10px; padding: 5px; margin: 20px 0 0 0; }
.search-box input[type=text] {
  padding: 9px;
  font-size: 15px;
  border:none ;
}
.search-box input:focus{outline: none;}
.search-box button {
  float: right;
  padding: 8px 10px;
  background: transparent;
  font-size: 17px;
  border: none;
  cursor: pointer;
}
.search-box button:hover {
 color: #ff7803; 
}
.v-slider{padding-top: 20px;}
.v-padding{padding: 10px 0;}
.videorow{}
.view{ text-align: center; padding: 20px 0 30px 0; }
.view a{border: 1px solid #ff7803; padding: 10px 20px; background: #ff7803; color: #fff;}
.view a:hover{background: #fff; color: #ff7803; text-decoration: none; transition: .3s ease-in-out;}
.v-text{text-align: left; color: #337ab7; font-size: 16px; padding-top: 5px; font-weight: bold;}
.v-text a:hover{text-decoration: none; color: #337ab7;}
.sec2{padding-top: 50px;}
#mixedSlider {
  position: relative;
}
#mixedSlider .MS-content {
  white-space: nowrap;
  overflow: hidden;	
  margin: 0 5%;
}
#mixedSlider .MS-content .item {
  display: inline-block;
  width: 33.3333%;
  position: relative;
  vertical-align: top;
  overflow: hidden;
  height: 100%;
  white-space: normal;
  padding: 0 10px;
}
@media (max-width: 991px) {
  #mixedSlider .MS-content .item {
    width: 50%;
  }
}
@media (max-width: 767px) {
  #mixedSlider .MS-content .item {
    width: 100%;
  }
}
#mixedSlider .MS-content .item .imgTitle a {
  position: relative;
}
#mixedSlider .MS-content .item .blogTitle a{
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
  margin: 0px 20px 0 5px;
text-align: justify;
  padding-top: 12px !important;
}
#mixedSlider .MS-content .item a {
  margin: 0 20px 0 0;
  font-size: 16px;
  font-style: italic;
  color: #337ab7 ;
  font-weight: bold;
  transition: linear 0.1s;
}
#mixedSlider .MS-content .item a:hover {
  text-decoration: none;
  color: #337ab7;
}
#mixedSlider .MS-controls button {
  position: absolute;
  border: none;
  background-color: transparent;
  outline: 0;
  font-size: 50px;
  top: 95px;
  color: rgba(0, 0, 0, 0.4);
  transition: 0.15s linear;
}
#mixedSlider .MS-controls button:hover {
  color: rgba(0, 0, 0, 0.8);
}

#mixedSlider .MS-controls .MS-right {
  right: 0px;
}
.wrap{
    float:left;
    position:relative;
    width:160px;
    height:100px;
    margin:10px;
    overflow:hidden;
}
.wrap .sfront{
    top:0;
    left:0;
    position:absolute;
}
.sub-cat{margin:0 0 0 45px; text-align: center; justify-content: center}
.sub-categories{padding-top: 40px;}
.back2{background: #ffa803; min-width: 160px; min-height: 100px; color:#FFF; font-family: lobster; text-align: center;
        padding-top: 20px; font-size: 20px; border-radius:4px; margin-left: -15px; }

.sfront{background: #1fbdff; min-width: 160px; min-height: 100px; color:#fff; font-family: lobster; text-align: center;
         padding: 10px 10px 10px 10px; font-size: 23px; border-radius:4px;}

.sub-cat-padding{padding-bottom: 30px;}
@media screen and (max-width: 1200px) and (min-width: 992px){
    .wrap{width: 200px; height: 140px;}
    .sfront{width: 200px; height: 140px;  padding: 40px 10px 10px 10px;}
    .back2{width: 200px; height: 140px; padding-top: 40px;}
} 
@media screen and (max-width: 992px) {
 .v-text{padding-bottom:20px }
 .sub-cat{margin:0 0 0 30px; text-align: center; justify-content: center}
 .wrap{margin: 5px;}
}

@media (max-width: 992px) {
  #mixedSlider .MS-controls button {
    font-size: 30px;
  }
}
@media (max-width: 767px) {
  #mixedSlider .MS-controls button {
    font-size: 20px;
  }
}
#mixedSlider .MS-controls .MS-left {
  left: 0px;
}
@media (max-width: 767px) {
  #mixedSlider .MS-controls .MS-left {
    left: -10px;
  }
}
@media (max-width: 767px) {
  #mixedSlider .MS-controls .MS-right {
    right: -10px;
  }
}
.search-box form{
    margin:0px;
}
.search-box form input:focus{
    box-shadow:none;
}
');
$script = <<< JS
    $("#seemore").click(function () {
        $(".row1:first").clone().appendTo(".videorow");
    });

    $('.bottom-center').hover(function () {
        $(this).children('.sfront').stop().animate({'top': '-150px'}, 500);
    }, function () {
        $(this).children('.sfront').stop().animate({'top': '0px', 'left': '0px'}, 500);
    });
     $('#mixedSlider').multislider({
        duration: 750,
        interval: 3000
    });
JS;
$this->registerJs($script);
$this->registerCssFile('http://www.jqueryscript.net/css/jquerysctipttop.css');
$this->registerJsFile('@eyAssets/js/multislider.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
