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
    <h4 class="modal-title"><?= Yii::t('frontend', 'Location Information'); ?></h4>
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
        <?= $form->field($organizationLocationFormModel, 'name')->label('<i class="fa fa-building"></i> Location Name')->textInput(['autocomplete' => 'off']); ?>
    </div>
    <div class="col-md-4">
        <?=
        $form->field($organizationLocationFormModel, 'phone')->widget(PhoneInput::className(), [
            'jsOptions' => [
                'allowExtensions' => false,
                'onlyCountries' => ['in'],
                'nationalMode' => false,
            ]
        ])->label(false);
        ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($organizationLocationFormModel, 'email')->label('<i class="fa fa-envelope"></i> Email')->textInput(['autocomplete' => 'off']); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?=
        $form->field($organizationLocationFormModel, 'state')->label('<i class="fa fa-location-arrow"></i> State')->dropDownList(
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
    <div class="col-md-6">
        <?=
        $form->field($organizationLocationFormModel, 'city')->label('<i class="fa fa-map-marker"></i> City')->dropDownList(
                [], [
            'prompt' => 'Select City',
            'id' => 'cities_drp',
        ])->label(false);
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        <?= $form->field($organizationLocationFormModel, 'address')->label('<i class="fa fa-map-marker"></i> Address')->textInput(['autocomplete' => 'off', 'id' => 'address']); ?>
    </div>
    <div class="col-md-2">
        <div class="form-group form-md-line-input">
            <?= Html::button('Get Location', ['class' => 'btn btn-primary btn-md location_btn', 'id' => 'location-button']); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div id="map-canvas" style="height: 400px;"></div>
        <div id="wait"><img src='http://www.downgraf.com/wp-content/uploads/2014/09/01-progress.gif?e44397' width="64" height="64" /><br>Loading..</div>
    </div>
</div>
<?=
$form->field($organizationLocationFormModel, 'latitude', [
    'template' => '{input}',
])->hiddenInput(['id' => 'latitude'])->label(false);
?>
<?=
$form->field($organizationLocationFormModel, 'longitude', [
    'template' => '{input}',
])->hiddenInput(['id' => 'longitude'])->label(false);
?>

<div class="modal-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']); ?>
    <?= Html::button('Close', ['class' => 'btn default', 'data-dismiss' => 'modal']); ?>
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerCss("
  #wait
  {
    display:none;
    width:100px;
    height:100px;
    
    position:absolute;
    top:50%;
    left:50%;
    padding:2px;
  }
         ");
?>

<?php
$script = <<<JS
function drp_down(id, data) {
    var selectbox = $('#' + id + '');
    $.each(data, function () {
        selectbox.append($('<option>', { 
            value: this.id,
            text : this.name 
        }));
    });
} 
        
"use strict";
var geocoder;
var map;
function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(40.6700, -73.9400);
    var mapOptions = {
        zoom: 14,
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
}

google.maps.event.addDomListener(window, 'load', initialize);

$(document).on('click','.location_btn',function() {
    var address = $("#address").val();
    var city = $("#cities_drp option:selected").text();
    var state = $("#states_drp option:selected").text();
    var resadd = address + ', ' + city + ', ' + state;
    codeAddress(resadd);
});

$(document).on('submit', 'form', function (event) {
    event.preventDefault();
    var url = $(this).attr('action');
    var data = $(this).serialize();
    var method = $(this).attr('method');
    $.ajax({
        url: url,
        type: method,
        data: data,
        success: function (response) {
            if (response.status == 'success') {
                toastr.success(response.message, response.title);
                $.pjax.reload({container: '#pjax_locations', async: false});
                $('#location-modal').modal('toggle');
            } else {
                toastr.error(response.message, response.title);
            }
        }
    });
});

JS;
$this->registerJs($script);
