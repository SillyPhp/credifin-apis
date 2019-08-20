<script id="usa-jobs-card" type="text/template">
    {{#.}}
 <div class="col-md-4 col-sm-12 col-xs-12 pt-5">
    <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
         class="application-card-main">
        {{#city}}
        <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
              data-locations="">
                <i class="fas fa-map-marker-alt"></i>&nbsp;{{city}}
                </span>
        {{/city}}
        {{^city}}
        <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
              data-locations="">
                <i class="fas fa-map-marker-alt"></i>&nbsp;All India
                </span>
        {{/city}}
        <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
            <div class="application-card-img">
                <a href="{{organization_link}}" title="{{organization_name}}">
                    {{#logo}}
                    <img src="{{logo}}" alt="{{organization_name}}" title="{{organization_name}}">
                    {{/logo}}
                    {{^logo}}
                    <canvas class="user-icon" name="{{organization_name}}" width="80" height="80"
                            color="{{color}}" font="35px"></canvas>
                    {{/logo}}
                </a>
            </div>
            <div class="application-card-description">
                <a href="{{link}}" title="{{title}}"><h4 class="application-title">{{MatchedObjectDescriptor.PositionTitle}}</h4></a>
                {{#salary}}
                <h5><i class="fas fa-rupee-sign"></i>&nbsp;{{salary}}</h5>
                {{/salary}}
                {{^salary}}
                <h5>Negotiable</h5>
                {{/salary}}
                {{#type}}
                <h5>{{type}}</h5>
                {{/type}}
                {{#experience}}
                <h5><i class="far fa-clock"></i>&nbsp;{{experience}}</h5>
                {{/experience}}
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h4 class="org_name text-right">{{organization_name}}</h4>
        </div>
        <div class="application-card-wrapper">
            <a href="{{link}}" class="application-card-open" title="View Detail">View Detail</a>
            <a href="#" class="application-card-add" title="Add to Review List">&nbsp;<i class="fas fa-plus"></i>&nbsp;</a>
        </div>
    </div>
</div>
 {{/.}}
</script>
<?php
$script = <<< JS
function fetch_usa_cards(host,userAgent,authKey,template)
{
  $.ajax({
  url:'https://data.usajobs.gov/api/search',
  method:'GET',
  data:{
      'JobCategoryCode':2210
  },
  headers: {          
        //"Host": host,          
        //"User-Agent": userAgent,          
        "Authorization-Key": authKey      
    },
  success:function(body) {
      template.append(Mustache.render($('#usa-jobs-card').html(),body.SearchResult.SearchResultItems));
  }   
  })
}
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
