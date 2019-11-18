<?php

use yii\helpers\Url;

?>
    <section>
        <div class="r-parent">
            <div class="review-box">
                <div class="r-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/learning-corner/learningc.png'); ?>">
                </div>
                <div class="r-text">review</div>
            </div>
        </div>
    </section>


<?php
$this->registerCss('
.r-parent{
    margin:20px 0px;
}
.review-box{
    width: 80%;
    text-align: center;
    margin: 0 auto;
    padding: 30px 0px 10px 0;
}
.r-text{
    padding-top: 15px;
    font-size: 16px;
}
');
