<?php
    use yii\helpers\Url;
?>
    <section class="drop-resume-head">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                        <div class="drop-resume-head-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/drop-resume-hdrimgg.png') ?>"/>
                        </div>
                    </div>
                <div class="col-md-6 col-sm-6">
                    <div class="drop-resume-txt">
                        <h1><span class="og">EmpowerYouth.com<br></span> can help you to get your dream job in your desired company.</h1>
                        <div class="txt-strip">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/drop-resume-og.png') ?>"/>
                        </div>
                        <p>To get noticed by the best companies as soon as any vacancy arises.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="drop-head-bg">
        <div class="pt50">
        <div class="container">
            <div class="row mt-20">
                <div class="col-md-12">
                    <h2 class="mb-20 pb-10 heading-style"><?= Yii::t('frontend', 'How It Works'); ?></h2>
                </div>
            </div>
            <div class="drop-flex">
                <div class="drop-hw-block">
                    <div class="drop-hw-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/seach-company.png') ?>"/>
                    </div>
                </div>
                <div class="drop-des">
                    <div class="drop-box">
                    <div class="drop-hw-title">Select The Company.</div>
                    <p class="drop-hw-description">
                         The first step after you logged in,
                        is to search your dream company in which you want to aplly for the job or internship.
                    </p>
                </div>
                </div>
        </div>
        </div>
        <div class="pt50">
            <div class="container">
                <div class="drop-flex">
                    <div class="drop-hw-block order2">
                        <div class="drop-hw-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/drop-resume-icon.png') ?>"/>
                        </div>
                    </div>
                    <div class="drop-des order1">
                        <div class="drop-box">
                            <div class="drop-hw-title">Click On The Drop Resume Icon.</div>
                            <p class="drop-hw-description">
                                After that, click on the Drop Resume Icon located
                                at the bottom-right corner of the company's profile page.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt50">
            <div class="container">
                <div class="drop-flex">
                    <div class="drop-hw-block">
                        <div class="drop-hw-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/job-internship.png') ?>"/>
                        </div>
                    </div>
                    <div class="drop-des">
                        <div class="drop-box">
                            <div class="drop-hw-title">Select The Type Of Job/Internship.</div>
                            <p class="drop-hw-description">
                                Now, choose the type of Job/Internship that best suits your needs and requirements.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt50">
            <div class="container">
                <div class="drop-flex">
                    <div class="drop-hw-block order2">
                        <div class="drop-hw-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/job-description.png') ?>"/>
                        </div>
                    </div>
                    <div class="drop-des order1">
                        <div class="drop-box">
                            <div class="drop-hw-title">Select Your Preferred Job Details.</div>
                            <p class="drop-hw-description">
                                Now, select the job profile, job title and preferred location.
                                You can also fill your experience if you have any.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt50">
            <div class="container">
                <div class="drop-flex">
                    <div class="drop-hw-block">
                        <div class="drop-hw-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/applynow.png') ?>"/>
                        </div>
                    </div>
                    <div class="drop-des">
                        <div class="drop-box">
                            <div class="drop-hw-title">Click On The APPLY NOW Button.</div>
                            <p class="drop-hw-description">
                                Hit the Apply Now button. Drop your resume in the resume box to get noticed by the employers
                                as soon as the vacancies are available.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?= $this->render('/widgets/drop-resume-for-teachers') ?>

<!--    <section>-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-md-6 col-sm-4 col-xs-12">-->
<!--                    <div class="com-grid">-->
<!--                        <h1 class="heading-style">Featured Companies</h1>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-6 col-sm-4 col-xs-12">-->
<!--                    <div class="type-1">-->
<!--                        <div>-->
<!--                            <a href="--><?//= Url::to('/organizations'); ?><!--" class="btn btn-3">-->
<!--                                <span class="txting">--><?//= Yii::t('frontend', 'View all'); ?><!--</span>-->
<!--                                <span class="round"><i class="fas fa-chevron-right"></i></span>-->
<!--                            </a>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="col-md-2 col-sm-3">-->
<!--                    <div class="top-box">-->
<!--                        <div class="company-logo">-->
<!---->
<!--                        </div>-->
<!--                        <div class="company-name">-->
<!--                        </div>-->
<!--            </div>-->
<!--        </div>-->
<!--       </div>-->
<!--    </section>-->
    <section class="sec-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-4 col-xs-12">
                    <div class="com-grid">
                        <h1 class="heading-style">Top Banks To Drop Your Resume In</h1>
                    </div>
                </div>
                <div class="col-md-6 col-sm-4 col-xs-12">
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
                <div class="col-md-2 col-sm-3">
                    <div class="company-box">
                        <a href="<?= Url::to('/icicibank'); ?>" target="_blank">
                        <div class="company-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/icici_bank_logo.png') ?>"
                        </div>
                        <div class="company-name">ICICI Bank</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <div class="company-box">
                        <a href="<?= Url::to('/citizensbank'); ?>" target="_blank">
                        <div class="company-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/citizens-bank.png') ?>"
                        </div>
                        <div class="company-name">Citizens Bank</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <div class="company-box">
                        <a href="<?= Url::to('/bankofbaroda'); ?>" target="_blank">
                        <div class="company-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/bob-logo.png') ?>"
                        </div>
                        <div class="company-name">Bank Of Baroda</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <div class="company-box">
                        <a href="<?= Url::to('/axisbank'); ?>" target="_blank">
                        <div class="company-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/axis-bank.png') ?>"
                        </div>
                        <div class="company-name">Axis Bank</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <div class="company-box">
                        <a href="<?= Url::to('/hsbcbankpvtltd3098/reviews'); ?>" target="_blank">
                        <div class="company-logo">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/HSBC-log.png') ?>"
                        </div>
                        <div class="company-name">HSBC Bank Pvt. Ltd.</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="category-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="college">
                    <div class="drop-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/university.png') ?>"
                    </div>
                        <div class="drop-text-btn">
                            <a href="<?= Url::to('/organizations?keyword=college'); ?>" target="_blank">
                                Drop Your Resume</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="college">
                        <div class="drop-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/health-care.png') ?>"
                        </div>
                        <div class="drop-text-btn">
                            <a href="<?= Url::to('/organizations?keyword=hospital'); ?>" target="_blank">
                                Drop Your Resume</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="college">
                        <div class="drop-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/IT.png') ?>"
                        </div>
                        <div class="drop-text-btn">
                            <a href="<?= Url::to('/organizations?keyword=IT'); ?>" target="_blank">
                                Drop Your Resume</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="college">
                        <div class="drop-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/custom/finance.png') ?>"
                        </div>
                        <div class="drop-text-btn">
                            <a href="<?= Url::to('/organizations?keyword=finance'); ?>" target="_blank">
                                Drop Your Resume</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.footer {
    margin-top: 0px;
}
.row{
    margin-left: 0px;
    margin-right: 0px;
}
section > .container-fluid{
    padding-top: 0px !important;
}
.container-fluid {
    padding: 0px !important;
}
.og{
  color: #ff7803;
}
.drop-resume-head {
    background-color: #F5F5F5;
}
.drop-resume-head-img img {
    height: 100%;
    max-height: 450px;
    max-width: 760px;
}
.drop-resume-txt {
    padding-top: 90px;
}
.drop-resume-txt h1 {
    font-size: 40px;
    font-family: lobster;
    text-align: center;
    color: #3461d4;
    line-height: 60px;
    margin: 0px 10px 20px 10px;
}
.txt-strip {
    margin: 20px 0px 20px 0px;
    text-align: center;
}
.txt-strip img {
    height: 100%;
    max-height: 52px;
}
.drop-resume-txt p {
    line-height: 36px;
    margin: 30px 35px 20px 35px;
    font-size: 26px;
    text-align: center;
    font-family: roboto;
    color: #3461d4;
    font-weight: 600;
}
.blue-strip img {
    width: 100%;
    max-width: 670px;
    float: right;
}
.drop-head-bg{
    background-color: #F5F5F5;
}
.pt50{
    padding-top: 5px;
    padding-bottom: 5px;
}
.drop-flex{
    display: flex;
    align-items: center;
    justify-content: space-even;
}
.drop-hw-block, .drop-des{
    flex-basis: 50%;
}
.drop-hw-icon{
    padding: 20px;
    text-align: center;
}
.drop-hw-icon img {
    width: 100%;
    max-width: 320px;
}
.drop-box{
    box-shadow: 0 1px 3px 0px #797979;
    border-radius: 8px;
    background-color: #fff;
    margin: 15px 20px 15px 20px;
}
.drop-hw-title {
    font-size: 20px;
    color: #000;
    font-family: lora;
    font-weight: bold;
    text-align: justify;
    padding: 15px 15px 0px 15px;
}
.drop-hw-description{
    color: #000;
    text-align: justify;
    font-family: roboto;
    font-size: 15px;
    padding: 5px 15px 30px 15px;
}
.order2{
    order: 2;
}
.order1{
    order: 1;
}
.company-box {
    border: 2px solid transparent;
    text-align: center;
    padding: 10px 5px;
    margin-bottom: 20px;
    background-color:#fff;
    border-radius: 5px;
    height: 140px !important;
    cursor: pointer;
    transition: all 0.3s;
}
.company-box:hover{
    box-shadow:0 0 15px 10px #eee; 
}
.company-logo {
    width: 65px;
    margin: auto;
    height: 65px;
    line-height: 61px;
    transition: all 0.3s;
}
.company-box:hover .company-logo{
    transform:scale(1.05);
}
.company-name {
    font-size: 15px;
    font-family: roboto;
    line-height: 22px;
    padding:5px;
    font-weight: 500;
    display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;  
  overflow: hidden;
}
.sec-bg{
    background-color: #F5F5F5;
    padding: 20px 0px 30px;
}
.category-bg {
    padding: 20px 0px 30px;
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
    box-shadow: 0 0 15px 10px #eee;
    padding: 15px;
}
.college:hover {
    background-color: #eee;
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
    .drop-resume-txt p {
        line-height: 27px;
        margin: 10px 35px 20px 35px;
        font-size: 20px;
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
    .drop-resume-txt p {
        line-height: 31px;
        margin: 30px 35px 20px 35px;
        font-size: 24px;
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
    .drop-resume-txt p {
        line-height: 28px;
        margin: 20px 35px 20px 35px;
        font-size: 19px;
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
    .drop-resume-txt p {
        line-height: 26px;
        margin: 10px 35px 10px 35px;
        font-size: 18px;
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