<?php

use yii\helpers\Url;

?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert-box text-center">
                <?php if (!empty($title)): ?>
                    <h1>
                        <?php
                        if ($status == 'success') {
                            echo '<i class="far fa-check-circle"></i>';
                        }
                        ?>
                        <?php
                        if ($status == 'error') {
                            echo '<i class="far fa-times-circle"></i>';
                        }
                        ?>
                        <?= $title; ?>
                    </h1>
                <?php endif; ?>
                <h4><?= $message; ?></h4>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
body{
    background-image: url( ' . Url::to("@eyAssets/images/backgrounds/lco_bg.jpg") . ' );
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
}
.layer-overlay.overlay-white-9::before {
    background-color: rgba(255, 255, 255, 0.49);
}
#home{
    min-height:100% !important;
}
.alert-box{
    width: 100%;
    background-color: #ffffffd9;
    border: 1px solid #cacaca8c;
    color: #fff !important;
    border-radius: 8px;
    padding: 20px;
    padding-top: 10px;
}
.alert-box h1{
    font-size:40px;
}

.alert-box h2{
    margin-top: -15px;
}');
$this->registerCssFile('https://use.fontawesome.com/releases/v5.8.2/css/all.css');
