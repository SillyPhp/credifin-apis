<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$location = ArrayHelper::map($locations, 'city_enc_id', 'name');
Yii::$app->view->registerJs('var btn_class = "' . $btn_class . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var application_type = "' . ucwords(Yii::$app->controller->id) . '"', \yii\web\View::POS_HEAD);
?>
<div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <?php $form = ActiveForm::begin(['id' => 'resume_form']); ?>
            <div class="modal-header">
                <h4 class="modal-title">Fill Out The Details</h4>
            </div>
            <div class="modal-body">
                <?php if (!empty($location)) {
                    echo $form->field($model, 'location_pref')->inline()->checkBoxList($location)->label('Select Placement Location');
                } ?>
                <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput(['id' => 'application_id', 'value' => $application_enc_id]); ?>
                <?= $form->field($model, 'org_id', ['template' => '{input}'])->hiddenInput(['id' => 'organization_id', 'value' => $organization_enc_id]); ?>
                <?php
                if ($que) {
                    $ques = 1;
                } else {
                    $ques = 0;
                }
                ?>
                <?= $form->field($model, 'questionnaire_id', ['template' => '{input}'])->hiddenInput(['id' => 'question_id', 'value' => $ques]); ?>
                <?php
                if (!empty($resumes)) {
                    $checkList = [0 => 'Use Existing One', 1 => 'Upload New'];
                } else {
                    $checkList = [1 => 'Upload New'];
                }
                ?>
                <?= $form->field($model, 'check')->inline()->radioList($checkList)->label('Upload Resume') ?>

                <div id="new_resume">
                    <?= $form->field($model, 'resume_file')->fileInput(['id' => 'resume_file'])->label('Upload Your CV In Doc, Docx,Pdf,Jpg,Jpeg,Png Format Only'); ?>
                </div>
                <?php if ($resumes) { ?>
                    <div id="use_existing">
                        <div class="row">
                            <label id="warn" class="col-md-offset-1 col-md-3">Select One</label>
                            <?php foreach ($resumes as $res) {
                                ?>
                                <div class="col-md-offset-1 col-md-10">
                                    <div class="radio_questions">
                                        <div class="inputGroup">
                                            <input id="<?= $res['resume_enc_id']; ?>" name="JobApplied[resume_list]"
                                                   type="radio" value="<?= $res['resume_enc_id']; ?>"/>
                                            <label for="<?= $res['resume_enc_id']; ?>"> <?= $res['title']; ?> </label>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <?= Html::submitbutton('Save', ['class' => 'btn btn-primary sav_job']); ?>
                <?= Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$this->registerCss("
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
        border-radius: 8px !important;
        line-height: 30px;
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
    .has-success .control-label, .has-success.radio-inline label, .has-success .checkbox-inline, .has-success .radio-inline, .has-error .control-label, .has-error.radio-inline label, .has-error .checkbox-inline{
        color:inherit;
    }
    
    label.control-label {
        font-family: 'Titillium Web', sans-serif;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }
");
$script = <<< JS
  $(document).on('click','.'+btn_class+'',function(e)
            {
             e.preventDefault();
             if($('.'+btn_class+'').attr("disabled") == "disabled")
            {
               return false;
            }
         $('#modal').modal('show'); 
         });
   
   $('input[name="JobApplied[check]"]').on('change',function()
       {
        if($(this).val() == 1)
        {
          $('#use_existing').css('display','none')
          $('#new_resume').css('display','block');
        }
        else if($(this).val() == 0)
        {
           $('#resume_form').yiiActiveForm('validate',false);
            $('#new_resume').css('display','none');
            $('#use_existing').css('display','block');
            
        }
        })
        
         var que_id = $('#question_id').val();
        $(document).on('click','.sav_job',function(e)
            {
                e.preventDefault();
               if($('input[name="JobApplied[location_pref][]"]:checked').length <= 0)
               {
                $('#resume_form').yiiActiveForm('validateAttribute', 'jobapplied-location_pref');
                   return false;
                }
               if($('input[name="JobApplied[check]"]:checked').length > 0){
                if($('input[name="JobApplied[check]"]:checked').val() == 0)
                {
                    if($('input[name="JobApplied[resume_list]"]:checked').length == 0)
                    {
                     $('#warn').css('display','block');
                     $('input[name="JobApplied[check]"]').focus();
                     return false;   
                    }
                    else if ($('input[name="JobApplied[resume_list]"]:checked').length > 0)
                    {
                      var formData = new FormData();
                      var id = $('#application_id').val();
                      var org_id = $('#organization_id').val();
                      var check = 1;
                       var loc_array = [];
                       $("input[name='JobApplied[location_pref][]']:checked").each(function(){
                        loc_array.push($(this).val()); 
                        });
                      var resume_enc_id = $('input[name="JobApplied[resume_list]"]').val();
                      formData.append('application_enc_id',id);
                      formData.append('resume_enc_id',resume_enc_id);
                      formData.append('check',check);
                      formData.append('application_type',application_type);
                      formData.append('org_id',org_id);
                      if($('#question_id').val() == 1)
                        {
                          var status = 'incomplete';
                          formData.append('status',status);
                        }
                      else
                        {
                          var status = 'Pending';
                          formData.append('status',status);
                        }
                      var json_loc = JSON.stringify(loc_array);
                      formData.append('json_loc',json_loc);
                      ajax_call(formData);
                      $('#warn').css('display','none');
                    }
                 }
         else if($('input[name="JobApplied[check]"]:checked').val()==1)
          {     
                if($('#resume_file').val() != '') {            
                 $.each($('#resume_file').prop("files"), function(k,v){
                 var filename = v['name'];    
                 var ext = filename.split('.').pop().toLowerCase();
                if($.inArray(ext, ['pdf','doc','docx','png','jpg','jpeg']) == -1||v['size']>2097152) {
                return false;
              }
          else
        {
            var formData = new FormData();
             var loc_array = [];
                       $("input[name='JobApplied[location_pref][]']:checked").each(function(){
                        loc_array.push($(this).val()); 
                        });
            var formData = new FormData($('form')[0]);
                 var id = $('#application_id').val();
                 var org_id = $('#organization_id').val();
                 if($('#question_id').val() == 1)
                        {
                          var status = 'incomplete';
                          formData.append('status',status);
                        }
                    else
                        {
                          var status = 'Pending';
                          formData.append('status',status);
                        }
                formData.append('id',id);
                formData.append('application_type',application_type);    
                formData.append('org_id',org_id);    
                var json_loc = JSON.stringify(loc_array);
                formData.append('json_loc',json_loc);
                ajax_call(formData);
              }
            });      
            }
            }
           }
          else
         {
         $('#resume_form').yiiActiveForm('validateAttribute', 'jobapplied-check');
         return false;
            }
            })
        
        function ajax_call(formData)
        {
            $.ajax({
                    url:'/jobs/jobs-apply',
                    dataType: 'text',  
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,                         
                    type: 'post',
                 beforeSend:function()
                 {
                 $('.sav_job').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
                 },     
                 success:function(data)
                 {
            var res = JSON.parse(data);
            if(res.status == true && $('#question_id').val() == 1){
                        applied();
                        swal({
                          title: "Submitted!",
                          text: "Your Application Has been successfully registered But There Are Some Questionnaire Pending From Your Side you can fill them now By clicking below Fill Questionnaire button!",
                          type: "success",
                          showCancelButton: true,
                          confirmButtonClass: "btn-primary",
                          confirmButtonText: "Fill Questionnaire!",
                          cancelButtonText: "Fill Later!",
                          closeOnConfirm: false,
                          closeOnCancel: false
                        },
                        function(isConfirm) {
                          if (isConfirm) {
                            window.location.pathname = "/account/dashboard";
                          } else {
                            swal("Please Note!", "Your Application Would not be process further if your don't complete it. To fill it visit your dashboard.", "warning");
                          }
                        });
                     }
                    else if(res.status == true)
                      { 
                         $('#appliedModal').modal('show') 
                          // swal("Submitted!", "Your Application Has been successfully registered with the recruiter. keep checking your Dashboard Regularly for further confirmation from the recruiter side.", "success");
                        applied();
                      }
                      else
                         {
                           alert('something went wrong..');
                         }
                      }
                    });
                    }
  
    function applied()
        {
             $('#modal').modal('toggle');
                     $('.'+btn_class+'').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
                     $('.'+btn_class+'').html('<i class = "fas fa-check"></i>Applied');
                     $('.'+btn_class+'').attr("disabled","true");
            }

JS;

$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
