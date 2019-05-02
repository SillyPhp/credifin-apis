<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
echo $this->render('/widgets/header/secondary-header', [
    'for' => 'Questionnaire',
]);
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
                            <h3>Process Applications of <?= $application_name['job_title']; ?></h3>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_actions_pending">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row cd-box">
                                        <?php
                                        if (!empty($fields)) {
                                            foreach ($fields as $arr) {
                                                ?>
                                                <div class="cd-can-box">
                                                    <div class="cd-box-border" id="cd-box-border">
                                                        <div class="row">
                                                            <div class=" cd-user-icon col-md-6">
                                                                <a href="<?= '/' . $arr['username'] ?>"
                                                                   target="_blank">
                                                                    <?php if ($arr['image']): ?>
                                                                        <img src="<?= $arr['image'] ?>"
                                                                             class="img-responsive img-thumbnail img-rounded">
                                                                    <?php else: ?>
                                                                        <canvas class="user-icon"
                                                                                name="<?= $arr['name'] ?>" width="80"
                                                                                height="80" font="35px"></canvas>
                                                                    <?php endif; ?>
                                                                </a>
                                                            </div>
                                                            <div class="vj-btn col-md-6">
                                                                <?php
                                                                $cv = Yii::$app->params->upload_directories->resume->file . $arr['resume_location'] . DIRECTORY_SEPARATOR . $arr['resume'];
                                                                ?>
                                                                <a href="<?= $cv ?>">Download
                                                                    Resume</a>
                                                                <a href="<?= '/' . $arr['username'] ?>">View
                                                                    Profile</a>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="cd-user-detail col-md-2">
                                                                <div class="cd-u-name">
                                                                    <a href="<?= '/' . $arr['username'] ?>"
                                                                       target="_blank">
                                                                        <?= $arr['name'] ?>
                                                                    </a>
                                                                </div>
                                                                <div class="cd-u-field"></div>
                                                                <div class="cd-u-p-company"></div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="steps-form-2">
                                                                            <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
                                                                                <?php
                                                                                $len = count($arr['appliedApplicationProcesses']);
                                                                                $j = 0;
                                                                                foreach ($arr['appliedApplicationProcesses'] as $p) {
                                                                                    ?>
                                                                                    <div class="steps-step-2 <?php
                                                                                    if ($j < $arr['active']) {
                                                                                        echo 'active';
                                                                                    } else {
                                                                                        echo '';
                                                                                    }
                                                                                    ?>">
                                                                                        <a type="button"
                                                                                           class="circle-group btn btn-circle-2 waves-effect btn-blue-grey <?php
                                                                                           if ($j < $arr['active']) {
                                                                                               echo 'active';
                                                                                           } elseif ($j == $arr['active']) {
                                                                                               echo 'current';
                                                                                           }
                                                                                           ?>" data-toggle="tooltip"
                                                                                           data-placement="top" title=""
                                                                                           data-id="<?= $p['field_enc_id'] ?>"
                                                                                           data-original-title="<?= $p['field_name'] ?>">
                                                                                            <i class="<?= $p['icon'] ?>"
                                                                                               aria-hidden="true"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                    <?php
                                                                                    $j++;
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="cd-btns col-md-2">
                                                                <?php if ($arr['status'] == 'Hired') { ?>
                                                                    <button type="button"
                                                                            class="btn btn-outline btn-circle btn-sm btn_hired">
                                                                        <i class="glyphicon glyphicon-ok"></i>Hired
                                                                    </button>
                                                                <?php } elseif ($arr['status'] == 'Rejected') { ?>
                                                                    <button type="button"
                                                                            class="btn btn-outline btn-circle btn-sm btn_reject">
                                                                        <i class="glyphicon glyphicon-remove"></i>Rejected
                                                                    </button>
                                                                <?php } else { ?>
                                                                    <button type="button"
                                                                            class="btn btn-outline btn-circle btn-sm btn_hired_temp">
                                                                        <i class="glyphicon glyphicon-ok"></i>Hired
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-outline btn-circle blue btn-sm approve"
                                                                            value="<?= $arr['applied_application_enc_id']; ?>"
                                                                            data-total="<?= $arr['total']; ?>">Approve
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-outline btn-circle blue btn-sm reject"
                                                                            value="<?= $arr['applied_application_enc_id']; ?>">
                                                                        Reject
                                                                    </button>
                                                                    <button type="button"
                                                                            class="btn btn-outline btn-circle btn-sm btn_reject_temp">
                                                                        <i class="glyphicon glyphicon-remove"></i>Rejected
                                                                    </button>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="slide-btn">
                                                                    <button class="slide-bttn" type="button">
                                                                        <i class="fa fa-angle-double-down"
                                                                           aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="cd-box-border-hide">
                                                        <?php if (!empty($que)) { ?>
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Question</th>
                                                                    <th>Process Name</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="qu_data">
                                                                <?php foreach ($que as $list_que) { ?>
                                                                    <tr>
                                                                        <td><a class="blue question_list"
                                                                               href="/account/questionnaire/display-answers/<?= $list_que['qid']; ?>/<?= $arr['applied_application_enc_id']; ?>"
                                                                               data-questionId="<?= $list_que['qid']; ?>"
                                                                               data-appliedId="<?= $arr['applied_application_enc_id']; ?>"
                                                                               target="_blank"><?= $list_que['name']; ?></a>
                                                                        </td>
                                                                        <td><?= $list_que['field_label']; ?></td>

                                                                    </tr>
                                                                <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        <?php } else { ?>
                                                            <h3>No Questionnaire To Display</h3>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php

                                            }
                                        } else {
                                            ?>
                                            <h3>No Applicant has Applied For This Post</h3>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php
$this->registerCss('
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