<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <Section class="news-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="get-latest">Get Latest News Updates</div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="get-logo">
                        <img src="<?= Url::to('@eyAssets/images/pages/news-update/news2.png'); ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </Section>

    <section>
        <div class="container">
            <div class="row">
                <?php
                foreach ($news as $n) {
                    ?>
                    <div class="col-md-4 col-sm-6">
                        <a href="<?= Url::to('/news/' . $n->slug) ?>">
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
                                    <div class="news-content"><?= strip_tags($n->description) ?></div>
                                    <div class="use-flex">
                                        <?php $sharingLink = Url::base(true) . '/news/' . $n->slug ?>
                                        <div class="share-news">
                                            <div class="wts-sh basis">
                                                <a href="#!"
                                                   onclick="window.open('https://wa.me/?text=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')">
                                                    <span class="fb-btn" title="share on whatsapp"
                                                          data-toggle="tooltip"><i class="fab fa-whatsapp"></i></span>
                                                </a>
                                            </div>
                                            <div class="tel-sh basis">
                                                <a href="#!"
                                                   onclick="window.open('https://telegram.me/share/url?url=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')">
                                                    <span class="tw-btn" title="share on telegram"
                                                          data-toggle="tooltip"><i
                                                                class="fab fa-telegram-plane"></i></span>
                                                </a>
                                            </div>
                                            <div class="tw-sh basis">
                                                <a href="#!"
                                                   onclick="window.open('https://twitter.com/intent/tweet?text=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')">
                                                    <span class="tw-btn" title="share on twitter" data-toggle="tooltip"><i
                                                                class="fab fa-twitter marg"></i></span>
                                                </a>
                                            </div>
                                            <div class="li-sh basis">
                                                <a href="#!"
                                                   onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                                    <span class="li-btn" title="share on linkedIn"
                                                          data-toggle="tooltip"><i class="fab fa-linkedin-in marg"></i></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="news-btns">
                                            <button data-id="upvoteBtn" data-key="<?= $n->news_enc_id ?>" class="vote-btn"
                                                    title="<?= $n->upvote ?>" data-toggle="tooltip"><i
                                                        class="fas fa-thumbs-up"></i>
                                            </button>
                                            <button data-id="downvoteBtn" data-key="<?= $n->news_enc_id ?>" class="vote-btn"
                                                    title="<?= $n->downvote ?>" data-toggle="tooltip"><i
                                                        class="fas fa-thumbs-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!--Subscribe Widget start-->
<?php
if (Yii::$app->user->isGuest) {
    echo $this->render('/widgets/subscribe-section');
}
?>
    <!--Subscribe Widget ends-->

<?php
$this->registercss('
.news-bg {
	background-color: #f59f0c;
	padding: 20px 0;
}
.get-latest {
	font-size: 45px;
	font-family: lora;
	font-weight: 600;
	margin-top: 155px;
	color: #fff;
}
@media(max-width:1199px){
.get-latest {
	margin-top: 100px;
}
}
@media(max-width:768px){
.get-latest {
	margin-top: 50px;
}
}
@media(max-width:550px){
.get-latest {
	font-size:32px;
	text-align:center;
}
.get-logo {
	width: 250px;
	margin: auto;
}
}
.news-box {
    border-radius: 8px;
    box-shadow: 0 0 6px 1px #eee;
    margin-bottom:20px;
    transition:all .3s;
}
.news-box:hover {
	transform: translatey(-5px);
	box-shadow: 0 0 15px 6px #eee;
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
    border-radius:8px 8px 0px 0px; 
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
.news-btns button {
	background-color: #00a0e3;
	border: none;
	color: #fff;
	padding: 3px 15px;
	font-size: 16px;
	border-radius: 2px;
}
.use-flex {
	display: flex;
	justify-content: space-between;
	padding: 2px 0;
}
.share-news {
    display: flex;
}
.basis a {
	margin-right: 10px;
	color: #fff;
	padding: 4px 6px;
	border-radius: 3px;
}
.wts-sh a{background-color:#36dc54;}
.tel-sh a{background-color:#2399d7;}
.tw-sh a{background-color:#1da1f2;}
.li-sh a{background-color:#0073b1;}
');

$script = <<<JS
$(document).on('click', '.vote-btn', function (event) {
    event.preventDefault();
    var btn = $(this);
    event.stopImmediatePropagation();
    if ( btn.data('requestRunning') ) {
        return false;
    }
    btn.data('requestRunning', true);
    
    var id = btn.attr('data-id');
    var key = btn.attr('data-key');
    var targetValue = btn.attr('data-original-title');
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
                var updateValue = parseInt(targetValue) + 1; 
                btn.attr('data-original-title', updateValue);
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
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);