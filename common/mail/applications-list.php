<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

    <div class="wrapper-outer">
        <div class="wrapper">
            <div class="wrapper-header">
                <div class="header-logo"><a href=""><img
                                src="<?= Url::to('@commonAssets/email_service/email-logo.png', 'https'); ?>"
                                class="responsive"></a></div>
                <div class="header-icon"><a href=""><img
                                src="<?= Url::to('@commonAssets/email_service/header-image.png', 'https'); ?>"
                                class="responsive"></a></div>
            </div>
            <?php if (is_array($data['jobs']) && count($data['jobs']) > 0): ?>
                <div class="jboxs">
                    <div class="job-heading">Top Jobs</div>

                    <?php foreach ($data['jobs'] as $jobs) { ?>

                        <div class="job-box">
                            <div class="width-30">
                                <div class="logo-box">
                                    <div class="logo">
                                        <a href="<?= Url::to($jobs['organization_link'], 'https'); ?>" ><img src="<?= Url::to($jobs['organization_logo'], 'https'); ?>"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="width-70">
                                <div class="com-details">
                                    <div class="com-name"><?= $jobs['cat_name']; ?></div>
                                    <div class="com-establish"><?= $jobs['organization_name']; ?></div>
                                </div>
                                <div class="skills-list">
                                    <ul>
                                        <li><?= $jobs['type']; ?></li>
                                        <li><?= $jobs['experience']; ?></li>
                                        <li><?= $jobs['amount']; ?></li>
                                    </ul>
                                </div>
                                <div class="job-description">
                                    <ul>
                                        <?php foreach ($jobs['applicationJobDescriptions'] as $jd) { ?>
                                            <li><?= $jd['job_description']; ?></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="last-date">
                                <div class="ld-text">Last Date To Apply</div>
                                <div class="ld-num"><?= $jobs['last_date']; ?></div>
                            </div>
                            <div class="applyBtn">
                                <a href="<?= Url::to('/job/' . $jobs['slug'], 'https'); ?>">View Job</a>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            <?php endif; ?>
            <?php if (is_array($data['internships']) && count($data['internships']) > 0): ?>
                <div class="jboxs jboxMarginTop">
                    <div class="job-heading">Top Internships</div>
                    <?php foreach ($data['internships'] as $internships) { ?>
                        <div class="job-box">
                            <div class="width-30">
                                <div class="logo-box">
                                    <div class="logo">
                                        <a href="<?= Url::to($internships['organization_link'], 'https'); ?>" ><img src="<?= Url::to($internships['organization_logo'], 'https'); ?>"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="width-70">
                                <div class="com-details">
                                    <div class="com-name"><?= $internships['cat_name']; ?></div>
                                    <div class="com-establish"><?= $internships['organization_name']; ?></div>
                                </div>
                                <div class="skills-list">
                                    <ul>
                                        <li><?= $internships['type']; ?></li>
                                        <li><?= $internships['amount']; ?></li>
                                    </ul>
                                </div>
                                <div class="job-description">
                                    <ul>
                                        <?php if (!empty($internships['applicationJobDescriptions'])) { ?>
                                            <?php foreach ($internships['applicationJobDescriptions'] as $id) { ?>
                                                <li><?= $id['job_description']; ?></li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="last-date">
                                <div class="ld-text">Last Date To Apply</div>
                                <div class="ld-num"><?= $internships['last_date']; ?></div>
                            </div>
                            <div class="applyBtn">
                                <a href="<?= Url::to('/internship/' . $internships['slug'], 'https'); ?>">View Job</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php endif; ?>
            <div class="text-center">
                <div class="ey-team">
                    <img src="<?= Url::to('@commonAssets/email_service/email-eyteam.png', 'https'); ?>">
                </div>
                <div class="copyright">
                    <?= Yii::t('app', 'Copyright') . ' &copy; ' . date('Y') . ' ' . Yii::$app->params->site_name; ?>
                </div>
                <div class="last-list">
                    <ul>
                        <li><a href="">Contact Us</a></li>
                        |
                        <li><a href="">Terms and Conditions</a></li>
                        |
                        <li><a href="">Privacy Policies</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
body{
margin:0 auto;
padding:0;
font-family: \'Open Sans\', sans-serif;

}

.wrapper-outer{
max-width:600px	;
margin:0 auto;
background: #56698F;
padding:30px 50px;
display: flex;
}
.wrapper{
background: #fff;
float: left;
border-radius: 10px;
}
.responsive{
width:100%;
}
img + div {
display:none !important;
}
.job-heading{
font-size:20px;
font-weight:bold;
padding-top:10px;
}
.jboxs{
padding:0 25px !important;
float:left;
}
.job-box{
position:relative;
border:1px solid #eee;
border-radius:10px;
padding:10px 15px;
float:left;
max-width: 518px;
width:100%;
margin-bottom:10px;
margin-top:20px;
}
.jboxMarginTop{
margin-top:30px;
}
.last-date{
padding-top:15px;
font-size: 12px;
text-align: center;
color: #999;
}

.wrapper-header{
background: url(' . Url::to('@commonAssets/email_service/wrapper-header-bg.png', 'https') . ');
background-size:cover;
background-repeat:no-repeat;
padding:30px 0;
text-align:center;
float: left;
width: 100%;
border-radius:9px;
}
.header-logo{
text-align:center;
}
.header-logo img{
max-width:200px;
}
.header-icon{
padding:50px 0;
}
.header-icon img{
max-width:300px;
}
.width-30{
width:100%;
}
.width-70{
width:100%;
float:left;
}
.com-establish{
font-size:14px;
color: #999;
}
.com-name{
font-size:17px;
font-weight:bold;
}
.com-details{
padding-top:10px;
}
.skills-list > ul{
padding-inline-start: 0px !important;
}
.skills-list > ul > li{
display:inline-block;
font-size:12px;
background:#00a0e3;
padding:5px 10px;
color:#fff;
border-radius:5px;
margin-top:5px;
}
.job-title{
color:#fff;
padding:10px 0 0 0;
font-size:25px;
font-weight:bold;
text-transform:capitalize;
}
.job-icon img{
max-width:250px;
}

.logo-box{
height:100px;
width:100px;
padding:0 0px;
background:#fff;
border-radius:50%;
display:table;
text-align:center;
border:1px solid #eee;
//        box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.6) !important;
position:relative;
float:left;
}
.logo{
display:table-cell;
vertical-align: middle;
width:100%;
}
.logo img{
max-width:80px;
}
.job-description > ul, .education > ul {
float: left;
margin-bottom: 20px;
padding-inline-start: 20px;
margin-block-start: 4px !important;
margin-block-end: 4px !important;
max-width:600px;
}

/*-----job-description-----*/
.job-description{
float:left;
}
.job-description li {
float: left;
width: 100%;
font-size: 13px;
color: #000;
line-height: 24px;
margin: 0;
margin-bottom: 19px;
}
.job-description ul{
padding-bottom:10px;
}
.job-description > ul li, .education > ul li {
float: left;
width: 100%;
margin: 0;
list-style-type:square;
margin-bottom: 0px;
line-height: 21px;
font-size: 13px;
color: #000;
}

/*----apply btn-----*/
.applyBtn{
float:left;
text-align:center;
width:100%;
margin-top: 15px;
margin-bottom: 15px;
}

.applyBtn a{
text-align:center;
color:#fff;
font-size:13px;
background:#00a0e3;
padding:10px 25px;
text-decoration:none;
text-transform:uppercase;
border-radius:5px;
}
.text-center{
float:left;
text-align:center;
padding:20px 0;
width:100%;
}
.ey-team{
padding:20px 0 0 0;
}
.ey-team img{
max-width:220px;
}
.copyright{
padding:0px 0 0 0;
font-size:13px;
}
.last-list{
padding: 0px 0 10px 0;
font-size: 13px;
}
.last-list ul{
padding-inline-start: 10px;
}
.last-list ul li{
list-style-type:none;
display:inline;
padding:15px 5px;

}
.last-list ul li a{
color:#00a0e3;
text-decoration:none;
}



@media only screen and (max-width: 670px ){
    .width-30{
        width:100%;
    }
    .width-70{
        width:100%;
    }
    .job-box{
        text-align:center;
        margin: 15px 10px;
    }
    .job-description li{
        text-align:left;
    }
    .logo-box{
        float:none;
        margin: 0 auto;    
    }
}
@media only screen and (max-width: 500px ){
    .skills-list ul li{
        margin-bottom: 5px;
    }
    .last-date{
        position: relative;
    }

}
@media only screen and(max-width: 420px){
    .applyBtn{
        display: grid;
    }
    .applyBtn a{
        margin-bottom:5px;
    }
    .wrapper-outer{
        padding:30px 10px;
    }
    .width-30{
        width:100%;
    }
    .width-70{
        width:100%;
    }
}
@media only screen and (max-width: 380px){
    .wrapper-outer{
        padding:30px 10px !important;
    }
    .jboxs{
        padding:0 10px;
    }
    .job-box{
        max-width:270px;
        text-align:center;
    }
    .width-30{
        width:100% !important;
      
    }
    .width-70{
        width:100% !important;
    }
    .skills-list ul{
        padding-inline-start: 0px;
    }
}

');

?>