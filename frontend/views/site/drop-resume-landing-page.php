<?php

use yii\helpers\Url;

?>
    <section class="drop-resume-head">
        <div class="drop-layer"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="drop-resume-txt">
                        <h1><span class="og">Drop Resume<br></span> can help you to get your dream job.</h1>
                        <!--                        <div class="txt-strip">-->
                        <!--                            <img src="-->
                        <? //= Url::to('@eyAssets/images/pages/custom/drop-resume-og.png') ?><!--"/>-->
                        <!--                        </div>-->
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
                <!--                <div class="col-md-6 col-sm-6">-->
                <!--                    <div class="drop-resume-head-img">-->
                <!--                        <img src="-->
                <? //= Url::to('@eyAssets/images/pages/custom/drop-resume-hdrimgg.png') ?><!--"/>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
        </div>
    </section>

    <section class="des-sec">
        <div class="container">
            <div class="row dis-flex">
                <div class="col-md-4 col-sm-4">
                    <div class="side-b">
                        <img src="<?= Url::to('@eyAssets/images/pages/cv_templates/resume-hold.jpg') ?>" alt="">
                    </div>
                </div>
                <div class="col-md-7 col-md-offset-1 col-sm-8">
                    <div class="content-resume">
                        <h3 class="drop-t">Drop in Your Resume</h3>
                        <p class="description-set">This unique feature of ours can help you towards securing your dream
                            job
                            in your desired company much before the vacancy arises. It gives you an opportunity to drop
                            in
                            your resume in the Resume Box of your dream company to get noticed before other applicants.
                            Drop
                            in your resume and get chance to secure an interview for your dream job.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="drop-resume-in">
        <div class="container">
            <div class="row">
                <div class="heading-style">Drop Your Resume In</div>
            </div>
            <div class="row">
                <div class="us-hover">
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <a href="<?= Url::to('/organizations?keyword=college'); ?>" target="_blank">
                            <div class="college">
                                <div class="drop-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/university.png') ?>">
                                </div>
                                <p class="name-drop">COLLEGE</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <a href="<?= Url::to('/organizations?keyword=hospital'); ?>" target="_blank">
                            <div class="college">
                                <div class="drop-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/health-care.png') ?>">
                                </div>
                                <p class="name-drop">HOSPITAL</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <a href="<?= Url::to('/organizations?keyword=IT'); ?>" target="_blank">
                            <div class="college">
                                <div class="drop-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/IT.png') ?>">
                                </div>
                                <p class="name-drop">INFORMATION TECHNOLOGY</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <a href="<?= Url::to('/organizations?keyword=finance'); ?>" target="_blank">
                            <div class="college">
                                <div class="drop-img">
                                    <img src="<?= Url::to('@eyAssets/images/pages/custom/finance.png') ?>">
                                </div>
                                <p class="name-drop">FINANCE</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="workss">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'How It Works'); ?></h2>
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
                        <h1 class="mb-20 pb-10 heading-style">Top Banks To Drop Your Resume In</h1>
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
            <div>
                <div class="col-md-3 col-sm-4">
                    <div class="company-box">
                        <a href="<?= Url::to('/icicibank'); ?>" target="_blank">
                            <div class="company-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/icici_bank_logo.png') ?>">
                            </div>
                            <div class="company-name">ICICI Bank</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="company-box">
                        <a href="<?= Url::to('/citizensbank'); ?>" target="_blank">
                            <div class="company-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/citizens-bank.png') ?>">
                            </div>
                            <div class="company-name">Citizens Bank</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="company-box">
                        <a href="<?= Url::to('/bankofbaroda'); ?>" target="_blank">
                            <div class="company-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/bob-logo.png') ?>">
                            </div>
                            <div class="company-name">Bank Of Baroda</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="company-box">
                        <a href="<?= Url::to('/axisbank'); ?>" target="_blank">
                            <div class="company-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/axis-bank.png') ?>">
                            </div>
                            <div class="company-name">Axis Bank</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4">
                    <div class="company-box">
                        <a href="<?= Url::to('/hsbcbankpvtltd3098/reviews'); ?>" target="_blank">
                            <div class="company-logo">
                                <img src="<?= Url::to('@eyAssets/images/pages/custom/HSBC-log.png') ?>">
                            </div>
                            <div class="company-name">HSBC Bank Pvt. Ltd.</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php
$this->registerCss('
.content-resume{
    padding: 40px;
    box-shadow: 6px 6px 12px 0px rgb(0 0 0 / 30%);
    background-color: #fff;
}
.des-sec {
    background-image: linear-gradient(to right, #fff 50%, #a9a9a9 50%);
    padding: 0px 0 20px;
    margin:30px 0;
}
.side-b {
    border: 2px solid #a9a9a9;
    padding: 10px;
    background-color: #fff;
}
.side-b img {
    width: 100%;
    height: 300px;
    object-fit: cover;
}
.drop-t {
    margin: 0px 0 5px 0;
    font-family: \'Roboto\';
    font-weight: 500;
}
p.description-set {
    font-size: 16px;
    font-family: \'Roboto\';
    text-align: justify;
    letter-spacing: .5px;
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
.us-hover:hover .college{
    opacity:0.4;
}
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
    text-align: center;
    font-family: \'Roboto\';
    font-weight: 500;
    margin: 10px 0 0;
    font-size: 15px;
    letter-spacing: 0.5px;
}
.drop-layer {
    width: 100%;
    height: 100%;
    background-color: #0000006b;
    position: absolute;
}
.og {
    color: #ff7803;
    text-transform: uppercase;
    font-family: \'Lobster\';
    font-size: 34px;
}
.drop-resume-head{
    background:url(' . Url::to('@eyAssets/images/pages/education-loans/resume1.png') . ');
    min-height:450px;
    background-size:cover;
    background-position: left;
    background-repeat: no-repeat;
}
.drop-resume-head-img img {
    height: 100%;
    max-height: 450px;
    max-width: 760px;
}
.drop-resume-txt {
    padding-top: 150px;
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
.company-box a {
    text-align: center;
    padding: 10px;
    margin-bottom: 30px;
    border-radius: 4px;
    box-shadow: 0 0 6px -1px rgb(0 0 0 / 20%);
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    border-left: 2px solid #ff7803;
}
.company-box a:hover{
    box-shadow:0 0 12px -1px rgb(0 0 0 / 20%); 
    border-left: 2px solid #00a0e3;
}
.company-logo {
    width: 65px;
    margin: auto;
    height: 65px;
    line-height: 60px;
    border-radius: 2px;
    transition: all 0.2s;
//    padding: 0 5px;
//    box-shadow: 0 0 4px -1px rgb(0 0 0 / 30%);
}
.company-logo img {
    width: 65px;
    height: 65px;
    object-fit: contain;
}
//.company-box:hover .company-logo{
//    transform:scale(1.05);
//}
.company-name {
    font-size: 15px;
    font-family: roboto;
    line-height: 22px;
    width: 80%;
    font-weight: 500;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    text-align: left;
    overflow: hidden;
    padding-left: 15px;
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
    padding: 15px;
    background-color: #fff;
    border-radius: 4px;
    margin-bottom:20px;
    transition:all .3s;
}
.drop-img{
    text-align: center;
}
.drop-img img {
    max-height: 128px;
    max-width: 200px;
    padding: 10px;
}
@media screen and (max-width:500px) and (min-width:300px){
.side-b{margin-bottom:25px;}
.type-1{margin-bottom:15px;}
    .drop-resume-head {
        background-color: #ececec;
    }
    .drop-resume-txt {
        padding-top: 90px;
    }
    .drop-resume-txt h1 {
        font-size: 36px;
        line-height: 43px;
        margin: 0px 10px 0px 10px;
    }
    .txt-strip img {
        max-height: 34px;
    }
     .drop-resume-head-img img {
       display: none;
     }
}
@media screen and (max-width:750px) and (min-width:501px){
    .drop-resume-head {
        background-color: #ececec;
    }
    .drop-resume-head-img img{
        display: none;
    }
    .drop-resume-txt {
        padding-top: 90px;
    }
    .drop-resume-txt h1 {
        font-size: 42px;
        line-height: 55px;
        margin: 0px 20px 0px 20px;
    }
    .txt-strip img {
        max-height: 42px;
    }
}
@media screen and (max-width:1060px) and (min-width:859px){
    .drop-resume-head-img img {
        height: 100%;
        max-height: 375px;
        max-width: 590px;
    }
    .drop-resume-txt h1 {
        font-size: 32px;
        line-height: 45px;
    }
    .txt-strip img {
        max-height: 36px;
    }
}
@media screen and (max-width:858px) and (min-width:768px){
    .drop-resume-head-img img {
        height: 100%;
        max-height: 350px;
        max-width: 560px;
    }
    .drop-resume-txt h1 {
        font-size: 28px;
        line-height: 35px;
    }
    .txt-strip img {
        max-height: 32px;
    }
}
@media screen and (max-width: 990px) and (min-width: 320px) {
    .drop-flex {
        flex-direction: column;
    }
    .order2{
        order: 1;
    }
    .order1{
        order: 2;
    }
}
');