<script id="usa-jobs-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-12 col-xs-12 pt-5">
        <div data-id="{{application_id}}" data-key="{{application_id}}-{{location_id}}"
             class="application-card-main">
            <span class="application-card-type location" data-lat="{{latitude}}" data-long="{{longitude}}"
                  data-locations="">
                <i class="fas fa-map-marker-alt"></i>
                &nbsp;{{Location}}
                </span>
            <div class="col-md-12 col-sm-12 col-xs-12 application-card-border-bottom">
                <div class="application-card-img">
                    <a href="/govt-jobs/detail/{{id}}" title="{{Organizations}}">
                        {{#logo}}
                        <img src="{{logo}}" alt="{{Organizations}}" title="{{Organizations}}">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon" name="{{Organizations}}" width="80" height="80"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </a>
                </div>
                <div class="application-card-description">
                    <a href="/govt-jobs/detail/{{id}}" title="{{Position}}"><h4 class="application-title">{{Position}}</h4></a>
                    {{#Last_date}}
                    <h5><i class="far fa-calendar-alt"></i>&nbsp;Last_date: {{Last_date}}</h5>
                    {{/Last_date}}
                    {{#Eligibility}}
                    <h5><i class="fas fa-map-marker-alt"></i>{{Eligibility}}</h5>
                    {{/Eligibility}}
                    <h5><i class="fas fa-map-marker-alt"></i>{{Location}}</h5>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h4 class="org_name text-right">{{Organizations}}</h4>
            </div>
            <div class="application-card-wrapper">
                <a href="/govt-jobs/detail/{{id}}" class="application-card-open" title="View Detail" target="_blank">View Detail</a>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<?php
$script = <<< JS
function fetchLocalData(template,limit,offset,loader,loader_btn,keyword=null,replace=false) {
  $.ajax({
  url:'/govt-jobs/get-data',
  method:'Post',
  datatype:"jsonp",
  data:{
      'limit':limit,
      'offset':offset,
      'keywords':keyword
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
      if (replace)
          {
              template.html(Mustache.render($('#usa-jobs-card').html(),body));
          }
      template.append(Mustache.render($('#usa-jobs-card').html(),body));
      utilities.initials();
      if(body == ''){
          $('#loader').hide();
          template.append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
      }
  }   
  })
}
var match = 0;
function fetchDeptData(template,limit,offset,dept_id,loader,loader_btn,keyword=null,replace=false) {
  $.ajax({
  url:'/govt-jobs/department-vise-jobs',
  method:'Post',
  datatype:"jsonp",
  data:{
      'limit':limit,
      'offset':offset,
      'keywords':keyword,
      'dept_id':dept_id,
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
      match = match+limit;
      if (body.count<12||match==body.count) 
          {
              $('#loader').hide();
          }
      template.append(Mustache.render($('#usa-jobs-card').html(),body.cards));
      utilities.initials();
      if(body == ''){
          $('#loader').hide();
          template.append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
      }
  }   
  })
}
JS;
$this->registerCss("
.align_btn
{
text-align:center;
clear:both;
}
.application-card-type
{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 250px;
}
");
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
