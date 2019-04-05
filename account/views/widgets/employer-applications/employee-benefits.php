<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\URL;
?>
<div class="row">
    <div id="select_benefit_err"></div>
    <div class="col-lg-6">
        <div class="module2-heading">
            Employee Benefits
        </div>
        (Selected Benefits Will Be Applicable To This Job Only)
    </div>
    <div class="col-lg-6">
        <div class="md-radio-inline text-right clearfix">
            <?=
            $form->field($model, 'benefit_selection')->inline()->radioList([
                1 => 'Add Jobs Benefits',
                0 => 'Skip Benefits',
            ], [
                'item' => function ($index, $label, $name, $checked, $value) {
                    $return = '<div class="md-radio">';
                    $return .= '<input type="radio" id="ben' . $index . '" name="' . $name . '" value="' . $value . '" class="md-radiobtn" ' . (($checked) ? 'checked' : '') . '>';
                    $return .= '<label for="ben' . $index . '">';
                    $return .= '<span></span>';
                    $return .= '<span class="check"></span>';
                    $return .= '<span class="box"></span> ' . $label . ' </label>';
                    $return .= '</div>';
                    return $return;
                }
            ])->label(false);
            ?>
        </div>
        <div class="button_location pull-right clearfix">
            <?= Html::button('Add New', ['value' => URL::to('/account/employee-benefits/create-benefit'), 'id' => 'benefitPopup', 'class' => 'btn btn-primary custom-buttons2 custom_color-set2 modal-load-benefit']); ?>
        </div>
    </div>
</div>
<div class="divider"></div>
<div id="benefits_hide">
    <?php
    Pjax::begin(['id' => 'pjax_benefits']);
    ?>
    <div id="b_error"></div>
    <?php
    if (!empty($benefits)) {
        ?>
        <div class="cat-sec">
            <div class="row no-gape">
                <?=
                $form->field($model, 'emp_benefit')->checkBoxList($benefits, [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $return .= '<div class="col-lg-3 col-md-3 col-sm-6 p-category-main">';
                        $return .= '<div class="p-category">';
                        $return .= '<input type="checkbox" id="benefit' . $value . '" name="' . $name . '" value="' . $value . '" class="checkbox-input" ' . (($checked) ? 'checked' : '') . '>';
                        $return .= '<label for="benefit' . $value . '" class="checkbox-label-v2">';
                        $return .= '<div class="checkbox-text">';
                        $return .= '<span class="checkbox-text--title">';
                        $return .= '<img src="' . $label["icon"] . '">';
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

        <div class="empty-section-text"> No Benefits Yet Added to display</div>

    <?php } ?>
    <?php Pjax::end() ?>
    <input type="text" name="benefit_calc" id="benefit_calc" readonly>
</div>
<div class="modal fade bs-modal-lg in" id="modal_benefit" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif'); ?>"
                     alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                <span><?= Yii::t('account', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
var benefit_len = 0;
$(document).on('click', '.modal-load-benefit', function() {
    $('#modal_benefit').modal('show').find('.modal-body').load($(this).attr('value'));
});
$('input[name= "benefit_selection"]').on('change',function(){
        var option = $(this).val();
        hide_show_benefits(option);
});
function hide_show_benefits(option)
{
    if(option==1)
            {
             $('#benefits_hide').css('display','block');   
             $('#benefitPopup').css('display','block');   
            }
        else {
            $('#benefits_hide').css('display','none');   
            $('#benefitPopup').css('display','none');   
        }
}
$(document).on("click",'input[name="emp_benefit[]"]', function() {
    benefits_selection($(this)); 
});

function benefits_selection(thisObj)
{
    if (thisObj.prop("checked")==true) {
        benefit_len =  $('[name="emp_benefit[]"]:checked').length;
        benefit_checker(benefit_len);
    } 

    else {
        benefit_len =  $('[name="emp_benefit[]"]:checked').length;
        benefit_checker(benefit_len); 
        
   }  
}

if (doc_type=='Clone_Jobs'||doc_type=='Clone_Internships'||doc_type=='Edit_Jobs'||doc_type=='Edit_Internships') 
    {
        hide_show_benefits('$model->benefit_selection');
        $.each($('[name="emp_benefit[]"]'),function(e) {
          benefits_selection($(this));
        })
    }
function benefit_checker(benefit_len)
        {
          if(benefit_len == 0)
          {
              $('#benefit_calc').val('');
           }
          else 
          {
              $('#benefit_calc').val('1');
           }
        }
JS;
$this->registerJs($script);
?>