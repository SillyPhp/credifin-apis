<?php

use yii\helpers\Url;

?>

<section class="set-bg">
    <div class="container">
        <div class="row position-relative">
            <div class="position-absolute">
                <div class="form-main col-md-6 col-sm-12 col-md-offset-3">
                    <div class="emp-logo">
                        <a href="https://www.empoweryouth.com/">
                            <img src="<?= Url::to('@eyAssets/images/logos/eycom.png') ?>">
                        </a>
                    </div>
                    <div class="tab" id="step-1">
                        <div class="job-title col-md-12 pdng">
                            <label for="job-profile">Job Profile</label>
                            <input type="text" class="form-control" placeholder="Enter Job Profile">
                        </div>
                        <div class="city col-md-12 pdng">
                            <label>City</label>
                            <input type="text" class="form-control" placeholder="Enter City">
                        </div>
                        <div class="experience col-md-6 col-sm-6 pdng">
                            <label>Job Experience</label>
                            <input type="text" class="form-control" placeholder="Enter Experience">
                        </div>
                        <div class="salary col-md-6 col-sm-6 pdng">
                            <label>Expected Salary</label>
                            <input type="text" class="form-control" placeholder="₹:">
                        </div>
                        <div class="submit-b col-md-12 col-sm-12">
                            <button class="sub-btn nextBtn" type="button">Next</button>
                        </div>
                    </div>
                    <div class="tab" id="step-2">
                        <div class="first-name col-md-7 pdng">
                            <label for="f-name">First Name</label>
                            <input type="text" class="form-control" placeholder="Enter your First-name">
                        </div>
                        <div class="last-name col-md-5 pdng">
                            <label for="l-name">Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter your Last-name">
                        </div>
                        <div class="E-mail col-md-12 pdng">
                            <label>E-mail Address</label>
                            <input type="email" class="form-control" placeholder="Enter Your E-mail">
                        </div>
                        <div class="submit-b col-md-6 col-sm-6">
                            <button class="prev-btn prevBtn" type="button">Prev.</button>
                        </div>
                        <div class="submit-b col-md-6 col-sm-6">
                            <button class="sub-btn nextBtn" type="button">Next</button>
                        </div>
                    </div>
                    <div class="tab" id="step-3">
                        <div class="user-name col-md-12 pdng">
                            <label for="u-name">User Name</label>
                            <input type="text" class="form-control" placeholder="Enter your User-name">
                        </div>
                        <div class="enter-pass col-md-6 pdng">
                            <label for="enter-pass">Enter Password</label>
                            <input type="password" class="form-control" placeholder="Enter your password">
                        </div>
                        <div class="confirm-pass col-md-6 pdng">
                            <label for="pass-c">Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Confirm your password">
                        </div>
                        <div class="submit-b col-md-12 col-sm-12">
                            <button class="sub-btn submBtn" type="button">Submit</button>
                        </div>
                    </div>
                    <!--                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open-->
                    <!--                        Modal-->
                    <!--                    </button>-->
                </div>
            </div>
        </div>
    </div>
</section>


<?php
$this->registerCss('
.emp-logo {
    width: 230px;
    margin: auto;
    margin-bottom: 25px;
}
.emp-logo img{
    width:100%;
}
.form-control{
    height:40px;
}
.set-bg{
    background:url(' . Url::to('@eyAssets/images/bg/bgforms.png') . ');  
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-position:bottom;
}
.position-relative{
    position: relative;
    height: 100vh;
}
.position-absolute{
    position: absolute;
    top:50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
}
.form-main {
	border: 1px solid #eee;
	border-radius: 4px;
	box-shadow: 0 0 25px rgba(0,0,0,0.1);
	background-color: #f8f8ffdb;
	padding:45px 20px;
}
label{font-size:16px;color:#9b9a9a;}
.pdng{
    padding-bottom:18px;
}
.submit-b {
    text-align: center;
    margin-top: 20px;
}
.sub-btn {
    background: #00a0e3;
    color: #fff;
    border: none;
    padding: 5px 25px;
    font-size: 18px;
    border-radius: 4px;
    text-transform: uppercase;
}
.prev-btn {
    background: #ff7803;
    color: #fff;
    border: none;
    padding: 5px 25px;
    font-size: 18px;
    border-radius: 4px;
    text-transform: uppercase;
}
.modal-body p {
    text-align: center;
    margin: 0;
    font-size: 20px;
    text-transform: capitalize;
}
.ys-btns {
    text-align: center;
    padding: 22px 0 10px;
}
.yes, .no {
    display: inline-block;
}
.yes a{
    background-color: #00a0e3;
    color: #fff;
    font-size: 20px;
    font-weight: 500;
    padding: 8px 30px;
    border-radius: 4px;
    text-decoration:none;
}
.no a{
    background-color: #ff7803;
    color: #fff;
    font-size: 20px;
    font-weight: 500;
    padding: 8px 30px;
    border-radius: 4px;
    text-decoration:none;
}
');
$this->registerCssFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
$this->registerjsFile('https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
$this->registerjsFile('https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js');
?>
<?php
$script = <<< JS
var navListItems = $('.steps-btn'),
    allWells = $('.tab'),
    allNextBtn = $('.nextBtn');
    allPrevBtn = $('.prevBtn');allWells.hide();
$('#step-1').show();allNextBtn.click(function(){
    var curStep = $(this).closest(".tab"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = curStep.next(),
        isValid = false;
    nextStepWizard.show();
    curStep.hide();
    });
allPrevBtn.click(function(){
    var curStep = $(this).closest(".tab"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = curStep.prev(),
        isValid = false;
    nextStepWizard.show();
    curStep.hide();
    });
JS;
$this->registerJs($script);
?>