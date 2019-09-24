<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$college = ArrayHelper::map($colleges, 'organization_enc_id', 'name');
?>
    <div id="select-colleges-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><?= Yii::t('account', 'Add Employee'); ?></h4>
                </div>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'select-college-form',
                    'fieldConfig' => [
                        'template' => "<div class='form-group form-md-line-input form-md-floating-label'>{input}{label}{hint}{error}</div>",
                    ]
                ]);
                ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $saveCollege->college_id = ArrayHelper::getColumn($addedColleges, 'college_enc_id');
                            ?>
                            <?=
                            $form->field($saveCollege, 'college_id')->checkBoxList($college, [
                                'item' => function ($index, $label, $name, $checked, $value) {
                                    $return .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 p-category-main">';
                                    $return .= '<input type="checkbox" id="' . $value . '" name="' . $name . '" value="' . $value . '" class="checkbox-input" ' . (($checked) ? 'checked' : '') . '>';
                                    $return .= '<label for="' . $value . '" class="checkbox-label-v2">';
                                    $return .= $label;
                                    $return .= '</label>';
                                    $return .= '</div>';
                                    return $return;
                                }
                            ])->label(false);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= Html::submitbutton('Submit', ['class' => 'btn btn-primary custom-buttons2 submit-colleges']); ?>
                    <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
                </div>
                <?php
                ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
<?php
$this->registerCss('

');
$script = <<< JS
$(document).on('submit', '#select-college-form', function (event) {
    var me = $('.submit-colleges');
    event.preventDefault();
    if ( me.data('requestRunning') ) {
        return;
    }
    me.data('requestRunning', true);
    var url = '/account/jobs/submit-colleges';
    var data = $('#select-college-form').serialize();
    $.ajax({
        url: url,
        type: 'post',
        data: data,
        beforeSend: function (){
            // $('.sav_benft').prop('disabled', 'disabled');
        },
        success: function (response) {
            if (response.status == 'success') {
                toastr.success(response.message, response.title);
                // $("#select-college-form")[0].reset();
                // $.pjax.reload({container: '#pjax_benefits', async: false});
            } else {
                toastr.error(response.message, response.title);
            }
            $('#modal_benefit').modal('toggle');
        },
        complete: function() {
        me.data('requestRunning', false);
      }
    });
});
JS;
$this->registerJs($script);