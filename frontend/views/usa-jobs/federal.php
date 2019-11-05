<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

Yii::$app->view->registerJs('var keywords = "' . $keywords . '"', \yii\web\View::POS_HEAD);
?>
    <section>
        <div class="bg-img">
            <img src="<?= Url::to('@eyAssets/images/usajobs/federal employee5(1).png'); ?>" class="img_load">
        </div>
        <div id="back-color">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="usa-heading bg-color">
                            <img src="<?= Url::to('@eyAssets/images/usajobs/employees1.png'); ?>"
                                 class="img_load">
                            <h3>Federal Employees </h3>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <p class="paragraph">If you are a current or former federal employee, there are
                            different
                            hiring options available to you, depending on your eligibility.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>Eligibility </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <P>Being a federal employee doesn't mean you're eligible for every federal job, so it's
                            important to
                            understand: </P>
                        <ul class="list-2">
                            <li>Which service you belong to.</li>
                            <li>The appointment type you are serving on.</li>
                        </ul>
                        <p>Understanding this will help you know which jobs you’re eligible for and prevent you from
                            spending time on jobs for which you’re not eligible. </p>
                        <P>Being eligible for a job is different from being qualified for a job.<a href="https://www.usajobs.gov/Help/faq/application/eligibility/difference-from-qualifications/" target="_blank"> Understand
                                the
                                difference.</a></P>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>Services </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p>Services are how the Federal Government describes categories of jobs that provide different
                            options and benefits to the future employee. There are three services in the Federal
                            Government. </p>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="card-box">
                            <a class="services" href="https://www.usajobs.gov/Help/working-in-government/unique-hiring-paths/federal-employees/#competitive-service">Competitive Service</a>
                            <div class="services-p">
                                Positions with agencies that follow the U.S. Office of Personnel Management's hiring
                                rules
                                and pay scales.
                            </div>
                            <div class="text">
                                <h5> Eligible to apply for merit promotion jobs?</h5>
                                <p class="service-text"><i class="fa fa-check" aria-hidden="true"></i> <strong>
                                        Yes</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="card-box">
                            <a class="services" href="https://www.usajobs.gov/Help/working-in-government/unique-hiring-paths/federal-employees/#excepted-service">Expected Service</a>
                            <div class="services-p">
                                Positions with agencies that have their own hiring rules, pay scales, and evaluation
                                criteria.
                            </div>
                            <div class="text ser-bg-pink">
                                <h5> Eligible to apply for merit promotion jobs?</h5>
                                <p class="service-text"><i class="fa fa-times" aria-hidden="true"></i><strong>
                                        No,</strong>unless
                                    your agency has an <a href="https://www.usajobs.gov/Help/working-in-government/unique-hiring-paths/federal-employees/interchange-agreements/" target="_blank"> Interchange Agreement.</a> But you can apply to jobs
                                    that
                                    are <a href="https://www.usajobs.gov/Help/working-in-government/unique-hiring-paths/public/" target="_blank" >open to the public</a> and federal employees -- excepted service. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="card-box">
                            <a class="services" href="https://www.usajobs.gov/Help/working-in-government/unique-hiring-paths/senior-executive-service/">Senior Executive Service</a>
                            <div class="services-p">
                                Positions with agencies that follow the U.S. Office of Personnel Management's hiring
                                rules
                                and pay scales.
                            </div>
                            <div class="text ser-bg-pink">
                                <h5> Eligible to apply for merit promotion jobs?</h5>
                                <p class="service-text"><i class="fa fa-times" aria-hidden="true"></i><strong>
                                        No</strong>
                                    but you can apply to jobs that are <a href="https://www.usajobs.gov/Help/working-in-government/unique-hiring-paths/public/" target="_blank"> open to the public</a> or other jobs in the<a href="https://www.usajobs.gov/Help/working-in-government/unique-hiring-paths/senior-executive-service/" target="_blank"> Senior
                                        Executive Service.</a> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="text-body">
                            <h2>Not sure what service you fall under? </h2>
                            <a href="https://www.usajobs.gov/Help/working-in-government/service/SF-50/" target="_blank"> <button class="buton">Learn how to determine your service and appointment type</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

 <?php
$this->registerCss("	
 .bg-img img{
	display: block;
	width: 100%;
 }

 #back-color{
 	background-color: #f4003f;
 	padding-top: 4.5rem;
    padding-bottom: 4.5rem;
 }

 .bg-color img {
	position: relative;
	margin-top: -12rem;
	max-width: 45%;
}
.usa-heading h3{
    font-family: Roboto;
	font-weight: 700;
	line-height: 1.3;
	margin-bottom: .5rem;
	margin-top: 1.5rem;
}
.bg-color h3 {
	font-size: 2.1rem;
	color: #fff;
	margin-top: 0;
}
.heading-box h3{
	font-size: 1.6rem;
    color: #0e1c66;
}
.paragraph{
	margin-bottom: .5rem;
	margin-top: 1.5rem;
	font-size: 1.4rem;
	font-family: roboto;
	font-weight: 400;
	line-height: 1.7;
	color:white;
}
.para {
	line-height: 1.9;
	margin-bottom: 3em;
	margin-top: 1em;
	font-size: 17px;
	font-family: roboto;
	color: #000;
}
.feature-box{
    border-bottom: 1px solid lightgray;
    margin-bottom: 10px;
}
.text a, .list-option li a, .para a{
 color: #6d2bcc; 
}

.list-2{
    list-style: disc;
    padding-left: 23px; 
}

.list-option{
	padding-top: 3rem;
	padding-bottom: 3rem;
	margin: 1rem auto;
}

.list-option li{
	display: inline-block;
}


.paragraph p{
	font-size: 17px;
	font-family: roboto;
	margin-bottom: 20px;
    margin-top: 20px;
    color: black;
    padding: 10px;
}
.card-box{
	border: 1px solid lightgray;
	margin-bottom: 20px;
}
.services {
	display: block;
    padding: 1.1rem;
    font-weight: 700;
    font-size: 15px;
    background-color: #dce4ef;
    color:  black;
}

.services-p{
	padding: 5px;
	min-height: 11.9rem;
}

#main-mg {
	margin-bottom: 40PX;
}

.text-box p {
	margin-bottom: .5rem;
	margin-top: 6.5rem;
	font-size: 27px;
	font-family: roboto;
	font-weight: 400;
	line-height: 1.7;
	color: white;
}

.text {
	padding:5px;
	background-color:
	aliceblue;
	min-height: 14.9rem;
}

.text h5 {
	font-weight: 700;
	line-height: 1.3;
	margin-bottom: .5rem;
	font-size: 1.1rem;
	font-family: roboto;
}

.text-body{
	border: 1px solid lightgray;
	padding: 1.5rem;
	margin-bottom: 10px;
}

.buton{
	background-color: transparent;
	border: 3px solid #154899;
	padding: 10px;
	border-radius: 5px;
	font-size: 15px;
	font-weight: 700;
	color: #19588e;
}

.text-body h2 {
	font-family: Roboto;
	font-weight: 700;
	line-height: 1.3;
	margin-bottom: 2.5rem;
	margin-top: 1.5rem;
	font-size: 1.4rem;
	color: #112e51;
}

.fa-times{
	color: red;
}
.fa-check{
	color:green;
}
.ser-bg-pink{
	background-color: #f9dede;
}

@media only screen and (max-width: 360px){
    .bg-color{text-align: center;}
     .heading-box h3 {padding-left: 0; font-size: 2.6rem; }
     .services-p {	padding: 1.5rem; min-height: 0rem;}
     .text {padding: 1.5rem;background-color: aliceblue; min-height: 0rem; }
     .text h5{font-size: 2.1rem;}
     .paragraph{ font-size: 2.4rem;}
     h3{ font-size: 2.5rem;}
     .para{ font-size: 18px;}
}
@media (min-width:768px) and (max-width:1024px){
	.services-p {	padding: 1.5rem; min-height: 0rem;}
    .text {padding: 1.5rem;background-color: aliceblue; min-height: 0rem; }
    .heading-box h3{font-size: 2.6rem; padding-left: 0px; }
}

");

