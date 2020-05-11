<script id="govt-jobs-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="application-card-main shadow">
            <div class="app-box">
                <div class="row">
                    <div class="application-card-img">
                        <a href="/govt-jobs/{{company_slug}}" target="_blank" title="{{Organizations}}">
                            {{#logo}}
                            <img src="{{logo}}" alt="{{Organizations}}" title="{{Organizations}}">
                            {{/logo}}
                            {{^logo}}
                            <canvas class="user-icon" name="{{Organizations}}" width="80" height="80"
                                    color="{{color}}" font="35px"></canvas>
                            {{/logo}}
                        </a>
                    </div>
                    <div class="comps-name-1 application-card-description">
                            <span class="skill">
                                <a href="/govt-jobs/detail/{{slug}}"  target="_blank" title="{{Position}}" class="application-title capitalize org_name">
                                    {{Position}}
                                </a>
                            </span>
                        <a href="/govt-jobs/detail/{{slug}}" target="_blank" title="{{Organizations}}" style="text-decoration:none;">
                            <h4 class="org_name comp-name org_name">{{Organizations}}</h4>
                        </a>
                    </div>
                    <span class="job-fill application-card-type location city">
                             <i class="fas fa-map-marker-alt"></i>&nbsp;{{Location}}
                    </span>
                    <div class="detail-loc application-card-description">
                        <div class="job-loc">
                            {{#salary}}
                            <h5 class="salary">{{salary}}</h5>
                            {{/salary}}
                            {{^salary}}
                            <h5 class="salary"><a href="/govt-jobs/detail/{{slug}}" target="_blank"><i class="fas fa-rupee-sign"></i> View In Details</a></h5>
                            {{/salary}}
                            {{#Last_date}}
                            <h5 class="last_date"><i class="far fa-calendar-alt"></i> Last_date: {{Last_date}}</h5>
                            {{/Last_date}}
                            {{#Eligibility}}
                            <h5><i class="fas fa-graduation-cap"></i>: {{Eligibility}}</h5>
                            {{/Eligibility}}
                            {{^Eligibility}}
                            <h5><i class="fas fa-graduation-cap"></i>: View In Details</h5>
                            {{/Eligibility}}
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="application-card-wrapper">
                    <a href="/govt-jobs/detail/{{slug}}" class="application-card-open" title="View Detail">View Detail</a>
                </div>
            </div>
        </div>
    </div>
    {{/.}}
</script>
<?php
$script = <<< JS
var match_local = 0;
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
              $('#loadMore').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
          }
      if (loader) {
            $('.loader-main').css('display','block');
        }
      },
  success:function(body) {
      $('#loadMore').html('Load More');
      $('#loadMore').css('display','block');
      $('.loader-main').hide();
      match_local = match_local+body.count;
      if (body.total<12||body.total==match_local) 
          {
              $('#loadMore').hide();
          }
      if (replace){
          template.html(Mustache.render($('#govt-jobs-card').html(),body.cards));
      }else
          {
              template.append(Mustache.render($('#govt-jobs-card').html(),body.cards));
          }
      utilities.initials();
      if(body == ''){
          $('#loadMore').hide();
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
      match = match+body.count;
      if (body.total<12||body.total==match) 
          {
              $('#loader').hide();
          }
      template.append(Mustache.render($('#govt-jobs-card').html(),body.cards));
      utilities.initials();
      if(body.total == 0){
          $('#loader').hide();
          template.append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
      }
  }   
  })
}
JS;
$this->registerCss("
/*cards-box css*/
.salary a
{
color:#3d80d4;
}
.last_date
{
font-weight:normal !important;
}
.application-card-description h5{
    margin-top:0px !important;
    margin-bottom: 8px !important;
}
.application-card-main {
    background-color: transparent !important;
    margin-bottom: 20px !important;
    border-radius: 10px;
}
.not-found{
    max-width: 400px;
    margin: auto;
    display: block;
}
.app-box {
    text-align: left;
    padding: 10px;
    border-radius: 10px;
    position:relative;
    background:#fff;
}
.img{
    max-width: 66px;
}
.cover-box{
    display: inline-block;
    padding-left: 13px;
}
.comps-name-1{
    padding-left: 15px;
    padding-top: 15px;
}
.org_name{display:block;}
.skill a{
    color: black;
    font-size: 18px;
    font-weight: bold;
}
.comp-name{
    font-weight: 700;
    font-size: 15px;
    color:#0173b2;
    margin:0;
    font-family:roboto;
}
.detail-loc{
    margin-top:5px;
}
.location{
    margin-right: 4px;
}
.fa-inr{
    color:lightgray;
    margin-right: 10px;

}
.city, .city i{
    color: #fff;
}
.show-responsive{
    display:none;
}

.job-fill{
    padding: 5px 10px 4px !important;
    margin: 3px !important;
    background-color:#ff7803 !important;
    color: #fff !important;
    border-radius: 0px 10px 0px 10px !important;
    float: right !important;
    position:absolute !important;
    right: -4px !important;
    top: -3px !important;
}
.clear{
    clear:both;
}
.sal{
    margin-right: 5px;
}
.salary{
    font-family:roboto;
}
.tag-box{
    border-top: 1px solid lightgray;
    padding-left:15px;
    padding-top:10px;
}
.tags{
    font-size: 17px;
    color:gray;
    font-family: Georgia !important;
    display:inline-block;
}
.after{
    padding-right: 25px;
    padding-left: 16px;
}
.after{
    background: #eee;
    border-radius: 3px 0 0 3px;
    color: #777;
    display: inline-block;
    height: 26px;
    line-height: 25px;
    padding: 0 21px 0 11px;
    position: relative;
    margin: 0 9px 3px 0;
    text-decoration: none;
    -webkit-transition: color 0.2s;
}
.after::after{
    background: #fff;
    border-bottom: 13px solid transparent;
    border-left: 10px solid #eee;
    border-top: 13px solid transparent;
    content: \"\";
    position: absolute;
    right: 0;
    top: 0;
}
.city-box{
    padding-bottom:5px;
}
.ADD-more{
    background-color: #eeeeee;
    padding: 4px 10px 4px 10px;
    border-radius: 5px;
}
.more-skills{
    background-color: #00a0e3;
    color: #fff;
    padding: 5px 15px;
    border-radius: 20px;
    display:inline-block;
}
.salary{ 
    padding-left: 16px;
}
.lg-skill{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
}
@media only screen and (max-width: 974px){
    .city-box{padding-left: 18px; padding-bottom: 10px;}
    .hide-responsive{display:none;}
    .show-responsive{display:inline;}
    .hide-resp{display:none;}
}
/*cards-box css*/
.align_btn{
    text-align:center;
    clear:both;
}
#no_job{
    font-size: 16px;
} 
");
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
