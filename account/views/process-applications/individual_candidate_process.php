<?php

use yii\helpers\Html;
use yii\helpers\Url;
//print_r($applied);
//exit;
?>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Applied Jobs</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_actions_pending">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row cd-box">
                                        <?php
                                        if (!empty($applied)) { ?>
                                            <div class="cd-can-box">
                                                <div class="cd-box-border" id="cd-box-border">
                                                    <div class="row">
                                                        <div class=" cd-user-icon col-md-6">
                                                            <a href="/job/<?= $applied['slug'] ?>" target="_blank">
                                                                <img src="/assets/common/categories/<?= $applied['icon']?>" class="img-responsive img-thumbnail img-rounded">
                                                            </a>
                                                        </div>
                                                        <div class="vj-btn col-md-6">
                                                            <a href="/job/<?= $applied['slug'] ?>">View Detail</a>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="cd-user-detail col-md-2">
                                                            <div class="cd-u-name">
                                                                <a href="/job/<?= $applied['slug'] ?>" target="_blank">
                                                                    <?= $applied['title']?>
                                                                </a>
                                                            </div>
                                                            <div class="cd-u-p-company"><a href="/<?= $applied['org_slug']?>"><?= $applied['org_name']?></a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="steps-form-2">
                                                                        <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
                                                                            <?php
                                                                            $len = count($applied['appliedApplicationProcesses']);
                                                                            $j = 0;
                                                                            foreach ($applied['appliedApplicationProcesses'] as $p) {
                                                                                ?>
                                                                                <div class="steps-step-2 <?php
                                                                                if ($j < $applied['active']) {
                                                                                    echo 'active';
                                                                                } else {
                                                                                    echo '';
                                                                                }
                                                                                ?>">
                                                                                    <a type="button" class="circle-group btn btn-circle-2 waves-effect btn-blue-grey <?php
                                                                                    if ($j < $applied['active']) {
                                                                                        echo 'active';
                                                                                    } elseif ($j == $applied['active']) {
                                                                                        echo 'current';
                                                                                    }
                                                                                    ?>" data-toggle="tooltip" data-placement="top" title=""  data-id ="<?= $p['field_enc_id'] ?>"  data-original-title="<?= $p['field_name'] ?>">
                                                                                        <i class="<?= $p['icon'] ?>" aria-hidden="true"></i>
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
                                                            <?php
                                                            if($applied['status'] == 'Cancelled') {
                                                                ?>
                                                                <button type="button" class="btn btn-outline btn-circle red btn-sm cancelled" disabled>
                                                                    Cancelled
                                                                </button>
                                                                <?php
                                                            } else{
                                                                ?>
                                                                <button value="<?= $applied['applied_application_enc_id'] ?>" type="button" class="btn btn-outline btn-circle red btn-sm cancel ">
                                                                    Cancel
                                                                </button>
                                                                <?php
                                                            }
                                                                ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } else {
                                            ?>
                                            <div class="col-md-12">
                                                <div class="tab-empty">
                                                    <div class="tab-empty-icon">
                                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/sr.png'); ?>"
                                                             class="img-responsive" alt=""/>
                                                    </div>
                                                    <div class="tab-empty-text">
                                                        <div class="">There are no Jobs to show.</div>
                                                        <div class="">You haven't apply this job.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
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
    <!-- Modal -->

<?php
$this->registerCss('
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
.cancelled{
    border-color: #e7505a !important;
    color: #fff !important;
    background-color: #e7505a !important;
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
    box-shadow:0 4px 4px rgba(0,0,0,0.5);
}
.cd-can-box{
    text-align-center !important; 
    margin-top:60px;
}
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
            border:2px solid #eef1f4; padding:10px 20px; background:#fff; 
            border-radius:10px !important; color:#999999; 
}
.cd-box-border:hover{box-shadow:0 0 20px rgb(0,0,0,.1); 
            background-image: url(' . Url::to('@eyAssets/images/pages/dashboard/cd-box-bg.jpg') . ');
            background-size:cover; color:#000 !important;
}                    
.cd-u-name{
    font-weight:bold; 
    font-size:16px; 
}
.cd-u-p-company{font-size:14px;}
.cd-btns{ text-align:center;}
.cd-btns button{margin:20px 0 0 0; }
.portlet.light .portlet-body{padding-top:0px;}

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
/* Top Radio filter css ends */
');
$script = <<<JS
$('[data-toggle="tooltip"]').tooltip();

$(document).on('click','.cancel',function(e){
    e.preventDefault();
    var data = $(this).val();
    if($(this).attr("disabled") == "disabled") {
        return false;
    }
            
     if (window.confirm("Do you really want to Cancel the current Application?")) {
        $.ajax({
            url:'/account/jobs/cancel-application',
            data:{data:data},
            method:'post',
            beforeSend:function(){
                $('.cancel').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');  
            },
            success:function(data){
              if(data==true) {
                  console.log('ok');
                  $('.cancel').addClass('cancelled');
                  $('.cancel').html('Cancelled');
                  $('.cancel').attr('disabled','disabled');
                  $('.cancel').removeClass('cancel');
                }
             }
          })
    }
          
});
   
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/css/plugins.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/css/components.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);


