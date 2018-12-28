<?php

use yii\helpers\Url;
?>
<ul class="menuzord-menu">
    <!--<li><a href="<?= Url::to('/'); ?>"><?= Yii::t('frontend', 'Home'); ?></a></li>-->
    <li><a href="<?= Url::to('/service/internships'); ?>"><?= Yii::t('frontend', 'Internships'); ?></a></li>
    <li><a href="<?= Url::to('/service/jobs'); ?>"><?= Yii::t('frontend', 'Jobs'); ?></a></li>
    
<!--    <li><a href="<?= Url::to('#'); ?>"><?= Yii::t('frontend', 'Problems We Solve'); ?></a>
        <div class="megamenu megamenu-quarter-width half-min bg-colr">
            <div class="megamenu-row">
                <div class="col12">
                    <div class="col6">
                        <ul class="list-unstyled">
                            <li>
                                <a href="<?= Url::to('/service/internships'); ?>">
                                    <h4><i class="fa fa-connectdevelop"></i> &nbsp;&nbsp;<?= Yii::t('frontend', 'Internships'); ?></h4>
                                    <p>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    </p>
                                </a>
                            </li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/service/notes'); ?>"><?= Yii::t('frontend', 'Notes'); ?></a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/service/question-papers'); ?>"><?= Yii::t('frontend', 'Question Papers'); ?></a></li>
                        </ul>
                        
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/service/resume'); ?>"><?= Yii::t('frontend', 'Create Resume'); ?></a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/service/learning-corner'); ?>"><?= Yii::t('frontend', 'Learning Corner'); ?></a></li>
                        </ul>
                    </div>
                    <div class="col6">
                        <ul class="list-unstyled">
                            <li>
                                <a href="<?= Url::to('/service/jobs'); ?>">
                                    <h4><i class="fa fa-instagram"></i> &nbsp;&nbsp;<?= Yii::t('frontend', 'Job Search'); ?></h4>
                                    <p>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                    </p>
                                </a>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/service/training-programs'); ?>"><?= Yii::t('frontend', 'Training Programs'); ?></a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/service/freelancers'); ?>"><?= Yii::t('frontend', 'Freelancers'); ?></a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/service/education-loans'); ?>"><?= Yii::t('frontend', 'Education Loans'); ?></a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/service/mock-interviews'); ?>"><?= Yii::t('frontend', 'Mock Interviews'); ?></a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/service/startup-support'); ?>"><?= Yii::t('frontend', 'Startup Support'); ?></a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/service/scholarships'); ?>"><?= Yii::t('frontend', 'Scholarships'); ?></a></li>
                        </ul>
                    </div>
                    <div class="col4">
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/educational-institute'); ?>"><?= Yii::t('frontend', 'Educational Institute'); ?></a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/ngo'); ?>"><?= Yii::t('frontend', 'NGO'); ?></a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/trainer'); ?>"><?= Yii::t('frontend', 'Trainer'); ?></a></li>
                        </ul>
                        <ul class="list-unstyled">
                            <li><a href="<?= Url::to('/jobs-provider'); ?>"><?= Yii::t('frontend', 'Jobs Provider'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </li>-->
    <!--<li><a href="<?= Url::to('/blog'); ?>"><?= Yii::t('frontend', 'Blog'); ?></a></li>-->
    <?php if(!Yii::$app->user->isGuest): ?>
    <li><a href="<?= Url::to('/account/dashboard'); ?>"><?= Yii::t('frontend', 'Dashboard'); ?></a></li>
    <li><a href="<?= Url::to('/logout'); ?>" data-method="post"><?= Yii::t('frontend', 'Logout'); ?></a></li>
    <?php else: ?>
    <li><a href="<?= Url::to('/login'); ?>"><?= Yii::t('frontend', 'Login'); ?></a></li>
    <?php endif; ?>
</ul>
<?php
$this->registerCss('
.menuzord-menu > li > .megamenu.megamenu-quarter-width{
    width: 36%;
}
.list-unstyled li a h4{
    margin:0px;
}
.list-unstyled li a p{
    padding: 2px;
    color: #6c6c6c;
    font-size: 13px;
    line-height: 1.6;
    padding-top: 5px;
}
.list-unstyled li:hover a h4{
    font-weight: 700;
}
.bg-theme-colored{
    background-color: #fff !important;
}
.border-bottom-theme-color-2-1px{
    border-bottom:1px solid #ddd !important;
}
.menuzord-menu li{
    padding: 6px 0px !important;
}
.menuzord-menu li a{
    font-size: 19px !important;
    color: #49a1e3;
    font-family: Georgia;
}
.bg-colr{
//    background: linear-gradient(90deg, #fff 65%, #ddd 40%) !important;
    background-color:#fff;
}
.menuzord-menu > li > a {
    padding: 6px 15px !important;
}
.menuzord-brand{
    margin-top: 7px !important;
}
.side-panel-trigger{
    margin-top: 17px !important;
}
.side-panel-trigger a i{
    color:#4aa2e2 !important;
}
.add-padding .menuzord .side-panel-trigger a i{
    color: #f08440 !important;
}
.menuzord-menu > li > .megamenu{
    top:50px !important;
}
.menuzord-menu > li > .megamenu{
    padding:12px !important;
}
.megamenu{
//    background-color: #fafafa !important;
    border-radius: 3px;
    border: 0px;
//    border-top: 4px solid #f08240 !important;
    box-shadow: 0px 3px 11px 5px #dddddd7a;
}
.menuzord .menuzord-menu > li.active > a i, .menuzord .menuzord-menu > li:hover > a i, .menuzord .menuzord-menu ul.dropdown li:hover > a i{
    color: #fff;
}
.menuzord.orange .menuzord-menu > li.active > a, .menuzord.orange .menuzord-menu > li:hover > a, .menuzord.orange .menuzord-menu ul.dropdown li:hover > a{
    background-color: #49a1e3 !important;
    color:#FFF !important;
}
.menuzord-menu > li > a{
    border-radius: 10px !important;
}
.list-unstyled li:first-child a{
    font-size: 19px !important;
    color: #49a1e4;
    font-family:Georgia;
//    margin-bottom: 15px !important;

}
.list-unstyled-2 li:first-child a{
    border-bottom: 0px !important;
}
.list-unstyled li:first-child a:hover{
    color:#49a1e4 !important;
    background-color: transparent !important;
}
.list-unstyled li a{
    font-size: 16px !important;
    color:#252525;
    cursor: pointer;
//    white-space: nowrap;
//    overflow: hidden;
//    text-overflow: ellipsis;
    transition: all .1s ease-in-out !important;
    text-decoration: none !important;
}
.list-unstyled li{
    padding: 3px 0px !important;
}
.list-unstyled li a:hover{
    color:#fff !important;
    background-color: #f08340 !important; 
}
.menuzord-menu > li > .megamenu .megamenu-row li a{
    padding: 0px;
}
.menuzord-menu > li > .megamenu .megamenu-row li.active > a, .menuzord-menu > li > .megamenu .megamenu-row li:hover > a{
    padding-left: 0px !important;
}
//.menuzord-menu > li > .megamenu .megamenu-row li.active > a, .menuzord-menu > li > .megamenu .megamenu-row li:hover > a{
//    color: #FFF !important;
//    background-color: #f08340 !important;
//}
.menuzord-menu > li.active > a, .menuzord-menu > li:hover > a {
    background-color:#49a1e3 !important;
    color:#fff !important;
}
@media only screen and (max-width:1100px){
    .megamenu{
        padding-left: 0px !important;
    }
}
@media only screen and (max-width:1100px){
    .list-unstyled li a{
        word-wrap: normal;
    }
}
.quarter-min{
    width:18% !important;
}');
