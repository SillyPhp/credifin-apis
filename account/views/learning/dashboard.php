<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
?>
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
<!--                    <a href="" class="viewall-jobs">--><?//= Yii::t('account', 'Add New'); ?><!--</a>-->

                </div>
            </div>
            <div class="portlet-body">

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
                    <a href="" class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                    <?php if ($applications['total'] > 8): ?>
                        <a href="" title="" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="video-container2">
                        <a href="/learning/video-detail?vidk={{slug}}">
                            <div class="video-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                            </div>
                            <div class="r-video2">
                                <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                            </div>
                        </a>
                    </div>
                </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="video-container2">
                            <a href="/learning/video-detail?vidk={{slug}}">
                                <div class="video-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                                </div>
                                <div class="r-video2">
                                    <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="video-container2">
                            <a href="/learning/video-detail?vidk={{slug}}">
                                <div class="video-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                                </div>
                                <div class="r-video2">
                                    <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="video-container2">
                            <a href="/learning/video-detail?vidk={{slug}}">
                                <div class="video-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                                </div>
                                <div class="r-video2">
                                    <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="video-container2">
                            <a href="/learning/video-detail?vidk={{slug}}">
                                <div class="video-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                                </div>
                                <div class="r-video2">
                                    <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="video-container2">
                            <a href="/learning/video-detail?vidk={{slug}}">
                                <div class="video-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                                </div>
                                <div class="r-video2">
                                    <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="video-container2">
                            <a href="/learning/video-detail?vidk={{slug}}">
                                <div class="video-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                                </div>
                                <div class="r-video2">
                                    <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="video-container2">
                            <a href="/learning/video-detail?vidk={{slug}}">
                                <div class="video-icon2">
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                                </div>
                                <div class="r-video2">
                                    <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                </div>
                            </a>
                        </div>
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
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'My Playlists'); ?></span>
                </div>
                <div class="actions">
                    <a href="" class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                    <?php if ($applications['total'] > 8): ?>
                        <a href="" title="" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="video-container2">
                        <a href="/learning/video-detail?vidk={{slug}}">
                            <div class="video-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                                <div class="overlay">
                                    <div class="text">15 Videos</div>
                                </div>
                            </div>
                            <div class="r-video2">
                                <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                <div class="t-videos">15 Videos</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="video-container2">
                        <a href="/learning/video-detail?vidk={{slug}}">
                            <div class="video-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                                <div class="overlay">
                                    <div class="text">15 Videos</div>
                                </div>
                            </div>
                            <div class="r-video2">
                                <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                <div class="t-videos">15 Videos</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="video-container2">
                        <a href="/learning/video-detail?vidk={{slug}}">
                            <div class="video-icon2">
                                <img src="<?= Url::to('@eyAssets/images/pages/candidates-list/video.png') ?>" alt="Cover Image">
                                <div class="overlay">
                                    <div class="text">15 Videos</div>
                                </div>
                            </div>
                            <div class="r-video2">
                                <div class="r-v-name">Lorem Ipsum is simply dummy text</div>
                                <div class="t-videos">15 Videos</div>
                            </div>
                        </a>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss('
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
');
