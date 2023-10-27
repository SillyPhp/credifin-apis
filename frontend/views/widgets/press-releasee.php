<?php

use yii\helpers\Url;

?>
    <section class="press-bg">
        <div class="container">
            <?php
            if ($viewBtn) {

                ?>
                <div class="row">
                    <div class="col-xs-7">
                        <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'As Seen In'); ?></h2>
                    </div>

                    <div class="col-xs-5">
                        <div class="type-1">
                            <div>
                                <a href="<?= Url::to('/education-loans/press-releases'); ?>" class="btn btn-3">
                                    <span class="txting"><?= Yii::t('frontend', 'View all'); ?></span>
                                    <span class="round"><i class="fas fa-chevron-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <?php
                if (!empty($data) && is_array($data)) {
                    foreach ($data as $d) {
                        ?>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                            <div class="press-release-hd">
                                <a href="<?= $d['link'] ?>" target="_blank">
                                    <div class="press-release">
                                        <div class="press-img">
                                            <img class="load-later" data-src="<?= Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->press->publishers->logo . $d['logo_location'] . DIRECTORY_SEPARATOR . $d['logo'], 'https'); ?>"
                                                 src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt=""/>
                                        </div>
                                    </div>
                                    <div class="press-txt-hd"><?= $d['name'] ?></div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.press-bg .heading-style{
    margin: 0;
}
.btn-3 {
    background-color: #424242;
}
.btn-3 .round {
    background-color: #737478;
}
.type-1{
    float:right;
    margin-top: 15px;
}
.type-1 div a {
    text-decoration: none;
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
    padding: 12px 53px 12px 23px;
    color: #fff;
    text-transform: uppercase;
    font-family: sans-serif;
    font-weight: bold;
    position: relative;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
    display: inline-block;
}
.type-1 div a span {
    position: relative;
    z-index: 3;
}
.type-1 div a .round {
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    width: 38px;
    height: 38px;
    position: absolute;
    right: 3px;
    top: 3px;
    -moz-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
    z-index: 2;
}
.type-1 div a .round i {
    position: absolute;
    top: 50%;
    margin-top: -6px;
    left: 50%;
    margin-left: -4px;
    color: #333332;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
}

.txting {
    font-size: 14px;
    line-height: 1.45;
}

.type-1 a:hover {
    padding-left: 48px;
    padding-right: 28px;
}
.type-1 a:hover .round {
    width: calc(100% - 6px);
    -moz-border-radius: 30px;
    -webkit-border-radius: 30px;
    border-radius: 30px;
}
.type-1 a:hover .round i {
    left: 12%;
    color: #FFF;
}
.press-bg {
    background-color: #edf4fc;
    padding-bottom: 30px;
}
.press-release-hd {
    border: 1px solid #fff;
    background-color: #fff;
    box-shadow: 0 0 11px -4px rgba(0,0,0,0.2);
    margin-bottom: 20px;
}
.press-release-hd:hover {
    box-shadow: 0 5px 10px 4px rgb(76 76 76 / 10%);
    transition: .3s ease;
}
.press-release {
    background-color: #fff;
    border-radius: 8px;
}
.press-img {
    text-align: center;
    padding: 10px 0px 0px;
}
.press-img img {
    width: 100px;
    height: 100px;
    object-fit: contain;
}
.press-txt-hd {
    font-size: 14px;
    font-family: lora;
    text-align: justify;
    color: #000;
    line-height: 20px;
    margin: 8px;
    margin-bottom: 10px;
    font-weight: 600;
    text-align: center;
    height: 46px;
}
');
$script = <<<JS
$('.load-later').Lazy();
JS;
$this->registerJs($script);