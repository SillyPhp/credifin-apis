<?php

use yii\helpers\Url;

?>

    <section class="teacher-head-bg">
       <div class="container">
           <div class="row">
               <div class="col-md-4 col-sm-4">
                    <div class="teacher-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/jobs/drop-cv-teacher-img.png') ?>" alt="">
                    </div>
               </div>
               <div class="col-md-8 col-sm-8">
                   <div class="teacher-txt">
                       <h3>Are You A Qualified And Experienced Teacher<br>
                           Looking For A Job In A Reputed Institution?</h3>
                       <p>Drop your resume in the institution's resume box.<br>
                           Get noticed by them first as soon as any vacancy arises.</p>
                       <div class="teacher-btn">
                           <a href="<?= Url::to('/hsbcbankpvtltd3098/reviews'); ?>" target="_blank">DROP RESUME FOR TEACHERS</a>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </section>

<?php
$this->registerCss('
.teacher-head-bg{
//    background-image: url(' . Url::to('@eyAssets/images/pages/jobs/drop-cv-teacher-bg.png') . ');
//    background-repeat: no-repeat;
//    background-size: cover;
//    min-height: 400px;
    background-color: #fbfbff;
        padding: 10px 0 40px;
}
.teacher-img {
    margin-top: 25px;
}
.teacher-txt {
    margin-top: 65px;
}
.teacher-txt h3 {
    font-size: 40px;
    font-family: lobster;
    color: #ff7803;
    text-align: center;
}
.teacher-txt p {
    font-size: 22px;
    line-height: 30px;
    text-align: center;
    font-family: roboto;
    font-weight: 600;
    color: #000;
}
.teacher-btn {
    text-align: center;
    margin-top: 20px;
}
.teacher-btn a {
    color: #fff;
    background-color: #ff7803;
    font-size: 20px;
    font-weight: 600;
    font-family: lora;
    border: 2px solid #fff;
    padding: 12px 40px;
    border-radius: 2px;
    display: inline-block;
    cursor: pointer;
    transition: ease-in-out .2s;
}
.teacher-btn a:hover{
    border: 2px solid #ff7803;
    color: #ff7803;
    background-color: #fff;
}
@media only screen and (max-width: 1024px) and (min-width: 992px){
    .teacher-img {
        margin: 55px 0px 0px 0px;
    }
    .teacher-txt h3 {
        font-size: 30px;
    }
    .teacher-txt p {
        font-size: 20px;
    }
    .teacher-btn a {
        font-size: 18px;
        padding: 12px 20px;
    }
    .teacher-txt {
        margin-top: 90px;
    }
}
@media only screen and (max-width: 990px) and (min-width: 768px){
    .teacher-img img{
        max-width: 110%;
    }
    .teacher-img {
        margin-top: 36px;
    }
    .teacher-txt {
        margin-top: 26px;
    }
    .teacher-txt h3 {
        font-size: 26px;
    }
    .teacher-txt p {
        font-size: 17px;
        line-height: 25px;
    }
    .teacher-btn a {
        font-size: 18px;
        padding: 10px 14px;
    }    
    .teacher-head-bg {
        min-height: 320px;
    }
}
@media only screen and (max-width: 758px) and (min-width: 590px){
    .teacher-head-bg {
        background-image: url(' . Url::to('@eyAssets/images/pages/jobs/bg.jpg') . ');
    }
    .teacher-img img {
        max-width: 90%;
        width: 275px;
    }
    .teacher-txt h3 {
        font-size: 30px;
    }
    .teacher-txt p {
        font-size: 18px;
        line-height: 24px;
    }
    .teacher-img {
        margin-top: 25px;
        text-align: center;
    }
    .teacher-btn a {
        font-size: 12px;
        padding: 11px 12px;
        margin-bottom: 30px;
    }
    .teacher-txt {
        margin-top: 5px;
    }
}
@media only screen and (max-width: 585px) and (min-width: 320px){
    .teacher-head-bg {
       background-image: url(' . Url::to('@eyAssets/images/pages/jobs/bg.jpg') . ');
    }
     .teacher-img img {
        max-width: 90%;
        width: 275px;
    }
     .teacher-txt h3 {
        font-size: 26px;
    }
    .teacher-txt p {
        font-size: 16px;
        line-height: 24px;
    }
    .teacher-img {
        margin-top: 25px;
        text-align: center;
    }
    .teacher-btn a {
        font-size: 12px;
        padding: 11px 12px;
        margin-bottom: 30px;
    }
     .teacher-txt {
        margin-top: 5px;
    }
}
');
