<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
    <div class="row">
        <?php
        if (!empty($tweets)):
            ?>
            <div class="masonry">
                <div id="twitter_jobs_cards">

                </div>
                <?php

                foreach ($tweets as $tweet) {
                    ?>
                    <div class="tweet-main">
                        <div class="tweet-inner-main">
                            <div class="tweet-org-deatail">
                                <div class="tweet-org-logo">
                                    <?php if (!empty($tweet['logo'])): ?>
                                        <img src="<?= $tweet['logo'] ?>"/>
                                    <?php else: ?>
                                        <canvas class="user-icon" name="<?= $tweet['org_name'] ?>" width="150"
                                                height="150"
                                                color="<?= $tweet['color'] ?>" font="70px"></canvas>
                                    <?php endif; ?>
                                </div>
                                <div class="tweet-org-description">
                                    <h2><?= ucwords($tweet['job_title']) ?></h2>
                                    <h4><?= ucwords($tweet['org_name']) ?></h4>
                                    <p><?= $tweet['job_type'] ?></p>
                                </div>
                            </div>
                            <div class="posted-tweet">
                                <?= $tweet['html_code']; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        <?php
        else:
            ?>
            <div class="no_tweets_found">
                <img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>
            </div>

        <?php
        endif;
        ?>
    </div>
<?php
$script = <<< JS
$(window).on('load', function() {
    var head = $(".posted-tweet iframe").contents().find("head");
    var css = '<style type="text/css">' +
              '.EmbeddedTweet{border: none !important;border-radius: 0 !important;}; ' +
              '</style>';
    jQuery(head).append(css);
});
JS;
$this->registerJs($script);
$this->registerCss('
.masonry { 
    -webkit-column-count: 4;
  -moz-column-count:4;
  column-count: 4;
  -webkit-column-gap: 1em;
  -moz-column-gap: 1em;
  column-gap: 1em;
   margin: 1.5em;
    padding: 0;
    -moz-column-gap: 1.5em;
    -webkit-column-gap: 1.5em;
    column-gap: 1.5em;
    font-size: .85em;
}
.tweet-main{
     display: inline-block;
    background: #fff;
    width: 100%;
	-webkit-transition:1s ease all;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    margin-bottom: 20px;
}
.tweet-org-deatail{
    width:100%;
    position:relative;
    float:left;
    background-color: #fff;
    padding: 10px 10px 0px;
    border-bottom: 1px solid #e8e8e8;
}
.tweet-org-logo{
    display:inline-block;
    max-width:50px;
    float:left;
}
.tweet-org-description{
    display:inline-block;
    width: calc(100% - 52px);
    padding-left:10px;
}
.tweet-org-logo img, .tweet-org-logo canvas{
    width:100%;
    height:100%;
    border-radius:50%;
    border:1px solid #ddd;
    margin-top: 3px;
}
.tweet-org-description *{
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    font-family: Roboto;
}
.tweet-org-description h4{
    font-size: 12.5px;
    font-weight: 400;
    color: #222;
    margin: 0px;
    line-height: 14px;
}
.tweet-org-description h2{
    font-size: 16px;
    font-weight: 500;
    color: #222;
    margin: 0px 0px;
}
.tweet-org-description p{
    color: #777;
    font-size: 13px;
    margin: 0px;
    line-height: 16px;
    font-weight: 400;
}
.tweet-inner-main{
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0px 2px 10px 2px #eaeaea;
}

');
?>
