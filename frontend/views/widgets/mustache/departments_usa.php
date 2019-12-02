<?php
use yii\helpers\Url;
?>
<script id="departments-card" type="text/template">
    {{#.}}
<div class="col-md-3 col-sm-6">
             <div class="agency-box">
                    <div class="agency-logo">
                        {{#logo}}
                        <img src="{{logo}}" alt="{{Value}}" title="{{Value}}">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon" name="{{Value}}" width="80" height="80"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </div>
                    <div class="agency-name">{{Value}}</div>
                    <div class="agency-count">
                        <a href="#">{{total_applications}} Jobs</a>
                    </div>
             </div>
</div>
    {{/.}}
</script>
<?php
$script = <<< JS
function fetchDepartments(template,limit) {
  $.ajax({
  url:'/usa-jobs/get-departments',
  method:'Post',
  datatype:"json",
  data:{
      'limit':limit,
  },
  beforeSend: function(){
     
      },
  success:function(response) {
      console.log(response);
      if(response.status === 200) {
          template.append(Mustache.render($('#departments-card').html(),response.cards));
          utilities.initials();
      }
  }   
  })
}
JS;

$this->registerJs($script);
?>