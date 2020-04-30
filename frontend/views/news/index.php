<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <Section class="news-bg"></Section>

    <section>
        <div class="container">
            <div class="row">
                <?php
                foreach ($news as $n) {
                    ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="news-box">
                            <div class="news-img">
                                <img src="<?= Url::to(Yii::$app->params->upload_directories->posts->featured_image . $n->image_location . '/' . $n->image); ?>"/>
                            </div>
                            <div class="news-main">
                                <a href="<?= Url::to('/news/' . $n->slug) ?>">
                                    <div class="news-heading"><?= $n->title ?></div>
                                </a>
                                <div class="news-date"><?= date('d M Y', strtotime($n->created_on)) ?></div>
                                <div class="news-tags">
                                    <ul>
                                        <?php
                                        $index = 1;
                                        foreach ($n->newsTags as $tag) {
                                            if ($tag->is_deleted == 0) {
                                                $t = $tag->assignedTagEnc->tagEnc;
                                                ?>
                                                <li><?= $t->name ?></li>
                                                <?php
                                                if ($index == 3) {
                                                    break;
                                                }
                                                $index++;
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="news-content"><?= $n->description ?></div>
                                <div class="news-btns">
                                    <button id="upvoteBtn" data-key="<?= $n->news_enc_id ?>" class="vote-btn"
                                            title="upvote"><i class="fas fa-chevron-up"></i></button>
                                    <button id="downvoteBtn" data-key="<?= $n->news_enc_id ?>" class="vote-btn"
                                            title="downvote"><i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

<?php
echo $this->render('/widgets/news-update');
?>

<?php
$this->registercss('
.news-bg{
    background:url(' . Url::to('@eyAssets/images/pages/news-update/newsbg.png') . ');
    min-height:450px;
    background-position: right;
    background-repeat: no-repeat;
    background-size: cover;  
}
.news-box {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 6px 1px #eee;
    margin-bottom:20px;
}
.news-img {
    width: 100%;
    min-height: 160px;
    max-height: 160px;
}
.news-img img{
    width: 100%;
    min-height: 160px;
    max-height: 160px;
}
.news-main {
    padding:10px 15px;
    font-family: roboto;
}
.news-heading {
	font-size: 22px;
	font-weight: 500;
	line-height: 30px;
	text-transform: capitalize;
	color: #333;
	display: block;
	display: -webkit-box;
	max-height: 66px;
	min-height: 66px;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
	text-overflow: ellipsis;
}
.news-date {
    color: #00a0e3;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
    min-height: 23px;
    max-height: 23px;
}
.news-tags {
    min-height: 30px;
    max-height: 30px;
}
.news-tags ul li{
    font-size: 13px;
    background-color: #333;
    display: inline-block;
    padding: 2px 9px;
    color: #fff;
    margin-bottom: 5px;
    border-radius:3px;
    font-weight:500;
}
//.news-tags ul li:nth-child(1) {
//  background: #ff7803;
//}
//.news-tags ul li:nth-child(2) {
//  background: #00a0e3;
//}
//.news-tags ul li:nth-child(3) {
//  background: #a42929;
//}
//.news-tags ul li:nth-child(4) {
//  background: #807e7e;
//}
.news-content {
	font-size: 16px;
	line-height: 24px;
	text-align: justify;
	background: #FFFFFF;
	display: block;
	display: -webkit-box;
	max-height: 75px;
	min-height: 75px;
	-webkit-line-clamp: 3;
	-webkit-box-orient: vertical;
	overflow: hidden;
	text-overflow: ellipsis;
	margin-bottom: 5px;
}
.news-btns {
    text-align:right;
}
.news-btns button {
	background-color: #00a0e3;
	border: none;
	color: #fff;
	padding: 3px 15px;
	font-size: 16px;
	border-radius: 2px;
}
');

$script = <<<JS
$(document).on('click', '.vote-btn', function (event) {
    event.preventDefault();
    var btn = $(this);
    console.log(btn);
    var id = btn.attr('id');
    var key = btn.attr('data-key');
    $.ajax({
        type: 'POST',
        data: {id:id,key:key},
        beforeSend: function () {
            btn.attr('disabled', true);
        },
        success: function (response) {
            btn.attr('disabled', false);
            if (response.status == 200) {
                toastr.success(response.message, response.title);
            } else {
                toastr.error(response.message, response.title);
            }
        },
        complete: function() {
            btn.attr('disabled', false);
        }
    }).fail(function(data, textStatus, xhr) {
         toastr.error('Network Problem', 'Please try later..');
         btn.attr('disabled', false);
    });
});
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);