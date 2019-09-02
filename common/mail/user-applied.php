<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->registerCss("
body{
	margin: 0;
	padding: 0;
	background-color:#f8f8f8;
	font-family: open sans;

}
.border
	{
	max-width: 600px;
	margin:0 auto; 
	 } 
.border2
	{	 
	background:white;
	text-align: center;
	}
.border3
	{	 
	background-color: #eff2f7;
	text-align: center;
	}
.border4
	{	 
	background-color: #222222;
	margin:5px 0 5px 0; 
	border-radius: 5px;
}
.responsive
	{
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
.logo img
	{
    max-width:160px; 
	}
.cmp-logo
{
	/*margin: 20px 0 20px 30px;*/
	width: 60px;
	height: 60px;
	border-radius: 50%;
	border:1px solid #eee;
	position: absolute;
	top: 10%;
	right: 5%;
	padding: 10px 0 0 10px;
	background-color: white;
}
.cmp-logo img
	{
	max-width: 80px;
	max-height: 60px;
	position: absolute;
	top:50%;
	left:50%;
	transform: translate(-50%,-50%);
	height: 70px;
	}

.icon img
	{
    max-width:250px; 
    padding:40px 0 0 0;
	}
.hdr{
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
.job-info{
	padding: 20px 0 0 0px;
	font-weight: bold;
	font-family: 'Roboto', sans-serif;
	font-size: 18px;
	color: #00a0e3;
	text-transform: capitalize;
	border-top: 2px solid #eee;
}
.designation
{
	font-size: 17px;
	font-weight: bold;
	font-family: 'Roboto', sans-serif;
}

.job-location{
	font-size: 16px;
	padding-top: 10px;
	padding-bottom: 5px;
	font-family: 'Roboto', sans-serif;
}
.job-skills
{
	padding-bottom: 5px;
	font-size: 16px;
	font-family: 'Roboto', sans-serif;
}

.job-salary
{
	font-size: 16px;
	font-family: 'Roboto', sans-serif;
}
.btn 
{
	padding-bottom: 20px;
	padding-top: 20px;
	font-family: 'Roboto', sans-serif;
	text-align: center;
}
.btn a{  
	text-align:center;
	display:inline-block; 
	padding:7px 30px; 
	background:#00a0e3; 
	border-radius:5px; 
	font-size:16px; 
	/*font-weight:bold; */
	color:#fff;
	text-decoration: none;
	}
.candidate-border{
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
	transform: translate(-50%,-50%);
}
.job-ds
{
	font-weight: bold;
	font-size: 17px;
	font-family: 'Roboto', sans-serif;
	position: absolute;
	top: -15px;
	left: 130px;
	text-transform: capitalize;
	color: #00a0e3;
}
.cand-name
{
	font-size: 16px;
	font-family: 'Roboto', sans-serif;
	text-transform: capitalize;
	margin: 5px 0;
}

.cand-skills
{
	font-size: 16px;
	font-family: 'Roboto', sans-serif;
	text-transform: capitalize;
	margin: 5px 0;
}
.com-skills
{
	font-size: 16px;
	font-family: 'Roboto', sans-serif;
	text-transform: capitalize;
	margin: 5px 0;

}
.position-relative{
	position:relative;
}
.update-text
{
	max-width: 250px;
	margin: 0 auto;	
	font-size: 13px;
	padding-bottom: 5px;
}
.copyright
{
	padding:10px 0 10px 0; 
	font-size:10px;
	text-align: center;
}
.btn1 a{  
	text-align:center;
	display:inline-block; 
	padding:8px 20px; 
	background:#00a0e3; 
	border-radius:5px; 
	font-size:16px; 
	/*font-weight:bold; */
	color:#fff;
	text-decoration: none;
	}
	.btn1, .btn2 
{
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
.cmp-logo1
	{
		width: 70px;
		height: 70px;
		border-radius: 50%;
		 position: relative;
		/* box-shadow: 0 0 10px rgba(0,0,0,.1);*/
	}
.cmp-logo1 img{
		width: 70px;
		height: 70px;
		position: absolute;
		top:55%;
		left:51%;
		transform: translate(-50%,-50%);
		border-radius: 50%;
	}
.good{
	font-family: 'Roboto', sans-serif;
	font-size: 18px;
	position: absolute;
	top:30px;
	left:17%;
	color: #fff;
}
.team{
	font-family: 'Roboto', sans-serif;
	font-size: 17px;
	position: absolute;
	top:55px;
	left:17%;
	color: #00a0e3;
	font-weight: bold;
}
.team1{
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
.social-icons img{
	margin: 0px 5px;
}
.social img{width: 32px;margin: 1px 2px;}
<--newstarts-->
 body {
        margin: 0;
        padding: 0;
        width: 100% !important;
      }

      a {
        color: inherit;
      }

      a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
      }

      img {
        border: 0;
        outline: none;
        line-height: 100%;
        text-decoration: none;
        -ms-interpolation-mode: bicubic;
      }

      table,
      td {
        mso-table-lspace: 0;
        mso-table-rspace: 0;
      }

      table,
      tr,
      td {
        border-collapse: collapse;
      }

      table.template-container {
        width: 600px;
        margin: 0 auto;
      }


      body,
      td,
      th,
      p,
      div,
      li,
      a,
      span {
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        mso-line-height-rule: exactly;
      }

      p:first-of-type {
        margin-top: 0 !important;
      }

      p {
        margin-top: 0;
        margin-bottom: 10px;
      }

      p+p {
        margin-top: 10px;
      }

      .gmail-fix {
        display: none !important;
      }

      .sm-right {
        text-align: right;
        margin-left: auto;
      }

      .sm-center {
        text-align: center;
      }

      .sm-padding-left-30 {
        padding-left: 30px;
      }

      .sm-padding-right-20 {
        padding-right: 20px;
      }

      .post-col-left {
        padding-right: 10px;
      }

      .post-col-right {
        padding-left: 10px;
      }

      .sm-col-25 {
        width: 25%;
      }

      .sm-col-33 {
        width: 33%;
      }

      .sm-col-50 {
        width: 50%;
      }

      @media screen and (max-width:620px) {
        table.template-container {
          width: 320px !important;
          margin: 0 auto;
          white-space: normal;
        }

        .xs-col {
          width: 100% !important;
        }

        .xs-spacing {
          margin: 10px 0 !important;
        }

        .xs-mb-10 {
          margin-bottom: 10px;
        }

        .xs-mb-20 {
          margin-bottom: 20px;
        }

        .xs-center {
          text-align: center;
        }

        .xs-table-center {
          text-align: center;
          margin: 0 auto;
        }

        .xs-padding-lr-0 {
          padding-left: 0 !important;
          padding-right: 0 !important;
        }

        .sm-padding-left-30 {
          padding-left: 0;
        }

        .sm-padding-right-20 {
          padding-right: 0;
        }

        .post-col-left {
          padding-right: 0;
        }

        .post-col-right {
          padding-left: 0;
        }
      }
<--newend-->
.e{ font-weight: bold;font-family: 'Roboto', sans-serif;}
.f{padding-left: 10px;font-family: 'Roboto', sans-serif;}
.g{padding-left: 10px;font-weight: bold;font-family: 'Roboto', sans-serif;}
@media (max-width: 450px){
.hdr{background-image: url(images/v1.png);background-size: contain;}
.seeker{text-align: center;}
.logo{background-size: 217px 100px;}
.logo img{max-width:130px;}
.cmp-logo{width: 45px;height: 45px;top: 5%;}
.cmp-logo img{width: 45px;height: 45px;}
.end img{max-width: 180px;}
.text{font-size: 15px;}
.text-heading{font-size: 16px;}
.job-info{font-size: 17px;}
.designation{font-size: 15px;}
.job-ds{position: relative;left: 0px !important;font-size: 15px;}
.cand-name{position: relative;left: 0px !important;padding-bottom: 5px;font-size: 15px;}
.newlogo{margin: 20px auto;font-size: 15px;width: 65px;height: 65px;}
.newlogo img{max-width: 60px;max-height: 60px;}
.candidate-border{font-size: 16px;}
.com-skills{position: relative;left: 0px !important;padding-bottom: 10px;font-size: 15px;}
.cand-skills{position: relative;left: 0px !important;padding-bottom: 6px;padding-left: 60px;font-size: 15px;}
.btn1{padding: 0px 0px 0px 0px !important}

}
@media (max-width: 414px){
	.bg-img{height: 180px;}
	.bg-text{font-size: 18px;top: 108px;}
	.good{padding-left: 48px;}
	.team{padding-left: 48px;}
}
");
?>
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
                <div class="cand-name"><img src="images/user-15.png" height="16px" width="14px"><span class="g">Sohal</span></div>
                <div class="cand-skills"><img src="images/skills.png" height="16px" width="14px"><span class="f">Html, Css, Php, bootstrap</span></div>
                <div class="com-skills"><img src="images/jobexxx.png" height="16px" width="14px"><span class="f">2year</span></div>
            </div>
            <div class="btn1"><a href="#">Download resume</a></div>
            <div class="btn2"><a href="#">View full application</a></div>
        </div>
        <div class="job-info">Job Information</div>
        <div class="designation">Junior web Developer</div>
        <div class="job-location"><img src="images/location1.png" height="15px" width="15px"><span class="f">Ludhiana</span></div>
        <!-- <div class="job-interview"><img src="interviewlocation.png" height="15px" width="15px"><span class="f">Ludhiana</span></div> -->
        <div class="job-skills"><img src="images/skills.png" height="15px" width="15px"><span class="f">Php, Css, Html, Bootstrap.</span></div>
        <div class="job-salary"><img src="images/salary.png" height="16px" width="14px"><span class="f">₹ 96000 - ₹ 120000 p.a.</span></div>
        <div class="btn"><a href="#">View Job</a></div>
    </div>
    <div class="new">
        <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" role="presentation" class="template-body" style="padding: 50px 0px; table-layout: fixed;">
            <tbody>
            <tr>
                <td style="vertical-align: top;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation" class="template-container" style="border-collapse: collapse;">
                        <tbody>
                        <tr>
                            <td class="template__inner">
                                <table class="components" cellpadding="0" cellspasing="0" role="presentation" style="border-collapse: collapse; width: 100%;">
                                    <tbody class="components__item" draggable="false">
                                    <tr>
                                        <td>
                                            <!-- START COMPONENT: FEATURE 4 -->
                                            <table cellspacing="0" cellpadding="0" border="0" role="presentation" class="component feature-4" style="width: 100%; border-collapse: collapse;">
                                                <tr>
                                                    <td style="padding: 30px 35px 20px; background-color: rgb(34, 34, 34); border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px;">
                                                        <table cellpadding="0" cellspacing="0" role="presentation" border="0" style="white-space: normal; border-collapse: collapse; width: 100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td align="left">
                                                                    <p style="color:#fff; font-family: Arial, Helvetica, sans-serif; font-size: 16px;"><span style="font-size: 32px; line-height: 1.2;"><strong>Features</strong></span></p>
                                                                    <p style="color: rgb(170, 170, 170); font-family: Arial, Helvetica, sans-serif; font-size: 16px; line-height: 1.5em;"><span style="color: #00AFEF"><span style="font-size: 15px; line-height: 1.5em;"><a href="http://empoweryouth.com/" rel="noopener noreferrer nofollow">Empower</a></span></span><span style="color: #FF7803"><span style="font-size: 15px; line-height: 1.5em;"><a href="http://empoweryouth.com/" rel="noopener noreferrer nofollow">Youth.com</a></span></span><span style="color: #FFFFFF"><span style="font-size: 15px; line-height: 1.5em;"> </span></span><span style="color: #AAAAAA"><span style="font-size: 15px; line-height: 1.5em;">Gives You The Flexibility To Create Jobs in Many Different Ways &amp; Also The Power of AI to Manage Your Candidates Efficiently &amp; Effectively.</span></span></p>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="width: 100%; border-collapse: collapse;">
                                                            <tbody>
                                                            <tr>
                                                                <td height="20" style="font-size: 1px; line-height: 1px;">
                                                                    &nbsp;
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <table cellpadding="0" cellspacing="0" border="0" role="presentation" class="wrapper wrapper__row" style="width: 100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    <table cellpadding="0" cellspacing="0" border="0" role="presentation" class="wrapper xs-col mso-col-100 sm-col-50" style="float: left;">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="post-col-left">
                                                                                <table cellpadding="0" cellspacing="0" border="0" role="presentation" class="wrapper" style="width: 100%;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="display: inline-table; vertical-align: top; float: left;">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td align="" class="" style="padding-right: 15px;"><a href="https://example.com" draggable="false">
                                                                                                            <img height="36" src="images/browser-white.png" alt="Some alt" style="vertical-align: top; max-width: 100%;" draggable="false">
                                                                                                            <!--<![endif]--></a></td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <table cellpadding="0" cellspacing="0" role="presentation" border="0" style="white-space: normal; border-collapse: collapse; width: 70%;">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td align="left" style="padding-top: 9px;">
                                                                                                        <p style="color: rgb(255, 255, 255); font-family: Arial, Helvetica, sans-serif; font-size: 16px;"><span style="font-size: 18px; line-height: 1.5em;"><strong>Jobs &amp; Internships</strong></span></p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="width: 100%; border-collapse: collapse;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td height="10" style="font-size: 1px; line-height: 1px;">
                                                                                            &nbsp;
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table cellpadding="0" cellspacing="0" role="presentation" border="0" style="white-space: normal; border-collapse: collapse; width: 100%;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td align="left">
                                                                                            <p style="color: rgb(255, 255, 255); font-family: Arial, Helvetica, sans-serif; font-size: 16px; line-height: 1.5em;"><span style="color: #AAAAAA"><span style="font-size: 15px; line-height: 1.5em;">Create Jobs or Internship using our AI Powered Tool, Traditional Job Posting Tool or Directly From Your Twitter Link.</span></span></p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table cellpadding="0" cellspacing="0" border="0" role="presentation" class="wrapper xs-col mso-col-100 sm-col-50" style="float: left;">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="post-col-right">
                                                                                <table cellpadding="0" cellspacing="0" border="0" role="presentation" class="wrapper" style="width: 100%;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="display: inline-table; vertical-align: top; float: left;">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td align="" class="" style="padding-right: 15px;"><a href="https://example.com" draggable="false"><img height="36" src="images/development-white.png" alt="Some alt" style="vertical-align: top; max-width: 100%;" draggable="false">
                                                                                                            <!--<![endif]--></a></td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <table cellpadding="0" cellspacing="0" role="presentation" border="0" style="white-space: normal; border-collapse: collapse; width: 70%;">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td align="left" style="padding-top: 9px;">
                                                                                                        <p style="color: rgb(255, 255, 255); font-family: Arial, Helvetica, sans-serif; font-size: 16px;"><span style="font-size: 18px; line-height: 1.5em;"><strong>Recruitment HRMS</strong></span></p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="width: 100%; border-collapse: collapse;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td height="10" style="font-size: 1px; line-height: 1px;">
                                                                                            &nbsp;
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table cellpadding="0" cellspacing="0" role="presentation" border="0" style="white-space: normal; border-collapse: collapse; width: 100%;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td align="left">
                                                                                            <p style="color: rgb(255, 255, 255); font-family: Arial, Helvetica, sans-serif; font-size: 16px; line-height: 1.5em;"><span style="color: #AAAAAA;"><span style="font-size: 15px; line-height: 1.5em;">We Have Made Words First Free Applicant Tracking System, Now You Can Know In Depth Knowledge About Your Candidate Before Recruitment.</span></span></p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <table cellpadding="0" cellspacing="0" border="0" role="presentation" class="wrapper wrapper__row" style="width: 100%;">
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    <table cellpadding="0" cellspacing="0" border="0" role="presentation" class="wrapper xs-col mso-col-100 sm-col-50" style="float: left;">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="post-col-left">
                                                                                <table cellpadding="0" cellspacing="0" border="0" role="presentation" class="wrapper" style="width: 100%;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="display: inline-table; vertical-align: top; float: left;">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td align="" class="" style="padding-right: 15px;"><a href="https://example.com" draggable="false"><img height="36" src="images/test-white.png" alt="Some alt" style="vertical-align: top; max-width: 100%;" draggable="false">
                                                                                                            <!--<![endif]--></a></td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <table cellpadding="0" cellspacing="0" role="presentation" border="0" style="white-space: normal; border-collapse: collapse; width: 70%;">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td align="left" style="padding-top: 9px;">
                                                                                                        <p style="color: rgb(255, 255, 255); font-family: Arial, Helvetica, sans-serif; font-size: 16px;"><span style="font-size: 18px; line-height: 1.5em;"><strong>Interview Scheduler</strong></span></p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="width: 100%; border-collapse: collapse;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td height="10" style="font-size: 1px; line-height: 1px;">
                                                                                            &nbsp;
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table cellpadding="0" cellspacing="0" role="presentation" border="0" style="white-space: normal; border-collapse: collapse; width: 100%;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td align="left">
                                                                                            <p style="color: rgb(255, 255, 255); font-family: Arial, Helvetica, sans-serif; font-size: 16px; line-height: 1.5em;"><span style="color: #AAAAAA"><span style="font-size: 15px; line-height: 1.5em;">Schedule Interviews With Candidates and among all your Recruitments Much More Effectively Cutting Your Valuable Time Loss By 80%.</span></span></p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table cellpadding="0" cellspacing="0" border="0" role="presentation" class="wrapper xs-col mso-col-100 sm-col-50" style="float: left;">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="post-col-right">
                                                                                <table cellpadding="0" cellspacing="0" border="0" role="presentation" class="wrapper" style="width: 100%;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="display: inline-table; vertical-align: top; float: left;">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td align="" class="" style="padding-right: 15px;"><a href="https://example.com" draggable="false"><img height="36" src="images/service-white.png" alt="Some alt" style="vertical-align: top; max-width: 100%;" draggable="false">
                                                                                                            <!--<![endif]--></a></td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <table cellpadding="0" cellspacing="0" role="presentation" border="0" style="white-space: normal; border-collapse: collapse; width: 70%;">
                                                                                                <tbody>
                                                                                                <tr>
                                                                                                    <td align="left" style="padding-top: 9px;">
                                                                                                        <p style="color: rgb(255, 255, 255); font-family: Arial, Helvetica, sans-serif; font-size: 16px;"><span style="font-size: 18px; line-height: 1.5em;"><strong>Campus Placements</strong></span></p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table cellpadding="0" cellspacing="0" border="0" role="presentation" style="width: 100%; border-collapse: collapse;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td height="10" style="font-size: 1px; line-height: 1px;">
                                                                                            &nbsp;
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                                <table cellpadding="0" cellspacing="0" role="presentation" border="0" style="white-space: normal; border-collapse: collapse; width: 100%;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td align="left">
                                                                                            <p style="color: rgb(255, 255, 255); font-family: Arial, Helvetica, sans-serif; font-size: 16px; line-height: 1.5em;"><span style="color: #AAAAAA"><span style="font-size: 15px; line-height: 1.5em;">Recruit Interns or Job Candidates without Any Number Restrictions. Now Conduct Campus Placements in Any College using our Campus Drive Sitting in The Comfort Of Your Office.</span></span></p>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table><!-- END COMPONENT: FEATURE 4 -->
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
            </tbody>
        </table>
        <div class="gmail-fix" style="white-space: nowrap; font: 15px courier; line-height: 0;">&nbsp; &nbsp; &nbsp; &nbsp;
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </div>
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
                <a href="https://www.linkedin.com/in/empower-youth-11231118a/" target="blank"><img src="images/linkedin.png"></a>
            </div>
        </div>
    </div>
    <div class="border3">
        <div class="copyright">
            <div class="">Copyright © 2019 Empower Youth</div>
        </div>
    </div>
</div>
