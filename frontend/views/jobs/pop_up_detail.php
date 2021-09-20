<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
if ($type == 'Internships') {
    if ($data['wage_type'] == 'Fixed') {
        if ($data['wage_duration'] == 'Weekly') {
            $data['fixed_wage'] = $data['fixed_wage'] / 7 * 30;
        }
        setlocale(LC_MONETARY, 'en_IN');
        $amount = '₹' . utf8_encode(money_format('%!.0n', $data['fixed_wage'])) . 'p.m.';
    } elseif ($data['wage_type'] == 'Negotiable' || $data['wage_type'] == 'Performance Based') {
        if ($data['wage_duration'] == 'Weekly') {
            $data['min_wage'] = $data['min_wage'] / 7 * 30;
            $data['max_wage'] = $data['max_wage'] / 7 * 30;
        }
        setlocale(LC_MONETARY, 'en_IN');
        $amount = '₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.m.';
    }
    $link = Url::to('internship/' . $application_details['slug'], true);
} else if ($type == 'Jobs') {
    if ($data['wage_type'] == 'Fixed') {
        if ($data['wage_duration'] == 'Monthly') {
            $data['fixed_wage'] = $data['fixed_wage'] * 12;
        } elseif ($data['wage_duration'] == 'Hourly') {
            $data['fixed_wage'] = $data['fixed_wage'] * 40 * 52;
        } elseif ($data['wage_duration'] == 'Weekly') {
            $data['fixed_wage'] = $data['fixed_wage'] * 52;
        }
        setlocale(LC_MONETARY, 'en_IN');
        $amount = '₹' . utf8_encode(money_format('%!.0n', $data['fixed_wage'])) . 'p.a.';
    } else if ($data['wage_type'] == 'Negotiable') {
        if ($data['wage_duration'] == 'Monthly') {
            $data['min_wage'] = $data['min_wage'] * 12;
            $data['max_wage'] = $data['max_wage'] * 12;
        } elseif ($data['wage_duration'] == 'Hourly') {
            $data['min_wage'] = $data['min_wage'] * 40 * 52;
            $data['max_wage'] = $data['max_wage'] * 40 * 52;
        } elseif ($data['wage_duration'] == 'Weekly') {
            $data['min_wage'] = $data['min_wage'] * 52;
            $data['max_wage'] = $data['max_wage'] * 52;
        }
        setlocale(LC_MONETARY, 'en_IN');
        if (!empty($data['min_wage']) && !empty($data['max_wage'])) {
            $amount = '₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.a.';
        } elseif (!empty($data['min_wage'])) {
            $amount = 'From ₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . 'p.a.';
        } elseif (!empty($data['max_wage'])) {
            $amount = 'Upto ₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.a.';
        } elseif (empty($data['min_wage']) && empty($data['max_wage'])) {
            $amount = 'Negotiable';
        }
    }
    $link = Url::to($application_details['link'], true);
}
?>
    <div id="openModal" class="modalDialog">
        <div class="modal-bg">
            <div class="col-md-12">
                <div class="row">
                    <div class="modal-main col-md-offset-2 col-sm-offset-1 col-xs-offset-1  col-md-8 col-sm-10 col-xs-10">
                        <a href="javascript:;" title="Close" class="jd-close">✕</a>
                        <div class="job-details-header col-md-12">
                            <div class="com-initials">
                                <div class="company-logo">
                                    <?php
                                    if (!empty($application_details['logo'])) {
                                        if ($application_details['organization_enc_id']) {
                                            ?>
                                            <img src="<?= Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $application_details['logo_location'] . DIRECTORY_SEPARATOR . $application_details['logo'] ?>"
                                                 class="img-responsive"/>
                                            <?php
                                        } else { ?>
                                            <img src="<?= Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo . $application_details['logo_location'] . DIRECTORY_SEPARATOR . $application_details['logo'] ?>"
                                                 class="img-responsive"/>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <canvas class="user-icon" name="<?= $application_details['org_name'] ?>"
                                                color="<?= $application_details['color'] ?>" width="100" height="100"
                                                border-radius="70px" font="45px"></canvas>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="name-f-c">
                                    <div><a href="<?= $application_details['link'] ?>" class="com-name"
                                            target="_blank"><?= $data['cat_name'] ?></a></div>
                                    <div><a href="<?= $application_details['org_link'] ?>" class="com-est"
                                            target="_blank"><?= $application_details['org_name'] ?></a></div>
                                </div>
                            </div>
                            <div class="buttons-detail">
                                <?php
                                if(!Yii::$app->user->identity->organization->organization_enc_id){
                                    if ($application_details['applied']) {
                                        ?>
                                        <a href="javascript:;" class="b-apply">Applied</a>
                                        <?php
                                    } else if (!$application_details['unclaimed_organization_enc_id']) {
                                        ?>
                                        <a href="javascript:;" data-app="<?= $application_details['application_enc_id']; ?>"
                                           data-org="<?= $application_details['organization_enc_id']; ?>"
                                           class="b-apply applyApplicationNow <?= $application_details['application_enc_id']; ?>-apply-now">Apply
                                            Now</a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?= $application_details['link'] ?>" target="_blank" class="b-apply">Apply Now</a>
                                        <?php
                                    }
                                }
                                ?>
                                <a href="<?= $application_details['link'] ?>" target="_blank" class="view-detail">View Detail</a>
                            </div>
                        </div>
                        <div class="j-details col-md-4">
                            <ul class="job-overviews row col-md-12">
                                <li>
                                    <i class="far fa-clock"></i>
                                    <h3>Experience</h3>
                                    <span><?= $data['experience'] ?></span>
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h3>Location</h3>
                                    <span><?= (($str) ? rtrim($str, ',') : 'Work From Home'); ?></span>
                                </li>
                                <?php
                                if ($type == '"jobs"') {
                                    if ($data['wage_type'] == 'Fixed') {
                                        $amount = $data['fixed_wage'];
                                        setlocale(LC_MONETARY, 'en_IN');
                                        $amount = '&#8377 ' . utf8_encode(money_format('%!.0n', $amount)) . 'p.a.';
                                    } else if ($data['wage_type'] == 'Negotiable') {
                                        $amount1 = $data['min_wage'];
                                        $amount2 = $data['max_wage'];
                                        setlocale(LC_MONETARY, 'en_IN');
                                        if (!empty($min_wage) && !empty($max_wage)) {
                                            $amount = '&#8377 ' . utf8_encode(money_format('%!.0n', $amount1)) . 'p.a.' . '&nbspTo&nbsp' . '&#8377 ' . utf8_encode(money_format('%!.0n', $amount2)) . 'p.a.';
                                        } elseif (!empty($min_wage)) {
                                            $amount = 'From &#8377 ' . utf8_encode(money_format('%!.0n', $amount1)) . 'p.a.';
                                        } elseif (!empty($max_wage)) {
                                            $amount = 'Upto &#8377 ' . utf8_encode(money_format('%!.0n', $amount2)) . 'p.a.';
                                        } elseif (empty($min_wage) && empty($max_wage)) {
                                            $amount = 'Negotiable';
                                        }
                                    }
                                    ?>
                                    <li>
                                        <i class="far fa-money-bill-alt"></i>
                                        <h3>Salary</h3>
                                        <span><?= $amount; ?></span>
                                    </li>
                                    <?php
                                }
                                if (!empty($data['industry'])) {
                                    ?>
                                    <li>
                                        <i class="fas fa-puzzle-piece"></i>
                                        <h3>Preferred Industry</h3>
                                        <span><?= $data['industry'] ?></span>
                                    </li>
                                    <?php
                                }
                                if (!empty($data['designation'])) {
                                    ?>
                                    <li>
                                        <i class="fas fa-thumbtack"></i>
                                        <h3>Designation</h3>
                                        <span><?= $data['designation'] ?></span>
                                    </li>
                                    <?php
                                }
                                if ($type == '"internships"') {
                                    if (!empty($data['min_wage'])) {
                                        ?>
                                        <li>
                                            <i class="far fa-money-bill-alt"></i>
                                            <h3>Minimum stipend</h3>
                                            <span><?= (($data['min_wage']) ? '&#8377 ' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . ' p.m.' : 'N/A'); ?></span>
                                        </li>
                                        <?php
                                    }
                                    if (!empty($data['max_wage'])) {
                                        ?>
                                        <li><i class="far fa-money-bill-alt"></i>
                                            <h3>Maximum Stipend</h3>
                                            <span><?= (($data['max_wage']) ? '&#8377 ' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . ' p.m.' : 'N/A'); ?></span>
                                        </li>
                                        <?php
                                    }
                                    if (!empty($data['fixed_wage'])) {
                                        ?>
                                        <li>
                                            <i class="far fa-money-bill-alt"></i>
                                            <h3>Fixed Stipend</h3>
                                            <span><?= (($data['fixed_wage']) ? '&#8377 ' . utf8_encode(money_format('%!.0n', $data['fixed_wage'])) . 'p.m.' : 'N/A') ?></span>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                                <li>
                                    <i class="fas fa-suitcase"></i>
                                    <h3>Type</h3>
                                    <span><?= $application_details['type'] ?></span>
                                </li>
                                <li>
                                    <i class="fas fa-chart-line"></i>
                                    <h3>Total Vacancies</h3>
                                    <span><?= (($total_vac) ? $total_vac : 'Not Applicable'); ?></span>
                                </li>
                            </ul>
                            <div class="col-md-12 flex-share">
                                <div class="share-bar">
                                    <h3>Share</h3>
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                       class="share-fb">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('https://twitter.com/home?status=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                       class="share-twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                       class="share-linkedin">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('https://wa.me/?text=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                       class="share-whatsapp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="javascript:;"
                                       onclick="window.open('<?= Url::to('mailto:?&body=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');"
                                       class="share-google">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                    <a href="javascript:;" class="tg-tele"
                                       onclick="window.open('<?= Url::to('https://t.me/share/url?url=' . $link); ?>', '_blank', 'width=800,height=400,left=200,top=100');">
                                        <i class="fab fa-telegram-plane"></i>
                                    </a>
                                    <a href="javascript:;" class="copy" id="copy-btn"
                                       onclick="copyFunction()">
                                       <span class="tooltiptext" id="myTooltip">Copy Link</span>
                                       <i class="fas fa-copy"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="j-discription col-md-8">
                            <?php
                            if ($data['description']) {
                                ?>
                                <h3 class="job-detail">Description</h3>
                                <div class="j-text j-textt">
                                    <div class="overlay"></div>
                                    <p>
                                        <?= $data['description'] ?>
                                    </p>
                                    <p>
                                    <ul>
                                        <?php
                                        foreach ($data['applicationJobDescriptions'] as $jd) {
                                            ?>
                                            <li><?= $jd['job_description'] ?></li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                    </p>
                                </div>
                                <div class="read-more col-md-12 p-0"><a href="<?= $application_details['link'] ?>"
                                                                        target="_blank" class="showmore">Read
                                        More......</a>
                                </div>
                                <?php
                            }
                            if ($data['applicationSkills']) {
                                ?>
                                <h3 class="job-detail">Skills Required</h3>
                                <div class="tags-bar">
                                    <?php
                                    foreach ($data['applicationSkills'] as $skill) {
                                        ?>
                                        <span><?= $skill['skill'] ?></span>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            if ($data['applicationSkills']) {
                                ?>
                                <h3 class="job-detail">Education/Qualification</h3>
                                <ul class="edu-requirement">
                                    <?php
                                    foreach ($data['applicationEducationalRequirements'] as $qualifications) {
                                        ?>
                                        <li><?= $qualifications['educational_requirement']; ?></li>
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
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.flex-share{
    padding-left: 0;
}
.j-textt{
	max-height: 364px;
}
.overlay {
    background: linear-gradient(180deg, transparent 80%, #ffffff 94%);
}
.read-moree{
    height:auto;
}
.showmore{display: block;}
.modalDialog {
    position: fixed;
    font-family: roboto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0,0,0,0.7);
    z-index: 99999;
    -webkit-transition: opacity 400ms ease-in;
    -moz-transition: opacity 400ms ease-in;
    transition: opacity 400ms ease-in;
    overflow:auto;
    margin-right:-18px;	
}
.modalDialog > .modal-bg {
    width:100%;
    margin: 1% auto; 
    position:relative;                   
    padding: 5px 20px 13px 20px;
    border-radius: 10px;
    color:#2d2d2d;  
}
.modal-main{
    background:#eef2f5;
    border-radius:10px;
    padding:15px;
    box-shadow:0px 0px 10px #fff;
    -moz-box-shadow: 0px 0px 10px #fff;
    -webkit-box-shadow: 0px 0px 10px #fff;
    margin-bottom:40px;
}
.modal-main .jd-close {
    background:#fff;
    color: #777672;
    line-height: 30px;
    position: absolute;
    right: -10px;
    text-align: center;
    top: -10px;
    width: 30px;
    height: 30px;
    text-decoration: none;
    font-weight:400;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;
    border-radius: 30px;
    -moz-box-shadow: 0px 0px 3px 1px #ddd;
    -webkit-box-shadow: 0px 0px 3px 1px #ddd;
    box-shadow: 0px 0px 3px 1px #ddd;
    opacity:1 !important; 
    z-index:9;
}
.modal-main .jd-close:hover {
    background:#fff;
    color:#ff7803;
    transition:.5s;
}
.bottom-line {
	border-bottom: 1px solid #ddd;
	padding-bottom: 15px;
	box-shadow: 0px 2px 5px -1px #ddd;
	padding-top: 20px;
	display: flex;
}
.job-overviews {
	box-shadow:0 0 10px 0px #e8ecec;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	-ms-border-radius: 8px;
	-o-border-radius: 8px;
	border-radius: 8px;
	padding:15px;
    background: #fff;
    height: 359px;
    overflow: auto;
}
.job-overviews::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
    border-radius: 0 8px 8px 0;
}

.job-overviews::-webkit-scrollbar
{
	width: 8px;
	background-color: #F5F5F5;
}

.job-overviews::-webkit-scrollbar-thumb
{
	background-color: #999999;
    border-radius: 0 8px 8px 0;
}

.job-overviews li {
	width: 100%;
	position: relative;
	padding-left: 50px;
	margin-bottom: 15px;
	min-height: 45px;
}
.job-overviews li i {
    height: 38px;
    position: absolute;
    left: -3px;
    top: 1px;
    font-size: 22px;
    background: linear-gradient(180deg, #C9EFFF -30%, #0094D1 125%);
    color: #ffffff;
    padding: 0 20px;
    border-radius: 11px;
}
i.far:before, i.fas:before {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.job-overviews li h3 {
	width: 100%;
	font-size: 13px;
	font-family: roboto;
	margin: 0;
	color: #1e1e1e;
	font-weight: 600;
}
.job-overviews li span {
	width: 100%;
	font-size: 13px;
	color: #545454;
	margin-top: 4px;
	display: -webkit-box;
	-webkit-line-clamp: 1;
	-webkit-box-orient: vertical;
	overflow: hidden;
}
h3.job-detail {
    width: 100%;
    font-family: roboto;
    font-size: 15px;
    color: #202020;
    margin-bottom: 10px;
    margin-top: 0;
    font-weight: 600;
}
.tags-bar {
	margin-bottom: 20px;
	box-shadow:0 0 10px 0px #e8ecec;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	-ms-border-radius: 8px;
	-o-border-radius: 8px;
	border-radius: 8px;
	padding: 10px;
	display: flex;
	align-items: center;
	justify-content: flex-start;
	flex-wrap: wrap;
}
.tags-bar > span {
	background: #f4f5fa;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	-ms-border-radius: 8px;
	-o-border-radius: 8px;
	border-radius: 8px;
	font-family: roboto;
	font-size: 13px;
	padding: 7px 17px;
	margin-right: 10px;
	margin-bottom: 5px;
}
.job-overviews li *, .apply-job-btn{
    -webkit-transition: all 0.4s ease 0s;
    -moz-transition: all 0.4s ease 0s;
    -ms-transition: all 0.4s ease 0s;
    -o-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}
.apply-job-btn {
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    font-size: 13px;
    text-align: center;
    margin: auto;
    display: inline-block;
    background: #ff7803;
    color: #fff;
    padding: 5px 28px;
    border: 2px solid #ff7803;
}
}
.apply-job-btn i {
    float: none;
    font-size: 25px;
    margin-right: 10px;
    line-height: 8px;
    position: relative;
    top: 4px;
}
.apply-job-btn:hover {
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    color: #ff7803;
    background: #fff;
}
.share-bar {
    text-align:center;
    text-align: center;
    background: #fff;
    border-radius: 8px;
    margin-left: -15px;
}
.share-bar h3 {
    margin: 0px;
    margin-top: 10px;
    font-size: 18px;
    font-family: Roboto;
    text-align: center;
    padding: 6px;
    font-weight: 700;
}
.share-bar a {
    display: inline-block;
    font-size: 18px;
    color: #fff;
    width: 30px;
    border-radius: 4px;
    height: 30px;
    position: relative;
    border-radius: 10px;
    background: #FFFFFF;
    box-shadow: 0px 0px 4px rgb(0 0 0 / 25%);
    border-radius: 11px;
    transition: .2s all ease-in;
}
.share-bar .fab, .share-bar .fas {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.share-bar a:not(.share-fb){
    margin-left: 7px;
}
.share-bar a.share-fb {
    color: #3b5998;
}
.share-bar a.share-twitter {
    color: #1da1f2;
}
.share-bar a.share-linkedin {
    color: #0077B5;
//    border-color: #0077B5;
}
.share-bar a.share-whatsapp {
    color: #4FCE5D;
//    border-color: #4FCE5D;
}
.share-bar a.share-google {
    color: #EA4335;
    position: relative;
//    border-color: #EA4335;
}
.share-bar a.tg-tele{
   color:#0088cc;
    border-color:#0088cc;  
}
.share-bar a.copy{
    color:#22577A;
     border-color:#22577A;  
 }
.share-bar a:hover{
    color: #fff;
    transition: 0.2s all ease-in;
    font-size: 12px;
    border-radius: 20px; 
}
.share-bar a.share-fb:hover {
    background-color: #3b5998;
}
.share-bar a.share-twitter:hover {
    background-color: #1da1f2;
}
.share-bar a.share-linkedin:hover {
    background-color: #0077B5;
}
.share-bar a.share-whatsapp:hover {
    background-color: #4FCE5D;
}
.share-bar a.share-google:hover {
    background-color: #EA4335;
    position: relative;
}
.share-bar a.tg-tele:hover{
   background-color:#0088cc;
    border-color:#0088cc;  
}
.share-bar a.copy:hover{
    background-color:#22577A;
     border-color:#22577A;  
 }
 #myTooltip:after {
    content: "";
    width: 10px;
    height: 10px;
    background: #222;
    display: block;
    position: absolute;
    transform: translateY(-50%);
    transform: rotate(45deg) translate(-93%);
    left: 50%;
    border-radius: 2px;
    z-index: -1;
}
#myTooltip {
    position: absolute;
    font-size: 13px;
    color: #fff;
    background: #222;
    width: 70px;
    border-radius: 5px;
    top: -30px;
    transform: translateX(-50%);
    display: none;
}

.com-name{ 
    font-size:18px; 
    font-weight:500;
    font-family:roboto;
    color:#000;
    line-height: 22px;
}
.com-est{
    font-size: 14px;
    font-weight: lighter;
    margin-top: 4px;
    color: #a0a0a0;
}
.com-initials {
    padding: 20px 0;
    display: flex;
    align-items: center;
    flex-basis: 65%;
}
.job-details-header {
    background: #fff;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
}
.company-logo {
    text-align: center;
    width: 100px;
    height: 100px;
    overflow: hidden;
    // box-shadow: 0 0 10px 0px rgb(0 0 0 / 30%);
    // border-radius: 70px;
    min-width: 100px;
}
.company-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    margin: 0 !important;
}
.company-logo canvas{border-radius:50%;}
.name-f-c {
    margin-left: 20px;
}
.j-details{padding:20px 0 0 15px;}

.j-discription {
    text-align: justify;
    font-size: 14px;
//    border-left: 2px solid #b8bdbd;
    padding: 20px;
    margin-top: 20px;
    background: #fff;
    border-radius: 8px;
    min-height: 480px;
}
.j-discription ul{ list-style-image:url(../images/check-circle1.png);}
.j-text {
//	padding-top: 10px;
	position: relative;
	overflow: hidden;
}
.read-more {
    margin-bottom: 10px;
}
.read-more a {
    color: #000000;
    font-size: 15px;
    font-family: roboto;
    font-weight: 900;
    margin-top: 5px;
}
.buttons-detail{
    text-align: center;
    flex-basis: 35%;
}
.view-detail, .b-apply, .view-detail:focus, .b-apply:focus{
    transition: .2s all ease-in;
    font-weight: 600;
    padding: 6px 22px;
    color: #fff;
    border-radius: 5px;
    margin-bottom: 5px;
    transition: .2s all ease-in;
    display:inline-block;
}
.b-apply{
    background-color:#00a0e3;
    border:2px solid #00a0e3;
}
.b-apply:hover{
    background-color:#fff;
    color:#00a0e3;
}
.view-detail{
    background-color:#ff7803;
    border:2px solid #ff7803;   
}
.view-detail:hover{
    background-color: #fff;
    color: #ff7803;
}
.edu-requirement {
    width: 100%;
    margin-bottom: 20px;
}
.edu-requirement li{
    float: left;
    width: 100%;
    margin: 0;
    position: relative;
    padding-left: 23px;
    line-height: 21px;
    margin-bottom: 10px;
    font-size: 13px;
    color: #888888;
}
.edu-requirement li::before {
    position: absolute;
    left: 0;
    top: 10px;
    width: 10px;
    height: 1px;
    background: #888888;
    content: "";
}

@media only screen and (max-width:992px){
    .job-overviews li{flex-basis:49%;}
    .j-details{
        padding: 9px 15px 0 15px;
    }
    .flex-share {
        padding: 0;
        margin-right: -15px;
    }
}
@media only screen and (max-width:768px){
    .job-details-header{
        flex-direction: column;
    }
    .view-detail, .b-apply{
        padding: 4px 16px;
    }
}
@media only screen and (max-width:670px){
.name-f-c {
    margin-left: 0px;
    width: 100%;
}
.company-logo {margin:20px auto;}
.job-overviews li{flex-basis:100%;}
.com-initials {
	text-align: center;
    flex-direction: column;
}
}
');
$script = <<<js
// $('.showmore').click(function () {
//     var status = $('.j-text');
//    var chk = status.hasClass('j-textt');
//    var btn = $(this);
//   if(chk){
//       btn.html('Read Less');
//       status.addClass('read-moree');
//       status.removeClass('j-textt');
//   } else {
//       btn.html('Read More......');
//       status.removeClass('read-moree');
//       status.addClass('j-textt');
//   }
// });
if(document.getElementsByClassName('j-text')[0].scrollHeight <= 394){
    document.getElementsByClassName('read-more')[0].classList.add('hidden');
}
js;
$this->registerJs('
utilities.initials();
var load_template = `<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-body"><img src="/assets/themes/dashboard/global/img/loading-spinner-grey.gif" class="loading"><span>Loading... </span></div></div></div>`;
$(document).on("click", ".jd-close", function(){
    $("#pop_up_modal").modal("hide");
    $("#pop_up_modal").html(load_template);    
});


var copyBtn = document.querySelector("#copy-btn");
var copyTooltip = document.querySelector("#myTooltip");
copyBtn.addEventListener("mouseover", () => {
    copyTooltip.style.display = "inline";
});
copyBtn.addEventListener("mouseout", () => {
    copyTooltip.style.display = "none";
});


function copyFunction() {
    var detailLink = document.querySelector(".view-detail").getAttribute("href");
    navigator.clipboard.writeText("empoweryouth.com" + detailLink);
    copyTooltip.innerHTML = "Copied";

    setTimeout(function() {
        copyTooltip.innerHTML = "Copy Link";
    }, 5000);
}

');
$this->registerJs($script);
