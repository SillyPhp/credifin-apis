<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

?>

    <section>
        <div class="row">
            <div class="col-md-3">
                <div class="parent-3 nd-shadow">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="comp-box">
                                <div class="comp-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/1company.png') ?>">
                                </div>
                                <div class="comp-info">
                                    <div class="comp-name">Company Name</div>
                                    <div class="comp-opp">Total Opportunities 5</div>
                                    <div class="comp-jobs">2 Jobs , 3 Internships</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="comp-box">
                                <div class="comp-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/1company.png') ?>">
                                </div>
                                <div class="comp-info">
                                    <div class="comp-name">Company Name</div>
                                    <div class="comp-opp">Total Opportunities 5</div>
                                    <div class="comp-jobs">2 Jobs , 3 Internships</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="comp-box">
                                <div class="comp-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/1company.png') ?>">
                                </div>
                                <div class="comp-info">
                                    <div class="comp-name">Company Name</div>
                                    <div class="comp-opp">Total Opportunities 5</div>
                                    <div class="comp-jobs">2 Jobs , 3 Internships</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="comp-box">
                                <div class="comp-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/1company.png') ?>">
                                </div>
                                <div class="comp-info">
                                    <div class="comp-name">Company Name</div>
                                    <div class="comp-opp">Total Opportunities 5</div>
                                    <div class="comp-jobs">2 Jobs , 3 Internships</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="comp-box">
                                <div class="comp-logo">
                                    <img src="<?= Url::to('@eyAssets/images/pages/hr-recruiters/1company.png') ?>">
                                </div>
                                <div class="comp-info">
                                    <div class="comp-name">Company Name</div>
                                    <div class="comp-opp">Total Opportunities 5</div>
                                    <div class="comp-jobs">2 Jobs , 3 Internships</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="parent-9 nd-shadow">

                </div>
            </div>
        </div>
    </section>

<?php
$this->registerCss('
.comp-box{
    border:1px solid #eee;
    border-radius:5px; 
    margin:5px; 
    padding:8px;
    display:flex;
}
.comp-logo{
    display:inline-block;
}
.comp-logo img{
    width:80px;
    height:80px;
}
.comp-info{
    display:inline-block;
    padding-top:7px;
    padding-left:15px;
    line-height:22px;
}
');