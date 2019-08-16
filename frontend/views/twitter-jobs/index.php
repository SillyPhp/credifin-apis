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
<div class="container">
    <div id="main_cnt">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <section class="head-bg">
                    <div class="overlay-bg"></div>
                    <div class="pos-relative">
                        <div class="header-bg">
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
                </section>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="twitter_jobs_cards">

                </div>
                <?php
                foreach ($tweets as $tweet){
                    ?>
                    <div class="col-md-3">
                        <div class="tweet-org-deatail">
                            <div class="tweet-org-logo">
                                <?php if (!empty($tweet['logo'])): ?>
                                    <img src="<?= $tweet['logo'] ?>"/>
                                <?php else: ?>
                                    <canvas class="user-icon" name="<?= $tweet['org_name'] ?>" width="150" height="150"
                                            color="<?= $tweet['color'] ?>" font="55px"></canvas>
                                <?php endif; ?>
                            </div>
                            <div class="tweet-org-description">
                                <h4><?= ucwords($tweet['org_name']) ?></h4>
                                <h2><?= ucwords($tweet['job_title']).','.$tweet['profile'] ?></h2>
                                <p><?= $tweet['job_type'] ?></p>
                            </div>
                        </div>
                        <div class="posted-tweet">
                            <?= $tweet['html_code']; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
//echo $this->render('/widgets/twitter-jobs');
$this->registerCss(" 
#form-search
{
margin-bottom:55px;
}
.main-content
{
    background-color: #f0f0f1;
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
JS;
$this->registerJs($script);
$this->registerJsFile("https://platform.twitter.com/widgets.js",['position'=>\yii\web\View::POS_HEAD]);
?>
