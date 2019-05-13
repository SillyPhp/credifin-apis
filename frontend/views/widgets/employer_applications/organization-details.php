<?php
use yii\helpers\Url;
$logo_image = Yii::$app->params->upload_directories->organizations->logo . $org_logo_location . DIRECTORY_SEPARATOR . $org_logo;
?>
<div class="job-single-head style2">
    <div class="job-thumb">
        <a href="/<?= $slug; ?>">
            <?php
            if (!empty($org_logo)) {
                ?>
                <img src="<?= Url::to($logo_image); ?>" id="logo_img" alt=""/>
                <?php
            } else {
                ?>
                <canvas class="user-icon" name="<?= $org_name; ?>" width="125" height="125"
                        color="<?= $initial_color; ?>" font="55px"></canvas>
                <?php
            }
            ?>
        </a>
    </div>
    <div class="job-head-info">
        <a href="/<?= $slug; ?>"><h4><?= $org_name; ?></h4></a>
        <?php if ($website): ?>
            <p><i class="fa fa-unlink"></i><?= $website; ?></p>
        <?php endif; ?>
    </div>
    <?php if (Yii::$app->user->isGuest): ?>
        <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="apply-job-btn"><i class="fa fa-paper-plane"></i>Login
            to apply</a>
    <?php else: ?>
        <?php if ($applied): ?>
            <a href="#" title="" class="apply-job-btn apply-btn" disabled="disabled"><i
                    class="fa fa-check"></i>Applied</a>
        <?php elseif (!Yii::$app->user->identity->organization): ?>
            <a href="#" class="apply-job-btn apply-btn"><i class="fa fa-paper-plane"></i>Apply for
                <?= $type ?></a>
        <?php endif; ?>
    <?php endif; ?>
    <?php
    if ($type=='Internship'): ?>
        <a href="<?= Url::to('/internships/list?company=' . $org_name); ?>" title="" class="viewall-jobs">View all
        Internships</a>
   <?php elseif($type=='Job'): ?>
    <a href="<?= Url::to('/jobs/list?company=' . $org_name); ?>" title="" class="viewall-jobs">View all
        Jobs</a>
    <?php endif; ?>
    <div class="share-bar no-border">
        <?php
        if ($type=='Internship'){
            $link = Url::to('internship/' . $application_slug, true);
        }
        else if($type=='Job') {
            $link = Url::to('job/' . $application_slug, true);
        }
        ?>
        <h3>Share</h3>
        <a href="#"
           onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
           class="share-fb">
            <i class="fa fa-facebook"></i>
        </a>
        <a href="#"
           onclick="window.open('<?= Url::to('https://twitter.com/home?status=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
           class="share-twitter">
            <i class="fa fa-twitter"></i>
        </a>
        <a href="#"
           onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
           class="share-linkedin">
            <i class="fa fa-linkedin"></i>
        </a>
        <a href="#"
           onclick="window.open('<?= Url::to('https://wa.me/?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
           class="share-whatsapp">
            <i class="fa fa-whatsapp"></i>
        </a>
        <a href="#"
           onclick="window.open('<?= Url::to('mailto:?&body=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
           class="share-google">
            <i class="fa fa-envelope"></i>
        </a>
    </div>
    <div class="col-lg-12">
        <h4>or</h4>
        <div class="pf-field">
            <input type="text" title="Click to Copy" id="share_manually" onclick="copyToClipboard()"
                   class="form-control" value="<?= $link ?>" readonly>
            <i class="fa fa-clipboard"></i>
        </div>
    </div>
</div>
<?php
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);