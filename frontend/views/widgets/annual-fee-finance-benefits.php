<?php
use yii\helpers\Url;
?>
<section class="padd-30">
    <div class="container">
        <div class="row disFlex">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <h3 class="loan-style">Benefits of <br><span class="cBlue">Annual </span>Fee<br>
                     <span class="cOrange">Financing</span></h3>
                <hr>
                <div class="applyLink">
                    <a href="/education-loans/apply" class="apply-btn">Apply Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="nbfc-opt-box">
                            <div class="rpe-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/Easy-Documentation.png')?>">
                            </div>
                            <p>Easy Documentation</p>
                            <ul>
                                <li>The documentation process is fairly simple and basic documents are needed for
                                    sanction of loan</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="nbfc-opt-box">
                            <div class="rpe-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/Quick-Disbursement.png')?>">
                            </div>
                            <p>Quick Disbursement</p>
                            <ul>
                                <li>With our state of the art system we strive to complete the disbursement of loan in
                                    less than 10 days</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="nbfc-opt-box">
                            <div class="rpe-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/Online-Application.png')?>">
                            </div>
                            <p>Online Application</p>
                            <ul>
                                <li>The Candidates can apply for loan online using the tools provided by our technology partners.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="nbfc-opt-box">
                            <div class="rpe-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/live-tracking.png')?>">
                            </div>
                            <p>Live Update</p>
                            <ul>
                                <li>The college gets a live tracking on status of the loan application for all candidates.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.padd-30{
    padding:30px 0;
}
.rpe-icon{
    height: 60px;   
    margin-bottom: 15px;
    display: flex;
    align-items: flex-end;    
}
.rpe-icon img{
    max-width: 60px !important;
    max-height: 60px !important; 
}
hr{
    max-width: 60px;
    border-color: #eee;
    border-width: 2px;
    margin-left: 0px;
}
.apply-btn{
    font-size: 20px;
    color: #fff;
    text-transform: capitalize;
    display: inline-flex;
    align-items: center;
    line-height: 25px;
    background: #00a0e3;
    padding: 10px 25px 13px;
    border: 2px solid transparent;
    border-radius: 12px;
}
.apply-btn i{
    margin-left: 10px;
    font-size: 15px;
    margin-top: 2px;
}
.apply-btn:hover{
    color: #00a0e3;
    background: #fff;
    border: 2px solid #00a0e3;
    transition: .3s ease;
}
.disFlex{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.loan-style{
    font-size: 40px;
    line-height: 50px;
    text-transform: capitalize;
    font-weight: 400;
    font-family: Roboto;
}
.cBlue{
    color: #00a0e3;
}
.cOrange{
    color: #ff7803
}
.nbfc-opt-box{
    box-shadow: 0 0px 8px rgba(146,139,139,.3);
    padding: 25px 15px; 
    margin: 15px 0;
    border-radius: 15px;
//    text-align: center;
    min-height: 215px;
    display: flex;
    flex-direction: column;
//    justify-content: center;
    position: relative;
}
.nbfc-opt-box ul li{
    text-align: left;
}
.nbfc-opt-box img{
    max-width: 100px;
    max-height: 100px;
}
.nbfc-opt-box p{
    font-size: 18px;
    text-transform: capitalize;
    line-height: 10px;
    color: #ff7803;
    font-family: roboto;
    margin-top: 0px;
}
@media only screen and (max-width: 992px){
    .loan-style{
        text-align: center;
    }
    hr{
        margin: 20px auto;
    }
    .applyLink{
        text-align: center;
        margin-bottom: 30px;
    }
}
')

?>
