<?php

use yii\helpers\url;

?>

    <div class="s-main col-md-10 col-md-offset-1">
        <div class="row">
            <h3 class="heading-job-upd">Get the Latest Job Updates on </h3>
            <div class="col-xs-6">
                <a href="/social-community#WhatsApp" class="s-head wts" target="_blank"><i class="fab fa-whatsapp"></i></a>
            </div>
            <div class="col-xs-6">
                <a href="/social-community#Telegram" class="s-head tell" target="_blank"><i class="fab fa-telegram-plane"></i></a>
            </div>
        </div>
    </div>

    <div class="s-main col-md-10 col-md-offset-1">
    </div>

<?php
$this->registercss('
.heading-job-upd{
    font-size: 16px;
    text-align: left;
    padding-left: 15px;
    font-weight: 700;
}
.s-main {
	padding: 0;
	margin-top: 15px;
	text-align: center;
}
.wts{
	background-color: #34bd34;
}
.wts:hover{
	background-color: #fff;
	color:#34bd34;
	border:2px solid #34bd34;
}
.tell{
    background-color: #0088cc;
}
.tell:hover{
    color: #0088cc;
    background-color: #fff;
    border:2px solid #0088cc;
}
.s-head {
    font-size: 22px;
    font-family: roboto;
    margin: 0;
    color: #fff;
    text-transform: capitalize;
    font-weight: 500;
    width: 100%;
    display: inline-block;
    padding: 0px;
    border-radius: 4px;
    border: 2px solid transparent;
    transition: all .3s;
}
');