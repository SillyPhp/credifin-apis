<?php
    use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-12">
        <div class="el-pos-rel">
            <div class="max-300">
                <div class="cl-heading">Get the Best Education Loan</div>
                <ul class="loan-benefits">
                    <li>- <span>100% Financing</span> will be provided which includes all expenses borne by
                        the students in a particular <span>academic year</span>.</li>
                    <li>- Loan will be <span>repaid</span> with in the semester</li>
                    <li>- More Than <span>20+</span> Lenders</li>
                </ul>
                <div class="cl-icon">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="widget-benfit">
                                <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/widget-minimal-paper-work.png') ?>">
                                <p>Minimal Paper Work</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-benfit">
                                <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/widget-faster-processing-time.png') ?>">
                                <p>Faster Processing Time</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-benfit">
                                <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/widget-approval-in-minutes.png') ?>">
                                <p>Approval In Minutes</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget-benfit">
                                <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/widget-quick-disbursement.png') ?>">
                                <p>Quick Disbursement</p>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div class="cl-icon">-->
<!--                    <p>Our Lenders</p>-->
<!--                    <ul>-->
<!--                        <li>-->
<!--                            <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png')?><!--">-->
<!--                                            </span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png')?><!--">-->
<!--                                            </span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/wepay.png')?><!--">-->
<!--                                            </span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/exclusive-logo.png')?><!--">-->
<!--                                            </span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/ezcapital.png')?><!--">-->
<!--                                            </span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="lender-icon">-->
<!--                                            <span>-->
<!--                                                <img src="--><?//= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?><!--">-->
<!--                                            </span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="lender-icon">-->
<!--                                <span class="li-text">+10 More</span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCSS('
.widget-benfit{
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin-top: 30px;
}
.widget-benfit img{
    max-width: 60px;
    margin-bottom: 10px;
}
.widget-benfit p{
    color: #fff;
    font-size: 16px !important;
    line-height: 20px;
    font-weight: 500 !important;    
} 
')
?>
