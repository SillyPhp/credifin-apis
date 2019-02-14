<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
$benefit = ArrayHelper::index($benefits, 'benefit_enc_id');
?>
    <div class="modal-header modal_title">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?= Yii::t('account', 'Employee Benefits'); ?></h4>
    </div>
<?php
$form = ActiveForm::begin([
    'id' => 'benefits-form',
    'options' => ['data-pjax' => true],
    'fieldConfig' => [
        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
    ]
]);
?>
    <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <input type="text" id="text" placeholder="Search Here.. Or Add New Benefit" class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <button type="button" id="add_new_btn" class="btn btn-default">Add To The List</button>
            </div>
        </div>
    </div>
  <?php
 if (!empty($benefit)){ ?>
    <div class="cat-sec fix_height">
        <div class="row no-gape">
            <?php
            $BenefitsModel->predefind_benefit = ArrayHelper::getColumn($org_benefits, 'benefit_enc_id');
            ?>
            <?=
            $form->field($BenefitsModel, 'predefind_benefit')->checkBoxList($benefit, [
                'item' => function ($index, $label, $name, $checked, $value) {
                    if(empty($label['icon'])){$label['icon'] = 'plus-icon.svg';}
                    $return .= '<div class="col-lg-3 col-md-3 col-sm-6 p-category-main">';
                    $return .= '<div class="p-category search_benefits">';
                    $return .= '<input type="checkbox" id="' . $value . '" name="' . $name . '" value="' . $value . '" class="checkbox-input" ' . (($checked) ? 'checked' : '') . '>';
                    $return .= '<label for="' . $value . '" class="checkbox-label-v2">';
                    $return .= '<div class="checkbox-text">';
                    $return .= '<span class="checkbox-text--title">';
                    $return .= '<img src="' . Url::to('/assets/icons/').$label["icon_location"].'/'.  $label["icon"] . '">';
                    $return .= '</span><br/>';
                    $return .= '<span class="checkbox-text--description2">';
                    $return .= $label['benefit'];
                    $return .= '</span>';
                    $return .= '</div>';
                    $return .= '</label>';
                    $return .= '</div>';
                    $return .= '</div>';
                    return $return;
                }
            ])->label(false);
            ?>
        </div>
    </div>
  <?php } else { ?>
     <h3>No Benefits To Display</h3>
 <?php }
 ?>
    <div class="modal-footer">
        <?= Html::submitbutton('Save', ['class' => 'btn btn-primary custom-buttons2 sav_benft']); ?>
        <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
    </div>
<?php ActiveForm::end(); ?>
<?php
$script = <<< JS
$("#text").keyup(function () {
    var re = new RegExp($(this).val(), "i")
    $('.search_benefits').each(function () {
        var text = $(this).text(),
            matches = !! text.match(re);
        $(this).toggle(matches)
    });
});
    $(document).on('submit', '#benefits-form', function (event) {
        event.stopImmediatePropagation();
        event.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            beforeSend: function (){
                $('.sav_benft').prop('disabled', 'disabled');
            },
            success: function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message, response.title);
                    $("#benefits-form")[0].reset();
                    $.pjax.reload({container: '#pjax_benefits', async: false});
                } else {
                    toastr.error(response.message, response.title);
                }
                $('#modal_benefit').modal('toggle');
            }
        });
    });
    
  $(document).on('click','#add_new_btn',function(event) {
      event.stopImmediatePropagation();
      event.preventDefault();
      var str = $.trim($('#text').val());
     if (str != '')
         {
         $.ajax({
            url: '/account/employee-benefits/create-benefit',
            type: 'post',
            data: {str:str},
             beforeSend: function (){
                $('#add_new_btn').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>Loading');
            },
            success: function (response)
            {
                $('#add_new_btn').html('Add To The List');
                 if (response.status == 'success') {
                    toastr.success(response.message, response.title);
                    $.pjax.reload({container: '#pjax_benefits', async: false});
                } else {
                    toastr.error(response.message, response.title);
                }
                $('#modal_benefit').modal('toggle'); 
            }
            })
         }
  }) 
JS;
$this->registerJs($script);
$this->registerCss("
.modal_title
{
border-bottom:0 !important;
}
.fix_height
{
max-height:350px;
overflow-y:scroll;
overflow-x: hidden;
}
.checkbox-label-v2 {
    width: 100%;
    cursor: pointer;
    font-weight: 400;
    margin-bottom: 0px;
}
.p-category img, .checkbox-text--title img{
    width: 80px;
    height: 50px;
}
.checkbox-label-v2:before {
  content: '';
  position: absolute;
  top: 80px;
  right: 16px;
  width: 40px;
  height: 40px;
  opacity: 0;
  background-color: #00A0E3;
  background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
  background-position: 80% 80%;
  background-repeat: no-repeat;
  background-size: 30px;
  border-radius: 50%;
  -webkit-transform: translate(0%, -50%);
  transform: translate(0%, -50%);
  transition: all 0.4s ease;
}
.checkbox-input:checked + .checkbox-label-v2:before {
  top: 0;
  opacity: 1;
}
.checkbox-input:checked + .checkbox-label-v2 .checkbox-text span {
  -webkit-transform: translate(0, -8px);
  transform: translate(0, -8px);
}
.p-category:hover .checkbox-label-v2 i{
    color: #f07d1d;
}
");
