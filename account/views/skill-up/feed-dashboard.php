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

    <section>
        <div class="col-md-12">
            <div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">My Contributions</span>
                    </div>
                    <div class="actions">
                        <div class="set-im">
                            <a href="<?= Url::to('create'); ?>" data-toggle="tooltip"
                               title="Add More"
                               class="add-lead">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/add-new.png'); ?>"></a>
                            <a href="<?= Url::to('view-all'); ?>" data-toggle="tooltip"
                               title="View All"
                               class="add-lead">
                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
                        </div>

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="my-leads-view">
                        <table class="my-leadd">
                            <thead>
                            <tr>
                                <th class="w100">Date</th>
                                <th class="w250">Title</th>
                                <th class="w200">Author Name</th>
                                <th class="w150">Source Name</th>
                                <th class="w150">Content Type</th>
                                <th class="w300">Source Link</th>
                                <th class="w300">Skills</th>
                                <th class="w200">Industries</th>
                                <th class="w200">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($feeds) {
                                foreach ($feeds as $f) { ?>
                                    <tr>
                                        <td><?= $f['date'] ?></td>
                                        <td><a href="/skill-up/detail/<?= $f['slug'] ?>"
                                               target="_blank"><?= $f['post_title'] ?></a></td>
                                        <td><?= $f['author_name'] ?></td>
                                        <td><?= $f['source'] ?></td>
                                        <td><?= $f['content_type'] ?></td>
                                        <td><a href="<?= $f['post_source_url'] ?>"
                                               class="src-link" target="_blank"><?= $f['post_source_url'] ?></a>
                                        </td>
                                        <td>
                                            <ul>
                                                <li><?= $f['skills'] ?></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li><?= $f['industries'] ?></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li>
                                                    <?php
                                                    if($f['status']){
                                                    ?>
                                                    <a href="/account/skill-up/edit?slug=<?= $f['slug'];?>">Edit</a>
                                                    <?php
                                                    }
                                                    ?>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
.danger {
    background-color: #d9534f;
}
.add-lead img{width:25px;}
.w50{min-width:50px;}
.w100{min-width:100px;}
.w150{min-width:150px;}
.w200{min-width:200px;}
.w250{min-width:250px;}
.w300{min-width:300px;}
.my-leads-view{ 
    overflow-x: scroll;
    max-width: 100%;
    position:relative;
}
.my-leadd  { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
.my-leadd tr:nth-of-type(even) { 
  background:#f5f5f5; 
}
.my-leadd tr th {
    background-color:#00a0e3;
    color: #fff;
    font-family: Roboto;
    font-weight: 500;
}
.my-leadd td, .my-leadd th { 
  padding: 10px 6px; 
  border: 1px solid #eee; 
  text-align: center; 
  font-family:roboto;
}
.my-leadd td ul {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start;
    padding:0;
}
.my-leadd td ul li {
    list-style: none;
    margin: 0 5px 2px 0;
}
@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {
.page-content{padding:0;}
.my-leadd tr:nth-of-type(odd) {
    background: #00a0e3;
    color: #fff;
    margin-bottom: 20px;
}
.my-leadd td, .my-leadd th {
    text-align:left;
}
.my-leadd td ul{
    justify-content: flex-start;
    }
.src-link{
    color:#000;    
    word-break: break-all;
    }
/* Force table to not be like tables anymore */
.my-leadd, thead, tbody, th, td, tr { 
    display: block; 
}

/* Hide table headers (but not display: none;, for accessibility) */
.my-leadd thead tr { 
    position: absolute;
    top: -9999px;
    left: -9999px;
}

.my-leadd tr { border: 1px solid #f5f5f5; }

.my-leadd td { 
    /* Behave  like a "row" */
    border: none;
    border-bottom: 1px solid #eee; 
    position: relative;
    padding-left: 50%; 
    margin: 5px;
}

.my-leadd td:before { 
    position: absolute;
    top: 8px;
    left: 5px;
    width:50%;
    padding-right: 10px;
    font-weight: 500;
}

/*
Label the data
*/
.my-leadd td:nth-of-type(1):before { content: "Date"; }
.my-leadd td:nth-of-type(2):before { content: "Title"; }
.my-leadd td:nth-of-type(3):before { content: "Author Name"; }
.my-leadd td:nth-of-type(4):before { content: "Source Name"; }
.my-leadd td:nth-of-type(5):before { content: "Content Type"; }
.my-leadd td:nth-of-type(6):before { content: "Sourcre Link"; }
.my-leadd td:nth-of-type(7):before { content: "Skills"; }
.my-leadd td:nth-of-type(8):before { content: "Industries"; }
}
@media screen and (max-width: 500px) {
.my-leadd td:before,.my-leadd td{
    font-size:12px;
}
.my-leadd td:before{
    top:0;
}
}
');
$script = <<<JS
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
var pa = new PerfectScrollbar('.my-leads-view');
JS;
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);