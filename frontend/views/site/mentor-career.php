<?php

use yii\helpers\Url;

?>

    <section style="background: #2c7480;">
        <div class="container headsec">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 pull-right">
                    <div class="newlogoset">
                        <div class="main-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentor/r-vector.png'); ?>" align="right"
                                 class="responsive"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 topp-pad">
                    <div class="main-heading-set">
                        <div class="min-heading">Become a CareerGuide Expert</div>
                        <div class="jumbo-heading">Join India's Largest Community of Career Counsellors</div>
                        <ul class="c-points">
                            <li>Boost Your online visibility</li>
                            <li>widen your reach</li>
                            <li>increase your network</li>
                            <li>multiply your earnings</li>
                        </ul>
                        <div class="ment-sign">
                            <a href="#">Sign up For Mentorship</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section style="padding: 30px 0;">
        <div class="container" style="background-color: aliceblue;border-radius: 8px;">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="car-main">
                        <div class="car-head"><i class="far fa-star"></i> Build Online Reputation</div>
                        <div class="car-content">Build your online visibility and credibilty by helping students on
                            CareerGuide.
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="car-main">
                        <div class="car-head"><i class="fas fa-expand"></i> Expand Your Reach</div>
                        <div class="car-content">CareerGuide helps you expand your geographic reach by connecting
                            students across India and South Asian Countries.
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="car-main">
                        <div class="car-head"><i class="fas fa-project-diagram"></i> Increase Your Network</div>
                        <div class="car-content">Connect with your peers across multiple geographies by joining
                            CareerGuide. Exchange knowledge and expertise.
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="car-main">
                        <div class="car-head"><i class="fas fa-rupee-sign"></i> Multiply Your Earning</div>
                        <div class="car-content">CareerGuide can become an alternative earning channel when you need it.
                            You can earn just by devoting your free time from anywhere.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
echo $this->render('/widgets/mentorship-works');
?>

<?php
$this->registercss('
.newlogoset{
    max-width:480px;
    margin: 0 auto;
    position:relative;
    padding-top:20px;
}
.main-img {
    position: relative;
    display: inline-block;
    z-index: 9;
    margin-bottom: 10px;
    margin-top:20px;
}
.main-heading-set {
    display: block;
    z-index: 9;
    position: relative;
    padding-top: 100px;
}
.min-heading {
    color: #fff;
    text-transform: uppercase;
    font-weight: 500;
    font-size: 32px;
    font-family: roboto;
    letter-spacing: 1px;
}
.jumbo-heading {
    font-size: 20px;
    font-family: roboto;
    text-transform: capitalize;
    color: #fff;
}
.c-points {
    font-size: 18px;
    color: #fff;
    list-style: square;
    padding-left: 20px;
    text-transform: capitalize;
}
.ment-sign{
    margin:20px 0;
}
.ment-sign a{
    font-size: 16px;
    color: #fff;
    background-color: #ff7803;
    padding: 8px 20px;
    border-radius: 4px;
    font-weight: 500;
    font-family: roboto;
}
.car-main {
    border: 2px solid transparent;
//    box-shadow: 0 0 17px 2px #eee;
    border-radius: 8px;
    padding: 20px;
    font-family: roboto;
    min-height: 150px;
    margin-bottom:20px;
    background-color:#fff; 
}
.car-head {
    font-size: 20px;
    color: #5ebeca;
    font-weight: 500;
}   
.car-head > i{
    padding-right:2px;
    font-size:17px;
}
.car-content {
    font-size: 16px;
    text-align: justify;
    padding: 0px 2px;
}
@media(max-width:1199px){
.car-main{min-height:180px;}
}
@media(max-width:1024px){
.newlogoset{padding-top:50px;max-width:400px;}
.min-heading{font-size:25px;}
.jumbo-heading{font-size:18px;}
.c-points{font-size:16px}
}
@media(max-width:991px){
.car-main{min-height:190px;}
.main-heading-set{padding-top:55px;}
}
@media(max-width:512px){
.main-heading-set{padding-top:15px;}
}
');
