<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

?>
    <div class="loader"><!--<img src='https://image.ibb.co/c0WrEK/check1.gif'/>--></div>
    <div class="row">
        <div class="col-md-3">
            <div class="portlet light nd-shadow">
                <div class="portlet-title tabbable-line">
                    <div class="caption set-center">
                        <span class="caption-subject font-dark bold uppercase">Internships Preferred by Location</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <?= $this->render('/widgets/jobs/job-by-location', [
                            'jobsByLocation' => $internshipsByLocation,
                        ]) ?>
                        <div class="col-md-12 text-center">
                            <a href="<?= Url::to('/internships/list?location=' . $preferredLocations) ?>"
                               class="jbl-viewall viewall-jobs">View All</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portlet light nd-shadow">
                <div class="portlet-title tabbable-line">
                    <div class="caption set-center">
                        <span class="caption-subject font-dark bold uppercase">Internships Matching Your Skills</span>
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="row">
                        <?= $this->render('/widgets/jobs/job-by-skills', [
                            'jobsBySkills' => $internshipsBySkills,
                        ]) ?>
                        <div class="col-md-12 text-center">
                            <a href="<?= Url::to('/internships/list?skills=' . $preferredSkills) ?>"
                               class="jbl-viewall viewall-jobs">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <?php
                Pjax::begin(['id' => 'widgets']);
                ?>
                <div class="widget-row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 blue"
                           href="<?= Url::to('/account/internships/reviewed') ?>">
                            <div class="visual">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="1349"><?= $total_reviews; ?></span>
                                </div>
                                <div class="desc">Applications Reviewed</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 red"
                           href="<?= Url::to('/account/internships/saved') ?>">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="12,5"><?= $total_shortlist; ?></span>
                                </div>
                                <div class="desc">Applications Saved</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 green"
                           href="<?= Url::to('/account/internships/applied') ?>">
                            <div class="visual">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="549"><?= $total_applied; ?></span>
                                </div>
                                <div class="desc"> Applications Applied</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 purple"
                           href="<?= Url::to('/account/internships/accepted') ?>">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="89"><?= $total_accepted; ?></span></div>
                                <div class="desc"> Applications Accepted</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 yellow"
                           href="<?= Url::to('/account/internships/pending') ?>">
                            <div class="visual">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="89"><?= $total_pending; ?></span></div>
                                <div class="desc">Applications Pending</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a class="dashboard-stat dashboard-stat-v2 pink"
                           href="<?= Url::to('/account/organization/shortlisted') ?>">
                            <div class="visual">
                                <i class="fa fa-building"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup" data-value="89"><?= $total_shortlist_org; ?></span>
                                </div>
                                <div class="desc">Followed Companies</div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php
                Pjax::end();
                ?>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light nd-shadow">
                        <div class="portlet-title tabbable-line text-center">
                            <div class="caption col-lg-11">
                                <ul class="tabs" id="head-tabs">
                                    <li data-tab="tab-1" data-url="/account/internships/reviewed"
                                        class="tab-link current caption-subject font-dark uppercase">Review List
                                    </li>
                                    |
                                    <li data-tab="tab-2" data-url="/account/internships/saved"
                                        class="tab-link caption-subject font-dark  uppercase">Applications saved
                                    </li>
                                    |
                                    <li data-tab="tab-3" data-url="/account/internships/applied"
                                        class="tab-link caption-subject font-dark uppercase">Applications Applied
                                    </li>
                                    |
                                    <li data-tab="tab-4" data-url="/account/internships/accepted"
                                        class="tab-link caption-subject font-dark uppercase">Accepted Applications
                                    </li>
                                    |
                                    <li data-tab="tab-5" data-url="/account/internships/shortlisted-resume"
                                        class="tab-link caption-subject font-dark uppercase">Shortlisted Resume
                                    </li>
                                </ul>
                            </div>
                            <div class="actions col-lg-1">
                                <a href="/account/internships/reviewed" class="viewall-jobs" id="view-all">View All</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_actions_pending">
                                    <div class="row">
                                        <div class="mt-actions">
                                            <div id="tab-1" class="tab-con current">
                                                <?php
                                                Pjax::begin(['id' => 'pjax_review']);
                                                if ($reviewlist) {
                                                    foreach ($reviewlist as $review) {
                                                        ?>
                                                        <div class="col-md-4 col-sm-6 hr-j-box">
                                                            <div class="topic-con"
                                                                 data-key="<?= $review['application_enc_id']; ?>">
                                                                <div class="hr-company-box">
                                                                    <div class="hr-com-icon">
                                                                        <?php
                                                                        if ($review['unclaimed_organization_enc_id'] != null) {
                                                                            $unclaimed_organization_enc_id = \common\models\UnclaimedOrganizations::findOne(['organization_enc_id' => $review['unclaimed_organization_enc_id']]);
                                                                            if ($unclaimed_organization_enc_id->logo) {
                                                                                $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo . $unclaimed_organization_enc_id->logo_location . DIRECTORY_SEPARATOR . $unclaimed_organization_enc_id->logo;
                                                                            } else {
                                                                                $organizationLogo = "https://ui-avatars.com/api/?name=" . $unclaimed_organization_enc_id->name . "&size=200&rounded=false&background=" . str_replace("#", "", $unclaimed_organization_enc_id->initials_color) . "&color=ffffff";
                                                                            }
                                                                        } else {
                                                                            if ($review['logo']) {
                                                                                $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $review['logo_location'] . DIRECTORY_SEPARATOR . $review['logo'];
                                                                            } else {
                                                                                $organizationLogo = "https://ui-avatars.com/api/?name=" . $review['org_name'] . "&size=200&rounded=false&background=" . str_replace("#", "", $review['initials_color']) . "&color=ffffff";
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <img src="<?= $organizationLogo ?>"
                                                                             class="img-responsive ">
                                                                    </div>

                                                                    <div class="hr-com-name job-title-name">
                                                                        <?= ((!empty($review['org_name'])) ? $review['org_name'] : $review['unclaim_org_name']); ?>
                                                                    </div>
                                                                    <div class="merge-name-icon">
                                                                        <div class="cat-icon">
                                                                            <img src="<?= Url::to('@commonAssets/categories/' . $review["icon"]); ?>"
                                                                                 class="img-responsive ">
                                                                        </div>
                                                                        <div class="hr-com-field">
                                                                            <?= $review['title']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="opening-txt">
                                                                        <?php
                                                                        if ($review['positions'] || $review['unclaim_positions']) {
                                                                            ?>
                                                                            <?= (($review['positions']) ? $review['positions'] : $review['unclaim_positions']); ?> Openings
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="overlay">
                                                                        <div class="col-md-12">
                                                                            <div class="text-o col-md-5">
                                                                                <?php if ($review['applied_application_enc_id']) { ?>
                                                                                    <a class="over-bttn ob1"
                                                                                       disabled="disabled">Applied</a>
                                                                                <?php } else { ?>
                                                                                    <a href="/internship/<?= $review['slug']; ?>"
                                                                                       class="over-bttn ob1 hover_short apply-btn">Apply</a>
                                                                                <?php } ?>
                                                                            </div>
                                                                            <div class="text-o col-md-7">
                                                                                <a class="over-bttn ob2 shortlist"
                                                                                   id="<?= $review['slug']; ?>"
                                                                                   data-key="<?= $review['application_enc_id']; ?>">
                                                                                <span class="hover-change"><i
                                                                                            class="fa fa-heart-o"></i> Shortlist</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="hr-com-jobs">
                                                                        <div class="row">
                                                                            <div class="col-md-12 col-sm-12 minus-15-pad">
                                                                                <div class="j-cross">
                                                                                    <button value="<?= $review['application_enc_id']; ?>"
                                                                                            class="rmv_review">
                                                                                        <i class="fa fa-times"></i>
                                                                                    </button>

                                                                                </div>
                                                                                <div class="j-grid">
                                                                                    <a href="javascript:;"
                                                                                       onclick="window.open('<?= Url::to('/internship/' . $review['slug']); ?>', '_blank');">VIEW
                                                                                        INTERNSHIP</a>
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
                                                    <div class="tab-empty">
                                                        <div class="tab-empty-icon">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/reviewlist.png'); ?>"
                                                                 class="img-responsive" alt=""/>
                                                        </div>
                                                        <div class="tab-empty-text">
                                                            <div class="">You haven't Select any internships for review.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                Pjax::end();
                                                ?>
                                            </div>
                                            <div id="tab-2" class="tab-con">
                                                <?php
                                                Pjax::begin(['id' => 'pjax_shortlist']);
                                                if ($shortlisted) {
                                                    foreach ($shortlisted as $shortlist) {
                                                        ?>
                                                        <div class="col-md-4 hr-j-box">
                                                            <div class="topic-con">
                                                                <div class="hr-company-box">
                                                                    <div class="hr-com-icon">
                                                                        <?php
                                                                        if ($shortlist['unclaimed_organization_enc_id'] != null) {
                                                                            if ($shortlist['unclaim_org_logo']) {
                                                                                $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo . $shortlist['unclaim_org_logo_location'] . DIRECTORY_SEPARATOR . $shortlist['unclaim_org_logo'];
                                                                            } else {
                                                                                $organizationLogo = "https://ui-avatars.com/api/?name=" . $shortlist['unclaim_org_name'] . "&size=200&rounded=false&background=" . str_replace("#", "", $shortlist['unclaim_org_initials_color']) . "&color=ffffff";
                                                                            }
                                                                        } else {
                                                                            if ($shortlist['logo']) {
                                                                                $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $shortlist['logo_location'] . DIRECTORY_SEPARATOR . $shortlist['logo'];
                                                                            } else {
                                                                                $organizationLogo = "https://ui-avatars.com/api/?name=" . $shortlist['org_name'] . "&size=200&rounded=false&background=" . str_replace("#", "", $shortlist['initials_color']) . "&color=ffffff";
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <img src="<?= $organizationLogo ?>"
                                                                             class="img-responsive ">
                                                                    </div>

                                                                    <div class="hr-com-name job-title-name">
                                                                        <?= (($shortlist['org_name']) ? $shortlist['org_name'] : $shortlist['unclaim_org_name']); ?>
                                                                    </div>
                                                                    <div class="merge-name-icon">
                                                                        <div class="cat-icon">
                                                                            <img src="<?= Url::to('@commonAssets/categories/' . $shortlist["icon"]); ?>"
                                                                                 class="img-responsive ">
                                                                        </div>
                                                                        <div class="hr-com-field">
                                                                            <?= $shortlist['name']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="opening-txt">
                                                                        <?php
                                                                        if ($shortlist['positions'] || $shortlist['unclaim_positions']) {
                                                                            ?>
                                                                            <?= (($shortlist["positions"]) ? $shortlist['positions'] : $shortlist['unclaim_positions']); ?> Openings
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="overlay2">
                                                                        <div class="text-o">
                                                                            <?php if ($shortlist['applied_application_enc_id']) { ?>
                                                                                <a class="over-bttn ob2 hover_short"
                                                                                   disabled="disabled">
                                                                                    <i class="fa fa-check"></i>Applied</a>
                                                                            <?php } else { ?>
                                                                                <a href="/internship/<?= $shortlist['slug']; ?>"
                                                                                   class="over-bttn ob2 hover_short apply-btn">Apply</a>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="hr-com-jobs">
                                                                        <div class="row ">
                                                                            <div class="col-md-12 col-sm-12 minus-15-pad">
                                                                                <div class=" j-cross">
                                                                                    <button value="<?= $shortlist['application_enc_id']; ?>"
                                                                                            class="rmv_list">
                                                                                        <i class="fa fa-times"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div class=" j-grid">
                                                                                    <a href="javascript:;"
                                                                                       onclick="window.open('<?= Url::to('/internship/' . $shortlist['slug']); ?>', '_blank');">VIEW
                                                                                        INTERNSHIP</a>
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
                                                    <div class="tab-empty">
                                                        <div class="tab-empty-icon">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/shortlist-icon.png'); ?>"
                                                                 class="img-responsive" alt=""/>
                                                        </div>
                                                        <div class="tab-empty-text">
                                                            <div class="">You haven't Saved any internships.</div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                Pjax::end();
                                                ?>
                                            </div>
                                            <div id="tab-3" class="tab-con">
                                                <?php
                                                if ($applied) {
                                                    foreach ($applied as $apply) {
                                                        ?>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="topic-con">
                                                                <div class="hr-company-box">
                                                                    <div class="hr-com-icon">
                                                                        <?php
                                                                        if ($apply['logo']) {
                                                                            $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $apply['logo_location'] . DIRECTORY_SEPARATOR . $apply['logo'];
                                                                        } else {
                                                                            $organizationLogo = "https://ui-avatars.com/api/?name=" . $apply['org_name'] . "&size=200&rounded=false&background=" . str_replace("#", "", $apply['initials_color']) . "&color=ffffff";
                                                                        }
                                                                        ?>
                                                                        <img src="<?= $organizationLogo ?>"
                                                                             class="img-responsive ">
                                                                    </div>
                                                                    <div class="hr-com-name job-title-name">
                                                                        <?= $apply['org_name']; ?>
                                                                    </div>
                                                                    <div class="merge-name-icon">
                                                                        <div class="cat-icon">
                                                                            <img src="<?= Url::to('@commonAssets/categories/' . $apply["icon"]); ?>"
                                                                                 class="img-responsive ">
                                                                        </div>
                                                                        <div class="hr-com-field">
                                                                            <?= $apply['title']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="opening-txt">
                                                                        <?= $apply['positions']; ?> Openings
                                                                    </div>
                                                                    <div class="overlay1">
                                                                        <div class="text-o">
                                                                            <a class="over-bttn ob1"
                                                                               href="/account/process-applications/<?= $apply['app_id']; ?>">View
                                                                                Application</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="hr-com-jobs">
                                                                        <div class="row minus-15-pad">
                                                                            <div class="j-grid">
                                                                                <a href="javascript:;"
                                                                                   onclick="window.open('<?= Url::to('/internship/' . $apply['slug']); ?>', '_blank');">VIEW
                                                                                    INTERNSHIP</a>
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
                                                    <div class="tab-empty">
                                                        <div class="tab-empty-icon">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/appliedapplication.png'); ?>"
                                                                 class="img-responsive" alt=""/>
                                                        </div>
                                                        <div class="tab-empty-text">
                                                            <div class="">You haven't Applied any internships.</div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div id="tab-4" class="tab-con">
                                                <?php
                                                if ($accepted_jobs) {
                                                    foreach ($accepted_jobs as $accept) {
                                                        ?>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="topic-con">
                                                                <div class="hr-company-box">
                                                                    <div class="hr-com-icon">
                                                                        <?php
                                                                        if ($accept['logo']) {
                                                                            $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $accept['logo_location'] . DIRECTORY_SEPARATOR . $accept['logo'];
                                                                        } else {
                                                                            $organizationLogo = "https://ui-avatars.com/api/?name=" . $accept['org_name'] . "&size=200&rounded=false&background=" . str_replace("#", "", $accept['initials_color']) . "&color=ffffff";
                                                                        }
                                                                        ?>
                                                                        <img src="<?= $organizationLogo ?>"
                                                                             class="img-responsive ">
                                                                    </div>
                                                                    <div class="hr-com-name job-title-name">
                                                                        <?= $accept['org_name']; ?>
                                                                    </div>
                                                                    <div class="merge-name-icon">
                                                                        <div class="cat-icon">
                                                                            <img src="<?= Url::to('@commonAssets/categories/' . $accept["job_icon"]); ?>"
                                                                                 class="img-responsive ">
                                                                        </div>
                                                                        <div class="hr-com-field">
                                                                            <?= $accept['title']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="opening-txt">
                                                                        <?= $accept['positions']; ?> Openings
                                                                    </div>
                                                                    <div class="overlay1">
                                                                        <div class="text-o"><a class="over-bttn ob2"
                                                                                               href="/account/process-applications/<?= $accept['app_id']; ?>">View
                                                                                Application</a></div>
                                                                    </div>
                                                                    <div class="hr-com-jobs">
                                                                        <div class="row minus-15-pad">
                                                                            <div class="j-grid">
                                                                                <a href="javascript:;"
                                                                                   onclick="window.open('<?= Url::to('/internship/' . $accept['slug']); ?>', '_blank');">VIEW
                                                                                    INTERNSHIP</a>
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
                                                    <div class="tab-empty">
                                                        <div class="tab-empty-icon">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/acceptedapplication.png'); ?>"
                                                                 class="img-responsive" alt=""/>
                                                        </div>
                                                        <div class="tab-empty-text">
                                                            <div class="">You haven't any accepted internships.</div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div id="tab-5" class="tab-con">
                                                <?php
                                                if ($shortlist1) {
                                                    foreach ($shortlist1 as $shortlist) {
                                                        ?>
                                                        <div class="col-md-4 col-sm-6 hr-j-box">
                                                            <div class="topic-con">
                                                                <div class="hr-company-box">
                                                                    <div class="hr-com-icon">
                                                                        <?php
                                                                        if ($shortlist['logo']) {
                                                                            $organizationLogo = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $shortlist['logo_location'] . DIRECTORY_SEPARATOR . $shortlist['logo'];
                                                                        } else {
                                                                            $organizationLogo = "https://ui-avatars.com/api/?name=" . $shortlist['org_name'] . "&size=200&rounded=false&background=" . str_replace("#", "", $shortlist['initials_color']) . "&color=ffffff";
                                                                        }
                                                                        ?>
                                                                        <img src="<?= $organizationLogo ?>"
                                                                             class="img-responsive ">
                                                                    </div>

                                                                    <div class="hr-com-name job-title-name">
                                                                        <?= $shortlist['org_name']; ?>
                                                                    </div>
                                                                    <div class="merge-name-icon">
                                                                        <div class="cat-icon">
                                                                            <img src="<?= Url::to('@commonAssets/categories/' . $shortlist["job_icon"]); ?>"
                                                                                 class="img-responsive ">
                                                                        </div>
                                                                        <div class="hr-com-field">
                                                                            <?= $shortlist['title']; ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="overlay2">
                                                                        <div class="text-o">
                                                                            <?php if ($shortlist['appliedApplications']) { ?>
                                                                                <a class="over-bttn ob2 hover_short"
                                                                                   disabled="disabled">
                                                                                    <i class="fa fa-check"></i>Applied</a>
                                                                            <?php } else { ?>
                                                                                <a href="/internship/<?= $shortlist['slug']; ?>"
                                                                                   class="over-bttn ob2 hover_short apply-btn">Apply</a>
                                                                            <?php } ?>
                                                                        </div>

                                                                    </div>
                                                                    <div class="hr-com-jobs">
                                                                        <div class="row ">
                                                                            <div class="col-md-12 col-sm-12 minus-15-pad">
                                                                                <div class=" j-grid">
                                                                                    <a href="javascript:;"
                                                                                       onclick="window.open('<?= Url::to('/internship/' . $shortlist['slug']); ?>', '_blank');">VIEW
                                                                                        INTERNSHIP</a>
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
                                                    <div class="tab-empty">
                                                        <div class="tab-empty-icon">
                                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/shortlistresume.png'); ?>"
                                                                 class="img-responsive" alt=""/>
                                                        </div>
                                                        <div class="tab-empty-text">
                                                            <div class="">You haven't Shortlisted in any internship
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xs-12 col-sm-12">
                    <div class="portlet light nd-shadow">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class=" icon-social-twitter font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase">Followed Companies<span
                                            data-toggle="tooltip"
                                            title="Here you will find all companies that you are following"><i
                                                class="fa fa-info-circle"></i></span>
                    </span>
                            </div>
                            <div class="actions">
                                <a href="<?= Url::to('/account/organization/shortlisted') ?>" title=""
                                   class="viewall-jobs">View
                                    All</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <?=
                                $this->render('/widgets/organization/card', [
                                    'organization_data' => $shortlist_org,
                                    'for' => 'Internships'
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.merge-name-icon {
    display: flex;
    align-items: center;
    justify-content: center;
}
.cat-icon img {
    width: 30px;
    min-width: 30px;
    height: 30px;
    object-fit: contain;
    margin-right:5px;
}
.hr-com-icon img {
//    border-radius: 50% !important;
    object-fit: contain;
    overflow: hidden;
}
.hr-com-name.job-title-name {
    padding: 0;
}
.set-center{
    width:100%;
    text-align: center;
}
.font-dark > span > i {
    font-size: 13px;
    margin-left: 5px;
    color:darkgray;
}
.portlet.light > .portlet-title > .actions{
    padding:0px !important;
}
.tab-empty{
    padding:20px;
}
.tab-empty-icon img{
    height:170px; 
    margin:0 auto;
}
.tab-empty-text{
    text-align:center; 
    font-size:35px; 
    font-family:lobster; 
    color:#999999; 
    padding-top:20px;
}
.topic-con{
    position:relative;
}
.overlay, .overlay1, .overlay2 {
  position: absolute;
  top: 0px;
  left: 0;
  right: 0;
  background: rgb(64 63 63 / 50%);;
  overflow: hidden;
  width: 100%;
  height: 0;
  transition: .5s ease;
}
.loader{
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    padding:2px;
    z-index:99999;
}
.topic-con:hover .overlay, .topic-con:hover .overlay1,.topic-con:hover .overlay2 {
  height: 78%;
  border-radius:10px 10px 0px 0px !important;
}
.topic-con:hover .opening-txt ~ .overlay, .topic-con:hover .opening-txt ~ .overlay1,.topic-con:hover .opening-txt ~ .overlay2 {
    height:80%;
}
button.over-bttn, .ob1, button.over-bttn, .ob2{
    background:#00a0e3; 
    border:1px solid #00a0e3; 
    border-radius:4px !important;
    padding:6px 12px;
    color:#fff;
    font-family:roboto;
}
button.over-bttn, .ob2{
    background:#ff7803 !important; 
    border: 1px solid #ff7803;
}                  
.ob1:hover{
    background:#fff !important;
    color:#00a0e3; 
    transition:.3s all;
}                 
.ob2:hover{
    background:#fff !important; 
    color:#ff7803; 
    transition:.3s all;
}
.text-o {
    font-size: 14px;
    line-height:280px;
}
ul.tabs{
    margin: 0px;
    padding: 0px;
    list-style: none;
}
ul.tabs li{
    background: none;
    color: #222;
    display: inline-block;
    padding: 10px 0px;
    cursor: pointer;
    font-family: roboto;
    font-size: 13px;
    font-weight: 500;
}
.caption > ul.tabs > li.tab-link:hover{
    color:#00a0e3 !important;
}
.tab-con{
    display:none
}
.tab-con.current{
    display:inherit
}
.current{
    color:#00a0e3 !important; 
    transition:2s ease-out;
}
.tab-con.current{
    animation: slide-down 1s ease-out;
}
@keyframes slide-down {
    0% { opacity: 0; transform: translateY(100%); }
    100% { opacity: 1; transform: translateY(0); }
}
li.current{ 
    border-bottom:1px solid #00a0e3;
    transition:2s ease-out;
}
.hr-company-box{
    border-radius:10px !important; 
}                      
.hr-com-icon{
    padding:10px 0;
}
.hr-com-name{
    padding-top:20px;
}
.hr-com-jobs{
    padding:20px 0px 0px 0px !important; 
    text-align:center;
}            
#view-all{
    margin-top:5px;
}
.opening-txt{
    padding-top: 2px;
    padding-bottom: 10px;
    font-size: 14px;
    color: #080808;
    height:31px;
}
a:hover{
    text-decoration:none;
}
.viewall-jobs{padding:8px;}
/*Sidebar Jobs Cards*/
.job-card-sidebar-candidate a{
    margin-bottom: 15px;
    width: 100%;
    min-height: 120px;
    border: 2px solid #eef1f5;
    display: flex;
    align-items: center;
    font-size: 12px;
    padding: 10px;
    border-radius:8px !important;
    font-family: roboto;
    color: #000;
}
.job-cat-icon{
  flex-basis: 30%;
  text-align: center;
}
.job-cat-icon img{
  width: 80%;
}
.job-card-detail{
  flex-basis: 70%;
  padding: 0 0px 0 10px;
  line-height: 19px;
}
.job-card-detail h3{
  margin-top: 0px;
  margin-bottom: 5px;
  font-size: 14px;
  color: #333;
  font-weight: 500;
  text-transform: capitalize;
}
.job-card-detail p{
    margin-bottom: 0px;
}
.jcc-location{
  color: #ff7803;
}
.jcc-location, .company-name, .card-title {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.job-card-sidebar-candidate i{
  margin-right: 5px;
}   
.jbl-viewall.viewall-jobs{
    float: unset;
    margin-left: 0px;
}
');
$script = <<<JS
$("ul[id*=head-tabs] li").click(function(){
    $('#view-all').attr('href',$(this).attr('data-url'));
})

$(document).on('click','#shortlist',function(){
   var app_id = $(this).attr('value');
    $.ajax({
        url:'/account/internships/shortlist-job',
        data: {app_id:app_id},
        method: 'post',
        success:function(data){
            console.log("in success");
            console.log(data);
        }

    });
});
            
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
    
    function Ajax_call_two(rmv_id,url,pjax_refresh_id,pjax_refresh_idd,parent)
    {
        $.ajax({
                url : url,
                data : {rmv_id:rmv_id},
                method : 'POST',
                beforeSend: function()
                {   
                    parent.hide();
                    // $(".loader").css("display", "block");
                },
                success:function(data){
                        if(data.status == 'true')
                          {
                            // $(".loader").css("display", "none");
                            $.pjax.reload({container: pjax_refresh_id, async: false});
                            $.pjax.reload({container: pjax_refresh_idd, async: false});
                            toastr.success(data.message, data.title);
                           } 
                        else if(data.status == 'false') {
                            $.pjax.reload({container: pjax_refresh_id, async: false});
                            toastr.error(data.message, data.title);
                           }
                       }
              })
    }
        
$(document).on('click','.shortlist',function()
    {
      var  url = '/account/internships/review-shortlist';
      var rmv_id = $(this).attr('data-key');
      var  pjax_refresh_id = '#pjax_review';
      var  pjax_refresh_idd = '#pjax_shortlist';
      var parent = $(this).parents().eq(5);
      Ajax_call_two(rmv_id,url,pjax_refresh_id,pjax_refresh_idd,parent);
   }) 
   
      
   $(document).on('click','.rmv_list',function()
    {
      var  url = '/account/internships/shortlist-delete';
      var rmv_id = $(this).val();
      var  pjax_refresh_id = '#pjax_shortlist';
      var main_card = $(this).parentsUntil(".topic-con").closest('.hr-j-box');
      main_card.remove();
      Ajax_call(rmv_id,url,pjax_refresh_id);
   }) 
        
$(document).on('click','.rmv_review',function()
    {
      var  url = '/account/internships/review-delete';
      var rmv_id = $(this).val();
      var  pjax_refresh_id = '#pjax_review';
      Ajax_call(rmv_id,url,pjax_refresh_id);
   }) 
   
        
$(document).on('click','.rmv_org',function()
    {
      var  url = '/account/internships/org-delete';
      var rmv_id = $(this).val();
      var  pjax_refresh_id = '#pjax_org';
      Ajax_call(rmv_id,url,pjax_refresh_id);
   }) 
        
        
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-con').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})

$(document).on('click', '#removejob', function(){
    $(this).closest('.hr-j-box').remove();
});   
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$this->registerCssFile('@backendAssets/global/css/plugins.min.css');
$this->registerCssFile('@backendAssets/global/css/components.min.css');
