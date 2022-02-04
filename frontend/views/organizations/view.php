<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('frontend', htmlspecialchars_decode($organization['name']));
$keywords = $industry['industry'] . "," . $organization['tag_line'];
$description = $organization['description'];
$image = Yii::$app->urlManager->createAbsoluteUrl((!empty($organization['cover_image']) ? Yii::$app->params->upload_directories->organizations->cover_image . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'] : '/assets/common/logos/empower_fb.png'));
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl("https"),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl("https"),
        'og:title' => Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];

if ($organization['logo']) {
    $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $organization['logo_location'] . DIRECTORY_SEPARATOR . $organization['logo'];
} else {
    $image = "https://ui-avatars.com/api/?name=" . $organization['name'] . '&size=200&rounded=false&background=' . str_replace("#", "", $organization['initials_color']) . '&color=ffffff';
}
if ($organization['cover_image']) {
    $cover_image_path = Yii::$app->params->upload_directories->organizations->cover_image_path . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'];
    $cover_image = Yii::$app->params->upload_directories->organizations->cover_image . $organization['cover_image_location'] . DIRECTORY_SEPARATOR . $organization['cover_image'];
    if (!file_exists($cover_image_path)) {
        $cover_image = "/assets/themes/ey/images/backgrounds/default_cover.png";
    }
} else {
    $cover_image = "/assets/themes/ey/images/backgrounds/default_cover.png";
}
$overall_avg = array_sum($review_stats) / count($review_stats);
$round_avg = round($overall_avg);
?>
    <section>
        <div class="header-bg" style='background-image:url("<?= Url::to($cover_image); ?>");'>
            <div class="cover-bg-color"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="h-inner">
                            <div class="logo-absolute">
                                <div class="logo-box">
                                    <div class="logo">
                                        <?php
                                        if (!empty($image)):
                                            ?>
                                            <img id="logo-img" src="<?= Url::to($image); ?>" class="do-image"
                                                 data-name="<?= $organization['name'] ?>" data-width="200"
                                                 data-height="200" data-color="<?= $organization['initials_color'] ?>"
                                                 data-font="100px"
                                                 alt="<?= htmlspecialchars_decode($organization['name']) ?>"/>
                                        <?php else: ?>
                                            <canvas class="user-icon" name="<?= $image; ?>"
                                                    color="<?= $organization['initials_color'] ?>" width="200"
                                                    height="200" font="100px"></canvas>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="com-details">
                                    <div class="com-name">
                                        <?= htmlspecialchars_decode($organization['name']) ?>

                                    </div>
                                    <?php if (!empty($organization['tag_line'])) { ?>
                                        <div class="com-establish">
                                            <!--                                        <span class="detail-title">Tagline:</span> -->
                                            <?= htmlspecialchars_decode($organization['tag_line']); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($industry['industry'])) { ?>
                                        <div class="com-establish">
                                            <!--                                        <span class="detail-title">Industry:</span> -->
                                            <?= htmlspecialchars_decode($industry['industry']); ?>
                                        </div>
                                    <?php }
                                    ?>
                                    <div class="status-icon">
                                        <?php
                                        if ($labels['is_new'] == 1) {
                                            ?>
                                            <span class="new-j" data-toggle="tooltip" title="New">
                                        <img src="<?= Url::to('@eyAssets/images/job-profiles/new-job.png') ?>"/>
                                    </span>
                                            <?php
                                        }
                                        if ($labels['is_featured'] == 1) {
                                            ?>
                                            <span class="fIcons" data-toggle="tooltip" title="Featured">
                                        <img src="<?= Url::to('@eyAssets/images/job-profiles/featured-job.png') ?>"/>
                                    </span>
                                            <?php
                                        }
                                        if ($labels['is_promoted'] == 1) {
                                            ?>
                                            <span class="fIcons" data-toggle="tooltip" title="Promoted">
                                        <img src="<?= Url::to('@eyAssets/images/job-profiles/promoted-job.png') ?>"/>
                                    </span>
                                            <?php
                                        }
                                        if ($labels['is_hot'] == 1) {
                                            ?>
                                            <span class="fIcons" data-toggle="tooltip" title="Hot">
                                        <img src="<?= Url::to('@eyAssets/images/job-profiles/hot-job.png') ?>"/>
                                    </span>
                                            <?php
                                        }
                                        if ($labels['is_trending'] == 1) {
                                            ?>
                                            <span class="fIcons" data-toggle="tooltip" title="Trending">
                                        <img src="<?= Url::to('@eyAssets/images/job-profiles/trending-job.png') ?>"/>
                                    </span>
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
    </section>
    <section>
        <div class="container padd-top-0">
            <div class="row">
                <div class="col-md-6 col-md-offset-2 col-sm-10 col-sm-offset-2 col-xs-12">
                    <!--                    <ul class="nav nav-tabs nav-padd-20">-->
                    <!--                        <li class="active"><a data-toggle="tab" href="#home">Overview</a></li>-->
                    <!--                        <li><a data-toggle="tab" href="#menu1">Opportunities</a></li>-->
                    <!--                        <li><a data-toggle="tab" href="#tab4" class="location_tab">Locations</a></li>-->
                    <!--                        <li><a data-toggle="tab" href="#menu4">Reviews</a></li>-->
                    <!--                    </ul>-->
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <?php if (Yii::$app->user->identity->organization) { ?>
                        <span></span>
                    <?php } else { ?>
                        <div class="follow-btn">
                            <?php if (!empty($follow) && $follow['followed'] == 1) {
                                ?>
                                <button class="follow">Following</button>

                                <?php
                            } elseif (!Yii::$app->user->isGuest) {
                                ?>
                                <button class="follow">Follow</button>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="social-btns">
                        <?php if (!empty($organization['facebook'])) { ?><a
                            href="<?= htmlspecialchars_decode($organization['facebook']) ?>" class="facebook-social"
                            target="_blank"><i class="fab fa-facebook-f"></i> </a><?php } ?>
                        <?php if (!empty($organization['twitter'])) { ?><a
                            href="<?= htmlspecialchars_decode($organization['twitter']) ?>" class="twitter"
                            target="_blank"><i class="fab fa-twitter"></i> </a><?php } ?>
                        <?php if (!empty($organization['linkedin'])) { ?><a
                            href="<?= htmlspecialchars_decode($organization['linkedin']) ?>" class="linkedin-social"
                            target="_blank"><i class="fab fa-linkedin-in"></i> </a><?php } ?>
                        <?php if (!empty($organization['website'])) { ?><a
                            href="<?= htmlspecialchars_decode($organization['website']) ?>" class="web" target="_blank">
                                <i class="fas fa-link"></i> </a><?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="tab-content">
                <div>
                    <div class="row">
                        <div class="heading-style">
                            About <?= htmlspecialchars_decode($organization['name']) ?>
                        </div>
                        <div class="divider"></div>
                        <div class="col-md-7 col-xs-12">
                            <?php if (!empty($organization['mission']) || !empty($organization['vision']) || !empty($organization['description'])) { ?>
                                <?php if (!empty($organization['description'])) { ?>
                                    <div class="com-description more">
                                        <?= htmlspecialchars_decode($organization['description']) ?>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($organization['mission']) || !empty($organization['vision'])) { ?>
                                    <div class="row">
                                        <div class="heading-style">Mission & Vision</div>
                                        <div class="divider"></div>
                                        <div class="mv-box">
                                            <div class="col-md-12">
                                                <?php if (!empty($organization['mission'])) { ?>
                                                    <div class="mv-heading">
                                                        Mission
                                                    </div>
                                                    <div class="mv-text">
                                                        <?= htmlspecialchars_decode($organization['mission']) ?>
                                                    </div>
                                                <?php }
                                                if (!empty($organization['vision'])) {
                                                    ?>
                                                    <div class="vission-box">
                                                        <div class="mv-heading">
                                                            Vision
                                                        </div>
                                                        <div class="mv-text">
                                                            <?= htmlspecialchars_decode($organization['vision']) ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div>
                                    <div class="desc-image mt-40">
                                        <img src="/assets/themes/ey/images/pages/dashboard/no-description.png">
                                    </div>
                                    <p class="heading_style_1">No Business details have been provided by the
                                        Organization.</p>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="col-md-5 col-xs-12">
                            <div class="a-boxs">
                                <div class="row margin-0">
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <div class="">
                                            <div class="about-det">
                                                <div class="det">
                                                    <?= $organization['number_of_employees'] ? htmlspecialchars_decode($organization['number_of_employees']) : 'N/A' ?>
                                                </div>
                                                <div class="det-heading">Employees</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <div class="">
                                            <div class="about-det">
                                                <?php
                                                $countVacancies = 0;
                                                if (!empty($count_opportunities)) {
                                                    foreach ($count_opportunities as $c) {
                                                        if (!empty($c['positions'])) {
                                                            $countVacancies += $c['positions'];
                                                        } else if (!empty($c['positions2'])) {
                                                            $countVacancies += $c['positions2'];
                                                        }
                                                    }
                                                }
                                                ?>
                                                <div class="det"><?= $countVacancies ?></div>
                                                <div class="det-heading">Opportunities</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 about-box">
                                        <div class="">
                                            <div class="about-det">
                                                <div class="det">
                                                    <?= $organization['establishment_year'] ? $organization['establishment_year'] : 'N/A' ?>
                                                </div>
                                                <div class="det-heading">Established</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                                <div class="j-profiles">-->
                            <!--                                    <h3>Job Profiles</h3>-->
                            <!--                                    <div class="row" style="padding: 0 15px;">-->
                            <!--                                        <div class="pf-flex">-->
                            <!--                                            <div class="pf-all">Infromation technology</div>-->
                            <!--                                            <div class="pf-all">marketing</div>-->
                            <!--                                            <div class="pf-all">sales</div>-->
                            <!--                                            <div class="pf-all">Engineering</div>-->
                            <!--                                            <div class="pf-all">accounting</div>-->
                            <!--                                            <div class="pf-all">others</div>-->
                            <!--                                        </div>-->
                            <!--                                    </div>-->
                            <!--                                </div>-->
                            <div>
                                <!--                                <h1 class="heading-style">Overall Ratings</h1>-->
                                <div class="sub-review-box">
                                    <div class="rating-large"><?= $round_avg ?>/5</div>
                                    <div class="rs-main">
                                        <div class="com-rating-1">
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <i class="fas fa-star <?= (($round_avg < $i) ? '' : 'active') ?>"></i>
                                            <?php } ?>
                                        </div>
                                        <div class="reviewers"><?= $reviews_count ?> Reviews</div>
                                    </div>
                                    <div class="write-rv">
                                        <a href="/<?= $organization['slug']; ?>/reviews">Write Review</a>
                                    </div>
                                </div>
                                <!--                                --><?php
                                //                                if ($round_avg != 0) {
                                //                                    ?>
                                <!--                                    <div class="col-md-12 user-rating">-->
                                <!--                                        <div class="ur-bg padd-lr-5">-->
                                <!--                                            <div class="urating">-->
                                <? //= $review_stats['job_avg']; ?><!--/5</div>-->
                                <!--                                            <div class="uratingtitle">Job Security</div>-->
                                <!--                                        </div>-->
                                <!--                                        <div class="ur-bg light-bg">-->
                                <!--                                            <div class="urating">-->
                                <? //= $review_stats['growth_avg']; ?><!--/5</div>-->
                                <!--                                            <div class="uratingtitle">Career Growth</div>-->
                                <!--                                        </div>-->
                                <!--                                        <div class="ur-bg">-->
                                <!--                                            <div class="urating">-->
                                <? //= $review_stats['avg_cult']; ?><!--/5</div>-->
                                <!--                                            <div class="uratingtitle">Company Culture</div>-->
                                <!--                                        </div>-->
                                <!--                                        <div class="ur-bg light-bg">-->
                                <!--                                            <div class="urating">-->
                                <? //= $review_stats['avg_compensation']; ?><!--/5</div>-->
                                <!--                                            <div class="uratingtitle">Salary & Benefits</div>-->
                                <!--                                        </div>-->
                                <!--                                        <div class="ur-bg">-->
                                <!--                                            <div class="urating">-->
                                <? //= $review_stats['avg_work']; ?><!--/5</div>-->
                                <!--                                            <div class="uratingtitle">Work Satisfaction</div>-->
                                <!--                                        </div>-->
                                <!--                                        <div class="ur-bg light-bg">-->
                                <!--                                            <div class="urating">-->
                                <? //= $review_stats['avg_work_life']; ?><!--/5</div>-->
                                <!--                                            <div class="uratingtitle">Work-Life Balance</div>-->
                                <!--                                        </div>-->
                                <!--                                        <div class="ur-bg">-->
                                <!--                                            <div class="urating">-->
                                <? //= $review_stats['avg_skill']; ?><!--/5</div>-->
                                <!--                                            <div class="uratingtitle">Skill Development</div>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                    --><?php
                                //                                }
                                //                                ?>
                                <div class="review-sidebar-main text-center">
                                    <h4 class="sub-heading-review">Help the community by giving your valuable
                                        review</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="av-jobs-intern" id="grand-parent-opportunities">
                        <div class="row">
                            <div class="heading-style">Available Opportunities</div>
                            <div class="divider"></div>
                        </div>
                        <div id="jobs-cards-main" class="row">
                            <div class="heading-style2">Jobs
                                <div class="pull-right">
                                    <a href="/jobs/list?slug=<?= $organization['slug'] ?>"
                                       class="write-review">View
                                        All</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="blogbox"></div>
                                </div>
                            </div>
                        </div>
                        <div id="internships-cards-main" class="row">
                            <div class="internships-block">
                                <div class="heading-style2">Internships
                                    <div class="pull-right">
                                        <a href="/internships/list?slug=<?= $organization['slug'] ?>"
                                           class="write-review">View All</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="internships_main"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="past-jobs-intern" id="grand-parent-past">
                        <div class="row">
                            <div class="heading-style">Past Opportunities</div>
                            <div class="divider"></div>
                        </div>
                        <div id="jobs-cards-past" class="row">
                            <div class="heading-style2">Jobs</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pastblogbox"></div>
                                </div>
                            </div>
                        </div>
                        <div id="internships-cards-past" class="row">
                            <div class="internships-block">
                                <div class="heading-style2">Internships</div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pastinternships_main"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="set-mar">
                        <div class="row">
                            <?= $this->render('/widgets/new-position', [
                                'company' => $organization['name'],]); ?>
                        </div>
                    </div>

                    <?php if (!empty($benefit)) {
                        ?>
                        <div class="row">
                            <div class="company-benefits">
                                <div class="heading-style">Employee Benefits</div>
                                <div class="divider"></div>
                                <div class="com-benefits no-padd">
                                    <?php
                                    foreach ($benefit as $benefits) {
                                        ?>
                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                            <div class="benefit-box">
                                                <div class="bb-icon">
                                                    <?php
                                                    if (!empty($benefits['icon'])) {
                                                        $benefit_icon = Url::to('/assets/icons/' . $benefits['icon_location'] . DIRECTORY_SEPARATOR . $benefits['icon']);
                                                    } else {
                                                        $benefit_icon = Url::to('@commonAssets/employee-benefits/plus-icon.svg');
                                                    }
                                                    ?>
                                                    <img src="<?= Url::to($benefits['icon']); ?>"
                                                         alt="<?= htmlspecialchars_decode($benefits['benefit']); ?>"/>
                                                </div>
                                                <div class="bb-text">
                                                    <?= htmlspecialchars_decode($benefits['benefit']); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php }
                    if (!empty($gallery)) {
                        ?>
                        <div class="row">
                            <div class="office-view">
                                <div class="heading-style">
                                    Inside <?= htmlspecialchars_decode($organization['name']) ?>
                                </div>
                                <div class="divider"></div>
                                <div class="office-pics">
                                    <?php
                                    foreach ($gallery as $g_image) {
                                        ?>
                                        <div class="col-md-3 col-sm-3 col-xs-12 no-padd">
                                            <div class="img1">
                                                <a href="<?= Url::to(Yii::$app->params->upload_directories->organizations->image . $g_image['image_location'] . DIRECTORY_SEPARATOR . $g_image['image']) ?>"
                                                   data-fancybox="image">
                                                    <img src="<?= Url::to(Yii::$app->params->upload_directories->organizations->image . $g_image['image_location'] . DIRECTORY_SEPARATOR . $g_image['image']) ?>"
                                                         alt="Inside <?= htmlspecialchars_decode($organization['name']) ?>">
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    if (!empty($org_products['organizationProductImages']) || !empty($org_products['description'])) {
                        ?>
                        <div class="row">
                            <div class="office-view">
                                <div class="heading-style">
                                    Products
                                </div>
                                <div class="divider"></div>
                                <?php if (!empty($org_products['organizationProductImages'])) { ?>
                                    <div class="office-pics">
                                        <div class="col-md-10 col-md-offset-1 col-sm-6 col-xs-12 no-padd">
                                            <div class="p-preview-img">
                                                <a href="" data-fancybox="images">
                                                    <img src=""
                                                         alt="<?= htmlspecialchars_decode($organization['name']) ?> Products">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12 no-padd text-center">
                                            <?php
                                            foreach ($org_products['organizationProductImages'] as $p_image) {
                                                ?>
                                                <div class="p-img-thumbnail" style="float: none;display: inline-block;">
                                                    <a href="<?= Url::to(Yii::$app->params->upload_directories->organizations->image . $p_image['image_location'] . DIRECTORY_SEPARATOR . $p_image['image']) ?>"
                                                       data-fancybox="images">
                                                        <img src="<?= Url::to(Yii::$app->params->upload_directories->organizations->image . $p_image['image_location'] . DIRECTORY_SEPARATOR . $p_image['image']) ?>"
                                                             alt="<?= $p_image['title'] ?>">
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if (!empty($org_products['description'])) {
                                    ?>
                                    <div class="col-md-12 col-sm-6 col-xs-12 no-padd">
                                        <h4>Brief Desciption</h4>
                                        <p>
                                            <?= $org_products['description']; ?>
                                        </p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php }
                    if (!empty($our_team)) {
                        ?>
                        <div class="row">
                            <div class="company-team">
                                <div class="heading-style">Meet The Team</div>
                                <div class="divider"></div>
                                <div class="team-box">
                                    <?php
                                    foreach ($our_team as $team) {
                                        ?>
                                        <div class="col-md-3 col-sm-6">
                                            <div class="team-container">
                                                <a href="#">
                                                    <div class="team-icon">
                                                        <img src="<?= Url::to(Yii::$app->params->upload_directories->organizations->employees->image . $team['image_location'] . DIRECTORY_SEPARATOR . $team['image']) ?>"
                                                             alt="<?= htmlspecialchars_decode($team['first_name'] . " " . $team['last_name']); ?>"/>
                                                        <?php if (!empty($team['facebook']) || !empty($team['linkedin']) || !empty($team['twitter'])) { ?>
                                                            <div class="team-overlay">
                                                                <div class="team-text">
                                                                    <div class="know-bet">Know me better</div>
                                                                    <?php if (!empty($team['facebook'])) { ?><a
                                                                        href="<?= htmlspecialchars_decode($team['facebook']); ?>"
                                                                        target="_blank"><i
                                                                                    class="fab fa-facebook-f t-fb"></i>
                                                                        </a><?php } ?>
                                                                    <?php if (!empty($team['linkedin'])) { ?><a
                                                                        href="<?= htmlspecialchars_decode($team['linkedin']); ?>"
                                                                        target="_blank"><i
                                                                                    class="fab fa-linkedin-in t-ln"></i>
                                                                        </a><?php } ?>
                                                                    <?php if (!empty($team['twitter'])) { ?><a
                                                                        href="<?= htmlspecialchars_decode($team['twitter']); ?>"
                                                                        target="_blank"><i
                                                                                    class="fab fa-twitter t-tw"></i>
                                                                        </a><?php } ?>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="t-member">
                                                        <div class="t-name"><?= htmlspecialchars_decode($team['first_name'] . " " . $team['last_name']); ?></div>
                                                        <div class="t-post"><?= htmlspecialchars_decode($team['designation']) ?></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="address-division">
                        <div class="heading-style">Reviews
                            <!--                            --><? //= htmlspecialchars_decode($organization['name']) ?>
                            <div class="pull-right">
                                <a href="/<?= $organization['slug'] ?>/reviews" class="write-review">Write
                                    Review</a>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div id="org-reviews"></div>
                        <div class="viewbtn">
                            <a href="/<?= $organization['slug'] ?>/reviews">View All Review</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="address-division-new">
                        <div class="heading-style">
                            Address
                        </div>
                        <div class="divider"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 pull-right mb-20">
                                <div id="map"></div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="head-office">

                                </div>
                                <div class="view-btn-location">
                                    <a href="javascript:;">View All <i class="fas fa-angle-down"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                         alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                    <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="organisation_id"
           value="<?= htmlspecialchars_decode($organization['organization_enc_id']) ?>"/>

<?php
echo $this->render('/widgets/mustache/organization_locations', [
    'Edit' => false
]);
echo $this->render('/widgets/mustache/application-card');
echo $this->render('/widgets/drop_resume', [
    'username' => Yii::$app->user->identity->username,
    'slug' => $organization['slug'],
    'type' => 'company',
    'is_claim' => $is_claim,
    'org_id' => $organization['organization_enc_id'],
]);
echo $this->render('/widgets/mustache/organization-reviews', [
    'org_slug' => $organization['slug'],
]);
$this->registerCss('
.past-jobs-intern {
    margin-top: 30px;
}
.imm1 img, .imm2 img {
    width: 55%;
}
.set-mar {
    margin: 35px 0 0;
}
.heading-style2 {
    font-size: 28px;
    font-family: lobster;
    margin: 0px 0px 20px 5px;
//    font-weight: 700;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.footer{margin-top:0 !important;}
.desc-image {
    text-align: center;
}
.desc-image img{
    width: 350px;
    height: auto;
    margin: 20px 0;
}
.new-j img{
    max-width:50px;
}
.fIcons img{
    max-width: 25px;
}
.status-icon{
    padding: 0 0 0 30px;
}
.status-icon span{
    font-size: 0px;
    margin-right: 8px;
}
.npb-pos-abso{
    top:55%;
}
.mv-text{
    text-align:justify;
    font-family:roboto;
}
.j-profiles {
	box-shadow: 0 3px 12px rgba(0, 0, 0, .2);
	position: relative;
	border-radius: 15px;
	margin: 30px 0 20px;
}
.j-profiles h3 {
	font-size: 21px;
//	background-color: #00a0e3;
	padding: 12px 20px 0px;
	text-transform: uppercase;
	color: #00a0e3;
	margin: 0 0 15px;
	font-family: roboto;
	font-weight: 500;
	border-radius: 4px 4px 0 0;
	text-align: center;
}
.pf-flex {
	display: flex;
	justify-content: center;
	flex-wrap:wrap;
}
.pf-all {
	text-align: center;
	font-size: 16px;
	text-transform: capitalize;
	font-family: roboto;
	font-weight: 500;
	cursor: pointer;
	flex-basis: 45%;
	margin: 0px 8px 8px;
	padding: 10px;
	transition: all .3s;
//	border: 1px solid #aaaaaa;
}
.pf-all:hover {
	color: #00a0e3;
	transform:translateY(-3px);
}
.write-rv {
    position: absolute;
    right:15px;
    bottom: 5px;
}
.write-rv a {
    color: #fff;
    font-weight: 500;
    font-family: roboto;
    transition:all .3s;
}
.write-rv:hover a {
    color: #00a0e3;
    background-color: #fff;
    padding: 5px 8px;
    border-radius: 2px;
}
.warn-img {
	width: 300px;
	margin: auto;
}
.warn-p {
	text-align: center;
	padding: 20px 0 0;
	font-size: 22px;
	font-family: roboto;
	font-weight: 500;
}
.write-review{
    font-family: Roboto;
    font-size: 14px;
    font-weight:500;
    padding: 10px 25px;
    border-radius: 4px;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
    background-color: #00a0e3;
    color:#fff;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
}
.write-review:hover{
    color: #00a0e3;
    background-color: #fff;
}
/*----jobs and internships----*/
.internships-block{
    padding-top:30px;
}
/*----jobs and internships ends----*/
/*----company benefits----*/
.company-benefits{
    padding:30px 0 0 0;
}
.benefit-box{
    text-align:center;
    border:1px solid rgba(221, 216, 216, 0.1);
    padding:25px 10px;
    margin:0 0 15px 0;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.3);
    padding-bottom: 0px;
    min-height: 165px;
    position:relative;
}
.bb-icon img{
    width:75px;
    height:75px;
}
.bb-text{
    padding-top:10px;
    text-transform:uppercase;
    font-size:15px;
    font-weight:500;
    font-family:roboto;
}
/*----company benefits ends----*/
/*----mission & vission----*/
.mv-heading {
	font-size: 20px;
	font-weight: 500;
	text-transform: uppercase;
	font-family: roboto;
}
.vission-box{
    padding-top:20px;
}
/*----mission & vission end----*/
/*----team----*/
.company-team{
    padding-top:20px;
}
.team-container{
    box-shadow:0 0 10px rgba(0,0,0,0.1);
    border-radius:10px;
    height:100%;
    position:relative;
    margin: 0 0 20px 0;
}
.t-fb:hover{
    color:#3C5A99
}
.t-ln:hover{
    color:#0077B5;
}
.t-tw:hover{
    color:#1DA1F2;
}
.team-container:hover{
    box-shadow:0 0 15px rgba(0,0,0,0.3);
    -o-transition:.3s all;
    -ms-transition:.3s all;
    -moz-transition:.3s all;
    -webkit-transition:.3s all;
    transition:.3s all;
}
.know-bet{
    font-size:14px;
    text-transform:uppercase;
    color:#00a0e3;
}
.team-container:hover .team-overlay {
  height: 100%;
}
.team-text {
  color: #000;
  font-size: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  text-align: center;
}
.team-text a{
    padding:0 5px;
}
.team-icon{
    width:100%;
    height:230px;
    overflow:hidden;
    object-fit:cover;
    position:relative;
}
.team-icon img{
    border-radius:10px 10px 0 0; 
    width:100%;
    height:100%;
}
.team-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(255,255,255,.9);
  overflow: hidden;
  width: 100%;
  height: 0;
  border-radius:10px 10px 0 0 ;
  transition: .5s ease;
}
.t-member{
    padding:5px 10px 10px 10px;
    text-align:center;
}
.t-name{
    font-size:16px;
    font-weight:bold;
}
/*----team ends----*/
/*----office view-----*/
.img1 img{
    width:285px;
    height:200px;
    object-fit:cover;
}
.office-view{
    padding:40px 0 0 0;
}
.no-padd{
    padding-left:0px !important;
    padding-right:0px !important;
}
/*----office view ends----*/
/*----address----*/
.head-office {
	display: flex;
	flex-wrap: wrap;
}
.org-location {
	border: 1px solid #eee;
	padding: 10px;
	margin: 0 1% 1% 0;
	box-shadow: 0 0 5px -1px rgba(0,0,0,0.1);
	flex-basis: 49%;
	height: 148px;
	overflow:hidden;
}
.office-heading {
	font-weight: bold;
	font-size: 16px;
	text-transform: uppercase;
	font-family: lora;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
	max-height: 55px;
	cursor: pointer;
}
.office-heading img{
    max-width:25px;
    margin-top:-5px;
}
.office-loc{
    font-family:roboto;
}
.o-h2 img{
    max-width:15px;
    margin:0 5px 0 5px;
    margin-top:-5px;
}
#map{
    height: 300px; 
}
/*----address ends----*/
/*----about us-----*/
.com-description{
    font-size:15px;
    text-align:justify;
    line-height:22px;
    font-family:roboto;
}
.com-des-list{
    padding:10px 25px;
}
.com-des-list li{
  list-style-image:url(' . Url::to('@eyAssets/images/pages/company-and-candidate/next.png') . ');  
}
.divider{
    border-top:1px solid #eee;
    padding:0 0 20px 0;
}
/*----about us ends----*/
/*----grid box----*/
.a-boxs{
        box-shadow: 2px 5px 24px rgba(221, 216, 216, 0.5);
}
.about-box{
    height:100px;
    border:1px solid rgba(238, 238, 238, .5);;
    text-align:center;
    position:relative;
}
.margin-0{
    margin-left:0px;
    margin-right:0px;
}
.about-det{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%); 
}
.det-heading {
	font-size: 15px;
	font-weight: 500;
	font-family: roboto;
}
.det{
    font-family: roboto;
    font-size:16px;
    color:#00a0e3;
}
/*----grid box ends*/
/*----follow btn----*/
.follow-btn,.social-btns{
    text-align:center
}
.social-btns{
   margin-top:15px;
}
.social-btns a{
    margin:0 5px;
    padding:8px 0;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
}
a.twitter{
    padding:8px 6px 8px 10px;
    color:#1DA1F2;
}
.twitter:hover{
    background:#1da1f2;
    color:#fff;
}
a.facebook-social{
    padding:8px 9px 8px 12px;
    color:#3C5A99;   
}
.facebook-social:hover{
    background:#3c5a99;
    color:#fff;
}
a.linkedin-social{
    padding:8px 9px 8px 11px;
     color:#0077B5;
}
.linkedin-social:hover{
    background:#0077b5;
    color:#fff;
}
a.web{
    padding:8px 11px 8px 11px;
    color:#ff7803; 
}
.web:hover{
    background:#ff7803;
    color:#fff;
}
.follow{
    padding:10px 0px;
    width:167px;
     background: transparent;
    border:none;
    font-size: 16px;
    text-transform: capitalize;
    color: #00a0e3;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    font-family:roboto;
}
.follow:hover{
    background:#00a0e3;
    color:#fff;
}
.follow, .follow:hover, a.facebook-social, .facebook-social:hover,
a.twitter, .twitter:hover, a.linkedin-social, .linkedin-social:hover, a.web, .web:hover{
    transition:.3s all;
}
/*----follow btn ends----*/
/*----tabs----*/
.nav-tabs > li.active a, .nav-tabs > li.active a:hover, .nav-tabs > li.active a:focus{
    color: #fff;
    background-color: #00a0e3 !important;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
     transition:.2s all;
     font-family:roboto;
}
.nav-tabs > li > a:hover{
   box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
   color:#00a0e3;
}
.nav-tabs>li>a{
    border:none;
    font-family:roboto;
}
.nav-tabs>li>a:hover{
    border:none;
}
/*----tabs end----*/
/*----company products css starts----*/
.p-img-thumbnail {
    width: 120px;
    height: 120px;
    float: left;
    line-height: 116px;
    border: 1px solid #eee;
    margin: 2px 5px;
}
.p-preview-img{
    height: 300px;
    text-align: center;
    line-height: 300px;
}
.p-preview-img a img{
    max-height: 300px;
}
.p-img-thumbnail a img{
    width: 100%;
    height: 100%;
}
/*----company products css ends----*/
.header-bg{
    background-repeat: no-repeat !important;
    background-size: 100% 100% !important;
    min-height:400px;
}
.h-inner{
    position:relative;
    min-height:400px;
    display: -webkit-box;
}
.logo-absolute{
    position:absolute;
    bottom:-60px;
    display:inherit;
    width:100%;
}
.com-details{width:auto;}
.logo-box{
    height:200px;
    width:200px;
    padding:0px;
    background:#fff;
    display:table; 
    text-align:center;
    border-radius:4px;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.3);
    position:relative;
}
.logo{
    display:table-cell;
    vertical-align: middle;
}
.logo img, .logo canvas{
    border-radius:4px;
    max-height: 200px;
    width: 100%;
}
#upload-logo{
    margin-bottom:0px;
}
.com-name{
    font-size:40px;
    font-family:lora;
    color:#fff;
    padding: 0 0 0 30px; 
    display: flex;
    flex-wrap: wrap;
    line-height: 31px;
    margin-bottom: 10px;
}
.com-establish{
    color:#fff;
    padding: 0 0 0 30px; 
    font-size:15px;
    font-family:roboto;
}
.com-establish .detail-title{
    font-weight:bold;
    color:#fafafa;
}
.nav-padd-20{
    padding-left:50px;
}

@media screen and (min-width: 992px) and (max-width:1200px){
       .nav-padd-20{
        padding-left:90px;
    }
}
@media screen and (max-width: 992px){
    .img1 img{
        width:180px;
        height:125px;
        object-fit:cover;
    }
    .nav-padd-20{
        padding-left:120px;
        padding-bottom:20px;
    }
    .follow-btn,.social-btns{
        text-align:right
    }
}
@media screen and (max-width: 768px){
.com-name{display:block;margin-top: 20px;}
    .img1 img{
        width:100%;
        height:100%;   
    }
    .logo-box{
        margin:0 auto;
    }
    .padd-top-0{
        padding-top: 0px!important;
        margin-top:-20px !important;
    }
    .h-inner{
        display: block;
        min-height:500px;
        text-align: center;
    }
    .com-name {
        font-size: 32px;
    }
    .com-establish {
        font-size: 14px;
    }
    .follow-btn, .social-btns{
        text-align:center;
        margin-top:20px;
    }
    .logo-absolute{
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%, -50%);
    }
    .nav-padd-20{
        text-align:center;
        padding-left:0px;
    }
    .header-inner{
        height:100%;
        width:100%;
        padding:50px 0;
    }
    .team-text{
        top: 152px;
        left: auto;
        right: 10px;
        -webkit-transform: none;
        -ms-transform: none;
        transform: none;
    }
    .know-bet {
        display: none;
    }
    .team-container .team-overlay {
        height: 100%;
        background-color: transparent;
    }
    
}
@media screen and (max-width: 600px){
.org-location{flex-basis:99%;}
.maxData .org-location{width:99%;}
}
.followed {
    background: #00a0e3;
    color: #fff;
}
.cover-bg-color{
    height: 100%;
    width: 100%;
    position: absolute;
    background-color: #00000057;
}
.user-rating{
    padding: 20px 0px;
    flex-flow: row wrap;
}
.ur-bg {
    padding: 10px 6px;
    margin-bottom:10px;
}
.sub-review-box{
    display: flex;
    flex: 1 auto;
    align-items: center;
    justify-content: center;
    background: #00a0e3;
    border-radius: 6px;
    padding: 10px 20px;
    color: #fff;
    margin-top:20px;
    position:relative;
}
.reviewers {
	text-align: left;
	padding-left: 10px;
	font-family: roboto;
}
.rs-main{
    max-width: 200px;
    padding: 10px 13px 15px 14px;
    text-align: center;
    color: #fff;
    border-radius: 6px;
    display: inline-block;
    float: left;
    width: 100%;
}
.com-rating-1{
    margin-top:15px;
}
.sub-heading-review {
	font-size: 17px;
	font-weight: 500;
	margin: 10px 0px;
	font-family: roboto;
}
.btn-default{
    background-color:#fff;
    border-radius:4px;
    padding: 12px 20px;
    display: inline-block;
    -webkit-box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.12);
    box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.12);
    color: #00a0e3;
}
.btn-default:hover, .btn-default:focus{
    background-color:#fff;
    -webkit-box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.18);
    box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.18);
    color: #00a0e3;
}
.rating-large{
    font-size:60px;
}
.com-rating-1 i{ 
    font-size:16px;
    background:#fff;
    color:#ccc;
    padding:7px 5px;
    border-radius:5px;
    margin-bottom:5px;
}
.com-rating-1 i.active{
    background:#fff;
    color:#00a0e3;
}   
.more{
    display:none;
}
.morecontent span {
    display: none;
}
.morelink {
    display: inline-block;
    color: #00a0e3;
}
.morelink:focus, .morelink:hover{
    color: #00a0e3;
}
');
$script = <<<JS
$(document).on('click','.follow',function(e){
    e.preventDefault();
    var org_id = $('#organisation_id').val();
    $.ajax({
        url:'/organizations/follow',
        data: {org_id:org_id},                         
        method: 'post',
        beforeSend:function(){
         $('.follow').html('<i class="fas fa-circle-notch fa-spin fa-fw"></i>');
        },
        success:function(data){  
            if(data.message == 'Following'){
                $('.follow').html('Following');
                $('.follow').addClass('followed');
            }
            else if(data.message == 'Unfollow'){
                $('.follow').html('Follow');
                $('.follow').removeClass('followed');
            }
        }
    });        
});

var first_preview = $('.p-img-thumbnail:first-child a').attr('href');
$('.p-preview-img a').attr('href', first_preview);
$('.p-preview-img a img').attr('src', first_preview);

$(document).on('mouseover', '.p-img-thumbnail', function(){
    var path = $(this).find('a').attr('href');
    $('.p-preview-img a').attr('href', path);
    $('.p-preview-img a img').attr('src', path);
});
$(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 1500;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    

    $('.more').each(function() {
        var content = $(this).html();
        if(content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
            $(this).html(html);
        }
        $(this).css('display','block');
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});

function getPastCards(type = 'Jobs',container = '.pastblogbox', url = window.location.pathname, container_id = null) {
    let data = {};
    page = 1;
    const searchParams = new URLSearchParams(window.location.search);
    searchParams.append("page", page);
    for(var pair of searchParams.entries()) {
        data[pair[0]] = pair[1];                                                                                                                                                                                                              ; 
    }
    
    data['type'] = type;
    $.ajax({
        method: "POST",
        url : url,
        data: data,
        success: function(response) {
            if(response.status === 200) {
                renderCards(response.cards, container);
                utilities.initials();
                if(container_id){
                    $(container_id).find('.ji-apply').css('pointer-events',"none");
                    $(container_id).find('.application-card-add').css('pointer-events',"none");
                    $(container_id).find('.ji-apply').attr('data-app',"");
                    $(container_id).find('.ji-apply').attr('data-org',"");
                }
            }else{
                if(container_id){
                    if($('#jobs-cards-past').hasClass('hidden') || $('#internships-cards-past').hasClass('hidden')){
                        $('#grand-parent-past').addClass('hidden');
                    }
                    $(container_id).addClass('hidden');
                }
            }
        }
    })
}
JS;
$this->registerJs("
return_message = true;
jobs_parent = '#jobs-cards-main';
internships_parent = '#internships-cards-main';
grand_parent = '#grand-parent-opportunities';
loader = false;
getCards('Jobs','.blogbox','/organizations/organization-opportunities/?org=" . $organization['slug'] . "');
getCards('Internships','.internships_main','/organizations/organization-opportunities/?org=" . $organization['slug'] . "');
getPastCards('Jobs','.pastblogbox','/organizations/organization-past-opportunities/?org=" . $organization['slug'] . "','#jobs-cards-past');
getPastCards('Internships','.pastinternships_main','/organizations/organization-past-opportunities/?org=" . $organization['slug'] . "','#internships-cards-past');
addToReviewList();
");
$this->registerJs($script);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDYtKKbGvXpQ4xcx4AQcwNVN6w_zfzSg8c', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/jquery.fancybox.min.css');
$this->registerJsFile('@eyAssets/js/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);