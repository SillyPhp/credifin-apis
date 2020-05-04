<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['header_dark'] = true;
?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-style">Choose Topic</div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="popular-cate">
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                            <a href="#">
                                <div class="newset">
                                    <div class="imag">
                                        <img src="<?= Url::to('@commonAssets/quiz_categories/other1.png') ?>" alt="">
                                    </div>
                                    <div class="txt">name</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                            <a href="#">
                                <div class="newset">
                                    <div class="imag">
                                        <img src="<?= Url::to('@commonAssets/quiz_categories/other1.png') ?>" alt="">
                                    </div>
                                    <div class="txt">name</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                            <a href="#">
                                <div class="newset">
                                    <div class="imag">
                                        <img src="<?= Url::to('@commonAssets/quiz_categories/other1.png') ?>" alt="">
                                    </div>
                                    <div class="txt">name</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 pr-0 pc-main">
                            <a href="#">
                                <div class="newset">
                                    <div class="imag">
                                        <img src="<?= Url::to('@commonAssets/quiz_categories/other1.png') ?>" alt="">
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
$this->registercss('
.popular-cate{
    text-align:center;
}
.newset{
    text-align:center;
    max-width: 160px;
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
    left: 0px;
    font-weight: 400;
    color: #222;
    font-family: roboto;
    text-transform: capitalize;
    background-color: #fff;
    padding: 0px 5px;
}
');
