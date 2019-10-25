<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = false;
?>

    <section class="backgrounds">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="text-white">The Easiest Way to Find Best Institutes</h2>
                    <h4 class="text-white">“Learning never exhausts the mind”</h4>
                    <div class="search-by-type">
                        <form class="form-inline" action="<?= Url::to('/training-programs/list?'); ?>">
                            <div class="input-group mb-10 mr-10 col-md-5">
                                <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                <input type="text" name="keyword" class="form-control"
                                       placeholder="Course Title or Keywords or Institute"/>
                            </div>
                            <div class="input-group mb-10 mr-10 col-md-3">
                                <span class="input-group-addon set-heights"><i
                                        class="fas fa-map-marker-alt"></i></span>
                                <input type="text" name="location" class="form-control" autocomplete="off"
                                       placeholder="City or State"/>
                            </div>
                            <div class="form-group mb-10 mr-10">
                                <input type="submit" class="form-control submit-next" id="form_control_1"
                                       value="Search">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row mt-20">
                <div class="col-md-12 col-sm-12">
                    <h1 class="heading-style">Most Active Profiles</h1>
                </div>
            </div>
            <div class="col-md-12">
                <div class="categories"></div>
            </div>
        </div>
    </section>

    <section class="bg-lighter">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <h1 class="heading-style">Featured Courses</h1>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="type-1">
                        <div>
                            <a href="<?=  Url::to('/training-programs/list'); ?>" class="btn btn-3">
                                <span class="txt">View all</span>
                                <span class="round"><i class="fas fa-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="blogbox"></div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="heading-style">Featured Institutes</h1>
                    <div class="row">
                        <div class="institutes_list"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/mustache/category-card');
echo $this->render('/widgets/mustache/training_cards/cards');
echo $this->render('/widgets/mustache/training_cards/institutes_cards');
$this->registerCss('
.marg{margin-left:-3px;}
.backgrounds{
    background-image: url("' . Url::to("@eyAssets/images/pages/training-program/institute.png") . '");
    background-repeat: no-repeat;
    min-height: 520px;
    padding-top: 150px;
    background-size: cover;
    background-position: 43%;
}
.text-white{
    color:white;
    font-family:roboto;
    }
.search-by-type {
    width: 84%;
    background-color: #14141459;
    padding: 2px 20px;
    color: #fff;
    margin: auto;
    border-radius: 10px;
    margin-top: 20px;
    padding-top: 20px;
}
.form-control{
    font-family:Roboto;
    font-weight:300;
    }
.submit-next {
    border-radius: 4px;
    min-width: 180px !important;
    background-color: #f07d1b;
    color: #FFF;
    border-color: transparent;
    font-family:Roboto;
    font-weight:400 !important;
}
.company-info {
    display: inline-block;
    padding: 25px 40px;
    -webkit-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
    box-shadow: 0 2px 5px 0 rgba(32,32,32,.1);
    border-radius: 8px;
}
a.company-inner:hover .company-info, a.company-inner:hover .company-info {
    outline: none;
    box-shadow: 0 0 30px 0 rgba(32,32,32,.15);
}
a.company-inner {
    display: inline-block;
}
.company-info img, .company-info canvas {
    display: block;width: 80px;height: 80px;
    }
.search-lists{
    padding:20px 0 50px;
    text-transform:capitalize;
    background:#ecf5fe;
    margin-top:30px;
}
.list-heading{
    font-size:16px;
    font-weight:500;
    font-family:Roboto;
}
.quick-links li a{
    line-height:23px;
    font-size:13px;
    font-family:Roboto;
    font-weight:300;
}
.quick-links li a:hover{
    color:#00a0e3;
}
.quick-links{
    padding-top:0px;
}
.showHideBtn {
    background: none;
    border: none;
    color: #00a0e3;
    padding: 0;
    font-size: 14px;
    }
.footer{
    margin-top:0px !important;
    }
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

.txt {
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
');
$script = <<< JS
loader = false;
getCards("Trainings");
getCategories("Trainings");
getInstitutes();
JS;
$this->registerJs($script);