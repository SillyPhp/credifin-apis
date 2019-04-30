<?php
$this->params['header_dark'] = true;
?>
<div class="row">
    <div class="col-md-6 near-me-map pr-0">
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

        </div>
        <button id="Load">Load</button>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p class="modal-title">Please enter your address</p>
            </div>
            <div class="modal-body">
                <input id="address" type="textbox" value="Ludhiana">
                <input id="submit" type="button" value="Search">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script id="cards" type="text/template">
    {{#.}}
    <div id="card-hover" class="col-md-12 col-sm-12 col-xs-12 pt-5">
        <div data-id="{{application_enc_id}}" data-key="{{application_enc_id}}-{{location_enc_id}}" class="application-card-main ui-draggable ui-draggable-handle">
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
                    <a href="/{{organization_slug}}">
                        {{#logo}}
                        <img src="{{logo}}" id="{{logo}}" class="company-logo">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon" name="{{name}}" width="80" height="80"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </a>
                </div>
                <div class="application-card-description">
                    <a href="/job/{{slug}}"><h4 class="application-title">
                            {{job_title}}</h4>
                    </a>
                    {{#salary}}
                    <h5><i class="fa fa-inr"></i>&nbsp;{{salary}}</h5>
                    {{/salary}}
                    {{^salary}}
                    <h5>Negotiable</h5>
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
                <a href="/job/{{slug}}" class="application-card-open">View Detail</a>
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
    height:100vh;
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
    position:fixed;
    top: 52px;
    right: 0;
    height: calc(100vh - 52px);
}
.n-header-bar{
    padding: 20px;
    box-shadow: 0px 0px 12px 2px #e6e6e6;
    margin: 15px 0px;
    border-radius: 4px;
}
.n-header-bar h4{
    display: inline;
    font-size: 16px;
}
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

var data = [$lat_long];
var map;
var marker;
var  purple_icon = 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
// var infowindow = null;
function showCards(lat,long){
    
    var i;
    var inprange = {
        rangerval : 20
    };
    var centre = {lat: lat, lng: long};
    map = new google.maps.Map(document.getElementById('map'),{
        center: centre,
        zoom: 4,
        mapTypeId: 'roadmap'
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
              $.ajax({
                    url: '/jobs/near-me',
                    type: 'post',
                    async: false,
                    cache: false,
                    data: {lat:lat,long:long,radius:inprange.rangerval * 1000,num:num},
                    success: function (res) {
                        var response = JSON.parse(res);
                        console.log(response);
                        $('#total-jobs').text("available Jobs("+response.total+")");
                        // console.log(response[0].latitude);
                        // console.log(response[0].longitude);
                        for(i=0;i<response[0].length;i++){
                            // console.log(response[0][i].latitude,' , ',response[0][i].longitude);
                            var contentString = '<p>'+response[0][i].name+'<\p>';
                            // console.log(Number(response[i].latitude)," , ",Number(response[i].longitude));
                                marker = new google.maps.Marker({
                                position: {lat: Number(response[0][i].latitude), lng: Number(response[0][i].longitude)},
                                map: map,
                                draggable: false
                            });
                           
                            infowindow = new google.maps.InfoWindow({
                            content: contentString,
                            maxWidth: 200
                            });
                            
                            
                        }
                        var template = $('#cards').html();
                        var rendered = Mustache.render(template,response[0]);
                        $('#near-me-cards').append(rendered);
                        num = num+20;
                    }
                });
              }
              
              $(document).on('click','#Load',function() {
                card();
              });
              
              card();
    
}

$(document).on("mouseenter","#card-hover",function() {
        if (infowindow) {
            infowindow.close();
        }
        types = $(this).find('.type').text();
        lat = $(this).find('.location').attr('data-lat');
        lon = $(this).find('.location').attr('data-long');
        titles = $(this).find('.application-title').text();
        locations =  $(this).find('.location').text();
        lastDates = $(this).find('.last-date').attr('id');
        periods = $(this).find('.exp').text();
        companys =  $(this).find('.company-name').text();
        logos = $(this).find('.company-logo').attr('id');
         var contentString = '<div style="width:400px;" class="product shadow iconbox-border iconbox-theme-colored"><span class="type tag-sale color-o pl-20 pr-20 ">'+types+'</span><div class="row"><div class="col-md-4 col-xs-4 pt-5" ><a href="#" class="icon set_logo"><img class="logo" src="'+logos+'"></a></div><div class="col-md-8 col-xs-8 pt-20"><h4 class="title icon-box-title"><strong>'+titles+'</strong></h4><h5><i class="location fa fa-map-marker" lat="'+lat+'" long="'+lon+'"> '+locations+'</i></h5><h5><i class="period fa fa-clock-o"> '+periods+'</i></h5></div><div class="btn-add-to-cart-wrapper"><a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS</a><a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#"><i class="fa fa-plus"></i></a></div></div><hr class="hr"><h6 class="pull-left pl-20 custom_set2" align="center"><strong>Last Date to Apply</strong><br><div class="lastDate">'+lastDates+'</div></h6><h4 class="company pull-right pr-10 pt-20 custom_set" align="center"><strong>'+companys+'</strong></h4></div>';    
         infowindow = new google.maps.InfoWindow({
          content: contentString
        });
         marker = new google.maps.Marker({
            position: new google.maps.LatLng(Number(lat),Number(lon)),
            map: map,
            // icon: purple_icon,
            draggable: true
        });
         // var position = new google.maps.LatLng(Number(lat),Number(lon));
         // map.setCenter(position);
         // map.setZoom(16);
          infowindow.open(map, marker);
    });
        


function initMap(){
        
    if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCallback,showError);
            // console.log('Getting the position information....');
        }else{
            console.log('Sorry, your browser does not support HTML5 geolocation.');
        }
        
        function successCallback(position){
            var lat = position.coords.latitude;
            var long = position.coords.longitude;
            
            showCards(lat,long);
        }
    
        function showError(error) {
          switch(error.code) {
            case error.PERMISSION_DENIED:
              $('#myModal').modal();
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
                
            var geocoder = new google.maps.Geocoder();
        
                document.getElementById('submit').addEventListener('click', function() {
                    $('#myModal').modal('toggle');
                  geocodeAddress(geocoder);
                });
}

function geocodeAddress(geocoder) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            // console.log(results[0].geometry.location.lat());
            // console.log(results[0].geometry.location.lng());
            var lat = results[0].geometry.location.lat();
            var long = results[0].geometry.location.lng();
            // resultsMap.setCenter(results[0].geometry.location);
            showCards(lat,long);
          } else {
            console.log('Geocode was not successful for the following reason: ' + status);
          }
        });
      }

initMap();
var ps = new PerfectScrollbar('.near-me-filters');
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c"></script>
