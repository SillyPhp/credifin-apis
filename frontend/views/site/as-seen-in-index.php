<?php

use yii\helpers\Url;

?>
<section class="seen-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6p  9999
             col-sm-6 p-0">
                <div class="seen">
                <div class="seen-txt">
                    <h1>Know what top <span class="white-txt">News Platforms</span> have to say about our Education Loan Scheme.</h1>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->render('/widgets/press-release') ?>

<?php
$this->registerCss('
.white-txt {
    Font-weight: 600px;
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
');