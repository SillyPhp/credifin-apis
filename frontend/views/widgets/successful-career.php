<?php

use yii\helpers\Url;

?>

<section>
    <div class="container car-back">
        <div class="row">
            <div class="col-md-7 pull-right">
                <div class="car-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/careers/newcar.png') ?>" alt=""/>
                </div>
            </div>
            <div class="col-md-5">
                <div class="car-main">
                    <h3>This Site is the Secret to a Successful Career.</h3>
                    <div class="car-content">Sign Up Today!!!</div>
                    <div class="ey-logo">
                        <a href="https://www.empoweryouth.com">
                        <img src="<?= Url::to('@eyAssets/images/logos/eycom.png') ?>" alt=""/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registercss('
.car-back {
    background-image: linear-gradient(to right, white 34%, #EBF5FF 0%);
    margin-top: 20px;
    margin-bottom: 20px;
}
.car-main {
    background-color: #fbfcfc;
    border: 2px solid transparent;
    padding: 20px 45px 100px;
    margin-bottom: 20px;
}
.car-main h3 {
    font-size: 32px;
    font-family: lora;
    line-height: 40px;
}
.car-content {
    font-size: 18px;
    font-family: roboto;
}
.ey-logo {
    width: 190px;
    margin-top: 5px;
}
.car-img {
    width: 400px;
    margin: auto;
    padding: 30px 0;
}
@media(max-width:1199px){
.car-main{padding:20px 45px 50px;}
}
@media(max-width:992px){
.car-back {background-image: linear-gradient(to right, white 0%, #EBF5FF 0%);border-radius:4px;}
.pull-right{float:none !important;}
.car-main {padding: 0px 45px 25px;}
.car-img {width: 340px;}
}
');