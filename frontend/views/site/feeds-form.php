<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<section class="feeds-form pt-100">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="feed-main nd-shadow">
                    <div class="feed-title">Feed Form</div>
                    <div class="feeds-data row">
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" name="application_title">
                                <label class="control-label" for="application_title">Source Url</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="content-t">Content Type</div>
                            <div class="form-group form-md-line-input form-md-floating-label dis-flex">
                                <div class="md-radio">
                                    <input id="md-radio2" name="hogehoge1" type="radio" value="Test2">
                                    <label for="md-radio2">Video</label>
                                </div>
                                <div class="md-radio">
                                    <input id="md-radio3" name="hogehoge1" type="radio" value="Test2">
                                    <label for="md-radio3">Blog</label>
                                </div>
                                <div class="md-radio">
                                    <input id="md-radio4" name="hogehoge1" type="radio" value="Test2">
                                    <label for="md-radio4">News</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-30">
                            <div class="content-t mb-20">Cover Image</div>
                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/schoolfee-financing.png') ?>"
                                 alt="your image" class="target set-w"/>
                            <div class="custom-file">
                                <input type="file" id="file" class="imgInp custom-file-input"
                                       aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="file">Choose Image</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" name="application_title">
                                <label class="control-label" for="application_title">Heading</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <div class="ui fluid search selection dropdown form-control test-sem"
                                     style="height: 45px !important;">
                                    <input type="hidden" name="country">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Select Source</div>
                                    <div class="menu">
                                        <div class="item" data-value="af"><i class="af flag"></i>Youtube</div>
                                        <div class="item" data-value="ax"><i class="ax flag"></i>Spotify</div>
                                        <div class="item" data-value="al"><i class="al flag"></i>Apple tv</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" name="application_title">
                                <label class="control-label" for="application_title">Embed Code</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" name="application_title">
                                <label class="control-label" for="application_title">Author Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <textarea class="form-control height-s"></textarea>
                                <label class="control-label" for="application_title">Short Description</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-skill content-t">
                                <input type="checkbox" class="checkboxx" checked>Skills
                            </label>
                            <div class="form-group form-md-line-input form-md-floating-label mb-10">
                                <div class="ui fluid multiple search selection dropdown form-control test-sem"
                                     style="min-height: 45px;">
                                    <input type="hidden" name="tags">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Skills</div>
                                    <div class="menu">
                                        <div class="item" data-value="html">HTML</div>
                                        <div class="item" data-value="css">CSS</div>
                                        <div class="item" data-value="design">Graphic Design</div>
                                        <div class="item" data-value="javascript">Javascript</div>
                                        <div class="item" data-value="angular">Angular</div>
                                        <div class="item" data-value="ember">Ember</div>
                                        <div class="item" data-value="node">NodeJS</div>
                                        <div class="item" data-value="python">Python</div>
                                        <div class="item" data-value="rails">Rails</div>
                                        <div class="item" data-value="ruby">Ruby</div>
                                        <div class="item" data-value="ui">UI Design</div>
                                        <div class="item" data-value="ux">User Experience</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="checkbox-skill content-t">
                                <input type="checkbox" class="checkboxx" checked>Industries
                            </label>
                            <div class="form-group form-md-line-input form-md-floating-label mb-10">
                                <div class="ui fluid multiple search selection dropdown form-control test-sem"
                                     style="min-height: 45px;">
                                    <input type="hidden" name="tags">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Industries</div>
                                    <div class="menu">
                                        <div class="item" data-value="html">HTML</div>
                                        <div class="item" data-value="css">CSS</div>
                                        <div class="item" data-value="design">Graphic Design</div>
                                        <div class="item" data-value="javascript">Javascript</div>
                                        <div class="item" data-value="angular">Angular</div>
                                        <div class="item" data-value="ember">Ember</div>
                                        <div class="item" data-value="node">NodeJS</div>
                                        <div class="item" data-value="python">Python</div>
                                        <div class="item" data-value="rails">Rails</div>
                                        <div class="item" data-value="ruby">Ruby</div>
                                        <div class="item" data-value="ui">UI Design</div>
                                        <div class="item" data-value="ux">User Experience</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-20 mb-30">
                            <div id="editor"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="submit-b">
                                <a href="">SUBMIT</a>
                                <a href="">PREVIEW</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feed-box dash-inner-box nd-shadow">
                    <!--                    <div class="rec-batch">Recommended</div>-->
                    <div class="feed-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/schoolfee-financing.png') ?>"
                             alt="your image" class="target"/>
                    </div>
                    <h3 class="feed-heading">
                        <a href="">post_title</a>
                    </h3>
                    <div class="author-s">
                        <div class="author list-data">
                            <i class="fas fa-user"></i><span> Sohal</span>
                        </div>
                        <div class="source">
                            <i class="fas fa-link"></i><Span> Youtube</Span>
                        </div>
                    </div>
                    <p class="feed-content">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only five centuries,
                        but also the leap into electronic typesetting, remaining essentially unchanged. It was
                        popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,
                        and more recently with desktop publishing software like Aldus PageMaker including versions of
                        Lorem Ipsum
                    </p>
                    <div class="feed-btns">
                        <div class="like-dis">
                            <a href="javascript:;" class="like-btn default" title="Like"><i class="fa fa-thumbs-up"></i></a>
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
</section>
<?php
$this->registerCss('
.checkbox-skill {
  position: relative;
  margin: 0.5rem;
  font-family: Arial, sans-serif;
  line-height: 135%;
  cursor: pointer;
}

.checkboxx {
//  position: relative;
  top: -0.375rem;
  margin: 0 1rem 0 0 !important;
  cursor: pointer;
}
.checkboxx:before {
  -webkit-transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
  content: "";
  position: absolute;
  left: 0;
  z-index: 1;
  width: 1rem;
  height: 1rem;
  border: 2px solid #f2f2f2;
}
.checkboxx:checked:before {
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
  transform: rotate(-45deg);
  height: 0.5rem;
  border-color: #00a0e3;
  border-top-style: none;
  border-right-style: none;
}
.checkboxx:after {
  content: "";
  position: absolute;
  top: -0.125rem;
  left: 0;
  width: 1.1rem;
  height: 1.1rem;
  background: #fff;
  cursor: pointer;
}

body {
    background-image: url(/assets/themes/ey/images/backgrounds/campus-hiring.png) !important;
    background-size: cover !important;
    background-attachment: fixed !important;
    background-repeat: no-repeat !important;
}
.custom-file {
    position: relative;
    width: 130px;
    cursor: pointer;
}
.custom-file-input {
    position: relative;
    z-index: 2;
    cursor: pointer;
    width: 100%;
    height: calc(2.25rem + 2px);
    margin: 0;
    opacity: 0;
}
.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    padding: 8px 10px;
    line-height: 1.5;
    cursor: pointer;
    color: #fff;
    background-color: #00a0e3;
    border-radius: .25rem;
    font-family: Roboto;
    text-align: center;
    font-size: 15px;
}
.set-w {
    width: 130px;
    height: 100px;
    object-fit: cover;
    padding: 5px;
    margin-bottom: 10px;
    border-radius: 4px;
    box-shadow: 0 0 6px 0px rgb(0 0 0 / 20%);
}
body{font-family:roboto;}
.height-s{height:45px !important;}
.feed-main {
    background-color:#fffffffa;
    padding: 20px;
    margin-bottom: 30px;
}
.nd-shadow {
    box-shadow: 0px 1px 10px 2px #eee !important;
}
.feed-title {
    border-bottom: 1px solid #eee;
    font-size:22px;
    font-family: \'Roboto\';
    text-align: center;
    margin-bottom: 15px;
    color: #333;
    padding-bottom: 10px;
    font-weight: 500;
}
.content-t {
    color: #999;
    font-size: 16px;
    font-family: Roboto;
    font-weight:500 !important;
}
.dis-flex{
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex-wrap: wrap;
    margin-bottom: 20px !important;
}
.md-radio {
    margin: 0px 25px 10px 0;
}
.md-radio input[type="radio"] {
  display: none;
}
.md-radio input[type="radio"]:checked + label:before {
  border-color: #00a0e3;
  animation: ripple 0.2s linear forwards;
}
.md-radio input[type="radio"]:checked + label:after {
  transform: scale(1);
}
.md-radio label {
    display: inline-block;
    position: relative;
    padding: 0 0 0 25px;
    margin-bottom: 0;
    color: #555;
    font-family:Roboto;
    cursor: pointer;
    vertical-align: bottom;
}
.md-radio label:before,
.md-radio label:after {
  position: absolute;
  content: "";
  border-radius: 50%;
  transition: all 0.3s ease;
  transition-property: transform, border-color;
}
.md-radio label:before {
  left: 0;
  top: 0;
  width: 20px;
  height: 20px;
  border: 2px solid rgba(0, 0, 0, 0.54);
  box-sizing: border-box;
}
.md-radio label:after {
  top: 5px;
  left: 5px;
  width: 10px;
  height: 10px;
  transform: scale(0);
  background: #00a0e3;
}
.test-sem{height:auto !important;}
.submit-b {
    text-align: center;
}
.submit-b a {
    background-color: #00a0e3;
    color: #fff;
    padding: 10px 40px;
    border-radius: 4px;
    display: inline-block;
    font-family: Roboto;
    font-weight: 500;
}
.ui.multiple.dropdown>.label{
    background-color: #00a0e3;
    color: #fff;
    font-weight: 400;
    font-family: Roboto;
    box-shadow:none;
    padding: 7px 10px;
}
a.ui.active.label:hover, a.ui.labels .active.label:hover{
    background-color: #00a0e3;
    color: #fff;
}
.ui.dropdown .menu>.item{
    font-size: 14px;
    font-family: Roboto;
}
.ui.dropdown .menu .selected.item, .ui.dropdown.selected, .ui.dropdown .menu>.item:hover {
    background: #00a0e3;
    color: #fff;
}
.feed-box {
    padding: 20px 20px 15px 20px;
    margin-bottom: 30px;
    position: relative;
    background-color:#fffffffa;
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
    font-size: 13px;
    padding-top: 3px;
    margin:0 1px;
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
');
$script = <<<JS
 CKEDITOR.replace('editor', {
      // Define the toolbar groups as it is a more accessible solution.
      toolbarGroups: [{
          "name": "basicstyles",
          "groups": ["basicstyles"]
        },
        {
          "name": "links",
          "groups": ["links"]
        },
        {
          "name": "paragraph",
          "groups": ["list", "blocks", "align"]
        },
        {
          "name": "document",
          "groups": ["mode"]
        },
        {
          "name": "insert",
          "groups": ["insert"]
        },
        {
          "name": "styles",
          "groups": ["styles"]
        }
      ],
      // Remove the redundant buttons from toolbar groups defined above.
      removeButtons: 'Source,Smiley,Iframe,Strike,Subscript,Superscript,Styles,Specialchar,Flash,'
    });
$('.test-sem').dropdown();
$(function () {

    "use strict";

    function url(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();
            reader.onload = function (e) {
                $(".target").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

        }
    }
    $("#file").change(function () {
        url(this);
    });
});
JS;
$this->registerCssFile('/assets/themes/dashboard/plugins/schedular/css/semantic.min.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/assets/themes/dashboard/plugins/schedular/js/semantic.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJS($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdn.ckeditor.com/4.16.0/full/ckeditor.js');
?>
