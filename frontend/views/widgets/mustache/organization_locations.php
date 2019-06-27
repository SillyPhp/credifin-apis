<?php

use yii\helpers\Url;

?>
    <script id="organization-locations" type="text/template">
        {{#.}}
        <div class="org-location">
            <div class="office-heading">
                {{location_name}}
            </div>
            <div class="office-loc">
                <div class="off-add">
                    {{address}}
                </div>
                <div class="off-city">{{city}}, {{state}}, {{country}}, {{postal_code}}</div>
            </div>
            <?php
            if ($Edit) {
                ?>
                <a value="/account/locations/get-data?id={{location_enc_id}}" class="edit_location"><i class="fas fa-pencil-alt"></i></a>
                <a href="#" class="remove_location"><i class="fas fa-times-circle"></i></a>
                <div id="remove_location_confirm" class="confirm_remove_loc">
                    <button id="confirm_loc" type="button" value="{{location_enc_id}}"
                            class="btn btn-primary btn-sm editable-submit"><i class="glyphicon glyphicon-ok"></i>
                    </button>
                    <button id="cancel_loc" type="button" class="btn btn-default btn-sm editable-cancel"><i
                                class="glyphicon glyphicon-remove"></i></button>
                </div>
                <?php
            }
            ?>
        </div>

        {{/.}}
    </script>
<?php
$this->registerCss("
.org-location:hover .remove_location, .remove_location:hover, .org-location:hover .edit_location, .edit_location:hover{
    display:block;
}
.remove_location, .edit_location{
    display:none;
    color: red;
    position: absolute;
    line-height: 26px;
    font-size: 24px;
    top: 5px;
    right: 10px;
}
.edit_location{
    right: 38px;
    color: #fff;
    width: 22px;
    font-size: 14px;
    background-color: #00a0e3;
    height: 22px;
    border-radius: 50%;
    text-align: center;
    line-height: 21px;
    top: 8px;
}
.confirm_remove_loc{
    position: absolute;
    right: 0;
    top: 0;
    display:none;
}
");
$script = <<<JS

$(document).on('click', '.edit_location', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('value'));
});


function getLocations() {
    $.ajax({
        method: "POST",
        url : window.location.href,
        success: function(response) {
            if(response.status === 200) {
                var location_data = $('#organization-locations').html();
                $(".head-office").html(Mustache.render(location_data, response.locations));
                var location_main = [];
                    var q = 1;
                $.each(response.locations, function(){
                    location_main.push([this.location_name, this.latitude, this.longitude, q]);
                    q++;
                });
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 4,
                    center: new google.maps.LatLng(30.900965, 75.857277),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                var marker, i;

                for (i = 0; i < location_main.length; i++) { 
                  marker = new google.maps.Marker({
                    position: new google.maps.LatLng(location_main[i][1], location_main[i][2]),
                    map: map
                  });
                }
                // renderLocations(response.locations);
            }
        }
    });
}

getLocations();
JS;
if ($Edit) {
    $this->registerJs("
        $(document).on('click', '.remove_location', function(e) {
            e.preventDefault();
            $(this).next().fadeIn();
        });
        $(document).on('click', '#cancel_loc', function() {
            $(this).parent().fadeOut();
        });
        $(document).on('click', '#confirm_loc', function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            $('#remove_video_confirm').fadeOut(1000);
            var id = $(this).val();
            $.ajax({
                url: '/organizations/location-delete',
                method: 'POST',
                data: {id:id},
                beforeSend:function(){     
                    $('#page-loading').fadeIn(1000);  
                },
                success: function (response) {
                $('#page-loading').fadeOut(1000);
                    if (response.title == 'Success') {
                        toastr.success(response.message, response.title);
                        getLocations();
                    } else {
                        toastr.error(response.message, response.title);
                    }
                }
            });
        });
    ");
}
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);