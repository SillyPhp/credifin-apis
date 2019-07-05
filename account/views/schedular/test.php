<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\Pjax;
?>

<div class="image-container set-full-height" style="">
    <!--   Big container   -->
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <!--      Wizard container        -->
                <div class="wizard-container">
                    <div class="card wizard-card" data-color="red" id="wizard">
                        <div class="wizard-header">
                            <h3 class="wizard-title">
                                Schedule Interview
                            </h3>
                        </div>
                        <div class="wizard-navigation">
                            <ul>
                                <li><a href="#captain" data-toggle="tab">Interview Type</a></li>
                                <li><a href="#description" data-toggle="tab">Interview Details</a></li>
                                <li><a href="#details" data-toggle="tab">Add Another Detail</a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane" id="captain">
                                <?php
                                echo $this->render('/widgets/scheduler/interview_type')
                                ?>
                            </div>

                            <div class="tab-pane" id="description">
                                <?php
                                echo $this->render('/widgets/scheduler/interview_details')
                                ?>
                            </div>

                            <div class="tab-pane" id="details">
                                <?php
                                echo  $this->render('/widgets/scheduler/interviewer_details')
                                ?>
                            </div>

                        </div>
                        <div class="wizard-footer">
                            <div class="pull-right">
                                <input type='button' class='btn btn-next btn-fill btn-danger btn-wd' name='next' value='Next' />
                                <input type='button' class='btn btn-finish btn-fill btn-danger btn-wd' name='finish' id="finish" value='Finish' />
                            </div>
                            <div class="pull-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div> <!-- wizard container -->
            </div>
        </div> <!-- row -->
    </div> <!--  big container -->
</div>

<script id="dates" type="text/template">
    {{#.}}
    <div class="col-sm-6">
        <label class="headings">Select Interview Timing for {{date}}</label>
        <div class="col-sm-6 secondary-time-from">
            <input type="text" class="timepicker timepicker-24" id="time_from" placeholder="from">
        </div>
        <div class="col-sm-6 secondary-time-to">
            <input type="text" class="timepicker timepicker-24" id="time_to" placeholder="to">
        </div>

        <div id="times-container" class="times-cont"></div>
        <div class="col-md-12">
            <a href="#" id="add-more"><i class="fa fa-plus-circle"></i> Add more</a>
        </div>
    </div>
    {{/.}}
</script>
<script id="add-more-d" type="text/template">
    <div id="added-date" class='col-sm-12'>
        <div class="row" style="margin-top: 10px;">
            <div class="col-sm-6 added-time-from">
                <input type="text" class="timepicker timepicker-24" id="time_from" placeholder="from">
            </div>
            <div class="col-sm-6 added-time-to">
                <input type="text" class="timepicker timepicker-24" id="time_to" placeholder="to">
            </div>
        </div>
        <a class='remove-add'>
            <i class='fa fa-times'></i>
        </a>
    </div>
</script>
<script id="add-more-interviewers-detail" type="text/template">
    <div class="col-md-12 col-sm-12 added-interviewers interviewers">
        <div class="col-md-4 col-sm-4">
            <label for="int_name" class="form-label">Name of Interviewer</label>
            <input type="text" name="int_name" class="int_name">
        </div>
        <div class="col-md-4 col-sm-4">
            <label for="int_email" class="form-label">Email of Interviewer</label>
            <input type="text" name="int_email" class="int_email">
        </div>
        <div class="col-md-4 col-sm-4">
            <label for="int_phone" class="form-label">Phone Number of Interviewer</label>
            <input type="number" name="int_phone" class="int_phone">
        </div>
        <a class='remove-added-interviewers'>
            <i class='fa fa-times'></i>
        </a>
    </div>
</script>
<script id="select-application" type="text/template">
    <select name="rounds" id="rounds">
        <option value="select" data-url='images/icon-vietnam.png'><img src="images/icon-vietnam.png" alt=""> Select</option>
        {{#applications}}
        <option value="{{application_enc_id}}" data-url='images/icon-vietnam.png'><img src="images/icon-vietnam.png" alt=""> {{application_name}}</option>
        {{/applications}}
    </select>
</script>
<script id="select-candidate" type="text/template">
    <label class="form-label">Select Candidates</label>
    <div class="select-group">
        <div class="ui fluid multiple search selection dropdown test-multi">
            <input type="hidden" name="country">
            <i class="dropdown icon"></i>
            <div class="default text">Select Candidate</div>
            <div class="menu">
                {{#appliedcandidates}}
                    <div class="item" data-value="{{user_enc_id}}"><img
                                src="{{image}}"
                                class="af flag">{{full_name}}
                    </div>
                {{/appliedcandidates}}
            </div>
        </div>
    </div>
</script>
<script id="select-round" type="text/template">
    <label for="location" class="form-label">Select Interview Round</label>
    <div class="select-group">

        <select name="location" id="location">
            <option value="select" data-url='images/icon-vietnam.png'><img
                        src="images/icon-vietnam.png" alt=""> Select Round
            </option>
            {{#interviewrounds}}
            <option value="{{field_enc_id}}" data-url='images/icon-vietnam.png'><img
                        src="images/icon-vietnam.png" alt=""> {{field_label}}
            </option>
            {{/interviewrounds}}
        </select>

    </div>
</script>
<script id="number-of-candidates" type="text/templates">
    <div class="form-row" id="number_candidate_cont">
        <div class="form-group" id="no_cand_cont">
            <label for="candidates" class="form-label">Enter Number of Candidates</label>
            <input type="number" name="candidates" id="candidates">
        </div>
    </div>
</script>
<script id="main-timings" type="text/template">
    <div class="col-sm-6" id="main_time_from">
        <label for="time_from" class="form-label">Select Interview Timing</label>
        <input type="text" class="timepicker timepicker-24" id="time_from" placeholder="from">
    </div>
    <div class="col-sm-6" id="main_time_to">
        <label for="time_to" class="form-label">Select Interview Timing</label>
        <input type="text" class="timepicker timepicker-24" id="time_to" placeholder="to">
    </div>
</script>
<script id="interview-locations-temp" type="text/template">
    <div id="interview_locations" class="form-group">
        <label for="location" class="form-label">Select Interview Location</label>
        <div class="select-group">
            <select name="interview-location" id="interview-location">
                <option value="">Select Location</option>
                {{#interviewlocation}}
                <option value="{{interview_location_enc_id}}">{{name}}</option>
                {{/interviewlocation}}
            </select>
        </div>
    </div>/
</script>
<script id="error-msg" type="text/template">
    <div class="error-msg">{{msg}}</div>
</script>
<?php
$this->registerCss('
.error-msg{
    padding-left:5px;
    color:#bb2124;
}
.nav-pills>li+li{
    margin-left:0px;
}
.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover{
    background-color: transparent;
}
.datepicker>div {
    display: block;
}
.wizard-container{
    padding: 30px 0px;
}
.bootstrap-timepicker-hour, .bootstrap-timepicker-minute, .bootstrap-timepicker-meridian{
    display: initial;
    padding: 0;
    background-color: transparent;
}
.select-group{height: 50px}
.float_to_left {
    float: left;
    width: auto;
    margin: 5px 10px 0px 0px !important;
}
input.float_to_left{margin-top: 8.7px !important;}
.remove-add, .remove-added-interviewers{
    position: absolute;
    top: 22px;
    right: -2px;
}
.remove-added-interviewers{
    top: 35px;
    right: 10px;
    color: #555;
}
#selected-dates{
    width: 100%;
}
#selected-dates .headings{
    margin-left: 15px;
}
#add-more, #add-more-interviewers{
    color:#555;
    margin-top: 5px;
    display: block;
    text-align: right;
}
#interview-location{
    width: 100%;
    padding: 13px 20px;
    background-color: #f8f8f8;
    border-color: transparent;
    border-radius: 5px;
}
#fixed_tab, #flexible_tab{
    display: none;
}
.label.ui.transition.visible{
    color:#555;
    padding: 2px 15px 2px 2px;
}
.label.ui.transition.visible img{
    width: 40px !important;
}
.ui.noamimate, .ui.noamimate * {
    -webkit-transition: none!important;
    -moz-transition: none!important;
    -ms-transition: none!important;
    transition: none!important;
}
#collapseOne.collapse.in, #collapseOne_1.collapse.in{
    height:auto !important;
}
.panel-group .panel+.panel {
    margin-top: 18px;
}
.nav-pills>li>a{pointer-events:none;}
#rounds{
    max-height: 235px;
    overflow-y: scroll;
}
');
$script = <<< JS

$('.btn-next.btn-fill.btn-danger.btn-wd').css('display','none');
$('#same-timings-cont').append(Mustache.render($('#main-timings').html()));

$(document).on('change', '#interview_type_fixed', function(){
    if($(this).is(':checked')){
        $('#collapseOne').addClass('in');
    }
});
$(document).on('change', '#interview_type_flexible', function(){
    if($(this).is(':checked')){
        $('#collapseOne_1').addClass('in');
    }
});

JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/plugins/schedular/css/semantic.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');
$this->registerCssFile('@backendAssets/plugins/schedular/css/material-bootstrap-wizard.css');
$this->registerCssFile('@backendAssets/plugins/schedular/css/acc-wizard.min.css');
$this->registerCssFile('@backendAssets/plugins/schedular/css/style.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/plugins/schedular/js/jquery.bootstrap.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/plugins/schedular/js/material-bootstrap-wizard.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/plugins/schedular/js/acc-wizard.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/plugins/schedular/js/additional-methods.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/plugins/schedular/js/jquery.steps.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/plugins/schedular/js/semantic.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/plugins/schedular/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
