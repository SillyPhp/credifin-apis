
<?php
$this->params['header_dark'] = false;
use yii\helpers\Url;
Yii::$app->view->registerJs('var keywords = "'. $keywords.'"',  \yii\web\View::POS_HEAD);
?>
    <section>
        <div class="bg-img">
            <img src="<?= Url::to('@eyAssets/images/usajobs/Military spouses(1).png'); ?>" class="img_load">
        </div>
        <div id="back-color">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="usa-heading bg-color">
                            <img src="<?= Url::to('@eyAssets/images/usajobs/Military spouses1.png'); ?>" class="img_load">
                            <h3> Military Spouses  </h3>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                        <p class="paragraph">If you're a military spouse, you may be eligible to apply using a non-competitive process designed to help you get a job in the federal government.  </p>
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
                            <li> Military Spouses</li>
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
                    <div class="para">
                        <p> Federal agencies can use the military spouse non-competitive hiring process to fill positions
                            on either a temporary or permanent basis.</p>
                        <p>You’re eligible if you are: </P>
                        <ul class="list-2">
                            <li>A spouse of an active duty member of the armed forces.</li>
                            <li>A spouse of a service member who is 100% disabled due to a service-connected injury.</li>
                            <li>A spouse of a service member killed while on active duty.</li>
                        </ul>
                        <p>You are no longer eligible if you remarry.</p>
                        <p>You must meet certain criteria for each of these eligibility categories
                            .<a href="#"> Learn more about the specific criteria for military spouses. </a>
                        </p>
                        <p>Your eligibility does not entitle you to a job within the Federal Government. You must still apply and meet qualification standards and additional requirements, such as a background investigation.</>
                        <p>You can also select the Military spouses filter in search. Your results will display all jobs open to military spouses. </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>How do I know a job is open to military spouses? </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p>In the job announcement look for the This job is open to section. When a job is open to Military Spouses you’ll see this icon: There may be other groups listed that can also apply. </p>
                        <p>You can also select the Military spouses filter in search. Your results will display all jobs open to military spouses. </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="usa-heading heading-box">
                        <h3>Documents you may need  </h3>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="para">
                        <p> <i class="far fa-file-alt"></i> Documentation verifying marriage  </p>
                        <p> <i class="far fa-file-alt"></i> A copy of your spouse's active military orders   </p>
                        <a href="#"><p><i class="far fa-file-pdf"></i> DD-214</p>  </a>
                        <p>Military spouses of 100% disabled separated or retired veterans and widows or widowers, who are not remarried, of military service members who were killed on active duty. </p>
                    </div>
                    <h4><strong class="chg-c">Upload and submit through USAJOBS</strong></h4>
                    <P class="content1">You can upload and save documents to your USAJOBS account. Once uploaded, you can submit these forms with your job application as needed. <a href="#">Sign into USAJOBS or learn how to upload documents.</a> </P>
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
 	background-color: #008645;
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
.para a, .list-option li a{
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
.fa-file-alt {
    font-size: 30px;
}
.fa-file-pdf {
    font-size: 40px;
    color: #cd2026;
}
.paragraph p{
	font-size: 17px;
	font-family: roboto;
	margin-bottom: 20px;
    margin-top: 20px;
    color: black;
    padding:0 10px;
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
.chg-c {
    color: #19197b;
}
.content1 {
    font-size: 17px;
    font-family: roboto;
    margin-bottom: 20px;
    margin-top: 20px;
    color: #000;
    padding: 10px;
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

