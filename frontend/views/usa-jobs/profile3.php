
<?php
$this->params['header_dark'] = false;
use yii\helpers\Url;
Yii::$app->view->registerJs('var keywords = "'. $keywords.'"',  \yii\web\View::POS_HEAD);
?>
<div class="main">
    <div class="bg-img">
        <img src="<?= Url::to('@eyAssets/images/usajobs/Individuals with disabilities(1).png'); ?>" class="img_load">
    </div>
    <div class="row" id="back-color">
        <div class="col-md-12">
            <div class="container">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="bg-color">
                        <img src="<?= Url::to('@eyAssets/images/usajobs/Individuals with disabilities1.png'); ?>" class="img_load">
                        <h3> Individuals with disabilities   </h3>
                    </div>

                </div>
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <p class="paragraph">If you're an individual with a disability, you can apply and compete for any job for which you are eligible and meet the qualifications, but you also may be eligible for a special hiring authority. </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="feature-box">
    <div class="container">
        <ul class="list-option">
            <li><a href="#">Help</a> /</li>
            <li><a href="#">Working in Government</a> /</li>
            <li><a href="#">Unique Hiring Path</a> /</li>
            <li> Individuals with disabilities</li>
        </ul>
    </div>
</div>
<div class="container">
    <div class="row" id="main-mg">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="heading-box">
                <h3>Eligibility </h3>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="para">
                <P> The Federal Government hires each person using a hiring authority (the term comes from the Federal regulation that describes it). Federal agencies can use the Schedule A Hiring Authority to hire an individual with a disability.</P>

               <ul>
                   <li class="list1"><button class="usa-btn">Schedule A Hiring Authority</button></li>
                   <li class="list1"><button class="usa-btn">Tips for applying under Schedule A</button></li>
                   <li> <a class="link-file" href="#">Learn more about eligibility for Schedule A <i class="fas fa-external-link-alt"></i> </a>  </li>
               </ul>

            </div>
        </div>

    </div>

    <div class="row"  id="main-mg" >
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="heading-box">
                <h3> How do I know a job is open to individuals with a disability?  </h3>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="paragraph">
                <p>In the job announcement look for the <strong> This job is open to </strong>section. When a job is open to<strong> Individuals with a disability,</strong> you’ll see this icon: There may be other groups listed that can also apply. </p>
                <p>You can also select the<strong> Individuals with disabilities</strong> filter in search. Your results will display all jobs open to individuals with disabilities.  </p>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="heading-box">
                <h3> Selective Placement Program Coordinator (SPPC)  </h3>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="paragraph">
                <p> Selective Placement Program Coordinators (SPPC) help agencies recruit, hire, and accommodate people with disabilities. The SPPC can guide you through the application process and answer questions. Most federal agencies, but not all, have an SPPC or equivalent role, such as a Special Emphasis Program Manager.  </p>
                <p> If you are a person with a disability and interested in a job opportunity, contact the agency SPPC using the <a class="link-file" href="#"> Selective Placement Program Coordinator directory <i class="fas fa-external-link-alt"></i> </a>  </p>
                <p> <a class="link-file" href="#">Learn more about the Selective Placement Coordinator.  <i class="fas fa-external-link-alt"></i> </a>  </p>

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="heading-box">
                <h3> Accommodating individuals with a disability  </h3>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="paragraph">
                <p> Federal agencies are required by law to provide reasonable accommodations to qualified applicants and employees with disabilities, unless doing so will result in undue hardship to the agency. The accommodations make it easier for an employee, with a disability, to successfully perform the duties of the position. For example, an agency may offer: </p>
                   <ul class="list-s">
                       <li>Interpreters, readers, or other personal assistance</li>
                       <li>Modified position duties</li>
                       <li>Flexible work schedules or work sites</li>
                       <li>Accessible technology or other workplace adaptive equipment</li>
                   </ul>
                <p> You can request reasonable accommodations any time during the hiring process or at any time while on the job. Requests are considered on a case-by-case basis.  </p>
                <p>To request a reasonable accommodation: </p>
                <ul class="list-s">
                    <li>Look at the job posting for instructions on requesting a reasonable accommodation.</li>
                    <li>Work directly with the person arranging the interviews.</li>
                    <li>Contact the agency SPPC.</li>
                    <li>Request a reasonable accommodation verbally or in writing; no special language is needed.</li>
                    <p><a class="link-file" href="#">Learn more about reasonable accommodation requests .   <i class="fas fa-external-link-alt"></i> </a> </p>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="heading-box">
                <h3> Documents you may need   </h3>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="paragraph">
                <p> <i class="far fa-file-alt"></i><strong> Disability letter</strong> </p>
                <p> A disability letter from you doctor or a licensed medical professional that proves your eligibility for Schedule A appointment   </p>
                 <h4 class="heading-set">Upload and submit through USAJOBS</h4>
                <p>You can upload and save documents to your USAJOBS account. Once uploaded, you can submit these forms with your job application as needed. <a class="link-file" href="#"> Sign into USAJOBS </a> or <a href="#">learn how to upload documents. </a></p>

            </div>
        </div>

    </div>
<?php
$this->registerCss("
body{
 	margin:0;
 }	

.row{
	margin: 0;
}
 .bg-img  img{
	display: block;
	width: 100%;
 }

 #back-color{
 	background-color: #00c1e5;
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

.heading-set{
   font-weight:bold;
}

.fa-file-pdf{
	font-size: 40px;
	color: #cd2026;
}

.chg-c{
	color: #19197b;
}

.link-file{
  padding-left:10px;
  
}

h3 {
	font-family: Roboto;
	font-weight: 700;
	line-height: 1.3;
	margin-bottom: .5rem;
	margin-top: 1.5rem;
	font-size: 2.1rem;
	color: #fff;
	margin-top: 0;
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

.list1{
  background-color: lightgray;
  margin:10px;
  
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

.para {
	line-height: 2.1;
	margin-bottom: 4em;
	margin-top: 1em;
	font-size: 17px;
	font-family: roboto;
	color: #4a4a4a;
}

.feature-box{
	 border-bottom: 1px solid lightgray;
	  margin-bottom: 10px;
}

a{
 color: #6d2bcc; 
}

.list-s{
	color: black;
	list-style: disc;
	font-size: 17px;
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

h2 {
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

