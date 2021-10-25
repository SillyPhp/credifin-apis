<?php

use yii\helpers\Url;

?>
    <div class="portlet light portlet-fit nd-shadow">
        <div class="portlet-title">
            <div class="caption">
                <i class=" icon-social-twitter font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Loan Details'); ?>
                    <span data-toggle="tooltip" title="Here you will see your current loan application detail">
                        <i class="fa fa-info-circle"></i>
                    </span>
                </span>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="disFlex">
                        <div class="statsBox">
                            <p class="mb0">Loan Type</p>
                            <h3 class="mt10"><?= $loanApplication['loan_type'] ?></h3>
                        </div>
                        <div class="statsBox">
                            <p class="mb0">Loan Amount</p>
                            <?php
                            setlocale(LC_MONETARY, 'en_IN');
                            ?>
                            <h3 class="mt10"><span><i
                                            class="fa fa-inr"></i></span> <?= money_format('%!i', $loanApplication['amount']) ?>
                            </h3>
                        </div>
                        <div class="statsBox">
                            <p class="mb0">Lender</p>
                            <?php
                            $lander = $loanApplication['assignedLoanProviders'][0];
                            $base_path = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory;
                            $path = $base_path . Yii::$app->params->upload_directories->organizations->logo . $lander['lander_logo_location'] . '/' . $lander['lander_logo'];
                            if ($lander['lander_logo']) {
                                ?>
                                <div class="vendorImg"><img src="<?= $path ?>"></div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="statsBox">
                            <p class="mb0">Loan Profile</p>
                            <a href="/account/education-loans/candidate-dashboard/<?= $loanApplication['loan_app_enc_id'] ?>">Complete
                                Profile</a>
                        </div>
                        <!--                        <div class="statsBox">-->
                        <!--                            <p class="mb0">Loan Structure</p>-->
                        <!--                            <a href="education-loans/emi-details">View Structure</a>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $loanStatusList = [
                        0 => 'New Lead',
                        1 => 'Accepted',
                        2 => 'Pre Verification',
                        3 => 'Under Process',
                        4 => 'Sanctioned',
                        5 => 'Disbursed',
                    ];
                    ?>
                    <div class="status">
                        <p class="headingP mb0">Loan Status</p>
                        <ul class="addressLink">
                            <?php
                            foreach ($loanStatusList as $key => $value) {
                                if ($lander['status'] == 5) {
                                    $cls = "completedTab";
                                } else {
                                    switch (true) {
                                        case ($lander['status'] == $key) :
                                            $cls = "activeTab";
                                            break;
                                        case ($lander['status'] > $key) :
                                            $cls = "completedTab";
                                            break;
                                        default :
                                            $cls = "pendingTab";
                                    }
                                }
                                ?>
                                <li class="<?= $cls ?>" data-id="<?= $key ?>">
                                    <a href="javascript:;"><?= $value ?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php
                $notifications = $loanApplication['loanApplicationNotifications'];
                if ($notifications) {
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="notifications-list">
                                <?php
                                    foreach ($notifications as $notification){
                                        ?>
                                        <li>
                                            <div class="container-fluid ">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="new-message-box">
                                                            <div class="new-message-box-info">
                                                                <div class="info-tab tip-icon-info" title="error"><i></i></div>
                                                                <div class="tip-box-info">
                                                                    <p class="mb-20"><strong class="formattedDate"><?= $notification['created_on'] ?>:</strong>
                                                                        <?= $notification['message'] ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="col-md-12">
                    <?php
                    if($lander['status'] < 1){
                        ?>
                        <div class="new-message-box">
                            <div class="new-message-box-success">
                                <div class="info-tab tip-icon-success" title="success"><i></i></div>
                                <div class="tip-box-success">
                                    <h4>Thank you for applying with EmpowerYouth.com</h4>
                                    <h5>We have shared your case with multiple partners and we will update you soon once one of them accepts your case.</h5>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row mt20">
                <div class="col-md-3 col-sm-4 col-xs-6 text-sm-left borderRight">

                </div>
            </div>
        </div>
    </div>
<?php
$this->registerCss('
.mt20{
    margin-top: 20px;
}
.disFlex{
    display: flex;
    flex-wrap: wrap;
}
.vendorImg img{
    max-width: 100px;
    max-height: 50px;
}
.portlet.light.portlet-fit>.portlet-body{
    padding: 10px 0 20px;
}
.status{
    margin-top: 20px;
}
.statsBox{
    flex: 1;
    color: #333;
    margin-bottom: 10px;
}
.statsBox p,
.statsBox h3{
    margin: 5px 0 0 0;
}
.statsBox h3{
    margin-top: 3px;
}
.statsBox h3 span{
    font-size: 16px;
}
.statsBox p,
.statsBox h3 span,
.headingP{
    color: #00a0e3;
    font-weight: 600;
}
.statsBox a{
    margin-top: 8px;
    color: #fff;
    background: #00a0e3;
    padding: 8px 15px;
    display: inline-block;
    border-radius: 5px;
}
.statsBox a:hover{
    background: #ff7803;
    transition: .3s ease;
}
.addressLink {
    list-style: none;
    overflow: hidden;
    font: 16px;
    margin: 10px 0;
    padding: 0px;
}
          
.addressLink li {
    float: left;
}
          
.addressLink li a {
    background: #eee;
    color: #333;
    text-decoration: none;
    padding: 10px 15px 10px 30px;
    position: relative;
    float: left;
    pointer-events: none
}          
.addressLink li a:after,
.addressLink li.activeTab a:after{
   content: " ";
    border-top: 20px solid transparent;
    border-bottom: 20px solid transparent;
    border-left: 15px solid #eee;
    /* margin-top: -50px; */
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 100%;
    z-index: 2;
}          
.addressLink li a:before,
.addressLink li.activeTab a:before {
   content: " ";
    border-top: 20px solid transparent;
    border-bottom: 20px solid transparent;
    border-left: 19px solid #fff;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 100%;
    z-index: 1;
}

          
.addressLink li:first-child a {
    padding-left: 10px !important;
}
.addressLink li.completedTab a{
    background: #00a0e3; 
    color:#fff;
}
.addressLink li.activeTab a{
    background: #ff7803; 
    color:#fff;
    font-style: italic
}
.addressLink li.activeTab a:after{
        border-left-color: #ff7803;
}

.addressLink li.completedTab a:after{
    border-left-color: #00a0e3;
}

.addressLink li.activeTab a:before,
.addressLink li.completedTab a:before{
    border-left-color: #fff;
}            
.addressLink li:last-child a {
    background: #eee !important;
    color: black;
    padding-right: 25px;
}          
.addressLink li:last-child a:after {
    border: 0px;
}
.addressLink li:last-child a:before {
    border: 0px;
}
          
.addressLink li a:hover {
    background: #99ff99;
}
          
.addressLink li a:hover:after {
    border-left-color: #99ff99 !important;
}
@media screen and (max-width: 1150px){
    .addressLink li a {
        border-left: 2px solid #fff;
        padding: 5px 15px 5px 15px;
    }
    .addressLink li a:after,
    .addressLink li a:before,
    .addressLink li.activeTab a:after,
    .addressLink li.activeTab a:before {
        border: none;
    }
}
.new-message-box {
    margin: 15px 0;
    padding-left: 20px;
    margin-bottom: 25px!important;
}

.new-message-box p{
    font-size: 1.15em;
    font-weight: 500;
}

.info-tab {
    width: 40px;
    height: 40px;
    display: inline-block;
    position: relative;
    top: 8px;
}

.info-tab {
    float: left;
    margin-left: -23px;
}

.info-tab i::before {
    width: 24px;
    height: 24px;
    box-shadow: inset 12px 0 13px rgba(0,0,0,0.5);
}

.info-tab i::after {
    width: 0;
    height: 0;
    border: 12px solid transparent;
    border-bottom-color: #fff;
    border-left-color: #fff;
    bottom: -18px;
}

.info-tab i::before, .info-tab i::after {
    content: "";
    display: inline-block;
    position: absolute;
    left: 0;
    bottom: -17px;
    transform: rotateX(60deg);
}

.note-box, .warning-box, .tip-box-success, .tip-box-danger, .tip-box-warning, .tip-box-info, .tip-box-alert {
    padding: 12px 8px 10px 26px;
}


.new-message-box-info {
    background: #eeeeee;
    padding: 3px;
    margin: 10px 0;
}

.tip-box-info {
    color: #01579B;
//    background: #B3E5FC;
}

.tip-icon-info {
    background: #03A9F4;
}

.tip-icon-info::before {
    font-size: 19px;
    content: "\f0a2";
    top: 7px;
    left: 10px;
    font-family: FontAwesome;
    position: absolute;
    color: white
}

.tip-icon-info i::before {
    background: #03A9F4;
}

.new-message-box-alert {
    background: #FF6F00;
    padding: 3px;
    margin: 10px 0;
}

.notifications-list{
    list-style: none;
    padding-left: 0;
}

.new-message-box-success {
    background: #eeeeee;
    padding: 3px;
    margin: 10px 0;
}

.tip-icon-success {
    background: #8BC34A;
}

.tip-box-success {
    color: #33691E;
    background: #DCEDC8;
}

.tip-icon-success::before {
    font-size: 21px;
    content: "\f00c";
    top: 5px;
    left: 9px;
    font-family: FontAwesome;
    position: absolute;
    color: white;
}

.tip-box-success h4, .tip-box-success h5{
    font-weight: 600;
}

.tip-icon-success i::before {
    background: #8BC34A;
}
.formattedDate{
    font-size: 13px;
    color: #ff7803;
}
');
$script = <<<JS
var months = ["January", "February", "March", "April", "May", "June", "July", "August", "Sep", "Oct", "November", "December"];
$('.formattedDate').each(function(){
    var d = new Date($(this).text());
    $(this).html(d.getDate() + " " + months[d.getMonth()] + ", " + d.getFullYear()+ ' : ');
});
JS;
$this->registerJs($script);
