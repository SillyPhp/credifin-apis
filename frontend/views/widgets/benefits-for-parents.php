<?php
use yii\helpers\Url;
?>

<section class="benefit-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="heading-style bene-head">Benefits For Parents</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs"><i class="fa fa-rupee-sign"></i></span>
                </div>
                <div class="bene-img-text">
                    <p>School Fee loans upto Rs. 3 lakhs</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs"><i class="fa fa-file-signature"></i></span>
                </div>
                <div class="bene-img-text">
                    <p>Minimal Paper Work</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs"><i class="fa fa-book-open"></i></span>
                </div>
                <div class="bene-img-text">
                    <p>0% Interest Loans</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs"><i class="fas fa-thumbs-up"></i></span>
                </div>
                <div class="bene-img-text">
                    <p>Approval In Minutes</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs"><i class="fa fa-hand-holding-usd"></i></span>
                </div>
                <div class="bene-img-text">
                    <p>No Prepayment Charges</p>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <div class="bene-img">
                    <span class="img-fs">EMI</span>
                </div>
                <div class="bene-img-text">
                    <p>Repay In Easy Monthly Installments</p>
                </div>
            </div>
        </div>
    </div>
</section>



<?php
$this->registerCss('
.benefit-bg {
    background-color: #edf4fc;
    padding: 20px 0px 20px;
}
.bene-head {
    margin: 0px 20px 60px;
}
.bene-head h2 {
    font-size: 28pt;
    font-family: lobster;
    color: #2b478b;
}
.bene-img-text {
    text-align: center;
    margin: 20px 0px;
}
.bene-img-text p {
    font-size: 15px;
    color: #2b478b;
    font-family: roboto;
    font-weight: 500;
    line-height: 20px;
}
.bene-img {
    text-align: center;
    border-radius: 50%;
    background-color: #00a0e3;
    padding: 10px;
    box-shadow: 0 0 11px 6px rgb(0 0 0 / 20%);
    max-width: 90px;
    margin: 0 auto;
}
.img-fs {
    font-size: 40px;
    font-weight: 600;
    color: #fff;
}
');