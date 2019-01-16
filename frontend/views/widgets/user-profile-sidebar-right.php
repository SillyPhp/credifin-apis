<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="profiles-sidebar">
    <span class="close-profile"><i class="fa fa-close"></i></span>
    <div class="can-detail-s">
        <div class="cst">

            <?php
            $name = $image = NULL;
            if (Yii::$app->user->identity->organization) {
                if (Yii::$app->user->identity->organization->logo) {
                    $image = Yii::$app->params->upload_directories->organizations->logo . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;
                }
                $name = Yii::$app->user->identity->organization->name;
            } else {
                if (Yii::$app->user->identity->image) {
                    $image = Yii::$app->params->upload_directories->users->image . Yii::$app->user->identity->image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->image;
                }
                $name = Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name;
            }

            if ($image):
                ?>
                <span><img src="<?= $image; ?>" alt="<?= $name; ?>" /></span>
            <?php else: ?>
                <span><canvas class="user-icon" name="<?= $name; ?>" width="40" height="40" font="20px"></canvas></span>
            <?php endif; ?>
        </div>
        <h3><?= Yii::$app->user->identity->first_name . '  ' . Yii::$app->user->identity->last_name ?></h3>
        <p><?= Yii::$app->user->identity->email ?></p>
    </div>
    <div class="tree_widget-sec">
        <ul>
            <?php
            $userType = Yii::$app->user->identity->type->user_type;
            if($userType === 'Individual') :
            ?>
            <li class="inner-child">
                <a href="/user/<?= Yii::$app->user->identity->username ?>" title="" class="tree-toggler"><i class="fa fa-file-text-o"></i>My Profile</a>

            </li>
            <li class="inner-child">
                <a href="/account/jobs/shortlisted" title="" class="tree-toggler"><i class="fa fa-money"></i>Shorlisted Job</a>

            </li>
            <li class="inner-child">
                <a href="/account/jobs/applied" title="" class="tree-toggler"><i class="fa fa-paper-plane-o"></i>Applied Job</a>
            </li>
            <li>
                <a href="#" url="/site/changepass" id="open-modal" data-toggle="modal" data-target="#myModal2" data-backdrop="static" data-keyboard="false"><i class="fa fa-key"></i> Change Password</a>
                <div class="modal fade" id="myModal2" role="dialog">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>" alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                                <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span> </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php elseif ($userType === 'Organization Admin'): ?>
<!--            Organization Menu Items-->
                <li class="inner-child">
                    <a href="/company/<?= Yii::$app->user->identity->username ?>" title="" class="tree-toggler"><i class="fa fa-file-text-o"></i>My Profile</a>
                </li>
                <li class="inner-child">
                    <a href="/account/jobs" title="" class="tree-toggler"><i class="fa fa-money"></i>Active Jobs</a>
                </li>
                <li class="inner-child">
                    <a href="/account/internships" title="" class="tree-toggler"><i class="fa fa-paper-plane-o"></i>Active Internships</a>
                </li>
                <li class="inner-child">
                    <a href="/account/jobs/create" title="" class="tree-toggler"><i class="fa fa-money"></i>Create Jobs</a>
                </li>
                <li class="inner-child">
                    <a href="/account/internships/create" title="" class="tree-toggler"><i class="fa fa-paper-plane-o"></i>Create Internships</a>
                </li>
            <?php endif; ?>
            <li class="inner-child">
                <a href="<?= Url::to('/logout'); ?>" data-method="post"><i class="fa fa-sign-out"></i>Logout</a>
            </li>
        </ul>
    </div>
</div>
<?php
$this->registerCss('
.my-profiles-sec {
    float: right;
}
.my-profiles-sec > span {
    float: left;
    width:40px;
    height:40px;
    color: #49a1e3;
    font-family: Open Sans;
    cursor: pointer;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50% !important;
}
.header-nav.navbar-transparent.animated-active .my-profiles-sec > span {
    color: #fff;
}
.my-profiles-sec > span > img {
    float: left;
    width:40px;
    height:40px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    border: 2px solid #ffffff;
    background-color:#fff;
}
.my-profiles-sec > span > i {
    float: right;
    line-height: 50px;
    font-size: 20px;
    margin-left: 5px;
}
.profiles-sidebar {
    position: fixed;
    right: -316px;
    top: 0;
    z-index: 99999;
    background: #ffffff;
    width: 316px !important;
    -webkit-box-shadow: 0px 0px 40px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 40px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 40px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 40px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 40px rgba(0,0,0,0.1);

    overflow-y: scroll;
    height: 100%;
    opacity: 0;
    visibility: hidden;
}
.profiles-sidebar .close-profile {
    position: absolute;
    left: 30px;
    top: 30px;
    width: 32px;
    height: 32px;
    background: #ef7706;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;

    text-align: center;
    line-height: 32px;
    color: #ffffff;
    cursor: pointer;
}
.profiles-sidebar .can-detail-s {
    margin: 0;
    float: left;
    width: 100%;
    padding: 0 20px;
}
.profiles-sidebar .can-detail-s .cst img, .profiles-sidebar .can-detail-s .cst canvas {
//    width: 100%;
//    height: 100%;
    width: 137px;
    height: 137px;
    border: 2px solid #ffffff;
    -webkit-box-shadow: 0px 0px 15px 10px #d8d8d8;
    -moz-box-shadow: 0px 0px 15px 10px #d8d8d8;
    -ms-box-shadow: 0px 0px 15px 10px #d8d8d8;
    -o-box-shadow: 0px 0px 15px 10px #d8d8d8;
    box-shadow: 0px 0px 15px 10px #d8d8d8;

}
.profiles-sidebar .tree_widget-sec {
    padding: 0 40px;
    margin-top: 30px;
    float: left;
    width: 100%;
    margin-bottom: 40px;
}
.profiles-sidebar .tree_widget-sec > ul {
    border-top: 1px solid #e8ecec;
    padding-top: 22px;
}
.profiles-sidebar.active {
    right: -16px;
    opacity: 1;
    visibility: visible;
}
.profiles-sidebar{
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.widget .tree_widget-sec {
    margin: 0;
}
.tree_widget-sec > ul {
    float: left;
    width: 100%;
    margin: 0;
}
.tree_widget-sec > ul > li {
    float: left;
    width: 100%;
    margin: 0;
}
.tree_widget-sec > ul > li > a {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 13px;
    color: #888888;
    line-height: 41px;
}
.tree_widget-sec > ul > li > a i {
    float: left;
    font-size: 23px;
    line-height: 41px !important;
    color: #babebe;
    margin-right: 5px;
    width: 35px;
}
.tree_widget-sec > ul > li > ul {
    float: left;
    width: 100%;
    margin: 0;
}
.tree_widget-sec > ul > li > ul {
    float: left;
    width: 100%;
    margin: 0;
    padding-left: 34px;
    margin: 17px 0;
    display: none;
}
.tree_widget-sec > ul > li > ul > li {
    float: left;
    width: 100%;
    position: relative;
    margin: 0;
    padding-left: 20px;
    border-left: 1px solid #e8ecec;
}
.tree_widget-sec > ul > li > ul > li a {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 13px;
    color: #888888;
    padding: 3px 0;
}
.tree_widget-sec > ul > li > ul > li::before {
    position: absolute;
    left: 0;
    top: 50%;
    width: 10px;
    height: 1px;
    content: "";
    background: #e8ecec;
}
.tree_widget-sec > ul > li > ul > li:first-child::before {
    top: 0;
}
.tree_widget-sec > ul > li > ul > li:last-child::before {
    bottom: 0;
    top: auto;
}
.tree_widget-sec > ul > li > ul > li:first-child > a {
    padding-top: 0;
    line-height: 2px;
    margin-bottom: 7px;
}
.tree_widget-sec > ul > li > ul > li:last-child > a {
    padding-bottom: 0;
    line-height: 2px;
    margin-top: 7px;
}
.tree-toggler.active{
    color: #4aa1e3 !important;
}
.tree-toggler.active i {
    color: #4aa1e3 !important;
}
.profiles-sidebar .tree_widget-sec {
    padding: 0 40px;
    margin-top: 30px;
    float: left;
    width: 100%;
    margin-bottom: 40px;
}
.profiles-sidebar .tree_widget-sec > ul {
    border-top: 1px solid #e8ecec;
    padding-top: 22px;
}
.tree_widget-sec > ul > li > ul > li a:hover {
    color: #202020;
}
.can-detail-s {
    vertical-align: top;
    text-align: center;
}
.can-detail-s > h3 {
    float: left;
    width: 100%;
    font-family: Quicksand;
    font-size: 22px;
    color: #202020;
    font-weight: bold;
    margin: 0;
}
.can-detail-s span {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 13px;
    color: #202020;
    margin-top: 14px;
}
.can-detail-s span i {
    font-style: normal;
    color: #4aa1e3;
}
.can-detail-s > p {
    float: left;
    width: 100%;
    margin: 0;
    margin-top: 0px;
    font-size: 13px;
    color: #888888;
    line-height: 13px;
    margin-top: 10px;
}
.can-detail-s > p i {
    margin-right: 5px;
}
.profiles-sidebar .can-detail-s {
    margin: 0;
    float: left;
    width: 100%;
    padding: 0 20px;
}
.cst {
    float: none;
    display: inline-block;
    border: 2px solid #ffffff;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    width: 175px;
    height: 175px;
    padding: 17px;
    margin-top:20px;
}
//.cst span{
//    width: 137px;
//    border-radius: 50%;
//    height: 137px;
//    border: 2px solid #ffffff;
//    padding:16px;
//    -webkit-box-shadow: 0px 0px 15px 10px #d8d8d8;
//    -moz-box-shadow: 0px 0px 15px 10px #d8d8d8;
//    -ms-box-shadow: 0px 0px 15px 10px #d8d8d8;
//    -o-box-shadow: 0px 0px 15px 10px #d8d8d8;
//    box-shadow: 0px 0px 15px 10px #d8d8d8;
//}
.cst img, .cst canvas {
    width: 100%;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
}
');

$script = <<<JS
$(".tree-toggler").click(function () {
    $(this).parent().children("ul.tree").toggle(300);
    $(this).toggleClass("active");
});

$(document).on("click", ".my-profiles-sec > span", function () {
    $(".profiles-sidebar").addClass("active");
});
$(document).on("click", ".close-profile", function () {
    $(".profiles-sidebar").removeClass("active");
});

$(document).on("click", ".scroll-to a, .scrollup, .back-top, .tree_widget-sec > ul > li > ul > li a, .cand-extralink a", function (e) {
//    e.preventDefault();
    $("html, body").animate({scrollTop: $($(this).attr("href")).offset().top}, 500, "linear");
});

        
$(document).on("click", "#open-modal", function (a) {
    a.preventDefault();
    $(".modal-body").load($(this).attr("url"));
});
JS;
$this->registerJs($script);
