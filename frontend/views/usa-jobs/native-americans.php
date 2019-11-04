<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

Yii::$app->view->registerJs('var keywords = "' . $keywords . '"', \yii\web\View::POS_HEAD);
?>
    <section>
        <div class="bg-img">
            <img src="<?= Url::to('@eyAssets/images/usajobs/native americans(1).png'); ?>" class="img_load">
        </div>
        <div id="back-color">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="usa-heading bg-color">
                            <img src="<?= Url::to('@eyAssets/images/usajobs/Native Americans1(1).png'); ?>"
                                 class="img_load">
                            <h3>Native Americans </h3>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <p class="paragraph">
                            If you're an American Indian or an Alaskan Native who is a member of one of the
                            federally recognized tribes, you may be eligible for Indian Preference. </p>
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
                        <h3>What is Indian Preference?</h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <P>With Indian Preference, you may receive preference over non-Indian applicants when applying to
                            jobs
                            with the <a href="https://www.ihs.gov/">Indian Health Service</a> and
                            <a href="https://www.bia.gov/">Indian Affairs</a> (including
                            the Bureau of Indian Affairs, the Bureau of Indian Education, and some positions within the
                            Assistant Secretary – Indian Affairs.) </P>

                        <p>Preference in filling vacancies is given to qualified Indian candidates in accordance with the
                            Indian
                            Reorganization Act of 1934 (Title 25, USC, Section 472). If you’re claiming Indian Preference,
                            you
                            must submit <a href="https://www.usajobs.gov/Help/working-in-government/unique-hiring-paths/native-americans/#required-documents">
                                Form BIA 4432 Verification of Indian Preference</a> with your application.
                            Indian Preference eligibles not currently employed in federal service may be appointed under the
                            Excepted Service Appointment Authority Schedule A, 213.3112(a)(7). Consideration will be given
                            to Non-Indian applicants if there are no qualified Indian Preference eligibles. </P>
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
                    <div class="para">
                        <p>To be eligible, you must submit a complete
                             <a href="https://www.usajobs.gov/Help/working-in-government/unique-hiring-paths/native-americans/#required-documents">
                             BIA form 4432</a> along with your application for each job announcement. </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>How do I know a job is open to Native Americans? </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p>In the job announcement look for the This job is open to section. When a job is open to Native
                            Americans you’ll see this icon: There may be other groups listed that can also apply. </p>
                        <p>In search you can also select the <strong> Native Americans</strong> filter. Your results will
                            display all jobs open to Native Americans. </p>

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
                        <a href="https://www.bia.gov/sites/bia.gov/files/assets/public/raca/online_forms/pdf/IndianPref_1076-0160_Exp3-31-21.pdf">
                            <p><i class="far fa-file-pdf"></i> Form BIA 4432
                            <span class="ser-prof">Verification of Indian Preference for Employment</span></p></a>

                    </div>
                    <h4><strong class="chg-c">Upload and submit through USAJOBS</strong></h4>
                    <P class="content1">You can upload and save documents to your USAJOBS account. Once uploaded, you can
                        submit
                        these forms with your job application as needed.
                        <a href="https://www.usajobs.gov/Applicant/ProfileDashboard/Home">Sign into USAJOBS</a> or
                        <a href="https://www.usajobs.gov/Help/how-to/account/documents/upload/">learn how to upload documents.</a></P>
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

 #back-color{
 	background-color: #f48b98;
 	padding-top: 4.5rem;
    padding-bottom: 4.5rem; 	
 }

.usa-heading h3{
    font-family: Roboto;
	font-weight: 700;
	line-height: 1.3;
	margin-bottom: .5rem;
	margin-top: 1.5rem;
}

.fa-file-alt{
   font-size:30px;
 }

.ser-prof{
	display: block;
	padding-left: 28px;
	color: blueviolet;
}
.bg-color h3 {
	font-size: 2.1rem;
	color: #fff;
	margin-top: 0;
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

.heading-box h3{
	font-family:Roboto;
	font-weight: 700;
	line-height: 1.3;
	margin-bottom: .5rem;
	margin-top: 1.5rem;
	font-size: 1.3rem;
    color: #0e1c66;
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

