<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
?>
<section>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Pending Jobs</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <?php
                        Pjax::begin(['id' => 'pjax_shortlist']);
                        $total_applications = count($pending);
                        if (!empty($pending)) {
                            foreach ($pending as $pend) {
                                ?>
                                <div class="col-md-3 hr-j-box">
                                    <div class="topic-con"> 
                                        <div class="hr-company-box">
                                            <div class="hr-com-icon">
                                                <img src="<?= Url::to('@commonAssets/categories/' . $pend["icon"]); ?>" class="img-responsive ">
                                            </div>
                                            <div class="hr-com-name">
                                                <?= $pend['org_name']; ?>
                                            </div>
                                            <div class="hr-com-field">
                                                <?= $pend['title']; ?>
                                            </div>
                                            <div class="opening-txt">
                                                <?= $pend["positions"]; ?> Openings
                                            </div>
                                            <div class="overlay2">
                                                <div class="text-o"><a class="over-bttn ob2 hover_short" href="/job/<?= $pend['slug']; ?>">Apply</a></div>
                                            </div>
                                            <div class="hr-com-jobs">
                                                <div class="row ">
                                                    <div class="col-md-12 col-sm-12 minus-15-pad">
                                                        <div class=" j-cross">
                                                            <button class="rmv_list" value="<?= $pend['application_enc_id']; ?>">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div> 
                                                        <div class=" j-grid"> 
                                                            <a  href="/job/<?= $pend['slug']; ?>" title="">VIEW JOB</a>
                                                        </div>
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
                                        <div class="">There are no Jobs to show.</div>
                                        <div class="">You haven't Select any jobs for review.</div>
                                    </div>
                                </div>
                            </div>  
                            <?php
                        }
                        Pjax::end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.j-grid > a {
    font-family: Open Sans;
    font-size: 11px;
    color: #00a0e3;
    border: 1px solid #00a0e3;
    -webkit-border-radius: 20px !important;
    -moz-border-radius: 20px !important;
    -ms-border-radius: 20px !important;
    -o-border-radius: 20px !important;
    border-radius: 20px !important;
    margin:10px 0;
    padding: 6px 12px;  
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


.hr-company-box{text-align:center;border:2px solid #eef1f5; background:#fff; padding:20px 10px;
                    border-radius:14px !important; margin-bottom:20px; text-decoration:none; }
.hr-company-box:hover{border-color:#fff; box-shadow:0 0 20px rgb(0,0,0,.3); transition:.3s all;
                        text-decoration:none;} 
.hr-company-box > div:hover {text-decoration:none;}                       
.hr-com-icon{ text-align:center; text-decoration:none;  vertical-align:middle; padding:20px 0;}
.hr-com-icon img{text-align:center; margin:0 auto; max-width:100px;  max-height:100px; }
.hr-com-name{color:#00a0e3; padding-top:10px;text-decoration:none; font-size:16px;} 
.hr-com-name:hover{text-decoration:none;}                                   
.hr-com-field{padding-top:2px; font-weight:bold;font-size:14px; color:#080808;}
.hr-com-jobs{font-size:13px; color:#080808; padding:10px 0 10px; 
              margin-top:10px; border-top:1px solid #eef1f5;}            
//.pad-top-10{padding-top:10px;}
.minus-15-pad{padding-left:0px !important; padding-right:0px !important;}
.com-load-more-btn{text-align:center; padding-top:30px; }
a:hover{
    text-decoration:none;
}

');
$script = <<<JS

function Ajax_call(rmv_id,url,pjax_refresh_id)
    {
        $.ajax({
                url:url,
                data:{rmv_id:rmv_id},
                method:'post',
                beforeSend: function()
                {
                    $(".loader").css("display", "block");
                },
                success:function(data)
                       {
                        if(data == true)
                          {
                            $(".loader").css("display", "none");
                            $.pjax.reload({container: pjax_refresh_id, async: false});
                            $.pjax.reload({container: '#widgets', async: false});
                           }
                       }
              })
    }

$(document).on('click','.rmv_list',function(e)
    {
        e.preventDefault();
        if (window.confirm("Do you really want to Delete the current Application?")) {
            var  url = '/account/jobs/pending-delete';
            var rmv_id = $(this).val();
            var  pjax_refresh_id = '#pjax_shortlist';
            Ajax_call(rmv_id,url,pjax_refresh_id);
        }
   })   
 

JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$this->registerCssFile('@backendAssets/global/css/plugins.min.css');
$this->registerCssFile('@backendAssets/global/css/components.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/jquery-validation/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

function used_for($n) {
    switch ($n) {
        case 1:
            $a = 'Jobs';
            break;
        case 2:
            $a = 'internships';
            break;
        case 3:
            $a = 'Training Programs';
            break;
        default:
            $a = 'NA';
    }
    return $a;
}
