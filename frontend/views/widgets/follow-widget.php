<?php

use yii\helpers\Url;

?>
<div class="follow-us">
    <h3>Follow us on</h3>
    <div class="follow-main">
        <div class="fb">
            <a href="https://www.facebook.com/empower">
                <div class="ifb">
                    <i class="fab fa-facebook-f"></i>
                </div>
                <div class="i-text">Facebook</div>
            </a>
        </div>
        <div class="tw">
            <a href="https://twitter.com/EmpowerYouthin">
                <div class="itw">
                    <i class="fab fa-twitter"></i>
                </div>
                <div class="i-text">Twitter</div>
            </a>
        </div>
        <div class="ig">
            <a href="https://www.instagram.com/empoweryouth.in/">
                <div class="iig">
                    <i class="fab fa-instagram"></i>
                </div>
                <div class="i-text">Instagram</div>
            </a>
        </div>
    </div>
</div>
<?php
$this->registercss('
.follow-us {
	background-color: #00a0e3;
	padding: 5px 10px 10px;
	border-radius: 8px;
	margin-bottom: 8px;
}
.follow-us h3 {
	margin: 2px 0;
	text-align: center;
	font-size: 20px;
	font-family: lora;
	text-transform: capitalize;
	color:#fff;
}
.follow-main {
	display: flex;
	justify-content: center;
}

.fb, .tw, .ig {
	text-align: center;
	flex-basis: 50%;
	background-color: #fff;
	margin: 0 5px 0 0;
	transition: all .3s;
	border-radius:4px;
}
.fb a, .tw a, .ig a {
	display: block;
	padding: 10px 0 5px;
}
.i-text {
	font-size: 13px;
	font-family: roboto;
	color: #000;
}
.fb:hover, .tw:hover, .ig:hover{
    transform: scale(1.09);
}

.fb i, .tw i, .ig i {
	font-size: 20px;
}
.fb i{
    color:#3b5998;
} 
.tw i{
    color:#00acee;
} 
.ig i{
    color:#c2359d;
}
');