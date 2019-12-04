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
                    <canvas class="user-icon" name="{{Value}}" width="100" height="100"
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
function fetchDepartments(template,limit,offset) {
  $.ajax({
  url:'/govt-jobs/get-departments',
  method:'Post',
  datatype:"json",
  data:{
      'limit':limit,
      'offset':offset,
  },
  beforeSend: function(){
     
      },
  success:function(response) {
      if(response.status === 200) {
          template.append(Mustache.render($('#departments-card').html(),response.cards));
          utilities.initials();
      }
  }   
  })
}
JS;
$this->registerCss('
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
.agency-box:hover .agency-count a {
    color:#fff;
    background-color:#00a0e3;
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
}
.agency-count {
    text-align: center;
    padding: 5px 0px 10px 0px;
}
.agency-count a {
    font-family: roboto;
    color: #bdbdbd;
    padding: 4px 6px;
    font-size: 14px;
    border-radius: 4px;
    margin: 0px 4px;
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