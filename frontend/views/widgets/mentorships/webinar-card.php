<?php

use yii\helpers\Url;
?>
<div class="col-md-6">
    <div class="webinar-box">
        <div class="webinar-icon">
            <img src="<?= Url::to('@eyAssets/images/pages/jobs/default-cover.png')?>">
        </div>
        <div class="web-date"><span class="cont">12</span><br><span class="abs">july</span></div>
        <div class="webinar-details">
            <div class="webinar-title">Business Conferences 2020</div>
            <div class="webinar-city"><i class="far fa-clock"></i> 12:00pm</div>
            <div class="webinar-desc">Lorem ipsum dolor sit amet elit. Cum veritatis sequi nulla nihil, dolor voluptatum nemo adipisci eligendi! Sed nisi perferendis, totam harum dicta.</div>
        </div>
        <div class="new-btns">
            <div class="join-btn naam">
                <button type="button">Join Event</button>
            </div>
            <div class="detail-btn naam">
                <button type="button">View Details</button>
            </div>
            <div class="sharing-btn naam">
                <button type="button" title="share with friend"><i class="fas fa-share"></i></button>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.new-btns{
    display: flex;
    margin-top: 20px;
    justify-content: center;
}
.naam button {
	background-color: #00a0e3;
	border: none;
	color: #fff;
	margin: 0 2px;
	padding: 7px 20px;
	font-size: 16px;
	border-radius: 4px;
	font-family: roboto;
}
.webinar-box{
    padding: 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    background-color:#fff;
}
.webinar-icon {
    position: relative;
    z-index: 0;
}
.web-date {
	border: 1px solid transparent;
	text-align: center;
	width: 130px;
	height: 130px;
	margin: auto;
	background-color: #00a0e3;
	color: #fff;
	padding: 21px 0;
	border-radius: 100px;
	margin-top: -70px;
    position: relative;
    z-index: 1;
}
.cont{
    font-size: 65px;
    line-height: 50px;
    font-family: roboto;
    font-weight: 600;
}
.abs{
    font-size: 22px;
    text-transform: uppercase;
    font-family: roboto;
}
.webinar-title {
    font-size: 32px;
    text-align: center;
    font-family: roboto;
    font-weight: 600;
    line-height: 35px;
    padding-top: 10px;
}
.webinar-city {
    text-align: center;
    font-size: 16px;
    color: #00a0e3;
    font-family: roboto;
    font-weight: 500;
    padding-bottom: 10px;
}
.webinar-desc {
    font-size: 16px;
    font-family: roboto;
    text-align: center;
}
')

?>
