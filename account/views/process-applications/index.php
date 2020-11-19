<?php

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
}else if ($application_name['wage_type'] == 'Unpaid'){
    $amount = 'Unpaid';
}
$user_pCount = [];
foreach ($application_name['interviewProcessEnc']['interviewProcessFields'] as $p){
    $user_pCount[$p['field_name']] = 0;
    foreach ($fields as $u){
        if($p['sequence'] == $u['current_round']){
            $user_pCount[$p['field_name']] += 1;
        }
    }
}
$hcount = 0;
foreach ($fields as $f){
    if($f['status'] == 'Hired'){
        $hcount += 1;
    }
}
?>
<div class="hamburger-jobs">
    <button class="ajBtn" onclick="showJobsSidebar()"><i class="fa fa-bars"></i></button>
    <div class="pa-sidebar" id="hamburgerJobs">
        <?php
            foreach ($similarApps as $app){
                $cnt = 0;
                $arry = [];
                $more = false;
        ?>
        <div class="jobCard">
            <a href="<?= Url::to('/account/process-applications/').$app['application_enc_id']?>">
                <div class="jc-icon">
                    <img src="<?= Url::to('@commonAssets/categories/' . $app['icon']); ?>">
                </div>
                <div class="jc-details">
                    <h3><?= $app['job_title'] ?></h3>

                    <?php
                    if ($app['applicationPlacementLocations']) {
                        foreach ($app['applicationPlacementLocations'] as $ps) {
                            $cnt += $ps['positions'];
                            if(count($arry) >= 3){
                                $more = true;
                            }else{
                                array_push($arry, $ps['name']);
                            }
                        }
                    }
                    ?>
                    <p><?php
                        echo implode(', ',  array_unique($arry));
                        echo $more ? ' and more' : ' ';
                    ?></p>
                    <p><?= $cnt ?> Openings</p>
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
                            <a href="/<?= $app_type . "/" . $application_name['slug'] ?>" target="_blank">
                                <?= $application_name['job_title'] ?></a>
                        </div>

                        <div class="j-share">
                            <span class="fbook"><a href=""
                                                   onclick="window.open('<?= 'https://www.facebook.com/sharer/sharer.php?u=' . Url::to($app_type . '/' . $application_name['slug'], 'https'); ?>', '_blank', 'width=800,height=400,left=200,top=100');"><i
                                            class="fa fa-facebook"></i></a></span>
                            <span class="wts"><a href=""
                                                 onclick="window.open('<?= 'https://api.whatsapp.com/send?text=' . Url::to($app_type . '/' . $application_name['slug'], 'https'); ?>', '_blank', 'width=800,height=400,left=200,top=100');"><i
                                            class="fa fa-whatsapp"></i></a></span>
                            <span class="twt"><a href=""
                                                 onclick="window.open('<?= 'https://twitter.com/intent/tweet?text=' . Url::to($app_type . '/' . $application_name['slug'], 'https'); ?>', '_blank', 'width=800,height=400,left=200,top=100');"<i
                                        class="fa fa-twitter"></i></a></span>
                            <span class="mail"><a href=""
                                                  onclick="window.open('<?= 'mailto:?&body=' . Url::to($app_type . '/' . $application_name['slug'], 'https'); ?>', '_blank', 'width=800,height=400,left=200,top=100');"<i
                                        class="fa fa-envelope"></i></a></span>
                            <span class="link"><a href=""
                                                  onclick="window.open('<?= 'https://www.linkedin.com/shareArticle?mini=true&url=' . Url::to($app_type . '/' . $application_name['slug'], 'https'); ?>', '_blank', 'width=800,height=400,left=200,top=100');"<i
                                        class="fa fa-linkedin"></i></a></span>
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
                                        if(count($l) >= 5){
                                            $more = true;
                                        }else{
                                            array_push($l, $apl['name']);
                                        }
                                        $cntt += $apl['positions'];
                                    }
                                }
                                echo implode(', ', array_unique($l));
                                echo $more ? ' and more' : '';
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
                                if($app_type == "internship"){
                            ?>
                                    <h1>Offered Stipend</h1>
                                    <p><?= $amount ?></p>
                            <?php
                                }else{
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
                                <a href="#" id="j-delete" data-toggle="tooltip"
                                   title="Delete <?= $app_type ?>" value="<?= $application_id ?>"><i
                                            class="fa fa-trash-o"></i></a>
                            </span>
                        <span class="j-cls">
                                <a href="#" id="j-closed" data-toggle="tooltip"
                                   title="Close <?= $app_type ?>" data-name="<?= $app_type ?>"
                                   value="<?= $application_id ?>"><i class="fa fa-times"></i></a>
                            </span>
                    </div>
                    <div class="scd-btn">
                        <a href="/account/schedular/interview">Schedule Interview</a>
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
            <li class="active"
                style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 2; ?>)">
                <a data-filter="*" href="#" onclick="roundClick()">All <span><?php
                       foreach($user_pCount as $v){
                           $pcnt += $v;
                       }
                       echo $pcnt + $hcount;
                   ?></span></a>
            </li>
            <?php
            $k = 0;
            foreach ($application_name['interviewProcessEnc']['interviewProcessFields'] as $p) {
                ?>
                <li id="<?= 'nav' . $p['field_enc_id'] ?>"
                    style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 2; ?>)">
                    <a data-filter=".<?= $p['field_enc_id'] . $k ?>" data-toggle="tooltip" data-placement="bottom"
                       title="" onclick="roundClick()" data-original-title="<?= $p['field_name'] ?>" href="#">
                        <i class="<?= $p['icon'] ?>" aria-hidden="true"></i><span><?= $user_pCount[$p['field_name']] ?></span>
                    </a>
                </li>
                <?php
                $k++;
            }
            ?>
            <li style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 2; ?>)">
                <a data-filter=".result" data-toggle="tooltip" data-placement="bottom" data-original-title="Hired"
                   href="#" onclick="roundClick()">
                    <i class="fa fa-check-square-o"></i><span>
                        <?php
                            echo $hcount;
                       ?>
                    </span>
                </a>
            </li>
        </ul>
    </div>
    <ul class="hiring_process_list gallery_zoom content-stick">
        <?php
        if (!empty($fields)) {
//                print_r($fields);
//                exit();
            foreach ($fields as $arr) {
                $j = 0;
                $fieldMain = "";
                if ($arr['status'] == 'Hired') {
                    $tempfieldMain = "result";
                    $fieldName = "Hired";
                } else if ($arr['status'] == 'Rejected') {
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
                ?>
                <li class="<?= $tempfieldMain ?>" data-key="<?= $fieldMain ?>"
                    data-id="<?= $p['applied_application_enc_id'] ?>">

                    <div class="row pr-user-main">
                        <div class="col-md-12 col-sm-12 pr-user-inner-main">
                            <div class="col-md-4">
                                <div class="pr-user-detail">
                                    <a class="pr-user-icon url-forward" href="#"
                                       data-id="<?= '/' . $arr['username'] . '?id=' . $arr['applied_application_enc_id'] ?>">
                                        <?php if ($arr['image']): ?>
                                            <img src="<?= $arr['image'] ?>"/>
                                        <?php else: ?>
                                            <canvas class="user-icon" name="<?= $arr['name'] ?>" width="80"
                                                    color="<?= $arr['initials_color']; ?>"  height="80" font="35px"></canvas>
                                        <?php endif; ?>
                                    </a>
                                    <a class="pr-user-n url-forward" href="#"
                                       data-id="<?= '/' . $arr['username'] . '?id=' . $arr['applied_application_enc_id'] ?>"><?= $arr['name'] ?></a>
                                    <?php
                                    if ($arr['createdBy']['userWorkExperiences']) {
                                        foreach ($arr['createdBy']['userWorkExperiences'] as $exp) {
                                            if ($exp['is_current'] == 1) {
                                                echo '<h5>' . $exp["title"] . ' @ ' . $exp["company"] . '</h5>';
                                            }
                                        }
                                    }
                                    ?>
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
                                        <h5><?= $arr['createdBy']['userEducations'][0]['institute'] . ' - ' . $arr['createdBy']['userEducations'][0]['degree']; ?></h5>
                                        <?php
                                        if (COUNT($arr['createdBy']['userEducations']) > 1) {
                                            ?>
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
                                    <ul class="s-skill">
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
                                    <ul class="h-skill">
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
                                        <a href="<?= Url::to($arr['username'], true) ?>" target="_blank">View
                                            Profile</a>
                                        <?php
                                        $cv = Yii::$app->params->upload_directories->resume->file . $arr['resume_location'] . DIRECTORY_SEPARATOR . $arr['resume'];
                                        ?>
                                        <a href="<?= Url::to($cv, true); ?>" target="_blank">Download Resume</a>
                                        <!--                                            <a href="#" class="tt" data-toggle="tooltip" title="Request to Complete Profile"><i class="fa fa-id-card"></i></a>-->
                                        <!--                                            <a href="#">Request to Complete Profile</a>-->
                                    </div>
                                    <ul>
                                        <!--                                            <li>-->
                                        <!--                                                <a href="#">-->
                                        <!--                                                    <img src="-->
                                        <?//= Url::to('@eyAssets/images/pages/dashboard/email2.png') ?><!--"/>-->
                                        <!--                                                </a>-->
                                        <!--                                            </li>-->
                                        <!--                                            <li>-->
                                        <!--                                                <a href="#" class="tt" title="Schedule Interview -->
                                        <?//= $arr['name'] ?><!--" data-toggle="tooltip">-->
                                        <!--                                                    <img src="-->
                                        <?//= Url::to('@eyAssets/images/pages/dashboard/calendar.png') ?><!--"/>-->
                                        <!--                                                </a>-->
                                        <!--                                            </li>-->
                                        <?php
                                        if ($arr['hiringProcessNotes']) {
                                            $notes = $arr['hiringProcessNotes'][0]['notes'];
                                        } else {
                                            $notes = '';
                                        }
                                        ?>
                                        <li class="notes" data-toggle="tooltip" title="Notes">
                                            <img src="<?= Url::to('@eyAssets/images/pages/dashboard/notes-icon-circle.png') ?>"
                                                 class="noteImg" data-val="<?= $notes; ?>">
                                        </li>
                                        <li>
                                            <a href="#" class="open_chat tt" data-id="<?= $arr['created_by']; ?>"
                                               data-key="<?= $arr['name']; ?>" title="Chat Now"
                                               data-toggle="tooltip">
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
                                                ?>
                                                <div data-id="<?= $p['field_enc_id'] ?>">
                                                    <a href="#" class="multipleRound <?= $p['is_completed'] == 1 ? 'disable-step' : ''?> <?php if($isHighlight){
                                                        if($p['is_completed'] == 0){
                                                            echo 'showBlue';
                                                            $isHighlight = false;
                                                        }
                                                    }?>" value="<?= $p['applied_application_enc_id']; ?>">
                                                        <i class="<?= $p['icon'] ?>" aria-hidden="true"></i>
                                                        <?= $p['field_name'] ?>
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div data-id="<?= $p['field_enc_id'] ?>" >
                                                <a href="#" class="multipleRound" value="<?= $arr['applied_application_enc_id']; ?>">
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
                                <?php foreach ($que as $list_que) { ?>
                                    <tr>
                                        <td><a class="blue question_list"
                                               href="/account/questionnaire/display-answers/<?= $list_que['qid']; ?>/<?= $arr['applied_application_enc_id']; ?>"
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
<?php
$this->registerCss('
body, .page-content{
    background-color: #eee;
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
}
.jobCard a{
    display: flex;
    color: #000;
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
    top: 105px;
    left: 0;
    border: 1px solid #eee;
    width: 0px;
    height: calc(100vh - 105px);
    transition: .3s ease;
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    z-index: 999;
}
.pa-sidebar{
    width: 100%;
    height: calc(100vh - 105px);
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
.h-skill{
    display:none;
    z-index:1;
}
.pr-user-skills:hover .h-skill {
    display: block;
    position: absolute;
    background-color: #fdfdfd;
    top: 15px;
    border-radius: 6px;
    box-shadow: 0 0 4px 0px rgba(0, 0, 0, 0.1);
    padding: 5px;
    left:10px;
    min-height:105px;
    max-height:135px;
    overflow-y:scroll;
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
	border-radius: 0 8px 0 5px;
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
    top: 104px;
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
	padding: 25px 15px;
	background: #fdfdfd;
}
.j-main {
	display: flex;
	border-right: 2px solid #333;
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
//	margin-bottom: 11px !important;
	font-size:11px;
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
    border-radius:8px;
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
}
.hiring_process_list > li{
    width:100%;
    transition: .3s ease;
}
.pr-user-n{
  font-size:19px;
  font-weight:500;
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
.pr-user-skills{
    padding-top:20px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow:hidden;
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
    border-radius:0 0 10px 10px !important; 
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
@media (min-width:1400px){
    .sticky{
        max-width: 1140px;
        width: 100%;
    }
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
   
}
');
$script = <<<JS
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop - 55;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
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
            console.log(this);
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
    console.log(this);
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
                    $('#'+listid).find('a').click();
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
  console.log(prevRounds);
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
                $('#'+listid).find('a').click();
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
    $.ajax({
        url:'/account/jobs/reject-candidate',
        data:{app_id:app_id},
        method:'post',
        beforeSend:function()  {
            btn.html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
            btn.attr("disabled","true");
        },    
        success:function(data){
            if(data==true) {
                btn.hide();
                btn2.hide();
                btn3.show();
                $.pjax.reload({container: '#pjax_process', async: false});
                  setTimeout(function() {
                    hiring_process();
                  }, 100)
            }
            else {
                alert('something went wrong..');
            }
        }
    });
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
            console.log(data);
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

var ps = new PerfectScrollbar('#hamburgerJobs');
JS;
$this->registerJs($script);
$this->registerJsFile('/assets/themes/backend/vendor/isotope/isotope.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<script>
    function showJobsSidebar() {
        let paSidebar = document.getElementsByClassName('hamburger-jobs');
        paSidebar[0].classList.toggle('pa-sidebar-show');
        let clickedBtn = this.event.currentTarget;
        if(paSidebar[0].classList.contains('pa-sidebar-show')){
            clickedBtn.innerHTML = "<i class='fa fa-times'></i>";
        }else {
            clickedBtn.innerHTML = "<i class='fa fa-bars'></i>";
        }
    }
    function roundClick() {
        let hp = document.querySelector('.hiring_process_list');
        let hpChild = hp.children;
        setTimeout(function () {
            hp.style.height = "auto";
            for (let i = 0; i < hpChild.length; i++) {
                hpChild[i].style.position = "relative";
                hpChild[i].style.top = "unset";
                hpChild[i].style.left = "unset";
            }
        }, 500);
    }


    let noteImg = document.getElementsByClassName('noteImg');
    for (let i = 0; i < noteImg.length; i++) {
        noteImg[i].addEventListener('click', function () {
            let noteForm = document.querySelectorAll('.noteForm');
            if (noteForm.length > 0) {
                noteForm[0].remove();
            }
            var note_val = noteImg[i].getAttribute('data-val');
            console.log(note_val);
            let parentElem = this.parentElement;
            let rootElem = parentElem.parentElement;
            let div = document.createElement('div');
            div.setAttribute('class', 'noteForm');
            let notesTemp = '<form><div class="noteInput"><span id="closeNotes"><i class="fa fa-times"></i></span><p>Notes</p><textarea class="noteText">' + note_val + '</textarea><button type="button" class="saveNote"><i class="fa fa-check"></i></button></div></form>';
            div.innerHTML = notesTemp;
            parentElem.insertAdjacentElement('afterend', div);

            let closeNotes = document.getElementById('closeNotes');
            closeNotes.addEventListener('click', function () {
                let noteInput = closeNotes.closest('.noteForm');
                noteInput.remove();
            });
        })
    }



</script>
