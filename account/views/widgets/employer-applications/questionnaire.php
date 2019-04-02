<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\URL;
?>
<div class="col-md-12 no-padd">
    <div id="select_ques_err"></div>
    <div class="row">
        <div class="col-md-6">
            <h3 class="module2-heading">Choose Questionnaire</h3>
        </div>
        <div class="col-md-6">
            <div class="md-radio-inline text-right clearfix">
                <?=
                $form->field($model, 'questionnaire_selection')->inline()->radioList([
                    1 => 'Add Questionnaire',
                    0 => 'Skip Questionnaire',
                ], [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $return = '<div class="md-radio">';
                        $return .= '<input type="radio" id="que' . $index . '" name="' . $name . '" value="' . $value . '" class="md-radiobtn" ' . (($checked) ? 'checked' : '') . '>';
                        $return .= '<label for="que' . $index . '">';
                        $return .= '<span></span>';
                        $return .= '<span class="check"></span>';
                        $return .= '<span class="box"></span> ' . $label . ' </label>';
                        $return .= '</div>';
                        return $return;
                    }
                ])->label(false);
                ?>
            </div>
            <div class="pull-right c-btn-top clearfix">
                <a onclick="window.open('/account/questionnaire/create', '_blank', 'width=1200,height=900,left=200,top=100');">
                    <?= Html::button('Create Questionnaire', ['class' => 'btn btn-primary btn-md custom-buttons2 custom_color-set2', 'id' => 'add']); ?>
                </a>
            </div>
        </div>
    </div>
</div>
<div id="questionnaire_hide">
    <div id="que_error"></div>
    <?php
    Pjax::begin(['id' => 'pjax_questionnaire']);
    if (!empty($questionnaire)) {
        ?>
        <div class="row">
            <?=
            $form->field($model, 'questionnaire')->checkBoxList($questionnaire, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $return .= '<div class="col-md-9">';
                    $return .= '<div class="radio_questions">';
                    $return .= '<div class="overlay-left"><a href="#" data-id="' . $value . '" class="text questionnaier_display">View</a></div>';
                    $return .= '<div class="inputGroup question_checkbox">';
                    $return .= '<input type="checkbox" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                    $return .= '<label for="' . $value . '">' . $label . '</label>';
                    $return .= '</div>';
                    $return .= '</div>';
                    $return .= '</div>';
                    $return .= '<div class="col-md-3">';
                    $return .= '<div class="selectWrapper">';
                    $return .= '<select class="selectBox">';
                    $return .= '<option value="">Choose Stage</option>';
                    $return .= '</select>';
                    $return .= '</div>';
                    $return .= '</div>';
                    return $return;
                }
            ])->label(false);
            ?>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="empty-section-text">No Questionnaire Found</div>
            </div>
        </div>
        <?php
    }
    Pjax::end();
    ?>
    <input type="text" name="ques_calc" id="ques_calc" readonly>
</div>
<?php
$script = <<< JS
var ques_len = 0;
var stage_len = 0;
var process_len = 0;
 $('.selectBox').prop("disabled", true); 
 if (doc_type=='Clone_Jobs'||doc_type=='Clone_Internships') 
    {
        $('.selectBox').html('<option value="">Choose Stage</option>');
        fetch_hiring_process2('$model->interview_process');
        process_len =  $('[name="interview_process"]:checked').length;
        process_checker(process_len);
        questionnaire_hide_show('$model->questionnaire_selection');
    }
function fetch_hiring_process2(id)
{
    if(!id=="")
        {
           $.ajax({
                 url:'/account/categories-list/process-list',
                 data:{id:id},
                 method:'post',
                 success:function(res)
                 {
                       var obj = JSON.parse(res);
                       var html = []; 
                       $.each(obj,function(index,value)
                             {
                              html.push('<option value="'+value.field_enc_id+'">'+value.field_name+'</option>');
                            });
                        $('.selectBox').append(html);
                        var fields = $model->questionfields;
                        $.each($('[name="questionnaire[]"]:checked'),function(i,v) {
                        questionnaire_process_change($(this),fields[i]);
                        });
                  }
               })
         }
}  
$('input[name= "questionnaire_selection"]').on('change',function(){
        var option = $(this).val();
        questionnaire_hide_show(option)
        });
function questionnaire_hide_show(option)
{
    if(option==1)
            {
             $('#questionnaire_hide').css('display','block');   
             $('#add').css('display','block');   
            }
        else {
            $('#questionnaire_hide').css('display','none');   
            $('#add').css('display','none');   
        }
}
$(document).on('click','.questionnaier_display',function(e) {
    e.preventDefault();
    var data = $(this).attr('data-id');
    window.open('/account/questionnaire/'+data+'/view', "_blank");
}); 
 function ques_checker(ques_len,stage_len)
        {  
          if(ques_len>0&&stage_len>0&&ques_len==stage_len)
          {
              $('#ques_calc').val('1');
           }
           else
           {
            $('#ques_calc').val('');
           }
        }
   function question_process_arr()  
        {
                        var process_question_arr =[];
                        $.each($("input[name='questionnaire[]']:checked"),
                        function(index,value){
                        var obj = {};
                        obj["id"] = $(this).attr('id');
                        obj["process_id"] = $(this).closest('.col-md-9').next().find('.selectBox').val();
                        process_question_arr.push(obj);
                        }); 
              $('#question_process').val(JSON.stringify(process_question_arr)); 

       }
   var box;    
  $(document).on('change','input[name="questionnaire[]"]',function(){
      questionnaire_process_change($(this),"");
   });
function questionnaire_process_change(thisObj,field_enc_id)
{
    if (thisObj.prop("checked")==true) {
        box =  thisObj.closest('.col-md-9').next().find('.selectBox');
        box.prop("disabled", false);
         box.val(field_enc_id);
        ques_len = $('[name="questionnaire[]"]:checked').length;
        stage_len = $('.selectBox option:selected:not([value=""])').length;
        ques_checker(ques_len,stage_len);
        }
        else if (thisObj.prop("checked")==false)
        {
        box =  thisObj.closest('.col-md-9').next().find('.selectBox');
        box.prop("disabled", true);
        box.val("");
        ques_len = $('[name="questionnaire[]"]:checked').length;
        stage_len = $('.selectBox option:selected:not([value=""])').length;
        ques_checker(ques_len,stage_len);
        }
}  
 $(document).on('change','.selectBox',function()
   {
     if($(this).val()!=="")
     {
        ques_len = $('[name="questionnaire[]"]:checked').length;
        stage_len = $('.selectBox option:selected:not([value=""])').length;
        ques_checker(ques_len,stage_len);
     }
     else
     {
        ques_len = $('[name="questionnaire[]"]:checked').length;
        stage_len = $('.selectBox option:selected:not([value=""])').length;
        ques_checker(ques_len,stage_len);
     }
    })       
JS;
$this->registerJs($script);
?>