<?php

use yii\helpers\url;

?>

    <div class="s-main col-md-10 col-md-offset-1 wts">
        <a href="/social-community#WhatsApp" class="s-head" target="_blank">get the latest Job updates on Whatsapp</a>
    </div>

    <div class="s-main col-md-10 col-md-offset-1 tell">
        <a href="/social-community#Telegram" class="s-head" target="_blank">get the latest Job updates on Telegram</a>
    </div>

<?php
$this->registercss('
.s-main {
	/* border: 1px solid #eee; */
	/* box-shadow: 0 5px 5px rgba(0, 0, 0, .3); */
	border-radius: 4px;
	/* background-image: linear-gradient(33deg, white 47%, #8a1117 100%); */
	padding: 15px 5px 15px;
	margin-top: 15px;
	text-align: center;
}
.wts{
	background-color: #34bd34;
}
.tell{
    background-color: #0088cc;
}
.s-head {
	font-size: 15px;
	font-family: roboto;
	margin:0;
	color:#fff;
	text-transform:capitalize;
	font-weight:500;
}
');