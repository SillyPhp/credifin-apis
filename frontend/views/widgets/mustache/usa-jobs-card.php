<script id="usa-jobs-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-12 col-xs-12 pt-5">
        <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
             class="application-card-main">
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fas fa-map-marker-alt"></i>
                &nbsp;{{PositionLocation}}
                </span>
            <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                <div class="application-card-img">
                    <a href="{{organization_link}}" title="{{DepartmentName}}">
                        {{#logo}}
                        <img src="{{logo}}" alt="{{organization_name}}" title="{{organization_name}}">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon" name="{{DepartmentName}}" width="80" height="80"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </a>
                </div>
                <div class="application-card-description">
                    <a href="{{link}}" title="{{PositionTitle}}"><h4 class="application-title">{{PositionTitle}}</h4></a>
                    <h5><i class="fas fa-dollar-sign"></i>{{MinimumRange}} - <i class="fas fa-dollar-sign"></i>{{MaximumRange}} {{Duration}}</h5>
                    <h5><i class="far fa-calendar-alt"></i>&nbsp;Last Date: {{ApplicationCloseDate}}</h5>
                    <h5><i class="fas fa-map-marker-alt"></i>{{Location}}</h5>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h4 class="org_name text-right">{{DepartmentName}}</h4>
            </div>
            <div class="application-card-wrapper">
                <a href="/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}" class="application-card-open" title="View Detail" target="_blank">View Detail</a>
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
  url:'/usa-jobs/get-keywords',
  method:'POST',
  data:{
      'Keyword':keywords
  },
  datatype:"jsonp",
    beforeSend: function(){
            $('.img_load').css('display','block');
        },
  success:function(body) {   
      $('.img_load').css('display','none');
      body = JSON.parse(body);
      template.html(''); 
      template.append(Mustache.render($('#usa-jobs-card').html(),body));
      utilities.initials();
  }   
  })
}
function fetchLocalData(template,min,max,loader,loader_btn) {
  $.ajax({
  url:'/usa-jobs/get-data',
  method:'Post',
  datatype:"jsonp",
  data:{
      'min':min,
      'max':max
  },
  beforeSend: function(){
      if (loader_btn)
          { 
              $('#loader').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
          }
      if (loader) {
            $('.img_load').css('display','block');
        }
      },
  success:function(body) {    
      $('.img_load').css('display','none');
      $('#loader').html('Load More');
      $('#loader').css('display','initial');
      body = JSON.parse(body);
      template.append(Mustache.render($('#usa-jobs-card').html(),body));
      utilities.initials();
  }   
  })
}
JS;
$this->registerCss("
.align_btn
{
text-align:center;
}
");
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
