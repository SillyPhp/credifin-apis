<div id="pre_loader">
    <h3 id="text">Please Don't Refresh The Page, Processing Your Payment...</h3>
</div>
<?php
Yii::$app->view->registerJs('var status = "' . $get['razorpay_invoice_status'] . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var payment_id = "' . $get['razorpay_payment_id'] . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var signature = "' . $get['razorpay_signature'] . '"', \yii\web\View::POS_HEAD);
Yii::$app->view->registerJs('var invoice_id = "' . $get['razorpay_invoice_receipt'] . '"', \yii\web\View::POS_HEAD);
$this->registerCss("
#pre_loader{
display:none,
height: 100vh;
position: relative;
width: 100%;
}
#text{
position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
button.confirm{
display: inline-block;
    padding: 6px;
    border-radius: 6px;
    background: #5cb85b;
    background: transparent;
}
");

$script = <<< JS
function paymentAccept(status,payment_id,signature,invoice_id){
 $.ajax({
'url':'/api/v3/payments/institute-update-transections',
'method':'POST',
'data':{
    'status':status,
    'payment_id':payment_id,
    'signature':signature,
    'invoice_id':invoice_id,
},
'beforeSend':function() {
  $('#pre_loader').show();
},
'success':function(res) {
    $('#pre_loader').hide();
    if (res.response.status==200){
             swal({
                        title: "",
                        text: "Your Application Fee Transection Is Saved Successfully",
                        type:'success',
                        showCancelButton: false,  
                        confirmButtonClass: "btn-primary",
                        confirmButtonText: "Go To Home",
                        closeOnConfirm: true, 
                        closeOnCancel: true
                         },
                            function (isConfirm) { 
                            if (isConfirm)
                             window.location.href = "/";
                         }
                        );
    }else {
        swal({
      title:res.response.status,
      text: res.response.message,
      });
    }
    
}
});   
}
paymentAccept(status,payment_id,signature,invoice_id);
JS;
$this->registerJs($script);
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
?>
