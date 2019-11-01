
<?php
$this->params['header_dark'] = false;
use yii\helpers\Url;
Yii::$app->view->registerJs('var keywords = "'. $keywords.'"',  \yii\web\View::POS_HEAD);
?>
<div class="main" xmlns="http://www.w3.org/1999/html">
    <div class="bg-img">
        <img src="<?= Url::to('@eyAssets/images/usajobs/Students & recent graduates(1).png'); ?>" class="img_load">
    </div>
    <div class="row" id="back-color">
        <div class="col-md-12">
            <div class="container">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="bg-color">
                        <img src="<?= Url::to('@eyAssets/images/usajobs/Special authorities1.png'); ?>" class="img_load">
                        <h3> Special authorities   </h3>
                    </div>

                </div>
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <p class="paragraph">The Federal Government offers other special hiring paths (also known as a hiring authority) to help hire individuals that represent our diverse society.   </p>
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
            <li> Special authorities</li>
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
                <P> You may be eligible under a special authority if you are a:  </P>
                 <ul class="list-2">
                     <li>Former employee of the Canal Zone Merit System or Panama Canal Employment System.</li>
                     <li>Former employee who served in the Office of the President or Vice-President or on the White House Staff.</li>
                     <li>Former incumbent of a position brought into the competitive service.</li>
                     <li>Disabled veteran who has completed a training course under Chapter 31 of title 38, United States Code.</li>
                     <li>Former ACTION volunteer.</li>
                     <li>Current or former Foreign Service officer or employee.</li>
                     <li>Former employee of the Panama Canal Commission located in the United States.</li>
                     <p>There are specific eligibility requirements for each of these special hiring authorities.  <li><a href="#">Please read OPM's code of federal hiring regulations for more details. </a> </li></p>
                 </ul>
            </div>
        </div>

    </div>

    <div class="row"  >
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="heading-box">
                <h3>How do I know a job is open to a special hiring authority? </h3>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="paragraph">
                <p>In the job announcement look for the This job is open to section. When a job is open to a special hiring authority you'll see the Special authorities icon: You also need to look at the Clarification from the agency section for further details about eligibility. There may be other groups listed that can also apply.  </p>
                 <p>In search, select the Special authorities filter. Your results will display all jobs open to special authorities. </p>
            </div>
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="heading-box">
                <h3>Documents you may need  </h3>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="paragraph">

                <p>Depending on the job, you may need to provide several different documents with your application. The Required documents section in the job announcement will list any required documents.   </p>
                <p>You can also select the Students or recent graduates filter. Your results will display all jobs open to students and recent graduates. <a href="#"> Learn about the different document types. </a> </p>
            </div><p></a> </P>
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
 	background-color: #cf1516;
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

.list-2 {
	list-style: disc;
	padding-left: 23px;
	color: #4a4a65;
	font-size: 18px;
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
	font-size: 20px;
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


