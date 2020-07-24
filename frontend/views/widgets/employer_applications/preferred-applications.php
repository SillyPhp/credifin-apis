<?php

use yii\helpers\Url;

$baseUrl = Url::base(true);
?>
    <div class="ji-tabs">
        <div class="container">
            <ul id="myTabs" class="nav nav-pills nav-justified set-w" role="tablist" data-tabs="tabs">
                <li class="active use-act" data-id="jobs"><a href="#featured-cards-jobs" data-toggle="tab">Jobs</a></li>
                <li class="use-act" data-id="internships"><a href="#featured-cards-internships" data-toggle="tab">Internships</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="featured-cards-jobs">
                    <?= $this->render('/widgets/preloaders/preferred-application-card'); ?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="featured-cards-internships">
                    <?= $this->render('/widgets/preloaders/preferred-application-card'); ?>
                </div>
            </div>
            <div class="v-btn">
                <a href="<?= Url::to('/jobs'); ?>" id="view-all-application">View All</a>
            </div>
        </div>
    </div>
<?php
echo $this->render('/widgets/mustache/application-card');
$this->registerCss('
#app-data{overflow-x:unset !important}
.set-w {
    max-width: 450px;
    margin: auto;
    margin-top: 20px;
    display: flex;
    background-color: #00a0e3;
    padding: 8px 3px;
    border-radius: 4px;
    justify-content: center;
    margin-bottom:20px;
}
.nav-pills li a{
    color:#fff;
    font-family:roboto;
    font-size:18px;
    font-weight:500;
    margin:0 5px;
    transition:all .3s;
    padding:8px 15px;
}
.use-act{flex-basis:50%;}
.nav-pills li a:hover, .nav-pills li.active > a, .nav-pills li.active > a:hover, .nav-pills li.active > a:focus{
    background-color:#fff !important;
    color:#00a0e3;
}
.v-btn{text-align:center;}
.v-btn a{
    font-size: 18px;
    font-family: roboto;
    background-color: #fff;
    border: 2px solid #828181;
    color: #828181;
    padding: 8px 40px;
    border-radius: 4px;
    transition:all .3s;
}
.v-btn a:hover{
    background-color: #00a0e3;
    border: 2px solid transparent;
    color: #fff;
}
.widget-heading {
	text-align: center;
	font-size: 27px;
	padding-bottom: 20px;
	color: #333;
	font-family: lora;
	font-weight: 600;
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
.btn-for-job {
	text-align: center;
	margin: 15px 0 20px;
}
.btn-for-job a {
	background: #fff;
	color: #333;
	padding: 8px 20px;
	font-size: 20px;
	border-radius: 4px;
	text-transform: capitalize;
	word-spacing: 2px;
	border: 1px solid #000;
	transition: all .3s;
	font-family: roboto;
}
.btn-for-job a:hover {
	background: #00a0e3;
	color: #fff;
	border: 1px solid #00a0e3;
	box-shadow: 0 0 11px 5px #eee;
}
');
$script = <<<JS
var baseUrl = "$baseUrl";
$(document).on('click', '.use-act', function(e) {
    e.preventDefault();
    var displayCity = localStorage.getItem("displayCity");
    var id = $(this).attr('data-id');
    var view_link = $('#view-all-application').attr('href', baseUrl + '/' + id + '-in-' + displayCity);
});
 var x, lat, lng, city, state, country, geocoder, latlng, loc;
 $(document).ready(function() {
     $('#featured-head').hide();
     getLocation();
 });
 function result() {
     loc = city + ', ' + state + ', ' + country;
     getCards(type = 'Internships',container = '#featured-cards-internships', url = '/employers/preferred-application-list',loc, 6, 'ai');
     getCards(type = 'Jobs',container = '#featured-cards-jobs', url = '/employers/preferred-application-list',loc, 6, 'ai');
     // if(city != ""){
     //    $('#prefer-heading').html('Jobs in ' + city);
     //    $('#65af4d5a').prop('href','/jobs-in-' + city)
     // }
 }
function ipLookUp () {
    city = localStorage.getItem("city");
    state = localStorage.getItem("state");
    country = localStorage.getItem("country");
    if(city || state){
        result();
    } else {
        $.getJSON('https://ipapi.co/json', function(data){
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
}
function geocodeLatLng(lat, lng) {
    geocoder = new google.maps.Geocoder();
    latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status === 'OK') {
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