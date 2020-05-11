<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->params['header_dark'] = false;
?>
    <section class="inner-header-page">
        <div class="container">
            <div class="col-md-8 col-sm-8">
                <div class="left-side-container">
                    <div class="freelance-image">
                        <?php
                        $name = $image = NULL;
                        if (!empty($user['image'])) {
                            $image = Yii::$app->params->upload_directories->users->image . $user['image_location'] . DIRECTORY_SEPARATOR . $user['image'];
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
                        if ($user['user_enc_id'] === Yii::$app->user->identity->user_enc_id) {
                            ?>
                            <a href="<?= Url::to('/' . $user['username'] . '/edit'); ?>" class="edit-profile-btn"
                               target="_blank">Edit Profile</a>
                            <?php
                            if (!empty($userCv)) {
                                $cv = Yii::$app->params->upload_directories->resume->file . $userCv['resume_location'] . DIRECTORY_SEPARATOR . $userCv['resume'];
                                ?>
                                <a href="<?= $cv ?>" class="edit-profile-btn" target="_blank">Download CV</a>
                            <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 bl-1 br-gary">
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
                    </ul>
                    <ul class="social-info">
                        <?php if (!empty($user['facebook'])) { ?>
                            <li>
                                <a href="https://www.facebook.com/<?= Html::encode($user['facebook']) ?>"
                                   target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                        <?php }
                        if (!empty($user['twitter'])) { ?>
                            <li>
                                <a href="https://www.twitter.com/<?= Html::encode($user['twitter']) ?>" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                        <?php }
                        if (!empty($user['linkedin'])) { ?>
                            <li>
                                <a href="https://www.linkedin.com/in/<?= Html::encode($user['linkedin']) ?>"
                                   target="_blank">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </li>
                        <?php }
                        if (!empty($user['skype'])) { ?>
                            <li>
                                <a href="https://www.skype.com/<?= Html::encode($user['skype']) ?>" target="_blank">
                                    <i class="fab fa-skype"></i>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="log-btn1">
                <?php
                if (!Yii::$app->user->identity->user_enc_id) {
                    ?>
                    <a href="javascript:;" data-toggle="modal" data-target="#loginModal" class="btn btn-info new-set">Login to view complete profile</a>
                    <?php
                } else {
                    ?>
                    <div class="log-text1">You have to be an organization user to view the details</div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <section class="detail-section">
        <div class="container">
            <div class="col-md-8 col-sm-8">
                <div class="container-detail-box">
                    <div class="apply-job-header">
                        <h4 class="capitalize"><?= $user['first_name'] . " " . $user['last_name'] ?></h4>
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
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                            voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    </div>
                    <div class="apply-job-detail">
                        <h5>Skills</h5>
                        <ul class="skills">
                            <?php
                            if ($skills) {
                                foreach ($skills as $sk) { ?>
                                    <li>XXXXXX XXXXXXXX</li>
                                    <?php
                                }
                            } else {
                                echo "<li>--</li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="apply-job-detail">
                        <h5>Spoken Languages</h5>
                        <ul class="skills">
                            <?php
                            if ($language) {
                                foreach ($language as $lg) { ?>
                                    <li>XXXXXX</li>
                                    <?php
                                }
                            } else {
                                echo "<li>--</li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="container-detail-box">
                    <div class="education-detail">
                        <div class="education-head">Education</div>
                        <?php
                        foreach ($education as $edu) {
                            ?>
                            <div class="set">
                                <div class="uni-name s-text"><i class="fas fa-university"></i>XXXXXX XXXX XXXX
                                </div>
                                <div class="quelification s-text"><i
                                            class="fas fa-user-graduate"></i>XXXXXXX XXXXXXXXXX (XXXXXXXXX)
                                </div>
                                <div class="s-time s-text"><i
                                            class="fas fa-clock"></i> XXXX - XXXX
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="experience-detail">
                        <div class="education-head">Work Experience</div>
                        <?php
                        foreach ($experience as $exp) {
                            ?>
                            <div class="set">
                                <div class="uni-name s-text"><i
                                            class="fas fa-hotel"></i>XXXX XXXXXXX XXXXXXX XXX XXX , XXXXXXXXX
                                </div>
                                <div class="quelification s-text"><i class="fas fa-briefcase"></i> XXX XXXXXXXXXX
                                </div>
                                <div class="s-time s-text"><i
                                            class="fas fa-calendar-alt"></i> XX/XX/XXXX to XX/XX/XXXX
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="achievements-detail set-li">
                        <div class="education-head">Achievements</div>
                        <ul>
                            <?php
                            foreach ($achievement as $achive) {
                                ?>
                                <li>XXXXXXXX XXXXX</li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="hobbies-detail set-li">
                        <div class="education-head">Hobbies</div>
                        <ul>
                            <?php
                            foreach ($hobbies as $hobby) {
                                ?>
                                <li>XXXXXXXXX</li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="Interests-detail set-li">
                        <div class="education-head">Interests</div>
                        <ul>
                            <?php
                            foreach ($interests as $intrst) {
                                ?>
                                <li>XXXXXXXXXXX</li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($job_preference)) {
                ?>
                <div class="sidebar-container" style="border: 2px solid #ff7803;border-bottom: 3px solid #ff7803;">
                    <div class="prefer" style="background-color:#ff7803; color:#fff;">Job Preferences</div>
                    <div class="prefer-detail">
                        <ul>
                            <li><span class="set-width">Profile</span><span
                                        class="position">XXXXXXXXXXXX, XXXXXX</span>
                            </li>
                            <li><span class="set-width">Type</span><span
                                        class="position">XXXX XXXX</span></li>
                            <li><span class="set-width">City</span><span
                                        class="position">XXXXXXXX, XXXXXXX, XXXXXXXXXX</span>
                            </li>
                            <li><span class="set-width">Skills</span><span
                                        class="position">XXXXX, XXXXXXXXXXXX, XXXXXXXXXX, XXXX</span>
                            </li>
                            <li><span class="set-width">Industry</span><span
                                        class="position">XXXXXXXXXXXX, XXXXXXXX & XXXXXXX XXX XXX, XXXXX</span>
                            </li>
                            <li><span class="set-width">Experience</span><span
                                        class="position">X-X year('s)</span>
                            </li>
                            <li><span class="set-width">Working Days</span><span
                                        class="position">XXX, XXX, XXX, XXX, XXX, XXX, XXX</span>
                            </li>
                            <li><span class="set-width">Timings</span><span
                                        class="position">XX:XX AM to XX:XX PM </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
            }
            if (!empty($internship_preference)) {
                ?>
                <div class="sidebar-container" style="border: 2px solid #00a0e3;border-bottom: 3px solid #00a0e3;">
                    <div class="prefer" style="background-color:#00a0e3; color:#fff;">Internship Preferences</div>
                    <div class="prefer-detail">
                        <ul>
                            <li><span class="set-width">Profile</span><span
                                        class="position">XXXXXXXXXXXX, XXXXXX</span>
                            </li>
                            <li><span class="set-width">Type</span><span
                                        class="position">XXXX XXXX</span></li>

                            <li><span class="set-width">City</span><span
                                        class="position">XXXXXXXX, XXXXXXX, XXXXXXXXXX</span>
                            </li>
                            <li><span class="set-width">Skills</span><span
                                        class="position">XXXXX, XXXXXXXXXXXX, XXXXXXXXXX, XXXX</span>
                            </li>
                            <li><span class="set-width">Industry</span><span
                                        class="position">XXXXXXXXXXXX, XXXXXXXX & XXXXXXX XXX XXX, XXXX</span>
                            </li>
                            <li><span class="set-width">Working Days</span><span
                                        class="position">XXX, XXX, XXX, XXX, XXX, XXX, XXX</span>
                            </li>
                            <li><span class="set-width">Timings</span><span
                                        class="position">XX:XX AM to XX:XX PM </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <!--End Sidebar-->
        </div>
    </section>
<?php
$this->registerCss('
.log-btn1 a{
    position: absolute;
    left: 50%;
    bottom: -20px;
    z-index: 999;
    transform: translate(-50%); 
}
.log-text1{
    position: absolute;
    left: 50%;
    bottom: -20px; 
    z-index: 999;
    transform: translate(-50%); 
    font-size: 18px;
    font-family: roboto;
    padding: 5px 20px !important;
    color: red;
    border: 1px solid;
    background: #fff;
}
.new-set {
    font-size: 18px;
    font-family: roboto;
    padding: 5px 20px !important;
//    color: red;
}
.detail-section{
    filter: blur(5px);
    -webkit-filter: blur(5px);
}
.education-head {
    font-size: 18px;
    font-weight: 500;
    font-family: roboto;
    padding-bottom: 3px;
    letter-spacing: 1px;
}
.education-detail, .experience-detail, .achievements-detail, .Interests-detail, .hobbies-detail {
    padding-bottom: 20px;
}
.set {
    margin-bottom: -1px;
    padding: 10px 0;
    border-bottom: 1px solid #dddddd;
}
.s-text {
    font-size: 14px;
    font-family: roboto;
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
    margin: 0 5px 0 0;
    font-weight: 500;
    color: #657180;
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
    padding-top:50px;
}
.prefer-detail > ul > li{
    font-size: 14px;
    font-family: sans-serif;
    padding-bottom:10px;
}
.set-width {
    width: 40%;
    display: inline-block;
}
.position {
    width: 60%;
    display: inline-flex;
}
.prefer {
    font-size: 20px;
    font-family: sans-serif;
    text-align: center;
    background: #eee;
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
}
.set-color{
    background: #ff7803;
    padding: 5px 15px;
    margin-left: -15px;
    color: #fff;
}
.edit-profile-btn{
    text-align: center;
    background-color: #00a0e3;
    color: #fff;
    padding: 5px 25px;
    box-shadow: 0px 1px 12px 1px #a5a5a5;
    border-radius: 4px;
    margin-top: 2px;
    font-size: 13px;
    display: inline-block;
}
.edit-profile-btn:hover, .edit-profile-btn:focus{
    background-color:#0392ce;
    color:#fff;
}
.freelance-image img{
    width:100%;
    height:88%;
}
 .inner-header-page{
    padding:150px 0 50px;
	text-align:left;
	background:#f5f6f7;
    border-bottom:2px solid #00a0e3;	
}
.left-side-container {
    display: table;
    width: 100%;
}
.bl-1 {
    border-left: 1px solid #00a0e3 !important;
}
.inner-header-page .freelance-image {
    height: 160px;
    flex: 0 0 140px;
    margin-right: 35px;
    background: #fff;
    border-radius: 4px;
    box-shadow: 0 3px 12px rgba(0,0,0,.1);
    display: inline-block;
    padding: 0 20px;
    line-height: 140px;
    float: left;
}
.inner-header-page .freelance-image img, .inner-header-page .freelance-image canvas{
	max-width:140px;
	margin-top:10px;
}
.header-details h4{
	margin:0 0 5px 0;
	font-size:24px;
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
    margin-bottom: 12px;
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
    margin-top: 20px;
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
}
.right-side-detail ul.social-info li{
	display:inline-block;
	margin:5px;
}
.right-side-detail ul.social-info li a {
    width: 40px;
    height: 40px;
    display: inline-block;
    background: #e3e8ec;
    text-align: center;
    line-height: 40px;
    border-radius: 2px;
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
    border: 1px solid #eaeff5;
}
.apply-job-detail{
	margin-bottom:30px;
}
.apply-job-detail h5{
	font-size:18px;
}
.apply-job-header a {
    margin-right: 15px;
}
.apply-job-header a i, .apply-job-header span i {
    margin-right: 5px;
}
.apply-job-header {
    margin-bottom: 40px;
}
.apply-job-header h4{
	font-size:22px;
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
    font-weight: 500;
    color: #657180;
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
.sidebar-container{
    background: #ffffff;
    overflow: hidden;
    margin-bottom:30px;
	position:relative;
	transition: .4s;
    padding: 0px 15px 10px 15px;
    border: 1px solid #eee;
    border-radius:5px;
}
.sidebar-container:hover, .sidebar-container:focus{
    transform: translateY(-5px);
    -webkit-transform: translateY(-5px);
	cursor:pointer;
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
@media screen and (max-width: 525px){
    .header-details {
        margin-top: 0px;
        display: inherit;
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
');