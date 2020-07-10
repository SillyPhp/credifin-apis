<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

Yii::$app->view->registerJs('var doc_type = "' . $type . '"', \yii\web\View::POS_HEAD);
?>

<div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif'); ?>"
                     alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                <span><?= Yii::t('account', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="portlet light nd-shadow" id="form_wizard_1">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-red"></i>
                <span class="caption-subject font-red bold uppercase">
                    <?php if ($type == 'Jobs' || $type == 'Clone_Jobs' || $type == 'Edit_Jobs'): ?>
                        Job Application
                    <?php elseif ($type == 'Internships' || $type == 'Clone_Internships' || $type == 'Edit_Internships'): ?>
                        Internship Application
                    <?php endif; ?>
                    <span class="step-title"> Step 1 of 4</span>
                </span>
            </div>
        </div>
        <div class="portlet-body form">
            <?php
            $form = ActiveForm::begin([
                'id' => 'submit_form',
                'enableClientValidation' => true,
                'validateOnBlur' => false,
                'fieldConfig' => [
                    'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}</div>",
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
                                    <i class="fa fa-check"></i>
                                    <?php if ($type == 'Jobs' || $type == 'Clone_Jobs' || $type == 'Edit_Jobs'): ?>
                                        Job Description
                                    <?php elseif ($type == 'Internships' || $type == 'Clone_Internships' || $type == 'Edit_Internships'): ?>
                                        Internship Description
                                    <?php endif; ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab3" data-toggle="tab" class="step">
                                <span class="number"> 3 </span><br/>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Interview Process  </span>
                            </a>
                        </li>
                        <li>
                            <a href="#tab4" data-toggle="tab" class="step">
                                <span class="number"> 4 </span><br/>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Interview Details  </span>
                            </a>
                        </li>
                        <li class="step5">
                            <a href="#tab5" data-toggle="tab" class="step">
                                <span class="number"> 5 </span><br/>
                                <span class="desc">
                                    <i class="fa fa-check"></i> Confirmation </span>

                            </a>
                        </li>
                    </ul>
                    <div id="bar" class="progress progress-striped" role="progressbar">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <?php
                            if ($type == 'Jobs' || $type == 'Clone_Jobs' || $type == 'Edit_Jobs'):
                                echo $this->render('/widgets/employer-applications/basic-job-details', [
                                    'form' => $form,
                                    'model' => $model,
                                    'primary_cat' => $primary_cat,
                                    'industry' => $industry,
                                    'type' => $type,
                                ]);
                            elseif ($type == 'Internships' || $type == 'Clone_Internships' || $type == 'Edit_Internships'):
                                echo $this->render('/widgets/employer-applications/basic-internships-details', [
                                    'form' => $form,
                                    'model' => $model,
                                    'primary_cat' => $primary_cat,
                                    'type' => $type,
                                ]);
                            endif;
                            ?>
                            <div class="divider">
                                <span></span>
                            </div>
                            <div class="placement_location_hide">
                                <?=
                                $this->render('/widgets/employer-applications/placement-locations', [
                                    'form' => $form,
                                    'model' => $model,
                                    'placement_locations' => $placement_locations,
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <?=
                            $this->render('/widgets/employer-applications/job-description', [
                                'form' => $form,
                                'model' => $model,
                            ]);
                            ?>
                            <div class="divider"></div>
                            <?=
                            $this->render('/widgets/employer-applications/educational-requirements', [
                                'form' => $form,
                                'model' => $model,
                            ]);
                            ?>
                            <div class="divider"></div>
                            <?=
                            $this->render('/widgets/employer-applications/skills', [
                                'form' => $form,
                                'model' => $model,
                            ]);
                            ?>
                            <div class="divider"></div>
                            <?=
                            $this->render('/widgets/employer-applications/employee-benefits', [
                                'form' => $form,
                                'model' => $model,
                                'benefits' => $benefits,
                            ]);
                            ?>
                            <?=
                            $this->render('/widgets/employer-applications/additional-information', [
                                'form' => $form,
                                'model' => $model,
                            ]);
                            ?>
                            <div class="divider"></div>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <?=
                            $this->render('/widgets/employer-applications/hiring-processes', [
                                'form' => $form,
                                'model' => $model,
                                'process' => $process,
                            ]);
                            ?>
                            <div class="divider"></div>
                            <?=
                            $this->render('/widgets/employer-applications/questionnaire', [
                                'form' => $form,
                                'model' => $model,
                                'questionnaire' => $questionnaire,
                            ]);
                            ?>
                        </div>
                        <div class="tab-pane" id="tab4">
                            <?=
                            $this->render('/widgets/employer-applications/interview-details', [
                                'form' => $form,
                                'model' => $model,
                            ]);
                            ?>
                            <div class="interview_panel_hide">
                                <?=
                                $this->render('/widgets/employer-applications/interview-locations', [
                                    'form' => $form,
                                    'model' => $model,
                                    'interview_locations' => $interview_locations,
                                ]);
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab5">
                            <?=
                            $this->render('/widgets/employer-applications/preview', [
                                'form' => $form,
                                'model' => $model,
                                'type' => $type,
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div id="loading_img">
                </div>
                <div class="form-actions">
                    <div class="row ">
                        <div class="btn-preview">
                            <a href="javascript:;" class="btn custom-buttons3 button-previous custom_color-set">
                                <i class="fa fa-angle-left"></i>
                                Back
                            </a>
                            <a href="javascript:;"
                               class="btn btn-primary custom-buttons2 button-next custom_color-set">
                                Continue
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <?= Html::button('Submit', ['class' => 'btn button-submit custom-buttons2 btn-primary custom_color-set2']) ?>
                            <a id="data_preview" href="#"
                               class="btn button-preview btn-primary custom-buttons2 custom_color-set2"
                               target="_blank">Preview</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="fader"></div>
<input type="hidden" id="app_id_main"/>
<?php
//echo $this->render('/widgets/campus-placement/select-college-for-campus-placement',[
//    'type' => $type,
//]);
$this->registerCss("
body {
    background-image: url(/assets/themes/ey/images/backgrounds/ai-header.png) !important;
    background-size: cover !important;
    background-attachment: fixed !important;
    background-repeat: no-repeat !important;
}
.page-container-bg-solid .page-content{
    background: transparent !important;
}
.portlet.light {
    background-color: #ffffffe3 !important;
}
ul.ks-cboxtags {
    list-style: none;
    padding:0px;
}
.service-list{
  display: inline-block;
  min-width: 120px;
}
.service-list label{
    width: 100%;
    display: inline-block;
    background-color: rgba(255, 255, 255, .9);
    border: 2px solid rgba(139, 139, 139, .3);
    color: #333;
    border-radius: 4px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s;
}

.service-list label {
    padding: 8px 12px;
    cursor: pointer;
}

.service-list label::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: 12px;
    padding: 2px 6px 2px 2px;
    content: '\f067';
    transition: transform .3s ease-in-out;
}

.service-list input[type='checkbox']:checked + label::before {
    content: '\f00c';
    transform: rotate(-360deg);
    transition: transform .3s ease-in-out;
}

.service-list input[type='checkbox']:checked + label, .service-list label:hover {
    border: 2px solid #00a0e3;
    background-color: #00a0e3;
    color: #fff;
    transition: all .2s;
}

.service-list input[type='checkbox'] {
  display: absolute;
}
.service-list input[type='checkbox'] {
  position: absolute;
  opacity: 0;
}
.service-list input[type='checkbox']:focus + label {
  border: 2px solid #00a0e3;
}
.align{text-align:center;}
.padd{padding-top:10px;}
.comp-logo img{
    width: 90px;
    height: 90px;
    border: 4px solid #fff;    
}
.modal-dialog{
    width:800px !important;    
}
.g-pref{
    display:block;
    }
.step {
   -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none;   /* Chrome/Safari/Opera */
  -khtml-user-select: none;    /* Konqueror */
  -moz-user-select: none;      /* Firefox */
  -ms-user-select: none;       /* Internet Explorer/Edge*/
   user-select: none;   
   -webkit-user-drag: none;
  -khtml-user-drag: none;
  -moz-user-drag: none;
  -o-user-drag: none;
   user-drag: none;
}
.md-radio-inline.text-right.clearfix{padding-top:20px;}
#benefits_hide,#questionnaire_hide,#benefitPopup,#add
{
 display:none;
}
.overlay-left {
  position: absolute;
  top: 0px;
  left: 6px;
  right: 0;
  background-color: #008CBA;
  overflow: hidden;
  width: 0;
  height: 100%;
  z-index:99;
  transition: .5s ease;
  border-radius: 8px 0px 0px 8px;
}

.radio_questions:hover .overlay-left {
  width: 130px;
}

.text {
  color: white;
  font-size: 15px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  white-space: nowrap;
}
/* Feature, categories css starts */
.checkbox-input {
  display: none;
}
.checkbox-label-v2 {
/*   display: inline-block; */
/*   vertical-align: top; */
/*   position: relative; */
  width: 100%;
  cursor: pointer;
  font-weight: 400;
  margin-bottom:0px;
}
.p-category img, .checkbox-text--title img{
    width: 80px;
    height: 50px;
}
.checkbox-label-v2:before {
  content: '';
  position: absolute;
  top: 80px;
  right: 16px;
  width: 40px;
  height: 40px;
  opacity: 0;
  background-color: #00A0E3;
  background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
  background-position: 80% 80%;
  background-repeat: no-repeat;
  background-size: 30px;
  border-radius: 50%;
  -webkit-transform: translate(0%, -50%);
  transform: translate(0%, -50%);
  transition: all 0.4s ease;
}
.checkbox-input:checked + .checkbox-label-v2:before {
  top: 0;
  opacity: 1;
}
.checkbox-input:checked + .checkbox-label-v2 .checkbox-text span {
  -webkit-transform: translate(0, -8px);
  transform: translate(0, -8px);
}
#fixed_stip,#min_max
{
 display:none;
}
.cat-sec {
    float: left;
    width: 100%;
}
.p-category {
    float: left;
    width: 100%;
    z-index: 1;
    position: relative;
    display:flex;
}
.p-category, .p-category *{
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.p-category .checkbox-text {
    float: left;
    width: 100%;
    text-align: center;
    padding-bottom: 30px;
    border-bottom: 1px solid #e8ecec;
    border-right: 1px solid #e8ecec;
}
.p-category .checkbox-text span i {
    float: left;
    width: 100%;
    color: #00A0E3;
    font-size: 70px;
    margin-top: 15px;
    line-height: initial !important;
}
.p-category .checkbox-text span {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    color: #202020;
    margin-top: 10px;
}
.p-category:hover {
    background: #ffffff;
    -webkit-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    width: 104%;
    margin-left: -2%;
    height: 102%;
    z-index: 10;
}
.p-category:hover .checkbox-text {
    border-color: #ffffff;
}
.p-category:hover .checkbox-label-v2 i{
    color: #f07d1d;
}
.row.no-gape .p-category-main {
    padding: 0;
}
.cat-sec .row .p-category-main:last-child .checkbox-text {
    border-right-color: #ffffff;
}
/* Feature, categories css ends */
.no-padd{
    padding-left:0px; 
    padding-right:0px;
} 
.c-btn-top{
    padding-top:35px;  
} 
.empty-section-text{
    font-size:15px;
    text-align:center;
    padding:20px 0px 10px 0;
} 
.btn-padd-top{
    padding-top:30px !important;
}
.m-padd{
    padding-left:15px !important;
}
.form-wizard .steps>li.active>a.step .number{
    background-color:#00a0e3 !important;
} 
.padd-10{
    padding-top:20px !important;
}
.manual_notes{
    padding: 6px 0px 0 10px;
    color: #999999;
    font-size: 15px;
} 
textarea{
    resize:none;
} 
.materialize-tags {
    border-bottom: 1px solid #c2cad8 !important;
}
.divider{
    border-top:2px solid #eee;
    margin: 35px -30px 19px;
}
.module2-heading{
    text-transform: uppercase;
    font-size: 22px;
    padding: 20px 0 0 0;
    color: #00a0e3; 
    margin-top:5px;
    font-weight: initial;
}
.has-success .md-radio label, .has-success.md-radio label {
    color: #00a0e3;
} 
.custom-buttons2{
//    width:100%;
//    background:#00a0e3 !important;
    font-size: 12px !important;
    padding: 8px 10px !important;
//    margin-bottom:20px;
     -webkit-border-radius: 6px !important;
    -moz-border-radius: 6px !important;
    -ms-border-radius: 6px !important;
    -o-border-radius: 6px !important;
    border-radius: 6px !important;
}
.custom-buttons2:hover{
    color: #ffffff;
    box-shadow:0 0 10px rgba(0,0,0,.5) !important;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -ms-transition:.3s all;
    -o-transition:.3s all;
}
.custom-buttons3{
//    width:100%;
    background:#ddd !important;
    font-size: 12px !important;
    padding: 8px 10px !important;
    margin-bottom:20px;
    color:#000 !important;
    border-color:#ddd !important;
     -webkit-border-radius: 6px !important;
    -moz-border-radius: 6px !important;
    -ms-border-radius: 6px !important;
    -o-border-radius: 6px !important;
    border-radius: 6px !important;
}
.custom-buttons3:hover, .custom-buttons3:active, .custom-buttons3:focus{
    color: #000 !important;
    background:#ddd !important;
    box-shadow:0 0 10px rgba(0,0,0,.5) !important;
    border-color:#ddd !important;
    transition:.3s all;
    -webkit-transition:.3s all;
    -moz-transition:.3s all;
    -ms-transition:.3s all;
    -o-transition:.3s all;
}
 /*new changes end*/
 
select{
 -moz-appearance: none;
 -o-appearance: none;
 -webkit-appearance: none;
}
.select {
  position: relative;
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
    padding: 5px 9px;
    line-height: 24px;
    min-height: 37px;
    margin-top: -2px !important;
    margin-left: -4px;
}

.gender_radio:checked + .gender_label{
    color: #fff;
    background: #00a0e3;
    margin: 0px 0px 0px -4px;
//    border-radius: 4px;
    height: 35px;
    padding-top: 7px;
    
}
.gender_label:last-child{
    
}

.gender_label + .gender_radio + .gender_label {
      border-left: solid 1px #c5cdda;
}
.radio-group {
    border: solid 1px #c5cdda;
    display: inline-block;
    border-radius: 5px;
    overflow: hidden;
    max-height: 36px;
    
}
#gender_pref {
    margin-top: 20px;
    text-align: center;
}

.field-gender
{
 margin:0px;
}

#week_options
{
 margin-left:10px;
}
#week_options div div{
    padding-top:0px;
}

.field-weekoptsat,.field-weekoptsund
{
    width: 100%;
    float: left;
    display:none;
}

    
#weekoptsat,#weekoptsund
{
 width:90%;
}
.weekDays-selector input {
  display: none!important;
}

.weekDays-selector input[type=checkbox] + label {
  display: inline-block;
  border-radius: 14px;
  background: #dddddd;
  height: 25px;
  width: 25px;
  margin-right: 3px;
  line-height: 25px;
  text-align: center;
  cursor: pointer;
  
}
#add2{
//display:none;
}
.selectBox{
    width: 100%;
    border: 1px solid #d1d7dc;
    border-radius: 5px;
    padding: 6px 15px;
}
.selectBox:focus{
    outline:none !important;
}
.selectWrapper{
    padding: 15px 16px;
}
.weekDays-selector input[type=checkbox]:checked + label {
  background: #00a0e3;
  color: #ffffff;
}    
.sat{
    display:none;
    clear: both;
    float: left;
    width: 100%;
}
.sun{
    display:none;
    clear: both;
    float: left;
    width: 100%;
}
.sat-sun{
    width:50%;
    float:left;
}
.progress-bar-success {
    background-color: #00a0e3;
}
.button-previous
{
  display:none;
}
#last_date,#earliestjoiningdate{
    border-bottom: 1px solid #c2cad8;
    cursor: pointer;
}
.has-error div #last_date, .has-error div #earliestjoiningdate{
border-bottom: 1px solid #e73d4a;
}
.has-error div #interviewstarttime-error{
    margin-top:10px;
}
.has-error div #interviewendtime-error{
    margin-top:10px;
}
.has-success div div .input-group-addon, .has-success div #last_date, .has-success div #earliestjoiningdate{
    border-bottom: 1px solid #00A0E3 !important;
}
.button-submit
{
display:none;
}
#ctc-main
{
  display:none;
}

.large-container{
    max-width: 1400px !important;
    padding-left: 15px;
    padding-right: 15px;
    margin:auto;
}
.tab-content{
    padding:20px 20px 0 20px;
}
.caption{
    padding:10px;
    width:100%;
}
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
.form-wizard .steps>li.done>a.step .number {
    background-color: #ffac64 !important;
    color: #fff;
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
  width: 98%;
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
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
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

.empty-message {

 text-align: center;
 
}
.skill_wrapper
{
margin-bottom:8px;
}

.skill_wrapper .Typeahead-spinner,.descrip_wrapper .Typeahead-spinner,.edu_wrapper .Typeahead-spinner{
    top: -16px;
    z-index: 99;
}
#inputfield, #quali_field, #question_field{
    padding-right:60px;
}
.Typeahead-input {
    position: relative;
    background-color: transparent;
    outline: none;
}

.twitter-typeahead {
    
    width: 100% !important;
}

.n-tag[disabled]
{
  display:none;
}

.materialize-tags-max .n-tag
{
  display:none;
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
    color: #3C454C !important; 
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
//  background-color: #00a0e3;
  background-color: #fff;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%) scale3d(1, 1, 1);
  transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
  opacity: 0;
  z-index: -1;
  box-shadow:0 0 10px rgba(0,0,0,.5) !important;
}
.question_checkbox label:after {
  width: 32px;
  height: 32px;
  content: '';
  border: 2px solid #D1D7DC;
  background-color: #fff;
  background-repeat: no-repeat;
  background-position: 2px 3px;
  background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
  //border-radius: 50%;
  z-index: 2;
  position: absolute;
  right: 30px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  transition: all 200ms ease-in;
}
.process_radio label:after {
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
  box-shadow:0 0 10px rgba(0,0,0,.3) !important;
}
.inputGroup input:checked ~ label:before {
  transform: translate(-50%, -50%) scale3d(56, 56, 1);
  opacity: 1;
}
.inputGroup input:checked ~ label:after {
  background-color: #00a0e3;
  border-color: #00a0e3;
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
//      padding: 0 16px;
  max-width: 100%;
  font-size: 18px;
  font-weight: 600;
  line-height: 36px;
  position:relative;
}

#skill_counter,#qualific_count,#desc_count,#placement_calc,#interview_calc,#benefit_calc,#process_calc,#ques_calc
{opacity:0;
cursor:default;
width:5%;
}

.rule-text4
{color:#e9465d;
font-size: 16px;
padding: 0px 15px;}

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
    background-color: #00A0E3;
    background-position: center;
    background-repeat: no-repeat;
    background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
    background-size: 100%;
    border-radius: 50%;
    background-position: 4px 4px;
    -webkit-transform: translate(0%, -50%);
    transform: translate(0%, -50%);
    transition: all 0.4s ease;
}
.color_red{
 color: #e73d49;
 font-size:18px;
}
.s_error{
   color: #e73d49;
   font-size: 14px;
}
.spinner {
  width: 100px;
  display:none;
  margin-top:10px;
}
.spinner input {
  text-align: right;
  max-width:48px;
}
.input-group-btn-vertical {
  position: relative;
  white-space: nowrap;
  width: 1%;
  vertical-align: middle;
  display: table-cell;
}
.input-group-btn-vertical > .btn {
  display: block;
  float: none;
  width: 100%;
  max-width: 100%;
  padding: 8px 11px !important;
  margin-left: -1px;
  position: relative;
  border-radius: 0;
}
.input-group-btn-vertical > .btn:first-child {
  border-top-right-radius: 4px;
}
.input-group-btn-vertical > .btn:last-child {
  margin-top: -2px;
  border-bottom-right-radius: 4px;
}
.input-group-btn-vertical i{
  position: absolute;
  top: 0;
  left: 4px;
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
    box-shadow: inset 0 0 0px 0 #00A0E3;
}

#heading_placeholder
{
  font-size:21px;
}

.checkbox-text--title {
  font-weight: 500;
}
.checkbox-text--description {
  font-size: 14px;
  margin-top: 16px;
  padding-top: 10px;
  border-top: 1px solid #00A0E3;
      margin-bottom: 10px;
}
.checkbox-text--description .un {
  display: none;
}

.checkbox-input:checked + .checkbox-label {
  border-color: #00A0E3;
  box-shadow: inset 0 -12px 0 0 #00A0E3;
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
    height: 28px;
    font-size: 14px;
    font-weight: 500;
    font-weight: 500;
    color: rgba(0, 0, 0, 0.6);
    line-height: 28px;
    padding: 0px 12px;
    border-radius: 5px;
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

.jd_heading{
  margin-top: 0px;
}
.loc_name_tag{
    margin: 5px 0px;
    font-size: 19px;
    padding-top: 6px;
}

.rule-text2{
  padding: 2px 16px;
    color: #e9465d;
}

.md-checkbox {
    position: relative;
    margin-bottom: 8px;
    
}

.field-checkbox{
  margin-top: -22px;
}

.form-group{
    min-height:10px;
}

#md-checkbox,#quali_list
{
    min-height: 288px;
    max-height: 288px;
    overflow-y: scroll;
    margin:0px;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 6px;
    position:relative;
}
#suggestionbox{
    min-height: 130px;
    max-height: 130px;
    overflow-y: scroll;
    margin:15px;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 6px;
    position:relative;
}
#startdate-kvdate{
    padding:25px 0px;
}

#addct
{
     padding: 28px 10px;
    text-align: center;
}
.close-ctc{
    position: absolute;
    z-index: 11;
    top: 30px;
    font-size: 16px;
    right: 20px;
    color: #a2a2a2;
}
.button_location
{padding: 14px 0px;
float:right;}

.checkbox-text{
    margin-bottom:8px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.checkbox-text .form-group.form-md-line-input {
   
     padding-top: 0px !important; 
     margin: 0 0 0px !important;
}
.placeble-area
{
    border: 1px solid #ccc;
    min-height:130px;
    max-height: 130px;
    border-radius: 6px;
    display: flex;
    padding: 5px 14px;
    position:relative;
    overflow-y: scroll;
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
  position:relative;
  padding: 15px 35px 15px 20px;
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
    margin-top:8px;
}

    .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
        } 
#shownlist span a {
    color: #bcbcbc;
    text-decoration: none;
//    font-weight: 900;
    margin-left: 10px;
}
#suggestionbox span:hover , #suggestionbox span:hover a{
    background-color: #00a0e3;
    color:#FFF;
}
#shownlist span:hover , #shownlist span:hover a{
    background-color: #00a0e3;
    color:#FFF;
}
#suggestionbox span a, .drop-options span a,.quali_drop_options span a
{
    color: #1d1818;
    text-decoration: none;
    
}
#shownlist span,#suggestionbox span{
    display: block;
    float: left;
    padding: 5px 8px;
    background-color: #f4f3f3;
    color: #1d1818;
    margin: 0 10px 10px 0;
    border-radius: 4px;
}

#checkboxlistarea,#quali_listarea
{
    border: 1px solid #c2cad8;
    min-height: 288px;
    max-height: 288px;
    overflow-y: scroll;
    border-radius:6px;
    position:relative;
}

#checkboxlistarea h3,#quali_listarea h3
{
    color: #c2cad8;
    text-align: center;
    font-size: 16px;
    font-weight: 300;
    padding:100px 10px 0 10px;
    line-height: 23px;
}

.rule-text{
    position: absolute;
    color: #e73d49;
    font-size:16px;
}

.inter_cust_rule
{
color: #e73d49;
font-size:16px;
}
 #interview_box
 {
display:none; 
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

.step5
{
 display:none !important;
}
#bar
{
height:17px !important;
}
.tooltips{
    display: none; 
    width: 167px;
    position: absolute;
    left: 90px;
    border: solid 1px transparent;
    background-color: #00A0E3;
    padding: 10px;
    color: #fff;
    z-index: 1000;
    bottom: 10px;
    border-radius:4px;
}
.tooltips:before{
    content: '';
    left: -15px;
    top: 10px;
    position: absolute;
    border-top: 10px solid transparent;
    border-right: 15px solid #00A0E3;
    border-bottom: 10px solid transparent;
}


.number-input input[type=\"number\"] {
  -webkit-appearance: textfield;
  -moz-appearance: textfield;
  appearance: textfield;
}

.number-input input[type=number]::-webkit-inner-spin-button,
.number-input input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
}

.number-input {
  border: 2px solid #ddd;
  display: inline-flex;
  display:none;
}

.number-input,
.number-input * {
  box-sizing: border-box;
}

.number-input button {
  outline:none;
  -webkit-appearance: none;
  background-color: transparent;
  border: none;
  align-items: center;
  justify-content: center;
  width: 3rem;
  height: 3rem;
  cursor: pointer;
  margin: 0;
  position: relative;
}

#manual_questions
{
  margin-bottom:8px;
}

.number-input button:before,
.number-input button:after {
  display: inline-block;
  position: absolute;
  content: '';
  width: 1rem;
  height: 2px;
  background-color: #212121;
  transform: translate(-50%, -50%);
}
.number-input button.plus:after {
  transform: translate(-50%, -50%) rotate(90deg);
}

.number-input input[type=number] {
  font-family: sans-serif;
  max-width: 5rem;
  padding: .5rem;
  border: solid #ddd;
  border-width: 0 2px;
  font-size: 2rem;
  height: 3rem;
  font-weight: bold;
  text-align: center;
}
.btn-preview{
    margin: auto;
    width: 100%;
    text-align: center;
}
.btn-preview a{
    margin:0px 5px;
}
.weekDays-selector{
    margin-top:25px;
    text-align:center;
}
.weekDays-selector .form-group{
    margin-bottom:0px;
}
.weekDays-selector label{
    display:block;
    margin-top:-2px;
}
.remove_this_item{
   position: absolute;
    right: 10px;
    top: 0%;
    background-color: #ff3434;
    color: #fff !important;
    border-radius: 0px 0px 9px 9px;
    width: 30px;
    height: 23px;
    text-align: center;
    line-height: 21px;
}

.button-preview {
    display:none;
}
.place_no{
    text-align: center !important;
    border: 1px solid #ddd !important;
}
.kv-container-from, .kv-container-to {
    padding: 0 !important;
    border: 0 !important;
}
.has-success .md-radio label, .has-success.md-radio label{
    color:inherit;
}
.ck-editor__editable {
    min-height: 200px !important;
}
:host ::ng-deep .ck-editor__editable {
    min-height: 200px !important;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 20px;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 35px 1px;
}

.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}

.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}

.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
#wage_type-error .color_red
{font-size:13px}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }

  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */
");
$script = <<< JS
var job_titles;
if(window.location.hash) 
    {
        window.location = window.location.pathname;
    }
var session_tok = "";
$(document).on('click','#weekdays input',function()
    {
     week_selecter();
   });
 
function week_selecter()
{
    if ($('#weekday-5').is(':checked'))
        {
         $('.field-weekoptsat').css('display','block');
         $('.sat').css('display','block');
        
        }
     else if ($('#weekday-5').is(':unchecked'))
        {
          $('.field-weekoptsat').css('display','none');
          $('.sat').css('display','none');
        }
    if($('#weekday-6').is(':checked'))
        {
          $('.field-weekoptsund').css('display','block');
          $('.sun').css('display','block');
        }
        
     else if($('#weekday-6').is(':unchecked'))
        { 
          $('.field-weekoptsund').css('display','none');
          $('.sun').css('display','none');
        }
}
function genrate_session_token() {
    var possible = "abcdefghijklmnopqrstuvwxyz1234567890";
    for(var i = 0;i < 8; i++) {
        session_tok += possible.charAt(Math.floor(Math.random()*possible.length));
    }
}
genrate_session_token();
if(doc_type=='Jobs'||doc_type=="Internships"||doc_type=='Clone_Jobs'||doc_type=='Clone_Internships')
    {
$("#primaryfield").prop("disabled", false);          
$("#title").prop("disabled", false);   
$("#designations").prop("disabled", false);   
$("#industry").prop("disabled", false);   
    }
var data_before = null;
var checked = null;
var array = [];
var prime_id = null;
$('#primaryfield').on('change',function()
    {
      prime_id = $(this).val();
      $('#title').val('');
      $('#title').typeahead('destroy');
      load_job_titles(prime_id);
   });
if (doc_type=='Jobs'||doc_type=='Clone_Jobs'||doc_type=='Edit_Jobs')
    {
        var preview_url = '/account/jobs/preview';
        var titles_url = '/account/categories-list/load-titles?id=';
        var redirect_url = '/account/jobs/dashboard';
    }
else if(doc_type=="Internships"||doc_type=='Clone_Internships'||doc_type=='Edit_Internships')
    {
        var preview_url = '/account/internships/preview';
        var titles_url = '/account/categories-list/load-titles?type=Internships&id=';
        var redirect_url = '/account/internships/dashboard';
    }

if(doc_type=='Clone_Jobs'||doc_type=='Clone_Internships')
    {
        load_job_titles('$model->primaryfield');
    }
if (doc_type=='Clone_Jobs'||doc_type=='Clone_Internships'||doc_type=='Edit_Jobs'||doc_type=='Edit_Internships')
    {
        work_from_home('$model->type');
        week_selecter();
    }
function load_job_titles(prime_id)
{
var categories = new Bloodhound({
  datumTokenizer: function(d) {
        var tokens = Bloodhound.tokenizers.whitespace(d.value);
            $.each(tokens,function(k,v){
                i = 0;
                while( (i+1) < v.length ){
                    tokens.push(v.substr(i,v.length));
                    i++;
                }
            })
            return tokens;
        },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: 
  {
      url:titles_url+prime_id,
      cache:false,
      filter:function(res) {
        job_titles = [];
        job_titles = res;
        return res;
      }
      }
  
});

$('#title').typeahead(null, {
  display: 'value',
  source: categories,
  minLength: 1,
  limit: 20,
}).blur(validateSelection);
return true;
}

function validateSelection() {
   var theIndex = -1;
  for (var i = 0; i < job_titles.length; i++) {
  if (job_titles[i].value == $(this).val()) {
   var data =  job_titles[i].id;
   skils_update(data); 
   educational_update(data);
   job_desc_update(data);
   make_removable_jd();
   make_removable_edu();
 break;
   }
 }
}
 $('#type').on('change',function()
  {
   var job_type_str = $(this).val();
   work_from_home(job_type_str);
     });
function work_from_home(job_type_str) {
  if(job_type_str == "Work From Home")  
        {
        $('.placement_location_hide').hide();
        }
   else
     { 
       $('.placement_location_hide').show();
         }
}
 function ChildFunction()
     {
       
       $.pjax.reload({container: '#pjax_questionnaire', async: false});
       $.pjax.reload({container: '#pjax_process', async: false});
     }
window.ChildFunction = ChildFunction;
        $(document).on('click','.button-submit',function(event)
            {
            event.preventDefault();
             var url =  $('#submit_form').attr('action');
             var data = $('#submit_form').serialize()+'&n='+session_tok;
                  $.ajax({
                   url: url,
                   type: 'post',
                   data: data,
                   beforeSend: function()
                       {
                         $('.button-submit').prop('disabled','disabled');
                       },
                   success: function(res) {
                   if(res['status'] == 200) {
                        $('.fader').css('display','block');    
                        $('#loading_img').addClass('show');
                        $('#app_id_main').val(res['app_id']);
                        // setTimeout(function() {
                        //     $('.m-modal, .m-cover').removeClass("hidden");
                        //     $('.m-modal').addClass("zoom");
                        // }, 500);
                    function explode(){
                     window.location.replace(redirect_url); 
                     }
                       setTimeout(explode, 2000);
                     } else {
                         $('#loading_img').removeClass('show');
                         $('.button-submit').prop('disabled','');
                         $('.fader').css('display','none');
                         toastr.error('Opps Something went wrong', 'Server Error');
                     }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                       toastr.error('Some Internal Server Error re-submit the application by clicking submit', 'Connection Error');
                       $('.button-submit').removeAttr('disabled');
                    }
                    });
                });
 
       $( init );
function init() {
  $( ".droppable-area" ).sortable({
      connectWith: ".connected-sortable",
      stack: '.connected-sortable ul'
    }).disableSelection();
}       
    var FormWizard = function () {
    return {
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
            var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
            $('#submit_form').validate({
                ignore: ":hidden:not(#title,#designations)",
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                
                rules: {
                    'minrange': {
                        required: function() {
                            return (min_s.val() > max_s.val());
                        }
                      },
                    'title': {
                        required: true
                    },
                    'is_online_interview':
                    {
                        required:true
                    },
                    'wage_type': {
                        required: true
                    },
                    'questionnaire_selection':
                    {
                        required:true
                    },
                    'benefit_selection':
                    {
                        required:true
                    },
                    'pre_placement_offer': {
                        required: true
                    },
                    'pre_placement_package': {
                        required: true
                    },
                    'benefit_calc': {
                        required: true
                    },
                    'designations': {
                        required: true
                    },
                    'process_calc': {
                        required: true
                    },
                    'placement_calc': {
                        required: true
                    },
                    'interview_calc': {
                        required: true
                    },
                    'type': {
                        required: true
                    },
                    'weekdays[]': {
                        required: true,
                        minlength: 1
                    },
                    'primaryfield': {
                      
                       required:true
                    },
                    'industry': {
                      
                       required:true
                    },
                    'gender': {
                       required:true
                    },
                   'skill_counter':
                    {
                      required:true
                    },
                   'qualific_count':
                    {
                      required:true
                    },
                    'min_wage': {
                        required: function() {
                              return (doc_type=='Internships');
                           }
                    },
                    'max_wage': {
                        required: function() {
                              return (doc_type=='Internships');
                           }
                    },
                   'desc_count':
                    {
                      required:true
                    },
                    'earliestjoiningdate': {
                        required: true
                    },
                    'fixed_wage': {
                        required: true,
                    },
                    'last_date': {
                        required: true,
                    },
                    'interviewstarttime': {
                        required: true,
                    },
                    'interviewendtime': {
                        required: true,
                    },
                    'ctc': {
                        required: true,
                        
                    },
                    'min_exp': {
                        required: true,
                        
                    },
                    'startdate':
                     {
                       required:true
                       },
                   'enddate':
                   {
                       required:true
                       },
                   'jobdescription':
                    {
                     required:true
                     
                      },
                   'ques_calc':
                    {
                     required: true
                      },
                   'quesradio':
                    {
                     required:true
                      },
        
                   'interradio':
                 {
                 required:true     
                },
                  'fill_quesio_on':
                 {
                 required:true     
                },
                },
                messages: { 
                    'weekdays[]': {
                        required: '<div class = "color_red">Choose One</div>',
                        minlength: '<div class = "color_red">Choose One</div>',
                    },
                    'pre_placement_offer': {
                      
                       required:'<div class = "color_red">Choose One</div>',
                    },
                    'wage_type': {
                      
                       required:'<div class = "color_red">Select One Option From The List</div>',
                    },
                    'benefit_selection':
                    {
                        required:'<div class = "color_red">Please Select From the options</div>'
                    },
                    'startdate':
                     {
                       required:'<div class = "color_red">Field Is Required</div>',
                       },
                    'fill_quesio_on':
                     {
                       required:'<div class = "color_red">Please Choose Fill Quesionnaire</div>',
                       },
                       'benefit_calc': {
                        required: '<div class = "color_red">Please Choose Or Add One Benefit</div>',
                    },
                    'ques_calc':
                     {
                       required:'<div class = "color_red">Please Choose atleast One Questionnaire and Process Stage</div>',
                       },
                       'questionnaire_selection':
                      {
                       required:'<div class = "color_red">Please Select From the options</div>',
                       },
                   'enddate':
                     {
                       required:'<div class = "color_red">Field Is Required</div>',
                       },
                    'process_calc':
                      {
                       required:'<div class = "color_red">Please Choose one Interview process</div>',
                       },
                    'desc_count': { 
                        required:'<div class = "rule-text">Select or add atleast Three Job Descriptions</div>',
                    },
                    'qualific_count': { 
                        required:'<div class = "rule-text">Select or add atleast One Educational Requirments</div>',
                    },
                    'placement_calc': { 
                        required:'<div class = "rule-text">Please Select Atleast One placement Location</div>',
                    },
              'interview_calc': {
                        required: '<div class = "inter_cust_rule">Please Select Atleast One Interview Location</div>',
                    },
             'quesradio':
                    {
                     required:'<div class = "color_red">Please Select From the options</div>'
                     
                      },
             'interradio':
                 {
                 required: '<div class = "rule-text2">Please Select From the options</div>'    
                },
                'is_online_interview':
                 {
                 required: '<div class = "rule-text2">Please Select From the options</div>'    
                },
                   'skill_counter':
                    {
                      required:'<div class = "rule-text4">Please Add Atleast One Skill</div>',
                    },
                },
                errorPlacement: function (error, element) { 
                    switch(element.attr("name"))
                    { 
                        case 'fixed_wage':
                            error.insertAfter("#fixed_wage");
                            break;
                        case 'desc_count':
                        error.insertAfter("#error-checkbox-msg");
                            break;
                        case 'wage_type':
                    error.insertAfter("#radio_rules");
                            break;
                        case 'qualific_count':
                        error.insertAfter("#error-edu-msg");
                            break;
                        case 'placement_calc':
                        error.insertAfter("#place_error");
                            break;
                        case 'interview_calc':
                        error.insertAfter("#interview_error");
                            break;
                        case 'quesradio':
                        error.insertAfter("#error-checkbox-msg2");
                            break;
                        case 'ques_calc':
                        error.insertAfter("#que_error");
                            break;
                        case 'interradio':
                        error.insertAfter("#error-checkbox-msg3");
                            break;
                        case 'is_online_interview':
                        error.insertAfter("#error-checkbox-msg4");
                            break;
                        case 'process_calc':
                        error.insertAfter("#process_err");
                            break;
                        case 'benefit_calc':
                        error.insertAfter("#b_error");
                            break;
                        case 'skill_counter':
                    error.insertAfter("#suggestionbox");
                            break;
                        case 'benefit_selection':
                error.insertAfter("#select_benefit_err");
                            break;
                        case 'questionnaire_selection':
                error.insertAfter("#select_ques_err");
                            break;
                        case 'pre_placement_offer':
                            error.insertAfter("#pre_placement_err");
                            break;
                        default:
                            error.insertAfter(element);
                            break;
                }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },

                highlight: function (element) { 
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "checkbox[]") { // for checkboxes and radio buttons, no need to show OK icon
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
                $('#tab5 .final_confrm', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-name"));
                    } 
                  else if ($(this).attr("data-display") == 'checkbox[]') {
                   var arr_val = [];
                   var checkboxvalues = new Array();
                   $.each($('.drop-options li'),function(index,value)
                    {
                    var object_val = {};
                    object_val = $.trim($(this).text());
                    checkboxvalues.push("&#8728; "+$.trim($(this).text())+"<br>"); 
                    arr_val.push(object_val);
                    });
                    $('#checkbox_array').val(JSON.stringify(arr_val));
                    $('#chackboxvalues').html(checkboxvalues);
                     var arr_quali = new Array();
                     var qualifications_arr = new Array();
                     $.each($('.quali_drop_options li'),function(index,value)
                    {
                    var obj_quali = {};
                    obj_quali = $.trim($(this).text());
                    qualifications_arr.push("&#8728; "+$.trim($(this).text())+"<br>"); 
                    arr_quali.push(obj_quali);
                    });
                     $('#qaulific_array').val(JSON.stringify(arr_quali));
                     $('#education_vals').html(qualifications_arr);
                    
                    }
                  else if($(this).attr("data-display") == 'randomfunc')
                  {
                  appEditor.updateSourceElement();
                  if($('#othrdetail').val()=='<p>&nbsp;</p>')
                      {
                          $('#othrdetail').val('');
                      }
                  var gendr =  $('.gender_radio:checked').val();
                  var gend;
                  switch(gendr) {
             case '0':
               gend = "No preference";
                break;
            case '1':
                 gend = "Male";
                 break;
             case '2':
             gend = "Female";
             break;
             case '3':
             gend = "Transgender";
             break;
             default:
             gend = "No preference";
             break; 
            } 
            $('#gendr_text').html(gend);
                        skills_arr();
                        placement_arr();
                        question_process_arr();
                        get_preview(session_tok);
                   if($('input[name="interradio"]:checked' ).val()== 0)
                   {
                      $('#interviewstarttime').val('');
                      $('#interviewendtime').val('');
                      $('#time1').html('');
                      $('#time2').html('');
                    }
                }
                 else if($(this).attr("data-display") == 'placement_locations[]' || $(this).attr("data-display") == 'specialskillsrequired' || $(this).attr("data-display") == 'primaryfield' || $(this).attr("data-display") == 'interviewcity[]')
                    {
                      var interviewcitynames = new Array();
                      var getintercity = new Array();
                       $('input[name = "interviewcity[]"]:checked').each(function(){
                          interviewcitynames.push('<span class = "chip">'+ $(this).attr('data-value')+ '</span>');
                          getintercity.push($(this).attr('data-value'));
                    });
                        $('#interviewcitycityvalues').html(interviewcitynames.join(" "));
                        $('#getinterviewcity').val(JSON.stringify(getintercity));
                        var placement_city = new Array();
                        $('input[name = "placement_locations[]"]:checked').each(function(){
                        placement_city.push('<span class = "chip">'+ $(this).attr('data-value')+":"+"("+$(this).next('label').find(".place_no").val()+")"+'</span>');
                  });
                      if ($('#type').val()=='Work From Home'){
                           $('#place_locations').html('');
                       }
                       else
                           {
                               $('#place_locations').html(placement_city.join(" "));
                           }
           
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
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
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
                    if (salarycomparison() === false) {
                        return false;
                    }
                    if (min_weekdays() === false) {
                        return false;
                    }
                    if (duration() === false) {
                        return false;
                    } 
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
function salarycomparison(){
    var max_s = convertToInt($('#max_wage').val());
    var min_s = convertToInt($('#min_wage').val());
    if(max_s < min_s){
        $('.salary_errors').html('<div class = "s_error">Maximum salary cannot less than Minimum salary.</div>');
        $('html, body').animate({ scrollTop: 200 }, 1000);
       return false;
    } else{
        $('.salary_errors').html(' ');
        return true;
    }
    }
function duration()
{
    var numb = $('#internship_duration').val();
    if (numb<=0||numb=='')
        {
        $('.duration_errors').html('<div class = "s_error">Enter a valid number</div>');
        $('html, body').animate({ scrollTop: 200 }, 1000);
            return false;
        }
    else {
        return true;
    }
}    
function min_weekdays()
{
    week_length =  $('[name="weekdays[]"]:checked').length;
    if (week_length==0){
        $('#weekdays').next('p').html('<div class = "s_error">working days cannot be blank</div>');
        $('html, body').animate({ scrollTop: 200 }, 1000);
        return false;
    }
    else
        {
            return true;
        }
}
function convertToInt(t){
    t=t.replace(/\,/g,'');
    t=parseInt(t,10);
    return t;
    }
function warn_validation(string)
{
    return false;
}

var session_tok = "";
genrate_session_token(session_tok);
function genrate_session_token() {
    var possible = "abcdefghijklmnopqrstuvwxyz1234567890";
    for(var i = 0;i < 8; i++) {
        session_tok += possible.charAt(Math.floor(Math.random()*possible.length));
    }
}
function get_preview(session_tok) {
  var data = $('#submit_form').serialize()+'&n='+session_tok;
                    $.ajax({
                         url: preview_url, 
                         data:data, 
                         method:'post',
                         success: function(data) {
                           if (doc_type=='Jobs'||doc_type=='Clone_Jobs'||doc_type=='Edit_Jobs')
                           {
                             $('.button-preview').attr('href','/jobs/job-preview?eipdk='+session_tok+'');
                           }
                       else if(doc_type=="Internships"||doc_type=='Clone_Internships'||doc_type=='Edit_Internships')
                       {
                        $('.button-preview').attr('href','/internships/internship-preview?eipdk='+session_tok+'');
                       }
                       }
                    }); 
            }
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/gmaps/gmaps.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/additional-methods.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-ui/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
