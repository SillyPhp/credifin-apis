<?php
use yii\helpers\Url;
?>
<div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-social-twitter font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'View Applications'); ?></span>
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
                    <h3>No Applications To Display</h3>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>
