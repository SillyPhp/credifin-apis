<?php

use yii\helpers\Url;
?>
<script id="usa-jobs-card-1" type="text/template">
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
                    <a href="/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}" title="{{DepartmentName}}">
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
                    <a href="/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}" title="{{PositionTitle}}"><h4 class="application-title">{{PositionTitle}}</h4></a>
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
<script id="usa-jobs-card" type="text/template">
    {{#.}}
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="application-card-main">
            <div class="app-box shadow">
                <span class="job-fill city">
                             <i class="fas fa-map-marker-alt"></i>&nbsp;{{Location}}
                    </span>
                <div class="app-card-main">
                    <div class="application-card-img">
                        <a href="/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}" target="_blank" title="{{DepartmentName}}">
                            {{#logo}}
                            <img src="{{logo}}" alt="{{organization_name}}" title="{{organization_name}}">
                            {{/logo}}
                            {{^logo}}
                            <canvas class="user-icon" name="{{DepartmentName}}" width="80" height="80"
                                    color="{{color}}" font="35px"></canvas>
                            {{/logo}}
                        </a>
                    </div>
                    <div class="comps-name-1 application-card-description">
                        <div class="us-card-t">
                            <a href="/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}"  target="_blank" title="{{PositionTitle}}" class="application-title capitalize org_name">
                                {{PositionTitle}}
                            </a>
                            <a href="/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}" target="_blank" title="{{organization_name}}"  class="org_name comp-name">
                                {{DepartmentName}}
                            </a>
                        </div>
                        <div class="job-loc">
                            <h5 class="salary"><i class="fas fa-dollar-sign"></i>{{MinimumRange}} - <i class="fas fa-dollar-sign"></i>{{MaximumRange}} {{Duration}}</h5>
                            {{#ApplicationCloseDate}}
                            <h5 class="last_date"><i class="far fa-calendar-alt"></i> Last_date: {{ApplicationCloseDate}}</h5>
                            {{/ApplicationCloseDate}}
                            <h5 class="loc"><i class="fas fa-map-marker-alt"></i> {{Location}}</h5>
                        </div>
                    </div>
                </div>
                <div class="application-card-wrapper application-card-bottom">
                    <a href="/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}" class="application-card-open" title="View Detail">View Detail</a>
                    <a href="javascript:;" class="share-b" title="Share">&nbsp;<i class="fas fa-share-alt"></i>&nbsp</a>
                    <div class="sharing-links">
                        <div class="inner">
                            <div class="fb">
                                <a href="javascript:;"
                                   onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . Url::to('/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}',true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-facebook j-linkedin share_btn tt" type="button" data-toggle="tooltip"
                                   title="Share on Facebook">
                                    <span><i class="fab fa-facebook-f"></i></span></a>
                            </div>
                            <div class="wts-app">
                                <a href="javascript:;"
                                   onclick="window.open('<?= Url::to('https://api.whatsapp.com/send?text=' . Url::to('/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}',true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-whatsapp share_btn tt" type="button" data-toggle="tooltip"
                                   title="Share on Whatsapp">
                                    <span><i class="fab fa-whatsapp"></i></span>
                                </a>
                            </div>
                            <div class="tw">
                                <a href="javascript:;"
                                   onclick="window.open('<?= Url::to('https://twitter.com/intent/tweet?text=' . Url::to('/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}',true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-twitter share_btn tt" type="button" data-toggle="tooltip"
                                   title="Share on Twitter">
                                    <span><i class="fab fa-twitter"></i></span></a>
                            </div>
                            <div class="linkd">
                                <a href="javascript:;"
                                   onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . Url::to('/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}',true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-linkedin share_btn tt" type="button" data-toggle="tooltip"
                                   title="Share on LinkedIn">
                                    <span><i class="fab fa-linkedin"></i></span></a>
                            </div>
                            <div class="male">
                                <a href="javascript:;"
                                   onclick="window.open('<?= Url::to('mailto:?&body=' . Url::to('/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}',true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-linkedin share_btn tt" type="button" data-toggle="tooltip"
                                   title="Share via E-Mail">
                                    <span><i class="far fa-envelope"></i></span></a>
                            </div>
                            <div class="tele">
                                <a href="javascript:;"
                                   onclick="window.open('<?= Url::to('https://t.me/share/url?url=' . Url::to('/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}',true)); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                   class="j-linkedin share_btn tt" type="button" data-toggle="tooltip"
                                   title="Share on Telegram">
                                    <span><i class="fab fa-telegram-plane"></i></span></a>
                            </div>
                            <div class="copy-app-link">
                                <a href="javascript:;" class="clipb tt detail-clipboard" type="button" data-toggle="tooltip"
                                   title="Copy Link" data-link="/usa-jobs/detail/{{JobCategory}}/{{MatchedObjectId}}">
                                    <i class="fas fa-clipboard"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
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
            $('.loader-main').css('display','block');
        },
  success:function(body) {   
      $('.loader-main').hide();
      body = JSON.parse(body);
      template.html(''); 
      template.append(Mustache.render($('#usa-jobs-card').html(),body));
      utilities.initials();
      $('#loader').hide();
      if(body == null){
           $('#loadMore').hide();
          template.append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
      }
  }   
  })
}

function fetch_usa_cards_dept(host,userAgent,authKey,template,Department)
{
  $.ajax({
  url:'/usa-jobs/get-dept-cards',
  method:'POST',
  data:{
      'Department':Department
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
      $('#loader').hide();
      if(body == null){
          $('#loader').hide();
          template.append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
      }
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
      body = JSON.parse(body);
      template.append(Mustache.render($('#usa-jobs-card').html(),body));
      utilities.initials();
      if(body == null){
          $('#loadMore').hide();
          template.append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');

      }
  }   
  })
}
$(document).on('click', '.detail-clipboard',function (event) {
            event.preventDefault();
            var link = window.location.hostname + $(this).attr('data-link');
            CopyClipboard(link, true, "Link copied");
        });
function CopyClipboard(value, showNotification, notificationText) {
        var temp = $("<input>");
        $("body").append(temp);
        temp.val(value).select();
        document.execCommand("copy");
        temp.remove();
        toastr.success("", "Link Copy to Clipboard");
    }
$(document).on('click', '.share-b', function(){
    let parentElem = $(this).parentsUntil('.app-box').parent();
    $(parentElem).find('.sharing-links').toggleClass('moveright');
    });

$(document).on('mouseleave', '.app-box', function(){
    $(this).find('.sharing-links').removeClass('moveright');
});
JS;
$this->registerJs($script);
$this->registerCss("
.app-box {
    text-align: left;
    padding: 30px 15px 5px;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
    background: #fff;
}
.app-card-main {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
}
.job-fill {
    padding: 4px 10px;
    background-color: #63c6f0 !important;
    color: #fff !important;
    border-radius: 0px 10px 0px 10px !important;
    position: absolute;
    right: 0;
    top: 0;
    max-width: 265px;
    font-size: 12px;
    font-family: 'Roboto';
}
.application-card-img img {
    height: 80px;
    max-height: 80px;
    width: 80px;
    max-width: 80px;
    overflow: hidden;
    object-fit: contain;
}
a.application-title.capitalize.org_name {
    display: block;
    font-size: 16px;
    font-weight: 500;
    font-family: 'Roboto';
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    color:#333;
}
.comp-name, .comp-name:hover {
    font-weight: 500;
    font-size: 14px;
    margin: 0;
    font-family: roboto;
    color: #63c6f0;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.application-card-description h5 {
    font-family: 'Roboto';
    font-weight: 500;
    margin: 6px 0px;
    display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
.application-card-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #ececec;
    margin-top: 5px;
    padding-top: 5px;
    width:100%;
    position:relative;
}
.share-b:hover{
    color:#00a0e3;
    transform:scale(1.2);
    transition:all .1s;
    }
.sharing-links {
    width: calc(100% - 12%);
    height:100%;
    position: absolute;
    right: -94%;
    top: 0px;
    text-align: center;
    background-color: #fff;
    padding: 3px 4px;
    transition:all .5s;
}
a.application-card-open:hover {
    color: #00a0e3;
    transform: scale(1.05);
}

a.application-card-open {
    font-family: 'Roboto';
    transition: all .3s;
    font-weight: 500;
}
.inner {
    display: flex;
    align-items: center;
    justify-content: center;
}
.moveright{right:13% !important;}
.wts-app i, .fb i, .tw i, .linkd i, .male i, .tele i, .copy-app-link i{
    width: 25px;
    text-align: center;
    border-radius: 50px;
    height: 25px;
    font-size: 14px;
    margin: 0 5px;
    border: 1px solid transparent;
    padding-top: 5px;
    transition:all .3s;
}
.fb i {color: #236dce;}
.fb i:hover {background-color: #236dce;}
.tw i{color: #1c99e9;}
.tw i:hover{background-color: #1c99e9;}
.linkd i{color: #0e76a8;}
.linkd i:hover{background-color: #0e76a8;}
.male i{color: #BB001B;}
.male i:hover{background-color: #BB001B;}
.tele i{color: #0088cc;}
.tele i:hover{background-color: #0088cc;}
.wts-app i{color:#4FCE5D;}
.wts-app i:hover{background-color:#4FCE5D;}
.copy-app-link i{color:#22577A;}
.copy-app-link i:hover{background-color:#22577A;}
.wts-app i:hover, .linkd i:hover, .tw i:hover, .fb i:hover, .male i:hover, .tele i:hover, .copy-app-link i:hover{
	color: #fff;
}
.share-b:hover .sharing-links, .sharing-links:hover{display:block !Important;}
/*cards-box css*/

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
.cover-box{
    display: inline-block;
    padding-left: 13px;
}
.comps-name-1{
    padding-left: 15px;
}
.skill a{
    color: black;
    font-size: 18px;
    font-weight: bold;
}
.detail-loc{
    margin-top:5px;
}
.fa-inr{
    color:lightgray;
    margin-right: 10px;
}
.show-responsive{
    display:none;
}


.clear{
    clear:both;
}
.sal{
    margin-right: 5px;
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
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
