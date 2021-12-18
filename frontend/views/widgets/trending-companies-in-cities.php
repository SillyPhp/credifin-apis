<?php

use yii\helpers\Url;

?>
    <script id="org-cards" type="text/template">
        <div class="top-cities">
            {{#.}}
            <a href="/{{slug}}">
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
    padding: 2px;
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
    border-radius: 50%;
}
');
$script = <<< JS
    $.getJSON('https://ipapi.co/json', function(data){
            $('#trendingCityName').text(data.city);
            if(!data.city){
                $('#trending-companies-by-location').html('Trending Companies');
            }
            getLocationData(data.city);
        });
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
              $('#trendingCompaniesSectionMain').remove();
          }
      }   
     });
     }
JS;
$this->registerJs($script);
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c"></script>
