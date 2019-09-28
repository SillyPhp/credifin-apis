<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>

<section>
    <div class="container">
        <div class="row col-md-12">
            <div class="heading-style col-md-6 col-sm-6">All Categories</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="popular-cate">
                    <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                        <a href="#">
                            <div class="newset">
                                <div class="imag">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/learning-corner/othercategory.png');?>">
                                </div>
                                <div class="txt">name</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                        <a href="#">
                            <div class="newset">
                                <div class="imag">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/learning-corner/othercategory.png');?>">
                                </div>
                                <div class="txt">name</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                        <a href="#">
                            <div class="newset">
                                <div class="imag">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/learning-corner/othercategory.png');?>">
                                </div>
                                <div class="txt">name</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                        <a href="#">
                            <div class="newset">
                                <div class="imag">
                                    <img src="<?= Url::to('/assets/themes/ey/images/pages/learning-corner/othercategory.png');?>">
                                </div>
                                <div class="txt">name</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.popular-cate{
    text-align:center;
}
.newset{
    text-align:center;
    max-width: 160px;
    min-height: 245px;  
    line-height: 210px;
    position: relative;
    width:100%;
    margin-bottom:20px;
}
.imag{
    text-align: right;
}
.txt {
    position: absolute;
    line-height: 17px;
    bottom: 10px;
    left: -4px;
    font-weight: 400;
    color: #222;
    font-family: roboto;
    text-transform: capitalize;
    background-color: #fff;
    padding: 0px 5px;
}
');