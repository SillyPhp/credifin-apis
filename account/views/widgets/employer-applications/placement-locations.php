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
if (!empty($placement_locations)) {
    ?>
    <?=
    $form->field($model, 'placement_locations')->checkBoxList($placement_locations, [
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
            $return .= '<input type="text" class="form-control place_no" value="1">';
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
<?php
$script = <<< JS
var place_len = 0;

$(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('value'));   
});

$(document).on("click",'input[name="placement_locations[]"]' , function() {
       placement_location_positions($(this),1);
});

function placement_location_positions(thisObj,positions) {
  if (thisObj.prop("checked")==true) {
        thisObj.next('label').find('input').val(positions);
        place_len =  $('[name="placement_locations[]"]:checked').length;
        place_checker(place_len);
        showPositionBox(thisObj);
    } 
    else {
        place_len =  $('[name="placement_locations[]"]:checked').length;
        place_checker(place_len);
        hidePositionBox(thisObj);
   } 
}
if (doc_type=='Clone_Jobs'||doc_type=='Clone_Internships'||doc_type=='Edit_Jobs'||doc_type=='Edit_Internships') 
    {
        var positions = $model->positions;
        $.each($('[name="placement_locations[]"]:checked'),function(i,v) {
          placement_location_positions($(this),positions[i]);
        });
    }
function showPositionBox(thisObj)
{
    thisObj.next('label').find('.spinner').css('display','inline-flex');
    thisObj.next('label').find(".tooltips").fadeIn(1000);
    thisObj.next('label').find(".tooltips").fadeOut(2000);
}

function hidePositionBox(thisObj)
{
    thisObj.next('label').find('.spinner').css('display','none');
    thisObj.next('label').find(".tooltips").css('display','none'); 
}
function place_checker(place_len)
        {
          if(place_len == 0)
          {
              $('#placement_calc').val('');
           }
          else 
          {
              $('#placement_calc').val('1');
           }
        } 
function placement_arr()
        {
            var place_arr =[];
            $.each($("input[name='placement_locations[]']:checked"),
            function(index,value){
            var obj_place = {};
            obj_place["id"] = $(this).attr('id');
            obj_place["value"] = $(this).next('label').find('.place_no').val();
            obj_place["name"] = $(this).attr('data-value');
            place_arr.push(obj_place); 
            });
            $('#placement_array').val(JSON.stringify(place_arr));
       }    
$(document).on("keypress",'.place_no', function (evt) {
    if (evt.which < 48 || evt.which > 57)
    {
        evt.preventDefault();
    }
   }); 
$(document).on('click','.down_bt',function(e)
       {
       e.preventDefault();
       var down = $(this).parent().prev().val(); 
       if(down>=2)  
       $(this).parent().prev().val( parseInt(down,10)-1 );
       else
        {
        return false;
         }  
   }); 
$(document).on('click','.up_bt',function(e)
       {
       e.preventDefault();  
       var up = $(this).parent().prev().val();
       if(up>=0) 
       $(this).parent().prev().val( parseInt(up,10)+1 );
       else{
        return false;
           } 
   });
$('[data-toggle="tooltip"]').tooltip();
JS;
$this->registerJs($script);
?>