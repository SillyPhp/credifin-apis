<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Lora&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300&display=swap" rel="stylesheet">
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: open sans;
        }

        .border {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
        }

        .new-img-set img {
            width: 100%;
            margin-top: 20px;
        }

        .border2 {
            background: white;
        }

        .part, .part2 {
            display: inline-block;
            padding-left: 20px;
        }

        .part2 {
            padding-left: 40px;
        }

        .responsive {
            width: 100%;
        }

        .logo {
            text-align: center;
            padding: 20px 0 0 0px;
        }

        .logo img {
            max-width: 140px;
        }

        .icon img {
            max-width: 250px;
            padding: 40px 0 0 0;
        }

        .text {
            padding: 20px 30px 0 30px;
            font-size: 16px;
            line-height: 25px;
            text-align: justify;
            color: #000;
            font-family: 'Roboto', sans-serif;
        }

        .text-heading {
            font-weight: bold;
            padding-bottom: 10px;
            text-align: left;
            font-size: 18px;
            font-family: 'Roboto', sans-serif;
        }

        .e {
            font-weight: bold;
        }

        .f {
            padding-left: 10px;
            font-family: 'Roboto', sans-serif;
        }

        .btn a {
            text-align: center;
            display: inline-block;
            padding: 5px 25px;
            background: #00a0e3;
            border-radius: 5px;
            font-size: 15px;
            color: #fff;
            text-decoration: none;
        }

        .info .btn {
            margin-top: 20px;
        }

        .info {
            margin: 30px 0;
            text-align: center;
        }

        .newlogo {
            text-align: center;
            margin: auto;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 1px solid #eff2f7;
        }

        .newlogo img {
            max-width: 70px;
            max-height: 70px;
        }

        .job-ds {
            font-weight: bold;
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
            text-transform: capitalize;
            padding-top: 10px;
        }

        .com-location {
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
            text-transform: capitalize;
            padding-top: 10px;
        }

        .com-skills {
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
            text-transform: capitalize;
            padding-top: 10px;
        }

        .salary {
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
            text-transform: capitalize;
            padding-top: 10px;
        }

        .end img {
            width: 100%;
            max-width: 150px;
        }

        .job-info {
            margin-top: 20px;
            text-align: left;
            padding: 20px 0 0 30px;
            font-weight: bold;
            font-family: 'Roboto', sans-serif;
            font-size: 18px;
            color: #00a0e3;
        }

        .copyright {
            padding: 5px 0 10px 0;
            font-size: 10px;
            text-align: center;
        }

        .btn1 a {
            text-align: center;
            display: inline-block;
            padding: 5px 25px;
            background: #00a0e3;
            border-radius: 5px;
            font-size: 15px;
            color: #fff;
            text-decoration: none;
        }

        .text-center {
            text-align: center;
            padding: 20px 0;
            width: 100%;
        }

        .ey-team {
            padding: 20px 0 0 0;
        }

        .ey-team img {
            max-width: 220px;
        }

        .copyright {
            padding: 0px 0 0 0;
            font-size: 13px;
        }

        .last-list {
            padding: 0px 0 10px 0;
            font-size: 13px;
        }

        .last-list ul {
            padding-inline-start: 10px;
        }

        .last-list ul li {
            list-style-type: none;
            display: inline;
            padding: 15px 5px;
        }

        .last-list ul li a {
            color: #00a0e3;
            text-decoration: none;
        }

        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #00a0e3;
            padding: 30px 50px;
        }

        @media (max-width: 500px) {
            .text {
                padding: 20px 30px 0 30px;
            }

            .last-list ul {
                margin: 0px;
                padding: 0px;
            }
        }

        @media (max-width: 450px) {
            .logo img {
                max-width: 120px;
            }

            .end img {
                max-width: 180px;
            }

            .job-ds {
                position: relative;
                left: 0px !important;
                font-size: 15px;
            }

            .text {
                font-size: 15px;
            }

            .text-heading {
                font-size: 17px;
            }

            .job-info {
                text-align: center;
                padding-right: 30px;
                font-size: 16px;
            }

            .com-location {
                position: relative;
                left: 0px !important;
                padding: 10px 0 0 0;
                font-size: 15px;
            }

            .newlogo {
                margin: 20px auto;
            }

            .com-skills {
                position: relative;
                left: 0px !important;
                font-size: 15px;
            }

            .salary {
                position: relative;
                left: 0px !important;
                font-size: 15px;
            }

            .newlogo {
                width: 65px;
                height: 65px;
            }

            .newlogo img {
                max-width: 60px;
                max-height: 60px;
            }

            img + div {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="border">
        <div class="position-relative">
            <div class="logo">
                <a href="<?= Url::to('/', true) ?>"><img
                            src="<?= Url::to('@commonAssets/email_service/email-logo.png', 'https'); ?>"
                            class="responsive"></a>
            </div>
        </div>
        <div class="new-img-set"><img src="<?= Url::to('@commonAssets/email_service/shortlisticon.png', 'https'); ?>">
        </div>
        <div class="border2">
            <div class="text">
                <div class="text-heading">Hi <?= $data['user_name'] ?></div>
                <span>Congratulations! You have been shortlisted for<span class="e"> <?= $data['title'] ?></span> role at the<span
                            class="e"> <?= $data['org_name'] ?></span>.
                    If you are interested to work in this company kindly send them your resume and your full Details so that they will invite you to an interview for further consideration.
                   </span>
            </div>

            <div class="job-info">Job Information</div>
            <div class="info">
                <div class="newlogo"><img
                            src="<?= Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '/' . $data['logo_location'] . '/' . $data['logo']; ?>">
                </div>
                <div class="job-ds"><?= $data['title'] ?></div>
                <?php if ($data['city']) { ?>
                    <div class="com-location"><img
                                src="<?= Url::to('@commonAssets/email_service/location1.png', 'https'); ?>"
                                height="15px"
                                width="15px"><span
                                class="f"><?= $data['city'] ?></span>
                    </div>
                <?php } ?>
                <?php if ($data['skills']) { ?>
                    <div class="com-skills"><img
                                src="<?= Url::to('@commonAssets/email_service/skills.png', 'https'); ?>"
                                height="15px" width="15px"><span class="f"><?= $data['skills'] ?></span>
                    </div>
                <?php } ?>
                <?php if ($data['salary']) { ?>
                    <div class="salary"><img src="<?= Url::to('@commonAssets/email_service/salary.png', 'https'); ?>"
                                             height="16px" width="14px"><span class="f"><?= $data['salary'] ?></span>
                    </div>
                <?php } ?>
                <?php if ($data['type'] == 'Jobs') { ?>
                    <div class="btn"><a href="<?= Url::to('/job/' . $data['slug'], 'https') ?>">View Job</a></div>
                <?php } elseif ($data['type'] == 'Internships') { ?>
                    <div class="btn"><a href="<?= Url::to('/internship/' . $data['slug'], 'https') ?>">View Job</a>
                    </div>
                <?php } ?>

            </div>
        </div>
        <div class="text-center">
            <div class="ey-team">
                <img src="<?= Url::to('@commonAssets/email_service/email-eyteam.png', 'https'); ?>"/>
            </div>
            <div class="copyright">
                <div class="">Copyright © 2019 Empower Youth</div>
            </div>
            <div class="last-list">
                <ul>
                    <li><a href="<?= Url::to('/contact-us', true) ?>">Contact Us</a></li>
                    |
                    <li><a href="<?= Url::to('/terms-conditions', true) ?>">Terms and Conditions</a></li>
                    |
                    <li><a href="<?= Url::to('/privacy-policy', true) ?>">Privacy Policies</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>