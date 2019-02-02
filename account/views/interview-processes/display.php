<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

    <div class="row">
        <div class="col-md-5 col-md-offset-7">
            <div class="col-md-4">
                <a class="btn btn-primary custom-buttons" href="/account/jobs/application">
                    Create a Job
                </a>
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
                <!--      <a class="btn btn-primary custom-buttons" href="/account/companies">
                                   Add new company
                                </a>-->
                <?=
                Html::button('Add New Company', [
                    'class' => 'btn btn-primary custom-buttons',
                    'url' => Url::to('/' . Yii::$app->controller->id . '/' . 'company-form'),
                    'id' => 'open-modal',
                    'data-toggle' => 'modal',
                    'data-target' => '#add-new',
                ]);
                ?>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Interview Process</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_actions_pending">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row cd-box">
                                        <div class="col-md-12 process-box">
                                            <div class="cd-can-box">
                                                <div class="cd-box-border" id="cd-box-border">
                                                    <div class="row">
                                                        <div class="vj-btn">
                                                            <span><?= $process_name['process_name'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="steps-form-2">
                                                                <div class="steps-row-2 setup-panel-2 d-flex justify-content-between">
                                                                    <?php
                                                                    $len = count($process_fields);
                                                                    $i = 0;
                                                                    foreach($process_fields as $p){
                                                                        $i++;
                                                                        ?>

                                                                        <div class="steps-step-2 <?php if($len != $i){echo 'active';} else{ echo '';} ?>">
                                                                            <a type="button" class="btn btn-circle-2 waves-effect btn-blue-grey current" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= $p['field_name'] ?>">
                                                                                <i class="<?= $p['icon']; ?>" aria-hidden="true"></i>
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
select{
    padding:5px 10px; border-radius:5px !important;
}
select:focus{
    outline:none;
}
.cd-box-border-hide{
            border:2px solid #eef1f4; border-top:none; padding:10px 20px; background:#fff; 
            border-radius:0 0 10px 10px !important; color:#999999; margin:0 20px; display:none;   
}  
 .multiselect-container>li>a>label {
  padding: 0px 20px 0px 20px;
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
    text-align:center;
    margin-top: -7px;
} 
.vj-btn span{
    background:#00a0e3;
    padding:5px 10px;
    font-size:13px;
    color:#fff;
    border-radius:0 0 10px 10px !important; 
}
.vj-btn span:hover{
    box-shadow:0 4px 4px rgba(0,0,0,0.5);
}
.cd-can-box{
    text-align-center !important; 
    margin-top:60px;
} 
//.cd-user-icon{margin:0 auto;}
.cd-user-icon img{
    max-width:80px; 
    height:80px; 
    margin-top:-50px;
}
//.cd-user-detail{
//    padding:10px 0px 0 15px;
//}
.cd-box{
    margin-bottom:3px;
    padding:5px 15px;
}
.cd-box-border{
    border:1px solid #eee; 
    padding:10px 20px; background:#fff; 
    border-radius:10px !important; 
    color:#999999; 
}
.cd-box-border:hover{
    box-shadow:0 0 20px rgb(0,0,0,.1); 
//    background-image: url(' . Url::to('@eyAssets/images/pages/dashboard/cd-box-bg.jpg') . ');
    background-size:cover; color:#000 !important;
}                    
//.cd-u-name{
//    font-weight:bold; 
//    font-size:16px; 
//}
//.cd-u-field{font-size:16px;  }
//.cd-u-p-company{font-size:14px;}
.cd-btns{ 
    text-align:center;
    padding-top:35px !important;
}
.cd-btns button i{
    font-size:16px;
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
.js-title-step span{
    display:none;
}
.custom-buttons{
    width:100%;
    font-size: 10px !important;
    padding: 8px 0px !important;
    margin-bottom:20px;
}
a:hover{
    text-decoration:none;
}

/*stepbar css*/

.steps-form-2 {
    display: table;
    width: 100%;
    position: relative; 
    padding-top:20px;
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
}
.steps-form-2 .steps-row-2 .steps-step-2:last-child::before{
    content:"";
    display:none;
}
.steps-form-2 .steps-row-2 .steps-step-2.active:after{
   top: 33px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 2px;
    background-color:#00a0e3 !important; 
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
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

//#checkboxes {
//  display: none;
//  border: 1px #dadada solid;
//}
//
//#checkboxes label {
//  display: block;
//}
//
//#checkboxes label:hover {
//  background-color: #1e90ff;
//}
');
$script = <<<JS
$('[data-toggle="tooltip"]').tooltip();
        
$('#chkveg').multiselect({
    includeSelectAllOption: true
});

//$('#btnget').click(function() {
//    alert($('#chkveg').val());    
//}); 
 
$('.cd-box-border').click(function(){
    $(this).closest('.cd-can-box').find('.cd-box-border-hide').slideToggle('slow');
});   
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/css/plugins.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/css/components.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('/assets/themes/backend/vendor/bootstrap-multiselect/bootstrap-multiselect.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('/assets/themes/backend/vendor/bootstrap-multiselect/bootstrap-multiselect.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
