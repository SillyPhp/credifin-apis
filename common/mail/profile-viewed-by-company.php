<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        img + div{
            display: none;
        }
        .company-msg-trigger-main {
            background-color: #f3f2ef;
            max-width: 650px;
            margin: auto;
            border-radius: 6px;
            font-family: arial;
            overflow: hidden;
        }
        .logo {
            padding: 20px;
        }
        .logo-img img {
            width: 155px;
            height: 25px;
        }
        .logo-img {
            float: left;
            margin-top: 10px;
        }
        .profile-img {
            float: right;
        }
        .profile-img img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .clear-both {
            clear: both;
        }
        .white-bg {
            background-color: #fff;
            margin: 10px;
        }
        .content, .mid-content {
            padding: 10px 15px;
            text-align: center;
        }
        .mid-content p{
            color: #000;
            font-size: 16px;
            letter-spacing: 0.3px;
            margin-bottom: 0px !important;
            line-height: 26px;
        }
        .cn {
            padding: 10px;
            text-align: center;
        }
        .cn h2 {
            font-size: 38pt;
            margin: 0px !important;
            color: #00a0e3;
        }
        .content p {
            font-size: 18px;
            letter-spacing: 0.3px;
            text-transform: capitalize;
            color: #000;
            font-weight: bold;
        }
        .msg-btn {
            border: 1px solid #00a0e3;
            background-color: #00a0e3;
            color: #fff !important;
            padding: 8px 20px;
            display: inline-block;
            border-radius: 4px;
            text-decoration: none;
            transition: 0.3s ease-in-out;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .msg-btn a{
            color: #fff !important;
            text-decoration: none;
        }
        .trigger-img {
            text-align: center;
        }
        .trigger-img img {
            width: 100%;
            max-width: 150px;
        }
        .footer {
            padding: 15px 20px 20px;
            margin: 0 30px;
        }
        .web-social a {
            margin: 0 5px;
            display: inline-block;
            width: 30px;
            height: 30px;
        }
        .web-social {
            text-align: center;
        }
        .web-social a img {
            width: 29px;
        }
        .ey-team img {
            width: 160px;
        }
        .ey-team {
            margin: 0 20px;
            text-align: center;
            padding: 0px 0px 5px;
        }
        .ey-team p {
            color: #000;
            font-weight: bold;
            margin: 6px 0;
        }
        .appstore {
            font-weight: 600;
            font-size: 16px;
            font-family: lora;
            padding-top: 15px;
            text-align: center;
            color: #000;
        }
        .appss img {
            height: 50px;
            width: 110px;
        }
    </style>
    <title></title>
</head>
<body>
<div class="company-msg-trigger-main">
    <div class="white-bg">
        <div class="logo">
            <div class="logo-img">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/XGpD9mA68oPlZvBAknjzoBVl4kwJne.png">
            </div>
            <div class="profile-img">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/7B0P3kNEldvW5vlKy53JQm14wrJXbj.png">
            </div>
        </div>
        <div class="clear-both"></div>

        <div class="content">
            <p>See how well your profile stands out in the crowd</p>
        </div>
        <div class="trigger-img">
            <img src="https://www.empoweryouth.com/assets/themes/email/images/MXOy576jYoKjx0Nvn3xxRKlw1eWDnG.png">
        </div>
        <div class="mid-content">
            <p>Your profile has been <b>viewed by <?=$data['org_name'];?></b>. So, <b>complete your profile</b> so that you don't miss them out.</p>
        </div>
        <div class="cn">
            <div class="msg-btn"><a href="https://empoweryouth.com/<?=$data['username'];?>/edit">Complete Profile</a></div>
        </div>
    </div>
    <div class="footer">
        <div class="web-social">
            <a href="https://www.facebook.com/empower/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/Nxj6lKYbJdDjEJYOMWeBRvg5VrAZ3y.png"></a>
            <a href="https://www.linkedin.com/company/empoweryouth/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/VA1npK2MJdJjMB18BWL5drlbjPkBXZ.png"></a>
            <a href="https://twitter.com/EmpowerYouthin" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/w6rmj0npDd2rwZeEjWjldJ8qgNV5KW.png"></a>
            <a href="https://www.instagram.com/empoweryouth.in/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/yVgawN7rxoLWq3vWnEywRYOM5kelbv.png"></a>
        </div>
        <div class="appstore">Download Our App
            <div class="appss">
                <a href="https://play.google.com/store/apps/details?id=com.empoweryouth.app" title="Get it on Google Play" target="_blank">
                    <img alt="Get it on Google Play" src="https://play.google.com/intl/en/badges/images/generic/en_badge_web_generic.png" title="Download Empower Youth App on Google Play">
                </a>
            </div>
        </div>
        <div class="ey-team">
            <a href="https://www.empoweryouth.com/">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/DeBxPEjOGdjymqkD7DqBopqANyVYw9.png">
            </a>
            <p>Copyright © 2021 Empower Youth</p>
        </div>
    </div>
</div>
</body>
</html>