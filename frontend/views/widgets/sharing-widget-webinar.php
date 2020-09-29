<?php

use yii\helpers\Url;

?>

    <div class="share-social">
        <div class="fbook-share basis">
            <a href="" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-elem-main">
                <span><i class="fab fa-facebook-f marg"></i> Facebook</span>
            </a>
        </div>
        <div class="whatsapp-share basis">
            <a href="" onclick="window.open('https://api.whatsapp.com/send?text=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                <span><i class="fab fa-whatsapp"></i> Whatsapp</span>
            </a>
        </div>
        <div class="teleg-share basis">
            <a href="" onclick="window.open('https://telegram.me/share/url?url=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                <span><i class="fab fa-telegram-plane"></i> Telegram</span>
            </a>
        </div>
        <div class="twi-share basis">
            <a href="" onclick="window.open('https://twitter.com/intent/tweet?text=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                <span><i class="fab fa-twitter marg"></i> Twitter</span>
            </a>
        </div>
        <div class="link-share basis">
            <a href="" onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-elem-main">
                <span><i class="fab fa-linkedin-in marg"></i> LinkedIn</span>
            </a>
        </div>
        <div class="reddit-share basis">
            <a href="" onclick="window.open('http://www.reddit.com/submit?url=<?= $sharingLink ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-elem-main">
                <span><i class="fab fa-reddit marg"></i> Reddit</span>
            </a>
        </div>
    </div>
<?php
$this->registercss('
.share-social {
	display: flex;
	align-items: stretch;
}
.basis{
    flex-basis:50%;
    margin:10px 0 5px;
}
.whatsapp-share a, .teleg-share a, .twi-share a, .link-share a, .reddit-share a, .fbook-share a{
	display: block;
	color: #fff;
	padding: 8px 10px;
	font-size: 16px;
	font-family: roboto;
	font-weight: 500;
	margin-right: 10px;
}
.whatsapp-share a{
    background-color:#36dc54;
}
.teleg-share a{
    background-color:#2399d7;
}
.fbook-share a{
background-color:#3B5998;
}
.twi-share a{
    background-color:#1da1f2;
}
.link-share a{
    background-color:#0073b1;
}
.reddit-share a{
    background-color:#ff4500;
}
.whatsapp-share a:hover, 
.teleg-share a:hover, 
.twi-share a:hover, 
.link-share a:hover, 
.reddit-share a:hover,
.fbook-share a:hover{
    box-shadow: 0 6px 8px rgba(0,0,0,.2);
    transition: .3s ease;
}
@media only screen and (max-width: 600px) {
  .share-social {
        display:block;    
    }
}
');
$script = <<<JS
$('.sharing-box div .share-elem-main').each(function() {
    var href = $(this).attr('href');
    var page_url = window.location.href;
    $(this).attr('href', href + page_url);
});
JS;
$this->registerJs($script);