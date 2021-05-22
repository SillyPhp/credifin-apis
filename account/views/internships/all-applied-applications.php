<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

$base_url = 'https://empoweryouth.com';
?>
<div class="aa-bg"></div>
<div class="container">
    <?php
    Pjax::begin(['id' => 'pjax_process']);
    ?>
    <ul class="hiring_process_list gallery_zoom content-stick">
        <?php
        if (!empty($fields)) {
            $app_type_link = rtrim($fields['type'], 's');
            $app_type = strtolower($app_type_link);
            ?>
            <div class="jobsBoxes">
                <div class="row">
                    <div class="col-md-10">
                        <h3 class="job-title"> <?= $app_type_link . ': ' . '<a class="url-forward" data-id="/' . $app_type . '/' . $fields['slug'] . '" href="javascript:;" target="_blank">' . $fields['job_title'] . '</a>' ?></h3>
                    </div>
                </div>
                <?php
                foreach ($fields['appliedApplications'] as $arr) {
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
                    $rejectionType = $arr['candidateRejections'][0]['rejection_type'];
                    ?>
                    <li class="<?= $tempfieldMain ?>" data-key="<?= $fieldMain ?>"
                        data-id="<?= $p['applied_application_enc_id'] ?>">

                        <div class="row pr-user-main">
                            <div class="reject-box" <?= (($arr['rejection_window'] == 1) ? 'style="display: flex;"' : '') ?>>
                                <div class="pr-top-actions text-right">
                                    <a class="url-forward"
                                       data-id="<?= Url::to($arr['username'] . '?id=' . $arr['applied_application_enc_id'], true) ?>"
                                       href="javascript:;"
                                       target="_blank">View Profile</a>

                                    <a href="javascript:;" class="download-resume" target="_blank"
                                       data-key="<?= $arr['resume_location'] ?>" data-id="<?= $arr['resume'] ?>">Download
                                        Resume</a>
                                    <!--                                            <a href="#" class="tt" data-toggle="tooltip" title="Request to Complete Profile"><i class="fa fa-id-card"></i></a>-->
                                    <!--                                            <a href="#">Request to Complete Profile</a>-->
                                </div>
                                <a class="pr-user-n url-forward" href="#"
                                   data-id="<?= '/' . $arr['username'] . '?id=' . $arr['applied_application_enc_id'] ?>"><?= $arr['name'] ?></a>

                                <div class="rejectReason rejectRea"
                                     id="rejectReason" <?= $rejectionType ? 'style="display: none"' : '' ?>>
                                    <form class="reasonsForm"
                                          id="<?= $p['applied_application_enc_id'] . 'reasonForm' ?>">
                                        <p>Reason for rejection</p>
                                        <ul class="rejectReasonsList">
                                            <?php
                                            foreach ($reasons as $reason) {
                                                ?>
                                                <li>
                                                    <div class="reasonsReject">
                                                        <input type="checkbox"
                                                               value="<?= $reason['rejection_reason_enc_id'] ?>"
                                                               name="<?= $p['applied_application_enc_id'] . 'reasons' ?>"
                                                               id="<?= $reason['rejection_reason_enc_id'] . $p['applied_application_enc_id'] ?>"
                                                               class="">
                                                        <label for="<?= $reason['rejection_reason_enc_id'] . $p['applied_application_enc_id'] ?>"><?= $reason['reason'] ?></label>
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
                                    <form class="reasonsType"
                                          id="<?= $p['applied_application_enc_id'] . 'reasonType' ?>">
                                        <p>Rejection Type</p>
                                        <ul>
                                            <li>
                                                <div class="reasonsReject">
                                                    <input type="radio" value="1"
                                                           name="<?= $p['applied_application_enc_id'] . 'rejectType' ?>"
                                                           id="<?= $p['applied_application_enc_id'] . 'permanent' ?>"
                                                           class="">
                                                    <label for="<?= $p['applied_application_enc_id'] . 'permanent' ?>">Permanent
                                                        Reject</label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="reasonsReject">
                                                    <input type="radio" value="2"
                                                           name="<?= $p['applied_application_enc_id'] . 'rejectType' ?>"
                                                           id="<?= $p['applied_application_enc_id'] . 'consider' ?>"
                                                           onclick="showJobsModal()" class="">
                                                    <label for="<?= $p['applied_application_enc_id'] . 'consider' ?>">Consider
                                                        For Other Job</label>
                                                    <!--                                                <button type="button" class="showJobs" >-->
                                                    <!--                                                    Consider For Other Job-->
                                                    <!--                                                </button>-->
                                                </div>
                                            </li>
                                            <li>
                                                <div class="reasonsReject">
                                                    <input type="radio" value="3"
                                                           name="<?= $p['applied_application_enc_id'] . 'rejectType' ?>"
                                                           id="<?= $p['applied_application_enc_id'] . 'save' ?>"
                                                           class="">
                                                    <label for="<?= $p['applied_application_enc_id'] . 'save' ?>">Save
                                                        For Later</label>
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
                                                $msg = "Candidate's CV has been saved for later. Please check CV in 
                                                        drop resume";
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
                                                    <a class="url-forward"
                                                       data-id="/<?= $app_type . "/" . $crj['applicationEnc']['slug'] ?>"
                                                       href="javascript:;" target="_blank">
                                                        <div class="customJobBox">
                                                            <div class="jc-icon">
                                                                <img src="<?= Url::to('@commonAssets/categories/' . $crj['applicationEnc']['icon']); ?>">
                                                            </div>
                                                            <p><?= $crj['applicationEnc']['job_title'] ?></p>
                                                        </div>
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
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 pr-user-inner-main">
                                <div class="col-md-4">
                                    <div class="pr-user-detail">
                                        <a class="pr-user-icon url-forward" href="#"
                                           data-id="<?= '/' . $arr['username'] . '?id=' . $arr['applied_application_enc_id'] ?>">
                                            <?php if ($arr['image']): ?>
                                                <img src="<?= $arr['image'] ?>"/>
                                            <?php else: ?>
                                                <canvas class="user-icon" name="<?= $arr['name'] ?>" width="80"
                                                        color="<?= $arr['initials_color']; ?>" height="80"
                                                        font="35px"></canvas>
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
                                            <a class="url-forward"
                                               data-id="<?= Url::to($arr['username'] . '?id=' . $arr['applied_application_enc_id'], true) ?>"
                                               href="javascript:;"
                                               target="_blank">View Profile</a>
                                            <?php
                                            if (!empty($arr['resume_location']) || !empty($arr['resume'])) {
                                                ?>
                                                <a href="javascript:;" class="download-resume"
                                                   target="_blank"
                                                   data-key="<?= $arr['resume_location'] ?>"
                                                   data-id="<?= $arr['resume'] ?>">Download Resume</a>
                                            <?php } ?>
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
                                                        <a href="#"
                                                           class="multipleRound <?= $p['is_completed'] == 1 ? 'disable-step' : '' ?> <?php if ($isHighlight) {
                                                               if ($p['is_completed'] == 0) {
                                                                   echo 'showBlue';
                                                                   $isHighlight = false;
                                                               }
                                                           } ?>" value="<?= $p['applied_application_enc_id']; ?>">
                                                            <i class="<?= $p['icon'] ?>" aria-hidden="true"></i>
                                                            <?= $p['field_name'] ?>
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
                ?>
            </div>
            <?php
        }
        ?>
    </ul>
    <?php
    Pjax::end();
    ?>
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
h3.job-title {
    font-size: 28px;
    font-family: lora;
    font-weight: 600;
    padding-left: 5px;
    line-height: 0;
}
a:focus{
    text-decoration: none;
}
.mt50{
    margin-top: 50px;
}
.jobsBoxes{
    background: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,.3);
    padding: 20px;
    margin-top: 30px; 
    margin-bottom: 50px;
}
.page-content {
    background-image: url(/assets/themes/ey/images/backgrounds/quickjob.png) !important;
    background-size: cover !important;
    background-attachment: fixed !important;
    background-repeat: no-repeat !important;
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
.sr-box{
    color: #000;
}
.rejectReason p{
    text-align: center;
    font-family: lora;
    font-size: 20px;
    font-weight: bold;
    margin-top: 0px;
    margin-bottom: 5px;
    color: #333;
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
    min-height: 130px;
    position: relative;
}
.hamburger-jobs .jobCard a{
    display: flex;
    color: #333;
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
    position: relative;
}
.reject-box{
    position: absolute;
    top: 0px;
    left: 0;
    width: 100%;
    height:102%;
    background: rgba(255,255,255, .96);
    z-index: 9;
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
window.onscroll = function() {myFunction()};


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
    console.log(app_id);
    var rootElem = btn.parentsUntil('.pr-user-main').parent();
    var rejectBox = $(rootElem).find('.reject-box');
    console.log(rejectBox);
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
    console.log(rejectBox);
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
    console.log(selectedReasons);
    let rootElem = parElem.parent();
    let rejectType = rootElem.find('.rejectType');
    rejectType.css('display', 'flex');
    parElem.css('display','none');
});
let considerJobs = [];
$(document).on('click','.doneCloseModal', function(e){
    e.preventDefault();
    let btn = $(this);
    let parElem = btn.parent();
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
                console.log(embedList);
                let reasonLi = document.createElement('li');
                reasonLi.innerHTML =  '<div class="reasonsReject"><input type="checkbox" value="'+ res['reason'] +'" name="reasons" id="'+ res['reason_enc_id'] +'" class="" checked><label for="'+ res['reason_enc_id'] +'">'+ res['reason'] +'</label></div>';
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
   console.log(reject_id);
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
                    window.open(cv_link);
                }else if(res['status'] == 500){
                    alert('an error occurerd')
                }
            }
        })    
})

// var ps = new PerfectScrollbar('#hamburgerJobs');
// var pa = new PerfectScrollbar('.modal-jobs');
JS;
$this->registerJs($script);
$this->registerJsFile('/assets/themes/backend/vendor/isotope/isotope.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);


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