<?php 

use kartik\widgets\TimePicker;

echo $form->field($model, 'field[' . $field['field_enc_id'] . ']')->widget(TimePicker::classname(),[
    'options'=>[
        'data-type'=>'time',
        'data-id'=>$field['field_enc_id'],
    ]
])->label(ucwords($field['field_label']));


?>