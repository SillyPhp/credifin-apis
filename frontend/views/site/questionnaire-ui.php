<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;


$this->title = Yii::t('frontend', 'form');
$this->params['background_image'] = Url::to('@eyAssets/images/backgrounds/bg-sign-up.jpg');
?>
<style>
/*    .wrapper{overflow: hidden; min-height: 100%;  padding:20px 15px; }
    .form-wrapper{max-width: 700px; margin: 0 auto; padding: 0px 20px;}
    .form-group{padding:15px 0 10px 0; }
    .f-contain{padding: 20px 0;  }
    .form-group button{margin-top: 20px; }
    button{background: #00a0e3; color: #fff; padding: 8px 15px; border: none; 
           border-radius:15px;}
    .mb-60{ margin-bottom: 0px !important;}
    .questionnair-ui > .form-group > label{padding: 10px 10px 3px 8px; margin-bottom: 0px !important;
                                           color: #00a0e3 ; font-size: 20px; font-weight: 500; }
    .main-heading{font-size: 20px; font-weight: 500; color: #ff7803; font-family: lobster; text-align: center }

    input[type="text"], input[type="date"], input[type="time"], input[type="number"]{background:rgba(255,255,255,.6); 
                                                                                     border-radius:10px; 
                                                                                     box-shadow: 0 0 10px rgba(0,0,0,.1);
                                                                                     border: 1px solid #c2cad8; height: 60px;
                                                                                     color: #999999;  
    }
    input[type="text"]:focus,input[type="date"]:focus,input[type="time"]:focus,
    input[type="number"]:focus,.form-group > textarea:focus{border-bottom: 4px solid #c2cad8;
                                                            box-shadow: 0 0 10px rgba(0,0,0,.1) !important;
                                                            transition: .2s all;}
    .form-control{ padding: 18px 12px !important;}
    .form-group > textarea {  
        height: 100px;
        padding:15px 10px;
        border: 1px solid #c2cad8;
        border-radius: 10px;
        background:rgba(255,255,255,.6);
        resize: none;
    }
    .md-radio {background:rgba(255,255,255,.6); border-radius:10px; box-shadow: 0 0 10px rgba(0,0,0,.1);
               border: 1px solid #c2cad8; height: 60px; padding:20px 10px; margin-bottom: 5px;}
    .md-radio label{color:#999999; font-weight: normal !important; margin-top: -2px;}
    .md-radio label>.box{border:2px solid #c2cad8; background:rgba(255,255,255,.6);  margin:20px 10px;}
    .md-radio label>.check{margin:20px 10px ;}
    .md-checkbox {background:rgba(255,255,255,.6); border-radius:10px; box-shadow: 0 0 10px rgba(0,0,0,.1);
                  border: 1px solid #c2cad8; height: 60px; padding:20px 10px; margin-bottom: 5px;}
    .md-checkbox label{color:#999999; font-weight: normal !important; margin-top: -2px; }
    .md-checkbox label>.box{border:2px solid #c2cad8; background:rgba(255,255,255,.6); margin:20px 10px;}
    .md-checkbox label>.check{margin:20px 10px ;}
    .form-group > select {
        height: 60px;
        border-radius:10px !important;
        color:#999999;
        padding: 0px 10px;
        border: 1px solid #c2cad8;
        border-radius: 5px;
        background:rgba(255,255,255,.6);  
    }
    .divider .container{padding-bottom: 0px; }
    .mb-60 > a > img { width: 30%;}*/
</style>
<div class="wrapper">
    <div class="row"> 
        <div class="f-contain"> 
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="main-heading">Please answer the following questions.</div>
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
                <?php
//                $option_fields = [];
//                foreach($data as $d){
//                    if($d['field_option_enc_id']) {
//                        if(array_key_exists($d['field_enc_id'],$option_fields)){
//                            $option_fields[$d['field_enc_id']]['options'] =
//                                [
//                                    'field_option_enc_id' => $d['field_option_enc_id'],
//                                    'field_option' => $d['field_option']
//                                ];
//                        }
//                        else {
//                            $option_fields[$d['field_enc_id']][] = [
//                                'field_enc_id' => $d['field_enc_id'],
//                                'field_type' => $d['field_type'],
//                                'field_label' => $d['field_label'],
//                                'options' => [
//                                    'field_option_enc_id' => $d['field_option_enc_id'],
//                                    'field_option' => $d['field_option']
//                                ]
//                            ];
//                        }
//                    }else{
//                        $option_fields[$d['field_enc_id']][] = [
//                            'field_enc_id' => $d['field_enc_id'],
//                            'field_type' => $d['field_type'],
//                            'field_label' => $d['field_label'],
//                            'options' => []
//                        ];
//                    }
//                }
                //print("<pre>".print_r($option_fields,true)."</pre>");
                ?>
              
                
                <div class="row">
                <?php
                foreach ($fields['fields'] as $field) { ?>
                    <div class="col-md-6 col-md-offset-3">
                         <?php  
                        echo $this->render('/widgets/frontend/forms/questionnaire/' . $field['field_type'], [
                            'model' => $model,
                            'form' => $form,
                            'field' => $field,
                        ]); 
                        ?>
                    </div>
                     
                <?php   
                }
                ?>
                    <div class="col-md-6 col-md-offset-3">
                        <?= Html::submitButton('Submit',['class'=>'btn btn-primary sav_ques']) ?>
                    </div>
                    
                </div>      
<!--                <div class="form-group col-md-12">
                    <label for="inputEmail4">Enter your Fullname</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name">
                    <div class=""> <button type="button" id="ok">Enter</button> </div>
                </div>
                <div class="form-group col-md-12">
                    <label for="inputPassword4">What is your first reaction to the product?</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-radio">
                                <input type="radio" id="radio1" name="radio1" class="md-radiobtn">
                                <label for="radio1">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Option 1 </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-radio">
                                <input type="radio" id="radio2" name="radio1" class="md-radiobtn">
                                <label for="radio2">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Option 1 </label>
                            </div>
                        </div><div class="col-md-6">
                            <div class="md-radio">
                                <input type="radio" id="radio3" name="radio1" class="md-radiobtn">
                                <label for="radio3">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Option 1 </label>
                            </div>
                        </div><div class="col-md-6">
                            <div class="md-radio">
                                <input type="radio" id="radio4" name="radio1" class="md-radiobtn">
                                <label for="radio4">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Option 1 </label>
                            </div>
                        </div>
                        <div class="col-md-12"><button type="button" id="ok">Enter</button></div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label for="inputAddress">Address</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div>
                <div class="form-group">
                    <label class="control-label">What is your first reaction to the product?</label>
                    <textarea rows="5" name="text-area_21050" placeholder="Type your answer" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label">How would you rate the quality of the product?</label>
                    <select class="form-control" name="name_77794"><option value="Value">Option</option></select>
                </div>
                <div class="form-group col-md-12">
                    <label for="inputPassword4">What is your first reaction to the product?</label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="md-checkbox">
                                <input type="checkbox" id="checkbox1" class="md-check">
                                <label for="checkbox1">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Option 1 </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="md-checkbox">
                                <input type="checkbox" id="checkbox2" class="md-check">
                                <label for="checkbox2">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Option 1 </label>
                            </div>
                        </div><div class="col-md-6">
                            <div class="md-checkbox">
                                <input type="checkbox" id="checkbox3" class="md-check">
                                <label for="checkbox3">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Option 1 </label>
                            </div>
                        </div><div class="col-md-6">
                            <div class="md-checkbox">
                                <input type="checkbox" id="checkbox4" class="md-check">
                                <label for="checkbox4">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> Option 1 </label>
                            </div>
                        </div>
                        <div class="col-md-12"><button type="button" id="ok">Enter</button></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Enter Date</label>
                    <input type="date" name="date-field_39155" class="form-control">
                </div>
                <div class="form input-group date">
                    <input type="text" class="form-control date-picker" value="12-02-2012">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label">Enter Time</label>
                    <input type="time" name="time-field_71254" value="12:02" class="form-control valid" aria-invalid="false">
                </div>
                <div class="form-group">
                    <label class="control-label">Enter your phone number</label>
                    <input type="number" name="number_30558" placeholder="" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <?php ActiveForm::end(); ?>
            </div>              
        </div> 
    </div> 
</div> -->
<?php
//$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
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
           success:function(data)
           {
             if(data==true){
            alert('Success');
            $('#modal_que').modal('toggle');
          }
        else{
          alert('Error');
        }
           }
        
           })
        
    })
JS;
$this->registerJs($script);
$this->registerCss("
//.datepicker>div{
//    display:block;
//}
.separator{
    width:auto;
}

           .form-group  label
            {
             
             color: #00a0e3 ; 
             
             font-weight: 500;
            }
        ");
$this->registerCssFile('@backendAssets/global/css/components-rounded.min.css');
//$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);