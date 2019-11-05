<?php
use yii\helpers\Url;
//print_r($applied_applications['list']);
//exit();
?>
<div class="portlet light nd-shadow">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'View Applications'); ?><a href="#" data-toggle="tooltip" title="Hooray!"><i class="fa fa-info-circle"></i></a></span>
</div>
</div>
<div class="portlet-body">
    <div class="row">
        <div class="col-md-12">
            <div class="mt-actions">
                <?php
                if (!empty($applied_applications['list'])) { ?>
                    <?php foreach ($applied_applications['list'] as $candiates) { ?>
                        <div class="mt-action">
                            <div class="mt-action-img" style="width: auto">
                                <a href="/<?= $candiates['username'] ?>">
                                    <?php if (!empty($candiates['image_location']) && !empty($candiates['image'])) { ?>
                                        <?php $user_img = Yii::$app->params->upload_directories->users->image . $candiates['image_location'] . DIRECTORY_SEPARATOR . $candiates['image']; ?>
                                        <img src="<?= $user_img; ?>" width="50px" height="50" class="img-circle"/>

                                        <?php
                                    } else {
                                        ?>
                                        <canvas class="user-icon img-circle" name="<?= $candiates['fullname'] ?>" width="50" height="50" font="25px"></canvas>
                                    <?php }
                                    ?>
                                </a>

                            </div>
                            <div class="mt-action-body">
                                <div class="mt-action-row">
                                    <div class="mt-action-info ">
                                        <div class="mt-action-details ">
                                            <span class="mt-action-author"><a href="/<?= $candiates['username'] ?>"><?= $candiates['fullname']; ?></a></span>
                                            <p class="mt-action-desc">Applied For <?= $candiates['job_title']; ?></p>
                                        </div>
                                    </div>
                                    <div class="mt-action-buttons">
                                        <div class="btn-group btn-group-circle">
                                            <a href="<?= Url::toRoute('process-applications' . DIRECTORY_SEPARATOR . $candiates['application_enc_id']); ?>" target="_blank" class="btn btn-outline green btn-sm">View Application</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="tab-empty">
                        <div class="tab-empty-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/applyingjob.png'); ?>"
                                 class="img-responsive" alt=""/>
                        </div>
                        <div class="tab-empty-text">
                            <div class="">No Application</div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php
$this->registerCss("
.font-dark > a > i {
    font-size: 13px;
    margin-left: 5px;
    color:darkgray;
}
.tab-empty{
    padding:20px;
}
.tab-empty-icon img{
    max-width:250px; 
    margin:0 auto;
}
.tab-empty-text{
    text-align:center; 
    font-size:35px; 
    font-family:lobster; 
    color:#999999; 
    padding-top:20px;
}
");
$script = <<<JS
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
});
JS;
$this->registerJs($script);