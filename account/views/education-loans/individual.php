<?php
use yii\helpers\Url;
?>
<section>
    <div class="container">
        <div class="row mt20">
            <div class="col-md-7">
                <div class="portlet light nd-shadow">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-microphone font-dark hide"></i>
                            <span class="caption-subject bold font-dark uppercase">
                                Loan Details
                            </span>
                        </div>
                        <div class="actions">
                            <a href="javascript:;" title="" class="loanAgreement"><i class="fa fa-download"></i> Loan Agreement</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="loanName">School Loan For Tarry</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 text-center text-sm-left borderRight">
                                <div class="statsBox">
                                    <p class="mb0">Total Payment</p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 77,000</h3>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6 text-center text-sm-left borderRight">
                                <div class="statsBox">
                                    <p class="mb0">Interest Payable</p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 10,780 <span>14%</span></h3>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6 text-center text-sm-left borderRight">
                                <div class="statsBox">
                                    <p class="mb0">Principle Amount</p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 66,220</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="scroll-table">
                                    <table class="emiTable">
                                    <thead>
                                    <tr>
                                        <th class="w30">Installment Date</th>
                                        <th class="w30">Installment Amount</th>
                                        <th class="w30">Loan Amount</th>
                                        <th class="w10">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="overdue">
                                        <td>01 Mar 2021</td>
                                        <td><i class="fa fa-inr"></i> 9,000</td>
                                        <td><i class="fa fa-inr"></i> 59,000</td>
                                        <td>Overdue</td>
                                    </tr>
                                    <tr class="overdue">
                                        <td>01 Apr 2021</td>
                                        <td><i class="fa fa-inr"></i> 9,000</td>
                                        <td><i class="fa fa-inr"></i> 50,000</td>
                                        <td>Overdue</td>
                                    </tr>
                                    <tr>
                                        <td>01 May 2021</td>
                                        <td><i class="fa fa-inr"></i> 9,000</td>
                                        <td><i class="fa fa-inr"></i> 41,000</td>
                                        <td>Due</td>
                                    </tr>
                                    <tr>
                                        <td>01 Jun 2021</td>
                                        <td><i class="fa fa-inr"></i> 9,000</td>
                                        <td><i class="fa fa-inr"></i> 32,000</td>
                                        <td>Due</td>
                                    </tr>
                                    <tr>
                                        <td>01 Jul 2021</td>
                                        <td><i class="fa fa-inr"></i> 9,000</td>
                                        <td><i class="fa fa-inr"></i> 23,000</td>
                                        <td>Due</td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet light nd-shadow">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-microphone font-dark hide"></i>
                            <span class="caption-subject bold font-dark uppercase">
                                Paid Installments
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="emiTable">
                                    <thead>
                                    <tr>
                                        <th class="w30">Installment Date</th>
                                        <th class="w30">Installment Amount</th>
                                        <th class="w30">Mode</th>
                                        <th class="w10">Default</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>01 Jan 2021</td>
                                        <td><i class="fa fa-inr"></i> 9,000</td>
                                        <td>ENACH</td>
                                        <td>No</td>
                                    </tr>
                                    <tr>
                                        <td>01 Feb 2021</td>
                                        <td><i class="fa fa-inr"></i> 9,000</td>
                                        <td>ENACH</td>
                                        <td>Yes 7 Days</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet light nd-shadow">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-microphone font-dark hide"></i>
                            <span class="caption-subject bold font-dark uppercase">
                                Remaining Not Yet
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 text-center text-sm-left borderRight">
                                <div class="statsBox align-start">
                                    <p class="mb0">Surplus</p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 77,000</h3>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6 text-center text-sm-left borderRight">
                                <div class="statsBox align-start">
                                    <p class="mb0">Installments</p>
                                    <h3 class="mt10"> <span class="colorBlue">2</span>/7</h3>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6 text-center text-sm-left borderRight">
                                <div class="statsBox align-start">
                                    <p class="mb0">Installments Missed</p>
                                    <h3 class="mt10"> <span class="colorRed">2</span>/7</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="portlet light nd-shadow">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-microphone font-dark hide"></i>
                            <span class="caption-subject bold font-dark uppercase">
                                Repayment
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="reStats mb20">
                                    <p class="mb0">Current Amount Due: </p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 99,000</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="reStats mb20">
                                    <p class="mb0">Upcoming Repayment Date</p>
                                    <h3 class="mt10"><span><i class="fa fa-calendar"></i></span>  30 MAR 2021</h3>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="reStats mb20">
                                    <p class="mb0">Upcoming Repayment Amount</p>
                                    <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 9,000</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row mt20">
                            <div class="col-md-12">
                                <p>Mode Of Payment ENACH</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet light nd-shadow">
                    <div class="portlet-title tabbable-line mt10">
                        <div class="caption">
                                <span class="caption-subject bold uppercase colorRed">
                                   Overdue Installments
                                </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="repayStats">
                                <p class="mb0">Overdue EMI's</p>
                                <h3 class="mt10"><span><i class="fa fa-calendar"></i></span> Mar, Apr</h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="repayStats">
                                <p class="mb0">Overdue Amount</p>
                                <h3 class="mt10"><span><i class="fa fa-inr"></i></span> 18,000</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt10">
                        <div class="col-md-12">
                            <p><button type="button" class="enachBtn overdueBtn">Repay Now</button></p>
                        </div>
                    </div>
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
.loanAgreement{
    background: #00a0e3;
    padding: 8px 15px;
    color: #fff;
    transition: .3s ease;
}
.loanAgreement i{
    margin-right: 3px;
}
.loanAgreement:hover{
    box-shadow: 2px 3px 5px rgba(0,0,0,.3);
    color: #fff;
    transition: .3s ease;
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
    align-items: center;
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
    width: 28%;
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
.align-start{
    align-items: flex-start;
}
.colorBlue{
    font-size: 24px !important;
}
.colorRed{
    font-size: 24px !important;
    color: #CA0B00 !important;
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
