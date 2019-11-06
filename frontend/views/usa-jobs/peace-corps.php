<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

Yii::$app->view->registerJs('var keywords = "' . $keywords . '"', \yii\web\View::POS_HEAD);
?>
<section>
    <div class="bg-img">
        <img src="<?= Url::to('@eyAssets/images/usajobs/peace-corps-americorps-VISTA.png'); ?>" class="img_load">
    </div>
    <div id="back-color">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="usa-heading bg-color">
                        <img src="<?= Url::to('@eyAssets/images/usajobs/Peace Corps & AmeriCorps VISTA1.png'); ?>"
                             class="img_load">
                        <h3> Peace Corps & AmeriCorps VISTA </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <p class="paragraph">If you served with the Peace Corps or AmeriCorps VISTA, you may qualify for
                        non-competitive eligibility. This means that a federal agency can hire you outside of the formal
                        competitive job announcement process. </p>
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
                    <P>You’re eligible if you have at least two years of service with the Peace Corps or one year of service
                        with AmeriCorps VISTA. </P>
                    <p>Your non-competitive eligibility lasts for one year after completing your Peace Corps or AmeriCorps
                        service. Federal agencies may extend the period for up to three years if, after your completed
                        service, you are: </p>
                    <ul class="list-2">
                        <li>In the military service.</li>
                        <li>Studying at a recognized institution of higher learning.</li>
                        <li>Involved in another activity, which in the agency’s view, warrants an extension.</li>
                    </ul>
                    <p>Your non-competitive eligibility does not entitle you to a job within the federal government. You
                        must still apply and meet qualification standards and additional requirements, such as a background
                        investigation. </p>
                    <p>When applying for a job, include your Peace Corps or AmeriCorps VISTA certification of service
                        documents with your application and make sure to mention your non-competitive eligibility status on
                        your resume. </p>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="usa-heading heading-box">
                    <h3>How do I know a job is open to Peace Corps & AmeriCorps VISTA Alumni? </h3>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="para">
                    <p>In the job announcement look for the <strong>This job is open to</strong> section. When a job is open
                        to<strong> Peace Corps & AmeriCorps VISTA</strong> Alumni you’ll see this icon: There may be other
                        groups listed that can also apply. </p>
                    <p>You can also select the Peace Corps & AmeriCorps Vista filter in search. Your results will display
                        all jobs open to <strong>Peace Corps & AmeriCorps VISTA</strong> alumni. </p>
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
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <p>
                            <a href="https://www.opm.gov/forms/pdfimage/sf50.pdf" target="_blank">
                                <i class="far fa-file-pdf"></i> SF-50 <br> Notification of Personnel Action
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <p>
                            <a href="https://files.peacecorps.gov/multimedia/pdf/Certification_Request_Form_2015.pdf" target="_blank">
                                <i class="far fa-file-pdf"></i> Certification of volunteer service <br> You may use the
                                Peace Corps certification request form to request your certification.
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="heading-job">
                        <h4><strong class="chg-c">Upload and submit through USAJOBS</strong></h4>
                        <P class="content1">You can upload and save documents to your USAJOBS account. Once uploaded, you
                            can submit these forms with your job application as needed. <a href="https://secure.login.gov/?request_id=80e26213-726f-41b4-bfb6-08cf19c72225" target="_blank">Sign into USAJOBS</a> or
                              <a href="https://www.usajobs.gov/Help/how-to/account/documents/upload/"  target="_blank">  learn how to upload documents.</a></P>
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
 	background-color: #0073b9;
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

.heading-job h4{
	font-weight: 700;
	color: #3a0080;
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


