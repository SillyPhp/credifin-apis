<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

//echo $this->render('/widgets/header/secondary-header', [
//    'for' => 'Questionnaire',
//]);
?>

    <div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                         alt="<?= Yii::t('account', 'Loading'); ?>" class="loading">
                    <span> &nbsp;&nbsp;<?= Yii::t('account', 'Loading'); ?>... </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3>Process Applications of candidates</h3>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            foreach ($users as $u) {
                                ?>
                                <div class="row cd-box">
                                    <div class="cd-can-box">
                                        <div class="cd-box-border" id="cd-box-border">
                                            <div class="row">
                                                <div class=" cd-user-icon col-md-6">
                                                    <a href="#"
                                                       target="_blank">
                                                        <canvas class="user-icon" name="test" width="80" height="80" font="35px"></canvas>
                                                    </a>
                                                    <div class="cand-name">
                                                        <a href="#" target="_blank">
                                                            <?= $u['appliedEnc']['name'] ?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="vj-btn col-md-6">
                                                    <a href="<?= Url::to('/' . $u['username']);?>">View Profile</a>
                                                </div>
                                            </div>
                                                <div class="row margn">
                                                    <div class="col-md-5 col-sm-12 col-xs-12">
                                                        <div class="cmp-profile">
                                                            <div class="cmp-logo">
                                                                <img src="https://www.empoweryouth.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/W10EsCvmo-75qtYr9L77yP1BrP6Q2I5c/WYn1kN3q6R6KAGmB3mNVoglZbMv0OE.png"
                                                                     class="user-icon" style="width: 100%;">
                                                            </div>
                                                            <div class="inline">
                                                                <h3 class="cmp-name"><?= $u['appliedEnc']['applicationEnc']['organizationEnc']['name'] ?></h3>
                                                                <h5 class="cmp-desg"><?= $u['appliedEnc']['applicationEnc']['organizationEnc']['slug'] ?></h5>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 floating col-sm-12 col-xs-12">
                                                        <div class="row">
                                                            <div class="col-md-12 padd">
                                                                <div class="steps-form-2">
                                                                    <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
                                                                        <?php
                                                                          foreach ($u['appliedEnc']['appliedApplicationProcesses'] as $d) {
                                                                        ?>
                                                                        <div class="steps-step-2 ">
                                                                            <a type="button"
                                                                               class="circle-group btn btn-circle-2 waves-effect btn-blue-grey current"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top" title=""
                                                                               data-id="jL9zWvg3wlJxz9GN0PM5ypoqEG6OB1"
                                                                               data-original-title="<?= $d['field_name']; ?>">
                                                                                <i class="<? $d['icon']; ?>"
                                                                                   aria-hidden="true"></i>
                                                                            </a>
                                                                        </div>
                                                                        <?php
                                                                          }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!--                                            <div class="row">-->
                                            <!--                                                <div class="col-md-4 col-sm-12 col-xs-12">-->
                                            <!--                                                    <div class="cmp-profile">-->
                                            <!--                                                        <div class="cmp-logo">-->
                                            <!--                                                            <img src="https://www.empoweryouth.com/images/organizations/logo/RD5x8awsjAU9zZVE3ScxAbsfphlaNgKgATbEU3Y6i0P4HKNPbP/W10EsCvmo-75qtYr9L77yP1BrP6Q2I5c/WYn1kN3q6R6KAGmB3mNVoglZbMv0OE.png"-->
                                            <!--                                                                 class="user-icon" style="width: 100%;">-->
                                            <!--                                                        </div>-->
                                            <!--                                                        <div class="inline">-->
                                            <!--                                                            <h3 class="cmp-name">empower youth</h3>-->
                                            <!--                                                            <h5 class="cmp-desg">web designer</h5>-->
                                            <!---->
                                            <!--                                                        </div>-->
                                            <!--                                                    </div>-->
                                            <!--                                                </div>-->
                                            <!--                                                <div class="col-md-8 floating col-sm-12 col-xs-12">-->
                                            <!--                                                    <div class="row">-->
                                            <!--                                                        <div class="col-md-12 padd">-->
                                            <!--                                                            <div class="steps-form-2">-->
                                            <!--                                                                <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">-->
                                            <!--                                                                    <div class="steps-step-2 ">-->
                                            <!--                                                                        <a type="button"-->
                                            <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey current"-->
                                            <!--                                                                           data-toggle="tooltip"-->
                                            <!--                                                                           data-placement="top" title=""-->
                                            <!--                                                                           data-id="jL9zWvg3wlJxz9GN0PM5ypoqEG6OB1"-->
                                            <!--                                                                           data-original-title="Get Applications">-->
                                            <!--                                                                            <i class="fa fa-sitemap"-->
                                            <!--                                                                               aria-hidden="true"></i>-->
                                            <!--                                                                        </a>-->
                                            <!--                                                                    </div>-->
                                            <!--                                                                    <div class="steps-step-2 ">-->
                                            <!--                                                                        <a type="button"-->
                                            <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                            <!--                                                                           data-toggle="tooltip"-->
                                            <!--                                                                           data-placement="top" title=""-->
                                            <!--                                                                           data-id="EV8KoxNaQZzMAegqqQPqyp539GLgXD"-->
                                            <!--                                                                           data-original-title="Technical Inteview">-->
                                            <!--                                                                            <i class="fa fa-cogs"-->
                                            <!--                                                                               aria-hidden="true"></i>-->
                                            <!--                                                                        </a>-->
                                            <!--                                                                    </div>-->
                                            <!--                                                                    <div class="steps-step-2 ">-->
                                            <!--                                                                        <a type="button"-->
                                            <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                            <!--                                                                           data-toggle="tooltip"-->
                                            <!--                                                                           data-placement="top" title=""-->
                                            <!--                                                                           data-id="LREdPVpMwyooRen33AP6y3kGB1Ye4r"-->
                                            <!--                                                                           data-original-title="HR Interview">-->
                                            <!--                                                                            <i class="fa fa-user-circle"-->
                                            <!--                                                                               aria-hidden="true"></i>-->
                                            <!--                                                                        </a>-->
                                            <!--                                                                    </div>-->
                                            <!--                                                                    <div class="steps-step-2 ">-->
                                            <!--                                                                        <a type="button"-->
                                            <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                            <!--                                                                           data-toggle="tooltip"-->
                                            <!--                                                                           data-placement="top" title=""-->
                                            <!--                                                                           data-id="EV8KoxNaQZzMAegqWVxnyp539GLgXD"-->
                                            <!--                                                                           data-original-title="Video Call">-->
                                            <!--                                                                            <i class="fa fa-video-camera"-->
                                            <!--                                                                               aria-hidden="true"></i>-->
                                            <!--                                                                        </a>-->
                                            <!--                                                                    </div>-->
                                            <!--                                                                    <div class="steps-step-2 ">-->
                                            <!--                                                                        <a type="button"-->
                                            <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                            <!--                                                                           data-toggle="tooltip"-->
                                            <!--                                                                           data-placement="top" title=""-->
                                            <!--                                                                           data-id="rND6P3qwg7D0z3qOYRg674ajv0oeAQ"-->
                                            <!--                                                                           data-original-title="Written Examination">-->
                                            <!--                                                                            <i class="fa fa-pencil-square-o"-->
                                            <!--                                                                               aria-hidden="true"></i>-->
                                            <!--                                                                        </a>-->
                                            <!--                                                                    </div>-->
                                            <!--                                                                    <div class="steps-step-2 ">-->
                                            <!--                                                                        <a type="button"-->
                                            <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                            <!--                                                                           data-toggle="tooltip"-->
                                            <!--                                                                           data-placement="top" title=""-->
                                            <!--                                                                           data-id="rND6P3qwg7D0z3qOYWqP74ajv0oeAQ"-->
                                            <!--                                                                           data-original-title="Employee Verification">-->
                                            <!--                                                                            <i class="fa fa-check"-->
                                            <!--                                                                               aria-hidden="true"></i>-->
                                            <!--                                                                        </a>-->
                                            <!--                                                                    </div>-->
                                            <!--                                                                    <div class="steps-step-2 ">-->
                                            <!--                                                                        <a type="button"-->
                                            <!--                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey "-->
                                            <!--                                                                           data-toggle="tooltip"-->
                                            <!--                                                                           data-placement="top" title=""-->
                                            <!--                                                                           data-id="d8WwBN62KlBn2eGN6zj2ljpEJLD9mv"-->
                                            <!--                                                                           data-original-title="Hire Applicants">-->
                                            <!--                                                                            <i class="fa fa-paper-plane"-->
                                            <!--                                                                               aria-hidden="true"></i>-->
                                            <!--                                                                        </a>-->
                                            <!--                                                                    </div>-->
                                            <!--                                                                </div>-->
                                            <!--                                                            </div>-->
                                            <!--                                                        </div>-->
                                            <!--                                                    </div>-->
                                            <!--                                                </div>-->
                                            <!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerCss('
.cand-name{
    font-weight: bold;
    font-size: 16px;
    }
.margn{
    margin-top:20px;
    }
.cmp-logo{
    width: 65px;
    border: 5px solid #f9f9f9;
    border-radius: 4px;
    float: left;
    margin-right: 10px;
    background-color: #fff;
    margin-left:50px;
    }
.cmp-name{
    float:left;
    margin-top: 0;
    font-weight: 500;
    color: #555;
    text-transform:capitalize;
    }
.cmp-desg{
    float: left;
    clear: both;
    font-weight: 500;
    color: #777;
    margin:0px;
    }
.inline{
    display: inline-block;
    }

.floating{
    float:right;
    }
.cmp-profile{
    margin-bottom:40px;
    }
.padd{
    margin-bottom:40px;
    }
.btn_hired{
    background-color: #8dd644;
    color: #fff;
    border: #8dd644;
}  
.btn_reject{
    background-color: #ff0000;
    color: #fff;
    border: #8dd644;
}
.btn_reject_temp{
    background-color: #ff0000;
    color: #fff;
    border: #8dd644;
    display:none;
}
.btn_hired_temp{
    background-color: #8dd644;
    color: #fff;
    border: #8dd644;
    display:none;
}
/*new*/
.slide-btn{
    text-align:center;
    margin-bottom:-1px;
    padding-top:10px;
}
.slide-bttn{
    background:#00a0e3;
    border:none;
    color:#fff;
    border-radius:10px 10px 0 0 !important;
    padding:1px 15px;
}
.slide-bttn:hover{
    box-shadow:0px -2px 8px rgba(0, 0, 0, .3);
    transition:.3s all;     
    -webkit-transition:.3s all;     
    -moz-transition:.3s all;     
    -o-transition:.3s all; 
}
.slide-bttn:focus{
    outline:none;
}
/*new ends*/
.cd-box-border-hide{
    border:2px solid #eef1f4; 
    border-top:none;
    padding:10px 20px 0 10px; 
    background:#fff; 
    border-radius:0 0 10px 10px !important; 
    color:#999999;
    margin:0 20px; 
    display:none; 
}   
.btn.btn-outline.blue {
    border-color: #00a0e3;
    color: #00a0e3;
    background: 0 0;
}
.btn.btn-outline.blue:hover {
    border-color: #00a0e3 !important;
    color:#fff ;
    background:#00a0e3 !important;
}
.vj-btn{
    text-align:right;
    margin-top: -7px;
    right: 8px;
}
.vj-btn a{
    background:#00a0e3;
    padding:5px 10px;
    font-size:13px;
     color:#fff;
    border-radius:0 0 10px 10px !important; 
}
.vj-btn a:hover{
    box-shadow:0 4px 4px rgba(0,0,0,0.3);
    transition:.3s all;     
    -webkit-transition:.3s all;     
    -moz-transition:.3s all;     
    -o-transition:.3s all;     
}
.cd-can-box{
    text-align-center !important; 
    margin-top:60px;
} 
//.cd-user-icon{margin:0 auto;}
.cd-user-icon img, .cd-user-icon canvas{
    max-width:80px; 
    height:80px; 
    margin-top:-50px;
    border-radius: 6px!important;
}
.cd-user-detail{padding:10px 0px 0 15px; }
.cd-box{
    margin-bottom:3px;
    padding:5px 15px;
}
.cd-box-border{
    border:2px solid #eef1f4; 
    padding:10px 20px 0 10px;
    background:#fff; 
    border-radius:10px !important;
    color:#999999; 
}
.cd-box-border:hover{
    box-shadow:0 0 20px rgb(0,0,0,.1); 
    background-image: url(' . Url::to('@eyAssets/images/pages/dashboard/cd-box-bg.jpg') . ');
    background-size:cover; color:#000 !important;
}                    
.cd-u-name{
    font-weight:bold; 
    font-size:16px; 
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
    margin:20px 0 0 0;
}
.portlet.light .portlet-body{
    padding-top:0px;
}
.tooltip-inner {
    background-color: #00acd6 !important;
    color: #fff;
    padding:5px 10px;
    border-radius:20px !important;
}
.tooltip.top .tooltip-arrow {
    border-top-color: #00acd6;
}
a:hover{
    text-decoration:none;
}

/*stepbar css*/

.steps-form-2 {
    display: table;
    width: 100%;
    position: relative; 
}    
.steps-form-2 .steps-row-2 {
    display: table-row; 
}
.steps-form-2 .steps-row-2 .steps-step-2:before {
    top: 33px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 2px;
    background-color:#eee; 
    background: linear-gradient(to right, #00a0e3 50%, #eee 50%);
    background-size: 200% 100%;
    background-position:right bottom;
    transition:all 1s ease;
}
.steps-form-2 .steps-row-2 .steps-step-2.active:before {
    top: 33px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 2px;
    background-color:#eee; 
    background: linear-gradient(to right, #00a0e3 50%, #eee 50%);
    background-size: 200% 100%;
    background-position:left bottom;
    transition:all 1s ease;
}
.steps-form-2 .steps-row-2 .steps-step-2:last-child::before{
    content:"";
    display:none;
}
//.steps-form-2 .steps-row-2 .steps-step-2.active:after{
//   top: 33px;
//    bottom: 0;
//    position: absolute;
//    content: " ";
//    width: 100%;
//    height: 2px;
//    background-color:#00a0e3 !important; 
//}
.steps-form-2 .steps-row-2 .steps-step-2 {
    display: table-cell;
    text-align: center;
    position: relative; 
}
.steps-form-2 .steps-row-2 .steps-step-2 p {
    margin-top: 0.5rem; 
}
.steps-form-2 .steps-row-2 .steps-step-2 button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important; 
}
.steps-form-2 .steps-row-2 .steps-step-2 .btn-circle-2 {
    width: 50px;
    height: 50px;
    border: 2px solid #eee;
    background-color: #fff !important;
    color: #eee !important;
    border-radius: 50% !important;
    padding: 18px 0px 15px 0px;
    margin-top: 8px; 
}
.steps-form-2 .steps-row-2 .steps-step-2 .btn-circle-2:hover,
.steps-form-2 .steps-row-2 .steps-step-2 .active{
    border: 2px solid #00a0e3;
    color: #fff !important;
    background-color: #00a0e3 !important; 
}
.steps-form-2 .steps-row-2 .steps-step-2 .current{
      border: 2px solid #00a0e3;
    color: #00a0e3 !important;
    background-color: #fff !important; 
}
.steps-form-2 .steps-row-2 .steps-step-2 .btn-circle-2 .fa {
    font-size: 18px; 
}
@media only screen and (max-width: 675px){
    .steps-form-2, .steps-form-2 .steps-row-2, .steps-form-2 .steps-row-2 .steps-step-2 {
        display: block;
    }
    .steps-form-2 .steps-row-2 .steps-step-2 .btn-circle-2{
        margin-top: 18px;
    }
    .steps-form-2 .steps-row-2 .steps-step-2:before, .steps-form-2 .steps-row-2 .steps-step-2.active:before{
        top: 33px;
        left: 49.9%;
        width: 2px;
        height: 57px;
    }
     .vj-btn{
        margin-top: 0px;
        right: 0px;
    }
    .vj-btn a{
        display: inline-block;
        border-radius: 4px !important;
        margin: 5px;
    }
}
@media only screen and (max-width: 388px) and (min-width: 300px){
.cmp-logo{margin:auto}
}
');
$script = <<<JS
$('[data-toggle="tooltip"]').tooltip();

$(document).on('click','.slide-bttn',function()
    {   
     $(this).closest('.cd-can-box').find('.cd-box-border-hide').slideToggle('slow');
   })  

$(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('href'));   
});
$(document).on('click', '.approve', function() {
    var field_id = $(this).parent().prev('div').find('.current').attr('data-id');  
    var app_id = $(this).val();
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
       success:function(data)
           {
            res = JSON.parse(data);
            if(res.status==true)
                {
                  disable(btn);
                  run(btn);
                  hide_btn(res,total,btn,btn2,btn3); 
                }
            else
            {
               disable(btn);
               alert('something went wrong..');
            }
          }
       }) 
});
   
        function hide_btn(res,total,thisObj,thisObj1,thisObj2)
        {  
       if(res.active==total)
        {
          thisObj.hide();
          thisObj1.hide();
          thisObj2.show();
        }
        }
        
   $(document).on('click','.reject',function()
            {
             var btn = $(this);
             var btn2 = $(this).prev();
             var btn3 = $(this).next();
             var app_id = $(this).val();
              $.ajax({
                 url:'/account/jobs/reject-candidate',
                 data:{app_id:app_id},
                 method:'post',
                 beforeSend:function()  {
                    btn.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                    btn.attr("disabled","true");
                    },    
            success:function(data)
           {
               if(data==true)
                    {
                      btn.hide();
                      btn2.hide();
                      btn3.show();
                    }
              else
            {
               alert('something went wrong..');
            }
            } 
            }) });   
  function disable(thisObj){thisObj.html('APPROVE');thisObj.removeAttr("disabled");}          
            
   function run(thisObj)
       {
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
?>