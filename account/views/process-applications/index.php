<?php

use borales\extensions\phoneInput\PhoneInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

$base_url = 'https://empoweryouth.com';
switch ($application_name['application_type']) {
    case 'Jobs':
        $app_type = 'job';
        break;
    case 'Internships':
        $app_type = 'internship';
        break;
}
if ($application_name['application_for'] == 2) {
    $slug_base = 'https://www.myecampus.in/detail?id=';
} else {
    $slug_base = '/' . $app_type . '/';
}
if ($application_name['wage_type'] == 'Fixed') {
    if ($application_name['wage_duration'] == 'Monthly') {
        $application_name['fixed_wage'] = $application_name['fixed_wage'] * 12;
    } elseif ($application_name['wage_duration'] == 'Hourly') {
        $application_name['fixed_wage'] = $application_name['fixed_wage'] * 40 * 52;
    } elseif ($application_name['wage_duration'] == 'Weekly') {
        $application_name['fixed_wage'] = $application_name['fixed_wage'] * 52;
    }
    setlocale(LC_MONETARY, 'en_IN');
    $amount = '₹ ' . utf8_encode(money_format('%!.0n', $application_name['fixed_wage'])) . ' p.a.';
} else if ($application_name['wage_type'] == 'Negotiable') {
    if ($application_name['wage_duration'] == 'Monthly') {
        $application_name['min_wage'] = $application_name['min_wage'] * 12;
        $application_name['max_wage'] = $application_name['max_wage'] * 12;
    } elseif ($application_name['wage_duration'] == 'Hourly') {
        $application_name['min_wage'] = $application_name['min_wage'] * 40 * 52;
        $application_name['max_wage'] = $application_name['max_wage'] * 40 * 52;
    } elseif ($application_name['wage_duration'] == 'Weekly') {
        $application_name['min_wage'] = $application_name['min_wage'] * 52;
        $application_name['max_wage'] = $application_name['max_wage'] * 52;
    }
    setlocale(LC_MONETARY, 'en_IN');
    if (!empty($application_name['min_wage']) && !empty($application_name['max_wage'])) {
        $amount = '₹ ' . utf8_encode(money_format('%!.0n', $application_name['min_wage'])) . ' - ' . '₹ ' . utf8_encode(money_format('%!.0n', $application_name['max_wage'])) . ' p.a.';
    } elseif (!empty($application_name['min_wage'])) {
        $amount = 'From ₹ ' . utf8_encode(money_format('%!.0n', $application_name['min_wage'])) . ' p.a.';
    } elseif (!empty($application_name['max_wage'])) {
        $amount = 'Upto ₹ ' . utf8_encode(money_format('%!.0n', $application_name['max_wage'])) . ' p.a.';
    } elseif (empty($application_name['min_wage']) && empty($application_name['max_wage'])) {
        $amount = 'Negotiable';
    }
} else if ($application_name['wage_type'] == 'Unpaid') {
    $amount = 'Unpaid';
}
$user_pCount = [];
$rejected_count = 0;
foreach ($application_name['interviewProcessEnc']['interviewProcessFields'] as $p) {
    $user_pCount[$p['field_name']] = 0;
    foreach ($fields as $u) {
        if ($p['sequence'] == $u['current_round']) {
            if ($u['status'] != 'Rejected') {
                $user_pCount[$p['field_name']] += 1;
            } else {
                $rejected_count += 1;
            }
        }
    }
}
$hcount = 0;
foreach ($fields as $f) {
    if ($f['status'] == 'Hired') {
        $hcount += 1;
    }
}

// grtting positions by location

$locations = [];
foreach ($application_name['applicationPlacementLocations'] as $apl) {
    if ($locations[$apl['city_enc_id']]) {
        $singleLoc = [];
        $singleLoc['name'] = $apl['name'];
        $singleLoc['positions'] = $locations[$apl['city_enc_id']]['positions'] + $apl['positions'];
        $locations[$apl['city_enc_id']] = $singleLoc;
    } else {
//        $locations[$apl['name']] = $apl['positions'];
        $singleLoc = [];
        $singleLoc['name'] = $apl['name'];
        $singleLoc['positions'] = $apl['positions'];
        $singleLoc['count'] = 0;
        $locations[$apl['city_enc_id']] = $singleLoc;
    }
}

foreach ($fields as $f) {
    foreach ($f['appliedApplicationLocations'] as $c) {
        $locations[$c['city_enc_id']]['count'] += 1;
    }
}

?>
<div class="bg-img"></div>
<div class="hamburger-jobs">
    <button class="ajBtn" onclick="showJobsSidebar()"><i class="fa fa-bars"></i></button>
    <div class="pa-sidebar" id="hamburgerJobs">
        <?php
        foreach ($similarApps as $app) {
            $cnt = 0;
            $arry = [];
            $more = false;
            ?>
            <div class="jobCard <?= ($app['application_enc_id'] == $application_id) ? 'activeJov' : '' ?>">
                <a href="<?= Url::to('/account/process-applications/') . $app['application_enc_id'] ?>">
                    <div class="jc-icon">
                        <img src="<?= Url::to('@commonAssets/categories/' . $app['icon']); ?>">
                    </div>
                    <div class="jc-details">
                        <h3><?= $app['job_title'] ?></h3>
                        <p>
                            <?php
                            if ($app['applicationPlacementLocations']) {
                                foreach ($app['applicationPlacementLocations'] as $ps) {
                                    $cnt += $ps['positions'];
                                    if (count($arry) >= 3) {
                                        $more = true;
                                    } else {
                                        array_push($arry, $ps['name']);
                                    }
                                }
                                echo implode(', ', array_unique($arry));
                                echo $more ? ' and more' : ' ';
                            } else {
                                echo 'Work From Home';
                            }
                            ?></p>
                        <p><?= $cnt ?> Openings</p>
                        <p><?= count($app['appliedApplications']) ?> Applications</p>
                    </div>
                    <div class="activeIcon <?= ($app['application_enc_id'] == $application_id) ? 'activeIconNone' : '' ?>">
                        Active
                    </div>
                </a>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="job-det col-md-12 row">
            <div class="col-md-4 col-sm-12">
                <div class="j-main">
                    <div class="j-logo">
                        <?php if ($application_name['icon']) { ?>
                            <img src="<?= Url::to('@commonAssets/categories/' . $application_name['icon']); ?>">
                        <?php } ?>
                    </div>
                    <div class="j-data">
                        <div class="j-title">
                            <a href="<?= $slug_base . $application_name['slug'] ?>" target="_blank">
                                <?= $application_name['job_title'] ?></a>
                        </div>

                        <div class="j-share">
                            <span class="fbook" data-toggle="tooltip" title="Share on Facebook"><a href="javascript:;"
                                                                                                   onclick="window.open('<?= 'https://www.facebook.com/sharer/sharer.php?u=' . Url::to($slug_base . $application_name['slug'], 'https'); ?>', '_blank', 'width=800,height=400,left=200,top=100');"><i
                                            class="fa fa-facebook"></i></a></span>
                            <span class="wts" data-toggle="tooltip" title="Share on Whatsapp"><a
                                        href="javascript:;"
                                        onclick="window.open('<?= 'https://api.whatsapp.com/send?text=' . Url::to($slug_base . $application_name['slug'], 'https'); ?>', '_blank', 'width=800,height=400,left=200,top=100');"><i
                                            class="fa fa-whatsapp"></i></a></span>
                            <span class="twt" data-toggle="tooltip" title="Share on Twitter"><a href="javascript:;"
                                                                                                onclick="window.open('<?= 'https://twitter.com/intent/tweet?text=' . Url::to($slug_base . $application_name['slug'], 'https'); ?>', '_blank', 'width=800,height=400,left=200,top=100');"<i
                                        class="fa fa-twitter"></i></a></span>
                            <span class="mail" data-toggle="tooltip" title="Share via Email"><a href="javascript:;"
                                                                                                onclick="window.open('<?= 'mailto:?&body=' . Url::to($slug_base . $application_name['slug'], 'https'); ?>', '_blank', 'width=800,height=400,left=200,top=100');"<i
                                        class="fa fa-envelope"></i></a></span>
                            <span class="link" data-toggle="tooltip" title="Share on LinkedIn"><a
                                        href="javascript:;"
                                        onclick="window.open('<?= 'https://www.linkedin.com/shareArticle?mini=true&url=' . Url::to($slug_base . $application_name['slug'], 'https'); ?>', '_blank', 'width=800,height=400,left=200,top=100');"<i
                                        class="fa fa-linkedin"></i></a></span>
                            <span class="j-">
                            <?php
                            $link = Url::to($slug_base . $application_name['slug'], "https");
                            ?>
                            <a href="javascript:;" class="clipb tt jj-clipboard" type="button" data-toggle="tooltip"
                               title="Copy Link" data-link="<?= $link ?>">
                                <i class="fa fa-clipboard"></i>
                            </a>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="j-detail">
                    <div class="j-exp" style="margin-bottom: 22px;">
                        <div class="e-logo"><i class="fa fa-clock-o"></i></div>
                        <div class="e-detail">
                            <h1>Experience</h1>
                            <p><?= $application_name['experience'] ?></p>
                        </div>
                    </div>
                    <div class="j-exp loc">
                        <div class="e-logo"><i class="fa fa-map-marker"></i></div>
                        <div class="e-detail">
                            <h1>Locations</h1>
                            <p>
                                <?php
                                $l = [];
                                $cntt = 0;
                                $more = false;
                                if ($application_name['applicationPlacementLocations']) {
                                    foreach ($application_name['applicationPlacementLocations'] as $apl) {
                                        if (count($l) >= 5) {
                                            $more = true;
                                        } else {
                                            array_push($l, $apl['name']);
                                        }
                                        $cntt += $apl['positions'];
                                    }
                                    echo implode(', ', array_unique($l));
                                    echo $more ? ' and more' : '';
                                } else {
                                    echo 'Work From Home';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <div class="j-detail">
                    <div class="j-exp salry" style="margin-bottom: 22px;">
                        <div class="e-logo"><i class="fa fa-money"></i></div>
                        <div class="e-detail">
                            <?php
                            if ($app_type == "internship") {
                                ?>
                                <h1>Offered Stipend</h1>
                                <p><?= $amount ?></p>
                                <?php
                            } else {
                                ?>
                                <h1>Offered Salary</h1>
                                <p><?= $amount ?></p>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="j-detail">
                    <div class="j-exp salry">
                        <div class="e-logo"><i class="fa fa-user-plus"></i></div>
                        <div class="e-detail">
                            <h1>Openings</h1>
                            <p>
                                <?php
                                if ($cntt <= 1) {
                                    echo $cntt . ' Opening';
                                } else {
                                    echo $cntt . ' Openings';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="ed-main">
                    <div class="option-1">
                        <span class="j-edt">
                            <a href="/account/<?= strtolower($application_name['application_type']) . '/' . $application_id ?>/edit"
                               target="_blank" data-toggle="tooltip" title=""
                               data-original-title="Edit <?= $app_type ?>"><i class="fa fa-pencil-square-o"></i></a>
                        </span>
                        <span class="j-cln">
                            <a href="/account/<?= strtolower($application_name['application_type']) . '/' . $application_id ?>/clone"
                               target="_blank" data-toggle="tooltip" title=""
                               data-original-title="Clone <?= $app_type ?>"><i class="fa fa-clone"></i></a>
                        </span>
                        <span class="j-delt">
                            <a href="#" id="j-delete" data-toggle="tooltip" title="Delete <?= $app_type ?>"
                               value="<?= $application_id ?>"><i class="fa fa-trash-o"></i></a>
                        </span>
                        <span class="j-cls">
                            <a href="#" id="j-closed" data-toggle="tooltip" title="Close <?= $app_type ?>"
                               data-name="<?= $app_type ?>" value="<?= $application_id ?>"><i
                                        class="fa fa-times"></i></a>
                        </span>

                    </div>
                    <div class="scd-btn">
                        <a href="/account/schedular/interview?app_id=<?= $application_name['application_enc_id'] ?>">Schedule
                            Interview</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12 use-ff">
                <div class="col-md-6 col-sm-12">
                    <div class="job-txt pos-left">Invite Candidates via</div>
                    <div class="dis-flex">
                        <div class="job-mail">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            <button class="redd" id="email-invitation"><i class="fa fa-envelope"></i></button>
                        </div>
                        <div class="job-whatsapp">
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'whatsapp-form',
                                'fieldConfig' => [
                                    'template' => '<div class="form-group">{input}{error}</div>',
                                    'labelOptions' => ['class' => ''],
                                ],
                            ]);
                            ?>
                            <?=
                            $form->field($whatsAppmodel, 'phone')->textInput(['id' => 'phone-input']);
                            ?>
                            <p id="phone-error" style="color:red;" class="help-block help-block-error"></p>
                            <button class="grn" id="whatsapp-invitation"><i class="fa fa-whatsapp"></i></button>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="job-txt pos-right" data-toggle="tooltip"
                         data-original-title="To Filter Candidates Click on City Name">Openings By Locations <i
                                class="fa fa-info-circle"></i></div>
                    <div class="main-locations">
                        <?php if ($application_name['applicationPlacementLocations']) { ?>
                            <ul class="location-posts">
                                <?php $k = 0;
                                foreach ($locations as $key => $val) { ?>
                                    <li class="filter-application-by-location"
                                        data-loc="<?= $key ?>"><?= $val['name'] . '<span>' . $val['count'] . '</span>' ?></li>
                                    <?php
                                    if ($k >= 2) {
                                        break;
                                    }
                                    $k++;
                                } ?>
                            </ul>
                            <?php if (count($locations) > 3) { ?>
                                <a href="javascript:;" class="and-more"> View All </a>
                            <?php } ?>
                        <?php } else { ?>
                            <span class="work-home">Work From Home</span>
                        <?php } ?>
                        <div class="hidden-locations">
                            <?php if ($application_name['applicationPlacementLocations']) { ?>
                                <ul class="location-postss">
                                    <?php $kk = 0;
                                    foreach ($locations as $key => $val) {
                                        if ($kk > 2) { ?>
                                            <li class="filter-application-by-location"
                                                data-loc="<?= $key ?>"><?= $val['name'] . '<span>' . $val['count'] . '</span>' ?></li>
                                        <?php }
                                        $kk++;
                                    } ?>
                                </ul>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <?php
    Pjax::begin(['id' => 'pjax_process']);
    ?>
    <div class="set-height">
        <ul class="nav nav-tabs pr-process-tab" id="myHeader">
            <li class="active" id=""
                style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 3; ?>)">
                <a data-filter="*" href="#" onclick="roundClick()">All <span><?php
                        foreach ($user_pCount as $v) {
                            $pcnt += $v;
                        }
                        echo $pcnt + $hcount + $rejected_count;
                        ?></span></a>
            </li>
            <?php
            $k = 0;
            foreach ($application_name['interviewProcessEnc']['interviewProcessFields'] as $p) {
                $tooltipTitle = ($p['field_name'] == 'Get Applications') ? 'New Application' : $p['field_name'];
                ?>
                <li id="<?= 'nav' . $p['field_enc_id'] ?>"
                    style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 3; ?>)">
                    <a data-filter=".<?= $p['field_enc_id'] . $k ?>" data-toggle="tooltip" data-placement="bottom"
                       title="" onclick="roundClick()" data-original-title="<?= $tooltipTitle ?>" href="#">
                        <i class="<?= $p['icon'] ?>"
                           aria-hidden="true"></i><span><?= $user_pCount[$p['field_name']] ?></span>
                    </a>
                </li>
                <?php
                $k++;
            }
            ?>
            <li style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 3; ?>)">
                <a data-filter=".result" data-toggle="tooltip" data-placement="bottom" data-original-title="Hired"
                   href="#" onclick="roundClick()">
                    <i class="fa fa-check-square-o"></i><span>
                        <?php
                        echo $hcount;
                        ?>
                    </span>
                </a>
            </li>
            <li style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 3; ?>)">
                <a data-filter=".rejected" data-toggle="tooltip" data-placement="bottom" data-original-title="Rejeted"
                   href="#" onclick="roundClick()">
                    <i class="fas fa-times"></i><span>
                        <?php
                        echo $rejected_count;
                        ?>
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <ul class="hiring_process_list gallery_zoom content-stick">
        <?php
        if (!empty($fields)) {
            foreach ($fields as $arr) {
                $j = 0;
                $fieldMain = "";
                if ($arr['status'] == 'Hired') {
                    $tempfieldMain = "result";
                    $fieldName = "Hired";
                } else if ($arr['status'] == 'Rejected') {
                    $tempfieldMain = "rejected";
                    $fieldName = "Rejected";
                } else {
                    $fieldName = "Applied";
                    $tempfieldMain = "";
                }
                foreach ($arr['appliedApplicationProcesses'] as $p) {
                    if ($j == $arr['active'] && $arr['status'] != 'Rejected') {
                        $fieldMain = $p['field_enc_id'];
                        $fieldName = $p['field_name'];
                        $tempfieldMain = $p['field_enc_id'] . $j;
                        break;
                    }
                    $j++;
                }
                $rejectionType = $arr['candidateRejections'][0]['rejection_type'];
                ?>
                <li class="single-item-field <?php echo $tempfieldMain;
                foreach ($arr['appliedApplicationLocations'] as $cID) {
                    echo " " . $cID['city_enc_id'] . " ";
                } ?>" data-key="<?= $fieldMain ?>" data-id="<?= $arr['applied_application_enc_id'] ?>">

                    <div class="row pr-user-main">
                        <div class="reject-box" <?= (($arr['rejection_window'] == 1) ? 'style="display: flex;"' : '') ?>>
                            <div class="pr-top-actions text-right">
                                <a href="<?= Url::to($arr['username'] . '?id=' . $arr['applied_application_enc_id'], true) ?>"
                                   target="_blank">View
                                    Profile</a>

                                <?php if (!empty($arr['resume_location']) || !empty($arr['resume'])) { ?>
                                    <a href="javascript:;" class="download-resume" target="_blank"
                                       data-key="<?= $arr['resume_location'] ?>" data-id="<?= $arr['resume'] ?>"
                                       data-name="<?= $arr['name'] ?>">Download
                                        Resume</a>
                                <?php } ?>
                                <!--                                            <a href="#" class="tt" data-toggle="tooltip" title="Request to Complete Profile"><i class="fa fa-id-card"></i></a>-->
                                <!--                                            <a href="#">Request to Complete Profile</a>-->
                            </div>
                            <a class="pr-user-n url-forward" href="javascript:void(0)" data-id="<?= '/' . $arr['username'] . '?id=' . $arr['applied_application_enc_id'] ?>"><?= $arr['name'] ?></a>

                            <div class="rejectReason rejectRea"
                                 id="rejectReason" <?= $rejectionType ? 'style="display: none"' : '' ?>>
                                <form class="reasonsForm" id="<?= $arr['applied_application_enc_id'] . 'reasonForm' ?>">
                                    <p>Reason for rejection</p>
                                    <ul class="rejectReasonsList">
                                        <?php
                                        foreach ($reasons as $reason) {
                                            ?>
                                            <li>
                                                <div class="reasonsReject">
                                                    <input type="checkbox"
                                                           value="<?= $reason['rejection_reason_enc_id'] ?>"
                                                           name="<?= $arr['applied_application_enc_id'] . 'reasons' ?>"
                                                           id="<?= $reason['rejection_reason_enc_id'] . $arr['applied_application_enc_id'] ?>"
                                                           class="">
                                                    <label for="<?= $reason['rejection_reason_enc_id'] . $arr['applied_application_enc_id'] ?>"><?= $reason['reason'] ?></label>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </form>
                                <form>
                                    <div class="addReasonBox">
                                        <input type="text" name="addReason" placeholder="Add Reason">
                                        <button type="button" class="addReasonBtn">Add</button>
                                    </div>
                                </form>
                                <button type="button" class="doneBtn getReasonsId">Done</button>
                                <button type="button" value="<?= $arr['applied_application_enc_id']; ?>"
                                        class="doneBtn reconBtn reconsiderBtn">Reconsider
                                </button>
                            </div>
                            <div class="rejectReason rejectType"
                                 id="rejectType" <?= $rejectionType ? 'style="display: none"' : '' ?>>
                                <form class="reasonsType" id="<?= $arr['applied_application_enc_id'] . 'reasonType' ?>">
                                    <p>Rejection Type</p>
                                    <ul>
                                        <li>
                                            <div class="reasonsReject">
                                                <input type="radio" value="1"
                                                       name="<?= $arr['applied_application_enc_id'] . 'rejectType' ?>"
                                                       id="<?= $arr['applied_application_enc_id'] . 'permanent' ?>"
                                                       class="">
                                                <label for="<?= $arr['applied_application_enc_id'] . 'permanent' ?>">Blacklist
                                                    Candidate</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="reasonsReject">
                                                <input type="radio" value="2"
                                                       name="<?= $arr['applied_application_enc_id'] . 'rejectType' ?>"
                                                       id="<?= $arr['applied_application_enc_id'] . 'consider' ?>"
                                                       onclick="showJobsModal()" class="">
                                                <label for="<?= $arr['applied_application_enc_id'] . 'consider' ?>">Consider
                                                    For Other Job</label>
                                                <!--                                                <button type="button" class="showJobs" >-->
                                                <!--                                                    Consider For Other Job-->
                                                <!--                                                </button>-->
                                            </div>
                                        </li>
                                        <li>
                                            <div class="reasonsReject">
                                                <input type="radio" value="3"
                                                       name="<?= $arr['applied_application_enc_id'] . 'rejectType' ?>"
                                                       id="<?= $arr['applied_application_enc_id'] . 'save' ?>" class="">
                                                <label for="<?= $arr['applied_application_enc_id'] . 'save' ?>">Save For
                                                    Later</label>
                                            </div>
                                        </li>
                                    </ul>
                                </form>
                                <button type="button" onclick="showRejectReason(this)" class="doneBtn reconBtn">Back
                                </button>
                                <button type="button" value="<?= $arr['applied_application_enc_id']; ?>"
                                        class="doneBtn sendReasons">Done
                                </button>
                            </div>

                            <div class="rejectReason showRejection" <?= $rejectionType ? 'style="display: flex"' : '' ?>>
                                <div class="sr-box">
                                    <?php
                                    switch ($rejectionType) {
                                        case 1:
                                            $msg = 'This candidate has been rejected';
                                            break;
                                        case 2:
                                            $msg = 'The candidate has been considered for following jobs';
                                            break;
                                        case 3:
                                            $msg = "Candidate has been saved for later. Please check candidate's profile in 
                                            Saved Candidates section";
                                            break;
                                        case 4:
                                            $msg = "This candidate has been rejected";
                                            break;
                                    }
                                    ?>
                                    <p><?= $msg ?></p>
                                    <?php
                                    if ($arr['candidateRejections'][0]['candidateConsiderJobs']) {
                                        ?>
                                        <div class="sr-jobs">
                                            <?php
                                            $cCount = count($arr['candidateRejections'][0]['candidateConsiderJobs']);
                                            $cCount -= 2;
                                            $i = 0;
                                            foreach ($arr['candidateRejections'][0]['candidateConsiderJobs'] as $crj) {
                                                if ($i == 2) {
                                                    break;
                                                }
                                                ?>
                                                <a href="javascript:void(0)" data-href="/<?= $app_type . "/" . $crj['applicationEnc']['slug'] ?>" class="customJobBox">
                                                    <div class="jc-icon">
                                                        <img src="<?= Url::to('@commonAssets/categories/' . $crj['applicationEnc']['icon']); ?>">
                                                    </div>
                                                    <p><?= $crj['applicationEnc']['job_title'] ?></p>
                                                </a>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                            <p id="<?= $arr['candidateRejections'][0]['candidate_rejection_enc_id'] ?>"
                                               class="cCount" <?= (($cCount >= 1) ? 'style="display: block"' : 'style="display: none"') ?>> <?= $cCount ?>
                                                More</p>
                                        </div>
                                        <?php
                                    } else if ($arr['candidateRejections'][0]['candidateRejectionReasons']) {
                                        ?>
                                        <ul class="cr-reasons">
                                            <li class="colorRed">Reasons:</li>
                                            <?php
                                            foreach ($arr['candidateRejections'][0]['candidateRejectionReasons'] as $crr) {
                                                ?>
                                                <li><?= $crr['reason'] ?></li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 pr-user-inner-main">
                            <div class="col-md-4">
                                <div class="pr-user-detail">
                                    <a class="pr-user-icon url-forward" href="#"
                                       data-id="<?= '/' . $arr['username'] . '?id=' . $arr['applied_application_enc_id'] ?>"
                                       target="_blank">
                                        <?php if ($arr['image']) : ?>
                                            <img src="<?= $arr['image'] ?>"
                                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?= $arr['name'] ?>&size=200&rounded=false&background=<?= str_replace('#', '', $arr['initials_color']) ?>&color=ffffff'"/>
                                        <?php else : ?>
                                            <canvas class="user-icon" name="<?= $arr['name'] ?>" width="80"
                                                    color="<?= $arr['initials_color']; ?>" height="80"
                                                    font="35px"></canvas>
                                        <?php endif; ?>
                                    </a>
                                    <a class="pr-user-n url-forward" href="#"
                                       data-id="<?= '/' . $arr['username'] . '?id=' . $arr['applied_application_enc_id'] ?>"
                                       target="_blank"><?= $arr['name'] ?></a>
                                    <div class="clamp-c">
                                        <?php
                                        if ($arr['createdBy']['userWorkExperiences']) {
                                            foreach ($arr['createdBy']['userWorkExperiences'] as $exp) {
                                                if ($exp['is_current'] == 1) {
                                                    echo '<h5>' . $exp["title"] . ' @ ' . $exp["company"] . '</h5>';
                                                    break;
                                                }
                                            }

                                            $crexperience = [];
                                            foreach ($arr['createdBy']['userWorkExperiences'] as $exp) {
                                                if ($exp['is_current'] == 1) {
                                                    array_push($crexperience, $exp);
                                                }
                                            }
                                            if (count($crexperience) > 1) {
                                                ?>
                                                <div class="all-data">
                                                    <?php
                                                    foreach ($crexperience as $exp) {
                                                        echo '<h5>' . $exp["title"] . ' @ ' . $exp["company"] . '</h5>';
                                                    }
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="pr-user-past">
                                    <?php
                                    $experience = [];
                                    if ($arr['createdBy']['userWorkExperiences']) {
                                        foreach ($arr['createdBy']['userWorkExperiences'] as $exp) {
                                            if ($exp['is_current'] == 0) {
                                                array_push($experience, $exp["company"]);
                                            }
                                        }
                                        $str = implode(", ", array_unique($experience));
                                        if ($str) {
                                            ?>
                                            <span class="past-title">Past</span>
                                            <h5>
                                                <?= rtrim($str, ','); ?>
                                            </h5>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <!--                                    <span>+2 more</span>-->
                                </div>
                                <?php
                                if ($arr['createdBy']['userEducations']) {
                                    ?>
                                    <div class="pr-user-past">
                                        <span class="past-title">
                                            Edu
                                        </span>
                                        <h5><?= $arr['createdBy']['userEducations'][0]['institute'] . ' - ' . $arr['createdBy']['userEducations'][0]['degree']; ?> </h5>
                                        <?php
                                        if (COUNT($arr['createdBy']['userEducations']) > 1) {
                                            ?>
                                            &nbsp
                                            <span>+<?= COUNT($arr['createdBy']['userEducations']) - 1 ?> more</span>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="pr-user-past">
                                    <span class="past-title">Applied Date</span>
                                    <h5><?= date('d M Y', strtotime($arr['created_on'])) ?></h5>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="pr-user-skills">
                                    <ul class="s-skill" id="skill-sett">
                                        <?php
                                        if ($arr['createdBy']['userSkills']) {
                                            foreach ($arr['createdBy']['userSkills'] as $skill) {
                                                ?>
                                                <li><?= $skill['skill']; ?></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                    <!--                                    <h4><span>Occupaiton:</span> Design, Entry Level, Research <span>+7</span></h4>-->
                                </div>
                                <div class="pref-indus">
                                    <?php
                                    $industry = [];
                                    if ($arr['createdBy']['userPreferredIndustries']) {
                                        foreach ($arr['createdBy']['userPreferredIndustries'] as $ind) {
                                            array_push($industry, $ind["industry"]);
                                        }
                                        $str2 = implode(", ", array_unique($industry));
                                        if ($str2) {
                                            ?>
                                            <h4>
                                                <span>Industry: </span>
                                                <?= rtrim($str2, ','); ?>
                                            </h4>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3 pl-0">
                                <div class="pr-user-actions">
                                    <div class="pr-top-actions text-right">
                                        <a href="<?= Url::to($arr['username'] . '?id=' . $arr['applied_application_enc_id'], true) ?>"
                                           target="_blank">View
                                            Profile</a>
                                        <?php
                                        if (!empty($arr['resume_location']) || !empty($arr['resume'])) { ?>
                                            <a href="javascript:;" class="download-resume" target="_blank"
                                               data-key="<?= $arr['resume_location'] ?>" data-id="<?= $arr['resume'] ?>"
                                               data-name="<?= $arr['name'] ?>">Download Resume</a>
                                        <?php } ?>
                                        <!--                                            <a href="#" class="tt" data-toggle="tooltip" title="Request to Complete Profile"><i class="fa fa-id-card"></i></a>-->
                                        <!--                                            <a href="#">Request to Complete Profile</a>-->
                                    </div>
                                    <ul>
                                        <!--                                            <li>-->
                                        <!--                                                <a href="#">-->
                                        <!--                                                    <img src="-->
                                        <? //= Url::to('@eyAssets/images/pages/dashboard/email2.png') 
                                        ?>
                                        <!--"/>-->
                                        <!--                                                </a>-->
                                        <!--                                            </li>-->
                                        <!--                                            <li>-->
                                        <!--                                                <a href="#" class="tt" title="Schedule Interview -->
                                        <? //= $arr['name'] 
                                        ?>
                                        <!--" data-toggle="tooltip">-->
                                        <!--                                                    <img src="-->
                                        <? //= Url::to('@eyAssets/images/pages/dashboard/calendar.png') 
                                        ?>
                                        <!--"/>-->
                                        <!--                                                </a>-->
                                        <!--                                            </li>-->
                                        <?php
                                        if ($arr['hiringProcessNotes']) {
                                            $notes = $arr['hiringProcessNotes'][0]['notes'];
                                        } else {
                                            $notes = '';
                                        }
                                        ?>
                                        <li>
                                            <?php
                                            if (!empty($arr['phone']) && $arr['phone']) {
                                                ?>
                                                <a href="https://api.whatsapp.com/send?phone=<?= $arr['phone'] ?>"
                                                   target="_blank" title="Contact Candidate" data-toggle="tooltip"
                                                   class="shareBtn"><i class="fa fa-whatsapp"></i></a>
                                                <?php
                                            }
                                            ?>
                                        </li>
                                        <?php if ($arr['status'] != 'Hired' && $arr['status'] != 'Cancelled') { ?>
                                            <li>
                                                <a href="/account/schedular/interview?app_id=<?= $application_id ?>&applied_id=<?= $arr['applied_application_enc_id'] ?>&current_round=<?= $arr['current_round'] ?>"
                                                   title="Schedule Interview" data-toggle="tooltip">
                                                    <img src="<?= Url::to('@eyAssets/images/pages/dashboard/interview-schedule.png') ?>"/>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <li class="notes" data-toggle="tooltip" title="Notes">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/notes-icon-circle.png') ?>"
                                                 class="noteImg" data-val="<?= $notes; ?>">
                                        </li>
                                        <li>
                                            <a href="#" class="open_chat tt" data-id="<?= $arr['created_by']; ?>"
                                               data-key="<?= $arr['name']; ?>"
                                               data-img="<?= (($arr['image']) ? $arr['image'] : "https://ui-avatars.com/api/?name=" . $arr['name'] . "&size=200&rounded=false&background=" . str_replace('#', '', $arr['initials_color']) . "&color=ffffff") ?>"
                                               title="Chat Now" data-toggle="tooltip">
                                                <img src="<?= Url::to('@eyAssets/images/pages/dashboard/chat-button-blue.png') ?>"/>
                                            </a>
                                        </li>
                                        <!--                        <li>-->
                                        <!--                            <i class="fa fa-phone-square"></i>-->
                                        <!--                        </li>-->
                                    </ul>
                                    <div class="round-detail">
                                        <h5>Current Round:</h5>
                                        <h4><?= $fieldName; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pr-user-action-main">
                            <?php if ($arr['status'] == 'Hired') { ?>
                                <div class="pr-full-height">
                                    <a href="javascript:;">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/hiredc.png'); ?>"/>
                                    </a>
                                </div>
                            <?php } elseif ($arr['status'] == 'Rejected') { ?>
                                <div class="pr-full-height">
                                    <a href="javascript:;">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/rejectedc.png'); ?>"/>
                                    </a>
                                </div>
                            <?php } elseif ($arr['status'] == 'Cancelled') { ?>
                                <div class="pr-full-height">
                                    <a href="javascript:;">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/cbc.png'); ?>"/>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <div class="pr-half-height">
                                    <a href="javascript:;" class="approve"
                                       value="<?= $arr['applied_application_enc_id']; ?>"
                                       data-total="<?= $arr['total']; ?>">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/approve.png'); ?>"/>
                                    </a>
                                    <div class="dropdown">
                                        <button class="dropbtn"><i class="fa fa-chevron-down"></i></button>
                                        <div class="dropdown-content">
                                            <?php
                                            $isHighlight = true;
                                            foreach ($arr['appliedApplicationProcesses'] as $p) {
                                                $roundName = trim($p['field_name']) == 'Get Applications' ? 'New Applications' : $p['field_name'];
                                                ?>
                                                <div data-id="<?= $p['field_enc_id'] ?>">
                                                    <a href="#"
                                                       class="multipleRound <?= $p['is_completed'] == 1 ? 'disable-step' : '' ?> <?php if ($isHighlight) {
                                                           if ($p['is_completed'] == 0) {
                                                               echo 'showBlue';
                                                               $isHighlight = false;
                                                           }
                                                       } ?>" value="<?= $p['applied_application_enc_id']; ?>">
                                                        <i class="<?= $p['icon'] ?>" aria-hidden="true"></i>
                                                        <?= $roundName ?>
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div data-id="<?= $p['field_enc_id'] ?>">
                                                <a href="#" class="multipleRound"
                                                   value="<?= $arr['applied_application_enc_id']; ?>">
                                                    <i class="fa fa-check-square-o"></i> Hired
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pr-half-height">
                                    <a href="javascript:;" class="reject"
                                       value="<?= $arr['applied_application_enc_id']; ?>">
                                        <img src="<?= Url::to('@eyAssets/images/pages/dashboard/reject5.png'); ?>"/>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="slide-btn">
                            <button class="slide-bttn" type="button">
                                <i class="fa fa-angle-double-down tt" aria-hidden="true" data-toggle="tooltip"
                                   title="View Questionnaire"></i>
                            </button>
                        </div>
                    </div>
                    <div class="cd-box-border-hide">
                        <?php if (!empty($que)) { ?>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Process Name</th>
                                </tr>
                                </thead>
                                <tbody class="qu_data">
                                <?php foreach ($que as $list_que) {
                                    $linkQ = "/account/questionnaire/display-answers/" . $list_que["qid"] . "/" . $arr["applied_application_enc_id"];
                                    ?>
                                    <tr>
                                        <td><a class="blue question_list" href="<?= Url::to($linkQ, 'https') ?>"
                                               data-questionId="<?= $list_que['qid']; ?>"
                                               data-appliedId="<?= $arr['applied_application_enc_id']; ?>"
                                               target="_blank"><?= $list_que['name']; ?></a>
                                        </td>
                                        <td><?= $list_que['field_label']; ?></td>

                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <div class="without-q">
                                <h3>No Questionnaire To Display</h3>
                                <!--                                    <a href="#">Set Questionnaire</a>-->
                            </div>
                        <?php } ?>
                    </div>
                </li>
                <?php
            }
        }
        ?>
    </ul>
    <?php
    Pjax::end();
    ?>
</div>

<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-body modal-jobs">
            <span class="close" onclick="closeModal()"><i class="fas fa-times"></i></span>
            <div class="row h100">
                <div class="col-md-12">
                    <p class="modalHeading">Select Job</p>
                </div>
                <form id="considerJobsModal">
                    <?php
                    foreach ($similarApps as $app) {
                        $cnt = 0;
                        $arry = [];
                        $more = false;
                        ?>
                        <div class="col-md-3 col-sm-4">
                            <div class="suggestJob">
                                <input type="checkbox" value="<?= $app['job_title'] ?>" name="suggested-jobs"
                                       id="<?= $app['application_enc_id'] ?>">
                                <label for="<?= $app['application_enc_id'] ?>">
                                    <div class="jobCard">
                                        <div class="jc-icon">
                                            <img src="<?= Url::to('@commonAssets/categories/' . $app['icon']); ?>">
                                        </div>
                                        <div class="jc-details">
                                            <h3><?= $app['job_title'] ?></h3>
                                            <p>
                                                <?php
                                                if ($app['applicationPlacementLocations']) {
                                                    foreach ($app['applicationPlacementLocations'] as $ps) {
                                                        $cnt += $ps['positions'];
                                                        if (count($arry) >= 3) {
                                                            $more = true;
                                                        } else {
                                                            array_push($arry, $ps['name']);
                                                        }
                                                    }
                                                    echo implode(', ', array_unique($arry));
                                                    echo $more ? ' and more' : ' ';
                                                } else {
                                                    echo 'Work From Home';
                                                }
                                                ?></p>
                                            <p><?= $cnt ?> Openings</p>
                                        </div>
                                    </div>
                                </label>
                                <a href="<?= Url::to('/job/') . $app['slug'] ?>" target="_blank">
                                    <div class="clickSelect">View Job</div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="col-md-12 text-center">
                        <button class="doneCloseModal">Done</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="conjobs" class="modal">
    <div class="modal-content">
        <div class="modal-body modal-jobs">
            <span class="close" onclick="closeConJobsModal()"><i class="fas fa-times"></i></span>
            <div class="row">
                <div class="col-md-12">
                    <p class="modalHeading">Considered Jobs</p>
                </div>
            </div>
            <div class="row" id="considerJobs">

            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.has-success #phone-input {
    border-color: #c2cad8;
}
.cr-reasons{
    display: inline;
    color: #000;
}
.cr-reasons li{
    padding: 0 !important;
}
.cr-reasons li:after{
    content: ",";
    padding-left: 2px;
}
.cr-reasons li:first-child:after,
.cr-reasons li:last-child:after{
   content: "";
}
.colorRed{
    color: #ff4242; 
}
.hidden-locations{
    display:none;
}
.dis-flex {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    flex-wrap: wrap;
}
.location-posts li {
    background-color: #eee;
    padding: 6px 10px 6px 10px;
    display: inline-block;
    border-radius: 4px;
    font-family: Roboto;
    margin: 0 5px 5px 0;
}
.location-posts li span, .location-postss li span {
    background-color: #00a0e3;
    color: #fff;
    border-radius: 4px;
    display: inline-block;
    text-align: center;
    margin-left: 5px;
    padding: 0 5px;
}
#whatsapp-form .form-group{
    margin-bottom:0px;
}
#whatsapp-form .form-group .help-block, #phone-error{
    margin:0px;
}
#phone-input{
    width: 100%;
}
//.job-whatsapp {
//    margin-top: 10px !important;
//}
.errorMsg{
    position: absolute;
    margin: 0;
    font-size: 12px;
    display: none;
    color: #df4759;
}
.showError{
    display: block;
}
.clamp-c{
  position:relative;
}
.shareBtn{
    font-size: 30px;
    color: #128c7e;
}
.shareBtn:hover{
    color: #128c7e;
}
.all-data {
    position: absolute;
    background-color: #fff;
    display: none;
    border-radius:4px;
    padding:8px 15px;
    top: 30px;
    box-shadow:0px 1px 6px 2px #ddd;
}
.all-data:before {
    content: "";
    left: 12px;
    top: -18px;
    position: absolute;
    border-top: 10px solid transparent;
    border-right: 15px solid #00A0E3;
    border-bottom: 10px solid transparent;
    transform: rotate(90deg);
}
.clamp-c:hover .all-data {
    display: block;
}
.activeJov{
    background: #fbfbfb;
    border: 1px solid #eee;
    box-shadow: 0 0 4px rgba(0,0,0,.5);
}
.activeIcon{
    position: absolute;
    bottom: 0px;
    right:0px; 
    background: #00a0e3;
    color: #fff;
    padding: 3px 8px 4px;
    font-size: 13px;
    display: none;
}
.activeIconNone{
    display: block;
}
.redd{
    background-color:#f9938a;
}
.grn{
    background-color:#63c56e;
}
.job-txt {
    font-size: 14px;
    position: absolute;
    top: -21px;
    font-weight: 500;
    text-align: center;
    font-family: roboto;
    background-color: #fdfdfd;
    padding: 0px 10px;
}
.pos-left{
    left: 0px;
}
.pos-right{
    right: 0px;
}
.use-ff {
    border-top: 2px solid #e0e0e0;
    padding-top: 10px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin: 15px 0 0px;
    flex-wrap:wrap;
}
.job-mail, .job-whatsapp {
    position: relative;
    margin: 5px 10px 5px 0px;
    flex-basis:45%;
}
.location-posts {
    height: 36px;
    overflow: hidden;
    text-align:right;
    padding:0;
    margin:5px 0;
    flex-basis: 85%;
}
.and-more {
    /* background-color: #00a0e3; */
    color: #00a0e3 !important;
    padding: 6px 12px;
    display: inline-block;
    border-radius: 4px;
    font-weight: 500;
    width:80px;
}
.and-more:focus{text-decoration:none;}
.main-locations {
    text-align: right;
    font-family: roboto;
    display: flex;
    align-items: baseline;
    justify-content: flex-end;
}
.work-home {
    background-color: #b1b1b1;
    color: #fff;
    padding: 6px 10px;
    border-radius: 26px;
    display: inline-block;
    margin-top: 5px;
}
.location-postss {
    max-height: 150px;
    padding: 0;
    position: absolute;
    top: 40px;
    right: 0;
    box-shadow: 1px 4px 10px 2px #d8d8d8;
    transition: all .3s;
    z-index: 2;
    width: 180px;
    text-align: center;
    border-radius: 4px;
}
.location-postss li {
    width: 100%;
    margin: 0;
    padding: 8px 5px;
}
.location-postss li:nth-child(even){
    background-color:#f5f5f5;
}
.location-postss li:nth-child(odd){
    background-color:#fff;
}
.iti{width:100%;}
.job-mail input, .job-whatsapp input {
    height: 34px;
    padding-right: 45px;
}
.job-whatsapp button, .job-mail button {
    position: absolute;
    top: 0px;
    right: 0px;
    width: 40px;
    height: 33px;
    border: none;
    font-size:20px;
    border-radius:0px 4px 4px 0px;
    color: #fff;
}
.clipb i{
    font-size: 11px; 
    color: #ff7803
}
.page-content {
   position:relative;
    padding:0px 0px 0px 0px!important;
}
.bg-img{
    position: absolute;
    width: 100%;
    height:100%;
     background-image: url(/assets/common/categories/dot-bg.png) !important;
    background-size: cover !important;
    background-attachment: fixed !important;
    background-repeat: no-repeat !important;
    opacity: .3;
}
.modal-open{
    overflow: hidden !important;
}
.customJobBox{
    display: flex;
    box-shadow: 0 0 10px rgba(0,0,0,.1);
    color: #000;
    padding: 10px;
    margin: 10px;
    width: 300px; 
    background: #fff;
}
#considerJobs .customJobBox{
      margin: 10px 0;
    width: 100%; 
}
.customJobBox .jc-icon{
    padding-right: 10px; 
}
.font-16{
    font-size: 14px !important;
}

.sr-jobs{
    display: flex;
    align-items: center;
    justify-content: center;
}
.cCount{
    padding-left: 20px; 
    cursor: pointer;
    font-weight: 500 !important;
    font-family: roboto !important;
    font-size: 18px !important;
}
.cCount:hover{
    color: #00a0e3;
    font-family: roboto !important;
    font-weight: 500;
}
.modalHeading{
    margin-bottom: 10px;
    text-align: center;
    color: #00a0e3;
    font-size: 20px;
    font-weight: 500;
    font-family: roboto;
}
.doneCloseModal{
    background: #00a0e3;
    color: #fff;
    padding: 8px 15px;
    text-align: center;
    border: 1px solid #00a0e3;
}
.reject-box{
    display: none;
}
.reject-box .pr-top-actions{
    position: absolute;
    top: 0px;
    right: 50px;
}
.reject-box .pr-user-n{
    margin-top: 55px;
    flex-basis: 15%;
}
.h100{
    height: 100%;
}
.doneBtn, .backBtn{
    position: absolute;
    right: 0px;
    bottom: 0px;
    background: #00a0e3;
    border: 1px solid #00a0e3;
    color: #fff;
    padding: 5px 12px;
    border-radius:8px 0 8px 0;
}

.reconBtn{
    right: 75px;
    border-radius:8px 8px 0 0;
    background: #ff7803;
    border: 1px solid #ff7803;
}
.backBtn{
    left: 0px;
    right: unset;
     border-radius:0px 8px 0px 8px;
}
.addReasonBox{
    display: flex;
    max-width: 400px;
    margin:0 auto;
    position: absolute;
    left: 50%;
    width: 100%;
    bottom: 0px;
    transform: translateX(-50%);
}
.addReasonBox input{
    width: 100%;
    padding: 5px 10px;
    border: 1px solid #eee;
    border-radius: 8px 0 0 0;
}
.addReasonBox button{
    background: #00a0e3;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 0 8px 0 0;
}
#rejectType{
    display: none;
    align-items: center;
    justify-content: center;
}
.showRejection{
    display: none;
    width: 100%;
    align-items: center;
    justify-content: center;
}
.sr-box {
    color: #ff4242;
    font-family: lora;
    align-self: end;
}
.rejectReason p{
    text-align: center;
    font-size: 20px;
    margin-top: 0px;
    margin-bottom: 5px;
    color: #;
}
.customJobBox p{
    color: #333 !important;
    font-size: 16px;
    margin-bottom: 0px;
    margin-top: 0px;
    font-family: Roboto !important;
    font-weight: 500 !important;
}
.rejectReason{
    text-align: center;
    width: 100%;
}
.rejectReason ul{
    padding-inline-start: 0px;
}
.rejectReason ul li{
    display: inline-block;
    padding:5px;
}
.reasonsReject{
    position: relative;
}
.reasonsReject input,
.suggestJob input{
    position: absolute;
    visibility: hidden;
}

.reasonsReject label,
.reasonsReject button {
    border: 1px solid #333;
    color: #333;
    padding: 3px 15px;
    cursor: pointer;
    font-weight: 500;
    border-radius: 8px;
    font-size: 14px;
    background: #fff;
    text-transform: capitalize;
}
.reasonsReject button:hover{
    background: #00a0e3;
    color: #fff;
    border-color: #00a0e3;
}
.reasonsReject input:checked ~ label,
.reasonsReject label:hover{
    background: #00a0e3;
    color: #fff;
    border-color: #00a0e3;
}
.suggestJob{
    padding-bottom: 40px; 
}
.suggestJob .jobCard{
    margin: 0px;
    z-index: 2;
}
.suggestJob label{
    border: 1px solid transparent;
}
.suggestJob input:checked ~ label{
    border: 1px solid #00a0e3; 
}
.clickSelect{
    margin: 0px;
    padding: 5px 15px;
    background: #00a0e3;
    color: #fff;
    text-align: center;
    box-shadow: 0 0 4px rgba(0,0,0,.1);
    border-radius: 0 0 5px 5px; 
    z-index: 1;
    cursor: pointer;
}
.pr-process-tab li a span{
    padding: 3px 8px;
    font-weight: bold;
}
.jc-details ul{
    padding-inline-start: 0px;
}
.jc-details ul li{
    display: inline;
}
.jobCard{
    box-shadow: 0 0 4px rgba(0,0,0,.1);
    padding: 10px 8px;
    margin: 5px;
//    min-height: 130px;
    position: relative;
}
.hamburger-jobs .jobCard a{
    display: flex;
    color: #333;
    min-height: 100px;
}
.suggestJob label{
    width: 100%;
    margin-bottom: 0px;
}
.suggestJob label .jobCard {
    display: flex;
    color: #000;
    width: 100%;
    margin: 0px;
}
.jc-icon{
    width: 50px;
    height: 50px;
}
.jc-icon img{
    width: 100%;
    height: 100%; 
}
.jc-details{
    margin-left: 10px;
}
.jc-details p{
    margin-top: 5px;
    margin-bottom: 5px;
}
.jc-details h3{
    font-size: 16px;
    margin-bottom: 0px;
    margin-top: 0px;
    font-family: Roboto;
    font-weight: 500;
}

.ajBtn{
    position: absolute;
    top: 40px;
    right: -46px;
    background: #00a0e3;
    border: 1px solid #00a0e3;
    color: #fff;
    padding: 5px 10px;
    border-radius: 0 5px 5px 0;
    width: 45px;
}
.ajBtn i{
    margin-right: 5px;
}
.hamburger-jobs{
    background: #fff;
    height: auto;
    position: fixed;
    top: 62px;
    left: 0;
    border: 1px solid #eee;
    width: 0px;
    height: calc(100vh - 62px);
    transition: .3s ease;
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    z-index: 999;
}
.pa-sidebar{
    width: 100%;
    height: calc(100vh - 70px);
    overflow-x: hidden;
    z-index: 999;
}
.pa-sidebar-show{
    width: 300px;
    transition: .3s ease;
    padding: 10px;
}
.hamburger-btn{
    position: absolute; 
    right: -35px;
    top: 15px;
    background: #00a0e3;
    padding: 5px 10px;
    border: 1px solid #00a0e3;
    color: #fff;
}
.showBlue{
    color: #fff !important;
    background: #00a0e3 !important;
    pointer-events: none;
}
.notes{
    cursor: pointer;
}
.disable-step{
    pointer-events: none;
    opacity: 0.6;
}
.noteText{
    min-height: 200px;    
    resize: none;
    font-size: 15px;
    padding: 5px 10px;
    border: none;
    width: 100%;
    margin-bottom: 28px
}
.noteForm{
    position: absolute;
    top: -120%;
    right: 0px;
    padding: 5px;
    background: #fff;
    border: 1px solid #eee;
    box-shadow: 0px 0px 10px rgba(0,0,0,.2);
    z-index: 9;
    max-width: 300px;
    width: 100%;
    border-radius: 10px;
}
.noteForm button{
    padding: 5px 20px;
    font-size: 14px;
    height:25px;
    display: flex;
    align-items: center;
    justify-content: center; 
    background: #00a0e3;
    color: #fff;
    border: 1px solid #00a0e3;
    position: absolute;
    bottom: 0;
    right: 0; 
    border-radius: 10px 0 10px 0;
}
.noteForm button:hover{
    background: #fff;
    color: #00a0e3;
    transition: .3s ease;
}
.noteInput p{
    font-size: 17px;
    font-weight: 500;
    text-transform: uppercase;
    margin: 0;
    border-bottom: 1px solid #eee;
}
.noteInput input{
    border: 1px solid #eee;
    font-size: 15px;
    padding: 5px 10px;
}
.dropbtn {
	background-color: #4CAF50;
	color: white;
	padding: 1px 1px 2px 2px;
	font-size: 12px;
	border: none;
	cursor: pointer;
	font-weight: 600;
	text-align: center;
	border-radius: 0 4px 0;
}
.dropdown {
	position: absolute;
	display: inline-block;
	top: -1px;
	right: 0;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 200px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  right:0;
  padding: 0;
}
.dropdown-content div a {
  color: #000;
  padding: 8px 0 8px 12px;
  text-decoration: none;
  display: block;
  border-bottom: 1px solid #eee;
  text-align:left;
}
.dropdown-content div:last-child a{
    border-bottom: none;
}
.dropdown-content div a:hover {
    background-color: #00a0e3;
    color: #fff;   
}
.dropdown:hover .dropdown-content {
  display: block;
}
.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}
.pref-indus h4 {
    font-size: 14px;
    font-family: roboto;
    padding:0 10px;
}
.pref-indus h4 span {
    font-weight: 400;
}
.set-height{height:55px;}
.sticky {
    position: fixed;
    top: 65px;
    width: 83.45vw;
    z-index: 99;
    background: rgb(255, 255, 255);
    border-radius: 0 0 20px 20px;
    padding: 15px 0px 0;
    box-shadow: 0 9px 13px rgba(147, 145, 145, 0.1);
}
.sticky li{
    margin:0 !important;
}
.sticky + .content-stick {
    padding-top: 55px;
}
.fbook a{
    color: #4267B2;
}
.wts a{
	color: #00bf8f;
}
.twt a{
	color: #00aced;
}
.mail a {
	color: #b00;
}
.link a {
	color: #007bb6;
}
.job-det.col-md-12 {
	box-shadow: 0px 3px 10px 2px #ddd;
	margin: 30px 0;
	padding: 25px 15px 10px;
	background: #fdfdfd;
}
.j-main {
	display: flex;
	border-right: 2px solid #bdb7b7;
	align-items:center;
}
.j-logo {
    width: 85px;
    height: 85px;
}
.j-logo img {
	width: 85px;
	height: 85px;
	object-fit: contain;
}
.j-data {
	margin-left: 15px;
	text-align: center;
}
.j-app {
	border: 2px solid #00a0e3;
	color: #00a0e3;
	border-radius: 4px;
	margin-top: 5px !important;
	padding: 4px 0;
	width: 150px;
	margin: auto;
	margin-bottom: 5px !important;
}
.j-title{
	font-size: 18px;
	display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom:10px;
}
.j-title a{
    color:#333;
    font-family: roboto;
    text-transform:capitalize;
} 
.j-share span {
	margin: 0 5px;
}
.j-share span i {
	font-size: 16px;
	margin: 5px 0;
}
.j-exp {
	display: flex;
}
.e-detail h1 {
	margin: 0;
	font-size: 16px;
	font-family: roboto;
	font-weight:400;
	line-height: 22px;
}
.e-detail p {
    margin: 0;
    font-size: 11px;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height:15px;
}
.e-logo i {
    font-size: 22px;
    color: #00a0e3;
    margin-top: 8px; 
}
.e-logo {
    width: 30px;
}
.ed-main {
	text-align: center;
}
.option-1 {
	margin: 15px 0 20px;
}
.option-1 span i {
	font-size: 18px;
	margin: 0 8px;
	color: #000;
}
.scd-btn a{
	background-color: #ff7803;
	color: #fff;
	font-size: 14px;
	font-family: roboto;
	padding: 8px 15px;
	border-radius: 4px;
	display:inline-block;
}
.without-q {
	display: flex;
	justify-content: space-between;
	align-items: center;
}
.without-q h3{
    margin:14px 0;
}
.without-q a{
	font-size: 14px;
	font-family: roboto;
	background-color: #00a0e3;
	color: #fff;
	padding: 4px 8px;
	border-radius: 4px;
}
.tt + .tooltip > .tooltip-inner {
    min-width:140px !important;
    background-color:#00a0e3 !important;
}
.tt{
    transition: .5s ease;
}
.rotate180{
    animation: rotate180 1s 1;
    transform: rotate(180deg);
    transition: .5s ease;
}
.notes i{
    font-size: 28px;
}
.round-detail{
    text-align:center;
}
.round-detail h5{
    margin-bottom:5px;
    font-family:roboto;
}
.round-detail h4{
    margin-top: 0px;
    font-weight: 500;
    font-family:roboto;
    font-size:16px;
}
.pl-0{
    padding-left:0px;
}
li{
    list-style: none;
}
.pr-user-main{
    margin:60px 0px;
    margin-bottom: 0px;
    border-radius:4px;
    box-shadow:0px 3px 10px 2px #ddd;
    background-color: #fdfdfd;
    width:100%;
    position:relative;
}
.pr-user-inner-main{
    padding:20px 0px 0;
    padding-top: 0px;
    padding-left: 15px;
    width:calc(100% - 70px);
    font-family:roboto;
    position: relative;
}
.reject-box{
    position: absolute;
    top: 0px;
    left: 0;
    width: 100%;
    height:102%;
    background: rgba(255,255,255,255);
    z-index: 1;
    border-radius: 8px;
    padding: 10px 15px;
}
.hiring_process_list > li{
    width:100%;
    transition: .3s ease;
}
.pr-user-n{
  font-size:19px;
  font-weight:500;
  font-family:roboto;
  margin: 0px;
  display: inline-block;
  text-transform:capitalize;
  color:#000;
}
.pr-user-detail{
    padding-left: 85px;
    padding-top: 20px;
    margin-top: -10px;
    height:68px;
}
.pr-user-icon{
    display: inline-block;
    width: 90px;
    height: 90px;
    transform: translate(0px, -45px);
    border: 5px solid #fff;
    box-shadow: 0px 0px 10px 0px #ddd;
    border-radius: 4px;
    position: absolute;
    left: 0;
    background:#fff;
    z-index: 9;
}
.pr-user-icon img{
    width: 100%;
    height:100%;
}
.pr-user-detail h5{
  font-size:13px;
  font-weight: 500;
  margin: 0px 0px 8px;
  color: #858585;
}
.pr-user-detail h4 span{
  font-size:14px;
  color:#777777;
}
.pr-user-past {
    display: flex;
    align-items: center;
}
.pr-user-past span{
  display:inline-block;
  color:#aaa;
}
.pr-user-past .past-title{
  background-color:#f2f2f2;
  color:#333;
  padding:3px 15px;
  border-radius:20px;
  font-size:13px;
}
.pr-user-past h5{
  font-family:roboto;
  font-size:13px;
  margin-left:5px;
  display: -webkit-box;
-webkit-line-clamp: 1;
-webkit-box-orient: vertical;
overflow: hidden;
}
.pr-user-skills {
    margin-top: 20px;
    position: relative;
    overflow: hidden;
}
.s-skill {
    max-height: 62px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    position:relative;
}
.pr-user-skills ul, .pr-user-actions ul{list-style:none;padding:0px;}
.pr-user-skills ul li{
  display:inline-block;
  background-color:#efefef;
  padding:4px 15px;
  margin:2px;
  font-size:14px;
  color:#222;
  border-radius:30px;
}
.pr-user-skills h4{
  font-size:14px;
  font-family:roboto;
}
.pr-user-skills h4 span{
    color:#777;
}
.pr-top-actions a{
    background-color: #00a0e3;
    padding: 4px 6px;
    display: inline-block;
    border-radius: 0px 0px 4px 4px;
    color: #fff;
    font-size: 12px;
    margin:auto;
    margin-bottom:5px;
    font-family:roboto;
}
.pr-user-actions ul{
  padding-top:40px;
  display: flex;
  justify-content: flex-end;
  align-items: center;
}
.pr-user-actions ul li{
    display:inline-block;
    font-size:23px;
    margin:0px 4px;
    position: relative;
}
.pr-user-actions ul li a img{
    max-width:35px;
}
.pr-user-action-main{
  width:70px;
  float:right;
  height: 165px;
  display: block;
  position: relative;
  border-left: 1px solid #ddd;
}
.pr-half-height{
  height:50%;
  padding-top:28%;
  text-align:center;
  position:relative;
}
.pr-full-height{
    position:relative;
    height:100%;
}
.pr-full-height a img{
    position:absolute;
    width:80%;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}
.pr-half-height:first-child{
  border-bottom:1px solid #ddd;
}
.pr-half-height a img{max-width:34px;}
.pr-half-height:first-child a img{max-width:40px;}

/* Tabs css starts*/
.pr-process-tab{
    border-bottom: none;
}
.pr-process-tab li {
  display: block;
  float: left;
  position: relative;
  font-size: 1.25em;
  line-height: 1.5em;
  text-align: center;
  text-overflow: ellipsis;
  background: white;
  border: 1px solid #ccc;
  padding: 0;
  cursor: pointer;
  margin-bottom: 1em;
  color:#555;
  border-left-color:transparent !important;
  border-right-color:transparent !important;
}
.pr-process-tab li a{
    background-color:transparent !Important;
    color:#555 !Important;
    border:none !Important;
    padding: 7.5px 15px;
}
.pr-process-tab li a:hover{
    background-color:transparent;
}
.pr-process-tab li.active a{
    color:#fff !important;
}
.pr-process-tab li:before {
  content: "";
  display: block;
  position: absolute;
  z-index: 1;
  top: 0;
  right: -34px;
  width: 0;
  height: 100%;
  border: 17px solid transparent;
  border-left-color: #797979;
}
.pr-process-tab li:after {
  content: "";
  display: block;
  position: absolute;
  z-index: 1;
  top: 0;
  right: -35px;
  margin-right: 1px;
  width: 0;
  height: 100%;
  border: 17px solid transparent;
  border-left-color: white;
}
.pr-process-tab li:first-child {
  border-radius: 20px 0 0 20px;
  border-left-color: #ccc !important;
}
.pr-process-tab li:last-child {
  border-right: 1px solid #ccc !important;
  border-radius: 0 20px 20px 0;
}
.pr-process-tab li:last-child:before, .pr-process-tab li:last-child:after{
    display:none;
}
.pr-process-tab li:hover {
  background: #eee;
}
.pr-process-tab li:hover:after {
  border-left-color: #eee;
}
.pr-process-tab li.active {
  background: #00a0e3;
  border-color: #00a0e3;
}
.pr-process-tab li.active:after {
  border-left-color: #00a0e3;
}
.pr-process-tab li.active:before {
  border-left-color: #00a0e3;
}
.tooltip-inner {
    background-color: #00a0e3 !important;
    color: #fff;
    padding:5px 10px;
    border-radius:20px !important;
}
.tooltip-inner {
    background-color: #00a0e3 !important;
    color: #fff;
    padding:5px 10px;
    border-radius:20px !important;
}
.tooltip.top .tooltip-arrow {
    border-top-color: #00acd6;
}
.tooltip.bottom .tooltip-arrow{
    border-bottom-color:#00a0e3;
}
.hiring_process_list{
    padding-left:0px;
    position:relative;
}
/* Tabs css ends*/
.slide-btn{
    margin-bottom: -1px;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translate(-50%, 0px);
}
.slide-bttn{
    background:#00a0e3;
    border:none;
    color:#fff;
    border-radius:10px 10px 0 0 !important;
    padding:1px 15px;
}
.slide-bttn:hover{
    box-shadow:0px -2px 8px rgba(0, 0, 0, .3);
    transition:.3s all;     
    -webkit-transition:.3s all;     
    -moz-transition:.3s all;     
    -o-transition:.3s all; 
}
.slide-bttn:focus{
    outline:none;
}
.cd-box-border-hide{
    border:2px solid #eef1f4; 
    border-top:none;
    padding:10px 20px 0 10px; 
    background:#fff; 
    border-radius:0 0 4px 4px !important; 
    color:#999999;
    margin:0 20px; 
    display:none; 
}
#closeNotes{
    position: absolute;
    top: 5px;
    right: 5px;
    cursor: pointer;
    font-size: 17px;
}
#closeNotes:hover{
    color: #00a0e3;
}
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 9999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  border: 1px solid #888;
  width: 80%;
  height: 80%;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
  -webkit-animation-name: animatetop;
  -webkit-animation-duration: 0.4s;
  animation-name: animatetop;
  animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
  from {top:-300px; opacity:0} 
  to {top:0; opacity:1}
}

@keyframes animatetop {
  from {top:-300px; opacity:0}
  to {top:0; opacity:1}
}

/* The Close Button */
.close {
  color: white;
  float: right;
  font-size: 38px;
  font-weight: bold;
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 9;
  
}
.filter-application-by-location{
    cursor: pointer;
}
.filter-application-by-location.active{
    background-color:#00a0e3 !important;
    color:#fff;
}
.filter-application-by-location.active span{
    background-color: #fff;
    color: #00a0e3;
}
.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.modal-header {
  padding: 2px 16px;
  background-color: #5cb85c;
  color: white;
}

.modal-body {
    padding: 2px 16px;
    height: 100%;
}
.modal-body label{
    margin: 0px;
}
.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}
@media (min-width:1400px){
    .sticky{
        max-width: 1140px;
        width: 100%;
    }
}
@media screen and (max-width: 992px){
    .scd-btn a{margin-bottom:15px;}
    .job-txt{position:relative;top:0;}
    .dis-flex{margin-bottom:10px;}
    .location-posts{text-align:center;}
    .main-locations{height:auto;text-align:center;}
}
@media screen and (max-width: 768px){
    .loc{
        margin-bottom:22px;
    }
}
@media screen and (max-width: 600px){
.sticky {
    position: relative;
    width: auto;
    top:0 !important;
    z-index:1;
    background: #fff;
    padding:0px;   
}
.job-mail, .job-whatsapp{flex-basis:100%;}
.sticky li{
    margin:0 0 15px 0 !important;
}
.sticky + .content-stick {
    padding-top: 0px;
}
    .nav.nav-tabs li {
        width: 100%;
        margin-bottom: 0px;
        border-bottom: 0px;
        border-right: 1px solid #ddd;
    }
    .pr-process-tab li:first-child{border-radius:0px;}
    .pr-process-tab li:before{
        top: 34px;
        right: 2%;
        transform: rotateZ(90deg);
    }
    .pr-process-tab li:after{
        top: 34px;
        right: 2%;
        margin-right: 0px;
        transform: rotateZ(90deg);
    }
    .pr-process-tab li:last-child { 
        border-bottom: 1px solid #ccc !important;
        border-radius: 0px;
    }
}
@media screen and (max-width: 991px){
    .j-main{
        margin-bottom:20px;
        border:none;    
    }
    .pr-user-inner-main{
        width:100%;
    }
    .pr-top-actions a{border-radius:4px;}
    .pr-top-actions, .pr-user-actions ul{text-align:center;}
    .pr-user-action-main{
        width:100%;
        border-top: 1px solid #ddd;
        border-left: 0px;
        height: 75px;
    }
    .pr-half-height{
        padding-top: 15px;
        width: 49%;
        display: inline-block;
        height: 100%;
    }
    .pr-half-height:first-child{
        border-right: 1px solid #ddd;
        border-bottom: none;
    }
    .pr-full-height a img{
        width:50px;
    }
    .sticky{
        top:0px;
    }
    .slide-btn{
        right:0%;
        left: auto;
    }
    .dropbtn{
        border-radius: 0px;
    }
    .reject-box{
        height: 100%;
    }
    .doneCloseModal{
        position: relative;
        display: block;
        margin: auto;
        clear: both;
    }
}
@media screen and (max-width: 768px){
    .addReasonBox{
        position: relative;
    }
    .addReasonBox input, .addReasonBox button.pr-user-icon{
        border-radius: 0px;
    }
}
.disabled-elem{
    opacity: 0.5;
    cursor: not-allowed;
}
');
$script = <<<JS
var application_id = "$application_id";
window.onscroll = function() {myFunction()};
$(document).on('keyup','input#email', function (e){
    if (e.keyCode === 13) {
        $('#email-invitation').click();
    }
})
$('.and-more').click( function(e) {
    e.preventDefault(); // stops link from making page jump to the top
    e.stopPropagation(); // when you click the button, it stops the page from seeing it as clicking the body too
    $('.hidden-locations').toggle();
});
// $('.hidden-locations').click( function(e) {
//     // e.stopPropagation(); // when you click within the content area, it stops the page from seeing it as clicking the body too 
// });
$('body').click( function() {
    $('.hidden-locations').hide();
   });
$(document).on('click', '.filter-application-by-location', function(e){
    e.preventDefault();
    if(!$(this).hasClass('active')){
        $('.filter-application-by-location').removeClass('active');
        var cId = $(this).attr('data-loc');
        $('li[data-loc='+cId+']').addClass('active');
        $('.single-item-field').addClass('hidden');
        $('.'+cId).removeClass('hidden');
    } else {
        $(this).removeClass('active');
        $('.single-item-field').removeClass('hidden');
    }
});
$(document).on('click', '#email-invitation', function(){
    var email_id = $(this).parent().find('input#email').val();
    if(email_id != "" && typeof email_id !== "undefined"){
        $.ajax({
            method: "POST",
            data: {"email":email_id, application_id:application_id},
            beforeSend: function()
            {
                $("#email-invitation").html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function (res){
                $("#email-invitation").html('<i class="fa fa-envelope"></i>');
                if (res.status == 200) {
                    toastr.success(res.title, res.message);
                    $('#email').val("");
                } else {
                    toastr.error(res.title, res.message);
                }
            }
        });
    } else {
        alert("no email found");
    }
})
$(document).on('keyup', '#whatsAppNum', function (e){
    if(e.keyCode == 13){
        $('.share_Btn_whats').trigger('click');
    }
})
$(document).on('click', '.share_Btn_whats', function (){
    let parentElem = this.parentElement;
    let inputVal = parentElem.querySelector('#whatsAppNum').value;
    let errorMsg = parentElem.querySelector('.errorMsg');
    const num = /^[0-9-+]+$/;
    if(!inputVal.match(num) && inputVal != ''){
      errorMsg.classList.add('showError');
      return false;
    }else{
      errorMsg.classList.remove('showError');
    }
    if($('#whatsAppNum').val() != ''){
        window.open('https://api.whatsapp.com/send?phone=' +$('#whatsAppNum').val() + '&text=' + $(this).attr('data-link'));
    }
})
var header = document.getElementById("myHeader");
var sticky = header.offsetTop - 55;
function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
$(document).on('click', '.jj-clipboard',function (event) {
    event.preventDefault();
    var link = $(this).attr('data-link');
    CopyToClipboard(link, true, "Link copied");
});
function CopyToClipboard(value, showNotification, notificationText) {
    var temp = $("<input>");
    $("body").append(temp);
    temp.val(value).select();
    document.execCommand("copy");
    temp.remove();
    toastr.success("", "Link Copy to Clipboard");
}
$(document).on('click','#j-delete',function(e){
     e.preventDefault();
     var data = $(this).attr('value');
     swal({ 
             title: "Are you sure?",
             text: "This $app_type will be deleted permanently from your dashboard",
             type: "warning",
             closeOnClickOutside: false,
             showCancelButton : true,
         },
         function (isConfirm) {
           if (isConfirm){
            var url = "/account/jobs/delete-application";
            $.ajax({
                url:url,
                data:{data:data},
                method:'post',
                success:function(data){
                    if(data==true) {
                        toastr.success('Deleted Successfully', 'Success');
                        location.replace('/account/dashboard');
                    }
                    else {
                        toastr.error('Something went wrong. Please try again.', 'Opps!!');
                    }
                }
          });
        }
     })
});
$(document).on('click','#j-closed',function(e){
     e.preventDefault();
     var data_name = $(this).attr('data-name');
     var data = $(this).attr('value');
     swal({
         title: "Are you sure?",
         text: "If you close this $app_type you will stop receiving new applications",
         type: "warning",
         closeOnClickOutside: false,
         showCancelButton : true, 
     },
     function(isConfirm) {
     if (isConfirm) { 
        var url = "/account/jobs/close-application";
        $.ajax({
            url:url,
            data:{data:data},
            method:'post',
            success:function(data){
              if(data==true) {
                  toastr.success('The Application moved to Closed ' + data_name +'s', 'Success');
                }
               else {
                  toastr.error('Something went wrong. Please try again.', 'Opps!!');
               }
             }
          });
        }  
        }
     )
});
$('[data-toggle="tooltip"]').tooltip();
$(document).on('click','.slide-bttn',function(){
    $(this).parentsUntil('.pr-user-main').parent().next('.cd-box-border-hide').slideToggle('slow');
    let fontIcon = this.children;
    fontIcon[0].classList.toggle('rotate180');    
    
});
function hiring_process(){
	if(jQuery().isotope) {
		// Needed variables
		var list 		 = jQuery('.hiring_process_list');
		var filter		 = jQuery('.pr-process-tab li');

		if(filter.length){
			// Isotope Filter 
			filter.find('a').on('click', function(){
				var selector = jQuery(this).attr('data-filter');
				list.isotope({ 
					filter				: selector,
					animationOptions	: {
						duration			: 750,
						easing				: 'linear',
						queue				: false
					}
				});
				return false;
			});	

			// Change active element class
			filter.find('a').on('click', function() {
			    $("html, body").animate({ scrollTop: 200 }, "slow");
				filter.find('a').parent().removeClass('active');
				$(this).parent().addClass('active');
				return false;
			});	
		}
	}
}
hiring_process();
$(document).on('click', '.approve', function(e) {
    e.preventDefault();
    var field_id = $(this).parent().parentsUntil('li').parent().attr('data-key');
    var app_id = $(this).attr('value');
    var btn = $(this);
    var btn2 = btn.next();
    var btn3 = btn.prev();
    var total = $(this).attr('data-total');
    var listid = $('ul.pr-process-tab').find('.active').prop('id');
   $.ajax({
       url:'/account/jobs/approve-candidate',
       data:{field_id:field_id,app_id:app_id},
       method:'post',
       beforeSend:function()  {
            btn.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
            btn.attr("disabled","true");
        },    
       success:function(data){
            res = JSON.parse(data);
            if(res.status==true) {
                  disable(btn);
                btn.html('<img src="/assets/themes/ey/images/pages/dashboard/approve.png">');
                  hide_btn(res,total,btn,btn2,btn3); 
                  $.pjax.reload({container: '#pjax_process', async: false});
                  setTimeout(function() {
                    hiring_process();
                    utilities.initials();
                    shownotes();
                    if(listid){
                        $('#'+listid).find('a').click();
                    }
                  }, 100)
            } else {
               disable(btn);
               alert('something went wrong..');
            }
      }
   }) 
});
$(document).on('click','.multipleRound',function(e) {
  e.preventDefault();
  var field_id = $(this).parent().parentsUntil('li').parent().attr('data-key');
  var app_id = $(this).attr('value');
  var roundId = $(this).parent().attr('data-id');
  var prevRounds = $(this).parent().prevAll();
  var btn = $(this);
  var dataArr = [];
  var obj = {};
  prevRounds.each(function() {
        $(this).addClass('disable-step');
        dataArr.push($(this).attr('data-id'));
  });
  obj['fields']= dataArr;
  obj['app_id']= app_id;
  var listid = $('ul.pr-process-tab').find('.active').prop('id');
  $.ajax({
    url:'/account/jobs/approve-multiple-steps',
    data:obj,
    method:'post',
    beforeSend:function()  {
        btn.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
        btn.attr("disabled","true");
    }, 
    success:function(data) {
      res = JSON.parse(data);
        if(res.status==true) {
              $.pjax.reload({container: '#pjax_process', async: false});
              setTimeout(function() {
                disable(btn);
                hiring_process();
                utilities.initials();
                shownotes();
                if(listid){
                    $('#'+listid).find('a').click();
                }
              }, 100)
        } else {
           alert('something went wrong..');
        }
    }
  })
});
$(document).on('click','.reject',function(e){
    e.preventDefault();
    var btn = $(this);
    var btn2 = $(this).prev();
    var btn3 = $(this).next();
    var app_id = $(this).attr('value');
    var rootElem = btn.parentsUntil('.pr-user-main').parent();
    var rejectBox = $(rootElem).find('.reject-box');
    $.ajax({
        url:'/account/process-applications/rejection-window',
        data:{app_id:app_id},
        method:'post',
        success:function (data){
            rejectBox.css('display', 'flex');            
        }
    });
   
});
$(document).on('click', '.reconsiderBtn', function (e){
    e.preventDefault();
    var btn = $(this);
    var app_id = $(this).attr('value');
    var rejectBox = btn.parentsUntil('.reject-box').parent();
   $.ajax({
       url: '/account/process-applications/hide-rejection-window',
       data:{app_id:app_id},
       method:'post',
        beforeSend:function()  {
            btn.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
            btn.attr("disabled","true");
        }, 
       success:function(data){
           rejectBox.css('display', 'none');
            btn.html('Reconsider');
            btn.attr("disabled","false");
       }
   });
});
var selectedReasons = [];
$(document).on('click', '.getReasonsId', function (e){
    e.preventDefault;
    let btn = $(this);
    let parElem = btn.parent();
    let reasonForm = parElem.find('.reasonsForm');
    let formId = reasonForm.attr('id');
    selectedReasons = [];
    $('input[type=checkbox]:checked', '#'+formId).each(function (){
        selectedReasons.push($(this).attr('value'));
    });
    let rootElem = parElem.parent();
    if(selectedReasons.length == 0){
        alert('Please Select Atleast One Reason');
    }else{
        let rejectType = rootElem.find('.rejectType');
        rejectType.css('display', 'flex');
        parElem.css('display','none');    
    }
});
let considerJobs = [];
$(document).on('click','.doneCloseModal', function(e){
    e.preventDefault();
    let btn = $(this);
    let parElem = btn.parentsUntil('#considerJobsModal').parent();
    let formId = parElem.attr('id');
    considerJobs = [];
    $('input[type=checkbox]:checked', '#'+formId).each(function (){
        considerJobs.push($(this).attr('id'));
    });
    closeModal();
    
})
$(document).on('click','.sendReasons', function(e){
    e.preventDefault();
    let btn = $(this);
    let parElem = btn.parent();
    let rootElem = parElem.parent();
    let reasonForm = parElem.find('.reasonsType');
    let formId = reasonForm.attr('id');
    let rType = $('input[type=radio]:checked', '#'+formId).val();
    var app_id = btn.attr('value');
    if(rType != 2){
        considerJobs = [];
    }
    let showRejection = rootElem.find('.showRejection');
    showRejection.css('display', 'block');
    parElem.css('display', 'none');
    $.ajax({
        url:'/account/jobs/reject-candidate',
        data:{app_id:app_id, rejectionType:rType, considerJobs:considerJobs, reasons:selectedReasons},
        method:'post',
        beforeSend:function()  {
            btn.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
            btn.attr("disabled","true");
        },    
        success:function(data){
            if(data==true) {
                btn.hide();
                $.pjax.reload({container: '#pjax_process', async: false});
                   setTimeout(function() {
                    hiring_process(); 
                    utilities.initials();
                  }, 100)
            }
            else {
                alert('something went wrong..');
            }
            $('#considerJobsModal')[0].reset();
        }
    });
});
$(document).on('click','.addReasonBtn', function (e){
   e.preventDefault();
   var reasonInput = $(this).prev('input');
   var reason = $(this).prev('input').val().trim();
   var parentElem = $(this).parentsUntil('form').parent();
   var rootElem = parentElem.parent();
   let embedList = $(rootElem).find('.rejectReasonsList');
   $.ajax({
        url:'/account/process-applications/add-reason',
        data:{reason:reason},
        method:'post',
        success:function(data){
            res = JSON.parse(data);
            if(res['status'] == 200){
                let reasonID = res['reason_enc_id'];
                let reasonTitle = res['reason'];
                let reasonLi = document.createElement('li');
                reasonLi.innerHTML =  '<div class="reasonsReject"><input type="checkbox" value="'+ res['reason_enc_id'] +'" name="reasons" id="'+ res['reason_enc_id'] +'" class="" checked><label for="'+ res['reason_enc_id'] +'">'+ res['reason'] +'</label></div>';
                embedList[0].appendChild(reasonLi);
                reasonInput.val('');
            }else{
                
            }
        }
   })
});
$(document).on('click','.cCount', function (e){
   e.preventDefault;
   var btn = $(this);
   var reject_id = btn.attr('id');
    $('#conjobs').css('display', 'block');
    $('body').addClass('modal-open');
    $.ajax({
        url:'/account/process-applications/show-consider-jobs',
        data:{reject_id:reject_id},
        method: 'post',
        success: function (res){
           if(res['status']==200){
               $('#considerJobs').html('');
               $('#considerJobs').append(Mustache.render($('#modalJobCards').html(),res['jobs']));
           }
        }
        
    })
});
$(document).on('click','.saveNote',function(e){
     e.preventDefault();
     var note = $(this).prev('textarea').val();
     var id = $(this).closest('li').attr('data-id');
     $.ajax({
        url:'/account/process-applications/process-notes',
        data:{note:note,id:id},
        method:'post',
        success:function(data){
        }  
     });
     $(this).parentsUntil('.noteForm').parent().prev().children('img').attr('data-val',note);
     $(this).parentsUntil('.noteForm').parent().remove();
});
function hide_btn(res,total,thisObj,thisObj1,thisObj2){  
    if(res.active==total) {
        thisObj.hide();
        thisObj1.hide();
        thisObj2.show();
    }
}
$(document).on('click','.url-forward',function (e){ 
    e.preventDefault();  
    var url = $(this).attr('data-id');  
    window.open(url, "_blank"); 
});
function disable(thisObj){thisObj.html('APPROVE');thisObj.removeAttr("disabled");}

$(document).on('click','.download-resume',function (e){
    e.preventDefault();
    let btnElem = $(this);
    let resume_location = $(this).attr('data-key');
    let resume = $(this).attr('data-id');
    let htmldata = $(this).html();
    let user_name = $(this).attr('data-name');
    btnElem.addClass('disabled-elem');
    btnElem.html('<i class="fa fa-circle-o-notch fa-spin fa-fw p-0"></i>');
    $.ajax({
            url: '/users/resume-link',
            type: 'POST',
            data: {
                resume_location: resume_location,
                resume: resume
            },
            success:function(res){
                btnElem.removeClass('disabled-elem');
                btnElem.html(htmldata);
                if(res['status'] == 200){
                    let cv_link = res['cv_link'];
                    downloadAs(cv_link,user_name+get_url_extension(cv_link));
                }else if(res['status'] == 500){
                    alert('an error occurerd')
                }
            }
        })    
})
function get_url_extension( url ) {
    return '.' + url.split(/[#?]/)[0].split('.').pop().trim();
}
$(document).on('click','.customJobBox', function(e) {
    e.preventDefault();
    window.open($(this).attr('data-href'));
});
var ps = new PerfectScrollbar('#hamburgerJobs');
var pa = new PerfectScrollbar('.modal-jobs');
var locationPosts = $('.location-postss')
if(locationPosts.length > 0){
    var pj = new PerfectScrollbar('.location-postss');
}
var skillSet = $('#skill-sett')
if(skillSet.length > 0){
   var pb = new PerfectScrollbar('#skill-sett');
}
var input = document.querySelector("#phone-input");
    var iti = window.intlTelInput(input, {
        'utilsScript': "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js",
       'allowExtensions': false,
       'preferredCountries': ['in'],
       'nationalMode': false,
       'separateDialCode':true
  });
var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
function allnumeric(inputtxt){
  var numbers = /^[0-9]+$/;
  if(inputtxt.match(numbers)) {
      return true;
  }
  return false;
}
$(document).on('click', '#whatsapp-invitation', function(e){
    e.preventDefault();
    if ($('#phone-input').val()) {
      if ($('#phone-input').val().trim()&& allnumeric($('#phone-input').val().trim())) {
        if (iti.isValidNumber()) {
            var number = iti.getNumber(intlTelInputUtils.numberFormat.E164);
            var msg = 'https://www.empoweryouth.com' + $('.j-title > a').attr("href");
            $('#phone-input').removeClass('error');
            $('#phone-error').html("");
            window.open("https://wa.me/" + number +'?text=' + msg , '_blank');
        } else {
          input.classList.add("error");
          var errorCode = iti.getValidationError();
          $('#phone-error').html(errorMap[errorCode]);
        }
      } else {
          input.classList.add("error");
          $('#phone-error').html('Invalid Phone Number');
      }
  }
})
function downloadAs(url, name) {
  axios.get(url, {
    headers: {
      "Content-Type": "application/octet-stream"
    },
    responseType: "blob"
  })
    .then(response => {
      const a = document.createElement("a");
      const url = window.URL.createObjectURL(response.data);
      a.href = url;
      a.download = name;
      a.click();
    })
    .catch(err => {
      console.log("error", err);
    });
};
JS;
$this->registerJs($script);
$this->registerJsFile('/assets/themes/backend/vendor/isotope/isotope.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/css/intlTelInput.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://unpkg.com/axios/dist/axios.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<script>
    function showJobsSidebar() {
        let paSidebar = document.getElementsByClassName('hamburger-jobs');
        paSidebar[0].classList.toggle('pa-sidebar-show');
        let clickedBtn = this.event.currentTarget;
        if (paSidebar[0].classList.contains('pa-sidebar-show')) {
            clickedBtn.innerHTML = "<i class='fa fa-times'></i>";
        } else {
            clickedBtn.innerHTML = "<i class='fa fa-bars'></i>";
        }
    }

    function roundClick() {
        let hp = document.querySelector('.hiring_process_list');
        let hpChild = hp.children;
        setTimeout(function () {
            hp.style.height = "auto";
            for (let i = 0; i < hpChild.length; i++) {
                setTimeout(function () {
                    hpChild[i].style.position = "relative";
                    hpChild[i].style.top = "unset";
                    hpChild[i].style.left = "unset";
                }, 300)
            }
        }, 500);
    }

    function shownotes() {
        let noteImg = document.getElementsByClassName('noteImg');
        for (let i = 0; i < noteImg.length; i++) {
            noteImg[i].addEventListener('click', function () {
                let noteForm = document.querySelectorAll('.noteForm');
                if (noteForm.length > 0) {
                    noteForm[0].remove();
                }
                var note_val = noteImg[i].getAttribute('data-val');
                let parentElem = this.parentElement;
                let rootElem = parentElem.parentElement;
                let div = document.createElement('div');
                div.setAttribute('class', 'noteForm');
                let notesTemp = '<form><div class="noteInput"><span id="closeNotes"><i class="fa fa-times"></i></span><p>Notes</p><textarea class="noteText">' + note_val + '</textarea><button type="button" class="saveNote"><i class="fa fa-check"></i></button></div></form>';
                div.innerHTML = notesTemp;
                parentElem.insertAdjacentElement('afterend', div);
                let textArea = document.querySelector(".noteText");

                PosEnd(textArea);

                let closeNotes = document.getElementById('closeNotes');
                closeNotes.addEventListener('click', function () {
                    let noteInput = closeNotes.closest('.noteForm');
                    noteInput.remove();
                });


                textArea.addEventListener("blur", () => {
                    var note = textArea.value
                    var id = textArea.closest('li').getAttribute('data-id');

                    $.ajax({
                        url: '/account/process-applications/process-notes',
                        data: {
                            note: note,
                            id: id
                        },
                        method: 'post',
                        success: function (data) {
                        }
                    });
                    this.setAttribute('data-val', note);
                    div.remove();
                });
            })
        }
    }

    function PosEnd(end) {
        var len = end.value.length;

        if (end.setSelectionRange) {
            end.focus();
            end.setSelectionRange(len, len);
        } else if (end.createTextRange) {
            var t = end.createTextRange();
            t.collapse(true);
            t.moveEnd('character', len);
            t.moveStart('character', len);
            t.select();
        }
    }

    shownotes()

    function showRejectType(e) {
        let parElem = e.parentElement;
        let rootElem = parElem.parentElement;
        let rejectType = rootElem.querySelector('.rejectType');
        rejectType.style.display = "flex";
        parElem.style.display = "none";
    }

    function showRejectReason(e) {
        let parElem = e.parentElement;
        let rootElem = parElem.parentElement;
        let rejectType = rootElem.querySelector('.rejectRea');
        rejectType.style.display = "flex";
        parElem.style.display = "none";
    }

    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    let bdy = document.getElementsByTagName('body');

    function showJobsModal() {
        modal.style.display = "block";
        bdy[0].classList.add('modal-open');
    }

    function closeModal() {
        modal.style.display = "none";
        bdy[0].classList.remove('modal-open');
    }

    let openConJob = document.getElementById('conjobs');

    function openConJobs() {
        openConJob.style.display = "block";
        bdy[0].classList.remove('modal-open');
    }

    function closeConJobsModal() {
        openConJob.style.display = "none";
        bdy[0].classList.remove('modal-open');
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        } else if (event.target == openConJob) {
            openConJob.style.display = "none";
        }
    }
</script>
<script id="modalJobCards" type="text/template">
    {{#.}}
    <div class="col-md-3">
        <a href="/<?= $app_type ?>/{{slug}}" target="_blank">
            <div class="customJobBox">
                <div class="jc-icon">
                    <img src="<?= Url::to('@commonAssets/categories/') ?>{{icon}}">
                </div>
                <div class="jc-details-con">
                    <p>{{job_title}}</p>
                    <p class="font-16">Positions: {{positions}}</p>
                </div>
            </div>
        </a>
    </div>
    {{/.}}
</script>