<?php
use yii\helpers\Url;
?>
<script id="organization-locations" type="text/template">
    {{#.}}
        <div class="office-heading">
<!--            <img src="--><?//= Url::to('@eyAssets/images/pages/company-and-candidate/branch-office.png') ?><!--">-->
            {{location_name}}
        </div>
        <div class="office-loc">
            <div class="off-add">
                {{address}}
            </div>
            <div class="off-city">{{city}}, {{state}}, {{country}}, {{postal_code}}</div>
        </div>
    {{/.}}
</script>
<?php
$this->registerCss("

");
$script = <<<JS
// function renderLocations(locations){
//     var card = $('#category-card').html();
//     var cardsLength = cards.length;
//     var noRows = Math.ceil(cardsLength / 4);
//     var j = 0;   
//     for(var i = 1; i <= noRows; i++){
//         $(".categories").append('<div class="row">' + Mustache.render(card, cards.slice(j, j+4)) + '</div>');
//         j+=3;
//     }
// }

function getLocations() {
    $.ajax({
        method: "POST",
        url : window.location.href,
        success: function(response) {
            if(response.status === 200) {
                var location_data = $('#organization-locations').html();
                $(".head-office").append(Mustache.render(location_data, response.locations));
                // renderLocations(response.locations);
            }
        }
    });
}
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);