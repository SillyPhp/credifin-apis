<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['header_dark'] = true;

?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="video-box-main dash-inner-box nd-shadow">
                        <!--                    <div class="rec-batch">Recommended</div>-->
                        <div class="vid-box">
                            <?php if ($detail['content_type'] == 'Video') { ?>
                                <iframe width="560" height="315"
                                        src="https://www.youtube.com/embed/<?= $detail['youtube_video_id'] ?>"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                            <?php } elseif ($detail['content_type'] == 'Podcast') { ?>
                                <?= $detail['embed_code'] ?>
                            <?php } else { ?>
                                <?php if ($detail['post_image_url']) { ?>
                                    <img src="<?= $detail['post_image_url'] ?>"
                                         alt="your image" class="target"/>
                                <?php } else { ?>
                                    <img src="<?= $detail['cover_image'] ?>"
                                         alt="your image" class="target"/>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <h3><?= $detail['post_title'] ?></h3>
                        <div class="author-s margin-top-10">
                            <div class="author list-data"><i
                                        class="fas fa-user"></i><span> <?= $detail['author_name'] ?> </span></div>
                            <div class="source"><i class="fas fa-link"></i><span> <?= $detail['source_name'] ?> </span>
                            </div>
                        </div>
                        <div class="tags-list">
                            <h5 class="tag-title">Related Topic</h5> :-
                            <?php foreach ($detail['skillsUpPostAssignedSkills'] as $s) { ?>
                                <span><?= $s['skill'] ?></span>
                            <?php } ?>
                        </div>
                        <div class="vid-content">
                            <?= $detail['post_description'] ?>
                        </div>
                        <div class="original-art">
                            <a href="<?= $detail['post_source_url'] ?>"
                               target="_blank">ORIGINAL <?= $detail['content_type'] ?></a>
                        </div>
                        <div class="share-social-links">
                            <a href="javascript:;" class="fb"
                               onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-facebook-f"></i></a>
                            <a href="javascript:;" class="wts-app"
                               onclick="window.open('https://api.whatsapp.com/send?text=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-whatsapp"></i></a>
                            <a href="javascript:;" class="tw"
                               onclick="window.open('https://twitter.com/intent/tweet?text=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-twitter"></i></a>
                            <a :href="'mailto:https://myecampus.in'+this.$route.fullPath" class="male">
                                <i class="far fa-envelope"></i></a>
                            <a href="javascript:;" class="fb"
                               onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&amp;url=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-linkedin"></i></a>
                            <a href="javascript:;" class="male"
                               onclick="window.open('http://pinterest.com/pin/create/link/?url=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-pinterest"></i></a>
                            <a href="javascript:;" class="tw"
                               onclick="window.open('https://telegram.me/share/url?url=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                                <i class="fab fa-telegram"></i></a>
                        </div>
                        <div class="discussion-box">
                            <h3>Comments</h3>
                            <div>
                                <textarea class="form-control"></textarea>
                                <div class="text-right">
                                    <button class="cmnt-btn disabled">Comment</button>
                                </div>
                            </div>
                        </div>
                        <div class="show-comment">
                            <ul id="skill-up-comments-list" class="comments-list comments-main">

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="live-chat dash-inner-box nd-shadow">
                        <h3>Chatting</h3>
                        <div id="skillup-chat-main" class="chatting-live">

                        </div>
                        <div class="input-chat">
                            <textarea type="text" class="form-control"></textarea>
                            <a href="javascript:;" class="disabled">Send</a>
                        </div>
                    </div>
                    <div class="related-art dash-inner-box nd-shadow">
                        <h3>Related Articles</h3>
                        <?php foreach ($related_posts as $post) { ?>
                            <a href="<?= Url::to('/skills-up/detail/' . $post['slug']) ?>" class="relate-box">
                                <div class="relate-icon">
                                    <img src="<?= $post['post_image_url'] ? $post['post_image_url'] : $post['cover_image'] ?>"
                                         alt="your image" class="target"/>
                                </div>
                                <div class="relate-name">
                                    <p><?= $post['post_title'] ?></p>
                                    <div class="author-relate">
                                        <div class="source"><i
                                                    class="fas fa-link"></i><Span><?= $post['source_name'] ?></Span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.input-chat textarea {
    height: 45px;
    padding-right: 50px;
}
.video-box-main {
        padding: 20px;
        margin-bottom: 20px;
        position: relative;
    }
.nd-shadow {
    box-shadow: 0px 1px 10px 2px #eee !important;
}
    .rec-batch {
        position: absolute;
        right: 25px;
        top: 25px;
        background-color: #fff;
        padding: 5px 8px;
        font-family: roboto;
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 500;
    }

    .vid-box img {
        width: 100%;
        height: 100%;
        max-height: 450px;
        object-fit: cover;
    }

    .video-box-main h3 {
        font-size: 22px;
        font-family: roboto;
        margin-top: 20px;
    }

    .author-s {
        display: flex;
        align-items: center;
        font-family: roboto;
    }

    .author, .source {
        margin-right: 10px;
        color: #fff;
        padding: 4px 8px;
        margin-bottom: 10px;
        font-family: Roboto;
        font-size: 12px;
    }

    .author {
        background-color: #00a0e3;
    }

    .source {
        background-color: #ff7803;
        flex: none;
    }

    .vid-content {
        font-size: 14px;
        text-align: justify;
        line-height: 22px;
        font-family: roboto;
    }

    .original-art a {
        background-color: #00a0e3;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        padding: 10px 16px;
        display: inline-block;
        font-family: roboto;
        font-weight: 500;
        margin: 15px 5px 0 0;
        text-transform: uppercase;
    }

    .share-social-links {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        flex-wrap: wrap;
    }

    .share-social-links > a {
        min-width:90px ;
        margin: 15px 1% 0 0;
    }

    .share-social-links > a:last-child {
        margin-right: 0;
    }

    .wts-app {
        background-color: #25D366;
    }

    .male {
        background-color: #d3252b;
    }

    .tw {
        background-color: #1c99e9;
    }

    .fb {
        background-color: #236dce;
    }

    .wts-app i, .male i, .tw i, .fb i {
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        width: 100%;
        text-align: center;
        padding: 10px 0;
    }

    .discussion-box textarea {
        padding: 10px;
        font-family: roboto;
    }

    .cmnt-btn {
        color: #fff;
        background-color: #00a0e3;
        border: none;
        font-family: roboto;
        font-size: 14px;
        font-weight: 500;
        padding: 8px 15px;
        margin: 10px 0 0;
        display: inline-block;
        width: 100px;
    }

    .show-comment {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        align-items: center;
        margin: 20px 0;
    }

    .user-p {
        width: 60px;
        height: 60px;
        margin-right: 20px;
    }

    .user-p img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-name-c {
        border-left: 2px solid #eee;
        padding-left: 20px;
        font-family: roboto;
        flex-basis: 75%;
        text-align: justify;
    }

    .user-name-c h3 {
        font-size: 22px;
        margin-top: 0px !important;
    }

    .reply-comment {
        flex-basis: 10%;
        text-align: center;
    }

    .reply-comment button {
        color: #ff7803;
        background-color: #fff;
        border: none;
        font-family: roboto;
    }

    .live-chat {
        height: 515px;
        position: relative;
        overflow: hidden;
    }
    .chatting-live{
        height: 365px;
        position:relative;
        overflow: hidden;
    }

    .input-chat {
        position: absolute;
        width: 100%;
        bottom: 0;
        right: 0;
    }

    .input-chat a {
        position: absolute;
        right: 0;
        top: 0;
        background-color: #00a0e3;
        padding: 12px 18px;
        color: #fff;
        font-family: roboto;
        font-weight: 500;
    }

    .related-art, .live-chat {
        padding: 20px;
        margin-bottom: 20px;
    }

    .related-art h3, .live-chat h3 {
        margin: 0;
        margin-bottom: 20px;
        color: #00a0e3;
        font-family: roboto;
        font-size: 22px;
    }

    .relate-box {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .relate-box:last-child {
        margin-bottom: 0;
    }

    .relate-icon {
        width: 90px;
        height: 90px;
        margin-right: 10px;
    }

    .relate-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        min-width: 90px;
    }

    .relate-name p {
        font-size: 14px;
        font-family: roboto;
        line-height: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 5px;
        cursor: pointer;
    }

    .author-relate {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-wrap: wrap;
    }

    .author-relate span {
        margin-right: 10px;
    }

    .save-later {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dis-none {
        opacity: 0;
        transition: ease-in-out .3s;
    }

    .relate-box:hover .dis-none {
        opacity: 1;
    }
    .author-relate >div{
        margin-bottom: 5px;
    }
    .like-btn {
      color: #00a0e3;
      font-size: 20px;
    }

    .like-btn.default{
      color: #aaa;
    }
    #chat-value{
       width: calc(100% - 70px);
    }
    .tags-list span{
        background-color: #eee;
        padding: 7px 15px;
        border-radius: 15px;
        margin: 0px 5px;
    }
    .tag-title{
        display: inline-block;
        color: #00a0e3;
        font-weight: 550;
        font-size: 18px;
    }
    .margin-top-10{
        margin-top: 10px;
    }
    .share-social-links:hover a {
        opacity: 0.6;
    }
    .share-social-links > a:hover {
        opacity: 1;
    }
');
