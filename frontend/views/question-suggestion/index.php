<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->params['header_dark'] = true;
?>
<div id="user_opinion_block">
<div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="ques-box">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'user_opinion',
                    'options' => [
                        'class' => 'questionnair-ui',
                    ],
                    'fieldConfig' => [
                        'template' => '{label}{input}{error}',

                    ],
                ]);
                ?>
                <?=$this->renderAjax('/widgets/frontend/forms/questionnaire/' . $field['field_type'], [
                    'model' => $model,
                    'form' => $form,
                    'field' => $field,
                ]);
                ?>
                <input type="hidden" value="<?=$field['questionnaire_enc_id'] ?>" id="hidden_qid">
                <?= Html::submitButton('Submit', ['class' => 'btn submit-bttn sav_ques']); ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
</div>
</div>
<?php
$script = <<< JS
$(document).on('submit','#user_opinion',function(e) {
  e.preventDefault();
  var result = [];
  var id = $('#hidden_qid').val();
       $("form#user_opinion div,:input").each(function(){
            var input = $(this).attr('data-type');
            var val = $(this).val();
            if(input=='text'){
             var val = $(this).val();
             var id = $(this).attr('data-id');
               var obj1 = {
                    'type': 'text',
                    'id': id,
                    'answer': val,
                    'option': null
                }
                result.push(obj1); 
           }
            if(input=='textarea'){
             var val = $(this).val();
             var id = $(this).attr('data-id');
               var obj2 = {
                    'type': 'textarea',
                    'id': id,
                    'answer': val,
                    'option': null
                }
                result.push(obj2); 
           }
            if(input=='select'){
             var val = $(this).val();
             var id = $(this).attr('data-id');
               var obj3 = {
                    'type': 'select',
                    'id': id,
                    'answer': null,
                    'option': val
                }
                result.push(obj3); 
           }
            if(input=='radio'){
             var id = $(this).attr('data-id');
              var val =  $("input[name='QuestionnaireViewForm[field]["+id+"]']:checked"). val();
               var obj4 = {
                    'type': 'radio',
                    'id': id,
                    'answer': null,
                    'option': val
                }
                result.push(obj4); 
           }
            if(input=='date'){
             var val = $(this).val();
             var id = $(this).attr('data-id');
               var obj5 = {
                    'type': 'date',
                    'id': id,
                    'answer': val,
                    'option': null
                }
                result.push(obj5); 
           }
            if(input=='number'){
             var val = $(this).val();
             var id = $(this).attr('data-id');
               var obj6 = {
                    'type': 'number',
                    'id': id,
                    'answer': val,
                    'option': null
                }
                result.push(obj6); 
           }
            if(input=='time'){
             var val = $(this).val();
             var id = $(this).attr('data-id');
               var obj8 = {
                    'type': 'time',
                    'id': id,
                    'answer': val,
                    'option': null
                }
                result.push(obj8); 
           }
            if(input=='checkbox'){
             var id = $(this).attr('data-id');
              var checked = [];
             $("input[name='QuestionnaireViewForm[field]["+id+"][]']:checked").each(function(){
            checked.push($(this).val());
            });
               var obj7 = {
                    'type': 'checkbox',
                    'id': id,
                    'answer': null,
                    'option': checked
                }
                result.push(obj7); 
           }
       });
  var data = JSON.stringify(result);
  $.ajax({
        url:'/question-suggestion/save-response',
        data:{data:data,id:id},
        method:'post',
        dataType: 'json',
        beforeSend: function()
        {
          $('.sav_ques').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
          $('.sav_ques').attr("disabled", "true");
        },
        success: function(data)
        {
         if (data){
             $('.sav_ques').html('<i class = "fas fa-check"></i>Submitted');
              $("#user_opinion_block").fadeOut("normal", function() {
               $('#user_opinion_block').remove();
             });
         }
        }
});
})
JS;
$this->registerJs($script);
$this->registerCss('
.ques-box{
    margin-top:20px;
    box-shadow: 0px 1px 10px 2px #eee !important;
    padding:10px;
    text-align:center;
    background:#00a0e3;
}
.control-label,label
{
color: #fff;
text-transform: uppercase;
font-weight: 300;
font-family: roboto;
font-size: 18px;
}
.ans-options{
    margin-top: 15px;
}
.ques{
    text-align:center;
    font-size:20px;
    font-family:roboto;
//    font-weight:bold;
    color:#fff
}
.service-list{
 display: inline-block;
}
.service-list label{
   display: inline-block;
   background-color: rgba(255, 255, 255, 1);
//   border: 2px solid rgba(139, 139, 139, .3);
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
   
   width:45%;
   margin:5px;
   float:left;
   text-align:center;
   padding: 8px 12px;
   cursor: pointer;
}
.service-list label::before {
   display: inline-block;
   font-style: normal;
   font-variant: normal;
   text-rendering: auto;
   -webkit-font-smoothing: antialiased;
   font-family: \'Font Awesome 5 Free\';
   font-weight: 900;
   font-size: 12px;
   padding: 2px 6px 2px 2px;
   content: \'067\';
   transition: transform .3s ease-in-out;
}
.service-list input[type=\'checkbox\']:checked + label::before {
   content: \'00c\';
   transform: rotate(-360deg);
   transition: transform .3s ease-in-out;
}
.service-list input[type=\'checkbox\']:checked + label, .service-list label:hover {
//   border: 2px solid #00a0e3;
//   background-color: #00a0e3;
   color: #00a0e3;
   transition: all .2s;
}
.service-list input[type=\'checkbox\'] {
 display: absolute;
}
.service-list input[type=\'checkbox\'] {
 position: absolute;
 opacity: 0;
}
.service-list input[type=\'checkbox\']:focus + label {
// border: 2px solid #00a0e3;
}
')
?>
