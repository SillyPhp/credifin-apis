<?php

use yii\helpers\Url;

?>

<section class="companies-features">
    <div class="heading">
        <div class="container">
            <div class="row">
                <h3>You have access to the following features</h3>
            </div>
        </div>
    </div>

    <div class="features">
        <div class="feature feature1">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/features-career.png') ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-text">
                            <h4>Get a well designed career page</h4>
                            <p>Your company's Career Page serves as a personal pitch to job seekers so they know why your company is attractive and can apply to open positions.</p>
                            <a href="/account/dashboard" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature feature2">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-text">
                            <h4>Utilize the chatbox to improve customer engagement</h4>
                            <p>Make communication easy between you and applicants by answering their queries and complex questions, ultimately resulting in a good candidate experience with an instant answering facility using a chatbox.</p>
                            <a href="/account/jobs/dashboard" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/features-live-chat.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature feature3">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/features-resume.png') ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-text">
                            <h4>'Drop resume' feature to hire candidates at any time</h4>
                            <p>The unique feature allows you to choose the best candidate whenever a vacancy arises, as applications are stored under different job profiles in the drop resume section.</p>
                            <a href="/account/dashboard" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature feature4">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="feature-text">
                            <h4>Keep track of each candidate's progress during the hiring process</h4>
                            <p>An applicant tracking system will give you insight into the status of your job openings and the people who have applied for them. You can drill down to the candidate level and see the positions they've applied for and what stage of the workflow they're at. You can also evaluate specific jobs and see how many candidates have applied and where each one is at.</p>
                            <a href="/account/jobs/dashboard" target="_blank" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/features-track.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
$this->registercss('
.companies-features{
    font-family: Roboto;
}
.feature{
    height: 400px;
}
.feature .container{
    height: 100%;
}
.feature .row{
    height: 100%;
    display: flex;
    align-items: center;
}
.feature2, .feature4{
    background: #E0F6FF;
}
.feature-img{
    text-align: center;
}
.feature-img img{
    width: 90%; 
    border-radius: 15px;
}
.learn-btn{
    font-weight: 700;
    padding: 6px 21px;
    background: #ADE7FF;
    color: #000;
    display: inline-block;
    margin-top: 20px;
    border-radius: 30px;
}
.feature-text h4{
    font-weight:700;
    font-size:21pt;
    color: #000;
    font-family: roboto;
}
.feature-text p{
    letter-spacing: 0.2px;
    font-size: 14px;
    font-weight: 500;
    color: #6c6c6c;
}
.view-all-btn{
    display: block;
    margin: 30px auto;
    width: fit-content;
    background: #00a0e3;
    padding: 6px 23px;
    color: #fff;
    font-weight: 700;
    border-radius: 4px;
}
.heading{
    margin-top: 20px;
}
.heading h3{
    text-align: center;
    margin: 10px 0;
    font-weight: 700;
    font-weight: 700;
    font-family: roboto;
    font-size: 30px;
    color: #000;
}
.feature:nth-child(3) .feature-img img{
    width: 80%;
}
@media only screen and (max-width: 768px){
    .feature .row{
        flex-direction: column;
        justify-content: center;
    }
    .feature:nth-child(2n) .row{
        flex-direction: column-reverse;
    }
    .feature{
        height: 100vh;
    }
    .feature-text{
        margin-top: 30px;
        padding: 0 20px;
        text-align: center;
    }
    .feature-text h4 {
        font-size: 16pt;
        line-height: 24px;
        margin-bottom: 19px;
        margin-top: 0;
    }
    .feature-text p{
        line-height: 16px;
        font-weight: 400;
    }
}

');
