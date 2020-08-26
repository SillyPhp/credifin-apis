<?php
use yii\helpers\Url;
if (Yii::$app->params->paymentGateways->mec->icici) {
    $configuration = Yii::$app->params->paymentGateways->mec->icici;
    if ($configuration->mode === "production") {
        $access_key = $configuration->credentials->production->access_key;
        $secret_key = $configuration->credentials->production->secret_key;
        $url = $configuration->credentials->production->url;
    } else {
        $access_key = $configuration->credentials->sandbox->access_key;
        $secret_key = $configuration->credentials->sandbox->secret_key;
        $url = $configuration->credentials->sandbox->url;
    }
}
Yii::$app->view->registerJs('var access_key = "' .$access_key. '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var token = "' . $token . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var education_loan_id = "' . $education_loan_id . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var loan_id = "' . $loan_id . '"', \yii\web\View::POS_HEAD);
?>
<script id="context" type="text/javascript" src="https://payments.open.money/layer"></script>
<script>
    p(token,access_key);
    function p(ptoken,access_key) {
        Layer.checkout({
                token: ptoken,
                accesskey: access_key
            },
            function(response) {
                if (response.status == "captured") {
                    updateStatus(education_loan_id,loan_id,response.payment_id,response.status);
                    window.location.href = "/";
                } else if (response.status == "created") {
                    updateStatus(education_loan_id,loan_id,response.payment_id,response.status);
                    window.location.href = "/";
                } else if (response.status == "pending") {
                    updateStatus(education_loan_id,loan_id,response.payment_id,response.status);
                } else if (response.status == "failed") {
                    updateStatus(education_loan_id,loan_id,response.payment_id,response.status);
                } else if (response.status == "cancelled") {
                    updateStatus(education_loan_id,loan_id,response.payment_id,response.status);
                    location.reload(true);
                }
            },
            function(err) {
                swal({
                    title:"Error",
                    text: "Some Internal Server Error, Please Try After Some Time",
                });
            }
        );
    }
 function updateStatus(education_loan_id,loan_app_enc_id,payment_id=null,status)
 {
     $.ajax({
         url : 'https://empoweryouth.com/api/v3/education-loan/update-widget-loan-application',
         method : 'POST',
         data : {
             loan_payment_id:education_loan_id,
             loan_app_id:loan_app_enc_id,
             payment_id:payment_id,
             status:status,
         },
         success:function(e)
         {
             //console.log(e);
         }
     })
 }
</script>
<?php

$this->registerCssFile('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');








