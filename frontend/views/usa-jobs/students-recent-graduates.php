<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

Yii::$app->view->registerJs('var keywords = "' . $keywords . '"', \yii\web\View::POS_HEAD);
?>
    <section>
        <div class="bg-img">
            <img src="<?= Url::to('@eyAssets/images/usajobs/Students & recent graduates(1).png'); ?>" class="img_load">
        </div>
        <div id="back-color">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="usa-heading bg-color">
                            <img src="<?= Url::to('@eyAssets/images/usajobs/Students & recent graduates1.png'); ?>"
                                 class="img_load">
                            <h3> Students & Recent Graduates </h3>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <p class="paragraph">If you’re a current student or recent graduate, you may be eligible for
                            federal
                            internships and job opportunities through the Pathways and other student programs. </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="feature-box">
                        <ul class="list-option">
                            <li><a href="#">Help</a> /</li>
                            <li><a href="#">Working in Government</a> /</li>
                            <li><a href="#">Unique Hiring Path</a> /</li>
                            <li> Students & Recent Graduates</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>Eligibility </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <h3 class="st-btn"> Internship Program</h3>
                    <div class="para">
                        <P> The Internship Program is for current students. If you’re a current student in high school,
                            college,
                            trade school or other qualifying educational institution, you may be eligible. This program
                            offers
                            paid opportunities to work in federal agencies and explore federal careers while completing your
                            education. </P>

                        <p><a href="#">Learn more about the Internship Program <i class="fas fa-external-link-alt"></i></a>
                        </P>

                        <h3 class="st-btn"> Recent Graduates Program</h3>
                        <p>The recent graduate program is for those who have graduated, within the past two years, from a
                            qualifying educational institution or certificate program. The recent graduate program offers
                            career
                            development with training and mentorship. </p>
                        <p>You must apply within two years of getting your degree or certificate (veterans have up to six
                            years
                            to apply due to their military service obligation). </p>
                        <p><a href="#">Learn more about the recent graduate program <i class="fas fa-external-link-alt"></i></a>
                        </P>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>Other student programs and opportunities </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p>There are several other opportunities available to students, including: </p>
                        <ul class="list-2">
                            <li><a href="#">Department of State Student Internship program</a></li>
                            <li><a href="#">Virtual Student Foreign Service (VSFS)</a></li>
                            <li>Overseas Student Summer Hire program</li>
                            <li>Summer jobs (for example, a lifeguard)</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>How do I know a job is open to Students & recent graduates? </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">

                        <p>In the job announcement look for the This job is open to section. When a job is open to Students
                            you’ll see the Students icon: . When a job is open to Recent graduates, you'll see the Recent
                            graduates icon: . There may be other groups listed that can also apply. </p>
                        <p>You can also select the Students or recent graduates filter. Your results will display all jobs
                            open
                            to students and recent graduates. </p>
                    </div>
                    <h4><strong class="chg-c">Upload and submit through USAJOBS</strong></h4>
                    <P class="content1">You can upload and save documents to your USAJOBS account. Once uploaded, you can
                        submit
                        these forms with your job application as needed. <a href="#">Sign into USAJOBS or learn how to
                            upload
                            documents.</a></P>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss("
 .bg-img  img{
	display: block;
	width: 100%;
 }

.st-btn{
	padding: 10px 158px 10px 5px;
	font-size: 15px;
	font-family: roboto;
	font-weight: 501;
	word-spacing: 0.3em;
	border: none;
	background-color: #ffb63a;
	color: white;
	margin-top: 20px;
}
.usa-heading h3{
    font-family: Roboto;
	font-weight: 700;
	line-height: 1.3;
	margin-bottom: .5rem;
	margin-top: 1.5rem;
}
.bg-color h3 {x
	font-size: 2.1rem;
	color: #fff;
	margin-top: 0;
}
.heading-box h3{
	font-size: 1.6rem;
    color: #0e1c66;
}


 #back-color{
 	background-color: #ffb63a;
 	padding-top: 4.5rem;
    padding-bottom: 4.5rem; 	
 }

.fa-file-alt{
   font-size:30px;
 }

 .bg-color img {
	position: relative;
	margin-top: -12rem;
	max-width: 45%;
}

.content1{
	font-size: 17px;
	font-family: roboto;
	margin-bottom: 20px;
	margin-top: 20px;
	color: black;
	padding: 10px;
}

.fa-file-pdf{
	font-size: 40px;
	color: #cd2026;
}

.chg-c{
	color: #19197b;
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

.list-2 a, .para a, .content1 a, .list-option a{
 color: #6d2bcc; 
}

.list-2{
    list-style: disc;
    padding-left: 23px; 
    color: black;
    font-size: 20px;
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

#main-mg {
	margin-bottom: 40PX;
}

.fa-times{
	color: red;
}
.fa-check{
	color:green;
}
#bg-color{
	background-color: #f9dede;
}

@media only screen and (max-width: 360px){
.bg-color{text-align: center;}
     .heading-box h3 {padding-left: 0; font-size: 2.6rem; }
     .text {padding: 1.5rem;background-color: aliceblue; min-height: 0rem; }
     .text h5{font-size: 2.1rem;}
     .paragraph{ font-size: 2.4rem;}
     h3{ font-size: 2.5rem;}
     .para{ font-size: 18px;}
}
@media (min-width:768px) and (max-width:1024px){
    .text {padding: 1.5rem;background-color: aliceblue; min-height: 0rem; }
     .heading-box h3{font-size: 2.6rem; padding-left: 0px; }
}

");

