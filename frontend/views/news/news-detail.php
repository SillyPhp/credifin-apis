<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

$this->title = $newsDetail['title'] . ' ' . Yii::$app->params->seo_settings->title_separator . ' Empower Youth';
$link = Url::to($newsDetail->slug . '/news', true);
$keywords = 'Empower Youth News: Get Latest and Breaking News Updates of world';
$description = 'Get Latest and Breaking News Updates of India and world, live world and India news headlines, and Read all latest India and world news & top news on Empower Youth.
breaking news updates in hindi,breaking news updates india, 24/7 latest breaking news update,www breaking news,News Updates.';
$image = Url::to(Yii::$app->params->upload_directories->posts->featured_image . $newsDetail->image_location . '/' . $newsDetail->image);
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::to(Yii::$app->request->url,'https'),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Url::to(Yii::$app->request->url,'https'),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="cb-blog-box">
                                <div class="cb-blog-icon header-banner">
                                    <?php
                                    if ($newsDetail->image) {
                                        ?>
                                        <img src="<?= Url::to(Yii::$app->params->upload_directories->posts->featured_image . $newsDetail->image_location . '/' . $newsDetail->image); ?>"/>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="cb-blog-title">
                                    <?= $newsDetail->title ?>
                                </div>
                                <div class="vots">
                                    <span class="upv"><i class="fas fa-thumbs-up vote-btn" data-id="upvoteBtn"
                                                         data-key="<?= $newsDetail->news_enc_id ?>"></i> <font
                                                class="vote_value"><?= rand(40, 100) + $newsDetail->upvote ?></font> upvotes</span>
                                    <span class="downv"><i class="fas fa-thumbs-down vote-btn" data-id="downvoteBtn"
                                                           data-key="<?= $newsDetail->news_enc_id ?>"></i> <font
                                                class="vote_value"><?= rand(0, 40) + $newsDetail->downvote ?></font> downvotes</span>
                                </div>
                                <div class="cb-quick-summery">
                                    <?= $newsDetail->description ?>
                                </div>
                                <?php
                                if ($newsDetail->newsTags) {
                                    ?>
                                    <div class="news-tags">
                                        <ul>
                                            <?php
                                            foreach ($newsDetail->newsTags as $tag) {
                                                if ($tag->is_deleted == 0) {
                                                    $t = $tag->assignedTagEnc->tagEnc;
                                                    ?>
                                                    <li><?= $t->name ?></li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>
                                <?php $sharingLink = Url::base(true) . '/news/' . $newsDetail->slug ?>
                                <?= $this->render('/widgets/sharing-widget-new', [
                                    'sharingLink' => $sharingLink,
                                    'news_title' => $this->title,
                                    'link' => $link,
                                ]) ?>
                                <?php
                                if ($newsDetail->source) {
                                    ?>
                                    <div class="source-name">
                                        <span class="src-name"><?= $newsDetail->source ?></span>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="cb-ori-artical-link">
                                    <a href="<?= $newsDetail->link ?>" target="_blank">Read orignal News</a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <?php
                    if (Yii::$app->user->isGuest) {
                        echo $this->render('/widgets/subscribe-newsletter', [
                            'subscribersForm' => $newsletterForm
                        ]);
                    }
                    ?>

                    <?php
                    echo $this->render('/widgets/sharing-box', [
                        'news_title' => $this->title,
                        'link' => $link,
                    ]);
                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="related-heading">Related News</div>
                        </div>
                        <?php
                        if ($relatedNews) {
                            $moreNews = $relatedNews;
                        } else {
                            $moreNews = $latestNews;
                        }
                        foreach ($moreNews as $r) {
                            ?>
                            <div class="col-md-12">
                                <a href="<?= $r->slug ?>">
                                    <div class="cb-blog-box cb-blog-box-small">
                                        <div class="cb-blog-icon">
                                            <img src="<?= Url::to(Yii::$app->params->upload_directories->posts->featured_image . $r->image_location . '/' . $r->image); ?>"/>
                                        </div>
                                        <div class="cb-blog-title cb-blog-title-small">
                                            <?= $r->title ?>
                                        </div>
                                        <div class="cb-blog-time"><?= date('d-M-Y', strtotime($r->created_on)) ?></div>
                                        <div class="cb-blob-web-name cb-blob-web-name-small">
                                            Read
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
<!--                    <//= $this->render("/widgets/square_ads"); ?>-->
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" value="<?= Yii::$app->user->identity->user_enc_id; ?>" id="user_id">

<?php
$this->registerCss('
.vots {
	font-family: roboto;
	padding: 10px 0 5px;
	font-size: 16px;
	text-align:right;
}
.upv {
	color: #00a0e3;
	padding-right:10px;
}
.downv {
	color: #ff7803;
}
.source-name {
	font-size: 16px;
	font-family: roboto;
	padding: 10px 2px 5px;
	text-transform: uppercase;
	text-align:right;
}
.src-name {
	background-color: brown;
	color: #fff;
	padding: 3px 12px;
	font-weight: 500;
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
.news-tags {
    padding-top: 20px;
}
.related-heading{
    font-size:20px;
    text-transform:capitalize;
    color:#000;
    padding-bottom:10px;
    padding-top:20px;
    font-weight:bold;
}
.cb-blog-box{
    width:100%;
//    border:1px solid #eee;
    padding-bottom: 20px;
}
.cb-blog-box-small{
    padding-bottom: 30px;
}
.cb-blog-box.cb-blog-box-small .cb-blog-icon{
    text-align:center;
}
.cb-blog-box.cb-blog-box-small .cb-blog-icon img{
    max-height: 300px;
    margin: auto;
}
.cb-blog-title{
    font-size: 25px;
    color: #000;
    line-height: 27px;
    padding-top: 15px;
}
.cb-blog-title-small{
    font-size:20px !important; 
    padding-top: 10px; 
}
.cb-blob-web-name {
    font-size:14px;
    padding-top:14px;
     color: #999;
     text-transform:capitalize;
}
.cb-blob-web-name-small{
    padding-top: 5px !important;
}
.cb-blob-web-name a{  
    font-weight: bold;
}
.cb-blob-web-name a:hover{
    color:#00a0e3;
}
.cb-blog-time{
    color:#999;
    font-size:14px;
}
.cb-quick-sum-heading{
    padding-top:25px;
    font-size:20px;
    font-weight:bold;
}
.cb-quick-summery{
    text-align:justify;
    line-height:25px;
}
.cb-ori-artical-link{
    margin-top:15px;
    margin-bottom:15px;
    text-align:right;
}
.cb-ori-artical-link a{
    text-transform:uppercase;
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    padding: 13px 32px;
    border-radius: 4px;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
    color: #222;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    background: #fff;
}
.cb-ori-artical-link a:hover{
    background-color: #00a0e3;
    color: #fff;
 }
 textarea{
    border:1px solid #eee; 
    border-radius:10px;
    width:100%;
    padding:10px 15px;
}
textarea::placeholder{
    color:#999;
    font-size:13px;
}   
.view-replies {
    padding: 10px 15px;
    background-color: #00a0e3;
    color: #fff;
    border-color: transparent;
    border-radius: 4px;
}
.reply button {
    background: transparent;
    border: none;
    font-size: 14px;
    color: #999;
}
.channel-icon, .comment-icon{
    background:#fff;
    box-shadow:0 0 10px rgba(0, 0, 0, .5);
    border-radius:50%;
    width:125px;
    height:125px;
    border:3px solid #eee;
    margin:0 auto;
    overflow:hidden;
    object-fit:cover;
}
.comment-icon{
    width:90px;
    height:90px;
}
.channel-icon img, .channel-icon canvas, .comment-icon img{
    width:100%;
    height:100%;
    line-height:0px;
}

.blog-comm, .reply-comm {
    border-bottom: 1px dotted #eee;
    padding: 25px 5px 20px;
    border-radius: 10px;
    position: relative;
}
.reply-comm {
    border-bottom: none;
}
.comment-name{
    font-weight:bold;
    text-transform:uppercase;
    font-size:15px;
}
.comment{
    margin-top:5px;
    border-left:1px solid #eee;
    padding:0 0px 0 20px;
}
.reply{
    position:absolute;
    top:10px;
    right:20px;
}
.reply button{
    background: transparent;
    border:none;
    font-size:14px;
    color:#999;
}
.reply button:hover{
    color:#00a0e3;
}
.reply-comm .comment{
    margin-left:15px;
}
.header-banner{
    text-align:center;
}
.header-banner img{
    max-height:460px;
    width:auto;
    margin:auto;
}
.vote-btn{
    cursor: pointer;
}
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
    var valBox = btn.next();
    var targetValue = valBox.text();
    $.ajax({
        url: '/news',
        type: 'POST',
        data: {id:id,key:key},
        beforeSend: function () {
            btn.attr('disabled', true);
            var updateValue = parseInt(targetValue) + 1; 
             valBox.text(updateValue);
        },
        success: function (response) {
            btn.attr('disabled', false);
            if (response.status == 201) {
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