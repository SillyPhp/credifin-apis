<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-md-12">
        <?php
        $form  = ActiveForm::begin([
            'id' => 'newsletterForm',
            'action' => '/site/add-new-subscriber',
            'fieldConfig' => [
                'template' => '<div class="form-group ">{label}{input}{error}</div>',
            ]
        ]);
        ?>
        <div class="sub-newletter">Sign up to our newsletter</div>
        <?=
        $form->field($subscribersForm,'first_name')->textInput([
            'autocomplete' => 'off',
            'placeholder' => $subscribersForm->getAttributeLabel('first_name')
        ])
        ?>
        <?=
        $form->field($subscribersForm,'last_name')->textInput([
            'autocomplete' => 'off',
            'placeholder' => $subscribersForm->getAttributeLabel('last_name')
        ])
        ?>
        <?=
        $form->field($subscribersForm,'email')->textInput([
            'autocomplete' => 'off',
            'placeholder' => $subscribersForm->getAttributeLabel('email')
        ])
        ?>
        <?=
        Html::submitButton('Submit', ['class' => 'btn btn-primary sendFeedback']);
        ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$this->registerCss('
.sub-newletter{
    font-size:20px;
    text-transform:capitalize;
    color:#000;
    padding-bottom:10px;
    font-weight:bold;
}
.sendFeedback{
    margin-top:5px;
    width:100%;
    text-transform: uppercase;
}
#newsletterForm label{
    margin-bottom:0px !important;
    font-size:14px;
    color:#00a0e3 !important;
    
}
.form-control{
    height: 40px !important;
    font-size: 14px !important;
    padding: 6px 10px !important;
    border: none !important;
    box-shadow:0 0 5px rgba(0,0,0,.1) !important;
}
');
$script = <<< JS
$(document).on('submit', '#newsletterForm', function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var me = $('.sendFeedback');
    if ( me.data('requestRunning') ) {
        return false;
    }
    me.data('requestRunning', true);
    var url = $(this).attr('action');
    var data = $('#newsletterForm').serialize();
    $.ajax({
        url: url,
        type: 'post',
        data: data,
        beforeSend: function (){
            $('.sendFeedback').html('<i class="fas fa-circle-notch fa-spin"></i>');
            $('.sendFeedback').prop('disabled', true);
        },
        success: function (response) {
            if (response.status == 200) {
                toastr.success(response.message, response.title);
                $("#newsletterForm")[0].reset();
            } else {
                toastr.error(response.message, response.title);
            }
            $('.sendFeedback').prop('disabled', false);
            $('.sendFeedback').html('Submit');
        },
        complete: function() {
        me.data('requestRunning', false);
      }
    });
});
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
