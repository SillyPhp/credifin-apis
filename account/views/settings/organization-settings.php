<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="s-tabs">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#email">Email</a></li>
                |
                <li><a data-toggle="tab" href="#menu1">Menu 2</a></li>
                |
                <li><a data-toggle="tab" href="#tab4">Menu 3</a></li>
            </ul>
        </div>
        <div class="portlet light form-fit ">
            <div class="tab-content">
                <div id="email" class="tab-pane fade in active">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-red"></i>
                            <span class="caption-subject font-red sbold uppercase">Email Preference Settings</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10 s-border">
                                <form action="#" class="form-horizontal form-bordered">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left">How Frequently you want to
                                                receive notifications via messages and emails</label>
                                            <div class="col-md-6 text-right">
                                                <div id="frequency" class="s-radios" aria-required="true"
                                                     aria-invalid="false">
                                                    <input type="radio" id="daily" name="frequency" value="0"
                                                           class="gender_radio"/>
                                                    <label class="gender_label" for="daily">Daily</label>
                                                    <input type="radio" id="weekly" name="frequency" value="1"
                                                           class="gender_radio"/>
                                                    <label class="gender_label" for="weekly">Weekly</label>
                                                    <input type="radio" id="off" name="frequency" value="2"
                                                           class="gender_radio" checked/>
                                                    <label class="gender_label" for="off">Off</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left">Get Notification for Applied
                                                Applications</label>
                                            <div class="col-md-6 text-right">
                                                <input type="checkbox" checked class="make-switch"
                                                       id="applied-application" data-size="small">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left">Get Notifications for
                                                Dropped Resume</label>
                                            <div class="col-md-6 text-right">
                                                <input type="checkbox" checked class="make-switch" id="drop-resume"
                                                       data-size="small">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-6 text-left">Get Notifications for
                                                Reviews</label>
                                            <div class="col-md-6 text-right">
                                                <input type="checkbox" checked class="make-switch" id="reviews"
                                                       data-size="small">
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <a href="javascript:;" id="email-submit" class="btn green">
                                                        <i class="fa fa-check"></i> Submit
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-outline grey-salsa">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-red"></i>
                            <span class="caption-subject font-red sbold uppercase">Menu 2</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10 s-border">
                                Content
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab4" class="tab-pane fade">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-red"></i>
                            <span class="caption-subject font-red sbold uppercase">Menu 3</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10 s-border">
                                Content 2
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
<?php
$this->registerCss('
.s-border{
    border: 1px solid #eee;
    padding: 0;
    margin-top: 20px;
}
.s-border .form-bordered .form-group .text-left{
    text-align:left;
}
.s-radios{
    border: solid 1px #c5cdda;
    display: inline-block;
    border-radius: 5px;
    overflow: hidden;
    max-height: 36px;
}
.gender_radio {
    position: absolute;
    visibility: hidden;
    display: none;
}
.gender_label {
    color: #9a929e;
    display: inline-block;
    cursor: pointer;
    font-weight: 400;
    padding: 7px 15px;
    line-height: 19px;
    min-height: 37px;
}
.gender_radio:checked + .gender_label {
    color: #fff;
    background: #00a0e3;
    height: 37px;
}
.s-tabs{
    background-color: #fff;
    padding-top: 10px;
    border-bottom: 1px solid #eee;
}
.s-tabs ul.nav{
    display: inline-block;
    text-align: center;
    width: 100%;
    border: 0px;
    margin: 0px;
}
.s-tabs ul.nav li{
    float: none;
    display: inline-block;
}
.s-tabs ul.nav li a{
    font-size: 18px !important;
    color: #2f353b!important;
}
.s-tabs ul.nav li.active a{
    background-color: #fff;
    border: 0px;
    border-bottom: 1px solid #00a0e3;
    transition: 2s ease-out;
    color: #00a0e3 !important;
}
.bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-primary, .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-primary{
    background: #00a0e3;
}
.portlet-title {
    padding: 17px 20px 10px;
    margin-bottom: 0;
    min-height: 48px;
    border-bottom: 1px solid #eee;
    -webkit-border-radius: 2px 2px 0 0;
    -moz-border-radius: 2px 2px 0 0;
    -ms-border-radius: 2px 2px 0 0;
    -o-border-radius: 2px 2px 0 0;
    border-radius: 2px 2px 0 0;
}
.caption {
    color: #666;
    padding: 10px 0;
    display: inline-block;
    font-size: 18px;
    line-height: 18px;
}
');
$script = <<< JS
function frequency(){
  var frequency = $('input[name="frequency"]');
  frequency.each(function() {
      if($(this).is(':checked')){
          console.log($(this).val());
      }
  });  
}
$(document).on('click', '#email-submit', function() {
    frequency();
    var applied = $('#applied-application').val();
    var resume = $('#drop-resume').val();
    var reviews = $('#reviews').val();
  // var f_email = frequency();
  // console.log(frequency());
})
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/pages/scripts/components-bootstrap-switch.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);