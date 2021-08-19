<?php

use yii\helpers\Url;

$type_job = strtolower($type);
?>
<?php if ($jobs) { ?>
    <div class="temp-job-main row nd-shadow">
        <div class="temp-head"><?= ($type ==
		 'Jobs') ? 'Job' : 'Internship' ?> Templates</div>
        <?php foreach ($jobs as $jb) { ?>
            <a href="<?= Url::to('/account/' . $type_job . '/clone-template?aidk=' . $jb['application_enc_id']); ?>">
                <div class="temp-card" title="Use Template" data-toggle="tooltip" data-placement="right">
                    <img src="/assets/common/categories/profile/<?= $jb['icon_png']; ?>">
                    <h3><?= ucwords($jb['cat_name']); ?></h3>
                </div>
            </a>
        <?php } ?>
        <div class="view-all-bt">
            <?php if (count($jobs) >= 10) { ?>
                <a href="<?= Url::to('/account/' . $type_job . '/view-templates'); ?>">View All</a>
            <?php } ?>
        </div>
    </div>
<?php } ?>
<?php
$this->registercss('
.temp-job-main {
	text-align: center;
	border: 1px solid #eee;
	margin-top: 40px;
	padding: 5px 5px 0px;
	border-radius: 4px;
	background:linear-gradient(to top right, #F96 20%,#6699FF 80%);
}
.temp-head {
	font-size: 22px;
	font-family: lora;
	margin: 5px 0 15px;
	color: #fff;
	border-bottom: 2px solid #fff;
}
.temp-card {
	padding:8px;
	border-radius: 4px;
	margin-bottom: 5px;
	display: flex;
	justify-content: flex-start;
	align-items: center;
	background: #fff;
}
.temp-card:hover.temp-card > i{
    background-color:#fff;
    color:#000;
}
.temp-card img {
	height: 30px;
	width: 30px;
	margin-right: 8px;
//	background-color: #000;
//    padding: 2px;
//    border-radius: 30px;
}
.temp-card h3 {
	font-size: 16px;
	font-family: roboto;
	font-weight: 400;
	margin: 0;
	color: #000;
	text-align:left;
}
.view-all-bt {
	margin: 12px 0;
}
.view-all-bt a{
	color: #fff;
	font-weight: 500;
	font-family: roboto;
	font-size: 16px;
}
');