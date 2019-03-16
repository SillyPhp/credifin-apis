<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = false;
?>
    <section class="inner-header-page">
        <div class="container">

            <div class="col-md-8">
                <div class="left-side-container">
                    <div class="freelance-image"><a href="company-detail.html">
                            <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>" class="img-responsive img-circle" alt="">
                        </a></div>
                    <div class="header-details">
                        <h4>Janelia Fragrintio</h4>
                        <p>Full Stack PHP Developer</p>
                        <ul>
                            <li><a href="single-company-profile.html"><i class="fa fa-building"></i> Mack Star</a></li>
                            <!--                        <li>-->
                            <!--                            <div class="star-rating" data-rating="4.2">-->
                            <!--                                <span class="fa fa-star fill"></span>-->
                            <!--                                <span class="fa fa-star fill"></span>-->
                            <!--                                <span class="fa fa-star fill"></span>-->
                            <!--                                <span class="fa fa-star fill"></span>-->
                            <!--                                <span class="fa fa-star-half fill"></span>-->
                            <!--                            </div>-->
                            <!--                        </li>-->
                            <li> United Kingdom</li>
                            <li><div class="verified-action">Verified</div></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-4 bl-1 br-gary">
                <div class="right-side-detail">
                    <ul>
                        <li><span class="detail-info">Availability</span>Full Time<span class="available-status">Available</span></li>
                        <li><span class="detail-info">Location</span>Australia</li>
                        <li><span class="detail-info">Experience</span>5 Year</li>
                        <li><span class="detail-info">Age</span>27 Year</li>
                    </ul>
                    <ul class="social-info">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                    </ul>
                </div>
            </div>

        </div>
    </section>
    <section>
        <div class="container">

            <div class="col-md-8 col-sm-8">
                <div class="container-detail-box">

                    <div class="apply-job-header">
                        <h4>Janelia Fragrintio</h4>
                        <a href="company-detail.html" class="cl-success"><span><i class="fa fa-building"></i>App Developer</span></a>
                        <span><i class="fa fa-map-marker"></i>United Kingdom</span>
                    </div>

                    <div class="apply-job-detail">
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
                        <p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus.</p>
                        <p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus.</p>
                    </div>

                    <div class="apply-job-detail">
                        <h5>Skills</h5>
                        <ul class="skills">
                            <li>Css3</li>
                            <li>Html5</li>
                            <li>Photoshop</li>
                            <li>Wordpress</li>
                            <li>PHP</li>
                            <li>Java Script</li>
                        </ul>
                    </div>

                    <div class="apply-job-detail">
                        <h5>Language</h5>
                        <ul class="skills">
                            <li>English</li>
                            <li>French</li>
                            <li>Hindi</li>
                        </ul>
                    </div>

                    <a href="#" class="btn offer-bttn">Make An Offer</a>

                </div>

            </div>

            <!-- Sidebar Start-->
            <div class="col-md-4 col-sm-4">

                <!-- Make An Offer -->
                <div class="sidebar-container">
                    <div class="sidebar-box">
                        <span class="sidebar-status">Available</span>
                        <!--                        <h4 class="flc-rate">$17/hr</h4>-->
                        <div class="sidebar-inner-box">
                            <div class="sidebar-box-thumb">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>" class="img-responsive img-circle" alt="" />
                            </div>
                            <div class="sidebar-box-detail">
                                <h4>Daniel Disroyer</h4>
                                <span class="desination">App Designer</span>
                            </div>
                        </div>
                        <div class="sidebar-box-extra">
                            <ul>
                                <li>Php</li>
                                <li>Android</li>
                                <li>Html</li>
                                <li class="more-skill bg-primary">+3</li>
                            </ul>
                            <ul class="status-detail">
                                <li class="br-1"><strong>5 Years</strong>Experience</li>
                                <!--                                <li class="br-1"><strong>52 Jobs</strong>Done job</li>-->
                                <!--                                <li><strong>44</strong>Rehired</li>-->
                            </ul>
                        </div>
                    </div>
                    <a href="sidebarr-detail.html" class="btn btn-sidebar bt-1 bg-success">Make An Offer</a>
                </div>


            </div>
            <!-- End Sidebar -->

        </div>
    </section>
<?php
$this->registerCss('
 .inner-header-page{
    padding:150px 0 50px;
	text-align:left;
	background:#f5f6f7;
    border-bottom:2px solid #00a0e3;	
}
.left-side-container {
    display: table;
    width: 100%;
}
.bl-1 {
    border-left: 1px solid #00a0e3 !important;
}
.inner-header-page .freelance-image {
    height: 160px;
    flex: 0 0 140px;
    margin-right: 35px;
    background: #fff;
    border-radius: 4px;
    box-shadow: 0 3px 12px rgba(0,0,0,.1);
    display: inline-block;
    padding: 0 20px;
    line-height: 140px;
    float: left;
}
.inner-header-page .freelance-image img{
	max-width:140px;
	margin-top:10px;
}
.header-details h4{
	margin:0 0 5px 0;
	font-size:24px;
}
.header-details h4 span{
	font-size:17px;
}
.inner-header-page .header-details ul {
    padding: 0;
    margin: 0;
    list-style: none;
    line-height: 24px;
    margin-bottom: -7px;
}
.inner-header-page .header-details li {
    display: inline-block;
    margin-right: 20px;
    margin-bottom: 12px;
}
.inner-header-page .header-details ul li img{
    height: 16px;
    border-radius: 3px;
    position: relative;
    top: -1px;
    display: inline-block;
    box-shadow: 0 0 3px rgba(0,0,0,.2);
    margin-right: 5px;
    cursor: default;
}
.verified-action{
    position: relative;
    height: 26px;
    display: flex;
    top: -1px;
    color: #fff;
    font-weight: 500;
    font-size: 14px;
    background-color: #00a0e3;
    text-align: center;
    z-index: 10;
    font-weight: 500;
    border-radius: 4px;
    padding: 0 8px 0 0;
    margin: 0;
    overflow: hidden;
    padding-left: 34px;
    line-height: 27px;
}
.verified-action:before {
    content: "\f00c";
    font-family:FontAwesome;
    font-size: 16px;
    color: #fff;
    position: absolute;
    top: 0;
    left: 0;
    line-height: 26px;
    height: 26px;
    width: 26px;
    display: inline-block;
    background-color: #0395d8;
}
.header-details {
    margin-top: 20px;
}
.inner-header-page .header-details li .star-rating {
    position: relative;
    top:0px;
}
.star-rating::before {
    content: attr(data-rating);
    float: left;
    background-color:#febe42;
    color:#ffffff;
    font-size: 14px;
    line-height: 15px;
    font-weight: 700;
    position: relative;
    top: 1px;
    margin-right: 10px;
    border-radius: 4px;
    padding: 5px 7px;
}
.inner-header-page .header-details li .star-rating .fa {
    color: #94a0ad;
}
.inner-header-page .header-details li .star-rating .fa.fill {
    color:#febe42;
}
.right-side-detail ul {
    padding: 0;
    margin: 0;
}
.right-side-detail ul li {
    list-style: none;
    padding: 5px 0;
}
.right-side-detail ul li .detail-info {
    width: 135px;
	font-weight:500;
    display: inline-block;
}
.right-side-detail ul.social-info li{
	display:inline-block;
	margin:5px;
}
.right-side-detail ul.social-info li a {
    width: 40px;
    height: 40px;
    display: inline-block;
    background: #e3e8ec;
    text-align: center;
    line-height: 40px;
    border-radius: 2px;
}
span.available-status {
    margin-left: 10px;
    background: #ff7803;
    padding: 5px 15px;
    border-radius: 4px;
    color: #ffffff;
}
/*------------ job Apply Detail ----------------*/
.container-detail-box{
    background: #ffffff;
    border-radius: 6px;
    overflow: hidden;
	padding:30px 30px;
    margin-bottom: 30px;
    position: relative;
    border: 1px solid #eaeff5;
}
.apply-job-detail{
	margin-bottom:30px;
}
.apply-job-detail h5{
	font-size:18px;
}
.apply-job-header a {
    margin-right: 15px;
}
.apply-job-header a i, .apply-job-header span i {
    margin-right: 5px;
}
.apply-job-header {
    margin-bottom: 40px;
}
.apply-job-header h4{
	font-size:22px;
}
ul.skills,  ul.job-requirements{
    margin: 15px 0;
    padding: 0;
}
ul.skills li {
    display: inline-block;
    list-style: none;
    padding: 3px 15px;
    border: 1px solid #b9c5ce;
    border-radius: 6px;
    margin: 5px;
    font-weight: 500;
    color: #657180;
}

ul.job-requirements li{
	list-style:none;
	display:block;
	padding:7px 0;
}
ul.job-requirements li span{
	display:inline-block;
	width:120px;
	font-weight:500;
}

/*---------- Login -------------*/
img.img-responsive.payment-img {
    margin-top: 20px;
}
/*--------------------------------------------------- 
	Default Sidebar
-----------------------------------------------*/
.sidebar-wrapper{
    background: #ffffff;
    border-radius: 6px;
    overflow: hidden;
	text-align:left;
    margin-bottom: 30px;
    position: relative;
    transition: .4s;
	padding:0 25px 30px;
    border: 1px solid #eaeff5;
}
.sidebar-box-header{
	padding:15px 0;
	margin-bottom:20px;
}
.sidebar-box-header h4{
	font-size:17px;
	margin:5px 0;
}
.member-profile-list {
    display: table;
    width: 100%;
}
.member-profile-list {
    padding: 15px 0;
	border-bottom:1px solid #eaeff5;
    text-align: left;
}
.member-profile-list:last-child{
	border-bottom:none;
}
.member-profile-thumb {
    width:70px;
    float: left;
}
.member-profile-detail {
    margin-left: 80px;
	margin-top:7px;
}
.member-profile-detail h4 {
    margin: 0 0 2px 0;
}
.member-profile-detail span {
    display: block;
	line-height:1.5;
    font-size: 13px;
}

/*--------------- Sidebar: Detail For Freelancer ----------------*/
.sidebar-container{
    background: #ffffff;
    border-radius: 6px;
    overflow: hidden;
	text-align:center;
    margin-bottom:30px;
	position:relative;
	transition: .4s;
    border:1px solid #eaeff5;
}
.sidebar-container:hover, .sidebar-container:focus{
    transform: translateY(-5px);
    -webkit-transform: translateY(-5px);
	cursor:pointer;
}
.sidebar-box{
    text-align: center;
    padding:60px 20px 15px;
}
.style-2 .sidebar-box {
    padding: 40px 20px 35px;
}
.sidebar-status {
    position: absolute;
    left:32px;
    top: 25px;
    background:#ff7803;
    color: #ffffff;
    padding: 4px 18px;
    border-radius: 4px;
    font-weight: 500;
}

.flc-rate{
    position: absolute;
    right:32px;
    top: 20px;
    font-size:18px;
    font-weight: 500;
}

.sidebar-box-thumb {
    margin-bottom: 30px;
    width: 120px;
	height:120px;
    margin: 0 auto 25px auto;
	border-radius:50%;
	overflow:hidden;
	box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-moz-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
}
.style-2 .sidebar-box-thumb {
    width: 100px;
	height:100px;
    margin: 0 auto 15px auto;
	border-radius:50%;
	overflow:hidden;
	box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-moz-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
}
.sidebar-box-detail h4{
	margin-bottom:4px;
	font-size:22px;
}
.sidebar-box-detail .desination, .sidebar-box-detail .location{
	font-weight:500;
	font-size:15px;
	display:block;
	color:#677484;
}
.sidebar-box-extra ul {
    margin: 15px 0;
	padding:0;
}
.sidebar-box-extra ul li {
    display: inline-block;
    list-style: none;
    padding:3px 15px;
    border: 1px solid #b9c5ce;
    border-radius: 50px;
    margin: 5px;
    font-weight: 500;
    color: #657180;
}
.sidebar-box-extra ul li.more-skill{
	color:#ffffff;
	border-color:#1194f7;
}
a.btn.btn-sidebar {
    padding: 17px;
    display: inline-block;
    width: 100%;
    font-size: 16px;
    font-weight: 500;
    border-radius: 0;
}
a.btn.btn-sidebar{
	color:#333333;
	background: #fff;
    border-top: 1px solid #eaeff5;
}
a.btn.btn-sidebar:hover, a.btn.btn-sidebar:focus{
	background:#00a0e3;
	color:#ffffff;
}
.cl-success {
    color: #00a0e3 !important;
}
ul.status-detail {
    width: 100%;
    display: table;
    margin:20px 0;
}
ul.status-detail li {
    display: inline-block;
    width: 33%;
    padding: 10px 0;
    border: none;
    border-radius: 0;
    text-align: center;
    display: table-cell;
	font-size:13px;
}
ul.status-detail li>strong {
    display: block;
    font-weight: 600;
    font-size: 16px;
}

.offer-bttn{
    border:2px solid #00a0e3;
    color:#00a0e3;
      -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
}
.offer-bttn:hover{
    background:#00a0e3;
    color:#fff;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
}



');
$script = <<< JS
  
JS;
$this->registerJs($script);