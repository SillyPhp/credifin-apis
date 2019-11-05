<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

Yii::$app->view->registerJs('var keywords = "' . $keywords . '"', \yii\web\View::POS_HEAD);
?>
    <section>
        <div class="bg-img">
            <img src="<?= Url::to('@eyAssets/images/usajobs/veteran.png'); ?>" class="img_load">
        </div>
        <div id="back-color">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="usa-heading bg-color">
                            <img src="<?= Url::to('@eyAssets/images/usajobs/Veterans1.png'); ?>" class="img_load">
                            <h3>Veterans</h3>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <p class="paragraph">If you’re a Veteran who served on active duty in the U.S. Armed Forces and
                            were separated under honorable conditions, you may be eligible for veterans’ preference, as
                            well as other veteran specific hiring options. </p>
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
                        <h3>Veterans' preference</h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <P>With veterans’ preference, you may receive preference over non-veteran applicants in the hiring
                            process. Veterans' preference can be used when applying to permanent and temporary positions in
                            both the competitive and excepted service (of the executive branch). </P>
                        <p>There are three types of veterans' preferences: </p>

                        <p><a href="https://www.fedshirevets.gov/job-seekers/veterans-preference/#10point" target="_blank">
                                <button class="buton">Disabled (10 point preference eligible)</button>
                            </a></p>
                        <p><a href="https://www.fedshirevets.gov/job-seekers/veterans-preference/#5point" target="_blank">
                                <button class="buton">Non-disabled (5 point preference eligible)</button>
                            </a></p>
                        <p><a href="https://www.fedshirevets.gov/job-seekers/veterans-preference/#0point" target="_blank">
                                <button class="buton"> Sole survivorship (0 point preference eligible)</button>
                            </a></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>How do I know a job is open to Veterans? </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p>In the job announcement look for the This job is open to section. When a job is open to Veterans
                            you’ll see this icon: There may be other groups listed that can also apply. </p>
                        <p>You can also select the<strong> Veterans </strong> filter in search. Your results will display
                            all jobs open to family of overseas employees. </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>Documents you may need </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <h4>Claiming veterans' preference</h4>
                        <p>When claiming veterans’ preference, you must provide a copy of your DD-214, Certificate of
                            Release or Discharge from Active Duty, or other acceptable documentation. Applicants claiming
                            10-point preference will need to submit Form SF-15, or other acceptable documentation. </p>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <p><a href="http://www.archives.gov/veterans/military-service-records/" target="_blank">
                                    <i class="far fa-file-pdf"></i> DD-214 <br>Certificate of Release or Discharge
                                    from Active Duty
                                </a></p>
                        </div>
                        <p>The DD-214 is issued to military members upon separation from active service. It contains
                            information about the veteran's dates of military service and separation. Most veterans and
                            their next-of-kin can obtain free copies of their DD Form 214 Report of Separation and other
                            military and medical records through the
                            <a href="https://www.archives.gov/veterans/military-service-records" target="_blank">
                                National Archives Veterans’ Records Service.
                            </a></p>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <p><a href="https://www.opm.gov/forms/pdf_fill/sf15.pdf" target="_blank">
                                    <i class="far fa-file-pdf"></i> SF-15<br> Application for 10-point Veterans' Preference
                                </a></p>
                        </div>
                        <p>The<strong> SF-15 </strong>is used by Federal agencies and OPM examining offices to adjudicate
                            individuals' claims for veterans' preference. </p>
                        <p>Note that a letter from the VA that contains the following may be sufficient instead of a
                            SF-15: </p>
                        <ul class="list-2">
                            <li>Dates of service</li>
                            <li>Discharge status</li>
                            <li>Disability rating</li>
                        </ul>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-job">
                            <h4><strong class="chg-c">Upload and submit through USAJOBS</strong></h4>
                            <P class="content1">You can upload and save documents to your USAJOBS account. Once uploaded,
                                you can submit these forms with your job application as needed.
                                <a href="https://secure.login.gov/?request_id=18338861-f63d-4806-a589-0331a04ce832" target="_blank">Sign into
                                    USAJOBS</a> or
                                <a href="https://www.usajobs.gov/Help/how-to/account/documents/upload/" target="_blank">learn how to upload documents.</a></P>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>Veteran's Recruitment Appointment and other hiring options </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">

                    <div class="para">
                        <p>If you’re a veteran, you may also be eligible for one of these special hiring authorities: </p>

                        <p><a href="https://www.fedshirevets.gov/job-seekers/special-hiring-authorities/#vra" target="_blank">
                                <button class="buton">Veterans Recruitment Appointment (VRA)</button>
                            </a></p>
                        <p><a href="https://www.fedshirevets.gov/job-seekers/special-hiring-authorities/#30" target="_blank">
                                <button class="buton">30% or More Disabled Veteran</button>
                            </a></p>
                        <p><a href="https://www.fedshirevets.gov/job-seekers/special-hiring-authorities/#veoa" target="_blank">
                                <button class="buton">Veterans Employment Opportunity Act of 1998 (VEOA)</button>
                            </a></p>
                        <p><a href="https://www.fedshirevets.gov/job-seekers/special-hiring-authorities/#training" target="_blank">
                                <button class="buton">Disabled Veterans Enrolled in a VA Training Program</button>
                            </a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss("
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

 #back-color{
 	background-color: #57b952;
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

.heading-2{
	font-size: 16px;
	font-weight: bold;
	color: #401277;
}

.buton{
	background-color: transparent;
	border: 3px solid #154899;
	padding: 10px;
	border-radius: 5px;
	font-size: 15px;
	font-weight: 700;
	color: #19588e;
	width: 50%;
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

.para a, .content1 a, .list-option a{
 color: #6d2bcc; 
}

.list-2 {
	list-style: disc;
	padding-left: 23px;
	color: #000;
	font-size: 17px;
}

.list-option{
	padding-top: 3rem;
	padding-bottom: 3rem;
	margin: 1rem auto;
}

.list-option li{
	display: inline-block;
}

.para h4, .heading-job h4{
	font-weight: 700;
	color: #401260;
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


