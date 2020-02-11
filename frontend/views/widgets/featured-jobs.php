<?php

use yii\helpers\Url;

?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c" async></script>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="widget-heading">
                    <span><img src="" alt=""></span>
                    <span id="demo">Prefered Jobs</span>
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
        <!--        <div class="fj-form">-->
        <!--            <div class="row">-->
        <!--                <div class="col-md-6">-->
        <!--                    <div class="fj-sub-heading">Get Latest Updates in you inbox</div>-->
        <!--                </div>-->
        <!--                <div class="col-md-6">-->
        <!--                    <div class="fj-sub-form">-->
        <!--                        <form id="subs_news">-->
        <!--                            <div class="row">-->
        <!--                                <div class="col-md-9">-->
        <!--                                    <input type="text" name="email" class="fj-input" placeholder="Your Email">-->
        <!--                                </div>-->
        <!--                                <div class="col-md-3">-->
        <!--                                    <button type="submit" class="fj-btn">Notify Me</button>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                        </form>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
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
var vals = {
    lat: null,
    long: null,
};

$('#subs_news').submit(function(event) {
    event.preventDefault();
     var formData = $(this).serialize();
  $.ajax({
    url: '/site/add-new-subscriber',
    data: formData,
    method: 'POST',
  })
});

var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
    vals.lat = position.coords.latitude;
    vals.long = position.coords.longitude;
    vals.inprange = parseInt($('#range_3').prop("value") * 1000);
    geocodeLatLng(vals.lat,vals.long);
  // x.innerHTML = "Latitude: " + position.coords.latitude + 
  // "<br>Longitude: " + position.coords.longitude;
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      x.innerHTML = "User denied the request for Geolocation.";
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML = "Location information is unavailable.";
      break;
    case error.TIMEOUT:
      x.innerHTML = "The request to get user location timed out.";
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML = "An unknown error occurred.";
      break;
  }
}

//address from lat and long
function geocodeLatLng(lat,long) {
    var geocoder = new google.maps.Geocoder();
    var latlng = {lat: lat, lng: long};
    geocoder.geocode({'location': latlng}, function(results, status) {
      if (status === 'OK') {
        if (results[7]) {
            localStorage.setItem("location", results[7].formatted_address);
        } else if(results[8]){
            localStorage.setItem("location", results[8].formatted_address);
        }
      }
    });
    var location = localStorage.getItem("location");
    getCityEnc(location);
}

function getCityEnc(location){
    $.ajax({
        url : '/cities/get-city-enc?location='+location,
        method : 'POST',
        success : function(res) {
            if(res){
                localStorage.setItem("user_city_id", res);
            }
            var cityId = localStorage.getItem("user_city_id");
            getCards(type = 'Jobs',container = '#featured-job-cards', url = '/jobs/index', city_id = cityId);           
        }
    });
}

$(document).ready(function() {
  getLocation();
});

JS;
$this->registerJS($script);
?>
