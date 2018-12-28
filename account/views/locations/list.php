<?php
$this->title = Yii::t('account', 'Locations');

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use borales\extensions\phoneInput\PhoneInput;

$states = ArrayHelper::map($statesModel->find()->select(['state_enc_id', 'name'])->where(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09'])->orderBy(['name' => SORT_ASC])->asArray()->all(), 'state_enc_id', 'name');
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light portlet-fit portlet-datatable">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-users font-dark"></i>
                    <span class="caption-globe font-dark sbold uppercase"><?= $this->title; ?></span>
                </div>
                <div class="text-right">
                    <?= Html::button('Add Location', ['data-toggle' => 'modal', 'data-target' => '#location-modal', 'class' => 'btn btn-primary btn-md', 'id' => 'modalButton']); ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <?php
                    Pjax::begin([
                        'id' => 'locations-container',
                        'enablePushState' => false,
                        'clientOptions' => [
                            'type' => 'POST',
                        ],
                        'timeout' => 10000,
                    ]);
                    echo GridView::widget([
                        'tableOptions' => [
                            'class' => 'table table-striped table-bordered table-hover table-checkable',
                            'id' => 'locations',
                        ],
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'attribute' => 'location_name',
                            ],
                            [
                                'attribute' => 'address',
                            ],
                            [
                                'attribute' => 'city_enc_id',
                                'label' => 'City',
                                'value' => 'cityEnc.name',
                            ],
                            [
                                'attribute' => 'postal_code',
                            ],
                        ]
                    ]);
                    Pjax::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="location-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'location-form',
                    'enableAjaxValidation' => true,
                    'validationUrl' => ['/' . Yii::$app->controller->id . '/' . 'validate'],
                    'fieldConfig' => [
                        'template' => '<div class="form-group form-md-line-input form-md-floating-label">{input}{label}{error}{hint}</div>',
                    ]
        ]);
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Location Information</h4>
            </div>
            <div class="modal-body">
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
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <?=
                        $form->field($locationFormModel, 'city')->label('<i class="fa fa-map-marker"></i> City')->dropDownList(
                                [], [
                            'prompt' => 'Select City',
                            'id' => 'cities_drp',
                        ])->label(false);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <?= $form->field($locationFormModel, 'address')->label('<i class="fa fa-map-marker"></i> Address')->textInput(['autocomplete' => 'off', 'id' => 'address']); ?>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group form-md-line-input form-md-floating-label">
                            <?= Html::button('Get Location', ['class' => 'btn btn-primary btn-md', 'id' => 'location-button']); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="map-canvas" style="height: 400px;"></div>
                    </div>
                </div>
                <?=
                $form->field($locationFormModel, 'latitude', [
                    'template' => '{input}',
                ])->hiddenInput(['id' => 'latitude'])->label(false);
                ?>
                <?=
                $form->field($locationFormModel, 'longitude', [
                    'template' => '{input}',
                ])->hiddenInput(['id' => 'longitude'])->label(false);
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-md']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$script = <<<JS
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

$(document).on('click', '#location-button', function() {
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
        success: function (data) {
            if (data == 1) {
                toastr.success('Success', 'Location successfully added.');
                $.pjax.reload({container:'#locations-container'});
                $('#location-modal').modal('toggle');
            } else {
                toastr.error('Opps!!', 'An error has occurred. Please try again.');
            }
        }
    });
});
JS;
$this->registerJs($script);

$this->registerJs("function drp_down(id, data) {
    var selectbox = $('#' + id + '');
    $.each(data, function () {
        selectbox.append($('<option>', { 
            value: this.id,
            text : this.name 
        }));
    });
}", View::POS_HEAD);

$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/additional-methods.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/pages/scripts/form-validation-md.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('//maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/gmaps/gmaps.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
