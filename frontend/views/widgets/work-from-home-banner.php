<?php

use yii\helpers\Url;
?>
<section class="work-from-home">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="banner-text">
                    <h1>Work From Home</h1>
                    <p>Maintain better work-life balance by working remotely. Apply for work from home jobs and internships without any hassle. Explore the section now!'</p>
                    <div class="explore-btn">
                        <a href="/work-from-home-jobs" class="job-btn"><span class="btn-text">Explore Jobs</span><span class="btn-icon"><i class="fas fa-briefcase"></i></span></a>
                        <a href="/work-from-home-internships" class="intern-btn"><span class="btn-text">Explore Internship</span><span class="btn-icon"><i class="fas fa-graduation-cap"></i></span></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="banner-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/jobs/work-from-home-img.png') ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->registerCss('
    .work-from-home{
        background: #F7F3FF;
        height: 380px;
        padding: 20px 0;
        margin: 30px 0;
    }
    .work-from-home .container{
        padding-top: 12px !important;
        padding-bottom: 12px !important;
    }
    .banner-img{
        width: 375px;
        display: block;
        margin-left: auto;
    }
    .banner-text {
        padding: 60px 0;
    }
    .banner-text *{
        margin: 0;
    }
    .banner-text p {
        font-size: 16px;
        line-height: 1.5;
        font-weight: 500;
    }
    .banner-text h1 {
        font-size: 40px;
        font-weight: 700;
        color: #333;
    }
    .banner-text .explore-btn {
        margin-top: 30px;
    }
    .banner-text .explore-btn a {
        padding: 7px 42px 7px 15px;
        margin: 5px 10px 5px 0;
        background: #00a0e3;
        display: inline-block;
        color: #fff;
        font-weight: 600;
        position: relative; 
    }
    .btn-text{
        transition: .3s all ease-in;
    }
    .explore-btn a span.btn-icon{
        width: 37px;
        height: 37px;
        background: #fff;
        position: absolute;
        right: 0px;
        top: 0px;
        color: #00a0e3;
        font-size: 20px;
        box-shadow: inset 0 0 0 1px #00a0e3;
        transition: .3s all ease-in;
        z-index: 1;
    }
    span.btn-text{
        position: relative;
        z-index: 2;
    }
    .explore-btn a span.btn-icon i{
        position: absolute;
        top: 8px;
        right: 6px;
    }
    .intern-btn span.btn-icon{
        color: #ff7803 !important;
        box-shadow: inset 0 0 0 1px #ff7803 !important;
    }
    .banner-text .explore-btn .intern-btn {
        background: #ff7803;
    }
    .explore-btn a:hover span.btn-icon{
        width: 100%;
        transition: .3s all ease-in;
    }
    .explore-btn a:nth-child(1):hover span.btn-text{
        color: #00a0e3;
        transition: .3s all ease-in;
        font-weight: 600;
    }
    .explore-btn a:hover span.btn-text{
        color: #ff7803;
        transition: .3s all ease-in;
        font-weight: 600;
    }
    @media only screen and (max-width: 991px){
        .banner-text p {
            font-size: 14px;
        }
        .banner-text h1 {
            font-size: 30px;
        } 
        .banner-img {
            width: 260px;
            display: block;
            margin-left: auto;
            padding: 40px 0;
        }
        .work-from-home{
            height: auto;
        }
    }
    @media only screen and (max-width: 767px){
        
    .work-from-home .row{
        display: flex;
        align-items: center;
        flex-direction: column-reverse;
    }
    .banner-img{
        padding: 10px 0;
        width: 220px;
    }
    .banner-text{
        padding: 10px 0;
    }
    @media only screen and (max-width: 475px){
        .banner-text{
            text-align: center;
        }
        .banner-text h1 {
            font-size: 25px;
        } 
    }
') ?>