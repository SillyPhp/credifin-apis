<?php
use yii\helpers\Url;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="w-parent row">
                <div class="col-md-4 col-sm-6 col-md-offset-2">
                    <div class="w-head">GET THE LATEST FROM EMPOWERYOUTH.COM</div>
                    <div class="w-content">Jobs, Internships, Learning -- It's all part of lightspeed newsletter,Sign up to receive the latest</div>
                </div>
                <div class="col-md-5 col-sm-6">
                    <div class="email-set" style="display: flex;">
                        <input type="email" class="form-control" id="email" placeholder="ENTER E-MAIL ADDRESS">
                        <button type="button" class="btn btn-primary" style="margin-left: 5px;">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="thanks-portion row">
                <div class="col-md-6">
                    <div class="thanks-text">Thank you! You'll be the first to know about new launches and features.</div>
                </div>
                <div class="col-md-6">
                    <div class="thanks-icon">
                        <img src="<?= Url::to('@eyAssets/images/pages/index2/200.png') ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
.w-parent {
    margin-top: 30px;
    background-image: linear-gradient(to right,#fbfcfc 65%,#fff 0%);
    padding: 0px 0px 32px 0px;
}
.w-head {
    margin-top: -25px;
    font-size: 30px;
    font-weight: bold;
    font-family: roboto;
}
.w-content {
    font-size: 15px;
    font-family: roboto;
    color:  #626567 ;
}
.email-set{
	padding-top: 50px;
}
.email-set .form-control{
	font-family: roboto;
}
.thanks-portion{
    border-bottom: 1px solid #eee;
}
.thanks-text {
    text-align: left;
    font-size: 35px;
    font-weight:500;
    font-family: roboto;
}
.thanks-icon{
    max-width: 200px;
    margin: 0 auto;
}
');