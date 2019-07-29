<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->params['header_dark'] = false;
$this->title = 'Job Preview';
$object->fixed_wage = (($object->fixed_wage) ? str_replace(',', '', $object->fixed_wage) : 0);
$object->min_wage = (($object->min_wage) ? str_replace(',', '', $object->min_wage) : 0);
$object->max_wage = (($object->max_wage) ? str_replace(',', '', $object->max_wage) : 0);
if (!empty($object->skillsArray)) {
    $s = json_decode($object->skillsArray);
    $c = count($s);
    for ($i = 0; $i < $c; $i++) {
        $skills[$i]['skill'] = $s[$i];
    }
}
if (!empty($object->qualifications_arr)) {
    $e = json_decode($object->qualifications_arr);
    $cnt = count($e);
    for ($i = 0; $i < $cnt; $i++) {
        $ed[$i]['educational_requirement'] = $e[$i];
    }
}
if (!empty($object->placement_loc)) {
    $pl_loc = json_decode($object->placement_loc, true);
    foreach ($pl_loc as $key => $val) {
        $placement_locations[$key]['positions'] = $val['value'];
        $placement_locations[$key]['name'] = $val['name'];
    }
}
if ($object->type == 'Work From Home') {
    $placement_locations = [];
}
if (!empty($object->checkboxArray)) {
    $j = json_decode($object->checkboxArray);
    $count = count($j);
    for ($i = 0; $i < $count; $i++) {
        $jd[$i]['job_description'] = $j[$i];
    }
}
if (!empty($object->getinterviewcity)) {
    $int = json_decode($object->getinterviewcity);
    $count_int = count($int);
    for ($i = 0; $i < $count_int; $i++) {
        $int_t[$i]['name'] = $int[$i];
    }
}
switch ($object->min_exp) {
    case '0':
        $experience = 'No Experience';
        break;
    case '1':
        $experience = 'Less Than 1 Year';
        break;
    case '2';
        $experience = '1 Year';
        break;
    case '3':
        $experience = '2-3 Years';
        break;
    case '3-5':
        $experience = '3-5 Years';
        break;
    case '5-10':
        $experience = '5-10 Years';
        break;
    case '10-20':
        $experience = '10-20 Years';
        break;
    case '20+':
        $experience = 'More Than 20 Years';
        break;
}
switch ($object->wage_type) {
    case '1':
        $object->wage_type = 'Fixed';
        break;
    case '2':
        $object->wage_type = 'Negotiable';
        break;
    case '3':
        $object->wage_type = 'Performance Based';
        break;
    case '0':
        $object->wage_type = 'Unpaid';
        break;
}
if ($type == 'Job') {
    if ($object->wage_type == 'Fixed') {
        if ($object->wage_duration == 'Monthly') {
            $fixd = $object->fixed_wage * 12;
        } elseif ($object->wage_duration == 'Hourly') {
            $fixd = $object->fixed_wage * 40 * 52;
        } elseif ($object->wage_duration == 'Weekly') {
            $fixd = $object->fixed_wage * 52;
        }
        setlocale(LC_MONETARY, 'en_IN');
        $amount = '₹' . utf8_encode(money_format('%!.0n', $fixd)) . 'p.a.';
    } else if ($object->wage_type == 'Negotiable') {
        if ($object->wage_duration == 'Monthly') {
            $min_wage = $object->min_wage * 12;
            $max_wage = $object->max_wage * 12;
        } elseif ($object->wage_duration == 'Hourly') {
            $min_wage = $object->min_wage * 40 * 52;
            $max_wage = $object->max_wage * 40 * 52;
        } elseif ($object->wage_duration == 'Weekly') {
            $min_wage = $object->min_wage * 52;
            $max_wage = $object->max_wage * 52;
        }
        setlocale(LC_MONETARY, 'en_IN');
        if (!empty($min_wage) && !empty($max_wage)) {
            $amount = '₹' . utf8_encode(money_format('%!.0n', $min_wage)) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $max_wage)) . 'p.a.';
        } elseif (!empty($min_wage)) {
            $amount = 'From ₹' . utf8_encode(money_format('%!.0n', $min_wage)) . 'p.a.';
        } elseif (!empty($max_wage)) {
            $amount = 'Upto ₹' . utf8_encode(money_format('%!.0n', $max_wage)) . 'p.a.';
        } elseif (empty($min_wage) && empty($max_wage)) {
            $amount = 'Negotiable';
        }
    }
}
if ($type == 'Internship') {
    if ($object->wage_type == 'Fixed') {
        if ($object->wage_duration == 'Weekly') {
            $fixd = $object->fixed_wage / 7 * 30;
        } else {
            $fixd = $object->fixed_wage;
        }
        setlocale(LC_MONETARY, 'en_IN');
        $amount = '₹' . utf8_encode(money_format('%!.0n', $fixd)) . 'p.m.';
    } elseif ($object->wage_type == 'Negotiable' || $object->wage_type == 'Performance Based') {
        if ($object->wage_duration == 'Weekly') {
            $min_wage = $object->min_wage / 7 * 30;
            $max_wage = $object->max_wage / 7 * 30;
        } else {
            $min_wage = $object->min_wage;
            $max_wage = $object->max_wage;
        }
        setlocale(LC_MONETARY, 'en_IN');
        $amount = '₹' . utf8_encode(money_format('%!.0n', $min_wage)) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $max_wage)) . 'p.m.';
    }
}
echo $this->render('/widgets/employer_applications/top-banner', [
    'org_image_location' => Yii::$app->user->identity->organization->cover_image_location,
    'org_image' => Yii::$app->user->identity->organization->cover_image,
    'job_title' => $object->title,
    'icon_png' => $primary_cat['icon_png'],
    'shortlist' => null,
]);
?>
    <section>
        <div class="container">
            <div class="row m-0">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <div class="job-single-sec">
                        <div class="job-single-head2">
                            <?php if ($type == 'Internship') {
                                echo $this->render('/widgets/employer_applications/internship-overview', [
                                    'placement_offer' => (($object->pre_placement_offer) ? 1 : 0),
                                    'profile_name' => $primary_cat['name'],
                                    'wage_duration' => $object->wage_duration,
                                    'wage_type' => $object->wage_type,
                                    'max_wage' => $max_wage,
                                    'min_wage' => $min_wage,
                                    'gender' => $object->gender,
                                    'fixed_wage' => $fixd,
                                    'placement_locations' => $placement_locations,
                                ]);
                            } else if ($type == 'Job') {
                                echo $this->render('/widgets/employer_applications/job-overview', [
                                    'profile_name' => $primary_cat['name'],
                                    'industry' => $industry['industry'],
                                    'designation' => $object->designations,
                                    'job_type' => $object->type,
                                    'wage_duration' => $object->wage_duration,
                                    'wage_type' => $object->wage_type,
                                    'max_wage' => $max_wage,
                                    'min_wage' => $min_wage,
                                    'gender' => $object->gender,
                                    'fixed_wage' => $fixd,
                                    'experience' => $experience,
                                    'placement_locations' => $placement_locations,
                                ]);
                            } ?>
                        </div>
                        <div class="job-details">
                            <?=
                            $this->render('/widgets/employer_applications/working-days', [
                                'working_days' => json_encode($object->weekdays)
                            ]);
                            ?>
                            <?=
                            $this->render('/widgets/employer_applications/working-time', [
                                'working_time_from' => $object->from,
                                'working_time_to' => $object->to
                            ]);
                            ?>
                            <?=
                            $this->render('/widgets/employer_applications/employee-benefits', [
                                'benefits' => $benefits
                            ]);
                            ?>
                            <?=
                            $this->render('/widgets/employer_applications/skills', [
                                'skills' => $skills
                            ]);
                            ?>
                            <?=
                            $this->render('/widgets/employer_applications/job-description', [
                                'job_description' => $jd,
                                'type' => $type,
                            ]);
                            ?>

                            <?=
                            $this->render('/widgets/employer_applications/educational-requirements', [
                                'educational_requirements' => $ed,
                            ]);
                            ?>
                            <?=
                            $this->render('/widgets/employer_applications/other-details', [
                                'other_details' => $object->othrdetail,
                            ]);
                            ?>
                        </div>
                        <div class="job-overview">
                            <?=
                            $this->render('/widgets/employer_applications/interview-details', [
                                'interview_start' => $object->startdate . ' ' . $object->interviewstarttime,
                                'interview_end' => $object->enddate . ' ' . $object->interviewendtime,
                                'interview_locations' => $int_t,
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 z-index-9">
                    <?=
                    $this->render('/widgets/employer_applications/organization-details', [
                        'org_logo' => Yii::$app->user->identity->organization->logo,
                        'org_logo_location' => Yii::$app->user->identity->organization->logo_location,
                        'org_name' => Yii::$app->user->identity->organization->name,
                        'slug' => Yii::$app->user->identity->organization->slug,
                        'website' => Yii::$app->user->identity->organization->website,
                        'type' => $type,
                        'applied' => false,
                        'application_slug' => 'Empoweryouth',
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </section>
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
        width: 90px;
        height: 90px; 
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
//        z-index: -1;
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
    }str
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
//        float: left;
//        width: 100%;
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
//        -webkit-box-shadow: 0px 0px 20px 7px #ddd;
//        -moz-box-shadow: 0px 0px 20px 7px #ddd;
//        -ms-box-shadow: 0px 0px 20px 7px #ddd;
//        -o-box-shadow: 0px 0px 20px 7px #ddd;
//        box-shadow: 0px 0px 20px 7px #ddd;
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
        font-family: Open Sans;
        font-size: 13px;
        color: #fff;
        width: 175px;
        height: auto;
        padding: 15px 6px;
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
               padding-top: 160px;
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
