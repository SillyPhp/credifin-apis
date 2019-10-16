<?php

use yii\helpers\Url;

?>
    <ul class="menuzord-menu">
        <li><a href="<?= Url::to('/jobs'); ?>"><?= Yii::t('account', 'Jobs'); ?></a></li>
        <li><a href="<?= Url::to('/internships'); ?>"><?= Yii::t('account', 'Internships'); ?></a></li>
        <li><a href="<?= Url::to('/reviews'); ?>"><?= Yii::t('account', 'Reviews'); ?></a></li>
        <li><a href="<?= Url::to('/blog'); ?>"><?= Yii::t('account', 'Blog'); ?></a></li>
    </ul>
<?php
$this->registerCss('
.bg-theme-colored {
    background-color: #fff !important;
}
.border-bottom-theme-color-2-1px {
    border-bottom: 1px solid #ddd !important;
}
.menuzord-menu li{
    padding: 6px 10px 6px 0px !important;
}
.menuzord-menu li a{
    font-size: 19px !important;
    color: #49a1e3;
    font-family: Georgia;
}
.menuzord-menu > li > a {
    padding: 5px 10px !important;
    border-radius: 10px !important;
}
.menuzord-brand{
    margin-top: 4px !important;
}
.menuzord-menu > li.active > a, .menuzord-menu > li:hover > a {
    background-color:#49a1e3 !important;
    color:#fff !important;
}');