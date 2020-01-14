<?php

use yii\helpers\Url;

?>
    <script id="departments-card" type="text/template">
        {{#.}}
        <div class="col-md-3 col-sm-6">
            <div class="agency-box">
                <a href="/govt-jobs/{{slug}}" title="{{Value}}">
                    <div class="agency-logo">
                        {{#logo}}
                        <img src="{{logo}}" alt="{{Value}}" title="{{Value}}">
                        {{/logo}}
                        {{^logo}}
                        <canvas class="user-icon" name="{{Value}}" width="100" height="100"
                                color="{{color}}" font="35px"></canvas>
                        {{/logo}}
                    </div>
                    <div class="agency-name">
                        <span href="/govt-jobs/{{slug}}">{{Value}}</span>
                    </div>
                    <div class="agency-count">
                        <span href="#">{{total_applications}} Jobs</span>
                    </div>
                </a>
            </div>
        </div>
        {{/.}}
    </script>
<?php
$script = <<< JS
var match_dept = 0;
function fetchDepartments(template,limit_dept,offset,loader,loader_btn) {
  $.ajax({
  url:'/govt-jobs/get-departments',
  method:'Post',
  datatype:"json",
  data:{
      'limit':limit_dept,
      'offset':offset,
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
       match_dept = match_dept+body.count;
      if (body.total<12||body.total==match_dept) 
          {
              $('#loader').hide();
          }
          template.append(Mustache.render($('#departments-card').html(),body.cards));
          utilities.initials();
          if(body == ''){
          $('#loader').hide();
          template.append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
      }
  }   
  })
}
JS;
$this->registerCss('
.align_btn
{
text-align:center;
clear:both;
}
body{
    background: url(\'/assets/themes/ey/images/backgrounds/p6.png\');
}
.agency-box {
    border: 1px solid #fff;
    box-shadow: 0px 0px 8px 0px #eee;
    margin-bottom: 20px;
    background:#fff;
    border-radius: 2px;
}
.agency-box:hover {
    box-shadow: 0px 0px 20px 5px #eee !important;
    transition: .3s ease-in-out;
}
.agency-logo {
    width: 100px;
    margin: 0 auto; 
    margin-top: 20px;
    height: 100px;
    line-height: 100px;
    text-align: center;
}
.agency-logo img {
    width: auto;
    height: auto;
    max-height:100px;
    max-width:100px;
}
.agency-name {
    text-align: center;
    padding: 25px 18px 0px 18px;
    font-size: 16px;
    font-weight: 500;
    font-family: roboto;
    position: relative;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height:78px;
    margin-bottom: 8px;
}
.agency-count {
    text-align: center;
    padding: 8px 0px 8px 0px;
    background-color:#00a0e3;
}
.agency-count span {
    font-family: roboto;
    color: #fff;
    padding: 4px 6px;
    font-size: 14px;
    border-radius: 4px;
    margin: 0px 4px;
    font-weight: 500;
    transition: all ease-out .3s;
}
.button-set{
    text-align:center;
    padding:0px 0px 20px 0px;
}
');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script);
?>