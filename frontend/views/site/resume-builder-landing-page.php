<?php

use yii\helpers\Url;

$this->params['header_dark'] = false;
?>
<section class="header-res">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 col-sm-5 col-md-offset-1">
                <div class="head-txt">
                    <h1>Resume Builder</h1>
                    <h2>Now Create Your Resume Efficiently To Crack Your Dream Job Interview With The <span class="org-txt">Best CV Templates</span>.</h2>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="head-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/resume1.png') ?>"/>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
        <div class="container">
            <div class="row mt-20">
                <div class="col-md-12">
                    <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'Benefits Of Using CV Templates'); ?></h2>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12">
                <div class="benefit">
                    <div class="benefit-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/resume-builder/organize.png'); ?>"/>
                    </div>
                </div>
            </div>
            </div>
</section>

<?php
$this->registerCss('
body{
    margin: 0px;
}
.container-fluid{
    padding: 0 !important;
}
.header-res{
    background-image: url(' . Url::to('@eyAssets/images/pages/resume-builder/resume-builder-bg.png') . ');
    min-height: 500px;
    background-position: bottom-left;
    background-repeat: no-repeat;
    background-size: cover;
}
.head-txt{
    padding-top: 190px;
}
.head-txt h1{
    font-size: 60px;
	font-family: lobster;
	font-weight: 600;
	color: #fca943;
}
.head-txt h2{
    font-weight: 600;
    font-size: 20px;
    font-family: lora;
    margin-bottom: 20px;
}
.head-img{
    text-align: right;
}
.head-img img{
    width: 75%;
}
.org-txt{
    color: #fca943;
}
.benefit-icon{
    text-align: center;
    width: 100%;
    max-width: 120px;
    height: 100%;
    max-height: 120px;
    min-height: 120px;
    margin: 0 auto 20px;
    border-radius: 80px;
}
');














