<?php

use yii\helpers\Url;

?>
<section class="seen-bg">
    <div class="opacity-div"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="seen">
                <div class="seen-txt">
                    <h1>Know what top News Platforms have to say about our Education Loan Scheme.</h1>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="pdtop"></div>

<?= $this->render('/widgets/press-releasee', [
    'data' => $data
]) ?>

<?php
$this->registerCss('
.pdtop{
    padding-top: 25px;
    background-color: #f5f5f5;
}
.seen-bg {
    background: url(' . Url::to('@eyAssets/images/pages/education-loans/as-seen-in-news.png') . ');
	min-height: 500px;
	background-repeat: no-repeat;
	background-size: cover;
	display: flex;
	align-items: center;
	position: relative;
	max-height: 700px;
	background-position: right top;
}
.opacity-div{
    position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,.5);
}
.seen-txt h1 {
    font-size: 30px;
    font-family: roboto;
    color: #fff;
    font-weight: 600;
}
');