<?php

use yii\helpers\Url;

?>
    <section class="j-tweets">
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="heading-style">Top Cities</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($cities_jobs as $app) {
                    ?>
                    <div class="col-md-3 col-sm-6">

                        <div class="city-main">
                            <div class="city-image">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/' . preg_replace('/\s+/', '_', strtolower($app["city_name"])) . '.png') ?>">
                            </div>
                            <div class="city-name"><?= $app['city_name'] ?></div>
                            <div class="divider"></div>
                            <div class="city-data">
                                <div class="openings">
                                    <?php
                                    if ($type == 'jobs' || $type == 'internships') {
                                        ?>
                                        Total Openings
                                        <?php
                                    } else {
                                        ?>
                                        <?= $app['jobs'] + $app['internships'] ?>  Total Openings
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
                                        ,<a href="<?= Url::to('/internships/list?location=' . $app['city_name']); ?>">
                                            <?= $app['internships'] ?>
                                            Internships
                                        </a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?= Url::to('/jobs/list?location=' . $app['city_name']); ?>">
                                            <?= $app['jobs'] ?> Jobs
                                        </a>,
                                        <a href="<?= Url::to('/internships/list?location=' . $app['city_name']); ?>">
                                            <?= $app['internships'] ?> Internships
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!--                        <div class="btn btn-info"><a href="">View Jobs</a></div>-->
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
/*cities*/
.city-main{
	border: 1px solid #eee;
	border-radius: 10px;
	text-align: center;
	padding: 0 0 20px 0;
	box-shadow: 0px 0px 6px 1px #eee;
	margin-bottom:15px;
    background: #fff;
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
//.btn-info{
//	background-color:#eeeeee33 !important;
//	border-color:#e2e2e2 !important;
//	padding: 6px 46px !important;
//}
//.btn-info:hover{box-shadow: 1px 4px 6px -1px #eee !important;}
//.btn a{
//	color: black !important;
//	text-decoration: none;
//	font-size: 15px;
//	font-weight: bold;
//}
')
?>