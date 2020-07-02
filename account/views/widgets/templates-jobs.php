<?php
use yii\helpers\Url;
?>

<div class="temp-job-main">
    <div class="temp-head">Job Templates</div>
    <div class="temp-card">
        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/quick-job-icon1.png') ?>">
        <h3>Web developer</h3>
    </div>
</div>
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