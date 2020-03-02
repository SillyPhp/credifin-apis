<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = false;

if($type == 'internships'){
    $url = '/internships-in-';
} else{
    $url = '/jobs-in-';
}
?>

    <section class="header-set">
        <div class="container">
            <div class="row">
                <div class="col-md-12"></div>
            </div>
        </div>
    </section>

    <section id="scroll-here">
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="heading-set">
                            <h1 class="heading-style mt-50">Popular Countries</h1>
                        </div><!-- Heading -->
                        <div class="cat-sec">
                            <div class="row no-gape">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'canada')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/canada.png') ?>">
                                            <span>Canada</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'us')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/usa.png') ?>">
                                            <span>USA</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'singapore')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/singapore.png') ?>">
                                            <span>Singapore</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'india')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/india.png') ?>">
                                            <span>India</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cat-sec">
                            <div class="row no-gape">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'germany')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/germany.png') ?>">
                                            <span>Germany</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'uk')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/uk.png') ?>">
                                            <span>UK</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'dubai')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/uae.png') ?>">
                                            <span>UAE</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'china')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/china.png') ?>">
                                            <span>China</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cat-sec">
                            <div class="row no-gape">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'japan')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/japan.png') ?>">
                                            <span>Japan</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'malaysia')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/malaysia.png') ?>">
                                            <span>Malaysia</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'spain')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/spain.png') ?>">
                                            <span>Spain</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'italy')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/italy.png') ?>">
                                            <span>Italy</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cat-sec">
                            <div class="row no-gape">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'france')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/france.png') ?>">
                                            <span>France</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'australia')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/australia.png') ?>">
                                            <span>Australia</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'new-zealand')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/newzealan.png') ?>">
                                            <span>New Zealand</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url .'hong-kong')?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/hong-kong.png') ?>">
                                            <span>Hong Kong</span>
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
.header-set{
    background:url(' . Url::to('@eyAssets/images/pages/world-job/world-jobs1.png') . ');
    background-repeat:no-repeat; 
    background-size:cover;
    min-height:450px;
    background-position:right top;
}
.heading-set {
    float: left;
    width: 100%;
    text-align: center;
    margin-bottom: 40px;
}
.hr_under_line {
    font-size:30px;
    text-align:center;
    text-decoration: none; 
    position: relative;
    font-family:Lora;
    cursor:default;
} 
.hr_under_line:after {
    position: absolute;
    content: "";
    height: 2px;
    bottom: -4px; 
    margin: 0 auto;
    left: 0;
    right: 0;
    width: 20%;
    background: #00a0e3;
    -o-transition:.5s;
    -ms-transition:.5s;
    -moz-transition:.5s;
    -webkit-transition:.5s;
    transition:.5s;
}
.hr_under_line:hover:after {
    width: 22%;
    background:#ff7803;
}   
.cat-sec {
    float: left;
    width: 100%;
}
.row.no-gape {
    margin: 0;
    display: flex;
}
.p-category {
    float: left;
    width: 100%;
    z-index: 1;
    position: relative;
}
.p-category > a{
    padding-bottom: 30px;
    padding-top: 30px;
    float: left;
    width: 100%;
    text-align: center;
    border-bottom: 1px solid #e8ecec;
    border-right: 1px solid #e8ecec;
}
.p-category:hover a {
    border-color: #ffffff;
}
.p-category:hover {
    background:#ffffff;
    box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    border-radius: 8px;
    width: 104%;
    margin-left: -2%;
    margin-top: -2%;
    height: 104%;
    z-index: 10;
    transition: all 0.4s ease 0s;
}
.p-category > a span{
    font-family: roboto;
    font-weight: 400;
    float: left;
    width: 100%;
    font-size: 18px;
    color:#232323;
    margin-top: 20px;
}
.p-category img{
    width:85px;
    height:85px;
}
.cat-sec .row > div:last-child a {
    border-right-color: #ffffff;
}
.cat-sec:last-child a {
    border-bottom-color: #ffffff;
}
@media (max-width:500px){
    .hr_under_line:after {
        width:55%;
    }
    .p-category > a {
        border-right: none;
    }
    .hr_under_line{
        font-size: 25px;
    }
    .row.no-gape{
        display:block;
    }
    .cat-sec:last-child a {
        border-bottom-color: #e8ecec;
    }
    .cat-sec:last-child .col-md-3:last-child a {
        border-bottom-color: #ffffff;
    }
}
');