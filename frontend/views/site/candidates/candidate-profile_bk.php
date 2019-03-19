<?php
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Html;
?>
<!--modal start-->
<div class="modal fade bs-modal-lg in" id="modal"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?= Url::to('@backendAssets/global/img/loading-spinner-grey.gif') ?>" alt="<?= Yii::t('frontend', 'Loading'); ?>" class="loading">
                <span> &nbsp;&nbsp;<?= Yii::t('frontend', 'Loading'); ?>... </span>
            </div>
        </div>
    </div>
</div>
<!--modal end-->
<div class="min-nav" id="min-nav">
    <ul class="nav nav-stacked navbar-fixed-top">
        <li class="active"><a href="#home" data-toggle="tooltip" data-placement="right" title="About Me"><i class="fa fa-home"></i></a></li>
        <li><a href="#exp" data-toggle="tooltip" data-placement="right" title="Experience"><i class="fa fa-briefcase"></i></a></li>
        <li><a href="#edu" data-toggle="tooltip" data-placement="right" title="Education"><i class="fa fa-graduation-cap"></i></a></li>
        <li><a href="#skills" data-toggle="tooltip" data-placement="right" title="Skills"><i class="fa fa-cogs" ></i></a></li>
        <li><a href="#portfolio" data-toggle="tooltip" data-placement="right" title="Portfolio"><i class="fa fa-folder-open"></i></a></li>
        <li><a href="#recommendation" data-toggle="tooltip" data-placement="right" title="Recommendation"><i class="fa fa-pencil"></i></a></li>
        <li><a href="#blog" data-toggle="tooltip" data-placement="right" title="Blog"><i class="fa fa-comments"></i></a></li>
        <!--<li><a href="" data-toggle="tooltip" data-placement="right" title="Say Hello"><i class="fa fa-envelope-o"></i></a></li>-->
    </ul>
</div>  
<!-- Main jumbotron for a primary marketing message or call to action -->

<div id="home"> 
    <div class="jumbo">
        <div class="can-user-icon">
            <!--                <div id="popover_avatar" class="popover menu" style="opacity: 0; left: 335.5px; top: 164px; display: none;">
                                <ul> 
                                    <li>
                                        <input name="avatar_image" id="avatar_image" accept="image/*" class="h-hidden" type="file">
                                        <a id="btn_avatar_upload">Upload Image...</a>
                                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="" class="img-circle img-thumbnail "/></div>
                                    </li>
                                </ul> 
                            </div>-->
            <div>
                <div class="personal-avatar h-iblock pb-20">

                    <!--<div class="image-upload h-cp rad-100%">-->
                    <div class="image-upload h-cp rad-100">
                        <div id="current-user-avatar">
                            <!--<img class="i-avatar" id="avatar_img_tag" src="MindMeister_files/default_avatar-b43bffa1218b399de437d643f24d91b05a8e8010e0d7e.svg" alt="Default avatar">-->
                            <img class="i-avatar" id="avatar_img_tag" src="/assets/themes/ey/images/pages/candidate-profile/Girls2.jpg" alt="Default avatar">

                        </div>
                        <a href="#" class="opener" id="btn_avatar"><i class="fa fa-camera"></i></a>
                    </div>

                    <div id="popover_avatar" class="popover menu" style="left: 182px; top: 86px; display: none;">
                        <ul>
                            <li>
                                <?php
                                $form = ActiveForm::begin([
                                            'id' => 'upload-company-logo',
                                            'options' => ['enctype' => 'multipart/form-data'],
                                        ])
                                ?>
                                <!--<input name="avatar_image" id="upload-input" class="avatar_image" accept="image/*" class="h-hidden" type="file">-->
                                <?=
                                $form->field($companyLogoFormModel, 'logo', [
                                    'template' => '{input}',
                                ])->fileInput(['class' => 'avatar_image h-hidden', 'id' => 'upload-input']);
                                ?>
                                <?php ActiveForm::end() ?>
                                <a href=""  id="btn_avatar_upload">Change Image</a>
                            </li>
                            <!--                            <li>
                                                            <input name="avatar_image" id="edit" class="avatar_image" accept="image/*" class="l-hidden" type="file">
                                                            <a id="btn_crop_avatar">Edit</a>
                                                        </li>-->
                            <li>
                                <input name="avatar_image" id="tk" class="avatar_image" accept="image/*" class="j-hidden" type="file">
                                <a href=""id="btn_avatar_webcam">Remove</a> 
                            </li>
                            <li>
                                <input type="hidden" name="avatar_image" id="pk" class="avatar_can" accept="image/*" class="j-hidden" type="file">
                                <a href="#" id="btn_avatar_can">Cancel</a>
                            </li>
                        </ul>
                        <!--<span class="arrow" style="left: 56.5px;"></span>-->
                    </div>
                    <div id="f-img" class="popover menu final-image" style="left: 182px; top: 86px; display: none;">
                        <ul>
                            <li>
                            <!--<input name="avatar_ige" id="tk" class="avatar_image" accept="image/*" class="j-hidden" type="file">-->
                                <a id="btn_avatar_sav">SAVE...</a>
                            </li>
                            <li>
                        <!--<input name="avatar_cancel" id="tk" class="avatar_image" accept="image/*" class="j-hidden" type="file">-->
                                <a id="avatar_cancel">CANCEL...</a>
                            </li>
                        </ul>
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <div class="bdy-content">
        <div id="about" >
            <!-- Example row of columns -->
            <div class="row">
                <div class="col-md-5 col-sm-4 head-btns">
                    <div class="col-md-5 col-sm-12">
                        <div class="head-btn1">
                            <a href="">
                                <i class="fa fa-volume-control-phone"></i>
                                <span class="btn-txt"> Contact Me</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <div class=" head-btn1 head-btn11">
                            <a href="">
                                <i class="fa fa-envelope-o"></i>
                                <div class="btn-txt2"> Send Email</div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-offset-2 col-md-5 col-sm-offset-4 col-sm-4 head-btns">
                    <div class="col-md-offset-1 col-md-5 col-sm-12 ">
                        <div class="head-btn2">
                            <a href="">
                                <i class="fa fa-cloud-download"></i>
                                <div class="btn-txt"> Download CV</div>
                            </a>  
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <div class=" head-btn2 head-btn11">
                            <a href="">
                                <i class="fa fa-list-ul"></i>
                                <div class="btn-txt"> Shortlist Profile</div>
                            </a>    
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="bdy-content">
                    <!--<div class="col-md-12 can-name-heading">Dummy Name </div>-->
                    <div class="col-md-12 can-name-heading"><?= $user['first_name']; ?> </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="personal-info">
                <div class="personal-detail col-md-6">
                    <h1 class="heading-style ">About Me</h1>
                    <div class="per-discription" id="gg">
                        <!--<label class="text_label">-->
<!--                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 
                        1500s,when an unknown printer took a galley of type and scrambled it to 
                        make a type specimen book.Letraset sheets containing Lorem Ipsum passages
                        and more recently with desktop publishing software like Aldus PageMaker 
                        including versions of Lorem Ipsum.-->
                    <!--</label>-->
                    <!--<div class="edit" ><i class="fa fa-edit"></i>-->
                    <a href="#" id="username" data-type="text" data-pk="1" data-url="/site/update-profile" data-title="Enter username">                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
<!--                        Lorem Ipsum has been the industry's standard dummy text ever since the 
                        1500s,when an unknown printer took a galley of type and scrambled it to 
                        make a type specimen book.Letraset sheets containing Lorem Ipsum passages
                        and more recently with desktop publishing software like Aldus PageMaker 
                        including versions of Lorem Ipsum.-->
                    <?= $users['description'];?>
                    </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 per">
                <div class="per-det col-md-12 row">
                    <div class="button_location" style="">
                        <?= Html::button('Edit', ['value' => URL::to('/site/personal-profile'), 'class' => 'btn btn-primary modal-load-class']); ?>
                    </div>
                    <h1 class="heading-style col-md-12">Personal Details</h1>
                    <div class="col-md-6 col-sm-6">
                        <div class="can-name col-md-6 col-sm-4">Nationality:</div>
                        <div class="can-name-fill col-md-6 col-sm-8 gg">
                            <a href="#" id="note" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Indian<i class="fa fa-pencil"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 ">
                        <div class="can-name col-md-4 col-sm-4">Skype:</div>
                        <div class="can-name-fill col-md-6 col-sm-8">
                            <a href="#" id="sky" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">YourSkype<i class="fa fa-pencil"></i></a></div>
                    </div>

                    <div class="col-md-6 col-sm-6 per-ped">
                        <div class="can-name col-md-6 col-sm-4">Marital:</div>
                        <div class="can-name-fill col-md-6 col-sm-8">
                            <a href="#" id="sex" data-type="select" data-pk="1" data-value="" data-title="Select sex">Single<i class="fa fa-pencil"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 per-ped">
                        <div class="can-name col-md-4 col-sm-4">Phone:</div>
                        <!--<div class="can-name-fill col-md-8 col-sm-8">123-456-789</div>-->
                        <div class="can-name-fill col-md-8 col-sm-8">
                            <a href="#" id="phn" data-type="text" data-pk="1" data-url="/post" data-title="Enter username"><?= $user['phone']; ?><i class="fa fa-pencil"></i></a></div>
                    </div>

                    <div class="col-md-6 col-sm-6 per-ped">
                        <div class="can-name col-md-6 col-sm-4">DOB:</div>
                        <div class="can-name-fill col-md-6 col-sm-8">
                            <a href="#" id="dob" data-type="date" data-pk="1" data-url="/post" data-title="Select Date">28-09-1993<i class="fa fa-pencil"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 per-ped">
                        <div class="can-name col-md-4 col-sm-4">Email:</div>
                        <div class="can-name-fill col-md-6 col-sm-8">
                        <a href="#" id="mail" data-type="text" data-pk="1" data-url="/post" data-title="Enter username"><?= $user['email']; ?><i class="fa fa-pencil"></i></a>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="wrap">
<!--                            <div class="social">
                                <i class="fa fa-facebook fb"></i>
                                <i class="fa fa-twitter tw"></i>
                                <i class="fa fa-youtube yt"></i>
                                <i class="fa fa-linkedin lk"></i>
                                <i class="fa fa-skype sk"></i>
                                <i class="icon-dropbox db"></i>
                                <i class="icon-apple apple"></i>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<!--<div class="clearfix"></div>-->
<!-- experience -->
<section id="exp">
    <div class="exp col-md-12">
        <div class="bdy-content">
            <h1 class="heading-style " style="">Work Experience</h1>
            <!--                <div class="col-md-4">-->
            <div class="button_location" style="">
                <?= Html::button('Add Work Experience', ['value' => URL::to('/site/work-experience'), 'class' => 'btn btn-primary modal-load-class']); ?>
                <!--</div>-->
            </div>
            <div class="exp-box1 ">
                <div class="minus-padding col-md-1">
                    <div class="com-line com-mark">
                        <i class="fa fa-bullseye"></i>
                    </div>
                    <div class="com-mark-img">
                    </div>
                </div>
                <div class="exp-time col-md-3"> 
                    <div class="com-name"><a href="#" id="company_name1" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">DSB Edu Tech</a></div>
                    <div class="com-loc"><a href="#" id="place1" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Ludhiana</a></div>
                    <div class="com-time">
                        <div class="col-md-6">
                            <div class="com-t">From</div>
                            <div class="com-due"><a href="#" id="from1" data-type="date" data-pk="1" data-url="/post" data-title="Enter username">July - 2018</a></div>
                        </div>
                        <div class="col-md-6">
                            <div class="com-t">To</div>
                            <div class="com-due"><a href="#" id="to1" data-type="date" data-pk="1" data-url="/post" data-title="Enter username">Present</a></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="time-du">( 2 years 9 months )</div>
                </div>
                <div class="exp-post col-md-8">
                    <div class="post"><a href="#" id="designation_1" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">WEB DESIGNER</a></div>
                    <div class="role">Tasks Performed</div>
                    <div class="duty"><a href="#" id="comments" data-type="textarea" data-pk="1" data-url="/post" data-title="Enter username">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,versions of Lorem Ipsum.</a></div>
                </div> 
            </div>

            <div class="clearfix"></div> 

            <div class="exp-box1 ">
                <div class="minus-padding col-md-1">
                    <div class="com-line com-mark">
                        <i class="fa fa-bullseye"></i>
                    </div>
                    <div class="com-mark-img">
                    </div>
                </div>
                <div class="exp-time col-md-3"> 
                    <div class="com-name"><a href="#" id="company_name2" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">DSB Edu Tech</a></div>
                    <div class="com-loc"><a href="#" id="place2" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Ludhiana</a></div>
                    <div class="com-time">
                        <div class="col-md-6">
                            <div class="com-t">From</div>
                            <div class="com-due"><a href="#" id="from2" data-type="date" data-pk="1" data-url="/post" data-title="Enter username">July - 2018</a></div>
                        </div>
                        <div class="col-md-6">
                            <div class="com-t">To</div>
                            <div class="com-due"><a href="#" id="to2" data-type="date" data-pk="1" data-url="/post" data-title="Enter username">Present</a></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="time-du">( 2 years 9 months )</div>
                </div>
                <div class="exp-post col-md-8">
                    <div class="post"><a href="#" id="designation_2" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">WEB DESIGNER</a></div>
                    <div class="role">Tasks Performed</div>
                    <div class="duty"><a href="#" id="comments_2" data-type="textarea" data-pk="1" data-url="/post" data-title="Enter username">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,versions of Lorem Ipsum.</a></div>
                </div> 
            </div>

            <div class="clearfix"></div> 

            <div class="exp-box1 ">
                <div class="minus-padding col-md-1">
                    <div class="com-line com-mark">
                        <i class="fa fa-bullseye"></i>
                    </div>
                    <div class="com-mark-img">
                    </div>
                </div>
                <div class="exp-time col-md-3"> 
                    <div class="com-name"><a href="#" id="company_name3" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">DSB Edu Tech</a></div>
                    <div class="com-loc"><a href="#" id="place3" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Ludhiana</a></div>
                    <div class="com-time">
                        <div class="col-md-6">
                            <div class="com-t">From</div>
                            <div class="com-due"><a href="#" id="from3" data-type="date" data-pk="1" data-url="/post" data-title="Enter username">July - 2018</a></div>
                        </div>
                        <div class="col-md-6">
                            <div class="com-t">To</div>
                            <div class="com-due"><a href="#" id="to3" data-type="date" data-pk="1" data-url="/post" data-title="Enter username">Present</a></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="time-du">( 2 years 9 months )</div>
                </div>
                <div class="exp-post col-md-8">
                    <div class="post"><a href="#" id="designation_3" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">WEB DESIGNER</a></div>
                    <div class="role">Tasks Performed</div>
                    <div class="duty"><a href="#" id="commnets_3" data-type="textarea" data-pk="1" data-url="/post" data-title="Enter username">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,versions of Lorem Ipsum.</a></div>
                </div> 
            </div>
        </div>   
    </div>    
</section>

<div class="clearfix"></div>
<!-- education -->    
<section id="edu">
    <div class="edu">
        <div class="bdy-content">
            <div class="button_location" style="">
                <?= Html::button('Edit', ['value' => URL::to('/site/qualification'), 'class' => 'btn btn-primary modal-load-class']); ?>
            </div>
            <h1 class="heading-style ">Qualification</h1>
            <div class="col-md-offset-1 col-md-5">
                <div class="edubox1">
                    <div class="edu-icon"><i class="fa fa-graduation-cap"></i></div>   
                    <div class="h-school-name"><a href="#" id="dg1" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Degree Name</a></div>
                    <div class="bord-name"><a href="#" id="un1" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">University Name</a></div>
                    <div class="h-year">
                        <a href="#" id="y1" data-type="date" data-pk="1" data-url="/post" data-title="Enter username">2010-2011</a>
                    </div>
                </div> 
            </div>
            <div class=" col-md-5">
                <div class="edubox1">
                    <div class="edu-icon"><i class="fa fa-graduation-cap"></i></div>   
                    <div class="h-school-name"><a href="#" id="dg2" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Degree Name</a></div>
                    <div class="bord-name"><a href="#" id="un2" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">University Name</a></div>
                    <div class="h-year">
                  <a href="#" id="y2" data-type="date" data-pk="1" data-url="/post" data-title="Enter username">2010-2011</a>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>

<!--Skills-->
<section id="skills">
    <div class="skills col-md-12">
        <div class="bdy-content">
            <div class="col-md-8">
                <div class="button_location" style="">
                    <?= Html::button('Edit', ['value' => URL::to('/site/skill-and-language'), 'class' => 'btn btn-primary modal-load-class']); ?>
                </div>
                <h1 class="heading-style">Skills & Language</h1>
                <div class="keyheading">Key Skills</div>
                <div class="col-md-6">
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" style="width: 55%" aria-valuenow="55" >HTML</div>
                    </div>
                    <!--                        <div class="col-md-6 start-val">0</div><div class="col-md-6 end-val">100</div>
                                            <input type="range" min="0" max="100" value="0"class="slider" id="myRange">
                                            <span class="help-block help-block-error" id="rangeerror">Please select range</span>-->
                </div>
                <div class="col-md-6">
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" style="width: 65%;" aria-valuenow="65" >CSS</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" style="width: 75%" aria-valuenow="75" >Photoshop</div>
                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" style="width: 40%" aria-valuenow="40" >Javascript</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" style="width: 80%" aria-valuenow="80" >Coraldraw</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" style="width: 80%" aria-valuenow="80" >Bootstrap</div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="skill-tags">
                    <div class="additionalskills">Additional Skills</div>
                    <ul>
                        <li>HTML</li>
                        <li>CSS</li>
                        <li>Javascript</li>
                        <li>Photoshop</li>
                        <li>CoralDraw</li>
                    </ul>
                </div>

            </div>
            <div class="col-md-4 communication">
                <div class="keyheading">Communication</div>
                <div class="col-md-12 com-prog">
                    <div class="communication-lvl">Novice <span>Intermediate</span><span> Advanced</span></div>      
                    <div class="progress margin-top-0">
                        <div class="progress-bar progress-bar-success" role="progressbar"  aria-valuenow="90" 
                             aria-valuemin="0" aria-valuemax="100" >English</div>
                    </div>
                </div>
                <div class="col-md-12 com-prog">
                    <div class="communication-lvl">Novice <span>Intermediate</span><span> Advanced</span></div>
                    <div class="progress  margin-top-0">
                        <div class="progress-bar progress-bar-info" role="progressbar"  aria-valuenow="90" 
                             aria-valuemin="0" aria-valuemax="100" >Hindi</div>
                    </div>
                </div>
                <div class="col-md-12 com-prog">
                    <div class="communication-lvl">Novice <span>Intermediate</span><span> Advanced</span></div>
                    <div class="progress margin-top-0">
                        <div class="progress-bar progress-bar-warning " aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"
                             role="progressbar" >Punjabi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="clearfix"></div>

<!--Portfolio-->
<section id="portfolio" class="portfolio">
    <div class="bdy-content ">
        <div class="lr-padding">
            <div class="button_location" style="">
                <?= Html::button('Edit', ['value' => URL::to('/site/portfolio'), 'class' => 'btn btn-primary modal-load-class']); ?>
            </div>
            <h1 class="heading-style">Portfolio</h1>
            <div class="gallary animate-grid">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="categories">
                            <ul>
                                <li>
                                    <ol>
                                        <li><a href="#" data-filter="*" class="active">All</a></li>
                                        <li><a href="#" data-filter=".web">Web Design</a></li>
                                        <li><a href="#" data-filter=".photography">Photography</a></li>
                                        <li><a href="#" data-filter=".app">Mobile App</a></li>
                                        <li><a href="#" data-filter=".branding">Branding</a></li>
                                    </ol>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row gallary-thumbs">
                    <div class="col-sm-6 col-md-3 branding">
                        <div class="gallary-item">
                            <div class="hover-bg">
                                <a href="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" data-caption="Img 1"  data-fancybox="image"> 
                                    <div class="hover-text">
                                        <h4>Logo Design</h4>
                                        <small>Branding</small>
                                        <div class="clearfix"></div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" class="img-responsive" alt="...">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 photography app">
                        <div class="gallary-item">
                            <div class="hover-bg">
                                <a href="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" data-caption="Img 1"  data-fancybox="image"> 
                                    <div class="hover-text">
                                        <h4>Logo Design</h4>
                                        <small>Branding</small>
                                        <div class="clearfix"></div>
                                        <i class="fa fa-plus"></i>
                                    </div> 
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" class="img-responsive" alt="...">
                                </a>    
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 branding">
                        <div class="gallary-item">
                            <div class="hover-bg">
                                <a href="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" data-caption="Img 1"  data-fancybox="image">
                                    <div class="hover-text">
                                        <h4>Logo Design</h4>
                                        <small>Branding</small>
                                        <div class="clearfix"></div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" class="img-responsive" alt="...">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 branding">
                        <div class="gallary-item">
                            <div class="hover-bg">
                                <a href="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" data-caption="Img 1"  data-fancybox="image"> 
                                    <div class="hover-text">
                                        <h4>Logo Design</h4>
                                        <small>Branding</small>
                                        <div class="clearfix"></div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" class="img-responsive" alt="..."> 
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 web">
                        <div class="gallary-item">
                            <div class="hover-bg">
                                <a href="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" data-caption="Img 1"  data-fancybox="image"> 
                                    <div class="hover-text">
                                        <h4>Logo Design</h4>
                                        <small>Branding</small>
                                        <div class="clearfix"></div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" class="img-responsive" alt="..."> 
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 app">
                        <div class="gallary-item">
                            <div class="hover-bg">
                                <a href="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" data-caption="Img 1"  data-fancybox="image"> 
                                    <div class="hover-text">
                                        <h4>Logo Design</h4>
                                        <small>Branding</small>
                                        <div class="clearfix"></div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" class="img-responsive" alt="..."> 
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 photography web">
                        <div class="gallary-item">
                            <div class="hover-bg">
                                <a href="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" data-caption="Img 1"  data-fancybox="image">
                                    <div class="hover-text">
                                        <h4>Logo Design</h4>
                                        <small>Branding</small>
                                        <div class="clearfix"></div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" class="img-responsive" alt="..."> 
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3 web">
                        <div class="gallary-item">
                            <div class="hover-bg">
                                <a href="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" data-caption="Img 1"  data-fancybox="image">
                                    <div class="hover-text">
                                        <h4>Logo Design</h4>
                                        <small>Branding</small>
                                        <div class="clearfix"></div>
                                        <i class="fa fa-plus"></i>
                                    </div>
                                    <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Placeholder.png') ?>" class="img-responsive" alt="..."> 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--<div class="clearfix"></div>
<section id="recommendation" class="recom">
    <div class="bdy-content">
        <h1 class="heading-style">Recommendations</h1>
    </div>
    <div id="carousel">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="quote"><i class="fa fa-quote-left fa-4x"></i></div>
                <div class="carousel slide" id="fade-quote-carousel" data-ride="carousel" data-interval="3000">
                     Carousel indicators 
                    <ol class="carousel-indicators">
                        <li data-target="#fade-quote-carousel" data-slide-to="0"></li>
                        <li data-target="#fade-quote-carousel" data-slide-to="1"></li>
                        <li data-target="#fade-quote-carousel" data-slide-to="2" class="active"></li>
                        <li data-target="#fade-quote-carousel" data-slide-to="3"></li>
                        <li data-target="#fade-quote-carousel" data-slide-to="4"></li>
                        <li data-target="#fade-quote-carousel" data-slide-to="5"></li>
                    </ol>
                     Carousel items 
                    <div class="carousel-inner">
                        <div class="item">
                            <div class="profile-circle" ><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="" class="img-circle img-responsive"/></div>
                            <blockquote>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, veritatis nulla eum laudantium totam tempore optio doloremque laboriosam quas, quos eaque molestias odio aut eius animi. Impedit temporibus nisi accusamus.</p>
                            </blockquote>	
                        </div>
                        <div class="item">
                            <div class="profile-circle" ><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="" class="img-circle img-responsive"/></div>
                            <blockquote>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, veritatis nulla eum laudantium totam tempore optio doloremque laboriosam quas, quos eaque molestias odio aut eius animi. Impedit temporibus nisi accusamus.</p>
                            </blockquote>
                        </div>
                        <div class="active item">
                            <div class="profile-circle" ><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="" class="img-circle img-responsive"/></div>
                            <blockquote>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, veritatis nulla eum laudantium totam tempore optio doloremque laboriosam quas, quos eaque molestias odio aut eius animi. Impedit temporibus nisi accusamus.</p>
                            </blockquote>
                        </div>
                        <div class="item">
                            <div class="profile-circle" ><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="" class="img-circle img-responsive"/></div>
                            <blockquote>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, veritatis nulla eum laudantium totam tempore optio doloremque laboriosam quas, quos eaque molestias odio aut eius animi. Impedit temporibus nisi accusamus.</p>
                            </blockquote>
                        </div>
                        <div class="item">
                            <div class="profile-circle" ><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="" class="img-circle img-responsive"/></div>
                            <blockquote>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, veritatis nulla eum laudantium totam tempore optio doloremque laboriosam quas, quos eaque molestias odio aut eius animi. Impedit temporibus nisi accusamus.</p>
                            </blockquote>
                        </div>
                        <div class="item">
                            <div class="profile-circle" ><img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/Girls2.jpg') ?>" alt="" class="img-circle img-responsive"/></div>
                            <blockquote>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem, veritatis nulla eum laudantium totam tempore optio doloremque laboriosam quas, quos eaque molestias odio aut eius animi. Impedit temporibus nisi accusamus.</p>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>							
        </div>
    </div>
</section>
<div class="clearfix"></div>
<section id="blog" class="blog col-md-12">
    <div class="col-md-12 ">
        <div class="bdy-content">
            <h1 class="heading-style">My Blog</h1>
            <div class="col-md-4">
                <div class="blog-box-1">
                    <div class="blog-cover">
                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/blog-cover1.jpeg') ?>" alt="" class="img-responsive "/>
                    </div>
                </div>
                <div class="blog-details">
                    <div class="blog-name">
                        <a href="">
                            <i class="fa fa-pencil-square-o"></i> Your Blog Name
                        </a>
                    </div>
                    <div class="blog-summary">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tincidunt nulla tortor, 
                        imperdiet enim tristique Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tincidunt nulla tortor
                        , a imperdiet enim tristique
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="blog-box-1">
                    <div class="blog-cover">
                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/blog-cover1.jpeg') ?>" alt="" class="img-responsive "/>
                    </div>
                </div>
                <div class="blog-details">
                    <div class="blog-name">
                        <a href="">
                            <i class="fa fa-pencil-square-o"></i> Your Blog Name
                        </a>
                    </div>
                    <div class="blog-summary">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tincidunt nulla tortor, 
                        imperdiet enim tristique Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tincidunt nulla tortor
                        , a imperdiet enim tristique
                    </div>
                </div>
            </div> 
            <div class="col-md-4">
                <div class="blog-box-1">
                    <div class="blog-cover">
                        <img src="<?= Url::to('@eyAssets/images/pages/candidate-profile/blog-cover1.jpeg') ?>" alt="" class="img-responsive "/>
                    </div>
                </div>
                <div class="blog-details">
                    <div class="blog-name">
                        <a href="">
                            <i class="fa fa-pencil-square-o"></i> Your Blog Name
                        </a>
                    </div>
                    <div class="blog-summary">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tincidunt nulla tortor, 
                        imperdiet enim tristique Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam tincidunt nulla tortor
                        , a imperdiet enim tristique
                    </div>
                </div>
            </div> 
        </div>
    </div>    
</section>
<div class="clearfix"></div>-->
<?php
$this->registerCss('
.bdy-content{margin:0 100px;  }
.jumbo{background: url(../assets/themes/ey/images/pages/candidate-profile/cover.jpg) no-repeat fixed; background-size: cover; width: 100%; height: 100%; min-height: 350px; 
       border-bottom:3px solid #eee}
.nav{background: #00a0e3; max-width: 60px; top:15%; left:0%; box-shadow: 0px 0px 35px rgb(0,0,0,.3);}
.min-nav li a{background: #00a0e3; color: #fff; text-align: center; font-size: 25px; padding: 10px 0 ;  }
.min-nav > .nav >.active a{color:#00a0e3 !important; background: #fff !important;}
.min-nav li a:hover {color:#00a0e3; background: #fff; transition:.3s ease-in-out; }
.tooltip{background: transparent;}
.tooltip-inner{background: #00a0e3; font-size: 16px; padding: 10px 10px; min-width: 100px; } 
.tooltip.right .tooltip-arrow {
  top: 50%;
  left: 0;
  margin-top: -6px;
  border-width: 6px 6px 6px 0;
  border-right-color: #00a0e3;
}
.can-name-heading{margin: 0 auto; text-align: center; margin-top: 15px; margin-left: 10px;
                 font-size: 28pt; color: #00a0e3; font-family: lobster;}
.can-user-icon{
    height: 350px;
    width: 150px;
    margin: 0 auto;
    z-index: 9999;
    position: relative;
}
.can-user-icon img{  max-height: 200px; max-width: 200px; margin-top:0px;box-shadow: 0px 0px 25px rgb(0,0,0,.3); }
.about{padding-bottom: 20px; }
.text-right{ text-align: right; }
.head-btns {margin-top:30px; padding:0 0 20px 0; text-align: center;  }
.head-btn1,.head-btn2{ max-width: 200px;} 
.head-btn1 a{  padding: 10px 0px; font-size: 14px; display: flex; justify-content: center;
             border-left: 2px solid #00a0e3; border-right: 2px solid #00a0e3; border-radius: 30px 0px 30px 0px;
             filter:gray; -webkit-filter: grayscale(1);  filter: grayscale(1);  }
.head-btn1 i, .head-btn2 i{font-size: 20px; padding: 0 5px 0 0; text-align: center; justify-content: center;  line-height: 18px !important; }
.head-btn1 a:hover,.head-btn2 a:hover {text-decoration: none; background: #00a0e3; color: #fff; transition: .3s ease-in-out;    
                                            filter:none; -webkit-filter: grayscale(0);}
.head-btn2 a{  padding: 10px 0px; font-size: 14px; display: flex; justify-content: center; 
                border-left: 2px solid #00a0e3; border-right: 2px solid #00a0e3; border-radius: 30px 0px 30px 0px;
                  filter:gray; -webkit-filter: grayscale(1);  filter: grayscale(1); }
.btn-txt{margin-top:0px;}
.btn-txt2{margin-top:0px;}
.personal-info{padding-top: 30px;}
.pi-heading{ font-size: 25px; }

.heading-style{
   font-family: lobster;
   font-size: 28pt;
   text-align: left;
   margin: 15px 5px;
}
.heading-style:before{
   content: "";
   position: absolute;
   width: 0;
   height: 0;
   border-style: solid;
   border-width: 0 0 5px 52px;
   border-color: #f07706;
}
.per-discription{ font-size: 15px; line-height: 20px; text-align: justify;}
.per-det{padding: 0px 40px 0px 10px; margin-top: 0px;
      border-left: 1px solid rgb(238, 238, 238, .4);}
.per-heading{font-size: 20px; font-family:  Open Sans; font-weight: Bold; padding-bottom: 20px;}
.can-name{padding: 0px 0 0 0; font-weight: bold;}
.can-name-fill{padding: 0px 0 0 15px;}
.per-ped{padding-top: 5px}


/*Experience Section*/
.com-mark{ background: #00a0e3;  font-size: 25px; text-align: center; color:#fff; margin-top:55px; border-top-left-radius: 50px; 
           border-bottom-left-radius: 50px; padding: 20px 0 20px 15px;}
.com-line:before{ content: "";
   position: absolute;
   width: 0;
   height: 150%;
   margin: 55px 0 0 10px;
   border-style: solid;
   border-width: 50px 0px 5px 3px;
   border-color: #00a0e3; }
.com-mark-img{ margin: -2px 0 0 20px; background: none;}
.minus-padding{padding-right :0px !important;}
.exp{ background: #ecf1f7; padding: 20px 0 50px 0; box-shadow: 0 0 25px rgb(0,0,0,.3)}
.exp-box1{padding: 5px; margin-top: 30px;}
.exp-time{ padding: 30px; text-align: center; background: #00a0e3; color:#fff;
         box-shadow: inset 0px 0px 15px rgb(0, 0, 0, .1)}
.com-name{font-size: 20px; font-weight: bold; font-family: open sans;}
.com-loc{font-size: 15px; font-weight: bold; font-family: open sans; font-style: oblique;}
.com-time{padding:20px 0; font-size:15px; font-family: open sans;   }
.com-due{font-weight: bold; font-size: 16px;}
.com-t{font-size:13px;}
.time-du{text-transform: uppercase; font-size: 12px; padding-top: 5px; font-style: oblique; font-weight: bold; 
        font-family: open sans;}
.exp-post{padding: 20px; background: #fff; min-height: 191px; }
.post{font-size: 20px; font-family: open sans; text-transform: uppercase; font-weight: bold;}
.role{text-transform: uppercase; font-family: open sans; font-weight: bold; padding:10px; }
.duty{font-size:14px;}

/*education section*/
.edu{padding: 30px 0 50px 0;}
.edubox1{ text-align: center; padding: 20px 0; box-shadow: 0 0 10px rgb(0,0,0,.5); border-radius: 0px 10% ;
         background: #eee; margin-bottom: 20px; border:1px solid #fff;} 
.h-school-name{font-size: 16px; font-family: open sans; padding-top: 10px; font-weight: bold; }
.bord-name{font-size: 16px; font-family: open sans;  font-weight: bold;}
.h-year{font-size: 16px; font-family: open sans; font-weight: bold;}
.edu-icon{font-size: 65px; color: #00a0e3; }
.edu-icon{margin: 0 auto; background:  rgb(255,255,255,.3); border: 1px solid #fff; max-height: 125px; max-width:125px;
         border-radius: 50% }

/*Skills Section*/
.skills{background: #ecf1f7; padding: 30px 0; margin-top:30px; box-shadow: 0 0 25px rgb(0,0,0,.3);   }
.skill-tags{display: inline; padding-top:10px; }
.skill-tags ul li span{color:#333339; font-size:16px; text-transform: uppercase; font-weight: bold; background: none; }
.skill-tags ul{padding-left: 10px;}
.skill-tags ul li{ display: inline; background: rgb(255,255,255,.6); padding: 5px 10px; border-radius: 10px; font-size: 14px; 
                  font-style: oblique; margin: 0 3px;}
.progress , .progress-bar{height: 15px; font-size: 10px; line-height: 15px;}
.progress{margin: 15px 0 0px 0;}
.custom-bg{background: #00a3e0; }
.keyheading, .additionalskills{font-size: 18px; font-family: open sans; font-weight: bold; padding-left: 15px;}
.additionalskills{padding: 15px 0 15px 15px;}
.margin-top-0{margin-top: 0px !important;}
.communication{padding-top:80px;}
.communication-lvl{font-size: 12px; color: #333;}
.communication-lvl span{padding-left:75px; }
.com-prog{margin-top: 10px;}

/*portfolio section*/
.portfolio{padding: 30px 0; background: url("../assets/themes/ey/images/pages/candidate-profile/port-bg-1.jpg") fixed; background-size: cover;}
.lr-padding{padding: 0 15px;}

/*Recommendation section*/
.recom{padding:30px 15px;}
.quote {
    color: rgba(0,0,0,.1);
    text-align: center;
    margin-bottom: 30px;
}

/*    Carousel Fade Transition   */

#fade-quote-carousel.carousel {
  padding-bottom: 60px;
}
#fade-quote-carousel.carousel .carousel-inner .item {
  opacity: 0;
  -webkit-transition-property: opacity;
      -ms-transition-property: opacity;
          transition-property: opacity;
}
#fade-quote-carousel.carousel .carousel-inner .active {
  opacity: 1;
  -webkit-transition-property: opacity;
      -ms-transition-property: opacity;
          transition-property: opacity;
}
#fade-quote-carousel.carousel .carousel-indicators {
  bottom: 10px;
}
#fade-quote-carousel.carousel .carousel-indicators > li {
  background-color: #e84a64;
  border: none;
}
#fade-quote-carousel blockquote {
    text-align: center;
    border: none;
}
#fade-quote-carousel .profile-circle {
    width: 100px;
    height: 100px;
    margin: 0 auto;
    border-radius: 100px;
}

/*blog section*/
.blog{background: #ecf1f7; padding: 30px 0px; box-shadow: 0 0 25px rgb(0,0,0,.3);  }
.blog-box-1{margin-top: 20px; border-radius: 20px }
.blog-cover img{max-height: 300px; width: 100%; border-radius: 20px 20px 0 0;}
.blog-details{background: #fff; padding: 20px 30px; border-radius:0 0px 20px 20px  }
.blog-name{font-size: 20px; }
.blog-summary{font-size: 15px; text-align: justify;}

/*contact section*/
.contact{padding: 30px 30px; margin-bottom: 30px;}
.c-padding{padding: 20px;}
.contact-btn{text-align: center; }
.contact-btn a{border:1px solid #00a0e3;padding: 10px 20px; background: #00a0e3; color:#fff; text-transform: uppercase; 
                letter-spacing: .5px;}
.contact-btn a:hover{border:1px solid #ff7803; background: #ff7803; color:#fff; transition: .3s ease-in-out; 
      text-decoration:none;  }
.textarea{resize: none;}
@media (min-width:992px) and (max-width:1100px){
    .head-btn1 i, .head-btn2 i{display:none;}
    .head-btn1,.head-btn2{ max-width: 150px;} 
    .can-user-icon img{margin-left: 0px;}
    .head-btn1 a, .head-btn2 a{ padding-left: 5px; padding-right: 5px;}
}
@media screen and (max-width:992px){
    
    .can-name-heading{margin-top: 0px; margin-left: -30px;}
    .head-btn11{margin-top:20px; }
    /*.btn-txt, .btn-txt2{display:none;}*/
    .head-btn1 a, .head-btn2 a{text-align: center;}
    .bdy-content{margin:0 50px 0 100px; }
    .can-user-icon img{margin-left: 20px;}
    .per-det{border: none; padding: 0 0 0 0;}
    .per{padding-top: 20px;}
    .com-mark{display: none;}
}

@-webkit-keyframes wiggle {
  0% {
    -webkit-transform: rotateZ(5deg);
            transform: rotateZ(2deg);
  }
  50% {
    -webkit-transform: rotateZ(-2deg);
            transform: rotateZ(-2deg);
  }
  100% {
    -webkit-transform: rotateZ(2deg);
            transform: rotateZ(2deg);
  }
}
   .btn
   {
    font-size: 11px;
    float: right;
    margin-bottom: 10px;   
}
.wrap {
  width: 100%;
 margin-top: 40px;
  text-align: center;
}
.social {
  font-size: 3em;
  height: 55px;
  overflow: hidden;
}
.social i {
  position: relative;
  top: 20px;
  margin: 0 10px;
  transition: all 100ms cubic-bezier(0.42, 0, 0.58, 1);
}
.social i:hover {
  top: 5px;
}

.fb {
  color: #3B5998;
}

.tw {
  color: #09AEEC;
}

.yt {
  color: #AA2A25;
}

.lk {
  color: #0077B5;
}

.sk {
  color: #00A5E6;
}

.db {
  color: #000;
}

.apple {
  color: #ccc;
}

.gallary .fa.fa-plus {
    height: 30px;
	width: 30px;
	border: 1px solid #FCAC45;
	font-size: 20px;
	padding: 5px;
	border-radius: 50%;
	color: #FCAC45;
}
.gallary ul {
	padding: 10px 0;
}
.gallary ul li {
	display: inline-block;
	margin-top: 10px;
}
.gallary ol li {
	display: inline-block;
	margin-left: 20px;
}
.gallary ol li:last-child a:after {
	content: "";
}
.gallary ol li a {
	color: #00a0e3;
        font-size: 18px;
        font-weight: 500;
        border: 1px solid #00a0e3;
        padding: 5px 10px;
        background: #00a0e3;
        color:#fff;
        border-radius: 15px;
}
.gallary ol li a:hover{
    text-decoration: none;
    color: #fff;
    background: #ff7803;
    border: 1px solid #ff7803;       
}
.gallary ol li a.active {
        color: #ff7803;
        text-decoration: none;
         border: 1px solid #ff7803;
         background: #ff7803;
         color: #fff;
}
.gallary .gallary-item {
    margin-bottom: 20px !important;
    display: block;
    position: relative;
    margin: 0 auto;
    max-width: 400px;
}
.gallary .gallary-item img{
    max-width: 300px;
    max-height: 250px;
}
.gallary .gallary-item .hover-bg {
	overflow: hidden;
	position: relative;
}
.gallary .hover-bg .hover-text {
	position: absolute;
	text-align: center;
	margin: 0 auto;
	color: #ffffff;
	background: rgba(0, 0, 0, 0.66);
	padding: 25% 0;
	height: 100%;
	width: 100%;
	opacity: 0;
	transition: all 0.5s;
}
.gallary .hover-bg .hover-text>h4 {
	opacity: 0;
	-webkit-transform: translateY(100%);
	transform: translateY(100%);
	transition: all 0.3s;
}

.gallary .hover-bg:hover .hover-text>h4 {
	opacity: 1;
	-webkit-backface-visibility: hidden;
	-webkit-transform: translateY(0);
	transform: translateY(0);
}
.gallary .hover-bg .hover-text>i {
	opacity: 0;
	-webkit-transform: translateY(0);
	transform: translateY(0);
	transition: all 0.3s;
}
.gallary .hover-bg:hover .hover-text>i {
	opacity: 1;
	-webkit-backface-visibility: hidden;
	-webkit-transform: translateY(100%);
	transform: translateY(100%);
}
.isotope-item { 
    z-index: 2;
}
.isotope-hidden.isotope-item { 
	z-index: 1;
}
.isotope,
.isotope .isotope-item {
    -webkit-transition-duration: 0.8s;
    -moz-transition-duration: 0.8s;
    transition-duration: 0.8s;
}
.isotope-item {
    margin-right: -1px;
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
}
.isotope {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition-property: height, width;
    -moz-transition-property: height, width;
    transition-property: height, width;
}
.isotope .isotope-item {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition-property: -webkit-transform, opacity;
    -moz-transition-property: -moz-transform, opacity;
    transition-property: transform, opacity;
}

@media (max-width: 767px) {
    .isotope {
        height: auto !important;
    }
    .isotope-item {
    	text-align: center;
    	transform: none !important;
    	position: relative !important;
    }
}
.progress-bar .percent{
    display:none;
}
.popover
{background-color:white;padding-bottom:10px;position:absolute;z-index:2000;border-radius:5px;-webkit-box-shadow:0 0 0 1px rgba(0,0,0,0.05),0 2px 4px 0 rgba(0,0,0,0.2);box-shadow:0 0 0 1px rgba(0,0,0,0.05),0 2px 4px 0 rgba(0,0,0,0.2);-webkit-transition:opacity 0.3s ease-in-out;transition:opacity 0.3s ease-in-out}.popover .arrow{width:0;height:0;position:absolute;top:-10px;border-left:10px solid transparent;border-right:10px solid transparent;border-bottom:10px solid rgba(0,0,0,0.08)}.popover 
.arrow:before
{
    width:0;height:0;position:absolute;top:1px;left:-9px;border-left:9px solid transparent;border-right:9px solid transparent;border-bottom:9px solid white}.popover.above>.arrow{top:100% !important;border-top:10px solid rgba(0,0,0,0.08);border-bottom:none}.popover.above>.arrow:before{top:-11px;border-top:9px solid white;border-bottom:none}.popover.onright>.arrow,.popover.onleft>.arrow{border-top:10px solid transparent;border-bottom-color:transparent}.popover.onright>.arrow:before,.popover.onleft>.arrow:before{border-top:9px solid transparent;border-bottom-color:transparent}.popover.onright>.arrow{left:-10px !important;border-right-color:rgba(0,0,0,0.08);border-left:none}.popover.onright>.arrow:before{top:-9px;left:1px;border-right-color:white;border-left:none}.popover.onleft>.arrow{left:100% !important;border-right:none;border-left-color:rgba(0,0,0,0.08)}.popover.onleft>.arrow:before{top:-9px;left:-10px;border-right:none;border-left-color:white}.popover hr{margin:10px 0}.popover .button{display:block;margin-bottom:10px}.popover p:last-child,.popover .button:last-child{margin-bottom:0}.popover.menu a{line-height:32px;font-weight:200;padding:0 25px 0 15px;white-space:nowrap;display:block;text-decoration:none !important;color:#3D474D}.popover.menu a:hover{color:white;background-color:#00AAFF}.popover.sections{padding:10px 0 !important}.popover.sections .title{font-weight:500;color:#A0A9AD;margin:5px 0}.popover.sections .widget-container{padding:0 20px}.popover.sections .widget-container.list-widget{padding:0}.popover.sections .widget-container.list-widget>div{padding-left:20px;padding-right:20px}.popover.sections .image-grid-widget cell{text-align:center;font-size:100%;line-height:100%}.popover.sections .image-grid-widget .item{display:inline-block;padding:2px;border:2px solid transparent;cursor:pointer;background-color:transparent}.popover.sections .image-grid-widget .item.selected{border-color:#00AAFF;background-color:#C7E9FA}.dialog,#overlay{position:fixed;width:100%;height:100%;top:0;bottom:0;left:0;right:0}#overlay{background-color:#EBF0F2;opacity:0.9;z-index:999 !important}.dialog{padding:25px 0;overflow-y:auto}.dialog-wrapper{position:absolute;left:50%;border-radius:10px;-webkit-box-shadow:0 1px 2px 0 rgba(0,0,0,0.2);box-shadow:0 1px 2px 0 rgba(0,0,0,0.2);-webkit-transform:translateX(-50%);transform:translateX(-50%);color:#3D474D;z-index:1000;height:auto;background-color:white}.dialog-wrapper #dlg_flash_msg{padding:20px 20px 20px 45px;background-color:#FFF2B3;color:#806040;font-size:14px;background:#FFF2B3 url(//cdn6.mindmeister.com/assets/meisterlabs/icons/sign-warning-dfef44ddb7e78760a728a8237a20c8faa91be4cce4eada12e673187b39e3f952.svg) no-repeat 15px 22px;background-size:auto 17px;border-radius:10px 10px 0 0;z-index:1;width:100%}.dialog-wrapper #dlg_flash_msg.notice{background-color:#e5f6ff;color:#0077B3;background-image:url(//cdn4.mindmeister.com/assets/meisterlabs/icons/sign-info-ea2bb1e53b1e2624b468743f13f563dd2d34e0389e123dd1022219e4c44c2300.svg)}.dialog-inner{display:inline-block;padding:30px}.dialog.plain .dialog-inner{padding:10px}.dialog_content{position:relative}.dialog_buttons{padding-left:60px;padding-top:20px;text-align:right}.dialog .tabcontent{padding:30px 0 20px 0}.dialog h2{font-size:24px;font-weight:400;margin-bottom:20px}.dialog .help{background-image:url(//cdn3.mindmeister.com/assets/meisterlabs/icons/help-1368861dcca1eba7d3188849088aa9ddad54295ff27f2aff87535c0c4e98008b.svg);background-size:30px 30px}.dialog .tabs{background-color:#F0F5F7;margin:0 -30px;padding:0 30px}.dialog .tabs.grow>*{-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;min-width:0}.dialog .tabs a,.dialog .tabs a:visited{color:#3D474D;padding:10px 0;margin:0 10px;text-decoration:none;border-bottom:4px solid transparent}.dialog .tabs a.selected,.dialog .tabs a:visited.selected{color:#00AAFF;border-color:#00AAFF}.dialogheader{margin-bottom:20px;-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start;display:-webkit-box;display:-ms-flexbox;display:flex}.dialogheader.no-description{-webkit-box-align:center;-ms-flex-align:center;align-items:center}.dialogheader .icon-left{width:48px;height:48px;-ms-flex-negative:0;flex-shrink:0;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;border-radius:100%;border:1px solid #dfe4e6;-ms-flex-item-align:start;align-self:flex-start}.dialogheader .header{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-flex:1;-ms-flex-positive:1;flex-grow:1;padding-left:15px;padding-right:15px}.dialogheader .header.no-right-side-icons{padding-right:0px}.dialogheader .headline{font-size:22px;color:#3D474D;font-weight:500;line-height:30px;margin-bottom:0}.dialogheader .description{font-size:15px;color:#A0A9AD;font-weight:400;line-height:22px;margin-bottom:0}.dialogheader .right-side-icons{height:30px;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.dialogheader .icon-right{color:#8A9499}.ui-badge{text-align:center;width:107px;height:107px;background-image:url(//cdn3.mindmeister.com/assets/meisterlabs/graphics/badge-blue-dbc9af009752e6dd902801945d096ab189ab7aef8d06629d59abe7a758a93c9b.svg);position:absolute;top:-2px;right:-2px}.ui-badge.orange{background-image:url(//cdn2.mindmeister.com/assets/meisterlabs/graphics/badge-orange-2139f38330eca9615f89a91b88e2dd1631c5e0cd17771e575bb4469ddc4a7df6.svg)}.ui-badge p{color:white !important;position:absolute;bottom:22px;left:50%;-webkit-transform:rotate(45deg) translateX(-50%);transform:rotate(45deg) translateX(-50%);font-weight:600;font-size:15px;line-height:1;text-align:center;width:100%}.bg-black{background-color:#000}.bg-grey-light{background-color:#8A9499}.bg-grey-lighter{background-color:#A0A9AD}.bg-yellow{background-color:#fff6cc}.bg-red{background-color:#FF531A}.c-blue,.c-pro{color:#00AAFF}.c-orange,.c-personal{color:#FF9F1A}.c-basic,.c-business{color:#8A9499}.c-edu_pro,.c-edu_personal,.c-academic{color:#41D9D9}.bc-grey-lighter{border-color:#A0A9AD !important}.bc-white{border-color:white !important}@media only screen and (min-width: 769px){.h-hidden-above-tablet{display:none !important}}@media only screen and (max-width: 768px){.h-hidden-tablet{display:none !important}.h-show-tablet{display:inline-block !important}div.h-responsive-tablet>div,row.h-responsive-tablet>cell{width:100% !important;max-width:none;min-width:0px;display:block}.into-middle-tablet{text-align:center !important}}@media (max-width: 680px){.h-hidden-phone{display:none !important}.h-show-phone{display:inline-block !important}div.h-responsive>div,row.h-responsive>cell,grid.h-responsive>cell{width:100% !important;max-width:none;min-width:0px;display:block}row.w-auto.h-responsive{width:100%}.justify-center-phone{-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center}.into-middle-phone{text-align:center !important}.into-left-phone{text-align:left !important}.ph-0-phone{padding-left:0 !important;padding-right:0 !important}}.bs-small{-webkit-box-shadow:0 1px 2px 0 rgba(0,0,0,0.2);box-shadow:0 1px 2px 0 rgba(0,0,0,0.2)}.bs-medium{-webkit-box-shadow:0 1px 3px 0 rgba(0,0,0,0.2);box-shadow:0 1px 3px 0 rgba(0,0,0,0.2)}.bs-large{-webkit-box-shadow:0 1px 20px 0 rgba(0,0,0,0.05);box-shadow:0 1px 20px 0 rgba(0,0,0,0.05)}.box-style{border:1px solid rgba(0,0,0,0.1);-webkit-box-shadow:0 1px 3px 0 rgba(0,0,0,0.05);box-shadow:0 1px 3px 0 rgba(0,0,0,0.05)}.h-h-center-relative{position:relative;left:50%;-webkit-transform:translate(-50%, 0);transform:translate(-50%, 0)}.h-hover-bg:hover{background-color:#F0F5F7}.ellipsis{display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.hyphenation{-ms-word-break:break-all;word-break:break-word;-webkit-hyphens:auto;-ms-hyphens:auto;hyphens:auto}.tag{border-radius:3px;padding:0 6px;font-weight:500;font-style:normal;font-size:10px;line-height:18px !important;color:white;display:inline-block;text-decoration:none;vertical-align:middle}.sr-only{position:absolute;width:1px;height:1px;padding:0;overflow:hidden;clip:rect(0, 0, 0, 0);white-space:nowrap;-webkit-clip-path:inset(50%);clip-path:inset(50%);border:0}
 .KR .h-iblock, .KR .h-iblock\* *, .KR .h-iblock\>\*>*, .KR .h-show-hidden .h-iblock.h-hidden {
    display: inline-block;
}
.KR .pb-20 {
    padding-bottom: 20px;
}
.personal-avatar {
    z-index: 100;
    max-width: 175px;
    width: 100%;
    position: absolute;
    bottom: -106px;
    left: 0;
}
* {
    -webkit-tap-highlight-color: transparent;
}
* {
    margin: 0;
    padding: 0;
    background-repeat: no-repeat;
}
.ta-center {
    text-align: center;
}
.bg-white {
    color: #3d474d;
}
body {
    background-color: white;
    font-family: Avenir, "Segoe UI", Helvetica, Arial, sans-serif;
    color: #3D474D;
    font-size: 14px;
    line-height: 140%;
}
.personal-avatar .image-upload {
    position: relative;
    padding: 11px;
    display: inline-block;
    border: 1px solid #CED5D9;
    line-height: 0;
    border-radius: 50%;
    background-color: #fff;
}
.h-cp {
    cursor: pointer;
}
.rad-100\% {
    border-radius: 100%;
}
* {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}
* {
    margin: 0;
    padding: 0;
    background-repeat: no-repeat;
}
.ta-center {
    text-align: center;
}
.bg-white {
    color: #3d474d;
}
.personal-avatar .i-avatar {
    width: 150px;
    height: 150px;
    border-radius: 100%;
}
.image-upload img {
    background: white;
}
.i-avatar {
    width: 28px;
    height: 28px;
    display: inline-block;
    overflow: hidden;
    padding: 0 !important;
    background-size: cover;
    background-color: #EBF0F2;
    border-radius: 100%;
}
.personal-avatar .opener {
    position: absolute;
    right: -12px;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
    height: 24px;
    width: 24px;
    text-align: center;
    padding-top: 2px;
    color: #8d8d8d;
    font-size: 12px;
    border-radius: 100%;
    border: 1px solid #CED5D9;
    background-color: white;
//    background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iOHB4IiBoZWlnaHQ9IjRweCIgdmlld0Jve…RoIGQ9Ik00MywxMiBMNDcsMTYgTDUxLDEyIEw0MywxMiBaIj48L3BhdGg+PC9nPjwvc3ZnPg==);
    background-position: center center;
    background-size: 8px 4px;
}
a {
    color: #00AAFF;
}
h1, h2, h3, h4, h5, p, span, a {
    line-height: 140%;
}
element.style {
    opacity: 0;
    left: 335.5px;
    top: 164px;
    display: none;
}
.popover {
    background-color: white;
    padding-bottom: 10px;
    position: absolute;
    text-align: center;
    z-index: 2000;
    border-radius: 5px;
    -webkit-box-shadow: 0 0 0 1px rgba(0,0,0,0.05), 0 2px 4px 0 rgba(0,0,0,0.2);
    box-shadow: 0 0 0 1px rgba(0,0,0,0.05), 0 2px 4px 0 rgba(0,0,0,0.2);
    -webkit-transition: opacity 0.3s ease-in-out;
    transition: opacity 0.3s ease-in-out;
}
.avatar_image{
    display:none !important;
}
#f-img{
    display:none;
    position:absolute;
}
.edit
    {
        float:left;
        /*background:url(https://devdojo.com/go/examples/jquery-easy-editable-text-fields/images/edit.png) no-repeat;*/
        /*background:<i class="far fa-edit"></i> no-repeat;*/
        width:32px;
        height:32px;
        display:block;
        cursor: pointer;
        margin-left:10px;
    }
    input[type=text]
    {
        margin-top:8px;
        font-size:18px;
        color:#545454;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        -border-radius: 2px;
        width:280px;

    }
    .control-group {
    display: inline-block;
    vertical-align: top;
    background: #fff;
    text-align: left;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    padding: 30px;
    margin: 10px;
        margin-bottom: 10px;
}
');

$script = <<< JS
            
var prv_img = $('#avatar_img_tag').attr('src');
            
$('[data-toggle="tooltip"]').tooltip();
var objectPositionTop = $('#skills').offset().top;
$(window).on('scroll', function () {
//    console.log(objectPositionTop);
    var currentPosition = $(document).scrollTop();
    if (currentPosition >= objectPositionTop) {
        $('.progress .progress-bar').css("width",
            function () {
                return $(this).attr("aria-valuenow") + "%";
            }
        )

    }
});

var container = $('.animate-grid .gallary-thumbs');
container.isotope({
    filter: '*',
    animationOptions: {
        duration: 750,
        easing: 'linear',
        queue: false
    }
});
$('.animate-grid .categories a').click(function () {
    $('.animate-grid .categories .active').removeClass('active');
    $(this).addClass('active');
    var selector = $(this).attr('data-filter');
    container.isotope({
        filter: selector,
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    });
    return false;
});        
 $('#btn_avatar_upload').click(function () {
    var readURL = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#avatar_img_tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#upload-input").on('change', function () {
        readURL(this);
    });
//                        $(".upload-button").on('click', function () {
//                            $(".file-upload").click();
    });
    $("#avatar_img_tag").on('load', function () {
        $("#f-img").show();
    });
            
    $(".opener").click(function (ab) {
        ab.preventDefault();
        $('#f-img').hide();
        $("#popover_avatar").show();
    });
    $("#btn_avatar_upload").click(function (bc) {
        bc.preventDefault();
        $("#upload-input").click();
            console.log("click");
//            $("#f-img").show();
            $("#popover_avatar").hide();
    });
    $(".j-hidden").click(function () {
        $("#popover_avatar").hide();
    });
    $(".rem a").click(function () {
        $(".j-hidden").attr('src', '');
    });
    $("#avatar_cancel").click(function(r){
            r.preventDefault();
        $("#f-img").hide();
        $("#avatar_img_tag").attr('src', prv_img);
    })
        $("#btn_avatar_can").click(function(){
		$("#popover_avatar").hide();
	});
            
    $("#btn_avatar_sav").click(function(){
        $("#upload-company-logo").submit();
    });
            
    $(document).on('submit', '#upload-company-logo', function(event) {
        event.preventDefault();
        $.ajax({
            url: "/site/upload-company-logo",
            method: "POST",
            data: new FormData(this),
            contentType: false,
            cache:false,
            processData: false,
            success: function (data) {
            }
        });
            $("#f-img").hide();
    });

            $(document).on('click', '.modal-load-class', function() {
    $('#modal').modal('show').find('.modal-body').load($(this).attr('value')); 
});
              $(document).ready(function(){
	$('.edit').click(function(){
		$(this).hide();
		$(this).prev().hide();
		$(this).next().show();
		$(this).next().select();
	});
	$('input[type="text"]').blur(function() {  
         if ($.trim(this.value) == ''){  
			 this.value = (this.defaultValue ? this.defaultValue : '');  
		 }
		 else{
			 $(this).prev().prev().html(this.value);
		 }
		 $(this).hide();
		 $(this).prev().show();
		 $(this).prev().prev().show();
     });
	  $('input[type="text"]').keypress(function(event) {
		  if (event.keyCode == '13') {
			  if ($.trim(this.value) == ''){  
				 this.value = (this.defaultValue ? this.defaultValue : '');  
			 }
			 else
			 {
				 $(this).prev().prev().html(this.value);
			 }
			 
			 $(this).hide();
			 $(this).prev().show();
			 $(this).prev().prev().show();
		  }
	  });
		  
});
//$('#gg').Tabledit({
//    url: 'example.php',
//    deleteButton: false,
//    saveButton: false,
//    autoFocus: false,
//    buttons: {
//        edit: {
//            class: 'btn btn-sm btn-primary',
//            html: '<span class="glyphicon glyphicon-pencil"></span> &nbsp EDIT',
//            action: 'edit'
//        }
//    },
//    columns: {
////        identifier: [0, 'id'],
////        editable: [[1, 'car'], [2, 'color']]
//    }
//});   
        
        
        
        
        
//    $.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#username').editable(); 
       
$('#note').editable();         
        
 $.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#nation').editable();
        
 $.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#sky').editable();
        
$('#sex').editable({
        prepend: "not selected",
        source: [
            {value: 1, text: 'Male'},
            {value: 2, text: 'Female'}
        ],
        display: function(value, sourceData) {
             var colors = {"": "gray", 1: "green", 2: "blue"},
                 elem = $.grep(sourceData, function(o){return o.value == value;});
             if(elem.length) {    
                 $(this).text(elem[0].text).css("color", colors[value]); 
             } else {
                 $(this).empty(); 
             }
        }   
    });  
//$.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#dob').editable();        
   
$('#dob').editable();
          
    $('#event').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name'
        }
    });      
    
    $('#meeting_start').editable({
        format: 'yyyy-mm-dd hh:ii',    
        viewformat: 'dd/mm/yyyy hh:ii',
        validate: function(v) {
           if(v && v.getDate() == 10) return 'Day cant be 10!';
        },
        datetimepicker: {
           todayBtn: 'linked',
           weekStart: 1
        }        
    });      
   
        
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#mail').editable();
        
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#company_name1').editable();
        
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#place1').editable();
        
//$.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#from1').editable();
$('#from1').editable();
    $('#event').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name'
        }
    });      
    $('#meeting_start').editable({
        format: 'yyyy-mm-dd hh:ii',    
        viewformat: 'dd/mm/yyyy hh:ii',
        validate: function(v) {
           if(v && v.getDate() == 10) return 'Day cant be 10!';
        },
        datetimepicker: {
           todayBtn: 'linked',
           weekStart: 1
        }        
    });         
//$.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#to1').editable();
        $('#to1').editable();
    $('#event').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name'
        }
    });      
    $('#meeting_start').editable({
        format: 'yyyy-mm-dd hh:ii',    
        viewformat: 'dd/mm/yyyy hh:ii',
        validate: function(v) {
           if(v && v.getDate() == 10) return 'Day cant be 10!';
        },
        datetimepicker: {
           todayBtn: 'linked',
           weekStart: 1
        }        
    });         
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#company_name2').editable();
        
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#place2').editable();
        
//$.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#from2').editable();

$('#from2').editable();
    $('#event').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name'
        }
    });      
    $('#meeting_start').editable({
        format: 'yyyy-mm-dd hh:ii',    
        viewformat: 'dd/mm/yyyy hh:ii',
        validate: function(v) {
           if(v && v.getDate() == 10) return 'Day cant be 10!';
        },
        datetimepicker: {
           todayBtn: 'linked',
           weekStart: 1
        }        
    });            
//$.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#to2').editable();
$('#to2').editable();
    $('#event').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name'
        }
    });      
    $('#meeting_start').editable({
        format: 'yyyy-mm-dd hh:ii',    
        viewformat: 'dd/mm/yyyy hh:ii',
        validate: function(v) {
           if(v && v.getDate() == 10) return 'Day cant be 10!';
        },
        datetimepicker: {
           todayBtn: 'linked',
           weekStart: 1
        }        
    });         
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#company_name3').editable();
        
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#place3').editable();
        
//$.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#from3').editable();
 
$('#from3').editable();
    $('#event').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name'
        }
    });      
    $('#meeting_start').editable({
        format: 'yyyy-mm-dd hh:ii',    
        viewformat: 'dd/mm/yyyy hh:ii',
        validate: function(v) {
           if(v && v.getDate() == 10) return 'Day cant be 10!';
        },
        datetimepicker: {
           todayBtn: 'linked',
           weekStart: 1
        }        
    });            
//$.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#to3').editable();
$('#to3').editable();
    $('#event').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name'
        }
    });      
    $('#meeting_start').editable({
        format: 'yyyy-mm-dd hh:ii',    
        viewformat: 'dd/mm/yyyy hh:ii',
        validate: function(v) {
           if(v && v.getDate() == 10) return 'Day cant be 10!';
        },
        datetimepicker: {
           todayBtn: 'linked',
           weekStart: 1
        }        
    });         
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#dg1').editable();
        
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#un1').editable();
        
//$.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#y1').editable();
$('#y1').editable();
    $('#event').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name'
        }
    });      
    $('#meeting_start').editable({
        format: 'yyyy-mm-dd hh:ii',    
        viewformat: 'dd/mm/yyyy hh:ii',
        validate: function(v) {
           if(v && v.getDate() == 10) return 'Day cant be 10!';
        },
        datetimepicker: {
           todayBtn: 'linked',
           weekStart: 1
        }        
    });         
        
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#dg2').editable();
        
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#un2').editable();
        
//$.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#y2').editable();
$('#y2').editable();
    $('#event').editable({
        placement: 'right',
        combodate: {
            firstItem: 'name'
        }
    });      
    $('#meeting_start').editable({
        format: 'yyyy-mm-dd hh:ii',    
        viewformat: 'dd/mm/yyyy hh:ii',
        validate: function(v) {
           if(v && v.getDate() == 10) return 'Day cant be 10!';
        },
        datetimepicker: {
           todayBtn: 'linked',
           weekStart: 1
        }        
    }); 
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#designation_1').editable();
        
//$.fn.editable.defaults.mode = 'popup';  
//    //make username editable
//    $('#description_1').editable(); 
   
 $('#comments').editable({
        showbuttons: 'bottom'
    });    
  $('#comments_2').editable({
        showbuttons: 'bottom'
    }); 
   $('#comments_3').editable({
        showbuttons: 'bottom'
    });       
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#designation_2').editable();
        
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#description_2').editable(); 
 
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#designation_3').editable();
        
$.fn.editable.defaults.mode = 'popup';  
    //make username editable
    $('#description_3').editable();   

JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/jquery.fancybox.min.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css');
$this->registerCssFile('https://vitalets.github.io/x-editable/demo-bs3.html/assets/select2/select2-bootstrap.css');
$this->registerCssFile('https://vitalets.github.io/x-editable/demo-bs3.html/assets/select2/select2.css');
$this->registerJsFile('@eyAssets/js/jquery.fancybox.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://vitalets.github.io/x-editable/demo-bs3.html/assets/select2/select2.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('@eyAssets/js/candidates-list/modernizr-2.8.3-respond-1.4.2.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@eyAssets/js/jquery.isotope.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('https://code.jquery.com/jquery-2.0.3.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
//$this->registerJsFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

