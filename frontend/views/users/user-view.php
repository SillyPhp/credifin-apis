<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\widgets\DatePicker;

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

$statesModel = new \common\models\States();
$states = ArrayHelper::map($statesModel->find()->alias('z')->select(['z.state_enc_id', 'z.name'])->joinWith(['countryEnc a'], false)->where(['a.name' => 'India'])->orderBy(['z.name' => SORT_ASC])->asArray()->all(), 'state_enc_id', 'name');

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

<section class="inner-header-page">
    <div class="container">
        <div class="col-md-7 col-sm-10 col-md-offset-1 col-sm-offset-1">
            <div class="left-side-container">
                <div class="edit-profile-pen">
                    <i class="fas fa-pencil-alt edit-btnn" data-id="edit-name-detail"></i>
                </div>
                <div class="freelance-image">
                    <?php
                    $name = $image = NULL;
                    if (!empty($user['image'])) {
                        $image = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $user['image_location'] . DIRECTORY_SEPARATOR . $user['image'];
                    }
                    $name = $user['first_name'] . ' ' . $user['last_name'];
                    if ($image):
                        ?>
                        <img src="<?= $image; ?>" alt="<?= $name; ?>" class="img-circle"/>
                    <?php else: ?>
                        <canvas class="user-icon img-circle img-responsive" name="<?= $name; ?>"
                                color="<?= $user['initials_color']; ?>" width="140" height="140"
                                font="70px"></canvas>
                    <?php endif; ?>
                </div>
                <div class="header-details">
                    <?php
                        Pjax::begin([
                            'id' => 'userbasicDetails'
                        ])
                    ?>
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
                    Pjax::end();
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
                        <a href="javascript:;" class="edit-profile-btn edit-pf">Edit Profile</a>
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
                    if (!empty($user['email'])) { ?>
                        <li class="mael">
                            <a href="mailto:<?= Html::encode($user['email']) ?>"
                               target="_blank">
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
                                   class="download-resume"
                                   data-key="<?= $userCv['resume_location'] ?>" data-id="<?= $userCv['resume'] ?>">Download
                                    Resume<i
                                            class="fas fa-download"></i></a>
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
                    <div class="apply-job-detail awesome-size ">
                        <h5>About Me <i class="fas fa-pencil-alt edit-profile-pen edit-btnn" data-id="edit-description"></i></h5>
                        <?php
                            pjax::begin([
                                'id'=>'user_description'
                            ])
                        ?>
                        <p><?= Html::encode($user['description']); ?></p>
                        <?php
                        pjax::end();
                        ?>
                    </div>
                    <?php if ($skills) { ?>
                        <div class="apply-job-detail awesome-size">
                            <h5>Skills <i class="fas fa-pencil-alt edit-profile-pen edit-btnn" data-id="edit-skills"></i></h5>
                            <?php
                                Pjax::begin([
                                    'id'=>'skills_display',
                                ])
                            ?>
                            <ul class="skills">
                                <?php
                                foreach ($skills as $sk) { ?>
                                    <li><?= $sk['skills']; ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                                Pjax::end();
                            ?>
                        </div>
                    <?php }
                    if ($language) {
                        ?>
                        <div class="apply-job-detail awesome-size">
                            <h5>Spoken Languages <i class="fas fa-pencil-alt edit-profile-pen edit-btnn"
                                                    data-id="edit-languages"></i></h5>
                            <?php
                                pjax::begin([
                                        'id' => 'languages_display'
                                ])
                            ?>
                            <ul class="skills">
                                <?php
                                foreach ($language as $lg) { ?>
                                    <li><?= $lg['language']; ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                                pjax::end();
                            ?>
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
                            <h5 class="education-head">
                                <span>Education</span>
                                <span><a href="javascript:;" class="edu-add-btn edit-btnn" data-type="add-new-education" data-id="add-education">
                                       <i class="fa fa-plus"></i> Add Education</a></span>
                            </h5>
                            <?php
                            pjax::begin(['id' => 'education_display']);
                            foreach ($education as $edu) {
                                ?>
                                <div class="set">
                                    <div class="side-btns">
                                        <i class="fas fa-pencil-alt edit-profile-pen edit-btnn"
                                           data-id="add-education" data-type="education" type="button" data-toggle="modal"
                                           id="<?= $edu['education_enc_id'] ?>" data-name="education_enc_id" data-target="#editModal"></i>
                                        <i class="fas fa-times edit-profile-pen edu-del" type="button"
                                           id="<?= $edu['education_enc_id'] ?>"></i>
                                    </div>
                                    <div class="prof-p">
                                        <!--                                    <img src="-->
                                        <?//= Url::to('@eyAssets/images/pages/index2/nslider-image1.jpg') ?><!--"/>-->
                                        <canvas class="user-icon" name="<?= $edu['institute'] ?>" width="80"
                                                height="80" font="30px"
                                                color="<?= $edu['initials_color']; ?>"></canvas>
                                    </div>
                                    <div class="prof-inner">
                                        <div class="uni-name s-text"><?= $edu['institute'] ?>
                                        </div>
                                        <div class="quelification s-text-2">
                                            <?= $edu['degree'] . ' (' . $edu['field'] . ')' ?>
                                        </div>
                                        <div class="s-time s-text-2"></i><?= date("Y", strtotime($edu['from_date'])) . ' - ' . date("Y", strtotime($edu['to_date'])) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            pjax::end();
                            ?>
                        </div>
                        <?php
                    }
                    if ($experience) {
                        ?>
                        <div class="experience-detail">
                            <h5 class="education-head">
                                <Span>Work Experience</Span>
                                <span><a href="javascript:;" class="edu-add-btn edit-btnn" data-id="add-experience"
                                     data-type="add-new-experience"><i class="fa fa-plus"></i> Add Experience</a></span>
                            </h5>
                            <?php
                            pjax::begin(['id' => 'experience_display']);
                            foreach ($experience as $exp) {
                                ?>
                                <div class="set">
                                    <div class="side-btns">
                                        <i class="fas fa-pencil-alt edit-profile-pen edit-btnn" type="button" data-toggle="modal"
                                          data-id="add-experience" data-name="experience_enc_id" id="<?= $exp['experience_enc_id'] ?>"
                                           data-type="experience" data-target="#editModal"></i>
                                        <i class="fas fa-times edit-profile-pen exp-del" type="button" data-id="<?= $exp['experience_enc_id'] ?>"></i>
                                    </div>
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
                            pjax::end();
                            ?>
                        </div>
                        <?php
                    }
                    Pjax::begin([
                        'id' => 'pjax_achievements',
                    ]);
                    if ($achievement) {
                        ?>
                        <div class="achievements-detail set-li awesome-size">
                            <h5 class="achievements-head all-head">Achievements
                                <i class="fas fa-pencil-alt edit-profile-pen edit-btnn" data-id="add-achievements"></i></h5>
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
                    Pjax::end();

                    Pjax::begin([
                        'id' => 'pjax_hobby',
                    ]);
                    if ($hobbies) {
                        ?>
                        <div class="hobbies-detail set-li awesome-size">

                            <h5 class="hobbies-head all-head">Hobbies
                                <i class="fas fa-pencil-alt edit-profile-pen edit-btnn" data-id="add-hobbies"></i></h5>

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
                    pjax::end();

                    Pjax::begin([
                        'id' => 'pjax_interest',
                    ]);
                    if ($interests) {
                        ?>
                        <div class="Interests-detail set-li awesome-size">
                            <h5 class="interest-head all-head">Interests <i class="fas fa-pencil-alt edit-profile-pen edit-btnn" data-id="add-interest"></i></h5>
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
                    Pjax::end();
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
                                if ($_GET['id']) {
                                    echo '<span class="caption-subject font-dark bold uppercase">Also Applied In</span>';
                                } else {
                                    echo '<span class="caption-subject font-dark bold uppercase">Applied In</span>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="portlet-body over-scroll">
                            <div class="mt-comments">
                                <?php
                                foreach ($userAppliedData as $data) {
                                    ?>
                                    <a href="/<?= (($data['type'] == 'Jobs') ? 'job/' : 'internship/') . $data['slug'] ?>"
                                       class="mt-comment">
                                        <div class="mt-comment-img">
                                            <img src="/assets/common/categories/<?= (($data['icon']) ? $data['icon'] : 'others.svg') ?>">
                                        </div>
                                        <div class="mt-comment-body">
                                            <div class="mt-comment-info">
                                                <span class="mt-comment-author"><?= $data['category'] ?></span>
                                                <span class="mt-comment-date"><?= (($data['type'] == 'Jobs') ? 'Job' : 'Internship') ?></span>
                                            </div>
                                            <div class="mt-comment-text"> <?= $data['parent'] ?></div>
                                        </div>
                                    </a>
                                    <?php
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
    </div>
    <!--End Sidebar-->
    <!--        </div>-->
</section>

<!--Edit Modal start here-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="parent row">
                    <div class="edit-name-detail col-md-12">
                        <!--                                <h3 class="edit-detail">Personal Details</h3>-->
                        <form class="text-center">
                            <div class="form-group text-left">
                                <label for="full_name" class="label-edit">Name</label>
                                <input type="text" class="form-control form-control-edit" data-name="full_name" id="full_name"
                                       placeholder="Enter Name" value="<?= $user['first_name'] .''. $user['last_name']  ?>">
                            </div>
                            <div class="form-group text-left">
                                <label for="job_title" class="label-edit">Position</label>
                                <input type="text" class="form-control form-control-edit" data-name="job_title" id="job_title"
                                       placeholder="Enter Position" value="<?= $user['job_profile'] ?>">
                            </div>
                            <div class="form-group">
                                <div class="form-group lp-form posRel text-left">
                                    <label class="label-edit">State</label>
                                    <select id='states_drp' data-name="state" value="<?= $user['state_enc_id'] ?>"
                                            class="form-control form-control-edit text-capitalize chosen">
                                        <?php
                                        if ($states) {
                                            foreach ($states as $key => $state) {
                                                ?>
                                                <option value="<?= $key ?>" <?php echo (($key == $user['state_enc_id']) ? 'selected': ''); ?>><?= $state ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <p class="errorMsg"></p>
                                </div>
                                <div class="form-group lp-form posRel text-left">
                                    <label class="label-edit">City</label>
                                    <select id="cities_drp" data-name="city" value="<?= $user['city_enc_id'] ?>"
                                            class="form-control form-control-edit text-capitalize chosen">

                                    </select>
                                    <p class="errorMsg selectError"></p>
                                </div>
                            </div>
                            <button type="button" data-name="basic-details" class="btn btn-primary mt10 updatedata">Submit</button>
                        </form>
                    </div>
                    <div class="edit-description col-md-12">
                        <form class="text-center">
                            <div class="form-group text-left">
                                <label for="job_title" class="label-edit">Description</label>
                                <textarea class="form-control form-control-edit" data-name="description" id="description"
                                      placeholder="Enter Position" value="<?= $user['description'] ?>"><?= $user['description'] ?></textarea>
                            </div>
                            <button type="button" data-name="description" class="btn btn-primary mt10 updatedata">Submit</button>
                        </form>
                    </div>
                    <div class="edit-skills col-md-12">
                        <form class="text-center">
                            <div class="form-group text-left">
                                <label for="skills-name" class="label-edit">Skills</label>
                                <ul class="old-skills tags skill_tag_list">
                                    <?php
                                    foreach ($skills as $sk) { ?>
                                        <li class="addedskills"><?= $sk['skills']; ?>
                                            <span class="tagRemove" onclick="$(this).parent().remove();">x</span>
                                            <input type="hidden" name="skills[]" value="<?= $sk['skills'] ?>">
                                        </li>
                                        <?php
                                    }
                                    ?>
                                    <li class="tagAdd taglist">
                                        <div class="skill_wrapper">
                                            <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                            <input type="text" id="search-skill" class="skill-input text-capitalize form-control form-control-edit">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <button type="button" data-name="skills" class="btn btn-primary mt10 updateSkills" >Submit</button>
                        </form>
                    </div>
                    <div class="edit-languages col-md-12">
                        <form class="text-center">
                            <div class="form-group text-left">
                                <label for="language-name" class="label-edit">Spoken Languages</label>
                                <ul class="old-languages tags languages_tag_list">
                                    <?php
                                        foreach ($language as $lg) { ?>
                                            <li class="addedskills"><?= $lg['language']; ?>
                                                <span class="tagRemove" onclick="$(this).parent().remove();">x</span>
                                                <input type="hidden" name="languages[]" value="<?= $lg['language']; ?>">
                                            </li>
                                            <?php
                                        }
                                    ?>
                                    <li class="tagAdd taglist">
                                        <div class="language_wrapper">
                                            <i class="Typeahead-spinner fas fa-circle-notch fa-spin fa-fw"></i>
                                            <input type="text" id="search-language" data-name="languages"
                                                   class="skill-input text-capitalize form-control form-control-edit">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <button type="button" data-name="languages" class="btn btn-primary mt10 updateSkills">Submit</button>
                        </form>
                    </div>
                    <div class="add-education col-md-12">
                        <form id="new-edu-form" class="text-center">
                            <div class="form-group text-left">
                                <label for="institute" class="label-edit">Education</label>
                                <input type="text" class="form-control form-control-edit" id="institute"
                                    data-name="institute" placeholder="School/College Name">
                            </div>
                            <div class="form-group text-left">
                                <label for="degree" class="label-edit">Class/Degree</label>
                                <input type="text" class="form-control form-control-edit" id="degree"
                                       data-name="degree" placeholder="Degree">
                            </div>
                            <div class="form-group text-left">
                                <label for="field" class="label-edit">Stream</label>
                                <input type="text" class="form-control form-control-edit" id="field"
                                       data-name="field" placeholder="Stream Name">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <div class="input-group date">
                                            <span class="input-group-addon kv-date-picker" title="Select date"><i
                                                        class="glyphicon glyphicon-calendar kv-dp-icon"></i></span>
                                            <input type="text" class="form-control krajee-datepicker"
                                                   placeholder="From Year" aria-invalid="true"
                                                   id="from_date" data-name="from_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <div class="input-group  date">
                                            <span class="input-group-addon kv-date-picker" title="Select date"><i
                                                        class="glyphicon glyphicon-calendar kv-dp-icon"></i></span>
                                            <input type="text" class="form-control"
                                               placeholder="To Year" aria-invalid="true" id="to_date"
                                               data-name="to_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="education_error"></p>
                            <button type="button" data-name="add_new_education" data-id="education_enc_id"
                                    class="btn btn-primary mt10 eduUpdate updatedata">Submit</button>

                        </form>
                    </div>
                    <div class="add-experience col-md-12">
                        <form class="text-center">
                            <div class="form-group text-left">
                                <label for="job-name" class="label-edit">Title *</label>
                                <input type="text" class="form-control form-control-edit" data-name="title"
                                       id="update_exp_title" placeholder="Job Title">
                            </div>
                            <div class="form-group text-left">
                                <label for="comp-name" class="label-edit">Company *</label>
                                <input type="text" class="form-control form-control-edit" data-name="company"
                                       id="update_exp_company" placeholder="Company Name">
                            </div>
                            <div class="form-group text-left">
                                <label for="locations-name" class="label-edit">Location *</label>
                                <input type="text" class="form-control form-control-edit" id="update_cities"
                                      data-name="city" placeholder="Location">
                                <input type="hidden" class="form-control form-control-edit" data-name="city_enc_id" id="update_city_id_exp">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group text-left">
                                        <label class="label-edit">Start Date *</label>
                                        <div class="input-group  date">
                                            <span class="input-group-addon kv-date-picker" title="Select date"><i
                                                        class="glyphicon glyphicon-calendar kv-dp-icon"></i></span>
                                            <input type="text" class="form-control krajee-datepicker"
                                                   placeholder="Work Experience From" id="update_exp_from"
                                                   data-name="from_date"
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 update_experience">
                                <div class="form-group text-left">
                                    <label class="label-edit">End Date</label>
                                    <div class="input-group  date">
                                        <span class="input-group-addon kv-date-picker" title="Select date"><i
                                                    class="glyphicon glyphicon-calendar kv-dp-icon"></i></span>
                                        <input type="text" class="form-control"
                                               placeholder="Work Experience To" id="update_exp_to"
                                               data-name="to_date"
                                        >
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control control-check">I currently Work here
                                    <input type="checkbox" id="update_exp_present" data-name="is_current">
                                    <div class="control__indicator"></div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-left">
                                    <label for="comp-salary" class="label-edit">Salary</label>
                                    <input type="text" class="form-control form-control-edit" data-name="salary"
                                           id="update_salary">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-left">
                                    <label for="comp-ctc" class="label-edit">CTC</label>
                                    <input type="text" class="form-control form-control-edit" data-name="ctc"
                                           id="update_ctc">
                                </div>
                            </div>
                            <div class="form-group text-left">
                                <label for="comp-description" class="label-edit">Description *</label>
                                <textarea class="form-control form-textarea" data-name="description" id="update_description"></textarea>
                            </div>
                            <p class="experience_error"></p>
                            <button type="button" data-name="add_new_experience" data-id="experience_enc_id"
                                class="btn btn-primary expUpdate mt10 updatedata">Submit</button>

                        </form>
                    </div>
                    <div class="add-achievements col-md-12">
                        <form onsubmit="return false">
                            <div class="form-group">
                                <label for="achievements-name" class="label-edit">Achievements</label>
                                <ul class="tags skill_tag_list">
                                    <?php
                                    if (!empty($achievement)) {
                                        foreach ($achievement as $a) { ?>
                                            <li class="addedTag"><?= $a['achievement'] ?>
                                                <span id="<?= $a['user_achievement_enc_id'] ?>" class="achievement_remove">x</span>
                                            </li>
                                        <?php }
                                    }
                                    ?>
                                    <li class="tagAdd taglist">
                                        <div class="skill_wrapper">
                                            <input type="text" id="achievement_input" class="achievement_search input_search text-capitalize
                                                   form-control  form-control-edit" placeholder="Achievements">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn mt10 btn-primary closeModal">Done</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="add-interest col-md-12">
                        <form onsubmit="return false">
                            <div class="form-group">
                                <label for="interest-name" class="label-edit">Interests</label>
                                <ul class="tags skill_tag_list">
                                    <?php
                                    if (!empty($interests)) {
                                        foreach ($interests as $interest) { ?>
                                            <li class="addedTag"><?= $interest['interest'] ?>
                                                <span id="<?= $interest['user_interest_enc_id'] ?>"
                                                      class="interest_remove">x</span>
                                            </li>
                                        <?php }
                                    }
                                    ?>
                                    <li class="tagAdd taglist">
                                        <div class="skill_wrapper">
                                            <input type="text" id="interest_input"
                                                   class="interest_search input_search text-capitalize
                                                   form-control form-control-edit" placeholder="interest">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn mt10 btn-primary closeModal">Done</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="add-hobbies col-md-12">
                        <form onsubmit="return false">
                            <div class="form-group">
                                <label for="hobbies-name" class="label-edit">Hobbies</label>
                                <?php
                                Pjax::begin([
                                    'id' => 'pjax_hobby',
                                ]);
                                ?>
                                <ul class="tags skill_tag_list">
                                    <?php

                                    if (!empty($hobbies)) {
                                        foreach ($hobbies as $hobby) { ?>
                                            <li class="addedTag"><?= $hobby['hobby'] ?>
                                                <span id="<?= $hobby['user_hobby_enc_id'] ?>"
                                                      class="hobby_remove">x</span>
                                            </li>
                                        <?php }
                                    }
                                    ?>
                                    <li class="tagAdd taglist">
                                        <div class="skill_wrapper">
                                            <input type="text" id="hobby_input" class="hobby_search input_search text-capitalize
                                                   form-control form-control-edit"
                                                   placeholder="Hobbies">
                                        </div>
                                    </li>
                                </ul>
                                <?php
                                Pjax::end();
                                ?>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn mt10 btn-primary closeModal">Done</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Edit Modal end here-->
<?php
if (Yii::$app->user->identity->organization->organization_enc_id && !empty($userApplied)) {
    if (!empty($userApplied['applied_application_enc_id'])) {
        echo $this->render('@common/widgets/chat-main');
        $this->registerJs('
            $(".open_chat").trigger("click");
        ');
    }
}
$item_id = '';
$this->registerCss('
.edication_error{
    color: #df4759;
    text-align: center;
}
.text-left{
    text-align: left;
}
.tags {
    float: left;
    width: 100%;
    border: 2px solid #e8ecec;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    padding: 8px;
}
.tags > .addedTag {
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
    margin-right: 10px;
    margin-bottom:5px;
    position: relative;
}
.tags li {
    margin: 0;
}
.taglist {
    float: left !important;
}
.skill_wrapper,.language_wrapper{
    position:relative;
    border: 2px solid #ddd;
    border-radius: 10px;
}
.skill_wrapper .Typeahead-spinner,.language_wrapper .Typeahead-spinner{
    position: absolute;
    right: 5px;
    top: 13px;
    z-index: 9;
    display:none;
}
.posRel{
    position: relative;
}
.awesome-size h5 i, .side-btns i, .edit-profile-pen i{
    font-size:14px !important;
    cursor: pointer;
}
ul.old-skills, ul.old-languages, ul.old-interest, ul.old-achievements {
    border: 2px solid #eee;
    border-radius: 8px;
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
}
ul.old-skills input, ul.old-languages input, ul.old-interest input, ul.old-achievements input{
    width: 180px;
    height: 34px;
}
li.addedskills,
li.addedTag{
    background: #f4f5fa;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    display: inline-block;
    border-radius: 8px;
    font-family: Open Sans;
    font-size: 13px;
    padding: 6px 15px;
    margin: 0 10px 5px 0;
    position: relative;
}
span.tagRemove,
span.interest_remove,
span.achievement_remove,
span.hobby_remove{
    position: absolute;
    right: -6px;
    top: -5px;
    width: 16px;
    height: 16px;
    font-style: normal;
    background: #00a0e3;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    border-radius: 50%;
    color: #ffffff;
    text-align: center;
    line-height: 13px;
    font-size: 10px;
    font-family: Open Sans;
    cursor: pointer;
}
.form-textarea {
    padding: 8px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    height: 80px !important;
    max-height: 100px;
    width:100%;
    font-family: Roboto;
}
.control-check {
    display: block;
    position: relative;
    padding-left: 30px;
    margin-bottom: 15px;
    cursor: pointer;
    font-size: 14px;
    margin-top:20px;
}
.control-check input {
    position: absolute;
    z-index: -1;
    opacity: 0;
}
.control-check input:checked ~ .control__indicator {
    background: #2aa1c0;
}
.control__indicator {
    position: absolute;
    top: 12px;
    left: 0;
    height: 20px;
    width: 20px;
    background: #e6e6e6;
}
.control__indicator:after {
    content: "";
    position: absolute;
    display: none;
}
.control-check .control__indicator:after {
    left: 8px;
    top: 5px;
    width: 4px;
    height: 8px;
    border: solid #fff;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}
.control-check input:checked ~ .control__indicator:after {
    display: block;
}
.edit-detail {
    margin: 0;
    text-align: center;
    font-size: 20px;
    font-family: Roboto;
}
.label-edit{
    font-size: 15px;
    font-family:roboto;
    font-weight: 500 !important;
    margin-bottom:4px;
}
.form-control-edit {
    padding: 4px 8px;
    border: 1px solid #eee;
    border-radius: 8px;
    height: 40px;
    font-family: Roboto;
}
.modal {
  text-align: center;
}
.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
.end-modal {
    background-color: #00a0e3;
    overflow: hidden;
    position: absolute;
    right: -6px;
    top: -6px;
    padding: 5px 8px;
    opacity: 1;
    border-radius: 52px;
    font-size: 14px;
    color: #fff;
}
.end-modal:hover{
    opacity: 1;
    color:#fff;
}
.edit-profile-pen i {
    position: absolute;
    right: 12px;
    top: 12px;
    font-size: 17px;
}
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
.all-head{
    font-size: 18px;
    font-weight: 500;
    font-family: roboto;
    padding-bottom: 3px;
    letter-spacing: 1px;
    color:#000;
}
.education-head {
    font-size: 18px;
    font-weight: 500;
    font-family: roboto;
    padding-bottom: 3px;
    letter-spacing: 1px;
    color:#000;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.edu-add-btn {
    background-color: #00a0e3;
    color: #fff;
    font-size: 14px;
    padding: 8px 15px;
    border-radius: 4px;
}
.edu-add-btn:hover, .edu-add-btn:focus{
    color:#fff;
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
    position:relative;
}
.side-btns {
    position: absolute;
    right: 0px;
    top: 10px;
}
.side-btns i{margin-left:5px;}
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
    font-weight: 500;
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
.twitter-typeahead{
    width:100%;
    display: block
}
.typeahead {
  background-color: #fff;
//  margin-left: 15px !important; 
}
.typeahead:focus {
  border: 2px solid #0097cf;
}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}



.tt-hint {
  color: #999
}
.tt-menu {
  width: 100%;
  margin: 0;
  top:90% !important;
  padding: 8px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
          max-height:158px;
          overflow-y:auto;
}
.tt-suggestion {
  padding: 3px 20px;
  font-size: 14px;
  line-height: 24px;
}
.tt-suggestion:hover {
  cursor: pointer;
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
  color: #fff;
  background-color: #0097cf;
}
.tt-suggestion p {
  margin: 0;
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
.mt10{
    margin-top: 10px;
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
@media screen and (min-width: 768px) { 
  .modal:before {
    display: inline-block;
    vertical-align: middle;
    content: " ";
    height: 100%;
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
$stateId = $user['state_enc_id'];
$cityId = $user['city_enc_id'];
$script = <<< JS
var user_id = "$uId";
var global = [];
$("#update_exp_to, #update_exp_from, #to_date, #from_date" ).datepicker({
    autoclose: true,
    format: "yyyy-mm-dd",
    endDate: new Date(),
    fontAwesome: true
});

$.ajax({
        url: '/cities/get-cities-by-state',
        type: 'POST',
        data: {id: "$stateId",_csrf: $("meta[name=csrf-token]").attr("content")},
        success: function(response) {
            if (response.status == 200) {
                drp_down("cities_drp", response.cities);
                $("#cities_drp").trigger("chosen:updated");
                $("#cities_drp").val("$cityId");
            }
        },
});
    
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
$(document).on("click", ".edit-btnn", function (e){
    e.preventDefault();
    $('#exampleModalCenter').modal('show');
    $('.parent').children('div').hide();
    $('.'+$(this).attr("data-id")).show();
    var id = $(this).attr("id");
    var type = $(this).attr("data-type");
    if(type == 'education'){
        editEducation(id);
    }else if(type == 'experience'){
        editExperience(id);
    }else if(type == 'add-new-experience'){
        addNewExperience(e);
    }else if(type == 'add-new-education'){
        addNewEducation();
    }
});
function editEducation(id){
    $.ajax({
    url: '/account/resume-builder/edit-education',
    method : 'POST',
    data : {id:id},
    beforeSend:function(){
            $('.loader-aj-main').fadeIn(100);
         },
    success : function(res){   
        $('.loader-aj-main').fadeOut(50);
       var obj = JSON.parse(res);
       $('#institute').val(obj.institute);
       $('#degree').val(obj.degree);
       $('#field').val(obj.field);
       $('#from_date').val(obj.from_date);
       $('#to_date').val(obj.to_date);
       $('.eduUpdate').attr('id',obj.education_enc_id);
      $('.eduUpdate').attr('data-name', 'education');
    } 
    })
}
function editExperience(id){
    $.ajax({
        url: '/account/resume-builder/edit-experience',
         method : 'POST',
         data : {id:id},
          success : function(res)
          {
              var obj = JSON.parse(res);
              $('#update_exp_title').val(obj.title);
              $('#update_exp_company').val(obj.company);
              $('#update_city_id_exp').val(obj.city_enc_id);
              $('#update_exp_to').val(obj.to_date);
              $('#update_cities').val(obj.name);
              $('#update_exp_from').val(obj.from_date);
              $('#update_ctc').val((obj.ctc != null) ? parseInt(obj.ctc) : '');
              $('#update_salary').val((obj.salary != null) ? parseInt(obj.salary) : '');
              if(obj.is_current == 1){
                  $('#update_exp_present').prop('checked', true);
                  $('#update_exp_to').val(0);
                  $('.update_experience').hide();
              }else{
                   $('#update_exp_present').prop('checked', false);
                   $('.update_experience').show();
              }
              $('#update_description').val(obj.description );
              $('.expUpdate').attr('id',obj.experience_enc_id);
              $('.expUpdate').attr('data-name', 'experience');
          }
    });
}
$(document).on('click', '.updatedata', function(e){
    let btn = e.target;
    let fieldName = btn.getAttribute('data-name');
    let parentElem = btn.parentElement;
    let inputElems = parentElem.querySelectorAll('input, select, textarea');
    let id = btn.getAttribute('id');
    let id_name = btn.getAttribute('data-id');    
    let data = null;
    if(id){
        data = {...data, [id_name]: id}
    }
    for (let i = 0; i < inputElems.length; i++){
        let inputId = inputElems[i].getAttribute('data-name')
        let inputValue = inputElems[i].value
        data = {...data,  [inputId]: inputValue};
    }
    if(fieldName == 'education'){
        if(data['school'] == ''  || data['degree'] == '' || data['field'] == '' || data['from'] == '' || data['to'] == ''){
            document.querySelector('.education_error').innerText = 'All fields are required';
            return false;    
        }else{
            updateEducation(data);
        }
    }else if(fieldName == 'experience'){
        if(data['title'] == '' || data['company'] == '' || data['city'] == '' || data['from'] == '' || data['description'] == ''){
            document.querySelector('.experience_error').innerText = 'Please fill all required fields';
            return false;
        }else{
            updateExperience(data)
        }
    }else if(fieldName == 'add_new_experience'){
        add_new_exp(data);
    }else if(fieldName == 'add_new_education'){
        if(data['school'] == ''  || data['degree'] == '' || data['field'] == '' || data['from'] == '' || data['to'] == ''){
            document.querySelector('.education_error').innerText = 'All fields are required';
            return false;    
        }else{
            add_new_edu(data);
        }
    }else if(fieldName == 'basic-details' || fieldName == 'description'){
        sendData(data, fieldName);
    }
})
function updateEducation(data){
    const{degree, institute, to_date, from_date, education_enc_id, field} = data
   $.ajax({
       url: '/account/resume-builder/update-education',
       method : 'POST',
       data : {school:institute,degree:degree,field:field,from:from_date,to:to_date,id:education_enc_id},
       beforeSend:function(){     
                 $('.loader-aj-main').fadeIn(1000);
       },
       success : function(res)
       {
           $('.loader-aj-main').fadeOut(1000);
            if(res == true){
               $.pjax.reload({container: '#education_display', async: false});
               utilities.initials();
            }else{
                
            }
       } 
    });
}
$(document).on('click','.edu-del',function(e){
   e.preventDefault();
   
   var  id = $(this).attr('id');
   
   $.ajax({
        url: '/account/resume-builder/delete-education',
         method : 'POST',
         data : {id:id},
         beforeSend:function(){
            $('.loader-aj-main').fadeIn(100);
         },
          success : function(response)
          {
              $('.loader-aj-main').fadeOut(50);
              var res = JSON.parse(response);
              
              if(res.status == 200){
                  $.pjax.reload({container: '#education_display', async: false});
              }else if(res.status == 201){
                  toastr.error(res.message, res.title);
              }
              
          }
    });
});

function add_new_exp(data){
    let {city_enc_id, company, ctc, description, from_date, is_current, name, salary, title, to_date} = data;
     if($('#update_exp_present').prop("checked")){
        is_current = 1;
        $('#update_exp_to').val('');
        to_date = $('#update_exp_to').val();
    }else{
        is_current = 0;
        if($('#update_exp_to').val() == ''){
             return false;
        }else{
            to_date = $('#update_exp_to').val();
        }
    }
    $.ajax({
       url: '/account/resume-builder/experience',
       method: 'POST',
       data : {title:title, company:company, city:city_enc_id, from:from_date, to:to_date, checkbox:is_current,
        description:description, salary:salary, ctc:ctc},
       success : function(response){
           var res = JSON.parse(response);
           if(res.status == 200)
           {
               // $('#add-experience-modal').modal('toggle');
               $.pjax.reload({container: '#experience_display', async: false});
               utilities.initials();
                $('#exampleModalCenter').modal('hide');
               
           } else {
               toastr.error('something went wrong.Try Again', 'error');
           }
        }
    }); 
}
function addNewExperience(e){
    $('.expUpdate').attr('data-name', 'add_new_experience');
    $('#update_exp_title').val('');
    $('#update_exp_company').val('');
    $('#update_city_id_exp').val('');
    $('#update_cities').val('');
    $('#update_exp_from').val('');
    $('#update_exp_to').val('');
    $('#update_ctc').val('');
    $('#update_salary').val('');
    $('#update_description').val('');
    $('.update_experience').show();
}

function addNewEducation(){
       $('#institute').val('');
       $('#degree').val('');
       $('#field').val('');
       $('#from_date').val('');
       $('#to_date').val('');
      $('.eduUpdate').attr('data-name', 'add_new_education');
}
function add_new_edu(data){
    const{institute, degree, field, from_date, to_date} = data;
    
     $.ajax({
        url: '/account/resume-builder/education',
        method : 'POST',
  
        data : {AddQualificationForm: {school:institute, degree:degree, field:field, qualification_to:to_date, qualification_from:from_date}},
        success : function(res){
             if(res == true){
                $.pjax.reload({container: '#education_display', async: false});
                $('#exampleModalCenter').modal('hide');
            }else{
            }
        } 
    });
}
function updateExperience(data){
    let{city_enc_id, company, ctc, description, experience_enc_id, from_date, is_current, name, salary, title, to_date}=data
    
    ctc = ctc ? parseInt(ctc) : '';
    salary = salary ? parseInt(salary) : '';
    if($('#update_exp_present').prop("checked")){
        is_current = 1;
        $('#update_exp_to').val('');
        to_date = $('#update_exp_to').val();
    }else{
        is_current = 0;
        if($('#update_exp_to').val() == ''){
             return false;
        }else{
            to_date = $('#update_exp_to').val();
        }
    }
    $.ajax({
       url: '/account/resume-builder/update-experience',
       method: 'POST',
       data : {id:experience_enc_id, title:title, company:company, city:city_enc_id, from:from_date, 
        to:to_date, check:is_current, description:description, salary:salary, ctc:ctc},
       success : function(res){
            $.pjax.reload({container: '#experience_display', async: false});
            utilities.initials();
            $('#exampleModalCenter').modal('hide');
        }
    });
}
$(document).on('click','.exp-del',function(e){
   e.preventDefault();
   var  id = $(this).attr('data-id');
   $.ajax({
        url: '/account/resume-builder/delete-experience',
         method : 'POST',
         data : {id:id},
          success : function(response){
              var res = JSON.parse(response);
              if(res.status == 200){
                  $.pjax.reload({container: '#experience_display', async: false});
                  utilities.initials();
              }else if(res.status == 201){
                  toastr.error(res.message, res.title);
              }
              
          }
   });
});
$('#exp_present').click(function(){
    if (this.checked) {
        $(this).val('1');
        $('.experience').hide();
    }else{
        $(this).val('0');
        $('.experience').show();
        $('#addexperienceform-exp_to').val('');
    }
}) ;
    
$('#update_exp_present').click(function(){
    if (this.checked) {
        $(this).val('1');
        $('.update_experience').hide();
    }else{
        $(this).val('0');
        $('.update_experience').show();
        $('#update_exp_to').val('');
        $('#update_exp_to').focus();
    }
}) ;
$(document).on('keyup','#search-skill',function(e){
    if(e.which==13)
        {
          add_tags($(this),'skill_tag_list','skills');  
        }
});

function add_tags(thisObj,tag_class,name,duplicates){
    var duplicates = [];
    $.each($('.'+tag_class+' input[type=hidden]'),function(index,value)
        {
         duplicates.push($.trim($(this).val()).toUpperCase());
        });
    if(thisObj.val() == '' || jQuery.inArray($.trim(thisObj.val()).toUpperCase(), duplicates) != -1) {
        thisObj.val('');
            } else {
             $('<li class="addedTag">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();">x</span><input type="hidden" value="' + thisObj.val() + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
             thisObj.val('');
        }
} 
var skills = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/account/categories-list/skills-data',
    prepare: function (query, settings) {
             settings.url += '?q=' +$('#search-skill').val();
             return settings;
        },   
    cache: false,    
    filter: function(list) {
             return list;
        }
  }
});    
            
$('#search-skill').typeahead(null, {
  name: 'skill',
  display: 'value',
  source: skills,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
     $('.skill_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
     $('.skill_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      add_tags($(this),'skill_tag_list','skills');
   }).blur(validateSelection);

function validateSelection() {
  var theIndex = -1;
  for (var i = 0; i < global.length; i++) {
      if (global[i].value == $(this).val()) {
      theIndex = i; 
      break;
    }
  }
    if (theIndex == -1) {
       $(this).val(""); 
       global = [];
    }
}
$(document).on('keyup','#search-language',function(e){
    if(e.which==13)
        {
          add_tags($(this),'languages_tag_list','languages');
        }
});
var languages = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
   remote: {
    url:'/account/categories-list/languages',
    prepare: function (query, settings) {
             settings.url += '?q=' +$('#search-language').val();
             return settings;
        },   
    cache: false,    
    filter: function(list) {
             return list;
        }
  }
});    

$('#search-language').typeahead(null, {
  name: 'languages',
  display: 'value',
  source: languages,
   limit: 6,
}).on('typeahead:asyncrequest', function() {
    $('.language_wrapper .Typeahead-spinner').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
   $('.language_wrapper .Typeahead-spinner').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      add_tags($(this),'languages_tag_list','languages');
   }).blur(validateSelection);

$(document).on('click', '.updateSkills', function (e){
    let btn = e.target;
    let parentElem = btn.parentElement;
    let fieldName = btn.getAttribute('data-name');
    let val = {}
    let skills = [];
    $('input[name="'+fieldName+'[]"]').each(function() {
        skills.push(this.value);
    });
    val[fieldName] = skills;
    sendData(val, fieldName);
})
$(document).on('change','#states_drp',function() {
   $("#cities_drp").empty().append($("<option>", { 
         value: "",
         text : "Select City" 
     }));
   $.ajax({
        url: '/cities/get-cities-by-state',
        type: 'POST',
        data: {id: $(this).val(),_csrf: $("meta[name=csrf-token]").attr("content")},
        success: function(response) {
            if (response.status == 200) {
                drp_down("cities_drp", response.cities);
                $("#cities_drp").trigger("chosen:updated");
            }
        },
    });
})
function drp_down(id, data) {
    var selectbox = $('#' + id + '');
    $.each(data, function () {
        selectbox.append($('<option>', {
            value: this.id,
            text: this.name
        }));
    });
}

$(document).on('keyup','#achievement_input',function(e){   
    e.preventDefault();
    if(e.which==13){
        var achievement_name = $('#achievement_input').val();
        if(achievement_name == ''){
            toastr.error('please enter something', 'error');
        }else {
            var last_child = $(this).parentsUntil('.tagAdd').parent().prev('.addedTag');
            var new_tag = '<li class="addedTag">'+ achievement_name +'<span class="tagRemove">x</span></li>';
            $(new_tag).insertAfter(last_child);
            $('#achievement_input').val('');
             $.ajax({
                url: '/account/resume-builder/achievements',
                method : 'POST',
                data : {achievement_name:achievement_name},
                success : function(response)
                {
                     var res = JSON.parse(response);
                     $.pjax.reload({container: '#pjax_achievements', async: false});
                     if(res.status == 201){
                         toastr.error(res.message, res.title);
                     }
                     else if(res.status == 203){
                         toastr.error(res.message, res.title);
                     }
                } 
            });
          }
        }
});
$(document).on('click','.achievement_remove', function(e) {
    e.preventDefault();
    var tag_main = $(this).parent();
    tag_main.hide();
        var id = e.target.id;
    $.ajax({
        url: "/account/resume-builder/achievement-remove",
        method: "POST",
        data: {id:id},
       
        success: function (response) {
            var data = JSON.parse(response);
            if(data.status == 200){
                $.pjax.reload({container: '#pjax_achievements', async: false});
            }else{
                tag_main.show();
                toastr.error(data.message, data.title);
            }
        }
    });
});
        
$(document).on('keyup','#hobby_input',function(e){   
    e.preventDefault();
    if(e.which==13){
    var hobby_name = $('#hobby_input').val();
    if(hobby_name == ''){
        toastr.error('please enter something', 'error');
    }else {     
        var last_child = $(this).parentsUntil('.tagAdd').parent().prev('.addedTag');
        var new_tag = '<li class="addedTag">'+ hobby_name +'<span class="hobby_remove">x</span></li>';
        $(new_tag).insertAfter(last_child);
        $('#hobby_input').val('');
        $.ajax({
            url: '/account/resume-builder/hobbies',
            method : 'POST',
            data : {hobby_name:hobby_name},
            success : function(response)
            {
                 var res = JSON.parse(response);
                 $.pjax.reload({container: '#pjax_hobby', async: false});
                 if(res.status == 201){
                     toastr.error(res.message, res.title);
                 }
                 else if(res.status == 203){
                     toastr.error(res.message, res.title);
                 }
                 
            } 
        });
      }
    }
});
$(document).on('click','.hobby_remove', function(e) {
    e.preventDefault();
    var tag_main = $(this).parent();
    tag_main.hide();
        var id = e.target.id;
    $.ajax({
        url: "/account/resume-builder/hobby-remove",
        method: "POST",
        data: {id:id},
       
        success: function (response) {
            var data = JSON.parse(response);
            if(data.status == 200){
                $.pjax.reload({container: '#pjax_hobby', async: false});              
            }else{
                tag_main.show();
                toastr.error(data.message, data.title);
            }
        }
    });
});

$(document).on('keyup','#interest_input',function(e){   
    e.preventDefault();
    if(e.which==13){
    var interest_name = $('#interest_input').val();
        if(interest_name == ''){
            toastr.error('please enter something', 'error');
        }else {
            var last_child = $(this).parentsUntil('.tagAdd').parent().prev('.addedTag');
            var new_tag = '<li class="addedTag">'+ interest_name +'<span class="interest_remove">x</span></li>';
            $(new_tag).insertAfter(last_child);
            $('#interest_input').val('');
            $.ajax({
                url: '/account/resume-builder/interests',
                method : 'POST',
                data : {interest_name:interest_name},
                success : function(response)
                {
                     var res = JSON.parse(response);
                     $.pjax.reload({container: '#pjax_interest', async: false});
                     if(res.status == 201){
                         toastr.error(res.message, res.title);
                     }
                     else if(res.status == 203){
                         toastr.error(res.message, res.title);
                     }
                     
                } 
            });
        }
    }   
});
$(document).on('click','.interest_remove', function(e) {
    e.preventDefault();
    var tag_main = $(this).parent();
    tag_main.hide();
        var id = e.target.id;
    $.ajax({
        url: "/account/resume-builder/interest-remove",
        method: "POST",
        data: {id:id},
        
        success: function (response) {
            var data = JSON.parse(response);
            if(data.status == 200){
                $.pjax.reload({container: '#pjax_interest', async: false});
            }else{
                tag_main.show();
                toastr.error(data.message, data.title);
            }
        }
    });
});

sendData = (data, fieldName) => {
    $.ajax({
        url: '/users/update-basic-detail',
        method: 'POST',
        data: data,
        success: function(response){
            if(response['status'] == 'success'){
                let sectionReload = '#'+fieldName+'_display';
                if (fieldName == 'basic-details'){
                    $.pjax.reload({container: '#userbasicDetails', async: false});
                }else if(fieldName == 'description'){
                    $.pjax.reload({container:'#user_description', async: false})
                }else{
                    $.pjax.reload({container: sectionReload, async: false});
                }
                $('#exampleModalCenter').modal('hide');
            }
        }
    })
}

$(document).on('click', '.closeModal', function (){
  $('#exampleModalCenter').modal('hide');
})
var city = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/account/cities/city-list?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(list) {
            global = list;
             return list;
        }
  }
});

$('#update_cities').typeahead(null, {
  name: 'cities',
  highlight: true,       
  display: 'text',
  source: city,
   limit: 15,
   hint:false,
}).on('typeahead:asyncrequest', function() {
    $('.city-spin').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    
    $('.city-spin').hide();
  }).on('typeahead:selected typeahead:completed',function(e,datum)
      {
        $('#update_city_id_exp').val(datum.id);
     });

var org = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: '',
  remote: {
    url:'/account/resume-builder/organizations?q=%QUERY',  
    wildcard: '%QUERY',
    filter: function(org) {
             return org;
        }
  }
});

JS;
$this->registerJs($script);
$this->registerCssFile("/assets/themes/jobhunt/css/chosen.css");
$this->registerCssFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

//$this->registerJsFile('@eyAssets/js/homepage_slider/select-chosen.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
