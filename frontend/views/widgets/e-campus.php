<?php

use yii\helpers\Url;

?>
    <section class="e-background">
        <h2>Join Our Campus Placement Programme Today!</h2>
    </section>
    <div class="container">
        <div class="row">
            <div class="e-parent">
                <div class="e-inner">
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="e-campus1 ebox">
                            <div class="e-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/employers/jobq.png') ?>" alt=""/>
                            </div>
                            <div class="e-text" style="padding-top:10px;">campus Jobs</div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="e-campus2 ebox">
                            <div class="e-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/employers/weekend.png') ?>" alt=""/>
                            </div>
                            <div class="e-text">Weekend internships</div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="e-campus3 ebox">
                            <div class="e-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/employers/summer-internship.png') ?>"
                                     alt=""/>
                            </div>
                            <div class="e-text">summer internships</div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="e-campus4 ebox">
                            <div class="e-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/employers/winter.png') ?>" alt=""/>
                            </div>
                            <div class="e-text">Winter internships</div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="e-campus5 ebox">
                            <div class="e-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/employers/campus-ambassador.png') ?>"
                                     alt=""/>
                            </div>
                            <div class="e-text">campus ambassador</div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-6">
                        <div class="e-campus6 ebox">
                            <div class="e-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/employers/campus-internship1.png') ?>"
                                     alt=""/>
                            </div>
                            <div class="e-text">campus internships</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registercss('
.e-background{
    background-image: url("' . Url::to("@eyAssets/images/pages/employers/bg.png") . '");
    min-height: 400px;
    background-size: cover;
    background-repeat: no-repeat;
}
.e-background h2 {
    text-align: center;
    padding-top: 20px;
    font-size: 35px;
    font-family: lobster;
    color:#fff;
}
.e-parent {
    height: 125px;
    position: relative;
}
.e-inner {
    position: absolute;
    top: -50px;
}
.ebox {
    display: inline-block;
    padding: 15px 5px 5px 5px;
    margin-bottom:20px;
    width: 100%;
    min-height: 143px;
    border-radius: 5px;
    background-color:#fff;
    box-shadow:0 0 15px 0px #eee;
    border-bottom: 3px solid #ff7803;
    transition: ease-out .3s;
}
.ebox:hover{
    margin-top:-5px;
    box-shadow:0 10px 10px 0px #eee;
}
.e-icon {
    width:70px;
    height: 70px;
    margin:0 auto;
    text-align:center;
}
.e-icon img{
    max-width:60px;
    height:60px;
    width:100%;
}
.e-text {
    text-align:center;
    font-size: 20px;
    font-weight: 700;
    font-family: lora;
    text-transform: capitalize;
    line-height:25px;
}
@media(max-width:991px){
.e-background{
    min-height: 280px;
}
.e-parent {
    height: 250px;
}
.ebox:hover{
    margin-top:0px;
    box-shadow:0 10px 10px 0px #eee;
}
}
@media(max-width:768px){
.e-parent {
    height: 450px;
}    
}
');
