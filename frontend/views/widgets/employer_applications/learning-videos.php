<?php

use yii\helpers\Url;
?>
    <div class="related-video-box">
        <div class="heading-text">Learning Videos</div>
        <a href="#">
            <div class="row">
                <div class="col-md-5">
                    <div class="re-v-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/learningc.png'); ?>">
                    </div>
                </div>
                <div class="col-md-7 padd-left-0">
                    <div class="re-v-name">title</div>
                </div>
            </div>
        </a>
    </div>

<?php
$this->registerCss('
.heading-text{
    font-size:18px;
    font-weight:bold;
    padding-bottom:20px;
}
.related-video-box {
    padding: 30px 0px 0px 0px;
    width: 80%;
    margin: 0 auto;
}
.re-v-icon img{
border-radius:10px;
}
.re-v-name{
font-size:11px;
font-weight:bold;
line-height:20px;
}
');