<?php
$separator = Yii::$app->params->seo_settings->title_separator;
$this->title = Yii::t('frontend', $data['cat_name'] . ' ' . $separator . ' ' . $data['name'] . ' ' . $separator . ' ' . $data['industry'] . ' ' . $separator . ' ' . $data['designation'] . ' ' . $separator . ' ' . $org['org_name']);
$this->params['header_dark'] = false;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
if (!Yii::$app->user->isGuest) {
    $user_id = Yii::$app->user->identity->user_enc_id;
}
if (!empty($data['applicationPlacementLocations'])) {
    $location = ArrayHelper::map($data['applicationPlacementLocations'], 'city_enc_id', 'name');
    $total_vac = 0;
    $str = "";
    $locations = [];
    foreach ($data['applicationPlacementLocations'] as $placements) {
        $total_vac += $placements['positions'];
        array_push($locations, $placements['name']);
    }
    $str = implode(", ", $locations);
}
$applied_data = ['app_number' => $data['application_number'], 'app_enc_id' => $data['application_enc_id']];
$application_object = json_encode($applied_data);

$cover_image = Yii::$app->params->upload_directories->organizations->cover_image . $org['cover_image_location'] . DIRECTORY_SEPARATOR . $org['cover_image'];
$cover_image_base_path = Yii::$app->params->upload_directories->organizations->cover_image_path . $cover_location . DIRECTORY_SEPARATOR . $cover;
if (empty($org['cover_image'])) {
    $cover_image = "@eyAssets/images/backgrounds/default_cover.png";
}
$logo_image = Yii::$app->params->upload_directories->organizations->logo . $org['logo_location'] . DIRECTORY_SEPARATOR . $org['logo'];
?>

    <div class="modal fade bs-modal-lg in" id="modal_que" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><?= Yii::t('frontend', 'Fill Out The Questionnaire'); ?></h4>
                </div>
                <div class="modal-body">
                    <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>"
                         alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                    <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-modal-lg in" id="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Fill Out The Details</h4>
                </div>
                <div class="modal-body">
                    <?php $form = ActiveForm::begin(['id' => 'resume_form']) ?>
                    <?php if (!empty($location)) {
                        echo $form->field($model, 'location_pref')->inline()->checkBoxList($location)->label('Select Placement Location');
                    } ?>
                    <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput(['id' => 'application_id', 'value' => $data['application_enc_id']]); ?>
                    <?php
                    if ($que > 0) {

                        $ques = 1;
                    } else {

                        $ques = 0;
                    }
                    ?>
                    <?= $form->field($model, 'questionnaire_id', ['template' => '{input}'])->hiddenInput(['id' => 'question_id', 'value' => $ques]); ?>
                    <?php
                    if ($resume) {
                        $checkList = [0 => 'Use Existing One', 1 => 'Upload New'];
                    } else {
                        $checkList = [1 => 'Upload New'];
                    }
                    ?>
                    <?= $form->field($model, 'check')->inline()->radioList($checkList)->label('Upload Resume') ?>

                    <div id="new_resume">
                        <?= $form->field($model, 'resume_file')->fileInput(['id' => 'resume_file'])->label('Upload Your CV In Doc, Docx,Pdf Format Only'); ?>
                    </div>
                    <?php if ($resume) { ?>
                        <div id="use_existing">
                            <div class="row">
                                <label id="warn" class="col-md-offset-1 col-md-3">Select One</label>
                                <?php foreach ($resume as $res) {
                                    ?>
                                    <div class="col-md-offset-1 col-md-10">
                                        <div class="radio_questions">
                                            <div class="inputGroup">
                                                <input id="<?= $res['resume_enc_id']; ?>" name="JobApplied[resume_list]"
                                                       type="radio" value="<?= $res['resume_enc_id']; ?>"/>
                                                <label for="<?= $res['resume_enc_id']; ?>"> <?= $res['title']; ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <div class="modal-footer">
                    <?= Html::submitbutton('Save', ['class' => 'btn btn-primary sav_job']); ?>
                    <?= Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
    <section class="overlape">
        <!--<div class="block no-padding">-->
        <div data-velocity="-.1"
             style="background: url('<?= Url::to($cover_image); ?>') repeat scroll 50% 422.28px transparent;background-size: 100% 100% !important;background-repeat: no-repeat;"
             class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
        <!--<div class="container fluid">-->
        <div class="row m-0">
            <div class="col-lg-12 p-0">
                <div class="inner-header">
                    <h3><?= $data['cat_name']; ?></h3>
                    <div class="job-statistic">
                        <?php
                        if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->organization) {
                            if (!empty($shortlist) && $shortlist['shortlisted'] == 1) {
                                ?>
                                <span class="hover-change col_pink"><a href="#" class="shortlist_job"><i
                                                class="fa fa-heart-o"></i> Shortlisted</a></span>
                                <?php
                            } else {
                                ?>
                                <span class="hover-change"><a href="#" class="shortlist_job"><i
                                                class="fa fa-heart-o"></i> Shortlist</a></span>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!--</div>-->
        <!--</div>-->
    </section>
    <section>
        <!--<div class="block">-->
        <div class="container">
            <div class="row m-0">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="job-single-sec">
                        <div class="job-single-head2">
                            <div class="job-overview">
                                <h3>Internship Overview</h3>
                                <?php
                                switch ($data['has_placement_offer']) {
                                    case 1;
                                        $offer = 'Yes';
                                        break;
                                    case 2;
                                        $offer = 'No';
                                        break;
                                }
                                ?>
                                <ul>
                                    <li><i class="fa fa-puzzle-piece"></i>
                                        <h3>Profile</h3><span><?= $data['name']; ?></span></li>
                                    <li><i class="fa fa-puzzle-piece"></i>
                                        <h3>Stipend Type <?= '(' . $data['wage_duration'] . ')'; ?></h3>
                                        <span><?= $data['wage_type']; ?></span></li>
                                    <li><i class="fa fa-gift"></i>
                                        <h3>Preplacement Offer</h3><span><?= $offer; ?></span></li>
                                    <?php setlocale(LC_MONETARY, 'en_IN'); ?>
                                    <li><i class="fa fa-money"></i>
                                        <h3>Maximum Stipend</h3>
                                        <span><?= (($data['max_wage']) ? '&#8377 ' . utf8_encode(money_format('%!.0n', $data['max_wage'])) : 'N/A'); ?></span>
                                    </li>
                                    <li><i class="fa fa-money"></i>
                                        <h3>Minimum stipend</h3>
                                        <span><?= (($data['min_wage']) ? '&#8377 ' . utf8_encode(money_format('%!.0n', $data['min_wage'])) : 'N/A'); ?></span>
                                    </li>
                                    <li><i class="fa fa-mars-double"></i>
                                        <h3>Gender</h3><span><?php
                                            switch ($data['preferred_gender']) {
                                                case 0:
                                                    echo 'No Preference';
                                                    break;
                                                case 1:
                                                    echo 'Male';
                                                    break;
                                                case 2:
                                                    echo 'Female';
                                                    break;
                                                case 3:
                                                    echo 'Trans';
                                                    break;
                                                default:
                                                    echo 'not found';
                                            }
                                            ?></span></li>
                                    <li><i class="fa fa-money"></i>
                                        <h3>Fixed Stipend</h3>
                                        <span><?= (($data['fixed_wage']) ? '&#8377 ' . utf8_encode(money_format('%!.0n', $data['fixed_wage'])) : 'N/A') ?></span>
                                    </li>
                                    <li><i class="fa fa-line-chart "></i>
                                        <h3>Total Vacancies</h3>
                                        <span><?= (($total_vac) ? $total_vac : 'Not Applicable'); ?></span></li>
                                    <li><i class="fa fa-map-marker "></i>
                                        <h3>Locations</h3>
                                        <span> <?= (($str) ? rtrim($str, ',') : 'Work From Home'); ?></span></li>
                                </ul>
                            </div><!-- Job Overview -->
                        </div><!-- Job Head -->

                        <div class="job-details">
                            <h3>Employer Benefits</h3>
                            <?php
                            $rows = ceil(count($data['applicationEmployeeBenefits']) / 3);
                            $next = 0;
                            for ($i = 0; $i < $rows; $i++) {
                                ?>
                                <div class="cat-sec">
                                    <div class="row no-gape">
                                        <?php
                                        for ($j = 0; $j < 3; $j++) {
                                            if(!empty($data['applicationEmployeeBenefits'][$next]['benefit'])){
                                                ?>
                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="p-category">
                                                        <div class="p-category-view">
                                                            <?php
                                                            if(!empty($data['applicationEmployeeBenefits'][$next]['icon'])){
                                                                $benefit_icon = '/assets/icons/' . $data['applicationEmployeeBenefits'][$next]['icon_location'] . DIRECTORY_SEPARATOR . $data['applicationEmployeeBenefits'][$next]['icon'];
                                                            } else{
                                                                $benefit_icon = '/assets/common/employee_benefits/plus-icon.svg';
                                                            }
                                                            ?>
                                                            <img src="<?= Url::to($benefit_icon); ?>" />
                                                            <span><?= $data['applicationEmployeeBenefits'][$next]['benefit'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            $next++;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <h3 class="mt-30">Required Knowledge, Skills, and Abilities</h3>
                            <div class="tags-bar">
                                <?php foreach ($data['applicationSkills'] as $job_skill) { ?>
                                    <span><?= strtoupper($job_skill['skill']); ?> </span>
                                <?php } ?>
                            </div>
                            <h3>Job Description</h3>
                            <ul>
                                <?php
                                foreach ($data['applicationJobDescriptions'] as $job_desc) {
                                    ?>
                                    <li> <?php echo ucwords($job_desc['job_description']); ?> </li>

                                <?php }
                                ?>
                            </ul>
                            <?php if (!empty($data['description'])) {
                                ?>
                                <h3>Other Details</h3>
                                <p><?= $data['description']; ?></p>
                            <?php } ?>


                            <h3>Education</h3>
                            <ul>
                                <?php
                                foreach ($data['applicationEducationalRequirements'] as $qualification) {
                                    ?>
                                    <li> <?php echo ucwords($qualification['educational_requirement']); ?> </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="job-overview">
                            <h3>Interview Details</h3>
                            <ul style="border:0px;">
                                <?php if (!empty($data['interview_start_date']) && $data['interview_end_date']) { ?>
                                    <li><i class="fa fa-calendar-check-o"></i>
                                        <h3>Interview Dates</h3>
                                        <span><?= date('d-M-y', strtotime($data['interview_start_date'])); ?> To <?= date('d-M-y', strtotime($data['interview_end_date'])); ?></span>
                                    </li>
                                    <li><i class="fa fa-clock-o"></i>
                                        <h3>Interview Time</h3>
                                        <span><?= date('H:i A', strtotime($data['interview_start_date'])); ?> To <?= date('H:i A', strtotime($data['interview_end_date'])); ?></span>
                                    </li>
                                <?php } ?>
                                <li><i class="fa fa-map-marker"></i>
                                    <h3>Interview Locations</h3><span> <?php
                                        if (!empty($data['applicationInterviewLocations']))
                                        {
                                            $str2 = "";
                                            $interview_locations = [];
                                            foreach ($data['applicationInterviewLocations'] as $loc) {
                                                array_push($interview_locations, $loc['name']);
                                            }
                                            $str2 = implode(", ", $interview_locations);
                                            echo rtrim($str2, ',');
                                        }
                                        else
                                        {
                                            echo 'Online/Skype/Telephonic';
                                        }
                                        ?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="job-single-head style2">
                        <div class="job-thumb">
                            <a href="/company/<?= $org['slug']; ?>">
                                <?php
                                if (!empty($org['logo'])) {
                                    ?>
                                    <img src="<?= Url::to($logo_image); ?>" id="logo_img" alt=""/>
                                    <?php
                                } else {
                                    ?>
                                    <canvas class="user-icon" name="<?= $org['org_name']; ?>" width="125" height="125"
                                            color="" font="55px"></canvas>
                                    <?php
                                }
                                ?>
                            </a>
                        </div>
                        <div class="job-head-info">
                            <a href="/company/<?= $org['slug']; ?>"><h4><?= $org['org_name']; ?></h4></a>
                            <?php if ($org['website']): ?>
                                <p><i class="fa fa-unlink"></i><?= $org['website']; ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if (Yii::$app->user->isGuest): ?>
                            <a href="<?= Url::to('/login'); ?>" class="apply-job-btn"><i class="fa fa-paper-plane"></i>Login
                                to apply</a>
                        <?php else: ?>
                            <?php if ($applied): ?>
                                <a href="#" title="" class="apply-job-btn apply-btn" disabled="disabled"><i
                                            class="fa fa-check"></i>Applied</a>
                            <?php elseif (!Yii::$app->user->identity->organization): ?>
                                <a href="#" class="apply-job-btn apply-btn"><i class="fa fa-paper-plane"></i>Apply for
                                    Internship</a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <a href="<?= Url::to('/internships/list'); ?>" title="" class="viewall-jobs">View all
                            Internships</a>
                        <div class="share-bar no-border">
                            <?php $link = Url::to('internship/' . $application_details["slug"], true); ?>
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
                    </div><!-- Job Head -->
                </div>
            </div>
        </div>
        <!--</div>-->
    </section>
    <div id="message_img">
        <span id='close_btn'><i class="fa fa-times"></i></span>
        <div id="msg">
            <img src="https://i.ibb.co/TmV51CY/done.png">
            <h1 class="heading_submit">Submitted!</h1>
            <p class="sub_description_1">Your Application Has been successfully registerd with the requiter. keep check
                your Dashboard Regularly for further confirmation from the Requiter side.</p>
            <p class="sub_description_2">Your Application Has been successfully registerd But There Are Some
                Questionnaire Pending From Your Side you can fill them now By clicking <a
                        href="<?= URL::to('/account/dashboard') ?>" target="_blank">Here</a> Or You can fill them Later.
                <br><b>Please Note:</b>Your Application Would not be process further if your didn't fill them!</p>

        </div>
    </div>
    <div class="fader"></div>
    <script>
        function copyToClipboard() {
            var copyText = document.getElementById("share_manually");
            copyText.select();
            document.execCommand("copy");
            toastr.success("", "Copied");
            // alert("Copied the text: " + copyText.value);
        }
    </script>
<?php
$this->registerCss("
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
    #message_img{
      display:none;
    }
    
    #message_img.show{
        display : block;
        position : fixed;
        z-index: 100;
        background-color:#33cdbb;
        opacity : 1;
        background-repeat : no-repeat;
        background-position : center;
        width:60%;
        height:60%;
        left : 20%;
        bottom : 0;
        right : 0;
        top : 20%;
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
        width: 124px;
        height: 124px; 
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
    .inner-header::before {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        content: '';
        z-index: -1;
        background: #00000078;
        opacity: 0.8;
    }
    .inner-header::after {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        content: '';
        z-index: 0;
        opacity: 0.14;
    }
    .inner-header {
        float: left;
        width: 100%;
        position: relative;
        padding-top: 240px; padding-bottom: 15px;
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
        float: left;
        width: 100%;
        position: relative;
        z-index: 1;
        color: #ffffff;
        font-weight: bold;
        font-size: 30px;
        text-align: center;
        margin: 0;
        margin-bottom: 50px;
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
        font-size: 12px;
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
//        padding-top: 20px;
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
        float: left;
        width: 100%;
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
        -webkit-box-shadow: 0px 0px 20px 7px #ddd;
        -moz-box-shadow: 0px 0px 20px 7px #ddd;
        -ms-box-shadow: 0px 0px 20px 7px #ddd;
        -o-box-shadow: 0px 0px 20px 7px #ddd;
        box-shadow: 0px 0px 20px 7px #ddd;
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
        text-align: center;
        margin: 0;
        margin-top: 0px;
        margin-top: 5px;
    }
    .job-single-head.style2 .job-head-info p i {
        float: none;
        color: #4aa1e3;
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
        color: #202020;
        margin: 0;
        margin-bottom: 0px;
        margin-bottom: 10px;
    }
    .job-head-info span {
        float: left;
        width: 100%;
        font-size: 13px;
        color: #888888;
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
        font-size: 21px;
        line-height: 27px;
        margin-right: 9px;
    }
    .apply-job-btn {
        background: #ffffff;
        -webkit-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
        -moz-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
        -ms-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
        -o-box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
        box-shadow: 0px 0px 20px rgba(0,0,0,0.18);
        -webkit-border-radius: 40px;
        -moz-border-radius: 40px;
        -ms-border-radius: 40px;
        -o-border-radius: 40px;
        border-radius: 40px;
        font-family: Open Sans;
        font-size: 13px;
        color: #ef7706;
        width: 200px;
        height: auto;
        padding: 15px 15px;
        text-align: center;
        margin:auto;
    }
    .apply-job-btn:hover {
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        -ms-border-radius: 8px;
        -o-border-radius: 8px;
        border-radius: 8px;
        color: #ef7706 !important;
    }
    .apply-job-btn i {
        float: none;
        font-size: 25px;
        margin-right: 10px;
        line-height: 8px;
        position: relative;
        top: 4px;
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
        margin-bottom:5px;
        position: relative;
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
        margin-bottom: 20px;
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
        top: 0;
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
        width: 80px;
        height: 50px;
    }
    .p-category .p-category-view img, .p-category .checkbox-text span i {
        color: #4aa1e3;
        font-size: 70px;
        margin-top: 30px;
        line-height: initial !important;
    }
    /* Feature, categories css ends */
    ");

$script = <<< JS
$(document).on('click','.shortlist_job',function(e)
    {
         e.preventDefault();
         var app_id = $('#application_id').val();
         $.ajax({
                    url:'/account/jobs/shortlist-job',
                    data: {app_id:app_id},                         
                    method: 'post',
                 beforeSend:function()
                 {
                  $('.shortlist_job').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                 },     
                 success:function(data)
                 {  
                    if(data=='short'){
                    $('.shortlist_job').html('<i class="fa fa-heart-o"></i> Shortlisted');
                    $('.hover-change').addClass('col_pink');
                    }
                      
                    else if(data=='unshort'){
                    $('.shortlist_job').html('<i class="fa fa-heart-o"></i> Shortlist');
                    $('.hover-change').removeClass('col_pink');
                    }
                 }
                    
                    });        
    });        
   
        $(document).on('click','.apply-btn',function(e)
            {
             e.preventDefault();
             if($('.apply-btn').attr("disabled") == "disabled")
            {
               return false;
            }
         $('#modal').modal('show'); 
         });
   
   $('input[name="JobApplied[check]"]').on('change',function()
       {
        if($(this).val() == 1)
        {
          $('#use_existing').css('display','none');
          $('#new_resume').css('display','block');
        }
        else if($(this).val() == 0)
        {
           $('#resume_form').yiiActiveForm('validate',false);
            $('#new_resume').css('display','none');
            $('#use_existing').css('display','block');
            
        }
        });
        
         var que_id = $('#question_id').val();
         var fill_que = $('#fill_question').val();
        
        $(document).on('click','.sav_job',function(e)
            {
                e.preventDefault();
               if($('input[name="JobApplied[location_pref][]"]:checked').length <= 0)
               {
                $('#resume_form').yiiActiveForm('validateAttribute', 'jobapplied-location_pref');
                   return false;
                }
               if($('input[name="JobApplied[check]"]:checked').length > 0){
                if($('input[name="JobApplied[check]"]:checked').val() == 0)
                {
                    if($('input[name="JobApplied[resume_list]"]:checked').length == 0)
                    {
                     $('#warn').css('display','block');
                     $('input[name="JobApplied[check]"]').focus();
                     return false;   
                    }
                    else if ($('input[name="JobApplied[resume_list]"]:checked').length > 0)
                    {
                      var formData = new FormData();
                      var id = $('#application_id').val();
                      var check = 1;
                       var loc_array = [];
                       $("input[name='JobApplied[location_pref][]']:checked").each(function(){
                        loc_array.push($(this).val()); 
                        });
                      var resume_enc_id = $('input[name="JobApplied[resume_list]"]').val();
                      formData.append('application_enc_id',id);
                      formData.append('resume_enc_id',resume_enc_id);
                      formData.append('fill_que',fill_que);
                      formData.append('check',check);
                      if($('#question_id').val() == 1)
                        {
                          var status = 'incomplete';
                          formData.append('status',status);
                        }
                      else
                        {
                          var status = 'Pending';
                          formData.append('status',status);
                        }
                      var json_loc = JSON.stringify(loc_array);
                      formData.append('json_loc',json_loc);
                      ajax_call(formData);
                      $('#warn').css('display','none');
                    }
                 }
         else if($('input[name="JobApplied[check]"]:checked').val()==1)
          {     
                if($('#resume_file').val() != '') {            
                 $.each($('#resume_file').prop("files"), function(k,v){
                 var filename = v['name'];    
                 var ext = filename.split('.').pop().toLowerCase();
                if($.inArray(ext, ['pdf','doc','docx']) == -1) {
                return false;
              }
          else
        {
            var formData = new FormData();
             var loc_array = [];
                       $("input[name='JobApplied[location_pref][]']:checked").each(function(){
                        loc_array.push($(this).val()); 
                        });
            var formData = new FormData($('form')[0]);
                 var id = $('#application_id').val();
                 if($('#question_id').val() == 1)
                        {
                          var status = 'incomplete';
                          formData.append('status',status);
                        }
                    else
                        {
                          var status = 'Pending';
                          formData.append('status',status);
                        }
                formData.append('id',id);
                var json_loc = JSON.stringify(loc_array);
                formData.append('json_loc',json_loc);
                ajax_call(formData);
              }
            });      
            }
            }
           }
          else
         {
         $('#resume_form').yiiActiveForm('validateAttribute', 'jobapplied-check');
         return false;
            }
            });
        
        function ajax_call(formData)
        {
            $.ajax({
                    url:'/account/jobs/jobs-apply',
                    dataType: 'text',  
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,                         
                    type: 'post',
                 beforeSend:function()
                 {
                 $('.sav_job').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                 },     
                 success:function(data)
                 {
            var res = JSON.parse(data);
            if(res.status == true && $('#question_id').val() == 1){
                        applied();
                        $('.sub_description_2').css('display','block');
                        $('.sub_description_1').css('display','none');
                        $('#message_img').addClass('show');
                        $('.fader').css('display','block');
                     }
                    else if(res.status == true)
                      {
                        $('.sub_description_1').css('display','block');
                        $('.sub_description_2').css('display','none');
                        $('#message_img').addClass('show');
                        $('.fader').css('display','block');
                        applied();
                      }
                      else
                         {
                           alert('something went wrong..');
                         }
                      }
                    });
                    }
  
    function applied()
        {
             $('#modal').modal('toggle');
                     $('.apply-btn').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
                     $('.apply-btn').html('<i class = "fa fa-check"></i>Applied');
                     $('.apply-btn').attr("disabled","true");
            }

 $(document).on('click','#close_btn',function()
 {
    $('.fader').css('display','none');
    $(this).parent().removeClass('show');

})          
JS;
$this->registerJs($script);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);