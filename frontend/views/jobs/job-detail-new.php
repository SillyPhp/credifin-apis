<style>
    .block {
        float: left;
        padding: 60px 0;
        position: relative;
        width: 100%;
        z-index: 1;
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
        content: "";
        z-index: -1;
        background: #00000078;
        /*        background: rgb(139,145,221);
                background: -moz-linear-gradient(45deg,  rgba(139,145,221,1) 0%, rgba(16,25,93,1) 71%, rgba(16,25,93,1) 100%);
                background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,rgba(139,145,221,1)), color-stop(71%,rgba(16,25,93,1)), color-stop(100%,rgba(16,25,93,1)));
                background: -webkit-linear-gradient(45deg,  rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
                background: -o-linear-gradient(45deg,  rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
                background: -ms-linear-gradient(45deg,  rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);
                background: linear-gradient(45deg,  rgba(139,145,221,1) 0%,rgba(16,25,93,1) 71%,rgba(16,25,93,1) 100%);*/
        /*filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4aa1e3', endColorstr='#10195d',GradientType=1 );*/
        opacity: 0.8;
    }
    .inner-header::after {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        content: "";
        background-image: url('../images/lines.png');
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
        padding-bottom: 30px;
        border-bottom: 1px solid #e8ecec;
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
        padding-top: 20px;
    }
    .job-details h3 {
        float: left;
        width: 100%;
        font-family: Open Sans;
        font-size: 15px;
        color: #202020;
        margin-bottom: 15px;
        margin-top: 10px;
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
        top: 13px;
        width: 10px;
        height: 1px;
        background: #888888;
        content: "";
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
        margin: 15px 0;
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
    }
    .job-overview ul > li span {
        float: left;
        width: 100%;
        font-size: 13px;
        color: #888888;
        margin-top: 7px;
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
    .job-overview ul > li *, .share-bar *, .job-single-head.style2 > a, .apply-job-btn, .hover-change{
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
        padding-bottom: 20px;
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
        color: #ef7706;
        border-color: #ef7706;
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
        background: #ef7706;
        border-color: #ef7706;
        color: #ffffff;
    }
    .share-bar a:hover {
        background: #ef7706;
        border-color: #ef7706;
        color: #ffffff;
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
    }
    .job-single-head.style2 .job-thumb img {
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
        margin-top: 30px;
        margin-bottom: 30px;
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
        /*float: none;*/
        /*display: inline-block;*/
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
        font-size: 15px;
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
        /*float: right;*/
        /*display: inline-block;*/
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
        padding: 15px 30px;
        /*line-height: 60px;*/
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
        /*line-height: 60px;*/
    }
    .job-title2 > h3 {
        float: left;
        font-size: 20px;
        font-weight: bold;
        margin: 0;
        margin-right: 0px;
        margin-right: 20px;
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
        position: relative;
    }
    .hover-change:hover {
        background: #fb236a;
        border-color: #fb236a;
        color: #ffffff;
    }
</style>
<?php
$this->title = Yii::t('frontend', 'Job Detail');
$this->params['header_dark'] = true;

$total_vac = 0;

foreach ($options as $value) {
    $option[$value['option_name']] = $value['value'];
}
foreach ($org_details as $org) {
    $org_name = $org['name'];
    $org_email = $org['email'];
    $org_website = $org['website'];
    $logo = $org['logo'];
    $logo_location = $org['logo_location'];
    $cover = $org['cover_image'];
    $cover_location = $org['cover_image_location'];
}

$cover_image = Yii::$app->params->upload_directories->organizations->cover_image . $cover_location . DIRECTORY_SEPARATOR . $cover;
$cover_image_base_path = Yii::$app->params->upload_directories->organizations->cover_image_path . $cover_location . DIRECTORY_SEPARATOR . $cover;
if (!file_exists($cover_image_base_path)) {
    $cover_image = "http://www.placehold.it/1500x500/EFEFEF/AAAAAA&amp;text=No+Cover+Image";
}

$logo_image = Yii::$app->params->upload_directories->organizations->logo . $logo_location . DIRECTORY_SEPARATOR . $logo;
$logo_base_path = Yii::$app->params->upload_directories->organizations->logo_path . $logo_location . DIRECTORY_SEPARATOR . $logo;

if (!file_exists($logo_base_path)) {
    $logo_image = "http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=No+Logo";
}
?>
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('http://www.eygb.co/images/company/cover_image/4bXlXl4UOQPpfiH88OPT/RBS-iRfn5w6Pb73YtrspGkEPKOpJmflm/aWdVMVlPeTRIbDFiZy85andzY1l3dz09.jpg') repeat scroll 50% 422.28px transparent;background-size: 100% 100% !important;background-repeat: no-repeat;" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>Senior Web Designer</h3>
                        <div class="job-statistic">
                            <span>PART TIME</span>
                            <!--<div class="apply-alternative">-->
                            <span class="hover-change"><i class="fa fa-heart-o"></i> Shortlist</span>
                            <!--</div>-->
                            <!--<p><i class="fa fa-map-marker"></i> Ajax, Ontario</p>-->
                            <!--<i class="fa fa-heart-o"></i>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="job-single-sec">
                        <div class="job-single-head2">
                            <!--<div class="job-title2">-->
                            <!--<h3>Senior Web Designer</h3>-->
                            <!--<span class="job-is ft">Full time</span>-->

                            <!--</div>-->
                            <!--<ul class="tags-jobs">-->
                                <!--<li><i class="fa fa-map-marker"></i> Sacramento, California</li>-->
                                <!--<li><i class="fa fa-money"></i> Monthly Salary : <span>$3000 - $5000</span></li>-->
                                <!--<li><i class="fa fa-calendar-o"></i> Post Date: July 29, 2017</li>-->
                            <!--</ul>-->                            
                            <!--<span><strong>Roles</strong> : UX/UI Designer, Web Designer, Graphic Designer</span>-->
                            <div class="job-overview">
                                <h3>Job Overview</h3>
                                <ul>
                                    <li><i class="fa fa-money"></i><h3>Offerd Salary</h3><span><?= $option['salary']; ?></span></li>
                                    <li><i class="fa fa-mars-double"></i><h3>Gender</h3><span>Female</span></li>
                                    <li><i class="fa fa-thumb-tack"></i><h3>Career Level</h3><span>Executive</span></li>
                                    <li><i class="fa fa-puzzle-piece"></i><h3>Industry</h3><span><?= $option['industry']; ?></span></li>
                                    <li><i class="fa fa-shield"></i><h3>Experience</h3><span>2 Years</span></li>
                                    <li><i class="fa fa-line-chart "></i><h3>Qualification</h3><span><?= $option['qualification']; ?></span></li>
                                    <li><i class="fa fa-map-marker "></i><h3>Locations</h3><span>Sacramento, California</span></li>
                                </ul>
                            </div><!-- Job Overview -->
                        </div><!-- Job Head -->

                        <div class="job-details">
                            <h3>Required Knowledge, Skills, and Abilities</h3>
                            <div class="tags-bar">
                                <span>Full Time</span>
                                <span>UX/UI Design</span>
                                <span>Istanbul</span>
                            </div>
                            <!--                            <ul>
                                                            <li>Ability to write code – HTML & CSS (SCSS flavor of SASS preferred when writing CSS)</li>
                                                            <li>Proficient in Photoshop, Illustrator, bonus points for familiarity with Sketch (Sketch is our preferred concepting)</li>
                                                            <li>Cross-browser and platform testing as standard practice</li>
                                                            <li>Experience using Invision a plus</li>
                                                            <li>Experience in video production a plus or, at a minimum, a willingness to learn</li>
                                                        </ul>-->
                            <h3>Job Description</h3>
                            <ul>
                                <li>Advanced degree or equivalent experience in graphic and web design</li>
                                <li>3 or more years of professional design experience</li>
                                <li>Direct response email experience</li>
                                <li>Ecommerce website design experience</li>
                            </ul>
                            <h3>Other Details</h3>
                            <p>Company is a 2016 Iowa City-born start-up that develops consectetuer adipiscing elit. Phasellus hendrerit. Pellentesque aliquet nibh nec urna. In nisi neque, aliquet vel, dapibus id, mattis vel, nisi. Sed pretium, ligula sollicitudin laoreet viverra, tortor libero sodales leo, eget blandit nunc tortor eu nibh. Nullam mollis. Ut justo. Suspendisse potenti.</p>
                            <!--<p>Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing, commodo quis, gravida id, est. Sed lectus. Praesent elementum hendrerit tortor. Sed semper lorem at felis. Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien</p>-->
                            <h3>Education + Experience</h3>
                            <ul>
                                <li>Advanced degree or equivalent experience in graphic and web design</li>
                                <li>3 or more years of professional design experience</li>
                                <li>Direct response email experience</li>
                                <li>Ecommerce website design experience</li>
                                <li>Familiarity with mobile and web apps preferred</li>
                                <li>Excellent communication skills, most notably a demonstrated ability to solicit and address creative and design feedback</li>
                                <li>Must be able to work under pressure and meet deadlines while maintaining a positive attitude and providing exemplary customer service</li>
                                <li>Ability to work independently and to carry out assignments to completion within parameters of instructions given, prescribed routines, and standard accepted practices</li>
                            </ul>
                        </div>
                        <div class="job-overview">
                            <h3>Interview Details</h3>
                            <ul style="border:0px;">
                                <li><i class="fa fa-clock-o"></i><h3>Interview Time</h3><span>10:00AM to 02:00PM</span></li>
                                <li><i class="fa fa-map-marker"></i><h3>Interview Locations</h3><span>Sacramento, California</span></li>
                            </ul>
                        </div>
                        <div class="share-bar">
                            <span>Share</span><a href="#" title="" class="share-fb"><i class="fa fa-facebook"></i></a><a href="#" title="" class="share-twitter"><i class="fa fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="job-single-head style2">
                        <div class="job-thumb"> <img src="http://placehold.it/124x124" alt="" /> </div>
                        <div class="job-head-info">
                            <h4>Tix Dog</h4>
                            <!--<span>274 Seven Sisters Road, London, N4 2HY</span>-->
                            <p><i class="fa fa-unlink"></i> www.empoweryouth.in</p>
                            <!--<p><i class="fa fa-phone"></i> +90 538 963 54 87</p>-->
                            <p><i class="fa fa-envelope-o"></i> ali.tufan@jobhunt.com</p>
                        </div>
                        <a href="#" title="" class="apply-job-btn"><i class="fa fa-paper-plane"></i>Apply for job</a>
                        <a href="#" title="" class="viewall-jobs">View all Jobs</a>
                    </div><!-- Job Head -->
                </div>
            </div>
        </div>
    </div>
</section>