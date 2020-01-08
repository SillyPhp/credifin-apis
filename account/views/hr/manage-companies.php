<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<section>
    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="col-md-4">
                <!--      <a class="btn btn-primary custom-buttons" href="/account/companies">
                                   Add new company
                                </a>-->
                <?=
                Html::button('Add New Company', [
                    'class' => 'btn btn-primary custom-buttons',
                    'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'company-form'),
                    'id' => 'open-modal2',
                    'data-toggle' => 'modal',
                    'data-target' => '#add-new-comp',
                ]);
                ?>
            </div>
        </div>      
    </div>
</section>
<div>
    <div class="row widget-row">
        <div class="col-md-12">
            <div class="col-md-3 col-sm-6">
                <a href="#">
                    <div class="box-des box3 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/company.png') ?>">
                        <span class="count">100+</span>
                        <span class="box-text">Total Companies</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="#">
                    <div class="box-des box1 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/internship.png') ?>">
                        <span class="count">10</span>
                        <span class="box-text">Companies Hiring</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="#">
                    <div class="box-des box6 mt">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/intrnship.png') ?>">
                        <span class="count">10</span>
                        <span class="box-text">Closed</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6">
                <a href="#">
                    <div class="box-des box4 mt box2set">
                        <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/candidates.png') ?>">
                        <span class="count">20</span>
                        <span class="box-text">Immediate Hiring</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
    <div class="modal fade" id="add-new-comp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="org-info">Organization Information</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="comp-logo">
                                <img src="/assets/themes/ey/images/pages/hr-recruiters/1job.png">
                            </div>
                            <div class="add-photo">
                                <i class="fa fa-plus" style="position: absolute;bottom: 40px;left: 55px;"></i>
                                <span style="position: absolute;bottom: 16px;left: 31px;font-size:12px;">Add photo</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" placeholder="Organization Name"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="email" class="form-control" placeholder="Organization E-mail"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="text" class="form-control" placeholder="Website"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <input type="tel" class="form-control" placeholder="Phone No.">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>Select Business Activity</option>
                                <option>Banking & Finance</option>
                                <option>Educational Institute</option>
                                <option>Schools</option>
                                <option>Colleges</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padd">
                            <div class="form-group form-md-line-input form-md-floating-label">
                                <textarea id="form7" class="md-textarea form-control" rows="5   "></textarea>
                                <label for="form7">Description</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 align">
                            <div class="form-group">
                                <ul class="ks-cboxtags">
                                    <li class="service-list">
                                        <input type="checkbox" id="services" class="checkbox-input services"/>
                                        <label for="services">
                                            Jobs
                                        </label>
                                    </li>
                                    <li class="service-list">
                                        <input type="checkbox" id="services2" class="checkbox-input services"/>
                                        <label for="services2">
                                            Internships
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary">Save</a>
                </div>
            </div>
        </div>
    </div>
<!--modal end-->
  <div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class=" icon-social-twitter font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Total Companies</span>
                </div>
                <div class="actions">
                    <!--<div class="dashboard-button">-->
                        <a href="<?= Url::to('/account/shortlist-companies') ?>" title="" class="viewall-jobs">View All</a>
                    <!--</div>-->
                </div>
            </div>
            <div class="portlet-body">
<!--                <div class="tab-content">
                    <div class="tab-pane active" id="tab_actions_pending">-->
                        <!-- BEGIN: Actions -->
                        <div class="row">
                            <?php
                            Pjax::begin(['id' => 'pjax_org']);
                            if ($shortlist_org) {
                                foreach ($shortlist_org as $shortlist) {
                                    $logo = $shortlist['logo'];
                                    ?>
                                    <div class="col-md-3 hr-j-box">
                                        <div class="topic-con"> 
                                            <div class="hr-company-box">
                                                <a href="/company/<?= $shortlist['slug']; ?>"> 
                                                    <div class="hr-com-icon">
                                                        <?php
                                                        if (empty($shortlist['logo_location'])) {
                                                            ?>
                                                            <canvas class="user-icon" name="<?= $shortlist['org_name'] ?>" width="80" height="80" font="35px"></canvas>
                                                            <?php
                                                        } else {
                                                            $logo_location = $shortlist['logo_location'];
                                                            $logo_image = Yii::$app->params->upload_directories->organizations->logo . $logo_location . DIRECTORY_SEPARATOR . $logo;
                                                            $logo_base_path = Yii::$app->params->upload_directories->organizations->logo_path . $logo_location . DIRECTORY_SEPARATOR . $logo;
                                                            if (!file_exists($logo_base_path)) {
                                                                $logo_image = "http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=No+Logo";
                                                            }
                                                            ?>
                                                        <img src="<?= Url::to($logo_image); ?>" class="img-responsive ">
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="hr-com-name">
                                                        <?= $shortlist['org_name']; ?>
                                                    </div>
                                                    <div class="hr-com-field">
                                                        <?= $shortlist['industry']; ?>
                                                    </div>
                                                </a>
                                                <div class="hr-com-jobs">
                                                    <div class="row">
                                                        <div class="col-md-1 j-cross"><button value="<?= $shortlist['shortlisted_enc_id']; ?>" class="rmv_org"><i class="fa fa-times"></i></button></div> 
                                                        <div class="col-md-offset-3 col-md-6 minus-15-pad j-grid"> 
                                                            <a  href="/company/<?= $shortlist['slug']; ?>" title="">VIEW PROFILE</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="col-md-12">
                                    <div class="tab-empty"> 
                                        <div class="tab-empty-icon">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?>" class="img-responsive" alt=""/>
                                        </div>
                                        <div class="tab-empty-text">
                                            <div class="">There are no companies to show.</div>
                                            <div class="">You haven't Shortlisted any Company.</div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            Pjax::end();
                            ?>
                        </div>
                        <!-- END: Actions -->
<!--                    </div>
                </div>-->
            </div>
        </div> 
    </div> 
</div>      
<?php
$this->registerCss('
.comp-logo img{
    width: 90px;
    height: 90px;
    border: 4px solid #fff;    
}
.remove-cand{
    position: absolute;
    right: 12px;
    top: 25px;
}
.add-cand-set{
    padding-left: 35px;
    color: cornflowerblue;
    cursor:pointer;
}
ul.ks-cboxtags {
    list-style: none;
    padding:0px;
}
.service-list{
  display: inline-block;
  min-width: 120px;
}
.service-list label{
    width: 100%;
    display: inline-block;
    background-color: rgba(255, 255, 255, .9);
    border: 2px solid rgba(139, 139, 139, .3);
    color: #333;
    border-radius: 4px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s;
}

.service-list label {
    padding: 8px 12px;
    cursor: pointer;
}

.service-list label::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-family: \'Font Awesome 5 Free\';
    font-weight: 900;
    font-size: 12px;
    padding: 2px 6px 2px 2px;
    content: \'067\';
    transition: transform .3s ease-in-out;
}

.service-list input[type=\'checkbox\']:checked + label::before {
    content: \'00c\';
    transform: rotate(-360deg);
    transition: transform .3s ease-in-out;
}

.service-list input[type=\'checkbox\']:checked + label, .service-list label:hover {
    border: 2px solid #00a0e3;
    background-color: #00a0e3;
    color: #fff;
    transition: all .2s;
}

.service-list input[type=\'checkbox\'] {
  display: absolute;
}
.service-list input[type=\'checkbox\'] {
  position: absolute;
  opacity: 0;
}
.service-list input[type=\'checkbox\']:focus + label {
  border: 2px solid #00a0e3;
}
.align{text-align:center;}
.padd{padding-top:10px;}
.org-info{
    font-size:22px;    
}
.box1{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1job.png");}
.box2{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1company.png");}
.box3{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1internship.png");}
.box4{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1institute.png");}
.box5{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/1school.png");}
.box6{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/college.png");}
.box7{ background-image: url("/assets/themes/ey/images/pages/hr-recruiters/g.png");}
.box-des {
   background-size: 100% 100%;
   background-repeat: no-repeat;
   position: relative;
   height: 160px;
}
.mt{margin-bottom:15px;}
.box-des img{
   position: absolute;
   max-width: 63px;
   right: 25px;
   top: 15px;
}
.box2set img{
    max-width: 80px !important;
}
.box-text {
   position: absolute;
   bottom: 3px;
   left: 16px;
   color: white;
   font-size: 21px;
   font-family: roboto;
}
.count {
   position: absolute;
   bottom: 28px;
   left: 16px;
   color: white;
   font-size: 30px;
   font-family: roboto;
}
.hr-company-box{
    border-radius:10px !important; 
}                      
.hr-com-icon{
    padding:10px 0;
}
.hr-com-name{
    padding-top:20px;
}
.hr-com-jobs{
    padding:20px 0px 0px 0px !important; 
    text-align:center;
}            
#view-all{
    margin-top:5px;
}
.tab-empty{
    padding:20px;
}
.tab-empty-icon img{
    max-width:200px; 
    margin:0 auto;
}
.tab-empty-text{
    text-align:center; 
    font-size:35px; 
    font-family:lobster; 
    color:#999999; 
    padding-top:20px;
}

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
    margin-top:00px;
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
    border-bottom:2px solid #ecf7fc;
    padding:10px 20px;
    background:#fff; 
    border-radius:10px !important; 
    color:#fff;
    background-image: url(' . Url::to('@eyAssets/images/pages/dashboard/cd-box-bg.png') . ');
    background-size:cover; 
    background-repeat: no-repeat;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
}
.cd-box-border:hover{
    box-shadow:0 0 20px rgb(0,0,0,.1); 
    background-image: url(' . Url::to('@eyAssets/images/pages/dashboard/cd-box-bg-hover.png') . ');
    background-size:cover; 
    background-repeat: no-repeat;
    color:#fff !important;
    transition:.2s all;
    -webkit-transition:.2s all;
    -moz-transition:.2s all;
    -o-transition:.2s all;
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
    margin:100px 0 0 0;
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
