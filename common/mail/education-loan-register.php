<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
        .ed-thankyou-main{
            max-width: 650px;
            margin: auto;
            background-color: #f5f5f5;
            border-radius: 6px;
            font-family: arial;
            overflow: hidden;
            padding: 5px 35px;
        }
        .border-none{
            border:none !important;
        }
        .thank-logo img {
            width: 100%;
            max-width: 250px;
            padding: 25px 0px 10px 20px;
        }
        .back-set-clr, .back-set-clrr {
            background-color: #fff;
            padding: 20px;
        }
        .thank-you-img {
            text-align: center;
        }
        .thank-you-img img {
            width: 100%;
            max-width: 460px;
            min-width: 200px;
        }
        .content {
            padding: 10px;
        }
        .content h2 {
            color: #000;
            font-size: 22px;
            font-weight: 700;
        }
        .content p {
            font-size: 14px;
            color: #000;
            line-height: 22px;
        }
        .signup-btn, .clickhere-btn{
            text-align: center;
            margin-top: 25px;
            margin-bottom: 25px;
        }
        .signup-btn a, .clickhere-btn a {
            border: 1px solid #f07f39;
            padding: 8px 16px;
            text-align: center;
            background-color: #f07f39;
            border-radius: 8px;
            color: #fff;
            font-weight: 600;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            text-decoration: none;
        }
        .signup-btn a:hover, .clickhere-btn a:hover{
            color: #f07f39;
            background-color: #fff;
            text-decoration: none;
        }
        .loan-img img {
            width: 100%;
        }
        .lending {
            max-width: 135px;
            display: inline-table;
            width: 135px;
            margin: 0 5px;
            text-align: center;
            margin-bottom: 25px;
            padding: 25px 0px 0px;
            border: 1px solid #e6e4e4;
        }
        .l-logo img {
            width: 100%;
            max-width: 70px;
            height: 70px;
            object-fit: contain;

        }
        .l-txt {
            font-size: 12px;
            height: 36px;
        }
        .l-txt a{
            text-decoration: none;
        }
        .lending-prtnrs {
            text-align: center;
        }
        .lending-partners h2 {
            text-align: center;
        }
        .footer {
            padding: 20px 20px 40px;
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
        .emal-contact {
            text-align: center;
            padding: 20px 0;
        }
        .emal-contact a {
            color: #000;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin: 0 34px;
            font-size: 16px;
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
        .appss img
        {
            height: 50px;
            width: 110px;
        }
    </style>
</head>
<body>
<div class="ed-thankyou-main">
    <div class="thank-logo">
        <img src="https://www.empoweryouth.com/assets/themes/email/images/zpBn4vYx2RmKpNExaDvPdJg3Aq9Vyl.png">
    </div>
    <div class="back-set-clr">
        <div class="thank-you-img">
            <img src="https://www.empoweryouth.com/assets/themes/email/images/yeD1AaYgZoGjL5kglg6eRGkOlw9MK5.png">
        </div>
        <div class="content">
            <p>We Have Recieved Your Loan Application.</p>
            <p>Your Default Username is: <b><?= $data['username'] ?></b> and Password: <b><?= $data['password'] ?></b></p>
            <p>You Can Track Your Application with These Credentials</p>
            <p>Thank You for applying for Education Loan via Empower Youth.If you have not signed up on our platform yet, Sign Up today and & track your loan application process. You can search for jobs, internships & learn New Skills as well.</p>
        </div>
    </div>
    <div class="loan-img">
        <img src="https://www.empoweryouth.com/assets/themes/email/images/6mMpL8zN9QqGLpKxz8NmoAxKOrBbnw.png">
    </div>
    <div class="back-set-clrr">
        <div class="lending-partners">
            <h2>Our Lending Partners</h2>
            <div class="lending-prtnrs">
                <div class="lending">
                    <div class="l-logo">
                        <img src="https://www.empoweryouth.com/assets/themes/email/images/E9n1pJ74KRzva69lWm9VRgxm0e5ND6.png">
                    </div>
                    <div class="l-txt">Agile Fenserv</div>
                </div>
                <div class="lending">
                    <div class="l-logo">
                        <img src="https://www.empoweryouth.com/assets/themes/email/images/ZNnVA4XWJ6oArkmAXpa8dOz8e2MyGq.png">
                    </div>
                    <div class="l-txt">InCred</div>
                </div>
                <div class="lending">
                    <div class="l-logo">
                        <img src="https://www.empoweryouth.com/assets/themes/email/images/Wge0NnDmOQg7ByyN8ONWQqVpKXvBlk.png">
                    </div>
                    <div class="l-txt">Avanse Financial Services</div>
                </div>
                <div class="lending">
                    <div class="l-logo">
                        <img src="https://www.empoweryouth.com/assets/themes/email/images/E9n1pJ74KRzva6YjDL0VRgxm0e5ND6.png">
                    </div>
                    <div class="l-txt">Exclusive Leasing & Financing</div>
                </div>
                <div class="lending">
                    <div class="l-logo">
                        <img src="https://www.empoweryouth.com/assets/themes/email/images/abvgrG4VyQNjy24NnqA4QpW30A9nXK.png">
                    </div>
                    <div class="l-txt">EZ Capital</div>
                </div>
                <div class="lending">
                    <div class="l-logo">
                        <img src="https://www.empoweryouth.com/assets/themes/email/images/abvgrG4VyQNjy2gvwn07QpW30A9nXK.png">
                    </div>
                    <div class="l-txt">We Pay India</div>
                </div>
                <div class="lending border-none">
                    <div class="l-txt"> <a href="https://www.empoweryouth.com/education-loans">And More..</a></div>
                </div>
            </div>
            <div class="clickhere-btn"><a href="https://www.empoweryouth.com/education-loans" target="_blank">Click Here</a></div>
        </div>
    </div>
    <div class="footer">
        <div class="emal-contact">
            <a href="mailto:info@empoweryouth.com" class="mail">Email: info@empoweryouth.com</a>
            <a href="tel:7814871632">Contact Us: +91 7814871632</a>
        </div>
        <div class="ey-team">
            <a href="https://www.empoweryouth.com/">
                <img src="https://www.empoweryouth.com/assets/themes/email/images/DeBxPEjOGdjymqkD7DqBopqANyVYw9.png">
            </a>
            <p>Copyright © 2021 Empower Youth</p>
        </div>
        <div class="web-social">
            <a href="https://www.facebook.com/empower/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/abvgrG4VyQNjy24KbXm7QpW30A9nXK.png"></a>
            <a href="https://www.linkedin.com/company/empoweryouth/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/7y028kbWNRWw9L4vkONkRK4v9marEp.png"></a>
            <a href="https://twitter.com/EmpowerYouthin" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/qnpLz0AvYopGO9801w3GRPrW15BMN9.png"></a>
            <a href="https://www.instagram.com/empoweryouth.in/" target="_blank"><img src="https://www.empoweryouth.com/assets/themes/email/images/Yljygz3xWRVwYOvjyP9Bo6BD7w1LP5.png"></a>
        </div>
        <div class="appstore">Download Our App
            <div class="appss">
                <a href="https://play.google.com/store/apps/details?id=com.dsbedutech.empoweryouth1" title="Get it on Google Play" target="_blank">
                    <img alt="Get it on Google Play" src="https://play.google.com/intl/en/badges/images/generic/en_badge_web_generic.png" title="Download Empower Youth App on Google Play">
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>