<?php
use yii\helpers\ArrayHelper;

$values = ArrayHelper::map($field['options'], 'field_option_enc_id', 'field_option');

echo $form->field($model, 'field[' . $field['field_enc_id'] . ']')->dropDownList($values,['data-type'=>'select','data-id'=>$field['field_enc_id']])->label(ucwords($field['field_label']));