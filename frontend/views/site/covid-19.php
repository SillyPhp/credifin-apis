<?php

use yii\helpers\Url;

$this->params['header_dark'] = true;
?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="covid-main">
                        <div class="main-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/blog/hand-shake.png') ?>">
                        </div>
                        <div class="small-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-21.jpg') ?>">
                            <img src="<?= Url::to('@eyAssets/images/pages/blog/p2.png') ?>">
                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-27.jpg') ?>">
                            <img src="<?= Url::to('@eyAssets/images/pages/blog/img-28.jpg') ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="covid-list">
                        <div class="covid-heading">Topics <span>No.</span></div>
                        <ul>
                            <li>Do not enter if unwell<span>2</span></li>
                            <li>Stay home if you feel unwell<span>2</span></li>
                            <li>Please use hand sanitizer before entering<span>2</span></li>
                            <li>Please maintain physical distance<span>2</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registercss('
.main-img {
    margin-bottom: 20px;
}
.main-img img{
    width:100%;
}
.small-img {
    margin-left: 12px;
}
.small-img img {
    width: 85px;
    height: 85px;
    margin-right: 5px;
}
.covid-heading {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 8px;
}
.covid-heading span{
    float:right;
}
.covid-list {
	border: 1px solid #eee;
	box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
	border-radius: 4px;
	padding: 20px;
	margin-top:16px;
}
.covid-list li {
	font-size: 16px;
	font-family: roboto;
	text-transform: full-size-kana;
	margin-bottom: 5px;
}
.covid-list li span {
    float: right;
    margin-right: 10px;
}
');
