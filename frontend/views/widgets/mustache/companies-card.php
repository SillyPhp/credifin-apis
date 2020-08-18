<?php

use yii\helpers\Url;

?>
    <script id="companies-card-all" type="text/template">
        {{#.}}
        <div class="col-md-4 col-sm-6">
            <div class="company-main">
                <a href="{{profile_link}}" target="_blank">
                    <div class="comp-featured">
                        {{#is_new}}
                        <span class="new-j" data-toggle="tooltip" title="New">
                            <img src="<?= Url::to('@eyAssets/images/job-profiles/new-job.png') ?>"/>
                        </span>
                        {{/is_new}}
                        {{#is_featured}}
                        <span data-toggle="tooltip" title="Featured">
                            <img src="<?= Url::to('@eyAssets/images/job-profiles/featured-job.png') ?>"/>
                        </span>
                        {{/is_featured}}
                        {{#is_promoted}}
                        <span data-toggle="tooltip" title="Promoted">
                            <img src="<?= Url::to('@eyAssets/images/job-profiles/promoted-job.png') ?>"/>
                        </span>
                        {{/is_promoted}}
                        {{#is_hot}}
                        <span data-toggle="tooltip" title="Hot">
                            <img src="<?= Url::to('@eyAssets/images/job-profiles/hot-job.png') ?>"/>
                        </span>
                        {{/is_hot}}
                        {{#is_trending}}
                        <span data-toggle="tooltip" title="Trending">
                            <img src="<?= Url::to('@eyAssets/images/job-profiles/trending-job.png') ?>"/>
                        </span>
                        {{/is_trending}}
                    </div>
                    <div class="total-vacancies">
                        {{#total_vaccency}}
                        <a href="#">{{total_vaccency}} Vacancies</a>
                        {{/total_vaccency}}
                        {{^total_vaccency}}
                        <a href="#">No Vacancies</a>
                        {{/total_vaccency}}
                    </div>
                    <div class="comp-logo">
                        {{#logo}}
                        <a href="/{{profile_link}}" target="_blank">
                            <img src="{{logo}}">
                        </a>
                        {{/logo}}
                        {{^logo}}
                        <a href="/{{profile_link}}" target="_blank">
                            <canvas class="user-icon" name="{{name}}" width="110" height="110"
                                    color="{{color}}" font="35px"></canvas>
                        </a>
                        {{/logo}}
                    </div>
                    <h3 class="comp-Name"><a href="{{profile_link}}" target="_blank">{{{name}}}</a></h3>
                    <h3 class="comp-relate">{{business_activity}}</h3>
                    {{#rating}}
                    <div class="com-rating comp-ratings">
                        <span class="average-star" data-score="{{rating}}"></span>
                        <span class="stars rate-in">{{rating}}</span>
                    </div>
                    <div class="rating">
                    </div>
                    {{/rating}}
                    {{^rating}}
                    <div class="com-rating comp-ratings">
                        <span class="average-star" data-score="0"></span>
                        <span class="stars rate-in">0</span>
                    </div>
                    <div class="rating">
                    </div>
                    {{/rating}}
                    <div class="comp-jobs-intern">
                        <a href="/jobs/list?slug={{slug}}" target="_blank"><span class="jobs">{{#employerApplications.0.total_application}} {{employerApplications.0.total_application}} {{/employerApplications.0.total_application}} {{^employerApplications.0.total_application}} 0 {{/employerApplications.0.total_application}}Jobs</span></a>
                        <a href="/internships/list?slug={{slug}}" target="_blank"><span class="interns">{{#employerApplications.1.total_application}} {{employerApplications.1.total_application}} {{/employerApplications.1.total_application}} {{^employerApplications.1.total_application}} 0 {{/employerApplications.1.total_application}} Internships</span></a>
                    </div>
                    <div class="flw-rvw">
                        <a href="/{{profile_link}}" target="_blank">VIEW PROFILE</a>
                        <a href="/{{review_link}}" target="_blank">REVIEW</a>
                        {{#login}}
                        {{#is_followed}}
                        <a href="javascript:;" value="{{organization_enc_id}}" type="{{is_claimed}}" class="is_follow_up follow_btn" target="_blank">FOLLOWED</a>
                        {{/is_followed}}
                        {{^is_followed}}
                        <a href="javascript:;" value="{{organization_enc_id}}" type="{{is_claimed}}" class="is_follow_up"  target="_blank">FOLLOW</a>
                        {{/is_followed}}
                        {{/login}}
                        {{^login}}
                        <a href="javascript:;" data-toggle="modal" data-target="#loginModal">FOLLOW</a>
                        {{/login}}
                    </div>
                </a>
            </div>
        </div>
        {{/.}}
    </script>
<?php
$this->registercss('
.follow_btn
{
    background-color: #fff !important;
    color: #00a0e3 !important;
    transition: all .3s;
}
.new-j {
	margin-left: -5px;
}
.new-j img{
    width:55px !important;
}
.company-main {
	border: 1px solid #eee;
	box-shadow:0px 2px 10px rgba(0,0,0,0.10);
	border-radius: 6px;
	text-align: center;
	position: relative;
	margin:10px 0 20px;
	padding: 30px 0px 10px;
	transition:all .3s;
}
.company-main:hover{
//    transform:scale(1.01);
    box-shadow:0px 10px 25px rgba(0,0,0,0.10);
}
.comp-featured {
	position: absolute;
	top: 5px;
	left: 5px;
}
.comp-featured img{width:30px; }
.comp-logo {
	width: 110px;
	height: 110px;
	margin: auto;
	border-radius: 60px;
	overflow: hidden;
	border: 1px solid #eee;
	box-shadow: 0 0 13px 4px #eee;
	line-height:104px;
	margin-top:12px;
}
.comp-Name {
	font-size: 24px;
	font-family: lora;
	margin: 20px 10px 5px;
	line-height: 30px;
	height: 60px;
	overflow: hidden;
}
.comp-relate {
	margin: 0;
	font-size: 18px;
	font-family: roboto;
	color: #9fa0a2;
	height:26px;
}
.comp-ratings {
	display: inline-flex;
	border: 1px solid #eee;
	padding:3px 5px 5px;
	box-shadow: 0 2px 6px rgba(0,0,0,0.10);
	margin: 15px 0 5px;
	border-radius:3px;
}
.comp-ratings span{
    margin:0 2px;
}
.comp-ratings span i{
    font-size:20px;
    color:#ff8a00;
}
.rate-in {
	background-color: forestgreen;
	color: #fff;
	font-family: roboto;
	margin-left: 5px !important;
	padding: 0 5px;
	border-radius:3px;
	font-weight:500;
	line-heighht:26px;
	width: 23px;
	font-size:15px;
}
.comp-jobs-intern {
	display: flex;
	padding: 10px 0 5px;
	font-size: 18px;
	color: #999c9d;
	font-family: roboto;
	flex: 1 1;
	align-items: center;
	justify-content: center;
}
.total-vacancies {
	position: absolute;
	top: 0;
	right: 0px;
	padding: 3px 8px;
}
.total-vacancies a {
	font-size: 20px;
	font-family: lora;
	font-weight: 500;
	display: block;
}
.comp-jobs-intern a {
    margin: 0 15px;
}
.flw-rvw {
	display: flex;
	justify-content: center;
	align-items: center;
	padding:0 10px;
	margin:5px 0;
}
.flw-rvw a {
	color: #fff;
	font-size: 12px;
	font-family: roboto;
	padding: 6px 0;
	border-radius: 4px;
	font-weight: 500;
	text-transform: uppercase;
	border:2px solid;
	background-color: #00a0e3;
	flex-basis: 50%;
	margin: 0 4px;
}
.flw-rvw a:hover{
	background-color: #fff;
	color: #00a0e3;
	transition: all .3s;
}
.com-rating.comp-ratings img {
    width: 20px;
}
');

$script = <<< JS
$(document).on('click','.is_follow_up',function(e) {
  e.preventDefault();
    btn = $(this);
    var org_id = btn.attr('value');
    var type = btn.attr('type');
    if (btn.hasClass('follow_btn'))
        {
            btn.removeClass('follow_btn')
            btn.text('Follow');
        }
    else 
        {
           btn.addClass('follow_btn'); 
           btn.text('Followed');
        }
    if (type == "1")
        {
            var url = '/organizations/follow';
        }
    else{
        var url = '/organizations/follow-unclaimed-organization';
    }
    $.ajax({
        url:url,
        data: {org_id:org_id},                         
        method: 'post',
        beforeSend:function(){
         //pre actions
        },
        success:function(data){  
         //success logs
        },
        error:function(xhr)
        {
            alert(xhr);
        }
    }); 
})
JS;
$this->registerJs($script);
