<?php

use yii\helpers\Url;
use yii\helpers\Html;
//print_r($type);exit();
$time = $nextEvent['start_datetime'];
?>
    <section class="non-a">
        <div class="Card">
            <div class="notification_div">
                <?php
                switch ($type) {
                    case 1:
                        ?>
                        <h2>Webinar Finished</h2>
                        <a href="/">Home</a>
                        <?php
                        break;
                    case 2:
                        ?>
                        <h2>Event Not Started</h2>
                        <div id="counter">
                            <div class="counter-item">
                                <span class="days" id="days"></span><b>d</b>
                            </div>
                            <div class="counter-item">
                                <span class="hours" id="hours"></span><b>h</b>
                            </div>
                            <div class="counter-item">
                                <span class="minutes" id="minutes"></span><b>m</b>
                            </div>
                            <div class="counter-item">
                                <span class="seconds" id="seconds"></span><b>s</b>
                            </div>
                        </div>
                        <p><?= date('jS M Y h:i A', strtotime($nextEvent['start_datetime'])) ?></p>
                        <a href="">Refresh Page</a>
                        <?php
                        break;
                    case 3:
                        ?>
                        <h2>Event Ended</h2>
                        <a href="/">Home</a>
                        <?php
                        break;
                    case 4:
                        ?>
                        <h2>Technical Issue</h2>
                        <a href="">Refresh Page</a>
                        <?php
                        break;
                    case 5:
                        ?>
                        <h2>Event Cancelled</h2>
                        <a href="/">Home</a>
                        <?php
                        break;
                    default :
                        ?>
                        <h2>You are not Authorized Speaker</h2>
                        <a href="/">Home</a>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/mustache/speakers-card');
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
function countdown(e){
    var countDownDate = new Date(e).getTime();
    var x = setInterval(function() {
        // Get today's date and time
        var now = new Date().getTime();
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
        // Time calculations for days, hours, minutes and seconds
        $('#days').text(Math.floor(distance / (1000 * 60 * 60 * 24)));
        $('#hours').text(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
        $('#minutes').text(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
        $('#seconds').text(Math.floor((distance % (1000 * 60)) / 1000));
        console.log(distance);
        if (distance <= 0) {
            $('a').show();
            clearInterval(x);
            $('#join').css('display','block');
            $('#counter').css('display','none');
        } else { 
            $('a').hide();
            $('#counter').css('display','block');
            $('#join').css('display','none');
        }
    }, 1000);
};
countdown('$time');
JS;
$this->registerJs($script);
