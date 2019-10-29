<?php
$this->params['header_dark'] = true;

use yii\helpers\Url;

?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="cb-blog-box">
                            <div class="cb-blog-icon">
                                <img src="<?= $careerDetail['image'] ?>" alt="">
                            </div>
                            <div class="cb-blog-title">
                                <?= $careerDetail['title'] ?>
                            </div>
                            <div class="cb-blob-web-name">
                                <a href="<?= $careerDetail['link'] ?>">View Source</a>
                            </div>
                            <div class="cb-blog-time"><?= date('d-M-Y',strtotime($careerDetail['created_on'])) ?></div>
                            <div class="cb-quick-sum-heading">
                                Quick Summary
                            </div>
                            <div class="cb-quick-summery">
                                <?= $careerDetail['description'] ?>
                            </div>
                            <div class="cb-ori-artical-link">
                                <a href="<?= $careerDetail['link'] ?>">Read orignal Article</a>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <//= $this->render('/widgets/career-pole-widget') >-->
                <?=
                $this->render('/widgets/mustache/discussion/discussion-box', [
                    "controllerId" => Yii::$app->controller->id . "/comments"
                ]);
                ?>
            </div>
            <div class="col-md-4">
                <?=
                $this->render('/widgets/subscribe-newsletter',[
                    'subscribersForm' => $newsletterForm
                ]);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="related-heading">Related Articles</div>
                    </div>
                    <?php
                    foreach ($relatedArticles as $r) {
                        ?>

                        <div class="col-md-12">
                            <div class="cb-blog-box cb-blog-box-small">
                                <div class="cb-blog-icon">
                                    <img src="<?= $r['image'] ?>" alt="">
                                </div>
                                <div class="cb-blog-title cb-blog-title-small">
                                    <?= $r['title'] ?>
                                </div>
                                <div class="cb-blog-time"><?= date('d-M-Y',strtotime($r['created_on'])) ?></div>
                                <div class="cb-blob-web-name cb-blob-web-name-small">
                                    <a href="">Read Article</a>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<input type="hidden" value="<?= Yii::$app->user->identity->user_enc_id; ?>" id="user_id">

<?php
$this->registerCss('
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
    font-size:18px;
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
    margin-top:25px;
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
');
?>
