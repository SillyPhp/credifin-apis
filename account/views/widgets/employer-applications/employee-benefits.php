<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\URL;

//if($type){
//    $type =  substr_replace($type ,"",-1);
//}
?>
<?php if ($type == 'Jobs' || $type == 'Clone_Jobs' || $type == 'Edit_Jobs'):
    $label = "Job";
elseif ($type == 'Internships' || $type == 'Clone_Internships' || $type == 'Edit_Internships'):
    $label = 'Internship';
endif; ?>

    <div class="row">
        <div id="select_benefit_err"></div>
        <div class="col-lg-6">
            <div class="module2-heading">
                Employee Benefits
            </div>
            (Selected Benefits Will Be Applicable To This <?= $label ?> Only)
        </div>
        <div class="col-lg-6">
            <div class="md-radio-inline text-right clearfix">
                <?=
                $form->field($model, 'benefit_selection')->inline()->radioList([
                    1 => 'Add ' . $label . ' Benefits',
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
                    <div class="form-group field-emp_benefit required has-success" aria-required="true">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <input type="hidden" name="emp_benefit" value="">
                            <div id="emp_benefit" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                    </div>
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
        });
        employee_benefits('$model->title_id');
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
function employee_benefits(data)
{
    $.ajax({
      url:"/account/categories-list/employee-benefits",
      data:{data:data},
      method:"post",
      success:function(response)
     {
         var obj = JSON.parse(response);
         var html = [];
         $.each(obj,function()
         { 
             var checked = '';
             if (doc_type=='Edit_Jobs'||doc_type=='Edit_Internships')
                 {
                     checked = (this.is_checked == 1 ? 'checked' : '');
                 } else {
                        checked = 'checked';
                 }
             html.push("<div class='col-lg-3 col-md-3 col-sm-6 p-category-main'><div class='pp-cate'><input type='checkbox' id='benefit"+this.benefit+"' name='emp_benefit[]' value='"+this.benefit_enc_id+"' class='checkbox-input' "+checked+"><label for='benefit"+this.benefit+"' class='checkbox-label-v2'><div class='checkbox-text'><img src='"+this.icon+"'><div class='checkbox-text--description2'>"+this.benefit+"</div></div></label></div></div>");
         });
     $("#emp_benefit").html(html); 
     }
     });
}  
JS;
$this->registerJs($script);
$this->registerCss('
.pp-cate{
    width: 98%;
    margin: auto;
}
.checkbox-label-v2 {
	width: 100%;
	cursor: pointer;
	/* font-weight: 400; */
	/* margin-bottom: 0px; */
	display: flex;
	padding: 20px;
	border: 1px solid #eee;
	justify-content: center;
	align-items: center;
	text-align: center;
	margin-bottom: 30px !important;
}
.pp-cate:hover {
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
	z-index: 10;
}
.p-category .checkbox-text {
    width: 100%;
}
.checkbox-text img {
    width: 80px;
    height: 80px;
    object-fit: contain;
}
.checkbox-text--description2 {
	min-height: 41px;
	margin-top: 5px;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
}
');

?>