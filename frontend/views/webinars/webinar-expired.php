<?php

use yii\helpers\Url;


function finalAmount($totalPrice, $gstAmount)
{
    if ($gstAmount) {
        $gstPercent = $gstAmount;
        if ($totalPrice > 0) {
            $gstAmount = round($gstPercent * ($totalPrice / 100), 2);
        }
    }
    $finalPrice = $totalPrice + $gstAmount;
    return (($finalPrice == 0) ? 'Free' : '₹ ' . $finalPrice);
}

function webDate($webDate)
{
    $date = $webDate;
    $sec = strtotime($date);
    $newDate = date('d-M', $sec);
    return $newDate;
}

?>

<section class="pdtp">
    <div class="container">
        <div class="row eflex">
            <div class="col-md-6 col-sm-6">
                <div class="expired-vector">
                    <img src="<?= Url::to('@eyAssets/images/pages/webinar/expired-webinar.png'); ?>" alt="">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="expired-text">
                    <h3>Sorry!</h3>
                    <p>The webinar you have been looking for is expired. Click on the below button to explore some other exciting webinars.</p>
                    <a href="/webinars" class="web-btn" target="_blank">Back</a>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="upcoming-web">
    <div class="container">
        <div class="row">
            <div class="heading-style">Similar Webinars</div>
        </div>
        <div class="row">
            <?php
            if ($webinars) {
                foreach ($webinars as $web) {
                    ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="web-card">
                            <div class="web-img">
                                <a href="<?= Url::to("/webinar/" . $web['slug']) ?>">
                                    <img src="<?= $web['banner'] ?>"></a>
                                <div class="web-detail-date">
                                    <div class="webinar-date">
                                        <?php
                                        $eventDate = webDate($web['webinarEvents'][0]['start_datetime']);
                                        echo $eventDate;
                                        ?>
                                    </div>
                                    <div class="web-paid">
                                        <?php
                                        $finalPrice = finalAmount($web['price'], $web['gst']);
                                        echo $finalPrice;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="web-inr">
                                <div class="web-title"><a href="<?= Url::to("/webinar/" . $web['slug']) ?>"><?= $web['title'] ?></a></div>
                                <div class="web-speaker">
                                    <ul class="speakersList">
                                    <?php
                                        foreach ($web['webinarEvents'] as $speakers) {
                                    ?>
                                        <li> <?= $speakers['speakers'] ?></li>
                                    <?php   
                                    }
                                    ?>
                                    </ul>
                                </div>
                                <div class="web-des"><?= $web['description'] ?></div>
                            </div>
                            <div class="reg-btn-count">
                                <div class="register-count">
                                    <div class="reg-img">
                                        <?php
                                        if (count($web['webinarRegistrations']) > 0) {
                                            $reg = 1;
                                            foreach ($web['webinarRegistrations'] as $uImage) {
                                                if ($uImage['image']) {
                                                    ?>
                                                    <span class="reg<?= $reg ?> reg">
                                        <img src="<?= $uImage['image'] ?>">
                                    </span>
                                                    <?php
                                                    $reg++;
                                                }
                                                if ($reg == 4) {
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <span class="count"> <?= count($web['webinarRegistrations']) ?> Registered</span>
                                </div>
                                <div class="register-btns">
                                    <a href="<?= Url::to("/webinar/" . $web['slug']) ?>" class="btn-drib"><i
                                                class="icon-drib fa fa-arrow-right"></i> Register Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<?php
$this->registerCss("
.footer {
    margin-top: 0 !important;
}
.speakersList li:after{
    content: ',';
}
.speakersList li:last-child:after{
    content: '';
}
.eflex {
    display: flex;
    align-items: center;
    justify-content: center;
}
.pdtp {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: url(' . Url::to('@eyAssets/images/pages/webinar/wbg.png') . ');
    background-size: cover;
    background-repeat: no-repeat;
}
.expired-vector img {
    width: 100%;
    max-width: 500px;
}
.expired-text h3 {
    font-size: 32px;
    font-family: lora;
    text-transform: uppercase;
    color: #ff7803;
    font-weight: 600;
}
.expired-text p {
    font-size: 20px;
    line-height: 30px;
    color: #000;
    font-family: roboto;
    letter-spacing: 0.3px;
    font-weight: 500;
    margin-bottom: 30px;
}
.web-btn {
    background: #ff7803;
    color: #fff;
    padding: 10px 26px;
    border: 1px solid #ff7803;
    font-size: 14px;
    text-transform: uppercase;
    border-radius: 4px;
    cursor: pointer;
    transition: 0.3s ease-in;
}
.web-btn:hover {
    color: #ff7803;
    background-color: #fff4eb;
}
.similar-web-heading {
    font-size: 30px;
    font-family: Roboto;
    font-weight: 600;
    color: #555;
    margin-bottom: 25px;
    position: relative;
    display: inline-block;
}
.similar-web-heading::before {
    background-color: #00a0e3;
    content: '';
    width: 50%;
    height: 5px;
    display: inline-block;
    position: absolute;
    bottom: 0;
}
.web-card:hover {
	box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
	transform: translateY(-3px);
	transition: all .2s;
}
.header-web {
    background-color: #E8F6EF;
    position: relative;
    overflow: hidden;
    min-height: 500px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.back-shadow {
    position: absolute;
    top: -22%;
    right: 0;
    width: 50%;
    background-color: #00a0e3;
    height: 144%;
    border-radius: 50% 0 0 50%;
}
.header-txt h1 {
    font-size: 44px;
    font-family: roboto;
    font-weight: 700;
    margin-top: 0px;
    color: #00a0e3;
    margin-bottom: 0;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}
.header-txt h2 {
    font-size: 20px;
    font-family: roboto;
    margin: 0 0 0 8px;
    color: #707070;
    font-weight: 500;
    text-transform: capitalize;
}
.header-img {
    width: 350px;
    margin: auto;
}
.web-form{
    margin: -9px 0px 0px 2px;
}
.web-form label{
    font-size: 18px;
    font-family: roboto;
    font-weight: 400;
    color: #333;
    margin-bottom: 6px;
}
.web-form input,
.web-form textarea{
     border: 1px solid #d4caca;
     padding: 6px;
     border-radius: 4px;
     width: 100%;
     height:40px;
     line-height:22px !important;
     margin-bottom: 10px;
}
.web-form textarea{
    margin-bottom: 10px;
    height: 100px;
}
.web-button{
    text-align:center;  
}
.web-button button{
    font-family: roboto;
    font-size: 16px;
    padding: 12px 21px;
    border-radius: 4px;
    border:none;
    background-color: #fff;
    color: #000;
    transition:all .3s;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    margin-top: 20px;
    border: 1px solid #d4caca;
}
.web-button button:hover{
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    background-color: #00a0e3;
    color: #fff;
}
.req-web{
    display: flex;
    background-color: #3e8cf9;
    flex-direction: column;
    justify-content: space-between;
}
.req h1{
    font-size: 36px;
    text-align: center;
    font-family: lobster;
    padding: 20px  0 10px;
    color: #fff;
}
.req p{
    font-size: 16px;
    color: #fff;
    text-align: center;
    font-family: roboto;
    font-weight: 400;
    margin:0 0 5px 0;
}
.req-icon {
    max-width: 350px;
    margin: 0 auto;
}
.web-card {
	border-radius: 6px;
	overflow: hidden;
	box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
	background-color:#fff;
	margin-bottom:20px;
}
.web-img {
	position: relative;
}
.web-img img{
	height: 200px;
	object-fit: cover;
	width: 100%;
}
.web-detail-date {
    position: absolute;
    bottom: 5px;
    right: 10px;
    display:flex;
    align-items: center;
}
.webinar-date {
    border-radius: 4px;
    padding: 0px 8px;
    text-align: center;
    border: 2px solid #00a0e3;
    font-weight: 500;
    font-family: roboto;
    background-color: #00a0e3;
    color: #fff;
    margin-right: 2px;
}
.web-paid{
    background-color: #ff7803;
    border: 2px solid #ff7803;
    border-radius: 4px;
    padding: 0px 8px;
    text-align: center;
    text-transform: uppercase;
    font-family: roboto;
    font-weight: 500;
    color: #fff;
}
.web-inr {
	padding: 5px 10px 10px;
}
.web-title{
	font-size: 22px;
	font-family: lora;
	font-weight: 600;
	display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.web-title a{
    color: #333
}

.web-title a:hover{
    color: #00a0e3;
}
.web-speaker {
	font-size: 12px;
	font-family: roboto;
	color: #a49f9f;
	font-weight: 500;
}
.web-des {
	font-family: roboto;
	display: -webkit-box;
	-webkit-line-clamp: 3;
	-webkit-box-orient: vertical;
	overflow: hidden;
	height: 75px;
}
.opted-web {
	background-image: url(" . Url::to('@eyAssets/images/pages/webinar/wb2.png') . "); 
	margin: 0px 0 0;
	padding: 0 0 50px;
	background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
.heading-opted::after{
	position: absolute;
	left: 0;
	top: 0;
	content: \'\';
	right: 0;
	background-image: url(" . Url::to('@eyAssets/images/pages/webinar/title.png') . ");
	background-repeat: no-repeat;
	background-size: center center;
	background-position: contain;
	width: 70px;
	height: 10px;
	margin: auto auto 0;
	top: auto;
	bottom: 0;
}
.heading-opted {
	text-align: center;
	font-family: lobster;
	/* font-weight: bold; */
	font-size: 40px;
	color: #3b1d82;
	/* text-transform: uppercase; */
	margin-bottom: 35px;
	position: relative;
}
.reg-btn-count {
	display: flex;
	align-items: center;
	justify-content: space-between;
	margin: 0 10px 10px;
}
.register-count {
	font-family: roboto;
	color: #f97364;
	font-weight: 500;
	display: flex;
	align-items: center;
}
.reg img {
    width: 35px;
    border-radius: 81px;
    height: 30px;
    object-fit: cover;
    border: 2px solid #fff;
}
.reg2.reg, .reg3.reg {
    margin-left: -25px;
}
.count {
    margin-left: 5px;
}
.register-btns:hover .btn-drib{
    color:#fff;
}
.btn-drib:hover .icon-drib{
  animation: bounce 1s infinite;
  color:#fff;
}
@keyframes bounce {
    from, 20%, 53%, 80%, to {
      animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
      transform: translate3d(0, 0, 0);
    }
    40%, 43% {
      animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
      transform: translate3d(0, -6px, 0);
    }
    70% {
      animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
      transform: translate3d(0, -4px, 0);
    }
    90% {
      transform: translate3d(0, -2px, 0);
    }
  }
.btn-drib {
	border: 1px solid transparent;
	color: #fff;
	text-align: center;
	font-size: 14px;
	border-radius: 5px;
	cursor: pointer;
	padding: 6px 10px;
	background-color: #00a0e3;
	font-family:roboto;
	font-weight:500;
}
.icon-drib {
  margin-right: 5px;
}

@media screen and (max-width: 768px) and (min-width: 320px) {
    .eflex {
        display: inline-block;
    }
    .expired-text {
        text-align: center;
    }
    .expired-vector {
        text-align: center;
    }
    .expired-text p {
        font-size: 18px;
        line-height: 26px;
    }
}
");

$script = <<<JS
$('.web-speaker').each(function (){
    $(this).children('span').addClass('hidden');
    $(this).children('span:first-child, span:nth-child(2), span:nth-child(3)').removeClass('hidden');
    var count = $(this).children('span').length - 3;
   if(count > 0){
       $(this).append('<span>+' + count + ' more</span>')
   }
});

JS;
$this->registerJs($script);