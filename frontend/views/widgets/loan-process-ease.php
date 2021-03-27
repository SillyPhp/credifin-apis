<?php
use yii\helpers\Url;
?>
<section class="padd-30">
    <div class="container">
        <div class="row disFlex">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <h3 class="loan-style">We are here<br> to <span class="cBlue">ease</span> your<br> <span class="cOrange">loan</span> process </h3>
                <hr>
                <div class="applyLink">
                    <a href="/education-loans/apply" class="apply-btn">Apply Now <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6 tc">
                        <div class="nbfc-opt-box">
                            <div class="nbfc-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/Faster-processing-time.png')?>">
                            </div>
                            <p>Faster processing time</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 tc">
                        <div class="nbfc-opt-box">
                            <div class="nbfc-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/Easy-education-loan.png')?>">
                            </div>
                            <p>Easy Apply</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 tc">
                        <div class="nbfc-opt-box">
                            <div class="nbfc-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/Less-Paperwork.png')?>">
                            </div>
                            <p>Less Paperwork</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 tc">
                        <div class="nbfc-opt-box">
                            <div class="nbfc-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/Multiple-Lending-Partners.png')?>">
                            </div>
                            <p>Multiple Lending Partners</p>
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
    padding: 30px 15px; 
    margin: 15px 0;
    border-radius: 15px;
}
.nbfc-opt-box img{
    max-width: 100px;
}
.nbfc-opt-box p{
    font-size: 16px;
    text-transform: capitalize;
    line-height: 26px;
    color: #000;
    font-family: roboto;
    margin-top: 10px;
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
