<?php

use yii\helpers\Url;
?>
    <section class="sharing-companies">
        <div class="col-md-8 col-sm-8 col-xs-8">
            <div class="org-share-logo">
                <img src="<?= Url::to('@eyAssets/images/logos/dsblaw.jpg') ?>"/>
            </div>
            <div class="org-share-name">
                Capital small bank <br>is hiring
            </div>
        </div>
    </section>
<?php
$this->registercss('
.sharing-companies{
  background-image:  url(' . Url::to('@eyAssets/images/pages/company-profile/org-share.png') . ');
  background-size: 100% 100%;
  width:500px; 
  min-height:250px;
  background-repeat: no-repeat;
}
.org-share-logo {
    width: 80px;
    height: 80px;
    background-color: #fff;
    text-align: center;
    padding: 6px;
    margin: 20px auto 10px;
}
.org-share-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.org-share-name {
    text-transform: capitalize;
    font-family: lora;
    font-weight: 700;
    text-align: center;
    font-size: 20px;
    line-height:30px;
}
');
$script = <<<JS
JS;
$this->registerJs($script);