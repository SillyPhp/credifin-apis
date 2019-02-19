<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
echo $this->render('/widgets/header/secondary-header', [
    'for' => 'Jobs',
]);

?>
    <div class="loader"><img src='https://gifimage.net/wp-content/uploads/2017/09/ajax-loading-gif-transparent-background-4.gif'/></div>
    <div class="row widget-row">
        <?=
        $this->render('/widgets/jobs/stats', [
            'questionnaire' => $questionnaire,
            'applications' => $applications,
            'interview_processes' => $interview_processes,
            'applied_applications' => $applied_applications,
        ]);
        ?>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Active Jobs'); ?></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/jobs/create'); ?>" class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                        <?php if ($applications['total'] > 8): ?>
                            <a href="<?= Url::toRoute('/jobs'); ?>" title="" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    Pjax::begin(['id' => 'pjax_active_jobs']);
                    if ($applications['total'] > 0) {
                        echo $this->render('/widgets/applications/card', [
                            'applications' => $applications['data'],
                            'per_row' => 4,
                        ]);
                    } else {
                        ?>
                        <h3>No Active Jobs</h3>
                    <?php }
                    Pjax::end();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Questionnaire'); ?></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/questionnaire/create'); ?>" class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                        <?php if ($questionnaire['total'] > 4): ?>
                            <a href="<?= Url::toRoute('/questionnaire'); ?>" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            Pjax::begin(['id' => 'pjax_active_questionnaire']);
                            if ($questionnaire['total'] > 0) {
                                echo $this->render('/widgets/questionnaire/card', [
                                    'questionnaire' => $questionnaire['data'],
                                    'per_row' => 2,
                                    'col_width' => 'col-lg-6 col-md-6 col-sm-6',
                                ]);
                            } else {
                                ?>
                                <h3>No Questionnaire To Display</h3>
                            <?php }
                            Pjax::end();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Interview Processes'); ?></span>
                    </div>
                    <div class="actions">
                        <a href="<?= Url::toRoute('/interview-processes/create'); ?>" class="viewall-jobs"><?= Yii::t('account', 'Add New'); ?></a>
                        <?php if ($interview_processes['total'] > 4): ?>
                            <a href="<?= Url::toRoute('/interview-processes'); ?>" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            Pjax::begin(['id' => 'pjax_active_process']);
                            if ($interview_processes['total'] > 0) {
                                echo $this->render('/widgets/processes/card', [
                                    'processes' => $interview_processes['data'],
                                    'per_row' => 2,
                                    'col_width' => 'col-lg-6 col-md-6 col-sm-6',
                                ]);
                            } else {
                                ?>
                                <h3>No Processes To Display</h3>
                            <?php }
                            Pjax::end();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'View Applications'); ?></span>
                    </div>
                    <?php
                    if ($applied_applications['total'] > 10):
                        ?>
                        <div class="actions">
                            <div class="dashboard-button">
                                <a href="javascript:;" class="viewall-jobs"><?= Yii::t('account', 'View all'); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-actions">
                                <?php
                                if (!empty($applied_applications)) { ?>
                                    <?php foreach ($applied_applications['list'] as $candiates) { ?>
                                        <div class="mt-action">
                                            <div class="mt-action-img" style="width: auto">
                                                <a href="/user/<?= $candiates['username'] ?>">
                                                    <?php if (!empty($candiates['image_location']) && !empty($candiates['image'])) { ?>
                                                        <?php $user_img = Yii::$app->params->upload_directories->users->image . $candiates['image_location'] . DIRECTORY_SEPARATOR . $candiates['image']; ?>
                                                        <img src="<?= $user_img; ?>" width="50px" height="50" class="img-circle"/>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <canvas class="user-icon img-circle" name="<?= $candiates['first_name'] . ' ' . $candiates['last_name'] ?>" width="50" height="50" font="25px"></canvas>
                                                    <?php }
                                                    ?>
                                                </a>

                                            </div>
                                            <div class="mt-action-body">
                                                <div class="mt-action-row">
                                                    <div class="mt-action-info ">
                                                        <div class="mt-action-details ">
                                                            <span class="mt-action-author"><a href="/site/candidate-profile"><?= $candiates['first_name'] . ' ' . $candiates['last_name']; ?></a></span>
                                                            <p class="mt-action-desc">Applied For <?= $candiates['name']; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-action-buttons">
                                                        <div class="btn-group btn-group-circle">
                                                            <button type="button" data-key="<?= $candiates['applied_application_enc_id'] ?>" class="btn btn-outline green btn-sm approv_btn">Approve</button>
                                                            <button type="button" data-key="<?= $candiates['applied_application_enc_id'] ?>" class="btn btn-outline red btn-sm reject_btn">Reject</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <h3>No Applications To Display</h3>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Resume Bank</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group dashboard-button">
                            <button title="" data-toggle="modal" data-target="#resumeBank" class="viewall-jobs">Add New</button>
                        </div>
                        <div class="btn-group dashboard-button">
                            <a href="/account/all-resume-profiles" title="" class="viewall-jobs">View All</a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body" id="resume-bank">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_actions_pending">
                            <!-- BEGIN: Actions -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mt-actions" style="" >
                                        <div class="row padd10">
                                            <?php foreach ($primary_fields as $p) { ?>
                                                <div class="col-md-4 col-sm-6 padd-5">
                                                    <a href="/account/candidate-resumes">
                                                        <div class="work-profile-box">
                                                            <div class="work-profile">
                                                                <?php echo $p['name'] ?> <span class="badge-num">1005</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="divider"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="resumeBank" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Categories</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <input type="text" id="text" placeholder="Search Here Or Add New Category" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="button" id="add_new_btn" class="btn btn-default">Add To The List</button>
                            </div>
                        </div>
                    </div>
                    <div class="row padd10">
                        <?php foreach ($primary_fields as $p) { ?>
                            <div class="col-md-4 col-sm-6 padd-5 work-profile-box-search">
                                <input type="radio" id="<?= $p['category_enc_id']?>" class="category-input" data-toggle="modal" data-target="#titleModal"/>
                                <label for="<?= $p['category_enc_id']?>" class="work-profile-box">
                                    <!--<div class="work-profile-box">-->
                                    <div class="work-profile">
                                        <?php echo $p['name'] ?> <span class="badge-num">1005</span>
                                    </div>
                                    <!--</div>-->
                                </label>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
<div id="titleModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Job Title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" id="text" placeholder="Search Here Or Add New Category" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" id="add_new_btn" class="btn btn-default">Add To The List</button>
                        </div>
                    </div>
                </div>
                <div class="row padd10">
                    <?php foreach ($primary_fields as $p) { ?>
                        <div class="col-md-4 col-sm-6 padd-5 work-profile-box-search">
                            <input type="checkbox" id="<?= $p['category_enc_id']?>" class="category-input"/>
                            <label for="<?= $p['category_enc_id']?>" class="work-profile-box">
                                <!--<div class="work-profile-box">-->
                                <div class="work-profile">
                                    <?php echo $p['name'] ?> <span class="badge-num">1005</span>
                                </div>
                                <!--</div>-->
                            </label>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<?php
$this->registerCss('
.loader
{
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    padding:2px;
    z-index:99999;
}
.mt-action-author a{
    color: #000;
}
.mt-actions .mt-action .mt-action-body .mt-action-row .mt-action-buttons {
    width:170px;
}
.work-profile-box{
    border: 2px solid #eef1f5;
    text-align:center;
    height:65px !important;
    display: table;
    width:100%;
    padding:0px 0 5px 0;
    position:relative;
    border-radius:12px !important;
    color:#000;
} 
.work-profile{
    display: table-cell;
    text-align: center;
    vertical-align: middle;
    padding:0 0px 0 0;
}
.work-profile-box span{
    background:#eee;
    padding:3px 8px;
    font-weight:bold;
    font-size:13px;
    border-radius:10px 0 10px 0px !important;
    position:absolute;
    bottom:0px;
    right:0px;
}
.work-profile-box:hover{
    background:#00a0e3;
    color:#fff;
    border:2px solid #00a0e3;
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.work-profile-box:hover span{
    background:#fff;
    color:#00a0e3;
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.padd10{
    padding-left:5px !important; 
    padding-right:5px !important; 
} 
.padd-5{
    padding-top:10px !important;
    padding-left:5px !important; 
    padding-right:5px !important; 
}
.category-input{
    display:none;
}
.category-input:checked + label{
    background: #00a0e3;
    color: #fff;
    border: 2px solid #00a0e3;
}
.category-input:checked + label div span{
    background: #fff;
    color: #00a0e3;
}
');
$script = <<<JS
    $(document).on('click', '.approv_btn', function (e) {
        e.preventDefault();
        var data = $(this).attr('data-key');
        $.ajax({
            url: '/account/accept-application',
            data: {data: data},
            method: 'post',
            beforeSend: function () {
            },
            success: function (data) {
            }
        });
    });
    $(document).on('click', '.remov_btn', function (e) {
        e.preventDefault();
    });

    $(document).on('click', '.share_btn', function (e) {
        e.preventDefault();
    });
    
  $(document).on('click','.j-delete',function(e)
       {
         e.preventDefault();
         if (window.confirm("Do you really want to Delete the current Application?")) { 
            var data = $(this).attr('value');
            url = "/account/jobs/delete-application";
            pjax_container = "#pjax_active_jobs";
            Ajax_delete(data,url,pjax_container);
        }
       })
    $(document).on('click','.delete_questionnaire',function(e)
       {
          e.preventDefault();
         if (window.confirm("Do you really want to Delete the current Questionnaire?")) { 
            var data = $(this).attr('value');
            url = "/account/questionnaire/delete";
            pjax_container = "#pjax_active_questionnaire";
            Ajax_delete(data,url,pjax_container);
        }
       })    
       
       $(document).on('click','.delete_interview_process',function(e)
       {
          e.preventDefault();
         if (window.confirm("Do you really want to Delete the current Process?")) { 
            var data = $(this).attr('value');
            url = "/account/interview-processes/delete";
            pjax_container = "#pjax_active_process";
            Ajax_delete(data,url,pjax_container);
        }
       })
       
        
 function Ajax_delete(data,url,pjax_container)
        {
          $.ajax({
                url:url,
                data:{data:data},
                method:'post',
                beforeSend:function(){
                    $(".loader").css("display", "block");
                  },
                success:function(data)
                    {
                      if(data==true)
                        {
                          $(".loader").css("display", "none");
                          $.pjax.reload({container: pjax_container, async: false});
                        }
                       else
                       {
                          alert('Something went wrong.. !');
                       }
                     }
              })
        }
    
JS;
$this->registerJs($script);
?>
<script>

</script>
