<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
$benefit = ArrayHelper::index($benefits, 'benefit_enc_id');
?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?= Yii::t('account', 'Employee Benefits'); ?></h4>
    </div>
<?php
$form = ActiveForm::begin([
    'id' => 'benefits-form',
    'fieldConfig' => [
        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
    ]
]);
?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($BenefitsModel, 'benefit')->label('<i class="fa fa-building"></i> Add Employer Benefits'); ?>
        </div>
    </div>
    <div class="cat-sec">
        <div class="row no-gape">
            <?=
            $form->field($BenefitsModel, 'predefind_benefit')->checkBoxList($benefits, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    if(empty($label['icon'])){$label['icon'] = 'plus-icon.svg';}
                    $return .= '<div class="col-lg-3 col-md-3 col-sm-6 p-category-main">';
                    $return .= '<div class="p-category">';
                    $return .= '<input type="checkbox" id="' . $label['benefit_enc_id'] . '" name="' . $name . '" value="' . $label['benefit_enc_id'] . '" class="checkbox-input" ' . (($checked) ? 'checked' : '') . '>';
                    $return .= '<label for="' . $label['benefit_enc_id'] . '" class="checkbox-label-v2">';
                    $return .= '<div class="checkbox-text">';
                    $return .= '<span class="checkbox-text--title">';
                    $return .= '<img src="' . Url::to('/assets/icons/').$label["icon_location"].'/'.  $label["icon"] . '">';
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
        <?= Html::submitbutton('Add', ['class' => 'btn btn-primary custom-buttons2 sav_benft']); ?>
        <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
    </div>
<?php ActiveForm::end(); ?>
<?php
$script = <<< JS
    $(document).on('submit', '#benefits-form', function (event) {
        event.stopImmediatePropagation();
        event.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            beforeSend: function (){
                $('.sav_benft').prop('disabled', 'disabled');
            },
            success: function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message, response.title);
                    $("#benefits-form")[0].reset();
                    $.pjax.reload({container: '#pjax_benefits', async: false});
                } else {
                    toastr.error(response.message, response.title);
                }
                $('#modal').modal('toggle');
            }
        });
    });
JS;
$this->registerJs($script);
$this->registerCss("

");
