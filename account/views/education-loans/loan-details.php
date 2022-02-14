<?php

use yii\helpers\Url;

Yii::$app->view->registerJs('var access_key = "' . Yii::$app->params->razorPay->prod->apiKey . '"', \yii\web\View::POS_HEAD);
?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<section>
    <div class="">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12" id="side-bar-main" class="remove-height">
                <div class="navigate-loan nd-shadow">
                    <ul class="nav nav-pills set-width">
                        <li class="active height-main"><a href="#homedata" data-toggle="tab"><i
                                        class="fa fa-home"></i> Home</a></li>
                        <!--                            <li class="height-main"><a href="#upcomingdata" data-toggle="tab"><i class="fa fa-user"></i>-->
                        <!--                                    Upcoming Installments</a></li>-->
                        <?php if (count($applications) > 1) { ?>
                            <li class="dropdown height-main">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"><i
                                            class="fa fa-money"></i> My Loans<span class="caret"></span></a>
                                <ul class="dropdown-menu design-list">
                                    <?php foreach ($loan_apps as $app) { ?>
                                        <li>
                                            <a href="#<?= $app['loan_app_enc_id'] ?>"
                                               data-toggle="tab"><?= $app['applicant_name'] ?> -
                                                <Span>₹ <?= $app['amount'] ?></Span></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <li class="height-main"><a href="#notifications" data-toggle="tab"><i
                                        class="fa fa-bell"></i> Notifications</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12" id="integration-main">

                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="homedata">

                        <?php
                        if ($applications) {
                            $application = $applications[0];

                            if ($application['educationLoanPayments'] && $application['assignedLoanProviders'][0]['status'] != 5) {
                                echo $this->render('/widgets/education-loan/complete-profile', [
                                    'loan_app_id' => $application['loan_app_enc_id'],
                                ]);
                            }

                            if (!$application['educationLoanPayments']) {
                                echo $this->render('/widgets/login-fee-due', [
                                    'loginFee' => $application,
                                ]);
                            } elseif ($application['educationLoanPayments'] && empty($application['assignedLoanProviders'])) {
                                echo $this->render('/widgets/job-application-lenders');
                            } elseif (!empty($application['assignedLoanProviders'])) {
                                echo $this->render('/widgets/loan-approved', [
                                    'loan_approve' => $application['assignedLoanProviders'],
                                ]);
                            }
                        }
                        ?>

                        <div class="loan-apps-by-lender"></div>

                        <?php if ($application['assignedLoanProviders'][0]['status'] == 5) { ?>
                            <?= $this->render('/widgets/education-loan/emi-details', [
                                'data' => $application,
                            ]); ?>
                        <?php } ?>

                        <?php
                        if ($loan && empty($loan['loanApplications'])) {
                            ?>
                            <div class="row">
                                <?= $this->render('/widgets/loan-applied', [
                                    'loan' => $loan
                                ]) ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>

                    <!--                        <div class="tab-pane" id="upcomingdata">-->
                    <!--                            -->
                    <!--                        </div>-->


                    <?php foreach ($applications as $application) { ?>
                        <div class="tab-pane" id="<?= $application['loan_app_enc_id'] ?>">
                            <?php
                            if ($application['educationLoanPayments'] && $application['assignedLoanProviders'][0]['status'] != 5) {
                                echo $this->render('/widgets/education-loan/complete-profile', [
                                    'loan_app_id' => $application['loan_app_enc_id'],
                                ]);
                            }
                            if (!$application['educationLoanPayments']) {
                                echo $this->render('/widgets/login-fee-due', [
                                    'loginFee' => $application,
                                ]);
                            } elseif ($application['educationLoanPayments'] && empty($application['assignedLoanProviders'])) {
                                echo $this->render('/widgets/job-application-lenders');
                            } elseif (!empty($application['assignedLoanProviders'])) {
                                echo $this->render('/widgets/loan-approved', [
                                    'loan_approve' => $application['assignedLoanProviders'],
                                ]);
                            }
                            ?>

                            <div class="loan-apps-by-lender"></div>

                            <?php if ($application['assignedLoanProviders'][0]['status'] == 5) { ?>
                                <?= $this->render('/widgets/education-loan/emi-details', [
                                    'data' => $application,
                                ]); ?>
                            <?php } ?>

                            <?php
                            if ($loan && empty($loan['loanApplications'])) {
                                ?>
                                <div class="row">
                                    <?= $this->render('/widgets/loan-applied', [
                                        'loan' => $loan
                                    ]) ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    <?php } ?>

                    <div class="tab-pane" id="notifications">
                        <?php foreach ($applications as $application) {
                            if ($application['loanApplicationNotifications']) { ?>
                                <?= $this->render('/widgets/education-loan/loan-notification', [
                                    'notifications' => $application,
                                ]); ?>
                            <?php }
                        } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php
$this->RegisterCss('
.navigate-loan {
    padding: 20px 0;
    position:sticky;
    top:115px;
    margin-bottom:30px;
}
.design-list {
    max-height: 250px;
    overflow: hidden;
    overflow-y: scroll;
}
.design-list>li.active:hover>a, .design-list>li.active>a {
    background-color: #00a0e3;
    color: #fff;
    font-weight: 500;
}
.design-list li a {
    width: 290px;
    font-family: roboto !important;
}
.design-list li a:hover {
    background-color: #00a0e3;
    color: #fff;
}
.set-width li {
    width: 100%;
}
.set-width li a {
    font-size: 15px;
    text-transform:capitalize;
    color: #333;
    font-family: "Roboto";
    border-left:4px solid transparent;
}
.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
    color: #00a0e3;
    background-color: #fff;
    font-weight:500;
    border-left: 4px solid #00a0e3;
    transition:all .5s;
}
.nav>li>a:focus, .nav>li>a:hover{
    background-color:#fff;
    color:#00a0e3;
}
.nav-pills>li+li {
     margin-left: 0px;
}
.portlet.light.portlet-fit>.portlet-body {
    padding: 10px 20px 20px;
}
.tab-pane.active {
    animation: slide-down 1s ease-out;
}

@keyframes slide-down {
    0% { opacity: 0; transform: translateY(30%); }
    50% { opacity: 1; transform: translateY(0); }
}
@media screen and (max-width: 768px) {
.remove-height{
    height:auto !important;
}
}
');
$script = <<<JS
 $('.company-logo').on('click', function(e){
    e.preventDefault();
    var elem = $(this);
    $.ajax({
        method: "GET",
        url : '/account/education-loans/loan-provider-detail',
        data: {loan_provider_id: this.id},
        async: false,
        success: function(response) {
           elem.parentsUntil('.tab-pane').parent().children('.loan-apps-by-lender').html(response);
        }
    });
 });
 function initializePosSticky() {
     
if ($(window).width() > 768) {
  var mainHeight = $('#integration-main').height();
  $('#side-bar-main').css('height',mainHeight);
}
}
initializePosSticky();
$(document).on('click', '.height-main', function(){
   setTimeout(function(){
      initializePosSticky();
   },1000);
});

if($('.design-list').length){
 var ps = new PerfectScrollbar('.design-list');
 }
function _razoPay(ptoken,loan_id,education_loan_id,email,phone,name){
    var options = {
    "key": access_key, 
    "name": "Empower Youth",
    "description": "Application Login Fee",
    "image": "/assets/common/logos/logo.svg",
    "order_id": ptoken, 
    "handler": function (response){
        updateStatus(education_loan_id,loan_id,response.razorpay_payment_id,"captured",response.razorpay_signature);
    },
    "prefill": {
        "name": name,
        "email": email,
        "contact": phone,
    },
    "theme": {
        "color": "#ff7803"
    }
};
     var rzp1 = new Razorpay(options);
     rzp1.open();
     rzp1.on('payment.failed', function (response){
         updateStatus(education_loan_id,loan_id,null,"failed");
      swal({
      title:"Error",
      text: response.error.description,
      });
});
}  
function updateStatus(education_loan_id,loan_app_enc_id,payment_id=null,status,signature=null){
    $.ajax({
            url : '/api/v3/education-loan/update-widget-loan-application',
            method : 'POST', 
            data : {
              loan_payment_id:education_loan_id,
              loan_app_id:loan_app_enc_id,
              payment_id:payment_id, 
              status:status, 
              signature:signature,
            },
            success:function(e)
            {
                if (status=="captured"){
                    if (e.response.status=='200'){
                        swal({
                         title: "Success",
                         text: "Payment Is Submitted Successfully",
                         type:'success',
                         showCancelButton: false,  
                         confirmButtonClass: "btn-primary",
                         confirmButtonText: "Close",
                         closeOnConfirm: true, 
                         closeOnCancel: true
                          },
                             function (isConfirm) { 
                              location.reload(true);
                          }
                         );
                    } else {
                        swal({
                         title:"Payment Error",
                         text: 'Your Payment Status Will Be Update In 1-2 Business Day',
                      });
                    }
                }
                $('#subBtn').show();     
                $('#prevBtn').show();     
                $('#loadBtn').hide();
            }
    })
}
$('.pay-btn').click(function(e){
  let loan_id = $(this).attr("data-loan-id");
  let phone = $(this).attr("data-phone");
  let email = $(this).attr("data-email");
  let payment_token = $(this).attr("data-payment-token");
  let education_payment_id = $(this).attr("data-education-payment-id");
  let data_name = $(this).attr("data-name");
  _razoPay(payment_token,loan_id,education_payment_id,email,phone,data_name)
});
JS;
$this->registerJs($script);
$this->registerCssFile('@eyAssets/css/perfect-scrollbar.css');
$this->registerJsFile('@eyAssets/js/perfect-scrollbar.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.css');
$this->registerJsFile('@backendAssets/global/plugins/bootstrap-sweetalert/sweetalert.min.js');
?>

