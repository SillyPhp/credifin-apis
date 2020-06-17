<?php

use yii\helpers\Url;

?>
    <script id="news-card" type="text/template">
        {{#.}}
        <div class="col-md-4 col-sm-6">
            <a href="{{news_slug}}">
                <div class="news-box">
                    <div class="news-img">
                        <img src="{{news_image}}"/>
                    </div>
                    <div class="news-main">
                        <a href="{{news_slug}}">
                            <div class="news-heading">{{title}}</div>
                        </a>
                        <div class="news-date">{{news_time}}</div>
                        <div class="news-tags">
                            <ul>
                                {{#newsTags}}
                                <li>{{tag_name}}</li>
                                {{/newsTags}}
                            </ul>
                        </div>
                        <div class="news-content">{{news_description}}</div>
                        <div class="use-flex">
                            <div class="share-news">
                                <div class="wts-sh basis">
                                    <a href="#!"
                                       onclick="window.open('https://api.whatsapp.com/send?text={{sharing_link}}', '_blank', 'width=800,height=400,left=200,top=100')">
                                                    <span class="fb-btn" title="share on whatsapp"
                                                          data-toggle="tooltip"><i class="fab fa-whatsapp"></i></span>
                                    </a>
                                </div>
                                <div class="tel-sh basis">
                                    <a href="#!"
                                       onclick="window.open('https://telegram.me/share/url?url={{sharing_link}}', '_blank', 'width=800,height=400,left=200,top=100')">
                                                    <span class="tw-btn" title="share on telegram"
                                                          data-toggle="tooltip"><i
                                                                class="fab fa-telegram-plane"></i></span>
                                    </a>
                                </div>
                                <div class="tw-sh basis">
                                    <a href="#!"
                                       onclick="window.open('https://twitter.com/intent/tweet?text={{sharing_link}}', '_blank', 'width=800,height=400,left=200,top=100')">
                                                    <span class="tw-btn" title="share on twitter" data-toggle="tooltip"><i
                                                                class="fab fa-twitter marg"></i></span>
                                    </a>
                                </div>
                                <div class="li-sh basis">
                                    <a href="#!"
                                       onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url={{sharing_link}}', '_blank', 'width=800,height=400,left=200,top=100');">
                                                    <span class="li-btn" title="share on linkedIn"
                                                          data-toggle="tooltip"><i class="fab fa-linkedin-in marg"></i></span>
                                    </a>
                                </div>
                            </div>
                            <div class="news-btns">
                                <button data-id="upvoteBtn" data-key="{{news_enc_id}}" class="vote-btn"
                                        title="{{rand_upvote}}" data-toggle="tooltip"><i
                                            class="fas fa-thumbs-up"></i>
                                </button>
                                <button data-id="downvoteBtn" data-key="{{news_enc_id}}" class="vote-btn"
                                        title="{{rand_downvote}}" data-toggle="tooltip"><i
                                            class="fas fa-thumbs-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        {{/.}}
    </script>
<?php
$this->registerCss('
.align_btn {
    text-align: center;
    clear: both;
}
.news-bg {
	background-color: #f59f0c;
	padding: 20px 0;
}
.get-latest {
	font-size: 45px;
	font-family: lora;
	font-weight: 600;
	margin-top: 155px;
	color: #fff;
}
@media(max-width:1199px){
.get-latest {
	margin-top: 100px;
}
}
@media(max-width:768px){
.get-latest {
	margin-top: 50px;
}
}
@media(max-width:550px){
.get-latest {
	font-size:32px;
	text-align:center;
}
.get-logo {
	width: 250px;
	margin: auto;
}
}
.news-box {
    border-radius: 8px;
    box-shadow: 0 0 6px 1px #eee;
    margin-bottom:20px;
    transition:all .3s;
}
.news-box:hover {
	transform: translatey(-5px);
	box-shadow: 0 0 15px 6px #eee;
}
.news-img {
    width: 100%;
    min-height: 160px;
    max-height: 160px;
}
.news-img img{
    width: 100%;
    min-height: 160px;
    max-height: 160px;
    border-radius:8px 8px 0px 0px; 
}
.news-main {
    padding:10px 15px;
    font-family: roboto;
}
.news-heading {
	font-size: 22px;
	font-weight: 500;
	line-height: 30px;
	text-transform: capitalize;
	color: #333;
	display: block;
	display: -webkit-box;
	max-height: 66px;
	min-height: 66px;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
	text-overflow: ellipsis;
}
.news-date {
    color: #00a0e3;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
    min-height: 23px;
    max-height: 23px;
}
.news-tags {
    min-height: 30px;
    max-height: 30px;
    overflow:hidden;
}
.news-tags ul li{
    font-size: 13px;
    background-color: #333;
    display: inline-block;
    padding: 2px 9px;
    color: #fff;
    margin-bottom: 5px;
    border-radius:3px;
    font-weight:500;
}
//.news-tags ul li:nth-child(1) {
//  background: #ff7803;
//}
//.news-tags ul li:nth-child(2) {
//  background: #00a0e3;
//}
//.news-tags ul li:nth-child(3) {
//  background: #a42929;
//}
//.news-tags ul li:nth-child(4) {
//  background: #807e7e;
//}
.news-content {
	font-size: 16px;
	line-height: 24px;
	text-align: justify;
	background: #FFFFFF;
	display: block;
	display: -webkit-box;
	max-height: 75px;
	min-height: 75px;
	-webkit-line-clamp: 3;
	-webkit-box-orient: vertical;
	overflow: hidden;
	text-overflow: ellipsis;
	margin-bottom: 5px;
}
.news-btns button {
	background-color: #00a0e3;
	border: none;
	color: #fff;
	padding: 3px 15px;
	font-size: 16px;
	border-radius: 2px;
}
.use-flex {
	display: flex;
	justify-content: space-between;
	padding: 2px 0;
}
.share-news {
    display: flex;
}
.basis a {
	margin-right: 10px;
	color: #fff;
	padding: 4px 6px;
	border-radius: 3px;
}
.wts-sh a{background-color:#36dc54;}
.tel-sh a{background-color:#2399d7;}
.tw-sh a{background-color:#1da1f2;}
.li-sh a{background-color:#0073b1;}
');
$script = <<< JS
var match_dept = 0;
function fetchNews(template,limit_dept,offset,loader,loader_btn) {
  $.ajax({
  url:'/news/get-news',
  method:'Post',
  datatype:"json",
  data:{
      'limit':limit_dept,
      'offset':offset,
  },
  beforeSend: function(){
     if (loader_btn)
          { 
              $('#loader').attr('disabled', true);
              $('#loader').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
          }
     if (loader) {
            $('.img_load').css('display','block');
        }
      },
  success:function(body) {
      $('.img_load').css('display','none');
      $('#loader').html('Load   More');
      $('#loader').css('display','initial');
      $('#loader').attr('disabled', false);
       match_dept = match_dept+body.count;
      if (body.total<3||body.total==match_dept) 
          {
              $('#loader').hide();
          }
          template.append(Mustache.render($('#news-card').html(),body.cards));
          utilities.initials();
          if(body == ''){
          $('#loader').hide();
          template.append('<img src="/assets/themes/ey/images/pages/jobs/not_found.png" class="not-found" alt="Not Found"/>');
      }
  }   
  })
}
$(document).on('click', '.vote-btn', function (event) {
    event.preventDefault();
    var btn = $(this);
    event.stopImmediatePropagation();
    if ( btn.data('requestRunning') ) {
        return false;
    }
    btn.data('requestRunning', true);
    
    var id = btn.attr('data-id');
    var key = btn.attr('data-key');
    var targetValue = btn.attr('title');
      var updateValue = parseInt(targetValue) + 1; 
      btn.attr('title', updateValue);
    $.ajax({
        type: 'POST',
        data: {id:id,key:key},
        beforeSend: function () {
            btn.attr('disabled', true);
        },
        success: function (response) {
            btn.attr('disabled', false);
            if (response.status == 201) {
                toastr.error(response.message, response.title);
            }
        },
        complete: function() {
            btn.attr('disabled', false);
        }
    }).fail(function(data, textStatus, xhr) {
         toastr.error('Network Problem', 'Please try later..');
         btn.attr('disabled', false);
    });
});
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});

JS;
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($script);