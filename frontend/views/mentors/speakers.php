<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="speaker-header">
    <div class="container">
        <div class="row">
            <div class="header-flex">
            <div class="col-lg-6 mx-auto order2">
                <h2 class="section-title">Speakers</h2>
            </div><!-- col end-->
            <div class="col-lg-6 order1">
                <div class="speaker-header-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/webinar/webinar-vector.png')?>">
                </div>
            </div>
            </div>
        </div><!-- row end-->
    </div>
    <div class="header-icons">
        <img src="<?= Url::to('@eyAssets/images/pages/webinar/top-left.png')?>">
        <img src="<?= Url::to('@eyAssets/images/pages/webinar/top-right.png')?>">
        <img src="<?= Url::to('@eyAssets/images/pages/webinar/top-center.png')?>">
        <img src="<?= Url::to('@eyAssets/images/pages/webinar/bottom-left.png')?>">
        <img src="<?= Url::to('@eyAssets/images/pages/webinar/bottom-right.png')?>">
    </div>
</div>
<!-- ts speaker start-->
<section>
    <div class="container">
        <div class="row">
            <div class="loader_screen">
                <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
            </div>
            <div id="speakers_card">

            </div>
            <div class="align_btn">
                <button id="loader" class="btn btn-success">Load More</button>
            </div>
        </div>
    </div>
</section>

<!-- ts speaker end-->
<?php
echo $this->render('/widgets/mustache/speakers-card');
$this->registerCss('
.loader_screen img
{
display:none;
margin:auto
}
.align_btn {
    text-align: center;
    clear: both;
    margin: 20px 0;
}
.header-icons{
    position: absolute;
    width: 100%;
    height: 100%;
}
.header-icons img:nth-child(1){
    top: 0;
    left: 0;
    position: absolute;
    max-width: 175px;
    width: 100%;
}
.header-icons img:nth-child(2){
    top: 0;
    right: 0;
    position: absolute;
}
.header-icons img:nth-child(3){
    top: 0%;
    left: 50%;
    transform: translateX(-50%);
    position: absolute;
}
.header-icons img:nth-child(4){
    bottom: 0;
    left: 0;
    position: absolute; 
}
.header-icons img:nth-child(5){
    bottom: 0;
    right: 0;
    position: absolute; 
}
@media screen and (max-width: 768px){
    .header-flex{
        flex-direction: column;
    }
    .order1{
        order: 1;
    }
    .order2{
        order: 2;
    }
}
@media screen and (max-width: 650px){
    .header-icons img{
        display: none;  
    }
}
.speaker-header{
    background: #000036;
    height: 500px;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: bottom center;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    position: relative;
}
.header-flex{
    display: flex;
    align-items: center;
}
#footer{
    margin-top: 0px;
}

');
$script = <<<JS
var offset = 0;
$(document).on('click','#loader',function(e) {
  e.preventDefault();
  fetchNews(template=$('#speakers_card'),limit_dept=12,offset = offset+12,loader=false,loader_btn=true);
})
fetchNews(template=$('#speakers_card'),limit_dept=12,offset=0,loader=true,loader_btn=false);

   
JS;
$this->registerJs($script);
