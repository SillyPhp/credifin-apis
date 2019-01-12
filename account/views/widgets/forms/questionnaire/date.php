
<?php

use kartik\widgets\DatePicker;

echo $form->field($model, 'field[' . $field['field_enc_id'] . ']')->widget(DatePicker::classname(), [
    'readonly' => true,
    'options'=>[
        'data-type'=>'date',
        'data-id'=>$field['field_enc_id'],
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-M-yyyy',
        'todayHighlight' => true,
]])->label(ucwords($field['field_label']));
?>


