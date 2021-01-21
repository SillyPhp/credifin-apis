<?php

use frontend\models\applications\CandidateApply;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use frontend\models\script\ImageScript;

$separator = Yii::$app->params->seo_settings->title_separator;
$slug = $org['slug'];
$this->params['url'] = $org['website'];
echo $this->render('/widgets/drop_resume', [
    'username' => Yii::$app->user->identity->username,
    'type' => 'application',
    'slug' => $slug
]);
$job_heading = (($data2['cat_name']) ? ($data2['cat_name']) : ($data1['cat_name']));
if ($type == 'Job') {
    if (!empty($data2['interview_process_enc_id'])) {
        $app_locations = $data2['applicationPlacementLocations'];
    } else {
        $app_locations = (($data1['applicationPlacementCities']) ? $data1['applicationPlacementCities'] : $data2['applicationPlacementCities']);
    }
    if (!empty($app_locations)) {
        $location = ArrayHelper::map($app_locations, 'city_enc_id', 'name');
        $lc_data = "";
        $lc = "";
        $locations = [];
        $loc = [];
        foreach ($app_locations as $placements) {
            array_push($locations, $job_heading . " jobs in " . $placements["name"]);
            array_push($loc, $placements["name"]);
        }
        $lc_data = implode(", ", array_unique($locations));
        $lc = implode(", ", array_unique($loc));
    }
    $smililars = 'jobs';
    if (!empty($data2)) {
        if ($data2['wage_type'] == 'Fixed') {
            if ($data2['wage_duration'] == 'Monthly') {
                $data2['fixed_wage'] = $data2['fixed_wage'] * 12;
            } elseif ($data2['wage_duration'] == 'Hourly') {
                $data2['fixed_wage'] = $data2['fixed_wage'] * 40 * 52;
            } elseif ($data2['wage_duration'] == 'Weekly') {
                $data2['fixed_wage'] = $data2['fixed_wage'] * 52;
            }
            setlocale(LC_MONETARY, 'en_IN');
            $amount = '₹' . utf8_encode(money_format('%!.0n', $data2['fixed_wage'])) . ' p.a.';
        } else if ($data2['wage_type'] == 'Negotiable') {
            if ($data2['wage_duration'] == 'Monthly') {
                $data2['min_wage'] = $data2['min_wage'] * 12;
                $data2['max_wage'] = $data2['max_wage'] * 12;
            } elseif ($data2['wage_duration'] == 'Hourly') {
                $data2['min_wage'] = $data2['min_wage'] * 40 * 52;
                $data2['max_wage'] = $data2['max_wage'] * 40 * 52;
            } elseif ($data2['wage_duration'] == 'Weekly') {
                $data2['min_wage'] = $data2['min_wage'] * 52;
                $data2['max_wage'] = $data2['max_wage'] * 52;
            }
            setlocale(LC_MONETARY, 'en_IN');
            if (!empty($data2['min_wage']) && !empty($data2['max_wage'])) {
                $amount = '₹' . utf8_encode(money_format('%!.0n', $data2['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data2['max_wage'])) . ' p.a.';
            } elseif (!empty($data2['min_wage'])) {
                $amount = 'From ₹' . utf8_encode(money_format('%!.0n', $data2['min_wage'])) . ' p.a.';
            } elseif (!empty($data2['max_wage'])) {
                $amount = 'Upto ₹' . utf8_encode(money_format('%!.0n', $data2['max_wage'])) . ' p.a.';
            } elseif (empty($data2['min_wage']) && empty($data2['max_wage'])) {
                $amount = 'Negotiable';
            }
        }
    } else {
        if ($data1['wage_type'] == 'Fixed') {
            if ($data1['wage_duration'] == 'Monthly') {
                $data1['fixed_wage'] = $data1['fixed_wage'] * 12;
            } elseif ($data1['wage_duration'] == 'Hourly') {
                $data1['fixed_wage'] = $data1['fixed_wage'] * 40 * 52;
            } elseif ($data1['wage_duration'] == 'Weekly') {
                $data1['fixed_wage'] = $data1['fixed_wage'] * 52;
            }
            setlocale(LC_MONETARY, 'en_IN');
            $amount = '₹' . utf8_encode(money_format('%!.0n', $data1['fixed_wage'])) . ' p.a.';
        } else if ($data1['wage_type'] == 'Negotiable') {
            if ($data1['wage_duration'] == 'Monthly') {
                $data1['min_wage'] = $data1['min_wage'] * 12;
                $data1['max_wage'] = $data1['max_wage'] * 12;
            } elseif ($data1['wage_duration'] == 'Hourly') {
                $data1['min_wage'] = $data1['min_wage'] * 40 * 52;
                $data1['max_wage'] = $data1['max_wage'] * 40 * 52;
            } elseif ($data1['wage_duration'] == 'Weekly') {
                $data1['min_wage'] = $data1['min_wage'] * 52;
                $data1['max_wage'] = $data1['max_wage'] * 52;
            }
            setlocale(LC_MONETARY, 'en_IN');
            if (!empty($data1['min_wage']) && !empty($data1['max_wage'])) {
                $amount = '₹' . utf8_encode(money_format('%!.0n', $data1['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data1['max_wage'])) . ' p.a.';
            } elseif (!empty($data1['min_wage'])) {
                $amount = 'From ₹' . utf8_encode(money_format('%!.0n', $data1['min_wage'])) . ' p.a.';
            } elseif (!empty($data1['max_wage'])) {
                $amount = 'Upto ₹' . utf8_encode(money_format('%!.0n', $data1['max_wage'])) . ' p.a.';
            } elseif (empty($data1['min_wage']) && empty($data1['max_wage'])) {
                $amount = 'Negotiable';
            }
        }
    }
    $this->title = $org['org_name'] . ' is hiring for ' . (($data2['cat_name']) ? $data2['cat_name'] : $data1['cat_name']);
    $keywords = $org['org_name'] . ' jobs,Freshers jobs,Software Jobs,IT Jobs, Technical Jobs,' . $job_heading . ' Jobs,  MBA Jobs, Career, Walk-ins ' . $job_heading . ', ' . rtrim($lc_data, ',') . ',Part Time Jobs,Top 10 Websites for jobs,Top lists of job sites,Jobs services in india,top 50 job portals in india,' . $job_heading . ' jobs in india for freshers';
    $description = 'Empower Youth is a career development platform where you can find your dream job and give wings to your career.';
}
if ($type == 'Internship') {
    if (!empty($data2['applicationPlacementLocations'])) {
        $app_locations = $data2['applicationPlacementLocations'];
    } else if (!empty($data1['applicationPlacementCities'])) {
        $app_locations = $data1['applicationPlacementCities'];
    } else {
        $app_locations = $data2['applicationPlacementCities'];
    }
    if (!empty($app_locations)) {
        $location = ArrayHelper::map($app_locations, 'city_enc_id', 'name');
        $lc_data = "";
        $lc = "";
        $locations = [];
        $loc = [];
        foreach ($app_locations as $placements) {
            array_push($locations, $job_heading . " internships in " . $placements["name"]);
            array_push($loc, $placements["name"]);
        }
        $lc_data = implode(", ", array_unique($locations));
        $lc = implode(", ", array_unique($loc));
    }
    $smililars = 'internships';
    if ($data2['wage_type'] == 'Fixed') {
        if ($data2['wage_duration'] == 'Weekly') {
            $data2['fixed_wage'] = $data2['fixed_wage'] / 7 * 30;
        }
        setlocale(LC_MONETARY, 'en_IN');
        $amount = '₹' . utf8_encode(money_format('%!.0n', $data2['fixed_wage'])) . ' p.m.';
    } elseif ($data2['wage_type'] == 'Negotiable' || $data2['wage_type'] == 'Performance Based') {
        if ($data2['wage_duration'] == 'Weekly') {
            $data2['min_wage'] = $data2['min_wage'] / 7 * 30;
            $data2['max_wage'] = $data2['max_wage'] / 7 * 30;
        }
        setlocale(LC_MONETARY, 'en_IN');
        $amount = '₹' . utf8_encode(money_format('%!.0n', $data2['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data2['max_wage'])) . ' p.m.';
    }

    if ($data1['wage_type'] == 'Fixed') {
        if ($data1['wage_duration'] == 'Weekly') {
            $data1['fixed_wage'] = $data1['fixed_wage'] / 7 * 30;
        }
        setlocale(LC_MONETARY, 'en_IN');
        $amount = '₹' . utf8_encode(money_format('%!.0n', $data1['fixed_wage'])) . ' p.m.';
    } elseif ($data1['wage_type'] == 'Negotiable' || $data1['wage_type'] == 'Performance Based') {
        if ($data1['wage_duration'] == 'Weekly') {
            $data1['min_wage'] = $data1['min_wage'] / 7 * 30;
            $data1['max_wage'] = $data1['max_wage'] / 7 * 30;
        }
        setlocale(LC_MONETARY, 'en_IN');
        $amount = '₹' . utf8_encode(money_format('%!.0n', $data1['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data1['max_wage'])) . ' p.m.';
    }
    $this->title = $org['org_name'] . ' is looking for ' . (($data2['cat_name']) ? $data2['cat_name'] : $data1['cat_name']) . ' interns';
    $keywords = $org['org_name'] . ' internships,Internships,Paid ' . $job_heading . ' Internships, ' . rtrim($lc_data, ',') . ', Summer Internships,top Internship sites,Top Free Internship Sevices in India,top Internship sites for students,top Internship sites for students,' . $job_heading . ' Internships near me';
    $description = 'Empower Youth Provides Internships To Students In Various Departments To Get On Job Training And Chance To Get Recruit In Reputed Organisations.';
}
if (!empty($data2)) {
    $content_logo = (($org['logo']) ? Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $org['logo_location'] . DIRECTORY_SEPARATOR . $org['logo'], 'https') : null);
} else {
    $content_logo = (($org['logo']) ? Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo . $org['logo_location'] . DIRECTORY_SEPARATOR . $org['logo'], 'https') : null);
}
$content = [
    'job_title' => (($data2['cat_name']) ? ($data2['cat_name']) : ($data1['cat_name'])),
    'company_name' => $org['org_name'],
    'bg_icon' => (($data1['profile_id']) ? $data1['profile_id'] : $data2['profile_id']),
    'canvas' => (($org['logo']) ? false : true),
    'logo' => $content_logo,
    'initial_color' => $org['color'],
    'location' => (($lc) ? $lc : 'Work From Home'),
    'app_id' => $application_details['application_enc_id'],
    'permissionKey' => Yii::$app->params->EmpowerYouth->permissionKey
];
$content['bg_icon'] = ImageScript::getProfile($content['bg_icon']);
if (empty($application_details['image']) || $application_details['image'] == 1) {
    $image = ImageScript::widget(['content' => $content]);
} else {
    $image = Yii::$app->params->digitalOcean->sharingImageUrl . $application_details['image'];
}
if (empty($application_details['square_image']) || $application_details['square_image'] == 1) {
    $Instaimage = \frontend\models\script\InstaImageScript::widget(['content' => $content]);
} else {
    $Instaimage = Yii::$app->params->digitalOcean->sharingImageUrl . $application_details['square_image'];
}
$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl("https"),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl("https"),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];

$this->params['header_dark'] = false;
$this->title = ($data2['cat_name']) ? $data2['cat_name'] : $data1['cat_name'];
if (!Yii::$app->user->isGuest) {
    $user_id = Yii::$app->user->identity->user_enc_id;
}
?>
<?=
$this->render('/widgets/employer_applications/top-banner', [
    'org_image_location' => $org['cover_image_location'],
    'org_image' => $org['cover_image'],
    'job_title' => (($data2['cat_name']) ? ($data2['cat_name']) : ($data1['cat_name'])),
    'icon_png' => (($data2['icon_png']) ? ($data2['icon_png']) : ($data1['icon_png'])),
    'shortlist' => $shortlist,
    'shortlist_btn_display' => true
]);
?>
<section>
    <div class="container">
        <div class="row m-0">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="job-single-sec">
                    <div class="job-single-head2">
                        <?php if ($type == 'Internship') {
                            if (!empty($data2)):
                                echo $this->render('/widgets/employer_applications/internship-overview', [
                                    'placement_offer' => $data2['has_placement_offer'],
                                    'profile_name' => $data2['name'],
                                    'wage_type' => $data2['wage_type'],
                                    'gender' => $data2['preferred_gender'],
                                    'ammount_value' => $amount,
                                    'placement_locations' => $app_locations,
                                ]);
                            else:
                                echo $this->render('/widgets/employer_applications/overview', [
                                    'type' => $type,
                                    'ammount_value' => $amount,
                                    'profile_name' => (($data1['name']) ? $data1['name'] : $data2['name']),
                                    'job_type' => (($data1['type']) ? $data1['type'] : $data2['type']),
                                    'gender' => (($data1['preferred_gender']) ? $data1['preferred_gender'] : $data2['preferred_gender']),
                                    'wage_type' => (($data1['wage_type']) ? $data1['wage_type'] : $data2['wage_type']),
                                    'wage_duration' => (($data1['wage_duration']) ? $data1['wage_duration'] : $data2['wage_duration']),
                                    'placement_locations' => $app_locations,
                                ]);
                            endif;
                        } else if ($type == 'Job') {
                            if (!empty($data2['interview_process_enc_id'])):
                                echo $this->render('/widgets/employer_applications/job-overview', [
                                    'profile_name' => $data2['name'],
                                    'industry' => $data2['industry'],
                                    'designation' => $data2['designation'],
                                    'job_type' => $data2['type'],
                                    'wage_type' => $data2['wage_type'],
                                    'gender' => $data2['preferred_gender'],
                                    'experience' => $data2['experience'],
                                    'ammount_value' => $amount,
                                    'placement_locations' => $data2['applicationPlacementLocations'],
                                ]);
                            else:
                                echo $this->render('/widgets/employer_applications/overview', [
                                    'type' => $type,
                                    'ammount_value' => $amount,
                                    'profile_name' => (($data1['name']) ? $data1['name'] : $data2['name']),
                                    'job_type' => (($data1['type']) ? $data1['type'] : $data2['type']),
                                    'gender' => (($data1['preferred_gender']) ? $data1['preferred_gender'] : $data2['preferred_gender']),
                                    'wage_type' => (($data1['wage_type']) ? $data1['wage_type'] : $data2['wage_type']),
                                    'experience' => (($data1['experience']) ? $data1['experience'] : $data2['experience']),
                                    'placement_locations' => (($data1['applicationPlacementCities']) ? $data1['applicationPlacementCities'] : $data2['applicationPlacementCities']),
                                    'positions' => (($data1['positions']) ? $data1['positions'] : $data2['positions']),
                                ]);
                            endif;
                        } ?>
                    </div>
                    <div class="job-details">
                        <?php if (!empty($data2['interview_process_enc_id'])) { ?>
                            <?=
                            $this->render('/widgets/employer_applications/working-days', [
                                'working_days' => $data2['working_days']
                            ]);
                            ?>
                            <?=
                            $this->render('/widgets/employer_applications/working-time', [
                                'working_time_from' => $data2['timings_from'],
                                'working_time_to' => $data2['timings_to']
                            ]);
                            ?>
                            <?=
                            $this->render('/widgets/employer_applications/employee-benefits', [
                                'benefits' => $data2['applicationEmployeeBenefits']
                            ]);
                            ?>

                            <?=
                            $this->render('/widgets/employer_applications/job-description', [
                                'job_description' => $data2['applicationJobDescriptions'],
                                'type' => $type,
                            ]);
                            ?>

                            <?=
                            $this->render('/widgets/employer_applications/educational-requirements', [
                                'educational_requirements' => $data2['applicationEducationalRequirements'],
                            ]);
                        }
                        ?>
                        <?php
                        if (!empty($data1['applicationSkills']) || !empty($data2['applicationSkills'])):
                            echo $this->render('/widgets/employer_applications/skills', [
                                'skills' => (($data1['applicationSkills']) ? $data1['applicationSkills'] : $data2['applicationSkills'])
                            ]);
                        endif;
                        ?>
                        <?=
                        $this->render('/widgets/employer_applications/other-details', [
                            'other_details' => (($data2['description']) ? $data2['description'] : $data1['description']),
                        ]);
                        ?>
                    </div>
                    <div class="job-overview">
                        <?php if (!empty($data2['applicationPlacementLocations'])): ?>
                            <?=
                            $this->render('/widgets/employer_applications/interview-details', [
                                'interview_start' => $data2['interview_start_date'],
                                'interview_end' => $data2['interview_end_date'],
                                'interview_locations' => $data2['applicationInterviewLocations'],
                            ]);
                        endif;
                        ?>
                    </div>
                    <?php
                    if (!empty($data2['applicationPlacementLocations'])) {
                        echo $this->render('/widgets/employer_applications/placement-direction', [
                            'placement_locations' => $data2['applicationPlacementLocations'],
                        ]);
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 z-index-9">
                <?php
                if (!empty($data2)):
                    echo $this->render('/widgets/employer_applications/organization-details', [
                        'org_logo' => $org['logo'],
                        'image' => $image,
                        'Instaimage' => $Instaimage,
                        'org_logo_location' => $org['logo_location'],
                        'org_name' => $org['org_name'],
                        'initial_color' => $org['color'],
                        'slug' => $org['slug'],
                        'website' => $org['website'],
                        'type' => $type,
                        'applied' => $applied,
                        'application_slug' => $application_details["slug"],
                        'shortlist' => $shortlist,
                        'shortlist_btn_display' => true,
                        'whatsAppmodel' => $whatsAppmodel
                    ]);
                else:
                    echo $this->render('/widgets/employer_applications/unclaim_org', [
                        'org_logo' => $org['logo'],
                        'image' => $image,
                        'Instaimage' => $Instaimage,
                        'org_logo_location' => $org['logo_location'],
                        'org_name' => $org['org_name'],
                        'initial_color' => $org['color'],
                        'slug' => $org['slug'],
                        'cid' => $org['organization_enc_id'],
                        'website' => $org['website'],
                        'job_url' => $data1['job_url'],
                        'application_id' => $data1['application_enc_id'],
                        'type' => $type,
                        'applied' => false,
                        'application_slug' => $application_details["slug"],
                        'shortlist' => $shortlist,
                        'shortlist_btn_display' => true,
                        'whatsAppmodel' => $whatsAppmodel
                    ]);
                endif;
                ?>

                <?= $this->render('/widgets/join-social-groups'); ?>

                <div class="new-row col-md-10 col-md-offset-1">
                    <?=
                    $this->render('/widgets/new-position',[
                        'company' => $org['org_name'], ]);
                    ?>
                </div>

                <?php
                if (Yii::$app->user->isGuest) {
                    echo $this->render('/widgets/best-platform');
                }
                ?>
            </div>
        </div>
        <?php if ($settings["showRelatedOpportunities"]): ?>
            <div class="row m-0">
                <div class="col-md-12">
                    <h2 class="heading-style">Related <?= $type . 's'; ?></h2>
                    <div class="similar-application"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
    if (!Yii::$app->user->isGuest && empty(Yii::$app->user->identity->organization)) {
        echo CandidateApply::widget(['application_enc_id' => (($data2['application_enc_id']) ? $data2['application_enc_id'] : $data1['application_enc_id']), 'btn_class' => 'apply-btn', 'organization_enc_id' => $org['organization_enc_id']]);
    }
    ?>
</section>
<?php
if ($settings["showNewPositionsWidget"]):
    ?>
    <section>
        <div class="container">
            <?=
            $this->render('/widgets/new-position');
            ?>
        </div>
    </section>
<?php endif; ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="heading-style">More <?= $type . 's'; ?> By This Company</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="blogbox"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="heading-style">Courses</div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="type-1">
                <div>
                    <a id="course-list-btn" href="<?= Url::to('/courses') ?>" target="_blank" class="btn btn-3">
                        <span class="txt-v"><?= Yii::t('frontend', 'View all'); ?></span>
                        <span class="round"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="list-main"></div>
</div>
<?php if (!empty($popular_videos)) {
    if (!empty($cat_name)) {
        $ctt = ucfirst(strtolower($cat_name));
        $category_name = str_replace(' ', '-', $ctt);
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="heading-style">Enhance Your Skills With Free Learning Videos</div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="type-1">
                    <div>
                        <a href="<?= (!empty($cat_name)) ? Url::to('/learning/videos/category/' . $category_name) : Url::to('/learning') ?>" target="_blank"
                           class="btn btn-3">
                            <span class="txt-v"><?= Yii::t('frontend', 'View all'); ?></span>
                            <span class="round"><i class="fas fa-chevron-right"></i></span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div id="mixedSlider">
                <div class="MS-content lc-items-grids">
                    <?php foreach ($popular_videos as $p) { ?>
                        <div class="item lc-single-item-main">
                            <div class="lc-item-img">
                                <a href="<?= Url::to('/learning/video/' . $p['slug']); ?>" class="lc-item-video-link" target="_blank">
                                </a>
                                <div class="lc-item-video-img"
                                     style="background-image: url(<?= Url::to($p['cover_image']); ?>);"></div>
                            </div>
                            <div class="lc-item-desciption">
                                <div class="lc-item-user-detail">
                                    <h3 class="lc-item-video-title">
                                        <a href="<?= Url::to('learning/video/' . $p['slug']); ?>" target="_blank" class="ml-20">
                                            <?= Yii::t('frontend', $p['title']); ?>
                                        </a>
                                    </h3>
                                </div>
                            </div>
                            <div class="lc-item-video-stats">
                                <span class="lc-item-video-stat marg">
                                    <?php
                                    $link = Url::to('learning/video/' . $p['slug'], 'https');
                                    ?>
                                    <a href="<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>"
                                       target="_blank">
                                            <span>
                                                <i class="fab fa-facebook-f"></i>
                                            </span>
                                        </a>
                                        <a href="<?= Url::to('https://twitter.com/intent/tweet?text=' . $link); ?>"
                                           target="_blank">
                                            <span>
                                                <i class="fab fa-twitter"></i>
                                            </span>
                                        </a>
                                        <a href="<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>"
                                           target="_blank">
                                            <span>
                                                <i class="fab fa-linkedin"></i>
                                            </span>
                                        </a>
                                </span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php }
if (!empty($data2) && Yii::$app->params->options->showSchema){
?>
    <script type="application/ld+json">
        {
            "@context" : "https://schema.org/",
            "@type" : "JobPosting",
            "title" : "<?=(($data2['cat_name']) ? $data2['cat_name'] : $data1['cat_name'])?>",
            "description" : "<?=$data2['applicationJobDescriptions']?>",
            "identifier": {
                "@type": "PropertyValue",
                "name": "Google",
                "value": "1234567"
            },
            "datePosted" : "<?=$data2['created_on']?>",
            "validThrough" : "<?= $data1['last_date']?>",
            "employmentType" : "CONTRACTOR",
            "hiringOrganization" : {
                "@type" : "Organization",
                "name" : "<?=$org['org_name']?>",
                "sameAs" : "<?=$org['website']?>",
                "logo" : "<?= Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $org['logo_location'] . DIRECTORY_SEPARATOR . $org['logo'], true)?>"
            },
            "jobLocation": {
                "@type": "Place",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "<?=$lc?>",
                    "addressCountry": "IN"
                }
            },
            "baseSalary": {
                "@type": "MonetaryAmount",
                "currency": "INR",
                "value": {
                    "value": "<?=$amount?>"
                }
            }
        }
    </script>
<?php
}
?>
<script>
    function copyToClipboard() {
        var copyText = document.getElementById("share_manually");
        copyText.select();
        document.execCommand("copy");
        toastr.success("", "Copied");
    }
</script>
<?php
echo $this->render('/widgets/mustache/application-card');
echo $this->render('/widgets/mustache/courses-card');
$this->registerCss("
.new-row{
	padding: 0;
	margin-top: 20px;
}
.course-box{
    min-height: 179px;
}
.display-block{
    display: block;
}
.recommendation-box, .job-review-box{
    width: 100%;
    position: ralative;
}
.recommendation-box button,
.job-review-box button{
    width: 100%;
    background: #ff7803;
    padding: 18px 0px;
    border: none;
    color: #fff;
    font-size: 15px;
    font-weight: bold;
    border-radius: 5px
}

.job-review-box button{
    background: #00a0e3;
}

.recommendation-box a,
.job-review-box a{
    float: right;
    font-size: 13px;
    color: #ff7803;
    font-weight: bold;
}
.job-review-box a{
    color: #00a0e3;
}
.recommendation-box a:hover{
    color: #00a0e3
}
.recommendation-box a:hover{
    color: #ff7803
}
.mt2{
    margin-top: 20px  
}
.rec-main{
    padding: 15px 0 0;
}
#mixedSlider .MS-content .item {
    display: inline-block;
    width: 31.7%;
    position: relative;
    vertical-align: top;
    height: 100%;
    white-space: normal;
    padding: 5px 10px;
    margin: 15px 8px;
}
@media (max-width: 991px) {
  #mixedSlider .MS-content .item {
    width: 47%;
  }
}
@media (max-width: 768px) {
  #mixedSlider .MS-content .item {
    width: 49%;
    margin:0px;
  }
}
@media (max-width: 550px) {
  #mixedSlider .MS-content .item {
    width: 100%;
    margin:0px;
  }
}
#mixedSlider .MS-content .item .imgTitle a {
  position: relative;
}
#mixedSlider .MS-content .item .blogTitle  a{
  color: #252525;
  font-style:normal !important;
  background-color: rgba(255, 255, 255, 0.5);
  width: 100%;
  bottom: 0;
  font-weight: bold;
  padding: 10px 0 0 0;
  font-size: 16px;
  
}
#mixedSlider .MS-content .item .imgTitle img {
  height: auto;
  width: 100%;
}
#mixedSlider .MS-content .item p {
  font-size: 16px;
  margin: 0px 0px 0 5px;
text-align: left;
  padding-top: 0px !important;
}
#mixedSlider .MS-content .item a {
  font-size: 16px;
}
.marg a {
    margin: 0px 2px;
}
#mixedSlider .MS-content .item a:hover {
  text-decoration: none;
}
.lc-single-item-main {
    z-index: 1;
}
.lc-item-img{
    position: relative;
    height: 0;
    border-radius: 6px;
    padding-top: 56.25%;
    overflow: hidden;
    background: #444857;
}
.lc-single-item-main .lc-item-video-link {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    border: 0 !important;
    z-index: 1;
}
.lc-item-img .lc-item-video-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-position: center center;
    background-size: cover;
}
.lc-single-item-main .lc-item-desciption {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    margin-top: 1rem;
    -webkit-box-ordinal-group: 4;
    -webkit-order: 3;
    -ms-flex-order: 3;
    order: 3;
}
.lc-single-item-main .lc-item-user-icon {
    display: block;
    margin-right: 0.75rem;
    position: relative;
    z-index: 1;
}
.lc-single-item-main .lc-item-user-icon>img {
    display: block;
    width: 40px;
    height: 40px;
    background: #444857;
    overflow: hidden;
    font: 10px/1 monospace;
    border-radius: 4px;
}
.lc-single-item-main .lc-item-user-detail {
    -webkit-box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    margin: 0 1rem 0 0;
}
.lc-single-item-main .lc-item-user-detail, .lc-single-item-main .lc-item-user-detail .lc-item-video-title {
    width: 95%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.lc-single-item-main .lc-item-video-title {
    font-weight: 900;
    font-size: 17px;
    margin: 0 0 0.25rem 15px;
    display: block;
}
.lc-single-item-main .lc-item-video-title a {
    color: white;
}
.lc-single-item-main .lc-item-user-sub-main {
    color: #c0c3d0;
    font: inherit;
    font-size: 14px;
    line-height: 1.2;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
}
.lc-single-item-main .lc-item-user-sub-detail {
    color: inherit;
    display: inline-block;
    position: relative;
    z-index: 1;
    -webkit-transition: 0.2s ease all;
    transition: 0.2s ease all;
}
.lc-single-item-main .lc-item-video-actions {
    position: relative;
}
.lc-item-video-stats {
    padding: 0 0 0 7px;
    height: 45px;
    z-index: 1;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    justify-content: flex-end;
    -webkit-box-align: center;  
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    font-size: 12px;
    overflow: hidden;
}
button.lc-item-video-menu {
    border: 0;
    background: none;
}
.lc-item-video-stats .lc-item-video-stat {
    font: inherit;
    margin-right: 5px;
    background: rgba(0,0,0,0.9);
    border-radius: 4px;
    padding: 2px 5px;
    color: white;
    cursor: pointer;
}
.lc-single-item-main:not(.hide-owner) .lc-item-video-stat {
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    opacity: 0;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
    -webkit-transition-property: opacity, -webkit-transform;
    transition-property: opacity, -webkit-transform;
    transition-property: transform, opacity;
    transition-property: transform, opacity, -webkit-transform;
    -webkit-transition-timing-function: cubic-bezier(1, 0, 0.65, 0.75),linear;
    transition-timing-function: cubic-bezier(1, 0, 0.65, 0.75),linear;
}
.lc-single-item-main:not(.hide-owner) .lc-item-video-stat:nth-child(2) {
    -webkit-transition-delay: 0.05s;
    transition-delay: 0.05s;
}
.lc-single-item-main:not(.hide-owner) .lc-item-video-stat:nth-child(3) {
    -webkit-transition-delay: 0.1s;
    transition-delay: 0.1s;
}
.lc-single-item-main::after {
    position: absolute;
    content: '';
    right: 0px;
    bottom: 35px;
    left: 1rem;
    top: 1rem;
    background: #202229;
    border-radius: 10px;
    z-index: -1;
    -webkit-transition: 0.3s ease;
    transition: 0.3s ease;
}
.lc-single-item-main:hover::after, .lc-single-item-main:focus::after, .lc-single-item-main:active::after {
    left: -5px;
    right: -5px;
    top: -5px;
    bottom: 0px;
}
.lc-single-item-main:not(.hide-owner):hover .lc-item-video-stat, .lc-single-item-main:not(.hide-owner):active .lc-item-video-stat, .lc-single-item-main:not(.hide-owner):focus .lc-item-video-stat {
    -webkit-transform: translateY(0);
    transform: translateY(0);
    opacity: 1;
    -webkit-transition-timing-function: cubic-bezier(0.2, 0.15, 0.1, 1),ease;
    transition-timing-function: cubic-bezier(0.2, 0.15, 0.1, 1),ease;
    -webkit-transition-delay: 0.2s;
    transition-delay: 0.2s;
}
.lc-single-item-main:not(.hide-owner):hover .lc-item-video-stat:nth-child(2), .lc-single-item-main:not(.hide-owner):active .lc-item-video-stat:nth-child(2), .lc-single-item-main:not(.hide-owner):focus .lc-item-video-stat:nth-child(2) {
    -webkit-transition-delay: 0.15s;
    transition-delay: 0.15s;
}
.lc-single-item-main:not(.hide-owner):hover .lc-item-video-stat:nth-child(3), .lc-single-item-main:not(.hide-owner):active .lc-item-video-stat:nth-child(3), .lc-single-item-main:not(.hide-owner):focus .lc-item-video-stat:nth-child(3) {
    -webkit-transition-delay: 0.1s;
    transition-delay: 0.1s;
}
.marg{
	margin-left: 125px;
	margin-bottom: 2px;
	background: none !important;
}
.marg img{
	width: 22px;
}
/*learning videos css ends */

    .z-index-9{
        z-index:9;
    }
     .sub_description_1,sub_description_2{
        display:none;
     }   
     .heading_submit{
        color:#fff;
     } 
     .sub_description{
        font-size:15px;
     }  
     #msg{
        color:#fff;
        padding: 5px 5px;
        text-align:center;
     }   
     #close_btn {
        float: right;
        display: inline-block;
        padding: 0px 6px;
        color: #fff;
        font-size: 28px;
        cursor: pointer;
    }
   
    .fader{
      width:100%;
      height:100%;
      position:fixed;
      top:0;
      left:0;
      display:none;
      z-index:99;
      background-color:#fff;
      opacity:0.7;
    }
    #warn{
        color:#e9465d;
        display:none;
    }
    .inputGroup {
      background-color: #fff;
      display: block;
      margin: 10px 0;
      position: relative;
    }
    .inputGroup label {
       padding: 6px 75px 10px 25px;
        width: 96%;
        display: block;
        margin:auto;
        text-align: left;
        color: #3C454C;
        cursor: pointer;
        position: relative;
        z-index: 2;
        transition: color 1ms ease-out;
        overflow: hidden;
        border-radius: 8px;
        border:1px solid #eee;
    }
    .inputGroup label:before {
      width: 100%;
      height: 10px;
      border-radius: 50%;
      content: '';
      background-color: #00a0e3;
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%) scale3d(1, 1, 1);
      transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
      opacity: 0;
      z-index: -1;
    }
    .inputGroup label:after {
      width: 32px;
      height: 32px;
      content: '';
      border: 2px solid #D1D7DC;
      background-color: #fff;
      background-repeat: no-repeat;
      background-position: 2px 3px;
      background-image: url(\"data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E \");
      border-radius: 50%;
      z-index: 2;
      position: absolute;
      right: 30px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      transition: all 200ms ease-in;
    }
    .inputGroup input:checked ~ label {
      color: #fff;
    }
    .inputGroup input:checked ~ label:before {
      transform: translate(-50%, -50%) scale3d(56, 56, 1);
      opacity: 1;
    }
    .inputGroup input:checked ~ label:after {
      background-color: #54E0C7;
      border-color: #54E0C7;
    }
    .inputGroup input {
      width: 32px;
      height: 32px;
      order: 1;
      z-index: 2;
      position: absolute;
      right: 30px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      visibility: hidden;
    }

    .block {
        float: left;
        padding: 60px 0;
        position: relative;
        width: 100%;
        z-index: 1;
    }
    #new_resume,#use_existing{
        display:none;
    }
    #logo_img{
        width: 115px;
        height: 115px;
        background-color:#fff;
        object-fit: contain;
    }
    .block .container{padding:0}
    .block.remove-top{padding-top:0}
    .block.no-padding{padding-top:0; padding-bottom:0; }
    .block.dark{background:#111111}
    .block.remove-bottom{padding-bottom:0}
    .block.overlape {
        z-index: 2;
    }
    section.overlape {
        z-index: 2;
    }
    .dark-color::before {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        content: '';
        background: #00000078;
        opacity: 0.8;
    }
    .dark-color::after {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        content: '';
        z-index: -1;
        opacity: 0.14;
    }
    .inner-header {
        float: left;
        width: 100%;
        position: relative;
        padding-top: 215px;
        padding-bottom: 15px;
        z-index: 0;
    }
    .inner-header.wform .job-search-sec {
        position: relative;
        float: left;
        z-index: 4;
        top: 0;
        -webkit-transform: translateX(-50%);
        -moz-transform: translateX(-50%);
        -ms-transform: translateX(-50%);
        -o-transform: translateX(-50%);
        transform: translateX(-50%);
    }
    .inner-header > h3 {
        max-width: 500px;
        position: relative;
        z-index: 1;
        color: #ffffff;
        font-weight: bold;
        font-size: 30px;
        text-align: center;
        margin: auto;
        margin-bottom: 50px;
        text-transform: capitalize;
    }
    .inner-header .container {
        position: relative;
        z-index: 1;
    }
    .job-statistic {
        float: left;
        width: 100%;
        text-align: center;
        position: relative;
        margin-top: 20px;
        margin-bottom: 50px;
        z-index: 1;
        color: #fff;
        font-size: 18px;
    }
    .job-statistic span {
        float: none;
        display: inline-block;
        font-size: 16px;
        font-family:roboto;
        border: 1px solid #ffffff;
        color: #ffffff;
        padding: 7px 20px;
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        -ms-border-radius: 20px;
        -o-border-radius: 20px;
        border-radius: 20px;
        background: #00a0e3;
        border-color: #00a0e3;
    }
    .job-statistic p {
        float: none;
        display: inline-block;
        color: #ffffff;
        font-size: 13px;
        margin: 0 20px;
    }
    .job-statistic p i {
        font-size: 23px;
        float: left;
        line-height: 29px;
        margin-right: 9px;
    }
    .container.fluid{ max-width: 100%; width: 100%; }
    .block .container{padding:0}
    .container{padding:0}
    .inner-header .container {
        position: relative;
        z-index: 1;
    }
    .job-single-sec {
        float: left;
        width: 100%;
    }
    .job-single-head2 {
        float: left;
        width: 100%;
//        padding-bottom: 30px;
//        border-bottom: 1px solid #e8ecec;
    }
    .job-single-head2 > span {
        float: left;
        width: 100%;
        font-size: 13px;
        color: #888888;
        margin-top: 20px;
    }
    .job-single-head2 > span strong {
        font-weight: normal;
        color: #202020;
    }
    .job-is {
        display: table-cell;
        vertical-align: middle;
        font-family: Open Sans;
        font-size: 12px;
        border: 1px solid;
        float: right;
        padding: 7px 0;
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        -ms-border-radius: 20px;
        -o-border-radius: 20px;
        border-radius: 20px;
        width: 108px;
        margin: 9px 0;
        text-align: center;
    }
    .job-is.ft,
    .job-list-modern .job-is.ft{
        color: #4aa1e3;
        border-color: #4aa1e3;
    }
    .job-is.ft {
        margin-top: 12px;
    }
    .job-title2 span.job-is {
        float: left;
        margin: 0;
    }
    .tags-jobs {
        float: left;
        width: auto;
        margin: 0;
        margin-top: 0px;
        margin-top: 20px;
    }
    .tags-jobs > li {
        float: left;
        margin: 0;
        margin-right: 0px;
        font-family: Open Sans;
        font-size: 13px;
        color: #888888;
        margin-right: 30px;
    }
    .tags-jobs > li i {
        float: left;
        font-size: 23px;
        float: left;
        line-height: 15px;
        margin-right: 8px;
        color: #4aa1e3;
    }
    .tags-jobs > li span {
        color: #4aa1e3;
    }
    .job-details {
        float: left;
        width: 100%;
    }
    .job-details h3 {
        float: left;
        width: 100%;
        font-family: Open Sans;
        font-size: 15px;
        color: #202020;
        margin-bottom: 15px;
        margin-top: 10px;
        font-weight: 600;
    }
    .job-details p,
    .job-details li {
        float: left;
        width: 100%;
        font-size: 13px;
        color: #888888;
        line-height: 24px;
        margin: 0;
        margin-bottom: 19px;
    }
    .job-details > ul {
        float: left;
        width: 100%;
        margin-bottom: 20px;
    }
    .job-details > ul li {
        float: left;
        width: 100%;
        margin: 0;
        margin-bottom: 0px;
        position: relative;
        padding-left: 23px;
        line-height: 21px;
        margin-bottom: 10px;
        font-size: 13px;
        color: #888888;
    }
    .job-details > ul li::before {
        position: absolute;
        left: 0;
        top: 10px;
        width: 10px;
        height: 1px;
        background: #888888;
        content: '';
    }
    .job-overview {
        float: left;
        width: 100%;
    }
    .job-overview > h3 {
        float: left;
        width: 100%;
        font-family: Open Sans;
        font-size: 15px;
        color: #202020;
        font-weight: 600;
    }
    .job-overview ul {
        float: left;
        width: 100%;
        border: 2px solid #e8ecec;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        margin: 0;
        padding-left: 15px !important;
    }
    .job-overview ul > li {
        float: left;
        width: 100%;
        margin: 0;
        position: relative;
        padding-left: 67px;
        margin: 8px 0px;
        min-height: 68px;
    }
    .job-overview ul > li i {
        position: absolute;
        left: 23px;
        top: 5px;
        font-size: 30px;
        color: #4aa1e3;
    }
    .job-overview ul > li h3 {
        float: left;
        width: 100%;
        font-size: 13px;
        font-family: Open Sans;
        margin: 0;
        color: #1e1e1e;
        font-weight: 600;
    }
    .job-overview ul > li span {
        float: left;
        width: 100%;
        font-size: 13px;
        color: #545454;
        margin-top: 4px;
    }
    .job-single-sec .job-overview ul {
        padding: 0;

        margin-bottom: 20px;
    }
    .job-single-sec .job-overview ul li {
        float: left;
        width: 33.334%;
        padding-left: 50px;
    }
    .job-single-sec .job-overview ul li i {
        left: 0;
    }
    .job-overview > a {
        float: left;
        width: 100%;
        height: 50px;
        font-size: 13px;
        background: #ef7706;
        text-align: center;
        line-height: 50px;
        color: #ffffff;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .job-overview > a.contct-user {
        background: #4aa1e3;
    }
    .job-overview ul > li:hover i {
        color: #ef7706;
    }
    .job-overview ul > li *, .job-single-head.style2 > a, .apply-job-btn, .hover-change{
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -ms-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }
    .share-bar {
        float: left;
        width: 100%;
        padding-top: 20px;
        border-top: 1px solid #e8ecec;
        border-bottom: 1px solid #e8ecec;
    }
    .share-bar span {
        float: left;
        font-size: 15px;
        color: #202020;
        line-height: 40px;
        margin-right: 14px;
    }
    .share-bar  a {
        float: none;
        display: inline-block;
        width: 47px;
        height: 35px;
        border: 2px solid;
        border-top-color: currentcolor;
        border-right-color: currentcolor;
        border-bottom-color: currentcolor;
        border-left-color: currentcolor;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        line-height: 30px;
        font-size: 18px;
        margin: 0 5px;
        margin-top: 0px;
        text-align: center;
        margin-top: 0px;
        margin-top: 6px;
    }
    .share-bar a.share-fb {
        color: #3b5998;
        border-color: #3b5998;
    }
    .share-bar  a.share-twitter {
        color: #1da1f2;
        border-color: #1da1f2;
    }
    .share-bar  a.share-google {
        color: #EA4335;
        border-color: #EA4335;
    }
    .share-bar  a.share-linkedin {
        color: #0077B5;
        border-color: #0077B5;
    }
    .share-bar  a.share-whatsapp {
        color: #4FCE5D;
        border-color: #4FCE5D;
    }
    .share-bar a.share-fb:hover {
        background: #3b5998;
        border-color: #3b5998;
        color: #ffffff;
    }
    .share-bar  a.share-twitter:hover {
        background: #1da1f2;
        border-color: #1da1f2;
        color: #ffffff;
    }
    .share-bar  a.share-google:hover {
        background: #EA4335;
        border-color: #EA4335;
        color: #ffffff;
    }
    .share-bar a:hover {
        color: #ffffff;
    }
    .share-bar a.share-linkedin:hover {
        background: #0077B5;
        border-color: #0077B5;
    }
    .share-bar a.share-whatsapp:hover {
        background: #4FCE5D;
        border-color: #4FCE5D;
    }
    .job-single-head.style2 {
        display: inherit;
        text-align: center;
        border: none;
    }
    .job-single-head.style2 .job-thumb {
        float: left;
        width: 100%;
        text-align: center;
        margin-top:20px;
    }
    .job-single-head.style2 .job-thumb img, .job-single-head.style2 .job-thumb canvas {
        float: none;
        display: inline-block;
        width: auto;
        border: none;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }
    .job-single-head.style2 .job-head-info {
        float: left;
        width: 100%;
        display: inherit;
        padding: 0;
        margin-top: 10px;
        margin-bottom: 18px;
    }
    .job-single-head.style2 .job-head-info p {
        float: left;
        width: 100%;
//        text-align: center;
        margin: 0;
        margin-top: 0px;
    }
    .job-single-head.style2 .job-head-info p i {
        float: none;
        color: #fff;
        display:inline-block;
    }
    .job-single-head.style2 .job-head-info > span {
        margin-top: 5px;
        margin-bottom: 20px;
    }
    .job-single-head.style2 > a {
        clear: both;
        display: block;
    }
    .job-single-head.style2 > a:hover {

        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        color: #ffffff;
    }
    .job-thumb {
        display: table-cell;
        vertical-align: top;
        width: 107px;
    }
    .job-thumb img {
        float: left;
        width: 100%;
        border: 2px solid #e8ecec;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
    }
    .job-head-info {
        display: table-cell;
        vertical-align: middle;
        padding-left: 25px;
    }
    .job-head-info h4 {
        float: left;
        width: 100%;
        font-family: Open Sans;
        font-size: 17px;
        font-weight: 600;
        color: #fff;
        margin: 0;
        margin-bottom: 0px;
        margin-bottom: 10px;
    }
    .job-head-info span {
        float: none;
        width: auto;
        font-size: 13px;
        color: #fff;
        line-height: 10px;
    }
    .job-head-info p {
        float: left;
        margin: 0;
        margin-top: 0px;
        margin-right: 0px;
        font-size: 13px;
        margin-right: 40px;
        color: #888;
        margin-top: 11px;
    }
    .job-head-info p i {
        float: left;
        font-size: 14px;
        line-height: 27px;
        margin-right: 9px;
        margin-top: 1px;
    }
    .apply-job-btn {
    display:flex;
    justify-content:center;
    align-items:center;    
    background: #00a0e3;
    -webkit-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    -moz-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    -ms-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    -o-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    -ms-border-radius: 2px;
    -o-border-radius: 2px;
    border-radius: 2px;
    font-family: roboto;
    font-size: 18px;
    color: #fff;
    width: 175px;
    height: auto;
    padding: 10px 6px;
    text-align: center;
    margin:auto;
}
    .apply-job-btn:hover {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        color: #fff !important;
    }
    .apply-job-btn i {
        float: none;
        font-size: 18px;
        margin-right: 6px;
        line-height: 8px;
        position: relative;
    }
    .viewall-jobs {
        background: #4aa1e3;
        width: 200px;
        height: auto;
        color: #ffffff;
        font-family: Open Sans;
        font-size: 13px;
        -webkit-border-radius: 40px;
        -moz-border-radius: 40px;
        -ms-border-radius: 40px;
        -o-border-radius: 40px;
        border-radius: 40px;
        margin:auto;
        margin-top: 15px;
        padding: 15px 30px;
    }
    .job-title2 > h3 {
        float: left;
        font-size: 20px;
        font-weight: bold;
        margin: 0;
        margin-right: 0px;
        margin-right: 20px;
    }
    .radio_questions {
      padding: 0 16px;
      max-width: 100%;
      font-size: 18px;
      font-weight: 600;
      line-height: 36px;
    }
    .parallax{
        height:100%;
        width:100%;
        margin:0;
        position:absolute;
        left:0;
        top:0;
        z-index:-1;
        background-size: cover !important;
    }
    .parallax.no-parallax {
        background-attachment: scroll !important;
        background-position: inherit !important;
    }
    .tags-bar {
        float: left;
        width: 100%;
        margin-bottom: 20px;
        border: 2px solid #e8ecec;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        padding: 10px;
        position: relative;
    }
    .tags-bar > span {
        float: left;
        background: #f4f5fa;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        font-family: Open Sans;
        font-size: 13px;
        padding: 7px 17px;
        margin-right: 15px;
        position: relative;
        margin-bottom:5px;
    }
    .shortlist_job,.shortlist_job:hover{
        color:#fff;
    }
    .shortlist_job:focus{
        color:#fff;
    }
    .col_pink{
        background: #ef7706 !important;
        border-color: #ef7706 !important;
        color: #ffffff;
    }
    .hover-change:hover {
        background: #ef7706;
        border-color: #ef7706;
        color: #ffffff;
    }
    .pf-field {
        float: left;
        width: 100%;
        position: relative;
    }
    .pf-field > input {
        height: 56px;
        float: left;
        width: 100%;
        border: 2px solid #e8ecec;
        margin-bottom: 10px;
        margin-top: 10px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        padding: 14px 45px 14px 15px;
        background: #ffffff !important;
        font-family: Open Sans;
        font-size: 13px;
        font-weight: 400;
        color: #101010;
        line-height: 24px;
        cursor: pointer;
    }
    .pf-field > i {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 20px;
        color: #848484;
        line-height: 56px;
        cursor: pointer;
    }
    @media only screen and (max-width: 575px) {
        .job-overview ul li{
             width: 50% !important;
        }
    }
    .has-success .control-label, .has-success.radio-inline label, .has-success .checkbox-inline, .has-success .radio-inline, .has-error .control-label, .has-error.radio-inline label, .has-error .checkbox-inline{
        color:inherit;
    }
    /* Feature, categories css starts */
    .cat-sec {
        float: left;
        width: 100%;
    }
    .p-category {
        float: left;
        width: 100%;
        z-index: 1;
        position: relative;
    }
    .p-category, .p-category *{
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -ms-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }
    .p-category > .p-category-view {
        float: left;
        width: 100%;
        text-align: center;
        padding-bottom: 30px;
        border-bottom: 1px solid #e8ecec;
        border-right: 1px solid #e8ecec;
    }
    .p-category > .p-category-view img {
        font-size: 70px;
        margin-top: 30px;
        line-height: initial !important;
    }
    .p-category > .p-category-view span {
        float: left;
        width: 100%;
        font-family: Open Sans;
        font-size: 15px;
        color: #202020;
        margin-top: 18px;
    }
    .p-category:hover {
        background: #ffffff;
        -webkit-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
        -moz-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
        -ms-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
        -o-box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
        box-shadow: 0px 0px 25px rgba(0,0,0,0.1);
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        width: 104%;
        margin-left: -2%;
        height: 102%;
        z-index: 10;
    }
    .p-category:hover .p-category-view {
        border-color: #ffffff;
    }
    .p-category:hover i{
        color: #f07d1d;
    }
    .row.no-gape > div {
        padding: 0;
    }
    .cat-sec .row > div:last-child .p-category-view {
        border-right-color: #ffffff;
    }
    .p-category img{
        max-width: 80px;
        max-height: 50px;
        width: auto;
    }
    .p-category .p-category-view img, .p-category .checkbox-text span i {
        color: #4aa1e3;
        font-size: 70px;
        margin-top: 30px;
        line-height: initial !important;
    }
    /* Feature, categories css ends */
    /* Profile icons css start */
    .profile_icons{
        position: absolute;
        width: 320px;
        left: 0px;
        bottom: -3px;
    }
    .background-container{
        max-width:1200px;
        padding-left: 15px;
        padding-right: 15px;
        margin:auto;
    }
    @media screen and (max-width: 1150px) and (min-width: 1025px) {
          .profile_icons{
               width: 290px;
          }
          .inner-header > h3{
               width: 400px;
          }
          .inner-header {
               padding-top: 190px;
          }
    }
    @media screen and (max-width: 1024px) and (min-width: 890px) {
          .profile_icons{
               width: 260px;
          }
          .inner-header {
               padding-top: 160px;
          }
          .inner-header > h3{
               width: 370px;
          }
    }
    @media screen and (max-width: 889px) and (min-width: 650px) {
          .profile_icons{
               width: 210px;
          }
          .inner-header > h3 {
               width: 290px;
               font-size: 22px;
               margin-bottom: 20px;
          }
          .inner-header {
               padding-top: 160px;
          }
    }
    @media screen and (max-width: 649px) and (min-width: 0px) {
          .profile_icons{
               width: 150px;
               position: relative;
               margin: auto;
               left: 0;
               bottom: 0px;
               margin-bottom: 30px;
          }
          .inner-header {
               padding-top: 90px;
          }
          .inner-header > h3 {
               font-size: 20px;
               margin-bottom: 20px;
          }
          .job-statistic{
               display:none;
          }
    }
    /* Profile icons css ends */
");

$script = <<<JS
var type = "$type";
var keyword = "$searchItems";
var cat = '';
var slugg = '$slug'

function getCourseList(keyword=null,cat=null){
    $.ajax({
        method: "POST",
        url : '/courses/courses-list',
        data:{keyword:keyword,cat:cat,page:1,limit:1},
        beforeSend: function(){
           $('.load-more-text').css('visibility', 'hidden');
           $('.load-more-spinner').css('visibility', 'visible');
        },
        success: function(response) {
            response = JSON.parse(response);
            $('.loader-main').hide();
            // $(window).animate({scrollTop:$(document).height() - ($('#footer').height() + 500)}, '300');
            $('#loadMore').addClass("loading_more");
            $('.load-more-text').css('visibility', 'visible');
            $('.load-more-spinner').css('visibility', 'hidden');
            if(response.count == 0) {
                $('#loadMore').hide();
                load_more_cards = false;
                var alreadyExist = $('#list-main').children().length;
                if(alreadyExist == 0){
                    getCourseList(); 
                }
            } else{
                page++;
                if(response.results.length > 6){
                     response.results = response.results.slice(0,6);
                }
                var template = $('#course-card').html();
                var rendered = Mustache.render(template,response.results);
                $('#list-main').append(rendered);
                $('.c-author').each(function() {
                    var strVal = $.trim($(this).text());
                    var lastChar = strVal.slice(-1);
                    if (lastChar == ',') { // check last character is string
                        strVal = strVal.slice(0, -1); // trim last character
                        $(this).text(strVal);
                    }
                });
            }
            $('#course-list-btn').attr('href','/courses/courses-list?keyword=' + keyword)
        },
        complete: function() {
            loading = true;
        }
    });
}
getCourseList(keyword,cat);

 $(document).on('click','#close_btn',function()
 {
    $('.fader').css('display','none');
    $(this).parent().removeClass('show');
});
loader = false;
addToReviewList();
getCards(type + 's','.blogbox','/organizations/organization-opportunities/?org=' + slugg);
JS;
$this->registerJs($script);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
