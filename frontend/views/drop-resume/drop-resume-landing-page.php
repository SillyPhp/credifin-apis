<?php

use yii\helpers\Url;

?>
    <section class="drop-resume-head">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="drop-resume-txt">
                        <h1><span class="og">Drop Resume<br></span> can help you to get your dream job.</h1>
                        <div class="search-container">
                            <form action="/organizations" id="form_search_cmp">
                                <input id="company_search" type="text"
                                       value="<?= ((Yii::$app->request->get('keyword')) ? Yii::$app->request->get('keyword') : '') ?>"
                                       placeholder="Search Companies, Colleges, Schools" name="keyword">
                                <button id="search"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 drop-resume-img">
                    <div class="drop-resume-head-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/man-with-glasses.png') ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="studyus-head">
        <div class="container">
            <div class="row">
                <div class="col-md-5 tac">
                    <div class="whystudy">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/drop-resume.png') ?>" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <h3 class="heading-style">Drop in Your Resume</h3>
                    <p class="why-des">This unique feature of ours can help you towards securing your dream
                        job
                        in your desired company much before the vacancy arises. It gives you an opportunity to drop
                        in
                        your resume in the Resume Box of your dream company to get noticed before other applicants.
                        Drop
                        in your resume and get chance to secure an interview for your dream job.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="drop-resume-in">
        <div class="container">
            <div class="row">
                <h3 class="heading-style white-font">Drop Your Resume In</h3>
            </div>
            <div class="row">
                <div class="us-hover">
                    <div class="col-md-3 col-sm-4 col-xs-12">
<!--                        <a href="" target="_blank">-->
                            <div class="college">
                                <p class="name-drop">Banks And NBFCs</p>
                                <div class="drop-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/NBFC.png') ?>">
                                </div>

                            </div>
<!--                        </a>-->
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
<!--                        <a href="" target="_blank">-->
                            <div class="college">
                                <p class="name-drop">Companies</p>
                                <div class="drop-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/companies.png') ?>">
                                </div>
                            </div>
<!--                        </a>-->
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
<!--                        <a href="" target="_blank">-->
                            <div class="college">
                                <p class="name-drop">Universities/Colleges</p>
                                <div class="drop-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/universities.png') ?>">
                                </div>
                            </div>
<!--                        </a>-->
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
<!--                        <a href="" target="_blank">-->
                            <div class="college">
                                <p class="name-drop">Hospitals</p>
                                <div class="drop-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/hospital.png') ?>">
                                </div>
                            </div>
<!--                        </a>-->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="workss">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'How It Works'); ?></h3>
                </div>
            </div>
            <div class="dis-flex">
                <div class="col-md-4 col-sm-6">
                    <div class="drop-hw-block">
                        <div class="service-icon">
                            <span>1</span>
                        </div>
                        <div class="drop-hw-title tit-1">Select The Company.</div>
                        <p class="drop-hw-description">
                            The first step after you log in is to search your dream company in which you want to apply
                            for the job or internship.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="drop-hw-block red">
                        <div class="service-icon">
                            <span>2</span>
                        </div>
                        <div class="drop-hw-title tit-2">Click On The Drop Resume Icon.</div>
                        <p class="drop-hw-description">
                            After that, click on the Drop Resume Icon located
                            at the bottom-right corner of the company's profile page.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="drop-hw-block blue">
                        <div class="service-icon">
                            <span>3</span>
                        </div>
                        <div class="drop-hw-title tit-3">Select The Type Of Job/Internship.</div>
                        <p class="drop-hw-description">
                            Now, choose the type of Job/Internship that best suits your needs and requirements.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="drop-hw-block orange">
                        <div class="service-icon">
                            <span>4</span>
                        </div>
                        <div class="drop-hw-title tit-4">Select Your Preferred Job Details.</div>
                        <p class="drop-hw-description">
                            Now, select the job profile, job title and preferred location.
                            You can also fill your experience if you have any.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="drop-hw-block gray">
                        <div class="service-icon">
                            <span>5</span>
                        </div>
                        <div class="drop-hw-title tit-5">Click On The APPLY NOW Button.</div>
                        <p class="drop-hw-description">
                            Hit the Apply Now button. Drop your resume in the resume box to get noticed by the
                            employers
                            as soon as the vacancies are available.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="banks">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-10 col-xs-12">
                    <div class="com-grid">
                        <h3 class="mb-20 pb-10 heading-style white-font">Top Banks To Drop Your Resume In</h3>
                    </div>
                </div>
                <div class="col-md-6 col-sm-2 col-xs-12">
                    <div class="type-1">
                        <div>
                            <a href="<?= Url::to('/organizations?keyword=bank'); ?>" class="btn btn-3" target="_blank">
                                <span class="txting"><?= Yii::t('frontend', 'View all'); ?></span>
                                <span class="round"><i class="fas fa-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <a href="<?= Url::to('/icicibank'); ?>" target="_blank" class="company-box">
                        <div class="company-hover"></div>
                        <div class="company-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/icici_bank_logo.png') ?>">
                        </div>
                        <div class="company-name">ICICI Bank</div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <a href="<?= Url::to('/citizensbank'); ?>" target="_blank" class="company-box">
                        <div class="company-hover"></div>
                        <div class="company-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/citizens-bank.png') ?>">
                        </div>
                        <div class="company-name">Citizens Bank</div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <a href="<?= Url::to('/bankofbaroda'); ?>" target="_blank" class="company-box">
                        <div class="company-hover"></div>
                        <div class="company-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/bob-logo.png') ?>">
                        </div>
                        <div class="company-name">Bank Of Baroda</div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <a href="<?= Url::to('/axisbank'); ?>" target="_blank" class="company-box">
                        <div class="company-hover"></div>
                        <div class="company-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/axis-bank.png') ?>">
                        </div>
                        <div class="company-name">Axis Bank</div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <a href="<?= Url::to('/hsbcbankpvtltd3098/reviews'); ?>" target="_blank" class="company-box">
                        <div class="company-hover"></div>
                        <div class="company-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/HSBC-log.png') ?>">
                        </div>
                        <div class="company-name">HSBC Bank Pvt. Ltd.</div>
                    </a>
                </div>
            </div>
        </div>
    </section>


<?php
$this->registerCss('
.white-font {
    color: #fff;
}
.drop-resume-in {
    background: linear-gradient(51.32deg, #50A7C2 58.67%, #B7F8DB 87.24%);
    padding-bottom: 20px;
}
.studyus-head {
    padding: 30px 0px 40px;
}
.whystudy {
    width: 100%;
    text-align: center;
    max-width: 300px;
    margin: 0 auto;
}
.whystudy img {
    width: 100%;
}
.tac {
    text-align: center;
}
.why-des{
    letter-spacing: 0.3px;
    font-size: 18px;
    line-height: 28px;
    color: #000;
    font-family: roboto;
    text-align: justify;
}
.drop-resume-img {
    align-self: flex-end;
}
.search-container {
    max-width: 600px;
    background: #fff;
    margin: 0 0px 10px;
    position: relative;
    height: 44px;
    border-radius: 8px;
    border: 1px solid #ddd;
}
.search-container input[type=text] {
    padding: 6px 0px 6px 15px;
    font-size: 15px;
    border: none;
    width: 100%;
    margin: 6px 0;
}
.search-container button {
    position: absolute;
    padding: 12px 25px;
    background: #ff7803;
    font-size: 17px;
    border: none;
    color: #fff;
    cursor: pointer;
    top: -1px;
    right: -1px;
    border-radius: 0 8px 8px 0;
}
//.us-hover:hover .college{
//    opacity:0.4;
//}
.us-hover .college:hover{
    opacity:1;
}
.service-icon {
    color: #fff;
    background: #fff;
    font-size: 22px;
    line-height: 60px;
    font-weight: bold;
    width: 60px;
    height: 60px;
    margin: 0 0 20px 3px;
    border-radius: 50%;
    box-shadow: 5px 0 5px rgb(0 0 0 / 20%);
    position: relative;
    text-align: center;
    z-index: 1;
}
.drop-hw-block .service-icon:before, .drop-hw-block .service-icon:after {
    content: "";
    background: linear-gradient(to right, #F09119 50%, transparent 50%);
    border-radius: 50%;
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    z-index: -1;
    transition: all ease 0.8s;
}
.drop-hw-block .service-icon:after {
    background: #F09119;
    box-shadow: 0 7px 15px rgb(0 0 0 / 30%);
    top: 10px;
    left: 10px;
    right: 10px;
    bottom: 10px;
}
.drop-hw-block:hover .service-icon {
    box-shadow: -5px 1px 5px rgb(0 0 0 / 20%);
}
.drop-hw-block:hover .service-icon:before, .drop-hw-block:hover .service-icon:after {
    transform: rotateZ(180deg);
}
.tit-1{color: #F09119;}
.drop-hw-block.red .service-icon:before {
    background: linear-gradient(to right, #E34A3A 50%, transparent 50%);
}
.drop-hw-block.red .service-icon:after {
    background: #E34A3A;
}
.tit-2{color: #E34A3A;}
.drop-hw-block.blue .service-icon:before {
    background: linear-gradient(to right, #00a0e3 50%, transparent 50%);
}
.drop-hw-block.blue .service-icon:after {
    background: #00a0e3;
}
.tit-3{color: #00a0e3;}
.drop-hw-block.orange .service-icon:before {
    background: linear-gradient(to right, #96b924 50%, transparent 50%);
}
.drop-hw-block.orange .service-icon:after {
    background: #96b924;
}
.tit-4{color: #96b924;}
.drop-hw-block.gray .service-icon:before {
    background: linear-gradient(to right, #888686 50%, transparent 50%);
}
.drop-hw-block.gray .service-icon:after {
    background: #888686;
}
.tit-5{color: #888686;}
.dis-flex {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}
p.name-drop {
    color: #000;
    text-align: center;
    font-family: roboto;
    font-weight: 500;
    margin: 10px 0 0;
    font-size: 18px;
    letter-spacing: 0.5px;
}
.og {
    color: #fff;
    text-transform: uppercase;
    font-family: \'Lobster\';
    font-size: 34px;
}
.drop-resume-head{
    background: url(' . Url::to('@eyAssets/images/pages/custom/color-circles.png') . ') 80% 5%, url(' . Url::to('@eyAssets/images/pages/custom/resume.png') . ') 55% 45%, linear-gradient(95.46deg, #50A7C2 8.49%, #B7F8DB 84.8%);
    min-height: 550px;
    background-size: 6%, 6%, cover !important;
    background-repeat: no-repeat !important;
    display: flex;
    align-items: flex-end;
}
.drop-resume-txt h1 {
    font-size: 30px;
    font-family: lora;
    text-align: left;
    text-transform: capitalize;
    color: #fff;
    line-height: 50px;
    margin: 0px 0px 20px 0px;
}
.txt-strip {
    margin: 0px 0px 20px 10px;
    text-align: left;
}
.txt-strip img {
    height: 100%;   
    max-height: 40px;
}
.blue-strip img {
    width: 100%;
    max-width: 670px;
    float: right;
}
.drop-hw-block {
    box-shadow: 0 0 10px -4px rgb(0 0 0 / 20%);
    padding: 20px;
    margin-bottom: 30px;
    transition: ease-in-out .3s;
    cursor:pointer;
}
.drop-hw-block:hover {
    box-shadow: 0 0 15px -4px rgba(0 0 0 / 30%);
}
.drop-hw-title {
    font-size: 17px;
    font-family: \'Roboto\';
    font-weight: 500;
    margin-bottom: 5px;
    text-transform: capitalize;
    letter-spacing: .7px;
}
p.drop-hw-description {
    font-size: 14px;
    min-height: 92px;
    font-family: \'Roboto\';
}

.company-logo {
    background-color: #fff;
    border-radius: 50%;
    min-width: 80px;
    max-width: 80px;
    height: 80px;
    line-height: 70px;
    overflow: hidden;
    transition: all 0.2s;
}
.company-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
//.company-box:hover .company-logo{
//    transform:scale(1.05);
//}
.company-name {
    font-size: 16px;
    color: #fff;
    font-weight: 600;
    font-family: roboto;
    width: 80%;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    text-align: left;
    overflow: hidden;
    padding-left: 15px;
    z-index: 1;
}
.drop-text-btn {
    text-align: center;
    padding: 10px;
}
.drop-text-btn a{   
    color: #fff;
    background-color: #ff7803;
    font-size: 14px;
    font-weight: 600;
    font-family: lora;
    border: 2px solid #fff;
    padding: 4px 10px;
    border-radius: 8px;
    display: inline-block;
    cursor: pointer;
    transition: ease-in-out .2s;
}
.drop-text-btn a:hover {
    color: #ff7803;
    background-color: #fff;
    border: 2px solid #ff7803;
}
.college {
    padding: 15px 15px 0;
    background-color: #fff;
    border-radius: 4px;
    margin-bottom: 20px;
    transition: all .3s;
    height: 175px;
}
.drop-img{
    text-align: center;
    height: 120px;
    width: 200px;
    margin: 0 auto;
    display: flex;
    align-items: flex-end;
}
.banks {
    background: linear-gradient(51.32deg, #50A7C2 58.67%, #B7F8DB 87.24%);
}
.company-box {
    position: relative;
    z-index: 1;
    transition: 0.5s all ease-out;
    overflow: hidden;
    display: flex;
    align-items: center;
    margin-bottom: 30px;
}
.company-hover {
    width: 80px;
    height: 80px;
    background-color: #fff;
    position: absolute;
    left: 0;
    top: 50%;
    transition: all .5s;
    border-radius: 40px;
    transform: translatey(-50%);
}
.company-logo {
    background-color: #fff;
    border-radius: 50%;
    min-width: 80px;
    max-width: 80px;
    height: 80px;
    line-height: 70px;
    overflow: hidden;
    transition: all 0.2s;
    z-index: 1;
}
.company-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 5px;
}
.company-box:hover .company-name {
    color: #333;
}
.company-box:hover .company-hover {
    width: 100%;
    height: 100%;
}
.footer {
    margin-top: 0px !important;
}
@media screen and (max-width:768px){
    .drop-resume-img {
        display: none;
    }
    .drop-resume-head {
    background: url(' . Url::to('@eyAssets/images/pages/custom/color-circles.png') . ') 80% 5%, url(' . Url::to('@eyAssets/images/pages/custom/resume.png') . ') 6% 31%, linear-gradient(95.46deg, #50A7C2 8.49%, #B7F8DB 84.8%);
        align-items: center;
    }
}
');