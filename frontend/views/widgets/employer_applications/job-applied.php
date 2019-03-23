<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
$location = ArrayHelper::map($locations,'city_enc_id','name');
Yii::$app->view->registerJs('var btn_class = "'. $btn_class.'"',  \yii\web\View::POS_HEAD);
?>
<?php $form = ActiveForm::begin(['id' => 'resume_form']); ?>
<div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Fill Out The Details</h4>
            </div>
            <div class="modal-body">
                <?php if (!empty($location)) {
                    echo $form->field($model, 'location_pref')->inline()->checkBoxList($location)->label('Select Placement Location');
                } ?>
                <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput(['id' => 'application_id', 'value' => $application_enc_id]); ?>
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
                    <?= $form->field($model, 'resume_file')->fileInput(['id' => 'resume_file'])->label('Upload Your CV In Doc, Docx,Pdf Format Only'); ?>
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
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<div id="message_img">
    <span id='close_btn'><i class="fa fa-times"></i></span>
    <div id="msg">
        <img src="https://i.ibb.co/TmV51CY/done.png">
        <h1 class="heading_submit">Submitted!</h1>
        <p class="sub_description_1">Your Application Has been successfully registerd with the recruiter. keep check
            your Dashboard Regularly for further confirmation from the recruiter side.</p>
        <p class="sub_description_2">Your Application Has been successfully registerd But There Are Some
            Questionnaire Pending From Your Side you can fill them now By clicking <a
                    href="<?= URL::to('/account/dashboard') ?>" target="_blank">Here</a> Or You can fill them Later.
            <br><b>Please Note:</b>Your Application Would not be process further if your didn't fill them!</p>

    </div>
</div>
<?php
$this->registerCss("
 #message_img{
      display:none;
    }
    
    #message_img.show{
        display : block;
        position : fixed;
        z-index: 100;
        background-color:#33cdbb;
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
                      var check = 1;
                       var loc_array = [];
                       $("input[name='JobApplied[location_pref][]']:checked").each(function(){
                        loc_array.push($(this).val()); 
                        });
                      var resume_enc_id = $('input[name="JobApplied[resume_list]"]').val();
                      formData.append('application_enc_id',id);
                      formData.append('resume_enc_id',resume_enc_id);
                      formData.append('check',check);
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
                if($.inArray(ext, ['pdf','doc','docx']) == -1) {
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
                    url:'/account/jobs/jobs-apply',
                    dataType: 'text',  
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,                         
                    type: 'post',
                 beforeSend:function()
                 {
                 $('.sav_job').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                 },     
                 success:function(data)
                 {
            var res = JSON.parse(data);
            if(res.status == true && $('#question_id').val() == 1){
                        applied();
                        $('.sub_description_2').css('display','block');
                        $('.sub_description_1').css('display','none');
                        $('#message_img').addClass('show');
                        $('.fader').css('display','block');
                     }
                    else if(res.status == true)
                      {
                        $('.sub_description_1').css('display','block');
                        $('.sub_description_2').css('display','none');
                        $('#message_img').addClass('show');
                        $('.fader').css('display','block');
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
                     $('.'+btn_class+'').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                     $('.'+btn_class+'').html('<i class = "fa fa-check"></i>Applied');
                     $('.'+btn_class+'').attr("disabled","true");
            }
JS;

$this->registerJs($script)
?>
