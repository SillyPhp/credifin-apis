<?php

use yii\helpers\Url;

?>
    <section class="mentors-how-it-works">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mentors-hwi-heading">How It Works</p>
                </div>
            </div>
            <div class="row">
                <div class="mentors-flex-box">
                    <div class="mfb-row">
                        <div class="mfb-box margin-sm-100">
                            <div class="mfb-icons">
                                <img src="<?= Url::to('@eyAssets/images/pages/mentorship/apply.png') ?>">
                                <p>Apply To Be A Mentor</p>
                            </div>
                            <div class="mfb-icons arrows">
                                <img src="<?= Url::to('@eyAssets/images/pages/mentorship/arrow.png') ?>"
                                     class="showIMG">
                                <img src="<?= Url::to('@eyAssets/images/pages/mentorship/downside.png') ?>"
                                     class="hideIMG">
                            </div>
                            <div class="mfb-icons max90">
                                <img src="<?= Url::to('@eyAssets/images/pages/mentorship/select.png') ?>">
                                <p>Search For Mentee</p>
                            </div>
                        </div>

                        <div class="mfb-box margin-sm-100">
                            <div class="mfb-icons max100 ">
                                <img src="<?= Url::to('@eyAssets/images/pages/mentorship/mentor-hiw-search.png') ?>">
                                <p>Search For Mentor</p>
                            </div>
                            <div class="mfb-icons arrows">
                                <img src="<?= Url::to('@eyAssets/images/pages/mentorship/arrow.png') ?>"
                                     class="showIMG">
                                <img src="<?= Url::to('@eyAssets/images/pages/mentorship/downside.png') ?>"
                                     class="hideIMG">
                            </div>
                            <div class="mfb-icons margin80">
                                <img src="<?= Url::to('@eyAssets/images/pages/mentorship/mentor-hiw-program.png') ?>">
                                <p>Apply For Program</p>
                            </div>
                        </div>
                    </div>


                    <div class="mfb-box-colmun">
                        <div class="mfb-icons img-left">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/arrowtop.png') ?>" class="showIMG">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/right.png') ?>" class="hideIMG">
                        </div>
                        <div class="mfb-icons max170">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/commited.png') ?>">
                            <p> Match</p>
                        </div>
                        <div class="mfb-icons img-left">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/arrowbottom.png') ?>"
                                 class="showIMG">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/left.png') ?>" class="hideIMG">
                        </div>
                    </div>
                    <div class="mfb-box-2">
                        <div class="mfb-icons arrows">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/arrow.png') ?>" class="showIMG">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/downside.png') ?>" class="hideIMG">
                        </div>
                    </div>
                    <div class="mfb-box-2">
                        <div class="mfb-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/schedule.png') ?>">
                            <p>Schedule Your <br>Avaliable Sessions</p>
                        </div>
                    </div>
                    <div class="mfb-box-2">
                        <div class="mfb-icons arrows">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/arrow.png') ?>" class="showIMG">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/downside.png') ?>" class="hideIMG">
                        </div>
                    </div>
                    <div class="mfb-box-2">
                        <div class="mfb-icons">
                            <img src="<?= Url::to('@eyAssets/images/pages/mentorship/begin-work.png') ?>">
                            <p>Begin The Work</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="apply-program">
                        <p>Apply for our mentorship program today</p>
                        <button type="button" class="apply-mentor-btn">Apply now</button>
                    </div>
                </div>
            </div>
    </section>
<?php
$this->registerCss('
.margin100{
    margin-bottom:100px;
}
.margin80{
    margin-top: 65px;
}
.arrows img{
    max-width:40px !important;
}
.mentors-hwi-heading{
    font-size:30px;
    font-family: lora;
    color:#333;
    margin-bottom:20px;
}
.mentors-how-it-works{
   background: #ecf5fe;
    padding:50px 0;
}
.mentors-flex-box{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    align-items: center;
    text-align:center
    
}
.mfb-box{
 display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}
.mfb-box-colmun{
    display: flex; 
    flex-direction: column;
}
.mfb-icons p{
    color: #333;
    font-weight: bold;
    font-size: 16px;
}
.mfb-icons img{
    max-width:80px;
}
.max170 img{
    max-width:170px;
}
.max150 img{
    max-width:150px;
    margin-top:80px;
}
.max100 img{
    max-width: 80px;
    margin-top: 67px;
}
.max90 img{
       max-width: 123px;
}
.mfb-user{
    padding-right:50px;
}
.img-left{
    text-align: left;
    margin: 2px 0 19px -10px;
}
.hideIMG{
    display:none;
}
.mfb-icons p{
    padding-top:10px;
}
.apply-program{
    text-align:  center;
    margin-top: 20px;
}
.apply-program p{
    color:#333;
    font-size: 20px;
    text-transform: capitalize;
    font-weight: bold;
}
.apply-program button{
     text-transform: uppercase;
    background:#00a0e3;
    color:#fff;
    padding:15px 20px;
    border: 1px solid #00a0e3
}
@media screen and (max-width:992px){
    .mfb-row{
        display: flex;
    }
    .mentors-flex-box{
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: center;
        text-align:center    
    }
    .mfb-box{
        display: flex; 
        flex-direction: column;
    }
    .mfb-box-colmun{
        display: flex; 
        flex-direction: row;
    }
    .margin-sm-100 .mfb-icons{
            margin: 20px 50px;
    }
    .hideIMG{
        display:block;    
    }
    .showIMG{
        display:none;
    }
    .max150 img{
        margin-top:0px;
            max-width: 120px;
    }
    .mfb-icons{
        margin-top: 20px;
    }
    .img-left{
        margin:-10px 10px;
    }
    .max100 img{
        margin-top: 0px;
    }
}
@media screen and (max-width:450px){
    .margin-sm-100 .mfb-icons {
        margin: 0 10px;
    }
}
');
?>