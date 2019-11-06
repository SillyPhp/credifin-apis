<?php

use yii\helpers\Url;

$logo_image = Yii::$app->params->upload_directories->organizations->logo . $org_logo_location . DIRECTORY_SEPARATOR . $org_logo;
?>
    <div class="job-single-head style2 overlay-top">
        <div class="job-thumb">
            <a href="/<?= $slug; ?>">
                <?php
                if (!empty($org_logo)) {
                    ?>
                    <img src="<?= Url::to($logo_image); ?>" id="logo_img" alt=""/>
                    <?php
                } else {
                    ?>
                    <canvas class="user-icon" name="<?= $org_name; ?>" width="100" height="100"
                            color="<?= $initial_color; ?>" font="48px"></canvas>
                    <?php
                }
                ?>
            </a>
        </div>
        <div class="job-head-info">
            <a href="/<?= $slug; ?>"><h4><?= $org_name; ?></h4></a>
            <div class="organization-details">
                <?php if ($website): ?>
                    <p><i class="fas fa-unlink"></i><?= $website; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="actions-main">
            <?php if (Yii::$app->user->isGuest): ?>
                <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="apply-job-btn single-btn"><i
                            class="fas fa-paper-plane"></i>Login to apply</a>
                <div class="sub-actions">
                    <?php
                    if ($type == 'Internship'): ?>
                        <a href="<?= Url::to('/internships/compare?s=' . $application_slug) ?>"
                           class="add-or-compare hvr-icon-pulse full-width"><i class="far fa-copy hvr-icon"></i>
                            Compare Internship</a>
                    <?php elseif ($type == 'Job'): ?>
                        <a href="<?= Url::to('/jobs/compare?s=' . $application_slug) ?>"
                           class="add-or-compare hvr-icon-pulse full-width"><i class="far fa-copy hvr-icon"></i>
                            Compare Job</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php if ($applied): ?>
                    <a href="#" title="" class="apply-job-btn single-btn" disabled="disabled"><i class="fas fa-check"></i>Applied</a>
                    <div class="sub-actions">
                        <?php
                        if ($type == 'Internship'): ?>
                            <a href="<?= Url::to('/internships/compare?s=' . $application_slug) ?>"
                               class="add-or-compare hvr-icon-pulse full-width"><i class="far fa-copy hvr-icon"></i>
                                Compare Internship</a>

                        <?php elseif ($type == 'Job'): ?>
                            <a href="<?= Url::to('/jobs/compare?s=' . $application_slug) ?>"
                               class="add-or-compare hvr-icon-pulse full-width"><i class="far fa-copy hvr-icon"></i>
                                Compare Job</a>
                        <?php endif; ?>
                    </div>
                <?php elseif (!Yii::$app->user->identity->organization): ?>
                    <a href="#" class="apply-job-btn apply-btn hvr-icon-pulse"><i class="fas fa-paper-plane hvr-icon"></i>Apply
                        for
                        <?= $type ?></a>
                <?php if ($shortlist_btn_display): ?>
                    <div class="sub-actions">
                        <?php
                        if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->organization) {
                            if (!empty($shortlist) && $shortlist['shortlisted'] == 1) {
                                ?>
                                <a href="#"
                                   class="add-or-compare hvr-icon-pulse shortlist_job <?= (($type == 'Internship') ? 'full-width' : '') ?>"><i
                                            class="far fa-heart hvr-icon"></i>Shortlisted</a>
                                <?php
                            } else {
                                ?>
                                <a href="#"
                                   class="add-or-compare hvr-icon-pulse shortlist_job <?= (($type == 'Internship') ? 'full-width' : '') ?>"><i
                                            class="far fa-heart hvr-icon"></i>Shortlist</a>
                                <?php
                            }
                        }
                        ?>
                        <?php
                        if ($type == 'Internship'): ?>
                            <a href="<?= Url::to('/internships/compare?s=' . $application_slug) ?>"
                               class="add-or-compare hvr-icon-pulse full-width"><i class="far fa-copy hvr-icon"></i>
                                Compare Internship</a>

                        <?php elseif ($type == 'Job'): ?>
                            <a href="<?= Url::to('/jobs/compare?s=' . $application_slug) ?>"
                               class="add-or-compare hvr-icon-pulse"><i class="far fa-copy hvr-icon"></i>
                                Compare Job</a>
                        <?php endif; ?>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php
            if ($type == 'Internship'): ?>
                <a href="<?= Url::to('/internships/list?company=' . $org_name); ?>" title="" class="view-all-a">View all
                    Internships</a>
            <?php elseif ($type == 'Job'): ?>
                <a href="<?= Url::to('/jobs/list?company=' . $org_name); ?>" title="" class="view-all-a">View all
                    Jobs</a>
            <?php endif; ?>
        </div>
        <div class="effect thurio">
        <h3 class="text-white">Share</h3>
        <div class="buttons">
            <?php
            if ($type == 'Internship') {
                $link = Url::to('internship/' . $application_slug, 'https');
            } else if ($type == 'Job') {
                $link = Url::to('job/' . $application_slug, 'https');
            }
            else if ($type=='Training')
            {
                $link = Url::to('training/' . $application_slug, 'https');
            }
            ?>
            <a href="#" class="facebook-f"
               onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="twitter-t"
               onclick="window.open('<?= Url::to('https://twitter.com/home?status=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="linked-l"
               onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="whatsapp-w"
               onclick="window.open('<?= Url::to('https://wa.me/?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="#" class="enve-e"
               onclick="window.open('<?= Url::to('mailto:?&body=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                <i class="fas fa-envelope"></i>
            </a>
        </div>
        <div class="row m-0">
            <div class="col-lg-12">
                <h4 class="text-white">or</h4>
                <div class="pf-field">
                    <input type="text" title="Click to Copy" id="share_manually" onclick="copyToClipboard()"
                           class="form-control" value="<?= $link ?>" readonly>
                    <i class="far fa-copy"></i>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php
$this->registerCss('
.job-thumb a{
    width: 125px;
    height: 125px;
    background-color: #fff;
    display: block;
    margin: auto;
    border-radius: 50%;
}
.job-thumb a img{
    margin:5px;
}
.overlay-top{
    width: 80%;
    margin: auto;
    margin-top: -150px;
    float: none;
    background-color: #333a44;
    z-index: 9;
    padding-top: 20px;
    padding-bottom: 50px;
}
.organization-details{
    display: block;
    text-align: left;
    padding: 25px;
}
.organization-details h4{
    font-size:14px !Important;
    margin-top:15px !important;
}
a.add-or-compare {
    display: inline-block !important;
    background-color: #fff;
    padding: 10px 16px;
    width: 42%;
    font-size: 12px;
    border-radius: 2px;
    color: #333;
    margin-top: 15px;
    box-shadow: 0px 0px 10px -2px #ddd;
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.single-btn{
    display:inline-block;
}
a.add-or-compare.full-width {
    width:175px;
}
a.add-or-compare:hover, a.add-or-compare:focus {
    background-color:#00a0e3;
    color:#fff;
    border-radius:6px;
}
.add-or-compare i {
    display: block;
}
.hvr-icon-pulse {
    display: inline-block;
    vertical-align: middle;
    -webkit-transform: perspective(1px) translateZ(0);
    transform: perspective(1px) translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    padding-right:1.2em;
}
.hvr-icon-pulse .hvr-icon {
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-transition-timing-function: ease-out;
    transition-timing-function: ease-out;
}
.hvr-icon-pulse:hover .hvr-icon, .hvr-icon-pulse:focus .hvr-icon, .hvr-icon-pulse:active .hvr-icon {
    -webkit-animation-name: hvr-icon-pulse;
    animation-name: hvr-icon-pulse;
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
}
.hvr-icon-pulse:before{
    content:"" !important;
}
.effect {
  width: 100%;
}
.effect .buttons {
  display: block;
  padding: 10px 0px;
}
.effect a {
  text-decoration: none !important;
  width: 40px;
  height: 40px;
  display: inline-block;
  border-radius: 50%;
  margin-right: 10px;
  font-size: 17px;
  overflow: hidden;
  position: relative;
  color: #fff;
  border: 2px solid #fff;
}
.effect a i {
  position: relative;
  z-index: 3;
}
.effect a i {
  display: inline-block;
  vertical-align: middle;
  margin-left: 0px;
  margin-top: 5px;
}
.effect a.facebook-f:hover{
    background:#3b5998;
    border-color:#3b5998;
} 
.effect a.twitter-t:hover{
    background:#6699FF;
    border-color:#6699FF;
} 
.effect a.linked-l:hover{
    background:#0e76a8;
    border-color:#0e76a8;
}
.effect a.whatsapp-w:hover{
    background:#25D366;
    border-color:#25D366;
}
.effect a.enve-e:hover{
    background:#00a0e3;
    border-color:#00a0e3;
}
/* thurio effect */
//.effect.thurio a {
//  transition: border-radius 0.2s linear 0s;
//  -webkit-transform: rotate(45deg);
//          transform: rotate(45deg);
//}
//.effect.thurio a i {
//  transition: -webkit-transform 0.01s linear 0s;
//  transition: transform 0.01s linear 0s;
//  transition: transform 0.01s linear 0s, -webkit-transform 0.01s linear 0s;
//  -webkit-transform: rotate(-45deg);
//          transform: rotate(-45deg);
//}
//.effect.thurio a:hover {
//  border-radius: 0px;
//}

.view-all-a{
    margin-top: 15px;
    display: block;
    color: #ddd;
}
@media only screen and (max-width: 991px) {
    .job-single-head.style2.overlay-top{
        margin-top: 0;
        width: 100%;
    }
    .job-thumb{max-width: 125px;}
    .job-head-info{
        max-width: 275px;
        text-align: left;
    }
    .job-head-info h4{
        margin-left:25px !Important;
    }
    .job-head-info .organization-details h4{
        margin-left:0px !Important;
    }
    .actions-main{
        float: left;
        display: inline-block;
        width: 42%;
    }
    a.add-or-compare{padding: 10px 5px;}
    .effect.thurio{clear:both;}
}
@media only screen and (max-width: 720px) {
    .actions-main{
        width: 30%;
        font-size:11px;
    }
}
@media only screen and (max-width: 640px) {
    a.add-or-compare{
        width:97%;
        padding: 13px 5px;
    }
    .add-or-compare i{display:inline-block;}
}
@media only screen and (max-width: 640px) {
    a.add-or-compare{
        width: 44%;
    }
    .actions-main {
        width: 100%;
    }
}
@media only screen and (max-width: 430px) {
    .job-thumb {
        max-width: inherit;
    }
    .job-head-info {
        max-width: inherit;
        text-align: center;
    }
    .organization-details {
        text-align: center;
    }
    .job-head-info h4{
        margin-left:0px !Important;
    }
}
');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);