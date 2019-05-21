
<!--    <link rel="stylesheet" type="text/css" href="./semantic.min.css">-->
<!--    <link href="http://ajay.eygb.me/assets/themes/dashboard/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" />-->
<!--    <link href="http://ajay.eygb.me/assets/themes/dashboard/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />-->
<!--    <link href="assets/css/material-bootstrap-wizard.css" rel="stylesheet" />-->
<!--    <link rel="stylesheet" href="./acc-wizard.min.css">-->
<!--    <link href="assets/css/style.css" rel="stylesheet" />-->

<div class="image-container set-full-height" style="">


    <!--   Big container   -->
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <!--      Wizard container        -->
                <div class="wizard-container">
                    <div class="card wizard-card" data-color="red" id="wizard">
                        <!-- <form action="" method=""> -->
                        <!--        You can switch " data-color="blue" "  with one of the next bright colors: "green", "orange", "red", "purple"             -->

                        <div class="wizard-header">
                            <h3 class="wizard-title">
                                Schedule Interview
                            </h3>
                            <!-- <h5>This information will let us know more about you.</h5> -->
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
                                <h4 class="info-text">Select Interview Type </h4>
                                <div class="row">
                                    <form>
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <div class="choice" title="This is good if you travel alone.">
                                                    <input type="radio" id="interview_type_fixed" name="interview_type" value="fixed">
                                                    <label for="interview_type_fixed" class="icon">
                                                        <i class="fa fa-link"></i>
                                                    </label>
                                                    <h6>Fixed</h6>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="choice" title="Select this room if you're traveling with your family.">
                                                    <input type="radio" id="interview_type_flexible" name="interview_type" value="flexible">
                                                    <label for="interview_type_flexible" class="icon">
                                                        <i class="fa fa-link"></i>
                                                    </label>
                                                    <h6>Flexible</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane" id="description">
                                <!-- <div id="fixed_tab" class="row"> -->
                                <!-- <div class="select-options">
                                  <input id="toggle1" type="checkbox">
                                  <label for="toggle1">Toggle me!</label>

                                  <input id="toggle2" type="checkbox">
                                  <label for="toggle2">Hey, me too!</label>
                                </div> -->

                                <!-- </div> -->
                                <!-- <div id="flexible_tab" class="row"> -->

                                <!-- </div> -->
                            </div>
                            <div class="tab-pane" id="details">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="info-text"> Add Interviewer details.</h4>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="col-md-4 col-sm-4">
                                                    <label for="int_name" class="form-label">Name of Interviewer</label>
                                                    <input type="text" name="int_name" id="int_name">
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <label for="int_email" class="form-label">Email of Interviewer</label>
                                                    <input type="text" name="int_email" id="int_email">
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <label for="int_phone" class="form-label">Phone Number of Interviewer</label>
                                                    <input type="number" name="int_phone" id="int_phone">
                                                </div>
                                            </div>
                                            <div id="more-interviewers"></div>
                                        </div>
                                        <!-- <div class="row"> -->
                                        <div class="col-md-12 col-sm-12">
                                            <a href="#" id="add-more-interviewers"><i class="fa fa-plus-circle"></i> Add More</a>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-footer">
                            <div class="pull-right">
                                <input type='button' class='btn btn-next btn-fill btn-danger btn-wd' name='next' value='Next' />
                                <input type='button' class='btn btn-finish btn-fill btn-danger btn-wd' name='finish' value='Finish' />
                            </div>
                            <div class="pull-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <!-- </form> -->
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
        <div class="col-sm-6">
            <input type="text" class="timepicker timepicker-24" id="time_from" placeholder="from">
        </div>
        <div class="col-sm-6">
            <input type="text" class="timepicker timepicker-24" id="time_to" placeholder="to">
        </div>

        <div id="times-container"></div>
        <div class="col-md-12">
            <a href="#" id="add-more"><i class="fa fa-plus-circle"></i> Add more</a>
        </div>
    </div>
    {{/.}}
</script>
<script id="add-more-d" type="text/template">
    <div id="added-date" class='col-sm-12'>
        <div class="row" style="margin-top: 10px;">
            <div class="col-sm-6">
                <input type="text" class="timepicker timepicker-24" id="time_from" placeholder="from">
            </div>
            <div class="col-sm-6">
                <input type="text" class="timepicker timepicker-24" id="time_to" placeholder="to">
            </div>
        </div>
        <a class='remove-add'>
            <i class='fa fa-times'></i>
        </a>
    </div>
</script>
<script id="add-more-interviewers-detail" type="text/template">
    <div class="col-md-12 col-sm-12 added-interviewers">
        <div class="col-md-4 col-sm-4">
            <label for="int_name" class="form-label">Name of Interviewer</label>
            <input type="text" name="int_name" id="int_name">
        </div>
        <div class="col-md-4 col-sm-4">
            <label for="int_email" class="form-label">Email of Interviewer</label>
            <input type="text" name="int_email" id="int_email">
        </div>
        <div class="col-md-4 col-sm-4">
            <label for="int_phone" class="form-label">Phone Number of Interviewer</label>
            <input type="number" name="int_phone" id="int_phone">
        </div>
        <a class='remove-added-interviewers'>
            <i class='fa fa-times'></i>
        </a>
    </div>
</script>
<script id="fixed_tab" type="text/template">
    <div class="acc-wizard">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading" id="headingOne">
                    <h3>
                        <a href="#collapseOne" data-toggle="collapse" data-parent="#accordion" aria-expanded="true">Basic infomation</a>
                    </h3>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="POST">
                            <fieldset>
                                <div class="form-row">
                                    <div class="form-select">
                                        <label for="rounds" class="form-label">Select Round</label>
                                        <div class="select-group">

                                            <select name="rounds" id="rounds">
                                                <option value="" data-url='images/icon-vietnam.png'><img src="images/icon-vietnam.png" alt=""> Select</option>
                                                <option value="Viet Nam" data-url='images/icon-vietnam.png'><img src="images/icon-vietnam.png" alt=""> Round 1</option>
                                                <option value="USA" data-url='images/icon-usa.png'><img src="images/icon-usa.png" alt="">Round 2</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-select">
                                        <label for="location" class="form-label">Select Placement Location</label>
                                        <div class="select-group">

                                            <select name="location" id="location">
                                                <option value="" data-url='images/icon-vietnam.png'><img src="images/icon-vietnam.png" alt=""> Select Location</option>
                                                <option value="Viet Nam" data-url='images/icon-vietnam.png'><img src="images/icon-vietnam.png" alt=""> Vietnam</option>
                                                <option value="USA" data-url='images/icon-usa.png'><img src="images/icon-usa.png" alt="">USA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" id="headingTwo">
                    <h3>
                        <a href="#collapseTwo" data-toggle="collapse" data-parent="#accordion">Additional infomation</a>
                    </h3>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form method="post">
                            <fieldset>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="datepicker" class="form-label">Select Interview Dates</label>
                                        <input class="date-picker" placeholder="Select Dates" size="16" type="text" id="datepicker" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label for="time_from" class="form-label">Select Interview Timing</label>
                                            <input type="text" class="timepicker timepicker-24" id="time_from" placeholder="from">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="time_to" class="form-label">Select Interview Timing</label>
                                            <input type="text" class="timepicker timepicker-24" id="time_to" placeholder="to">
                                        </div>
                                        <div class="col-md-12">
                                            <input type="checkbox" id="all-dates" class="float_to_left" name="" checked>
                                            <label for="all-dates" class="float_to_left">For all Interview Dates</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div id="selected-dates"></div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" id="headingThree">
                    <h3>
                        <a href="#collapseThree" data-toggle="collapse" data-parent="#accordion">Specialities</a>
                    </h3>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form method="post">
                            <fieldset>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Select Mode</label>
                                        <div class="col-sm-6">
                                            <input type="radio" id="inplace" class="float_to_left" value="1" name="mode" checked="checked"/>
                                            <label for="inplace" class="float_to_left">Inplace</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="radio" id="online" class="float_to_left" value="2" name="mode">
                                            <label for="online" class="float_to_left">Online</label>
                                        </div>
                                    </div>
                                    <div id="interview_locations" class="form-group">
                                        <label for="location" class="form-label">Select Interview Location</label>
                                        <div class="select-group">
                                            <select name="interview-location" id="interview-location">
                                                <option value="">Select Location</option>
                                                <option value="jk">Vietnam</option>
                                                <option value="xzfgd">USA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="candidates" class="form-label">Enter Number of Candidates</label>
                                        <input type="number" name="candidates" id="candidates">
                                    </div>
                                </div>
                            </fieldset>
                            <!--  <div class="form-submit">
                                 <input type="submit" value="Submit" class="au-btn">
                             </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
<script id="flexible_tab" type="text/template">
    <div class="acc-wizard">
        <div class="panel-group" id="accordion_1">
            <div class="panel panel-default">
                <div class="panel-heading" id="headingOne">
                    <h3>
                        <a href="#collapseOne_1" data-toggle="collapse" data-parent="#accordion_1">Basic infomation</a>
                    </h3>
                </div>

                <div id="collapseOne_1" class="panel-collapse collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form method="POST">
                            <fieldset>
                                <div class="form-row">
                                    <div class="form-select">
                                        <label class="form-label">Select Candidates</label>
                                        <div class="select-group">
                                            <div class="ui fluid multiple search selection dropdown test-multi">
                                                <input type="hidden" name="country">
                                                <i class="dropdown icon"></i>
                                                <div class="default text">Select Country</div>
                                                <div class="menu">
                                                    <div class="item" data-value="af"><img src="https://design.printexpress.co.uk/wp-content/uploads/2016/02/01-avatars.jpg" class="af flag"></i>aaaa</div>
                                                    <div class="item" data-value="ax"><img src="https://design.printexpress.co.uk/wp-content/uploads/2016/02/01-avatars.jpg" class="ax flag"></i>bbb Islands</div>
                                                    <div class="item" data-value="al"><img src="https://design.printexpress.co.uk/wp-content/uploads/2016/02/01-avatars.jpg" class="al flag"></i>ccc</div>
                                                    <div class="item" data-value="dz"><img src="https://design.printexpress.co.uk/wp-content/uploads/2016/02/01-avatars.jpg" class="dz flag"></i>ddd</div>
                                                    <div class="item" data-value="as"><img src="https://design.printexpress.co.uk/wp-content/uploads/2016/02/01-avatars.jpg" class="as flag"></i>aa Samoa</div>
                                                    <div class="item" data-value="ad"><img src="https://design.printexpress.co.uk/wp-content/uploads/2016/02/01-avatars.jpg" class="ad flag"></i>ab</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-select">
                                        <label for="location" class="form-label">Select Placement Location</label>
                                        <div class="select-group">

                                            <select name="location" id="location">
                                                <option value="" data-url='images/icon-vietnam.png'><img src="images/icon-vietnam.png" alt=""> Select Location</option>
                                                <option value="Viet Nam" data-url='images/icon-vietnam.png'><img src="images/icon-vietnam.png" alt=""> Vietnam</option>
                                                <option value="USA" data-url='images/icon-usa.png'><img src="images/icon-usa.png" alt="">USA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" id="headingTwo">
                    <h3>
                        <a href="#collapseTwo_2" data-toggle="collapse" data-parent="#accordion_1">Additional infomation</a>
                    </h3>
                </div>
                <div id="collapseTwo_2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form method="post">
                            <fieldset>

                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
<?php
$this->registerCss('
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
');
$script = <<< JS
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

