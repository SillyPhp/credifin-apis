<?php
$this->title = Yii::t('frontend', 'Job Detail');
$this->params['header_dark'] = true;

use yii\helpers\Url;

$total_vac = 0;

foreach ($options as $value) {
    $option[$value['option_name']] = $value['value'];
}



foreach ($org_details as $org) {
    $org_name = $org['name'];
    $org_email = $org['email'];
    $org_website = $org['website'];
    $logo = $org['logo'];
    $logo_location = $org['logo_location'];
    $cover = $org['cover_image'];
    $cover_location = $org['cover_image_location'];
}

$cover_image = Yii::$app->params->upload_directories->organizations->cover_image . $cover_location . DIRECTORY_SEPARATOR . $cover;
$cover_image_base_path = Yii::$app->params->upload_directories->organizations->cover_image_path . $cover_location . DIRECTORY_SEPARATOR . $cover;
if (!file_exists($cover_image_base_path)) {
    $cover_image = "http://www.placehold.it/1500x500/EFEFEF/AAAAAA&amp;text=No+Cover+Image";
}

$logo_image = Yii::$app->params->upload_directories->organizations->logo . $logo_location . DIRECTORY_SEPARATOR . $logo;
$logo_base_path = Yii::$app->params->upload_directories->organizations->logo_path . $logo_location . DIRECTORY_SEPARATOR . $logo;

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
    <div class="col-md-offset-1 col-md-10">
        <div class="row" id="row_style">
            <div class="col-md-4">
                <h4 id="comp_name"><?php echo ucwords($org_name); ?></h4>	
            </div>
            <div class="col-md-4">
                <a href="#" class="button">Apply</a>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <div class="col-md-1">

    </div>
</div>
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div class="row">
            <div class="col-md-8">
                <div id="job_description">
                    <h3 class="title">Job Description</h3>
                    <p class="text_desc">

                    <ul>
                        <?php
                        foreach ($desc as $job_desc) {
                            ?>
                            <li> <?php echo ucwords($job_desc['job_description']); ?> </li>

                        <?php }
                        ?>
                    </ul>
                    </p>
                    <h3 class="title">Skills Required</h3>
                    <div  class="skills">
                        <?php foreach ($skills as $job_skill) { ?>
                            <span class="chip"><?php echo ucwords($job_skill['skill']); ?> </span>
                        <?php } ?>
                    </div>
                    <h3 class="title">Job Locations</h3>
                    <ul class="job-locations">
                        <?php
                        foreach ($placements as $job_placement) {
                            $total_vac = $total_vac + $job_placement['positions'];
                            ?>
                            <li><i class="fa fa-map-marker"></i><?php echo $job_placement['name']; ?></li>
                        <?php } ?>
                    </ul>
                    <h3 class="title">Interview Details:</h3>
                    <div class="row">
                        <?php //if($object->interradio == 1){   ?>  
                       	<div class="col-md-4">

                            <span class="title2">Start From: <strong><?php echo $option['interview_start_date'];      ?></strong></span> 
                       	</div>
                       	<div class="col-md-4">
                            <span class="title2">Upto: <strong><?php echo $option['interview_end_date'];      ?></strong></span>
                       	</div>
                        <?php
                        //}
                        //else //{
                        ?>
                        <div class="col-md-12"> 
                            <!--                        <label>NA</label>-->
                        </div>
                        <?php //}  ?>
                    </div>
                    <div class="row">
                       	<div class="col-md-12">
                            <h3 class="title">Interview Locations:</h3>
                            <?php //if($object->interradio == 1){  ?>  
                            <ul class="job-locations">
                                <?php
                                foreach ($interview_loc as $loc) {
                                    ?>
                                    <li><i class="fa fa-dot-circle-o"></i><?php echo $loc['name']; ?></li>
                                <?php } ?>
                            </ul>
                            <?php
                            //} else
                            //{
                            ?>

                            <!--                            <label>NA</label>-->
                            <?php //}   ?>  
                       	</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div id="side_panel">
                    <h3 class="title"><?php
                        foreach ($title as $job_tit) {
                            echo $job_tit['name'];
                            $application_date = $job_tit['date_created'];
                            $type = $job_tit['type'];
                        }
                        ?></h3>
                    <p class="border-bottom"><i class="fa fa-calendar" aria-hidden="true"></i> <strong>Date Posted</strong> :- <?php echo $application_date; ?></p>
                    <p class="border-bottom"><i class="fa fa-black-tie" aria-hidden="true"></i> <strong>Job Type</strong> :- <?php echo $type; ?></p>
                    <p class="border-bottom"><i class="fa fa-user" aria-hidden="true"></i> <strong>Total Vaccencies</strong> :- <?php echo $total_vac; ?></p>
                    <p class="border-bottom"><i class="fa fa-money" aria-hidden="true"></i> <strong>Salery Est.</strong> :- <?php echo $option['salary'];      ?></p>
                    <p class="border-bottom"><i class="fa fa-money" aria-hidden="true"></i> <strong>CTC</strong> :- <?php echo $option['ctc'];?></p>
                </div>
                <div id="side_panel">
                    <h3 class="title">Company Details</h3>
                    <p class="border-bottom"><i class="fa fa-users" aria-hidden="true"></i> <strong>Name</strong> :- <?php echo ucwords($org_name); ?> </p>
                    <p class="border-bottom"><i class="fa fa-globe" aria-hidden="true"></i> <strong>Email</strong>:- <?php echo $org_email; ?> </p>
                    <p class="border-bottom"><i class="fa fa-envelope" aria-hidden="true"></i> <strong>Website</strong>:- <?php echo $org_website; ?> </p>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1">

    </div> 
</div>

<?php
$this->registerCss("
body{
    background-color:#F1F3FA;
}
#cover_image{
    width: 100%;
    position: absolute;
    height:325px
}
#profile_photo{
    /*border: 4px solid #ffffff;*/
    width: 150px;
    height: 150px;
    /* right: 0px; */
    position: relative;
    /* margin-bottom: 0px; */
    top: 250px;
    /* right: -12px; */
    left: 3%;
}
@media only screen and (min-width: 1440px){
    #profile_photo{
        left:4%;
    }
}
@media only screen and (min-width: 1740px){
    #profile_photo{
        left:6%;
    }
}
.title,#comp_name{
    font-family: 'Lobster', cursive;
        font-size: 23px;
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
#row_style{
    margin-top: 199px;
    margin-left: 147px;
}
#job_description{
    margin-top:30px;
    width: 100%;
    min-height: 500px;
    border: 2px solid #ffffff;
    border-radius: 15px;
    background-color: #ffffff;
    padding: 12px 25px;
    margin-bottom:24px;
    box-shadow: 0px 2px 11px 0px #ddd;
}
#side_panel{
    margin-top:30px;
    width: 100%;
//    min-height: 500px;
    border: 2px solid #ffffff;
    border-radius: 15px;
    background-color: #ffffff;
    padding: 12px 25px;
    box-shadow: 0px 2px 11px 0px #ddd;
    margin-bottom: 21px;
}
.text_desc{
    text-align: justify;
}
.button:hover{
    text-decoration: none;
    color: white;
}
.logo{
    border-radius: 75px;
}
.job-locations{
    display:inline-block;
}
.job-locations li{
    float:left;
    margin-right:18px;
    font-size:15px;
}
.chip{
    display: inline-block;
    height: auto;
    font-size: 14px;
    font-weight: 500;
    font-weight: 500;
    color: rgba(0, 0, 0, 0.6);
    line-height: 28px;
    padding: 4px 14px;
    border-radius: 16px;
    background-color: #e4e4e4;
    margin-bottom: 6px;
    margin-right: 5px;
    margin-top: 0px;
}
.title2{
    font-family: 'Open Sans', sans-serif;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333333;
}
.border-bottom{
    border-bottom: 1px solid #e4e4e4;
    padding: 10px 0px;
    margin: 10px 0px;
}
");

$script = <<<JS

 
 
JS;

$this->registerJs($script);


$this->registerCssFile('https://fonts.googleapis.com/css?family=Lobster');


