<?php

use yii\helpers\Url;
?>
<div class="webinar-widget">
        <div class="row">
            <div class="col-md-12">
                <div class="invite-webinar-box">
                    <div class="join-webinar-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/jobs/default-cover.png')?>">
                    </div>
                    <div class="webi-date"><span class="cont">12</span><br><span class="abs">july</span></div>
                    <div class="invite-webinar-details">
                        <div class="invite-webinar-title">You Have been invited to join webinar</div>
                        <div class="invite-webinar-title">Business Conferences 2020</div>
                        <div class="invite-webinar-city"><i class="far fa-clock"></i> 12:00pm</div>
                    </div>
                    <div class="new-btns">
                        <div class="join-btn naam">
                            <button type="button">Join Event</button>
                        </div>
                        <div class="detail-btn naam">
                            <button type="button">View Details</button>
                        </div>
                        <div class="sharing-btn naam">
                            <button type="button" title="share with friend">Share <i class="fas fa-share-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.webinar-widget{
    text-align: center;
    padding: 0 20px;
}
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
	padding: 7px 18px;
	font-size: 16px;
	border-radius: 4px;
	font-family: roboto;
}
.invite-webinar-box{
    padding: 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    background-color:#fff;
}
.join-webinar-icon {
    position: relative;
    z-index: 0; 
    height:200px;  
}
.join-webinar-icon img{
    max-height: 200px;
    width: 100%;
    object-fit: cover;
    object-position: top center; 
}
.webi-date {
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
.invite-webinar-title {
    font-size: 32px;
    text-align: center;
    font-family: roboto;
    font-weight: 600;
    line-height: 35px;
    padding-top: 10px;
    text-transform: capitalize;
}
.invite-webinar-city {
    text-align: center;
    font-size: 16px;
    color: #00a0e3;
    font-family: roboto;
    font-weight: 500;
    padding-bottom: 10px;
}
.invite-webinar-desc {
    font-size: 16px;
    font-family: roboto;
    text-align: center;
}

')
?>