<?php
use yii\helpers\Url;
?>
    <section class="edu-with-us">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-20 pb-10 mt0 heading-style"><?= Yii::t('frontend', 'Why Empower Youth'); ?></h2>
                </div>
            </div>
            <div class="row-mt10">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="finance">
                        <div class="finance-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/100-finance.png'); ?>"/>
                        </div>
                        <div class="finance-text">100% Financing</div>
                        <div class="overlay">
                            <div class="overlay-txt">Loans covering all the student expenses like tution fees, hostel
                                fees, transportation expenses etc.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="finance">
                        <div class="finance-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/customized-loans.png'); ?>"/>
                        </div>
                        <div class="finance-text">Customized Loans</div>
                        <div class="overlay">
                            <div class="overlay-txt">Personalized loans as per the students needs and requirements.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="finance">
                        <div class="finance-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/quick-sanctions.png'); ?>"/>
                        </div>
                        <div class="finance-text">Quick Sanctions</div>
                        <div class="overlay">
                            <div class="overlay-txt">Easy and fast loan approvals for your dream education.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="finance">
                        <div class="finance-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/documentation.png'); ?>"/>
                        </div>
                        <div class="finance-text">Minimal Documentation</div>
                        <div class="overlay">
                            <div class="overlay-txt">Hassle free loan application process with less or minimal paperwork.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="finance">
                        <div class="finance-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/repayment.png'); ?>"/>
                        </div>
                        <div class="finance-text">Flexible Repayment Options</div>
                        <div class="overlay">
                            <div class="overlay-txt">Student can select a repayment option that best suits his/her needs.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="finance">
                        <div class="finance-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/study-abroadd.png'); ?>"/>
                        </div>
                        <div class="finance-text">Get Loan To Study Abroad</div>
                        <div class="overlay">
                            <div class="overlay-txt">Providing easy and interest free education loan for study abroad
                                programs.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="finance">
                        <div class="finance-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/pre-admissin.png'); ?>"/>
                        </div>
                        <div class="finance-text">Pre-Admission Loan</div>
                        <div class="overlay">
                            <div class="overlay-txt">Get your loan approved before your admission in college or university.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="finance">
                        <div class="finance-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/pre-visa.png'); ?>"/>
                        </div>
                        <div class="finance-text">Pre-Visa Loan</div>
                        <div class="overlay">
                            <div class="overlay-txt">Now you can get your loan sanctioned before your visa gets approved.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.finance:hover .overlay{
    height: 100%;
}
.overlay{
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #ed6d1e;
    overflow: hidden;
    width: 100%;
    height: 0;
    transition: .5s ease;
}
.overlay-txt{
    color: #fff;
    width:90%;
    font-size: 15px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
    font-family: roboto;
    font-weight: 500;
    line-height: 20px;
}
.finance-text{
    margin: 10px 0;
    font-size: 14px;
    font-family: roboto;
    font-weight: 600;
    text-align: center;
    color: #808080;
    padding: 0 5px;
}
.finance-icon{
    text-align: center;
    width: 70px;
    margin: 0px auto;
    height: 70px;
}
.finance{
    width: 100%;
    height: 155px;
    box-shadow: 0 0 11px -4px #999;
    margin-bottom: 30px;
    background-color: #fff;
    transition: all .2s;
    position: relative;
    padding: 20px 0;
}
.finance-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
@media only screen and (max-width: 550px){
    .finance-icon{
        width: 70px;
        height: 70px;
    }
    .finance-icon img{
        width: 70px;
        height: 70px;
    }
}
');