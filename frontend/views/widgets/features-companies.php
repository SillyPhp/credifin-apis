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
                    <div class="col-md-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/feature-career-page.png') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-text">
                            <h4>Get a well designed career page</h4>
                            <p>Your company's Career Page serves as a personal pitch to job seekers so they know why your company is attractive and can apply to open positions.</p>
                            <a href="" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature feature2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="feature-text">
                            <h4>Utilize the chatbox to improve customer engagement</h4>
                            <p>Make communication easy between you and applicants by answering their queries and complex questions, ultimately resulting in a good candidate experience with an instant answering facility using a chatbox.</p>
                            <a href="" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/feature-chat-box.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature feature3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/feature-drop-resume.png') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-text">
                            <h4>'Drop resume' feature to hire candidates at any time</h4>
                            <p>The unique feature allows you to choose the best candidate whenever a vacancy arises, as applications are stored under different job profiles in the drop resume section.</p>
                            <a href="" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature feature4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="feature-text">
                            <h4>Keep track of each candidate's progress during the hiring process</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In dapibus tincidunt libero, quis dignissim nisl consectetur et. </p>
                            <a href="" class="learn-btn">Learn More</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="feature-img">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/feature-tracking.png') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="view-all">
        <div class="container">
            <div class="row">
                <a herf="" class="view-all-btn">View All Feature</a>
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
    width: 65%;
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

');
