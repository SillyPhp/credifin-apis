<?php
use yii\helpers\Url;
?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6" pics>
                    <div class="exp-jobs">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/expired-job-icon1.png') ?>"/>
                    </div>
                    <div class="pic1 moving">
                        <img src="<?= Url::to('@eyAssets/images/pages/custom/settings.png') ?>"/>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="exp-txt">
                        <h1>The job you are looking for has just got expired..</h1>
                        <h2>Awww.. Don't Worry!!</h2>
                        <h4><a href="<?= Url::to('/jobs/list') ?>"
                           class="butn success">
                            Go Back
                        </a></h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class=" col-md-12">
                    <div class="job-exp">
                        <h3>Similar Jobs That You Can Also Apply For!</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.butn{
   border: 2px solid black;
   background-color: white;
   font-color: black;
   padding: 10px 20px;
   font-size: 16px;
   cursor: pointer;
   border-radius: 10px;
}
.success {
  border-color: #53bbeb;
  color: #00a0e3;
}
.success:hover {
  background-color: #53bbeb;
  color: white;
  transition-duration: 0.4s;
}
.exp-txt{
    padding-top: 140px;
} 
.exp-txt h2{
    color: #00a0e3;
    font-family: lobster;
    max-width: 500px;
    line-height: 26px;
    font-size: 46px;
    margin-bottom: 48px;
}
.exp-txt h1{
    font-weight: 500;
    font-size: 22px;
    font-family: lora;
    margin-bottom: 20px;
    margin-top: 140px;
}
.exp-jobs{
    margin-top: 150px;
}
.job-exp h3{
    padding: 30px 0 10px 20px;
    font-weight: 700;
    font-family: lobster;
    font-size: 30px;
}

.pics{
    position: relative;
    }
.pics img {
    width: 100%;
} 
.pic{
    position: absolute;
    top: 235px;
    left: 70px;
    width: 90px;
    height: 100px;
    z-index: 2;
    }
.pic1{
    position: absolute;
    top: 110px;
    left: 250px;
    z-index: 0;    
    animation: mymove 7s infinite linear;
}
@keyframes mymove {
   from { 
            transform: rotate(0deg);
        }
   to  { 
            transform: rotate(359deg);
        }
}
@media screen and (max-width:1150px) and (min-width:990px) {
    .pic1{ 
        left: 228px; 
    }
    .exp-txt{
    padding-top: 100px;
} 
}
@media screen and (max-width:991px) and (min-width:768px) {
    .pic1{ 
        top: 125px;
        left: 173px;
    }
    .pic1 img{
        width: 46px;
        height: 47px;
        }
    .exp-txt{
    padding-top: 80px;
    } 
    .exp-txt h2{
    font-size: 35px;
    }
    .exp-txt h1{
    font-size: 18px;
    }
    .butn{
    font-size: 12px;
    }
    .job-exp h3{
    font-size: 25px;
    }
}
@media screen and (max-width:768px){
    .exp-jobs{
     text-align: center;
    }
    .pic1{ 
        top: -30px;
        left: 300px;
    }
    .exp-txt{
    padding-top: 20px;
    } 
    .exp-txt h2{
    font-size: 35px;
    margin-top: 5px;
    margin-bottom: 35px;
    }
    .exp-txt h1{
    font-size: 20px;
    }
    .butn{
    font-size: 10px;
    margin-left: -8px;
    }
    .job-exp h3{
    font-size: 22px;
    }
    .exp-txt{
    text-align: center;
    margin-left: 70px;
    }
    .job-exp h3{
    margin-top: -8px;
    }
}
@media screen and (max-width:510px) and (min-width: 320px){
.exp-jobs{
     text-align: center;
    }
    .pic1{ 
        top: -30px;
        left: 240px;
    }
    .exp-txt{
    padding-top: 20px;
    } 
    .exp-txt h2{
    font-size: 35px;
    margin-top: 10px;
    margin-bottom: 35px;
    }
    .exp-txt h1{
    font-size: 20px;
    }
    .butn{
    font-size: 10px;
    margin-left: -2px;
    }
    .job-exp h3{
    font-size: 22px;
    }
    .exp-txt{
    text-align: center;
    margin-left: 10px;
    }
    .job-exp h3{
    margin-top: -8px;
    }
}
');
?>