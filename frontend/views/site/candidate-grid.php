<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = false;
?>
<section class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header-content">
                    <div class="vertically-center">
                        <div class="main-tagline">Want to attract top talent ?</div>
                        <div class="main-text">Showcase Your Profile, Create your Brand, Find Empowered Candidates &
                            Save Time On Hiring Candidates.</div>
                        <div class="main-text"><span>Increase Your Efficiency & Effectiveness.</span></div>
<!--                        <div class="main-bttn">-->
<!--                            <a href="/signup/organization" class="button2">Create Account-->
<!--                                <span><i class="fa fa-arrow-right"></i></span> </a>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <h1 class="heading-style">Candidates</h1>
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="paid-candidate-container">
                    <div class="paid-candidate-box">
                        <div class="dropdown">
                            <div class="btn-group fl-right">
                                <button type="button" class="btn-trans" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-gear"></i>
                                </button>
                                <div class="dropdown-menu pull-right animated flipInX">
                                    <a href="#">Shortlist</a>
                                    <a href="#">Send Message</a>
                                    <a href="#">Dislike</a>
                                </div>
                            </div>
                        </div>
                        <div class="paid-candidate-inner--box">
                            <div class="paid-candidate-box-thumb">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>" class="img-responsive img-circle" alt="" />
                            </div>
                            <div class="paid-candidate-box-detail">
                                <h4>Daniel Disroyer</h4>
                                <span class="desination">App Designer</span>
                            </div>
                        </div>
                        <div class="paid-candidate-box-extra">
                            <ul>
                                <li>Php</li>
                                <li>Android</li>
                                <li>Html</li>
                                <li class="more-skill bg-primary">+3</li>
                            </ul>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui.</p>
                        </div>
                    </div>
                    <a href="paid-candidater-detail.html" class="btn btn-paid-candidate bt-1">View Detail</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="paid-candidate-container">
                    <div class="paid-candidate-box">
                        <div class="dropdown">
                            <div class="btn-group fl-right">
                                <button type="button" class="btn-trans" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-gear"></i>
                                </button>
                                <div class="dropdown-menu pull-right animated flipInX">
                                    <a href="#">Shortlist</a>
                                    <a href="#">Send Message</a>
                                    <a href="#">Dislike</a>
                                </div>
                            </div>
                        </div>
                        <div class="paid-candidate-inner--box">
                            <div class="paid-candidate-box-thumb">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>" class="img-responsive img-circle" alt="" />
                            </div>
                            <div class="paid-candidate-box-detail">
                                <h4>Daniel Disroyer</h4>
                                <span class="desination">App Designer</span>
                            </div>
                        </div>
                        <div class="paid-candidate-box-extra">
                            <ul>
                                <li>Php</li>
                                <li>Android</li>
                                <li>Html</li>
                                <li class="more-skill bg-primary">+3</li>
                            </ul>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui.</p>
                        </div>
                    </div>
                    <a href="paid-candidater-detail.html" class="btn btn-paid-candidate bt-1">View Detail</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="paid-candidate-container">
                    <div class="paid-candidate-box">
                        <div class="dropdown">
                            <div class="btn-group fl-right">
                                <button type="button" class="btn-trans" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-gear"></i>
                                </button>
                                <div class="dropdown-menu pull-right animated flipInX">
                                    <a href="#">Shortlist</a>
                                    <a href="#">Send Message</a>
                                    <a href="#">Dislike</a>
                                </div>
                            </div>
                        </div>
                        <div class="paid-candidate-inner--box">
                            <div class="paid-candidate-box-thumb">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg')?>" class="img-responsive img-circle" alt="" />
                            </div>
                            <div class="paid-candidate-box-detail">
                                <h4>Daniel Disroyer</h4>
                                <span class="desination">App Designer</span>
                            </div>
                        </div>
                        <div class="paid-candidate-box-extra">
                            <ul>
                                <li>Php</li>
                                <li>Android</li>
                                <li>Html</li>
                                <li class="more-skill bg-primary">+3</li>
                            </ul>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui.</p>
                        </div>
                    </div>
                    <a href="paid-candidater-detail.html" class="btn btn-paid-candidate bt-1">View Detail</a>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
$this->registerCss('
.header{
    background:url(' . Url::to('@eyAssets/images/pages/index2/cover-image.png') . ');
    background-repeat:no-repeat; 
    background-size:cover;
}
.header-content{
    height:400px;
}
.vertically-center{
    position: relative;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
}
.main-tagline{
    color:#fff;
    font-family:lobster;
    font-size:40px;
}
.main-text{
    color:#fff;
    font-size:17px;
    max-width:600px;
    line-height:27px;
}
.main-text span{
    background:#000;
    padding:2px 5px;
}
.main-bttn{
    padding-top:20px;
}
/*-------*/
.paid-candidate-container{
    background: #ffffff;
    border-radius: 6px;
    overflow: hidden;
	text-align:center;
    margin-bottom:30px;
	position:relative;
	transition: .4s;
    border:1px solid #eaeff5;
}
.paid-candidate-container:hover, .paid-candidate-container:focus{
    transform: translateY(-5px);
    -webkit-transform: translateY(-5px);
	cursor:pointer;
}
.paid-candidate-box{
    text-align: center;
    padding:60px 20px 15px;
}
.paid-candidate-status {
    position: absolute;
    left:32px;
    top: 25px;
    background:#01c73d;
    color: #ffffff;
    padding: 4px 18px;
    border-radius: 50px;
    font-weight: 500;
}

.flc-rate{
    position: absolute;
    right:32px;
    top: 20px;
    font-size:18px;
    font-weight: 500;
}

.paid-candidate-box-thumb {
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

.paid-candidate-box-detail h4{
	margin-bottom:4px;
	font-size:20px;
}
.paid-candidate-box-detail .desination, .paid-candidate-box-detail .location{
	font-weight:500;
	font-size:15px;
	display:block;
	color:#677484;
}
.paid-candidate-box-extra ul {
    margin: 15px 0;
	padding:0;
}
.paid-candidate-box-extra ul li {
    display: inline-block;
    list-style: none;
    padding:3px 15px;
    border: 1px solid #b9c5ce;
    border-radius: 50px;
    margin: 5px;
    font-weight: 500;
    color: #657180;
}
.paid-candidate-box-extra ul li.more-skill{
	color:#ffffff;
	border-color:#1194f7;
}
a.btn.btn-paid-candidate {
    padding: 17px;
    display: inline-block;
    width: 100%;
    font-size: 16px;
    font-weight: 500;
    border-radius: 0;
}

a.btn.btn-paid-candidate:hover, a.btn.btn-paid-candidate:focus{
	background:#00a0e3; 
	color:#ffffff;
	-webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    -ms-transition: all .3s ease-in-out;
    transition: all .3s ease-in-out;
}
.paid-candidate-box .dropdown{
	position:absolute;
	right:30px;
	top:25px;
}
.btn-trans {
    background: transparent;
    border: none;
	font-size:20px;
    color:#99abb9;
}

.dropdown-menu.pull-right {
    right: 0;
    left: auto !important;
    top: 90% !important;
}
.dropdown-menu.pull-right {
    right: 0;
	border-color: #ebf2f7;
	padding: 0;
    left: auto !important;
    top: 90% !important;
}
.dropdown-menu>a {
    display: block;
    padding: 14px 12px 14px 12px;
    clear: both;
    font-weight: 300;
    line-height: 1.42857143;
    color: #67757c;
    border-bottom: 1px solid #f1f6f9;
}
.bt-1 {
    border-top: 1px solid #eaeff5!important;
}

');
$script = <<< JS
  
JS;
$this->registerJs($script);
