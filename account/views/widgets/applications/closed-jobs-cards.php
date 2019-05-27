<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$total_applications = count($applications);
$next = 0;
Pjax::begin(['id' => 'pjax_active_jobs']);
if (!empty($total_applications)) {
    ?>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-actions">
                    <?php
                    if (!empty($applications)) { ?>
                        <?php foreach ($applications as $application) { ?>
                            <div class="mt-action">
                                <div class="mt-action-img" style="width: auto">
                                    <a href="<?= $application['link'] ?>">
                                            <img src="<?= Url::to('@commonAssets/categories/' . $application["icon"]); ?>" width="50px" height="50" class="img-circle"/>
                                    </a>
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-details ">
                                                <span class="mt-action-author"><a href="<?= $application['link'] ?>"><?= $application['name']; ?></a></span>
                                                <p class="mt-action-desc">Expired On <?= date("d-m-Y", strtotime($application['last_date'])); ?></p>
                                            </div>
                                        </div>
                                        <div class="mt-action-buttons">
                                            <div class="btn-group btn-group-circle">
                                                <a href="#" class="btn btn-outline green btn-sm datepicker_opn" data-id="<?= $application['application_enc_id']?>" data-date="<?= date("d-m-Y", strtotime($application['last_date'])); ?>">Re-open</a>
                                                <a href="<?= Url::toRoute($application['application_type'] . DIRECTORY_SEPARATOR . $application["application_enc_id"] . DIRECTORY_SEPARATOR . 'clone'); ?>" target="_blank" class="btn btn-outline green btn-sm">Clone</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <h3>No Closed Jobs</h3>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div id="form_modal2" class="modal fade in" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Re-Open The Application</h4>
                </div>
                <div class="modal-body">
                <?php
                $form = ActiveForm::begin([
                    'id'=>'extends_job',
                    'action'=>'extends-date'
                ]);
                      echo $form->field($model, 'date')->widget(DatePicker::classname(), [
                                            'options' => ['placeholder' => 'Last Date To Apply'],
                                            'readonly' => true,
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'format' => 'dd-M-yyyy',
                                                'name' => 'date',
                                                'todayHighlight' => true,
                                                'startDate' => '+0d',
                                            ]])->label(false);
                      echo $form->field($model, 'application_enc_id', ['template' => '{input}'])->hiddenInput(['id' => 'application_enc_id'])->label(false);
                                        ?>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Save',['class'=>'btn green']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <?php
} else { ?>
    <h3>No Closed Jobs</h3>
<?php }
Pjax::end();
$this->registerCss("

");
$script = <<<JS
$(document).on('click','.datepicker_opn',function(e) {
e.preventDefault();
$('#application_enc_id').val($(this).attr('data-id'));
$('#form_modal2').modal('show');
});
JS;
$this->registerJs($script);
