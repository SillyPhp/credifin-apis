<?php

use yii\helpers\ArrayHelper;

?>
<div class="job-single-head2">
    <h4 class="p-location-heading">Navigate to Placement Location</h4>
    <ul class="p-locations">
        <?php
        foreach ($placement_locations as $placements) {
            echo'<li><a target="_blank" class="map-navigate" title="Navigate to Google Map" href="http://maps.google.com/maps?daddr=' . $placements['latitude'] . ',' . $placements['longitude'] . '"><img src="/assets/themes/ey/images/pages/jobs/city-map.png" /><span>' . $placements['name'] . '</span></a></li>';
        }
        ?>
    </ul>
</div>
<?php
$this->registerCss('
.p-location-heading{
    width: 100%;
    font-family: Open Sans;
    font-size: 15px;
    color: #202020;
    font-weight: 600;
}
.p-locations li{
    max-width: 125px;
    box-shadow: 0px 1px 10px -2px #ddd;
    background-color: #35394F;
    background-image: linear-gradient(-40deg, #35394F 25%, #787D90);
    display: inline-block;
    margin: 8px;
    box-shadow: 0px 1px 10px -2px #ddd;
}
.p-locations li a{
    color: #222;
    position: relative;
    display:block;
}
.p-locations li a:before, .p-locations li a:after{
    content:"";
    position:absolute;
    width:100%;
    height:78%;
    left:0;
    top:0;
    background-repeat: no-repeat;
    background-position: center;
    display:block;
    opacity:0;
     -webkit-transition: opacity 0.7s ease;
  -moz-transition: opacity 0.7s ease;
  -ms-transition: opacity 0.7s ease;
  -o-transition: opacity 0.7s ease;
  transition: opacity 0.7s ease-out;
}
.p-locations li a:before{
    background:url("/assets/themes/ey/images/pages/jobs/direction_icon.png");
    z-index: 2;
    background-repeat: no-repeat;
    background-position: center;
    background-size: 40%;
}
.p-locations li a:after{
    background-color: #000;
}
.p-locations li:hover a:before{
    opacity:1;
}.p-locations li:hover a:after{
    opacity:0.55;
}
.p-locations li a img{
    width: 90%;
    margin-left: 5%;
    padding: 10px;
}
.p-locations li a span{
    font-size: 14px;
    color:#fff;
    padding: 0px 4px;
    height: 35px;
    line-height: 35px;
    width: 100%;
    text-align: center;
    display: block;
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
    background-color: #787E91;
    box-shadow: 0 -10px 5px -5px #393d52;
}
.p-locations li:hover a span{
    background-color: #00a0e3;
    color:#fff;
}
');
$this->registerJs('
if(navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(successCallback);
}

//successful locatin permission
function successCallback(position){
   var lat = position.coords.latitude;
   var long = position.coords.longitude;
   $(".map-navigate").each(function(){
    var default_attr = $(this).attr("href");
    $(this).attr("href", default_attr+"&saddr="+lat+","+long);
   });
//   geocodeLatLng(vals.lat,vals.long);
//   showCards();
}
');