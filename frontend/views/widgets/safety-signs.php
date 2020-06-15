<?php

use yii\helpers\Url;
?>
<section class="safety-header-widget">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="safety-heading">
                    <h3>We Care For You</h3>
                    <p>Ensure Safety At Your Workplace With COVID-19 Safety Signs</p>
                    <p  class="mb3">Download For Free</p>
                    <a href="/covid-19/warning-posters">View Posters</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="safety-banner-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/safety-posters/posters.png') ?>">
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCSS('
.safety-header-widget{
    background: #ffcc00;
    min-height: 300px;
    display: flex;
    align-items: center;
}
.safety-banner-icon{
    text-align: center;
}
.safety-heading{
   padding-left: 30px;  
}
.safety-heading p{
    color:#000;
    font-family: roboto;
    font-size: 19px; 
    text-transform: capitalize;
    line-height: 25px;
}
.mb3{
    padding-bottom: 30px;
}
.safety-heading h3{
    font-size: 40px;
    font-family: lora;
    font-weight: 600;
    color: #000;
    margin-top: 0px;
} 
.safety-heading a{
    border: 2px solid #000;
    background: #000;
    color: #ffcc00;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    padding: 10px 20px;
    letter-spacing: .5px; 
}
.safety-heading a:hover{
    color: #000;
    border-color: #000;
    background: #ffcc00;
    transition: .3s ease;
}
@media screen and (max-width: 550px){
    .safety-banner-icon{
        padding: 25px;
    }
    .safety-heading {
        padding: 30px;
        text-align: center;
    }
}
');
?>