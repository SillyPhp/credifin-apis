<?php

use yii\helpers\Url;

if ($type == 'internships') {
    $url = '/internships-in-';
} else {
    $url = '/jobs-in-';
}
?>

    <section id="scroll-here">
        <div class="block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="heading-set">
                                <h2 class="heading-style"> International Employment Opportunities </h2>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="type-1">
                                <div>
                                    <a href="<?= Url::to('/jobs/international'); ?>" class="btn btn-3">
                                        <span class="txting"><?= Yii::t('frontend', 'View all'); ?></span>
                                        <span class="round"><i class="fas fa-chevron-right"></i></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="cat-sec">
                            <div class="row no-gape owl-carousel country-carousel" id="country-carousel">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0 fb-25 item">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url . 'canada') ?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/canada.png') ?>" alt="work around the world,working around the world jobs,find jobs around the world,job opportunities around the world,jobs all around the world">
                                            <span>Canada</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0 fb-25 item">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url . 'usa') ?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/usa.png') ?>" alt="work around the world,working around the world jobs,find jobs around the world,job opportunities around the world,jobs all around the world">
                                            <span>USA</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0 fb-25 item">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url . 'singapore') ?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/singapore.png') ?>" alt="work around the world,working around the world jobs,find jobs around the world,job opportunities around the world,jobs all around the world">
                                            <span>Singapore</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0 fb-25 item">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url . 'india') ?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/india.png') ?>" alt="work around the world,working around the world jobs,find jobs around the world,job opportunities around the world,jobs all around the world">
                                            <span>India</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0 fb-25 item">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url . 'germany') ?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/germany.png') ?>" alt="work around the world,working around the world jobs,find jobs around the world,job opportunities around the world,jobs all around the world">
                                            <span>Germany</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0 fb-25 item">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url . 'uk') ?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/uk.png') ?>" alt="work around the world,working around the world jobs,find jobs around the world,job opportunities around the world,jobs all around the world">
                                            <span>UK</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0 fb-25 item">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url . 'thailand') ?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/thailand.png') ?>" alt="work around the world,working around the world jobs,find jobs around the world,job opportunities around the world,jobs all around the world">
                                            <span>Thailand</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 p-0 fb-25 item">
                                    <div class="p-category">
                                        <a href="<?= Url::to($url . 'china') ?>" title="">
                                            <img src="<?= Url::to('@eyAssets/images/pages/world-job/china.png') ?>" alt="work around the world,working around the world jobs,find jobs around the world,job opportunities around the world,jobs all around the world">
                                            <span>China</span>
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
.block {
    padding: 20px 0;
    overflow: hidden;
}
/*    <!-- view-all button css start -->*/
.btn-3 {
    background-color: #424242;
}
.btn-3 .round {
    background-color: #737478;
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
    color: #333332;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}

.txting {
    font-size: 14px;
    line-height: 1.45;
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

/*<!---- view-all button css ends --->*/

.p-0{
    padding:0;
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
    flex-wrap: wrap;
}

.row.no-gape .item{
    margin: 0 !important;
}
.fb-25{
    flex-basis: 25%;
}
.p-category {
    float: left;
    width: 100%;
    z-index: 1;
    position: relative;
    transition: all 0.3s ease 0s;
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
    background: #ffffff;
    box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    border-radius: 8px;
    z-index: 10;
    transition: all 0.3s ease 0s;
    transform: scale(1.05);
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
.cat-sec .row > div:nth-child(4n) a {
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
    #country-carousel .item img{
        margin: auto;
    }
    #country-carousel .owl-controls .owl-nav .owl-prev i, #country-carousel .owl-controls .owl-nav .owl-next i{
        font-size: 40px !important;
    }
    #country-carousel .owl-controls .owl-nav .owl-prev {
        left: -20px !important;
    }
    #country-carousel .owl-controls .owl-nav .owl-next {
        right: -20px !important;
    }
}
');

$script = <<<JS
$(document).ready(function () {
    if ($(window).width() > 500){
        $('.country-carousel').removeAttr('id');
    }
    $('#country-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
          ],
        responsive:{
            0:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
});

JS;
$this->registerJs($script);
?>