<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

$company_locations = ArrayHelper::map($location_list, 'location_enc_id', 'location_name');
?>

<div class="portlet light " id="form_wizard_1">
    <div class="portlet-title">
        <div class="caption">
            <i class=" icon-layers font-red"></i>
            <span class="caption-subject font-red bold uppercase">Internship Application
                <span class="step-title"> Step 1 of 4</span>
            </span>
        </div>
    </div>
    <div class="portlet light portlet-fit portlet-form">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'submit_form',
                    'enableClientValidation' => true,
                    'fieldConfig' => [
                        'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{error}{hint}</div>",
                    ]
        ]);
        ?>
        <div class="form-wizard">
            <div class="form-body">
                <ul class="nav nav-pills nav-justified steps">
                    <li>
                        <a href="#tab1" data-toggle="tab" class="step">
                            <span class="number"> 1 </span><br/>
                            <span class="desc">
                                <i class="fa fa-check"></i> Basic Information </span>
                        </a>
                    </li>
                    <li>
                        <a href="#tab2" data-toggle="tab" class="step">
                            <span class="number"> 2 </span><br/>
                            <span class="desc">
                                <i class="fa fa-check"></i> Internship Description </span>
                        </a>
                    </li>
                    <li>
                        <a href="#tab3" data-toggle="tab" class="step"> <!-- active--->
                            <span class="number"> 3 </span><br/>
                            <span class="desc">
                                <i class="fa fa-check"></i> Interview Detail </span>
                        </a>
                    </li>
                    <li> 
                        <a href="#tab4" data-toggle="tab" class="step">
                            <span class="number"> 4 </span><br/>
                            <span class="desc">
                                <i class="fa fa-check"></i> Other Details  </span>
                        </a>
                    </li>
                    <li class="step5">
                        <a href="#tab5" data-toggle="tab" class="step">
                            
                        </a>
                    </li>
                </ul>
                <div id="bar" class="progress progress-striped" role="progressbar">
                    <div class="progress-bar progress-bar-success"> </div>
                </div>
                <div class="tab-content">
                    <div class="alert alert-danger display-none">
                        <button class="close" data-dismiss="alert"></button> 
                        You have some form errors. Please check below.
                    </div>
                    <div class="alert alert-success display-none">
                        <button class="close" data-dismiss="alert"></button> 
                        Your Application has been register successful!
                    </div>
                    <div class="tab-pane active" id="tab1">

                        <div class="row">                    
                            <div class="col-md-6">
                                <div class="cat_wrapper">
                                    <img class = "Typeahead-spinner" src="<?= Url::to('@eyAssets/images/pages/jobs/spinner.gif');
                                        ?>" >
                                <?= $form->field($model, 'primaryfield')->textInput(['placeholder'=>'Search Primary Field Here..'])->label(false) ?> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="floating">
                                    <?= $form->field($model, 'internshiptitle')->textInput(['id' => 'internshiptitle'])->label('Internship Title'); ?>
                                </div>

                                <div id="error-msg4"> </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'fieldofwork')->textInput(['id' => 'designation'])->label('Designation'); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'jobtype')->dropDownList(['Full time' => 'Full time', 'Part Time' => 'Part time', 'Work From Home' => 'Work from home'])->label(false); ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div id="radio_rules"></div>
                                <label>Type Of Stipend</label>
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="stipend1" name="InternshipApplicationForm[stipendtype]" value="Unpaid" data-title="1" class="md-radiobtn"> 
                                        <label for="stipend1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Unpaid </label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="stipend2" name="InternshipApplicationForm[stipendtype]" value="Performance Based" data-title="2" class="md-radiobtn"> 
                                        <label for="stipend2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Performance Based </label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="stipend3" name="InternshipApplicationForm[stipendtype]" value="Negotiable" data-title ="3" class="md-radiobtn"> 
                                        <label for="stipend3">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Negotiable </label>
                                    </div>
                                    <div class="md-radio">
                                        <input type="radio" id="stipend4" name="InternshipApplicationForm[stipendtype]" value="Fixed" data-title="4" class="md-radiobtn"> 
                                        <label for="stipend4">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Fixed </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="fixed_stip">
                                    <?= $form->field($model,'stipendpaid')->label('Stipend Paid') ?>
                                </div>
                                
                                <div id="performence_stip">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <?= $form->field($model,'minstip')->label('Min Stipend') ?>
                                        </div>
                                        <div class="col-md-6">
                                            <?= $form->field($model,'maxstip')->label('Max Stipend') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'internshipduration')->textInput(['autocomplete' => 'off'])->label('Duration'); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'internshipperiod')->dropDownList(['months'=>'Months','weeks'=>'Weeks'])->label(false); ?>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'from')->widget(TimePicker::classname(),['pluginOptions'=>
                                    ['defaultTime'=>'current']])->label('Internship Timing From'); ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'to')->widget(TimePicker::classname())->label('Upto'); ?> 
                            </div>
                            <div class="col-md-4">
                                <?=
                                $form->field($model, 'earliestjoiningdate')->widget(DatePicker::classname(), [
                                    'options' => ['placeholder' => 'Joining Date'],
                                    'readonly' => true,
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd-M-yyyy',
                                        'name' => 'earliestjoiningdate',
                                        'todayHighlight' => true,
                                        'startDate' => '+0d',
                            ]])->label(false);
                                ?>
                            </div>

                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Select Placement Locations</h3>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'placement_loc',['template'=>'{input}'])->hiddenInput(['id'=>'placement_array'])->label(false); ?>
                            </div>
                        </div>   
                        <?php
                        $total = count($location_list);
                        $rows = ceil($total / 3);
                        $next = 0;
                        for ($i = 1; $i <= $rows; $i++) {
                            ?> <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    for ($j = 0; $j < 3; $j++) {
                                        if ($next < $total) {
                                            ?>
                                            <div class="col-md-4">
                                                <input type="checkbox" name="placement_loc" id="<?= $location_list[$next]['location_enc_id']; ?>" value="<?= $location_list['location_enc_id']; ?>" data-value="<?= $location_list[$next]['location_name']; ?>" class="checkbox-input" data-count = "">
                                                <label for="<?= $location_list[$next]['location_enc_id'] ?>" class="checkbox-label">
                                                    <div class="checkbox-text">
                                                        <p class="loc_name_tag"> <?= $location_list[$next]['location_name'] ?> </p>
                                                        <span class="address_tag"><?= $location_list[$next]['address']; ?> </span> <br>   
                                                        <span class="state_city_tag"><?= $location_list[$next]['state_name'] . ', ' . $location_list[$next]['city_name']; ?> </span>
                                                        
                                                  <div class="form-group form-md-line-input">
                                                      <input type="number" class="form-control place_no"  placeholder="No Of Positions" min="1" >
                                                    
                                                </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <?php
                                        }
                                        $next++;
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="tab-pane" id="tab2">
                        <div class="row">
                            <div class="col-md-6">

                                <div id="checkboxlistarea">
                                    <h3 id="heading_placeholder"> Please Select Atleast 3 JD From The List <i class="fa fa-share" aria-hidden="true" ></i> </h3>
                                    <ul class="drop-options connected-sortable droppable-area">

                                    </ul>
                                </div>  

                            </div>
                            <div class="col-md-6">

                                <div class="md-checkbox-list" id="md-checkbox">

                                </div>
                                <div id="error-checkbox-msg"></div> 
                                <?= $form->field($model,'checkboxArray',['template'=>'{input}'])->hiddenInput(['id'=>'checkbox_array']); ?>

                                <div id="manual_questions">
                                    <input type="text" class="form-control" id="question_field" placeholder="Type Custom JD And Press Enter..">
                                </div>

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                                <?=
                                $form->field($model, 'othrdetail')->textarea(['rows' => 6, 'cols' => 50])->label('Any Other Detail');
                                ?>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class = "skill_wrapper">
                                    <img class = "Typeahead-spinner" src="<?= Url::to('@eyAssets/images/pages/jobs/spinner.gif');
                                        ?>" >
                                    <input type="text"  id="inputfield" name="inputfield" class="form-control" placeholder = "Enter Required Skills" >
                                    
                                    <input type="text" name="skill_counter" id="skill_counter" readonly  >
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div id="suggestionbox" >

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class = "placeble-area" >

                                    <div id="shownlist"> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'specialskillsrequired',['template'=>'{input}'])->hiddenInput(['id' => 'specialskillsrequired'])->label(false); ?>
                                <?= $form->field($model, 'skillsArray',['template'=>'{input}'])->hiddenInput(['id' => 'skillsArray'])->label(false); ?>            
                            </div>

                        </div>
                    </div>

                    <div class="tab-pane" id="tab3">
                        <h3>Walk In Interview Details </h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio11" name="interview-radio" value="1" class="md-radiobtn"> 
                                        <label for="radio11">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Yes </label>
                                    </div>
                                    <div class="md-radio ">
                                        <input type="radio" id="radio12" name="interview-radio" value="2"  class="md-radiobtn">
                                        <label for="radio12">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> No </label>
                                    </div>

                                </div>
                            </div>
                            <div id="error-checkbox-msg3"></div>
                        </div>

                        <div id="interview_box">  
                            <div class="row">

                                <div class="col-md-6">
                                        
                                 <?= DatePicker::widget([
                                        'model' => $model,
                                        'attribute' => 'startdate',
                                        'id'=>'interview_range',
                                        'attribute2' => 'enddate',
                                        'options' => ['placeholder' => 'Start From'],
                                        'options2' => ['placeholder' => 'End Date'],
                                        'type' => DatePicker::TYPE_RANGE,
                                        'form' => $form,
                                        'pluginOptions' => [
                                            'format' => 'yyyy-mm-dd',
                                            'autoclose' => true,
                                            'startDate'=>'+0d',
                                        ]
                                    ]);
                                    ?>
                                </div>    
                                <div class="col-md-3">
                                    <?= $form->field($model, 'interviewstarttime')->widget(TimePicker::classname())->label('Starts From'); ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($model, 'interviewendtime')->widget(TimePicker::classname())->label('End'); ?>
                                </div>
                                </div>
                                <?php
                                Modal::begin([
                                    'header' => "Please Fill Up The Details",
                                    'id' => 'location-modal',
                                    'size' => 'modal-lg',
                                ]);

                                echo "<div id='message'></div>";
                                echo "<div id= 'modal-content'></div>";

                                Modal::end();
                                ?>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <h3 class="interview_location_tag">Select Interview Locations </h3>

                                </div>
                                <div class="col-md-8">
                                    <div class="button_location">
                                        <?= Html::button('Add New Location', ['value' => URL::to('/account/jobs/add-location'), 'class' => 'btn btn-primary modal-load-class']); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            Pjax::begin(['id' => 'pjax_locations']);
                            $total = count($location_list);
                            $rows = ceil($total / 3);
                            $next = 0;
                            for ($i = 1; $i <= $rows; $i++) {
                                ?> <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                        for ($j = 0; $j < 3; $j++) {
                                            if ($next < $total) {
                                                ?>
                                                <div class="col-md-4">
                                                    <input type="checkbox" name="InternshipApplicationForm[interviewcity][]" id="<?= $next . $location_list[$next]['location_enc_id']; ?>" value="<?= $location_list[$next]['location_enc_id']; ?>" data-value="<?= $location_list[$next]['location_name']; ?>" class="checkbox-input">
                                                    <label for="<?= $next . $location_list[$next]['location_enc_id'] ?>" class="checkbox-label">
                                                        <div class="checkbox-text">
                                                            <p class="loc_name_tag"> <?= $location_list[$next]['location_name'] ?> </p>
                                                            <span class="address_tag"><?= $location_list[$next]['address']; ?> </span> <br>   
                                                            <span class="state_city_tag"><?= $location_list[$next]['state_name'] . ', ' . $location_list[$next]['city_name']; ?> </span>   

                                                        </div>
                                                    </label>
                                                </div>
                                                <?php
                                            }
                                            $next++;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                            Pjax::end();
                            ?>
                        </div> 
                    </div>

                    <div class="tab-pane" id="tab4">
                        <h3 class="block">Enter Questions</h3>
                        <div class="row">

                            <div class="col-md-12">
                                <div class="md-radio-inline">
                                    <div class="md-radio">
                                        <input type="radio" id="radio1" name="question-radio" value="1" class="md-radiobtn"> 
                                        <label for="radio1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Use Existing Questions </label>
                                    </div>
                                    <div class="md-radio ">
                                        <input type="radio" id="radio2" name="question-radio" value="2"  class="md-radiobtn">
                                        <label for="radio2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> Build Your Own Questions </label>
                                    </div>
                                    <div class="md-radio ">
                                        <input type="radio" id="radio3" name="question-radio" value="3" class="md-radiobtn">
                                        <label for="radio3">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> No </label>
                                    </div>
                                </div>
                            </div>

                            <div id="error-checkbox-msg2"> </div>


                        </div>
                        <div id="question_dropdown">
                            <?php
                            Pjax::begin(['id' => 'pjax_questionnaire']);
                            $total = count($questions_list);
                            $rows = ceil($total / 2);
                            $next = 0;
                            for ($i = 1; $i <= $rows; $i++) {
                                ?>      
                                <div class="row">

                                    <?php
                                    for ($j = 0; $j < 2; $j++) {
                                        if ($next < $total) {
                                            ?>

                                            <div class="col-md-offset-1 col-md-10"> 
                                                <div class="radio_questions">
                                                    <div class="inputGroup">
                                                        <input id="<?= $questions_list[$next]['questionnaire_enc_id']; ?>" name="InternshipApplicationForm[questionnaire]" type="radio" value="<?= $questions_list[$next]['questionnaire_enc_id']; ?>"/>
                                                        <label for="<?= $questions_list[$next]['questionnaire_enc_id']; ?>"> <?= $questions_list[$next]['questionnaire_name']; ?> </label>
                                                    </div>
                                                </div>
                                            </div>    
                                            <?php
                                        }
                                        $next++;
                                    }
                                    ?> 
                                </div>
                                <?php
                            }
                            Pjax::end();
                            ?>
                        </div>

                        <a onclick="window.open('/account/questionnaire', '_blank', 'width=1200,height=900,left=200,top=100');">

                            <?= Html::button('Build your Form', ['class' => 'btn btn-success btn-md ', 'id' => 'add']); ?> 
                        </a>

                    </div>
                    <div class="tab-pane" id="tab5">
                        <h3 class="block">Confirm your Details</h3>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Primary Field:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[primaryfield]" id="fieldvalue"> </p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Internship Title:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[internshiptitle]"> </p>
                                </div>
                            </div>
                        </div>         
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Designation:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[fieldofwork]"> </p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Internship Type:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[jobtype]"> </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                             
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Joining Date:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[earliestjoiningdate]"> </p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Stipend Type:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[stipendtype]"> </p>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                             
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Duration:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[internshipduration]"> </p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Internship Period:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[internshipperiod]"> </p>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Special Skills:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[specialskillsrequired]" id="skillvalues"> </p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Stipend Amount:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[stipendpaid]"> </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Minimum Stipend:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[minstip]"> </p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Maximum:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[maxstip]"> </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Timing From:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[from]"> </p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Upto:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[to]"> </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Interview Start:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[startdate]" > </p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Interview End:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[enddate]"> </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Interview Start Time:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[interviewstarttime]" > </p>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-6">Interview End Time:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[interviewendtime]"> </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label col-md-3">Internship Description:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[checkbox][]" id="chackboxvalues"> </p>
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label col-md-3">Placement Locations (No. of positions):</label>
                                <div class="col-md-9">
                                    <p class="form-control-static" data-display="placement_loc" id="placement_locations" > </p>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-9">
                                <label class="control-label col-md-4">Interview Location:</label>
                                <div class="col-md-8">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[interviewcity][]" id="interviewcitycityvalues" > </p>
                                </div>
                                <?= $form->field($model, 'getinterviewcity',['template'=>'{input}'])->hiddenInput(['id' => 'getinterviewcity'])->label(false) ?>
                            </div>
                            <div class="form-group col-md-3">

                                <div class="col-md-12">
                                    <p class="form-control-static" data-display="randomfunc"> </p>
                                    <?= $form->field($model, 'mainfield')->hiddenInput(['id' => 'primary_hidden'])->label(false) ?> 
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label col-md-3">Brief Description:</label>
                                <div class="col-md-9">
                                    <p class="form-control-static" data-display="InternshipApplicationForm[othrdetail]"> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="loading_img">

          </div>
            <div class="form-actions">
                <div class="row ">
                    <div class="col-md-offset-3 col-md-9 text-right btn-preview">
                        

                        <a href="javascript:;" class="btn default button-previous">
                            <i class="fa fa-angle-left"></i>
                            Back
                        </a>
                        <a href="javascript:;" class="btn btn-outline green button-next">
                            Continue
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <?= Html::button('Submit', ['class' => 'btn green button-submit']) ?>

                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
<?php
Modal::begin([
    'id' => 'job_position_modal',
    'header' => 'Fill Up The Details',
    'size' => 'modal-sm',
]);
?>
<form id="position_form" action="#" role="form" >
    <div class="modal-body">

        <h3>No Of Positions</h3>
        <input type="text" name="no_position" id="no_position" class="form-control">



    </div>
    <div class="modal-footer">
        <!-- <button type="button" name="submit" class="btn btn-primary" id="update">Update</button> -->
        <button href="#" class="btn btn-primary" id="update">Update</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>
<div class="fader"></div>
<?php Modal::end(); ?>



<?php
$this->registerCss("
    
.typeahead,
.tt-query,
 {
  width: 396px;
  height: 30px;
  padding: 8px 12px;
  font-size: 18px;
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
  color: #999
}
.tt-menu {
  width: 422px;
  margin: 12px 0;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 18px;
  line-height: 24px;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.cat_wrapper .Typeahead-spinner {
    position: absolute;
    right: 20px;
    bottom: 40px;
    display: none;
}

.skill_wrapper .Typeahead-spinner
{
    position: absolute;
    top: 3px;
    z-index: 999;
    right: 20px;
    display:none;
    
}


.Typeahead-input {
    position: relative;
    background-color: transparent;
    outline: none;
}

.twitter-typeahead {
    
    width: 100% !important;
}

.step5
{
 display:none !important;
}
#bar
{
height:17px !important;
}
.inputGroup {
  background-color: #fff;
  display: block;
  margin: 10px 0;
  position: relative;
}
.inputGroup label {
   padding: 6px 75px 10px 25px;
    width: 96%;
    display: block;
    margin:auto;
    text-align: left;
    color: #3C454C;
    cursor: pointer;
    position: relative;
    z-index: 2;
    transition: color 1ms ease-out;
    overflow: hidden;
    border-radius: 8px;
    border:1px solid #eee;
}
.inputGroup label:before {
  width: 100%;
  height: 10px;
  border-radius: 50%;
  content: '';
  background-color: #00a0e3;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%) scale3d(1, 1, 1);
  transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
  opacity: 0;
  z-index: -1;
}
.inputGroup label:after {
  width: 32px;
  height: 32px;
  content: '';
  border: 2px solid #D1D7DC;
  background-color: #fff;
  background-repeat: no-repeat;
  background-position: 2px 3px;
  background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
  border-radius: 50%;
  z-index: 2;
  position: absolute;
  right: 30px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  transition: all 200ms ease-in;
}
.inputGroup input:checked ~ label {
  color: #fff;
}
.inputGroup input:checked ~ label:before {
  transform: translate(-50%, -50%) scale3d(56, 56, 1);
  opacity: 1;
}
.inputGroup input:checked ~ label:after {
  background-color: #54E0C7;
  border-color: #54E0C7;
}
.inputGroup input {
  width: 32px;
  height: 32px;
  order: 1;
  z-index: 2;
  position: absolute;
  right: 30px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  visibility: hidden;
}

.radio_questions {
  padding: 0 16px;
  max-width: 100%;

  font-size: 18px;
  font-weight: 600;
  line-height: 36px;
}

#skill_counter
{opacity:0;
cursor:default;}

.rule-text4
{color:#e9465d;}

.interview_location_tag
{
 padding: 0px 20px;
}

.checkbox-input {
  display: none;
}

q:before, q:after, blockquote:before, blockquote:after {
  content: '';
  content: none;
}
.checkbox-label, .checkbox-text, .checkbox-text--description {
  transition: all 0.4s ease;
}
.checkbox-label:before {
    content: attr(data-before);
    position: absolute;
    color: #efecec;
    text-align: center;
    top: 75%;
    padding: 5px 4px;
    font-size: 18px;
    font-weight: 600;
    right: 16px;
    width: 36px;
    height: 36px;
    opacity: 0;
    background-color: #2196F3;
    background-position: center;
    background-repeat: no-repeat;
    background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
    background-size: 100%;
    border-radius: 50%;
    background-position: 3px 4px;
    -webkit-transform: translate(0%, -50%);
    transform: translate(0%, -50%);
    transition: all 0.4s ease;
}

  


.checkbox-label {
    display: inline-block;
    vertical-align: top;
    position: relative;
    width: 100%;
    padding: 5px 29px;
    cursor: pointer;
    
    font-weight: 400;
    margin: 16px 0;
    border: 1px solid #d9d9d9;
    
    border-radius: 2px;
    box-shadow: inset 0 0 0px 0 #2196F3;
}

#heading_placeholder
{
  font-size:23px;
}

.checkbox-text--title {
  font-weight: 500;
}
.checkbox-text--description {
  font-size: 14px;
  margin-top: 16px;
  padding-top: 10px;
  border-top: 1px solid #2196F3;
      margin-bottom: 10px;
}
.checkbox-text--description .un {
  display: none;
}

.checkbox-input:checked + .checkbox-label {
  border-color: #2196F3;
  box-shadow: inset 0 -12px 0 0 #2196F3;
}
.checkbox-input:checked + .checkbox-label:before {
  top: 0;
  opacity: 1;
}
.checkbox-input:checked + .checkbox-label .checkbox-text {
  -webkit-transform: translate(0, -8px);
  transform: translate(0, -8px);
}
.checkbox-input:checked + .checkbox-label .checkbox-text--description {
  border-color: #d9d9d9;
}
.checkbox-input:checked + .checkbox-label .checkbox-text--description .un {
  display: inline-block;
}

 
.state_city_tag
{font-size:14px;}

.address_tag
{font-size: 13px;}
#existing_location

{
 padding:6px 0px;
}


.floating{
  float: left;
  width: 33.3333%;
  margin: 2rem 0 1rem;
  position: relative;
}
.materialize-tags ~ input ~ label {
  color: #999 !important;
  padding: 1rem !important;
  position: absolute !important;
  top: 12px !important;
  left: 0 !important;
  -webkit-transition: .2s ease all !important;
  transition: .2s ease all !important;
  pointer-events: none !important;
}
.materialize-tags ~ input ~ .infocus, .materialize-tags ~ input ~ .active{
 font-size: 12px !important;
 color: #999 !important;
 top: -2.25rem !important;
 -webkit-transition: .2s ease all !important;
 transition: .2s ease all !important;
}
.chip i.material-icons
{
      line-height: 29px !important;
}
.chip {
    display: inline-block;
    height: 26px;
    font-size: 14px;
    font-weight: 500;
    font-weight: 500;
    color: rgba(0, 0, 0, 0.6);
    line-height: 28px;
    padding: 0px 12px;
    border-radius: 16px;
    background-color: #e4e4e4;
    margin-bottom: 4px;
    margin-right: 5px;
    margin-top: 0px;
}

.chip .close {
  cursor: pointer;
  float: right;
  font-size: 16px;
  line-height: 32px;
  padding-left: 8px;
}

span.chip .fa-times
{    cursor: pointer;
    float: right;
    font-size: 14px;
    line-height: 28px;
    padding-left: 8px;
}

.jd_heading
{
  margin-top: 0px;
}

.select2-selection select2-selection--single
{
  padding: 4px 11px !important;
}

.loc_name_tag
{
    margin: 5px 0px;
    font-size: 19px;
    padding-top: 6px;
}

#tab4,#tab3
{
  padding: 0px 50px;
}

.rule-text2
{
  padding: 2px 16px;
    color: #e9465d;
}

.md-checkbox {
    position: relative;
    margin-bottom: 8px;
    
}

.field-jobapplicationform-checkbox
{
  margin-top: -22px;
}

.form-group{
    min-height:10px;
}

#md-checkbox
{
   min-height: 267px;
    max-height: 267px;
    overflow-y: scroll;
}

#internshipapplicationform-startdate-kvdate 
{padding:25px;}

#addct
{
     padding: 28px 10px;
    text-align: center;
}

.button_location
{padding: 14px 16px;
float:right;}
.close-drp_down
{
    position: absolute;
    font-size: 16px;
    right: -26px;
    color: #a2a2a2;
    bottom: 16px;

}

.place_no
{
    margin-bottom: 8px;
    margin-top: 8px;
    display:none;
}

.checkbox-text
{
  margin-bottom:8px;
}

.checkbox-text .form-group.form-md-line-input {
   
     padding-top: 0px !important; 
     margin: 0 0 0px !important;
}


.placeble-area
{
  
    border: 1px solid #ccc;
    min-height:130px;
    border-radius: 9px;
    display: flex;
    padding: 5px 14px;
    
}


.drop-options li{
    padding:10px;
}

.connected-sortable {
     margin: 0;
    list-style: none;
    width: 100%;
    padding: 0px;
}



li.draggable-item {
  width: inherit;
  padding: 15px 20px;
  background-color: #f5f5f5;
  cursor:move;
  border-bottom:1px solid #d6cece;
  -webkit-transition: transform .25s ease-in-out;
  -moz-transition: transform .25s ease-in-out;
  -o-transition: transform .25s ease-in-out;
  transition: transform .25s ease-in-out;
  
  -webkit-transition: box-shadow .25s ease-in-out;
  -moz-transition: box-shadow .25s ease-in-out;
  -o-transition: box-shadow .25s ease-in-out;
  transition: box-shadow .25s ease-in-out;
  &:hover {
    cursor: pointer;
    background-color: #eaeaea;
  }
}
/* styles during drag */
li.draggable-item.ui-sortable-helper {
  background-color: #e5e5e5;
  -webkit-box-shadow: 0 0 8px rgba(53,41,41, .8);
  -moz-box-shadow: 0 0 8px rgba(53,41,41, .8);
  box-shadow: 0 0 8px rgba(53,41,41, .8);
  transform: scale(1.015);
  z-index: 100;
}
li.draggable-item.ui-sortable-placeholder {
  background-color: #ddd;
  -moz-box-shadow:    inset 0 0 10px #000000;
   -webkit-box-shadow: inset 0 0 10px #000000;
   box-shadow:         inset 0 0 10px #000000;
}

#hiddenlist{
	display:none;
}

#shownlist{
    display: block;
    clear: both;
    
}

.ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;

        } 

#shownlist span a {
    color: #1d1818;
    text-decoration: none;
    font-weight: 900;
}
#suggestionbox span:hover , #suggestionbox span:hover a{
    background-color: #f07706;
    color:#FFF;
}
#shownlist span:hover , #shownlist span:hover a{
    background-color: #f07706;
    color:#FFF;
}
#suggestionbox span a, .drop-options span a
{
    color: #1d1818;
    text-decoration: none;
    
}
#shownlist span,#suggestionbox span{
    display: block;
    float: left;
    padding: 5px 8px;
    background-color: #e4e3e3;
    color: #1d1818;
    margin: 10px 10px 0 0;
    border-radius: 9px;
}

#checkboxlistarea
{
   border: 1px solid #c2cad8;
    min-height: 288px;
    max-height: 288px;
    overflow-y: scroll;
}

#checkboxlistarea h3
{
    color: #c2cad8;
    padding: 89px 49px;
}

#add_existing_location
{
  margin:-21px;
}

#suggestionbox 
{
margin-top:-10px;
}

.rule-text
{
    position: absolute;
    margin-top: -8px;
    color: #e73d49;
    padding:63px 1px;
}


#testmap {
   width: 100%;
   height: 400px;
   background-color: grey;
 }
 
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('http://www.downgraf.com/wp-content/uploads/2014/09/01-progress.gif?e44397') 50% 50% no-repeat rgb(249,249,249);
}

#loading_img
{
  display:none;
}

#loading_img.show
{
  display : block;
position : fixed;
z-index: 100;
background-image : url('https://cdn.dribbble.com/users/178981/screenshots/1642680/tick.gif');
opacity : 1;
background-repeat : no-repeat;
background-position : center;
width:60%;
height:60%;
left : 20%;
bottom : 0;
right : 0;
top : 20%;
}
.fader{
  width:100%;
  height:100%;
  position:fixed;
  top:0;
  left:0;
  display:none;
  z-index:99;
  background-color:#fff;
  opacity:0.7;
}

");

$script = <<< JS
        
 $(function(){
        
$('#fixed_stip').hide();
$('#performence_stip').hide();
   
$('input[name= "InternshipApplicationForm[stipendtype]"]').on('change',function(){
        var stipendtyp = $(this).attr("data-title");
   if(stipendtyp=='1')
        {
        $('#fixed_stip').hide();
        $('#performence_stip').hide();
        $('#internshipapplicationform-minstip').val('');
        $('#internshipapplicationform-maxstip').val('');
        $('#internshipapplicationform-stipendpaid').val('');
        }
     else if(stipendtyp=='4')
        {
        $('#fixed_stip').show();
        $('#performence_stip').hide();
        $('#internshipapplicationform-minstip').val('');
        $('#internshipapplicationform-maxstip').val('');
        $('#internshipapplicationform-stipendpaid').val('');
        }
     else if(stipendtyp=='2')
        {
          $('#performence_stip').show();
          $('#fixed_stip').hide();
        $('#internshipapplicationform-stipendpaid').val('');
        }
     else if(stipendtyp=='3')
        {
          $('#performence_stip').show();
          $('#fixed_stip').hide();
        $('#internshipapplicationform-stipendpaid').val('');
        }
   })  
   
   })   
var data_before = null;

var checked = null;
var array = [];
        
$('input[name="placement_loc"]').on("click", function() {
    checked = $(this);
    if (this.checked == true) {
        
        checked.next('label').find('.place_no').css('display','block');
        checked.next('label').find('.place_no').blur(value_upd);
        
        function value_upd()
        {
           var pos = checked.next('label').find('.place_no').val();
           checked.attr('data-count', pos);
         }
    } 
        
    else {
      checked.next('label').find('.place_no').css('display','none');
   }    
        
        
});

$('#position_form').validate({
rules: {

no_position: {
required:true,
number:true,
max:1000
},
},

messages: {
no_position:
{
   
   required:'<div class = "alert-danger">this field is required!</div>'
},
},
})      
var global = [];
        
var skills = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/categories-list/skills-data?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#inputfield').typeahead(null, {
  name: 'skill',
  display: 'value',
  source: skills,
   limit: 6,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.skill_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.skill_wrapper .Typeahead-spinner').hide();
     
  }).on('typeahead:selected',function(e, datum)
  {
      var skillsdata = datum.value;
      var value = datum.id;
        addTags(skillsdata,value);
        
        
   });       

var categories = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/categories-list/categories-data?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(list) {
            global = list;
            return list;
        }
  }
});


$('#internshipapplicationform-primaryfield').typeahead(null, {
  name: 'categories',
  display: 'value',
  source: categories,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
    $('.cat_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.cat_wrapper .Typeahead-spinner').hide();
     
  }).on('typeahead:selected',function(e, datum)
  {
      var data = datum.id; 
      skils_update(data);  
      $('#primary_hidden').val(data);  
      $.ajax({
      url:"/categories-list/job-description",
      data:{data:data},
      method:"post",
      success:function(data)
     {
     var obj = JSON.parse(data);
     var html = [];
     $.each(obj,function()
     { 
      html.push ("<div class=\'md-checkbox\'>"+
     "<input type=\'checkbox\' id=\'"+this.job_description_enc_id+"\' value = \'"+this.job_description_enc_id+"\' class=\'md-check\' name = \'InternshipApplicationForm[checkbox][]\'>"+
      "<label for=\'"+this.job_description_enc_id+"\'>"+
      "<span></span>"+
       "<span class=\'check\'></span>"+
       "<span class=\'box\'></span>"+this.job_description+"</label>"+
       "</div>");  
         });
                                                
        $(".md-checkbox-list").html(html); 
                                          
         }
     });  

    }).blur(validateSelection);
    
function skils_update(data)
        {
      $.ajax({
      url:"/categories-list/job-skills",
      data:{data:data},
      method:"post",
      success:function(response)
        {
          var obj = JSON.parse(response);
           var html = [];
     $.each(obj,function()
     { 
      html.push ("<span ><a href='#' class='clickable' data-value = '"+this.skill_enc_id+"'>"  +this.skill+ "</a> </span>");  
         });
                                                
        $("#suggestionbox").html(html);
        }
      });    
        }


        
function validateSelection() {
   var theIndex = -1;
  for (var i = 0; i < global.length; i++) {
  if (global[i].value == $(this).val()) {
  theIndex = i;
 break;
   }
          }
    if (theIndex == -1) {
   $(this).val(""); 
  }

}        
 
 function ChildFunction()
     {
       
       $.pjax.reload({container: '#pjax_questionnaire', async: false});
        $('#radio1').prop('checked', true);
        $('#add').hide();
        $('#question_dropdown').show();
        
     }
window.ChildFunction = ChildFunction;
   
$('#internshiptitle').materialtags({
  maxTags:1
  }) 
      
$('#designation').materialtags({
  maxTags:1
  })       
    
$('.modal-load-class').click(function()
        {
   $('#location-modal').modal('show').find('#modal-content').load($(this).attr('value'));  
        
   });
 $('#add_existing_location').hide();        
 $('#existing_location').on('click',function()
     
   {
     $('#existing_location').hide();   
     $('#add_existing_location').show();   
   })       
        

 $('.close-drp_down').on('click',function()
     
   {
         $('#add_existing_location').hide();
         $('#existing_location').show();
   })

   $('#interview_box').hide();     
   $('#add').hide();
   $('#question_dropdown').hide();     
   $('input[name = "question-radio"]').on('change', function()
       {
         var r = $(this).val();
             
        if(r == 1)
        {
            $('#add').hide();
            $('#question_dropdown').show();  
        }
        else if(r == 2)
        {
        $('#question_dropdown').hide();
           $('#add').show();
        }
        
        else
        {
         $('#question_dropdown').hide();
          $('#add').hide();
        }
        
   })
        
    $('input[name = "interview-radio"]').on('change',function()
        
   {
     var i  = $(this).val();
        if (i==1) 
        {
          $('#interview_box').show();
        }
        else
        {
            $('#interview_box').hide();
         }
   })    
  
        
        
        $('#question_field').keypress(function(e){
        if(e.which == 13){
        
        questions  = $('#question_field').val();
        
        if(questions == "")
        {
         return false;
        }
        else{
             $('#heading_placeholder').hide();
             $(".drop-options").append('<li  value-id="" class="draggable-item"> <i class="fa fa-arrows" aria-hidden="true"></i> ' +questions+ '<span> <a href = "#" class = "pull-right"><i class="fa fa-times"></i></a></span> </li> ');
              
              $('#question_field').val("");
            }
            
        
        } 
    });
        
        
    
        $(document).on('click','.drop-options span a', function(event){
		event.preventDefault();
                var btn = $(this);
                var tag = btn.closest("li").remove();
	});
        
        $(document).on('click','.button-submit',function(event)
            {
            event.preventDefault();
            checkbox_arr();
            skills_arr();
            var array =[];
            $.each($("input[name='placement_loc']:checked"), function(index,value){
            var obj = {};
            obj["id"] = $(this).attr('id');
            obj["value"] = $(this).next('label').find('.place_no').val();
            array.push(obj);
            }); 
            $('#placement_array').val(JSON.stringify(array));
           
             var url =  $('#submit_form').attr('action');
             var data = $('#submit_form').serialize();
                  $.ajax({
                   url: url,
                   type: 'post',
                   data: data,
                   beforeSend: function()
                       {
                         $('#loading_img').addClass('show');
                         $('.button-submit').prop('disabled','disabled');
                         $('.fader').css('display','block');
                       },
                   success: function(data) {
                   if(data == 'success')
                    {
                    function explode(){
                     $('#loading_img').removeClass('show');
                     $('.button-submit').prop('disabled','');
               
                     window.location.href = '/account/jobs/dashboard';
                     }
                       setTimeout(explode, 3000);
                     }
                     else{
                     alert('failed');
                    }
    
                    }            
                     });
                
                });
 
       var skillsdata = null;
       $(document).on('click','.clickable', function(event){
		event.preventDefault();
                skillsdata = $(this).text();
                var value = $(this).attr('data-value');
                
                addTags(skillsdata,value);
        
   });
        
 function getTags(){ //Gets array of existing tags
		var alltags = new Array();
		var i = 0;
		$("#shownlist span").each(function( index ) {
  			alltags[i] = $(this).html().substr(0,$(this).html().length - 36);
			i ++;
		});	
		return alltags;
                
	};
function setTags(){ //Gets string of existing tags separated by commas
		var texttags = getTags();
		var finaltext = "";
		for(var i=0; i<texttags.length; i++){
			if(finaltext == ""){
				finaltext = texttags[i];	
			}
			else{
				finaltext = finaltext + "," + texttags[i];
			}
		}
		return finaltext;
	}
    var count = 0; 
function addTags(skillsdata,value){
		var tags = skillsdata.trim();
		var listnews = "";
		var newtags = "";
		var existenttags = getTags();
		//checks if a comma was left alone at the end and removes it
		if(tags.substr(tags.length - 1) == ","){ 
			tags = tags.substr(0, tags.length -1);	
		}
		//checks if a comma was left alone at the beginning and removes it
		if(tags.substr(0,1) == ","){
			tags = tags.substr(1, tags.length);	
		}
		//if more than one tag was added
		if(tags.indexOf(",") !== -1){
			var artags = tags.split(',');	
			for(var i=0; i<artags.length; i++){
				if((artags[i].trim() !== "")&&($.inArray(artags[i].trim(), existenttags) == -1)){
					listnews = listnews + '<span data-value = "'+value+'">'+artags[i].trim()+'<a href="#" class="fa fa-times"></a></span>';
					existenttags.push(artags[i].trim());
                                    count++;
                                    skill_counter();
				}
			}
		}
		
		else{
			if($.inArray(tags, existenttags) == -1){
				listnews = '<span data-value = "'+value+'">'+tags+'<a href="#" class="fa fa-times"></a></span>';
                         count++;
                          skill_counter();
			}
		}
		//adds everything to the html and clears the value of the textfield
		$("#shownlist").append(listnews);
		$("#inputfield").val("");
	};        
        
$("#inputfield").keypress(function(e){
        if(e.which == 13){
        skillsdata = $('#inputfield').val();
        
        if(skillsdata == "")
        {
         return false;
        }
        else{
             addTags(skillsdata,value = "");
            }
        } 
    }).blur(clearfun);
        
        function clearfun()
        {
          $(this).val("");
        }

$(document).on('click','#shownlist span a', function(event){
		event.preventDefault();
		var btn = $(this);
		var tag = btn.parent().html().toString();
		tag = tag.substr(0,tag.length-20);
		btn.parent().remove();
                count--;
                skill_counter();
		
	});   
 
 function skill_counter()
        {
           if(count == 0)
               {
                 $('#skill_counter').val("");
               }
           else
           {
           $('#skill_counter').val("1");
          
          }
        }
        
         $('#md-checkbox').on('click', ':checkbox', function () {
            if ($(this).is(':checked')) {

                $('#heading_placeholder').hide();
                
                $(".drop-options").append('<li value-id="' + $(this).attr("id") + '" class="draggable-item"> <i class="fa fa-arrows" aria-hidden="true"></i> ' + $(this).closest("div").find("label").text() + '</li>');
                
            } else if ($(this).is(':unchecked')) {
              $('.drop-options [value-id = "'+$(this).attr("id")+'"]').remove();
             
            }
        });
        
       $( init );

function init() {
  $( ".droppable-area" ).sortable({
      connectWith: ".connected-sortable",
      stack: '.connected-sortable ul'
    }).disableSelection();
}       
 
  
       
   function checkbox_arr()
       {
        var arr_val = [];

        $.each($('.drop-options li'),function(index,value)
        {
        var object_val = {};
        object_val["id"] = $(this).attr('value-id');
        object_val["value"] = $.trim($(this).text());

        arr_val.push(object_val);
         });

         $('#checkbox_array').val(JSON.stringify(arr_val));
        };
        
       function skills_arr()
       {
        var array_val = [];

        $.each($('.placeble-area span'),function(index,value)
        {
        var obj_val = {};
        obj_val["id"] = $(this).attr('data-value');
        obj_val["value"] = $.trim($(this).text());

        array_val.push(obj_val);
         });
         $('#skillsArray').val(JSON.stringify(array_val));
        };  
        
    var FormWizard = function () {
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
            function format(state) {
                if (!state.id) return state.text; // optgroup
                return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }
            var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
            $.validator.addMethod("mycustomrule", function(value, elem, param) {
            return $('input[name = "InternshipApplicationForm[checkbox][]"]:checkbox:checked').length > 2;
            },"You must select at least Three !");  
    
            $('#submit_form').validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    'InternshipApplicationForm[mainfield]':
                     {
                       required:true,
                     },
                    'InternshipApplicationForm[internshiptitle]': {
                        required: true
                    },
                    'InternshipApplicationForm[fieldofwork]': {
                        required: true
                    },
                    'InternshipApplicationForm[jobtype]': {
                        required: true
                    },
                    'InternshipApplicationForm[primaryfield]': {
                      
                       required:true
                    },
                    'InternshipApplicationForm[stipendtype]': {
                      
                       required:true
                    },             
                   'skill_counter':
                    {
                      required:true
                    },
                    'InternshipApplicationForm[earliestjoiningdate]': {
                        required: true
                    },
                    'InternshipApplicationForm[internshipduration]': {
                        required: true,
                        number: true
                    },
                    'InternshipApplicationForm[minstip]': {
                        required: true,
                        number: true
                    },
                    'InternshipApplicationForm[maxstip]': {
                        required: true,
                        number: true
                    },
                    'InternshipApplicationForm[stipendpaid]': {
                        required: true,
                        number: true
                    },
                        
                   'InternshipApplicationForm[checkbox][]': {
                        mycustomrule:true,
                    },
                   
                    'InternshipApplicationForm[startdate]':
                   {
                       required:true
                       },
                   'InternshipApplicationForm[enddate]':
                   {
                       required:true
                       },
                   'InternshipApplicationForm[jobdescription]':
                    {
                     required:true
                     
                      },
                   'InternshipApplicationForm[jobposition]':
                    {
                     required:true,
                     number:true
                     
                      },
                   'question-radio':
                    {
                     required:true
                      },
        
                   'interview-radio':
                 {
                 required:true     
                },
        
                },
                messages: { 
                    'InternshipApplicationForm[checkbox][]': { 
                        mycustomrule:'<div class = "rule-text">Please Select atleast Three questions</div>',
                    },
          'InternshipApplicationForm[internshiptitle]': {
                        required: 'This Field is Required'
                    },
        
            'InternshipApplicationForm[salaryinhand]': {
                        
                        number: 'Salary Should be in digits only',
                    },
         'InternshipApplicationForm[mainfield]':
                     {
                       required:'<div class = "rule-text">Please Select One Category From The List</div>',
                     },
         'InternshipApplicationForm[stipendtype]': {
                      
                       required:'<div class = "rule-text4">Please Select One Option From The List</div>',
                    },
             'question-radio':
                    {
                     required:'<div class = "rule-text2">Please Select From the options</div>'
                     
                     
                      },
             'interview-radio':
                 {
                 required: '<div class = "rule-text2">Please Select From the options</div>'    
                },
                 'InternshipApplicationForm[primaryfield]': {
                       required : '<div class = "rule-text">Please Select from the list</div>'
        
                    },
                   'skill_counter':
                    {
                      required:'<div class = "rule-text4">Please Choose Atleast One Skill</div>',
                    },
                },
        
                errorPlacement: function (error, element) { 
                    if (element.attr("name") == "InternshipApplicationForm[salaryinhand]") { 
                        error.insertAfter("#jobapplicationform-salaryinhand");
                    } else if (element.attr("name") == "InternshipApplicationForm[checkbox][]") { 
                        error.insertAfter("#error-checkbox-msg");
        
                    } 
        else if (element.attr("name") == "question-radio") { 
                        error.insertAfter("#error-checkbox-msg2");
        
                    } 
        
        else if (element.attr("name") == "interview-radio") { 
                        error.insertAfter("#error-checkbox-msg3");
        
                    } 
        else if(element.attr("name") == "InternshipApplicationForm[primaryfield]")
        {
        error.insertAfter("#primaryfield_error_msg");
            }
        else if(element.attr("name") == "InternshipApplicationForm[internshiptitle]")
             { 
                    error.insertAfter("#error-msg4");
                }
         else if(element.attr("name") == "skill_counter")
             { 
                    error.insertAfter("#specialskillsrequired");
                }
         else if(element.attr("name") == "InternshipApplicationForm[stipendtype]")
             { 
                    error.insertAfter("#radio_rules");
                }
        
            else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                        label
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label
                            .addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },
            });

            var displayConfirm = function() {
                $('#tab5 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio")) {
                        $(this).html(input.attr("value"));
                    } else if ($(this).attr("data-display") == 'InternshipApplicationForm[checkbox][]') {
                        var checkboxvalues = new Array();
                        var checkbox_id = new Array();
                        var n = 1;
                        $('input[name = "InternshipApplicationForm[checkbox][]"]:checked').each(function()
                            {
                               checkboxvalues.push(n+" "+$(this).parent().text()+"<br>");   
                                   n++;
                                checkbox_id.push($(this).val());
                                });
                               $('#chackboxvalues').html(checkboxvalues); 

                    }
                  else if($(this).attr("data-display") == 'randomfunc')
                {  
                   var n = "";
                  var possible = "abcdefghijklmnopqrstuvwxyz";
                  for(var i = 0;i < 5; i++)
                    {
                         n += possible.charAt(Math.floor(Math.random()*possible.length));
                    }
                
                var data = $('#submit_form').serialize()+'&n='+n;
        
//                    $.ajax({
//                         url: '/account/job-preview', 
//                         data:data, 
//                         method:'post',
//                         success: function(data)
//                            {
//                               if($('#data_preview').length == 0 ){
//                                   $('.btn-preview').append('<a id = "data_preview" href="/jobs/job-preview?data='+data+'" class="btn green button-preview" target = "_blank">Preview</a>');
//                                    }
//                                else
//                                  {return false;}   
//                             }
//                        })
                }
                 else if($(this).attr("data-display") == 'placement_loc' || $(this).attr("data-display") == 'InternshipApplicationForm[specialskillsrequired]' || $(this).attr("data-display") == 'InternshipApplicationForm["primaryfield"]' || $(this).attr("data-display") == 'InternshipApplicationForm[interviewcity][]'  )
                    {
                      var interviewcitynames = new Array();
                       
                       $('input[name = "InternshipApplicationForm[interviewcity][]"]:checked').each(function(){
                          interviewcitynames.push('<span class = "chip">'+ $(this).attr('data-value')+ '</span>');
                          
                    });
                        $('#interviewcitycityvalues').html(interviewcitynames.join(" "));
                        var placement_city = new Array();
                        $('input[name = "placement_loc"]:checked').each(function(){
                        placement_city.push('<span class = "chip">'+ $(this).attr('data-value')+":"+"("+$(this).attr('data-count')+")"+'</span>');
                  });
                      $('#placement_locations').html(placement_city.join(" "));
                       var skills_list = getTags();
                       $('#skillvalues').html(skills_list.toString());
                      var skill_data =  getTags();
                      $('#specialskillsrequired').val(skill_data);
                   }
                });
            }
            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    $('#form_wizard_1').find('.button-preview').show();
                    displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                    $('#form_wizard_1').find('.button-preview').hide();
                }
                App.scrollTo($('.page-title'));
            }
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false;
                    
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
                
            }).hide();
        }
    };

}();

jQuery(document).ready(function() {
    FormWizard.init();
});
        
JS;

$this->registerJs($script);
$this->registerCssFile('@root/assets/vendor/form-builder/css/jquery-custom-ui.css');
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/additional-methods.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJsFile('@root/assets/vendor/form-builder/js/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


$this->registerCssFile('@eyAssets/materialized/materialize-tags/css/materialize-tags.css');

$this->registerJsFile('@eyAssets/materialized/materialize-tags/js/materialize-tags.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/gmaps/gmaps.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>


 
   

