<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>EY Email</title>
    <head>
        <style>
            body {
                font-family: 'Open Sans', Arial, Helvetica, sans-serif !important;
                font-size: 14px;
                line-height: 20px;
                color: #414141;
                margin: 0;
                padding: 0;
            }

            .wrapper {
                max-width: 700px;
                margin: 0 auto;
                background: #fff;
                border: 1px solid #eee;
                background-color: #eff2f7;
            }

            .logo {
                text-align: center;
                padding-bottom: 35px;
                background-color: #eff2f7;
            }

            .logo img {
                max-width: 140px;
                padding: 30px 0 0 0;
            }

            .shadow {
                box-shadow: 0 0 5px rgba(0, 0, 0, .2);
                padding: 30px 30px;
                margin: 0 20px;
                background: #fff;
            }

            .reciver-name, .reciver-msg {
                color: #000;
                font-size: medium;
            }

            .reciver-msg {
                padding-top: 10px;
            }

            .job-list ul {
                padding-inline-start: 0px !important;
            }

            .job-list ul li {
                list-style-type: none;
                padding: 15px 0px;
                line-height: 25px;
                border-bottom: 1px solid #eee;
            }

            .job-list ul li:last-child {
                border-bottom: none;
            }

            .job-list ul li a {
                text-decoration: none;
                color: #00a0e3;
                font-weight: bold;
                text-overflow: ellipsis;
                white-space: nowrap;
                overflow: hidden;
                display: block;
            }

            .job-list ul li a:hover {
                cursor: pointer;
            }

            .ey-link a {
                color: #fff;
                background: #00a0e3;
                text-decoration: none;
                padding: 10px 15px;
            }

            .dispalyFlex {
                display: flex;
                margin-top: 40px;
                border-top: 1px solid #eee;
            }

            .border5 {
                background-color: #eff2f7;
                text-align: center;
                padding: 10px 0 20px 0;
            }

            .appstore {
                font-size: 24px;
                font-family: lora;
                padding-top: 15px;
            }

            .appss {
                height: 70px;
                width: 175px;
            }

            .end {
                text-align: center;
            }

            .end img {
                width: 100%;
                max-width: 150px;
            }

            .icon img {
                max-width: 50px;
                margin-top: 40px;
            }

            .preferences-text {
                padding-left: 20px;
            }

            .preferences-text {
                margin-top: 20px;
            }

            .preferences-text a {
                color: #00a0e3;
                text-decoration: none;
            }

            .preferences-text p {
                margin-bottom: 5px !important;
                margin-top: 0px !important;

            }
        </style>
    </head>
<body>
<div class="wrapper">
    <div class="position-relative">
        <div class="logo">
            <a href="<?= Url::to('/', true) ?>"><img
                        src="<?= Url::to('/assets/themes/email/invitation/images/email-logo.png', 'https'); ?>"
                        class="responsive"></a>
        </div>
    </div>
    <div class="shadow">
        <div class="reciver-name">Hi <?= ucfirst($data['user_detail']['name']) ?></div>
        <div class="reciver-msg">We found some new job openings that you could be refferd to!</div>
        <div class="job-list">
            <ul>
                <?php foreach ($data['cards'] as $d) { ?>
                    <li>
                        <?php
                        if ($d['type'] == 'Jobs') {
                            $link = "job";
                        } elseif ($d['type'] == 'Internships') {
                            $link = "internship";
                        }
                        ?>
                        <a href="<?= Url::to($link . '/' . $d['slug'], 'https') ?>"><?= $d['designation'] ? $d['designation'] : $d['title'] ?>
                            @<?= $d['name'] ?>
                            , <?= $d['city'] ? $d['city'] : 'Work From Home' ?> </a>
                    </li>

                <?php } ?>
            </ul>
        </div>
        <!--        <div class="ey-link"><a href="">See All Openings</a></div>-->
        <div class="dispalyFlex">
            <div class="icon">
                <img src="<?= Url::to('/assets/themes/email/invitation/images/sf1.png', 'https'); ?>">
            </div>
            <div class="preferences-text">
                <p>Get more relevant jobs</p>
                <p>Share details of your experience and preferences to find jobs that are suited to you</p>
                <?php if (!$data['user_prefs']) { ?>
                    <a href="<?= Url::to('account/preferences', 'https') ?>">Submit your job preferences</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="border5">

        <div class="end"><img src="<?= Url::to('/assets/themes/email/invitation/images/email-logo.png', 'https'); ?>">
        </div>
        <div class="copyright">
            <div class="">Copyright © 2019 Empower Youth</div>
        </div>
    </div>
</div>
</body>
</html>

