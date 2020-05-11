<?php
use yii\helpers\Url;
?>
<div class="fixed-btn background-logo-blue">
    <a href="/employers">
        <img src="<?= Url::to('@eyAssets/images/flaticon-png/small/team-white.png'); ?>"/><br/>
        <?= Yii::t('frontend', 'Are you an Employer?'); ?><br/>
        <span><?= Yii::t('frontend', 'Want to post a Job or an Intenship?'); ?></span>
    </a>
</div>
<?php
$this->registerCss('
.fixed-btn a{
    position: fixed;
    text-align: center;
    width: 150px;
    color: #fff !important;
    bottom: 0px;
    left:0px;
    border-right: 4px solid orange;
    z-index: 999999;
    height: 112px;
    opacity: 0.9;
    padding: 10px 0px;
    transition: ease-in-out .3s;
    cursor: pointer;
    bottom: -42px;
    border-top-right-radius: 28px;
}
.fixed-btn a span{
    font-weight: 700;
    color: #fff;
}
.fixed-btn a:hover{
    opacity: 1;
    bottom: 0px;
}
.background-logo-blue a{
    background-color: #49a1e3;
}
');