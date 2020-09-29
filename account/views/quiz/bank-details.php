<?php

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>
<section class="mt2">
    <div class="form-shadow">
        <div class="bank-detail-icon">
            <img src="<?= Url::to('@eyAssets/images/pages/quiz/bank-detail.png') ?>">
        </div>
        <div class="form-layout">
            <div class="row">
                <div class="col-md-12">
                    <div class="bank-heading">Bank Details</div>
                </div>
            </div>
            <div class="row">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'bank_detail_form',
                    'options' => [
                    ],
                    'fieldConfig' => [
                        'template' => "{label}{input}",
                    ],
                ]);
                ?>
                <div class="col-md-4 col-sm-6">
                    <?= $form->field($model, 'bank_name')->textInput(['class' => 'uname-in']) ?>
                </div>
                <div class="col-md-4 col-sm-6">
                    <?= $form->field($model, 'branch_name')->textInput(['class' => 'uname-in']) ?>
                </div>
                <div class="col-md-4 col-sm-6">
                    <?= $form->field($model, 'branch_number')->textInput(['class' => 'uname-in']) ?>
                </div>
                <div class="col-md-6 col-sm-6">
                    <?= $form->field($model, 'branch_address')->textInput(['class' => 'uname-in']) ?>
                </div>
                <div class="col-md-3 col-sm-3">
                    <?= $form->field($model, 'city')->textInput(['class' => 'uname-in']) ?>
                </div>
                <div class="col-md-3 col-sm-3">
                    <?= $form->field($model, 'region')->textInput(['class' => 'uname-in']) ?>
                </div>
                <div class="col-md-4 col-sm-6">
                    <?= $form->field($model, 'account_no')->textInput(['class' => 'uname-in']) ?>
                </div>
                <div class="col-md-4 col-sm-6">
                    <?= $form->field($model, 'account_holder')->textInput(['class' => 'uname-in']) ?>
                </div>
                <div class="col-md-4 col-sm-6">
                    <?= $form->field($model, 'ifsc_code')->textInput(['class' => 'uname-in']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="com-load-more-btn">
                <button type="button" id="" class="btn blue">Submit</button>
            </div>
        </div>
    </div>
</section>
<?php
$this->registerCss('
label{
    font-weight: bold;
}
.bank-detail-icon{
    text-align: center;
    padding: 80px 0 0 0;
    flex-basis: 30%;
}
.form-shadow{
    background: linear-gradient(to right, #00a0e3 30%, #fff 30%);
    box-shadow: 0 0 10px rgba(0,0,0,.2);
    display: flex;
}
.form-layout{
    padding: 20px 30px 40px 30px;  
    flex-basis: 70%;   
}
.uname-in {
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
    font-size: 13px;
}
.com-load-more-btn{
    padding-top: 30px;
    text-align: center;
}
.mt2{
    margin-top: 20px;
}
.bank-heading{
    font-size: 25px; 
    font-weight: bold;
    text-transform: capitalize;
    text-align: center;
    padding: 0 0 40px 0
}
@media screen and (max-width: 992px){
    .form-layout{
        flex-basis: 100%;
    }
    .bank-detail-icon{
        flex-basis: 100%;
    }
    .form-shadow{
        background: linear-gradient(to bottom, #00a0e3 30%, #fff 30%);
        flex-direction: column
    }
    
}
')
?>


