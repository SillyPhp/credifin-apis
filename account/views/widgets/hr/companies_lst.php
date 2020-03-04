<?php
use yii\helpers\Url;
?>
<script id="cmp_lst" type="text/template">
    {{#.}}
<div class="col-md-4 col-sm-6">
   <div class="topic-con">
     <div class="hr-company-box">
       <a href="/account/hr/company-dashboard">
        <div class="hr-com-icon">
            {{#logo}}
            <img src="{{logo}}" class="img-responsive ">
            {{/logo}}
            {{^logo}}
            <canvas class="user-icon" name="{{name}}" width="80" height="80"
                    color="{{initials_color}}" font="35px"></canvas>
            {{/logo}}
        </div>
        <div class="hr-com-name">
        {{name}}
        </div>
        <div class="hr-com-field">
        {{business_activity}}
        </div>
        <div class="overlay">
        <div class="text-o">View Dashboard</div>
        </div>
        </a>
        <div class="openings">{{total_applications}} Applications</div>
<!--        <div class="jobcount">7 jobs, 3 Internships</div>-->
        <div class="j-grid"><a href="/{{slug}}" title="">View Profile</a>
        </div>
        </div>
        </div>
</div>
    {{/.}}
</script>
<?php
$script = <<<JS
function fetch_companies_list(template=null,limit=6,offset=0,id=null) {
  $.ajax({
  url:'http://www.sneh.eygb.me/api/v3/companies/list-companies', 
  method:'Post',  
  datatype:"jsonp",
  data:{
      'limit':limit, 
      'offset':offset,
      'id':id,
  },
  beforeSend: function(){
       
      },
  success:function(body) {
      template.append(Mustache.render($('#cmp_lst').html(),body.response));
      utilities.initials();
      if(body.response == ''){
          template.html('No Companies Has been Created Yet');
      }
  }   
  })
}
JS;
$this->registerJs($script);
?>