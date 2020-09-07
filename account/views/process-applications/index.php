<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
$base_url = 'https://empoweryouth.com';
switch($application_name['application_type']){
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
        }
?>
    <div class="container">
        <div class="row">
            <div class="job-det col-md-12 row">
                <div class="col-md-4 col-sm-12">
                    <div class="j-main">
                        <div class="j-logo">
                           <?php if($application_name['icon']){ ?>
                            <img src="<?= Url::to('@commonAssets/categories/' .$application_name['icon']); ?>">
                        <?php } ?>
                        </div>
                        <div class="j-data">
                            <div class="j-title"><?= $application_name['job_title'] ?></div>
                            <div class="j-app"><?php
                                if(!empty($application_name['applicationPlacementLocations'])){
                                foreach($application_name['applicationPlacementLocations'] as $apl){
                                    if($apl['positions'] <= 1){
                                    echo $apl['positions'].' Opening';
                                    } else {
                                        echo $apl['positions'].' Openings';
                                    }
                                } } ?> </div>
                            <div class="j-share">
                                <span class="wts"><a href="" onclick="window.open('<?= Url::to('https://api.whatsapp.com/send?text='.$base_url.'/'.$app_type.'/'.$application_name['slug']); ?>', '_blank', 'width=800,height=400,left=200,top=100');"><i class="fa fa-whatsapp"></i></a></span>
                                <span class="twt"><a href="" onclick="window.open('<?= Url::to('https://twitter.com/intent/tweet?text='.$base_url.'/'.$app_type.'/'.$application_name['slug']); ?>', '_blank', 'width=800,height=400,left=200,top=100');"<i class="fa fa-twitter"></i></a></span>
                                <span class="mail"><a href="" onclick="window.open('<?= Url::to('mailto:?&body='.$base_url.'/'.$app_type.'/'.$application_name['slug']); ?>', '_blank', 'width=800,height=400,left=200,top=100');"<i class="fa fa-envelope"></i></a></span>
                                <span class="link"><a href="" onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url='.$base_url.'/'.$app_type.'/'.$application_name['slug']); ?>', '_blank', 'width=800,height=400,left=200,top=100');"<i class="fa fa-linkedin"></i></a></span>
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
                                <p><?php
                                    if($application_name['applicationPlacementLocations']){
                                    foreach($application_name['applicationPlacementLocations'] as $apl){
                                    echo $apl['name'].',';
                                    } } ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="j-detail">
                        <div class="j-exp salry">
                            <div class="e-logo"><i class="fa fa-money"></i></div>
                            <div class="e-detail">
                                <h1>Offered Salary</h1>
                                <p><?= $amount ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="ed-main">
                        <div class="option-1">
                            <span class="j-edt">
                                <a href="/account/<?= strtolower($application_name['application_type']).'/'.$application_id ?>/edit" target="_blank" data-toggle="tooltip" title="" data-original-title="Edit <?= $app_type ?>"><i class="fa fa-pencil-square-o"></i></a>
                            </span>
                                <span class="j-cln">
                                <a href="/account/<?= strtolower($application_name['application_type']).'/'.$application_id ?>/clone" target="_blank" data-toggle="tooltip" title="" data-original-title="Clone <?= $app_type ?>"><i class="fa fa-clone"></i></a>
                            </span>
                                <span class="j-delt">
                                <a href="#" id="j-delete" data-toggle="tooltip"
                                   title="Delete <?= $app_type ?>" value="<?= $application_id ?>" ><i class="fa fa-trash-o"></i></a>
                            </span>
                                <span class="j-cls">
                                <a href="#" id="j-closed" data-toggle="tooltip"
                                   title="Close <?= $app_type ?>" data-name="<?= $app_type ?>" value="<?= $application_id ?>" ><i class="fa fa-times"></i></a>
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
        <ul class="nav nav-tabs pr-process-tab">
            <li class="active"
                style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 2; ?>)">
                <a data-filter="*" href="#">All</a>
            </li>
            <?php
            $k = 0;
            foreach ($application_name['interviewProcessEnc']['interviewProcessFields'] as $p) {
                ?>
                <li id="<?= 'nav' . $p['field_enc_id'] ?>"
                    style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 2; ?>)">
                    <a data-filter=".<?= $p['field_enc_id'] . $k ?>" data-toggle="tooltip" data-placement="bottom"
                       title=""
                       data-original-title="<?= $p['field_name'] ?>" href="#">
                        <i class="<?= $p['icon'] ?>" aria-hidden="true"></i>
                    </a>
                </li>
                <?php
                $k++;
            }
            ?>
            <li style="width:calc(100% / <?= COUNT($application_name['interviewProcessEnc']['interviewProcessFields']) + 2; ?>)">
                <a data-filter=".result" data-toggle="tooltip" data-placement="bottom" data-original-title="Hired"
                   href="#">
                    <i class="fa fa-check-square-o"></i>
                </a>
            </li>
        </ul>
        <ul class="hiring_process_list gallery_zoom">
            <?php
            if (!empty($fields)) {
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
                    <li class="<?= $tempfieldMain ?>" data-key="<?= $fieldMain ?>">
                        <div class="row pr-user-main">
                            <div class="col-md-12 col-sm-12 pr-user-inner-main">
                                <div class="col-md-4">
                                    <div class="pr-user-detail">
                                        <a class="pr-user-icon" href="<?= '/' . $arr['username'].'/'.$arr['applied_application_enc_id'] ?>">
                                            <?php if ($arr['image']): ?>
                                                <img src="<?= $arr['image'] ?>"/>
                                            <?php else: ?>
                                                <canvas class="user-icon" name="<?= $arr['name'] ?>" width="80"
                                                        height="80" font="35px"></canvas>
                                            <?php endif; ?>
                                        </a>
                                        <a class="pr-user-n"
                                           href="<?= '/' . $arr['username'].'/'.$arr['applied_application_enc_id'] ?>"><?= $arr['name'] ?></a>
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
                                                <span class="past-title">
                                    Past
                                  </span>
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
                                        <span class="past-title">Applied Date</span>  <h5><?= date('d M Y',strtotime($arr['created_on'])) ?></h5>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="pr-user-skills">
                                        <ul>
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
	padding: 20px;
}
.j-main {
	display: flex;
	border-right: 2px solid #333;
}
.j-logo img {
	width: 70px;
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
.j-title {
	font-size: 18px;
	display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;`
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
}
.e-detail p {
	margin: 0;
//	margin-bottom: 11px !important;
	font-size:12px;
}
.e-logo i {
    font-size: 22px;
    color: #00a0e3;
}
.e-logo {
    width: 30px;
}
.ed-main {
	text-align: center;
}
.option-1 {
	margin: 20px 0;
}
.option-1 span i {
	font-size: 18px;
	margin: 0 8px;
	color: #b95b0a;
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
    background-color:#000 !important;
}
.round-detail{text-align:center;}
.round-detail h5{margin-bottom:5px;font-family:roboto;}
.round-detail h4{
    margin-top: 0px;
    font-weight: 500;
    font-family:roboto;
}
.pl-0{padding-left:0px;}
li{list-style: none;}
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
}
.pr-user-icon img{
    width: 100%;
    height:100%;
}
.pr-user-detail h5{
  font-size:14px;
  font-weight: 500;
  margin: 8px 0px;
  color: #858585;
}
.pr-user-detail h4 span{
  font-size:14px;
  color:#777777;
}
.pr-user-past span{
  display:inline-block;
  color:#aaa;
}
.pr-user-past .past-title{
  background-color:#f2f2f2;
  color:#555;
  padding:3px 15px;
  border-radius:20px;
}
.pr-user-past h5{
  display:inline-block;
  font-family:roboto;
}
.pr-user-skills{padding-top:20px;}
.pr-user-skills ul, .pr-user-actions ul{list-style:none;padding:0px;}
.pr-user-skills ul li{
  display:inline-block;
  background-color:#efefef;
  padding:4px 15px;
  margin:2px;
  font-size:15px;
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
  text-align:right;
}
.pr-user-actions ul li{
  display:inline-block;
  font-size:23px;
  margin:0px 8px;
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
@media screen and (max-width: 768px){
    .loc{
        margin-bottom:22px;
    }
}
@media screen and (max-width: 600px){
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
}
');
$script = <<<JS
$(document).on('click','#j-delete',function(e){
     e.preventDefault();
     if (window.confirm("Do you really want to Delete the current Application?")) { 
        var data = $(this).attr('value');
        var url = "/account/jobs/delete-application";
        $.ajax({
            url:url,
            data:{data:data},
            method:'post',
            success:function(data){
                  if(data==true) {
                      toastr.success('Deleted Successfully', 'Success');
                    }
                   else {
                      toastr.error('Something went wrong. Please try again.', 'Opps!!');
                   }
                 }
          });
    }
});
$(document).on('click','#j-closed',function(e){
     e.preventDefault();
     var data_name = $(this).attr('data-name');
     if (window.confirm("Do you really want to Close the current Application?")) { 
        var data = $(this).attr('value');
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
});
$('[data-toggle="tooltip"]').tooltip();
$(document).on('click','.slide-bttn',function(){
    $(this).parentsUntil('.pr-user-main').parent().next('.cd-box-border-hide').slideToggle('slow');
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
function hide_btn(res,total,thisObj,thisObj1,thisObj2){  
    if(res.active==total) {
        thisObj.hide();
        thisObj1.hide();
        thisObj2.show();
    }
}
function disable(thisObj){thisObj.html('APPROVE');thisObj.removeAttr("disabled");}
JS;
$this->registerJs($script);
$this->registerJsFile('/assets/themes/backend/vendor/isotope/isotope.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);