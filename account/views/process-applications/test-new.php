<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
?>
    <div class="container">
        <?php
        Pjax::begin(['id' => 'pjax_process']);
        ?>
        <ul class="nav nav-tabs pr-process-tab">
            <li class="active"
                style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 1; ?>)">
                <a data-filter="*" href="#">All</a></li>
            <?php
            foreach ($application_name['interviewProcessEnc']['interviewProcessFields'] as $p) {
                ?>
                <li style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 1; ?>)">
                    <a data-filter=".<?= $p['field_enc_id'] ?>" data-toggle="tooltip" data-placement="bottom" title=""
                       data-original-title="<?= $p['field_name'] ?>" href="#">
                        <i class="<?= $p['icon'] ?>" aria-hidden="true"></i>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
        <ul class="arlo_tm_portfolio_list gallery_zoom">
            <?php
            if (!empty($fields)) {
                foreach ($fields as $arr) {
                    $j = 0;
                    foreach ($arr['appliedApplicationProcesses'] as $p) {
                        if ($j == $arr['active']) {
                            $fieldMain =  $p['field_enc_id'];
                        }
                        $j++;
                    }
                    ?>
                    <li class="row pr-user-main <?= $fieldMain?>" data-key="<?= $fieldMain?>">
                        <div class="col-md-12 col-sm-12 pr-user-inner-main">
                            <div class="col-md-4">
                                <div class="pr-user-detail">
                                    <a class="pr-user-icon" href="<?= '/' . $arr['username'] ?>">
                                        <?php if ($arr['image']): ?>
                                            <img src="<?= $arr['image'] ?>"/>
                                        <?php else: ?>
                                            <canvas class="user-icon" name="<?= $arr['name'] ?>" width="80"
                                                    height="80" font="35px"></canvas>
                                        <?php endif; ?>
                                        <!--                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQSlL7khGH-Z3o48IDosMRnocgQAMv7Dxg7qLwzb5vrWf8WR7vRA"/>-->
                                    </a>
                                    <h4>
                                        <?= $arr['name'] ?>
                                        <!--                        <span> Ludhiana, Punjab</span>-->
                                    </h4>
                                    <?php
                                    foreach ($arr['createdBy']['userWorkExperiences'] as $exp) {
                                        if ($exp['is_current'] == 1) {
                                            echo '<h5>' . $exp["title"] . ' @ ' . $exp["company"] . '</h5>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="pr-user-past">
                                    <?php
                                    $experience = [];
                                    foreach ($arr['createdBy']['userWorkExperiences'] as $exp) {
                                        if ($exp['is_current'] == 0) {
                                            array_push($experience, $exp["company"]);
                                        }
                                    }
                                    $str = implode(", ", array_unique($experience));
                                    if ($str) {
                                        ?>
                                        <span class="past-title">
                                    Past
                                  </span>
                                        <h5>
                                            <?= rtrim($str, ','); ?>
                                        </h5>
                                        <?php
                                    }
                                    ?>
                                    <!--                                    <span>+2 more</span>-->
                                </div>
                                <?php
                                if ($arr['createdBy']['userEducations']) {
                                    ?>
                                    <div class="pr-user-past">
                                      <span class="past-title">
                                        Edu
                                      </span>
                                        <h5><?= $arr['createdBy']['userEducations'][0]['institute'] . ' - ' . $arr['createdBy']['userEducations'][0]['degree']; ?></h5>
                                        <?php
                                        if (COUNT($arr['createdBy']['userEducations']) > 1) {
                                            ?>
                                            <span>+<?= COUNT($arr['createdBy']['userEducations']) - 1 ?> more</span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col-md-5">
                                <div class="pr-user-skills">
                                    <ul>
                                        <?php
                                        foreach ($arr['createdBy']['userSkills'] as $skill) {
                                            ?>
                                            <li><?= $skill['skill']; ?></li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                    <h4><span>Occupaiton:</span> Design, Entry Level, Research <span>+7</span></h4>
                                    <?php
                                    $industry = [];
                                    foreach ($arr['createdBy']['userPreferredIndustries'] as $ind) {
                                        array_push($industry, $ind["industry"]);
                                    }
                                    $str2 = implode(", ", array_unique($industry));
                                    if ($str2) {
                                        ?>
                                        <h4>
                                            <span>Industry: </span>
                                            <?= rtrim($str2, ','); ?>
<!--                                            <span>+5</span>-->
                                        </h4>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3 pl-0">
                                <div class="pr-user-actions">
                                    <div class="pr-top-actions text-right">
                                        <a href="<?= '/' . $arr['username'] ?>">View Profile</a>
                                        <!--                                        <a href="#">Download Resume</a>-->
                                    </div>
                                    <ul>
                                        <!--                                        <li>-->
                                        <!--                                            <a href="#">-->
                                        <!--                                                <img src="-->
                                        <?//= Url::to('@eyAssets/images/pages/dashboard/email2.png') ?><!--"/>-->
                                        <!--                                            </a>-->
                                        <!--                                        </li>-->
                                        <li>
                                            <a href="#">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/chat-button-blue.png') ?>"/>
                                            </a>
                                        </li>
                                        <!--                        <li>-->
                                        <!--                            <i class="fa fa-phone-square"></i>-->
                                        <!--                        </li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pr-user-action-main">
                            <div class="pr-half-height">
                                <a href="javascript:;" class="approve" value="<?= $arr['applied_application_enc_id']; ?>" data-total="<?= $arr['total']; ?>">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/approve.png'); ?>"/>
                                </a>
                                <!--                <i class="fa fa-thumbs-o-up"></i>-->
                            </div>
                            <div class="pr-half-height">
                                <a href="javascript:;" class="reject" value="<?= $arr['applied_application_enc_id']; ?>">
                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/reject5.png'); ?>"/>
                                </a>
                                <!--                <i class="fa fa-thumbs-o-down"></i>-->
                            </div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
        <?php
        Pjax::end();
        ?>
    </div>
<?php
$this->registerCss('
.pl-0{padding-left:0px;}
.pr-user-main{
  margin:20px 0px;
  margin-bottom: 50px;
  list-style: none;
  border-radius:8px;
  box-shadow:0px 3px 10px 2px #ddd;
  background-color: #fdfdfd;
  width:100%;
}
.pr-user-inner-main{
  padding:20px 0px;
  padding-top: 0px;
  padding-left: 15px;
  width:calc(100% - 70px);
  border-right:1px solid #ddd;
}
.pr-user-detail h4{
  font-size:19px;
  font-weight:500;
  margin: 0px;
  display: inline-block;
}
.pr-user-detail{
    padding-left: 85px;
    padding-top: 20px;
    margin-top: -10px;
}
.pr-user-icon{
    display: inline-block;
    width: 90px;
    height: 90px;
    transform: translate(0px, -45px);
    border: 5px solid #fff;
    box-shadow: 0px 0px 10px 0px #ddd;
    border-radius: 4px;
    position: absolute;
    left: 0;
}
.pr-user-icon img{
    width: 100%;
}
.pr-user-detail h5{
  font-size:14px;
  font-weight: 500;
  margin: 8px 0px;
  color: #858585;
}
.pr-user-detail h4 span{
  font-size:14px;
  color:#777777;
}
.pr-user-past span{
  display:inline-block;
  color:#aaa;
}
.pr-user-past .past-title{
  background-color:#f2f2f2;
  color:#555;
  padding:3px 15px;
  border-radius:20px;
}
.pr-user-past h5{
  display:inline-block;
}
.pr-user-skills{padding-top:20px;}
.pr-user-skills ul, .pr-user-actions ul{list-style:none;padding:0px;}
.pr-user-skills ul li{
  display:inline-block;
  background-color:#efefef;
  padding:4px 15px;
  margin:2px;
  font-size:15px;
  color:#222;
  border-radius:30px;
}
.pr-user-skills h4{
  font-size:14px;
}
.pr-user-skills h4 span{
  color:#777;
}
.pr-top-actions a{
    background-color: #00a0e3;
    padding: 4px 10px;
    display: inline-block;
    border-radius: 0px 0px 4px 4px;
    color: #fff;
    font-size: 12px;
    margin-right:1px;
}
.pr-user-actions ul{
  padding-top:40px;
  text-align:right;
}
.pr-user-actions ul li{
  display:inline-block;
  font-size:23px;
  margin:0px 8px;
}
.pr-user-actions ul li a img{
    max-width:35px;
}
.pr-user-action-main{
  width:70px;
  float:right;
  height: 165px;
  display: block;
  position: relative;
}
.pr-half-height{
  font-size:25px;
  height:50%;
  padding-top:28%;
  text-align:center;
}
.pr-half-height:first-child{
  border-bottom:1px solid #ddd;
}
.pr-half-height a img{max-width:34px;}
.pr-half-height:first-child a img{max-width:40px;}

/* Tabs css starts*/
.pr-process-tab{
    border-bottom: none;
    margin-bottom:50px;
}
.pr-process-tab li {
  display: block;
  float: left;
  position: relative;
  font-size: 1.25em;
  line-height: 1.5em;
  text-align: center;
  text-overflow: ellipsis;
  background: white;
  border: 1px solid #ccc;
  border-right: none;
  padding: 0;
  cursor: pointer;
  margin-bottom: 1em;
  color:#555;
}
.pr-process-tab li a{
    background-color:transparent !Important;
    color:#555 !Important;
    border:none !Important;
    padding: 7.5px 15px;
}
.pr-process-tab li a:hover{
    background-color:transparent;
}
.pr-process-tab li.active a{
    color:#fff !important;
}
.pr-process-tab li:before {
  content: "";
  display: block;
  position: absolute;
  z-index: 1;
  top: 0;
  right: -34px;
  width: 0;
  height: 0;
  border: 17px solid transparent;
  border-left-color: #797979;
}
.pr-process-tab li:after {
  content: "";
  display: block;
  position: absolute;
  z-index: 1;
  top: 0;
  right: -35px;
  margin-right: 1px;
  width: 0;
  height: 0;
  border: 17px solid transparent;
  border-left-color: white;
}
.pr-process-tab li:first-child {
  border-radius: 20px 0 0 20px;
}
.pr-process-tab li:last-child {
  border-right: 1px solid #ccc;
  border-radius: 0 20px 20px 0;
}
.pr-process-tab li:last-child:before, .pr-process-tab li:last-child:after{
    display:none;
}
.pr-process-tab li:hover {
  background: #eee;
}
.pr-process-tab li:hover:after {
  border-left-color: #eee;
}
.pr-process-tab li.active {
  background: #00a0e3;
  border-color: #00a0e3;
}
.pr-process-tab li.active:after {
  border-left-color: #00a0e3;
}
.pr-process-tab li.active:before {
  border-left-color: #00a0e3;
}
.tooltip-inner {
    background-color: #00a0e3 !important;
    color: #fff;
    padding:5px 10px;
    border-radius:20px !important;
}
.tooltip.top .tooltip-arrow {
    border-top-color: #00acd6;
}
.tooltip.bottom .tooltip-arrow{
    border-bottom-color:#00a0e3;
}
.arlo_tm_portfolio_list{
    padding-left:0px;
}
/* Tabs css ends*/
@media screen and (max-width: 600px){
    .pr-user-inner-main{
        width:100%;
    }
    .pr-top-actions a{border-radius:4px;}
    .pr-top-actions, .pr-user-actions ul{text-align:center;}
    .pr-user-action-main{
        width:100%;
        border-top: 1px solid #ddd;
        height: 75px;
    }
    .pr-half-height{
        padding-top: 15px;
        width: 49%;
        display: inline-block;
        height: 100%;
    }
    .pr-half-height:first-child{
        border-right: 1px solid #ddd;
        border-bottom: none;
    }
    .nav.nav-tabs li {
        width: 100%;
        margin-bottom: 0px;
        border-bottom: 0px;
        border-right: 1px solid #ddd;
    }
    .pr-process-tab li:first-child{border-radius:0px;}
    .pr-process-tab li:before{
        top: 34px;
        right: 2%;
        transform: rotateZ(90deg);
    }
    .pr-process-tab li:after{
        top: 34px;
        right: 2%;
        margin-right: 0px;
        transform: rotateZ(90deg);
    }
    .pr-process-tab li:last-child {
        border-bottom: 1px solid #ccc !important;
        border-radius: 0px;
    }
}
');
$script = <<<JS
$('[data-toggle="tooltip"]').tooltip();
function arlo_tm_portfolio(){
	if(jQuery().isotope) {
		// Needed variables
		var list 		 = jQuery('.arlo_tm_portfolio_list');
		var filter		 = jQuery('.pr-process-tab li');

		if(filter.length){
			// Isotope Filter 
			filter.find('a').on('click', function(){
				var selector = jQuery(this).attr('data-filter');
				list.isotope({ 
					filter				: selector,
					animationOptions	: {
						duration			: 750,
						easing				: 'linear',
						queue				: false
					}
				});
				return false;
			});	

			// Change active element class
			filter.find('a').on('click', function() {
				filter.find('a').parent().removeClass('active');
				$(this).parent().addClass('active');
				return false;
			});	
		}
	}
}
arlo_tm_portfolio();
$(document).on('click', '.approve', function(e) {
    e.preventDefault();
    // var field_id = $(this).parent().prev('div').find('.current').attr('data-id');  
    var field_id = $(this).parent().parentsUntil('.pr-user-main').parent().attr('data-key');  
    var app_id = $(this).attr('value');
    var btn = $(this);
    var btn2 = btn.next();
    var btn3 = btn.prev();
    var total = $(this).attr('data-total');
   $.ajax({
       url:'/account/jobs/approve-candidate',
       data:{field_id:field_id,app_id:app_id},
       method:'post',
       beforeSend:function()  {
            btn.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
            btn.attr("disabled","true");
        },    
       success:function(data){
            res = JSON.parse(data);
            if(res.status==true) {
                  disable(btn);
                  run(btn);
                btn.html('<img src="/assets/themes/ey/images/pages/dashboard/approve.png">');
                  hide_btn(res,total,btn,btn2,btn3); 
                  $.pjax.reload({container: '#pjax_process', async: false});
            } else {
               disable(btn);
               alert('something went wrong..');
            }
      }
   }) 
});
$(document).on('click','.reject',function(e){
    e.preventDefault();
    var btn = $(this);
    var btn2 = $(this).prev();
    var btn3 = $(this).next();
    var app_id = $(this).attr('value');
    $.ajax({
        url:'/account/jobs/reject-candidate',
        data:{app_id:app_id},
        method:'post',
        beforeSend:function()  {
            btn.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
            btn.attr("disabled","true");
        },    
        success:function(data){
            if(data==true) {
                btn.hide();
                btn2.hide();
                btn3.show();
            }
            else {
                alert('something went wrong..');
            }
        }
    });
});
function hide_btn(res,total,thisObj,thisObj1,thisObj2){  
    if(res.active==total) {
        thisObj.hide();
        thisObj1.hide();
        thisObj2.show();
    }
}
function disable(thisObj){thisObj.html('APPROVE');thisObj.removeAttr("disabled");}
function run(thisObj){
    var current_div = $(thisObj).parent().prev('div').find('.steps-step-2:first');
    if(current_div.hasClass('active')) {
        current_div = $(thisObj).parent().prev('div').find('.steps-step-2.active:last').next('.steps-step-2');
    }
    if(!(current_div.is(':last-child'))) {
        current_div.addClass('active');
        setTimeout(function() {
            current_div.next('div').find('a').addClass('current');
        }, 1000);
        
    }
    current_div.find('a').removeClass('current').addClass('active');
}
JS;
$this->registerJs($script);
$this->registerJsFile('/assets/themes/backend/vendor/isotope/isotope.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);