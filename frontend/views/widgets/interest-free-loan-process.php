<?php
use yii\helpers\Url;
?>
    <section class="loan-process">
        <div class="container">
            <div class="row">
                <div class="heading-style bene-head">Loan Process</div>
            </div>
            <div class="row flex-process">
                <div class="col-md-2 col-md-offset-1 col-sm-4 col-xs-12">
                    <div class="loan-steps loan-line1">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/step1.png') ?>" alt="">
                        <p>Apply Online</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="loan-steps marg-top loan-line2">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/step2.png') ?>" alt="">
                        <p>Upload Documents</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="loan-steps loan-line1">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/step3.png') ?>" alt="">
                        <p>Pre Sanction Verification</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="loan-steps marg-top loan-line2">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/step4.png') ?>" alt="">
                        <p>Sanction of Loan</p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
                    <div class="loan-steps">
                        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/step5.png') ?>" alt="">
                        <p>Loan Disbursed</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.loan-process {
    margin: 40px 0;
}
.marg-top{margin-top:50px;}
.heading-s {
    margin: 0 20px 50px;
    font-family: lobster;
    font-size: 34px;
}
.loan-steps p {
    font-size: 14px;
    font-family: roboto;
    font-weight: 500;
    margin-bottom:30px;
}
.loan-steps img {
    width: 90px;
    margin-bottom: 15px;
    position:relative;
    z-index:999;
}
.loan-steps {
    text-align: center;
    position:relative;
}
.loan-line1::before {
    content: "";
    display: block;
    width: 140px;
    height: 2px;
    background: #dbdbdb;
    left: 66%;
    top: 48%;
    position: absolute;
    transform: rotate(41deg);
}

.loan-line2::before {
    content: "";
    display: block;
    width: 140px;
    height: 2px;
    background: #dbdbdb;
    left: 67%;
    top: 16%;
    position: absolute;
    transform: rotate(-40deg);
}
@media screen and (max-width: 992px){
.loan-line1::before, .loan-line2::before{display:none;}
.marg-top{margin:0;}
.flex-process {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}
}
@media screen and (max-width: 515px) and (min-width: 300px) {
.marg-top {
    margin-top: 0px;
    }
}
');
