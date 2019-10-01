<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="wizard card-like">
                    <form id="add-applications-inErexx">
                        <div class="wizard-header">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h1 class="text-center">
                                        Welcome to an amazing Experience
                                        <!--                                        <br>-->
                                        <!--                                        <small>Provide us some details to get you started-->
                                        <!--                                        </small>-->
                                    </h1>
                                    <hr/>
                                    <!--                                    <div class="steps text-center">-->
                                    <!--                                        <div class="wizard-step active"></div>-->
                                    <!--                                        <div class="wizard-step"></div>-->
                                    <!--                                        <div class="wizard-step"></div>-->
                                    <!--                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="wizard-body">
                            <div class="step initial active">
                                <div class="row">
                                    <?php
                                    foreach ($applications['data'] as $app) {
                                        ?>
                                        <div class="col-sm-6">
                                            <div class="form-group app-list-data">
                                                <input id="<?= $app['application_enc_id']; ?>" type="checkbox" name="applications[]" value="<?= $app['application_enc_id']; ?>">
                                                <label for="<?= $app['application_enc_id']; ?>"><?= $app['name']; ?></label>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="step">
                                <div class="row">
                                    <?php
                                    foreach ($colleges as $clg) {
                                        ?>
                                        <div class="col-sm-6">
                                            <div class="form-group app-list-data">
                                                <input id="<?= $clg['college_enc_id']; ?>" type="checkbox" name="colleges[]" value="<?= $clg['college_enc_id']; ?>">
                                                <label for="<?= $clg['college_enc_id']; ?>"><?= $clg['name']; ?></label>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!--                            <div class="step">-->
                            <!--                                <div class="row">-->
                            <!--                                    <div class="col-sm-6">-->
                            <!--                                        <div class="form-group">-->
                            <!--                                            <label for="firstname">First Name:</label>-->
                            <!--                                            <input type="text" class="form-control" id="firstname">-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                    <div class="col-sm-6">-->
                            <!--                                        <div class="form-group">-->
                            <!--                                            <label for="lastname">Last Name:</label>-->
                            <!--                                            <input type="text" class="form-control" id="lastname">-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                                <div class="row">-->
                            <!--                                    <div class="col-sm-6">-->
                            <!--                                        <div class="form-group">-->
                            <!--                                            <label for="email">Email address:</label>-->
                            <!--                                            <input type="email" class="form-control" id="email">-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                    <div class="col-sm-6">-->
                            <!--                                        <div class="form-group">-->
                            <!--                                            <label for="repeatEmail">Repeat Email address:</label>-->
                            <!--                                            <input type="email" class="form-control" id="repeatEmail">-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                                <div class="row">-->
                            <!--                                    <div class="col-sm-6">-->
                            <!--                                        <div class="form-group">-->
                            <!--                                            <label for="password">Password:</label>-->
                            <!--                                            <input type="password" class="form-control" id="password">-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                    <div class="col-sm-6">-->
                            <!--                                        <div class="form-group">-->
                            <!--                                            <label for="repeatPassword">Repeat Password:</label>-->
                            <!--                                            <input type="password" class="form-control" id="repeatPassword">-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                                <div class="row">-->
                            <!--                                    <div class="col-sm-6">-->
                            <!--                                        <div class="form-group">-->
                            <!--                                            <label for="password">Password:</label>-->
                            <!--                                            <input type="password" class="form-control" id="password">-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                    <div class="col-sm-6">-->
                            <!--                                        <div class="form-group">-->
                            <!--                                            <label for="repeatPassword">Repeat Password:</label>-->
                            <!--                                            <input type="password" class="form-control" id="repeatPassword">-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </div>
                        <div class="wizard-footer">
                            <div class="row">
                                <div class="col-xs-12 text-right">
                                    <button id="wizard-prev" style="display:none" type="button" class="btn btn-default">
                                        Previous
                                    </button>
                                    <button id="wizard-next" type="button" class="btn btn-primary">
                                        Next
                                    </button>
                                    <button id="wizard-subm" style="display:none" type="submit" class="btn btn-primary submit-applications-inErexx">
                                        Submit
                                    </button>
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
.app-list-data > input {
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

.app-list-data > label::before {
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
.app-list-data > label:hover, .app-list-data > input:focus + label {
  box-shadow: 0 0 10px rgba(146, 146, 146, 0.6);
}
.app-list-data > input:checked + label {
  background-color: #00a0e3;
  color:#fff;
}
.app-list-data > input:checked + label::before {
  content:"\f00c";
  background-color: #fff;
  border-color:#fff;
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
');
$script = <<< JS
// Checking button status ( wether or not next/previous and
// submit should be displayed )
const checkButtons = (activeStep, stepsCount) => {
  const prevBtn = $("#wizard-prev");
  const nextBtn = $("#wizard-next");
  const submBtn = $("#wizard-subm");

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
  $("#wizard-prev").click(() => {
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
  $("#wizard-next").click(() => {
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
  });
});

$(document).on('submit', '#add-applications-inErexx', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    // if(valdidate_form){
        console.log('request');
        var me = $('.submit-applications-inErexx');
        if ( me.data('requestRunning') ) {
            return false;
        }
        me.data('requestRunning', true);
        var url = '/account/jobs/submit-erexx-applications';
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
                     window.location.replace('/account/jobs/dashboard'); 
                // }
                // setTimeout(explode, 2000);
            },
            complete: function() {
            me.data('requestRunning', false);
          }
        });
    // }
});
JS;
$this->registerJs($script);
