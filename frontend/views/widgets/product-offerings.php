<?php
use yii\helpers\Url;
?>
<section class="main-bg">
    <div class="image-top-right">
        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/lv-s1.png') ?>" alt="">
    </div>
    <div class="image-bottom-right">
        <img src="<?= Url::to('@eyAssets/images/pages/education-loans/lv-s2.png') ?>" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 sol-sm-8">
                <div class="loan-vector-txt">
                    <h2>Loans That We Offer</h2>
                    <p>Find customized loans for all your needs.</p>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="loanFlex">
                            <div class="loan-product">
                                <div class="loan-product-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/mini-annual-fee-f.png') ?>" alt="">
                                </div>
                                <div class="loan-product-txt">
                                    <p>Annual Fee Finance</p>
                                </div>
                            </div>
                            <div class="loan-product">
                                <div class="loan-product-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-moratorium.png') ?>" alt="">
                                </div>
                                <div class="loan-product-txt">
                                    <p>Education Loan With Moratorium</p>
                                </div>
                            </div>
                            <div class="loan-product">
                                <div class="loan-product-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/mini-school-fee-f.png') ?>" alt="">
                                </div>
                                <div class="loan-product-txt">
                                    <p>School Fee Finance</p>
                                </div>
                            </div>
                            <div class="loan-product">
                                <div class="loan-product-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/interest-free-lon.png') ?>" alt="">
                                </div>
                                <div class="loan-product-txt">
                                    <p>Interest Free Loan</p>
                                </div>
                            </div>
                            <div class="loan-product">
                                <div class="loan-product-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/mini-abroad-edu-loan.png') ?>" alt="">
                                </div>
                                <div class="loan-product-txt">
                                    <p>Abroad Education Loans</p>
                                </div>
                            </div>
                            <div class="loan-product">
                                <div class="loan-product-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/mini-edu-Loan-Refinance.png') ?>" alt="">
                                </div>
                                <div class="loan-product-txt">
                                    <p>Education Loan Refinance</p>
                                </div>
                            </div>
                            <div class="loan-product">
                                <div class="loan-product-icon">
                                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/mini-teacher-loan.png') ?>" alt="">
                                </div>
                                <div class="loan-product-txt">
                                    <p>Teacher Loan</p>
                                </div>
                            </div>
                            <div class="loan-product">
                            <div class="loan-product-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/mini-edtech-loans.png') ?>" alt="">
                            </div>
                            <div class="loan-product-txt">
                                <p>EdTech Loans</p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="loan-vector">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/loan-vector1.png') ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.main-bg {
    background-color: #fff;
    position: relative;
//    min-height: 500px;
    padding: 20px 0 60px 0;
}
.loanFlex{
    display: flex;
    width: 100%;
    flex-wrap: wrap;
    margin-top: 20px; 
}
.image-top-right {
    position: absolute;
    top: 0;
    right: 0;
}
.image-top-right img {
    width: 100%;
//    max-width: 500px;
}
.image-bottom-right {
    position: absolute;
    bottom: 0;
    right: 0;
}
.image-bottom-right img {
    width: 100%;
//    max-width: 450px;
}
.loan-vector-txt h2 {
    color: #00a0e3;
    font-family: roboto;
    font-size: 36pt;
    line-height: 46px;
    font-weight: 400;
    margin-bottom:0px;
}
.loan-vector-txt p {
    font-size: 20px;
    color: #000;
    font-family: roboto;
    font-weight: 400;
}
.loan-vector {
    margin-top: 80px;
}
.loan-vector img {
    width: 120%;
    max-width: 500px;
}
.loan-product {
    display: flex;
    align-items: center;
    border-radius: 10px;
    box-shadow: 3px 4px 7px rgb(102 102 102 / 25%);
    margin: 12px 20px 12px 0;
    padding: 10px 12px;
}
.loan-product-icon {
//    margin-left: 10px;
}
.loan-product-icon img{
//    width: 100%;
    max-width: 50px;
    max-height: 50px
}
.loan-product-txt {
   margin: 5px 0px 5px 10px;
}
.loan-product-txt p {
    font-size: 14px;
    font-family: roboto;
    font-weight: 400;
    color: #000;
    margin-bottom: 0px !important;
    letter-spacing: .5px;
}
');