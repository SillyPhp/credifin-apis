<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
$url = \yii\helpers\Url::to(['/cities/career-city-list']);
?>
<div class="container">
    <div class="portlet light" id="form_wizard_1">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-layers font-red"></i>
                <span class="caption-subject font-red bold uppercase">Training Program
                </span>
            </div>
        </div>
    <div class="portlet-body form">
        <?php $form = ActiveForm::begin([
            'id' => 'training_form',
            'fieldConfig' => [
                'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}{error}</div>",
            ]
        ]);
        ?>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model,'profile')->dropDownList($primary_cat,['prompt'=>'Course Profile'])->label(false); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model,'title')->textInput(['id'=>'title'])->label('Course Title'); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model,'fees')->textInput(['id'=>'fees'])->label('Fees'); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model,'fees_type')->dropDownList([1=>'Monthly',2=>'Weekly',3=>'Annually',4=>'One Time'])->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="module2-heading">
                    Course Description
                </div>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'description')->textArea(['rows' => 6, 'cols' => 50, 'id' => 'description'])->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="module2-heading">
                   Skills Required
                </div>
            </div>
            <div class="col-md-12">
                <span class="pf-title">Required Skills For The Course</span>
                <div class="pf-field no-margin">
                    <ul class="tags skill_tag_list">
                        <li class="addedTag">Php<span
                                    onclick="$(this).parent().remove();"
                                    class="tagRemove">x</span><input type="hidden"
                                                                     name="skills[]"
                                                                     value="php">
                        </li>
                        <li class="tagAdd taglist">
                            <div class="skill_wrapper">
                                <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                <input type="text" id="search-skill" class="skill-input">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('Submit',['class'=>'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
    </div>
</div>
<?php
$this->registerCss('
.module2-heading{
    text-transform: uppercase;
    font-size: 22px;
    padding: 20px 0 0 0;
    color: #00a0e3; 
    margin-top:5px;
    font-weight: initial;
}
.ck-content{
    min-height:180px;
}
.pf-title{
    margin-bottom: 5px;
    font-weight:bold;
}
');
$script = <<< JS
let appEditor;
 ClassicEditor
    .create(document.querySelector('#description'), {
        removePlugins: [ 'Heading', 'Link' ],
        toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]
    }  )
    .then( editor => {
        appEditor = editor;
    } )
    .catch( error => {
        console.error( error );
    } );
JS;
$this->registerJs($script);
$this->registerCssFile("@web/assets/themes/jobhunt/css/icons.css");
$this->registerCssFile("@web/assets/themes/jobhunt/css/style.css");
$this->registerCssFile("@web/assets/themes/jobhunt/css/chosen.css");
$this->registerCssFile("@web/assets/themes/jobhunt/css/colors/colors.css");
$this->registerJsFile('@root/assets/vendor/ckeditor/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

