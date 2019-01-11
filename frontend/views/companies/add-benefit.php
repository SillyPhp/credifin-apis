<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
$benefit = ArrayHelper::index($benefits, 'benefit_enc_id');
?>
    <div class="modal-header">
        <h4 class="modal-title"><?= Yii::t('frontend', 'Add New Employee Benefit'); ?></h4>
    </div>
<?php
$form = ActiveForm::begin([
    'id' => 'benefit-form',
    'fieldConfig' => [
        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
    ]
]);
?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= $form->field($addEmployeeBenefitForm, 'add_benefit')->textInput(['autocomplete' => 'off', 'id' => 'url']); ?>
        </div>
    </div>
    <div class="cat-sec">
        <div class="row no-gape">

            <?=
            $form->field($addEmployeeBenefitForm, 'emp_benefit')->checkBoxList($benefit, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $return .= '<div class="col-lg-3 col-md-3 col-sm-6 p-category-main">';
                    $return .= '<div class="p-category">';
                    $return .= '<input type="checkbox" id="' . $label['benefit_enc_id'] . '" name="' . $name . '" value="' . $value . '" class="checkbox-input" ' . (($checked) ? 'checked' : '') . '>';
                    $return .= '<label for="' . $label['benefit_enc_id'] . '" class="checkbox-label">';
                    $return .= '<div class="checkbox-text">';
                    $return .= '<span class="checkbox-text--title">';
                    $return .= '<img src="' . Url::to("@commonAssets/employee_benefits/" . $label['icon']) . '">';
                    $return .= '</span><br/>';
                    $return .= '<span class="checkbox-text--description2">';
                    $return .= $label['benefit'];
                    $return .= '</span>';
                    $return .= '</div>';
                    $return .= '</label>';
                    $return .= '</div>';
                    $return .= '</div>';
                    return $return;
                }
            ])->label(false);
            ?>
        </div>
    </div>
    <div class="modal-footer">
        <?= Html::submitbutton('Save', ['class' => 'btn btn-primary custom-buttons2']); ?>
        <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
    </div>
<?php ActiveForm::end(); ?>
<?php
$this->registerCss("    
.modal-header{
    color:blue;
}
");
$script = <<<JS
$(document).on('submit', '#benefit-form', function (event) {
    event.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        url: '/companies/submit-benefit',
        type: 'post',
        data: data,
        beforeSend:function(){
              $('#page-loading').fadeIn(1000);
        },
        success: function (response) {
                $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $("#benefit-form")[0].reset();
                $.pjax.reload({container: '#pjax_benefit', async: false});
                $('#modal').modal('hide');
            } else {
                toastr.error(response.message, response.title);
            }
        }
    });
});
JS;
$this->registerJs($script);