<?php
$this->params['header_dark'] = false;

use yii\helpers\Url;

Yii::$app->view->registerJs('var keywords = "' . $keywords . '"', \yii\web\View::POS_HEAD);
?>
    <section>
        <div class="bg-img">
            <img src="<?= Url::to('@eyAssets/images/usajobs/Individuals with disabilities(1).png'); ?>"
                 class="img_load">
        </div>
        <div id="back-color">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="usa-heading bg-color">
                            <img src="<?= Url::to('@eyAssets/images/usajobs/Individuals with disabilities1.png'); ?>"
                                 class="img_load">
                            <h3> Individuals with disabilities </h3>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <p class="paragraph">If you're an individual with a disability, you can apply and compete for
                            any job
                            for which you are eligible and meet the qualifications, but you also may be eligible for a
                            special
                            hiring authority. </p>
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
                        <p> The Federal Government hires each person using a hiring authority (the term comes from the
                            Federal
                            regulation that describes it). Federal agencies can use the Schedule A Hiring Authority to hire
                            an
                            individual with a disability.</p>

                        <ul>
                            <li class="list1">
                                <button class="usa-btn" data-toggle="collapse" data-target="#demo">Schedule A Hiring Authority</button>
                            </li>
                            <div id="demo" class="para">
                                <p>Schedule A refers to a special hiring authority that gives Federal agencies an optional, and potentially quicker, way to hire individuals with disabilities. Applying under Schedule A offers an exception to the traditional competitive hiring process. You can apply for jobs using Schedule A, if you are a person with an intellectual disability, a severe physical disability, or a psychiatric disability.</p>
                                <p>To be eligible for Schedule A, you must provide a "proof of a disability" letter stating that you have an intellectual disability, severe physical disability or psychiatric disability. You can get this letter from your doctor, a licensed medical professional, a licensed vocational rehabilitation specialist, or any federal, state, or local agency that issues or provides disability benefits.</p>
                                <p>Applying using "Schedule A" can be a great way to get a Federal job, but it is only one of many options that may be available and you still have to compete with other eligible applicants. Federal agencies hire people using many options, so applying under "Schedule A" does not guarantee you a job.</p>
                             </div>
                            <li class="list1">
                                <button class="usa-btn" data-toggle="collapse" data-target="#demo1">Tips for applying under Schedule A</button>
                            </li>
                            <div id="demo1" class="para">
                                <p>Mention your eligibility and that you want to be considered for "Schedule A" on your resume (and in your cover letter, if you use one).</p>
                                <p>If you're eligible for Schedule A, go to your profile and select the Individuals with disabilities hiring path and make your resume searchable. If your resume is searchable, agencies who are looking for people eligible under Schedule A, may be able to find you.</p>
                            </div>

                            <li>

                                <a class="link-file" href="https://www.opm.gov/policy-data-oversight/disability-employment/getting-a-job/#url=Schedule-A-Hiring-Authority" target="_blank">
                                    Learn more about eligibility for Schedule A <i class="fas fa-external-link-alt"></i>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3> How do I know a job is open to individuals with a disability? </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p>In the job announcement look for the <strong> This job is open to </strong>section. When a job is
                            open to<strong> Individuals with a disability,</strong> you’ll see this icon: There may be other
                            groups listed that can also apply. </p>
                        <p>You can also select the<strong> Individuals with disabilities</strong> filter in search. Your
                            results
                            will display all jobs open to individuals with disabilities. </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3> Selective Placement Program Coordinator (SPPC) </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p> Selective Placement Program Coordinators (SPPC) help agencies recruit, hire, and accommodate
                            people
                            with disabilities. The SPPC can guide you through the application process and answer questions.
                            Most
                            federal agencies, but not all, have an SPPC or equivalent role, such as a Special Emphasis
                            Program
                            Manager. </p>
                        <p> If you are a person with a disability and interested in a job opportunity, contact the agency
                            SPPC
                            using the <a class="link-file" href="https://www.opm.gov/policy-data-oversight/disability-employment/selective-placement-program-coordinator-directory/" target="_blank" >
                                Selective Placement Program Coordinator directory
                                <i class="fas fa-external-link-alt"></i> </a></p>
                        <p>
                            <a class="link-file" href="https://www.opm.gov/policy-data-oversight/disability-employment/selective-placement-program-coordinator/" target="_blank">
                                Learn more about the Selective Placement Coordinator. <i class="fas fa-external-link-alt"></i> </a></p>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3> Accommodating individuals with a disability </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p> Federal agencies are required by law to provide reasonable accommodations to qualified
                            applicants
                            and employees with disabilities, unless doing so will result in undue hardship to the agency.
                            The
                            accommodations make it easier for an employee, with a disability, to successfully perform the
                            duties
                            of the position. For example, an agency may offer: </p>
                        <ul class="list-s">
                            <li>Interpreters, readers, or other personal assistance</li>
                            <li>Modified position duties</li>
                            <li>Flexible work schedules or work sites</li>
                            <li>Accessible technology or other workplace adaptive equipment</li>
                        </ul>
                        <p> You can request reasonable accommodations any time during the hiring process or at any time
                            while on
                            the job. Requests are considered on a case-by-case basis. </p>
                        <p>To request a reasonable accommodation: </p>
                        <ul class="list-s">
                            <li>Look at the job posting for instructions on requesting a reasonable accommodation.</li>
                            <li>Work directly with the person arranging the interviews.</li>
                            <li>Contact the agency SPPC.</li>
                            <li>Request a reasonable accommodation verbally or in writing; no special language is needed.
                            </li>
                            <p><a class="link-file" href="https://www.opm.gov/policy-data-oversight/disability-employment/reasonable-accommodations/" target="_blank">
                                    Learn more about reasonable accommodation requests .
                                <i class="fas fa-external-link-alt"></i> </a></p>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3> Documents you may need </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p><i class="far fa-file-alt"></i><strong> Disability letter</strong></p>
                        <p> A disability letter from you doctor or a licensed medical professional that proves your
                            eligibility
                            for Schedule A appointment </p>
                        <h4 class="heading-set">Upload and submit through USAJOBS</h4>
                        <p>You can upload and save documents to your USAJOBS account. Once uploaded, you can submit these
                            forms
                            with your job application as needed.
                            <a class="link-file" href="https://secure.login.gov/?request_id=18338861-f63d-4806-a589-0331a04ce832" target="_blank"> Sign into USAJOBS </a> or
                            <a href="https://www.usajobs.gov/Help/how-to/account/documents/upload/" target="_blank">learn how to upload documents. </a>
                        </p>
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
 .chg-c{
	color: #19197b;
}

 #back-color{
 	background-color: #00c1e5;
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
	padding:10px;
}
.feature-box{
    border-bottom: 1px solid lightgray;
    margin-bottom: 10px;
}
.para a, .list-option li a, .content1 a{
    color: #6d2bcc; 
}
.list1{
  background-color: lightgray;
  margin:10px;

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
.usa-btn {
	padding: 14px 4px 16px 7px;
	border: none;
	border-radius: 5px;
	font-size: 16px;
	font-family: roobot;
	font-weight: 700;
	margin: 10px;
    background-color:
    transparent;
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
.list-s{
	color: black;
	list-style: disc;
	font-size: 17px;
	padding-left: 23px;
}
.fa-file-pdf{
	font-size: 40px;
	color: #cd2026;
}
.content1{
	font-size: 17px;
	font-family: roboto;
	margin-bottom: 20px;
	margin-top: 20px;
	color: black;
	padding: 10px;
}
.link-file{
  padding-left:10px;

}
.fa-times{
	color: red;
}
.fa-check{
	color:green;
}
.fa-file-alt{
   font-size:30px;
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

//$this->registerCss("
//body{
// 	margin:0;
// }
//
//.row{
//	margin: 0;
//}
// .bg-img  img{
//	display: block;
//	width: 100%;
// }
//
// #back-color{
// 	background-color: ;
// 	padding-top: 4.5rem;
//    padding-bottom: 4.5rem;
// }
//

//
// .bg-color img {
//	position: relative;
//	margin-top: -12rem;
//	max-width: 45%;
//}
//

//
//.heading-set{
//   font-weight:bold;
//}
//

//
//

//
//h3 {
//	font-family: Roboto;
//	font-weight: 700;
//	line-height: 1.3;
//	margin-bottom: .5rem;
//	margin-top: 1.5rem;
//	font-size: 2.1rem;
//	color: #fff;
//	margin-top: 0;
//}
//
//.paragraph{
//	margin-bottom: .5rem;
//	margin-top: 1.5rem;
//	font-size: 1.4rem;
//	font-family: roboto;
//	font-weight: 400;
//	line-height: 1.7;
//	color:white;
//}
//
//
//

//
//.para {
//	line-height: 2.1;
//	margin-bottom: 4em;
//	margin-top: 1em;
//	font-size: 17px;
//	font-family: roboto;
//	color: #4a4a4a;
//}
//
//.feature-box{
//	 border-bottom: 1px solid lightgray;
//	  margin-bottom: 10px;
//}
//
//a{
// color: #6d2bcc;
//}
//
//
//
//.list-option{
//	padding-top: 3rem;
//	padding-bottom: 3rem;
//	margin: 1rem auto;
//}
//
//.list-option li{
//	display: inline-block;
//}
//
//.heading-box h3{
//	font-family:Roboto;
//	font-weight: 700;
//	line-height: 1.3;
//	margin-bottom: .5rem;
//	margin-top: 1.5rem;
//	font-size: 1.3rem;
//    color: #0e1c66;
//}
//
//
//.paragraph p{
//	font-size: 17px;
//	font-family: roboto;
//	margin-bottom: 20px;
//    margin-top: 20px;
//    color: black;
//    padding: 10px;
//}
//
//#main-mg {
//	margin-bottom: 40PX;
//}
//
//h2 {
//	font-family: Roboto;
//	font-weight: 700;
//	line-height: 1.3;
//	margin-bottom: 2.5rem;
//	margin-top: 1.5rem;
//	font-size: 1.4rem;
//	color: #112e51;
//}
//

//#bg-color{
//	background-color: #f9dede;
//}
//
//@media only screen and (max-width: 360px){
//.bg-color{text-align: center;}
//     .heading-box h3 {padding-left: 0; font-size: 2.6rem; }
//     .text {padding: 1.5rem;background-color: aliceblue; min-height: 0rem; }
//     .text h5{font-size: 2.1rem;}
//     .paragraph{ font-size: 2.4rem;}
//     h3{ font-size: 2.5rem;}
//     .para{ font-size: 18px;}
//}
//@media (min-width:768px) and (max-width:1024px){
//    .text {padding: 1.5rem;background-color: aliceblue; min-height: 0rem; }
//     .heading-box h3{font-size: 2.6rem; padding-left: 0px; }
//}
//
//");

