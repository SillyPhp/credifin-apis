
<?php
$this->params['header_dark'] = false;
use yii\helpers\Url;
Yii::$app->view->registerJs('var keywords = "'. $keywords.'"',  \yii\web\View::POS_HEAD);
?>
    <div class="main">
        <div class="bg-img">
            <img src="<?= Url::to('@eyAssets/images/usajobs/Military spouses(1).png'); ?>" class="img_load">
        </div>
        <div class="row" id="back-color">
            <div class="col-md-12">
                <div class="container">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="bg-color">
                            <img src="<?= Url::to('@eyAssets/images/usajobs/Military spouses1.png'); ?>" class="img_load">
                            <h3> Military spouses  </h3>
                        </div>

                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <p class="paragraph">If you're a military spouse, you may be eligible to apply using a non-competitive process designed to help you get a job in the federal government.  </p>
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
                <li> Military Spouses</li>
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
                    <P> Federal agencies can use the military spouse non-competitive hiring process to fill positions on either a temporary or permanent basis.</P>

                        <p>You’re eligible if you are: </P>
                    <ul class="list-2">
                        <li>A spouse of an active duty member of the armed forces.</li>
                        <li>A spouse of a service member who is 100% disabled due to a service-connected injury.</li>
                        <li>A spouse of a service member killed while on active duty.</li>
                    </ul>
                    <P>You are no longer eligible if you remarry.</P>
                    <p>You must meet certain criteria for each of these eligibility categories.<a href="#"> Learn more about the specific criteria for military spouses. </a> </p>
                    <P>Your eligibility does not entitle you to a job within the Federal Government. You must still apply and meet qualification standards and additional requirements, such as a background investigation.</P>
                     <p>You can also select the Military spouses filter in search. Your results will display all jobs open to military spouses. </p>
                </div>
            </div>

        </div>

        <div class="row"  >
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="heading-box">
                    <h3>How do I know a job is open to military spouses? </h3>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="paragraph">
                    <p>In the job announcement look for the This job is open to section. When a job is open to Military Spouses you’ll see this icon: There may be other groups listed that can also apply. </p>
                    <p>You can also select the Military spouses filter in search. Your results will display all jobs open to military spouses. </p>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="heading-box">
                    <h3>Documents you may need  </h3>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="paragraph">
                    <p> <i class="far fa-file-alt"></i> Documentation verifying marriage  </p>
                    <p> <i class="far fa-file-alt"></i> A copy of your spouse's active military orders   </p>
                    <a href="#"><p><i class="far fa-file-pdf"></i> DD-214</p>  </a>
                    <p>Military spouses of 100% disabled separated or retired veterans and widows or widowers, who are not remarried, of military service members who were killed on active duty. </p>
                </div>
                <h4><strong class="chg-c">Upload and submit through USAJOBS</strong></h4>
                <P class="content1">You can upload and save documents to your USAJOBS account. Once uploaded, you can submit these forms with your job application as needed. <a href="#">Sign into USAJOBS or learn how to upload documents.</a> </P>
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
 	background-color: #008645;
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

