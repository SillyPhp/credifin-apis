<?php

use yii\helpers\Url;

?>
    <section class="top-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="heading-style">Employment in Top Cities</h2>
                </div>
            </div>
            <div class="row">
                <?= $this->render('/widgets/preloaders/top-cities-preloader'); ?>
                <div id="cities-main">
                    <?php
                    foreach ($cities_jobs as $app) {
                        ?>
                        <div class="col-md-4 col-sm-6">
                            <div class="city-main"
                                 style="background: url(<?= Url::to('@commonAssets/images/cities/' . preg_replace('/\s+/', '_', strtolower($app["city_name"])) . '.png') ?>)">
                                <!--                                <div class="city-image">-->
                                <!--                                    <img src="-->
                                <?//= Url::to('@commonAssets/images/cities/' . preg_replace('/\s+/', '_', strtolower($app["city_name"])) . '.png') ?><!--">-->
                                <!--                                </div>-->
                                <!--                        <div class="btn btn-info"><a href="">View Jobs</a></div>-->
                            </div>
                            <div class="main-set">
                                <div class="city-name"><?= $app['city_name'] ?></div>
                                <div class="divider"></div>
                                <div class="city-data">
                                    <div class="openings">
                                        <?php
                                        if ($type == 'jobs' || $type == 'internships') {
                                            ?>
                                            Total Vacancies
                                            <?php
                                        } else {
                                            ?>
                                            <?= $app['jobs'] + $app['internships'] ?>  Total Vacancies
                                            <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="count">

                                        <?php
                                        if ($type == 'jobs') {
                                            ?>
                                            <a href="<?= Url::to('/jobs/list?location=' . $app['city_name']); ?>">
                                                <?= $app['jobs'] ?> Jobs
                                            </a>
                                            <?php
                                        } elseif ($type == 'internships') {
                                            ?>
                                            <a href="<?= Url::to('/internships/list?location=' . $app['city_name']); ?>">
                                                <?= $app['internships'] ?>
                                                Internships
                                            </a>
                                            <?php
                                        } else {
                                            ?>
                                            <a href="<?= Url::to('/jobs/list?location=' . $app['city_name']); ?>">
                                                <?= $app['jobs'] ?> Jobs
                                            </a>
                                            <a href="<?= Url::to('/internships/list?location=' . $app['city_name']); ?>">
                                                <?= $app['internships'] ?> Internships
                                            </a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.top-bg{
   background-color:#fff;
   padding:20px 0 50px;
}
.main-set {
	/* padding-bottom: 20px; */
	background-color: #fff;
	text-align: center;
	border: 1px solid #eee;
	border-radius: 4px;
	margin-top: -39px !important;
	width: 85%;
	margin: auto;
	margin-bottom: 25px !important;
	box-shadow: 0 4px 7px rgba(0, 0, 0, 0.2);
}
/*cities*/
.city-main{
//	background: url();
    background-size: 100% 100% !important;
    background-repeat: no-repeat !important;
    min-height:160px;
    border-radius:8px;
}
//.city-image {
//	border-bottom: 1px solid #eee;
//}
//.city-image img{
//	width: 100%;
//	height: 100px;
//	border-top-left-radius: 10px;
//	border-top-right-radius: 10px;
//}
.city-name {
	font-size: 20px;
	font-weight: 600;
	font-family: lora;
	padding: 5px 0 5px 0;
}
.main-set .city-data .count a {
    padding: 2px 6px;
    font-size: 14px;
    border-radius:4px;
}
.city-main:hover ~ .main-set .city-data .count a {
	color: #fff;
	background-color: #00a0e3;
	transition: all .3s;
}
.main-set:hover .city-data .count a {
	color: #fff;
	background-color: #00a0e3;
	transition: all .3s;
}
.divider{
	border-bottom: 1px solid #e2dddd;
	width: 70%;
    margin: 0 auto;
}
.city-data{
	padding: 5px 0;
}
.openings{
	font-size: 16px;
	font-weight: 500;
	font-family: roboto;
}
.count {
	color: #bdbdbd;
	padding-top: 5px;
	font-family: roboto;
	display: flex;
	justify-content: space-around;
}
#cities-main{
    display:none;
}
');
$script = <<<JS
setTimeout(function() {
    $('.loading-main').remove();
    $('#cities-main').slideDown(500);
}, 2000);
JS;
$this->registerJs($script);
?>