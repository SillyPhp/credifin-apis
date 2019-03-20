<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
$benefit = ArrayHelper::index($benefits, 'benefit_enc_id');
?>
    <div class="modal-header">
        <h4 class="modal-title"><?= Yii::t('frontend', 'Add New Employee Benefit'); ?></h4>
    </div>
<?php
$form = ActiveForm::begin([
    'id' => 'benefit-form',
    'fieldConfig' => [
        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
    ]
]);
?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= $form->field($addEmployeeBenefitForm, 'add_benefit')->textInput(['autocomplete' => 'off', 'id' => 'url']); ?>
        </div>
    </div>
    <div class="cat-sec">
        <div class="row no-gape pl-5 pr-5">

            <?=
            $form->field($addEmployeeBenefitForm, 'emp_benefit')->checkBoxList($benefit, [
                'item' => function ($index, $label, $name, $checked, $value) {
                if(empty($label['icon'])){$label['icon'] = 'plus-icon.svg';}
                    $return .= '<div class="col-lg-3 col-md-3 col-sm-6 p-category-main">';
                    $return .= '<div class="p-category-benefit">';
                    $return .= '<input type="checkbox" id="' . $label['benefit_enc_id'] . '" name="' . $name . '" value="' . $value . '" class="checkbox-input" ' . (($checked) ? 'checked' : '') . '>';
                    $return .= '<label for="' . $label['benefit_enc_id'] . '" class="checkbox-label-benefit">';
                    $return .= '<div class="checkbox-text-benefit">';
                    $return .= '<span class="checkbox-text--title">';
                    $return .= '<img src="' . Url::to("@commonAssets/employee_benefits/" . $label['icon']) . '">';
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
    <div class="modal-footer">
        <?= Html::submitbutton('Save', ['class' => 'btn btn-primary custom-buttons2']); ?>
        <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
    </div>
<?php ActiveForm::end(); ?>
<?php
$this->registerCss("    
.modal-header{
    color:blue;
}
");
$script = <<<JS
$(document).on('submit', '#benefit-form', function (event) {
    event.preventDefault();
    var data = $(this).serialize();
    $.ajax({
        url: '/companies/submit-benefit',
        type: 'post',
        data: data,
        beforeSend:function(){
              $('#page-loading').fadeIn(1000);
        },
        success: function (response) {
                $('#page-loading').fadeOut(1000);
            if (response.title == 'Success') {
                toastr.success(response.message, response.title);
                $("#benefit-form")[0].reset();
                $.pjax.reload({container: '#pjax_benefit', async: false});
                $('#modal').modal('hide');
            } else {
                toastr.error(response.message, response.title);
            }
        }
    });
});
JS;
$this->registerJs($script);
$this->registerCss('
/* Feature, categories css starts */
.checkbox-input {
  display: none;
}
.checkbox-label-benefit {
/*   display: inline-block; */
/*   position: relative; */
  vertical-align: top;
  width: 100%;
  cursor: pointer;
  font-weight: 400;
  margin-bottom:0px;
}
.checkbox-label-benefit:before {
  content: \'\';
  position: absolute;
  top: 80px;
  right: 16px;
  width: 40px;
  height: 40px;
  opacity: 0;
  background-color: #2196F3;
  background-image: url(\"data:image/svg+xml,%3Csvg width=\'32\' height=\'32\' viewBox=\'0 0 32 32\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z\' fill=\'%23fff\' fill-rule=\'nonzero\'/%3E%3C/svg%3E \");
  background-position: 80% 80%;
  background-repeat: no-repeat;
  background-size: 30px;
  border-radius: 50%;
  -webkit-transform: translate(0%, -50%);
  transform: translate(0%, -50%);
  transition: all 0.4s ease;
}
.checkbox-input:checked + .checkbox-label-benefit:before {
  top: 0;
  opacity: 1;
}
.checkbox-input:checked + .checkbox-label-benefit .checkbox-text-benefit span {
  -webkit-transform: translate(0, -8px);
  transform: translate(0, -8px);
}

.cat-sec {
    float: left;
    width: 100%;
}
.p-category-benefit {
    float: left;
    width: 100%;
    z-index: 1;
    position: relative;
}
.p-category-benefit, .p-category-benefit *{
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.p-category-benefit .p-category-view, .p-category-benefit .checkbox-text-benefit {
    float: left;
    width: 100%;
    text-align: center;
    padding-bottom: 30px;
    border-bottom: 1px solid #e8ecec;
    border-right: 1px solid #e8ecec;
}
.p-category-benefit .p-category-view img, .p-category-benefit .checkbox-text-benefit span i {
    color: #4aa1e3;
    font-size: 70px;
    margin-top: 30px;
    line-height: initial !important;
}
.p-category-benefit .p-category-view span, .p-category-benefit .checkbox-text-benefit span {
    float: left;
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    color: #202020;
    margin-top: 18px;
}
.p-category-benefit img, .checkbox-text--title img{
    width: 80px;
    height: 50px;
}
.p-category-benefit:hover {
    background: #ffffff;
    -webkit-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -moz-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -ms-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -o-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    width: 104%;
    margin-left: -2%;
    height: 102%;
    z-index: 10;
}
.p-category-benefit:hover a, .p-category-benefit:hover .checkbox-text-benefit {
    border-color: #ffffff;
}
.p-category-benefit:hover i, .p-category-benefit:hover .checkbox-label-benefit i{
    color: #f07d1d;
}
.row.no-gape > div, .row.no-gape .p-category-main {
    padding: 0;
}
.cat-sec .row > div:last-child .p-category-view, .cat-sec .row .p-category-main:nth-child(4n+0) .checkbox-text-benefit {
    border-right-color: #ffffff;
}
/* Feature, categories css ends */
');