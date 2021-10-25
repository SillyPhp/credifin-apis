<?php
use yii\helpers\Url;
?>
<section>
    <div class="loan">
        <div class="loan-txt">
            <div class="loan-txt1">Take Your <br> Students to Success with our
                <h2 class="blue-txt"> Educational Institution Loan</h2>
                <a href="<?= Url::to('/educational-institution-loan') ?>" class="btn-set">
                    Apply Now
                </a>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
.btn-set{   
    border: 1px solid #00a0e3;
    padding: 6px 44px;
    color: #fff;
    background: #00a0e3;
    border-radius: 5px;
    display: inline-flex;
    margin-top: 10px;
    font-size: 20px;
    font-family: roboto;
    transition-duration: 0.3s ease-in-out;
}
.btn-set:hover{
    background-color: #fff;
    color: #00a0e3;;
}
.loan{
    background-image: url(/assets/themes/ey/images/pages/education-loans/loan-widget-shape.png),url(/assets/themes/ey/images/pages/education-loans/edu-loan-icn.png);
    background-repeat: no-repeat;
    background-position: left top, right bottom;
    min-height: 350px;
    margin-top: 40px;
}
.loan-txt{
    font-size: 30px;
    font-family: roboto;
    display: flex;
    font-weight: 600;
    line-height: 40px;
    color: #000;
    height: 350px;
    align-items: center;
    margin-left: 14%;
}
.blue-txt{
    color: #00a0e3;
    font-size: 30px;
    font-weight: 600;
    margin: 0;
    font-family:roboto;
}
@media screen and (max-width: 1030px) and (min-width:990px) {
  .loan{
        background-size: 10%, 57%;
    }
    .loan-txt{
        font-size: 26px;
        line-height: 35px;
    }
}
@media screen and (max-width: 986px) and (min-width:770px) {
  .loan{
        background-size: 0%, 70%;
    }
    .loan-txt{
        margin-left: 3%;
        font-size: 23px;
        line-height: 30px;
    }
}
@media screen and (max-width: 768px) and (min-width:600px) {
  .loan{
            background-size: 0%, 74%;
    }
    .loan-txt{
        margin-left: 2%;
        font-size: 21px;
        line-height: 28px;
    }
}
@media screen and (max-width: 590px) and (min-width:320px) {
  .loan{
           background-size: 33%, 0%;
}
    .loan-txt{
        font-size: 27px;
        line-height: 38px;
        margin-left: 32%;
    }
    .btn-set{
        padding: 3px 48px;
        font-size: 17px;
}
}
');
?>
