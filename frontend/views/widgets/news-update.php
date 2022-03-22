<?php

use common\models\ExternalNewsUpdate;
use yii\helpers\Url;

?>

    <section class="news-updation">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="n-heading">Latest News Update</div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="view-all-news">
                        <a href="<?= Url::to('/news') ?>">View All</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $newsUpdates = ExternalNewsUpdate::find()
                    ->where(['is_deleted' => 0, 'status' => 1, 'is_visible' => 1])
                    ->orderBy(['created_on' => SORT_DESC])
                    ->limit(9)
                    ->all();
                foreach ($newsUpdates as $n) {
                    ?>
                    <div class="col-md-4 col-sm-6">
                        <a href="<?= Url::to('/news/' . $n->slug) ?>">
                            <div class="news-bx">
                                <div class="news-logo">
                                    <img class="load-later" data-src="<?= Url::to(Yii::$app->params->upload_directories->posts->featured_image . $n->image_location . '/' . $n->image); ?>"
                                         src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt=""/>
                                </div>
                                <div class="news-name"><?= $n->title ?></div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
<?php
$this->registercss('
.news-updation {
	background:linear-gradient(to bottom right, #141e30 0%, #243b55 100%);
	padding:20px 0 40px;
}
.n-heading {
	text-align: left;
	margin: 0px 0 20px;
	font-size: 34px;
	font-family: lora;
	font-weight: 600;
	color: #fff;
}
.view-all-news a{
	text-align: right;
	font-size: 16px;
	font-family: roboto;
	color: #000;
	background-color: #fff;
	float: right;
	padding: 2px 17px;
	margin-top: 12px;
	margin-bottom: 12px;
	border-radius: 4px;
	transition:all .3s;
	border:2px solid transparent;
}
.view-all-news:hover a{
    background-color:#141e30;
    color:#fff;
    border:2px solid #fff;
}
.news-bx {
	display: flex;
	margin-bottom: 15px;
	border: 1px dotted #fff;
	padding: 10px;
	transition: all .3s;
	align-items:center;
	height:80px;
}
.news-bx:hover {
	background-color: #fff;
}
.news-logo {
    max-width: 70px;
    line-height: 50px;
    height: 55px;
    overflow: hidden;
    min-width: 70px;
}
.news-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.news-name {
    padding-left: 14px;
    font-size: 14px;
    font-family: roboto;
    color: #fff;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.news-bx:hover .news-name {
	color: #000;
}
');
$script = <<<JS
$('.load-later').Lazy();
JS;
$this->registerJs($script);