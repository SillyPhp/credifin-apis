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
Yii::$app->view->registerJs('var access_key = "' . $access_key . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var ptoken = "' . $token . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var loan_id = "' . $loan_id . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var gst = "' . $gst . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var pay_amount = "' . $amount . '"', \yii\web\View::POS_HEAD);
?>
<script id="context" type="text/javascript" src="https://payments.open.money/layer"></script>
<script>
    payment(ptoken,access_key);
    function payment(ptoken,access_key) {
        Layer.checkout({
                token: ptoken,
                accesskey: access_key
            },
            function(response) {
                if (response.status == "captured") {
                    updateStatus(ptoken,loan_id,gst,pay_amount,response.payment_id,response.status);
                    swal({
                            title: "",
                            text: "Your Payment Has Updated Successfully",
                            type:'success',
                            showCancelButton: false,
                            confirmButtonClass: "btn-primary",
                            confirmButtonText: "Go To Home",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            window.location.href = "/";
                        }
                    );
                } else if (response.status == "created") {
                    updateStatus(ptoken,loan_id,gst,pay_amount,response.payment_id,response.status);
                    swal({
                            title: "",
                            text: "Your Payment Has Updated Successfully",
                            type:'success',
                            showCancelButton: false,
                            confirmButtonClass: "btn-primary",
                            confirmButtonText: "Go To Home",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            window.location.href = "/";
                        }
                    );
                } else if (response.status == "pending") {
                    updateStatus(ptoken,loan_id,gst,pay_amount,response.payment_id,response.status);
                    swal({
                            title: "",
                            text: "Your Payment Will Be Updated Soon",
                            type:'success',
                            showCancelButton: false,
                            confirmButtonClass: "btn-primary",
                            confirmButtonText: "Home",
                            closeOnConfirm: true,
                            closeOnCancel: true
                        },
                        function (isConfirm) {
                            window.location.href = "/";
                        }
                    );
                } else if (response.status == "failed") {
                    updateStatus(ptoken,loan_id,gst,pay_amount,response.payment_id,response.status);
                } else if (response.status == "cancelled") {
                    updateStatus(ptoken,loan_id,gst,pay_amount,response.payment_id,response.status);
                    window.location.href = "/";
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

 function updateStatus(ptoken,loan_id,gst,pay_amount,payment_id=null,status)
 {
     $.ajax({
         url : 'https://www.empoweryouth.com/api/v3/payments/retry-payment',
         method : 'POST',
         data : {
             token:ptoken,
             gst:gst,
             pay_amount:pay_amount,
             loan_app_id:loan_id,
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
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');
$this->registerCssFile('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');








