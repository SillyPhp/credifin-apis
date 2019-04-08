<?php

$this->title = Yii::t('frontend', 'Jobs Near Me');
$this->params['header_dark'] = true;

use yii\helpers\Url;
?>

<div class="row">

    <div class="col-md-2 col-sm-3">
        <?=
        $this->render('/widgets/sidebar-review', [
            'type' => 'jobs',
        ]);
        ?>
    </div>

    <div class="col-md-10 col-sm-9 set-map-container">
        <script id="marker-content-template" type="text/x-handlebars-template"></script>
        <div class="my-large-container mb-20">
                <div class="row">
                    <div class="col-md-12 mb-20">
                        <div class="overlay-map">
                            <div class="map-canvas">
                            </div>
                        </div>
                        <br/>
                        <div>
                            <nav class="navbar-search" data-spy="affix" data-offset-top="679">
                                <div class="col-md-12 search-box-border-shadow">
                                    <form id="form1">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group form-md-line-input form-md-floating-label">
                                                    <?php
                                                    if(Yii::$app->request->get('keyword')){
                                                        ?>
                                                        <input type="text" name="keyword" class="form-control" autocomplete="off" id="form_control_3"  value="<?=Yii::$app->request->get('keyword')?>">
                                                    <?php }else{ ?>
                                                        <input type="text" name="keyword" class="form-control" autocomplete="off" id="form_control_3" placeholder="Job Title or Keywords">
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group form-md-line-input form-md-floating-label">
                                                    <?php
                                                    if(Yii::$app->request->get('company')){
                                                        ?>
                                                        <input type="text" name="company" class="form-control" id="form_control_1"  value="<?=Yii::$app->request->get('company')?>">
                                                    <?php }else{ ?>
                                                        <input type="text" name="company" class="form-control" id="form_control_1"  placeholder="Company">
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group form-md-line-input form-md-floating-label">
                                                    <?php
                                                    if(Yii::$app->request->get('location')){
                                                        ?>
                                                        <input type="text" name="location" class="form-control" id="form_control_2" value="<?=Yii::$app->request->get('location')?>">
                                                    <?php }else{ ?>
                                                        <input type="text" name="location" class="form-control" id="form_control_2" placeholder="Location">
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="range-slider mt-10">
                                                    <div class="p-bar-main">
                                                        <?php
                                                        if(Yii::$app->request->get('distance')){
                                                            ?>
                                                            <input type="range" class="range-slider__range" name="distance" min="0" max="50"  value="<?=Yii::$app->request->get('distance')?>" onchange="document.querySelector('.range-slider__value').innerHTML = this.value;">
                                                        <?php }else{ ?>
                                                            <input type="range" name="distance" class="range-slider__range" value="0" min="0" max="50" onchange="document.querySelector('.range-slider__value').innerHTML = this.value;">
                                                        <?php }?>
                                                        <span class="range-slider__value">0</span>
                                                        <span class="p-bar"></span>
                                                    </div>
                                                    <h5>Set distance between search location.</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-right pt-10">
                                                <svg version="1.1" class="svg-filters">
                                                    <defs>
                                                        <filter id="filter-goo-2">
                                                            <feGaussianBlur in="SourceGraphic" stdDeviation="7" result="blur" />
                                                            <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
                                                            <feComposite in="SourceGraphic" in2="goo" />
                                                        </filter>
                                                    </defs>
                                                </svg>
                                                <button type="submit" form="form1" id="component-2" class="button button--2" style="filter: url('#filter-goo-2')">
                                                    Search
                                                    <span class="button__bg"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>


            <div class="row">
                <div class="border-top-set col-md-12">
                    <div id="cardBlock" class="row work-load blogbox"></div>
                    <div class="row loader-main" style="display: none;">
                        <div class="col-md-4">
                            <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load pl-20 pr-20 ">
                                    <div class="loader anim"></div>
                                </span>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4 pt-5" >
                                        <a href="#" class="icon set_logo">
                                            <div class="loader anim"></div>
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-xs-8 pt-20">
                                        <h4 class="icon-box-title">
                                            <strong><div class="loader anim"></div></strong>
                                        </h4>
                                        <h5>
                                            <i class="locations"><div class="loader anim"></div></i>
                                        </h5>
                                        <h5>
                                            <i class="periods"><div class="loader anim"></div></i>
                                        </h5>
                                    </div>
                                </div>
                                <hr class="hr">
                                <div class="col-md-6">
                                    <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                        <br>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="pull-right pt-20 custom_set" align="center">
                                        <strong>
                                            <div class="loader anim"></div>
                                        </strong>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load pl-20 pr-20 ">
                                    <div class="loader anim"></div>
                                </span>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4 pt-5" >
                                        <a href="#" class="icon set_logo">
                                            <div class="loader anim"></div>
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-xs-8 pt-20">
                                        <h4 class="icon-box-title">
                                            <strong><div class="loader anim"></div></strong>
                                        </h4>
                                        <h5>
                                            <i class="locations"><div class="loader anim"></div></i>
                                        </h5>
                                        <h5>
                                            <i class="periods"><div class="loader anim"></div></i>
                                        </h5>
                                    </div>
                                </div>
                                <hr class="hr">
                                <div class="col-md-6">
                                    <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                        <br>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="pull-right pt-20 custom_set" align="center">
                                        <strong>
                                            <div class="loader anim"></div>
                                        </strong>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-load pl-20 pr-20 ">
                                    <div class="loader anim"></div>
                                </span>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4 pt-5" >
                                        <a href="#" class="icon set_logo">
                                            <div class="loader anim"></div>
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-xs-8 pt-20">
                                        <h4 class="icon-box-title">
                                            <strong><div class="loader anim"></div></strong>
                                        </h4>
                                        <h5>
                                            <i class="locations"><div class="loader anim"></div></i>
                                        </h5>
                                        <h5>
                                            <i class="periods"><div class="loader anim"></div></i>
                                        </h5>
                                    </div>
                                </div>
                                <hr class="hr">
                                <div class="col-md-6">
                                    <h6 class="pull-left custom_set2" align="center"><strong><div class="loader anim"></div></strong>
                                        <br>
                                        <div class="last-date">
                                            <div class="loader anim"></div>
                                        </div>
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="pull-right pt-20 custom_set" align="center">
                                        <strong>
                                            <div class="loader anim"></div>
                                        </strong>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-div" align="center">
                        <a href="#" id="loadMore" class="btn btn-primary loadmorebtn" align="center"style="color:white">
                            <h4>Load More
                                <i class="fa fa-angle-down">
                                </i>
                            </h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
*:focus{
    outline:none;
}    
.loadmorebtn{
    padding:5px 20px !important;
}    
.search-box-border-shadow{
    border: 1px solid transparent;
    box-shadow: 0px 4px 9px 0px #EEE;
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 8px;
}
.side-menu{
    z-index:9;
}
.form-group.form-md-line-input{margin-bottom:0px !important;}
.search-box-border-shadow form{
    padding: 0px 20px 0px 20px;
    margin-bottom:0px;
}
.search-box-header{
    background-color: #55c6d3;
    padding: 2px 30px;
    border-radius: 8px 8px 0px 0px;
}
.search-box-header h3{
    color:#fff;
    margin: 8px 0px;
}
.overlay-map{
    width:100%;
    height:640px;
}
.shadow{
    box-shadow: 0 1px 3px 0px #797979;
}
.set_logo{
//    display: table-cell;
    vertical-align: middle;
    height: 73px !important;
}
.product *:not(i) {
    font-family: Georgia !important;
}
.product {
    padding: 0px 10px 10px 10px;
    margin-bottom: 10px !important;
    margin-top: 0px !important;
}
.color-o {
    background: #FF4500 !important;
}
.hr {
    margin-bottom: 0px !important;
    margin-top: 0px !important;
}
.custom_set {
    margin-bottom: 0px !important;
    margin-top: 0px !important;
}
.custom_set2 {
    margin-bottom: 0px !important;
}
.map-canvas {
    height: 100%;
}
.map-canvas div:first-child{z-index:999;}
.my-large-container{
    max-width: 1500px !important;
//    padding-left: 15px;
//    padding-right: 15px;
    margin:auto;
}
//.set-map-container{
//    padding-left:100px;
//}
.button--2{
    -webkit-font-smoothing: antialiased;
    background-color: #222;
    border: none;
    display: inline-block;
    font-family: "Montserrat", sans-serif;
    font-size: 0.85em;
    font-weight: 700;
    text-decoration: none;
    user-select: none;
    letter-spacing: 0.1em;
    color: white;
    padding: 20px 40px;
    text-transform: uppercase;
    -webkit-transition: background-color 0.1s ease-out;
    -moz-transition: background-color 0.1s ease-out;
    transition: background-color 0.1s ease-out;
}
.button--2:hover{
    background-color: #2CD892;
    color: #fff;
}
.button--2:focus{
    outline: none;
    color: #fff;
}
.safari .button, .safari
.button__bg {
    -webkit-filter: none !important;
    filter: none !important;
}
.button--2 .button__bg {
    content: "";
    position: absolute;
}
.button__bg {
    transform: translateZ(0);
    outline: 90px solid transparent !important;
    background: #00a0e3;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
    -webkit-transition: background 0.1s ease-out;
    -moz-transition: background 0.1s ease-out;
    transition: background 0.1s ease-out;
    /*border-radius: 40px;*/
}
.button--2 {
    outline: 90px solid transparent !important;
    position: relative;
    z-index: 0;
    background-color: transparent;
}
.button--2 .left, .button--2 .right {
    position: absolute;
    width: 25px;
    height: 25px;
    border-radius: 15px;
    background: #00a0e3;
    -webkit-transition: background 0.1s ease-out;
    -moz-transition: background 0.1s ease-out;
    transition: background 0.1s ease-out;
    top: 50%;
    margin-top: -12px;
    z-index: -2;
}
.button--2 .left.left, .button--2 .right.left {
    left: 0;
}
.button--2 .left.right, .button--2 .right.right {
    right: 0;
}
.button--2:hover {
    background-color: transparent;
}
.button--2:hover:before, .button--2:hover span {
    background-color: #ff7803;
}
.svg-filters {
    position: absolute;
    visibility: hidden;
    width: 1px;
    height: 1px;
}
.si-content {
    overflow: visible;
}
.custom-close {
    position: absolute;
    top: 0;
    right: -36px;
    width: 36px;
    height: 36px;
    -webkit-transition: background-color 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    transition: background-color 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    border: 0;
    background-color: rgba(68, 67, 62, 0.8);
    color: #fff;
    font-size: 1.5em;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
    cursor: pointer;
}
.si-content-wrapper {
    padding: 0px;
    overflow: visible;
}
.set_logo img{
    width: 96px;
    height: 73px;
}
.company {
    height: auto;
    width: auto;
}
.si-content .product{
    margin-bottom: 0px !important;
}
.range-slider {
  width: 100%;
}
.range-slider__range {
  -webkit-appearance: none;
//  width: calc(100% - (73px)) !important;
  width:100% !important;
  height: 10px;
  border-radius: 5px;
  background: #d7dcdf;
  outline: none;
  padding: 0;
  margin: 0;
  display: initial !important;
}
.range-slider__range::-webkit-slider-thumb {
  -webkit-appearance: none;
          appearance: none;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background: #00a0e3;
  cursor: pointer;
  transition: background .15s ease-in-out;
}
.range-slider__range::-webkit-slider-thumb:hover {
  background: #ff7803;
}
.range-slider__range:active::-webkit-slider-thumb {
  background: #00a0e3;
}
.range-slider__range::-moz-range-thumb {
  width: 20px;
  height: 20px;
  border: 0;
  border-radius: 50%;
  background: #2c3e50;
  cursor: pointer;
  transition: background .15s ease-in-out;
}
.range-slider__range::-moz-range-thumb:hover {
  background: #00a0e3;
}
.range-slider__range:active::-moz-range-thumb {
  background: #00a0e3;
}
.range-slider__range:focus::-webkit-slider-thumb {
  box-shadow: 0 0 0 3px #fff, 0 0 0 6px #00a0e3;
}

.range-slider__value {
  display: inline-block;
//  position: relative;
  position: absolute;
  width: 60px;
  color: #fff;
  line-height: 20px;
  text-align: center;
  border-radius: 3px;
  background: #00a0e3;
  padding: 5px 10px;
  margin-left: 8px;
  top: 0;
  right: -72px;
}
.range-slider__value:after {
  position: absolute;
  top: 8px;
  left: -7px;
  width: 0;
  height: 0;
  border-top: 7px solid transparent;
  border-right: 7px solid #00a0e3;
  border-bottom: 7px solid transparent;
  content: "";
}
::-moz-range-track {
  background: transparent;
  border: 0;
}


input::-moz-focus-inner,
input::-moz-focus-outer {
  border: 0;
}
.p-bar-main{
    position:relative;
    width:80%;
}
#loadMore {
    text-align: center;
    background-color: #202c45;
    color: #fff !important;
    border-width: 0 0px 0px 0;
    border-radius: 12px;
    border-style: solid;
    border-color: #fff;
    box-shadow: 0 6px 10px #868686 !important;
    transition: all 600ms ease-in-out;
    -webkit-transition: all 600ms ease-in-out;
    -moz-transition: all 600ms ease-in-out;
    -o-transition: all 600ms ease-in-out;
}
#loadMore:hover {
    background-color: #f08340;
    color: #fff;
}
#loadMore h4{
    color:#fff !important;
}
.btn-div{
    margin-top: 20px;
    padding-top: 20px;
    margin-bottom: 20px;
}
.product .tag-load .anim{
  max-width:30%;
  float:right;
}
.set_logo .anim{
  max-width:96px;
  height:73px;
  margin-left:10px;
}
.icon-box-title strong .anim{
  max-width:100%;
  height:15px;
}
.locations .anim{
  max-width:60%;
}
.periods .anim{
  max-width:40%;
}
.custom_set2 strong .anim{
  max-width:80%;
  margin:auto;
}
.last-date .anim{
  max-width:60%;
  margin:auto;
}
.custom_set strong .anim{
  max-width:80%;
  height:18px;
  float:right;
}
.loader {
    display: block;
    position:relative;
    width: 160px;
    height: 10px;
    background-color: #ECEFF1;
    border-radius: 4px;
}
.anim {
    animation-duration: 1s;
    animation-fill-mode: forwards;
    animation-iteration-count: infinite;
    animation-name: placeHolderAnim;
    animation-timing-function: linear;
    background: #f6f7f8;
    background: linear-gradient(to right, #ECEFF1 8%, #DBE2E5 18%, #ECEFF1 33%);
    background-size: 40rem 1rem;
    position: relative;
}
@keyframes placeHolderAnim {
    0% { background-position: -12rem 0; }
    100% { background-position: 12rem 0; }
}
.affix {
    top: 51px;
    -moz-top:52px;
    width: 84.6%;
    z-index: 999 !important;
}
@-moz-document url-prefix() {
   .affix{
       top: 52px;
   }
}
@media screen and (min-device-width: 991px) and (max-device-width: 1160px) {
    .set-map-container{
        padding-left:40px;
    }
}
@media only screen and (max-width: 991px) {
    .affix{
        position:relative;
        width:100%;
        top:0px;
    }
}
');
$script = <<< JS
//     let types='', newLat='', lat=0, lon=0, titles='', locations='', lastDates='', periods=0, companys='', logos='';
//  
//     $(function() {
//             var mapStyle = [{'featureType': 'all', 'elementType': 'geometry.fill', 'stylers': [{'weight': '2.00'}]}, {'featureType': 'all', 'elementType': 'geometry.stroke', 'stylers': [{'color': '#9c9c9c'}]}, {'featureType': 'all', 'elementType': 'labels.text', 'stylers': [{'visibility': 'on'}]}, {'featureType': 'landscape', 'elementType': 'all', 'stylers': [{'color': '#f2f2f2'}]}, {'featureType': 'landscape', 'elementType': 'geometry.fill', 'stylers': [{'color': '#ffffff'}]}, {'featureType': 'landscape.man_made', 'elementType': 'geometry.fill', 'stylers': [{'color': '#ffffff'}]}, {'featureType': 'poi', 'elementType': 'all', 'stylers': [{'visibility': 'off'}]}, {'featureType': 'road', 'elementType': 'all', 'stylers': [{'saturation': -100}, {'lightness': 45}]}, {'featureType': 'road', 'elementType': 'geometry.fill', 'stylers': [{'color': '#eeeeee'}]}, {'featureType': 'road', 'elementType': 'labels.text.fill', 'stylers': [{'color': '#7b7b7b'}]}, {'featureType': 'road', 'elementType': 'labels.text.stroke', 'stylers': [{'color': '#ffffff'}]}, {'featureType': 'road.highway', 'elementType': 'all', 'stylers': [{'visibility': 'simplified'}]}, {'featureType': 'road.arterial', 'elementType': 'labels.icon', 'stylers': [{'visibility': 'off'}]}, {'featureType': 'transit', 'elementType': 'all', 'stylers': [{'visibility': 'off'}]}, {'featureType': 'water', 'elementType': 'all', 'stylers': [{'color': '#46bcec'}, {'visibility': 'on'}]}, {'featureType': 'water', 'elementType': 'geometry.fill', 'stylers': [{'color': '#c8d7d4'}]}, {'featureType': 'water', 'elementType': 'labels.text.fill', 'stylers': [{'color': '#070707'}]}, {'featureType': 'water', 'elementType': 'labels.text.stroke', 'stylers': [{'color': '#ffffff'}]}];
//            
//             $(document).on("click",".opens", function () {
//                 types = $(this).find('#set-types').attr('type');
// //                lat = $(this).find('#set-types').attr('lat');
// //                lon = $(this).find('#set-types').attr('long');
// //                lat = [28.489000, 22.719568, 30.888472];
// //                lon = [77.089996, 75.857727, 75.930984];
//                 lat = 28.489000;
//                 lon = 77.089996;
//                 titles = $(this).find('#set-types').attr('title');
//                 locations =  $(this).find('#set-types').attr('location');
//                 lastDates = $(this).find('#set-types').attr('lastdate');
//                 periods = $(this).find('#set-types').attr('period');
//                 companys =  $(this).find('#set-types').attr('company');
//                 logos = $(this).find('#set-types').attr('logo');
//             });
//
//             var myLatLng = new google.maps.LatLng(lat=30.900430, lon=75.826821);
//             // Create the map
//             var map = new google.maps.Map($('.map-canvas')[0], {
//                 zoom: 14,
//                 styles: mapStyle,
//                 center: myLatLng
//             });
//        
//             // Add a custom marker
//             var markerIcon = {
//                 path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
//                 fillColor: '#e25a00',
//                 fillOpacity: 0.95,
//                 scale: 3,
//                 strokeColor: '#fff',
//                 strokeWeight: 3,
//                 anchor: new google.maps.Point(12, 24)
//             };
//             var marker = new google.maps.Marker({
//                 map: map,
//                 icon: markerIcon,
//                 position: myLatLng
//             });
//
//             // Set up handle bars
//             var template = Handlebars.compile($('#marker-content-template').html());
//
//             // Set up a close delay for CSS animations
//             var info = null;
//             var closeDelayed = false;
//             var closeDelayHandler = function() {
//                 $(info.getWrapper()).removeClass('active');
//                 setTimeout(function() {
//                     closeDelayed = true;
//                     info.close();
//                 }, 300);
//             };
//
//             // Add a Snazzy Info Window to the marker
//             info = new SnazzyInfoWindow({
//                 marker: marker,
//                 wrapperClass: 'custom-window',
//                 offset: {
//                     top: '-72px'
//                 },
//                 edgeOffset: {
//                     top: 50,
//                     right: 60,
//                     bottom: 50
//                 },
//                 border: false,
//                 closeButtonMarkup: '<button type="button" class="custom-close">&#215;</button>',
//                 callbacks: {
//                     beforeOpen: function() {
//                         this.setContent(setMarketContent());
//                     },
//                     open: function() {
//                         $(this.getWrapper()).addClass('open');
//                     },
//                     afterOpen: function() {
//                         var wrapper = $(this.getWrapper());
//                         wrapper.addClass('active');
//                         wrapper.find('.custom-close').on('click', closeDelayHandler);
//                     },
//                     beforeClose: function() {
//                         if (!closeDelayed) {
//                             closeDelayHandler();
//                             return false;
//                         }
//                         return true;
//                     },
//                     afterClose: function() {
//                         var wrapper = $(this.getWrapper());
//                         wrapper.find('.custom-close').off();
//                         wrapper.removeClass('open');
//                         closeDelayed = false;
//                         marker.setVisible(false);
//                     }
//                 }
//             });
//             marker.setVisible(false);
//             // Open the Snazzy Info Window
//        
//             $(document).on("click", '.opens' , function(){
//                 changeMarkerPosition(marker);
//                 marker.setVisible(true);
//                 info.open();
//                
//             });
//            
//             function changeMarkerPosition(marker) {
//                 var latlng = new google.maps.LatLng(lat, lon);
//                 marker.setPosition(latlng);
//                 map.setCenter(latlng);
//             }
//
//             function setMarketContent() {
//                 return '<div style="width:400px;" class="product shadow iconbox-border iconbox-theme-colored"><span class="type tag-sale color-o pl-20 pr-20 ">'+types+'</span><div class="row"><div class="col-md-4 col-xs-4 pt-5" ><a href="#" class="icon set_logo"><img class="logo" src="'+logos+'"></a></div><div class="col-md-8 col-xs-8 pt-20"><h4 class="title icon-box-title"><strong>'+titles+'</strong></h4><h5><i class="location fa fa-map-marker" lat="'+lat+'" long="'+lon+'"> '+locations+'</i></h5><h5><i class="period fa fa-clock-o"> '+periods+'</i></h5></div><div class="btn-add-to-cart-wrapper"><a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS</a><a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#"><i class="fa fa-plus"></i></a></div></div><hr class="hr"><h6 class="pull-left pl-20 custom_set2" align="center"><strong>Last Date to Apply</strong><br><div class="lastDate">'+lastDates+'</div></h6><h4 class="company pull-right pr-10 pt-20 custom_set" align="center"><strong>'+companys+'</strong></h4></div>';
//             }
//             info.close();
//         });
//
// var pagenum = 1;
//        
// $(document).ready(function () {
//     $.ajax({
//         method: "GET",
//         url : "/jobs/jobs-near-me?pagenum="+pagenum,
//         beforeSend: function(){
//             $('.loader-main').show();
//         },
//         success: function(response) {
//             $('.loader-main').hide();
//             if(response.status == 200) {
//                 jobcards(response);
//        
//             } else {
//                 $('#loadMore').hide();
//             }
//         }
//     }).done(function(){
//         $.each($('.application-card-main'), function(){
//             $(this).draggable({
//                 helper: "clone",
//             });
//         });
//     });
// });
//        
// function jobcards(response){
//     if(response.status == 200){    
//                 var card = $('#application-card').html();
//                 $(".blogbox").append("<div class='row'>" + Mustache.render(card, response.jobcards) + "</div>");
//     }else{
//         console.log("not work");
//     }
// }        
//        
//         $('#loadMore').on('click', function(e){
//             e.preventDefault();
//             pagenum+=1;
//             $.ajax({
//                 method: "GET",
//                 url : "/jobs/jobs-near-me?pagenum="+pagenum,
//                 beforeSend: function(){
//                    $('.loader-main').show();
//                 },
//                 success: function(response) {
//                     $('.loader-main').hide();
//                     if(response.status == 200) {
//                         jobcards(response);
//                     } else {
//                         $('#loadMore').hide();
//                     }
//                 }
//             }).done(function(){
//                 $.each($('.application-card-main'), function(){
//                     $(this).draggable({
//                         helper: "clone",
//                     });
//                 });
//             });
//         });        
//
// function getRandom(min, max){
//   return Math.random() * (max - min) + min;
// }
//
// var isSafari = /constructor/i.test(window.HTMLElement);
// var isFF = !!navigator.userAgent.match(/firefox/i);
//
// if (isSafari) {
//   document.getElementsByTagName('html')[0].classList.add('safari');
// }
//
// initBt2();        
//
// function initBt2() {
//   var bt = document.querySelectorAll('#component-2')[0];
//   var filter = document.querySelectorAll('#filter-goo-2 feGaussianBlur')[0];
//   var particleCount = 12;
//   var colors = ['#DE8AA0', '#8AAEDE', '#FFB300', '#60C7DA']
//
//   bt.addEventListener('click', function() {
//     var particles = [];
//     var tl = new TimelineLite({onUpdate: function() {
//       filter.setAttribute('x', 0);
//     }});
//    
//     tl.to(bt.querySelectorAll('.button__bg'), 0.6, { scaleX: 1.05 });
//     tl.to(bt.querySelectorAll('.button__bg'), 0.9, { scale: 1, ease: Elastic.easeOut.config(1.2, 0.4) }, 0.6);
//
//     for (var i = 0; i < particleCount; i++) {
//       particles.push(document.createElement('span'));
//       bt.appendChild(particles[i]);
//
//       particles[i].classList.add(i % 2 ? 'left' : 'right');
//      
//       var dir = i % 2 ? '-' : '+';
//       var r = i % 2 ? getRandom(-1, 1)*i/2 : getRandom(-1, 1)*i;
//       var size = i < 2 ? 1 : getRandom(0.4, 0.8);
//       var tl = new TimelineLite({ onComplete: function(i) {
//         particles[i].parentNode.removeChild(particles[i]);
//         this.kill();
//       }, onCompleteParams: [i] });
//
//       tl.set(particles[i], { scale: size });
//       tl.to(particles[i], 0.6, { x: dir + 20, scaleX: 3, ease: SlowMo.ease.config(0.1, 0.7, false) });
//       tl.to(particles[i], 0.1, { scale: size, x: dir +'=25' }, '-=0.1');
//       if(i >= 2) tl.set(particles[i], { backgroundColor: colors[Math.round(getRandom(0, 3))] });
//       tl.to(particles[i], 0.6, { x: dir + getRandom(60, 100), y: r*10, scale: 0.1, ease: Power3.easeOut });
//       tl.to(particles[i], 0.2, { opacity: 0, ease: Power3.easeOut }, '-=0.2');
//     }
//   });
// }
//        
// var rangeSlider = function(){
//   var slider = $('.range-slider'),
//       range = $('.range-slider__range'),
//       value = $('.range-slider__value');
//    
//   slider.each(function(){
//
//     value.each(function(){
//       var value = $(this).prev().attr('value');
//       $(this).html(value + ' KM');
//     });
//
//     range.on('input', function(){
//       $(this).next(value).html(this.value + ' KM');
//       $(this).css('background','linear-gradient(90deg, #00a0e3 ' + this.value*2 + '%, #d7dcdf 0%)');
//     });
//   });
// };
//
// rangeSlider();
//        
// var city = new Bloodhound({
//   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
//   queryTokenizer: Bloodhound.tokenizers.whitespace,
//   prefetch: '',
//   remote: {
//     url:'/cities/city-list?q=%QUERY',  
//     wildcard: '%QUERY',
//     filter: function(list) {
//              return list;
//         }
//   }
// });    
//            
// $('#form_control_3').typeahead(null, {
//   name: 'cities',
//   highlight: true,       
//   display: 'text',
//   source: city,
//    limit: 15,
//    hint:false,
// }).on('typeahead:asyncrequest', function() {
//     $('.Typeahead-spinner').show();
//   }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
//    
//     $('.Typeahead-spinner').hide();
//   });
//
// $(document).on('submit','form', function(e) {
//     e.preventDefault();
//     console.log("submitted!!");
//     var form = $("form");
//         var params = form.serialize();
//         console.log("params :", params);
// });

var page = 1;
$(document).on('click', '#component-2', function(e){
    
        e.preventDefault();

        var keywords = document.querySelector('#form_control_3').value;
        var company = document.querySelector('#form_control_1').value;
        var location = document.querySelector('#form_control_2').value;
        var distance = document.querySelector('.range-slider__value').innerHTML;
    
        insertUrlParam('keywords', keywords);
        insertUrlParam('company', company);
        insertUrlParam('location', location);
        insertUrlParam('distance', distance);
    
        getJobs();
});

function insertUrlParam(key, value) {
    if (history.pushState) {
        let searchParams = new URLSearchParams(window.location.search);
        searchParams.set(key, value);
        let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + searchParams.toString();
        window.history.pushState({path: newurl}, '', newurl);
    }
}

var areThereQueryParams = window.location.search.replace("?", '');
if(areThereQueryParams){
    getJobs();
}

function getJobs(type = "Jobs", p = 1){
    var data = {};
    var params = (new URL(document.location)).searchParams;
    data['keywords'] = params.get("keywords");
    data['company'] = params.get("company");
    data['location'] = params.get("location");
    data['distance'] = params.get("distance");
    data['page'] = p;
    data['type'] = type;
    
    console.log(data);
    
    $.ajax({
        method: 'POST', 
        url : window.location.pathname,
        data : data,
        success : function(response){
                console.log(response);
        }
    })
}

$('#loadMore').on('click', function(e){
    e.preventDefault();
    page += 1;
    getJobs("Jobs", page);
});
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-rounded.min.css');
//$this->registerCssFile('@backendAssets/global/plugins/ion.rangeslider/css/ion.rangeSlider.css');
//$this->registerCssFile('@backendAssets/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css');
$this->registerCssFile('@eyAssets/css/jobs-map/snazzy-info-window.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@backendAssets/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@backendAssets/pages/scripts/components-ion-sliders.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/snazzy-info-window.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jobs-near-me/TweenMax.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//echo $this->render('/widgets/application-card', [
//    'type' => 'mustache',
//]);
?>
<!---->
<!--<script id="application-card" type="text/template">-->
<!--    {{#.}}-->
<!--    <div class="col-md-4 pt-5">-->
<!--        <div data-key="{{id}}" class="application-card-main">-->
<!--            {{#salary}}-->
<!--            <span class="application-card-type"><i class="fa fa-inr"></i>{{salary}}</span>-->
<!--            {{/salary}}-->
<!--            {{^salary}}-->
<!--            <span class="application-card-type">{{type}}</span>-->
<!--            {{/salary}}-->
<!--            <div class="col-md-12 application-card-border-bottom">-->
<!--                <div class="application-card-img">-->
<!--                    {{#logo}}-->
<!--                    <a href="/company/{{company_link}}"><img src="{{logo}}"></a>-->
<!--                    {{/logo}}-->
<!--                    {{^logo}}-->
<!--                    <canvas class="user-icon" name="{{organization_name}}" width="80" height="80" font="35px"></canvas>-->
<!--                    {{/logo}}-->
<!--                </div>-->
<!--                <div class="application-card-description">-->
<!--                    <h4 class="application-title" >{{title}}</h4>-->
<!--                    <h5 class="location" data-lat="{{latitude}}" data-long="{{longitude}}" data-locations="" ><i class="fa fa-map-marker"></i>&nbsp;{{applicationPlacementLocations.0.name}}</h5>-->
<!--                    <h5> <i class="fa fa-clock-o"></i>&nbsp;{{experience}}</h5>-->
<!--                </div>-->
<!--            </div>-->
<!--            {{#last_date}}-->
<!--            <h6 class="pull-left pl-20 custom_set2" align="center">-->
<!--                <strong>Last Date to Apply</strong>-->
<!--                <br>-->
<!--                {{last_date}}-->
<!--            </h6>-->
<!--            <h4 class="pull-right pr-10 pt-20 custom_set" align="center">-->
<!--                <strong>{{org_name}}</strong>-->
<!--            </h4>-->
<!--            {{/last_date}}-->
<!--            {{^last_date}}-->
<!--            <div class="col-md-12 text-right">-->
<!--                <h4 class="org_name" >{{organization_name}}</h4>-->
<!--            </div>-->
<!--            {{/last_date}}-->
<!--            <div class="application-card-wrapper">-->
<!--                <a href="/job/{{link}}" class="application-card-open">View Detail</a>-->
<!--                <a href="#" class="application-card-add">&nbsp;<i class="fa fa-plus"></i>&nbsp;</a>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    {{/.}}-->
<!--</script>-->