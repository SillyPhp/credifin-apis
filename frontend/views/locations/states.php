<?php
$this->title = Yii::t('frontend', 'States');
$this->params['header_dark'] = false;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;

?>
    <section class="all-state-header">
        <div class="ash-vector"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="pos-real">
                        <div class="ash-banner-text">
                            <div class="ash-b-heading">
                                <h1>India's Fastest Growing Career Helping Portal</h1>
                                <span>More Opportunities, More Ease </span>
                            </div>
                            <div class="ash-stats">
                                <ul>
                                    <li>
                                        <div class="stat-num">20+</div>
                                        <div class="stat-title">States</div>
                                    </li>
                                    <li class="ash-border">
                                        <div class="stat-num">100+</div>
                                        <div class="stat-title">Cities</div>
                                    </li>
                                    <li>
                                        <div class="stat-num">1000+</div>
                                        <div class="stat-title">Opportunities</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="pos-real">
                        <div class="ash-icon1">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/i1.png') ?>" alt=""
                                 class="img-responsive">
                        </div>
                        <div class="ash-icon2">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/i2.png') ?>" alt="">
                        </div>
                        <div class="ash-icon3">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/i3.png') ?>" alt="">
                        </div>
                        <div class="ash-icon4">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/i4.png') ?>" alt="">
                        </div>
                        <div class="ash-icon5">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/i5.png') ?>" alt="">
                        </div>
                        <div class="ash-icon6">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/i6.png') ?>" alt="">
                        </div>
                        <div class="ash-icon7">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/i7.png') ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="heading-style">States</h1>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($states as $app) {
                            ?>
                            <div class="col-md-4 col-sm-6">
                                <a href="">
                                    <div class="state-box">
                                        <div class="state-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/locations/'.strtolower($app["state_name"]).'.png') ?>"
                                                 alt="">
                                        </div>
                                        <div class="state-name"><?= $app['state_name'] ?></div>
                                        <div class="state-oppertunities">
                                            <ul>
                                                <li><span>Jobs:</span> <?= $app['jobs'] ?></li>
                                                <li><span>Internships:</span> <?= $app['internships'] ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="heading-style">Popular Profiles</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/ey-profile.png') ?>">
                        </div>
                        <div class="col-md-4">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/ey-profile.png') ?>">
                        </div>
                        <div class="col-md-4">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/ey-profile.png') ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="heading-style">Popular Cities</h1>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($cities as $app) {
                            ?>
                            <div class="col-md-3 col-sm-6">
                                <a href="">
                                    <div class="city-main">
                                        <div class="city-image">
                                            <img src="<?= Url::to('@eyAssets/images/pages/custom/'.strtolower($app["city_name"]).'.png') ?>">
                                        </div>
                                        <div class="city-name"><?= $app['city_name'] ?></div>
                                        <div class="divider"></div>
                                        <div class="city-data">
                                            <div class="openings">10 Total Openings</div>
                                            <div class="count"><?= $app['jobs'] ?> Jobs, <?= $app['internships'] ?> Internships</div>
                                        </div>
                                        <!--                        <div class="btn btn-info"><a href="">View Jobs</a></div>-->
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="heading-style">Recent Jobs</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <div class="job-card">
                                <img src="<?= Url::to('@eyAssets/images/pages/jobs/job-card.png') ?>" alt="">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <div class="job-card">
                                <img src="<?= Url::to('@eyAssets/images/pages/jobs/job-card.png') ?>" alt="">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <div class="job-card">
                                <img src="<?= Url::to('@eyAssets/images/pages/jobs/job-card.png') ?>" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="heading-style">Recent Internships</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <div class="job-card">
                                <img src="<?= Url::to('@eyAssets/images/pages/jobs/job-card.png') ?>" alt="">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <div class="job-card">
                                <img src="<?= Url::to('@eyAssets/images/pages/jobs/job-card.png') ?>" alt="">
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <div class="job-card">
                                <img src="<?= Url::to('@eyAssets/images/pages/jobs/job-card.png') ?>" alt="">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
@media only screen and (max-width: 1200px) and (min-width:768px){
    .ash-icon1 {
        left: 1%;
        top: 60px;
    }
    .ash-icon1 img{
        max-width: 150px;    
    }
    .ash-icon2 {
        top: 43px;
        left: 35%;
    }
    .ash-icon2 img{
        max-width: 100px;
    }
    .ash-icon3 {
        right: 0% !important;
        top: 5% !important;
    }
    .ash-icon3 img{
        max-width: 100px;
    }
    .ash-icon4 {
        top: 45%;
        left: 22%;
    }
    .ash-icon4 img{
        max-width: 130px;
    }
    .ash-icon5 img{
        max-width: 105px;
    }
    .ash-icon6{
        top: 100px;
        right: 3%;
    }
    .ash-icon6 img{
        max-width: 190px;
    }
    .ash-icon7 img{
        max-width: 110px;
    }
}
.state-oppertunities ul li{
    display:inline; 
    padding:0 5px;
}
.state-oppertunities span{
    font-weight:bold;
}
.ash-b-heading h1{
    font-size: 31px;
    margin-bottom: 0px;
    font-weight:bold;
    color:#000;
}
.ash-b-heading span{
    font-size:17px;
    color:#000;
}
.stat-num{
    font-size:27px;
    color:#000;
}
.stat-title{
    margin-top: -10px;
    color:#000
    ;
}
.ash-b-heading{
    text-align:center;
}
.ash-banner-text{
    position: absolute;
    width:100%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.ash-stats ul{
    padding-inline-start: 0px;
}
.ash-stats ul li{
    display: inline-block;
    min-width: 50px;
    text-align: center;
    padding: 0 15px;
}
.ash-stats{
    text-align:center;
    margin-top:20px;
}
.ash-icon1, .ash-icon2, .ash-icon3, .ash-icon4,.ash-icon5, .ash-icon6, .ash-icon7{
    position:absolute;
} 
.pos-real{
    width:100%;
    position: relative;
    min-height:400px
}
.ash-icon7{
    bottom: 5%;
    right: 0%;
}
.ash-icon6{
    top: 67px;
    right: 2%;
}
.ash-icon5{
    left: 55%;
    top: 57%;
    z-index: 1;
}
.ash-icon4{
    top: 46%;
    left: 19%;
}
.ash-icon3{
    right: -1%;
    top: 4%;
    z-index:1;
}
.ash-icon2{   
    top: 37px;
    left: 36%;;
}
.ash-icon1{
    left:0%;
    top:50px;
}
.all-state-header{
//    background:#f9f9f9;
//    background:#efefef;
    background: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);
    min-height:400px;
    padding-top:20px;
    position:relative;
    overflow:hidden;
}
.ash-vector{
    background-image:url(' . url::to("@eyAssets/images/pages/custom/stateshdr1.png") . ');
    background-repeat: no-repeat;
    background-position: right bottom; 
    width: 100%;
    height: 100%;
    position:absolute;
}
.state-box{
    box-shadow:0 0 10px rgba(0,0,0,.1);
    text-align:center;
    border-radius: 8px;
    margin-bottom: 20px;
    padding: 0 0 10px 0;
} 
.state-name{
    font-size:20px;
    font-weight:bold;
    font-family: lora;
}
.state-icon img{
    border-radius:8px 8px 0 0;   
}
.city-main{
	border: 1px solid #eee;
	border-radius: 10px;
	text-align: center;
	padding: 0 0 20px 0;
	box-shadow: 0px 0px 6px 1px #eee;
	margin-bottom:15px;
}
.city-image {
	border-bottom: 1px solid #eee;
}
.city-image img{
	width: 100%;
	height: 100px;
	border-top-left-radius: 10px;
	border-top-right-radius: 10px;
}
.city-name{
	font-size: 18px;
	font-weight: bold;
	padding: 10px 0 10px 0;
}
.divider{
	border-bottom: 1px solid #e2dddd;
	width: 70%;
    margin: 0 auto;
}
.city-data{
	padding: 15px 0;
}
.openings{
	font-size: 16px;
	font-weight: bold;
}
.count{
	color: #bdbdbd;
}
.btn-info{
	background-color:#eeeeee33 !important;
	border-color:#e2e2e2 !important;
	padding: 6px 46px !important;
}
.btn-info:hover{box-shadow: 1px 4px 6px -1px #eee !important;}
.btn a{
	color: black !important;
	text-decoration: none;
	font-size: 15px;
	font-weight: bold;
}
');
?>