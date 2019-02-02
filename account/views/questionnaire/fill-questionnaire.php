<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->title = Yii::t('account', 'Quesionnaire');
$this->params['grid_size'] = 'col-md-8 col-md-offset-2';
?>
    <div class="col-md-12 set-overlay">
        <div class="row">
            <div class="f-contain">
                <?php if(empty($chk)) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-heading text-center"><h3>Please answer the following questions</h3></div>
                        </div>
                    </div>

                    <div class="form-wrapper">
                        <?php
                        $form = ActiveForm::begin([
                            'id' => 'quesionnaire-form',
                            'options' => [
                                'class' => 'questionnair-ui',
                            ],
                            'fieldConfig' => [
                                'template' => '{label}{input}{error}',

                            ],
                        ]);
                        ?>
                        <div class="row">
                            <?php
                            foreach ($fields['fields'] as $field) { ?>
                                <div class="col-md-12">
                                    <?php
                                    echo $this->render('/widgets/forms/questionnaire/' . $field['field_type'], [
                                        'model' => $model,
                                        'form' => $form,
                                        'field' => $field,
                                    ]);
                                    ?>
                                </div>

                                <?php
                            }
                            ?>
                            <div class="col-md-12">
                                <?= Html::submitButton('Submit',['class'=>'btn btn-primary sav_ques']) ?>
                            </div>

                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                <?php } else { ?>
                    <h3>You have already answered the questionnaire..!!</h3>
                <?php } ?>
            </div>
        </div>
    </div>
<?php
$script = <<< JS
$(document).on('submit','#quesionnaire-form',function(e)
    {
        e.preventDefault();
        var url = $(this).attr('action');
       var result = [];
       $("form#quesionnaire-form div,:input").each(function(){
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
              var val =  $("input[name='QuestionnaireForm[field]["+id+"]']:checked"). val();
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
             $("input[name='QuestionnaireForm[field]["+id+"][]']:checked").each(function(){
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
           url:url,
           method:'post',
           data:{data:data},
           beforeSend: function()
                       {
                         $('.sav_quest').prop('disabled','disabled');
                         $('.sav_quest').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                       },
           success:function(data)
           {
             if(data==true){
        $('.sav_ques').prop('disabled','');
        window.location.replace('/account/dashboard');
          }
        else{
          alert('Internal Server Error');
        }
           }
        
           })
        
    })
JS;
$this->registerJs($script);
$this->registerCss('
body  {
    background-image: url( ' . Url::to("@eyAssets/images/backgrounds/lco.png") . ' );
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
}
.layer-overlay.overlay-white-9::before {
    background-color: rgba(255, 255, 255, 0.49);
}
#home {
    padding-bottom: 100px;
}
.set-overlay{
    background-color: #ffffffd9;
    padding: 30px 30px 40px;
    box-shadow: 0px 0px 16px 6px #b3b3b399;
    border-radius: 6px;
}
label{
    text-transform: uppercase;
    font-size: 16px;
    font-weight: 600;
}
.main-heading h3{
    margin:0px;
}

.separator{
   width:auto;
}
     .form-group  label
            {
             
             color: #00a0e3 ; 
             
             font-weight: 500;
            }
        ');
$this->registerCssFile('@backendAssets/global/css/components-rounded.min.css');
