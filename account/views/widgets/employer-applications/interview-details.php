<?php
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
?>
<div class="row">
    <div class="col-md-6">
        <h3 class="module2-heading">Walk In Interview Details </h3>
    </div>
    <div class="col-md-6 pull-right">
        <div class="md-radio-inline text-right clearfix">
            <?=
            $form->field($model, 'interradio')->inline()->radioList([
                1 => 'Yes',
                0 => 'No',
            ], [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $return = '<div class="md-radio">';
                    $return .= '<input type="radio" id="1' . $index . '" name="' . $name . '" value="' . $value . '" class="md-radiobtn">';
                    $return .= '<label for="1' . $index . '">';
                    $return .= '<span></span>';
                    $return .= '<span class="check"></span>';
                    $return .= '<span class="box"></span> ' . $label . ' </label>';
                    $return .= '</div>';
                    return $return;
                }
            ])->label(false);
            ?>
        </div>
        <div id="error-checkbox-msg3"></div>
    </div>
</div>
<div class="row">
    <div id="interview_box">
        <div class="col-md-6">
            <?=
            DatePicker::widget([
                'model' => $model,
                'attribute' => 'startdate',
                'id' => 'interview_range',
                'attribute2' => 'enddate',
                'options' => ['placeholder' => 'Start From', 'readonly' => 'readonly'],
                'options2' => ['placeholder' => 'End Date', 'readonly' => 'readonly'],
                'type' => DatePicker::TYPE_RANGE,
                'form' => $form,
                'pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'autoclose' => true,
                    'startDate' => '+0d',
                ]
            ]);
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'interviewstarttime')->widget(TimePicker::classname(), ['pluginOptions' => ['defaultTime' => '9:00 AM']])->label('Starts From');
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'interviewendtime')->widget(TimePicker::classname(), ['pluginOptions' => ['defaultTime' => '5:00 PM']])->label('End');
            ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
$('input[name = "interradio"]').on('change',function()
   {
     var i  = $(this).val();
        if (i==1) 
        {
          $('#interview_box').show();
        }
        else
        {
            $('#interview_box').hide();
        }
   }) 
JS;
$this->registerJs($script);
?>