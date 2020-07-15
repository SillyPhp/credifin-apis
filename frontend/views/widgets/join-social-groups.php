<?php

use yii\helpers\url;

?>

    <div class="s-main col-md-10 col-md-offset-1 wts">
        <h3 class="s-head">get the latest Job updates on Whatsapp</h3>
        <div class="linkss">
            <div class="wtsa"><i class="fab fa-whatsapp"></i></div>
            <div class="btn-j">
                <a href="/social-community#whatsapp" target="_blank">Join Now</a>
            </div>
        </div>
    </div>

    <div class="s-main col-md-10 col-md-offset-1 tell">
        <h3 class="s-head">get the latest Job updates on Telegram</h3>
        <div class="linkss">
            <div class="wtsa"><i class="fab fa-telegram-plane"></i></div>
            <div class="btn-j">
                <a href="/social-community#telegram" target="_blank">Join Now</a>
            </div>
        </div>
    </div>

<?php
$this->registercss('
.s-main {
	/* border: 1px solid #eee; */
	/* box-shadow: 0 5px 5px rgba(0, 0, 0, .3); */
	border-radius: 4px;
	/* background-image: linear-gradient(33deg, white 47%, #8a1117 100%); */
	padding: 15px 10px 5px;
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
.btn-j a{
	font-size: 15px;
	color: #fff;
	font-family: roboto;
}
.linkss {
	text-align: center;
	margin: 5px 0;
	display: inline-flex;
}
.linkss > div > i {
	color: #fff;
	padding: 5px;
	/* border-radius: 4px; */
	font-size: 25px;
	/* width: 30px; */
}
.btn-j {
	margin-top: 4px;
}
//.fac, .wtsa, .tel, .inst, .twi{
//    display:inline-block;
//}
//.fac i{
//    background-color: #3c69c8;
//}
//.twi i{
//    background-color: #00aced;
//}
//.wtsa i{
//    background-color: #34bd34;
//}
//.tel i{
//    background-color: #0088cc;
//}
//.inst i{
//    background-color: #3f729b ;
//}

');