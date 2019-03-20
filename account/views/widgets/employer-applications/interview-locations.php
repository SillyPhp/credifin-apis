<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>

<div class="row">
    <div class="col-md-4 m-padd">
        <h3 class="module2-heading">Select Interview Locations</h3>
    </div>
    <div class="col-md-4">
        <span id="interview_error"></span>
    </div>
    <div class="col-md-4">
        <div class="btn-padd-top pull-right">
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
    checked = $(this);
    if (this.checked == true) {
        interview_len =  $('[name="interviewcity[]"]:checked').length;
        interview_checker(interview_len);
    } 
        
    else {
        interview_len =  $('[name="interviewcity[]"]:checked').length;
        interview_checker(interview_len); 
        
   }   
});
JS;
$this->registerJs($script);
?>