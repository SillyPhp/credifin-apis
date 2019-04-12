<?php

use yii\helpers\Url;

?>
    <ul class="menuzord-menu">
        <li><a href="<?= Url::to('/jobs'); ?>"><?= Yii::t('frontend', 'Jobs'); ?></a></li>
        <li><a href="<?= Url::to('/internships'); ?>"><?= Yii::t('frontend', 'Internships'); ?></a></li>
        <li><a href="<?= Url::to('/reviews'); ?>"><?= Yii::t('frontend', 'Reviews'); ?></a></li>
        <?php if (!Yii::$app->user->isGuest): ?>
            <li><a href="<?= Url::to('/account/dashboard'); ?>"><?= Yii::t('frontend', 'Dashboard'); ?></a></li>
        <?php else: ?>
            <li><a href="javascript:;" data-toggle="modal" data-target="#loginModal"><?= Yii::t('frontend', 'Login'); ?></a></li>
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
    padding: 6px 0px !important;
}
.menuzord-menu li a{
    font-size: 19px !important;
    color: #49a1e3;
    font-family: Georgia;
}
.menuzord-menu > li > a {
    padding: 6px 15px !important;
    border-radius: 10px !important;
}
.menuzord-brand{
    margin-top: 7px !important;
}
.menuzord-menu > li.active > a, .menuzord-menu > li:hover > a {
    background-color:#49a1e3 !important;
    color:#fff !important;
}
@media only screen and (max-width: 900px) {
    .menuzord .showhide{
        padding: 19px 0 0 !important;
    }
}
');