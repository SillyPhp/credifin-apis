<?php

use yii\helpers\Url;

?>

    <section class="event-back">
        <div class="container">
            <div class="row reg-flex">
                <div class="col-md-5 col-sm-6">
                    <div class="ent-heading">
                        <h3>ENTREPRENEURSHIP & INNOVATION SUMMIT</h3>
                        <p>18 - 20 September, 2020</p>
                    </div>
                    <div class="ent-register">
                        <a href="https://www.empoweryouth.com/webinar/entrepreneurship-innovation-summit-75367" target="_blank">Register Now</a>
                    </div>
                </div>
                <div class="col-md-5 col-sm-6">
                    <div class="speakers">
                        <img src="<?= Url::to('@eyAssets/images/pages/webinar/speakers-img.png') ?>" title="Jobs"/>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12">
                    <div class="sir">
                        <img src="<?= Url::to('@eyAssets/images/pages/webinar/sir.png') ?>" title="Jobs"/>
                    </div>
                </div>
                <div class="col-md-12 date-reg">
                    <div class="ent-register new-r">
                        <a href="https://www.empoweryouth.com/webinar/entrepreneurship-innovation-summit-75367" target="_blank">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.event-back{
    background:url(' . Url::to('@eyAssets/images/pages/webinar/s-bg.png') . ');
    min-height: 300px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    padding:10px 0;
}
.reg-flex {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}
.ent-heading h3 {
	color: #fff;
	font-family: lora;
	font-size: 42px;
	font-weight: 600;
}
.ent-heading p {
	background-color: #ff7803;
	color: #fff;
	width: 200px;
	text-align: center;
	font-size: 16px;
	font-family: roboto;
//	margin: auto;
	border-radius: 30px;
	padding: 5px;
	font-weight: 500;
}
.ent-register {
//	text-align: center;
	margin: 30px 0;
}
.ent-register a {
	color: #fff;
	background-color: #00a0e3;
	padding: 10px 25px;
	font-size: 16px;
	font-family: roboto;
	font-weight: 600;
	border-radius: 4px;
	width: 200px;
    margin: auto;
}
.speakers {
    text-align: center;
    margin: 20px 0;
}
.sir {
    text-align: center;
}
.date-reg{
    display:none;
}
@media only screen and (max-width: 1199px) {
  .ent-heading h3 {
	    font-size: 34px;
	}
}
@media only screen and (max-width: 768px) {
  .ent-heading h3 {
	    text-align:center;
	}
	.date-reg, .new-r a{
        display:block !important;
    }
    .ent-register a{display:none;}
    .ent-heading p {margin:auto;}
    .ent-register{text-align:center;}
    .date-reg{flex-basis:100%}
}
');
