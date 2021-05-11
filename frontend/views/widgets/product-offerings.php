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
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="loan-product">
                            <div class="loan-product-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-moratorium.png') ?>" alt="">
                            </div>
                            <div class="loan-product-txt">
                                <p>Education Loan With Moratorium</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="loan-product">
                            <div class="loan-product-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/interest-free-lon.png') ?>" alt="">
                            </div>
                            <div class="loan-product-txt">
                                <p>Interest Free Loan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="loan-product">
                            <div class="loan-product-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-moratorium.png') ?>" alt="">
                            </div>
                            <div class="loan-product-txt">
                                <p>Education Loan With Moratorium</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="loan-product">
                            <div class="loan-product-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-moratorium.png') ?>" alt="">
                            </div>
                            <div class="loan-product-txt">
                                <p>Education Loan With Moratorium</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="loan-product">
                            <div class="loan-product-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-moratorium.png') ?>" alt="">
                            </div>
                            <div class="loan-product-txt">
                                <p>Education Loan With Moratorium</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="loan-product">
                            <div class="loan-product-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-moratorium.png') ?>" alt="">
                            </div>
                            <div class="loan-product-txt">
                                <p>Education Loan With Moratorium</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="loan-product">
                            <div class="loan-product-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-moratorium.png') ?>" alt="">
                            </div>
                            <div class="loan-product-txt">
                                <p>Education Loan With Moratorium</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="loan-product">
                            <div class="loan-product-icon">
                                <img src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-moratorium.png') ?>" alt="">
                            </div>
                            <div class="loan-product-txt">
                                <p>Education Loan With Moratorium</p>
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
    min-height: 450px;
}
.image-top-right {
    position: absolute;
    top: 0;
    right: 0;
}
.image-top-right img {
    width: 100%;
    max-width: 500px;
}
.image-bottom-right {
    position: absolute;
    bottom: 0;
    right: 0;
}
.image-bottom-right img {
    width: 100%;
    max-width: 450px;
}
.loan-vector-txt h2 {
    color: #005bbf;
    font-family: lora;
    font-size: 42pt;
    font-weight: bold;
}
.loan-vector-txt p {
    font-size: 28px;
    color: #000;
    font-family: roboto;
    font-weight: 500;
    line-height: 20px;
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
    border: 1px solid #f5f5f5;
    border-radius: 8px;
    box-shadow: 3px 3px 10px rgb(0 0 0 / 10%);
    margin-top: 40px;
}
.loan-product-icon {
    margin-left: 10px;
}
.loan-product-icon img{
    width: 100%;
    max-width: 70px;
}
.loan-product-txt {
   margin: 5px 0px 5px 10px;
}
.loan-product-txt p {
    font-size: 12px;
    font-family: roboto;
    font-weight: 500;
    line-height: 20px;
    color: #000;
    margin-bottom: 0px !important;
}
');