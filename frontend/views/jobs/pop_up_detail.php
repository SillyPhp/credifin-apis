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
    $link = Url::to('job/' . $application_details['slug'], true);
}
?>
    <div id="openModal" class="modalDialog">
        <div class="modal-bg">
            <div class="col-md-12">
                <div class="row">
                    <div class="modal-main col-md-offset-2 col-sm-offset-1 col-xs-offset-1  col-md-8 col-sm-10 col-xs-10">
                        <a href="javascript:;" title="Close" class="jd-close">✕</a>
                        <div class="row bottom-line">
                            <div class="com-initials col-md-12 col-sm-12">
                                <div class="company-logo center-block">
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
                                                border-radius="70px"
                                                font="55px"></canvas>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="name-f-c">
                                    <div class="com-name"><?= $data['cat_name'] ?></div>
                                    <div class="com-est"><?= $application_details['org_name'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
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
                            </div>
                        </div>
                        <div class="j-details col-md-12">
                            <ul class="job-overviews row">
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
                                        <li><i class="far fa-money-bill-alt"></i>
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
                                        <li><i class="far fa-money-bill-alt"></i>
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
                        </div>
                        <div class="j-discription col-md-12">
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
                            <h3 class="job-detail">Description</h3>
                            <div class="j-text j-textt">
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
                            <div class="read-more col-md-12"><a href="#" class="showmore">Read More</a></div>
                        </div>
                        <div class="col-md-12">
                            <div class="b-apply foo">
                                <a href="<?= $link ?>" class="apply-job-btn apply-btn"><i
                                            class="fas fa-paper-plane"></i>View
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.j-textt{
	max-height: 450px;
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
    margin: 3% auto; 
    position:relative;                   
    padding: 5px 20px 13px 20px;
    border-radius: 10px;
    color:#2d2d2d;  
}
.modal-main{
    background:#fff;
    border-radius:10px;
    padding:15px;
    box-shadow:0px 0px 10px #fff;
    -moz-box-shadow: 0px 0px 10px #fff;
    -webkit-box-shadow: 0px 0px 10px #fff;
    margin-bottom:40px;
    padding-top: 0px;
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
	border: 2px solid #e8ecec;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	-ms-border-radius: 8px;
	-o-border-radius: 8px;
	border-radius: 8px;
	margin: 0;
	padding-left: 15px !important;
	display: flex;
	flex-wrap: wrap;
	justify-content: flex-start;
	align-items: flex-start;
}
.job-overviews li {
	width: 192px;
	position: relative;
	padding-left: 50px;
	margin: 8px 2px;
	min-height: 45px;
}
.job-overviews li i {
    position: absolute;
    left: 0px;
    top: 5px;
    font-size: 30px;
    color: #4aa1e3;
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
.job-overviews li:hover i {
    color: #ef7706;
}
h3.job-detail {
    width: 100%;
    font-family: roboto;
    font-size: 15px;
    color: #202020;
    margin-bottom: 15px;
    margin-top: 10px;
    font-weight: 600;
}
.tags-bar {
	margin-bottom: 20px;
	border: 2px solid #e8ecec;
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
    font-family: roboto;
    font-size: 13px;
    color: #ef7706;
    width: 200px;
    height: auto;
    padding: 15px 15px;
    text-align: center;
    margin: auto;
    display: inline-block;
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
    color: #ef7706;
}
.share-bar {
    text-align:center;
}
.share-bar h3 {
	margin: 0px;
	margin-top: 10px;
	font-size: 24px;
	font-family: lora;
	margin-bottom: 10px;
}
.share-bar a {
	display: inline-block;
	font-size: 18px;
	margin: 0px 0 4px;
	color: #fff;
	padding: 5px 0;
	min-width: 130px;
}
.share-bar a.share-fb {
    background-color: #3b5998;
}
.share-bar a.share-twitter {
    background-color: #1da1f2;
}
.share-bar a.share-linkedin {
    background-color: #0077B5;
//    border-color: #0077B5;
}
.share-bar a.share-whatsapp {
    background-color: #4FCE5D;
//    border-color: #4FCE5D;
}
.share-bar a.share-google {
    background-color: #EA4335;
//    border-color: #EA4335;
}
.share-bar a.tg-tele{
    background-color:#0088cc;
    border-color:#0088cc;  
}
.com-name{ 
    font-size:20px; 
    font-weight:600;
    font-family:roboto;
}
.com-est{
    font-size: 16px;
    font-weight: lighter;
    margin-top: 4px;
}
.com-initials {
	display: flex;
	align-items: center;
	flex-wrap: wrap;
}
.company-logo {
	max-height: 100px;
	max-width: 100px;
	text-align: center;
	width: 100px;
	height: 100px;
	border-radius: 50%;
	overflow: hidden;
	margin: 0 10px 0 0;
}
.j-details{padding-top:20px;}

.j-discription{ text-align:justify; font-size:14px; padding-top:15px;}
.j-discription ul{ list-style-image:url(../images/check-circle1.png);}
.j-text {
	padding-top: 10px;
	position: relative;
	overflow: hidden;
	margin-bottom: 20px;
}
.read-more {
    text-align: center;
    margin-bottom: 20px;
}
.read-more a {
	color: #333;
	font-size: 18px;
	font-family: roboto;
}
.b-apply{  text-align:center;}
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
@media only screen and (max-width:670px){
.com-initials {
	display: block;
	margin: auto;
	text-align: center;
}
.company-logo{
    margin:0 auto;
}
}
');
$script = <<<js
$('.showmore').click(function () {
    var status = $('.j-text');
   var chk = status.hasClass('j-textt');
   var btn = $(this);
  if(chk){
      btn.html('Show Less');
      status.addClass('read-moree');
      status.removeClass('j-textt');
  } else {
      btn.html('Show More');
      status.removeClass('read-moree');
      status.addClass('j-textt');
  }
});
if(document.getElementsByClassName('j-text')[0].scrollHeight <= 451){
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
');
$this->registerJs($script);