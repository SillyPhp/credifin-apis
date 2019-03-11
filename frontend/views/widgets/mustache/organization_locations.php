<?php

use yii\helpers\Url;

?>
    <script id="organization-locations" type="text/template">
        {{#.}}
        <div class="org-location">
            <div class="office-heading">
                <!--            <img src="-->
                <? //= Url::to('@eyAssets/images/pages/company-and-candidate/branch-office.png') ?><!--">-->
                {{location_name}}
            </div>
            <div class="office-loc">
                <div class="off-add">
                    {{address}}
                </div>
                <div class="off-city">{{city}}, {{state}}, {{country}}, {{postal_code}}</div>
            </div>
            <a href="#" class="remove_location"><i class="fa fa fa-times-circle"></i></a>
            <div id="remove_location_confirm" class="confirm_remove_loc">
                <button id="confirm_loc" type="button" value="{{location_enc_id}}" class="btn btn-primary btn-sm editable-submit"><i class="glyphicon glyphicon-ok"></i></button>
                <button id="cancel_loc" type="button" class="btn btn-default btn-sm editable-cancel"><i class="glyphicon glyphicon-remove"></i></button>
            </div>
        </div>
        {{/.}}
    </script>
<?php
$this->registerCss("
.org-location:hover .remove_location, .remove_location:hover{
    display:block;
}
.remove_location{
    display:none;
    color: red;
    position: absolute;
    line-height: 26px;
    font-size: 24px;
    top: 5px;
    right: 10px;
}
.confirm_remove_loc{
    position: absolute;
    right: 0;
    top: 0;
    display:none;
}
");
$script = <<<JS
function getLocations() {
    $.ajax({
        method: "POST",
        url : window.location.href,
        success: function(response) {
            if(response.status === 200) {
                var location_data = $('#organization-locations').html();
                $(".head-office").html(Mustache.render(location_data, response.locations));
                // renderLocations(response.locations);
            }
        }
    });
}
$(document).on('click', '.remove_location', function(e) {
    e.preventDefault();
    $(this).next().fadeIn();
});
$(document).on('click', '#cancel_loc', function() {
    $(this).parent().fadeOut();
});
$(document).on('click', '#confirm_loc', function(event) {
    event.preventDefault();
    $('#remove_video_confirm').fadeOut(1000);
    var id = $(this).val();
    $.ajax({
        url: "/companies/location-delete",
        method: "POST",
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
getLocations();
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);