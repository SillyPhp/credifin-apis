<?php

use yii\helpers\Url;
use yii\helpers\html;
use yii\bootstrap\ActiveForm;

$this->params['header_dark'] = false;

function finalAmount($totalPrice, $gstAmount)
{
    if ($gstAmount) {
        $gstPercent = $gstAmount;
        if ($totalPrice > 0) {
            $gstAmount = round($gstPercent * ($totalPrice / 100), 2);
        }
    }
    $finalPrice = $totalPrice + $gstAmount;
    return (($finalPrice == 0) ? 'Free' : '₹ ' . $finalPrice);
}

function webDate($webDate)
{
    $date = $webDate;
    $sec = strtotime($date);
    $newDate = date('d-M', $sec);
    return $newDate;
}

?>
<section class="header-web">
    <div class="back-shadow"></div>
    <div class="container-fluid">
        <div class="row flex-set">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="header-txt">
                    <h1>Webinars</h1>
                    <h2>Introducing <span class="ornge">EmpowerYouth Masterclass - A Webinar Series</span>
                        Created To Help You Understand And Immerse Yourself In The Latest Career Options.</h2>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="header-img">
                    <img src="<?= Url::to('@eyAssets/images/pages/webinar/web.png') ?>"/>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="upcoming-web">
    <div class="container">
        <div class="row">
            <div class="heading-style">Upcoming Webinars</div>
        </div>
        <div class="row">
            <?php
            if ($upcomingWebinar) {
                foreach ($upcomingWebinar as $web) {
                    ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="web-card">
                            <div class="web-img">
                                <a href="<?= Url::to("/webinar/" . $web['slug']) ?>">
                                    <img src="<?= $web['image'] ?>"></a>
                                <div class="web-date">
                                    <div class="date">
                                        <?php
                                        $eventDate = webDate($web['webinarEvents'][0]['start_datetime']);
                                        echo $eventDate;
                                        ?>
                                    </div>
                                </div>
                                <div class="web-paid">
                                    <?php
                                    $finalPrice = finalAmount($web['price'], $web['gst']);
                                    echo $finalPrice;
                                    ?>
                                </div>
                            </div>
                            <div class="web-inr">
                                <div class="web-title"><a href="<?= Url::to("/webinar/" . $web['slug']) ?>"><?= $web['name'] ?></a></div>
                                <div class="web-speaker">
                                    <span><?= str_replace(',', ', </span><span>', trim($web['speakers'])) ?></span>
                                </div>
                                <div class="web-des"><?= $web['description'] ?></div>
                            </div>
                            <div class="reg-btn-count">
                                <div class="register-count">
                                    <div class="reg-img">
                                        <?php
                                        if (count($web['webinarRegistrations']) > 0) {
                                            $reg = 1;
                                            foreach ($web['webinarRegistrations'] as $uImage) {
                                                if ($uImage['createdBy']['image']) {
                                                    ?>
                                                    <span class="reg<?= $reg ?> reg">
                                        <img src="<?= $uImage['createdBy']['image'] ?>">
                                    </span>
                                                    <?php
                                                    $reg++;
                                                }
                                                if ($reg == 4) {
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <span class="cont"> <?= count($web['webinarRegistrations']) ?> Registered</span>
                                </div>
                                <div class="register-btns">
                                    <a href="<?= Url::to("/webinar/" . $web['slug']) ?>" class="btn-drib"><i
                                                class="icon-drib fa fa-arrow-right"></i> Register Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="how-it-works">
    <div class="container">
        <div class="row">
            <div class="heading-style">How To Join A Webinar</div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="step">
                    <div class="step-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/webinar/icons-registration.png') ?>"/>
                    </div>
                    <div class="step-text">
                        <h3>1. Register</h3>
                        <p>Register for the webinar by simply filling all the required details and clicking on the "Request For a Webinar' button. Once registered, a mail will the join link will be sent to you.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="step">
                    <div class="step-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/webinar/icons-join.png') ?>"/>
                    </div>
                    <div class="step-text">
                        <h3>2. Join</h3>
                        <p>At the time of the webinar, click on the join link sent in the mail. You will be redirected to the webinar detail page. Click on the 'Join Now' button and you will be in the webinar.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="step">
                    <div class="step-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/webinar/icons-watch.png') ?>"/>
                    </div>
                    <div class="step-text">
                        <h3>3. Watch</h3>
                        <p>Once the organiser arrived, the webinar will begin. You can also interact with them before the Live Chat. Enjoy your creative learning!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
if ($optedWebinar) {
    ?>
    <section class="opted-web">
        <div class="container">
            <div class="row">
                <div class="heading-opted">Opted Webinars</div>
            </div>
            <?php
            foreach ($optedWebinar as $opWeb) {
                ?>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="web-card">
                            <div class="web-img">
                                <a href="<?= Url::to("/webinar/" . $opWeb['slug']) ?>"><img
                                            src="<?= $opWeb['image'] ?>"></a>
                                <div class="web-date">
                                    <div class="date">
                                        <?php
                                        $eventDate = webDate($opWeb['webinarEvents'][0]['start_datetime']);
                                        echo $eventDate;
                                        ?>
                                    </div>
                                </div>
                                <div class="web-paid">
                                    <?php
                                    $finalPrice = finalAmount($opWeb['price'], $opWeb['gst']);
                                    echo $finalPrice;
                                    ?>
                                </div>
                            </div>
                            <div class="web-inr">
                                <div class="web-title"><a
                                            href="<?= Url::to("/webinar/" . $opWeb['slug']) ?>"> <?= $opWeb['name'] ?> </a>
                                </div>
                                <div class="web-speaker">
                                    <span><?= str_replace(',', ', </span><span>', trim($opWeb['speakers'])) ?></span></span>
                                </div>
                                <div class="web-des"><?= $opWeb['description'] ?></div>
                            </div>
                            <div class="reg-btn-count">
                                <div class="register-count">
                                    <div class="reg-img">
                                        <?php
                                        if (count($opWeb['webinarRegistrations']) > 0) {
                                            $reg = 1;
                                            foreach ($opWeb['webinarRegistrations'] as $uImage) {
                                                ?>
                                                <span class="reg<?= $reg ?> reg">
                                                        <img src="<?= $uImage['createdBy']['image'] ?>">
                                                    </span>
                                                <?php
                                                $reg++;
                                                if ($reg == 4) {
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <span class="cont"><?= count($opWeb['webinarRegistrations']) ?> Registered</span>
                                </div>
                                <!--                        <div class="register-btns">-->
                                <!--                            <a class="btn-drib"><i class="icon-drib fa fa-arrow-right"></i> Register Now</a>-->
                                <!--                        </div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section>
    <?php
}
?>

<section class="past-web">
    <div class="container">
        <div class="row">
            <div class="heading-style">Past Webinars</div>
        </div>
        <div class="row">
            <?php
            foreach ($pastWebinar as $pWeb) {
                $date = array();
                foreach ($pWeb['webinarEvents'] as $key => $row)
                {
                    $date[$key] = $row['start_datetime'];
                }
                array_multisort($date, SORT_DESC, $pWeb['webinarEvents']);
                ?>
                <div class="col-md-4 col-sm-6">
                    <div class="web-card">
                        <div class="web-img">
                            <a href="<?= Url::to("/webinar/" . $pWeb['slug']) ?>">
                                <img src="<?= $pWeb['image'] ?>">
                            </a>
                            <div class="web-date">
                                <div class="date">
                                    <?php
                                    $eventDate = webDate($pWeb['webinarEvents'][0]['start_datetime']);
                                    echo $eventDate;
                                    ?>
                                </div>
                            </div>
                            <div class="web-paid">
                                <?php
                                $totalPrice = $pWeb['price'];
                                $gstAmount = 0;
                                if ($pWeb['gst']) {
                                    $gstPercent = $pWeb['gst'];
                                    if ($totalPrice > 0) {
                                        $gstAmount = round($gstPercent * ($totalPrice / 100), 2);
                                    }
                                }
                                $finalPrice = $totalPrice + $gstAmount;
                                ?>
                                <?= (($finalPrice == 0) ? 'Free' : '₹ ' . $finalPrice) ?>
                            </div>
                        </div>
                        <div class="web-inr">
                            <div class="web-title"><a href="<?= Url::to("/webinar/" . $pWeb['slug']) ?>">
                                    <?= $pWeb['name'] ?></a></div>
                            <div class="web-speaker">
                                <span><?= str_replace(',', ', </span><span>', trim($pWeb['speakers'])) ?></span></div>
                            <div class="web-des"><?= $pWeb['description'] ?></div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<section class="webinar-on-device">
    <div class="container">
        <div class="row">
            <h1 class="heading-style">Engage from anywhere on any device</h1>
        </div>
        <div class="row steps">
            <div class="col-sm-4">
                <div class="icon">
                    <div class="icon-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/webinar/icon-computer.png'); ?>">
                    </div>
                    On your Desktop
                </div>
            </div>
            <div class="col-sm-4">
                <div class="icon">
                    <div class="icon-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/webinar/icon-smartphone.png'); ?>">
                    </div>
                    On your Smartphone
                </div>
            </div>
            <div class="col-sm-4">
                <div class="icon">
                    <div class="icon-img">
                        <img src="<?= Url::to('@eyAssets/images/pages/webinar/icon-tablet.png'); ?>">
                    </div>
                    On your Tablet
                </div>
            </div>
        </div>
    </div>
</section>

<section class="speakers">
    <div class="container">
        <div class="row">
            <div class="heading-style">Webinars Speaker</div>
        </div>
        <div class="row">
            <div class="loader_screen">
                <img src="<?= Url::to('@eyAssets/images/loader/91.gif'); ?>" class="img_load">
            </div>
            <div id="speakers_card">

            </div>
            <div class="align_btn">
                <button id="loader" class="btn btn-success">View More</button>
            </div>
        </div>
    </div>
</section>

<section class="req-form">
    <div style="display: flex;flex-wrap: wrap; ">
        <div class="col-md-5 col-sm-12 req-web">
            <div class="req">
                <h1>Request For A Webinar</h1>
                <p>- For Enriching Your Organization's Online Content.</p>
                <p>- Establishing Authority.</p>
                <p>- Enhanced Branding Value.</p>
                <p>- Building Trust.</p>
                <p>- Building Stronger, Lasting Business Relationships.</p>
                <p>- Accessing The Global Audience.</p>
                <p>- Sharing Information with the Audience.</p>
            </div>
            <div class="req-icon">
                <img src="<?= Url::to('@eyAssets/images/pages/webinar/r-webi.png') ?>"/>
            </div>
        </div>
        <div class="col-md-7 col-sm-12 col-xs-12" style="background-color: #fff;padding: 30px 20px;">
            <?php $form = ActiveForm::begin([
                'id'=>'requestWebForm'
            ])
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="web-form">
                        <label for="title">Topic</label>
                        <?= $form->field($model,'topic')->textInput(['class' => 'form-control', 'id' => 'topic', 'placeholder' => ''])->label(false)?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="web-form">
                        <label for="date">Date</label>
                        <?= $form->field($model,'date')->textInput(['class' => 'form-control datepicker', 'id' => 'date', 'placeholder' => ''])->label(false)?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="web-form">
                        <label for="seats">Seats</label>
                       <?= $form->field($model,'seats')->textInput(['class' => 'form-control', 'id' => 'seats', 'placeholder' => ''])->label(false)?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="web-form">
                        <label for="speakers">Speakers</label>
                        <div class="load-suggestions">
                            <span></span><span></span><span></span>
                        </div>
                        <?= $form->field($model,'speakers[]',['template' => '{input}{error}'])->textInput(['class' => 'form-control typeahead', 'id' => 'speakers', 'placeholder' => ''])->label(false)?>
                        <div class="pf-field no-margin">
                            <ul class="tags languages_tag_list">
                                <li class="tagAdd taglist"></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt10">
                    <div class="web-form">
                        <label for="objectives">Objectives</label><br>
                       <?= $form->field($model,'objective')->textArea(['rows'=> 6, 'cols'=> 20,'class' => 'form-control', 'id' => 'objective', 'placeholder' => ''])->label(false)?>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <?= Html::submitButton('Submit Request', ['class' => 'sub-btn gnt-btn']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
</section>

<?php
echo $this->render('/widgets/mustache/speakers-card');
$this->registerCss("
.how-it-works .step {
    text-align: center;
    background-color: #fff;
    padding: 20px;
    transition: 0.3s ease-in;
}
.how-it-works{
    margin-bottom: 20px;
}
.how-it-works .step-text h3 {
    font-size: 20px;
    font-family: lora;
    font-weight: 600;
    color: #000;
    letter-spacing: 0.3px;
    margin: 20px 0;
}
.how-it-works .step-text p {
    font-size: 16px;
    font-family: roboto;
    color: #717171;
    letter-spacing: 0.3px;
    line-height: 24px;
}
.how-it-works .step:hover {
    box-shadow: 0 2px 12px rgb(0 0 0 / 20%);
}
.step-img img{
    width: 60px;
}
.icon-img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    background: #204E8445;
    margin-bottom: 10px;
}
.icon-img img {
    width: 30px;
}
.icon {
    color: #494949;
    font-weight: 600;
    width: fit-content;
    margin: auto;
    font-size: 18px;
}
.steps{
    margin: 50px 0;
}
.step{
    min-height: 300px;
    margin-bottom: 10px;
}
.icon{
    margin-bottom: 40px;
}
.how-it-works{
    background:#fcfcfc;
    margin-bottom: 20px;
    padding-bottom: 20px;
}
.flex-set{
    display:flex;
    align-items: center;
    flex-wrap: wrap;
}
.header-txt {
    padding-left: 35px;
}
.sub-btn {
    background: #00a0e3;
    color: #fff;
    padding: 10px 15px;
    border: 1px solid #00a0e3;
    font-size: 14px;
    text-transform: uppercase;
    transition: all .3s;
    font-family:roboto;
    font-weight: 500;
    border-radius: 4px;
}
.sub-btn:hover{
    background: #fff;
    color: #00a0e3;
}
.has-success .form-control{
    border-color: unset;
}
.taglist{
    float:left !important;
}
.btn_remove_picture{
    margin-left:5px;
}
.mt10{
    margin-top: 10px;
}
.cat_wrapper .Typeahead-spinner{
    position: absolute;
    right: 8px;
    top: 18px;
    font-size: 22px;
    display:none;
}
.twitter-typeahead input{
    padding-right:35px !important;
}
.social-edit > form{
    padding-left:0px;
}
.add_loader{
background-color: #ffffff;
background-image: url('http://loadinggif.com/images/image-selection/3.gif');
background-size: 25px 25px;
background-position:right center;
background-repeat: no-repeat;
}
.fb i{
    color:#3b5998 !important;
}
.twitter i{
    color:#1DA1F2 !important;
}
.gplus i{ 
    color:#CC3333 !important;
}
.linkedin i{
    color:#0077B5 !important;
}
.wrapper-bg{
    background:url(' . Url::to('@eyAssets/images/pages/index2/get-hired-bg.jpg') . ');
}
.skill-input{
    position: relative;
    vertical-align: top;
    background-color: transparent;
    padding: 15px 10px !important;
    font-size: 15px;
    border-radius: 7px;
}
.lang-input{
    margin-top: 0px !important;    
}
.help-block{
    font-weight: 500 !important;
    font-size: 14px;
    margin-bottom: 30px;
    line-height: 15px;
}
.tags > .addedTag{
    margin-bottom:10px;
}
.pf-title{
    margin-bottom: 5px;
    font-weight:bold;
}
.profile-title > h3{
    margin-top:0px;
}
.chosen-container .chosen-drop {
    background:#fff !important;
}
.highlighted{
    color:#00a0e3 !important;
}
/*-----------------*/
.tags li{
    display: inline-block;
}
.tags > .addedTag{
    background: #00a0e3;
    color: #fff;
    padding: 5px 10px;
    position: relative;
    margin-right: 15px; 
}
.tags > .addedTag > span{
    background: #fff;
    position: absolute;
    top: -11px;
    right: -8px;
    height: auto;
    color: #000;
    padding: 0px 5px;
    border: 1px solid #00a0e3;
    border-radius: 50%;
    display: block;
    line-height: 18px;
    font-size: 12px;
}
.tags > .addedTag > span:hover{
    cursor: pointer;
    color: #00a0e3;
}
.typeahead,.tt-query{
  width: 396px;
  height: 30px;
  padding: 8px 12px;
  font-size: 18px;
  line-height: 30px;
  border: 2px solid #ccc;
  -webkit-border-radius: 8px;
     -moz-border-radius: 8px;
          border-radius: 8px;
  outline: none;
}
.form-wizard .steps>li.done>a.step .number {
    background-color: #ffac64 !important;
    color: #fff;
}
.typeahead {
  background-color: #fff;
}
//.typeahead:focus {
//  border: 2px solid #0097cf;
//}
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
.twitter-typeahead{
width:100%;
}

.form-control.tt-hint {
  color: #999;
  opacity: 0 !important;
}
.tt-menu {
    width: 100%;
    margin: 12px 0;
    padding: 8px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
    max-height:158px;
    overflow-y:auto;
    margin-top: 0px;
}
.tt-suggestion {
    padding: 3px 20px;
    font-size: 14px;
    line-height: 24px;
}
.tt-suggestion:hover {
    cursor: pointer;
    color: #fff;
    background-color: #0097cf;
}
.tt-suggestion.tt-cursor {
    color: #fff;
    background-color: #0097cf !important;
}
.tt-suggestion p {
    margin: 0;
}
.custom_label{
   font-size: 13px !important;
   font-weight: 100 !important;
}
.padding-left{
    margin-top:20px;
}
.set-overlay{
    background-color: #ffffffd9;
    padding: 15px 30px 40px 30px;
    box-shadow: 0px 0px 16px 6px rgba(179, 179, 179, 0.1);
    border-radius: 6px;
}
input[type=radio] + label::after{
    border: 3px solid #00a0e3;
}
.btn_pink{
float: right;
    background: #ffffff;
    border: 2px solid #00a0e3;
    color: #00a0e3;
    font-size: 15px;
    padding: 12px 30px;
    -webkit-border-radius: 8px;
    -moz-border-radius: 8px;
    -ms-border-radius: 8px;
    -o-border-radius: 8px;
    border-radius: 8px;
    margin-top: 10px;
    letter-spacing: 0px;
}
.btn_pink:hover{
    background:#00a0e3;
color:#fff;
}
.tg-fileinput{
    display:none !important;  
}  
.tg-fileuploadlabel::before{
    border:none !important;
}
.tg-fileuploadlabel{
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    padding: 0;
    padding-top: 150px;
}
.tg-fileuploadlabel span i{
    background-color: #fff;
    color: #000;
    box-shadow: 0px 0px 10px 1px #bbb;
    width: 30px;
    height: 30px;
    line-height: 30px;
}
.tg-btn{
    display: block !important;
    color: #ff7803 !important;
    position: relative;
    text-align: center;
    border-radius: 8px;
    display: inline-block;
    vertical-align: middle;
    text-transform: capitalize;
    background: rgba(0,0,0,0.00);
    padding:10px 0 0 0 ;
    font-weight: 500;
    cursor: pointer;
    font-size:15px;
    width: 150px !important;
   height: 45px;
    border: 2px solid #ff7803;
}
.view_profile_btn
{
    padding: 4px 12px;
    margin-top: 3px;
    background: #ffffff !important;
    border: 1px solid #ff7803 !important;
    color: #ff7803 !important;
    border-radius: 4px;
    font-size: 13px;
}
.tg-btn:hover{
color: #fff !important;
    background:#ff7803;
}
.has-error .form-control {
    border: 2px solid #e73d4a !important;
    }
#picture_submit{
    margin-top:0px;
    float:left;
}    
.label_element{
    font-weight:100;
    font-size:15px;
}
.pf-field > input{
    height:56px;
}
.pf-field{
    margin-top: -14px;
}  
#dob{
    background-color: #fff;
}
.skill_wrapper,.language_wrapper{position:relative;}
.skill_wrapper .Typeahead-spinner,.language_wrapper .Typeahead-spinner{
    position: absolute;
    right: 5px;
    top: 13px;
    z-index: 9;
    display:none;
}
.footer{
    margin-top: 0px !important;
}
.ornge {
    color: #00a0e3;
    font-weight:500;
}
.speakers{
    padding-bottom: 50px; 
}
.align_btn{
    text-align: center;
}
.align_btn button{
    background: #00a0e3;
    color: #fff;
    text-transform: capitalize;
    font-size: 16px;
    padding: 7px 15px;
    border: 1px solid #00a0e3;
}
.align_btn button:hover{
    background: #fff;
    color: #00a0e3;
    transition: .3s ease;
    border-color: #00a0e3;
}
.web-card:hover {
	box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
	transform: translateY(-3px);
	transition: all .2s;
}
.header-web {
    background-color: #E8F6EF;
    position: relative;
    overflow: hidden;
    min-height: 500px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.back-shadow {
    position: absolute;
    top: -22%;
    right: 0;
    width: 50%;
    background-color: #00a0e3;
    height: 144%;
    border-radius: 50% 0 0 50%;
}
.header-txt h1 {
    font-size: 44px;
    font-family: roboto;
    font-weight: 700;
    margin-top: 0px;
    color: #00a0e3;
    margin-bottom: 0;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}
.header-txt h2 {
    font-size: 20px;
    font-family: roboto;
    margin: 0 0 0 8px;
    color: #707070;
    font-weight: 500;
    text-transform: capitalize;
}
.header-img {
    width: 350px;
    margin: auto;
}
.web-form{
    margin: -9px 0px 0px 2px;
}
.web-form label{
    font-size: 18px;
    font-family: roboto;
    font-weight: 400;
    color: #333;
    margin-bottom: 6px;
}
.web-form input,
.web-form textarea{
     border: 1px solid #d4caca;
     padding: 6px;
     border-radius: 4px;
     width: 100%;
     height:40px;
     line-height:22px !important;
     margin-bottom: 10px;
}
.web-form textarea{
    margin-bottom: 10px;
    height: 100px;
}
.web-button{
    text-align:center;  
}
.web-button button{
    font-family: roboto;
    font-size: 16px;
    padding: 12px 21px;
    border-radius: 4px;
    border:none;
    background-color: #fff;
    color: #000;
    transition:all .3s;
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    margin-top: 20px;
    border: 1px solid #d4caca;
}
.web-button button:hover{
    box-shadow: 2px 4px 17px rgba(221, 216, 216, 0.8);
    background-color: #00a0e3;
    color: #fff;
}
.req-web{
    display: flex;
    background-color: #3e8cf9;
    flex-direction: column;
    justify-content: space-between;
}
.req h1{
    font-size: 36px;
    text-align: center;
    font-family: lobster;
    padding: 20px  0 10px;
    color: #fff;
}
.req p{
    font-size: 16px;
    color: #fff;
    text-align: center;
    font-family: roboto;
    font-weight: 400;
    margin:0 0 5px 0;
}
.req-icon {
    max-width: 350px;
    margin: 0 auto;
}
.web-card {
	border-radius: 6px;
	overflow: hidden;
	box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
	background-color:#fff;
	margin-bottom:20px;
}
.web-img {
	position: relative;
}
.web-img img{
	height: 200px;
	object-fit: cover;
	width: 100%;
}
.web-date {
    position: absolute;
    bottom: 5px;
    right: 67px;
    border-radius: 4px;
    padding: 0px 8px;
    text-align: center;
    border: 2px solid #00a0e3;
    font-weight: 500;
    font-family: roboto;
    background-color: #00a0e3;
    color: #fff;
}
.web-paid {
    position: absolute;
    bottom: 5px;
    right: 10px;
    background-color: #ff7803;
    border: 2px solid #ff7803;
    border-radius: 4px;
    padding: 0px 8px;
    text-align: center;
    text-transform: uppercase;
    font-family: roboto;
    font-weight: 500;
    color: #fff;
}
.web-inr {
	padding: 5px 10px 10px;
}
.web-title{
	font-size: 22px;
	font-family: lora;
	font-weight: 600;
	display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.web-title a{
    color: #333
}

.web-title a:hover{
    color: #00a0e3;
}
.web-speaker {
	font-size: 12px;
	font-family: roboto;
	color: #a49f9f;
	font-weight: 500;
}
.web-des {
	font-family: roboto;
	display: -webkit-box;
	-webkit-line-clamp: 3;
	-webkit-box-orient: vertical;
	overflow: hidden;
	height: 75px;
}
.opted-web {
	background-image: url(" . Url::to('@eyAssets/images/pages/webinar/wb2.png') . "); 
	margin: 0px 0 0;
	padding: 0 0 50px;
	background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
.heading-opted::after{
	position: absolute;
	left: 0;
	top: 0;
	content: \'\';
	right: 0;
	background-image: url(" . Url::to('@eyAssets/images/pages/webinar/title.png') . ");
	background-repeat: no-repeat;
	background-size: center center;
	background-position: contain;
	width: 70px;
	height: 10px;
	margin: auto auto 0;
	top: auto;
	bottom: 0;
}
.heading-opted {
	text-align: center;
	font-family: lobster;
	/* font-weight: bold; */
	font-size: 40px;
	color: #3b1d82;
	/* text-transform: uppercase; */
	margin-bottom: 35px;
	position: relative;
}
.reg-btn-count {
	display: flex;
	align-items: center;
	justify-content: space-between;
	margin: 0 10px 10px;
}
.register-count {
	font-family: roboto;
	color: #f97364;
	font-weight: 500;
	display: flex;
	align-items: center;
}
.reg img {
    width: 35px;
    border-radius: 81px;
    height: 30px;
    object-fit: cover;
    border: 2px solid #fff;
}
.reg2.reg, .reg3.reg {
    margin-left: -25px;
}
.cont {
    margin-left: 5px;
}
.register-btns:hover .btn-drib{
    color:#fff;
}
.btn-drib:hover .icon-drib{
  animation: bounce 1s infinite;
  color:#fff;
}
.btn-drib {
	border: 1px solid transparent;
	color: #fff;
	text-align: center;
	font-size: 14px;
	border-radius: 5px;
	cursor: pointer;
	padding: 6px 10px;
	background-color: #00a0e3;
	font-family:roboto;
	font-weight:500;
}
.icon-drib {
  margin-right: 5px;
}
.field-speakers span{
    display: block !important;
}
.tt-menu .tt-dataset .suggestion_wrap:nth-child(odd) {
    background-color: #eff1f6;
}
.tt-menu .tt-dataset .suggestion_wrap:nth-child(odd):hover{
    background-color: #00a0e3;
    color:#fff;
}
.suggestion_wrap{
    margin-top: 3px;
    display: flex;
    width: 100%;
    align-items: center;
}
.logo_wrap{
    width: 50px;
    height: 50px;
    margin-right: 10px;
}
.bg_black{
    color: #000;
}
.logo_wrap img{ 
    width:100%;
}
.no_result_found{
    display:inline-block;
}
.no_result_display{
    padding:0px 15px;
}
.no_result_display .add_org{
    border-left: 1px solid #ddd;
    padding: 0px 5px 0px 15px;
}
.no_result_display .add_org a{
    color: #00a0e3;
    font-size: 13px;
}
/*Load Suggestions loader css starts*/
.load-suggestions{
    display:none;
    position: absolute;
    top:10px;
    right: 20px;
    z-index: 999;
}
.load-suggestions span{
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 100%;
  background-color: #3498db;
  margin: 35px 1px;
}
.load-suggestions span:nth-child(1){
  animation: bounce 1s ease-in-out infinite;
}
.load-suggestions span:nth-child(2){
  animation: bounce 1s ease-in-out 0.33s infinite;
}
.load-suggestions span:nth-child(3){
  animation: bounce 1s ease-in-out 0.66s infinite;
}
@keyframes bounce {
  from, 20%, 53%, 80%, to {
    animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
    transform: translate3d(0, 0, 0);
  }
  40%, 43% {
    animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    transform: translate3d(0, -6px, 0);
  }
  70% {
    animation-timing-function: cubic-bezier(0.755, 0.05, 0.855, 0.06);
    transform: translate3d(0, -4px, 0);
  }
  90% {
    transform: translate3d(0, -2px, 0);
  }
}
@media only screen and (max-width: 991px) {
    .header-txt h1{margin-top:40px;}
    .header-txt h2{font-size:18px;}
    .header-img{width:300px;}
}
@media only screen and (max-width: 767px) and (min-width: 300px){
    .header-txt h1{
        font-size: 25px;
        margin-bottom: 0px;
    }
    .header-txt h2{
        font-size: 16px;
        margin-bottom: 25px;
    }
    .header-img{
        width: 200px;
        padding-top: 20px;
    }
    .header-txt {
        padding-left: 0px;
        padding-bottom:30px;
    }
    .back-shadow {
        position: absolute;
        top:inherit;
        bottom: -50%;
        left: -22%;
        width: 140%;
        background-color: #00a0e3;
        height: 100%;
        border-radius: 50% 50% 0 0;
    }
}
");
$script = <<<JS
$(document).on('click', '.sub-btn', function (e){
   e.preventDefault();
   var btn = $(this);
   var form = $('#requestWebForm');
   var speakers = $('.addedTag');
   var speaker_id = [];
   for(var i = 0; i < speakers.length; i++){
        speaker_id.push(speakers[i].getAttribute('data-id'));
   }
   var reqWebFrom = form.serializeArray();
   var url = form.attr('action');
   var method = form.attr('method');
   reqWebFrom.push({name:"speaker_id",value:speaker_id});
   $.ajax({
        url:url,
        method: method,
        data: reqWebFrom,
        beforeSend:function (){
            btn.html('<i class="fas fa-circle-notch fa-spin"></i>');
            btn.attr("disabled","true");
        },
        success:function(res){
            btn.html('Submit Request');
            btn.attr("disabled", false);
            if(res.status == 200) {
                toastr.success(res.message, res.title);
                $('#requestWebForm')[0].reset();
                $('.addedTag').remove();
            }
            else {
                toastr.error(res.message, res.title);
            }
        }
        
   })
   
});
$('.web-speaker').each(function (){
    $(this).children('span').addClass('hidden');
    $(this).children('span:first-child, span:nth-child(2), span:nth-child(3)').removeClass('hidden');
    var count = $(this).children('span').length - 3;
   if(count > 0){
       $(this).append('<span>+' + count + ' more</span>')
   }
});
var offset = 0;
$(document).on('click','#loader',function(e) {
  e.preventDefault();
  fetchNews(template=$('#speakers_card'),limit_dept=8,offset = offset+8,loader=false,loader_btn=true);
})
fetchNews(template=$('#speakers_card'),limit_dept=8,offset=0,loader=true,loader_btn=false);
var speakersData = [];
function add_tags(thisObj,tag_class,name,ids,duplicates)
{
    var duplicates = [];
    $.each($('.'+tag_class+' input[type=hidden]'),function(index,value)
                        {
                         duplicates.push($.trim($(this).val()).toUpperCase());
                        });
    if(thisObj.val() == '' || jQuery.inArray($.trim(thisObj.val()).toUpperCase(), duplicates) != -1) {
        thisObj.val('');
    } else {
         $('<li class="addedTag" data-id="'+ids+'">' + thisObj.val() + '<span class="tagRemove" onclick="$(this).parent().remove();"><i class="fas fa-times"></i></span><input type="hidden" value="' + thisObj.val() + '" name="'+name+'[]"></li>').insertBefore('.'+tag_class+' .tagAdd');
         thisObj.val('');
    }
} 
// $(document).on('keyup','#speakers',function(e){
//     if(e.which==13)
//         {
//           add_tags($(this),'languages_tag_list','searchSpeaker');
//         }
// });
var searchSpeaker = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
  url:'/webinars/search-speakers',
  prepare: function (query, settings) {
           settings.url += '?q=' + $('#speakers').val();
           return settings;
      },  
  'cache': true, 
  filter: function(list) {
      speakersData = [];
      speakersData = list;
           return list;
      }
}
});

$('#speakers').typeahead(null, {
  name: 'value',
  display: 'value',
  source: searchSpeaker,
  templates: {
   suggestion: function (data) {
      var result = '<div class="suggestion_wrap">' + '<div class="logo_wrap">' + (data.image !== null ? '<img src = "' + data.image + '">' : '<img src = "https://shshank.eygb.me/assets/themes/ey/images/pages/webinar/default-user.png">') + '</div>' + '<div class="suggestion">' + '<p class="tt_text">' + data.value + "</p></div></div>"
      return result;
   },
   empty: ['<div class="no_result_display"><div class="no_result_found">Sorry! No results found</div></div>'],
},
}).on('typeahead:asyncrequest', function() {
    $('.load-suggestions').show();
  }).on('typeahead:asynccancel typeahead:asyncreceive', function() {
    $('.load-suggestions').hide();
  }).on('typeahead:selected',function(e, datum)
  {
      add_tags($(this),'languages_tag_list','searchSpeaker',datum.id);
      setTimeout(function (){
          $('#speakers').val('');
      },200);
      console.log(12);
   });

$(".datepicker").datepicker({
    autoclose: true,
    format: "yyyy-mm-dd",
    startDate: new Date(),
    fontAwesome: true
});
 function validateSelection() {
  var theIndex = -1;
  for (var i = 0; i < global.length; i++) {
  if (global[i].value == $(this).val()) {
  theIndex = i;
 break;
   }
  }
  if (theIndex == -1) {
   $(this).val(""); 
   global = [];
  }
  }
JS;
$this->registerCssFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('@backendAssets/global/plugins/typeahead/typeahead.bundle.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-toastr/toastr.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJS($script);

?>
<script></script>
