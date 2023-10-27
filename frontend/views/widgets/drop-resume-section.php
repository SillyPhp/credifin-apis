<?php

use yii\helpers\Url;
?>
    <section class="drop-resume">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-sm-7">
                    <div class="drop-resume-text">
                        <h3>Drop Resume</h3>
                    <?php
                        if(Yii::$app->user->identity->organization || Yii::$app->request->url == '/employers'){
                    ?>
                            <p>It is often the best hire that sets the tone for the company's culture. Pick the best candidate
                                for your team, your vision and the company as a whole.</p>
                    <?php
                        }else{
                    ?>
                            <p>Drop off your resume at the company you are interested in and help them see why you are the right one. Make it count by listing your top skills.</p>
                            <?php
                        }
                    ?>
                       <div class="drop-btn">
                            <a href="<?= Url::to('/drop-resume'); ?>" class="activate-drop arrow">View Details</a>
<!--                            <a href="--><!--" class="detail-drop">View Detail</a>-->
                        </div>
                    </div>
                    <div class="dr-how-it-works">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dr-how-text">
                                    <h3>How It Works</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="dr-box">
                                    <?php
                                        if(Yii::$app->user->identity->organization || Yii::$app->request->url == '/employers'){
                                    ?>
                                        <i class="fas fa-briefcase"></i>
                                        <p>Add categories</p>
                                        <?php
                                    }else{
                                        ?>
                                        <img src="<?= Url::to('@eyAssets/images/pages/drop-resume/search-profile.png')?>">
                                        <p>Search for and open the organization's profile</p>
                                        <?php
                                    }
                                        ?>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="dr-box">
                                <?php
                                if(Yii::$app->user->identity->organization || Yii::$app->request->url == '/employers'){
                                    ?>
                                    <i class="fas fa-copy"></i>
                                    <p>Candidates check your profile</p>
                                    <?php
                                }else{
                                    ?>
                                    <img src="<?= Url::to('@eyAssets/images/pages/drop-resume/click-on-cv-box.png')?>">
                                    <p> Click on the CV box icon</p>
                                    <?php
                                }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="dr-box">
                                <?php
                                if(Yii::$app->user->identity->organization || Yii::$app->request->url == '/employers'){
                                    ?>
                                    <i class="fas fa-user"></i>
                                    <p>Drop the candidate's resume accordingly</p>
                                    <?php
                                }else{
                                    ?>
                                    <img src="<?= Url::to('@eyAssets/images/pages/drop-resume/choose-profile.png')?>">
                                    <p>Apply for internships or jobs that suit your interests</p>
                                    <?php
                                }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-6">
                                <div class="dr-box">
                                <?php
                                if(Yii::$app->user->identity->organization || Yii::$app->request->url == '/employers'){
                                    ?>
                                    <i class="fas fa-check"></i>
                                    <p>When position opens, select ready applicant</p>
                                    <?php
                                }else{
                                    ?>
                                    <img src="<?= Url::to('@eyAssets/images/pages/drop-resume/be-patient.png')?>">
                                    <p>Be patient while the company responds</p>
                                    <?php
                                }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-5">
                    <div class="drop-image">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/drop-res.png') ?>" alt="drop resume">
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.drop-resume-text h3 {
    color: #000;
    font-family: roboto;
    font-weight: 600;
    font-size: 30px;
    letter-spacing: 0.3px;
}
.drop-resume-text p {
    color: #000;
    font-family: roboto;
    letter-spacing: 0.5px;
    font-size: 18px;
    line-height: 30px;
    text-transform: capitalize;
}
.drop-btn {
    margin-top: 25px;
}
.dr-box img {
    width: 100%;
    max-width: 60px;
}
.activate-drop {
    color: #fff;
    background-color: #00a0e3;
    font-size: 14px;
    font-family: roboto;
    border: 2px solid #00a0e3;
    padding: 3px 15px;
    border-radius: 4px;
    display: inline-block;
    transition: ease-in-out .2s;
    width: 145px;
}
.arrow {
  color: #fff;
  background-color: #00a0e3;
  margin: 1em 0;
}
.arrow::after {
  display: inline-block;
  font-size: 18px;
  padding-left: 12px;
  content: "➞";
  transition: transform 0.3s ease-out;
}
.arrow:hover {
  color: #00a0e3;
  background-color: #fff;
}
.arrow:hover::after {
  transform: translateX(10px);
}
.detail-drop {
    font-size: 16px;
    font-family: roboto;
    padding: 8px 15px;
    transition: 0.5s;
    cursor: pointer;
    display: inline-block;
    position: relative;
}
.detail-drop:after {
    content: "»";
    position: absolute;
    font-size: 22px;
    opacity: 0;
    top: 1px;
    right: -26px;
    transition: 0.5s;
}

.detail-drop:hover{
  padding-right: 24px;
  padding-left:8px;
}

.detail-drop:hover:after {
  opacity: 1;
  right: 10px;
}
.dr-box {
    text-align: center;
    margin-bottom: 30px;
    min-width: 100px;
}
.dr-box i {
    background: linear-gradient(180deg, #93C7FF 0%, #298EF9 100%);
    font-size: 25px;
    color: #fff;
    padding: 16px 18px;
    border-radius: 16px;
    margin-bottom: -3px;
}
.dr-how-text {
    margin-bottom: 20px;
}
.dr-box p{
    margin-top: 10px;
    font-family: roboto;
    letter-spacing: 0.3px;
    line-height: 16px;
    text-transform: capitalize;
    color: #6f6f6f;
    font-size: 13px;
    font-weight: 500;
    min-height: 32px;
}
.dr-how-text h3:after {
    width: 40px;
    height: 3px;
    background-color: #00a0e3;
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
}
.dr-how-text {
    margin-bottom: 20px;
    position: relative;
}
.dr-how-text h3 {
    font-family: roboto;
    font-weight: 500;
    font-size: 20pt;
}
@media only screen and (max-width: 425px){
    .dr-box p {
        min-height: 48px;
    }
}
@media screen and (max-width: 1200px) and (min-width: 1000px) {
    .drop-image {
        margin-top: 60px;
    }
}
@media screen and (max-width: 992px) and (min-width: 768px) {
    .drop-resume-text h3 {
        font-size: 24px;
    }
    .drop-resume-text p {
        font-size: 16px;
        line-height: 26px;
    }
    .dr-box i {
        font-size: 20px;
    }
    .dr-box p {
        font-size: 12px;
    }
    .drop-image {
        margin-top: 40px;
    }
}
@media screen and (max-width: 760px) and (min-width: 320px) {
    .drop-resume-text h3 {
        font-size: 22px;
    }
    .drop-resume-text p {
        font-size: 16px;
        line-height: 26px;
    }
    .drop-btn {
        margin-top: 0px;
    }
    .drop-image {
        display: none;
    }
    .dr-how-text h3 {
        font-size: 22px;    
    }
}
');
