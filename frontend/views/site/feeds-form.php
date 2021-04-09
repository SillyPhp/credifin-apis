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
                        <div class="col-md-6 mb-30 mt-20">
                            <div class="content-t mb-20">Cover Image</div>
                            <img src="#" alt="your image" class="target set-w" />
<!--                            <label for="file">Choose image</label>-->
                            <input type="file" id="file" />
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
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" name="application_title">
                                <label class="control-label" for="application_title">Source Url</label>
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
                                <select class="form-control set-opt" name="status">
                                    <option>Select Source</option>
                                    <option>Youtube</option>
                                    <option>Udemy</option>
                                    <option>Wikipedia</option>
                                    <option>Spotify</option>
                                    <option>Blogger</option>
                                    <option>Inforgraphic</option>
                                </select>
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
                            <div class="form-group form-md-line-input form-md-floating-label dis-flex">
                                <div class="check-b">
                                    <div class="content-t">Skills</div>
                                    <input type="checkbox" id="switch"/>
                                    <label for="switch" class="lab-set">Toggle</label>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input form-md-floating-label mb-10">
                                <input type="text" class="form-control" id="skills" name="application_title">
                                <label class="control-label" for="application_title">Add Skills</label>
                            </div>
                            <ul class="skills-list" id="skill-scroll">
                                <li class="tagAdd taglist"></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label dis-flex">
                                <div class="check-b">
                                    <div class="content-t">Industries</div>
                                    <input type="checkbox" id="switch1"/>
                                    <label for="switch1" class="lab-set">Toggle</label>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input form-md-floating-label mb-10">
                                <div class="ui fluid multiple search selection dropdown form-control test-sem">
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
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" name="application_title">
                                <label class="control-label" for="application_title">Full Description</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="submit-b">
                                <a href="">SUBMIT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-view-main nd-shadow feed-main">
                    <div class="form-data">
                        <div class="view-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/schoolfee-financing.png') ?>">
                        </div>
                        <div class="view-heading marg-se bold">
                            <p>FARAAR - GURINDER GILL | SHINDA KAHLON | AP DHILLON</p>
                        </div>
                        <div class="form-url marg-se">
                            <a href="https://kulwinder.eygb.me/site/feeds-form" target="_blank">https://kulwinder.eygb.me/site/feeds-form</a>
                        </div>
                        <div class="view-source marg-se">
                            <p>Type: <span class="bold">Blog</span></p>
                            <p>Source: <span class="bold">youtube</span></p>
                            <p>Author: <span class="bold">sohal</span></p>
                        </div>
                        <div class="view-desc marg-se">
                            <p>Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing
                                industries for previewing layouts and visual mockups.</p>
                        </div>
                        <div class="view-skil marg-se">
                            <div class="content-t class=" bold
                            "">Skills
                        </div>
                        <ul class="skills-show">
                            <li>test</li>
                            <li>test2</li>
                            <li>test3</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<?php
$this->registerCss('
.set-w {
    width: 100px;
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
    padding: 20px;
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
input[type=checkbox] {
  height: 0;
  width: 0;
  visibility: hidden;
}
.lab-set {
    cursor: pointer;
    text-indent: -9999px;
    width: 40px;
    height: 25px;
    background: #999;
    display: block;
    border-radius: 100px;
    position: relative;
}
.lab-set:after {
  content: "";
  position: absolute;
  top: 5px;
  left: 5px;
  width: 15px;
  height: 15px;
  background: #fff;
  border-radius: 90px;
  transition: 0.3s;
}
input:checked + .lab-set {
  background: #00a0e3;
}
input:checked + .lab-set:after {
  left: calc(100% - 5px);
  transform: translateX(-100%);
}
.lab-set:active:after {
  width: 20px;
}
ul.skills-list {
    display: flex;
    position: relative;
    min-height: 45px;
    max-height: 150px;
    scroll-behavior: smooth;
    align-items: flex-start;
    justify-content: flex-start;
    flex-wrap: wrap;
}
ul.skills-list li {
    background-color: #00a0e3;
    margin: 0 8px 8px 0;
    color: #fff;
    font-family: Roboto;
    padding: 4px 5px 4px 10px;
    border-radius: 4px;
}
.test-sem{height:auto !important;}
.form-data{font-family:roboto;}
.marg-se {
    margin: 10px 0;
}
.view-img img {
    height: 180px;
    object-fit: cover;
    width: 100%;
}
.marg-se p {
    font-size: 15px;
}
.form-url a {
    font-size: 15px;
    color: #00a0e3;
}
ul.skills-show li {
    background-color: #00a0e3;
    color: #fff;
    padding: 4px 10px;
    margin: 5px 5px 0px 0px;
    border-radius: 4px;
}
ul.skills-show {
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    flex-wrap: wrap;
}
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
');
$script = <<<JS
$(document).on('keypress','#skills',function (e){
    if(e.which == 13){
    var  value = $(this).val();
    if(value){
        $('<li class="addedTag">'+ value+'<span class="tagRemove" onclick="$(this).parent().remove()"><i class="fa fa-times"></i></span></li>').insertBefore('.skills-list .tagAdd');
        $('#skills').val('');
        }
    }
})
var ps = new PerfectScrollbar('#skill-scroll');
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
?>
