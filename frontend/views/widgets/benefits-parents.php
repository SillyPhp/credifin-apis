<?php
use yii\helpers\Url;
?>
    <section class="benefits-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-20 pb-10 mt0 heading-style"><?= Yii::t('frontend', 'Benefits For Parents'); ?></h2>
                </div>
            </div>
            <div class="row-mt10">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="benefits-for-parents">
                        <div class="benefits-for-parents-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/tax-rebate.png'); ?>"/>
                        </div>
                        <div class="benefits-for-parents-text">Tax Rebate</div>
                        <div class="overlay">
                            <div class="overlay-txt"> Parents can file for tax rebate under Income Tax Returns till the loan is going on.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="benefits-for-parents">
                        <div class="benefits-for-parents-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/reduces-financial-burden.png'); ?>"/>
                        </div>
                        <div class="benefits-for-parents-text">Reduces Financial Burden</div>
                        <div class="overlay">
                            <div class="overlay-txt">Parents can easily repay off the loan with easy installments which reduces burden of one time payment of huge amounts.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="benefits-for-parents">
                        <div class="benefits-for-parents-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/easy-repayment.png'); ?>"/>
                        </div>
                        <div class="benefits-for-parents-text">Easy Repayment</div>
                        <div class="overlay">
                            <div class="overlay-txt">Parents can easily repay off in installments that are set according to their repayment capacities.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="benefits-for-parents">
                        <div class="benefits-for-parents-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/time-saving-process.png'); ?>"/>
                        </div>
                        <div class="benefits-for-parents-text">Time Saving Process</div>
                        <div class="overlay">
                            <div class="overlay-txt">Whole process is online which saves a lot of time and the reverts on the cases are shared in 7 working days.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="benefits-for-parents">
                        <div class="benefits-for-parents-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/services-online.png'); ?>"/>
                        </div>
                        <div class="benefits-for-parents-text"> At Home Service</div>
                        <div class="overlay">
                            <div class="overlay-txt">Customer can avail service at home as EmpowerYouth.com provides services online.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="benefits-for-parents">
                        <div class="benefits-for-parents-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/online-documentation-pdf.png'); ?>"/>
                        </div>
                        <div class="benefits-for-parents-text">Online Documentation</div>
                        <div class="overlay">
                            <div class="overlay-txt">No need to provide physical copies of documents. Pdfs are the safest and fastest mode to share documents.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="benefits-for-parents">
                        <div class="benefits-for-parents-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/cash-income.png'); ?>"/>
                        </div>
                        <div class="benefits-for-parents-text">Cash Income</div>
                        <div class="overlay">
                            <div class="overlay-txt">Parents having total cash income like income from tuition, boutique, agriculture income etc are considered.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="benefits-for-parents">
                        <div class="benefits-for-parents-icon">
                            <img src="<?= Url::to('@eyAssets/images/pages/education-loans/non-itr.png'); ?>"/>
                        </div>
                        <div class="benefits-for-parents-text">Non-ITR cases</div>
                        <div class="overlay">
                            <div class="overlay-txt">Parents with no or 1 ITR can avail the service of education loan with EmpowerYouth.com.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.benefits-bg {
    background-color: #edf4fc;
    padding: 30px 0;
}
.benefits-for-parents:hover .overlay{
    height: 100%;
}
.overlay{
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #00a0e3;
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
.benefits-for-parents-text{
    margin: 10px 0;
    font-size: 14px;
    font-family: roboto;
    font-weight: 600;
    text-align: center;
    color: #808080;
    padding: 0 5px;
}
.benefits-for-parents-icon{
    text-align: center;
    width: 70px;
    margin: 0px auto;
    height: 70px;
}
.benefits-for-parents{
    width: 100%;
    height: 155px;
    box-shadow: 0 0 11px -4px #999;
    margin-bottom: 30px;
    background-color: #fff;
    transition: all .2s;
    position: relative;
    padding: 20px 0;
}
.benefits-for-parents-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
@media only screen and (max-width: 550px){
    .benefits-for-parents-icon{
        width: 70px;
        height: 70px;
    }
    .benefits-for-parents-icon img{
        width: 70px;
        height: 70px;
    }
}
');