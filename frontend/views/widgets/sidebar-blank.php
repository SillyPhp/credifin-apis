
<!--    <div class="row profile">
                <div class="col-md-3">
                        <div class="profile-sidebar">
                                 SIDEBAR USERPIC 
                                <div class="profile-userpic">
                                        <img src="/assets/images/logo-black-footer.png" hight="200" width="200" class="img-responsive" alt="">
                                </div>
                                 END SIDEBAR USERPIC 
                                 SIDEBAR USER TITLE 
                                <div class="profile-usertitle">
                                        <div class="profile-usertitle-name">
                                                DSB EduTEch Pvt. Ltd.
                                        </div>
                                </div>
                                 END SIDEBAR USER TITLE 
                                 SIDEBAR BUTTONS 
                                <div class="profile-userbuttons">
                                        <button type="button" class="btn btn-success btn-sm">Follow</button>
                                        <button type="button" class="btn btn-danger btn-sm">Message</button>
                                </div>
                                 END SIDEBAR BUTTONS 
                                 SIDEBAR MENU 
                                <div class="profile-usermenu">
                                        <ul class="nav">
                                                <li class="active">
                                                        <a href="#">
                                                        <i class="glyphicon glyphicon-home"></i>
                                                        Overview </a>
                                                </li>
                                                <li>
                                                        <a href="#">
                                                        <i class="glyphicon glyphicon-user"></i>
                                                        Account Settings </a>
                                                </li>
                                                <li>
                                                        <a href="#">
                                                        <i class="glyphicon glyphicon-ok"></i>
                                                        Tasks </a>
                                                </li>
                                                <li>
                                                        <a href="#">
                                                        <i class="glyphicon glyphicon-flag"></i>
                                                        Help </a>
                                                </li>
                                        </ul>
                                </div>
                                 END MENU 
                        </div>
                </div>
        </div>-->
<?php

use yii\widgets\Menu;
use yii\helpers\Url;
?>
<div class="row profile">
    <div class="profile-sidebar">

        <div class="profile-userpic">
            <img src="/assets/images/logo-black-footer.png" hight="200" width="200" class="img-responsive" alt="">
        </div>

        <div class="profile-usertitle">
            <div class="profile-usertitle-name">
                DSB EduTech Pvt. Ltd.
            </div>
        </div>
        <div class="profile-usermenu">
            <?php
            echo Menu::widget([
                'encodeLabels' => false,
                'activateItems' => true,
                'activateParents' => true,
                'activeCssClass' => 'active',
                'items' => [
                    [
                        'label' => 'Dashboard',
                        'icon' => 'Dashboard',
                        'url' => Url::to(['/demo/dashboard']),
                        'linkTemplate' => '<a href="{url}"><i class="glyphicon glyphicon-user"></i>{label}</a>',
                        'itemOptions' => [
                            'class' => 'asacacs',
                        ],
                    ],
                    ['label' => 'Resume',
                        'icon' => 'items',
                        'visible' => (Yii::$app->session->get('user_type') == 'Member'),
                        'url' => Url::to(['/demo/resume',
                            'type' => $type]), 'active' => ($item == 'resume')],
                    ['label' => 'Internships',
                        'icon' => 'items',
                        'url' => Url::to(['/demo/internships', 'type' => $type]),
                        'active' => ($item == 'internships')],
                    ['label' => 'Profile',
                        'icon' => 'user',
                        'url' => Url::to(['/demo/profile',
                        'type' => $type]), 'active' => ($item == 'profile')],
                    ['label' => 'Post Internship',
                        'icon' => 'items', 'visible' => (Yii::$app->session->has('user_type') && Yii::$app->session->get('user_type') == 'Company Admin'),
                        'url' => Url::to(['/demo/post-new-internship', 'type' => $type]),
                        'active' => ($item == 'resume')
                    ],
                    ['label' =>
                        'Internships for review',
                        'visible' => (Yii::$app->session->has('user_type') && Yii::$app->session->get('user_type') == 'Member'),
                        'icon' => 'items',
                        'url' => Url::to(['/demo/internship-for-review', 'type' => $type]),
                        'active' => ($item == 'Internships For Review')
                    ],
                    ['label' => 'Organization Form',
                        'visible' => (Yii::$app->session->has('user_type') && Yii::$app->session->get('user_type') == 'Company Admin'),
                        'icon' => 'items',
                        'url' => Url::to(['/demo/organization', 'type' => $type]),
                        'active' => ($item == 'organization')
                    ],
                    ['label' => 'Employer Requisition',
                        'visible' => (Yii::$app->session->has('user_type') && Yii::$app->session->get('user_type') == 'Company Admin'),
                        'icon' => 'items',
                        'url' => Url::to(['/demo/employer-requisition-form', 'type' => $type]),
                        'active' => ($item == 'Empoyer Requisition')
                    ],
                    ['label' => Yii::t('dsbedutech', 'Account Settings'),
                        'url' => ['/logout'],
                        'template' => '<a href="{url}" data-method="post">{label}</a>',
                        'visible' => !Yii::$app->user->isGuest,
                    ],
                    ['label' => Yii::t('dsbedutech', 'Logout'),
                        'url' => ['/logout'],
                        'template' => '<a href="{url}" data-method="post">{label}</a>',
                        'visible' => !Yii::$app->user->isGuest,
                    ],
                ],
                'options' => [
                    'class' => 'nav',
                ],
            ]);
            ?>
        </div>
    </div>
</div>
</div>
<?=
$this->registerCss("
  
body {
  background: #F1F3FA;
}

.profile {
  margin: 20px 0;
}

.profile-sidebar {
  background: #fff;
    margin-top: 20px;
    padding-top-20;
}

.profile-userpic img {
  float: none;
  margin: 0 auto;
  width: 50%;
  height: 50%;
}

.profile-usertitle {
  text-align: center;
  margin-top: 20px;
}

.profile-usertitle-name {
  color: #5a7391;
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 7px;
}

.profile-usertitle-job {
  text-transform: uppercase;
  color: #5b9bd1;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 15px;
}

.profile-userbuttons {
  text-align: center;
  margin-top: 10px;
}

.profile-userbuttons .btn {
  text-transform: uppercase;
  font-size: 11px;
  font-weight: 600;
  padding: 6px 15px;
  margin-right: 5px;
}

.profile-userbuttons .btn:last-child {
  margin-right: 0px;
}
    
.profile-usermenu {
  margin-top: 30px;
}

.profile-usermenu ul li {
  border-bottom: 1px solid #f0f4f7;
}

.profile-usermenu ul li:last-child {
  border-bottom: none;
}

.profile-usermenu ul li a {
  color: #93a3b5;
  font-size: 14px;
  font-weight: 400;
}

.profile-usermenu ul li a i {
  margin-right: 8px;
  font-size: 14px;
}

.profile-usermenu ul li a:hover {
  background-color: #fafcfd;
  color: #5b9bd1;
}

.profile-usermenu ul li.active {
  border-bottom: none;
}

.profile-usermenu ul li.active a {
  color: #5b9bd1;
  background-color: #f6f9fb;
  border-left: 2px solid #5b9bd1;
  margin-left: -2px;
}

/* Profile Content */
.profile-content {
  padding: 20px;
  background: #fff;
  min-height: 460px;
}

:focus {
  outline: none;
}
.row {
  margin-right: 0;
  margin-left: 0;
}
.side-menu {
  position: fixed;
  height: 100%;
  background-color: #f8f8f8;
  border-right: 1px solid #e7e7e7;
}
.side-menu .navbar {
  border: none;
}
.side-menu .navbar-header {
  width: 100%;
  border-bottom: 1px solid #e7e7e7;
}
.side-menu .navbar-nav .active a {
  background-color: transparent;
  margin-right: -1px;
  border-right: 5px solid #e7e7e7;
}
.side-menu .navbar-nav li {
  display: block;
  width: 100%;
  border-bottom: 1px solid #e7e7e7;
}
.side-menu .navbar-nav li a {
  padding: ;
}
.side-menu .navbar-nav li a .glyphicon {
  padding-right: 10px;
}
.side-menu #dropdown {
  border: 0;
  margin-bottom: 0;
  border-radius: 0;
  background-color: transparent;
  box-shadow: none;
}
.side-menu #dropdown .caret {
  float: right;
  margin: 9px 5px 0;
}
.side-menu #dropdown .indicator {
  float: right;
}
.side-menu #dropdown > a {
  border-bottom: 1px solid #e7e7e7;
}
.side-menu #dropdown .panel-body {
  padding: 0;
  background-color: #f3f3f3;
}
.side-menu #dropdown .panel-body .navbar-nav {
  width: 100%;
}
.side-menu #dropdown .panel-body .navbar-nav li {
  padding-left: 15px;
  border-bottom: 1px solid #e7e7e7;
}
.side-menu #dropdown .panel-body .navbar-nav li:last-child {
  border-bottom: none;
}
.side-menu #dropdown .panel-body .panel > a {
  margin-left: -20px;
  padding-left: 35px;
}
.side-menu #dropdown .panel-body .panel-body {
  margin-left: -15px;
}
.side-menu #dropdown .panel-body .panel-body li {
  padding-left: 30px;
}
.side-menu #dropdown .panel-body .panel-body li:last-child {
  border-bottom: 1px solid #e7e7e7;
}
.side-menu #search-trigger {
  background-color: #f3f3f3;
  border: 0;
  border-radius: 0;
  position: absolute;
  top: 0;
  right: 0;
  padding: 15px 18px;
}
.side-menu .brand-name-wrapper {
  min-height: 50px;
}
.side-menu .brand-name-wrapper .navbar-brand {
  display: block;
}
.side-menu #search {
  position: relative;
  z-index: 1000;
}
.side-menu #search .panel-body {
  padding: 0;
}
.side-menu #search .panel-body .navbar-form {
  padding: 0;
  padding-right: 50px;
  width: 100%;
  margin: 0;
  position: relative;
  border-top: 1px solid #e7e7e7;
}
.side-menu #search .panel-body .navbar-form .form-group {
  width: 100%;
  position: relative;
}
.side-menu #search .panel-body .navbar-form input {
  border: 0;
  border-radius: 0;
  box-shadow: none;
  width: 100%;
  height: 50px;
}
.side-menu #search .panel-body .navbar-form .btn {
  position: absolute;
  right: 0;
  top: 0;
  border: 0;
  border-radius: 0;
  background-color: #f3f3f3;
  padding: 15px 18px;
}
/* Main body section */
.side-body {
  margin-left: 210px;
}
/* small screen */
@media (max-width: 768px) {
  .side-menu {
    position: relative;
    width: 100%;
    height: 0;
    border-right: 0;
    border-bottom: 1px solid #e7e7e7;
  }
  .side-menu .brand-name-wrapper .navbar-brand {
    display: inline-block;
  }
  /* Slide in animation */
  @-moz-keyframes slidein {
    0% {
      left: -300px;
    }
    100% {
      left: 10px;
    }
  }
  @-webkit-keyframes slidein {
    0% {
      left: -300px;
    }
    100% {
      left: 10px;
    }
  }
  @keyframes slidein {
    0% {
      left: -300px;
    }
    100% {
      left: 10px;
    }
  }
  @-moz-keyframes slideout {
    0% {
      left: 0;
    }
    100% {
      left: -300px;
    }
  }
  @-webkit-keyframes slideout {
    0% {
      left: 0;
    }
    100% {
      left: -300px;
    }
  }
  @keyframes slideout {
    0% {
      left: 0;
    }
    100% {
      left: -300px;
    }
  }
  /* Slide side menu*/
  /* Add .absolute-wrapper.slide-in for scrollable menu -> see top comment */
  .side-menu-container > .navbar-nav.slide-in {
    -moz-animation: slidein 300ms forwards;
    -o-animation: slidein 300ms forwards;
    -webkit-animation: slidein 300ms forwards;
    animation: slidein 300ms forwards;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
  }
  .side-menu-container > .navbar-nav {
    /* Add position:absolute for scrollable menu -> see top comment */
    position: fixed;
    left: -300px;
    width: 300px;
    top: 43px;
    height: 100%;
    border-right: 1px solid #e7e7e7;
    background-color: #f8f8f8;
    -moz-animation: slideout 300ms forwards;
    -o-animation: slideout 300ms forwards;
    -webkit-animation: slideout 300ms forwards;
    animation: slideout 300ms forwards;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
  }
  /* Uncomment for scrollable menu -> see top comment */
  /*.absolute-wrapper{
        width:285px;
        -moz-animation: slideout 300ms forwards;
        -o-animation: slideout 300ms forwards;
        -webkit-animation: slideout 300ms forwards;
        animation: slideout 300ms forwards;
        -webkit-transform-style: preserve-3d;
        transform-style: preserve-3d;
    }*/
  @-moz-keyframes bodyslidein {
    0% {
      left: 0;
    }
    100% {
      left: 300px;
    }
  }
  @-webkit-keyframes bodyslidein {
    0% {
      left: 0;
    }
    100% {
      left: 300px;
    }
  }
  @keyframes bodyslidein {
    0% {
      left: 0;
    }
    100% {
      left: 300px;
    }
  }
  @-moz-keyframes bodyslideout {
    0% {
      left: 300px;
    }
    100% {
      left: 0;
    }
  }
  @-webkit-keyframes bodyslideout {
    0% {
      left: 300px;
    }
    100% {
      left: 0;
    }
  }
  @keyframes bodyslideout {
    0% {
      left: 300px;
    }
    100% {
      left: 0;
    }
  }
  /* Slide side body*/
  .side-body {
    margin-left: 5px;
    margin-top: 70px;
    position: relative;
    -moz-animation: bodyslideout 300ms forwards;
    -o-animation: bodyslideout 300ms forwards;
    -webkit-animation: bodyslideout 300ms forwards;
    animation: bodyslideout 300ms forwards;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
  }
  .body-slide-in {
    -moz-animation: bodyslidein 300ms forwards;
    -o-animation: bodyslidein 300ms forwards;
    -webkit-animation: bodyslidein 300ms forwards;
    animation: bodyslidein 300ms forwards;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
  }
  /* Hamburger */
  .navbar-toggle {
    border: 0;
    float: left;
    padding: 18px;
    margin: 0;
    border-radius: 0;
    background-color: #f3f3f3;
  }
  /* Search */
  #search .panel-body .navbar-form {
    border-bottom: 0;
  }
  #search .panel-body .navbar-form .form-group {
    margin: 0;
  }
  .navbar-header {
    /* this is probably redundant */
    position: fixed;
    z-index: 3;
    background-color: #f8f8f8;
  }
  /* Dropdown tweek */
  #dropdown .panel-body .navbar-nav {
    margin: 0;
  }
}
");
