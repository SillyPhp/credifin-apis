<script id="usa-jobs-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-12 col-xs-12 pt-5">
        <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
             class="application-card-main">
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fas fa-map-marker-alt"></i>&nbsp;USA
                </span>
            <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                <div class="application-card-img">
                    <a href="{{organization_link}}" title="{{MatchedObjectDescriptor.DepartmentName}}">
                        {{#logo}}
                        <img src="{{logo}}" alt="{{organization_name}}" title="{{organization_name}}">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon" name="{{MatchedObjectDescriptor.DepartmentName}}" width="80" height="80"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </a>
                </div>
                <div class="application-card-description">
                    <a href="{{link}}" title="{{MatchedObjectDescriptor.PositionTitle}}"><h4 class="application-title">{{MatchedObjectDescriptor.PositionTitle}}</h4></a>
                    <h5><i class="far fa-calendar-alt"></i>&nbsp;Start Date: {{MatchedObjectDescriptor.PositionStartDate}}</h5>
                    <h5><i class="far fa-calendar-alt"></i>&nbsp;End Date: {{MatchedObjectDescriptor.PositionEndDate}}</h5>
                    <h5><i class="fas fa-map-marker-alt"></i>{{#MatchedObjectDescriptor.PositionLocation}}{{LocationName}}{{/MatchedObjectDescriptor.PositionLocation}}</h5>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h4 class="org_name text-right">{{MatchedObjectDescriptor.DepartmentName}}</h4>
            </div>
            <div class="application-card-wrapper">
                <a href="{{link}}" class="application-card-open" title="View Detail">View Detail</a>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<?php
$script = <<< JS
function fetch_usa_cards(host,userAgent,authKey,template,keywords)
{
  $.ajax({
  url:'https://data.usajobs.gov/api/search',
  method:'GET',
  data:{
      'Keyword':keywords 
  },
  headers: {          
        //"Host": host,          
        //"User-Agent": userAgent,          
        "Authorization-Key": authKey      
    },
    beforeSend: function(){
            $('.img_load').css('display','block');
        },
  success:function(body) {   
      $('.img_load').css('display','none');
      localStorage.setItem('jobStorage', JSON.stringify(body));
      var obj = JSON.parse(localStorage.getItem('jobStorage'));
      template.html('');
      template.append(Mustache.render($('#usa-jobs-card').html(),body.SearchResult.SearchResultItems));
      utilities.initials();
  }   
  })
}
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
