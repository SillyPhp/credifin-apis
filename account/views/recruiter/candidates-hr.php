<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<section>
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="col-md-4 col-md-offset-8">
                <?=
                Html::button('Add New Candidate', [
                    'class' => 'btn btn-primary custom-buttons',
                    'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'add-candidate-profile'),
                    'id' => 'addpro',
                    'data-toggle' => 'modal',
                    'data-target' => '#addprofile',
                ]);
                ?>
            </div>
        </div>
    </div>
</section>
<div class="">
    <div class="row widget-row">
        <div class="col-md-3">
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Total Candidates </h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-green fa fa-users"></i>
                    <div class="widget-thumb-body">
                        <!--<span class="widget-thumb-subtitle">Total number of candidates</span>-->
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="7,644">0</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"> 
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Placements Till Date</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-red fa fa-users"></i>
                    <div class="widget-thumb-body">
                        <!--<span class="widget-thumb-subtitle">USD</span>-->
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="1,293">0</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Looking For Job</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-purple fa fa-user"></i>
                    <div class="widget-thumb-body">
                        <!--<span class="widget-thumb-subtitle">USD</span>-->
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="815">0</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
                <h4 class="widget-thumb-heading">Open For Opportunities</h4>
                <div class="widget-thumb-wrap">
                    <i class="widget-thumb-icon bg-blue fa fa-user"></i>
                    <div class="widget-thumb-body">
                        <!--<span class="widget-thumb-subtitle">USD</span>-->
                        <span class="widget-thumb-body-stat" data-counter="counterup" data-value="5,071">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Candidate Profiles</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_actions_pending">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- BEGIN: Actions -->
                                    <!--                        <div class="mt-actions scroller " style="height: 450px;" >-->
                                    <div class="row cd-box">
                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div>                     

                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div>                    

                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div>                     

                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div>                    

                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div>                     

                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div> 
                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div>
                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div>
                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div>
                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div>
                                        <div class="col-md-3 cd-can-box">
                                            <div class="cd-box-border col-md-12">
                                                <div class=" cd-user-icon">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg'); ?>" class="img-responsive img-thumbnail img-rounded">
                                                </div>
                                                <div class="">
                                                    <div class="cd-user-detail">                                       
                                                        <div class="cd-u-name">Natasha Kim</div>
                                                        <div class="cd-u-field">UI/UX developer</div>
                                                        <div class="cd-u-p-company">at DSB Edu tech</div>
                                                    </div>
                                                </div>
                                                <div class="cd-btns">
                                                    <button type="button" class="btn btn-outline btn-circle orange btn-sm">View</button>   
                                                    <button type="button" class="btn btn-outline btn-circle blue btn-sm">Shortlist</button>   
                                                </div>                     
                                            </div>                     
                                        </div>
                                    </div>
                                    <!--                        </div>-->
                                    <!-- END: Actions -->
                                </div>
                            </div>
                        </div>
                        <div class="com-load-more-btn">
                            <button type="button" id="comloadmore" class="btn blue">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addprofile" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>" alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('account', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss('
.btn.btn-outline.orange {
    border-color: #ff7803;
    color: #ff7803;
    background: 0 0;
}
.btn.btn-outline.orange.active, .btn.btn-outline.orange:active, .btn.btn-outline.orange:active:focus, .btn.btn-outline.orange:active:hover, .btn.btn-outline.orange:focus, .btn.btn-outline.orange:hover {
    border-color: #ff7803;
    color: #fff;
    background-color: #ff7803;
}
.cd-can-box{
    text-align-center !important; 
    margin-top:60px;
} 
.cd-user-icon{
    margin:0 auto;
}
.cd-user-icon {
    max-width:80px; 
    height:80px; 
    margin-top:-50px;
}
.cd-user-detail{
    padding:10px 0px 0 0px;
    text-align:center;
}
.cd-box{
    margin-bottom:3px;
    padding:5px 15px;
}
.cd-box-border{
    border:2px solid #eef1f4;
    padding:10px 20px;
    background:#fff; 
    border-radius:10px !important; 
    color:#999999;
}
.cd-box-border:hover{
    box-shadow:0 0 20px rgb(0,0,0,.1); 
    background-image: url(' . Url::to('@eyAssets/images/pages/dashboard/cd-box-bg3.png') . ');
    background-size:contain; 
    color:#000 !important;
}                    
.cd-u-name{
    font-weight:bold; 
    font-size:16px;
    transition:1s all;
}
.cd-u-field{
    font-size:16px; 
}
.cd-u-p-company{
    font-size:14px;
}
.cd-btns{
    text-align:center;
}
.cd-btns button{
    margin:25px 0 0 0;
}
.com-load-more-btn{
    text-align:center; 
    padding-top:20px;  
}
.btn-primary {
    background-color: #0088CC;
    border-color: #0088CC #0088CC #006699;
    color: #FFF;
}
.custom-buttons{
    width:100%;
    font-size: 10px !important;
    padding: 8px 0px !important;
    margin-bottom:20px;
}  
 .large-container{
   max-width: 1400px !important;
   padding-left: 15px;
   padding-right: 15px;
   margin:auto;
 }
.dashboard-button a, .dashboard-button button{    
    margin-left:10px !important;
}
.intl-tel-input {
    width: 100%;
}

.thumbnail{
    padding: 0px !important;
    margin: 20px auto 25px auto !important;
}
.thumbnail img{
    width: 100%;
    height: 100%;
}
.js-title-step span{
    display:none;
}

.widget-thumb-subtitle{font-size:11px !important;}
');
$script = <<<JS
//$(document).on("click", "#open-modal", function () {
//    $(".modal-body").load($(this).attr("url"));
//});
//$(document).on("click", "#open-modal2", function () {
//    $(".modal-body").load($(this).attr("url"));
//    $('#add-new').modalSteps();
//});
//$(document).on("click", "#open-modal3", function () {
//    $(".modal-body").load($(this).attr("url"));
//});
//$(document).on("click", "#open-modal4", function () {
//    $(".modal-body").load($(this).attr("url"));
//});
$(document).on("click", "#addpro", function () {
    $(".modal-body").load($(this).attr("url"));
});

  $('form').validate({
  rules: {
    'OrganizationSignUpForm[company_name]': {
         required: true,
     },
        
    "OrganizationSignUpForm[company_email]": {
         required: true,
     },
    "OrganizationSignUpForm[company_website]": {
         required: true,
     },
    "OrganizationSignUpForm[company_phone]": {
         required: true,
     }
  },
});  
        
!function(a){"use strict";a.fn.modalSteps=function(b){var c=this,d=a.extend({btnCancelHtml:"Cancel",btnPreviousHtml:"Previous",btnNextHtml:"Next",btnLastStepHtml:"Complete",disableNextButton:!1,completeCallback:function(){},callbacks:{},getTitleAndStep:function(){}},b),e=function(){var a=d.callbacks["*"];if(void 0!==a&&"function"!=typeof a)throw"everyStepCallback is not a function! I need a function";if("function"!=typeof d.completeCallback)throw"completeCallback is not a function! I need a function";for(var b in d.callbacks)if(d.callbacks.hasOwnProperty(b)){var c=d.callbacks[b];if("*"!==b&&void 0!==c&&"function"!=typeof c)throw"Step "+b+" callback must be a function"}},f=function(a){return void 0!==a&&"function"==typeof a&&(a(),!0)};return c.on("show.bs.modal",function(){var l,m,n,o,p,b=c.find(".modal-footer"),g=b.find(".js-btn-step[data-orientation=cancel]"),h=b.find(".js-btn-step[data-orientation=previous]"),i=b.find(".js-btn-step[data-orientation=next]"),j=d.callbacks["*"],k=d.callbacks[1];d.disableNextButton&&i.attr("disabled","disabled"),h.attr("disabled","disabled"),e(),f(j),f(k),g.html(d.btnCancelHtml),h.html(d.btnPreviousHtml),i.html(d.btnNextHtml),m=a("<input>").attr({type:"hidden",id:"actual-step",value:"1"}),c.find("#actual-step").remove(),c.append(m),l=1,p=l+1,c.find("[data-step="+l+"]").removeClass("hide"),i.attr("data-step",p),n=c.find("[data-step="+l+"]").data("title"),o=a("<span>").addClass("label label-success").html(l),c.find(".js-title-step").append(o).append(" "+n),d.getTitleAndStep(m.attr("data-title"),l)}).on("hidden.bs.modal",function(){var a=c.find("#actual-step"),b=c.find(".js-btn-step[data-orientation=next]");c.find("[data-step]").not(c.find(".js-btn-step")).addClass("hide"),a.not(c.find(".js-btn-step")).remove(),b.attr("data-step",1).html(d.btnNextHtml),c.find(".js-title-step").html("")}),c.find(".js-btn-step").on("click",function(){var m,n,o,p,b=a(this),e=c.find("#actual-step"),g=c.find(".js-btn-step[data-orientation=previous]"),h=c.find(".js-btn-step[data-orientation=next]"),i=c.find(".js-title-step"),j=b.data("orientation"),k=parseInt(e.val()),l=d.callbacks["*"];if(m=c.find("div[data-step]").length,"complete"===b.attr("data-step"))return d.completeCallback(),void c.modal("hide");if("next"===j)n=k+1,g.attr("data-step",k),e.val(n);else{if("previous"!==j)return void c.modal("hide");n=k-1,h.attr("data-step",k),g.attr("data-step",n-1),e.val(k-1)}parseInt(e.val())===m?h.attr("data-step","complete").html(d.btnLastStepHtml):h.attr("data-step",n).html(d.btnNextHtml),d.disableNextButton&&h.attr("disabled","disabled"),c.find("[data-step="+k+"]").not(c.find(".js-btn-step")).addClass("hide"),c.find("[data-step="+n+"]").not(c.find(".js-btn-step")).removeClass("hide"),parseInt(g.attr("data-step"))>0?g.removeAttr("disabled"):g.attr("disabled","disabled"),"previous"===j&&h.removeAttr("disabled"),o=c.find("[data-step="+n+"]"),o.attr("data-unlock-continue")&&h.removeAttr("disabled"),p=o.attr("data-title");var q=a("<span>").addClass("label label-success").html(n);i.html(q).append(" "+p),d.getTitleAndStep(o.attr("data-title"),n);var r=d.callbacks[e.val()];f(l),f(r)}),this}}(jQuery);
        $('#add-new').modalSteps();
        
   var callback = function(){
 
//        if($('#company-form').yiiActiveForm('validate', true))
//        {
//          disableNextButton:1;
//         }
//        else
//        {
//          disableNextButton:!1;
//        }
       $('form').valid();
   }
       
  $('#add-new').modalSteps({
       callbacks:{
           '*':callback
        }
   });    
        

        
      
//$('#nexts').on('click',function(e){
//        e.preventDefault();
//        console.log('1');
//    $('#company-form').yiiActiveForm('validate', true);
//});

    $(document).on('click','#comloadmore', function(){
       $('.cd-box:first').clone().appendTo('.tab-pane');     
   }); 
        
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$this->registerCssFile('@backendAssets/global/css/plugins.min.css');
$this->registerCssFile('@backendAssets/global/css/components.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
