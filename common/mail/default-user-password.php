<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->registerCss('
    * {
    margin: 0;
    padding: 0;
}

    img + div {
    display: none;
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
.email_icon{
    width:15px;
height:15px;
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
    margin-bottom: 35px;
        list-style-type: none;
    }

    .activate-button ul li a {
    padding: 15px 10px;
        color: #fff;
        background: #00a0e3;
        border-radius: 8px;
        font-size: 16px;
        text-decoration: none;
        margin-bottom: 20px;
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
        color: #000;
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
');
?>
<div class="wrapper">
    <div class="inner-wrapper">
        <div class="logo">
            <a href="https://www.empoweryouth.com"><img
                        src="https://www.empoweryouth.com/assets/themes/email/images/jE3DW981MQMkA49zEAL7ol5zrZyBag.png"
                        alt="Empower Youth" class="responsive"></a>
        </div>
        <div class="welcome-text">
            <div class="text-heading">Hello <?= $data['name']; ?> !
            </div>
            <div class="text-heading">Greetings from Empower Youth!
            </div>
           <p>This is to inform you that your account's Default Username  on  <span class="e">Empower</span> <span class="y">Youth</span> is: <span class="e"><?= $data['username']?></span>.
            and The Default password is: <span class="e"><?= $data['password']; ?></span>
               You Can change password anytime after login it.</p>
            <br>
            <p>You can now track your Education loan application as well as your Job application status from your Empower Youth's Dashboard or By Clicking <a  href="https://www.empoweryouth.com/account/dashboard">Here</a></p>
        </div>

        <div class="welcome-text wt2">
            If you facing any kind of difficulties, Please contact us immediately at:
<br><img class= "email_icon" src="https://www.empoweryouth.com/assets/themes/email/images/DKLb29kg0o07Bn0jBA5WRPBlampN8J.png"
                     alt="Email"> info@empoweryouth.com
<br><img class= "email_icon" src="https://www.empoweryouth.com/assets/themes/email/images/qEeByK16PolWLxpp14p5RzZn49J0YL.png"
                     alt="Whatsapp"> 8727985888
        </div>

        <div class="ey-team">
            <a href="javascript:;">
                <img src="https://www.empoweryouth.com/assets/themes/email/images//Yljygz3xWRVwxEP98XaJo6BD7w1LP5.png"
                     alt="Empower Youth Team">
            </a>
        </div>
        <div class="copyright">
            <div class="">Copyright © 2021 Empower Youth</div>
        </div>
    </div>
</div>
