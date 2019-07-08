<?php

/* @var $referral string */

use yii\helpers\Url;
?>
    <ul class="menuzord-menu">
        <li><a href="<?= Url::to('/jobs' . $referral); ?>"><?= Yii::t('frontend', 'Jobs'); ?></a></li>
        <li><a href="<?= Url::to('/internships' . $referral); ?>"><?= Yii::t('frontend', 'Internships'); ?></a></li>
        <li><a href="<?= Url::to('/reviews' . $referral); ?>"><?= Yii::t('frontend', 'Reviews'); ?></a></li>
        <li><a href="<?= Url::to('/blog' . $referral); ?>"><?= Yii::t('frontend', 'Blog'); ?></a></li>
        <?php if (!Yii::$app->user->isGuest): ?>
            <li><a href="<?= Url::to('/account/dashboard'); ?>"><?= Yii::t('frontend', 'Dashboard'); ?></a></li>
        <?php else: ?>
            <li><a href="javascript:;" data-toggle="modal"
                   data-target="#loginModal"><?= Yii::t('frontend', 'Login'); ?></a></li>
        <?php endif; ?>
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
    padding: 7px 0px !important;
}
.menuzord-menu li a{
    font-size: 19px !important;
    color: #49a1e3;
    font-family: Georgia;
}
.menuzord-menu > li > a {
    padding: 5px 15px !important;
    border-radius: 4px !important;
}
.menuzord-brand{
    margin-top: 7px !important;
}
.menuzord-menu > li.active > a, .menuzord-menu > li:hover > a {
    background-color:#49a1e3 !important;
    color:#fff !important;
}
.menuzord.orange .menuzord-menu > li.active > a, .menuzord.orange .menuzord-menu > li:hover > a, .menuzord.orange .menuzord-menu ul.dropdown li:hover > a {
    /*    background: url("../../../asset/images/hover1.png");
        background-size: 100%;*/
    color:#f08440;
}
@media only screen and (max-width: 901px) and (min-width: 451px) {
    .menuzord.orange .menuzord-menu > li.active > a, .menuzord.orange .menuzord-menu > li:hover > a, .menuzord.orange .menuzord-menu ul.dropdown li:hover > a {
        background: none !important;
        color:#000;
    }
}
@media only screen and (max-width: 900px) {
    .menuzord .showhide{
        padding: 19px 0 0 !important;
    }
}
@media only screen and (max-width: 450px) {
    .menuzord .showhide{
        width: 50px;
    }
    .menuzord-menu li{
        padding: 0px !important;
    }
    .menuzord-menu {
        border-radius: 10px;
    }
    .menuzord-menu li:hover a, .menuzord-menu li:focus a{
        background-color: #00a0e3;
        color: #fff !important;
    }
}
');