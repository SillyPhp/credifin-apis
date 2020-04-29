<?php

use common\models\ExternalNewsUpdate;
use yii\helpers\Url;

?>

    <section class="news-updation">
        <div class="container">
            <div class="row">
                <div class="n-heading">News Update</div>
            </div>
            <div class="row">
                <?php
                $newsUpdates = ExternalNewsUpdate::find()
                    ->where(['is_deleted' => 0, 'status' => 1])
                    ->orderBy(['created_on' => SORT_DESC])
                    ->limit(6)
                    ->all();
                foreach ($newsUpdates as $n) {
                    ?>
                    <div class="col-md-4">
                        <a href="<?= Url::to('/news/' . $n->slug) ?>">
                            <div class="news-bx">
                                <div class="news-logo">
                                    <img src="<?= Url::to(Yii::$app->params->upload_directories->posts->featured_image . $n->image_location . '/' . $n->image); ?>"
                                         alt=""/>
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
	background-color: #000;
	padding: 0px 0 30px;
}
.n-heading {
	text-align: center;
	margin: 0px 0 20px;
	font-size: 34px;
	font-family: lora;
	font-weight: 600;
	color: #fff;
}
.news-bx {
	display: flex;
	margin-bottom: 15px;
	border: 1px dashed #fff;
	padding: 10px;
	transition: all .3s;
}
.news-bx:hover {
	background-color: #fff;
}
.news-logo {
    max-width: 70px;
}
.news-name {
	padding-left: 14px;
	font-size: 16px;
	font-family: roboto;
	display: block;
	display: -webkit-box;
	max-height: 56px;
	min-height: 56px;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
	text-overflow: ellipsis;
	color: #fff;
	padding-top: 6px;
}
.news-bx:hover .news-name {
	color: #000;
}
');