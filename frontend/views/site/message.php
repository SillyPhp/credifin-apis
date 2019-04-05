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
                            echo '<i class="fa fa-check-circle-o"></i>';
                        }
                        ?>
                        <?php
                        if ($status == 'error') {
                            echo '<i class="fa fa-times-circle-o"></i>';
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
