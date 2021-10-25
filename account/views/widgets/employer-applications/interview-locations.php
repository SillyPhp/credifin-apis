<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>

<div class="row">
    <div class="col-md-4 m-padd">
        <h3 class="module2-heading">Select Interview Locations</h3>
    </div>
    <div class="col-md-3">
        <span id="interview_error"></span>
    </div>
    <div class="col-md-5">
        <div class="btn-padd-top pull-right display-flexbox">
            <div class="md-checkbox">
                <input type="checkbox" id="sameAsPlacementLocation"/>
                <label for="sameAsPlacementLocation">
                    <span class="inc"></span>
                    <span class="check"></span>
                    <span class="box"></span> Same as Placement Locations
                </label>
            </div>
            <?= Html::button('Add New Location', ['value' => URL::to('/account/locations/create'), 'data-key' => '1', 'class' => 'btn modal-load-class btn-primary custom-buttons2']); ?>
        </div>
    </div>
</div>
<div class="row">
    <?php
    Pjax::begin(['id' => 'pjax_locations2']);
    if (!empty($interview_locations)) {
        ?>
        <?=
        $form->field($model, 'interviewcity')->checkBoxList($interview_locations, [
            'item' => function ($index, $label, $name, $checked, $value) {
                $i++;
                if ($index % 3 == 0) {
                    $return .= '<div class="row">';
                }
                $return .= '<div class="col-md-4">';
                $return .= '<input type="checkbox" value="' . $value . '" name="' . $name . '" id="int' . $value . '" data-value="' . $label['city_name'] . '" class="checkbox-input" data-count = "" ' . (($checked) ? 'checked' : '') . '>';
                $return .= '<label for="int' . $value . '" class="checkbox-label">';
                $return .= '<div class="checkbox-text">';
                $return .= '<p class="loc_name_tag">' . $label['location_name'] . '</p>';
                $return .= '<span class="address_tag">' . $label['address'] . '</span> <br>';
                $return .= '<span class="state_city_tag">' . $label['city_name'] . ", " . $label['state_name'] . '</span>';
                $return .= '</div>';
                $return .= '</label>';
                $return .= '</div>';

                if ($index % 3 == 2 || isset($label['total'])) {
                    $return .= '</div>';
                }
                return $return;
            }
        ])->label(false);
        ?>
    <?php } else { ?>
        <div class="row">
            <div class="col-md-12">
                <div class="empty-section-text">No Location has been found</div>
            </div>
        </div>
    <?php }
    Pjax::end();
    ?>
    <input type="text" name="interview_calc" id="interview_calc" readonly>
</div>
<?php
$this->registerCss('
.display-flexbox{
    display: flex;
    align-items: center;
}
.display-flexbox > div{
    margin-right: 10px;
    margin-bottom: 0;
}
');
$script = <<< JS
var interview_len = 0; 
$(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('value'));   
});
function interview_checker(interview_len)
        {
          if(interview_len == 0)
          {
              $('#interview_calc').val('');
           }
          else 
          {
              $('#interview_calc').val('1');
           }
        }
 $(document).on("click",'input[name="interviewcity[]"]', function() {
    interview_location_len_validation($(this));
});
if (doc_type=='Clone_Jobs'||doc_type=='Clone_Internships'||doc_type=='Edit_Jobs'||doc_type=='Edit_Internships') 
    {
        $.each($('[name="interviewcity[]"]'),function(e) {
          interview_location_len_validation($(this));
        })
    }
function interview_location_len_validation(thisObj) {
  if (thisObj.prop("checked")==true) {
        interview_len =  $('[name="interviewcity[]"]:checked').length;
        interview_checker(interview_len);
    } 
        
    else {
        interview_len =  $('[name="interviewcity[]"]:checked').length;
        interview_checker(interview_len); 
   }   
}
$(document).on('change','#sameAsPlacementLocation',function() {
    $('input[name="interviewcity[]"]').prop('checked',false);
    if($(this).is(':checked')){
        $('input[name="placement_locations[]"]:checked').each(function(){
            $('#int'+$(this).attr('id')).prop('checked',true);
        });
    }
});
$(document).on('change','input[name="interviewcity[]"], input[name="placement_locations[]"]',function() {
    $('#sameAsPlacementLocation').prop('checked',false);
});
JS;
$this->registerJs($script);
?>