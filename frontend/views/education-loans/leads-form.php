<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\Select2;
$this->params['background_image'] = '/assets/themes/ey/images/backgrounds/vector-form-job.png';
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4 style="font-size: 16px;font-family: 'roboto'; "><i class="fa fa-check-circle-o"></i> <?= Yii::t('frontend', 'Application Submitted !'); ?></h4>
                <?php
                $session = Yii::$app->session;
                ?>
                <h4 style="font-size: 16px;font-family: 'roboto'; "><i class="fa fa-check-circle-o"></i> Application Number <?= $session->get('app_number'); ?></h4>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <h4><i class="fa fa-check-circle-o"></i> <?= Yii::t('frontend', 'Error'); ?></h4>
                <?= Yii::$app->session->getFlash('error'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="col-md-12 set-overlay">
    <div class="row">
        <div class="f-contain">
            <div class="form-wrapper">
                <?php $form = ActiveForm::begin([
                    'id' => 'leads_form',
                ]); ?>
                <div class="row">
                   <div class="col-md-12">
                       <?= $form->field($model, 'student_name')->textInput(['placeholder'=>'Student Name','class'=>'form-control text-capitalize'])->label(false); ?>
                   </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'student_mobile_number')->textInput(['placeholder'=>'Student Mobile Number'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php $data = \yii\helpers\ArrayHelper::map($data,'text','text'); ?>
                        <?= $form->field($model, 'university_name')->widget(Select2::classname(), [
                            'data' => $data,
                            'options' => ['placeholder' => 'University/College Name','class'=>'form-control text-capitalize'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'tags'=>true
                            ],
                        ])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'course_name')->textInput(['placeholder'=>'Course Name','class'=>'form-control text-capitalize'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'course_fee_annual')->textInput(['placeholder'=>'Annual Course Fee','maxLength'=>20])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div id="clone_fields_parent"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button id="add_parent_info" class="addAnotherCo"><i class="fas fa-plus"></i> Add Parent Information</button>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-12 text-right">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary logo-dark-color']) ?>
                          </div>
                </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    function removeAnotherField(ths) {
        ths.closest('.parent_inforamtion').remove();
    }
</script>
<?php
$script = <<< JS
$('#student_mobile_number').mask("#", {reverse: true});
$('#parent_mobile_number').mask("#", {reverse: true});
$('#parent_annual_income').mask("#", {reverse: true});
$(document).on('click','#add_parent_info',function (e){
    addAnotherField();
});
$(document).on('click','.addAnotherCo',function (e){
    e.preventDefault();
});
function addAnotherField()
{
    var field = ['<div class="col-md-12">' +
     '<div><label class="p_label">Parent Information</label></div>'+
     '<div class="form-group"><input type="text" name="parent_name[]" class="form-control text-capitalize" placeholder = "Name" id="parent_name[]" required></div>' +
     '<div class="form-group"><input type="text" name="parent_relation[]" class="form-control text-capitalize" placeholder = "Relation With Student" id="parent_relation[]" required></div>' +
     '<div class="form-group"><input type="text" name="parent_mobile_number[]" class="form-control parent_mobile_number" placeholder = "Mobile Number" id="parent_mobile_number[]"></div>' +
     '<div class="form-group"><input type="text" name="parent_annual_income[]" class="form-control parent_annual_income" placeholder = "Annual Income" id="parent_annual_income[]"></div>' +
     '<div class"pull-right">'+
     '<button type="button" class="addAnotherCo input-group-text float-right" onclick="removeAnotherField(this)"><i class="fas fa-times"></i> Remove</button>'+
     '</div>'+
     '</div>'];
            var textnode = document.createElement("div"); 
            textnode.setAttribute('class', 'parent_inforamtion');
            textnode.innerHTML = field; 
            $('#clone_fields_parent').prepend(textnode);
}
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/fonts/fontawesome-5/css/all.css');
$this->registerCss("
.addAnotherCo{
    background: none;
    border:none;
    margin-bottom:20px;
}
.addAnotherCo:hover{
    color:#00a0e3;
    transition: .3s ease;
}
.p_label{
font-size: 13px;
}
.logo-dark-color{
    background-color: #00a0e3;
    border-color: #00a0e3;
}
.set-overlay{
    background-color: #ffffffd9;
    padding: 30px 30px 40px;
    box-shadow: 0px 0px 16px 6px #b3b3b399;
    border-radius: 6px;
}
.form-wrapper{
    padding: 25px 20px 0px;
}
");
?>
