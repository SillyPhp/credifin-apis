<?php

use yii\helpers\Url;

?>
    <script id="companies-card-all" type="text/template">
        {{#.}}
        <div class="col-md-4 col-sm-6">
            <div class="similar-company">
                <div class="sim-company-head">
                    <div class="sim-company-logo">
                        <a href="/{{profile_link}}" target="_blank">
                            <img src="{{logo}}" class="do-image" data-name="{{name}}" data-width="110" data-height="110" data-color="{{color}}" data-font="45px">
                        </a>
                    </div>
                    <div class="sim-company-details">
                        <h3 class="sim-comp-Name"><a href="{{profile_link}}" target="_blank" title="{{{name}}}">{{{name}}}</a>
                        </h3>
                        <h3 class="sim-comp-relate">{{business_activity}}</h3>
                        <div class="sim-comp-jobs-intern">
                            <a href="/jobs/list?slug={{slug}}" target="_blank"><span class="jobs">{{jobs_cnt}} Jobs</span></a>
                            <a href="/internships/list?slug={{slug}}" target="_blank"><span class="interns">{{internships_cnt}} Internships</span></a>
                        </div>
                        <div class="sim-view-detail">
                            <a href="">View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{/.}}
    </script>
<?php

echo $this->render('/widgets/drop_resume', [
    'username' => Yii::$app->user->identity->username,
    'type' => 'company',
    'org_cards' => true
]);

$this->registercss('
.similar-company {
    border: 1px solid #eee;
    box-shadow: 0px 2px 10px rgb(0 0 0 / 10%);
    border-radius
    text-align: center;
    position: relative;
    margin: 10px 0 20px;
	border-radius: 4px;
    padding: 15px 15px;
    transition: all .3s;
}
.similar-company:hover{
//    transform:scale(1.01);
    box-shadow:0px 10px 25px rgba(0,0,0,0.10);
}
.sim-company-head {
    display: flex;
    align-items: center;
}
.sim-company-details {
    text-align: left;
}
.sim-company-logo {
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
.sim-comp-Name {
    font-size: 24px;
    font-family: lora;
    margin: 20px 15px 5px;
    line-height: 30px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.sim-comp-relate {
    margin: 10px 15px 0;
    font-size: 18px;
    font-family: roboto;
    color: #9fa0a2;
    height: 26px;
}
.sim-comp-jobs-intern {
    padding: 10px 0px 5px;
    font-size: 16px;
    color: #999c9d;
    font-family: roboto;
}
.sim-comp-jobs-intern a {
    margin: 0 15px;
}
.sim-view-detail{
    display: flex;
}
.sim-view-detail a {
	color: #fff;
	font-size: 12px;
	font-family: roboto;
	padding: 5px 10px;
	font-weight: 500;
	border-radius: 4px;
	text-transform: uppercase;
	border:2px solid #00a0e3;
	background-color: #00a0e3;
	margin: 0 4px;
	transform: translate(19px, 15px);
	display: inline-block;
	margin-left:auto;
}
.sim-view-detail a:hover{
	background-color: #fff;
	color: #00a0e3;
	transition: all .3s;
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
$(document).on('click', '.fab-message-open', function() {
    var slug = $(this).attr('id');
    var btn = $(this);
    console.log(btn);
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
$this->registerJs($script);

