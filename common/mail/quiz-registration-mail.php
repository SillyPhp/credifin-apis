<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <title></title>
    <style type="text/css">
        a, h1, h2, h3, h4, h5, h6, p {
            margin: 0;
        }

        img + div {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .quiz-registration-mail {
            max-width: 650px;
            margin: auto;
        }

        .logo, .content, .mid-content, .quiz-recommendations {
            width: 90%;
            margin: auto;
        }

        .quiz-vector {
            width: 100%;
        }

        .logo img {
            width: 200px;
        }

        .quiz-vec {
            text-align: center;
        }

        .quiz-vec img {
            width: 100%;
        }

        .c-text {
            padding: 10px 15px 0;
        }

        .c-text p {
            font-family: open Sans;
            text-align: center;
            font-size: 16px;
            letter-spacing: 0.3px;
            color: #000;
            line-height: 28px;
        }

        .m-content {
            text-align: center;
            background-color: #e2f2f1;
            padding: 18px;
        }

        .m-content p {
            font-family: open sans;
            font-size: 16px;
            color: #000;
            letter-spacing: 0.3px;
            font-weight: bold;
        }

        .quiz-rec {
            margin-bottom: 10px;
        }

        .quiz-rec p {
            font-size: 16px;
            color: #000;
            font-weight: bold;
            letter-spacing: 0.3px;
            padding: 10px 0px;
            font-family: open sans;
        }

        .q-rec td img {
            width: 100%;
            border-radius: 6px;
        }

        .rec-text {
            padding: 10px 5px;
        }

        .rec-text p {
            font-size: 14px;
            padding: 0 !important;
            font-weight: 500;
            text-align: left;
            line-height: 20px;
            margin: 0;
            text-transform: capitalize;
            color: #484848;
            font-family: open sans;
        }

        .footer {
            background-color: #1B6285;
        }

        .footer td {
            padding: 10px;
        }

        .play-img {
            width: 120px;
        }

        .ey-team-img {
            width: 150px;
        }

        .logo-copyright p {
            font-family: 'Open Sans';
            font-size: 14px;
            color: #fff;
            font-weight: 500;
        }
    </style>
</head>
<body>
<table class="quiz-registration-mail">
    <tr>
        <td>
            <table class="logo">
                <tr>
                    <td style="text-align: right;padding: 10px 15px;">
                        <a href="https://www.empoweryouth.com/"><img
                                    src="https://www.empoweryouth.com/assets/themes/email/images/XGpD9mA68oPlZvBAknjzoBVl4kwJne.png"></a>
                    </td>
                </tr>
            </table>

            <table class="quiz-vector">
                <tr>
                    <td class="quiz-vec">
                        <img src="<?= $data['sharing_image'] ?>">
                    </td>
                </tr>
            </table>

            <table class="content">
                <tr>
                    <td class="c-text">
                        <p>Your registration for <b><?= $data['quiz_name'] ?></b> is Successful!</p>
                    </td>
                </tr>
            </table>

            <?php if ($data['quiz_start_datetime']) { ?>
                <table class="mid-content" style="margin-top: 20px; margin-bottom: 20px;">
                    <tr>
                        <td class="m-content">
                            <p>Date: <?= $data['quiz_start_datetime'] ?></p>
                        </td>
                    </tr>
                </table>
            <?php } ?>

            <?php if ($data['similar_quizzes']) { ?>
                <table class="quiz-recommendations">
                    <tr>
                        <td class="quiz-rec">
                            <p>You may also check</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="q-rec">
                                <tr>
                                    <?php foreach ($data['similar_quizzes'] as $val) { ?>
                                        <td style="padding: 10px;">
                                            <a href=""><img
                                                        src="<?= $val['sharing_image'] ?>"></a>
                                            <div class="rec-text">
                                                <p><?= $val['name'] ?></p>
                                            </div>
                                        </td>
                                    <?php } ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            <?php } ?>
            <table class="footer">
                <tr>
                    <td>
                        <table class="social">
                            <tr>
                                <td>
                                    <a href="https://www.facebook.com/empower/" target="_blank"><img
                                                src="https://www.empoweryouth.com/assets/themes/email/images/n9lYWbywLRkn75m8qvzbQE854A1z7M.png"></a>
                                    <a href="https://twitter.com/EmpowerYouthin" target="_blank"><img
                                                src="https://www.empoweryouth.com/assets/themes/email/images/ZBW1zjDgOQXwN59Y87NldAw80vrkMx.png"></a>
                                    <a href="https://www.instagram.com/empoweryouth.in/" target="_blank"><img
                                                src="https://www.empoweryouth.com/assets/themes/email/images/g2PlVzA0MQ18VnYJJAWxdbZ8yqE9ON.png"></a>
                                    <a href="https://www.linkedin.com/company/empoweryouth/" target="_blank"><img
                                                src="https://www.empoweryouth.com/assets/themes/email/images/jmXaKq76pdwG9nWzwnped9gMN83Bbv.png"></a>
                                </td>
                                <td style="text-align: right;">
                                    <a href="https://play.google.com/store/apps/details?id=com.empoweryouth.app"
                                       title="Get it on Google Play" target="_blank">
                                        <img alt="Get it on Google Play" class="play-img"
                                             src="https://play.google.com/intl/en/badges/images/generic/en_badge_web_generic.png"
                                             title="Download Empower Youth App on Google Play">
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <table class="logo-copyright">
                            <tr>
                                <td style="text-align: center;">
                                    <a href="https://www.empoweryouth.com/">
                                        <img class="ey-team-img"
                                             src="https://www.empoweryouth.com/assets/themes/email/images/DeBxPEjOGdjymqkD7DqBopqANyVYw9.png">
                                    </a>
                                    <p>Copyright © 2021 Empower Youth</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>