<?php

use yii\helpers\Url;

$type_job = strtolower($type);
?>
<?php if ($jobs) { ?>
    <div class="temp-job-main">
        <div class="temp-head"><?= ($type == 'Jobs') ? 'Job' : 'Internship' ?> Templates</div>
        <?php foreach ($jobs as $jb) { ?>
            <a href="<?= Url::to('/account/'.$type_job.'/clone-template?aidk=' . $jb['application_enc_id']); ?>">
            <div class="temp-card">
                <i class="fa fa-files-o" title="clone"></i>
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
}
.temp-head {
	font-size: 26px;
	font-family: lora;
	margin: 40px 0 20px;
	color: #00a0e3;
	border-bottom: 2px solid #00a0e3;
}
.temp-card {
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
	padding: 14px 5px;
	border-radius: 8px;
	margin-bottom:20px;
	position:relative;
}
.temp-card i {
	position: absolute;
	left: 5px;
	top: 0px;
	font-weight: bold;
	color: #8e8e8e;
	padding: 5px;
	border-radius: 0 0px 6px 6px;
	transition: all .3s;
}
.temp-card:hover.temp-card > i{
    background-color:#00a0e3;
    color:#fff;
}
.temp-card img{
	height: 70px;
	width: 70px;
}
.temp-card h3 {
	font-size: 19px;
	font-family: roboto;
	font-weight: 400;
}
');