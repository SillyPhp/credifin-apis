<?php
$this->registerCssFile("https://fonts.googleapis.com/css?family=Lora&display=swap");
$this->registerCssFile("https://fonts.googleapis.com/css?family=Open+Sans&display=swap");
$this->registerCssFile("https://fonts.googleapis.com/css?family=Quattrocento&display=swap");
$this->registerCssFile("https://fonts.googleapis.com/css?family=Roboto:300&display=swap");

$this->registerCss("
    body {
        margin: 0;
        padding: 0;
        background-color: #f8f8f8;
        font-family: open sans;

    }

    .border {
        max-width: 600px;
        margin: 0 auto;
    }

    .border2 {
        background: white;
        text-align: center;
    }

    .border3 {
        background-color: #eff2f7;
        text-align: center;
    }

    .border4 {
        background-color: #222222;
        margin: 5px 0 5px 0;
        border-radius: 5px;
    }

    .responsive {
        width: 100%;
    }

    .logo {
        text-align: left;
        padding: 18px 0 0px 30px;
        background: url(images/hdrshape.png);
        background-size: 300px 100px;
        background-repeat: no-repeat;
        background-position: left;
        height: 81px;
        background-color: #fff;
    }

    .logo img {
        max-width: 160px;
    }

    .cmp-logo {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 1px solid #eee;
        position: absolute;
        top: 10%;
        right: 5%;
        padding: 10px 0 0 10px;
        background-color: white;
    }

    .cmp-logo img {
        max-width: 80px;
        max-height: 60px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: 70px;
    }

    .icon img {
        max-width: 250px;
        padding: 40px 0 0 0;
    }

    .hdr {
        background-image: url(images/v2.png), url(images/v1.png);
        background-position: left bottom, right bottom;
        background-repeat: no-repeat, no-repeat;
        height: 200px;
    }

    .seeker {
        text-align: left;
        padding-left: 35px;
        padding-top: 15px;
        font-size: 25px;
        color: #ff7803;
        font-weight: bold;
        font-family: lora;
    }

    .job-info {
        padding: 20px 0 0 0px;
        font-weight: bold;
        font-family: 'Roboto', sans-serif;
        font-size: 18px;
        color: #00a0e3;
        text-transform: capitalize;
        border-top: 2px solid #eee;
    }

    .designation {
        font-size: 17px;
        font-weight: bold;
        font-family: 'Roboto', sans-serif;
    }

    .job-location {
        font-size: 16px;
        padding-top: 10px;
        padding-bottom: 5px;
        font-family: 'Roboto', sans-serif;
    }

    .job-skills {
        padding-bottom: 5px;
        font-size: 16px;
        font-family: 'Roboto', sans-serif;
    }

    .job-salary {
        font-size: 16px;
        font-family: 'Roboto', sans-serif;
    }

    .btn {
        padding-bottom: 20px;
        padding-top: 20px;
        font-family: 'Roboto', sans-serif;
        text-align: center;
    }

    .btn a {
        text-align: center;
        display: inline-block;
        padding: 7px 30px;
        background: #00a0e3;
        border-radius: 5px;
        font-size: 16px;
        color: #fff;
        text-decoration: none;
    }

    .candidate-border {
        font-weight: bold;
        font-size: 17px;
        font-family: 'Roboto', sans-serif;
        text-transform: capitalize;
        color: #00a0e3;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .newlogo {
        margin: 0 auto;
        text-align: center;
        width: 85px;
        height: 85px;
        border-radius: 50%;
        border: 1px solid #eee;
        position: relative;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .newlogo img {
        max-width: 85px;
        max-height: 83px;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .job-ds {
        font-weight: bold;
        font-size: 17px;
        font-family: 'Roboto', sans-serif;
        position: absolute;
        top: -15px;
        left: 130px;
        text-transform: capitalize;
        color: #00a0e3;
    }

    .cand-name {
        font-size: 16px;
        font-family: 'Roboto', sans-serif;
        text-transform: capitalize;
        margin: 5px 0;
    }

    .cand-skills {
        font-size: 16px;
        font-family: 'Roboto', sans-serif;
        text-transform: capitalize;
        margin: 5px 0;
    }

    .com-skills {
        font-size: 16px;
        font-family: 'Roboto', sans-serif;
        text-transform: capitalize;
        margin: 5px 0;

    }

    .position-relative {
        position: relative;
    }

    .update-text {
        max-width: 250px;
        margin: 0 auto;
        font-size: 13px;
        padding-bottom: 5px;
    }

    .copyright {
        padding: 10px 0 10px 0;
        font-size: 10px;
        text-align: center;
    }

    .btn1 a {
        text-align: center;
        display: inline-block;
        padding: 8px 20px;
        background: #00a0e3;
        border-radius: 5px;
        font-size: 16px;
        color: #fff;
        text-decoration: none;
    }

    .btn1, .btn2 {
        text-align: center;
        padding: 15px 0 20px 0;
        font-family: 'Roboto', sans-serif;
        display: inline-block;
    }

    .btn2 a {
        text-align: center;
        display: inline-block;
        padding: 7px 20px;
        background: #fff;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        color: #00a0e3;
        text-decoration: none;
        border: 1px solid #00a0e3;
    }

    .cmp-logo1 {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        position: relative;
    }

    .cmp-logo1 img {
        width: 70px;
        height: 70px;
        position: absolute;
        top: 55%;
        left: 51%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
    }

    .good {
        font-family: 'Roboto', sans-serif;
        font-size: 18px;
        position: absolute;
        top: 30px;
        left: 17%;
        color: #fff;
    }

    .team {
        font-family: 'Roboto', sans-serif;
        font-size: 17px;
        position: absolute;
        top: 55px;
        left: 17%;
        color: #00a0e3;
        font-weight: bold;
    }

    .team1 {
        color: #ff7803;
        font-weight: bold;
    }

    .teaming {
        text-align: left;
        padding: 15px 0px 15px 15px;
        font-family: roboto;
        font-size: 15px;
    }

    .social-icons {
        text-align: right;
        margin: 0px 15px;
    }

    .social-icons img {
        margin: 0px 5px;
    }

    .main {
        max-width: 600px;
        margin: 0 auto;
        background-color: #222222;
        color: white;
        border-radius: 5px;
        font-family: roboto;
        margin-top: 5px;
    }

    .parent1 {
        padding: 20px 30px;
    }

    .hed {
        font-size: 45px;
    }

    .em {
        color: #00a0e3;
        text-decoration: underline;
    }

    .yo {
        color: #ff7803;
        text-decoration: underline;
    }

    .all-features {
        display: flow-root;
        padding-top: 20px;
    }

    .feature-text {
        font-weight: 300;
        line-height: 1.5em;
        color: #aaa;
        text-align: justify;
        font-size: 15px;
    }

    .sett {
        width: 49%;
        display: inline-block;
        min-height: 175px;
        float: left;
    }

    .main-logo {
        display: block;
        line-height: 45px;
    }

    .logo-set {
        display: inline-block;
        float: left;
    }

    .logo-set img {
        max-width: 40px;
    }

    .main-text {
        padding-left: 10px;
        font-size: 19px;
        font-weight: 500;
        display: inline-block;
    }

    .inner-text {
        padding-top: 15px;
        color: #aaaaaa;
        font-weight: 300;
        font-size: 15px;
        line-height: 1.5em;
        text-align: inherit;
    }

    .social img {
        width: 32px;
        margin: 1px 2px;
    }

    .e {
        font-weight: bold;
        font-family: 'Roboto', sans-serif;
    }

    .f {
        padding-left: 10px;
        font-family: 'Roboto', sans-serif;
    }

    .g {
        padding-left: 10px;
        font-weight: bold;
        font-family: 'Roboto', sans-serif;
    }
");

$this->registerCss("
");
$this->registerCss("");
$this->registerCss("");
?>

<style type="text/css">
    @media screen and (max-width: 500px) {
        .sett {
            width: 100%
        }
    }

    @media (max-width: 450px) {
        .hdr {
            background-image: url(images/v1.png);
            background-size: contain;
        }

        .seeker {
            text-align: center;
        }

        .logo {
            background-size: 217px 100px;
        }

        .logo img {
            max-width: 130px;
        }

        .cmp-logo {
            width: 45px;
            height: 45px;
            top: 5%;
        }

        .cmp-logo img {
            width: 45px;
            height: 45px;
        }

        .end img {
            max-width: 180px;
        }

        .text {
            font-size: 15px;
        }

        .text-heading {
            font-size: 16px;
        }

        .job-info {
            font-size: 17px;
        }

        .designation {
            font-size: 15px;
        }

        .job-ds {
            position: relative;
            left: 0px !important;
            font-size: 15px;
        }

        .cand-name {
            position: relative;
            left: 0px !important;
            padding-bottom: 5px;
            font-size: 15px;
        }

        .newlogo {
            margin: 20px auto;
            font-size: 15px;
            width: 65px;
            height: 65px;
        }

        .newlogo img {
            max-width: 60px;
            max-height: 60px;
        }

        .candidate-border {
            font-size: 16px;
        }

        .com-skills {
            position: relative;
            left: 0px !important;
            padding-bottom: 10px;
            font-size: 15px;
        }

        .cand-skills {
            position: relative;
            left: 0px !important;
            padding-bottom: 6px;
            padding-left: 60px;
            font-size: 15px;
        }

        .btn1 {
            padding: 0px 0px 0px 0px !important
        }

    }

    @media (max-width: 414px) {
        .bg-img {
            height: 180px;
        }

        .bg-text {
            font-size: 18px;
            top: 108px;
        }

        .good {
            padding-left: 48px;
        }

        .team {
            padding-left: 48px;
        }
    }

</style>
<div class="border">
    <div class="position-relative">
        <div class="logo"><a href="#"><img src="images/com.png" class="responsive"></a>
        </div>
        <div class="cmp-logo"><img src="images/vsc.png" height="50%"></div>
    </div>
    <div class="border2">
        <div class="hdr">
            <div class="seeker">Job Seekers Resume</div>
            <!-- <img src="images/v2.png"> -->
            <!-- <img src="images/v1.png"> -->
        </div>
        <div class="candidate-profile">
            <div class>
                <div class="newlogo"><img src="images/index.jpg"></div>
                <div class="job-ds"></div>
                <div class="cand-name"><img src="images/user-15.png" height="16px" width="14px"><span
                            class="g">Sohal</span></div>
                <div class="cand-skills"><img src="images/skills.png" height="16px" width="14px"><span class="f">Html, Css, Php, bootstrap</span>
                </div>
                <div class="com-skills"><img src="images/jobexxx.png" height="16px" width="14px"><span
                            class="f">2year</span></div>
            </div>
            <div class="btn1"><a href="#">Download resume</a></div>
            <div class="btn2"><a href="#">View full application</a></div>
        </div>
        <div class="job-info">Job Information</div>
        <div class="designation">Junior web Developer</div>
        <div class="job-location"><img src="images/location1.png" height="15px" width="15px">
            <span class="f">Ludhiana</span></div>
        <div class="job-skills"><img src="images/skills.png" height="15px" width="15px"><span class="f">Php, Css, Html, Bootstrap.</span>
        </div>
        <div class="job-salary"><img src="images/salary.png" height="16px" width="14px"><span class="f">₹ 96000 - ₹ 120000 p.a.</span>
        </div>
        <div class="btn"><a href="#">View Job</a></div>
    </div>
    <div class="main">
        <div class="parent1">
            <div class="feature-head">
                <div class="hed">Features</div>
                <div class="feature-text"><span class="em">Empower</span><span class="yo">Youth.com</span> Gives You The
                    Flexibility To Create Jobs in Many Different Ways Also The Power of AI to Manage Your Candidates
                    Efficiently Effectively.
                </div>
            </div>
            <div class="all-features">
                <div class="first-feature sett">
                    <div class="main-logo">
                        <div class="logo-set"><img src="images/browser-white.png"></div>
                        <div class="main-text">Jobs & Internships</div>
                    </div>
                    <div class="inner-text">Create Jobs or Internship using our AI Powered Tool, Traditional Job Posting
                        Tool or Directly From Your Twitter Link.
                    </div>
                </div>
                <div class="second-feature sett">
                    <div class="main-logo">
                        <div class="logo-set"><img src="images/development-white.png"></div>
                        <div class="main-text">Recruitment HRMS</div>
                    </div>
                    <div class="inner-text">We Have Made Words First Free Applicant Tracking System, Now You Can Know In
                        Depth Knowledge About Your Candidate Before Recruitment.
                    </div>
                </div>
                <div class="third-feature sett">
                    <div class="main-logo">
                        <div class="logo-set"><img src="images/test-white.png"></div>
                        <div class="main-text">Interview Scheduler</div>
                    </div>
                    <div class="inner-text">Schedule Interviews With Candidates and among all your Recruitments Much
                        More Effectively Cutting Your Valuable Time Loss By 80%.
                    </div>
                </div>
                <div class="fourth-feature sett">
                    <div class="main-logo">
                        <div class="logo-set"><img src="images/service-white.png"></div>
                        <div class="main-text">Campus Placements</div>
                    </div>
                    <div class="inner-text">Recruit Interns or Job Candidates without Any Number Restrictions. Now
                        Conduct Campus Placements in Any College using our Campus Drive Sitting in The Comfort Of Your
                        Office.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="border4">
        <div class="teaming position-relative">
            <div class="cmp-logo1"><img src="images/name.png"></div>
            <div class="good">Best Regards,</div>
            <div class="team">Shyna and EmpowerYouth <span class="team1">Team</span></div>
            <div class="social-icons">
                <a href="https://www.facebook.com/empower/" target="blank"><img src="images/fbicon.png"></a>
                <a href="https://twitter.com/EmpowerYouth__" target="blank"><img src="images/twittericon.png"></a>
                <a href="https://www.instagram.com/empoweryouth.in" target="blank"><img src="images/instaicon.png"></a>
                <a href="https://www.linkedin.com/in/empower-youth-11231118a/" target="blank"><img
                            src="images/linkedin.png"></a>
            </div>
        </div>
    </div>
    <div class="border3">
        <div class="copyright">
            <div class="">Copyright © 2019 Empower Youth</div>
        </div>
    </div>
</div>