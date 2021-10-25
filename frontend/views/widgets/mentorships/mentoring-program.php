<?php

use yii\helpers\Url;

?>
    <section class="mentoring-category-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mentors-heading">Which Mentoring Program Solution ?</p>
                    <p class="mentors-sub-heading">Select A category or click here to discover other mentoring program
                    categories</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="mentoring-category">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentorship/mentoring-employee-programs.png') ?>">
                        <p class="mentoring-category-heading">Employee Mentoring Programs</p>
                        <p>For companies or government organizations</p>
<!--                        <a href="">Learn More</a>-->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mentoring-category">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentorship/mentoring-entrepreneur-programs.png') ?>">
                        <p class="mentoring-category-heading">Entrepreneur Mentoring Programs</p>
                        <p>For accelerators, incubators, Entrepreneurship programs</p>
<!--                        <a href="">Learn More</a>-->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mentoring-category">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentorship/mentoring-student-programs.png') ?>">
                        <p class="mentoring-category-heading">Alumni & Student Mentoring Programs</p>
                        <p>For Universities, Alumni network, high schools</p>
<!--                        <a href="">Learn More</a>-->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mentoring-category">
                        <img src="<?= Url::to('@eyAssets/images/pages/mentorship/mentoring-community-programs.png') ?>">
                        <p class="mentoring-category-heading">Community Mentoring Programs</p>
                        <p>For Associations, Groups, NGOs, Charities</p>
<!--                        <a href="">Learn More</a>-->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.mentoring-category-section{
    padding:50px 0;
    text-align:center;
    font-family: roboto;
}
.mentors-sub-heading{
    font-size: 16px;
    color: #333;
    line-height: 25px;
    margin-bottom:40px;
}
.mentors-heading{
    font-size:30px;
    font-family: lora;
    color:#333;
    margin-bottom:5px;
}
.mentoring-category{
    margin-bottom:20px;
    color:#333;
    padding:0 10px;
}
.mentoring-category-heading{
    font-size: 23px;
    font-family: lora;
    line-height: 25px;
    margin-top: 20px;
}

');
?>