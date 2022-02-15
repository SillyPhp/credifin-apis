<?php

use yii\helpers\Url;

?>
    <div class="portlet light portlet-fit nd-shadow">
        <div class="portlet-title" style="position:relative;">
            <div class="caption">
                <i class=" icon-social-twitter font-dark hide"></i>
                <span class="caption-subject font-dark bold uppercase"><?= Yii::t('account', 'Loan Details'); ?>
                    <span data-toggle="tooltip" title="Here you will see your current loan application detail">
                        <i class="fa fa-info-circle"></i>
                    </span>
                </span>
            </div>
            <?php if($loanApplication['status'] == 10) {?>
                <div class="rejected-loan">Application Rejected</div>
            <?php } ?>
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
                            <div class="vendorImg"><img src="<?= $loanApplication['organization_logo'] ?>"></div>
                            <div class="vendorname"><?= $loanApplication['name'] ?></div>
                        </div>
                        <?php if($loanApplication['status'] != 5 && $loanApplication['status'] != 10){ ?>
                        <div class="statsBox">
                            <p class="mb0"><Loan></Loan> Profile</p>
                            <a href="/account/education-loans/candidate-dashboard/<?= $loanApplication['loan_application_enc_id'] ?>" target="_blank">Complete
                                Profile</a>
                        </div>
                        <?php }?>
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
                                if ($loanApplication['status'] == 5) {
                                    $cls = "completedTab";
                                } else {
                                    switch (true) {
                                        case ($loanApplication['status'] == $key) :
                                            $cls = "activeTab";
                                            break;
                                        case ($loanApplication['status'] > $key) :
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
                <div class="col-md-12">
                    <?php
                    if($loanApplication['status'] < 1){
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
.rejected-loan {
    position: absolute;
    right: 0;
    top: 0;
    background-color: red;
    color: #fff;
    padding: 6px 14px;
    font-family: roboto;
    font-weight: 700;
    font-size: 14px;
    letter-spacing: .5px;
}
.mt20{
    margin-top: 20px;
}
.disFlex{
    display: flex;
    flex-wrap: wrap;
}
.vendorImg img {
    width: 50px;
    height: 50px;
    object-fit: contain;
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
    width:145px;
    text-align:center;
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

.note-box, .warning-box, .tip-box-success, .tip-box-danger, .tip-box-warning, .tip-box-alert {
    padding: 12px 8px 10px 26px;
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

.new-message-box-success {
    background: #eeeeee;
    padding: 3px;
    margin: 10px 0 0 20px;
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
.portlet.light.portlet-fit>.portlet-body{
    padding:10px 20px 20px !important;
}
.vendorname {
    margin: 6px 0 0 0;
    font-family: "Roboto";
    font-weight: 500;
}
');
?>
