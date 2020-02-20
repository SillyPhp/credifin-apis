
<?php
use yii\helpers\ArrayHelper;

$values = ArrayHelper::map($field['options'], 'field_option_enc_id', 'field_option');

//echo $form->field($model, 'field[' . $field['field_enc_id'] . ']')->radioList($values)->label(ucwords($field['field_label']));
?>
<div class="md-radio-inline">
    <?=
    $form->field($model, 'field[' . $field['field_enc_id'] . ']')->radioList($values,['data-type' => 'radio','data-id'=>$field['field_enc_id'],
        'item' => function($index, $label, $name, $checked, $value) {
            $return = '<div class="md-radio">';
            $return .= '<input type="radio" id="1' . $value . '" name="' . $name . '" value="' . $value . '" class="md-radiobtn">';
            $return .= '<label for="1' . $value . '">';
            $return .= '<span></span>';
            $return .= '<span class="check"></span>';
            $return .= '<span class="box"></span> ' . ucwords($label) . ' </label>';
            $return .= '</div>';
            return $return;
        } 
    ])->label(ucwords($field['field_label'])); 
    ?>
</div>
 
