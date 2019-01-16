<?php
$this->title = Yii::t('frontend', 'Internship Preview');
use yii\helpers\Url;
$tot = 0;
foreach (json_decode($object->placement_loc) as $pl_loc) {
    $str .= $pl_loc->name . ',';
    $tot = $tot + $pl_loc->value;
}
$pl_loc = rtrim($str, ',');
$cover_image = Yii::$app->params->upload_directories->organizations->cover_image . Yii::$app->user->identity->organization->cover_image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->cover_image;
$cover_image_base_path = Yii::$app->params->upload_directories->organizations->cover_image_path . Yii::$app->user->identity->organization->cover_image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->cover_image;

if (!file_exists($cover_image_base_path)) {
    $cover_image = "http://www.placehold.it/1500x500/EFEFEF/AAAAAA&amp;text=No+Cover+Image";
}
$logo_image = Yii::$app->params->upload_directories->organizations->logo . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;
?>
    <section class="overlape">
        <div data-velocity="-.1" style="background: url('<?= Url::to($cover_image); ?>') repeat scroll 50% 422.28px transparent;background-size: 100% 100% !important;background-repeat: no-repeat;" class="parallax scrolly-invisible no-parallax"></div>
        <div class="row m-0">
            <div class="col-lg-12 p-0">
                <div class="inner-header">
                    <h3><?= $object->jobtitle; ?></h3>
                    <div class="job-statistic">
                        <span class="hover-change"><a href="#" class="shortlist_job"><i class="fa fa-heart-o"></i> Shortlist</a></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="job-single-sec">
                        <div class="job-single-head2">
                            <div class="job-overview">
                                <h3>Job Overview</h3>
                                <?php
                                $n1 = $object->stipendtype;
                                switch ($n1)
                                {
                                    case 1;
                                         $type = 'Unpaid';
                                         break;
                                    case 2;
                                        $type = 'Performance Based';
                                        break;
                                    case 3;
                                        $type = 'Negotiable';
                                        break;
                                    case 4;
                                        $type = 'Fixed';
                                        break;
                                }
                                $n2 = $object->pre_place;
                                switch ($n2)
                                {
                                    case 1;
                                        $offer = 'Yes';
                                        break;
                                    case 2;
                                        $offer = 'No';
                                        break;
                                }
                                ?>
                                <ul>
                                    <li><i class="fa fa-puzzle-piece"></i><h3>Profile</h3><span><?= $primary_cat['name']; ?></span></li>
                                    <li><i class="fa fa-puzzle-piece"></i><h3>Stipend Type</h3><span><?= $type; ?></span></li>
                                    <li><i class="fa fa-thumb-tack"></i><h3>Preplacement Offer</h3><span><?= $offer; ?></span></li>
                                    <li><i class="fa fa-thumb-tack"></i><h3>Maximum Stipend</h3><span><?= (($object->maxstip) ? $object->maxstip : 'Nil') ?></span></li>
                                    <li><i class="fa fa-money"></i><h3>Minimum stipend</h3><span><?= (($object->minstip) ? $object->minstip : 'Nil') ?></span></li>
                                    <li><i class="fa fa-mars-double"></i><h3>Gender</h3><span>
                                        <?php
                                        if ($object->gender == 0) {
                                            echo 'No Preference';
                                        } else if ($object->gender == 1) {
                                            echo 'Male';
                                        } else if ($object->gender == 2) {
                                            echo 'Female';
                                        } else if ($object->gender == 3) {
                                            echo 'Trans';
                                        }
                                        ?>
                                    </span></li>
                                    <li><i class="fa fa-shield"></i><h3>Fixed Stipend</h3><span><?= (($object->stipendpaid) ? $object->stipendpaid : 'Nil') ?></span></li>
                                    <li><i class="fa fa-line-chart "></i><h3>Total Vacancy</h3><span><?= $tot ?> </span></li>
                                    <li><i class="fa fa-map-marker "></i><h3>Locations</h3><span>
                                        <?= $pl_loc; ?>
                                    </span> </li>
                                </ul>
                            </div><!-- Job Overview -->
                        </div><!-- Job Head -->
                        <div class="job-details">
                            <h3>Required Knowledge, Skills, and Abilities</h3>
                            <div class="tags-bar">
                                <?php foreach (json_decode($object->skillsArray) as $skill) { ?>
                                    <span><?php echo ucwords($skill); ?> </span>
                                <?php } ?>
                            </div>
                            <h3>Job Description</h3>
                            <ul>
                                <?php
                                foreach (json_decode($object->checkboxArray) as $job_desc) {
                                    ?>
                                    <li> <?php echo ucwords($job_desc); ?> </li>
                                <?php }
                                ?>
                            </ul>
                            <h3>Other Details</h3>
                            <p></p>
                            <h3>Education + Experience</h3>
                            <ul>
                                <?php
                                foreach (json_decode($object->qualifications_arr) as $qualifications) {
                                    ?>

                                    <li><?= $qualifications; ?></li>
                                <?php } ?>
                            </ul>
                            <h3>Employer Benefits</h3>
                            <?php if(!empty($benefits)){ ?>
                                <ul><?php foreach ($benefits as $v) { ?>
                                        <li><?= $v['benefit']; ?></li>
                                    <?php } ?>

                                </ul>
                            <?php } else { ?>
                                <ul><li>No Employee Benefits</li></ul>
                            <?php } ?>
                        </div>
                        <div class="job-overview">
                            <h3>Interview Details</h3>
                            <ul style="border:0px;">

                                <?php if ($object->interradio == 1) {
                                    ?>
                                    <li><i class="fa fa-calendar-check-o"></i><h3>Interview Dates</h3><span><?= $object->startdate; ?> To <?= $object->enddate; ?></span></li>
                                    <li><i class="fa fa-clock-o"></i><h3>Interview Time</h3><span><?= $object->interviewstarttime; ?> To <?= $object->interviewendtime; ?></span></li>
                                <?php } ?>
                                <li><i class="fa fa-map-marker"></i><h3>Interview Locations</h3><span>
                                    <?= rtrim($interview, ','); ?></span></li>
                            </ul>
                        </div>
                        <div class="share-bar">
                            <span>Share</span>
                            <a href="#" onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=http%3A//www.eygb.me/internship/' . $job_tit["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-fb">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="#" onclick="window.open('<?= Url::to('https://twitter.com/home?status=http%3A//www.eygb.me/internship/' . $job_tit["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="#" onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=http%3A//www.eygb.me/internship/' . $job_tit["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-linkedin">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a href="#" onclick="window.open('<?= Url::to('https://wa.me/?text=http%3A//www.eygb.me/internship/' . $job_tit["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-whatsapp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                            <a href="#" onclick="window.open('<?= Url::to('mailto:?&body=http%3A//www.eygb.me/internship/' . $job_tit["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-google">
                                <i class="fa fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="job-single-head style2">
                        <div class="job-thumb">
                            <?php
                            if (!empty(Yii::$app->user->identity->organization->logo_location)) {
                                ?>
                                <img src="<?= Url::to($logo_image); ?>" id="logo_img" alt="" />
                                <?php
                            } else {
                                ?>
                                <canvas class="user-icon" name="<?php echo ucwords(Yii::$app->user->identity->organization->name); ?>" width="125" height="125" font="55px"></canvas>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="job-head-info">
                            <h4><?= ucwords(Yii::$app->user->identity->organization->name); ?></h4>
                        </div>
                        <a href="" class="apply-job-btn apply-btn"><i class="fa fa-paper-plane"></i>Apply for Job</a>

                        <a href="<?= Url::to('/jobs/list'); ?>" title="" class="viewall-jobs">View all Jobs</a>
                        <div class="share-bar no-border">
                            <h3>Share</h3>
                            <a href="#" onclick="window.open('<?= Url::to('https://www.facebook.com/sharer/sharer.php?u=http%3A//www.eygb.me/internship/' . $job_tit["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-fb">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="#" onclick="window.open('<?= Url::to('https://twitter.com/home?status=http%3A//www.eygb.me/internship/' . $job_tit["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a href="#" onclick="window.open('<?= Url::to('https://www.linkedin.com/shareArticle?mini=true&url=http%3A//www.eygb.me/internship/' . $job_tit["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-linkedin">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a href="#" onclick="window.open('<?= Url::to('https://wa.me/?text=http%3A//www.eygb.me/internship/' . $job_tit["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-whatsapp">
                                <i class="fa fa-whatsapp"></i>
                            </a>
                            <a href="#" onclick="window.open('<?= Url::to('mailto:?&body=http%3A//www.eygb.me/internship/' . $job_tit["slug"]); ?>', '_blank', 'width=800,height=400,left=200,top=100');" class="share-google">
                                <i class="fa fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss("
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
#new_resume,#use_existing
{display:none;}
.btn-colour
{
    background: #fff;
    border: 1px solid white;
    box-shadow: 1px 1px 8px 1px;
}
.btn-col
{background:#4aa1e3}
.btn-shape
{
    line-height: 15px;
    height: 38px;
    border-radius: 19px;
    border: 1px;
}
    #logo_img
    {
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
    }
    .job-overview ul > li span {
        float: left;
        width: 100%;
        font-size: 13px;
        color: #888888;
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
    .shortlist_job,.shortlist_job:hover
    {
     color:#fff;
    }
    .shortlist_job:focus{
        color:#fff;
    }
    .col_pink
    {
    background: #ef7706;
    border-color: #ef7706;
    color: #ffffff;
    }
    .hover-change:hover {
        background: #ef7706;
        border-color: #ef7706;
        color: #ffffff;
    }");


$this->registerJs($script);
