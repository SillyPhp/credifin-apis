<?php
use yii\helpers\Url;
$cover_image = Yii::$app->params->upload_directories->organizations->cover_image . $org_image_location . DIRECTORY_SEPARATOR . $org_image;
$cover_image_base_path = Yii::$app->params->upload_directories->organizations->cover_image_path . $cover_location . DIRECTORY_SEPARATOR . $cover;
if (empty($org_image)) {
$cover_image = "@eyAssets/images/backgrounds/default_cover.png";
}
?>
<section class="overlape dark-color">
    <div data-velocity="-.1"
         style="background: url('<?= Url::to($cover_image); ?>') repeat scroll 50% 422.28px transparent;background-size: 100% 100% !important;background-repeat: no-repeat;"
         class="parallax scrolly-invisible no-parallax"></div>
    <div class="background-container">
        <div class="row m-0">
            <div class="col-lg-12 p-0">
                <div class="inner-header">
                    <div class="profile_icons">
                        <img src="/assets/common/categories/profile/<?= $icon_png; ?>"/>
                    </div>
                    <h3><?= $job_title; ?></h3>
                    <div class="job-statistic">
                        <?php
                        if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->organization) {
                            if (!empty($shortlist) && $shortlist['shortlisted'] == 1) {
                                ?>
                                <span class="hover-change col_pink"><a href="#" class="shortlist_job"><i
                                            class="fa fa-heart-o"></i> Shortlisted</a></span>
                                <?php
                            } else {
                                ?>
                                <span class="hover-change"><a href="#" class="shortlist_job"><i
                                            class="fa fa-heart-o"></i> Shortlist</a></span>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--</div>-->
    <!--</div>-->
</section>