<?php

$this->params['header_dark'] = true;

use yii\web\JqueryAsset;

if ($type == 'jobs') {
    $job_type = 'job';
} elseif ($type == 'internships') {
    $job_type = 'internship';
}

?>

<div class="row m-0">
    <div class="col-md-10 col-md-offset-2">
        <div class="near-me-search row">
            <div class="col-md-3">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <input type="text" class="form-control" id="job_keyword" placeholder="Job Title or Keywords"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="load-suggestions Typeahead-spinner city-spin"
                     style="display: none;">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="form-group form-md-line-input">
                    <input type="text" class="form-control" id="city_location" placeholder="Enter Address or city"/>
                    <p class="error" style="color: red"></p>
                </div>
            </div>
            <div class="col-md-4 pt-10">
                <input type="text" autocomplete="off" id="range_3">
            </div>
            <div class="col-md-2">
                <button type="submit" id="search_jobs" class="btn near-me-btn">Search</button>
            </div>
        </div>
    </div>
</div>

<div class="row m-0">
    <div class="col-md-6 near-me-map pr-0" data-spy="affix" data-offset-top="138">
        <div id="map"></div>
    </div>
    <div class="col-md-2 near-me-filters pl-0">
        <?=
        $this->render('/widgets/sidebar-review', [
            'type' => $type,
        ]);
        ?>
    </div>
    <div class="col-md-4 col-md-offset-2 near-me-content">

        <div class="row">
            <div id="near-me-cards"></div>
        </div>

        <div class="row preloader-card">
            <?= $this->render('/widgets/preloader-application-card', [
                'size' => 'col-md-12'
            ]); ?>
        </div>

        <div id="loading">
            <a href="#" id="loadMore"
               class="ajax-paginate-link btn btn-border btn-more btn--primary load-more loading_more">
                <span class="load-more-text">Load More</span>
                <svg class="load-more-spinner" viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg"
                     stroke="currentColor">
                    <g fill="none" fill-rule="evenodd">
                        <g transform="translate(1 1)" stroke-width="2">
                            <circle cx="8.90684" cy="50" r="5">
                                <animate attributeName="cy" begin="0s" dur="2.2s" values="50;5;50;50"
                                         calcMode="linear" repeatCount="indefinite"></animate>
                                <animate attributeName="cx" begin="0s" dur="2.2s" values="5;27;49;5"
                                         calcMode="linear" repeatCount="indefinite"></animate>
                            </circle>
                            <circle cx="25.0466" cy="8.99563" r="5">
                                <animate attributeName="cy" begin="0s" dur="2.2s" from="5" to="5"
                                         values="5;50;50;5" calcMode="linear"
                                         repeatCount="indefinite"></animate>
                                <animate attributeName="cx" begin="0s" dur="2.2s" from="27" to="27"
                                         values="27;49;5;27" calcMode="linear"
                                         repeatCount="indefinite"></animate>
                            </circle>
                            <circle cx="47.0466" cy="46.0044" r="5">
                                <animate attributeName="cy" begin="0s" dur="2.2s" values="50;50;5;50"
                                         calcMode="linear" repeatCount="indefinite"></animate>
                                <animate attributeName="cx" from="49" to="49" begin="0s" dur="2.2s"
                                         values="49;5;27;49" calcMode="linear"
                                         repeatCount="indefinite"></animate>
                            </circle>
                        </g>
                    </g>
                </svg>
            </a>
        </div>
    </div>
</div>

<script id="cards" type="text/template">
    {{#.}}
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="card-hover" data-id="{{application_enc_id}}" data-key="{{application_enc_id}}-{{location_id}}"
             class="application-card-main shadow">
            <div class="app-box">
                <div class="row">
                    <div class="col-md-3">
                        <div class="application-card-img img-main">
                            <a href="{{organization_link}}" title="{{organization_name}}" id="organization-slug">
                                {{#logo}}
                                <img src="{{logo}}" alt="{{organization_name}}" title="{{organization_name}}"
                                     class="company_logo" id="{{logo}}">
                                {{/logo}}
                                {{^logo}}
                                <canvas class="user-icon company-logo" name="{{organization_name}}" width="80"
                                        height="80"
                                        color="{{color}}" font="35px"></canvas>
                                {{/logo}}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="comps-name-1 application-card-description">
                            <span class="skill">
                                <a href="{{link}}" title="{{title}}" class="application-title capitalize org_name">
                                    {{title}}
                                </a>
                            </span>
                            <a href="{{organization_link}}" title="{{organization_name}}" style="text-decoration:none;">
                                <h4 class="org_name comp-name">{{organization_name}}</h4>
                            </a>
                        </div>
                        {{#city}}
                        <span class="job-fill application-card-type location city" data-lat="{{latitude}}"
                              data-long="{{longitude}}">
                             <i class="fas fa-map-marker-alt"></i>&nbsp;{{city}}
                        </span>
                        {{/city}}
                        {{^city}}
                        <span class="job-fill application-card-type location city" data-lat="{{latitude}}"
                              data-long="{{longitude}}"
                              data-locations="">
                        <i class="fas fa-map-marker-alt"></i>&nbsp;All India
                        </span>
                        {{/city}}
                        </span>
                        <div class="detail-loc">
                            <div class="application-card-description job-loc">
                                {{#salary}}
                                <h5 class="salary"><i class="fas fa-rupee-sign"></i>&nbsp;{{salary}}</h5>
                                {{/salary}}
                                {{^salary}}
                                <h5 class="salary">Negotiable</h5>
                                {{/salary}}
                                {{#type}}
                                <h5 class="type">{{type}}</h5>
                                {{/type}}
                                {{#experience}}
                                <h5 class="exp"><i class="far fa-clock"></i>&nbsp;{{experience}}</h5>
                                {{/experience}}
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 p-0 skills-main">
                        <div class="tag-box">
                            <div class="tags">
                                {{#skill}}
                                <span class="after skills">{{.}}</span>
                                {{/skill}}
                                {{^skill}}
                                <span class="after skills">Multiple Skills</span>
                                {{/skill}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="application-card-wrapper">
                    <a href="{{link}}" class="application-card-open" title="View Detail">View Detail</a>
                    <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i
                                class="fas fa-plus"></i>&nbsp;</a>
                </div>
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
    z-index:999;
    overflow: visible !important;
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
.modal-backdrop{
    z-index:99;
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
.near-me-search div .form-group{
    margin-bottom:15px;
}
.loader-main{
    padding: 0px 15px;
}
#sticky {
    top: 0px !important;
}
#footer{display:none;}
.near-me-content{
    min-height:105vh;
    padding-top:10px;
}
.btn--primary.btn-border{
    border-radius:50px !important;
    margin-bottom: 10px;
}
.typeahead {
  background-color: #fff;
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
  margin: 0px 0;
  text-align:left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 0px 0px 6px 6px;
     -moz-border-radius: 0px 0px 6px 6px;
          border-radius: 0px 0px 6px 6px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
    padding: 4px 15px;
    font-size: 12px;
    line-height: 24px;
    color: #222;
    border-bottom: 1px solid #dddddda3;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
}
.Typeahead-spinner{
    position: absolute;
    color: #222;
    z-index: 999;
    right: 0;
    top: 10px;
    font-size: 25px;
    display: none;
}
.twitter-typeahead{
    float:left;
    width:100%;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    right: 20px;
    top:1px;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 35px 1px;
}
.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}
.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}
.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
@keyframes bounce{
  0%, 75%, 100%{
    -webkit-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
  }
  25%{
    -webkit-transform: translateY(-15px);
    -ms-transform: translateY(-15px);
    -o-transform: translateY(-15px);
    transform: translateY(-15px);
  }
}
/*Load Suggestions loader css ends */
body {
  scroll-behavior: smooth;
}
/*new card css*/
.application-card-description{
    margin:0 0 0 14px !important;
    width:100% !important;
}
.application-card-description h5{
    margin-top:0px !important;
    margin-bottom: 8px !important;
}
.application-card-main {
    background-color: transparent !important;
    margin-bottom: 20px !important;
    border-radius: 10px;
}
.mb-0{
    margin-bottom: 0px !important;
}
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
.app-box {
    text-align: left;
    padding: 10px;
    border-radius: 10px;
    position:relative;
    background:#fff;
    min-width: 330px;
}
.img{
    max-width: 66px;
}
.cover-box{
    display: inline-block;
    padding-left: 13px;
}
.comps-name-1{
    display: block;
    vertical-align: middle;
    padding-left: 12px;
    padding-top: 15px;
}
.org_name{display:block;}
.skill a{
    color: black;
    font-size: 18px;
    font-weight: bold;
}
.comp-name{
    font-weight: 700;
    font-size: 15px;
    color:#0173b2;
    margin:0;
    font-family:roboto;
}
.detail-loc{
    margin-top:5px;
}
.location{
    margin-right: 4px;
}
.fa-inr{
    color:lightgray;
    margin-right: 10px;

}
.city, .city i{
    color: #fff;
}
.show-responsive{
    display:none;
}

.job-fill{
    padding: 5px 10px 4px !important;
    margin: 3px !important;
    background-color:#ff7803 !important;
    color: #fff !important;
    border-radius: 0px 10px 0px 10px !important;
    float: right !important;
    position:absolute !important;
    right: 2px !important;
    top: -13px !important;
}

.clear{
    clear:both;
}

.sal{
    margin-right: 5px;
}

.salary{
    font-family:roboto;
}

.tag-box{
    border-top: 1px solid lightgray;
    padding-left:15px;
    padding-top:10px;
}

.tags{
    font-size: 17px;
    color:gray;
    font-family: Georgia !important;
}
.after{
    padding-right: 25px;
    padding-left: 16px;
}
.after{
    background: #eee;
    border-radius: 3px 0 0 3px;
    color: #777;
    display: inline-block;
    height: 26px;
    line-height: 25px;
    padding: 0 21px 0 11px;
    position: relative;
    margin: 0 9px 3px 0;
    text-decoration: none;
    -webkit-transition: color 0.2s;
}
.after::after{
    background: #fff;
    border-bottom: 13px solid transparent;
    border-left: 10px solid #eee;
    border-top: 13px solid transparent;
    content: "";
    position: absolute;
    right: 0;
    top: 0;
}
.city-box{
    padding-bottom:5px;
}
.ADD-more{
    background-color: #eeeeee;
    padding: 4px 10px 4px 10px;
    border-radius: 5px;
}
.img-main{
    display: inline-block;
}
.comps-name-1{
    float: none;
    margin: 0px !important;
}
.more-skills{
    background-color: #00a0e3;
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
}
@media only screen and (max-width: 360px){
    .comps-name-1 {display: block;vertical-align: middle; padding-left: 14px;}
}
@media only screen and (max-width: 768px){
    .comps-name-1 {display: block;vertical-align: middle; padding-left: 14px;}
}
@media only screen and (max-width: 974px){
    .salary{ 
        padding-left: 16px;
    }
    .city-box{padding-left: 18px; padding-bottom: 10px;}
    .hide-responsive{display:none;}
    .show-responsive{display:inline;}
    .hide-resp{display:none;}

}
');
$controller = Yii::$app->controller->id;
$script = <<< JS
$(window).animate({scrollTop:0}, '300');
$('body').css('overflow','hidden');
setTimeout(
    function(){
    $('body').css('overflow','inherit');
}, 2000);

//variables declaration
var empty = true;
var loading = false;
var loadmore = true;
var vals = {
    lat: null,
    long: null,
    num: 0,
    keyword: null,
    inprange: null 
};
var map;
var marker;
var  purple_icon = 'https://maps.google.com/mapfiles/ms/icons/purple-dot.png';
var infowindow = new google.maps.InfoWindow();

//takes location of user
if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback,showError);
}

//successful locatin permission
function successCallback(position){
    vals.lat = position.coords.latitude;
    vals.long = position.coords.longitude;
    vals.inprange = parseInt($('#range_3').prop("value") * 1000);
    geocodeLatLng(vals.lat,vals.long);
    showCards();
}

//error im location fetching
function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
        $.ajax({
          url:'/$controller/user-location',
          method:'POST',
          success: function (res) {
            var response = JSON.parse(res);
            if(response == null){
                $('#city_location').val('');
                $('#city_location').focus();
                $('.error').text('Please enter city');
                return false;
            }else if(response.name == null){
                $('#city_location').val('');
                $('#city_location').focus();
                $('.error').text('Please enter city');
                return false;
            }
            var city = response.name;
            var state = response.state_name;
            var address = city+','+state;
            $('#city_location').val(address);
            vals.inprange = parseInt($('#range_3').prop("value") * 1000);
            geocodeAddress(address);
          }  
        });
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
            $('#city_location').val(results[0].formatted_address);
        } else {
          toastr.error('No results found.', 'error'); 
        }
      }
    });
}



//initiates maps and cards
function showCards(){
    //local variables
    var i;
    var lat = vals.lat;
    var long = vals.long;
    var range = vals.inprange;
    
    //map setup
    map = new google.maps.Map(document.getElementById('map'),{
        center: {
            lat: lat, 
            lng: long
        },
        zoom: 4,
        mapTypeId: 'roadmap',
    });
    
    myCity = new google.maps.Circle({
        center: {
            lat: lat, 
            lng: long
        },
        radius: range,
        strokeColor: "#0000FF",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#0000FF",
        fillOpacity: 0.4
    });
              
    map.setCenter({lat: lat, lng: long});
    map.setZoom(9);
    myCity.setMap(map);
    
    //cards setup
    card();
}

//shows card
function card(){
    $.ajax({
            url: '/$controller/$action',
            type: 'post',
            data: vals,
            success: function (res) {
                $('#loadMore').addClass("loading_more");
                $('.loader-main').hide();
                $('.load-more-text').css('visibility', 'visible');
                $('.load-more-spinner').css('visibility', 'hidden');
                
                var response = JSON.parse(res);
                if(response.length == 0 && empty){
                    $('#loadMore').hide();
                    $('.near-me-map').css('display','none');
                    $('.near-me-content').removeClass('col-md-4');
                    $('.near-me-content').addClass('col-md-10');
                    $('.near-me-content').addClass('text-center');
                    if("$action" == 'near-me'){
                        $('#near-me-cards').html('<img src="/assets/themes/ey/images/pages/jobs/oops_404.png" class="not-found" alt="Not Found"/><h2>Currently there are no $type in selected Keyword or Location.</h2>');
                    } else{
                        $('#near-me-cards').html('<img src="/assets/themes/ey/images/pages/jobs/oops_404.png" class="not-found" alt="Not Found"/><h2>Currently there are no Walk In Interviews for today.</h2>');
                    }
                }else{
                    empty = false;
                    for(i=0;i<response.length;i++){
                            marker = new google.maps.Marker({
                            position: {lat: Number(response[i].latitude), lng: Number(response[i].longitude)},
                            map: map,
                            draggable: false
                        });                          
                        
                    }
                    for(var i=0; i<response.length; i++){
                        if(response[i].skill != null){
                            response[i].skill = response[i].skill.split(',')
                        } else {
                            response[i].skill = [];
                        }
                    }
                    var template = $('#cards').html();
                    var rendered = Mustache.render(template,response);
                    $('#near-me-cards').append(rendered);
                    utilities.initials();
                    vals.num += 20;
                    checkSkills();
                    
                    if(response.length < 20){
                        $('#loadMore').hide();
                        loadmore = false;
                    }
                }
            }
    }).done(function(){
            $.each($('.application-card-main'), function(){
                $(this).draggable({
                    helper: "clone",
                    drag: function() { 
                        $('#sticky').addClass('drag-on');
                        $('#review-internships').addClass('drop-on');
                        $('#header-main').css('z-index','1002');
                        $('.near-me-content').css('z-index','1001');
                     },
                     stop: function() { 
                        $('#sticky').removeClass('drag-on');
                        $('#review-internships').removeClass('drop-on');
                        $('#header-main').css('z-index','1000');
                        $('.near-me-content').css('z-index','0');
                     },
                });
            });
    });
         
    map.addListener('click', function(e) {
        infowindow.close();
    });
                      
    myCity.addListener('click', function(e) {
        infowindow.close();
    });
}

// load more click
// $(document).on('click','#loadMore',function(e) {
//     e.preventDefault();
//     $('.load-more-text').css('visibility', 'hidden');
//     $('.load-more-spinner').css('visibility', 'visible');
//     $('.loader-main').show();
//     card();
// });

//card click
$(document).on("click","#card-hover",function() {
     if (infowindow) {
        infowindow.close();
     }
    
     var types = $(this).find('.type').text();
     var salary = $(this).find('.salary').text();
     var lat = $(this).find('.location').attr('data-lat');
     var lon = $(this).find('.location').attr('data-long');
     var titles = $(this).find('.application-title').text();
     var locations =  $(this).find('.location').text();
     var last_date = $(this).find('.last-date').attr('id');
     var exp = $(this).find('.exp').text();
     var company =  $(this).find('.comp-name').text();
     var logo = $(this).find('.company_logo').attr('src');
     var logo_color = $(this).find('.company-logo').attr('color');
     var link = $(this).find('.application-card-open').attr('href');
     var org_link = $(this).find('#organization-slug').attr('href');
     var application_id = $(this).attr('data-id');
     var application_key = $(this).attr('data-key');
     var skills = $(this).find('.skills-main').html();
     var job_type = '$job_type';
     if(!logo){
        logo = '<canvas class="user-icon company-logo" name="'+$.trim(company)+'" width="80" height="80"color="'+logo_color+'" font="35px"></canvas>'
     }else{
        logo = '<img class="side-bar_logo" src="' + logo + '" height="40px">';
     }
     
     if(salary == 'Negotiable'){
         salary = '<h5 class="salary">'+salary+'</h5>';
     }else{
         salary = '<h5 class="salary"><i class="fas fa-rupee-sign"></i>&nbsp;'+salary+'</h5>';
     }
     // var contentString = '<div class="col-md-12 col-sm-12 col-xs-12 p-0"><div data-id="'+application_id+'" data-key="'+application_key+'" class="application-card-main in-map"><span class="application-card-type location"><i class="fas fa-map-marker-alt"></i>&nbsp;'+locations+'</span><div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom"><div class="application-card-img"><a href="/'+org_slug+'">'+logo+'</a></div><div class="application-card-description"><a href="/'+job_type+'/'+slug+'"><h4 class="application-title">'+titles+'</h4></a><h5><i class="fas fa-rupee-sign"></i>&nbsp;'+salary+'</h5><h5 class="type">'+types+'</h5><h5 class="exp"><i class="far fa-clock"></i>&nbsp;'+exp+'</h5></div></div><h4 class="col-md-12 org_name text-right pr-10 company-name">'+company+'</h4><div class="application-card-wrapper"><a href="/'+job_type+'/'+slug+'" class="application-card-open">View Detail</a><a href="#" class="application-card-add">&nbsp;<i class="fas fa-plus"></i>&nbsp;</a></div></div></div>';
     var contentString = '<div class="col-md-12 col-sm-12 col-xs-12 p-0"> <div data-id="'+application_id+'" data-key="'+application_key+'" class="application-card-main shadow mb-0"> <div class="app-box"> <div class="row"> <div class="col-md-3"> <div class="application-card-img img-main"> <a href="'+org_link+'" title="'+company+'">'+logo+'</a> </div></div><div class="col-md-9"> <div class="comps-name-1 application-card-description"> <span class="skill"> <a href="'+link+'" title="'+titles+'" class="application-title capitalize org_name">'+titles+'</a></span> <a href="'+org_link+'" style="text-decoration:none;"> <h4 class="org_name comp-name org_name">'+company+'</h4> </a> </div><span class="job-fill application-card-type location city" data-lat="'+lat+'" data-long="'+lon+'"> <i class="fas fa-map-marker-alt"></i>&nbsp;'+locations+'</span> <div class="detail-loc"> <div class="application-card-description job-loc">'+salary+'<h5>'+types+'</h5><h5><i class="far fa-clock"></i>&nbsp;'+exp+'</h5></div><div class="clear"></div></div></div></div><div class="row">'+skills+'</div><div class="application-card-wrapper"> <a href="'+link+'" class="application-card-open" title="View Detail">View Detail</a> <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i class="fas fa-plus"></i>&nbsp;</a> </div></div></div></div>';
     infowindow = new google.maps.InfoWindow({
      content: contentString
     });
     marker = new google.maps.Marker({
        position: new google.maps.LatLng(Number(lat),Number(lon)),
        map: map,
        draggable: false
     });
     infowindow.open(map, marker);
     // utilities.initials();
     setTimeout(
                        function(){
				            utilities.initials();
				    }, 100);
});

//search for,
$(document).on('click','#search_jobs',function(e) {
    
     e.preventDefault();
     searching();
     
 });

//search function
function searching() {
  vals.num = 0;
     var city = $('#city_location').val();
     vals.inprange = parseInt($('#range_3').prop("value") * 1000);
     vals.keyword = $('#job_keyword').val();
     
     if(!city){
           $('#city_location').focus();
           $('.error').text('Please enter city');
           return false;
     }
       
     $('#near-me-cards').html('');
     $('.near-me-map').css('display','block');
     $('.near-me-content').removeClass('col-md-10');
     $('.near-me-content').addClass('col-md-4');
     $('.loader-main').show();
     $('#loadMore').hide();
     $('#loadMore').show();
     loadmore = true;
     empty = true;
     
     geocodeAddress(city);
}

$('#city_location').on('keyup',function(e) {
  $('.error').text('');
  if(e.which == 13){
      searching();
  }
});

$('#job_keyword').on('keyup',function(e) {
  if(e.which == 13){
      searching();
  }
});

//display searched cards
function geocodeAddress(city) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({'address': city}, function(results, status) {
      if (status === 'OK') {
        vals.lat = results[0].geometry.location.lat();
        vals.long = results[0].geometry.location.lng();
        
        showCards();
      }else if(results.length == 0){
          toastr.error('please enter correct city', 'error');
      } 
    });
}
      
$("#range_3").ionRangeSlider({
    skin: "round",
    min: 1,
    max: 50,
    from: 50,
    grid: true,
    grid_num: 9,
    step: 1,
    force_edges: true,
    postfix: " km",
});

function getReviewList(sidebarpage){
    var type = '$type';
    $.ajax({
        method: "POST",
        url : "/reviewed-applications/review-list?sidebarpage="+sidebarpage,
        data:{type:type},
        success: function(response) {
            reviewlists(response);
            check_list();
            utilities.initials();
        }
    });
}

setTimeout(
    function(){
        loading = true;
    }, 900);

$(window).scroll(function() { //detact scroll
			if($(window).scrollTop() + $(window).height() >= $(document).height()){ //scrolled to bottom of the page
				
                if(loadmore && loading){
                    loading = false;
                    $('#loadMore').removeClass("loading_more");
                    $('.load-more-text').css('visibility', 'hidden');
                    $('.load-more-spinner').css('visibility', 'visible');
				    card();
				    setTimeout(
                        function(){
				            loading = true;
				    }, 500);
                }
			}
		});

$(document).on('click','.loading_more',function(e) {
    e.preventDefault();
    $('#loadMore').removeClass("loading_more");
    $('.load-more-text').css('visibility', 'hidden');
    $('.load-more-spinner').css('visibility', 'visible');
    card();
});

var global = [];
var city = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/cities/city-list?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(list) {
            global = list;
             return list;
        }
  }
});
       
$('#city_location').typeahead(null, {
  name: 'city_location',
  highlight: true,       
  display: 'text',
  source: city,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.city-spin').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.city-spin').hide();
  });



var sidebarpage = 1;
getReviewList(sidebarpage);
$(document).on('click','li.draggable-item .opens', function(){
    $('.near-me-filters').css('z-index','1000');
});
$(document).on('click','.jd-close', function(){
    $('.near-me-filters').css('z-index','999');
});
var ps = new PerfectScrollbar('.near-me-filters');

function checkSkills(){
    $('.application-card-main').each(function(){
       var elems = $(this).find('.after');
       var i = 0;
       $(elems).each(function() {
            if($(this).width() > 100 && $(this).text() != 'Multiple Skills' || i >= 2){
                $(this).addClass('hidden');
            }
            i++;
       });
       var skillsMain = $(this).find('.tags');
       var hddn = $(this).find('.after.hidden');
       var hasMore = $(this).find('span.more-skills');
       if(hddn.length != 0){
           if(elems.length === hddn.length){
               $(elems[0]).removeClass('hidden');
               var countMore = hddn.length - 1;
               if(countMore != 0 && hasMore.length == 0){
                   skillsMain.append('<span class="more-skills">+ ' + countMore + '</span>');
               }
           } else if(hasMore.length == 0) {
                skillsMain.append('<span class="more-skills">+ ' + hddn.length + '</span>');
           }
       }
    });
}
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-md.min.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css');
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js', ['depends' => [JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [JqueryAsset::className()]]);
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c"></script>