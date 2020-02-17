<?php

use yii\helpers\Url;

?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-heading">
                        <span><img src="" alt=""></span>
                        <span>Prefered Jobs</span>
                        <span class="fj-wa" data-toggle="tooltip" title="Click to join us on whatsapp">
                <a href="https://chat.whatsapp.com/JTzFN51caeqIRrdWGneBOi">
                    <i class="fab fa-whatsapp-square"></i> Join Us
                </a>
            </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="featured-job-cards"></div>
                </div>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/mustache/application-card');
$this->registerCss('
.widget-heading{
    text-align:center;
    font-size:25px;
    padding-bottom:20px;
    color:#333;
    font-family: roboto;
}
.fj-wa a{
    font-size:18px;
    padding-left:5px;
    color: #25D366; 
}
.fj-sub-heading{
    font-size: 18px;
    text-transform: capitalize;
    font-family: roboto;
    padding:8px 10px;    
}

.fj-form {
    border:1px solid #eee;
    padding:20px 10px 15px;
    margin:20px 0;
    box-shadow:0 0 10px rgba(0,0,0,.2)
}
.fj-input{
    width:100%;
    padding:10px;
    border:1px solid #eee;
    font-size:15px;
}
.fj-input::placeholder{
    color:#999;
}
.fj-btn{
    color:#fff;
    background:#00a0e3;
    padding:10px 10px;
    border:none;
}
');
$script = <<<JS

 var x, lat, lng, city, state, country, geocoder, latlng, loc;
 $(document).ready(function() {
     getLocation();
 });
 function result() {
     loc = city + ', ' + state + ', ' + country;
     // alert(loc);
     getCards(type = 'Jobs',container = '#featured-job-cards', url = '/jobs/index',loc);
 }
function ipLookUp () {
    city = localStorage.getItem("city");
    state = localStorage.getItem("state");
    country = localStorage.getItem("country");
    if(city || state){
        result();
    } else {
        $.getJSON('https://ipapi.co/json', function(data){
            console.error(data);
            city = data.city;
            state = data.region;
            country = data.country_name;
            result();
        });
    }
}
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        x = "Geolocation is not supported by this browser.";
        ipLookUp();
        console.error(x);
    }
}
function showPosition(position) {
    lat = position.coords.latitude;
    lng = position.coords.longitude;
    // inprange = parseInt($('#range_3').prop("value") * 1000);
    geocodeLatLng(lat, lng);
}
function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            x = "User denied the request for Geolocation.";
            break;
        case error.POSITION_UNAVAILABLE:
            x = "Location information is unavailable.";
            break;
        case error.TIMEOUT:
            x = "The request to get user location timed out.";
            break;
        case error.UNKNOWN_ERROR:
            x = "An unknown error occurred.";
            break;
    }
    ipLookUp();
    console.error(x);
}
function geocodeLatLng(lat, lng) {
    geocoder = new google.maps.Geocoder();
    latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status === 'OK') {
            console.log(results);
            for (var i = 0; i < results[0].address_components.length; i++) {
                for (var b = 0; b < results[0].address_components[i].types.length; b++) {
                    switch (results[0].address_components[i].types[b]) {
                        case 'locality':
                            city = results[0].address_components[i].long_name;
                            break;
                        case 'administrative_area_level_1':
                            state = results[0].address_components[i].long_name;
                            break;
                        case 'country':
                            country = results[0].address_components[i].long_name;
                            break;
                    }
                }
            }
            localStorage.setItem("city", city);
            localStorage.setItem("state", state);
            localStorage.setItem("country", country);
        }
        city = localStorage.getItem("city");
        state = localStorage.getItem("state");
        country = localStorage.getItem("country");
        result();
    });
}



$('#subs_news').submit(function(event) {
    event.preventDefault();
     var formData = $(this).serialize();
  $.ajax({
    url: '/site/add-new-subscriber',
    data: formData,
    method: 'POST',
  })
});
JS;
$this->registerJS($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>