<?php

use yii\helpers\Url;

?>

    <div class="share-social">
        <div class="facebook-share basis">
            <a href="https://www.facebook.com/sharer/sharer.php?u=" target="_blank" class="share-elem-main">
                <span class="fb-btn"><i class="fab fa-facebook-f marg"></i> Facebook</span>
            </a>
        </div>
        <div class="twitter-share basis">
            <a href="https://twitter.com/home?status=" target="_blank" class="share-elem-main">
                <span class="tw-btn"><i class="fab fa-twitter marg"></i> Twitter</span>
            </a>
        </div>
        <div class="linked-share basis">
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=" target="_blank" class="share-elem-main">
                <span class="li-btn"><i class="fab fa-linkedin-in marg"></i> LinkedIn</span>
            </a>
        </div>
    </div>
<?php
$this->registercss('
.share-social {
	display: flex;
	align-items: stretch;
	margin:10px 0;
}
.basis{
    flex-basis:50%;
}
.facebook-share a, .twitter-share a, .linked-share a{
	display: block;
	color: #fff;
	padding: 8px 10px;
	font-size: 16px;
	font-family: roboto;
	font-weight: 500;
	margin-right: 10px;
}
.facebook-share a{background-color:#4667ab;}
.twitter-share a{background-color:#1da1f2;}
.linked-share a{background-color:#0073b1;}
');
$script = <<<JS
$('.sharing-box div .share-elem-main').each(function() {
    var href = $(this).attr('href');
    var page_url = window.location.href;
    $(this).attr('href', href + page_url);
});
JS;
$this->registerJs($script);