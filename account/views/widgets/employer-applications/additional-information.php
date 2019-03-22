<div class="row">
    <div class="col-md-12">
        <div class="module2-heading">
            Additional Information
        </div>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'othrdetail')->textArea(['rows' => 6, 'cols' => 50, 'id' => 'othrdetail'])->label(false); ?>
    </div>
</div>
<?php
$script = <<< JS
let appEditor;
 ClassicEditor
    .create(document.querySelector('#othrdetail'), {
        removePlugins: [ 'Heading', 'Link' ],
        toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]
    }  )
    .then( editor => {
        appEditor = editor;
    } )
    .catch( error => {
        console.error( error );
    } );
JS;
$this->registerJs($script);
$this->registerJsFile('@root/assets/vendor/ckeditor/ckeditor.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>