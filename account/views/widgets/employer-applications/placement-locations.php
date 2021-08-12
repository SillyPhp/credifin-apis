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
<div class="row">
    <div class="col-md-6">
        <div class="allPosSlider">
            <div class="form-group  allPos">
                <p>Enter No. of Positions For All Locations</p>
                <div class="input-group allSpiner">
                    <input type="text" class="form-control place_no all_place_no" value="1">
                    <div class="input-group-btn-vertical">
                        <button class="btn btn-default all_up_bt" type="button"><i class="fa fa-caret-up"></i></button>
                        <button class="btn btn-default all_down_bt" type="button"><i class="fa fa-caret-down"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 align-left">
        <button type="button" class="selectAllBtn">Select All</button>
    </div>
</div>
<div class="locationInputs">
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
            $return .= '<input type="checkbox" name="' . $name . '" id="' . $value . '" data-value="' . $label['city_name'] . '" class="checkbox-input locationInput" data-count = "" ' . (($checked) ? 'checked' : '') . '>';
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
</div>
<?php
$this->registerCSS('
.align-left{
    text-align: right;
}
.allPos{
    display: flex;
    margin-bottom: 5px !important;
}
.allPos p{
    margin-top: 10px !important;
    margin-bottom: 0px;
    margin-right: 20px;
}
.form-group.form-md-line-input {
    padding-top: 10px !important;
}
.allSpiner{
    width: 50px;
    display: inline-flex;
}
.selectAllBtn{
    border-radius: 6px !important;
    color: #00a0e3;
    background: #fff;
    border: 1px solid #00a0e3;
    padding: 6px 12px;
}
.selectAllBtn.active{
     color: #fff;
    background: #00a0e3;
}
.selectAllBtn:hover{
    box-shadow: 0 0 10px rgb(0 0 0 / 50%) !important;
    transition: .3s ease;
}
.mb0{
    margin-bottom: 0px !important;
}
.allPosSlider{
    display: none;
}
');
$script = <<< JS
var place_len = 0;

$(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('value'));   
});

$(document).on("click",'input[name="placement_locations[]"]' , function() {
        placement_location_positions($(this),1);
        if($('.selectAllBtn').hasClass('active')){
            $('.selectAllBtn').removeClass('active');
            $('.allPosSlider').hide();
            $('.all_place_no').val(1)
        }
});
$(document).on('click', '.selectAllBtn', function (){
    let locationsDiv = document.querySelector('.locationInputs');
    let checked = locationsDiv.querySelectorAll('.checkbox-input:checked'); 
    let unChecked = locationsDiv.querySelectorAll('.checkbox-input:not(:checked)');
    if(checked.length == 0 || unChecked.length > 0){
        for(let i=0; i<unChecked.length; i++){
            $(unChecked[i]).trigger('click');
            $('.selectAllBtn').addClass('active');
            $('.allPosSlider').show();
        }
    }else {
        for(let i=0; i<checked.length; i++){
           $(checked[i]).trigger('click');
            $('.selectAllBtn').removeClass('active');
            $('.allPosSlider').hide();
            $('.all_place_no').val(1)
        }
    }
})
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
function showPositionBox(thisObj){
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

$(document).on('click', '.all_up_bt', function (e){
   e.preventDefault()
   var upField = $(this).parent().prev(); 
   var up = $(this).parent().prev().val(); 
   if(up>=0){
        upField.val( parseInt(up,10)+1 );
        $('.place_no').val(upField.val());
   }else{
        return false;
   } 
});
$(document).on('click', '.all_down_bt', function (e){
    e.preventDefault()
    var downField = $(this).parent().prev();
    var down = $(this).parent().prev().val(); 
    if(down>=2)  {
        downField.val( parseInt(down,10)-1 );
        $('.place_no').val(downField.val());
    }else {
        return false;
    }  
});
$(document).on('click','.down_bt',function(e){
   e.preventDefault();
   var down = $(this).parent().prev().val(); 
   if(down>=2){  
        $(this).parent().prev().val( parseInt(down,10)-1 );
    }else {
        return false;
   }  
}); 
$(document).on('click','.up_bt',function(e)
       {
       e.preventDefault();  
       var up = $(this).parent().prev().val();
       if(up>=0) {
            $(this).parent().prev().val( parseInt(up,10)+1 );
       }else{
            return false;
       } 
   });
$('[data-toggle="tooltip"]').tooltip();
JS;
$this->registerJs($script);
?>