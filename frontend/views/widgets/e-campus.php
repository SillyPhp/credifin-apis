<?php

use yii\helpers\Url;

?>
    <section class="e-background"></section>
    <div class="container">
        <div class="row">
            <div class="e-parent">
                <div class="e-inner">
                    <div class="e-campus1 ebox">
                        <div class="e-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/jobs.png') ?>" alt=""/>
                        </div>
                        <div class="e-text">Jobs</div>
                    </div>
                    <div class="e-campus2 ebox">
                        <div class="e-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/campus-internship.png') ?>" alt=""/>
                        </div>
                        <div class="e-text">Weekend internships</div>
                    </div>
                    <div class="e-campus3 ebox">
                        <div class="e-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/campus-internship.png') ?>" alt=""/>
                        </div>
                        <div class="e-text">summer internships</div>
                    </div>
                    <div class="e-campus4 ebox">
                        <div class="e-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/ambas-profile.png') ?>" alt=""/>
                        </div>
                        <div class="e-text">campus ambassador</div>
                    </div>
                    <div class="e-campus5 ebox">
                        <div class="e-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/employers/campus-internship.png') ?>" alt=""/>
                        </div>
                        <div class="e-text">campus internships</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registercss('
.e-background{
    background-image: url("' . Url::to("@eyAssets/images/pages/employers/e-campus-mainn.png") . '");
    min-height: 400px;
    background-size: cover;
    background-repeat: no-repeat;
}
.e-parent {
    height: 125px;
    position: relative;
}
.e-inner {
    position: absolute;
    top: -80px;
}
.ebox {
    display: inline-block;
    padding-top: 20px;
    width: 190px;
    min-height: 170px;
    margin:0 20px;
    border-radius: 10px;
    background-color:#fff;
    box-shadow:0 0 18px -4px;
    border-bottom: 15px solid #ff7803;
    float:left;
}
.e-icon {
    width:70px;
    height: 75px;
    padding-left: 10px;
}
.e-text {
    text-align:left;
    font-size: 20px;
    font-weight: 700;
    font-family: roboto;
    text-transform: capitalize;
    line-height:22px;
    padding-left: 10px;
}
.e-icon, .e-text{

}
');
