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
                        <button class="sub-btn" data-toggle="modal" data-target="#myModal">Submit</button>
                    </div>
                    <!--                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open-->
                    <!--                        Modal-->
                    <!--                    </button>-->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Notice!</h4>
            </div>
            <div class="modal-body">
                <p>If you wanna sign up click on Yes</p>
                <div class="ys-btns">
                    <div class="yes">
                        <a href="#">Yes</a>
                    </div>
                    <div class="no">
                        <a href="#">No</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

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
    padding: 8px 30px;
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
