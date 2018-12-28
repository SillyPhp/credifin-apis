<?php
$this->title = Yii::t('frontend', 'Jobs Near Me');
$this->params['header_dark'] = true;

use yii\helpers\Url;
?>
<?php
foreach ($cards as $card) {
    $lat_long .= "'" . $card['latitude'] . ',' . $card['longitude'] . "',";
}
?>
<div class="col-md-1">
    <?=
    $this->render('/widgets/sidebar-review', [
        'type' => 'jobs',
    ]);
    ?>
</div>
<div class="col-md-11 set-map-container">
    <script id="marker-content-template" type="text/x-handlebars-template"></script>
    <div class="my-large-container mb-20">
        <div class="row">
            <div class="col-md-12 mb-20">
                    <div id="map">
                    </div>

                <br/>
                <div>
                    <nav class="" data-spy="affix" data-offset-top="679">
                        <div class="col-md-12 search-box-border-shadow">
                            <form>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <input type="text" class="form-control" id="form_control_3"/>
                                            <label for="form_control_3">City</label>
                                            <!--<span class="help-block">Some help goes here...</span>-->
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <input type="text" class="form-control" id="form_control_1"/>
                                            <label for="form_control_1">Location</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-md-line-input form-md-floating-label">
                                            <input type="text" class="form-control" id="form_control_2"/>
                                            <label for="form_control_2">Job Title</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="range-slider mt-10">
                                            <input class="range-slider__range" type="range" id = "mapper" value="2" min="0" max="50">
                                            <span class="range-slider__value">0</span>
                                            <h5>Set distance between search location in km.</h5>
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
                                        <button id="component-2" class="button button--2" style="filter: url('#filter-goo-2')">
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

        <?php
        $total_cards = count($cards);
        $rows = ceil($total_cards / 3);
        $next = 0;
        for ($i = 1; $i <= $rows; $i++) {
            ?> 
            <div class="row work-load blogbox">
                <?php
                for ($j = 0; $j < 3; $j++) {
                    if ($next < $total_cards) {
                        ?> 
                        <div class="col-md-4 pt-5">
                            <div class="product shadow iconbox-border iconbox-theme-colored">
                                <span class="tag-sale color-o pl-20 pr-20 "><?php echo $cards[$next]['type']; ?>
                                </span>
                                <div class="row">
                                    <div class="col-md-4 col-xs-4 pt-5" >
                                        <a href="#" class="icon set_logo">
                                            <?php
                                            $logo = $cards[$next]['logo'];
                                            $logo_location = $cards[$next]['logo_location'];
                                            $logo_image = Yii::$app->params->upload_directories->organizations->logo . $logo_location . DIRECTORY_SEPARATOR . $logo;
                                            $logo_base_path = Yii::$app->params->upload_directories->organizations->logo_path . $logo_location . DIRECTORY_SEPARATOR . $logo;

                                            if (!file_exists($logo_base_path)) {
                                                $logo_image = "http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=No+Logo";
                                            }
                                            ?>
                                            <img src="<?= Url::to($logo_image); ?>">
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-xs-8 pt-20">
                                        <h4 class="icon-box-title"> 
                                            <strong><?php echo $cards[$next]['title']; ?> 
                                            </strong>
                                        </h4>
                                        <h5 class="location" lats="<?= $cards[$next]['latitude'] ?>" longs="<?= $cards[$next]['longitude'] ?>"> 
                                            <i class="fa fa-location-arrow"></i> 
                                            <strong>Ludhiana, Jalandhar
                                            </strong>

                                        </h5>
                                        <h5>
                                            <i class="fa fa-map-pin"> 
                                                Min <?php echo $cards[$next]['experience']; ?> yr exp
                                            </i>
                                        </h5>
                                    </div>
                                    <div class="btn-add-to-cart-wrapper" data-key="<?= $cards[$next]['application_enc_id'] ?>" >
                                        <a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/job/<?php echo $cards[$next]['slug']; ?>">VIEW DETAILS
                                        </a>
                                        <a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#">
                                            <i class="fa fa-plus">
                                            </i>
                                        </a>
                                    </div>
                                </div>
                                <hr class="hr">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                        <h4 class="pull-right pr-10 pt-10 custom_set" align="right">
                                            <p><strong><?php echo $cards[$next]['org_name']; ?></strong>
                                            </p>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    $next++;
                }
                ?>
            </div>
            <?php
        }
        ?>
        <div class="btn-div" align="center">
            <a href="#" id="loadMore" class="btn btn-primary" align="center"style="color:white">
                <h4>Load More 
                    <i class="fa fa-angle-down">
                    </i>
                </h4>
            </a>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.search-box-border-shadow{
    border: 1px solid transparent;
    box-shadow: 0px 4px 9px 0px #EEE;
    margin-bottom: 20px;
    background-color: #fff;
    border-radius: 8px;
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
#map{
    width:100%;
    height:640px;
}
.shadow{
    box-shadow: 0 1px 3px 0px #797979;
}
.set_logo{
    display: table-cell;
    vertical-align: middle;
    height: 125px;
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
.set-map-container{
    padding-left:100px;
}
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
    background: #2c3e50;
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
    background: #222;
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
    background-color: #2CD892;
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
  width: calc(100% - (73px)) !important;
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
  background: #2c3e50;
  cursor: pointer;
  transition: background .15s ease-in-out;
}
.range-slider__range::-webkit-slider-thumb:hover {
  background: #1abc9c;
}
.range-slider__range:active::-webkit-slider-thumb {
  background: #1abc9c;
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
  background: #1abc9c;
}
.range-slider__range:active::-moz-range-thumb {
  background: #1abc9c;
}
.range-slider__range:focus::-webkit-slider-thumb {
  box-shadow: 0 0 0 3px #fff, 0 0 0 6px #1abc9c;
}

.range-slider__value {
  display: inline-block;
  position: relative;
  width: 60px;
  color: #fff;
  line-height: 20px;
  text-align: center;
  border-radius: 3px;
  background: #2c3e50;
  padding: 5px 10px;
  margin-left: 8px;
}
.range-slider__value:after {
  position: absolute;
  top: 8px;
  left: -7px;
  width: 0;
  height: 0;
  border-top: 7px solid transparent;
  border-right: 7px solid #2c3e50;
  border-bottom: 7px solid transparent;
  content: "";
}

::-moz-range-track {
  background: #d7dcdf;
  border: 0;
}

input::-moz-focus-inner,
input::-moz-focus-outer {
  border: 0;
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
');
$script = <<< JS
        
var types, lat, lon, titles, locations, lastDates, periods, companys, logos;
var data = [$lat_long];
var map;
var marker;
var  purple_icon = 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png';
var infowindow = null;

function showCards(){
    var i;
    var inprange = {
        rangerval : 10
    };
    var centre = {lat: 30.900965, lng: 75.857277};
    map = new google.maps.Map(document.getElementById('map'),{
        center: centre,
        zoom: 4,
        mapTypeId: 'roadmap'
    });
    for(i=0;i<data.length;i++){
        console.log(data[i]);
        var res = data[i].split(",");
        console.log(res);
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(Number(res[0]),Number(res[1])),
            map: map,
            icon: purple_icon,
            draggable: true
        });
    }
    $(document).on("click",".opens",function() {
        if (infowindow) {
            infowindow.close();
        }
        types = $(this).find('#set-types').attr('type');
        lat = $(this).find('#set-types').attr('lat');
        lon = $(this).find('#set-types').attr('long');
        titles = $(this).find('#set-types').attr('title');
        locations =  $(this).find('#set-types').attr('location');
        lastDates = $(this).find('#set-types').attr('lastdate');
        periods = $(this).find('#set-types').attr('period');
        companys =  $(this).find('#set-types').attr('company');
        logos = $(this).find('#set-types').attr('logo');
         var contentString = '<div style="width:400px;" class="product shadow iconbox-border iconbox-theme-colored"><span class="type tag-sale color-o pl-20 pr-20 ">'+types+'</span><div class="row"><div class="col-md-4 col-xs-4 pt-5" ><a href="#" class="icon set_logo"><img class="logo" src="'+logos+'"></a></div><div class="col-md-8 col-xs-8 pt-20"><h4 class="title icon-box-title"><strong>'+titles+'</strong></h4><h5><i class="location fa fa-map-marker" lat="'+lat+'" long="'+lon+'"> '+locations+'</i></h5><h5><i class="period fa fa-clock-o"> '+periods+'</i></h5></div><div class="btn-add-to-cart-wrapper"><a class="btn btn-theme-colored btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color" href="/internships/detail">VIEW DETAILS</a><a style="background-color:#FF4500" class="btn btn-sm btn-flat pl-20 pr-20 btn-add-to-cart text-uppercase font-weight-700 custom_color2" href="#"><i class="fa fa-plus"></i></a></div></div><hr class="hr"><h6 class="pull-left pl-20 custom_set2" align="center"><strong>Last Date to Apply</strong><br><div class="lastDate">'+lastDates+'</div></h6><h4 class="company pull-right pr-10 pt-20 custom_set" align="center"><strong>'+companys+'</strong></h4></div>';    
         infowindow = new google.maps.InfoWindow({
          content: contentString
        });
         marker = new google.maps.Marker({
            position: new google.maps.LatLng(Number(lat),Number(lon)),
            map: map,
            icon: purple_icon,
            draggable: true
        });
         var position = new google.maps.LatLng(Number(lat),Number(lon));
         map.setCenter(position);
         map.setZoom(16);
         infowindow.open(map, marker);
    });
    
    $("#mapper").on("input change", function() {
        inprange.rangerval = $(this).val();
        console.log(inprange.rangerval);
    });
    var myCity = null;
    $(document).on('click', ".button__bg", function(){
        
        if(myCity){
            myCity.setMap(null);
        }
        var geocoder = new google.maps.Geocoder();
        var city = $('#form_control_3').val();
        var location = $('#form_control_1').val();
        var address = city + " " + location;
        console.log(address);
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            
            console.log(inprange.rangerval);
              myCity = new google.maps.Circle({
                center: results[0].geometry.location,
                radius: inprange.rangerval * 1000,
                strokeColor: "#0000FF",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#0000FF",
                fillOpacity: 0.4
              });
              var position = results[0].geometry.location;
              map.setCenter(position);
              console.log(position);
              map.setZoom(12);
              
              myCity.setMap(map);
          } else {
            alert("Location does not exist.");
          }
        });
    });
    
}
        


function initMap(){
    
    showCards();
}
        
function getRandom(min, max){
  return Math.random() * (max - min) + min;
}

var isSafari = /constructor/i.test(window.HTMLElement);
var isFF = !!navigator.userAgent.match(/firefox/i);

if (isSafari) {
  document.getElementsByTagName('html')[0].classList.add('safari');
}

// Remove click on button for demo purpose
Array.prototype.slice.call(document.querySelectorAll('.button'), 0).forEach(function(bt) {
  bt.addEventListener('click', function(e) {
    e.preventDefault();
  });
});

// Button 2
initBt2();        

function initBt2() {
  var bt = document.querySelectorAll('#component-2')[0];
  var filter = document.querySelectorAll('#filter-goo-2 feGaussianBlur')[0];
  var particleCount = 12;
  var colors = ['#DE8AA0', '#8AAEDE', '#FFB300', '#60C7DA']

  bt.addEventListener('click', function() {
    var particles = [];
    var tl = new TimelineLite({onUpdate: function() {
      filter.setAttribute('x', 0);
    }});
    
    tl.to(bt.querySelectorAll('.button__bg'), 0.6, { scaleX: 1.05 });
    tl.to(bt.querySelectorAll('.button__bg'), 0.9, { scale: 1, ease: Elastic.easeOut.config(1.2, 0.4) }, 0.6);

    for (var i = 0; i < particleCount; i++) {
      particles.push(document.createElement('span'));
      bt.appendChild(particles[i]);

      particles[i].classList.add(i % 2 ? 'left' : 'right');
      
      var dir = i % 2 ? '-' : '+';
      var r = i % 2 ? getRandom(-1, 1)*i/2 : getRandom(-1, 1)*i;
      var size = i < 2 ? 1 : getRandom(0.4, 0.8);
      var tl = new TimelineLite({ onComplete: function(i) {
        particles[i].parentNode.removeChild(particles[i]);
        this.kill();
      }, onCompleteParams: [i] });

      tl.set(particles[i], { scale: size });
      tl.to(particles[i], 0.6, { x: dir + 20, scaleX: 3, ease: SlowMo.ease.config(0.1, 0.7, false) });
      tl.to(particles[i], 0.1, { scale: size, x: dir +'=25' }, '-=0.1');
      if(i >= 2) tl.set(particles[i], { backgroundColor: colors[Math.round(getRandom(0, 3))] });
      tl.to(particles[i], 0.6, { x: dir + getRandom(60, 100), y: r*10, scale: 0.1, ease: Power3.easeOut });
      tl.to(particles[i], 0.2, { opacity: 0, ease: Power3.easeOut }, '-=0.2');
    }
  });
}
        
        
var rangeSlider = function(){
  var slider = $('.range-slider'),
      range = $('.range-slider__range'),
      value = $('.range-slider__value');
    
  slider.each(function(){

    value.each(function(){
      var value = $(this).prev().attr('value');
      $(this).html(value);
    });

    range.on('input', function(){
      $(this).next(value).html(this.value);
    });
  });
};

rangeSlider();
        
$(document).ready(function () {
    $(".work-load").slice(0, 3).show();
    if ($(".blogbox:hidden").length != 0) {
        $("#loadMore").show();
    }
    $("#loadMore").on('click', function (e) {
        e.preventDefault();
        $('.loader-main').slideDown();
        setTimeout(function() { $(".loader-main").hide(); 
            $(".work-load:hidden").slice(0, 1).fadeIn();
        if ($(".work-load:hidden").length == 0) {
            $(".btn-div").fadeOut('slow');
        }
        }, 2000);
    });
});
        
//google.maps.event.addDomListener(window, 'load', initMap);
       initMap();

JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/components-rounded.min.css');
//$this->registerCssFile('@backendAssets/global/plugins/ion.rangeslider/css/ion.rangeSlider.css');
//$this->registerCssFile('@backendAssets/global/plugins/ion.rangeslider/css/ion.rangeSlider.skinFlat.css');
//$this->registerCssFile('@eyAssets/css/jobs-map/snazzy-info-window.min.css');
$this->registerJsFile('@backendAssets/global/scripts/app.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@backendAssets/global/plugins/ion.rangeslider/js/ion.rangeSlider.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@backendAssets/pages/scripts/components-ion-sliders.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c&callback=initMap', ['depends' => [\yii\web\JqueryAsset::className()], 'async' => 'async', 'defer' => 'defer']);
//$this->registerJsFile('@eyAssets/js/snazzy-info-window.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jobs-near-me/TweenMax.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery-ui.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
?>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c"></script>