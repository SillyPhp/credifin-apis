<?php

use yii\helpers\Url;

?>

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
<?php
$this->registercss('
.follow-main {
	display: flex;
	justify-content: right;
	background-color: #f7f7f7;
	float: right;
	padding: 15px 8px 10px;
	border-radius:8px;
}
.i-text {
	font-size: 15px;
	font-family: roboto;
	padding: 4px 0 0 0;
	color: #000;
}
.fb, .tw, .ig{
    text-align:center;
}
.fb i, .tw i, .ig i {
	font-size: 25px;
	margin: 0 35px;
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
@media (max-width:550px){
.follow-main {
	justify-content: center;
	float:none;
}
}
');