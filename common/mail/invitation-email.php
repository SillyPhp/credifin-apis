<?php

use yii\helpers\Url;

?>
    <div class="wrapper">
        <div class="inner-wrapper">
            <div class="logo">
                <a href="<?= Url::to('/', 'https'); ?>"><img
                            src="<?= Url::to('/assets/themes/email/invitation/images/email-logo.png', 'https'); ?>"
                            alt="Empower Youth" class="responsive"></a>
            </div>
            <div class="icon">
                <a href="<?= Url::to('/', 'https'); ?>"><img
                            src="<?= Url::to('/assets/themes/email/invitation/images/invitation-icon.png', 'https'); ?>"
                            alt="Invitation" class="responsive"></a>
            </div>
            <div class="welcome-text">
                <div class="text-heading">You have a new invite!</div>
                <span>Congratulations!</span> Your friend just sent you an invite to create premium profile on
                <span class="e">Empower</span> <span class="y">Youth</span>. Please note that this invitation can be
                used by anyone And your friend could share it with someone
                else as well.
            </div>
            <div class="activate-button">
                <ul>
                    <li><a href="<?= Url::to('/signup/individual', 'https'); ?>">Claim Personal Account</a></li>
                    <li class="btn2"><a href="<?= Url::to('/signup/organization', 'https'); ?>">Claim Company
                            Account</a></li>
                </ul>
                <div class="btn1"></div>
            </div>
            <div class="welcome-text wt2">
                Please make sure you claim your premium account at the earliest.
                <div class="ending">Enjoy!</div>
            </div>

            <div class="ey-team">
                <a href="javascript:;">
                    <img src="<?= Url::to('/assets/themes/email/invitation/images/email-eyteam.png', 'https'); ?>"
                         alt="Empower Youth Team">
                </a>
            </div>
            <div class="copyright">
                <div>
                    <?= Yii::t('app', 'Copyright') . ' &copy; ' . date('Y') . ' ' . Yii::$app->params->site_name . ' ' . Yii::t('app', 'All Rights Reserved') . '.'; ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
        * {
            margin: 0;
            padding: 0;
        }
        img + div{
            display:none;
        }

        body {
            font-family: open sans, arial;
            font-size: 13px;
            color: #4d4d4d;
            font-family: Times New Roman, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif;
        }

        .responsive {
            width: 100%;
        }

        .wrapper {
            max-width: 600px;
            margin: 0 auto;
            background: #ff5c48;
            padding: 15px 10px;
        }

        .inner-wrapper {
            background: #fff;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 0px 10px rgba(68, 67, 67, 0.4);
        }

        .logo img {
            max-width: 175px;
            padding: 30px 0 0 0;
        }

        .icon img {
            max-width: 250px;
            padding: 40px 0 0 0;
        }

        .com-name {
            padding: 10px 0 0 0;
            font-weight: bold;
            font-size: 28px;
            color: #000;
        }

        .welcome-text {
            padding: 20px 30px 0 30px;
            font-size: 19px;
            line-height: 30px;
            text-align: justify;
            color: #000;
        }

        .wt2 {
            padding-top: 50px;
        }

        .activate-button {
            padding: 45px 15px 0px 15px;
            text-align: center;
        }

        .activate-button ul li {
            margin-bottom:35px;
            list-style-type:none;
        }

        .activate-button ul li a {
            padding: 15px 10px;
            color: #fff;
            background: #00a0e3;
            border-radius: 8px;
            font-size: 16px;
            text-decoration: none;
            margin-bottom:20px;
        }

        .btn2 {
            margin-top: 40px
        }

        .ey-team {
            padding: 40px 0 0 0;
        }

        .ey-team img {
            max-width: 220px;
        }

        .copyright {
            padding: 10px 0 10px 0;
            font-size: 13px;
            color:#000;
        }

        .last-list {
            padding: 5px 0 10px 0;
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

        .text-heading {
            font-weight: bold;
            padding-bottom: 20px;
        }

        .welcome-text span {
            font-weight: bold;
        }

        .e {
            color: #00a0e3;
        }

        .y {
            color: #ff7803;
        }

        .ending {
            padding-top: 20px;
        }
        ', ['media' => 'screen']);
$this->registerCss('
        @media (max-width: 630px) {
            .activate-button ul li {
                display: block;
            }
        }
        @media (max-width: 500px) {
            .welcome-text {
                padding: 20px 30px 0 30px;
            }

            .activate-button a {
                width: 100%;
            }

            .btn2 {
                margin-top: 40px;
            }
        }
        @media (max-width: 405px) {
            .activate-button {
                padding: 45px 0px 0px 0px;
                text-align: center;
            }
            .icon img {
                max-width: 180px;
                padding: 40px 0 0 0;
            }
            .wt2 {
                padding-top: 50px;
            }
        }
        @media (max-width: 321px) {
            .activate-button ul li a {
                padding: 15px 10px
            }
        }
', ['media' => 'only screen and (max-device-width: 630px), only screen and (max-width: 500px), only screen and (max-width: 405px), only screen and (max-width: 321px)']);