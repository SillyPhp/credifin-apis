<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<section class="feeds-form pt-100">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="feed-main nd-shadow">
                    <div class="feed-title">
                        <i class=" icon-layers font-red"></i>
                        <span class="caption-subject bold uppercase">Feed Form</span>
                    </div>
                    <div class="feeds-data row">
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" name="application_title">
                                <label class="control-label" for="application_title">Source Url</label>
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
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <textarea class="form-control"></textarea>
                                <label class="control-label" for="application_title">Short Description</label>
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
.feed-main {
    padding: 20px;
}
.nd-shadow {
    box-shadow: 0px 1px 10px 2px #eee !important;
}
.feed-title {
    border-bottom: 1px solid #eee;
    font-size: 18px;
    font-family: \'Roboto\';
    text-align: center;
    margin-bottom: 15px;
    color: #333;
    padding-bottom: 10px;
    font-weight: 500;
}
');
?>
<?php
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
?>
