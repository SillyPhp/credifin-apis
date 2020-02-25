<?php

use yii\helpers\Url;
?>
<div class="col-md-12">
    <div class="overlay-white-9">
        <div id="header-search">
            <form class="form-inline" action="<?= strtok($_SERVER["REQUEST_URI"],'?'); ?>">
                <div class="set-scroll-fixed mb-20">
                    <div class="row content-search">
                        <div class="col-md-6 col-md-offset-2 col-xs-12 col-sm-6 col-sm-offset-3">
                            <div class="input-group">
                                <span style="width: 40px;" class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" name="keyword" value="<?= $s; ?>" placeholder="Search City,State,Organizations" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12 col-sm-6 text-center">
                            <input type="submit" class="form-control submit-next hvr-float search-button" id="form_control_1" value="Search">
                        </div>
                    </div>
                </div>
            </form>
            <div id="search_preview">
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
#header-search{height:55px;}
.input-group{
    width: 100%;
    margin-bottom:10px;
}
.input-group-btn:last-child>.btn, .input-group-btn:last-child>.btn-group{
    height: 45px;
}
.display-flex{
    display: inline-flex !important;
}
.set-heights{
    line-height:31px;
}
.preview_tags{
    position:relative;
    padding: 8px 10px;
    background-color: #f5f5f5;
    margin: 5px;
    border-radius: 8px;
    box-shadow: 0px 1px 4px 2px #DDD;
}
.preview_tags a{
    position: absolute;
    right: -5px;
    top: -6px;
    width: 16px;
    height: 17px;
    background-color: #fb236a;
    color: #fff;
    border-radius: 50%;
    text-align: center;
    font-size: 10px;
    font-weight: 200;
}
.content-search {
    position: relative;
    background-color: #666666;
    padding: 16px;
    top: 15% !important;
    z-index: 99;
    margin-top: 10px;
    padding-top: 15px;
}
.stickyheader{
    position: fixed;
    top: -100%;
    width: 80.3%;
    margin-top: 0;
    border-bottom: 1px solid #ccc;
    z-index: 999;
    -webkit-box-shadow: 0 8px 5px -6px #ccc;
    -moz-box-shadow: 0 8px 5px -6px #ccc;
    box-shadow: 0 8px 5px -6px #ccc;
    background-color:#fff;
}
.content-search{
    background-color: transparent !important;
    padding:0px 16px !important;
}
.search-button{
    background-color: #ed4303 !important;
    color: #fff;
    border-color: transparent;
    border-radius: 4px;
    width:100% !important;
}
@media only screen and (max-width: 991px) {
    #header-search {
        height: 110px;
    }
    .stickyheader {
        width: 69.3%;
    }
    .twitter-typeahead input{
        width:100% !important;
    }
}
@media only screen and (max-width: 767px) {
    .stickyheader {
        width: auto;
        position: relative !important;
        top: 0 !important;
        background-color: transparent;
        border-bottom: none !important;
        box-shadow: none;
    }
    #header-search {
        height: 225px;
    }
    .set-heights {
        padding-right: 30px;
    }
}
@media screen and (max-width: 1160px) and (min-width: 992px) {
    .twitter-typeahead input{
        max-width:165px;
    }
    .twitter-typeahead .tt-menu{
        max-width:165px;
    }
}
');
$script = <<<JS
$(window).scroll(function () {
    if( $(window).scrollTop() > $('.set-scroll-fixed').offset().top + 120 && !($('.set-scroll-fixed').hasClass('stickyheader'))){
        $('.set-scroll-fixed').addClass('stickyheader').animate({"top":"60px"}, 1000);
    } else if ($(window).scrollTop() == 0){
        $('.set-scroll-fixed').removeClass('stickyheader').css({"top":"-100%"});
    }
});
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
