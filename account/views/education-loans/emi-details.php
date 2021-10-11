<?php
$payable_interest = ($data['loan_amount'] / 100 * $data['rate_of_interest']);
$total_payment = (int)$payable_interest + (int)$data['loan_amount'] + (int)$data['processing_fee'];
$emi_structures = $data['loanEmiStructures'];
?>
    <section>
        <div class="container">
            <div class="row mt20">
                <div class="col-md-12">
                    <div class="portlet light nd-shadow">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-microphone font-dark hide"></i>
                                <span class="caption-subject bold font-dark uppercase">
                                 EMI Details
                            </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
<!--                                    <p class="loanName">School Loan For Tarry</p>-->
                                    <p class="loanName"><?= $data['loanAppEnc']['loan_type'] . ' for ' . $data['loanAppEnc']['applicant_name'] ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-sm-4 text-sm-left borderRight">
                                    <div class="statsBox">
                                        <p class="mb0">Total Payment</p>
                                        <h3 class="mt10"><span><i class="fa fa-inr"></i></span> <?= money_format('%!i', $total_payment) ?></h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6 text-sm-left borderRight">
                                    <div class="statsBox">
                                        <p class="mb0">Interest Payable</p>
                                        <h3 class="mt10"><span><i class="fa fa-inr"></i></span> <?= money_format('%!i', $payable_interest) ?> <span><?= $data['rate_of_interest'] ?>%</span></h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6 text-sm-left borderRight">
                                    <div class="statsBox">
                                        <p class="mb0">Principle Amount</p>
                                        <h3 class="mt10"><span><i class="fa fa-inr"></i></span> <?= money_format('%!i', $data['loan_amount']); ?></h3>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-6 text-sm-left borderRight">
                                    <div class="statsBox">
                                        <p class="mb0">Processing Fee</p>
                                        <h3 class="mt10"><span><i class="fa fa-inr"></i></span> <?= money_format('%!i', $data['processing_fee']); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <?php
                                if(count($emi_structures) >= 1){
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="scroll-table">
                                                <table class="emiTable">
                                                    <thead>
                                                    <tr>
                                                        <th class="w30">Installment Date</th>
                                                        <th class="w30">Installment Amount</th>
                                                        <th class="w30">Loan Amount</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $balanceAmount = (int)$total_payment;
                                                        foreach ($emi_structures as $emi){
                                                            $balanceAmount = $balanceAmount - (int)$emi['amount'];
                                                            ?>
                                                            <tr>
                                                                <td><?= date('d M Y', strtotime($emi['due_date'])) ?></td>
                                                                <td><i class="fa fa-inr"></i> <?= money_format('%!i', $emi['amount']) ?></td>
                                                                <td><i class="fa fa-inr"></i> <?= money_format('%!i', $balanceAmount) ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->registerCSS('
.dashboard-stat {
    display: block;
    margin-bottom: 25px;
    overflow: hidden;
    border-radius: 2px;
}
.heading-style {
    font-family: lobster;
    font-size: 28pt;
    text-align: left;
    margin: 15px 5px;
}
.enachBtn{
    background: linear-gradient(213.55deg,#00a0e3 0%,#048dc7 100%);
    border: none;
    padding: 10px 15px;
    color: #fff;
    border-radius: 5px;
    margin-left: 8px;
}
.overdueBtn{
    background: linear-gradient(213.55deg,#CA0B00 0%,#cc1e14 100%);

}
.borderRight{
    border-right: 1px solid #eee;
}
.borderRight:last-child{
    border-right: none;
    margin-bottom: 15px;
}
.mb20{
    margin-bottom: 20px;
}
.mt10{
    margin-top: 10px;
}
.mt20{
    margin-top: 20px;
}
.scroll-table{
    width: 100%;
    overflow-x: auto;
}
.statsBox{
    width: 100%;
    height: 60px;
    display: flex;
//    align-items: center;
    justify-content: center;
    flex-direction: column;
    color: #333;
}
.statsBox p,
.statsBox h3,
.reStats p, 
.reStats h3 {
    margin: 5px 0 0 0;
}
.statsBox h3{
    margin-top: 3px;
}
.statsBox h3 span,
.reStats h3 span, 
.repayStats h3 span{
    font-size: 16px;
}
.statsBox p,
.reStats p, 
.reStats h3 span, 
.statsBox h3 span{
    color: #00a0e3;
    font-weight: 600;
}
.repayStats h3 span,
.repayStats p,
.colorRed{
    color: #CA0B00
}


.repayStats{
    margin-bottom: 20px;
}
.repayStats h3{
    margin: 0px;
}
.repayStats p{
    margin-bottom: 5px;
    margin-top: 0px; 
    font-weight: 600;
}
.emiTable { 
    width: 100%; 
    border-collapse: collapse; 
    margin-bottom: 0px !important;
    margin-top: 5px;
    color: #333;
}
.w30{
    width: 20%;
}
.w16{
    width: 16%;
}
.loanName{
    font-weight: 600;
    font-size: 18px;
    color: #333;
    text-transform: capitalize;
}
/* Zebra striping */
tr{
    padding: 5px 0; 
}
th { 
    background: #00a0e3; 
    color: #fff; 
    font-weight: 500;
    letter-spacing: .5px; 
}
td, th { 
    padding: 10px 6px; 
    text-align: center;
    border-bottom: 1px solid #eee;
    font-family: roboto;
    letter-spacing: .5px;
    font-size: 13px;
}
tr:nth-child(odd){
    background: #f9f9f9; 
}
.paidBg td{
    border-bottom: 1px solid rgba(255,255,255,.3) ;
}
.paidBg{
    background: linear-gradient(213.55deg,#00a0e3 0%,#048dc7 100%) !important; 
    color: #fff;
}
.overdue{
    color: #CA0B00 !important;
}
td:first-child, th:first-child{
    border-left:none;
}
@media only screen and (max-width: 767px) {
     .statsBox{
        align-items: flex-start;
    }
    .borderRight:first-child{
        border:none;
    }
}
@media only screen and (max-width: 500px){
    .page-content{
        padding: 30px 0 !important;
    }
    .statsBox p, .reStats p{
        font-size: 12px;
    }
    .statsBox h3, .reStats h3{
        font-size: 18px;
    }
    .text-sm-left{
        text-align: left !important
    }
   .emiTable{
        width: 500px;
   }
   .w30{
        width: 120px;
   }
    td, th { 
        padding: 5px 6px; 
    }
}
');
