<?php

use yii\helpers\Url;

?>
    <section class="header-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="pos-relative">
                        <div class="h-heading"><span>Work With Us</span>
                            <div class="h2-text">Start your career at empower youth</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="jobs-row">
                        <div class="heading-style">Explore Jobs</div>
                        <div id="jobs_careers_cards" class="job-cards-row"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="jobs-row">
                        <div class="heading-style">Explore Internships</div>
                        <div id="internships_careers_cards" class="job-cards-row"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
echo $this->render('/widgets/mustache/careers-cards');
$this->registerCss('
.pos-relative{
    position:relative;
    height:250px;
}
.header-bg{
    background:url(' . Url::to('@eyAssets/images/pages/careers/careers-bg.png') . ');
    background-size:cover;
    min-height:450px;
}
.h-heading{
    position:absolute;
    top:50%;
    right:20px;
    transform: translateY(-50%);
    font-size:40px;
    color:#fff;
}
.h-heading span{
    font-family:lobster;
}
.h2-text{
    font-size:25px;
    margin-top:-15px;
}
@media only screen and (max-width:1200px){
   .h-heading{
        color:#fff;
        font-size:30px;
   }
   .h2-text{
        font-size:15px;
   }   
}
@media only screen and (max-width:992px){
    .header-bg{
        background-image:none;
        background:#1ea6a1 !important;
         min-height:300px;
    }
    .h-heading{
        color:#fff;
        font-size:40px;
        top:50%;
        left:%50;
        transform: translate(-50%, -50%);
    }
    .h2-text{
        font-size:25px;
    }
}
');
$script = <<<JS
getCareersCards("Jobs",'#jobs_careers_cards');
getCareersCards("Internships",'#internships_careers_cards');
JS;
$this->registerJs($script);