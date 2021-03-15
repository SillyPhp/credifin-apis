<?php
use yii\helpers\Url;
?>
<section class="lnbg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="loan-strip-text">
                    <p>All loans are from bank and non-bank partners licensed by RBI</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->registerCss('
.lnbg {
    background-color: #00a0e3;
}
.loan-strip-text {
    text-align: center;
    margin: -6px;
}
.loan-strip-text p {
    font-size: 22px;
    font-family: roboto;
    color: #fff;
    font-weight: 600;
}
@media screen and (max-width:758px) and (min-width:200px) {
    .loan-strip-text p {
        font-size: 16px;
    }
}
@media screen and (max-width:1024px) and (min-width:768px) {
    .loan-strip-text p {
        font-size: 20px;
    }
}
');
