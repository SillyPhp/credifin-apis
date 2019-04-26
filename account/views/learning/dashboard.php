<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<div class="row" id="removeBtn">
    <div class="youtube">
        <button class="viewall-jobs" id="connectBtn"><i class="fa fa-youtube-play"></i> Connect your YouTube Account
        </button>
    </div>
</div>
<div id="channel-info">
    <div class="row">
        <div class="widget-row">
            <div class="col-md-3">
                <a href="">
                    <div class="internships_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                        <h4 class="widget-thumb-heading">Total Videos</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-building-o"></i>
                            <div class="widget-thumb-body">
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                          data-value="">00</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="">
                    <div class="internships_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                        <h4 class="widget-thumb-heading">Total Video Views</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-building-o"></i>
                            <div class="widget-thumb-body">
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                          data-value="">00</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="">
                    <div class="internships_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                        <h4 class="widget-thumb-heading">Total Comments</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-building-o"></i>
                            <div class="widget-thumb-body">
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                          data-value="">00</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="">
                    <div class="internships_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                        <h4 class="widget-thumb-heading">Total Playlists</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-building-o"></i>
                            <div class="widget-thumb-body">
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                          data-value="">00</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="">
                    <div class="internships_count widget-thumb widget-bg-color-white text-uppercase margin-bottom-20">
                        <h4 class="widget-thumb-heading">Total Subscriber</h4>
                        <div class="widget-thumb-wrap">
                            <i class="widget-thumb-icon bg-green fa fa-building-o"></i>
                            <div class="widget-thumb-body">
                    <span class="widget-thumb-body-stat" data-counter="counterup"
                          data-value="">00</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'My Channel'); ?></span>
                    </div>
                    <div class="actions">
                        <!--                    <a href="" class="viewall-jobs">-->
                        <? //= Yii::t('account', 'Add New'); ?><!--</a>-->

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="channel-icon">
                                <img src="<?= Url::to('@commonAssets/logos/logo.svg') ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="channel-name">Empower Youth</div>
                            <div class="channel-cate"><span>Categoery:-</span> Information Technology</div>
                            <div class="channel-cate"><span>Subscribers:-</span> 1000</div>
                            <div class="channel-cate"><span>Videos:-</span> 100</div>
                            <div class="channel-cate"><span>Playlists:-</span> 10</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'My Videos'); ?></span>
                    </div>
                    <div class="actions">
                        <button id="showVideo" class="viewall-jobs"><?= Yii::t('account', 'Show In Learning'); ?></button>
                        <button id="canVideo" class="viewall-jobs"><?= Yii::t('account', 'Cancel'); ?></button>
                        <?php if ($applications['total'] > 8): ?>
                            <a href="" title="" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <form>
                        <div class="col-xs-4 col-sm-3 col-md-3 text-center">
                            <input type="checkbox" id="11" class="c-learning" name="videos" value=""/>
                            <label for="11" class="image-checkbox">
                                <div class="video-container2">
                                    <!--                                <a href="/learning/video-detail?vidk={{slug}}">-->
                                    <div class="video-icon2">
                                        <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>"
                                             alt="Cover Image">
                                    </div>
                                    <div class="r-video2">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                    </div>
                                    <!--                                </a>-->
                                </div>
                                <div class="chk">
                                    <i class="fa fa-check"></i>
                                </div>
                                <i class="fa fa-check hidden"></i>
                            </label>
                        </div>
                        <div class="col-xs-4 col-sm-3 col-md-3 text-center">
                            <input type="checkbox" id="22" class="c-learning" name="videos" value=""/>
                            <label for="22" class="image-checkbox">
                                <div class="video-container2">
                                    <!--                                <a href="/learning/video-detail?vidk={{slug}}">-->
                                    <div class="video-icon2">
                                        <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>"
                                             alt="Cover Image">
                                    </div>
                                    <div class="r-video2">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                    </div>
                                    <!--                                </a>-->
                                </div>
                                <div class="chk">
                                    <i class="fa fa-check"></i>
                                </div>
                                <i class="fa fa-check hidden"></i>
                            </label>
                        </div>
                        <div class="col-xs-4 col-sm-3 col-md-3 text-center">
                            <input type="checkbox" id="33" class="c-learning" name="videos" value=""/>
                            <label for="33" class="image-checkbox">
                                <div class="video-container2">
                                    <!--                                <a href="/learning/video-detail?vidk={{slug}}">-->
                                    <div class="video-icon2">
                                        <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>"
                                             alt="Cover Image">
                                    </div>
                                    <div class="r-video2">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                    </div>
                                    <!--                                </a>-->
                                </div>
                                <div class="chk">
                                    <i class="fa fa-check"></i>
                                </div>
                                <i class="fa fa-check hidden"></i>
                            </label>
                        </div>
                        <div class="col-xs-4 col-sm-3 col-md-3 text-center">
                            <input type="checkbox" id="4" class="c-learning" name="videos" value=""/>
                            <label class="image-checkbox" for="4">
                                <div class="video-container2">
                                    <!--                                <a href="/learning/video-detail?vidk={{slug}}">-->
                                    <div class="video-icon2">
                                        <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>"
                                             alt="Cover Image">
                                    </div>
                                    <div class="r-video2">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                    </div>
                                    <!--                                </a>-->
                                </div>
                                <div class="chk">
                                    <i class="fa fa-check"></i>
                                </div>
                                <i class="fa fa-check hidden"></i>
                            </label>
                        </div>
                            <div class="sub-video-btn">
                                <button id="saveVideo" class="viewall-jobs">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'My Playlists'); ?></span>
                    </div>
                    <div class="actions">
                        <button id="showPlay" class="viewall-jobs"><?= Yii::t('account', 'Show In Learning'); ?></button>
                        <button id="canPlay" class="viewall-jobs"><?= Yii::t('account', 'Cancel'); ?></button>
                        <?php if ($applications['total'] > 8): ?>
                            <a href="" title="" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <form>
                        <div class="col-xs-4 col-sm-3 col-md-3 text-center">
                            <input type="checkbox" id="p1" class="c-learning" name="videos" value=""/>
                            <label class="image-checkbox" for="p1">
                                <div class="video-container2">
                                    <!--                        <a href="/learning/video-detail?vidk={{slug}}">-->
                                    <div class="video-icon2">
                                        <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>"
                                             alt="Cover Image">
                                        <div class="overlay">
                                            <div class="text">15 Videos</div>
                                        </div>
                                    </div>
                                    <div class="r-video2">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                        <div class="t-videos">15 Videos</div>
                                    </div>
                                    <!--                        </a>-->
                                </div>
                                <div class="chk1">
                                    <i class="fa fa-check"></i>
                                </div>
                            </label>
                        </div>
                        <div class="col-xs-4 col-sm-3 col-md-3 text-center">
                            <input type="checkbox" id="p2" class="c-learning" name="videos" value=""/>
                            <label class="image-checkbox" for="p2">
                                <div class="video-container2">
                                    <!--                        <a href="/learning/video-detail?vidk={{slug}}">-->
                                    <div class="video-icon2">
                                        <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>"
                                             alt="Cover Image">
                                        <div class="overlay">
                                            <div class="text">15 Videos</div>
                                        </div>
                                    </div>
                                    <div class="r-video2">
                                        <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                        <div class="t-videos">15 Videos</div>
                                    </div>
                                    <!--                        </a>-->
                                </div>
                                <div class="chk1">
                                    <i class="fa fa-check"></i>
                                </div>
                            </label>
                        </div>
                        <div class="col-xs-4 col-sm-3 col-md-3 text-center">
                            <input type="checkbox" id="p3" class="c-learning" name="videos" value=""/>
                            <label class="image-checkbox" for="p3">
                                <div class="video-container2">
<!--                                    <a href="/learning/video-detail?vidk={{slug}}">-->
                                        <div class="video-icon2">
                                            <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>"
                                                 alt="Cover Image">
                                            <div class="overlay">
                                                <div class="text">15 Videos</div>
                                            </div>
                                        </div>
                                        <div class="r-video2">
                                            <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                            <div class="t-videos">15 Videos</div>
                                        </div>
<!--                                    </a>-->
                                </div>
                                <div class="chk1">
                                    <i class="fa fa-check"></i>
                                </div>
                            </label>
                        </div>
                        <div class="col-xs-4 col-sm-3 col-md-3 text-center">
                            <input type="checkbox" id="p4" class="c-learning" name="videos" value=""/>
                            <label class="image-checkbox" for="p4">
                                <div class="video-container2">
<!--                                    <a href="/learning/video-detail?vidk={{slug}}">-->
                                        <div class="video-icon2">
                                            <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>"
                                                 alt="Cover Image">
                                            <div class="overlay">
                                                <div class="text">15 Videos</div>
                                            </div>
                                        </div>
                                        <div class="r-video2">
                                            <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                            <div class="t-videos">15 Videos</div>
                                        </div>
<!--                                    </a>-->
                                </div>
                                <div class="chk1">
                                    <i class="fa fa-check"></i>
                                </div>
                            </label>
                        </div>
                            <div class="sub-btn">
                                <button id="savePlay" class="viewall-jobs">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
.sub-btn, .sub-video-btn{
    position: absolute;
    top:18px;
    right:110px;
}
.sub-btn button, .sub-video-btn button{
    border:none;
}
/*image gallery*/
.image-checkbox {
	cursor: pointer;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	border: 4px solid transparent;
	margin-bottom: 0;
	outline: 0;
	position:relative;
}
.c-learning{
	display: none;
}
.c-learning:checked ~ label .chk .fa, .c-learning:checked ~ label .chk1 .fa {
    opacity: 1;
}
.chk, .chk1{
  position: absolute;
  color: #4A79A3;
  background-color: #fff;
  padding: 10px;
  top: 0;
  right: 0;
  border-radius: 0 10px;
  display:none;
}
.image-checkbox-checked {
	border-color: #4783B0;
}
.chk .fa, .chk1 .fa {
    opacity:0;
}

.image-checkbox-checked .fa {
  display: block !important;
}
#canPlay{
    display:none;
}
#canVideo{
    display:none;
}
#channel-info{
    display:none;
}
#savePlay{
    display:none;
}
#saveVideo{
    display:none;
}
.youtube{
    text-align:center;
    position:relative;
    height:325px;
}
.youtube button{
    border:none;
    float: none;
    margin: 0 auto;
    background:#FF0000 !important;
    position:absolute;
    font-size:16px;
    font-weight:bold;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
}
.youtube button i{
    font-size:16px;
}
.video-container2{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:300px;
    background:#fff;
    position:relative;
    margin-bottom:20px;
}
.video-icon2{
    width:100%;
    height:200px;
    overflow:hidden;
    object-fit:cover;
    position:relative;
}
.video-icon2 img{
    border-radius:10px 10px 0 0;
    object-fit:cover;
    width:100%;
    height:200px;
    
}
.r-video2{
    padding:5px 10px 10px 10px;
    background:#fff;
}
.r-v-name{
    font-size:14px;
    font-weight:bold;
}
.t-videos{
    position:absolute;
    bottom:5px;
    left:10px;
}

.overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
//  background-color: rgba(0, 160, 227, .5);
  background-color: rgba(255, 255, 255, .4);
  overflow: hidden;
  width: 100%;
  height: 0;
  transition: .5s ease;
  border-radius:10px 10px 0 0;
}

.video-container2:hover .overlay {
  height: 100%;
}

.text {
  color: #000;
  font-size: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  text-align: center;
}
.channel-icon{
    height:150px;
    border:1px solid #eee;
//    box-shadow:0 0 10px rgba(0,0,0,.1);
    position:relative;
    border-radius:10px;
}
.channel-icon img{
    position:absolute;
    top:50%;
    left:50%;
    max-width:150px;
    transform:translate(-50%, -50%);
}
.channel-name{
    font-size:20px;
    font-weight:bold;
    padding-top:10px;
}
.channel-cate{
    font-size:14px
    padding-top:10px;
}
.channel-cate span{
    font-weight:bold;
}
.actions button{
    border:none;
}
');

$script = <<<JS



JS;
$this->registerJs($script);
?>
<script>
    document.getElementById('connectBtn').addEventListener('click', function () {
        document.getElementById('channel-info').style.display = "block";
        document.getElementById('removeBtn').remove();
    });

    var chk = document.getElementsByClassName('chk');
    document.getElementById('showVideo').addEventListener("click", function () {
        for (i = 0; i < chk.length; i++) {
            chk[i].style.display = "block";
        }
        document.getElementById('showVideo').style.display = "none";
        document.getElementById('canVideo').style.display = "block";
        document.getElementById('saveVideo').style.display = "block";
    });
    document.getElementById('canVideo').addEventListener("click", function () {
        for (i = 0; i < chk.length; i++) {
            chk[i].style.display = "none";
        }
        document.getElementById('showVideo').style.display = "block";
        document.getElementById('canVideo').style.display = "none";
        document.getElementById('saveVideo').style.display = "none";
    });


    var chk1 = document.getElementsByClassName('chk1');
    document.getElementById('showPlay').addEventListener("click", function () {
        for (i = 0; i < chk1.length; i++) {
            chk1[i].style.display = "block";
        }
        document.getElementById('showPlay').style.display = "none";
        document.getElementById('canPlay').style.display = "block";
        document.getElementById('savePlay').style.display = "block";
    });
    document.getElementById('canPlay').addEventListener("click", function () {
        for (i = 0; i < chk1.length; i++) {
            chk1[i].style.display = "none";
        }
        document.getElementById('showPlay').style.display = "block";
        document.getElementById('canPlay').style.display = "none";
        document.getElementById('savePlay').style.display = "none";
    });

</script>
