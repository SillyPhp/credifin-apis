<?php

use yii\helpers\Url;
$news_title = urlencode($news_title);
?>

    <div class="sharing-box">
        <div class="sharing-pic">
            <img src="<?= Url::to('/assets/themes/ey/images/pages/jobs/socialsharing.png'); ?>">
        </div>
        <!--                        <div class="share-it">Share :-</div>-->
        <div class="fb-share">
            <a href="https://www.facebook.com/sharer/sharer.php?u=" target="_blank" class="share-elem-main">
                <span class="fb-btn"><i class="fab fa-facebook-f marg"></i> Facebook</span>
            </a>
        </div>
        <div class="tw-share">
            <a href="javascript:;" onclick="window.open('<?= Url::to('https://twitter.com/intent/tweet?text='.$news_title.'&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                <span class="tw-btn"><i class="fab fa-twitter marg"></i> Twitter</span>
            </a>
        </div>
        <div class="li-share">
            <a href="javascript:;" onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link.'&title='.$news_title.'&summary='.$news_title.'&source='.Url::base(true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-elem-main">
                <span class="li-btn"><i class="fab fa-linkedin-in marg"></i> LinkedIn</span>
            </a>
        </div>
        <div class="wa-share">
            <a href="javascript:;" onclick="window.open('<?= Url::to('https://api.whatsapp.com/send?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100')" class="share-elem-main">
                <span class="wa-btn"><i class="fab fa-whatsapp"></i> Whatsapp</span>
            </a>
        </div>
        <div class="mail-share">
            <a href="mailto:someone@example.com?Subject=Hello&body=" target="_top" class="share-elem-main">
                <span class="mail-btn"><i class="fas fa-envelope marg"></i> Mail</span>
            </a>
        </div>
    </div>

<?php
$this->registercss('
.share-elem-main{display:block;}
.sharing-box{
    border: 1px solid #eee;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 0 10px 0px #eee;
    width:100%;
    background-color:#1d759a;
    margin-bottom:20px;
}
.fb-share, .tw-share, .li-share, .wa-share{
    display:inline-block;
    width:49%;
}
.fb-btn, .li-btn, .tw-btn, .wa-btn, .mail-btn {
    padding: 7px 0;
    width:100%;
    background: #00a0e3;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-family: roboto;
    text-transform: capitalize;
    color: #fff;
    margin-bottom: 10px;
    display: inline-block;
    text-align: center;
}
.fb-btn:hover {
    background-color: #fff;
    color: #1d759a;
}
.li-btn:hover {
    background-color: #fff;
    color: #0077b5;
}
.tw-btn:hover {
    background-color: #fff;
    color: #28aae1;
}
.wa-btn:hover {
    background-color: #fff;
    color: #00e676;
}
.mail-btn:hover {
    background-color: #fff;
    color:#d4483a;
}
.sharing-pic{
    padding-bottom:10px;
    text-align:center;
}
.sharing-pic img{
    width:330px;
    height:180px;
}
.mail-share{
    text-align:center;
}   
@media only screen and (max-width: 768px){
.mail-share{
    display:inline-block;
    width:99%;
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