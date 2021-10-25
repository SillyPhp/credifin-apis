<?php

use yii\helpers\Url;

//print_r($applied_applications['list']);
//exit();
?>
    <div class="portlet light nd-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-social-twitter font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Applicants'); ?>
                <span href="#" data-toggle="tooltip"
                      title="Here you will find all applications received on your open opportunities">
                    <i class="fa fa-info-circle"></i>
                </span>
            </span>
            </div>
            <div class="actions">
                <a href="<?= Url::toRoute('/' . $type . '/applied-applications'); ?>" data-toggle="tooltip"
                   title="View All Applicants">
                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/viewall.png'); ?>"></a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-actions">
                        <?php
                        if (!empty($applied_applications)) { ?>
                            <?php foreach ($applied_applications as $candiates) { ?>
                                <div class="mt-action">
                                    <div class="mt-action-img" style="width: auto">
                                        <a href="/<?= $candiates['username'] ?>">
                                            <?php if (!empty($candiates['image_location']) && !empty($candiates['image'])) { ?>
                                                <?php $user_img = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $candiates['image_location'] . DIRECTORY_SEPARATOR . $candiates['image']; ?>
                                                <img src="<?= $user_img ?>"
                                                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?= $candiates['fullname'] ?>&size=200&rounded=false&background=<?= str_replace('#', '', $candiates['initials_color']) ?>&color=ffffff'"
                                                     width="50px" height="50" class="img-circle"/>

                                                <?php
                                            } else {
                                                ?>
                                                <canvas class="user-icon img-circle"
                                                        name="<?= $candiates['fullname'] ?>"
                                                        color="<?= $candiates['initials_color'] ?>" width="50"
                                                        height="50" font="25px"></canvas>
                                            <?php }
                                            ?>
                                        </a>

                                    </div>
                                    <div class="mt-action-body">
                                        <div class="mt-action-row">
                                            <div class="mt-action-info ">
                                                <div class="mt-action-details text-capitalize">
                                                    <span class="mt-action-author"><a
                                                                href="/<?= $candiates['username'] ?>"><?= $candiates['fullname']; ?></a></span>
                                                    <p class="mt-action-desc">Applied
                                                        For <?= $candiates['job_title']; ?></p>
                                                </div>
                                            </div>
                                            <div class="mt-action-buttons">
                                                <div class="btn-group btn-group-circle">
                                                    <a href="<?= Url::toRoute('process-applications' . DIRECTORY_SEPARATOR . $candiates['application_enc_id']); ?>"
                                                       target="_blank" class="btn btn-outline green btn-sm">View
                                                        Application</a>
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
                                    <div class="">There Are No Applicants</div>
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
.mt-action-details{
    font-family:roboto;
} 
.font-dark > span > i {
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