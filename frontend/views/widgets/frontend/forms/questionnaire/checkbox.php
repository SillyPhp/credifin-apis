<?php
use yii\helpers\ArrayHelper;

$values = ArrayHelper::map($field['options'], 'field_option_enc_id', 'field_option');

//echo $form->field($model, 'field[' . $field['field_enc_id'] . ']')->checkBoxList($values)->label(ucwords($field['field_label']));
$type = $field['field_type'];
?>



    <?=
    $form->field($model, 'field[' . $field['field_enc_id'] . ']')->checkBoxList($values, ['data-type' => 'checkbox','data-id'=>$field['field_enc_id'],
        'item' => function($index, $label, $name, $checked, $value) {
            $return = '<div class="md-checkbox">';
            $return .= '<input type="checkbox" id="1' . $value . '" name="' . $name . '" value="' . $value . '" class="md-check">';
            $return .= '<label for="1' . $value . '">';
            $return .= '<span></span>';
            $return .= '<span class="check"></span>';
            $return .= '<span class="box"></span> ' . ucwords($label) . ' </label>';
            $return .= '</div>';
            return $return;
        } 
    ])->label(ucwords($field['field_label'])); 
    
?>
