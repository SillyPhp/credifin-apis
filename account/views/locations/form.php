<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;

$states = ArrayHelper::map($statesModel->find()->select(['state_enc_id', 'name'])->where(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09'])->orderBy(['name' => SORT_ASC])->asArray()->all(), 'state_enc_id', 'name');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?= Yii::t('account', 'Location Information'); ?></h4>
</div>

<?php
$form = ActiveForm::begin([
            'id' => 'location-form',
            'fieldConfig' => [
                'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
            ]
        ]);
?>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($locationFormModel, 'name')->label('<i class="fa fa-building"></i> Location Name')->textInput(['autocomplete' => 'off']); ?>
    </div>
    <div class="col-md-4">
        <?=
        $form->field($locationFormModel, 'phone')->widget(PhoneInput::className(), [
            'jsOptions' => [
                'allowExtensions' => false,
                'onlyCountries' => ['in'],
                'nationalMode' => false,
            ]
        ])->label(false);
        ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($locationFormModel, 'email')->label('<i class="fa fa-envelope"></i> Email')->textInput(['autocomplete' => 'off']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?=
        $form->field($locationFormModel, 'state')->label('<i class="fa fa-location-arrow"></i> State')->dropDownList(
                $states, [
            'prompt' => 'Select State',
            'id' => 'states_drp',
            'onchange' => '
                                    $("#cities_drp").empty().append($("<option>", { 
                                        value: "",
                                        text : "Select City" 
                                    }));
                                    $.post(
                                        "' . Url::toRoute("cities/get-cities-by-state") . '", 
                                        {id: $(this).val(),_csrf: $("input[name=_csrf]").val()}, 
                                        function(res){
                                            if(res.status === 200) {
                                                drp_down("cities_drp", res.cities);
                                            }
                                        }
                                    );',
        ])->label(false);
        ?>
    </div>
    <div class="col-md-4">
        <?=
        $form->field($locationFormModel, 'city')->label('<i class="fa fa-map-marker"></i> City')->dropDownList(
                [], [
            'prompt' => 'Select City',
            'id' => 'cities_drp',
        ])->label(false);
        ?>
    </div>
    <div class="col-md-4">
        <div class="md-checkbox-inline">
            <?=
            $form->field($locationFormModel, 'location_for')->checkBoxList([
                1 => 'Office',
                2 => 'Interviews',
                    ], [
                'item' => function($index, $label, $name, $checked, $value) {
                    $return = '<div class="md-checkbox">';
                    $return .= '<input type="checkbox" id="location_for' . $value . $index . '" name="' . $name . '" value="' . $value . '" class="md-check" ' . $checked . ' >';
                    $return .= '<label for="location_for' . $value . $index . '">';
                    $return .= '<span></span>';
                    $return .= '<span class="check"></span>';
                    $return .= '<span class="box"></span> ' . $label . ' </label>';
                    $return .= '</div>';
                    return $return;
                }
            ])->label(false);
            ?>
        </div>
    </div>
</div>  
<div class="row">
    <div class="col-md-10">
        <?= $form->field($locationFormModel, 'address')->label('<i class="fa fa-map-marker"></i> Address')->textInput(['autocomplete' => 'off', 'id' => 'address']); ?>
    </div>
    <div class="col-md-2">
        <div class="form-group form-md-line-input">
            <?= Html::button('Get Location', ['class' => 'btn btn-primary btn-md custom-buttons2 location_btn', 'id' => 'location-button']); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <div id="map-canvas"></div>
    </div>
</div>
<?=
$form->field($locationFormModel, 'latitude', [
    'template' => '{input}<div class ="pull-right lat_valid">{error}</div>',
])->hiddenInput(['id' => 'latitude'])->label(false);
?>
<?=
$form->field($locationFormModel, 'longitude', [
    'template' => '{input}',
])->hiddenInput(['id' => 'longitude'])->label(false);
?>

<div class="modal-footer">
    <?= Html::submitbutton('Save', ['class' => 'btn btn-primary custom-buttons2 sav_loc']); ?>
    <?= Html::button('Close', ['class' => 'btn default custom-buttons2', 'data-dismiss' => 'modal']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php
$script = <<<JS

    function drp_down(id, data) {
        var selectbox = $('#' + id + '');
        $.each(data, function () {
            selectbox.append($('<option>', {
                value: this.id,
                text: this.name
            }));
        });
    }

    var x;
    $(document).on('change', '#states_drp, #cities_drp', function () {
        $('#latitude').val('');
        $('#longitude').val('');
    });

    $(document).on('keydown keyup', '#location-button', function (e) {
        if (e.which == 9)
            $(this).trigger("click");
    });
    "use strict";
    var geocoder;
    var map;
   
    function initialize() {
        $("#map-canvas").css("height", "400px");
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(40.6700, -73.9400);
        var mapOptions = {
            zoom: 18,
            center: latlng
        }
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        
    }

    function codeAddress(address) {
        initialize();
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                $('#latitude').val(results[0].geometry.location.lat());
                $('#longitude').val(results[0].geometry.location.lng());
                var marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: results[0].geometry.location
                });
                google.maps.event.addListener(marker, 'dragend', function (evt) {
                    $('#latitude').val(evt.latLng.lat().toFixed(3));
                    $('#longitude').val(evt.latLng.lng().toFixed(3));
                });
                map.setCenter(marker.position);
                marker.setMap(map);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    };

    $(document).on('click', '.location_btn', function () {
        var address = $("#address").val();
        var city = $("#cities_drp option:selected").text();
        var state = $("#states_drp option:selected").text();
        var checkbox = $('[name="location_for[]"]:checked').length;
        if (address == "" || city == "Select City" || state == "Select City" || checkbox == 0) {
            $('#location-form').yiiActiveForm("validate", true);
            return false;
        } else {
            var resadd = address + ', ' + city + ', ' + state;
            codeAddress(resadd);
            $("#modal").animate({scrollTop: $('#modal').prop("scrollHeight")}, 1000);
            $('.lat_valid').css('display', 'none');
        }
    });
    
    var tab_count = "";
    tab_count = $('.tab-pane.active').attr('id');

    $(document).on('submit', '#location-form', function (event) {
        event.stopImmediatePropagation();
        event.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            beforeSend: function () {
                $("#wait").css("display", "block");
                $('.sav_loc').prop('disabled', 'disabled');
            },
            success: function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message, response.title);
                    $("#location-form")[0].reset();
                    $("#wait").css("display", "none");
                    if (tab_count == 'tab1') {
                        $.pjax.reload({container: '#pjax_locations1', async: false});
                        $.pjax.reload({container: '#pjax_locations2', async: false});
                    } else if (tab_count == 'tab4')
                    {
                        $.pjax.reload({container: '#pjax_locations2', async: false});
                    }
                    $('#modal').modal('toggle');
                } else {
                    $("#wait").css("display", "none");
                    toastr.error(response.message, response.title);
                }
            }
        });
    });
JS;
$this->registerJs($script);
