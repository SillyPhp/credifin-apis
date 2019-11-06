<?php

use yii\helpers\Url;

?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="wizard card-like">
                        <form id="add-applications-inErexx">
                            <div class="wizard-header">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php
                                        if (!empty($applications['data'])) {
                                            ?>
                                            <div class="col-sm-9">
                                                <h1 class="text-center">Campus Hiring</h1>
                                            </div>
                                            <div class="col-sm-3 text-right pr-0">
                                                <button style="display:none" type="button"
                                                        class="btn btn-default wizard-prev">
                                                    Previous
                                                </button>
                                                <button type="button" class="btn btn-primary wizard-next">
                                                    Continue
                                                </button>
                                                <button style="display:none" type="submit"
                                                        class="btn btn-primary wizard-subm submit-applications-inErexx">
                                                    Submit
                                                </button>

                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <h1 class="text-center">Campus Hiring</h1>
                                            <?php
                                        }
                                        ?>
                                        <hr/>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-body">
                                <div class="step initial active">
                                    <div class="row">
                                        <?php
                                        if (!empty($applications['data'])) {
                                            ?>
                                            <div class="col-md-12">
                                                <h4>Select Internships for campus hiring.</h4>
                                            </div>
                                            <?php
                                            foreach ($applications['data'] as $app) {
                                                ?>
                                                <div class="col-sm-6 app-list-data-main">
                                                    <input id="<?= $app['application_enc_id']; ?>" type="checkbox"
                                                           name="applications[]"
                                                           value="<?= $app['application_enc_id']; ?>"
                                                           class="app-list-main">
                                                    <label for="<?= $app['application_enc_id']; ?>" class="job_listing">
                                                        <div class="inner-list-main">
                                                            <div class="job-listing-company-logo">
                                                                <img class="company_logo"
                                                                     src="<?= Url::to('@commonAssets/categories/' . $app['icon']); ?>"
                                                                     alt="<?= $app['name']; ?>">
                                                            </div>
                                                            <div class="job-details">
                                                                <div class="job-details-inner">
                                                                    <div class="job-listing-company company"
                                                                         title="<?= $app['name']; ?>">
                                                                        <strong><?= $app['name']; ?></strong></div>
                                                                    <div class="job-location location">
                                                                        <i class="fa fa-map-marker"></i>
                                                                        <?php
                                                                        $lc = [];
                                                                        foreach ($app['locations'] as $loc) {
                                                                            array_push($lc, $loc['name']);
                                                                        }
                                                                        echo ' <span title="' . implode(', ', $lc) . '">' . implode(', ', $lc) . '</span>';
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="job-listing-meta meta">
                                                                    <div class="job-location location"><i
                                                                                class="la la-map-marker"></i>Ukraine
                                                                    </div>
                                                                    <ul class="job-types">
                                                                        <li class="job-type full-time"> <?= $app['type']; ?></li>
                                                                    </ul>
                                                                    <span class="job-published-date date">Last Date To Apply <?= $app['last_date']; ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="error-list"></div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="col-md-12 text-center">
                                                <!--                                                <img src="/assets/themes/ey/images/pages/dashboard/jobinterview.png" class="img-responsive">-->
                                                <h2>No Active Internships found!</h2>
                                                <h4>Create AI Internships to Hire Candidates from Colleges</h4>
                                                <a href="<?= Url::to('/account/internships/create'); ?>"
                                                   class="btn btn-primary">Create AI Internship</a>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="step">
                                    <div class="row">
                                        <?php
                                        if (!empty($applications['data'])) {
                                            ?>
                                            <div class="col-md-12">
                                                <h4>Select Colleges for campus hiring.</h4>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group form-md-line-input form-md-floating-label">
                                                    <div class="md-checkbox">
                                                        <input type="checkbox" id="select-all-colleges" name="selectAll"
                                                               class="md-check">
                                                        <label for="select-all-colleges">
                                                            <span></span>
                                                            <span class="check"></span>
                                                            <span class="box"></span>
                                                            Select All Colleges
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            foreach ($colleges as $clg) {
                                                ?>
                                                <div class="col-sm-6 app-list-data-main">
                                                    <input id="<?= $clg['college_enc_id']; ?>" type="checkbox"
                                                           name="colleges[]" value="<?= $clg['college_enc_id']; ?>"
                                                           class="college-list-main">
                                                    <label for="<?= $clg['college_enc_id']; ?>" class="job_listing">
                                                        <div class="inner-list-main">
                                                            <div class="job-listing-company-logo">
                                                                <img class="company_logo"
                                                                     src="<?= Url::to($clg['logo']); ?>"
                                                                     alt="<?= $clg['name']; ?>">
                                                            </div>
                                                            <div class="job-details">
                                                                <div class="job-details-inner">
                                                                    <!--                                                            <h3 class="job-listing-loop-job__title">-->
                                                                    <?//= $app['name']; ?><!--</h3>-->
                                                                    <div class="job-listing-company company"
                                                                         title="<?= $clg['name']; ?>">
                                                                        <strong><?= $clg['name']; ?></strong></div>
                                                                    <div class="job-location location">
                                                                        <?php
                                                                        if (!empty($clg['city'])) {
                                                                            ?>
                                                                            <i class="fa fa-map-marker"></i> <?= $clg['city']; ?>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="job-listing-meta meta">
                                                                    <div class="job-location location">
                                                                        <i class="la la-map-marker"></i> <?= $clg['city']; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="ch-message">
                                                <p>
                                                    We are partnering with New collages/universities everyday for you.
                                                    We
                                                    will push your Internship there as Well.
                                                    <input type="checkbox" name="subscribed-to-all" checked/>
                                                </p>
                                            </div>
                                            <div class="error-c-list"></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-footer">
                                <div class="row">
                                    <div class="col-xs-12 text-right">
                                        <?php
                                        if (!empty($applications['data'])) {
                                            ?>
                                            <button id="wizard-prev" style="display:none" type="button"
                                                    class="btn btn-default wizard-prev">
                                                Previous
                                            </button>
                                            <button id="wizard-next" type="button" class="btn btn-primary wizard-next">
                                                Continue
                                            </button>
                                            <button id="wizard-subm" style="display:none" type="submit"
                                                    class="btn btn-primary submit-applications-inErexx wizard-subm">
                                                Submit
                                            </button>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.pr-0{
    padding-right:0px;
}
.card-like {
//  margin-top: 50px;
//  margin-bottom: 50px;
//  color: white;
//  background: rgba(0, 0, 0, 0.8);
  border-radius: 6px;
  padding: 50px;
  box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
}
.wizard {
  overflow: hidden;
}
.wizard .wizard-header {
  margin-bottom: 30px;
}
.wizard .wizard-header h1 {
  margin-top: 0;
  margin-bottom: 20px;
}
.wizard .wizard-header h1 small {
  color: #bbb;
}
.wizard .wizard-header hr {
  border-color: #038dab;
  border-top-width: 2px;
  clear:both;
}
.wizard .wizard-header .steps {
  height: 15px;
}
.wizard .wizard-header .steps .wizard-step {
  background: #038dab;
  width: 15px;
  height: 15px;
  display: inline-block;
  margin: 0 10px;
  opacity: 0.2;
  border-radius: 50%;
  transition: all 0.8s;
}
.wizard .wizard-header .steps .wizard-step.active {
  opacity: 1;
}
.wizard .wizard-body {
  position: relative;
  transition: all 0.3s cubic-bezier(0.68, -0.3, 0.37, 0.6);
}
.wizard .wizard-body .step {
  transition: all 0.3s ease-in-out;
  position: absolute;
  width: 100%;
  top: 0;
  right: -100%;
  opacity: 0;
}
.wizard .wizard-body .step.initial {
  position: relative;
}
.wizard .wizard-body .step.off {
  opacity: 0 !important;
  right: 100% !important;
}
.wizard .wizard-body .step.active {
  right: 0;
  margin-left: 0;
  margin-top: 0;
  opacity: 1;
  transition: all 0.4s linear;
  transition-delay: 0.1s;
}
.wizard .wizard-footer {
  margin-top: 30px;
}
.app-list-data > input, .app-list-data-main > input {
  position: absolute;
  left: -9999px;
}
.app-list-data > label {
  display: block;
  position: relative;
  margin: 10px;
  padding: 15px 30px 15px 62px;
  border: 3px solid #fff;
  border-radius: 10px;
  color: #444;
  background-color: #fff;
  box-shadow:0 0 20px rgba(139, 139, 139, 0.2);
  white-space: nowrap;
  cursor: pointer;
  user-select: none;
  transition: background-color .2s, box-shadow .2s;
}
.app-list-data > label::before, .app-list-data-main > label::before {
  content: "";
  display: block;
  position: absolute;
  top: 10px;
  bottom: 10px;
  left: 10px;
  height: 30px;
  width: 30px;
  padding-top: 1px;
  border: 3px solid #666;
  border-radius: 20px;
  transition: background-color .2s;
  font: normal normal normal 14px/1 FontAwesome;
  color: #00a0e3;
  font-size: 22px;
}
.app-list-data-main > label::before{
    border:0px;
    color:#fff;
    z-index:9;
}
.app-list-data > label:hover, .app-list-data > input:focus + label {
  box-shadow: 0 0 10px rgba(146, 146, 146, 0.6);
}
.app-list-data > input:checked + label {
  background-color: #00a0e3;
  color:#fff;
}
.app-list-data > input:checked + label::before, .app-list-data-main >input:checked + label::before {
  content:"\f00c";
  background-color: #fff;
  border-color:#fff;
}
.app-list-data-main >input:checked + label::before{background-color:transparent;}
.app-list-data-main >input:checked + label::after{
    position: absolute;
    top: -37px;
    left: -2px;
    content: "";
    border-top: 59px solid transparent;
    border-right: 49px solid #00a0e3;
    border-bottom: 39px solid transparent;
    -ms-transform: rotate(20deg);
    -webkit-transform: rotate(20deg);
    transform: rotate(51deg);
}
.step.initial.off{
  display: none;
  -webkit-animation-name: hide_tab;
  -webkit-animation-duration: 4s;
  animation-name: hide_tab;
  animation-duration: 4s;
}
@-webkit-keyframes hide_tab {
  from {display: block;}
  to {display: none;}
}
@keyframes hide_tab {
  from {display: block;}
  to {display: none;} 
}
.app-list-data-main:first-child > .job_listing > .inner-list-main, .app-list-data-main:nth-child(2) > .job_listing > .inner-list-main {
    border-top: 1px solid #edeff7;
}
.app-list-data-main:nth-child(odd) > .job_listing > .inner-list-main{
    border-right: 1px solid #edeff7;
}
.job_listing>.inner-list-main {
    padding: 30px 15px;
    border-bottom: 1px solid #edeff7;
    margin: 0;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
    -webkit-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.job-listing-company-logo {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
    text-align: center;
    margin-bottom: 30px;
}
.job-listing-company-logo img {
    width: 80px;
    height: 80px;
}
.job-details {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
    color: #717f86;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.job-details {
    -ms-flex-preferred-size: 0;
    flex-basis: 0%;
    -webkit-box-flex: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
    max-width: 100%;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
}
.job-details-inner {
    line-height: 1.6;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 auto;
    flex: 0 0 auto;
}
.job-details-inner {
    padding-right: 15px;
    -webkit-box-flex: inherit;
    -ms-flex: inherit;
    flex: inherit;
}
.job-listing-loop-job__title {
    font-size: 16px;
    margin-bottom: 0;
    margin-top: 0;
}
.job-details-inner>*+* {
    margin-top: 6px;
}
.job-listing-company strong {
    text-transform: capitalize;
}
.job-details-inner .job-location {
    font-size: 13px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}
.job-listing-meta {
    text-align: right;
}
.job-listing-meta .job-location {
    display: none;
}
.job-types{
    padding-left: 0;
    list-style: none;
}
.job-type {
    font-family: "Quicksand",sans-serif;
    display: inline-block;
    font-weight: 500;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 2px solid transparent;
    -webkit-transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
    transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
    padding: .375rem .75rem;
    font-size: 12px;
    line-height: 16px;
    border-radius: 4px;
    color: #007bff;
    background-color: transparent;
    background-image: none;
    border-color: #007bff;
    width: 110px;
}
.job-type.full-time {
    color: #00a0e3;
    background-color: transparent;
    background-image: none;
    border-color: #00a0e3;
}
.job-type:not(:disabled):not(.disabled) {
    cursor: pointer;
}
.job-published-date {
    display: inline-block;
    color: #888;
    font-size: 13px;
    margin-top: 12px;
}
.job_listing {
    padding-left: 0;
    width: 100%;
    margin-bottom: 0px;
}
.job-listing-company-logo {
    max-width: 110px;
    -webkit-box-flex: 0;
    -ms-flex: 0 0 110px;
    flex: 0 0 110px;
    margin-bottom: 0;
}
.job_listing>.inner-list-main:hover, .job_listing>.inner-list-main:focus {
    color: initial;
    box-shadow: 0 0 30px rgba(0,0,0,.1);
}
.job-type.full-time:hover {
    color: #fff;
    background-color: #00a0e3;
    border-color: #00a0e3;
}
.job-details-inner .job-location.location{
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-box-align: inherit;
    -ms-flex-align: inherit;
    align-items: inherit;
}
.job-details-inner .job-listing-company.company{
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.error-list, .error-c-list{
    text-align:center;
    clear:both;
}
.error-list p, .error-c-list p{
    color:red;
    font-size:18px;
}
.ch-message{
    clear:both;
    padding: 20px 5px;
}
.ch-message p{
    color: #777;
}
.ch-message input{
    display: inline-block;
    margin-top: 5px;
}
.step-title{
    font-weight:500;
    margin-bottom:30px;
}
');
$script = <<< JS
$(document).on('change','input[name=selectAll]', function() {
    if($(this).is(':checked')){
        allChecked();
    } else {
        allUnChecked(); 
    }
});
function allChecked() {
  $('.college-list-main').each(function() {
        $(this).prop('checked', true);
  });
}
function allUnChecked() {
  $('.college-list-main').each(function() {
        $(this).prop('checked', false);
  });
}
// Checking button status ( wether or not next/previous and
// submit should be displayed )
const checkButtons = (activeStep, stepsCount) => {
  const prevBtn = $(".wizard-prev");
  const nextBtn = $(".wizard-next");
  const submBtn = $(".wizard-subm");

  switch (activeStep / stepsCount) {
    case 0: // First Step
      prevBtn.hide();
      submBtn.hide();
      nextBtn.show();
      break;
    case 1: // Last Step
      nextBtn.hide();
      prevBtn.show();
      submBtn.show();
      break;
    default:
      submBtn.hide();
      prevBtn.show();
      nextBtn.show();
  }
};

// Scrolling the form to the middle of the screen if the form
// is taller than the viewHeight
const scrollWindow = (activeStepHeight, viewHeight) => {
  if (viewHeight < activeStepHeight) {
    $(window).scrollTop($(steps[activeStep]).offset().top - viewHeight / 2);
  }
};

// Setting the wizard body height, this is needed because
// the steps inside of the body have position: absolute
const setWizardHeight = activeStepHeight => {
  $(".wizard-body").height(activeStepHeight);
};

$(function() {
  // Form step counter (little cirecles at the top of the form)
  const wizardSteps = $(".wizard-header .wizard-step");
  // Form steps (actual steps)
  const steps = $(".wizard-body .step");
  // Number of steps (counting from 0)
  const stepsCount = steps.length - 1;
  // Screen Height
  const viewHeight = $(window).height();
  // Current step being shown (counting from 0)
  let activeStep = 0;
  // Height of the current step
  let activeStepHeight = $(steps[activeStep]).height();

  checkButtons(activeStep, stepsCount);
  setWizardHeight(activeStepHeight);
  
  // Resizing wizard body when the viewport changes
  $(window).resize(function() {
    setWizardHeight($(steps[activeStep]).height());
  });

  // Previous button handler
  $(".wizard-prev").click(() => {
    // Sliding out current step
    $(steps[activeStep]).removeClass("active");
    $(wizardSteps[activeStep]).removeClass("active");

    activeStep--;
    
    // Sliding in previous Step
    $(steps[activeStep]).removeClass("off").addClass("active");
    $(wizardSteps[activeStep]).addClass("active");

    activeStepHeight = $(steps[activeStep]).height();
    setWizardHeight(activeStepHeight);
    checkButtons(activeStep, stepsCount);
  });

  // Next button handler
  $(".wizard-next").click(() => {
      var validated = false;
      $('.app-list-main').each(function() {
            if($(this).is(':checked')){
                validated = true;
                return true;
            }
        });
        if(validated){
            $('.error-list').html('');
            // Sliding out current step
            $(steps[activeStep]).removeClass("inital").addClass("off").removeClass("active");
            $(wizardSteps[activeStep]).removeClass("active");
        
            // Next step
            activeStep++;
            
            // Sliding in next step
            $(steps[activeStep]).addClass("active");
            $(wizardSteps[activeStep]).addClass("active");
        
            activeStepHeight = $(steps[activeStep]).height();
            setWizardHeight(activeStepHeight);
            checkButtons(activeStep, stepsCount);
        } else {
            $('.error-list').html('<p>Please Select any Internship</p>');
        }
  });
});

$(document).on('submit', '#add-applications-inErexx', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var valdidate_form = false;
      $('.college-list-main').each(function() {
            if($(this).is(':checked')){
                valdidate_form = true;
                return true;
            }
        });
    if(valdidate_form){
        $('.error-c-list').html('');
        $('.wizard-prev').prop('disabled', true);
        var me = $('.submit-applications-inErexx');
        if ( me.data('requestRunning') ) {
            return false;
        }
        me.data('requestRunning', true);
        var url = '/account/internships/submit-erexx-applications';
        var data = $('#add-applications-inErexx').serialize();
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            beforeSend: function (){
                $('.submit-applications-inErexx').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                $('.submit-applications-inErexx').prop('disabled', true);
            },
            success: function (response) {
                if (response.status == 200) {
                    toastr.success(response.message, response.title);
                } else {
                    toastr.error(response.message, response.title);
                    $('.submit-applications-inErexx').prop('disabled', false);
                }
                $('.submit-applications-inErexx').html('Submit');
                // function explode(){
                     window.location.replace('/account/internships/dashboard'); 
                // }
                // setTimeout(explode, 2000);
            },
            complete: function() {
            me.data('requestRunning', false);
          }
        });
    } else {
        $('.error-c-list').html('<p>Please Select any College</p>');
    }
});
JS;
$this->registerJs($script);
