<?php
use yii\helpers\Url;
?>
<div class="wizard-navigation">
    <ul class="nav nav-pills">
        <li><a href="<?= Url::to('/' . Yii::$app->user->identity->username . '/edit'); ?>">Edit Profile</a></li>
        <li><a href="<?= Url::to('/account/resume-builder'); ?>">Resume Builder</a></li>
        <li><a href="<?= Url::to('/account/preferences'); ?>">Candidate Preferences</a></li>
    </ul>
</div>
<?php
$this->registerCss('
/* wizard-navigation css starts */
.wizard-navigation {
    position: relative;
    margin-bottom: 30px;
}
.wizard-navigation .nav-pills > li {
    text-align: center;
}
.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
    background-color: transparent;
}
.nav-pills {
    background-color: rgba(200, 200, 200, 0.2);
}
.nav>li>a:focus, .nav>li>a:hover {
    text-decoration: none;
    background-color: #eee;
}
.wizard-navigation ul li {
    width: calc(99% / 3);
    display: inline-block;
    margin-bottom:0px;
    text-align: center;
}
.nav-pills>li>a, .nav-tabs>li>a {
    font-size: 14px;
    -webkit-border-radius: 2px 2px 0 0;
    -moz-border-radius: 2px 2px 0 0;
    -ms-border-radius: 2px 2px 0 0;
    -o-border-radius: 2px 2px 0 0;
    border-radius: 2px 2px 0 0;
}
.wizard-navigation > .nav.nav-pills > li a{
    color: #808080;
}
.wizard-navigation > .nav.nav-pills > li.active a{
    color:#fff;
}
.wizard-navigation > .nav.nav-pills > li.active:before{
    content:"";
    width:100%;
    height: calc(100% + 8px);
    background-color: #f44336;
    box-shadow: 0 16px 26px -10px rgba(244, 67, 54, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(244, 67, 54, 0.2);
    position: absolute;
    text-align: center;
    padding: 12px;
    font-size: 12px;
    text-transform: uppercase;
    -webkit-font-smoothing: subpixel-antialiased;
    top: -4px;
    left: 0px;
    border-radius: 4px;
    color: #FFFFFF;
    cursor: pointer;
    font-weight: 500;
    transform: translate3d(-8px, 0px, 0px);
    transition: transform 0s ease 0s;
}
/* wizard-navigation css ends */
');
$this->registerJs('
var thispageurl = window.location.pathname;
$(".wizard-navigation .nav-pills li a").each(function(){
    var attr = $(this).attr("href");
      if (attr === thispageurl) {
        $(this).parent().addClass("active");
      }
});
');
