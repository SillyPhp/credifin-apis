<?= $form->field($model, 'field[' . $field['field_enc_id'] . ']')->textInput(['required' => ($field['is_required']) ? true : false,'data-type'=>'text','data-id'=>$field['field_enc_id']])->label(ucwords($field['field_label'])); ?>

