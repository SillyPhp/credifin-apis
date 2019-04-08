<?php
$this->title = Yii::t('frontend', 'Learning Corner');

use yii\helpers\Url;

$this->registerCssFile('https://raw.githubusercontent.com/daneden/animate.css/master/animate.css');

$this->registerCss('
                                                            // Benefits sectionn css start
                                                            
.text-justify{
   text-align:justify;
}
.how-section1{
    margin-top:-8%;
    padding: 2%;
}
.how-section1 h4{
    color: #ff8c29;
    font-weight: bold;
    font-size: 30px;
}
.how-section1 .subheading{
    color: #5774b8;
    font-size: 20px;
}
.how-section1 .row
{
    margin-top: 3%;
}
.how-img 
{
    text-align: center;
    line-height:15;
}
.how-img img{
    width: 40%;
}



/*Heading Style Four*/

.sandbox-correct-pronounciation {
  padding: 4em 0 1em 0;
  	background-color: #5774b8;
}

.heading-correct-pronounciation {

  margin: auto;
  text-align: center;
  position: relative;
}


h5 {
 
  font-family: "Cardo", serif;
  font-size: 1.5em;
  font-weight: normal;
  font-style: italic;
  letter-spacing: 0.1em;
  line-height: 2.2em;
  color:#fff;
}
.heading1
{
    color:#5774b8;
    font-weight: 700;
    font-size: 25px;
    color:#3b5998;
}
.step-heading strong {
    color:#fff;
}
em {
  font-family: "EB Garamond", serif;
  font-size: 3.5em;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  display: block;
  font-style:normal;
  padding-top: 0.1em;
  text-shadow: 0.07em 0.07em 0 rgba(0, 0, 0, 0.1);
  
  &::before, &::after {
  content: "§";
  display: inline-block;
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -o-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  transform: rotate(90deg);
    opacity: 0.2;
  margin: 0 0.6em;
  font-size: 0.5em;
}
}

                                                                // Benefits sectionn css end
.search-box1{
    max-width:350px;
    float:left;
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
}
.search-box1 input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
.search-box1 button {
  float: right;
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

.flipbox a.lc-link{ color:#333;}
.backgrounds{
    background-size: 100% 595px;
    background-image: url("https://image.ibb.co/dDPLVq/wd.png");
    background-position: left top;
    background-repeat: no-repeat;
    min-height: 600px;
    padding-top: 100px;
}
.head-pic{
    text-align: center;
}
.headsec{
    color:#333;
}
.jumbo-heading{
    font-size: 45px;
    font-weight:bold;
    font-family: lobster;
    text-transform: uppercase; 
    
    animation-name: intern;
    animation-duration: 3s;
    animation-fill-mode: forwards;
}
@keyframes intern {
    
    from
    { 
    transform: translateX(-400px);
    letter-spacing: 0px;
    }
    to{ 
    transform: translateX(0px);
    letter-spacing: 10px;
    }
    
}
.jumbo-subheading{
    font-size: 25px;
    padding-top: 0px;
    font-family: lobster
}
.jumbo-subheading span{
    text-transform: uppercase;
}
.search-box{
    float: right;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 3px;
    margin: 21px 0 0 0;
}
.search-box form{
    margin-bottom:0px;
}
.search-box input[type=text] {
  padding: 9px;
  font-size: 15px;
  border:none ;
}
.search-box input:focus{
    outline: none;
    border:0px;
    box-shadow:none !important;
}
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
.f-box{
    text-align: center;
    align-content: center;
}
.b-padding{
    padding-top: 125px;
}
.c-padding{
    padding-top: 125px;
}
.flipbox{
    position:relative;
    width:160px;
    height:160px;
    padding-top:10px;
    margin-left:50px;
}
.flipbox a > .front{
    position:relative;
    text-align: center; 
    transform: perspective(600px) rotateY(0deg );
    height: 160px; width: 160px;
    background:transparent; 
    backface-visibility:hidden;
    transition: transform .5s linear 0s;
}
.flipbox a > .back{         
    text-align: center;
    position: absolute;
    justify-content: center;
    transform: perspective(600px) rotateY(180deg );
    height: 160px; width: 160px; background: #ff7803; border-radius:50%; 
    backface-visibility:hidden;
    transition: transform .5s linear 0s;
	
}

.flipbox > a .back > .b-icon{padding:40px 0 0 0;  }
.flipbox a:hover > .front{transform: perspective(600px) rotateY(-180deg );}
.flipbox a:hover > .back{transform: perspective(600px) rotateY(0deg );}
/*.flipbox a{color: #333;}*/
.flipbox a:hover{color: #ff7803 !important; transition: .3s ease-in-out; text-decoration: none;}
a .b-text{text-align: center; padding: 20px 0 0 0; font-weight: bold; font-size: 20px; 
       text-decoration: none; text-transform: capitalize; }
/*a .b-text:hover{color:#ff7803 !important; text-decoration: none; }*/
.seemore{padding: 125px 0 0 0; text-align: center;}
.seemore a{border: 1px solid #ff7803; padding: 10px 25px; color:#fff; background: #ff7803; font-size: 17px; 
          border-radius: 5px}
.seemore a:hover{background: #fff; color: #ff7803; transition: all .5s; text-decoration: none; 
                    box-shadow: 0px 0px 10px rgb(255, 120, 3, .5 )  }
.cat-padding{padding-top:20px;}
.mv{ padding: 0px 0 0 0;}
.mv1{background: #fff; color: #080808; border: 1px solid #ccc; padding: 20px 10px; text-align: center; font-size:18px; 
    border-radius:5px; min-height:100px; }
.mv1:hover{box-shadow: 0px 0px 15px rgb(0, 0, 0, .5); transition: .3s ease-in-out;}
.working-box{ padding: 30px 0 !important; margin: 60px 0 0px 0; }
.box1{background: #fa811a; padding: 40px 50px 0px 50px; min-height: 280px;}
.box2{background: #ff902f; padding: 40px 50px 0px 50px; min-height: 280px;}
.box3{background: #ff9e4a; padding: 40px 50px 0px 50px; min-height: 280px;}
.box4{background: #ffac64; padding: 40px 50px 0px 50px; min-height: 280px;}
.w-heading{color: #fff; padding: 20px 0 20px 0; font-size: 20px; text-transform: uppercase; font-weight: 600; }
.w-heading:before{
   content: "";
   position: absolute;
   width: 0;
   height: 0;
   border-style: solid;
   border-width: 0 0 3px 40px;
   border-color: #fff;
   margin-top:-3px 
}
.w-text{color:#fff; font-size: 16px}
.empty{padding-bottom: 20px;  }
@media only screen and (max-width: 992px){
    .b-padding{padding-top: 0px;}
    .f-box{padding-bottom: 100px;}
    .c-padding{padding: 0px;}
    .mv1{margin-bottom: 15px;  }
    .seemore{padding: 50px;}
    .mv{padding: 50px;}
    
}

.v-slider{padding-top: 20px; padding-bottom: 40px;}
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
  margin: 0 0 0 0;
  font-size: 16px;
  font-style: italic;
  color: rgba(173, 0, 0, 0.82);
  font-weight: bold;
  transition: linear 0.1s;
}
#mixedSlider .MS-content .item a:hover {
  text-shadow: 0 0 1px grey; text-decoration: none;
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
#mixedSlider .MS-controls .MS-right {
  right: 0px;
}
@media (max-width: 767px) {
  #mixedSlider .MS-controls .MS-right {
    right: -10px;
  }
}
/*topics css*/
.topic-con{
     position: relative;
  width:100%;
 
/*border:1px solid #eee;*/
border-radius:2px;
text-align: center;
font-size:18px; 

color:#fff;
text-transform: uppercase;
}
.mv12{ display: block;
  width: 100%;
  height: auto;
  }

.overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background-color:rgba(0,140,186,.9);
  overflow: hidden;
  width: 100%;
  height: 0;
  transition: .5s ease;
}
.topic-con:hover .overlay {
  height: 100%;
  border-radius:15px 15px 15px 15px;
}
.text-o {
  color: white;
  font-size: 15px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  white-space: nowrap;
}
.back .b-icon img{
    width:55%;
}
.hr-company-box{text-align:center;border:2px solid #eef1f5; background:#fff; padding:20px 10px;
                    border-radius:14px !important; margin-bottom:20px; text-decoration:none; }
.hr-company-box:hover{border-color:#fff; box-shadow:0 0 20px rgb(0,0,0,.3); transition:.3s all;
                        text-decoration:none;} 
.hr-company-box > div:hover {text-decoration:none;}                       
.hr-com-icon{ text-align:center; text-decoration:none;  vertical-align:middle; padding:10px 0;}
.hr-com-icon img{text-align:center; margin:0 auto; max-width:80px;  max-height:80px; }
.hr-com-name{color:#00a0e3; padding-top:10px;text-decoration:none; font-size:16px;} 
.hr-com-name:hover{text-decoration:none;}                                   
.hr-com-field{padding-top:2px; font-weight:bold;font-size:14px; color:#080808;}
.hr-com-jobs{font-size:13px; color:#080808; padding:10px 0 10px; 
              margin-top:10px; border-top:1px solid #eef1f5;}            
.pad-top-10{padding-top:10px;}
.minus-15-pad{padding-left:0px !important; padding-right:0px !important;}


   
                                                        //steps 2 section css statt here

body
{
	background:#00bcd4;
}

h1
{
	color:#fff;
	margin:40px 0 60px 0;
	font-weight:300;
}

.our-team-main
{
	width:100%;
	height:auto;
	border-bottom:5px #ff9941 solid;
	background:#fff;
	text-align:center;
	border-radius:10px;
	overflow:hidden;
	position:relative;
	transition:0.5s;
	margin-bottom:28px;
}


.our-team-main img
{
	border-radius:50%;
	margin-bottom:20px;
	width: 90px;
}

.our-team-main h3
{
	font-size:20px;
	font-weight:700;
}

.our-team-main p
{
	margin-bottom:0;
}

.team-back
{
	width:100%;
	height:auto;
	position:absolute;
	top:0;
	left:0;
	padding:5px 15px 0 15px;
	text-align:left;
	background:#fff;
	
}

.team-front
{
	width:100%;
	height:auto;
	position:relative;
	z-index:10;
	background:#eee;
	padding:15px;
	bottom:0px;
	transition: all 0.5s ease;
}

.our-team-main:hover .team-front
{
	bottom:-250px;
	transition: all 1s ease;
}

.our-team-main:hover
{
	border-color:#ddd;
	transition:0.5s;
        transition: 1s ease;
}

/*our-team-main*/



                                                        //steps 2 section css start here

                                                        
');


?>
<section class="backgrounds">
    <div class="container headsec">
        <div class="col-md-6 mt-50">
            <div id="anm1"></div>
        </div> 
        <div class="col-md-6">
            <img width="85%" src="<?= Url::to('@eyAssets/images/pages/learning-corner/bgtop.svg'); ?>" align="right"/>
        </div>
    </div>
</section>


<div class="clearfix"></div>


                           
                        <!--************************************
					Benefit section start
                        ************************************* -->
                             
 <div class="container ">
                            
                        
    <div class="heading-style">Benefits</div>
             
<div class="how-section1">
    <div class="row">
        <div class="col-md-4 col-md-offset-1 how-img">
            <img src="https://image.ibb.co/dDW27U/Work_Section2_freelance_img1.png" class="rounded-circle img-fluid" alt=""/>
        </div>
        <div class="col-md-6">
            <h4>Easy Working Process</h4>
                        <!--<h4 class="subheading">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h4>-->
                        <p class="text-justify">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-1">
            <h4>Easy Job Posting</h4>
                        <!--<h4 class="subheading">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h4>-->
                        <p class="text-justify">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
        </div>
        <div class="col-md-4 how-img">
            <img src="https://image.ibb.co/cHgKnU/Work_Section2_freelance_img2.png" class="rounded-circle img-fluid" alt=""/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-1 how-img">
             <img src="https://image.ibb.co/ctSLu9/Work_Section2_freelance_img3.png" class="rounded-circle img-fluid" alt=""/>
        </div>
        <div class="col-md-6">
            <h4>Compare Applicants</h4>
                        <!--<h4 class="subheading">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h4>-->
                        <p class="text-justify">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-1"> 
            <h4>Hiring the best</h4>
                        <!--<h4 class="subheading">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h4>-->
                        <p class="text-justify">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
        </div>
        <div class="col-md-4 how-img">
            <img src="https://image.ibb.co/gQ9iE9/Work_Section2_freelance_img4.png" class="rounded-circle img-fluid" alt=""/>
        </div>
    </div>
</div>
                            </div>

                        <div class="clearfix"></div>
                        <div class="empty"></div>
                        <div class="empty"></div>
                        <!--************************************
					Benefit section end
                        ************************************* -->
                        
 
                        
                         <!--************************************
                                Steps2 section start here
                        ************************************* -->



	<div class="container">
            <h2 class="heading-style">How it works</h2>
	<div class="row">
	
	<!--team-1-->
	<div class="col-lg-4">
	<div class="our-team-main">
	
	<div class="team-front">
	<img src="http://placehold.it/110x110/9c27b0/fff?text=1" class="img-fluid" />
	<h3>Simply Register With Us</h3>
	<p>More</p>
	</div>
	
	<div class="team-back">
	<span>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque penatibus et magnis dis parturient montes,
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque.
	</span>
	</div>
	
	</div>
	</div>
	<!--team-1-->
	
	<!--team-2-->
	<div class="col-lg-4">
	<div class="our-team-main">
	
	<div class="team-front">
	<img src="http://placehold.it/110x110/336699/fff?text=2" class="img-fluid" />
	<h3>Complete Your Profile</h3>
	<p>More</p>
	</div>
	
	<div class="team-back">
	<span>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque penatibus et magnis dis parturient montes,
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque.
	</span>
	</div>
	
	</div>
	</div>
	<!--team-2-->
	
	<!--team-3-->
	<div class="col-lg-4">
	<div class="our-team-main">
	
	<div class="team-front">
	<img src="http://placehold.it/110x110/607d8b/fff?text=3" class="img-fluid" />
	<h3>Add More Skills</h3>
	<p>More</p>
	</div>
	
	<div class="team-back">
	<span>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque penatibus et magnis dis parturient montes,
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque.
	</span>
	</div>
	
	</div>
	</div>
	<!--team-3-->
	
	<!--team-4-->
	<div class="col-lg-4 col-lg-offset-2">
	<div class="our-team-main">
	
	<div class="team-front">
	<img src="http://placehold.it/110x110/4caf50/fff?text=4" class="img-fluid" />
	<h3>Join Your Choice</h3>
	<p>More</p>
	</div>
	
	<div class="team-back">
	<span>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque penatibus et magnis dis parturient montes,
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque.
	</span>
	</div>
	
	</div>
	</div>
	<!--team-4-->
	
	<!--team-5-->
	<div class="col-lg-4">
	<div class="our-team-main">
	
	<div class="team-front">
	<img src="http://placehold.it/110x110/e91e63/fff?text=5" class="img-fluid" />
	<h3>Grow Yourself</h3>
	<p>More</p>
	</div>
	
	<div class="team-back">
	<span>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque penatibus et magnis dis parturient montes,
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque.
	</span>
	</div>
	
	</div>
	</div>
	<!--team-5-->
	
<!--	team-6
	<div class="col-lg-4">
	<div class="our-team-main">
	
	<div class="team-front">
	<img src="http://placehold.it/110x110/2196f3/fff?text=Step+6" class="img-fluid" />
	<h3>Dilip Kevat</h3>
	<p>More</p>
	</div>
	
	<div class="team-back">
	<span>
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque penatibus et magnis dis parturient montes,
	Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis 
	natoque.
	</span>
	</div>
	
	</div>
	</div>
	team-6-->
	
	
	
	</div>
	</div>
<div class="clearfix"></div>
<div class="empty"></div>

                       <!--************************************
                                Steps2 section end here
                        ************************************* -->


<?php


$script = <<< JS
    (function (b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
                function () {
                    (b[l].q = b[l].q || []).push(arguments)
                });
        b[l].l = +new Date;
        e = o.createElement(i);
        r = o.getElementsByTagName(i)[0];
        e.src = '//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', 'UA-XXXXX-X', 'auto');
    ga('send', 'pageview');

    $("#seemore").click(function (e) {
        e.preventDefault();
        $(".category:first").clone().appendTo(".categories");
    });

    $('#mixedSlider').multislider({
        duration: 750,
        interval: 3000
    });
        
                                                            // seteps2 js state over here
        
        /**
 *  BootTree Treeview plugin for Bootstrap.
 *
 *  Based on BootSnipp TreeView Example by Sean Wessell
 *  URL:	http://bootsnipp.com/snippets/featured/bootstrap-30-treeview
 *
 *	Revised code by Leo "LeoV117" Myers
 *
 */
$.fn.extend({
	treeview:	function() {
		return this.each(function() {
			// Initialize the top levels;
			var tree = $(this);
			
			tree.addClass('treeview-tree');
			tree.find('li').each(function() {
				var stick = $(this);
			});
			tree.find('li').has("ul").each(function () {
				var branch = $(this); //li with children ul
				
				branch.prepend("<i class='tree-indicator glyphicon glyphicon-chevron-right'></i>");
				branch.addClass('tree-branch');
				branch.on('click', function (e) {
					if (this == e.target) {
						var icon = $(this).children('i:first');
						
						icon.toggleClass("glyphicon-chevron-down glyphicon-chevron-right");
						$(this).children().children().toggle();
					}
				})
				branch.children().children().toggle();
				
				/**
				 *	The following snippet of code enables the treeview to
				 *	function when a button, indicator or anchor is clicked.
				 *
				 *	It also prevents the default function of an anchor and
				 *	a button from firing.
				 */
				branch.children('.tree-indicator, button, a').click(function(e) {
					branch.click();
					
					e.preventDefault();
				});
			});
		});
	}
});

/**
 *	The following snippet of code automatically converst
 *	any '.treeview' DOM elements into a treeview component.
 */
$(window).on('load', function () {
	$('.treeview').each(function () {
		var tree = $(this);
		tree.treeview();
	})
})
       $(document).ready(function(){
        $('#anm1').addClass('jumbo-heading');
        $('#anm1').html('Intern with us');
   });
        
                                                                         // steps2 js end here
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/candidates-list/modernizr-2.8.3-respond-1.4.2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/multislider.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
