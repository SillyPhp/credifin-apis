<?php
$this->title = Yii::t('account', 'Job Detail');
$this->params['header_dark'] = true;

use yii\helpers\Url;
$var = $_GET['data'];

$session = Yii::$app->session;
$object = $session->get($var);



$cover_image = Yii::$app->params->upload_directories->organization->cover_image . Yii::$app->user->identity->organization->cover_image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->cover_image;
$cover_image_base_path = Yii::$app->params->upload_directories->organization->cover_image_path . Yii::$app->user->identity->organization->cover_image_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->cover_image;

if (!file_exists($cover_image_base_path)) {
    $cover_image = "http://www.placehold.it/1500x500/EFEFEF/AAAAAA&amp;text=No+Cover+Image";
}

$logo_image = Yii::$app->params->upload_directories->organization->logo . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;
$logo_base_path = Yii::$app->params->upload_directories->organization->logo_path . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;

if (!file_exists($logo_base_path)) {
    $logo_image = "http://www.placehold.it/150x150/EFEFEF/AAAAAA&amp;text=No+Logo";
}
?>

<div class="row">

    <div class="col-md-12">
        <img src="<?= Url::to($cover_image); ?>" id="cover_image" >
        <div id="profile_photo">
            <img src="<?= Url::to($logo_image); ?>"  class="logo">
        </div>

    </div>

</div>
<div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-10">
        <div class="row" id="row_style">
            <div class="col-md-4">
                <h4 id="comp_name">DSB Edu Tech Ludhiana</h4>	
            </div>
            <div class="col-md-4">
                <a href="#" class="button">Apply</a>
            </div>
            <div class="col-md-4">
                <a href="#"></a>
                <i class="fa fa-3x fa-facebook-square share_fb"></i>

                <a href="#"></a>
                <i class="fa fa-3x fa-linkedin-square share_ld"></i>

                <a href="#"></a>
                <i class="fa fa-3x fa-twitter-square share_tw"></i>
                <a href="#"></a>
                <i class="fa fa-3x fa-google-plus-square share_gp"></i>
                <a href="#"></a>
                <i class="fa fa-3x fa-envelope-square share_em"></i>
            </div>
        </div>

    </div>
    <div class="col-md-1">

    </div>
</div>
<div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-7">
                <div id="job_description">
                    <h3 class="title">Job Description</h3>
                    <p class="text_desc"><ul>
                        
                        <li>Aspiring & ambitious about providing the highest standards of delivery and embedding them in the team</li>
                        <li>Strong facilitation and sound leadership skills</li>
                        <li>Customer orientation and Client handling</li>
                        <li>Excellent English written & verbal communication skills</li>
                        <li>Ability to develop cohesive working relationships with functional units</li>

                        <li>Strong conceptual skills (business models, frameworks, standards) and analytical skills to craft, execute, and oversee initiatives</li>
                        <li>Strong knowledge in Content digitizing and Book publishin</li>
                    </ul></p>

                    <h3 class="title">Skills Required</h3>
                    <div  class="skills">
                        <span class="chip">Sales</span>
                        <span class="chip">Marketing</span>
                        <span class="chip">Direct Sales</span>
                        <span class="chip">Business Development</span>
                        <span class="chip">B2B Sales</span>
                        <span class="chip">Sales</span>
                        <span class="chip">Marketing</span>
                        <span class="chip">Lead Genration</span>
                        <span class="chip">Cold calling</span>

                    </div>
                    <h3 class="title">Job Locations</h3>
                    <span class="chip">Ludhiana</span>
                    <span class="chip">Jalandhar</span>
                    <span class="chip">Delhi</span>
                    <span class="chip">Mumbai</span>

                    <h3 class="title">Interview Details:</h3>
                    <div class="row">
                       	<div class="col-md-4">
                            <span class="title2">Start From: <strong>20/06/2018</strong></span> 
                       	</div>
                       	<div class="col-md-4">
                            <span class="title2">Upto: <strong>28/06/2018</strong></span>
                       	</div>

                    </div>
                    <div class="row">
                       	<div class="col-md-12">
                            <h4 class="title">Interview Locations:</h4>
                            <span class="chip">Ludhiana</span>
                            <span class="chip">Jalandhar</span>
                            <span class="chip">Delhi</span>
                            <span class="chip">Mumbai</span>
                            <span class="chip">Chandigarh</span>
                            <span class="chip">Jaipur</span>
                       	</div>


                    </div>

                </div>
            </div>
            <div class="col-md-2">

            </div>
            <div class="col-md-3">
                <div id="side_panel">
                    <h3 class="minor_details">Job Title</h3>
                    <br>
                    <p class="elements"><i class="fa fa-calendar" aria-hidden="true"></i> Date Posted</p>
                    <p class="elements border-bottom">10-08-2018</p>
                    <br>
                    <p class="elements"><i class="fa fa-black-tie" aria-hidden="true"></i> Job Type</p>
                    <p class="elements border-bottom">Full Time</p>
                    <br>
                    <p class="elements"><i class="fa fa-user" aria-hidden="true"></i> Total Vaccencies</p>
                    <p class="elements border-bottom">500</p>
                    <br>
                    <p class="elements"><i class="fa fa-money" aria-hidden="true"></i> Salery Est.</p>
                    <p class="elements border-bottom">10-20K~</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1">

    </div> 

</div>




<?php
$this->registerCss("

body
{
background-color:#F1F3FA;
}

#cover_image
{
	width: 100%;
	position: absolute;
        height:325px

    }

#profile_photo
{
	/*border: 4px solid #ffffff;*/
    width: 150px;
    height: 150px;
    /* right: 0px; */
    position: relative;
    /* margin-bottom: 0px; */
    top: 250px;
    /* right: -12px; */
    left: 35px;
}
.title,#comp_name
{
	
	font-family: 'Lobster', cursive;
}

.minor_details
{
	font-family: 'Lobster', cursive;
	text-align: center;
}

.button {
    background-color: #1d1f1d;
    border: none;
    color: white;
    padding: 8px 27px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    font-weight: 600;
    border-radius: 7px;
}

.share_ld {
    color: #0075B5;
    cursor: pointer;
    text-shadow: 0px 7px 10px rgba(0, 0, 0, 0.4);
    transition: all ease-in-out 150ms;
}

.share_fb {
    color: #4867AA;
    cursor: pointer;
    text-shadow: 0px 7px 10px rgba(0, 0, 0, 0.4);
    transition: all ease-in-out 150ms;
}

.share_tw {
    color: #1DA1F2;
    cursor: pointer;
    text-shadow: 0px 7px 10px rgba(0, 0, 0, 0.4);
    transition: all ease-in-out 150ms;
}

.share_gp {
    color: #d34836;
    cursor: pointer;
    text-shadow: 0px 7px 10px rgba(0, 0, 0, 0.4);
    transition: all ease-in-out 150ms;
}
.share_em {
    color: #ed2301;
    cursor: pointer;
    text-shadow: 0px 7px 10px rgba(0, 0, 0, 0.4);
    transition: all ease-in-out 150ms;
}

#row_style
{
 margin-top: 199px;
 margin-left: 147px;
}

#job_description
{
    margin-top:30px;
    width: 100%;
    min-height: 500px;
    border: 2px solid #ffffff;
    border-radius: 15px;
    background-color: #ffffff;
    padding: 12px 18px;
    margin-bottom:24px;

   }

  #side_panel
  {
    margin-top:30px;
    width: 100%;
    min-height: 500px;
    border: 2px solid #ffffff;
    border-radius: 15px;
    background-color: #ffffff;
    padding: 12px 18px;
    
  }

  .text_desc
  {
  	text-align: justify;
  }

.button:hover
{
	text-decoration: none;
	color: white;

}
.logo
{
	border-radius: 75px;
}

.chip
{
    display: inline-block;
    height: 26px;
    font-size: 14px;
    font-weight: 500;
    font-weight: 500;
    color: rgba(0, 0, 0, 0.6);
    line-height: 28px;
    padding: 0px 12px;
    border-radius: 16px;
    background-color: #e4e4e4;
    margin-bottom: 4px;
    margin-right: 5px;
    margin-top: 0px;
}
.title2
{
	font-family: 'Open Sans', sans-serif;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333333;
}

.elements
{
	text-align: center;
}

.border-bottom
{
	    border-bottom: 1px solid #e4e4e4;
}
");

$script = <<<JS

 
 
JS;

$this->registerJs($script);


$this->registerCssFile('https://fonts.googleapis.com/css?family=Lobster');


