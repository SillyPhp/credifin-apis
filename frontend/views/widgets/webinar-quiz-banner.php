<?php 
    use yii\helpers\Url;
?>

<section class="quiz-banner">
    <img class="quiz-upper-img" src="<?= Url::to('@eyAssets/images/pages/webinar/webinar-quiz-upper-img.png')?>" alt="">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="quiz-banner-text">
                    <h3>Participate In The Quiz Based On New Investment Strategy</h3>
                    <div class="prize-money">
                        Prize Money: <span>₹5000/-</span>
                    </div>
                    <a href="/webinar/new-age-investment-strategies-10407">Register Now <i class="fa fa-chevron-right"></i></a>
                    <p>Only Registered Candidate Can Participate</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="quiz-banner-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/webinar/webinar-quiz-illustration.png')?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->registerCss('
    .quiz-banner {
        background: url('. Url::to('@eyAssets/images/pages/webinar/webinar-quiz-bg.png') .');
        min-height: 500px;
        display: flex;
        align-items: center;
        position: relative;
        background-repeat: no-repeat;
        background-size: cover;
        padding: 30px 0;
    }
    img.quiz-upper-img {
        position: absolute;
        top: 5px;
    }
    .quiz-banner .row{
        display: flex;
        align-items: center;
    }
    .quiz-banner-text h3 {
        color: #fff;
        font-size: 35px;
        font-weight: 800;
    }
    .prize-money {
        font-size: 20px;
        color: #fff;
        font-weight: 700;
    }
    .prize-money span {
        font-size: 40px;
        margin-left: 20px;
    }
    .quiz-banner-text a {
        padding: 12px 44px;
        background: #ff63be;
        display: inline-block;
        margin-top: 20px;
        color: #ffffff;
        font-weight: 800;
    }
    .quiz-banner-text p {
        color: #e9e9e9;
        margin-top: 14px;
        font-weight: 700;
    }
    .quiz-banner-text a:hover i {
        margin-left: 20px;
        transition: all ease-out .15s;
    }
    .quiz-banner-text a i {
        transition: all ease-out .15s;
    }
    @media only screen and (max-width: 767px){
        .quiz-banner .row{
            flex-direction: column;
        }
        .quiz-upper-img{
            display: none;
        }
        .quiz-banner-img{
            width: 280px;
        }
        .quiz-banner-text h3{
            font-size: 25px;
        }
    }
')?>