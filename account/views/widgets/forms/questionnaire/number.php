
<?= $form->field($model, 'field[' . $field['field_enc_id'] . ']')->textInput(['type'=>'number','min'=>0,'required' => ($field['is_required']) ? true : false,'data-type'=>'number','data-id'=>$field['field_enc_id']])->label(ucwords($field['field_label'])); ?>


