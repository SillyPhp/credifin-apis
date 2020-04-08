<?php

use yii\helpers\Url;

?>
    <section class="benefits-bg">
        <div class="overlay-black"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mentors-benefit-heading">Benefits For Your  <br> Mentor And Mentees</p>
                </div>
                <div class="col-md-6">
                    <div class="m-benefit-box">
                        <div class="mbb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/benefits-schedule-remider.png')?>">
                        </div>
                        <div class="mbb-text">
                            <p class="text-bold">Easy Scheduling + Reminders</p>
                            <p>Calendar Sync (Google & Outlook) And time slot management </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pull-right col-sm-12 col-xs-12">
                    <div class="m-benefit-box">
                        <div class="mbb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/benefits-direct-msg.png')?>">
                        </div>
                        <div class="mbb-text">
                            <p class="text-bold">Meeting Notes + Direct Messages</p>
                            <p>Mentors and mentees can take notes and send direct message to each other  </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pull-right col-sm-12 col-xs-12">
                    <div class="m-benefit-box">
                        <div class="mbb-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/benefits-video-call.png')?>">
                        </div>
                        <div class="mbb-text">
                            <p class="text-bold">Video calls inside the platform</p>
                            <p>No registration or installation need. video call works inside the platform  </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
<!--                    <div class="mbb-btn">-->
<!--                    <a href=""><i class="fas fa-users"></i> Try With Your Mentors</a>-->
<!--                    </div>-->
                </div>

            </div>

    </section>
<?php
$this->registerCss('
.mentors-benefit-heading{
    font-size:40px;
    font-family: lora;
    color:#FFF;
    margin-bottom:5px;
    line-height: 50px;
}
.benefits-bg{
    background: url('. Url::to('@eyAssets/images/pages/mentorship/benefits-mentor.png') .');
    background-size: cover;
    position:relative;
    min-height:500px;
    font-family: roboto;
    padding: 50px 0;
}
.overlay-black{
    background: rgba(0,0,0,.4);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.m-benefit-box{
    display: flex;
    max-width:400px;
    background: #fff;
    align-items: center;
    box-shadow: 5px 5px 10px rgba(0,0,0,.3);
    margin-bottom: 30px;
    border-radius: 10px;
}
.mbb-icon{
    background: #00a0e3;
    padding:10px 15px;
    min-width: 110px;
    border-radius: 10px 0 0 10px;

}
.mbb-text p{
    margin-bottom: 0px !important;
    padding: 0 15px;
    color:#333;
    9text-transform: capitalize;
}
.text-bold{
    font-weight: bold;
}
.mbb-btn{
    margin-top: 65px;
}
.mbb-btn a{
    background: #00a0e3;
    color:#fff; 
    padding: 10px 20px;
    box-shadow:0 0 10px rgba(0, 0, 0, .3);
}
@media screen and (max-width:992px) {
    .benefits-bg{
        text-align:center;    
    }
    .m-benefit-box{
        margin:20px auto;
    }
}
');
?>