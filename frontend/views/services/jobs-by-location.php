<?php

use yii\widgets\Pjax;

$this->title = Yii::t('frontend', 'Jobs By Location');
$this->params['header_dark'] = true;

use yii\helpers\Url;

$this->registerCssFile('https://fonts.googleapis.com/css?family=Crimson+Text');
$this->registerCss('
.owl-item{
    min-height:150px !important;
}
.partners-flex-box .logo-box:hover {
    -webkit-box-shadow: 0 17px 27px -9px #757575;
    box-shadow: 0 17px 27px -9px #757575;
    -webkit-transition: -webkit-box-shadow .7s !important;
    transition: -webkit-box-shadow .7s !important;
    transition: box-shadow .7s !important;
    transition: box-shadow .7s, -webkit-box-shadow .7s !important;
}
.partners-flex .partners-flex-box {
    width: 20%;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box2 {
    width:20%;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 65px;
    width: 65px;
    background-color: #fff;

}


.partners-flex .partners-flex-box {
    width: 20%;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .industrybox {
    height: 90px;
    width: 90px;
    background-color: #fff;
}
.partners-flex .partners-flex-box .logo-box {
    height: 90px;
    width: 90px;
    background-color: #fff;
}
.partners-flex .partners-flex-box {
    width: 130px;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.partners-flex .partners-flex-box .logo-box {
    height: 120px;
    width: 120px;
    background-color: #fff;
}
.partners-flex .partners-flex-box2 .industrybox {
    height: 200px;
    width:100%;
    padding:40px 10px;
    background-color: #fff;
    font-size:16px;
    
    
}
.partners-flex .partners-flex-box .image-partners {
    height: 114px;
    margin: 2px;
    cursor: pointer;
    padding: 6px;
    width: 116px;
}
.partners-flex {
    width: 90%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap;
    margin: 1.5% auto;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}
.set_logo{
    display: table-cell;
    vertical-align: middle;
    height: 125px;
}
.custom_color:hover{
    color:#f08340 !important;
}
.custom_color2{
    color:#fff !important;
}
.custom_color2:hover{
    color: #202c45 !important;
}
.custom_set{
    margin-bottom: 0px !important;
    margin-top: 0px !important;
}
.custom_set2{
    margin-bottom: 0px !important;
}
.btn-add-to-cart-wrapper{
    margin-bottom: 10px !important;
    z-index:99999;
}
.btn-add-to-cart-wrapper a{
    padding:10px 15px !important;
}
.top-container {
    background-color: #f1f1f1;
    padding: 30px;
    text-align: center;
}
.sticky {
    position: fixed;
    top: 0;
}
.sticky + .content {
    padding-top: 80px;
}
.set_icon{
    background:transparent !important;
}
.item{
    display: block;
    padding: 30px 0px;
    margin: 5px;
    color: #FFF;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    text-align: center;
}
.owl-controls .nav div {
    padding: 5px 9px;
}
.owl-nav i{
    margin-top: 2px;
}
.owl-controls .owl-nav div {
    position: absolute;
}
.owl-controls .owl-nav .owl-prev{
    left: -60px;
    top: 50px;
}
.owl-controls .owl-nav .owl-prev i,.owl-controls .owl-nav .owl-next i{
    font-size:64px !important;
}
.owl-controls .owl-nav .owl-prev,.owl-controls .owl-nav .owl-next{
    background: transparent !important;
}
.owl-controls .owl-nav .owl-next{
    right: -60px;
    top: 50px;
}
@media only screen and (max-width: 991px) {
    .side-body{
        margin-left: 168px;
    }
}
.input-group{
    width: 100%;
    margin-bottom:10px;
}
.input-group-btn:last-child>.btn, .input-group-btn:last-child>.btn-group{
    height: 45px;
}
.btn_effect{
    transition: all .5s ease;
    border-radius: 3px;
}
.btn_effect:hover{
    color: #fff !important;
}
.is-active{
    box-shadow: 0px 16px 21px -10px #000;
    transform: translateY(6px);
}
.change-hr{
    margin-bottom: 30px;
    margin-top: 15px;
    border-top: 1px solid #ccc;
    width:100%;
}
#menuzord-right{
    padding:0px !important;
}
.blogbox{
    margin-bottom: 20px;
}

a:hover {
    text-decoration: none;
}
#loadMore {
    text-align: center;
    background-color: #202c45;
    color: #fff !important;
    border-width: 0 0px 0px 0;
    border-radius: 12px;
    border-style: solid;
    border-color: #fff;
    box-shadow: 0 6px 10px #868686;
    transition: all 600ms ease-in-out;
    -webkit-transition: all 600ms ease-in-out;
    -moz-transition: all 600ms ease-in-out;
    -o-transition: all 600ms ease-in-out;
}
#loadMore:hover {
    background-color: #f08340;
    color: #fff;
}
#loadMore h4{
    color:#fff !important;
}
.btn-div{
    margin-top: 20px;
    padding-top: 20px;
    margin-bottom: 20px;
}
.blogbox *:not(i){
    font-family: Georgia !important;
}
.round{
    border-radius: 10px;
    color:white;
}
.icon-box
{
    padding: 0px 0px !important;
}

.round-info{
    border-radius: 10px;
    background: darkgrey;
    box-shadow: 0 1px 3px 0px #797979;
}
.round-info-upper{
    border-radius: 10px 10px 0px 0px;
    background: darkgrey;
}
.round-info-lower{
    border:1px;
    border-radius: 10px 10px 10px 10px;
    box-shadow: 0 1px 3px 0px #797979;
}
.info{
    background:#f9f9f9;
}
.shadow{
    box-shadow: 0 1px 3px 0px #797979;
}
.product{
    margin-bottom:0px !important;
    margin-top:0px !important;
}
.ui-draggable{
    padding: 0px 10px 10px 10px;
}
.hr{
    margin-bottom: 0px !important;
    margin-top: 0px !important;
}
.tag-sale color-o {
    background:#FF4500  !important; 
}
.color-o{
    background:#FF4500 !important;
}
.tag-sale{
    font-family:arial;
}
#thumbnail-slider {
    margin:0 auto; /*center-aligned*/
    width:100%;/*width:400px;*/
    max-width:600px;
    padding:20px;
    background-color:#f2f1ea;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    box-sizing:border-box;
    position:relative;
    -webkit-user-select: none;
    user-select:none;
}
#thumbnail-slider div.inner {
    /*the followings should not be changed */
    position:relative;
    overflow:hidden;
    padding:2px 0;
    margin:0;
}
#thumbnail-slider div.inner ul {
    /*the followings should not be changed */
    white-space:nowrap;
    position:relative;
    left:0; top:0;
    list-style:none;
    font-size:0;
    padding:0;
    margin:0;
    float:left!important;
    width:auto!important;
    height:auto!important;
}
#thumbnail-slider ul li {
    display:inline-block;
    *display:inline!important; /*IE7 hack*/
    border:3px solid black;
    margin:0;
    margin-right:10px; /* Spacing between thumbs*/
    transition:border-color 0.3s;
    box-sizing:content-box;
    text-align:center;
    vertical-align:middle;
    padding:0;
    position:relative;
    list-style:none;
    backface-visibility:hidden;
}
#thumbnail-slider ul li.active {
    border-color:white;
}
#thumbnail-slider .thumb {
    opacity:1;
    width:100%;
    height: 100%;
    background-size:contain;
    background-repeat:no-repeat;
    background-position:center center;
    display:block;
    position:absolute;
    font-size:0;
}
#thumbnail-slider-pause-play {display:none;} /*.pause*/
#thumbnail-slider-prev, #thumbnail-slider-next
{
    opacity:1;
    position: absolute;
    *background-color:#ccc;/*IE7 hack*/
    backface-visibility:hidden;
    width:32px;
    height:60px;
    line-height:60px;
    top: 50%;
    margin:0;
    margin-top:-30px;
    color:white;    
    z-index:10;
    cursor:pointer;
}
#thumbnail-slider-prev {
    left:-30px; right:auto;
}
#thumbnail-slider-next {
    left:auto; right:-30px;
}
#thumbnail-slider-next.disabled, #thumbnail-slider-prev.disabled {
    opacity:0.3;
    cursor:default;
}
/* arrows */
#thumbnail-slider-prev::before, #thumbnail-slider-next::before {
    position: absolute;
    top: 19px;
    content: "";
    display: block;
    width: 12px;
    height: 12px;
    border-left: 6px solid black;
    border-top: 6px solid black;
}
#thumbnail-slider-prev::before {
    left:7px;
    -ms-transform:rotate(-45deg);/*IE9*/
    -webkit-transform:rotate(-45deg);
    transform: rotate(-45deg);
}
#thumbnail-slider-next::before {
    right:7px;
    -ms-transform:rotate(135deg);/*IE9*/
    -webkit-transform:rotate(135deg);
    transform: rotate(135deg);
}
/*Responsive settings*/
@media only screen and (max-width:736px){
    #thumbnail-slider {padding:10px 26px;}
    #thumbnail-slider-prev {left:0px;}
    #thumbnail-slider-next {right:0px;}
}
#thumbs2 {
    height:300px; 
    display:inline-block;
    *display:inline; /* hack for old IE6-7 */
    background-color:#fff;
    box-shadow: 0px 1px 11px rgba(0,0,0,0.2);
    padding:16px;
    position:relative;
    -webkit-user-select: none;
    user-select:none;
}
#thumbs2 div.inner {
    width:auto;
    padding:2px;
    /*the followings should not be changed */
    height:100%;
    box-sizing:border-box;
    position:relative;
    overflow:hidden;
    margin:0 auto;
}
#thumbs2 div.inner ul {
    /*the followings should not be changed */
    position:relative;
    left:0; top:0;
    list-style:none;
    font-size:0;
    padding:0;
    margin:0;
    float:left!important;
    width:auto!important;
    height:auto!important;
}
#thumbs2 ul li {
    display:block;
    border: 4px solid transparent;
    outline:1px solid transparent;
    margin:0;
    margin-bottom:3px; /* Spacing between thumbs*/
    box-sizing:content-box;
    text-align:center;
    padding:0;
    position:relative;
    list-style:none;
    backface-visibility:hidden;
}
#thumbs2 ul li.active {
    outline-color:black;
}
#thumbs2 li:hover {
    border-color:rgba(255,255,255,0.5);
}
#thumbs2 .thumb {
    width:100%;
    height: 100%;
    background-size:contain;
    background-repeat:no-repeat;
    background-position:center center;
    display:block;
    position:absolute;
    font-size:0;
}
#thumbs2-pause-play {display:none;} /*.pause*/
#thumbs2-prev, #thumbs2-next
{
    position: absolute;
    width:100%;
    height:30px;
    line-height:30px;
    text-align:center;
    margin:0;
    z-index:10;
    cursor:pointer;
    transition:opacity 0.6s;
    *background-color:#ccc;/*IE7 hack*/
    backface-visibility:hidden;
}
#thumbs2-prev {
    top:-36px;
}
#thumbs2-next {
    bottom:-36px;
}
#thumbs2-next.disabled, #thumbs2-prev.disabled {
    opacity:0.1;
    cursor:default;
}
/* arrows */
#thumbs2-prev::before, #thumbs2-next::before {
    position:absolute;
    content: "";
    display: inline-block;
    width: 10px;
    height: 10px;
    margin-left:-20px;
    border-left: 4px solid black;
    border-top: 4px solid black;
}
#thumbs2-prev::before {
    top:12px;
    -ms-transform:rotate(-45deg);/*IE9*/
    -webkit-transform:rotate(45deg);
    transform: rotate(45deg);
}
#thumbs2-next::before {
    bottom:12px;
    -ms-transform:rotate(135deg);/*IE9*/
    -webkit-transform:rotate(-135deg);
    transform: rotate(-135deg);
}
.general-partners .partners .partners-flex .partners-flex-box {
    width: 130px;
    -o-object-fit: contain;
    object-fit: contain;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
/*Industry row*/

.border-top-set{
    border-top: 1px solid #ccc;
    padding-top: 20px;
}
');
?>
<section>
    <div class="row">
    <div class="col-md-2">
        <?=
        $this->render('/widgets/sidebar-review', [
            'type' => 'jobs',
        ]);
        ?>
    </div>
    <div class="col-md-10">
        <div class="row side-body">
            <?=
            $this->render('/widgets/search-bar', [
                'category' => 'location',
                'locations' => $locations,
            ]);
            ?>
            <div class="border-top-set col-md-12">
                <?php
                Pjax::begin(['id' => 'pjax_result']);
                ?>
                <!--<div class="col-md-12">-->
                    <?php
                    $total_cards = count($cards);
                    $rows = ceil($total_cards / 3);
                    $next = 0;
                    for ($i = 1; $i <= $rows; $i++) {
                        ?> <div class="row work-load blogbox">
                        <?php
                        for ($j = 0; $j < 3; $j++) {
                            if ($next < $total_cards) {
                                ?> 
                                    <div class="col-md-4 pt-5">
                                        <div class="product shadow iconbox-border iconbox-theme-colored">
                                            <span class="tag-sale color-o pl-20 pr-20 "><?php echo $cards[$next]['type']; ?>
                                            </span>
                                            <div class="row">
                                                <div class="col-md-4 col-xs-4 pt-5" >
                                                    <a href="#" class="icon set_logo">
                                                        <?php
                                                        $logo = $cards[$next]['logo'];
                                                        $logo_location = $cards[$next]['logo_location'];
                                                        $logo_image = Yii::$app->params->upload_directories->organizations->logo . $logo_location . DIRECTORY_SEPARATOR . $logo;

                                                        $logo_base_path = Yii::$app->params->upload_directories->organizations->logo_path . $logo_location . DIRECTORY_SEPARATOR . $logo;

                                                        if (!file_exists($logo_base_path)) {
                                                            $logo_image = "http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=No+Logo";
                                                        }
                                                        ?>

                                                        <img src="<?= Url::to($logo_image); ?>">
                                                    </a>
                                                </div>
                                                <div class="col-md-8 col-xs-8 pt-20">
                                                    <h4 class="icon-box-title"> 
                                                        <strong><?php echo $cards[$next]['title']; ?> 
                                                        </strong>
                                                    </h4>
                                                    <h5> 
                                                        <i class="fa fa-location-arrow"></i> 
                                                        <strong><?php echo $cards[$next]['city']; ?>
                                                        </strong>

                                                    </h5>
                                                    <h5>
                                                        <i class="fa fa-map-pin"> 
                                                            Min <?php echo $cards[$next]['experience']; ?> yr exp
                                                        </i>
                                                    </h5>
                                                </div>
                                                <div class="btn-add-to-cart-wrapper" data-key="<?= $cards[$next]['application_enc_id'] ?>" >
                                                    <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/job/<?php echo $cards[$next]['slug']; ?>">VIEW DETAILS
                                                    </a>
                                                    <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                                        <i class="fa fa-plus">
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>
                                            <hr class="hr">
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">
                                                    <h4 class="pull-right pr-10 pt-10 custom_set" align="right">
                                                        <p><strong><?php echo $cards[$next]['org_name']; ?></strong>
                                                        </p>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                $next++;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row blogbox loader-main" style="display: none;">
                        <div class="col-md-4">
                            <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load pl-20 pr-20 ">
                                    <div class="loader anim"></div>
                                </span>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4 pt-5" >
                                        <a href="#" class="icon">
                                            <div class="loader anim"></div>
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-xs-8 pt-20">
                                        <h4 class="icon-box-title">
                                            <strong><div class="loader anim"></div></strong>
                                        </h4>
                                        <h5>
                                            <i class="locations"><div class="loader anim"></div></i>
                                        </h5>
                                        <h5>
                                            <i class="periods"><div class="loader anim"></div></i>
                                        </h5>
                                    </div>
                                </div>
                                <hr class="hr">
                                <div class="col-md-6">
                                    <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                        <br>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="pull-right pt-20 custom_set" align="center">
                                        <strong>
                                            <div class="loader anim"></div>
                                        </strong>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load pl-20 pr-20 ">
                                    <div class="loader anim"></div>
                                </span>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4 pt-5" >
                                        <a href="#" class="icon">
                                            <div class="loader anim"></div>
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-xs-8 pt-20">
                                        <h4 class="icon-box-title">
                                            <strong><div class="loader anim"></div></strong>
                                        </h4>
                                        <h5>
                                            <i class="locations"><div class="loader anim"></div></i>
                                        </h5>
                                        <h5>
                                            <i class="periods"><div class="loader anim"></div></i>
                                        </h5>
                                    </div>
                                </div>
                                <hr class="hr">
                                <div class="col-md-6">
                                    <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                        <br>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="pull-right pt-20 custom_set" align="center">
                                        <strong>
                                            <div class="loader anim"></div>
                                        </strong>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load pl-20 pr-20 ">
                                    <div class="loader anim"></div>
                                </span>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4 pt-5" >
                                        <a href="#" class="icon">
                                            <div class="loader anim"></div>
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-xs-8 pt-20">
                                        <h4 class="icon-box-title">
                                            <strong><div class="loader anim"></div></strong>
                                        </h4>
                                        <h5>
                                            <i class="locations"><div class="loader anim"></div></i>
                                        </h5>
                                        <h5>
                                            <i class="periods"><div class="loader anim"></div></i>
                                        </h5>
                                    </div>
                                </div>
                                <hr class="hr">
                                <div class="col-md-6">
                                    <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                        <br>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="pull-right pt-20 custom_set" align="center">
                                        <strong>
                                            <div class="loader anim"></div>
                                        </strong>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-div" align="center">
                        <a href="#" id="loadMore" class="btn btn-primary" align="center"style="color:white">
                            <h4>Load More 
                                <i class="fa fa-angle-down">
                                </i>
                            </h4>
                        </a>
                    </div>
                    <hr class="change-hr">
                    <div class="esc-heading ml-20">
                        <h3 style="font-family:lobster;font-size:28pt;margin-bottom:0px;text-indent: 50px;">Featured Companies</h3>
                    </div>
                    <div class="row ml-20 mr-20">
                        <div class="partners-flex">
                            <div class="owl-carousel-4col" data-dots="false" data-nav="true">
                                <div class="item partners-flex-box">
                                    <a class="logo-box" href="">
                                        <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/dsbedutech.jpg'); ?>" align="left">
                                    </a>
                                </div>
                                <div class="item partners-flex-box">
                                    <a class="logo-box" href="">
                                        <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/agile.jpg'); ?>" align="left">
                                    </a>
                                </div>
                                <div class="item partners-flex-box">
                                    <a class="logo-box" href="">
                                        <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/dsblaw.jpg'); ?>" align="left">
                                    </a>
                                </div>
                                <div class="item partners-flex-box">
                                    <a class="logo-box" href="">
                                        <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/agile.jpg'); ?>" align="left">
                                    </a>
                                </div>
                                <div class="item partners-flex-box">
                                    <a class="logo-box" href="">
                                        <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/ey.jpg'); ?>" align="left">
                                    </a>
                                </div>
                                <div class="item partners-flex-box">
                                    <a class="logo-box" href="">
                                        <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/dsblaw.jpg'); ?>" align="left">
                                    </a>
                                </div>
                                <div class="item partners-flex-box">
                                    <a class="logo-box" href="">
                                        <img alt="..." class="image-partners" target="_blank" src="<?= Url::to('@eyAssets/images/logos/agile.jpg'); ?>" align="left">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--</div>-->
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
    </div>
</section>
<?php
$script = <<<JS
$('.owl-carousel-5col').owlCarousel({
    loop: true,
    nav: true,
    dots: false,
    pauseControls: true,
    margin: 20,
    responsiveClass: true,
    navText: [
        '<i class="fa fa-angle-left set_icon"></i>',
        '<i class="fa fa-angle-right set_icon"></i>'
    ],
    responsive: {
        0: {
            items: 1
        },
        568: {
            items: 2
        },
        600: {
            items: 3
        },
        1000: {
            items: 4
        },
        1400: {
            items: 7
        }
    }
});
$('.owl-carousel-4col').owlCarousel({
    loop: true,
    nav: true,
    dots: false,
    pauseControls: true,
    margin: 20,
    responsiveClass: true,
    navText: [
        '<i class="fa fa-angle-left set_icon"></i>',
        '<i class="fa fa-angle-right set_icon"></i>'
    ],
    responsive: {
        0: {
            items: 1
        },
        568: {
            items: 2
        },
        600: {
            items: 3
        },
        1000: {
            items: 6
        },
        1400: {
            items: 7
        }
    }
});
$(document).ready(function () {
    $(".work-load").slice(0, 3).show();
    if ($(".blogbox:hidden").length != 0) {
        $("#loadMore").show();
    }
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $(".work-load:hidden").slice(0, 6).slideDown();
        if ($(".work-load:hidden").length == 0) {
            $(".btn-div").fadeOut('slow');
        }
    });
});

$(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
        $('.totop a').fadeIn(5000);
    } else {
        $('.totop a').fadeOut();
    }
});

$(".btn_effect").hover(function () {
    $(this).toggleClass("is-active");
});
JS;
$this->registerJs($script);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
