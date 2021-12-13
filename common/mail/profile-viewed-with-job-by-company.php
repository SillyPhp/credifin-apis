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

        .bold-font {
            font-weight: bold;
        }

        .candidate-profile-view-main {
            max-width: 650px;
            margin: auto;
        }

        .logo, .view-profile-img, .content {
            width: 90%;
            margin: auto;
        }

        .logo img {
            width: 200px;
        }

        .v-img {
            text-align: center;
            padding: 15px;
        }

        .v-img img {
            width: 100%;
            max-width: 400px;
        }

        .description {
            text-align: center;
            padding: 15px;
        }

        .description p {
            font-family: Open Sans;
            font-size: 16px;
            line-height: 26px;
            letter-spacing: 0.3px;
            color: #000;
        }

        .complete-btn a {
            font-family: Open Sans;
            display: block;
            padding: 10px 25px;
            border: 2px solid #6da8df;
            border-radius: 4px;
            width: fit-content;
            margin: auto;
            color: #fff;
            font-weight: bold;
            background-color: #6da8df;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .more-jobs {
            text-align: center;
        }

        .more-jobs p {
            font-size: 16px;
            font-family: open sans;
            letter-spacing: 0.3px;
            font-weight: 600;
            color: #000;
            padding: 10px;
        }

        .more-jobs img {
            padding: 15px;
            height: 150px;
            max-width: 250px;
        }

        .more-jobs button {
            font-family: Open Sans;
            display: block;
            padding: 6px 20px;
            border: 2px solid #6da8df;
            border-radius: 4px;
            width: fit-content;
            margin: auto;
            color: #fff;
            font-weight: bold;
            background-color: #6da8df;
            margin-bottom: 20px;
        }

        .more-jobs button a {
            text-decoration: none;
            color: #fff;
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
    <title></title>
</head>
<body>
<table class="candidate-profile-view-main">
    <tr>
        <td>
            <table class="logo">
                <tr>
                    <td style="text-align: right;padding: 10px 15px;">
                        <img src="https://www.empoweryouth.com/assets/themes/email/images/XGpD9mA68oPlZvBAknjzoBVl4kwJne.png">
                    </td>
                </tr>
            </table>

            <table class="view-profile-img">
                <tr>
                    <td class="v-img">
                        <img src="https://www.empoweryouth.com/assets/themes/email/images/k4x1rvbEZd3ybgOOlJGPRaY7p5gXMV.png">
                    </td>
                </tr>
            </table>

            <table class="content">
                <tr>
                    <td class="description">
                        <p>
                            Your <?=(($data['type'] == 'Jobs') ? 'Job' : 'Internship');?> application for the <span class="bold-font"><?=$data['name']?> position</span> in <span
                                    class="bold-font"><?=$data['org_name']?></span> has been viewed by them. Please <span
                                    class="bold-font">complete</span> all the <span class="bold-font">professional and personal details</span>
                            in your profile to leave a great impression on the recruiter.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="complete-btn"><a href="https://www.empoweryouth.com/<?=$data['username'];?>/edit">Complete Profile</a></td>
                </tr>
            </table>

            <table class="explorejobs">
                <tr>
                    <td class="more-jobs">
                        <p>More Jobs on Empoweryouth</p>
                        <img src="https://www.empoweryouth.com/assets/themes/email/images/jKbDalL5YRxwG6Z7xzgLQGqgwrkA06.png">
                        <button><a href="https://www.empoweryouth.com/jobs/list">View</a></button>
                    </td>
                    <td class="more-jobs">
                        <p>Drop Resume</p>
                        <img src="https://www.empoweryouth.com/assets/themes/email/images/Nxj6lKYbJdDjOaELNjM4Rvg5VrAZ3y.png">
                        <button><a href="https://www.empoweryouth.com/organizations">View</a></button>
                    </td>
                </tr>
            </table>

            <table class="footer">
                <tr>
                    <td>
                        <table class="social">
                            <tr>
                                <td>
                                    <a href="https://www.facebook.com/empower/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/n9lYWbywLRkn75m8qvzbQE854A1z7M.png"></a>
                                    <a href="https://twitter.com/EmpowerYouthin" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/ZBW1zjDgOQXwN59Y87NldAw80vrkMx.png"></a>
                                    <a href="https://www.instagram.com/empoweryouth.in/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/g2PlVzA0MQ18VnYJJAWxdbZ8yqE9ON.png"></a>
                                    <a href="https://www.linkedin.com/company/empoweryouth/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/jmXaKq76pdwG9nWzwnped9gMN83Bbv.png"></a>
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