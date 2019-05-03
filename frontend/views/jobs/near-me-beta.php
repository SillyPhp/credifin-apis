<?php
$this->params['header_dark'] = true;

use yii\web\JqueryAsset; ?>
<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <div class="near-me-search row">
            <div class="col-md-3">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <input type="text" class="form-control" id="job_keyword" placeholder="Job Title or Keywords"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group form-md-line-input">
                    <input type="text" class="form-control" id="city_location" placeholder="Enter Address or city"/>
                </div>
            </div>
            <div class="col-md-4 pt-20">
                <input type="text" autocomplete="off" id="range_3">
            </div>
            <div class="col-md-2">
                <button type="submit" id="search_jobs" class="btn near-me-btn">Search</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 near-me-map" data-spy="affix" data-offset-top="138">
        <div id="map"></div>
    </div>
    <div class="col-md-2 near-me-filters pl-0">
        <?=
        $this->render('/widgets/sidebar-review', [
            'type' => 'jobs',
        ]);
        ?>
    </div>
    <div class="col-md-4 col-md-offset-2">
        <div class="row">
            <div class="col-md-12">
                <div class="n-header-bar">
                    <h4 id="total-jobs">Available Jobs()</h4>
                </div>
            </div>
        </div>

        <div class="row" id="near-me-cards">
            <?= $this->render('/widgets/preloader-application-card',[
                    'size' => 'col-md-12'
            ]); ?>
        </div>
        <div id="loading">
            <button id="Load">Load</button>
        </div>

    </div>
</div>


<script id="cards" type="text/template">
    {{#.}}
    <div class="col-md-12 col-sm-12 col-xs-12 pt-5">
        <div id="card-hover" data-id="{{application_enc_id}}" data-key="{{application_enc_id}}-{{location_enc_id}}"
             class="application-card-main">
            {{#city_name}}
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;{{city_name}}
                </span>
            {{/city_name}}
            {{^city_name}}
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fa fa-map-marker"></i>&nbsp;All India
                </span>
            {{/city_name}}
            <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                <div class="application-card-img">
                    <a href="/{{organization_slug}}" id="organization-slug" class="{{organization_slug}}">
                        {{#logo}}
                        <img src="{{logo}}" id="{{logo}}" class="company-logo">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon company-logo" name="{{name}}" width="80" height="80"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </a>
                </div>
                <div class="application-card-description">
                    <a href="/job/{{slug}}"><h4 class="application-title">
                            {{job_title}}</h4>
                    </a>
                    {{#salary}}
                    <h5 id="salary"><i class="fa fa-inr"></i>&nbsp;{{salary}}</h5>
                    {{/salary}}
                    {{^salary}}
                    <h5 id="salary">Negotiable</h5>
                    {{/salary}}
                    {{#type}}
                    <h5 class="type">{{type}}</h5>
                    {{/type}}
                    {{#experience}}
                    <h5 class="exp"><i class="fa fa-clock-o"></i>&nbsp;{{experience}}</h5>
                    {{/experience}}
                </div>
            </div>
            {{#last_date}}
            <h6 class="col-md-5 pl-20 custom_set2 text-center last-date" id="{{last_date}}">
                Last Date to Apply
                <br>
                {{last_date}}
            </h6>
            <h4 class="col-md-7 org_name text-right pr-10 company-name">
                {{name}}
            </h4>
            {{/last_date}}
            {{^last_date}}
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h4 class="org_name text-right">{{name}}</h4>
            </div>
            {{/last_date}}
            <div class="application-card-wrapper">
                <a href="/job/{{slug}}" class="application-card-open" id="{{slug}}">View Detail</a>
                <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>
            </div>
        </div>
    </div>
    {{/.}}
</script>


<?php
$this->registerCss('
.near-me-map{
    float:right !important;
}
#map{
    height: calc(100vh - 50px);
}
.side-menu{
    width:16%;
}
#review-internships{
    width:auto;
}
.near-me-filters{
    position:fixed;
    width: 16%;
    top: 52px;
    left: 0;
    height: calc(100vh - 52px);
    overflow-y: scroll;
    overflow-x: hidden;
    box-shadow: 0px 0px 10px 1px #e6e6e6;
}
.near-me-map{
    height: calc(100vh - 52px);
    margin-top: 15px;
}
.near-me-map.affix{
//    position:fixed;
    top: 52px;
    right: 0;
    padding-right:0px;
    margin-top: 0px;
}
.n-header-bar{
    padding: 20px;
    box-shadow: 0px 0px 12px 2px #e6e6e6;
    margin: 15px 0px;
    border-radius: 4px;
    background-color: #fff;
}
.n-header-bar h4{
    display: inline;
    font-size: 16px;
}
.in-map{
    margin-bottom:0px;
}
.gm-style .gm-style-iw-c{
    padding:0px;
    overflow: visible;
}
.gm-style .gm-style-iw-d{
    overflow:hidden !important;
    max-width:400px !important;
}
.gm-ui-hover-effect {
    opacity: 1;
    background-color: #fff !important;
    right: -26px !important;
    top: 0 !important;
    z-index: 999;
    border-radius: 0px 6px 6px 0px;
}
.irs--round .irs-bar, .irs--round .irs-from, .irs--round .irs-to, .irs--round .irs-single{
    background-color: #00a0e3;
}
.irs--round .irs-handle{
    border: 4px solid #00a0e3;
}
.near-me-search{
    background-color: #fff;
    margin: 0;
    margin-top: 10px;
    padding: 2px 10px;
    border-radius: 5px;
}
.near-me-btn{
    margin: 20px 0px;
    display: inline-block;
    width: 100%;
    padding: 15px !Important;
    background-color: #00a0e3;
    color: #fff;
}
.loader-main{
    padding: 0px 15px;
}
#sticky {
    top: 0px !important;
}
#footer{display:none;}
//.filter-search{
//    padding-bottom: 20px;
//}
//.f-main-heading{
//    display: flex;
//}
//.show-search{
//    margin-left: 15px;
//    margin-top: 5px;
//}
//.show-search button{
//    background: transparent;
//    border:none;
//    font-size: 15px;
//    color: #666;
//    float:right;
//}
//.show-search button:hover{
//    color:#00a0e3;
//}
//.f-search-loc{
//   border:1px solid #eee; 
//   padding:5px 15px;
//   border-radius:10px;
//   margin-top:15px;
//   position:relative;  
//}
//.f-search-loc input{
//    border:none;
//    font-size: 14px;
//}
//.f-search-loc input::placeholder{
//    color:#999;
//}
//.f-search-loc i{
//    color: #999;
//    position: absolute;
//    right: 10px;
//    top: 10px;
//}
//.md-checkbox label>.box{
//    top:6px;
//    border: 2px solid #ddd;
//}
//.md-checkbox-list .md-checkbox{
//    margin-bottom:-10px;
//}
//.f-ratings{
//    padding:5px 15px;
//    border:1px solid #eee;
//    border-radius:10px;
//}
//.form label{
//    margin-bottom: 0px !important;
//}
//.filter-heading{
//    padding: 4px 0px 10px 10px;
//    font-size: 13px;
//    font-weight: 600;
//    text-transform: uppercase;
//}
//.overall-box-heading{
//    font-size:13px;
//    padding-top:5px;
//    font-weight:bold;
//}
//.all-label-2{
//    padding-top:7px;
//    font-weight:500;
//    font-size:13px;
//    text-transform: capitalize;;
//}
//.f-rating-box-2{
//    margin-top:20px;
//    position:relative; 
//}
');
$script = <<< JS


var map;
var marker;
var  purple_icon = 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
var infowindow = new google.maps.InfoWindow();
function showCards(lat,long,range,keyword){
    
    var i;
    var inprange = {
        rangerval : range
    };
    var centre = {lat: lat, lng: long};
    map = new google.maps.Map(document.getElementById('map'),{
        center: centre,
        zoom: 4,
        mapTypeId: 'roadmap',
    });
    
    myCity = new google.maps.Circle({
                center: centre,
                radius: inprange.rangerval * 1000,
                strokeColor: "#0000FF",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#0000FF",
                fillOpacity: 0.4
              });
              
    
              var position = {lat: lat, lng: long};
              map.setCenter(position);
              map.setZoom(11);
             
              myCity.setMap(map);
              
              var num = 0;
              
              function card(){
                  $('#Load').remove();
              $.ajax({
                    url: '/jobs/near-me',
                    type: 'post',
                    data: {lat:lat,long:long,radius:inprange.rangerval * 1000,num:num,keyword:keyword},
                    success: function (res) {
                        $('.loader-main').remove();
                        var response = JSON.parse(res);
                        if(!response['total']){
                            $('#Load').remove();
                            $('#total-jobs').text("Available Jobs("+response.total+")");
                            $('#near-me-cards').html('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
                        }else{
                            $('#total-jobs').text("Available Jobs("+response.total+")");
                            for(i=0;i<response[0].length;i++){
                                    marker = new google.maps.Marker({
                                    position: {lat: Number(response[0][i].latitude), lng: Number(response[0][i].longitude)},
                                    map: map,
                                    draggable: false
                                });                          
                                
                            }
                            $('#loading').append('<button id="Load">Load</button>');
                            var template = $('#cards').html();
                            var rendered = Mustache.render(template,response[0]);
                            $('#near-me-cards').append(rendered);
                            utilities.initials();
                            num = num+20;
                            
                            if(response[0].length < 20){
                                $('#Load').remove();
                            }
                        }
                  }
                });
              }
              
              $(document).on('click','#Load',function() {
                card();
              });
              
              card();
              
              map.addListener('click', function(e) {
                  infowindow.close();
              });
              
              myCity.addListener('click', function(e) {
                  infowindow.close();
              });
    
}

$(document).on("mouseenter","#card-hover",function() {
    
        if (infowindow) {
            infowindow.close();
        }
        types = $(this).find('.type').text();
        salary = $(this).find('#salary').text();
        lat = $(this).find('.location').attr('data-lat');
        lon = $(this).find('.location').attr('data-long');
        titles = $(this).find('.application-title').text();
        locations =  $(this).find('.location').text();
        last_date = $(this).find('.last-date').attr('id');
        exp = $(this).find('.exp').text();
        company =  $(this).find('.company-name').text();
        logo = $(this).find('.company-logo').attr('id');
        logo_color = $(this).find('.company-logo').attr('color');
        slug = $(this).find('.application-card-open').attr('id');
        org_slug = $(this).find('#organization-slug').attr('class');
        if(!logo){
            logo = '<canvas class="user-icon image-partners" name="'+company+'" color="'+logo_color+'" width="80" height="80" font="24px"></canvas>';
        }else{
            logo = '<img class="side-bar_logo" src="' + logo + '" height="40px">';
        }
        var contentString = '<div class="col-md-12 col-sm-12 col-xs-12 p-0"><div class="application-card-main in-map"><span class="application-card-type location"><i class="fa fa-map-marker"></i>&nbsp;'+locations+'</span><div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom"><div class="application-card-img"><a href="/'+org_slug+'">'+logo+'</a></div><div class="application-card-description"><a href="/job/'+slug+'"><h4 class="application-title">'+titles+'</h4></a><h5><i class="fa fa-inr"></i>&nbsp;'+salary+'</h5><h5 class="type">'+types+'</h5><h5 class="exp"><i class="fa fa-clock-o"></i>&nbsp;'+exp+'</h5></div></div><h6 class="col-md-5 pl-20 custom_set2 text-center last-date">Last Date to Apply<br>'+last_date+'</h6><h4 class="col-md-7 org_name text-right pr-10 company-name">'+company+'</h4><div class="application-card-wrapper"><a href="/job/'+slug+'" class="application-card-open">View Detail</a><a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a></div></div></div>';
         infowindow = new google.maps.InfoWindow({
          content: contentString
        });
            utilities.initials();
         marker = new google.maps.Marker({
            position: new google.maps.LatLng(Number(lat),Number(lon)),
            map: map,
            // icon: purple_icon,
            draggable: false
        });
          infowindow.open(map, marker);
    });

function initMap(){
        
    if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCallback,showError);
        }else{
        }
        
        function successCallback(position){
            var lat = position.coords.latitude;
            var long = position.coords.longitude;
            var range = $('#range_3').prop("value");
            geocodeLatLng(lat,long);
            showCards(lat,long,range);
        }
    
        function showError(error) {
          switch(error.code) {
            case error.PERMISSION_DENIED:
              break;
          }
        }
}

function geocodeLatLng(lat,long) {
     var geocoder = new google.maps.Geocoder();
        var latlng = {lat: lat, lng: long};
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
                $('#city_location').val(results[0].formatted_address);
            } else {
              console.log('No results found');
            }
          } else {
            console.log('Geocoder failed due to: ' + status);
          }
        });
      }

function geocodeAddress(city,range,keyword) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': city}, function(results, status) {
          if (status === 'OK') {
            var lat = results[0].geometry.location.lat();
            var long = results[0].geometry.location.lng();
            showCards(lat,long,range,keyword);
          } else {
            console.log('Geocode was not successful for the following reason: ' + status);
          }
        });
      }

initMap();

$("#range_3").ionRangeSlider({
                skin: "round",
                min: 5,
                max: 50,
                from: 50,
                grid: true,
                grid_num: 9,
                step: 1,
                force_edges: true,
                postfix: " km",
            });
 
 $(document).on('click','#search_jobs',function(e) {
     e.preventDefault();
     $('#near-me-cards').html('');
   var city = $('#city_location').val();
   var range = $('#range_3').prop("value");
   var keyword = $('#job_keyword').val();
    geocodeAddress(city,range,keyword);
 });

var ps = new PerfectScrollbar('.near-me-filters');
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css');
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c"></script>
