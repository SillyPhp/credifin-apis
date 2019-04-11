<?php

use yii\helpers\Url;
?>
<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'My Channel'); ?></span>
                </div>
                <div class="actions">
                    <!--                    <a href="" class="viewall-jobs">--><?//= Yii::t('account', 'Add New'); ?><!--</a>-->

                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-12">
                        <form>
                            <div class="col-md-12">
                            <div class="fm-heading">Create New Playlist</div>
                            </div>
                            <div class="col-md-4">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" id="form_control_1">
                                <label for="form_control_1">Name</label>
                                <span class="help-block">Enter Playlist Name</span>
                            </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <input type="text" class="form-control" id="form_control_1">
                                    <label for="form_control_1">Category</label>
                                    <span class="help-block">Enter Playlist Category</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <input type="text" class="form-control" id="form_control_1">
                                    <label for="form_control_1">Sub Category</label>
                                    <span class="help-block">Enter Playlist Sub Category</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="fm-heading">Enter Video URL's</div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-md-line-input form-md-floating-label">
                                    <input type="text" class="form-control" id="form_control_1">
                                    <label for="form_control_1">Sub Category</label>
                                    <span class="help-block">Enter Playlist Sub Category</span>
                                </div>
                                <div class="hidden-fields">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-md-line-input form-md-floating-label">
                                                <input type="text" class="form-control" id="form_control_1">
                                                <label for="form_control_1">Name</label>
                                                <span class="help-block">Enter Playlist Name</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-md-line-input form-md-floating-label">
                                                <input type="text" class="form-control" id="form_control_1">
                                                <label for="form_control_1">Category</label>
                                                <span class="help-block">Enter Video Category</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-md-line-input form-md-floating-label">
                                                <input type="text" class="form-control" id="form_control_1">
                                                <label for="form_control_1">Sub Category</label>
                                                <span class="help-block">Enter Video Sub Category</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <textarea class="form-control" rows="4"></textarea>
                                            <label for="form_control_1">Video Description</label>
                                        </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group form-md-line-input form-md-floating-label">
                                                <input type="text" class="form-control" id="form_control_1">
                                                <label for="form_control_1">Tags</label>
                                                <span class="help-block">Enter Related Tags</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$this->registerCss('
textarea{
    resize:none;
}
');