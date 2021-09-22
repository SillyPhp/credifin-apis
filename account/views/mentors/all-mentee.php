<?php

use yii\helpers\Url;
?>
<section>
    <div class="row mt3">
        <div class="col-md-3">
            <h4 class="mentor-heading">Total Mentee</h4>
            <div class="md-stats-box">
                <div class="md-earning"><i class="fa fa-users"></i> 464</div>
                <div>Last mentee shshank</div>
                <div>Last menteww Ajay</div>
            </div>
        </div>
        <div class="col-md-3">
            <h4 class="mentor-heading">New Mentee</h4>
            <div class="md-stats-box">
                <div class="md-earning"><i class="fa fa-user"></i> 25</div>
                <div>Recently Joined shshank Vasisht</div>
                <div>joined on 25th jan 2020</div>
            </div>
        </div>
        <div class="col-md-3">
            <h4 class="mentor-heading">Pending Approval's</h4>
            <div class="md-stats-box">
                <div class="md-earning"><i class="fa fa-user"></i> 5</div>
                <div>Last Application Ravinder singh</div>
                <div>applied on 25th jan 2020</div>
            </div>
        </div>
    </div>
</section>
<section class="mt3">
        <h4 class="mentor-heading">Your Mentee</h4>
    <div class="row">
        <div class="col-md-3">
            <div class="md-mentee-box">
                <div class="mentee-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                </div>
                <div class="mentor-dashboard-details">
                    <div class="md-name">Ajay Juneja</div>
                    <div class="md-skills">Yii2, JavaScript</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="md-mentee-box">
                <div class="mentee-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                </div>
                <div class="mentor-dashboard-details">
                    <div class="md-name">Shshank Vasisht</div>
                    <div class="md-skills">HTML, JavaScript, Bootstrap</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="md-mentee-box">
                <div class="mentee-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                </div>
                <div class="mentor-dashboard-details">
                    <div class="md-name">Tarandeep Singh Rakhra</div>
                    <div class="md-skills">Yii2</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="md-mentee-box">
                <div class="mentee-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                </div>
                <div class="mentor-dashboard-details">
                    <div class="md-name">Ajay Juneja</div>
                    <div class="md-skills">Yii2, JavaScript</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="md-mentee-box">
                <div class="mentee-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                </div>
                <div class="mentor-dashboard-details">
                    <div class="md-name">Shshank Vasisht</div>
                    <div class="md-skills">HTML, JavaScript, Bootstrap</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="md-mentee-box">
                <div class="mentee-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                </div>
                <div class="mentor-dashboard-details">
                    <div class="md-name">Tarandeep Singh Rakhra</div>
                    <div class="md-skills">Yii2</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="md-mentee-box">
                <div class="mentee-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                </div>
                <div class="mentor-dashboard-details">
                    <div class="md-name">Tarandeep Singh Rakhra</div>
                    <div class="md-skills">Yii2</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="md-mentee-box">
                <div class="mentee-icon">
                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>">
                </div>
                <div class="mentor-dashboard-details">
                    <div class="md-name">Tarandeep Singh Rakhra</div>
                    <div class="md-skills">Yii2</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="m-view-more-button">
                <button type="button" class="">View More</button>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.m-view-more-button{
    text-align: center;
}
.m-view-more-button button{
    background: #00a0e3;
    color: #fff;
    padding: 10px 15px;
    border: none;
}
.mt3{
    margin-top: 30px;
}
.mentor-heading{
    font-size: 20px;
    margin: 0px 0 15px 0;
    line-height: 20px;
    font-family: lora;
    color: #333;
}
.md-stats-box{
    box-shadow: 0px 1px 10px 2px #eee !important;
    padding: 20px 15px;
    font-family: roboto;
    text-transform: capitalize;
    position: relative;
    border-radius: 10px; 
} 
.mentor-dashboard-details{
    margin-left: 20px;
}
.md-earning{
    font-size: 25px; 
    font-family: lora;
    color:#000;
    font-weight: bold;
}
.md-mentee-box{
    display: flex;
    box-shadow: 0px 1px 10px 2px #eee !important;
    padding: 20px 15px;
    align-items: center;
    font-family: roboto;
    margin-bottom: 10px;
    border-radius: 10px;   
}
.mentee-icon{
    min-width: 70px;
    max-width: 70px;
    min-height: 70px;
    max-height: 70px;
    border-radius: 50%;
    overflow: hidden;
}
.mentee-icon img{
    width: 100%;
    height: 100%;
}
.md-name{
    font-size: 20px;
    font-family: lora;
    font-weight: bold;
    line-height: 20px;
}
')
?>
