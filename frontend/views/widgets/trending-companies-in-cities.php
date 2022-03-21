<?php

use yii\helpers\Url;

?>
<script id="org-cards" type="text/template">
    <div class="top-cities" id="cities-carousel">
        {{#.}}
        <a href="/{{slug}}" class="item">
            <div class="top-cities-img">
                <img src="{{logo}}" alt="{{name}}" title="{{name}}">
            </div>
            <div class="company-name">{{name}}</div>
        </a>
        {{/.}}
    </div>
</script>
<?php
$this->registerCss('
.top-cities {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin:20px 0;
}
.top-cities a {
    position: relative;
    flex-basis:15%;
}
.top-cities-img {
    width: 110px;
    height: 110px;
    margin: 10px 40px 10px;
    border-radius: 60px;
    overflow: hidden;
    box-shadow: 0 0 13px 4px #eee;
    line-height: 85px;
    padding: 10px;
}
.company-name {
    opacity:0;
    text-align: center;
    font-family: "Roboto";
    font-weight: 500;
    font-size: 15px;
    display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;  
  overflow: hidden;
    transition: all .3s;
}
.top-cities-img:hover + .company-name{
    opacity:1;
}
.top-cities-img img, .top-cities-img canvas {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

@media only screen and (max-width: 767px){
    #cities-carousel .top-cities-img {
        margin: 0 auto;
    }
    #cities-carousel .owl-controls .owl-nav .owl-prev {
        left: 0 !important;
        top: 20px;
    }
    #cities-carousel .owl-controls .owl-nav .owl-next {
        right: 0 !important;
        top: 20px;
    }
    #cities-carousel .owl-controls .owl-nav .owl-prev i, #cities-carousel .owl-controls .owl-nav .owl-next i{
        font-size: 40px !important;
    }
    #cities-carousel .top-cities-img {
        width: 88px;
        height: 88px;
    }
}

');
$userCity = Yii::$app->userData->currentCity;
if($userCity){
    $cityName = $userCity['name'];
} else{
    $cityName = 0;
}
$script = <<< JS

$(document).ready(function () {
    if ($(window).width() > 767){
        $('.top-cities').removeAttr('id');
    }
    $('#cities-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        navText: [
            "<i class='fa fa-angle-left'></i>",
            "<i class='fa fa-angle-right'></i>"
          ],
        responsive:{
            0:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
});


let userCity = "$cityName";
if(userCity != "0"){
    $('#trendingCityName').text(userCity);
    getLocationData(userCity);
    $('#location-btn').attr('href','/organizations?keyword='+userCity);
} else{
    if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback,showError);
    }
}

//successful locatin permission
function successCallback(position){
    let lat = position.coords.latitude;
    let long = position.coords.longitude;
    geocodeLatLng(lat,long);
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
        getLocationFromIp();
        break;
  }
}
//address from lat and long
function geocodeLatLng(lat,long) {
    var geocoder = new google.maps.Geocoder();
    var latlng = {lat: lat, lng: long};
    geocoder.geocode({'location': latlng}, function(results, status) {
      if (status === 'OK') {
        if (results[0]) {
            let dataList = results[0].address_components;
            for(let p=0;p<dataList.length;p++) {
                if(dataList[p].types.includes("administrative_area_level_2")){
                    $('#trendingCityName').text(dataList[p].long_name);
                    getLocationData(dataList[p].long_name);
                    $('#location-btn').attr('href','/organizations?keyword='+dataList[p].long_name);
                    return false;
                }
            }
        } else {
          getLocationFromIp(); 
        }
      }
    });
}

function getLocationFromIp(){
    $.getJSON('https://ipapi.co/json', function(data){
        $('#trendingCityName').text(data.city);
        if(!data.city){
            $('#trending-companies-by-location').html('Trending Companies');
        }
        getLocationData(data.city);
        $('#location-btn').attr('href','/organizations?keyword='+data.city);
    });
}
function getLocationData(city) {
        $.ajax({
      url:'/jobs/top-city-companies',
      method:'Post',
      data:{
          city_name:city
      },
      success:function(body) {
          if (body.status == 200){
              $('#trendingOrgCardsMain').html(Mustache.render($('#org-cards').html(),body.organizations));
          } else{
            //   $('#trendingCompaniesSectionMain').remove();
          }
      }   
     });
     }
JS;
$this->registerJs($script);
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c"></script>
