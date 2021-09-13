<?php

use yii\helpers\Url;
?>
    <script id="companies-card-all" type="text/template">
        {{#.}}
        <div class="col-md-4 col-sm-6">
            <div class="company-main {{#is_org}}company-main-height{{/is_org}}">
                <a href="/{{profile_link}}" target="_blank">
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
                        <a href="/{{profile_link}}" target="_blank">
                            <img src="{{logo}}" class="do-image" data-name="{{name}}" data-width="110" data-height="110" data-color="{{color}}" data-font="45px">
                        </a>
                    </div>
                    <h3 class="comp-Name"><a href="/{{profile_link}}" target="_blank" title="{{{name}}}">{{{name}}}</a>
                    </h3>
                    <h3 class="comp-relate">{{business_activity}}</h3>
                    {{#rating}}
                    <div class="com-rating comp-ratings">
                        <a href="/{{review_link}}" target="_blank">
                            <span class="average-star" data-score="{{rating}}"></span>
                            <span class="stars rate-in">{{rating}}</span>
                        </a>
                    </div>
                    <div class="rating">
                    </div>
                    {{/rating}}
                    {{^rating}}
                    <div class="com-rating comp-ratings">
                        <a href="/{{review_link}}" target="_blank">
                            <span class="average-star" data-score="0"></span>
                            <span class="stars rate-in">0</span>
                        </a>
                    </div>
                    <div class="rating">
                    </div>
                    {{/rating}}
                    <div class="comp-jobs-intern">
                        <a href="/jobs/list?slug={{slug}}" target="_blank"><span class="jobs">{{jobs_cnt}} Jobs</span></a>
                        <a href="/internships/list?slug={{slug}}" target="_blank"><span class="interns">{{internships_cnt}} Internships</span></a>
                    </div>
                    {{#is_org}}
                    <div class="flw-rvw">
                        {{#login}}
                        {{#is_followed}}
                        <a href="javascript:;" value="{{organization_enc_id}}" type="{{is_claimed}}"
                           class="is_follow_up follow_btn" target="_blank">FOLLOWED</a>
                        {{/is_followed}}
                        {{^is_followed}}
                        <a href="javascript:;" value="{{organization_enc_id}}" type="{{is_claimed}}"
                           class="is_follow_up" target="_blank">FOLLOW</a>
                        {{/is_followed}}
                        {{/login}}
                        {{^login}}
                        <a href="javascript:;" data-toggle="modal" data-target="#loginModal">FOLLOW</a>
                        {{/login}}
                        <a href="/{{review_link}}" target="_blank">Review</a>
                        <?php
                            if(!$hideDropResume){
                        ?>
                            <a href="javascript:;" class="fab-message-open" id="{{slug}}">DROP RESUME</a>
                        <?php
                            }
                        ?>
                    </div>
                    {{/is_org}}
                </a>
            </div>
        </div>
        {{/.}}
    </script>
<?php
if(!$hideDropResume) {
    echo $this->render('/widgets/drop_resume', [
        'username' => Yii::$app->user->identity->username,
        'type' => 'company',
        'org_cards' => true
    ]);
    $this->registerJsFile('@eyAssets/ideapopup/ideabox-popup_drop_resume.js');
    $this->registerJsFile('/assets/themes/dropresume/main.js');
    $this->registerCssFile('@eyAssets/ideapopup/ideabox-popup.css');
    $script2 = <<< JS
        $(document).on('click', '.fab-message-open', function() {
            var slug = $(this).attr('id');
            var btn = $(this);
            $.ajax({
                type: 'POST',
                url: '/drop-resume/check-resume',
                data : {slug:slug},
                beforeSend:function(){
                     btn.html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
                    btn.attr("disabled","true");
                },
                success: function(response){
                    btn.html('DROP RESUME');
                    btn.attr("disabled", false);
                    $('#dropcv').val(response.message);
                },
                complete: function() {
                    $('#fab-message-open').trigger('click');
                }
            });
            
        });
JS;
    $this->registerJs($script2);
}
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
	min-height: 350px !important;
}
.company-main-height{
    min-height: 390px !important;
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
//	border-radius: 60px;
	overflow: hidden;
//	border: 1px solid #eee;
//	box-shadow: 0 0 13px 4px #eee;
	line-height:104px;
	margin-top:12px;
}
.comp-Name {
	font-size: 24px;
	font-family: lora;
	margin: 20px 10px 5px;
	line-height: 30px;
	display: -webkit-box;
	-webkit-line-clamp: 1;
	-webkit-box-orient: vertical;
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
	padding: 5px 0 4px;
	border-radius: 4px;
	font-weight: 500;
	text-transform: uppercase;
	border:2px solid #00a0e3;
	background-color: #00a0e3;
	flex-basis: 35%;
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
});
JS;
$this->registerJs($script);

