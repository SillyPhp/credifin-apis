<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

Yii::$app->view->registerJs('var keywords = "' . $keywords . '"', \yii\web\View::POS_HEAD);
?>
    <section>
        <div class="bg-img">
            <img src="<?= Url::to('@eyAssets/images/usajobs/National Guard & Reserves(1).png'); ?>" class="img_load">
        </div>
        <div id="back-color">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="usa-heading bg-color">
                            <img src="<?= Url::to('@eyAssets/images/usajobs/National Guard & Reserves1.png'); ?>"
                                 class="img_load">
                            <h3> National Guard & Reserves </h3>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <p class="paragraph">If you’re a member of the National Guard, or are willing and able to join
                            the
                            National Guard, you may be eligible to apply for federal jobs located within a National
                            Guard
                            unit. </p>
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
                        <P>Jobs within a National Guard unit are in the <a href="https://www.usajobs.gov/Help/working-in-government/service/" target="_blank">excepted service</a> , so it’s important to read the Who
                            May
                            Apply section of the job announcement to understand if you’re eligible or what you need to do to
                            be
                            eligible. Some jobs: </P>

                        <ul class="list-2">
                            <li>Require you to already be a National Guard member in a specific state.</li>
                            <li>Require you to already be a National Guard member, but willing to transfer to a specific
                                state.
                            </li>
                            <li>Are open to anyone, but you must join the National Guard to accept the job.</li>
                            <li>Require you to wear a National Guard uniform.</li>
                        </ul>
                        <p>The
                            <stronng>Who May Apply</stronng>
                            section may say:
                        </p>

                        <ul class="list-2">
                            <li>Restricted to CURRENT members of the Army National Guard, Air National Guard, Reserves or
                                Active
                                Duty Military – Only a current member of one of these groups is eligible for this job.
                            </li>
                            <li>United States Citizens – Anyone is eligible, but you have to join the National Guard to
                                accept
                                the job.
                            </li>
                            <li>AREA 1 – Open to current, permanent technicians of the Michigan National Guard. (Does not
                                include temporary technicians).
                            </li>
                            <li>AREA 2 – Open to current military members of the Michigan National Guard – You must already
                                be a
                                member of the Michigan National Guard to be eligible. Preference is given to current
                                technicians, because the job is specific to that skill set.
                            </li>
                            <li>Current Warrant officer (CW3 & below) or Enlisted (E6 or above) members of the ND Army or
                                Air
                                National Guard – You must have a specific rank within the North Dakota National Guard to be
                                eligible for this job.
                            </li>
                            <li>US Citizens and Federal Employees with status – Anyone or federal employees with status are
                                eligible, but you have to join the National Guard.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>How do I know a job is open to National Guard & Reserves? </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p>In the job announcement look for the This job is open to section. When a job is open to National
                            Guard & Reserves, or those willing to join, you’ll see this icon: There may be other groups
                            listed
                            that can also apply. </p>
                        <p>In search you can also select the National Guard filter. Your results will display all jobs open
                            to
                            the National Guard, reserves, and those willing to join. </p>
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
                        <p>The National Guard for each state requires different forms. You will likely need to complete
                            forms to
                            demonstrate prior military or federal service if appropriate. Standard forms that you may need
                            to
                            complete are listed below. </p>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <p><a href="https://www.opm.gov/Forms/pdf_fill/SF144.pdf" target="_blank"> <i class="far fa-file-pdf"></i> SF-144 <br> Statement of prior federal service
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <a href="https://www.esd.whs.mil/Portals/54/Documents/DD/forms/dd/dd0369.pdf" target="_blank" ><p><i class="far fa-file-pdf"> </i> DD-369 <br> police record check form</a> </p>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="heading-job">
                            <h4><strong class="chg-c">Upload and submit through USAJOBS</strong></h4>
                            <P class="content1">You can upload and save documents to your USAJOBS account. Once uploaded,
                                you
                                can submit these forms with your job application as needed. <a href="https://secure.login.gov/?request_id=80e26213-726f-41b4-bfb6-08cf19c72225" target="_blank">Sign into USAJOBS</a> or
                                   <a href="https://www.usajobs.gov/Help/how-to/account/documents/upload/" target="_blank"> learn how to upload documents.</a></P>
                        </div>
                    </div>
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
 	background-color: #002f4f;
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

.para a, .content1 a{
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

.heading-job h4{
	font-weight: 700;
	color: #3a0080;
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


