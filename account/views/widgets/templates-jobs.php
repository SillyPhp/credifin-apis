<?php

use yii\helpers\Url;

$type_job = strtolower($type);
?>
<?php if ($jobs) { ?>
    <div class="temp-job-main row nd-shadow">
        <div class="temp-head"><?= ($type == 'Jobs') ? 'Job' : 'Internship' ?> Templates</div>
        <?php foreach ($jobs as $jb) { ?>
            <a href="<?= Url::to('/account/'.$type_job.'/clone-template?aidk=' . $jb['application_enc_id']); ?>">
            <div class="temp-card" title="Use Template" data-toggle="tooltip" data-placement="right">
                <img src="/assets/common/categories/profile/<?= $jb['icon_png']; ?>">
                <h3><?= $jb['cat_name']; ?></h3>
            </div>
            </a>
        <?php } ?>
    </div>
<?php } ?>
<?php
$this->registercss('
.temp-job-main {
	text-align: center;
	border: 1px solid #eee;
    margin-top: 40px;
    padding: 5px 5px 10px;
    border-radius:4px;
}
.temp-head {
	font-size: 22px;
	font-family: lora;
	margin: 5px 0 15px;
	color: #000;
	border-bottom: 2px solid #000;
}
.temp-card {
	padding: 10px 8px 10px;
	border-radius: 4px;
	margin-bottom: 5px;
	display: flex;
	justify-content: flex-start;
	align-items: center;
	background-color:#000;
}
.temp-card:hover.temp-card > i{
    background-color:#fff;
    color:#000;
}
.temp-card img {
	height: 30px;
	width: 30px;
	margin-right: 8px;
	background-color: #fff;
    padding: 2px;
    border-radius: 30px;
}
.temp-card h3 {
	font-size: 16px;
	font-family: roboto;
	font-weight: 400;
	margin: 0;
	color: #fff;
}
');