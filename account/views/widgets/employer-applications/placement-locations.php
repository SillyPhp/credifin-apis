<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<div class="row">
    <div class="col-md-4">
        <div class="module2-heading">Select Placement Locations</div>

    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'placement_loc', ['template' => '{input}'])->hiddenInput(['id' => 'placement_array'])->label(false); ?>
        <span id="place_error"></span>
    </div>

    <div class="col-md-4">
        <div class="button_location">
            <?= Html::button('Add New Location', ['value' => URL::to('/account/locations/create'), 'data-key' => '3', 'id' => 'btn_placement_locations', 'class' => 'btn modal-load-class custom-buttons2 btn-primary custom_color-set2']); ?>
        </div>
    </div>
</div>
<?php
Pjax::begin(['id' => 'pjax_locations1']);
if (!empty($loc_list)) {
    ?>
    <?=
    $form->field($model, 'placement_locations')->checkBoxList($loc_list, [
        'item' => function ($index, $label, $name, $checked, $value) {

            if ($index % 3 == 0) {
                $return .= '<div class="row">';
            }
            $return .= '<div class="col-md-4">';
            $return .= '<input type="checkbox" name="' . $name . '" id="' . $value . '" data-value="' . $label['city_name'] . '" class="checkbox-input" data-count = "" ' . (($checked) ? 'checked' : '') . '>';
            $return .= '<label for="' . $value . '" class="checkbox-label">';
            $return .= '<div class="checkbox-text">';
            $return .= '<p class="loc_name_tag">' . $label['location_name'] . '</p>';
            $return .= '<span class="address_tag">' . $label['address'] . '</span> <br>';
            $return .= '<span class="state_city_tag">' . $label['city_name'] . ", " . $label['state_name'] . '</span>';
            $return .= '<div class="form-group">';
            $return .= '<div class="input-group spinner">';
            $return .= '<input type="text" class="form-control place_no" value="1" >';
            $return .= '<div class="input-group-btn-vertical">';
            $return .= '<button class="btn btn-default up_bt" type="button"><i class="fa fa-caret-up"></i></button>';
            $return .= '<button class="btn btn-default down_bt" type="button"><i class="fa fa-caret-down"></i></button>';
            $return .= '</div>';
            $return .= '</div>';
            $return .= '</div>';
            $return .= '<div class="tooltips">';
            $return .= 'Enter No. of Positions.';
            $return .= '</div>';
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
    <div class="empty-section-text">No Placement Location has been found</div>
<?php }
Pjax::end(); ?>
<input type="text" name="placement_calc" id="placement_calc" readonly>