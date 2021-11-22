<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
    <section class="non-a">
        <div class="Card">
            <div class="notification_div">
                <h2><?= $message ?></h2>
                <a href="https://myecampus.in/quiz/<?= $slug?>" target="_top">Back to detail</a>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
body{
	background-color:#00a0e3;
	width:100%;
	height:auto;
}
.non-a {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.Card{
	position:relative;
	text-align:center;
	width:350px;
	height:350px;
	border-radius:74% 82% 70% 88%;
	display:table;
	padding:20px;
	background-color:rgba(255,255,255,.9);
	cursor:pointer;
	z-index:1;
	transition:.5s;
	color:#227093;
	margin:auto;
}
.Card:before,
.Card:after{
	content:\'\';
	position:absolute;
	top:0px;
	left:0px;
	width:100%;
	height:100%;
	z-index:-1;
	animation:RotateDiv 5s linear infinite;
}
.Card:before{
	border-radius:130% 151% 189% 166%;
	background-color:rgba(255,255,255,.7);
	animation-delay:0s;
	transition:.5s;
}
.Card:after{
	border-radius:145% 86% 80% 90%;
	background-color:rgba(255,255,255,.3);
	animation-delay:.2s;
	transition:.5s;
}
.Card:hover{
	background-color:rgba(9,113,195,.8);
	color:#fff;
}
.Card:hover:after{
	background-color: rgba(9,113,195,.7);
}
.Card:hover:before{
	background-color: rgba(9,113,195,.3);
}
.Card div{
	display:table-cell;
	vertical-align:middle;
}
.Card div h2{
	font-size:32px;
	color:#00a0e3;
}
.Card:hover div h2{color:#fff;}
@keyframes RotateDiv{
	0%{
		transform:rotate(0deg);
	}
	100%{
		transform:rotate(360deg);
	}
}
.notification_div a{
    color:#fff;
    background-color:#00a0e3;
    font-size:14px;
    font-family:roboto;
    border:2px solid transparent;
    padding:8px 20px;
}
.notification_div:hover a{
    color:#00a0e3;
    background-color:#fff;
    border:2px solid #00a0e3;
}
#counter{
    display:block;
    margin-bottom:15px;
}
.counter-item {
    display: inline-block !important;
}
');

$script = <<<JS

JS;
$this->registerJs($script);
