<?php

use yii\helpers\Html;
use yii\helpers\Url;

function webDate($webDate)
{
    $date = $webDate;
    $sec = strtotime($date);
    $newDate = date('d-M', $sec);
    return $newDate;
}
if (!empty($userApplied) && Yii::$app->user->identity->organization->organization_enc_id) {
    if (!empty($userApplied['applied_application_enc_id'])) {
        $j = 0;
        if ($userApplied['status'] == 'Hired') {
            $fieldName = "Hired";
        } elseif ($userApplied['status'] == 'Rejected') {
            $fieldName = "Rejected";
        } else {
            $fieldName = "Applied";
        }
        if (!empty($userApplied['appliedApplicationProcesses'])) {
            foreach ($userApplied['appliedApplicationProcesses'] as $p) {
                if ($j == $userApplied['active'] && $userApplied['status'] != 'Rejected') {
                    $fieldName = $p['field_name'];
                    break;
                }
                $j++;
            }
        }
    }
}
$this->params['header_dark'] = false;
$uId = $user['user_enc_id'];
?>

    <!--Modal-->
    <div id="shortList" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" id="profiles">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="submit" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center" style="font-family: roboto; font-size: 20px;">Choose
                        Applications to Shortlist for</h4>
                </div>
                <div class="modal-body">
                    <?php
                    if ($available_applications && count($available_applications) > 0) {
                        foreach ($available_applications as $a) {
                            ?>
                            <div class="row padd10">
                                <div class="col-md-12 text-center">
                                    <div class="radio_questions">
                                        <div class="inputGroup process_radio">
                                            <input type="radio" name="applications" id="<?= $a['application_enc_id'] ?>"
                                                   value="<?= $a['application_enc_id'] ?>" class="application_list">
                                            <label for="<?= $a['application_enc_id'] ?>">
                                                <?= $a['name'] ?>
                                                <span class="<?= (($a['application_type'] == 'Jobs') ? 'colorBlue' : 'colorOrange') ?>"> ( <?= substr_replace($a['application_type'], "", -1) ?> ) </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>

                <div class="modal-footer">
                    <?php if ($available_applications && count($available_applications) > 0) { ?>
                        <button id="submitData" type="submit" class="btn btn-primary" data-dismiss="modal">Submit
                        </button>
                    <?php } else { ?>
                        <a class="btn btn-primary" href="/account/<?= $type ?>/create">Create New <?= $type ?></a>
                    <?php } ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--Schedule Interview Modal-->
    <div id="schedule_interview" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" id="profiles">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="submit" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center" style="font-family: roboto; font-size: 20px;">Choose
                        Applications to Schedule Interview</h4>
                </div>
                <?php
                if ($userAppliedData && Yii::$app->user->identity->organization->organization_enc_id) {
                    ?>
                    <div class="modal-body">
                        <?php
                        foreach ($userAppliedData as $arr) {
                            foreach ($arr as $pData) {
                                if ($pData['status'] != 'Hired' && $pData['status'] != 'Cancelled' && $pData['status'] != 'Rejected') {
                                    ?>
                                    <div class="row padd10">
                                        <div class="col-md-12 text-center">
                                            <div class="radio_questions">
                                                <div class="inputGroup process_radio">
                                                    <input type="radio" name="scheduleInterview"
                                                           id="scheduleInterview<?= $pData['application_enc_id'] ?>"
                                                           value="/account/schedular/interview?app_id=<?= $pData['application_enc_id'] . '&applied_id=' . $pData['applied_application_enc_id'] . '&current_round=' . $pData['current_round'] ?>"
                                                           class="application_list">
                                                    <label for="scheduleInterview<?= $pData['application_enc_id'] ?>">
                                                        <?= $pData['title'] ?>
                                                        <span class="<?= (($pData['type'] == 'Jobs') ? 'colorBlue' : 'colorOrange') ?>"> ( <?= substr_replace($pData['type'], "", -1) ?> ) </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>

                    <div class="modal-footer">
                        <button id="scheduleInterviewSubmit" type="button" class="btn btn-primary">
                            Schedule
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <section class="inner-header-page">
        <div class="container">
            <div class="col-md-7 col-sm-10 col-md-offset-1 col-sm-offset-1">
                <div class="left-side-container">
                    <div class="freelance-image">
                        <?php
                        $name = $image = NULL;
                        if (!empty($user['image'])) {
                            $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $user['image_location'] . DIRECTORY_SEPARATOR . $user['image'];
                        }
                        $name = $user['first_name'] . ' ' . $user['last_name'];
                        if ($image) :
                            ?>
                            <img src="<?= $image; ?>" alt="<?= $name; ?>" class="img-circle"/>
                        <?php else : ?>
                            <canvas class="user-icon img-circle img-responsive" name="<?= $name; ?>"
                                    color="<?= $user['initials_color']; ?>" width="140" height="140"
                                    font="70px"></canvas>
                        <?php endif; ?>
                    </div>
                    <div class="header-details">
                        <h4 class="capitalize"><?= $user['first_name'] . " " . $user['last_name'] ?></h4>
                        <p><?= $user['job_profile'] ?></p>
                        <?php
                        if ($user['city']) {
                            ?>
                            <ul>
                                <li><i class="fas fa-map-marker-alt"></i> <?= $user['city'] ?></li>
                            </ul>
                            <?php
                        }
                        if (!Yii::$app->user->identity->organization) {
                            ?>
                            <div class="pro-bar">
                                <div class="pro-text"><?= $profileProcess ?>% Completed</div>
                                <div class="progress">
                                    <?php
                                    if ($profileProcess < 50) {
                                        $processClr = 'process-clr';
                                    } else {
                                        $processClr = 'process-clr1';
                                    }
                                    ?>
                                    <div class="progress-bar <?= $processClr ?>"
                                         style="width:<?= $profileProcess ?>%"></div>
                                </div>
                                <?php
                                if ($profileProcess < 100) {
                                    ?>
                                    <p class="progress-bar-description">To complete your profile and to make it more
                                        impressive, fill Educational Details in Resume Builder, Skills, Experience and
                                        Job Profile in Edit Profile.</p>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        if ($user['user_enc_id'] === Yii::$app->user->identity->user_enc_id) {
                            ?>
                            <a href="<?= Url::to('/' . $user['username'] . '/edit'); ?>" class="edit-profile-btn"
                               target="_blank">Edit Profile</a>
                            <?php
                            if (!empty($userCv)) { ?>
                                <a href="javascript:;" class="edit-profile-btn download-resume" target="_blank"
                                   data-key="<?= $userCv['resume_location'] ?>" data-id="<?= $userCv['resume'] ?>">Download
                                    CV</a>
                            <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6  br-gary">
                <div class="right-side-detail">
                    <ul>
                        <li><span class="detail-info">Availability</span><span
                                    class="set-color"><?= $user['availability'] ?></span></li>
                        <li><span class="detail-info">Location</span><?php echo($user['city'] ? $user['city'] : '--') ?>
                        </li>
                        <li>
                            <span class="detail-info">Experience</span><?php
                            if ($user['experience']) {
                                $strToArr = explode('"', $user["experience"]);
                                if ($strToArr[1] != 0) {
                                    echo $strToArr[1] . ' Year(s) ';
                                }
                                if ($strToArr[3] != 0) {
                                    echo $strToArr[3] . ' Month(s)';
                                }
                            } else {
                                echo '--';
                            }
                            ?>
                        </li>
                        <li>
                            <span class="detail-info">Age</span><?php echo($user['age'] ? $user['age'] . ' Years' : '--') ?>
                        </li>
                        <li>
                            <?php if (!empty($userApplied) && Yii::$app->user->identity->organization->organization_enc_id) {
                                if (!empty($userApplied['applied_application_enc_id'])) {
                                    ?>
                                    <span class="detail-info">
                                    Application Status</span><?= $fieldName ?>
                                <?php }
                            } ?>
                        </li>

                    </ul>
                    <ul class="social-info">
                        <?php if (!empty($user['facebook'])) { ?>
                            <li class="fbook">
                                <a href="https://www.facebook.com/<?= Html::encode($user['facebook']) ?>"
                                   target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                        <?php }
                        if (!empty($user['twitter'])) { ?>
                            <li class="tter">
                                <a href="https://www.twitter.com/<?= Html::encode($user['twitter']) ?>" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                        <?php }
                        if (!empty($user['linkedin'])) { ?>
                            <li class="lin">
                                <a href="https://www.linkedin.com/in/<?= Html::encode($user['linkedin']) ?>"
                                   target="_blank">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                        <?php }
                        if(!empty($user['telegram'])) {?>
                            <li class="telegram">
                                <a href="https://t.me/<?= Html::encode($user['telegram']) ?>"
                                   target="_blank">
                                    <i class="fab fa-telegram"></i>
                                </a>
                            </li>
                        <?php }
                        if (!empty($user['email'])) { ?>
                            <li class="mael">
                                <a href="mailto:<?= Html::encode($user['email']) ?>" target="_blank">
                                    <i class="far fa-envelope-open"></i>
                                </a>
                            </li>
                        <?php }
                        if (!empty($user['skype'])) { ?>
                            <li class="skpe">
                                <a href="skype:<?= Html::encode($user['skype']) ?>?chat" target="_blank">
                                    <i class="fab fa-skype"></i>
                                </a>
                            </li>
                        <?php }

                        if (Yii::$app->user->identity->organization->organization_enc_id && !empty($user['phone']) && !empty($userApplied)) { ?>
                            <li class="whatsapp">
                                <a href="<?= "https://api.whatsapp.com/send?phone=" . $user['phone'] ?>"
                                   target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </li>
                            <li class="skpe">
                                <a href="<?= "tel:" . $user['phone'] ?>" id="phone-val" value="<?= $user['phone'] ?>">
                                    <i class="fa fa-phone"></i>
                                </a>
                            </li>
                        <?php }
                        if (Yii::$app->user->identity->organization->organization_enc_id && !empty($userApplied)) {
                            if (!empty($userApplied['applied_application_enc_id'])) {
                                ?>
                                <li class="talking">
                                    <a href="javascript:;" class="open_chat" data-id="<?= $user['user_enc_id']; ?>"
                                       data-key="<?= $user['first_name'] . " " . $user['last_name'] ?>"
                                       data-img="<?= (($image) ? $image : "https://ui-avatars.com/api/?name=" . $user['first_name'] . " " . $user['last_name'] . "&size=200&rounded=false&background=" . str_replace('#', '', $user['initials_color']) . "&color=ffffff"); ?>">
                                        <i class="fa fa-comments"></i>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                        <li class="dwn">

                        </li>
                    </ul>
                    <?php if (Yii::$app->user->identity->organization->organization_enc_id) {
                        ?>
                        <div class="down-res">
                            <?php
                            if ($userAppliedData && Yii::$app->user->identity->organization->organization_enc_id) {
                                ?>
                                <a href="javascript:;" title="Shortlist" data-toggle="modal" data-target="#schedule_interview">
                                    Schedule Interview <i class="fas fa-calendar-alt"></i>
                                </a>
                                <?php
                            }
                            if ($user['is_shortlisted'] == "true") {
                                ?>
                                <a href="javascript:;" title="Shortlist" class="shortlist-main">
                                    Shortlisted<i class="fas fa-heart"></i>
                                </a>
                                <?php
                            } else {
                                ?>
                                <a href="javascript:;" title="Shortlist" class="shortlist-main">
                                    Shortlist<i class="far fa-heart"></i>
                                </a>
                                <?php
                            }
                            if (!empty($userApplied) && !empty($userApplied['applied_application_enc_id']) && !empty($userApplied['resume'])) {
                                if (!empty($userCv['resume_location']) && !empty($userCv['resume'])) {
                                    ?>
                                    <a href="javascript:;" target="_blank" title="Download Resume"
                                       class="download-resume" data-key="<?= $userCv['resume_location'] ?>"
                                       data-id="<?= $userCv['resume'] ?>">Download
                                        Resume<i class="fas fa-download"></i></a>
                                    <?php
                                }
                            } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <section class="detail-section">
        <div class="container">
            <div class="col-md-8 col-sm-12">
                <?php if ($user['job_profile'] || $user['city'] || $user['description'] || $skills || $language) { ?>
                    <div class="container-detail-box">
                        <div class="apply-job-header">
                            <?php
                            if ($user['job_profile']) {
                                ?>
                                <a href="#" class="cl-success">
                                    <span><i class="fas fa-building"></i><?= $user['job_profile'] ?></span>
                                </a>
                                <?php
                            }
                            if ($user['city']) {
                                ?>
                                <span><i class="fas fa-map-marker-alt"></i><?= $user['city'] ?></span>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="apply-job-detail">
                            <p><?= Html::encode($user['description']); ?></p>
                        </div>
                        <?php if ($skills) { ?>
                            <div class="apply-job-detail">
                                <h5>Skills</h5>
                                <ul class="skills">
                                    <?php
                                    foreach ($skills as $sk) { ?>
                                        <li><?= $sk['skills']; ?></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php }
                        if ($language) {
                            ?>
                            <div class="apply-job-detail">
                                <h5>Spoken Languages</h5>
                                <ul class="skills">
                                    <?php
                                    foreach ($language as $lg) { ?>
                                        <li><?= $lg['language']; ?></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if ($education || $experience || $achievement || $hobbies || $interests) { ?>
                    <div class="container-detail-box">
                        <?php
                        if ($education) {
                            ?>
                            <div class="education-detail">
                                <div class="education-head">Education</div>
                                <?php
                                foreach ($education as $edu) {
                                    ?>
                                    <div class="set">
                                        <div class="prof-p">
                                            <!--                                    <img src="-->
                                            <? //= Url::to('@eyAssets/images/pages/index2/nslider-image1.jpg')
                                            ?>
                                            <!--"/>-->
                                            <canvas class="user-icon" name="<?= $edu['institute'] ?>" width="80"
                                                    height="80" font="30px"
                                                    color="<?= $edu['initials_color']; ?>"></canvas>
                                        </div>
                                        <div class="prof-inner">
                                            <div class="uni-name s-text"><?= $edu['institute'] ?>
                                            </div>
                                            <div class="quelification s-text-2"><?= $edu['degree'] . ' (' . $edu['field'] . ')' ?>
                                            </div>
                                            <div class="s-time s-text-2"></i><?= date("Y", strtotime($edu['from_date'])) . ' - ' . date("Y", strtotime($edu['to_date'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        if ($experience) {
                            ?>
                            <div class="experience-detail">
                                <div class="education-head">Work Experience</div>
                                <?php
                                foreach ($experience as $exp) {
                                    ?>
                                    <div class="set">
                                        <div class="prof-p">
                                            <canvas class="user-icon" name="<?= $exp['company'] ?>" width="80"
                                                    height="80" font="30px"
                                                    color="<?= $exp['initials_color']; ?>"></canvas>
                                        </div>
                                        <div class="prof-inner">
                                            <div class="uni-name s-text"><?= $exp['company'] . ', ' . $exp['city_name'] ?>
                                            </div>
                                            <div class="quelification s-text-2"><?= $exp['title'] ?>
                                            </div>
                                            <div class="s-time s-text-2"><?= date("d/m/Y", strtotime($exp['from_date'])) . ' to ' ?>
                                                <?php if ($exp['is_current']) {
                                                    echo 'Present';
                                                } else { ?>
                                                    <?php echo date("d/m/Y", strtotime($exp['to_date']));
                                                } ?>
                                            </div>
                                            <div class="s-time s-text-2"><?= $exp['description'] ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                        }
                        if ($achievement) {
                            ?>
                            <div class="achievements-detail set-li">
                                <div class="education-head">Achievements</div>
                                <ul>
                                    <?php
                                    foreach ($achievement as $achive) {
                                        ?>
                                        <li><?= $achive['achievement'] ?></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php
                        }
                        if ($hobbies) {
                            ?>
                            <div class="hobbies-detail set-li">
                                <div class="education-head">Hobbies</div>
                                <ul>
                                    <?php
                                    foreach ($hobbies as $hobby) {
                                        ?>
                                        <li><?= $hobby['hobby'] ?></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php
                        }
                        if ($interests) {
                            ?>
                            <div class="Interests-detail set-li">
                                <div class="education-head">Interests</div>
                                <ul>
                                    <?php
                                    foreach ($interests as $intrst) {
                                        ?>
                                        <li><?= $intrst['interest'] ?></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                <?php } ?>
            </div>
            <?php
            if (array_filter($job_preference)) {
                ?>
                <div class="sidebar-container" style="border-bottom: 3px solid #ff7803;">
                    <div class="prefer" style="background-color:#ff7803; color:#fff;">Job Preferences</div>
                    <div class="prefer-detail">
                        <ul>
                            <li><span class="set-width">Profile</span><span
                                        class="position"><?= $job_preference['profiles_name'] ?></span>
                            </li>
                            <li><span class="set-width">Type</span><span
                                        class="position"><?= $job_preference['type'] ?></span></li>
                            <li><span class="set-width">City</span><span
                                        class="position"><?= $job_preference['cities'] ?></span>
                            </li>
                            <li><span class="set-width">Skills</span><span
                                        class="position"><?= $job_preference['skills'] ?></span>
                            </li>
                            <li><span class="set-width">Industry</span><span
                                        class="position"><?= $job_preference['industry'] ?></span>
                            </li>
                            <li><span class="set-width">Experience</span><span
                                        class="position"><?= $job_preference['exp'] ?> year('s)</span>
                            </li>
                            <li><span class="set-width">Working Days</span><span
                                        class="position"><?= ($job_preference['sun_frequency']) ? 'Sun,' : '' ?> Mon, Tue, Wed, Thu, Fri<?= ($job_preference['sat_frequency']) ? ', Sat' : '' ?></span>
                            </li>
                            <li><span class="set-width">Timings</span><span
                                        class="position"><?= date("g:i A", strtotime($job_preference['from'])) . ' to ' . date("g:i A", strtotime($job_preference['to'])) ?> </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
            }
            if (array_filter($internship_preference)) {
                ?>
                <div class="sidebar-container" style="border-bottom: 3px solid #00a0e3;">
                    <div class="prefer" style="background-color:#00a0e3; color:#fff;">Internship Preferences</div>
                    <div class="prefer-detail">
                        <ul>
                            <li><span class="set-width">Profile</span><span
                                        class="position"><?= $internship_preference['profiles_name'] ?></span>
                            </li>
                            <li><span class="set-width">Type</span><span
                                        class="position"><?= $internship_preference['type'] ?></span></li>

                            <li><span class="set-width">City</span><span
                                        class="position"><?= $internship_preference['cities'] ?></span>
                            </li>
                            <li><span class="set-width">Skills</span><span
                                        class="position"><?= $internship_preference['skills'] ?></span>
                            </li>
                            <li><span class="set-width">Industry</span><span
                                        class="position"><?= $internship_preference['industry'] ?></span>
                            </li>
                            <li><span class="set-width">Working Days</span><span
                                        class="position"><?= ($internship_preference['sun_frequency']) ? 'Sun,' : '' ?> Mon, Tue, Wed, Thu, Fri<?= ($internship_preference['sat_frequency']) ? ', Sat' : '' ?></span>
                            </li>
                            <li><span class="set-width">Timings</span><span
                                        class="position"><?= date("g:i A", strtotime($internship_preference['from'])) . ' to ' . date("g:i A", strtotime($internship_preference['to'])) ?> </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
            }

            if ($userAppliedData && Yii::$app->user->identity->organization->organization_enc_id) {
                ?>
                <div class="col-md-4">
                    <div class="row">
                        <div class="portlet light border-rad">
                            <div class="portlet-title tabbable-line">
                                <div class="caption">
                                    <?php
                                    //                                    if ($_GET['id']) {
                                    //                                        echo '<span class="caption-subject font-dark bold uppercase">Also Applied In</span>';
                                    //                                    } else {
                                    echo '<span class="caption-subject font-dark bold uppercase">Applied In</span>';
                                    //                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="portlet-body over-scroll">
                                <div class="mt-comments">
                                    <?php
                                    foreach ($userAppliedData as $arr) {
                                        foreach ($arr as $pData) {
                                            ?>
                                            <a href="/account/process-applications/<?= $pData['application_enc_id'] ?>"
                                               class="mt-comment">
                                                <div class="mt-comment-img">
                                                    <img src="/assets/common/categories/<?= (($pData['job_icon']) ? $pData['job_icon'] : 'others.svg') ?>">
                                                </div>
                                                <div class="mt-comment-body">
                                                    <div class="mt-comment-info">
                                                        <span class="mt-comment-author"><?= $pData['title'] ?></span>
                                                        <span class="mt-comment-date"><?= (($pData['type'] == 'Jobs') ? 'Job' : 'Internship') ?></span>
                                                    </div>
                                                    <div class="mt-comment-text">
                                                        <?php
                                                        if ($pData['status'] == 'Hired' || $pData['status'] == 'Cancelled' || $pData['status'] == 'Rejected') {
                                                            echo $pData['status'];
                                                        } else {
                                                            if ($pData['process'][$pData['active']]['field_name']) {
                                                                echo(($pData['process'][$pData['active']]['field_name'] == 'Get Applications') ? 'New Application' : $pData['process'][$pData['active']]['field_name']);
                                                            } else {
                                                                echo $pData['status'];
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>


            <!-- Quiz Scores -->
            <!-- <div class="sidebar-container" style="border-bottom: 3px solid #ff7803;">
                <div class="prefer" style="background-color:#ff7803; color:#fff;">Quiz Played</div>
                <div class="prefer-detail">
                    <div class="recent-quiz">
                        <div class="quiz-heading">
                            <div class="date">Date</div>
                            <div class="title">Title</div>
                            <div class="score">Score</div>
                            <div class="drop-down"></div>
                        </div>
                        <div class="quiz-row show-one">
                            <div class="showed-con">
                                <div class="date">Oct 21</div>
                                <div class="title">Something</div>
                                <div class="score">65</div>
                                <div class="drop-down"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="drop-con">
                                Some data
                            </div>
                        </div>
                        <div class="quiz-row show-one">
                            <div class="showed-con">
                                <div class="date">Oct 21</div>
                                <div class="title">Something</div>
                                <div class="score">65</div>
                                <div class="drop-down"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="drop-con">
                                Some data
                            </div>
                        </div>
                        <div class="quiz-row show-one">
                            <div class="showed-con">
                                <div class="date">Oct 21</div>
                                <div class="title">Something</div>
                                <div class="score">65</div>
                                <div class="drop-down"><i class="fa fa-chevron-down"></i></div>
                            </div>
                            <div class="drop-con">
                                Some data
                            </div>
                        </div>
                    </div>

                    <a href="" class="view-more-quiz">View More</a>
                </div>
            </div> -->


        </div>
        <!--End Sidebar-->
        <!--        </div>-->
    </section>


    <?php 
    if(count($pastWebinar) !== 0){
    ?>
    <section class="webinar-attended">
        <div class="container">
            <div class="row">
                <div class="heading-style">Webinars Attended</div>
            </div>
            <div class="row">
                <?php
                foreach ($pastWebinar as $pWeb) {
                    $date = array();
                    foreach ($pWeb['webinarEvents'] as $key => $row) {
                        $date[$key] = $row['start_datetime'];
                    }
                    array_multisort($date, SORT_DESC, $pWeb['webinarEvents']);
                    ?>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <div class="web-card">
                            <div class="web-img">
                                <a href="<?= Url::to("/webinar/" . $pWeb['slug']) ?>">
                                    <img src="<?= $pWeb['image'] ?>">
                                </a>
                                <div class="web-detail-date">
                                    <div class="web-date">
                                        <?php
                                        $eventDate = webDate($pWeb['webinarEvents'][0]['start_datetime']);
                                        echo $eventDate;
                                        ?>
                                    </div>
                                    <!--<div class="web-paid">
                                        <?php
                                        $totalPrice = $pWeb['price'];
                                        $gstAmount = 0;
                                        if ($pWeb['gst']) {
                                            $gstPercent = $pWeb['gst'];
                                            if ($totalPrice > 0) {
                                                $gstAmount = round($gstPercent * ($totalPrice / 100), 2);
                                            }
                                        }
                                        $finalPrice = $totalPrice + $gstAmount;
                                        ?>
                                        <?= (($finalPrice == 0) ? 'Free' : '₹ ' . $finalPrice) ?>
                                    </div> -->
                                </div>
                            </div>
                            <div class="web-inr">
                                <div class="web-title"><a href="<?= Url::to("/webinar/" . $pWeb['slug']); ?>">
                                        <?= $pWeb['name'] ?></a></div>
                                <div class="web-speaker">
                                    <span><?= str_replace(',', ', </span><span>', trim($pWeb['speakers'])) ?></span></div>
                                <div class="web-des"><?= $pWeb['description'] ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>               
    </section>

    <?php } ?>

<?php
if (Yii::$app->user->identity->organization->organization_enc_id && !empty($userApplied)) {
    if (!empty($userApplied['applied_application_enc_id'])) {
        echo $this->render('@common/widgets/chat-main');
        $this->registerJs('
            $(".open_chat").trigger("click");
        ');
    }
}
$this->registerCss('

/*-----------Webinar Attended CSS Starts Here---------*/
.web-card {
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgb(0 0 0 / 20%);
    background-color: #fff;
    margin-bottom: 20px;
    min-height: 360px;
}
.web-img {
    position: relative;
}
.web-img img {
    height: 200px;
    object-fit: cover;
    width: 100%;
}
.web-detail-date {
    position: absolute;
    bottom: 5px;
    right: 10px;
    display: flex;
    align-items: center;
}
.web-date {
    border-radius: 4px;
    padding: 0px 8px;
    text-align: center;
    border: 2px solid #00a0e3;
    font-weight: 500;
    font-family: roboto;
    background-color: #00a0e3;
    color: #fff;
    margin-right: 2px;
}
.web-paid {
    background-color: #ff7803;
    border: 2px solid #ff7803;
    border-radius: 4px;
    padding: 0px 8px;
    text-align: center;
    text-transform: uppercase;
    font-family: roboto;
    font-weight: 500;
    color: #fff;
}
.web-inr {
    padding: 5px 10px 10px;
}
.web-title {
    font-size: 22px;
    font-family: lora;
    font-weight: 600;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.web-title a {
    color: #333;
}
.web-speaker {
    font-size: 12px;
    font-family: roboto;
    color: #a49f9f;
    font-weight: 500;
    height: 22px;
    overflow: hidden;
}
.web-des {
    font-family: roboto;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 70px;
}
/*-----------Webinar Attended CSS Ends Here---------*/

.over-scroll {
    position: relative;
    max-height: 550px;
    overflow-y: scroll;
}
.border-rad{
    border-radius:6px;
    box-shadow: 0 5px 6px rgb(0 0 0 / 20%);
}
.mt-comment-author {
    width: 70%;
    display: -webkit-box !important;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
  line-height:20px;
}
.pro-text {
	text-align: right;
	font-family: roboto;
	font-weight: 500;
}
.progress {
  padding: 2px;
  background: rgba(0, 0, 0, 0.1);
  border-radius: 20px;
  -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2), 0 1px rgba(255, 255, 255, 0.08);
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2), 0 1px rgba(255, 255, 255, 0.08);
  margin:0px 0 5px 0;
}
.process-clr{
    background-color:#ff7803;
}
.process-clr1{
    background-color:#00a0e3;
}
.progress-bar {
  height: 16px;
  border-radius: 20px;
	background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05));
  background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05));
  background-image: -o-linear-gradient(top, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05));
  background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05));
  -webkit-transition: 0.4s linear;
  -moz-transition: 0.4s linear;
  -o-transition: 0.4s linear;
  transition: 0.4s linear;
  -webkit-transition-property: width, background-color;
  -moz-transition-property: width, background-color;
  -o-transition-property: width, background-color;
  transition-property: width, background-color;
  -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, 0.25), inset 0 1px rgba(255, 255, 255, 0.1);
  box-shadow: 0 0 1px 1px rgba(0, 0, 0, 0.25), inset 0 1px rgba(255, 255, 255, 0.1);
}
.down-res{
    text-align:center;
    margin-top: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}
.social-info{
    text-align: center;
}
.down-res a:hover{
    background-color: #53bbeb;
}
.down-res a{
    background-color: #00a0e3;
    padding: 8px 12px;
    text-align: center;
    border-radius: 6px;
    margin: 0px 5px;
    color: #fff;
    transition: 0.3s;
    margin-top: 5px;
}
.down-res a i{
    padding-left: 8px;
}
.fbook a {
    background-color: #3b5998;
}
.tter a {
	background-color: #00aced;
}
.lin a {
	background-color: #007bb6;
}
.telegram a{
    background-color: #229ED9;
}
.mael a {
	background-color: #bb0000;
}
.skpe a {
	background-color: #00a0e3;
}
.whatsapp a {
	background-color: #25D366;
}
.talking a {
	background-color: #3b5998;
}
.down-r {
	text-align:center;
}
.down-r a {
	background-color: #00a0e3;
}
.prof-p {
	width: 80px;
	height: 80px;
	border-radius: 4px;
	overflow: hidden;
}
.prof-p img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}
.prof-p canvas {
    border-radius: 50%;
}
.prof-inner {
	margin: 0 0 0 10px;
}
.s-text-2 {
    font-size: 14px;
    color: #605c5c;
}
.user-icon.img-circle.img-responsive {
    width: 236px;
}
body{background-color:#f9f9f9;}
//.detail-section{
//    filter: blur(5px);
//    -webkit-filter: blur(5px);
//}
.education-head {
    font-size: 18px;
    font-weight: 500;
    font-family: roboto;
    padding-bottom: 3px;
    letter-spacing: 1px;
    color:#000;
}
.education-detail, .experience-detail, .achievements-detail, .Interests-detail, .hobbies-detail {
    padding-bottom: 15px;
}
.set {
    margin-bottom: -1px;
    padding: 10px 0;
    border-bottom: 1px solid #dddddd;
    display:flex;
    flex-wrap: wrap;
}
.s-text {
    font-size: 18px;
    font-family: roboto;
    color:#000;
}
.s-text > i{
    margin-right:7px;
}
.set-li > ul > li {
    display: inline-block;
    list-style: none;
    padding: 3px 15px;
    border: 1px solid #b9c5ce;
    border-radius: 6px;
    margin: 0 5px 10px 0;
    font-weight: 500;
    color: #605c5c;
}
.skillss > ul > li {
    display: inline-block;
    list-style: none;
    padding: 0px 5px;
    border: 1px solid #b9c5ce;
    border-radius: 6px;
    margin-right: 5px;
    font-weight: 500;
    color: #657180;
    margin-bottom:5px;
}
.working-days > ul > li {
    display: inline-block;
    border-radius: 14px;
    background: #ff7803;
    height: 25px;
    width: 25px;
    margin-right: 3px;
    line-height: 25px;
    text-align: center;
    cursor: pointer;
    color:#fff;
    margin-bottom:5px;
}
.working-days2 > ul > li {
    display: inline-block;
    border-radius: 14px;
    background: #00a0e3;
    height: 25px;
    width: 25px;
    margin-right: 3px;
    line-height: 25px;
    text-align: center;
    cursor: pointer;
    color:#fff;
    margin-bottom:5px;
}
.prefer-detail{
    padding:20px;
}
.prefer-detail > ul > li{
    font-size: 14px;
    font-family: sans-serif;
    padding-bottom:10px;
}
.set-width {
    width: 40%;
    display: inline-block;
    font-family:roboto;
    font-weight:500;
}
.position {
    width: 60%;
    display: inline-flex;
    font-family:roboto;
}
.prefer {
	font-size: 20px;
	font-family: roboto;
	text-align: center;
	padding: 3px;
}
.set-color{
    background: #ff7803;
    padding: 5px 15px;
    margin-left: -15px;
    color: #fff;
    font-family:roboto;
}
.edit-profile-btn{
    text-align: center;
    background-color: #00a0e3;
    color: #fff;
    padding: 5px 25px;
    box-shadow: 0px 1px 12px 1px #a5a5a5;
    border-radius: 4px;
    margin: 10px 5px 5px;
    font-size: 13px;
    display: inline-block;
    font-family:roboto;
}
.edit-profile-btn:hover, .edit-profile-btn:focus{
    background-color:#0392ce;
    color:#fff;
}
.freelance-image img{
    width:100%;
    height:100%;
    object-fit:fill;
}
 .inner-header-page{
    padding:100px 0 0px;	
}
.left-side-container {
	width: 100%;
	background-color: #fff;
	padding: 50px 50px 25px;
	position: relative;
	margin: auto;
	border-radius: 8px;
	margin-bottom: 25px;
	min-height: 300px;
	box-shadow:0 5px 6px rgba(0, 0, 0, 0.2);
}
.bl-1 {
    border-left: 1px solid #00a0e3 !important;
}
.inner-header-page .freelance-image {
	height: 240px;
	background: #fff;
	border-radius: 100%;
	box-shadow: 0 3px 12px rgba(0,0,0,.1);
	padding: 2px;
	position: absolute;
	left: -19%;
	top: 5%;
	width: 240px;
	overflow:hidden;
}
.inner-header-page .freelance-image img, .inner-header-page .freelance-image canvas{
//	max-width:140px;
//	margin-top:10px;
}
.header-details p{
    font-size:16px;
    font-family:roboto;
}
.header-details h4{
	margin:0 0 5px 0;
	font-size:34px;
	font-family:lora;
}
.header-details h4 span{
	font-size:17px;
}
.inner-header-page .header-details ul {
    padding: 0;
    margin: 0;
    list-style: none;
    line-height: 24px;
    margin-bottom: -7px;
}
.inner-header-page .header-details li {
    display: inline-block;
    margin-right: 20px;
    margin-bottom: 0px;
    font-family:roboto;
    font-size:16px;
}
.inner-header-page .header-details ul li img{
    height: 16px;
    border-radius: 3px;
    position: relative;
    top: -1px;
    display: inline-block;
    box-shadow: 0 0 3px rgba(0,0,0,.2);
    margin-right: 5px;
    cursor: default;
}
.verified-action{
    position: relative;
    height: 26px;
    display: flex;
    top: -1px;
    color: #fff;
    font-weight: 500;
    font-size: 14px;
    background-color: #00a0e3;
    text-align: center;
    z-index: 10;
    font-weight: 500;
    border-radius: 4px;
    padding: 0 8px 0 0;
    margin: 0;
    overflow: hidden;
    padding-left: 34px;
    line-height: 27px;
}
.verified-action:before {
    content: "\f00c";
    font-family:FontAwesome;
    font-size: 16px;
    color: #fff;
    position: absolute;
    top: 0;
    left: 0;
    line-height: 26px;
    height: 26px;
    width: 26px;
    display: inline-block;
    background-color: #0395d8;
}
.header-details {
    padding-left: 100px;
}
.inner-header-page .header-details li .star-rating {
    position: relative;
    top:0px;
}
.star-rating::before {
    content: attr(data-rating);
    float: left;
    background-color:#febe42;
    color:#ffffff;
    font-size: 14px;
    line-height: 15px;
    font-weight: 700;
    position: relative;
    top: 1px;
    margin-right: 10px;
    border-radius: 4px;
    padding: 5px 7px;
}
.inner-header-page .header-details li .star-rating .fa {
    color: #94a0ad;
}
.inner-header-page .header-details li .star-rating .fa.fill {
    color:#febe42;
}
.right-side-detail {
	background-color: #fff;
	padding: 30px 20px 5px;
	border-radius: 8px;
    min-height:300px;
    box-shadow:0 5px 6px rgba(0, 0, 0, 0.2);
}
.right-side-detail ul {
    padding: 0;
    margin: 0;
}
.right-side-detail ul li {
    list-style: none;
    padding: 5px 0;
}
.right-side-detail ul li .detail-info {
    width: 135px;
	font-weight:500;
    display: inline-block;
    font-family:roboto;
}
.right-side-detail ul.social-info li{
	display:inline-block;
	margin:5px 2px;
}
.right-side-detail ul.social-info li a {
    width: 30px;
    height: 30px;
    display: inline-block;
    text-align: center;
    line-height: 30px;
    border-radius: 6px;
    color:#fff;
}
span.available-status {
    margin-left: 10px;
    background: #ff7803;
    padding: 5px 15px;
    border-radius: 4px;
    color: #ffffff;
}
/*------------ job Apply Detail ----------------*/
.container-detail-box{
    background: #ffffff;
    border-radius: 6px;
    overflow: hidden;
	padding:30px 30px;
    margin-bottom: 30px;
    position: relative;
    box-shadow:0 5px 6px rgba(0, 0, 0, 0.2);
}
.apply-job-detail{
	margin-bottom:30px;
	font-family:roboto;
	color:#605c5c;
}
.apply-job-detail h5{
	font-size:18px;
	font-family:roboto;
	color:#000;
}
.apply-job-header a {
    margin-right: 15px;
    font-family:roboto;
}
.apply-job-header span {
	font-family: roboto;
}
.apply-job-header a i, .apply-job-header span i {
    margin-right: 5px;
}
.apply-job-header {
    margin-bottom: 40px;
}
.apply-job-header h4{
	font-size:22px;
	font-family:roboto;
}
ul.skills,  ul.job-requirements{
    margin: 15px 0;
    padding: 0;
}
ul.skills li {
    display: inline-block;
    list-style: none;
    padding: 3px 15px;
    border: 1px solid #b9c5ce;
    border-radius: 6px;
    margin: 5px;
    font-weight: 400;
    font-family:roboto;
    color: #605c5c;
}

ul.job-requirements li{
	list-style:none;
	display:block;
	padding:7px 0;
}
ul.job-requirements li span{
	display:inline-block;
	width:120px;
	font-weight:500;
}

/*---------- Login -------------*/
img.img-responsive.payment-img {
    margin-top: 20px;
}
/*--------------------------------------------------- 
	Default Sidebar
-----------------------------------------------*/
.sidebar-wrapper{
    background: #ffffff;
    border-radius: 6px;
    overflow: hidden;
	text-align:left;
    margin-bottom: 30px;
    position: relative;
    transition: .4s;
	padding:0 25px 30px;
    border: 1px solid #eaeff5;
}
.sidebar-box-header{
	padding:15px 0;
	margin-bottom:20px;
}
.sidebar-box-header h4{
	font-size:17px;
	margin:5px 0;
}
.member-profile-list {
    display: table;
    width: 100%;
}
.member-profile-list {
    padding: 15px 0;
	border-bottom:1px solid #eaeff5;
    text-align: left;
}
.member-profile-list:last-child{
	border-bottom:none;
}
.member-profile-thumb {
    width:70px;
    float: left;
}
.member-profile-detail {
    margin-left: 80px;
	margin-top:7px;
}
.member-profile-detail h4 {
    margin: 0 0 2px 0;
}
.member-profile-detail span {
    display: block;
	line-height:1.5;
    font-size: 13px;
}

/*--------------- Sidebar: Detail For Freelancer ----------------*/
.sidebar-container {
	background: #ffffff;
	overflow: hidden;
	margin-bottom: 25px;
	position: relative;
	transition: .4s;
	/* padding: 0px 15px 10px 15px; */
	/* border: 1px solid #eee; */
	border-radius: 8px;
	box-shadow: 0 5px 6px rgba(0, 0, 0, 0.2);
}
.sidebar-container:hover, .sidebar-container:focus{
    transform: translateY(-5px);
    -webkit-transform: translateY(-5px);
}
.sidebar-box{
    text-align: center;
    padding:60px 20px 15px;
}
.style-2 .sidebar-box {
    padding: 40px 20px 35px;
}
.sidebar-status {
    position: absolute;
    right:0px;
    top: 0px;
    background:#ff7803;
    color: #ffffff;
    padding: 4px 18px;
    border-radius: 0px 4px;
    font-weight: 500;
}

.flc-rate{
    position: absolute;
    right:32px;
    top: 20px;
    font-size:18px;
    font-weight: 500;
}

.sidebar-box-thumb {
    margin-bottom: 30px;
    width: 120px;
	height:120px;
    margin: 0 auto 25px auto;
	border-radius:50%;
	overflow:hidden;
	box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-moz-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
}
.sidebar-box-thumb img{
    width:100%;
    height:100%;
}
.style-2 .sidebar-box-thumb {
    width: 100px;
	height:100px;
    margin: 0 auto 15px auto;
	border-radius:50%;
	overflow:hidden;
	box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-webkit-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
	-moz-box-shadow: 0 0px 14px 0 rgba(0, 0, 0, 0.08);
}
.sidebar-box-detail h4{
	margin-bottom:4px;
	font-size:22px;
}
.sidebar-box-detail .desination, .sidebar-box-detail .location{
	font-weight:500;
	font-size:15px;
	display:block;
	color:#677484;
}
.sidebar-box-extra ul {
    margin: 15px 0;
	padding:0;
}
.sidebar-box-extra ul li {
    display: inline-block;
    list-style: none;
    padding:3px 15px;
    border: 1px solid #b9c5ce;
    border-radius: 50px;
    margin: 5px;
    font-weight: 500;
    color: #657180;
}
.sidebar-box-extra ul li.more-skill{
	color:#ffffff;
	border-color:#1194f7;
}
a.btn.btn-sidebar {
    padding: 17px;
    display: inline-block;
    width: 100%;
    font-size: 16px;
    font-weight: 500;
    border-radius: 0;
}
a.btn.btn-sidebar{
	color:#333333;
	background: #fff;
    border-top: 1px solid #eaeff5;
}
a.btn.btn-sidebar:hover, a.btn.btn-sidebar:focus{
	background:#00a0e3;
	color:#ffffff;
}
.cl-success {
    color: #00a0e3 !important;
}
ul.status-detail {
    width: 100%;
    display: table;
    margin:20px 0;
}
ul.status-detail li {
    display: inline-block;
    width: 33%;
    padding: 10px 0;
    border: none;
    border-radius: 0;
    text-align: center;
    display: table-cell;
	font-size:13px;
}
ul.status-detail li>strong {
    display: block;
    font-weight: 600;
    font-size: 16px;
}

.offer-bttn{
    border:2px solid #00a0e3;
    color:#00a0e3;
      -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
}
.offer-bttn:hover{
    background:#00a0e3;
    color:#fff;
    -o-transition: .3s all;
    -ms-transition: .3s all;
    -moz-transition: .3s all;
    -webkit-transition: .3s all;
    transition: .3s all;
}
.portlet {
        margin-bottom: 25px;
        padding: 12px 20px 15px;
        background-color: #fff;
    }
    .portlet>.portlet-title {
        border-bottom: 1px solid #eee;
        padding: 0;
        margin-bottom: 10px;
        min-height: 48px;
    }
    .portlet>.portlet-title>.caption {
        float: left;
        display: inline-block;
        font-size: 18px;
        line-height: 18px;
        padding: 10px 0;
        color: #666;
    }
    .portlet.light>.portlet-title>.caption>.caption-subject {
        font-size: 16px;
        color: #2f353b;
        text-transform: uppercase;
        font-weight: 700;
    }
    .portlet.light .portlet-body {
        padding-top: 8px;
        clear: both;
    }
    .mt-comments .mt-comment {
        padding: 10px;
        margin: 0 0 10px;
        display:block;
    }
    .mt-comments .mt-comment .mt-comment-img {
        width: 40px;
        float: left;
        margin-right: 8px;
    }
    .mt-comments .mt-comment .mt-comment-img>img {
        border-radius: 50%!important;
        width:40px;
        height: 40px;
    }
    .mt-comments .mt-comment .mt-comment-body {
        padding-left: 10px;
        position: relative;
        /*overflow: hidden;*/
    }
    .mt-comments .mt-comment .mt-comment-body .mt-comment-info .mt-comment-author {
        margin: 0px;
        color: #060606;
        font-weight: 600;
        width: 70%;
        display: -webkit-box !important;
        -webkit-line-clamp:1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 20px;
    }
    .mt-comments .mt-comment .mt-comment-body .mt-comment-info .mt-comment-date {
        display: inline-block;
        float: right;
        background: #00a0e3;
        color: #fff;
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 12px;
    }
    .mt-comments .mt-comment .mt-comment-body .mt-comment-text {
        color: #999;
    }
    .radio_questions {
	max-width: 100%;
	font-size: 18px;
	font-weight: 600;
	line-height: 36px;
	position: relative;
}
.inputGroup {
	background-color: #fff;
	display: block;
	margin: 10px 0;
	position: relative;
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
.inputGroup input:checked~label {
	color: #fff;
	box-shadow: 0 0 10px rgba(0, 0, 0, .3) !important;
}
.inputGroup label {
	padding: 6px 75px 6px 25px !important;
	width: 96%;
	display: block;
	margin: auto;
	text-align: left;
	color: #3C454C !important;
	cursor: pointer;
	position: relative;
	z-index: 2;
	transition: color 1ms ease-out;
	overflow: hidden;
	border-radius: 8px;
	border: 1px solid #eee;
	font-size:16px;
    font-family: Roboto;
}
.inputGroup input:checked~label:before {
	transform: translate(-50%, -50%) scale3d(56, 56, 1);
	opacity: 1;
}
.inputGroup label:before {
	width: 100%;
	height: 10px;
	border-radius: 50%;
	content: \'\';
	background-color: #fff;
	position: absolute;
	left: 50%;
	top: 50%;
	transform: translate(-50%, -50%) scale3d(1, 1, 1);
	transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
	opacity: 0;
	z-index: -1;
	box-shadow: 0 0 10px rgba(0, 0, 0, .5) !important;
}
.inputGroup input:checked ~ label:after {
	background-color: #00a0e3;
	border-color: #00a0e3;
}
.colorOrange{
    color: #ff7803;
}
.colorBlue{
    color: #00a0e3;
}
.process_radio label:after {
	width: 26px;
	height: 26px;
	content: \'\';
	border: 2px solid #D1D7DC;
	background-color: #fff;
	background-repeat: no-repeat;
	background-position: 2px 3px;
	background-image: url("data:image/svg+xml,%3Csvg width=\'26\' height=\'26\' viewBox=\'0 0 32 32\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z\' fill=\'%23fff\' fill-rule=\'nonzero\'/%3E%3C/svg%3E ");
	border-radius: 50%;
	z-index: 2;
	position: absolute;
	right: 30px;
	top: 50%;
	transform: translateY(-50%);
	cursor: pointer;
	transition: all 200ms ease-in;
}
.progress-bar-description{
    font-size: 12px !important;
    color: #777;
    font-weight: 500;
    font-style: italic;
}




/* Quiz Score CSS*/
.sidebar-container {
    background: #ffffff;
    overflow: hidden;
    margin-bottom: 25px;
    position: relative;
    transition: .4s;
    border-radius: 8px;
    box-shadow: 0 5px 6px rgb(0 0 0 / 20%);
}
.quiz-heading, .showed-con {
    display: flex;
    align-items: center;
    width: 100%;
}

.quiz-heading {
    margin: 0;
    font-weight: 600;
    margin-bottom: -7px;
}
.quiz-row {
    margin: 15px 0;
    padding: 5px 11px;
    line-height: 22px;
    box-shadow: 0 0 2px 2px #eee;
    overflow: hidden;
    transition: all linear .2s;
    border-radius: 4px;
}
.view-more-quiz {
    display: inline-block;
    background: #ff7803;
    color: #fff;
    margin: auto;
    position: relative;
    padding: 4px 15px;
    left: 50%;
    transform: translate(-50%);
}
.prefer-detail {
    padding: 20px;
}
.title {
    flex-basis: 55%;
}
.score {
    flex-basis: 15%;
    text-align: center;
}
.date {
    flex-basis: 25%;
    font-size: 12px;
    font-weight: 600;
}
.drop-down{
    flex-basis: 10%;
    text-align: right;
}

.drop-down i.rotate{
    transform: rotate(180deg);
    transition: all linear .2s;
}
.drop-down i{
    transition: all linear .2s;
}
.reward {
    width: 30px;
    height: 30px;
    background: #FFC93C;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}
.show-one{
    height: 30px;
}
.show-hide{
    height: 60px;
}
@media screen and (max-width: 525px){
    .header-details {
        margin-top: 0px;
        display: inherit;
        padding-left:0;
        text-align:center;
    }
    .inner-header-page .freelance-image {
        position: relative;
        left: 0;
        top: 0;
        margin: auto;
        width: 160px;
        height: 160px;
    }
}
@media screen and (max-width: 991px) and (min-width: 768px) {
    .right-side-detail ul.social-info li {
        margin: 2px;
    }
    .edit-profile-btn {
        padding: 5px 20px;
    }
}
@media screen and (max-width: 450px){
    .set{
        display:block;
    }
    .prof-inner {
        margin: 5px 0 0 0;
    }
}
.disabled-elem{
    opacity: 0.5;
    cursor: not-allowed;
}
');
$script = <<< JS

$('.drop-down').click(function(){
    $(this).parent('div').parent('div').toggleClass('show-hide');
    $(this).children('i').toggleClass('rotate');
});


var user_id = "$uId";
$(document).on('click','#phone-val',function(e) {
  e.preventDefault();
  var phone = $(this).attr('value');
                swal({
                        title: phone,
                        text: "",
                        type:"info",
                        showCancelButton: true,  
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Call",
                        cancelButtonText:"Close",
                        closeOnConfirm: true, 
                        closeOnCancel: true
                         },
                            function (isConfirm) { 
                             if (isConfirm){
                                 window.open('tel:' + phone);
                             }
                         }
                        );
})

$(document).on('click', '#scheduleInterviewSubmit', function() {
    window.location.replace($('input[name="scheduleInterview"]:checked').val());
})
$(document).on('click','.download-resume',function (e){
    e.preventDefault();
    let btnElem = $(this);
    let resume_location = $(this).attr('data-key');
    let resume = $(this).attr('data-id');
    let htmldata = $(this).html();
    btnElem.addClass('disabled-elem');
    btnElem.html('<i class="fas fa-circle-notch fa-spin fa-fw p-0"></i>');
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
if($('.over-scroll').length){
    var ps = new PerfectScrollbar('.over-scroll');
}
$(document).on('click', '.shortlist-main', function (event) {
	event.preventDefault();
	$('.application_list:checked').prop('checked',false);
	$.ajax({
		type: "POST",
		url: "/candidates/get-data",
		data: {
			user_id: user_id
		},
		success: function (response) {
			var res = JSON.parse(response);
			if (res["status"] == 404) {
				$('#shortList').modal('toggle');
			} else {
				for (var i = 0; i < res.length; i++) {
					$('.application_list').each(function () {
						if ($(this).attr('id') == res[i]['application_enc_id']) {
							$(this).attr('name', 'already-checked-' + i);
							$(this).prop('checked', true);
							$(this).prop('disabled', true);
						}
					})
				}
				$('#shortList').modal('toggle');
			}
		}
	});
});
if(document.getElementById('submitData')){
    document.getElementById('submitData').addEventListener('click', function () {
	var applications = document.getElementsByName('applications');
	var selected_value;
	for (var i = 0; i < applications.length; i++) {
		if (applications[i].checked) {
			app_id = applications[i].value;
		}
	}
	$.ajax({
		type: "POST",
		url: "/candidates/shortlist",
		data: {
			user_id: user_id,
			app_id: app_id
		},
		success: function (response) {
			if (JSON.parse(response)["status"] == 200) {
			    $('.shortlist-main').html('Shortlisted<i class="fas fa-heart"></i>');
				// toastr.success('successfully shortlisted', 'success');
			} else {
				// toastr.error('an error occurred', 'error');
			}
		}
	});
});
}
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
