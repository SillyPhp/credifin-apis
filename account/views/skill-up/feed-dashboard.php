<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <section class="statistics">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3 col-sm-4">
                    <div class="box nd-shadow clr1">
                        <i class="fa fa-video-camera"></i>
                        <div class="info">
                            <p>Total Videos</p>
                            <h3><?= $counts['video'] ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="box nd-shadow clr2">
                        <i class="fa fa-newspaper-o"></i>
                        <div class="info">
                            <p>Total News</p>
                            <h3><?= $counts['news'] ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="box nd-shadow clr3">
                        <i class="fa fa-window-restore" aria-hidden="true"></i>
                        <div class="info">
                            <p>Total Articles</p>
                            <h3><?= $counts['article'] ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="box nd-shadow clr4">
                        <i class="fa fa-align-justify"></i>
                        <div class="info">
                            <p>Total Courses</p>
                            <h3><?= $counts['course'] ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="box nd-shadow clr5">
                        <i class="fa fa-volume-up"></i>
                        <div class="info">
                            <p>Total Podcast</p>
                            <h3><?= $counts['podcast'] ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="box nd-shadow clr6">
                        <i class="fa fa-rss" aria-hidden="true"></i>
                        <div class="info">
                            <p>Total Blogs</p>
                            <h3><?= $counts['blog'] ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?= $this->render('/widgets/skill-up/my-contributions',[

])?>

<?php
$this->registerCss('
.clr1{
    background-image: linear-gradient(to top left, #70c6ea, #06729f);
}
.clr2{
    background-image: linear-gradient(to top left, #ffbb80, #ff7803);
}
.clr3{
    background-image: linear-gradient(to top left, #d5dfa2, #28838c);
}
.clr4{
    background: linear-gradient(145deg, #c23465,#4c0e50);
}
.clr5{
    background: linear-gradient(145deg, #1e21f4, #43c7f0);
}
.clr6{
    background: linear-gradient(145deg, #3cc4a4, #43f0d0);
}
.statistics {
    margin-top: 25px;
    font-family: Roboto;
}
.statistics .box {
    padding: 30px;
    overflow: hidden;
    margin-bottom:25px;
    position:relative;
    color:#fff;
}
.box i {
    position: absolute;
    right: 20px;
    font-size: 40px;
    top: 50%;
}
.statistics .box .info h3 {
    margin: 5px 0 5px;
    display: inline-block;
    font-family: Roboto;
    font-weight: 500;
}
.statistics .box .info p {
    margin: 0 0 5px;
    font-family: roboto;
    font-weight: 500;
}
');
$script = <<<JS
feeds();
JS;
$this->registerJS($script);
