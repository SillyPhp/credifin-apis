<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\URL;
?>
<div id="process_err"></div>
<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'getinterviewcity', ['template' => '{input}', 'options' => []])->hiddenInput(['id' => 'getinterviewcity'])->label(false) ?>
        <?= $form->field($model, 'question_process', ['template' => '{input}', 'options' => []])->hiddenInput(['id' => 'question_process'])->label(false) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12  m-padd">
        <div class="row">
            <div class="col-md-6">
                <h3 class="module2-heading">Choose Application Process</h3>
            </div>
            <div class="col-md-6  ">
                <div class="pull-right c-btn-top">
                    <a onclick="window.open('/account/hiring-processes/create', '_blank', 'width=1200,height=900,left=200,top=100');">
                        <?= Html::button('Create Application Process', ['class' => 'btn btn-md btn-primary custom-buttons2 custom_color-set2', 'id' => 'add2']); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
    Pjax::begin(['id' => 'pjax_process']);
    if (!empty($process)) {
        ?>
        <div class="row">
            <div class="col-md-12">
                <?=
                $form->field($model, 'interview_process')->radioList($process, [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $return .= '<div class="col-md-4 text-center">';
                        $return .= '<div class="radio_questions">';
                        $return .= '<div class="overlay-left"><a href="#" data-id="' . $value . '" class="text process_display">View</a></div>';
                        $return .= '<div class="inputGroup process_radio">';
                        $return .= '<input type="radio" id="' . $value . '" name="' . $name . '" value="' . $value . '" ' . (($checked) ? 'checked' : '') . '>';
                        $return .= '<label for="' . $value . '">' . $label . '</label>';
                        $return .= '</div>';
                        $return .= '</div>';
                        $return .= '</div>';
                        return $return;
                    }
                ])->label(false);
                ?>
            </div>
        </div>

    <?php } else {
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="empty-section-text">No Process Found</div>
            </div>
        </div>
        <?php
    }
    Pjax::end();
    ?>
</div>
<input type="text" name="process_calc" id="process_calc" readonly>
<?php
$this->registerCSS('
.proCount{
    background: #eee;
    height: 32px;
    float: right;
    border-radius: 50%;
    width: 32px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
}
');
$script = <<< JS
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
let process_radio = document.querySelectorAll('.process_radio');
if(process_radio.length){
    process_radio[0].querySelector('input[type=radio]').checked = true
}

$('.process_radio')
$(document).on('click','.process_display',function(e) {
    e.preventDefault();
    var data = $(this).attr('data-id');
    window.open('/account/hiring-processes/'+data+'/view', "_blank");
});
$(document).on('change','input[name="interview_process"]',function()
      {
        $('.selectBox').html('<option value="">Choose Stage</option>');
        ques_len = $('[name="questionnaire[]"]:checked').length;
        stage_len = $('.selectBox option:selected:not([value=""])').length;
        ques_checker(ques_len,stage_len);
         var id = $(this).val();
         fetch_hiring_process(id);
   });
function fetch_hiring_process(id)
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
                  }
               })
         }
}   
$(document).on("click",'input[name="interview_process"]', function() {
    checked = $(this);
    if (this.checked == true) {
        process_len =  $('[name="interview_process"]:checked').length;
        process_checker(process_len);
    } 
        
    else {
        process_len =  $('[name="interview_process"]:checked').length;
        process_checker(process_len); 
        
   }   
});
function process_checker(process_len)
        {
          if(process_len == 0)
          {
              $('#process_calc').val('');
           }
          else 
          {
              $('#process_calc').val('1');
           }
        } 
JS;
$this->registerJs($script);
?>