<nav class="ey-main-menu-nav">
    <ul class="ey-menu-inner-main">
        <li class="ey-nav-item ey-header-item ey-header-item-is-menu">
            <a href="/jobs">
                Jobs
                <i class="fa fa-caret-down" aria-hidden="true"></i>
            </a>
            <div class="ey-sub-menu">
                <div class="container-fluid">
                    <div class="large-container container">
                        <nav class="ey-sub-nav-main">
                            <ul class="ey-sub-nav-items">
                                <li>
                                    <a href="/jobs/near-me">Jobs Near Me</a>
                                </li>
                                <li>
                                    <a href="/organizations">Explore Companies</a>
                                </li>
                                <li>
                                    <a href="/jobs/compare">Compare Jobs</a>
                                </li>
                                <li>
                                    <a href="/organizations/explore">Featured Companies</a>
                                </li>
                                <li>
                                    <a href="/tweets/jobs">Job Tweets</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </li>
        <li class="ey-nav-item ey-header-item ey-header-item-is-menu">
            <a href="/internships">
                Internships
                <i class="fa fa-caret-down" aria-hidden="true"></i>
            </a>
            <div class="ey-sub-menu">
                <div class="container-fluid">
                    <div class="large-container container">
                        <nav class="ey-sub-nav-main">
                            <ul class="ey-sub-nav-items">
                                <li>
                                    <a href="/internships/near-me">Internships Near Me</a>
                                </li>
                                <li>
                                    <a href="/organizations">Explore Companies</a>
                                </li>
                                <li>
                                    <a href="/internships/compare">Compare Internships</a>
                                </li>
                                <li>
                                    <a href="/organizations/explore">Featured Companies</a>
                                </li>
                                <li>
                                    <a href="/tweets/internships">Internship Tweets</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </li>
        <li class="ey-nav-item ey-header-item ey-header-item-is-menu">
            <a href="/reviews">
                Reviews
                <i class="fa fa-caret-down" aria-hidden="true"></i>
            </a>
            <div class="ey-sub-menu">
                <div class="container-fluid">
                    <div class="large-container container">
                        <nav class="ey-sub-nav-main">
                            <ul class="ey-sub-nav-items">
                                <li>
                                    <a href="/reviews/companies">Companies</a>
                                </li>
                                <li>
                                    <a href="/reviews/colleges">Colleges</a>
                                </li>
                                <li>
                                    <a href="/reviews/schools">Schools</a>
                                </li>
                                <li>
                                    <a href="/reviews/institutes">Educational Institutes</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </li>
        <li class="ey-nav-item ey-header-item ey-header-item-is-menu">
            <a href="/blog">
                Blog
                <i class="fa fa-caret-down" aria-hidden="true"></i>
            </a>
            <div class="ey-sub-menu">
                <div class="container-fluid">
                    <div class="large-container container">
                        <nav class="ey-sub-nav-main">
                            <ul class="ey-sub-nav-items">
                                <li>
                                    <a href="/blog/category/articles">Articles</a>
                                </li>
                                <li>
                                    <a href="/blog/category/infographics">Infographics</a>
                                </li>
                                <li>
                                    <a href="/quizzes/all">Quizzes</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </li>
        <?php if (!Yii::$app->user->isGuest) { ?>
            <li class="ey-nav-item ey-header-item ey-header-item-is-menu">
                <a href="/account/dashboard">
                    Dashboard
<!--                    <i class="fa fa-caret-down" aria-hidden="true"></i>-->
                </a>
                <?php
                if (Yii::$app->user->identity->organization_enc_id) {
                    ?>
                    <div class="ey-sub-menu ey-active-menu">
                        <div class="container-fluid">
                            <div class="large-container container">
                                <nav class="ey-sub-nav-main">
                                    <ul class="ey-sub-nav-items">
                                        <li>
                                            <a href="/account/dashboard">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="/account/jobs/dashboard">Manage Jobs</a>
                                        </li>
                                        <li>
                                            <a href="/account/internships/dashboard">Manage Internships</a>
                                        </li>
                                        <li class="ey-head-sub-menu-has-child">
                                            <a href="javascript:;">Create Job</a>
                                            <div class="ey-sub-sec">
                                                <ul class="ey-head-sub-menu-items">
                                                    <li class="ey-head-sub-menu-icon">
                                                        <a href="/account/jobs/quick-job">
                                                            <div>
                                                                <span class="ey-services-icons quick"></span>
                                                            </div>
                                                            <span>Create Quick Job</span>
                                                        </a>
                                                    </li>
                                                    <li class="ey-head-sub-menu-icon">
                                                        <a href="/tweets/job/create">
                                                            <div>
                                                                <span class="ey-services-icons tweet"></span>
                                                            </div>
                                                            <span>Post Job Tweet</span>
                                                        </a>
                                                    </li>
                                                    <li class="ey-head-sub-menu-icon">
                                                        <a href="/account/jobs/create">
                                                            <div>
                                                                <span class="ey-services-icons ai"></span>
                                                            </div>
                                                            <span>Create AI Job</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="ey-head-sub-menu-has-child">
                                            <a href="javascript:;">Create Internship</a>
                                            <div class="ey-sub-sec">
                                                <ul class="ey-head-sub-menu-items">
                                                    <li class="ey-head-sub-menu-icon">
                                                        <a href="/tweets/internship/create">
                                                            <div>
                                                                <span class="ey-services-icons tweet"></span>
                                                            </div>
                                                            <span>Post Internship Tweet</span>
                                                        </a>
                                                    </li>
                                                    <li class="ey-head-sub-menu-icon">
                                                        <a href="/account/internships/create">
                                                            <div>
                                                                <span class="ey-services-icons ai"></span>
                                                            </div>
                                                            <span>Create AI Internship</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="/account/templates">Templates</a>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="ey-header-sub-menu-container"></div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="ey-sub-menu ey-active-menu">
                        <div class="container-fluid">
                            <div class="large-container container">
                                <nav class="ey-sub-nav-main">
                                    <ul class="ey-sub-nav-items">
                                        <li>
                                            <a href="/account/dashboard">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="/account/jobs/dashboard">Manage Jobs</a>
                                        </li>
                                        <li>
                                            <a href="/account/internships/dashboard">Manage Internships</a>
                                        </li>
                                        <li>
                                            <a href="/account/preferences">My Preferences</a>
                                        </li>
                                        <li>
                                            <a href="/account/resume-builder">Build Resume</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </li>
        <?php } ?>
    </ul>
</nav>
<?php
$this->registerCss('
.ey-header, .ey-header *{
    color: #333;
    transition: transform .3s;
}
.ey-header {
    min-height: 60px;
}
.ey-head-main {
    display: none;
    min-height: 60px;
    position: relative;
}
@media (min-width: 1080px) {
    .ey-head-main {
        display: block;
    }
}
.ey-header-main {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    min-height: 60px;
    position: relative;
}
.ey-header-logo, .ey-header-logo .ey-logo {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.ey-header-logo .ey-logo {
    font-size: 14px;
    line-height: 1em;
    position:relative;
}
.ey-logo img{
    max-height: 45px;
}
.ey-menu-main {
    -webkit-box-flex:16;
    -ms-flex: 16;
    flex: 16;
    margin: 0 30px;
}
.ey-head-main .ey-main-menu-nav,
.ey-head-main .ey-menu-inner-main {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    justify-content: flex-end;
}

.ey-main-menu-nav {
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
}
.ey-head-main .ey-menu-inner-main {
    list-style: none;
    margin-top: 10px;
    padding: 0;
}
.ey-head-main .ey-nav-item, .ey-head-main .ey-nav-actions .ey-menu-login {
    font: 500 14px/16px Roboto, Arial, sans-serif;
    margin: 0 20px 0 0;
    padding: 7px 0px;
}
.ey-head-main .ey-nav-item:last-child {
    margin: 0;
}
.ey-head-main .ey-header-item i {
    font-size: 12px;
    line-height: 1em;
    padding-left: 4px;
    -webkit-transform: rotate(0);
    -ms-transform: rotate(0);
    transform: rotate(0);
    -webkit-transition: .2s linear;
    -o-transition: .2s linear;
    transition: .2s linear;
}

.ey-sub-menu .ey-sub-nav-items {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    list-style: none;
    min-height: 40px;
    justify-content: flex-end;
}

.ey-sub-menu .ey-head-sub-menu-has-child, .ey-sub-nav-items > li {
    font: 500 13px/30px Roboto, Arial, sans-serif;
    padding: 0;
    margin: 0 10px;
}

.ey-sub-menu .ey-head-sub-menu-has-child:first-child>a,
.ey-sub-menu .ey-head-sub-menu-has-child:first-child>span {
    padding-left: 0;
}

.ey-sub-menu li > a,
.ey-sub-menu .ey-head-sub-menu-has-child>span {
    cursor: pointer;
    padding: 0 0 17px;
    position: relative;
}

.ey-sub-menu li > a {
    -webkit-transition: none;
    -o-transition: none;
    transition: none;
    position: relative;
}

.ey-head-main .ey-header-item a {
    padding-bottom: 25px;
}

.ey-sub-sec {
    display: block;
    left: 0;
    list-style: none;
    height: 0;
    min-height: 40px;
    opacity: 0;
    position: absolute;
    right: 0;
    visibility: hidden;
    top: 40px;
    -webkit-transition: opacity .4s;
    -o-transition: opacity .4s;
    transition: opacity .4s;
    z-index: 2;
}

.ey-sub-sec .ey-head-sub-menu-items {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    list-style: none;
    margin: 0 auto;
    padding: 16px 0 23px;
}

.ey-sub-sec .ey-head-sub-menu-icon {
    max-width: 164px;
    width: 100%;
    text-align: center;
}

.ey-sub-sec .ey-head-sub-menu-icon a {
    display: inline-block;
    font-size: 14px;
    padding: 0;
    text-align: center;
}

.ey-sub-sec .ey-head-sub-menu-icon a>div {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    height: 60px;
    margin: 0 auto 10px;
    width: 60px;
}

.ey-services-icons {
    height: 50px;
    width: 50px;
    background-repeat: no-repeat !important;
    background-size: 100% 100% !important;
}
.ey-services-icons.quick {
    background: url(/assets/themes/ey/images/job-profiles/quick.png);
}
.ey-services-icons.tweet {
    background: url(/assets/themes/ey/images/job-profiles/twitter.png);
}
.ey-services-icons.ai {
    background: url(/assets/themes/ey/images/job-profiles/ai.png);
}

.ey-sub-sec .ey-head-sub-menu-icon a>span {
    display: block;
}

.ey-header-sub-menu-container,
.ey-header-sub-menu-container:before {
    left: 50%;
    position: absolute;
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
    width: 100vw;
}

.ey-head-main .ey-nav-actions {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-flex: 1.2;
    -ms-flex: 1.2;
    flex: 1.2;
    -webkit-box-pack: end;
    -ms-flex-pack: end;
    justify-content: flex-end;
}
.ey-sub-menu {
    display: none;
    left: 50%;
    position: absolute;
    right: 0;
    top: 63px;
    z-index: 4;
    height:0px;
    width: 100vw;
    transform: translate(-50%, 0%);
    overflow:hidden;
    box-shadow: 0px 3px 10px 0px #DDD;
}

@media (min-width: 1080px) {
    .ey-mobile-menu {
        display: none;
    }
}

.ey-mobile-menu .ey-mob-nav-main {
    min-height: 40px;
    padding: 0;
    position: relative;
    z-index: 4;
}

.ey-mobile-menu .ey-mobile-logo-main,
.ey-mobile-menu .ey-mob-nav-items {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}

.ey-mobile-menu .ey-mob-nav-items {
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    min-height: 40px;
}

.ey-mobile-menu .ey-humburger-menu-main {
    position: absolute;
}

.ey-humburger-menu,
.ey-humburger-menu span {
    display: block;
    -webkit-transform: rotate(0);
    -ms-transform: rotate(0);
    transform: rotate(0);
}

.ey-humburger-menu {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-color: transparent;
    border: 0;
    color: inherit;
    cursor: pointer;
    font: inherit;
    height: 14px;
    margin: 0;
    overflow: visible;
    padding: 0;
    position: relative;
    text-transform: none;
    -webkit-transition: .5s ease-in-out;
    -o-transition: .5s ease-in-out;
    transition: .5s ease-in-out;
    width: 22px;
}

.ey-humburger-menu span {
    display: block;
    -webkit-transform: rotate(0);
    -ms-transform: rotate(0);
    transform: rotate(0);
}

.ey-humburger-menu span {
    background: #333;
    border-radius: 4px;
    height: 2px;
    left: 0;
    opacity: 1;
    position: absolute;
    -webkit-transition: .25s ease-in-out;
    -o-transition: .25s ease-in-out;
    transition: .25s ease-in-out;
    width: 100%;
}

.ey-humburger-menu span:nth-child(2) {
    top: 0;
}

.ey-humburger-menu span:nth-child(3),
.ey-humburger-menu span:nth-child(4) {
    top: 6px;
}

.ey-humburger-menu span:last-child {
    top: 12px;
}

.ey-mobile-menu .ey-mobile-logo-main {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    text-align: center;
}

.ey-mobile-menu .ey-mobile-logo-main .ey-logo {
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    line-height: 1em;
}

.ey-mobile-menu .ey-mob-actions {
    font: 500 14px/16px Roboto, Arial, sans-serif;
    left: auto;
    position: absolute;
    right: 20px;
}

.ey-mobile-menu .ey-mobile-content {
    display: none;
    background: #fff;
    left: 0;
    min-height: 100vh;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 3;
}

.ey-mobile-menu .ey-mobile-menu-main-content {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-direction: row;
    flex-direction: row;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    height: 100%;
    min-height: 100vh;
    padding-top: 40px;
}

.ey-mobile-menu .ey-mobile-menu-inner-content {
    -webkit-box-flex: 1;
    -ms-flex: 1 0 100%;
    flex: 1 0 100%;
    max-width: 100%;
    padding: 30px;
}

.ey-mobile-menu .ey-mobile-menu-inner-content nav {
    height: 100%;
    min-height: 100%;
}

.ey-mobile-menu .ey-mob-menu-main-items {
    list-style: none;
    margin: 0 0 20px;
    padding: 0;
}
.ey-head-main .ey-header-item-is-menu:hover>a {
    color: #286efa;
}
.ey-head-main .ey-header-item-is-menu:hover .ey-sub-menu, .ey-head-main .ey-header-item-is-menu .ey-sub-menu:hover, .ey-active-menu {
    display: block;
    overflow:visible;
    height:40px;
    -webkit-animation-name: ey_menu;
    -webkit-animation-duration: 0.5s;
    animation-name: ey_menu;
    animation-duration: 0.5s;
}
.ey-head-main .ey-header-item-is-menu:hover .ey-sub-menu, .ey-head-main .ey-header-item-is-menu .ey-sub-menu:hover{z-index:99;}

@-webkit-keyframes ey_menu {
  from {overflow:hidden;display: none;height: 0px;}
  to {overflow:visible;display: block;height: 40px;}
}

@keyframes ey_menu {
  from {overflow:hidden;display: none;height: 0px;}
  to {overflow:visible;display: block;height: 40px;}
}
.ey-sub-menu:before {
    background: #f8f8f8;
    content: "";
    position: absolute;
    top: 0;
    left: 50%;
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
    height: 100%;
    width: 100vw;
    -webkit-transition: background-color 500ms linear;
    -ms-transition: background-color 500ms linear;
    transition: background-color 500ms linear;
}
.large-container.container.add-padding .ey-header-main .ey-menu-main nav ul > .ey-header-item-is-menu > .ey-sub-menu{box-shadow: 0px 3px 10px -5px #DDD;}
.large-container.container.add-padding .ey-header-main .ey-menu-main nav ul > .ey-header-item-is-menu > .ey-sub-menu:before {
    background: #000000;
    -webkit-transition: background-color 500ms linear;
    -ms-transition: background-color 500ms linear;
    transition: background-color 500ms linear;
}
.large-container.container.add-padding .ey-header-main .ey-menu-main nav ul > .ey-header-item-is-menu > .ey-sub-menu.ey-active-menu:before {
    background: #00000047;
    -webkit-transition: background-color 500ms linear;
    -ms-transition: background-color 500ms linear;
    transition: background-color 500ms linear;
}
.large-container.container.add-padding nav ul > .ey-head-sub-menu-has-child a{color: #f2f2f2;}
.ey-sub-menu .ey-head-sub-menu-has-child:focus>a,
.ey-sub-menu .ey-head-sub-menu-has-child:focus>span,
.ey-sub-menu .ey-head-sub-menu-has-child:hover>a,
.ey-sub-menu .ey-head-sub-menu-has-child:hover>span {
    color: #286efa;
}
.ey-head-sub-menu-items > .ey-head-sub-menu-icon:hover > a > div > span {
  animation: shake 0.5s;
  animation-iteration-count: infinite;
}
.ey-sub-sec .ey-head-sub-menu-items > .ey-head-sub-menu-icon{
    position:relative;
    -webkit-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.ey-head-sub-menu-items > .ey-head-sub-menu-icon:before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: -1;
    -webkit-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
}
.ey-head-sub-menu-items > .ey-head-sub-menu-icon:hover:before{
    top: -3px;
    bottom: -3px;
    left: -3px;
    right: -3px;
    background-color: #fff;
    box-shadow: 0 0 50px rgba(32,32,32,.15);
    border-radius: 8px;
}

@keyframes shake {
  0% { transform: translate(1px, 1px) rotate(0deg); }
  10% { transform: translate(-1px, -2px) rotate(-1deg); }
  20% { transform: translate(-3px, 0px) rotate(1deg); }
  30% { transform: translate(3px, 2px) rotate(0deg); }
  40% { transform: translate(1px, -1px) rotate(1deg); }
  50% { transform: translate(-1px, 2px) rotate(-1deg); }
  60% { transform: translate(-3px, 1px) rotate(0deg); }
  70% { transform: translate(3px, 1px) rotate(-1deg); }
  80% { transform: translate(-1px, -1px) rotate(1deg); }
  90% { transform: translate(1px, 2px) rotate(0deg); }
  100% { transform: translate(1px, -2px) rotate(-1deg); }
}
.ey-sub-menu .ey-head-sub-menu-has-child:focus .ey-sub-sec,
.ey-sub-menu .ey-head-sub-menu-has-child:hover .ey-sub-sec {
    height: auto;
    opacity: 1;
    visibility: visible;
}

.ey-sub-menu .ey-head-sub-menu-has-child:focus .ey-sub-sec .ey-head-sub-menu-items, .ey-sub-menu .ey-head-sub-menu-has-child:hover .ey-sub-sec .ey-head-sub-menu-items {
    -webkit-animation: ey-fadeInDown .4s ease-in both;
    animation: ey-fadeInDown .4s ease-in both;
}

.ey-sub-menu .ey-head-sub-menu-has-child:focus .ey-sub-sec .ey-head-sub-menu-items,
.ey-sub-menu .ey-head-sub-menu-has-child:hover .ey-sub-sec .ey-head-sub-menu-items {
    -webkit-animation: .4s ease-in both ey-fadeInDown;
    animation: .4s ease-in both ey-fadeInDown;
}

.ey-header-sub-menu-container {
    background-color: #fff;
    height: 0;
    opacity: 0;
    top: 40px;
    -webkit-transition: .25s ease-in-out .3s;
    -o-transition: .25s ease-in-out .3s;
    transition: .25s ease-in-out .3s;
    visibility: hidden;
    z-index: 1;
}
.ey-header-sub-menu-container-show {
    height: 130px;
    opacity: 1;
    -webkit-transition: .25s ease-in-out;
    -o-transition: .25s ease-in-out;
    transition: .25s ease-in-out;
    visibility: visible;
}
.ey-header-sub-menu-container, .ey-header-sub-menu-container:before {
    left: 50%;
    position: absolute;
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
    width: 100vw;
}
.ey-header-sub-menu-container:before {
    background: -webkit-gradient(linear,left top,left bottom,from(#e6e6e6),to(hsla(0,0%,97.3%,0)));
    background: -webkit-linear-gradient(top,#e6e6e6,hsla(0,0%,97.3%,0));
    background: -o-linear-gradient(top,#e6e6e6 0,hsla(0,0%,97.3%,0) 100%);
    background: linear-gradient(180deg,#e6e6e6 0,hsla(0,0%,97.3%,0));
    bottom: -20px;
    content: "";
    height: 20px;
    right: 0;
}

.ey-header-sub-menu-container, .ey-header-sub-menu-container:before {
    left: 50%;
    position: absolute;
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    transform: translateX(-50%);
    width: 100vw;
}
.ey-mobile-menu .ey-mobile-show {
    display: block;
}
.ey-mobile-menu .ey-mob-menu-inner-item {
    font: 500 18px/21px Roboto,Arial,sans-serif;
    margin: 0 0 19px;
    padding: 0;
    position: relative;
}
.ey-mobile-menu .ey-mobile-item-main {
    border-bottom: 1px solid #e6e6e6;
    cursor: pointer;
    padding: 0;
    position: relative;
}
.ey-mobile-menu .ey-mobile-item-main a {
    display: block;
    padding: 0 0 19px;
}
.ey-mobile-menu .ey-mobile-menu-toggler, .ey-mobile-menu .ey-mobile-menu-item-toggler {
    font-size: 12px;
    line-height: 1em;
    position: absolute;
    right: 0;
    top: 7px;
    -webkit-transition: color .2s;
    -o-transition: color .2s;
    transition: color .2s;
}
.ey-mobile-menu .ey-mobile-menu-toggler i, .ey-mobile-menu .ey-mobile-menu-item-toggler i {
    display: inline-block;
    font-size: 12px;
    line-height: 1em;
}
.ey-mobile-menu .ey-mob-sub-main {
    display: none;
    max-height: 0;
    opacity: 0;
    padding: 20px 0;
    visibility: hidden;
    -webkit-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
}
.ey-mobile-menu .ey-mob-sub-items {
    margin: 0;
    padding: 0;
    width: 100%;
}
.ey-mobile-menu .ey-mob-sub-item {
    border-bottom: 1px solid #ddd;
    font: 500 18px/21px Roboto,Arial,sans-serif;
    margin: 0 0 19px;
    padding: 0;
    position: relative;
}
.ey-mobile-menu .ey-mobile-sub-menu-heading {
    cursor: pointer;
    padding: 0;
    position: relative;
}
.ey-mobile-menu .ey-mobile-sub-menu-heading a {
    display: block;
    padding: 0 0 15px 15px;
}
.ey-mobile-menu .ey-mobile-sub-menu-container {
    display: none;
    max-height: 0;
    opacity: 0;
    visibility: hidden;
    -webkit-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    transition: all .2s ease-in-out;
}
.ey-mobile-menu .ey-mobile-sub-nav-items {
    margin: 0;
    padding: 0;
    width: 100%;
}
.ey-mobile-menu .ey-mobile-nav-item-with-icons {
    margin: 0 0 5px;
    padding: 0;
}
.ey-mobile-menu .ey-mobile-nav-item-with-icons a {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.ey-mobile-menu .ey-mobile-nav-item-with-icons a>div {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    height: 48px;
    margin: 0 10px 0 0;
    width: 48px;
    text-align: center;
}
.ey-mobile-menu .ey-mobile-sub-icons .ey-services-icons {
    height: 26px;
    width: 26px;
}
.ey-mobile-menu .ey-mobile-sub-menu-show {
    display: block;
    max-height: 1800px;
    opacity: 1;
    visibility: visible;
}
.ey-mobile-menu .ey-mobile-sub-nav-show {
    display: block;
    max-height: 1000px;
    opacity: 1;
    padding: 20px 0 20px 20px;
    visibility: visible;
}
.ey-header-main .ey-menu-main nav .ey-menu-inner-main .ey-nav-item a,
.ey-header-main .ey-nav-actions div a,
.ey-header-main .ey-header-logo a span{
    color:#444;
}
.container.add-padding .ey-header-main > .ey-menu-main nav .ey-menu-inner-main .ey-nav-item > a,
.container.add-padding .ey-header-main > .ey-nav-actions div a,
.container.add-padding .ey-header-main > .ey-header-logo a span{
    color:#fff;
}
.container.add-padding .ey-mob-nav-items > .ey-humburger-menu-main button > span{
    background:#fff;
}
.large-container{
    width:auto;
}
.bg-theme-colored {
    background-color: #fff !important;
    min-height:65px;
}
#header-main{
    padding:2px 0px;
}
@media screen and (max-width: 900px) and (min-width: 0px) {
    #header-main{
        padding:6px 0px;
    }
}
.ey-sub-nav-main .ey-sub-nav-items > li > a:hover{
    color:#00a0e3 !Important;
}
.ey-mobile-menu{
    padding: 10px 5px 3px 0px;
}
');
?>