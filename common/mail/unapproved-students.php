<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        img{
            max-width: 100%;
        }
        h1, h2, h3, h4, h5, h6, p, a{
            margin: 0;
            text-decoration: none;

        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        .unapproved-mail-main{
            max-width: 650px;
            margin: auto;
        }
        .logo, .header-img, .content-background, .content, .footer{
            width: 95%;
            margin: auto;
        }
        .logo img {
            width: 150px;
            padding: 10px;
        }
        .content-bg {
            background: url('https://www.empoweryouth.com/assets/themes/email/images/M39pOaLxn1RybbL2ywjYowrK85kq6m.png'), #E5F7FD;
            background-size: 100%;
            background-repeat: no-repeat;
            margin: 10px auto;
            border-radius: 10px;
            max-width: 600px;
        }
        .hd-img {
            text-align: center;
            padding: 20px;
        }
        .hd-img img {
            width: 100%;
            max-width: 160px;
        }
        .description h3 {
            font-size: 20px;
            font-weight: bold;
            font-family: Open Sans;
            text-align: center;
            text-transform: capitalize;
            color: #000;
            margin-bottom: 10px;
        }
        .description p {
            line-height: 24px;
            letter-spacing: 0.5px;
            text-align: center;
            font-family: Open Sans;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .view-btn a {
            border: 1px solid #00a0e3;
            background-color: #00a0e3;
            color: #fff;
            text-decoration: none;
            padding: 2px 20px;
            display: inline-block;
            border-radius: 4px;
            margin: 10px;
            transition: 0.3s ease-in;
        }
        .view-btn a:hover {
            background-color: #d6e7f1;
            color: #00a0e3;
        }
        .view-btn {
            text-align: center;
            margin-bottom: 10px;
        }
        .footer{
            background-color: #1B6285;
        }
        .footer td{
            padding: 10px;
            text-align: center;
        }
        .play-img{
            width: 120px;
        }
        .ey-team-img{
            width: 150px;
        }
        .logo-copyright p {
            font-family: 'roboto';
            font-size: 14px;
            color: #fff;
            font-weight: 500;
        }
    </style>
</head>
<body>
<table class="unapproved-mail-main">
    <tr>
        <td>
            <table class="logo" style="text-align: right;">
                <tr>
                    <td>
                        <a href="https://www.myecampus.in/"><img class="ey-logo" src="https://www.empoweryouth.com/assets/themes/email/images/Nxj6lKYbJdDjZ1nLZeLBRvg5VrAZ3y.png"></a>
                    </td>
                </tr>
            </table>

            <table class="content-background">
                <tr>
                    <td class="content-bg">
                        <table class="header-image">
                            <tr>
                                <td class="hd-img">
                                    <img src="https://www.empoweryouth.com/assets/themes/email/images/ZBW1zjDgOQXwBvJJDOvadAw80vrkMx.png">
                                </td>
                            </tr>
                        </table>

                        <table class="content">
                            <tr>
                                <td class="description">
                                    <h3>Hi {College Name}</h3>
                                    <p>The <b>number of unapproved students of your college</b> who have recently signed up on our platform have <b>crossed 10</b>. Please <b>perform the necessary action as soon as possible</b> so that they can make the best use of our platform.</p>
                                    <p>You can view the list of unapproved students by clicking below:</p>
                                    <table class="view-btn">
                                        <tr>
                                            <td>
                                                <a href="">
                                                    <p>View</p>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="footer">
                <tr>
                    <td>
                        <table class="social">
                            <tr>
                                <td>
                                    <a href="https://www.facebook.com/empower/"><img src="https://www.empoweryouth.com/assets/themes/email/images/n9lYWbywLRkn75m8qvzbQE854A1z7M.png"></a>
                                    <a href="https://twitter.com/EmpowerYouthin"><img src="https://www.empoweryouth.com/assets/themes/email/images/ZBW1zjDgOQXwN59Y87NldAw80vrkMx.png"></a>
                                    <a href="https://www.instagram.com/empoweryouth.in/"><img src="https://www.empoweryouth.com/assets/themes/email/images/g2PlVzA0MQ18VnYJJAWxdbZ8yqE9ON.png"></a>
                                    <a href="https://www.linkedin.com/company/empoweryouth/"><img src="https://www.empoweryouth.com/assets/themes/email/images/jmXaKq76pdwG9nWzwnped9gMN83Bbv.png"></a>
                                </td>
                                <!-- <td style="text-align: right;">
                                    <a href="https://play.google.com/store/apps/details?id=com.empoweryouth.app"
                                        title="Get it on Google Play" target="_blank">
                                        <img alt="Get it on Google Play" class="play-img"
                                            src="https://play.google.com/intl/en/badges/images/generic/en_badge_web_generic.png"
                                            title="Download Empower Youth App on Google Play">
                                    </a>
                                </td> -->
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