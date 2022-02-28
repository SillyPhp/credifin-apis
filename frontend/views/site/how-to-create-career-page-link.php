<?php

use yii\helpers\Url;

?>
<section class="career-header-bg">
    <div class="container">
        <div class="row cpflex">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="htc-header-content">
                    <h1>Build Your Career Page</h1>
                    <p>Expand Your Brand’s Visibility and Business with Our Career Page.</p>
                    <a href="" class="create-btn">Create Now</a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="htc-header-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/custom/career-page.png') ?>">
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="pdtp50">
        <div class="container">
            <div class="careerpage-benefits">Benefits of Getting a Career Page</div>
            <div class="career-flex">
                <div class="career-bene-des">
                    <div class="career-bene-title">Manage Your Jobs & Internships</div>
                    <p class="career-bene-description">Managing jobs/internshps of your organization is way
                        easier with our career page. Now, <span class="b-font">showcase</span> your <span class="b-font">job postings</span>
                        without any difficulty.</p>
                </div>
                <div class="career-bene-block">
                    <div class="career-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/org-ji.png') ?>">
                    </div>
                </div>
            </div>
            <div class="career-flex">
                <div class="career-bene-des order2">
                    <div class="career-bene-title">Save Your Valuable Time</div>
                    <p class="career-bene-description">All your <span class="b-font">jobs/internships</span> posting are <span class="b-font">managed</span> very
                        <span class="b-font">efficiently</span> on career page. Hence, it <span class="b-font">saves</span> a lot of your
                        <span class="b-font">time</span> that can be used in other productive work.</p>
                </div>
                <div class="career-bene-block order1">
                    <div class="career-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/save-valuable-time.png') ?>">
                    </div>
                </div>
            </div>
            <div class="career-flex">
                <div class="career-bene-des">
                    <div class="career-bene-title">Avoid Re-creating Jobs & Internships</div>
                    <p class="career-bene-description">Avoid the hassle of making all the job related changes on
                        your website. <span class="b-font">Remove</span>, <span class="b-font">Update</span> or <span class="b-font">Close</span> your postings and
                        it will <span class="b-font">automatically</span> reflect on your website.</p>
                </div>
                <div class="career-bene-block">
                    <div class="career-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/recreate-job.png') ?>">
                    </div>
                </div>
            </div>
            <div class="career-flex">
                <div class="career-bene-des order2">
                    <div class="career-bene-title">Increase Your Job Reach</div>
                    <p class="career-bene-description">By <span class="b-font">creating jobs</span> through our career page, you can get a
                        <span class="b-font">large pool of candidates</span> from all over India. Thus,
                         Increasing your job/candidate reach.</p>
                </div>
                <div class="career-bene-block order1">
                    <div class="career-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/increase-job-search.png') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="how-it-works">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>How it Works</h1>
                </div>
            </div>
            <div class="row steps">
                <div class="col-md-3 col-sm-3">
                    <div class="step">
                        <span></span>
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/careerpagesignup.png') ?>">
                        <h3>Sign Up</h3>
                        <p>Create an account on empower youth if you are a new user and log in if you are
                            an existing member.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="step">
                        <span></span>
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/clickdashboard.png') ?>">
                        <h3>Click on the <br>Dashboard</h3>
                        <p>After signing up, click on the dashboard from the Navigation Bar.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="step">
                        <span></span>
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/careerlink.png') ?>">
                        <h3>Generate Career<br> Page Link</h3>
                        <p>Move to career page section on the dashboard and click on the Generate Link button.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3">
                    <div class="step">
                        <span></span>
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/embedthelink.png') ?>">
                        <h3>Embed Career Link on your Website</h3>
                        <p>After generating the link, copy the link and embed it on your website.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.career-header-bg {
    background: url('.Url::to('@eyAssets/images/pages/custom/blue-quad-bg.png').');
    background-size: cover;
    background-repeat: no-repeat;
    min-height: 550px;
    display: flex;
    align-items: center;
    justify-content: center;    
}
.cpflex {
    display: flex;
    align-items: center;
    justify-content: center;
}
.htc-header-content h1 {
    font-family: lora;
    color: #fff;
    letter-spacing: 0.3px;
    font-size: 48px;
}
.htc-header-content p{
    font-size: 20px;
    color: #fff;
    font-family: roboto;
    letter-spacing: 0.3px;
}
.htc-header-img {
    transform: translateY(87px);
}
.htc-header-img img {
    width: 100%;
    max-width: 560px;
}
.create-btn {
    font-size: 16px;
    font-family: roboto;
    color: #fff;
    padding: 4px 15px;
    border-radius: 4px;
    display: inline-block;
    background-color: #ff7803;
    border: 2px solid #ff7803;
    transition: ease-in-out .2s;
    margin-top: 10px;
}
.create-btn:hover{
    background-color: transparent;
    color: #fff;
    border: 2px solid #fff;
}
.career-flex {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}
.career-bene-block, .career-bene-des {
    flex-basis: 50%;
}
.career-bene-des {
    padding: 10px 0px 10px 30px;
}
.careerpage-benefits {
    text-align: center;
    padding: 20px;
    font-size: 28pt;
    font-family: lobster;
    color: #000;
    letter-spacing: 0.3px;
}
.career-bene-title {
    font-size: 22px;
    font-family: roboto;
    color: #000;
    font-weight: 600;
    letter-spacing: 0.3px;
    margin-bottom: 5px;
}
.career-bene-description {
    color: #333;
    font-family: roboto;
    line-height: 22px;
    font-size: 16px;
    letter-spacing: 0.3px;
}
.career-img {
    text-align: center;
    padding: 10px 20px 10px 0;
}
.career-img img {
    width: 100%;
    max-width: 290px;
}
.b-font {
 font-weight: bold;
}
.order1 {
    order: 1;
}
.order2 {
    order: 2;
}
.how-it-works{
  background: #E5F7FF;
  padding: 30px 10px;
  font-family: Montserrat;
  text-align: center;
}
.how-it-works h1{
  text-align: center;
  font-size: 28pt;
  font-family: lobster;
  color: #000;
  letter-spacing: 0.3px;
  margin: 0;
}
.steps{
  margin-top: 25px;
}
.step{
  background: #FFFFFF;
  box-shadow: 0px 0px 14px 1px rgba(0, 0, 0, 0.25);
  height: 250px;
  padding: 20px 10px;
  min-width: 200px;
  max-width: 250px;
  margin: auto;
  overflow: hidden;
  position: relative;
  border-radius: 5px;
  cursor: pointer;
  margin-bottom: 10px;
}
.step span{
  display: block;
  width: 0;
  height: 0;
  background: #0a8bba;
  position: absolute;
  top: -70px;
  left: -70px;
  border-radius: 50%;
  transition: all linear .35s;
  opacity: 0;
}
.step h3{
  margin-top: 45px;
  font-size: 18px;
  font-weight: 700;
  transition: all linear .35s;
  position: relative;
  z-index: 1;
}
.step img{
  max-height: 100px;
  transition: all linear .35s;
  position: relative;
  z-index: 1;
}
.step p{
  font-family: roboto;
  font-size: 14px;
  opacity: 0;
  transition: all linear .35s;
  position: relative;
  z-index: 1;
}
.step:hover p{
  display: block;
  transition: all linear .35s;
  opacity: 1;
  color: #fff;
}
.step:hover h3{
  font-size: 15px;
  margin-top: 10px;
  transition: all linear .35s;
  color: #fff;
}
.step:hover img{
  max-height: 80px;
  transition: all linear .35s;
}
.step:hover span{
  width: 380px;
  height: 380px;
  transition: all linear .35s;
  opacity: 0.9;
}
.footer {
    margin-top: 0px !important;
}
@media (max-width: 992px) and (min-width: 768px){
    .career-header-bg {
        min-height: 460px;
    }
    .htc-header-content h1 {
        font-size: 34px;
    }
    .htc-header-content p {
        font-size: 18px;
        line-height: 27px;
    }
    .htc-header-img {
        transform: translateY(110px);
    }
    .htc-header-img img {
        width: 100%;
        max-width: 360PX;
    }
    .step {
        min-width: 160px;
        max-width: 190px;
    }
    .career-bene-title {
        font-size: 20px;
        margin-bottom: 10px;
        line-height: 24px;
    }
    .career-img img {
        max-width: 250px;
    }
}    
@media (max-width: 767px) and (min-width: 500px){
    .cpflex {
        display: block;
    }
    .career-flex {
        display: block;
    }
    .htc-header-content {
        text-align: center;
        margin-top: 80px;
    }
    .career-header-bg {
        min-height: 460px;
    }
    .htc-header-content h1 {
        font-size: 34px;
    }
    .htc-header-content p {
        font-size: 18px;
        line-height: 27px;
    }
    .htc-header-img {
        transform: translateY(0);
        text-align: center;
        margin-top: 40px;
    }
    .htc-header-img img {
        width: 100%;
        max-width: 360PX;
    }
    .step {
        height: 225px;
        margin-bottom: 30px;
    }
    .step h3 {
        font-size: 16px;
    }
    .career-bene-des {
        text-align: center;
    }
    .career-bene-description {
        line-height: 26px;
    }
    .career-img img {
        max-width: 250px;
    }
    .how-it-works h1 {
        margin-bottom: 10px;
    }
}
@media (max-width: 499px) and (min-width: 320px){
    .cpflex {
        display: block;
    }
    .career-flex {
        display: block;
    }
    .htc-header-content {
        text-align: center;
        margin-top: 80px;
    }
    .career-header-bg {
        min-height: 460px;
    }
    .htc-header-content h1 {
        font-size: 28px;
    }
    .htc-header-content p {
        font-size: 16px;
        line-height: 25px;
    }
    .htc-header-img {
        transform: translateY(0);
        text-align: center;
        margin-top: 40px;
    }
    .htc-header-img img {
        width: 100%;
        max-width: 360PX;
    }
    .create-btn {
        font-size: 14px;
    }
    .step {
        height: 225px;
        margin-bottom: 30px;
    }
    .step h3 {
        font-size: 16px;
    }
    .career-bene-des {
        text-align: center;
        padding: 0px;
    }
    .career-bene-title {
        font-size: 18px;
    }
    .career-bene-description {
        line-height: 20px;
        font-size: 14px;
    }
    .career-img {
        padding: 10px;
    }
    .career-img img {
        max-width: 200px;
    }
    .careerpage-benefits {
        font-size: 24px;
        line-height: 46px;
    }
    .how-it-works h1 {
        font-size: 24pt;
        margin-bottom: 10px;
    }
}
@media (min-width: 1200px)
.container {
    width: 1170px;
}
@media (min-width: 992px)
.container {
    width: 970px;
}
@media (min-width: 768px)
.container {
    width: 750px;
}
');
