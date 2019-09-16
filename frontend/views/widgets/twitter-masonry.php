<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="row">
    <?php
    if (!empty($tweets)):
        foreach ($tweets as $tweet) {
            ?>
            <div class="col-md-3 col-sm-6 twitter-cards" data-id="<?= $tweet['application_type'] ?>">
                <div id="twitter_jobs_cards">

                </div>
                <div class="tweet-main">
                    <div class="tweet-inner-main">
                        <div class="tweet-org-deatail">
                            <div class="myBtn">
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
                        </div>
                        <div class="posted-tweet">
                            <?= $tweet['html_code']; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    else:
        ?>
        <div class="no_tweets_found">
            <img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>
        </div>

    <?php
    endif;
    ?>
</div>

<div id="testAdi"></div>
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="row ds-block">
            <div class="col-md-6 col-sm-6">
                hello
            </div>
            <div class="col-md-6 col-sm-6">
                <div id="clickedTweet"></div>
            </div>
        </div>

    </div>


</div>
<?php

$script = <<< JS
$(document).on('load', function() {
    $('#clickedTweet .twitter-tweet').attr('style', 'margin-top: 0px !important');
    // var head = $(".posted-tweet iframe").contents().find("head");
    // var css = '<style type="text/css">' +
    //           '.EmbeddedTweet{border: none !important;border-radius: 0 !important;}; ' +
    //           '</style>';
    // jQuery(head).append(css);
});
JS;
$this->registerJs($script);
$this->registerCss('
.ds-block{
    display:inline;
}
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
   display: inline-block;
    height: 50px;
    width: 50px;
    float: left;
    position: relative;
    border: 1px solid #ddd;
    border-radius: 50%;
    overflow: hidden;
}
.tweet-org-description{
    display:inline-block;
    width: calc(100% - 52px);
    padding-left:10px;
}
.tweet-org-logo img, .tweet-org-logo canvas{
    max-width: 40px;
    max-height: 40px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.tweet-org-logo canvas{
    max-width: 50px !important;
    max-height: 50px !important;
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
twitter-widget[style]{
    position: static;
    visibility: visible;
    display: block;
    transform: rotate(0deg);
    max-width: 100%;
    width: 100% !important;
    min-width: 220px;
    margin-top: 69px;
    margin-bottom: 10px;
}
.EmbeddedTweet{
    max-width:100% !important;
}
.EmbeddedTweet-tweetContainer{
    max-width:100% !important;
}
.myBtn{
    cursor: pointer;
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
   background: #fff;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: none;
  box-shadow:none;
  width: 70%; /* Could be more or less, depending on screen size */
  position:absolute;
  top:50%;
  left:50%;
  transform:translate(-50%, -50%);
}

/* The Close Button */
.close {
  color: #FFF;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
.w-50{
    float:left;
    width:50%;
}

@media screen only and (max-width: 768px){
    
}
');
?>
<script src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script>
    let modal = document.getElementById("myModal");


    let btn = document.querySelectorAll(".myBtn");
    for (let i = 0; i <= btn.length; i++) {
        btn[i].addEventListener('click', function (e) {
            modal.style.display = "block";
            let target = e.target || e.rootElement;
            let cl = target.closest('.tweet-org-deatail').nextElementSibling.querySelector('twitter-widget').getAttribute('data-tweet-id');
            twttr.widgets.createTweet(
                cl,
                document.getElementById('clickedTweet'),
            )
        });
        let span = document.getElementsByClassName("close")[0];
        span.onclick = function () {
            modal.style.display = "none";
            document.getElementById('clickedTweet').innerHTML = null
        };

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
                document.getElementById('clickedTweet').innerHTML = null

            }
        }

    }
</script>
