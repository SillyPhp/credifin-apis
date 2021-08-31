<?php
    use yii\helpers\Url;
?>
<div class="row">
    <div class="col-md-12">
        <div class="el-pos-rel">
            <div class="max-300">
                <div class="cl-heading">Interest Free Loans</div>
                <p class="interest-text">Going for an Education Loan lowers down the burden on your family savings.
                    On the same hand, think of an education loan that is INTEREST FREE. At EmpowerYouth, we have come up
                    with Interest Free Education Loan to meet all your financial
                    needs and help you get your dream education.</p>
                <p class="lenders">More Than <span>20+</span> Lenders</p>
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
<!--                                <span>-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/index2/AG-logo.png')?><!--">-->
<!--                                </span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="lender-icon">-->
<!--                                <span>-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/avanse-logo.png')?><!--">-->
<!--                                </span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="lender-icon">-->
<!--                                <span>-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/incred_logo.png')?><!--">-->
<!--                                </span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <div class="lender-icon">-->
<!--                                <span>-->
<!--                                    <img src="--><?//= Url::to('@eyAssets/images/pages/education-loans/ezcapital.png')?><!--">-->
<!--                                </span>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
                <div class="cl-icon">
                    <p>Our Partner Colleges</p>
                    <ul>
                        <li>
                            <div class="lender-icon">
                                <span>
                                     <img src="<?= Url::to('@eyAssets/images/pages/education-loans/gna.png') ?>" alt="">
                                </span>
                            </div>
                        </li>
                        <li>
                            <div class="lender-icon">
                                <span>
                                     <img src="<?= Url::to('@eyAssets/images/pages/education-loans/rayat.png') ?>" alt="">
                                </span>
                            </div>
                        </li>
                        <li>
                            <div class="lender-icon">
                                <span>
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/bahra.png') ?>" alt="">
                                </span>
                            </div>
                        </li>
                        <li>
                            <div class="lender-icon">
                                <span>
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/rayat2.png') ?>" alt="">
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerCss('
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
    font-weight: 400 !important;
} 
.lenders{
    margin-top: 20px;
    color: #f3f3f2;
    font-size: 16px;
}
.lenders span{
    font-weight: 600;
}
.college-logo {
    position:relative !important;
}
.interest-text{
    color: #fff;
    max-width: 450px;
    margin: 0 auto;
    padding-top: 10px;
}
')
?>