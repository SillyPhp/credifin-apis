<?php

use yii\helpers\Url;
$news_title = urlencode($news_title);
?>

    <div class="share-social">
        <div class="fb-sharr basis">
            <a href="javascript:;" onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                <span><i class="fab fa-facebook-f"></i> Facebook</span>
            </a>
        </div>
        <div class="whatsapp-share basis">
            <a href="javascript:;" onclick="window.open('<?= Url::to('https://api.whatsapp.com/send?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                <span><i class="fab fa-whatsapp"></i> Whatsapp</span>
            </a>
        </div>
        <div class="teleg-share basis">
            <a href="javascript:;" onclick="window.open('<?= Url::to('https://telegram.me/share/url?url='. $link ); ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                <span><i class="fab fa-telegram-plane"></i> Telegram</span>
            </a>
        </div>
        <div class="twi-share basis">
            <a href="javascript:;" onclick="window.open('<?= Url::to('https://twitter.com/intent/tweet?text='.$news_title.'&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                <span><i class="fab fa-twitter marg"></i> Twitter</span>
            </a>
        </div>
        <div class="link-share basis">
            <a href="javascript:;" onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link.'&title='.$news_title.'&summary='.$news_title.'&source='.Url::base(true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-elem-main">
                <span><i class="fab fa-linkedin-in marg"></i> LinkedIn</span>
            </a>
        </div>
    </div>
<?php
$this->registercss('
.share-social {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    margin: 10px 0;
}
.basis {
    flex-basis: 19%;
    margin: 0 1% 1% 0;
}
.fb-sharr a, .whatsapp-share a, .teleg-share a, .twi-share a, .link-share a, .download button{
	display: block;
	color: #fff;
	padding: 8px 10px;
	font-size: 16px;
	font-family: roboto;
	font-weight: 500;
}
.fb-sharr a{background-color:#4267B2;}
.whatsapp-share a{background-color:#36dc54;}
.teleg-share a{background-color:#2399d7;}
.twi-share a{background-color:#1da1f2;}
.link-share a{background-color:#0073b1;}
');
$script = <<<JS
$('.sharing-box div .share-elem-main').each(function() {
    var href = $(this).attr('href');
    var page_url = window.location.href;
    $(this).attr('href', href + page_url);
});
JS;
$this->registerJs($script);