<?php
use yii\helpers\Url;
?>
    <section class="ourProducts">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="heading-style"><?= Yii::t('frontend', 'Our Products'); ?></h5>
                </div>
                <div class="col-md-12">
                    <div class="displayFlex">
                        <div class="edu-loan-products">
                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/Annual-Fee-Financing-Loans.png') ?>">
                            <p>Annual Fee Financing Loans</p>
                            <a href="/education-loans/annual-fee-financing">Learn More</a>
                        </div>
                        <div class="edu-loan-products">
                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/General-Edu-Loans.png') ?>">
                            <p>General Education Loans </p>
                            <a href="/education-loans/study-in-india">Learn More</a>
                        </div>
<!--                        <div class="edu-loan-products">-->
<!--                            <img src="--><?//= Url::to('@eyAssets/images/pages/educational-loans/Pathway-Edu-Loans.png') ?><!--">-->
<!--                            <p>Pathway Education Loans</p>-->
<!--                            <a href="/annual-fee-financing">Learn More</a>-->
<!--                        </div>-->
                        <div class="edu-loan-products">
                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/school-fee-financing.png') ?>">
                            <p>School Fee Financing Loans</p>
                            <a href="/education-loans/school-fee-finance">Learn More</a>
                        </div>
                        <div class="edu-loan-products">
                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/Abroad-Edu-Loans.png') ?>">
                            <p>Abroad Education Loans</p>
                            <a href="/education-loans/study-abroad">Learn More</a>
                        </div>
                        <div class="edu-loan-products">
                            <img src="<?= Url::to('@eyAssets/images/pages/educational-loans/Refinancing-Edu-Loans.png') ?>">
                            <p>Refinancing Education Loans</p>
                            <a href="/education-loans/refinance">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCss('
.ourProducts{
    padding: 0 0 30px 0;
}
.displayFlex{
    display: flex; 
    flex-wrap: wrap;
    justify-content: center;
}
.edu-loan-products{
    text-align: center;
    box-shadow: -19px 19px 0px -11px #eee;
    min-height: 200px;
    margin-bottom: 30px;
    display: flex;
    border: 1px solid #eee;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 15px 10px;
    padding: 15px;
    width: 200px;
    letter-spacing: .5px;
    font-family: roboto;
}
.edu-loan-products:hover{
    box-shadow: -19px 19px 0px -11px #00a0e3;
    transition: .3s ease;
    cursor: pointer
}
.edu-loan-products a{
    color: #00a0e3;
    font-size: 15px;
    font-weight: 500;
}
.edu-loan-products a:hover{
    color: #ff7803;
    transition: .3s ease;
}
.edu-loan-products img{
    max-height: 50px;
}
.edu-loan-products p{
    margin-top: 15px;
    font-size: 15px;
    text-transform: capitalise;
    line-height: 20px;
}
');