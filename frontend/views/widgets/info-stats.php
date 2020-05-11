<div id="stats_cards"></div>
<script id="stats-card" type="text/template">
    <div class="box-parent row">
        <div class="bolls">
            <div class="boll1 bol2"></div>
            <div class="boll2 bol2"></div>
            <div class="boll3 bol"></div>
            <div class="boll4 bol"></div>
            <div class="boll5 bol2"></div>
            <div class="boll6 bol2"></div>
        </div>
        {{#jobs}}
        <div class="col-md-3 col-sm-6">
            <div class="jobs-content">
                <div class="j-count">{{jobs}}+</div>
                <div class="j-name">Jobs</div>
            </div>
        </div>
        {{/jobs}}

        {{#internships}}
        <div class="col-md-3 col-sm-6">
            <div class="jobs-content">
                <div class="j-count">{{internships}}+</div>
                <div class="j-name">Internships</div>
            </div>
        </div>
        {{/internships}}

        {{#titles}}
        <div class="col-md-3 col-sm-6">
            <div class="jobs-content">
                <div class="j-count">{{titles}}+</div>
                <div class="j-name">Profiles</div>
            </div>
        </div>
        {{/titles}}

        <div class="col-md-3 col-sm-6">
            <div class="jobs-content">
                <div class="j-count">{{location}}+</div>
                <div class="j-name">Locations</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="jobs-content">
                <div class="j-count">{{companies}}+</div>
                <div class="j-name">Companies</div>
            </div>
        </div>
    </div>
</script>
<?php
$this->registerCss('
.box-parent {
    background:#00a0e3;
    border-radius: 8px;
    padding: 90px 50px;
    overflow:hidden;
    margin: 20px;
}
.jobs-content {
    text-align: left;
    border-left: 4px solid #79c5e6;
    padding-left: 20px;
}
.j-count{
    font-size:40px;
    color:#fff;
    font-weight: 700;
    font-family: roboto;
}
.j-name{
    font-size:25px;
    color:#fff;
    font-weight: 300;
    font-family: roboto;
}
@media (max-width:768px){
    .box-parent{padding:20px 50px !important;}
    .jobs-content{margin-bottom:10px;}
}
.bolls{position:relative;}
.bol{
    position: absolute;
    width: 85px;
    height: 85px;
    background: #79c5e62e;
    border-radius: 50%;
}
.bol2{
    position: absolute;
    width: 125px;
    height: 125px;
    background: #79c5e62e;
    border-radius: 50%;
}
.boll1 {
    top: -100px;
    left: -56px;
}
.boll2 {
    left: 171px;
    top: 164px;
}
.boll3 {
    left: 371px;
    top: -25px;
}
.boll4 {
    right: 1px;
    top: 76px;
}
.boll5 {
    right: 195px;
    top: 18px;
}
.boll6 {
    right: -69px;
    bottom: 12px;
}
@media (max-width:415px){
.boll5 {
    right: 159px;
    top: 305px;
}
.boll6 {
    left: 205px;
    top: 415px;
}
}
');
$script = <<< JS
function fetchStats(template) {
  $.ajax({
  url:'/jobs/get-stats',
  method:'Post',
  datatype:"json",
  success:function(response) {
      if(response.status === 200) {
          template.html(Mustache.render($('#stats-card').html(),response.cards));
      }
  }   
  })
}
fetchStats(template = $('#stats_cards'));
JS;
$this->registerJs($script);