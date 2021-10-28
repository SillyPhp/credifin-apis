<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->params['header_dark'] = true;

?>

    <section class="skill-time">
        <div class="container">
            <div class="row">
                <div class="col-md-3 pos-stick">
                    <div class="dash-inner-box set-height-s nd-shadow">
                        <div style="padding: 10px 15px;">
                            <h3 class="filterss" style="padding-left: 0px">Search Feed</h3>
                            <input type="text" class="form-control" placeholder="Enter Keyword to search feed">
                        </div>
                        <h3 class="filterss">Filters</h3>
                        <div class="filters-main">
                            <div class="filters-inner-main">
                                <div class="col-md-12 col-sm-12" style="padding:0;">
                                    <div class="main-filter">
                                        <ul class="m-filter">
                                            <li>
                                                <input class="checkbox" id="sort-videos" type="checkbox" name="courses"
                                                       value="Video"/>
                                                <label for="sort-videos">
                                                    <div>Video</div>
                                                </label>
                                            </li>
                                            <li>
                                                <input class="checkbox" id="sort-podcast" type="checkbox" name="courses"
                                                       value="Podcast"/>
                                                <label for="sort-podcast">
                                                    <div>Podcast</div>
                                                </label>
                                            </li>
                                            <li>
                                                <input class="checkbox" id="sort-webinars" type="checkbox"
                                                       name="courses"
                                                       value="Audio"/>
                                                <label for="sort-webinars">
                                                    <div>Audio</div>
                                                </label>
                                            </li>
                                            <li>
                                                <input class="checkbox" id="sort-news" type="checkbox" name="courses"
                                                       value="Article"/>
                                                <label for="sort-news">
                                                    <div>Articles</div>
                                                </label>
                                            </li>
                                            <li>
                                                <input class="checkbox" id="sort-filter" type="checkbox" name="courses"
                                                       value="Blog"/>
                                                <label for="sort-filter">
                                                    <div>Blog</div>
                                                </label>
                                            </li>
                                            <li>
                                                <input class="checkbox" id="news-filter" type="checkbox" name="courses"
                                                       value="News"/>
                                                <label for="news-filter">
                                                    <div>News</div>
                                                </label>
                                            </li>
                                            <li>
                                                <input class="checkbox" id="course-filter" type="checkbox"
                                                       name="courses"
                                                       value="Course"/>
                                                <label for="course-filter">
                                                    <div>Courses</div>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-4" style="padding:0;">
                                    <div class="filters-box">
                                        <div class="f-head">
                                            <h3>Skills</h3>
                                        </div>
                                        <ul>
                                            <li>
                                                <label class="control control--checkbox">First checkbox
                                                    <input type="checkbox" checked="checked"/>
                                                    <div class="control__indicator"></div>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="feed-box dash-inner-box nd-shadow">
                                <div class="rec-batch">Recommended</div>
                                <div class="feed-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/schoolfee-financing.png') ?>"
                                         alt="your image" class="target"/>
                                </div>
                                <h3 class="feed-heading">post_title</h3>
                                <div class="author-s">
                                    <div class="author list-data"><i class="fas fa-user"></i><span>author.name</span>
                                    </div>
                                    <div class="source"><i class="fas fa-link"></i><Span>source_name</Span></div>
                                </div>
                                <p class="feed-content">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum
                                    has
                                    been the industry's standard dummy text ever since the 1500s, when an unknown
                                    printer
                                    took a
                                    galley of type and scrambled it to make a type specimen book. It has survived not
                                    only
                                    five
                                    centuries, but also the leap into electronic typesetting, remaining essentially
                                    unchanged.
                                    It was popularised in the 1960s with the release of Letraset sheets containing Lorem
                                    Ipsum
                                    passages, and more recently with desktop publishing software like Aldus PageMaker
                                    including
                                    versions of Lorem Ipsum
                                </p>
                                <div class="feed-btns">
                                    <div class="like-dis">
                                        <a href="javascript:;" class="like-btn default" title="Like">
                                            <i class="fa fa-thumbs-up"></i></a>
                                    </div>
                                    <div class="feed-share">
                                        <a href="javascript:;" class="fb"
                                           onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                        <a href="javascript:;" class="wts-app"
                                           onclick="window.open('https://api.whatsapp.com/send?text=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <a href="javascript:;"
                                           onclick="window.open('https://twitter.com/intent/tweet?text=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');"
                                           class="tw">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="javascript:;" class="male"
                                           onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&amp;url=' + window.location.href, '_blank', 'width=800,height=400,left=200,top=100');">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.control {
  font-size: 16px;
}
.control__indicator {
  background: #00a0e3 !important;
}
.control__indicator:after {
    left: 8px !important;
    top: 3px !important;
    width: 5px !important;
    height: 11px !important;
    border: solid #fff;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}
.nd-shadow {
    box-shadow: 0px 1px 10px 2px #eee !important;
}
.pos-stick {
    position: sticky;
    top: 100px;
}

.set-height-s {
    height: 80vh;
    overflow: hidden;
    margin-bottom: 20px;
}

.filterss {
    color: #00a0e3;
    font-family: roboto;
    font-size: 22px;
    padding: 20px 20px 10px;
    margin: 0;
}

.feed-box {
    padding: 20px 20px 15px 20px;
    margin-bottom: 30px;
    position: relative;
}

.feed-box:hover {
    box-shadow: 0 0 10px rgba(0, 0, 0, .3);
    transition: .3s ease;
}

.rec-batch {
    position: absolute;
    right: 25px;
    top: 25px;
    background-color: #fff;
    padding: 5px 8px;
    font-family: roboto;
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 500;
}

.feed-img img {
    width: 100%;
    object-fit: cover;
    min-height: 220px;
    max-height: 320px;
}

.feed-heading a {
    font-size: 18px;
    font-family: roboto;
    text-transform: capitalize;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    cursor: pointer;
    color: #000;
}

.author-s {
    display: flex;
    align-items: center;
    font-family: roboto;
    flex-wrap: wrap;
}

.author, .source {
    margin-right: 10px;
    color: #fff;
    padding: 4px 8px;
    margin-bottom: 10px;
}

.author {
    background-color: #00a0e3;
}

.source {
    background-color: #ff7803;
}

.feed-content {
    text-align: justify;
    font-size: 14px;
    font-family: roboto;
    line-height: 22px;
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.filters-box {
    margin-bottom: 15px;
}

.f-head h3 {
    margin: 15px 0;
    font-size: 20px;
    color: #00a0e3;
}

.filters-main {
    padding: 0px;
    overflow-y: hidden;
    height: calc(100vh - 280px);
    overflow-x: hidden;
    position: relative;
}

.filters-inner-main {
    padding: 0px 20px;
}

.m-filter {
    display: flex;
    flex-wrap: wrap;
}

.m-filter li {
    flex-basis: 49%;
    box-shadow: inset 0 0 4px 0px rgba(0, 0, 0, .1);
    margin: 2px 1px;
    border-radius: 5px;
}

.m-filter li label {
    height: 42px;
    font-family: Roboto;
    color: #333;
    text-align: center;
    display: table;
    position: relative;
    width: 100%;
    margin-bottom: 0;
    cursor: pointer;
}

.m-filter li label div {
    vertical-align: middle;
    display: table-cell;
}

.m-filter li label span {
    position: absolute;
    top: 4px;
    right: 5px;
}

.m-filter li input[type=checkbox] {
    display: none;
}

.m-filter li input:checked + label {
    transition: .2s ease;
    color: #fff;
    background-color: #00a0e3;
}

.check-container {
    font-family: roboto;
    font-size: 14px;
}

.check {
    padding-top: 0px !important;
    visibility: hidden;
}

input:checked + label .check {
    visibility: visible;
}

input.checkbox:checked + label:before {
    content: "";
}

.feed-btns {
    display: flex;
    border-top: 2px solid #eee;
    padding: 10px 0 0;
    flex-wrap: wrap;
    justify-content: space-between;
    position: relative;
}

.like-dis {
    flex-basis: 50%;
}

.feed-share {
    text-align: right;
    display: flex;
    justify-content: space-between;
    flex-basis: 22%;
    align-items: center;
}

.like-btn {
    color: #00a0e3;
    font-size: 20px;
}

.like-btn.default, .recommend-student.default {
    color: #aaa;
}

.recommend-student {
    font-size: 20px;
    margin-left: 15px;
    color: #00a0e3;
}

.wts-app, .fb, .tw, .male {
    width: 25px;
    text-align: center;
    border-radius: 50px;
    height: 25px;
    font-size: 15px;
}

.wts-app {
    background-color: #25D366;
}

.male {
    background-color: #d3252b;
}

.tw {
    background-color: #1c99e9;
}

.fb {
    background-color: #236dce;
}

.wts-app i, .male i, .tw i, .fb i {
    color: white;
    font-size: 14px;
    cursor: pointer;
}

#skillsModal .modal-contents {
    margin: 15vh auto;
    width: 60vw;
    height: 60vh;
    border-radius: 10px;
    overflow: hidden !Important;
}

@media only screen and (max-width: 1200px) {
    .m-filter li {
        flex-basis: 100%;
    }
}

@media only screen and (max-width: 992px) {
    .pos-stick {
        position: inherit;
        top: 0px;
    }

    .m-filter li {
        flex-basis: 20%;
    }

    .set-height-s, .filters-main {
        height: auto;
    }
}

@media only screen and (max-width: 767px) {
    .m-filter li {
        flex-basis: 49%;
    }
}
');
$script = <<<JS
 var ps = new PerfectScrollbar('.filters-main');
JS;
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
?>