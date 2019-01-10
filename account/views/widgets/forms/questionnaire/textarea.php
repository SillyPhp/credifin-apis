
<?= $form->field($model, 'field[' . $field['field_enc_id'] . ']')->textarea(['required' => ($field['is_required']) ? true : false,'data-type'=>'textarea','data-id'=>$field['field_enc_id']])
    ->label(ucwords($field['field_label'])); ?>
