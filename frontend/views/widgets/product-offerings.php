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
    <div class="container-fluid">
        <div class="row loan-offerings">
            <div class="col-md-7 sol-sm-7">
                <div class="loan-vector-txt">
                    <h2>Loans That We Offer</h2>
                    <p>Find customized loans for all your needs.</p>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="loanFlex">
                            <a href="/education-loans/annual-fee-financing" target="_blank">
                                <div class="loan-product">
                                    <div class="loan-product-icon">
                                        <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/annual-fee-f.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt="">
                                    </div>
                                        Annual Fee Finance
                                </div>
                            </a>
                            <a href="/education-loans/study-in-india" target="_blank">
                                <div class="loan-product">
                                    <div class="loan-product-icon">
                                        <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/edu-loan-moratorium.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt="">
                                    </div>
                                        Education Loan With Moratorium
                                </div>
                            </a>
                            <a href="/education-loans/school-fee-finance" target="_blank">
                                <div class="loan-product">
                                    <div class="loan-product-icon">
                                        <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/school-fee-f.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt="">
                                    </div>
                                        School Fee Finance
                                </div>
                            </a>
                            <a href="/education-loans/interest-free" target="_blank">
                                <div class="loan-product">
                                    <div class="loan-product-icon">
                                        <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/interest-free-lon.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt="">
                                    </div>
                                        Interest Free Loan
                                </div>
                            </a>
                            <a href="/education-loans/study-abroad" target="_blank">
                                <div class="loan-product">
                                    <div class="loan-product-icon">
                                        <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/abroad-edu-loan.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt="">
                                    </div>
                                        Abroad Education Loans
                                </div>
                            </a>
                            <a href="/education-loans/refinance" target="_blank">
                                <div class="loan-product">
                                    <div class="loan-product-icon">
                                        <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/Edu-Loan-Refinance.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt="">
                                    </div>
                                        Education Loan Refinance
                                </div>
                            </a>
                            <a href="/education-loans/loan-for-teachers/apply" target="_blank">
                                <div class="loan-product">
                                    <div class="loan-product-icon">
                                        <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/teacher-loan.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt="">
                                    </div>
                                        Teacher Loan
                                </div>
                            </a>
                            <a target="_blank">
                                <div class="loan-product">
                                    <div class="loan-product-icon">
                                        <img class="load-later" data-src="<?= Url::to('@eyAssets/images/pages/education-loans/edtech-loans.png') ?>" src="<?= Url::to('@eyAssets/images/loader/Circles-menu.gif') ?>" alt="">
                                    </div>
                                        EdTech Loans
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-5">
                <div class="loan-vector">
                    <img src="<?= Url::to('@eyAssets/images/pages/education-loans/loan-vector1.png') ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.loan-offerings {
    display: flex;
    align-items: flex-end;
    justify-content: center;
    flex-wrap: wrap;
}
.loan-product:hover {
    background-color: #00a0e3;
    color: #fff;
    transition: 0.2s ease-in;
}
.main-bg {
    background-color: #EDF5FF;
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
    font-weight: 600;
    margin-bottom: 0px;
}
.loan-vector-txt p {
    font-size: 19px;
    color: #000;
    font-family: roboto;
    font-weight: 400;
    margin-top: 8px
}
.loan-vector img {
    width: 100%;
    max-width: 500px;
}
.loan-product {
    display: flex;
    align-items: center;
    border-radius: 10px;
    box-shadow: 3px 4px 7px rgb(102 102 102 / 25%);
    margin: 12px 20px 12px 0;
    padding: 10px 12px;
    font-size: 14px;
    font-family: roboto;
    font-weight: 500;
    color: #000;
    margin-bottom: 0px !important;
    letter-spacing: .5px;
    background-color: #fff;
}
.loan-product-icon {
    margin-right: 10px;
}
.loan-product-icon img{
//    width: 100%;
    max-width: 50px;
    max-height: 50px
}
.loan-product-txt {
   margin: 5px 0px 5px 10px;
   
}
@media screen and (max-width: 992px) {
    .image-bottom-right, .loan-vector {
        display: none;
    }
    .image-top-right img {
    max-width: 350px;
    }
}
@media screen and (max-width: 550px) {
    .image-top-right img {
        max-width: 240px;
    }
    .loan-vector-txt h2 {
        font-size: 28pt;
        line-height: 40px;
    }
    .loanFlex a{
        width: 100%;
        }
}
');
$script = <<<JS
$('.load-later').Lazy();
JS;
$this->registerJs($script);
