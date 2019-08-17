<?php
//$this->params['grid_size'] = 'col-md-12';
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['header_dark'] = true;
//$this->params['background_image'] = '/assets/themes/ey/images/backgrounds/vector-form-job.png';
?>
<div id="loading_img">
</div>
<section class="head-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="search-box">
                    <form id="form-search" action="<?= Url::to(['search']) ?>">
                        <div class="input-group search-bar">
                            <input type="text" id="search_company" class="form-control"
                                   placeholder="Search #tweets"
                                   name="keywords">
                            <div class="input-group-btn">
                                <button class="loader_btn_search"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="twitter_jobs_cards">

                </div>
                <?php
                foreach ($tweets as $tweet) {
                    ?>
                    <div class="col-md-3 tweet-main">
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
                                    <h4><?= ucwords($tweet['org_name']) ?></h4>
                                    <h2><?= ucwords($tweet['job_title']) . ',' . $tweet['profile'] ?></h2>
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
        </div>
    </div>
</section>
<?php
//echo $this->render('/widgets/twitter-jobs');
$this->registerCss("
body{
    background:url('" . Url::to('@eyAssets/images/backgrounds/p6.png') . "');
}
.posted-tweet iframe{width:100% !important;margin-bottom:0px !important;}
.head-bg{
    background-color:#00a0e3;
    padding:50px 0px;
}
.search-box{
    width: 100%;
    max-width: 650px;
    margin: auto;
}
#form-search .search-bar{
    border-radius: 18px;
    overflow: hidden;
}
#form-search .search-bar input{
    border: 0px;
}
.tweet-main{
    padding: 0px 8px;
}
#form-search{
    margin-bottom:55px;
}
.search-bar button {
    padding: 13px 19px 12px 16px;
    border: none;
    background: #fff;
    color: #999;
    }
.search-bar
{
box-shadow:4px 6px 20px rgba(73, 72, 72, 0.5);
border: 1px solid #ddd;
    background: #fff;
}
#main_cnt
{
margin-top:20px
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
//.posted-tweet iframe .EmbeddedTweet{
//    border: none !important;
//    border-radius: 0 !important;
//}
#load_me
{
//display:none;
}

#loading_img
{
  display:none;
}

#loading_img.show
{
display : block;
position : fixed;
z-index: 100;
background-image : url('/assets/themes/ey/images/loader/5.gif');
opacity : 1;
background-repeat : no-repeat;
background-position : center;
width:60%;
height:60%;
left : 20%;
bottom : 0;
right : 0;
top : 20%;
}

");
$script = <<< JS
//$('#loading_img').addClass('show');
$(window).on('load', function() {
    var head = $(".posted-tweet iframe").contents().find("head");
    console.log(head);
    var css = '<style type="text/css">' +
              '.EmbeddedTweet{border: none !important;border-radius: 0 !important;}; ' +
              '</style>';
    jQuery(head).append(css);
});
JS;
$this->registerJs($script);
//$this->registerJs("
//$(document).ready(function(){
//    var head = $('.posted-tweet iframe').contents().find('head');
//    console.log(head);
//    var css = '<style type=\"text/css\">' +
//              '.EmbeddedTweet{border: none !important;border-radius: 0 !important;}; ' +
//              '</style>';
//    jQuery(head).append(css);
//});
//",[]);
$this->registerJsFile("https://platform.twitter.com/widgets.js", ['position' => \yii\web\View::POS_HEAD]);
?>
